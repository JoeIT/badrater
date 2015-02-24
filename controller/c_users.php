<?php
include_once('../../model/query_processor.php');

class ControllerUsers
{
	// Shows a table with the complete stock of users
	public function users_table()
	{
		$counter = 1;
		$empty_row_to_show = 0;
		
		$html_empty_cell = '<td>&nbsp;</td>';
		
		$html_table = 
		'<h2>USUARIOS</h2>
		
		<table id="usersTable" name="usersTable" width="100%" border="0" align="center" class="tablesorter" >
			<thead>
			<tr>
				<th width="4%" align="center" >#</th>
				<th width="30%" >NOMBRE</th>
				<th width="30%" >LOGIN</th>
				<th width="6%" >&nbsp;</th>
			</tr>
			</thead><tbody>';
		
		// Showing data into the table
		$qp = new QueryProcessor();
		$data_array = $qp->query_users();
		
		
		foreach($data_array as $user_id => $user_object)
		{
			$id = $user_object->get_id();
			
			$html_table .= "<tr>
								<td align='center' >$counter</td>
								<td id='tdName$id' >$user_object->name</td>
								<td id='tdLogin$id' >$user_object->login</td>
								<td align='center' >
									<a href='javascript:void(0)' class='bModifyUser' id='bModifyUser' title='Modificar' user='$id' ><img src='../icons/modify.png'></a>
									<a href='javascript:void(0)' class='bDeleteUser' id='bDeleteUser' title='Eliminar' user='$id' ><img src='../icons/delete.png'></a>
								</td>
							</tr>";
			
			$counter ++;
			$empty_row_to_show --;
		}
		
		// Fill the table with empty rows if is needed
		while($empty_row_to_show > 0)
		{
			$html_table .= "<tr>
								$html_empty_cell
								$html_empty_cell
								$html_empty_cell
								$html_empty_cell
							</tr>";
			$empty_row_to_show --;
		}
			
		$html_table .= '</tbody></table>'; // Closing table tag
		
		echo $html_table;
	}
	
	// Add/Modify a user data into the db
	public function save_user($id, $name, $login, $password)
	{
		if(empty($id))
			$objUser = new ObjUser();
		else
			$objUser = new ObjUser($id);
		
		$objUser->name = $name;
		$objUser->login = $login;
		$objUser->password = $password;
		
		if( $objUser->save() )
		{
			if( empty($id) )
			{
				include_once('c_roles.php');
				
				$roles = new ControllerRoles();
				$roles->initiateUserRoles( $objUser->get_id() );
				
				$roles->initiateUserStoresRoles( $objUser->get_id() );
				$roles->initiateUserShopsRoles( $objUser->get_id() );
			}
			
			return true;
		}
		else
			return false;
	}
	
	// Delete a user data from the dbase_add_record
	public function delete_user($id)
	{
		$objUser = new ObjUser($id);
		
		include_once('c_roles.php');
				
		$roles = new ControllerRoles();
		$roles->deleteAllUserRoles( $id );
		
		return $objUser->remove();
	}
	
	public function existUser($id, $login)
	{
		// Showing data into the table
		$qp = new QueryProcessor();
		$logins_array = $qp->query_users_login_array();
		
		foreach($logins_array as $user)
		{
			if( (strtolower($login) == strtolower($user['login'])) && $id != $user['id'] )
				return true;
		}
		
		return false;
	}
}

?>