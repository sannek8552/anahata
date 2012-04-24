{config_load file=templates.ini section="common" scope="global"}
<h2>Direct Deposit Manager</h2>
<form name="deposit" action="{#script_url#}{seo_url rm="AdminDeposit"}" method="post" >
    <fieldset name="information" id="information">
      <legend>Direct Deposit Details</legend>
<table>
<tr>
	<td>
	{*<textarea name="info" cols="30" rows="8" >{$info.info}</textarea>*}
	{if $info.info != ''}	
		{fceditor_exact editor_name="info" value=$info.info}
	{else}
		{fceditor_exact editor_name="info" value=""}
	{/if}	
	</td>
</tr>
<tr>
	<td>Thank you page url</td>
</tr>
<tr>
	<td><input type="text" name="url" value="{$info.url}" /></td>
</tr>
<tr>
	<td><input type="submit" name="save" value="Save" class="submit-button" /></td>
</tr>
</table>
</fieldset>
</form>

{fceditor_init}