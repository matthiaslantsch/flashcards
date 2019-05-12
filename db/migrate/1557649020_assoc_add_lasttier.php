<?php
/**
 * This file is part of the holonet flashcards application
 * (c) Matthias Lantsch
 *
 * class file for a migration to add a lasttier field to the assoc table
 *
 * @package holonet flashcards app
 * @license http://www.wtfpl.net/ Do what the fuck you want Public License
 * @author  Matthias Lantsch <matthias.lantsch@bluewin.ch>
 */

namespace holonet\flashcards\db\migrate;

use holonet\activerecord\Migration;
use holonet\activerecord\Schema;

/**
 * add a lasttier field to the assoc table
 *
 * @author  matthias.lantsch
 * @package holonet\flashcards\db\migrate
 */
class AssocAddLasttierMigration implements Migration {

	/**
	 * migration into the up direction
	 */
	public static function up() {
		Schema::changeTable('assoc', function($t) {
			$t->integer("lasttier")->default(0);
		});
	}

	/**
	 * migration into the down direction
	 */
	public static function down() {
		Schema::changeTable('assoc', function($t) {
			$t->dropColumn("lasttier");
		});
	}

}
