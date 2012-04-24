{config_load file=templates.ini section="common" scope="global"}
<h2>Product Tops Manager</h2>
<form action="{#script_url#}{seo_url}" method="post">
    <fieldset name="information" id="information">
      <legend>Tops options</legend>
		<table width="100%">
		<tr>
			<td colspan="2" align="center">&nbsp;</td>
		</tr>
		<tr>
			<td><b>Number of products to show</b></td>
			<td><input type="text" name="count" value="{$data.count}" /></td>
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
		          <th scope="col" nowrap="nowrap">Functions</th>    
		        </tr>
		      </thead>
		{foreach from=$records item=item key=key}
		<tr>
			<td>[product_tops_module?entry={$item.id}]</td>
			<td>{$item.count}</td>
			<td>
				<a title="Edit" href="{#script_url#}{seo_url param1='edit' param2=$item.id}"><img border="none" src="{#img_url#}edit.png" alt="Edit" /></a>
				<a title="Delete" href="{#script_url#}{seo_url param1='delete' param2=$item.id}" onclick="return confirm('Are you sure?');"><img border="none" src="{#img_url#}cross.png" alt="Delete" /></a>
			</td>
		</tr>
		{/foreach}
		<tfoot>
		<tr>
			<td colspan="100"> <p>&nbsp; </p>
		</td>
		</tr>
		</tfoot>
		</table>
		</div>