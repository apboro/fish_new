<?php
/*
  $Id: compatibility.php,v 1.1.1.1 2003/09/18 19:03:40 wilt Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2007 osCommerce

  Released under the GNU General Public License
*/

////
// Recursively handle magic_quotes_gpc turned off.
// This is due to the possibility of have an array in
// $HTTP_xxx_VARS
// Ie, products attributes
  function do_magic_quotes_gpc(&$ar) {
    if (!is_array($ar)) return false;

    reset($ar); 
    while (list($key, $value) = each($ar)) {
      if (is_array($value)) {
        do_magic_quotes_gpc($value);
      } else {
        $ar[$key] = addslashes($value);
      }
    }
    reset($ar); 
  }

//  if (PHP_VERSION >= 4.1) {
//    $_GET =& $_GET;
//    $_POST =& $_POST;
//    $_COOKIE =& $_COOKIE;
//    $_SESSION =& $_SESSION;
//    $_SERVER =& $_SERVER;
//  } else {
//    if (!is_array($_GET)) $_GET = array();
//    if (!is_array($_POST)) $_POST = array();
//    if (!is_array($_COOKIE)) $_COOKIE = array();
//  }

// handle magic_quotes_gpc turned off.
  if (!get_magic_quotes_gpc()) {
    do_magic_quotes_gpc($_GET);
    do_magic_quotes_gpc($_POST);
    do_magic_quotes_gpc($_COOKIE);
  }

// set default timezone if none exists (PHP 5.3 throws an E_WARNING)
  if (PHP_VERSION >= '5.2') {
    date_default_timezone_set(defined('CFG_TIME_ZONE') ? CFG_TIME_ZONE : date_default_timezone_get());
  }

  if (!function_exists('is_numeric')) {
    function is_numeric($param) {
      return preg_match("/^[0-9]{1,50}.?[0-9]{0,50}$/", $param);
    }
  }

  if (!function_exists('is_uploaded_file')) {
    function is_uploaded_file($filename) {
      if (!$tmp_file = get_cfg_var('upload_tmp_dir')) {
        $tmp_file = dirname(tempnam('', ''));
      }

      if (strchr($tmp_file, '/')) {
        if (substr($tmp_file, -1) != '/') $tmp_file .= '/';
      } elseif (strchr($tmp_file, '\\')) {
        if (substr($tmp_file, -1) != '\\') $tmp_file .= '\\';
      }

      return file_exists($tmp_file . basename($filename));
    }
  }

  if (!function_exists('move_uploaded_file')) {
    function move_uploaded_file($file, $target) {
      return copy($file, $target);
    }
  }

  if (!function_exists('checkdnsrr')) {
    function checkdnsrr($host, $type) {
      if(tep_not_null($host) && tep_not_null($type)) {
        @exec("nslookup -type=$type $host", $output);
        while(list($k, $line) = each($output)) {
          if(preg_match("/^$host/", $line)) {
            return true;
          }
        }
      }
      return false;
    }
  }

  if (!function_exists('in_array')) {
    function in_array($lookup_value, $lookup_array) {
      reset($lookup_array);
      while (list($key, $value) = each($lookup_array)) {
        if ($value == $lookup_value) return true;
      }

      return false;
    }
  }

  if (!function_exists('array_merge')) {
    function array_merge($array1, $array2, $array3 = '') {
      if ($array3 == '') $array3 = array();

      while (list($key, $val) = each($array1)) $array_merged[$key] = $val;
      while (list($key, $val) = each($array2)) $array_merged[$key] = $val;

      if (sizeof($array3) > 0) while (list($key, $val) = each($array3)) $array_merged[$key] = $val;

      return (array)$array_merged;
    }
  }

  if (!function_exists('array_shift')) {
    function array_shift(&$array) {
      $i = 0;
      $shifted_array = array();
      reset($array);
      while (list($key, $value) = each($array)) {
        if ($i > 0) {
          $shifted_array[$key] = $value;
        } else {
          $return = $array[$key];
        }
        $i++;
      }
      $array = $shifted_array;

      return $return;
    }
  }

  if (!function_exists('array_reverse')) {
    function array_reverse($array) {
      $reversed_array = array();

      for ($i=sizeof($array)-1; $i>=0; $i--) {
        $reversed_array[] = $array[$i];
      }

      return $reversed_array;
    }
  }

  if (!function_exists('array_slice')) {
    function array_slice($array, $offset, $length = '0') {
      $length = abs($length);

      if ($length == 0) {
        $high = sizeof($array);
      } else {
        $high = $offset+$length;
      }

      for ($i=$offset; $i<$high; $i++) {
        $new_array[$i-$offset] = $array[$i];
      }

      return $new_array;
    }
  }

/*
 * http_build_query() natively supported from PHP 5.0
 * From Pear::PHP_Compat
 */

  if ( !function_exists('http_build_query') && (PHP_VERSION >= 4)) {
    function http_build_query($formdata, $numeric_prefix = null, $arg_separator = null) {
// If $formdata is an object, convert it to an array
      if ( is_object($formdata) ) {
        $formdata = get_object_vars($formdata);
      }

// Check we have an array to work with
      if ( !is_array($formdata) || !empty($formdata) ) {
        return false;
      }

// Argument seperator
      if ( empty($arg_separator) ) {
        $arg_separator = ini_get('arg_separator.output');

        if ( empty($arg_separator) ) {
          $arg_separator = '&';
        }
      }

// Start building the query
      $tmp = array();

      foreach ( $formdata as $key => $val ) {
        if ( is_null($val) ) {
          continue;
        }

        if ( is_integer($key) && ( $numeric_prefix != null ) ) {
          $key = $numeric_prefix . $key;
        }

        if ( is_scalar($val) ) {
          array_push($tmp, urlencode($key) . '=' . urlencode($val));
          continue;
        }

// If the value is an array, recursively parse it
        if ( is_array($val) || is_object($val) ) {
          array_push($tmp, http_build_query_helper($val, urlencode($key), $arg_separator));
          continue;
        }

// The value is a resource
        return null;
      }

      return implode($arg_separator, $tmp);
    }

// Helper function
    function http_build_query_helper($array, $name, $arg_separator) {
      $tmp = array();

      foreach ( $array as $key => $value ) {
        if ( is_array($value) ) {
          array_push($tmp, http_build_query_helper($value, sprintf('%s[%s]', $name, $key), $arg_separator));
        } elseif ( is_scalar($value) ) {
          array_push($tmp, sprintf('%s[%s]=%s', $name, urlencode($key), urlencode($value)));
        } elseif ( is_object($value) ) {
          array_push($tmp, http_build_query_helper(get_object_vars($value), sprintf('%s[%s]', $name, $key), $arg_separator));
        }
      }

      return implode($arg_separator, $tmp);
    }
  }
?>