<?php
/**
 * Created by PhpStorm.
 * User: powernic
 * Date: 21.06.2018
 * Time: 17:04
 */
 
 ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
 echo 'ghbdtn1';

if (isset($_GET['oID']) && !empty($_GET['oID'])) {
	echo 'ghbdtn2';
    require(__DIR__ . '/includes/application_top.php');
	echo 'ghbdtn3';
    $orderId = (int)$_GET['oID']
    $order = new order($orderId);;
	echo 'ghbdtn4';
    require(DIR_WS_CLASSES . 'order.php');
	echo 'ghbdtn5';
    require (DIR_WS_LANGUAGES . 'russian/modules/payment/nal.php');
    $cost = ceil($order->info['value']);
    if($order->info['payment_method'] == MODULE_PAYMENT_NAL_TEXT_TITLE){
        require (DIR_WS_LANGUAGES . 'russian/modules/order_total/ot_surcharge.php');
        $count = count($order->totals);
        if($order->totals[$count-2]['title'] == MODULE_PAYMENT_TITLE.':') {
            $add_cost = (int)str_replace(',','',$order->totals[$count-2]['text']);
            $main_cost = (int)str_replace(',','',$order->totals[$count-3]['text']);
            $cost = $add_cost + $main_cost;
        }else{
            $cost = (int)str_replace(',','',$order->totals[$count-2]['text']);
        }
    }
	echo 'ghbdtn8';
    require_once __DIR__ . '/sber/register.php';
    $result = SberRegister::makeOrder($cost, $orderId);
    if (!empty($result['orderId'])) {
        tep_db_query("UPDATE " . TABLE_ORDERS . " SET `sber_order`='" . $result['orderId'] . "' WHERE `orders_id`=" . $orderId);

        include(DIR_WS_LANGUAGES . $language . '/' . FILENAME_CHECKOUT_PROCESS);
        $email_order = STORE_NAME . "\n" .
            EMAIL_SEPARATOR . "\n" .
            EMAIL_TEXT_PODTV . "\n" .
            EMAIL_SEPARATOR . "\n" .
            EMAIL_TEXT_ORDER_NUMBER . ' ' . $orderId . "\n" .
            ((tep_session_is_registered('customer_id') && $guest_account == false) ? EMAIL_TEXT_INVOICE_URL . ' ' . tep_href_link(FILENAME_ACCOUNT_HISTORY_INFO, 'order_id=' . $orderId, 'SSL', false) . "\n" : '') .
            EMAIL_TEXT_DATE_ORDERED . ' ' . strftime(DATE_FORMAT_LONG) . "\n" .
            EMAIL_TEXT_CUSTOMER_NAME . ' ' . $order->customer['name'] . "\n" .
            EMAIL_TEXT_CUSTOMER_EMAIL_ADDRESS . ' ' . $order->customer['email_address'] . "\n" .
            EMAIL_TEXT_CUSTOMER_TELEPHONE . ' ' . $order->customer['telephone'] . "\n\n";
        if ($order->info['comments']) {
            $email_order .= tep_db_output($order->info['comments']) . "\n\n";
        }

        for ($i = 0, $n = sizeof($order->products); $i < $n; $i++) {
            $total_weight += ($order->products[$i]['qty'] * $order->products[$i]['weight']);
            $total_tax += tep_calculate_tax($total_products_price, $products_tax) * $order->products[$i]['qty'];
            $total_cost += $total_products_price;
            $products_ordered .= $order->products[$i]['qty'] . ' x ' . $order->products[$i]['name'] . ' (' . $order->products[$i]['model'] . ') = ' . $currencies->display_price_nodiscount($order->products[$i]['final_price'], $order->products[$i]['tax'], $order->products[$i]['qty']) . $products_ordered_attributes . "\n";
        }
        $email_order .= EMAIL_TEXT_PRODUCTS . "\n" .
            EMAIL_SEPARATOR . "\n" .
            $products_ordered .
            EMAIL_SEPARATOR . "\n";

        for ($i = 0, $n = sizeof($order->totals); $i < $n; $i++) {
            $email_order .= strip_tags($order->totals[$i]['title']) . ' ' . strip_tags($order->totals[$i]['text']) . "\n";
        }
        $email_order .= EMAIL_SEPARATOR . "\n";

        $email_order .= "Способ оплаты" . "\n";
        $email_order .= EMAIL_SEPARATOR . "\n";
        $email_order .= $order->info['payment_method']."\n";
        $email_order .= EMAIL_SEPARATOR . "\n";
        if ($order->info['payment_method'] == MODULE_PAYMENT_NAL_TEXT_TITLE) {
            $email_order .= 'Для отправки заказа необходимо оплатить стоимость транспортных услуг. Оплатить транспортные услуги банковской картой - '. $result['url'] . "\n";
        } else {
            $email_order .= "Оплатить - " . $result['url'] . "\n";
        }
       // tep_mail($order->customer['name'], $order->customer['email_address'], 'Оплата заказа', $email_order, STORE_OWNER, STORE_OWNER_EMAIL_ADDRESS);
    }
	
	
    tep_redirect('/admin/orders.php?action=edit&oID=' . $orderId);
}
echo 'ghbdtn9';