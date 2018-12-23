<?php
/**
* This file is part of the holonet flashcards application
 * (c) Matthias Lantsch
 *
 * class file for the Card model
 * @package flashcards
 * @license http://opensource.org/licenses/gpl-license.php  GNU Public License
 * @author  Matthias Lantsch <matthias.lantsch@bluewin.ch>
 */

namespace holonet\flashcards\models;

use holonet\activerecord\ModelBase;

/**
 * card model class
 * a card is defined as a flashcard with 2 sides,
 * one containing the "question" and the other one the "answer"
 *
 * @author  matthias.lantsch
 * @package holonet\flashcards\models
 */
class CardModel extends ModelBase {

	/**
	 * property containing hasMany relationship mappings
	 *
	 * @access public
	 * @var    array $hasMany Relationship mappings
	 */
	public static $hasMany = array("assocs");

	/**
	 * property containing belongsTo relationship mappings
	 *
	 * @access public
	 * @var    array $belongsTo Relationship mappings
	 */
	public static $belongsTo = array("box");

	/**
	 * property containing verification data for some of the columns
	 *
	 * @access public
	 * @var    array $validate Array with verification data
	 */
	public static $validate = [
		"qSide" => ["presence"],
		"aSide" => ["presence"]
	];

	/**
	 * special getter method for the individual progress each user has made on this card
	 * returns an instance of AssocModel if the user has ever done anything with this card
	 *
	 * @access public
	 * @param  integer $idUser The user id for whom the progress is requested
	 * @return AssocModel instance for the given card and user if that relation exists
	 */
	public function progressOf(int $idUser) {
		if($idUser === null) {
			return null;
		}

		return AssocModel::get(array("idCard" => $this->id, "idUser" => $idUser));
	}

}
