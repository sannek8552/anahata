{config_load file=templates.ini section="common" scope="global"}
<h2>Add News Section</h2>
<form action="{#script_url#}{seo_url}" method="post" name="frm">
    <fieldset name="information" id="information">
      <legend>Add Testimonial Section</legend>
	<table>
            <tr>
                <td align="right">
                    Name
                </td>
                <td align="left">
                    <input title="string___Please enter name" type="text" value="{$data.name|escape}" name="name"/>
                </td>
            </tr>
            <tr>
                <td align="right">
                    Items per page
                </td>
                <td align="left">
                    <input title="number___Please enter number" type="text" value="{$data.items_per_page|escape}" name="items_per_page" />
                </td>
            </tr>
            <tr>
                <td align="right">
                    Seo all testimonials
                </td>
                <td align="left">
                    <input title="string___Please enter number" type="text" value="{$data.seo_page|escape}" name="seo_page" />
                </td>
            </tr>
            <tr>
                <td align="right">
                    Timer
                </td>
                <td align="left">
                    <input title="number___Please enter number" type="text" value="{$data.timer|escape}" name="timer" />
                </td>
            </tr>
            <tr>
                <td align="right">
                    Description
                </td>
                <td align="left">
                    <textarea cols="40" rows="10" name="description">{$data.description}</textarea>
                </td>
            </tr>
            <tr>
                <td align="right">
                    <input type="hidden" name="id" value="{$data.id}" />
                </td>
                <td align="left">
                    <input type="submit" value="save" name="send" class="submit-button"/>
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
              <th scope="col" nowrap="nowrap">Insert Code</th>
              <th scope="col" nowrap="nowrap">Name</th>
              <th scope="col" nowrap="nowrap">Description</th>
              <th scope="col" nowrap="nowrap">On page</th>
              <th scope="col" nowrap="nowrap">Seo url</th>
              <th scope="col" nowrap="nowrap">Timer</th>
              <th scope="col" nowrap="nowrap">Functions</th>
          </thead>
        {foreach from=$testimonials item=item key=key}
            <tr valign="top">
                <td>
                    <p>[testimonial_module?section={$item.id}]</p>
                    <p style="color:#FF0000;"><em>to show all testimonials on your page, your snippet will be:</em></p>
                    <p>[testimonial_module?section={$item.id}&amp;all_testimonials=1]</p>
                </td>
                <td>{$item.name|escape}</td>
                <td>{$item.description|escape|nl2br}</td>
                <td>{$item.items_per_page}</td>
                <td>{$item.seo_page|escape}</td>
                <td>{$item.timer|escape}</td>
                <td nowrap="nowrap">
                    <a title="Edit" href="{#script_url#}{seo_url param1 = 'edit' param2 = $item.id}"><img border="none" src="{#admin_img_url#}edit.png" alt="Edit" /></a>
                    <a title="Manage Entries" href="{#script_url#}{seo_url rm = Testimonial_Manager_Entry param1 = $item.id}"><img border="none" src="{#admin_img_url#}detail.png" alt="Manage Entries" /></a>
                    <a title="Delete" href="{#script_url#}{seo_url param1 = 'delete' param2 = $item.id}" onclick="return confirm('All testimonial in this directory will delete. Are you sure?');"><img border="none" src="{#admin_img_url#}cross.png" alt="Delete" /></a>
                </td>
            </tr>
        {/foreach}
        <tfoot>
            <tr>
                <td colspan="100">
                    &nbsp;
                </td>
            </tr>
        </tfoot>
    </table>
</div>