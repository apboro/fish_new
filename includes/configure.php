<?php 
/*
  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/

// Define the webserver and path parameters
// * DIR_FS_* = Filesystem directories (local/physical)
// * DIR_WS_* = Webserver directories (virtual/URL)
//  define('HTTP_SERVER', 'http://yourfish.ru'); // eg, http://localhost - should not be empty for productive servers
  define('HTTPS_SERVER', 'https://yourfish.ru'); // eg, https://localhost - should not be empty for productive servers
  define('ENABLE_SSL', true); // secure webserver for checkout procedure?
  if (ENABLE_SSL){  define('HTTP_SERVER', HTTPS_SERVER);}else{
     define('HTTP_SERVER', 'http://yourfish.ru'); // eg, http://localhost - should not be empty for productive servers
         }
  define('HTTP_COOKIE_DOMAIN', 'yourfish.ru');
  define('HTTPS_COOKIE_DOMAIN', '');
  define('HTTP_COOKIE_PATH', '/');
  define('HTTPS_COOKIE_PATH', '/');
  define('DIR_WS_HTTP_CATALOG', '/');
  define('DIR_WS_HTTPS_CATALOG', '/');
  define('STATIC_DOMAIN', 'https://static.yourfish.ru/');
  define('DIR_WS_IMAGES', 'images/');
  define('DIR_WS_ICONS', DIR_WS_IMAGES . 'icons/');
  define('DIR_WS_INCLUDES', 'includes/');
  define('DIR_WS_BOXES', DIR_WS_INCLUDES . 'boxes/');
//  define('DIR_WS_FUNCTIONS', DIR_WS_INCLUDES . 'functions/');
//  define('DIR_WS_CLASSES', DIR_WS_INCLUDES . 'classes/');

  define('DIR_WS_MODULES', DIR_WS_INCLUDES . 'modules/');
  define('DIR_WS_LANGUAGES', DIR_WS_INCLUDES . 'languages/');

//Added for BTS1.0
  define('DIR_WS_TEMPLATES', 'templates/');
  define('DIR_WS_CONTENT', DIR_WS_TEMPLATES . 'content/');
  define('DIR_WS_JAVASCRIPT', DIR_WS_INCLUDES . 'javascript/');
//End BTS1.0
  define('DIR_WS_DOWNLOAD_PUBLIC', 'pub/'); 
    define('DIR_FS_ADMIN', '/var/www/html/yourfish.ru/admin/'); // absolute pate required
  define('DIR_FS_CATALOG', '/var/www/html/yourfish.ru/');
  define('DIR_FS_DOWNLOAD', DIR_FS_CATALOG . 'download/');
  define('DIR_FS_DOWNLOAD_PUBLIC', DIR_FS_CATALOG . 'pub/');

  define('DIR_WS_CLASSES', DIR_FS_CATALOG.DIR_WS_INCLUDES . 'classes/');
  define('DIR_WS_FUNCTIONS', DIR_FS_CATALOG.DIR_WS_INCLUDES . 'functions/');

// define our database connection
  define('DB_SERVER', 'db'); // eg, localhost - should not be empty for productive servers
  define('DB_SERVER_USERNAME', 'root');
  define('DB_SERVER_PASSWORD', 'lHhYoy');
  define('DB_DATABASE', 'yourfish');
  define('USE_PCONNECT', 'false'); // use persistent connections?
  define('STORE_SESSIONS', 'mysql'); // leave empty '' for default handler or set to 'mysql'
?>