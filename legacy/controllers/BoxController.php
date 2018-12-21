<?php
/**
 * This file is part of the flashcards package
 * (c) Matthias Lantsch
 *
 * class file for the BoxController controller class
 */

namespace HIS5\flashcards\controllers;

use HIS5\holoFW\core\baseclasses as base;
use HIS5\holoFW\core\error as error;
use HIS5\flashcards\models as models;

/**
 * The BoxController class
 *
 * @author  Matthias Lantsch
 * @version {VERSION}
 * @package HIS5\flashcards\controllers
 */
class BoxController extends base\ControllerBase {

	/**
	 * method for the index action
	 * displays a list of all boxes loaded via a seperate request
	 * /box GET
	 *
	 * @access public
	 */
	public function index() {
		$this->accessControl();

		yield "title" => "All Boxes";
		yield "listName" => "All Boxes";

		yield "backendRequest" => "";
		yield "user" => models\UserModel::find($_SESSION["usr"]["db_id"]);

		//overwrite the controller facade method to use the common template
		$this->format("html")->append("user")->append("box".DIRECTORY_SEPARATOR."listing");
	}

	/**
	 * method for the save action
	 * /box/idBox:?int POST
	 * JSON
	 *
	 * @access public
	 * @param  array params | array with parameters from the routing process
	 */
	public function save($params = []) {
		$this->accessControl();
		if(isset($params["idBox"])) {
			//edit case
			$box = models\BoxModel::find($params["idBox"]);
			if(!$box->exists()) {
				throw new error\NotFoundException("Could not find box #{$params['idBox']}");
			}

			//check if the logged in user is the actual owner
			if($box->idUser != $_SESSION["usr"]["db_id"]) {
				throw new error\NotAllowedException("User with the id {$_SESSION["usr"]["db_id"]} tried to change the box #{$params['idBox']}");
			}

			$box->name = strip_tags($_POST["name"]);
			$box->desc = strip_tags($_POST["desc"]);
			$box->updateTimestamp();
			if(!$box->save()) {
				throw new error\HFWException("Failed saving edit to flashcard box id: {$box->id} valid?: ".var_export($box->valid(), true));
			} else {
				yield "idBox" => $box->id;
			}
		} else {
			//new case
			$newBox = new models\BoxModel([
				"name" => strip_tags($_POST["name"]),
				"desc" => strip_tags($_POST["desc"]),
				"idUser" => $_SESSION["usr"]["db_id"],
				"created" =>  date("Y-m-d H:i:s")
			]);

			if(!$newBox->save()) {
				throw new error\HFWException("Failed creating a new flashcard box valid?: ".var_export($newBox->valid(), true));
			} else {
				yield "idBox" => $newBox->id;
			}
		}

		$this->format("json")->addCallback(
			function($data) {
				return ["error" => false, "idBox" => $data["idBox"]];
			}
		);
	}

	/**
	 * method for the show action
	 * will display an overview of the box and allow the owner to change the name directly as well as the description
	 * /box/idBox:int GET
	 *
	 * @access public
	 * @param  array params | array with parameters from the routing process
	 */
	public function show($params = []) {
		$this->accessControl();
		$box = models\BoxModel::find($params["idBox"]);
		if(!$box->exists()) {
			throw new error\NotFoundException("Could not find box #{$params['idBox']}");
		}

		yield "box" => $box;
		yield "title" => "{$box->name}";
		yield "user" => models\UserModel::find($_SESSION["usr"]["db_id"]);

		//append the user controller template first (with the user navigation sidebar)
		$this->format("html")->append("user")->append("box".DIRECTORY_SEPARATOR."overview");
	}

	/**
	 * method for the view action
	 * will display a carousel with the cards in order to view them all
	 * /box/idBox:int/view GET
	 *
	 * @access public
	 * @param  array params | array with parameters from the routing process
	 */
	public function view($params = []) {
		$this->accessControl();
		$box = models\BoxModel::find($params["idBox"]);
		if(!$box->exists()) {
			throw new error\NotFoundException("Could not find box #{$params['idBox']}");
		}

		$box->updateTimestamp();

		yield "title" => "View {$box->name}";
		yield "box" => $box;
		yield "user" => models\UserModel::find($_SESSION["usr"]["db_id"]);
		yield "cards" => array_values($box->card->execute());

		//append the user controller template first (with the user navigation sidebar)
		$this->format("html")->append("user")->append("box".DIRECTORY_SEPARATOR."view");
	}

