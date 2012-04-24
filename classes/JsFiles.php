<?php
class JsFiles
{

	/*
	format: 'js name' => array('p' => value,'v' => value,'d' => array or string);
	where p is path to javascript in js folder
	v is version of file
	d is dependicies, if file have more then one dependice should be array

	that array will be filled more while js files will be required and more files will be written
	*/

	static $js_list = array(
		'animation' => array('p' => 'yui/animation/animation-min.js','v' => 0,'f' => 0),
		'helper' => array('p' => 'helper.js', 'v' => 0,'f' => 0),
		//'icon_const' => array('p' => 'const.js', 'v' => 1,'f' => 0),
		'tiny_mce' => array('p' => 'tiny_mce/tiny_mce.js', 'v' => 0,'f' => 0),
		'validator' => array('p' => 'validator_o.js', 'v' => 0,'f' => 0),
		'blocker' => array('p' => 'body_blocker.js', 'v' => 0,'f' => 0),
		//'blocker' => array('p' => 'body_blocker.js', 'v' => 0),
		'ajax' => array('p' => 'AJAX.js', 'v' => 0,'f' => 0),
		'yahoo' => array('p' => 'http://yui.yahooapis.com/2.7.0/build/yahoo/yahoo-min.js', 'v' => 0,'d' => array('const','helper'),'f' => 1),
		'yahoo_dom' => array('p'=>'http://yui.yahooapis.com/2.7.0/build/dom/dom-min.js', 'v' => 0, 'd' => 'yahoo','f' => 1),
		'menu-min' => array('p'=>'http://yui.yahooapis.com/2.7.0/build/menu/menu-min.js','v'=>0,'d'=> array('treeview-min','container_core-min'), 'c' => 'http://yui.yahooapis.com/2.7.0/build/menu/assets/skins/sam/menu.css','f' => 1),
		'menu-folders' => array('p'=>'http://yui.yahooapis.com/2.7.0/build/menu/menu-min.js','v'=>0,'d'=> array('treeview-folders','container_core-min'), 'c' => 'http://yui.yahooapis.com/2.7.0/build/menu/assets/skins/sam/menu.css','f' => 1),
		'treeview-min' => array('p'=>'http://yui.yahooapis.com/2.7.0/build/treeview/treeview-min.js','v'=>0, 'c' => 'http://yui.yahooapis.com/2.7.0/build/treeview/assets/skins/sam/treeview.css','f' => 1),
		'treeview-folders' => array('p'=>'http://yui.yahooapis.com/2.7.0/build/treeview/treeview-min.js','v'=>0, 'c' => 'http://yui.yahooapis.com/2.7.0/build/treeview/assets/skins/sam/treeview-folders.css','f' => 1),
		'container_core-min' => array('p'=>'http://yui.yahooapis.com/2.7.0/build/container/container_core-min.js','v'=>0,'f' => 1),
		'datatable' => array('p' => 'http://yui.yahooapis.com/2.7.0/build/datatable/datatable-min.js','v' => 0, 'd' => array('connection','json','element','paginator','datasource','autocomplete'), 'c' => 'http://yui.yahooapis.com/2.8.0r4/build/datatable/assets/skins/sam/datatable.css','f' => 1),
		'datasource' => array('p' => 'http://yui.yahooapis.com/2.7.0/build/datasource/datasource-min.js','v' => 0,'f' => 1),
		'element' => array('p' => 'http://yui.yahooapis.com/2.7.0/build/element/element-min.js','v' => 0,'d' => array('yahoo_dom'),'f' => 1),
		'yahoo_dom_event' => array('p' => 'http://yui.yahooapis.com/2.7.0/build/yahoo-dom-event/yahoo-dom-event.js', 'v' => 0,'f' => 1),
		
		'connection' => array('p' => 'http://yui.yahooapis.com/2.7.0/build/connection/connection-min.js', 'v' => 0,'f' => 1),
		'json' => array('p' => 'http://yui.yahooapis.com/2.7.0/build/json/json-min.js', 'v' => 0,'f' => 1),
		'paginator' => array('p' => 'http://yui.yahooapis.com/2.7.0/build/paginator/paginator-min.js', 'v' => 0, 'c' => 'http://yui.yahooapis.com/2.7.0/build/paginator/assets/skins/sam/paginator.css','f' => 1),
		'autocomplete' => array('p' => 'http://yui.yahooapis.com/2.7.0/build/autocomplete/autocomplete-min.js', 'v' => 0, 'c' => 'http://yui.yahooapis.com/2.7.0/build/autocomplete/assets/skins/sam/autocomplete.css','f' => 1),
		'tabview' => array('p' => 'http://yui.yahooapis.com/2.7.0/build/tabview/tabview-min.js', 'v' => 0, 'c' => 'http://yui.yahooapis.com/2.7.0/build/tabview/assets/skins/sam/tabview.css','d' => array('element'),'f' => 1),
		'logger' => array('p' => 'http://yui.yahooapis.com/2.7.0/build/logger/logger-min.js','v' => 0, 'c' => 'http://yui.yahooapis.com/2.7.0/build/logger/assets/skins/sam/logger.css','f' => 1),
		'button' => array('p' => 'http://yui.yahooapis.com/2.7.0/build/button/button-min.js', 'v' => 0,'d' => array('element'), 'c' => 'http://yui.yahooapis.com/2.7.0/build/button/assets/skins/sam/button.css','f' => 1),
		'connection' => array('p' => 'http://yui.yahooapis.com/2.7.0/build/connection/connection-min.js', 'v' => 0,'f' => 1),
		'dragdrop' => array('p' => 'http://yui.yahooapis.com/2.7.0/build/dragdrop/dragdrop-min.js', 'v' => 0,'f' => 1),
		'container' => array('p' => 'http://yui.yahooapis.com/2.7.0/build/container/container-min.js', 'v' => 0, 'd' => array('dragdrop','connection','button'), 'c' => 'http://yui.yahooapis.com/2.7.0/build/container/assets/skins/sam/container.css','f' => 1),
		'calendar' => array('p' => 'http://yui.yahooapis.com/2.7.0/build/calendar/calendar-min.js', 'v' => 0,'c' => 'http://yui.yahooapis.com/2.7.0/build/assets/skins/sam/skin.css','d' => array('container'),'f' => 1),
		'uploader' => array('p' => 'http://yui.yahooapis.com/2.7.0/build/uploader/uploader-min.js','v' => 0,'d' => array('element','cookie'),'f' => 1),
		'cookie' => array('p' => 'http://yui.yahooapis.com/2.7.0/build/cookie/cookie-min.js', 'v' => 0,'f' => 1),
		'carousel' => array('p' => 'http://yui.yahooapis.com/2.7.0/build/carousel/carousel-min.js','v' => 0,'c' => 'http://yui.yahooapis.com/2.7.0/build/carousel/assets/skins/sam/carousel-rp-skin.css','f' => 1),
		'history' => array('p' => 'http://yui.yahooapis.com/2.7.0/build/history/history-min.js','v' => 0),
		'user' => array('p' => 'Admin/CMS/user.js','v' => 0,'d' => array('const'),'f' => 0),
		'const' => array('p' => 'Admin/CMS/const.js','v' => 0,'f' => 0),
	);

