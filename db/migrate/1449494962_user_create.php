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
 * create the user table
 * 
 * @author  Matthias Lantsch
 * @version {VERSION}
 * @package HIS5\flashcards\db\migrate
 */
class UserCreateMigration implements activerecord\Migration {

	/**
	 * migration into the up direction
	 */
	public static function up() {
		Schema::createTable('user', function($t) {
			$t->string("name")->setSizeDef('40');
			$t->string("email")->setSizeDef('40');
			$t->string("authHash")->setSizeDef('255');
		});
	}

	/**
	 * migration into the down direction
	 */
	public static function down() {
		Schema::dropTable("user");
	}

}