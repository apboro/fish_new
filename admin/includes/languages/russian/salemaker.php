<?php
/*
  $Id: salemaker.php,v 1.2 2003/09/24 13:57:08 wilt Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2002 osCommerce

  Released under the GNU General Public License
*/

define('HEADING_TITLE', 'Массовые скидки');

define('TABLE_HEADING_SALE_NAME', 'Название акции');
define('TABLE_HEADING_SALE_DEDUCTION', 'Вычет');
define('TABLE_HEADING_SALE_DATE_START', 'Начало действия акции');
define('TABLE_HEADING_SALE_DATE_END', 'Дата окончания');
define('TABLE_HEADING_STATUS', 'Статус');
define('TABLE_HEADING_ACTION', 'Действие');

define('TEXT_SALEMAKER_NAME', 'Название акции:');
define('TEXT_SALEMAKER_DEDUCTION', 'Вычет:');
define('TEXT_SALEMAKER_DEDUCTION_TYPE', '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Тип:&nbsp;&nbsp;');
define('TEXT_SALEMAKER_PRICERANGE_FROM', 'Товары стоимостью от:');
define('TEXT_SALEMAKER_PRICERANGE_TO', '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;до&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;');
define('TEXT_SALEMAKER_SPECIALS_CONDITION', 'Если товар уже находится в скидках:');
define('TEXT_SALEMAKER_DATE_START', 'Начало действия акции:');
define('TEXT_SALEMAKER_DATE_END', 'Дата окончания:');
define('TEXT_SALEMAKER_CATEGORIES', '<b>Или</b> выберите категории, для которых будет действительна данная акция:');
define('TEXT_SALEMAKER_POPUP', '<a href="javascript:session_win();"><span class="errorText"><b>Рекомендации по созданию и использованию массовых скидок.</b></span></a>');
define('TEXT_SALEMAKER_IMMEDIATELY', 'Немедленно');
define('TEXT_SALEMAKER_NEVER', 'Нет ограничения');
define('TEXT_SALEMAKER_ENTIRE_CATALOG', 'Отметьте, если акция действительна для <b>всех</b> товаров магазина:');
define('TEXT_SALEMAKER_TOP', 'Скидка действительна для всех товаров магазина');

define('TEXT_INFO_DATE_ADDED', 'Дата создания:');
define('TEXT_INFO_DATE_MODIFIED', 'Последние изменения:');
define('TEXT_INFO_DATE_STATUS_CHANGE', 'Последний раз статус акции менялся:');
define('TEXT_INFO_SPECIALS_CONDITION', 'Если товар уже в скидках:');
define('TEXT_INFO_DEDUCTION', 'Вычет:');
define('TEXT_INFO_PRICERANGE_FROM', 'Товары стоимостью от:');
define('TEXT_INFO_PRICERANGE_TO', ' до ');
define('TEXT_INFO_DATE_START', 'Начало действия акции:');
define('TEXT_INFO_DATE_END', 'Дата окончания:');

define('SPECIALS_CONDITION_DROPDOWN_0', 'Игнорировать специальную цену и ставить условие массовой скидки');
define('SPECIALS_CONDITION_DROPDOWN_1', 'Игнорировать условие массовой скидки к такому товару');
define('SPECIALS_CONDITION_DROPDOWN_2', 'Добавить условие массовой скидки к специальной цене');

define('DEDUCTION_TYPE_DROPDOWN_0', 'Вычет суммы');
define('DEDUCTION_TYPE_DROPDOWN_1', 'Процент скидки');
define('DEDUCTION_TYPE_DROPDOWN_2', 'Новая цена');

define('TEXT_INFO_HEADING_COPY_SALE', 'Копировать акцию');
define('TEXT_INFO_COPY_INTRO', 'Введите название для копируемой акции<br>&nbsp;&nbsp;"%s"');

define('TEXT_INFO_HEADING_DELETE_SALE', 'Удалить акцию');
define('TEXT_INFO_DELETE_INTRO', 'Вы действительно хотите удалить данную акцию?');
define('TEXT_DISPLAY_NUMBER_OF_SALES', 'Показано <b>%d</b> - <b>%d</b> (всего <b>%d</b> массовых скидок)');

?>