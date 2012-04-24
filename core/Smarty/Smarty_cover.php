<?php
require_once('Smarty/Smarty.class.php');
class Smarty_cover extends Module 
{
	var $smarty;
	function Smarty_cover($cfg)
	{
		
	}
	function init()
	{
		$this->smarty = new Smarty();
		$this->smarty->template_dir = './templates';
        $this->smarty->compile_dir = './templates/templates_c';
        $this->smarty->cache_dir = './templates/cache';
        $this->smarty->config_dir = './conf';
        $this->smarty->compile_check = true;
        
        $this->smarty->register_outputfilter(array($this, 'module_parser'));
        //$this->smarty->load_filter('output','trimwhitespace');
        
		return true;
	}
	function assign($val1, $val2)
	{
		return $this->smarty->assign($val1, $val2);
	}	
	function fetch($val)
	{
		return $this->smarty->fetch($val);
	}
	function module_parser($output,&$smarty)
	{
		if(isset($GLOBALS['core.CMS.seo_url']))
		{
			$GLOBALS['core.smarty']->assign('seo_url', $GLOBALS['core.CMS.seo_url']);
		}
		
		if(isset($GLOBALS['core.do_not_parse']))
			return $output;
		$to_return = '';
		$len = strlen($output);
		$start = false;
		$skip_one = false;
		
		$possible_module = '';
		for ($i = 0; $i < $len; $i++)
		{
			//need to make parser of module code
			if('[' == $output[$i] && false == $start)
			{
				//new module possible started and that is not part of other module
				$start = true;
				$skip_one = true;
				$possible_module = '';
			}
			if(true == $start && ']' == $output[$i])
			{
				//we are at end of module
				$to_return .= $this->module_get($possible_module);
				$skip_one = true;
				$start = false;
			}
			
			if(true == $skip_one)
			{
				$skip_one = false;
				continue;
			}
			elseif (true == $start)
			{
				//need to make string of possible module
				$possible_module .= $output[$i];
			}
			else 
			{
				$to_return .= $output[$i];
			}
			
			
		}
		
		if(true == $start && !empty($possible_module))
		{
			//possible module was started but never ended
			$to_return .= '[' . $possible_module;
		}
		
		return $to_return;
	}
	function module_get($module_string)
	{
		//we have module formatted as module_name?param1=123&param2=asdasd
		$splt = explode('?', $module_string);
		$module_name = $splt[0];
		//need to search if we have that module
		require_once('CMS/Page_Factory.php');
		
		$class = Page_Factory::module_list($module_name);
		//print $module_string;
		if(!empty($class))
		{
			if(!empty($splt[1]))
			{
				//we have params to pass
				$splt[1] = str_replace('&amp;','&',$splt[1]);
				$params = explode('&', $splt[1]);
				foreach ($params as $key => $value)
				{
					list($param_name, $param_value) = explode('=', $value);
					$_REQUEST[$param_name] = $param_value;
				}
			}
			
			require_once($class['processor']);
			$obj = new $class['class_name'];
			return $obj->process();
		}
		else
		{
			return '[' . $module_string . ']';
		}
		
		//return 'content of module:)';
	}
}
?>