<?php
/*
  $Id: general.php,v 1.1.1.1 2003/09/18 19:03:42 wilt Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/

function tep_get_products_special_price($product_id) {
    $product_query = tep_db_query("select products_quantity,products_price, products_model from " . TABLE_PRODUCTS . " where products_id = '" . $product_id . "'");
    if (tep_db_num_rows($product_query)) {
      $product = tep_db_fetch_array($product_query);
	  $product_price = $product['products_price'];
	  $product_quantity = $product['products_quantity'];
    } else {
	  return false;
    }

    $specials_query = tep_db_query("select specials_new_products_price from " . TABLE_SPECIALS . " where products_id = '" . $product_id . "' and status");
    if (tep_db_num_rows($specials_query)) {
      $special = tep_db_fetch_array($specials_query);
	  $special_price = $special['specials_new_products_price'];
    } else {
	  $special_price = false;
    }

    if(substr($product['products_model'], 0, 4) == 'GIFT') {    //Never apply a salededuction to Ian Wilson's Giftvouchers
      return $special_price;
    }

    $product_to_categories_query = tep_db_query("select categories_id from " . TABLE_PRODUCTS_TO_CATEGORIES . " where products_id = '" . $product_id . "'");
    $product_to_categories = tep_db_fetch_array($product_to_categories_query);
    $category = $product_to_categories['categories_id'];
    $sale_query = tep_db_query("select sale_specials_condition, 
    if (".$product_quantity.">=sale_quantity,sale_deduction_value_2,sale_deduction_value) as sale_deduction_value,
     sale_deduction_type from " . TABLE_SALEMAKER_SALES . " where sale_categories_all like '%," . $category . ",%' and sale_status = '1' and (sale_date_start <= now() or sale_date_start = '0000-00-00') and (sale_date_end >= now() or sale_date_end = '0000-00-00') and (sale_pricerange_from <= '" . $product_price . "' or sale_pricerange_from = '0') and (sale_pricerange_to >= '" . $product_price . "' or sale_pricerange_to = '0')
     having sale_deduction_value>0");
    if (tep_db_num_rows($sale_query)) {
      $sale = tep_db_fetch_array($sale_query);
    } else {
	  return $special_price;
    }

    if (!$special_price) {
      $tmp_special_price = $product_price;
    } else {
      $tmp_special_price = $special_price;
    }

    switch ($sale['sale_deduction_type']) {
      case 0:
        $sale_product_price = $product_price - $sale['sale_deduction_value'];
        $sale_special_price = $tmp_special_price - $sale['sale_deduction_value'];
        break;
      case 1:
        $sale_product_price = $product_price - (($product_price * $sale['sale_deduction_value']) / 100);
        $sale_special_price = $tmp_special_price - (($tmp_special_price * $sale['sale_deduction_value']) / 100);
        break;
      case 2:
        $sale_product_price = $sale['sale_deduction_value'];
        $sale_special_price = $sale['sale_deduction_value'];
        break;
      default:
        return $special_price;
    }

    if ($sale_product_price < 0) {
      $sale_product_price = 0;
    }

    if ($sale_special_price < 0) {
      $sale_special_price = 0;
    }

    if (!$special_price) {
      return number_format($sale_product_price, 4, '.', '');
	} else {
      switch($sale['sale_specials_condition']){
        case 0:
          return number_format($sale_product_price, 4, '.', '');
          break;
        case 1:
          return number_format($special_price, 4, '.', '');
          break;
        case 2:
          return number_format($sale_special_price, 4, '.', '');
          break;
        default:
          return number_format($special_price, 4, '.', '');
      }
    }
  }
  function tep_xppp_getproductprice($products_id) {
    global $customer_id;
    $customer_query = tep_db_query("select g.customers_groups_price from " . TABLE_CUSTOMERS_GROUPS . " g inner join  " . TABLE_CUSTOMERS  . " c on g.customers_groups_id = c.customers_groups_id and c.customers_id = '" . $customer_id . "'");
    $customer_query_result = tep_db_fetch_array($customer_query);
    $customer_price = $customer_query_result['customers_groups_price'];
	$products_price_list = tep_xppp_getpricelist("");
    $product_info_query = tep_db_query("select products_id, " . $products_price_list . "  from " . TABLE_PRODUCTS . " where products_id = '" . $products_id . "'");
    $product_info = tep_db_fetch_array($product_info_query);
    if ($product_info['products_price_' . $customer_price] == NULL) {
        $product_info['products_price_' . $customer_price] = $product_info['products_price'];
    }
    if ((int)$customer_price != 1) {
       $product_info['products_price'] = $product_info['products_price_' . $customer_price];
    }
	return $product_info['products_price'];
  }
  //TotalB2B end


//Return files stored in box that can be accessed by user
function tep_admin_files_boxes_newsdesk($filename, $sub_box_name) {
	global $login_groups_id;
	$sub_boxes = '';

	$dbquery = tep_db_query("select admin_files_name from " . TABLE_ADMIN_FILES . " where FIND_IN_SET( '" . $login_groups_id . "', admin_groups_id) and admin_files_is_boxes = '0' and admin_files_name = '" . $filename . "'");
	if (tep_db_num_rows($dbquery)) {
		$sub_boxes = '<a href="' . tep_href_link($filename) . '" class="menuBoxContentLink">' . $sub_box_name . '</a><br>';
	}

	$configuration_groups_query = tep_db_query("
select configuration_group_id as cgID, configuration_group_title as cgTitle from " . TABLE_NEWSDESK_CONFIGURATION_GROUP . " where visible = '1' order by sort_order
	");
	while ($configuration_groups = tep_db_fetch_array($configuration_groups_query)) {
		$sub_boxes .= '<a href="' . tep_href_link(FILENAME_NEWSDESK_CONFIGURATION, 'gID=' . $configuration_groups['cgID'], 'NONSSL') . '
		" class="menuBoxContentLink">' . $configuration_groups['cgTitle'] . '</a><br>';
	}
return $sub_boxes;
}

//Return files stored in box that can be accessed by user
function tep_admin_files_boxes_faqdesk($filename, $sub_box_name) {
	global $login_groups_id;
	$sub_boxes = '';

	$dbquery = tep_db_query("select admin_files_name from " . TABLE_ADMIN_FILES . " where FIND_IN_SET( '" . $login_groups_id . "', admin_groups_id) and admin_files_is_boxes = '0' and admin_files_name = '" . $filename . "'");
	if (tep_db_num_rows($dbquery)) {
		$sub_boxes = '<a href="' . tep_href_link($filename) . '" class="menuBoxContentLink">' . $sub_box_name . '</a><br>';
	}

	$configuration_groups_query = tep_db_query("
select configuration_group_id as cgID, configuration_group_title as cgTitle from " . TABLE_FAQDESK_CONFIGURATION_GROUP . " where visible = '1' order by sort_order
	");
	while ($configuration_groups = tep_db_fetch_array($configuration_groups_query)) {
		$sub_boxes .= '<a href="' . tep_href_link(FILENAME_FAQDESK_CONFIGURATION, 'gID=' . $configuration_groups['cgID'], 'NONSSL') . '
		" class="menuBoxContentLink">' . $configuration_groups['cgTitle'] . '</a><br>';
	}
return $sub_boxes;
}


//Admin begin
////
//Check login and file access
function tep_admin_check_login() {
  global $PHP_SELF, $login_groups_id;
  if (!tep_session_is_registered('login_id')) {
    tep_redirect(tep_href_link(FILENAME_LOGIN, '', 'SSL'));
  } else {
    $filename = basename( $PHP_SELF );
    if ($filename != FILENAME_DEFAULT && $filename != FILENAME_FORBIDEN && $filename != FILENAME_LOGOFF && $filename != FILENAME_ADMIN_ACCOUNT && $filename != FILENAME_POPUP_IMAGE && $filename != 'packingslip.php' && $filename != 'invoice.php') {
      $db_file_query = tep_db_query("select admin_files_name from " . TABLE_ADMIN_FILES . " where FIND_IN_SET( '" . $login_groups_id . "', admin_groups_id) and admin_files_is_boxes='0' and admin_files_name = '" . $filename . "'");
      if (!tep_db_num_rows($db_file_query)) {
        tep_redirect(tep_href_link(FILENAME_FORBIDEN));
      }
    }
  }  
}

////
//Return 'true' or 'false' value to display boxes and files in index.php and column_left.php
function tep_admin_check_boxes($filename, $boxes='') {
  global $login_groups_id;
  
  $is_boxes = 1;
  if ($boxes == 'sub_boxes') {
    $is_boxes = 0;
  }
  $dbquery = tep_db_query("select admin_files_id from " . TABLE_ADMIN_FILES . " where FIND_IN_SET( '" . $login_groups_id . "', admin_groups_id) and admin_files_is_boxes = '" . $is_boxes . "' and admin_files_name = '" . $filename . "'");
  
  $return_value = false;
  if (tep_db_num_rows($dbquery)) {
    $return_value = true;
  }
  return $return_value;
}

////
//Return files stored in box that can be accessed by user
function tep_admin_files_boxes($filename, $sub_box_name) {
  global $login_groups_id;
  $sub_boxes = '';
  
  $dbquery = tep_db_query("select admin_files_name from " . TABLE_ADMIN_FILES . " where FIND_IN_SET( '" . $login_groups_id . "', admin_groups_id) and admin_files_is_boxes = '0' and admin_files_name = '" . $filename . "'");
  if (tep_db_num_rows($dbquery)) {
    $sub_boxes = '<a href="' . tep_href_link($filename) . '" class="menuBoxContentLink">' . $sub_box_name . '</a><br>';

  }
  return $sub_boxes;
}

////
//Get selected file for index.php
function tep_selected_file($filename) {
  global $login_groups_id;
  $randomize = FILENAME_ADMIN_ACCOUNT;
  
  $dbquery = tep_db_query("select admin_files_id as boxes_id from " . TABLE_ADMIN_FILES . " where FIND_IN_SET( '" . $login_groups_id . "', admin_groups_id) and admin_files_is_boxes = '1' and admin_files_name = '" . $filename . "'");
  if (tep_db_num_rows($dbquery)) {
    $boxes_id = tep_db_fetch_array($dbquery);
    $randomize_query = tep_db_query("select admin_files_name from " . TABLE_ADMIN_FILES . " where FIND_IN_SET( '" . $login_groups_id . "', admin_groups_id) and admin_files_is_boxes = '0' and admin_files_to_boxes = '" . $boxes_id['boxes_id'] . "'");
    if (tep_db_num_rows($randomize_query)) {
      $file_selected = tep_db_fetch_array($randomize_query);
      $randomize = $file_selected['admin_files_name'];
    }
  }
  return $randomize;
}
//Admin end

////
// Redirect to another page or site
function tep_redirect($url) {
  global $logger;

  if ( (strstr($url, "\n") != false) || (strstr($url, "\r") != false) ) {
    tep_redirect(tep_href_link(FILENAME_DEFAULT, '', 'NONSSL', false));
  }

  header('Location: ' . $url);

    if (STORE_PAGE_PARSE_TIME == 'true') {
      if (!is_object($logger)) $logger = new logger;
      $logger->timer_stop();
    }
    tep_session_close();
    exit;
}

////
// Parse the data used in the html tags to ensure the tags will not break
  function tep_parse_input_field_data($data, $parse) {
    return strtr(trim($data), $parse);
  }

  function tep_output_string($string, $translate = false, $protected = false) {
    if ($protected == true) {
      return htmlspecialchars($string);
    } else {
      if ($translate == false) {
        return tep_parse_input_field_data($string, array('"' => '&quot;'));
      } else {
        return tep_parse_input_field_data($string, $translate);
      }
    }
  }

  function tep_output_string_protected($string) {
    return tep_output_string($string, false, true);
  }

  function tep_sanitize_string($string) {
    $string = preg_replace('/ +/', ' ', $string);

    return preg_replace("/[<>]/", '_', $string);
  }

  function tep_customers_name($customers_id) {
    $customers = tep_db_query("select customers_firstname, customers_lastname from " . TABLE_CUSTOMERS . " where customers_id = '" . (int)$customers_id . "'");
    $customers_values = tep_db_fetch_array($customers);

    return $customers_values['customers_firstname'] . ' ' . $customers_values['customers_lastname'];
  }

  function tep_get_path($current_category_id = '') {
    global $cPath_array;

    if ($current_category_id == '') {
      $cPath_new = implode('_', $cPath_array);
    } else {
      if (sizeof($cPath_array) == 0) {
        $cPath_new = $current_category_id;
      } else {
        $cPath_new = '';
        $last_category_query = tep_db_query("select parent_id from " . TABLE_CATEGORIES . " where categories_id = '" . (int)$cPath_array[(sizeof($cPath_array)-1)] . "'");
        $last_category = tep_db_fetch_array($last_category_query);

        $current_category_query = tep_db_query("select parent_id from " . TABLE_CATEGORIES . " where categories_id = '" . (int)$current_category_id . "'");
        $current_category = tep_db_fetch_array($current_category_query);

        if ($last_category['parent_id'] == $current_category['parent_id']) {
          for ($i = 0, $n = sizeof($cPath_array) - 1; $i < $n; $i++) {
            $cPath_new .= '_' . $cPath_array[$i];
          }
        } else {
          for ($i = 0, $n = sizeof($cPath_array); $i < $n; $i++) {
            $cPath_new .= '_' . $cPath_array[$i];
          }
        }

        $cPath_new .= '_' . $current_category_id;

        if (substr($cPath_new, 0, 1) == '_') {
          $cPath_new = substr($cPath_new, 1);
        }
      }
    }

    return 'cPath=' . $cPath_new;
  }

  function tep_get_all_get_params($exclude_array = '') {
    global $_GET;

    if ($exclude_array == '') $exclude_array = array();

    $get_url = '';

    reset($_GET);
    while (list($key, $value) = each($_GET)) {
      if (($key != tep_session_name()) && ($key != 'error') && (!in_array($key, $exclude_array))) $get_url .= $key . '=' . $value . '&';
    }

    return $get_url;
  }

  function tep_date_long($raw_date) {
    if ( ($raw_date == '0000-00-00 00:00:00') || ($raw_date == '') ) return false;

    $year = (int)substr($raw_date, 0, 4);
    $month = (int)substr($raw_date, 5, 2);
    $day = (int)substr($raw_date, 8, 2);
    $hour = (int)substr($raw_date, 11, 2);
    $minute = (int)substr($raw_date, 14, 2);
    $second = (int)substr($raw_date, 17, 2);

    return strftime(DATE_FORMAT_LONG, mktime($hour, $minute, $second, $month, $day, $year));
  }

////
// Output a raw date string in the selected locale date format
// $raw_date needs to be in this format: YYYY-MM-DD HH:MM:SS
// NOTE: Includes a workaround for dates before 01/01/1970 that fail on windows servers
  function tep_date_short($raw_date) {
    if ( ($raw_date == '0000-00-00 00:00:00') || ($raw_date == '') ) return false;

    $year = substr($raw_date, 0, 4);
    $month = (int)substr($raw_date, 5, 2);
    $day = (int)substr($raw_date, 8, 2);
    $hour = (int)substr($raw_date, 11, 2);
    $minute = (int)substr($raw_date, 14, 2);
    $second = (int)substr($raw_date, 17, 2);

    if (@date('Y', mktime($hour, $minute, $second, $month, $day, $year)) == $year) {
      return date(DATE_FORMAT, mktime($hour, $minute, $second, $month, $day, $year));
    } else {
      return preg_replace('/2037$/', $year, date(DATE_FORMAT, mktime($hour, $minute, $second, $month, $day, 2037)));
    }

  }

  function tep_datetime_short($raw_datetime) {
    if ( ($raw_datetime == '0000-00-00 00:00:00') || ($raw_datetime == '') ) return false;

    $year = (int)substr($raw_datetime, 0, 4);
    $month = (int)substr($raw_datetime, 5, 2);
    $day = (int)substr($raw_datetime, 8, 2);
    $hour = (int)substr($raw_datetime, 11, 2);
    $minute = (int)substr($raw_datetime, 14, 2);
    $second = (int)substr($raw_datetime, 17, 2);

    return strftime(DATE_TIME_FORMAT, mktime($hour, $minute, $second, $month, $day, $year));
  }

// BOF: KategorienAdmin / OLISWISS
/*  function tep_get_category_tree($parent_id = '0', $spacing = '', $exclude = '', $category_tree_array = '', $include_itself = false) {
    global $languages_id;

    if (!is_array($category_tree_array)) $category_tree_array = array();
    if ( (sizeof($category_tree_array) < 1) && ($exclude != '0') ) $category_tree_array[] = array('id' => '0', 'text' => TEXT_TOP);

    if ($include_itself) {
      $category_query = tep_db_query("select cd.categories_name from " . TABLE_CATEGORIES_DESCRIPTION . " cd where cd.language_id = '" . (int)$languages_id . "' and cd.categories_id = '" . (int)$parent_id . "'");
      $category = tep_db_fetch_array($category_query);
      $category_tree_array[] = array('id' => $parent_id, 'text' => $category['categories_name']);
    }

    $categories_query = tep_db_query("select c.categories_id, cd.categories_name, c.parent_id from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd where c.categories_id = cd.categories_id and cd.language_id = '" . (int)$languages_id . "' and c.parent_id = '" . (int)$parent_id . "' order by c.sort_order, cd.categories_name");
    while ($categories = tep_db_fetch_array($categories_query)) {
      if ($exclude != $categories['categories_id']) $category_tree_array[] = array('id' => $categories['categories_id'], 'text' => $spacing . $categories['categories_name']);
      $category_tree_array = tep_get_category_tree($categories['categories_id'], $spacing . '&nbsp;&nbsp;&nbsp;', $exclude, $category_tree_array);
    }

    return $category_tree_array;
  }
*/
    function tep_quick_get_subcategories($parent_id = 0, $only_active = false,&$ind = 0)
    {
        if(!function_exists('read_cache')){
            include('../'.DIR_WS_FUNCTIONS . 'cache.php');
        }
         if (!read_cache($subcategories_array, 'categories-tree-' . $parent_id . 'active_' . $only_active . '.cache', 300)) {

            $query = "select categories_id from " . TABLE_CATEGORIES . " where parent_id = '" . (int)$parent_id . "'";
            if ($only_active) {
                $query .= " and categories_status=1";
            }
            $subcategories_query = tep_db_query($query);
            $subcategories_array = array();
            while ($subcategories = tep_db_fetch_array($subcategories_query)) {
                if ($subcategories['categories_id'] != $parent_id) {
                    $subcategories_array += tep_quick_get_subcategories($subcategories['categories_id'], $only_active,$ind);
                }
                $subcategories_array[$ind++] = $subcategories['categories_id'];
            }
            write_cache($subcategories_array, 'categories-tree-' . $parent_id . 'active_' . $only_active . '.cache');
        }
        return $subcategories_array;
    }

    function tep_get_category_tree($parent_id = '0', $spacing = '', $exclude = '', $category_tree_array = '', $category_tree_allowed_array = '', $include_itself = false) {
    global $languages_id;
    return array(array('id' => '0', 'text' => 'Временно не работает'));

    if (!is_array($category_tree_array)) $category_tree_array = array();
    if ( (sizeof($category_tree_array) < 1) && ($exclude != '0') ) $category_tree_array[] = array('id' => '0', 'text' => TEXT_TOP);

    if ($include_itself) {
      $category_query = tep_db_query("select cd.categories_name from " . TABLE_CATEGORIES_DESCRIPTION . " cd where cd.language_id = '" . (int)$languages_id . "' and cd.categories_id = '" . (int)$parent_id . "'");
      $category = tep_db_fetch_array($category_query);
      $category_tree_array[] = array('id' => $parent_id, 'text' => $category['categories_name']);
    }

    if (is_array($category_tree_allowed_array)) {
      $category_tree_allowed_string = implode(",",$category_tree_allowed_array);
      $categories_query = tep_db_query("select c.categories_id, cd.categories_name, c.parent_id from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd where (c.parent_id or c.categories_id in (" . $category_tree_allowed_string . ")) and c.categories_id = cd.categories_id and cd.language_id = '" . (int)$languages_id . "' and c.parent_id = '" . (int)$parent_id . "' order by c.sort_order, cd.categories_name");
        while ($categories = tep_db_fetch_array($categories_query)) {
            if ($exclude != $categories['categories_id']) {
                $category_tree_array[] = array('id' => $categories['categories_id'], 'text' => $spacing . $categories['categories_name']);
                $category_tree_array = tep_get_category_tree($categories['categories_id'], $spacing . '&nbsp;&nbsp;&nbsp;', $exclude, $category_tree_array);
            }
        }
    } else {
      $categories_query = tep_db_query("select c.categories_id, cd.categories_name, c.parent_id from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd where c.categories_id = cd.categories_id and cd.language_id = '" . (int)$languages_id . "' and c.parent_id = '" . (int)$parent_id . "' order by c.sort_order, cd.categories_name");
      while ($categories = tep_db_fetch_array($categories_query)) {
          if ($exclude != $categories['categories_id']){
            $category_tree_array[] = array('id' => $categories['categories_id'], 'text' => $spacing . $categories['categories_name']);
            $category_tree_array = tep_get_category_tree($categories['categories_id'], $spacing . '&nbsp;&nbsp;&nbsp;', $exclude, $category_tree_array);
        }
      }
    }
    return $category_tree_array;
  }


