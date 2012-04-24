{config_load file=templates.ini section="common" scope="global"}
<div class="content-container">
<h2>{if !$edit_data}FAQ Manager - Add New{else}FAQ Manager - Edit{/if}</h2>
<div class="NewButton"><a href="{#script_url#}{seo_url rm="FAQ_Manager"}">Add New FAQ</a></div>
<form name="faq_form" action="{#script_url#}{seo_url}" method="post">
    <fieldset name="information" id="information">
      <legend>Add New FAQ Category</legend>
<table>
<tr>
	<td colspan="2"><h1>{if !$edit_data}Add New{else}Edit{/if} FAQ Section</h1></td>
</tr>
<tr>
	<td>
	  <strong>Enter name      </strong></td>
	<td>
		<input name="section_name" type="text" title="string___Enter name" value="{$edit_data.name}" size="50" />
	</td>
</tr>
<tr>
	<td>
	  <strong>User questions      </strong></td>
	<td>
		<input style="width:auto;" name="user_questions" type="checkbox" {if $edit_data.user_questions} checked {/if} />
	</td>
</tr>
<tr>
	<td>&nbsp;{if $edit_data}<input type="hidden" name="id" value="{$edit_data.id}">{/if}</td>
	<td><input type="submit" name="save" value="Save" class="submit-button"/></td>
</tr>
</table>
</fieldset>
</form>
<script type="text/javascript">
validator.add('faq_form');
</script>

{*faq sections list here*}
<div class="table-list">
<table>
      <thead>
        <tr>
          <th scope="col" nowrap="nowrap">Insert Code</th>
          <th scope="col" nowrap="nowrap">Name</th>
          <th scope="col" nowrap="nowrap">Entries</th>
          <th scope="col" nowrap="nowrap" width="90">User Questions</th>
          <th scope="col" nowrap="nowrap">Funtions</th>
        </tr>
{foreach from=$sections item=item key=key}
<tr>
	<td> [faq_module?section={$item.id}]</td>
	<td>{$item.name}</td>
	<td><a href="{#script_url#}{seo_url rm="FAQ_Manager_Entry" param1=$item.id}">{$item.enties_num}</a></td>
        <td width="150">
        {if $item.user_questions}Active{else}Blocked{/if} 
            <a href="{#script_url#}{seo_url rm = FAQ_Manager_User_Entry param1 = $item.id}">{$c_mass[$item.id].count}</a>
        </td>
	<td><a title="Edit" href="{#script_url#}{seo_url param1="edit" param2=$item.id}"><img border="none" src="{#admin_img_url#}edit.png" alt="Edit" /></a>
	<a title="Manage Entries" href="{#script_url#}{seo_url rm="FAQ_Manager_Entry" param1=$item.id}"><img border="none" src="{#admin_img_url#}detail.png" alt="Manage Entries" /></a>
	<a title="Delete" href="{#script_url#}{seo_url param1="delete" param2=$item.id}" onclick="return confirm('Are you sure?');"><img border="none" src="{#admin_img_url#}cross.png" alt="Delete" /></a>	
        
        </td>
</tr>
{/foreach}
<tfoot>
<tr>
	<td colspan="100">
</td>
</tr>
</tfoot>
</table>
</div></div>
{*end of faq sections list*}