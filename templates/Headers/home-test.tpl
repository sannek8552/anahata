{config_load file=templates.ini section="common" scope="global"}
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US" xmlns:fb='http://developers.facebook.com/schema/' xmlns:og='http://opengraphprotocol.org/schema/'>
<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>{if $seo_data.page_title}{$seo_data.page_title}{else}Scenar Health{/if}</title>
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
<link href="{#css_url#}home.css" rel="stylesheet" type="text/css" />
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
<!--[if IE 6]>
<style type="text/css" media="all">@import "css/ie6.css";</style>
<![endif]--> <!--[if IE 7]>
<style type="text/css" media="all">@import "css/ie7.css";</style>
<![endif]--> 
<script type="text/javascript" src="{#js_url#}jquery.min.js"></script>
<script type="text/javascript" src="{#js_url#}jqueryslidemenu.js"></script>
{* end of new jquery menu routine *}

{literal}
<div id="fb-root"></div>
<script>
  window.fbAsyncInit = function() {
    FB.init({appId: '127440070643172', status: true, cookie: true,
             xfbml: true});
  };
  
  window.addEvent('domready',function(){
	  (function() {
	    var e = document.createElement('script'); e.async = true;
	    e.src = document.location.protocol +
	      '//connect.facebook.net/en_US/all.js';
	    document.getElementById('fb-root').appendChild(e);
	  }());
	});
</script>
{/literal}

{literal}
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-18443810-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
  
  window.addEvent('domready',function(){  	  
  	//var pageTracker = _gat._getTracker("UA-2420829-1");
  });

</script>
{/literal}
{literal}
<script>
	window.addEvent('domready',function(){
 		FB.Event.subscribe('edge.create', function(href, widget) {
        //pageTracker._trackEvent('facebook','like', href);
        _gaq.push(['_trackEvent','facebook','like', href]);
    	});
	});
</script>
{/literal}
</head>
<body>
<div id="header"{if !empty($seo_data.header_image)}style="background:url('{#script_url#}pictures/header/{$seo_data.header_image}?c={$smarty.now}') no-repeat scroll 0 0;"{/if}>
<div><a href="{#script_url#}{seo_url rm="index"}" ><img src="{#img_url#}logo.gif" alt="Home" width="535" height="106" border="0" /></a></div>
</div>
	<div id="container">
		<div id="search">
<form method="post" action="{#script_url#}{seo_url rm='Search'}">
          <input name="search_string" type="text" class="Search" value="{$search_string}" />
          <input type="hidden" name="ie_hack" value="" />
          <input name="search" type="submit" class="button" value="Search" />
        </form>
        </div>
  <div id="myCart"> 
			{if $cart_items}
				<b>My Shopping Cart</b><br />
		  		Items: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {$cart_items}<br />
    			Sub Total: {$cart_total|money}<br />
				<a href="{#script_url#}{seo_url rm="Cart"}">View Cart</a> | 
				<a href="{#script_url#}{seo_url rm="RegistrationInCheckout"}" >Checkout</a>
			{/if}
   		</div>
		<div id="ll">			
			<div id="Login">
				{if $usr_logged_in}				
			  		Welcome{if $logged_user_data.billing.name != ''}, {$logged_user_data.billing.name}{/if} 
				  	<br /><br />
					<a href="{#script_url#}{seo_url rm="Profile"}" >Your Account</a> 
					<a href="{#script_url#}{seo_url rm='MyOrders'}" id="MyOrders">Order History</a>
					<a href="{#script_url#}{seo_url rm='Wishlist'}" id="Wishlist">Wishlist</a>
					<a href="{#script_url#}{seo_url rm="Logout"}" >Logout</a>
				{else}				
					<a href="{#script_url#}{seo_url rm="Login"}" >Login</a>
				{/if}
			</div>
		</div>
<div id="myslidemenu" class="jqueryslidemenu">
				<ul>
					<li class="top"><a href="{#script_url#}{seo_url rm=$html_home_page.seo_url}" id="home" class="top_link" ><span>{$html_home_page.title}</span></a></li>
					{if $settings.show_on_top == 1}				
	            		<li class="top"><a href="#" class="top_link"/><span class="down">SCENAR Products</span></a>              		
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
<div id="handsetHm"><img src="{#img_url#}hand-set.jpg" width="269" height="387" /></div>
<div class="l1">SCENAR Health <br />
<a href="{#script_url#}{seo_url rm="Customer-Support"}">Support</a></div>
<div class="l2">SCENAR Health<br />
  <a href="{#script_url#}{seo_url rm="Scenar-in-the-Media"}">Media</a> + <a href="{#script_url#}{seo_url rm="Medical-Research"}">Research</a></div>
<div class="l3">SCENAR Health<br />
<a href="{#script_url#}{seo_url rm="Links-Resources"}">Links</a> + <a href="{#script_url#}{seo_url rm="Resources"}">Resources</a></div>
<div class="social"><h4>Follow Us On</h4>
  <div align="center"><a href="http://www.facebook.com/home.php#!/pages/Scenar-Health-Australia/174345405937473" target="_blank"><img src="{#img_url#}facebookH.jpg" alt="Twitter" width="51" height="51" /></a> 
    <a href="http://twitter.com/Scenarhealth" target="_blank"><img src="{#img_url#}twitterH.jpg" alt="Twitter" width="51" height="51" /></a></div>
