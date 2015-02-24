<?php

include_once('object_db_interact.php');

class ObjTyre extends ObjectDbInteract
{
	const DB_TABLE = 'tyre';
	
	// True is this item object is not save into the db
	private $is_new = true;
	private $tyre_id;
	
	public $tyre_brand;
	public $tyre_size;
	public $tyre_code;
	
	public function __construct($id = '')
	{
		// If id is empty, then is a new item, otherwise get the item from the DB
		if(!empty($id))
			$this->get_item_from_db($id);
	}
	
	// Allows if the item exists in the db, the data is load into the variables of this object
	protected function get_item_from_db($item_id)
	{
		$query = 'SELECT tyre_id, tyre_brand, tyre_size, tyre_code 
				FROM '.self::DB_TABLE.
				" WHERE tyre_id = $item_id";
		
		$bd = DbConnectivity::getInstance();
		
		if(!($resulSet = $bd->query($query)))
			return false;
		
		$row = mysqli_fetch_assoc($resulSet);
		
		// If the resultset is not an empty array
		if(!empty($row))
		{
			$this->tyre_id = $row['tyre_id'];
			$this->tyre_brand = $row['tyre_brand'];
			$this->tyre_size = $row['tyre_size'];
			$this->tyre_code = $row['tyre_code'];
			
			$this->is_new = false;
		}
		
		mysqli_free_result($resulSet);
	}
	
	// Clean all the values of the item object
	protected function reset_values()
	{
		$this->tyre_id = null;
		$this->tyre_brand = null;
		$this->tyre_size = null;
		$this->tyre_code = null;
		
		$this->is_new = true;
	}
	
	public function get_id()
	{
		return $this->tyre_id;
	}
	
	// Save the tyre item into the database
	public function save()
	{
		// Starting db conectivity
		$bd = DbConnectivity::getInstance();
		
		// Data filtering
		$this->tyre_brand = mysqli_real_escape_string($bd->getLink(), $this->tyre_brand);
		$this->tyre_size = mysqli_real_escape_string($bd->getLink(), $this->tyre_size);
		$this->tyre_code = mysqli_real_escape_string($bd->getLink(), $this->tyre_code);
		
		if($this->is_new)
			$query = 'INSERT INTO '.self::DB_TABLE." (tyre_brand, tyre_size, tyre_code) 
					VALUES ('$this->tyre_brand', '$this->tyre_size', '$this->tyre_code')";
		else
			$query = 'UPDATE '.self::DB_TABLE.
					" SET 
							tyre_brand = '$this->tyre_brand',
							tyre_size = '$this->tyre_size',
							tyre_code = '$this->tyre_code' 
					WHERE tyre_id = $this->tyre_id";
		
		
		return $bd->query($query);
	}
	
	// Save the tyre item into the database
	public function remove()
	{
		if(!$this->is_new)
		{
			$query = 'DELETE FROM '.self::DB_TABLE." WHERE tyre_id = $this->tyre_id";
			
			$bd = DbConnectivity::getInstance();
			
			if(!$bd->query($query))
				return false;
		}
		
		$this->reset_values();
		return true;
	}
	
	public function toString()
	{
		echo "[tyre_id] => $this->tyre_id,
			[tyre_brand] => $this->tyre_brand,
			[tyre_size] => $this->tyre_size,
			[tyre_code] => $this->tyre_code
			<br />";
	}
	
} // End ObjTyres class

?>