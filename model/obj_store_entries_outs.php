<?php

include_once('object_db_interact.php');

class ObjStoreEntriesOuts extends ObjectDbInteract
{
	const DB_TABLE = 'store_entries_outs';
	
	// True is this item object is not save into the db
	private $is_new = true;
	private $id;
	
	public $store_id;
	public $tyre_id;
	public $supplier_id;	
	public $invoice_id;
	public $dest_store;
	public $dest_shop;
	public $date;
	public $entry_out;
	public $employee;
	public $amount;
	
	public function __construct($id = '')
	{
		// If id is empty, then is a new item, otherwise get the item from the DB
		if(!empty($id))
			$this->get_item_from_db($id);
	}
	
	// Allows if the item exists in the db, the data is load into the variables of this object
	protected function get_item_from_db($item_id)
	{
		$query = 'SELECT id, store_id, tyre_id, supplier_id, invoice_id, dest_store, dest_shop, date, entry_out, employee, amount 
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
			$this->store_id = $row['store_id'];
			$this->tyre_id = $row['tyre_id'];
			$this->supplier_id = $row['supplier_id'];
			$this->invoice_id = $row['invoice_id'];
			$this->dest_store = $row['dest_store'];
			$this->dest_shop = $row['dest_shop'];
			$this->date = $row['date'];
			$this->entry_out = $row['entry_out'];
			$this->employee = $row['employee'];
			$this->amount = $row['amount'];
			
			$this->is_new = false;
		}
		
		mysqli_free_result($resulSet);
	}
	
	// Clean all the values of the item object
	protected function reset_values()
	{
		$this->id = null;
		$this->store_id = null;
		$this->tyre_id = null;
		$this->supplier_id = null;
		$this->invoice_id = null;
		$this->dest_store = null;
		$this->dest_shop = null;
		$this->date = null;
		$this->entry_out = null;
		$this->employee = null;
		$this->amount = 0;
		
		$this->is_new = true;
	}
	
	public function get_id()
	{
		return $this->id;
	}
	
	// Save the tyre item into the database
	public function save()
	{
		// Starting db conectivity
		$bd = DbConnectivity::getInstance();
		
		// Data filtering
		$this->store_id = mysqli_real_escape_string($bd->getLink(), $this->store_id);
		$this->tyre_id = mysqli_real_escape_string($bd->getLink(), $this->tyre_id);
		$this->supplier_id = mysqli_real_escape_string($bd->getLink(), $this->supplier_id);
		$this->invoice_id = mysqli_real_escape_string($bd->getLink(), $this->invoice_id);
		$this->dest_store = mysqli_real_escape_string($bd->getLink(), $this->dest_store);
		$this->dest_shop = mysqli_real_escape_string($bd->getLink(), $this->dest_shop);
		$this->date = mysqli_real_escape_string($bd->getLink(), $this->date);
		$this->entry_out = mysqli_real_escape_string($bd->getLink(), $this->entry_out);
		$this->employee = mysqli_real_escape_string($bd->getLink(), $this->employee);
		$this->amount = mysqli_real_escape_string($bd->getLink(), $this->amount);
	
		if($this->is_new)
			$query = 'INSERT INTO '.self::DB_TABLE." (store_id, tyre_id, supplier_id, invoice_id, dest_store, dest_shop, date, entry_out, employee, amount) 
					VALUES ('$this->store_id',
							'$this->tyre_id',"
							.(!empty($this->supplier_id) ? "'$this->supplier_id'" : "null").","
							.(!empty($this->invoice_id) ? "'$this->invoice_id'" : "null").","
							.(!empty($this->dest_store) ? "'$this->dest_store'" : "null").","
							.(!empty($this->dest_shop) ? "'$this->dest_shop'" : "null").",
							'$this->date',
							'$this->entry_out',
							'$this->employee',
							'$this->amount')";
		else
			$query = 'UPDATE '.self::DB_TABLE.
					" SET 
							store_id = '$this->store_id',
							tyre_id = '$this->tyre_id',
							supplier_id = ".(!empty($this->supplier_id) ? "'$this->supplier_id'" : "null").",
							invoice_id = ".(!empty($this->invoice_id) ? "'$this->invoice_id'" : "null").",
							dest_store = ".(!empty($this->dest_store) ? "'$this->dest_store'" : "null").",
							dest_shop = ".(!empty($this->dest_shop) ? "'$this->dest_shop'" : "null").",
							date = '$this->date',
							entry_out = '$this->entry_out',
							employee = '$this->employee',
							amount = '$this->amount' 
					WHERE id = $this->id";
		
		
		return $bd->query($query);
	}
	
	// Save the tyre item into the database
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
			[store_id] = '$this->store_id',
			[tyre_id] = '$this->tyre_id',
			[supplier_id] = '$this->supplier_id',
			[invoice_id] = '$this->invoice_id',
			[dest_store] = '$this->dest_store',
			[dest_shop] = '$this->dest_shop',
			[date] = '$this->date',
			[entry_out] = '$this->entry_out',
			[employee] = '$this->employee',
			[amount] = '$this->amount'
			<br />";
	}
	
} // End ObjStoreEntriesOuts class

?>