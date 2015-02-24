<?php
include_once('../../utils/usr_permission.php');
$up = new UsrPermission();
$up->requestAccessPage(PermissionType::SHOPS);

include('../../controller/c_shops.php');
include('../../utils/validators.php');
include('../../utils/generic_tags.php');

$control = new ControllerShops();
$val = new Validators();

// Saving data if a shop was added, modified or deleted
if(isset($_POST['hEventShop']))
{
	$event = $_POST['hEventShop'];
	
	if($event == 'delete')
	{
		$delete = true;
		
		// Validating if the store is not related to other kind of data into the db
		if( $control->has_entries_outs_history( $_POST['hIdShop']) )
		{
			echo 'Nota: No se puede borrar la tienda pues contiene historial de entradas/salidas.<br>';
			$delete = false;
		}
		
		if( $control->contain_stocks( $_POST['hIdShop']) )
		{
			echo 'Nota: No se puede borrar la tienda pues contiene historial de stock.<br>';
			$delete = false;
		}
		
		if($delete)
		{
			if(!$control->delete_shop($_POST['hIdShop']))
				echo $error_db;
		}
	}
	else if($event == 'add' || $event == 'modify')
	{
		$message = '';
		
		$val->isEmpty($_POST['tInputNameShop'], "NOMBRE", $message);
		
		if(empty($message))
		{
			if(!$control->save_shop($_POST['hIdShop'],
										$_POST['tInputNameShop'],
										$_POST['tInputInfoShop']))
				echo $error_db;
		}
		else
			echo $message;
	}
}
else
	echo $error;

?>