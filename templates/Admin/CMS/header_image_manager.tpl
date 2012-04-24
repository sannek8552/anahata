{config_load file=templates.ini section="common" scope="global"}
<h2>Header Image Manager</h2>
<form action="{#script_url#}{seo_url}" method="post" name="frm" enctype="multipart/form-data">
    <fieldset name="information" id="information">
      <legend>Add Image</legend>
	<table>
            <tr>
                <td valign="top">
                    Title:
                </td>
                <td>
                    <input type="text" name="title" value="{$data.title|escape}" title="string___Please, enter title"/>
                </td>
            </tr>
            <tr>
                <td>
                    Image:
                </td>
                <td>
                    <input type="file" name="file"/>
                    {if $image_error}<small class="required_class">Unavaliable file type.</small>{/if}
                </td>
            </tr>
            <tr>
                <td align="right" valign="top">
                    <input type="hidden" value="{$data.id}" name="id" />
                </td>
                <td align="left">
                    <input type="submit" value="Save" name="save" class="submit-button"/>
                </td>
            </tr>
	</table>
    </fieldset>
</form>
<div class="table-list">
    <table>
        <thead>
            <tr>
                <th scope="col" nowrap="nowrap">Title</th>
                <th scope="col" nowrap="nowrap">Image</th>
                <th scope="col" nowrap="nowrap">Functions</th>
            </tr>
        </thead>
        {foreach from = $images item=item key=key}
            <tr valign="top">
                <td nowrap="nowrap">
                    {$item.title|escape}
                </td>
                <td valign="top">
                    {if $item.image}
                    <img src="{#script_url#}pictures/header/{$item.image}?c={$smarty.now}" alt="image" style="max-width:700px;"/>
                    {else}
                    No image
                    {/if}
                </td>

                <td valign="top" nowrap="nowrap">
                    <a title="Edit" href="{#script_url#}{seo_url param1='edit' param2 = $item.id}"><img border="none" src="{#admin_img_url#}edit.png" alt="Edit" /></a>
                    <a title="Delete" href="{#script_url#}{seo_url param1='delete' param2 = $item.id}" onclick="return confirm('Are you sure?');"><img border="none" src="{#admin_img_url#}cross.png" alt="Delete" /></a>
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


