<?php
include_once('../../utils/usr_permission.php');
$up = new UsrPermission();
$up->requestAccessPage(PermissionType::STORES);

include('../../controller/c_stores.php');
include('../../utils/validators.php');
include('../../utils/generic_tags.php');

$control = new ControllerStores();
$val = new Validators();

// Saving data if a store was added, modified or deleted
if(isset($_POST['hEventStore']))
{
	$event = $_POST['hEventStore'];
	
	if($event == 'delete')
	{
		$delete = true;
		
		// Validating if the store is not related to other kind of data into the db
		if( $control->has_entries_outs_history( $_POST['hIdStore']) )
		{
			echo 'Nota: No se puede borrar el almacen pues contiene historial de entradas/salidas.<br>';
			$delete = false;
		}
		
		if( $control->contain_stocks( $_POST['hIdStore']) )
		{
			echo 'Nota: No se puede borrar el almacen pues contiene historial de stock.<br>';
			$delete = false;
		}
		
		if($delete)
		{
			if(!$control->delete_store( $_POST['hIdStore']) )
				echo $error_db;
		}
	}
	else if($event == 'add' || $event == 'modify')
	{
		$message = '';
		
		$val->isEmpty($_POST['tInputNameStore'], "NOMBRE", $message);
		//$val->isEmpty($_POST['selVirtual'], "TIPO", $message);
		
		if(empty($message))
		{
			if(!$control->save_store($_POST['hIdStore'],
									$_POST['tInputNameStore'],
									$_POST['selVirtual'],
									$_POST['tInputInfoStore']))
				echo $error_db;
		}
		else
			echo $message;
	}
}
else
	echo $error;

?>