<?php
/**
 * This file is part of the flashcards project
 * (c) Matthias Lantsch
 *
 * procedural file used to create routing entries
 * The order matters, as the first match will be returned
 * There can only be 1 root route.
 * The first match is returned for two routes on the same url
 * example:
 * 	Router::get(array(
 *	  	"url" => "fancy/url",
 *	  	"controller" => "controller",
 *		"method" => "method"
 *	));
 */

use HIS5\holoFW\core\Router as Router;

//LOGIN PAGE
Router::get([
	"url" => "login",
	"controller" => "home",
	"method" => "login"
]);

//LOGIN POST ROUTE (will display the dashboard index page)
Router::post(array(
	"url" => "login",
	"controller" => "user",
	"method" => "index"
));

//BOXCONTROLLER
	//ALL BOXES VIEW
	Router::get(array(
		"url" => "box",
		"controller" => "box",
		"method" => "index"
	));
	//SAVE CHANGES TO A SPECIFIC BOX/NEW BOX
	Router::post(array(
		"url" => "box/save/idBox:?int",
		"controller" => "box",
		"method" => "save"
	));
	//GET AN EDIT FORM/NEW FORM
	Router::get(array(
		"url" => "box/form/idBox:?int",
		"controller" => "box",
		"method" => "form"
	));
	//RESET A USER'S PROGRESS ON A SPECIFIC BOX
	Router::post(array(
		"url" => "box/idBox:int/reset",
		"controller" => "box",
		"method" => "reset"
	));
	//DELETE A BOX
	Router::post(array(
		"url" => "box/idBox:int/delete",
		"controller" => "box",
		"method" => "delete"
	));

	//LIST BOXES LIMITED BY GET PARAMETERS
	Router::get(array(
		"url" => "box/list",
		"controller" => "box",
		"method" => "getList"
	));
	//VIEW BOX CARDS
	Router::get(array(
		"url" => "box/idBox:int/view",
		"controller" => "box",
		"method" => "view"
	));
	//STUDY BOX CARDS
	Router::get(array(
		"url" => "box/idBox:int/study",
		"controller" => "box",
		"method" => "study"
	));
	//SHOW BOX CONTENT
	Router::get(array(
		"url" => "box/idBox:int",
		"controller" => "box",
		"method" => "show"
	));

//USERCONTROLLER
	//INDEX PAGE
	Router::root([
		"controller" => "user",
		"method" => "index"
	]);
	//LISTING METHOD FOR MY OWN BOXES
	Router::any(array(
		"url" => "my",
		"controller" => "user",
		"method" => "listboxes"
	));
	//SHOW BOXES OF A SPECIFIC USER
	Router::any(array(
		"url" => "boxes/idUser:int",
		"controller" => "user",
		"method" => "listboxes"
	));
	//GET AN EDIT/NEW FORM FOR A USER
	Router::any(array(
		"url" => "user/form/idUser:?int",
		"controller" => "user",
		"method" => "form"
	));
	//SAVE CHANGES TO A SPECIFIC USER/NEW USER
	Router::post(array(
		"url" => "user/save/idUser:?int",
		"controller" => "user",
		"method" => "save"
	));
	//DELETE A USER
	Router::post(array(
		"url" => "user/idUser:int/delete",
		"controller" => "user",
		"method" => "delete"
	));

//CARDCONTROLLER
	//GET AN EDIT FORM/NEW FORM
	Router::get(array(
		"url" => "card/form/idCard:?int",
		"controller" => "card",
		"method" => "form"
	));
	//SAVE CHANGES TO A SPECIFIC CARD/NEW CARD
	Router::post(array(
		"url" => "card/save/idCard:?int",
		"controller" => "card",
		"method" => "save"
	));
	//SEND A BACKEND UPDATE
	Router::post(array(
		"url" => "card/idCard:int/update",
		"controller" => "card",
		"method" => "update"
	));
	//DELETE A CARD
	Router::post(array(
		"url" => "card/idCard:int/delete",
		"controller" => "card",
		"method" => "delete"
	));
	//PROFILE PAGE
	Router::any(array(
		"url" => "profile",
		"controller" => "user",
		"method" => "profile"
	));
//ADMIN CONTROLLER
	//INDEX PAGE (USER OVERVIEW)
	Router::any(array(
		"url" => "admin",
		"controller" => "admin",
		"method" => "index"
	));