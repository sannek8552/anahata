{config_load file=templates.ini section="common" scope="global"}
<form  method="post" name="form">
<fieldset name="information" id="information">
      <legend>Category Structure Information</legend>
<table border="0" cellspacing="1" cellpadding="5">
  <tr>
    <td><strong>Category Name:</strong></td>
    <td>
        <input name="name_title" type="text" id="title" value="{$menu_row.title}" size="50" title="string___Please, enter page title" /><br/>
        
    </td>
    <td><strong>Meta Description:</strong></td>
    <td rowspan="5"><textarea name="name_page_description" cols="60" rows="4" id="page_description">{$menu_row.page_description}</textarea></td>

  </tr>
  <tr>
        <td><strong>Meta Title:</strong></td>
        <td><input onchange="category_creator.populate_seo(true);" name="name_page_title" type="text" id="page_title" value="{$menu_row.page_title}" size="80" /></td>
  </tr>
  <tr>
    <td><strong>Meta Keywords:</strong></td>
    <td><input name="name_keywords" type="text" id="keywords" value="{$menu_row.keywords}" size="80" /></td>
    
  </tr>
  <tr>
      <td rowspan="2" ><strong>Seo Url:</strong></td>
    <td style="padding-bottom:0px;" valign="bottom">
    	<input name="name_seo_url" type="text" id="seo_url" value="{$menu_row.seo_url}" size="80" title="string___Please, enter page seo_url"/><br />
        <div id="bad_seo"></div>
    	 </td>
  </tr>
  <tr>

      <td style="padding-top:0px;" valign="top">
    	<a href="javascript:void(0);" onclick="category_creator.populate_seo(false);">Auto Fill from Meta Title</a>    </td>
  </tr>
  <tr>
    <td valign="top"><strong>Google Priority:</strong></td>
    <td>
        <select name="name_google_priority" id="google_priority">
            <option value="0.1">0.1</option>
            <option value="0.2" {if $menu_row.google_priority=="0.2"}selected{/if}>0.2</option>
            <option value="0.3" {if $menu_row.google_priority=="0.3"}selected{/if}>0.3</option>
            <option value="0.4" {if $menu_row.google_priority=="0.4"}selected{/if}>0.4</option>
            <option value="0.5" {if $menu_row.google_priority=="0.5"}selected{/if}>0.5</option>
            <option value="0.6" {if $menu_row.google_priority=="0.6"}selected{/if}>0.6</option>
            <option value="0.7" {if $menu_row.google_priority=="0.7"}selected{/if}>0.7</option>
            <option value="0.8" {if $menu_row.google_priority=="0.8"}selected{/if}>0.8</option>
            <option value="0.9" {if $menu_row.google_priority=="0.9"}selected{/if}>0.9</option>
            <option value="1" {if $menu_row.google_priority=="1"}selected{/if}>1</option>
        </select> <br />
        <em>To be updated with caution</em>
    </td>
    <td valign="top"><strong>Access:</strong></td>
    <td valign="top"><input name="name_access" type="text" id="access" value="" size="80" /></td>
    {*<!--<td valign="top"><strong>Header Image</strong></td>
    <td valign="top">
        <select name="name_header_image" id="header_image">
            <option value="">Default</option>
            {foreach from=$header_images key=key item=item}
            <option value="{$key}">{$item}</option>
            {/foreach}
        </select>
    </td>
  </tr>
  <tr>
    <td><strong>Template:</strong></td>
    <td>
        <select name="name_template" id="template">
            <option value="">Default</option>
            {foreach from=$templates item=item}
            <option value="{$item}" {if $menu_row.template==$item}selected{/if}>{$item}</option>
            {/foreach}
        </select>
    </td>
    <td><strong>Access:</strong></td>
    <td><input name="name_access" type="text" id="access" value="" size="80" /></td>-->*}
  </tr>
</table>
</fieldset>
<fieldset name="information" id="information">
      <legend>Category Description - HTML Editor</legend>
          <textarea rows="50" style="height:500px; width: 500px;" name="name_description" id="description">{$attribute_row.content}</textarea><br/>
          <table>
          <tr>
              <td>
                  <strong>Published:</strong>
              </td>
              <td>
                  <input style="width:20px;" type="checkbox" name="name_published" id="published" />
              </td>
              <td>
                  <strong>Active:</strong>
              </td>
              <td>
                  <input style="width:20px;" type="checkbox" name="name_active" id="active" />
              </td>
              <td id="created"></td>
              <td id="updated"></td>
          </tr>
      </table>
         
      
<br />

</fieldset>
<fieldset name="information" id="information">
<legend>Last revisions</legend>
<div id="revisions"></div>
</fieldset>
<br />

Keep open after save <input type="checkbox" name="no_need" style="width:auto;" id="keep_open" />
<input id="save"type="button" name="next_step" value="Save" class="submit-button" onclick="check_errors();"  />
<input type="button" name="preview" value="Preview" class="submit-button" onclick="category_creator.preview(false);"/>
<input type="button" name="cancel" value="Cancel" class="submit-button" onclick="category_creator.cancel();" />

<p style="clear:both"></p>
</form>
{literal}
<script type="text/javascript">
    validator.add('form',true);
    function check_errors()
    {
        if(validator.check('form'))
        {
            category_creator.save();
        }
        
    }
    
</script>
{/literal}



