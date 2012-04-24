{if $level==2}
    {assign var='class' value='secondLevel'}
{else}
    {assign var='class' value='thirdLevel'}
{/if}
   
<ul class="{$class}">
    {foreach from=$items item=item}
    <li class="expanded">
        <!--<a href="{if $level>2}{#script_url#}{seo_url rm='Category' param1=$item.id}{else}javascript:void(0);{/if}" {if $cur_cat == $item.id}class="active"{/if}>{$item.title}</a>-->
        <a href="{#script_url#}{seo_url rm='Category' param1=$item.id}" {if $cur_cat == $item.id}class="active"{/if}>{$item.title}</a>
        {if $item.sub}
            {include file="sub_cat.tpl" items=$item.sub level=$level+1}
        {/if}
    </li>
    {/foreach}
</ul>
