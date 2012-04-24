{config_load file=templates.ini section="common" scope="global"}
 {literal}
<style type="text/css">
body,td,th, a {
	font: Arial;
	font-size: 12px;
	color:#FFFFFF;
}
-->
</style>
{/literal}
  {if $user.text_type == 1}
		To unsubscribe to this e-mail go to: {#domain_name#}{#script_url#}?rm=nl_unsubscribe&id={$user.user_id}&key={$user_key}
  {else} 
  	<br />
  	<div align="center">
  		<a href="{#domain_name#}{#script_url#}?rm=nl_unsubscribe&id={$user.user_id}&key={$user_key}">Click here to unsubscribe</a>
  	</div>	
  {/if}  