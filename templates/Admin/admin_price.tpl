<p>{config_load file=templates.ini section="common" scope="global"} </p>
<div class="content-container">
<h2>Prices</h2>
<form name="add_price" method="post" action="{#script_url#}{seo_url rm="AdminPrice"}">
    <fieldset name="information" id="information">
      <legend>Add New Price</legend>
<p>
  <input type="hidden" name="action" value="list" />
  {if $price.id}
  <input type="hidden" name="price_id" value="{$price.id}" />
  {/if}</p>
    <table>
      <thead>
        <tr>
          <th scope="col" nowrap="nowrap">Height</th>
          <th scope="col" nowrap="nowrap">Width</th>
          <th scope="col" nowrap="nowrap">Price (without dollar sign)</th>
        </tr>
        <tr>
          <th scope="col" nowrap="nowrap"><input type="text" name="height" title="string___Please enter height (eg. 1.22)" value="{$price.height}"/></th>
          <th scope="col" nowrap="nowrap"><input type="text" name="width" title="string___Please enter width (eg. 1.22)" value="{$price.width}"/></th>
          <th scope="col" nowrap="nowrap"><input type="text" name="price" title="numeric___Please enter price" value="{$price.price}"/></th>
        </tr>
      </thead>
      <tfoot>
      </tfoot>
    </table>
	  <br />
	  <input type="submit" name="save" value="Save" class="submit-button" /></td>
      </fieldset> 
  <tr><td>&nbsp;</td>
  </tr>
    <div class="table-list">
<table>
<tr>
	<td><strong>Select price type</strong></td>
	<td>
	<select name="id" onchange="change_type();">
		{foreach from=$price_types item=item key=key}
		<option value="{$key}" {if $type_id == $key}selected{/if}>{$item.title}</option>
		{/foreach}
	</select>	</td>
</tr>

<tr>
	<td><b>Height</b></td>
	<td><b>Width</b></td>
	<td><b>Price</b></td>
	<td><b>Functions</b></td>
</tr>
{foreach from=$prices item=item key=key}
<tr>
	<td>{$item.height}</td>
	<td>{$item.width}</td>
	<td>${$item.price}</td>
	<td><a href="{#script_url#}{seo_url rm="AdminPrice" param1="edit" param2=$item.id}">Edit</a>
		<a href="{#script_url#}{seo_url rm="AdminPrice" param1="delete" param2=$item.id}" onclick="return confirm('Are you sure?');">Delete</a>	</td>
</tr>
{foreachelse}
<tr>
	<td colspan="100" align="center">no prices found</td>
</tr>
{/foreach}
<tr>
	<td colspan="100" align="center"><b>Save price</b></td>
</tr>
<tr>

</table>
</form>
</div>
<script type="text/javascript">
validator.add('add_price');
{literal}
function change_type()
{
	var val = document.forms["add_price"].elements["id"].value;
	document.location = {/literal}'{#script_url#}AdminPrice/list/' + val + '.html';{literal}
}
{/literal}
</script>