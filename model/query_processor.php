<?php
include_once('obj_debt.php');
include_once('obj_deptor.php');
include_once('obj_expense.php');
include_once('obj_invoice.php');
include_once('obj_shop.php');
include_once('obj_store.php');
include_once('obj_tyre.php');
include_once('obj_shop_entries_outs.php');
include_once('obj_store_entries_outs.php');
include_once('obj_supplier.php');
include_once('obj_user.php');

class QueryProcessor
{
	const DB_TABLE_DEBT = 'debt';
	const DB_TABLE_DEPTOR = 'deptor';
	const DB_TABLE_EXPENSE = 'expense';
	const DB_TABLE_INVOICE = 'invoice';
	const DB_TABLE_ROLE = 'role';
	const DB_TABLE_ROLE_STORE = 'role_store';
	const DB_TABLE_ROLE_SHOP = 'role_shop';
	const DB_TABLE_SHOP = 'shop';
	const DB_TABLE_SHOP_E_O = 'shop_entries_outs';
	const DB_TABLE_STOCK = 'stock';
	const DB_TABLE_STORE = 'store';
	const DB_TABLE_STORE_E_O = 'store_entries_outs';
	const DB_TABLE_SUPPLIER = 'supplier';
	const DB_TABLE_TYRE = 'tyre';
	const DB_TABLE_USR = 'usr';
	
	private $_db;
	
	public function __construct()
	{
		$this->_bd = DbConnectivity::getInstance();
	}
	
	public function getLink()
	{
		return $this->_bd->getLink();
	}
	
	// Return an array of debt's ids according the terms of the parameters
	public function query_debts($where = '')
	{
		$query = 'SELECT id FROM '.self::DB_TABLE_DEBT;
		
		if(!empty($where))
			$query .= " WHERE $where ";
		
		$query .= ' ORDER BY date ';
		
		//$bd = DbConnectivity::getInstance();
		
		if(!($resulSet = $this->_bd->query($query)))
			return false;
		
		$debt_array = array();
		
		while($row = mysqli_fetch_assoc($resulSet))
		{
			//if(!empty($row))
			$debt_array[$row['id']] = new ObjDebt($row['id']);
		}
		
		return $debt_array;
	}
	
	//----------------------------------------------
	
	// Return an array of deptor's ids according the terms of the parameters
	public function query_deptors($where = '')
	{
		$query = 'SELECT id FROM '.self::DB_TABLE_DEPTOR;
		
		if(!empty($where))
			$query .= " WHERE $where ";
		
		$query .= ' ORDER BY name ';
		
		//$bd = DbConnectivity::getInstance();
		
		if(!($resulSet = $this->_bd->query($query)))
			return false;
		
		$deptor_array = array();
		
		while($row = mysqli_fetch_assoc($resulSet))
		{
			//if(!empty($row))
			$deptor_array[$row['id']] = new ObjDeptor($row['id']);
		}
		
		return $deptor_array;
	}
	
	//----------------------------------------------
	
	// Return an array of expense's ids according the terms of the parameters
	public function query_expenses($where = '')
	{
		$query = 'SELECT id FROM '.self::DB_TABLE_EXPENSE;
		
		if(!empty($where))
			$query .= " WHERE $where ";
		
		$query .= ' ORDER BY date ';
		
		//$bd = DbConnectivity::getInstance();
		
		if(!($resulSet = $this->_bd->query($query)))
			return false;
		
		$expense_array = array();
		
		while($row = mysqli_fetch_assoc($resulSet))
		{
			//if(!empty($row))
			$expense_array[$row['id']] = new ObjExpense($row['id']);
		}
		
		return $expense_array;
	}
	
	//----------------------------------------------
	
	// Return an array of invoice's ids according the terms of the parameters
	public function query_invoices($where = '')
	{
		$query = 'SELECT invoice_id FROM '.self::DB_TABLE_INVOICE;
		
		if(!empty($where))
			$query .= " WHERE $where ";
		
		$query .= ' ORDER BY date ';
		
		if(!($resulSet = $this->_bd->query($query)))
			return false;
		
		$invoice_array = array();
		
		while($row = mysqli_fetch_assoc($resulSet))
		{
			//if(!empty($row))
			$invoice_array[$row['invoice_id']] = new ObjInvoice($row['invoice_id']);
		}
		
		return $invoice_array;
	}
	
	//----------------------------------------------
	
	// Return an array of shop's ids according the terms of the parameters
	public function query_shops($where = '')
	{
		$query = 'SELECT shop_id FROM '.self::DB_TABLE_SHOP;
		
		if(!empty($where))
			$query .= " WHERE $where ";
		
		$query .= ' ORDER BY shop_name ';
		
		//$bd = DbConnectivity::getInstance();
		
		if(!($resulSet = $this->_bd->query($query)))
			return false;
		
		$shop_array = array();
		
		while($row = mysqli_fetch_assoc($resulSet))
		{
			//if(!empty($row))
			$shop_array[$row['shop_id']] = new ObjShop($row['shop_id']);
		}
		
		return $shop_array;
	}
	