function tep_draw_select2_products_pull_down($name, $parameters)
{
    $html = '<select style="width:600px" class="select2-products" ';
    if (tep_not_null($parameters)) $html .= ' ' . $parameters;
    $html .= ' name="'.tep_output_string($name) . '"  ><option disabled>Выберите товар</option></select>';
    return $html;
}
// EOF: KategorienAdmin / OLISWISS

  function tep_draw_products_pull_down($name, $parameters = '', $exclude = '',$filter='') {
      return tep_draw_select2_products_pull_down($name,$parameters);
    global $currencies, $languages_id;
    if ($exclude == '') {
      $exclude = array();
    }

    $select_string = '<select name="' . $name . '"';

    if ($parameters) {
      $select_string .= ' ' . $parameters;
    }

    $select_string .= '>';
//----changed by iHolder---
    $query="select p.products_id, pd.products_name, p.products_price from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd where p.products_id = pd.products_id and pd.language_id = '" . (int)$languages_id."'" ;
    if (strlen($filter)>0){$query.=$filter;}
    $query.=" order by products_name";

    $products_query = tep_db_query($query);
//----changed by iHolder---
    while ($products = tep_db_fetch_array($products_query)) {
      if (!in_array($products['products_id'], $exclude)) {
        $select_string .= '<option value="' . $products['products_id'] . '">' . $products['products_name'] . ' (' . $currencies->format($products['products_price']) . ')</option>';
      }
    }

    $select_string .= '</select>';

    return $select_string;
  }

  function tep_options_name($options_id) {
    global $languages_id;

    $options = tep_db_query("select products_options_name from " . TABLE_PRODUCTS_OPTIONS . " where products_options_id = '" . (int)$options_id . "' and language_id = '" . (int)$languages_id . "'");
    $options_values = tep_db_fetch_array($options);

    return $options_values['products_options_name'];
  }

  function tep_values_name($values_id) {
    global $languages_id;

    $values = tep_db_query("select products_options_values_name from " . TABLE_PRODUCTS_OPTIONS_VALUES . " where products_options_values_id = '" . (int)$values_id . "' and language_id = '" . (int)$languages_id . "'");
    $values_values = tep_db_fetch_array($values);

    return $values_values['products_options_values_name'];
  }

  function tep_info_image($image, $alt, $width = '', $height = '') {
    if (tep_not_null($image) && (file_exists(DIR_FS_CATALOG_IMAGES . $image)) ) {
      $image = tep_image(DIR_WS_CATALOG_IMAGES . $image, $alt, $width, $height);
    } else {
      $image = TEXT_IMAGE_NONEXISTENT;
    }

    return $image;
  }

  function tep_break_string($string, $len, $break_char = '-') {
    $l = 0;
    $output = '';
    for ($i=0, $n=strlen($string); $i<$n; $i++) {
      $char = substr($string, $i, 1);
      if ($char != ' ') {
        $l++;
      } else {
        $l = 0;
      }
      if ($l > $len) {
        $l = 1;
        $output .= $break_char;
      }
      $output .= $char;
    }

    return $output;
  }

  function tep_get_country_name($country_id) {
    $country_query = tep_db_query("select countries_name from " . TABLE_COUNTRIES . " where countries_id = '" . (int)$country_id . "'");

    if (!tep_db_num_rows($country_query)) {
      return $country_id;
    } else {
      $country = tep_db_fetch_array($country_query);
      return $country['countries_name'];
    }
  }

  function tep_get_zone_name($country_id, $zone_id, $default_zone) {
    $zone_query = tep_db_query("select zone_name from " . TABLE_ZONES . " where zone_country_id = '" . (int)$country_id . "' and zone_id = '" . (int)$zone_id . "'");
    if (tep_db_num_rows($zone_query)) {
      $zone = tep_db_fetch_array($zone_query);
      return $zone['zone_name'];
    } else {
      return $default_zone;
    }
  }

  function tep_not_null($value) {
    if (is_array($value)) {
      if (sizeof($value) > 0) {
        return true;
      } else {
        return false;
      }
    } else {
      if ( (is_string($value) || is_int($value)) && ($value != '') && ($value != 'NULL') && (strlen(trim($value)) > 0)) {
        return true;
      } else {
        return false;
      }
    }
  }

  function tep_browser_detect($component) {
    global $HTTP_USER_AGENT;

    return stristr($HTTP_USER_AGENT, $component);
  }

  function tep_tax_classes_pull_down($parameters, $selected = '') {
    $select_string = '<select ' . $parameters . '>';
    $classes_query = tep_db_query("select tax_class_id, tax_class_title from " . TABLE_TAX_CLASS . " order by tax_class_title");
    while ($classes = tep_db_fetch_array($classes_query)) {
      $select_string .= '<option value="' . $classes['tax_class_id'] . '"';
      if ($selected == $classes['tax_class_id']) $select_string .= ' SELECTED';
      $select_string .= '>' . $classes['tax_class_title'] . '</option>';
    }
    $select_string .= '</select>';

    return $select_string;
  }

  function tep_geo_zones_pull_down($parameters, $selected = '') {
    $select_string = '<select ' . $parameters . '>';
    $zones_query = tep_db_query("select geo_zone_id, geo_zone_name from " . TABLE_GEO_ZONES . " order by geo_zone_name");
    while ($zones = tep_db_fetch_array($zones_query)) {
      $select_string .= '<option value="' . $zones['geo_zone_id'] . '"';
      if ($selected == $zones['geo_zone_id']) $select_string .= ' SELECTED';
      $select_string .= '>' . $zones['geo_zone_name'] . '</option>';
    }
    $select_string .= '</select>';

    return $select_string;
  }

  function tep_get_geo_zone_name($geo_zone_id) {
    $zones_query = tep_db_query("select geo_zone_name from " . TABLE_GEO_ZONES . " where geo_zone_id = '" . (int)$geo_zone_id . "'");

    if (!tep_db_num_rows($zones_query)) {
      $geo_zone_name = $geo_zone_id;
    } else {
      $zones = tep_db_fetch_array($zones_query);
      $geo_zone_name = $zones['geo_zone_name'];
    }

    return $geo_zone_name;
  }

  function tep_address_format($address_format_id, $address, $html, $boln, $eoln) {
    $address_format_query = tep_db_query("select address_format as format from " . TABLE_ADDRESS_FORMAT . " where address_format_id = '" . (int)$address_format_id . "'");
    $address_format = tep_db_fetch_array($address_format_query);

    $company = tep_output_string_protected($address['company']);
    if (isset($address['firstname']) && tep_not_null($address['firstname'])) {
      $firstname = tep_output_string_protected($address['firstname']);
      $lastname = tep_output_string_protected($address['lastname']);
    } elseif (isset($address['name']) && tep_not_null($address['name'])) {
      $firstname = tep_output_string_protected($address['name']);
      $lastname = '';
    } else {
      $firstname = '';
      $lastname = '';
    }
    $street = tep_output_string_protected($address['street_address']);
    $suburb = tep_output_string_protected($address['suburb']);
    $city = tep_output_string_protected($address['city']);
    $state = tep_output_string_protected($address['state']);
    if (isset($address['country_id']) && tep_not_null($address['country_id'])) {
      $country = tep_get_country_name($address['country_id']);

      if (isset($address['zone_id']) && tep_not_null($address['zone_id'])) {
        $state = tep_get_zone_code($address['country_id'], $address['zone_id'], $state);
      }
    } elseif (isset($address['country']) && tep_not_null($address['country'])) {
      $country = tep_output_string_protected($address['country']);
    } else {
      $country = '';
    }
    $postcode = tep_output_string_protected($address['postcode']);
    $zip = $postcode;

    if ($html) {
// HTML Mode
      $HR = '<hr>';
      $hr = '<hr>';
      if ( ($boln == '') && ($eoln == "\n") ) { // Values not specified, use rational defaults
        $CR = '<br>';
        $cr = '<br>';
        $eoln = $cr;
      } else { // Use values supplied
        $CR = $eoln . $boln;
        $cr = $CR;
      }
    } else {
// Text Mode
      $CR = $eoln;
      $cr = $CR;
      $HR = '----------------------------------------';
      $hr = '----------------------------------------';
    }

    $statecomma = '';
    $streets = $street;
    if ($suburb != '') $streets = $street . $cr . $suburb;
    if ($country == '') $country = tep_output_string_protected($address['country']);
    if ($state != '') $statecomma = $state . ', ';

    $fmt = $address_format['format'];
    eval("\$address = \"$fmt\";");

    if ( (ACCOUNT_COMPANY == 'true') && (tep_not_null($company)) ) {
      $address = $company . $cr . $address;
    }

    return $address;
  }

  ////////////////////////////////////////////////////////////////////////////////////////////////
  //
  // Function    : tep_get_zone_code
  //
  // Arguments   : country           country code string
  //               zone              state/province zone_id
  //               def_state         default string if zone==0
  //
  // Return      : state_prov_code   state/province code
  //
  // Description : Function to retrieve the state/province code (as in FL for Florida etc)
  //
  ////////////////////////////////////////////////////////////////////////////////////////////////
  function tep_get_zone_code($country, $zone, $def_state) {

    $state_prov_query = tep_db_query("select zone_code from " . TABLE_ZONES . " where zone_country_id = '" . (int)$country . "' and zone_id = '" . (int)$zone . "'");

    if (!tep_db_num_rows($state_prov_query)) {
      $state_prov_code = $def_state;
    }
    else {
      $state_prov_values = tep_db_fetch_array($state_prov_query);
      $state_prov_code = $state_prov_values['zone_code'];
    }
    
    return $state_prov_code;
  }

  function tep_get_uprid($prid, $params) {
    $uprid = $prid;
    if ( (is_array($params)) && (!strstr($prid, '{')) ) {
      while (list($option, $value) = each($params)) {
        $uprid = $uprid . '{' . $option . '}' . $value;
      }
    }

    return $uprid;
  }

  function tep_get_prid($uprid) {
    $pieces = explode('{', $uprid);

    return $pieces[0];
  }

  function tep_get_languages() {
    $languages_query = tep_db_query("select languages_id, name, code, image, directory from " . TABLE_LANGUAGES . " order by sort_order");
    while ($languages = tep_db_fetch_array($languages_query)) {
      $languages_array[] = array('id' => $languages['languages_id'],
                                 'name' => $languages['name'],
                                 'code' => $languages['code'],
                                 'image' => $languages['image'],
                                 'directory' => $languages['directory']);
    }

    return $languages_array;
  }

  function tep_get_category_name($category_id, $language_id) {
    $category_query = tep_db_query("select categories_name from " . TABLE_CATEGORIES_DESCRIPTION . " where categories_id = '" . (int)$category_id . "' and language_id = '" . (int)$language_id . "'");
    $category = tep_db_fetch_array($category_query);

    return $category['categories_name'];
  }

