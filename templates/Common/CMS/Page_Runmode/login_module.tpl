{config_load file=templates.ini section="common"}
<div style="float:right;">
{if $logged_in == 1}
	<table>
		<tr>
			<td><a href="{#script_url#}{seo_url rm="MyProfile"}">My profile</a></td>
		</tr>
		<tr>
			<td><a href="{#script_url#}{seo_url rm="MyOrders"}">My orders</a></td>
		</tr>
		<tr>
			<td><a href="{#script_url#}{seo_url rm="Logout"}">Logout</a></td>
		</tr>
	</table>
{else}	
	<form method="post" action="{#script_url#}{seo_url rm="CommonLogin"}">
	<table>
	<tr>
		<td>Login</td>
		<td><input type="text" name="login" size="8"/></td>
	</tr>
	<tr>
		<td>Password</td>
		<td><input type="password" name="password" size="8"/></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td><input type="submit" name="sign_in" value="Login"/></td>
	</tr>	
	</table>
	</form>
{/if}
</div>