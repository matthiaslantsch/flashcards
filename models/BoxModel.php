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
 * box model class
 * a box is defined as an entity that contains multiple flashcards
 * the foreign key in this table is defined as being the user that "owns" the box
 * this user is also able to make changes to the set
 * the box has many flashcards via the "assoc" table
 * 
 * @author  Matthias Lantsch
 * @version {VERSION}
 * @package HIS5\flashcards\models
 */
class BoxModel extends ar\ModelBase {

	/**
	 * property containing relationship mappings
	 *
	 * @access 	public
	 * @var 	array with relationships
	 */
	public static $relations = [
		"user" => "belongsTo",
		"card" => "canHaveMany"
	];
	
	/**
	 * property containing verification data for some of the columns
	 *
	 * @access 	public
	 * @var 	array with verification data
	 */
	public $valid = [
		"name" => ["presence" => true, "maxLength" => 255, "minLength" => 5],
		"desc" => ["presence" => true]
	];

	/**
	 * special getter method for the individual progress each user has made on this box
	 * returns an integer with a percentage
	 *
	 * @access 	public
	 * @param   integer idUser | the user id for whom the progress is requested
	 * @return  progress integer as a percentage how far the user completed this box
	 */
	public function progressOf($idUser) {
		$sql = "SELECT SUM(tier) AS res, COUNT(idCard) AS numb FROM assoc WHERE idUser = ? AND idCard IN (SELECT idCard FROM card WHERE idBox = ?)";
		$db = ar\connectors\PDODataInterface::init();
		$result = $db->queryRow($sql, [$idUser, $this->id]);
		if($result["numb"] != 0) {
			return floor(($result["res"] / ($result["numb"] * 5)) * 100);
		} else {
			return 0;
		}
	}

	/**
	 * special selection method to return the cards associated with this box
	 * returns an array with the cards ordered by progress of the given user
	 * this is used to show the cards that the user isn't good with yet first
	 *
	 * @access 	public
	 * @param   integer idUser | the user id for whom the progress is requested
	 * @return  associative array with the card info as well as the specific user's progress on that card
	 */
	public function getStudySetFor($idUser) {
		$ret = [];
		foreach ($this->card as $card) {
			$cardprogress = $card->progressOf($idUser);
			if($cardprogress !== null) {
				if($cardprogress->tier != 5) {
					$ret[$cardprogress->tier][] = [
						"idCard" => $card->id,
						"question" => $card->qSide,
						"answer" => $card->aSide,
						"wrongCount" => $cardprogress->wrongC,
						"rightCount" => $cardprogress->corrC,
						"tier" => $cardprogress->tier
					];
				}
			} else {
				$ret[0][] = [
					"idCard" => $card->id,
					"question" => $card->qSide,
					"answer" => $card->aSide,
					"wrongCount" => 0,
					"rightCount" => 0,
					"tier" => 0
				];
			}
		}
		ksort($ret);
		if(count($ret) > 0) {
			return call_user_func_array('array_merge', $ret);
		} else {
			return $ret;
		}
	}

	/**
	 * small helper function updating the last activity timestamp in the database
	 *
	 * @access 	public
	 */
	public function updateTimestamp() {
		$this->updated = date("Y-m-d H:i:s");
		$this->save();
	}

}