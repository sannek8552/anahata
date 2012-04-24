{config_load file=templates.ini section="common" scope="global"}
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>{if $seo_data.page_title}{$seo_data.page_title}{else}Perfumery{/if}</title>
{if $seo_data.page_description}<meta name="description" content="{$seo_data.page_description}" />{/if}
{if $seo_data.keywords}<meta name="keywords" content="{$seo_data.keywords}" />{/if}

{if $isMobile}
	{* this section to include stylesheets for mobile devices *}
<link href="{#css_url#}main.css" rel="stylesheet" type="text/css" />
<link href="{#css_url#}style.css" rel="stylesheet" type="text/css" />
<link href="{#css_url#}cart.css" rel="stylesheet" type="text/css" />
	
	{* end of this section to include stylesheets for mobile devices *}
{else}
<link href="{#css_url#}main.css" rel="stylesheet" type="text/css" />
<link href="{#css_url#}style.css" rel="stylesheet" type="text/css" />
<link href="{#css_url#}cart.css" rel="stylesheet" type="text/css" />
{/if}



<link rel="stylesheet" href="{#css_url#}slimbox.css" type="text/css" media="screen" />
<script type="text/javascript">
        var script_url = '{#script_url#}';
        var images_prefix = '{#img_url#}';
        var ajax_prefix = '{#script_url#}';
        var common_prefix = '{#common_url#}';        
</script>
<script type="text/javascript" src="{#js_url#}validator_o.js"></script>
<script type="text/javascript" src="{#js_url#}AJAX.js"></script>
<script type="text/javascript" src="{#js_url#}mootools.v1.11.js"></script>
<script type="text/javascript" src="{#js_url#}slimbox_module.js"></script>
<script type="text/javascript" src="{#js_url#}body_blocker.js"></script>
<script type="text/javascript">        
    {literal}        
        window.addEvent('domready',function()
                        {
                            init_additional();
                            {/literal}{$text_to_init}{literal}
                        });
        {/literal}        
    </script>
{literal}
<script type="text/javascript">
    function init_additional()
    {
        
        
        
        
    }
    </script>
{/literal}

{* new jquery menu routine *}
<link rel="stylesheet" type="text/css" href="{#css_url#}jqueryslidemenu.css" />
{literal}
<!--[if lte IE 7]>
<style type="text/css">
html .jqueryslidemenu{height: 1%;} /*Holly Hack for IE7 and below*/
</style>
<![endif]-->
{/literal}
<script type="text/javascript" src="{#js_url#}jquery.min.js"></script>
<script type="text/javascript" src="{#js_url#}jqueryslidemenu.js"></script>
{* end of new jquery menu routine *}

{if $isMobile}
{* section to place some tags for mobile devices *}



{* end of section to place some tags for mobile devices *}
{/if}

</head>
</head>
<body>
<div id="container">
<div id="ll">{if !$logged_in}<a href="{#script_url#}{seo_url rm="Logout"}" >Logout</a>{else}<a href="{#script_url#}{seo_url rm="Login"}" >Login</a>{/if}</div>
<div id="header"{if !empty($seo_data.header_image)}style="background:url('{#script_url#}pictures/header/{$seo_data.header_image}?c={$smarty.now}') no-repeat scroll 0 0;"{/if}>
          
			<div id="Login">
			{if !$logged_in}
				{else}
			  Welcome{if $logged_user_data.billing.name != ''}, {$logged_user_data.billing.name}{/if} <br /><br />
				<a href="{#script_url#}{seo_url rm="Profile"}" >Your Account</a> <a href="{#script_url#}{seo_url rm='MyOrders'}" id="MyOrders">Order History</a> <a href="{#script_url#}{seo_url rm='Wishlist'}" id="Wishlist">Wishlist</a><a href="{#script_url#}{seo_url rm="Logout"}" >Logout</a>{/if}
			</div>

	  <div id="myCart"> 

				{if $cart_items}
				<b>My Shopping Cart</b><br />
    		  		Items: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$cart_items}<br />
	    			Sub Total: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$cart_total|money}<br />
    				<a href="{#script_url#}{seo_url rm="Cart"}">View Cart</a> | 
    				<a href="{#script_url#}{seo_url rm="RegistrationInCheckout"}" >Checkout</a>
    			{/if}
    		</div>   
            </div> 	
