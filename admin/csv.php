<?
require('includes/application_top.php');
define('CURRENT_FOLDER',DIR_FS_CATALOG.'cron');
if (!file_exists(CURRENT_FOLDER)){@mkdir(CURRENT_FOLDER,0770,true);}
define('CURRENT_DATA',CURRENT_FOLDER.'/data.bin');
define('CHARSET','UTF-8');

$start = $_POST['start'];
$end = $_POST['end'];
$manu = $_POST['manu'];

	
function test ($a) {
echo "<pre>";
print_r($a);
echo "</pre>";
}

// test($_POST);

function convert_to_csv($input_array, $output_file_name, $delimiter, $head)
{
    /** open raw memory as file, no need for temp files, be careful not to run out of memory thought */
    $f = fopen('php://memory', 'w');
    /** loop through array  */
	
	fputcsv($f, $head, $delimiter);
	
    foreach ($input_array as $line) {
        /** default php csv handler **/
        fputcsv($f, $line, $delimiter);
    }
	// for($i=0; $i<count($input_array); $i++){
		
		// fputcsv($f, $input_array[], $delimiter);
	
	// }
	
    /** rewrind the "file" with the csv lines **/
    fseek($f, 0);
    /** modify header to be downloadable csv file **/
    header('Content-Type: application/csv');
    header('Content-Disposition: attachement; filename="' . $output_file_name . '";');
    /** Send file to browser for download */
    fpassthru($f);
}
/** Array to convert to csv */



// if($_REQUSET['query'] == 1) {

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

// echo "<option value='no'>Без выбора поставщика</option>";
// foreach ($arr as $ar) {
	// echo "<option value='".$ar['products_extra_fields_value']."'>".$ar['products_extra_fields_value']."</option>"; 
// }


// }else{
if($_POST['manu'] == "no") {
 $query = tep_db_query ("
SELECT 
p.products_model,
o.products_name,
ord.date_purchased,
sup.supplier_name,
o.orders_id
FROM
products as p
JOIN 
orders_products as o
ON
p.products_id = o.products_id
JOIN 
supplier as sup
ON
p.supplier_id = sup.supplier_id
JOIN
orders as ord
ON
ord.orders_id = o.orders_id 
WHERE 
ord.date_purchased BETWEEN '".$start."' AND '".$end."'
ORDER BY o.orders_id DESC"
);
}
else {
 $query = tep_db_query ( "
SELECT
p.products_model,
o.products_name,
p.products_quantity,
ord.date_purchased,
sup.supplier_name,
o.orders_id
FROM
products as p
JOIN 
orders_products as o
ON
p.products_id = o.products_id
JOIN 
supplier as sup
ON
p.supplier_id = sup.supplier_id
JOIN
orders as ord
ON
ord.orders_id = o.orders_id 
WHERE 
sup.supplier_name =  '".$manu."' 
AND
ord.date_purchased BETWEEN '".$start."' AND '".$end."'
ORDER BY o.orders_id DESC"
);
}

// $result = tep_db_fetch_array ($query);
	while ($new_values = tep_db_fetch_array($query)){
	$arr[] = $new_values;
} 

$heads = array (
"Модель","Название","Количество","Дата заказа","Поставщик","Номер заказа"
);

convert_to_csv($arr, 'report.csv', ';', $heads);
// test($result);
// }




?>