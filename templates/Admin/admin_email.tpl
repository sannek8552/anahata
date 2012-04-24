{config_load file=templates.ini section="common" scope="global"}
<div class="content-container">
<h2>Admin Payment Email Settings</h2>
{if $saved == 1}
<div style="color:blue;">settings saved</div>
{/if}
<form name="admin_email" action="{#script_url#}{seo_url rm="AdminEmail"}" method="post" >
    <fieldset name="information" id="information">
      <legend>Email Settings</legend>
	<table>
	
		<tr>
			<td>From name</td>
			<td><input type="text" name="from_name" value="{$info.from_name}" /></td>
		</tr>
		<tr>
			<td>From email</td>
			<td><input type="text" name="from_email" value="{$info.from_email}" /></td>
		</tr>
		<tr>
			<td>Admin email</td>
			<td><input type="text" name="admin_email" value="{$info.admin_email}" /></td>
		</tr>
		<tr>
			<td colspan="2" ><input type="submit" name="save" value="Save" class="submit-button" /></td>
		</tr>
	</table>
</form>
</fieldset>
</div>