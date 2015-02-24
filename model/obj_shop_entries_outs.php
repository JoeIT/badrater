<?php

include_once('object_db_interact.php');

class ObjShopEntriesOuts extends ObjectDbInteract
{
	const DB_TABLE = 'shop_entries_outs';
	
	// True is this item object is not save into the db
	private $is_new = true;
	private $id;
	
	public $shop_id;
	public $tyre_id;
	public $source_store;
	public $source_shop;	
	public $date;
	public $date_save;
	public $entry_out;
	public $employee;
	public $amount;
	public $deptor_id;
	public $payment_bs;
	public $payment_sus;
	

	
	public function __construct($id = '')
	{
		// If id is empty, then is a new item, otherwise get the item from the DB
		if(!empty($id))
			$this->get_item_from_db($id);
	}
	
	// Allows if the item exists in the db, the data is load into the variables of this object
	protected function get_item_from_db($item_id)
	{
		$query = 'SELECT id, shop_id, tyre_id, source_store, source_shop, date, date_save, entry_out, employee, amount, deptor_id, payment_bs, payment_sus 
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
			$this->tyre_id = $row['tyre_id'];
			$this->source_store = $row['source_store'];
			$this->source_shop = $row['source_shop'];
			$this->date = $row['date'];
			$this->date_save = $row['date_save'];
			$this->entry_out = $row['entry_out'];
			$this->employee = $row['employee'];
			$this->amount = $row['amount'];
			$this->deptor_id = $row['deptor_id'];
			$this->payment_bs = $row['payment_bs'];
			$this->payment_sus = $row['payment_sus'];
			
			$this->is_new = false;
		}
		
		mysqli_free_result($resulSet);
	}
	
	// Clean all the values of the item object
	protected function reset_values()
	{
		$this->id = null;
		$this->shop_id = null;
		$this->tyre_id = null;
		$this->source_store = null;
		$this->source_shop = null;
		$this->date = null;
		$this->date_save = null;
		$this->entry_out = null;
		$this->employee = null;
		$this->amount = 0;
		$this->deptor_id = null;
		$this->payment_bs = null;
		$this->payment_sus = null;
		
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
		$this->shop_id = mysqli_real_escape_string($bd->getLink(), $this->shop_id);
		$this->tyre_id = mysqli_real_escape_string($bd->getLink(), $this->tyre_id);
		$this->source_store = mysqli_real_escape_string($bd->getLink(), $this->source_store);
		$this->source_shop = mysqli_real_escape_string($bd->getLink(), $this->source_shop);
		$this->date = mysqli_real_escape_string($bd->getLink(), $this->date);
		//$this->date_save = mysqli_real_escape_string($bd->getLink(), $this->date_save);
		$this->entry_out = mysqli_real_escape_string($bd->getLink(), $this->entry_out);
		$this->employee = mysqli_real_escape_string($bd->getLink(), $this->employee);
		$this->amount = mysqli_real_escape_string($bd->getLink(), $this->amount);
		$this->deptor_id = mysqli_real_escape_string($bd->getLink(), $this->deptor_id);
		$this->payment_bs = mysqli_real_escape_string($bd->getLink(), $this->payment_bs);
		$this->payment_sus = mysqli_real_escape_string($bd->getLink(), $this->payment_sus);
	
		if($this->is_new)
			$query = 'INSERT INTO '.self::DB_TABLE." (shop_id, tyre_id, source_store, source_shop, date, date_save, entry_out, employee, amount, deptor_id, payment_bs, payment_sus) 
					VALUES ('$this->shop_id',
							'$this->tyre_id', "
							.(!empty($this->source_store) ? "'$this->source_store'" : "null").", "
							.(!empty($this->source_shop) ? "'$this->source_shop'" : "null").", 
							'$this->date', 
							'$this->date_save', 
							'$this->entry_out', 
							'$this->employee', 
							'$this->amount', "
							.(!empty($this->deptor_id) ? "'$this->deptor_id'" : "null").", 
							'$this->payment_bs', 
							'$this->payment_sus')";
		else
			$query = 'UPDATE '.self::DB_TABLE.
					" SET 
							shop_id = '$this->shop_id',
							tyre_id = '$this->tyre_id',
							source_store = ".(!empty($this->source_store) ? "'$this->source_store'" : "null").",
							source_shop = ".(!empty($this->source_shop) ? "'$this->source_shop'" : "null").",
							date = '$this->date',
							date_save = '$this->date_save',
							entry_out = '$this->entry_out',
							employee = '$this->employee',
							amount = '$this->amount',
							deptor_id = ".(!empty($this->deptor_id) ? "'$this->deptor_id'" : "null").",
							payment_bs = '$this->payment_bs', 
							payment_sus = '$this->payment_sus'
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
			[shop_id] = '$this->shop_id',
			[tyre_id] = '$this->tyre_id',
			[source_store] = '$this->source_store',
			[source_shop] = '$this->source_shop',
			[date] = '$this->date',
			[date_save] = '$this->date_save',
			[entry_out] = '$this->entry_out',
			[employee] = '$this->employee',
			[amount] = '$this->amount'
			[deptor_id] = '$this->deptor_id',
			[payment_bs] = '$this->payment_bs',
			[payment_sus] = '$this->payment_sus'
			<br />";
	}
	
} // End ObjShopEntriesOuts class

?>