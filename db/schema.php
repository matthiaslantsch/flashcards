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

use HIS5\lib\activerecord\Schema as Schema;

##
## assoc #
##
Schema::createTable('assoc', function($t) {
	$t->integer("wrongC")->setDefault('0');
	$t->integer("corrC")->setDefault('0');
	$t->integer("tier")->setDefault('5');
	$t->version("1470654981");
});

##
## authtoken #
##
Schema::createTable('authtoken', function($t) {
	$t->string("selector")->setSizeDef('12');
	$t->string("token")->setSizeDef('64');
	$t->datetime("expires");
	$t->version("1470905959");
});

##
## box #
##
Schema::createTable('box', function($t) {
	$t->string("name")->setSizeDef('255');
	$t->text("desc");
	$t->datetime("created");
	$t->timestamp("updated")->setDefault('CURRENT_TIMESTAMP');
	$t->version("1470654982");
});

##
## card #
##
Schema::createTable('card', function($t) {
	$t->text("qSide");
	$t->text("aSide");
	$t->version("1470654979");
});

##
## permission #
##
Schema::createTable('permission', function($t) {
	$t->string("permission")->setSizeDef('40');
	$t->version("1449494964");
});

##
## user #
##
Schema::createTable('user', function($t) {
	$t->string("name")->setSizeDef('40');
	$t->string("email")->setSizeDef('40');
	$t->string("authHash")->setSizeDef('255');
	$t->version("1449494962");
});

##
## userGroup #
##
Schema::createTable('userGroup', function($t) {
	$t->string("name")->setSizeDef('40');
	$t->version("1449494963");
});

##
## permission2user #
##
Schema::createResolutionTable('permission', 'user', '1449494965');


##
## permission2userGroup #
##
Schema::createResolutionTable('permission', 'userGroup', '1449494967');


##
## user2userGroup #
##
Schema::createResolutionTable('user', 'userGroup', '1449494966');


##
## assoc references #
##
Schema::changeTable('assoc', function($t) {
	$t->addReference("card", "idCard", "idCard");
	$t->addReference("user", "idUser", "idUser");
	$t->version("1470654981");
});

##
## authtoken references #
##
Schema::changeTable('authtoken', function($t) {
	$t->addReference("user", "idUser", "idUser");
	$t->version("1470905959");
});

##
## box references #
##
Schema::changeTable('box', function($t) {
	$t->addReference("user", "idUser", "idUser");
	$t->version("1470654982");
});

##
## card references #
##
Schema::changeTable('card', function($t) {
	$t->addReference("box", "idBox", "idBox");
	$t->version("1470654979");
});