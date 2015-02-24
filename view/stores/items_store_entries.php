<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<script>
$(document).ready(function() {
	
	$(".autocompleteTyreEntryStore").attr('size', 25);
	
	$( ".usrDateEntryStore" ).datepicker({
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
	$(".autocompleteTyreEntryStore").autocomplete({
		source: function( request, response ) {
			$.ajax({
				url: "../model/list_tyres.php",
				data: {searchCondition: request.term,
						searchType: function(){
							return $('#tyreTypeSearchEntryStore option:selected').val();
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
			$("#hIdTyreEntryStore" + rowNum).val(ui.item.id);
			$("#tInputTyreEntryStore" + rowNum).attr("readonly", "readonly");
			
			if( $(".autocompleteTyreEntryStore").attr('size') < (ui.item.label).length + 3 )
				$(".autocompleteTyreEntryStore").attr('size', (ui.item.label).length + 3 );
		},
		autoFocus: true
	});
	
	// Autocomplete supplier
	$(".autocompleteSupplierEntryStore").autocomplete({
		source: function( request, response ) {
			$.ajax({
				url: "../model/list_suppliers.php",
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
			// Getting the selected supplier and save it into the hidden
			$("#hIdSupplierEntryStore" + rowNum).val(ui.item.id);
			$("#tInputSupplierEntryStore" + rowNum).attr("readonly", "readonly");
			
			if(rowNum == 0)
			{
				fillVoidFieldsEntryStore('hIdSupplierEntryStore', ui.item.id, false);
				fillVoidFieldsEntryStore('tInputSupplierEntryStore', ui.item.value, true);
			}
		},
		autoFocus: true
	});
	
	// Autocomplete invoice
	$(".autocompleteInvoiceEntryStore").autocomplete({
		source: function( request, response ) {
			$.ajax({
				url: "../model/list_invoices.php",
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
			// Getting the selected invoice and save it into the hidden
			$("#hIdInvoiceEntryStore" + rowNum).val(ui.item.id);
			$("#tInputInvoiceEntryStore" + rowNum).attr("readonly", "readonly");
			
			if(rowNum == 0)
			{
				fillVoidFieldsEntryStore('hIdInvoiceEntryStore', ui.item.id, false);
				fillVoidFieldsEntryStore('tInputInvoiceEntryStore', ui.item.value, true);
			}
		},
		autoFocus: true
	});
	
	//---------------------------------------------------
	// Delete events
	$(".bDeleteEntryStore").click(function(){
		var type = $(this).attr("obj_type");
		var rowNum = $(this).attr("num");
		
		var field = type + 'EntryStore' + rowNum;
		
		// Deleting the data of tyres in the respective row num
		$("#tInput" + field).val("");
		$("#hId" + field).val("");
		
		// Removing the attribute read-only
		$("#tInput" + field).removeAttr("readonly");
	});
	
	//------------------------------------------------------
	// Change events
	$('#tInputDateEntryStore0').change(function(){
		fillVoidFieldsEntryStore('tInputDateEntryStore', $('#tInputDateEntryStore0').val(), false);
	});
	
	$('#tInputEmployeeEntryStore0').change(function(){
		fillVoidFieldsEntryStore('tInputEmployeeEntryStore', $('#tInputEmployeeEntryStore0').val(), false);
	});
});

function fillVoidFieldsEntryStore(fieldId, cloneValue, readOnly)
{
	var currentEvent = $('#hEventEntryStore').val();
	
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

</script>

</head>

<body>

<div id="dAddModifyStoreEntries" title="ENTRADAS">

	<form id='fAddModifyStoreEntries'>
		<table>
			<tr>
				<th>&nbsp;</th>
				<th>&nbsp;</th>
				<th>FECHA</th>
				<th>LLANTA (*)
					<select id='tyreTypeSearchEntryStore'>
						<option value='code'>Cod</option>
						<option value='size'>Med</option>
					</select>
				</th>
				<th>&nbsp;</th>
				<th>IMPORTADOR (*)</th>
				<th>&nbsp;</th>
				<th>FACTURA</th>
				<th>&nbsp;</th>
				<th>RECIBIO</th>
				<th>CANT. (*)</th>
			</tr>
			<?php 
			// NOTE: Do not change the 0 aux start value, other behaviors depend of it.
			$aux = 0;
			for(; $aux < 10; $aux++){?>
			<tr <?php if($aux > 0){ echo "class='add_only'";} ?> >
				<td><?php echo ($aux + 1) . ')'; ?></td>
				<td><?php
					if($aux > 0){ ?>
					<input type='checkbox' name='checkEntryStore<?php echo $aux; ?>' id='checkEntryStore<?php echo $aux; ?>' class='usrChecksEntryStore'>
					<?php }?>
				</td>
				<td><input type='text' name='tInputDateEntryStore<?php echo $aux; ?>' id='tInputDateEntryStore<?php echo $aux; ?>' class='usrDateEntryStore inputDate' /></td>
				<td>
					<input type='text' name='tInputTyreEntryStore<?php echo $aux; ?>' id='tInputTyreEntryStore<?php echo $aux; ?>' class='autocompleteTyreEntryStore usrTyreEntryStore' num='<?php echo $aux; ?>' />					
					<input type='hidden' name='hIdTyreEntryStore<?php echo $aux; ?>' id='hIdTyreEntryStore<?php echo $aux; ?>' class='usrIdsEntryStore' />
				</td>
				<td><a href='javascript:void(0)' title='Borrar llanta' class='bDeleteEntryStore' obj_type='Tyre' num='<?php echo $aux; ?>' ><img src='../icons/delete.png'></a></td>
				<td>
					<input type='text' name='tInputSupplierEntryStore<?php echo $aux; ?>' id='tInputSupplierEntryStore<?php echo $aux; ?>' class='autocompleteSupplierEntryStore usrSupplierEntryStore' num='<?php echo $aux; ?>' />
					<input type='hidden' name='hIdSupplierEntryStore<?php echo $aux; ?>' id='hIdSupplierEntryStore<?php echo $aux; ?>' class='usrIdsEntryStore' />
				</td>
				<td><a href='javascript:void(0)' title='Borrar proveedor' class='bDeleteEntryStore' obj_type='Supplier' num='<?php echo $aux; ?>' ><img src='../icons/delete.png'></a></td>
				<td>
					<input type='text' name='tInputInvoiceEntryStore<?php echo $aux; ?>' id='tInputInvoiceEntryStore<?php echo $aux; ?>'  class='autocompleteInvoiceEntryStore usrInvoiceEntryStore' num='<?php echo $aux; ?>' />
					<input type='hidden' name='hIdInvoiceEntryStore<?php echo $aux; ?>' id='hIdInvoiceEntryStore<?php echo $aux; ?>' class='usrIdsEntryStore' />
				</td>
				<td><a href='javascript:void(0)' title='Borrar factura' class='bDeleteEntryStore' obj_type='Invoice' num='<?php echo $aux; ?>' ><img src='../icons/delete.png'></a></td>
				<td><input type='text' name='tInputEmployeeEntryStore<?php echo $aux; ?>' id='tInputEmployeeEntryStore<?php echo $aux; ?>' class='usrEmployeeEntryStore' /></td>
				<td><input type='text' name='tInputAmountEntryStore<?php echo $aux; ?>' id='tInputAmountEntryStore<?php echo $aux; ?>' class='usrAmountEntryStore inputQuantity' /></td>
			</tr>
			<?php }// End for ?>
			<tr>
				<td id='message_fieldEntryStore' colspan='11'></td>
			</tr>
		</table>
		
		<input type='hidden' name='hIdEntryStore' id='hIdEntryStore' value='' />
		<input type='hidden' name='hTotalRowsEntryStore' id='hTotalRowsEntryStore' value='<?php echo $aux; ?>' />
		<input type='hidden' name='hEventEntryStore' id='hEventEntryStore' value='add' />
	</form>

</div>

</body>
</html>