{config_load file=templates.ini section="common" scope="global"}
<link href="{#js_url#}noobSlide/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="{#js_url#}noobSlide/_class.noobSlide.packed.js"></script>

<style type="text/css">{literal}
    .gallery_mask{
        width: {/literal}{$gallery_data.width1*2}{literal}px;
        height: 260px;
    }
    #gallery_box span{
        width: {/literal}{$gallery_data.width1*2}{literal}px;
       height: 345px;
    }
    .gallery_mask .info	{
        width: {/literal}{$gallery_data.width1*2}{literal}px;
        height: 42px;
     }
     .gallery_thumbs div, .gallery_thumbs span{
	width: {/literal}{$gallery_data.width2}{literal}px;
	/*height: 112px;*/
    }
{/literal}
</style>

<script type="text/javascript">{literal}
window.addEvent('domready',function(){
	var sampleObjectItems =[
{/literal}
{foreach from=$page item=i name='foreach_pic'}
{literal}{{/literal}name: '{$i.name|escape}', description: '{$i.description|escape}', elements: '{$i.elements|escape}', url: '{$i.url}'{literal}}{/literal}{if !$smarty.foreach.foreach_pic.last },{/if}
{/foreach}
{literal}
	];

	var info = $('gallery_box').getNext().setOpacity(0.7);
	var hs = new noobSlide({
		mode: 'horizontal',
		box: $('gallery_box'),
		items: sampleObjectItems,
		size: {/literal}{$gallery_data.width1*2}{literal},
		//handles: $ES('div','handles6_1').extend($ES('div','handles6_2')),
		handles: $ES('span','gallery_handles'),
		handle_event: 'mouseenter',
		buttons: {
			previous: $('prev'),
			play: $('play'),
			stop: $('stop'),
			playback: $('playback'),
			next: $('next')
		},
		//button_event: 'click',
		fxOptions: {
			duration: 1000,
			transition: Fx.Transitions.Back.easeOut,
			wait: false
		},
		onWalk: function(currentItem, currentHandle){
			info.empty();
			new Element('p').setHTML(
				'<a href="'+currentItem.url+'">more information</a>'+
				'<b>View:</b> '+currentItem.name+'<br />'+
				'<b>Description:</b> '+currentItem.description+'<br />'+
				''+currentItem.elements).inject(info);
			this.handles.setOpacity(0.7);
			currentHandle.setOpacity(1);
		},
		startItem: -1,
		autoPlay: true
	});
	hs.next();
});
</script>{/literal}
<div id="portfolio">
<div class="gallery_mask">
	<div id="gallery_box">
	{foreach from=$page item=i}<span><img   src="{#script_url#}gallery/{$gallery_data.width1}_{$i.pic1}" /><img  src="{#script_url#}gallery/{$gallery_data.width1}_{$i.pic2}" /></span>{/foreach}
	</div>
	<div class="info"></div>
</div>
<div class="buttons">
	<span id="prev"> </span>
	<span id="playback"></span>
	<span id="stop"> </span>
	<span id="play"> </span>
	<span id="next"> </span>
</div>

<div class="gallery_thumbs" id="gallery_handles">
	{foreach from=$page item=i}<span><img src="{#script_url#}gallery/{$gallery_data.width2}_{$i.pic2}" /></span>{/foreach}
</div>
</div>
<div style="clear: both;"></div>
<table>
<tr>
	<td>
            {if $num.current!='1'}
            <a href="{#script_url#}{seo_url rm=$seo_url param1=$num.current-1}">Previous</a>
            {else}
            Previous
            {/if}

            {foreach from=$num.prepared item=item key=key}
            <a href="{#script_url#}{seo_url rm=$seo_url param1=$item}">
                {if $num.current==$item}<b>{/if}
                {$item}
                {if $num.current==$item}</b>{/if}
            </a>
            {/foreach}
            {if $num.current!=$num.pages}
            <a href="{#script_url#}{seo_url rm=$seo_url param1=$num.current+1}">Next</a>
            {else}
            Next
            {/if}
	</td>
</tr>
</table>