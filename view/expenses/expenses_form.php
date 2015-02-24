<?php
session_start();

include('../../controller/c_expenses.php');
include('../../utils/validators.php');
include('../../utils/generic_tags.php');

$control = new ControllerExpenses();
$val = new Validators();

// Saving data if a expense was added, modified or deleted
if(isset($_POST['hEventExpense']))
{
	$event = $_POST['hEventExpense'];
	
	if($event == 'delete')
	{
		if(!$control->delete_expense($_POST['hIdExpense']))
			echo $error_db;
	}
	else if($event == 'add' || $event == 'modify')
	{
		$message = '';
		
		$val->isEmpty($_POST['tInputDescriptionExpense'], "DESCRIPCION", $message);
		
		$val->isDouble($_POST['tInputBsExpense'], "Pago Bus.", $message);
		$val->isDouble($_POST['tInputSusExpense'], "Pago Sus.", $message);
		
		if(empty($message))
		{
			if(!$control->save_expense($_POST['hIdExpense'],
										$_SESSION['idShop'],
										$_SESSION['shopShowDate'],
										$_POST['tInputDescriptionExpense'],
										$_POST['tInputBsExpense'],
										$_POST['tInputSusExpense']))
				echo $error_db;
		}
		else
			echo $message;
	}
}
else
	echo $error;

?>