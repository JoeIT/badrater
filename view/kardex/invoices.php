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
		
		if( $('#kardex_invoices_id').val() == '' )
			alert( 'Seleccione una factura.' );
		else
		{
			$.post("kardex/invoices_data.php", { invoice_id: $('#kardex_invoices_id').val(), 
												invoice_number: $('#kardex_invoices_number').val()
										}, function(data){
				$('#invoices_content').html(data);
			});
		}
	});
	
	// Autocomplete supplier
	$("#kardex_invoices_number").autocomplete({
		source: function( request, response ) {
			$.ajax({
				url: "../model/list_invoices.php",
				data: {searchCondition: request.term},
				type: 'post',
				dataType: "json",
				success: function(output) {
					response(output);					
				}
			});
		},
		select: function(event, ui){
			$("#kardex_invoices_id").val(ui.item.id);
			$("#kardex_invoices_number").attr('readonly', 'readonly');
		},
		autoFocus: true
	});
	
	$("#bDelete_invoice_invoices").click(function(){
		// Deleting the data of suppliers in the respective row num
		$("#kardex_invoices_number").val("");
		$("#kardex_invoices_id").val("");
		
		// Removing the attribute read-only
		$("#kardex_invoices_number").removeAttr("readonly");
	});
});

</script>

</head>

<body>

<table border="0" align="center">
	<tr>
		<th>Numero de factura:</th>
		<td align='center'>
			<input type='text' id='kardex_invoices_number' style='width:85%'>
			<a href='javascript:void(0)' title='Borrar factura' id='bDelete_invoice_invoices' ><img src='../icons/delete.png'></a>
			<input type='hidden' id='kardex_invoices_id'>
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

<div id='invoices_content'>
	
</div>

</body>
</html>