<?php
/*
  $Id: pollbooth.php,v 1.5 2003/04/06 21:45:33 wilt Exp $

  The Exchange Project - Community Made Shopping!
  http://www.theexchangeproject.org

  Copyright (c) 2000,2001 The Exchange Project

  Released under the GNU General Public License
*/
if (!isset($_GET['op'])) {
	$_GET['op']="list";
	}
if ($_GET['op']=='results') {
  define('TOP_BAR_TITLE', 'Результаты опроса');
  define('HEADING_TITLE', 'Результаты опроса');
  define('SUB_BAR_TITLE', 'Результаты опроса');
}
if ($_GET['op']=='list') {
  define('TOP_BAR_TITLE', 'Результаты опроса');
  define('HEADING_TITLE', 'Результаты опроса');
  define('SUB_BAR_TITLE', 'Другие опросы');
}
if ($_GET['op']=='vote') {
  define('TOP_BAR_TITLE', 'Результаты опроса');
  define('HEADING_TITLE', 'Результаты опроса');
  define('SUB_BAR_TITLE', 'Проголосуйте');
}
if ($_GET['op']=='comment') {
  define('HEADING_TITLE', 'Отзывы');
}
define('_WARNING', 'Предупреждение: ');
define('_ALREADY_VOTED', 'Вы уже голосовали.');
define('_NO_VOTE_SELECTED', 'Вы не выбрали ответ для голосования.');
define('_TOTALVOTES', 'Всего голосов');
define('_OTHERPOLLS', 'Другие опросы');
define('NAVBAR_TITLE_1', 'Результаты опроса');
define('_POLLRESULTS', 'Результаты опроса');
define('_VOTING', 'Голосовать');
define('_RESULTS', 'Результаты');
define('_VOTES', 'Голосов');
define('_VOTE', 'Голосовать');
define('_COMMENT', 'Отзыв');
define('_COMMENTS', 'Отзывы');
define('_COMMENTS_POSTED', 'Отзывы добавлены');
define('_COMMENTS_BY', 'Отзыв добавил ');
define('_COMMENTS_ON', '  ');
define('_YOURNAME', 'Ваше имя:');
define('_OTZYV', 'Отзыв:');
define('TEXT_CONTINUE', 'Добавить отзыв');
define('_PUBLIC','Открытое голосование');
define('_PRIVATE','Закрытое голосование');
define('_POLLOPEN','Опрос открыт');
define('_POLLCLOSED','Опрос для зарегистрированных пользователей');
define('_POLLPRIVATE','Опрос для зарегистрированных пользователей, войдите в магазин, опрос только для зарегистрированных пользователей');
define('_ADD_COMMENTS', 'Добавить отзыв');
define('TEXT_DISPLAY_NUMBER_OF_COMMENTS', 'Показано <b>%d</b> - <b>%d</b> (всего <b>%d</b> отзывов)');
?>
