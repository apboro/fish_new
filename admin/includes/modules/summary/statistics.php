<?php
/*
  $Id: statistics.php,v 1.2 2007/09/24 15:18:15 wilt Exp $

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

    <h4><?php echo '<a href="' . tep_href_link(FILENAME_STATS_SALES_REPORT, '', 'NONSSL') . '">' . TEXT_SUMMARY_STAT . '</a>'; ?></h4>
				    
				    </td>
				  </tr>

              <tr>
                <td class="dataTableContentRss" valign="top" width="50%">
<?php
include(DIR_WS_CLASSES . 'ofc-library/open_flash_chart_object.php');
open_flash_chart_object( '100%', 250, tep_href_link('chart_data.php', '', 'NONSSL'), false );
?>
                </td>
                <td class="dataTableContentRss" valign="top" width="45%">
<?php
open_flash_chart_object( '100%', 250, tep_href_link('chart_data.php', 'report_type=orders', 'NONSSL'), false );
?>
                </td>
              </tr>
              				  
              <tr>
                <td width="100%" valign="top" align="left" colspan="2">
<?php                
  $orders_contents = '';
  $orders_status_query = tep_db_query("select orders_status_name, orders_status_id from " . TABLE_ORDERS_STATUS . " where language_id = '" . $languages_id . "'");
  while ($orders_status = tep_db_fetch_array($orders_status_query)) {
    $orders_pending_query = tep_db_query("select count(*) as count from " . TABLE_ORDERS . " where orders_status = '" . $orders_status['orders_status_id'] . "'");
    $orders_pending = tep_db_fetch_array($orders_pending_query);
    $orders_contents .= '<a href="' . tep_href_link(FILENAME_ORDERS, 'selected_box=customers&status=' . $orders_status['orders_status_id']) . '">' . $orders_status['orders_status_name'] . '</a> - ' . $orders_pending['count'] . ' | ';
  }
//  $orders_contents = substr($orders_contents, 0, -4);

  $heading = array();
  $contents = array();

  $heading[] = array('params' => 'class="menuBoxHeading"',
                     'text'  => BOX_TITLE_ORDERS);

  $contents[] = array('params' => 'class="infoBox"',
                      'text'  => $orders_contents);

  $box = new box;
  echo $box->menuBox($heading, $contents);        
?>
                
                </td>
              </tr>

                </table></td>
              </tr>