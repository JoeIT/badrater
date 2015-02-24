<?php
include_once('../../utils/usr_permission.php');
$up = new UsrPermission();
$up->requestAccessPage(PermissionType::ROLES);


include('../../controller/c_roles.php');

$control = new ControllerRoles();

// Saving data if a tyre was added, modified or deleted
if( isset($_POST['hUserId']) )
{
	$control->updateRoles($_POST['hUserId'],
							$_POST['sPermissions'],
							(isset($_POST['store_view']) || isset($_POST['store_add']) || isset($_POST['store_delete'])) ? 'y' : 'x',
							(isset($_POST['store_add'])) ? 'y' : 'x',
							(isset($_POST['store_delete'])) ? 'y' : 'x',
							(isset($_POST['shop_view']) || isset($_POST['shop_add']) || isset($_POST['shop_delete'])) ? 'y' : 'x',
							(isset($_POST['shop_add'])) ? 'y' : 'x',
							(isset($_POST['shop_delete'])) ? 'y' : 'x',
							(isset($_POST['tyre_add'])) ? 'y' : 'x',
							(isset($_POST['tyre_delete'])) ? 'y' : 'x',
							(isset($_POST['supplier_add'])) ? 'y' : 'x',
							(isset($_POST['supplier_delete'])) ? 'y' : 'x',
							(isset($_POST['deptor_add'])) ? 'y' : 'x',
							(isset($_POST['deptor_delete'])) ? 'y' : 'x' );
	
	
	//	Saving store permissions
	$storesArr = $control->getStoresArray();
	
	foreach($storesArr as $store)
	{
		$id = $store['id'];
		
		$control->updateStoreRoles($_POST['hUserId'],
								$id,
								(isset($_POST['mov_store_'. $id .'_view']) || isset($_POST['mov_store_'. $id .'_add']) || isset($_POST['mov_store_'. $id .'_delete'])) ? 'y' : 'x',
								(isset($_POST['mov_store_'. $id .'_add'])) ? 'y' : 'x',
								(isset($_POST['mov_store_'. $id .'_delete'])) ? 'y' : 'x');
	}
	
	$shopArr = $control->getShopsArray();
	
	foreach($shopArr as $shop)
	{
		$id = $shop['id'];
		
		$control->updateShopRoles($_POST['hUserId'],
								$id,
								(isset($_POST['mov_shop_'. $id .'_view']) || isset($_POST['mov_shop_'. $id .'_add']) || isset($_POST['mov_shop_'. $id .'_delete'])) ? 'y' : 'x',
								(isset($_POST['mov_shop_'. $id .'_add'])) ? 'y' : 'x',
								(isset($_POST['mov_shop_'. $id .'_delete'])) ? 'y' : 'x',
								(isset($_POST['mov_shop_'. $id .'_out'])) ? 'y' : 'x');
	}
	
}
?>