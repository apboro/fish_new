<?php
ini_set('display_errors','On');
error_reporting('E_ALL');
require('includes/application_top.php');
?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<title><?php echo TITLE; ?></title>
<link rel="stylesheet" type="text/css" href="bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
<script language="javascript" src="includes/menu.js"></script>
<script language="javascript" src="includes/general.js"></script>
</head>
<body marginwidth="0" marginheight="0" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0" bgcolor="#FFFFFF" onload="SetFocus();">

<!-- header //-->
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
<!-- header_eof //-->

<!-- body //-->
<table border="0" width="100%" cellspacing="2" cellpadding="2">
		<td width="<?php echo BOX_WIDTH; ?>" valign="top">


<!-- left_navigation //-->
<?php require(DIR_WS_INCLUDES . 'column_left.php'); ?>
<!-- left_navigation_eof //-->
</td>
<td>

<hr class="style13">
<input class="form-control" type="text" placeholder="Фильтровать остатки по Название, артикул, категория" id="search-text" onkeyup="tableSearch()">
<table class="table table-striped" id="info-table">
    <thead>
<tr><th>Название</th><th>Артикул</th><th>Количество</th><th>Цена</th><th>Категория</th><th>Штрихкод</th></tr></thead><tbody>

<?php
$tovar_query= tep_db_query("SELECT p.products_id, pd.products_name, p.products_model, p.products_quantity, 
  p.manufacturers_id, p.products_price, pd.products_barcode,
  cd.categories_name, c.parent_id
  FROM products as p 
  INNER JOIN products_to_categories as p2c
  ON p.products_quantity > 0 AND p.products_quantity < 100 AND  p.products_id = p2c.products_id
  INNER JOIN categories as c
  ON p2c.categories_id = c.categories_id
  INNER JOIN products_description as pd
  ON p.products_id = pd.products_id
  INNER JOIN categories_description as cd
  ON p2c.categories_id=cd.categories_id 
  ORDER BY p.products_price desc");


  
  
while ($tovars = tep_db_fetch_array($tovar_query)){
$str123 = $tovars['products_name'];
$rus = array('А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ъ', 'Ы', 'Ь', 'Э', 'Ю', 'Я', 'а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'ю', 'я', '-', ' ', '0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '.', '(', ')', ',', '№','"');
$lat = array('A', 'B', 'V', 'G', 'D', 'E', 'E', 'Gh', 'Z', 'I', 'Y', 'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'U', 'F', 'H', 'C', 'Ch', 'Sh', 'Sch', 'Y', 'Y', 'Y', 'E', 'Yu', 'Ya', 'a', 'b', 'v', 'g', 'd', 'e', 'e', 'gh', 'z', 'i', 'y', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'h', 'c', 'ch', 'sh', 'sch', 'y', 'y', 'y', 'e', 'yu', 'ya', '*', '-', '*', '*', '*', '*', '*', '*', '*', '*', '*', '*', '', '', '', '', '','');
$url1 = str_replace($rus, $lat, $str123);
if (strpos($url1, "*") !== false) {
$url = strstr($url1, '*', true);
$url2 = substr($url, -1);
if($url2 == "-"){
  $url = substr($url,0,-1);
}
}
$producturl = $url . '-p-' . $tovars['products_id'];  


echo '<tr><td>';
echo '<a target="_blank" href="https://yourfish.ru/'.$producturl.'">' .$tovars['products_name'] . "</a></td>";
echo '<td>';
echo $tovars['products_model'] . "</td>";
echo '<td>';
echo $tovars['products_quantity'] . "</td>";
echo '<td>';
echo round($tovars['products_price']) . "руб. </td>";
echo '<td>';
echo $tovars['categories_name'] . "</td>";
echo '<td>';
echo $tovars['products_barcode'] . "</td>";
echo'</tr>';

}
//var_dump($tovars);

//require(DIR_WS_INCLUDES . 'footer.php');
require(DIR_WS_INCLUDES . 'application_bottom.php');
 ?>
 </tbody></table>
 <script>
function tableSearch() {
    var phrase = document.getElementById('search-text');
    var table = document.getElementById('info-table');
    var regPhrase = new RegExp(phrase.value, 'i');
    var flag = false;
    for (var i = 1; i < table.rows.length; i++) {
        flag = false;
        for (var j = table.rows[i].cells.length - 1; j >= 0; j--) {
            flag = regPhrase.test(table.rows[i].cells[j].innerHTML);
            if (flag) break;
        }
        if (flag) {
            table.rows[i].style.display = "";
        } else {
            table.rows[i].style.display = "none";
        }

    }
}

</script>