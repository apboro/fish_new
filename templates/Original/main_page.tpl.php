<!DOCTYPE HTML>
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
    <meta name="viewport" content="width=1200">
	<meta name="yandex-verification" content="5f73d96997ea6595" />
<link rel="icon" href="favicon.ico" type="image/x-icon">
<base href="<?php echo preg_replace('/(.*)\/$/',"$1",(($request_type == 'SSL') ? HTTPS_SERVER : HTTP_SERVER) . DIR_WS_CATALOG); ?>">
<?php
// BOF: WebMakers.com Changed: Header Tag Controller v1.0
// Replaced by header_tags.php
if ( file_exists(DIR_WS_INCLUDES . 'header_tags.php') ) {
  require(DIR_WS_INCLUDES . 'header_tags.php');
} else {
?>
  <title><?php echo TITLE ?></title>
<?php
}
// EOF: WebMakers.com Changed: Header Tag Controller v1.0



// market block
?>
<script defer type="text/javascript" src="https://goodmod.ru/scripts/860a30d12434e339a9c1058b72a4887b/api.js"></script>


<?php
/*     global $sape;
     if (!defined('_SAPE_USER')){
        define('_SAPE_USER', '7b9d86ea9cc119e34bcf8de228c67ce9');
     }
     require_once(realpath($_SERVER['DOCUMENT_ROOT'].'/'._SAPE_USER.'/sape.php'));
    $o['force_show_code'] = true;
    $o['charset'] = 'UTF-8';
    $sape = new SAPE_client($o);
    unset($o)*/
?>

<!-- Никитины
<link rel="preload"  href="ext/css/font-awesome/css/font-awesome.min.css&display=swap" as="style" onload="this.onload=null;this.rel='stylesheet'"/>
<noscript><link rel="stylesheet" type="text/css" href="ext/css/font-awesome/css/font-awesome.min.css" /></noscript>
-->

<link href="ext/css/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="<?php echo TEMPLATE_STYLE;?>?v=13122019">

<?php
if (isset($javascript)){
    if (is_array($javascript)){
    foreach($javascript as $script){
    if (file_exists(DIR_WS_JAVASCRIPT .basename($script)))
	{ require(DIR_WS_JAVASCRIPT .basename($script)); }
	}
	}else{
	if (file_exists(DIR_WS_JAVASCRIPT .basename($javascript)))
	    { require(DIR_WS_JAVASCRIPT .basename($javascript)); }

	    }
    }
?>
<?php

/*------insert before head tag-------*/
?>
<link rel="stylesheet" type="text/css" href="<?php echo DIR_WS_TEMPLATES.TEMPLATE_NAME;?>/addon.css">
<script type="text/javascript" src="jscript/jquery/jquery.js"></script>
<script type="text/javascript">
function setCookie(key, value) {
	    var date = new Date(new Date().getTime() + 8640000000);
	    document.cookie = key+"="+value+"; path=/; expires=" + date.toUTCString();
        }
function getCookie(key) {
            var keyValue = document.cookie.match('(^|;) ?' + key + '=([^;]*)(;|$)');
            return keyValue ? keyValue[2] : null;
        }
function igetkeywords(obj, value,page){
var pos = $(obj).position();
id=$(obj).attr('id').substr(2);
/*

//TODO: Оптимизировать быстрый поиск
$("#keywords"+id).show();
$("#keywords"+id).css('left',-($("#keywords"+id).width()-2-$("#kw1").width())+'px');
$.get('nsearch.php', {action: 'keywords', v:value,p:page,id:$(obj).attr('id')},
    function ( data){
	$("#keywords"+id).html( data )
});
}*/
/*
 * js-throttle-debounce v0.1.0
 * https://github.com/emn178/js-throttle-debounce
 *
 * Copyright 2015, emn178@gmail.com
 *
 * Licensed under the MIT license:
 * http://www.opensource.org/licenses/MIT
 */
;(function(root, undefined) {
    'use strict';

    Function.prototype.throttle = function(delay, ignoreLast) {
        var func = this;
        var lastTime = 0;
        var timer;
        if(delay === undefined) {
            delay = 100;
        }
        return function() {
            var self = this, args = arguments;
            var exec = function() {
                lastTime = new Date();
                func.apply(self, args);
            };
            if(timer) {
                clearTimeout(timer);
                timer = null;
            }
            var diff = new Date() - lastTime;
            if (diff > delay) {
                exec();
            } else if(!ignoreLast) {
                timer = setTimeout(exec, delay - diff);
            }
        };
    };

    Function.prototype.debounce = function(delay) {
        var func = this;
        var timer;
        if(delay === undefined) {
            delay = 100;
        }
        return function() {
            var self = this, args = arguments;
            if(timer) {
                clearTimeout(timer);
                timer = null;
            }
            timer = setTimeout(function() {
                func.apply(self, args);
            }, delay);
        };
    };
}(this));
$(document).ready(function(){
    $search_ajax = igetkeywords.debounce(500);
    var quickSearch = function(event){
        if (event.which == 27) {
            $("#keywords1").hide();
            return;
        }
        var len = $(this).val();
        $("#search_page1").val(0);
        if (len.length > 2) {
            $search_ajax($(this), $(this).val(), 0);
        } else {
            $("#keywords1").html('').hide()
        }
    }
    $("#kw1").keyup(quickSearch);
});
</script>
<?php
/*------insert before head tag-------*/
?>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
            })(window,document,'script','//<?php echo $_SERVER['SERVER_NAME'];?>/ext/js/analytics.js','ga');
      ga('create', 'UA-24119572-1', 'auto');
      ga('send', 'pageview');
      setTimeout("ga('send', 'event', '10 seconds', 'read')",10000);
    </script>
