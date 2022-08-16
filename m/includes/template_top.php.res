<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com
  Copyright (c) 2013 osCommerce
  Released under the GNU General Public License
*/
  $oscTemplate->buildBlocks();

  if (!$oscTemplate->hasBlocks('boxes_column_left')) {
    $oscTemplate->setGridContentWidth($oscTemplate->getGridContentWidth() + $oscTemplate->getGridColumnWidth());
  }

  if (!$oscTemplate->hasBlocks('boxes_column_right')) {
    $oscTemplate->setGridContentWidth($oscTemplate->getGridContentWidth() + $oscTemplate->getGridColumnWidth());
  }
?>
<?php
$osmart_query = tep_db_query("select * from " . osmart);
	while($osmart_color = tep_db_fetch_array($osmart_query)){
		$color = $osmart_color['osmart_color'];
		$_SESSION['themecolor_com'] = $color;
	}
	?>
<?php 
if($_SESSION['themecolor_com']=="slategray")
{
	$bgcolor = "#4B5668";
}
elseif($_SESSION['themecolor_com']=="red")
{
	$bgcolor = "#A52223";
}
elseif($_SESSION['themecolor_com']=="blue")
{
	$bgcolor = "#3692CA";
}
elseif($_SESSION['themecolor_com']=="navyblue")
{
	$bgcolor = "#23054F";
}
elseif($_SESSION['themecolor_com']=="brown")
{
	$bgcolor = "#322416";
}
elseif($_SESSION['themecolor_com']=="cyan")
{
	$bgcolor = "#008080";
}
elseif($_SESSION['themecolor_com']=="green")
{
	$bgcolor = "#509B00";
}
elseif($_SESSION['themecolor_com']=="pink")
{
	$bgcolor = "#DE5DA2";
}
else
{
	$bgcolor = "#4B5668";
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php echo HTML_PARAMS; ?> >

<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>" />
<title><?php echo tep_output_string_protected($oscTemplate->getTitle()); ?></title>
<base href="<?php echo (($request_type == 'SSL') ? HTTPS_SERVER : HTTP_SERVER) . DIR_WS_CATALOG; ?>" />
<!-- CSS files -->
<link href='http://fonts.googleapis.com/css?family=Lato:100,300,400,700,900,100italic,300italic,400italic,700italic,900italic' rel='stylesheet' type='text/css'>
<!--<link href='ext/font/lato' rel='stylesheet' type='text/css'>-->
<link rel="stylesheet" type="text/css" href="ext/css/<?php echo ((stripos(HTML_PARAMS, 'dir="rtl"') !== false) ? 'rtl_' : ''); ?>mj-template.css" />
<link rel="stylesheet" type="text/css" href="ext/jquery/ui/redmond/jquery-ui-1.10.4.min.css" />
<link rel="stylesheet" type="text/css" href="ext/css/<?php echo ((stripos(HTML_PARAMS, 'dir="rtl"') !== false) ? 'rtl_' : ''); ?>mj_tabcontent.css" />
<link rel="stylesheet" type="text/css" href="ext/css/<?php echo ((stripos(HTML_PARAMS, 'dir="rtl"') !== false) ? 'rtl_' : ''); ?>template.css" />
<link rel="stylesheet" type="text/css" href="ext/css/<?php echo ((stripos(HTML_PARAMS, 'dir="rtl"') !== false) ? 'rtl_' : ''); ?>mj-tab.css" />
<link rel="stylesheet" type="text/css" href="ext/css/<?php echo ((stripos(HTML_PARAMS, 'dir="rtl"') !== false) ? 'rtl_' : ''); ?>bootstrap.css" />
<link rel="stylesheet" type="text/css" href="ext/css/<?php echo ((stripos(HTML_PARAMS, 'dir="rtl"') !== false) ? 'rtl_' : ''); ?>bootstrap-responsive.css" />
<link rel="stylesheet" type="text/css" href="ext/css/<?php echo ((stripos(HTML_PARAMS, 'dir="rtl"') !== false) ? 'rtl_' : ''); ?>mj-general.css" />
<link rel="stylesheet" type="text/css" href="ext/css/<?php echo ((stripos(HTML_PARAMS, 'dir="rtl"') !== false) ? 'rtl_' : ''); ?>mj-mobile.css" />
<link rel="stylesheet" type="text/css" href="ext/css/<?php echo ((stripos(HTML_PARAMS, 'dir="rtl"') !== false) ? 'rtl_' : ''); ?>mj-ie.css" />
<link rel="stylesheet" type="text/css" href="ext/css/<?php echo ((stripos(HTML_PARAMS, 'dir="rtl"') !== false) ? 'rtl_' : ''); ?>mj-layout.css" />
<link rel="stylesheet" type="text/css" href="ext/css/<?php echo ((stripos(HTML_PARAMS, 'dir="rtl"') !== false) ? 'rtl_' : ''); ?>flexslider.css" />
<link rel="stylesheet" type="text/css" href="ext/css/font-awesome/css/font-awesome.css" />
<!--<script type="text/javascript" async="" src="http://www.google-analytics.com/ga.js"></script>-->
<link href="ext/css/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="ext/css/jquery.cookiebar.css" />

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
<!-- CSS files ends -->
<!-- JS files -->
<!--<script type="text/javascript" src="ext/jquery/jquery-1.11.1.min.js"></script>-->
<!--<script type="text/javascript" src="ext/jquery/ui/jquery-ui-1.10.4.min.js"></script>-->
<!--<script type="text/javascript" src="ext/jquery/jquery-1.8.0.min.js"></script>-->
<!--<script type="text/javascript" src="ext/jquery/ui/jquery-ui-1.8.22.min.js"></script>-->
<!--<script type="text/javascript" src="http://code.jquery.com/jquery-1.11.2.min.js"></script>-->
<!--<script type="text/javascript" src="ext/jquery/ui/jquery-ui-1.10.4.min.js"></script>-->

<!--<script type="text/javascript" src="//google-analytics.com/analytics.js"></script>-->
<!--<script src="ext/script/jquery-1.11.2.min.js"></script>
<script src="ext/script/jquery-migrate-1.2.1.min.js"></script>
-->
<script src="//code.jquery.com/jquery-1.11.2.min.js"></script>
<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>

<script type="text/javascript" src="ext/jquery/bootstrap.js"></script>
<script type="text/javascript" src="ext/jquery/bootstrap.min.js"></script>
<script type="text/javascript" src="ext/jquery/jquery.cookiebar.js"></script>
<!--<script type="text/plain" class="cc-onconsent-inline-advertising" src="http://pagead2.googlesyndication.com/pagead/show_ads.js"></script>-->

<script type="text/javascript">
var cookie= jQuery.noConflict();
cookie(document).ready(function(){
  cookie.cookieBar({
    declineButton: true,	
	autoEnable: true,
	fixed:true,	
	opacity:'0.5',
	zindex: '99999999999',
}); 
}); 
</script>
<script type="text/javascript">
var jqqqnoconf=jQuery.noConflict();
// fix jQuery 1.8.0 and jQuery UI 1.8.22 bug with dialog buttons; http://bugs.jqueryui.com/ticket/8484
if ( jqqqnoconf.attrFn ) { jqqqnoconf.attrFn.text = true; }
</script>
<script type="text/javascript">
	var tba = jQuery.noConflict();
	
	tba(document).ready(function(){       
            var scroll_pos = 0;
			
            tba(document).scroll(function() { 
			//alert("hello");
                scroll_pos = tba(this).scrollTop();
                if(scroll_pos > 25) {
                    tba("#mj-topbar").css('background-color', '<?php echo $bgcolor; ?>');
					tba("#mj-topbar").css('background-image','url("images/topbar-bg.png") repeat scroll 0 0 transparent');
					tba("#mj-topbar a").css('color', '#FFFFFF');
					tba("#mj-topbar i").css('color', '#FFFFFF');
					tba("#mj-topbar div").css('color', '#FFFFFF');
					//tba("#mj-topbar li").css('background', 'url("images/topbar-arrow-white.png") no-repeat scroll right center transparent');
					tba("#mj-topbar li:last-child").css('background', 'none');
                } 
				else 
				{
					tba("#mj-topbar").css('background','url("images/topbar-bg.png") repeat scroll 0 0 transparent');
					tba("#mj-topbar a").css('color', '<?php echo $bgcolor; ?>');
					tba("#mj-topbar i").css('color', '<?php echo $bgcolor; ?>');
					tba("#mj-topbar div").css('color', '<?php echo $bgcolor; ?>');
					//tba("#mj-topbar li").css('background', 'url("images/icons/<?php echo $_SESSION['themecolor_com']."-arrow.png" ?>") no-repeat scroll right center transparent');
					tba("#mj-topbar li:last-child").css('background', 'none');
                }
            });
        });
</script>
<?php
  if (tep_not_null(JQUERY_DATEPICKER_I18N_CODE)) {
?>
<script type="text/javascript" src="ext/jquery/ui/i18n/jquery.ui.datepicker-<?php echo JQUERY_DATEPICKER_I18N_CODE; ?>.js"></script>
<script type="text/javascript">
var jqnnndatre=jQuery.noConflict();
jqnnndatre.datepicker.setDefaults(jqnnndatre.datepicker.regional['<?php echo JQUERY_DATEPICKER_I18N_CODE; ?>']);
</script>
<?php
  }
?>
<script type="text/javascript" src="ext/photoset-grid/jquery.photoset-grid.min.js"></script>
<link rel="stylesheet" type="text/css" href="ext/colorbox/colorbox.css" />

<script type="text/javascript" src="ext/colorbox/jquery.colorbox-min.js"></script>
<!--<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>-->
<script type="text/javascript" src="ext/jquery/jquery.carouFredSel-6.0.4-packed.js"></script>
<script type="text/javascript" src="ext/jquery/jquery.flexslider.js"></script>
<script type="text/javascript" src="ext/jquery/osmart.js"></script>
<script type="text/javascript" src="ext/jquery/tabcontent.js"></script>
<script type="text/javascript" src="ext/jquery/css_browser_selector.js"></script>

<!-- JS files ends -->
<!-- Google Fonts -->
<!--<link href='http://fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css' />-->
<link href='ext/font/oswald' rel='stylesheet' type='text/css' />
<link href='ext/font/ptsans' rel='stylesheet' type='text/css' />
<?php 
/*if (isset($javascript)){
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
*/
?>


<!-- Google fonts ends -->
<?php require(DIR_WS_MODULES . 'top_bar.php'); ?>
<?php echo $oscTemplate->getBlocks('header_tags'); ?>





</head>
<body> <!--body area starts -->
	<div id="mj-container"> <!-- mj-container -->
		<?php require(DIR_WS_INCLUDES . 'header.php'); ?> <!-- inclusion of header file -->
        
		<div id="mj-maincontent"> <!-- mj-maincontent starts -->
			<div class="mj-subcontainer"> <!-- mj-subcontainer starts -->
				<div id="mj-contentarea" <?php 
				    if(($oscTemplate->hasBlocks('boxes_column_left') &&  basename($PHP_SELF) == FILENAME_PRODUCT_INFO) && ($oscTemplate->hasBlocks('boxes_column_right') &&  basename($PHP_SELF) == FILENAME_PRODUCT_INFO) ) { ?> class="mj-grid80 mj-lspace" style="right:0%; left:0%" <?php } elseif($boxes_column_left == true) { ?> class="mj-grid96 mj-lspace" style="right:17.5%" <?php } elseif($boxes_column_right == true) { ?> class="mj-grid64 mj-lspace" style="right:-1%" <?php }else { ?> class="mj-grid64 mj-lspace" <?php } ?>> <!-- mj-contentarea starts --> 
                
<!--<div id="bodyContent" class="grid_<?php echo $oscTemplate->getGridContentWidth(); ?> <?php echo ($oscTemplate->hasBlocks('boxes_column_left') ? 'push_' . $oscTemplate->getGridColumnWidth() : ''); ?>">-->
