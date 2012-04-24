{config_load file=templates.ini section="common" scope="global"}

<div class="content-container">
  <h2>Customer Report</h2>
  <div class="table-list">
  <form name="payment" action="{#script_url#}{seo_url rm="CustomerReport"}" method="post" >
    <fieldset name="information" id="information">  
      <legend>Filter Results by Date</legend>
      <div id="selectAuto"> 
		<b>Date from:</b>&nbsp;{html_select_date end_year="+3" field_order="DMY" prefix="from_" time=$date_from}&nbsp;<b>to</b>&nbsp;{html_select_date end_year="+3" field_order="DMY" prefix="to_" time=$date_to}
	  </div>
	  &nbsp;<input type="submit" name="save" class="submit-button" value="Filter" />
    </fieldset>
  </form>  
  
  <table>
	<tr></tr>
    <thead>
    	<tr>
          <th scope="col" nowrap="nowrap">Client</th>
          <th scope="col" nowrap="nowrap">Order date</th>
          <th scope="col" nowrap="nowrap">Shipping Type</th>          
          <th scope="col" nowrap="nowrap">Payment Method</th>
          <th scope="col" nowrap="nowrap">Total</th>
          <th scope="col" nowrap="nowrap">Transaction ID</th>          
          <th scope="col" nowrap="nowrap">Products</th>
        </tr>
    </thead>
    {foreach from=$customers item=item key=key}
    <tr>
    	<td>
    	  <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td>Name:   </td>
              <td>{$item.billing.name}</td>
            </tr>
            <tr>
              <td>Username:</td>
              <td>{$item.login}</td>
            </tr>
            <tr>
              <td>Total Orders:</td>
              <td>{$item.payments_count}</td>
            </tr>
            <tr>
              <td>Total Purchases:</td>
              <td>{$item.payments_total|money}</td>
            </tr>
          </table></td>
    	    
    	{foreach from=$item.payments item=payment name=pay_for}
    	{if !$smarty.foreach.pay_for.first}
    	<tr>
    		<td>&nbsp;</td>
    	{/if}
    		<td>{$payment.created|date_output:"d.m.Y H:i:s"}</td>
    		<td>{$shipping_list[$payment.shipping].method} {$shipping_list[$payment.shipping].price|money}</td>
    		<td>
    			{$payment.method}
					{if $payment.method == 'card'}		
						: {$payment.card_number}
					{/if}
    		</td>
    		<td>{$payment.total|money}</td>
    		<td><a href="{#script_url#}{seo_url rm="PaymentDetails" param1=$payment.id}" >{$payment.transaction_id}</a></td>
    		<td valign="top"><ul>
    		  <li>
    		    {foreach from=$payment.products item=product}
    		    {$products[$product.product_id].name}
    		    {if $product.option} <br />
    		    {$options[$product.option_id].name}	
    		    {/if}
    		    {/foreach}	
   		      </li>
  		  </ul></td>		
   	  </tr> 
    	{foreachelse}
    	</tr>
    	{/foreach}    
    {foreachelse}
    <tr>
    	<td colspan="100" align="center" >None customers found</td>
    </tr>	
    {/foreach}</table>
  </div>
</div>