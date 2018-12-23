<?php
/**
 * This file is part of the holonet flashcards application
 * (c) Matthias Lantsch
 *
 * class file for a migration to create the user table
 *
 * @package holonet flashcards app
 * @license http://www.wtfpl.net/ Do what the fuck you want Public License
 * @author  Matthias Lantsch <matthias.lantsch@bluewin.ch>
 */

namespace holonet\flashcards\db\migrate;

use holonet\activerecord\Migration;
use holonet\activerecord\Schema;

/**
 * create the user table
 *
 * @author  matthias.lantsch
 * @package holonet\hblog\db\migrate
 */
class UserCreateMigration implements Migration {

	/**
	 * migration into the up direction
	 */
	public static function up() {
		Schema::createTable('user', function($t) {
			$t->string("name")->size('40');
			$t->integer("sphinx_id");
		});
	}

	/**
	 * migration into the down direction
	 */
	public static function down() {
		Schema::dropTable("user");
	}

}
