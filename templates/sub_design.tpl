<!--[if gte IE 7]><!-->
    </a>
    <!--<![endif]-->
    <!--[if lte IE 6]><table><tr><td><![endif]-->
    <ul>
        {foreach from=$items item=item}
        
        <li>
            <a href="{#script_url#}{seo_url rm=Category param1=$item.seo_url}" >{$item.title}
            {if $item.sub}
	            {include file='sub_design.tpl' items=$item.sub}
       		{else} 
       			</a> 
       		{/if}            
        </li>
        
        {/foreach}
    </ul>
    <!--[if lte IE 6]></td></tr></table></a><![endif]-->