<?php
include_once('../../model/query_processor.php');

class ControllerKardex
{
	private $_qp;
	
	public function __construct()
	{
		$this->_qp = new QueryProcessor();
	}
	
	public function getAllStores()
	{
		return $this->_qp->query_stores_array();
	}

    public function getAllShops()
	{
		return $this->_qp->query_shops_array();
	}
	
	public function io($store_id, $shop_id, $tyre_id, $dateIni, $dateEnd)
	{
		return $this->_qp->query_kardex_io($store_id, $shop_id, $tyre_id, $dateIni, $dateEnd);
	}
	
	public function entries($store_id, $shop_id, $tyre_id, $dateIni, $dateEnd)
	{
		return $this->_qp->query_kardex_entries($store_id, $shop_id, $tyre_id, $dateIni, $dateEnd);
	}
	
	public function outs($shop_id, $tyre_id, $type, $dateIni, $dateEnd)
	{
		return $this->_qp->query_kardex_outs($shop_id, $tyre_id, $type, $dateIni, $dateEnd);
	}
	
	public function stock($storesArr, $shopsArr, $tyre_id, $store_id, $shop_id)
	{
		return $this->_qp->query_kardex_stock($storesArr, $shopsArr, $tyre_id, $store_id, $shop_id);
	}
	
	public function imports($supplier_id, $dateIni, $dateEnd)
	{
		return $this->_qp->query_kardex_imports($supplier_id, $dateIni, $dateEnd);
	}
	
	public function invoices($invoice_id)
	{
		return $this->_qp->query_kardex_invoices($invoice_id);
	}
	
	public function debts($shop_id, $deptor_id)
	{
		return $this->_qp->query_kardex_debts($shop_id, $deptor_id);
	}
}

?>