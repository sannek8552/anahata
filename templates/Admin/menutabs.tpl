
        {foreach from=$items item=item}
        <option value="{$item.seo_url}">|{$item.prefix|escape}</option>
            {if $item.sub}
                {include file="Admin/menutabs.tpl" items=$item.sub k=$item.id}
            {/if}
        {/foreach}