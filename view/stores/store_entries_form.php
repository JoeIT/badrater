<?php
include_once('../../utils/usr_permission.php');
$up = new UsrPermission();
$up->requestAccessPage(PermissionType::STORES_MOVEMENTS);

include('../../controller/c_stores.php');
include('../../utils/validators.php');
include_once('../../utils/config.php');
include('../../utils/generic_tags.php');

$control = new ControllerStores();
$val = new Validators();


// Saving data if a tyre was added, modified or deleted
if(isset($_POST['hEventEntryStore']))
{
	$event = $_POST['hEventEntryStore'];
	
	if($event == 'delete')
	{
		if(!$control->delete_entry_out($_POST['hIdEntryStore']))
			$error_db;
	}
	else if($event == 'add' || $event == 'modify')
	{
		$totalRows = $_POST['hTotalRowsEntryStore'];
		
		if($event != 'add')
			$totalRows = 1;
		
		$message = '';
		
		for($i=0; $i < $totalRows; $i++)
		{
			$index = '(' . ($i + 1) . ')';
			// VALIDATE php data
			
			if( $i == 0 || ( $i > 0 && isset($_POST['checkEntryStore'.$i]) ))
			{
				// Only if this values are not empty, the row data will be saved
				$val->isEmpty($_POST['tInputDateEntryStore'.$i], "FECHA $index", $message);
				
				$val->isEmpty($_POST['hIdTyreEntryStore'.$i], "LLANTA $index", $message);
				$val->isEmpty($_POST['hIdSupplierEntryStore'.$i], "IMPORTADOR $index", $message);
				
				$val->isEmpty($_POST['tInputAmountEntryStore'.$i], "CANTIDAD $index", $message);
				$val->isInt($_POST['tInputAmountEntryStore'.$i], "CANTIDAD $index", $message);
			}
		}
	
		if(empty($message))
		{
			$config = Config::getInstance();
			$idCurrentStore = $_SESSION["idStore"];
			
			// Saving data
			for($i=0; $i < $totalRows; $i++)
			{
				if( $i == 0 || ( $i > 0 && isset($_POST['checkEntryStore'.$i]) ))
				{
					$invoice_id = $_POST['hIdInvoiceEntryStore'.$i];
					
					// If the invoice id is empty, but the invoice number is filled, the the invoices is saved
					if( empty($invoice_id) && !empty($_POST['tInputInvoiceEntryStore'.$i]) )
					{
						$new_invoice = new ObjInvoice();
						$new_invoice->invoice_number = $_POST['tInputInvoiceEntryStore'.$i];
						$new_invoice->date = $config->getCurrentDate();
						
						if( $new_invoice->save() )
							$invoice_id = $new_invoice->get_id();
					}
				
					if(!$control->save_entry($_POST['hIdEntryStore'],
										$idCurrentStore, 
										$_POST['hIdTyreEntryStore'.$i],
										$_POST['hIdSupplierEntryStore'.$i],
										$invoice_id,
										$config->toBdDateFormat( $_POST['tInputDateEntryStore'.$i] ),
										$_POST['tInputEmployeeEntryStore'.$i],
										$_POST['tInputAmountEntryStore'.$i]) )
					{
						echo $error_db;
						break;
					}
				}
			}
		}
		else
			echo $message;
	}
}
else
	echo $error;

?>