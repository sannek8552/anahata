{config_load file=templates.ini section="common" scope="global"}
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>{if $seo_data.page_title}{$seo_data.page_title}{else}Bambino Rugrats{/if}</title>
	{if $seo_data.page_description}
		<meta name="description" content="{$seo_data.page_description}" />
	{/if}
	{if $seo_data.keywords}
		<meta name="keywords" content="{$seo_data.keywords}" />
	{/if}
	<link href="{#css_url#}main.css" rel="stylesheet" type="text/css" />
	<link href="{#css_url#}cart.css" rel="stylesheet" type="text/css" />
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
	<script type="text/javascript" src="{#js_url#}slimbox.js"></script>
	<script type="text/javascript" src="{#js_url#}body_blocker.js"></script>
	<script src="Scripts/AC_RunActiveContent.js" type="text/javascript"></script>
	<script src="Scripts/swfobject_modified.js" type="text/javascript"></script>
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
</head>
<body>
<div id="container">
		<div id="header">
			<div id="Login" style="padding-left:15px;padding-top:20px;float:left;" >
			{if !$logged_in}
				<form action="{#script_url#}{seo_url rm="CommonLogin"}" method="post">
					Login:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type="text" name="login" size="8" /><br />
					Password: <input type="password" name="password" size="8" /><br />
					<input type="submit" name="sign_in" value="Login" />
				</form>	
			{else}
				Welcome{if $logged_user_data.billing.name != ''}, {$logged_user_data.billing.name}{/if} <br />
				<a href="{#script_url#}{seo_url rm="Profile"}" >Your account</a><br />
                <a href="{#script_url#}{seo_url rm='MyOrders'}" id="MyOrders">Order History</a><br />
                <a href="{#script_url#}{seo_url rm='Wishlist'}" id="Wishlist">Wishlist</a><br />
				<a href="{#script_url#}{seo_url rm="Logout"}" >Logout</a><br />
			{/if}
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
<div id="main_menu">
       		  <ul class="menu2">
            		<li class="top"><a href="{#script_url#}{seo_url rm=$html_home_page.seo_url}" id="home" class="top_link"><span>{$html_home_page.title}</span></a></li>
					{if $settings.show_on_top == 1}
            		<li class="top"><a href="#" class="top_link"/><span class="down">Online Store</span>
              		<!--[if gte IE 7]><!-->	        </a>
              		<!--<![endif]-->
              		<!--[if lte IE 6]><table><tr><td><![endif]-->
                	<ul class="sub">	
                  		{foreach from=$categories item=s_item key=s_key}
                  			<li><a href="{#script_url#}{seo_url rm=Category param1=$s_item.seo_url}" {if $s_item.sub}class="fly"{/if}> {$s_item.title}
                    		{if $s_item.sub}
                    			{include file='sub_design.tpl' items=$s_item.sub}
                    		{else} </a> {/if} </li>
                  		{/foreach}
                	</ul>
              		<!--[if lte IE 6]></td></tr></table></a><![endif]-->
	                </li>
	                {/if}
            		{foreach from=$html_menus item=item key=key}
            			<li class="top"><a href="{if $item.direct_link}{$item.seo_url}{else}{#script_url#}{seo_url rm=$item.seo_url}{/if}" class="top_link"><span {if $item.sub}class="down"{else}class="top_link"{/if}>{$item.title}</span> {if $item.sub}
              				<!--[if gte IE 7]><!-->{/if}
	        			</a>
	        			{if $item.sub}<!--<![endif]-->
              			{/if}	
              			{if $item.sub}
              				<!--[if lte IE 6]><table><tr><td><![endif]-->
                		<ul class="sub">
                  			{foreach from=$item.sub item=s_item key=s_key}
                  				<li><a href="{if $s_item.direct_link}{$s_item.seo_url}{else}{#script_url#}{seo_url rm=$s_item.seo_url}{/if}" {if $s_item.sub}class="fly"{/if}> {$s_item.title}
                    			{if $s_item.sub}
                    				{include file=&quot;sub_menu.tpl&quot; items=$s_item.sub}
                    			{else} </a> {/if} </li>
                  			{/foreach}
                		</ul>
              			<!--[if lte IE 6]></td></tr></table></a><![endif]-->
            			{/if} </li>
            			{/foreach}
	          </ul>
	  		</div>
            </div> 		
<div id="main">   
	<div id="leftColumn">    
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
	     {/if}
     <a href="{#script_url#}{seo_url rm="Specials"}" style="color:#ef3c24">SALE</a>
     </div>
  <div id="content"> {if $body}
    				{include file=$body}
    			{elseif $body_as_text}
    				{$body_as_text}
  {/if}</div>
  <div id="rightColumn"> <a href="{#script_url#}{seo_url rm="NewProducts"}"><img border="none" src="{#img_url#}rightColumn/new-products.jpg" alt="New Products" width="161" height="36" /></a><br />
      <a href="{#script_url#}{seo_url rm="Wishlist"}"><img border="none" src="{#img_url#}rightColumn/wish-list.jpg" alt="Wish List" width="161" height="43" /></a><br />
      <a href="#"><img border="none" src="{#img_url#}rightColumn/gift-vouchersjpg" alt="Wish List" width="161" height="44" /></a><br />
      <a href="{#script_url#}{seo_url rm="Newsletter-Signup"}"><img border="none" src="{#img_url#}rightColumn/heart-right.jpg" width="161" height="155" /></a><br />
      <a href="{#script_url#}{seo_url rm="Profile"}"><img border="none" src="{#img_url#}rightColumn/become-member.jpg" width="161" height="95" /></a><br />
      <img border="none" src="{#img_url#}featureHeading.gif" alt="Featured Products" width="146" height="14" /><br />
      <div id="featuredSide">[featured_module?entry=1]</div>
      <br />
  </div>
</div><div id="footer">Copyright 2009 Bambinos &amp; Rugrats
    <div id="qws"></div></div>
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