function tep_get_category_yandex_name($category_id, $language_id) {
    $category_query = tep_db_query("select categories_yandex_name from " . TABLE_CATEGORIES_DESCRIPTION . " where categories_id = '" . (int)$category_id . "' and language_id = '" . (int)$language_id . "'");
    $category = tep_db_fetch_array($category_query);

    return $category['categories_yandex_name'];
}

  function tep_get_orders_status_name($orders_status_id, $language_id = '') {
    global $languages_id;

    if (!$language_id) $language_id = $languages_id;
    $orders_status_query = tep_db_query("select orders_status_name from " . TABLE_ORDERS_STATUS . " where orders_status_id = '" . (int)$orders_status_id . "' and language_id = '" . (int)$language_id . "'");
    $orders_status = tep_db_fetch_array($orders_status_query);

    return $orders_status['orders_status_name'];
  }

  function tep_get_orders_status() {
    global $languages_id;

    $orders_status_array = array();
    $orders_status_query = tep_db_query("select orders_status_id, orders_status_name from " . TABLE_ORDERS_STATUS . " where language_id = '" . (int)$languages_id . "' order by orders_status_id");
    while ($orders_status = tep_db_fetch_array($orders_status_query)) {
      $orders_status_array[] = array('id' => $orders_status['orders_status_id'],
                                     'text' => $orders_status['orders_status_name']);
    }

    return $orders_status_array;
  }

  function tep_get_products_name($product_id, $language_id = 0) {
    global $languages_id;

    if ($language_id == 0) $language_id = $languages_id;
    $product_query = tep_db_query("select products_name from " . TABLE_PRODUCTS_DESCRIPTION . " where products_id = '" . (int)$product_id . "' and language_id = '" . (int)$language_id . "'");
    $product = tep_db_fetch_array($product_query);

    return $product['products_name'];
  }

  function tep_get_products_info($product_id, $language_id) {
    $product_query = tep_db_query("select products_info from " . TABLE_PRODUCTS_DESCRIPTION . " where products_id = '" . (int)$product_id . "' and language_id = '" . (int)$language_id . "'");
    $product = tep_db_fetch_array($product_query);

    return $product['products_info'];
  }


  function tep_get_infobox_file_name($infobox_id, $language_id = 0) {
    global $languages_id;

    if ($language_id == 0) $language_id = $languages_id;
    $infobox_query = tep_db_query("select infobox_file_name from " . TABLE_INFOBOX_CONFIGURATION . " where infobox_id = '" . (int)$infobox_id . "' and language_id = '" . (int)$language_id . "'");
    $infobox = tep_db_fetch_array($infobox_query);

    return $infobox['infobox_file_name'];
  }

  function tep_get_products_description($product_id, $language_id) {
    $product_query = tep_db_query("select products_description from " . TABLE_PRODUCTS_DESCRIPTION . " where products_id = '" . (int)$product_id . "' and language_id = '" . (int)$language_id . "'");
    $product = tep_db_fetch_array($product_query);

    return $product['products_description'];
  }

  function tep_get_products_head_title_tag($product_id, $language_id) {
    $product_query = tep_db_query("select products_head_title_tag from " . TABLE_PRODUCTS_DESCRIPTION . " where products_id = '" . (int)$product_id . "' and language_id = '" . (int)$language_id . "'");
    $product = tep_db_fetch_array($product_query);

    return $product['products_head_title_tag'];
  }

  function tep_get_products_head_desc_tag($product_id, $language_id) {
    $product_query = tep_db_query("select products_head_desc_tag from " . TABLE_PRODUCTS_DESCRIPTION . " where products_id = '" . (int)$product_id . "' and language_id = '" . (int)$language_id . "'");
    $product = tep_db_fetch_array($product_query);

    return $product['products_head_desc_tag'];
  }

  function tep_get_products_head_keywords_tag($product_id, $language_id) {
    $product_query = tep_db_query("select products_head_keywords_tag from " . TABLE_PRODUCTS_DESCRIPTION . " where products_id = '" . (int)$product_id . "' and language_id = '" . (int)$language_id . "'");
    $product = tep_db_fetch_array($product_query);

    return $product['products_head_keywords_tag'];
  }

  function tep_get_products_url($product_id, $language_id) {
    $product_query = tep_db_query("select products_url from " . TABLE_PRODUCTS_DESCRIPTION . " where products_id = '" . (int)$product_id . "' and language_id = '" . (int)$language_id . "'");
    $product = tep_db_fetch_array($product_query);

    return $product['products_url'];
  }

////
// Return the manufacturers URL in the needed language
// TABLES: manufacturers_info
  function tep_get_manufacturer_url($manufacturer_id, $language_id) {
    $manufacturer_query = tep_db_query("select manufacturers_url from " . TABLE_MANUFACTURERS_INFO . " where manufacturers_id = '" . (int)$manufacturer_id . "' and languages_id = '" . (int)$language_id . "'");
    $manufacturer = tep_db_fetch_array($manufacturer_query);

    return $manufacturer['manufacturers_url'];
  }

////
// Wrapper for class_exists() function
// This function is not available in all PHP versions so we test it before using it.
  function tep_class_exists($class_name) {
    if (function_exists('class_exists')) {
      return class_exists($class_name);
    } else {
      return true;
    }
  }

////
// Count how many products exist in a category
// TABLES: products, products_to_categories, categories
  function tep_products_in_category_count($categories_id, $include_deactivated = false) {
    $products_count = 0;

    if ($include_deactivated) {
      $products_query = tep_db_query("select count(*) as total from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c where p.products_id = p2c.products_id and p2c.categories_id = '" . (int)$categories_id . "'");
    } else {
      $products_query = tep_db_query("select count(*) as total from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c where p.products_id = p2c.products_id and p.products_status = '1' and p2c.categories_id = '" . (int)$categories_id . "'");
    }

    $products = tep_db_fetch_array($products_query);

    $products_count += $products['total'];

    $childs_query = tep_db_query("select categories_id from " . TABLE_CATEGORIES . " where parent_id = '" . (int)$categories_id . "'");
    if (tep_db_num_rows($childs_query)) {
      while ($childs = tep_db_fetch_array($childs_query)) {
        $products_count += tep_products_in_category_count($childs['categories_id'], $include_deactivated);
      }
    }

    return $products_count;
  }

////
// Count how many subcategories exist in a category
// TABLES: categories
  function tep_childs_in_category_count($categories_id) {
    $categories_count = 0;

    $categories_query = tep_db_query("select categories_id from " . TABLE_CATEGORIES . " where parent_id = '" . (int)$categories_id . "'");
    while ($categories = tep_db_fetch_array($categories_query)) {
      $categories_count++;
      $categories_count += tep_childs_in_category_count($categories['categories_id']);
    }

    return $categories_count;
  }

////
// Returns an array with countries
// TABLES: countries
  function tep_get_countries($default = '') {
    $countries_array = array();
    if ($default) {
      $countries_array[] = array('id' => '',
                                 'text' => $default);
    }
    $countries_query = tep_db_query("select countries_id, countries_name from " . TABLE_COUNTRIES . " order by countries_name");
    while ($countries = tep_db_fetch_array($countries_query)) {
      $countries_array[] = array('id' => $countries['countries_id'],
                                 'text' => $countries['countries_name']);
    }

    return $countries_array;
  }

