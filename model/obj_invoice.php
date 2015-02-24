<?php

include_once('object_db_interact.php');

class ObjInvoice extends ObjectDbInteract
{
	const DB_TABLE = 'invoice';
	
	// True is this item object is not save into the db
	private $is_new = true;
	private $invoice_id;
	
	public $date;
	public $invoice_number;
	
	public function __construct($id = '')
	{
		// If id is empty, then is a new item, otherwise get the item from the DB
		if(!empty($id))
			$this->get_item_from_db($id);
	}
	
	// Allows if the item exists in the db, the data is load into the variables of this object
	protected function get_item_from_db($item_id)
	{
		$query = 'SELECT invoice_id, date, invoice_number 
				FROM '.self::DB_TABLE.
				" WHERE invoice_id = $item_id";
		
		$bd = DbConnectivity::getInstance();
		
		if(!($resulSet = $bd->query($query)))
			return false;
		
		$row = mysqli_fetch_assoc($resulSet);
		
		// If the resultset is not an empty array
		if(!empty($row))
		{
			$this->invoice_id = $row['invoice_id'];
			$this->date = $row['date'];
			$this->invoice_number = $row['invoice_number'];
			
			$this->is_new = false;
		}
		
		mysqli_free_result($resulSet);
	}
	
	// Clean all the values of the item object
	protected function reset_values()
	{
		$this->invoice_id = null;
		$this->date = null;
		$this->invoice_number = null;
		
		$this->is_new = true;
	}
	
	public function get_id()
	{
		return $this->invoice_id;
	}
	
	// Save the invoice item into the database
	public function save()
	{
		// Starting db conectivity
		$bd = DbConnectivity::getInstance();
		
		
		// Data filtering
		$this->date = mysqli_real_escape_string($bd->getLink(), $this->date);
		$this->invoice_number = mysqli_real_escape_string($bd->getLink(), $this->invoice_number);
	
		if($this->is_new)
		{
			// If this exactly invoice dataset doesn't exist into the DB, then it will be saved, otherwise, the invoice id is retrieved from the DB
			$this->_getIdFromDB();
			
			if(!$this->is_new)
				return true;
			
			
			$query = 'INSERT INTO '.self::DB_TABLE." (date, invoice_number) 
					VALUES ('$this->date', '$this->invoice_number')";
		}
		else
			$query = 'UPDATE '.self::DB_TABLE.
					" SET 
							date = '$this->date', 
							invoice_number = '$this->invoice_number' 
					WHERE invoice_id = $this->invoice_id";
		
		
		if(!$bd->query($query))
			return false;
		
		$this->_getIdFromDB();
		
		return true;
	}
	
	// Save the invoice item into the database
	public function remove()
	{
		if(!$this->is_new)
		{
			$query = 'DELETE FROM '.self::DB_TABLE." WHERE invoice_id = $this->invoice_id";
			
			$bd = DbConnectivity::getInstance();
			
			if(!$bd->query($query))
				return false;
		}
		
		$this->reset_values();
		return true;
	}
	
	// Set the current id value to the value of this object into the db
	// It purpuose is mainly when the data is saved as a new data set into the DB
	private function _getIdFromDB()
	{
		$where = " invoice_number = '$this->invoice_number' ";
		
		$aux_qp = new QueryProcessor();
		$data_array = $aux_qp->query_invoices($where);
		
		foreach($data_array as $invoice_id => $invoice_object)
		{
			$this->invoice_id = $invoice_object->get_id();
			$this->is_new = false;
		}		
	}
	
	public function toString()
	{
		echo "[invoice_id] => $this->invoice_id,
			[date] => $this->date, 
			[invoice_number] => $this->invoice_number 
			<br />";
	}
	
} // End ObjInvoice class

?>