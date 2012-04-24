function change_img(){
	now = new Date();
	document.getElementById('cap_id').src = 'Captcha/'+now.getMilliseconds()+'.html'
}

function get_schools(){
	v = document.getElementById('id_city').value;
	//report_id = v;
	var params = {};
	params['id'] = v;
	var req = new JsHttpRequest();
	req.ir = this;
	req.onreadystatechange = function()
	{
		if (req.readyState == 4)
		{
			document.getElementById('id_school').innerHTML = req.responseJS.html;

		}
	}
	req.caching = false;
	req.open('POST', ajax_prefix + '?rm=School_List&id='+v, true);
	req.send(params);
}

function delete_pic(name){
	if(confirm('Are you sure?'))
	{
		var params = {};
		params['name'] = name;
		var req = new JsHttpRequest();
		req.ir = this;
		req.onreadystatechange = function()
		{
			if (req.readyState == 4)
			{
				document.getElementById('pic_id').innerHTML = '';
			}
		}
		req.caching = false;
		req.open('POST', ajax_prefix + '?rm=Delete_Pic&name='+name, true);
		req.send(params);
	}
}
		
function helper_text_on_off(text, obj,pass){
	//alert('here');
	if(obj.value==''){
		
		if(pass){
			var parent = obj.parentNode;
			if(/type=password/i.test(obj.parentNode.innerHTML)){
				obj.parentNode.innerHTML = obj.parentNode.innerHTML.replace(/type=password/i,"type=text");
			} else {
				obj.parentNode.innerHTML = obj.parentNode.innerHTML.replace(/<input/i,"<input type=text ");
				//setTimeout("$('"+pass+"').focus();", 10);
			}
			$(pass).value = text;
			//alert(parent.innerHTML);
		} else {
			obj.value = text;
		}
	}
}

function helper_text_off_on(text, obj,pass)
{
	if(obj.value==text)
	{
		obj.value = '';
		if(obj.type == 'text' && pass)
		{
			//setTimeout("helper_change_type('"+pass+"')",1000);
			if(/type=text/i.test(obj.parentNode.innerHTML))
			{
				//alert(obj.parentNode.innerHTML.replace(/type=text/i,"type=password"));
			}
			else
			{
				obj.parentNode.innerHTML = obj.parentNode.innerHTML.replace(/<input/i,"<input type=password ");
				setTimeout("$('"+pass+"').focus();", 5);
				$(pass).value = '';
			}
		}
	}
}

function handleEnter(obj, e) 
{
	var charCode;
	
	if(e && e.which)
	{
		charCode = e.which;
	}
	else if(window.event)
	{
		e = window.event;
		charCode = e.keyCode;
	}

	if(charCode == 13) 
	{
	 obj.form.submit();   
	}
}

function helper_change_type(pass)
{
	obj = $(pass);
	if(/type=text/i.test(obj.parentNode.innerHTML))
	{
		//alert(obj.parentNode.innerHTML.replace(/type=text/i,"type=password"));
	}
	else
	{
		obj.parentNode.innerHTML = obj.parentNode.innerHTML.replace(/<input/i,"<input type=password ");
		setTimeout("$('"+pass+"').focus();", 5);
		
	}
}


function show_hide_el(id){
	if(document.getElementById(id).style.display == 'block'){
		document.getElementById(id).style.display = 'none';
	} else {
		document.getElementById(id).style.display = 'block';
	}
}
function show_hide_els(id, list){
	for(i in list){
		if(document.getElementById(list[i]).style.display == 'block')
			document.getElementById(list[i]).style.display = 'none';
	}
	show_hide_el(id);
}

function show_hide_element(id, display){
	document.getElementById(id).style.display = display;
}
