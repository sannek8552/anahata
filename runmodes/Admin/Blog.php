<?php
require_once('Admin_Header.php');
require_once('CMS/SettingsHolder.php');

class Blog extends Runmode
{
    function Blog()
    {
        parent::Runmode();
    }
    function process()
    {
        $sh = new SettingsHolder();
        $settings = $sh->getSettings();
        $url = $settings['blog_login_page'];
        $redirect = $settings['blog_redirect_page'];
        $pathurl = parse_url($redirect);
        $domain = $pathurl['host'];
        $blog = $pathurl['path'];
        $login = $settings['blog_user'];
        $pwd = $settings['blog_password'];
        $file = 'cache/temp.txt';
        if(is_file($file))
        {
            unlink($file);
        }
        //mkfile($file);
       /* $file_ = fopen($file, "w");
        fclose($file_);*/
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.11) Gecko/2009060215 Firefox/3.0.11 GTB5");
        curl_setopt($ch, CURLOPT_URL, $url);
        //curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_COOKIEJAR, $file);
        curl_setopt($ch, CURLOPT_COOKIE, $file);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "log=$login&pwd=$pwd&wp-submit=Log In&redirect_to=$redirect&testcookie=1");
        //curl_setopt($ch, CURLOPT_REFERER, $conf['common']['domain_name'].$conf['common']['script_url'].'Blog/wp-login.php');
        curl_setopt($ch, CURLOPT_COOKIEFILE, $file);
        curl_exec($ch);
        curl_close($ch);
        $lines = file($file);
        
        $time = time();
        $wps = split("\t", $lines[5]);
        $wps__ = split("%7C", $wps[6]);

        setcookie($wps[5], str_replace("\n", '', $wps__[0].'|'.$wps__[1].'|'.$wps__[2]), time() + 3600, $wps[2], $domain);
        $wps = split("\t", $lines[6]);
        $wps__ = split("%7C", $wps[6]);
        setcookie($wps[5], str_replace("\n", '', $wps__[0].'|'.$wps__[1].'|'.$wps__[2]), time() + 3600, $wps[2], $domain);
        
        $wps = split("\t", $lines[4]);
        $wps__ = split("%7C", $wps[6]);

        setcookie('wordpress_test_cookie', 'WP Cookie check', time() + 3600, $wps[2], $domain);

  //      setcookie('wp-settings-time-1', $wps__[1], time() + 3600, $wps[2], $domain);

//        setcookie('wp-settings-1', 'm0=c&m1=c&m2=c&m3=c&m4=c&m5=c&m6=o&m7=c&m8=o', time() + 3600, $wps[2], $domain);
        $wps = split("\t", $lines[7]);
        $wps__ = split("%7C", $wps[6]);
        setcookie($wps[5], str_replace("\n", '', $wps__[0].'|'.$wps__[1].'|'.$wps__[2]), time() + 3600, $wps[2], $domain);
        setcookie('cms_logged', time(), time() + 3600, $wps[2],$domain);
        //$_SESSION['cms_loged'] = time();
        if(is_file($file))
        {
            unlink($file);
        }
        //exit;
        header ("Location:$redirect");
        exit;
    }
}
?>
