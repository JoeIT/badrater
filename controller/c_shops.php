<?php
include_once('../../utils/usr_permission.php');
include_once('../../utils/config.php');
include_once('../../model/query_processor.php');
include_once('c_stocks.php');

//session_start();

class ControllerShops
{
	// Shows a table with the complete list of stores
	public function shop_table()
	{
		$counter = 1;
		$empty_row_to_show = 0;
		
		$html_empty_cell = '<td>&nbsp;</td>';
		
		$up = new UsrPermission();
		$action_a = $up->isPageActionAllowed(PermissionType::SHOPS, PermissionType::SHOP_A);
		$action_d = $up->isPageActionAllowed(PermissionType::SHOPS, PermissionType::SHOP_D);
			
		$html_table = '<h2>Tiendas</h2>';
		
		$html_table .= '
		<table id="shopsTable" width="100%" border="0" align="center" class="tablesorter">
			<thead><tr>
				<th width="40%">NOMBRE</th>
				<th width="55%">INFORMACION</th>';
				if( $action_a == true || $action_d == true )
					$html_table .= '<th width="5%" >&nbsp;</th>';
				
		$html_table .= '</tr></thead><tbody>';
		
		
		//TODO: change the filters according the date y store that we are
		
		// Showing data into the table
		$qp = new QueryProcessor();
		$data_array = $qp->query_shops();
		
		foreach($data_array as $id => $shop_object)
		{
			// Getting the entry_out object id
			$shop_id = $shop_object->get_id();
			
			$html_table .= "<tr>
								<td id='tdNameShop$shop_id' >$shop_object->shop_name</td>
								<td id='tdInfoShop$shop_id' >$shop_object->shop_info</td>";
								if( $action_a == true || $action_d == true ){
									$html_table .= "<td align='center' >";
									
									if( $action_a )
										$html_table .= 
										"<a href='javascript:void(0)' class='bModifyShop' id='bModifyShop' title='Modificar' shop='$shop_id' ><img src='../icons/modify.png'></a>";
									if( $action_d )	
										$html_table .=
										"<a href='javascript:void(0)' class='bDeleteShop' id='bDeleteShop' title='Eliminar' shop='$shop_id' ><img src='../icons/delete.png'></a>";
								$html_table .=  '</td>';
								}
			$html_table .=  '</tr>';
			
			$counter ++;
			$empty_row_to_show --;
		}
		
		// Fill the table with empty rows if is needed
		while($empty_row_to_show > 0)
		{
			$html_table .= "<tr>
								$html_empty_cell
								$html_empty_cell";
								if( $action_a == true || $action_d == true )
									$html_table .= $html_empty_cell;
			$html_table .= 	'</tr>';
			$empty_row_to_show --;
		}
			
		$html_table .= '</tbody></table>'; // Closing table tag
		
		echo $html_table;
	}
	
	// Shows a table with the complete list of entrys
	public function shop_entries_table()
	{
		$counter = 1;
		$empty_row_to_show = 0;
		
		$html_empty_cell = '<td>&nbsp;</td>';
		
		$config = Config::getInstance();
		$entryDate = $config->toUsrDateFormat( $_SESSION['shopShowDate'] );
		
		$html_table = '<h2>Entradas: Tienda ' . $_SESSION['shopName'] . " ($entryDate)</h2>";
		
		
		$html_table .= '
		<table id="entriesTable" width="100%" border="0" align="center" class="tablesorter">
			<thead><tr>
				<th width="6%">CANT.</th>
				<th width="20%">MEDIDA</th>
				<th width="20%">MARCA</th>
				<th width="20%">CODIGO</th>
				<th width="15%">FUENTE</th>
			</tr></thead><tbody>';
		
		
		//TODO: change the filters according the date y shop that we are
		// Data db filters
		$shop_id = $_SESSION["idShop"];

        // Building "where" filter according the shop, date and other vars
        $where = " shop_id = $shop_id AND entry_out = 'entry' AND date = '". $_SESSION['shopShowDate'] ."' ";
		
		// Showing data into the table
		$qp = new QueryProcessor();
		$data_array = $qp->query_shops_entries_outs($where);
		//$data_array = $qp->query_shops_entries('', $shop_id, $_SESSION['shopShowDate']);


        foreach($data_array as $id => $io_object)
        {
            $tyre_obj = new ObjTyre($io_object->tyre_id);

            if(!empty($io_object->source_store))
            {
                $store_obj = new ObjStore($io_object->source_store);
                $destLabel = $store_obj->store_name;
            } else
            {
                $shop_obj = new ObjShop($io_object->source_shop);
                $destLabel = $shop_obj->shop_name;
            }

            $html_table .= "<tr>
								<td align='right'>".$io_object->amount."</td>
								<td>".$tyre_obj->tyre_size."</td>
								<td>".$tyre_obj->tyre_brand."</td>
								<td>".$tyre_obj->tyre_code."</td>
								<td>".$destLabel."</td>
			</tr>";

            $counter ++;
            $empty_row_to_show --;
        }

		/*foreach($data_array as $value)
		{
			
			
			$html_table .= "<tr>
								<td align='right'>".$value['amount']."</td>
								<td>".$value['size']."</td>
								<td>".$value['brand']."</td>
								<td>".$value['code']."</td>
								<td>".$value['source']."</td>								
			</tr>";
			
			$counter ++;
			$empty_row_to_show --;
		}*/
		
		// Fill the table with empty rows if is needed
        while($empty_row_to_show > 0)
		{
			$html_table .= "<tr>
								$html_empty_cell
								$html_empty_cell
								$html_empty_cell
								$html_empty_cell
								$html_empty_cell
							</tr>";
			$empty_row_to_show --;
		}
			
		$html_table .= '</tbody></table>'; // Closing table tag
		
		echo $html_table;
	}
	
