<?php
/*
  WebMakers.com Added: attributes_sorter_added_functions.php
  Additional functions for the admin

  Shoppe Enhancement Controller - Copyright (c) 2003 WebMakers.com
  Linda McGrath - osCommerce@WebMakers.com
*/

function tep_delete_products_attributes($delete_product_id) {
  // delete products attributes
//  tep_db_query("delete from " . TABLE_PRODUCTS_ATTRIBUTES_DOWNLOAD . "pad, " . TABLE_PRODUCT_ATTRIBUTES . 'pa where pa.products_id = '" . $delete_product_id . "'" . " and pad.products_attributes_id='" . pa.products_attributes_id . "'");

  // delete associated downloads
  $products_delete_from_query= tep_db_query("select pa.products_id, pad.products_attributes_id from " . TABLE_PRODUCTS_ATTRIBUTES . " pa, " . TABLE_PRODUCTS_ATTRIBUTES_DOWNLOAD . " pad  where pa.products_id='" . $delete_product_id . "' and pad.products_attributes_id= pa.products_attributes_id");
  while ( $products_delete_from=tep_db_fetch_array($products_delete_from_query) ) {
    tep_db_query("delete from " . TABLE_PRODUCTS_ATTRIBUTES_DOWNLOAD . " where products_attributes_id = '" . $products_delete_from['products_attributes_id'] . "'");
  }
//        tep_db_query("delete from " . TABLE_PRODUCTS_ATTRIBUTES . " where products_id = '" . $products_copy_to_check['products_id'] . "'");

  tep_db_query("delete from " . TABLE_PRODUCTS_ATTRIBUTES . " where products_id = '" . $delete_product_id . "'");
}

