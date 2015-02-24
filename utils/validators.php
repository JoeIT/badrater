<?php

class Validators
{
	public function isEmpty(&$data, $field_name, &$message)
	{
		if(empty($data))
		{	
			$message = $message . "<b>$field_name:</b> Este campo es obligatorio, y no puede estar vacio.<br>";
			return false;
		}
		
		return true;
	}
	
	// Determinate if a string is a int
	public function isInt(&$data, $field_name, &$message)
	{
		if(!is_numeric($data))
		{
			$message = $message . "<b>$field_name:</b> Este campo debe ser un entero.<br>";
			return false;
		}
		
		if(!is_int($data + 0))
		{
			$message = $message . "<b>$field_name:</b> Este campo debe ser un entero.<br>";
			return false;
		}
		
		return true;
	}
	
	public function isDouble(&$data, $field_name, &$message)
	{
		if(!is_numeric($data))
		{
			$message = $message . "<b>$field_name:</b> Este campo debe ser un decimal.<br>";
			return false;
		}
		
		if(!is_float($data + 0.0))
		{
			$message = $message . "<b>$field_name:</b> Este campo debe ser un decimal.<br>";
			return false;
		}
		
		return true;
	}
	
	public function isAlpha(&$data, $field_name, &$message)
	{
		
		return true;
	}
	
	public function isAlphaNumeric(&$data, $field_name, &$message)
	{
		return true;
	}
	
	public function isEmail(&$data, $field_name, &$message)
	{
		return true;
	}
	
	public function showMessage($field_name, $messageString, &$message)
	{
		$message .= "<b>$field_name:</b> $messageString.<br>";
	}
}

?>