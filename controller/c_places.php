<?php

class ControllerPlaces
{
	// Shows a select with all the stores
	public function stores_select()
	{
		$optionsNum = 0;
		
		$html_select = '[Dep&oacute;sito:
						<select id="selectPlaceStore" name="selectPlaceStore">';
		
		$data_array = $_SESSION['alowedStores'];
		
		foreach($data_array as $id => $val)
		{
			$selected = '';
			if($id == $_SESSION["idStore"])
				$selected = 'selected = "selected"';
			
			$html_select .= "<option value='$id-$val' $selected >$val</option>";
			
			$optionsNum++;
		}
		
		$html_select .= '</select>]';
		
		if($optionsNum > 1)
			echo $html_select;
		else
			echo '';
	}
	
	// Shows a select with all the shops
	public function shops_select()
	{
		$optionsNum = 0;
		$html_select = '[Tienda:
						<select id="selectPlaceShop" name="selectPlaceShop">';
		
		$data_array = $_SESSION['alowedShops'];
		
		foreach($data_array as $id => $val)
		{
			$selected = '';
			if($id == $_SESSION["idShop"])
				$selected = 'selected = "selected"';
			
			$html_select .= "<option value='$id-$val' $selected >$val</option>";
			
			$optionsNum++;
		}
		
		$html_select .= '</select>]';
		
		if($optionsNum > 1)
			echo $html_select;
		else
			echo '';
	}
	
}  // End controller places
?>