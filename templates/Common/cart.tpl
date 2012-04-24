{config_load file=templates.ini section="common"}
<script type="text/javascript" src="{#js_url#}mootools-1.2-more.js"></script>
{literal}
<script type="text/javascript">		
window.addEvent('domready', function()
			{			
				var Tips2 = new Tips($$('.Tips2'), 
										{
											initialize:function()
													{
														this.fx = new Fx.Style(this.toolTip, 'opacity', {duration: 500, wait: false}).set(0);
													},
											onShow: function(toolTip) 
													{
														this.fx.start(1);				
													},
											onHide: function(toolTip)
													{
														this.fx.start(0);
													}			
										});		
			}); 	
{/literal}
</script>	


<div id="bodyContent">

<div class="required_class">

{foreach from=$error_messages item=item key=key}

{$item}<br />

{/foreach}

</div>

{if $cart}
<h1>My Shopping Cart </h1>
<fieldset name="information" id="information">
<legend>Cart Contents</legend>

<form name="cart" action="{#script_url#}{seo_url rm="Cart"}" method="post" >

<table width="96%" border="0" cellpadding="0" cellspacing="0">
  <thead>
  <tr>
    <td width="60">&nbsp;</td>
	  <td width="200"><b>Item</b></td>	
	  <td width="100" align="center"><b>Quantity</b></td>	
	  <td width="100"><b>Price (ea)</b></td>
	  </tr>
  </thead>
  {foreach from=$cart item=item key=key}  
  <tr>
    <td align="right" valign="top">
    	{if $item.certificate}
    		<img src="{#script_url#}{show_image id=$item.product_id width=option_width height=option_height param1=2}" alt="{$item.name}" title="<div style='background-color:#ffffff;padding:0px;'><IMG src='{#script_url#}{show_image id=$item.product_id width=tip_width height=tip_height param1=2}'/></div>" class="Tips2" />  	
    	{else}
    		<img src="{#script_url#}{show_image id=$item.product_id width=option_width height=option_height}" alt="{$item.name}" title="<div style='background-color:#ffffff;padding:0px;'><IMG src='{#script_url#}{show_image id=$item.product_id width=tip_width height=tip_height}'/></div>" class="Tips2" />  	
    	{/if}    </td>
	  <td valign="top">
	    <p>
	    	{if $item.certificate}
	    		{$certificates[$item.product_id].name}
	    	{else}
		    	{$products[$item.product_id].name} 
		      		{if $item.option_id}
		      			<br />
		      			<strong>Option:</strong>  {$options[$item.option_id].name}
		      		{/if}
		     {/if}
	    </p>
	    <p>
	    	{if $item.certificate}
	    		<a href="{#script_url#}{seo_url rm="Certificate" param1=$item.product_id param2="EditCart" param3=$key }" class="cart">Edit</a> 
	    		<a onclick="return confirm('Are you sure?');" href="{#script_url#}{seo_url rm="Cart" param1="Delete" param2=$key}"class="cart"><img border="none" src="{#img_url#}cross.png" alt="{$L_DELETE}" />Remove</a>
	    	{else}
	    		<a href="{#script_url#}{seo_url rm="Product" param1=$item.product_id param2="EditCart" param3=$key }" class="cart">Edit</a> 
	    		<a onclick="return confirm('Are you sure?');" href="{#script_url#}{seo_url rm="Cart" param1="Delete" param2=$key}"class="cart"><img border="none" src="{#img_url#}cross.png" alt="{$L_DELETE}" />Remove</a>
	    	{/if}	    </p>
	  </td>	
	  <td align="center" valign="top">
	  	{if !$products[$item.product_id].has_options}
	  		{if $item.certificate}
	  		1
	  		{else}
	    	<input type="text" name="quantity_{$key}" value="{$item.quantity}" size="4"/>
	    	{/if}
	    {/if}
	  </td>
  
	<td valign="top" nowrap="nowrap">		
	  {if !$products[$item.product_id].has_options}
	  {$item.price|money} AUD
	  {/if}	</td>
	  </tr>
  
  {if $item.options}
  
  {foreach from = $item.options item = it key = k}
  
	<tr>
		<td valign="top" align="center">
			{if $options.$k.picture}
      			<img src="{#script_url#}{show_image id=$k width=option_width height=option_height param1=1}" alt="{$options.$k.small_name}" title="<div style='background-color:#ffffff;padding:5px;'><IMG src='{#script_url#}{show_image id=$k width=tip_width height=tip_height param1=1}'/></div>" class="Tips2"  />          
      		{else}
      			{$options.$k.small_name}
      		{/if}      	</td>  
       <td>              
 	       {$options.$k.name|escape}            
 	       <p>
 	       		<a href="{#script_url#}{seo_url rm="Product" param1=$key param2="EditCart" }" class="cart">Edit</a> 
	    		<a onclick="return confirm('Are you sure?');" href="{#script_url#}{seo_url rm="Cart" param1="DeleteOption" param2=$key param3=$k}"class="cart"><img border="none" src="{#img_url#}cross.png" alt="{$L_DELETE}" />Remove</a> 	       </p>
 	    </td>  
	    <td align="center">              
        	<input type="text" name="opt_quantity_{$key}_{$k}" value="{$it}" size="4"/>            
       	</td>  
        <td>              
            {$options.$k.price|money}
        </td>
        <td>
        	
        </td>
      </tr>
  {/foreach}
  
  {/if}    
  
  {/foreach}
  <tr>
    <td valign="bottom">&nbsp;</td>
    <td height="30" valign="bottom"><b>Shipping</b></td>
    {if $settings.shipping_type == 0}
    	<td align="center" valign="bottom">{$shipping.method}</td>
    	<td valign="bottom">{if $shipping.price}{$shipping.price|money}{else}Free{/if}</td>
    {elseif $settings.shipping_type == 1}
    	<td align="center" valign="bottom">
    		<select name="fixed_shipping_id" >
    			{foreach from=$fixed_shippings item=item key=key}
    			<option value="{$item.id}" {if $shipping.id == $item.id}selected{/if} >{$item.method}  {$item.price|money}</option>
    			{/foreach}
    		</select>    		
    	</td>
    {elseif $settings.shipping_type == 2}
    	<td align="center" valign="bottom">{$shipping.method}</td>
    	<td valign="bottom">{if $shipping.price}{$shipping.price|money}{else}Free{/if}</td>
    {/if}
  </tr>
  
  {if $wholesale_discount}
  <tr>
    <td valign="bottom">&nbsp;</td>
	  <td height="30" valign="bottom"><b class="productFontLg">Wholesale discount:</b></td>
	  <td align="center" valign="bottom"><b class="productFontLg">{$wholesale_discount|money}</b></td>
  </tr>
  {/if}
  <tr>
    <td valign="bottom">&nbsp;</td>
  
	<td height="30" valign="bottom"><b class="productFontLg">Sub total:</b></td>
      <td align="center">&nbsp;</td>
  
	<td valign="bottom"><b class="productFontLg">
	  
	  {if $total_with_coupons === 0 || $total_with_coupons > 0}
	  
	  <strike>{$cart_total|money}</strike>
	  
	  {if $total_with_coupons === 0}
	  	free
	  {else}
	  	{$total_with_coupons|money}
	  {/if}
	  
	  {else}
	  
	  {$cart_total|money}
	  
	  {/if}
	  
	  </b></td>
  </tr>
  
  {if $logged_in}
  
  {if $coupons}
  
  {foreach from=$coupons item=item}
  
  <tr>
    <td >&nbsp;</td>
	  
	    <td > <b class="productFontLg" >{$item.name}</b></td>
	  
	    <td align="center">{$item.discount|money}</td>
	  
	    <td id="cartLinks"><a href="{#script_url#}{seo_url param1 = 'delete_coupon' param2 = $item.id}" onclick="return confirm('Are you sure?')" >Remove</a></td>
	  </tr>
  
  {/foreach}
  
  {/if}
  
  <tr>
    <td valign="top">&nbsp;</td>
	  
		<td valign="top"><b class="productFontLg">Coupon code:</b><br />
		  
		  <span style="font-size:8pt;">(Enter code and press update cart)</span> </td>
	  
		<td align="center" valign="top"><input type="text" name="code" size="4"/></td>
	  </tr>
  {else}
  
  <tr>
    <td valign="top">&nbsp;</td>
	  
		<td valign="top"><b class="productFontLg">Coupon code:</b><br />
		  
		  <span style="font-size:8pt;color:red;">(To use coupon code you should <a href="{#script_url#}{seo_url rm="Login" param1=0 param2="Cart"}" >log in</a>.<br />If you have not account please <a href="{#script_url#}{seo_url rm="Registration"}" >register</a>)</span> </td>
	  
		<td align="center" valign="top"><input type="text" name="c" size="4"/></td>
	  </tr>	
  
  {/if}
  