	// Shows a table with the complete list of outs
	public function shop_entries_outs_table($option)
	{
		$counter = 1;
		$empty_row_to_show = 0;
		
		$html_empty_cell = '<td>&nbsp;</td>';
		
		$up = new UsrPermission();
		$action_a = $up->isPageActionAllowed(PermissionType::SHOPS_MOVEMENTS, PermissionType::MOV_A);
		$action_d = $up->isPageActionAllowed(PermissionType::SHOPS_MOVEMENTS, PermissionType::MOV_D);
		$action_o = $up->isPageActionAllowed(PermissionType::SHOPS_MOVEMENTS, PermissionType::MOV_O);
		
		$config = Config::getInstance();
		$eoDate = $config->toUsrDateFormat( $_SESSION['shopShowDate'] );
		
		$html_table = '<h2>Salidas: Tienda ' . $_SESSION['shopName'] . " ($eoDate)</h2>";
		if($option == 'entry')
			$html_table = '<h2>Entradas: Tienda ' . $_SESSION['shopName'] . " ($eoDate)</h2>";
		
		
		$html_table .= '
		<table id="entriesOutsTable" width="100%" border="0" align="center" class="tablesorter">
			<thead><tr>
				<th width="6%">CANT.</th>
				<th width="20%">MEDIDA</th>
				<th width="20%">MARCA</th>
				<th width="20%">CODIGO</th>';
		if($option == 'entry')
			$html_table .=
				'<th width="15%">FUENTE</th>
				<th width="15%">QUIEN RECIBIO</th>';
		else
			$html_table .=
				'<th width="15%">DESTINO</th>
				<th width="15%">QUIEN DIO</th>';
			
			if( ($action_a == true || $action_d == true) && $action_o == true )
				$html_table .= '<th width="4%" >&nbsp;</th>';
				
		$html_table .= '</tr></thead><tbody>';
		
		
		//TODO: change the filters according the date y shop that we are
		// Data db filters
		$shop_id = $_SESSION["idShop"];
		
		// Building "where" filter according the shop, date and other vars
		$where = " shop_id = $shop_id AND entry_out = '$option' AND date = '". $_SESSION['shopShowDate'] ."' ";
		
		// Showing data into the table
		$qp = new QueryProcessor();
		$data_array = $qp->query_shops_entries_outs($where);
		
		foreach($data_array as $id => $io_object)
		{
			// Getting the entry_out object id
			$io_id = $io_object->get_id();
			// Getting the shop entry object
			$tyre_obj = new ObjTyre($io_object->tyre_id);
			
			$destId;
			$destType;
			$destLabel;
			
			if(!empty($io_object->source_store))
			{
				$destId = $io_object->source_store;
				$store_obj = new ObjStore($io_object->source_store);
				$destLabel = $store_obj->store_name;
				$destType = 'store';
			} else
			{
				$destId = $io_object->source_shop;
				$shop_obj = new ObjShop($io_object->source_shop);
				$destLabel = $shop_obj->shop_name;
				$destType = 'shop';
			}
			
			
			$html_table .= "<tr>
								<td id='tdAmountEOShop$io_id' align='right'>$io_object->amount</td>
								
								<td id='tdTyreSizeEOShop$io_id' tyre_id='$io_object->tyre_id' >$tyre_obj->tyre_size</td>
								<td id='tdTyreBrandEOShop$io_id' >$tyre_obj->tyre_brand</td>
								<td id='tdTyreCodeEOShop$io_id' >$tyre_obj->tyre_code</td>
								
								<td id='tdDestinationEOShop$io_id' destination_id='$destId' type_destination='$destType' >$destLabel</td>
								<td id='tdEmployeeEOShop$io_id' >$io_object->employee</td>";
								if( ($action_a == true || $action_d == true) && $action_o == true ){
									$html_table .= "<td align='center' >";
									
									if( $action_a )
										$html_table .= 
										"<a href='javascript:void(0)' class='bModifyIO' id='bModifyIO' title='Modificar' shop_entry_out='$io_id' ><img src='../icons/modify.png'></a>";
									if( $action_d )	
										$html_table .=
										"<a href='javascript:void(0)' class='bDeleteIO' id='bDeleteIO' title='Eliminar' shop_entry_out='$io_id' ><img src='../icons/delete.png'></a>";
								$html_table .=  '</td>';
								}
			$html_table .=  '</tr>';
			
			$counter ++;
			$empty_row_to_show --;
		}
		
		// Fill the table with empty rows if is needed
		while($empty_row_to_show > 0)
		{
			$html_table .= "<tr>
								$html_empty_cell
								$html_empty_cell
								$html_empty_cell
								$html_empty_cell
								$html_empty_cell
								$html_empty_cell";
								if( ($action_a == true || $action_d == true) && $action_o == true )
									$html_table .= $html_empty_cell;
			$html_table .= 	'</tr>';
			$empty_row_to_show --;
		}
			
		$html_table .= '</tbody></table>'; // Closing table tag
		
		echo $html_table;
	}
	
