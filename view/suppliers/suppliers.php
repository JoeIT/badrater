<?php 
include_once('../../utils/usr_permission.php');
include('../../utils/generic_tags.php');
include('../../controller/c_suppliers.php');

$control = new ControllerSuppliers();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $tag_company_name.$tag_title_separator; ?>IMPORTADORES</title>

<script>
$(document).ready(function() {
	
	$("#suppliersTable").tablesorter({widthFixed: true, widgets: ['zebra']});
	
	$("#bAddSup").button().click(function()
	{
		preOpenDialogSup("", "add");
	});
	
	$(".bModifySup").click(function()
	{
		preOpenDialogSup($(this).attr("supplier"), "modify");
	});
	
	$(".bDeleteSup").click(function()
	{
		preOpenDialogSup($(this).attr("supplier"), "delete");
	});
	
	function preOpenDialogSup(id, event)
	{
		// Array with ok's name button
		var buttonOkName = {"add":"Agregar", "modify":"Modificar", "delete":"Borrar"};
		
		// Setting Buttons
		$("#dAddModifySup").dialog( "option", "buttons", [
		{
			text: buttonOkName[event],
			id: 'saveButtonSup',
			
			// Sending input data
			click: function() {
				// Disabling save button
				$('#saveButtonSup').prop('disabled', true);
				
				$.post("suppliers/suppliers_form.php", $('#fAddModifySup').serialize(), function(data){					
					supplierWarningReset();
					
					// Extracting posible blank spaces
					data = $.trim(data);
					
					if(data == '')
					{
						reloadMain();
						
						$("#dAddModifySup").dialog("close");
					}
					else
					{
						// Enabling save button
						$('#saveButtonSup').prop('disabled', false);
						
						showWarningSup(data);
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
		$('#saveButtonSup').prop('disabled', false);
		
		// Cleaning the message field
		supplierWarningReset();
		
		$("#hEventSup").val(event);
		
		
		if(event == "delete")
		{
			$("#tInputNameSup").attr('readonly', 'readonly');
			$("#tInputInfoSup").attr('readonly', 'readonly');
		}
		else
		{
			$("#tInputNameSup").removeAttr('readonly');
			$("#tInputInfoSup").removeAttr('readonly');
		}
		
		// If the event is modify or delete
		if(event != "add")
		{
			$("#hIdSup").val(id);
			  
			$("#tInputNameSup").val($("#tdName" + id).html());
			$("#tInputInfoSup").val($("#tdInfo" + id).html());
		}
		else
		{
			$("#hIdSup").val("");
			
			$("#tInputNameSup").val("");
			$("#tInputInfoSup").val("");
		}
		
		// Opening dialog window
		$("#dAddModifySup").dialog("open");
	}
	
	$("#dAddModifySup").dialog({
		autoOpen: false,
		height: 'auto',
		width: 'auto',
		resizable: false,
		modal: true,
		
		open: function(){
			
		}
	});
});

function showWarningSup(text)
{
	$("#supplier_message_field").append("<span class='warning_text'>" + text + "</span><br>");
}

function supplierWarningReset()
{
	$("#supplier_message_field").html('');
}
</script>

</head>

<body>
<?php

// Suppliers table
$control->suppliers_table();

include('item_supplier.php');

$up = new UsrPermission();
if( $up->isPageActionAllowed(PermissionType::SUPPLIERS, PermissionType::SUPPLIER_A) ){
?>
<input type="button" name="bAddSup" id="bAddSup" value="Agregar importador" />
<?php } ?>

</body>
</html>