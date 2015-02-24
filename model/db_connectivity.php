<?php

// Singleton class
class DbConnectivity
{
	const HOSTNAME = 'localhost';
	const DB = 'badrater_terrabol';
	const USER_NAME = 'root';
	//const USER_NAME = 'badrater_staler';
	//const USER_PASS = 'pS,T&y,?Ml($';
	const USER_PASS = '';

	private static $_instance;
	private $_db_server = false;
	
	private function __construct()
	{
		$this->_connect();
	}
	
	public function __destruct()
	{
		$this->_disconnect();
		self::$_instance = null;
	}
	
	public static function getInstance()
	{
		if(!self::$_instance)
			self::$_instance = new DbConnectivity();
			
		return self::$_instance;
	}
	
	private function _connect()
	{
		$this->_db_server = mysqli_connect(self::HOSTNAME, self::USER_NAME, self::USER_PASS, self::DB);
		
		if(!$this->_db_server)
			die('Could not connect to SERVER: ' . mysqli_error());
		
		return true;
	}
	
	private function _disconnect()
	{
		if(!$this->_db_server)
			return false;
			
		return mysqli_close($this->_db_server);		
	}
	
	public function getLink()
	{
		return $this->_db_server;
	}
	
	public function query(&$query)
	{
		//echo "Query: $query <br />";
		return mysqli_query($this->_db_server, $query);
	}
	
	public function getLastInsertedId()
	{
		return mysqli_insert_id($this->_db_server);
	}
} // End class DbConnectivity

?>