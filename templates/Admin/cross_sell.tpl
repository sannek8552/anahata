{config_load file=templates.ini section="common" scope="global"}
<div class="content-container">
  <h2>Cross Sell Manager</h2>  
  {*
  <br /> 
  <a href="{#script_url#}{seo_url rm="AdminSpecial" param1="category"}" class="submit-button">Categories</a>
  <br />  
  *}
<fieldset name="information" id="information">
      <legend>Products</legend>
  <form name="add_special" method="post" action="{#script_url#}{seo_url rm="AdminCrossSell"}" >
  	<input type="hidden" name="type" value="product" />
  	<table>
  		<tr>
  			<td valign="top"><b>All Products</b></td>
			<td colspan="3">
  				<select multiple name="products[]" style="width:100%;">
  				{foreach from=$categories item=category key=ckey}
  					<option value="cat_{$ckey}" disabled>{$category}</option>
	  				{foreach from=$products item=item key=key}
		  				{if $item.category_id == $ckey}
		  					<option value="{$item.id}" {if $selected_products[$item.id]}selected{/if}>
		  						&nbsp;&nbsp;{$item.name} ({$item.price|money}) ID {$item.number} 
		  						{if $cross_sells[$item.id]}
		  							:
		  							{foreach from=$cross_sells[$item.id] item=citem key=cskey name="cross_for"}
		  								{if $products[$citem.cross_product_id]}
		  									{$products[$citem.cross_product_id].name} ({$item.price|money}) ID {$item.number} 
		  								{/if}
		  								{if !$smarty.foreach.cross_for.last},{/if}
		  							{/foreach}
		  						{/if}
		  					</option>
		  				{/if}
	  				{/foreach}
	  			{/foreach}
  				</select>
  			</td>
  		</tr>
  		<tr>
  			<td width="150" valign="top"><strong>Product to Cross Sell</strong></td>
<td>
  				<select multiple name="cross_products[]" style="width:100%;">
  				{foreach from=$categories item=category key=ckey}
  					<option value="cat_{$ckey}" disabled>{$category}</option>
	  				{foreach from=$products item=item key=key}
	  					{if $item.category_id == $ckey}
	  						<option value="{$item.id}" >{$item.name} ({$item.price|money}) ID {$item.number} </option>
	  					{/if}
	  				{/foreach}
	  			{/foreach}
  				</select>
  			</td>
  		</tr>
    	<tr>
    		<td></td>
    		<td><input type="submit" name="save" value="Save" class="submit-button" /></td>
    	</tr>
  	</table>
  </form></fieldset>  
</div>