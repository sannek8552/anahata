{config_load file=templates.ini section="common" scope="global"}
<div class="content-container">
<h2>Individual Product Manager</h2>
<div><a href="{#script_url#}{seo_url rm="AdminProduct"}">&larr; Product Manager</a></div>
<div id="adminProduct">
  <form name="edit_product" action="{#script_url#}{seo_url rm="AdminProduct"}" enctype="multipart/form-data" method="post">
      <fieldset name="information" id="information">
    <legend>Product</legend>
    {if $product.id}
  <input type="hidden" name="id" value="{$product.id}" />
    {/if}
  <input type="hidden" name="action" value="save" />
    
  <table>
    
    <tr>
      
      <td width="150" valign="top"><b>Category</b></td>
  
	  <td>
	    
	    <select name="category_id" >

		{foreach from=$categories item=item key=key}

		<option value="{$key}" {if $key == $product.category_id}selected{/if}>{$item}</option>		

		{/foreach}

		</select>		</td>
	  </tr>
    
    <tr>
      
      <td valign="top"><b>Name</b></td>
  
	  <td><input type="text" name="name" value="{$product.name}" title="string___<br/>Please enter product name" /></td>
	  </tr>
    
    <tr>
      
      <td valign="top"><b>Item C<span class="style1">ode</span></b></td>
  
	  <td><input type="text" name="number" value="{$product.number}" /></td>
	  </tr>
    
    <tr>
      	<td valign="top"><b>Price</b></td>
  		<td>
    		<input type="text" name="price" value="{$product.price}" title="numeric___<br/>Please enter price"/>	
    	</td>
	</tr>
	<tr>
		<td valign="top" ><b>Quantity</b></td>
		<td>
			<input type="text" name="quantity" value="{$product.quantity}" title="integer___<br />Please enter quantity" />
		</td>
	</tr>
	<tr>
  		<td valign="top"><b>Lash Type</b></td>
			<td><select name="lash_type" title="numeric_empty___<br/>Please select lash type">
			<option value="">No lash type</option>
			{foreach from = $lashes item = item}
				<option value="{$item.id}" {if $item.id == $product.lash_type}selected{/if}>{$item.title}</option>
			{/foreach}
		</select></td>
  	</tr>  	
    <tr>
      <td valign="top"><b>Weight</b></td>
	    <td><input type="text" name="weight" value="{$product.weight}" title="numeric___<br/>Please enter weight"/></td>
	  </tr>
    <tr>
      <td valign="top"><b>Order</b></td>
	    <td><input type="text" name="order_no" value="{$product.order_no}"/></td>
	  </tr>
    <tr>
      <td valign="top"><b>Subcategory Image</b></td>
	    <td><input type="checkbox" class="submit-button" name="subcategory_picture" {$product.subcategory_picture|checked}/></td>
	  </tr>
    
    <tr>
      
      <td valign="top"><b>Image Upload</b></td>
  
	  <td valign="top"><input type="file" name="picture" />
	  {if $product.id}
	    <b>Current Image</b> <img src="{#picture_url#}{$product.picture}" align="picture"/>
	  {/if}
	  </td>
	    
	  </tr>
    <tr>
      <td valign="top"><b>Basic Description</b></td>
	    <td><textarea name="description" class="wide">{$product.description}</textarea></td>
	  </tr>
    
    <tr>
      <td valign="top"><b>HTML Editor - Full Description</b></td>
	  <td>
		    {if $product && $product.full_description}
		    {fceditor_exact editor_name="full_description" value=$product.full_description}
		    {else}
		    {fceditor_exact editor_name="full_description" value=""}
		    {/if}		
	  </td>
    </tr>
    <tr>
    	<td valign="top"><b>Inactive</b></td>
    	<td><input type="checkbox" name="inactive" {if $product.inactive == 1}checked{/if} /></td>
    </tr>
    
    <tr>
    	<td colspan="2" ><h3>Special</h3></td>
    </tr>
    {*specials module fields*}
    
    {include file='Admin/Special/special_product.tpl'}   
    
    {*end of specials module fields*}
    
    <tr>
      <td>
      		<input type="submit" class="submit-button" name="save" value="Save" /></td>
	  </tr>
  </table>
      </fieldset>
  </div>
</form>
  {fceditor_init}</div>
<script type="text/javascript">
validator.add('edit_product');
</script>
