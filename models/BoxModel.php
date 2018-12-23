<?php
/**
* This file is part of the holonet flashcards application
 * (c) Matthias Lantsch
 *
 * class file for the Box model
 *
 * @package flashcards
 * @license http://opensource.org/licenses/gpl-license.php  GNU Public License
 * @author  Matthias Lantsch <matthias.lantsch@bluewin.ch>
 */

namespace holonet\flashcards\models;

use holonet\activerecord\ModelBase;

/**
 * box model class
 * a box is defined as an entity that contains multiple flashcards
 * the foreign key in this table is defined as being the user that "owns" the box
 * this user is also able to make changes to the set
 * the box has many flashcards via the "assoc" table
 *
 * @author  matthias.lantsch
 * @package holonet\flashcards\models
 */
class BoxModel extends ModelBase {

	/**
	 * property containing belongsTo relationship mappings
	 *
	 * @access public
	 * @var    array $belongsTo Relationship mappings
	 */
	public static $belongsTo = array("user");

	/**
	 * property containing hasMany relationship mappings
	 *
	 * @access public
	 * @var    array $hasMany Relationship mappings
	 */
	public static $hasMany = array("cards");

	/**
	 * property containing verification data for some of the columns
	 *
	 * @access public
	 * @var    array $validate Array with verification data
	 */
	public static $validate = [
		"name" => array("presence", "length" => ["max" => 255, "min" => 5]),
		"desc" => array("presence")
	];

	/**
	 * special getter method for the individual progress each user has made on this box
	 * returns an integer with a percentage
	 *
	 * @access public
	 * @param  int $idUser The user id for whom the progress is requested
	 * @return progress integer as a percentage how far the user completed this box
	 */
	public function progressOf(int $idUser) {
		$avgTier = AssocModel::avg("tier", array("card.idBox" => $this->id, "idUser" => $idUser));
		if($this->countCards() != 0) {
			return floor(($avgTier / 5) * 100);
		} else {
			return 0;
		}
	}

	/**
	 * small method used to get the count of cards in this box
	 *
	 * @access public
	 * @return integer count of how many cards are in this box
	 */
	public function countCards() {
		return CardModel::count(array("idBox" => $this->id));
	}

	/**
	 * special selection method to return the cards associated with this box
	 * returns an array with the cards ordered by progress of the given user
	 * this is used to show the cards that the user isn't good with yet first
	 *
	 * @access public
	 * @param  int $idUser The user id for whom the progress is requested
	 * @return associative array with the card info as well as the specific user's progress on that card
	 */
	public function getStudySetFor(int $idUser) {
		$ret = [];
		$avgTier = AssocModel::avg("tier", array("card.idBox" => $this->id, "idUser" => $idUser));
		foreach ($this->cards as $card) {
			$cardprogress = $card->progressOf($idUser);
			if($cardprogress !== null) {
				if($cardprogress->tier != 5 || $avgTier == 5) {
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
	 * @access public
	 * @return void
	 */
	public function lastActivity() {
		$this->updatetime = date("Y-m-d H:i:s");
		$this->save();
	}

}
