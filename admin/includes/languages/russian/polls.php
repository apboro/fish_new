<?php
/*
  $Id: polls.php,v 1.2 2003/04/06 13:12:38 wilt Exp $

  The Exchange Project - Community Made Shopping!
  http://www.theexchangeproject.org

  Copyright (c) 2000,2001 The Exchange Project

  Released under the GNU General Public License
*/

define('TOP_BAR_TITLE', 'Опросы');
define('HEADING_TITLE', 'Опросы');

define('TABLE_HEADING_ID', 'Код');
define('TABLE_HEADING_TITLE', 'Название опроса');
define('TABLE_HEADING_VOTES', 'Голосов');
define('TABLE_HEADING_CREATED', 'Дата создания');
define('TABLE_HEADING_ACTION', 'Действие');
define('TABLE_HEADING_PUBLIC', 'Общедоступный опрос');
define('TABLE_HEADING_OPEN', 'Статус');
define('TABLE_HEADING_CONFIGURATION_TITLE','Заголовок');
define('TABLE_HEADING_CONFIGURATION_VALUE','Значение');
define('TEXT_DISPLAY_NUMBER_OF_POLLS', 'Количество опросов:');
define('TEXT_DELETE_INTRO', 'Вы действительно хотите удалить данный опрос?');
define('TEXT_INFO_DESCRIPTION','Описание:');
define('TEXT_INFO_DATE_ADDED','Дата добавления:');
define('TEXT_INFO_LAST_MODIFIED','Последние изменения:');
define('TEXT_INFO_EDIT_INTRO','Внесите необходимые изменения');
define('TEXT_POLL_TITLE', 'Название опроса');
define('TEXT_POLL_CATEGORY', 'Выберите категорию');
define('TEXT_OPTION', 'Вариант ответа');
define('IMAGE_NEW_POLL', 'Новый опрос');
define('_ALT_REOPEN','Активировать опрос');
define('_ALT_CLOSE','Закрыть опрос');
define('_ALT_PUBLIC','Сделать опрос общедоступным');
define('_ALT_PRIVATE','Сделать опрос доступным только для зарегистрированных посетителей');

define('DISPLAY_POLL_HOW_TITLE', 'Какой опрос показывать');
define('DISPLAY_POLL_ID_TITLE', 'ID Опроса');
define('SHOW_POLL_COMMENTS_TITLE', 'Разрешить отзывы');
define('SHOW_NOPOLL_TITLE', 'Показывать бокс опросов даже если нет опросов');
define('POLL_SPAM_TITLE', 'Разрешить голосовать несколько раз');
define('MAX_DISPLAY_NEW_COMMENTS_TITLE', 'Количество отзывов на странице');

define('DISPLAY_POLL_HOW_DESC', 'Какие опросы показывать в боксе.<br>0 = Случайный<br>1 = Самый последний<br>2 = Самый популярный<br>3 = Указанный ниже опрос в поле ID Опроса');
define('DISPLAY_POLL_ID_DESC', 'Если Вы в переменной Показывать опрос указали 3, то здесь необходимо указать ID код опроса, который будет показан.');
define('SHOW_POLL_COMMENTS_DESC', 'Разрешить оставлять отзывы к опросу?<br>0 = Запретить<br>1 = Разрешить');
define('SHOW_NOPOLL_DESC', 'Показывать бокс опросов, даже если ни одного опроса на данный момент не проводится.<br>0 = Не показывать<br>1 = Показывать');
define('POLL_SPAM_DESC', 'Разрешить голосовать одному человеку несколько раз в одном и том же опросе.<br>0 = Не разрешать (рекомендуется)<br>1 = разрешить');
define('MAX_DISPLAY_NEW_COMMENTS_DESC', 'Максимальное количество отзывов на странице');

define('TEXT_POLLS_CATEGORY','Данные');

?>