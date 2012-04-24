{config_load file=templates.ini section="common" scope="global"}
{$mail_text}
{foreach from = $entry key = key item = item}
	{if $key == 'stored_files'}
		{foreach from = $item item = i key = kkk}
		{$to_admin}
			<b>{$kkk}:</b> {if $to_admin == 1}<a href="{#domain_name#}{#script_url#}{#stored_module#}contact_module/{$i}" target="_blank">{$i}</a>{else} {$i} {/if}<br/>
		{/foreach}
	{else}
		<b>{$key}:</b>{$item} <br/>
	{/if}
	{/foreach}
<br/>
<b>E-Mail</b>: {$email}<br/>
<b>Name</b>: {$name}<br />
{if $http_referer}
<br/>
<b>Referer: <a target="_blank" href="{$http_referer}">{$http_referer}</a>
{/if}