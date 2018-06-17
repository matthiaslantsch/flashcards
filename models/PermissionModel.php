<?php
/**
 * This file is part of the flashcard project
 * (c) Matthias Lantsch
 *
 * Permission model class file
 */

namespace HIS5\flashcards\models;

use HIS5\lib\activerecord as ar;

/**
 * model to represent a permission entry in the database
 * part of the standard database authentification service
 * 
 * @author  Matthias Lantsch
 * @version {VERSION}
 * @package HIS5\flashcards\models
 */
class PermissionModel extends ar\ModelBase {

	/**
	 * property containing relationship mappings
	 *
	 * @access 	public
	 * @var 	array with relationships
	 */
	public static $relations = [
		"user" => "many2many",
		"userGroup" => "many2many"
	];

	/**
	 * property containing verification data for some of the columns
	 *
	 * @access 	public
	 * @var 	array with verification data
	 */
	public $valid = [
		"permission" => array("presence" => true, "minLength" => 10, "maxLength" => 40, "pattern" => "/HN_PERM_WEB_(.*)/")
	];

}