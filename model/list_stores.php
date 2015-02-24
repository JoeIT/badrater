<?php
// This file returns a store array according a string condition

include('query_processor.php');

$qp = new QueryProcessor();

$searchCondition = mysqli_real_escape_string($qp->getLink(), $_POST['searchCondition']);

$storeExcep = '';
if(isset($_POST['idStoreException']))
	$storeExcep = " AND store_id != '" . $_POST['idStoreException'] . "' ";

$ids_array = $qp->query_stores(" store_name LIKE '$searchCondition%' $storeExcep ");

$stores_array = array();

foreach($ids_array as $store_id => $store_object)
{
	// Do not change the label name, is required for the autocomplete
	$stores_array[] = array('id' => $store_object->get_id(), 'label' => "$store_object->store_name");
}

print json_encode($stores_array);

?>