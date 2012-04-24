{config_load file=templates.ini section="common" scope="global"}
<div class="table-list">
<table>   
{if $item.sub}
<thead>
    			 	<tr id="op{$item.id}">
	        			<td scope="col" nowrap><strong>Sub Category</strong></td>
    	    			<td scope="col" nowrap><strong>Operations</strong></td>
                            </tr>
        </thead>   
    					{include file="Admin/Tree/structure_table_sub.tpl" data = $item.sub padding=0}</td>						
				{else}
				No sub categories found
				{/if}
<tfoot>
            <tr>
						<td id="a{$item.id}"{if $padding}style="padding-left:{$padding}px;"{/if}>&nbsp;</td>
						<td><a href="javascript:void(0);" onclick="tree.add_submenu_handler({$item.id});"><strong>Add Sub-{$item_name}</strong></a>
						&nbsp;<a href="javascript:void(0);" onclick="tree.order_items_handler({$item.id});"><strong>Order Sub-{$item_name}</strong></a></td>
            </tr>
        </tfoot>    
</table>
</div>