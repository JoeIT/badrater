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


<title><?php echo $tag_company_name.$tag_title_separator; ?>SALIDAS DEPOSITO</title>

<script>
$(document).ready(function() {
	
<?php 
if( $up->isPageActionAllowed(PermissionType::STORES_MOVEMENTS, PermissionType::MOV_V) ||
	$up->isPageActionAllowed(PermissionType::STORES_MOVEMENTS, PermissionType::MOV_A) ||
	$up->isPageActionAllowed(PermissionType::STORES_MOVEMENTS, PermissionType::MOV_D)) {
?>
	$("#usrChooseDateOutStore").datepicker({
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
	$('#usrChooseDateOutStore').change(function(){
		$.post("../utils/storeDateChange.php", { date: $('#usrChooseDateOutStore').val() }, function(){
			reloadMain();
		});
	});
<?php } ?>	
	
	$("#entriesTable").tablesorter({widthFixed: true, widgets: ['zebra']});
	
	$("#bOutAll").button().click(function()
	{
		$("#dAllStoreOuts").dialog("open");
	});
	
	$("#bAddOut").button().click(function()
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
		$("#dAddModifyStoreOuts").dialog( "option", "buttons", [
		{
			text: buttonOkName[event],
			id: 'saveButtonStoreOuts',
			
			click: function() {
				// Disabling save button
				$('#saveButtonStoreOuts').prop('disabled', true);
				
				$.post("stores/store_outs_form.php", $('#fAddModifyStoreOuts').serialize(), function(data){					
					
					warningReset();
					
					// Extracting posible blank spaces
					data = $.trim(data);
					
					if(data == '')
					{
						reloadMain();
						
						$("#dAddModifyStoreOuts").dialog("close");
					}
					else
					{
						// Enabling save button
						$('#saveButtonStoreOuts').prop('disabled', false);
						
						showWarning(data);
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
		$('#saveButtonStoreOuts').prop('disabled', false);
		
		$("#hEventStoreOut").val(event);
		
		$('.tyre_quantity').html('');
		
		// Cleaning the message field
		warningReset();
		
		
		// Loading data if the event is modify or delete
		if(event != "add")
		{
			$("#hId").val(id);
			
			$("#hIdTyre0").val($("#tdTyreSizeEntryStore" + id).attr("tyre_id"));
			
			
			$("#tInputDate0").val($("#tdDateEntryStore" + id).html());
			$("#tInputTyre0").val($("#tdTyreSizeEntryStore" + id).html() +" "+ $("#tdTyreBrandEntryStore" + id).html() +" "+ $("#tdTyreCodeEntryStore" + id).html());
			
			if($("#tdDestinationEntryStore" + id).attr("type_destination") == "store")
			{
				$("#sInputStore0").attr('value', $("#tdDestinationEntryStore" + id).attr("destination_id") );
				
				$("#sInputShop0").attr('value', '');
			}
			else
			{
				$("#sInputShop0").attr('value', $("#tdDestinationEntryStore" + id).attr("destination_id"));
				
				$("#sInputStore0").attr('value', '');
			}
			
			$("#tInputEmployee0").val($("#tdEmployeeEntryStore" + id).html());
			$("#tInputAmount0").val($("#tdAmountEntryStore" + id).html());
		}
		
		// 
		if(event == "delete")
		{
			$(".usrDate").attr('readonly', 'readonly');
			$(".usrTyre").attr('readonly', 'readonly');
			$(".usrStore").attr('disabled', 'disabled');
			$(".usrShop").attr('disabled', 'disabled');
			$(".usrEmployee").attr('readonly', 'readonly');
			$(".usrAmount").attr('readonly', 'readonly');
			
			// Hiding all the delete buttons
			$(".bDelete").hide();
			
			// Hiding add_only rows
			$(".add_only").hide();
		}
		else if(event == "modify")
		{
			$(".usrDate").removeAttr('readonly');
			$(".usrTyre").attr('readonly', 'readonly');
			$(".usrStore").removeAttr('disabled');
			$(".usrShop").removeAttr('disabled');
			$(".usrEmployee").removeAttr('readonly');
			$(".usrAmount").removeAttr('readonly');
			
			// Showing the delete buttons
			$(".bDelete").show();
			
			// Hiding add_only rows
			$(".add_only").hide();
		}
		else if(event == "add")
		{
			$(".usrDate").removeAttr('readonly');
			$(".usrTyre").removeAttr('readonly');
			$(".usrStore").removeAttr('disabled');
			$(".usrShop").removeAttr('disabled');
			$(".usrEmployee").removeAttr('readonly');
			$(".usrAmount").removeAttr('readonly');
							
			// Showing the delete buttons
			$(".bDelete").show();
			
			// Showing add_only rows
			$(".add_only").show();
			
			$("#hId").val("");
			$(".usrIds").val("");
			
			$('.usrChecks').attr('checked', false);
			
			var myDate = new Date();
			var currentDate = ( (myDate.getDate() <= 9) ? '0'+ myDate.getDate() : myDate.getDate() ) + '/' + ( (myDate.getMonth() < 9) ? '0'+ (myDate.getMonth() + 1) : (myDate.getMonth() + 1) ) + '/' + myDate.getFullYear();
						$(".usrDate").val( currentDate );
			$(".usrTyre").val("");
			$(".usrStore").attr('value', '');
			$(".usrShop").attr('value', '');
			$(".usrEmployee").val("");
			$(".usrAmount").val("");
		}
		
		// Opening dialog window
		$("#dAddModifyStoreOuts").dialog("open");
	}
	
	$("#dAllStoreOuts").dialog({
		autoOpen: false,
		height: 'auto',
		width: 'auto',
		resizable: false,
		modal: true,
		buttons: {
			"Enviar llantas": function() {
				
				$.post("stores/virtual_store_outs.php");
				
				reloadMain();
				
				$( this ).dialog( "close" );
			},
			Cancel: function() {
				$( this ).dialog( "close" );
			}
		}
	});
	
	$("#dAddModifyStoreOuts").dialog({
		autoOpen: false,
		height: 'auto',
		width: 'auto',
		resizable: false,
		modal: true,
		open: function(){
			
		}
	});
	
	function showWarning(text)
	{
		$("#message_field").append("<span class='warning_text'>" + text + "</span><br>");
	}

	function warningReset()
	{
		$("#message_field").html('');
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
<h3>ELEGIR FECHA: <input type='hidden' id='usrChooseDateOutStore' class='inputDate hFormat' value='<?php echo $_SESSION['storeShowDate']; ?>'></h3>

<?php
}

if( $up->isPageActionAllowed(PermissionType::STORES_MOVEMENTS, PermissionType::MOV_A) ){
	if( $control->is_virtual($_SESSION["idStore"]) )
	{
		echo '<input type="button" name="bOutAll" id="bOutAll" value="Traspasar todo" />';
	}
	else
		echo '<input type="button" name="bAddOut" id="bAddOut" value="Agregar salida" />';
}

// Store outs table
$control->store_entries_outs_table('out');
?>


<?php
include('items_store_outs.php');

?>

<div id="dAllStoreOuts" title="SALIDA">
	 <p><span style="float: left; margin: 0 7px 20px 0;"></span>Desea usted enviar todas las llantas?</p>
</div>

</body>
</html>