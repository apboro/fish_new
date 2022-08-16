<?php
/*
  $Id: information.php,v 1.151 2003/02/07 21:46:49 dgw_ Exp $

  -----> information.php is a edited copy of general.php.
  If general.php code changes in newer releases
  update this file accordingly. <-----

  Author: Xander Witteveen (xanderwitteveen@hotmail.com)

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/

  function tep_get_infopage_tree($parent_id = '0', $spacing = '', $exclude = '', $infopage_tree_array = '', $include_itself = false) {
    global $languages_id;

    if (!is_array($infopage_tree_array)) $infopage_tree_array = array();
    if ( (sizeof($infopage_tree_array) < 1) && ($exclude != '0') ) $infopage_tree_array[] = array('id' => '0', 'text' => TEXT_TOP);

    if ($include_itself) {
      $infopage_query = tep_db_query("select cd.pages_name from " . TABLE_PAGES_DESCRIPTION . " cd where cd.language_id = '" . $languages_id . "' and cd.pages_id = '" . $parent_id . "'");
      $infopage = tep_db_fetch_array($infopage_query);
      $infopage_tree_array[] = array('id' => $parent_id, 'text' => $infopage['pages_name']);
    }

    $information_query = tep_db_query("select c.pages_id, cd.pages_name from " . TABLE_PAGES . " c, " . TABLE_PAGES_DESCRIPTION . " cd where c.pages_id = cd.pages_id and cd.language_id = '" . $languages_id . "' order by c.sort_order, cd.pages_name");
    while ($information = tep_db_fetch_array($information_query)) {
      if ($exclude != $information['pages_id']) $infopage_tree_array[] = array('id' => $information['pages_id'], 'text' => $spacing . $information['pages_name']);
      $infopage_tree_array = tep_get_infopage_tree($information['pages_id'], $spacing . '&nbsp;&nbsp;&nbsp;', $exclude, $infopage_tree_array);
    }

    return $infopage_tree_array;
  }

  function tep_get_pages_name($page_id, $language_id = 0) {
    global $languages_id;

    if ($language_id == 0) $language_id = $languages_id;
    $page_query = tep_db_query("select pages_name from " . TABLE_PAGES_DESCRIPTION . " where pages_id = '" . $page_id . "' and language_id = '" . $language_id . "'");
    $page = tep_db_fetch_array($page_query);

    return $page['pages_name'];
  }

  function tep_get_pages_description($page_id, $language_id) {
    $page_query = tep_db_query("select pages_description from " . TABLE_PAGES_DESCRIPTION . " where pages_id = '" . $page_id . "' and language_id = '" . $language_id . "'");
    $page = tep_db_fetch_array($page_query);

    return $page['pages_description'];
  }

////
// Sets the status of a page
  function tep_set_page_status($pages_id, $status) {
    if ($status == '1') {
      return tep_db_query("update " . TABLE_PAGES . " set pages_status = '1', pages_last_modified = now() where pages_id = '" . $pages_id . "'");
    } elseif ($status == '0') {
      return tep_db_query("update " . TABLE_PAGES . " set pages_status = '0', pages_last_modified = now() where pages_id = '" . $pages_id . "'");
    } else {
      return -1;
    }
  }

  function tep_generate_infopage_path($id, $from = 'infopage', $information_array = '', $index = 0) {
    global $languages_id;

    if (!is_array($information_array)) $information_array = array();

    if ($from == 'page') {
      $information_query = tep_db_query("select pages_id from " . TABLE_PAGES . " where pages_id = '" . $id . "'");
      while ($information = tep_db_fetch_array($information_query)) {
        if ($information['pages_id'] == '0') {
          $information_array[$index][] = array('id' => '0', 'text' => TEXT_TOP);
        } else {
          $infopage_query = tep_db_query("select cd.pages_name, c.pages_id from " . TABLE_PAGES . " c, " . TABLE_PAGES_DESCRIPTION . " cd where c.pages_id = '" . $information['pages_id'] . "' and c.pages_id = cd.pages_id and cd.language_id = '" . $languages_id . "'");
          $infopage = tep_db_fetch_array($infopage_query);
          $information_array[$index][] = array('id' => $information['pages_id'], 'text' => $infopage['pages_name']);
          if ( (tep_not_null($infopage['pages_id'])) && ($infopage['pages_id'] != '0') ) $information_array = tep_generate_infopage_path($infopage['pages_id'], 'infopage', $information_array, $index);
          $information_array[$index] = tep_array_reverse($information_array[$index]);
        }
        $index++;
      }
    }
    return $information_array;
  }

  function tep_output_generated_infopage_path($id, $from = 'infopage') {
    $calculated_infopage_path_string = '';
    $calculated_infopage_path = tep_generate_infopage_path($id, $from);
    for ($i = 0, $n = sizeof($calculated_infopage_path); $i < $n; $i++) {
      for ($j = 0, $k = sizeof($calculated_infopage_path[$i]); $j < $k; $j++) {
        $calculated_infopage_path_string .= $calculated_infopage_path[$i][$j]['text'] . '&nbsp;&gt;&nbsp;';
      }
      $calculated_infopage_path_string = substr($calculated_infopage_path_string, 0, -16) . '<br>';
    }
    $calculated_infopage_path_string = substr($calculated_infopage_path_string, 0, -4);

    if (strlen($calculated_infopage_path_string) < 1) $calculated_infopage_path_string = TEXT_TOP;

    return $calculated_infopage_path_string;
  }

  function tep_remove_page($page_id) {
    $page_image_query = tep_db_query("select pages_image from " . TABLE_PAGES . " where pages_id = '" . (int)$page_id . "'");
    $page_image = tep_db_fetch_array($page_image_query);

    $duplicate_image_query = tep_db_query("select count(*) as total from " . TABLE_PAGES . " where pages_image = '" . (int)$page_image['pages_image'] . "'");
    $duplicate_image = tep_db_fetch_array($duplicate_image_query);

    if ($duplicate_image['total'] < 2) {
      if (file_exists(DIR_FS_CATALOG_IMAGES . $page_image['pages_image'])) {
        @unlink(DIR_FS_CATALOG_IMAGES . $page_image['pages_image']);
      }
    }

    tep_db_query("delete from " . TABLE_PAGES . " where pages_id = '" . (int)$page_id . "'");
    tep_db_query("delete from " . TABLE_PAGES_DESCRIPTION . " where pages_id = '" . (int)$page_id . "'");

    if (USE_CACHE == 'true') {
      tep_reset_cache_block('pages');
    }
  }

// -----------------------------------------------------------------------
// upload file function
// -----------------------------------------------------------------------
function tep_get_uploaded_file_info($filename) {
if (isset($_FILES[$filename])) {
        $uploaded_file = array(
                'name' => $_FILES[$filename]['name'],
                'type' => $_FILES[$filename]['type'],
                'size' => $_FILES[$filename]['size'],
                'tmp_name' => $_FILES[$filename]['tmp_name']
        );
} elseif (isset($GLOBALS['HTTP_POST_FILES'][$filename])) {
        global $HTTP_POST_FILES;

        $uploaded_file = array(
        'name' => $HTTP_POST_FILES[$filename]['name'],
        'type' => $HTTP_POST_FILES[$filename]['type'],
        'size' => $HTTP_POST_FILES[$filename]['size'],
        'tmp_name' => $HTTP_POST_FILES[$filename]['tmp_name']
        );
} else {
        $uploaded_file = array(
                'name' => $GLOBALS[$filename . '_name'],
                'type' => $GLOBALS[$filename . '_type'],
                'size' => $GLOBALS[$filename . '_size'],
                'tmp_name' => $GLOBALS[$filename]
        );
}

// a_berezin fix start

if (substr($uploaded_file['type'],0,5) != 'image')
    $uploaded_file = array();
    
// a_berezin fix end

        return $uploaded_file;
}

// -----------------------------------------------------------------------
// return a local directory path (without trailing slash)
// -----------------------------------------------------------------------
function tep_get_local_path_info($path) {
        if (substr($path, -1) == '/') $path = substr($path, 0, -1);
        return $path;
}
// -----------------------------------------------------------------------

 function tep_array_merge($array1, $array2, $array3 = '') {
   if ($array3 == '') $array3 = array();
   if (function_exists('array_merge')) {
     $array_merged = array_merge($array1, $array2, $array3);
   } else {
     while (list($key, $val) = each($array1)) $array_merged[$key] = $val;
     while (list($key, $val) = each($array2)) $array_merged[$key] = $val;
     if (sizeof($array3) > 0) while (list($key, $val) = each($array3)) $array_merged[$key] = $val;
   }

   return (array) $array_merged;
 }

 // -----------------------------------------------------------------------
// the $filename parameter is an array with the following elements:
// name, type, size, tmp_name
// -----------------------------------------------------------------------
function tep_copy_uploaded_file_info($filename, $target) {
        if (substr($target, -1) != '/') $target .= '/';
        $target .= $filename['name'];
        move_uploaded_file($filename['tmp_name'], $target);
        chmod($target, 0777);
}
// -----------------------------------------------------------------------

  function tep_array_reverse($array) {
   if (function_exists('array_reverse')) {
     return array_reverse($array);
   } else {
     $reversed_array = array();
     for ($i=sizeof($array)-1; $i>=0; $i--) {
       $reversed_array[] = $array[$i];
     }
     return $reversed_array;
   }
 }

?>