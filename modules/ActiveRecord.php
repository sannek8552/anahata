<?php
class ActiveRecord implements ArrayAccess
{
	//this variable should contain all the
	//field that represented by table, without special fields like created, updated and primary key!
	protected $field_list = array();
	
	protected $shared = false;

	//values of data
	public $data = array();
	//name of the primary key
	protected $key = 'id';

	protected $table = '';
	//currently that class will not support any relationships and
	//observers, to add later

	//value of the key
	protected $key_value = null;

	//set if record delete, prevent save or anything
	protected $deleted = false;

	//configure meta fields, that linked to other table by foreign key
	protected $meta_fields = array();

	protected $meta_class = array();

	protected $check_save = false;
	//constructor
	function __construct($id = null)
	{
		if(!is_null($id))
		{
			$mods = array();
			$sql = 'SELECT *';

			$prefix = '#p#';
			if ($this->shared) $prefix = '#sp#';

			$from = 'FROM '.$prefix.$this->table;
			
			$data = $GLOBALS['core.sql']->getRow($sql . ' ' . $from . ' WHERE '.$prefix . $this->table .'.' . $this->key .'=?', $id);
			
			if(empty($data))
			{
				//invalid id given, can be catched when someone try to use deleted record
				throw new Exception('Record with ' . $id . ' not present in ' . $this->table);
			}
			else
			{
				//got from database
				$this->key_value = $id;
				$this->data = $data;
			}
		}
	}

	function get_data($name = null)
	{
		if(is_null($name))
		{
			$this->data[$this->key] = $this->key_value;
			$data = $this->data;
			foreach ($this->meta_class as $key => $value)
			{
				$data[$key] = '';
				if(!empty($data[$value['f_key']]))
				{
					$temp_class = new $value['class']($data[$value['f_key']]);
					$data[$key] = $temp_class->$value['field'];
					
				}
				
			}
			
			return $data;
		}
		else
		{
			if($name == $this->key)
				return $this->key_value;
				
			foreach ($this->meta_class as $key => $value)
			{
				if($name == $key)
				{
					
					
					$temp = $this->$value['f_key'];
					
					if(!empty($temp))
					{
					
						$temp_class = new $value['class']($this->$value['f_key']);
					
						return $temp_class->$value['field'];
					}
					return '';
				}
			}
			//need to return specific value
			if(!in_array($name,$this->field_list))
			{
				throw new Exception('no field in field_list - '.$name);
			}
			if(!isset($this->data[$name]))
				$this->data[$name] = '';
			return $this->data[$name];
		}
	}

	function set_data($data)
	{
		foreach ($data as $key => $value)
		{
			if(in_array($key, $this->field_list))
				$this->data[$key] = $value;
				//throw new Exception('no field in field list');
		}
	}

	function __get($name)
	{

		return $this->get_data($name);
	}

	function __set($name, $value)
	{
		$data = array($name => $value);
		$this->set_data($data);
	}

	//function allow to construct by data, data can come from list or other source
	function construct_by_data($data)
	{
		if(isset($data[$this->key]) && !is_null($data[$this->key]))
		{
			$this->key_value = $data[$this->key];
		}
		unset($data[$this->key_value]);
		if(isset($data['created']))
			$this->data['created'] = $data['created'];
		if(isset($data['updated']))
			$this->data['updated'] = $data['updated'];
		unset($data['created']);
		unset($data['updated']);
		$this->set_data($data);

	}

	function save()
	{
		if($this->deleted)
			throw new Exception('record delete, can not save');
		//save all the modifications back to database
		//need a way to save only really modified variables?
		
		$key_info = array('key_name' => $this->key);
		if (is_null($this->key_value))
		{
			//we add new record to database
			$res = $GLOBALS['core.store']->save($this->table, $this->data, $key_info,$this->shared);
			$this->data['created'] = $res['created'];
			$this->data['updated'] = $res['updated'];
			$this->key_value = $GLOBALS['core.store']->last_id();
		}
		else
		{
			//we update existing record
			$key_info['key_value'] = $this->key_value;
			unset($this->data[$this->key]);
			$created = $this->data['created'];
			unset($this->data['created']);
			unset($this->data['updated']);
			
			$res = $GLOBALS['core.store']->save($this->table, $this->data, $key_info,$this->shared);
			$this->data['created'] = $created;
			$this->data['updated'] = $res['updated'];
		}
		$this->data[$this->key] = $this->key_value;
	
		
		
	}

	function delete()
	{
		if($this->deleted || is_null($this->key_value))
			throw new Exception('record already deleted');
		$key_info = array('key_name' => $this->key, 'key_value' => $this->key_value);
		
		//need to some type of trash here, possible to restore data after delete?
		
		$this->real_delete();
		
		//$this->data['deleted'] = 1;
		//$this->save();
		
		$this->deleted = true;
		
	}
	
	function real_delete()
	{
		if($this->deleted || is_null($this->key_value))
			throw new Exception('record already deleted: '.$this->key_value);
		$key_info = array('key_name' => $this->key, 'key_value' => $this->key_value);
		$GLOBALS['core.store']->delete($this->table, $key_info,$this->shared);
		//need to some type of trash here, possible to restore data after delete?
		$this->deleted = true;
	}

	//ArrayAccess interface implementation here
	function offsetExists($name)
	{
		return isset($this->$name);
	}

	function offsetGet($name)
	{
		return $this->$name;
	}

	function offsetSet($index,$value)
	{
		$this->$index = $value;
	}

	function offsetUnset($name)
	{
		return;
	}
	
	function record_exists($id)
	{
		$mods = array();
		$sql = 'SELECT *';
		$prefix = '#p#';
		if ($this->shared) $prefix = '#sp#';
		$from = 'FROM '.$prefix.$this->table;
		$data = $GLOBALS['core.sql']->getRow($sql . ' ' . $from . ' WHERE '.$prefix . $this->table .'.' . $this->key .'=?', $id);
		if(empty($data))
		{
			return false;
		}
		return true;
	}
}
?>