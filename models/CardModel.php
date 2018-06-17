<?php
/**
 * This file is part of the flashcard project
 * (c) Matthias Lantsch
 *
 * class file for the Card model
 */

namespace HIS5\flashcards\models;

use HIS5\lib\activerecord as ar;

/**
 * card model class
 * a card is defined as a flashcard with 2 sides,
 * one containing the "question" and the other one the "answer"
 * 
 * @author  Matthias Lantsch
 * @version {VERSION}
 * @package HIS5\flashcards\models
 */
class CardModel extends ar\ModelBase {

	/**
	 * property containing relationship mappings
	 *
	 * @access 	public
	 * @var 	array with relationships
	 */
	public static $relations = [
		"assoc" => "canHaveMany",
		"box" => "belongsTo"
	];
	
	/**
	 * property containing verification data for some of the columns
	 *
	 * @access 	public
	 * @var 	array with verification data
	 */
	public $valid = [
		"qSide" => ["presence" => true],
		"aSide" => ["presence" => true]
	];

	/**
	 * special getter method for the individual progress each user has made on this card
	 * returns an instance of AssocModel if the user has ever done anything with this card
	 *
	 * @access 	public
	 * @param   integer idUser | the user id for whom the progress is requested
	 */
	public function progressOf($idUser) {
		if($idUser === null) {
			return null;
		}

		$ret = AssocModel::findBy("idCard = {$this->id} AND idUser = ?", $idUser);
		if($ret->exists()) {
			return $ret->execute();
		} else {
			return null;
		}
	}

}