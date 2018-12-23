<?php
/**
* This file is part of the holonet flashcards application
 * (c) Matthias Lantsch
 *
 * Model class for the UserModel model class
 *
 * @package flashcards
 * @license http://opensource.org/licenses/gpl-license.php  GNU Public License
 * @author  Matthias Lantsch <matthias.lantsch@bluewin.ch>
 */

namespace holonet\flashcards\models;

use holonet\activerecord\ModelBase;

/**
 * UserModel to wrap around the user table
 *
 * @author  matthias.lantsch
 * @package holonet\flashcards\models
 */
class UserModel extends ModelBase {

	/**
	 * property containing hasMany relationship mappings
	 *
	 * @access public
	 * @var    array $hasMany Relationship mappings
	 */
	public static $hasMany = array("boxes", "assocs");

	/**
	 * property containing verification data for some of the columns
	 *
	 * @access public
	 * @var    array $validate Array with verification data
	 */
	public static $validate = [
		"name" => array("presence", "length" => ["max" => 40, "min" => 4]),
		"sphinx_id" => array("presence", "uniqueness")
	];

}
