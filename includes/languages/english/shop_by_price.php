<?php
/*
  $Id: shop_by_price.php,v 1.0 2003/5/26  $

  Contribution by Meltus
  http://www.highbarn-consulting.com

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/

define('NAVBAR_TITLE', 'Shop by Price');
define('HEADING_TITLE', 'Shop by Price');
define('BOX_HEADING_SHOP_BY_PRICE', 'Shop By Price');
define('TABLE_HEADING_IMAGE', '');
define('TABLE_HEADING_PRICE', 'Price');
define('TABLE_HEADING_BUY_NOW', 'Buy Now');
define('TABLE_HEADING_MODEL', 'Model');
define('TABLE_HEADING_PRODUCTS', 'Product Name');
define('TABLE_HEADING_MANUFACTURER', 'Manufacturer');
define('TABLE_HEADING_QUANTITY', 'Quantity');

$price_ranges = Array( 	"Under 100",
						"From 100 to 250",
						"From 250 to 500",
						"From 500 to 1000",
						"1000 and above" );

$price_ranges_sql = Array( 	"p.products_price < 100",
							"(p.products_price <= 250 and p.products_price >= 100)",
							"(p.products_price <= 500 and p.products_price >= 250)",
							"(p.products_price <= 1000 and p.products_price >= 500)",
							"p.products_price >= 1000");

?>