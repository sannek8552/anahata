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
function reset_form_params(form_id)
{
	var form = $(form_id);
	for(var i = 0; i < form.elements.length; i++)
	{
		var element = form.elements[i];
		var type = form.elements[i].type;
		if (form.elements[i].tagName != 'FIELDSET' && form.elements[i].type != 'checkbox' && form.elements[i].type != 'radio')
	  		form.elements[i].value = '';

		if (form.elements[i].type == 'textarea' && !form.elements[i].value)
		{
	  		form.elements[i].value = '';
		}

		if (form.elements[i].type == 'checkbox' && form.elements[i].checked)
	  		form.elements[i].checked = false;
                
		if (form.elements[i].type == 'select-one')
		{
	  		form.elements[i].value = 0;
	  		
		}
	}

}

if(typeof($) == "undefined")
{
	function $(id)
	{
		return document.getElementById(id);
	}
}


function format_work_phone(eCell, oRecord, oColumn, oData)
{
	eCell.innerHTML =  formatters_work_phone(oData)
}
function formatters_work_phone(data)
{
	var phone = new String(data);
	if (phone.length == 0) return '';
	var str = '';
	if (phone.substr(10, 5) != '') str = ' x ' + phone.substr(10, 5);
	return '(' + phone.substr(0,3) + ') ' + phone.substr(3,3) + ' - ' + phone.substr(6,4) + str;
}
function format_date_yui(eCell, oRecord, oColumn, oData)
{
	eCell.innerHTML =  format_date(oData)
}
function format_date(date)
{
	var splt = date.split('-');
	var day = splt[2];
	var month = splt[1];
	var year = splt[0];
	return month + '/' + day + '/' + year;
}

function format_datetime_yui(eCell, oRecord, oColumn, oData)
{
	eCell.innerHTML =  format_datetime(oData)
}
function format_datetime(datetime)
{	
	var splt = datetime.split(' ');
	var date = splt[0];
	var time = splt[1];
	date = date.split('-');
	var day = date[2];
	var month = date[1];
	var year = date[0];
	
	time = time.split(":");
	var hour = time[0];
	var minute = time[1];
	if (hour<12) {
		var ampm = 'AM';
		if (hour = 0) hour = 12;
	}
	else if (hour>=12)
	{ 
		var ampm = 'PM';
		if (hour>12) hour -=12;
	}
	return month + '/' + day + '/' + year+' '+hour+':'+minute+' '+ampm;
}

function format_asset_manager_type(type_manager)
{
	var type = ''
	if ('asset' == type_manager) type = 'Asset Manager';
	if ('premarket' == type_manager) type = 'PreMarket Manager';
	if ('closing' == type_manager) type = 'Closing Manager';
	if ('executive' == type_manager) type = 'Executive Manager';
	return type;
}

function clear_form_params(form_id)
{
	var form = $(form_id);
	for(var i = 0; i < form.elements.length; i++)
	{
		if (form.elements[i].type == 'select-one')
		{
	  		for (var o=0;o<form.elements[i].options.length;o++)
	  		{
	    		if (form.elements[i].options[o].selected)
	  				form.elements[i].options[o].selected = false;
	  		}
		}
		else if (form.elements[i].type == 'checkbox' && form.elements[i].checked)
		{
			form.elements[i].checked = false;
		}
		else if (form.elements[i].type == 'radio' && form.elements[i].checked)
		{
			form.elements[i].checked = false;
		}
		else
		{
			form.elements[i].value = "";
		}
	}
}
