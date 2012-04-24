{config_load file=templates.ini section="common" scope="global"}
<form action="#"  method="POST" id="frm" name="forma_name">
<div id="faqsContact">Looking to find out more? Submit your question below.
    <table align="center" width="350" height="230" cellspacing="1" border="0">
        <tr valign="top">
            <td>
                Name:
            </td>
            <td align="left">
                <input name="name" value="{$name}" title="string___<br/>Please enter your name" />
            </td>
        </tr>
        <tr valign="top">
            <td>
               E-mail:
            </td>
            <td align="left">
               <input name="email" value="{$email}" title="email___<br/>Please enter email" />
            </td>
            </tr>
        <tr valign="top">
            <td>
                Question:
            </td>
            <td align="left">
                <textarea rows="5" cols="30" name="question" title="string___<br/>Please enter question"></textarea>
            </td>
        </tr>
        <tr>
            <td>
                <input type="hidden" name="send" value="1"/>
                <input type="hidden" name="id" value="{$id}"/>
                <input type="hidden" name="section_name" value="{$section_name|escape}"/>
            </td>
            <td align="left"><input type="button" value="Send" onclick="sbmQuest();" /> <input type="button" value="Cancel" onclick="Lightbox.close();"/></td>
        </tr>
    </table>
    </div>
</form>

