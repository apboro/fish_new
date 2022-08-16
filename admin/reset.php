<?php
require('includes/application_top.php');
$action=$_GET['action'];
$action=preg_replace('|[^\w]|','',$action)
?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?> >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<title><?php echo TITLE; ?></title>
<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
<script language="javascript" src="includes/menu.js"></script>
<script language="javascript" src="includes/general.js"></script>
</head>
<body marginwidth="0" marginheight="0" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0" bgcolor="#FFFFFF" onload="SetFocus();">
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
<!-- header_eof //-->
<!-- body //-->
<table border="0" width="100%" cellspacing="2" cellpadding="2">
<tr>
<td width="<?php echo BOX_WIDTH; ?>" valign="top">
<table border="0" width="<?php echo BOX_WIDTH; ?> " cellspacing="1" cellpadding="1" class="columnLeft">
<!-- left_navigation //-->
<?php require(DIR_WS_INCLUDES . 'column_left.php'); ?>
<!-- left_navigation_eof //-->
</table>
</td>
<td width=100% valign=top>
<!-- body_text -->
<?php 
if ($action=='reset'){
    echo '<p>Выполняем обнуление</p>';
    tep_db_query('UPDATE `products` SET `products_quantity`=9999 WHERE `products_quantity`>0');
    }
$count=0;
$qry=tep_db_query('select count(*)as cnt from products where products_quantity>0');
if ($qry!==false){
    $res=tep_db_fetch_array($qry);
    $count=$res['cnt'];
    }
echo '<p>Обнулим '.$count.' товаров</p>';
?>
<form method="GET" action="<?php echo DIR_WS_ADMIN.basename(__FILE__);?>">
<input type="hidden" name="action" value="reset">
<input type="submit" value="обнулить остатки магазина">
</form>
<!-- body_eof //-->
<!-- footer //-->
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<!-- footer_eof //-->

