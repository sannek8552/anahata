{config_load file=templates.ini section="common" scope="global"}
<link href="{#js_url#}noobSlide/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="{#js_url#}noobSlide/_class.noobSlide.packed.js"></script>


<script type="text/javascript">{literal}
window.addEvent('domready',function(){
	var sampleObjectItems =[
{/literal}
{foreach from=$page item=i name='foreach_pic'}
{literal}{{/literal}name: '{$i.name|escape}', description: '{$i.description|escape}', elements: '{$i.elements|escape}', url: '{$i.url}'{literal}}{/literal}{if !$smarty.foreach.foreach_pic.last },{/if}
{/foreach}
{literal}
	];

	var info = $('gallery_box').getNext().setOpacity(0.8);
	var hs = new noobSlide({
		mode: 'horizontal',
		box: $('gallery_box'),
		items: sampleObjectItems,
		size: 529,
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
				'<a target="_blank" href="'+currentItem.url+'">visit site</a>'+
				'<b>Client:</b> '+currentItem.name+'<br />'+
				'<b>Description:</b> '+currentItem.description+'<br />'+
				'<b>Elements:</b> '+currentItem.elements).inject(info);
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
	{foreach from=$page item=i}<span><img src="{#script_url#}gallery/525_{$i.pic1}" /></span>{/foreach}
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
	{foreach from=$page item=i}<span><img src="{#script_url#}gallery/thumb_{$i.pic1}" /></span>{/foreach}
</div></div>
<div style="clear: both;"></div>
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