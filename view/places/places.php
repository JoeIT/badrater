<?php 
include_once('../../utils/usr_permission.php');
$up = new UsrPermission();
$up->requestAccessPage(PermissionType::PLACES);

include('../../controller/c_places.php');
$control = new ControllerPlaces();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script>

$(document).ready(function() {
	$('#bChange').click(function(){
		
		$.post("places/places_form.php", $('#fPlace').serialize(), function(data){					
			loadPage('infos/data_saved.php');
		});
	});
});

</script>

</head>

<body>
<form id='fPlace' >
	<table width="250px" align="center">
		<tr>
			<th colspan="2">OPCIONES<th>
		</tr>
		
		<?php $control->stores_select(); ?>
		
		<?php $control->shops_select(); ?>
		
		<tr>
			<td colspan="2" align="center">
				<input type='button' id='bChange' value='Aceptar'/>
			</td>
		</tr>
	</table>
<form>
</body>
</html>
