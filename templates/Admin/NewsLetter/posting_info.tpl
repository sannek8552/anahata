{config_load file=templates.ini section="common" scope="global"}
<table style="text-align:left;width:100%;">
<tr>
	<td width="80">Title</td>
	<td>{$data.title}</td>
</tr>
<tr>
	<td>Method</td>
	<td>{$data.method}</td>
</tr>
{if $data.type eq 'group'}
<tr>
	<td>Groups</td>
	<td>
		<div style="width: 300px; max-height: 200px; overflow-x: hidden; overflow-y: auto;">
		{foreach from=$data.groups item=i}{$i.title}<br />{/foreach}
		</div>
	</td>
</tr>

{elseif $data.type eq 'status'}
<tr>
	<td>Status</td>
	<td>
		<div style="width: 300px; max-height: 200px; overflow-x: hidden; overflow-y: auto;">
		{foreach from=$data.statuses item=i}{$i.title}<br />{/foreach}
		</div>
	</td>
</tr>

{elseif $data.type eq 'contact'}
<tr>
	<td>Contact</td>
	<td>
		<div style="width: 300px; max-height: 200px; overflow-x: hidden; overflow-y: auto;">
		{foreach from=$data.contacts item=i}{$i.subject}<br />{/foreach}
		</div>
	</td>
</tr>
{/if}
<tr>
	<td>Date</td>
	<td>
		<div style="width: 300px; max-height: 200px; overflow-x: hidden; overflow-y: auto;">
                    {if $data.date_time != 0}
                        {$data.date_time|date_format:"%B %d, %Y% %H:%M"}
                    {/if}
		</div>
	</td>
</tr>
<tr>
	<td></td>
	<td>
		{if $data.state}
			<b>in progress</b><br />
			<input type="button" value="stop" onclick="nlposting.stop({$data.id});" style="width: auto;" />
		{else}
			<input type="button" value="start" onclick="nlposting.start({$data.id});" style="width: auto;" />
		{/if}
	</td>
</tr>
{if $data.state}
<tr>
	<td></td>
	<td>
		<div style="width: 300px; max-height: 200px; overflow-x: hidden; overflow-y: auto;">
		start process: {$info.start_time|date_format:"%Y-%m-%d %H:%M:%S"}<br />
		last run: {if $info.update_time}{$info.update_time|date_format:"%Y-%m-%d %H:%M:%S"}{else}-{/if}<br />
		Users:<br />
		{foreach from=$info.users item=i}
		{$i.first_name} {$i.last_name} {if $i.mail_sended} - mailed{/if}<br />
		{/foreach}
		</div>
	</td>
</tr>
{/if}
</table>
