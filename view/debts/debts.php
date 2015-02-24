<?php 
include_once('../../controller/c_debts.php');

$control = new ControllerDebts();

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $tag_company_name.$tag_title_separator; ?>PAGO DE DEUDAS</title>

<script>
$(document).ready(function() {
	
	$("#debtsTable").tablesorter({widthFixed: true, widgets: ['zebra']});
	
	$("#bAddDebt").button().click(function()
	{
		preOpenDebtDialog("", "add");
	});
	
	$(".bModifyDebt").click(function()
	{
		preOpenDebtDialog($(this).attr("debt"), "modify");
	});
	
	$(".bDeleteDebt").click(function()
	{
		preOpenDebtDialog($(this).attr("debt"), "delete");
	});
	
	function preOpenDebtDialog(id, event)
	{
		// Array with ok's name button
		var buttonOkName = {"add":"Agregar", "modify":"Modificar", "delete":"Borrar"};
		
		// Setting Buttons
		$("#dAddModifyDebt").dialog( "option", "buttons", [
		{
			text: buttonOkName[event],
			id: 'saveButtonDebt',
			
			// Sending input data
			click: function() {
				// Disabling save button
				$('#saveButtonDebt').prop('disabled', true);
				
				$.post("debts/debts_form.php", $('#fAddModifyDebt').serialize(), function(data){					
					
					debtWarningReset();
					
					// Extracting posible blank spaces
					data = $.trim(data);
					
					if(data == '')
					{
						reloadMain();
						
						$("#dAddModifyDebt").dialog("close");
					}
					else
					{
						// Enabling save button
						$('#saveButtonDebt').prop('disabled', false);
						
						showWarningDebt(data);
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
		$('#saveButtonDebt').prop('disabled', false);
		
		// Cleaning the message field
		debtWarningReset();
		
		$("#hEventDebt").val(event);
		
		if(event == "delete")
		{
			$("#tInputDescriptionDebt").attr('readonly', 'readonly');
			$("#tInputDeptorDebt").attr('readonly', 'readonly');
			$("#tInputBsDebt").attr('readonly', 'readonly');
			$("#tInputSusDebt").attr('readonly', 'readonly');
			
			// Hiding all the delete buttons
			$(".bActionDeleteDebt").hide();
		}
		else
		{
			$("#tInputDescriptionDebt").removeAttr('readonly');
			$("#tInputDeptorDebt").removeAttr('readonly');
			$("#tInputBsDebt").removeAttr('readonly');
			$("#tInputSusDebt").removeAttr('readonly');
			
			// Showing the delete buttons
			$(".bActionDeleteDebt").show();
		}
		
		// If the event is modify or delete
		if(event != "add")
		{
			$("#hIdDebt").val(id);
			  
			$("#tInputDescriptionDebt").val($("#tdDescription" + id).html());
			$("#tInputDeptorDebt").val($("#tdDeptor" + id).html());
			$("#hIdDeptorDebt").val($("#tdDeptor" + id).attr("deptor_id"));
			$("#tInputBsDebt").val($("#tdBs" + id).html());
			$("#tInputSusDebt").val($("#tdSus" + id).html());
			
			$("#tInputDeptorDebt").attr('readonly', 'readonly');
		}
		else
		{
			$("#hIdDebt").val("");
			
			$("#tInputDescriptionDebt").val("");
			$("#tInputDeptorDebt").val("");
			$("#hIdDeptorDebt").val("");
			$("#tInputBsDebt").val("0");
			$("#tInputSusDebt").val("0");
		}
		
		// Opening dialog window
		$("#dAddModifyDebt").dialog("open");
	}
	
	$("#dAddModifyDebt").dialog({
		autoOpen: false,
		height: 'auto',
		width: 'auto',
		resizable: false,
		modal: true,
		open: function(){
			
		}
	});
});

function showWarningDebt(text)
{
	$("#debt_message_field").append("<span class='warning_text'>" + text + "</span><br>");
}

function debtWarningReset()
{
	$("#debt_message_field").html('');
}
</script>

</head>

<body>

<?php
// Debts table
$control->debts_table($totalDayBsSales, $totalDaySusSales);

include('item_debt.php');
?>


<input type="button" name="bAddDebt" id="bAddDebt" value="Agregar pago de deuda" />

</body>
</html>