	static $to_include = array();
	static $to_include_css = array();
	static $include_count = 0;

	function __construct()
	{

	}

	static function get_js_list($names = array())
	{
		foreach ($names as $name)
		{
			self::load_one($name);
		}

		return self::$to_include;
	}
	static function get_css_list()
	{
		return self::$to_include_css;
	}
	function load_one($name)
	{
		if(self::$include_count > 100) throw new Exception('recursion in JsFiles');

		self::$include_count++;
		
		if(isset(self::$to_include[$name])) return true;

		if(isset(self::$js_list[$name]['d']) && !empty(self::$js_list[$name]['d']))
		{
			//js file has dependicies, include it first
			if(is_string(self::$js_list[$name]['d']))
			{
				self::load_one(self::$js_list[$name]['d']);
			}
			elseif (is_array(self::$js_list[$name]['d']))
			{
				foreach (self::$js_list[$name]['d'] as $value)
				{
					self::load_one($value);
				}
			}
		}
		//assume here all the dependicies loaded, add js to list
		self::$to_include[$name] = array('item' => self::$js_list[$name]['p'] . '?v=' . self::$js_list[$name]['v'],'f' => self::$js_list[$name]['f']);
		if (isset(self::$js_list[$name]['c']) && !empty(self::$js_list[$name]['c']))
			self::$to_include_css[$name] = array('item' => self::$js_list[$name]['c'] . '?v=' . self::$js_list[$name]['v'],'f' => self::$js_list[$name]['f']);
	}
}
?>