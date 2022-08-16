<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<link rel="shortcut icon" href="favicon.ico" >
<base href="<?php echo (($request_type == 'SSL') ? HTTPS_SERVER : HTTP_SERVER) . DIR_WS_CATALOG; ?>">
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
?>

<link rel="stylesheet" type="text/css" href="<?php echo TEMPLATE_STYLE;?>">
<?php if (isset($javascript) && file_exists(DIR_WS_JAVASCRIPT .
basename($javascript))) { require(DIR_WS_JAVASCRIPT .
basename($javascript)); } ?>
</head>
<body>
<!-- warnings //-->
<?php require(DIR_WS_INCLUDES . 'warnings.php'); ?>
<!-- warning_eof //-->

<!-- header //-->
<?php
// WebMakers.com Added: Down for Maintenance
// Hide header if not to show
if (DOWN_FOR_MAINTENANCE_HEADER_OFF =='false') {

if (SITE_WIDTH!='100%') {
?>
    <table width="100%" cellpadding="10" cellspacing="0" border="0" BGCOLOR="#ffffff">
      <tr><td>
        <table CELLSPACING="2" CELLPADDING="4" BORDER="0" width="<?php echo SITE_WIDTH;?>" align="center" BGCOLOR="FFFFFF">
      <tr>
        <td>
        <table border="0" width="100%" bordercolor="#000000" style="border-collapse: collapse" cellpadding="0" cellspacing="0">
          <tr>
            <td>

<?php
}
?>
            <table width="100%" border="0" cellspacing="0" cellpadding="6">
  <tr>
        <td height="80" bgcolor="#ffffff" background="<?php echo DIR_WS_TEMPLATES . TEMPLATE_NAME;?>/images/bg_cat4.gif"><a href="index.php"><img src="<?php echo DIR_WS_TEMPLATES . TEMPLATE_NAME;?>/images/oscommerce.gif" border="0" alt="Интернет-магазин"></a></td>
        <td align="right" height="80" bgcolor="#ffffff" background="<?php echo DIR_WS_TEMPLATES . TEMPLATE_NAME;?>/images/bg_cat4.gif">

<?php
  if ($banner = tep_banner_exists('dynamic', '468x50')) {
?>
<?php echo tep_display_banner('static', $banner); ?>
<?php
  }
?>


<?php
// show Cart Details
 if (SHOW_CART_DETAILS_HEADER=='1') {
?>
  <table class="table-padding-0">
    <tr>
      <td class="ShowCartDetails" align="right" height="30" valign="middle">
        <?php echo '[ ' . $cart->count_contents() . ($cart->count_contents() == "1" ? " Item" : " Items "); ?> &nbsp;&nbsp; <?php echo $currencies->format($cart->show_total()); ?> &nbsp;&nbsp; <?php echo $cart->show_weight() . ($cart->show_weight() == "1" ? " lb" : " lbs ");?>&nbsp;]&nbsp;&nbsp;
      </td>
    </tr>
  </table>
<?php
}
?></td>
  </tr>
</table>
<?php
}
?>

