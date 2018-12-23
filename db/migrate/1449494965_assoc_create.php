<?php
/**
 * This file is part of the holonet flashcards application
 * (c) Matthias Lantsch
 *
 * class file for a migration to create the assoc table
 *
 * @package holonet flashcards app
 * @license http://www.wtfpl.net/ Do what the fuck you want Public License
 * @author  Matthias Lantsch <matthias.lantsch@bluewin.ch>
 */

namespace holonet\flashcards\db\migrate;

use holonet\activerecord\Migration;
use holonet\activerecord\Schema;

/**
 * create the assoc table
 *
 * @author  matthias.lantsch
 * @package holonet\hblog\db\migrate
 */
class AssocCreateMigration implements Migration {

	/**
	 * migration into the up direction
	 */
	public static function up() {
		Schema::createTable('assoc', function($t) {
			$t->integer("wrongC")->default(0);
			$t->integer("corrC")->default(0);
			$t->integer("tier")->default(5);
			$t->addReference("card");
			$t->addReference("user");
			$t->addUnique("idCard", "idUser");
		});
	}

	/**
	 * migration into the down direction
	 */
	public static function down() {
		Schema::dropTable("assoc");
	}

}
