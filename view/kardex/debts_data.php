<script>
$(document).ready(function() {
	
	$("#kardexDebsTable").tablesorter({widthFixed: true, widgets: ['zebra']});
});
</script>

<?php

include('../../controller/c_kardex.php');
include('../../utils/config.php');

	$deptorId = trim($_POST['deptor_id']);
	$deptor = trim($_POST['deptor_name']);
	$shop_id = trim($_POST['place_code']);
	$place = trim($_POST['place_name']);
	
	$config = Config::getInstance();
	$control = new ControllerKardex();
	
	$kardexName = 'KARDEX DE DEUDAS';
	$dataTable = '';
	$rowLimiter = '@';
	$colLimiter = '|';
	$headerColspan = 8;
	
	$header = "$kardexName
				<br>
				<br>
				DEUDOR: $deptor
				<br>
				TIENDA: $place";

	$html = 
	"<table border='0' align='center' width='100%'>
		<tr>
			<th colspan='$headerColspan' >
				$header
			</th>
		</tr>
	</table>
	<table border='0' align='center' width='100%' id='kardexDebsTable' class='tablesorter' >
		<thead>
		<tr>
			<th width='10%'>Fecha</th>
			<th width='15%'>Tienda</th>
			<th width='15%'>Deudor</th>
			<th width='20%'>Llanta</th>
			<th width='20%'>Descripcion</th>
			<th width='6%'>Cantidad</th>
			<th width='7%'>Bs</th>
			<th width='7%'>Sus</th>
		</tr>
		</thead><tbody>";
	
	$dataHeader = 'Fecha' . $colLimiter .
					'Tienda' . $colLimiter .
					'Deudor' . $colLimiter .
					'Llanta' . $colLimiter .
					'Descripcion' . $colLimiter .
					'Cantidad' . $colLimiter .
					'Bs' . $colLimiter .
					'Sus';
		
	$config = Config::getInstance();
	$dataArr = $control->debts( $shop_id, $deptorId );

	$totalBs = 0;
	$totalSus = 0;

	foreach( $dataArr as $data )
	{
		$html .= 
			'<tr>
				<td>'.$config->toUsrDateFormat($data['date']).'</td>
				<td>'.$data['shop_name'].'</td>
				<td>'.$data['deptor_name'].'</td>
				<td>'.$data['tyre'].'</td>
				<td>'.$data['description'].'</td>
				<td>'.$data['amount'].'</td>
				<td align="right">'.$data['payment_bs'].'</td>
				<td align="right">'.$data['payment_sus'].'</td>';
			
			$totalBs += $data['payment_bs'];
			$totalSus += $data['payment_sus'];
		
		$dataTable .= $config->toExportDateFormat($data['date']) 
					. $colLimiter . $data['shop_name']
					. $colLimiter . $data['deptor_name']
					. $colLimiter . $data['tyre']
					. $colLimiter . $data['description']
					. $colLimiter . $data['amount']
					. $colLimiter . $data['payment_bs']
					. $colLimiter . $data['payment_sus']
					. $rowLimiter;
		
		$html .= '</tr>';
	}
		
	$html .= 
		"</tbody>
		<tr>
			<td colspan='6'>&nbsp;</td>
			<th align='right'>$totalBs</th>
			<th align='right'>$totalSus</th>
		</tr>
	</table>";
	
	$dataFooter = $colLimiter . $colLimiter . $colLimiter . $colLimiter . $colLimiter. $colLimiter. $totalBs . $colLimiter. $totalSus;
	
	$exportLink = "<h3><a href='../utils/excel_generator.php?name=$kardexName&header=$header&headerColspan=$headerColspan&colHeaders=$dataHeader&table=$dataTable&footer=$dataFooter'>..Exportar..</a></h3>";

	echo $html . $exportLink;
?>