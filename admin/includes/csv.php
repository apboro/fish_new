<?
if($_REQUEST['query'] == 1) {
function convert_to_csv($input_array, $output_file_name, $delimiter)
{
    /** open raw memory as file, no need for temp files, be careful not to run out of memory thought */
    $f = fopen('php://memory', 'w');
    /** loop through array  */
    foreach ($input_array as $line) {
        /** default php csv handler **/
        fputcsv($f, $line, $delimiter);
    }
    /** rewrind the "file" with the csv lines **/
    fseek($f, 0);
    /** modify header to be downloadable csv file **/
    header('Content-Type: application/csv');
    header('Content-Disposition: attachement; filename="' . $output_file_name . '";');
    /** Send file to browser for download */
    fpassthru($f);
}
/** Array to convert to csv */
$array_to_csv = Array(
    Array(12566,
        'Enmanuel',
        'Corvo'
    ),
    Array(56544,
        'John',
        'Doe'
    ),
    Array(78550,
        'Mark',
        'Smith'
    )
);



 $query = tep_db_query ( "SELECT 
p.products_model,
p.products_name,
o.date_purchased,
ptp.products_extra_fields_value,
o.orders_id
FROM
orders_products as p
JOIN 
orders as o
ON
p.orders_id = o.orders_id
JOIN 
products_to_products_extra_fields as ptp
ON
p.products_id = ptp.products_id
WHERE 
o.date_purchased BETWEEN '2015-08-01' AND '2015-08-15'
ORDER BY o.orders_id DESC"
);

$result = tep_db_fetch_array ($query);
	

convert_to_csv($result, 'report.csv', ',');
// test($result);
	
function test ($a) {
echo "<pre>";
print_r($a);
echo "</pre>";
}



}

?>