{if $logged_in} 

  {if $cart_certificates}
  
  {foreach from=$cart_certificates item=item}
  
  <tr>
    <td >&nbsp;</td>
	  
	    <td > <b class="productFontLg" >{$item.name}</b></td>
	  
	    <td align="center">{$item.discount|money}</td>
	  
	    <td id="cartLinks"><a href="{#script_url#}{seo_url param1 = 'delete_certificate' param2 = $item.id}" onclick="return confirm('Are you sure?')" >Remove</a></td>
	  </tr>
  
  {/foreach}
  
  {/if}
  
  <tr>
    <td valign="top">&nbsp;</td>
	  
		<td valign="top"><b class="productFontLg">Certificate code:</b><br />
		  
		  <span style="font-size:8pt;">(Enter code and press update cart)</span> </td>
	  
		<td align="center" valign="top"><input type="text" name="certificate_code" size="4"/></td>
	  </tr>
  {else}
  
  <tr>
    <td valign="top">&nbsp;</td>
	  
		<td valign="top"><b class="productFontLg">Certificate code:</b><br />
		  
		  <span style="font-size:8pt;color:red;">(To use certificate code you should <a href="{#script_url#}{seo_url rm="Login" param1=0 param2="Cart"}" >log in</a>.<br />If you have not account please <a href="{#script_url#}{seo_url rm="Registration"}" >register</a>)</span> </td>
	  
		<td align="center" valign="top"><input type="text" name="c" size="4"/></td>
	  </tr>	
  
  {/if}  
  
  <tr>
    
    <td colspan="100">&nbsp;</td>
  </tr>
</table>
<input type="button" name="continue" class="btnVw"  value="Continue Shopping" {if $continue_shopping_url}onclick="document.location='{#script_url#}{$continue_shopping_url}';"{/if} />

<input type="submit" name="update_quantity" value="Update cart" class="btnW" />

<input type="submit" name="checkout" value="Checkout" class="btnW"   />

<div>

</div>

</form>
</fieldset>

{* CROSS SELL FEATURE SECTION *}		
  		
	{include file='Common/we_recommend.tpl'}
			
{* END OF CROSS SELL FEATURE SECTION *}


{else}

<div>

  <h1>My Shopping Cart </h1>

	There are currently no items in your Shopping Cart.

</div>

{/if}

</div>