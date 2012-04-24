{config_load file=templates.ini section="common" scope="global"}
<h2>Manage Entry</h2>
<form action="{#script_url#}{seo_url rm = Answer_To_User}" method="post" id="frm">
    <table>
        <tr valign="top">
            <td style="width:50px">
                Name
            </td>
            <td>
                {$entry.name|escape}
            </td>
        </tr>
        <tr valign="top">
            <td>
                Email
            </td>
            <td>
                {$entry.email|escape}
            </td>
        </tr>
        <tr valign="top">
            <td>
                Question:
            </td>
            <td>
                <textarea name="question">{$entry.question}</textarea>
            </td>
        </tr>
        <tr valign="top">
            <td>
                Answer:
            </td>
            <td>
                <textarea name="answer">{$entry.answer}</textarea>
            </td>
        </tr>
        <tr valign="top">
            <td>
                Publish:
            </td>
            <td>
                <input type="checkbox" name="publish" {if $entry.publish} checked {/if} />
            </td>
        </tr>
        <tr>
            <td>
                <input type="hidden" name="id" value="{$id}" />
                <input type="hidden" name="faq_id" value="{$faq_id}" />
                <input type="submit" style="width:60px;" value="Save"  name="send" {*onclick="Lightbox.submit_form(document.getElementById('frm'), 'Answer_To_User');" *}/>
            </td>
            <td>
                <input type="button" value="Close" onclick="Lightbox.close();" />
            </td>
        </tr>
    </table>

</form>