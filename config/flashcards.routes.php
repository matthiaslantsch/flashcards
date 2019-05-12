<?php
/**
* This file is part of the holonet flashcards application
 * (c) Matthias Lantsch
 *
 * php route definition file
 *
 * @package flashcards
 * @license http://www.wtfpl.net/ Do what the fuck you want Public License
 * @author  Matthias Lantsch <matthias.lantsch@bluewin.ch>
 */

use holonet\holofw\FWRouter;

//Homepage of the app
FWRouter::index(array(
	"controller" => "user",
	"method" => "index"
));

//personal profile page with options
FWRouter::get(array(
	"url" => "profile",
	"controller" => "user",
	"method" => "profile"
));

//page showing the boxes of the current user
FWRouter::get(array(
	"url" => "my",
	"controller" => "user",
	"method" => "listboxes"
));

//page showing the boxes of any user
FWRouter::get(array(
	"url" => "user/[idUser:i]",
	"controller" => "user",
	"method" => "listboxes"
));

//backend method that can be used to delete a user
FWRouter::delete(array(
	"url" => "user/[idUser:i]",
	"controller" => "user",
	"method" => "delete"
));

//admin backend that can be used to delete user entries
FWRouter::get(array(
	"url" => "admin",
	"controller" => "admin",
	"method" => "index"
));

//expose the REST resource "box" to the application user
FWRouter::resource("box");

//backend api to get a list of botxes that accepts certain parameters
FWRouter::get(array(
	"url" => "boxes/api",
	"controller" => "boxes",
	"method" => "boxApi"
));

//some more boxes related routes
FWRouter::with("boxes/[id:i]", function($builder) {
	//backend that can be used to reset a users process for a certain box
	$builder->post(array(
		"url" => "reset",
		"controller" => "boxes",
		"method" => "reset"
	));
	//backend that can be used to reset a users process for a certain box
	$builder->post(array(
		"url" => "reset",
		"controller" => "boxes",
		"method" => "reset"
	));
	//show a carousell with all the cards in the box
	$builder->get(array(
		"url" => "view",
		"controller" => "boxes",
		"method" => "view"
	));
	//study interface for the user to study the cards
	$builder->get(array(
		"url" => "study",
		"controller" => "boxes",
		"method" => "study"
	));
	//choice interface for multiple choice training
	$builder->get(array(
		"url" => "choice",
		"controller" => "boxes",
		"method" => "choice"
	));
});

//the card is so to speak a "sub" REST resource below the box
FWRouter::with("boxes/[idBox:i]/cards", function($builder) {
	//post to create a new card
	$builder->post(array(
		"url" => "",
		"controller" => "cards",
		"method" => "create"
	));
	//put to save an edit to an existing card
	$builder->put(array(
		"url" => "[idCard:i]",
		"controller" => "cards",
		"method" => "update"
	));
	//delete a card
	$builder->delete(array(
		"url" => "[idCard:i]",
		"controller" => "cards",
		"method" => "delete"
	));
	//send an update about the learning process of a user with a certain card
	$builder->post(array(
		"url" => "[idCard:i]/update",
		"controller" => "cards",
		"method" => "cardUpdate"
	));

});
