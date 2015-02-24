<?php
include_once('../../model/query_processor.php');

class ControllerExpenses
{
	// Shows a table with the complete stock of expenses
	public function expenses_table(&$totalDayBsSales, &$totalDaySusSales)
	{
		$counter = 1;
		$empty_row_to_show = 0;
		
		$html_empty_cell = '<td>&nbsp;</td>';
		
		$html_table = 
		'<h2>Gastos</h2>
		
		<table id="expensesTable" name="expensesTable" width="100%" border="0" align="center" class="tablesorter" >
			<thead>
			<tr>
				<th width="74%" >DESCRIPCION</th>
				<th width="10%" >Bs.</th>
				<th width="10%" >Sus.</th>
				<th width="6%" >&nbsp;</th>
			</tr>
			</thead><tbody>';
		
		
		$shop_id = $_SESSION["idShop"];
		
		$where = " shop_id = '$shop_id' AND date = '". $_SESSION['shopShowDate'] ."' ";
		
		// Showing data into the table
		$qp = new QueryProcessor();
		$data_array = $qp->query_expenses($where);
		
		$totalBs = 0;
		$totalSus = 0;
		
		foreach($data_array as $id => $expense_object)
		{
			$id = $expense_object->get_id();
			
			$html_table .= "<tr>
								<td id='tdDescription$id' >$expense_object->description</td>
								<td id='tdBs$id' align='right'>$expense_object->bs</td>
								<td id='tdSus$id' align='right'>$expense_object->sus</td>
								<td align='center' >
									<a href='javascript:void(0)' class='bModifyExpense' id='bModifyExpense' title='Modificar' expense='$id' ><img src='../icons/modify.png'></a>
									<a href='javascript:void(0)' class='bDeleteExpense' id='bDeleteExpense' title='Eliminar' expense='$id' ><img src='../icons/delete.png'></a>
								</td>
			</tr>";
			
			$totalBs += $expense_object->bs;
			$totalSus += $expense_object->sus;
			
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
							</tr>";
			$empty_row_to_show --;
		}
		
		// Sum results
		$html_table .=
			"</tbody>
			<tr>
				<td>&nbsp;</td>
				<th align='right'>". number_format($totalBs, 2, '.', '') ."</th>
				<th align='right'>". number_format($totalSus, 2, '.', '') ."</th>				
				$html_empty_cell
			</tr>";
		
		$totalDayBsSales -= $totalBs;
		$totalDaySusSales -= $totalSus;
		
		$html_table .= '</table>'; // Closing table tag
		
		echo $html_table;
	}
	
	// Add/Modify a expense data into the db
	public function save_expense($id, $shop_id, $date, $description, $bs, $sus)
	{
		if(empty($id))
			$objExpense = new ObjExpense();
		else
			$objExpense = new ObjExpense($id);
		
		
		$objExpense->shop_id = $shop_id;
		$objExpense->date = $date;
		$objExpense->description = $description;
		$objExpense->bs = $bs;
		$objExpense->sus = $sus;
		
		return $objExpense->save();
	}
	
	// Delete a expense data from the dbase_add_record
	public function delete_expense($id)
	{
		$objExpense = new ObjExpense($id);
		return $objExpense->remove();
	}
}  // End controller expenses
?>