tinyMCEPopup.requireLangPack();

var MediaManagerDialog = 
{
	init : function(ed)
	{
		var f = document.forms[0], nl = f.elements, ed = tinyMCEPopup.editor, dom = ed.dom, n = ed.selection.getNode();
		
	}
}

tinyMCEPopup.onInit.add(MediaManagerDialog.init, MediaManagerDialog);

function insert_image(path,filename,form_id)
{
	params = get_form_params(form_id);

	var to_insert = '';
	var cssclass = 'class="';
	
	if (params['url'] != '') to_insert += '<a href="'+params['url']+'">';	

	if (params['size'] != '' && params['size'] != null)
	{
		src = path+params['size']+'_'+filename;
	}
	else
	{
		src = path+filename;
	}
	
	if (params['alignment'] == 'middle')
	{
		cssclass += ' aligncenter';
	}
	
	cssclass += '"';
	to_insert += '<img src="'+src+'"  alt="'+params['caption']+'" title="'+params['description']+'" align="'+params['alignment']+'" '+cssclass+' id="img_'+params['id']+'_'+params['size']+'_'+params['alignment']+'" />';

	if (params['url'] != '') to_insert += '</a>';
    tinyMCEPopup.execCommand('mceInsertContent', false, to_insert);
    tinyMCEPopup.close();
}

function insert_embed()
{
	var to_insert = document.getElementById('embed_input').value;
	tinyMCEPopup.execCommand('mceInsertContent', false, to_insert);
    tinyMCEPopup.close();
}

function insert_file(path,filename,icon)
{
	var to_insert = '<a href="'+path+filename+'" target="_blank"><img src="'+icon+'" border="0"></a>';
	tinyMCEPopup.execCommand('mceInsertContent', false, to_insert);
    tinyMCEPopup.close();
}

function get_form_params(form_id)
{
	var form = $(form_id);
	var params = {};
	for(var i = 0; i < form.elements.length; i++)
	{
		var element = form.elements[i];
		var type = form.elements[i].type;
		if (form.elements[i].tagName != 'FIELDSET' && form.elements[i].type != 'checkbox' && form.elements[i].type != 'radio')
	  		params[form.elements[i].name] = form.elements[i].value;

		if (form.elements[i].type == 'textarea' && !form.elements[i].value)
		{
	  		params[form.elements[i].name] = form.elements[i].value;
		}

		if (form.elements[i].type == 'checkbox' && form.elements[i].checked)
	  		params[form.elements[i].name] = form.elements[i].value;
		else if(form.elements[i].type == 'checkbox' && !form.elements[i].checked)
	  		params[form.elements[i].name] = '';
		if (form.elements[i].type == 'radio' && form.elements[i].checked)
	  		params[form.elements[i].name] = form.elements[i].value;

		if (form.elements[i].type == 'select-multiple')
		{
	  		var values = [];
	  		for (var o=0;o<form.elements[i].options.length;o++)
	  		{
	    		if (form.elements[i].options[o].selected)
	  				values[values.length] = form.elements[i].options[o].value;
	  		}
	  		params[form.elements[i].name] = values;
		}
	}
	return params;
} 