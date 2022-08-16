<?php
/*
  $Id: orders.php,v 1.2 2003/09/24 13:57:08 wilt Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2002 osCommerce

  Released under the GNU General Public License
*/

define('HEADING_TITLE', 'Orders');
define('HEADING_TITLE_SEARCH', 'Order ID:');
define('HEADING_TITLE_STATUS', 'Status:');

define('TABLE_HEADING_COMMENTS', 'Comments');
define('TABLE_HEADING_CUSTOMERS', 'Customers');
define('TABLE_HEADING_ORDER_TOTAL', 'Order Total');
define('TABLE_HEADING_DATE_PURCHASED', 'Date Purchased');
define('TABLE_HEADING_STATUS', 'Status');
define('TABLE_HEADING_ACTION', 'Action');
define('TABLE_HEADING_QUANTITY', 'Qty.');
define('TABLE_HEADING_PRODUCTS_MODEL', 'Model');
define('TABLE_HEADING_PRODUCTS', 'Products');
define('TABLE_HEADING_TAX', 'Tax');
define('TABLE_HEADING_TOTAL', 'Total');
define('TABLE_HEADING_PRICE_EXCLUDING_TAX', 'Price (ex)');
define('TABLE_HEADING_PRICE_INCLUDING_TAX', 'Price (inc)');
define('TABLE_HEADING_TOTAL_EXCLUDING_TAX', 'Total (ex)');
define('TABLE_HEADING_TOTAL_INCLUDING_TAX', 'Total (inc)');

define('TABLE_HEADING_STATUS', 'Status');
define('TABLE_HEADING_DATE_ADDED', 'Date Added');
define('TABLE_HEADING_CUSTOMER_NOTIFIED', 'Customer notified');

define('ENTRY_CUSTOMER', 'Customer:');
define('ENTRY_SOLD_TO', 'SOLD TO:');
define('ENTRY_DELIVERY_TO', 'Delivery To:');
define('ENTRY_SHIP_TO', 'SHIP TO:');
define('ENTRY_SHIPPING_ADDRESS', 'Shipping Address:');
define('ENTRY_BILLING_ADDRESS', 'Billing Address:');
define('ENTRY_PAYMENT_METHOD', 'Payment Method:');
define('ENTRY_CREDIT_CARD_TYPE', 'Credit Card Type:');
define('ENTRY_CREDIT_CARD_OWNER', 'Credit Card Owner:');
define('ENTRY_CREDIT_CARD_NUMBER', 'Credit Card Number:');
define('ENTRY_CREDIT_CARD_EXPIRES', 'Credit Card Expires:');
define('ENTRY_SUB_TOTAL', 'Sub-Total:');
define('ENTRY_TAX', 'Tax:');
define('ENTRY_SHIPPING', 'Shipping:');
define('ENTRY_TOTAL', 'Total:');
define('ENTRY_DATE_PURCHASED', 'Date Purchased:');
define('ENTRY_STATUS', 'Status:');
define('ENTRY_DATE_LAST_UPDATED', 'Date Last Updated:');
define('ENTRY_NOTIFY_CUSTOMER', 'Notify Customer:');
define('ENTRY_NOTIFY_COMMENTS', 'Append Comments:');
define('ENTRY_PRINTABLE', 'Print Invoice');

define('TEXT_INFO_HEADING_DELETE_ORDER', 'Delete Order');
define('TEXT_INFO_DELETE_INTRO', 'Are you sure you want to delete this order?');
define('TEXT_INFO_DELETE_DATA', 'Customers Name  ');
define('TEXT_INFO_DELETE_DATA_OID', 'Order Number  ');
define('TEXT_INFO_RESTOCK_PRODUCT_QUANTITY', 'Restock product quantity');
define('TEXT_DATE_ORDER_CREATED', 'Date Created:');
define('TEXT_DATE_ORDER_LAST_MODIFIED', 'Last Modified:');
define('TEXT_INFO_PAYMENT_METHOD', 'Payment Method:');

define('TEXT_ALL_ORDERS', 'All Orders');
define('TEXT_NO_ORDER_HISTORY', 'No Order History Available');

