<?php
/**
 * This file is part of the flashcard project
 * (c) Matthias Lantsch
 *
 * User Group model class file
 */

namespace HIS5\flashcards\models;

use HIS5\lib\activerecord as ar;

/**
 * model to represent a user group in the database
 * part of the standard database authentification service
 * 
 * @author  Matthias Lantsch
 * @version {VERSION}
 * @package HIS5\flashcards\models
 */
class UserGroupModel extends ar\ModelBase {

	/**
	 * property containing relationship mappings
	 *
	 * @access 	public
	 * @var 	array with relationships
	 */
	public static $relations = [
		"permission" => "many2many",
		"user" => "many2many"
	];

	/**
	 * property containing verification data for some of the columns
	 *
	 * @access 	public
	 * @var 	array with verification data
	 */
	public $valid = [
		"name" => array("presence" => true, "minLength" => 10)
	];

}