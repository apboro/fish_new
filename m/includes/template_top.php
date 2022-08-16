	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php 
define('ALL_IN_ONE',true);

  $oscTemplate->buildBlocks();
  if (!$oscTemplate->hasBlocks('boxes_column_left')) {
    $oscTemplate->setGridContentWidth($oscTemplate->getGridContentWidth() + $oscTemplate->getGridColumnWidth());
  }
  if (!$oscTemplate->hasBlocks('boxes_column_right')) {
    $oscTemplate->setGridContentWidth($oscTemplate->getGridContentWidth() + $oscTemplate->getGridColumnWidth());
  }
$color='blue';
$_SESSION['themecolor_com']='blue';
$bgcolor = "#3692CA";
?>
<html xmlns="http://www.w3.org/1999/xhtml" <?php echo HTML_PARAMS; ?>>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>" />
<meta name="theme-color" content = "#358FC6">
<?php
if ( file_exists(DIR_FS_CATALOG.DIR_WS_INCLUDES . 'header_tags.php') ) {
  require(DIR_FS_CATALOG.DIR_WS_INCLUDES . 'header_tags.php');
  } else {
  ?>
<title><?php echo tep_output_string_protected($oscTemplate->getTitle()); ?></title>
<?php }?>
<base href="<?php echo (($request_type == 'SSL') ? HTTPS_SERVER : HTTP_SERVER) . DIR_WS_CATALOG; ?>" />
<?php if (ALL_IN_ONE===false){?>
<link rel="stylesheet" type="text/css" href="ext/css/<?php echo ((stripos(HTML_PARAMS, 'dir="rtl"') !== false) ? 'rtl_' : ''); ?>mj-template.css" />
<link rel="stylesheet" type="text/css" href="ext/css/<?php echo ((stripos(HTML_PARAMS, 'dir="rtl"') !== false) ? 'rtl_' : ''); ?>mj_tabcontent.css" />
<link rel="stylesheet" type="text/css" href="ext/css/<?php echo ((stripos(HTML_PARAMS, 'dir="rtl"') !== false) ? 'rtl_' : ''); ?>template.css" />
<link rel="stylesheet" type="text/css" href="ext/css/<?php echo ((stripos(HTML_PARAMS, 'dir="rtl"') !== false) ? 'rtl_' : ''); ?>mj-tab.css" />
<link rel="stylesheet" type="text/css" href="ext/css/<?php echo ((stripos(HTML_PARAMS, 'dir="rtl"') !== false) ? 'rtl_' : ''); ?>bootstrap.css" />
<link rel="stylesheet" type="text/css" href="ext/css/<?php echo ((stripos(HTML_PARAMS, 'dir="rtl"') !== false) ? 'rtl_' : ''); ?>bootstrap-responsive.css" />
<link rel="stylesheet" type="text/css" href="ext/css/<?php echo ((stripos(HTML_PARAMS, 'dir="rtl"') !== false) ? 'rtl_' : ''); ?>mj-general.css" />
<link rel="stylesheet" type="text/css" href="ext/css/<?php echo ((stripos(HTML_PARAMS, 'dir="rtl"') !== false) ? 'rtl_' : ''); ?>mj-mobile.css" />
<link rel="stylesheet" type="text/css" href="ext/css/<?php echo ((stripos(HTML_PARAMS, 'dir="rtl"') !== false) ? 'rtl_' : ''); ?>mj-ie.css" />
<link rel="stylesheet" type="text/css" href="ext/css/<?php echo ((stripos(HTML_PARAMS, 'dir="rtl"') !== false) ? 'rtl_' : ''); ?>mj-layout.css" />
<link rel="stylesheet" type="text/css" href="ext/css/mj-menu.css"/>
<link rel="stylesheet" type="text/css" href="ext/colorbox/colorbox.css" />
<link rel="stylesheet" type="text/css" href="ext/css/mj-<?php if ($_SESSION['themecolor_com'] != ""){ echo $_SESSION['themecolor_com']; }else { echo "slategray"; } ?>.css" />
<?php }else { ?>
<!--
Никитины изменения 
<link href="ext/css/aio.css?v=6" rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'"/>
<noscript><link href='ext/css/aio.css?v=6' rel='stylesheet' type='text/css' /></noscript>
<?php// } ?>
<link href='https://fonts.googleapis.com/css?family=Oswald&display=swap'  rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'"/>
<link href='https://fonts.googleapis.com/css?family=PT+Sans&display=swap'  rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'"/>
<link rel="preload"  href="ext/css/font-awesome/css/font-awesome.min.css&display=swap" as="style" onload="this.onload=null;this.rel='stylesheet'"/>
<noscript><link href='https://fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css' /></noscript>
<noscript><link href='https://fonts.googleapis.com/css?family=PT+Sans' rel='stylesheet' type='text/css' /></noscript>
<noscript><link rel="stylesheet" type="text/css" href="ext/css/font-awesome/css/font-awesome.min.css" /></noscript>

-->
<link rel="stylesheet" type="text/css" href="ext/css/aio.css?v=6"/>
<?php } ?>
<link href='https://fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css' />
<link href='https://fonts.googleapis.com/css?family=PT+Sans' rel='stylesheet' type='text/css' />
<link rel="stylesheet" type="text/css" href="ext/css/font-awesome/css/font-awesome.min.css"/>

