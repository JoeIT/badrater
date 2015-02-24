<script>
$(document).ready(function() {
	
	$("#kardexStockTable").tablesorter({widthFixed: true, widgets: ['zebra']});
});
</script>

<?php

include('../../controller/c_kardex.php');

$tyreId = trim($_POST['tyre_id']);
$tyre = trim($_POST['tyre_name']);
$placeId = trim($_POST['place_code']);
$place = trim($_POST['place_name']);

$storeId = $shopId = '';

if( !empty($placeId) )
{
	$placeArr = explode('-', $placeId, 2);

	if( $placeArr[0] == 'store' )
		$storeId = $placeArr[1];
	else
		$shopId = $placeArr[1];
}

$control = new ControllerKardex();

$kardexName = 'KARDEX DE EXISTENCIAS';
$dataTable = '';
$rowLimiter = '@';
$colLimiter = '|';

if( empty($storeId) && empty($shopId) )
{
	$storesArr = $control->getAllStores();
	$shopsArr = $control->getAllShops();

	$cols = 4 + count($storesArr) + count($shopsArr);
	$widhtPercent = 100 / ($cols + 3);

	// Building the stock array data
	$dataArr = $control->stock( $tyreId, '', '' );

	$total = 0;
	$totalTyre = 0;

	// Cleaning variable to re-use
	$tyreId = '';

	$stockArray = array();

	foreach( $dataArr as $data )
	{
		if( $tyreId != '' && $data['tyre_id'] != $tyreId && $totalTyre != 0)
		{
			$rowArray['total'] = $totalTyre;
			array_push($stockArray, $rowArray);
		}
		
		if( $data['tyre_id'] != $tyreId )
		{
			$totalTyre = 0;
			$rowArray = array();
			$rowArray['tyre_brand'] = $data['tyre_brand'];
			$rowArray['tyre_size'] = $data['tyre_size'];
			$rowArray['tyre_code'] = $data['tyre_code'];
		}
		
		if( !empty($data['store_id']) )
		{
			$totalTyre += $data['quantity'];
			$rowArray[ 'store'.$data['store_id'] ] = $data['quantity'];
		}
		
		if( !empty($data['shop_id']) )
		{
			$totalTyre += $data['quantity'];
			$rowArray[ 'shop'.$data['shop_id'] ] = $data['quantity'];
		}
		
		$total += $data['quantity'];
		$tyreId = $data['tyre_id'];
	}

	if( $tyreId != '' && $totalTyre != 0 )
	{
		$rowArray['total'] = $totalTyre;
		array_push($stockArray, $rowArray);
	}
	
	$header = "$kardexName
				<br>
				<br>
				LLANTA: $tyre";
	
	$html = 
	"<table border='0' align='center' width='100%'>
		<tr>
			<th colspan='$cols' >
				$header
			</th>
		</tr>
		<tr>
	</table>
	<table border='0' align='center' width='100%' id='kardexStockTable' class='tablesorter' >
	<thead><tr>";

	$html .= '<th width="'.($widhtPercent * 2).'%">Medida</th>';
	$html .= '<th width="'.($widhtPercent * 2).'%">Marca</th>';
	$html .= '<th width="'.($widhtPercent * 2).'%">Codigo</th>';
	
	$dataHeader = 'Medida' . $colLimiter . 'Marca' . $colLimiter . 'Codigo';
	
	foreach($storesArr as $store)
	{
		$html .= "<th width='$widhtPercent%'>".$store['name']."</th>";
		
		$dataHeader .= $colLimiter . $store['name'];
	}
	foreach($shopsArr as $shop)
	{
		$html .= "<th width='$widhtPercent%'>".$shop['name']."</th>";
		
		$dataHeader .= $colLimiter . $shop['name'];
	}

	$html .= "<th width='$widhtPercent%'>Total</th>
		</tr></thead><tbody>";
	
	$dataHeader .= $colLimiter . 'Total';

	foreach($stockArray as $row)
	{
		$html .= '<tr>';
		
		$html .= '<td>'.$row['tyre_size'].'</td>';
		$html .= '<td>'.$row['tyre_brand'].'</td>';
		$html .= '<td>'.$row['tyre_code'].'</td>';
		
		$dataTable .= $row['tyre_size'] . $colLimiter . $row['tyre_brand'] . $colLimiter . $row['tyre_code'];
		
		foreach($storesArr as $store)
		{
			if( isset($row[ 'store'.$store['id'] ] ) )
			{
				$html .= '<td align="right">'.$row[ 'store'.$store['id'] ].'</td>';
				
				$dataTable .= $colLimiter . $row[ 'store'.$store['id'] ];
			}
			else
			{
				$html .= '<td align="right">0</td>';
				
				$dataTable .= $colLimiter . '0';
			}
		}
		
		foreach($shopsArr as $shop)
		{
			if( isset($row[ 'shop'.$shop['id'] ] ) )
			{
				$html .= '<td align="right">'.$row[ 'shop'.$shop['id'] ].'</td>';
				
				$dataTable .= $colLimiter . $row[ 'shop'.$shop['id'] ];
			}
			else
			{
				$html .= '<td align="right">0</td>';
				
				$dataTable .= $colLimiter . '0';
			}
		}
		
		$html .= '<td align="right">'.$row['total'].'</td>';
		
		$dataTable .= $colLimiter . $row['total'] . $rowLimiter;
		
		$html .= '</tr>';
	}
		
	$html .= 
		"</tbody>
		<tr>
			<td colspan='".($cols - 1)."'>&nbsp;</td>
			<th align='right'>$total</th>
		</tr>		
	</table>";
	
	$dataFooter = '';
	
	for($aux = ($cols - 1); $aux > 0; $aux--)
	{
		$dataFooter .= $colLimiter;
	}

	$dataFooter .= $total;
	
	$exportLink = "<h3><a href='../utils/excel_generator.php?name=$kardexName&header=$header&headerColspan=$cols&colHeaders=$dataHeader&table=$dataTable&footer=$dataFooter'>..Exportar..</a></h3>";

	echo $html . $exportLink;
}
else
{
	// Building the stock array data
	$dataArr = $control->stock( $tyreId, $storeId, $shopId );
	
	$headerColspan = 4;
	$header = "$kardexName
				<br>
				<br>
				$place
				<br>
				LLANTA: $tyre";
	
	$html = 
	"<table border='0' align='center' width='100%' >
		<tr>
			<th colspan='$headerColspan' >
				$header
			</th>
		</tr>
	</table>
	<table border='0' align='center' width='100%' id='kardexStockTable' class='tablesorter' >
		<thead>
		<tr>
			<th width='30%'>Medida</th>
			<th width='30%'>Marca</th>
			<th width='20%'>Codigo</th>
			<th width='20%'>Total</th>
		</tr>
		</thead><tbody>";
	
	$dataHeader = 'Medida' . $colLimiter . 'Marca' . $colLimiter . 'Codigo' . $colLimiter . 'Total';
	
	$total = 0;
	
	foreach( $dataArr as $data )
	{
		if( $data['quantity'] != 0 )
		{
			$html .= '
				<tr>
					<td>'.$data['tyre_size'].'</th>
					<td>'.$data['tyre_brand'].'</th>
					<td>'.$data['tyre_code'].'</th>
					<td align="right">'.$data['quantity'].'</th>
				</tr>';
			
			$total += $data['quantity'];
			
			$dataTable .= $data['tyre_size']
					. $colLimiter . $data['tyre_brand']
					. $colLimiter . $data['tyre_code']
					. $colLimiter . $data['quantity']
					. $rowLimiter;
		}
	}
	
	$html .= 
		"</tbody>
		<tr>
			<td colspan='3'>&nbsp;</td>
			<th align='right'>$total</th>
		</tr>
	</table>";
	
	$dataFooter = $colLimiter.$colLimiter.$colLimiter. $total;
	
	$exportLink = "<h3><a href='../utils/excel_generator.php?name=$kardexName&header=$header&headerColspan=$headerColspan&colHeaders=$dataHeader&table=$dataTable&footer=$dataFooter'>..Exportar..</a></h3>";

	echo $html . $exportLink;
}
?>