<div id="myslidemenu" class="jqueryslidemenu">
				<ul>
					<li class="top"><a href="{#script_url#}{seo_url rm=$html_home_page.seo_url}" id="home" class="top_link" ><span>{$html_home_page.title}</span></a></li>
					{if $settings.show_on_top == 1}				
	            		<li class="top"><a href="#" class="top_link"/><span class="down">Products</span></a>              		
		                	<ul class="sub">
		                  		{foreach from=$categories item=s_item key=s_key}    
		                  			<li>
		                  				<a href="{#script_url#}{seo_url rm=Category param1=$s_item.seo_url}" {if $s_item.sub}class="fly"{/if}>{$s_item.title}</a>
			                    		{if $s_item.sub}
			                    			{include file='sub_design.tpl' items=$s_item.sub}
			                    		{/if}
		                    		</li>
		                  		{/foreach}
		                	</ul>
		                </li>
		            {/if}
					{foreach from=$html_menus item=item key=key name="menu_for"}
			  <li class="{if !$smarty.foreach.menu_for.last}top{else}menuEnd{/if}" ><a href="{if $item.direct_link}{$item.seo_url}{else}{#script_url#}{seo_url rm=$item.seo_url}{/if}" class="top_link"><span {if $item.sub}class="down"{else}class="top_link"{/if}>{$item.title}</span></a>
		        		{if $item.sub}	        
		        			<ul class="sub">
		          			{foreach from=$item.sub item=s_item key=s_key}	          
		          				<li>
		          					<a href="{if $s_item.direct_link}{$s_item.seo_url}{else}{#script_url#}{seo_url rm=$s_item.seo_url}{/if}" {if $s_item.sub}class="fly"{/if}>{$s_item.title}</a>
			            			{if $s_item.sub}
			            				{include file="sub_menu.tpl" items=$s_item.sub}	            			
			            			{/if}
		          				</li>
		          			{/foreach}
		        			</ul>	        
		        		{/if}
		        		</li>
		        	{/foreach}	
				</ul>
				<br style="clear: left" />
			</div>
<div id="main">   
	<div id="leftColumn"> 
    <h3>Alphabet Search</h3>  
<table width="100%" table border="0" align="center" cellpadding="2">
<tr>
<td><div align="center"><a href="{#script_url#}{seo_url rm=Products param1=search param2=A}">A</a></div></td>
<td><div align="center"><a href="{#script_url#}{seo_url rm=Products param1=search param2=B}">B</a></div></td>
<td><div align="center"><a href="{#script_url#}{seo_url rm=Products param1=search param2=C}">C</a></div></td>
<td><div align="center"><a href="{#script_url#}{seo_url rm=Products param1=search param2=D}">D</a></div></td>
<td><div align="center"><a href="{#script_url#}{seo_url rm=Products param1=search param2=E}">E</a></div></td>
<td><div align="center"><a href="{#script_url#}{seo_url rm=Products param1=search param2=F}">F</a></div></td>
</tr><tr>
<td><div align="center"><a href="{#script_url#}{seo_url rm=Products param1=search param2=G}">G</a></div></td>

