<?php
include_once('../../utils/config.php');
include_once('../../model/query_processor.php');
include_once('c_stocks.php');
include_once('../../utils/usr_permission.php');


//session_start();

class ControllerStores
{
	// Shows a table with the complete list of stores
	public function store_table()
	{
		$counter = 1;
		$empty_row_to_show = 0;
		
		$html_empty_cell = '<td>&nbsp;</td>';
		
		$up = new UsrPermission();
		$action_a = $up->isPageActionAllowed(PermissionType::STORES, PermissionType::STORE_A);
		$action_d = $up->isPageActionAllowed(PermissionType::STORES, PermissionType::STORE_D);
		
		$html_table = '<h2>Dep&oacute;sitos</h2>';
		
		$html_table .= '
		<table id="storesTable" width="100%" border="0" align="center" class="tablesorter">
			<thead>
			<tr>
				<th width="25%">NOMBRE</th>
				<th width="25%">VIRTUAL</th>
				<th width="45%">INFORMACION</th>';
				if( $action_a == true || $action_d == true )
					$html_table .= '<th width="5%" >&nbsp;</th>';
				
		$html_table .= '</tr></thead><tbody>';
		
		//TODO: change the filters according the date y store that we are
		
		// Showing data into the table
		$qp = new QueryProcessor();
		$data_array = $qp->query_stores();
		
		foreach($data_array as $id => $store_object)
		{
			// Getting the entry_out object id
			$io_id = $store_object->get_id();
			
			$virtual = '';
			if(!empty($store_object->store_virtual))
			{
				$shop_obj = new ObjShop($store_object->store_virtual);
				$virtual = $shop_obj->shop_name;
			}
			
			$html_table .= "<tr>
								<td id='tdNameStore$io_id' >$store_object->store_name</td>
								<td id='tdTypeStore$io_id' virtual='$store_object->store_virtual'>$virtual</td>
								<td id='tdInfoStore$io_id' >$store_object->store_info</td>";
								if( $action_a == true || $action_d == true ){
									$html_table .= "<td align='center' >";
									
									if( $action_a )
										$html_table .= 
										"<a href='javascript:void(0)' class='bModifyStore' id='bModifyStore' title='Modificar' store='$io_id' ><img src='../icons/modify.png'></a>";
									if( $action_d )	
										$html_table .=
										"<a href='javascript:void(0)' class='bDeleteStore' id='bDeleteStore' title='Eliminar' store='$io_id' ><img src='../icons/delete.png'></a>";
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
	public function store_entries_outs_table($option)
	{
		$counter = 1;
		$empty_row_to_show = 0;
		
		$html_empty_cell = '<td>&nbsp;</td>';
		
		$up = new UsrPermission();
		$action_a = $up->isPageActionAllowed(PermissionType::STORES_MOVEMENTS, PermissionType::MOV_A);
		$action_d = $up->isPageActionAllowed(PermissionType::STORES_MOVEMENTS, PermissionType::MOV_D);
		
		$config = Config::getInstance();
		$startDate = date('Y-m-d', strtotime( $_SESSION['storeShowDate'] .' -3 month') );
		
		$startDateFormatted = $config->toUsrDateFormat( $startDate );
		$endDateFormatted = $config->toUsrDateFormat( $_SESSION['storeShowDate'] );
		
		// Data db filters
		$store_id = $_SESSION["idStore"];
		
		$virtual = '';
		if( $this->is_virtual($store_id) )
			$virtual = ' virtual ';
		
		$html_table = '<h2>Salidas: Dep&oacute;sito '.$virtual.' '.$_SESSION['storeName'] ." ($startDateFormatted - $endDateFormatted)</h2>";
		if( $option == 'entry' )
			$html_table = '<h2>Entradas: Dep&oacute;sito '.$virtual.' '. $_SESSION['storeName'] ." ($startDateFormatted - $endDateFormatted)</h2>";
		
		
		$html_table .= '
		<table id="entriesTable" width="100%" border="0" align="center" class="tablesorter">
			<thead><tr>
				<th width="6%">FECHA</th>
				<th width="18%">MEDIDA</th>
				<th width="18%">MARCA</th>
				<th width="18%">CODIGO</th>';
		
		if($option == 'entry')
		{
			$html_table .= 
				'<th width="10%">IMPORTADOR</th>
				<th width="10%">FACTURA</th>
				<th width="10%">QUIEN RECIBIO</th>';
		} else
		{
			$html_table .= 
				'<th width="15%">DESTINO</th>
				<th width="15%">QUIEN ENVIO</th>';
		}
		
		$html_table .= 
				'<th width="6%">CANT.</th>';
				if( ($action_a == true || $action_d == true) && (empty($virtual) || $option == 'entry') )
					$html_table .= '<th width="4%" >&nbsp;</th>';
				
		$html_table .= '</tr></thead><tbody>';
		
		$config = Config::getInstance();
		
		// Building "where" filter according the store, date and other vars
		$where = " store_id = $store_id AND entry_out = '$option' AND date >= '". $startDate ."' AND date <= '". $_SESSION['storeShowDate'] ."' ";
		
		// Showing data into the table
		$qp = new QueryProcessor();
		$data_array = $qp->query_stores_entries_outs($where);
		
		foreach($data_array as $id => $io_object)
		{
			// Getting the entry_out object id
			$io_id = $io_object->get_id();
			// Getting the store entry object
			$tyre_obj = new ObjTyre($io_object->tyre_id);
			
			if($option == 'entry')
			{
				// Getting the supplier object
				$supplier_obj = new ObjSupplier($io_object->supplier_id);
				// Getting the invoice object
				$invoice_obj = new ObjInvoice($io_object->invoice_id);
			} else
			{
				$destId;
				$destType;
				$destLabel;
				
				if(!empty($io_object->dest_store))
				{
					$destId = $io_object->dest_store;
					$store_obj = new ObjStore($io_object->dest_store);
					$destLabel = $store_obj->store_name;
					$destType = 'store';
				} else
				{
					$destId = $io_object->dest_shop;
					$shop_obj = new ObjShop($io_object->dest_shop);
					$destLabel = $shop_obj->shop_name;
					$destType = 'shop';
				}
			}
			
			$html_table .= "<tr>
								<td id='tdDateEntryStore$io_id' >".$config->toUsrDateFormat($io_object->date)."</td>
								
								<td id='tdTyreSizeEntryStore$io_id' tyre_id='$io_object->tyre_id' >$tyre_obj->tyre_size</td>
								<td id='tdTyreBrandEntryStore$io_id' >$tyre_obj->tyre_brand</td>
								<td id='tdTyreCodeEntryStore$io_id' >$tyre_obj->tyre_code</td>";
			
			if($option == 'entry')
			{
				$html_table .=	"<td id='tdSupplierEntryStore$io_id' supplier_id='$io_object->supplier_id' >$supplier_obj->name</td>
								<td id='tdInvoiceEntryStore$io_id' invoice_id='$io_object->invoice_id' >$invoice_obj->invoice_number</td>";
			} else
			{
				$html_table .=	"<td id='tdDestinationEntryStore$io_id' destination_id='$destId' type_destination='$destType' >$destLabel</td>";
			}
			
			$html_table .= "
								<td id='tdEmployeeEntryStore$io_id' >$io_object->employee</td>
								<td id='tdAmountEntryStore$io_id' align='right'>$io_object->amount</td>";
								if( ($action_a == true || $action_d == true) && (empty($virtual) || $option == 'entry') ){
									$html_table .= "<td align='center' >";
									
									if( $action_a )
										$html_table .= 
										"<a href='javascript:void(0)' class='bModifyIO' id='bModifyIO' title='Modificar' store_entry_out='$io_id' ><img src='../icons/modify.png'></a>";
									if( $action_d )	
										$html_table .=
										"<a href='javascript:void(0)' class='bDeleteIO' id='bDeleteIO' title='Eliminar' store_entry_out='$io_id' ><img src='../icons/delete.png'></a>";
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
								$html_empty_cell";
			
			if($option == 'entry')
				$html_table .=	"$html_empty_cell";
			
			$html_table .=		"$html_empty_cell
								$html_empty_cell
								$html_empty_cell";
								if( ($action_a == true || $action_d == true) && (empty($virtual) || $option == 'entry') )
									$html_table .= $html_empty_cell;
			$html_table .= 	'</tr>';
			$empty_row_to_show --;
		}
			
		$html_table .= '</tbody></table>'; // Closing table tag
		
		echo $html_table;
	}
	
	// Add/Modify a store data into the db
	public function save_store($id, $store_name, $store_virtual, $store_info)
	{
		if(empty($id))
			$objStore = new ObjStore();
		else
			$objStore = new ObjStore($id);
		
		$objStore->store_name = $store_name;
		$objStore->store_virtual = $store_virtual;
		$objStore->store_info = $store_info;
		
		if( $objStore->save() )
		{
			if( empty($id) )
			{
				include_once('c_roles.php');
				
				$roles = new ControllerRoles();
				$roles->initiateStoreUsersRoles( $objStore->get_id() );
			}
			
			return true;
		}
		else
			return false;
	}
	
	// Add/Modify a entry store data into the db
	public function save_entry($id, $store_id, $tyre_id, $supplier_id, $invoice_id, $date, $employee, $amount)
	{
		if(empty($id))
			$objStoreEntriesOuts = new ObjStoreEntriesOuts();
		else
			$objStoreEntriesOuts = new ObjStoreEntriesOuts($id);
		
		$oldAmount = $objStoreEntriesOuts->amount;
		
		$objStoreEntriesOuts->store_id = $store_id;
		$objStoreEntriesOuts->tyre_id = $tyre_id;
		$objStoreEntriesOuts->supplier_id = $supplier_id;
		$objStoreEntriesOuts->invoice_id = $invoice_id;
		$objStoreEntriesOuts->dest_store = null;
		$objStoreEntriesOuts->dest_shop = null;
		$objStoreEntriesOuts->date = $date;
		$objStoreEntriesOuts->entry_out = "entry";
		$objStoreEntriesOuts->employee = $employee;
		$objStoreEntriesOuts->amount = $amount;
		
		if($objStoreEntriesOuts->save())
		{
			$newAmount = $amount - $oldAmount;
			$stock = new ControllerStocks();
			$stock->movement($tyre_id, $store_id, '', $newAmount);
			return true;
		}
		else
			return false;
	}
	
	// Add/Modify a out store data into the db
	public function save_out($id, $store_id, $tyre_id, $dest_store, $dest_shop, $date, $employee, $amount)
	{
		if(empty($id))
			$objStoreEntriesOuts = new ObjStoreEntriesOuts();
		else
			$objStoreEntriesOuts = new ObjStoreEntriesOuts($id);
		
		$oldAmount = $objStoreEntriesOuts->amount;
		
		$objStoreEntriesOuts->store_id = $store_id;
		$objStoreEntriesOuts->tyre_id = $tyre_id;
		$objStoreEntriesOuts->supplier_id = null;
		$objStoreEntriesOuts->invoice_id = null;
		$objStoreEntriesOuts->dest_store = $dest_store;
		$objStoreEntriesOuts->dest_shop = $dest_shop;
		$objStoreEntriesOuts->date = $date;
		$objStoreEntriesOuts->entry_out = "out";
		$objStoreEntriesOuts->employee = $employee;
		$objStoreEntriesOuts->amount = $amount;
		
		if($objStoreEntriesOuts->save())
		{
			$newAmount = $amount - $oldAmount;
			$stock = new ControllerStocks();
			$stock->movement($tyre_id, $store_id, '', -$newAmount);

            if(!empty($dest_store))
            {
                $this->save_entry('', $dest_store, $tyre_id, 1, null, $date, $employee, $amount);
                $stock->movement($tyre_id, $dest_store, '', $newAmount);
            }
            else if (!empty($dest_shop))
            {
                include_once('c_shops.php');
                $shop = new ControllerShops();
                $shop->save_entry_out('', $dest_shop, $tyre_id, $store_id, '', $date, 'entry', $employee, $amount);
            }

			return true;
		}
		else
			return false;
	}
	
	// Add one or many outs store virtual data into the db
	public function save_virtual_store_outs($store_id)
	{
		$store = new ObjStore($store_id);
		
		$qp = new QueryProcessor();
		$stock = $qp->query_all_tyres_stocks_quantity($store_id, '');
		
		$data = '';
		foreach($stock as $item)
		{
			if( $item['quantity'] > 0 )
				$this->save_out('', $store_id, $item['tyre_id'], '', $store->store_virtual, date('Y-m-d'), $_SESSION['usr_name'], $item['quantity']);
		}

		return true;
	}
	
	// Delete a store data from the dbase_add_record
	public function delete_store($id)
	{
		$objStore = new ObjStore( $id );
		
		include_once('c_roles.php');
		
		$roles = new ControllerRoles();
		$roles->deleteAllStoreRoles( $id );
		
		// Deleting stocks
		$stock = new ControllerStocks();
		$stock->delete_all_store_stock( $id );
		
		
		// If the current selected store is the one to be deleted
		if( isset( $_SESSION['idStore'] ) )
		{
			if( $_SESSION['idStore'] == $id )
			{
				unset( $_SESSION['idStore'] );
				
				foreach( $_SESSION['alowedStores'] as $key => $value )
				{
					if( $key != $id && !isset($_SESSION['idStore']) )
					{
						$_SESSION['idStore'] = $key;
						$_SESSION['storeName'] = $value;
					}
				}
			}
		}
		
		// Delete the store from the session array
		unset($_SESSION['alowedStores'][$id]);
		
		return $objStore->remove();
	}
	
	// Delete a entry/out data from the dbase_add_record
	public function delete_entry_out($id)
	{
		$objStoreEntriesOuts = new ObjStoreEntriesOuts($id);
		
		$entry_out = $objStoreEntriesOuts->entry_out;
		$tyre_id = $objStoreEntriesOuts->tyre_id;
		$store_id = $objStoreEntriesOuts->store_id;
		$amount = $objStoreEntriesOuts->amount;
		$dest_store = $objStoreEntriesOuts->dest_store;
		$dest_shop = $objStoreEntriesOuts->dest_shop;
		
		if( $objStoreEntriesOuts->remove() )
		{
			$stock = new ControllerStocks();
			
			if($entry_out == 'entry')
				$stock->movement($tyre_id, $store_id, '', -$amount);
			else if ($entry_out == 'out')
			{
				$stock->movement($tyre_id, $dest_store, $dest_shop, -$amount);
				$stock->movement($tyre_id, $store_id, '', $amount);
			}
				
			return true;
		}
		else
			return false;
	}
	
	// Returns an array with stores without the current one
	public function stores_array($avoidCurrentStore)
	{
		$where = '';
		if($avoidCurrentStore)
			$where = ' store_id != '.$_SESSION["idStore"].' ';
		
		$qp = new QueryProcessor();
		return $qp->query_stores_array($where);
	}
	
	public function is_virtual($storeId)
	{
		$qp = new QueryProcessor();
		$store = $qp->query_stores_array(" store_id = $storeId ");
		
		$virtual = '';
		
		foreach($store as $s)
		{
			$virtual = $s['virtual'];
		}
		
		if( empty($virtual) )
			return false;
		else
			return true;
	}
	
	public function has_entries_outs_history($storeId)
	{
		$qp = new QueryProcessor();
		$store_e_o_1 = $qp->query_stores_entries_outs(" store_id = $storeId ");
		$store_e_o_2 = $qp->query_stores_entries_outs(" dest_store = $storeId ");
		$shop_e_o = $qp->query_shops_entries_outs(" source_store = $storeId ");
			
		return ( !empty( $store_e_o_1 ) || !empty( $store_e_o_2 ) || !empty( $shop_e_o ) );
	}
	
	// If the store contains a number > or < to 0, it will return true
	public function contain_stocks($storeId)
	{
		$qp = new QueryProcessor();
		$stock = $qp->query_all_tyres_stocks_quantity($storeId, '');
		
		foreach($stock as $item)
		{
			if( $item['quantity'] > 0 || $item['quantity'] < 0 )
				return true;
		}
		
		return false;
	}
	

} // End controller stores

?>