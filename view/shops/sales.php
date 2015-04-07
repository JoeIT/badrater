<?php 
include_once('../../utils/usr_permission.php');
include('../../controller/c_shops.php');

$control = new ControllerShops();
$up = new UsrPermission();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title><?php echo $tag_company_name.$tag_title_separator; ?>VENTAS</title>

<script>
$(document).ready(function() {

<?php 
if( $up->isPageActionAllowed(PermissionType::SHOPS, PermissionType::SHOP_A) ||
	$up->isPageActionAllowed(PermissionType::SHOPS, PermissionType::SHOP_D)){
?>
	$("#usrDateSale").datepicker({
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
	$('#usrDateSale').change(function(){
		$.post("../utils/shopDateChange.php", { date: $('#usrDateSale').val() }, function(){
			reloadMain();
		});
	});
<?php } ?>
	
	$("#salesTable").tablesorter({widthFixed: true, widgets: ['zebra']});
	
	$("#bAddSale").button().click(function()
	{
		preOpenSalesDialog("", "add");
	});
	
	$(".bModifySale").click(function()
	{
		preOpenSalesDialog($(this).attr("shop_sale"), "modify");
	});
	
	$(".bDeleteSale").click(function()
	{
		preOpenSalesDialog($(this).attr("shop_sale"), "delete");
	});
	
	function preOpenSalesDialog(id, event)
	{
		// Array with ok's name button
		var buttonOkName = {"add":"Agregar", "modify":"Modificar", "delete":"Borrar"};
		
		// Setting Buttons
		$("#dAddModifyShopSale").dialog( "option", "buttons", [
		{
			text: buttonOkName[event],
			id: 'saveButtonSaleShop',
			
			click: function() {
				// Disabling save button
				$('#saveButtonSaleShop').prop('disabled', true);
				
				$.post("shops/shop_sales_form.php", $('#fAddModifyShopSale').serialize(), function(data){
					
					warningResetSaleShop();
					
					// Extracting posible blank spaces
					data = $.trim(data);
					
					if(data == '')
					{
						reloadMain();
						
						$("#dAddModifyShopSale").dialog("close");
					}
					else
					{
						// Enabling save button
						$('#saveButtonSaleShop').prop('disabled', false);
						
						showWarningSaleShop(data);
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
		$('#saveButtonSaleShop').prop('disabled', false);
		
		$('#hEventSaleShop').val(event);
		
		$(".tyre_quantitySaleShop").html('');
		
		// Cleaning the message field
		warningResetSaleShop();
		
		
		// Loading data if the event is modify or delete
		if(event != "add")
		{
			$("#hIdSaleShop").val(id);
			
			$("#hIdTyreSaleShop0").val($("#tdTyreSizeSaleShop" + id).attr("tyre_id"));
			
			if( $("#tdPaymentTypeSaleShop" + id).attr("deptor_id") != "" )
			{
				$("#tInputDeptorSaleShop0").val($("#tdPaymentTypeSaleShop" + id).html());
				$("#hIdDeptorSaleShop0").val($("#tdPaymentTypeSaleShop" + id).attr("deptor_id"));
			}
			else
			{
				$("#tInputDeptorSaleShop0").val("");
				$("#hIdDeptorSaleShop0").val("");
			}
			
			
			$("#tInputTyreSaleShop0").val($("#tdTyreSizeSaleShop" + id).html() +" "+ $("#tdTyreBrandSaleShop" + id).html() +" "+ $("#tdTyreCodeSaleShop" + id).html());
			$("#tInputBsSaleShop0").val($("#tdPaymentBsSaleShop" + id).html());
			$("#tInputSusSaleShop0").val($("#tdPaymentSusSaleShop" + id).html());
			$("#tInputAmountSaleShop0").val($("#tdAmountSaleShop" + id).html());
		}
		
		// 
		if(event == "delete")
		{
			$(".usrTyreSaleShop").attr('readonly', 'readonly');
			$(".usrDeptorSaleShop").attr('readonly', 'readonly');
			$(".usrBsSaleShop").attr('readonly', 'readonly');
			$(".usrSusSaleShop").attr('readonly', 'readonly');
			$(".usrAmountSaleShop").attr('readonly', 'readonly');
			
			// Hiding all the delete buttons
			$(".bDeleteSaleShop").hide();
			
			// Hiding add_only rows
			$(".add_only").hide();
		}
		else if(event == "modify")
		{
			$(".usrTyreSaleShop").attr('readonly', 'readonly');
			
			if($("#hIdDeptorSaleShop0").val() != "")
				$(".usrDeptorSaleShop").attr('readonly', 'readonly');
			else
				$(".usrDeptorSaleShop").removeAttr('readonly');
			
			$(".usrBsSaleShop").removeAttr('readonly');
			$(".usrSusSaleShop").removeAttr('readonly');
			$(".usrAmountSaleShop").removeAttr('readonly');
			
			// Showing the delete buttons
			$(".bDeleteSaleShop").show();
			
			// Hiding add_only rows
			$(".add_only").hide();
		}
		else if(event == "add")
		{
			$(".usrTyreSaleShop").removeAttr('readonly');
			$(".usrDeptorSaleShop").removeAttr('readonly');
			$(".usrBsSaleShop").removeAttr('readonly');
			$(".usrSusSaleShop").removeAttr('readonly');
			$(".usrAmountSaleShop").removeAttr('readonly');
							
			// Showing the delete buttons
			$(".bDeleteSaleShop").show();
			
			// Showing add_only rows
			$(".add_only").show();
			
			$("#hIdSaleShop").val("");
			$(".usrIdsSaleShop").val("");
			
			$('.usrChecksSaleShop').attr('checked', false);
			
			$(".usrTyreSaleShop").val("");
			$(".usrDeptorSaleShop").val("");
			$(".usrBsSaleShop").val("0");
			$(".usrSusSaleShop").val("0");
			$(".usrAmountSaleShop").val("");
		}
		
		// Opening dialog window
		$("#dAddModifyShopSale").dialog("open");
	}
	
	$("#dAddModifyShopSale").dialog({
		autoOpen: false,
		height: 'auto',
		width: 'auto',
		resizable: false,
		modal: true,
		open: function(){
			
		}
	});

    <?php
    if( $up->isPageActionAllowed(PermissionType::SHOPS_MOVEMENTS, PermissionType::MOV_A) ||
    $up->isPageActionAllowed(PermissionType::SHOPS_MOVEMENTS, PermissionType::MOV_D)) {
        ?>
	$('#totalDaySales').html("<h3 align='center' > En caja Bs: " + $('#totalDayBsSales').val() + " - Sus: " + $('#totalDaySusSales').val() + "</h3>");
	<?php } ?>
});

function showWarningSaleShop(text)
{
	$("#message_fieldSaleShop").append("<span class='warning_text'>" + text + "</span><br>");
}

function warningResetSaleShop()
{
	$("#message_fieldSaleShop").html('');
}
</script>

</head>

<body>

<?php
if( $up->isPageActionAllowed(PermissionType::SHOPS, PermissionType::SHOP_A) ||
	$up->isPageActionAllowed(PermissionType::SHOPS, PermissionType::SHOP_D)) {
?>
<h3>ELEGIR FECHA: <input type='hidden' id='usrDateSale' class='inputDate hFormat' value='<?php echo $_SESSION['shopShowDate']; ?>'></h3>

<?php
}

$totalDayBsSales = 0;
$totalDaySusSales = 0;

echo "<div id='totalDaySales'></div>";

$control->sales($totalDayBsSales, $totalDaySusSales);

if( $up->isPageActionAllowed(PermissionType::SHOPS_MOVEMENTS, PermissionType::MOV_A) ||
    $up->isPageActionAllowed(PermissionType::SHOPS_MOVEMENTS, PermissionType::MOV_D)) {
?>

<input type="button" name="bAddSale" id="bAddSale" value="Agregar venta" />

</br>

<?php
include_once('../debts/debts.php');
?>

</br>

<?php
include_once('../expenses/expenses.php');

// Saving daily total amounts to be showed ahead
echo '<input type="hidden" id="totalDayBsSales" value="'. $totalDayBsSales .'" >';
echo '<input type="hidden" id="totalDaySusSales" value="'. $totalDaySusSales .'" >';

?>

</body>
</html>
<?php

include('items_shop_sales.php');

}
?>