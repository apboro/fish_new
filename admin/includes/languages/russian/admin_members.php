<?php
/*
  $Id: admin_members.php,v 1.2 2003/09/24 13:57:08 wilt Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2002 osCommerce

  Released under the GNU General Public License
*/

if ($_GET['gID']) {
  define('HEADING_TITLE', 'Группы');
} elseif ($_GET['gPath']) {
  define('HEADING_TITLE', 'Настройка группы');
} else {
  define('HEADING_TITLE', 'Администраторы');
}

define('TEXT_COUNT_GROUPS', 'Группы: ');

define('TABLE_HEADING_NAME', 'Имя');
define('TABLE_HEADING_EMAIL', 'Email Адрес');
define('TABLE_HEADING_PASSWORD', 'Пароль');
define('TABLE_HEADING_CONFIRM', 'Подтвердить пароль');
define('TABLE_HEADING_GROUPS', 'Группа');
define('TABLE_HEADING_CREATED', 'Дата создания');
define('TABLE_HEADING_MODIFIED', 'Последние изменения');
define('TABLE_HEADING_LOGDATE', 'Последний вход');
define('TABLE_HEADING_LOGNUM', 'Количество входов');
define('TABLE_HEADING_LOG_NUM', 'Количество входов');
define('TABLE_HEADING_ACTION', 'Действие');

define('TABLE_HEADING_GROUPS_NAME', 'Название группы');
define('TABLE_HEADING_GROUPS_DEFINE', 'Боксы и файлы, доступные для данной группы');
define('TABLE_HEADING_GROUPS_GROUP', 'Группа');
define('TABLE_HEADING_GROUPS_CATEGORIES', 'Доступные файлы и боксы');


define('TEXT_INFO_HEADING_DEFAULT', 'Администратор ');
define('TEXT_INFO_HEADING_DELETE', 'Удалить доступ ');
define('TEXT_INFO_HEADING_EDIT', 'Изменить группу / ');
define('TEXT_INFO_HEADING_NEW', 'Новый администратор ');

define('TEXT_INFO_DEFAULT_INTRO', 'Группа');
define('TEXT_INFO_DELETE_INTRO', 'Вы действительно хотите удалить <nobr><b>%s</b></nobr> из <nobr>Администраторов?</nobr>');
define('TEXT_INFO_DELETE_INTRO_NOT', 'Вы не можете удалить группу <nobr>%s!</nobr>');
define('TEXT_INFO_EDIT_INTRO', 'Права доступа к боксам и файлам: ');

define('TEXT_INFO_FULLNAME', 'Имя: ');
define('TEXT_INFO_FIRSTNAME', 'Имя: ');
define('TEXT_INFO_LASTNAME', 'Фамилия: ');
define('TEXT_INFO_EMAIL', 'Email Адрес: ');
define('TEXT_INFO_PASSWORD', 'Пароль: ');
define('TEXT_INFO_CONFIRM', 'Подтвердите Пароль: ');
define('TEXT_INFO_CREATED', 'Запись создана: ');
define('TEXT_INFO_MODIFIED', 'Последние изменения: ');
define('TEXT_INFO_LOGDATE', 'Последний вход: ');
define('TEXT_INFO_LOGNUM', 'Количество входов: ');
define('TEXT_INFO_GROUP', 'Группа: ');
define('TEXT_INFO_ERROR', '<font color="red">Введённый Email уже зарегистрирован! Попробуйте указать другой адрес.</font>');

define('JS_ALERT_FIRSTNAME',        '- Вы не указали своё Имя. \n');
define('JS_ALERT_LASTNAME',         '- Вы не указали свою Фамилию. \n');
define('JS_ALERT_EMAIL',            '- Вы не указали свой Email адрес. \n');
define('JS_ALERT_EMAIL_FORMAT',     '- Вы неправильно написали Email адрес! \n');
define('JS_ALERT_EMAIL_USED',       '- Введённый Email адрес уже зарегистрирован! \n');
define('JS_ALERT_LEVEL', '- Вы не указали группу \n');