	public function sales(&$totalDayBsSales, &$totalDaySusSales)
	{
		$counter = 1;
		$empty_row_to_show = 0;
		
		$type = 'sale';
		
		$html_empty_cell = '<td>&nbsp;</td>';
		
		$config = Config::getInstance();
		$saleDate = $config->toUsrDateFormat( $_SESSION['shopShowDate'] );
		
		$html_table = "<h2>Ventas: Tienda ". $_SESSION['shopName'] ." ($saleDate)</h2>";
		
		$html_table .= '
		<table id="salesTable" width="100%" border="0" align="center" class="tablesorter">
			<thead><tr>
				<th width="6%">CANT.</th>
				<th width="20%">MEDIDA</th>
				<th width="20%">MARCA</th>
				<th width="20%">CODIGO</th>
				<th width="20%">FORMA DE PAGO</th>
				<th width="5%">Bs.</th>
				<th width="5%">Sus.</th>
				<th width="4%">&nbsp;</th>
			</tr></thead><tbody>';
		
		//TODO: change the filters according the date y shop that we are
		// Data db filters
		$shop_id = $_SESSION["idShop"];
		
		// Building "where" filter according the shop, date and other vars
		$where = " shop_id = $shop_id AND entry_out = '$type' AND date = '". $_SESSION['shopShowDate'] ."' ";
		
		// Showing data into the table
		$qp = new QueryProcessor();
		$data_array = $qp->query_shops_sales($where);
		
		$totalBs = 0.0;
		$totalSus = 0.0;
			
		foreach($data_array as $id => $io_object)
		{
			// Getting the entry_out object id
			$sale_id = $io_object->get_id();
			// Getting the shop entry object
			$tyre_obj = new ObjTyre($io_object->tyre_id);
			
			$typeSale = 'Contado';
			if(!empty($io_object->deptor_id))
			{
				$deptor_obj = new ObjDeptor($io_object->deptor_id);
				$typeSale = $deptor_obj->name;
			}
			
			$html_table .= "<tr>
								<td id='tdAmountSaleShop$sale_id' align='right'>$io_object->amount</td>
								
								<td id='tdTyreSizeSaleShop$sale_id' tyre_id='$io_object->tyre_id' >$tyre_obj->tyre_size</td>
								<td id='tdTyreBrandSaleShop$sale_id' >$tyre_obj->tyre_brand</td>
								<td id='tdTyreCodeSaleShop$sale_id' >$tyre_obj->tyre_code</td>
								
								<td id='tdPaymentTypeSaleShop$sale_id' deptor_id='$io_object->deptor_id' >$typeSale</td>
								<td id='tdPaymentBsSaleShop$sale_id' align='right'>$io_object->payment_bs</td>
								<td id='tdPaymentSusSaleShop$sale_id' align='right'>$io_object->payment_sus</td>
								
								<td align='center' >
									<a href='javascript:void(0)' class='bModifySale' id='bModifySale' title='Modificar' shop_sale='$sale_id' ><img src='../icons/modify.png'></a>
									<a href='javascript:void(0)' class='bDeleteSale' id='bDeleteSale' title='Eliminar' shop_sale='$sale_id' ><img src='../icons/delete.png'></a>
								</td>
			</tr>";
			
			$totalBs += $io_object->payment_bs;
			$totalSus += $io_object->payment_sus;
			
			$counter ++;
			$empty_row_to_show --;
		}
		
		
		// Fill the table with empty rows if is needed
		while($empty_row_to_show > 0)
		{
			$html_table .= "<tr>
								$html_empty_cell
								$html_empty_cell
								$html_empty_cell
								$html_empty_cell
								$html_empty_cell
								$html_empty_cell
								$html_empty_cell
								$html_empty_cell
							</tr>";
			$empty_row_to_show --;
		}
		
		// Sum results
		$html_table .=
			"<tr>
				<td colspan='5'>&nbsp;</td>
				<th align='right'>". number_format($totalBs, 2, '.', '') ."</th>
				<th align='right'>". number_format($totalSus, 2, '.', '') ."</th>				
				$html_empty_cell
			</tr>";
		
		$totalDayBsSales += $totalBs;
		$totalDaySusSales += $totalSus;
		
		$html_table .= '</tbody></table>'; // Closing table tag
		
		echo $html_table;
	}
	
