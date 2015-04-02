<script>$(document).ready(function() {		$("#kardexImportsTable").tablesorter({widthFixed: true, widgets: ['zebra']});});</script><?phpinclude('../../controller/c_kardex.php');include('../../utils/config.php');if( !empty($_POST['supplier_id']) && 	!empty($_POST['supplier_name']) &&	!empty($_POST['dateIni']) &&	!empty($_POST['dateEnd']) ){	$supplierId = trim($_POST['supplier_id']);	$supplier = trim($_POST['supplier_name']);	$dateIni = trim($_POST['dateIni']);	$dateEnd = trim($_POST['dateEnd']);		$config = Config::getInstance();	$control = new ControllerKardex();		$kardexName = 'REPORTE DE IMPORTADORES';	$dataTable = '';	$rowLimiter = '@';	$colLimiter = '|';	$headerColspan = 5;		$header = "REPORTE DE IMPORTADORES				<br>				<br>				IMPORTADOR: $supplier				<br>				DEL: ".$config->toExportDateFormat($config->toBdDateFormat($dateIni))." AL: ".$config->toExportDateFormat($config->toBdDateFormat($dateEnd));	$html = 	"<table border='0' align='center' width='100%'>		<tr>			<th colspan='$headerColspan' >				$header			</th>		</tr>	</table>	<table border='0' align='center' width='100%' id='kardexImportsTable' class='tablesorter' >		<thead>		<tr>			<th width='10%'>Fecha</th>			<th width='25%'>Almacen</th>			<th width='40%'>Llanta</th>			<th width='20%'>Factura</th>			<th width='5%'>Cantidad</th>		</tr>		</thead><tbody>";			$dataHeader = 'Fecha' . $colLimiter . 'Almacen' . $colLimiter . 'Llanta' . $colLimiter . 'Factura' . $colLimiter . 'Cantidad';	$dataArr = $control->imports( $supplierId, $config->toBdDateFormat($dateIni), $config->toBdDateFormat($dateEnd) );	$quantity = 0;	foreach( $dataArr as $data )	{		$html .= 			'<tr>				<td>'.$config->toUsrDateFormat($data['date']).'</td>				<td>'.$data['store'].'</td>				<td>'.$data['tyre'].'</td>				<td>'.$data['invoice'].'</td>				<td align="right">'.$data['amount'].'</td>';					$quantity += $data['amount'];				$dataTable .= $config->toExportDateFormat($data['date']) 					. $colLimiter . $data['store']					. $colLimiter . $data['tyre']					. $colLimiter . $data['invoice']					. $colLimiter . $data['amount']					. $rowLimiter;		$html .= '</tr>';	}			$html .= 		"</tbody>		<tr>			<td colspan='4'>&nbsp;</td>			<th align='right'>$quantity</th>		</tr>	</table>";	$dataFooter = $colLimiter . $colLimiter . $colLimiter . $colLimiter. $quantity;		$exportLink = "<h3><a href='../utils/excel_generator.php?name=$kardexName&header=$header&headerColspan=$headerColspan&colHeaders=$dataHeader&table=$dataTable&footer=$dataFooter'>..Exportar..</a></h3>";	echo $html . $exportLink;}?>