	// Return an array of shop's ids entries from stores and shops
	public function query_shops_entries($toStore, $toShop, $date)
	{
		$where_1 = '';
		$where_2 = '';
		
		if( !empty($toStore) )
		{
			$where_1 = " WHERE dest_store =  $toStore ";
			$where_2 = " WHERE source_store = $toStore ";
		}
		else if( !empty($toShop) )
		{
			$where_1 = " WHERE dest_shop = $toShop ";
			$where_2 = " WHERE source_shop = $toShop ";
		}
		
		if( !empty($date) )
		{
			$where_1 .= " AND date = '$date' ";
			$where_2 .= " AND date = '$date' ";
		}
		
		$query = "SELECT date, tyre_id, amount, store_id, shop_id
				FROM
				(
					SELECT date, tyre_id, amount, store_id, null AS shop_id
					FROM ".self::DB_TABLE_STORE_E_O."
					$where_1
					
					UNION
					
					SELECT date, tyre_id, amount, null AS store_id, shop_id
					FROM ".self::DB_TABLE_SHOP_E_O."
					$where_2
				) AS unionTable
				ORDER BY date";
		
		//$bd = DbConnectivity::getInstance();
		
		if(!($resulSet = $this->_bd->query($query)))
			return false;
		
		$entries_array = array();
		
		while($row = mysqli_fetch_assoc($resulSet))
		{
			$tyre = new ObjTyre($row['tyre_id']);
			
			if( !empty($row['store_id']) )
			{
				$store_obj = new ObjStore($row['store_id']);
				$source = $store_obj->store_name;
			}
			else if( !empty($row['shop_id']) )
			{
				$shop_obj = new ObjShop($row['shop_id']);
				$source = $shop_obj->shop_name;
			}
			
			array_push($entries_array, array('amount' => $row['amount'], 
											'size' => $tyre->tyre_size, 
											'brand' => $tyre->tyre_brand, 
											'code' => $tyre->tyre_code, 
											'source' => $source));
		}
		
		return $entries_array;
	}
	
	// Return an array of shop's ids entries or aouts according the terms of the parameters
	public function query_shops_entries_outs($where = '')
	{
		$query = 'SELECT id FROM '.self::DB_TABLE_SHOP_E_O;
		
		if(!empty($where))
			$query .= " WHERE $where ";
		
		$query .= ' ORDER BY date ';
		
		//$bd = DbConnectivity::getInstance();
		
		if(!($resulSet = $this->_bd->query($query)))
			return false;
		
		$io_array = array();
		
		while($row = mysqli_fetch_assoc($resulSet))
		{
			//if(!empty($row))
			$io_array[$row['id']] = new ObjShopEntriesOuts($row['id']);
		}
		
		return $io_array;
	}
	
	// Return an array of shop's ids entries or aouts according the terms of the parameters
	public function query_shops_sales($where = '')
	{
		$query = 'SELECT id FROM '.self::DB_TABLE_SHOP_E_O;
		
		if(!empty($where))
			$query .= " WHERE $where ";
		
		$query .= ' ORDER BY date ';
		
		//$bd = DbConnectivity::getInstance();
		
		if(!($resulSet = $this->_bd->query($query)))
			return false;
		
		$io_array = array();
		
		while($row = mysqli_fetch_assoc($resulSet))
		{
			//if(!empty($row))
			$io_array[$row['id']] = new ObjShopEntriesOuts($row['id']);
		}
		
		return $io_array;
	}
	
	public function query_is_linked_virtual($id)
	{
		$query = 'SELECT * FROM '.self::DB_TABLE_STORE." WHERE store_virtual = $id ";
		
		if(!($resulSet = $this->_bd->query($query)))
			return false;
		
		if( mysqli_fetch_assoc($resulSet) != null )
			return true;
		
		return false;
	}
	
	//----------------------------------------------
	
	// Return a quantity value of tyres that a store or shop has
	public function query_stocks_quantity($idTyre, $idStore, $idShop)
	{
		$andWhere = '';
		
		if(!empty($idStore))
			$andWhere = " AND store_id = $idStore ";
		else if(!empty($idShop))
			$andWhere = " AND shop_id = $idShop ";
		else
			return 0;
		
		$query = 'SELECT quantity FROM ' .self::DB_TABLE_STOCK. " WHERE tyre_id = $idTyre $andWhere";
		
		
		if(!($resulSet = $this->_bd->query($query)))
			return 0;
		
		if( ($quantity = mysqli_fetch_assoc($resulSet)) != null )
			return $quantity['quantity'];
		else
			return 0;
	}
	
