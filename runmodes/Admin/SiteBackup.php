<?php
require_once('Admin_Header.php');


class SiteBackup extends Runmode 
{
	function SiteBackup()
	{
		parent::Runmode();
	}
	
	function process()
	{
		//print getcwd();
		if (isset($_REQUEST['save']) && !empty($_REQUEST['save']))
		{
			$date = date("d.m.Y",time());
			$path = getcwd();		
			$mysqldump = "mysqldump ";
			$db = $GLOBALS['core.config']->get_config('db_config');
			
			exec("$mysqldump " . $db['common']['database'] . " --user=" . $db['MySQL']['db_user'] . " --password=" . $db['MySQL']['db_password'] . " > $path/upload/dump.sql");
			exec("cd $path && tar -cvzf upload/site_backup_" . $date . ".tar.gz upload pictures gallery file_storage");
			if (file_exists("./upload/dump.sql")) unlink("./upload/dump.sql");
			
			header('Content-type: application/x-tar');
			header('Content-Disposition: attachment; filename="site_backup_'.$date.'.tar.gz"');
			$handle = fopen('./upload/site_backup_'.$date.'.tar.gz', "rb");
			if(!$handle)
			{
				print 'error occured';
				exit();
			}
			
			while (!feof($handle)) 
			{
				print fread($handle, 8192);
			}
			fclose($handle); 			
			unlink('./upload/site_backup_'.$date.'.tar.gz');
		}
		
		return Admin_Header::out('site_backup');
	}
}


// cd /usr/html/pavel/svn_cms && tar -cvzf upload/site_backup_name.tgz upload pictures gallery file_storage
?>