<?php
include_once('../../utils/usr_permission.php');
$up = new UsrPermission();
$up->requestAccessPage(PermissionType::DEPTORS);


include('../../controller/c_deptors.php');
include('../../utils/validators.php');
include('../../utils/generic_tags.php');

$control = new ControllerDeptors();
$val = new Validators();

// Saving data if a deptor was added, modified or deleted
if(isset($_POST['hEventDeptor']))
{
	$event = $_POST['hEventDeptor'];
	
	if($event == 'delete')
	{
		if(!$control->delete_deptor($_POST['hIdDeptor']))
			echo $error_db;
	}
	else if($event == 'add' || $event == 'modify')
	{
		$message = '';
		
		$val->isEmpty($_POST['tInputNameDeptor'], "NOMBRE", $message);
				
		if(empty($message))
		{
			if(!$control->save_deptor($_POST['hIdDeptor'], $_POST['tInputNameDeptor'], $_POST['tInputInfoDeptor']))
				echo $error_db;
		}
		else
			echo $message;
	}
}
else
	echo $error;

?>