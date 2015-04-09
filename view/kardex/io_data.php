<script>
$(document).ready(function() {
	
	$("#kardexIoTable").tablesorter({widthFixed: true, widgets: ['zebra']});
	
	/*$("#exportIo").click(function(){
		
		$.post("../utils/excel_generator.php", { name: $('#kardexNameIo').val(), 
										header: $('#headerIo').val(), 
										colHeaders: $('#columnHeadersIo').val(), 
										footer: $('#footerIo').val(), 
										table: $('#tableIo').val()
									}, function(data){
			//alert(data);
		});
	});*/
	
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
	$placeCode = trim($_POST['place_code']);
	$place = trim($_POST['place_name']);
	
	$config = Config::getInstance();
	$control = new ControllerKardex();
	
	$kardexName = 'KARDEX DE ENTRADAS Y SALIDAS';
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
				$place
				<br>
				DEL: ".$config->toExportDateFormat($config->toBdDateFormat($dateIni))." AL: ".$config->toExportDateFormat($config->toBdDateFormat($dateEnd));
	
	$html = 
	"<table border='0' align='center' width='100%' >
		<tr>
			<th colspan='$headerColspan' >
				$header
			</th>
		</tr>
	</table>
	
	<table border='0' align='center' width='100%' id='kardexIoTable' class='tablesorter' >
		<thead>
		<tr>
			<th width='30%'>Fecha</th>";

    if(empty($tyreId))
        $html .= "<th width='30%'>Llanta</th>";

    $html .=	"<th width='50%'>Tipo</th>
			<th width='10%'>Entrada</th>
			<th width='10%'>Salida</th>
		</tr>
		</thead><tbody>";
	
	$dataHeader = 'Fecha' . $colLimiter;
    if(empty($tyreId))
        $dataHeader .= 'Llanta' . $colLimiter;
    $dataHeader .= 'Tipo' . $colLimiter . 'Entrada' . $colLimiter . 'Salida';
	
	$store_id = $shop_id = '';

	$placeArr = explode('-', $placeCode, 2);

	if( $placeArr[0] == 'store' )
		$store_id = $placeArr[1];
	else
		$shop_id = $placeArr[1];

	$dataArr = $control->io( $store_id, $shop_id, $tyreId, $config->toBdDateFormat($dateIni), $config->toBdDateFormat($dateEnd) );

	$totalEntries = 0;
	$totalOuts = 0;
	
	$type = array('entry' => 'Entrada', 'out' => 'Salida', 'sale' => 'Venta');

	foreach( $dataArr as $data )
	{
		$html .= 
			'<tr>
				<td>'.$config->toUsrDateFormat($data['date']).'</td>';

        if(empty($tyreId))
            $html .='<td>'.$data['tyre'].'</td>';

        $html .='<td>'.$type[ $data['entry_out'] ].'</td>';
		
		$dataTable .= $config->toExportDateFormat($data['date']);

        if(empty($tyreId))
            $dataTable .= $colLimiter . $data['tyre'];

        $dataTable .= $colLimiter . $type[ $data['entry_out'] ];

		if($data['entry_out'] == 'entry')
		{
			$html .= '<td align="right">'.$data['amount'].'</td>
					<td>&nbsp;</td>';
			
			$dataTable .= $colLimiter . $data['amount'] . $colLimiter ;
			
			$totalEntries += $data['amount'];
		}
		else
		{
			$html .= '<td>&nbsp;</td>
					<td align="right">'.$data['amount'].'</td>';
			
			$dataTable .= $colLimiter . $colLimiter . $data['amount'];
			
			$totalOuts += $data['amount'];
		}

		$html .= '</tr>';
		$dataTable .= $rowLimiter;
	}

    $rows = 2;
    if(empty($tyreId))
        $rows = 3;
		
	$html .= 
		"</tbody>
		<tr>
			<td colspan='".$rows."'>&nbsp;</td>
			<th align='right'>$totalEntries</th>
			<th align='right'>$totalOuts</th>
		</tr>
	</table>";

    $dataFooter = '';
    if(empty($tyreId))
        $dataFooter .= $colLimiter;

	$dataFooter .= $colLimiter . $colLimiter . $totalEntries . $colLimiter . $totalOuts;
	
	/*$html .= "<input type='button' id='exportIo' value='Exportar a excel'>";
	
	$html .= "<input type='text' id='kardexNameIo' value='$kardexName'>";
	$html .= "<input type='text' id='headerIo' value='$header'>";
	$html .= "<input type='text' id='columnHeadersIo' value='$dataHeader'>";
	$html .= "<input type='text' id='footerIo' value='$dataFooter'>";
	$html .= "<input type='text' id='tableIo' value='$dataTable'>";
	$html .= "<input type='text' id='fileIo' value=''>";*/
	
	
	
	$exportLink = "<h3><a href='../utils/excel_generator.php?name=$kardexName&header=$header&headerColspan=$headerColspan&colHeaders=$dataHeader&table=$dataTable&footer=$dataFooter'>..Exportar..</a></h3>";

	echo $html . $exportLink;
}
?>