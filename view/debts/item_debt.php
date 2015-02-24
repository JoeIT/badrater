<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<script>
$(document).ready(function() {
	
	// Autocomplete deptor
	$(".autocompleteDeptorDebt").autocomplete({
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
		
			// Getting the selected deptor and save it into the hidden
			$("#hIdDeptorDebt").val(ui.item.id);
			$("#tInputDeptorDebt").attr("readonly", "readonly");
		},
		autoFocus: true
	});
	
	//---------------------------------------------------
	// Delete events
	$(".bActionDeleteDebt").click(function(){
		var type = $(this).attr("obj_type");
		
		// Deleting the data of tyres in the respective row num
		$("#tInput" + type + 'Debt').val("");
		$("#hId" + type + 'Debt').val("");
		
		// Removing the attribute read-only
		$("#tInput" + type + 'Debt').removeAttr("readonly");
	});
});
</script>

</head>

<body>

<div id="dAddModifyDebt" title="PAGO DE DEUDA">

	<form id='fAddModifyDebt'>
		<table>
			<tr>
				<th>Descripci&oacute;n(*):</th>
				<td><input type='text' name='tInputDescriptionDebt' id='tInputDescriptionDebt' /></td>
			</tr>
			<tr>
				<th>Deudor(*):</th>
				<td><input type='text' name='tInputDeptorDebt' id='tInputDeptorDebt' class='autocompleteDeptorDebt' /></td>
				<td><input type='hidden' name='hIdDeptorDebt' id='hIdDeptorDebt' /></td>
				<td><a href='javascript:void(0)' title='Borrar deudor' class='bActionDeleteDebt' obj_type='Deptor' ><img src='../icons/delete.png'></a></td>
			</tr>
			<tr>
				<th>Pago Bs.:</th>
				<td><input type='text' name='tInputBsDebt' id='tInputBsDebt' /></td>
			</tr>
			<tr>
				<th>Pago Sus.:</th>
				<td><input type='text' name='tInputSusDebt' id='tInputSusDebt' /></td>
			</tr>
			<tr>
				<td id='debt_message_field' colspan='3'></td>
			</tr>
		</table>
		
		<input type='hidden' name='hIdDebt' id='hIdDebt' value='' />
		<input type='hidden' name='hEventDebt' id='hEventDebt' value='add' />
	</form>

</div>

</body>
</html>