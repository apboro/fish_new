<?php
/*
  $Id: links.php,v 1.00 2003/10/03 Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/

define('NAVBAR_TITLE', 'Ссылки');

if ($display_mode == 'links') {
  define('HEADING_TITLE', 'Ссылки');
  define('TABLE_HEADING_LINKS_IMAGE', '');
  define('TABLE_HEADING_LINKS_TITLE', 'Название');
  define('TABLE_HEADING_LINKS_URL', 'URL Адрес');
  define('TABLE_HEADING_LINKS_DESCRIPTION', 'Описание');
  define('TABLE_HEADING_LINKS_COUNT', 'Клики');
  define('TEXT_NO_LINKS', 'В данном разделе нет ни одной ссылки.');
} elseif ($display_mode == 'categories') {
  define('HEADING_TITLE', 'Разделы');
  define('TEXT_NO_CATEGORIES', 'Нет ни одного раздела.');
}

// VJ todo - move to common language file
define('TEXT_DISPLAY_NUMBER_OF_LINKS', 'Показано <b>%d</b> - <b>%d</b> (всего <b>%d</b> ссылок)');

define('IMAGE_BUTTON_SUBMIT_LINK', 'Добавить ссылку');
?>
