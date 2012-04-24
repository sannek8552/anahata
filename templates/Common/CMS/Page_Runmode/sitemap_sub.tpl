    </a>
    <ul type="circle">
        {foreach from=$items item=item}
        <li>
            <a href="{if $item.direct_link}{$item.seo_url}{else}{#script_url#}{seo_url rm=$item.seo_url}{/if}" class="fly">{$item.title}
            {if $item.sub}
                {include file="Common/CMS/Page_Runmode/sitemap_sub.tpl" items=$item.sub}
            {else}
            </a>
            {/if}
        </li>
        {/foreach}
    </ul>