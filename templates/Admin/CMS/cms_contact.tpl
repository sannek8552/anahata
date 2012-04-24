{config_load file=templates.ini section="common" scope="global"}
<form name="cms_contact" action="{#script_url#}{seo_url}" method="post">
<table width="50%">
<tr>
	<td colspan="2" align="center"><h1>Contact Page Settings</h1></td>
</tr>
{if $updated}
<tr>
	<td colspan="2" class="s_message" align="center">Settings updated</td>
</tr>
{/if}
<tr>
	<td>From Name</td>
	<td><input type="text" name="from_name" value="{$settings.from_name}" title="string___Enter Name"/></td>
</tr>
<tr>
	<td>From Email</td>
	<td><input type="text" name="from_email" value="{$settings.from_email}" title="email___Enter valid email"/></td>
</tr>
<tr>
	<td>Google Key</td>
	<td><input type="text" name="google_key" value="{$settings.google_key}" /></td>
</tr>
<tr>
	<td>&nbsp;<input type="hidden" name="id" value="{$settings.id}" /></td>
	<td><input type="submit" name="save" value="Save" /></td>
</tr>
</table>
<script type="text/javascript">
validator.add('cms_contact');
</script>
</form>
<table>
<tr>
	<td colspan="2" align="center"><h1>Messages</h1></td>
</tr>
<tr>
	<td>Contact Info</td>
	<td>Type</td>
	<td>Message</td>
	<td>functions</td>
</tr>
{foreach from=$messages item=item key=key}
<tr>
	<td>
		<b>Name:<b> {$item.entry.name}<br/>
		<b>Phone:</b> {$item.entry.phone} <br/>
		<b>E-Mail:</b> {$item.entry.mail} <br/>
		<b>Postcode:</b> {$item.entry.postcode}
	</td>
	<td>{$item.entry.type}</td>
	<td>{$item.entry.comments|nl2br}</td>
	<td><a href="{#script_url#}{seo_url param1="delete" param2=$item.id}" onclick="return confirm('Are you sure?');">Delete</a></td>
</tr>
{/foreach}
</table>