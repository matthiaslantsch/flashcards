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
 * create the box table
 * 
 * @author  Matthias Lantsch
 * @version {VERSION}
 * @package HIS5\flashcards\db\migrate
 */
class BoxCreateMigration implements activerecord\Migration {

	/**
	 * migration into the up direction
	 */
	public static function up() {
		Schema::createTable('box', function($t) {
			$t->string("name")->setSizeDef('255');
			$t->text("desc");
			$t->datetime("created");
			$t->datetime("updated");
		});
	}

	/**
	 * migration into the down direction
	 */
	public static function down() {
		Schema::dropTable("box");
	}

}