<script>
$(document).ready(function() {
	
	$("#kardexOutsTable").tablesorter({widthFixed: true, widgets: ['zebra']});
});
</script>

<?php

include('../../controller/c_kardex.php');
include('../../utils/config.php');

if( !empty($_POST['tyre_name']) &&
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
    if(empty($tyreId))
        $headerColspan = 5;
	
	$header = "$kardexName
				<br>
				<br>
				LLANTA: $tyre
				<br>
				TIENDA: $place
				<br>
				DEL: ".$config->toExportDateFormat($config->toBdDateFormat($dateIni))." AL: ".$config->toExportDateFormat($config->toBdDateFormat($dateEnd));

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
			<th width='10%'>Fecha</th>";

    if(empty($tyreId))
        $html .= "<th width='30%'>Llanta</th>";

    $html .= "<th width='40%'>Tipo</th>
			<th width='40%'>Tienda destino</th>
			<th width='10%'>Cantidad</th>
		</tr>
		</thead><tbody>";
	
	$dataHeader = 'Fecha' . $colLimiter;
    if(empty($tyreId))
        $dataHeader .= 'Llanta' . $colLimiter;
    $dataHeader .= 'Tipo' . $colLimiter . 'Tienda destino' . $colLimiter . 'Cantidad';
		
	$dataArr = $control->outs( $shop_id, $tyreId, $type, $config->toBdDateFormat($dateIni), $config->toBdDateFormat($dateEnd) );

	$total = 0;

	foreach( $dataArr as $data )
	{
		$type = 'Traspaso';
		if( $data['entry_out'] == 'sale')
			$type = 'Venta';
		
		$html .= 
			'<tr>
				<td>'.$config->toUsrDateFormat($data['date']).'</td>';

        if(empty($tyreId))
            $html .='<td>'.$data['tyre'].'</td>';

        $html .='<td>'.$type.'</td>
				<td>'.$data['destination'].'</td>
				<td align="right">'.$data['amount'].'</td>';
			
			$total += $data['amount'];
		
		$dataTable .= $config->toExportDateFormat($data['date']);

        if(empty($tyreId))
            $dataTable .= $colLimiter . $data['tyre'];

        $dataTable .= $colLimiter . $type
                    . $colLimiter . $data['destination']
					. $colLimiter . $data['amount']
					. $rowLimiter;
		
		$html .= '</tr>';
	}

    $rows = 3;
    if(empty($tyreId))
        $rows = 4;
		
	$html .= 
		"</tbody>
		<tr>
			<td colspan='".$rows."'>&nbsp;</td>
			<th align='right'>$total</th>
		</tr>
	</table>";

    $dataFooter = '';
    if(empty($tyreId))
        $dataFooter .= $colLimiter;

    $dataFooter .= $colLimiter . $colLimiter . $colLimiter. $total;
	
	$exportLink = "<h3><a href='../utils/excel_generator.php?name=$kardexName&header=$header&headerColspan=$headerColspan&colHeaders=$dataHeader&table=$dataTable&footer=$dataFooter'>..Exportar..</a></h3>";

	echo $html . $exportLink;
}
?>