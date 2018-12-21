<?php
# This file contains sample data that will be used for demo purposes
# This is only going to be loaded if the application is in a demo state
# The data can then be loaded with the db/schema::seed or with the complete db/schema::setup task
#
# Examples:
#
#   $stones = models\StoneModel::create(array("name" => "a stone"));
use HIS5\lib\Common as co;
use HIS5\flashcards\models as models;
use HIS5\holoFW\models as hmodels;

$perms[] = hmodels\PermissionModel::create(["permission" => "HN_PERM_WEB_FLASHCARDS_USER_*"]);
$perms[] = hmodels\PermissionModel::create(["permission" => "HN_PERM_WEB_FLASHCARDS_BOX_*"]);
$perms[] = hmodels\PermissionModel::create(["permission" => "HN_PERM_WEB_FLASHCARDS_CARD_*"]);

models\UserModel::create([
	"name" => "Hanspeter",
	"email" => "hanspeter@localhost",
	"password" => "hanspeter@flashcard2016NO",
	"permission" => $perms
]);

loadSampleCsv("Hanspeter");

models\UserModel::create([
	"name" => "Jean",
	"email" => "jean@localhost",
	"password" => "jean@flashcard2016NO",
	"permission" => $perms
]);

loadSampleCsv("jean");

models\UserModel::create([
	"name" => "Kim Wong",
	"email" => "kimwong@localhost",
	"password" => "kimwong@flashcard2016NO",
	"permission" => $perms
]);

loadSampleCsv("Kim Wong");

models\UserModel::create([
	"name" => "user",
	"email" => "user@localhost",
	"password" => "user@flashcard2016",
	"permission" => $perms
]);

$perms[] = hmodels\PermissionModel::create(["permission" => "HN_PERM_WEB_FLASHCARDS_ADMIN_*"]);

models\UserModel::create([
	"name" => "admin",
	"email" => "admin@localhost",
	"password" => "admin@flashcard2016",
	"permission" => $perms
]);

function loadSampleCsv($name) {
	$glob = __DIR__.DIRECTORY_SEPARATOR.strtolower(str_replace(" ", "", $name)).DIRECTORY_SEPARATOR."*.csv";
	foreach (glob($glob) as $csvFile) {
		$file = file_get_contents($csvFile);
		$lines = explode("\n", $file);
		$setName = strstr(basename($csvFile), ".", true);
		$newBox = models\BoxModel::create([
			"name" => $setName,
			"desc" => $setName,
			"idUser" => models\UserModel::findBy("name = ?", $name)->id,
			"created" =>  date("Y-m-d H:i:s")
		]);

		foreach ($lines as $line) {
			$line = explode(",", $line);
			models\CardModel::create([
				"qSide" => $line[0],
				"aSide" => $line[1],
				"idBox" => $newBox->id
			]);
		}
	}
}