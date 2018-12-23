<?php
/**
* This file is part of the flashcards package
 * (c) Matthias Lantsch
 *
 * Class file for the CardsController
 *
 * @package flashcards
 * @license http://opensource.org/licenses/gpl-license.php  GNU Public License
 * @author  Matthias Lantsch <matthias.lantsch@bluewin.ch>
 */

namespace holonet\flashcards\controllers;

use RuntimeException;
use holonet\flashcards\models\CardModel;
use holonet\flashcards\models\BoxModel;
use holonet\flashcards\models\AssocModel;

/**
 * CardsController exposing the card REST resource to the application card
 *
 * @author  matthias.lantsch
 * @package holonet\flashcards\controllers
 */
class CardsController extends FlashcardsControllerBase {

	/**
	 * GET /boxes/[idBox:i]/cards/new
	 * Display an edit mask to create a new entry
	 *
	 * @access public
	 * @param  integer $idBox The id of the box to add a new card to
	 * @return the yield from the controller method
	 */
	public function new(int $idBox) {
		if(($box = BoxModel::find($idBox)) === null) {
			$this->notFound("Box with the id #{$idBox}");
		}

		//check if the logged in user is the actual owner
		if($box->idUser != $this->user->id) {
			$this->notAllowed("User with the id {$this->user->id} tried to change the box #{$id}");
		}

		yield "box" => $box;

		//just return only the form template raw
		$this->respondTo("html")->append("cards".DIRECTORY_SEPARATOR."form");
	}

	/**
	 * POST /boxes/[idBox:i]/cards
	 * method used to create a new card
	 *
	 * @access public
	 * @param  integer $idBox The id of the box to add a new card to
	 * @return the yield from the controller method
	 */
	public function create(int $idBox) {
		if(($box = BoxModel::find($idBox)) === null) {
			$this->notFound("Box with the id #{$idBox}");
		}

		//check if the logged in user is the actual owner
		if($box->idUser != $this->user->id) {
			$this->notAllowed("User with the id {$this->user->id} tried to change the box #{$id}");
		}

		//create the new flashcard
		$newCard = new CardModel([
			"qSide" => strip_tags($this->request->request->get("question")),
			"aSide" => strip_tags($this->request->request->get("answer")),
			"idBox" => $box->id
		]);

		if(!$newCard->save()) {
			throw new RuntimeException("Failed creating a new flashcard valid?: ".var_export($newCard->valid(), true), 400);
		} else {
			yield "idCard" => $newCard->id;

			//create an assoc table entry for the owner of the box
			$assoc = AssocModel::create([
				"idCard" => $newCard->id,
				"idUser" => $box->idUser
			]);

			if($assoc === false) {
				throw new RuntimeException("Failed creating an assoc entry for #{$box->id} valid?: ".var_export($assoc->valid(), true), 400);
			}
		}

		$box->lastActivity();

		$this->respondTo("json")->addCallback(
			function($data) {
				return ["error" => false, "idCard" => $data["idCard"]];
			}
		);
	}

	/**
	 * GET /boxes/[idBox:i]/cards/[idCard:i]/edit
	 * method used to show an edit mask to change a card entry
	 *
	 * @access public
	 * @param  integer $idBox The id of the box to edit a card in
	 * @param  integer $idCard The id of the card to edit
	 * @return the yield from the controller method
	 */
	public function edit(int $idBox, int $idCard) {
		if(($box = BoxModel::find($idBox)) === null) {
			$this->notFound("Box with the id #{$idBox}");
		}

		//check if the logged in user is the actual owner
		if($box->idUser != $this->user->id) {
			$this->notAllowed("User with the id {$this->user->id} tried to change the box #{$id}");
		}

		if(($card = CardModel::find($idCard)) === null) {
			$this->notFound("card with the id #{$idCard}");
		}

		yield "box" => $box;
		yield "card" => $card;

		//just return only the form template raw
		$this->respondTo("html")->append("cards".DIRECTORY_SEPARATOR."form");
	}