	// Return an array of all the tyres and quantitys that a store or shop has
	public function query_all_tyres_stocks_quantity($idStore, $idShop)
	{
		if(!empty($idStore))
			$where = " WHERE store_id = $idStore ";
		else if(!empty($idShop))
			$where = " WHERE shop_id = $idShop ";
		
		$query = 'SELECT tyre_id, quantity FROM ' .self::DB_TABLE_STOCK. " $where ";
		
		if( !($resulSet = $this->_bd->query($query)) )
			return array();
		
		$stockArray = array();
		while($row = mysqli_fetch_assoc($resulSet))
		{
			$stockArray[] = $row;
		}
		
		return $stockArray;
	}
	
	// Adding a quantity value of tyres that a store or shop has
	public function query_add_stocks_quantity($idTyre, $idStore, $idShop, $addQuatity)
	{
		$andWhere = '';
		
		if(!empty($idStore))
			$andWhere = " AND store_id = $idStore ";
		else if(!empty($idShop))
			$andWhere = " AND shop_id = $idShop ";
		
		// Retrieving data
		$querySelect = 'SELECT quantity FROM ' .self::DB_TABLE_STOCK. " WHERE tyre_id = $idTyre $andWhere";
		$resulSet = $this->_bd->query($querySelect);
		
		$new = true;
		if( ($q = mysqli_fetch_assoc($resulSet)) != null )
		{
			$quantity = $q['quantity'];
			$new = false;
		}
		else
			$quantity = 0;
		
		$quantity += $addQuatity;
		
		// Saving data
		if($new)
		{
			if(!empty($idStore))
				$query = 'INSERT INTO '.self::DB_TABLE_STOCK." (tyre_id, store_id, quantity) VALUES ($idTyre, $idStore, $quantity)";
			else if(!empty($idShop))
				$query = 'INSERT INTO '.self::DB_TABLE_STOCK." (tyre_id, shop_id, quantity) VALUES ($idTyre, $idShop, $quantity)";
		}
		else
			$query = 'UPDATE '.self::DB_TABLE_STOCK." SET quantity = $quantity WHERE tyre_id = $idTyre $andWhere";
		
		return $this->_bd->query($query);
	}
	
	public function query_delete_stocks_store($idStore)
	{
		$query =  'DELETE FROM '.self::DB_TABLE_STOCK." WHERE store_id = $idStore; ";
		return $this->_bd->query($query);
	}
	
	public function query_delete_stocks_shop($idShop)
	{
		$query =  'DELETE FROM '.self::DB_TABLE_STOCK." WHERE shop_id = $idShop; ";
		return $this->_bd->query($query);
	}
	
	
	//----------------------------------------------
	
	// Return an array of store's ids according the terms of the parameters
	public function query_stores($where = '')
	{
		$query = 'SELECT store_id FROM '.self::DB_TABLE_STORE;
		
		if(!empty($where))
			$query .= " WHERE $where ";
		
		$query .= ' ORDER BY store_name ';
		
		//$bd = DbConnectivity::getInstance();
		
		if(!($resulSet = $this->_bd->query($query)))
			return false;
		
		$store_array = array();
		
		while($row = mysqli_fetch_assoc($resulSet))
		{
			$store_array[$row['store_id']] = new ObjStore($row['store_id']);
		}
		
		return $store_array;
	}
	
	// Return an array of store's ids according the terms of the parameters
	public function query_stores_entries_outs($where = '')
	{
		$query = 'SELECT id FROM '.self::DB_TABLE_STORE_E_O;
		
		if(!empty($where))
			$query .= " WHERE $where ";
		
		$query .= ' ORDER BY date ';
		
		//$bd = DbConnectivity::getInstance();
		
		if(!($resulSet = $this->_bd->query($query)))
			return false;
		
		$io_array = array();
		
		while($row = mysqli_fetch_assoc($resulSet))
		{
			$io_array[$row['id']] = new ObjStoreEntriesOuts($row['id']);
		}
		
		return $io_array;
	}
	
	//----------------------------------------------
	
	// Return an array of tyre's ids according the terms of the parameters
	public function query_suppliers($where = '')
	{
		$query = 'SELECT supplier_id FROM '.self::DB_TABLE_SUPPLIER;
		
		if(!empty($where))
			$query .= " WHERE $where ";
		
		$query .= ' ORDER BY name ';
		
		if(!($resulSet = $this->_bd->query($query)))
			return false;
		
		$supplier_array = array();
		
		while($row = mysqli_fetch_assoc($resulSet))
		{
			$supplier_array[$row['supplier_id']] = new ObjSupplier($row['supplier_id']);
		}
		
		return $supplier_array;
	}
	
	//----------------------------------------------
	
	// Return an array of tyre's ids according the terms of the parameters
	public function query_tyres($where = '')
	{
		$query = 'SELECT tyre_id FROM '.self::DB_TABLE_TYRE;
		
		if(!empty($where))
			$query .= " WHERE $where ";
		
		$query .= ' ORDER BY tyre_brand, tyre_size, tyre_code ';
		
		//$bd = DbConnectivity::getInstance();
		
		if(!($resulSet = $this->_bd->query($query)))
			return false;
		
		$tyre_array = array();
		
		while($row = mysqli_fetch_assoc($resulSet))
		{
			$tyre_array[$row['tyre_id']] = new ObjTyre($row['tyre_id']);
		}
		
		return $tyre_array;
	}
	
