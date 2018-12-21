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
 * add foreign key reference constraits to the box table
 * 
 * @author  Matthias Lantsch
 * @version {VERSION}
 * @package HIS5\flashcards\db\migrate
 */
class BoxAddReferencesMigration implements activerecord\Migration {

	/**
	 * migration into the up direction
	 */
	public static function up() {
		Schema::changeTable('box', function($t) {
			$t->addReference("user", "idUser", "idUser");
		});
	}

	/**
	 * migration into the down direction
	 */
	public static function down() {
		Schema::changeTable('box', function($t) {
			$t->dropReference("user", "idUser", "idUser");
		});
	}

}