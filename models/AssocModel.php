<?php
/**
* This file is part of the holonet flashcards application
 * (c) Matthias Lantsch
 *
 * class file for the Assoc model
 *
 * @package flashcards
 * @license http://opensource.org/licenses/gpl-license.php  GNU Public License
 * @author  Matthias Lantsch <matthias.lantsch@bluewin.ch>
 */

namespace holonet\flashcards\models;

use holonet\activerecord\ModelBase;

/**
 * assoc model class
 * a assoc is defined as being the association between a box, a user and a flash card
 * every user that uses a flashcard box will get it's own assoc entry for each card
 * the assoc table contains:
 *  - the number of times a user has guessed the card right
 *  - the number of times a user has guessed the card wrong
 *  - the tier the user has the card on (1-5)
 *
 * @author  matthias.lantsch
 * @package holonet\flashcards\models
 */
class AssocModel extends ModelBase {

	/**
	 * property containing belongsTo relationship mappings
	 *
	 * @access public
	 * @var    array $belongsTo Relationship mappings
	 */
	public static $belongsTo = array("user", "card");

	/**
	 * property containing verification data for some of the columns
	 *
	 * @access public
	 * @var    array $validate Array with verification data
	 */
	public static $validate = [
		"wrongC" => ["presence" => true],
		"corrC" => ["presence" => true],
		"tier" => ["presence" => true],
		"lasttier" => ["presence" => true]
	];

	/**
	 * using a percentage as a measurement of how well the user knows this card
	 * e.g. tier 5 => perfect 100%
	 *
	 * @access public
	 * @return  integer a percentage of how well a user knows this card
	 */
	public function percentage() {
		return floor($this->tier / 5 * 100);
	}

	/**
	 * constructor method taking a assotiative array as an argument
	 * overwritten for hooking into the creation process
	 *
	 * @access public
	 * @param  array $data Data the assotiative array
	 * @param  boolean $fromDb Boolean marking the data entry as new or not
	 * @return void
	 */
	public function __construct($data = array(), $fromDb = false) {
		if(!isset($data['wrongC'])) {
			$data["wrongC"] = 0;
		}

		if(!isset($data['corrC'])) {
			$data["corrC"] = 0;
		}

		if(!isset($data['tier'])) {
			$data["tier"] = 0;
		}

		if(!isset($data['lasttier'])) {
			$data["lasttier"] = 0;
		}

		parent::__construct($data, $fromDb);
	}

}
