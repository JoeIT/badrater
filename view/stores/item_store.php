<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<script>
$(document).ready(function() {
});

function loadVirtualSelect(optionToSelect)
{
	// Cleaning all previous options
	$('#selVirtual').empty();
	
	
	// Adding default option
	addSelectOption('', 'No', false);
	
	$.ajax({
		url: '../model/list_shops.php',
		data: {searchCondition: ''},
		type: 'post',
		dataType: "json",
		async: false,
		success: function(data) {
			$.each(data, function(key) {
				if(data[key]['id'] == optionToSelect)
					addSelectOption(data[key]['id'], data[key]['label'], true);
				else
					addSelectOption(data[key]['id'], data[key]['label'], false);
			});
		}
	});
}

function addSelectOption(key, label, isSelected)
{
	var selected = '';
	if(isSelected)
		selected = 'selected="selected"';
	
	$('#selVirtual').append($("<option " + selected + "></option>")
								.attr("value", key)
								.text(label));
}
</script>

</head>

<body>

<div id="dAddModifyStore" title="DEPOSITO">

	<form id='fAddModifyStore'>
		<table>
			<tr>
				<th>Nombre(*):</th>
				<td><input type='text' name='tInputNameStore' id='tInputNameStore' /></td>
			</tr>
			<tr>
				<th>Virtual(*):</th>
				<td align="left">
					<input type='text' name='tInputTypeStore' id='tInputTypeStore' readonly='readonly' value='Holas' />
					
					<select name="selVirtual" id="selVirtual">
					</select>
				</td>
			</tr>
			<tr>
				<th>Informaci&oacute;n:</th>
				<td><input type='text' name='tInputInfoStore' id='tInputInfoStore' /></td>
			</tr>
			<tr>
				<td colspan='2'><span class='warning_text'><b>NOTA: Debe de cerrar su sesion para que los cambios tomen efecto!!</b></span></td>
			</tr>
			<tr>
				<td id='store_message_field' colspan='3'></td>
			</tr>
		</table>
		
		<input type='hidden' name='hIdStore' id='hIdStore' value='' />
		<input type='hidden' name='hEventStore' id='hEventStore' value='add' />
	</form>

</div>

</body>
</html>