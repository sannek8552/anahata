    <ul>
        {foreach from=$items item=item}
        <li>
            <a href="{#script_url#}{seo_url rm=$item.seo_url}" >{$item.title}</a>
        {if $item.sub}
            {include file='sub_cross_1.tpl' items=$item.sub}
        {/if}
        </li>
        {/foreach}
    </ul>
