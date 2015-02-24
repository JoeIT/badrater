<?php 
include_once('../../utils/usr_permission.php');
$up = new UsrPermission();
$up->requestAccessPage(PermissionType::STORES_MOVEMENTS);

include('../../utils/generic_tags.php');
include('../../controller/c_stores.php');

$control = new ControllerStores();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title><?php echo $tag_company_name.$tag_title_separator; ?>ENTREDAS DEPOSITO</title>

<script>
$(document).ready(function() {
	
<?php 
if( $up->isPageActionAllowed(PermissionType::STORES_MOVEMENTS, PermissionType::MOV_V) ||
	$up->isPageActionAllowed(PermissionType::STORES_MOVEMENTS, PermissionType::MOV_A) ||
	$up->isPageActionAllowed(PermissionType::STORES_MOVEMENTS, PermissionType::MOV_D)) {
?>
	$("#usrChooseDateEntryStore").datepicker({
		showOn: 'button',
		buttonText: '<< Elegir >>',
		maxDate: '0',
		minDate: new Date(2010, 0, 1),
		changeMonth: true,
		changeYear: true,
		dateFormat: 'yy-mm-dd',
		firstDay: 1,
		monthNamesShort: [ "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre" ],
		dayNamesMin: [ "Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa" ]
	});
	
	// Change event
	$('#usrChooseDateEntryStore').change(function(){
		$.post("../utils/storeDateChange.php", { date: $('#usrChooseDateEntryStore').val() }, function(){
			reloadMain();
		});
	});
<?php } ?>
	
	$("#entriesTable").tablesorter({widthFixed: true, widgets: ['zebra']});
	
	$("#bAddEntryStore").button().click(function()
	{
		preOpenDialog("", "add");
	});
	
	$(".bModifyIO").click(function()
	{
		preOpenDialog($(this).attr("store_entry_out"), "modify");
	});
	
	$(".bDeleteIO").click(function()
	{
		preOpenDialog($(this).attr("store_entry_out"), "delete");
	});
	
	function preOpenDialog(id, event)
	{
		// Array with ok's name button
		var buttonOkName = {"add":"Agregar", "modify":"Modificar", "delete":"Borrar"};
		
		// Setting Buttons
		$("#dAddModifyStoreEntries").dialog( "option", "buttons", [
		{
			text: buttonOkName[event],
			id: 'saveButtonStoreEntries',
			
			click: function() {
				// Disabling save button
				$('#saveButtonStoreEntries').prop('disabled', true);
				
				$.post("stores/store_entries_form.php", $('#fAddModifyStoreEntries').serialize(), function(data){
					
					warningResetEntryStore();
					
					// Extracting posible blank spaces
					data = $.trim(data);
					
					if(data == '')
					{
						reloadMain();
						
						$("#dAddModifyStoreEntries").dialog("close");
					}
					else
					{
						// Enabling save button
						$('#saveButtonStoreEntries').prop('disabled', false);
						
						showWarningEntryStore(data);
					}
				});
			}
		},
		{
			text: "Cancelar",
			click: function() { $(this).dialog("close"); }
		}
		]);
		
		// Enabling save button
		$('#saveButtonStoreEntries').prop('disabled', false);
		
		$("#hEventEntryStore").val(event);
		
		// Cleaning the message field
		warningResetEntryStore();
		
		// Loading data if the event is modify or delete
		if(event != "add")
		{
			$("#hIdEntryStore").val(id);
			
			$("#hIdTyreEntryStore0").val($("#tdTyreSizeEntryStore" + id).attr("tyre_id"));
			$("#hIdSupplierEntryStore0").val($("#tdSupplierEntryStore" + id).attr("supplier_id"));
			$("#hIdInvoiceEntryStore0").val($("#tdInvoiceEntryStore" + id).attr("invoice_id"));
			
			$("#tInputDateEntryStore0").val($("#tdDateEntryStore" + id).html());
			$("#tInputTyreEntryStore0").val($("#tdTyreSizeEntryStore" + id).html() +" "+ $("#tdTyreBrandEntryStore" + id).html() +" "+ $("#tdTyreCodeEntryStore" + id).html());
			$("#tInputSupplierEntryStore0").val($("#tdSupplierEntryStore" + id).html());
			$("#tInputInvoiceEntryStore0").val($("#tdInvoiceEntryStore" + id).html());
			$("#tInputEmployeeEntryStore0").val($("#tdEmployeeEntryStore" + id).html());
			$("#tInputAmountEntryStore0").val($("#tdAmountEntryStore" + id).html());
		}
		
		// 
		if(event == "delete")
		{
			$(".usrDateEntryStore").attr('readonly', 'readonly');
			$(".usrTyreEntryStore").attr('readonly', 'readonly');
			$(".usrSupplierEntryStore").attr('readonly', 'readonly');
			$(".usrInvoiceEntryStore").attr('readonly', 'readonly');
			$(".usrEmployeeEntryStore").attr('readonly', 'readonly');
			$(".usrAmountEntryStore").attr('readonly', 'readonly');
			
			// Hiding all the delete buttons
			$(".bDeleteEntryStore").hide();
			
			// Hiding add_only rows
			$(".add_only").hide();
		}
		else if(event == "modify")
		{
			$(".usrDateEntryStore").removeAttr('readonly');
			$(".usrTyreEntryStore").attr('readonly', 'readonly');
			$(".usrSupplierEntryStore").attr('readonly', 'readonly');
			$(".usrInvoiceEntryStore").attr('readonly', 'readonly');
			$(".usrEmployeeEntryStore").removeAttr('readonly');
			$(".usrAmountEntryStore").removeAttr('readonly');
			
			// Showing the delete buttons
			$(".bDeleteEntryStore").show();
			
			// Hiding add_only rows
			$(".add_only").hide();
		}
		else if(event == "add")
		{
			$(".usrDateEntryStore").removeAttr('readonly');
			$(".usrTyreEntryStore").removeAttr('readonly');
			$(".usrSupplierEntryStore").removeAttr('readonly');
			$(".usrInvoiceEntryStore").removeAttr('readonly');
			$(".usrEmployeeEntryStore").removeAttr('readonly');
			$(".usrAmountEntryStore").removeAttr('readonly');
							
			// Showing the delete buttons
			$(".bDeleteEntryStore").show();
			
			// Showing add_only rows
			$(".add_only").show();
			
			$("#hIdEntryStore").val("");
			$(".usrIdsEntryStore").val("");
			
			$('.usrChecksEntryStore').attr('checked', false);
			
			var myDate = new Date();
			var currentDate = ( (myDate.getDate() <= 9) ? '0'+ myDate.getDate() : myDate.getDate() ) + '/' + ( (myDate.getMonth() < 9) ? '0'+ (myDate.getMonth() + 1) : (myDate.getMonth() + 1) ) + '/' + myDate.getFullYear();
						$(".usrDateEntryStore").val( currentDate );
			$(".usrTyreEntryStore").val("");
			$(".usrSupplierEntryStore").val("");
			$(".usrInvoiceEntryStore").val("");
			$(".usrEmployeeEntryStore").val("");
			$(".usrAmountEntryStore").val("");
		}
		
		// Opening dialog window
		$("#dAddModifyStoreEntries").dialog("open");
	}
	
	$("#dAddModifyStoreEntries").dialog({
		autoOpen: false,
		height: 'auto',
		width: 'auto',
		resizable: false,
		modal: true,
		open: function(){
			
		}
	});
	
	function showWarningEntryStore(text)
	{
		$("#message_fieldEntryStore").append("<span class='warning_text'>" + text + "</span><br>");
	}

	function warningResetEntryStore()
	{
		$("#message_fieldEntryStore").html("");
	}
});


</script>

</head>

<body>

<?php 
if( $up->isPageActionAllowed(PermissionType::STORES_MOVEMENTS, PermissionType::MOV_V) ||
	$up->isPageActionAllowed(PermissionType::STORES_MOVEMENTS, PermissionType::MOV_A) ||
	$up->isPageActionAllowed(PermissionType::STORES_MOVEMENTS, PermissionType::MOV_D)) {
?>

<h3>ELEGIR FECHA: <input type='hidden' id='usrChooseDateEntryStore' class='inputDate hFormat' value='<?php echo $_SESSION['storeShowDate']; ?>'></h3>

<?php
}

// Store entries table
$control->store_entries_outs_table('entry');

if( $up->isPageActionAllowed(PermissionType::STORES_MOVEMENTS, PermissionType::MOV_A) ){
?>
<input type="button" name="bAddEntryStore" id="bAddEntryStore" value="Agregar entrada" />
<?php } ?>


</body>
</html>

<?php
include('items_store_entries.php');
?>