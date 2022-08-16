<?php
/*
  $Id: index.php,v 1.1.1.1 2003/09/18 19:04:30 wilt Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/

define('TEXT_MAIN', '&nbsp;');
define('TABLE_HEADING_NEW_PRODUCTS', 'New Products For %s');
define('TABLE_HEADING_UPCOMING_PRODUCTS', 'Upcoming Products');
define('TABLE_HEADING_DATE_EXPECTED', 'Date Expected');
define('TABLE_HEADING_DEFAULT_SPECIALS', 'Specials For %s');

if ( ($category_depth == 'products') || (isset($_GET['manufacturers_id'])) ) {
  define('HEADING_TITLE', 'Let\'s See What We Have Here');

  define('TABLE_HEADING_IMAGE', '');
  define('TABLE_HEADING_MODEL', 'Model');
  define('TABLE_HEADING_PRODUCTS', 'Product Name');
  define('TABLE_HEADING_MANUFACTURER', 'Manufacturer');
  define('TABLE_HEADING_QUANTITY', 'Quantity');
  define('TABLE_HEADING_PRICE', 'Price');
  define('TABLE_HEADING_WEIGHT', 'Weight');
  define('TABLE_HEADING_BUY_NOW', 'Buy Now');
  define('TABLE_HEADING_PRODUCT_SORT', 'Sort order');   
  define('TEXT_NO_PRODUCTS', 'There are no products to list in this category.');
  define('TEXT_NO_PRODUCTS2', 'There is no product available from this manufacturer.');
  define('TEXT_NUMBER_OF_PRODUCTS', 'Number of Products: ');
  define('TEXT_SHOW', '<b>Show:</b>');
  define('TEXT_BUY', 'Buy 1 \'');
  define('TEXT_NOW', '\' now');
  define('TEXT_ALL_CATEGORIES', 'All Categories');
  define('TEXT_ALL_MANUFACTURERS', 'All Manufacturers');
} elseif ($category_depth == 'top') {
  define('HEADING_TITLE', 'What\'s New Here?');
} elseif ($category_depth == 'nested') {
  define('HEADING_TITLE', 'Categories');
}
  define('HEADING_CUSTOMER_GREETING', 'Our Customer Greeting');
  define('MAINPAGE_HEADING_TITLE', 'Main Page Heading Title');
// BOF: Lango added for Featured Products
  define('TABLE_HEADING_FEATURED_PRODUCTS', 'Featured Products');
  define('TABLE_HEADING_FEATURED_PRODUCTS_CATEGORY', 'Featured Products in %s'); 
// EOF: Lango added for Featured Products

// Start Products Specifications
  define('TEXT_BUTTON_COMPARISON', 'Show the product comparison page');
  define('TEXT_LINK_PRODUCTS_COMPARISON', 'See the product comparison page');
// End Products Specifications

?>