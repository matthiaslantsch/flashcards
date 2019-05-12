<?php
# This file should contain all the record creation needed to seed the database with its default values.
# The data can then be loaded with the db/schema::seed or with the complete db/schema::setup task
#
# Examples:
#
#   $stones = models\StoneModel::create(array("name" => "a stone"));

use holonet\flashcards\models\UserModel;
use holonet\flashcards\models\BoxModel;

require_once "demo".DIRECTORY_SEPARATOR."demo.php";

$i = 1;

while ($i < 100) {
	$newBox = BoxModel::create([
		"name" => "Box no $i",
		"desc" => "Box no $i desc",
		"idUser" => UserModel::first()->id
	], true);
	$i++;
}
