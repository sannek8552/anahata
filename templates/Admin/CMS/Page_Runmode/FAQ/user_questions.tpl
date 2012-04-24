{config_load file=templates.ini section="common" scope="global"}

{if $faq_entries}
    {foreach from = $faq_entries item = item key = key}
        {$item.title|escape}<br/>
                    {*<b>Question: </b>{$it.question|escape|nl2br}<br/>
                    {if $it.answer}<b>Answer: </b>{$it.answer|escape|nl2br}{/if}*}
                    <div class="table-list">
                        <table width="100%">
                            <thead>
                                <tr align="center">
                                    <th>
                                        Name
                                    </th>
                                    <th>
                                        Email
                                    </th>
                                   <th>
                                        Question
                                    </th>
                                    <th>
                                        Answer
                                    </th>
                                    <th>
                                        Published
                                    </th>
                                    <th>
                                        Date
                                    </th>
                                    <th>
                                        Functions
                                    </th>
                                </tr>
                            </thead>
                            {foreach from = $entries[$item.id] item = it key = k}
                            <tr valign="top">
                                <td>
                                    {$it.name|escape}
                                </td>
                                <td>
                                    {$it.email|escape}
                                </td>
                                <td>
                                    {$it.question|escape|nl2br}
                                </td>
                                <td>
                                    {$it.answer|escape|nl2br}
                                </td>
                                <td align="center">
                                    {if $it.publish}Yes{else}No{/if}
                                </td>
                                <td>
                                    {$it.created|date_format:"%d-%m-%Y %R"}
                                </td>
                                <td>
                                    <a href="javascript: void(0);" onclick="Lightbox.get_html('Answer_To_User', {literal}{{/literal}id:{$it.id}, faq_id:{$item.faq_id}{literal}}{/literal})">Edit answer</a>
                                    <a href="{#script_url#}{seo_url param1 = $faq_id param2 = 'delete' param3 = $it.id}" onclick="return confirm('Are you sure?')">Delete</a>
                                </td>
                            </tr>
                            {foreachelse}
                            <tr>

                                <td colspan="100">
                                    No questions for this topic
                                </td>
                            </tr>
                            {/foreach}
                        </table>
                    </div>
                
            <br/>
            
            <hr/>
    {/foreach}
{else}
{/if}
<script type="text/javascript">

</script>