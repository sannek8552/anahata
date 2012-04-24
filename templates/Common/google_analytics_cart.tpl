{config_load file=templates.ini section="common" scope="global"}
{if $transaction}
<script type="text/javascript">

{literal}

try{
	
	if (typeof(_gat) == 'object') {
	
	  var pageTracker = _gat._getTracker("UA-18443810-1");
	  pageTracker._trackPageview();
	  
	  pageTracker._addTrans(
	  {/literal}
	      "{$transaction.transaction_id}",            // order ID - required
	      "Scotty Makeup",  // affiliation or store name
	      "{$transaction.total}",           // total - required      
	      "",								// tax      
	      "{$item_shippings[$transaction.shipping].price}",           // shipping      
	      "",   //city
	      "",	//state
	      ""	//country
	  {literal}
	    );
	
	
	   // add item might be called for every item in the shopping cart
	   // where your ecommerce engine loops through each item in the cart and
	   // prints out _addItem for each 
	   {/literal}
	   {foreach from=$transaction.products item=product key=key}
	   
		   pageTracker._addItem(
		      "{$transaction.transaction_id}",           // order ID - necessary to associate item with transaction
		      "{$product.product_id}-{if $product.certificate}{$certificates[$product.product_id].name}{else}{$products[$product.product_id].name}{/if}",           // SKU/code - required
		      {if $product.certificate}
		      "{$certificates[$product.product_id].name}",
		      {else}
		      "{$products[$product.product_id].name}",        // product name
		      {/if}	      
		      "", 							//category
		      "{$product.price}",          // unit price - required
		      "{$product.quantity}"               // quantity - required
		   );
		   
		   {if $product.options}
		   		{foreach from=$product.options item=item key=k}
		   			pageTracker._addItem(
				      "{$transaction.transaction_id}",           // order ID - necessary to associate item with transaction
				      "{$k}-{$options[$k].name}",           // SKU/code - required			      
				      "{$options[$k].name}",
				      "",
				      "{$options[$k].price}",          // unit price - required
				      "{$item}"               // quantity - required
				   );
		   		
		   		{/foreach}
		   {/if}
	   
	   {/foreach}
	   {literal}
	
	   pageTracker._trackTrans(); //submits transaction to the Analytics servers
	}
   
} catch(err) 
	{
		alert(err);
	}

{/literal}
</script>
{/if}