	// Add/Modify a out shop data into the db
	public function save_shop($id, $shop_name, $shop_info)
	{
		$config = Config::getInstance();
		
		if(empty($id))
			$objShop = new ObjShop();
		else
			$objShop = new ObjShop($id);
		
		$objShop->shop_name = $shop_name;
		$objShop->shop_info = $shop_info;
		
		if( $objShop->save() )
		{
			if( empty($id) )
			{
				include_once('c_roles.php');
				
				$roles = new ControllerRoles();
				$roles->initiateShopUsersRoles( $objShop->get_id() );
			}
			
			return true;
		}
		else
			return false;
	}
	
	// Add/Modify a out shop data into the db
	public function save_entry_out($id, $shop_id, $tyre_id, $source_store, $source_shop, $date, $entry_out, $employee, $amount)
	{
		$config = Config::getInstance();
		
		if(empty($id))
			$objShopEntriesOuts = new ObjShopEntriesOuts();
		else
			$objShopEntriesOuts = new ObjShopEntriesOuts($id);
		
		$oldAmount = $objShopEntriesOuts->amount;
		
		$objShopEntriesOuts->shop_id = $shop_id;
		$objShopEntriesOuts->tyre_id = $tyre_id;
		$objShopEntriesOuts->source_store = $source_store;
		$objShopEntriesOuts->source_shop = $source_shop;
		$objShopEntriesOuts->date = $date;
		$objShopEntriesOuts->date_save = $config->getCurrentDateTime();
		$objShopEntriesOuts->entry_out = $entry_out;
		$objShopEntriesOuts->employee = $employee;
		$objShopEntriesOuts->amount = $amount;
		
		if($objShopEntriesOuts->save())
		{
			$newAmount = $amount - $oldAmount;
			$stock = new ControllerStocks();
			
			if($entry_out == 'entry')
			{
				$stock->movement($tyre_id, '', $shop_id, $newAmount);
			}
			else if($entry_out == 'out')
			{
				$stock->movement($tyre_id, '', $shop_id, -$newAmount);
				//$stock->movement($tyre_id, $source_store, $source_shop, $newAmount);
                $this->save_entry_out('', $source_shop, $tyre_id, '', $shop_id, $date, 'entry', $employee, $amount);
			}
			
			return true;
		}
		else
			return false;
	}
	
	// Add/Modify a out shop data into the db
	public function save_sale($id, $shop_id, $tyre_id, $date, $amount, $deptor_id, $payment_bs, $payment_sus)
	{
		$config = Config::getInstance();
		
		if(empty($id))
			$objShopEntriesOuts = new ObjShopEntriesOuts();
		else
			$objShopEntriesOuts = new ObjShopEntriesOuts($id);
		
		$oldAmount = $objShopEntriesOuts->amount;
		
		$objShopEntriesOuts->shop_id = $shop_id;
		$objShopEntriesOuts->tyre_id = $tyre_id;
		$objShopEntriesOuts->date = $date;
		$objShopEntriesOuts->date_save = $config->getCurrentDateTime();
		$objShopEntriesOuts->entry_out = "sale";
		$objShopEntriesOuts->amount = $amount;
		$objShopEntriesOuts->deptor_id = $deptor_id;
		$objShopEntriesOuts->payment_bs = $payment_bs;
		$objShopEntriesOuts->payment_sus = $payment_sus;
		
		
		if($objShopEntriesOuts->save())
		{
			$newAmount = $amount - $oldAmount;
			$stock = new ControllerStocks();
			
			$stock->movement($tyre_id, '', $shop_id, -$newAmount);
			
			return true;
		}
		else
			return false;
	}
	