function tep_copy_products_attributes($products_id_from,$products_id_to) {
  global $copy_attributes_delete_first, $copy_attributes_duplicates_skipped, $copy_attributes_duplicates_overwrite, $copy_attributes_include_downloads, $copy_attributes_include_filename;
  // $products_id_to= $copy_to_products_id;
  // $products_id_from = $pID;
  $products_copy_to_query= tep_db_query("select products_id from " . TABLE_PRODUCTS . " where products_id='" . $products_id_to . "'");
  $products_copy_to_check_query= tep_db_query("select products_id from " . TABLE_PRODUCTS . " where products_id='" . $products_id_to . "'");
  $products_copy_from_query= tep_db_query("select * from " . TABLE_PRODUCTS_ATTRIBUTES . " where products_id='" . $products_id_from . "'");
  $products_copy_from_check_query= tep_db_query("select * from " . TABLE_PRODUCTS_ATTRIBUTES . " where products_id='" . $products_id_from . "'");

// Check for errors in copy request
  if (!$products_copy_from_check=tep_db_fetch_array($products_copy_from_check_query) or !$products_copy_to_check=tep_db_fetch_array($products_copy_to_check_query) or $products_id_to == $products_id_from ) {
    echo '<table width="100%" cellpadding="0" cellspacing="0"><tr>';
    if ($products_id_to == $products_id_from) {
      // same products_id
      echo '<td class="messageStackError">' . tep_image(DIR_WS_ICONS . 'warning.gif', ICON_WARNING) . ATTRIBUTES_COPY_TEXT1 . $products_id_from . ATTRIBUTES_COPY_TEXT2 . $products_id_to . ATTRIBUTES_COPY_TEXT3 . '</td>';
    } else {
      if (!$products_copy_from_check) {
        // no attributes found to copy
        echo '<td class="messageStackError">' . tep_image(DIR_WS_ICONS . 'warning.gif', ICON_WARNING) . ATTRIBUTES_COPY_TEXT4 . $products_id_from . ATTRIBUTES_COPY_TEXT5 . tep_get_products_name($products_id_from) . ATTRIBUTES_COPY_TEXT6 . '</td>';
      } else {
        // invalid products_id
        echo '<td class="messageStackError">' . tep_image(DIR_WS_ICONS . 'warning.gif', ICON_WARNING) . ATTRIBUTES_COPY_TEXT7 . $products_id_to . ATTRIBUTES_COPY_TEXT8 . '</td>';
      }
    }
    echo '</tr></table>';
  } else {

if (false) { // Used for testing
echo $products_id_from . 'x' . $products_id_to . '<br>';
echo $copy_attributes_delete_first;
echo $copy_attributes_duplicates_skipped;
echo $copy_attributes_duplicates_overwrite;
echo $copy_attributes_include_downloads;
echo $copy_attributes_include_filename . '<br>';
} // false for testing

    if ($copy_attributes_delete_first=='1') {
      // delete all attributes and downloads first
        $products_delete_from_query= tep_db_query("select pa.products_id, pad.products_attributes_id from " . TABLE_PRODUCTS_ATTRIBUTES . " pa, " . TABLE_PRODUCTS_ATTRIBUTES_DOWNLOAD . " pad  where pa.products_id='" . $products_id_to . "' and pad.products_attributes_id= pa.products_attributes_id");
        while ( $products_delete_from=tep_db_fetch_array($products_delete_from_query) ) {
          tep_db_query("delete from " . TABLE_PRODUCTS_ATTRIBUTES_DOWNLOAD . " where products_attributes_id = '" . $products_delete_from['products_attributes_id'] . "'");
        }
        tep_db_query("delete from " . TABLE_PRODUCTS_ATTRIBUTES . " where products_id = '" . $products_copy_to_check['products_id'] . "'");
    }

    while ( $products_copy_from=tep_db_fetch_array($products_copy_from_query) ) {
      $rows++;
// This must match the structure of your products_attributes table
// First test for existing attribute already being there
      $check_attribute_query= tep_db_query("select products_id, products_attributes_id, options_id, options_values_id from " . TABLE_PRODUCTS_ATTRIBUTES . " where products_id='" . $products_id_to . "' and options_id='" . $products_copy_from['options_id'] . "' and options_values_id ='" . $products_copy_from['options_values_id'] . "'");
      $check_attribute= tep_db_fetch_array($check_attribute_query);
// Check if there is a download with this attribute
      $check_attributes_download_query= tep_db_query("select * from " . TABLE_PRODUCTS_ATTRIBUTES_DOWNLOAD . " where products_attributes_id ='" . $products_copy_from['products_attributes_id'] . "'");
      $check_attributes_download=tep_db_fetch_array($check_attributes_download_query);

// Process Attribute
      $skip_it=false;
      switch (true) {
        case ($check_attribute and $copy_attributes_duplicates_skipped):
          // skip duplicate attributes
          $skip_it=true;
          break;
        case (!$copy_attributes_include_downloads and $check_attributes_download['products_attributes_id']):
          // skip download attributes
          $skip_it=true;
          break;
        default:
          if ($check_attributes_download['products_attributes_id']) {
            if (DOWNLOAD_ENABLED=='false' or !$copy_attributes_include_downloads) {
              // do not copy this download
              $skip_it=true;
            } else {
              // copy this download
            }
          }

// skip anything when $skip_it
          if (!$skip_it) {
            if ($check_attribute['products_id']) {
              // Duplicate attribute - update it

              $sql_data_array = array(
                'options_id' => tep_db_prepare_input($products_copy_from['options_id']),
                'options_values_id' => tep_db_prepare_input($products_copy_from['options_values_id']),
                'options_values_price' => tep_db_prepare_input($products_copy_from['options_values_price']),
                'price_prefix' => tep_db_prepare_input($products_copy_from['price_prefix']),
                'products_options_sort_order' => tep_db_prepare_input($products_copy_from['products_options_sort_order']),
                'product_attribute_is_free' => tep_db_prepare_input($products_copy_from['product_attribute_is_free']),
                'products_attributes_weight' => tep_db_prepare_input($products_copy_from['products_attributes_weight']),
                'products_attributes_weight_prefix' => tep_db_prepare_input($products_copy_from['products_attributes_weight_prefix']),

                'attributes_price_onetime' => tep_db_prepare_input($products_copy_from['attributes_price_onetime']),

                'attributes_display_only' => tep_db_prepare_input($products_copy_from['attributes_display_only']),

                'attributes_default' => $_POST['attributes_default'][$rows],
                'attributes_qty_prices_onetime' => $_POST['attributes_qty_prices_onetime'][$rows],
                'attributes_discounted' => $_POST['attributes_discounted'][$rows],

                'attributes_price_factor' => $_POST['attributes_price_factor'][$rows],
                'attributes_price_factor_offset' => $_POST['attributes_price_factor_offset'][$rows]
              );

              $cur_attributes_id = $check_attribute['products_attributes_id'];
              tep_db_perform(TABLE_PRODUCTS_ATTRIBUTES, $sql_data_array, 'update', 'products_id = \'' . tep_db_input($products_id_to) . '\' and products_attributes_id=\'' . tep_db_input($cur_attributes_id) . '\'');
            } else {
              // New attribute - insert it
// , attributes_default, attributes_qty_prices_onetime, attributes_discounted
              tep_db_query("insert into " . TABLE_PRODUCTS_ATTRIBUTES . " values ('', '" . $products_id_to . "', '" . $products_copy_from['options_id'] . "', '" . $products_copy_from['options_values_id'] . "', '" . $products_copy_from['options_values_price'] . "', '" . $products_copy_from['price_prefix'] . "', '" . $products_copy_from['products_options_sort_order'] . "', '" . $products_copy_from['product_attribute_is_free'] . "', '" . $products_copy_from['products_attributes_weight'] . "', '" . $products_copy_from['products_attributes_weight_prefix'] . "', '" . $products_copy_from['attributes_price_onetime'] . "', '" . $products_copy_from['attributes_display_only'] . "', '" . $products_copy_from['attributes_default'] . "', '" . $products_copy_from['attributes_qty_prices_onetime'] . "', '" . $products_copy_from['attributes_discounted'] . "', '" . $products_copy_from['attributes_price_factor'] . "', '" . $products_copy_from['attributes_price_factor_offset'] . "')");
            }

// Manage download attribtues
            if (DOWNLOAD_ENABLED == 'true') {
              if ($check_attributes_download and $copy_attributes_include_downloads) {
                // copy download attributes
//                echo 'Download - ' . ' Attribute ID ' . $check_attributes_download['products_attributes_id'] . ' ' . $check_attributes_download['products_attributes_filename'] . ' copy it<br>';
                $new_attribute_query= tep_db_query("select * from " . TABLE_PRODUCTS_ATTRIBUTES . " where products_id='" . $products_id_to . "' and options_id='" . $products_copy_from['options_id'] . "' and options_values_id ='" . $products_copy_from['options_values_id'] . "'");
                $new_attribute= tep_db_fetch_array($new_attribute_query);

                $sql_data_array = array(
                  'products_attributes_id' => tep_db_prepare_input($new_attribute['products_attributes_id']),
                  'products_attributes_filename' => tep_db_prepare_input($check_attributes_download['products_attributes_filename']),
                  'products_attributes_maxdays' => tep_db_prepare_input($check_attributes_download['products_attributes_maxdays']),
                  'products_attributes_maxcount' => tep_db_prepare_input($check_attributes_download['products_attributes_maxcount'])
                );

                $cur_attributes_id = $check_attribute['products_attributes_id'];
                tep_db_perform(TABLE_PRODUCTS_ATTRIBUTES_DOWNLOAD, $sql_data_array);
              }
            }
          } // $skip_it
          break;
      } // end of switch
    } // end of products attributes while loop
  } // end of no attributes or other errors
} // eof: tep_copy_products_attributes


