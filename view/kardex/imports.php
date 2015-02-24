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
		
		if( $('#kardex_imports_supplier_id').val() == '' )
			alert( 'Seleccione un importador.' );
		else if( $('#kardex_imports_date_ini').val() == '' )
			alert( 'Seleccione fecha inicial.' );
		else if( $('#kardex_imports_date_end').val() == '' )
			alert( 'Seleccione fecha final.' );
		else
		{
			$.post("kardex/imports_data.php", { supplier_id: $('#kardex_imports_supplier_id').val(), 
												supplier_name: $('#kardex_imports_supplier').val(), 
												dateIni: $('#kardex_imports_date_ini').val(), 
												dateEnd: $('#kardex_imports_date_end').val(),
										}, function(data){
				$('#imports_content').html(data);
			});
		}
	});
	
	// Autocomplete supplier
	$("#kardex_imports_supplier").autocomplete({
		source: function( request, response ) {
			$.ajax({
				url: "../model/list_suppliers.php",
				data: {searchCondition: request.term},
				type: 'post',
				dataType: "json",
				success: function(output) {
					response(output);					
				}
			});
		},
		select: function(event, ui){
			$("#kardex_imports_supplier_id").val(ui.item.id);
			$("#kardex_imports_supplier").attr('readonly', 'readonly');
		},
		autoFocus: true
	});
	
	$("#kardex_imports_date_ini").datepicker({
		maxDate: '0',
		minDate: new Date(2010, 0, 1),
		changeMonth: true,
		changeYear: true,
		dateFormat: 'dd/mm/yy',
		firstDay: 1,
		monthNamesShort: [ "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre" ],
		dayNamesMin: [ "Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa" ],
		onClose: function( selectedDate ) {
			$( "#kardex_imports_date_end" ).datepicker( "option", "minDate", selectedDate );
		}
	});
	
	$("#kardex_imports_date_end").datepicker({
		maxDate: '0',
		minDate: new Date(2010, 0, 1),
		changeMonth: true,
		changeYear: true,
		dateFormat: 'dd/mm/yy',
		firstDay: 1,
		monthNamesShort: [ "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre" ],
		dayNamesMin: [ "Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa" ],
		onClose: function( selectedDate ) {
			$( "#kardex_imports_date_ini" ).datepicker( "option", "maxDate", selectedDate );
		}
	});
	
	$("#bDelete_supplier_imports").click(function(){
		// Deleting the data of suppliers in the respective row num
		$("#kardex_imports_supplier").val("");
		$("#kardex_imports_supplier_id").val("");
		
		// Removing the attribute read-only
		$("#kardex_imports_supplier").removeAttr("readonly");
	});
});

</script>

</head>

<body>

<table border="0" align="center">
	<tr>
		<th>Nombre:</th>
		<td align='center'>
			<input type='text' id='kardex_imports_supplier' style='width:85%'>
			<a href='javascript:void(0)' title='Borrar importador' id='bDelete_supplier_imports' ><img src='../icons/delete.png'></a>
			<input type='hidden' id='kardex_imports_supplier_id'>
		</td>
	</tr>
	<tr>
		<th>Fecha Inicial:</th>
		<td>
			<input type='text' id='kardex_imports_date_ini' readonly='readonly' style='width:100%' value='<?php echo date('d/m/Y'); ?>'>
		</td>
	</tr>
	<tr>
		<th>Fecha Final:</th>
		<td>
			<input type='text' id='kardex_imports_date_end' readonly='readonly' style='width:100%' value='<?php echo date('d/m/Y'); ?>'>
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

<div id='imports_content'>
	
</div>

</body>
</html>