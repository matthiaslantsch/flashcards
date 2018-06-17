<?php
/**
 * This file is part of the flashcard project
 * (c) Matthias Lantsch
 *
 * class file for the Assoc model
 */

namespace HIS5\flashcards\models;

use HIS5\lib\activerecord as ar;

/**
 * user model class
 * holds user information
 * 
 * @author  Matthias Lantsch
 * @version {VERSION}
 * @package HIS5\flashcards\models
 */
class UserModel extends ar\ModelBase {

	/**
	 * property containing relationship mappings
	 *
	 * @access 	public
	 * @var 	array with relationships
	 */
	public static $relations = [
		"assoc" => "canHaveMany",
		"box" => "canHaveMany",
		"authtoken" => "canHaveMany",
		"permission" => "many2many",
		"userGroup" => "many2many"
	];
	
	/**
	 * property containing verification data for some of the columns
	 *
	 * @access 	public
	 * @var 	array with verification data
	 */
	public $valid = [
		"name" => array("presence" => true, "minLength" => 4, "maxLength" => 40),
		"email" => array("presence" => true, "minLength" => 10, "maxLength" => 40)
	];

	/**
	 * constructor method taking a assotiative array as an argument
	 * overwritten for hooking into the creation process
	 *
	 * @access 	public
	 * @param   data the assotiative array
	 */
	public function __construct($data = array(), $fromDb = false) {
		if(isset($data['password'])) {
			$data['authHash'] = password_hash($data['password'], PASSWORD_DEFAULT);
			unset($data['password']);
		}
		parent::__construct($data, $fromDb);
	}

	/**
	 * special getter method used as a shortcut to the ADMIN permission string
	 * the method will check the session before the database to reduce requests
	 *
	 * @access 	public
	 * @return  boolean marking this user as an admin or not
	 */
	public function isAdmin() {
		if(isset($_SESSION["usr"]) && $_SESSION["usr"]["db_id"] == $this->id) {
			return in_array("HN_PERM_WEB_FLASHCARDS_ADMIN_*", $_SESSION["usr"]["perms"]);
		} else {
			return in_array("HN_PERM_WEB_FLASHCARDS_ADMIN_*", $this->permission->__toArray("permission"));			
		}
	}

}