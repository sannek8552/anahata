
function add_to_wishlist_not_logged(id)
{
	var res = confirm('You should be logged in to add products to wishlist.\n\n Do you want to login now ?');
	if (res) document.location = script_url + 'Login/' + id + '.html';
	return false;
}

function add_to_wishlist(id)
{
	Lightbox.get_html('ajax_add_to_wishlist',{'id':id});
	Lightbox.get_html_callback = function()
	{
		if (Lightbox.req.responseJS.message != undefined)
		{
			alert(Lightbox.req.responseJS.message);
		}
	}
}

function add_position()
{
	var div = document.getElementById('pos_div_'+q);
	var position = document.getElementById('pos_select_'+q);
	var quantity = document.getElementById('quantity_text_'+q);
	q = q+1;
	
	var div_clone = new Element('div').injectAfter(div);//div.clone().injectAfter(div);
	div_clone.id = 'pos_div_'+q;
	var position_clone = position.clone();
	var quantity_clone = quantity.clone();
	position_clone.id = 'pos_select_'+q;
	position_clone.setProperty('name','position_id_'+q);
	//position_clone.selected = false;
	for(var i in position_clone.options)
	{
		position_clone.options[i].selected = false;
	}
	quantity_clone.id = 'quantity_text_'+q;
	quantity_clone.setProperty('name','quantity_'+q);
	quantity_clone.value = '';
	
	div_clone.appendText('Position:');
	position_clone.injectInside(div_clone);
	div_clone.appendText(' Quantity:');
	quantity_clone.injectInside(div_clone);
}

function calculate_price(id)
{
	var w = document.forms['add_product'].elements['width'].value;
	var h = document.forms['add_product'].elements['height'].value;
	
	var message = '';
	if (w == 0) message = 'Please input width\n';
	if (h == 0) message = message + 'Please input height';
	if (message != '') 
	{
		alert(message);
		return false;
	}
	
	Lightbox.get_html('ajax_calculate_price',{'width' : w,'height' : h,'id' : id});
	Lightbox.get_html_callback = function ()
	{
		if (Lightbox.req.responseJS.message != '')
		{
			alert(Lightbox.req.responseJS.message);
		}
		else
		{
			var el = document.getElementById('price_div');
			el.innerHTML = '$'+Lightbox.req.responseJS.price;
		}
	}
}