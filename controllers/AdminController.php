<?php
/**
 * This file is part of the flashcards package
 * (c) Matthias Lantsch
 *
 * class file for the AdminController controller class
 *
 * @package flashcards
 * @license http://opensource.org/licenses/gpl-license.php  GNU Public License
 * @author  Matthias Lantsch <matthias.lantsch@bluewin.ch>
 */

namespace holonet\flashcards\controllers;

use holonet\flashcards\models\UserModel;

/**
 * The AdminController class
 * Controller class for the admin area of the webpage
 *
 * @author  matthias.lantsch
 * @package holonet\flashcards\controllers
 */
class AdminController extends FlashcardsControllerBase {

	/**
	 * method for the index action
	 * Provides an overview over the existing users in the application
	 * GET /admin
	 *
	 * @access public
	 * @return yield from the controller method
	 */
	public function index() {
		$this->checkAccess("admin", "interface");

		yield "title" => "Admin interface";
		yield "user" => $this->user;
		yield "users" => UserModel::all();
	}

}
