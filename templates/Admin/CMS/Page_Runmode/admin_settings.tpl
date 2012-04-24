{config_load file=templates.ini section="common" scope="global"}
<div class="content-container">
  <h2>Admin - Settings Manager</h2> 

</div>

{foreach from=$setting_list item=section}
	<div class="form-container">
  		<form action="{#script_url#}{seo_url rm="AdminSettings"}" method="post">
    		<fieldset>
      			<legend>{$section.title}</legend>    
				<table width="900">
				{foreach from=$section.fields item=field}
			  	<tr>
					<td nowrap="nowrap" width="350"><b>{$field.alias}</b></td>
					<td>{include file='Admin/CMS/Page_Runmode/admin_settings_field.tpl' field=$field title=$section.title}</td>
				</tr>
				{/foreach}
                <tr>
                    <td></td>
                    <td><input type="submit" name="{$section.save_name}" value="Save" class="submit-button"/></td>
                </tr>
				</table>
		  </fieldset>
		</form>
	</div>
{/foreach}