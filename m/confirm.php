<?php
/*
autocreated script
*/
  require('includes/application_top.php');

  define('CUSTOMER_CONFIRM_STATUS',2);
  $allowed_payment=array('оплата наличными','наложенный платеж');

  $guest_account = false;
  if ($session_started == false) {
    tep_redirect(tep_href_link(FILENAME_COOKIE_USAGE));
  }
//  require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_LOGIN);
  $check_customer_query=tep_db_query('select customers_id, customers_firstname, customers_password, customers_groups_id, customers_email_address, customers_default_address_id, customers_status from ' . TABLE_CUSTOMERS . 
	' where customers_status = 1 and customers_uuid="'.tep_db_input($_GET['uid']).'"');
    if ($check_customer_query!==false){
	    if (tep_db_num_rows($check_customer_query)==0){tep_redirect(tep_href_link(FILENAME_DEFAULT, '', 'SSL'));}
	    }else{tep_redirect(tep_href_link(FILENAME_DEFAULT, '', 'SSL'));}
   $check_customer=tep_db_fetch_array($check_customer_query);
        tep_session_recreate();
        $check_country_query = tep_db_query("select entry_country_id, entry_zone_id from " . TABLE_ADDRESS_BOOK . " where customers_id = '" . (int)$check_customer['customers_id'] . "' and address_book_id = '" . (int)$check_customer['customers_default_address_id'] . "'");
        $check_country = tep_db_fetch_array($check_country_query);
        $customer_id = $check_customer['customers_id'];
        $customer_default_address_id = $check_customer['customers_default_address_id'];
        $customer_first_name = $check_customer['customers_firstname'];
        $customer_country_id = $check_country['entry_country_id'];
        $customer_zone_id = $check_country['entry_zone_id'];
// add for SPPC shipment and payment module start 		
	$sppc_customers_groups_id = $check_customer['customers_groups_id'];
//add for SPPC shipment and payment module end
        tep_session_register('customer_id');
        tep_session_register('customer_default_address_id');
        tep_session_register('customer_first_name');
        tep_session_register('customer_country_id');
        tep_session_register('customer_zone_id');
//add for SPPC shipment and payment module start 		
	tep_session_register('sppc_customers_groups_id');
//add for SPPC shipment and payment module end 	
        tep_db_query("update " . TABLE_CUSTOMERS_INFO . " set customers_info_date_of_last_logon = now(), customers_info_number_of_logons = customers_info_number_of_logons+1 where customers_info_id = '" . (int)$customer_id . "'");
// restore cart contents
        $cart->restore_contents();
// restore wishlist to sesssion
        $wishList->restore_wishlist();

$_GET['order_id']=$_GET['oid'];
$order_id=tep_db_input($_GET['oid']);
if (strlen($_GET['oid']>0)){
    require(DIR_WS_CLASSES . 'order.php');
    $order = new order($_GET['order_id']);
}else{tep_redirect(tep_href_link(FILENAME_ACCOUNT_HISTORY, '', 'SSL'));}
/*echo '<pre>';
var_dump($order);
echo '</pre>';
exit;*/
//----define if payment appropriate
$allowed=false;
foreach($allowed_payment as $akey){
    $allowed=$allowed | preg_match('|'.mb_strtoupper($akey,'utf-8').'|',mb_strtoupper($order->info['payment_method'],'utf-8'));
    }
