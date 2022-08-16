<?php
/*
  $Id: index.php,v 1.1.1.1 2003/09/18 19:04:30 wilt Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/

define('TEXT_MAIN', '&nbsp;');
define('TABLE_HEADING_NEW_PRODUCTS', 'Новинки %s');
define('TABLE_HEADING_UPCOMING_PRODUCTS', 'Ожидается');
define('TABLE_HEADING_DATE_EXPECTED', 'Дата поступления');
define('TABLE_HEADING_DEFAULT_SPECIALS', 'Скидки %s');

if ( ($category_depth == 'products') || (isset($_GET['manufacturers_id'])) ) {
  define('HEADING_TITLE', 'Список товаров');

  define('TABLE_HEADING_IMAGE', '');
  define('TABLE_HEADING_MODEL', 'Код товара');
  define('TABLE_HEADING_PRODUCTS', 'Наименование');
  define('TABLE_HEADING_MANUFACTURER', 'Производитель');
  define('TABLE_HEADING_QUANTITY', 'Количество');
  define('TABLE_HEADING_PRICE', 'Цена');
  define('TABLE_HEADING_WEIGHT', 'Вес');
  define('TABLE_HEADING_BUY_NOW', 'Купить');
  define('TABLE_HEADING_PRODUCT_SORT', 'Порядок');   
  define('TEXT_NO_PRODUCTS', 'Нет ни одного товара в этом разделе.');
  define('TEXT_NO_PRODUCTS2', 'Нет ни одного товара данного производителя.');
  define('TEXT_NUMBER_OF_PRODUCTS', 'Количество товара: ');
  define('TEXT_SHOW', '<b>Смотреть:</b>');
  define('TEXT_BUY', 'Купить \'');
  define('TEXT_NOW', '\' сейчас');
  define('TEXT_ALL_CATEGORIES', 'Все разделы');
  define('TEXT_ALL_MANUFACTURERS', 'Все производители');
} elseif ($category_depth == 'top') {
  define('HEADING_TITLE', 'Добро пожаловать');
} elseif ($category_depth == 'nested') {
  define('HEADING_TITLE', 'Разделы');
}
  define('HEADING_CUSTOMER_GREETING', 'Добро пожаловать');
  define('MAINPAGE_HEADING_TITLE', 'Приветствуем Вас в нашем интернет-магазине');
// BOF: Lango added for Featured Products
  define('TABLE_HEADING_FEATURED_PRODUCTS', 'Рекомендуемые товары');
  define('TABLE_HEADING_FEATURED_PRODUCTS_CATEGORY', 'Рекомендуемые товары раздела %s'); 
// EOF: Lango added for Featured Products

// Start Products Specifications
  define('TEXT_BUTTON_COMPARISON', 'Показать страницу сравнения');
  define('TEXT_LINK_PRODUCTS_COMPARISON', 'Смотреть страницу сравнения');
// End Products Specifications

?>