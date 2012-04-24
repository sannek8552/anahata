{config_load file=templates.ini section="common" scope="global"}
<table width="100%">
    <tr>
        <td>
            <div id="faq_accordion">
                {foreach from = $faq_entries item = item key = key}
                    <h3 class="toggler atStart">{$item.title|escape}</h3>
                    <div class="element atStart">
                        {$item.content}<br/>
                        {foreach from = $entries[$item.id] item = it key = k}
                            {if $it.publish == 1}
                                <div>
                                    <div id="quest_section" style="width:80%;float:left;padding-bottom:10px;">
                                        <b>Name: </b> {$it.name|escape}<br/>
                                        <b>Question: </b>{$it.question|escape|nl2br}<br/>
                                        {if $it.answer}<b>Answer: </b>{$it.answer|escape|nl2br}{/if}
                                    </div>
                                </div>
                            {/if}
                        {/foreach}
                    <div style="clear:both;"></div>
                    {if $faq_data.user_questions}<a href="" onclick="Lightbox.get_html_callback=add_validator;Lightbox.get_html('Ask_Question', {literal}{{/literal}id:'{$item.id}', section_name:'{$item.title|escape}'{literal}}{/literal});return false" >Aska Question</a>{/if}
                    </div>
                {/foreach}
            </div>
        </td>
    </tr>
    {*foreach from=$faq_entries item=item key=key}
    <tr>
        <td>
            <h3>{$item.title}</h3> <br/><br/>
            {$item.content}
        </td>
    </tr>
    {/foreach*}
</table>
<script type="text/javascript">
var accordion = null;
{literal}      
    window.addEvent('domready',function()
    {
        {/literal}{$to_init_faq}{literal}
    });
{/literal}
</script>
{literal}
<script type="text/javascript">
    function add_validator()
    {
        validator.add('forma_name');
    }
    function sbmQuest()
    {
        if(validator.check('forma_name'))
        {
            Lightbox.submit_form(document.getElementById('frm'), 'Ask_Question');
        }
    }
</script>
{/literal}