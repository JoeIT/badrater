<?php
include_once('../../model/query_processor.php');

class ControllerStocks
{
	// Gets the quantity of tyres that a store or shop has
	private function _getQuantity($idTyre, $idStore, $idShop)
	{
		$qp = new QueryProcessor();
		return $qp->query_stocks_quantity($idTyre, $idStore, $idShop);
	}
	
	// Sets the quantity of tyres that a store or shop has
	private function _setQuantity($idTyre, $idStore, $idShop)
	{
		$qp = new QueryProcessor();
		return $qp->query_stocks_quantity($idTyre, $idStore, $idShop);
	}
	
	public function getStoreQuantity($idTyre, $idStore)
	{
		return $this->_getQuantity($idTyre, $idStore, '');
	}
	
	public function getShopQuantity($idTyre, $idShop)
	{
		return $this->_getQuantity($idTyre, '', $idShop);
	}
	
	// Generate the movement of stock
	public function movement($idTyre, $toStore, $toShop, $quantity)
	{
		$qp = new QueryProcessor();
		
		// Adding a stock of tyres
		if( !empty($toStore) )
			$qp->query_add_stocks_quantity($idTyre, $toStore, '', $quantity);
		else if( !empty($toShop) )
			$qp->query_add_stocks_quantity($idTyre, '', $toShop, $quantity);
	}
	
	public function delete_all_store_stock($idStore)
	{
		$qp = new QueryProcessor();
		return $qp->query_delete_stocks_store($idStore);
	}
	
	public function delete_all_shop_stock($idShop)
	{
		$qp = new QueryProcessor();
		return $qp->query_delete_stocks_shop($idShop);
	}
}

?>