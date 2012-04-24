{config_load file=templates.ini section="common" scope="global"}
{assign var=cur_level value=$cur_level+1}
      {foreach from=$data item=item key=key}
	      <tr id="d{$item.id}" class="{cycle values="one,two"}" >
	      	<td id="a{$item.id}" {if $padding}style="padding-left:{$padding}px;"{/if}>{$item.title}<br />{$item.description|truncate:40}</td>
	        <td {if $padding}style="padding-left:{$padding}px;"{/if}><img src="{#img_url#}arrow_up.png" onclick="tree.menu_move_up({$item.id})" alt="Move Up" />&nbsp;<img src="{#img_url#}arrow_down.png" onclick="tree.menu_move_down({$item.id})" alt="Move Down" />&nbsp;<img src="{#img_url#}edit.gif" onclick="tree.edit_item_handler({$item.id})" alt="Edit" />&nbsp;<img src="{#img_url#}delete.gif" onclick="tree.delete_item_handler({$item.id},{$item.parent_id})" alt="Delete" />
	        &nbsp;<input type="text" name="order{$item.id}" value="{$item.order_id}" style="width:auto" id="{$item.parent_id}input{$item.id}" size="3" /></td>
	      </tr>
	      <div id="deep{$item.id}">
	      {if $item.sub}
	      	{assign var=padding_new value=$padding+30}
	      	{include file="Admin/Tree/structure_table_sub.tpl" data = $item.sub padding=$padding_new}
	      {/if}
	      </div>
		  {if $cur_level <= $max_level}
	       <tr>
	      	<td bgcolor="#CCCCCC" {if $padding}style="padding-left:{$padding}px;"{/if}>&nbsp;</td>
	      	<td bgcolor="#CCCCCC"><a href="javascript:void(0);" onclick="tree.add_submenu_handler({$item.id});"><strong>Add Sub-{$item_name} </strong></a>
	      	&nbsp;<a href="javascript:void(0);" onclick="tree.order_items_handler({$item.id});"><strong>Order Sub-{$item_name}</strong></a></td>
		   </tr>
		  {/if}
      {/foreach}
