<?php
include_once('../../utils/usr_permission.php');
$up = new UsrPermission();
$up->requestAccessPage(PermissionType::ROLES);

include('../../controller/c_users.php');
include('../../utils/validators.php');
include('../../utils/generic_tags.php');

$control = new ControllerUsers();
$val = new Validators();

// Saving data if a user was added, modified or deleted
if(isset($_POST['hEventUser']))
{
	$event = $_POST['hEventUser'];
	
	if($event == 'delete')
	{
		if(!$control->delete_user($_POST['hId']))
			echo $error_db;
	}
	else if($event == 'add' || $event == 'modify')
	{
		$message = '';
		
		$val->isEmpty($_POST['tInputNameUser'], "NOMBRE", $message);
		
		$val->isEmpty($_POST['tInputLoginUser'], "LOGIN", $message);
		if( $control->existUser( $_POST['hId'], $_POST['tInputLoginUser']) )
			$val->showMessage("LOGIN", 'Ya existe un usuario con este mismo login, intente con otro', $message);
		
		$val->isEmpty($_POST['tInputPasswordUser'], "CONTRASENA", $message);
		$val->isEmpty($_POST['tInputPassword2User'], "REESCRIBA CONTRASENA", $message);
		
		if($_POST['tInputPasswordUser'] != $_POST['tInputPassword2User'])
			$val->showMessage("CONTRASENAS", 'Ambos campos de contrasenas deben de ser iguales', $message);
		
		if(empty($message))
		{
			if(!$control->save_user($_POST['hId'],
									$_POST['tInputNameUser'], 
									$_POST['tInputLoginUser'], 
									$_POST['tInputPasswordUser']))
				echo $error_db;
		}
		else
			echo $message;
	}
}
else
	echo $error;
?>