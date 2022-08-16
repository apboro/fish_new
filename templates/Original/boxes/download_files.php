<?php
/*
  $Id: download.php,v 1.2 2003/09/24 15:34:26 wilt Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/
?>
<!-- downloads //-->
<?php
  if (!strstr($PHP_SELF, FILENAME_ACCOUNT_HISTORY_INFO)) {
// Get last order id for checkout_success
    $orders_query_raw = "SELECT orders_id FROM " . TABLE_ORDERS . " WHERE customers_id = '" . $customer_id . "' ORDER BY orders_id DESC LIMIT 1";
    $orders_query = tep_db_query($orders_query_raw);
    $orders_values = tep_db_fetch_array($orders_query);
    $last_order = $orders_values['orders_id'];
  } else {
    $last_order = $_GET['order_id'];
  }

// Now get all downloadable products in that order
  $downloads_query_raw = "SELECT DATE_FORMAT(date_purchased, '%Y-%m-%d') as date_purchased_day, op.products_name, opd.orders_products_download_id, opd.orders_products_filename, opd.download_count, opd.download_maxdays, opd.download_pin_code,opd.download_is_pin
                          FROM " . TABLE_ORDERS . " o, " . TABLE_ORDERS_PRODUCTS . " op, " . TABLE_ORDERS_PRODUCTS_DOWNLOAD . " opd
                          WHERE customers_id = '" . (int)$customer_id . "'
                          AND o.orders_id = '" . (int)$last_order . "'
                          AND o.orders_status >= " . DOWNLOADS_CONTROLLER_ORDERS_STATUS . "
                          AND op.orders_id = '" . (int)$last_order . "'
                          AND opd.orders_products_id=op.orders_products_id
                          AND (opd.orders_products_filename != '' or opd.download_is_pin='1')";
  $downloads_query = tep_db_query($downloads_query_raw);

// Don't display if there is no downloadable product
  if (tep_db_num_rows($downloads_query) > 0) {
     require(DIR_WS_LANGUAGES . $language . '/download_files.php');
          ECHO '<tr><td>' ;
          $info_box_contents = array();
/* ORIGINAL 213
          $info_box_contents[] = array('text'  => '<font color="' . $font_color . '">' . BOX_HEADING_DOWNLOAD . '</font>');
*/
/* CDS Patch. 12. BOF */
          $info_box_contents[] = array('text'  => '<a href="' . tep_href_link(FILENAME_DOWNLOAD, '', 'NONSSL') . '"><font color="' . $font_color . '">' . BOX_HEADING_DOWNLOAD . '</font></a>');
/* CDS Patch. 12. EOF */
          new infoBoxHeading($info_box_contents, false, false);

           $info_box_contents = array();
 ?>
<!-- list of products -->
<?php
    while ($downloads_values = tep_db_fetch_array($downloads_query)) {
?>

<!-- left box -->
<?php
// MySQL 3.22 does not have INTERVAL
    	list($dt_year, $dt_month, $dt_day) = explode('-', $downloads_values['date_purchased_day']);
    	$download_timestamp = mktime(23, 59, 59, $dt_month, $dt_day + $downloads_values['download_maxdays'], $dt_year);
  	    $download_expiry = date('Y-m-d H:i:s', $download_timestamp);

//PIN add
if ($downloads_values['download_is_pin']==1) { //PIN processing
	$pinstring=$downloads_values['download_pin_code'];
	echo '<td class="main">'.$downloads_values['products_name'].': </td><td class="main">'.$pinstring.'</td><td class="main">&nbsp;</td>';
} else { //usual stuff

// The link will appear only if:
// - Download remaining count is > 0, AND
// - The file is present in the DOWNLOAD directory, AND EITHER
// - No expiry date is enforced (maxdays == 0), OR
// - The expiry date is not reached
      if (($downloads_values['download_count'] > 0) &&
          (file_exists(DIR_FS_DOWNLOAD . $downloads_values['orders_products_filename'])) &&
          (($downloads_values['download_maxdays'] == 0) ||
           ($download_timestamp > time()))) {

 $info_box_contents = array();
 $info_box_contents[] = array('align' => 'left',
  	                           'text'  => BOX_TEXT_DOWNLOAD . '<br><br><a href="' . tep_href_link(FILENAME_DOWNLOAD, 'order=' . $last_order . '&id=' . $downloads_values['orders_products_download_id']) . '">' . $downloads_values['products_name'] . '</a>&nbsp;-&nbsp;<a href="' . tep_href_link(FILENAME_DOWNLOAD, 'order=' . $last_order . '&id=' . $downloads_values['orders_products_download_id']) . '"><font color="red"><b>' . BOX_TEXT_DOWNLOAD_NOW . '</b></font></a>'
  	                                      );
 new infoBox($info_box_contents);
      } else {
 $info_box_contents = array();
 $info_box_contents[] = array('align' => 'left',
  	                           'text'  => $downloads_values['products_name']
  	                                      );
 new infoBox($info_box_contents);

      }
?>
<!-- right box -->
<?php
 $info_box_contents = array();
 $info_box_contents[] = array('align' => 'left',
  	                           'text'  => TABLE_HEADING_DOWNLOAD_DATE . '<br>' .  tep_date_long($download_expiry)
  	                                      );

  new infoBox($info_box_contents);
  $info_box_contents = array();
  $info_box_contents[] = array('align' => 'left',
	                           'text'  => $downloads_values['download_count'] . '  ' .  TABLE_HEADING_DOWNLOAD_COUNT
	                                      );
  new infoBox($info_box_contents);
 }
 }

if (!strstr($PHP_SELF, FILENAME_ACCOUNT_HISTORY_INFO)) {

  $info_box_contents = array();
  $info_box_contents[] = array('align' => 'left',
	                           'text'  => TEXT_FOOTER_DOWNLOAD . '<br><a href="' . tep_href_link(FILENAME_ACCOUNT_HISTORY, '', 'SSL') . '">' . TEXT_DOWNLOAD_MY_ACCOUNT . '</a>'
	                                      );
  new infoBox($info_box_contents);

   }


?>
     </td>
   </tr>
<?php
  }
?>
<!-- downloads_eof //-->