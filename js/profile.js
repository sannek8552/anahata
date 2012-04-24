

function same_as_above(obj,form)
{
	if(obj.checked)
	{
		form.elements['shipping_address'].value = form.elements['address'].value;
		form.elements['shipping_address2'].value = form.elements['address2'].value;
		form.elements['shipping_suburb'].value = form.elements['suburb'].value;
		form.elements['shipping_state'].value = form.elements['state'].value;
		form.elements['shipping_postcode'].value = form.elements['postcode'].value;
		form.elements['shipping_phone'].value = form.elements['phone'].value;
		form.elements['shipping_country'].value = form.elements['billing_country'].value;
	}
	else
	{
		form.elements['shipping_address'].value = '';
		form.elements['shipping_address2'].value = '';
		form.elements['shipping_suburb'].value = '';
		form.elements['shipping_state'].value = '';
		form.elements['shipping_postcode'].value = '';
		form.elements['shipping_phone'].value = '';
	  	form.elements['shipping_country'].value = '';
	}
}