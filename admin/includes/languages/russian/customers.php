<?php
/*
  $Id: customers.php,v 1.2 2003/09/24 13:57:08 wilt Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2002 osCommerce

  Released under the GNU General Public License
*/

define('HEADING_TITLE', 'Клиенты');
define('HEADING_TITLE_SEARCH', 'Поиск:');

//TotalB2B start
define('TABLE_HEADING_CUSTOMERS_STATUS', 'Статус');
define('TABLE_HEADING_CUSTOMERS_GROUP', 'Входит в группу');
define('TABLE_HEADING_CUSTOMERS_DISCOUNT', 'Личная скидка');
define('ENTRY_CUSTOMERS_DISCOUNT', 'Установите персональную скидку данному покупателю:');
define('ENTRY_CUSTOMERS_GROUPS_NAME', 'Либо выберите группу, к которой относится данный покупатель:');

// add for SPPC shipment and payment module start 
define('ENTRY_CUSTOMERS_PAYMENT_SET', 'Установить модули оплаты для покупателя');
define('ENTRY_CUSTOMERS_PAYMENT_DEFAULT', 'Использовать настройки группы или стандартные настройки');
define('ENTRY_CUSTOMERS_PAYMENT_SET_EXPLAIN', 'Если Вы выбираете <b>Установить модули оплаты для покупателя</b>, но не выбираете ни одного модуля, будут действительны настройки группы или стандартные настройки.');
define('ENTRY_CUSTOMERS_PAYMENT_SET_EXPLAIN2', 'Отметье те модули, которые будут <b><font color="red">доступны</font></b> данному покупателю при оформлении заказа.');

define('ENTRY_CUSTOMERS_SHIPPING_SET', 'Установить модули доставки для покупателя');
define('ENTRY_CUSTOMERS_SHIPPING_DEFAULT', 'Использовать настройки группы или стандартные настройки');
define('ENTRY_CUSTOMERS_SHIPPING_SET_EXPLAIN', 'Если Вы выбираете <b>Установить модули доставки для покупателя</b>, но не выбираете ни одного модуля, будут действительны настройки группы или стандартные настройки.');
define('ENTRY_CUSTOMERS_SHIPPING_SET_EXPLAIN2', 'Отметье те модули, которые будут <b><font color="red">доступны</font></b> данному покупателю при оформлении заказа.');
// add for SPPC shipment and payment module end

//TotalB2B end

define('TABLE_HEADING_FIRSTNAME', 'Имя');
define('TABLE_HEADING_LASTNAME', 'Фамилия');
define('TABLE_HEADING_ACCOUNT_CREATED', 'Дата');
define('TABLE_HEADING_ACTION', 'Действие');

define('TEXT_DATE_ACCOUNT_CREATED', 'Дата:');
define('TEXT_DATE_ACCOUNT_LAST_MODIFIED', 'Последнее Изменение:');
define('TEXT_INFO_DATE_LAST_LOGON', 'Последний Вход:');
define('TEXT_INFO_NUMBER_OF_LOGONS', 'Количество Входов:');
define('TEXT_INFO_COUNTRY', 'Страна:');
define('TEXT_INFO_NUMBER_OF_REVIEWS', 'Количество Отзывов:');
define('TEXT_DELETE_INTRO', 'Вы действительно хотите удалить клиента?');
define('TEXT_DELETE_REVIEWS', 'Удалить %s отзыв(ы)');
define('TEXT_INFO_HEADING_DELETE_CUSTOMER', 'Удалить Клиента');
define('TYPE_BELOW', 'Тип Ниже');
define('PLEASE_SELECT', 'Выберите что-то одно');

define('NO_PERSONAL_DISCOUNT', 'Нет');
define('TEXT_PERCENT', '%');
define('TEXT_GROUP', '<br>Скидка: ');
define('TEXT_HELP_HEADING', 'Справка:');
define('TEXT_HELP_TEXT', 'Если будут указаны и персональная скидка и скидка группы, учтите, что обе скидки будут считаться. Например, если выбрана группа Оптовые покупатели, данный покупатель получает скидку -20%, и указана персональная скидка, например, -10%, тогда в итоге покупатель получит общую скидку -30%.');

define('CATEGORY_EXTRA_FIELDS','Дополнительная информация');

?>