<td><div align="center"><a href="{#script_url#}{seo_url rm=Products param1=search param2=H}">H</a></div></td>
<td><div align="center"><a href="{#script_url#}{seo_url rm=Products param1=search param2=I}">I</a></div></td>
<td><div align="center"><a href="{#script_url#}{seo_url rm=Products param1=search param2=J}">J</a></div></td>
<td><div align="center"><a href="{#script_url#}{seo_url rm=Products param1=search param2=K}">K</a></div></td>
<td><div align="center"><a href="{#script_url#}{seo_url rm=Products param1=search param2=L}">L</a></div></td>
</tr><tr>
<td><div align="center"><a href="{#script_url#}{seo_url rm=Products param1=search param2=M}">M</a></div></td>
<td><div align="center"><a href="{#script_url#}{seo_url rm=Products param1=search param2=N}">N</a></div></td>
<td><div align="center"><a href="{#script_url#}{seo_url rm=Products param1=search param2=O}">O</a></div></td>

<td><div align="center"><a href="{#script_url#}{seo_url rm=Products param1=search param2=P}">P</a></div></td>
<td><div align="center"><a href="{#script_url#}{seo_url rm=Products param1=search param2=Q}">Q</a></div></td>
<td><div align="center"><a href="{#script_url#}{seo_url rm=Products param1=search param2=R}">R</a></div></td>
</tr><tr>
<td><div align="center"><a href="{#script_url#}{seo_url rm=Products param1=search param2=S}">S</a></div></td>
<td><div align="center"><a href="{#script_url#}{seo_url rm=Products param1=search param2=T}">T</a></div></td>
<td><div align="center"><a href="{#script_url#}{seo_url rm=Products param1=search param2=U}">U</a></div></td>
<td><div align="center"><a href="{#script_url#}{seo_url rm=Products param1=search param2=V}">V</a></div></td>
<td><div align="center"><a href="{#script_url#}{seo_url rm=Products param1=search param2=W}">W</a></div></td>

<td><div align="center"><a href="{#script_url#}{seo_url rm=Products param1=search param2=X}">X</a></div></td>
</tr><tr>
<td><div align="center"><a href="{#script_url#}{seo_url rm=Products param1=search param2=Y}">Y</a></div></td>
<td><div align="center"><a href="{#script_url#}{seo_url rm=Products param1=search param2=Z}">Z</a></div></td>
<td><div align="center"><a href="{#script_url#}{seo_url rm=Products param1=search param2=1}">1</a></div></td>
<td><div align="center"><a href="{#script_url#}{seo_url rm=Products param1=search param2=2}">2</a></div></td>
<td><div align="center"><a href="{#script_url#}{seo_url rm=Products param1=search param2=3}">3</a></div></td>
<td><div align="center"><a href="{#script_url#}{seo_url rm=Products param1=search param2=4}">4</a></div></td>
</tr><tr>
<td><div align="center"><a href="{#script_url#}{seo_url rm=Products param1=search param2=5}">5</a></div></td>

<td><div align="center"><a href="{#script_url#}{seo_url rm=Products param1=search param2=6}">6</a></div></td>
<td><div align="center"><a href="{#script_url#}{seo_url rm=Products param1=search param2=7}">7</a></div></td>
<td><div align="center"><a href="{#script_url#}{seo_url rm=Products param1=search param2=8}">8</a></div></td>
<td><div align="center"><a href="{#script_url#}{seo_url rm=Products param1=search param2=9}">9</a></div></td>
<td><div align="center"><a href="{#script_url#}{seo_url rm=Products param1=search param2=0}">0</a></div></td>
</tr>
</table>
    <h3>Fragrance Type Search</h3>
    <form action="{#script_url#}{seo_url rm=Fragrance}" method="post" id="fragrance_form">
        <select name="fragrance_seo" id="fragrance_select_id" onchange="{literal}$('fragrance_form').action='{/literal}{#script_url#}Fragrance/{literal}' + $('fragrance_select_id').value + {/literal}'.html';{literal}$('fragrance_form').submit();{/literal}">
            <option value="">Select...</option>
            {foreach from=$fragrance_types item=item key=key}
                    <option value="{$item.seo_url}" {if $current_fragrance == $key}selected="selected"{/if} >{$item.title}</option>
            {/foreach}
        </select>
    </form>
    <h3>Brand Search</h3>
          		<form action="{#script_url#}{seo_url rm="Brands"}" method="post" id="brand_form">
	   	            <select name="brand_seo" id="select" onchange="{literal}$('brand_form').action='{/literal}{#script_url#}Brands/{literal}' + $('select').value + {/literal}'.html';{literal}$('brand_form').submit();{/literal}">
	     	        		<option value="">All Brands</option>
	     	        		{foreach from=$brands item=item key=key}    
	     	        			<option value="{$item.seo_url}" {if $current_brand_seo == $item.seo_url}selected{/if} >{$item.title}</option>
	     	        		{/foreach}
	            	</select>
   	         	</form>
    <h3>Gift Certificates</h3>
    <a href="{#script_url#}{seo_url rm="Category/Certificates"}" ><img src="{#img_url#}gift-certificates.jpg" alt="Gift Certificates" width="130" height="122" /></a>