	//----------------------------------------------
	
	// Return an array of tyre's ids according the terms of the parameters
	public function query_users($where = '')
	{
		$query = 'SELECT id FROM '.self::DB_TABLE_USR;
		
		if(!empty($where))
			$query .= " WHERE $where ";
		
		$query .= ' ORDER BY name ';
		
		//$bd = DbConnectivity::getInstance();
		
		if(!($resulSet = $this->_bd->query($query)))
			return false;
		
		$user_array = array();
		
		while($row = mysqli_fetch_assoc($resulSet))
		{
			$user_array[$row['id']] = new ObjUser($row['id']);
		}
		
		return $user_array;
	}
	
	// Return an array of user's ids and names according the terms of the parameters
	public function query_users_array()
	{
		$query = 'SELECT id, name FROM '.self::DB_TABLE_USR;
		
		$query .= ' ORDER BY name ';
		
		if(!($resulSet = $this->_bd->query($query)))
			return array();
		
		$user_array = array();
		
		while($row = mysqli_fetch_assoc($resulSet))
		{
			array_push($user_array, array('id' => $row['id'], 'name' => $row['name']));
		}
		
		return $user_array;
	}
	
	// Return an array of user's ids and logins according the terms of the parameters
	public function query_users_login_array()
	{
		$query = 'SELECT id, login FROM '.self::DB_TABLE_USR;
		
		$query .= ' ORDER BY login ';
		
		if(!($resulSet = $this->_bd->query($query)))
			return array();
		
		$user_array = array();
		
		while($row = mysqli_fetch_assoc($resulSet))
		{
			array_push($user_array, array('id' => $row['id'], 'login' => $row['login']));
		}
		
		return $user_array;
	}
	
	// Return an array of user's ids and names according the terms of the parameters
	public function query_user_roles_array($userId)
	{
		$query = 'SELECT id, 
						permission, 
						store_v, 
						store_a, 
						store_d, 
						shop_v, 
						shop_a, 
						shop_d, 
						tyre_a, 
						tyre_d, 
						supplier_a, 
						supplier_d, 
						deptor_a, 
						deptor_d 
					FROM '.self::DB_TABLE_ROLE." WHERE user = $userId";
		
		if(!($resulSet = $this->_bd->query($query)))
			return array();
		
		$permissions_array = array();
		
		while($row = mysqli_fetch_assoc($resulSet))
		{
			array_push($permissions_array, array('id' => $row['id'],
												'permission' => $row['permission'],
												'store_v' => $row['store_v'],
												'store_a' => $row['store_a'],
												'store_d' => $row['store_d'],
												'shop_v' => $row['shop_v'],
												'shop_a' => $row['shop_a'],
												'shop_d' => $row['shop_d'],
												'tyre_a' => $row['tyre_a'],
												'tyre_d' => $row['tyre_d'],
												'supplier_a' => $row['supplier_a'],
												'supplier_d' => $row['supplier_d'],
												'deptor_a' => $row['deptor_a'],
												'deptor_d' => $row['deptor_d'],
												));
		}
		
		return $permissions_array;
	}
	
	//----------------------------------------------
	
	// Return an array of all store's ids and names
	public function query_stores_array($where = '')
	{
		if( !empty($where) )
			$where = ' WHERE '. $where;
		
		$query = 'SELECT store_id, store_name, store_virtual FROM '.self::DB_TABLE_STORE.' '. $where .' ORDER BY store_name ';
		
		if( !($resulSet = $this->_bd->query($query)) )
			return array();
		
		$stores_array = array();
		
		while($row = mysqli_fetch_assoc($resulSet))
		{
			array_push($stores_array, array( 'id' => $row['store_id'], 
											'name' => $row['store_name'], 
											'virtual' => $row['store_virtual'] 
											));
		}
		
		return $stores_array;
	}

    // Return an array of all shop's ids and names
	public function query_shops_array($where = '')
	{
		if( !empty($where) )
			$where = ' WHERE '. $where;
		
		$query = 'SELECT shop_id, shop_name FROM '.self::DB_TABLE_SHOP.' '. $where .' ORDER BY shop_name ';
		
		if( !($resulSet = $this->_bd->query($query)) )
			return array();
		
		$shops_array = array();
		
		while($row = mysqli_fetch_assoc($resulSet))
		{
			array_push($shops_array, array('id' => $row['shop_id'], 'name' => $row['shop_name']));
		}
		
		return $shops_array;
	}
	
