<?php
if( isset($_POST['date']) )
{
	if(!isset($_SESSION))
		session_start();
	$_SESSION['shopShowDate'] = $_POST['date'];
}
?>