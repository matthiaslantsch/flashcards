<?php
/**
 * This file is part of the flashcards package
 * (c) Matthias Lantsch
 *
 * class file for the CardController controller class
 */

namespace HIS5\flashcards\controllers;

use HIS5\holoFW\core\baseclasses as base;
use HIS5\holoFW\core\error as error;
use HIS5\flashcards\models as models;

/**
 * The CardController class
 *
 * @author  Matthias Lantsch
 * @version {VERSION}
 * @package HIS5\flashcards\controllers
 */
class CardController extends base\ControllerBase {

	/**
	 * json backend method used to dynamically load a form to either edit a flashcard or create a new one
	 * /card/form/idCard?:int GET
	 *
	 * @access public
	 * @param  array params | array with parameters from the routing process
	 */
	public function form($params = []) {
		$this->accessControl();

		if(!isset($_GET["idBox"])) {
			throw new error\HFWException("Failed to create a new flashcard without supplying a box id");
		}

		$box = models\BoxModel::find($_GET["idBox"]);
		if(!$box->exists()) {
			throw new error\NotFoundException("Could not find box #{$_GET['idBox']}");
		}

		//check if the logged in user is the actual owner
		if($box->idUser != $_SESSION["usr"]["db_id"]) {
			throw new error\NotAllowedException("User with the id {$_SESSION["usr"]["db_id"]} tried to add a card to the box #{$_GET['idBox']}");
		}

		if(isset($params["idCard"])) {
			//edit case
			$card = models\CardModel::find($params["idCard"]);
			if(!$card->exists()) {
				throw new error\NotFoundException("Could not find flashcard #{$params['idCard']}");
			}

			yield "card" => $card;
		}

		$this->format("html")->append("card".DIRECTORY_SEPARATOR."form")->raw = true;
	}

	/**
	 * json backend method used to add a flashcard to the given box
	 * /card/save/idCard?:int POST
	 *
	 * @access public
	 * @param  array params | array with parameters from the routing process
	 */
	public function save($params = []) {
		$this->accessControl();

		if(!isset($_POST["idBox"])) {
			throw new error\HFWException("Failed to create a new flashcard without supplying a box id");
		}

		$box = models\BoxModel::find($_POST["idBox"]);
		if(!$box->exists()) {
			throw new error\NotFoundException("Could not find box #{$_POST['idBox']}");
		}

		//check if the logged in user is the actual owner
		if($box->idUser != $_SESSION["usr"]["db_id"]) {
			throw new error\NotAllowedException("User with the id {$_SESSION["usr"]["db_id"]} tried to add a card to the box #{$_POST['idBox']}");
		}

		if(isset($params["idCard"])) {
			$card = models\CardModel::find($params["idCard"]);
			if(!$card->exists()) {
				throw new error\NotFoundException("Could not find flashcard #{$params['idCard']}");
			}

			$card->qSide = strip_tags($_POST["question"]);
			$card->aSide = strip_tags($_POST["answer"]);
			if(!$card->save()) {
				throw new error\HFWException("Failed updating flashcard #{$card->id} valid?: ".var_export($card->valid(), true));
			}

			yield "idCard" => $card->id;
		} else {
			//create the new flashcard
			$newCard = new models\CardModel([
				"qSide" => strip_tags($_POST["question"]),
				"aSide" => strip_tags($_POST["answer"]),
				"idBox" => $box->id
			]);

			if(!$newCard->save()) {
				throw new error\HFWException("Failed creating a new flashcard valid?: ".var_export($newCard->valid(), true));
			} else {
				yield "idCard" => $newCard->id;

				//create an assoc table entry for the owner of the box
				$assoc = models\AssocModel::create([
					"idCard" => $newCard->id,
					"idUser" => $box->idUser
				]);

				if($assoc === false) {
					throw new error\HFWException("Failed creating an assoc entry for #{$box->id} valid?: ".var_export($assoc->valid(), true));
				}
			}
		}

		$box->updateTimestamp();

		$this->format("json")->addCallback(
			function($data) {
				return ["error" => false, "idCard" => $data["idCard"]];
			}
		);
	}

	/**
	 * json backend method used to completely remove a flashcard with it's associated records
	 * /card/idCard:int/delete POST
	 *
	 * @access public
	 * @param  array params | array with parameters from the routing process
	 */
	public function delete($params = []) {
		$this->accessControl();

		$card = models\CardModel::find($params["idCard"]);
		if(!$card->exists()) {
			throw new error\NotFoundException("Could not find flashcard #{$params['idCard']}");
		}

		//check if the logged in user is the actual owner
		if($card->box->idUser != $_SESSION["usr"]["db_id"]) {
			throw new error\NotAllowedException("User with the id {$_SESSION["usr"]["db_id"]} tried to delete the flashcard #{$params['idCard']}");
		}

		$card->box->updateTimestamp();

		yield "error" => !$card->destroy();
		$this->format("json")->addCallback(
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
	 * /card/idCard:int/update POST
	 *
	 * @access public
	 * @param  array params | array with parameters from the routing process
	 */
	public function update($params = []) {
		$this->accessControl();

		$card = models\CardModel::find($params["idCard"]);
		if(!$card->exists()) {
			throw new error\NotFoundException("Could not find flashcard #{$params['idCard']}");
		}

		$assoc = $card->progressOf($_SESSION["usr"]["db_id"]);
		if($assoc === null) {
			$assoc = models\AssocModel::create([
				"idCard" => $card->id,
				"idUser" => $_SESSION["usr"]["db_id"]
			]);

			if($assoc === false) {
				throw new error\HFWException("Failed creating an assoc entry for #{$box->id}", true);
			}
		}

		if($_POST["update"] == "WRONG") {
			$assoc->wrongC = $assoc->wrongC + 1;
			$assoc->tier = 1;
		} elseif($_POST["update"] == "RIGHT") {
			$assoc->corrC = $assoc->corrC + 1;
			if($assoc->tier < 5) {
				$assoc->tier = $assoc->tier + 1;
			}
		}

		if(!$assoc->save()) {
			throw new error\HFWException("Failed updating the assoc entry for #{$assoc->id}", true);
		}
		$this->format("json")->addCallback(
			function($data) {
				return ["error" => false];
			}
		);	
	}

}