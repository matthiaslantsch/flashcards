<?php
# This file contains sample data that will be used for demo purposes
# This is only going to be loaded if the application is in a demo state
# The data can then be loaded with the db/schema::seed or with the complete db/schema::setup task
#
# Examples:
#
#   $stones = models\StoneModel::create(array("name" => "a stone"));

use holonet\flashcards\models\UserModel;
use holonet\flashcards\models\BoxModel;
use holonet\flashcards\models\CardModel;

UserModel::create(["name" => "Hanspeter", "sphinx_id" => 1], true);
loadSampleCsv("Hanspeter");

UserModel::create(["name" => "Jean", "sphinx_id" => 2], true);
loadSampleCsv("Jean");

UserModel::create(["name" => "Kim Wong", "sphinx_id" => 3], true);
loadSampleCsv("Kim Wong");

function loadSampleCsv($name) {
	$glob = __DIR__.DIRECTORY_SEPARATOR.strtolower(str_replace(" ", "", $name)).DIRECTORY_SEPARATOR."*.csv";
	foreach (glob($glob) as $csvFile) {
		$file = file_get_contents($csvFile);
		$lines = explode("\n", $file);
		$setName = strstr(basename($csvFile), ".", true);
		$newBox = BoxModel::create([
			"name" => $setName,
			"desc" => $setName,
			"idUser" => UserModel::get(array("name" => $name))->id
		], true);

		foreach ($lines as $line) {
			$line = explode(",", $line);
			CardModel::create([
				"qSide" => $line[0],
				"aSide" => $line[1],
				"idBox" => $newBox->id
			], true);
		}
	}
}
