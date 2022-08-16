<?php
/*
  $Id: privacy.php,v 1.3 2001/12/20 14:14:15 dgw_ Exp $

  The Exchange Project - Community Made Shopping!
  http://www.theexchangeproject.org

  Copyright (c) 2000,2001 The Exchange Project

  Released under the GNU General Public License
*/

define('NAVBAR_TITLE', 'RSS каналы');
define('HEADING_TITLE', 'RSS каналы');
define('TEXT_INFORMATION', '


<a href="' . HTTP_SERVER . DIR_WS_HTTP_CATALOG . FILENAME_RSS2. '?feed=news' .'">' . HTTP_SERVER . DIR_WS_HTTP_CATALOG . FILENAME_RSS2. '?feed=news</a> - Новости.<br>
<a href="' . HTTP_SERVER . DIR_WS_HTTP_CATALOG . FILENAME_RSS2. '?feed=articles' .'">' . HTTP_SERVER . DIR_WS_HTTP_CATALOG . FILENAME_RSS2. '?feed=articles</a> - Статьи.<br>
<a href="' . HTTP_SERVER . DIR_WS_HTTP_CATALOG . FILENAME_RSS2. '?feed=categories' .'">' . HTTP_SERVER . DIR_WS_HTTP_CATALOG . FILENAME_RSS2. '?feed=categories</a> - Категории.<br>
<a href="' . HTTP_SERVER . DIR_WS_HTTP_CATALOG . FILENAME_RSS2. '?feed=products&limit=10' .'">' . HTTP_SERVER . DIR_WS_HTTP_CATALOG . FILENAME_RSS2. '?feed=products&limit=10</a> - Товары.<br>
<a href="' . HTTP_SERVER . DIR_WS_HTTP_CATALOG . FILENAME_RSS2. '?feed=products&products_id=1' .'">' . HTTP_SERVER . DIR_WS_HTTP_CATALOG . FILENAME_RSS2. '?feed=products&products_id=1</a> - Товар с id кодом 1.</a><br>
<a href="' . HTTP_SERVER . DIR_WS_HTTP_CATALOG . FILENAME_RSS2. '?feed=products&cPath=28&limit=10' .'">' . HTTP_SERVER . DIR_WS_HTTP_CATALOG . FILENAME_RSS2. '?feed=products&cPath=28&limit=10</a> - Товары в категории (28 это идентификатор категории, идентификаторы можно узнать, к примеру в ?feed=categories, в ссылке категории, т.е. Вы можете показывать товары только из определённых категорий).<br>
<a href="' . HTTP_SERVER . DIR_WS_HTTP_CATALOG . FILENAME_RSS2. '?feed=new_products&limit=10' .'">' . HTTP_SERVER . DIR_WS_HTTP_CATALOG . FILENAME_RSS2. '?feed=new_products&limit=10</a> - Новинки.</a><br>
<a href="' . HTTP_SERVER . DIR_WS_HTTP_CATALOG . FILENAME_RSS2. '?feed=best_sellers&limit=10' .'">' . HTTP_SERVER . DIR_WS_HTTP_CATALOG . FILENAME_RSS2. '?feed=best_sellers&limit=10</a> - Лучшие товары.<br>
<a href="' . HTTP_SERVER . DIR_WS_HTTP_CATALOG . FILENAME_RSS2. '?feed=specials&limit=10' .'">' . HTTP_SERVER . DIR_WS_HTTP_CATALOG . FILENAME_RSS2. '?feed=specials&limit=10</a> - Скидки.<br>
<a href="' . HTTP_SERVER . DIR_WS_HTTP_CATALOG . FILENAME_RSS2. '?feed=featured&limit=10' .'">' . HTTP_SERVER . DIR_WS_HTTP_CATALOG . FILENAME_RSS2. '?feed=featured&limit=10</a> - Рекомендуемые товары.<br>
<a href="' . HTTP_SERVER . DIR_WS_HTTP_CATALOG . FILENAME_RSS2. '?feed=upcoming&limit=10' .'">' . HTTP_SERVER . DIR_WS_HTTP_CATALOG . FILENAME_RSS2. '?feed=upcoming&limit=10</a> - Ожидаемые товары.<br>

<br>

<a href="' . HTTP_SERVER . DIR_WS_HTTP_CATALOG . FILENAME_RSS2. '?feed=new_products_random' .'">' . HTTP_SERVER . DIR_WS_HTTP_CATALOG . FILENAME_RSS2. '?feed=new_products_random</a> - Случайный товар из новых товаров.<br>
<a href="' . HTTP_SERVER . DIR_WS_HTTP_CATALOG . FILENAME_RSS2. '?feed=best_sellers_random' .'">' . HTTP_SERVER . DIR_WS_HTTP_CATALOG . FILENAME_RSS2. '?feed=best_sellers_random</a> - Случайный товар из лучших товаров.<br>
<a href="' . HTTP_SERVER . DIR_WS_HTTP_CATALOG . FILENAME_RSS2. '?feed=specials_random' .'">' . HTTP_SERVER . DIR_WS_HTTP_CATALOG . FILENAME_RSS2. '?feed=specials_random</a> - Случайный товар из скидок.<br>
<a href="' . HTTP_SERVER . DIR_WS_HTTP_CATALOG . FILENAME_RSS2. '?feed=featured_random' .'">' . HTTP_SERVER . DIR_WS_HTTP_CATALOG . FILENAME_RSS2. '?feed=featured_random</a> - Случайный товар из рекомендуемых товаров.<br>
<a href="' . HTTP_SERVER . DIR_WS_HTTP_CATALOG . FILENAME_RSS2. '?feed=upcoming_random' .'">' . HTTP_SERVER . DIR_WS_HTTP_CATALOG . FILENAME_RSS2. '?feed=upcoming_random</a> - Случайный товар из ожидаемых товаров.<br>
<br />
<h3>Лимит запросов</h3>
<p>Обратите внимание на параметр limit.<br />
Можно выводить, к примеру, не все новинки (rss2.php?feed=new_products), а только 10, просто добавляете параметр limit (rss2.php?feed=new_products&amp;limit=10)</p>
<h3>Партнёрский ID код</h3>
<p>Обратите внимание на параметр ref.<br />
Если у Вас в магазине установлен модуль партнёрской программы, Ваши партнёры могут получать RSS каналы со своим партнёрским кодом, например, партнёр с id кодом 1 может получить список новинок следующим образом rss2.php?feed=new_products&amp;ref=1</p>
');

?>