<?php
/**
 * This file is part of the flashcard project
 * (c) Matthias Lantsch
 *
 * database schema migration class file
 */

namespace HIS5\flashcards\db\migrate;

use HIS5\lib\activerecord as activerecord;
use HIS5\lib\activerecord\Schema as Schema;

/**
 * create the card table
 * 
 * @author  Matthias Lantsch
 * @version {VERSION}
 * @package HIS5\flashcards\db\migrate
 */
class CardCreateMigration implements activerecord\Migration {

	/**
	 * migration into the up direction
	 */
	public static function up() {
		Schema::createTable('card', function($t) {
			$t->text("qSide");
			$t->text("aSide");
			$t->addReference("box", "idBox", "idBox");
		});
	}

	/**
	 * migration into the down direction
	 */
	public static function down() {
		Schema::dropTable("card");
	}

}