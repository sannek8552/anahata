<?php /* Smarty version 2.6.18, created on 2012-04-24 13:42:49
         compiled from common_header.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'config_load', 'common_header.tpl', 1, false),array('function', 'seo_url', 'common_header.tpl', 75, false),array('modifier', 'money', 'common_header.tpl', 161, false),)), $this); ?>
<?php echo smarty_function_config_load(array('file' => "templates.ini",'section' => 'common','scope' => 'global'), $this);?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php if ($this->_tpl_vars['seo_data']['page_title']): ?>Модный ребенок :: <?php echo $this->_tpl_vars['seo_data']['page_title']; ?>
<?php else: ?>Модный ребенок<?php endif; ?></title>
<?php if ($this->_tpl_vars['seo_data']['page_description']): ?><meta name="description" content="<?php echo $this->_tpl_vars['seo_data']['page_description']; ?>
" /><?php endif; ?>
<?php if ($this->_tpl_vars['seo_data']['keywords']): ?><meta name="keywords" content="<?php echo $this->_tpl_vars['seo_data']['keywords']; ?>
" /><?php endif; ?>

<link href="<?php echo $this->_config[0]['vars']['img_url']; ?>
favico.ico" rel="shortcut icon" type="image/x-icon" />
<link href="<?php echo $this->_config[0]['vars']['css_url']; ?>
main.css?1=2" rel="stylesheet" type="text/css" />
<link href="<?php echo $this->_config[0]['vars']['css_url']; ?>
style.css" rel="stylesheet" type="text/css" />
<link  href="<?php echo $this->_config[0]['vars']['css_url']; ?>
slimbox.css" rel="stylesheet" type="text/css" media="screen" />
<link  href="<?php echo $this->_config[0]['vars']['css_url']; ?>
jquery-ui-1.8.16.custom.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript">
        var script_url = '<?php echo $this->_config[0]['vars']['script_url']; ?>
';
        var images_prefix = '<?php echo $this->_config[0]['vars']['img_url']; ?>
';
        var ajax_prefix = '<?php echo $this->_config[0]['vars']['script_url']; ?>
';
        var common_prefix = '<?php echo $this->_config[0]['vars']['common_url']; ?>
';        
</script>
<script type="text/javascript" src="<?php echo $this->_config[0]['vars']['js_url']; ?>
validator_o.js"></script>

<script type="text/javascript" src="<?php echo $this->_config[0]['vars']['js_url']; ?>
AJAX.js"></script>
<script type="text/javascript" src="<?php echo $this->_config[0]['vars']['js_url']; ?>
body_blocker.js"></script>
<script type="text/javascript" src="<?php echo $this->_config[0]['vars']['js_url']; ?>
jquery-1.6.2.min.js"></script>
<script type="text/javascript" src="<?php echo $this->_config[0]['vars']['js_url']; ?>
jquery-ui-1.8.16.custom.min.js"></script>
<script type="text/javascript" src="<?php echo $this->_config[0]['vars']['js_url']; ?>
jquery.placeholder.min.js"></script>
<script type="text/javascript">        
    <?php echo '        
        $(document).ready(function(){
            jQuery(\'input[placeholder], textarea[placeholder]\').placeholder();
            init_additional();
            '; ?>
<?php echo $this->_tpl_vars['text_to_init']; ?>
<?php echo '

            $(\'#search_form\').bind(\'submit\', function(){
                var url = \''; ?>
<?php echo $this->_config[0]['vars']['script_url']; ?>
<?php echo 'Search/\';
                url += $("#search_form input[name=\'search\']").val() + \'.html\';
                $(\'#search_form\').attr(\'action\', url);
            });

            
        });
'; ?>
        
    </script>
<?php echo '
<script type="text/javascript">
    function init_additional()
    {

    }
    //jQuery(\'input[placeholder], textarea[placeholder]\').placeholder();
    </script>
'; ?>




</head>
<body>
<div id="wrapper">
    <div id="container">
        <div id="header">
            <a href="<?php echo $this->_config[0]['vars']['script_url']; ?>
index.html" style="position: absolute; top: 10px; left: 320px; width: 190px; height: 110px;" title="Модный ребенок :: Главная"></a>
            <div id="contacts">
                <div class="head">Контакты:</div>
                г. Томск<br/>
                Адрес: Учебная 37а<br/>
                Тел. 41-99-69<br/>
                Сот. 8-923-402-23-74<br/>
                <a href="mailto:modrebenok@sibmail.com">modrebenok@sibmail.com</a>
            </div>

        </div>
        <div id="menu">
            <ul>
                <li <?php if ($this->_tpl_vars['seo_data']['page_title'] == 'Модный ребенок'): ?>class="active"<?php endif; ?>><a href="<?php echo $this->_config[0]['vars']['script_url']; ?>
<?php echo smarty_function_seo_url(array('rm' => 'index'), $this);?>
"  ><div style="width:77px">Главная</div><div class="rside"></div></a></li>
                <li <?php if ($this->_tpl_vars['seo_data']['page_title'] == 'О нас'): ?>class="active"<?php endif; ?>><a href="<?php echo $this->_config[0]['vars']['script_url']; ?>
<?php echo smarty_function_seo_url(array('rm' => 'About'), $this);?>
"  ><div style="width:68px">О нас</div><div class="rside"></div></a></li>
                <li <?php if ($this->_tpl_vars['seo_data']['page_title'] == 'Статьи'): ?>class="active"<?php endif; ?>><a href="<?php echo $this->_config[0]['vars']['script_url']; ?>
<?php echo smarty_function_seo_url(array('rm' => 'Article'), $this);?>
"  ><div style="width:68px">Статьи</div><div class="rside"></div></a></li>
                <li <?php if ($this->_tpl_vars['seo_data']['page_title'] == 'Second Hand'): ?>class="active"<?php endif; ?>><a href="<?php echo $this->_config[0]['vars']['script_url']; ?>
<?php echo smarty_function_seo_url(array('rm' => 'Second-Hand'), $this);?>
"  ><div style="width:130px">Second Hand</div><div class="rside"></div></a></li>
                <li <?php if ($this->_tpl_vars['seo_data']['page_title'] == 'Сток'): ?>class="active"<?php endif; ?>><a href="<?php echo $this->_config[0]['vars']['script_url']; ?>
<?php echo smarty_function_seo_url(array('rm' => 'Stock'), $this);?>
" ><div style="width:55px">Сток</div><div class="rside"></div></a></li>
                <li <?php if ($this->_tpl_vars['seo_data']['page_title'] == 'Контакты'): ?>class="active"<?php endif; ?>><a href="<?php echo $this->_config[0]['vars']['script_url']; ?>
<?php echo smarty_function_seo_url(array('rm' => 'Contacts'), $this);?>
" ><div style="width:87px">Контакты</div><div class="rside"></div></a></li>
                <li <?php if ($this->_tpl_vars['seo_data']['page_title'] == 'Приём на комиссию'): ?>class="active"<?php endif; ?>><a href="<?php echo $this->_config[0]['vars']['script_url']; ?>
<?php echo smarty_function_seo_url(array('rm' => 'Payment'), $this);?>
" ><div style="width:170px">Приём на комиссию</div><div class="rside"></div></a></li>
                <li  <?php if ($this->_tpl_vars['seo_data']['page_title'] == 'Гостевая книга'): ?>class="active"<?php endif; ?>><a href="<?php echo $this->_config[0]['vars']['script_url']; ?>
<?php echo smarty_function_seo_url(array('rm' => 'Guestbook'), $this);?>
" ><div style="width:135px">Гостевая книга</div><div class="rside"></div></a></li>
            </ul>

        </div>
        <div id="ad">

            <a href="#"><img src="<?php echo $this->_config[0]['vars']['img_url']; ?>
ff_baner.jpg" alt="baner"/></a>
            <a href="#"><img src="<?php echo $this->_config[0]['vars']['img_url']; ?>
baner2.jpg" alt="baner"/></a>
            <a href="#"><img src="<?php echo $this->_config[0]['vars']['img_url']; ?>
sg_baner.jpg" alt="baner" class="nomargin"/></a>
        </div>
        <div class="clear"></div>
        <div id="main" >
            <div id="leftColumn">
                <div id="leftMenu">
                    <ul class="firstLevel">
                        <?php $_from = $this->_tpl_vars['categories']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
                        <li class="expanded">
                            <a href="<?php echo $this->_config[0]['vars']['script_url']; ?>
<?php echo smarty_function_seo_url(array('rm' => 'Category','param1' => $this->_tpl_vars['item']['id']), $this);?>
"><?php echo $this->_tpl_vars['item']['title']; ?>
</a>
                            <?php if ($this->_tpl_vars['item']['sub']): ?>
                                <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "sub_cat.tpl", 'smarty_include_vars' => array('items' => $this->_tpl_vars['item']['sub'],'level' => 2)));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                            <?php endif; ?>
                        </li>

                        <?php endforeach; endif; unset($_from); ?>
                        <li class="expanded leftHead">
                            <select name="brand_id"  onchange="window.location = this.value" style="margin-top: 5px;">
                                <option value="">Производители</option>
                            <?php $_from = $this->_tpl_vars['brands']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
                                <option value="<?php echo $this->_config[0]['vars']['script_url']; ?>
<?php echo smarty_function_seo_url(array('rm' => 'Brands','param1' => $this->_tpl_vars['item']['seo_url']), $this);?>
" <?php if ($this->_tpl_vars['key'] == $this->_tpl_vars['brand_id']): ?>selected<?php endif; ?>><?php echo $this->_tpl_vars['item']['title']; ?>
</option>
                            <?php endforeach; endif; unset($_from); ?>
                            </select>
                        </li>
                    </ul>
                </div>
            </div>

          <div id="content">

                <?php if ($this->_tpl_vars['body']): ?>
                    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['body'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

                <?php elseif ($this->_tpl_vars['body_as_text']): ?>
                    <?php echo $this->_tpl_vars['body_as_text']; ?>


                <?php endif; ?>
          </div>
        <div id="rightColumn">

            <div class="block" id="search">
                <div class="header">
                    <form action="" method="post" id="search_form">
                        <input type="text" name="search" placeholder="Поиск..." class="search" value="<?php echo $this->_tpl_vars['search']; ?>
"/>
                    </form>
                </div>
                <div class="content"></div>
            </div>

            <div class="block" id="campaign">
                <div class="header">
                    <a href="<?php echo $this->_config[0]['vars']['script_url']; ?>
<?php echo smarty_function_seo_url(array('rm' => 'Campaign'), $this);?>
">Акции</a>
                </div>
                <div class="content">
                    [news_module?section=8&short_list=1]
                </div>
            </div>
            <!--<div class="block" id="discount">
                <div class="header">
                    <a href="<?php echo $this->_config[0]['vars']['script_url']; ?>
<?php echo smarty_function_seo_url(array('rm' => 'Discount'), $this);?>
">Скидки</a>
                </div>
                <div class="content">
                    <?php if ($this->_tpl_vars['discount']): ?>
                         <div class="image">
                            <a href="<?php echo $this->_config[0]['vars']['script_url']; ?>
<?php echo smarty_function_seo_url(array('rm' => 'Product','param1' => $this->_tpl_vars['discount'][0]['id']), $this);?>
">
                                <img src="<?php echo $this->_config[0]['vars']['picture_url']; ?>
block_<?php echo $this->_tpl_vars['discount'][0]['picture1']; ?>
" alt="<?php echo $this->_tpl_vars['discount'][0]['name']; ?>
" />
                            </a>
                        </div>
                        <div class="name">
                            <a href="<?php echo $this->_config[0]['vars']['script_url']; ?>
<?php echo smarty_function_seo_url(array('rm' => 'Product','param1' => $this->_tpl_vars['discount'][0]['id']), $this);?>
"><?php echo $this->_tpl_vars['discount'][0]['name']; ?>
</a>
                        </div>
                        <div class="oldprice"><?php echo ((is_array($_tmp=$this->_tpl_vars['discount'][0]['price'])) ? $this->_run_mod_handler('money', true, $_tmp) : smarty_modifier_money($_tmp)); ?>
 р.</div>
                        <div class="newprice"><?php echo ((is_array($_tmp=$this->_tpl_vars['discount'][0]['newprice'])) ? $this->_run_mod_handler('money', true, $_tmp) : smarty_modifier_money($_tmp)); ?>
 р.</div>
                    <?php else: ?>
                        Нет скидок
                    <?php endif; ?>
                </div>
            </div>-->
            <div class="block" id="featured">
                <div class="header">
                    <a href="<?php echo $this->_config[0]['vars']['script_url']; ?>
<?php echo smarty_function_seo_url(array('rm' => 'Featured'), $this);?>
">Новинки</a>
                </div>
                <div class="content">
                    <?php if ($this->_tpl_vars['featured']): ?>
                        <div class="image">
                            <a href="<?php echo $this->_config[0]['vars']['script_url']; ?>
<?php echo smarty_function_seo_url(array('rm' => 'Product','param1' => $this->_tpl_vars['featured'][0]['id']), $this);?>
">
                                <img src="<?php echo $this->_config[0]['vars']['picture_url']; ?>
block_<?php echo $this->_tpl_vars['featured'][0]['picture1']; ?>
" alt="<?php echo $this->_tpl_vars['featured'][0]['name']; ?>
" />
                            </a>
                        </div>
                        <div class="name">
                            <a href="<?php echo $this->_config[0]['vars']['script_url']; ?>
<?php echo smarty_function_seo_url(array('rm' => 'Product','param1' => $this->_tpl_vars['featured'][0]['id']), $this);?>
"><?php echo $this->_tpl_vars['featured'][0]['name']; ?>
</a>
                        </div>
                        <div class="price"><?php echo ((is_array($_tmp=$this->_tpl_vars['featured'][0]['price'])) ? $this->_run_mod_handler('money', true, $_tmp) : smarty_modifier_money($_tmp)); ?>
 р.</div>
                    <?php else: ?>
                        Нет новинок
                    <?php endif; ?>
                </div>
            </div>
            <!--
            <div class="block" id="discount">
                <div class="header">
                    <a href="#">Акции</a>
                </div>
                <div class="content">
                    Нет акций
                </div>
            </div>
            -->
            <div class="block" id="news">
                <div class="header">
                    <a href="<?php echo $this->_config[0]['vars']['script_url']; ?>
<?php echo smarty_function_seo_url(array('rm' => 'News'), $this);?>
">Новости</a>
                </div>
                <div class="content">
                    [news_module?section=6&short_list=1]
                </div>
            </div>
            <div class="block" id="discount">
                <div class="header">
                    <a href="<?php echo $this->_config[0]['vars']['script_url']; ?>
<?php echo smarty_function_seo_url(array('rm' => 'Photogallery'), $this);?>
">Фотогалерея</a>
                </div>
                <div class="content">
                    <?php if ($this->_tpl_vars['gallery_photo']): ?>
                    <a href="<?php echo $this->_config[0]['vars']['script_url']; ?>
<?php echo smarty_function_seo_url(array('rm' => 'Photogallery'), $this);?>
">
                        <img src="<?php echo $this->_config[0]['vars']['script_url']; ?>
gallery/thumb_<?php echo $this->_tpl_vars['gallery_photo']; ?>
" alt="Галерея"/>
                    </a>
                    <?php else: ?>
                        Нет галереи
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div style="clear:both;"></div>
        <div id="footer">
            <p>Магазин недорогой и качественной детской одежды из Европы «МОДНЫЙ РЕБЕНОК» г. Томск</p>
        </div>
        </div>
    </div>
</div>
</body>
</html>