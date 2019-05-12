<?php
/**
* This file is part of the flashcards package
 * (c) Matthias Lantsch
 *
 * Class file for the BoxesController
 *
 * @package flashcards
 * @license http://opensource.org/licenses/gpl-license.php  GNU Public License
 * @author  Matthias Lantsch <matthias.lantsch@bluewin.ch>
 */

namespace holonet\flashcards\controllers;

use RuntimeException;
use holonet\flashcards\models\BoxModel;
use holonet\flashcards\models\AssocModel;

/**
 * BoxesController exposing the box REST box to the application box
 *
 * @author  matthias.lantsch
 * @package holonet\flashcards\controllers
 */
class BoxesController extends FlashcardsControllerBase {

	/**
	 * GET /boxes
	 * Display an index listing
	 *
	 * @access public
	 * @return the yield from the controller method
	 */
	public function index() {
		yield "title" => "All Boxes";
		yield "listName" => "All Boxes";

		yield "backendRequest" => "";
		yield "user" => $this->user;
	}

	/**
	 * GET /boxes/new
	 * Dynamically load a form to create a new box entry
	 *
	 * @access public
	 * @return the yield from the controller method
	 */
	public function new() {
		//just return only the form template rendered
		$this->respondTo("html")->append("boxes".DIRECTORY_SEPARATOR."form");
	}

	/**
	 * POST /boxes
	 * method used to create a new box
	 *
	 * @access public
	 * @return the yield from the controller method
	 */
	public function create() {
		//new case
		$newBox = new BoxModel([
			"name" => strip_tags($this->request->request->get("name")),
			"desc" => strip_tags($this->request->request->get("desc")),
			"idUser" => $this->user->id
		]);

		if(!$newBox->save()) {
			throw new RuntimeException("Failed creating a new flashcard box valid?: ".var_export($newBox->valid(), true), 400);
		} else {
			yield "idBox" => $newBox->id;
		}

		$this->respondTo("json")->addCallback(
			function($data) {
				return ["error" => false, "idBox" => $data["idBox"]];
			}
		);
	}

	/**
	 * GET /boxes/[id:i]
	 * method used to show a box entry in detail
	 *
	 * @access public
	 * @param  integer $id The id of the box to be shown
	 * @return the yield from the controller method
	 */
	public function show(int $id) {
		if(($box = BoxModel::find($id)) === null) {
			$this->notFound("Box with the id #{$id}");
		}

		yield "box" => $box;
		yield "title" => "{$box->name}";
		yield "user" => $this->user;
	}

	/**
	 * GET /boxes/[id:i]/edit
	 * method used to show an edit mask to change a box entry
	 * Dynamically load a form to edit a box entry
	 *
	 * @access public
	 * @param  integer $id The id of the box to be edited
	 * @return the yield from the controller method
	 */
	public function edit(int $id) {
		if(($box = BoxModel::find($id)) === null) {
			$this->notFound("Box with the id #{$id}");
		}

		//check if the logged in user is the actual owner
		if($box->idUser != $this->user->id) {
			$this->notAllowed("User with the id {$this->user->id} tried to change the box #{$id}");
		}

		yield "box" => $box;
		//just return only the form template rendered
		$this->respondTo("html")->append("boxes".DIRECTORY_SEPARATOR."form");
	}

	/**
	 * PUT /boxes/[id:i]
	 * method used to submit a change to an existing box entry
	 *
	 * @access public
	 * @param  integer $id The id of the box to be edited
	 * @return the yield from the controller method
	 */
	public function update(int $id) {
		if(($box = BoxModel::find($id)) === null) {
			$this->notFound("Box with the id #{$id}");
		}

		//check if the logged in user is the actual owner
		if($box->idUser != $this->user->id) {
			$this->notAllowed("User with the id {$this->user->id} tried to change the box #{$id}");
		}

		$box->name = strip_tags($this->request->request->get("name"));
		$box->desc = strip_tags($this->request->request->get("desc"));
		if(!$box->save()) {
			throw new RuntimeException("Failed saving edit to flashcard box id: {$box->id} valid?: ".var_export($box->valid(), true), 400);
		} else {
			yield "idBox" => $box->id;
		}

		$this->respondTo("json")->addCallback(
			function($data) {
				return ["error" => false, "idBox" => $data["idBox"]];
			}
		);
	}

	/**
	 * DELETE /boxes/[id:i]
	 * method used to delete a box entry
	 *
	 * @access public
	 * @param  integer $id The id of the box to be edited
	 * @return the yield from the controller method
	 */
	public function delete(int $id) {
		if(($box = BoxModel::find($id)) === null) {
			$this->notFound("Box with the id #{$id}");
		}

		//check if the logged in user is the actual owner
		if($box->idUser != $this->user->id) {
			$this->notAllowed("User with the id {$this->user->id} tried to change the box #{$id}");
		}

		yield "error" => !$box->destroy();
		$this->respondTo("json")->addCallback(
			function($data) {
				return ["error" => $data["error"]];
			}
		);
	}

