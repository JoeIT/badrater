<?php 
include_once('../../utils/usr_permission.php');
$up = new UsrPermission();
$up->requestAccessPage(PermissionType::ROLES);

include('../../utils/generic_tags.php');
include('../../controller/c_users.php');

$control = new ControllerUsers();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $tag_company_name.$tag_title_separator; ?>USUARIOS</title>

<script>
$(document).ready(function() {
	
	$("#usersTable").tablesorter({widthFixed: true, widgets: ['zebra']});
	
	$("#bAddUser").button().click(function()
	{
		preOpenDialog("", "add");
	});
	
	$(".bModifyUser").click(function()
	{
		preOpenDialog($(this).attr("user"), "modify");
	});
	
	$(".bDeleteUser").click(function()
	{
		preOpenDialog($(this).attr("user"), "delete");
	});
	
	function preOpenDialog(id, event)
	{
		// Array with ok's name button
		var buttonOkName = {"add":"Agregar", "modify":"Modificar", "delete":"Borrar"};
		
		// Setting Buttons
		$("#dAddModifyUser").dialog( "option", "buttons", [
		{
			text: buttonOkName[event],
			id: 'saveButtonUser',
			
			// Sending input data
			click: function() {
				// Disabling save button
				$('#saveButtonUser').prop('disabled', true);
				
				$.post("users/users_form.php", $('#fAddModifyUser').serialize(), function(data){					
					userWarningReset();
					
					// Extracting posible blank spaces
					data = $.trim(data);
					
					if(data == '')
					{
						reloadMain();
						
						$("#dAddModifyUser").dialog("close");
					}
					else
					{
						// Enabling save button
						$('#saveButtonUser').prop('disabled', false);
						
						showWarningUser(data);
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
		$('#saveButtonUser').prop('disabled', false);
		
		// Cleaning the message field
		userWarningReset();
		
		$("#hEventUser").val(event);
		
		
		if(event == "delete")
		{
			$("#tInputNameUser").attr('readonly', 'readonly');
			$("#tInputLoginUser").attr('readonly', 'readonly');
			$("#tInputPasswordUser").attr('readonly', 'readonly');
			$("#tInputPassword2User").attr('readonly', 'readonly');
			
			$("#tInputPasswordUser").val('***');
			$("#tInputPassword2User").val('***');
		}
		else
		{
			$("#tInputNameUser").removeAttr('readonly');
			$("#tInputLoginUser").removeAttr('readonly');
			$("#tInputPasswordUser").removeAttr('readonly');
			$("#tInputPassword2User").removeAttr('readonly');
			
			$("#tInputPasswordUser").val('');
			$("#tInputPassword2User").val('');
		}
		
		// If the event is modify or delete
		if(event != "add")
		{
			$("#hId").val(id);
			  
			$("#tInputNameUser").val($("#tdName" + id).html());
			$("#tInputLoginUser").val($("#tdLogin" + id).html());
			$("#tInputPasswordUser").val('');
			$("#tInputPassword2User").val('');
		}
		else
		{
			$("#hId").val("");
			
			$("#tInputNameUser").val("");
			$("#tInputLoginUser").val("");
			$("#tInputPasswordUser").val("");
			$("#tInputPassword2User").val("");
		}
		
		// Opening dialog window
		$("#dAddModifyUser").dialog("open");
	}
	
	$("#dAddModifyUser").dialog({
		autoOpen: false,
		height: 'auto',
		width: 'auto',
		resizable: false,
		modal: true,
		open: function(){
			
		}
	});
});

function showWarningUser(text)
{
	$("#user_message_field").append("<span class='warning_text'>" + text + "</span><br>");
}

function userWarningReset()
{
	$("#user_message_field").html('');
}
</script>

</head>

<body>

<?php
// Users table
$control->users_table();

include('item_user.php');

?>
<input type="button" name="bAddUser" id="bAddUser" value="Agregar usuario" />


</body>
</html>