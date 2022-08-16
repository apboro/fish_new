<?php

if ( ($category_depth == 'products') ) {

define('HEADING_TITLE', 'News Articles');
define('NAVBAR_TITLE', 'News Articles');

define('TABLE_HEADING_IMAGE', 'Image');
define('TABLE_HEADING_ARTICLE_NAME', 'Headline');
define('TABLE_HEADING_ARTICLE_SHORTTEXT', 'Summary');
define('TABLE_HEADING_ARTICLE_DESCRIPTION', 'Content');
define('TABLE_HEADING_STATUS', 'Status');
define('TABLE_HEADING_DATE_AVAILABLE', 'Date');
define('TABLE_HEADING_ARTRICLE_URL', 'URL to outside resource');

define('TEXT_NO_ARTICLES', 'There are no news articles in this category.');

define('TEXT_NUMBER_OF_ARTICLES', 'Number of Articles: ');
define('TEXT_SHOW', '<b>Show:</b>');

} elseif ($category_depth == 'top') {

define('HEADING_TITLE', 'What\'s New Here?');

} elseif ($category_depth == 'nested') {

define('HEADING_TITLE', 'News Article Categories');

}

?>