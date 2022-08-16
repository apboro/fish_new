<?php

if ( ($category_depth == 'products') ) {

define('HEADING_TITLE', 'Новости');
define('NAVBAR_TITLE', 'Новости');

define('TABLE_HEADING_IMAGE', 'Картинка');
define('TABLE_HEADING_ARTICLE_NAME', 'Заголовок');
define('TABLE_HEADING_ARTICLE_SHORTTEXT', 'Кратко');
define('TABLE_HEADING_ARTICLE_DESCRIPTION', 'Содержание');
define('TABLE_HEADING_STATUS', 'Статус');
define('TABLE_HEADING_DATE_AVAILABLE', 'Дата');
define('TABLE_HEADING_ARTRICLE_URL', 'URL источника');

define('TEXT_NO_ARTICLES', 'В данном разделе нет новостей.');

define('TEXT_NUMBER_OF_ARTICLES', 'Количество новостей: ');
define('TEXT_SHOW', '<b>Показать:</b>');

} elseif ($category_depth == 'top') {

define('HEADING_TITLE', 'Что нового?');

} elseif ($category_depth == 'nested') {

define('HEADING_TITLE', 'Разделы');

}

?>