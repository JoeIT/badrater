<?php
// This file returns a invoice array according a string condition

include('query_processor.php');

$qp = new QueryProcessor();

$searchCondition = mysqli_real_escape_string($qp->getLink(), $_POST['searchCondition']);

$ids_array = $qp->query_invoices(" invoice_number LIKE '$searchCondition%' ");

$invoices_array = array();

foreach($ids_array as $invoice_id => $invoice_object)
{
	// Do not change the label name, is required for the autocomplete
	$invoices_array[] = array('id' => $invoice_object->get_id(), 'label' => "$invoice_object->invoice_number");
}

print json_encode($invoices_array);

?>