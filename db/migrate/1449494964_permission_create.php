<?php
/**
 * This file is part of the flashcards project
 * (c) Matthias Lantsch
 *
 * migration class file
 */

namespace HIS5\flashcards\db\migrate;

use HIS5\lib\activerecord as activerecord;
use HIS5\lib\activerecord\Schema as Schema;

/**
 * the permission table is used by the standard database auth mechanism
 * 
 * @author  {AUTHOR}
 * @version {VERSION}
 * @package HIS5\flashcards\db\migrate
 */
class PermissionCreateMigration implements activerecord\Migration {

	/**
	 * migration into the up direction
	 */
	public static function up() {
		Schema::createTable("permission", function($t) {
			$t->string("permission", 40)->unique();
		});
	}

	/**
	 * migration into the down direction
	 */
	public static function down() {
		Schema::dropTable("permission");
	}

}