<meta name="google-site-verification" content="0tX55NU_C46Hnb-PaCgGJAqC_kReOaYEXzMOz5RXxGQ" />
<script src="/ext/js/es5-shims.min.js"></script>
<script src="/ext/js/share.js"></script>
</head>
<body>
<div itemscope itemtype="http://schema.org/WebPage">
    <meta itemprop="name" content="<?=strip_tags($the_title)?>"/>
    <meta itemprop="description" content="<?=strip_tags($the_desc)?>"/>
    <link itemprop="url" href="<?=$canonicalURL?>"/>
</div>

<div class="md_switch">
<a title="Мобильная версия" href="<?php echo tep_href_link($PHP_SELF,tep_get_all_get_params().'&is_mobile=1');?>">
<i class="fa fa-3x fa-mobile"></i></a>
</div>
<div id="to-top"></div>
<div class="ya-share2" data-services="facebook,vkontakte,twitter,gplus,whatsapp,skype,odnoklassniki,moimirblogger,delicious,digg,reddit,linkedin,lj,viber,telegram" data-direction="vertical" data-limit="6" data-size="m"></div>



<!-- warnings //-->
<?php require(DIR_WS_INCLUDES . 'warnings.php'); ?>
<!-- warning_eof //-->
<!-- header //-->
<?php require(DIR_WS_TEMPLATES . TEMPLATE_NAME .'/header.php'); ?>
<!-- header_eof //-->
<!-- body //-->
<table border="0" width="100%" cellspacing="3" cellpadding="<?php echo CELLPADDING_MAIN; ?>">
  <tr>
<?php
if (DOWN_FOR_MAINTENANCE == 'true') {
  $maintenance_on_at_time_raw = tep_db_query("select last_modified from " . TABLE_CONFIGURATION . " WHERE configuration_key = 'DOWN_FOR_MAINTENANCE'");
  $maintenance_on_at_time= tep_db_fetch_array($maintenance_on_at_time_raw);
  define('TEXT_DATE_TIME', $maintenance_on_at_time['last_modified']);
}
?>

<?php
if (DISPLAY_COLUMN_LEFT == 'yes')  {
// WebMakers.com Added: Down for Maintenance
// Hide column_left.php if not to show
if (DOWN_FOR_MAINTENANCE =='false' || DOWN_FOR_MAINTENANCE_COLUMN_LEFT_OFF =='false') {
?>
    <td width="<?php echo BOX_WIDTH_LEFT; ?>" valign="top"><table border="0" class="leftcolumn" width="<?php echo BOX_WIDTH_LEFT; ?>" cellspacing="0" cellpadding="<?php echo CELLPADDING_LEFT; ?>">
<!-- left_navigation //-->
<?php require(DIR_WS_INCLUDES . 'column_left.php'); ?>
<!-- left_navigation_eof //-->
    </table></td>
<?php
}
}
?>
<!-- content //-->
    <td width="100%" valign="top">


        <?php
  if (isset($content_template)) {
    require(DIR_WS_CONTENT . $content_template);
  } else {
    require(DIR_WS_CONTENT . $content . '.tpl.php');
  }
?>
    </td>
<script type="text/javascript" src="/js/dcart.js?v=11092019"></script>
      <?php if (IS_MOBILE==1){ ?>
      <script src="/ext/script/internal.js?v=1"></script>
      <?php } ?>
<!-- content_eof //-->
<?php
// WebMakers.com Added: Down for Maintenance
// Hide column_right.php if not to show


if (DISPLAY_COLUMN_RIGHT == 'yes')  {
if (DOWN_FOR_MAINTENANCE =='false' || DOWN_FOR_MAINTENANCE_COLUMN_RIGHT_OFF =='false') {
?>
    <td width="<?php echo BOX_WIDTH_RIGHT; ?>" valign="top"><table class="rightcolumn" border="0" width="<?php echo BOX_WIDTH_RIGHT; ?>" cellspacing="0" cellpadding="<?php echo CELLPADDING_RIGHT; ?>">
<!-- right_navigation //-->
<?php require(DIR_WS_INCLUDES . 'column_right.php'); ?>
<!-- right_navigation_eof //-->
    </table></td>
<?php
}
}
?>
  </tr>
</table>
<!-- body_eof //-->

<!-- footer //-->
<?php require(DIR_WS_TEMPLATES . TEMPLATE_NAME .'/footer.php'); ?>
<!-- footer_eof //-->
<br>


</body>
</html>


