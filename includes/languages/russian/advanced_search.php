<?php
/*
  $Id: advanced_search.php,v 1.1.1.1 2003/09/18 19:04:28 wilt Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/

define('NAVBAR_TITLE_1', 'Расширенный поиск');
define('NAVBAR_TITLE_2', 'Результаты поиска');

define('HEADING_TITLE_1', 'Расширенный поиск');
define('HEADING_TITLE_2', 'Товары, соответствующие Вашему запросу');

define('HEADING_SEARCH_CRITERIA', 'Поиск товаров');

define('TEXT_SEARCH_IN_DESCRIPTION', 'Искать в описании товаров');
define('ENTRY_CATEGORIES', 'Категории:');
define('ENTRY_INCLUDE_SUBCATEGORIES', 'включая подкатегории');
define('ENTRY_MANUFACTURERS', 'Производители:');
define('ENTRY_PRICE_FROM', 'Цена от:');
define('ENTRY_PRICE_TO', 'до:');
define('ENTRY_DATE_FROM', 'Дата добавления от:');
define('ENTRY_DATE_TO', 'до:');

define('TEXT_SEARCH_HELP_LINK', '<u>Рекомендации по поиску</u> [?]');

define('TEXT_ALL_CATEGORIES', 'Все категории');
define('TEXT_ALL_MANUFACTURERS', 'Все производители');

define('HEADING_SEARCH_HELP', 'Рекомендации по поиску');
define('TEXT_SEARCH_HELP', 'Система поиска позволяет Вам искать продукты, названия, описания и изготовителей по ключевому слову.<br><br>При поиске, Вы можете разделять ключевые слова и фразы предлогами *AND*, *OR*. Например, Вы можете ввести <u>Компьютеры AND аксессуары</u>. В результате будет будут выведены ссылки, содержащие оба слова. Тем не менее, если Вы заносите <u>Компьютеры OR аксессуары</u>, Вы получите список, который содержит оба или одно из слов, заданных в поиске. Если слова не разделяются символами И или ИЛИ, поиск будет работать с определением ИЛИ.<br><br>Вы можете также найти точно заданные слова, заключая их в кавычки. Например, если Вы ищете <u>"Карты памяти"</u>, Вы получите список продуктов, которые содержат эту фразу целиком.<br><br>Скобки могут использоваться, чтобы управлять порядком логических действий. Например, Вы можете ввести <u>Компьютеры (карманные or ноутбуки)</u>.');
define('TEXT_CLOSE_WINDOW', '<u>Закрыть окно</u> [x]');

define('TABLE_HEADING_IMAGE', '');
define('TABLE_HEADING_MODEL', 'Код товара');
define('TABLE_HEADING_PRODUCTS', 'Название');
define('TABLE_HEADING_MANUFACTURER', 'Производитель');
define('TABLE_HEADING_QUANTITY', 'Количество');
define('TABLE_HEADING_PRICE', 'Цена');
define('TABLE_HEADING_WEIGHT', 'Вес');
define('TABLE_HEADING_BUY_NOW', 'Купить сейчас');
define('TABLE_HEADING_PRODUCT_SORT', 'Порядок');


define('TEXT_NO_PRODUCTS', '<br><span style="font-size:11px;">По Вашему запросу - <b>' . stripslashes($_GET['keywords']) . '</b> - ничего не найдено.</span><br><br>Рекомендации по поиску:<ol><li>Проверяйте правильность написания запроса.</li><li>Используйте разные ключевые слова.</li><li>Используйте несколько ключевых слов.</li></ol>');

define('ERROR_AT_LEAST_ONE_INPUT', 'Вы не заполнили одно из необходимых полей формы.');
define('ERROR_INVALID_FROM_DATE', 'Неправильно заполнено поле Дата добавления от.');
define('ERROR_INVALID_TO_DATE', 'Неправильно заполнено поле Дата добавления до.');
define('ERROR_TO_DATE_LESS_THAN_FROM_DATE', 'Значение поля Дата добавления от должно быть больше значения поля Дата добавления до.');
define('ERROR_PRICE_FROM_MUST_BE_NUM', 'Поле Цена от должно содержать только цифры.');
define('ERROR_PRICE_TO_MUST_BE_NUM', 'Поле Цена до должно содержать только цифры.');
define('ERROR_PRICE_TO_LESS_THAN_PRICE_FROM', 'Значение поля Цена от должно быть больше значения поля Цена до.');
define('ERROR_INVALID_KEYWORDS', 'Поисковый запрос составлен неверно.');

define('TEXT_REPLACEMENT_SUGGESTION', 'Также рекомендуем искать: ');

define('TABLE_HEADING_INFO', 'Краткое описание');

?>
