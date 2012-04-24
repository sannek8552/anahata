
function TreeModule()
{
	//var id_prefix = 'd';
	//var opened_nodes = new Array();
	
	this.id_prefix = 'd';
	this.opened_nodes = new Array();
	this.ajax_rm = 'ajax_admin_menu';//'ajax_get_menus';
	this.root_div_id = 'root_div';
	this.title_field = 'title';
	this.id_field = 'id';
	this.parent_field = 'parent_id';	
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
	this.order_tree = order_tree;

	
	function domreadyHandler()
	{
		var send_url = ajax_prefix + '?rm='+this.ajax_rm;
		var query = {};	
		//query generates here
		query['action'] = 'init';
		//
		var fun_this = this;
		
		var req = new JsHttpRequest();
		req.onreadystatechange = function()
		{	
			 if (req.readyState == 4)
	        	{
	        		var tree = req.responseJS.tree;
	        		//var root = document.getElementById(id_prefix + 'root_div');
	        		var root = document.getElementById(fun_this.id_prefix + fun_this.root_div_id);
	        		var i;
	        		//build_tree(tree,id_prefix + 'root_div',1);
	        		fun_this.build_tree(tree,fun_this.id_prefix + fun_this.root_div_id,1);
	        		fun_this.open_node(1);
	        	}
		}
		req.caching = false;
	    req.open('GET', send_url, true);
	    req.send({ q: query});
	    return false;

	}
	
	function refresh_menu(menu_id)
	{
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
	        		var menu = req.responseJS.menu;
	        		var id = 'a'+menu[fun_this.id_field];
	        		var elem = $(id);
	        		if(elem != null)
	        			elem.innerHTML = menu[fun_this.title_field];
	        	}
		}
		req.caching = false;
	    req.open('GET', send_url, true);
	    req.send({ q: query});
	    return false;
	}
	
	function refresh_tree(parent_id)
	{
		var send_url = ajax_prefix + '?rm='+this.ajax_rm;//ajax_refresh_tree';//ajax_prefix + 'index.php?rm=ajax_get_menus';
		var query = {};	
		//query generates here
		query['id'] = parent_id;
		query['action'] = 'refresh_tree';
		//
		var fun_this = this;
		
		var req = new JsHttpRequest();
		req.onreadystatechange = function()
		{	
			 if (req.readyState == 4)
			 	{
	        		var tree = req.responseJS.tree;	        		
	        		var parent = document.getElementById(fun_this.id_prefix + parent_id);
	        		fun_this.clear_menu_item(parent_id);	        		
	        		if (req.responseJS.success == 1)
	        		{
	        			fun_this.build_tree(tree,fun_this.id_prefix + parent_id,0);
	        		}
	        	}
		}
		req.caching = false;
	    req.open('GET', send_url, true);
	    req.send({ q: query});
	    return false;
	}

	function clear_menu_item(id)
	{
		var elem = $(this.id_prefix + id);
		if (elem != undefined && elem.lastChild != undefined)
		{
			var child = elem.lastChild;
			while(child.id != 'ad'+id && child.id != 'im'+id)
			{
				elem.removeChild(child);
				var child = elem.lastChild;
			}
		}
	}
	
	function build_tree(sub_tree,parent_div_id,full_tree)
	{
		var i;
		for(i in sub_tree)
		{
			var cur_div = new Element('div');		
			cur_div.id = this.id_prefix+sub_tree[i][this.id_field];		
			cur_div.className = 'submenu';
			if (full_tree == 1)		
			{
				if (parent_div_id != this.id_prefix+this.root_div_id)
					cur_div.style.display = 'none';
			}
			else if (this.opened_nodes[sub_tree[i][this.parent_field]] != 1)
					cur_div.style.display = 'none';
			parent_div = $(parent_div_id);
			if(parent_div != null)
			parent_div.appendChild(cur_div);		
			this._generate_menu_item(sub_tree[i][this.id_field],sub_tree[i][this.title_field]);
			if (sub_tree[i]['sub'] != undefined)
				this.build_tree(sub_tree[i]['sub'],this.id_prefix+sub_tree[i][this.id_field],full_tree);
		}
	}
	
	function _generate_menu_item(id,title)
	{		
		var fun_this = this;
		var parent_el = document.getElementById(this.id_prefix+id);
		var img_div = new Element('div');
		//plus image
		var img_el = new Element('img');
		img_el.id = 'im'+id;
		if (this.opened_nodes[id] != 1)
			img_el.src = img_prefix + 'plusnode.gif';
		else 	img_el.src = img_prefix + 'minusnode.gif';

		img_el.addEvents({'click':function(c_id,fun_this){fun_this.open_node(c_id);}.pass([id,fun_this])});
		img_el.setStyles({float:'left'});
		parent_el.appendChild(img_el);
		
		//page image
		var page_img = new Element('img');
		page_img.id = 'pimg'+id;
		page_img.src = img_prefix + 'page-html.gif';		
		page_img.setStyle('float','left');
		page_img.addEvents({'click':function(c_id,fun_this){fun_this._show_menu_box(c_id);return false;}.pass([id,fun_this])});
		parent_el.appendChild(page_img);
		
		var a_div = new Element('div');
		a_div.id = "ad"+id;
		parent_el.appendChild(a_div);
		var a_el = new Element('a');
		a_el.innerHTML = title;
		a_el.id = 'a'+id;
		a_el.name = 'a'+id;
		a_el.href = "javascript:void(0)";		
		//a_el.addEvents({'click':function(c_id,fun_this){fun_this._show_menu_box(c_id);return false;}.pass([id,fun_this])});
		a_el.addEvents({'click':function(c_id,fun_this){cms.info_item(c_id);fun_this.close_menu_box();return false;}.pass([id,fun_this])});
		a_div.appendChild(a_el);
		
		var up_elem = new Element('img');
		up_elem.id = 'up'+id;
		up_elem.alt = 'up';
		up_elem.src = img_prefix + 'arrow_up.png';
		up_elem.addEvents({'click':function(c_id,fun_this){fun_this.menu_move_up(c_id);}.pass([id,fun_this])});
		
		a_div.appendChild(up_elem);
		
		var down_elem = new Element('img');
		down_elem.alt = 'down';	
		down_elem.src = img_prefix + 'arrow_down.png';
		down_elem.addEvents({'click':function(c_id,fun_this){fun_this.menu_move_down(c_id);}.pass([id,fun_this])});
		a_div.appendChild(down_elem);
		
		var move_elem = new Element('img');
		move_elem.alt = 'move';
		move_elem.src = img_prefix + 'sitemap.png';
		move_elem.addEvents({'click':function(c_id,fun_this){fun_this.order_tree(c_id);}.pass([id,fun_this])});
		a_div.appendChild(move_elem);
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
			
			var coords = myParent.getCoordinates();
			drop_el.className = 'menu_box_class';
			var fun_this = this;
	
			//generate menu box rows
				var row4 = new Element('div');
				row4.className = 'menu_box_row';
				row4.innerHTML = '<img src="'+img_prefix+'context_view.gif" alt="view" /> View document';
				row4.addEvents({'mouseover':function (){this.className = 'menu_box_row_over';},'mouseout':function() {this.className = 'menu_box_row';}});
				row4.addEvents({'click':function(c_id,fun_this){cms.view_item(c_id);fun_this.close_menu_box();return false;}.pass([id,fun_this])});
				drop_el.appendChild(row4);			
			
				var row1 = new Element('div');
				row1.className = 'menu_box_row';
				row1.innerHTML = '<img src="'+img_prefix+'save.gif" alt="edit" /> Edit document';
				row1.addEvents({'mouseover':function (){this.className = 'menu_box_row_over';},'mouseout':function() {this.className = 'menu_box_row';}});
				row1.addEvents({'click':function(c_id,fun_this){cms.edit_item(c_id);fun_this.close_menu_box();return false;}.pass([id,fun_this])});				
				drop_el.appendChild(row1);
				
				var row2 = new Element('div');
				row2.innerHTML = '<img src="'+img_prefix+'cancel.gif" alt="delete" /> Delete document';
				row2.addEvents({'mouseover':function (){this.className = 'menu_box_row_over';},'mouseout':function() {this.className = 'menu_box_row';}});
				row2.addEvents({'click':function(c_id,fun_this){if(!confirm('Are you sure?')){return false;};cms.delete_item(c_id);fun_this.close_menu_box();return false;}.pass([id,fun_this])});
				drop_el.appendChild(row2);
				
				var row3 = new Element('div');
				row3.innerHTML = '<img src="'+img_prefix+'newdoc.gif" alt="new" /> Add document';
				row3.addEvents({'mouseover':function (){this.className = 'menu_box_row_over';},'mouseout':function() {this.className = 'menu_box_row';}});
				row3.addEvents({'click':function(c_id,fun_this){cms.new_item(c_id);fun_this.close_menu_box();return false;}.pass([id,fun_this])});
				drop_el.appendChild(row3);
				
				var row5 = new Element('div');
				row5.className = 'separator';
				drop_el.appendChild(row5);
				
				var row6 = new Element('div');
				row6.innerHTML = '<img src="'+img_prefix+'delete.gif" alt="new" /> Deactivate document';
				row6.addEvents({'mouseover':function (){this.className = 'menu_box_row_over';},'mouseout':function() {this.className = 'menu_box_row';}});
				row6.addEvents({'click':function(c_id,fun_this){cms.active_item(c_id,0);fun_this.close_menu_box();return false;}.pass([id,fun_this])});
				drop_el.appendChild(row6);
				
				var row7 = new Element('div');
				row7.innerHTML = '<img src="'+img_prefix+'b092.gif" alt="new" /> Activate document';
				row7.addEvents({'mouseover':function (){this.className = 'menu_box_row_over';},'mouseout':function() {this.className = 'menu_box_row';}});
				row7.addEvents({'click':function(c_id,fun_this){cms.active_item(c_id,1);fun_this.close_menu_box();return false;}.pass([id,fun_this])});
				drop_el.appendChild(row7);
				
				var row8 = new Element('div');
				row8.className = 'separator';
				drop_el.appendChild(row8);
				
				var row9 = new Element('div');
				row9.innerHTML = '<img src="'+img_prefix+'date.gif" alt="pub" /> Publish document';
				row9.addEvents({'mouseover':function (){this.className = 'menu_box_row_over';},'mouseout':function() {this.className = 'menu_box_row';}});
				row9.addEvents({'click':function(c_id,fun_this){cms.publish_item(c_id,1);fun_this.close_menu_box();return false;}.pass([id,fun_this])});
				drop_el.appendChild(row9);
				
				var row10 = new Element('div');
				row10.innerHTML = '<img src="'+img_prefix+'date.gif" alt="unpub" /> Unpublish document';
				row10.addEvents({'mouseover':function (){this.className = 'menu_box_row_over';},'mouseout':function() {this.className = 'menu_box_row';}});
				row10.addEvents({'click':function(c_id,fun_this){cms.publish_item(c_id,0);fun_this.close_menu_box();return false;}.pass([id,fun_this])});
				drop_el.appendChild(row10);
				
			
				/*			
				var li_el = new Element('li');
				var a_el = new Element('a');
				li_el.appendChild(a_el);
				a_el.href = "javascript:void(0)";
				a_el.addEvents({'click':function(c_id,fun_this){cms.edit_item(c_id);fun_this.close_menu_box();return false;}.pass([id,fun_this])});
				a_el.innerHTML = "Edit";
				drop_el.appendChild(li_el);
			
				var li_el = new Element('li');
				var a_el = new Element('a');
				li_el.appendChild(a_el);
				a_el.href = "javascript:void(0)";
				a_el.addEvents({'click':function(c_id,fun_this){cms.delete_item(c_id);fun_this.close_menu_box();return false;}.pass([id,fun_this])});
				a_el.innerHTML = "Delete";
				
				drop_el.appendChild(li_el);
	
				var li_el = new Element('li');
				var a_el = new Element('a');
				li_el.appendChild(a_el);
				a_el.href = "javascript:void(0)";
				a_el.addEvents({'click':function(c_id,fun_this){cms.new_item(c_id);fun_this.close_menu_box();return false;}.pass([id,fun_this])});
				a_el.innerHTML = "Add Submenu";
				drop_el.appendChild(li_el);
				*/
				
			
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
				img_el.src = img_prefix + 'plusnode.gif';
				this.opened_nodes[id] = 0;
			}
			else
			{
				img_el.src = img_prefix + 'minusnode.gif';
				this.opened_nodes[id] = 1;
				displ = '';
			}
			var childs = cur_div.childNodes;
			var i;
			for(i=3;i<childs.length;i++)
				childs[i].style.display = displ;
	}
	
	function menu_move_up(id)
	{
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
	        		fun_this.refresh_tree(1);
	        		//
	        	}
		}
		req.caching = false;
	    req.open('GET', send_url, true);
	    req.send({ q: query});
	    return false;
	}
	
	function menu_move_down(id)
	{
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
	        		fun_this.refresh_tree(1);
	        		//
	        	}
		}
		req.caching = false;
	    req.open('GET', send_url, true);
	    req.send({ q: query});
	    return false;
	}
	
	function order_tree(id)
	{
		Lightbox.get_html(this.ajax_rm,{'action':'order_tree','id':id});
	}
}

