<?php
include_once('../../model/query_processor.php');

class ControllerDeptors
{
	// Shows a table with the complete stock of deptors
	public function deptors_table()
	{
		$counter = 1;
		$empty_row_to_show = 0;
		
		$html_empty_cell = '<td>&nbsp;</td>';
		
		$up = new UsrPermission();
		$action_a = $up->isPageActionAllowed(PermissionType::DEPTORS, PermissionType::DEPTOR_A);
		$action_d = $up->isPageActionAllowed(PermissionType::DEPTORS, PermissionType::DEPTOR_D);
		
		$html_table = 
		'<h2>Deudores</h2>
		
		<table id="deptorsTable" name="deptorsTable" width="100%" border="0" align="center" class="tablesorter">
			<thead><tr>
				<th width="4%" align="center" >#</th>
				<th width="30%" >NOMBRE</th>
				<th width="60%" >INFORMACION</th>';
				if( $action_a == true || $action_d == true )
					$html_table .= '<th width="6%" >&nbsp;</th>';
				
		$html_table .= '</tr></thead><tbody>';
		
		// Showing data into the table
		$qp = new QueryProcessor();
		$data_array = $qp->query_deptors();
		
		foreach($data_array as $id => $deptor_object)
		{
			$id = $deptor_object->get_id();
			
			$html_table .= "<tr>
								<td align='center' >$counter</td>
								<td id='tdName$id' >$deptor_object->name</td>
								<td id='tdInfo$id' >$deptor_object->info</td>";
								if( $action_a == true || $action_d == true ){
									$html_table .= "<td align='center' >";
									
									if( $action_a )
										$html_table .= 
										"<a href='javascript:void(0)' class='bModifyDeptor' id='bModifyDeptor' title='Modificar' deptor='$id' ><img src='../icons/modify.png'></a>";
									if( $action_d )	
										$html_table .=
										"<a href='javascript:void(0)' class='bDeleteDeptor' id='bDeleteDeptor' title='Eliminar' deptor='$id' ><img src='../icons/delete.png'></a>";
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
	
	// Add/Modify a deptor data into the db
	public function save_deptor($id, $name, $info)
	{
		if(empty($id))
			$objDeptor = new ObjDeptor();
		else
			$objDeptor = new ObjDeptor($id);
		
		
		$objDeptor->name = $name;
		$objDeptor->info = $info;
		
		return $objDeptor->save();
	}
	
	// Delete a deptor data from the dbase_add_record
	public function delete_deptor($id)
	{
		$objDeptor = new ObjDeptor($id);
		return $objDeptor->remove();
	}
	
}  // End controller deptors
?>