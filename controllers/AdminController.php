<?php
/**
 * This file is part of the flashcards package
 * (c) Matthias Lantsch
 *
 * class file for the AdminController controller class
 */

namespace HIS5\flashcards\controllers;

use HIS5\holoFW\core\baseclasses as base;
use HIS5\holoFW\core\error as error;
use HIS5\flashcards\models as models;

/**
 * The AdminController class
 * Controller class for the admin area of the webpage
 *
 * @author  Matthias Lantsch
 * @version {VERSION}
 * @package HIS5\flashcards\controllers
 */
class AdminController extends base\ControllerBase {

	/**
	 * method for the index action
	 * Provides an overview over the existing users in the application
	 * /admin ANY
	 *
	 * @access public
	 */
	public function index() {
		$this->accessControl();

		yield "title" => "Admin interface";
		yield "user" => models\UserModel::find($_SESSION["usr"]["db_id"]);
		yield "users" => models\UserModel::all();

		$this->format("html")->append("user")->append("admin".DIRECTORY_SEPARATOR."index");
	}

}