////
// Check if product has attributes
  function tep_has_product_attributes($products_id) {
    $attributes_query = tep_db_query("select count(*) as count from " . TABLE_PRODUCTS_ATTRIBUTES . " where products_id = '" . $products_id . "'");
    $attributes = tep_db_fetch_array($attributes_query);

    if ($attributes['count'] > 0) {
      return true;
    } else {
      return false;
    }
  }


////
// Set attributes_discounted on/off
  function tep_discount_products_attributes($products_id, $on_off='1') {
    $attributes_discount_query = tep_db_query("select * from " . TABLE_PRODUCTS_ATTRIBUTES . " where products_id = '" . $products_id . "'");
    while ($attributes_discount = tep_db_fetch_array($attributes_discount_query)) {
//      echo $attributes_discount['products_attributes_id'] . ' - ' . $on_off . '<br>';
        tep_db_query("update " . TABLE_PRODUCTS_ATTRIBUTES . " set attributes_discounted = '" . $on_off . "' where products_attributes_id = '" . $attributes_discount['products_attributes_id'] . "'");
    }
  }


////
// Set products_price_excluded on/off
  function tep_products_price_excluded($products_id, $on_off='1') {
    tep_db_query("update " . TABLE_PRODUCTS . " set products_price_excluded='" . $on_off . "' where products_id='" . $products_id . "'");
  }

////
// Set Product Attributes Sort Order to Products Option Value Sort Order
  function tep_update_attributes_products_option_values_sort_order($products_id) {
    $attributes_sort_order_query = tep_db_query("select distinct pa.products_attributes_id, pa.options_id, pa.options_values_id, pa.products_options_sort_order, pov.products_options_values_sort_order from " . TABLE_PRODUCTS_ATTRIBUTES . " pa, " . TABLE_PRODUCTS_OPTIONS_VALUES . " pov where pa.products_id = '" . $products_id . "' and pa.options_values_id = pov.products_options_values_id");
    while ($attributes_sort_order = tep_db_fetch_array($attributes_sort_order_query)) {
      tep_db_query("update " . TABLE_PRODUCTS_ATTRIBUTES . " set products_options_sort_order = '" . $attributes_sort_order['products_options_values_sort_order'] . "' where products_id = '" . $products_id . "' and products_attributes_id = '" . $attributes_sort_order['products_attributes_id'] . "'");
    }
  }

?>
