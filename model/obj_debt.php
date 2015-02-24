<?php

include_once('object_db_interact.php');

class ObjDebt extends ObjectDbInteract
{
	const DB_TABLE = 'debt';
	
	// True is this item object is not save into the db
	private $is_new = true;
	private $id;
	
	public $shop_id;
	public $deptor_id;
	public $date;
	public $description;
	public $bs;
	public $sus;
	
		
	public function __construct($id = '')
	{
		// If id is empty, then is a new item, otherwise get the item from the DB
		if(!empty($id))
			$this->get_item_from_db($id);
	}
	
	// Allows if the item exists in the db, the data is load into the variables of this object
	protected function get_item_from_db($item_id)
	{
		$query = 'SELECT id, shop_id, deptor_id, date, description, bs, sus 
				FROM '.self::DB_TABLE.
				" WHERE id = $item_id";
		
		$bd = DbConnectivity::getInstance();
		
		if(!($resulSet = $bd->query($query)))
			return false;
		
		$row = mysqli_fetch_assoc($resulSet);
		
		// If the resultset is not an empty array
		if(!empty($row))
		{
			$this->id = $row['id'];
			$this->shop_id = $row['shop_id'];
			$this->deptor_id = $row['deptor_id'];
			$this->date = $row['date'];
			$this->description = $row['description'];
			$this->bs = $row['bs'];
			$this->sus = $row['sus'];
			
			$this->is_new = false;
		}
		
		mysqli_free_result($resulSet);
	}
	
	// Clean all the values of the item object
	protected function reset_values()
	{
		$this->id = null;
		$this->shop_id = null;
		$this->deptor_id = null;
		$this->date = null;
		$this->description = null;
		$this->bs = null;
		$this->sus = null;
		
		$this->is_new = true;
	}
	
	public function get_id()
	{
		return $this->id;
	}
	
	// Save the debt item into the database
	public function save()
	{
		// Starting db conectivity
		$bd = DbConnectivity::getInstance();
		
		
		// Data filtering
		$this->shop_id = mysqli_real_escape_string($bd->getLink(), $this->shop_id);
		$this->deptor_id = mysqli_real_escape_string($bd->getLink(), $this->deptor_id);
		$this->date = mysqli_real_escape_string($bd->getLink(), $this->date);
		$this->description = mysqli_real_escape_string($bd->getLink(), $this->description);
		$this->bs = mysqli_real_escape_string($bd->getLink(), $this->bs);
		$this->sus = mysqli_real_escape_string($bd->getLink(), $this->sus);
	
		if($this->is_new)
			$query = 'INSERT INTO '.self::DB_TABLE." (shop_id, deptor_id, date, description, bs, sus) 
					VALUES ('$this->shop_id', '$this->deptor_id', '$this->date', '$this->description', '$this->bs', '$this->sus')";
		else
			$query = 'UPDATE '.self::DB_TABLE.
					" SET 
							shop_id = '$this->shop_id', 
							deptor_id = '$this->deptor_id', 
							date = '$this->date', 
							description = '$this->description', 
							bs = '$this->bs', 
							sus = '$this->sus'
					WHERE id = $this->id";
		
		
		return $bd->query($query);
	}
	
	// Save the debt item into the database
	public function remove()
	{
		if(!$this->is_new)
		{
			$query = 'DELETE FROM '.self::DB_TABLE." WHERE id = $this->id";
			
			$bd = DbConnectivity::getInstance();
			
			if(!$bd->query($query))
				return false;
		}
		
		$this->reset_values();
		return true;
	}
	
	public function toString()
	{
		echo "[id] => $this->id,
			[shop_id] => $this->shop_id, 
			[deptor_id] => $this->deptor_id, 
			[date] => $this->date, 
			[description] => $this->description, 
			[bs] => $this->bs, 
			[sus] => $this->sus
			<br />";
	}
	
} // End ObjDebt class

?>