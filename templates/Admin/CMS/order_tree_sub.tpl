{config_load file=templates.ini section="common" scope="global"}
{foreach from=$tree item=item key=key name=tree_sub}
	{if $item.id != $cur_node}<img src="{#admin_img_url#}plusnode.gif" alt="expand" onclick="expand_node({$item.id},event);" id="img{$item.id}" style="float:left;"/>{/if}
	<div {if $item.id != $cur_node}onclick="change_back(this,{$item.id});"{/if} style="{if $item.id != $cur_node}cursor:pointer;{else}padding-left:18px;{/if}background:#ffffff;">{$item.title}</div>
	{if $item.sub && $item.id != $cur_node}
		<div style="display:none;padding-left:10px;" id="node{$item.id}">
			{include file="Admin/CMS/order_tree_sub.tpl" tree=$item.sub cur_node=$cur_node}
		</div>
	{/if}
{/foreach}