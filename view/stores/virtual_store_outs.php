<?php
// This file make the movement of a virtual store to his shop
include('../../controller/c_stores.php');

$control = new ControllerStores();

$control->save_virtual_store_outs($_SESSION['idStore']);
	
?>