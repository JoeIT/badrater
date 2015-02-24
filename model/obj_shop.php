<?php

include_once('object_db_interact.php');

class ObjShop extends ObjectDbInteract
{
	const DB_TABLE = 'shop';
	
	// True is this item object is not save into the db
	private $is_new = true;
	private $shop_id;
	
	public $shop_name;
	public $shop_info;
	
	public function __construct($id = '')
	{
		// If id is empty, then is a new item, otherwise get the item from the DB
		if(!empty($id))
			$this->get_item_from_db($id);
	}
	
	// Allows if the item exists in the db, the data is load into the variables of this object
	protected function get_item_from_db($item_id)
	{
		$query = 'SELECT shop_id, shop_name, shop_info 
				FROM '.self::DB_TABLE.
				" WHERE shop_id = $item_id";
		
		$bd = DbConnectivity::getInstance();
		
		if(!($resulSet = $bd->query($query)))
			return false;
		
		$row = mysqli_fetch_assoc($resulSet);
		
		// If the resultset is not an empty array
		if(!empty($row))
		{
			$this->shop_id = $row['shop_id'];
			$this->shop_name = $row['shop_name'];
			$this->shop_info = $row['shop_info'];
			
			$this->is_new = false;
		}
		
		mysqli_free_result($resulSet);
	}
	
	// Clean all the values of the item object
	protected function reset_values()
	{
		$this->shop_id = null;
		$this->shop_name = null;
		$this->shop_info = null;
		
		$this->is_new = true;
	}
	
	public function get_id()
	{
		return $this->shop_id;
	}
	
	// Save the shop item into the database
	public function save()
	{
		// Starting db conectivity
		$bd = DbConnectivity::getInstance();
		
		
		// Data filtering
		$this->shop_name = mysqli_real_escape_string($bd->getLink(), $this->shop_name);
		$this->shop_info = mysqli_real_escape_string($bd->getLink(), $this->shop_info);
	
		if($this->is_new)
			$query = 'INSERT INTO '.self::DB_TABLE." (shop_name, shop_info) 
					VALUES ('$this->shop_name', '$this->shop_info')";
		else
			$query = 'UPDATE '.self::DB_TABLE.
					" SET 
						shop_name = '$this->shop_name',
						shop_info = '$this->shop_info' 
					WHERE shop_id = $this->shop_id";
		
		if( $bd->query($query) )
		{
			$this->shop_id = $bd->getLastInsertedId();
			$this->is_new = false;
			return true;
		}
		else
			return false;
	}
	
	// Save the shop item into the database
	public function remove()
	{
		if(!$this->is_new)
		{
			$query = 'DELETE FROM '.self::DB_TABLE." WHERE shop_id = $this->shop_id";
			
			$bd = DbConnectivity::getInstance();
			
			if(!$bd->query($query))
				return false;
		}
		
		$this->reset_values();
		return true;
	}
	
	public function toString()
	{
		echo "[shop_id] => $this->shop_id,
			[shop_name] => $this->shop_name,
			[shop_info] => $this->shop_info
			<br />";
	}
	
} // End ObjShop class

?>