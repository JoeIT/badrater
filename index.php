<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<link rel="stylesheet" type="text/css" href="css/login_style.css">

<?php 
include('utils/generic_tags.php');
?>

<title><?php echo $tag_company_name.$tag_title_separator; ?>INICIO</title>
</head>

<body>

<form action="utils/usr_validator.php" method="post">
<table border="0" align="center" id='login'>
	<tr>
		<th colspan='2'><h1>BIENVENIDO</h1></th>
	</tr>
	<tr>
		<th>USUARIO:</th>
		<td><input type="text" name="tLogin" id="tLogin" /></td>
	</tr>
	<tr>
		<th>CONTRASEÑA:</th>
		<td><input type="password" name="tPassword" id="tPassword" /></td>
	</tr>
	<tr>
		<th colspan='2'><input type="submit" name="bAccept" id="bAccept" value="Ingresar" /></th>
	</tr>
</table>
</form>

</body>
</html>