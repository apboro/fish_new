<?php
/*
  $Id: orders.php,v 1.2 2003/09/24 15:18:15 wilt Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/

require('includes/application_top.php');
include(DIR_WS_LANGUAGES . $language . '/' . FILENAME_CHECKOUT_PROCESS);
require(DIR_WS_CLASSES . 'currencies.php');
$currencies = new currencies();

//----byIHolder-----
function GetOrderShippingInfo($oID)
{
    $query = tep_db_query("select shipping_module,addon from orders where orders_id=" . (int)$oID);
    $ret['cdek'] = false;
    $ret['addon'] = '';
    if ($query !== false) {
        $data = tep_db_fetch_array($query);
        //    var_dump($data);
        if (preg_match('|cdek|', $data['shipping_module'])) {
            $ret['cdek'] = true;
            $ret['addon'] = unserialize($data['addon']);
        }
    }
    return $ret;
}



function BuildCDEKInvoice()
{
    global $_REQUEST, $CDEK_INFO, $messageStack;
    if ($CDEK_INFO['cdek'] == false) {
        return;
    }
    $postpay = array('nal');
    //$packageaddon=30;
    /*$packageaddon=0;
    $deliveryaddon=0+$packageaddon;//----for package*/
    $dopostpay = true;
    //echo 'POST:'.$CDEK_INFO['addon']['payment'];
    if (strlen($CDEK_INFO['addon']['payment']) > 0) {
        $dopostpay = in_array($CDEK_INFO['addon']['payment'], $postpay);
    }
    //require_once(DIR_FS_DOCUMENT_ROOT.'includes/classes/order.php');
    if (!class_exists('order')) {
        include(DIR_WS_CLASSES . 'order.php');
    }
    $order_id = (int)$_REQUEST['oID'];
    $corder = new order($order_id);
    $orders_status = $corder->info['orders_status'];
    $total_pay = 0;

    foreach ($corder->products as $pkey => $pvalue) {
        $total_pay += $pvalue['qty'] * $pvalue['final_price'];
    }
    /*foreach($corder->totals as $pkey=>$pvalue){
        if (preg_match('|^Всего:|',$pvalue['title'])){
        $deliveryaddon+=$pvalue['value'];
        }
        }

    if ($deliveryaddon>$total_pay){$deliveryaddon-=$total_pay;}
    $deliveryaddon=round($deliveryaddon,0);*/
    $delivery_price = $CDEK_INFO['addon']['cdek_price'];
    //echo $delivery_price;exit;
    if ($total_pay > 10000) {
        $delivery_price = 0;
    }

    if (isset($corder->totals[1]['value'])) {
        $delivery_price = $corder->totals[1]['value'];
    }
    /*echo '<pre>';
    echo $orders_status;
    var_dump($CDEK_INFO);
    var_dump($corder);
    echo '</pre>';exit;*/
    $Edate = date('Y-m-d');
    $auth_block = md5($Edate . '&' . CDEK_UserPassword);

    $request = '<?xml version="1.0" encoding="UTF-8" ?><DeliveryRequest Number="' . $order_id . '" Date="' . date('Y-m-d') . '" Account="' .
        CDEK_UserKey . '" Secure="' . $auth_block . '" OrderCount="1">' .
        '<Order Number="' . $order_id . '"
SendCityCode="' . CDEK_SenderCity . '"
RecCityCode="' . $CDEK_INFO['addon']['cityID'] . '"
RecipientName="' . $corder->customer['name'] . '"
Phone="' . $corder->customer['telephone'] . '"
Comment=""
TariffTypeCode="' . $CDEK_INFO['addon']['cdek_tarif'] . '" 
DeliveryRecipientCost="';
    $request .= '0';
    $add_price = $delivery_price;
    foreach ($corder->totals as $total) {
        if (stripos($total['title'], "Наценка") !== false) {
            $add_price += $total['value'];
            break;
        }
    }

    $summary = 0;

    require('../' . DIR_WS_LANGUAGES . 'russian/modules/payment/nal.php');
    require('../' . DIR_WS_LANGUAGES . 'russian/modules/payment/paypal.php');
    if (($corder->info['payment_method'] == MODULE_PAYMENT_NAL_TEXT_TITLE)
        or ($corder->info['payment_method'] == MODULE_PAYMENT_PAYPAL_TEXT_TITLE)
        or ($corder->info['payment_method'] == 'POSTPAID')
    ) {
        $summary = ceil($corder->totals[count($corder->totals) - 1]['value']);
    }
    $request .= '"  RecepientCurrency="RUB"
ItemsCurrency="RUB">' .
        '<Address PvzCode="' . $CDEK_INFO['addon']['cdek_postbox'] . '" />
<Package Number="1" BarCode="1" Weight="1000">' . "\n";
    $request .= '<Item WareKey="order" Cost="' . $summary . '" 
    Payment="' . $summary . '" Weight="0" Amount="1" Comment="Заказ №' .
        $order_id . '"/>' . "\n";
    /*foreach ($corder->products as $pkey => $pvalue) {

        $request .= '<Item WareKey="' . $pvalue['model'] . '" Cost="' . $pvalue['final_price'] . '"
    Payment="';
        if ($dopostpay) {
            $request .= $pvalue['final_price'];
        } else {
            $request .= 0;
        }
        $request .= '" Weight="0" Amount="' . $pvalue['qty'] . '" Comment="' .
            $pvalue['name'] . '"/>' . "\n";
    }*/
    //Добавим доставку к стоимости
    $request .= '</Package>';
    if ($CDEK_INFO['addon']['cdek_mode'] == 1) {
        $request .= '<AddService ServiceCode="17"></AddService>';
    }
    $request .= '</Order></DeliveryRequest>';
    /*echo '<pre>';
    var_dump($CDEK_INFO);var_dump($corder);
    echo 'Request'.$request."\n\n\n";
    echo '</pre>';
    exit;*/
    unset($corder);
    //exit;
    $request_data = array('xml_request' => $request);

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, "http://int.cdek.ru/new_orders.php");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_BINARYTRANSFER, true);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $request_data);

    $response = curl_exec($curl);
    try {
        $xml = simplexml_load_string($response);
        if (is_object($xml)) {
            $ret['error'] = false;
            $ret['message'] = '';
            $ret['dispatch'] = '';
            if (isset($xml->Order)) {
                foreach ($xml->Order->attributes() as $key => $value) {
                    switch ($key) {
                        case 'ErrorCode': {
                                $ret['error'] = true;
                                $ret['ErrorCode'] = (string)$value;
                                break;
                            }
                        case 'Msg': {
                                $ret['message'] = (string)$value;
                                break;
                            }
                        case 'DispatchNumber': {
                                $ret['dispatch'] = (string)$value;
                                break;
                            }
                    }
                }
            }
            unset($xml);
        }
        if ($ret['ErrorCode'] == 'ERR_ORDER_DUBL_EXISTS') {
            $request = '<?xml version="1.0" encoding="UTF-8" ?>
<DeleteRequest Number="' . $order_id . '" Date="' . date('Y-m-d') . '" Account="' . CDEK_UserKey . '" Secure="' . $auth_block . '" OrderCount="1">
    <Order Number="' . $order_id . '" />  
</DeleteRequest>';
            $request_data = array('xml_request' => $request);
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, "http://int.cdek.ru/delete_orders.php");
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_BINARYTRANSFER, true);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $request_data);
            $response = curl_exec($curl);
            $ret['ErrorCode'] = '';
            BuildCDEKInvoice();
        } else {
            if ($ret['error'] == true) {
                $messageStack->add('CDEK:' . $ret['message'], 'error');
            } else {
                $messageStack->add('Отслеживание посылки - https://www.cdek.ru/ru/tracking?order_id=' . $ret['dispatch'], 'success');
                $messageStack->add('https://lk.cdek.ru/print/print-barcodes?orderId='. $ret['dispatch'].'&format=A4' , 'success');
                tep_db_query("insert into " . TABLE_ORDERS_STATUS_HISTORY . " 
    (orders_id, orders_status_id, date_added, customer_notified, comments, customer_visible) values 
    ('" . (int)$order_id . "', '" . tep_db_input($orders_status) . "', now(), '0', 
    '" . tep_db_input('https://lk.cdek.ru/print/print-barcodes?orderId='.$ret['dispatch'].'&format=A4
     Отслеживание посылки - https://www.cdek.ru/ru/tracking?order_id=' . $ret['dispatch']) . "',0)");
            }
        }
    } catch (Exception $e) {
        $messageStack->add('CDEK:' . $e->getMessage(), 'error');
    }

    /* var_dump($messageStack);
    var_dump($response);
    echo 'Complete';
    //require('includes/application_bottom.php');
    exit;*/
}

$CDEK_INFO = GetOrderShippingInfo($_REQUEST['oID']);
if ($_REQUEST['action'] == 'cdek') {
    BuildCDEKInvoice();
    unset($_GET['action'], $_REQUEST['action']);
}

