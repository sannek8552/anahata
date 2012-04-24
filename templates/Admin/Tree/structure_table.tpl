{config_load file=templates.ini section="common" scope="global"}
{assign var=cur_level value=1}
<h2>{$item_name} редактор</h2>
<div class="table-list">
<table>
         <thead>
            <tr>

                                    <th scope="col" nowrap>{$item_name}</th>
                                    <th scope="col" nowrap>Редактировать {$item_name}</th>
                                    <th scope="col" nowrap>Функции</th>
                            </tr>
        </thead>    	
  		{foreach from=$data item=item key=key}
  		<tr id="d{$item.id}">
    		<td id="a{$item.id}" bgcolor="#FFFFFF" valign="top"><b>{$item.title}</b><br />{$item.description|truncate:20}</td>
    		
    		<td id="after{$item.id}" bgcolor="#FFFFFF" >
    		{if $max_level > 0}
    		{include file="Admin/Tree/structure_table_tab.tpl" item = $item}
    		{/if}
    		<td bgcolor="#FFFFFF" valign="top"><img src="{#img_url#}arrow_up.png" onclick="tree.menu_move_up({$item.id})" alt="Move Up" />&nbsp;<img src="{#img_url#}arrow_down.png" onclick="tree.menu_move_down({$item.id})" alt="Move Down" />&nbsp;<img src="{#img_url#}edit.gif" onclick="tree.edit_item_handler({$item.id})" alt="Edit" />&nbsp;<img src="{#img_url#}delete.gif" onclick="tree.delete_item_handler({$item.id},{$item.parent_id})" alt="Delete" />
    		&nbsp;<input type="text" name="order{$item.id}" value="{$item.order_id}" style="width:auto" id="{$item.parent_id}input{$item.id}" size="3" /></td>
 		</tr>
 		{foreachelse}
 		<tr>
 			<td colspan="100">Нет данных</td>
 		</tr>
  		{/foreach} 
<tfoot>
            <tr>
                <th scope="row" colspan="4"><a href="javascript:void(0);" onclick="tree.add_submenu_handler(0);"><strong>Добавить {$item_name}</strong></a>
			&nbsp;<a href="javascript:void(0);" onclick="tree.order_items_handler(0);"><strong>Сортировать {$item_name}</strong></a></th>
            </tr>
        </tfoot>         
  	</table>
</div>