//----define if payment appropriate
if ($allowed){
    $query=tep_db_query('select orders_status_id from orders_status_history 
	    where orders_id='.$order_id.' order by date_added desc limit 1');
    if ($query!==false){
	$r=tep_db_fetch_array($query);
	if ((int)$r['orders_status_id']!==CUSTOMER_CONFIRM_STATUS){
	    tep_db_query('update '.TABLE_ORDERS.' set orders_status='.CUSTOMER_CONFIRM_STATUS.
    		    ' where orders_id='.$order_id);
	    tep_db_query("INSERT into " . TABLE_ORDERS_STATUS_HISTORY . " 
		(orders_id, orders_status_id, date_added, customer_notified, comments) 
		values ('" . $order_id . "', 
		'" . CUSTOMER_CONFIRM_STATUS . "', 
		now(),1,'" . ''  . "')");
//----display message at top of content
        $messageStack->add('ahi','<font size=+1>Мы уведомим Вас об отправке!</font>','info');
//---send mail to admins
/*-----------------Prepare mail messages for admin----*/
$mail_message='<html><body><h1>Заказ '.$order_id.' подтвержден</h1>
<table cellpadding="0" cellspacing="0" style="border:1px solid black;width:100%">';
for ($i = 0, $n = sizeof($order->products); $i < $n; $i++) {
//---get quantity by iHolder
try{
$qtq=tep_db_query('select products_quantity as cnt from products p
left join products_description pd on (p.products_id=pd.products_id)
where 
pd.products_name="'.mysql_real_escape_string($order->products[$i]['name'],$db_link).'"');
if ($qtq!==false){
    $qres=tep_db_fetch_array($qtq);
    if ((int)$qres['cnt']<9999){$instore=' * ';}else{$instore=' ** ';}
    }
}catch(Exception $e){$instore='';}
//---get quantity by iHolder

    $num = $i +1;
      $mail_message.= '      <tr>' .
           '        <td width="5%" >' . $num . '.</td>' .
           '        <td width="17%" >' . $order->products[$i]['model'] . '</td>'.
           '        <td width="48%" >' . $instore.$order->products[$i]['name'];

      if (sizeof($order->products[$i]['attributes']) > 0) {
        for ($j = 0, $k = sizeof($order->products[$i]['attributes']); $j < $k; $j++) {
          $mail_message.= '<br><nobr><small>&nbsp;<i> - ' . $order->products[$i]['attributes'][$j]['option'] . ': ' . $order->products[$i]['attributes'][$j]['value'];
          $mail_message.= '</i></small></nobr>';
        }
      }

      $mail_message.='<td width="12%" >' . $order->products[$i]['qty'] . ' шт.</td>' . 
           '        <td  width="6%">' . number_format(tep_round(tep_add_tax($order->products[$i]['final_price']*$order->info['currency_value'], $order->products[$i]['tax'], true), $currencies->currencies[$order->info['currency']]['decimal_places']), 2) . '</td>' . 
           '        <td width="9%" >' . number_format(tep_round(tep_add_tax($order->products[$i]['final_price']*$order->info['currency_value']* $order->products[$i]['qty'], $order->products[$i]['tax'], true), $currencies->currencies[$order->info['currency']]['decimal_places']), 2) . '</td>' ;
           '      </tr>';
    }
  for ($i = 0, $n = sizeof($order->totals); $i < $n; $i++) {
    $mail_message.= '<tr>' .
         '<td colspan="5" ><p align="right"><b>' . $order->totals[$i]['title'] . '</b></p></td>'  .
         '<td width="9%" >' . $order->totals[$i]['text'] . '</td>' .
         '</tr>';
  }
$mail_message.='</table><p><span style="display:inline-block;width:30px">*</span>- В наличии<br>
<span style="display:inline-block;width:30px">**</span>- В наличии
</p>';
$mail_message.='<p><table cellpadding="0" cellspacing="0" style="border:1px solid black;width:100%">';
$hq=tep_db_query('SELECT date_format(date_added,"%d.%m.%Y %H:%i") as date_rus,date_added,
    orders_status_name,comments FROM orders_status_history osh
left join orders_status os on (os.orders_status_id=osh.orders_status_id)
where orders_id='.$order_id.' order by date_added');
if ($hq!==false){
    while ($rq=tep_db_fetch_array($hq)){
	$mail_message.='<tr><td>'.$rq['date_rus'].
	    '</td><td>'.$rq['orders_status_name'].
	    '</td><td>';
	    if ((int)$rq['customer_visible']==1){$mail_message.=$rq['comments'];}
	    $mail_message.='</td></tr>';
	}
    }
$mail_message.='</table></p>';

$mail_message.='</body></html>';
/*-----------------Prepare mail messages for admin----*/
/*        tep_mail(STORE_OWNER, STORE_OWNER_EMAIL_ADDRESS,
	'Подтверждение заказа '.$order_id, 'Покупатель подтвердил заказ '.$order_id. "\n".' Ждем оплату', 
	STORE_OWNER, STORE_OWNER_EMAIL_ADDRESS);    */

        tep_mail(STORE_OWNER, STORE_OWNER_EMAIL_ADDRESS,
	'Подтверждение заказа '.$order_id, $mail_message, 
	STORE_OWNER, STORE_OWNER_EMAIL_ADDRESS,true);    

	    }//---do change status
	    else{
	    }
	}//if query ok
    }
    tep_redirect(tep_href_link(FILENAME_ACCOUNT_HISTORY_INFO, 'order_id=' . (int)$_GET['order_id'], 'SSL'));
/*    require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_ACCOUNT_HISTORY_INFO);
    $breadcrumb->add(NAVBAR_TITLE_1, tep_href_link(FILENAME_ACCOUNT, '', 'SSL'));
    $breadcrumb->add(NAVBAR_TITLE_2, tep_href_link(FILENAME_ACCOUNT_HISTORY, '', 'SSL'));
    $breadcrumb->add(sprintf(NAVBAR_TITLE_3, (int)$_GET['order_id']), tep_href_link(FILENAME_ACCOUNT_HISTORY_INFO, 'order_id=' . (int)$_GET['order_id'], 'SSL'));
    $content = CONTENT_ACCOUNT_HISTORY_INFO;
    $javascript = 'popup_window.js';*/
?>
<?php
  require(DIR_WS_INCLUDES . 'template_top.php');
?>
<div class="contentContainer">
    <div class="contentText">

</div>
</div>
<?php
  require(DIR_WS_INCLUDES . 'template_bottom.php');
  require(DIR_WS_INCLUDES . 'application_bottom.php');
?>
