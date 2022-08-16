<?php
/*
  $Id: links.php,v 1.00 2003/10/02 Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2002 osCommerce

  Released under the GNU General Public License
*/

define('HEADING_TITLE', 'Ссылки');
define('HEADING_TITLE_SEARCH', 'Поиск:');

define('TABLE_HEADING_TITLE', 'Название');
define('TABLE_HEADING_URL', 'URL адрес');
define('TABLE_HEADING_CLICKS', 'Клики');
define('TABLE_HEADING_STATUS', 'Статус');
define('TABLE_HEADING_ACTION', 'Действие');

define('TEXT_INFO_HEADING_DELETE_LINK', 'Удалить ссылку');
define('TEXT_INFO_HEADING_CHECK_LINK', 'Проверить ссылку');

define('TEXT_DELETE_INTRO', 'Вы действительно хотите удалить эту ссылку?');

define('TEXT_INFO_LINK_CHECK_RESULT', 'Результат проверки:');
define('TEXT_INFO_LINK_CHECK_FOUND', 'Ссылка верная');
define('TEXT_INFO_LINK_CHECK_NOT_FOUND', 'Ссылка отсутствует');
define('TEXT_INFO_LINK_CHECK_ERROR', 'Ошибка чтения URL адреса');


define('TEXT_INFO_LINK_STATUS', 'Статус:');
define('TEXT_INFO_LINK_CATEGORY', 'Раздел:');
define('TEXT_INFO_LINK_CONTACT_NAME', 'Имя:');
define('TEXT_INFO_LINK_CONTACT_EMAIL', 'Email:');
define('TEXT_INFO_LINK_CLICK_COUNT', 'Клики:');
define('TEXT_INFO_LINK_DESCRIPTION', 'Описание:');
define('TEXT_DATE_LINK_CREATED', 'Дата добавления:');
define('TEXT_DATE_LINK_LAST_MODIFIED', 'Последние изменения:');
define('TEXT_IMAGE_NONEXISTENT', 'КАРТИНКА ОТСУТСТВУЕТ');

define('EMAIL_SEPARATOR', '------------------------------------------------------');
define('EMAIL_TEXT_SUBJECT', 'Статус ссылки изменён!');
define('EMAIL_TEXT_STATUS_UPDATE', 'Уважаемый(ая) %s,' . "\n\n" . 'Статус Вашей ссылки в ' . STORE_NAME . ' изменён.' . "\n\n" . 'Новый статус: %s' . "\n\n" . 'Если у Вас возникли вопросы, задайте нам их в ответном письме.' . "\n");

// VJ todo - move to common language file
define('CATEGORY_WEBSITE', 'Информация о сайте');
define('CATEGORY_RECIPROCAL', 'Страница, где размещена ссылка нашего магазина');
define('CATEGORY_OPTIONS', 'Опции');

define('ENTRY_LINKS_TITLE', 'Название сайта:');
define('ENTRY_LINKS_TITLE_ERROR', 'Поле Название сайта должно содержать как минимум ' . ENTRY_LINKS_TITLE_MIN_LENGTH . ' символов.');
define('ENTRY_LINKS_URL', 'URL адрес:');
define('ENTRY_LINKS_URL_ERROR', 'Поле URL адрес должно содержать как минимум ' . ENTRY_LINKS_URL_MIN_LENGTH . ' символов.');
define('ENTRY_LINKS_CATEGORY', 'Раздел:');
define('ENTRY_LINKS_DESCRIPTION', 'Описание:');
define('ENTRY_LINKS_DESCRIPTION_ERROR', 'Поле Описание должно содержать как минимум ' . ENTRY_LINKS_DESCRIPTION_MIN_LENGTH . ' символов.');
define('ENTRY_LINKS_IMAGE', 'URL баннера:');
define('ENTRY_LINKS_CONTACT_NAME', 'Имя:');
define('ENTRY_LINKS_CONTACT_NAME_ERROR', 'Поле Имя должно содержать как минимум ' . ENTRY_LINKS_CONTACT_NAME_MIN_LENGTH . ' символов.');
define('ENTRY_LINKS_RECIPROCAL_URL', 'Адрес страницы, где размещена ссылка на наш магазин:');
define('ENTRY_LINKS_RECIPROCAL_URL_ERROR', 'Поле Адрес страницы, где размещена ссылка на наш магазин должно содержать как минимум ' . ENTRY_LINKS_URL_MIN_LENGTH . ' символов.');
define('ENTRY_LINKS_STATUS', 'Статус:');
define('ENTRY_LINKS_NOTIFY_CONTACT', 'Уведомить автора ссылки:');
define('ENTRY_LINKS_RATING', 'Рейтинг:');
define('ENTRY_LINKS_RATING_ERROR', 'Поле рейтинг не должно быть пустым.');

define('TEXT_DISPLAY_NUMBER_OF_LINKS', 'Показано <b>%d</b> - <b>%d</b> (всего <b>%d</b> ссылок)');

define('IMAGE_NEW_LINK', 'Новая ссылка');
define('IMAGE_CHECK_LINK', 'Проверить ссылку');

define('TEXT_OPEN_LINK', 'Открыть ссылку');

?>