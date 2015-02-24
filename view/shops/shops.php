<?php 
include_once('../../utils/usr_permission.php');
$up = new UsrPermission();
$up->requestAccessPage(PermissionType::SHOPS);

include('../../controller/c_shops.php');
$control_shops = new ControllerShops();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<script>
$(document).ready(function() {
	
	$("#shopsTable").tablesorter({widthFixed: true, widgets: ['zebra']});
	
	$("#bAddShop").button().click(function()
	{
		preOpenDialogShop("", "add");
	});
	
	$(".bModifyShop").click(function()
	{
		preOpenDialogShop($(this).attr("shop"), "modify");
	});
	
	$(".bDeleteShop").click(function()
	{
		preOpenDialogShop($(this).attr("shop"), "delete");
	});
	
	function preOpenDialogShop(id, event)
	{
		// Array with ok's name button
		var buttonOkName = {"add":"Agregar", "modify":"Modificar", "delete":"Borrar"};
		
		// Setting Buttons
		$("#dAddModifyShop").dialog( "option", "buttons", [
		{
			text: buttonOkName[event],
			id: 'saveButtonShop',
			
			// Sending input data
			click: function() {
				// Disabling save button
				$('#saveButtonShop').prop('disabled', true);
				
				$.post("shops/shops_form.php", $('#fAddModifyShop').serialize(), function(data){					
					
					shopWarningReset();
					
					// Extracting posible blank spaces
					data = $.trim(data);
					
					if(data == '')
					{
						updatePlacesBar('shops');
						reloadMain();
						
						$("#dAddModifyShop").dialog("close");
					}
					else
					{
						// Enabling save button
						$('#saveButtonShop').prop('disabled', false);
						
						showWarningShop(data);
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
		$('#saveButtonShop').prop('disabled', false);
		
		$("#hEventShop").val(event);
		
		// Cleaning the message field
		shopWarningReset();
		
		if(event == "delete")
		{
			$("#tInputNameShop").attr('readonly', 'readonly');
			$("#tInputInfoShop").attr('readonly', 'readonly');
		}
		else
		{
			$("#tInputNameShop").removeAttr('readonly');
			$("#tInputInfoShop").removeAttr('readonly');
		}
		
		// If the event is modify or delete
		if(event != "add")
		{
			$("#hIdShop").val(id);
			  
			$("#tInputNameShop").val($("#tdNameShop" + id).html());
			$("#tInputInfoShop").val($("#tdInfoShop" + id).html());
		}
		else
		{
			$("#hIdShop").val("");
			
			$("#tInputNameShop").val("");
			$("#tInputInfoShop").val("");
		}
		
		// Opening dialog window
		$("#dAddModifyShop").dialog("open");
	}
	
	$("#dAddModifyShop").dialog({
		autoOpen: false,
		height: 'auto',
		width: 'auto',
		resizable: false,
		modal: true,
		open: function(){
			
		}
	});
});

function showWarningShop(text)
{
	$("#shop_message_field").append("<span class='warning_text'>" + text + "</span><br>");
}

function shopWarningReset()
{
	$("#shop_message_field").html('');
}
</script>

</head>

<body>

<?php
// Shops table
$control_shops->shop_table();

include('item_shop.php');

if( $up->isPageActionAllowed(PermissionType::SHOPS, PermissionType::SHOP_A) ){
?>
<input type="button" name="bAddShop" id="bAddShop" value="Agregar tienda" />
<?php } ?>

</body>
</html>