function UpdateOrder($oID, $status, $comments, $notify, $notifyComments)
{
    global $_POST, $_GET, $orders_status_array, $messageStack, $currencies;
    include(DIR_WS_CLASSES . 'order.php');
    $order = new order($oID);
    if ($notify == 1) {
        $notify = 'on';
    }
    $status_changed = false;
    $customer_visible = 1;
    //	if (!isset($_POST['customer_visible'])){$customer_visible=0;}
    if (!isset($notifyComments)) {
        $customer_visible = 0;
    }

    $order_updated = false;
    $check_status_query = tep_db_query("select customers_name, customers_email_address, orders_status, date_purchased, customers_id from " . TABLE_ORDERS . " where orders_id = '" . (int)$oID . "'");
    $check_status = tep_db_fetch_array($check_status_query);
    // BOF: WebMakers.com Added: Downloads Controller
    // always update date and time on order_status
    // original        if ( ($check_status['orders_status'] != $status) || tep_not_null($comments)) {
    //  $status_changed=$check_status['orders_status'] != $status;

    if (($check_status['orders_status'] != $status) || $comments != '' || ($status == DOWNLOADS_ORDERS_STATUS_UPDATED_VALUE)) {
        tep_db_query("update " . TABLE_ORDERS . " set orders_status = '" . tep_db_input($status) . "', last_modified = now() where orders_id = '" . (int)$oID . "'");
        $check_status_query2 = tep_db_query("select customers_name, customers_id, customers_email_address, orders_status, date_purchased from " . TABLE_ORDERS . " where orders_id = '" . (int)$oID . "'");
        $check_status2 = tep_db_fetch_array($check_status_query2);
        if ($check_status2['orders_status'] == DOWNLOADS_ORDERS_STATUS_UPDATED_VALUE) {
            tep_db_query("update " . TABLE_ORDERS_PRODUCTS_DOWNLOAD . " set download_maxdays = '" . tep_get_configuration_key_value('DOWNLOAD_MAX_DAYS') . "', download_count = '" . tep_get_configuration_key_value('DOWNLOAD_MAX_COUNT') . "' where orders_id = '" . (int)$oID . "'");
        }
        // EOF: WebMakers.com Added: Downloads Controller

        $customer_notified = '0';
        if (isset($notify) && ($notify == 'on')) {
            $notify_comments = '';
            // BOF: WebMakers.com Added: Downloads Controller - Only tell of comments if there are comments
            if (isset($notifyComments) && ($notifyComments == 'on') && !empty($comments)) {
                $notify_comments = sprintf(EMAIL_TEXT_COMMENTS_UPDATE, $comments) . "\n";
            }
            // EOF: WebMakers.com Added: Downloads Controller
            $changed_status = sprintf(EMAIL_TEXT_STATUS_UPDATE, $orders_status_array[$status]);
            if ($status == 5) {
                $changed_status .= OTZIV_MARKET;
            }

            // eto dlya ждём оплаты список товаров
            $statusi = array(2, 14, 17, 18, 20, 11, 10, 3, 4);
            if (in_array($status, $statusi)) {

                for ($i = 0, $n = sizeof($order->products); $i < $n; $i++) {
                    //$total_weight += ($order->products[$i]['qty'] * $order->products[$i]['weight']);
                    //$total_tax += tep_calculate_tax($total_products_price, $products_tax) * $order->products[$i]['qty'];
                    //$total_cost += $total_products_price;
                    $products_ordered .= $order->products[$i]['qty'] . ' x ' . $order->products[$i]['name'] . ' (' . $order->products[$i]['model'] . ') = ' . round($order->products[$i]['final_price'] * $order->products[$i]['qty']) . ' руб.' . $products_ordered_attributes . "\n";
                }
                $changed_status .= 'Заказанные снасти' . "\n" .
                    EMAIL_SEPARATOR . "\n" .
                    $products_ordered .
                    EMAIL_SEPARATOR . "\n";

                for ($i = 0, $n = sizeof($order->totals); $i < $n; $i++) {
                    $changed_status .= strip_tags($order->totals[$i]['title']) . ' ' . strip_tags($order->totals[$i]['text']) . "\n";
                }
                // $changed_status .= EMAIL_SEPARATOR . "\n";

            }

            if ($status == EMAIL_ST_ID) {
                $changed_status = EMAIL_ST_CH . "\n\n" . EMAIL_ST_CH_FOOTER;
            }
            $email = STORE_NAME . "\n" . EMAIL_SEPARATOR . "\n" .
                EMAIL_TEXT_ORDER_NUMBER . ' ' . $oID . "\n" .
                EMAIL_TEXT_INVOICE_URL . ' ' .
                tep_catalog_href_link(FILENAME_CATALOG_ACCOUNT_HISTORY_INFO, 'order_id=' . $oID, 'SSL') . "\n" .
                EMAIL_TEXT_DATE_ORDERED . ' ' . tep_date_long($check_status['date_purchased']) .
                "\n\n" . $notify_comments . $changed_status;
            tep_mail($check_status['customers_name'], $check_status['customers_email_address'], EMAIL_TEXT_SUBJECT . ' №' . tep_db_input($oID), nl2br($email), STORE_OWNER, STORE_OWNER_EMAIL_ADDRESS);
            $customer_notified = '1';
        }
        tep_db_query("insert into " . TABLE_ORDERS_STATUS_HISTORY . " (orders_id, orders_status_id, date_added, customer_notified, comments,customer_visible) values ('" . (int)$oID . "', '" . tep_db_input($status) . "', now(), '" . tep_db_input($customer_notified) . "', '" . tep_db_input($comments) . "'," . $customer_visible . ")");
        $order_updated = true;
    }

    if ($order_updated == true) {
        $messageStack->add(SUCCESS_ORDER_UPDATED, 'success');
    } else {
        $messageStack->add(WARNING_ORDER_NOT_UPDATED, 'warning');
    }

    // denuz added accumulated discount

    $customer_query = tep_db_query("select c.* from customers as c, orders as o where o.customers_id = c.customers_id and o.orders_id = " . (int)$oID);
    $customer = tep_db_fetch_array($customer_query);
    if (strlen(trim($customer['customers_id'])) == 0) {
        $messageStack->add('Несуществующий клиент заказ №' . (int)$oID, 'warning');
        return;
    }


    $changed = false;

    $check_group_query = tep_db_query("select 
        customers_groups_id from customers_groups_orders_status where orders_status_id = " . $status);
    if (tep_db_num_rows($check_group_query)) {
        while ($groups = tep_db_fetch_array($check_group_query)) {
            // calculating total customers purchase
            // building query
            $customer_query = tep_db_query("select c.* from customers as c, orders as o where o.customers_id = c.customers_id and o.orders_id = " . (int)$oID);
            $customer = tep_db_fetch_array($customer_query);
            $customer_id = $customer['customers_id'];
            $statuses_groups_query = tep_db_query("select orders_status_id from customers_groups_orders_status where customers_groups_id = " . $groups['customers_groups_id']);
            $purchase_query = "select sum(ot.value) as total from orders_total as ot, orders as o where ot.orders_id = o.orders_id and o.customers_id = " . $customer_id . " and ot.class = 'ot_total' and (";
            $statuses = tep_db_fetch_array($statuses_groups_query);
            $purchase_query .= " o.orders_status = " . $statuses['orders_status_id'];
            while ($statuses = tep_db_fetch_array($statuses_groups_query)) {
                $purchase_query .= " or o.orders_status = " . $statuses['orders_status_id'];
            }
            $purchase_query .= ");";

            $total_purchase_query = tep_db_query($purchase_query);
            $total_purchase = tep_db_fetch_array($total_purchase_query);
            $customers_total = $total_purchase['total'];

            // looking for current accumulated limit & discount
            $acc_query = tep_db_query("select cg.customers_groups_accumulated_limit, cg.customers_groups_name, cg.customers_groups_discount from customers_groups as cg, customers as c where cg.customers_groups_id = c.customers_groups_id and c.customers_id = " . $customer_id);
            $current_limit = @mysqli_result($acc_query, 0, "customers_groups_accumulated_limit");
            $current_discount = @mysqli_result($acc_query, 0, "customers_groups_discount");
            $current_group = @mysqli_result($acc_query, "customers_groups_name");

            // ok, looking for available group
            $groups_query = tep_db_query("select customers_groups_discount, customers_groups_id, customers_groups_name, customers_groups_accumulated_limit from customers_groups where customers_groups_accumulated_limit < " . $customers_total . " and customers_groups_accumulated_limit > " . $current_limit . " and customers_groups_id = " . $groups['customers_groups_id'] . " order by customers_groups_accumulated_limit DESC");
            if (tep_db_num_rows($groups_query)) {
                // new group found
                $customers_groups_id = @mysqli_result($groups_query, 0, "customers_groups_id");
                $customers_groups_name = @mysqli_result($groups_query, 0, "customers_groups_name");
                $limit = @mysqli_result($groups_query, 0, "customers_groups_accumulated_limit");
                $current_discount = @mysqli_result($groups_query, 0, "customers_groups_discount");

                // updating customers group
                tep_db_query("update customers set customers_groups_id = " . $customers_groups_id . " where customers_id = " . $customer_id);
                $changed = true;
            }
        }
        $groups_query = tep_db_query("select cg.* from customers_groups as cg, customers as c where c.customers_groups_id = cg.customers_groups_id and c.customers_id = " . $customer_id);
        $customers_groups_id = @mysqli_result($groups_query, 0, "customers_groups_id");
        $customers_groups_name = @mysqli_result($groups_query, 0, "customers_groups_name");
        $limit = @mysqli_result($groups_query, 0, "customers_groups_accumulated_limit");
        $current_discount = @mysqli_result($groups_query, 0, "customers_groups_discount");


        if ($changed) {
            // send emails
            $text = EMAIL_TEXT_LIMIT . $currencies->display_price($limit, 0) . "\n" .
                EMAIL_TEXT_CURRENT_GROUP . $customers_groups_name . "\n" .
                EMAIL_TEXT_DISCOUNT . $current_discount . "%" . "\n";
            if ($_REQUEST['status'] == 5) {
                $text .= OTZIV_MARKET;
            }
            // to store owner
            $email_text = EMAIL_ACC_DISCOUNT_INTRO_OWNER . "\n\n" .
                EMAIL_TEXT_CUSTOMER_NAME . ' ' . $customer['customers_firstname'] . ' ' . $customer['customers_lastname'] . "\n" .
                EMAIL_TEXT_CUSTOMER_EMAIL_ADDRESS . ' ' . $customer['customers_email_address'] . "\n" .
                EMAIL_TEXT_CUSTOMER_TELEPHONE . ' ' . $customer['customers_telephone'] . "\n\n" . $text;


            tep_mail(STORE_OWNER, STORE_OWNER_EMAIL_ADDRESS, EMAIL_ACC_SUBJECT, $email_text, STORE_OWNER, STORE_OWNER_EMAIL_ADDRESS);

            // to customer
            $email_text = EMAIL_ACC_INTRO_CUSTOMER . "\n\n" .
                $text . "\n\n" .
                EMAIL_ACC_FOOTER;
            tep_mail($customer['customers_firstname'] . ' ' . $customer['customers_lastname'], $customer['customers_email_address'], EMAIL_ACC_SUBJECT, nl2br($email_text), STORE_OWNER, STORE_OWNER_EMAIL_ADDRESS);
        }
    }
    // eof denuz added accumulated discount


}

function inverseHex($color)
{
    $color = TRIM($color);
    $prependHash = FALSE;
    $r = DECHEX(255 - HEXDEC(mb_SUBSTR($color, 0, 2, 'utf-8')));
    $r = (STRLEN($r) > 1) ? $r : '0' . $r;
    $g = DECHEX(255 - HEXDEC(mb_SUBSTR($color, 2, 2, 'utf-8')));
    $g = (STRLEN($g) > 1) ? $g : '0' . $g;
    $b = DECHEX(255 - HEXDEC(mb_SUBSTR($color, 4, 2, 'utf-8')));
    $b = (STRLEN($b) > 1) ? $b : '0' . $b;
    return $r . $g . $b;
}

$cos_array = array();
$cos_query = 'select * from customers_groups';
$cos_qry = tep_db_query($cos_query);
if (is_object($cos_qry)) {
    while ($cos_res = tep_db_fetch_array($cos_qry)) {
        $cos_array[$cos_res['customers_groups_id']] = array(
            'title' => $cos_res['customers_groups_name'],
            'discount' => $cos_res['customers_groups_discount'],
            'color' => preg_replace('|#|', '', $cos_res['color_bar'])
        );
    }
}
//echo '<pre>';var_dump($cos_array);echo '</pre>';
//----byIHolder-----

$orders_statuses = array();
$orders_status_array = array();
$orders_status_query = tep_db_query("select orders_status_id, orders_status_name from " . TABLE_ORDERS_STATUS . " where language_id = '" . (int)$languages_id . "'");
while ($orders_status = tep_db_fetch_array($orders_status_query)) {
    $orders_statuses[] = array(
        'id' => $orders_status['orders_status_id'],
        'text' => $orders_status['orders_status_name']
    );
    $orders_status_array[$orders_status['orders_status_id']] = $orders_status['orders_status_name'];
}

$action = (isset($_GET['action']) ? $_GET['action'] : '');

// Start Batch Update Status v0.4
if (isset($_POST['submit'])) {
    if (($_POST['submit'] == BUS_SUBMIT) && (isset($_POST['new_status'])) && (!isset($_POST['delete_orders']))) { // Fair enough, let's update ;)
        $status = tep_db_prepare_input($_POST['new_status']);
        if ($status == '') { // New status not selected
            tep_redirect(tep_href_link(FILENAME_ORDERS), tep_get_all_get_params());
        }
        foreach ($_POST['update_oID'] as $this_orderID) {
            $order_updated = false;
            $check_status_query = tep_db_query("select customers_name, customers_email_address, orders_status, date_purchased from " . TABLE_ORDERS . " where orders_id = '" . (int)$this_orderID . "'");
            $check_status = tep_db_fetch_array($check_status_query);
            UpdateOrder($this_orderID, $status, '', $_POST['notify'], 'off');
            /*    if ($check_status['orders_status'] != $status) {
                   tep_db_query("update " . TABLE_ORDERS . " set orders_status = '" . tep_db_input($status) . "', last_modified = now() where orders_id = '" . (int)$this_orderID . "'");
                   $customer_notified ='0';
                      if (isset($_POST['notify'])) {
                        $notify_comments = '';
                        $email = STORE_NAME . "\n" . EMAIL_SEPARATOR . "\n" . EMAIL_TEXT_ORDER_NUMBER . ' ' . $this_orderID . "\n" . EMAIL_TEXT_INVOICE_URL . ' ' . tep_catalog_href_link(FILENAME_CATALOG_ACCOUNT_HISTORY_INFO, 'order_id=' . $this_orderID, 'SSL') . "\n" . EMAIL_TEXT_DATE_ORDERED . ' ' . tep_date_long($check_status['date_purchased']) . "\n\n" . $notify_comments . sprintf(EMAIL_TEXT_STATUS_UPDATE, $orders_status_array[$status]);
                        tep_mail($check_status['customers_name'], $check_status['customers_email_address'], EMAIL_TEXT_SUBJECT, $email, STORE_OWNER, STORE_OWNER_EMAIL_ADDRESS);
                        $customer_notified = '1';
                      }
                      tep_db_query("insert into " . TABLE_ORDERS_STATUS_HISTORY . " (orders_id, orders_status_id, date_added, customer_notified, comments) values ('" . (int)$this_orderID . "', '" . tep_db_input($status) . "', now(), '" . tep_db_input($customer_notified) . "', '" . tep_db_input($comments)  . "')");
                      $order_updated = true;
                }*/
            /*        if ($order_updated == true) {
                     $messageStack->add_session(BUS_SUCCESS, 'success');
                    } else {
                      $messageStack->add_session(BUS_WARNING, 'warning');
                    }*/
        } // End foreach ID loop
    }

    // /delete orders

    if (($_POST['submit'] == BUS_SUBMIT) && (isset($_POST['delete_orders']))) {

        foreach ($_POST['update_oID'] as $this_orderID) {

            $orders_deleted = false;

            tep_db_query("delete from " . TABLE_ORDERS . " where orders_id = '" . (int)$this_orderID . "'");
            tep_db_query("delete from " . TABLE_ORDERS_PRODUCTS . " where orders_id = '" . (int)$this_orderID . "'");
            tep_db_query("delete from " . TABLE_ORDERS_PRODUCTS_ATTRIBUTES . " where orders_id = '" . (int)$this_orderID . "'");
            tep_db_query("delete from " . TABLE_ORDERS_PRODUCTS_DOWNLOAD . " where orders_id = '" . (int)$this_orderID . "'");
            tep_db_query("delete from " . TABLE_ORDERS_STATUS_HISTORY . " where orders_id = '" . (int)$this_orderID . "'");
            tep_db_query("delete from " . TABLE_ORDERS_TOTAL . " where orders_id = '" . (int)$this_orderID . "'");
            tep_db_query("delete from " . TABLE_PERSONS . " where orders_id = '" . (int)$this_orderID . "'");
            tep_db_query("delete from " . TABLE_COMPANIES . " where orders_id = '" . (int)$this_orderID . "'");

            $orders_deleted = true;

            if ($orders_deleted == true) {
                $messageStack->add(BUS_DELETE_SUCCESS, 'success');
            } else {
                $messageStack->add(BUS_DELETE_WARNING, 'warning');
            }
        } // End foreach ID loop
    }

    // /delete orders

    tep_redirect(tep_href_link(FILENAME_ORDERS), tep_get_all_get_params());
}

// End Batch Update Status v0.4

if (tep_not_null($action)) {
    switch ($action) {

        case 'update_order':
            $oID = tep_db_prepare_input((int)$_GET['oID']);
            $status = tep_db_prepare_input($_POST['status']);
            $comments = tep_db_prepare_input($_POST['comments']);
            $orders_date_finished = tep_db_prepare_input($_POST['orders_date_finished']);
            if (empty($orders_date_finished)) {
                tep_db_query("UPDATE `" . TABLE_ORDERS . "` SET orders_date_finished=NULL WHERE `orders_id`=" . $oID);
            } else {
                tep_db_query("UPDATE `" . TABLE_ORDERS . "` SET orders_date_finished='" . tep_db_input($orders_date_finished) . "' WHERE `orders_id`=" . $oID);
            }

            UpdateOrder($oID, $status, $comments, $_POST['notify'], $_POST['notify_comments']);

            tep_redirect(tep_href_link(FILENAME_ORDERS, tep_get_all_get_params(array('action')) . 'action=edit'));
            break;
        case 'deleteconfirm':
            $oID = tep_db_prepare_input($_GET['oID']);

            tep_remove_order($oID, $_POST['restock']);

            tep_redirect(tep_href_link(FILENAME_ORDERS, tep_get_all_get_params(array('oID', 'action'))));
            break;
    }
}

if (($action == 'edit') && isset($_GET['oID'])) {
    $oID = tep_db_prepare_input($_GET['oID']);

    $orders_query = tep_db_query("select orders_id from " . TABLE_ORDERS . " where orders_id = '" . (int)$oID . "'");
    $order_exists = true;
    if (!tep_db_num_rows($orders_query)) {
        $order_exists = false;
        $messageStack->add(sprintf(ERROR_ORDER_DOES_NOT_EXIST, $oID), 'error');
    }
}
// BOF: WebMakers.com Added: Additional info for Orders
// Look up things in orders
$the_extra_query = tep_db_query("select * from " . TABLE_ORDERS . " where orders_id = '" . (int)$oID . "'");
$the_extra = tep_db_fetch_array($the_extra_query);
$the_customers_id = $the_extra['customers_id'];
// Look up things in customers
$the_extra_query = tep_db_query("select * from " . TABLE_CUSTOMERS . " where customers_id = '" . $the_customers_id . "'");
$the_extra = tep_db_fetch_array($the_extra_query);
$the_customers_fax = $the_extra['customers_fax'];
// EOF: WebMakers.com Added: Additional info for Orders
if (!class_exists('order')) {
    include(DIR_WS_CLASSES . 'order.php');
}

?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
    <title><?php echo TITLE; ?></title>
    <link rel="stylesheet" type="text/css" href="includes/stylesheet.css">

    <script language="javascript" src="includes/menu.js"></script>
    <script language="javascript" src="includes/general.js"></script>
    <script>
        console.log('0');
    </script>

</head>

<body marginwidth="0" marginheight="0" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0" bgcolor="#FFFFFF">
    <!-- header //-->
    <?php
    require(DIR_WS_INCLUDES . 'header.php');
    ?>
    <!-- header_eof //-->

    <!-- body //-->
    <table border="0" width="100%" cellspacing="2" cellpadding="2">
        <tr>
            <td width="<?php echo BOX_WIDTH; ?>" valign="top">
                <table border="0" width="<?php echo BOX_WIDTH; ?>" cellspacing="1" cellpadding="1" class="columnLeft">
                    <!-- left_navigation //-->
                    <?php require(DIR_WS_INCLUDES . 'column_left.php'); ?>
                    <!-- left_navigation_eof //-->
                </table>
            </td>
            <!-- body_text //-->
            <td width="100%" valign="top">
                <table class="table-padding-2">
                    <?php
                    if (($action == 'edit') && ($order_exists == true)) {
                        $order = new order($oID);
                    ?>
                        <tr>
                            <td width="100%">
                                <table class="table-padding-0">
                                    <tr>
                                        <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
                                        <td class="pageHeading" align="right"><?php echo tep_draw_separator('pixel_trans.gif', 1, HEADING_IMAGE_HEIGHT); ?></td>
                                        <td class="pageHeading" align="right"><?php echo '<a href="' . tep_href_link(FILENAME_ORDERS, tep_get_all_get_params(array('action'))) . '">' . tep_image_button('button_back.gif', IMAGE_BACK) . '</a>'; ?></td>
                                        <td class="pageHeading" align="right">

                                            <?php echo '<a href="' . tep_href_link(FILENAME_ORDERS, tep_get_all_get_params(array('oID', 'action')) . 'oID=' . $_GET['oID'] . '&action=delete') . '" >' . tep_image_button('button_delete.gif', IMAGE_DELETE) . '</a>'; ?>
                                            &nbsp;
                                            <?php
                                            // Modifyed 4 VaM
                                            echo '<a href="' . tep_href_link(
                                                "edit_orders.php",
                                                tep_get_all_get_params(array('action'))
                                            ) .
                                                '&customer_id=' . $the_customers_id . '">' .
                                                tep_image_button('button_edit.gif', IMAGE_EDIT) . '</a> &nbsp; ';
                                            //end mod for VaM
                                            ?>
                                            <?php echo '<a href="' . tep_href_link(FILENAME_ORDERS, tep_get_all_get_params(array('action'))) . '">' . tep_image_button('button_back.gif', IMAGE_BACK) . '</a>'; ?>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <?php
                                if (ENABLE_TABS == 'true') {
                                ?>
                                    <script type="text/javascript">
                                        $(function() {
                                            $('#tabs').tabs({
                                                fx: {
                                                    opacity: 'toggle',
                                                    duration: 'fast'
                                                }
                                            });
                                        });
                                    </script>
                                <?php } ?>

                                <div id="tabs">

                                    <ul>
                                        <li><a href="#orders"><?php echo TEXT_ORDER_SUMMARY; ?></a></li>
                                        <li><a href="#customers"><?php echo TEXT_ORDER_PAYMENT; ?></a></li>
                                        <li><a href="#products"><?php echo TEXT_ORDER_PRODUCTS; ?></a></li>
                                        <?php if (ENABLE_MAP_TAB == 'true') { ?>
                                            <li><a href="#map" id="getmap"><?php echo TEXT_ORDER_MAP; ?></a></li>
                                        <?php } ?>
                                        <li><a href="#status"><?php echo TEXT_ORDER_STATUS; ?></a></li>
                                    </ul>

                                    <div id="orders">

                                        <table border="0">

                                            <tr>
                                                <td valign="top">
                                                    <table width="100%" border="0" cellspacing="0" cellpadding="2">
                                                        <tr>
                                                            <td class="main" valign="top">
                                                                <b><?php echo ENTRY_CUSTOMER; ?></b>
                                                            </td>
                                                            <td class="main"><?php echo $order->customer['name']; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '5'); ?></td>
                                                        </tr>
                                                        <?php echo tep_get_extra_fields_order($the_customers_id, $languages_id); ?>
                                                        <tr>
                                                            <td class="main"><b><?php echo ENTRY_TELEPHONE_NUMBER; ?></b>
                                                            </td>
                                                            <td class="main"><?php echo $order->customer['telephone']; ?></td>

                                                        </tr>
                                                        <tr>
                                                            <td class="main"><a href="https://web.whatsapp.com/send?phone=<?php echo str_replace("-", "", $order->customer['telephone']); ?>&text=%D0%97%D0%B4%D1%80%D0%B0%D0%B2%D1%81%D1%82%D0%B2%D1%83%D0%B9%D1%82%D0%B5%2C%20<?php echo mb_ereg_replace('^([^\s]*).*$', '\\1', trim($order->customer['name'])) . "\n"; ?>! %D0%92%D0%B0%D1%81%20%D0%B1%D0%B5%D1%81%D0%BF%D0%BE%D0%BA%D0%BE%D1%8F%D1%82%20%D0%B8%D0%B7%20%D0%AF%D0%BD%D0%B4%D0%B5%D0%BA%D1%81.%D0%9C%D0%B0%D1%80%D0%BA%D0%B5%D1%82%20%D0%BF%D0%BE%20%D0%BF%D0%BE%D0%B2%D0%BE%D0%B4%D1%83%20%D0%B7%D0%B0%D0%BA%D0%B0%D0%B7%20%E2%84%96 <?php echo $oID ?> - <?php echo str_replace("\"", "", $order->products[0]['qty'] . ' x ' . $order->products[0]['name'] . ' '); ?><?php echo str_replace("\"", "", '  ' . $order->products[1]['qty'] . ' x ' . $order->products[1]['name']); ?>" target="_blank"><b>
                                                                        <font color=red>Вацапнуть маркет</font>
                                                                    </b></a></td>
                                                        </tr>
                                                        <td class="main"><a href="https://web.whatsapp.com/send?phone=<?php echo str_replace("-", "", $order->customer['telephone']); ?>&text=%D0%97%D0%B4%D1%80%D0%B0%D0%B2%D1%81%D1%82%D0%B2%D1%83%D0%B9%D1%82%D0%B5%2C%20<?php echo mb_ereg_replace('^([^\s]*).*$', '\\1', trim($order->customer['name'])) . "\n"; ?>! %D0%92%D0%B0%D1%81%20%D0%B1%D0%B5%D1%81%D0%BF%D0%BE%D0%BA%D0%BE%D1%8F%D1%82%20%D0%B8%D0%B7%20%D0%BC%D0%B0%D0%B3%D0%B0%D0%B7%D0%B8%D0%BD%D0%B0%20YOURFISH%20%D0%BF%D0%BE%20%D0%BF%D0%BE%D0%B2%D0%BE%D0%B4%D1%83%20%D0%B7%D0%B0%D0%BA%D0%B0%D0%B7%D0%B0 <?php echo $oID ?> - <?php echo str_replace("\"", "", $order->products[0]['qty'] . ' x ' . $order->products[0]['name'] . ' '); ?><?php echo str_replace("\"", "", '  ' . $order->products[1]['qty'] . ' x ' . $order->products[1]['name']); ?>" target="_blank"><b>
                                                                    <font color=red>Вацапнуть фиш</font>
                                                                </b></a></td>
                                            </tr>



                                            <tr>
                                                <td class="main"><b><?php echo ENTRY_FAX_NUMBER; ?></b></td>
                                                <td class="main"><?php echo $order->customer['fax']; ?></td>
                                            </tr>
                                            <tr>
                                                <td class="main"><b><?php echo ENTRY_EMAIL_ADDRESS; ?></b></td>
                                                <td class="main"><?php echo $order->customer['email_address']; ?></td>
                                            </tr>
                                            <tr>
                                                <td class="main"><b><?php echo TEXT_REFERER; ?></b></td>
                                                <td class="main"><?php echo $order->info['customers_referer_url']; ?>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td class="main"><b><?php echo TEXT_INFO_DELETE_DATA_OID; ?></b>
                                                </td>
                                                <td class="main"><a href="https://partner.market.yandex.ru/shop/22787539/orders/<?php echo tep_db_input($oID); ?>?id=22787539" target="_blank"><?php echo tep_db_input($oID); ?></a></td>
                                            </tr>
                                            <!-- add date/time // -->
                                            <tr>
                                                <td class="main"><b><?php echo EMAIL_TEXT_DATE_ORDERED; ?></b>
                                                </td>
                                                <td class="main"><?php echo tep_datetime_short($order->info['date_purchased']); ?></td>
                                            </tr>

                                        </table>
                            </td>
                            <td valign="top">
                                <table width="100%" border="0" cellspacing="0" cellpadding="2">
                                    <tr>
                                        <td class="main" valign="top">
                                            <b><?php echo ENTRY_SHIPPING_ADDRESS; ?></b>
                                        </td>
                                        <td class="main"><?php echo tep_address_format($order->delivery['format_id'], $order->delivery, 1, '', '<br>'); ?></td>
                                    </tr>
                                </table>
                            </td>
                            <!--            <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="2">
              <tr>
                <td class="main" valign="top"><b><?php echo ENTRY_BILLING_ADDRESS; ?></b></td>
                <td class="main"><?php echo tep_address_format($order->billing['format_id'], $order->billing, 1, '', '<br>'); ?></td>
              </tr>
            </table></td>
