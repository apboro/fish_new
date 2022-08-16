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
$folder =  getcwd();
echo 123;

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


	
function test ($a) {
echo "<pre>";
print_r($a);
echo "</pre>";
}
// test($result);
test($arr);
 ?>

<div class="container" id="sandbox-container" style="width: 435px;text-align: center;">
<form action="csv.php" method="post">
    <div class="input-daterange input-group" id="datepicker">
    <input class="input-sm form-control" name="start" type="text">
    <span class="input-group-addon">Рэнж</span>
    <input class="input-sm form-control" name="end" type="text">
    </div>
	<select class="form-control" id="manu" name="manu" style="margin:15px 0px">
<?
// $query =  tep_db_query ("
// SELECT 
// products_extra_fields_value
// FROM
// products_to_products_extra_fields 
// GROUP BY products_extra_fields_value
// ");
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
echo "<option value='no'>Без выбора поставщика</option>";
foreach ($arr as $ar) {
	echo "<option value='".$ar['supplier_name']."'>".$ar['supplier_name']."</option>"; 
}

?>
</select>
<input class="form-control" type="submit" value="Создать">
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
<script language="javascript" src="includes/javascript/bootstrap-datepicker.js"></script>
<script>

$(document).ready(function() {
$('#sandbox-container .input-daterange').datepicker({
  format:"yyyy-mm-dd",  
    });
});

// $('#manu').on('change', function() {
		// var id = 1;
			// console.log(1);
 // jQuery.ajax({
            // url: '<? echo $folder;?>/csv.php?query=1',
                    // type:     "POST", //Тип запроса
                    // dataType: "html", //Тип данных
                     // data:  {id:id },  
					  // success: function(data){
					  // $("#manu").html(data);
					  // },
					   // });
				
		// });
</script>
</body>
</html>