<?php
if((basename($PHP_SELF) == FILENAME_DEFAULT && $cPath == '') && !isset($_GET['manufacturers_id'])) { ?>
	<link rel="stylesheet" type="text/css" href="ext/css/<?php echo ((stripos(HTML_PARAMS, 'dir="rtl"') !== false) ? 'rtl_' : ''); ?>homepage.css" />
<?php }else
{ ?>
	<link rel="stylesheet" type="text/css" href="ext/css/<?php echo ((stripos(HTML_PARAMS, 'dir="rtl"') !== false) ? 'rtl_' : ''); ?>nohomepage.css" />
<?php } ?>  
<!--[if IE]>
<link rel="stylesheet" type="text/css" href="ext/css/<?php echo ((stripos(HTML_PARAMS, 'dir="rtl"') !== false) ? 'rtl_' : ''); ?>mj-ie8.css" />
<![endif]-->
<?php if (ALL_IN_ONE===false){?>
<script src="ext/script/jquery-1.11.3.min.js"></script>
<script src="ext/script/jquery-migrate-1.2.1.min.js"></script>

<script type="text/javascript" src="ext/jquery/bootstrap.js"></script>
<script type="text/javascript" src="ext/jquery/bootstrap.min.js"></script>

<script type="text/javascript" src="ext/colorbox/jquery.colorbox-min.js"></script>
<script type="text/javascript" src="ext/jquery/osmart.js"></script>
<script type="text/javascript" src="ext/jquery/tabcontent.js"></script>
<script type="text/javascript" src="ext/jquery/css_browser_selector.js"></script>

<script src="ext/script/internal.js"></script>
<script type="text/javascript" src="/ddaccordion.js"></script>
<?php }else{ ?>
<script type="text/javascript" src="/ext/aio.js?v=11092019a" async></script>
<?php }?>



<script type="text/javascript">
<?php /* ?>
var cookie= jQuery.noConflict();
cookie(document).ready(function(){cookie.cookieBar({declineButton: true,autoEnable: true,fixed:true,opacity:'0.5',zindex: '99999999999',}); 
}); 
<?php */ ?>
var jqqqnoconf=jQuery.noConflict();
if ( jqqqnoconf.attrFn ) { jqqqnoconf.attrFn.text = true; }
	var tba = jQuery.noConflict();
	tba(document).ready(function(){       
            var scroll_pos = 0;
            tba(document).scroll(function() { 
                scroll_pos = tba(this).scrollTop();
                if(scroll_pos > 25) {
		tba("#glide1").hide();
		tba("#glide2").show();
                    tba("#mj-topbar").css('background-color', '<?php echo $bgcolor; ?>');
					tba("#mj-topbar").css('background-image','url("images/topbar-bg.png") repeat scroll 0 0 transparent');
					tba("#mj-topbar a").css('color', '#FFFFFF');
					tba("#mj-topbar i").css('color', '#FFFFFF');
					tba("#mj-topbar div").css('color', '#FFFFFF');
					tba("#mj-topbar li:last-child").css('background', 'none');
                }else{
		tba("#glide2").hide();
		tba("#glide1").show();
    		tba("#mj-topbar").css('background','url("images/topbar-bg.png") repeat scroll 0 0 transparent');
		tba("#mj-topbar a").css('color', '<?php echo $bgcolor; ?>');
		tba("#mj-topbar i").css('color', '<?php echo $bgcolor; ?>');
		tba("#mj-topbar div").css('color', '<?php echo $bgcolor; ?>');
		tba("#mj-topbar li:last-child").css('background', 'none');
                }
            });
	tba(document).scroll();
        });
</script>


<?php
if (isset($javascript)){
    if (is_array($javascript)){
        foreach($javascript as $script){
        if (file_exists(DIR_FS_CATALOG.DIR_WS_JAVASCRIPT .basename($script)))
            { require(DIR_FS_CATALOG.DIR_WS_JAVASCRIPT .basename($script)); }
    	    }
        }else{
        if (file_exists(DIR_FS_CATALOG.DIR_WS_JAVASCRIPT .basename($javascript)))
        { require(DIR_FS_CATALOG.DIR_WS_JAVASCRIPT .basename($javascript)); }
    }
}
//require(DIR_WS_MODULES . 'top_bar.php'); 
?>

<?php
require(DIR_WS_INCLUDES . 'counters_head.php'); 
?>
</head>
<body> 
<div class="md_switch">
<a  id="glide1" title="Обычная версия" href="<?php echo tep_href_link($PHP_SELF,tep_get_all_get_params().'&is_mobile=0');?>">
<i  class="fa fa-2x fa-desktop"></i></a>
<a href="/"><img id="glide2" loading="auto" style="display:none" width="30" height="30" border="0" loading="lazy" src="templates/Original/images/content/default.gif" alt="<?php echo STORE_NAME;?>" title="<?php echo STORE_NAME;?>"></a>
</div>

	<div id="mj-container"> 
		<?php require(DIR_WS_INCLUDES . 'header.php'); ?> 
		<div id="mj-maincontent"> 
			<div class="mj-subcontainer"> 
				<div id="mj-contentarea" <?php if(($oscTemplate->hasBlocks('boxes_column_left') &&  basename($PHP_SELF) == FILENAME_PRODUCT_INFO) && ($oscTemplate->hasBlocks('boxes_column_right') &&  basename($PHP_SELF) == FILENAME_PRODUCT_INFO) ) { ?> class="mj-grid80 mj-lspace" style="right:0%; left:0%" <?php } elseif($boxes_column_left == true) { ?> class="mj-grid96 mj-lspace" style="right:17.5%" <?php } elseif($boxes_column_right == true) { ?> class="mj-grid64 mj-lspace" style="right:-1%" <?php }else { ?> class="mj-grid64 mj-lspace" <?php } ?>> 