////
// return an array with country zones
  function tep_get_country_zones($country_id) {
    $zones_array = array();
    $zones_query = tep_db_query("select zone_id, zone_name from " . TABLE_ZONES . " where zone_country_id = '" . (int)$country_id . "' order by zone_name");
    while ($zones = tep_db_fetch_array($zones_query)) {
      $zones_array[] = array('id' => $zones['zone_id'],
                             'text' => $zones['zone_name']);
    }

    return $zones_array;
  }

  function tep_prepare_country_zones_pull_down($country_id = '') {
// preset the width of the drop-down for Netscape
    $pre = '';
    if ( (!tep_browser_detect('MSIE')) && (tep_browser_detect('Mozilla/4')) ) {
      for ($i=0; $i<45; $i++) $pre .= '&nbsp;';
    }

    $zones = tep_get_country_zones($country_id);

    if (sizeof($zones) > 0) {
      $zones_select = array(array('id' => '', 'text' => PLEASE_SELECT));
      $zones = array_merge($zones_select, $zones);
    } else {
      $zones = array(array('id' => '', 'text' => TYPE_BELOW));
// create dummy options for Netscape to preset the height of the drop-down
      if ( (!tep_browser_detect('MSIE')) && (tep_browser_detect('Mozilla/4')) ) {
        for ($i=0; $i<9; $i++) {
          $zones[] = array('id' => '', 'text' => $pre);
        }
      }
    }

    return $zones;
  }

////
// Get list of address_format_id's
  function tep_get_address_formats() {
    $address_format_query = tep_db_query("select address_format_id from " . TABLE_ADDRESS_FORMAT . " order by address_format_id");
    $address_format_array = array();
    while ($address_format_values = tep_db_fetch_array($address_format_query)) {
      $address_format_array[] = array('id' => $address_format_values['address_format_id'],
                                      'text' => $address_format_values['address_format_id']);
    }
    return $address_format_array;
  }

////
// Alias function for Store configuration values in the Administration Tool
  function tep_cfg_pull_down_country_list($country_id) {
    return tep_draw_pull_down_menu('configuration_value', tep_get_countries(), $country_id);
  }

  function tep_cfg_pull_down_zone_list($zone_id) {
    return tep_draw_pull_down_menu('configuration_value', tep_get_country_zones(STORE_COUNTRY), $zone_id);
  }

  function tep_cfg_pull_down_tax_classes($tax_class_id, $key = '') {
    $name = (($key) ? 'configuration[' . $key . ']' : 'configuration_value');

    $tax_class_array = array(array('id' => '0', 'text' => TEXT_NONE));
    $tax_class_query = tep_db_query("select tax_class_id, tax_class_title from " . TABLE_TAX_CLASS . " order by tax_class_title");
    while ($tax_class = tep_db_fetch_array($tax_class_query)) {
      $tax_class_array[] = array('id' => $tax_class['tax_class_id'],
                                 'text' => $tax_class['tax_class_title']);
    }

    return tep_draw_pull_down_menu($name, $tax_class_array, $tax_class_id);
  }

////
// Function to read in text area in admin
 function tep_cfg_textarea($text) {
    return tep_draw_textarea_field('configuration_value', false, 35, 5, $text);
  }

  function tep_cfg_get_zone_name($zone_id) {
    $zone_query = tep_db_query("select zone_name from " . TABLE_ZONES . " where zone_id = '" . (int)$zone_id . "'");

    if (!tep_db_num_rows($zone_query)) {
      return $zone_id;
    } else {
      $zone = tep_db_fetch_array($zone_query);
      return $zone['zone_name'];
    }
  }

////
// Sets the status of a banner
  function tep_set_banner_status($banners_id, $status) {
    if ($status == '1') {
      return tep_db_query("update " . TABLE_BANNERS . " set status = '1', expires_impressions = NULL, expires_date = NULL, date_status_change = NULL where banners_id = '" . $banners_id . "'");
    } elseif ($status == '0') {
      return tep_db_query("update " . TABLE_BANNERS . " set status = '0', date_status_change = now() where banners_id = '" . $banners_id . "'");
    } else {
      return -1;
    }
  }

////
// Sets the status of a product
  function tep_set_product_status($products_id, $status) {
    if ($status == '1') {
      return tep_db_query("update " . TABLE_PRODUCTS . " set products_status = '1', products_last_modified = now() where products_id = '" . (int)$products_id . "'");
    } elseif ($status == '0') {
      return tep_db_query("update " . TABLE_PRODUCTS . " set products_status = '0', products_last_modified = now() where products_id = '" . (int)$products_id . "'");
    } else {
      return -1;
    }
  }

function tep_try_upload($file = '', $destination = '', $permissions = '777', $extensions = '') {
	$file_object = new upload($file, $destination, $permissions, $extensions);
	if ($file_object->filename != '')
		return $file_object;
	else
		return false;
}

////
// Sets the status of a product to XML
  function tep_set_product_xml($products_id, $status) {
    if ($status == '1') {
      return tep_db_query("update " . TABLE_PRODUCTS . " set products_to_xml = '1', products_last_modified = now() where products_id = '" . (int)$products_id . "'");
    } elseif ($status == '0') {
      return tep_db_query("update " . TABLE_PRODUCTS . " set products_to_xml = '0', products_last_modified = now() where products_id = '" . (int)$products_id . "'");
    } else {
      return -1;
    }
  }

////
// Sets the status of a product on special
  function tep_set_specials_status($specials_id, $status) {
    if ($status == '1') {
      return tep_db_query("update " . TABLE_SPECIALS . " set status = '1', expires_date = NULL, date_status_change = NULL where specials_id = '" . (int)$specials_id . "'");
    } elseif ($status == '0') {
      return tep_db_query("update " . TABLE_SPECIALS . " set status = '0', date_status_change = now() where specials_id = '" . (int)$specials_id . "'");
    } else {
      return -1;
    }
  }

////
// Sets timeout for the current script.
// Cant be used in safe mode.
  function tep_set_time_limit($limit) {
    if (!get_cfg_var('safe_mode')) {
      set_time_limit($limit);
    }
  }

////
// Alias function for Store configuration values in the Administration Tool
  function tep_cfg_select_option($select_array, $key_value, $key = '') {
    $string = '';

    for ($i=0, $n=sizeof($select_array); $i<$n; $i++) {
      $name = ((tep_not_null($key)) ? 'configuration[' . $key . ']' : 'configuration_value');

      $string .= '<br><input type="radio" name="' . $name . '" value="' . $select_array[$i] . '"';

      if ($key_value == $select_array[$i]) $string .= ' CHECKED';

      $string .= '> ' . $select_array[$i];
    }

    return $string;
  }

////
// Alias function for module configuration keys
  function tep_mod_select_option($select_array, $key_name, $key_value) {
    reset($select_array);
    while (list($key, $value) = each($select_array)) {
      if (is_int($key)) $key = $value;
      $string .= '<br><input type="radio" name="configuration[' . $key_name . ']" value="' . $key . '"';
      if ($key_value == $key) $string .= ' CHECKED';
      $string .= '> ' . $value;
    }

    return $string;
  }


