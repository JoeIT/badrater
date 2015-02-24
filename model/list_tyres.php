<?php
// This file returns a tyre array according a string condition

include('query_processor.php');

$qp = new QueryProcessor();

$searchCondition = mysqli_real_escape_string($qp->getLink(), $_POST['searchCondition']);
$searchType = mysqli_real_escape_string($qp->getLink(), $_POST['searchType']);

$search = array();
// Build the where query
$where = '';

if ($searchType == 'size' && !empty($searchCondition))
	$where = " tyre_size LIKE '%$searchCondition%' ";
else if ($searchType == 'code' && !empty($searchCondition))
	$where = " tyre_code LIKE '%$searchCondition%' ";



/* // This section search a tyre by size, brand and code orderly
if(!empty($searchCondition))
	$search = explode(" ", $searchCondition);

if(isset($search[0]))
	$where = " tyre_size LIKE '$search[0]%' ";
	
if(isset($search[1]))
	$where .= " AND tyre_brand LIKE '$search[1]%' ";
	
if(isset($search[2]))
	$where .= " AND tyre_code LIKE '$search[2]%' ";*/
	
//$ids_array = $qp->query_tyres(" tyre_size LIKE '$searchCondition%' ");
$ids_array = $qp->query_tyres($where);

$tyres_array = array();

foreach($ids_array as $tyre_id => $tyre_object)
{
	// Do not change the label name, is required for the autocomplete
	$tyres_array[] = array('id' => $tyre_object->get_id(), 'label' => "$tyre_object->tyre_size $tyre_object->tyre_brand $tyre_object->tyre_code");
}

print json_encode($tyres_array);

?>