<ul class="vertical {if $level == 2}first{/if}">
    {foreach from = $items item = item}
    <li>
        <a href="{#script_url#}{seo_url rm=$item.seo_url}">{$item.title}</a>
        {if $item.sub}
            {include file="sub_menu.tpl" items=$item.sub level=$level+1}
        {/if}
    </li>
    {/foreach}
</ul>
