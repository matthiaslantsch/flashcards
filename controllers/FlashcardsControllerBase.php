<?php
/**
* This file is part of the flashcards package
 * (c) Matthias Lantsch
 *
 * Class file for the abstract FlashcardsControllerBase base class
 *
 * @package flashcards
 * @license http://opensource.org/licenses/gpl-license.php  GNU Public License
 * @author  Matthias Lantsch <matthias.lantsch@bluewin.ch>
 */

namespace holonet\flashcards\controllers;

use holonet\holofw\FWController;
use holonet\flashcards\models\UserModel;

/**
 * abstract FlashcardsControllerBase base class for every flashcards controller
 * used to import the current sphinx user to our database
 *
 * @author  matthias.lantsch
 * @package holonet\flashcards\controllers
 */
abstract class FlashcardsControllerBase extends FWController {

	/**
	 * property containing a reference to the current user object
	 *
	 * @access protected
	 * @var    UserModel $user The current logged in user for the flashcard app
	 */
	protected $user;

	/**
	 * facade method used to import the current sphinx user to our database
	 *
	 * @access public
	 * @return void
	 */
	public function __before() {
		$this->authenticateUser();

		$this->user = UserModel::getOrCreate(array(
			"name" => $this->session->user->name,
			"sphinx_id" => $this->session->user->db_id
		), true);
	}

}
