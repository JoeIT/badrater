<?php
class Config
{
	private static $_instance;

	private function __construct()
	{
		date_default_timezone_set('America/La_Paz');
	}
	
	public function __destruct()
	{
		self::$_instance = null;
	}
	
	// Return the date of the number of years, months and/or days before(-) or after(+) that was selected
	private function _getDateFrom($years, $months, $days = 0)
	{
		return date("Y-m-d", mktime(0, 0, 0, date("m") + $months, (date("d") + $days), date("Y") + $years));
	}
	
	public static function getInstance()
	{
		if(!self::$_instance)
			self::$_instance = new Config();
		
		return self::$_instance;
	}
	
	// Return the current server date
	public function getCurrentDate()
	{
		return date('Y-m-d');
	}
	
	// Return the current server datetime
	public function getCurrentDateTime()
	{
		return date('Y-m-d H:i:s');
	}
	
	// Return the number of earlier days that a shop, store or sale will show the data
	/*public function getDateToShow($type)
	{
		switch ($type)
		{
			case 'store': return $this->_getDateFrom(0, +3);
			case 'shop': return $this->_getDateFrom(0, -3);
			case 'today': return $this->_getDateFrom(0, 0);
			default: return $this->_getDateFrom(0, 0); // Don't change, this is the actual date
		}
	}*/
	
	// Convert the 'Y-m-d', 'd-m-Y', 'now', etc date format to 'd/m/Y' date format
	public function toUsrDateFormat($date)
	{
		return date("d/m/Y", strtotime($date));
	}
	
	// Convert the 'Y-m-d', 'd-m-Y', 'now', etc date format to 'd/m/Y' date format
	public function toExportDateFormat($date)
	{
		return date("d-m-Y", strtotime($date));
	}
	
	// Convert the 'd/m/Y' format to 'Y-m-d' date format
	public function toBdDateFormat($date)
	{
		$date = implode('/', array_reverse(explode('/', $date)));
		
		return date("Y-m-d", strtotime($date));
	}
	
	public function getFontSize()
	{
	}
} // End Config class

?> 