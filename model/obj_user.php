<?php

include_once('object_db_interact.php');

class ObjUser extends ObjectDbInteract
{
	const DB_TABLE = 'usr';
	
	// True is this item object is not save into the db
	private $is_new = true;
	private $id;
	
	public $login;
	public $password;
	public $name;
	
	public function __construct($id = '')
	{
		// If id is empty, then is a new item, otherwise get the item from the DB
		if(!empty($id))
			$this->get_item_from_db($id);
	}
	
	// Allows if the item exists in the db, the data is load into the variables of this object
	protected function get_item_from_db($item_id)
	{
		$query = 'SELECT id, login, password, name 
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
			$this->login = $row['login'];
			$this->password = $row['password'];
			$this->name = $row['name'];
			
			$this->is_new = false;
		}
		
		mysqli_free_result($resulSet);
	}
	
	// Clean all the values of the item object
	protected function reset_values()
	{
		$this->id = null;
		$this->login = null;
		$this->password = null;
		$this->name = null;
		
		$this->is_new = true;
	}
	
	public function get_id()
	{
		return $this->id;
	}
	
	// Save the user item into the database
	public function save()
	{
		// Starting db conectivity
		$bd = DbConnectivity::getInstance();
		
		// Data filtering
		$this->login = mysqli_real_escape_string($bd->getLink(), $this->login);
		$this->password = mysqli_real_escape_string($bd->getLink(), $this->password);
		$this->name = mysqli_real_escape_string($bd->getLink(), $this->name);
		
		$pass = SHA1($this->password);
		
		if($this->is_new)
			$query = 'INSERT INTO '.self::DB_TABLE." (login, password, name) 
					VALUES ('$this->login', '$pass', '$this->name')";
		else
			$query = 'UPDATE '.self::DB_TABLE.
					" SET 
							login = '$this->login',
							password = '$pass',
							name = '$this->name' 
					WHERE id = $this->id";
		
		
		if( $bd->query($query) )
		{
			$this->id = $bd->getLastInsertedId();
			$this->is_new = false;
			return true;
		}
		else
			return false;
	}
	
	// Save the user item into the database
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
			[login] => $this->login,
			[password] => $this->password,
			[name] => $this->name
			<br />";
	}
	
} // End ObjUsers class

?>