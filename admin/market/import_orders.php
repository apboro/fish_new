<?
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
require_once('PHPExcel.php');
require_once('PHPExcel/Writer/Excel2007.php');
require_once('PHPExcel/Writer/Excel5.php');
require_once('IOFactory.php');
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

global $order;
$host = 'db';  
$user = 'root'; 
$password = 'lHhYoy'; 
$db_name = 'yourfish'; 
//$dsn = "mysql:host=$host;dbname=$db_name";
//$pdo = new PDO($dsn, $user, $password);

$link = mysqli_connect($host, $user, $password, $db_name);
mysqli_set_charset($link, "utf8mb4");
//printf("Initial character set: %s\n", mysqli_character_set_name($link));

function insertCustomer($orderNumber, $customerName, $customerTel, $link){
mysqli_query ($link, "INSERT INTO `customers` (`customers_id`, `customers_gender`, `customers_firstname`, `customers_lastname`, `customers_dob`,
 `customers_email_address`, `customers_default_address_id`, `customers_telephone`, `customers_fax`, `customers_password`,
  `customers_newsletter`, `mmstatus`, `customers_selected_template`, `guest_flag`, `customers_discount`, `customers_groups_id`,
   `customers_status`, `customers_payment_allowed`, `customers_shipment_allowed`, `keep_customers_telephone`, `customers_uuid`)
 VALUES ('".$orderNumber."', '', '".$customerName."', '', '0000-00-00 00:00:00.000000', '', NULL, '".$customerTel."', NULL, '', NULL, '', '', '0', '0.00', '1', '1', '', '', NULL, NULL)");
}

 function insertOrder($orderNumber, $customerName, $customerTel, $paymentMethod, $link){
mysqli_query ($link, "INSERT INTO `orders` (`orders_id`, `customers_id`, `customers_groups_id`, `customers_name`, `customers_company`,
 `customers_street_address`, `customers_suburb`, `customers_city`, `customers_postcode`, `customers_state`, `customers_country`,
  `customers_telephone`, `customers_email_address`, `customers_address_format_id`, `delivery_name`, `delivery_company`,
   `delivery_street_address`, `delivery_suburb`, `delivery_city`, `delivery_postcode`, `delivery_state`, `delivery_country`,
    `delivery_address_format_id`, `billing_name`, `billing_company`, `billing_street_address`, `billing_suburb`, `billing_city`,
     `billing_postcode`, `billing_state`, `billing_country`, `billing_address_format_id`, `payment_method`, `payment_info`, `cc_type`,
      `cc_owner`, `cc_number`, `cc_expires`, `last_modified`, `date_purchased`, `orders_status`, `orders_date_finished`, `currency`, 
      `currency_value`, `customers_referer_url`, `customers_fax`, `shipping_module`, `SSID`, `addon`, `sber_order`, `meta`)
       VALUES ('".$orderNumber."', (200000+ROUND(1 + (RAND() * 9999))), '0', '".$customerName."', NULL, '', NULL, '', '', NULL, '', '+". $customerTel ."', '', '0', '', NULL, '', NULL, '', '', NULL, '', '0', '', NULL,
        '', NULL, '', '', NULL, '', '0', '". $paymentMethod."', NULL, NULL, NULL, NULL, NULL, NULL, now(), '10', NULL, 'RUR', '1.0000000', 'Яндекс.Маркет', '', NULL, '', NULL,
         '', '')");
echo "<br>ADDING... Order number " . $orderNumber ." by customer " . $customerName. " with telephone " . $customerTel;
}

function insertOrderProducts($orderNumber, $productsName, $productsPrice, $productsQuantity, $link){
  $products_query=mysqli_query ($link, "select p.products_id, p.products_model,
   pd.products_name from products_description pd
   join products p
   on p.products_id=pd.products_id
   where products_name='".$productsName."'");
  while ($product= mysqli_fetch_assoc($products_query)){

    mysqli_query($link, "INSERT INTO `orders_products` (`orders_products_id`, `orders_id`, `products_id`, `products_model`,
      `products_name`, `products_price`, `final_price`, `products_tax`, `products_quantity`, `zakaz_price`)
       VALUES (NULL, '" . $orderNumber . "', '" . $product['products_id'] . "', '" . $product['products_model'] . "',
        '" . $product['products_name'] . "',
        '" . $productsPrice . "', '" . $productsPrice . "', '0.0000', '" . $productsQuantity . "','0')");
        echo ' with products ' .$product['products_name'];

}
}
function insertTotal($orderNumber, $productsPrice, $deliveryPrice, $link){
  mysqli_query($link, "INSERT INTO `orders_total` (`orders_total_id`, `orders_id`, `title`, `text`, `value`, `class`, `sort_order`)
   VALUES (NULL, '".$orderNumber."', 'Стоимость товара:', '".$productsPrice."', '".$productsPrice."', 'ot_subtotal', '1')");
   mysqli_query($link, "INSERT INTO `orders_total` (`orders_total_id`, `orders_id`, `title`, `text`, `value`, `class`, `sort_order`)
   VALUES (NULL, '".$orderNumber."', 'Доставка:', '".$deliveryPrice."', '".$deliveryPrice."', 'ot_shipping', '2')");
   $totalsum=$productsPrice+$deliveryPrice;
   mysqli_query($link, "INSERT INTO `orders_total` (`orders_total_id`, `orders_id`, `title`, `text`, `value`, `class`, `sort_order`)
   VALUES (NULL, '".$orderNumber."', 'Всего:', '".$totalsum."', '".$totalsum."', 'ot_total', '800')");
}

function insertComment($orderNumber, $orderKomment, $orderAdres, $link){
  $komment=$orderAdres.'
  '.$orderKomment;
  mysqli_query($link, "INSERT INTO `orders_status_history` (`orders_status_history_id`, `orders_id`, `orders_status_id`, `date_added`, `customer_notified`, `comments`, `customer_visible`)
   VALUES (NULL, '".$orderNumber."', '10', now(), '0', '".$komment."', '1')");
}

$xls = PHPExcel_IOFactory::load(__DIR__ . '/import_order_market.csv'); //import orders file from market
Foreach($xls ->getWorksheetIterator() as $worksheet) {
    $lists[] = $worksheet->toArray();
   }
   foreach($lists as $list){
    // Перебор строк
    $j=0;
    foreach($list as $row){
      $i=0;
      foreach($row as $col){
        $order[$j][$i]=$col;
        $i++;
    }
    $j++;
    }
   }
  for ($j=0; $j<count($order); $j++) {
      insertCustomer($order[$j][0], $order[$j][4], $order[$j][5], $link);
      insertOrder($order[$j][0],$order[$j][4],$order[$j][5],$order[$j][6],$link); // Element select by column in import file
      insertOrderProducts($order[$j][0], $order[$j][1], $order[$j][2],$order[$j][3],$link); 
      insertTotal($order[$j][0], $order[$j][2], $order[$j][7], $link);
      insertComment($order[$j][0], $order[$j][8], $order[$j][9],$link);
  }
