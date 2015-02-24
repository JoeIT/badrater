<?php
include_once('../../utils/config.php');
include('../../model/query_processor.php');

class ControllerInvoices
{
	// Shows a table with the complete stock of invoices
	public function invoices_table()
	{
		$counter = 1;
		$empty_row_to_show = 10;
		
		$html_empty_cell = '<td>&nbsp;</td>';
		
		$html_table = 
		'<h2>Facturas</h2>
		
		<table id="invoicesTable" name="invoicesTable" width="100%" border="2" align="center">
			<tr>
				<th width="4%" align="center" >#</th>
				<th width="20%" >FECHA</th>
				<th width="70%" >No. FACTURA</th>
				<th width="6%" >&nbsp;</th>
			</tr>';
		
		// Showing data into the table
		$qp = new QueryProcessor();
		$data_array = $qp->query_invoices();
		
		foreach($data_array as $invoice_id => $invoice_object)
		{
			$id = $invoice_object->get_id();
			
			$html_table .= "<tr>
								<td align='center' >$counter</td>
								<td id='tdDate$id' >$invoice_object->date</td>
								<td id='tdNumber$id' >$invoice_object->invoice_number</td>
								<td align='center' >
									<a href='javascript:void(0)' class='bModifyInvoice' id='bModifyInvoice' title='Modificar' invoice='$id' ><img src='../icons/modify.png'></a>
									<a href='javascript:void(0)' class='bDeleteInvoice' id='bDeleteInvoice' title='Eliminar' invoice='$id' ><img src='../icons/delete.png'></a>
								</td>
			</tr>";
			
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
			
		$html_table .= '</table>'; // Closing table tag
		
		echo $html_table;
	}
	
	// Add/Modify a invoice data into the db
	public function save_invoice($id, $date, $invoice_number)
	{
		if(empty($id))
			$objInvoice = new ObjInvoice();
		else
			$objInvoice = new ObjInvoice($id);
		
		
		if(!empty($date))
			$objInvoice->date = $date;
		else
		{
			$config = Config::getInstance();
			$objInvoice->date = $config->getCurrentDate();
		}
		
		$objInvoice->invoice_number = $invoice_number;
		
		return $objInvoice->save();
	}
	
	// Delete a invoice data from the dbase_add_record
	public function delete_invoice($id)
	{
		$objInvoice = new ObjInvoice($id);
		return $objInvoice->remove();
	}
}

?>