	// Delete a shop data from the dbase_add_record
	public function delete_shop($id)
	{
		// If the shop allows to a virtual store, it can't be deleted
		if( $this->_is_linked_virtual($id) )
			return false;
			
		$objShop = new ObjShop( $id );
		
		include_once('c_roles.php');
				
		$roles = new ControllerRoles();
		$roles->deleteAllShopRoles( $id );
		
		// Deleting stocks
		$stock = new ControllerStocks();
		$stock->delete_all_shop_stock( $id );
		
		// If the current selected shop is the one to be deleted
		if( isset( $_SESSION['idShop'] ) )
		{
			if( $_SESSION['idShop'] == $id )
			{
				unset( $_SESSION['idShop'] );
				
				foreach( $_SESSION['alowedShops'] as $key => $value )
				{
					if( $key != $id && !isset($_SESSION['idShop']) )
					{
						$_SESSION['idShop'] = $key;
						$_SESSION['shopName'] = $value;
					}
				}
			}
		}
		
		// Delete the shop from the session array
		unset($_SESSION['alowedShops'][$id]);
		
		return $objShop->remove();
	}
	
	// Delete a entry/out data from the dbase_add_record
	public function delete_entry_out($id)
	{
		$objShopEntriesOuts = new ObjShopEntriesOuts($id);
		
		$tyre_id = $objShopEntriesOuts->tyre_id;
		$shop_id = $objShopEntriesOuts->shop_id;
		$destiny_shop_id = $objShopEntriesOuts->source_shop;
		$amount = $objShopEntriesOuts->amount;
		
		if( $objShopEntriesOuts->remove() )
		{
			$stock = new ControllerStocks();
			
			if( !empty($destiny_shop_id) )
				$stock->movement($tyre_id, '', $destiny_shop_id, -$amount);
			
			$stock->movement($tyre_id, '', $shop_id, $amount);
			
			return true;
		}
		else
			return false;
	}
	
	// Delete a sale data from the dbase_add_record
	public function delete_sale($id)
	{
		$objShopEntriesOuts = new ObjShopEntriesOuts($id);
		
		$tyre_id = $objShopEntriesOuts->tyre_id;
		$shop_id = $objShopEntriesOuts->shop_id;
		$amount = $objShopEntriesOuts->amount;
		
		if( $objShopEntriesOuts->remove() )
		{
			$stock = new ControllerStocks();
			$stock->movement($tyre_id, '', $shop_id, $amount);
			
			return true;
		}
		else
			return false;
	}
	
	// Returns an array with shops without the current one
	public function shops_array($avoidCurrentShop)
	{
		$where = '';
		if($avoidCurrentShop)
			$where = ' shop_id != '.$_SESSION["idShop"].' ';
		
		$qp = new QueryProcessor();
		return $qp->query_shops_array($where);
	}
	
	// Returns true if the shop is linked to a virtual store
	private function _is_linked_virtual($shopId)
	{
		$qp = new QueryProcessor();
		return $qp->query_is_linked_virtual( $shopId );
	}
	
	public function has_entries_outs_history($shopId)
	{
		$qp = new QueryProcessor();
		$store_e_o = $qp->query_stores_entries_outs(" dest_shop = $shopId ");
		$shop_e_o_1 = $qp->query_shops_entries_outs(" shop_id = $shopId ");
		$shop_e_o_2 = $qp->query_shops_entries_outs(" source_shop = $shopId ");
			
		return ( !empty( $store_e_o ) || !empty( $shop_e_o_1 ) || !empty( $shop_e_o_2 ) );
	}
	
	// If the shop contains a number > or < to 0, it will return true
	public function contain_stocks($shopId)
	{
		$qp = new QueryProcessor();
		$stock = $qp->query_all_tyres_stocks_quantity('', $shopId);
		
		foreach($stock as $item)
		{
			if( $item['quantity'] > 0 || $item['quantity'] < 0 )
				return true;
		}
		
		return false;
	}

} // End controller shops

?>