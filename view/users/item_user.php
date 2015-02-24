<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

</head>

<body>

<div id="dAddModifyUser" title="USUARIO">

	<form id='fAddModifyUser'>
		<table>
			<tr>
				<th>NOMBRE (*):</th>
				<td><input type='text' name='tInputNameUser' id='tInputNameUser' /></td>
			</tr>
			<tr>
				<th>LOGIN (*):</th>
				<td><input type='text' name='tInputLoginUser' id='tInputLoginUser' /></td>
			</tr>
			<tr>
				<th>CONTRASENA (*):</th>
				<td><input type='password' name='tInputPasswordUser' id='tInputPasswordUser' /></td>
			</tr>
			<tr>
				<th>REESCRIBA CONTRASENA (*):</th>
				<td><input type='password' name='tInputPassword2User' id='tInputPassword2User' /></td>
			</tr>
			<tr>
				<td id='user_message_field' colspan='2'></td>
			</tr>
		</table>
		
		<input type='hidden' name='hId' id='hId' value='' />
		<input type='hidden' name='hEventUser' id='hEventUser' value='add' />
	</form>

</div>

</body>
</html>
