{config_load file=templates.ini section="common" scope="global"}
<script type="text/javascript" src="{#js_url#}coupon.js" ></script>
<div class="content-container">
<h2>Individual Coupon Manager</h2>
<div><a href="{#script_url#}{seo_url rm="AdminCoupon"}">&larr; Coupon Manager</a></div>
<div id="adminCoupon">
  <form name="edit_coupon" action="{#script_url#}{seo_url rm="AdminCoupon"}" enctype="multipart/form-data" method="post">
      <fieldset name="information" id="information">
    	<legend>Coupon</legend>
    		{if $coupon.id}
  				<input type="hidden" name="id" value="{$coupon.id}" />
    		{/if}
  		<input type="hidden" name="action" value="save" />
  <table>    
    <tr>
      <td valign="top"><b>Name</b></td>  
	  <td><input type="text" name="name" value="{$coupon.name}" title="string___<br/>Please enter coupon name" /></td>
  	</tr>
  	<tr>
      	<td valign="top"><b>Description</b></td>
	    <td><textarea name="description" class="wide">{$coupon.description}</textarea></td>
  	</tr>
    <tr>
      <td valign="top"><b>Minimum order</b></td>  
	  <td><input type="text" name="minimum_order" value="{$coupon.minimum_order}" title="numeric_empty___Please input valid number (e.g 10.05)" /></td>
  	</tr>
    <tr>
      	<td valign="top"><b>Coupon code</b></td>
  		<td>
    		<input type="text" name="code" value="{$coupon.code}" title="string___<br/>Please enter code"/>
    	</td>
	</tr>
	<tr>
		<td valign="top" ><b>Uses per coupon</b></td>
		<td>
			<input type="text" name="uses_per_coupon" value="{$coupon.uses_per_coupon}" title="integer___<br />Please enter count of uses per coupon" />
		</td>
	</tr>
	<tr>
		<td valign="top" ><b>Uses per customer</b></td>
		<td>
			<input type="text" name="uses_per_customer" value="{$coupon.uses_per_customer}" title="integer___<br />Please enter count of uses per customer" />
		</td>
	</tr>	
    <tr>
    	<td valign="top"><b>Discount type</b></td>
    	<td>
    		<select name="type" >
    			<option value="amount" {if $coupon.type == 'amount'}selected{/if} >Discount amount</option>
    			<option value="percent" {if $coupon.type == 'percent'}selected{/if} >Discount %</option>
    		</select>
    	</td>
    </tr>
    <tr>
    	<td valign="top"><b>Discount value</b></td>
    	<td><input type="text" name="amount" value="{$coupon.amount}" title="numeric___Please input discount (e.g 5.75)" /></td>
    </tr>
    <tr>
    	<td valign="top"><b>Start date</b></td>
    	<td>
    		{if $coupon.start_date}
    			{html_select_date prefix="start" end_year="+4" time=$coupon.start_date field_order="DMY"}
    		{else}
    			{html_select_date prefix="start" end_year="+4" time=$coupon.start_date time=$smarty.now field_order="DMY"}
    		{/if}
    	</td>
    </tr>
    <tr>
    	<td valign="top"><b>End date</b></td>
    	<td>
    		{if $coupon.end_date}
    			{html_select_date prefix="end" end_year="+4" time=$coupon.end_date field_order="DMY"}
    		{else}
    			{html_select_date prefix="end" end_year="+4" time=$coupon.end_date time=$smarty.now  field_order="DMY"}
    		{/if}
    	</td>
    </tr>
    <tr>
    	<td valign="top"><b>Applying coupon to</b></td>
    	<td>
    		<table>
    			<tr>
    				<td><input style="width:15px" type="radio" name="apply_type" value="everything" {if !$coupon.id || $coupon.apply_type == 'everything'}checked{/if} onclick="process_apply();"/> Everything in cart</td>
    			</tr>
    			<tr>
    				<td><input style="width:15px" type="radio" name="apply_type" value="category" {if $coupon.apply_type == 'category'}checked{/if} onclick="process_apply();" /> Category</td>
    				<td>
    					<select id="cid" name="category_id" >    						
    						{foreach from=$categories item=item key=key}
    						<option value="{$key}" {if $coupon.apply_type == 'category' && $coupon.item_id == $key}selected{/if} >{$item}</option>
    						{/foreach}
    					</select>
    				</td>
    			</tr>
   				<tr>
    				<td><input style="width:15px" type="radio" name="apply_type" value="product" {if $coupon.apply_type == 'product'}checked{/if} onclick="process_apply();" /> Single product</td>
    				<td>
    					<select name="product_id" id="pid">
    						{foreach from=$products item=item key=key}
    						<option value="{$key}"  {if $coupon.apply_type == 'product' && $coupon.item_id == $key}selected{/if} >{$item.name} #{$item.number} {$item.price|money}</option>
    						{/foreach}
    					</select>
    				</td>
    			</tr>    			
    		</table>
    	</td>
    </tr>    
    <tr>
      <td><input type="submit" class="submit-button" name="save" value="Save" /></td>
  	</tr>
  </table>
  </fieldset>
 
</form> </div>
  {fceditor_init}</div>
<script type="text/javascript">
validator.add('edit_coupon');
</script>