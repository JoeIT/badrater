<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<script>
$(document).ready(function() {
	$(".autocompleteTyreEOShop").attr('size', 25);
	
	// Autocomplete tyre
	$(".autocompleteTyreEOShop").autocomplete({
		source: function( request, response ) {
			$.ajax({
				url: "../model/list_tyres.php",
				data: {searchCondition: request.term,
						searchType: function(){
							return $('#tyreTypeSearchEOShop option:selected').val();
						}},
				type: 'post',
				dataType: "json",
				success: function(output) {
					response(output);					
				}
			});
		},
		select: function(event, ui){
			var rowNum = $(this).attr("num");
			// Getting the selected tyre and save it into the hidden
			$("#hIdTyreEOShop" + rowNum).val(ui.item.id);
			$("#tInputTyreEOShop" + rowNum).attr("readonly", "readonly");
			
			if( $(".autocompleteTyreEOShop").attr('size') < (ui.item.label).length + 3 )
				$(".autocompleteTyreEOShop").attr('size', (ui.item.label).length + 3 );
			
			// Updating quantity
			showTyreQuantityEOShop(ui.item.id, rowNum);
		},
		autoFocus: true
	});
	
	//---------------------------------------------------
	// Delete events
	$(".bDeleteEOShop").click(function(){
		var type = $(this).attr("obj_type");
		var rowNum = $(this).attr("num");
		
		var field = type + 'EOShop' + rowNum;
		
		// Deleting the data of tyres in the respective row num
		$("#tInput" + field).val("");
		$("#hId" + field).val("");
		
		// Reseting the tyre quantity
		$('#tyre_quantityEOShop' + rowNum).html('');
		
		// Removing the attribute read-only
		$("#tInput" + field).removeAttr("readonly");
	});
	
	//------------------------------------------------------
	// Change events
	$('#tInputEmployeeEOShop0').change(function(){
		fillVoidFieldsEOShop('tInputEmployeeEOShop', $('#tInputEmployeeEOShop0').val(), false);
	});
});

function fillVoidFieldsEOShop(fieldId, cloneValue, readOnly)
{
	var currentEvent = $('#hEventEOShop').val();
	
	if(currentEvent != 'add')
		return 0;
	
	for(var aux = 1; aux < 10; aux++)
	{
		var field = '#' + fieldId + aux;
		if( !$(field).val() )
		{
			$(field).val(cloneValue);
			
			if(readOnly)
				$(field).attr("readonly", "readonly");
		}
	}
	
	return 1;
}

function showTyreQuantityEOShop(tyreId, row)
{
	$.ajax({
		url: "../model/ajax_shop_quantity.php",
		data: {id: tyreId},
		type: 'post',
		dataType: "json",
		success: function(quantity) {
			$('#tyre_quantityEOShop' + row).html('/' + quantity);
		}
	});
}

function reloadShops()
{
	// Deleting all select option
	$(".usrShopEOShop").empty();
	
	$('.usrShopEOShop').append('<option value=""></option>');
	
	// Getting the list of shops without the current one
	$.ajax({
		url: "../model/list_shops.php",
		data: {searchCondition: '', idShopException: 'current'},
		type: 'post',
		dataType: "json",
		async: false,
		success: function(data) {
			for (index = 0; index < data.length; ++index) {
				var shop_id = data[index]['id'];
				var shop_name = data[index]['label'];
				
				// Reload the select list
				$('.usrShopEOShop').append('<option value="' + shop_id + '">' + shop_name + '</option>');
			}
		}
	});
	
	///// Eventually, in modify select the option tha was selected before
}

</script>

</head>

<body>

<div id="dAddModifyShopEO" title="DATOS">

	<form id='fAddModifyShopEO'>
		<table>
			<tr>
				<th>&nbsp;</th>
				<th>&nbsp;</th>
				<th>LLANTA (*)
					<select id='tyreTypeSearchEOShop'>
						<option value='code'>Cod</option>
						<option value='size'>Med</option>
					</select>
				</th>
				<th>&nbsp;</th>
				<th>TIENDA (*)</th>
				<th>RECIBIO/DIO</th>
				<th colspan='2'>CANT. (*)</th>
			</tr>
			<?php 
			
			/*include_once('../../controller/c_shops.php');
			$shop = new ControllerShops();
			
			$arrayShops = $shop->shops_array(true);*/
			
			// NOTE: Do not change the 0 aux start value, other behaviors depend of it.
			$aux = 0;
			for(; $aux < 10; $aux++){?>
			<tr <?php if($aux > 0){ echo "class='add_only'";} ?> >
				<td><?php echo $aux + 1 . ')'; ?></td>
				<td><?php
					if($aux > 0){ ?>
					<input type='checkbox' name='checkEOShop<?php echo $aux; ?>' id='checkEOShop<?php echo $aux; ?>' class='usrChecksEOShop'>
					<?php }?>
				</td>
				<td>
					<input type='text' name='tInputTyreEOShop<?php echo $aux; ?>' id='tInputTyreEOShop<?php echo $aux; ?>' class='autocompleteTyreEOShop usrTyreEOShop' num='<?php echo $aux; ?>' />					
					<input type='hidden' name='hIdTyreEOShop<?php echo $aux; ?>' id='hIdTyreEOShop<?php echo $aux; ?>' class='usrIdsEOShop' />
				</td>
				<td><a href='javascript:void(0)' title='Borrar llanta' class='bDeleteEOShop' obj_type='Tyre' num='<?php echo $aux; ?>' ><img src='../icons/delete.png'></a></td>
				<td>
					<select name='sInputShopEOShop<?php echo $aux; ?>' id='sInputShopEOShop<?php echo $aux; ?>' class='usrShopEOShop' num='<?php echo $aux; ?>'>
						<option value=''></option>
						<?php 
						/*foreach($arrayShops as $sh)
						{
							echo "<option value='". $sh['id'] ."'>". $sh['name'] ."</option>";
						}*/ ?>
					</select>
				</td>
				<td><input type='text' name='tInputEmployeeEOShop<?php echo $aux; ?>' id='tInputEmployeeEOShop<?php echo $aux; ?>' class='usrEmployeeEOShop' /></td>
				<td><input type='text' name='tInputAmountEOShop<?php echo $aux; ?>' id='tInputAmountEOShop<?php echo $aux; ?>' class='usrAmountEOShop inputQuantity' /></td>
				<td id='tyre_quantityEOShop<?php echo $aux; ?>' class='tyre_quantityEOShop'></td>
			</tr>
			<?php }// End for ?>
			<tr>
				<td id='message_fieldEOShop' colspan='7'></td>
			</tr>
		</table>
		
		<input type='hidden' name='hIdEOShop' id='hIdEOShop' value='' />
		<input type='hidden' name='hTotalRowsEOShop' id='hTotalRowsEOShop' value='<?php echo $aux; ?>' />
		<input type='hidden' name='thEOShop' id='thEOShop' value='' />
		<input type='hidden' name='hEventEOShop' id='hEventEOShop' value='add' />
	</form>

</div>

</body>
</html>