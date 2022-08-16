<?php
  $HTTP_GET_VARS=$_GET;
  $HTTP_POST_VARS=$_POST;

  define('PAGE_PARSE_START_TIME', microtime());
  error_reporting(E_ALL & ~E_NOTICE);
  if (function_exists('ini_get') && (ini_get('register_globals') == false) && (PHP_VERSION < 4.3) ) {
    exit('Server Requirement Error: register_globals is disabled in your PHP configuration. This can be enabled in your php.ini configuration file or in the .htaccess file in your catalog directory. Please use PHP 4.3+ if register_globals cannot be enabled on the server.');
  }
require(dirname(__FILE__).'../../includes/configure.php');
require(DIR_FS_ADMIN.'includes/database_tables.php');
require(DIR_FS_ADMIN.'includes/functions/database.php');
require(DIR_FS_ADMIN.'includes/functions/sessions.php');
//echo `pwd`;exit;
require(DIR_FS_ADMIN.'includes/functions/general.php');

require(DIR_FS_CATALOG.'includes/classes/order.php');//----link shop order class not admin order class
require(DIR_WS_CLASSES.'class.phpmailer.php');



// make a connection to the database... now
if (!function_exists('mysql_connect')){echo 'No support for DB?';exit;}
if (!function_exists('simplexml_load_string')){echo 'NO simpleXML support';exit;}

tep_db_connect() or die('Unable to connect to database server!');

  $configuration_query = tep_db_query('select configuration_key as cfgKey, configuration_value as cfgValue from ' . TABLE_CONFIGURATION);
  while ($configuration = tep_db_fetch_array($configuration_query)) {
    define($configuration['cfgKey'], $configuration['cfgValue']);
  }

    include(DIR_WS_CLASSES . 'language.php');
    $lng = new language();
    if (isset($_GET['language']) && tep_not_null($_GET['language'])) {
              $lng->set_language($_GET['language']);
              } else {
                $lng->get_browser_language();
                }
    $language = $lng->language['directory'];

?>