////
// Retreive server information
  function tep_get_system_information() {
    global $db_link, $_SERVER;

    $db_query = tep_db_query("select now() as datetime");
    $db = tep_db_fetch_array($db_query);

    list($system, $host, $kernel) = preg_split('/[\s,]+/', @exec('uname -a'), 5);

    return array('version' => (function_exists('mysqli_get_server_info') ? mysqli_get_server_info($db_link) : ''),
                 'date' => tep_datetime_short(date('Y-m-d H:i:s')),
                 'system' => $system,
                 'kernel' => $kernel,
                 'host' => $host,
                 'ip' => gethostbyname($host),
                 'uptime' => @exec('uptime'),
                 'http_server' => $_SERVER['SERVER_SOFTWARE'],
                 'php' => PHP_VERSION,
                 'zend' => (function_exists('zend_version') ? zend_version() : ''),
                 'db_server' => DB_SERVER,
                 'db_ip' => gethostbyname(DB_SERVER),
                 'db_version' => 'MySQL ' . (function_exists('mysqli_get_server_info') ? mysqli_get_server_info($db_link) : ''),
                 'db_date' => tep_datetime_short($db['datetime']));
  }

  function tep_generate_category_path($id, $from = 'category', $categories_array = '', $index = 0) {
    global $languages_id;

    if (!is_array($categories_array)) $categories_array = array();

    if ($from == 'product') {
      $categories_query = tep_db_query("select categories_id from " . TABLE_PRODUCTS_TO_CATEGORIES . " where products_id = '" . (int)$id . "'");
      while ($categories = tep_db_fetch_array($categories_query)) {
        if ($categories['categories_id'] == '0') {
          $categories_array[$index][] = array('id' => '0', 'text' => TEXT_TOP);
        } else {
          $category_query = tep_db_query("select cd.categories_name, c.parent_id from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd where c.categories_id = '" . (int)$categories['categories_id'] . "' and c.categories_id = cd.categories_id and cd.language_id = '" . (int)$languages_id . "'");
          $category = tep_db_fetch_array($category_query);
          $categories_array[$index][] = array('id' => $categories['categories_id'], 'text' => $category['categories_name']);
          if ( (tep_not_null($category['parent_id'])) && ($category['parent_id'] != '0') ) $categories_array = tep_generate_category_path($category['parent_id'], 'category', $categories_array, $index);
          $categories_array[$index] = array_reverse($categories_array[$index]);
        }
        $index++;
      }
    } elseif ($from == 'category') {
      $category_query = tep_db_query("select cd.categories_name, c.parent_id from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd where c.categories_id = '" . (int)$id . "' and c.categories_id = cd.categories_id and cd.language_id = '" . (int)$languages_id . "'");
      $category = tep_db_fetch_array($category_query);
      $categories_array[$index][] = array('id' => $id, 'text' => $category['categories_name']);
      if ( (tep_not_null($category['parent_id'])) && ($category['parent_id'] != '0') ) $categories_array = tep_generate_category_path($category['parent_id'], 'category', $categories_array, $index);
    }

    return $categories_array;
  }

  function tep_output_generated_category_path($id, $from = 'category') {
    $calculated_category_path_string = '';
    $calculated_category_path = tep_generate_category_path($id, $from);
    for ($i=0, $n=sizeof($calculated_category_path); $i<$n; $i++) {
      for ($j=0, $k=sizeof($calculated_category_path[$i]); $j<$k; $j++) {
        $calculated_category_path_string .= $calculated_category_path[$i][$j]['text'] . '&nbsp;&gt;&nbsp;';
      }
      $calculated_category_path_string = substr($calculated_category_path_string, 0, -16) . '<br>';
    }
    $calculated_category_path_string = substr($calculated_category_path_string, 0, -4);

    if (strlen($calculated_category_path_string) < 1) $calculated_category_path_string = TEXT_TOP;

    return $calculated_category_path_string;
  }

  function tep_get_generated_category_path_ids($id, $from = 'category') {
    $calculated_category_path_string = '';
    $calculated_category_path = tep_generate_category_path($id, $from);
    for ($i=0, $n=sizeof($calculated_category_path); $i<$n; $i++) {
      for ($j=0, $k=sizeof($calculated_category_path[$i]); $j<$k; $j++) {
        $calculated_category_path_string .= $calculated_category_path[$i][$j]['id'] . '_';
      }
      $calculated_category_path_string = substr($calculated_category_path_string, 0, -1) . '<br>';
    }
    $calculated_category_path_string = substr($calculated_category_path_string, 0, -4);

    if (strlen($calculated_category_path_string) < 1) $calculated_category_path_string = TEXT_TOP;

    return $calculated_category_path_string;
  }

  function tep_remove_category($category_id) {
    $category_image_query = tep_db_query("select categories_image from " . TABLE_CATEGORIES . " where categories_id = '" . (int)$category_id . "'");
    $category_image = tep_db_fetch_array($category_image_query);

    $duplicate_image_query = tep_db_query("select count(*) as total from " . TABLE_CATEGORIES . " where categories_image = '" . tep_db_input($category_image['categories_image']) . "'");
    $duplicate_image = tep_db_fetch_array($duplicate_image_query);

    if ($duplicate_image['total'] < 2) {
      if (file_exists(DIR_FS_CATALOG_IMAGES . $category_image['categories_image'])) {
        @unlink(DIR_FS_CATALOG_IMAGES . $category_image['categories_image']);
      }
    }

    tep_db_query("delete from " . TABLE_CATEGORIES . " where categories_id = '" . (int)$category_id . "'");
    tep_db_query("delete from " . TABLE_CATEGORIES_DESCRIPTION . " where categories_id = '" . (int)$category_id . "'");
    tep_db_query("delete from " . TABLE_PRODUCTS_TO_CATEGORIES . " where categories_id = '" . (int)$category_id . "'");

    if (USE_CACHE == 'true') {
      tep_reset_cache_block('categories');
      tep_reset_cache_block('also_purchased');
    }
  }

  function tep_remove_product($product_id) {
    $product_image_query = tep_db_query("select products_image from " . TABLE_PRODUCTS . " where products_id = '" . (int)$product_id . "'");
    $product_image = tep_db_fetch_array($product_image_query);

    $duplicate_image_query = tep_db_query("select count(*) as total from " . TABLE_PRODUCTS . " where products_image = '" . tep_db_input($product_image['products_image']) . "'");
    $duplicate_image = tep_db_fetch_array($duplicate_image_query);

    if ($duplicate_image['total'] < 2) {
      if (file_exists(DIR_FS_CATALOG_IMAGES . $product_image['products_image'])) {
        @unlink(DIR_FS_CATALOG_IMAGES . $product_image['products_image']);
      }
    }

    $product_image_med_query = tep_db_query("select products_image_med from " . TABLE_PRODUCTS . " where products_id = '" . (int)$product_id . "'");
    $product_image_med = tep_db_fetch_array($product_image_med_query);

    $duplicate_image_med_query = tep_db_query("select count(*) as total from " . TABLE_PRODUCTS . " where products_image_med = '" . tep_db_input($product_image_med['products_image_med']) . "'");
    $duplicate_image_med = tep_db_fetch_array($duplicate_image_med_query);

    if ($duplicate_image_med['total'] < 2) {
      if (file_exists(DIR_FS_CATALOG_IMAGES . $product_image_med['products_image_med'])) {
        @unlink(DIR_FS_CATALOG_IMAGES . $product_image_med['products_image_med']);
      }
    }

    $product_image_lrg_query = tep_db_query("select products_image_lrg from " . TABLE_PRODUCTS . " where products_id = '" . (int)$product_id . "'");
    $product_image_lrg = tep_db_fetch_array($product_image_lrg_query);

    $duplicate_image_lrg_query = tep_db_query("select count(*) as total from " . TABLE_PRODUCTS . " where products_image_lrg = '" . tep_db_input($product_image_lrg['products_image_lrg']) . "'");
    $duplicate_image_lrg = tep_db_fetch_array($duplicate_image_lrg_query);

    if ($duplicate_image_lrg['total'] < 2) {
      if (file_exists(DIR_FS_CATALOG_IMAGES . $product_image_lrg['products_image_lrg'])) {
        @unlink(DIR_FS_CATALOG_IMAGES . $product_image_lrg['products_image_lrg']);
      }
    }

    tep_db_query("delete from " . TABLE_SPECIALS . " where products_id = '" . (int)$product_id . "'");
    tep_db_query("delete from " . TABLE_PRODUCTS . " where products_id = '" . (int)$product_id . "'");
    tep_db_query("delete from " . TABLE_PRODUCTS_TO_CATEGORIES . " where products_id = '" . (int)$product_id . "'");
    tep_db_query("delete from " . TABLE_PRODUCTS_DESCRIPTION . " where products_id = '" . (int)$product_id . "'");
    tep_db_query("delete from " . TABLE_PRODUCTS_ATTRIBUTES . " where products_id = '" . (int)$product_id . "'");
    tep_db_query("delete from " . TABLE_CUSTOMERS_BASKET . " where products_id = '" . (int)$product_id . "' or products_id like '" . (int)$product_id . "{%'"); 
    tep_db_query("delete from " . TABLE_CUSTOMERS_BASKET_ATTRIBUTES . " where products_id = '" . (int)$product_id . "' or products_id like '" . (int)$product_id . "{%'"); 

// START: Extra Fields Contribution
    tep_db_query("delete from " . TABLE_PRODUCTS_TO_PRODUCTS_EXTRA_FIELDS . " where products_id = " . (int)$product_id);
    // END: Extra Fields Contribution

//Wishlist addition to delete products from the wishlist when deleted
    tep_db_query("delete from " . TABLE_WISHLIST . " where products_id = '" . (int)$product_id . "'");
    tep_db_query("delete from " . TABLE_WISHLIST_ATTRIBUTES . " where products_id = '" . (int)$product_id . "'");

    $product_reviews_query = tep_db_query("select reviews_id from " . TABLE_REVIEWS . " where products_id = '" . (int)$product_id . "'");
    while ($product_reviews = tep_db_fetch_array($product_reviews_query)) {
      tep_db_query("delete from " . TABLE_REVIEWS_DESCRIPTION . " where reviews_id = '" . (int)$product_reviews['reviews_id'] . "'");
    }
    tep_db_query("delete from " . TABLE_REVIEWS . " where products_id = '" . (int)$product_id . "'");

    if (USE_CACHE == 'true') {
      tep_reset_cache_block('categories');
      tep_reset_cache_block('also_purchased');
    }
  }

  function tep_remove_order($order_id, $restock = false) {
    if ($restock == 'on') {
      $order_query = tep_db_query("select products_id, products_quantity from " . TABLE_ORDERS_PRODUCTS . " where orders_id = '" . (int)$order_id . "'");
      while ($order = tep_db_fetch_array($order_query)) {
        tep_db_query("update " . TABLE_PRODUCTS . " set products_quantity = products_quantity + " . $order['products_quantity'] . ", products_ordered = products_ordered - " . $order['products_quantity'] . " where products_id = '" . (int)$order['products_id'] . "'");
      }
    }

    tep_db_query("delete from " . TABLE_ORDERS . " where orders_id = '" . (int)$order_id . "'");
    tep_db_query("delete from " . TABLE_ORDERS_PRODUCTS . " where orders_id = '" . (int)$order_id . "'");
    tep_db_query("delete from " . TABLE_ORDERS_PRODUCTS_ATTRIBUTES . " where orders_id = '" . (int)$order_id . "'");
    tep_db_query("delete from " . TABLE_ORDERS_STATUS_HISTORY . " where orders_id = '" . (int)$order_id . "'");
    tep_db_query("delete from " . TABLE_ORDERS_TOTAL . " where orders_id = '" . (int)$order_id . "'");
  }

  function tep_reset_cache_block($cache_block) {
    global $cache_blocks;

    for ($i=0, $n=sizeof($cache_blocks); $i<$n; $i++) {
      if ($cache_blocks[$i]['code'] == $cache_block) {
        if ($cache_blocks[$i]['multiple']) {
          if ($dir = @opendir(DIR_FS_CACHE)) {
            while ($cache_file = readdir($dir)) {
              $cached_file = $cache_blocks[$i]['file'];
              $languages = tep_get_languages();
              for ($j=0, $k=sizeof($languages); $j<$k; $j++) {
                $cached_file_unlink = preg_replace('/-language/', '-' . $languages[$j]['directory'], $cached_file);
                if (preg_match('/^' . $cached_file_unlink.'/', $cache_file)) {
                  @unlink(DIR_FS_CACHE . $cache_file);
                }
              }
            }
            closedir($dir);
          }
        } else {
          $cached_file = $cache_blocks[$i]['file'];
          $languages = tep_get_languages();
          for ($i=0, $n=sizeof($languages); $i<$n; $i++) {
            $cached_file = preg_replace('/-language/', '-' . $languages[$i]['directory'], $cached_file);
            @unlink(DIR_FS_CACHE . $cached_file);
          }
        }
        break;
      }
    }
  }

  function tep_get_file_permissions($mode) {
// determine type
    if ( ($mode & 0xC000) == 0xC000) { // unix domain socket
      $type = 's';
    } elseif ( ($mode & 0x4000) == 0x4000) { // directory
      $type = 'd';
    } elseif ( ($mode & 0xA000) == 0xA000) { // symbolic link
      $type = 'l';
    } elseif ( ($mode & 0x8000) == 0x8000) { // regular file
      $type = '-';
    } elseif ( ($mode & 0x6000) == 0x6000) { //bBlock special file
      $type = 'b';
    } elseif ( ($mode & 0x2000) == 0x2000) { // character special file
      $type = 'c';
    } elseif ( ($mode & 0x1000) == 0x1000) { // named pipe
      $type = 'p';
    } else { // unknown
      $type = '?';
    }

// determine permissions
    $owner['read']    = ($mode & 00400) ? 'r' : '-';
    $owner['write']   = ($mode & 00200) ? 'w' : '-';
    $owner['execute'] = ($mode & 00100) ? 'x' : '-';
    $group['read']    = ($mode & 00040) ? 'r' : '-';
    $group['write']   = ($mode & 00020) ? 'w' : '-';
    $group['execute'] = ($mode & 00010) ? 'x' : '-';
    $world['read']    = ($mode & 00004) ? 'r' : '-';
    $world['write']   = ($mode & 00002) ? 'w' : '-';
    $world['execute'] = ($mode & 00001) ? 'x' : '-';

// adjust for SUID, SGID and sticky bit
    if ($mode & 0x800 ) $owner['execute'] = ($owner['execute'] == 'x') ? 's' : 'S';
    if ($mode & 0x400 ) $group['execute'] = ($group['execute'] == 'x') ? 's' : 'S';
    if ($mode & 0x200 ) $world['execute'] = ($world['execute'] == 'x') ? 't' : 'T';

    return $type .
           $owner['read'] . $owner['write'] . $owner['execute'] .
           $group['read'] . $group['write'] . $group['execute'] .
           $world['read'] . $world['write'] . $world['execute'];
  }

  function tep_remove($source) {
    global $messageStack, $tep_remove_error;

    if (isset($tep_remove_error)) $tep_remove_error = false;

    if (is_dir($source)) {
      $dir = dir($source);
      while ($file = $dir->read()) {
        if ( ($file != '.') && ($file != '..') ) {
          if (is_writeable($source . '/' . $file)) {
            tep_remove($source . '/' . $file);
          } else {
            $messageStack->add(sprintf(ERROR_FILE_NOT_REMOVEABLE, $source . '/' . $file), 'error');
            $tep_remove_error = true;
          }
        }
      }
      $dir->close();

      if (is_writeable($source)) {
        rmdir($source);
      } else {
        $messageStack->add(sprintf(ERROR_DIRECTORY_NOT_REMOVEABLE, $source), 'error');
        $tep_remove_error = true;
      }
    } else {
      if (is_writeable($source)) {
        unlink($source);
      } else {
        $messageStack->add(sprintf(ERROR_FILE_NOT_REMOVEABLE, $source), 'error');
        $tep_remove_error = true;
      }
    }
  }

////
// Output the tax percentage with optional padded decimals
  function tep_display_tax_value($value, $padding = TAX_DECIMAL_PLACES) {
    if (strpos($value, '.')) {
      $loop = true;
      while ($loop) {
        if (substr($value, -1) == '0') {
          $value = substr($value, 0, -1);
        } else {
          $loop = false;
          if (substr($value, -1) == '.') {
            $value = substr($value, 0, -1);
          }
        }
      }
    }

    if ($padding > 0) {
      if ($decimal_pos = strpos($value, '.')) {
        $decimals = strlen(substr($value, ($decimal_pos+1)));
        for ($i=$decimals; $i<$padding; $i++) {
          $value .= '0';
        }
      } else {
        $value .= '.';
        for ($i=0; $i<$padding; $i++) {
          $value .= '0';
        }
      }
    }

    return $value;
  }

  function tep_mail($to_name, $to_email_address, $email_subject, $email_text, $from_email_name, $from_email_address) {
    if (SEND_EMAILS != 'true') return false;
 
    // Instantiate a new mail object
    $message = new PHPMailer();

    $message->CharSet = CHARSET;
           
            if (EMAIL_TRANSPORT == 'smtp'){
                        $message->IsSMTP();
                        $message->SMTPKeepAlive = true;
                        $message->SMTPAuth = EMAIL_SMTP_AUTH;
                        $message->Username = EMAIL_SMTP_USERNAME;
                        $message->Password = EMAIL_SMTP_PASSWORD;
                        $message->Host = EMAIL_SMTP_SERVER; // SMTP server
                        $message->Port = EMAIL_SMTP_PORT;
            }else{
                        $message->IsMail(); // telling the class to use SMTP
            }
           
            // Config
           
            if( !tep_not_null($from_email_address) ) {
                        $from_email_address = SMTP_SENDMAIL_FROM;
            }
           
            $message->From = $from_email_address;
           
            if( !tep_not_null($from_email_name) ) {
                        $from_email_name = SMTP_FROMEMAIL_NAME;
            }
           
            $message->FromName = $from_email_name;
           
            if( !tep_not_null($to_name) ) {
                        $to_name = '';
            }
             
            if( !tep_not_null($to_email_address) ) {
                        return false;
            }
           
            $message->AddAddress($to_email_address, $to_name);
 
            $message->Subject = $email_subject;
 
    // Build the text version
    $text = strip_tags($email_text);
    if (EMAIL_USE_HTML == 'true') {
              $message->Body = tep_convert_linefeeds(array("\r\n", "\n", "\r"), '<br>', $email_text);
              $message->AltBody = $text;
              $message->IsHTML(true);
    } else {
              $message->Body = $text;
              $message->IsHTML(false);
    }

 

    // Send message
    if(!$message->Send()){
               /*echo 'Email was not sent.';
               echo 'Mailer error: ' . $message->ErrorInfo;*/
               return false;
            }
  }

  function tep_get_tax_class_title($tax_class_id) {
    if ($tax_class_id == '0') {
      return TEXT_NONE;
    } else {
      $classes_query = tep_db_query("select tax_class_title from " . TABLE_TAX_CLASS . " where tax_class_id = '" . (int)$tax_class_id . "'");
      $classes = tep_db_fetch_array($classes_query);

      return $classes['tax_class_title'];
    }
  }

  function tep_banner_image_extension() {
    if (function_exists('imagetypes')) {
      if (imagetypes() & IMG_PNG) {
        return 'png';
      } elseif (imagetypes() & IMG_JPG) {
        return 'jpg';
      } elseif (imagetypes() & IMG_GIF) {
        return 'gif';
      }
    } elseif (function_exists('imagecreatefrompng') && function_exists('imagepng')) {
      return 'png';
    } elseif (function_exists('imagecreatefromjpeg') && function_exists('imagejpeg')) {
      return 'jpg';
    } elseif (function_exists('imagecreatefromgif') && function_exists('imagegif')) {
      return 'gif';
    }

    return false;
  }

