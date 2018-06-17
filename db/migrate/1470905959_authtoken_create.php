<?php
/**
 * This file is part of the flashcards project
 * (c) Matthias Lantsch
 *
 * migration class file for authtoken
 */

namespace HIS5\flashcards\db\migrate;

use HIS5\lib\activerecord as activerecord;
use HIS5\lib\activerecord\Schema as Schema;

/**
 * create the authtoken table
 * 
 * @author  Matthias Lantsch
 * @version {VERSION}
 * @package HIS5\flashcards\db\migrate
 */
class AuthtokenCreateMigration implements activerecord\Migration {

	/**
	 * migration into the up direction
	 */
	public static function up() {
		Schema::createTable('authtoken', function($t) {
			$t->string("selector")->setSizeDef('12');
			$t->string("token")->setSizeDef('64');
			$t->datetime("expires");
			$t->addReference("user", "idUser", "idUser");
		});
	}

	/**
	 * migration into the down direction
	 */
	public static function down() {
		Schema::dropTable("authtoken");
	}
}