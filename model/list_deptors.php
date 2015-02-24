<?php
// This file returns a deptor array according a string condition

include('query_processor.php');

$qp = new QueryProcessor();

$searchCondition = mysqli_real_escape_string($qp->getLink(), $_POST['searchCondition']);

$ids_array = $qp->query_deptors(" name LIKE '%$searchCondition%' ");

$deptors_array = array();

foreach($ids_array as $id => $deptor_object)
{
	// Do not change the label name, is required for the autocomplete
	$deptors_array[] = array('id' => $deptor_object->get_id(), 'label' => "$deptor_object->name");
}

print json_encode($deptors_array);

?>