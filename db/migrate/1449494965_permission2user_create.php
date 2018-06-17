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
 * the permission2user table is used by the standard database auth mechanism
 * 
 * @author  {AUTHOR}
 * @version {VERSION}
 * @package HIS5\flashcards\db\migrate
 */
class Permission2UserCreateMigration implements activerecord\Migration {

	/**
	 * migration into the up direction
	 */
	public static function up() {
		Schema::createResolutionTable("permission", "user");
	}

	/**
	 * migration into the down direction
	 */
	public static function down() {
		Schema::dropTable("permission2user");
	}

}