<?php
/**
 * This file is part of the flashcards package
 * (c) Matthias Lantsch
 *
 * class file for the UserController controller class
 */

namespace HIS5\flashcards\controllers;

use HIS5\holoFW\core\baseclasses as base;
use HIS5\holoFW\core\error as error;
use HIS5\flashcards\models as models;

/**
 * The UserController class
 *
 * @author  {AUTHOR}
 * @version {VERSION}
 * @package HIS5\flashcards\controllers
 */
class UserController extends base\ControllerBase {

	/**
	 * method for the index action
	 * / GET
	 *
	 * @access public
	 */
	public function index() {
		$this->accessControl();
		$user = models\UserModel::find($_SESSION["usr"]["db_id"]);

		yield "title" => "Dashboard";
		yield "myBoxCount" => count(models\BoxModel::where("idUser = ?", $user->id));
		yield "boxCount" => count(models\BoxModel::all());
		yield "user" => $user;
	}

	/**
	 * method for the index action
	 * /profile GET
	 *
	 * @access public
	 */
	public function profile() {
		$this->accessControl();

		$user = models\UserModel::find($_SESSION["usr"]["db_id"]);

		yield "title" => "{$user->name} Profile";
		yield "user" => $user;
		$this->format("html")->append("user")->append("user".DIRECTORY_SEPARATOR."profile")->append("user".DIRECTORY_SEPARATOR."form");
	}

	/**
	 * method for the my boxes view
	 * shows all boxes the user created and allows for creation of new ones
	 * /my GET
	 * /boxes/idUser:int GET
	 *
	 * @access public
	 * @param  array params | array with parameters from the routing process
	 */
	public function listboxes($params = []) {
		$this->accessControl();

		//check if a user id was submitted
		if(!isset($params["idUser"])) {
			//personal user "My Boxes" view
			$user = models\UserModel::find($_SESSION["usr"]["db_id"]);
			yield "title" => "My Boxes";
			yield "listName" => "My Boxes";
		} else {
			//viewing the boxes of a specific user
			$user = models\UserModel::find($params["idUser"]);
			if(!$user->exists()) {
				throw new error\NotFoundException("Could not find user with the id {$params['idUser']}");
			}

			yield "title" => "{$user->name} Boxes";
			yield "listName" => "{$user->name} Boxes";
		}

		yield "backendRequest" => "&idUser={$user->id}";
		yield "user" => $user;

		//overwrite the controller facade method to use the common template
		$this->format("html")->append("user")->append("box".DIRECTORY_SEPARATOR."listing");
	}

	/**
	 * facade method building the sidebar
	 *
	 * @access public
	 */
	public function __before() {
		//append the user controller template first (with the user navigation sidebar)
		$this->format("html")->append("user")->append("user".DIRECTORY_SEPARATOR."{$this->method}");
	}

	/**
	 * json backend method used to dynamically load a form to either edit a user or create a new one
	 * /user/form/idUser?:int GET
	 *
	 * @access public
	 * @param  array params | array with parameters from the routing process
	 */
	public function form($params = []) {
		$this->accessControl();

		if(isset($params["idUser"])) {
			//edit case
			$user = models\UserModel::find($params["idUser"]);
			if(!$user->exists()) {
				throw new error\NotFoundException("Could not find user #{$params['idUser']}");
			}

			yield "user" => $user;
		}

		$this->format("html")->append("user".DIRECTORY_SEPARATOR."form")->raw = true;
	}

	/**
	 * method for the save action
	 * /user/idUser:?int POST
	 * JSON
	 *
	 * @access public
	 * @param  array params | array with parameters from the routing process
	 */
	public function save($params = []) {
		$perms[] = models\PermissionModel::create(["permission" => "HN_PERM_WEB_FLASHCARDS_USER_*"]);
		$perms[] = models\PermissionModel::create(["permission" => "HN_PERM_WEB_FLASHCARDS_BOX_*"]);
		$perms[] = models\PermissionModel::create(["permission" => "HN_PERM_WEB_FLASHCARDS_CARD_*"]);

		if(isset($_POST["admin"]) && $_POST["admin"] == "true") {
			$perms[] = models\PermissionModel::create(["permission" => "HN_PERM_WEB_FLASHCARDS_ADMIN_*"]);
		}

		if(isset($params["idUser"])) {
			$this->accessControl();
			//edit case
			$user = models\UserModel::find($params["idUser"]);
			if(!$user->exists()) {
				throw new error\NotFoundException("Could not find user #{$params['idUser']}");
			}

			//check if the logged in user is editing his own profile
			//also go into the admin check if the post tries to make a user to an admin
			if($user->idUser != $_SESSION["usr"]["db_id"] || (isset($_POST["admin"]) && $_POST["admin"] == "true")) {
				//check if the user sending the POST is an admin
				$this->accessControl("admin", "editUser");
			}

			$user->name = strip_tags($_POST["name"]);
			$user->email = strip_tags($_POST["email"]);
			$user->permission = $perms;

			if(isset($_POST["password"]) && $_POST["password"] !== "") {
				$user->authHash = password_hash($_POST["password"], PASSWORD_DEFAULT);
			}

			if(!$user->save()) {
				throw new error\HFWException("Failed saving edit to user id: {$user->id} valid?: ".var_export($user->valid(), true));
			} else {
				yield "errormsg" => "";
			}
		} else {
			//new case
			$this->accessControl("admin", "addUser");

			//check if the username is already taken
			if(models\UserModel::findBy("name = ?", strip_tags($_POST["name"]))->exists()) {
				yield "errormsg" => "Username already taken";
			} else {
				$newUser = new models\UserModel([
					"name" => strip_tags($_POST["name"]),
					"email" => strip_tags($_POST["email"]),
					"password" => strip_tags($_POST["password"]),
					"permission" => $perms
				]);

				if(!$newUser->save()) {
					throw new error\HFWException("Failed creating a new user valid?: ".var_export($newUser->valid(), true));
				} else {
					yield "errormsg" => "";
				}
			}
		}

		$this->format("json")->addCallback(
			function($data) {
				return ["errormsg" => $data["errormsg"]];
			}
		);
	}

	/**
	 * json backend method used to completely remove a user with it's associated records
	 * /user/idUser:int/delete POST
	 *
	 * @access public
	 * @param  array params | array with parameters from the routing process
	 */
	public function delete($params = []) {
		$this->accessControl();

		$user = models\UserModel::find($params["idUser"]);
		if(!$user->exists()) {
			throw new error\NotFoundException("Could not find user #{$params['idUser']}");
		}

		//check if the logged in user is the actual user himself
		if($user->id != $_SESSION["usr"]["db_id"]) {
			//check if it's an admin doing the request
			$this->accessControl("admin", "delUser");
		}

		yield "error" => !$user->destroy();
		$this->format("json")->addCallback(
			function($data) {
				return ["error" => $data["error"]];
			}
		);		
	}

}