<?php

class SList extends Module
{
    var $list_name = '';
    var $sql = '';
    var $filters = array();
    var $prepared_sql;
    var $modif;
    var $params = array();
    var $count_sql;
    var $current_page = 1;
    var $saved = 0;
    
    function SList($cfg)
    {
    }
    
    function run()
    {
    	return true;
    }
    
    function init()
    {
    	return true;
    }
    
    function custom_init($list_name = '')
    {
	$this->list_name = $list_name;
	if(!empty($list_name) && !empty($_SESSION[$list_name]))
	{
	    if(!empty($_SESSION[$list_name]['sql']))
		$this->sql = $_SESSION[$list_name]['sql'];
	    if(!empty($_SESSION[$list_name]['filters']))
		$this->filters = $_SESSION[$list_name]['filters'];
	    if(!empty($_SESSION[$list_name]['params']))
		$this->params = $_SESSION[$list_name]['params'];
	    if(!empty($_SESSION[$list_name]['count_sql']))
		$this->count_sql = $_SESSION[$list_name]['count_sql'];
	    if(!empty($_SESSION[$list_name]['current_page']))
		$this->current_page = $_SESSION[$list_name]['current_page'];
	    $this->saved = 1;
	}
    }
    function is_saved()
    {
	return $this->saved;
    }
    
    function set_sql($sql_string,$where_exists = false)
    {
		$this->sql = $sql_string;
		if(!$where_exists)
		{
		    $this->sql .= ' WHERE 1';
		}
		if(!empty($this->list_name))
		    $_SESSION[$this->list_name]['sql'] = $sql_string;
    }
    
    function get_sql()
    {
		return $this->sql;
    }
    
    function set_count_sql($count_sql)
    {
		$this->count_sql = $count_sql;
		if(!empty($this->list_name))
		    $_SESSION[$this->list_name]['count_sql'] = $count_sql;
    }
    
    //function get_count_sql()
    //{
	//	return $this->count_sql;
    //}
    
    function set_filters($filters)
    {
		$this->filters = $filters;
		if(!empty($this->list_name))
		    $_SESSION[$this->list_name]['filters'] = $filters;
    }
    
    function get_filters()
    {
		return $this->filters;
    }
    
    function prepare_sql()
    {
		#pp($this->filters);
		$result_prepare = $this->prepare_filters($this->filters);
		$prepared_sql = 'SELECT SQL_CALC_FOUND_ROWS ' . $this->sql;
		if(!empty($result_prepare['sql_part']))
		    $prepared_sql .= ' AND' . $result_prepare['sql_part'];
		$this->prepared_sql = $prepared_sql;
		$this->modif = $result_prepare['modif'];
	}

	function set_params($params)
	{
		$this->params = $params;
		if(!empty($this->list_name))
		    $_SESSION[$this->list_name]['params'] = $params;
		//params is 'items_per_page','order by', 'group_by'
    }
    
    function set_param($param, $value)
    {
    	$this->params[$param] = $value;
    	if(!empty($this->list_name))
	    $_SESSION[$this->list_name]['params'][$param] = $value;
    }
    
    function get_params()
    {
		return $this->params;
    }
    function num_pages()
    {
		
		$num = $GLOBALS['core.sql']->getOne('SELECT FOUND_ROWS()');
		
		$pages = ceil($num / $this->params['items_per_page']);
		$prepared = array();
		for($i = 0; $i < $pages; $i++)
		{
			$prepared[$i+1] = $i + 1;
		}
		return array('pages' => $pages,'items' => $num, 'current' => $this->current_page, 'prepared' => $prepared);
    }
    function current_page()
    {
		return $this->current_page;
    }
    function get_page($page_num = 1)
    {
	//prepare limits
	//lower is ($page_num - 1) * $items_per_page
	//uppre is $page_num * $items_per_page
	$limit = '';
	if(!empty($page_num))
	{
	    if(!empty($this->list_name))
	    $_SESSION[$this->list_name]['current_page'] = $page_num;
	    $this->current_page = $page_num;
	}
	else
	{
		if(empty($this->current_page))
		{
			$this->current_page = 1;
			$_SESSION[$this->list_name]['current_page'] = 1;
		}
	    $page_num = $this->current_page;
	    
	}
	
	$limit = '';
	
	if(!empty($this->params['group_by']))
	{
		$limit .= ' GROUP BY ' . $this->params['group_by'];
	}
	
	if(!empty($this->params['order_by']))	
	{
	    $order_by = array();
	    foreach($this->params['order_by'] as $key => $value)
	    {
	
		if(strpos($value,';') > 0)
		{
	
		    $spl = split(';',$value);
	
		    $order_by[] = $spl[0] . ' ' . $spl[1];
		}
		else
		{
		    $order_by[] = $value;
		}
	    }
	    $limit .= ' ORDER BY ' . join(',',$order_by);
	}
	
	
	if (isset($this->params['items_per_page']) && !empty($this->params['items_per_page']))
		$limit .= ' LIMIT ' . ($page_num - 1) * $this->params['items_per_page'] . ', ' .$this->params['items_per_page']; //($page_num * $this->params['items_per_page']);
	
	$this->prepare_sql();
	
	return $GLOBALS['core.sql']->getAll($this->prepared_sql . $limit, $this->modif);
	
    }

    function prepare_filters($filters)
    {
    	
      $to_join = array();
      $modif = array();
      $logik = 'AND';
      if(is_array($filters) and !empty($filters['logik']))
      {
		$logik = $filters['logik'];
		unset($filters['logik']);
      }
	
      foreach($filters as $key => $value)
      {
		if(!empty($value['sub']))
		{			
	  		$result_prepare = $this->prepare_filters($value['sub']);
	  		$to_join[] = $result_prepare['sql_part'];
	  		$modif = array_merge($modif,$result_prepare['modif']);
		}
		else
		{
	
	  		if(!isset($value['o']) || empty($value['o']))
	  			$value['o'] = '=';
	  		$str_to_append = $value['f'] . ' ' . $value['o'] . ' ';
	  		
	  		if(strtolower($value['o']) == 'in' || strtolower($value['o']) == 'not in')
	  		{
	    		$str_to_append .= ' (';
	    		$in_join = array();
	    		foreach($value['v'] as $v_key => $v_value)
				    {
						$in_join[] = ' ?';
						$modif[] = $v_value;
			    	}
			    $str_to_append .= join(',',$in_join) . ')';
			    $to_join[] = $str_to_append;
			}
			elseif(strtolower($value['o']) == 'like')
			{
				
				$to_join[] = $str_to_append . '?';
				$modif[] = '%' . $value['v'] . '%';
			}
			else
			{
				
			    $to_join[] = $str_to_append . '?';
			    $modif[] = $value['v'];
			}
			
		}
	}
	if(!empty($to_join))
	    $sql_part = '(' . join(' ' . $logik . ' ',$to_join) . ')';
	else
	    $sql_part = '';
	
	return array('sql_part' => $sql_part,'modif' => $modif);
	}
}
?>