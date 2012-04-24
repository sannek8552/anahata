{config_load file=templates.ini section="common" scope="global"}

<form id="settings_form" action="javascript:void(0);" method="post">

<table style="text-align: left;">
<tr>
	<td>Cron command:</td>
	<td>
	{*<span style="font-size: 16px; color: #2647a0;">wget {#domain_name#}{#script_url#}{seo_url rm='nl_posting_process'}</span><br />*}
		<span style="font-size: 16px; color: #2647a0; font-family: Arial">cd {$path} && /path_to_php/php cron_index.php nl_posting_process</span><br />

	</td>
</tr>

{foreach from=$settings item=i}
<tr>
{if $i.name}

	<td>{$i.title}:</td>
        {if $i.name eq 'smtp_password'}
	<td><input type="password" name="{$i.name}" value="{$i.value}" class="values" /></td>
        {else}
        <td><input type="text" name="{$i.name}" value="{$i.value}" class="values" /></td>
        {/if}
{else}
	<td></td>
	<td><b>{$i.title}</b></td>
{/if}
</tr>
{/foreach}
<tr>
    <td>Example of CSV:</td>
    <td><a href="{#script_url#}example.csv">example.csv</a></td>

</tr>
<tr>
	<td></td>
	<td><input type="button" value="Save" onclick="nlsettings.save();" style="width: auto;"/></td>
</tr>
</table>
</form>

