{config_load file=templates.ini section="common" scope="global"}
<table>
<tr>
	<td>Username:</td>
	<td>{$user_info.login}</td>
</tr>
{*
<tr>
	<td>First Name:</td>
	<td>{$user_info.first_name}</td>
</tr>
<tr>
	<td>Last Name:</td>
	<td>{$user_info.last_name}</td>
</tr>
<tr>
	<td>Phone:</td>
	<td>{$user_info.phone}</td>
</tr>
*}
<tr>
	<td>E-Mail:</td>
	<td>{$user_info.email}</td>
</tr>
<tr>
	<td>Groups:</td>
	<td>{$user_info.groups}</td>
</tr>
</table>