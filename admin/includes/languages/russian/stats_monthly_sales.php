<?php
/*
  $Id: stats_monthly_sales.php,v 1.1 2003/09/28 23:39:22 anotherlango Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2002 osCommerce

  Released under the GNU General Public License
*/

define('HEADING_TITLE', 'Статистика продаж');
define('HEADING_TITLE_STATUS','Статус');
define('HEADING_TITLE_REPORTED','Дата');
define('TEXT_ALL_ORDERS', 'Все заказы');
define('TEXT_NOTHING_FOUND', 'Не было заказов в выбранный период');
define('TEXT_BUTTON_REPORT_PRINT','Версия для печати');
define('TEXT_BUTTON_REPORT_FILE','Файл');
define('TEXT_BUTTON_REPORT_HELP','Помощь');
define('TEXT_BUTTON_REPORT_PRINT_DESC', 'Показать версию для печати');
define('TEXT_BUTTON_REPORT_FILE_DESC', 'Скачать отчёт в формате txt, разделители запятые');
define('TEXT_BUTTON_REPORT_HELP_DESC', 'О данном отчёте');
define('TEXT_REPORT_DATE_FORMAT', 'j M Y -   g:i a'); // date format string
//  as specified in php manual here: http://www.php.net/manual/en/function.date.php
define('TABLE_HEADING_YEAR','Год');
define('TABLE_HEADING_MONTH', 'Месяц');
define('TABLE_HEADING_DAYS', 'День');
define('TABLE_HEADING_INCOME', 'Всего<br>');
define('TABLE_HEADING_SALES', 'Общая стоимость<br> товара');
define('TABLE_HEADING_NONTAXED', 'Стоимость<br> товара');
define('TABLE_HEADING_TAXED', 'Включая<br> налоги');
define('TABLE_HEADING_TAX_COLL', 'Налоги');
define('TABLE_HEADING_SHIPHNDL', 'Доставка');
define('TABLE_HEADING_LOWORDER', 'Низкая<br> стоимость');
define('TABLE_HEADING_OTHER', 'Сертификаты');  // could be any other extra class value
define('TABLE_FOOTER_YTD','Год');
define('TABLE_FOOTER_YEAR','Год');
?>