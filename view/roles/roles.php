<?php
include_once('../../utils/usr_permission.php');
$up = new UsrPermission();
$up->requestAccessPage(PermissionType::ROLES);

include_once('../../controller/c_roles.php');
$control = new ControllerRoles();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script>

$(document).ready(function() {
	
	$('#select_users').change(function(){
		var user_id_selected = $(this).val();
		
		$('#access_control').load('roles/roles_config.php?id=' + user_id_selected);
	});	
});

</script>

</head>

<body>
<form id='fRoles' name='fRoles'>
<table border="1" align="center">
	<tr>
		<th colspan='3'>Usuario: 
		<select id="select_users">
			<option value='' >ELIJA UN USUARIO</option>
		<?php 
		$userArr = $control->getUserArray();
		foreach($userArr as $user) {
		?>
			<option value='<?php echo $user['id']; ?>' ><?php echo $user['name']; ?></option>
		<?php } ?>
		</select>
		</th>
	</tr>
<tbody id='access_control' colspan='3'>
	
</tbody>

</table>
</form>
</body>
</html>