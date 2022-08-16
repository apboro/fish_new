<?php
/*
  $Id: index.php,v 1.2 2003/09/24 15:18:15 wilt Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/ 
  require('includes/application_top.php');

// BOF: KategorienAdmin / OLISWISS
  if ($login_groups_id != 1) {
    tep_redirect(tep_href_link(FILENAME_CATEGORIES, ''));
  }
// BOF: KategorienAdmin / OLISWISS

  $languages = tep_get_languages();
  $languages_array = array();
  $languages_selected = DEFAULT_LANGUAGE;
  for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
    $languages_array[] = array('id' => $languages[$i]['code'],
                               'text' => $languages[$i]['name']);
    if ($languages[$i]['directory'] == $language) {
      $languages_selected = $languages[$i]['code'];
    }
  }
?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<title><?php echo TITLE; ?></title> 
<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
</head>
<body marginwidth="0" marginheight="0" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0" bgcolor="#FFFFFF">
<!-- header //-->
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
<!-- header_eof //-->

<table border="0" width="100%" cellspacing="4" cellpadding="0">

<tr>

    <td width="<?php echo BOX_WIDTH; ?>" valign="top"><table border="0" width="<?php echo BOX_WIDTH; ?>" cellspacing="1" cellpadding="1" class="columnLeft">
<!-- left_navigation //-->
<?php require(DIR_WS_INCLUDES . 'column_left.php'); ?>
<!-- left_navigation_eof //-->
    </table></td>

<td align="left" width="100%" valign="top">
<table class="table-padding-0">

<tr>
    <td align="right" width="100%" valign="top">
<?php echo tep_draw_form('languages', 'index.php', '', 'get'); ?>
<?php echo TEXT_INDEX_LANGUAGE . tep_draw_pull_down_menu('language', $languages_array, $languages_selected, 'onChange="this.form.submit();"'); ?>
<?php echo tep_hide_session_id(); ?></form>
    </td>
</tr>

<tr>
    <td align="left" width="100%" valign="top">

<?php
  if (ENABLE_TABS == 'true') { 
?>
		<script type="text/javascript">
			$(function(){
				$('#tabs').tabs({ fx: { opacity: 'toggle', duration: 'fast' } });
			});
		</script>
<?php } ?>

<div id="tabs">

			<ul>
				<li><a href="#orders"><?php echo TEXT_SUMMARY_ORDERS; ?></a></li>
				<li><a href="#customers"><?php echo TEXT_SUMMARY_CUSTOMERS; ?></a></li>
				<li><a href="#products"><?php echo TEXT_SUMMARY_PRODUCTS; ?></a></li>
				<li><a href="#stat"><?php echo TEXT_SUMMARY_STAT; ?></a></li>
				<li><a href="#help"><?php echo TEXT_SUMMARY_HELP; ?></a></li>
			</ul>

<div id="orders">
<table border="0" width="93%">
<?php include(DIR_WS_MODULES . 'summary/orders.php'); ?>
</table>
</div>

<div id="customers">
<table border="0" width="93%">
<?php include(DIR_WS_MODULES . 'summary/customers.php'); ?>
</table>
</div>

<div id="products">
<table border="0" width="93%">
<?php include(DIR_WS_MODULES . 'summary/products.php'); ?>
</table>
</div>

<div id="stat">
<table border="0" width="93%">
<?php include(DIR_WS_MODULES . 'summary/statistics.php'); ?>
</table>
</div>

<div id="help">
<table border="0" width="93%">
<?php include(DIR_WS_MODULES . 'summary/help.php'); ?>
</table>
</div>

</div>    

</td>
</tr>


</table>
</td>
    
</tr>

<tr>
<td align="center" colspan="2" width="100%" valign="top">
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>      
</td>        
</tr>

</table>
</body>
</html>