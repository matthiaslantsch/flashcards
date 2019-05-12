<?php
# encoding: UTF-8
# This file is auto-generated from the current state of the database. Instead
# of editing this file, please use the migrations feature of Active Record to
# incrementally modify your database, and then regenerate this schema definition.
#
# Note that this schema.php definition is the main source for your
# database schema. To recreate the database, do not run all migrations, use the
# db/schema::load task
#
# It's strongly recommended that you check this file into your version control system.

use holonet\activerecord\Schema;

##
## user #
##
Schema::createTable("user", function($table) {
	$table->string("name", 40);
	$table->integer("sphinx_id");
	$table->version("1449494962");
});

##
## box #
##
Schema::createTable("box", function($table) {
	$table->string("name");
	$table->text("desc");
	$table->integer("idUser");
	$table->timestamps();
	$table->version("1449494963");
});

##
## card #
##
Schema::createTable("card", function($table) {
	$table->text("qSide");
	$table->text("aSide");
	$table->integer("idBox");
	$table->version("1449494964");
});

##
## assoc #
##
Schema::createTable("assoc", function($table) {
	$table->integer("wrongC")->default(0);
	$table->integer("corrC")->default(0);
	$table->integer("tier")->default(5);
	$table->integer("idCard")->unique();
	$table->integer("idUser");
	$table->integer("lasttier")->default(0);
	$table->version("1557649020");
});

##
## box references #
##
Schema::changeTable("box", function($table) {
	$table->addReference("user", "idUser", "idUser");
	$table->version("1449494963");
});

##
## card references #
##
Schema::changeTable("card", function($table) {
	$table->addReference("box", "idBox", "idBox");
	$table->version("1449494964");
});

##
## assoc references #
##
Schema::changeTable("assoc", function($table) {
	$table->addReference("card", "idCard", "idCard");
	$table->addReference("user", "idUser", "idUser");
	$table->version("1557649020");
});