var tree = new TreeModule();

window.addEvent('domready', function(){
	tree.domreadyHandler();
});

function expand_node(id)
{
	if($('node'+id).style.display == 'block')
	{
		close_node(id);
	}
	else
	{
		$('img'+id).src = im_url+'minusnode.gif';
		//$('img'+id).addEvent('click',close_node.pass([id]));
		if ($('node'+id) != undefined)	$('node'+id).setStyle('display','block');
	}
	/*var eve = new Event(ev);
	eve.stop();
	eve.stopPropagation();*/
	//alert(id);
}

var just_open;

function close_node(id)
{
	//alert('close' + id);
	/*if(just_open == true)
	{
		just_open = false;
		return;
	}*/
	$('img'+id).src = im_url+'plusnode.gif';
	//$('img'+id).addEvent('click',expand_node.pass([id]));
	if ($('node'+id) != undefined)	$('node'+id).setStyle('display','none');
	
}

function change_back(elem,id)
{
	move_id = id;
	$ES('div','parent_el').each(function(item){item.setStyle('background','#ffffff')});
	elem.setStyle('background','#00ff00');
}

function move_here()
{
	if (move_id != undefined)
	{
		Lightbox.close();
		Lightbox.get_html(tree.ajax_rm,{'action':'move_node','id':cur_node,'parent_id':move_id});
		Lightbox.get_html_callback = function()
		{
			tree.refresh_tree(1);
		}
	}
	else alert('select new parent node');
	
}

var im_url;
var move_id;
var cur_node;