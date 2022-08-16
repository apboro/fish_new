<?php
// /catalog/includes/languages/english/header_tags.php
// WebMakers.com Added: Header Tags Generator v2.0
// Add META TAGS and Modify TITLE
//
// DEFINITIONS FOR /includes/languages/english/header_tags.php

// Define your email address to appear on all pages
define('HEAD_REPLY_TAG_ALL','your@e-mail');

// For all pages not defined or left blank, and for products not defined
// These are included unless you set the toggle switch in each section below to OFF ( '0' )
// The HEAD_TITLE_TAG_ALL is included BEFORE the specific one for the page
// The HEAD_DESC_TAG_ALL is included AFTER the specific one for the page
// The HEAD_KEY_TAG_ALL is included BEFORE the specific one for the page
define('HEAD_TITLE_TAG_ALL',STORE_NAME.' ');
define('HEAD_DESC_TAG_ALL','description');
define('HEAD_KEY_TAG_ALL','keywords');

// DEFINE TAGS FOR INDIVIDUAL PAGES

// index.php
define('HTTA_DEFAULT_ON','1'); // Include HEAD_TITLE_TAG_ALL in Title
define('HTKA_DEFAULT_ON','1'); // Include HEAD_KEY_TAG_ALL in Keywords
define('HTDA_DEFAULT_ON','1'); // Include HEAD_DESC_TAG_ALL in Description
define('HEAD_TITLE_TAG_DEFAULT',STORE_NAME);
define('HEAD_DESC_TAG_DEFAULT','main page');
define('HEAD_KEY_TAG_DEFAULT','main page');

// product_info.php - if left blank in products_description table these values will be used
define('HTTA_PRODUCT_INFO_ON','1');
define('HTKA_PRODUCT_INFO_ON','1');
define('HTDA_PRODUCT_INFO_ON','1');
define('HEAD_TITLE_TAG_PRODUCT_INFO','');
define('HEAD_DESC_TAG_PRODUCT_INFO','');
define('HEAD_KEY_TAG_PRODUCT_INFO','');

// products_new.php - whats_new
define('HTTA_WHATS_NEW_ON','1');
define('HTKA_WHATS_NEW_ON','1');
define('HTDA_WHATS_NEW_ON','1');
define('HEAD_TITLE_TAG_WHATS_NEW','New products');
define('HEAD_DESC_TAG_WHATS_NEW','new products');
define('HEAD_KEY_TAG_WHATS_NEW','new products');

// specials.php
// If HEAD_KEY_TAG_SPECIALS is left blank, it will build the keywords from the products_names of all products on special
define('HTTA_SPECIALS_ON','1');
define('HTKA_SPECIALS_ON','1');
define('HTDA_SPECIALS_ON','1');
define('HEAD_TITLE_TAG_SPECIALS','Specials');
define('HEAD_DESC_TAG_SPECIALS','specials');
define('HEAD_KEY_TAG_SPECIALS','specials');

// product_reviews_info.php and product_reviews.php - if left blank in products_description table these values will be used
define('HTTA_PRODUCT_REVIEWS_INFO_ON','1');
define('HTKA_PRODUCT_REVIEWS_INFO_ON','1');
define('HTDA_PRODUCT_REVIEWS_INFO_ON','1');
define('HEAD_TITLE_TAG_PRODUCT_REVIEWS_INFO','Product review');
define('HEAD_DESC_TAG_PRODUCT_REVIEWS_INFO','');
define('HEAD_KEY_TAG_PRODUCT_REVIEWS_INFO','');


// Управление тэгами статей

   // For all pages not defined or left blank, and for articles not defined
   // These are included unless you set the toggle switch in each section below to OFF ( '0' )
   // The HEAD_TITLE_TAG_ALL is included BEFORE the specific one for the page
   // The HEAD_DESC_TAG_ALL is included AFTER the specific one for the page
   // The HEAD_KEY_TAG_ALL is included AFTER the specific one for the page
   define('HEAD_TITLE_ARTICLE_TAG_ALL','Store name');
   define('HEAD_DESC_ARTICLE_TAG_ALL','articles');
   define('HEAD_KEY_ARTICLE_TAG_ALL','articles');

/* End of Indented Section */

// DEFINE TAGS FOR INDIVIDUAL PAGES

// articles.php
define('HTTA_ARTICLES_ON','1'); // Include HEAD_TITLE_TAG_ALL in Title
define('HTKA_ARTICLES_ON','1'); // Include HEAD_KEY_TAG_ALL in Keywords
define('HTDA_ARTICLES_ON','1'); // Include HEAD_DESC_TAG_ALL in Description
define('HEAD_TITLE_TAG_ARTICLES','Articles');
define('HEAD_DESC_TAG_ARTICLES','articles');
define('HEAD_KEY_TAG_ARTICLES','articles');

// article_info.php - if left blank in articles_description table these values will be used
define('HTTA_ARTICLE_INFO_ON','1');
define('HTKA_ARTICLE_INFO_ON','1');
define('HTDA_ARTICLE_INFO_ON','1');
define('HEAD_TITLE_TAG_ARTICLE_INFO','Articles');
define('HEAD_DESC_TAG_ARTICLE_INFO','');
define('HEAD_KEY_TAG_ARTICLE_INFO','');

// articles_new.php - new articles
// If HEAD_KEY_TAG_ARTICLES_NEW is left blank, it will build the keywords from the articles_names of all new articles
define('HTTA_ARTICLES_NEW_ON','1');
define('HTKA_ARTICLES_NEW_ON','1');
define('HTDA_ARTICLES_NEW_ON','1');
define('HEAD_TITLE_TAG_ARTICLES_NEW','New articles');
define('HEAD_DESC_TAG_ARTICLES_NEW','');
define('HEAD_KEY_TAG_ARTICLES_NEW','');

// article_reviews_info.php and article_reviews.php - if left blank in articles_description table these values will be used
define('HTTA_ARTICLE_REVIEWS_INFO_ON','1');
define('HTKA_ARTICLE_REVIEWS_INFO_ON','1');
define('HTDA_ARTICLE_REVIEWS_INFO_ON','1');
define('HEAD_TITLE_TAG_ARTICLE_REVIEWS_INFO','');
define('HEAD_DESC_TAG_ARTICLE_REVIEWS_INFO','');
define('HEAD_KEY_TAG_ARTICLE_REVIEWS_INFO','');


?>
