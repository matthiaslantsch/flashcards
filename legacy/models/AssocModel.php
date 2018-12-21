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
 * assoc model class
 * a assoc is defined as being the association between a box, a user and a flash card
 * every user that uses a flashcard box will get it's own assoc entry for each card
 * the assoc table contains:
 *  - the number of times a user has guessed the card right
 *  - the number of times a user has guessed the card wrong
 *  - the tier the user has the card on (1-5)
 * 
 * @author  Matthias Lantsch
 * @version {VERSION}
 * @package HIS5\flashcards\models
 */
class AssocModel extends ar\ModelBase {

	/**
	 * property containing relationship mappings
	 *
	 * @access 	public
	 * @var 	array with relationships
	 */
	public static $relations = [
		"user" => "belongsTo",
		"card" => "belongsTo"
	];
	
	/**
	 * property containing verification data for some of the columns
	 *
	 * @access 	public
	 * @var 	array with verification data
	 */
	public $valid = [
		"wrongC" => ["presence" => true],
		"corrC" => ["presence" => true],
		"tier" => ["presence" => true]
	];

	/**
	 * using a percentage as a measurement of how well the user knows this card
	 * e.g. tier 5 => perfect 100%
	 *
	 * @access 	public
	 * @param   data the assotiative array
	 */
	public function percentage() {
		return floor($this->tier / 5 * 100);
	}

	/**
	 * constructor method taking a assotiative array as an argument
	 * overwritten for hooking into the creation process
	 *
	 * @access 	public
	 * @param   data the assotiative array
	 */
	public function __construct($data = array(), $fromDb = false) {
		if(!isset($data['wrongC'])) {
			$data["wrongC"] = 0;
		}

		if(!isset($data['corrC'])) {
			$data["corrC"] = 0;
		}

		if(!isset($data['tier'])) {
			$data["tier"] = 1;
		}

		parent::__construct($data, $fromDb);
	}

}