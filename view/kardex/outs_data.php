<script>
$(document).ready(function() {
	
	$("#kardexOutsTable").tablesorter({widthFixed: true, widgets: ['zebra']});
});
</script>

<?php

include('../../controller/c_kardex.php');
include('../../utils/config.php');

if( !empty($_POST['tyre_id']) && 
	!empty($_POST['tyre_name']) &&
	!empty($_POST['dateIni']) &&
	!empty($_POST['dateEnd']) &&
	!empty($_POST['place_code']) &&
	!empty($_POST['place_name']) )
{
	$tyreId = trim($_POST['tyre_id']);
	$tyre = trim($_POST['tyre_name']);
	$dateIni = trim($_POST['dateIni']);
	$dateEnd = trim($_POST['dateEnd']);
	$shop_id = trim($_POST['place_code']);
	$place = trim($_POST['place_name']);
	$type = trim($_POST['type']);
	
	$config = Config::getInstance();
	$control = new ControllerKardex();
	
	$kardexName = 'KARDEX DE SALIDAS';
	$dataTable = '';
	$rowLimiter = '@';
	$colLimiter = '|';
	$headerColspan = 4;
	
	$header = "$kardexName
				<br>
				<br>
				LLANTA: $tyre
				<br>
				TIENDA: $place
				<br>
				DEL: ".$config->toExportDateFormat($dateIni)." AL: ".$config->toExportDateFormat($dateEnd);

	$html = 
	"<table border='0' align='center' width='100%'>
		<tr>
			<th colspan='$headerColspan' >
				$header
			</th>
		</tr>
	</table>
	<table border='0' align='center' width='100%' id='kardexOutsTable' class='tablesorter' >
		<thead>
		<tr>
			<th width='10%'>Fecha</th>
			<th width='40%'>Tipo</th>
			<th width='40%'>Tienda destino</th>
			<th width='10%'>Cantidad</th>
		</tr>
		</thead><tbody>";
	
	$dataHeader = 'Fecha' . $colLimiter . 'Tipo' . $colLimiter . 'Tienda destino' . $colLimiter . 'Cantidad';
		
	$dataArr = $control->outs( $shop_id, $tyreId, $type, $config->toBdDateFormat($dateIni), $config->toBdDateFormat($dateEnd) );

	$total = 0;

	foreach( $dataArr as $data )
	{
		$type = 'Traspaso';
		if( $data['entry_out'] == 'sale')
			$type = 'Venta';
		
		$html .= 
			'<tr>
				<td>'.$config->toUsrDateFormat($data['date']).'</td>
				<td>'.$type.'</td>
				<td>'.$data['destination'].'</td>
				<td align="right">'.$data['amount'].'</td>';
			
			$total += $data['amount'];
		
		$dataTable .= $config->toExportDateFormat($data['date']) 
					. $colLimiter . $type
					. $colLimiter . $data['destination']
					. $colLimiter . $data['amount']
					. $rowLimiter;
		
		$html .= '</tr>';
	}
		
	$html .= 
		"</tbody>
		<tr>
			<td colspan='3'>&nbsp;</td>
			<th align='right'>$total</th>
		</tr>
	</table>";
	
	$dataFooter = $colLimiter . $colLimiter . $colLimiter. $total;
	
	$exportLink = "<h3><a href='../utils/excel_generator.php?name=$kardexName&header=$header&headerColspan=$headerColspan&colHeaders=$dataHeader&table=$dataTable&footer=$dataFooter'>..Exportar..</a></h3>";

	echo $html . $exportLink;
}
?>