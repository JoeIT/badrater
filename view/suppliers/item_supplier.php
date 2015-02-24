<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

</head>

<body>

<div id="dAddModifySup" title="IMPORTADOR">

	<form id='fAddModifySup'>
		<table>
			<tr>
				<th>NOMBRE(*):</th>
				<td><input type='text' name='tInputNameSup' id='tInputNameSup' /></td>
			</tr>
			<tr>
				<!-- <th>INFORMACION:</th> -->
				<td><input type='hidden' name='tInputInfoSup' id='tInputInfoSup' /></td>
			</tr>
			<tr>
				<td id='supplier_message_field' colspan='2'></td>
			</tr>
		</table>
		
		<input type='hidden' name='hIdSup' id='hIdSup' value='' />
		<?php //Hidden that manage event (add, modify, delete); ?>
		<input type='hidden' name='hEventSup' id='hEventSup' value='add' />
	</form>

</div>

</body>
</html>