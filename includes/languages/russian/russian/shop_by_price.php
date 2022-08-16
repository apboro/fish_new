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

define('NAVBAR_TITLE', 'Сортировка по цене');
define('HEADING_TITLE', 'Сортировка по цене');
define('BOX_HEADING_SHOP_BY_PRICE', 'Сортировка по цене');
define('TABLE_HEADING_IMAGE', '');
define('TABLE_HEADING_PRICE', 'Цена');
define('TABLE_HEADING_BUY_NOW', 'Купить');
define('TABLE_HEADING_MODEL', 'Код');
define('TABLE_HEADING_PRODUCTS', 'Название');
define('TABLE_HEADING_MANUFACTURER', 'Производитель');
define('TABLE_HEADING_QUANTITY', 'Количество');

$price_ranges = Array( 	"До 100",
						"От 100 до 250",
						"От 250 до 500",
						"От 500 до 1000",
						"От 1000 и выше" );

$price_ranges_sql = Array( 	"p.products_price < 100",
							"(p.products_price <= 250 and p.products_price >= 100)",
							"(p.products_price <= 500 and p.products_price >= 250)",
							"(p.products_price <= 1000 and p.products_price >= 500)",
							"p.products_price >= 1000");

?>