-->
                        </tr>

                </table>

                </div>

                <div id="customers">

                    <table border="0">

                        <tr>
                            <td>
                                <table border="0" cellspacing="0" cellpadding="2">
                                    <?php
                                    // BOF: WebMakers.com Added: Show Order Info
                                    ?>
                                    <!-- add Order # // -->
                                    <?php
                                    // EOF: WebMakers.com Added: Show Order Info

                                    $shipping_method_query = tep_db_query("select title from " . TABLE_ORDERS_TOTAL . " where orders_id = '" . tep_db_input($_GET['oID']) . "' and class = 'ot_shipping'");
                                    $shipping_method = tep_db_fetch_array($shipping_method_query);

                                    $order_shipping_text = ((substr($shipping_method['title'], -1) == ':') ? substr(strip_tags($shipping_method['title']), 0, -1) : strip_tags($shipping_method['title']));

                                    ?>
                                    <tr>
                                        <td class="main"><b><?php echo ENTRY_PAYMENT_METHOD; ?></b></td>
                                        <td class="main"><?php echo $order->info['payment_method']; ?></td>
                                    </tr>
                                    <tr>
                                        <td class="main"><b><?php echo ENTRY_SHIPPING_METHOD; ?></b>
                                        </td>
                                        <td class="main"><?php echo $order_shipping_text; ?></td>
                                    </tr>
                                    <?php if (!empty($order->info['sber_order'])) {
                                        require_once __DIR__ . '/../sber/register.php';
                                        $status = SberRegister::statusOrder((int)$_REQUEST['oID'], $order->info['sber_order']);
                                        $sber_statuses = array(
                                            0 => 'Заказ зарегистрирован, но не оплачен',
                                            1 => 'Предавторизованная сумма захолдирована (для двухстадийных платежей)',
                                            2 => 'Проведена полная авторизация суммы заказа',
                                            3 => 'Авторизация отменена',
                                            4 => 'По транзакции была проведена операция возврата',
                                            5 => 'Инициирована авторизация через ACS банка-эмитента',
                                            6 => 'Авторизация отклонена.'
                                        );
                                        //echo $_REQUEST['status'];
                                        //echo $order->info['orders_status'];
                                        //echo $_GET['status'];
                                        if ($order->info['orders_status'] == 18) {
                                            $sber_info = $sber_statuses[2];
                                        } else {
                                            $sber_info = $sber_statuses[$status];
                                            $orderForm = '';

                                            if (!empty($sber_info) && $status < 2) {
                                                $orderForm = ' (<a target="_blank" href="' . SberRegister::getOrderForm($order->info['sber_order']) . '">ссылка на форму оплаты</a>)';
                                            }
                                        }
                                    ?>
                                        <tr>
                                            <td class="main"><b>Оплата/Предоплата Заказа:</b></td>
                                            <td class="main"><?= empty($sber_info) ? "Возможность оплаты не предоставлялась" : $sber_info . $orderForm ?></td>
                                        </tr>
                                    <?php } ?>
                                    <?php
                                    if (tep_not_null($order->info['cc_type']) || tep_not_null($order->info['cc_owner']) || tep_not_null($order->info['cc_number'])) {
                                    ?>
                                        <tr>
                                            <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
                                        </tr>
                                        <tr>
                                            <td class="main"><?php echo ENTRY_CREDIT_CARD_TYPE; ?></td>
                                            <td class="main"><?php echo $order->info['cc_type']; ?></td>
                                        </tr>
                                        <tr>
                                            <td class="main"><?php echo ENTRY_CREDIT_CARD_OWNER; ?></td>
                                            <td class="main"><?php echo $order->info['cc_owner']; ?></td>
                                        </tr>
                                        <tr>
                                            <td class="main"><?php echo ENTRY_CREDIT_CARD_NUMBER; ?></td>
                                            <td class="main"><?php echo $order->info['cc_number']; ?></td>
                                        </tr>
                                        <tr>
                                            <td class="main"><?php echo ENTRY_CREDIT_CARD_EXPIRES; ?></td>
                                            <td class="main"><?php echo $order->info['cc_expires']; ?></td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </table>
                            </td>
                        </tr>

                    </table>

                </div>

                <div id="products">

                    <table border="1" width="93%" cellspacing="0" cellpadding="2">
                        <tr class="dataTableHeadingRow">
                            <td class="dataTableHeadingContent" colspan="2"><?php echo TABLE_HEADING_PRODUCTS; ?></td>
                            <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_PRODUCTS_MODEL; ?></td>

                            <td class="dataTableHeadingContent" align="center"><?php echo TABLE_HEADING_PRICE_INCLUDING_TAX; ?></td>
                            <td class="dataTableHeadingContent" align="center"><?php echo TABLE_HEADING_TOTAL_INCLUDING_TAX; ?></td>

                            <td class="dataTableHeadingContent" colspan="2" align="left">Количество</td>
                        </tr>
                        <?php
                        $pribil1 = 0;
                        for ($i = 0, $n = sizeof($order->products); $i < $n; $i++) {


                            //---get quantity by iHolder
                            try {
                                $qtq = tep_db_query('select p.supplier_id as suplik, p.products_price, pd.products_id as pid,products_quantity as cnt,products_barcode from products p
left join products_description pd on (p.products_id=pd.products_id)
where
pd.products_name="' . mysql_escape_string($order->products[$i]['name']) . '"');
                                $barcode_line = '';
                                $sdiscount = 0;
                                if ($qtq !== false) {
                                    $qres = tep_db_fetch_array($qtq);
                                    if (isset($qres['pid'])) {
                                        $sprice = tep_get_products_special_price($qres['pid']);
                                        //	    echo $sprice.'--'.$qres['products_price'];
                                        if ($sprice !== false) {
                                            $sdiscount = 100 - round($sprice * 100 / $qres['products_price'], 0);
                                        }
                                    }
                                    //        var_dump($qres);exit;
                                    if ((int)$qres['cnt'] < 500) {
                                        $instore = ' * ';
                                    } else {
                                        $instore = ' ** ';
                                    }
                                    $barcode_line = $qres['products_barcode'];
                                }
                            } catch (Exception $e) {
                                $instore = '';
                            }
                            //---get quantity by iHolder


                            $display_discount = '';
                            if ($sdiscount > 0) {
                                $display_discount = '<span style="color:red">(-' . $sdiscount . '%)</span>';
                            }
                            $str123 = $order->products[$i]['name'];
                            $rus = array('А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ъ', 'Ы', 'Ь', 'Э', 'Ю', 'Я', 'а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'ю', 'я', '-', ' ', '0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '.', '(', ')', ',', '№', '"');
                            $lat = array('A', 'B', 'V', 'G', 'D', 'E', 'E', 'Gh', 'Z', 'I', 'Y', 'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'U', 'F', 'H', 'C', 'Ch', 'Sh', 'Sch', 'Y', 'Y', 'Y', 'E', 'Yu', 'Ya', 'a', 'b', 'v', 'g', 'd', 'e', 'e', 'gh', 'z', 'i', 'y', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'h', 'c', 'ch', 'sh', 'sch', 'y', 'y', 'y', 'e', 'yu', 'ya', '*', '-', '*', '*', '*', '*', '*', '*', '*', '*', '*', '*', '', '', '', '', '', '');
                            $url1 = str_replace($rus, $lat, $str123);
                            if (strpos($url1, "*") !== false) {
                                $url = strstr($url1, '*', true);
                                $url2 = substr($url, -1);
                                if ($url2 == "-") {
                                    $url = substr($url, 0, -1);
                                }
                            }
                            $producturl = $url . '-p-' . $order->products[$i]['products_id'];
                            echo '          <tr class="dataTableRow">' . "\n" .
                                '            <td class="dataTableContent" valign="top" align="right">' . $instore . $order->products[$i]['qty'] . '&nbsp;x</td>' . "\n" .
                                '            <td class="dataTableContent" valign="top"><a target="_blank" href="https://yourfish.ru/' . $producturl . '">' . $order->products[$i]['name'] . $display_discount;
                            if (isset($order->products[$i]['attributes']) && (sizeof($order->products[$i]['attributes']) > 0)) {
                                for ($j = 0, $k = sizeof($order->products[$i]['attributes']); $j < $k; $j++) {
                                    echo '<br><nobr><small>&nbsp;<i> - ' . $order->products[$i]['attributes'][$j]['option'] . ': ' . $order->products[$i]['attributes'][$j]['value'];
                                    if ($order->products[$i]['attributes'][$j]['price'] != '0') echo ' (' . $order->products[$i]['attributes'][$j]['prefix'] . $currencies->format($order->products[$i]['attributes'][$j]['price'] * $order->products[$i]['qty'], true, $order->info['currency'], $order->info['currency_value']) . ')';
                                    echo '</i></small></nobr>';
                                }
                            }
                            //$sup_id_query = tep_db_query ("select supplier_id from products where products_id=". $order->products[$i]['id']); //." LEFT JOIN supplier as s on p.supplier_id = s.supplier_id");
                            //$sup_id = tep_db_fetch_array($sup_id_query); 
                            //$sup_name_query = tep_db_query("select supplier_name from supplier where supplier_id=" . $sup_id['supplier_id']);
                            //$sup_name= tep_db_fetch_array($sup_name_query); 
                            //$sn=array_map('strtolower', $sup_name);

                            $price_query = tep_db_query("select * from `price_order_relations` where order_id = " . (int)$oID . " and product_id=" . $order->products[$i]['id']);
                            $product_order = tep_db_fetch_array($price_query);
                            //$minus = $order->products[$i]['zakaz_price'] * $order->products[$i]['qty'];
                            //$pribil = $order->products[$i]['final_price'] * $order->products[$i]['qty'] -  $minus;
                            //$pribil1 = $pribil1 + $pribil;
                            echo '            </td>' . "\n" .
                                '            <td class="dataTableContent" va  lign="top"><a target ="_blank" href="https://yourfish.ru/admin/categories.php?search=' . $order->products[$i]['model'] . '">' . $order->products[$i]['model'] . '</a></td>' . "\n" .
                                '            <td class="dataTableContent" align="right" valign="top"><b>' . $currencies->format($order->products[$i]['final_price'], true, $order->info['currency'], $order->info['currency_value']) . '</b></td>' . "\n" .
                                '            <td class="dataTableContent" align="right" valign="top"><b>' . $currencies->format(tep_add_tax($order->products[$i]['final_price'], $order->products[$i]['tax'], true) * $order->products[$i]['qty'], true, $order->info['currency'], $order->info['currency_value']) . '</b></td>' . "\n";

                            if (!empty($product_order)) {
                                echo ' <td class="dataTableContent" colspan="2" align="left" valign="top">Добавлено ' . $product_order['count'] .
                                    ' <button  style="background: #dbdbdb" data-productind="' . $i . '" data-qty="' . $order->products[$i]['qty'] . '" data-orderid="' . (int)$oID . '" onclick="deorderSupplier(this)">Отменить</button>' .
                                    '</td>';
                            } else {
                                echo '            <td class="dataTableContent" colspan="2"  align="left" valign="top"><input  style="width:40px"   type="number" name="count" min="1" step="1" value="' . $order->products[$i]['qty'] . '">
            <button  style="background: #c7dbff" data-productind="' . $i . '" data-qty="' . $order->products[$i]['qty'] . '" data-orderid="' . (int)$oID . '" onclick="orderSupplier(this)">Заказать</button>
            </td>' . "\n";
                            }

                            echo '          </tr>' . "\n";
                        }
                        ?>
                        <tr>
                            <td align="right" colspan="5">
                                <table border="0" cellspacing="0" cellpadding="2">
                                    <?php
                                    for ($i = 0, $n = sizeof($order->totals); $i < $n; $i++) {
                                        echo '              <tr>' . "\n" .
                                            '                <td align="right" class="smallText">' . $order->totals[$i]['title'] . '</td>' . "\n" .
                                            '                <td align="right" class="smallText">' . $order->totals[$i]['text'] . '</td>' . "\n" .
                                            '              </tr>' . "\n";
                                    }

                                    ?>
                                </table>
                            </td>
                        </tr>
                    </table>

                    <p>
                        <span style="display:inline-block;width:30px">*</span>- В наличии<br>
                        <span style="display:inline-block;width:30px">**</span>- Заказать
                    </p>


                </div>

                <?php if (ENABLE_MAP_TAB == 'true') { ?>

                    <div id="map">

                        <?php

                            $street_address = (!isset($order->delivery["street_address"])) ? null : $order->delivery["street_address"];
                            $city = (!isset($order->delivery["city"])) ? null : $order->delivery["city"] . ', ';
                            $postcode = (!isset($order->delivery["postcode"])) ? null : $order->delivery["postcode"] . ', ';
                            $state = (!isset($order->delivery["state"])) ? null : $order->delivery["state"] . ', ';
                            $country = (!isset($order->delivery["country"])) ? null : $order->delivery["country"] . ', ';
                            $ship_address = $postcode . $city . $street_address;

                        ?>

                        <script type="text/javascript">
                            // Флаг, обозачающий произошла ли ошибка при загрузке API
                            var flagApiFault = 0;

                            // Функция для обработки ошибок при загрузке API
                            function apifault(err) {
                                // Создание обработчика для события window.onLoad
                                // Отображаем сообщение об ошибке в контейнере над картой
                                window.onload = function() {
                                    var errorContainer = document.getElementById("error");
                                    errorContainer.innerHTML = "<?php echo MAP_API_KEY_ERROR; ?> \"" + err + "\"";
                                    errorContainer.style.display = "";
                                }
                                flagApiFault = 1;
                            }
                        </script>
                        <script src="https://api-maps.yandex.ru/2.1/?apikey=a10398eb-7d7f-43ff-a60f-3c7c71ec1978&lang=ru_RU" type="text/javascript"></script>

                        <script type="text/javascript">
                            $(document).ready(function() {
                                $("#getmap").click(function() {


                                    if (!flagApiFault) {
                                        // Создает обработчик события window.onLoad
                                        YMaps.jQuery(function() {
                                            // Создает экземпляр карты и привязывает его к созданному контейнеру
                                            var map = new YMaps.Map(YMaps.jQuery("#YMapsID")[0]);

                                            map.addControl(new YMaps.TypeControl());
                                            map.addControl(new YMaps.ToolBar());
                                            map.addControl(new YMaps.Zoom());
                                            map.addControl(new YMaps.ScaleLine());

                                            var geocoder = new YMaps.Geocoder("<?php echo $ship_address; ?>");

                                            map.addOverlay(geocoder);

                                            // По завершению геокодирования инициализируем карту первым результатом
                                            YMaps.Events.observe(geocoder, geocoder.Events.Load, function(geocoder) {
                                                if (geocoder.length()) {
                                                    map.setBounds(geocoder.get(0).getBounds());
                                                }
                                            });


                                        })
                                    }
                                })

                            });
                        </script>

                        <div id="error" style="display:none"></div>
                        <div id="YMapsID" style="width:100%;height:350px"></div>

                    </div>

                <?php } ?>

                <div id="status">

                    <table border="0">

                        <tr>
                            <td class="main">
                                <table border="1" cellspacing="0" cellpadding="5">
                                    <tr>
                                        <td class="smallText" align="center">
                                            <b><?php echo TABLE_HEADING_DATE_ADDED; ?></b>
                                        </td>
                                        <td class="smallText" align="center">
                                            <b><?php echo TABLE_HEADING_CUSTOMER_NOTIFIED; ?></b>
                                        </td>
                                        <td class="smallText" align="center">
                                            <b><?php echo TABLE_HEADING_CUSTOMER_VISIBLE; ?></b>
                                        </td>
                                        <td class="smallText" align="center">
                                            <b><?php echo TABLE_HEADING_STATUS; ?></b>
                                        </td>
                                        <td class="smallText" align="center">
                                            <b><?php echo TABLE_HEADING_COMMENTS; ?></b>
                                        </td>
                                    </tr>
                                    <?php
                                    $orders_history_query = tep_db_query("select orders_status_id, date_added, customer_notified, comments,customer_visible from " . TABLE_ORDERS_STATUS_HISTORY . " where orders_id = '" . (int)$oID . "' order by date_added");
                                    if (tep_db_num_rows($orders_history_query)) {
                                        while ($orders_history = tep_db_fetch_array($orders_history_query)) {
                                            echo '          <tr>' . "\n" .
                                                '            <td class="smallText" align="center">' . tep_datetime_short($orders_history['date_added']) . '</td>' . "\n" .
                                                '            <td class="smallText" align="center">';
                                            if ($orders_history['customer_notified'] == '1') {
                                                echo tep_image(DIR_WS_ICONS . 'tick.gif', ICON_TICK) . "</td>\n";
                                            } else {
                                                echo tep_image(DIR_WS_ICONS . 'cross.gif', ICON_CROSS) . "</td>\n";
                                            }
                                            echo '            <td class="smallText" align="center">';
                                            if ($orders_history['customer_visible'] == '1') {
                                                echo tep_image(DIR_WS_ICONS . 'tick.gif', ICON_TICK) . "</td>\n";
                                            } else {
                                                echo tep_image(DIR_WS_ICONS . 'cross.gif', ICON_CROSS) . "</td>\n";
                                            }

                                            echo '            <td class="smallText">' . $orders_status_array[$orders_history['orders_status_id']] . '</td>' . "\n" .
                                                '            <td class="smallText">' . nl2br(tep_db_output($orders_history['comments'])) . '&nbsp;</td>' . "\n" .
                                                '          </tr>' . "\n";
                                            //$comments_address=($orders_history['comments']);   
                                        }
                                    } else {
                                        echo '          <tr>' . "\n" .
                                            '            <td class="smallText" colspan="5">' . TEXT_NO_ORDER_HISTORY . '</td>' . "\n" .
                                            '          </tr>' . "\n";
                                    }


                                    ?>




                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td class="main"><br><b><?php echo TABLE_HEADING_COMMENTS; ?></b></td>
                        </tr>
                        <tr>
                            <td><?php echo tep_draw_separator('pixel_trans.gif', '1', '5'); ?></td>
                        </tr>
                        <tr><?php echo tep_draw_form('status', FILENAME_ORDERS, tep_get_all_get_params(array('action')) . 'action=update_order'); ?>

                            <?php
                            $orders_sum = round(($order->totals[count($order->totals) - 1]['value']));
                            $komment = "Сначала нужно сформировать счёт";
                            if (($sber_info) and ($order->info['payment_method'] == 'Наложенный Платеж (Предоплата за доставку)')) {
                                $komment = "
Ссылка на оплату доставки - " . SberRegister::getOrderForm($order->info['sber_order']);
                            } elseif (($sber_info) and ($order->info['payment_method'] !== MODULE_PAYMENT_NAL_TEXT_TITLE)) {
                                $komment = "
Ссылка на оплату заказа- " . SberRegister::getOrderForm($order->info['sber_order']);
                            };
                            $komments_dop_oplata = "
Сумма - " . $orders_sum . " руб.
Номер нашей карты Сбербанка 5228 6005 4159 9645 Александр Петрович Б.
*Поле - Сообщение получателю - не заполняйте.
Либо:
Пополнение телефона: +7-950-016-85-70 Tele2
На яндекс.деньги: 41001117781117
На Qiwi кошелёк: 7926-266-32-18
WebMoney: R363270505613
По квитанции Сбербанка -  https://yourfish.ru/kvitan.rtf";

                            $komment_na_schet = "
Сумма - " . $orders_sum . " руб.
Заказ готов.

Оплата через приложение Банка на наши реквизиты

ИНН: 772465031143
Далее выберите:
ИП РЫБЛОВ НИКИТА ИЛЬИЧ
Счёт № 40802810738060147444
БИК 044525225
К/С 30101810400000000225"


                            ?>

                            <td class="main"><?php echo tep_draw_textarea_field2('comments', 'soft', '60', '12'); ?>

                                <a href="#" style="padding: 5px; background: lightgray; position: absolute; text-align: center; text-decoration: none; color: purple;" onclick="var komment = `<?php echo $komment; ?>`; document.getElementsByName('comments')[0].value+=komment; document.getElementsByName('status')[1].options[0].selected=true; return false;">
                                    <<< Добавить текст с оплатой по ссылке</a>



                                        <a href="#" style="margin-top:30px; padding: 5px; background: lightgreen; position: absolute; text-align: center; text-decoration: none; color: purple;" onclick="var komments_dop_oplata = `<?php echo $komments_dop_oplata; ?>`; document.getElementsByName('comments')[0].value+=komments_dop_oplata; document.getElementsByName('status')[1].options[0].selected=true; return false;">
                                            <<< Добавить текст с остальными способами оплаты</a>

                                                <a href="#" style="margin-top:30px; padding: 5px; margin-left: 400px; background: white; position: absolute; text-align: center; text-decoration: none; color: purple;" onclick="var komments_dop_oplata = `<?php echo $komments_dop_oplata2; ?>`; document.getElementsByName('comments')[0].value+=komments_dop_oplata; document.getElementsByName('status')[1].options[0].selected=true; return false;">
                                                    <font color="white">
                                                        <<<<<< /font>
                                                </a>




                                                <a href="#" style="margin-top:60px; padding: 5px; background: DeepSkyBlue; position: absolute; text-align: center; text-decoration: none; color: purple;" onclick="var komment_na_schet = `<?php echo $komment_na_schet; ?>`; document.getElementsByName('comments')[0].value+=komment_na_schet; document.getElementsByName('status')[1].options[0].selected=true; return false;">
                                                    <<< Добавить текст с оплатой по ИНН</a>

                                                        <a href="#" style="margin-top:90px; padding: 5px; background: Pink; position: absolute; text-align: center; text-decoration: none; color: purple;" onclick="var komment = `<?php echo $komment; ?>`; document.getElementsByName('comments')[0].value+='ПОДТВЕРДИТЕ ОТПРАВКУ ЗАКАЗА В ОТВЕТНОМ ПИСЬМЕ, ПОЖАЛУЙСТА'; document.getElementsByName('status')[1].options[12].selected=true; return false;">
                                                            <<< Подтвердите отправку</a>


                                                                <a href="#" style="margin-top:120px; padding: 5px; background: Aquamarine; position: absolute; text-align: center; text-decoration: none; color: purple;" onclick="var komment = `<?php echo $komment; ?>`; document.getElementsByName('comments')[0].value='Извините, нет в наличии.'; document.getElementsByName('status')[1].options[4].selected=true; return false;">
                                                                    <<< Нет в наличии</a>



                                                                        <a href="#" style="margin-top:150px; padding: 5px; background: lightblue; position: absolute; text-align: center; text-decoration: none; color: purple;" onclick="document.getElementsByName('comments')[0].value=' '; return false;">
                                                                            <<< Очистить</a>
                            </td>


                        </tr>
                        <tr>
                            <td><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
                        </tr>
                        <tr>
                            <td>
                                <table border="0" cellspacing="0" cellpadding="2">
                                    <tr>
                                        <td>
                                            <table border="0" cellspacing="0" cellpadding="2">
                                                <tr>
                                                    <td class="main">
                                                        <b><?php echo ENTRY_STATUS; ?></b> <?php echo tep_draw_pull_down_menu('status', $orders_statuses, $order->info['orders_status']); ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="main">
                                                        <b><?php echo ENTRY_NOTIFY_CUSTOMER; ?></b> <?php echo tep_draw_checkbox_field('notify', '', true); ?>
                                                    </td>
                                                    <td class="main">





                                                        <b><?php echo ENTRY_NOTIFY_COMMENTS; ?></b>
                                                        <?php echo tep_draw_checkbox_field('notify_comments', '', true); ?>
                                                        <!--		<br>
		<b><?php echo TABLE_HEADING_CUSTOMER_VISIBLE; ?></b>
		<?php echo tep_draw_checkbox_field('customer_visible', '', true); ?>
	-->
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                        <td valign="top"><?php echo tep_image_submit('button_update.gif', IMAGE_UPDATE); ?></td>
                                    </tr>
                                    <tr class="main">
                                        <td>
                                            <b>Планируемая дата отгрузки:</b><input onchange="let b=document.getElementsByName('orders_date_finished')[0].value.split('-'); let d=new Date(b); d=d.toLocaleString('ru', {
  weekday: 'long',
  year: 'numeric',
  month: 'long',
  day: 'numeric'
}); document.getElementsByName('comments')[0].value+='\nПланируемая дата отгрузки: ' + d; return false;" type="date" name="orders_date_finished" value="<?= empty($order->info['orders_date_finished']) ? "" : date('Y-m-d', strtotime($order->info['orders_date_finished'])) ?>" min="<?= date('Y-m-d', strtotime($order->info['date_purchased'])) ?>">


                                            <br><a href="https://yourfish.ru/sms.txt" target="_blank">Тексты СМС</a><br>







                                            <?php
                                            require('../' . DIR_WS_LANGUAGES . 'russian/modules/payment/nal.php');
                                            $customers_name = $order->customer['name'];
                                            $search = array('+', ' ');
                                            $tel = str_replace($search, "", $order->customer['telephone']);
                                            $customers_tel = $tel;
                                            $orders_sum = round(($order->totals[count($order->totals) - 1]['value']));
                                            $nomer_zakaza = $oID;
                                            $index_from = 125413;
                                            $orders_history_query2 = tep_db_query("select comments from " . TABLE_ORDERS_STATUS_HISTORY . " where orders_id = '" . (int)$oID . "' order by date_added limit 1");
                                            $taks = tep_db_fetch_array($orders_history_query2);
                                            $customers_address = $taks['comments'];
                                            $payment_method = $order->info['payment_method'];
                                            if ($order->info['payment_method'] == MODULE_PAYMENT_NAL_TEXT_TITLE) {
                                                $payment_method = $orders_sum;
                                            } else {
                                                $payment_method = 0;
                                                $orders_sum = 0;
                                            }
                                            $massa = 1;
                                            function pochta($customers_name, $customers_tel, $orders_sum, $nomer_zakaza, $index_from, $customers_address, $payment_method, $massa)
                                            {
                                                tep_db_query("insert into pochta
    (ADDRESSLINE, ADRESAT,	MASS,	VALUE,	PAYMENT,	COMMENT,	TELADDRESS,	MAILTYPE,	INDEXFROM,	ORDER_ID) 
	values 
    ('" . $customers_address . "'
	, '" . $customers_name . "'
	, " . $massa .
                                                    ", " . $orders_sum . ", " .
                                                    $payment_method . "
	, " . $nomer_zakaza . "
	, '" . $customers_tel . "'
	, 4, " . $index_from . "
	, " . $nomer_zakaza . ")");
                                            }



                                            $search = array('-', ')', '(', ' ');
                                            $tel = str_replace($search, "", $order->customer['telephone']);
                                            $data = array(
                                                "data" => array(
                                                    "addresses"   => array($tel),
                                                    "message" => "Заказ № " . (int)$oID .  " готов. Проверьте Email (и папку Спам). YOURFISH.RU",
                                                    "target_device_iden" => "ujCebCmJMyWsjBAT2Rkeey"//mashin A7 -"ujCebCmJMyWsjvEKd3c3P2" //alisin tel -"ujCebCmJMyWsjBQ9UrR0mq"//mashinA7 -"ujCebCmJMyWsjvEKd3c3P2"//eto A7 - "ujCebCmJMyWsjv9KNd3kGa"
                                                )
                                            );
                                            $data_comment = array(
                                                "data" => array(
                                                    "addresses"   => array($tel),
                                                    "message" => "К заказу добавлен комментарий. Проверьте Email. YOURFISH.RU",
                                                    "target_device_iden" => "ujCebCmJMyWsjBAT2Rkeey"//"ujCebCmJMyWsjvEKd3c3P2" //alisin tel-"ujCebCmJMyWsjBQ9UrR0mq"//mashinA7 -"ujCebCmJMyWsjvEKd3c3P2"//"S5 -ujCebCmJMyWsjwnQTN65LM"//"ujCebCmJMyWsjv9KNd3kGa"
                                                )
                                            );

                                            $data_text = array(
                                                "data" => array(
                                                    "addresses"   => array($tel),
                                                    "message" => $_POST['smstext'],
                                                    "target_device_iden" => "ujCebCmJMyWsjBAT2Rkeey"//"ujCebCmJMyWsjvEKd3c3P2" //alisin tel-"ujCebCmJMyWsjBQ9UrR0mq"//mashinA7 -"ujCebCmJMyWsjvEKd3c3P2"//"ujCebCmJMyWsjv9KNd3kGa"//
                                                )
                                            );

                                            function sendSMS($data)
                                            {
                                                $ch = curl_init();
                                                curl_setopt($ch, CURLOPT_URL, "https://api.pushbullet.com/v2/texts");
                                                curl_setopt($ch, CURLOPT_POST, 1);
                                                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
                                                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                                                curl_setopt($ch, CURLOPT_HEADER, true);
                                                curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json; charset=utf-8", "Access-Token: o.JNYdz8BzzY9PrV40KVQGdfHeUx0IRBr3",));
                                                $html = curl_exec($ch);
                                                curl_close($ch);
                                            }

                                            $orders_sum = round(($order->totals[count($order->totals) - 1]['value']));
                                            $timestamp = new DateTime();
                                            $timestamp2 = new DateTime('6 hours');
                                            $data_dost = array(
                                                "deliveries" => array(
                                                    array(
                                                        "matter"         => "Рыболовные снасти",
                                                        "address"        => $customers_address,
                                                        "weight_kg"      => 1,
                                                        "client_order_id" => $nomer_zakaza,
                                                        "required_start_datetime" => $timestamp->format('c'),
                                                        "required_finish_datetime" => $timestamp2->format('c'),
                                                        "taking_amount" => $orders_sum,
                                                        "insurance_amount" => $orders_sum,
                                                        "is_door_to_door" => true,
                                                        "contact_person" => array(
                                                            "phone" => $customers_tel,
                                                            "name" => $customers_name,
                                                        ),
                                                    ),
                                                ),
                                            );

                                            function dostavista($data_dost)
                                            {
                                                $curl = curl_init();
                                                curl_setopt($curl, CURLOPT_URL, 'https://robot.dostavista.ru/api/business/1.1/create-deliveries');
                                                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
                                                curl_setopt($curl, CURLOPT_HTTPHEADER, array("X-DV-Auth-Token: E85F748EA609CD9EED17CE25CDCC09CCC0207011"));
                                                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
                                                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                                                curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data_dost));
                                                curl_exec($curl);
                                            }

                                            function bemal()
                                            {
                                            }


                                            ?>
                                            <form method="get">

                                            </form>
                                            <form method="post">
                                                <p><input type="submit" name="bemal" value="Бемал" /></p>
                                                <p><input type="submit" name="pochta" value="Почта" /></p>
                                                <p><input type="submit" name="dost" value="Достависта" /></p>
                                                <p><input type="submit" name="nopay" value="Напомнить об оплате и сменить статус" /></p>
                                                <p><input type="submit" name="sms2" value="Отправить СМС о готовности заказа" /></p>
                                                <p><input type="submit" name="sms3" value="Отправить СМС о добавлении комментария" /></p>
                                                <p><input type="submit" name="smstextbtn" value="Отправить СМС с любым текстом &#8595&#8595;&#8595;" /></p>
                                                <p><textarea cols="30" rows="5" name="smstext" id="smstext">Заказ <?php echo (int)$oID; ?>. YOURFISH.RU</textarea>
                                                    <a href="#" style="margin-top:32px; padding: 5px; background: pink; position: absolute; text-align: center; text-decoration: none; color: purple;" onclick="document.getElementsByName('smstext')[0].value='Пришлите Email или номер WhatsApp для обработки заказа <?php echo (int)$oID; ?>. YOURFISH.RU '; return false;">
                                                        <<< Запрос для связи</a>
                                                            <a href="#" style="margin-top:2px; padding: 5px; background: cyan; position: absolute; text-align: center; text-decoration: none; color: purple;" onclick="document.getElementsByName('smstext')[0].value='Ваш заказ <?php echo (int)$oID; ?> готов. Самовывоз: Москва, 4й-Лихачёвский переулок 2с2  Перед приездом свяжитесь 88002224149. Оплата наличными. YOURFISH.RU  '; return false;">
                                                                <<< Готов к самовывозу</a>

                                                </p>



                                            </form>

                                            <?php

                                            if ($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['sms2'])) {
                                                sendsms($data);
                                            }
                                            if ($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['sms3'])) {
                                                sendsms($data_comment);
                                            }
                                            if ($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['smstextbtn'])) {
                                                sendsms($data_text);
                                            }
                                            if ($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['pochta'])) {
                                                pochta($customers_name, $customers_tel, $orders_sum, $nomer_zakaza, $index_from, $customers_address, $payment_method, $massa);
                                            }

                                            if ($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['dost'])) {
                                                dostavista($data_dost);
                                            }

                                            //dlya net oplaty
                                            if ($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['nopay'])) {

                                                $email_order = STORE_NAME . "\n" .
                                                    EMAIL_SEPARATOR . "\n" .
                                                    'РЕЗЕРВ ЗАКАЗА ЗАКОНЧЕН, ДЛЯ ЕГО ВОЗОБНОВЛЕНИЯ И ОТПРАВКИ НЕОБХОДИМО ПРОИЗВЕСТИ ОПЛАТУ.'  . "\n" .
                                                    EMAIL_SEPARATOR . "\n" .
                                                    EMAIL_TEXT_ORDER_NUMBER . ' ' . (int)$oID . "\n" .
                                                    ((tep_session_is_registered('customer_id') && $guest_account == false) ? EMAIL_TEXT_INVOICE_URL . ' ' . tep_href_link(FILENAME_ACCOUNT_HISTORY_INFO, 'order_id=' . $orderId, 'SSL', false) . "\n" : '') .
                                                    EMAIL_TEXT_DATE_ORDERED . ' ' . strftime(DATE_FORMAT_LONG) . "\n" .
                                                    EMAIL_TEXT_CUSTOMER_NAME . ' ' . $order->customer['name'] . "\n" .
                                                    EMAIL_TEXT_CUSTOMER_EMAIL_ADDRESS . ' ' . $order->customer['email_address'] . "\n" .
                                                    EMAIL_TEXT_CUSTOMER_TELEPHONE . ' ' . $order->customer['telephone'] . "\n\n";
                                                if ($order->info['comments']) {
                                                    $email_order .= tep_db_output($order->info['comments']) . "\n\n";
                                                }

                                                for ($i = 0, $n = sizeof($order->products); $i < $n; $i++) {
                                                    //$total_weight += ($order->products[$i]['qty'] * $order->products[$i]['weight']);
                                                    //$total_tax += tep_calculate_tax($total_products_price, $products_tax) * $order->products[$i]['qty'];
                                                    //$total_cost += $total_products_price;
                                                    $products_ordered .= $order->products[$i]['qty'] . ' x ' . $order->products[$i]['name'] . ' (' . $order->products[$i]['model'] . ') = ' . round($order->products[$i]['final_price'] * $order->products[$i]['qty']) . ' руб.' . $products_ordered_attributes . "\n";
                                                }
                                                $email_order .= 'Заказанные снасти' . "\n" .
                                                    EMAIL_SEPARATOR . "\n" .
                                                    $products_ordered .
                                                    EMAIL_SEPARATOR . "\n";

                                                for ($i = 0, $n = sizeof($order->totals); $i < $n; $i++) {
                                                    $email_order .= strip_tags($order->totals[$i]['title']) . ' ' . strip_tags($order->totals[$i]['text']) . "\n";
                                                }
                                                $email_order .= EMAIL_SEPARATOR . "\n";

                                                $email_order .=
                                                    ' Мы не получили предоплату по Вашему заказу. Срок резерва закончен. 
Если он всё же Вам нужен, можете воспользоваться следующими реквизитами для предоплаты.
Предоплата составляет 300 руб. 
Оставшаяся сумма за вычетом предоплаты оплачивается при получении заказа.
Номер нашей карты Сбербанка 4276 3801 4352 6460 Александр Петрович Б.
*Поле "Сообщение получателю" не заполняйте.
Либо:
Пополнение телефона: +7-950-016-85-70 Tele2
На яндекс.деньги: 41001117781117
На Qiwi кошелёк: 7926-266-32-18
WebMoney: R363270505613
По квитанции Сбербанка -  https://yourfish.ru/kvitan.rtf
После оплаты сообщите номер заказа на почту magazin@yourfsih.ru,
или по смс на номер 8-950-016-85-70 или 
в WhatsApp по номеру 8-926-266-32-18
либо в окно Консультант на сайте.';



                                                tep_mail($order->customer['name'], $order->customer['email_address'], 'Резерв заказа закончен', $email_order, STORE_OWNER, STORE_OWNER_EMAIL_ADDRESS);
                                                sendsms($data_comment);
                                                tep_db_query("insert into orders_status_history
		(orders_id, orders_status_id, date_added, customer_notified, comments,customer_visible)
		values(" . $oID . ", 21 , now(), 0, ' ', 1)");
                                            }

                                            unset($_POST['nopay']);
                                            ?>



                                        </td>


                                    </tr>

                                </table>
                            </td>
                            <?php echo tep_hide_session_id(); ?></form>
                        </tr>

                    </table>

                </div>
                </div>
        <tr>
            <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '5'); ?></td>
        </tr>
        <tr>
            <script>
                /*							
	$( document ).ready(function(){
	  $( "#button" ).click(function(){ // задаем функцию при нажатиии на элемент <button>
	    $.ajax({
		url: '..sber/sber_check.php?oID=<?php echo $_GET['oID']; ?>',
        success: function(data) {
        
		}
		})
		})
		})*/
            </script>



            <td colspan="2" align="right">
                <?php

                        //echo '<pre>';
                        //var_dump($order);
                        //echo '</pre>';
                        //echo $customers_tel;
                        //echo $orders_sum;

                        // echo '<a href="/pochta.php?oID=' . $_GET['oID'] . '" target=_blank><button>ПОЧТА</button></a>';


                        echo '<a href="' . tep_href_link(FILENAME_ORDERS_INVOICE, 'oID=' . $_GET['oID']) . '" TARGET="_blank">' . tep_image_button('button_invoice.gif', IMAGE_ORDERS_INVOICE) . '</a>&nbsp;';
                        if (empty($order->info['sber_order'])) {
                            require('../' . DIR_WS_LANGUAGES . 'russian/modules/payment/nal.php');

                            if ($order->info['payment_method'] == MODULE_PAYMENT_NAL_TEXT_TITLE) {
                                echo '<a href="/sber_check.php?oID=' . $_GET['oID'] . '"><button>Сформировать счёт на оплату пересылки</button></a>';
                            } else {
                                echo '<a href="/sber_check.php?oID=' . $_GET['oID'] . '"><button>Сформировать счёт на оплату</button></a>';
                            }
                        }
                        echo '<a href="' . tep_href_link(FILENAME_ORDERS_PACKINGSLIP, 'oID=' . $_GET['oID']) . '" TARGET="_blank">' . tep_image_button('button_packingslip.gif', IMAGE_ORDERS_PACKINGSLIP) . '</a>';
                        if ($CDEK_INFO['cdek']) {
                            echo '&nbsp;<a href="' . tep_href_link(FILENAME_ORDERS, tep_get_all_get_params(array('action')) . '&action=cdek') . '">' . tep_image_button('sdek.png', CDEK_INVOICE) . '</a>';
                        }
                        echo '&nbsp;<a href="' . tep_href_link(FILENAME_ORDERS_PACKINGSLIP, 'oID=' . $_GET['oID'] . '&bc=1') . '" TARGET="_blank">' . tep_image_button('button_packingslip_bc.gif', IMAGE_ORDERS_PACKINGSLIP) . '</a>
        &nbsp;<a href="' . tep_href_link(FILENAME_ORDERS, tep_get_all_get_params(array('action'))) . '">' . tep_image_button('button_back.gif', IMAGE_BACK) . '</a>'; ?></td>
        </tr>
    <?php
                    } else {
    ?>
        <tr>
            <td width="100%">
                <table class="table-padding-0">
                    <tr>
                        <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
                        <td class="pageHeading" align="right">
                            <a href="ostatki.php" target="_blank">
                                <button>Остатки</button>
                            </a>
                        </td>
                        <td class="pageHeading" align="right">
                            <a href="oprihod.php" target="_blank">
                                <button>Оприходовать</button>
                            </a>
                        </td>
                        <td class="pageHeading" align="right">
                            <a href="/orderSupplier.php?action=plane" target="_blank">
                                <button>Планирование поставщиков</button>
                            </a>
                        </td>
                        <td align="right" width="25%">
                            <table class="table-padding-0">
                                <tr><?php echo tep_draw_form('orders', FILENAME_ORDERS, '', 'get'); ?>
                                    <td class="smallText" align="right"><?php echo HEADING_TITLE_SEARCH . ' ' . tep_draw_input_field('oID', '', 'size="12"') . tep_draw_hidden_field('action', 'edit'); ?></td>
                                    <?php echo tep_hide_session_id(); ?></form>
                                </tr>
                                <tr><?php echo tep_draw_form('status', FILENAME_ORDERS, '', 'get'); ?>
                                    <td class="smallText" align="right"><?php echo HEADING_TITLE_STATUS . ' ' . tep_draw_pull_down_menu('status', array_merge(array(array('id' => '', 'text' => TEXT_ALL_ORDERS)), $orders_statuses), $_GET['status'], 'onChange="this.form.submit();"'); ?></td>
                                    <?php echo tep_hide_session_id(); ?></form>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td class="pageHeading">Фильтр</td>
                        <td class="pageHeading" calign="right">
                            <?php
                            $orders_type = array();
                            $type_query = tep_db_query("SELECT count(*) as count FROM `orders` where orders_status = 20");
                            $result = tep_db_fetch_array($type_query);
                            $orders_type[3] = $result['count'];
                            $type_query = tep_db_query("SELECT count(*) as count FROM `orders` where orders_status = 18");
                            $result = tep_db_fetch_array($type_query);
                            $orders_type[4] = $result['count'];
                            $type_query = tep_db_query("SELECT count(*) as count FROM `orders` where orders_status = 2");
                            $result = tep_db_fetch_array($type_query);
                            $orders_type[5] = $result['count'];
                            $type_query = tep_db_query("SELECT count(*) as count FROM `orders` where orders_status NOT IN  (5,6,16) AND shipping_module=\"percent_percent\"");
                            $result = tep_db_fetch_array($type_query);
                            $orders_type[2] = $result['count'];
                            $type_query = tep_db_query("SELECT count(*) as count FROM `orders` where orders_status NOT IN  (5,6,16) AND shipping_module=\"flat_flat\"");
                            $result = tep_db_fetch_array($type_query);
                            $orders_type[1] = $result['count'];
                            ?>
                            <select onchange="window.location.href =  this.value;">
                                <option <?= $_GET['action'] !== 'filter' ? 'selected' : "" ?> value="<?= tep_href_link(FILENAME_ORDERS) ?>">Все
                                </option>
                                <option <?= $_GET['value'] == '1' ? 'selected' : "" ?> value="<?= tep_href_link(FILENAME_ORDERS, tep_get_all_get_params(array('action')) . '&action=filter&value=1') ?>">
                                    Заказы курьером по МСК: (<?= $orders_type[1] ?>)
                                </option>
                                <option <?= $_GET['value'] == '2' ? 'selected' : "" ?> value="<?= tep_href_link(FILENAME_ORDERS, tep_get_all_get_params(array('action')) . '&action=filter&value=2') ?>">
                                    Самовывозы: (<?= $orders_type[2] ?>)
                                </option>
                                <option <?= $_GET['value'] == '3' ? 'selected' : "" ?> value="<?= tep_href_link(FILENAME_ORDERS, tep_get_all_get_params(array('action')) . '&action=filter&value=3') ?>">
                                    Предоплачены: (<?= $orders_type[3] ?>)
                                </option>
                                <option <?= $_GET['value'] == '4' ? 'selected' : "" ?> value="<?= tep_href_link(FILENAME_ORDERS, tep_get_all_get_params(array('action')) . '&action=filter&value=4') ?>">
                                    Оплачены: (<?= $orders_type[4] ?>)
                                </option>
                                <option <?= $_GET['value'] == '5' ? 'selected' : "" ?> value="<?= tep_href_link(FILENAME_ORDERS, tep_get_all_get_params(array('action')) . '&action=filter&value=5') ?>">
                                    Ждём оплату: (<?= $orders_type[5] ?>)
                                </option>
                            </select>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <table class="table-padding-0">
                    <tr>
                        <td valign="top">
                            <?php
                            echo tep_draw_form('UpdateStatus', FILENAME_ORDERS, tep_get_all_get_params()); ?>
                            <script language="javascript">
                                function checkAll() {
                                    var el = document.getElementsByName('update_oID[]')
                                    for (i = 0; i < el.length; i++) {
                                        el[i].checked = true;
                                    }
                                }

                                function uncheckAll() {
                                    var el = document.getElementsByName('update_oID[]')
                                    for (i = 0; i < el.length; i++) {
                                        el[i].checked = false;
                                    }
                                }
                            </script>
                            <table class="table-padding-2">
                                <?php
                                $HEADING_CUSTOMERS = TABLE_HEADING_CUSTOMERS . '&nbsp;';
                                $HEADING_CUSTOMERS .= '<a href="' . $_SERVER['PHP_SELF'] . '?sort=customer&order=ascending">';
                                $HEADING_CUSTOMERS .= '+</a>';
                                $HEADING_CUSTOMERS .= '<a href="' . $_SERVER['PHP_SELF'] . '?sort=customer&order=decending">';
                                $HEADING_CUSTOMERS .= '-</a>';
                                $HEADING_DATE_PURCHASED = TABLE_HEADING_DATE_PURCHASED . '&nbsp;';
                                $HEADING_DATE_PURCHASED .= '<a href="' . $_SERVER['PHP_SELF'] . '?sort=date&order=ascending">';
                                $HEADING_DATE_PURCHASED .= '+</a>';
                                $HEADING_DATE_PURCHASED .= '<a href="' . $_SERVER['PHP_SELF'] . '?sort=date&order=decending">';
                                $HEADING_DATE_PURCHASED .= '-</a>';
                                $HEADING_ORDER_NUMBER = TABLE_HEADING_ORDER_NUMBER . '&nbsp;';
                                $HEADING_ORDER_NUMBER .= '<a href="' . $_SERVER['PHP_SELF'] . '?sort=orders&order=ascending">';
                                $HEADING_ORDER_NUMBER .= '+</a>';
                                $HEADING_ORDER_NUMBER .= '<a href="' . $_SERVER['PHP_SELF'] . '?sort=orders&order=decending">';
                                $HEADING_ORDER_NUMBER .= '-</a>';
                                ?>
                                <tr class="dataTableHeadingRow">
                                    <td class="dataTableHeadingContent"></td>
                                    <td class="dataTableHeadingContent"><?php echo $HEADING_CUSTOMERS; ?></td>
                                    <td class="dataTableHeadingContent" align="right"><?php echo $HEADING_ORDER_NUMBER; ?></td>
                                    <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_ORDER_TOTAL; ?></td>
                                    <td class="dataTableHeadingContent" align="center"><?php echo $HEADING_DATE_PURCHASED; ?></td>
                                    <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_STATUS; ?></td>
                                    <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_ACTION; ?>&nbsp;
                                    </td>
                                </tr>
                                <?php
                                $sortorder = 'order by ';
                                if ($_GET["sort"] == 'customer') {
                                    if ($_GET["order"] == 'ascending') {
                                        $sortorder .= 'o.customers_name  asc, ';
                                    } else {
                                        $sortorder .= 'o.customers_name desc, ';
                                    }
                                } elseif ($_GET["sort"] == 'date') {
                                    if ($_GET["order"] == 'ascending') {
                                        $sortorder .= 'o.date_purchased  asc, ';
                                    } else {
                                        $sortorder .= 'o.date_purchased desc, ';
                                    }
                                } elseif ($_GET["sort"] == 'orders') {
                                    if ($_GET["order"] == 'ascending') {
                                        $sortorder .= 'o.orders_id  asc, ';
                                    } else {
                                        $sortorder .= 'o.orders_id desc, ';
                                    }
                                }
                                $sortorder .= 'o.orders_id DESC';
                                $filter = '';
                                if (isset($_GET['action']) && isset($_GET['value'])) {
                                    switch ($_GET['value']) {
                                        case '1':
                                            $filter = " AND o.orders_status NOT IN  (5,6,16) AND o.shipping_module=\"flat_flat\" ";
                                            break;
                                        case '2':
                                            $filter = " AND o.orders_status NOT IN  (5,6,16) AND o.shipping_module=\"percent_percent\" ";
                                            break;
                                        case '3':
                                            $filter = " AND o.orders_status = 20 ";
                                            break;
                                        case '4':
                                            $filter = " AND o.orders_status = 18 ";
                                            break;
                                        case '5':
                                            $filter = " AND o.orders_status = 2 ";
                                            break;
                                    }
                                }
                                if (isset($_GET['cID'])) {
                                    $cID = tep_db_prepare_input($_GET['cID']);
                                    $orders_query_raw = "select c.customers_groups_id,o.orders_id, o.customers_name, o.customers_id, o.payment_method, o.date_purchased, o.last_modified, o.currency, o.currency_value, s.orders_status_name, ot.text as order_total from " . TABLE_ORDERS . " o left join " . TABLE_ORDERS_TOTAL . " ot on (o.orders_id = ot.orders_id) " . ' left join customers c on (o.customers_id=c.customers_id), ' . TABLE_ORDERS_STATUS . " s where o.customers_id = '" . (int)$cID . "' and o.orders_status = s.orders_status_id and s.language_id = '" . (int)$languages_id . "' and ot.class = 'ot_total'  " . $filter . " order by orders_id DESC";
                                } elseif (isset($_GET['status']) && is_numeric($_GET['status']) && ($_GET['status'] > 0)) {
                                    $status = tep_db_prepare_input($_GET['status']);
                                    $orders_query_raw = "select c.customers_groups_id, o.orders_id, o.customers_name, o.customers_id, o.payment_method, o.date_purchased, o.last_modified, o.currency, o.currency_value, s.orders_status_name, ot.text as order_total from " . TABLE_ORDERS . " o left join " . TABLE_ORDERS_TOTAL . " ot on (o.orders_id = ot.orders_id) " . ' left join customers c on (o.customers_id=c.customers_id), ' . TABLE_ORDERS_STATUS . " s where o.orders_status = s.orders_status_id and s.language_id = '" . (int)$languages_id . "' and s.orders_status_id = '" . (int)$status . "' and ot.class = 'ot_total' " . $filter . " order by o.orders_id DESC";
                                } else {
                                    $orders_query_raw = "select c.customers_groups_id, o.orders_id, o.customers_name, o.customers_id, o.payment_method, o.date_purchased, o.last_modified, o.currency, o.currency_value, s.orders_status_name, ot.text as order_total from " . TABLE_ORDERS . " o left join " . TABLE_ORDERS_TOTAL . " ot on (o.orders_id = ot.orders_id) " . ' left join customers c on (o.customers_id=c.customers_id), ' . TABLE_ORDERS_STATUS . " s where o.orders_status = s.orders_status_id and s.language_id = '" . (int)$languages_id . "' and ot.class = 'ot_total' " . $filter . $sortorder;
                                }
                                $orders_split = new splitPageResults($_GET['page'], MAX_PROD_ADMIN_SIDE, $orders_query_raw, $orders_query_numrows);
                                $orders_query = tep_db_query($orders_query_raw);
                                while ($orders = tep_db_fetch_array($orders_query)) {
                                    if ((!isset($_GET['oID']) || (isset($_GET['oID']) && ($_GET['oID'] == $orders['orders_id']))) && !isset($oInfo)) {
                                        $oInfo = new objectInfo($orders);
                                    }

                                    // Start Batch Update Status v0.4
                                    if (isset($oInfo) && is_object($oInfo) && ($orders['orders_id'] == $oInfo->orders_id)) {
                                        echo '              <tr id="defaultSelected" class="dataTableRowSelected" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" >' . "\n";
                                        $onclick = 'onclick="document.location.href=\'' . tep_href_link(FILENAME_ORDERS, tep_get_all_get_params(array('oID', 'action')) . 'oID=' . $oInfo->orders_id . '&action=edit') . '\'"';
                                    } else {
                                        echo '              <tr class="dataTableRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" >' . "\n";
                                        $onclick = 'onclick="document.location.href=\'' . tep_href_link(FILENAME_ORDERS, tep_get_all_get_params(array('oID')) . 'oID=' . $orders['orders_id']) . '\'"';
                                    }
                                ?>
                                    <td class="dataTableContent" style="white-space:nowrap;text-align:left;">


                                        <?php
                                        echo '<span style="height:16px;padding:2px;display:block;';
                                        $this_group = $cos_array[$orders['customers_groups_id']];
                                        if (isset($this_group)) {
                                            echo 'color:#' . (inverseHex($this_group['color'])) . ';background-color:#' . $this_group['color'] . '"';
                                        } else {
                                            echo '"';
                                        }
                                        if (isset($this_group)) {
                                            echo ' title="' . $this_group['title'] . '" >';
                                        } else {
                                            echo '>';
                                        }
                                        ?>
                                        <input type="checkbox" name="update_oID[]" value="<?php echo $orders['orders_id']; ?>">
                                        <?php
                                        echo round($this_group['discount']);
                                        ?>
                                        </span>
                                    </td>
                                    <td class="dataTableContent" width="20%"><?php echo '<a href="' . tep_href_link(FILENAME_ORDERS, tep_get_all_get_params(array('oID', 'action')) . 'oID=' . $orders['orders_id'] . '&action=edit') . '">' . tep_image(DIR_WS_ICONS . 'preview.gif', ICON_PREVIEW) . '</a>&nbsp;<a href="' . tep_href_link(FILENAME_ORDERS, tep_get_all_get_params(array('oID', 'action')) . 'oID=' . $orders['orders_id'] . '&action=edit') . '">' . $orders['customers_name'] . '</a>'; ?></td>
                                    <td class="dataTableContent" align="right"><?php echo strip_tags($orders['orders_id']); ?></td>
                                    <td class="dataTableContent" align="right"><?php echo strip_tags($orders['order_total']); ?></td>
                                    <td class="dataTableContent" align="center"><?php echo tep_datetime_short($orders['date_purchased']); ?></td>
                                    <td class="dataTableContent" align="right"><?php if ($orders['orders_status_name'] == "Ожидаем Вашего подтверждения") {
                                                                                    echo "ОВП";
                                                                                } else {
                                                                                    echo $orders['orders_status_name'];
                                                                                }
                                                                                ?></td>
                                    <td class="dataTableContent" align="right"><?php if (isset($oInfo) && is_object($oInfo) && ($orders['orders_id'] == $oInfo->orders_id)) {
                                                                                    echo tep_image(DIR_WS_IMAGES . 'icon_arrow_right.gif', '');
                                                                                } else {
                                                                                    echo '<a href="' . tep_href_link(FILENAME_ORDERS, tep_get_all_get_params(array('oID')) . 'oID=' . $orders['orders_id']) . '">' . tep_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . '</a>';
                                                                                } ?>&nbsp;
                                    </td>
                    </tr>
                <?php
                                }
                ?>
                <?php
                        echo '<tr class="dataTableContent"><td colspan="4">' . BUS_HEADING_TITLE . ': ' . tep_draw_pull_down_menu('new_status', array_merge(array(array('id' => '', 'text' => BUS_TEXT_NEW_STATUS)), $orders_statuses), '', '');
                        echo '</td><td colspan="2">' . tep_draw_checkbox_field('notify', '1', true) . ' ' . BUS_NOTIFY_CUSTOMERS . '</td></tr>';
                        echo '<tr class="dataTableContent" align="left"><td colspan="7" nobr="nobr" align="left">' .
                            BUS_DELETE_ORDERS . ': ' . tep_draw_checkbox_field('delete_orders', '1') . '</td></tr>';
                        echo '<tr class="dataTableContent" align="center"><td colspan="7" nobr="nobr" align="left">' .
                            tep_draw_input_field('select_all', BUS_SELECT_ALL, 'onclick="checkAll(); return false;" class="but_cat2"', '', 'submit') . '&nbsp;' .
                            tep_draw_input_field('select_none', BUS_SELECT_NONE, 'onclick="uncheckAll(); return false;" class="but_cat2"', '', 'submit') . '&nbsp;' .
                            tep_draw_input_field('submit', BUS_SUBMIT, 'class="but_cat"', '', 'submit') . '</td></tr>';
                ?>
                </form>
                <tr>
                    <td colspan="7">
                        <table class="table-padding-2">
                            <tr>
                                <td class="smallText top-valign"><?php echo $orders_split->display_count($orders_query_numrows, MAX_PROD_ADMIN_SIDE, $_GET['page'], TEXT_DISPLAY_NUMBER_OF_ORDERS); ?></td>
                                <td class="smallText" align="right"><?php echo $orders_split->display_links($orders_query_numrows, MAX_PROD_ADMIN_SIDE, MAX_DISPLAY_PAGE_LINKS, $_GET['page'], tep_get_all_get_params(array('page', 'oID', 'action'))); ?></td>
                            </tr>

                        </table>
                    </td>

                </tr>
                </table>
            </td>
            <?php
                        $days = array(1 => 'пн', 'вт', 'ср', 'чт', 'пт', 'сб', 'вс');

                        $heading = array();
                        $contents = array();

                        switch ($action) {
                            case 'delete':
                                $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_DELETE_ORDER . '</b>');

                                $contents = array('form' => tep_draw_form('orders', FILENAME_ORDERS, tep_get_all_get_params(array('oID', 'action')) . 'oID=' . $oInfo->orders_id . '&action=deleteconfirm'));
                                $contents[] = array('text' => TEXT_INFO_DELETE_INTRO . '<br><br>');
                                $contents[] = array('text' => TEXT_INFO_DELETE_DATA . '&nbsp;' . $oInfo->customers_name . '<br>');
                                $contents[] = array('text' => TEXT_INFO_DELETE_DATA_OID . '&nbsp;<b>' . $oInfo->orders_id . '</b><br>');
                                $contents[] = array('text' => '<br>' . tep_draw_checkbox_field('restock') . ' ' . TEXT_INFO_RESTOCK_PRODUCT_QUANTITY);
                                $contents[] = array('align' => 'center', 'text' => '<br>' . tep_image_submit('button_delete.gif', IMAGE_DELETE) . ' <a href="' . tep_href_link(FILENAME_ORDERS, tep_get_all_get_params(array('oID', 'action')) . 'oID=' . $oInfo->orders_id) . '">' . tep_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>');
                                break;


                            default:
                                if (isset($oInfo) && is_object($oInfo)) {
                                    $heading[] = array('text' => '<b>[' . $oInfo->orders_id . ']&nbsp;&nbsp;' . tep_datetime_short($oInfo->date_purchased) . '</b>');

                                    //        $contents[] = array('align' => 'center', 'text' => '<a href="' . tep_href_link(FILENAME_ORDERS, tep_get_all_get_params(array('oID', 'action')) . 'oID=' . $oInfo->orders_id . '&action=edit') . '">' . tep_image_button('button_edit.gif', IMAGE_EDIT) . '</a> <a href="' . tep_href_link(FILENAME_ORDERS, tep_get_all_get_params(array('oID', 'action')) . 'oID=' . $oInfo->orders_id . '&action=delete') . '">' . tep_image_button('button_delete.gif', IMAGE_DELETE) . '</a>');


                                    //        $contents[] = array('text' => '<br>' . TEXT_DATE_ORDER_CREATED . ' ' . tep_date_short($oInfo->date_purchased));


                                    if (tep_not_null($oInfo->last_modified)) $contents[] = array('text' => TEXT_DATE_ORDER_LAST_MODIFIED . ' ' . tep_date_short($oInfo->last_modified));
                                    $contents[] = array('align' => 'center', 'text' => '<a href="' . tep_href_link(FILENAME_ORDERS, tep_get_all_get_params(array('oID', 'action')) . 'oID=' . $oInfo->orders_id . '&action=edit') . '">' . tep_image_button('button_edit.gif', IMAGE_EDIT) . '</a> <a href="' . tep_href_link(FILENAME_ORDERS, tep_get_all_get_params(array('oID', 'action')) . 'oID=' . $oInfo->orders_id . '&action=delete') . '">' . tep_image_button('button_delete.gif', IMAGE_DELETE) . '</a> <a href="' . tep_href_link(FILENAME_EDIT_ORDERS, 'oID=' . $oInfo->orders_id . '&customer_id=' . $oInfo->customers_id) . '">' . tep_image_button('button_update.gif', IMAGE_UPDATE) . '</a>');

                                    $contents[] = array(
                                        'align' => 'center', 'text' => '<a href="' . tep_href_link(FILENAME_ORDERS_INVOICE, 'oID=' . $oInfo->orders_id) . '" TARGET="_blank">' . tep_image_button('button_invoice.gif', IMAGE_ORDERS_INVOICE) . '</a>' .
                                            ($CDEK_INFO['cdek'] ? ' <a href="' . tep_href_link(FILENAME_ORDERS, tep_get_all_get_params(array('action')) . '&action=cdek') . '">' . tep_image_button('sdek.png', CDEK_INVOICE) . '</a>' : '') .
                                            ' <a href="' . tep_href_link(FILENAME_ORDERS_PACKINGSLIP, 'oID=' . $oInfo->orders_id) . '" TARGET="_blank">' . tep_image_button('button_packingslip.gif', IMAGE_ORDERS_PACKINGSLIP) . '</a>' .
                                            ''
                                    );
                                    $contents[] = array('text' => '<br>' . TEXT_DATE_ORDER_CREATED . ' ' . tep_date_short($oInfo->date_purchased));
                                    $contents[] = array('text' => '<br>' . TEXT_INFO_PAYMENT_METHOD . ' ' . $oInfo->payment_method);
                                }
                                break;
                        }

                        if ((tep_not_null($heading)) && (tep_not_null($contents))) {
                            echo '            <td width="25%" valign="top">' . "\n";
                            $orders_date_query_msktoday = tep_db_query("SELECT orders_id, shipping_module FROM `orders` where orders_date_finished=curdate() AND shipping_module='flat_flat' and orders_status NOT IN  (5,6,10,21,4)");
                            $orders_date_query_msktomorrow = tep_db_query("SELECT orders_id, shipping_module FROM `orders` where orders_date_finished=curdate()+1 AND shipping_module='flat_flat' and orders_status NOT IN  (5,6,10,21,4)");
                            $orders_date_query_samtoday = tep_db_query("SELECT orders_id, shipping_module FROM `orders` where orders_date_finished=curdate() AND shipping_module='percent_percent' and orders_status NOT IN  (5,6,10,21,4)");
                            $orders_date_query_samtomorrow = tep_db_query("SELECT orders_id, shipping_module FROM `orders` where orders_date_finished=curdate()+1 AND shipping_module='percent_percent' and orders_status NOT IN  (5,6,10,21,4)");
                            $orders_date_query_senttoday = tep_db_query("SELECT orders_id, shipping_module FROM `orders` where orders_date_finished=curdate() AND shipping_module!='percent_percent' AND shipping_module!='flat_flat' and orders_status NOT IN (5,6,10,21,4,2)");
                            $orders_date_query_senttomorrow = tep_db_query("SELECT orders_id, shipping_module FROM `orders` where orders_date_finished=curdate()+1 AND shipping_module!='percent_percent' AND shipping_module!='flat_flat' and orders_status NOT IN  (5,6,10,21,4,2)");


                            $box = new box;
                            echo $box->infoBox($heading, $contents);

                            echo '    
										<p>СЕГОДНЯ<br></p>
										<p><b>Курьер по МСК</b>:<br>';
                            while ($result_dates = tep_db_fetch_array($orders_date_query_msktoday)) {
                                echo '<a href="' . tep_href_link(FILENAME_ORDERS, tep_get_all_get_params(array('oID', 'action')) . 'oID=' . $result_dates['orders_id'] . '&action=edit') . '" target=_blank style="color:blue; font-size:17px">' . $result_dates['orders_id'] . ' </a>';
                            }

                            echo '					
										<p><b>Самовывозы:<br></b> ';
                            while ($result_dates = tep_db_fetch_array($orders_date_query_samtoday)) {
                                echo '<a href="' . tep_href_link(FILENAME_ORDERS, tep_get_all_get_params(array('oID', 'action')) . 'oID=' . $result_dates['orders_id'] . '&action=edit') . '" target=_blank style="color:blue; font-size:17px">' . $result_dates['orders_id'] . ' </a>';
                            }

                            echo
                            '<p><b>Отгрузки:</b><br> </p>';
                            while ($result_dates = tep_db_fetch_array($orders_date_query_senttoday))
                                echo '<a href="' . tep_href_link(FILENAME_ORDERS, tep_get_all_get_params(array('oID', 'action')) . 'oID=' . $result_dates['orders_id'] . '&action=edit') . '" target=_blank style="color:blue; font-size:17px">' . $result_dates['orders_id'] . ' </a>'; {
                                echo $result_dates['orders_id'] . ' ';
                            }
                            echo '<br>------------------------------';
                            echo '
										
										<p>ЗАВТРА<br></p>
										<p><b>Курьер по МСК:</b></p>';
                            while ($result_dates = tep_db_fetch_array($orders_date_query_msktomorrow)) {
                                echo '<a href="' . tep_href_link(FILENAME_ORDERS, tep_get_all_get_params(array('oID', 'action')) . 'oID=' . $result_dates['orders_id'] . '&action=edit') . '" target=_blank style="color:blue; font-size:17px">' . $result_dates['orders_id'] . ' </a>';
                            }

                            echo
                            '</p><b>Самовывозы:</b><br> ';
                            while ($result_dates = tep_db_fetch_array($orders_date_query_samtomorrow)) {
                                echo '<a href="' . tep_href_link(FILENAME_ORDERS, tep_get_all_get_params(array('oID', 'action')) . 'oID=' . $result_dates['orders_id'] . '&action=edit') . '" target=_blank style="color:blue; font-size:17px">' . $result_dates['orders_id'] . ' </a>';
                            }

                            echo
                            '<p><b>Отгрузки:</b></p>';
                            while ($result_dates = tep_db_fetch_array($orders_date_query_senttomorrow)) {
                                echo '<a href="' . tep_href_link(FILENAME_ORDERS, tep_get_all_get_params(array('oID', 'action')) . 'oID=' . $result_dates['orders_id'] . '&action=edit') . '" target=_blank style="color:blue; font-size:17px">' . $result_dates['orders_id'] . ' </a>';
                            }
                            echo '<br>------------------------------';
                            echo '<p><b>Ближайшие поставщики: </p></b><table border=1  style="border-collapse: collapse;">';
                            $supplier_query = tep_db_query("select s.* from `price_order_relations` as por 
                INNER JOIN `price_order` as po on por.price_id = po.id
                INNER JOIN `products` as p on p.products_id = por.product_id 
                INNER JOIN `supplier` as s on s.supplier_id = p.supplier_id
                INNER JOIN orders as o on o.orders_id = por.order_id and o.orders_status NOT IN (3,4,6)
                WHERE por.act = '1' GROUP by s.supplier_id");
                            while ($supplier = tep_db_fetch_array($supplier_query)) {
                                $plane_query = tep_db_query("select o.orders_date_finished from `price_order_relations` as por 
                INNER JOIN `price_order` as po on por.price_id = po.id
                INNER JOIN `products` as p on p.products_id = por.product_id and p.supplier_id={$supplier['supplier_id']}
                INNER JOIN `supplier` as s on s.supplier_id = p.supplier_id  
                INNER JOIN orders as o on o.orders_id = por.order_id and o.orders_status=11
                WHERE por.act = '1' AND o.orders_date_finished IS NOT NULL  GROUP BY por.order_id ORDER BY por.date LIMIT 1");
                                $plane = tep_db_fetch_array($plane_query);
                                if (!empty($plane['orders_date_finished'])) {
                                    echo '<tr><td>';
                                    echo $supplier['supplier_name'];
                                    echo ' </td><td> ';
                                    echo date($days[date('N', strtotime($plane['orders_date_finished']))] . ', d.m.Y', strtotime($plane['orders_date_finished'])); //date($days[date( 'N' )]. d-m-Y'));
                                    echo '</td>';
                                }
                            }
                            echo '
										</td>' . "\n";
                        }
            ?>
        </tr>
    </table>
    <?php
                        echo '<p><a href="/pochta-file.php"><button>Выгрузить почтовые</button></a></p>';
    ?>

    </td>
    </tr>
<?php

                    }
?>
</table>
</td>
<!-- body_text_eof //-->
</tr>
</table>
<!-- body_eof //-->

<!-- footer //-->
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<!-- footer_eof //-->
<br>
</body>

</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>