////
// Wrapper function for round() for php3 compatibility
  function tep_round($value, $precision) {
    if (PHP_VERSION < 4) {
      $exp = pow(10, $precision);
      return round($value * $exp) / $exp;
    } else {
      return round($value, (int)$precision);
    }
  }

////
// Add tax to a products price
  function tep_add_tax($price, $tax, $override = false) { 
    if ( ( (DISPLAY_PRICE_WITH_TAX == 'true') || ($override == true) ) && ($tax > 0) ) { 
      return $price + tep_calculate_tax($price, $tax); 
    } else {
      return $price; 
    }
  }

// Calculates Tax rounding the result
  function tep_calculate_tax($price, $tax) {
    return $price * $tax / 100; 
  }

////
// Returns the tax rate for a zone / class
// TABLES: tax_rates, zones_to_geo_zones
  function tep_get_tax_rate($class_id, $country_id = -1, $zone_id = -1) {
    global $customer_zone_id, $customer_country_id;

    if ( ($country_id == -1) && ($zone_id == -1) ) {
      if (!tep_session_is_registered('customer_id')) {
        $country_id = STORE_COUNTRY;
        $zone_id = STORE_ZONE;
      } else {
        $country_id = $customer_country_id;
        $zone_id = $customer_zone_id;
      }
    }

    $tax_query = tep_db_query("select SUM(tax_rate) as tax_rate from " . TABLE_TAX_RATES . " tr left join " . TABLE_ZONES_TO_GEO_ZONES . " za ON tr.tax_zone_id = za.geo_zone_id left join " . TABLE_GEO_ZONES . " tz ON tz.geo_zone_id = tr.tax_zone_id WHERE (za.zone_country_id IS NULL OR za.zone_country_id = '0' OR za.zone_country_id = '" . (int)$country_id . "') AND (za.zone_id IS NULL OR za.zone_id = '0' OR za.zone_id = '" . (int)$zone_id . "') AND tr.tax_class_id = '" . (int)$class_id . "' GROUP BY tr.tax_priority");
    if (tep_db_num_rows($tax_query)) {
      $tax_multiplier = 0;
      while ($tax = tep_db_fetch_array($tax_query)) {
        $tax_multiplier += $tax['tax_rate'];
      }
      return $tax_multiplier;
    } else {
      return 0;
    }
  }

////
// Returns the tax rate for a tax class
// TABLES: tax_rates
  function tep_get_tax_rate_value($class_id) {
    $tax_query = tep_db_query("select SUM(tax_rate) as tax_rate from " . TABLE_TAX_RATES . " where tax_class_id = '" . (int)$class_id . "' group by tax_priority");
    if (tep_db_num_rows($tax_query)) {
      $tax_multiplier = 0;
      while ($tax = tep_db_fetch_array($tax_query)) {
        $tax_multiplier += $tax['tax_rate'];
      }
      return $tax_multiplier;
    } else {
      return 0;
    }
  }

  function tep_call_function($function, $parameter, $object = '') {
    if ($object == '') {
      return call_user_func($function, $parameter);
    } elseif (PHP_VERSION < 4) {
      return call_user_method($function, $object, $parameter);
    } else {
      return call_user_func(array($object, $function), $parameter);
    }
  }

  function tep_get_zone_class_title($zone_class_id) {
    if ($zone_class_id == '0') {
      return TEXT_NONE;
    } else {
      $classes_query = tep_db_query("select geo_zone_name from " . TABLE_GEO_ZONES . " where geo_zone_id = '" . (int)$zone_class_id . "'");
      $classes = tep_db_fetch_array($classes_query);

      return $classes['geo_zone_name'];
    }
  }

  function tep_cfg_pull_down_zone_classes($zone_class_id, $key = '') {
    $name = (($key) ? 'configuration[' . $key . ']' : 'configuration_value');

    $zone_class_array = array(array('id' => '0', 'text' => TEXT_NONE));
    $zone_class_query = tep_db_query("select geo_zone_id, geo_zone_name from " . TABLE_GEO_ZONES . " order by geo_zone_name");
    while ($zone_class = tep_db_fetch_array($zone_class_query)) {
      $zone_class_array[] = array('id' => $zone_class['geo_zone_id'],
                                  'text' => $zone_class['geo_zone_name']);
    }

    return tep_draw_pull_down_menu($name, $zone_class_array, $zone_class_id);
  }

  function tep_cfg_pull_down_order_statuses($order_status_id, $key = '') {
    global $languages_id;

    $name = (($key) ? 'configuration[' . $key . ']' : 'configuration_value');

    $statuses_array = array(array('id' => '0', 'text' => TEXT_DEFAULT));
    $statuses_query = tep_db_query("select orders_status_id, orders_status_name from " . TABLE_ORDERS_STATUS . " where language_id = '" . (int)$languages_id . "' order by orders_status_name");
    while ($statuses = tep_db_fetch_array($statuses_query)) {
      $statuses_array[] = array('id' => $statuses['orders_status_id'],
                                'text' => $statuses['orders_status_name']);
    }

    return tep_draw_pull_down_menu($name, $statuses_array, $order_status_id);
  }

  function tep_get_order_status_name($order_status_id, $language_id = '') {
    global $languages_id;

    if ($order_status_id < 1) return TEXT_DEFAULT;

    if (!is_numeric($language_id)) $language_id = $languages_id;

    $status_query = tep_db_query("select orders_status_name from " . TABLE_ORDERS_STATUS . " where orders_status_id = '" . (int)$order_status_id . "' and language_id = '" . (int)$language_id . "'");
    $status = tep_db_fetch_array($status_query);

    return $status['orders_status_name'];
  }

////
// Return a random value
  function tep_rand($min = null, $max = null) {
    static $seeded;

    if (!$seeded) {
      mt_srand((double)microtime()*1000000);
      $seeded = true;
    }

    if (isset($min) && isset($max)) {
      if ($min >= $max) {
        return $min;
      } else {
        return mt_rand($min, $max);
      }
    } else {
      return mt_rand();
    }
  }

// nl2br() prior PHP 4.2.0 did not convert linefeeds on all OSs (it only converted \n)
  function tep_convert_linefeeds($from, $to, $string) {
    if ((PHP_VERSION < "4.0.5") && is_array($from)) {
      return preg_replace('/(' . implode('|', $from) . ')/', $to, $string);
    } else {
      return str_replace($from, $to, $string);
    }
  }

  function tep_string_to_int($string) {
    return (int)$string;
  }

////
// Parse and secure the cPath parameter values
  function tep_parse_category_path($cPath) {
// make sure the category IDs are integers
    $cPath_array = array_map('tep_string_to_int', explode('_', $cPath));

// make sure no duplicate category IDs exist which could lock the server in a loop
    $tmp_array = array();
    $n = sizeof($cPath_array);
    for ($i=0; $i<$n; $i++) {
      if (!in_array($cPath_array[$i], $tmp_array)) {
        $tmp_array[] = $cPath_array[$i];
      }
    }

    return $tmp_array;
  }
  
  //TotalB2B start
  function tep_xppp_getmaxprices() {
    //max prices per product
	return 10;
  }
  
  function tep_xppp_getpricesnum() {
	$prices_query = tep_db_query("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'XPRICES_NUM'");
    $prices = tep_db_fetch_array($prices_query);
	return $prices['configuration_value'];
  }

  function tep_xppp_getpricelist($ts) {
	$prices_num = tep_xppp_getpricesnum();
    for ($i=2; $i<=$prices_num; $i++) {
	  if ($ts != NULL) $price_list .= $ts . ".products_price_" . $i . ",";
	  else $price_list .= "products_price_" . $i . ",";
    }
	if ($ts != NULL) $price_list .= $ts . ".products_price";
	else $price_list .= "products_price";
	return $price_list;
  }

  function tep_cfg_pull_down_prices($price) {
	for ($i=1; $i<=tep_xppp_getmaxprices(); $i++) {
      $price_array[] = array('id' => $i,
                             'text' => $i);
    }
    return tep_draw_pull_down_menu('configuration_value', $price_array, $price);
  }

  function tep_update_prices($price) {
  	$link = 'db_link';
    global $$link;  	
    $do_drop = true;
	$prices_num = tep_xppp_getpricesnum();
	for ($i=2; $i<=$prices_num; $i++)
	  if (!mysqli_query($$link,"select products_price_" . $i . " from " . TABLE_PRODUCTS)) {
	    $do_drop = false;
	    tep_db_query("alter table " . TABLE_PRODUCTS . " add products_price_" . $i . " decimal(15,4) null");
	  }
	if ($do_drop) {
	  for ($i=tep_xppp_getmaxprices(); $i>$prices_num; $i--)
		if (mysqli_query($$link,"select products_price_" . $i . " from " . TABLE_PRODUCTS)) {
		   tep_db_query("alter table " . TABLE_PRODUCTS . " drop products_price_" . $i);
		   $customers_groups_update_query = tep_db_query("select customers_groups_id, customers_groups_price from " . TABLE_CUSTOMERS_GROUPS . " where customers_groups_price = '" . $i . "'");
	       while ($customers_groups = tep_db_fetch_array($customers_groups_update_query)) {
		      tep_db_query("update " . TABLE_CUSTOMERS_GROUPS . " set customers_groups_price = '1' where customers_groups_id = '" . $customers_groups['customers_groups_id'] . "'");
		   }
	  }
	}
    return $prices_num;
  }
  
  function tep_set_customers_status($customers_id, $customers_status) { 
    if ($customers_status == '1') { 
      return tep_db_query("update " . TABLE_CUSTOMERS . " set customers_status = '1' WHERE customers_id = '" . $customers_id . "'"); 
    } elseif ($customers_status == '0') { 
      return tep_db_query("update " . TABLE_CUSTOMERS . " set customers_status = '0' WHERE customers_id = '" . $customers_id . "'"); 
    } else { 
      return -1; 
    } 
  } 
  //TotalB2B end

// Alias function for Store configuration values in the Administration Tool
  function tep_cfg_select_multioption($select_array, $key_value, $key = '') {
    for ($i=0; $i<sizeof($select_array); $i++) {
      $name = (($key) ? 'configuration[' . $key . '][]' : 'configuration_value');
      $string .= '<br><input type="checkbox" name="' . $name . '" value="' . $select_array[$i] . '"';
      $key_values = explode( ", ", $key_value);
      if ( in_array($select_array[$i], $key_values) ) $string .= ' CHECKED';
      $string .= '> ' . $select_array[$i];
    } 
    $string .= '<input type="hidden" name="' . $name . '" value="--none--">';
    return $string;
  }

//create a select list to display list of themes available for selection
  function tep_cfg_pull_down_template_list($template_id, $key = '') {
    $name = (($key) ? 'configuration[' . $key . ']' : 'configuration_value');

    $template_query = tep_db_query("select template_id, template_name from " . TABLE_TEMPLATE . " order by template_name");
    while ($template = tep_db_fetch_array($template_query)) {
      $template_array[] = array('id' => $template['template_name'],
                                 'text' => $template['template_name']);
    }

    return tep_draw_pull_down_menu($name, $template_array, $template_id);
  }

// BOF Enable - Disable Categories Contribution--------------------------------------
// Sets the status of a category and all nested categories and products whithin.
  function tep_set_categories_status($category_id, $status) {
    if ($status == '1') {
      tep_db_query("update " . TABLE_CATEGORIES . " set categories_status = '1', last_modified = now() where categories_id = '" . $category_id . "'");
      $tree = tep_get_category_tree($category_id);
      for ($i=1; $i<sizeof($tree); $i++) {
        tep_db_query("update " . TABLE_CATEGORIES . " set categories_status = '1', last_modified = now() where categories_id = '" . $tree[$i]['id'] . "'");
      }
    } elseif ($status == '0') {
      tep_db_query("update " . TABLE_CATEGORIES . " set categories_status = '0', last_modified = now() where categories_id = '" . $category_id . "'");
      $tree = tep_get_category_tree($category_id);
      for ($i=1; $i<sizeof($tree); $i++) {
        tep_db_query("update " . TABLE_CATEGORIES . " set categories_status = '0', last_modified = now() where categories_id = '" . $tree[$i]['id'] . "'");
      }
    }
  }
// EOF Enable - Disable Categories Contribution--------------------------------------

