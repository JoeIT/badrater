<?php 
include('../../controller/c_kardex.php');
$control = new ControllerKardex();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script>
$(document).ready(function() {
	
	$('#bGenerate').click(function(){
		if( $('#kardex_stock_tyre_id').val() == '' && !($('#kardex_stock_all_tyres').is(':checked')) )
			alert( 'Seleccione una llanta.' );
		else
			$.post("kardex/stock_data.php", { tyre_id: $('#kardex_stock_tyre_id').val(), 
												tyre_name: $('#kardex_stock_tyre').val(),
												place_code: $('#kardex_stock_place').val(),
												place_name: $('#kardex_stock_place option:selected').text()
											}, function(data){
				$('#stock_content').html(data);
			});
	});
	
	$('#kardex_stock_all_tyres').change(function(){
		if( $(this).is(':checked') )
		{
			$('#kardex_stock_tyre').prop('disabled', true);
			$('#kardex_stock_tyre_type_search').prop('disabled', true);
			$('#bDelete_tyre_stock').hide();
			$('#kardex_stock_tyre').val('Todas las llantas');
			$('#kardex_stock_tyre_id').val('');
			
		}
		else
		{
			$('#kardex_stock_tyre').val('');
			$('#kardex_stock_tyre_type_search').prop('disabled', false);
			$('#kardex_stock_tyre').prop('disabled', false);
			$('#bDelete_tyre_stock').show();
		}
	});
	
	// Autocomplete tyre
	$("#kardex_stock_tyre").autocomplete({
		source: function( request, response ) {
			$.ajax({
				url: "../model/list_tyres.php",
				data: {searchCondition: request.term,
						searchType: function(){
							return $('#kardex_stock_tyre_type_search option:selected').val();
						}},
				type: 'post',
				dataType: "json",
				success: function(output) {
					response(output);					
				}
			});
		},
		select: function(event, ui){
			$("#kardex_stock_tyre_id").val(ui.item.id);
			$("#kardex_stock_tyre").attr('readonly', 'readonly');
		},
		autoFocus: true
	});
	
	$("#bDelete_tyre_stock").click(function(){
		// Deleting the data of tyres in the respective row num
		$("#kardex_stock_tyre").val("");
		$("#kardex_stock_tyre_id").val("");
		
		// Removing the attribute read-only
		$("#kardex_stock_tyre").removeAttr("readonly");
	});
});

</script>

</head>

<body>

<table border="0" align="center">
	<tr>
		<th>Llanta:</th>
		<td align='center'>
			TODAS >>> <input type='checkbox' id='kardex_stock_all_tyres'><br>
			<br>
			<input type='text' id='kardex_stock_tyre' style='width:85%'>
			<a href='javascript:void(0)' title='Borrar llanta' id='bDelete_tyre_stock' ><img src='../icons/delete.png'></a>
			<input type='hidden' id='kardex_stock_tyre_id'>
			<br>
			<select id='kardex_stock_tyre_type_search'>
				<option value='code'>C&oacute;digo</option>
				<option value='size'>Medida</option>
			</select>
		</td>
	</tr>
	<tr>
		<th>Lugar:</th>
		<td align='center'>
			<select id='kardex_stock_place'>
				<option value=''>Todos los lugares</option>
				<?php
				$selectHtml = '';
				session_start();
                $storesArray = $_SESSION['alowedStores'];
                foreach($storesArray as $id => $val)
                {
                    $selectHtml .= "<option value='store-". $id ."'>DEPOSITO: ". $val ."</option>";
                }

                $shopsArray = $_SESSION['alowedShops'];
                foreach($shopsArray as $id => $val)
                {
                    $selectHtml .= "<option value='shop-". $id ."'>TIENDA: ". $val ."</option>";
                }
				
				echo $selectHtml;
				?>
			</select>
		</td>
	</tr>
	<tr>
		<th colspan='2'>
			<input type='button' id='bGenerate' value='Generar kardex'>
		</th>
	</tr>
</table>

<br>
<br>

<div id='stock_content'>
	
</div>

</body>
</html>