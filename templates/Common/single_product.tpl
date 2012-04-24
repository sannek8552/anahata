{config_load file=templates.ini section="common" scope="global"}

<div>
	<form name="add_product{$product.id}" method="post" action="{#script_url#}{seo_url rm="Product"}" >
		<input type="hidden" name="id" value="{$product.id}" />
		{if $cart_info}
		<input type="hidden" name="cart_id" value="{$cart_id}" />
		{/if}
		<div class="single_product_div">
			<div class="product_div {$bcolor}" >
                    <div class="b">
                    	<a href="{#script_url#}{seo_url rm="Product" param1=$product.seo}" >
							<img src="{#script_url#}{show_image id=$product.id width=width height=height}" alt="{$product.name}" />
	                    	<div>
	                    		<p>{$product.name}</p>
	                    	</div>
                    	</a>
                    </div>
            </div>
	        <div id="productDetailsWide">	         	
	       		<div>
	       	    	<h3>{$container_categories[$product.category_id]}</h3>
	       	  	</div>
		      	<div>
					{$product.full_description|truncate:300}
				</div>		
				<br />    		
				{if $product.has_options == 0}
					<div id="price_div" >
			    		{if $product.special.new_price}
			    			<div>Was: <span class="old_price">{$product.special.old_price|money} AUD</span></div>
			                <div class="new_price">Now only: {$product.special.new_price|money} AUD</div><br />
			    			<div class="save_off" style="clear:left;">Save: {$product.special.save_off.percentage}%</div>
			    		{else}
			    			{if $product.price > 0}{$product.price|money} AUD{/if}
			    		{/if}
					</div>
		    		<div id="productQuantity">    
				    	{if $product.quantity != 0  || !$settings.use_out_of_stock}
					    	  <strong>Quantity</strong>:
					    	  <input type="text" name="quantity" size="5"/>    
					    	  <input type="submit" name="save" value="Add" class="btn" />
					    {elseif  $settings.use_out_of_stock}
					    	<img src="{#img_url#}out-stock.gif" align="Out of stock" border="none" />
					    {/if}	    	 	
					</div>
				{else}						
					<div>					
						<table width="480" border="0" cellspacing="0" cellpadding="0">
							<tr>						      
				          		<td><strong>Name</strong></td>
				          		<td width="50"><strong>Code</strong></td>		
				          		<td width="50"><strong>Weight</strong></td>
				          		<td width="80"><strong>Cost</strong></td>
				          		<td width="80"><strong>Quantity</strong></td>
						     </tr>
						     {assign var=has_opt value=0}
						   	 {foreach from=$options item=item key=key}
						  	 	{if $item.inactive == 0 && $item.product_id == $product.id}     
						  	 	{assign var=has_opt value=1}
							    	<tr>						      
							        	<td>{$item.name} </td>
							        	<td>{$item.item_code}</td>
							        	<td>{$item.weight}</td>
							        	<td>{$item.price|money}</td>
							        	<td>
								          	{if $item.quantity > 0 || !$settings.use_out_of_stock}
								          		<input type="text" name="quantity_option[{$key}]" value="{if $cart_info.options.$key}{$cart_info.options.$key}{elseif $request.quantity_option[$key]}{$request.quantity_option[$key]}{/if}" size="8" />
								          	{elseif $settings.use_out_of_stock}
					          					<img src="{#img_url#}out-stock.gif" align="Out of stock" border="none" />
					          				{/if}
							          	</td>
						        	</tr>
								{/if}
					  		  {/foreach}
					  		  {if !$has_opt}
					  		  <tr>
					  		  	<td colspan="100" align="center">no options</td>
					  		  </tr>
					  		  {else}
					  		  <tr>
					  		  	<td colspan="4"></td>
					  		  	<td>
					  		  		<input type="submit" name="save" value="Add" class="btn" />
					  		  	</td>
					  		  </tr>
					  		  {/if}
						  </table>						
					  </div>					  
				{/if}	
	
		  	</div>
	
	  </div>

	</form>
	<div style="clear:both;" />
</div>	 </div>