	/**
	 * json backend method used to reset a users progress on a certain flashcard box
	 * POST /boxes/[id:i]/reset
	 *
	 * @access public
	 * @param  integer $id The id of the box to be reset
	 * @return the yield from the controller method
	 */
	public function reset(int $id) {
		if(($box = BoxModel::find($id)) === null) {
			$this->notFound("Box with the id #{$id}");
		}

		$box->lastActivity();

		//delete all entries in the assoc table for that specific user
		$assocs = AssocModel::select(array(
			"card.idBox" => $box->id,
			"idUser" => $this->user->id
		));

		$success = true;

		foreach ($assocs as $assoc) {
			$success = $assoc->delete();
		}

		yield "error" => !$success;
		$this->respondTo("json")->addCallback(
			function($data) {
				return ["error" => $data["error"]];
			}
		);
	}

	/**
	 * json backend method used to get a list of boxes as specified by various GET parameters
	 * these can include:
	 *  - idUser => only show boxes of a certain user
	 *  - pager => used to paginate the display
	 * GET /boxes/api
	 *
	 * @access public
	 * @return the yield from the controller method
	 */
	public function boxApi() {
		//sort by activity by default
		$options = array(
			"ORDER" => "updatetime"
		);

		//user id filter
		if($this->request->query->has("idUser")) {
			$options["idUser"] = intval($this->request->query->get("idUser"));
		}

		//get the total number of results for this query
		$totalcount = BoxModel::count($options);
		$showlimit = $this->request->query->get("limit", 10);
		$totalnumberofpages = ceil($totalcount / $showlimit);

		//apply pagination
		$options["LIMIT"] = $showlimit;
		$options["OFFSET"] = ($this->request->query->get("pager", 1) - 1) * $showlimit;

		$pagedresult = BoxModel::select($options);

		//for the displaying result 1 to 10 out of 115 text
		yield "showingresult" => $options["OFFSET"] + 1;
		yield "showingtoresult" => $options["OFFSET"] + count($pagedresult);

		yield "boxes" => $pagedresult;
		yield "user" => $this->user;
		yield "pager" => $this->request->query->get("pager", 1);
		yield "totalresults" => $totalcount;
		yield "totalpages" => $totalnumberofpages;

		$this->respondTo("html")->append("boxes".DIRECTORY_SEPARATOR."table");
	}

	/**
	 * method for the view action
	 * will display a carousel with the cards in order to view them all
	 * GET /boxes/[id:i]/view
	 *
	 * @access public
	 * @param  integer $id The id of the box to view
	 * @return the yield from the controller method
	 */
	public function view(int $id) {
		if(($box = BoxModel::find($id)) === null) {
			$this->notFound("Box with the id #{$id}");
		}

		$box->lastActivity();

		yield "title" => "View {$box->name}";
		yield "box" => $box;
		yield "user" => $this->user;
	}

	/**
	 * method for the study action
	 * will display a textfield
	 * GET /boxes/[id:i]/study
	 *
	 * @access public
	 * @param  integer $id The id of the box to view
	 * @return the yield from the controller method
	 */
	public function study(int $id) {
		if(($box = BoxModel::find($id)) === null) {
			$this->notFound("Box with the id #{$id}");
		}

		$box->lastActivity();

		yield "title" => "Study {$box->name}";
		yield "box" => $box;
		yield "user" => $this->user;

		//do not include cards from tier 5 in the result
		$cardsArray = $box->getStudySetFor($this->user->id);
		yield "cardcount" => count($cardsArray);
		yield "cardsjson" => htmlspecialchars(json_encode($cardsArray));
	}

	/**
	 * method for the choice action
	 * will display a multiple choice training exercise
	 * GET /boxes/[id:i]/choice
	 *
	 * @access public
	 * @param  integer $id The id of the box to view
	 * @return the yield from the controller method
	 */
	public function choice(int $id) {
		if(($box = BoxModel::find($id)) === null) {
			$this->notFound("Box with the id #{$id}");
		}

		$box->lastActivity();

		yield "title" => "{$box->name} - Multiple choice";
		yield "box" => $box;
		yield "user" => $this->user;

		//do not include cards from tier 5 in the result
		$cardsArray = $box->getStudySetFor($this->user->id);
		yield "cardcount" => count($cardsArray);
		yield "cardsjson" => htmlspecialchars(json_encode($cardsArray));
	}

}
