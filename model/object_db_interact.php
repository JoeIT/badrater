<?php

include_once('db_connectivity.php');

abstract class ObjectDbInteract
{
	// Gets the data objtect from the db
	abstract protected function get_item_from_db($item_id);
	// Clean all the values of the item object
	abstract protected function reset_values();
	//
	abstract public function get_id();
	
	// Saves the data object to the db
	abstract public function save();
	// Removes the data object to the db
	abstract public function remove();
	// Prints the data object in the screen
	abstract public function toString();
}

?>