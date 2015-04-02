<?php 
include('../../controller/c_kardex.php');
$control = new ControllerKardex();

if(!isset($_SESSION))
	session_start();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script>
$(document).ready(function() {
	$('#bGenerate').click(function(){
		
		if( $('#kardex_outs_tyre_id').val() == '' )
			alert( 'Seleccione una llanta.' );
		else if( $('#kardex_outs_date_ini').val() == '' )
			alert( 'Seleccione fecha inicial.' );
		else if( $('#kardex_outs_date_end').val() == '' )
			alert( 'Seleccione fecha final.' );
		else if( $('#kardex_outs_place option:selected').val() == '' )
			alert( 'Seleccione un lugar.' );
		else
		{
			$.post("kardex/outs_data.php", { tyre_id: $('#kardex_outs_tyre_id').val(), 
											tyre_name: $('#kardex_outs_tyre').val(), 
											dateIni: $('#kardex_outs_date_ini').val(), 
											dateEnd: $('#kardex_outs_date_end').val(), 
											place_code: $('#kardex_outs_place').val(),
											place_name: $('#kardex_outs_place option:selected').text(),
											type: $('#kardex_outs_type').val()
										}, function(data){
				$('#outs_content').html(data);
			});
		}
	});
	
	// Autocomplete tyre
	$("#kardex_outs_tyre").autocomplete({
		source: function( request, response ) {
			$.ajax({
				url: "../model/list_tyres.php",
				data: {searchCondition: request.term,
						searchType: function(){
							return $('#kardex_outs_tyre_type_search option:selected').val();
						}},
				type: 'post',
				dataType: "json",
				success: function(output) {
					response(output);					
				}
			});
		},
		select: function(event, ui){
			$("#kardex_outs_tyre_id").val(ui.item.id);
			$("#kardex_outs_tyre").attr('readonly', 'readonly');
		},
		autoFocus: true
	});
	
	$("#kardex_outs_date_ini").datepicker({
		maxDate: '0',
		minDate: new Date(2010, 0, 1),
		changeMonth: true,
		changeYear: true,
		dateFormat: 'dd/mm/yy',
		firstDay: 1,
		monthNamesShort: [ "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre" ],
		dayNamesMin: [ "Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa" ],
		onClose: function( selectedDate ) {
			$( "#kardex_outs_date_end" ).datepicker( "option", "minDate", selectedDate );
		}
	});
	
	$("#kardex_outs_date_end").datepicker({
		maxDate: '0',
		minDate: new Date(2010, 0, 1),
		changeMonth: true,
		changeYear: true,
		dateFormat: 'dd/mm/yy',
		firstDay: 1,
		monthNamesShort: [ "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre" ],
		dayNamesMin: [ "Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa" ],
		onClose: function( selectedDate ) {
			$( "#kardex_outs_date_ini" ).datepicker( "option", "maxDate", selectedDate );
		}
	});
	
	$("#bDelete_tyre_outs").click(function(){
		// Deleting the data of tyres in the respective row num
		$("#kardex_outs_tyre").val("");
		$("#kardex_outs_tyre_id").val("");
		
		// Removing the attribute read-only
		$("#kardex_outs_tyre").removeAttr("readonly");
	});
});

</script>

</head>

<body>

<table border="0" align="center">
	<tr>
		<th>Llanta:</th>
		<td align='center'>
			<input type='text' id='kardex_outs_tyre' style='width:85%'>
			<a href='javascript:void(0)' title='Borrar llanta' id='bDelete_tyre_outs' ><img src='../icons/delete.png'></a>
			<input type='hidden' id='kardex_outs_tyre_id'>
			<br>
			<select id='kardex_outs_tyre_type_search'>
				<option value='code'>C&oacute;digo</option>
				<option value='size'>Medida</option>
			</select>
		</td>
	</tr>
	<tr>
		<th>Fecha Inicial:</th>
		<td>
			<input type='text' id='kardex_outs_date_ini' readonly='readonly' style='width:100%' value='<?php echo date('d/m/Y'); ?>'>
		</td>
	</tr>
	<tr>
		<th>Fecha Final:</th>
		<td>
			<input type='text' id='kardex_outs_date_end' readonly='readonly' style='width:100%' value='<?php echo date('d/m/Y'); ?>'>
		</td>
	</tr>
	<tr>
		<th>Tienda:</th>
		<td align='center'>
			<select id='kardex_outs_place'>
				<option value=''>Seleccione</option>
				<?php
				$selectHtml = '';
                $shopsArray = $_SESSION['alowedShops'];
                foreach($shopsArray as $id => $val)
                {
                    $selectHtml .= "<option value='". $id ."'>". $val ."</option>";
                }
				
				echo $selectHtml;
				?>
			</select>
		</td>
	</tr>
	<tr>
		<th>Tipo:</th>
		<td align='center'>
			<select id='kardex_outs_type'>
				<option value='out'>Traspasos</option>
				<option value='sale'>Ventas</option>
				<option value=''>Ambos</option>
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

<div id='outs_content'>
	
</div>

</body>
</html>