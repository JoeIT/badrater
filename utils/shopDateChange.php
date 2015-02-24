<?php

if( isset($_POST['date']) )
{
	session_start();
	$_SESSION['shopShowDate'] = $_POST['date'];
}

?>