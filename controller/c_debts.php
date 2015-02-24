<?php
include_once('../../model/query_processor.php');

class ControllerDebts
{
	// Shows a table with the complete stock of debts
	public function debts_table(&$totalDayBsSales, &$totalDaySusSales)
	{
		$counter = 1;
		$empty_row_to_show = 0;
		
		$html_empty_cell = '<td>&nbsp;</td>';
		
		$html_table = 
		'<h2>Deudores(Cancelaciones)</h2>
		
		<table id="debtsTable" name="debtsTable" width="100%" border="0" align="center" class="tablesorter" >
			<thead>
			<tr>
				<th width="50%">DESCRIPCION</th>
				<th width="30%">NOMBRE</th>
				<th width="8%">Bs.</th>
				<th width="8%">Sus.</th>
				<th width="4%">&nbsp;</th>
			</tr>
			</thead><tbody>';
		
		
		$shop_id = $_SESSION["idShop"];
		
		$where = " shop_id = '$shop_id' AND date = '". $_SESSION['shopShowDate'] ."' ";
		
		// Showing data into the table
		$qp = new QueryProcessor();
		$data_array = $qp->query_debts($where);
		
		$totalBs = 0;
		$totalSus = 0;
		
		foreach($data_array as $id => $debt_object)
		{
			$id = $debt_object->get_id();
			
			$deptor_name = 'No registrado';
			if(!empty($debt_object->deptor_id))
			{
				$deptor_obj = new ObjDeptor($debt_object->deptor_id);
				$deptor_name = $deptor_obj->name;
			}
			
			$html_table .= "<tr>
								<td id='tdDescription$id' >$debt_object->description</td>
								<td id='tdDeptor$id' deptor_id='$debt_object->deptor_id' >$deptor_name</td>
								<td id='tdBs$id' align='right'>$debt_object->bs</td>
								<td id='tdSus$id' align='right'>$debt_object->sus</td>
								<td align='center' >
									<a href='javascript:void(0)' class='bModifyDebt' id='bModifyDebt' title='Modificar' debt='$id' ><img src='../icons/modify.png'></a>
									<a href='javascript:void(0)' class='bDeleteDebt' id='bDeleteDebt' title='Eliminar' debt='$id' ><img src='../icons/delete.png'></a>
								</td>
			</tr>";
			
			$totalBs += $debt_object->bs;
			$totalSus += $debt_object->sus;
			
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
							</tr>";
			$empty_row_to_show --;
		}
		
		// Sum results
		$html_table .=
			"</tbody>
			<tr>
				<td colspan='2'>&nbsp;</td>
				<th align='right'>". number_format($totalBs, 2, '.', '') ."</th>
				<th align='right'>". number_format($totalSus, 2, '.', '') ."</th>				
				$html_empty_cell
			</tr>";
		
		$totalDayBsSales += $totalBs;
		$totalDaySusSales += $totalSus;
		
		$html_table .= '</table>'; // Closing table tag
		
		echo $html_table;
	}
	
	// Add/Modify a debt data into the db
	public function save_debt($id, $shop_id, $date, $description, $deptor_id, $bs, $sus)
	{
		if(empty($id))
			$objDebt = new ObjDebt();
		else
			$objDebt = new ObjDebt($id);
		
		$objDebt->shop_id = $shop_id;		
		$objDebt->date = $date;		
		$objDebt->description = $description;
		$objDebt->deptor_id = $deptor_id;
		$objDebt->bs = $bs;
		$objDebt->sus = $sus;
		
		return $objDebt->save();
	}
	
	// Delete a debt data from the dbase_add_record
	public function delete_debt($id)
	{
		$objDebt = new ObjDebt($id);
		return $objDebt->remove();
	}
	
}  // End controller debts
?>