	public function query_store_permissions_array($userId)
	{
		$query = 'SELECT store_id, mov_v, mov_a, mov_d FROM '.self::DB_TABLE_ROLE_STORE." WHERE user = $userId ORDER BY store_id ";
		
		if( !($resulSet = $this->_bd->query($query)) )
			return array();
		
		$permissions_array = array();
		
		while($row = mysqli_fetch_assoc($resulSet))
		{
			$permissions_array[$row['store_id']] = array('mov_v' => $row['mov_v'], 
														'mov_a' => $row['mov_a'], 
														'mov_d' => $row['mov_d']);
		}
		
		return $permissions_array;
	}
	
	public function query_shop_permissions_array($userId)
	{
		$query = 'SELECT shop_id, mov_v, mov_a, mov_d, mov_o FROM '.self::DB_TABLE_ROLE_SHOP." WHERE user = $userId ORDER BY shop_id ";
		
		if( !($resulSet = $this->_bd->query($query)) )
			return array();
		
		$permissions_array = array();
		
		while($row = mysqli_fetch_assoc($resulSet))
		{
			$permissions_array[$row['shop_id']] = array('mov_v' => $row['mov_v'], 
														'mov_a' => $row['mov_a'], 
														'mov_d' => $row['mov_d'], 
														'mov_o' => $row['mov_o']);
		}
		
		return $permissions_array;
	}
	
	public function query_save_role($user_id, 
										$permission, 
										$store_v, 
										$store_a, 
										$store_d, 
										$shop_v, 
										$shop_a, 
										$shop_d, 
										$tyre_a, 
										$tyre_d, 
										$supplier_a, 
										$supplier_d, 
										$deptor_a, 
										$deptor_d)
	{
		
		$query = 'INSERT INTO '.self::DB_TABLE_ROLE." (user, permission, store_v, store_a, store_d, 
														shop_v, shop_a, shop_d, tyre_a, tyre_d, 
														supplier_a, supplier_d, deptor_a, deptor_d) 
													VALUES 
													('$user_id', '$permission', '$store_v', '$store_a', '$store_d', '$shop_v', 
													'$shop_a', '$shop_d', '$tyre_a', '$tyre_d', 
													'$supplier_a', '$supplier_d', '$deptor_a', '$deptor_d')";
		
