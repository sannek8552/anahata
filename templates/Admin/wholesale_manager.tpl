{config_load file=templates.ini section="common" scope="global"}
<div class="content-container">
  <h2>Wholesale Manager</h2>  
    <fieldset name="information" id="information">  
      <legend>Wholesale Details</legend>
      <div id="selectAuto">
  <form name="add_wholesale" method="post" action="{#script_url#}{seo_url rm="WholesaleManager"}" >
  {if $data.id}
  <input type="hidden" name="id" value="{$data.id}" />
  {/if}
  	<table>
  		<tr>
  			<td><strong>Name</strong></td>
		  <td><input type="text" name="name" value="{$data.name}" title="string___Please input name" /></td>
  		</tr>
  		<tr>
  			<td><strong>Category</strong></td>
<td>
  				<select name="category_ids[]" multiple >
  					<option value="0" {if $data.categories[0]}selected{/if} >All products</option>
  					{foreach from=$select_categories item=item key=key}
  					<option value="{$key}" {if $data.categories[$key]}selected{/if} >{$item}</option>
  					{/foreach}
  				</select>  			</td>
  		</tr>
  		<tr>
  			<td><strong>Discount %</strong></td>
		  <td><input type="text" name="discount" value="{$data.discount}" title="numeric___Please input numeric value" /></td>
  		</tr>
  		<tr>
  			<td><strong>Active</strong></td>
		  <td><input type="checkbox" name="active" value="1" {if $data.active}checked{/if} /></td>
  		</tr>
  		<tr>
  			<td></td>
  			<td><input type="submit" name="save" class="submit-button" value="Save" /></td>
  		</tr>
  	</table>  
  </form>
  </div></fieldset>
  <div class="NewButton"><a href="{#script_url#}{seo_url rm="WholesaleManager"}">Add New Wholesale Category</a></div><br />
    <a href="{#script_url#}{seo_url rm="UserList"}" >Apply to Customers</a><br />

  <script type="text/javascript">
  	validator.add('add_wholesale');
  </script>
    <fieldset name="information" id="information">  
      <legend>Wholesale Categories</legend>
  <div class="table-list">
  	<table>
		<tr></tr>
      	<thead>
        <tr>
          <th scope="col" nowrap="nowrap">Name</th>
          <th scope="col" nowrap="nowrap">Category</th>
          <th scope="col" nowrap="nowrap">Discount</th>
          <th scope="col" nowrap="nowrap">Active</th>
          <th scope="col" nowrap="nowrap">Functions</th>      
        </tr>
      </thead>
      {foreach from=$wholesales item=item key=key}
      <tr>
      	<td>{$item.name}</td>
      	<td>
      		{foreach from=$item.categories item=category key=ckey}
      			{if $select_categories[$ckey]}{$select_categories[$ckey]}{else}All products{/if}<br />
      		{/foreach}
      	</td>
      	<td>{$item.discount}%</td>
      	<td>{if $item.active}Yes{else}No{/if}</td>
      	<td><a href="{#script_url#}{seo_url rm="WholesaleManager" param1="Edit" param2=$item.id}" ><img border="0" src="{#admin_img_url#}picture_edit.png" alt="{$L_EDIT}" /></a>  <a href="{#script_url#}{seo_url rm="WholesaleManager" param1="Delete" param2=$item.id}" onclick="return confirm('Are you sure ?');"><img border="none" src="{#admin_img_url#}cross.png" alt="{$L_DELETE}" /></a></td>
      </tr>
      {foreachelse}
      <tr>
      	<td colspan="100" align="center">no wholesales found</td>
      </tr>
      {/foreach}
   </table>
  </div></fieldset>
</div>