<?php
include('../../controller/c_shops.php');
include('../../utils/validators.php');
include('../../utils/generic_tags.php');

$control = new ControllerShops();
$val = new Validators();

// Saving data if a shop_entry_out was added, modified or deleted
if(isset($_POST['hEventSaleShop']))
{
	$event = $_POST['hEventSaleShop'];
	
	if($event == 'delete')
	{
		if(!$control->delete_sale($_POST['hIdSaleShop']))
			echo $error_db;
	}
	else if($event == 'add' || $event == 'modify')
	{
		$totalRows = $_POST['hTotalRowsSaleShop'];
		
		if($event != 'add')
			$totalRows = 1;
		
		$message = '';
		
		for($i=0; $i < $totalRows; $i++)
		{
			$index = '(' . ($i + 1) . ')';
			// VALIDATE php data
			
			if( $i == 0 || ( $i > 0 && isset($_POST['checkSaleShop'.$i]) ))
			{
				// Only if this values are not empty, the row data will be saved
				$val->isEmpty($_POST['hIdTyreSaleShop'.$i], "LLANTA $index", $message);
				
				$val->isEmpty($_POST['tInputAmountSaleShop'.$i], "CANTIDAD $index", $message);
				$val->isInt($_POST['tInputAmountSaleShop'.$i], "CANTIDAD $index", $message);
				
				$val->isDouble($_POST['tInputBsSaleShop'.$i], "Bs.", $message);
				$val->isDouble($_POST['tInputSusSaleShop'.$i], "Sus.", $message);
			}
		}
		
		if(empty($message))
		{
			$idCurrentShop = $_SESSION['idShop'];
			for($i=0; $i < $totalRows; $i++)
			{
				if( $i == 0 || ( $i > 0 && isset($_POST['checkSaleShop'.$i]) ))
				{
					if(!$control->save_sale($_POST['hIdSaleShop'], 
											$idCurrentShop, 
											$_POST['hIdTyreSaleShop'.$i], 
											$_SESSION['shopShowDate'], 
											$_POST['tInputAmountSaleShop'.$i], 
											$_POST['hIdDeptorSaleShop'.$i], 
											$_POST['tInputBsSaleShop'.$i], 
											$_POST['tInputSusSaleShop'.$i]))
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