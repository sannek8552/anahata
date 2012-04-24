

function check_username(form,element)
{
	var elem = document.forms[form].elements[element];
	var username = elem.value;
	if (username == '') return false;
	var params = {'username':username};
    var send_url = ajax_prefix+'index.php?rm=ajax_check_username';
    var req = new JsHttpRequest();
    req.onreadystatechange = function()
       {
         if (req.readyState == 4)
           {
				var coordinates = elem.getCoordinates();
				var old_modal = $('modal');
				if (old_modal != undefined) old_modal.dispose();
				
				modal = new Element("div", {
        					id: "modal",
        					styles: {
            				position: "absolute",
            				top: coordinates.top,
            				left: coordinates.right,
            				width: 150,
            				height: 25,            				
            				"text-align":'center',            				
            				"z-index": 100      				
        		},
        		opacity: 1,         
    			});
		    	modal.set('html',req.responseJS.message);
		    	if (req.responseJS.available == 1) modal.setStyle('background-color','#CCFFCC');
		    	else modal.setStyle('background-color','#FF99CC');
		    	modal.inject(document.body);
		    	var fx = new Fx.Morph(modal,{duration:2000,transition: Fx.Transitions.Sine.easeOut});
		    	fx.start({'background-color':'#FFFFFF'});
           }
	}
    req.caching = false;
    req.open('GET', send_url, true);
    req.send({ q: params});
}