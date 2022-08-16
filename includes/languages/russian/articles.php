<?php
/*
  $Id: articles.php, v1.0 2003/12/04 12:00:00 ra Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/

define('TEXT_MAIN', '');
define('TABLE_HEADING_NEW_ARTICLES', 'Новые статьи в разделе %s');
define('TEXT_ARTICLES_SEARCH', 'Поиск в статьях: ');

if ( ($topic_depth == 'articles') || (isset($_GET['authors_id'])) ) {
  define('HEADING_TITLE', $topics['topics_name']);
  define('TABLE_HEADING_ARTICLES', 'Статьи');
  define('TABLE_HEADING_AUTHOR', 'Автор');
  define('TEXT_NO_ARTICLES', 'На данный момент нет статей в данном разделе.');
  define('TEXT_NO_ARTICLES2', 'На данный момент нет опубликованных статей данным автором.');
  define('TEXT_NUMBER_OF_ARTICLES', 'Количество статей: ');
  define('TEXT_SHOW', 'Показать:');
  define('TEXT_NOW', '\' сейчас');
  define('TEXT_ALL_TOPICS', 'Все разделы');
  define('TEXT_ALL_AUTHORS', 'Все авторы');
  define('TEXT_ARTICLES_BY', 'Статья автора ');
  define('TEXT_ARTICLES', 'Список статей по дате добавления в порядке убывания:');
  define('TEXT_DATE_ADDED', 'Опубликовано:');
  define('TEXT_AUTHOR', 'Автор:');
  define('TEXT_TOPIC', 'Раздел');
  define('TEXT_BY', 'Автор:');
  define('TEXT_READ_MORE', 'Читать далее...');
  define('TEXT_MORE_INFORMATION', 'Для получения дополнительно информации, посетите <a href="http://%s" target="_blank">сайт автора</a>.');
} elseif ($topic_depth == 'top') {
  define('HEADING_TITLE', 'Все статьи');
  define('TEXT_ALL_ARTICLES', 'Список статей по дате добавления в порядке убывания:');
  define('TEXT_CURRENT_ARTICLES', '');
  define('TEXT_UPCOMING_ARTICLES', 'Статьи, которые будут опубликованы в ближайшее время.');
  define('TEXT_NO_ARTICLES', 'Нет доступных статей.');
  define('TEXT_DATE_ADDED', 'Опубликовано:');
  define('TEXT_DATE_EXPECTED', 'Ожидается:');
  define('TEXT_AUTHOR', 'Автор:');
  define('TEXT_TOPIC', 'Раздел
  :');
  define('TEXT_BY', 'by');
  define('TEXT_READ_MORE', 'Читать далее...');
} elseif ($topic_depth == 'nested') {
  define('HEADING_TITLE', 'Статьи');
}

  define('HEADING_TITLE', 'Статьи');

?>
