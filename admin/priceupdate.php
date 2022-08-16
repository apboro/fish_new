<?php
require('includes/application_top.php');
if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'update') {
    if (empty($_POST['supplier']) || empty($_POST['article']) || empty($_POST['type'])) {
        die('error');
    }
    $supplier_id = (int)$_POST['supplier'];
    $article_col = (int)$_POST['article'];
    $type = $_POST['type'];
    $file = '';
    if($type == 'link'){
        $file = $_POST['link'];
    }else{
        $file = $supplier_id . '.xls';
        move_uploaded_file($_FILES['file']['tmp_name'], DIR_FS_DOCUMENT_ROOT . 'prices/' . $supplier_id . '.xls');
    }
    tep_db_query("UPDATE `supplier` SET  `date_added`=CURDATE(), `type`='" . $type . "',`file`='".$file."',`article_col`='" . $article_col . "'
                  WHERE `supplier_id`=" . $supplier_id);
    die();
}

?>
    <!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
    <html <?php echo HTML_PARAMS; ?> >
    <head>
	<script src="js/jquery-3.1.1.min.js"></script>
	<style type="text/css"> 
.table_sort table {
    border-collapse: collapse;
}

.table_sort th {
    color: #ffebcd;
    background: #008b8b;
    cursor: pointer;
}

.table_sort td,
.table_sort th {
    width: 150px;
    height: 40px;
    text-align: center;
    border: 2px solid #846868;
}

.table_sort tbody tr:nth-child(even) {
    background: #e3e3e3;
}

th.sorted[data-order="1"],
th.sorted[data-order="-1"] {
    position: relative;
}

th.sorted[data-order="1"]::after,
th.sorted[data-order="-1"]::after {
    right: 8px;
    position: absolute;
}

th.sorted[data-order="-1"]::after {
	content: "▼"
}

th.sorted[data-order="1"]::after {
	content: "▲"
}
</style>
	
	
        <meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
        <title><?php echo TITLE; ?></title>

        <link rel="stylesheet" type="text/css" href="includes/style/bootstrap.css">
        <link rel="stylesheet" type="text/css" href="includes/style/datepicker.css">

        <link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
        <script language="javascript" src="includes/menu.js"></script>
        <script language="javascript" src="includes/general.js"></script>

    </head>
    <body>
	
    <body marginwidth="0" marginheight="0" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0"
          bgcolor="#FFFFFF" onload="SetFocus();">
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
                        <h1 class="headers">Обновление прайсов</h1>
                        <form onsubmit="updateSupplyPrices(this);return false;">
                            <select required class="form-control" onchange="changeSupplierPrice(this);" name="supplier" style="margin:15px 0px">
                                <?
                                $query = tep_db_query("
                            SELECT 
                            *
                            FROM
                            supplier
                            ");

                                while ($new_values = tep_db_fetch_array($query)) {
                                    $arrDel[] = $new_values;
                                }
                                echo "<option value=''>Выберите поставщика</option>";

                                foreach ($arrDel as $ar) {
                                    echo "<option data-article='" . $ar['article_col'] . "' data-file='" . $ar['file'] . "' data-type='" . $ar['type'] . "' value='" . $ar['supplier_id'] . "'>" . $ar['supplier_name'] . "</option>";
                                }

                                ?>
                            </select>
                            <select required name="type" class="form-control" onchange="changePriceType(this);"
                                    style="margin:15px 0px">
                                <option value="">Выбери тип файла</option>
                                <option value="link">Ссылка</option>
                                <option value="file">Файл</option>
                            </select>
                            <div class="types type-file" style="margin:15px 0px">
                                <input name="file" accept=".xls,.xlsx" type="file" class="form-control">
                                <div></div>
                            </div>
                            <div class="types type-link" style="margin:15px 0px">
                                <input type="text" name="link" class="form-control">
                            </div>
                            <div>Номер колонки с артикулом (Начинается с 1)</div>
                            <input type="number" min="1" name="article" class="form-control">
                            <button class="form-control save-button" style="margin:15px 0px; ">Сохранить</button>
                        </form>
                    </div>
                    <button class="form-control updater-button" onclick="startPriceUpdater(this);return false;" style="margin:0 auto; width:200px">Запустить обновление</button>
                </div>
				
	<?php
	/*
    $query_products=tep_db_query(
	"select p.supplier_id,
p.manufacturers_id, 
m.manufacturers_name 
from products p
left join 
manufacturers_info m 
on m.manufacturers_id=p.manufacturers_id
group by manufacturers_id
")
;
  while($suplis = tep_db_fetch_array($query_products)) {
	 if ($ar['supplier_id']=$suplis['supplier_id']){
	   tep_db_query("UPDATE supplier SET
	   brands = concat
	   (brands,
	   \"". $suplis['manufacturers_name'] .
	   ", \"" . ")".
	   " where supplier_id=". $suplis['supplier_id']); 
	 }
	 }*/
 	
	echo "<table class='table_sort' border=1 align=center>";
	echo "<thead><tr bgcolor='yellow'><th>Поставщик</th><th>Файл</th><th>Дата обновления</th><th>Товаров в прайсе</th><th>Товаров на сайте</th><th>Брэнды</th></tr></thead><tbody>";
	foreach ($arrDel as $ar) {
                                    echo "<tr><td>".$ar['supplier_name']."</td><td>" . $ar['file'] . "</td><td>" . $ar['date_added']. "</td><td>" .$ar['products_total'] ."</td>". "<td>" .$ar['products_active'] ."</td><td>" .$ar['brands'] ."</td></tr>";
                               }
							   echo "</tbody>";
    ?>								
                <!-- body_text_eof //-->
				</table>
            </td>
        </tr>
    </table>
<script> document.addEventListener('DOMContentLoaded', () => {

    const getSort = ({ target }) => {
        const order = (target.dataset.order = -(target.dataset.order || -1));
        const index = [...target.parentNode.cells].indexOf(target);
        const collator = new Intl.Collator(['en', 'ru'], { numeric: true });
        const comparator = (index, order) => (a, b) => order * collator.compare(
            a.children[index].innerHTML,
            b.children[index].innerHTML
        );
        
        for(const tBody of target.closest('table').tBodies)
            tBody.append(...[...tBody.rows].sort(comparator(index, order)));

        for(const cell of target.parentNode.cells)
            cell.classList.toggle('sorted', cell === target);
    };
    
    document.querySelectorAll('.table_sort thead').forEach(tableTH => tableTH.addEventListener('click', () => getSort(event)));
    
});

</script>

	
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