<?php
//require_once('Admin_Header.php');
require_once('CMS/MediaManager/MediaManager_Record.php');
require_once('CMS/MediaManager/MediaManager_RecordList.php');

class MediaManager extends Runmode 
{
	var $file_types = array(
		'application/vnd.ms-excel' => 'file_xls.png',
		'text/html' => 'file_html.png',
		'text/plain' => 'file_txt.png',
		'application/rtf' => 'file_rtf.png',
		'image/psd' => 'file_psd.png',
		'pdf' => 'file_pdf.png',
		'doc' => 'file_doc.png',
		'zip' => 'file_zip.png',
		'application/x-rar-compressed' => 'file_rar.png',
		'avi' => 'file_avi.png',
		'image/bmp' => 'file_bmp.png',
		'video/x-flv' => 'file_flv.png',
		'audio/mpeg' => 'file_mp3.png',
		'video/mpeg' => 'file_mpg',
		'audio/x-ms-wma' => 'file_wma'
	);
	
	var $mime_types = array(
		'images' => array('image/jpeg','image/png','image/gif'),
		'music' => array('audio/mpeg','audio/x-ms-wma'),
		'video' => array('video/mpeg','video/x-flv','avi'),
		'files' => array('application/vnd.ms-excel','text/html','text/plain','application/rtf','image/psd','pdf','doc','zip','application/x-rar-compressed')
	);

	function __construct()
	{
		$this->base_map[0] = 'id';
		parent::Runmode();
	}

