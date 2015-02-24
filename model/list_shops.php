<?php
// This file returns a shop array according a string condition

include('query_processor.php');

$qp = new QueryProcessor();

$searchCondition = mysqli_real_escape_string($qp->getLink(), $_POST['searchCondition']);

$shopExcep = '';
if(isset($_POST['idShopException']))
{
	if($_POST['idShopException'] != 'current')
		$shopExcep = " AND shop_id != '" . $_POST['idShopException'] . "' ";
	else
	{
		session_start();
		$shopExcep = " AND shop_id != '" . $_SESSION["idShop"] . "' ";		
	}
}

$ids_array = $qp->query_shops(" shop_name LIKE '$searchCondition%' $shopExcep ");

$shops_array = array();

foreach($ids_array as $shop_id => $shop_object)
{
	// Do not change the label name, is required for the autocomplete
	$shops_array[] = array('id' => $shop_object->get_id(), 'label' => "$shop_object->shop_name");
}

print json_encode($shops_array);

?>