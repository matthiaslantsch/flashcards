<?php
/**
 * This file is part of the flashcards package
 * (c) Matthias Lantsch
 *
 * class file for the UserController controller class
 * @package flashcards
 * @license http://opensource.org/licenses/gpl-license.php  GNU Public License
 * @author  Matthias Lantsch <matthias.lantsch@bluewin.ch>
 */

namespace holonet\flashcards\controllers;

use holonet\flashcards\models\BoxModel;
use holonet\flashcards\models\UserModel;

/**
 * The UserController class
 *
 * @author  matthias.lantsch
 * @package holonet\flashcards\controllers
 */
class UserController extends FlashcardsControllerBase {

	/**
	 * method for the index action
	 * GET /
	 *
	 * @access public
	 * @return yield from the controller method
	 */
	public function index() {
		yield "title" => "Dashboard";
		yield "myBoxCount" => BoxModel::count(array("idUser" => $this->user->id));
		yield "boxCount" => BoxModel::count();
		yield "user" => $this->user;
	}

	/**
	 * method for the index action
	 * GET /profile
	 *
	 * @access public
	 * @return yield from the controller method
	 */
	public function profile() {
		yield "title" => "{$this->user->name} Profile";
		yield "user" => $this->user;
	}

	/**
	 * method for the my boxes view
	 * shows all boxes the user created and allows for creation of new ones
	 * GET /my
	 * GET /user/[idUser:i]
	 *
	 * @access public
	 * @param  int $idUser Optional parameter to specify what user's boxes to see
	 * @return yield from the controller method
	 */
	public function listboxes(int $idUser = null) {
		//check if a user id was submitted
		if($idUser === null) {
			//personal user "My Boxes" view
			$user = $this->user;
			yield "title" => "My Boxes";
			yield "listName" => "My Boxes";
		} else {
			//viewing the boxes of a specific user
			if(($user = UserModel::find($idUser)) === null) {
				$this->notFound("User with the id '{$idUser}'");
			}

			yield "title" => "{$user->name} Boxes";
			yield "listName" => "{$user->name} Boxes";
		}

		yield "backendRequest" => "&idUser={$user->id}";
		yield "user" => $user;

		//overwrite to use the listing template
		$this->renderTemplate("boxes".DIRECTORY_SEPARATOR."index");
	}

	/**
	 * json backend method used to completely remove a user with it's associated records
	 * DELETE /user/[idUser:i]
	 *
	 * @access public
	 * @param  int $idUser Parameter to specify what user to delete
	 * @return yield from the controller method
	 */
	public function delete(int $idUser) {
		if(($user = UserModel::find($idUser)) === null) {
			$this->notFound("User #{$idUser}");
		}

		//check if the logged in user is the actual user himself
		if($user->id != $this->user->id) {
			//check if it's an admin doing the request
			$this->checkAccess("admin", "delUser");
		}

		yield "error" => !$user->destroy();
		$this->respondTo("json")->addCallback(
			function($data) {
				return ["error" => $data["error"]];
			}
		);
	}

}
