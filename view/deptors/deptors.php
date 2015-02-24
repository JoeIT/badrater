<?php 
include_once('../../utils/usr_permission.php');
include('../../utils/generic_tags.php');
include('../../controller/c_deptors.php');

$control = new ControllerDeptors();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $tag_company_name.$tag_title_separator; ?>DEUDORES</title>

<script>
$(document).ready(function() {
	
	$("#deptorsTable").tablesorter({widthFixed: true, widgets: ['zebra']});
	
	$("#bAddDeptor").button().click(function()
	{
		preOpenDialog("", "add");
	});
	
	$(".bModifyDeptor").click(function()
	{
		preOpenDialog($(this).attr("deptor"), "modify");
	});
	
	$(".bDeleteDeptor").click(function()
	{
		preOpenDialog($(this).attr("deptor"), "delete");
	});
	
	function preOpenDialog(id, event)
	{
		// Array with ok's name button
		var buttonOkName = {"add":"Agregar", "modify":"Modificar", "delete":"Borrar"};
		
		// Setting Buttons
		$("#dAddModifyDeptor").dialog( "option", "buttons", [
		{
			text: buttonOkName[event],
			id: 'saveButtonDeptor',
			
			// Sending input data
			click: function() {
				// Disabling save button
				$('#saveButtonDeptor').prop('disabled', true);
				
				$.post("deptors/deptors_form.php", $('#fAddModifyDeptor').serialize(), function(data){					
					deptorWarningReset();
					
					// Extracting posible blank spaces
					data = $.trim(data);
					
					if(data == '')
					{
						reloadMain();
						
						$("#dAddModifyDeptor").dialog("close");
					}
					else
					{
						// Enabling save button
						$('#saveButtonDeptor').prop('disabled', false);
						
						showWarningDeptor(data);
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
		$('#saveButtonDeptor').prop('disabled', false);
		
		// Cleaning the message field
		deptorWarningReset();
		
		$("#hEventDeptor").val(event);
		
		
		if(event == "delete")
		{
			$("#tInputNameDeptor").attr('readonly', 'readonly');
			$("#tInputInfoDeptor").attr('readonly', 'readonly');
		}
		else
		{
			$("#tInputNameDeptor").removeAttr('readonly');
			$("#tInputInfoDeptor").removeAttr('readonly');
		}
		
		// If the event is modify or delete
		if(event != "add")
		{
			$("#hIdDeptor").val(id);
			  
			$("#tInputNameDeptor").val($("#tdName" + id).html());
			$("#tInputInfoDeptor").val($("#tdInfo" + id).html());
		}
		else
		{
			$("#hIdDeptor").val("");
			
			$("#tInputNameDeptor").val("");
			$("#tInputInfoDeptor").val("");
		}
		
		// Opening dialog window
		$("#dAddModifyDeptor").dialog("open");
	}
	
	$("#dAddModifyDeptor").dialog({
		autoOpen: false,
		height: 200,
		width: 250,
		resizable: false,
		modal: true,
		open: function(){
			
		}
	});
});

function showWarningDeptor(text)
{
	$("#deptor_message_field").append("<span class='warning_text'>" + text + "</span><br>");
}

function deptorWarningReset()
{
	$("#deptor_message_field").html('');
}
</script>

</head>

<body>

<?php

// Deptors table
$control->deptors_table();

include('item_deptor.php');

$up = new UsrPermission();
if( $up->isPageActionAllowed(PermissionType::DEPTORS, PermissionType::DEPTOR_A) ){
?>
<input type="button" name="bAddDeptor" id="bAddDeptor" value="Agregar deudor" />
<?php } ?>

</body>
</html>