<?php
// /catalog/includes/languages/english/header_tags.php
// WebMakers.com Added: Header Tags Generator v2.0
// Add META TAGS and Modify TITLE
//
// DEFINITIONS FOR /includes/languages/english/header_tags.php

// Define your email address to appear on all pages
define('HEAD_REPLY_TAG_ALL','magazin@yourfish.ru');
// For all pages not defined or left blank, and for products not defined
// These are included unless you set the toggle switch in each section below to OFF ( '0' )
// The HEAD_TITLE_TAG_ALL is included BEFORE the specific one for the page
// The HEAD_DESC_TAG_ALL is included AFTER the specific one for the page
// The HEAD_KEY_TAG_ALL is included BEFORE the specific one for the page
define('HEAD_TITLE_TAG_ALL','YourFish.ru ');
define('HEAD_DESC_TAG_ALL','Рыболовный магазин');
define('HEAD_KEY_TAG_ALL','Рыболовные товары, товары для рыбалки, всё для рыбалки, подарки рыбакам, магазин для рыбаков');

// DEFINE TAGS FOR INDIVIDUAL PAGES

// index.php
define('HTTA_DEFAULT_ON','1'); // Include HEAD_TITLE_TAG_ALL in Title
define('HTKA_DEFAULT_ON','0'); // Include HEAD_KEY_TAG_ALL in Keywords
define('HTDA_DEFAULT_ON','0'); // Include HEAD_DESC_TAG_ALL in Description
define('HEAD_TITLE_TAG_DEFAULT', 'Рыболовный интернет-магазин - рыболовный магазин Москва. Рыболовные снасти и товары для рыбалки.');
define('HEAD_DESC_TAG_DEFAULT', 'Рыболовный интернет-магазин YourFish (ЕФиш) - продажа рыболовных снастей и товаров для рыбалки от ведущих производителей с доставкой почтой по России или курьером по Москве.');
define('HEAD_KEY_TAG_DEFAULT', 'рыбалка, катушки, спиннинги, рыболовное снаряжение, ryobi, катушки ryobi, воблеры, катушка, рыболовный интернет магазин, рыболовные товары, рыболовный магазин, рыболовные снасти, блёсны mepps');



// product_info.php - if left blank in products_description table these values will be used
define('HTTA_PRODUCT_INFO_ON','0');
define('HTKA_PRODUCT_INFO_ON','0');
define('HTDA_PRODUCT_INFO_ON','0');
define('HEAD_TITLE_TAG_PRODUCT_INFO','рыболовный интернет магазин');
define('HEAD_DESC_TAG_PRODUCT_INFO','');
define('HEAD_KEY_TAG_PRODUCT_INFO','');

// products_new.php - whats_new
define('HTTA_WHATS_NEW_ON','0');
define('HTKA_WHATS_NEW_ON','0');
define('HTDA_WHATS_NEW_ON','0');
define('HEAD_TITLE_TAG_WHATS_NEW','рыболовный интернет магазин');
define('HEAD_DESC_TAG_WHATS_NEW','новинки');
define('HEAD_KEY_TAG_WHATS_NEW','новинки');

// specials.php
// If HEAD_KEY_TAG_SPECIALS is left blank, it will build the keywords from the products_names of all products on special
define('HTTA_SPECIALS_ON','1');
define('HTKA_SPECIALS_ON','1');
define('HTDA_SPECIALS_ON','1');
define('HEAD_TITLE_TAG_SPECIALS','Скидки');
define('HEAD_DESC_TAG_SPECIALS','Скидки');
define('HEAD_KEY_TAG_SPECIALS','скидки');

// product_reviews_info.php and product_reviews.php - if left blank in products_description table these values will be used
define('HTTA_PRODUCT_REVIEWS_INFO_ON','1');
define('HTKA_PRODUCT_REVIEWS_INFO_ON','1');
define('HTDA_PRODUCT_REVIEWS_INFO_ON','1');
define('HEAD_TITLE_TAG_PRODUCT_REVIEWS_INFO','Отзыв о товаре');
define('HEAD_DESC_TAG_PRODUCT_REVIEWS_INFO','отзывы');
define('HEAD_KEY_TAG_PRODUCT_REVIEWS_INFO','отзывы');


// Управление тэгами статей

   // For all pages not defined or left blank, and for articles not defined
   // These are included unless you set the toggle switch in each section below to OFF ( '0' )
   // The HEAD_TITLE_TAG_ALL is included BEFORE the specific one for the page
   // The HEAD_DESC_TAG_ALL is included AFTER the specific one for the page
   // The HEAD_KEY_TAG_ALL is included AFTER the specific one for the page
   define('HEAD_TITLE_ARTICLE_TAG_ALL','Интернет-магазин');
   define('HEAD_DESC_ARTICLE_TAG_ALL','статьи');
   define('HEAD_KEY_ARTICLE_TAG_ALL','статьи');

/* End of Indented Section */

// DEFINE TAGS FOR INDIVIDUAL PAGES

// articles.php
define('HTTA_ARTICLES_ON','1'); // Include HEAD_TITLE_TAG_ALL in Title
define('HTKA_ARTICLES_ON','1'); // Include HEAD_KEY_TAG_ALL in Keywords
define('HTDA_ARTICLES_ON','1'); // Include HEAD_DESC_TAG_ALL in Description
define('HEAD_TITLE_TAG_ARTICLES','Статьи');
define('HEAD_DESC_TAG_ARTICLES','статьи');
define('HEAD_KEY_TAG_ARTICLES','статьи');

// article_info.php - if left blank in articles_description table these values will be used
define('HTTA_ARTICLE_INFO_ON','1');
define('HTKA_ARTICLE_INFO_ON','1');
define('HTDA_ARTICLE_INFO_ON','1');
define('HEAD_TITLE_TAG_ARTICLE_INFO','Статьи');
define('HEAD_DESC_TAG_ARTICLE_INFO','статьи');
define('HEAD_KEY_TAG_ARTICLE_INFO','статьи');

// articles_new.php - new articles
// If HEAD_KEY_TAG_ARTICLES_NEW is left blank, it will build the keywords from the articles_names of all new articles
define('HTTA_ARTICLES_NEW_ON','1');
define('HTKA_ARTICLES_NEW_ON','1');
define('HTDA_ARTICLES_NEW_ON','1');
define('HEAD_TITLE_TAG_ARTICLES_NEW','Новые статьи');
define('HEAD_DESC_TAG_ARTICLES_NEW','новые статьи');
define('HEAD_KEY_TAG_ARTICLES_NEW','новые статьи');

// article_reviews_info.php and article_reviews.php - if left blank in articles_description table these values will be used
define('HTTA_ARTICLE_REVIEWS_INFO_ON','1');
define('HTKA_ARTICLE_REVIEWS_INFO_ON','1');
define('HTDA_ARTICLE_REVIEWS_INFO_ON','1');
define('HEAD_TITLE_TAG_ARTICLE_REVIEWS_INFO','Отзывы статьи');
define('HEAD_DESC_TAG_ARTICLE_REVIEWS_INFO','отзывы статьи');
define('HEAD_KEY_TAG_ARTICLE_REVIEWS_INFO','отзывы статьи');


?>
