<?php
/**
 * This file is part of the flashcards package
 * (c) Matthias Lantsch
 *
 * class file for the AuthtokenModel model class
 */

namespace HIS5\flashcards\models;

use HIS5\lib\activerecord as ar;

/**
 * authtoken model class (part of the standard db authentification service)
 * 
 * @author  Matthias Lantsch
 * @version {VERSION}
 * @package HIS5\flashcards\models
 */
class AuthtokenModel extends ar\ModelBase {

	/**
	 * property containing relationship mappings
	 *
	 * @access 	public
	 * @var 	array with relationships
	 */
	public static $relations = [
		"user" => "belongsTo"
	];
	
	/**
	 * property containing verification data for some of the columns
	 *
	 * @access 	public
	 * @var 	array with verification data
	 */
	public $valid = [
		"selector" => array("presence" => true, "maxLength" => 12),
		"token" => array("presence" => true, "maxLength" => 64),
		"expires" => array("presence" => true)
	];

}