{config_load file=templates.ini section="common" scope="global"}
<div class="content-container">
<h2>Referrals</h2>
	<fieldset name="information" id="information">
    	<legend>List of referrals</legend>
    	<div class="table-list" >
    	{if $coupon_sent}
    	<span style="color:blue;" >Coupon was sent successfully.</span>
    	{/if}
    	<form action="{#script_url#}{seo_url}" method="post" >
			<table>
	      		<thead>
	        		<tr>
	          			<th scope="col" nowrap="nowrap">User</th>
	          			<th scope="col" nowrap="nowrap">Count of referrals</th>
	          			<th scope="col" nowrap="nowrap">Total payments from referrals</th>
	          			<th scope="col" nowrap="nowrap">Actions</th>
					</tr>
				</thead>
				{foreach from=$referral_users item=item}
				<tr>
					<td>{$item.login}</td>
					<td>{$item.referrals_count}</td>
					<td>{$item.referrals_total|money}</td>
					<td><input type="checkbox" name="send[{$item.user_id}]" value="{$item.user_id}" /></td>
				</tr>
				{/foreach}
				<tr>
					<td colspan="3">&nbsp;</td>
					<td>Select coupon</td>
				</tr>
				<tr>
					<td colspan="3"></td>
					<td>
						<select name="coupon_id" >
						{foreach from=$coupons item=item}
							<option value="{$item.id}" >{$item.name}</option>
						{/foreach}
						</select>
						<input type="submit" name="save" value="Send to checked" />
					</td>
				</tr>
			</table>
		</form>
		</div>
	</fieldset>
</div>