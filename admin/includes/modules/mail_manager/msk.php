<?php
/*
  $Id: all accounts.php 1739 2007-12-20 00:52:16Z hpdl $
  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com
  Copyright (c) 2002 osCommerce
  Released under the GNU General Public License
*/

switch ($action){
    case 'send';
        //count the target group
        $count_query = tep_db_query("select count(*) as count from " . TABLE_CUSTOMERS . " where mmstatus = '0' and customers_id IN (
                SELECT customers_id FROM  orders 
                 WHERE   shipping_module='percent_percent' or  shipping_module='flat_flat'
                 Group by customers_id
            )");
        $count = tep_db_fetch_array($count_query);
        break;

    case 'confirm_send';
        //count the target group (number to be mailed)
        $queue_query = tep_db_query("select count(*) as count from " . TABLE_CUSTOMERS . " where mmstatus = '0' and customers_id IN (
                SELECT customers_id FROM  orders 
                 WHERE   shipping_module='percent_percent' or  shipping_module='flat_flat'
                 Group by customers_id
            )");
        $queue = tep_db_fetch_array($queue_query);

        //count how many have been mailed
        $mailed_query = tep_db_query("select count(*) as count from " . TABLE_CUSTOMERS . " where mmstatus = '9' and customers_id IN (
                SELECT customers_id FROM  orders 
                 WHERE   shipping_module='percent_percent' or  shipping_module='flat_flat'
                 Group by customers_id
            )");
        $mailed = tep_db_fetch_array($mailed_query);

        //get the target group
        $mail_query = tep_db_query("select customers_firstname, customers_lastname, customers_email_address, customers_newsletter, mmstatus,customers_uuid,customers_id from " . TABLE_CUSTOMERS . " where  mmstatus = '0' and customers_id IN (
                SELECT customers_id FROM  orders 
                 WHERE   shipping_module='percent_percent' or  shipping_module='flat_flat'
                 Group by customers_id
            )");
        $mail = tep_db_fetch_array($mail_query);
        break;
}

?>