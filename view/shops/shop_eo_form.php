<?php
include_once('../../utils/usr_permission.php');
$up = new UsrPermission();
$up->requestAccessPage(PermissionType::SHOPS_MOVEMENTS);

include('../../utils/config.php');
include('../../controller/c_shops.php');
include('../../utils/validators.php');
include('../../utils/generic_tags.php');

$control = new ControllerShops();
$val = new Validators();
$stock = new ControllerStocks();

// Saving data if a shop_entry_out was added, modified or deleted
if(isset($_POST['hEventEOShop']))
{
	$event = $_POST['hEventEOShop'];
	
	if($event == 'delete')
	{
		if(!$control->delete_entry_out($_POST['hIdEOShop']))
			echo $error_db;
	}
	else if($event == 'add' || $event == 'modify')
	{
		$totalRows = $_POST['hTotalRowsEOShop'];
		
		if($event != 'add')
			$totalRows = 1;
		
		$message = '';
		
		for($i=0; $i < $totalRows; $i++)
		{
			$index = '(' . ($i + 1) . ')';
			// VALIDATE php data
			
			if( $i == 0 || ( $i > 0 && isset($_POST['checkEOShop'.$i]) ))
			{
				// Only if this values are not empty, the row data will be saved
				$val->isEmpty($_POST['hIdTyreEOShop'.$i], "LLANTA $index", $message);
				
				$val->isEmpty($_POST['sInputShopEOShop'.$i], "TIENDA $index", $message);
				
				$val->isEmpty($_POST['tInputAmountEOShop'.$i], "CANTIDAD $index", $message);
				if($val->isInt($_POST['tInputAmountEOShop'.$i], "CANTIDAD $index", $message))
				{
					// Checking the stock quantity of the tyre
					if( !empty($_POST['hIdTyreEOShop'.$i]) && !empty($_POST['tInputAmountEOShop'.$i]) )
					{
						$quantity = $stock->getShopQuantity($_POST['hIdTyreEOShop'.$i], $_SESSION["idShop"]);
						if($quantity < $_POST['tInputAmountEOShop'.$i])
							$val->showMessage("CANTIDAD $index", "Solo se cuenta con $quantity en stock" , $message);
					}
				}
			}
		}
		
		if(empty($message))
		{
			$idCurrentShop = $_SESSION["idShop"];
			for($i=0; $i < $totalRows; $i++)
			{
				if( $i == 0 || ( $i > 0 && isset($_POST['checkEOShop'.$i]) ))
				{
					if(!$control->save_entry_out($_POST['hIdEOShop'],
											$idCurrentShop, 
											$_POST['hIdTyreEOShop'.$i],
											'',
											$_POST['sInputShopEOShop'.$i],
											$_SESSION['shopShowDate'],
											$_POST['thEOShop'],
											$_POST['tInputEmployeeEOShop'.$i],
											$_POST['tInputAmountEOShop'.$i]))
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