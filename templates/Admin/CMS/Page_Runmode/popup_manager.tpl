{config_load file=templates.ini section="common" scope="global"}
<h2>Popup Page Manager</h2>
<div class="content-container">
    <form action="{#script_url#}{seo_url}" name="frm" method="post">
        <fieldset name="information" id="information">
            <legend>Enter Parameters</legend>
        
            <table>
                <tr>
                    <td>
                        <strong>Seo:</strong>
                    </td>
                    <td>
                        <input type="text" name="page_seo" value="{$data.page_seo|escape}" title="string___<br/>Please enter seo" />
                    </td>
                </tr>
                <tr>
                    <td>
                        <strong>Link text:</strong>
                    </td>
                    <td>
                        <input type="text" name="link_text" value="{$data.link_text|escape}" title="string___<br/>Please enter text"/>
                    </td>
                </tr>
                <tr>
                    <td>
                        <strong>Width:</strong>
                    </td>
                    <td>
                        <input type="text" name="width" value="{$data.width|escape}" title="integer_empty___<br/>Please enter numeric value"/>
                    </td>
                </tr>
                <tr>
                    <td>
                        <strong>Height:</strong>
                    </td>
                    <td>
                        <input type="text" name="height" value="{$data.height|escape}" title="integer_empty___<br/>Please enter numeric value"/>
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="hidden" name="id" value="{$data.id}" />
                    </td>
                    <td>
                        <input type="submit" name="send" value="Save" /> {if $data.id}<input type="submit" name="cancel" value="Cancel" />{/if}
                    </td>
                </tr>
            </table>
        </fieldset>
    </form>
</div>

<div class="table-list">
    <table>
        <thead>
            <tr>
                <th scope="col" nowrap="nowrap">Code</th>
                <th>Seo</th>
                <th>Link text</th>
                <th >Height</th>
                <th >Width</th>
                <th scope="col" nowrap="nowrap">Funcions</th>
            </tr>
        </thead>
        {foreach from = $popups item = item key = key}
            <tr>
                <td>
                    {*<b>[popup_module?seo={$item.page_seo|escape}{if $item.width}&page_width={$item.width}{/if}{if $item.height}&page_height={$item.height}{/if}&link_text={$item.link_text|escape}]</b>*}
                    [popup_module?section={$item.id|escape}]
                </td>
                <td>
                    {$item.page_seo|escape}
                </td>
                <td>
                    {$item.link_text|escape}
                </td>
                <td >
                    {$item.height|escape}
                </td>
                <td >
                    {$item.width|escape}
                </td>
                <td>
                    <a title="Edit" href="{#script_url#}{seo_url param1 = 'edit' param2 = $item.id}"><img border="none" src="{#admin_img_url#}edit.png" alt="Edit" /></a>
                    <a title="Delete" href="{#script_url#}{seo_url param1 = 'delete' param2 = $item.id}" onclick="return confirm('Are you sure?');"><img border="none" src="{#admin_img_url#}cross.png" alt="Delete" /></a>
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
    validator.add('frm');
</script>