{config_load file=templates.ini section="common" scope="global"}
<h2>Settings</h2>
<form action="{#script_url#}{seo_url}" method="post">
    <fieldset name="information" id="information">
      <legend>E-mail Settings</legend>
<table>
{foreach from = $settings item = item key = key}
	<tr>
		<td align="left" valign="top">
			{$item.alias}	
		</td>
		<td align="left">
			<input type="text" name="{$key}" value="{$item.value}" />
			{foreach from = $errors item = e key = k}
				{if $k == $key}<div style="color:red;">Please enter correct value</div> {/if}
			{/foreach}
		</td>
	</tr>
{/foreach}
	<tr>
		<td>&nbsp;
			
		</td>
		<td>
			<input type="submit" name="send" value="Save" class="submit-button"/>
		</td>
	</tr>
</table>
</fieldset>
</form>