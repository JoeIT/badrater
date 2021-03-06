<?php

include_once('object_db_interact.php');

class ObjDeptor extends ObjectDbInteract
{
	const DB_TABLE = 'deptor';
	
	// True is this item object is not save into the db
	private $is_new = true;
	private $id;
	
	public $name;
	public $info;
		
	public function __construct($id = '')
	{
		// If id is empty, then is a new item, otherwise get the item from the DB
		if(!empty($id))
			$this->get_item_from_db($id);
	}
	
	// Allows if the item exists in the db, the data is load into the variables of this object
	protected function get_item_from_db($item_id)
	{
		$query = 'SELECT id, name, info 
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
			$this->name = $row['name'];
			$this->info = $row['info'];
			
			$this->is_new = false;
		}
		
		mysqli_free_result($resulSet);
	}
	
	// Clean all the values of the item object
	protected function reset_values()
	{
		$this->id = null;
		$this->name = null;
		$this->info = null;
		
		$this->is_new = true;
	}
	
	public function get_id()
	{
		return $this->id;
	}
	
	// Save the deptor item into the database
	public function save()
	{
		// Starting db conectivity
		$bd = DbConnectivity::getInstance();
		
		
		// Data filtering
		$this->name = mysqli_real_escape_string($bd->getLink(), $this->name);
		$this->info = mysqli_real_escape_string($bd->getLink(), $this->info);
	
		if($this->is_new)
			$query = 'INSERT INTO '.self::DB_TABLE." (name, info) 
					VALUES ('$this->name', '$this->info')";
		else
			$query = 'UPDATE '.self::DB_TABLE.
					" SET 
							name = '$this->name',
							info = '$this->info'
					WHERE id = $this->id";
		
		
		return $bd->query($query);
	}
	
	// Save the deptor item into the database
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
			[name] => $this->name,
			[info] => $this->info
			<br />";
	}
	
} // End ObjDeptor class

?>