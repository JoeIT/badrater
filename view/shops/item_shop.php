<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

</head>

<body>

<div id="dAddModifyShop" title="TIENDA">

	<form id='fAddModifyShop'>
		<table>
			<tr>
				<th>Nombre (*):</th>
				<td><input type='text' name='tInputNameShop' id='tInputNameShop' /></td>
			</tr>
			<tr>
				<th>Informaci&oacute;n:</th>
				<td><input type='text' name='tInputInfoShop' id='tInputInfoShop' /></td>
			</tr>
			<tr>
				<td colspan='2'><span class='warning_text'><b>NOTA: Debe de cerrar su sesion para que los cambios tomen efecto!!</b></span></td>
			</tr>
			<tr>
				<td id='shop_message_field' colspan='2'></td>
			</tr>
		</table>
		
		<input type='hidden' name='hIdShop' id='hIdShop' value='' />
		<input type='hidden' name='hEventShop' id='hEventShop' value='add' />
	</form>

</div>

</body>
</html>