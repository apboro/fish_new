<?php
/*
  $Id: general.php,v 1.1.1.1 2003/09/18 19:05:10 wilt Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/

////
// Stop from parsing any further PHP code
function tep_exit()
{
    tep_session_close();
    exit();
}

////
/**
 * ULTIMATE Seo Urls 5 PRO by FWR Media
 * Redirect to another page or site
 */
function tep_redirect($url, $code = 302)
{
    if ((strstr($url, "\n") != false) || (strstr($url, "\r") != false)) {
        tep_redirect(tep_href_link(FILENAME_DEFAULT, '', 'NONSSL', false));
    }

    if ((ENABLE_SSL == true) && (getenv('HTTPS') == 'on')) { // We are loading an SSL page
        if (substr($url, 0, strlen(HTTP_SERVER)) == HTTP_SERVER) { // NONSSL url
            $url = HTTPS_SERVER . substr($url, strlen(HTTP_SERVER)); // Change it to SSL
        }
    }
    if (false !== strpos($url, '&amp;')) {
        $url = str_replace('&amp;', '&', $url);
    }
    session_write_close();
    header('Location: ' . $url, true, $code);
    exit;
}

////
// Parse the data used in the html tags to ensure the tags will not break
function tep_parse_input_field_data($data, $parse)
{
    return strtr(trim($data), $parse);
}