	/**
	 * PUT /boxes/[idBox:i]/cards/[idCard:i]
	 * method used to submit a change to an existing card entry
	 *
	 * @access public
	 * @param  integer $idBox The id of the box to edit a card in
	 * @param  integer $idCard The id of the card to edit
	 * @return the yield from the controller method
	 */
	public function update(int $idBox, int $idCard) {
		if(($box = BoxModel::find($idBox)) === null) {
			$this->notFound("Box with the id #{$idBox}");
		}

		//check if the logged in user is the actual owner
		if($box->idUser != $this->user->id) {
			$this->notAllowed("User with the id {$this->user->id} tried to change the box #{$id}");
		}

		if(($card = CardModel::find($idCard)) === null) {
			$this->notFound("card with the id #{$idCard}");
		}

		$card->qSide = strip_tags($this->request->request->get("question"));
		$card->aSide = strip_tags($this->request->request->get("answer"));
		if(!$card->save()) {
			throw new RuntimeException("Failed updating flashcard with id #{$idCard} valid?: ".var_export($newCard->valid(), true), 400);
		}

		$box->lastActivity();
		yield "idCard" => $card->id;

		$this->respondTo("json")->addCallback(
			function($data) {
				return ["error" => false, "idCard" => $data["idCard"]];
			}
		);
	}

	/**
	 * DELETE /boxes/[idBox:i]/cards/[idCard:i]
	 * method used to delete a card entry
	 *
	 * @access public
	 * @param  integer $idBox The id of the box to edit a card in
	 * @param  integer $idCard The id of the card to edit
	 * @return the yield from the controller method
	 */
	public function delete(int $idBox, int $idCard) {
		if(($box = BoxModel::find($idBox)) === null) {
			$this->notFound("Box with the id #{$idBox}");
		}

		//check if the logged in user is the actual owner
		if($box->idUser != $this->user->id) {
			$this->notAllowed("User with the id {$this->user->id} tried to change the box #{$id}");
		}

		if(($card = CardModel::find($idCard)) === null) {
			$this->notFound("card with the id #{$idCard}");
		}

		$box->lastActivity();
		yield "error" => !$card->destroy();

		$this->respondTo("json")->addCallback(
			function($data) {
				return ["error" => $data["error"]];
			}
		);
	}

	/**
	 * json backend method used to update the personal progress of one user on that card
	 * a request onto this method informs the application of one of these events:
	 *  - a user viewed a card
	 *  - a user answered a card correct
	 *  - a user answered a card wrong
	 * POST /boxes/[idBox:i]/cards/[idCard:i]/update
	 *
	 * @access public
	 * @param  integer $idBox The id of the box to edit a card in
	 * @param  integer $idCard The id of the card to edit
	 * @return the yield from the controller method
	 */
	public function cardUpdate(int $idBox, int $idCard) {
		if(($box = BoxModel::find($idBox)) === null) {
			$this->notFound("Box with the id #{$idBox}");
		}

		if(($card = CardModel::find($idCard)) === null) {
			$this->notFound("card with the id #{$idCard}");
		}

		$assoc = $card->progressOf($this->user->id);
		if($assoc === null) {
			$assoc = AssocModel::create([
				"idCard" => $card->id,
				"idUser" => $this->user->id
			]);

			if($assoc === false) {
				throw new RuntimeException("Failed creating an assoc entry for #{$box->id}", 400);
			}
		}

		if($this->request->request->get("update") === "WRONG") {
			$assoc->wrongC += 1;
			$assoc->tier = 1;
		} elseif($this->request->request->get("update") === "RIGHT") {
			$assoc->corrC += 1;
			if($assoc->tier < 5) {
				$assoc->tier += 1;
			}
		}

		if(!$assoc->save()) {
			throw new RuntimeException("Failed updating the assoc entry for #{$assoc->id}", 400);
		}

		$box->lastActivity();

		$this->respondTo("json")->addCallback(
			function($data) {
				return ["error" => false];
			}
		);
	}

}
