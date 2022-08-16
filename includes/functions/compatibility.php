<?php
/*
  $Id: compatibility.php,v 1.1.1.1 2003/09/18 19:05:08 wilt Exp $

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

  if (!function_exists('array_splice')) {
    function array_splice(&$array, $maximum) {
      if (sizeof($array) >= $maximum) {
        for ($i=0; $i<$maximum; $i++) {
          $new_array[$i] = $array[$i];
        }
        $array = $new_array;
      }
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

  if (!function_exists('array_reverse')) {
    function array_reverse($array) {
      for ($i=0, $n=sizeof($array); $i<$n; $i++) $array_reversed[$i] = $array[($n-$i-1)];

      return $array_reversed;
    }
  }

  if (!function_exists('constant')) {
    function constant($constant) {
      eval("\$temp=$constant;");

      return $temp;
    }
  }

  if (!function_exists('is_null')) {
    function is_null($value) {
      if (is_array($value)) {
        if (sizeof($value) > 0) {
          return false;
        } else {
          return true;
        }
      } else {
        if (($value != '') && ($value != 'NULL') && (strlen(trim($value)) > 0)) {
          return false;
        } else {
          return true;
        }
      }
    }
  }

  if (!function_exists('array_merge')) {
    function array_merge($array1, $array2, $array3 = '') {
      if (empty($array3) && !is_array($array3)) $array3 = array();
      while (list($key, $val) = each($array1)) $array_merged[$key] = $val;
      while (list($key, $val) = each($array2)) $array_merged[$key] = $val;
      if (sizeof($array3) > 0) while (list($key, $val) = each($array3)) $array_merged[$key] = $val;

      return (array) $array_merged;
    }
  }

  if (!function_exists('is_numeric')) {
    function is_numeric($param) {
      return preg_match('/^[0-9]{1,50}.?[0-9]{0,50}$/', $param);
    }
  }

  if (!function_exists('array_slice')) {
    function array_slice($array, $offset, $length = 0) {
      if ($offset < 0 ) {
        $offset = sizeof($array) + $offset;
      }
      $length = ((!$length) ? sizeof($array) : (($length < 0) ? sizeof($array) - $length : $length + $offset));
      for ($i = $offset; $i<$length; $i++) {
        $tmp[] = $array[$i];
      }

      return $tmp;
    }
  }

  if (!function_exists('array_map')) {
    function array_map($callback, $array) {
      if (is_array($array)) {
        $_new_array = array();
        reset($array);
        while (list($key, $value) = each($array)) {
          $_new_array[$key] = array_map($callback, $array[$key]);
        }
        return $_new_array;
      } else {
        return $callback($array);
      }
    }
  }

  if (!function_exists('str_repeat')) {
    function str_repeat($string, $number) {
      $repeat = '';

      for ($i=0; $i<$number; $i++) {
        $repeat .= $string;
      }

      return $repeat;
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
?>