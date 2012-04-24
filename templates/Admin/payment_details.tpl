{config_load file=templates.ini section="common" scope="global"}
{literal}<style type="text/css">
<!--
h1 {color: #2E8CFF; margin-left:0;}
h2 {color: #2E8CFF; font-size: 16px; margin-bottom: 10px; margin-top: 15px;}
-->
th { background: #2E8CFF; color: #fff; padding: 5px 10px; border-left: 1px solid #CCC; text-align: left;}
td {padding: 5px 10px;}

</style>{/literal}
<h2>Payment History</h2>
<p>Order Date:{$data.created|date_output:"d.m.Y"}</p>
<h2>Order & Shipping Information</h2>
<table width="70%" border="0" cellpadding="0" cellspacing="0">
  <div id="inputShort">
    <thead>
      <tr>
        <th width="150" align="left" valign="top" nowrap="nowrap" scope="col">Client Name</th>
        <th align="left" nowrap="nowrap" scope="col">{$data.client_name}</th>
      </tr>
    </thead>
  </div>
  
<tr>
  <th align="left" valign="top" nowrap="nowrap" scope="col">Billing Address</th>
    <td align="left"><b>Address</b>: {$data.address}<br/>
      <b>Address 2</b>: {$data.address2}<br/>
      <b>Suburb</b>: {$data.suburb}<br/>
      <b>State</b>: {$data.state}<br/>
      <b>Postcode</b>: {$data.postcode}<br/>
      <b>Phone</b>: {$data.phone}<br />
      <b>Email</b>: {$data.email}<br />
      <b>Country</b>: {$countries[$data.country_id].name}    </td>
  </tr>
  <tr>
    <th align="left" valign="top" nowrap="nowrap" scope="col">Shipping Address</th>
    <td align="left"><b>Address</b>: {$data.shipping_address}<br/>
      <b>Address 2</b>: {$data.shipping_address2}<br/>
      <b>Suburb</b>: {$data.shipping_suburb}<br/>
      <b>State</b>: {$data.shipping_state}<br/>
      <b>Postcode</b>: {$data.shipping_postcode}<br/>
      <b>Phone</b>: {$data.shipping_phone}<br />
      <b>Country</b>: {$countries[$data.shipping_country_id].name}    </td>
  </tr>
  <tr>
    <th align="left" valign="top" nowrap="nowrap" scope="col">Comments</th>
    <td align="left">{$data.comments|nl2br}</td>
  </tr>
  <tr>
    <th align="left" valign="top" nowrap="nowrap" scope="col">Shipping Type</th>
    <td align="left">
    	{$data.shipping_info.method} {if $data.shipping_info.price}{$data.shipping_info.price|money}{else}free{/if}
    	{*{$item_shippings[$data.shipping].method} {if $item_shippings[$data.shipping].price}{$item_shippings[$data.shipping].price|money}{else}free{/if}*}
    </td>
  </tr>
  <tr>
    <th align="left" valign="top" nowrap="nowrap" scope="col">Payment Method</th>
    <td align="left">{if $data.method == 'deposit'}direct deposit{elseif $data.method == 'card'}Credit Card{else}{$data.method}{/if}</td>
  </tr>
  <tr>
    <th align="left" valign="top" nowrap="nowrap" scope="col">Transaction ID</th>
    <td align="left">{$data.transaction_id}</td>
  </tr>
  {if $data.wholesale_discount}
  <tr>
    <th align="left" valign="top" nowrap="nowrap" scope="col">Wholesale discount</th>
    <td align="left"><b class="productFontLg">{$data.wholesale_discount|money}</b></td>
  </tr>
  {/if}  
  <tr>
    <th align="left" valign="top" nowrap="nowrap" scope="col">Order Total</th>
    <td align="left"><b class="productFontLg">
      {if $total_with_coupons === 0 || $total_with_coupons > 0}
      <strike>{$cart_total|money}</strike>
      {if $total_with_coupons === 0}
      free
      {else}
      {$total_with_coupons|money}
      {/if}
      {elseif $cart_total}
      	{$cart_total|money}
      {else}
      	{$data.total|money}
      {/if}
      </b>    </td>
  </tr>
</table>
<h2>Product Details</h2>	
{if $coupons_m}
<table width="65%" border="0" cellpadding="0" cellspacing="0">
  <thead>
    <tr>
      <th align="left" nowrap="nowrap" scope="col">Discounts</th>
    </tr>
  </thead>
  
  <tr>
    <td>
      Coupon    </td>
    <td>
      Discount    </td>
  </tr>
  {foreach from = $coupons_m item = item key = key}
  <tr>
    <td>
      {$item.name|escape}    </td>
    <td>
      {$item.discount|money}    </td>
  </tr>
  {/foreach}
</table>
<br/>
{/if}


{if $certificates_m}
<table width="65%" border="0" cellpadding="0" cellspacing="0">
  <thead>
    <tr>
      <th align="left" nowrap="nowrap" scope="col">Certificates</th>
    </tr>
  </thead>
  
  <tr>
    <td>
      Name    </td>
    <td>
      Discount    </td>
  </tr>
  {foreach from = $certificates_m item = item key = key}
  <tr>
    <td>
      {$item.name|escape}    </td>
    <td>
      {$item.discount|money}    </td>
  </tr>
  {/foreach}
</table>
<br/>
{/if}


{if $data.discount_point}
<table width="65%" border="0" cellpadding="0" cellspacing="0">
  <thead>
    <tr>
        <th align="left" nowrap="nowrap" scope="col">Discount points used</th>
	</tr>
  </thead>
  <tr>
   	  <td>{$data.discount_point|money}</td>
  </tr>
</table>
{/if}

<table width="65%" border="0" cellpadding="0" cellspacing="0">
  <thead>
    <tr>
      <th align="left" nowrap="nowrap" scope="col">Products</th>
    </tr>
  </thead>
  <tr>
    <td><strong>Product Name</strong></td>
    <td><strong>Number</strong></td>
    <td><strong>Price</strong></td>
    <td><strong>Quantity</strong></td>
  </tr>
  {foreach from=$data.products item=product key=key}	
  {if $product.certificate}
  <tr>
    <td>{$certificates[$product.product_id].name}</td>
	  <td>#{$certificates[$product.product_id].number}</td>
	  <td>{$product.price|money}</td>
	  <td>{$product.quantity}</td>
  </tr>
  {else}
  <tr>
    <td>{$products[$product.product_id].name}</td>
	  <td>#{$products[$product.product_id].number}</td>
	  <td>{$product.price|money}</td>
	  <td>{$product.quantity}</td>
  </tr>
  {/if}
  {if $product.options}
  <tr>
    <td></td>
	  <td colspan="3">
	      <table> 
		      <thead>
		          <tr>
		            <th align="left" nowrap="nowrap" scope="col">Options</th>
				  </tr>
	          </thead>
		      <tr>
		        <td><strong>Name</strong></td>
		   	    <td><strong>Number</strong></td>
		   	    <td><strong>Price</strong></td>
		   	    <td><strong>Quantity</strong></td>
		      </tr>
		      {foreach from=$product.options item=item key=k}
		      <tr>						
		          <td>			
			          {$options[$k].name}		          </td>
				  <td>#{$options[$k].item_code}</td>
				  <td>{$options[$k].price|money}</td>
				  <td>{$item}</td>
			  </tr>	
		      {/foreach}
	      </table>	  </td>
	  </tr>
  {/if}
  {/foreach}
  <tfoot>
  <tr>
    <td colspan="100"></td>
  </tr>
  </tfoot>
</table>