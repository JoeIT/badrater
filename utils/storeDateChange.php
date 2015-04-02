<?php
if( isset($_POST['date']) )
{
	if(!isset($_SESSION))
		session_start();
	$_SESSION['storeShowDate'] = $_POST['date'];
}
?>