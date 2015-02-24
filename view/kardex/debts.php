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
		
		if( $('#kardex_debts_deptor_id').val() == '' && !($('#kardex_debs_all_deptors').is(':checked')) )
			alert( 'Seleccione una deudor.' );
		else
		{
			$.post("kardex/debts_data.php", { deptor_id: $('#kardex_debts_deptor_id').val(), 
											deptor_name: $('#kardex_debts_deptor').val(), 
											place_code: $('#kardex_debts_place').val(),
											place_name: $('#kardex_debts_place option:selected').text()
										}, function(data){
				$('#debts_content').html(data);
			});
		}
	});
	
	$('#kardex_debs_all_deptors').change(function(){
		if( $(this).is(':checked') )
		{
			$('#kardex_debts_deptor').prop('disabled', true);
			$('#bDelete_deptor_debts').hide();
			$('#kardex_debts_deptor').val('Todos los deudores');
			$('#kardex_debts_deptor_id').val('');
			
		}
		else
		{
			$('#kardex_debts_deptor').val('');
			$('#kardex_debts_deptor').prop('disabled', false);
			$('#bDelete_deptor_debts').show();
		}
	});
	
	// Autocomplete deptor
	$("#kardex_debts_deptor").autocomplete({
		source: function( request, response ) {
			$.ajax({
				url: "../model/list_deptors.php",
				data: {searchCondition: request.term},
				type: 'post',
				dataType: "json",
				success: function(output) {
					response(output);					
				}
			});
		},
		select: function(event, ui){
			$("#kardex_debts_deptor_id").val(ui.item.id);
			$("#kardex_debts_deptor").attr('readonly', 'readonly');
		},
		autoFocus: true
	});
	
	$("#bDelete_deptor_debts").click(function(){
		// Deleting the data of deptors in the respective row num
		$("#kardex_debts_deptor").val("");
		$("#kardex_debts_deptor_id").val("");
		
		// Removing the attribute read-only
		$("#kardex_debts_deptor").removeAttr("readonly");
	});
});

</script>

</head>

<body>

<table border="0" align="center">
	<tr>
		<th>Deudor:</th>
		<td align='center'>
			TODOS >>> <input type='checkbox' id='kardex_debs_all_deptors'><br>
			<br>
			<input type='text' id='kardex_debts_deptor' style='width:85%'>
			<a href='javascript:void(0)' title='Borrar deudor' id='bDelete_deptor_debts' ><img src='../icons/delete.png'></a>
			<input type='hidden' id='kardex_debts_deptor_id'>
		</td>
	</tr>
	<tr>
		<th>Tienda:</th>
		<td align='center'>
			<select id='kardex_debts_place'>
				<option value=''>Todas las tiendas</option>
				<?php
				$selectHtml = '';
				$shopsArray = $control->getAllShops();
				foreach($shopsArray as $shop)
				{
					$selectHtml .= "<option value='". $shop['id'] ."'>". $shop['name'] ."</option>";
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

<div id='debts_content'>
	
</div>

</body>
</html>