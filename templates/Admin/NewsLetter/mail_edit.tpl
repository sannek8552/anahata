{config_load file=templates.ini section="common" scope="global"}
{if $saved}	Successfully saved!{else}
<form id="edit_form" action="javascript:void(0);" method="post">
<input type="text" style="display: none;" />

<table style="text-align:left;width:100%;">
{if $err}<tr><td colspan="2" align="center" class="required_class">Please check marked fields</td></tr>{/if}

<tr>
	<td{if $err.title}class="required_class"{/if} >Title</td>
	<td>
            <input type="text" name="title" value="{$data.title}" />&nbsp;&nbsp;
            Subject 
            <input type="text" name="subject" value="{$data.subject}" />
        </td>
</tr>
<tr>
	<td{if $err.html}class="required_class"{/if}>HTML</td>
	<td><textarea style="width:660px; height:300px" name="html" id="edid_html_text_area">{$data.html}</textarea></td>
</tr>
<tr>
	<td{if $err.plain}class="required_class"{/if}>Plain</td>
	<td><textarea name="plain" style="width:660px; height:200px">{$data.plain}</textarea></td>
</tr>
<tr>
    <td>
        Campaign Settings:<br />
    </td>
    <td>
        <table>
            <tr>
                <td>Source:</td>
                <td><input type="text" value="{$data.utm.utm_source}" name="utm[utm_source]" style="width:auto"/></td>
                <td>Medium:</td>
                <td><input type="text" value="{if $data.utm.utm_medium}{$data.utm.utm_medium}{else}email{/if}" name="utm[utm_medium]" style="width:auto"/</td>
                <td>Name:</td>
                <td><input type="text" value="{$data.utm.utm_campaign}" name="utm[utm_campaign]" style="width:auto"/></td>
            </tr>
            <tr>
                <td>Content:</td>
                <td><input type="text" value="{$data.utm.utm_content}" name="utm[utm_content]" style="width:auto"/></td>
                <td>Term:</td>
                <td><input type="text" value="{$data.utm.utm_term}" name="utm[utm_term]" style="width:auto"/></td>
            </tr>
            
        </table>
    </td>
</tr>
<tr>
	<td><input type="hidden" name="item_id" value="{$data.id}" /></td>
	<td><input type="button" style="width: auto;" name="save" value="Save" onclick="nlmail.save_edit('edit_form');" /></td>
</tr>
</table>

</form>
{/if}