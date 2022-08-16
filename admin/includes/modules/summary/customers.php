<?php
/*
  $Id: customers.php,v 1.2 2007/09/24 15:18:15 wilt Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/

?>
          <tr>
            <td valign="top"><table class="table-padding-2">
				  <tr> 
				    <td colspan="3" class="pageHeading" width="100%">

    <h4><?php echo '<a href="' . tep_href_link(FILENAME_CUSTOMERS, '', 'NONSSL') . '">' . TABLE_HEADING_CUSTOMERS . '</a>'; ?></h4>
				    
				    </td>
				  </tr>
              <tr class="dataTableHeadingRow">
                <td width="33%" class="dataTableHeadingContent"><?php echo TABLE_HEADING_LASTNAME; ?></td>
                <td width="33%" class="dataTableHeadingContent"><?php echo TABLE_HEADING_FIRSTNAME; ?></td>
                <td width="33%" class="dataTableHeadingContent"><?php echo TABLE_HEADING_DATE; ?></td>
              </tr>

<?php
  $customers_query_raw = "select c.customers_id, c.customers_lastname, c.customers_firstname, ci.customers_info_date_account_created from " . TABLE_CUSTOMERS . " c left join " . TABLE_CUSTOMERS_INFO . " ci on (ci.customers_info_id = c.customers_id) order by ci.customers_info_date_account_created desc limit 20"; 
    
	$customers_query = tep_db_query($customers_query_raw);
	while ($customers = tep_db_fetch_array($customers_query)) {


?>
              <tr>
                <td class="dataTableContent"><a href="<?php echo tep_href_link(FILENAME_CUSTOMERS, tep_get_all_get_params(array ('cID')).'cID='.$customers['customers_id'].'&action=edit'); ?>"><?php echo $customers['customers_lastname']; ?></a></td>
                <td class="dataTableContent"><a href="<?php echo tep_href_link(FILENAME_CUSTOMERS, tep_get_all_get_params(array ('cID')).'cID='.$customers['customers_id'].'&action=edit'); ?>"><?php echo $customers['customers_firstname']; ?></a></td>
                <td class="dataTableContent"><a href="<?php echo tep_href_link(FILENAME_CUSTOMERS, tep_get_all_get_params(array ('cID')).'cID='.$customers['customers_id'].'&action=edit'); ?>"><?php echo $customers['customers_info_date_account_created']; ?></a></td>
              </tr>
<?php

	}
?>

                </table></td>
              </tr>