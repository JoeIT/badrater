<?php

include_once('object_db_interact.php');

class ObjStore extends ObjectDbInteract
{
	const DB_TABLE = 'store';
	
	// True is this item object is not save into the db
	private $is_new = true;
	private $store_id;
	
	public $store_name;
	public $store_virtual;
	public $store_info;
	
	public function __construct($id = '')
	{
		// If id is empty, then is a new item, otherwise get the item from the DB
		if(!empty($id))
			$this->get_item_from_db($id);
	}
	
	// Allows if the item exists in the db, the data is load into the variables of this object
	protected function get_item_from_db($item_id)
	{
		$query = 'SELECT store_id, store_name, store_virtual, store_info 
				FROM '.self::DB_TABLE.
				" WHERE store_id = $item_id";
		
		$bd = DbConnectivity::getInstance();
		
		if(!($resulSet = $bd->query($query)))
			return false;
		
		$row = mysqli_fetch_assoc($resulSet);
		
		// If the resultset is not an empty array
		if(!empty($row))
		{
			$this->store_id = $row['store_id'];
			$this->store_name = $row['store_name'];
			$this->store_virtual = $row['store_virtual'];
			$this->store_info = $row['store_info'];
			
			$this->is_new = false;
		}
		
		mysqli_free_result($resulSet);
	}
	
	// Clean all the values of the item object
	protected function reset_values()
	{
		$this->store_id = null;
		$this->store_name = null;
		$this->store_virtual = null;
		$this->store_info = null;
		
		$this->is_new = true;
	}
	
	public function get_id()
	{
		return $this->store_id;
	}
	
	// Save the store item into the database
	public function save()
	{
		// Starting db conectivity
		$bd = DbConnectivity::getInstance();
		
		
		// Data filtering
		$this->store_name = mysqli_real_escape_string($bd->getLink(), $this->store_name);
		$this->store_virtual = mysqli_real_escape_string($bd->getLink(), $this->store_virtual);
		$this->store_info = mysqli_real_escape_string($bd->getLink(), $this->store_info);
	
		if($this->is_new)
			$query = 'INSERT INTO '.self::DB_TABLE." (store_name, store_virtual, store_info) 
					VALUES ('$this->store_name',"
							.(!empty($this->store_virtual) ? "'$this->store_virtual'" : "null").",
							'$this->store_info')";
		else
			$query = 'UPDATE '.self::DB_TABLE.
					" SET 
						store_name = '$this->store_name',
						store_virtual = ".(!empty($this->store_virtual) ? "'$this->store_virtual'" : "null").",
						store_info = '$this->store_info' 
					WHERE store_id = $this->store_id";
		
		if( $bd->query($query) )
		{
			$this->store_id = $bd->getLastInsertedId();
			$this->is_new = false;
			return true;
		}
		else
			return false;
	}
	
	// Save the store item into the database
	public function remove()
	{
		if(!$this->is_new)
		{
			$query = 'DELETE FROM '.self::DB_TABLE." WHERE store_id = $this->store_id";
			
			$bd = DbConnectivity::getInstance();
			
			if(!$bd->query($query))
				return false;
		}
		
		$this->reset_values();
		return true;
	}
	
	public function toString()
	{
		echo "[store_id] => $this->store_id,
			[store_name] => $this->store_name,
			[store_virtual] => $this->store_virtual,
			[store_info] => $this->store_info
			<br />";
	}
	
} // End ObjStore class

?>