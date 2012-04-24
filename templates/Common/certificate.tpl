{config_load file=templates.ini section="common"}
<script type="text/javascript" src="{#js_url#}product.js" ></script>
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
</script>	
<style type="text/css">	

.imgRight {
	float:right;
}
</style>	
{/literal}
<div id="bodyContent">
	<form name="add_product" method="post" action="{#script_url#}{seo_url rm="Certificate"}" >
		<input type="hidden" name="id" value="{$pdata.id}" />
		{if $cart_id != ''}
			<input type="hidden" name="cart_id" value="{$cart_id}" />
		{/if}
		{if $pdata.inactive == 1}
			<h1>This certificate is inactive</h1>
		{else}	
        	<div id="productImg">
				<img src="{#script_url#}{show_image id=$pdata.id width=width height=height param1=2}" title="<div style='background-color:#ffffff;padding:5px;'><IMG src='{#script_url#}{show_image id=$pdata.id width=tip_width height=tip_height param1=2}'/></div>" class="Tips2"/><br />
				<img src="{#img_url#}hover.jpg" border="none" style="float:left; margin-right: 5px;" /> Hover for larger image</div>
			<div id="ProductColumn">
                <h2 class="ProductNav">{$certificate_category.title}</h2>
				Categories:				
              		<a href="{#script_url#}{seo_url rm=Category param1=$certificate_category.seo_url}" >{$certificate_category.title}</a>&nbsp;
              	
              	<h1>{$pdata.name}</h1>              	
              	<p>{if $pdata.full_description != ''}{$pdata.full_description}{else}{$pdata.description}{/if}</p>            	
            	<br />
                <div class="product">			
				{* TABLE HEAD FOR PRODUCT WITHout OPTIONS*}
				<table width="100%" border="0" cellpadding="0" cellspacing="0" style="margin-bottom:5px;">
						<thead>
						<tr>
	                    	<td width="200"><strong>PRODUCTS</strong></td>
							<td width="100"><strong>PRICE</strong></td>
							<td width="200"><strong>PERSON NAME</strong></td>
							<td width="200"><strong>PERSON E-MAIL</strong></td>
	                        <td width="150">&nbsp;</td>
	                      	<td><strong>OPTIONS</strong></td>
						</tr>
						</thead>
	            </table>
				{* END OF TABLE HEAD FOR PRODUCT WITHOUT OPTIONS*}
                </div><div class="product">
	      		<table>
			      <tr>
			        <th width="200" align="left"><span class="Black">{$pdata.name}</span></th>
  					<td width="100" align="left">
  						<div id="price_div">
							{if $pdata.price > 0}{$pdata.price|money} AUD{/if}
						</div>
					</td>
					<td width="200" align="left"><input type="text" name="person_name" value="{if $cart_info.person_name}{$cart_info.person_name}{/if}" title="string___Please input person name" /></td>
					<td width="200" align="left"><input type="text" name="person_email" value="{if $cart_info.person_email}{$cart_info.person_email}{/if}" title="email___Please input person email" /></td>
			        <td width="150" align="left">			        	
	        			<input type="submit" name="save" value="Add to cart" class="buttonAdd" />
			        </td>			        
			      </tr>
			      <tr>
			      	<th>Comment</th>
			      	<td></td>
			      	<td colspan="2">
			      		<textarea name="person_comment" id="person_commentid" style="width:323px;height:200px;" >{if $cart_info.person_comment}{$cart_info.person_comment}{/if}</textarea>
			      	</td>
			      </tr>
			    </table></div>
				{if $pdata.has_options == 1}
                <div class="product">	
				  <table border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td><strong>Name</strong></td>
						<td></td>
						<td width="70"><strong>Cost</strong></td>					
						<td width="60"><strong>Quantity</strong></td>
					</tr>
					{foreach from=$pdata.options item=item key=key}
						{if $item.inactive == 0}
							<tr>
								<td nowrap="nowrap">{$item.name} </td>
								<td ><img src="{#script_url#}{show_image id=$item.id width=option_width height=option_height param1=1}" alt="{$item.name}" /></td>
 								<td>{$item.price|money} AUD</td>							
								<td><input type="text" name="quantity_option[{$key}]" value="{if $cart_info.options.$key}{$cart_info.options.$key}{elseif $request.quantity_option[$key]}{$request.quantity_option[$key]}{/if}" size="5" /></td>
							</tr>
						{/if}
					{/foreach}
				  </table></div>
				{/if}
				{if $error_message}
				<div class="required_class">{$error_message}</div>
				{/if}
			</div>				
  			
  		<div style="clear:both"></div>  		
		
	<a href="javascript: history.go(-1)" class="button">Back</a>
</form>
</div>
<script type="text/javascript">	var q = {$q};	validator.add('add_product');	</script>
{/if}
<script type="text/javascript" src="{#js_url#}product.js"></script>
<script type="text/javascript" src="{#js_url#}tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" >
{literal}

tinyMCE.init({
		// General options
		mode : "exact",
		elements: "person_commentid",
		theme : "simple",		
		// Theme options		
		toolbar_location : "top",
		toolbar_align : "left",
		statusbar_location : "bottom",		
		// Example word content CSS (should be your site CSS) this one removes paragraph margins
		//content_css : "css/word.css",

		// Drop lists for link/image/media/template dialogs
		template_external_list_url : "lists/template_list.js",
		external_link_list_url : "lists/link_list.js",
		external_image_list_url : "lists/image_list.js",
		media_external_list_url : "lists/media_list.js",
		convert_urls : false		
	});

{/literal}
</script>