<h3>Featured</h3>
[featured_module?entry=5]
	 {if $settings.show_on_left == 1}
	    {foreach from=$categories item=category key=key}
	       	<a href="{#script_url#}{seo_url rm="Category" param1=$category.seo_url}" >{$category.title}</a><br />
    		{if $open_parent && $open_parent == $category.id && $childs}
    			<div class="sub_category_div" >
		          	{foreach from=$childs item=child}
		          		<a href="{#script_url#}{seo_url rm="Category" param1=$child.seo_url}" >{$child.title}</a><br />
		          	{/foreach}
	          	</div>
   			 {/if}
	     {/foreach}
	     {/if}     </div>
  <div id="content"> {if $body}
    				{include file=$body}
    			{elseif $body_as_text}
    				{$body_as_text}
  {/if}
<h3 class="centre">Featured Products</h3>
[featured_module?entry=1]
  </div>
<div id="rightColumn">  
<h3>Search</h3>  
<div id="search"><form action="{#script_url#}{seo_url rm="Search"}" method="post" >
      		<input type="text" name="search_value" value="{$search_value}" />
      		<input type="submit" name="search_single" value="Search" class="button" />
          </form></div>
	[banner_module?banner=1]
  <br clear="all" />
  </div>
<div id="footer">         
<a href="{#script_url#}{seo_url rm=$html_home_page.seo_url}"><a href="{#script_url#}{seo_url rm=$html_home_page.seo_url}">{$html_home_page.title}</span></a> | {if $settings.show_on_top == 1} </a>{/if}{foreach from=$html_menus item=item key=key}<a href="{if $item.direct_link}{$item.seo_url}{else}{#script_url#}{seo_url rm=$item.seo_url}{/if}" class="top_link">{$item.title} {if $item.sub}{/if}</a> | {if $item.sub}{/if}	{if $item.sub} {foreach from=$item.sub item=s_item key=s_key}
    <a href="{if $s_item.direct_link}{$s_item.seo_url}{else}{#script_url#}{seo_url rm=$s_item.seo_url}{/if}" {if $s_item.sub}class="fly"{/if}> {$s_item.title} {if $s_item.sub}{include file=&quot;sub_menu.tpl&quot; items=$s_item.sub}{else} </a> | {/if} {/foreach}{/if}{/foreach}<br /><br />
<div id="qws"><a href="http://quantumwebsolutions.com.au/Ecommerce-Shopping-Carts.html" target="_blank">Ecommerce Shopping Carts</a> by Quantum Web Solutions</div>
Copyright 2011 Perfumery</div>
{if $debug_info}
   	TOTAL TIME:
   	{$debug_info.total_time}
<br/>
    	PHP TIME:
	    	{$debug_info.php_time}
	    	<br/>
	    	SQL TIME:
	    	{$debug_info.sql_time}
	    	<br/>
	    	SQL COUNT:
	    	{$debug_info.sql_count}
	    	{/if}
{literal}
{/literal}
</div>
</body>
</html>