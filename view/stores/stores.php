<?php 
include_once('../../utils/usr_permission.php');
$up = new UsrPermission();
$up->requestAccessPage(PermissionType::STORES);

include_once('../../controller/c_stores.php');
$control = new ControllerStores();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title><?php echo $tag_company_name.$tag_title_separator; ?>DEPOSITOS</title>

<script>
$(document).ready(function() {
	
	$("#storesTable").tablesorter({widthFixed: true, widgets: ['zebra']});
	
	$("#bAddStore").button().click(function()
	{
		preOpenStoreDialog("", "add");
	});
	
	$(".bModifyStore").click(function()
	{
		preOpenStoreDialog($(this).attr("store"), "modify");
	});
	
	$(".bDeleteStore").click(function()
	{
		preOpenStoreDialog($(this).attr("store"), "delete");
	});
	
	function preOpenStoreDialog(id, event)
	{
		loadVirtualSelect( $("#tdTypeStore" + id).attr('virtual') );
		
		// Array with ok's name button
		var buttonOkName = {"add":"Agregar", "modify":"Modificar", "delete":"Borrar"};
		
		// Setting Buttons
		$("#dAddModifyStore").dialog( "option", "buttons", [
		{
			text: buttonOkName[event],
			id: 'saveButtonStore',
			
			// Sending input data
			click: function() {
				// Disabling save button
				$('#saveButtonStore').prop('disabled', true);
				
				$.post("stores/stores_form.php", $('#fAddModifyStore').serialize(), function(data){					
					
					storeWarningReset();
					
					// Extracting posible blank spaces
					data = $.trim(data);
					
					if(data == '')
					{
						updatePlacesBar('stores');
						reloadMain();
						
						$("#dAddModifyStore").dialog("close");
					}
					else
					{
						// Enabling save button
						$('#saveButtonStore').prop('disabled', false);
						
						showWarningStore(data);
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
		$('#saveButtonStore').prop('disabled', false);
		
		$("#hEventStore").val(event);
		
		// Cleaning the message field
		storeWarningReset();
		
		if(event == "delete")
		{
			$("#tInputNameStore").attr('readonly', 'readonly');
			
			//$("#tInputTypeStore").attr('readonly', 'readonly');
			$("#selVirtual").hide();
			$("#tInputTypeStore").show();
			
			$("#tInputInfoStore").attr('readonly', 'readonly');
		}
		else
		{
			$("#tInputNameStore").removeAttr('readonly');
			
			//$("#tInputTypeStore").removeAttr('readonly');
			$("#tInputTypeStore").hide();
			$("#selVirtual").show();
			
			$("#tInputInfoStore").removeAttr('readonly');
		}
		
		// If the event is modify or delete
		if(event != "add")
		{
			$("#hIdStore").val(id);
			  
			$("#tInputNameStore").val($("#tdNameStore" + id).html());
			$("#tInputTypeStore").val($("#tdTypeStore" + id).html());
			$("#tInputInfoStore").val($("#tdInfoStore" + id).html());
		}
		else
		{
			$("#hIdStore").val("");
			
			$("#tInputNameStore").val("");
			$("#tInputTypeStore").val("");
			$("#tInputInfoStore").val("");
		}
		
		// Opening dialog window
		$("#dAddModifyStore").dialog("open");
	}
	
	$("#dAddModifyStore").dialog({
		autoOpen: false,
		height: 'auto',
		width: 'auto',
		resizable: false,
		modal: true,
		open: function(){
			
		}
	});
});

function showWarningStore(text)
{
	$("#store_message_field").append("<span class='warning_text'>" + text + "</span><br>");
}

function storeWarningReset()
{
	$("#store_message_field").html('');
}
</script>

</head>

<body>

<?php

// Stores table
$control->store_table();


include('item_store.php');

if( $up->isPageActionAllowed(PermissionType::STORES, PermissionType::STORE_A) ){
?>
<input type="button" name="bAddStore" id="bAddStore" value="Agregar dep&oacute;sito" />
<?php } ?>

</body>
</html>