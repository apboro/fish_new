<?php
/*
  $Id: privacy.php,v 1.3 2001/12/20 14:14:15 dgw_ Exp $

  The Exchange Project - Community Made Shopping!
  http://www.theexchangeproject.org

  Copyright (c) 2000,2001 The Exchange Project

  Released under the GNU General Public License
*/

define('NAVBAR_TITLE', 'RSS Channels');
define('HEADING_TITLE', 'RSS Channels');
define('TEXT_INFORMATION', '

<a href="' . HTTP_SERVER . DIR_WS_HTTP_CATALOG . FILENAME_RSS2. '?feed=news' .'">' . HTTP_SERVER . DIR_WS_HTTP_CATALOG . FILENAME_RSS2. '?feed=news</a> - News.<br>
<a href="' . HTTP_SERVER . DIR_WS_HTTP_CATALOG . FILENAME_RSS2. '?feed=articles' .'">' . HTTP_SERVER . DIR_WS_HTTP_CATALOG . FILENAME_RSS2. '?feed=articles</a> - Articles.<br>
<a href="' . HTTP_SERVER . DIR_WS_HTTP_CATALOG . FILENAME_RSS2. '?feed=categories' .'">' . HTTP_SERVER . DIR_WS_HTTP_CATALOG . FILENAME_RSS2. '?feed=categories</a> - Categories.<br>
<a href="' . HTTP_SERVER . DIR_WS_HTTP_CATALOG . FILENAME_RSS2. '?feed=products&limit=10' .'">' . HTTP_SERVER . DIR_WS_HTTP_CATALOG . FILENAME_RSS2. '?feed=products&limit=10</a> - Products.<br>
<a href="' . HTTP_SERVER . DIR_WS_HTTP_CATALOG . FILENAME_RSS2. '?feed=products&products_id=1' .'">' . HTTP_SERVER . DIR_WS_HTTP_CATALOG . FILENAME_RSS2. '?feed=products&products_id=1</a> - Product with id 1.</a><br>
<a href="' . HTTP_SERVER . DIR_WS_HTTP_CATALOG . FILENAME_RSS2. '?feed=products&cPath=28&limit=10' .'">' . HTTP_SERVER . DIR_WS_HTTP_CATALOG . FILENAME_RSS2. '?feed=products&cPath=28&limit=10</a> - Products in categories.<br>
<a href="' . HTTP_SERVER . DIR_WS_HTTP_CATALOG . FILENAME_RSS2. '?feed=new_products&limit=10' .'">' . HTTP_SERVER . DIR_WS_HTTP_CATALOG . FILENAME_RSS2. '?feed=new_products&limit=10</a> - New products.</a><br>
<a href="' . HTTP_SERVER . DIR_WS_HTTP_CATALOG . FILENAME_RSS2. '?feed=best_sellers&limit=10' .'">' . HTTP_SERVER . DIR_WS_HTTP_CATALOG . FILENAME_RSS2. '?feed=best_sellers&limit=10</a> - Best sellers.<br>
<a href="' . HTTP_SERVER . DIR_WS_HTTP_CATALOG . FILENAME_RSS2. '?feed=specials&limit=10' .'">' . HTTP_SERVER . DIR_WS_HTTP_CATALOG . FILENAME_RSS2. '?feed=specials&limit=10</a> - Specials.<br>
<a href="' . HTTP_SERVER . DIR_WS_HTTP_CATALOG . FILENAME_RSS2. '?feed=featured&limit=10' .'">' . HTTP_SERVER . DIR_WS_HTTP_CATALOG . FILENAME_RSS2. '?feed=featured&limit=10</a> - Featured products.<br>
<a href="' . HTTP_SERVER . DIR_WS_HTTP_CATALOG . FILENAME_RSS2. '?feed=upcoming&limit=10' .'">' . HTTP_SERVER . DIR_WS_HTTP_CATALOG . FILENAME_RSS2. '?feed=upcoming&limit=10</a> - Upcoming products.<br>

<br>

<a href="' . HTTP_SERVER . DIR_WS_HTTP_CATALOG . FILENAME_RSS2. '?feed=new_products_random' .'">' . HTTP_SERVER . DIR_WS_HTTP_CATALOG . FILENAME_RSS2. '?feed=new_products_random</a> - New products random.<br>
<a href="' . HTTP_SERVER . DIR_WS_HTTP_CATALOG . FILENAME_RSS2. '?feed=best_sellers_random' .'">' . HTTP_SERVER . DIR_WS_HTTP_CATALOG . FILENAME_RSS2. '?feed=best_sellers_random</a> - Best sellers random.<br>
<a href="' . HTTP_SERVER . DIR_WS_HTTP_CATALOG . FILENAME_RSS2. '?feed=specials_random' .'">' . HTTP_SERVER . DIR_WS_HTTP_CATALOG . FILENAME_RSS2. '?feed=specials_random</a> - Specials random.<br>
<a href="' . HTTP_SERVER . DIR_WS_HTTP_CATALOG . FILENAME_RSS2. '?feed=featured_random' .'">' . HTTP_SERVER . DIR_WS_HTTP_CATALOG . FILENAME_RSS2. '?feed=featured_random</a> - Featured products random.<br>
<a href="' . HTTP_SERVER . DIR_WS_HTTP_CATALOG . FILENAME_RSS2. '?feed=upcoming_random' .'">' . HTTP_SERVER . DIR_WS_HTTP_CATALOG . FILENAME_RSS2. '?feed=upcoming_random</a> - Upcoming random.<br>
<br />
<h3>Limit parameter</h3>
<p>You can use limit parameter.<br />
For example, you can display only 10 items from new products rss2.php?feed=new_products&amp;limit=10</p>
<h3>Ref parameter</h3>
<p>You can use affiliate id parameter.<br />
For example, you can display products from new products with your affiliate id rss2.php?feed=new_products&amp;ref=1</p>

');

?>