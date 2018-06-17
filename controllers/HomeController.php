<?php
/**
 * This file is part of the flashcards package
 * (c) Matthias Lantsch
 *
 * class file for the HomeController controller class
 */

namespace HIS5\flashcards\controllers;

use HIS5\holoFW\core\baseclasses as base;
use HIS5\holoFW\core\error as error;
use HIS5\flashcards\models as models;

/**
 * The HomeController class
 *
 * @author  Matthias Lantsch
 * @version {VERSION}
 * @package HIS5\flashcards\controllers
 */
class HomeController extends base\ControllerBase {

	/**
	 * method for the index action
	 * /login GET
	 *
	 * @access public
	 */
	public function login() {
		if(isset($_SESSION["usr"])) {
			$authTokens = models\AuthtokenModel::where("idUser = ?", $_SESSION["usr"]["db_id"]);
			$authTokens->delete();
			unset($_SESSION["usr"]);
			session_destroy();
		}

		yield "title" => "Login";
	}

}