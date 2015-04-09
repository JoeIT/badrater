<?php 
include_once('../../utils/usr_permission.php');
include('../../controller/c_tyres.php');
include('../../utils/generic_tags.php');

$control = new ControllerTyres();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $tag_company_name.$tag_title_separator; ?>LLANTAS</title>

<script>
$(document).ready(function() {
	
	$("#tyresTable").tablesorter({widthFixed: true, widgets: ['zebra']});
	
	$("#bAddTyre").button().click(function()
	{
		preOpenDialog("", "add");
	});
	
	$(".bModifyTyre").click(function()
	{
		preOpenDialog($(this).attr("tyre"), "modify");
	});
	
	$(".bDeleteTyre").click(function()
	{
		preOpenDialog($(this).attr("tyre"), "delete");
	});
	
	function preOpenDialog(id, event)
	{
		// Array with ok's name button
		var buttonOkName = {"add":"Agregar", "modify":"Modificar", "delete":"Borrar"};
		
		// Setting Buttons
		$("#dAddModifyTyre").dialog( "option", "buttons", [
		{
			text: buttonOkName[event],
			id: 'saveButton',
			//click: function() { $('#fAddModifyTyre').submit(); }
				
			// Sending input data
			click: function() {
				// Disabling save button
				$('#saveButton').prop('disabled', true);
				
				$.post("tyres/tyres_form.php", $('#fAddModifyTyre').serialize(), function(data){					
					tyreWarningReset();
					
					// Extracting posible blank spaces
					data = $.trim(data);
					
					if(data == '')
					{
						reloadMain();
						
						$("#dAddModifyTyre").dialog("close");
					}
					else
					{
						// Enabling save button
						$('#saveButton').prop('disabled', false);
						
						showWarningTyre(data);
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
		$('#saveButton').prop('disabled', false);
		
		// Cleaning the message field
		tyreWarningReset();
		
		$("#hEventTyre").val(event);
		
		
		if(event == "delete")
		{
			$("#tInputBrandTyre").attr('readonly', 'readonly');
			$("#tInputSizeTyre").attr('readonly', 'readonly');
			$("#tInputCodeTyre").attr('readonly', 'readonly');
		}
		else
		{
			$("#tInputBrandTyre").removeAttr('readonly');
			$("#tInputSizeTyre").removeAttr('readonly');
			$("#tInputCodeTyre").removeAttr('readonly');
		}
		
		// If the event is modify or delete
		if(event != "add")
		{
			$("#hId").val(id);
			  
			$("#tInputBrandTyre").val($("#tdBrand" + id).html());
			$("#tInputSizeTyre").val($("#tdSize" + id).html());
			$("#tInputCodeTyre").val($("#tdCode" + id).html());
		}
		else
		{
			$("#hId").val("");
			
			$("#tInputBrandTyre").val("");
			$("#tInputSizeTyre").val("");
			$("#tInputCodeTyre").val("");
		}
		
		// Opening dialog window
		$("#dAddModifyTyre").dialog("open");
	}
	
	$("#dAddModifyTyre").dialog({
		autoOpen: false,
		height: 'auto',
		width: 'auto',
		resizable: false,
		modal: true
		/*buttons: {
			"Guardar": function()
			{
				$('#fAddModifyTyre').submit();
			},
			"Cancelar": function() {
				$(this).dialog("close");
			}
		},*/
	});
});

function showWarningTyre(text)
{
	$("#tyre_message_field").append("<span class='warning_text'>" + text + "</span><br>");
}

function tyreWarningReset()
{
	$("#tyre_message_field").html('');
}
</script>

</head>

<body>

<?php

include('item_tyre.php');

$up = new UsrPermission();
if( $up->isPageActionAllowed(PermissionType::TYRES, PermissionType::TYRE_A) ){
?>
<input type="button" name="bAddTyre" id="bAddTyre" value="Agregar llanta" />
<?php }
// Tyres table
$control->tyres_table();
?>

</body>
</html>