		return $this->_bd->query($query);
	}
	
	public function query_save_store_role($user_id, $store_id, $mov_v, $mov_a, $mov_d)
	{
		$query = 'INSERT INTO '.self::DB_TABLE_ROLE_STORE." (user, store_id, mov_v, mov_a, mov_d)
													VALUES ('$user_id', '$store_id', '$mov_v', '$mov_a', '$mov_d')";
		
		
		return $this->_bd->query($query);
	}
	
	public function query_save_shop_role($user_id, $shop_id, $mov_v, $mov_a, $mov_d)
	{
		$query = 'INSERT INTO '.self::DB_TABLE_ROLE_SHOP." (user, shop_id, mov_v, mov_a, mov_d)
													VALUES ('$user_id', '$shop_id', '$mov_v', '$mov_a', '$mov_d')";
		
		return $this->_bd->query($query);
	}
	
	public function query_delete_all_user_roles($user_id)
	{
		$query1 =  'DELETE FROM '.self::DB_TABLE_ROLE." WHERE user = $user_id; ";
		$query2 = 'DELETE FROM '.self::DB_TABLE_ROLE_STORE." WHERE user = $user_id; ";
		$query3 = 'DELETE FROM '.self::DB_TABLE_ROLE_SHOP." WHERE user = $user_id; ";
		
		if( $this->_bd->query($query1) == true &&
			$this->_bd->query($query2) == true &&
			$this->_bd->query($query3) == true)
			return true;
		else
			return false;
	}
	
	public function query_delete_all_store_roles($store_id)
	{
		$query = 'DELETE FROM '.self::DB_TABLE_ROLE_STORE." WHERE store_id = $store_id; ";
		return $this->_bd->query($query);
	}
	
	public function query_delete_all_shop_roles($shop_id)
	{
		$query = 'DELETE FROM '.self::DB_TABLE_ROLE_SHOP." WHERE shop_id = $shop_id; ";
		return $this->_bd->query($query);
	}
	
	public function query_update_role($user_id, 
										$permission, 
										$store_v, 
										$store_a, 
										$store_d, 
										$shop_v, 
										$shop_a, 
										$shop_d, 
										$tyre_a, 
										$tyre_d, 
										$supplier_a, 
										$supplier_d, 
										$deptor_a, 
										$deptor_d)
	{
		
		if( $store_a == 'y' || $store_d == 'y' )
			$store_v = 'y';
		if( $shop_a == 'y' || $shop_d == 'y' )
			$shop_v = 'y';
		
		$query = 'UPDATE '.self::DB_TABLE_ROLE." SET permission = '$permission', 
													store_v = '$store_v', 
													store_a = '$store_a', 
													store_d = '$store_d', 
													shop_v = '$shop_v', 
													shop_a = '$shop_a', 
													shop_d = '$shop_d', 
													tyre_a = '$tyre_a', 
													tyre_d = '$tyre_d', 
													supplier_a = '$supplier_a', 
													supplier_d = '$supplier_d', 
													deptor_a = '$deptor_a', 
													deptor_d = '$deptor_d' 
												WHERE user = $user_id";
		
		return $this->_bd->query($query);
	}
	
	public function query_update_store_role($user_id, $store_id, $mov_v, $mov_a, $mov_d)
	{
		if( $mov_a == 'y' || $mov_d == 'y' )
			$mov_v = 'y';
		
		$query = 'UPDATE '.self::DB_TABLE_ROLE_STORE." SET mov_v = '$mov_v', 
															mov_a = '$mov_a', 
															mov_d = '$mov_d' 
														WHERE user = $user_id AND store_id = $store_id";
														
		return $this->_bd->query($query);
	}
	
	public function query_update_shop_role($user_id, $shop_id, $mov_v, $mov_a, $mov_d, $mov_o)
	{
		if( $mov_a == 'y' || $mov_d == 'y' )
			$mov_v = 'y';
		
		$query = 'UPDATE '.self::DB_TABLE_ROLE_SHOP." SET mov_v = '$mov_v', 
															mov_a = '$mov_a', 
															mov_d = '$mov_d', 
															mov_o = '$mov_o' 
														WHERE user = $user_id AND shop_id = $shop_id";
														
		return $this->_bd->query($query);
	}
	
	//------------------------------------
	// KARDEX
	public function query_kardex_io($store_id, $shop_id, $tyre_id, $dateIni, $dateEnd)
	{
        $where = '';
        if( !empty($tyre_id) )
            $where = " AND tyre_id = $tyre_id ";

        if( !empty($store_id) )
		{
			$query = 'SELECT date, entry_out, amount, tyre.tyre_size, tyre.tyre_brand, tyre.tyre_code
                      FROM '.self::DB_TABLE_STORE_E_O." as s
                      LEFT JOIN ".self::DB_TABLE_TYRE." as tyre ON tyre.tyre_id = s.tyre_id
                      WHERE store_id = $store_id
                        $where
                        AND date >= '$dateIni'
                        AND date <= '$dateEnd' ";
		}
		else if( !empty($shop_id) )
		{
			$query = 'SELECT date, entry_out, amount, tyre.tyre_size, tyre.tyre_brand, tyre.tyre_code
                      FROM '.self::DB_TABLE_SHOP_E_O." as s
                      LEFT JOIN ".self::DB_TABLE_TYRE." as tyre ON tyre.tyre_id = s.tyre_id
                      WHERE shop_id = $shop_id
                        $where
                        AND date >= '$dateIni'
                        AND date <= '$dateEnd' ";
			
			// Obtaining the shop entries from the store
			/*$query2 = 'SELECT date, amount FROM '.self::DB_TABLE_STORE_E_O." WHERE dest_shop = $shop_id
																							AND tyre_id = $tyre_id 
																							AND date >= '$dateIni' 
																							AND date <= '$dateEnd' ";*/
		}

        //echo "QUERY: $query";

        if( !($resulSet = $this->_bd->query($query)) )
			return array();
		
		$movements_array = array();
		
		while($row = mysqli_fetch_assoc($resulSet))
		{
			array_push($movements_array, array('date' => $row['date'],
                                                'tyre' => $row['tyre_size'] .' '. $row['tyre_brand'] .' '. $row['tyre_brand'],
												'entry_out' => $row['entry_out'],
												'amount' => $row['amount']));
		}
		
		/*
		if( !empty($shop_id) )
		{
			$resulSet = $this->_bd->query($query2);
			
			if( mysqli_num_rows($resulSet) > 0 )
			{
				while($row = mysqli_fetch_assoc($resulSet))
				{
					array_push($movements_array, array('date' => $row['date'], 
														'entry_out' => 'entry', 
														'amount' => $row['amount']));
				}
				
				$sort = array();
				foreach($movements_array as $k=>$v)
				{
					$sort['date'][$k] = $v['date'];
				}
				
				array_multisort($sort['date'], SORT_ASC, $movements_array);
			}
		}*/
		
		return $movements_array;
	}
	
	public function query_kardex_entries($store_id, $shop_id, $tyre_id, $dateIni, $dateEnd)
	{
		if( !empty($store_id) )
			$query = 'SELECT date, supplier.name, employee, amount FROM '.self::DB_TABLE_STORE_E_O.' as eo, 
													'.self::DB_TABLE_SUPPLIER." as supplier 
												WHERE store_id = $store_id 
													AND tyre_id = $tyre_id 
													AND entry_out = 'entry' 
													AND date >= '$dateIni' 
													AND date <= '$dateEnd' ";
		
		else if( !empty($shop_id) )
			$query = 'SELECT date, employee AS name, employee, amount FROM '.self::DB_TABLE_SHOP_E_O.' as eo '.
			                                    "WHERE shop_id = $shop_id
													AND tyre_id = $tyre_id
													AND entry_out = 'entry'
													AND date >= '$dateIni'
													AND date <= '$dateEnd' ";

            /*$query = 'SELECT date, supplier.name, employee, amount FROM '.self::DB_TABLE_STORE_E_O.' as eo,
													'.self::DB_TABLE_SUPPLIER." as supplier
												WHERE dest_shop = $shop_id
													AND tyre_id = $tyre_id
													AND date >= '$dateIni'
													AND date <= '$dateEnd' ";*/
		
		if( !($resulSet = $this->_bd->query($query)) )
			return array();
		
		$movements_array = array();
		
		while($row = mysqli_fetch_assoc($resulSet))
		{
			array_push($movements_array, array('date' => $row['date'], 
												'supplier' => $row['name'], 
												'employee' => $row['employee'], 
												'amount' => $row['amount']));
		}
		
		return $movements_array;
	}
	
	public function query_kardex_outs($shop_id, $tyre_id, $type, $dateIni, $dateEnd)
	{
		if( !empty($type) )
			$type = " AND entry_out = '$type' ";
        else
            $type = " AND entry_out != 'entry' ";
		
		$query = 'SELECT date, entry_out, s.shop_name, amount FROM '.self::DB_TABLE_SHOP_E_O.' as eo
																	LEFT JOIN '.self::DB_TABLE_SHOP." as s ON eo.source_shop = s.shop_id
																WHERE eo.shop_id = $shop_id
																	AND tyre_id = $tyre_id
																	$type
																	AND date >= '$dateIni'
																	AND date <= '$dateEnd' ";

        if( !($resulSet = $this->_bd->query($query)) )
			return array();
		
		$movements_array = array();
		
		while($row = mysqli_fetch_assoc($resulSet))
		{
			array_push($movements_array, array('date' => $row['date'], 
												'entry_out' => $row['entry_out'], 
												'destination' => $row['shop_name'], 
												'amount' => $row['amount']));
		}
		
		return $movements_array;
	}
	
	public function query_kardex_stock($tyre_id, $store_id, $shop_id)
	{
		$where = '';
        $placesWhere = '';

        if( !empty($tyre_id) )
			$where = " AND s.tyre_id = $tyre_id ";
		
		if( !empty($store_id) )
			$where .= " AND s.store_id = $store_id ";
        else
        {
            $storesArray = $_SESSION['alowedStores'];
            foreach($storesArray as $id => $val)
            {
                $placesWhere .= " s.store_id = $id OR ";
            }
        }
		
		if( !empty($shop_id) )
			$where .= " AND s.shop_id = $shop_id ";
        else
        {
            $shopsArray = $_SESSION['alowedShops'];
            foreach($shopsArray as $id => $val)
            {
                $placesWhere .= " s.shop_id = $id OR ";
            }
        }

        if(!empty($placesWhere))
            $placesWhere = ' AND (' . substr($placesWhere, 0, strlen($placesWhere) - 3) . ') ';

        $where .= $placesWhere;

		
		$query = 'SELECT quantity, s.tyre_id, tyre_size, tyre_brand, tyre_code, store_id, shop_id FROM '.self::DB_TABLE_STOCK.' as s, 
															'.self::DB_TABLE_TYRE." as t 
													WHERE s.tyre_id = t.tyre_id AND s.quantity != 0 
														$where 
													ORDER BY tyre_brand, tyre_size, tyre_code";

        if( !($resulSet = $this->_bd->query($query)) )
			return array();
		
		$movements_array = array();
		
		while($row = mysqli_fetch_assoc($resulSet))
		{
			array_push($movements_array, array( 'quantity' => $row['quantity'], 
												'tyre_id' => $row['tyre_id'], 
												'store_id' => $row['store_id'], 
												'shop_id' => $row['shop_id'], 
												'tyre_size' => $row['tyre_size'],
												'tyre_brand' => $row['tyre_brand'],
												'tyre_code' => $row['tyre_code'] ));
		}
		
		return $movements_array;
	}
	
	public function query_kardex_invoices($invoice_id)
	{
		$query = 'SELECT store_name, tyre_size, tyre_brand, tyre_code, eo.date, amount FROM '.self::DB_TABLE_STORE.' as store, 
																										'.self::DB_TABLE_TYRE.' as tyre, 
																										'.self::DB_TABLE_STORE_E_O." as eo 
																									WHERE eo.invoice_id = $invoice_id 
																											AND eo.store_id = store.store_id
																											AND eo.tyre_id = tyre.tyre_id";
		
		if( !($resulSet = $this->_bd->query($query)) )
			return array();
		
		$imports_array = array();
		
		while($row = mysqli_fetch_assoc($resulSet))
		{
			array_push($imports_array, array('store' => $row['store_name'], 
												'tyre' => $row['tyre_size'].' '.$row['tyre_brand'].' '.$row['tyre_code'], 
												'date' => $row['date'], 
												'amount' => $row['amount']));
		}
		
		return $imports_array;
	}

	public function query_kardex_imports($supplier_id, $dateIni, $dateEnd)
	{
		$query = 'SELECT store_name, tyre_size, tyre_brand, tyre_code, invoice.invoice_number, eo.date, amount FROM '.self::DB_TABLE_STORE.' as store, 
																										'.self::DB_TABLE_TYRE.' as tyre, 
																										'.self::DB_TABLE_STORE_E_O.' as eo
																										LEFT JOIN '.self::DB_TABLE_INVOICE." as invoice ON eo.invoice_id = invoice.invoice_id 
																									WHERE eo.supplier_id = $supplier_id 
																											AND eo.date >= '$dateIni' 
																											AND eo.date <= '$dateEnd' 
																											AND eo.store_id = store.store_id
																											AND eo.tyre_id = tyre.tyre_id";
		
		if( !($resulSet = $this->_bd->query($query)) )
			return array();
		
		$imports_array = array();
		
		while($row = mysqli_fetch_assoc($resulSet))
		{
			array_push($imports_array, array('store' => $row['store_name'], 
												'tyre' => $row['tyre_size'].' '.$row['tyre_brand'].' '.$row['tyre_code'], 
												'invoice' => $row['invoice_number'], 
												'date' => $row['date'], 
												'amount' => $row['amount']));
		}
		
		return $imports_array;
	}
	
	public function query_kardex_debts($shop_id, $deptor_id)
	{
		$deptorWhere = '';
		$shopWhere = '';
		$deptorWhere2 = '';
		$shopWhere2 = '';
		
		if( !empty($deptor_id) )
		{
			$deptorWhere = " AND eo.deptor_id = $deptor_id ";
			$deptorWhere2 = " AND debt.deptor_id = $deptor_id ";
		}
		
		if( !empty($shop_id) )
		{
			$shopWhere = " AND eo.shop_id = $shop_id ";
			$shopWhere2 = " AND debt.shop_id = $shop_id ";
		}
		
		$query = 'SELECT date, shop_name, tyre_size, tyre_brand, tyre_code, payment_bs, payment_sus, amount, name FROM '.self::DB_TABLE_SHOP_E_O.' as eo, 
																'.self::DB_TABLE_SHOP.' as shop, 
																'.self::DB_TABLE_TYRE.' as tyre, 
																'.self::DB_TABLE_DEPTOR." as d 
																WHERE eo.deptor_id = d.id 
																	AND eo.shop_id = shop.shop_id 
																	AND eo.tyre_id = tyre.tyre_id 
																	$deptorWhere 
																	$shopWhere ";
		
		$queryPayDebts = 'SELECT date, shop_name, name, description, bs, sus FROM '.self::DB_TABLE_DEBT.' as debt,
																'.self::DB_TABLE_SHOP.' as shop, 
																'.self::DB_TABLE_DEPTOR." as d 
																WHERE debt.deptor_id = d.id 
																	AND debt.shop_id = shop.shop_id 
																	$deptorWhere2 
																	$shopWhere2 ";
																	
		
		$resulSet = $this->_bd->query($query);
		$resulSetPayDebts = $this->_bd->query($queryPayDebts);
		
		if( !($resulSet) && !($resulSetPayDebts) )
			return array();
		
		$movements_array = array();
		
		if( mysqli_num_rows($resulSet) > 0 )
			while($row = mysqli_fetch_assoc($resulSet))
			{
				array_push($movements_array, array('date' => $row['date'], 
													'shop_name' => $row['shop_name'], 
													'deptor_name' => $row['name'], 
													'tyre' => $row['tyre_size'].' '.$row['tyre_brand'].' '.$row['tyre_code'], 
													'description' => '', 
													'amount' => $row['amount'], 
													'payment_bs' => $row['payment_bs'], 
													'payment_sus' => $row['payment_sus']));
			}
		
		if( mysqli_num_rows($resulSetPayDebts) > 0 )
			while($row = mysqli_fetch_assoc($resulSetPayDebts))
			{
				array_push($movements_array, array('date' => $row['date'], 
													'shop_name' => $row['shop_name'], 
													'deptor_name' => $row['name'], 
													'tyre' => '', 
													'description' => $row['description'], 
													'amount' => '', 
													'payment_bs' => $row['bs'], 
													'payment_sus' => $row['sus']));
			}
		
		if( !empty($movements_array) )
		{
			$sort = array();
			foreach($movements_array as $k=>$v)
			{
				$sort['date'][$k] = $v['date'];
				$sort['tyre'][$k] = $v['tyre'];
			}
			
			array_multisort($sort['date'], SORT_ASC, $sort['tyre'], SORT_DESC, $movements_array);
		}
		return $movements_array;
	}
}

?>