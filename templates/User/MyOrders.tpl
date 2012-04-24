<p>{config_load file=templates.ini section="common" scope="global"} </p>
<div id="bodyContent">
<h1>Payment History</h1>
<form name="payment" action="{#script_url#}{seo_url rm="MyOrders"}" method="post" >
    <fieldset name="information" id="information">
      <legend>Filter Results by Date</legend><div id="selectShort">  
	<b>Date from:</b>&nbsp;{html_select_date end_year="+3" field_order="DMY" prefix="from_" time=$date_from}&nbsp;to&nbsp;{html_select_date end_year="+3" field_order="DMY" prefix="to_" time=$date_to} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type="submit" name="save" class="short" value="Filter" /></div>
	
    </fieldset>
<div class="table-list">
<table width="96%">
      <thead>
        <tr>
          <th scope="col" nowrap="nowrap">Shipping Address</th>
          <th scope="col" nowrap="nowrap">Method</th>
          <th scope="col" nowrap="nowrap">Total</th>
          <th scope="col" nowrap="nowrap">Order ID</th>
          <th scope="col" nowrap="nowrap">Date</th>    
          <th scope="col" nowrap="nowrap">Products</th>
        </tr>
      </thead>
{foreach from=$page item=item key=key}
<tr>
	<td valign="top">
		{$item.shipping_address}<br/>
		{$item.shipping_address2} {$item.shipping_suburb}  
		{$item.shipping_state} {$item.shipping_postcode}<br/>
	  	{$item.shipping_phone}<br />
	  	{$countries[$item.shipping_country_id].name}
	</td>
	<td valign="top">{if $item.method == 'card'}Credit Card{elseif $item.method == 'deposit'}Direct Deposit{else}{$item.method}{/if}</td>	
	<td valign="top">${$item.total}</td>
	<td valign="top">{$item.transaction_id}</td>
	<td valign="top">
		{$item.created|date_output:"d.m.Y"}	</td>
	<td valign="top">
		<table>
	{foreach from=$item.products item=product key=key}
		<tr>							
			<td>
				{if $product.certificate}
					{$certificates[$product.product_id].name}
				{else}
					{$products[$product.product_id].name}
					{if $product.option}
						<br />
						{$options[$product.option_id].name}	
					{/if}
				{/if}
			</td>
		</tr>		
	{/foreach}
		</table></td>
	</tr>

{foreachelse}
<tr>
	<td colspan="95" align="center">No payments found</td>
</tr>
{/foreach}
{if $info.prepared}
<tfoot>
<tr>
	<td colspan="95">
	Pages:&nbsp;
	{foreach from=$info.prepared item=item key=key}
	{if $item == $info.current}<b>{$item}</b>
	{else}
	<a href="{#script_url#}{seo_url rm="MyOrders" param1="Page" param2=$item}">{$item}</a>
	{/if}
	{/foreach}	</td>
</tr>
</tfoot>
{/if}
</table></div>
</form>
<p><a href="{#script_url#}{seo_url rm='Profile'}" id="Profile">Back to Profile</a></p>
</div>