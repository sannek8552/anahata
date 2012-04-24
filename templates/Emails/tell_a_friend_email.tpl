{config_load file=templates.ini section="common" scope="global"}

Hi, {$data.friend_name} .<br /><br />

{if $product}	
	{* TELL ABOUT PRODUCT *}
	
	{$data.friend_comment|nl2br}<br /><br />
		
	Check <a href="{#full_url#}{seo_url rm=Product param1=$product.seo}" >{#full_url#}{seo_url rm=Product param1=$product.seo}</a> product.
		
	{* END OF TELL ABOUT PRODUCT *}	
{else}
	{* TELL ABOUT SITE *}
	
	{$data.friend_comment|nl2br}<br /><br />
	
	{if $my_user_id}
		Check <a href="{#full_url#}" >{$site_name}</a> site.
	{else}
		Check <a href="{#full_url#}?user_id={$my_user_id}" >{$site_name}</a> site.
	{/if}
	
	{* END OF TELL ABOUT SITE *}
{/if}
<br /><br />

{if $my_user_id}
<a href="{#full_url#}?user_id={$my_user_id}" >Visit site</a>
{/if}