define('ADMIN_EMAIL_SUBJECT', 'Новый администратор');
define('ADMIN_EMAIL_TEXT', 'Здравствуйте, %s!' . "\n\n" . 'Вы можете заходить в админку со следущим паролем. После того как Вы зайдёте в админку, мы настоятельно Вам рекомендуем изменить свой пароль!' . "\n\n" . 'Сайт: %s' . "\n" . 'Email: %s' . "\n" . 'Пароль: %s' . "\n\n" . 'Спасибо!' . "\n" . '%s' . "\n\n" . 'Это письмо отправлено автоматически, не нужно на него отвечать!'); 
define('ADMIN_EMAIL_EDIT_SUBJECT', 'Ваша информация изменена администратором');
define('ADMIN_EMAIL_EDIT_TEXT', 'Здравствуйте, %s!' . "\n\n" . 'Ваша информация изменена администратором.' . "\n\n" . 'Сайт: %s' . "\n" . 'Email: %s' . "\n" . 'Пароль: %s' . "\n\n" . 'Спасибо!' . "\n" . '%s' . "\n\n" . 'Это письмо отправлено автоматически, не нужно на него отвечать!'); 

define('TEXT_INFO_HEADING_DEFAULT_GROUPS', 'Группа ');
define('TEXT_INFO_HEADING_DELETE_GROUPS', 'Удалить группу ');

define('TEXT_INFO_DEFAULT_GROUPS_INTRO', '<b>ВНИМАНИЕ:</b><li><b>изменить:</b> изменение названия группы.</li><li><b>удалить:</b> удаление группы.</li><li><b>доступ к файлам:</b> настройка доступа к боксам и файлам.</li>');
define('TEXT_INFO_DELETE_GROUPS_INTRO', 'Удаляя данную группу, Вы также удаляете всех администраторов, находящихся в этой группе. Вы действительно хотите удалить группу <nobr><b>%s</b>?</nobr>');
define('TEXT_INFO_DELETE_GROUPS_INTRO_NOT', 'Вы не можете удалить данную группу!');
define('TEXT_INFO_GROUPS_INTRO', 'Дайте название новой группе, затем нажмите кнопку "далее".');

define('TEXT_INFO_HEADING_GROUPS', 'Новая группа');
define('TEXT_INFO_GROUPS_NAME', ' <b>Название группы:</b><br>Введите название новой группы, затем нажмите кнопку "Далее".<br>');
define('TEXT_INFO_GROUPS_NAME_FALSE', '<font color="red"><b>ОШИБКА:</b> Название группы должно состоять минимум из 2 символов!</font>');
define('TEXT_INFO_GROUPS_NAME_USED', '<font color="red"><b>ОШИБКА:</b> Введённое название группы уже есть, попробуйте назвать группу по-другому!</font>');
define('TEXT_INFO_GROUPS_LEVEL', 'Группа: ');
define('TEXT_INFO_GROUPS_BOXES', '<b>Права доступа к боксам:</b><br>Разграничение доступа к боксам.');
define('TEXT_INFO_GROUPS_BOXES_INCLUDE', 'Добавить файл в бокс: ');

define('TEXT_INFO_HEADING_EDIT_GROUP', 'Изменить название группы');
define('TEXT_INFO_EDIT_GROUP_INTRO', 'Вы можете изменить название данной группы на новое, укажите новое название и нажмите кнопку <b>сохранить</b>');

// BOF: KategorienAdmin / OLISWISS
define('TEXT_INFO_CATEGORIEACCESS','Доступ:');
define('TEXT_RIGHTS_CNEW','Создавать категории');
define('TEXT_RIGHTS_CEDIT','Изменять категории');
define('TEXT_RIGHTS_CMOVE','Перемещать категории');
define('TEXT_RIGHTS_CDELETE','Удалять категории');
define('TEXT_RIGHTS_PNEW','Создавать товары');
define('TEXT_RIGHTS_PEDIT','Изменять товары');
define('TEXT_RIGHTS_PMOVE','Перемещать товары');
define('TEXT_RIGHTS_PCOPY','Копировать товары');
define('TEXT_RIGHTS_PDELETE','Удалять товары');
define('TEXT_RIGHTS_ID','ID код');
// EOF: KategorienAdmin / OLISWISS

define('TEXT_INFO_HEADING_DEFINE', 'Настройка группы');
if ($_GET['gPath'] == 1) {
  define('TEXT_INFO_DEFINE_INTRO', '<b>%s :</b><br>Вы не можете изменять доступ к боксам и файлам для этой группы.<br><br>');
} else {
  define('TEXT_INFO_DEFINE_INTRO', '<b>%s :</b><br>Вы можете установить либо снять доступ к боксам и файлам для данной группы. Нажмите внизу кнопку  <b>сохранить</b> для сохранения внесённых изменений.<br><br>');
}
?>
