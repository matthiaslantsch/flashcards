<?php
/**
 * This file is part of the holonet flashcards application
 * (c) Matthias Lantsch
 *
 * class file for a migration to create the box table
 *
 * @package holonet flashcards app
 * @license http://www.wtfpl.net/ Do what the fuck you want Public License
 * @author  Matthias Lantsch <matthias.lantsch@bluewin.ch>
 */

namespace holonet\flashcards\db\migrate;

use holonet\activerecord\Migration;
use holonet\activerecord\Schema;

/**
 * create the box table
 *
 * @author  matthias.lantsch
 * @package holonet\flashcards\db\migrate
 */
class BoxCreateMigration implements Migration {

	/**
	 * migration into the up direction
	 */
	public static function up() {
		Schema::createTable('box', function($t) {
			$t->string("name")->size('255');
			$t->text("desc");
			$t->timestamps();
			$t->addReference("user");
		});
	}

	/**
	 * migration into the down direction
	 */
	public static function down() {
		Schema::dropTable("box");
	}

}
