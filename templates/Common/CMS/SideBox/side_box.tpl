
    {foreach from=$side_boxes item=item}
        {if $item.active}

	{* SINGLE SIDE BOX HTML CODE *}

        <div class="side_box_element">
            <h3>{$item.title}</h3>
	    <br/>
            <div class="text">{$item.text}</div>
            {if !empty($item.cms_url)}
                <a href="{#script_url#}{seo_url rm = $item.cms_url}">link...</a>
            {elseif !empty($item.external_url)}
                <a href="{$item.external_url}">link...</a>
            {/if}

        </div>

	{* END OF SINGLE SIDE BOX HTML CODE *}

        {/if}
    {/foreach}
