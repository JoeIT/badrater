<?php 
include('../../controller/c_shops.php');
$control = new ControllerShops();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<script>
$(document).ready(function() {
	$("#entriesTable").tablesorter({widthFixed: true, widgets: ['zebra']});
});
</script>
</head>

<body>

<?php

// Shop entries table
$control->shop_entries_table();
?>

</body>
</html>