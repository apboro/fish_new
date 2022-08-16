<?php
/*
  $Id: affiliate_application_top.php,v 1.2 2003/09/24 13:57:07 wilt Exp $

  OSC-Affiliate

  Contribution based on:

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2002 - 2003 osCommerce

  Released under the GNU General Public License
*/

// Set the local configuration parameters - mainly for developers
  if (file_exists(DIR_WS_INCLUDES . 'local/affiliate_configure.php')) include(DIR_WS_INCLUDES . 'local/affiliate_configure.php');

  require(DIR_WS_INCLUDES . 'affiliate_configure.php');
  require(DIR_WS_FUNCTIONS . 'affiliate_functions.php');

  define('FILENAME_AFFILIATE', 'affiliate_affiliates.php');
  define('FILENAME_AFFILIATE_BANNERS', 'affiliate_banners.php');
  define('FILENAME_AFFILIATE_BANNER_MANAGER', 'affiliate_banners.php');
  define('FILENAME_AFFILIATE_CLICKS', 'affiliate_clicks.php');
  define('FILENAME_AFFILIATE_CONTACT', 'affiliate_contact.php');
  define('FILENAME_AFFILIATE_HELP_1', 'popup_affiliate_help.php?action=1');
  define('FILENAME_AFFILIATE_HELP_2', 'popup_affiliate_help.php?action=2');
  define('FILENAME_AFFILIATE_HELP_3', 'popup_affiliate_help.php?action=3');
  define('FILENAME_AFFILIATE_HELP_4', 'popup_affiliate_help.php?action=4');
  define('FILENAME_AFFILIATE_HELP_5', 'popup_affiliate_help.php?action=5');
  define('FILENAME_AFFILIATE_HELP_6', 'popup_affiliate_help.php?action=6');
  define('FILENAME_AFFILIATE_HELP_7', 'popup_affiliate_help.php?action=7');
  define('FILENAME_AFFILIATE_HELP_8', 'popup_affiliate_help.php?action=8');
  define('FILENAME_AFFILIATE_INVOICE', 'affiliate_invoice.php');
  define('FILENAME_AFFILIATE_PAYMENT', 'affiliate_payment.php');
  define('FILENAME_AFFILIATE_POPUP_IMAGE', 'affiliate_popup_image.php');
  define('FILENAME_AFFILIATE_SALES', 'affiliate_sales.php');
  define('FILENAME_AFFILIATE_STATISTICS', 'affiliate_statistics.php');
  define('FILENAME_AFFILIATE_SUMMARY', 'affiliate_summary.php');
  define('FILENAME_AFFILIATE_RESET', 'affiliate_reset.php');
  define('FILENAME_CATALOG_AFFILIATE_PAYMENT_INFO','affiliate_payment.php');
  define('FILENAME_CATALOG_PRODUCT_INFO', 'product_info.php');

  define('TABLE_AFFILIATE', 'affiliate_affiliate');
  define('TABLE_AFFILIATE_BANNERS', 'affiliate_banners');
  define('TABLE_AFFILIATE_BANNERS_HISTORY', 'affiliate_banners_history');
  define('TABLE_AFFILIATE_CLICKTHROUGHS', 'affiliate_clickthroughs');
  define('TABLE_AFFILIATE_PAYMENT', 'affiliate_payment');
  define('TABLE_AFFILIATE_PAYMENT_STATUS', 'affiliate_payment_status');
  define('TABLE_AFFILIATE_PAYMENT_STATUS_HISTORY', 'affiliate_payment_status_history');
  define('TABLE_AFFILIATE_SALES', 'affiliate_sales');
  define('TABLE_PRODUCTS_XSELL', 'products_xsell'); //X-Sell

// include the language translations
  require(DIR_WS_LANGUAGES . 'affiliate_' . $language . '.php');

// If an order is deleted delete the sale too (optional)
  if ($_GET['action'] == 'deleteconfirm' && basename($_SERVER['SCRIPT_FILENAME']) == FILENAME_ORDERS && AFFILIATE_DELETE_ORDERS == 'true') {
    $affiliate_oID = tep_db_prepare_input($_GET['oID']);
    tep_db_query("delete from " . TABLE_AFFILIATE_SALES . " where affiliate_orders_id = '" . tep_db_input($affiliate_oID) . "' and affiliate_billing_status != 1");
  }
?>