<?php
include_once('../../utils/usr_permission.php');
$up = new UsrPermission();
$up->requestAccessPage(PermissionType::PLACES);

//session_start();

// Saving data if a expense was added, modified or deleted
if( isset($_POST['selectPlaceStore']) )
{
	$arr = explode('-', $_POST['selectPlaceStore'], 2);
	
	$_SESSION["idStore"] = $arr[0];
	$_SESSION['storeName'] = $arr[1];
}

if( isset($_POST['selectPlaceShop']) )
{
	$arr = explode('-', $_POST['selectPlaceShop'], 2);
	
	$_SESSION["idShop"] = $arr[0];	
	$_SESSION['shopName'] = $arr[1];
}

?>