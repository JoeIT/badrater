<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<script>
$(document).ready(function() {
	$(".autocompleteTyre").attr('size', 25);
	
	$( ".usrDate" ).datepicker({
		maxDate: '0',
		minDate: new Date(2010, 0, 1),
		changeMonth: true,
		changeYear: true,
		dateFormat: 'dd/mm/yy',
		firstDay: 1,
		monthNamesShort: [ "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre" ],
		dayNamesMin: [ "Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa" ]
	});
	
	// Autocomplete tyre
	$(".autocompleteTyre").autocomplete({
		source: function( request, response ) {
			$.ajax({
				url: "../model/list_tyres.php",
				data: {searchCondition: request.term,
						searchType: function(){
							return $('#tyreTypeSearch option:selected').val();
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
			$("#hIdTyre" + rowNum).val(ui.item.id);
			$("#tInputTyre" + rowNum).attr("readonly", "readonly");
			
			if( $(".autocompleteTyre").attr('size') < (ui.item.label).length + 3 )
				$(".autocompleteTyre").attr('size', (ui.item.label).length + 3 );
			
			// Updating quantity
			showTyreQuantity(ui.item.id, rowNum);
		},
		autoFocus: true
	});
	
	//---------------------------------------------------
	// Delete events
	$(".bDelete").click(function(){
		var type = $(this).attr("obj_type");
		var rowNum = $(this).attr("num");
		
		var field = type + rowNum;
		
		// Deleting the data of tyres in the respective row num
		$("#tInput" + field).val("");
		$("#hId" + field).val("");
		
		// Reseting the tyre quantity
		$('#tyre_quantity' + rowNum).html('');
		
		// Removing the attribute read-only
		$("#tInput" + field).removeAttr("readonly");
	});
	
	//------------------------------------------------------
	// Change events
	$('#tInputDate0').change(function(){
		fillVoidFields('tInputDate', $('#tInputDate0').val(), false);
	});
	
	$('#tInputEmployee0').change(function(){
		fillVoidFields('tInputEmployee', $('#tInputEmployee0').val(), false);
	});
	
	$('.usrStore').change(function(){
		var rowNum = $(this).attr("num");
		
		$("#sInputShop" + rowNum).attr('value', '');
	});
	
	$('.usrShop').change(function(){
		var rowNum = $(this).attr("num");
		
		$("#sInputStore" + rowNum).attr('value', '');
	});
});

function fillVoidFields(fieldId, cloneValue, readOnly)
{
	var currentEvent = $('#hEventStoreOut').val();
	
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

function showTyreQuantity(tyreId, row)
{
	$.ajax({
		url: "../model/ajax_store_quantity.php",
		data: {id: tyreId},
		type: 'post',
		dataType: "json",
		success: function(quantity) {
			$('#tyre_quantity' + row).html('/' + quantity);
		}
	});
}

</script>

</head>

<body>

<div id="dAddModifyStoreOuts" title="MOVIMIENTOS">

	<form id='fAddModifyStoreOuts' action='store_outs.php' method='post'>
		<table>
			<tr>
				<th>&nbsp;</th>
				<th>&nbsp;</th>
				<th>FECHA</th>
				<th>LLANTA (*)
					<select id='tyreTypeSearch'>
						<option value='code'>Cod</option>
						<option value='size'>Med</option>
					</select>
				</th>
				<th>&nbsp;</th>
				<th>DEPOSITO(*-)</th>
				<th>TIENDA(*-)</th>
				<th>ENVIO</th>
				<th colspan='2'>CANT. (*)</th>
			</tr>
			<?php 
			include_once('../../controller/c_stores.php');
			include_once('../../controller/c_shops.php');
			//include_once('../../utils/config.php');
			
			$store = new ControllerStores();
			$shop = new ControllerShops();
			$conf = Config::getInstance();
			
			$arrayStores = $store->stores_array(true);
			$arrayShops = $shop->shops_array(false);
			
			// NOTE: Do not change the 0 aux start value, other behaviors depend of it.
			$aux = 0;
			for(; $aux < 10; $aux++){?>
			<tr <?php if($aux > 0){ echo "class='add_only'";} ?> >
				<td><?php echo $aux + 1 . ')'; ?></td>
				<td><?php
					if($aux > 0){ ?>
					<input type='checkbox' name='check<?php echo $aux; ?>' id='check<?php echo $aux; ?>' class='usrChecks'>
					<?php }?>
				</td>
				<td><input type='text' name='tInputDate<?php echo $aux; ?>' id='tInputDate<?php echo $aux; ?>' class='usrDate inputDate' /></td>
				<td>
					<input type='text' name='tInputTyre<?php echo $aux; ?>' id='tInputTyre<?php echo $aux; ?>' class='autocompleteTyre usrTyre' num='<?php echo $aux; ?>' />					
					<input type='hidden' name='hIdTyre<?php echo $aux; ?>' id='hIdTyre<?php echo $aux; ?>' class='usrIds' />
				</td>
				<td><a href='javascript:void(0)' title='Borrar llanta' class='bDelete' obj_type='Tyre' num='<?php echo $aux; ?>' ><img src='../icons/delete.png'></a></td>
				<td>
					<select name='sInputStore<?php echo $aux; ?>' id='sInputStore<?php echo $aux; ?>' class='usrStore' num='<?php echo $aux; ?>'>
						<option value=''></option>
						<?php 
						foreach($arrayStores as $st)
						{
							echo "<option value='". $st['id'] ."'>". $st['name'] ."</option>";
						} ?>
					</select>
				</td>
				<td>
					<select name='sInputShop<?php echo $aux; ?>' id='sInputShop<?php echo $aux; ?>' class='usrShop' num='<?php echo $aux; ?>'>
						<option value=''></option>
						<?php 
						foreach($arrayShops as $sh)
						{
							echo "<option value='". $sh['id'] ."'>". $sh['name'] ."</option>";
						} ?>
					</select>
				</td>
				<td><input type='text' name='tInputEmployee<?php echo $aux; ?>' id='tInputEmployee<?php echo $aux; ?>' class='usrEmployee' /></td>
				<td><input type='text' name='tInputAmount<?php echo $aux; ?>' id='tInputAmount<?php echo $aux; ?>' class='usrAmount inputQuantity' /></td>
				<td id='tyre_quantity<?php echo $aux; ?>' class='tyre_quantity'></td>
			</tr>
			<?php }// End for ?>
			<tr>
				<td id='message_field' colspan='11'></td>
			</tr>
		</table>
		
		<input type='hidden' name='hId' id='hId' value='' />
		<input type='hidden' name='hTotalRows' id='hTotalRows' value='<?php echo $aux; ?>' />
		<input type='hidden' name='hEventStoreOut' id='hEventStoreOut' value='add' />
	</form>

</div>

</body>
</html>