	/**
	 * method for the study action
	 * will display a textfield
	 * /box/idBox:int/study GET
	 *
	 * @access public
	 * @param  array params | array with parameters from the routing process
	 */
	public function study($params = []) {
		$this->accessControl();
		$box = models\BoxModel::find($params["idBox"]);
		if(!$box->exists()) {
			throw new error\NotFoundException("Could not find box #{$params['idBox']}");
		}

		$box->updateTimestamp();

		yield "title" => "Study {$box->name}";
		yield "box" => $box;
		yield "user" => models\UserModel::find($_SESSION["usr"]["db_id"]);

		//do not include cards from tier 5 in the result
		$cardsArray = $box->getStudySetFor($_SESSION["usr"]["db_id"]);
		yield "cardcount" => count($cardsArray);
		yield "cardsjson" => htmlspecialchars(json_encode($cardsArray));

		$this->format("html")->append("user")->append("box".DIRECTORY_SEPARATOR."study");
	}

	/**
	 * json backend method used to get a list of boxes as specified by various GET parameters
	 * these can include:
	 *  - idUser => only show boxes of a certain user
	 *  - pager => used to paginate the display
	 * /box/list GET
	 *
	 * @access public
	 */
	public function getList() {
		$this->accessControl();

		//apply pagination
		$result = models\BoxModel::all()->limit(10)->offset(($_GET["pager"] - 1) * 10);

		//user user id filter
		if(isset($_GET["idUser"])) {
			$result->where("idUser = ?", $_GET["idUser"]);
		}

		yield "boxes" => $result;
		yield "user" => models\UserModel::find($_SESSION["usr"]["db_id"]);

		$this->format("html")->append("box".DIRECTORY_SEPARATOR."table")->raw = true;
	}

	/**
	 * json backend method used to reset a users progress on a certain flashcard box
	 * /box/idBox:int/reset POST
	 *
	 * @access public
	 * @param  array params | array with parameters from the routing process
	 */
	public function reset($params = []) {
		$this->accessControl();

		$box = models\BoxModel::find($params["idBox"]);
		if(!$box->exists()) {
			throw new error\NotFoundException("Could not find box #{$params['idBox']}");
		}

		$box->updateTimestamp();

		$sucess = true;
		//delete all entries in the assoc table for that specific user
		foreach ($box->card as $card) {
			//check if the user has an assoc entry with this card
			if(($assoc = $card->progressOf($_SESSION["usr"]["db_id"]))) {
				$sucess = $assoc->delete();
			}
		}

		yield "error" => !$sucess;
		$this->format("json")->addCallback(
			function($data) {
				return ["error" => $data["error"]];
			}
		);
	}

	/**
	 * json backend method used to dynamically load a form to either edit a box or create a new one
	 * /box/form/idBox?:int GET
	 *
	 * @access public
	 * @param  array params | array with parameters from the routing process
	 */
	public function form($params = []) {
		$this->accessControl();
		if(isset($params["idBox"])) {
			//edit case
			$box = models\BoxModel::find($params["idBox"]);
			if(!$box->exists()) {
				throw new error\NotFoundException("Could not find box #{$params['idBox']}");
			}

			//check if the logged in user is the actual owner
			if($box->idUser != $_SESSION["usr"]["db_id"]) {
				throw new error\NotAllowedException("User with the id {$_SESSION["usr"]["db_id"]} tried to change the box #{$params['idBox']}");
			}
			yield "box" => $box;
		}
		$this->format("html")->append("box".DIRECTORY_SEPARATOR."form")->raw = true;
	}

	/**
	 * json backend method used to completely remove a flashcard box with it's associated records
	 * /box/idBox:int/delete POST
	 *
	 * @access public
	 * @param  array params | array with parameters from the routing process
	 */
	public function delete($params = []) {
		$this->accessControl();

		$box = models\BoxModel::find($params["idBox"]);
		if(!$box->exists()) {
			throw new error\NotFoundException("Could not find box #{$params['idBox']}");
		}

		//check if the logged in user is the actual owner
		if($box->idUser != $_SESSION["usr"]["db_id"]) {
			throw new error\NotAllowedException("User with the id {$_SESSION["usr"]["db_id"]} tried to delete the box #{$params['idBox']}");
		}

		yield "error" => !$box->destroy();
		$this->format("json")->addCallback(
			function($data) {
				return ["error" => $data["error"]];
			}
		);		
	}	

}