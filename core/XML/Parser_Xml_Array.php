<?php
require_once 'PEAR.php';

define('XML_PARSER_ERROR_NO_RESOURCE', 200);
define('XML_PARSER_ERROR_UNSUPPORTED_MODE', 201);
define('XML_PARSER_ERROR_INVALID_ENCODING', 202);
define('XML_PARSER_ERROR_FILE_NOT_READABLE', 203);
define('XML_PARSER_ERROR_INVALID_INPUT', 204);
define('XML_PARSER_ERROR_REMOTE', 205);

class Parser_Xml_Array extends Module
{
	var $fp;
	var $parser;
	var $_handlerObj;
	var $srcenc;
	var $fold, $skip;
	Var $chet=-1;
	var $xml_array=array();
	var $stek=array();
	var $stek_index=array();
	var $size_file;
	var $error;
	var $time;
	//�����������
	function Parser_Xml_Array()
	{
		$this->srcenc="null";
		$this->setMode();
	}
	function run()
	{
		return true;
	}
	function init()
	{
		return true;
	}
 
	function parser_xml()
	{
		$this->chet=-1;
		$result = $this->_create();
		$parse_result = xml_parse($this->parser, $this->fp,true);
		if($parse_result === 0)
		{
			$this->error=xml_error_string(xml_get_error_code($this->parser));
			$this->free();
			return false;
		}
		$this->free();
		return true;
	}
    // �������� �������
	function _create()
	{
		if ($this->srcenc == "null") 
		{
			$xp = @xml_parser_create();
		} else 
		{
			$xp = @xml_parser_create($this->srcenc);
		}
		if (is_resource($xp)) 
		{
			$this->parser = $xp;
			$result=$this->_initHandlers();
		}
		return true;
	}
	
	function _initHandlers()
	{
		if (!is_resource($this->parser)) 
		{
			return false;
		}

		if (!is_object($this->_handlerObj)) 
		{
			$this->_handlerObj = &$this;
		}
		xml_set_object($this->parser, $this->_handlerObj);
		xml_set_element_handler($this->parser, 'startElement', 'endElement');	
		xml_set_character_data_handler($this->parser, "characterData");
		xml_parser_set_option($this->parser, XML_OPTION_CASE_FOLDING, $this->fold);
		xml_parser_set_option($this->parser, XML_OPTION_SKIP_WHITE, $this->skip);
		return true;
    }
    // ���� ������ �����, URL ��� ������.
	function setInput($fp)
    {
    	
        if (eregi('^[a-z]+://', substr($fp, 0, 10))) 
		{
			return $this->setInputFile($fp);
		}
        elseif (file_exists($fp)) 
		{
			return $this->setInputFile($fp);
		}
		else 
		{
			$this->fp = $fp;
			return true;
		}
		return false;
    }
    // ���� ������
	function setInputString($data)
    {
        $this->fp = $data;
        return true;
    }
	// ���� ����� xml
	function setInputFile($file)
    {
		$file_local=str_replace(':', '_', $file);
		$file_local=str_replace('/', '_', $file_local);
		$file_local=str_replace('\\', '_', $file_local);
		$file_local=str_replace('.', '_', $file_local);
		$file_local = md5($file_local);
		
		$file_local=$file_local.'.xml';
		$this->file_local=$file_local;
		if (file_exists('./cache/' . $file_local)) 
		{
			$time_raz=time()-filemtime('./cache/' . $file_local);
		}
		else 
		{
			$time_raz=$this->time+1;
    	}
			//pp($time_raz);
		if ($time_raz>$this->time){
			$ch = curl_init($file);
			$fp = fopen('./cache/' . $file_local, "w");
			curl_setopt($ch, CURLOPT_FILE, $fp);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_exec($ch);
			curl_close($ch);
			fclose($fp);
		}
		$this->fp=file_get_contents('./cache/' . $file_local);
	}
    // ��������� �������
    // $time - ������ ����������
    // $fild - {0,1} 1 - ��������� ��� ���� � ������� �������, 0 - ��������� ��� ���������.
    // $skip - {0,1} 1 - ���������� ������� � ��������� ����� ������, 0 - ��������� �� ��� �������(�� �������������!)
    function setMode($time=600, $fold=0, $skip=1, $srcenc="null")
    {
    	$this->srcenc=$srcenc;
    	$this->skip=$skip;
    	$this->fold=$fold;
    	$this->time=$time;
    }
	// ����������� ��� (��������)
	function startElement($parser, $name, $atts)
	{
		$this->chet++;
		if ($this->chet==0) 
			{
				$chil=array("atrib"=>$atts,"value"=>"");
				$this->xml_array[$name] = $chil;
				$this->stek[$this->chet]=&$this->xml_array[$name];
				$this->stek_index[$this->chet]=0;
			}
		else 
		{
			$chil=array("atrib"=>$atts,"value"=>"");
			if (isset($this->stek[($this->chet)-1][$name]))
			{
				$this->stek_index[$this->chet]++;
				$this->stek[($this->chet)-1][$name][$this->stek_index[$this->chet]]=$chil;
				$this->stek[$this->chet]=&$this->stek[($this->chet)-1][$name][$this->stek_index[$this->chet]];
			}
			else 
			{
				$this->stek_index[$this->chet]=0;
				$this->stek[($this->chet)-1][$name][$this->stek_index[$this->chet]]=$chil;
				$this->stek[$this->chet]=&$this->stek[($this->chet)-1][$name][0];
			}
		}
	}
	// ����������� ���(��������)
	function endElement($parser, $name)
	{
		unset($this->stek[$this->chet]);
		$this->chet--;
	}
	// �������� ��������
	function characterData($parser, $value)
	{
		if ($this->stek[$this->chet]["value"]=="!*!")$this->stek[$this->chet]["value"]="";
		if (trim($value))
		{
			$this->stek[$this->chet]["value"].=$value;
		}
	}
	// ����������� ������ 
	function free()
	{
		if (isset($this->parser) && is_resource($this->parser)) 
		{
			xml_parser_free($this->parser);
			unset( $this->parser );
		}
		if (isset($this->fp) && is_resource($this->fp)) 
		{
			fclose($this->fp);
		}
		unset($this->fp);
		return null;
	}

	function &parser_xml_to_array()
	{
		//if ($this->parser_xml()) $this->error="Not errors"; else $this->error="ERROR!";		
		$this->parser_xml();
		return $this->xml_array;
	}
}

?>