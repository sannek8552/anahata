    <ul>
        {foreach from=$items item=item}        
        <li>
            <a href="{if $item.direct_link}{$item.seo_url}{else}{#script_url#}{seo_url rm=$item.seo_url}{/if}" {if $item.sub}class="fly"{/if}>{$item.title}</a>
            {if $item.sub}
                {include file="sub_menu.tpl" items=$item.sub}
            {/if}
        </li>        
        {/foreach}
    </ul>    


{*

<!--[if gte IE 7]><!-->
    </a>
    <!--<![endif]-->
    <!--[if lte IE 6]><table><tr><td><![endif]-->
    <ul>
        {foreach from=$items item=item}
        
        <li>
            <a href="{if $item.direct_link}{$item.seo_url}{else}{#script_url#}{seo_url rm=$item.seo_url}{/if}" {if $item.sub}class="fly"{/if}>{$item.title}
            {if $item.sub}
                {include file="sub_menu.tpl" items=$item.sub}
            {else}
            </a>
            {/if}
        </li>
        
        {/foreach}
    </ul>
    <!--[if lte IE 6]></td></tr></table></a><![endif]-->
*}