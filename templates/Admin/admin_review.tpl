{config_load file=templates.ini section="common"}
<script type="text/javascript">
	function deleteReview()
	{literal}
	{
		if(confirm('Are you shure you want to delete checked reviews?')) 
		{
			document.getElementById('actionType').value='DeleteChecked';
			document.getElementById('Actions').submit();
		}
	}
	{/literal}
</script>

<h2>Product Reviews Manager</h2>
<div class="table-list">
<form name="payment" action="{#script_url#}{seo_url rm="AdminReview"}" method="post" >
    <fieldset name="information" id="information">  
    	<legend>Filter Results by Product</legend>
<div >  
      			<select name="product_id" >
      				<option value="" >All products</option>
      				{foreach from=$products item=item key=key}
      				<option value="{$item.id}" {if $cur_product_id == $item.id}selected{/if} >{$item.name}</option>
      				{/foreach}
      			</select>
      			&nbsp;<input type="submit" name="save" class="submit-button" value="Filter" />
	  		</div>
			
    </fieldset>
</form>
    <fieldset name="information" id="information">  
    	<legend>Products Reviewed or Pending Review</legend>
<form id="Actions" action="{#script_url#}{seo_url rm="AdminReview" param1="DoChecked"}" method="post">    	
<table>
	<thead>
		<tr>
		  <th scope="col" nowrap="nowrap">Product name</th>
		  <th scope="col" nowrap="nowrap">User name</th>
		  <th scope="col" nowrap="nowrap">Review</th>
		  <th scope="col" nowrap="nowrap">Date</th>
		  <th scope="col" nowrap="nowrap">Status</th>
		  <th scope="col" nowrap="nowrap">Check</th>
		  <th scope="col" nowrap="nowrap">Functions</th>		  
		</tr>
	</thead>
	
	{foreach from=$reviews item=item key=key}
	<tr>
		<td><a href="{#script_url#}{seo_url rm="AdminProduct" param1="edit" param2=$item.product_id}">{$products[$item.product_id].name}</a></td>
		<td>{$item.name} {if $item.user_id}(<a href="{#script_url#}{seo_url rm="UserList" param1="edit" param2=$item.user_id}">registered user</a>){/if}</td>
		<td>{$item.comment}</td>
		<td>{$item.created|date_output:"d.m.Y H:i:s"}</td>
		<td>
			{if $item.approved}<span class="green" >Approved</span>{else}<span class="red" >Not approved</span>{/if}		</td>
		<td><input type="checkbox" id="check{$item.id}" name="check{$item.id}" style="width:10px;" /></td>
		<td>
			{if $item.approved}<a href="{#script_url#}{seo_url rm="AdminReview" param1="Unapprove" param2=$item.id}" ><img border="none" src="{#img_url#}admin/unapprove.jpg" alt="Unapprove" /></a>{else}<a href="{#script_url#}{seo_url rm="AdminReview" param1="Approve" param2=$item.id}" ><img border="none" src="{#img_url#}admin/approve.jpg" alt="Approve" /></a>{/if} | <a href="{#script_url#}{seo_url rm="AdminReview" param1="Delete" param2=$item.id}" onclick="return confirm('Are you sure ?');" ><img border="none" src="{#img_url#}cross.png" alt="{$L_DELETE}" /></a>		</td>
	</tr>
	{/foreach}
	<tr>
		<td colspan="5" >
			<strong>Bulk Actions: </strong>With all checked:
			<input type="hidden" name="actionType" id="actionType" value="" />
			<a href="javascript:void(0)" onclick="document.getElementById('actionType').value='ApproveChecked'; document.getElementById('Actions').submit();return false;" >Approve</a> |   
			<a href="javascript:void(0)" onclick="document.getElementById('actionType').value='UnapproveChecked'; document.getElementById('Actions').submit();return false;" >Unapprove</a> |   
			<a href="javascript:void(0)" onclick=" return deleteReview();" >Delete</a>		</td>
		<td ><input type="checkbox" id="checkAll" name="checkAll" style="width:10px; " onclick="{foreach from=$reviews item=item key=key}document.getElementById('check{$item.id}').checked=document.getElementById('checkAll').checked;{/foreach}"/></td>
		<td>
					</td>
  	</tr>
	<tfoot>
	<tr>
		<td colspan="100">
			Pages:&nbsp;
			{foreach from=$page_array item=item key=key}
			{if $item == $page}<b>{$item}</b>
			{else}
			<a href="{#script_url#}{seo_url rm="AdminReview" param1="Page" param2=$item}">{$item}</a>
			{/if}
			{/foreach}		</td>
	</tr>
</tfoot>
</table>
</form>
</fieldset>
</div>
