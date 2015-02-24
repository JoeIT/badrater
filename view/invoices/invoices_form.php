<?php
include('../../controller/c_invoices.php');

$control = new ControllerInvoices();

// Saving data if a invoice was added, modified or deleted
if(isset($_POST['hEventInvoice']))
{
	$event = $_POST['hEventInvoice'];
	
	if($event == 'delete')
	{
		if($control->delete_invoice($_POST['hIdInv']))
			echo 'Ok';
		else
			echo 'Error_db';
	}
	else if($event == 'add' || $event == 'modify')
	{
		//if(VALIDATE php data)
		if(true)
			if($control->save_invoice($_POST['hIdInv'], $_POST['tInputDateInv'], $_POST['tInputNumberInv']))
				echo 'Ok';
			else
				echo 'Error_db';
		else
			echo 'Error_input_data';
	}
}
else
	echo 'Error';

?>