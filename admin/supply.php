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

// $result = tep_db_fetch_array ($query);
// while ($new_values = tep_db_fetch_array($query)){
	// $arr[] = $new_values;
// }

// $query =  tep_db_query ( "
// SELECT
// products_extra_fields_value
// FROM
// products_to_products_extra_fields
// GROUP BY products_extra_fields_value
// ");

// while ($new_values = tep_db_fetch_array($query)){
	// $arr[] = $new_values;
// }



 ?>
<style>
.allforms {
width: 600px;
text-align: center;
}
</style>
<div class="container allforms" id="sandbox-container">
<h1 class="headers">Создание поставщика</h1>
<form action="done.php?action=1" method="post">

	<input class="form-control" type="text" name="supply" placeholder="Введите название нового поставщика">
<input class="form-control" type="submit" value="Создать Поставщика">
</form>
</div>
 <div class="container allforms">
 <h1 class="headers">Присвоение поставщика</h1>
 <form action="done.php?action=2" method="post">
 <select class="form-control"  name="supply" style="margin:15px 0px">
<?
$query =  tep_db_query ("
SELECT 
supplier_name
FROM
supplier 
GROUP BY supplier_id
");

while ($new_values = tep_db_fetch_array($query)){
	$arr[] = $new_values;
}
echo "<option>Выбери поставщика</option>";

foreach ($arr as $ar) {
	echo "<option value='".$ar['supplier_name']."'>".$ar['supplier_name']."</option>";
}

?>
</select>
 <select class="form-control"  name="manu" style="margin:15px 0px">
<?
$query2 =  tep_db_query ("
SELECT 
manufacturers_name
FROM
manufacturers_info 
");

while ($new_values2 = tep_db_fetch_array($query2)){
	$arr2[] = $new_values2;
}
echo "<option>Выбери производителя</option>";

foreach ($arr2 as $ar) {
	echo "<option value='".$ar['manufacturers_name']."'>".$ar['manufacturers_name']."</option>";
}

?>
</select>
<input class="form-control" type="submit" value="Присвоить Поставщика">
 </form>
</div>
<div class="container allforms">
<h1>Удалить Поставщика</h1>
<div >Удалить поставщика (При удалении поставщика он удаляется у товара)</div>
 <form action="done.php?action=3" method="post">
 <select class="form-control"  name="delete" style="margin:15px 0px">
<?
$query =  tep_db_query ("
SELECT 
supplier_name
FROM
supplier
");

while ($new_values = tep_db_fetch_array($query)){
	$arrDel[] = $new_values;
}
echo "<option>Выбери поставщика</option>";

foreach ($arrDel as $ar) {
	echo "<option value='".$ar['supplier_name']."'>".$ar['supplier_name']."</option>";
}

?>
</select>
<? // test ($arr);?>
<input class="form-control" type="submit" value="Удалить Поставщика">
</form>
</div>
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

<?

?>