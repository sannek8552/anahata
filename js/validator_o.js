//HTMLInputElement.prototype.validate = '';
//HTMLTextAreaElement.prototype.validate = '';

function Validator()
{
	this.version = '1.0';
	var integer_regexp = /^\d+$/;
	var mail_regexp = /^[^@]+@[^@]+\.[^.|@]+$/;
	var numeric_regexp = /^\d+(\.\d+)?$/;
	
	var login_regexp = /^[\w|_|\d]{4,20}$/;
	var car_name_regexp = /^[\w|_| |-|\d]{1,32}$/;
	var password_regexp = /^.{1,25}$/;	
	
	//var date_regexp = /^\d\d\/\d\d\/\d\d\d\d$/;
	var date_regexp = /^\d\d\.\d\d\.\d\d\d\d$/;
	var year_regexp = /^\d\d\d\d$/;
	var url_regexp = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/;
	
	this.add_error_style = add_error_style;
	this.clear_external = clear_external;
	to_check = {};
	var inputsWithErrors = Array();
	var hexDigit = new Array("0","1","2","3","4","5","6","7","8","9","A","B","C","D","E","F");
	this.add = add;
	var span = false;
	var focus = false;
	
	function clear_external()
	{
		clear_errors();
	}
	
	function set_span(b)
	{
		span = b;
	}
	this.set_span = set_span;
	
	function add(form_name,no_submit)
	{
		to_check[form_name] = {};
		var form_to_add = document.forms[form_name];
			for(var i = 0; i < form_to_add.elements.length; i++)
			{
				var elem = form_to_add.elements[i];
				//alert(elem);
				if(typeof(elem.title) != 'undefined' && elem.title!='')
				{
					var restriction = elem.title.split('___');
					//restriction[1] = restriction[1].replace(/_/g, ' ');
					to_check[form_name][elem.name] = {limit : restriction[0], message : restriction[1]};
					elem.title = '';
				}
			}
                if(!no_submit)
                {
                    form_to_add.onsubmit = function() {return check(form_name);};
                }
		//alert(form_to_add.onsubmit);
	}
	
	function check(form_name)
	{
		var no_error = true;
		clear_errors();
		//alert(form_name);
		//alert(to_check[form_name]);
		if(typeof(to_check[form_name]) != 'undefined')
		{
			for(var input in to_check[form_name])
			{				
				var checking = to_check[form_name][input];
			//	alert(checking.limit);
				if(checking.limit == 'string')
				{
					//alert(input);
					//alert(document.forms[form_name].elements[input].value);
					if(document.forms[form_name].elements[input].value == null || document.forms[form_name].elements[input].value=='')
					{
						no_error = false;						
						add_error_style(document.forms[form_name].elements[input], checking.message);
						
					}
				}				
				else if (checking.limit == 'selected')
				{					
					if (document.forms[form_name].elements[input].checked == false)
					{
						no_error = false;						
						add_error_style(document.forms[form_name].elements[input], checking.message);
						
					}
				}								
				else if (checking.limit == 'string_empty')
				{					
					//anything
				}
				else if (checking.limit == 'login')
				{
					if(!login_regexp.test(document.forms[form_name].elements[input].value))
					{
						no_error = false;
						add_error_style(document.forms[form_name].elements[input], checking.message);
					}					
				}
				else if (checking.limit == 'nick')
				{
					if(!login_regexp.test(document.forms[form_name].elements[input].value))
					{
						no_error = false;
						add_error_style(document.forms[form_name].elements[input], checking.message);
					}
				}
				else if (checking.limit == 'password')
				{
					if(!password_regexp.test(document.forms[form_name].elements[input].value))
					{
						no_error = false;
						add_error_style(document.forms[form_name].elements[input], checking.message);
					}
				}
				else if(checking.limit == 'integer')
				{
					//alert(document.forms[form_name].elements[input]);
					if(!integer_regexp.test(document.forms[form_name].elements[input].value))
					{
						no_error = false;
						add_error_style(document.forms[form_name].elements[input], checking.message);
					}
				}
				else if(checking.limit == 'integer_empty')
				{
					if(document.forms[form_name].elements[input].value.length>0  && !integer_regexp.test(document.forms[form_name].elements[input].value))
					{
						no_error = false;
						add_error_style(document.forms[form_name].elements[input], checking.message);
					}
				}
				else if(checking.limit == 'date')
				{
					if(!date_regexp.test(document.forms[form_name].elements[input].value))
					{
						no_error = false;
						add_error_style(document.forms[form_name].elements[input], checking.message);
					}
				}
				else if(checking.limit == 'date_empty')
				{
					if(document.forms[form_name].elements[input].value.length > 0 && !date_regexp.test(document.forms[form_name].elements[input].value))
					{
						no_error = false;
						add_error_style(document.forms[form_name].elements[input], checking.message);
					}
				}
				else if(checking.limit == 'year')
				{
					if(!year_regexp.test(document.forms[form_name].elements[input].value))
					{
						no_error = false;
						add_error_style(document.forms[form_name].elements[input], checking.message);
					}
				}
				else if(checking.limit == 'year_empty')
				{
					if(document.forms[form_name].elements[input].value.length > 0 && !year_regexp.test(document.forms[form_name].elements[input].value))
					{
						no_error = false;
						add_error_style(document.forms[form_name].elements[input], checking.message);
					}
				}
				else if(checking.limit == 'date_empty')
				{
					if(document.forms[form_name].elements[input].value.length>0  && !date_regexp.test(document.forms[form_name].elements[input].value))
					{
						no_error = false;
						add_error_style(document.forms[form_name].elements[input], checking.message);
					}
				}
				else if(checking.limit == 'numeric')
				{
					if(!numeric_regexp.test(document.forms[form_name].elements[input].value))
					{
						no_error = false;
						add_error_style(document.forms[form_name].elements[input], checking.message);
					}
				}
				else if(checking.limit == 'numeric_empty')
				{
					if(document.forms[form_name].elements[input].value.length>0  && !numeric_regexp.test(document.forms[form_name].elements[input].value))
					{
						no_error = false;
						add_error_style(document.forms[form_name].elements[input], checking.message);
					}
				}
				else if(checking.limit == 'email')
				{
					//alert(document.forms[form_name].elements[input].value.length);
					if(!mail_regexp.test(document.forms[form_name].elements[input].value))
					{
						no_error = false;
						add_error_style(document.forms[form_name].elements[input], checking.message);
					}
				}
				else if(checking.limit == 'email_empty')
				{
					//alert(document.forms[form_name].elements[input].value.length);
					if(!mail_regexp.test(document.forms[form_name].elements[input].value) && document.forms[form_name].elements[input].value.length > 0)
					{
						no_error = false;
						add_error_style(document.forms[form_name].elements[input], checking.message);
					}
				}
				else if(checking.limit == 'password_register')
				{
					//alert(document.forms[form_name].elements[input].value);
					//alert(document.forms[form_name].elements['retype_' + input].value);
					if(!password_regexp.test(document.forms[form_name].elements[input].value))
					{
						no_error = false;
						add_error_style(document.forms[form_name].elements[input], checking.message);
					}
					else if(!password_regexp.test(document.forms[form_name].elements['retype_' + input].value))
					{
						no_error = false;
						add_error_style(document.forms[form_name].elements['retype_' + input], checking.message);
					}					
					else if(document.forms[form_name].elements[input].value != document.forms[form_name].elements['retype_' + input].value)
					{
						no_error = false;
						add_error_style(document.forms[form_name].elements[input], 'Password mismatch');
					}
				}
				else if(checking.limit == 'email_register')
				{
					//alert(document.forms[form_name].elements[input].value);
					//alert(document.forms[form_name].elements['retype_' + input].value);
					if(!mail_regexp.test(document.forms[form_name].elements[input].value))
					{
						no_error = false;
						add_error_style(document.forms[form_name].elements[input], checking.message);
					}
					else if(!mail_regexp.test(document.forms[form_name].elements['retype_' + input].value))
					{
						no_error = false;
						add_error_style(document.forms[form_name].elements['retype_' + input], checking.message);
					}					
					else if(document.forms[form_name].elements[input].value != document.forms[form_name].elements['retype_' + input].value)
					{
						no_error = false;
						add_error_style(document.forms[form_name].elements[input], 'Email mismatch');
					}
				}
				else if (checking.limit == 'url')
				{
		
					if (!url_regexp.test(document.forms[form_name].elements[input].value))
					{
						no_error = false;
						add_error_style(document.forms[form_name].elements[input], checking.message);				
					}
				}
				else if (checking.limit == 'notempty')
				{					
					if (!document.forms[form_name].elements[input].value)
					{						
						no_error = false;
						add_error_style(document.forms[form_name].elements[input], checking.message);
					}
				}				
			}
		}
		/*if(no_error)
			alert('in check function');
		else
			alert(inputsWithErrors.length);
			alert(inputsWithErrors[0]['name']);*/
		//alert(no_error);
		return no_error;
		//return false;
	}
	
	this.check = check;
	
	function clear_errors()
	{
		for(var wp = 0; wp < inputsWithErrors.length; wp++) 
		{
	    	    if(typeof(inputsWithErrors[wp]) != 'undefined' && typeof(inputsWithErrors[wp].parentNode) != 'undefined' && inputsWithErrors[wp].parentNode != null)
	    	    {
	        	inputsWithErrors[wp].parentNode.removeChild(inputsWithErrors[wp].parentNode.lastChild);
	    	    }
		}
		this.focus = false;
		inputsWithErrors = new Array();
	}
	
	function add_error_style(input, txt) 
    {
		var style = "FFFFFF";//get_current_bgcolor(input);
	        if (!this.focus) 
	        {
	        	input.focus(); 
	        	this.focus = true;
	        }
		if(input.parentNode.innerHTML.search(txt) == -1) 
		{
			var errorTextNode = null;
			if(span)
			{
				errorTextNode = document.createElement('span');
				errorTextNode.style.margin='0px';
			}
			else
			{
				errorTextNode = document.createElement('small');
			}
	            
	        errorTextNode.className = 'required_class';
		    /*if(span)
		    {
			errorTextNode.innerHTML = '<br/>' + txt;
		    }
		    else
		    {*/
			errorTextNode.innerHTML = '' + txt;
		    //}
	            input.parentNode.appendChild(errorTextNode);              
		}
	
		input.style.backgroundColor = "#FF0000";
		inputsWithErrors.push(input);
	
		for(wp = 1; wp <= 10; wp++)
		{
	        window.setTimeout('validator.fade_error_style("'+style+'", ' + wp * 10 + ')', 1000 + (wp * 50));
		}
    }
    
    this.fade_error_style = fade_error_style;
    
    
    function fade_error_style(normalStyle, percent) 
	{       
	    var errorStyle = 'c60c30';
	    var r1 = hex2dec(errorStyle.slice(0,2));
	    var g1 = hex2dec(errorStyle.slice(2,4));
	    var b1 = hex2dec(errorStyle.slice(4,6));
	    
	    var r2 = hex2dec(normalStyle.slice(0,2));
	    var g2 = hex2dec(normalStyle.slice(2,4));
	    var b2 = hex2dec(normalStyle.slice(4,6));
	
	    var pc = percent / 100;
	
	    r= Math.floor(r1+(pc*(r2-r1)) + .5);
	    g= Math.floor(g1+(pc*(g2-g1)) + .5);
	    b= Math.floor(b1+(pc*(b2-b1)) + .5);
	
	    for(var wp = 0; wp < inputsWithErrors.length; wp++) {
	            inputsWithErrors[wp].style.backgroundColor = "#" + dec2hex(r) + dec2hex(g) + dec2hex(b);
	    }
	}
	function hex2dec(hex)
	{
		return(parseInt(hex,16));
	}

	function dec2hex(dec) 
	{
		return(hexDigit[dec>>4]+hexDigit[dec&15]);
	}
	
	
	function get_current_bgcolor(input) 
	{
	    if(input.currentStyle) 
	    {// ie 
	        var style = input.currentStyle.backgroundColor;
	        return style.substring(1,7);
	    }
	    else {// moz
	        var style = '';
	        styleRGB = document.defaultView.getComputedStyle(input, '').getPropertyValue("background-color");
	        var comma = styleRGB.indexOf(',');
	       	style += dec2hex(styleRGB.substring(4, comma));
	        var commaPrevious = comma;
	        comma = styleRGB.indexOf(',', commaPrevious+1);
	        style += dec2hex(styleRGB.substring(commaPrevious+2, comma));
	        style += dec2hex(styleRGB.substring(comma+2, styleRGB.lastIndexOf(')')));
	        return style;
	    }
	}
	
}

var validator = new Validator();
