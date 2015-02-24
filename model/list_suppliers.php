<?php
// This file returns a supplier array according a string condition

include('query_processor.php');

$qp = new QueryProcessor();

$searchCondition = mysqli_real_escape_string($qp->getLink(), $_POST['searchCondition']);

$ids_array = $qp->query_suppliers(" name LIKE '$searchCondition%' ");

$suppliers_array = array();

foreach($ids_array as $supplier_id => $supplier_object)
{
	// Do not change the label name, is required for the autocomplete
	$suppliers_array[] = array('id' => $supplier_object->get_id(), 'label' => "$supplier_object->name");
}

print json_encode($suppliers_array);

?>