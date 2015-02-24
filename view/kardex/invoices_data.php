<script>
$(document).ready(function() {
	
	$("#kardexInvoicesTable").tablesorter({widthFixed: true, widgets: ['zebra']});
});
</script>

<?php

include('../../controller/c_kardex.php');
include('../../utils/config.php');

if( !empty($_POST['invoice_id']) && 
	!empty($_POST['invoice_number']) )
{
	$invoiceId = trim($_POST['invoice_id']);
	$invoiceNumber = trim($_POST['invoice_number']);

	$control = new ControllerKardex();
	
	$kardexName = 'REPORTE DE FACTURAS';
	$dataTable = '';
	$rowLimiter = '@';
	$colLimiter = '|';
	$headerColspan = 4;
	
	$header = "$kardexName
				<br>
				<br>
				FACTURA: $invoiceNumber";

	$html = 
	"<table border='0' align='center' width='100%'>
		<tr>
			<th colspan='$headerColspan' >
				$header
			</th>
		</tr>
	</table>
	<table border='0' align='center' width='100%' id='kardexInvoicesTable' class='tablesorter' >
		<thead>
		<tr>
			<th width='10%'>Fecha</th>
			<th width='35%'>Almacen</th>
			<th width='50%'>Llanta</th>
			<th width='5%'>Cantidad</th>
		</tr>
		</thead><tbody>";
		
	$dataHeader = 'Fecha' . $colLimiter . 'Almacen' . $colLimiter . 'Llanta' . $colLimiter . 'Cantidad';

	$config = Config::getInstance();
	$dataArr = $control->invoices( $invoiceId );

	$quantity = 0;

	foreach( $dataArr as $data )
	{
		$html .= 
			'<tr>
				<td>'.$config->toUsrDateFormat($data['date']).'</td>
				<td>'.$data['store'].'</td>
				<td>'.$data['tyre'].'</td>
				<td align="right">'.$data['amount'].'</td>';
			
		$quantity += $data['amount'];
		
		$dataTable .= $config->toExportDateFormat($data['date']) 
					. $colLimiter . $data['store']
					. $colLimiter . $data['tyre']
					. $colLimiter . $data['amount']
					. $rowLimiter;

		$html .= '</tr>';
	}
		
	$html .= 
		"</tbody>
		<tr>
			<td colspan='3'>&nbsp;</td>
			<th align='right'>$quantity</th>
		</tr>
	</table>";

	$dataFooter = $colLimiter . $colLimiter . $colLimiter. $quantity;
	
	$exportLink = "<h3><a href='../utils/excel_generator.php?name=$kardexName&header=$header&headerColspan=$headerColspan&colHeaders=$dataHeader&table=$dataTable&footer=$dataFooter'>..Exportar..</a></h3>";

	echo $html . $exportLink;
}
?>