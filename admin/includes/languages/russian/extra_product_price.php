<?php
/*
  $Id: extra_product_price.php,v 1.0 2005/09/11 15:18:15 wilt Exp $

  for The osCommerce Vam Edition v 1.71
  Last Update: 2005/10/22 12:27:15

  Author: FlyOpenair
  email: flyopenair@mail.ru
  web:   flyopenair.ru

  Released under the GNU General Public License
*/

// BOF FlyOpenair: Extra Product Price

define('HEADING_TITLE', 'Система наценок');

define('TABLE_EXTRA_PRODUCT_PRICE_NAME', 'Название');
define('TABLE_EXTRA_PRODUCT_PRICE_DEDUCTION', 'Наценка');
define('TABLE_EXTRA_PRODUCT_PRICE_HEADING_DEDUCTION_STATUS', 'Статус');
define('TABLE_EXTRA_PRODUCT_PRICE_HEADING_ACTION', 'Действие');



define('TEXT_EXTRA_PRODUCT_PRICE_DEDUCTION_TYPE', '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Тип:&nbsp;&nbsp;');
define('TEXT_EXTRA_PRODUCT_PRICE_PRICERANGE_FROM', 'Товары стоимостью от:');
define('TEXT_EXTRA_PRODUCT_PRICE_PRICERANGE_TO', '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;до&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;');

define('TEXT_EXTRA_PRODUCT_PRICE_CATEGORIES', '<b>Или</b> выберите категории, для которых будет действительна данная наценка:');


define('TEXT_EXTRA_PRODUCT_PRICE_ENTIRE_CATALOG', 'Отметьте, если наценка действительна для <b>всех</b> товаров магазина:');
define('TEXT_EXTRA_PRODUCT_PRICE_TOP', 'Наценка действительна для всех товаров магазина');

define('TEXT_INFO_DATE_ADDED', 'Дата создания:');
define('TEXT_INFO_DATE_MODIFIED', 'Последние изменения:');
define('TEXT_INFO_DEDUCTION', 'Наценка:');
define('TEXT_INFO_PRICERANGE_FROM', 'Товары стоимостью от:');
define('TEXT_INFO_PRICERANGE_TO', ' до ');

define('DEDUCTION_TYPE_DROPDOWN_0', 'Добавка к сумме');
define('DEDUCTION_TYPE_DROPDOWN_1', 'Процент наценки');
define('DEDUCTION_TYPE_DROPDOWN_2', 'Новая цена');

define('TEXT_INFO_HEADING_COPY_SALE', 'Копировать наценку');
define('TEXT_INFO_COPY_INTRO', 'Введите название для копируемой наценки<br>&nbsp;&nbsp;"%s"');

define('TEXT_INFO_HEADING_DELETE_SALE', 'Удалить наценку');
define('TEXT_INFO_DELETE_INTRO', 'Вы действительно хотите удалить данную наценку?');
define('TEXT_DISPLAY_NUMBER_OF_EXTRA_PRODUCT_PRICE', 'Показано <b>%d</b> - <b>%d</b> (всего <b>%d</b> наценок)');
define('IMAGE_NEW_EXTRA_PRODUCT_PRICE', 'Новая наценка');


// EOF FlyOpenair: Extra Product Price

?>