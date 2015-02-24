<?php 
include('../../utils/generic_tags.php');
include('../../controller/c_invoices.php');

$control = new ControllerInvoices();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $tag_company_name.$tag_title_separator; ?>FACTURAS</title>

<script>
$(document).ready(function() {
	
	$("#bAddInvoice").button().click(function()
	{
		preOpenDialog("", "add");
	});
	
	$(".bModifyInvoice").click(function()
	{
		preOpenDialog($(this).attr("invoice"), "modify");
	});
	
	$(".bDeleteInvoice").click(function()
	{
		preOpenDialog($(this).attr("invoice"), "delete");
	});
	
	function preOpenDialog(id, event)
	{
		// Array with ok's name button
		var buttonOkName = {"add":"Agregar", "modify":"Modificar", "delete":"Borrar"};
		
		// Setting Buttons
		$("#dAddModifyInvoice").dialog( "option", "buttons", [
		{
			text: buttonOkName[event],
			id: 'saveButtonInvoice',
			
			// Sending input data
			click: function() {
				// Disabling save button
				$('#saveButtonInvoice').prop('disabled', true);
				
				$.post("invoices/invoices_form.php", $('#fAddModifyInvoice').serialize(), function(data){					
					//alert(data);
					if(data == 'Ok')
					{
						reloadMain();
						
						$("#dAddModifyInvoice").dialog("close");
					}
					else
					{
						// Enabling save button
						$('#saveButtonInvoice').prop('disabled', false);
						
						//showWarningTyre(data);
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
		$('#saveButtonInvoice').prop('disabled', false);
		
		$("#hEventInvoice").val(event);
		
		
		if(event == "delete")
		{
			$("#tInputDateInv").attr('readonly', 'readonly');
			$("#tInputNumberInv").attr('readonly', 'readonly');
		}
		else
		{
			$("#tInputDateInv").removeAttr('readonly');
			$("#tInputNumberInv").removeAttr('readonly');
		}
		
		// If the event is modify or delete
		if(event != "add")
		{
			$("#hIdInv").val(id);
			  
			$("#tInputDateInv").val($("#tdDate" + id).html());
			$("#tInputNumberInv").val($("#tdNumber" + id).html());
		}
		else
		{
			$("#hIdInv").val("");
			
			$("#tInputDateInv").val("");
			$("#tInputNumberInv").val("");
		}
		
		// Opening dialog window
		$("#dAddModifyInvoice").dialog("open");
	}
	
	$("#dAddModifyInvoice").dialog({
		autoOpen: false,
		height: 200,
		width: 250,
		resizable: false,
		modal: true,
		open: function(){
			
		}
	});
});
</script>

</head>

<body>

<?php
// Invoices table
$control->invoices_table();

include('item_invoice.php');
?>


<input type="button" name="bAddInvoice" id="bAddInvoice" value="Agregar factura" />

</body>
</html>