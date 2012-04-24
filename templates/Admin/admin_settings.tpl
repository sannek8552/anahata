{config_load file=templates.ini section="common" scope="global"}
<div class="content-container">
  <h2>Admin - Settings Manager</h2> 

</div>
<form action="{#script_url#}{seo_url rm="AdminSettings"}" method="post" id="setting_form_id">
<input type="text" id="all_email" /> <input id="all_email_apply_id" type="checkbox" name="all_email_apply" onclick="apply_to_all();" /> Apply to all email fields
{foreach from=$setting_list item=section}
	<div class="form-container">  		
    		<fieldset>
      			<legend>{$section.title}</legend>    
				<table width="900">
				{foreach from=$section.fields item=field}
			  		<tr>
						<td width="400" nowrap="nowrap"><b>{$field.alias}</b></td>
						<td>{include file='Admin/admin_settings_field.tpl' field=$field}</td>
					</tr>
				{/foreach}
					<tr>
						<tr>
							<td></td>
							<td><input type="submit" name="{$section.save_name}" value="Save" class="submit-button"/></td>
						</tr>
					</tr>
				</table>
		  </fieldset>		
	</div>
{/foreach}
<div>
		<input type="submit" name="save_all" value="Save all" class="submit-button" />
</div>
</form>

<script type="text/javascript">
{literal}
function apply_to_all()
{
	var check = document.getElementById('all_email_apply_id');
	var email = document.getElementById('all_email').value;
	if (check.checked)
	{
		var elem = new YAHOO.util.Element('setting_form_id');
		var elems = elem.getElementsByClassName('email_input');
		for(var i=0;i<elems.length;i++)
		{
			elems[i].value = email;
		}
	}
}
{/literal}
</script>