	function process()
	{
		$GLOBALS['core.smarty']->assign('current_tab','list');
		
		if(isset($_FILES['upload_file']['tmp_name']))
		{
			#pp($_FILES);
			if ($_FILES['upload_file']['error'] == UPLOAD_ERR_INI_SIZE)
			{
				$GLOBALS['core.smarty']->assign('error_message','The uploaded file exceeds the upload_max_filesize directive in php.ini');
			}
			elseif ($_FILES['upload_file']['error'] == UPLOAD_ERR_FORM_SIZE)
			{
				$GLOBALS['core.smarty']->assign('error_message','The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form');
			}
			elseif ($_FILES['upload_file']['error'] == UPLOAD_ERR_PARTIAL)
			{
				$GLOBALS['core.smarty']->assign('error_message','The uploaded file was only partially uploaded.');
			}
			elseif ($_FILES['upload_file']['error'] == UPLOAD_ERR_NO_FILE)
			{
				$GLOBALS['core.smarty']->assign('error_message','No file was uploaded.');
			}
			elseif ($_FILES['upload_file']['error'] == UPLOAD_ERR_NO_TMP_DIR)
			{
				$GLOBALS['core.smarty']->assign('error_message','Missing a temporary folder.');
			}
			elseif ($_FILES['upload_file']['error'] == UPLOAD_ERR_CANT_WRITE)
			{
				$GLOBALS['core.smarty']->assign('error_message','Failed to write file to disk.');
			}
			elseif ($_FILES['upload_file']['error'] == UPLOAD_ERR_EXTENSION)
			{
				$GLOBALS['core.smarty']->assign('error_message','A PHP extension stopped the file upload.');
			}
			
			if (move_uploaded_file($_FILES['upload_file']['tmp_name'], './file_storage/' . $_FILES['upload_file']['name']))
			{
				$images = array();
				
				$image = getimagesize('file_storage/' . $_FILES['upload_file']['name']);
#pp($image);
				$config = $GLOBALS['core.config']->get_config('media_manager');
				
				$record = new MediaManager_Record();
				$record->filename = $_FILES['upload_file']['name'];
				$record->thumbs = implode(",",array_keys($config));
				

				$GLOBALS['core.smarty']->assign('uploaded', 'file_storage/' . $_FILES['upload_file']['name']);

				if ($image['mime'] == 'image/jpeg' or $image['mime'] == 'image/png' or $image['mime'] == 'image/gif')
				{
					foreach ($config as $key => $value)
					{
						if ($value['type'] == 'crop')
						{
							$GLOBALS['core.image']->create_thumb_crop('file_storage/' . $_FILES['upload_file']['name'],'file_storage/'.$key.'_' . $_FILES['upload_file']['name'],$value['width'],$value['height']);
						}
						elseif ($value['type'] == 'width')
						{
							$GLOBALS['core.image']->create_thumb_width('file_storage/' . $_FILES['upload_file']['name'],'file_storage/'.$key.'_' . $_FILES['upload_file']['name'],$value['width']);						
						}
						$im = getimagesize('file_storage/'.$key.'_' . $_FILES['upload_file']['name']);
						$im['key'] = $key;
						$images[] = $im;
					}
				
					$image['key'] = '';
					$images[] = $image;
					$GLOBALS['core.smarty']->assign('images',$images);
					$GLOBALS['core.smarty']->assign('image',1);
				}
				/*
				else
				{
					$GLOBALS['core.smarty']->assign('error','Only gif, jpeg and png images allowed');
				}
				*/

				$GLOBALS['core.smarty']->assign('filename',$_FILES['upload_file']['name']);
				if ($image)
				{
					$file_info = $image;
				}
				else 
				{
					if ($_FILES['upload_file']['type'] == 'application/octet' or $_FILES['upload_file']['type'] == 'application/x-php' or $_FILES['upload_file']['type'] == 'unknown/unknown' or $_FILES['upload_file']['type'] == 'application/force-download')
					{
						$pathinfo = pathinfo('file_storage/' . $_FILES['upload_file']['name']);
						$file_info = array('mime' => $pathinfo['extension']);
					}
					else 
					{
						$file_info = array('mime' => $_FILES['upload_file']['type']);
					}
				}
				$record->type = $file_info['mime'];
				$GLOBALS['core.smarty']->assign('file_info',$file_info);
				
				$record->save();
				$GLOBALS['core.smarty']->assign('id',$record->id);
			}
			$GLOBALS['core.smarty']->assign('current_tab','upload');
		}
		
		$GLOBALS['core.smarty']->assign('file_types',$this->file_types);

		if (isset($_REQUEST['id']) and $_REQUEST['id'])
		{
			if (preg_match("/img_(\d+)(_(\d+)(_([^_]+)))?/",$_REQUEST['id'],$matches))
			{
				$id = $matches[1];
				
				$size = '';
				$alignment = '';
				if (isset($matches[3])) $size = $matches[3];
				if (isset($matches[5])) $alignment = $matches[5];

				$record = new MediaManager_Record($id);
				foreach ($record->get_data() as $key => $value) $GLOBALS['core.smarty']->assign($key,$value);

				$GLOBALS['core.smarty']->assign('size',$size);
				$GLOBALS['core.smarty']->assign('alignment',$alignment);
				
				$images = array();
				if ($record->thumbs)
				{
					$thumbs = explode(",",$record->thumbs);
					foreach ($thumbs as $t)
					{
						if ($t)
						{
							$image = getimagesize("file_storage/{$t}_".$record->filename);
						}
						else
						{
							$image = getimagesize("file_storage/".$record->filename);
						}
						$image['key'] = $t;
						$images[] = $image;
					}
				}
				$GLOBALS['core.smarty']->assign('images',$images);
			}
			
			$GLOBALS['core.smarty']->assign('image',1);
			$GLOBALS['core.smarty']->assign('current_tab','upload');
		}

		if (isset($_REQUEST['delete']) and $_REQUEST['delete'])
		{
			$record = new MediaManager_Record($_REQUEST['id']);
			@unlink("file_storage/".$record->filename);
			if ($record->thumbs)
			{
				$thumbs = explode(",",$record->thumbs);
				foreach ($thumbs as $t)
				{
					@unlink("file_storage/{$t}_".$record->filename);
				}
			}
			$record->real_delete();
			$GLOBALS['core.smarty']->assign('current_tab','list');
		}

		if (isset($_REQUEST['save']) and $_REQUEST['save'])
		{
			$record = new MediaManager_Record($_REQUEST['id']);
			$record->set_data($_REQUEST);
			$record->save();
		}

		$filters = array();
		
		if (isset($_REQUEST['type']) and $_REQUEST['type'])
		{
			$filters['type'] = $this->mime_types[$_REQUEST['type']];
		}

		$list = new MediaManager_RecordList();
		$items = $list->get_page(0,'','asc',100,$filters);
		foreach ($items['records'] as $key => $value)
		{
			if (file_exists("file_storage/".$value['filename']))
			{	
				if ($items['records'][$key]['type'] == 'image/jpeg' or $items['records'][$key]['type'] == 'image/png' or $items['records'][$key]['type'] == 'image/gif')
				{
					$items['records'][$key]['images'] = array();
					if (isset($value['thumbs']))
					{
						$thumbs = explode(",",$value['thumbs']);
						foreach ($thumbs as $t)
						{
							if ($t)
							{
								if (file_exists("file_storage/{$t}_".$value['filename']))
									$image = getimagesize("file_storage/{$t}_".$value['filename']);
							}
							else
							{
								$image = getimagesize("file_storage/".$value['filename']);
							}
							
							if (isset($image) and $image)
							{
								$image['key'] = $t;
								$items['records'][$key]['images'][] = $image;
							}
						}										
					}
				}				
			}
			else 
			{
				unset($items['records'][$key]);
			}
		}
		#pp($items);
		
		foreach ($_REQUEST as $key => $value) $GLOBALS['core.smarty']->assign($key,$value);

		$GLOBALS['core.smarty']->assign('items',$items['records']);
		return $GLOBALS['core.smarty']->fetch('Admin/CMS/media_manager.tpl');
	}
}
?>