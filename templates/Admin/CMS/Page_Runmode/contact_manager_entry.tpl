{config_load file=templates.ini section="common" scope="global"}
<h2>Entries</h2>
<div class="NewButton"><a href="{#script_url#}{seo_url rm="Contact_Manager"}">&larr; Back</a></div>
<br />
<div class="table-list">
<table>
      <thead>
        <tr>
          <th scope="col" nowrap="nowrap">Date</th>
          <th scope="col" nowrap="nowrap">E-mail</th>
          <th scope="col" nowrap="nowrap">Name</th>
          <th scope="col" nowrap="nowrap">Entry</th>
          <th scope="col" nowrap="nowrap">Functions</th>
        </tr>
      </thead>
{foreach from=$entries item=item key=key}
<tr>
        <td>{$item.created|date_format:"%d.%m.%Y"}</td>
	<td>{$item.email}</td>
	<td>{$item.name}</td>
	<td>
		{foreach from = $item.entry item = it key = k}
			{if $k == 'stored_files'}
				{foreach from = $it item = i key = kkk}
					<b>{$kkk}:</b> <a href="{#script_url#}{#stored_module#}contact_module/{$i}" target="_blank">{$i}</a> <br/>
				{/foreach}
			{else}
				<b>{$k}:</b>{$it} <br/>
			{/if}
		{/foreach}
	</td>
	<td><a title="Delete" href="{#script_url#}{seo_url param1=$contact_id param2="delete" param3=$item.id}" onclick="return confirm('Are you sure?');"><img border="none" src="{#admin_img_url#}cross.png" alt="Delete" /></a></td>
</tr>
{/foreach}
<tfoot>
<tr>
	<td colspan="100">
</td>
</tr>
</tfoot>
</table>
</div>