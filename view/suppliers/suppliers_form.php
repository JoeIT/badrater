<?php
include_once('../../utils/usr_permission.php');
$up = new UsrPermission();
$up->requestAccessPage(PermissionType::SUPPLIERS);

include('../../controller/c_suppliers.php');
include('../../utils/validators.php');
include('../../utils/generic_tags.php');

$control = new ControllerSuppliers();
$val = new Validators();

// Saving data if a supplier was added, modified or deleted
if(isset($_POST['hEventSup']))
{
	$event = $_POST['hEventSup'];
	
	if($event == 'delete')
	{
		if(!$control->delete_supplier($_POST['hIdSup']))
			echo $error_db;
	}
	else if($event == 'add' || $event == 'modify')
	{
		$message = '';
		
		$val->isEmpty($_POST['tInputNameSup'], "NOMBRE", $message);
		
		if(empty($message))
		{
			if(!$control->save_supplier($_POST['hIdSup'], $_POST['tInputNameSup'], $_POST['tInputInfoSup']))
				echo $error_db;
		}
		else
			echo $message;
	}
}
else
	echo $error;

?>