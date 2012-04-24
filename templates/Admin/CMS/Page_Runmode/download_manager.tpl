{config_load file=templates.ini section="common" scope="global"}
<h2>Download Manager</h2>
<form action="{#script_url#}{seo_url}" method="post" name="frm">
    <fieldset name="information" id="information">
      <legend>Add Download Category</legend>
	<table>
            <tr>
                <td align="right"><strong>
                  Name
            </strong></td>
                <td align="left">
                    <input title="string___Please enter name" type="text" value="{$data.name}" name="name"/>
                </td>
            </tr>
            <tr>
                <td align="right"><strong>
                  Public
            </strong></td>
                <td align="left">
                    <input type="checkbox" style="width:auto" name="public" {if $data.public}checked{/if} />
                </td>
            </tr>
            <tr>
                <td align="right">
                    <input type="hidden" name="id" value="{$data.id}" />
                </td>
                <td align="left">
                    <input type="submit" value="Save" name="send" class="submit-button"/>
                </td>
            </tr>
	</table>
    </fieldset>
</form>

<script type="text/javascript">
    validator.add('frm');
</script>
<div class="table-list">
    <table>
          <thead>
            <tr>
              <th scope="col" nowrap="nowrap">Insert Code Snippet</th>
              <th scope="col" nowrap="nowrap">Download Category Name</th>
              <th scope="col" nowrap="nowrap">Public Access</th>
              <th scope="col" nowrap="nowrap">Functions</th>
            </tr>
          </thead>
        {foreach from=$sections item=item key=key}
            <tr valign="top">
                <td>
                    <p>[download_module?section={$item.id}]</p>
                </td>
                <td>{$item.name|escape}</td>
                <td>{if $item.public}Public{else}Private{/if}</td>
                <td nowrap="nowrap">
                    <a title="Edit" href="{#script_url#}{seo_url param1 = 'edit' param2 = $item.id}"><img border="none" src="{#admin_img_url#}edit.png" alt="Edit" /></a>
                    <a title="Manage Entries" href="{#script_url#}{seo_url rm = Download_Manager_Entry param1 = $item.id}"><img border="none" src="{#admin_img_url#}detail.png" alt="Manage Entries" /></a>
                    <a title="Delete" href="{#script_url#}{seo_url param1 = 'delete' param2 = $item.id}" onclick="return confirm('All files in this section will be deleted. Are you sure?');"><img border="none" src="{#admin_img_url#}cross.png" alt="Delete" /></a>
                </td>
            </tr>
        {/foreach}
        <tfoot>
            <tr>
                <td colspan="100">&nbsp;
                    
                </td>
            </tr>
        </tfoot>
    </table>
</div>