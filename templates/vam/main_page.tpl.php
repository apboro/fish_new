<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
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

<!-- Контейнер -->
<div id="container">

<!-- Шапка -->
<div id="header">

<b class="b1"></b><b class="b2"></b><b class="b3"></b><b class="b4"></b>
<table border="0" cellpadding="0" cellspacing="0" class="header">
<tr>
<td class="header-left">
<a href="<?php echo tep_href_link(FILENAME_DEFAULT); ?>"><img src="<?php echo DIR_WS_TEMPLATES . TEMPLATE_NAME;?>/images/oscommerce.gif" border="0" alt="<?php echo STORE_NAME; ?>" /></a>
</td>
<td class="header-center">
&nbsp;
</td>
<td class="header-right">
<?php
  if ($banner = tep_banner_exists('dynamic', '468x50')) {
?>
<?php echo tep_display_banner('static', $banner); ?>
<?php
  }
?>
</td>
</tr>
</table>
<b class="b4b"></b><b class="b3b"></b><b class="b2b"></b><b class="b1b"></b>

</div>
<!-- /Шапка -->

<div id="menu">
<b class="b1"></b><b class="b2"></b><b class="b3"></b><b class="b4"></b>
<ul>
<li<?php if (strstr($PHP_SELF, FILENAME_DEFAULT)) echo ' class="current"'; ?>><a href="<?php echo tep_href_link(FILENAME_DEFAULT); ?>"><span><?php echo HEADER_LINKS_DEFAULT; ?></span></a></li>
<li<?php if (strstr($PHP_SELF, FILENAME_PRODUCTS_NEW)) echo ' class="current"'; ?>><a href="<?php echo tep_href_link(FILENAME_PRODUCTS_NEW); ?>"><span><?php echo HEADER_LINKS_WHATS_NEW; ?></span></a></li>
<li<?php if (strstr($PHP_SELF, FILENAME_SHOPPING_CART)) echo ' class="current"'; ?>><a href="<?php echo tep_href_link(FILENAME_SHOPPING_CART); ?>"><span><?php echo HEADER_LINKS_CART; ?></span></a></li>
<li<?php if (strstr($PHP_SELF, FILENAME_CHECKOUT_SHIPPING) or strstr($PHP_SELF, FILENAME_CHECKOUT_PAYMENT) or strstr($PHP_SELF, FILENAME_CHECKOUT_CONFIRMATION) or strstr($PHP_SELF, FILENAME_CHECKOUT_SUCCESS)) echo ' class="current"'; ?>><a href="<?php echo tep_href_link(FILENAME_CHECKOUT_SHIPPING); ?>"><span><?php echo HEADER_LINKS_CHECKOUT; ?></span></a></li>
<?php if (tep_session_is_registered('customer_id')) { ?>
<li<?php if (strstr($PHP_SELF, FILENAME_LOGOFF)) echo ' class="current"'; ?>><a href="<?php echo tep_href_link(FILENAME_LOGOFF); ?>"><span><?php echo HEADER_LINKS_LOGOFF; ?></span></a></li>
<?php } else { ?>
<li<?php if (strstr($PHP_SELF, FILENAME_LOGIN)) echo ' class="current"'; ?>><a href="<?php echo tep_href_link(FILENAME_LOGIN); ?>"><span><?php echo HEADER_LINKS_LOGIN; ?></span></a></li>
<?php } ?>
</ul>
<b class="b4b"></b><b class="b3b"></b><b class="b2b"></b><b class="b1b"></b>
</div>

<!-- Навигация -->
<div id="navigation">
<span><?php echo $breadcrumb->trail(' &raquo; '); ?></span>
</div>
<!-- /Навигация -->

<div class="outer">
<b class="b1"></b><b class="b2"></b><b class="b3"></b><b class="b4"></b>
<div class="outer-page">

<!-- Центр -->
<div id="wrapper">
<div id="content">

<?php
  if (isset($content_template) && file_exists(DIR_WS_CONTENT .
basename($content_template))) { 
    require(DIR_WS_CONTENT . basename($content_template));
  } else {
    require(DIR_WS_CONTENT . $content . '.tpl.php');
  }
?>

</div>
</div>
<!-- /Центр -->

<!-- Левая колонка -->
<div id="left">

<?php require(DIR_WS_INCLUDES . 'column_left.php'); ?>

</div>
<!-- /Левая колонка -->

<!-- Правая колонка -->
<div id="right">

<?php require(DIR_WS_INCLUDES . 'column_right.php'); ?>

</div>
<!-- /Правая колонка -->

<div class="clear-left">
</div>

</div>
<b class="b4b"></b><b class="b3b"></b><b class="b2b"></b><b class="b1b"></b>
</div>

<div class="outer">
<b class="b1"></b><b class="b2"></b><b class="b3"></b><b class="b4"></b>
<div class="outer-page">
<!-- Низ -->
<div id="footer">
<p>
<?php require(DIR_WS_TEMPLATES . TEMPLATE_NAME . '/counters.txt'); ?>
</p>
<p>
<?php echo FOOTER_TEXT_BODY; ?>
</p>
<p>
<?php if (DISPLAY_PAGE_PARSE_TIME == 'true') { ?>
<?php echo TOTAL_QUERIES . $query_counts; ?>
<br />
<?php echo TOTAL_TIME . $query_total_time; ?>
<?php } ?>
</p>
</div>
<!-- /Низ -->
</div>
<b class="b4b"></b><b class="b3b"></b><b class="b2b"></b><b class="b1b"></b>
</div>

</div>
<!-- /Контейнер -->

</body>
</html>