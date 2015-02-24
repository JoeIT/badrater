<?php
include_once('../../model/query_processor.php');

class ControllerSuppliers
{
	// Shows a table with the complete list of suppliers
	public function suppliers_table()
	{
		$counter = 1;
		$empty_row_to_show = 0;
		
		$html_empty_cell = '<td>&nbsp;</td>';
		
		$up = new UsrPermission();
		$action_a = $up->isPageActionAllowed(PermissionType::SUPPLIERS, PermissionType::SUPPLIER_A);
		$action_d = $up->isPageActionAllowed(PermissionType::SUPPLIERS, PermissionType::SUPPLIER_D);
		
		$html_table = 
		'<h2>Importadores</h2>
		
		<table id="suppliersTable" name="suppliersTable" width="100%" border="0" align="center" class="tablesorter">
			<thead><tr>
				<th width="4%" align="center" >#</th>
				<th width="25%" >NOMBRE</th>';
				if( $action_a == true || $action_d == true )
					$html_table .= '<th width="6%" >&nbsp;</th>';
				
		$html_table .= '</tr></thead><tbody>';
		
		// Showing data into the table
		$qp = new QueryProcessor();
		$data_array = $qp->query_suppliers();
		
		foreach($data_array as $supplier_id => $supplier_object)
		{
			$id = $supplier_object->get_id();
			
			$html_table .= "<tr>
								<td align='center' >$counter</td>
								<td id='tdName$id' >$supplier_object->name</td>";
								if( $action_a == true || $action_d == true ){
									$html_table .= "<td align='center' >";
									
									if( $action_a )
										$html_table .= 
										"<a href='javascript:void(0)' class='bModifySup' id='bModifySup' title='Modificar' supplier='$id' ><img src='../icons/modify.png'></a>";
									if( $action_d )	
										$html_table .=
										"<a href='javascript:void(0)' class='bDeleteSup' id='bDeleteSup' title='Eliminar' supplier='$id' ><img src='../icons/delete.png'></a>";
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
	
	// Add/Modify a supplier data into the db
	public function save_supplier($id, $name, $info)
	{
		if(empty($id))
			$objSupplier = new ObjSupplier();
		else
			$objSupplier = new ObjSupplier($id);
		
		$objSupplier->name = $name;
		$objSupplier->info = $info;
		
		return $objSupplier->save();
	}
	
	// Delete a supplier data from the dbase_add_record
	public function delete_supplier($id)
	{
		$objSupplier = new ObjSupplier($id);
		return $objSupplier->remove();
	}
}

?>