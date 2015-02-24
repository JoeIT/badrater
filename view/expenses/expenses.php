<?php 
include('../../controller/c_expenses.php');
$control_expenses = new ControllerExpenses();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $tag_company_name.$tag_title_separator; ?>GASTOS</title>

<script>
$(document).ready(function() {
	
	$("#expensesTable").tablesorter({widthFixed: true, widgets: ['zebra']});
	
	$("#bAddExpense").button().click(function()
	{
		preOpenDialogExpense("", "add");
	});
	
	$(".bModifyExpense").click(function()
	{
		preOpenDialogExpense($(this).attr("expense"), "modify");
	});
	
	$(".bDeleteExpense").click(function()
	{
		preOpenDialogExpense($(this).attr("expense"), "delete");
	});
	
	function preOpenDialogExpense(id, event)
	{
		// Array with ok's name button
		var buttonOkName = {"add":"Agregar", "modify":"Modificar", "delete":"Borrar"};
		
		// Setting Buttons
		$("#dAddModifyExpense").dialog( "option", "buttons", [
		{
			text: buttonOkName[event],
			id: 'saveButtonExpense',
			
			// Sending input data
			click: function() {
				// Disabling save button
				$('#saveButtonExpense').prop('disabled', true);
				
				$.post("expenses/expenses_form.php", $('#fAddModifyExpense').serialize(), function(data){					
					
					expenseWarningReset();
					
					// Extracting posible blank spaces
					data = $.trim(data);
					
					if(data == '')
					{
						reloadMain();
						
						$("#dAddModifyExpense").dialog("close");
					}
					else
					{
						// Enabling save button
						$('#saveButtonExpense').prop('disabled', false);
						
						showWarningExpense(data);
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
		$('#saveButtonExpense').prop('disabled', false);
		
		$("#hEventExpense").val(event);
		
		// Cleaning the message field
		expenseWarningReset();
		
		if(event == "delete")
		{
			$("#tInputDescriptionExpense").attr('readonly', 'readonly');
			$("#tInputBsExpense").attr('readonly', 'readonly');
			$("#tInputSusExpense").attr('readonly', 'readonly');
		}
		else
		{
			$("#tInputDescriptionExpense").removeAttr('readonly');
			$("#tInputBsExpense").removeAttr('readonly');
			$("#tInputSusExpense").removeAttr('readonly');
		}
		
		// If the event is modify or delete
		if(event != "add")
		{
			$("#hIdExpense").val(id);
			  
			$("#tInputDescriptionExpense").val($("#tdDescription" + id).html());
			$("#tInputBsExpense").val($("#tdBs" + id).html());
			$("#tInputSusExpense").val($("#tdSus" + id).html());
		}
		else
		{
			$("#hIdExpense").val("");
			
			$("#tInputDescriptionExpense").val("");
			$("#tInputBsExpense").val("0");
			$("#tInputSusExpense").val("0");
		}
		
		// Opening dialog window
		$("#dAddModifyExpense").dialog("open");
	}
	
	$("#dAddModifyExpense").dialog({
		autoOpen: false,
		height: 'auto',
		width: 'auto',
		resizable: false,
		modal: true,
		open: function(){
			
		}
	});
});

function showWarningExpense(text)
{
	$("#expense_message_field").append("<span class='warning_text'>" + text + "</span><br>");
}

function expenseWarningReset()
{
	$("#expense_message_field").html('');
}
</script>

</head>

<body>

<?php
// Expenses table
$control_expenses->expenses_table($totalDayBsSales, $totalDaySusSales);

include('item_expense.php');
?>


<input type="button" name="bAddExpense" id="bAddExpense" value="Agregar gasto" />

</body>
</html>