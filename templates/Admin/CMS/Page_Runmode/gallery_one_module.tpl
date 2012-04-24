{config_load file=templates.ini section="common" scope="global"}
 {literal}
<script type="text/javascript">
		window.addEvent('domready', function(){
			var Tips2 = new Tips($$('.Tips2'), {
				initialize:function(){
					this.fx = new Fx.Style(this.toolTip, 'opacity', {duration: 500, wait: false}).set(0);
				},
				onShow: function(toolTip) {
					this.fx.start(1);
				},
				onHide: function(toolTip) {
					this.fx.start(0);
				}
			});
		}); 
	</script>
	<style type="text/css">
	
	 
	.tool-text {
		font-size: 12px;
		padding: 4px 8px 8px;
		color: #333333;
		background: white ;
		width: 500px;
		text-align:center;	
	}
	</style>
	{/literal}
<table width="100%" align="left">
<tr>
	<td width="100%" align="center"> 
		<div id="picture_div" >
		<table align="left">
{foreach from=$outarray item=item key=key}
<tr>
	<td>
<table align="center" border="0">
			<tr>
				<td align="center" width="50%">
				before
				</td>
				<td align="center">
				after
				</td>
			</tr>
			<tr>
				<td align="center" colspan="2">
					<img src="{#script_url#}gallery/200_{$item.0.pic1}" title="<table align='center' ><tr><td align='center' width='50%'>	before  </td><td align='center'>  after</td></tr><tr><td align='center' colspan='2'><img src='{#script_url#}gallery/400_{$item.0.pic1}'/></td></tr><tr><td colspan='2' align='center'><div>{$item.0.description|nl2br}</div></td></tr></table>" class="Tips2" />
				</td>
			</tr>
			<tr>
				<td colspan="2" align="center">{if $item.0.description}{$item.0.description|nl2br}{else} &nbsp;{/if}</td>
			</tr>
		</table>
		</td>
		<td>
		{if $item.1.pic1}
		<table align="center" border="0">
			<tr>
				<td align="center" width="50%">
				before
				</td>
				<td align="center">
				after
				</td>
			</tr>
			<tr>
			<td align="center" colspan="2">
				<img src="{#script_url#}gallery/200_{$item.1.pic1}" title="<table align='center' ><tr><td align='center' width='50%'>	before  </td><td align='center'>  after</td></tr><tr><td align='center' colspan='2'><img src='{#script_url#}gallery/400_{$item.1.pic1}'/></tr><tr><td colspan='2' align='center'>{$item.1.description|nl2br}</td></tr></table>" class="Tips2"/>
			</td>
			</tr>
			<tr>
				<td colspan="2" align="center">{if $item.1.description}{$item.1.description|nl2br}{else}&nbsp;{/if}</td>
			</tr>
		</table>
		{else}
		&nbsp;
		{/if}
	</td>
	</tr>
{/foreach}
</table>
	  </div>
	</td>
</tr>
<tr>
	<td colspan="2">
	{foreach from=$num.prepared item=item key=key}
	<a href="{#script_url#}{seo_url rm=$seo_url param1=$item}">{if $num.current==$item}<b>{/if}{$item}{if $num.current==$item}</b>{/if}</a>
	{/foreach}
	</td>
</tr>
</table>