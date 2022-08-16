<?php
/*
  $Id: orders.php,v 1.2 2007/09/24 15:18:15 wilt Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/

?>
          <tr>
            <td valign="top"><table class="table-padding-2">
				  <tr> 
				    <td colspan="5" class="pageHeading" width="100%">

    <h4><?php echo '<a href="' . tep_href_link(FILENAME_ORDERS, '', 'NONSSL') . '">' . TABLE_HEADING_ORDERS . '</a>'; ?></h4>
				    
				    </td>
				  </tr>
              <tr class="dataTableHeadingRow">
                <td width="40%" class="dataTableHeadingContent"><?php echo TABLE_HEADING_CUSTOMER; ?></td>
                <td width="10%" class="dataTableHeadingContent"><?php echo TABLE_HEADING_NUMBER; ?></td>
                <td width="10%" class="dataTableHeadingContent"><?php echo TABLE_HEADING_ORDER_TOTAL; ?></td>
                <td width="20%" class="dataTableHeadingContent"><?php echo TABLE_HEADING_STATUS; ?></td>
                <td width="20%" class="dataTableHeadingContent"><?php echo TABLE_HEADING_DATE; ?></td>
              </tr>

<?php

		$orders_query_raw = "select o.orders_id, o.orders_status, o.customers_name, o.date_purchased, o.last_modified, o.currency, o.currency_value, s.orders_status_name, ot.text as order_total from ".TABLE_ORDERS." o left join ".TABLE_ORDERS_TOTAL." ot on (o.orders_id = ot.orders_id), ".TABLE_ORDERS_STATUS." s where (o.orders_status = s.orders_status_id and s.language_id = '".$_SESSION['languages_id']."' and ot.class = 'ot_total') or (o.orders_status = '0' and ot.class = 'ot_total' and  s.orders_status_id = '1' and s.language_id = '".$_SESSION['languages_id']."') order by o.date_purchased desc limit 20";


	$customers_query_raw = "select
	                                c.customers_id,
	                                c.customers_lastname,
	                                c.customers_firstname,
	                                c.customers_date_added
	                                from
	                                ".TABLE_CUSTOMERS." c order by c.customers_date_added desc limit 5";

	$orders_query = tep_db_query($orders_query_raw);
	while ($orders = tep_db_fetch_array($orders_query)) {


?>
              <tr>
                <td class="dataTableContent"><a href="<?php echo tep_href_link(FILENAME_ORDERS, tep_get_all_get_params(array('oID', 'action')) . 'oID=' . $orders['orders_id'] . '&action=edit'); ?>"><?php echo $orders['customers_name']; ?></a></td>
                <td class="dataTableContent"><?php echo $orders['orders_id']; ?></td>
                <td class="dataTableContent"><?php echo strip_tags($orders['order_total']); ?></td>
                <td class="dataTableContent"><?php echo $orders['orders_status_name']; ?></td>
                <td class="dataTableContent"><?php echo tep_datetime_short($orders['date_purchased']); ?></td>
              </tr>
<?php

	}
?>

                </table></td>
              </tr>