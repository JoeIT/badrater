<?php 
include_once('../../utils/usr_permission.php');
$up = new UsrPermission();
$up->requestAccessPage(PermissionType::SHOPS_MOVEMENTS);

include('../../utils/generic_tags.php');
include('../../controller/c_shops.php');

$control = new ControllerShops();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script>
$(document).ready(function() {

<?php 
if( $up->isPageActionAllowed(PermissionType::SHOPS, PermissionType::SHOP_A) ||
	$up->isPageActionAllowed(PermissionType::SHOPS, PermissionType::SHOP_D)){
?>
	$("#usrDateEOShop").datepicker({
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
	$('#usrDateEOShop').change(function(){
		$.post("../utils/shopDateChange.php", { date: $('#usrDateEOShop').val() }, function(){
			reloadMain();
		});
	});
<?php } ?>
	
	$("#entriesOutsTable").tablesorter({widthFixed: true, widgets: ['zebra']});
	
	$("#bAddEOShop").button().click(function()
	{
		preOpenDialog("", "add");
	});
	
	$(".bModifyIO").click(function()
	{
		preOpenDialog($(this).attr("shop_entry_out"), "modify");
	});
	
	$(".bDeleteIO").click(function()
	{
		preOpenDialog($(this).attr("shop_entry_out"), "delete");
	});
	
	function preOpenDialog(id, event)
	{
		// Array with ok's name button
		var buttonOkName = {"add":"Agregar", "modify":"Modificar", "delete":"Borrar"};
		
		// Setting Buttons
		$("#dAddModifyShopEO").dialog( "option", "buttons", [
		{
			text: buttonOkName[event],
			id: 'saveButtonEOShop',
			
			click: function() {
				// Disabling save button
				$('#saveButtonEOShop').prop('disabled', true);
				
				$.post("shops/shop_eo_form.php", $('#fAddModifyShopEO').serialize(), function(data){					
					
					warningResetEOShop();
					
					// Extracting posible blank spaces
					data = $.trim(data);
					
					if(data == '')
					{
						reloadMain();
						
						$("#dAddModifyShopEO").dialog("close");
					}
					else
					{
						// Enabling save button
						$('#saveButtonEOShop').prop('disabled', false);
						
						showWarningEOShop(data);
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
		$('#saveButtonEOShop').prop('disabled', false);
		
		$('#hEventEOShop').val(event);
		
		$(".tyre_quantityEOShop").html("");
		
		// Cleaning the message field
		warningResetEOShop();
		
		$('#thEOShop').val( $('#th_eo_EOShop').val() );
		
		
		// Loading data if the event is modify or delete
		if(event != "add")
		{
			$("#hIdEOShop").val(id);
			
			$("#hIdTyreEOShop0").val($("#tdTyreSizeEOShop" + id).attr("tyre_id"));
			
			$("#sInputShopEOShop0").attr('value', $("#tdDestinationEOShop" + id).attr("destination_id"));
			
			$("#tInputTyreEOShop0").val($("#tdTyreSizeEOShop" + id).html() +" "+ $("#tdTyreBrandEOShop" + id).html() +" "+ $("#tdTyreCodeEOShop" + id).html());
			$("#tInputEmployeeEOShop0").val($("#tdEmployeeEOShop" + id).html());
			$("#tInputAmountEOShop0").val($("#tdAmountEOShop" + id).html());
		}
		
		// 
		if(event == "delete")
		{
			$(".usrTyreEOShop").attr('readonly', 'readonly');
			$(".usrShopEOShop").attr('disabled', 'disabled');
			$(".usrEmployeeEOShop").attr('readonly', 'readonly');
			$(".usrAmountEOShop").attr('readonly', 'readonly');
			
			// Hiding all the delete buttons
			$(".bDeleteEOShop").hide();
			
			// Hiding add_only rows
			$(".add_only").hide();
			
			reloadShops();
			$(".usrShopEOShop").val( $("#tdDestinationEOShop" + id).attr("destination_id") );
		}
		else if(event == "modify")
		{
			$(".usrTyreEOShop").attr('readonly', 'readonly');
			$(".usrShopEOShop").removeAttr('disabled');
			
			$(".usrEmployeeEOShop").removeAttr('readonly');
			$(".usrAmountEOShop").removeAttr('readonly');
			
			// Showing the delete buttons
			$(".bDeleteEOShop").show();
			
			// Hiding add_only rows
			$(".add_only").hide();
			
			reloadShops();
			$(".usrShopEOShop").val( $("#tdDestinationEOShop" + id).attr("destination_id") );
		}
		else if(event == "add")
		{
			reloadShops();
			$(".usrTyreEOShop").removeAttr('readonly');
			$(".usrShopEOShop").removeAttr('disabled');
			$(".usrEmployeeEOShop").removeAttr('readonly');
			$(".usrAmountEOShop").removeAttr('readonly');
							
			// Showing the delete buttons
			$(".bDeleteEOShop").show();
			
			// Showing add_only rows
			$(".add_only").show();
			
			$("#hIdEOShop").val("");
			$(".usrIdsEOShop").val("");
			
			$('.usrChecksEOShop').attr('checked', false);
			
			$(".usrTyreEOShop").val("");
			$(".usrShopEOShop").attr('value', "");
			$(".usrEmployeeEOShop").val("");
			$(".usrAmountEOShop").val("");
		}
		
		// Opening dialog window
		$("#dAddModifyShopEO").dialog("open");
	}
	
	$("#dAddModifyShopEO").dialog({
		autoOpen: false,
		height: $(this).data("winHeight"),
		width: 'auto',
		resizable: false,
		modal: true,
		open: function(){
			
		}
	});
});

function showWarningEOShop(text)
{
	$("#message_fieldEOShop").append("<span class='warning_text'>" + text + "</span><br>");
}

function warningResetEOShop()
{
	$("#message_fieldEOShop").html('');
}
</script>

</head>

<body>

<?php
if(($up->isPageActionAllowed(PermissionType::SHOPS, PermissionType::SHOP_A) ||
	$up->isPageActionAllowed(PermissionType::SHOPS, PermissionType::SHOP_D)) &&
	$up->isPageActionAllowed(PermissionType::SHOPS_MOVEMENTS, PermissionType::MOV_O) ) {
?>

<h3>ELEGIR FECHA: <input type='hidden' id='usrDateEOShop' class='inputDate hFormat' value='<?php echo $_SESSION['shopShowDate']; ?>'></h3>

<?php
}

$open_eo_type = 'entry';
if(isset($_GET['eo_type']))
	$open_eo_type = $_GET['eo_type'];



if( $up->isPageActionAllowed(PermissionType::SHOPS_MOVEMENTS, PermissionType::MOV_A) && 
	$up->isPageActionAllowed(PermissionType::SHOPS_MOVEMENTS, PermissionType::MOV_O) ){
?>
<input type="button" name="bAddEOShop" id="bAddEOShop" value="Agregar salida" />
<?php }

// Shop entries table
$control->shop_entries_outs_table($open_eo_type);
?>

<input type='hidden' name='th_eo_EOShop' id='th_eo_EOShop' value='<?php echo $open_eo_type; ?>' />


</body>
</html>

<?php
include('items_shop_eo.php');
?>