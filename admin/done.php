<?php 
require('includes/application_top.php');
define('CURRENT_FOLDER',DIR_FS_CATALOG.'cron');
if (!file_exists(CURRENT_FOLDER)){@mkdir(CURRENT_FOLDER,0770,true);}
define('CURRENT_DATA',CURRENT_FOLDER.'/data.bin');
define('CHARSET','UTF-8');

?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?> >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<title><?php echo TITLE; ?></title>

<link rel="stylesheet" type="text/css" href="includes/style/bootstrap.css">
<link rel="stylesheet" type="text/css" href="includes/style/datepicker.css">

<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
<script language="javascript" src="includes/menu.js"></script>
<script language="javascript" src="includes/general.js"></script>

</head>
<body>
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

?>
<div class="panel">



<? 

if($_REQUEST['action'] == 1) {
	$query =  tep_db_query ("INSERT INTO `supplier`(`supplier_name`) VALUES ('".$_POST['supply']."');");
	if ($query) 
		echo 'Запрос обработан, поставщик добавлен!';
	else
		echo "Что-то пошло не так!";
}


if($_REQUEST['action'] == 2) {
$query =  tep_db_query ("
UPDATE `products` SET `supplier_id` = (SELECT `supplier_id` FROM `supplier` WHERE `supplier_name` = '".$_POST['supply']."') WHERE `manufacturers_id` = (SELECT `manufacturers_id` FROM `manufacturers_info` WHERE `manufacturers_name` = '".$_POST['manu']."')");
	if ($query) 
		echo 'Запрос обработан, поставщик присвоен!';
	else
		echo "Что-то пошло не так!";
}

if($_REQUEST['action'] == 3 ){

$query2 =  tep_db_query ("
	UPDATE `products` SET `supplier_id`= 0 WHERE `supplier_id`=(SELECT `supplier_id` FROM `supplier` WHERE `supplier_name` = '".$_POST['delete']."');
	");

if ($query2) {
	echo "Удалилен поставщик ".$_POST['delete'];
	$query =  tep_db_query ("DELETE FROM `supplier` WHERE `supplier_name`= '".$_POST['delete']."';");
}
	}

if($_REQUEST['action'] == 4 ){
	
}

?>

<button type="button" class="btn btn-info" onclick="location.href='supply.php'">Назад</button>
</div>

<!-- body_text_eof //-->
</td>
</tr>
</table>
<!-- body_eof //-->
<!-- footer //-->
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<!-- footer_eof //-->
<br>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script language="javascript" src="includes/javascript/bootstrap.js"></script>
<!--script language="javascript" src="includes/javascript/bootstrap-datepicker.js"></script-->

</body>
</html>
?>