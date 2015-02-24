<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<script>
$(document).ready(function() {
	$(".autocompleteTyreSaleShop").attr('size', 25);
	
	// Autocomplete tyre
	$(".autocompleteTyreSaleShop").autocomplete({
		source: function( request, response ) {
			$.ajax({
				url: "../model/list_tyres.php",
				data: {searchCondition: request.term,
						searchType: function(){
							return $('#tyreTypeSearchSaleShop option:selected').val();
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
			$("#hIdTyreSaleShop" + rowNum).val(ui.item.id);
			$("#tInputTyreSaleShop" + rowNum).attr("readonly", "readonly");
			
			if( $(".autocompleteTyreSaleShop").attr('size') < (ui.item.label).length + 3 )
				$(".autocompleteTyreSaleShop").attr('size', (ui.item.label).length + 3 );
			
			// Updating quantity
			showTyreQuantitySaleShop(ui.item.id, rowNum);
		},
		autoFocus: true
	});
	
	// Autocomplete deptor
	$(".autocompleteDeptor").autocomplete({
		source: function( request, response ) {
			$.ajax({
				url: "../model/list_deptors.php",
				data: {searchCondition: request.term},
				type: 'post',
				dataType: "json",
				success: function(output) {
					response(output);					
				}
			});
		},
		select: function(event, ui){
			var rowNum = $(this).attr("num");
			// Getting the selected store and save it into the hidden
			$("#hIdDeptorSaleShop" + rowNum).val(ui.item.id);
			$("#tInputDeptorSaleShop" + rowNum).attr("readonly", "readonly");
		},
		autoFocus: true
	});
	
	//---------------------------------------------------
	// Delete events
	$(".bDeleteSaleShop").click(function(){
		var type = $(this).attr("obj_type");
		var rowNum = $(this).attr("num");
		
		var field = type + 'SaleShop' + rowNum;
		
		// Deleting the data of "type" in the respective row num
		$("#tInput" + field).val("");
		$("#hId" + field).val("");
		
		// Reseting the tyre quantity
		$('#tyre_quantitySaleShop' + rowNum).html('');
		
		// Removing the attribute read-only
		$("#tInput" + field).removeAttr("readonly");
	});
});

function fillVoidFieldsSaleShop(fieldId, cloneValue, readOnly)
{
	var currentEvent = $('#hEventSaleShop').val();
	
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

function showTyreQuantitySaleShop(tyreId, row)
{
	$.ajax({
		url: "../model/ajax_shop_quantity.php",
		data: {id: tyreId},
		type: 'post',
		dataType: "json",
		success: function(quantity) {
			$('#tyre_quantitySaleShop' + row).html('/' + quantity);
		}
	});
}

</script>

</head>

<body>

<div id="dAddModifyShopSale" title="Venta">

	<form id='fAddModifyShopSale'>
		<table>
			<tr>
				<th>&nbsp;</th>
				<th>&nbsp;</th>
				<th>LLANTA (*)
					<select id='tyreTypeSearchSaleShop'>
						<option value='code'>Cod</option>
						<option value='size'>Med</option>
					</select>
				</th>
				<th colspan='2'>CANT. (*)</th>
				<th>&nbsp;</th>
				<th>DEUDOR</th>
				<th>&nbsp;</th>
				<th>Bs. (*-)</th>
				<th>Sus. (*-)</th>
			</tr>
			<?php 
			// NOTE: Do not change the 0 aux start value, other behaviors depend of it.
			$aux = 0;
			for(; $aux < 10; $aux++){?>
			<tr <?php if($aux > 0){ echo "class='add_only'";} ?> >
				<td><?php echo $aux + 1 . ')'; ?></td>
				<td><?php
					if($aux > 0){ ?>
					<input type='checkbox' name='checkSaleShop<?php echo $aux; ?>' id='checkSaleShop<?php echo $aux; ?>' class='usrChecksSaleShop'>
					<?php }?>
				</td>
				<td>
					<input type='text' name='tInputTyreSaleShop<?php echo $aux; ?>' id='tInputTyreSaleShop<?php echo $aux; ?>' class='autocompleteTyreSaleShop usrTyreSaleShop' num='<?php echo $aux; ?>' />					
					<input type='hidden' name='hIdTyreSaleShop<?php echo $aux; ?>' id='hIdTyreSaleShop<?php echo $aux; ?>' class='usrIdsSaleShop' />
				</td>
				<td><a href='javascript:void(0)' title='Borrar llanta' class='bDeleteSaleShop' obj_type='Tyre' num='<?php echo $aux; ?>' ><img src='../icons/delete.png'></a></td>
				<td><input type='text' name='tInputAmountSaleShop<?php echo $aux; ?>' id='tInputAmountSaleShop<?php echo $aux; ?>' class='usrAmountSaleShop inputQuantity' /></td>
				<td id='tyre_quantitySaleShop<?php echo $aux; ?>' class='tyre_quantitySaleShop'></td>
				<td>
					<input type='text' name='tInputDeptorSaleShop<?php echo $aux; ?>' id='tInputDeptorSaleShop<?php echo $aux; ?>' class='autocompleteDeptor usrDeptorSaleShop' num='<?php echo $aux; ?>' />
					<input type='hidden' name='hIdDeptorSaleShop<?php echo $aux; ?>' id='hIdDeptorSaleShop<?php echo $aux; ?>' class='usrIdsSaleShop' />
				</td>
				<td><a href='javascript:void(0)' title='Borrar deudor' class='bDeleteSaleShop' obj_type='Deptor' num='<?php echo $aux; ?>' ><img src='../icons/delete.png'></a></td>
				<td><input type='text' name='tInputBsSaleShop<?php echo $aux; ?>' id='tInputBsSaleShop<?php echo $aux; ?>' class='usrBsSaleShop inputPrice' /></td>
				<td><input type='text' name='tInputSusSaleShop<?php echo $aux; ?>' id='tInputSusSaleShop<?php echo $aux; ?>' class='usrSusSaleShop inputPrice' /></td>
			</tr>
			<?php }// End for ?>
			<tr>
				<td id='message_fieldSaleShop' colspan='9'></td>
			</tr>
		</table>
		
		<input type='hidden' name='hIdSaleShop' id='hIdSaleShop' value='' />
		<input type='hidden' name='hTotalRowsSaleShop' id='hTotalRowsSaleShop' value='<?php echo $aux; ?>' />
		<input type='hidden' name='thSaleShop' id='thSaleShop' value='' />
		<input type='hidden' name='hEventSaleShop' id='hEventSaleShop' value='add' />
	</form>

</div>

</body>
</html>