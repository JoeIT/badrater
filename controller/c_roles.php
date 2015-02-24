<?php
include_once('../../model/query_processor.php');

class ControllerRoles
{
	private $_qp;
	
	public function __construct()
	{
		$this->_qp = new QueryProcessor();
	}
	
	public function getUserArray()
	{
		
		return $this->_qp->query_users_array();
	}
	
	public function getStoresArray()
	{
		return $this->_qp->query_stores_array();
	}
	
	public function getShopsArray()
	{
		return $this->_qp->query_shops_array();
	}
	
	public function getUserPermissions($userId)
	{
		return $this->_qp->query_user_roles_array($userId);
	}
	
	public function getUserStorePermissions($userId)
	{
		return $this->_qp->query_store_permissions_array($userId);
	}
	
	public function getUserShopPermissions($userId)
	{
		return $this->_qp->query_shop_permissions_array($userId);
	}
	
	public function initiateUserRoles($user_id)
	{
		return $this->_qp->query_save_role($user_id, 
											'x', 
											'x', 
											'x', 
											'x', 
											'x', 
											'x', 
											'x', 
											'x', 
											'x', 
											'x', 
											'x', 
											'x', 
											'x');
	}
	
	public function initiateUserStoresRoles($user_id)
	{
		$storesArr = $this->_qp->query_stores_array();
		
		foreach($storesArr as $store)
		{
			$this->_qp->query_save_store_role($user_id, $store['id'], 'x', 'x', 'x');
		}
		
		return true;
	}
	
	public function initiateStoreUsersRoles($store_id)
	{
		$usersArr = $this->_qp->query_users_array();
		
		foreach($usersArr as $user)
		{
			$this->_qp->query_save_store_role($user['id'], $store_id, 'x', 'x', 'x');
		}
		
		return true;
	}
	
	public function initiateUserShopsRoles($user_id)
	{
		$shopsArr = $this->_qp->query_shops_array();
		
		foreach($shopsArr as $shop)
		{
			$this->_qp->query_save_shop_role($user_id, $shop['id'], 'x', 'x', 'x');
		}
		
		return true;
	}
	
	public function initiateShopUsersRoles($shop_id)
	{
		$usersArr = $this->_qp->query_users_array();
		
		foreach($usersArr as $user)
		{
			$this->_qp->query_save_shop_role($user['id'], $shop_id, 'x', 'x', 'x');
		}
		
		return true;
	}
	
	public function deleteAllUserRoles($user_id)
	{
		return $this->_qp->query_delete_all_user_roles($user_id);
	}
	
	public function deleteAllStoreRoles($store_id)
	{
		return $this->_qp->query_delete_all_store_roles($store_id);
	}
	
	public function deleteAllShopRoles($shop_id)
	{
		return $this->_qp->query_delete_all_shop_roles($shop_id);
	}
	
	public function updateRoles($user_id, 
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
		return $this->_qp->query_update_role($user_id, 
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
											$deptor_d);
	}
	
	public function updateStoreRoles($user_id, $store_id, $mov_v, $mov_a, $mov_d)
	{
		return $this->_qp->query_update_store_role($user_id, $store_id, $mov_v, $mov_a, $mov_d);
	}
	
	public function updateShopRoles($user_id, $shop_id, $mov_v, $mov_a, $mov_d, $mov_o)
	{
		return $this->_qp->query_update_shop_role($user_id, $shop_id, $mov_v, $mov_a, $mov_d, $mov_o);
	}
}

?>