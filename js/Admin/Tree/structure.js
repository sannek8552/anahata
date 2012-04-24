function Structure()
{
	this.id_prefix = 'd';
	this.opened_nodes = new Array();
	this.ajax_rm = 'ajax_admin_structure';//'ajax_get_menus';
	this.root_div_id = 'root_div';
	this.title_field = cfg['title_field'];
	this.id_field = cfg['key_field'];
	this.parent_field = cfg['parent_field'];
	this.domreadyHandler = domreadyHandler;
	this.refresh_menu = refresh_menu;
	this.refresh_tree = refresh_tree;
	this.clear_menu_item = clear_menu_item;
	this.build_tree = build_tree;
	this._generate_menu_item = _generate_menu_item;
	this.menu_move_up = menu_move_up;
	this.menu_move_down = menu_move_down;
	this.open_node = open_node;
	this._show_menu_box = _show_menu_box;
	this.close_menu_box = close_menu_box;
	this._drop_menu_box = _drop_menu_box;
	this.add_submenu_handler = add_submenu_handler;
	this.edit_item_handler = edit_item_handler;
	this.delete_item_handler = delete_item_handler;
	this.order_items_handler = order_items_handler;
	this.maxdepth = cfg['max_level'];
	this.curdepth = 0;
	
	function domreadyHandler()
	{
		body_blocker.create_block();
		
		var send_url = ajax_prefix + '?rm='+this.ajax_rm;
		var query = {};	
		//query generates here
		query['action'] = 'get_html';
		//
		var fun_this = this;
		
		var req = new JsHttpRequest();
		req.onreadystatechange = function()
		{	
			 if (req.readyState == 4)
	        	{
	        		//alert(req.responseText);
	        		//var tree = req.responseJS.tree;
	        		//var root = document.getElementById(id_prefix + 'root_div');
	        		var html = req.responseJS.html;
	        		
	        		var root = document.getElementById(fun_this.id_prefix + fun_this.root_div_id);
	        		root.innerHTML = html;
	        		body_blocker.remove_block();
	        	}
		}
		query['sn'] = sn;
		query['restaurant_id'] = restaurant_id;
		req.caching = false;
	    req.open('GET', send_url, true);
	    req.send({ q: query});
	    return false;

	}
	
	function refresh_menu(menu_id)
	{
		this.domreadyHandler();
		/*
		body_blocker.create_block();
		var send_url = ajax_prefix + '?rm='+this.ajax_rm;//ajax_refresh_menu';//ajax_prefix + 'index.php?rm=ajax_get_menus';
		var query = {};	
		//query generates here
		query['id'] = menu_id;
		query['action'] = 'refresh_menu';
		//
		var fun_this = this;
		
		var req = new JsHttpRequest();
		req.onreadystatechange = function()
		{	
			 if (req.readyState == 4)
	        	{
	        		alert(req.responseText);
	        		var menu = req.responseJS.menu;
	        		
		        		var id = 'a'+menu[fun_this.id_field];
		        		var elem = $(id);
		        		if (elem != undefined)
		        			elem.innerHTML = menu[fun_this.title_field];
		        		else
		        		{
		        			var parent = $(tree.id_prefix + menu[tree.parent_field]);	        			
		        			var elem = new Element('tr');
		        			parent.appendChild(elem);
		        			var td1 = elem.insertCell(0);
		        			td1.innerHTML = menu[tree.title_field];
		        			td1.id = 'a' + menu_id;
		        			var td2 = elem.insertCell(1);
		        			
		        			id = menu_id;
		        			var img = new Element('img');
							img.src = img_prefix + 'arrow_up.png';
							img.addEvent('click',function(id){tree.move_menu_up(id);}.pass([id]));
							img.alt = "Move Up";
							td2.appenndChild(img);
							
							var img = new Element('img');
							img.src = img_prefix + 'arrow_down.png';
							img.addEvent('click',function(id){tree.move_menu_down(id);}.pass([id]));
							img.alt = "Move Down";
							td2.appenndChild(img);
							
							var img = new Element('img');
							img.src = img_prefix + 'edit.gif';
							img.addEvent('click',function(id){tree.edit_menu_handler(id);}.pass([id]));
							img.alt = "Edit";
							td2.appenndChild(img);
					
							var img = new Element('img');
							img.src = img_prefix + 'delete.gif';
							img.addEvent('click',function(id){tree.delete_item_handler(id);}.pass([id]));
							img.alt = "Delete";
							td2.appenndChild(img);
		        			
		        		}
	        		body_blocker.remove_block();
	        	}
		}
		req.caching = false;
	    req.open('GET', send_url, true);
	    req.send({ q: query});
	    return false;
	    */
	}
	
	function refresh_tree(parent_id)
	{
		this.domreadyHandler();
	}

	function clear_menu_item(id)
	{
		var elem = $(this.id_prefix + id);
		var child = elem.lastChild;
		while(child.id != 'ad'+id && child.id != 'im'+id)
		{
			elem.removeChild(child);
			var child = elem.lastChild;
		}
	}
	
	function build_tree(sub_tree,parent_div_id,full_tree)
	{
		this.curdepth ++;
		var i;
		for(i in sub_tree)
		{
			var cur_div = new Element('table');		
			cur_div.id = this.id_prefix+sub_tree[i][this.id_field];		
			cur_div.depth = this.curdepth;
			cur_div.className = 'submenu';
			/*
			if (full_tree == 1)		
			{
				if (parent_div_id != this.id_prefix+this.root_div_id)
					cur_div.style.display = 'none';
			}
			else if (this.opened_nodes[sub_tree[i][this.parent_field]] != 1)
					cur_div.style.display = 'none';
			*/
			parent_div = $(parent_div_id);
			parent_div.appendChild(cur_div);
			this._generate_menu_item(sub_tree[i][this.id_field],sub_tree[i][this.title_field]);
			if (sub_tree[i]['sub'] != undefined)
			{
				this.build_tree(sub_tree[i]['sub'],this.id_prefix+sub_tree[i][this.id_field],full_tree);
				this.curdepth --;
			}
				
		}
	}
	
	function _generate_menu_item(id,title)
	{		
		var fun_this = this;
		var parent_el = document.getElementById(this.id_prefix+id);
		
		var row = parent_el.insertRow(parent_el.rows.length);
		var td1 = row.insertCell(0);
		var td2 = row.insertCell(1);
		td1.innerHTML = title;
		td1.id = this.id_prefix + id;
		
		var img = new Element('img');
		img.src = img_prefix + 'arrow_up.png';
		img.addEvent('click',function(id){tree.move_menu_up(id);}.pass([id]));
		img.alt = "Move Up";
		td2.appenndChild(img);
		
		var img = new Element('img');
		img.src = img_prefix + 'arrow_down.png';
		img.addEvent('click',function(id){tree.move_menu_down(id);}.pass([id]));
		img.alt = "Move Down";
		td2.appenndChild(img);
		
		var img = new Element('img');
		img.src = img_prefix + 'edit.gif';
		img.addEvent('click',function(id){tree.edit_menu_handler(id);}.pass([id]));
		img.alt = "Edit";
		td2.appenndChild(img);

		var img = new Element('img');
		img.src = img_prefix + 'delete.gif';
		img.addEvent('click',function(id){tree.delete_item_handler(id);}.pass([id]));
		img.alt = "Delete";
		td2.appenndChild(img);		
		
	}

	function _drop_menu_box()
	{
		var menu_box = document.getElementById('menu_box');	
		if (menu_box != undefined)	menu_box.remove();//myParent.removeChild(menu_box);
	}
	
	function close_menu_box()
	{
		var menu_box = $('menu_box');
		if (menu_box != undefined)
		{
			var targetValueX = menu_box.targetValueX;
			if (targetValueX != 0)
			{
				f_st = new Fx.Styles(menu_box,{duration: 500,transition: Fx.Transitions.linear});
				f_st.start({'height': 0,'width': 0});
				menu_box.targetValueX = 0;
			 	menu_box.targetValueY = 0;
			}
		}
	}
	
	function _show_menu_box(id)
	{
		var menu_box = $('menu_box');
		var show_box = 0;
		if (menu_box != undefined)
		{
			var targetValueX = menu_box.targetValueX;
			if (targetValueX != 0)
			{
				var nod = document.getElementById('ad'+id);
				if (menu_box.parentNode != nod)	show_box = 1;
			 	menu_box.targetValueX = 0;
			 	menu_box.targetValueY = 0;
				f_st = new Fx.Styles(menu_box,{duration: 500,transition: Fx.Transitions.linear});
				f_st.start({'height': 0,'width': 0});
			}
			else show_box = 1;
		}
		else show_box = 1;
		if (show_box == 1) 
		{
			this._drop_menu_box();
			var drop_el = new Element('div');
			drop_el.id = "menu_box";
			
			var myParent = document.getElementById('ad'+id);
			myParent.appendChild(drop_el);
			
			var parent_div_elem = $(this.id_prefix + id);
			
			
			var coords = myParent.getCoordinates();
			drop_el.className = 'menu_box_class';
			var fun_this = this;
				
			if (parent_div_elem.depth != undefined && parent_div_elem.depth > 2)
			{
				var li_el = new Element('li');
				var a_el = new Element('a');
				li_el.appendChild(a_el);
				a_el.href = "javascript:void(0)";
				a_el.addEvents({'click':function(c_id,fun_this){fun_this.edit_item_handler(c_id);return false;}.pass([id,fun_this])});
				a_el.innerHTML = "Edit";
				drop_el.appendChild(li_el);
			
				var li_el = new Element('li');
				var a_el = new Element('a');
				li_el.appendChild(a_el);
				a_el.href = "javascript:void(0)";
				a_el.addEvents({'click':function(c_id,fun_this){fun_this.delete_item_handler(c_id);return false;}.pass([id,fun_this])});
				a_el.innerHTML = "Delete";
				
				drop_el.appendChild(li_el);
			}	
			if (parent_div_elem.depth != undefined && parent_div_elem.depth < this.maxdepth)
			{
					var li_el = new Element('li');
					var a_el = new Element('a');
					li_el.appendChild(a_el);
					a_el.href = "javascript:void(0)";
					a_el.addEvents({'click':function(c_id,fun_this){fun_this.add_submenu_handler(c_id);return false;}.pass([id,fun_this])});
					a_el.innerHTML = "Add Submenu";
					drop_el.appendChild(li_el);
			}
			
			var size_arr = drop_el.getSize();
			var targetValueY = size_arr['size']['y'];
			var targetValueX = size_arr['size']['x'];
			
			drop_el.setStyles({'overflow':'hidden','display':'block','height':'0px','width':'0px','position':'absolute'});
			
			f_st = new Fx.Styles(drop_el,{duration: 500,transition: Fx.Transitions.linear});
			f_st.start({'height': targetValueY,'width': targetValueX});
			drop_el.targetValueX = targetValueX;
			drop_el.targetValueY = targetValueY;
		}
	}
	
	function open_node(id,act)
	{
			var cur_div = document.getElementById(this.id_prefix+id);
			var img_el = document.getElementById('im'+id);
			var displ = 'none';
			if (this.opened_nodes[id] != undefined && this.opened_nodes[id] != 0)
			{
				img_el.src = img_prefix + 'plus.gif';
				this.opened_nodes[id] = 0;
			}
			else
			{
				img_el.src = img_prefix + 'minus.gif';
				this.opened_nodes[id] = 1;
				displ = '';
			}
			var childs = cur_div.childNodes;
			var i;
			for(i=2;i<childs.length;i++)
				childs[i].style.display = displ;
	}
	
	function menu_move_up(id)
	{
		body_blocker.create_block();
		
		
		var send_url = ajax_prefix + 'index.php?rm='+this.ajax_rm;//ajax_move_up_menu';
		var query = {};
		//query generates here
		query['id'] = id;
		query['action'] = 'menu_move_up';
		//
		var fun_this = this;
		
		var req = new JsHttpRequest();
		req.onreadystatechange = function()
		{
			 if (req.readyState == 4)
	        	{
	        		//result process here
	        		var success = req.responseJS.success;
	        		//fun_this.refresh_tree(1);
	        		fun_this.refresh_tree(0);
	        		body_blocker.remove_block();
	        		//
	        	}
		}
		query['sn'] = sn;
		query['restaurant_id'] = restaurant_id;
		req.caching = false;
	    req.open('GET', send_url, true);
	    req.send({ q: query});
	    return false;
	}
	
	function menu_move_down(id)
	{
		body_blocker.create_block();
		var send_url = ajax_prefix + 'index.php?rm='+this.ajax_rm;//ajax_move_down_menu';
		var query = {};
		//query generates here
		query['id'] = id;
		query['action'] = 'menu_move_down';
		//
		var fun_this = this;
		
		var req = new JsHttpRequest();
		req.onreadystatechange = function()
		{
			 if (req.readyState == 4)
	        	{
	        		//result process here
	        		var success = req.responseJS.success;
	        		//fun_this.refresh_tree(1);
	        		fun_this.refresh_tree(0);
	        		body_blocker.remove_block();
	        		//
	        	}
		}
		query['sn'] = sn;
		query['restaurant_id'] = restaurant_id;
		req.caching = false;
	    req.open('GET', send_url, true);
	    req.send({ q: query});
	    return false;
	}
	
	function add_submenu_handler(id)
	{
		var query = {};
		query['action'] = 'get_add_form';
		query['id'] = id;
		query['sn'] = sn;
		query['restaurant_id'] = restaurant_id;
		Lightbox.get_html_callback = function() {validator.add('car_model_add');if (Lightbox.req.responseJS.js_text != undefined) eval(Lightbox.req.responseJS.js_text);};
		Lightbox.get_html(this.ajax_rm,query);
		this.close_menu_box();
	}
	
	function edit_item_handler(id)
	{
		var query = {};
		query['action'] = 'get_edit_form';
		query['id'] = id;
		query['sn'] = sn;
		query['restaurant_id'] = restaurant_id;
		Lightbox.get_html_callback = function() 
		{
			validator.add('car_model_edit');		
			if (Lightbox.req.responseJS.js_text != undefined) 
			{
				//alert(Lightbox.req.responseJS.js_text);
				eval(Lightbox.req.responseJS.js_text);
			}
		};
		Lightbox.get_html(this.ajax_rm,query);
		
		//this.close_menu_box();
	}
	
	function delete_item_handler(id)
	{
		if (!confirm('Are you sure?')) return false;
		body_blocker.create_block();
		
		var send_url = ajax_prefix + 'index.php?rm='+this.ajax_rm;//ajax_move_down_menu';
		var query = {};
		//query generates here
		query[this.id_field] = id;
		query['action'] = 'delete';
		//
		var f_this = this;
		var req = new JsHttpRequest();
		req.onreadystatechange = function()
		{
			if (req.readyState == 4)
	        	{
	        		//result process here
	        		var success = req.responseJS.success;
	        		if (success)
	        		{
	        			//f_this.refresh_tree(1);
	        			f_this.refresh_tree(0);
	        			Lightbox.close();
	        		}
					body_blocker.remove_block();
	        		//
	        	}
		}
		query['sn'] = sn;
		query['restaurant_id'] = restaurant_id;
		req.caching = false;
	    req.open('GET', send_url, true);
	    req.send({ q: query});
		this.close_menu_box();
	}
	
	function order_items_handler(id)
	{
		body_blocker.create_block();
		
		var query = {};
		query['id'] = id;
		query['data'] = {};
		$('droot_div').getElements('input[id^='+id+'input]').each(function(item, index)
		{query['data'][item.id] = item.value;});
		var send_url = ajax_prefix + 'index.php?rm='+this.ajax_rm;
		query['action'] = 'order';
		//
		var f_this = this;
		var req = new JsHttpRequest();
		req.onreadystatechange = function()
		{
			if (req.readyState == 4)
	        	{
	        		//result process here
	        		var success = req.responseJS.success;
	        		if (success)
	        		{
	        			//f_this.refresh_tree(1);
	        			f_this.refresh_tree(0);
	        			Lightbox.close();
	        		}
					body_blocker.remove_block();
	        		//
	        	}
		}
		query['sn'] = sn;
		query['restaurant_id'] = restaurant_id;
		req.caching = false;
	    req.open('POST', send_url, true);
	    req.send({ q: query});
	}

}

var tree = new Structure();

window.addEvent('domready', function(){
	tree.domreadyHandler();
	Lightbox.init.bind(Lightbox);
});