</div>
<h4>Subscribe to our Newsletter</h4>
[contact_module?section=12]
<div class="logos"><h4>Scenar Health</h4>
is proud to be associated with:<br />
<img src="{#img_url#}logos-lc_01.jpg" width="273" height="43" /><br />
<a href="http://www.scenarinstitute.org/main.asp" target="_blank"><img src="{#img_url#}logos-lc_02.jpg" width="273" height="74" /></a><br />
<a href="http://www.scenar.com.au" target="_blank"><img src="{#img_url#}logos-lc_03.jpg" width="273" height="91" /></a><br />
<a href="http://www.scenar.org.au/" target="_blank"><img src="{#img_url#}logos-lc_04.jpg" width="273" height="87" /></a><br />
</div>
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
				</div>
			    <div id="content">  
                <div id="ct"> </div>    
				  {if $body}
    					{include file=$body}
    				{elseif $body_as_text}
    					{$body_as_text}
				  {/if}
<h3 style="clear:both">Scenar Health Products</h3>        
<div id="hmProducts">
  					{include file='Common/top_categories.tpl'}
				</div>
<div class="hmB">
[text_module?entry=4]
  </div>
<div class="hmB"><h3>Latest News</h3><br />
[feed_reader?section=1]
</div>
</div>
</div>
	<div style="clear:both"></div>	
</div>
    <div id="footer">  
<div id="footerC"> 
<div>
<b>contact</b>
<br />
ph. 02 9913 2020
<br />
email: <a href="mailto:admin@scenarhealth.com">admin@scenarhealth.com</a></div> 
<div>    <b>sales</b>
    <br />
    ph. 02 8003 5301
    <br />
    email: <a href="mailto:sales@scenarhealth.com">sales@scenarhealth.com</a>  
    <p><b>support</b></p>
 email: <a href="mailto:support@scenarhealth.com">support@scenarhealth.com</a></div>
<div>
<b>support</b>
<br />
<a href="{#script_url#}{seo_url rm="Customer-Support"}">customer support</a> 
<br />
<a href="http://www.scenarinstitute.org/forum" target="_blank"Scenar-Forum"}">scenar forum</a> 
<br />
<a href="{#script_url#}{seo_url rm="Links-Resources"}">links and resources</a> 
<br />
<a href="{#script_url#}{seo_url rm="Medical-Research"}">medical research</a> 
<br />
<a href="{#script_url#}{seo_url rm="Scenar-in-the-Media"}">scenar in the media</a> 
<br />
<a href="{#script_url#}{seo_url rm="Frequently-Asked-Questions"}">frequently asked questions</a> 
</div> 
<div>
<b>about the treatment</b>
<br />
<a href="{#script_url#}{seo_url rm="Treatment-Overview"}">treatment overview</a> 
<br />
<a href="{#script_url#}{seo_url rm="Contact-Us"}">our clinic</a>
<br />
<a href="{#script_url#}{seo_url rm="Our-Therapists"}">our therapists</a>
</div> 
<div>    <b>medical device categories</b>
    <br />
    
<a href="{#script_url#}{seo_url rm="Category/Hand-Held-Pain-Relief-Products"}">hand held pain relief products</a>
    <br />
<a href="{#script_url#}{seo_url rm="Category/Pain-Management-Accessories"}">pain management accessories</a>
    <br />
<a href="{#script_url#}{seo_url rm="Category/Pain-Management-Therapy-Blankets"}">pain management therapy blankets</a>
    <br />
<a href="{#script_url#}{seo_url rm="Category/Pain-Management-Blanket-Accessories"}">pain management blanket accessories</a>
    <p><b>my order</b></p>
<a href="{#script_url#}{seo_url rm="Products"}">complete product catalogue</a>
</div>
</div>   
<div id="footerL"><a href="{#script_url#}{seo_url rm=$html_home_page.seo_url}"><a href="{#script_url#}{seo_url rm=$html_home_page.seo_url}">{$html_home_page.title}</span></a> {foreach from=$html_menus item=item key=key}<a href="{if $item.direct_link}{$item.seo_url}{else}{#script_url#}{seo_url rm=$item.seo_url}{/if}">{$item.title}{/foreach}</a>     
<a href="{#script_url#}{seo_url rm="Disclaimer"}">disclaimer</a> 
<a href="{#script_url#}{seo_url rm="Terms-and-Conditions"}">terms & conditions</a> 
<a href="{#script_url#}{seo_url rm="Privacy-Policy"}">privacy policy</a> 
<a href="{#script_url#}{seo_url rm="Delivery-Information"}">delivery information</a> 
<a href="{#script_url#}{seo_url rm="Warranty-and-Returns"}">warranty & returns</a>
<br /><br />
		<div id="qws">
			Copyright 2010 Scenar Health | <a href="http://quantumwebsolutions.com.au/Ecommerce-Shopping-Carts.html" target="_blank">Ecommerce Shopping Carts</a> by Quantum Web Solutions
		</div>
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
	 </div></div>
</body>
</html>