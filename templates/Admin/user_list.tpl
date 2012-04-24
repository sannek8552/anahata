{config_load file=templates.ini section="common" scope="global"}
<div class="content-container">
  <h2>User Manager</h2>
  <fieldset name="information" id="information">
<legend>User Details</legend>
	<form name="user_add" action="{#script_url#}{seo_url rm="UserList"}" method="post">
	{if $data.user_id}
		<input type="hidden" name="id" value="{$data.user_id}" />
	{/if}
	<table >
	{if $status_code}
	<tr>
		<td colspan="2" align="center">{include file="status_code.tpl"}</td>
	</tr>
	{/if}
	<tr>
		<th width="180" valign="top">General information</th>
		<td valign="top">&nbsp;</td>
		<th valign="top">Billing information</th>
		<td valign="top">&nbsp;</td>
		<th valign="top">Shipping information</th>
		<td valign="top">&nbsp;</td>
	</tr>
	<tr>
		<td align="right" valign="top"><strong>Login:</strong></td>
		<td valign="top"><input type="text" name="login" value="{$data.login}" title="string___please input login"/></td>	
		<td align="right" valign="top"><strong>Name:</strong></td>
		<td valign="top"><input type="text" name="client_name" value="{$data.billing.name}" /></td>
		<td valign="top">&nbsp;</td>
		<td valign="top"></td>
	</tr>
	<tr>
		<td align="right" valign="top"><strong>Email:</strong></td>
		<td valign="top"><input type="text" name="email" value="{$data.email}" title="email___please input correct email" /></td>
		<td align="right" valign="top"><strong>Address:</strong></td>
		<td valign="top"><input type="text" name="address" value="{$data.billing.address}" /></td>
		<td align="right" valign="top"><strong>Address:</strong></td>
		<td valign="top"><input type="text" name="shipping_address" value="{$data.shipping.address}" /></td>
	</tr>
	<tr>
		<td align="right" valign="top"><strong>Discount Points: $</strong></td>
		<td valign="top"><input type="text" name="discount_point" value="{$data.discount_point}" title="numeric_empty___please input numeric value" /></td>
		<td align="right" valign="top"><strong>Address 2:</strong></td>
		<td valign="top"><input type="text" name="address2" value="{$data.billing.address2}" /></td>
		<td align="right" valign="top"><strong>Address 2:</strong></td>
		<td valign="top"><input type="text" name="shipping_address2" value="{$data.shipping.address2}" /></td>
	</tr>
	<tr>
		<td align="right" valign="top"><strong>Password:</strong></td>
		<td valign="top"><input type="password" name="pass" {if !$data}title="string___please input password"{/if}/>
		{if $data.user_id}
		<br />
		<span style="font-size:11px; color:#FF0000;">Leave  field blank if don't wish to change password</span>
		{/if}		</td>
		
		<td align="right" valign="top"><strong>Suburb:</strong></td>
		<td valign="top"><input type="text" name="suburb" value="{$data.billing.suburb}" /></td>
		<td align="right" valign="top"><strong>Suburb:</strong></td>
		<td valign="top"><input type="text" name="shipping_suburb" value="{$data.shipping.suburb}" /></td>
	</tr>
	<tr>
		<td align="right" valign="top"><strong>Password confirmation</strong></td>
		<td valign="top"><input type="password" name="password_confirmation" {if !$data}title="string___please confirm password"{/if}/></td>
		<td align="right" valign="top"><strong>State:</strong></td>
		<td valign="top"><input type="text" name="state" value="{$data.billing.state}" /></td>
		<td align="right" valign="top"><strong>State:</strong></td>
		<td valign="top"><input type="text" name="shipping_state" value="{$data.shipping.state}" /></td>
	</tr>
	<tr>
		<td align="right" valign="top"><strong>Wholesale customer</strong></td>
		<td valign="top"><input type="checkbox" style="width:auto;"  name="wholesale" {if $data.wholesale}checked{/if} /> </td>
		<td align="right" valign="top"><strong>Postcode:</strong></td>
		<td valign="top"><input type="text" name="postcode" value="{$data.billing.postcode}" /></td>
		<td align="right" valign="top"><strong>Postcode:</strong></td>
		<td valign="top"><input type="text" name="shipping_postcode" value="{$data.shipping.postcode}" /></td>
	</tr>
	<tr>
		<td align="right" valign="top"><strong>Wholesale categories</strong><br />
        (only for <a href="{#script_url#}{seo_url rm="WholesaleManager"}" >wholesale</a> customer)</td>
		<td valign="top">
		  <select name="wholesales_ids[]" multiple >				
				{foreach from=$wholesales item=item key=key}
				<option value="{$item.id}" {if $data.wholesales[$item.id]}selected{/if} >{$item.name}   {$item.discount}%   {if $item.active}Active{else}Not active{/if}</option>
				{/foreach}
			</select>		</td>
		<td align="right" valign="top"><strong>Phone:</strong></td>
		<td valign="top"><input type="text" name="phone" value="{$data.billing.phone}" /></td>
		<td align="right" valign="top"><strong>Phone:</strong></td>
		<td valign="top"><input type="text" name="shipping_phone" value="{$data.shipping.phone}" /></td>
	</tr>	
	<tr>
		<td valign="top"></td>
		<td colspan="3" valign="top"><input type="submit" name="save" style="width:auto;" value="{if $data}Save{else}Add{/if}" class="submit-button" />		  <input type="button" name="cancel" style="width:auto;" value="Cancel" onclick="document.location='UserList.html'" class="submit-button" /></td>
		<td valign="top"></td>		
		<td valign="top"></td>
		<td></td>
	</tr>
	</table>
  </form>
  </fieldset>
  
  <fieldset name="information" id="information">
	<legend>User Search</legend>
	<form name="user_search" action="{#script_url#}{seo_url rm="UserList"}" method="post">
		<table align="center" width="100%" >
	  <tr>
				<td width="180" align="right"><strong>Users login name:</strong></td>
			  <td width="200"><input type="text" name="search_login" value="{$search.login}" /></td>
			  <td width="110" align="right"><strong>Users full name:</strong></td>
	          <td><input type="text" name="search_name" value="{$search.name}"  /></td>
	  </tr>
			
			<tr>
				<td></td>
				<td colspan="3"><input type="submit" name="search" value="Search" class="submit-button" /></td>
			</tr>
		</table>
  </form>
  </fieldset>
  <div class="table-list">
	<table align="center" width="100%" cellpadding="0" cellspacing="0">
	<tr>
		<td><strong>Login</strong></td>	
		<td><strong>Email</strong></td>
		<td><strong>Discount Points</strong></td>
		<td><strong>Wholesale customer</strong></td>
		<td><strong>Billing information</strong></td>
		<td><strong>Shipping information</strong></td>
		<td><strong>Functions</strong></td>
	</tr>
	{foreach from=$agents item=agent key=key}
	<tr {if $agent.user_id == $highlight_id}style="background-color:#aaffaa"{else}class="{cycle values="one,two"}{/if}">
		<td valign="top">{$agent.login}</td>
		<td valign="top">{$agent.email}</td>
		<td valign="top">{$agent.discount_point|money}</td>		
	  <td valign="top">
			{if $agent.wholesale}
				Yes
		  <br />
				Categories:<br />
				{foreach from=$wholesales item=item key=key}
					{if $agent.wholesales[$item.id]}
						{$item.name} {$item.discount}%  {if $item.active}Active{else} Not active{/if}<br />
					{/if}
				{/foreach}
			{else}
				No
			{/if}
		</td>
	  <td valign="top">
	  <table>
				<tr>
					<td>Name</td>
					<td>{$agent.billing.name}</td>
				</tr>
				<tr>
					<td>Address</td>
					<td>{$agent.billing.address}</td>
				</tr>
				<tr>
					<td>Address 2</td>
					<td>{$agent.billing.address2}</td>
				</tr>
				<tr>
					<td>Suburb</td>
					<td>{$agent.billing.suburb}</td>
				</tr>
				<tr>
					<td>State</td>
					<td>{$agent.billing.state}</td>
				</tr>
				<tr>
					<td>Postocode</td>
					<td>{$agent.billing.postcode}</td>
				</tr>
				<tr>
					<td>Phone</td>
					<td>{$agent.billing.phone}</td>
				</tr>				
			</table>
		</td>
		<td valign="top">
	      <table>				
				<tr>
					<td>Address</td>
					<td>{$agent.shipping.address}</td>
				</tr>
				<tr>
					<td>Address 2</td>
					<td>{$agent.shipping.address2}</td>
				</tr>
				<tr>
					<td>Suburb</td>
					<td>{$agent.shipping.suburb}</td>
				</tr>
				<tr>
					<td>State</td>
					<td>{$agent.shipping.state}</td>
				</tr>
				<tr>
					<td>Postocode</td>
					<td>{$agent.shipping.postcode}</td>
				</tr>
				<tr>
					<td>Phone</td>
					<td>{$agent.shipping.phone}</td>
				</tr>				
			</table>
		</td>
	  <td valign="top">
			<a href="{#script_url#}{seo_url rm="UserList" param1="edit" param2=$agent.user_id}"><img border="0" src="{#img_url#}picture_edit.png" alt="{$L_EDIT}" /></a> |
			<a href="{#script_url#}{seo_url rm="UserList" param1="delete" param2=$agent.user_id}" onclick="return confirm('Are you sure ?');"><img border="none" src="{#img_url#}cross.png" alt="{$L_DELETE}" /></a>		</td>
	</tr>
	{foreachelse}
	<tr>
		<td colspan="100" align="center">none users found</td>
	</tr>
	{/foreach}
	</table>
  </div>
	<script type="text/javascript">
	validator.add('user_add');
	</script>
</div>