function tep_output_string($string, $translate = false, $protected = false)
{
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

function tep_output_string_protected($string)
{
    return tep_output_string($string, false, true);
}

function tep_sanitize_string($string)
{
    $string = preg_replace('/ +/', ' ', trim($string));

    return preg_replace("/[<>]/", '_', $string);
}

////
// Return a random row from a database query
function tep_random_select($query)
{
    $random_product = '';
    $random_query = tep_db_query($query);
    $num_rows = tep_db_num_rows($random_query);
    if ($num_rows > 0) {
        $random_row = tep_rand(0, ($num_rows - 1));
        tep_db_data_seek($random_query, $random_row);
        $random_product = tep_db_fetch_array($random_query);
    }

    return $random_product;
}

////
// Return a product's name
// TABLES: products
function tep_get_products_name($product_id, $language = '')
{
    global $languages_id;
    if (empty($language)) $language = $languages_id;

    $product_query = tep_db_query("select products_name from " . TABLE_PRODUCTS_DESCRIPTION . " where products_id = '" . (int)$product_id . "' and language_id = '" . (int)$language . "'");
    $product = tep_db_fetch_array($product_query);

    return $product['products_name'];
}

////
// Return a product's special price (returns nothing if there is no offer)
// TABLES: products
function tep_get_customers_groups_id()
{
    global $customer_id;
    $customers_groups_query = tep_db_query("select customers_groups_id from " . TABLE_CUSTOMERS . " where customers_id =  '" . $customer_id . "'");
    $customers_groups_id = tep_db_fetch_array($customers_groups_query);
    return $customers_groups_id['customers_groups_id'];
}


function tep_get_quick_products_special_price($product, $has_sales = false)
{

    $special_price = $product['specials_new_products_price'];
//     if (!$has_sales && empty($special_price)) {
//         return false;
//     }
    $product_price = $product['products_price'];
    $product_quantity = $product['products_quantity'];
// Todo: Необходимо оптимизировать
    $product_price = extra_product_price($product_price);

//  Todo: Необходимо оптимизировать
    $special_price = extra_product_price($special_price);

    if (substr($product['products_model'], 0, 4) == 'GIFT') {    //Never apply a salededuction to Ian Wilson's Giftvouchers
        return $special_price;
    }

    $category = $product['categories_id'];
    global $sale_items_cache;
    if (!isset($sale_items_cache)) {
        $sale_items_cache = array();
    }
    if (!isset($sale_items_cache[$category])) {
        $sale_query = tep_db_query("select sale_specials_condition, 
        sale_quantity,
        sale_deduction_value_2,
        sale_deduction_value ,
        sale_pricerange_from,
        sale_pricerange_to,
    sale_deduction_type from " . TABLE_SALEMAKER_SALES . " where sale_categories_all like '%," . $category . ",%' 
    and sale_status = '1' and (sale_date_start <= now() or sale_date_start = '0000-00-00') and 
    (sale_date_end >= now() or sale_date_end = '0000-00-00')  
    having sale_deduction_value>0");
        $sale_cache = tep_db_fetch_array($sale_query);
        if (!$sale_cache) {
            $sale_items_cache[$category] = '';
            return $special_price;
        }
        $sale_items_cache[$category] = $sale_cache;
    } else if (empty($sale_items_cache[$category])) {
        return $special_price;
    } else {
        $sale_cache = $sale_items_cache[$category];
    }

    $sale = array();
    if (($sale_cache['sale_pricerange_from'] <= $product_price || $sale_cache['sale_pricerange_from'] == 0)
        && ($sale_cache['sale_pricerange_to'] >= $product_price || $sale_cache['sale_pricerange_to'] == 0)) {
        $sale['sale_specials_condition'] = $sale_cache['sale_specials_condition'];
        $sale['sale_deduction_type'] = $sale_cache['sale_deduction_type'];
        if ($product_quantity >= $sale_cache['sale_quantity']) {
            $sale['sale_deduction_value'] = $sale_cache['sale_deduction_value_2'];
        } else {
            $sale['sale_deduction_value'] = $sale_cache['sale_deduction_value'];
        } 
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
// BOF FlyOpenair: Extra Product Price
            $sale_special_price = extra_product_price($sale_special_price);
// EOF FlyOpenair: Extra Product Price
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
        switch ($sale['sale_specials_condition']) {
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

function tep_get_products_special_price($product_id)
{
    $product_query = tep_db_query("select products_price, products_model,products_quantity from " . TABLE_PRODUCTS . " where products_id = '" . $product_id . "'");
    if (tep_db_num_rows($product_query)) {
        $product = tep_db_fetch_array($product_query);
        $product_price = $product['products_price'];
        $product_quantity = $product['products_quantity'];
// BOF FlyOpenair: Extra Product Price
        $product_price = extra_product_price($product_price);
// EOF FlyOpenair: Extra Product Price
    } else {
        return false;
    }

    $specials_query = tep_db_query("select specials_new_products_price from " . TABLE_SPECIALS . " where products_id = '" . $product_id . "' and status");

    if (tep_db_num_rows($specials_query)) {
        $special = tep_db_fetch_array($specials_query);
        $special_price = $special['specials_new_products_price'];
// BOF FlyOpenair: Extra Product Price
        $special_price = extra_product_price($special_price);
// EOF FlyOpenair: Extra Product Price
    } else {
        $special_price = false;
    }


    if (substr($product['products_model'], 0, 4) == 'GIFT') {    //Never apply a salededuction to Ian Wilson's Giftvouchers
        return $special_price;
    }
    $product_to_categories_query = tep_db_query("select p2c.categories_id from " . TABLE_PRODUCTS_TO_CATEGORIES . " as p2c,".TABLE_CATEGORIES." as c where p2c.products_id = '" . $product_id . "' AND c.categories_status='1' and c.categories_id=p2c.categories_id");

    $product_to_categories = tep_db_fetch_array($product_to_categories_query);
    $category = $product_to_categories['categories_id'];

    $sale_query = tep_db_query("select sale_specials_condition, 
    if (" . $product_quantity . ">=sale_quantity,sale_deduction_value_2,sale_deduction_value) as sale_deduction_value,
    sale_deduction_type from " . TABLE_SALEMAKER_SALES . " where sale_categories_all like '%," . $category . ",%' and sale_status = '1' and (sale_date_start <= now() or sale_date_start = '0000-00-00') and (sale_date_end >= now() or sale_date_end = '0000-00-00') and (sale_pricerange_from <= '" . $product_price . "' or sale_pricerange_from = '0') and (sale_pricerange_to >= '" . $product_price . "' or sale_pricerange_to = '0')
    having sale_deduction_value>0");

    if (tep_db_num_rows($sale_query)) {
        $sale = tep_db_fetch_array($sale_query);
//    echo '<pre>';var_dump($sale);echo'</pre>';
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
// BOF FlyOpenair: Extra Product Price
            $sale_special_price = extra_product_price($sale_special_price);
// EOF FlyOpenair: Extra Product Price
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
        switch ($sale['sale_specials_condition']) {
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


////
// Return a product's stock
// TABLES: products
function tep_get_products_stock($products_id)
{
    $products_id = tep_get_prid($products_id);
    $stock_query = tep_db_query("select products_quantity from " . TABLE_PRODUCTS . " where products_id = '" . (int)$products_id . "'");
    $stock_values = tep_db_fetch_array($stock_query);

    return $stock_values['products_quantity'];
}

////
// Check if the required stock is available
// If insufficent stock is available return an out of stock message
function tep_check_stock($products_id, $products_quantity)
{
    $stock_left = tep_get_products_stock($products_id) - (int)$products_quantity;
    $out_of_stock = '';
    if ($stock_left < 0) {
        $out_of_stock = '<span class="markProductOutOfStock">' . STOCK_MARK_PRODUCT_OUT_OF_STOCK . '</span>';
    }
    return $out_of_stock;
}

////
// Break a word in a string if it is longer than a specified length ($len)
function tep_break_string($string, $len, $break_char = '-')
{
    $l = 0;
    $output = '';
    for ($i = 0, $n = utf8_strlen($string); $i < $n; $i++) {
        $char = utf8_substr($string, $i, 1);
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

////
// Return all HTTP GET variables, except those passed as a parameter
function tep_get_all_get_params($exclude_array = '')
{
    global $_GET;

    if (!is_array($exclude_array))
        $exclude_array = array();
    $get_url = '';

    if (is_array($_GET) && (sizeof($_GET) > 0)) {
        reset($_GET);

        foreach ($_GET as $key => $value) {
            if (is_array($value)) {
                foreach ($value as $new_key => $new_value) {
                    if (!in_array($key, $exclude_array)) {
                        $get_url .= $key . '[' . $new_key . ']' . '=' . rawurlencode(stripslashes($new_value)) . '&';
                    }
                }
            } elseif ((strlen($value) > 0) && ($key != tep_session_name()) && ($key != 'error') && (!in_array($key, $exclude_array)) && ($key != 'x') && ($key != 'y')) {
                $get_url .= $key . '=' . rawurlencode(stripslashes($value)) . '&';
            }
        }
    }

    return $get_url;
}

////
// Returns an array with countries
// TABLES: countries
function tep_get_countries($countries_id = '', $with_iso_codes = false)
{
    $countries_array = array();
    if (tep_not_null($countries_id)) {
        if ($with_iso_codes == true) {
            $countries = tep_db_query("select countries_name, countries_iso_code_2, countries_iso_code_3 from " . TABLE_COUNTRIES . " where countries_id = '" . (int)$countries_id . "' order by countries_name");
            $countries_values = tep_db_fetch_array($countries);
            $countries_array = array('countries_name' => $countries_values['countries_name'],
                'countries_iso_code_2' => $countries_values['countries_iso_code_2'],
                'countries_iso_code_3' => $countries_values['countries_iso_code_3']);
        } else {
            $countries = tep_db_query("select countries_name from " . TABLE_COUNTRIES . " where countries_id = '" . (int)$countries_id . "'");
            $countries_values = tep_db_fetch_array($countries);
            $countries_array = array('countries_name' => $countries_values['countries_name']);
        }
    } else {
        $countries = tep_db_query("select countries_id, countries_name from " . TABLE_COUNTRIES . " order by countries_name");
        while ($countries_values = tep_db_fetch_array($countries)) {
            $countries_array[] = array('countries_id' => $countries_values['countries_id'],
                'countries_name' => $countries_values['countries_name']);
        }
    }

    return $countries_array;
}

////
// Alias function to tep_get_countries, which also returns the countries iso codes
function tep_get_countries_with_iso_codes($countries_id)
{
    return tep_get_countries($countries_id, true);
}

// Generate a paths to categories

function tep_get_paths($category_ids = array())
{
    global $cPath_array;
    $cPaths_new = array();
    if (!empty($category_ids)) {
        $cp_size = sizeof($cPath_array);

        $last_category_query = tep_db_query("select parent_id from " . TABLE_CATEGORIES . " where categories_id = '" . (int)$cPath_array[($cp_size - 1)] . "'");
        $last_category = tep_db_fetch_array($last_category_query);

        $current_categories_query = tep_db_query("select parent_id,categories_id from " . TABLE_CATEGORIES . " where categories_id IN (" . implode(',', $category_ids) . ")");

        while ($current_categories = tep_db_fetch_array($current_categories_query)) {
            $current_category_id = $current_categories['categories_id'];
            if ($cp_size == 0) {
                $cPath_new = $current_category_id;
            } else {
                $cPath_new = '';
            }

            if ($last_category['parent_id'] == $current_categories['parent_id']) {
                for ($i = 0; $i < ($cp_size - 1); $i++) {
                    $cPath_new .= '_' . $cPath_array[$i];
                }
            } else {
                for ($i = 0; $i < $cp_size; $i++) {
                    $cPath_new .= '_' . $cPath_array[$i];
                }
            }
            $cPath_new .= '_' . $current_category_id;

            if (substr($cPath_new, 0, 1) == '_') {
                $cPath_new = substr($cPath_new, 1);
            }
            $cPaths_new[$current_category_id] = 'cPath=' . $cPath_new;
        }
    } else {
        $cPaths_new[] = 'cPath=' . implode('_', $cPath_array);
    }

    return $cPaths_new;
}

////
// Generate a path to categories
function tep_get_path($current_category_id = '')
{
    global $cPath_array;

    if (tep_not_null($current_category_id)) {
        $cp_size = sizeof($cPath_array);
        if ($cp_size == 0) {
            $cPath_new = $current_category_id;
        } else {
            $cPath_new = '';
            $last_category_query = tep_db_query("select parent_id from " . TABLE_CATEGORIES . " where categories_id = '" . (int)$cPath_array[($cp_size - 1)] . "'");
            $last_category = tep_db_fetch_array($last_category_query);

            $current_category_query = tep_db_query("select parent_id from " . TABLE_CATEGORIES . " where categories_id = '" . (int)$current_category_id . "'");
            $current_category = tep_db_fetch_array($current_category_query);
            if ($last_category['parent_id'] == $current_category['parent_id']) {
                for ($i = 0; $i < ($cp_size - 1); $i++) {
                    $cPath_new .= '_' . $cPath_array[$i];
                }
            } else {
                for ($i = 0; $i < $cp_size; $i++) {
                    $cPath_new .= '_' . $cPath_array[$i];
                }
            }
            $cPath_new .= '_' . $current_category_id;

            if (substr($cPath_new, 0, 1) == '_') {
                $cPath_new = substr($cPath_new, 1);
            }
        }
    } else {
        $cPath_new = implode('_', $cPath_array);
    }

    return 'cPath=' . $cPath_new;
}

////
// Returns the clients browser
function tep_browser_detect($component)
{
    global $HTTP_USER_AGENT;

    return stristr($HTTP_USER_AGENT, $component);
}

////
// Alias function to tep_get_countries()
function tep_get_country_name($country_id)
{
    $country_array = tep_get_countries($country_id);

    return $country_array['countries_name'];
}

////
// Returns the zone (State/Province) name
// TABLES: zones
function tep_get_zone_name($country_id, $zone_id, $default_zone)
{
    $zone_query = tep_db_query("select zone_name from " . TABLE_ZONES . " where zone_country_id = '" . (int)$country_id . "' and zone_id = '" . (int)$zone_id . "'");
    if (tep_db_num_rows($zone_query)) {
        $zone = tep_db_fetch_array($zone_query);
        return $zone['zone_name'];
    } else {
        return $default_zone;
    }
}

////
// Returns the zone (State/Province) code
// TABLES: zones
function tep_get_zone_code($country_id, $zone_id, $default_zone)
{
    $zone_query = tep_db_query("select zone_code from " . TABLE_ZONES . " where zone_country_id = '" . (int)$country_id . "' and zone_id = '" . (int)$zone_id . "'");
    if (tep_db_num_rows($zone_query)) {
        $zone = tep_db_fetch_array($zone_query);
        return $zone['zone_code'];
    } else {
        return $default_zone;
    }
}

////
// Wrapper function for round()
function tep_round($number, $precision)
{
    if (strpos($number, '.') && (strlen(substr($number, strpos($number, '.') + 1)) > $precision)) {
        $number = substr($number, 0, strpos($number, '.') + 1 + $precision + 1);

        if (substr($number, -1) >= 5) {
            if ($precision > 1) {
                $number = substr($number, 0, -1) + ('0.' . str_repeat(0, $precision - 1) . '1');
            } elseif ($precision == 1) {
                $number = substr($number, 0, -1) + 0.1;
            } else {
                $number = substr($number, 0, -1) + 1;
            }
        } else {
            $number = substr($number, 0, -1);
        }
    }

    return $number;
}

////
// Returns the tax rate for a zone / class
// TABLES: tax_rates, zones_to_geo_zones
//Используется для ускорения
function tep_get_quick_tax_rate($class_id, $country_id = -1, $zone_id = -1)
{
    global $class_tax_rate;
    if (tep_not_null($class_tax_rate) && isset($class_tax_rate[$class_id])) {
        return $class_tax_rate[$class_id];
    } else {
        $tax_query = tep_db_query("select sum(tax_rate) as tax_rate from " . TABLE_TAX_RATES . " tr left join " . TABLE_ZONES_TO_GEO_ZONES . " za on (tr.tax_zone_id = za.geo_zone_id) left join " . TABLE_GEO_ZONES . " tz on (tz.geo_zone_id = tr.tax_zone_id) where (za.zone_country_id is null or za.zone_country_id = '0' or za.zone_country_id = '" . (int)$country_id . "') and (za.zone_id is null or za.zone_id = '0' or za.zone_id = '" . (int)$zone_id . "') and tr.tax_class_id = '" . (int)$class_id . "' group by tr.tax_priority");
        if (tep_db_num_rows($tax_query)) {
            $tax_multiplier = 1.0;
            while ($tax = tep_db_fetch_array($tax_query)) {
                $tax_multiplier *= 1.0 + ($tax['tax_rate'] / 100);
            }
            $class_tax_rate[$class_id] = ($tax_multiplier - 1.0) * 100;
        } else {
            $class_tax_rate[$class_id] = 0;
        }
        return $class_tax_rate[$class_id];
    }
}

function tep_get_tax_rate($class_id, $country_id = -1, $zone_id = -1)
{
    global $customer_zone_id, $customer_country_id;

    if (($country_id == -1) && ($zone_id == -1)) {
        if (!tep_session_is_registered('customer_id')) {
            $country_id = STORE_COUNTRY;
            $zone_id = STORE_ZONE;
        } else {
            $country_id = $customer_country_id;
            $zone_id = $customer_zone_id;
        }
        return tep_get_quick_tax_rate($class_id, $country_id, $zone_id);
    }
    $tax_query = tep_db_query("select sum(tax_rate) as tax_rate from " . TABLE_TAX_RATES . " tr left join " . TABLE_ZONES_TO_GEO_ZONES . " za on (tr.tax_zone_id = za.geo_zone_id) left join " . TABLE_GEO_ZONES . " tz on (tz.geo_zone_id = tr.tax_zone_id) where (za.zone_country_id is null or za.zone_country_id = '0' or za.zone_country_id = '" . (int)$country_id . "') and (za.zone_id is null or za.zone_id = '0' or za.zone_id = '" . (int)$zone_id . "') and tr.tax_class_id = '" . (int)$class_id . "' group by tr.tax_priority");
    if (tep_db_num_rows($tax_query)) {
        $tax_multiplier = 1.0;
        while ($tax = tep_db_fetch_array($tax_query)) {
            $tax_multiplier *= 1.0 + ($tax['tax_rate'] / 100);
        }
        return ($tax_multiplier - 1.0) * 100;
    } else {
        return 0;
    }
}

////
// Return the tax description for a zone / class
// TABLES: tax_rates;
function tep_get_tax_description($class_id, $country_id, $zone_id)
{
    $tax_query = tep_db_query("select tax_description from " . TABLE_TAX_RATES . " tr left join " . TABLE_ZONES_TO_GEO_ZONES . " za on (tr.tax_zone_id = za.geo_zone_id) left join " . TABLE_GEO_ZONES . " tz on (tz.geo_zone_id = tr.tax_zone_id) where (za.zone_country_id is null or za.zone_country_id = '0' or za.zone_country_id = '" . (int)$country_id . "') and (za.zone_id is null or za.zone_id = '0' or za.zone_id = '" . (int)$zone_id . "') and tr.tax_class_id = '" . (int)$class_id . "' order by tr.tax_priority");
    if (tep_db_num_rows($tax_query)) {
        $tax_description = '';
        while ($tax = tep_db_fetch_array($tax_query)) {
            $tax_description .= $tax['tax_description'] . ' + ';
        }
        $tax_description = substr($tax_description, 0, -3);

        return $tax_description;
    } else {
        return TEXT_UNKNOWN_TAX_RATE;
    }
}

////
// Add tax to a products price
function tep_add_tax($price, $tax)
{

    if ((DISPLAY_PRICE_WITH_TAX == 'true') && ($tax > 0)) {
        return $price + tep_calculate_tax($price, $tax);
    } else {
        return $price;
    }
}

// Calculates Tax rounding the result
function tep_calculate_tax($price, $tax)
{
    return $price * $tax / 100;
}

////
// Return the number of products in a category
// TABLES: products, products_to_categories, categories
function tep_count_products_in_category($category_id, $include_inactive = false)
{
    $products_count = 0;
    if ($include_inactive == true) {
        $products_query = tep_db_query("select count(*) as total from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c where p.products_id = p2c.products_id and p2c.categories_id = '" . (int)$category_id . "'");
    } else {
        $products_query = tep_db_query("select count(*) as total from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c where p.products_id = p2c.products_id and p.products_status = '1' and p2c.categories_id = '" . (int)$category_id . "'");
    }
    $products = tep_db_fetch_array($products_query);
    $products_count += $products['total'];

    $child_categories_query = tep_db_query("select categories_id from " . TABLE_CATEGORIES . " where parent_id = '" . (int)$category_id . "'");
    if (tep_db_num_rows($child_categories_query)) {
        while ($child_categories = tep_db_fetch_array($child_categories_query)) {
            $products_count += tep_count_products_in_category($child_categories['categories_id'], $include_inactive);
        }
    }

    return $products_count;
}

////
// Return true if the category has subcategories
// TABLES: categories
function tep_has_category_subcategories($category_id)
{
    $child_category_query = tep_db_query("select count(*) as count from " . TABLE_CATEGORIES . " where parent_id = '" . (int)$category_id . "'");
    $child_category = tep_db_fetch_array($child_category_query);

    if ($child_category['count'] > 0) {
        return true;
    } else {
        return false;
    }
}

////
// Returns the address_format_id for the given country
// TABLES: countries;
function tep_get_address_format_id($country_id)
{
    $address_format_query = tep_db_query("select address_format_id as format_id from " . TABLE_COUNTRIES . " where countries_id = '" . (int)$country_id . "'");
    if (tep_db_num_rows($address_format_query)) {
        $address_format = tep_db_fetch_array($address_format_query);
        return $address_format['format_id'];
    } else {
        return '1';
    }
}

////
// Return a formatted address
// TABLES: address_format
function tep_address_format($address_format_id, $address, $html, $boln, $eoln)
{
    $address_format_id = ($address_format_id ? $address_format_id : 1);
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
//        $state = tep_get_zone_code($address['country_id'], $address['zone_id'], $state);
            $state = tep_get_zone_name($address['country_id'], $address['zone_id'], $state);
        }
    } elseif (isset($address['country']) && tep_not_null($address['country'])) {
        $country = tep_output_string_protected($address['country']['title']);
    } else {
        $country = '';
    }
    $postcode = tep_output_string_protected($address['postcode']);
    $zip = $postcode;

    if ($html) {
// HTML Mode
        $HR = '<hr>';
        $hr = '<hr>';
        if (($boln == '') && ($eoln == "\n")) { // Values not specified, use rational defaults
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
    if ($state != '') $statecomma = $state . ', ';

    $fmt = $address_format['format'];
    eval("\$address = \"$fmt\";");

    if ((ACCOUNT_COMPANY == 'true') && (tep_not_null($company))) {
        $address = $company . $cr . $address;
    }

    return $address;
}

////
// Return a formatted address
// TABLES: customers, address_book
function tep_address_label($customers_id, $address_id = 1, $html = false, $boln = '', $eoln = "\n")
{
    if (is_array($address_id) && !empty($address_id)) {
        return tep_address_format($address_id['address_format_id'], $address_id, $html, $boln, $eoln);
    }

    $address_query = tep_db_query("select entry_firstname as firstname, entry_lastname as lastname, entry_company as company, entry_street_address as street_address, entry_suburb as suburb, entry_city as city, entry_postcode as postcode, entry_state as state, entry_zone_id as zone_id, entry_country_id as country_id from " . TABLE_ADDRESS_BOOK . " where customers_id = '" . (int)$customers_id . "' and address_book_id = '" . (int)$address_id . "'");
    $address = tep_db_fetch_array($address_query);

    $format_id = tep_get_address_format_id($address['country_id']);

    return tep_address_format($format_id, $address, $html, $boln, $eoln);
}

function tep_row_number_format($number)
{
    if (($number < 10) && (substr($number, 0, 1) != '0')) $number = '0' . $number;

    return $number;
}

function tep_get_categories($categories_array = '', $parent_id = '0', $indent = '')
{
    global $languages_id;

    if (!is_array($categories_array)) $categories_array = array();

    $categories_query = tep_db_query("select c.categories_id, cd.categories_name from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd where parent_id = '" . (int)$parent_id . "' and c.categories_status = '1' and c.categories_id = cd.categories_id and cd.language_id = '" . (int)$languages_id . "' order by sort_order, cd.categories_name");
    while ($categories = tep_db_fetch_array($categories_query)) {
        $categories_array[] = array('id' => $categories['categories_id'],
            'text' => $indent . $categories['categories_name']);

        if ($categories['categories_id'] != $parent_id) {
            $categories_array = tep_get_categories($categories_array, $categories['categories_id'], $indent . '&nbsp;&nbsp;');
        }
    }

    return $categories_array;
}

function tep_get_manufacturers($manufacturers_array = '')
{
    if (!is_array($manufacturers_array)) $manufacturers_array = array();

// BOF manufacturers descriptions
    //$manufacturers_query = tep_db_query("select manufacturers_id, manufacturers_name from " . TABLE_MANUFACTURERS . " order by manufacturers_name");
    global $languages_id;
    $manufacturers_query = tep_db_query("select manufacturers_id, manufacturers_name from " . TABLE_MANUFACTURERS_INFO . " where languages_id = '" . (int)$languages_id . "' order by manufacturers_name");
// EOF manufacturers descriptions
    while ($manufacturers = tep_db_fetch_array($manufacturers_query)) {
        $manufacturers_array[] = array('id' => $manufacturers['manufacturers_id'], 'text' => $manufacturers['manufacturers_name']);
    }

    return $manufacturers_array;
}

////
// Return all subcategory IDs
// TABLES: categories


/**
 * Получаем список дочерних категорий
 * @param int $parent_cat_id - ID родительской категории
 * @return array - массив id категорий
 * @throws DB_exception
 */
function tep_getSubcatIds($parent_cat_id, $only_active = false)
{
    $query = "select categories_id from " . TABLE_CATEGORIES . " where parent_id = '" . (int)$parent_cat_id . "'";
    if ($only_active) {
        $query .= " and categories_status=1";
    }
    $sub_ids_query = tep_db_query($query);
    $sub_ids = array();
    while ($sub_id = tep_db_fetch_array($sub_ids_query)) {
        $sub_ids [] = $sub_id['categories_id'];
    }
    return $sub_ids;
}

/**
 * Рекурсивный поиск подкатегорий
 * @param int $cat_id - ID родительской категории с которой начинаем поиск
 * @return array
 * @throws DB_exception
 */
function tep_recursiveCatList($cat_id = 0, $only_active = false)
{
    $subcat_ids = tep_getSubcatIds($cat_id, $only_active);
    $ids = array();
    if (!empty($subcat_ids)) {
        foreach ($subcat_ids as $subcat_id) {
            $get_subcat_ids = tep_recursiveCatList($subcat_id, $only_active);
            if (!empty($get_subcat_ids)) {
                $ids = array_merge($ids, $get_subcat_ids);
                if ($get_subcat_ids[0] != $subcat_id) {
                    $ids[] = $subcat_id;
                }
            }
        }
    } else {
        return array($cat_id);
    }
    return $ids;
}

/*
 * &$ind - хак, для ускорения сложения массивов,
 * чтобы вместо медленного array_merge можно было использовать оператор +
 */
function tep_quick_get_subcategories($parent_id = 0, $only_active = false, &$ind = 0)
{
    if (!function_exists('read_cache')) {
        include(DIR_WS_FUNCTIONS . 'cache.php');
    }
    if (!read_cache($subcategories_array, 'subcategories-list-' . $parent_id . 'active_' . $only_active . '.cache', 300)) {

        $query = "select categories_id from " . TABLE_CATEGORIES . " where parent_id = '" . (int)$parent_id . "'";
        if ($only_active) {
            $query .= " and categories_status=1";
        }
        $subcategories_query = tep_db_query($query);
        $subcategories_array = array();
        while ($subcategories = tep_db_fetch_array($subcategories_query)) {
            if ($subcategories['categories_id'] != $parent_id) {
                $subcategories_array += tep_quick_get_subcategories($subcategories['categories_id'], $only_active, $ind);
            }
            $subcategories_array[$ind++] = $subcategories['categories_id'];
        }

        write_cache($subcategories_array, 'subcategories-list-' . $parent_id . 'active_' . $only_active . '.cache');
    }
    return $subcategories_array;
}

function tep_get_subcategories(&$subcategories_array, $parent_id = 0, $only_active = false)
{
    $subcategories_array = tep_quick_get_subcategories($parent_id, $only_active);
}

// Output a raw date string in the selected locale date format
// $raw_date needs to be in this format: YYYY-MM-DD HH:MM:SS
function tep_date_long($raw_date)
{
    if (($raw_date == '0000-00-00 00:00:00') || ($raw_date == '')) return false;

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
function tep_date_short($raw_date)
{
    if (($raw_date == '0000-00-00 00:00:00') || empty($raw_date)) return false;

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

////
// Parse search string into indivual objects
function tep_parse_search_string($search_str = '', &$objects)
{
    $search_str = trim(strtolower($search_str));

// Break up $search_str on whitespace; quoted string will be reconstructed later
    $pieces = preg_split('/[[:space:]]+/', $search_str);
    $objects = array();
    $tmpstring = '';
    $flag = '';

    for ($k = 0; $k < count($pieces); $k++) {
        while (substr($pieces[$k], 0, 1) == '(') {
            $objects[] = '(';
            if (strlen($pieces[$k]) > 1) {
                $pieces[$k] = substr($pieces[$k], 1);
            } else {
                $pieces[$k] = '';
            }
        }

        $post_objects = array();

        while (substr($pieces[$k], -1) == ')') {
            $post_objects[] = ')';
            if (strlen($pieces[$k]) > 1) {
                $pieces[$k] = substr($pieces[$k], 0, -1);
            } else {
                $pieces[$k] = '';
            }
        }

// Check individual words

        if ((substr($pieces[$k], -1) != '"') && (substr($pieces[$k], 0, 1) != '"')) {
            $objects[] = trim($pieces[$k]);

            for ($j = 0; $j < count($post_objects); $j++) {
                $objects[] = $post_objects[$j];
            }
        } else {
            /* This means that the $piece is either the beginning or the end of a string.
               So, we'll slurp up the $pieces and stick them together until we get to the
               end of the string or run out of pieces.
            */

// Add this word to the $tmpstring, starting the $tmpstring
            $tmpstring = trim(preg_replace('/"/', ' ', $pieces[$k]));

// Check for one possible exception to the rule. That there is a single quoted word.
            if (substr($pieces[$k], -1) == '"') {
// Turn the flag off for future iterations
                $flag = 'off';

                $objects[] = trim($pieces[$k]);

                for ($j = 0; $j < count($post_objects); $j++) {
                    $objects[] = $post_objects[$j];
                }

                unset($tmpstring);

// Stop looking for the end of the string and move onto the next word.
                continue;
            }

// Otherwise, turn on the flag to indicate no quotes have been found attached to this word in the string.
            $flag = 'on';

// Move on to the next word
            $k++;

// Keep reading until the end of the string as long as the $flag is on

            while (($flag == 'on') && ($k < count($pieces))) {
                while (substr($pieces[$k], -1) == ')') {
                    $post_objects[] = ')';
                    if (strlen($pieces[$k]) > 1) {
                        $pieces[$k] = substr($pieces[$k], 0, -1);
                    } else {
                        $pieces[$k] = '';
                    }
                }

// If the word doesn't end in double quotes, append it to the $tmpstring.
                if (substr($pieces[$k], -1) != '"') {
// Tack this word onto the current string entity
                    $tmpstring .= ' ' . $pieces[$k];

// Move on to the next word
                    $k++;
                    continue;
                } else {
                    /* If the $piece ends in double quotes, strip the double quotes, tack the
                       $piece onto the tail of the string, push the $tmpstring onto the $haves,
                       kill the $tmpstring, turn the $flag "off", and return.
                    */
                    $tmpstring .= ' ' . trim(preg_replace('/"/', ' ', $pieces[$k]));

// Push the $tmpstring onto the array of stuff to search for
                    $objects[] = trim($tmpstring);

                    for ($j = 0; $j < count($post_objects); $j++) {
                        $objects[] = $post_objects[$j];
                    }

                    unset($tmpstring);

// Turn off the flag to exit the loop
                    $flag = 'off';
                }
            }
        }
    }

// add default logical operators if needed
    $temp = array();
    for ($i = 0; $i < (count($objects) - 1); $i++) {
        $temp[] = $objects[$i];
        if (($objects[$i] != 'and') &&
            ($objects[$i] != 'or') &&
            ($objects[$i] != '(') &&
            ($objects[$i + 1] != 'and') &&
            ($objects[$i + 1] != 'or') &&
            ($objects[$i + 1] != ')')) {
            $temp[] = ADVANCED_SEARCH_DEFAULT_OPERATOR;
        }
    }
    $temp[] = $objects[$i];
    $objects = $temp;

    $keyword_count = 0;
    $operator_count = 0;
    $balance = 0;
    for ($i = 0; $i < count($objects); $i++) {
        if ($objects[$i] == '(') $balance--;
        if ($objects[$i] == ')') $balance++;
        if (($objects[$i] == 'and') || ($objects[$i] == 'or')) {
            $operator_count++;
        } elseif (($objects[$i]) && ($objects[$i] != '(') && ($objects[$i] != ')')) {
            $keyword_count++;
        }
    }

    if (($operator_count < $keyword_count) && ($balance == 0)) {
        return true;
    } else {
        return false;
    }
}

////
// Check date
function tep_checkdate($date_to_check, $format_string, &$date_array)
{
    $separator_idx = -1;

    $separators = array('-', ' ', '/', '.');
    $month_abbr = array('jan', 'feb', 'mar', 'apr', 'may', 'jun', 'jul', 'aug', 'sep', 'oct', 'nov', 'dec');
    $no_of_days = array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);

    $format_string = strtolower($format_string);

    if (strlen($date_to_check) != strlen($format_string)) {
        return false;
    }

    $size = sizeof($separators);
    for ($i = 0; $i < $size; $i++) {
        $pos_separator = strpos($date_to_check, $separators[$i]);
        if ($pos_separator != false) {
            $date_separator_idx = $i;
            break;
        }
    }

    for ($i = 0; $i < $size; $i++) {
        $pos_separator = strpos($format_string, $separators[$i]);
        if ($pos_separator != false) {
            $format_separator_idx = $i;
            break;
        }
    }

    if ($date_separator_idx != $format_separator_idx) {
        return false;
    }

    if ($date_separator_idx != -1) {
        $format_string_array = explode($separators[$date_separator_idx], $format_string);
        if (sizeof($format_string_array) != 3) {
            return false;
        }

        $date_to_check_array = explode($separators[$date_separator_idx], $date_to_check);
        if (sizeof($date_to_check_array) != 3) {
            return false;
        }

        $size = sizeof($format_string_array);
        for ($i = 0; $i < $size; $i++) {
            if ($format_string_array[$i] == 'mm' || $format_string_array[$i] == 'mmm') $month = $date_to_check_array[$i];
            if ($format_string_array[$i] == 'dd') $day = $date_to_check_array[$i];
            if (($format_string_array[$i] == 'yyyy') || ($format_string_array[$i] == 'aaaa')) $year = $date_to_check_array[$i];
        }
    } else {
        if (strlen($format_string) == 8 || strlen($format_string) == 9) {
            $pos_month = strpos($format_string, 'mmm');
            if ($pos_month != false) {
                $month = substr($date_to_check, $pos_month, 3);
                $size = sizeof($month_abbr);
                for ($i = 0; $i < $size; $i++) {
                    if ($month == $month_abbr[$i]) {
                        $month = $i;
                        break;
                    }
                }
            } else {
                $month = substr($date_to_check, strpos($format_string, 'mm'), 2);
            }
        } else {
            return false;
        }

        $day = substr($date_to_check, strpos($format_string, 'dd'), 2);
        $year = substr($date_to_check, strpos($format_string, 'yyyy'), 4);
    }

    if (strlen($year) != 4) {
        return false;
    }

    if (!settype($year, 'integer') || !settype($month, 'integer') || !settype($day, 'integer')) {
        return false;
    }

    if ($month > 12 || $month < 1) {
        return false;
    }

    if ($day < 1) {
        return false;
    }

    if (tep_is_leap_year($year)) {
        $no_of_days[1] = 29;
    }

    if ($day > $no_of_days[$month - 1]) {
        return false;
    }

    $date_array = array($year, $month, $day);

    return true;
}

////
// Check if year is a leap year
function tep_is_leap_year($year)
{
    if ($year % 100 == 0) {
        if ($year % 400 == 0) return true;
    } else {
        if (($year % 4) == 0) return true;
    }

    return false;
}

////
// Return table heading with sorting capabilities
function tep_create_sort_heading($sortby, $colnum, $heading)
{
    global $PHP_SELF;

    $sort_prefix = '';
    $sort_suffix = '';

    if ($sortby) {
        $sort_prefix = '<a href="' . tep_href_link(basename($PHP_SELF), tep_get_all_get_params(array('page', 'info', 'sort')) . 'page=1&sort=' . $colnum . ($sortby == $colnum . 'a' ? 'd' : 'a')) . '" title="' . tep_output_string(TEXT_SORT_PRODUCTS . ($sortby == $colnum . 'd' || substr($sortby, 0, 1) != $colnum ? TEXT_ASCENDINGLY : TEXT_DESCENDINGLY) . TEXT_BY . $heading) . '" class="productListing-heading">';
        $sort_suffix = (substr($sortby, 0, 1) == $colnum ? (substr($sortby, 1, 1) == 'a' ? '+' : '-') : '') . '</a>';
    }

    return $sort_prefix . $heading . $sort_suffix;
}

////
// Recursively go through the categories and retreive all parent categories IDs
// TABLES: categories
function tep_get_parent_categories(&$categories, $categories_id)
{
    $parent_categories_query = tep_db_query("select parent_id from " . TABLE_CATEGORIES . " where categories_id = '" . (int)$categories_id . "'");
    while ($parent_categories = tep_db_fetch_array($parent_categories_query)) {
        if ($parent_categories['parent_id'] == 0) return true;
        $categories[sizeof($categories)] = $parent_categories['parent_id'];
        if ($parent_categories['parent_id'] != $categories_id) {
            tep_get_parent_categories($categories, $parent_categories['parent_id']);
        }
    }
}

////
// Construct a category path to the product
// TABLES: products_to_categories
function tep_get_product_path($products_id)
{
    $cPath = '';

    $category_query = tep_db_query("select p2c.categories_id from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c where p.products_id = '" . (int)$products_id . "' and p.products_status = '1' and p.products_id = p2c.products_id limit 1");
    if (tep_db_num_rows($category_query)) {
        $category = tep_db_fetch_array($category_query);

        $categories = array();
        tep_get_parent_categories($categories, $category['categories_id']);

        $categories = array_reverse($categories);

        $cPath = implode('_', $categories);

        if (tep_not_null($cPath)) $cPath .= '_';
        $cPath .= $category['categories_id'];
    }

    return $cPath;
}

////
// Return a product ID with attributes
function tep_get_uprid($prid, $params)
{
    if (is_numeric($prid)) {
        $uprid = $prid;

        if (is_array($params) && (sizeof($params) > 0)) {
            $attributes_check = true;
            $attributes_ids = '';

            reset($params);
            while (list($option, $value) = each($params)) {
                if (is_numeric($option) && is_numeric($value)) {

// otf 1.71 Add processing around $value. This is needed for text attributes.
                    $attributes_ids .= '{' . (int)$option . '}' . (int)$value;

                    // Add else stmt to process product ids passed in by other routines.

                } else {
                    $attributes_ids .= htmlspecialchars(stripslashes($attributes_ids), ENT_QUOTES);
                    $attributes_check = false;
                    break;
                }
            }

            if ($attributes_check == true) {
                $uprid .= $attributes_ids;
            }
        }
    } else {
        $uprid = tep_get_prid($prid);

        if (is_numeric($uprid)) {
            if (strpos($prid, '{') !== false) {
                $attributes_check = true;
                $attributes_ids = '';

// strpos()+1 to remove up to and including the first { which would create an empty array element in explode()
                $attributes = explode('{', substr($prid, strpos($prid, '{') + 1));

                for ($i = 0, $n = sizeof($attributes); $i < $n; $i++) {
                    $pair = explode('}', $attributes[$i]);

                    if (is_numeric($pair[0]) && is_numeric($pair[1])) {
                        $attributes_ids .= '{' . (int)$pair[0] . '}' . (int)$pair[1];
                    } else {
                        $attributes_check = false;
                        break;
                    }
                }

                if ($attributes_check == true) {
                    $uprid .= $attributes_ids;
                }
            }
        } else {
            return false;
        }
    }

    return $uprid;
}

////
// Return a product ID from a product ID with attributes
function tep_get_prid($uprid)
{
    $pieces = explode('{', $uprid);

    if (is_numeric($pieces[0])) {
        return $pieces[0];
    } else {
        return false;
    }
}

////
// Return a customer greeting
function tep_customer_greeting()
{
    global $customer_id, $customer_first_name;

    if (tep_session_is_registered('customer_first_name') && tep_session_is_registered('customer_id')) {
        $greeting_string = sprintf(TEXT_GREETING_PERSONAL, tep_output_string_protected($customer_first_name), tep_href_link(FILENAME_PRODUCTS_NEW));
    } else {
        $greeting_string = sprintf(TEXT_GREETING_GUEST, tep_href_link(FILENAME_LOGIN, '', 'SSL'), tep_href_link(FILENAME_CREATE_ACCOUNT, '', 'SSL'));
    }

    return $greeting_string;
}

////
//! Send email (text/html) using MIME
// This is the central mail function. The SMTP Server should be configured
// correct in php.ini
// Parameters:
// $to_name           The name of the recipient, e.g. "Jan Wildeboer"
// $to_email_address  The eMail address of the recipient,
//                    e.g. jan.wildeboer@gmx.de
// $email_subject     The subject of the eMail
// $email_text        The text of the eMail, may contain HTML entities
// $from_email_name   The name of the sender, e.g. Shop Administration
// $from_email_adress The eMail address of the sender,
//                    e.g. info@mytepshop.com

function tep_mail($to_name, $to_email_address, $email_subject, $email_text, $from_email_name, $from_email_address, $force_html = false)
{
    if (SEND_EMAILS != 'true') return false;

    // Instantiate a new mail object
    $message = new PHPMailer();

    $message->CharSet = CHARSET;

    if (EMAIL_TRANSPORT == 'smtp') {
        $message->IsSMTP();
        $message->SMTPKeepAlive = true;
        $message->SMTPAuth = EMAIL_SMTP_AUTH;
        $message->Username = EMAIL_SMTP_USERNAME;
        $message->Password = EMAIL_SMTP_PASSWORD;
        $message->Host = EMAIL_SMTP_SERVER; // SMTP server
        $message->Port = EMAIL_SMTP_PORT;
    } else {
        $message->IsMail(); // telling the class to use SMTP
    }

    // Config

    if (!tep_not_null($from_email_address)) {
        $from_email_address = SMTP_SENDMAIL_FROM;
    }

    $message->From = $from_email_address;

    if (!tep_not_null($from_email_name)) {
        $from_email_name = SMTP_FROMEMAIL_NAME;
    }

    $message->FromName = $from_email_name;

    if (!tep_not_null($to_name)) {
        $to_name = '';
    }

    if (!tep_not_null($to_email_address)) {
        return false;
    }

    $message->AddAddress($to_email_address, $to_name);

    $message->Subject = $email_subject;

    // Build the text version
    $text = strip_tags($email_text);
    if ((EMAIL_USE_HTML == 'true') || ($force_html == true)) {
        $message->Body = tep_convert_linefeeds(array("\r\n", "\n", "\r"), '<br>', $email_text);
        $message->AltBody = $text;
        $message->IsHTML(true);
    } else {
        $message->Body = $text;
        $message->IsHTML(false);
    }


    // Send message
    if (!$message->Send()) {
        /*echo 'Email was not sent.';
        echo 'Mailer error: ' . $message->ErrorInfo;*/
        return false;
    }
}

// Check if product has attributes
function tep_has_products_attributes($product_ids)
{
    $has_products_attributes = array();
    $attributes_query = tep_db_query("select products_id from " . TABLE_PRODUCTS_ATTRIBUTES . " where products_id IN (" . implode(',', $product_ids) . ") group by products_id");
    while ($attributes = tep_db_fetch_array($attributes_query)) {
        $has_products_attributes[$attributes['products_id']] = true;
    }
    return $has_products_attributes;
}

////
// Check if product has attributes
function tep_has_product_attributes($products_id)
{
    $attributes_query = tep_db_query("select count(*) as count from " . TABLE_PRODUCTS_ATTRIBUTES . " where products_id = '" . (int)$products_id . "'");
    $attributes = tep_db_fetch_array($attributes_query);

    if ($attributes['count'] > 0) {
        return true;
    } else {
        return false;
    }
}

////
// Get the number of times a word/character is present in a string
function tep_word_count($string, $needle)
{
    $temp_array = preg_split('/' . $needle . '/', $string);

    return sizeof($temp_array);
}

function tep_count_modules($modules = '')
{
    $count = 0;

    if (empty($modules)) return $count;

    $modules_array = preg_split('/;/', $modules);

    for ($i = 0, $n = sizeof($modules_array); $i < $n; $i++) {
        $class = substr($modules_array[$i], 0, strrpos($modules_array[$i], '.'));

        if (is_object($GLOBALS[$class])) {
            if ($GLOBALS[$class]->enabled) {
                $count++;
            }
        }
    }

    return $count;
}

function tep_count_payment_modules()
{
    return tep_count_modules(MODULE_PAYMENT_INSTALLED);
}

function tep_count_shipping_modules()
{
    return tep_count_modules(MODULE_SHIPPING_INSTALLED);
}

function tep_create_random_value($length, $type = 'mixed')
{
    if (($type != 'mixed') && ($type != 'chars') && ($type != 'digits')) return false;

    $rand_value = '';
    while (strlen($rand_value) < $length) {
        if ($type == 'digits') {
            $char = tep_rand(0, 9);
        } else {
            $char = chr(tep_rand(0, 255));
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

function tep_array_to_string($array, $exclude = '', $equals = '=', $separator = '&')
{
    if (!is_array($exclude)) $exclude = array();

    $get_string = '';
    if (sizeof($array) > 0) {
        while (list($key, $value) = each($array)) {
            if ((!in_array($key, $exclude)) && ($key != 'x') && ($key != 'y')) {
                $get_string .= $key . $equals . $value . $separator;
            }
        }
        $remove_chars = strlen($separator);
        $get_string = substr($get_string, 0, -$remove_chars);
    }

    return $get_string;
}

function tep_not_null($value)
{
    if (is_array($value)) {
        if (sizeof($value) > 0) {
            return true;
        } else {
            return false;
        }
    } else {
        if (($value != '') && (strtolower($value) != 'null') && (strlen(trim($value)) > 0)) {
            return true;
        } else {
            return false;
        }
    }
}

////
// Output the tax percentage with optional padded decimals
function tep_display_tax_value($value, $padding = TAX_DECIMAL_PLACES)
{
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
            $decimals = strlen(substr($value, ($decimal_pos + 1)));
            for ($i = $decimals; $i < $padding; $i++) {
                $value .= '0';
            }
        } else {
            $value .= '.';
            for ($i = 0; $i < $padding; $i++) {
                $value .= '0';
            }
        }
    }

    return $value;
}

////
// Checks to see if the currency code exists as a currency
// TABLES: currencies
function tep_currency_exists($code)
{
    $code = tep_db_prepare_input($code);

    $currency_query = tep_db_query("select code from " . TABLE_CURRENCIES . " where code = '" . tep_db_input($code) . "' limit 1");
    if (tep_db_num_rows($currency_query)) {
        $currency = tep_db_fetch_array($currency_query);
        return $currency['code'];
    } else {
        return false;
    }
}

function tep_string_to_int($string)
{
    return (int)$string;
}

////
// Parse and secure the cPath parameter values
function tep_parse_category_path($cPath)
{
// make sure the category IDs are integers
    $cPath_array = array_map('tep_string_to_int', explode('_', $cPath));

// make sure no duplicate category IDs exist which could lock the server in a loop
    $tmp_array = array();
    $n = sizeof($cPath_array);
    for ($i = 0; $i < $n; $i++) {
        if (!in_array($cPath_array[$i], $tmp_array)) {
            $tmp_array[] = $cPath_array[$i];
        }
    }

    return $tmp_array;
}

////
// Return a random value
function tep_rand($min = null, $max = null)
{
    static $seeded;

    if (!isset($seeded)) {
        mt_srand((double)microtime() * 1000000);
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

function tep_setcookie($name, $value = '', $expire = 0, $path = '/', $domain = '', $secure = ENABLE_SSL)
{
    setcookie($name, $value, $expire, $path, (tep_not_null($domain) ? $domain : ''), $secure, true);
}

function tep_get_ip_address()
{
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

function tep_count_customer_orders($id = '', $check_session = true)
{
    global $customer_id;

    if (is_numeric($id) == false) {
        if (tep_session_is_registered('customer_id')) {
            $id = $customer_id;
        } else {
            return 0;
        }
    }

    if ($check_session == true) {
        if ((tep_session_is_registered('customer_id') == false) || ($id != $customer_id)) {
            return 0;
        }
    }

    $orders_check_query = tep_db_query("select count(*) as total from " . TABLE_ORDERS . " where customers_id = '" . (int)$id . "'");
    $orders_check = tep_db_fetch_array($orders_check_query);

    return $orders_check['total'];
}

function tep_count_customer_address_book_entries($id = '', $check_session = true)
{
    global $customer_id;

    if (is_numeric($id) == false) {
        if (tep_session_is_registered('customer_id')) {
            $id = $customer_id;
        } else {
            return 0;
        }
    }

    if ($check_session == true) {
        if ((tep_session_is_registered('customer_id') == false) || ($id != $customer_id)) {
            return 0;
        }
    }

    $addresses_query = tep_db_query("select count(*) as total from " . TABLE_ADDRESS_BOOK . " where customers_id = '" . (int)$id . "'");
    $addresses = tep_db_fetch_array($addresses_query);

    return $addresses['total'];
}

// nl2br() prior PHP 4.2.0 did not convert linefeeds on all OSs (it only converted \n)
function tep_convert_linefeeds($from, $to, $string)
{
    if ((PHP_VERSION < "4.0.5") && is_array($from)) {
        return preg_replace('/(' . implode('|', $from) . ')/', $to, $string);
    } else {
        return str_replace($from, $to, $string);
    }
}

//TotalB2B start
function tep_xppp_getmaxprices()
{
    //max prices per product
    return 10;
}

function tep_xppp_getpricesnum()
{
//	$prices_query = tep_db_query("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'XPRICES_NUM'");
//    $prices = tep_db_fetch_array($prices_query);
//	return $prices['configuration_value'];
    return XPRICES_NUM;
}

function tep_xppp_getpricelist($ts)
{
    $prices_num = tep_xppp_getpricesnum();
    $price_list = '';
    for ($i = 2; $i <= $prices_num; $i++) {
        if ($ts != NULL) $price_list .= $ts . ".products_price_" . $i . ",";
        else $price_list .= "products_price_" . $i . ",";
    }
    if ($ts != NULL) $price_list .= $ts . ".products_price";
    else $price_list .= "products_price";
    return $price_list;
}

function tep_get_customer_price()
{
    global $customer_id, $customer_price;
    if (tep_not_null($customer_price)) {
        return $customer_price;
    }
    $customer_query = tep_db_query("select g.customers_groups_price from " . TABLE_CUSTOMERS_GROUPS . " g inner join  " . TABLE_CUSTOMERS . " c on g.customers_groups_id = c.customers_groups_id and c.customers_id = '" . $customer_id . "'");
    $customer_query_result = tep_db_fetch_array($customer_query);
    $customer_price = $customer_query_result['customers_groups_price'];
    return $customer_price;
}

function tep_quick_getproductprice($product, $customer_price)
{
    if ($product['products_price_' . $customer_price] == NULL) {
        $product['products_price_' . $customer_price] = $product['products_price'];
    }
    if ((int)$customer_price != 1) {
        $product['products_price'] = $product['products_price_' . $customer_price];
    }
    return extra_product_price($product['products_price']);
}

function tep_xppp_getproductprice($products_id)
{
    global $customer_id;
    $customer_query = tep_db_query("select g.customers_groups_price from " . TABLE_CUSTOMERS_GROUPS . " g inner join  " . TABLE_CUSTOMERS . " c on g.customers_groups_id = c.customers_groups_id and c.customers_id = '" . $customer_id . "'");
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
// BOF FlyOpenair: Extra Product Price
    $product_info['products_price'] = extra_product_price($product_info['products_price']);
// EOF FlyOpenair: Extra Product Price
    return $product_info['products_price'];
}

//TotalB2B end


function tep_get_products_info($product_id)
{
    global $languages_id;

    $product_query = tep_db_query("select products_info from " . TABLE_PRODUCTS_DESCRIPTION . " where products_id = '" . $product_id . "' and language_id = '" . $languages_id . "'");
    $product_info = tep_db_fetch_array($product_query);

    return $product_info['products_info'];
}

function tep_get_manufacturers_name($manufacturers_id)
{
    global $languages_id;

    $product_query = tep_db_query("select manufacturers_name from " . TABLE_MANUFACTURERS_INFO . " where manufacturers_id = '" . $manufacturers_id . "' and languages_id = '" . $languages_id . "'");
    $product_info = tep_db_fetch_array($product_query);

    return $product_info['manufacturers_name'];
}

function tep_get_categories_name($category_id)
{
    global $languages_id;

    $product_query = tep_db_query("select categories_name from " . TABLE_CATEGORIES_DESCRIPTION . " where categories_id = '" . $category_id . "' and language_id = '" . $languages_id . "'");
    $product_info = tep_db_fetch_array($product_query);

    return $product_info['categories_name'];
}

////
//CLR 030228 Add function tep_decode_specialchars
// Decode string encoded with htmlspecialchars()
function tep_decode_specialchars($string)
{
    $string = str_replace('&gt;', '>', $string);
    $string = str_replace('&lt;', '<', $string);
    $string = str_replace('&#039;', "'", $string);
    $string = str_replace('&quot;', "\"", $string);
    $string = str_replace('&amp;', '&', $string);

    return $string;
}


////
// Return a product's minimum quantity
// TABLES: products

function tep_get_product_quantity_order_min($product)
{
     if ($product['products_quantity'] < 9999) {
         $product['products_quantity_order_min'] = 1;
    }
    return $product['products_quantity_order_min'];
}


function tep_get_products_quantity_order_min($product_id)
{
    $the_products_quantity_order_min_query = tep_db_query("select products_id, products_quantity_order_min,products_quantity from " . TABLE_PRODUCTS . " where products_id = '" . $product_id . "'");
    $the_products_quantity_order_min = tep_db_fetch_array($the_products_quantity_order_min_query);
    if ($the_products_quantity_order_min['products_quantity'] < 9999) {
        $the_products_quantity_order_min['products_quantity_order_min'] = 1;
    }
    return $the_products_quantity_order_min['products_quantity_order_min'];
}

////
// Return a product's minimum unit order
// TABLES: products
function tep_get_product_quantity_order_units($product)
{
    if ($product['products_quantity'] < 9999) {
        $product['products_quantity_order_units'] = 1;
    }

    return $product['products_quantity_order_units'];
}
function tep_get_products_quantity_order_units($product_id)
{
    $the_products_quantity_order_units_query = tep_db_query("select products_id,products_quantity,products_quantity_order_units from " . TABLE_PRODUCTS . " where products_id = '" . $product_id . "'");
    $the_products_quantity_order_units = tep_db_fetch_array($the_products_quantity_order_units_query);
    if ($the_products_quantity_order_units['products_quantity'] < 9999) {
        $the_products_quantity_order_units['products_quantity_order_units'] = 1;
    }

    return $the_products_quantity_order_units['products_quantity_order_units'];
}

// begin mod for ProductsProperties v2.01
function tep_get_prop_options_name($options_id, $language = '')
{
    global $languages_id;

    if (empty($language)) $language = $languages_id;

    $options = tep_db_query("select products_options_name from " . TABLE_PRODUCTS_PROP_OPTIONS . " where products_options_id = '" . (int)$options_id . "' and language_id = '" . (int)$languages_id . "'");
    $options_values = tep_db_fetch_array($options);

    return $options_values['products_options_name'];
}

function tep_get_prop_values_name($values_id, $language = '')
{
    global $languages_id;

    if (empty($language)) $language = $languages_id;

    $values = tep_db_query("select products_options_values_name from " . TABLE_PRODUCTS_PROP_OPTIONS_VALUES . " where products_options_values_id = '" . (int)$values_id . "' and language_id = '" . (int)$languages_id . "'");
    $values_values = tep_db_fetch_array($values);

    return $values_values['products_options_values_name'];
}

// end mod for ProductsProperties v2.01

////
// saved from old code
function tep_output_warning($warning)
{
    new errorBox(array(array('text' => tep_image(DIR_WS_ICONS . 'warning.gif', ICON_WARNING) . ' ' . $warning)));
}

function tep_get_languages_id($code)
{
    global $languages_id;
    $language_query = tep_db_query("select languages_id from " . TABLE_LANGUAGES . " where code = '" . DEFAULT_LANGUAGE . "'");
    if (tep_db_num_rows($language_query)) {
        $language = tep_db_fetch_array($language_query);
        $languages_id = $language['languages_id'];
        return $language['languages_id'];
    } else {
        return false;
    }
}

function tep_get_extra_fields($customer_id, $languages_id)
{
    $extra_fields_query = tep_db_query("select ce.fields_id, ce.fields_input_type, ce.fields_input_value, ce.fields_required_status, cei.fields_name, ce.fields_status, ce.fields_input_type from " . TABLE_EXTRA_FIELDS . " ce, " . TABLE_EXTRA_FIELDS_INFO . " cei where ce.fields_status=1 and cei.fields_id=ce.fields_id and cei.languages_id =" . $languages_id);
    $extra_fields_string = '';
    if (tep_db_num_rows($extra_fields_query) > 0) {
        $extra_fields_string .= '<tr><td class="formAreaTitle"><b>' . CATEGORY_EXTRA_FIELDS . '</b></td></tr>';
        $extra_fields_string .= '<td class="formArea"><table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBox">
                                     <tr class="infoBoxContents"><td><table border="0" cellspacing="2" cellpadding="2">';
        while ($extra_fields = tep_db_fetch_array($extra_fields_query)) {
            $value = '';
            if (isset($customer_id)) {
                $value_query = tep_db_query("select value from " . TABLE_CUSTOMERS_TO_EXTRA_FIELDS . " where customers_id=" . $customer_id . " and fields_id=" . $extra_fields['fields_id']);
                $value_info = tep_db_fetch_array($value_query);
                $value_list = explode("\n", $value_info['value']);
                for ($i = 0, $n = sizeof($value_list); $i < $n; $i++) {
                    $value_list[$i] = trim($value_list[$i]);
                }
                $value = $value_list[0];
            }
            $extra_fields_string .= '<tr>
                                        <td class="main" valign="top">' . $extra_fields['fields_name'] . ': </td><td class="main" valign="top">';


            $select_values_list = explode("\n", $extra_fields['fields_input_value']);
            $select_values = array();
            foreach ($select_values_list as $item) {
                $item = trim($item);
                $select_values[] = array('id' => $item, 'text' => $item);
            }

            switch ($extra_fields['fields_input_type']) {
                case  0:
                    $extra_fields_string .= tep_draw_input_field('fields_' . $extra_fields['fields_id'], $value) . (($extra_fields['fields_required_status'] == 1) ? '<span class="inputRequirement">*</span>' : '');
                    break;
                case  1:
                    $extra_fields_string .= tep_draw_textarea_field('fields_' . $extra_fields['fields_id'], 'soft', 50, 6, $value, 'style="width:400px;"') . (($extra_fields['fields_required_status'] == 1) ? '<span class="inputRequirement">*</span>' : '');
                    break;
                case  2:
                    foreach ($select_values_list as $item) {
                        $item = trim($item);
                        $extra_fields_string .= tep_draw_selection_field('fields_' . $extra_fields['fields_id'], 'radio', $item, (($value == $item) ? (true) : (false))) . $item . (($extra_fields['fields_required_status'] == 1) ? '<span class="inputRequirement">*</span>' : '') . '<br>';
                        $extra_fields['fields_required_status'] = 0;
                    }
                    break;
                case  3:
                    $cnt = 1;
                    foreach ($select_values_list as $item) {
                        $item = trim($item);
                        $extra_fields_string .= tep_draw_selection_field('fields_' . $extra_fields['fields_id'] . '_' . ($cnt++), 'checkbox', $item, ((@in_array($item, $value_list)) ? (true) : (false))) . $item . (($extra_fields['fields_required_status'] == 1) ? '<span class="inputRequirement">*</span>' : '') . '<br>';
                        $extra_fields['fields_required_status'] = 0;
                    }
                    $extra_fields_string .= tep_draw_hidden_field('fields_' . $extra_fields['fields_id'] . '_total', $cnt);
                    break;
                case  4:
                    $extra_fields_string .= tep_draw_pull_down_menu('fields_' . $extra_fields['fields_id'], $select_values, $value) . (($extra_fields['fields_required_status'] == 1) ? '<span class="inputRequirement">*</span>' : '');
                    break;
                default:
                    $extra_fields_string .= tep_draw_input_field('fields_' . $extra_fields['fields_id'], $value) . (($extra_fields['fields_required_status'] == 1) ? '<span class="inputRequirement">*</span>' : '');
                    break;
            }

            $extra_fields_string .= ' ' . '</td></tr>';
        }
        $extra_fields_string .= '</table></td></tr></table></td></tr>';
        $extra_fields_string .= '<tr><td>' . tep_draw_separator('pixel_trans.gif', '100%', '10') . '</td></tr>';
    }
    return $extra_fields_string;
}

function tep_store_mail($to_name, $to_email_address, $email_subject, $email_text, $from_email_name, $from_email_address, $hold = '')
{

    if (SEND_EMAILS != 'true') return false;

    $browser_ip = tep_get_ip_address();
    $this_moment = date("Ymd") . ' ' . date("H:i:s");
    $sql_data_array = array('to_name' => $to_name,
        'charset' => CHARSET,
        'to_address' => $to_email_address,
        'subject' => $email_subject,
        'text' => $email_text,
        'from_name' => $from_email_name,
        'from_address' => $from_email_address,
        'last_updated' => $this_moment,
        'created' => $this_moment,
        'hold' => $hold,
        'ip' => $browser_ip);

    tep_db_perform(TABLE_EMAIL_BATCH, $sql_data_array);
}

function tep_get_spsr_zone_id($zone_id)
{
    $spsr_zone_query = tep_db_query("select spsr_zone_id from " . TABLE_SPSR_ZONES . " where zone_id = '" . $zone_id . "'");
    if (tep_db_num_rows($spsr_zone_query)) {
        $spsr_zone = tep_db_fetch_array($spsr_zone_query);
        $spsr_zone_id = $spsr_zone['spsr_zone_id'];
        return $spsr_zone_id;
    } else {
        return false;
    }
}

function make_alias($alias)
{

    //Replace cyrillic symbols to translit
    $trdic = array(
        "ё" => "jo",
        "ж" => "zh",
        "ф" => "ph",
        "х" => "kh",
        "ц" => "ts",
        "ч" => "ch",
        "ш" => "sh",
        "щ" => "sch",
        "э" => "je",
        "ю" => "ju",
        "я" => "ja",

        "а" => "a",
        "б" => "b",
        "в" => "v",
        "г" => "g",
        "д" => "d",
        "е" => "e",
        "з" => "z",
        "и" => "i",
        "й" => "j",
        "к" => "k",
        "л" => "l",
        "м" => "m",
        "н" => "n",
        "о" => "o",
        "п" => "p",
        "р" => "r",
        "с" => "s",
        "т" => "t",
        "у" => "u",
        "х" => "h",
        "ц" => "c",
        "ы" => "y",

        "Ё" => "E",
        "Ж" => "ZH",
        "Ф" => "PH",
        "Х" => "KH",
        "Ц" => "TS",
        "Ч" => "CH",
        "Ш" => "SH",
        "Щ" => "SCH",
        "Э" => "JE",
        "Ю" => "JU",
        "Я" => "JA",

        "А" => "A",
        "Б" => "B",
        "В" => "V",
        "Г" => "G",
        "Д" => "D",
        "Е" => "E",
        "З" => "Z",
        "И" => "I",
        "Й" => "J",
        "К" => "K",
        "Л" => "L",
        "М" => "M",
        "Н" => "N",

        "О" => "O",
        "П" => "P",
        "Р" => "R",
        "С" => "S",
        "Т" => "T",
        "У" => "U",
        "Х" => "H",
        "Ц" => "C",
        "Ы" => "Y",

        // -----------------------
        "Ъ" => "",
        "Ь" => "",
        "ъ" => "",
        "ь" => ""
    );

    if ($alias == "") {
        $alias = rand(1000, 9999);
    }

    //$alias = trim($alias);
    //$alias = strtolower($alias);
    $alias = str_replace(' ', '-', $alias);
    //Replace cyrillic symbols to translit
    $alias = strtr(stripslashes($alias), $trdic);
    $alias = preg_replace("/[^a-zA-Z0-9-s]/", "", $alias);

    return $alias;
}

function tep_RandomString($length)
{
    $chars = array('a', 'A', 'b', 'B', 'c', 'C', 'd', 'D', 'e', 'E', 'f', 'F', 'g', 'G', 'h', 'H', 'i', 'I', 'j', 'J', 'k', 'K', 'l', 'L', 'm', 'M', 'n', 'N', 'o', 'O', 'p', 'P', 'q', 'Q', 'r', 'R', 's', 'S', 't', 'T', 'u', 'U', 'v', 'V', 'w', 'W', 'x', 'X', 'y', 'Y', 'z', 'Z', '1', '2', '3', '4', '5', '6', '7', '8', '9', '0');

    $max_chars = count($chars) - 1;
    srand((double)microtime() * 1000000);

    $rand_str = '';
    for ($i = 0; $i < $length; $i++) {
        $rand_str = ($i == 0) ? $chars[rand(0, $max_chars)] : $rand_str . $chars[rand(0, $max_chars)];
    }

    return $rand_str;
}

// SMART CHECKOUT BOF
// Return a formatted address for noaccount
function tep_address_label_noaccount($sc_ship_case, $html = false, $boln = '', $eoln = "\n")
{
    if ($sc_ship_case == 0) {
        $address = array('company' => $_SESSION['sc_customers_company'],
            'firstname' => $_SESSION['sc_customers_firstname'],
            'lastname' => $_SESSION['sc_customers_lastname'],
            'street_address' => $_SESSION['sc_customers_street_address'],
            'suburb' => $_SESSION['sc_customers_suburb'],
            'city' => $_SESSION['sc_customers_city'],
            'state' => $_SESSION['sc_customers_state'],
            'country_id' => $_SESSION['sc_customers_country'],
            'zone_id' => $_SESSION['sc_customers_zone_id'],
            'postcode' => $_SESSION['sc_customers_postcode']);

    } elseif ($sc_ship_case == 1) { //payment address id different form shipping
        $address = array('company' => $_SESSION['sc_payment_company'],
            'firstname' => $_SESSION['sc_payment_firstname'],
            'lastname' => $_SESSION['sc_payment_lastname'],
            'street_address' => $_SESSION['sc_payment_street_address'],
            'suburb' => $_SESSION['sc_payment_suburb'],
            'city' => $_SESSION['sc_payment_city'],
            'state' => $_SESSION['sc_payment_state'],
            'country_id' => $_SESSION['sc_payment_country'],
            'zone_id' => $_SESSION['sc_payment_zone_id'],
            'postcode' => $_SESSION['sc_payment_postcode']);
    }


    $format_id = tep_get_address_format_id($address['country_id']);

    return tep_address_format($format_id, $address, $html, $boln, $eoln);
}

function GetAllSubCat($catId)
{
    $c2c_array = array();
    $c2c_query = tep_db_query('select c.parent_id,c.categories_id
                    from categories c left join categories c1 on c.parent_id=c1.categories_id
                    order by c.parent_id,c.categories_id');
    if (is_object($c2c_query)) {
        while ($res = tep_db_fetch_array($c2c_query)) {
            $c2c_array[$res['parent_id']][] = $res['categories_id'];
        }
    }
    $cids = array();
    $res = array();
    $j = 0;
    if (is_array($c2c_array[$catId])) {
        $cids[] = $catId;
        do {
            if ($j > 10) {
                break;
            }
            $cid = array_shift($cids);
            $res[] = $cid;
            if (is_array($c2c_array[$cid])) {
                foreach ($c2c_array[$cid] as $key => $value) {
                    $cids[] = $value;
                }
            }
        } while (sizeof($cids) > 0);

    } else {
        $res[] = $catId;
    }
    return $res;
}

function GetMinMaxFromCat($catId)
{//----by iHolder get min max
    if($catId == 0){
        return false;
    }

    $res = array();

    tep_get_subcategories($res, $catId, true);
    $res[] = $catId;
    $m_query = tep_db_query('select min(products_price)as mi,max(products_price) as ma
		       from products p,products_to_categories ptc 
		       where p.products_id=ptc.products_id and
                       p.products_status=1 and p.products_quantity>0 and
                       ptc.categories_id in (' . implode(',', $res) . ')');
    if (is_object($m_query)) {
        $m_res = tep_db_fetch_array($m_query);
        unset ($res);
        $res['min'] = $m_res['mi'];
        $res['max'] = $m_res['ma'];
        return $res;
    }
    return false;
}

function GetCategoriesProductsCount()
{
    if (!function_exists('read_cache')) {
        include(DIR_WS_FUNCTIONS . 'cache.php');
    }
    if (!read_cache($c2c_array, 'categories-product-count.cache', 3600)) {

//---by iHolder-- count products in categories nested--
        $p2c_array = array();
        $c2c_array = array();
        $p2c_query = tep_db_query('select ptc.categories_id,sum(if(p.products_quantity>0,p.products_quantity,0)) as cnt
		           from products_to_categories ptc
                           left join products p on p.products_id=ptc.products_id
                         where p.products_status=1
                        group by ptc.categories_id ');


        while ($res = tep_db_fetch_array($p2c_query)) {
            $p2c_array[$res['categories_id']] = $res['cnt'];
        }

        $c2c_query = tep_db_query('select c.parent_id,c.categories_id
			     from categories c left join categories c1 on c.parent_id=c1.categories_id
			     where c.categories_status="1" and  c1.categories_status="1"
                           order by c.parent_id ,c.categories_id DESC');
        while ($res = tep_db_fetch_array($c2c_query)) {
            $c2c_array[$res['categories_id']] += $p2c_array[$res['categories_id']];
            $c2c_array[$res['parent_id']] += $c2c_array[$res['categories_id']];
        }
        write_cache($c2c_array, 'categories-product-count.cache');
    }
    return $c2c_array;
}

function deductionFromCache($refresh = false)
{
    global $HTTP_GET_VARS, $language, $languages_id;
    $auto_expire = 3600;
    $cache_output = '';
    require_once(DIR_WS_FUNCTIONS . 'cache.php');
    if (($refresh == true) || !read_cache($cache_output, 'get_deduction_map.cache', $auto_expire)) {
        global $PHP_SELF;
        $dproducts = array();
        $dmanufacturers = array();
        $display_cat = array();
        $inactive = array();
        $vPath = (int)$_REQUEST['vPath'];
        $min_price = 1000000;
        $max_price = 0;
        /*Get category map------*/
        $c2c = array();
        $dQuery = 'select c.parent_id,c.categories_id,c.categories_status
                            from categories c 
                            INNER join categories c1 on c.parent_id=c1.categories_id
                            and c1.parent_id=0
                            order by c.parent_id,c.categories_id';
        $c2c_query = tep_db_query($dQuery);
        if ($c2c_query !== false) {
            while ($res = tep_db_fetch_array($c2c_query)) {
                $c2c[$res['parent_id']][] = $res['categories_id'];
                if ($res['categories_status'] == 0) {
                    $inactive[] = $res['categories_id'];
                }
            }
        }
        if (isset($parent_array)) {
            unset($parent_array);
        }
        $start = microtime(true);
        $cat_ids = array_keys($c2c);
        foreach ($cat_ids as $cid) {
            if (isset($c2c[$cid])) {
                $to_process = array_values($c2c[$cid]);
            } else {
                unset($to_process);
                $parent_array[$cid][] = $cid;
            }
            while (sizeof($to_process) > 0) {
                $pa = array_shift($to_process);
                if (in_array($pa, $inactive)) {
                    continue;
                }
                $parent_array[$cid][] = $pa;
                if (isset($c2c[$pa])) {
                    $to_process = array_merge($to_process, array_values($c2c[$pa]));
                }
            }
        }
        $pp = array();
        foreach ($parent_array as $key => $value) {
            $pp['parent'][$key] = $value;
            foreach (array_values($value) as $v) {
                $pp['child'][$v] = $key;
            }
        }

        unset ($parent_array, $c2c, $c2c_query);
        /*Get category map------*/

        //-----get categories,quantities and deductions
        $query = tep_db_query('select sale_pricerange_from,sale_pricerange_to,sale_deduction_value_2,sale_deduction_value,sale_id,sale_categories_all,sale_quantity from salemaker_sales where sale_status=1 and sale_date_start<now()
        and (sale_date_end>now() or sale_date_end = "0000-00-00" )');
        if ($query !== false) {
            while ($res = tep_db_fetch_array($query)) {
                $arr = explode(',', $res['sale_categories_all']);
                $qty[$res['sale_id']] = array(
                    'qty' => $res['sale_quantity'],
                    'sdv' => $res['sale_deduction_value'],
                    'sdv2' => $res['sale_deduction_value_2'],
                    'price_from' => $res['sale_pricerange_from'],
                    'price_to' => $res['sale_pricerange_to']
                );
                foreach ($arr as $category) {
                    if (strlen($category) == 0) {
                        continue;
                    }
                    if (in_array($category, $inactive)) {
                        continue;
                    }
                    $qty[$res['sale_id']]['categories'][] = $category;
                }
                if (!isset($qty[$res['sale_id']]['categories'])) {
                    unset($qty[$res['sale_id']]);
                }
            }
        }

        //-----get categories,quantities and deductions

        //-----calculate categories to be displayed----
        $dQuery = 'select 
            s.products_id, p2c.categories_id,p.products_price as price,
            p.manufacturers_id
            from specials s
            left join
                products_to_categories p2c ON (s.products_id = p2c.products_id)
            left join
            categories c on (c.categories_id=p2c.categories_id)
            left join
                products p ON (s.products_id = p.products_id)
            left join
            manufacturers m ON (m.manufacturers_id = p.manufacturers_id)
            where  s.status = 1 and (s.expires_date > NOW() or s.expires_date is null)
            and c.categories_status=1
            and p.products_quantity>0 ';
        //echo $dQuery;
        $query = tep_db_query($dQuery);
        if ($query !== false) {
            while ($res = tep_db_fetch_array($query)) {
                $display_cat[$pp['child'][$res['categories_id']]] = 1;
                /*fake where syntax*/
                $keep_it = true;
                if (isset($_REQUEST['srmi']) && isset($_REQUEST['srma'])) {
                    $keep_it = $keep_it & ($res['price'] >= (int)$_REQUEST['srmi']) & ($res['price'] <= (int)$_REQUEST['srma']);
                } else {
                    $keep_it = $keep_it & ($res['price'] > 0);
                }
                if (isset($_REQUEST['vPath']) && (strlen($_REQUEST['vPath']) > 0)) {
                    $keep_it = $keep_it & in_array($res['categories_id'], $pp['parent'][$vPath]);
                }
                if (isset($_REQUEST['filter_id']) && (strlen($_REQUEST['filter_id']) > 0)) {
                    if ($keep_it) {
                        $dmanufacturers[$res['manufacturers_id']] = 1;
                    }
                    $keep_it = $keep_it & ($res['manufacturers_id'] == (int)$_REQUEST['filter_id']);
                }
                if ($keep_it) {
                    $dproducts[$res['products_id']] = 1;
                    $dmanufacturers[$res['manufacturers_id']] = 1;
                    if ($res['price'] > $max_price) {
                        $max_price = $res['price'];
                    }
                    if ($res['price'] < $min_price) {
                        $min_price = $res['price'];
                    }
                }

                /*fake where syntax*/
            }
        }
        if (!empty($qty)) {
            foreach ($qty as $quantity => $data) {
                //echo '<pre>';var_dump($qty);echo '</pre>';
                $dQuery = 'select distinct p2c.categories_id,p.products_id,p.products_price as price,
            if (products_quantity>=' . $data['qty'] . ',' . $data['sdv2'] . ',' . $data['sdv'] . ')
             as sdv ,m.manufacturers_id
            from products p
            left join 
                products_to_categories p2c on (p.products_id=p2c.products_id)
                left join
               manufacturers m ON (m.manufacturers_id = p.manufacturers_id)
            left join
                categories c on (c.categories_id=p2c.categories_id)
            where  p.products_status=1 ';
                if (sizeof($data['categories']) > 0) {
                    $dQuery .= ' and p2c.categories_id in (' . implode(',', $data['categories']) . ') ';
                }
                $sql_price_to = '';
                $priceto = intval($data['price_to']);
                if (!empty($priceto)) {
                    $sql_price_to = 'p.products_price between  ' . $data['price_from'] . ' and ' . $data['price_to'];
                } else {
                    $sql_price_to = 'p.products_price >  ' . $data['price_from'];
                }
                $dQuery .= ' and p.products_quantity>0  and c.categories_status=1 
            and (' . $sql_price_to . ') having sdv>0 ';
                //echo $dQuery;exit;

                $query = tep_db_query($dQuery);
                if ($query !== false) {
                    while ($res = tep_db_fetch_array($query)) {
                        $display_cat[$pp['child'][$res['categories_id']]] = 1;
                        /*fake where syntax*/
                        $keep_it = true;
                        if (isset($_REQUEST['srmi']) && isset($_REQUEST['srma'])) {
                            $keep_it = $keep_it & ($res['price'] >= (int)$_REQUEST['srmi']) & ($res['price'] <= (int)$_REQUEST['srma']);
                        } else {
                            $keep_it = $keep_it & ($res['price'] > 0);
                        }
                        if (isset($_REQUEST['vPath']) && (strlen($_REQUEST['vPath']) > 0)) {
                            $keep_it = $keep_it & in_array($res['categories_id'], $pp['parent'][$vPath]);
                        }
                        if (isset($_REQUEST['filter_id']) && (strlen($_REQUEST['filter_id']) > 0)) {
                            if ($keep_it) {
                                $dmanufacturers[$res['manufacturers_id']] = 1;
                            }
                            $keep_it = $keep_it & ($res['manufacturers_id'] == (int)$_REQUEST['filter_id']);
                        }
                        if ($keep_it) {
                            $dproducts[$res['products_id']] = 1;
                            $dmanufacturers[$res['manufacturers_id']] = 1;
                            if ($res['price'] > $max_price) {
                                $max_price = $res['price'];
                            }
                            if ($res['price'] < $min_price) {
                                $min_price = $res['price'];
                            }
                        }
                        /*fake where syntax*/
                    }
                }
            }
        }
        unset($display_cat['']);
        unset($dmanufacturers['']);
        $cache_output = array('products' => $dproducts, 'categories' => $display_cat, 'min' => $min_price, 'max' => $max_price, 'manufacturers' => $dmanufacturers);
        write_cache($cache_output, 'get_deduction_map-' . $_GET['vPath'] . '.cache');
    }
    return $cache_output;
}

function GetDeductionMap($refresh = false)
{
    return deductionFromCache($refresh);
}

function GetCustomersUUID($uid)
{
    $query = tep_db_query('select customers_uuid as uuid,count(*) as cnt from customers where customers_id=' . (int)$uid);
    if ($query !== false) {
        $r = tep_db_fetch_array($query);
        if (((int)$r['cnt'] > 0) &&
            (strlen(trim($r['uuid'])) > 0)) {
            return $r['uuid'];
        } else {
            if (strlen(trim($r['uuid'])) == 0) {
                //---create uniq ID
                do {
                    $uuid = tep_create_random_value(32);
                    $qry = tep_db_query('select count(*) as cnt from customers where customers_uuid="' . $uuid . '"');
                    if ($qry !== false) {
                        $res = tep_db_fetch_array($qry);
                    } else {
                        $res['cnt'] = 0;
                    }
                } while ($res['cnt'] > 0);
                //---create uniq ID
                tep_db_query('update customers set customers_uuid="' . $uuid . '"
	                    where customers_id=' . $uid);
                return $uuid;
            }
        }//--else
    } else {
        return 'AAA';
    }//---if query
}

function tep_get_sc_titles_number()
{
    if (SC_COUNTER_ENABLED == 'true') {
        static $sc_count = 0;
        $sc_count++;
        return $sc_count . '.&nbsp;&nbsp;';
    }
}


////
// Function to handle links between shipping and payment

function ship2pay()
{
    global $shipping, $order;
//	$shipping_module = substr($shipping['id'], 0, strpos($shipping['id'], '_')) . '.php';
    $shipping_module = substr($shipping['id'], strpos($shipping['id'], '_') + 1) . '.php';
    $q_ship2pay = tep_db_query("SELECT payments_allowed, zones_id FROM " . TABLE_SHIP2PAY . " where shipment = '" . $shipping_module . "' and status=1");
    $check_flag = false;
    while ($mods = tep_db_fetch_array($q_ship2pay)) {
        if ($mods['zones_id'] > 0) {
            $check_query = tep_db_query("select zone_id from " . TABLE_ZONES_TO_GEO_ZONES . " where geo_zone_id = '" . $mods['zones_id'] . "' and zone_country_id = '" . $order->delivery['country']['id'] . "' order by zone_id");
            while ($check = tep_db_fetch_array($check_query)) {
                if ($check['zone_id'] < 1) {
                    $check_flag = true;
                    break 2;
                } elseif ($check['zone_id'] == $order->delivery['zone_id']) {
                    $check_flag = true;
                    break 2;
                }
            }
        } else {
            $check_flag = true;
            break;
        }
    }
    if ($check_flag)
        $modules = $mods['payments_allowed'];
    else
        $modules = MODULE_PAYMENT_INSTALLED;
    $modules = explode(';', $modules);
    return ($modules);
}

function SetUserDiscount()
{
    global $customer_id, $_SESSION;
    if (tep_session_is_registered('customer_id')) {
        if (!isset($_SESSION['customer_discount'])) {
            $query = tep_db_query("select g.customers_groups_discount from " . TABLE_CUSTOMERS_GROUPS . " g inner join  " . TABLE_CUSTOMERS . " c on c.customers_groups_id = g.customers_groups_id and c.customers_id = '" . $customer_id . "'");
            $query_result = tep_db_fetch_array($query);
            $customers_groups_discount = $query_result['customers_groups_discount'];
            $query = tep_db_query("select customers_discount from " . TABLE_CUSTOMERS . " where customers_id =  '" . $customer_id . "'");
            $query_result = tep_db_fetch_array($query);
            $customer_discount = $query_result['customers_discount'];
            $customer_discount = $customer_discount + $customers_groups_discount;
            $_SESSION['customer_discount'] = $customer_discount;
        }
    }
}

function finalPrice($price, $price_full, $is_special = false){
 ;
    if (abs($price_full - $price) < $price_full * 0.01 || $price_full < $price) {
        $price = $price_full;
    }
    return $price;
}

function DisplayDiscountPrice($price, $price_full, $is_special = false)
{
    global $currencies;
    $line = '';
    if (abs($price_full - $price) < $price_full * 0.001 || $price_full < $price) {
        $price = $price_full;
    }
    if (round($price, 0) == round($price_full, 0)) {
        $line = $currencies->format_simple($price);
        return 'Цена' . ': ' . $line;
    }
    if ($is_special == false) {
        $line .= '<nobr><s class="cds">' . 'Цена' . ': ' . $currencies->format_simple($price_full) . '</s></nobr><br>
		<nobr><span class="cd">' . 'Цена' . ': ' . $currencies->format_simple($price) . '</span></nobr>';
    } else {
        $line = '<nobr><s class="cds">' . 'Цена' . ': ' . $currencies->format_simple($price_full) . '</s></nobr><br><span class="productSpecialPrice">' .
            'Цена со скидкой' . ': ' . $currencies->format_simple($price) . '</span>';
    }
    return $line;
}

function Display1Click($img)
{
    global $cart;
    if (is_object($cart)) {
        $ret = '	 <script type="text/javascript">
    $(document).ready(function() {
        $("a.a_one_click").fancybox({
        "zoomOpacity"            : true,
        "overlayShow"            : false,
        "zoomSpeedIn"            : 500,
        "zoomSpeedOut"            : 500
    });
    });
</script> 
<div style="display:inline-block;text-align:center;width:100%;"><a href="/1check.php" class="a_one_click">';
        $ret .= '<img style="margin:5px;" src="/templates/' . TEMPLATE_NAME . '/images/' . $img . '" />';
        $ret .= '</a></div>';
        return $ret;
    }
}

?>