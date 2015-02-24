<?php
include_once('../../utils/usr_permission.php');
$up = new UsrPermission();
$up->requestAccessPage(PermissionType::TYRES);

include('../../controller/c_tyres.php');
include('../../utils/validators.php');
include('../../utils/generic_tags.php');

$control = new ControllerTyres();
$val = new Validators();

// Saving data if a tyre was added, modified or deleted
if(isset($_POST['hEventTyre']))
{
	$event = $_POST['hEventTyre'];
	
	if($event == 'delete')
	{
		if(!$control->delete_tyre($_POST['hId']))
			echo $error_db;
	}
	else if($event == 'add' || $event == 'modify')
	{
		$message = '';
		
		$val->isEmpty($_POST['tInputSizeTyre'], "MEDIDA", $message);
		$val->isEmpty($_POST['tInputBrandTyre'], "MARCA", $message);
		$val->isEmpty($_POST['tInputCodeTyre'], "CODIGO", $message);
		
		if(empty($message))
		{
			if(!$control->save_tyre($_POST['hId'],
									$_POST['tInputBrandTyre'], 
									$_POST['tInputSizeTyre'], 
									$_POST['tInputCodeTyre']))
				echo $error_db;
		}
		else
			echo $message;
	}
}
else
	echo $error;
?>