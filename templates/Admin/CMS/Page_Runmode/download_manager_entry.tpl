{config_load file=templates.ini section="common" scope="global"}
<h2> Download Files for {$section_data.name|escape}</h2>
<div class="NewButton"><a href="{#script_url#}{seo_url rm="Download_Manager"}">&larr; Back</a></div><br />
<form action="{#script_url#}{seo_url param1 = $section_data.id}" method="post" name="frm" enctype="multipart/form-data">
    <fieldset name="information" id="information">
      <legend>Add File</legend>
	<table>
            <tr>
                <td>
                    File:
                </td>
                <td>
                    <input type="file" name="file"/>
                </td>
            </tr>
            <tr>
                <td valign="top">
                    Description:
                </td>
                <td>
                    <textarea name="description" >{$data.description|escape}</textarea>
                </td>
            </tr>
            <tr>
                <td>
                    Order:
                </td>
                <td>
                    <input type="text" title="integer_empty___<br/>Please enter number" name="order_no" value="{$data.order_no}" />
                </td>
            </tr>
            <tr>
                <td align="right" valign="top">
                    <input type="hidden" value="{$data.id}" name="id" />
                </td>
                <td align="left">
                    <input type="submit" value="Save" name="send" class="submit-button"/>
                </td>
            </tr>
	</table>
    </fieldset>
</form>
<div class="table-list">
    <table>
        <thead>
            <tr>
                <th scope="col" nowrap="nowrap">File name</th>
                <th scope="col" nowrap="nowrap">Content type</th>
                <th scope="col" nowrap="nowrap">Description</th>
                <th scope="col" nowrap="nowrap">Order</th>
                <th scope="col" nowrap="nowrap">Functions</th>
            </tr>
        </thead>
        {foreach from = $d_entries item = item key = key}
            <tr valign="top">
                <td nowrap="nowrap">
                    {$item.file}
                </td>
                <td valign="top">
                    {$item.content_type}
                </td>
                <td valign="top">
                    {$item.description|escape|nl2br}
                </td>
                <td valign="top" >
                    {$item.order_no}
                </td>
                <td valign="top" nowrap="nowrap">
                    <a title="Edit" href="{#script_url#}{seo_url param1 = $section_data.id param2='edit' param3 = $item.id}"><img border="none" src="{#admin_img_url#}edit.png" alt="Edit" /></a>
                    <a title="Delete" href="{#script_url#}{seo_url param1 = $section_data.id param2='delete' param3 = $item.id}" onclick="return confirm('Are you sure?');"><img border="none" src="{#admin_img_url#}cross.png" alt="Delete" /></a>
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
</div>

<script type="text/javascript">
    validator.add("frm");
</script>