// begin mod for PrductsProperties v2.01
  function tep_get_products_model($product_id, $language_id = 0) {
    global $languages_id;

    if ($language_id == 0) $language_id = $languages_id;
    $product_query = tep_db_query("select p.products_model, pd.language_id from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd where p.products_id = '" . (int)$product_id . "' and pd.products_id = p.products_id and pd.language_id = '" . (int)$language_id . "'");
    $product = tep_db_fetch_array($product_query);

    return $product['products_model'];
  }

  function tep_get_properties_options_name($options_id) {
    global $languages_id;

    $options = tep_db_query("select products_options_name from " . TABLE_PRODUCTS_PROP_OPTIONS . " where products_options_id = '" . (int)$options_id . "' and language_id = '" . (int)$languages_id . "'");
    $options_values = tep_db_fetch_array($options);

    return $options_values['products_options_name'];
  }

  function tep_get_properties_values_name($values_id) {
    global $languages_id;

    $values = tep_db_query("select products_options_values_name from " . TABLE_PRODUCTS_PROP_OPTIONS_VALUES . " where products_options_values_id = '" . (int)$values_id . "' and language_id = '" . (int)$languages_id . "'");
    $values_values = tep_db_fetch_array($values);

    return $values_values['products_options_values_name'];
  }
// end mod for PrductsProperties v2.01

        //TotalB2B start
    function b2b_display_price($products_id, $products_price) {
      global $customer_id;
         $query_A = tep_db_query("select m.manudiscount_discount from " 
. TABLE_MANUDISCOUNT .  " m, " . TABLE_PRODUCTS . " p where 
m.manudiscount_groups_id = 0 and m.manudiscount_customers_id = '" . 
$customer_id . "' and p.products_id = '" . $products_id . "' and 
p.manufacturers_id = m.manudiscount_manufacturers_id");
         $query_B = tep_db_query("select m.manudiscount_discount from " 
. TABLE_CUSTOMERS  . " c, " . TABLE_MANUDISCOUNT .  " m, " . 
TABLE_PRODUCTS . " p where m.manudiscount_groups_id = 
c.customers_groups_id  and m.manudiscount_customers_id = 0 and 
c.customers_id = '" . $customer_id . "' and p.products_id = '" . 
$products_id . "' and p.manufacturers_id = 
m.manudiscount_manufacturers_id");
         $query_C = tep_db_query("select m.manudiscount_discount from " 
. TABLE_MANUDISCOUNT .  " m, " . TABLE_PRODUCTS . " p where 
m.manudiscount_groups_id = 0 and m.manudiscount_customers_id = 0 and 
p.products_id = '" . $products_id . "' and p.manufacturers_id = 
m.manudiscount_manufacturers_id");
         if ($query_result = tep_db_fetch_array($query_A)) {
             $customer_discount = $query_result['manudiscount_discount'];
         } else if ($query_result = tep_db_fetch_array($query_B)) {
             $customer_discount = $query_result['manudiscount_discount'];
         } else if ($query_result = tep_db_fetch_array($query_C)) {
             $customer_discount = $query_result['manudiscount_discount'];
         } else {
             $query = tep_db_query("select g.customers_groups_discount 
from " . TABLE_CUSTOMERS_GROUPS . " g inner join  " . TABLE_CUSTOMERS  . 
" c on g.customers_groups_id = c.customers_groups_id and c.customers_id 
= '" . $customer_id . "'");
             $query_result = tep_db_fetch_array($query);
             $customers_groups_discount = 
$query_result['customers_groups_discount'];
             $query = tep_db_query("select customers_discount from " . 
TABLE_CUSTOMERS . " where customers_id =  '" . $customer_id . "'");
             $query_result = tep_db_fetch_array($query);
             $customer_discount = $query_result['customers_discount'];
             $customer_discount = $customer_discount + 
$customers_groups_discount;
         }
         if ($customer_discount >= 0) {
            $products_price = $products_price + $products_price * 
abs($customer_discount) / 100;
         } else {
            $products_price = $products_price - $products_price * 
abs($customer_discount) / 100;
         }
         return $products_price;
    }
    //TotalB2B end

  function tep_get_languages_directory($code) {
    global $languages_id;
    $language_query = tep_db_query("select languages_id, directory from " . TABLE_LANGUAGES . " where code = '" . tep_db_input($code) . "'");
    if (tep_db_num_rows($language_query)) {
      $language = tep_db_fetch_array($language_query);
      $languages_id = $language['languages_id'];
      return $language['directory'];
    } else {
      return false;
   }
  }

   	 function tep_get_extra_fields($customer_id,$languages_id){
          $extra_fields_query = tep_db_query("select ce.fields_id, ce.fields_input_type, ce.fields_input_value, ce.fields_required_status, cei.fields_name, ce.fields_status, ce.fields_input_type from " . TABLE_EXTRA_FIELDS . " ce, " . TABLE_EXTRA_FIELDS_INFO . " cei where ce.fields_status=1 and cei.fields_id=ce.fields_id and cei.languages_id =" . $languages_id);
          $extra_fields_string ='';
          if(tep_db_num_rows($extra_fields_query)>0){
             $extra_fields_string .= '<tr><td class="formAreaTitle"><b>' . CATEGORY_EXTRA_FIELDS .'</b></td></tr>';
             $extra_fields_string .= '<td class="formArea"><table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBox">
                                     <tr class="infoBoxContents"><td><table border="0" cellspacing="2" cellpadding="2">';
             while($extra_fields = tep_db_fetch_array($extra_fields_query)){
                  $value='';
                  if(isset($customer_id)){
                          $value_query = tep_db_query("select value from " . TABLE_CUSTOMERS_TO_EXTRA_FIELDS . " where customers_id=" . $customer_id . " and fields_id=" . $extra_fields['fields_id']);
                          $value_info = tep_db_fetch_array($value_query);
                          $value_list = explode("\n", $value_info['value']);
                          for($i = 0, $n = sizeof($value_list); $i < $n; $i++)
                          {
                            $value_list[$i] = trim($value_list[$i]);
													}
													$value = $value_list[0];
                  }
                  $extra_fields_string .='<tr>
                                        <td class="main" valign="top">' . $extra_fields['fields_name'] . ': </td><td class="main" valign="top">';


									$select_values_list = explode("\n", $extra_fields['fields_input_value']);
									$select_values = array();
									foreach($select_values_list as $item)
									{
									  $item = trim($item);
                    $select_values[] = array('id' => $item, 'text' => $item);
									}

									switch($extra_fields['fields_input_type'])
									{
									  case  0: $extra_fields_string .= tep_draw_input_field('fields_' . $extra_fields['fields_id'],$value). (($extra_fields['fields_required_status']==1) ? '<span class="inputRequirement">*</span>': ''); break;
									  case  1: $extra_fields_string .= tep_draw_textarea_field('fields_' . $extra_fields['fields_id'], 'soft', 50, 6,$value,'style="width:400px;"'). (($extra_fields['fields_required_status']==1) ? '<span class="inputRequirement">*</span>': ''); break;
									  case  2:
									  	foreach($select_values_list as $item)
											{
                          $item = trim($item);
                      		$extra_fields_string .= tep_draw_selection_field('fields_' . $extra_fields['fields_id'], 'radio', $item, (($value == $item)?(true):(false))).$item. (($extra_fields['fields_required_status']==1) ? '<span class="inputRequirement">*</span>': '').'<br>';
                      		$extra_fields['fields_required_status']  = 0;
											}
									    break;
									  case  3:
											$cnt = 1;
									  	foreach($select_values_list as $item)
											{
											    $item = trim($item);
                      		$extra_fields_string .= tep_draw_selection_field('fields_' . $extra_fields['fields_id'] . '_' . ($cnt++), 'checkbox', $item, ((in_array($item, $value_list))?(true):(false))).$item. (($extra_fields['fields_required_status']==1) ? '<span class="inputRequirement">*</span>': '').'<br>';
                      		$extra_fields['fields_required_status']  = 0;
											}
											$extra_fields_string .= tep_draw_hidden_field('fields_' . $extra_fields['fields_id'] . '_total' , $cnt);
									    break;
									  case  4: $extra_fields_string .= tep_draw_pull_down_menu('fields_' . $extra_fields['fields_id'], $select_values, $value).(($extra_fields['fields_required_status']==1) ? '<span class="inputRequirement">*</span>': ''); break;
									  default: $extra_fields_string .= tep_draw_input_field('fields_' . $extra_fields['fields_id'],$value). (($extra_fields['fields_required_status']==1) ? '<span class="inputRequirement">*</span>': ''); break;
									}

                 	$extra_fields_string .=' '  .'</td></tr>';
             }
             $extra_fields_string .= '</table></td></tr></table></td></tr>';
             $extra_fields_string .= '<tr><td>' .  tep_draw_separator('pixel_trans.gif', '100%', '10') . '</td></tr>';
          }
          return $extra_fields_string;
  }

  function tep_get_customers_extra_fields_name($fields_id, $language_id) {
    $fields_query = tep_db_query("select fields_name from " . TABLE_EXTRA_FIELDS_INFO . " where fields_id = '" . (int)$fields_id . "' and languages_id = '" . (int)$language_id . "'");
    $fields = tep_db_fetch_array($fields_query);

    return $fields['fields_name'];
  }

  function tep_get_extra_fields_order($customer_id,$languages_id){
          $extra_fields_query = tep_db_query("select ce.fields_id, ce.fields_input_type, ce.fields_required_status, cei.fields_name, ce.fields_status, ce.fields_input_type from " . TABLE_EXTRA_FIELDS . " ce, " . TABLE_EXTRA_FIELDS_INFO . " cei where ce.fields_status=1 and cei.fields_id=ce.fields_id and cei.languages_id =" . $languages_id);
          $extra_fields_string ='';
          if(tep_db_num_rows($extra_fields_query)>0){
             while($extra_fields = tep_db_fetch_array($extra_fields_query)){
                  $value='';
                  if(isset($customer_id)){
                          $value_query = tep_db_query("select value from " . TABLE_CUSTOMERS_TO_EXTRA_FIELDS . " where customers_id=" . $customer_id . " and fields_id=" . $extra_fields['fields_id']);
                          $value_info = tep_db_fetch_array($value_query);
                          $value = $value_info['value'];
                  }
                  $extra_fields_string .= '

               <tr>
                 <td class="main"><b>' .$extra_fields['fields_name'] .':</b></td>
                 <td class="main">' .$value . '</td>
               </tr>';
               
             }
          }
          return $extra_fields_string;
  }
        
// BOF: WebMakers.com Added: Downloads Controller
require(DIR_WS_FUNCTIONS . 'downloads_controller.php');
// EOF: WebMakers.com Added: Downloads Controller

//BEGIN Dynamic Information pages unlimited
  require(DIR_WS_FUNCTIONS . 'information.php');
//END Dynamic Information pages unlimited

function tep_iconv($text) {

    //if (function_exists('iconv')) {
       //return iconv('UTF-8', CHARSET, $text); 
    //} else {
      return $text;
    //}
  }

function tep_iconv_utf($text) {

    //if (function_exists('iconv')) {
       //return iconv(CHARSET, 'UTF-8', $text); 
    //} else {
      return $text;
    //}
  }

  //////create a pull down for all payment installed payment methods for Order Editor configuration
   
  // Get list of all payment modules available
  function tep_cfg_pull_down_payment_methods() {
  global $language;
  $enabled_payment = array();
  $module_directory = DIR_FS_CATALOG_MODULES . 'payment/';
  $file_extension = '.php';

  if ($dir = @dir($module_directory)) {
    while ($file = $dir->read()) {
      if (!is_dir( $module_directory . $file)) {
        if (substr($file, strrpos($file, '.')) == $file_extension) {
          $directory_array[] = $file;
        }
      }
    }
    sort($directory_array);
    $dir->close();
  }

  // For each available payment module, check if enabled
  for ($i=0, $n=sizeof($directory_array); $i<$n; $i++) {
    $file = $directory_array[$i];

    include(DIR_FS_CATALOG_LANGUAGES . $language . '/modules/payment/' . $file);
    include($module_directory . $file);

    $class = substr($file, 0, strrpos($file, '.'));
    if (tep_class_exists($class)) {
      $module = new $class;
      if ($module->check() > 0) {
        // If module enabled create array of titles
      	$enabled_payment[] = array('id' => $module->title, 'text' => $module->title);
		
      }
   }
 }
 				
    $enabled_payment[] = array('id' => TEXT_OTHER, 'text' => TEXT_OTHER);	
		
		//draw the dropdown menu for payment methods and default to the order value
	  return tep_draw_pull_down_menu('configuration_value', $enabled_payment, '', ''); 
		}


/////end payment method dropdown

// Start products specifications

// Functions copied from catalog/includes/functions/general.php
////
// Return true if the category has subcategories
// TABLES: categories
  function tep_has_category_subcategories($category_id) {
    $child_category_query = tep_db_query("select count(*) as count from " . TABLE_CATEGORIES . " where parent_id = '" . (int)$category_id . "'");
    $child_category = tep_db_fetch_array($child_category_query);

    if ($child_category['count'] > 0) {
      return true;
    } else {
      return false;
    }
  }

////
// Return all subcategory IDs
// TABLES: categories
  function tep_get_subcategories(&$subcategories_array, $parent_id = 0) {
    $subcategories_query = tep_db_query("select categories_id from " . TABLE_CATEGORIES . " where parent_id = '" . (int)$parent_id . "'");
    while ($subcategories = tep_db_fetch_array($subcategories_query)) {
      $subcategories_array[sizeof($subcategories_array)] = $subcategories['categories_id'];
      if ($subcategories['categories_id'] != $parent_id) {
        tep_get_subcategories($subcategories_array, $subcategories['categories_id']);
      }
    }
  }
// End copied functions
  
////
// Return the products_tab_x data from the database
// TABLES: products_description
  function tep_get_products_tabs ($product_id, $language_id) {
    $product_query_raw = "
      select 
        products_tab_1,
        products_tab_2,
        products_tab_3,
        products_tab_4,
        products_tab_5,
        products_tab_6
      from 
        " . TABLE_PRODUCTS_DESCRIPTION . " 
      where 
        products_id = '" . (int) $product_id . "' 
        and language_id = '" . (int) $language_id . "'
    ";
    $product_query = tep_db_query ($product_query_raw);
    
    $product_tabs = array();
    $product = tep_db_fetch_array ($product_query);
    for ($i=1, $n=7; $i<$n; $i++) {
      $product_tabs[$i] = $product['products_tab_' . $i];
    }

    return $product_tabs;
  }
// End products specifications

  function tep_get_ip_address() {
    if (isset($_SERVER)) {
      if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
      } elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
      } else {
        $ip = $_SERVER['REMOTE_ADDR'];
      }
    } else {
      if (getenv('HTTP_X_FORWARDED_FOR')) {
        $ip = getenv('HTTP_X_FORWARDED_FOR');
      } elseif (getenv('HTTP_CLIENT_IP')) {
        $ip = getenv('HTTP_CLIENT_IP');
      } else {
        $ip = getenv('REMOTE_ADDR');
      }
    }

    return $ip;
  }

function tep_store_mail($to_name, $to_email_address, $email_subject, $email_text, $from_email_name, $from_email_address, $hold = '') {

  if (SEND_EMAILS != 'true') return false;

  $browser_ip = tep_get_ip_address();
  $this_moment = date("Y-m-d") . ' ' . date("H:i:s");
  $sql_data_array = array('to_name'      => $to_name,
                          'charset'      => CHARSET,
                          'to_address'   => $to_email_address,
                          'subject'      => $email_subject,
                          'text'         => $email_text,
                          'from_name'    => $from_email_name,
                          'from_address' => $from_email_address,
                          'last_updated' => $this_moment,
                          'created'      => $this_moment,
                          'hold'         => $hold,
                          'ip'           => $browser_ip);

  tep_db_perform(TABLE_EMAIL_BATCH, $sql_data_array);
}

function tep_get_spsr_zone_id($zone_id) {
    $spsr_zone_query = tep_db_query("select spsr_zone_id from " . TABLE_SPSR_ZONES . " where zone_id = '" . $zone_id . "'");
    if (tep_db_num_rows($spsr_zone_query)) {
      $spsr_zone = tep_db_fetch_array($spsr_zone_query);
	  $spsr_zone_id = $spsr_zone['spsr_zone_id'];
	  return $spsr_zone_id;
    } else {
	  return false;
    }
   }

	function make_alias ($alias)
	{

		//Replace cyrillic symbols to translit
		$trdic = array(
		"ё"=>"jo",
		"ж"=>"zh",
		"ф"=>"ph",
		"х"=>"kh",
		"ц"=>"ts",
		"ч"=>"ch",
		"ш"=>"sh",
		"щ"=>"sch",
		"э"=>"je",
		"ю"=>"ju",
		"я"=>"ja",
		
		"а"=>"a",
		"б"=>"b",
		"в"=>"v",
		"г"=>"g",
		"д"=>"d",
		"е"=>"e",
		"з"=>"z",
		"и"=>"i",
		"й"=>"j",
		"к"=>"k",
		"л"=>"l",
		"м"=>"m",
		"н"=>"n",
		"о"=>"o",
		"п"=>"p",
		"р"=>"r",
		"с"=>"s",
		"т"=>"t",
		"у"=>"u",
		"х"=>"h",
		"ц"=>"c",
		"ы"=>"y",
		
		"Ё"=>"E",
		"Ж"=>"ZH",
		"Ф"=>"PH",
		"Х"=>"KH",
		"Ц"=>"TS",
		"Ч"=>"CH",
		"Ш"=>"SH",
		"Щ"=>"SCH",
		"Э"=>"JE",
		"Ю"=>"JU",
		"Я"=>"JA",
		
		"А"=>"A",
		"Б"=>"B",
		"В"=>"V",
		"Г"=>"G",
		"Д"=>"D",
		"Е"=>"E",
		"З"=>"Z",
		"И"=>"I",
		"Й"=>"J",
		"К"=>"K",
		"Л"=>"L",
		"М"=>"M",
		"Н"=>"N",
		
		"О"=>"O",
		"П"=>"P",
		"Р"=>"R",
		"С"=>"S",
		"Т"=>"T",
		"У"=>"U",
		"Х"=>"H",
		"Ц"=>"C",
		"Ы"=>"Y",
		
		// -----------------------
		"Ъ" => "",
		"Ь" => "",
		"ъ" => "",
		"ь" => ""
		);			

						if($alias == "") {
							$alias = rand(1000,9999);
						}
							
						//$alias = trim($alias);
						//$alias = strtolower($alias);
						$alias = str_replace(' ','-',$alias);
						//Replace cyrillic symbols to translit
						$alias = strtr(stripslashes($alias), $trdic);
						$alias = preg_replace("/[^a-zA-Z0-9-s]/", "", $alias);						
                
		return $alias;
	}

// BOF Site timezone
function tep_cfg_pull_down_timezone_list($timezone, $key = '') {
if (class_exists(DateTimeZone)) {
$name = (($key) ? 'configuration[' . $key . ']' : 'configuration_value');
// $zones = timezone_identifiers_list();
$zones = DateTimeZone::listIdentifiers();
$locations = array();
foreach ($zones as $zone) {
$zone = explode('/', $zone);
if (!in_array($zone[0], array('Africa', 'America', 'Antarctica', 'Arctic', 'Asia', 'Atlantic', 'Australia', 'Europe', 'Indian', 'Pacific')) || !isset($zone[1]) || $zone[1] == '') continue;
$locations[$zone[0]][$zone[0] . '/' . $zone[1]] = str_replace('_', ' ', $zone[1]);
}
$field = '<select name="' . $name . '">' . "\n";
$field .= ' <option value="">' . '--' . '</option>' . "\n";
foreach ($locations as $continent => $zones) {
$field .= ' <optgroup label="' . $continent . '">' . "\n";
foreach ($zones as $zone => $city) {
$field .= ' <option value="' . $zone . '"';
if ($timezone == $zone) {
$field .= ' selected="selected"';
}
$field .= '>' . $city . '</option>' . "\n";
}
$field .= ' </optgroup>' . "\n";
}
$field .= '</select>' . "\n";
}
return $field;
}
// EOF Site timezone

  /**
  * ULTIMATE Seo Urls 5 PRO by FWR Media
  * Reset the various cache systems
  * @param string $action
  */
  function tep_reset_cache_data_usu5( $action = false ) {
    if ( $action == 'reset' ) {
      $usu5_path = realpath( dirname( __FILE__ ) . '/../../../' ) . '/' . DIR_WS_MODULES . 'ultimate_seo_urls5/';
      switch( USU5_CACHE_SYSTEM ) {
        case 'file': 
          $path_to_cache = $usu5_path . 'cache_system/cache/';
          $it = new DirectoryIterator( $path_to_cache );
          while( $it->valid() ) {
            if ( !$it->isDot() && is_readable( $path_to_cache . $it->getFilename() ) && ( substr( $it->getFilename(), -6 ) == '.cache' ) ) {
              @unlink( $path_to_cache . $it->getFilename() );
            }
            $it->next();
          }
          break;
        case 'mysql':
          tep_db_query( 'TRUNCATE TABLE `usu_cache`' );
          break;
        case 'memcache':
          if ( class_exists('Memcache') ){
            include $usu5_path . 'interfaces/cache_interface.php';
            include $usu5_path . 'cache_system/memcache.php';
            Memcache_Cache_Module::iAdmin()->initiate()
                                           ->flushOut();
          }
          break;
        case 'sqlite':
          include $usu5_path . 'interfaces/cache_interface.php';
          include $usu5_path . 'cache_system/sqlite.php';
          Sqlite_Cache_Module::admini()->gc(); 
          break;
      }
      tep_db_query( "UPDATE " . TABLE_CONFIGURATION . " SET configuration_value='false' WHERE configuration_key='USU5_RESET_CACHE'" );
    }       
  } // end function

///////////////////start mail manager////////////////////////////////////////start mail manager////////////////////////////////////////start mail manager/////////////////////

function tep_mm_set_mailstatus($mail_id, $status) {
if ($status == '1') {
return tep_db_query("update " . TABLE_MM_RESPONSEMAIL . " set status = '1' where mail_id = '" . (int)$mail_id . "'");
} elseif ($status == '0') {
return tep_db_query("update " . TABLE_MM_RESPONSEMAIL . " set status = '0' where mail_id = '" . (int)$mail_id . "'");
} else {
return -1;
}
}



function tep_mm_sendmail($mail, $email_address, $sender_name, $sender, $output_subject, $output_content_html, $output_content_txt,$bcc='') {
    $to_name=$mail;$to_email_address=$email_address;
    $email_subject=$output_subject;$email_text=$output_content_html;
    $from_email_name=$sender_name; $from_email_address=$sender;

    $message = new PHPMailer();
    $message->CharSet = 'utf-8';
    $message->Encoding='base64';

            if (EMAIL_TRANSPORT == 'smtp'){
                        $message->IsSMTP();
                        $message->SMTPKeepAlive = true;
                        $message->SMTPAuth = EMAIL_SMTP_AUTH;
                        $message->Username = EMAIL_SMTP_USERNAME;
                        $message->Password = EMAIL_SMTP_PASSWORD;
                        $message->Host = EMAIL_SMTP_SERVER; // SMTP server
                        $message->Port = EMAIL_SMTP_PORT;
            }else{
                        $message->IsMail(); // telling the class to use SMTP
            }
           
            // Config
           
            if( !tep_not_null($from_email_address) ) {
                        $from_email_address = SMTP_SENDMAIL_FROM;
            }
           
            $message->From = $from_email_address;
           
            if( !tep_not_null($from_email_name) ) {
                        $from_email_name = SMTP_FROMEMAIL_NAME;
            }
           
            $message->FromName = $from_email_name;
           
            if( !tep_not_null($to_name) ) {
                        $to_name = '';
            }

            if( !tep_not_null($to_email_address) ) {
                        return false;
            }
            $message->AddAddress($to_email_address, $to_name);
	    if (is_array($bcc)){
		foreach($bcc as $key=>$value){
		    $message->AddBCC($value['address'],$value['name']);
		    }
		}
    $message->Subject = $email_subject;
    // Build the text version
    $text = strip_tags($email_text);
//    $message->Body = tep_convert_linefeeds(array("\r\n", "\n", "\r"), '<br>', $email_text);
    $message->Body=$email_text;
    $message->AltBody = $text;
    $message->IsHTML(true);
    // Send message
    if(!$message->Send()){
               return false;
            }
}



///////////////////end mail manager////////////////////////////////////////end mail manager////////////////////////////////////////end mail manager/////////////////////
function tep_create_random_value($length, $type = 'mixed') {
    if ( ($type != 'mixed') && ($type != 'chars') && ($type != 'digits')) return false;
    $rand_value = '';
    while (strlen($rand_value) < $length) {
      if ($type == 'digits') {
        $char = tep_rand(0,9);
      } else {
        $char = chr(tep_rand(0,255));
      }
      if ($type == 'mixed') {
        if (preg_match('/^[a-z0-9]$/', $char)) $rand_value .= $char;
      } elseif ($type == 'chars') {
        if (preg_match('/^[a-z]$/', $char)) $rand_value .= $char;
      } elseif ($type == 'digits') {
        if (preg_match('/^[0-9]$/', $char)) $rand_value .= $char;
      }
    }
    return $rand_value;
  }

function GetCustomersUUID($uid){
$query=tep_db_query('select customers_uuid as uuid,count(*) as cnt from customers where customers_id='.(int)$uid);
if ($query!==false){
    $r=tep_db_fetch_array($query);
        if (((int)$r['cnt']>0)&&
    	    (strlen(trim($r['uuid']))>0)){return $r['uuid'];}
                else{
                    if (strlen(trim($r['uuid']))==0){
                    //---create uniq ID
                    do {
                        $uuid=tep_create_random_value(32);
                        $qry=tep_db_query('select count(*) as cnt from customers where customers_uuid="'.$uuid.'"');
                        if ($qry!==false){
                            $res=tep_db_fetch_array($qry);
                                }else{$res['cnt']=0;}
                        }while ($res['cnt']>0);
                //---create uniq ID
    	        tep_db_query('update customers set customers_uuid="'.$uuid.'"
	                    where customers_id='.$uid);
                return $uuid;
            }
        }//--else
    }else{return 'AAA';}//---if query
}
function echoHTTP(){
    if (ENABLE_SSL==true){return 'https://';}else{return 'http://';}
            }
?>