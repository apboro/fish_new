<?php
/*
  $Id: filenames.php,v 1.3 2003/09/28 23:37:26 anotherlango Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/

//Admin begin
  define('FILENAME_ADMIN_ACCOUNT', 'admin_account.php');
  define('FILENAME_ADMIN_FILES', 'admin_files.php');
  define('FILENAME_ADMIN_MEMBERS', 'admin_members.php');  
  Define('FILENAME_FORBIDEN', 'forbiden.php');
  define('FILENAME_LOGIN', 'login.php');
  define('FILENAME_LOGOFF', 'logoff.php');
  define('FILENAME_PASSWORD_FORGOTTEN', 'password_forgotten.php');
//Admin end

// MaxiDVD Added Line For WYSIWYG HTML Area: BOF
  define('FILENAME_DEFINE_MAINPAGE', 'define_mainpage.php');
// MaxiDVD Added Line For WYSIWYG HTML Area: EOF

// Added Line For Infobox configuration: BOF
  define('FILENAME_TEMPLATE_CONFIGURATION', 'template_configuration.php');
  define('FILENAME_INFOBOX_CONFIGURATION', 'infobox_configuration.php');
  define('FILENAME_INFOBOX_ADMIN', 'infobox_admin.php');
// Added Line For Infobox configuration: EOF

// Added Line For Salemaker Mod: BOF
  define('FILENAME_SALEMAKER', 'salemaker.php');
  define('FILENAME_SALEMAKER_INFO', 'salemaker_info.php');
// Added Line For Salemaker Mod: EOF

// BOF: Added for Featured product MOD
  define('FILENAME_FEATURED', 'featured.php');
// EOF: Added for Featured product MOD

// BOF: Added for Order_edit MOD
  define('FILENAME_CREATE_ACCOUNT', 'create_account.php');
  define('FILENAME_CREATE_ACCOUNT_PROCESS', 'create_account_process.php');
  define('FILENAME_CREATE_ACCOUNT_SUCCESS', 'create_account_success.php');
  define('FILENAME_CREATE_ORDER_PROCESS', 'create_order_process.php');
  define('FILENAME_CREATE_ORDER', 'create_order.php');
  define('FILENAME_EDIT_ORDERS', 'edit_orders.php');
  define('FILENAME_ORDERS_EDIT', 'edit_orders.php');
  define('FILENAME_ORDERS_EDIT_ADD_PRODUCT', 'edit_orders_add_product.php');
  define('FILENAME_ORDERS_EDIT_AJAX', 'edit_orders_ajax.php');
// EOF: Added for Order_edit MOD

// BOF: Added for Sales Stats MOD
define('FILENAME_STATS_MONTHLY_SALES', 'stats_monthly_sales.php');
// EOF: Added for Sales Stats MOD

// define the filenames used in the project
  define('FILENAME_BACKUP', 'backup.php');
  define('FILENAME_BANNER_MANAGER', 'banner_manager.php');
  define('FILENAME_BANNER_STATISTICS', 'banner_statistics.php');
  define('FILENAME_CACHE', 'cache.php');
  define('FILENAME_CATALOG_ACCOUNT_HISTORY_INFO', 'account_history_info.php');
  define('FILENAME_CATEGORIES', 'categories.php');
  define('FILENAME_CONFIGURATION', 'configuration.php');
  define('FILENAME_COUNTRIES', 'countries.php');
  define('FILENAME_CURRENCIES', 'currencies.php');
  define('FILENAME_CUSTOMERS', 'customers.php');
  define('FILENAME_DEFAULT', 'index.php');
  define('FILENAME_DEFINE_LANGUAGE', 'define_language.php');
  define('FILENAME_FILE_MANAGER', 'file_manager.php');
  define('FILENAME_GEO_ZONES', 'geo_zones.php');
  define('FILENAME_LANGUAGES', 'languages.php');
  define('FILENAME_MAIL', 'mail.php');
  define('FILENAME_MANUFACTURERS', 'manufacturers.php');
  define('FILENAME_MODULES', 'modules.php');
  define('FILENAME_NEWSLETTERS', 'newsletters.php');
  define('FILENAME_ORDERS', 'orders.php');
  define('FILENAME_ORDERS_INVOICE', 'invoice.php');
  define('FILENAME_ORDERS_PACKINGSLIP', 'packingslip.php');
  define('FILENAME_ORDERS_STATUS', 'orders_status.php');
  define('FILENAME_POPUP_IMAGE', 'popup_image.php');
  define('FILENAME_POPUP_INFOBOX_HELP', 'popup_infobox_help.php');
  define('FILENAME_PRODUCTS_ATTRIBUTES', 'products_attributes.php');
  define('FILENAME_PRODUCTS_EXPECTED', 'products_expected.php');
  define('FILENAME_REVIEWS', 'reviews.php');
  define('FILENAME_SERVER_INFO', 'server_info.php');
  define('FILENAME_SHIPPING_MODULES', 'shipping_modules.php');
  define('FILENAME_SPECIALS', 'specials.php');
  define('FILENAME_STATS_CUSTOMERS', 'stats_customers.php');
  define('FILENAME_STATS_PRODUCTS_PURCHASED', 'stats_products_purchased.php');
  define('FILENAME_STATS_PRODUCTS_VIEWED', 'stats_products_viewed.php');
  define('FILENAME_TAX_CLASSES', 'tax_classes.php');
  define('FILENAME_TAX_RATES', 'tax_rates.php');
  define('FILENAME_WHOS_ONLINE', 'whos_online.php');
  define('FILENAME_ZONES', 'zones.php');
  define('FILENAME_XSELL_PRODUCTS', 'xsell_products.php'); // X-Sell
  define('FILENAME_EASYPOPULATE', 'easypopulate.php');
  define('FILENAME_EDIT_ORDERS', 'edit_orders.php');
  define('FILENAME_GROUPS', 'customers_groups.php');  
  define('FILENAME_MANUAL_DISCOUNTS', 'manudiscount.php');  

// VJ Links Manager v1.00 begin
  define('FILENAME_LINKS', 'links.php');
  define('FILENAME_LINK_CATEGORIES', 'link_categories.php');
  define('FILENAME_LINKS_CONTACT', 'links_contact.php');
// VJ Links Manager v1.00 end

	define('FILENAME_RECOVER_CART_SALES', 'recover_cart.php');
	define('FILENAME_STATS_RECOVER_CART_SALES', 'stats_recover_cart_sales.php');
   define('FILENAME_CATALOG_LOGIN', 'login.php');

   define('FILENAME_KEYWORDS', 'stats_keywords.php');

  define('FILENAME_ARTICLE_REVIEWS', 'article_reviews.php');
  define('FILENAME_ARTICLES', 'articles.php');
  define('FILENAME_ARTICLES_CONFIG', 'articles_config.php');
  define('FILENAME_ARTICLES_XSELL', 'articles_xsell.php');
  define('FILENAME_AUTHORS', 'authors.php');

  define('FILENAME_QUICK_UPDATES', 'quick_updates.php');

  // begin mod for ProductsProperties v2.01
  define('FILENAME_PRODUCTS_PROPERTIES', 'products_properties.php');
  define('FILENAME_PRODUCTS_PROPERTIES_POPUP', 'products_properties_popup.php');
  // end mod for ProductsProperties v2.01

  define('FILENAME_STATS_SALES_REPORT2', 'stats_sales_report2.php');	
  define('FILENAME_STATS_SALES_REPORT', 'stats_sales_report.php');	

//BEGIN Dynamic Information pages unlimited
  define('FILENAME_INFORMATION', 'information_manager.php');
//END Dynamic Information pages unlimited

  define('FILENAME_STATS_CUSTOMERS_ORDERS', 'stats_customers_orders.php'); 

  define('FILENAME_NEW_ATTRIBUTE_MANAGER', 'new_attributes.php'); 
  
// BOF FlyOpenair: Extra Product Price
  define('FILENAME_EXTRA_PRODUCT_PRICE', 'extra_product_price.php');
// EOF FlyOpenair: Extra Product Price

  define('FILENAME_ORDERS_EDIT', 'edit_orders.php');

  define('FILENAME_SHIP2PAY', 'ship2pay.php');

  define('FILENAME_EXTRA_FIELDS','customer_extra_fields.php');

    // START: Product Extra Fields
    define('FILENAME_PRODUCTS_EXTRA_FIELDS', 'product_extra_fields.php');
    // END: Product Extra Fields

  define('CONTENT_CIP_MANAGER','cip_manager');
  define('FILENAME_CIP_MANAGER',CONTENT_CIP_MANAGER.'.php');

  define('FILENAME_CATEGORY_SPECIALS', 'category_specials.php');

//Options as Images
define ('FILENAME_OPTIONS_IMAGES', 'options_images.php');

define('FILENAME_PRODUCTS_MULTI', 'products_multi.php');

define('FILENAME_SELECT_FEATURED','select_featured.php');
define('FILENAME_SELECT_SPECIAL','select_special.php');

// Start Product Specifications
  define('FILENAME_PRODUCTS_SPECIFICATIONS', 'products_specifications.php');
  define('FILENAME_PRODUCTS_SPECIFICATIONS_INPUT', 'products_specifications_input.php');
  define('FILENAME_PRODUCTS_TABS', 'products_tabs.php');
// End Product Specifications

define('FILENAME_EMAIL_QUEUE','email_queue.php');

define('FILENAME_YML_IMPORT','yml_import.php');

  define('FILENAME_EXPORTORDERS', 'exportorders.php');
  define('FILENAME_CUSTOMERS_EXPORT', 'customer_export.php');

  define('FILENAME_PIN_LOADER', 'pin_loader.php');

//MAIL MANAGER
define('FILENAME_MM_RESPONSEMAIL', 'mm_responsemail.php');
define('FILENAME_MM_TEMPLATES', 'mm_templates.php');
define('FILENAME_MM_BULKMAIL', 'mm_bulkmail.php');
define('FILENAME_MM_EMAIL', 'mm_email.php');

?>