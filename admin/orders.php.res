<?php
/*
  $Id: orders.php,v 1.2 2003/09/24 15:18:15 wilt Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/

  require('includes/application_top.php');

  require(DIR_WS_CLASSES . 'currencies.php');
  $currencies = new currencies();

  //----byIHolder-----
function UpdateOrder($oID,$status,$comments,$notify,$notifyComments){
	global $_POST,$_GET,$orders_status_array,$messageStack,$currencies;

	$customer_visible=1;
//	if (!isset($_POST['customer_visible'])){$customer_visible=0;}
	if (!isset($notifyComments)){$customer_visible=0;}

        $order_updated = false;
        $check_status_query = tep_db_query("select customers_name, customers_email_address, orders_status, date_purchased, customers_id from " . TABLE_ORDERS . " where orders_id = '" . (int)$oID . "'");
        $check_status = tep_db_fetch_array($check_status_query);
// BOF: WebMakers.com Added: Downloads Controller
// always update date and time on order_status
// original        if ( ($check_status['orders_status'] != $status) || tep_not_null($comments)) {
                   if ( ($check_status['orders_status'] != $status) || $comments != '' || ($status ==DOWNLOADS_ORDERS_STATUS_UPDATED_VALUE) ) {
          tep_db_query("update " . TABLE_ORDERS . " set orders_status = '" . tep_db_input($status) . "', last_modified = now() where orders_id = '" . (int)$oID . "'");
        $check_status_query2 = tep_db_query("select customers_name, customers_id, customers_email_address, orders_status, date_purchased from " . TABLE_ORDERS . " where orders_id = '" . (int)$oID . "'");
        $check_status2 = tep_db_fetch_array($check_status_query2);
      if ( $check_status2['orders_status']==DOWNLOADS_ORDERS_STATUS_UPDATED_VALUE ) {
        tep_db_query("update " . TABLE_ORDERS_PRODUCTS_DOWNLOAD . " set download_maxdays = '" . tep_get_configuration_key_value('DOWNLOAD_MAX_DAYS') . "', download_count = '" . tep_get_configuration_key_value('DOWNLOAD_MAX_COUNT') . "' where orders_id = '" . (int)$oID . "'");
      }
// EOF: WebMakers.com Added: Downloads Controller

          $customer_notified = '0';
          if (isset($notify) && ($notify == 'on')) {
            $notify_comments = '';
// BOF: WebMakers.com Added: Downloads Controller - Only tell of comments if there are comments
            if (isset($notifyComments) && ($notifyComments == 'on')) {
              $notify_comments = sprintf(EMAIL_TEXT_COMMENTS_UPDATE, $comments) . "\n\n";
            }
// EOF: WebMakers.com Added: Downloads Controller
            $email = STORE_NAME . "\n" . EMAIL_SEPARATOR . "\n" . EMAIL_TEXT_ORDER_NUMBER . ' ' . $oID . "\n" . EMAIL_TEXT_INVOICE_URL . ' ' . tep_catalog_href_link(FILENAME_CATALOG_ACCOUNT_HISTORY_INFO, 'order_id=' . $oID, 'SSL') . "\n" . EMAIL_TEXT_DATE_ORDERED . ' ' . tep_date_long($check_status['date_purchased']) . "\n\n" . $notify_comments . sprintf(EMAIL_TEXT_STATUS_UPDATE, $orders_status_array[$status]);
            tep_mail($check_status['customers_name'], $check_status['customers_email_address'], EMAIL_TEXT_SUBJECT . ' №' . tep_db_input($oID), nl2br($email), STORE_OWNER, STORE_OWNER_EMAIL_ADDRESS);
            $customer_notified = '1';
          }
          tep_db_query("insert into " . TABLE_ORDERS_STATUS_HISTORY . " (orders_id, orders_status_id, date_added, customer_notified, comments,customer_visible) values ('" . (int)$oID . "', '" . tep_db_input($status) . "', now(), '" . tep_db_input($customer_notified) . "', '" . tep_db_input($comments)  . "',".$customer_visible.")");
          $order_updated = true;
        }

        if ($order_updated == true) {
         $messageStack->add_session(SUCCESS_ORDER_UPDATED, 'success');
        } else {
          $messageStack->add_session(WARNING_ORDER_NOT_UPDATED, 'warning');
        }
      
        // denuz added accumulated discount

      $customer_query = tep_db_query("select c.* from customers as c, orders as o where o.customers_id = c.customers_id and o.orders_id = " . (int)$oID);
      $customer = tep_db_fetch_array($customer_query);
      if (strlen(trim($customer['customers_id']))==0){
    	$messageStack->add_session('Несуществующий клиент заказ №'.(int)$oID, 'warning');
    	return;}


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
              $purchase_query .=");";
                   
              $total_purchase_query = tep_db_query($purchase_query);
              $total_purchase = tep_db_fetch_array($total_purchase_query);
              $customers_total = $total_purchase['total'];

              // looking for current accumulated limit & discount
              $acc_query = tep_db_query("select cg.customers_groups_accumulated_limit, cg.customers_groups_name, cg.customers_groups_discount from customers_groups as cg, customers as c where cg.customers_groups_id = c.customers_groups_id and c.customers_id = " . $customer_id);
              $current_limit = @mysqli_result($acc_query, 0, "customers_groups_accumulated_limit");
              $current_discount = @mysqli_result($acc_query, 0, "customers_groups_discount");
              $current_group = @mysqli_result($acc_query, "customers_groups_name");
                                                                                                                                                                                                 
              // ok, looking for available group
              $groups_query = tep_db_query("select customers_groups_discount, customers_groups_id, customers_groups_name, customers_groups_accumulated_limit from customers_groups where customers_groups_accumulated_limit < " . $customers_total . " and customers_groups_discount < " . $current_discount . " and customers_groups_accumulated_limit > " . $current_limit . " and customers_groups_id = " . $groups['customers_groups_id'] . " order by customers_groups_accumulated_limit DESC");

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
             $text =     EMAIL_TEXT_LIMIT . $currencies->display_price($limit, 0) . "\n" .
                         EMAIL_TEXT_CURRENT_GROUP . $customers_groups_name . "\n" . 
                         EMAIL_TEXT_DISCOUNT . $current_discount . "%"."\n".
                         OTZIV_MARKET; 

             // to store owner
             $email_text = EMAIL_ACC_DISCOUNT_INTRO_OWNER . "\n\n" . 
                           EMAIL_TEXT_CUSTOMER_NAME . ' ' . $customer['customers_firstname'] . ' ' . $customer['customers_lastname']  . "\n" .
                           EMAIL_TEXT_CUSTOMER_EMAIL_ADDRESS . ' ' . $customer['customers_email_address']  . "\n" .
                           EMAIL_TEXT_CUSTOMER_TELEPHONE . ' ' . $customer['customers_telephone'] . "\n\n" . $text;
             tep_mail(STORE_OWNER, STORE_OWNER_EMAIL_ADDRESS, EMAIL_ACC_SUBJECT, $email_text, STORE_OWNER, STORE_OWNER_EMAIL_ADDRESS);
     
             // to customer
             $email_text = EMAIL_ACC_INTRO_CUSTOMER . "\n\n" . 
                           $text . "\n\n" . 
                           EMAIL_ACC_FOOTER;
             tep_mail ($customer['customers_firstname'] . ' ' . $customer['customers_lastname'], $customer['customers_email_address'], EMAIL_ACC_SUBJECT, nl2br($email_text), STORE_OWNER, STORE_OWNER_EMAIL_ADDRESS);
           }
        }
        // eof denuz added accumulated discount


}
function inverseHex( $color ){
     $color       = TRIM($color);
     $prependHash = FALSE;
     $r = DECHEX(255-HEXDEC(mb_SUBSTR($color,0,2,'utf-8')));
     $r = (STRLEN($r)>1)?$r:'0'.$r;
     $g = DECHEX(255-HEXDEC(mb_SUBSTR($color,2,2,'utf-8')));
     $g = (STRLEN($g)>1)?$g:'0'.$g;
     $b = DECHEX(255-HEXDEC(mb_SUBSTR($color,4,2,'utf-8')));
     $b = (STRLEN($b)>1)?$b:'0'.$b;
      RETURN $r.$g.$b;
}
    $cos_array=array();
    $cos_query='select * from customers_groups';
    $cos_qry=tep_db_query($cos_query);
    if (is_object($cos_qry)){
	while ($cos_res=tep_db_fetch_array($cos_qry)){
	    $cos_array[$cos_res['customers_groups_id']]=array('title'=>$cos_res['customers_groups_name'],
					    'discount'=>$cos_res['customers_groups_discount'],
					    'color'=>preg_replace('|#|','',$cos_res['color_bar']));
	    }
	}
//echo '<pre>';var_dump($cos_array);echo '</pre>';
  //----byIHolder-----  

  $orders_statuses = array();
  $orders_status_array = array();
  $orders_status_query = tep_db_query("select orders_status_id, orders_status_name from " . TABLE_ORDERS_STATUS . " where language_id = '" . (int)$languages_id . "'");
  while ($orders_status = tep_db_fetch_array($orders_status_query)) {
    $orders_statuses[] = array('id' => $orders_status['orders_status_id'],
                               'text' => $orders_status['orders_status_name']);
    $orders_status_array[$orders_status['orders_status_id']] = $orders_status['orders_status_name'];
  }

  $action = (isset($_GET['action']) ? $_GET['action'] : '');

// Start Batch Update Status v0.4
if (isset($_POST['submit'])){
 if (($_POST['submit'] == BUS_SUBMIT)&&(isset($_POST['new_status']))&&(!isset($_POST['delete_orders']))){ // Fair enough, let's update ;)
  $status = tep_db_prepare_input($_POST['new_status']);
  if ($status == '') { // New status not selected 
     tep_redirect(tep_href_link(FILENAME_ORDERS),tep_get_all_get_params());
  }
  foreach ($_POST['update_oID'] as $this_orderID){
    $order_updated = false;
    $check_status_query = tep_db_query("select customers_name, customers_email_address, orders_status, date_purchased from " . TABLE_ORDERS . " where orders_id = '" . (int)$this_orderID . "'");
    $check_status = tep_db_fetch_array($check_status_query);
    UpdateOrder($this_orderID,$status,'',$_POST['notify'],'off');
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
 
 if (($_POST['submit'] == BUS_SUBMIT)&&(isset($_POST['delete_orders']))){ 

  foreach ($_POST['update_oID'] as $this_orderID){

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
         $messageStack->add_session(BUS_DELETE_SUCCESS, 'success');
        } else {
          $messageStack->add_session(BUS_DELETE_WARNING, 'warning');
        }
  } // End foreach ID loop
 }

// /delete orders 

   tep_redirect(tep_href_link(FILENAME_ORDERS),tep_get_all_get_params());
}

// End Batch Update Status v0.4

  if (tep_not_null($action)) {
    switch ($action) {
    
      case 'update_order':
        $oID = tep_db_prepare_input($_GET['oID']);
        $status = tep_db_prepare_input($_POST['status']);
        $comments = tep_db_prepare_input($_POST['comments']);
	UpdateOrder($oID,$status,$comments,$_POST['notify'],$_POST['notify_comments']);

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
$the_extra_query= tep_db_query("select * from " . TABLE_ORDERS . " where orders_id = '" . (int)$oID . "'");
$the_extra= tep_db_fetch_array($the_extra_query);
$the_customers_id= $the_extra['customers_id'];
// Look up things in customers
$the_extra_query= tep_db_query("select * from " . TABLE_CUSTOMERS . " where customers_id = '" . $the_customers_id . "'");
$the_extra= tep_db_fetch_array($the_extra_query);
$the_customers_fax= $the_extra['customers_fax'];
// EOF: WebMakers.com Added: Additional info for Orders

  include(DIR_WS_CLASSES . 'order.php');
?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<title><?php echo TITLE; ?></title>
<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
<script language="javascript" src="includes/menu.js"></script>
<script language="javascript" src="includes/general.js"></script>
<script language="javascript"><!--
function popupWindow(url) {
  window.open(url,'popupWindow','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=no,resizable=yes,copyhistory=no,width=650,height=500,screenX=150,screenY=150,top=150,left=150')
}
//--></script>
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
    <td width="<?php echo BOX_WIDTH; ?>" valign="top"><table border="0" width="<?php echo BOX_WIDTH; ?>" cellspacing="1" cellpadding="1" class="columnLeft">
<!-- left_navigation //-->
<?php require(DIR_WS_INCLUDES . 'column_left.php'); ?>
<!-- left_navigation_eof //-->
    </table></td>
<!-- body_text //-->
    <td width="100%" valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
<?php
  if (($action == 'edit') && ($order_exists == true)) {
    $order = new order($oID);
?>
      <tr>
        <td width="100%"><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
            <td class="pageHeading" align="right"><?php echo tep_draw_separator('pixel_trans.gif', 1, HEADING_IMAGE_HEIGHT); ?></td>
            <td class="pageHeading" align="right"><?php echo '<a href="' . tep_href_link(FILENAME_ORDERS, tep_get_all_get_params(array('action'))) . '">' . tep_image_button('button_back.gif', IMAGE_BACK) . '</a>'; ?></td>
<td class="pageHeading" align="right">

<?php echo '<a href="' . tep_href_link(FILENAME_ORDERS, tep_get_all_get_params(array('oID', 'action')) . 'oID=' . $_GET['oID'] . '&action=delete') . '" >' . tep_image_button('button_delete.gif', IMAGE_DELETE) . '</a>'; ?>&nbsp;
<?php
// Modifyed 4 VaM
echo '<a href="' . tep_href_link("edit_orders.php", 
tep_get_all_get_params(array('action'))) . 
'&customer_id='.$the_customers_id.'">' . 
tep_image_button('button_edit.gif', IMAGE_EDIT) . '</a> &nbsp; ';
//end mod for VaM
?>
<?php echo '<a href="' . tep_href_link(FILENAME_ORDERS, tep_get_all_get_params(array('action'))) . '">' . tep_image_button('button_back.gif', IMAGE_BACK) . '</a>'; ?>
</td>
          </tr>
        </table></td>
      </tr>
      
      <tr>
        <td>
<?php
  if (ENABLE_TABS == 'true') { 
?>
		<script type="text/javascript">
			$(function(){
				$('#tabs').tabs({ fx: { opacity: 'toggle', duration: 'fast' } });
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
            <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="2">
              <tr>
                <td class="main" valign="top"><b><?php echo ENTRY_CUSTOMER; ?></b></td>
                <td class="main"><?php echo tep_address_format($order->customer['format_id'], $order->customer, 1, '', '<br>'); ?></td>
              </tr>
              <tr>
                <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '5'); ?></td>
              </tr>
              <?php echo tep_get_extra_fields_order($the_customers_id,$languages_id); ?>
              <tr>
                <td class="main"><b><?php echo ENTRY_TELEPHONE_NUMBER; ?></b></td>
                <td class="main"><?php echo $order->customer['telephone']; ?></td>
              </tr>
               <tr>
                 <td class="main"><b><?php echo ENTRY_FAX_NUMBER; ?></b></td>
                 <td class="main"><?php echo $order->customer['fax']; ?></td>
               </tr>
              <tr>
                <td class="main"><b><?php echo ENTRY_EMAIL_ADDRESS; ?></b></td>
                <td class="main"><?php echo '<a href="mailto:' . $order->customer['email_address'] . '"><u>' . $order->customer['email_address'] . '</u></a>'; ?></td>
              </tr>
		<tr>
		<td class="main"><b><?php echo TEXT_REFERER; ?></b></td>
		<td class="main"><a href="<?php echo $order->info['customers_referer_url'];  ?>" target="_blank"><?php echo $order->info['customers_referer_url']; ?></a></td>
                </tr>

<tr>
<td class="main"><b><?php echo TEXT_INFO_DELETE_DATA_OID; ?></b></td>
<td class="main"><?php  echo tep_db_input($oID); ?></td>
</tr>
<!-- add date/time // -->
<tr>
<td class="main"><b><?php echo EMAIL_TEXT_DATE_ORDERED; ?></b></td>
<td class="main"><?php echo tep_datetime_short($order->info['date_purchased']); ?></td>
</tr>
              
            </table></td>
            <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="2">
              <tr>
                <td class="main" valign="top"><b><?php echo ENTRY_SHIPPING_ADDRESS; ?></b></td>
                <td class="main"><?php echo tep_address_format($order->delivery['format_id'], $order->delivery, 1, '', '<br>'); ?></td>
              </tr>
            </table></td>
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
        <td><table border="0" cellspacing="0" cellpadding="2">
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
            <td class="main"><b><?php echo ENTRY_SHIPPING_METHOD; ?></b></td>
            <td class="main"><?php echo $order_shipping_text; ?></td>
          </tr>
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
        </table></td>
      </tr>
     
</table>

</div>

        <div id="products">

<table border="0" width="93%" cellspacing="0" cellpadding="2">
          <tr class="dataTableHeadingRow">
            <td class="dataTableHeadingContent" colspan="2"><?php echo TABLE_HEADING_PRODUCTS; ?></td>
            <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_PRODUCTS_MODEL; ?></td>
            <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_PRICE_INCLUDING_TAX; ?></td>
            <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_TOTAL_INCLUDING_TAX; ?></td>
          </tr>
<?php
    for ($i=0, $n=sizeof($order->products); $i<$n; $i++) {
      echo '          <tr class="dataTableRow">' . "\n" .
           '            <td class="dataTableContent" valign="top" align="right">' . $order->products[$i]['qty'] . '&nbsp;x</td>' . "\n" .
           '            <td class="dataTableContent" valign="top">' . $order->products[$i]['name'];

      if (isset($order->products[$i]['attributes']) && (sizeof($order->products[$i]['attributes']) > 0)) {
        for ($j = 0, $k = sizeof($order->products[$i]['attributes']); $j < $k; $j++) {
          echo '<br><nobr><small>&nbsp;<i> - ' . $order->products[$i]['attributes'][$j]['option'] . ': ' . $order->products[$i]['attributes'][$j]['value'];
          if ($order->products[$i]['attributes'][$j]['price'] != '0') echo ' (' . $order->products[$i]['attributes'][$j]['prefix'] . $currencies->format($order->products[$i]['attributes'][$j]['price'] * $order->products[$i]['qty'], true, $order->info['currency'], $order->info['currency_value']) . ')';
          echo '</i></small></nobr>';
        }
      }

      echo '            </td>' . "\n" .
           '            <td class="dataTableContent" valign="top">' . $order->products[$i]['model'] . '</td>' . "\n" .
           '            <td class="dataTableContent" align="right" valign="top"><b>' . $currencies->format($order->products[$i]['final_price'], true, $order->info['currency'], $order->info['currency_value']) . '</b></td>' . "\n" .
           '            <td class="dataTableContent" align="right" valign="top"><b>' . $currencies->format(tep_add_tax($order->products[$i]['final_price'], $order->products[$i]['tax'], true) * $order->products[$i]['qty'], true, $order->info['currency'], $order->info['currency_value']) . '</b></td>' . "\n";
      echo '          </tr>' . "\n";
    }
?>
          <tr>
            <td align="right" colspan="5"><table border="0" cellspacing="0" cellpadding="2">
<?php
    for ($i = 0, $n = sizeof($order->totals); $i < $n; $i++) {
      echo '              <tr>' . "\n" .
           '                <td align="right" class="smallText">' . $order->totals[$i]['title'] . '</td>' . "\n" .
           '                <td align="right" class="smallText">' . $order->totals[$i]['text'] . '</td>' . "\n" .
           '              </tr>' . "\n";
    }
?>
            </table></td>
          </tr>
        </table>
      
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
        function apifault (err) {
            // Создание обработчика для события window.onLoad
            // Отображаем сообщение об ошибке в контейнере над картой
            window.onload = function () {
                var errorContainer = document.getElementById("error");
                errorContainer.innerHTML = "<?php echo MAP_API_KEY_ERROR; ?> \"" + err + "\"";
                errorContainer.style.display = "";
            }
            flagApiFault = 1;
        }
        
    </script>
    <script src="http://api-maps.yandex.ru/1.1/index.xml?key=<?php echo MAP_API_KEY; ?>&onerror=apifault" type="text/javascript"></script>
    <script type="text/javascript">

	$(document).ready(function(){
			$("#getmap").click(function() {
			
			
        if (!flagApiFault) {
        // Создает обработчик события window.onLoad
        YMaps.jQuery(function () {
            // Создает экземпляр карты и привязывает его к созданному контейнеру
            var map = new YMaps.Map(YMaps.jQuery("#YMapsID")[0]);

                    map.addControl(new YMaps.TypeControl());
                    map.addControl(new YMaps.ToolBar());
                    map.addControl(new YMaps.Zoom());
                    map.addControl(new YMaps.ScaleLine());
                    
            var geocoder = new YMaps.Geocoder("<?php echo $ship_address; ?>");
            
            map.addOverlay(geocoder);
				
            // По завершению геокодирования инициализируем карту первым результатом
            YMaps.Events.observe(geocoder, geocoder.Events.Load, function (geocoder) {
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
        <td class="main"><table border="1" cellspacing="0" cellpadding="5">
          <tr>
            <td class="smallText" align="center"><b><?php echo TABLE_HEADING_DATE_ADDED; ?></b></td>
            <td class="smallText" align="center"><b><?php echo TABLE_HEADING_CUSTOMER_NOTIFIED; ?></b></td>
            <td class="smallText" align="center"><b><?php echo TABLE_HEADING_CUSTOMER_VISIBLE; ?></b></td> 
            <td class="smallText" align="center"><b><?php echo TABLE_HEADING_STATUS; ?></b></td>
            <td class="smallText" align="center"><b><?php echo TABLE_HEADING_COMMENTS; ?></b></td>
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
    echo         '            <td class="smallText" align="center">';
        if ($orders_history['customer_visible'] == '1') {
          echo tep_image(DIR_WS_ICONS . 'tick.gif', ICON_TICK) . "</td>\n";
        } else {
          echo tep_image(DIR_WS_ICONS . 'cross.gif', ICON_CROSS) . "</td>\n";
        }
        
        echo '            <td class="smallText">' . $orders_status_array[$orders_history['orders_status_id']] . '</td>' . "\n" .
             '            <td class="smallText">' . nl2br(tep_db_output($orders_history['comments'])) . '&nbsp;</td>' . "\n" .
             '          </tr>' . "\n";
      }
    } else {
        echo '          <tr>' . "\n" .
             '            <td class="smallText" colspan="5">' . TEXT_NO_ORDER_HISTORY . '</td>' . "\n" .
             '          </tr>' . "\n";
    }
?>
        </table></td>
      </tr>
      <tr>
        <td class="main"><br><b><?php echo TABLE_HEADING_COMMENTS; ?></b></td>
      </tr>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '1', '5'); ?></td>
      </tr>
      <tr><?php echo tep_draw_form('status', FILENAME_ORDERS, tep_get_all_get_params(array('action')) . 'action=update_order'); ?>
        <td class="main"><?php echo tep_draw_textarea_field('comments', 'soft', '60', '5'); ?></td>
      </tr>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
      <tr>
        <td><table border="0" cellspacing="0" cellpadding="2">
          <tr>
            <td><table border="0" cellspacing="0" cellpadding="2">
              <tr>
                <td class="main"><b><?php echo ENTRY_STATUS; ?></b> <?php echo tep_draw_pull_down_menu('status', $orders_statuses, $order->info['orders_status']); ?></td>
              </tr>
              <tr>
                <td class="main"><b><?php echo ENTRY_NOTIFY_CUSTOMER; ?></b> <?php echo tep_draw_checkbox_field('notify', '', true); ?></td>
                <td class="main"><b><?php echo ENTRY_NOTIFY_COMMENTS; ?></b> 
                <?php echo tep_draw_checkbox_field('notify_comments', '', true); ?>
<!--		<br>
		<b><?php echo TABLE_HEADING_CUSTOMER_VISIBLE; ?></b>
		<?php echo tep_draw_checkbox_field('customer_visible', '', true); ?>
	-->
                </td>
              </tr>
            </table></td>
            <td valign="top"><?php echo tep_image_submit('button_update.gif', IMAGE_UPDATE); ?></td>
          </tr>
        </table></td>
      <?php echo tep_hide_session_id(); ?></form></tr>
      
</table>
      
</div>      
</div>
              <tr>
                <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '5'); ?></td>
              </tr>      
           <tr> 
        <td colspan="2" align="right"><?php echo '<a href="' . tep_href_link(FILENAME_ORDERS_INVOICE, 'oID=' . $_GET['oID']) . '" TARGET="_blank">' . tep_image_button('button_invoice.gif', IMAGE_ORDERS_INVOICE) . '</a>&nbsp;<a href="' . tep_href_link(FILENAME_ORDERS_PACKINGSLIP, 'oID=' . $_GET['oID']) . '" TARGET="_blank">' . tep_image_button('button_packingslip.gif', IMAGE_ORDERS_PACKINGSLIP) . '</a>&nbsp;<a href="' . tep_href_link(FILENAME_ORDERS, tep_get_all_get_params(array('action'))) . '">' . tep_image_button('button_back.gif', IMAGE_BACK) . '</a>'; ?></td>
     </tr> 
<?php
  } else {
?>
      <tr>
        <td width="100%"><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
            <td class="pageHeading" align="right"><?php echo tep_draw_separator('pixel_trans.gif', 1, HEADING_IMAGE_HEIGHT); ?></td>
            <td align="right" width="25%"><table border="0" width="100%" cellspacing="0" cellpadding="0">
              <tr><?php echo tep_draw_form('orders', FILENAME_ORDERS, '', 'get'); ?>
                <td class="smallText" align="right"><?php echo HEADING_TITLE_SEARCH . ' ' . tep_draw_input_field('oID', '', 'size="12"') . tep_draw_hidden_field('action', 'edit'); ?></td>
              <?php echo tep_hide_session_id(); ?></form></tr>
              <tr><?php echo tep_draw_form('status', FILENAME_ORDERS, '', 'get'); ?>
                <td class="smallText" align="right"><?php echo HEADING_TITLE_STATUS . ' ' . tep_draw_pull_down_menu('status', array_merge(array(array('id' => '', 'text' => TEXT_ALL_ORDERS)), $orders_statuses), $_GET['status'], 'onChange="this.form.submit();"'); ?></td>
              <?php echo tep_hide_session_id(); ?></form></tr>            
            </table></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top">
<?php 
echo tep_draw_form('UpdateStatus', FILENAME_ORDERS,tep_get_all_get_params()); ?>
<script language="javascript">
function checkAll(){
  var el = document.getElementsByName('update_oID[]')
  for(i=0;i<el.length;i++){
    el[i].checked = true;
  }
}
function uncheckAll(){
  var el = document.getElementsByName('update_oID[]')
  for(i=0;i<el.length;i++){
    el[i].checked = false;
  }
}

</script>            
            <table border="0" width="100%" cellspacing="0" cellpadding="2">
<?php
  $HEADING_CUSTOMERS = TABLE_HEADING_CUSTOMERS .'&nbsp;';
  $HEADING_CUSTOMERS .= '<a href="' . $_SERVER['PHP_SELF'] . '?sort=customer&order=ascending">';
  $HEADING_CUSTOMERS .= '+</a>';
  $HEADING_CUSTOMERS .= '<a href="' . $_SERVER['PHP_SELF'] . '?sort=customer&order=decending">';
  $HEADING_CUSTOMERS .= '-</a>';
  $HEADING_DATE_PURCHASED = TABLE_HEADING_DATE_PURCHASED .'&nbsp;';
  $HEADING_DATE_PURCHASED .= '<a href="' . $_SERVER['PHP_SELF'] . '?sort=date&order=ascending">';
  $HEADING_DATE_PURCHASED .= '+</a>';
  $HEADING_DATE_PURCHASED .= '<a href="' . $_SERVER['PHP_SELF'] . '?sort=date&order=decending">';
  $HEADING_DATE_PURCHASED .= '-</a>';
  $HEADING_ORDER_NUMBER = TABLE_HEADING_ORDER_NUMBER .'&nbsp;';
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
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_ACTION; ?>&nbsp;</td>
              </tr>
<?php
    $sortorder = 'order by ';
    if($_GET["sort"] == 'customer') {
      if($_GET["order"] == 'ascending') {
        $sortorder .= 'o.customers_name  asc, ';
      } else {
        $sortorder .= 'o.customers_name desc, ';
      }
    } elseif($_GET["sort"] == 'date') {
      if($_GET["order"] == 'ascending') {
        $sortorder .= 'o.date_purchased  asc, ';
      } else {
        $sortorder .= 'o.date_purchased desc, ';
      }
    } elseif($_GET["sort"] == 'orders') {
      if($_GET["order"] == 'ascending') {
        $sortorder .= 'o.orders_id  asc, ';
      } else {
        $sortorder .= 'o.orders_id desc, ';
      }
     }
    $sortorder .= 'o.orders_id DESC';
    if (isset($_GET['cID'])) {
      $cID = tep_db_prepare_input($_GET['cID']);
      $orders_query_raw = "select c.customers_groups_id,o.orders_id, o.customers_name, o.customers_id, o.payment_method, o.date_purchased, o.last_modified, o.currency, o.currency_value, s.orders_status_name, ot.text as order_total from " . TABLE_ORDERS . " o left join " . TABLE_ORDERS_TOTAL . " ot on (o.orders_id = ot.orders_id) ".' left join customers c on (o.customers_id=c.customers_id), ' . TABLE_ORDERS_STATUS . " s where o.customers_id = '" . (int)$cID . "' and o.orders_status = s.orders_status_id and s.language_id = '" . (int)$languages_id . "' and ot.class = 'ot_total' order by orders_id DESC";
    } elseif (isset($_GET['status']) && is_numeric($_GET['status']) && ($_GET['status'] > 0)) {
      $status = tep_db_prepare_input($_GET['status']);
      $orders_query_raw = "select c.customers_groups_id, o.orders_id, o.customers_name, o.customers_id, o.payment_method, o.date_purchased, o.last_modified, o.currency, o.currency_value, s.orders_status_name, ot.text as order_total from " . TABLE_ORDERS . " o left join " . TABLE_ORDERS_TOTAL . " ot on (o.orders_id = ot.orders_id) " .' left join customers c on (o.customers_id=c.customers_id), '. TABLE_ORDERS_STATUS . " s where o.orders_status = s.orders_status_id and s.language_id = '" . (int)$languages_id . "' and s.orders_status_id = '" . (int)$status . "' and ot.class = 'ot_total' order by o.orders_id DESC";
    } else {
      $orders_query_raw = "select c.customers_groups_id, o.orders_id, o.customers_name, o.customers_id, o.payment_method, o.date_purchased, o.last_modified, o.currency, o.currency_value, s.orders_status_name, ot.text as order_total from " . TABLE_ORDERS . " o left join " . TABLE_ORDERS_TOTAL . " ot on (o.orders_id = ot.orders_id) ".' left join customers c on (o.customers_id=c.customers_id), ' . TABLE_ORDERS_STATUS . " s where o.orders_status = s.orders_status_id and s.language_id = '" . (int)$languages_id . "' and ot.class = 'ot_total' " . $sortorder;
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

                <span style="height:16px;padding:2px;display:block;
                <?php
                $this_group=$cos_array[$orders['customers_groups_id']];
            	 if (isset($this_group)){
            	 echo 'color:#'.(inverseHex($this_group['color'])).';background-color:#'.$this_group['color'].'"';
            	 }else{echo '"';}
            	 if (isset($this_group)){
            	    echo ' title="'.$this_group['title'].'" >';
            	    }else{echo '>';}
		?>
		<input type="checkbox" name="update_oID[]" value="<?php echo $orders['orders_id'];?>">
		<?php            	    
		 echo $this_group['discount'];
		 ?>
            	</span></td>
                <td class="dataTableContent"><?php echo '<a href="' . tep_href_link(FILENAME_ORDERS, tep_get_all_get_params(array('oID', 'action')) . 'oID=' . $orders['orders_id'] . '&action=edit') . '">' . tep_image(DIR_WS_ICONS . 'preview.gif', ICON_PREVIEW) . '</a>&nbsp;<a href="' . tep_href_link(FILENAME_ORDERS, tep_get_all_get_params(array('oID', 'action')) . 'oID=' . $orders['orders_id']) . '">' . $orders['customers_name'] . '</a>'; ?></td>
                <td class="dataTableContent" align="right"><?php echo strip_tags($orders['orders_id']); ?></td>
                <td class="dataTableContent" align="right"><?php echo strip_tags($orders['order_total']); ?></td>
                <td class="dataTableContent" align="center"><?php echo tep_datetime_short($orders['date_purchased']); ?></td>
                <td class="dataTableContent" align="right"><?php echo $orders['orders_status_name']; ?></td>
                <td class="dataTableContent" align="right"><?php if (isset($oInfo) && is_object($oInfo) && ($orders['orders_id'] == $oInfo->orders_id)) { echo tep_image(DIR_WS_IMAGES . 'icon_arrow_right.gif', ''); } else { echo '<a href="' . tep_href_link(FILENAME_ORDERS, tep_get_all_get_params(array('oID')) . 'oID=' . $orders['orders_id']) . '">' . tep_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . '</a>'; } ?>&nbsp;</td>
              </tr>
<?php
    }
?>
<?php
echo '<tr class="dataTableContent"><td colspan="4">' . BUS_HEADING_TITLE . ': ' . tep_draw_pull_down_menu('new_status', array_merge(array(array('id' => '', 'text' => BUS_TEXT_NEW_STATUS)), $orders_statuses), '', '');
echo '</td><td colspan="2">' . tep_draw_checkbox_field('notify','1',true) . ' ' . BUS_NOTIFY_CUSTOMERS . '</td></tr>';
echo '<tr class="dataTableContent" align="left"><td colspan="7" nobr="nobr" align="left">' .
BUS_DELETE_ORDERS . ': ' . tep_draw_checkbox_field('delete_orders','1') . '</td></tr>';
echo '<tr class="dataTableContent" align="center"><td colspan="7" nobr="nobr" align="left">' .
     tep_draw_input_field('select_all',BUS_SELECT_ALL,'onclick="checkAll(); return false;" class="but_cat2"','','submit') . '&nbsp;' . 
     tep_draw_input_field('select_none',BUS_SELECT_NONE,'onclick="uncheckAll(); return false;" class="but_cat2"','','submit') . '&nbsp;' . 
     tep_draw_input_field('submit',BUS_SUBMIT,'class="but_cat"','','submit') . '</td></tr>';
?>
</form>
              <tr>
                <td colspan="7"><table border="0" width="100%" cellspacing="0" cellpadding="2">
                  <tr>
                    <td class="smallText" valign="top"><?php echo $orders_split->display_count($orders_query_numrows, MAX_PROD_ADMIN_SIDE, $_GET['page'], TEXT_DISPLAY_NUMBER_OF_ORDERS); ?></td>
                    <td class="smallText" align="right"><?php echo $orders_split->display_links($orders_query_numrows, MAX_PROD_ADMIN_SIDE, MAX_DISPLAY_PAGE_LINKS, $_GET['page'], tep_get_all_get_params(array('page', 'oID', 'action'))); ?></td>
                  </tr>

                </table></td>
                
              </tr>
            </table></td>
<?php
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
     $contents[] = array('align' => 'center', 'text' => '<a href="' . tep_href_link(FILENAME_ORDERS, tep_get_all_get_params(array('oID', 'action')) . 'oID=' . $oInfo->orders_id . '&action=edit') . '">' . tep_image_button('button_edit.gif', IMAGE_EDIT) . '</a> <a href="' . tep_href_link(FILENAME_ORDERS, tep_get_all_get_params(array('oID', 'action')) . 'oID=' . $oInfo->orders_id . '&action=delete') . '">' . tep_image_button('button_delete.gif', IMAGE_DELETE) . '</a> <a href="' . tep_href_link(FILENAME_EDIT_ORDERS, 'oID=' . $oInfo->orders_id . '&customer_id='.$oInfo->customers_id). '">' . tep_image_button('button_update.gif', IMAGE_UPDATE) . '</a>');
 
     $contents[] = array('align' => 'center', 'text' => '<a href="' . tep_href_link(FILENAME_ORDERS_INVOICE, 'oID=' . $oInfo->orders_id) . '" TARGET="_blank">' . tep_image_button('button_invoice.gif', IMAGE_ORDERS_INVOICE) . '</a> <a href="' . tep_href_link(FILENAME_ORDERS_PACKINGSLIP, 'oID=' . $oInfo->orders_id) . '" TARGET="_blank">' . tep_image_button('button_packingslip.gif', IMAGE_ORDERS_PACKINGSLIP) . '</a>'); 
     $contents[] = array('text' => '<br>' . TEXT_DATE_ORDER_CREATED . ' ' . tep_date_short($oInfo->date_purchased));
        $contents[] = array('text' => '<br>' . TEXT_INFO_PAYMENT_METHOD . ' '  . $oInfo->payment_method);

      }
      break;
  }

  if ( (tep_not_null($heading)) && (tep_not_null($contents)) ) {
    echo '            <td width="25%" valign="top">' . "\n";

    $box = new box;
    echo $box->infoBox($heading, $contents);

    echo '            </td>' . "\n";
  }
?>
          </tr>
        </table></td>
      </tr>
<?php
  }
?>
    </table></td>
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
