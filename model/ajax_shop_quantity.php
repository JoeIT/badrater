<?php
// This file returns the quantity stock tyre of a shop
session_start();
include('query_processor.php');

$qp = new QueryProcessor();

$tyreId = mysqli_real_escape_string($qp->getLink(), $_POST['id']);

print json_encode($qp->query_stocks_quantity($tyreId, '', $_SESSION["idShop"]));

?>