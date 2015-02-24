<?php
include_once('../../model/query_processor.php');

class ControllerTyres
{
	// Shows a table with the complete stock of tyres
	public function tyres_table()
	{
		$counter = 1;
		$empty_row_to_show = 0;
		
		$html_empty_cell = '<td>&nbsp;</td>';
		
		$up = new UsrPermission();
		$action_a = $up->isPageActionAllowed(PermissionType::TYRES, PermissionType::TYRE_A);
		$action_d = $up->isPageActionAllowed(PermissionType::TYRES, PermissionType::TYRE_D);
		
		$html_table = 
		'<h2>Llantas</h2>
		
		<table id="tyresTable" name="tyresTable" width="100%" border="0" align="center" class="tablesorter">
			<thead><tr>
				<th width="4%" align="center" >#</th>
				<th width="30%" >MEDIDA</th>
				<th width="30%" >MARCA</th>
				<th width="30%" >CODIGO</th>';
				if( $action_a == true || $action_d == true )
					$html_table .= '<th width="6%" >&nbsp;</th>';
				
		$html_table .= '</tr></thead><tbody>';
		
		// Showing data into the table
		$qp = new QueryProcessor();
		$data_array = $qp->query_tyres();
		
		
		
		foreach($data_array as $tyre_id => $tyre_object)
		{
			$id = $tyre_object->get_id();
			
			$html_table .= "<tr>
								<td align='center' >$counter</td>
								<td id='tdSize$id' >$tyre_object->tyre_size</td>
								<td id='tdBrand$id' >$tyre_object->tyre_brand</td>
								<td id='tdCode$id' >$tyre_object->tyre_code</td>";
								if( $action_a == true || $action_d == true ){
									$html_table .= "<td align='center' >";
									
									if( $action_a )
										$html_table .= 
										"<a href='javascript:void(0)' class='bModifyTyre' id='bModifyTyre' title='Modificar' tyre='$id' ><img src='../icons/modify.png'></a>";
									if( $action_d )	
										$html_table .=
										"<a href='javascript:void(0)' class='bDeleteTyre' id='bDeleteTyre' title='Eliminar' tyre='$id' ><img src='../icons/delete.png'></a>";
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
								if( $action_a == true || $action_d == true )
									$html_table .= $html_empty_cell;
			$html_table .= 	'</tr>';
			$empty_row_to_show --;
		}
			
		$html_table .= '</tbody></table>'; // Closing table tag
		
		echo $html_table;
	}
	
	// Add/Modify a tyre data into the db
	public function save_tyre($id, $brand, $size, $code)
	{
		if(empty($id))
			$objTyre = new ObjTyre();
		else
			$objTyre = new ObjTyre($id);
		
		$objTyre->tyre_brand = $brand;
		$objTyre->tyre_size = $size;
		$objTyre->tyre_code = $code;
		
		return $objTyre->save();
	}
	
	// Delete a tyre data from the dbase_add_record
	public function delete_tyre($id)
	{
		$objTyre = new ObjTyre($id);
		return $objTyre->remove();
	}
}

?>