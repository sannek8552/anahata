{config_load file=templates.ini section="common" scope="global"}
<h1>Featured Manager</h1>
<form action="{#script_url#}{seo_url}" method="post">
    <fieldset name="information" id="information">
      <legend>Featured options</legend>
		<table width="100%">
		<tr>
			<td colspan="2" align="center">&nbsp;</td>
		</tr>
		<tr>
			<td><b>Number of products to show</b></td>
			<td><input type="text" name="count" value="{$data.count}" /></td>
		</tr>
		<tr>
			<td><b>Display products randomly</b></td>
			<td><input type="checkbox" name="random" {if $data.random == 1}checked{/if} /></td>
		</tr>		
		<tr>
			<td>&nbsp;<input type="hidden" name="id" value="{$data.id}"></td>
			<td><input type="submit" name="save" value="Save" class="submit-button"/></td>
		</tr>
		</table>
		</fieldset>
		</form>
		<div class="table-list">
		<table>
		
		      <thead>
		        <tr>
		          <th scope="col" nowrap="nowrap">Insert Code</th>
		          <th scope="col" nowrap="nowrap">Number of products</th>
		          <th scope="col" nowrap="nowrap">Display products randomly</th>
		          <th scope="col" nowrap="nowrap">Functions</th>    
		        </tr>
		      </thead>
		{foreach from=$records item=item key=key}
		<tr>
			<td>[featured_module?entry={$item.id}]</td>
			<td>{$item.count}</td>
			<td>{if $item.random == 1}yes{else}no{/if}</td>
			<td>
				<a title="Edit" href="{#script_url#}{seo_url param1='edit' param2=$item.id}"><img border="none" src="{#img_url#}edit.png" alt="Edit" /></a>
				<a title="Delete" href="{#script_url#}{seo_url param1='delete' param2=$item.id}" onclick="return confirm('Are you sure?');"><img border="none" src="{#img_url#}cross.png" alt="Delete" /></a>
			</td>
		</tr>
		{/foreach}
		<tfoot>
		<tr>
			<td colspan="100">&nbsp;
		</td>
		</tr>
		</tfoot>
		</table>
		</div>