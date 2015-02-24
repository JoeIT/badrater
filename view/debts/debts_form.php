<?php
session_start();

include('../../controller/c_debts.php');
include('../../utils/validators.php');
include('../../utils/generic_tags.php');

$control = new ControllerDebts();
$val = new Validators();

// Saving data if a debt was added, modified or deleted
if(isset($_POST['hEventDebt']))
{
	$event = $_POST['hEventDebt'];
	
	if($event == 'delete')
	{
		if(!$control->delete_debt($_POST['hIdDebt']))
			echo $error_db;
	}
	else if($event == 'add' || $event == 'modify')
	{
		$message = '';
		
		$val->isEmpty($_POST['tInputDescriptionDebt'], "DESCRIPCION", $message);
		$val->isEmpty($_POST['hIdDeptorDebt'], "DEUDOR", $message);
		
		$val->isDouble($_POST['tInputBsDebt'], "Pago Bs.", $message);
		$val->isDouble($_POST['tInputSusDebt'], "Pago Sus.", $message);
		
		if(empty($message))
		{
			if(!$control->save_debt($_POST['hIdDebt'],
									$_SESSION["idShop"],
									$_SESSION['shopShowDate'],
									$_POST['tInputDescriptionDebt'],
									$_POST['hIdDeptorDebt'],
									$_POST['tInputBsDebt'],
									$_POST['tInputSusDebt']))
				echo $error_db;
		}
		else
			echo $message;
	}
}
else
	echo $error;

?>