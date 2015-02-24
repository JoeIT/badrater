<?php

if( isset($_POST['date']) )
{
	session_start();
	$_SESSION['storeShowDate'] = $_POST['date'];
}

?>