function make_h(num)
{
	$('i_' + num).src = images_prefix + num + '_on.gif';
}

function make_n(num)
{
	$('i_' + num).src = images_prefix + num + '_off.gif';
}

function ShowModify()
{
	var params = {};
	Lightbox.get_html('GetModify', params);
	return false;
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