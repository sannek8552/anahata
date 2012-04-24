    </a>
    <ul type="circle">
        {foreach from=$items item=item}
        <li>
            <a href="{#script_url#}{seo_url rm=Category param1=$category.seo_url}" class="fly">{$item.title}
            {if $item.sub}
                {include file="Common/CMS/Page_Runmode/sitemap_category_sub.tpl" items=$item.sub}
            {else}
            </a>
            {/if}
        </li>
        {/foreach}
    </ul>