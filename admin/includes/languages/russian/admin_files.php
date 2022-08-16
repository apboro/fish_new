<?php
/*
  $Id: admin_files.php,v 1.2 2003/09/24 13:57:08 wilt Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2002 osCommerce

  Released under the GNU General Public License
*/

define('HEADING_TITLE', 'Меню Администраторских Боксов');

define('TABLE_HEADING_ACTION', 'Действие');
define('TABLE_HEADING_BOXES', 'Боксы');
define('TABLE_HEADING_FILENAME', 'Список файлов');
define('TABLE_HEADING_GROUPS', 'Группы');
define('TABLE_HEADING_STATUS', 'Статус');

define('TEXT_COUNT_BOXES', 'Боксы: ');
define('TEXT_COUNT_FILES', 'Файлы: ');

//categories access
define('TEXT_INFO_HEADING_DEFAULT_BOXES', 'Имя файла: ');

define('TEXT_INFO_DEFAULT_BOXES_INTRO', 'Чтобы бокс был активирован, нажмите на зелёную кнопку, чтобы сделать бокс неактивным(невидимым), нажмите на красную кнопку.<br><br><b>ВНИМАНИЕ:</b> Если Вы отключите бокс, то всё файлы, расположенные в данном боксе также будут не видны!');
define('TEXT_INFO_DEFAULT_BOXES_INSTALLED', ' Активен');
define('TEXT_INFO_DEFAULT_BOXES_NOT_INSTALLED', ' Неактивен');

define('STATUS_BOX_INSTALLED', 'Активен');
define('STATUS_BOX_NOT_INSTALLED', 'Неактивен');
define('STATUS_BOX_REMOVE', 'Выключить');
define('STATUS_BOX_INSTALL', 'Включить');

//files access
define('TEXT_INFO_HEADING_DEFAULT_FILE', 'Файл: ');
define('TEXT_INFO_HEADING_DELETE_FILE', 'Подтверждение удаления:');
define('TEXT_INFO_HEADING_NEW_FILE', 'Добавить файл в бокс');

define('TEXT_INFO_DEFAULT_FILE_INTRO', 'Нажмите кнопку <b>добавить</b> и файлы, которые Вы выберите будут добавлены в бокс: ');
define('TEXT_INFO_DELETE_FILE_INTRO', 'Вы действительно хотите удалить файл <font color="red"><b>%s</b></font> из бокса <b>%s</b>? ');
define('TEXT_INFO_NEW_FILE_INTRO', 'Убедитесь, что файл, который Вы хотите добавить отсутствует в <font color="red"><b>списке файлов</b></font> слева. Возможно, файл, который Вы хотите добавить, уже есть в списке.');

define('TEXT_INFO_NEW_FILE_BOX', 'Текущий бокс: ');

?>
