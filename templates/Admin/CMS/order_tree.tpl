{config_load file=templates.ini section="common" scope="global"}
<div id="parent_el" >
{foreach from=$tree item=item key=key name=tree_for}
	<div style="display:block;width:300px;height:500px;overflow:auto;">
		{if $item.id != $cur_node}<img src="{#admin_img_url#}plusnode.gif" style="float:left;" alt="expand" onclick="expand_node({$item.id},event)" id="img{$item.id}"/>{/if}
			<div {if $item.id != $cur_node}onclick="change_back(this,{$item.id});"{/if} style="{if $item.id != $cur_node}cursor:pointer;{else}padding-left:18px;{/if}background:#ffffff;" >{$item.title}</div>
		{if $item.sub && $item.id != $cur_node}
		<div style="display:none;padding-left:10px;" id="node{$item.id}">
		{include file="Admin/CMS/order_tree_sub.tpl tree=$item.sub cur_node=$cur_node}
		</div>
		{/if}
	</div>
	<div style="padding:10px;">
	Select new parent node by clicking on name and then click Move Here button
	</div>	
	<div style="padding:10px;padding-left:60px;">
	<input type="button" name="save" value="Move Here" onclick="move_here();"/>&nbsp;<input type="button" name="cancel" value="Cancel" onclick="Lightbox.close();" />
	</div>
{/foreach}

</div>

{*<script type="text/javascript">

</script>*}