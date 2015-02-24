<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

</head>

<body>

<div id="dAddModifyExpense" title="GASTO">

	<form id='fAddModifyExpense'>
		<table>
			<tr>
				<th>Descripci&oacute;n (*):</th>
				<td><input type='text' name='tInputDescriptionExpense' id='tInputDescriptionExpense' /></td>
			</tr>
			<tr>
				<th>Monto Bs.:</th>
				<td><input type='text' name='tInputBsExpense' id='tInputBsExpense' /></td>
			</tr>
			<tr>
				<th>Monto Sus.:</th>
				<td><input type='text' name='tInputSusExpense' id='tInputSusExpense' /></td>
			</tr>
			<tr>
				<td id='expense_message_field' colspan='2'></td>
			</tr>
		</table>
		
		<input type='hidden' name='hIdExpense' id='hIdExpense' value='' />
		<input type='hidden' name='hEventExpense' id='hEventExpense' value='add' />
	</form>

</div>

</body>
</html>