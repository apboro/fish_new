<?php
/*
  $Id: database_tables.php,v 1.2 2003/09/24 13:57:07 wilt Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/

//Admin begin
  define('TABLE_ADMIN', 'admin');
  define('TABLE_ADMIN_FILES', 'admin_files');
  define('TABLE_ADMIN_GROUPS', 'admin_groups');
//Admin end

// Added Line For Infobox & Template configuration: BOF
  define('TABLE_INFOBOX_CONFIGURATION', 'infobox_configuration');
  define('TABLE_TEMPLATE', 'template');
// Added Line For Infobox & Template configuration: BOF

// Added Line For Salemaker Mod: BOF
  define('TABLE_SALEMAKER_SALES', 'salemaker_sales');
// Added Line For Salemaker Mod: EOF

// BOF: Added for Featured product MOD
  define('TABLE_FEATURED', 'featured');
// EOF: Added for Featured product MOD

// define the database table names used in the project
  define('TABLE_ADDRESS_BOOK', 'address_book');
  define('TABLE_ADDRESS_FORMAT', 'address_format');
  define('TABLE_BANNERS', 'banners');
  define('TABLE_BANNERS_HISTORY', 'banners_history');
  define('TABLE_CATEGORIES', 'categories');
  define('TABLE_CATEGORIES_DESCRIPTION', 'categories_description');
  define('TABLE_CONFIGURATION', 'configuration');
  define('TABLE_CONFIGURATION_GROUP', 'configuration_group');
  define('TABLE_COUNTRIES', 'countries');
  define('TABLE_CURRENCIES', 'currencies');
  define('TABLE_CUSTOMERS', 'customers');
  define('TABLE_CUSTOMERS_BASKET', 'customers_basket');
  define('TABLE_CUSTOMERS_BASKET_ATTRIBUTES', 'customers_basket_attributes');
  define('TABLE_CUSTOMERS_INFO', 'customers_info');
  define('TABLE_LANGUAGES', 'languages');
  define('TABLE_MANUFACTURERS', 'manufacturers');
  define('TABLE_MANUFACTURERS_INFO', 'manufacturers_info');
  define('TABLE_NEWSLETTERS', 'newsletters');
  define('TABLE_ORDERS', 'orders');
  define('TABLE_ORDERS_PRODUCTS', 'orders_products');
  define('TABLE_ORDERS_PRODUCTS_ATTRIBUTES', 'orders_products_attributes');
  define('TABLE_ORDERS_PRODUCTS_DOWNLOAD', 'orders_products_download');
  define('TABLE_ORDERS_STATUS', 'orders_status');
  define('TABLE_ORDERS_STATUS_HISTORY', 'orders_status_history');
  define('TABLE_ORDERS_TOTAL', 'orders_total');
  define('TABLE_PRODUCTS', 'products');
  define('TABLE_PRODUCTS_ATTRIBUTES', 'products_attributes');
  define('TABLE_PRODUCTS_ATTRIBUTES_DOWNLOAD', 'products_attributes_download');
  define('TABLE_PRODUCTS_DESCRIPTION', 'products_description');
define('TABLE_SUPPLIER', 'supplier');
  define('TABLE_PRODUCTS_NOTIFICATIONS', 'products_notifications');
  define('TABLE_PRODUCTS_OPTIONS', 'products_options');
  define('TABLE_PRODUCTS_OPTIONS_VALUES', 'products_options_values');
  define('TABLE_PRODUCTS_OPTIONS_VALUES_TO_PRODUCTS_OPTIONS', 'products_options_values_to_products_options');
  define('TABLE_PRODUCTS_TO_CATEGORIES', 'products_to_categories');
  define('TABLE_REVIEWS', 'reviews');
  define('TABLE_REVIEWS_DESCRIPTION', 'reviews_description');
  define('TABLE_SESSIONS', 'sessions');
  define('TABLE_SPECIALS', 'specials');
  define('TABLE_TAX_CLASS', 'tax_class');
  define('TABLE_TAX_RATES', 'tax_rates');
  define('TABLE_GEO_ZONES', 'geo_zones');
  define('TABLE_ZONES_TO_GEO_ZONES', 'zones_to_geo_zones');
  define('TABLE_WHOS_ONLINE', 'whos_online');
  define('TABLE_ZONES', 'zones');

// VJ Links Manager v1.00 begin
  define('TABLE_LINK_CATEGORIES', 'link_categories');
  define('TABLE_LINK_CATEGORIES_DESCRIPTION', 'link_categories_description');
  define('TABLE_LINKS', 'links');
  define('TABLE_LINKS_DESCRIPTION', 'links_description');
  define('TABLE_LINKS_TO_LINK_CATEGORIES', 'links_to_link_categories');
  define('TABLE_LINKS_STATUS', 'links_status');
// VJ Links Manager v1.00 end

	define('TABLE_SCART', 'scart');

// RJW Begin Meta Tags Code
  define('TABLE_METATAGS', 'meta_tags');
// RJW End Meta Tags Code

  define('TABLE_ARTICLE_REVIEWS', 'article_reviews');
  define('TABLE_ARTICLE_REVIEWS_DESCRIPTION', 'article_reviews_description');
  define('TABLE_ARTICLES', 'articles');
  define('TABLE_ARTICLES_DESCRIPTION', 'articles_description');
  define('TABLE_ARTICLES_TO_TOPICS', 'articles_to_topics');
  define('TABLE_ARTICLES_XSELL', 'articles_xsell');
  define('TABLE_AUTHORS', 'authors');
  define('TABLE_AUTHORS_INFO', 'authors_info');
  define('TABLE_TOPICS', 'topics');
  define('TABLE_TOPICS_DESCRIPTION', 'topics_description');

  // begin mod for ProductsProperties v2.01
  define('TABLE_PRODUCTS_PROPERTIES', 'products_properties');
  define('TABLE_PRODUCTS_PROP_OPTIONS', 'products_prop_options');
  define('TABLE_PRODUCTS_PROP_OPTIONS_VALUES', 'products_prop_options_values');
  define('TABLE_PRODUCTS_PROP_OPTIONS_VALUES_TO_PRODUCTS_PROP_OPTIONS', 'products_prop_options_values_to_products_prop_options');
  // end mod for ProductsProperties v2.01

  //TotalB2B start
  define('TABLE_CUSTOMERS_GROUPS', 'customers_groups');
  define('TABLE_MANUDISCOUNT', 'manudiscount');
  //TotalB2B end
  
//BEGIN Dynamic Information pages unlimited
  define('TABLE_PAGES', 'pages');
  define('TABLE_PAGES_DESCRIPTION', 'pages_description');
  define('TABLE_PAGES_TO_INFORMATION', 'pages_to_information');
  define('TABLE_INFORMATION', 'information');
  define('TABLE_INFORMATION_DESCRIPTION', 'information_description');
//END Dynamic Information pages unlimited

// BOF FlyOpenair: Extra Product Price
  define('TABLE_EXTRA_PRODUCT_PRICE', 'extra_product_price');
// EOF FlyOpenair: Extra Product Price

  define('TABLE_WISHLIST', 'customers_wishlist'); 
  define('TABLE_WISHLIST_ATTRIBUTES', 'customers_wishlist_attributes');

  define('TABLE_SHIP2PAY','ship2pay');

  define('TABLE_EXTRA_FIELDS','extra_fields');
  define('TABLE_EXTRA_FIELDS_INFO','extra_fields_info');
  define('TABLE_CUSTOMERS_TO_EXTRA_FIELDS','customers_to_extra_fields');

    // START: Product Extra Fields
    define('TABLE_PRODUCTS_EXTRA_FIELDS', 'products_extra_fields');
    define('TABLE_PRODUCTS_TO_PRODUCTS_EXTRA_FIELDS', 'products_to_products_extra_fields');
    // END: Product Extra Fields

  define('TABLE_CIP_DEPEND', 'cip_depend');
  define('TABLE_CIP', 'cip');

  define('TABLE_SPECIAL_CATEGORY', 'special_category');
  define('TABLE_SPECIAL_PRODUCT', 'special_product');

  define('TABLE_COMPANIES', 'companies');
  define('TABLE_PERSONS', 'persons');

// Start Products Specifications
  define('TABLE_PRODUCTS_SPECIFICATIONS', 'products_specifications');
  define('TABLE_SPECIFICATION', 'specifications');
  define('TABLE_SPECIFICATION_DESCRIPTION', 'specification_description');
  define('TABLE_SPECIFICATION_GROUPS', 'specification_groups');
  define('TABLE_SPECIFICATIONS_FILTERS', 'specification_filters');
  define('TABLE_SPECIFICATIONS_FILTERS_DESCRIPTION', 'specification_filters_description');
  define('TABLE_SPECIFICATIONS_TO_CATEGORIES', 'specification_groups_to_categories');
  define('TABLE_SPECIFICATIONS_VALUES', 'specification_values');
  define('TABLE_SPECIFICATIONS_VALUES_DESCRIPTION', 'specification_values_description');
// End Products Specifications

define('TABLE_EMAIL_BATCH', 'email_batch');      // the email queue
define('TABLE_EMAIL_BATCH_A', 'email_batch_a');  // the email queue archive

?>