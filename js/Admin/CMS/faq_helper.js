function faq_add_entry()
{	
	var topic_title = $('topic_title').value;
	$('topic_title').value = '';
	var topic_content = tinyMCE.get('faq_entryid').getContent();
	tinyMCE.get('faq_entryid').setContent('');
	
	if(edit_mode !== false)
	{
		$('faq_add_entry_id').value = 'Add Entry';
		faq_entries[edit_mode].title = topic_title;
		faq_entries[edit_mode].content = topic_content
		faq_rebuild_accordion();
		edit_mode = false;
	}
	else
	{
		faq_entries[faq_entries.length] = {title : topic_title, content : topic_content};
		faq_insert(topic_title, topic_content, faq_entries.length -1);
	}
	
}

function faq_rebuild_accordion()
{
	$('faq_accordion').setHTML('');
	acc = null;
	faq_entries.each(function(item, index)
	{
		faq_insert(item.title, item.content, index);
	}
	);
}

function faq_insert(topic_title, topic_content, num)
{
	if(null == acc)
	{
		acc = new Accordion('h3.atStart', 'div.atStart',{alwaysHide:true},$('faq_accordion'));
		acc.addSection = function(toggler, element, pos){
		toggler = $(toggler);
		element = $(element);
		var test = this.togglers.contains(toggler);
		var len = this.togglers.length;
		this.togglers.include(toggler);
		this.elements.include(element);
		if (len && (!test || pos))
		{
			pos = $pick(pos, len - 1);
			toggler.injectAfter(this.elements[pos]);//(this.togglers[pos]);
			element.injectAfter(toggler);
		} 
		else if (this.container && !test)
		{
			toggler.inject(this.container);
			element.inject(this.container);
		}
		var idx = this.togglers.indexOf(toggler);
		toggler.addEvent('click', this.display.bind(this, idx));
		if (this.options.height) element.setStyles({'padding-top': 0, 'border-top': 'none', 'padding-bottom': 0, 'border-bottom': 'none'});
		if (this.options.width) element.setStyles({'padding-left': 0, 'border-left': 'none', 'padding-right': 0, 'border-right': 'none'});
		element.fullOpacity = 1;
		if (this.options.fixedWidth) element.fullWidth = this.options.fixedWidth;
		if (this.options.fixedHeight) element.fullHeight = this.options.fixedHeight;
		element.setStyle('overflow', 'hidden');
		if (!test){
		for (var fx in this.effects) element.setStyle(fx, 0);
		}
		return this;
 		}
	}
	topic_title += ' <a href="#" onclick="move_up(event,'+(num)+');return false;"><img border="none" src="../../css/images/admin/move_up.png" alt="Move Up" /></a> ' + ' <a href="#" onclick="move_down(event,'+(num)+');return false;"><img border="none" src="../../css/images/admin/move_down.png" alt="Move Down" /></a> ' + '<a href="#" onclick="faq_edit_entry(event,'+num+');return false;"><img border="none" src="../../css/images/admin/edit.png" alt="Edit" /></a> ' + '<a href="#" onclick="faq_delete_entry(event,'+num+');return false;"><img border="none" src="../../css/images/admin/cross.png" alt="Delete" /></a>';
	var newTog = new Element('h3', {'class': 'toggler atStart'}).setHTML(topic_title);
	var newEl = new Element('div', {'class': 'element atStart'}).setHTML(topic_content);
	 
	//alert(faq_entries_num -1);
	acc.addSection(newTog, newEl,acc.togglers.length - 1);
	
}

function faq_delete_entry(event, faq_id)
{
	
	e = new Event(event);
	e.stopPropagation();
	if(!confirm('Are you sure?'))
		return false;
	var i = 0;
        
	var old_faq_entries = faq_entries;
	faq_entries = Array();
	for(i = 0; i < old_faq_entries.length - 1; i++)
	{
		if(i >= faq_id)
			faq_entries[i] = old_faq_entries[i + 1];
		else
			faq_entries[i] = old_faq_entries[i];
			
	}
	faq_rebuild_accordion();
	//alert(faq_id);
	
}

function move_up(event,faq_id)
{
	e = new Event(event);
	e.stopPropagation();
	//alert('we are in move up function');
	if(0 == faq_id)
	{
		return false;
	}
	var new_faq_entries = new Array();
	var i = 0;
	for(i = 0; i < faq_id - 1;i++)
	{
		new_faq_entries[i] = faq_entries[i];
	}
	new_faq_entries[faq_id - 1] = faq_entries[faq_id];
	new_faq_entries[faq_id] = faq_entries[faq_id - 1];
	for(i = faq_id+1; i < faq_entries.length;i++)
	{
		new_faq_entries[i] = faq_entries[i];
	}
	faq_entries = new_faq_entries;
	
	/*$('faq_accordion').setHTML('');
	acc = null;
	faq_entries.each(function(item, index)
	{
		faq_insert(item.title, item.content, index);
	}
	);*/
	faq_rebuild_accordion();
	//now we need to create new array with other order of elements
	//tip is that faq_id is index of array
	
	//$('faq_accordion').;
}
function move_down(event,faq_id)
{
	e = new Event(event);
	e.stopPropagation();
	//alert('we are in move up function');
	if(faq_entries.length-1 == faq_id)
	{
		return false;
	}
	var new_faq_entries = new Array();
	var i = 0;
	for(i = 0; i < faq_id; i++)
	{
		new_faq_entries[i] = faq_entries[i];
	}
	new_faq_entries[faq_id + 1] = faq_entries[faq_id];
	new_faq_entries[faq_id] = faq_entries[faq_id + 1];
	for(i = faq_id+2; i < faq_entries.length;i++)
	{
		new_faq_entries[i] = faq_entries[i];
	}
	faq_entries = new_faq_entries;
	
	/*$('faq_accordion').setHTML('');
	acc = null;
	faq_entries.each(function(item, index)
	{
		faq_insert(item.title, item.content, index);
	}
	);*/
	faq_rebuild_accordion();
	//$('faq_accordion').;
}

function faq_edit_entry(event, faq_id)
{
	e = new Event(event);
	e.stopPropagation();
	$('topic_title').value = faq_entries[faq_id].title;
	tinyMCE.get('faq_entryid').setContent(faq_entries[faq_id].content);
	$('faq_add_entry_id').value = 'Save Changes';
	edit_mode = faq_id;
}

function faq_cleanup()
{
	edit_mode = false;
	faq_entries = new Array();
	faq_entries_num = 1;
	acc = null;
}

var edit_mode = false;
var faq_entries = new Array();
var faq_entries_num = 1;
var acc = null;

function faq_save()
{
	var req = new JsHttpRequest();
	var query = {};
	query.faq_id = faq_section_id;
	query.faq_entries = faq_entries;
	req.onreadystatechange = function()
	{
            if(4 == req.readyState)
            {
                    //alert(req.responseText);
                    //alert(req.responseJS.status);
                if('false' == req.responseJS.status)
                {
                        //alert(req.responseJS.message);
                //	alert('here');
                        return;
                }
                else
                {
                    alert('Saved');
                }
            }
	}
	//alert(ajax_prefix);
	req.caching = false;
	req.open('post', ajax_prefix + '?rm=FAQ_Manager_Entry_ajax', true);
	req.send(query);
}