define('EMAIL_SEPARATOR', '------------------------------------------------------');
define('EMAIL_TEXT_SUBJECT', 'Order Update');
define('EMAIL_TEXT_ORDER_NUMBER', 'Order Number:');
define('EMAIL_TEXT_INVOICE_URL', 'Detailed Invoice:');
define('EMAIL_TEXT_DATE_ORDERED', 'Date Ordered:');
define('EMAIL_TEXT_STATUS_UPDATE', 'Your order has been updated to the following status.' . "\n\n" . 'New status: %s' . "\n\n" . 'Please reply to this email if you have any questions.' . "\n");
define('EMAIL_TEXT_COMMENTS_UPDATE', 'The comments for your order are' . "\n\n%s\n\n");

define('ERROR_ORDER_DOES_NOT_EXIST', 'Error: Order does not exist.');
define('SUCCESS_ORDER_UPDATED', 'Success: Order has been successfully updated.');
define('WARNING_ORDER_NOT_UPDATED', 'Warning: Nothing to change. The order was not updated.');
// denuz
define('TABLE_HEADING_ORDER_NETTO', 'Нетто');
define('TABLE_HEADING_ORDER_NUMBER', 'Order number');
define('TABLE_HEADING_ORDER_MARJA', 'Маржа');
define('TITLE_ORDER_NETTO', 'Нетто:');
define('TITLE_ORDER_MARJA', 'Маржа:');
define('TEXT_TOTAL', 'Total: ');
define('TEXT_NETTO', 'Нетто: ');
define('TEXT_MARJA', 'Маржа: ');
// eof denuz
define('EMAIL_TEXT_CUSTOMER_NAME', 'Customer:');
define('EMAIL_TEXT_CUSTOMER_EMAIL_ADDRESS', 'Email:');
define('EMAIL_TEXT_CUSTOMER_TELEPHONE', 'Phone:');
define('EMAIL_ACC_DISCOUNT_INTRO_OWNER', 'One of your customers reach accumulated discount limit. ' . "\n\n" . 'Details:');
define('EMAIL_TEXT_LIMIT', 'Accumulated discount: ');
define('EMAIL_TEXT_CURRENT_GROUP', 'New group: ');
define('EMAIL_TEXT_DISCOUNT', 'Discount: ');
define('EMAIL_ACC_SUBJECT', 'Accumalated discount');
define('EMAIL_ACC_INTRO_CUSTOMER', 'Congratulations, you have new discount. All details below:');
define('EMAIL_ACC_FOOTER', 'Now you can buy with your new discount rate.');

define('TEXT_REFERER', 'Referer: ');
define('TEXT_ORDER_DELETE', 'Delete orders: ');
define('TEXT_ORDER_DELETE_CONFIRM1', 'Are you sure you want to clear ');
define('TEXT_ORDER_DELETE_CONFIRM2', ' orders?');

define('TEXT_ORDER_SUMMARY','Summary');
define('TEXT_ORDER_PAYMENT','Payment / Shipping');
define('TEXT_ORDER_PRODUCTS','Products');
define('TEXT_ORDER_STATUS','Status');

define('BUS_HEADING_TITLE','Batch Update Status');
define('BUS_TEXT_NEW_STATUS', 'Select New Status');
define('BUS_NOTIFY_CUSTOMERS', 'Notify customer(s)');
define('BUS_SELECT_ALL', 'Select All');
define('BUS_SELECT_NONE', 'Select None');
define('BUS_SUBMIT', 'Update Status');
define('BUS_SUCCESS','Updated!');
define('BUS_WARNING','Not updated!');
define('BUS_DELETE_SUCCESS','Deleted!');
define('BUS_DELETE_WARNING','Not deleted!');
define('BUS_DELETE_ORDERS','Delete selected orders');

define('TEXT_ORDER_MAP','Map');
define('MAP_API_KEY_ERROR','Get your API KEY at <a href=\"http://api.yandex.ru/maps/form.xml\" target=\"_blank\">http://api.yandex.ru/maps/form.xml</a> and set your key in Admin - Configuration - My Store - Yandex Maps API Key. <br /> Error:');

define('ENTRY_SHIPPING_METHOD', 'Shipping method:');

?>