<?php // BOF: WebMakers.com Added: Show Header Link Buttons
 if (SHOW_HEADER_LINK_BUTTONS =='yes') {
if (DOWN_FOR_MAINTENANCE =='false') {
?>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
<tr><td bgcolor="black" height="1" colspan=2></td></tr>
<tr class="headerNavigation">
<td class="headerNavigation" height="25" align="center" colspan="2">
| <?php echo '<a class="headernavigation1" href="' . tep_href_link(FILENAME_DEFAULT) . '">' . HEADER_LINKS_DEFAULT . '</a>'; ?>  
| <?php echo '<a class="HeaderPageLinks" href="' . tep_href_link(FILENAME_PRODUCTS_NEW) . '">' . HEADER_LINKS_WHATS_NEW . '</a>'; ?> | 
<?php if (tep_session_is_registered('customer_id')) { ?>
<?php echo '<a class="HeaderPageLinks" href="' . tep_href_link(FILENAME_CHECKOUT_SHIPPING) . '">' . HEADER_LINKS_CHECKOUT . '</a>'; ?> |
<?php echo '<a class="HeaderPageLinks" href="' . tep_href_link(FILENAME_LOGOFF) . '">' . HEADER_LINKS_LOGOFF . '</a>'; ?> |
<?php } else { ?>
<?php echo '<a class="HeaderPageLinks" href="' . tep_href_link(FILENAME_LOGIN) . '">' . HEADER_LINKS_LOGIN . '</a>'; ?> |
<?php } ?>
<?php echo '<a class="HeaderPageLinks" href="' . tep_href_link(FILENAME_SHOPPING_CART) . '">' . HEADER_LINKS_CART . '</a>'; ?> |

</td>
</tr>
<tr><td bgcolor="black" height="1" colspan="2"></td></tr>
<!-- /Закладки, стартовая страница -->
</table>
<?php
 }
}
?>

<?php if (SHOW_HEADING_TITLE_ORIGINAL == 'yes'){ ?>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
<tr class="headerNavigation1">
<td  class="headerNavigation1" height="25" align="left" colspan="2">
&nbsp;&nbsp;<?php echo $breadcrumb->trail(' &raquo; '); ?>
</td></tr>
<?php } ?>

<tr><td bgcolor="black" height="1" colspan=2></td></tr>
</tr>
</table>


<!-- header_eof //-->
<!-- body //-->
<table border="0" width="100%" cellspacing="3" cellpadding="<?php echo CELLPADDING_MAIN; ?>" background="<?php echo DIR_WS_TEMPLATES . TEMPLATE_NAME;?>/images/bg_cat4.gif">
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
    <td width="<?php echo BOX_WIDTH_LEFT; ?>" valign="top"><table border="0" width="<?php echo BOX_WIDTH_LEFT; ?>" cellspacing="0" cellpadding="<?php echo CELLPADDING_LEFT; ?>">
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
  if (isset($content_template) && file_exists(DIR_WS_CONTENT .
basename($content_template))) { 
    require(DIR_WS_CONTENT . basename($content_template));
  } else {
    require(DIR_WS_CONTENT . $content . '.tpl.php');
  }
?>
    </td>
<!-- content_eof //-->
<?php
// WebMakers.com Added: Down for Maintenance
// Hide column_right.php if not to show
//  if (substr(basename($PHP_SELF), 0, 7) !='account') {
if (DISPLAY_COLUMN_RIGHT == 'yes')  {
if (DOWN_FOR_MAINTENANCE =='false' || DOWN_FOR_MAINTENANCE_COLUMN_RIGHT_OFF =='false') {
?>
    <td width="<?php echo BOX_WIDTH_RIGHT; ?>" valign="top"><table border="0" width="<?php echo BOX_WIDTH_RIGHT; ?>" cellspacing="0" cellpadding="<?php echo CELLPADDING_RIGHT; ?>">
<!-- right_navigation //-->
<?php require(DIR_WS_INCLUDES . 'column_right.php'); ?>
<!-- right_navigation_eof //-->
    </table></td>
<?php
}
}
//}
?>
  </tr>
</table>
<!-- body_eof //-->

<!-- footer //-->
<br>
<!--Counters-->
<br>
<center>
<span class="smallText">
<?php require(DIR_WS_TEMPLATES . TEMPLATE_NAME . '/counters.txt'); ?>
</span>
</center>
<br>
<!--/Counters-->
<?php echo FOOTER_TEXT_BODY; ?>
<br>
<center>
<span class="smallText">
<?php if (DISPLAY_PAGE_PARSE_TIME == 'true') { ?>
<?php echo TOTAL_QUERIES . $query_counts; ?>
<br>
<?php echo TOTAL_TIME . $query_total_time; ?>
<?php } ?>
</span>
</center>


<!-- footer_eof //-->
<br>
</body>
</html>

