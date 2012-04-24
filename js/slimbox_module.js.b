

var Slimbox = {

	init: function(options){
		this.req = {};
		this.options = $extend({
			resizeDuration: 400,
			resizeTransition: false,	// default transition
			initialWidth: 350,
			initialHeight: 210,
			animateCaption: true,
			showCounter: false
		}, options || {});
		
		
		this.anchors = [];
		$each(document.links, function(el){
			if (el.rel && el.rel.test(/^slimbox/i)){
				el.onclick = this.click.pass(el, this);
				this.anchors.push(el);
			}
		}, this);
		
		
		this.eventKeyDown = this.keyboardListener.bindAsEventListener(this);
		this.eventPosition = this.position.bind(this);		
		this.overlay = new Element('div', {'id': 'lbOverlay', 'styles': {'z-index':1000}}).injectInside(document.body);
		this.center = new Element('div', {'id': 'lbCenter', 'styles': {'width': this.options.initialWidth, 'height': this.options.initialHeight, 'marginLeft': -(this.options.initialWidth/2), 'display': 'none','z-index':999}}).injectInside(document.body);
		this.bottomContainer = new Element('div', {'id': 'lbBottomContainer', 'styles': {'display': 'none'}}).injectInside(document.body);
		this.bottom = new Element('div', {'id': 'lbBottom'}).injectInside(this.bottomContainer);
		new Element('a', {'id': 'lbCloseLink', 'href': '#'}).injectInside(this.bottom).onclick = this.overlay.onclick = "";this.close.bind(this);
		this.caption = new Element('div', {'id': 'lbCaption'}).injectInside(this.bottom);
		this.number = new Element('div', {'id': 'lbNumber'}).injectInside(this.bottom);
		new Element('div', {'styles': {'clear': 'both'}}).injectInside(this.bottom);

		var nextEffect = this.nextEffect.bind(this);
		this.fx = {
			overlay: this.overlay.effect('opacity', {duration: 500}).hide(),
			resize: this.center.effects($extend({duration: this.options.resizeDuration, onComplete: nextEffect}, this.options.resizeTransition ? {transition: this.options.resizeTransition} : {})),
			bottom: this.bottom.effect('margin-top', {duration: 400, onComplete: nextEffect})
		};
	},

	show: function(inner_div){
		return this.open(inner_div);
	},
	
	open: function(inner_div){
		this.position();
		this.setup(true);
		this.top = window.getScrollTop() + (window.getHeight() / 15);
		this.center.setStyles({top: this.top, display: ''});
		this.fx.overlay.start(0.8);
		
		test_slimbox(inner_div);
		return false;
	},

	position: function(){
		this.overlay.setStyles({'top': window.getScrollTop(), 'height': window.getHeight()});
	},

	setup: function(open){		
		var fn = open ? 'addEvent' : 'removeEvent';
		window[fn]('scroll', this.eventPosition)[fn]('resize', this.eventPosition);
		//document[fn]('keydown', this.eventKeyDown);
		this.step = 0;
	},
	keyboardListener: function(event){
		switch (event.keyCode){
			/*
			case 27: case 88: case 67: this.close(); break;
			case 37: case 80: this.previous(); break;	
			case 39: case 78: this.next();
			*/
		}
	},

	previous: function(){
		return this.changeImage(this.activeImage-1);
	},

	next: function(){
		return this.changeImage(this.activeImage+1);
	},

	changeImage: function(imageNum){
		if (this.step || (imageNum < 0) || (imageNum >= this.images.length)) return false;
		this.step = 1;
		this.activeImage = imageNum;

		this.bottomContainer.style.display = 'none';// this.prevLink.style.display = this.nextLink.style.display = 'none';
		this.fx.image.hide();
		this.center.className = 'lbLoading';

		this.preload = new Image();
		this.preload.onload = this.nextEffect.bind(this);
		this.preload.src = this.images[imageNum][0];
		return false;
	},

	nextEffect: function(){
		switch (this.step++){
		case 1:
			this.center.className = '';
			//this.image.style.backgroundImage = 'url('+this.images[this.activeImage][0]+')';
			//this.image.style.width = this.bottom.style.width = this.preload.width+'px';
			//this.image.style.height = this.preload.height+'px'; //this.prevLink.style.height = this.nextLink.style.height = 

			this.caption.setHTML(this.images[this.activeImage][1] || '');
			this.number.setHTML((!this.options.showCounter || (this.images.length == 1)) ? '' : 'Image '+(this.activeImage+1)+' of '+this.images.length);

			if (this.activeImage) this.preloadPrev.src = this.images[this.activeImage-1][0];
			if (this.activeImage != (this.images.length - 1)) this.preloadNext.src = this.images[this.activeImage+1][0];
			if (this.center.clientHeight != this.image.offsetHeight){
				this.fx.resize.start({height: this.image.offsetHeight});
				break;
			}
			this.step++;
		case 2:
			if (this.center.clientWidth != this.image.offsetWidth){
				this.fx.resize.start({width: this.image.offsetWidth, marginLeft: -this.image.offsetWidth/2});
				break;
			}
			this.step++;
		case 3:
			this.bottomContainer.setStyles({top: this.top + this.center.clientHeight, height: 0, marginLeft: this.center.style.marginLeft, display: ''});
			this.fx.image.start(1);
			break;
		case 4:
			if (this.options.animateCaption){
				this.fx.bottom.set(-this.bottom.offsetHeight);
				this.bottomContainer.style.height = '';
				this.fx.bottom.start(0);
				break;
			}
			this.bottomContainer.style.height = '';
		case 5:
			//if (this.activeImage) this.prevLink.style.display = '';
			//if (this.activeImage != (this.images.length - 1)) this.nextLink.style.display = '';
			this.step = 0;
		}
	},

	close: function(){
		if (this.step < 0) return;
		this.step = -1;
		if (this.preload){
			this.preload.onload = Class.empty;
			this.preload = null;
		}
		for (var f in this.fx) this.fx[f].stop();
		this.center.style.display = this.bottomContainer.style.display = 'none';
		this.fx.overlay.chain(this.setup.pass(false, this)).start(0);
		return false;
	},
	
	get_html: function(runmode_name,params){
		
		    if (params == null) params = {};
		    body_blocker.create_block();
		    var send_url = ajax_prefix+'index.php?rm='+runmode_name;
	            var req = new JsHttpRequest();
                    req.onreadystatechange = function()
                    {
                      if (req.readyState == 4)
                      {
                      	
                      	//alert(req.responseText);
		                //result process here
		                Slimbox.req = req;
		                
		                //var success = 1;
		                //if (req.responseJS.success != null)
						if (req.responseJS.success == null) var success = 0;
            			else var success = req.responseJS.success;	
		                if (success == 1)
		                {
		                  	Slimbox.close();
		                }
						else
						{
						  var html = req.responseJS.html;
						  if(req.responseJS.text_to_init)
						  {
						  	init_js(req.responseJS.text_to_init);
						  	//alert(req.responseJS.text_to_init);
						  }
						  var elem = new Element('div');
						  elem.innerHTML = html;
						  Slimbox.show(elem);
						}
						body_blocker.remove_block();
						Slimbox.get_html_callback();
		      			Slimbox.get_html_callback = function(req){};
                      }
                    }
                    req.caching = false;
                    req.open('GET', send_url, true);
                    req.send({ q: params});
	},
	
	submit_form: function(form,runmode_name)
	{
	  body_blocker.create_block();
	  var params = {};
	  for(var i = 0; i < form.elements.length; i++)
	  {
	    var element = form.elements[i];
	    var type = form.elements[i].type;
	    if (form.elements[i].tagName != 'FIELDSET' && form.elements[i].type != 'checkbox' && form.elements[i].type != 'radio')
	      params[form.elements[i].name] = form.elements[i].value;
	    
	    if (form.elements[i].type == 'textarea' && !form.elements[i].value)
	    {
		//alert(tinyMCE._cleanupHTML);
	      //params[form.elements[i].name] = tinyMCE.getContent();
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

	  var send_url = ajax_prefix+'index.php?rm='+runmode_name;

	  var req = new JsHttpRequest();
          req.onreadystatechange = function()
          {
            if (req.readyState == 4)
            {	      
			      //result process here
			Slimbox.req = req;
			//alert(req.responseText);

           // var success = 1;
            if (req.responseJS.success == null) var success = 0;
            else var success = req.responseJS.success;	
			
			if (success == 1)
			{
				Slimbox.close();
			}
	    	  	else
	      		{
				var html = req.responseJS.html;
				var elem = new Element('div');
				elem.innerHTML = html;
				Slimbox.show(elem);
	      		}
			Slimbox.submit_form_callback();
	      		body_blocker.remove_block();
	      		Slimbox.submit_form_callback = function(){};
			
            }
          }
          req.caching = false;
          req.open('POST', send_url, true);
          req.send({ q: params});
	},

	submit_form_callback: function()
	{
		//do not put any code
		//change this by javascript only
	},

	get_html_callback: function()
	{
		//do not put any code
		//change this by javascript only 
	}
};

window.addEvent('domready', Slimbox.init.bind(Slimbox));

function test_slimbox(inner_div)
{
  var main_div = $('lbCenter');
  main_div.setStyle('z-index','1900','display','');
  main_div.empty(); 
  
  if (navigator.appName == 'Microsoft Internet Explorer')
  {
    this.overframe = new Element('iframe',{'src': ajax_prefix + 'empty.html','id':'lbFrame','styles':{'z-index':'1800','position':'absolute','top':0,'left':0,'width':main_div.clientWidth,'height':main_div.clientHeight}}).injectInside(main_div);
  }  

  inner_div.setStyles({'z-index':'1950','position':'absolute','top':0,'left':0}).injectInside(main_div);

  main_div.appendChild(inner_div);

  main_div.setStyle('width',inner_div.clientWidth);
  main_div.setStyle('height',inner_div.clientHeight);
  main_div.setStyle('marginLeft',-(inner_div.clientWidth/2));

  if (navigator.appName == 'Microsoft Internet Explorer')
  {
    this.overframe.setStyle('width',inner_div.clientWidth);
    this.overframe.setStyle('height',inner_div.clientHeight);
  }
}


function init_js(text_to_init)
{
	eval(text_to_init);
}