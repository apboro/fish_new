<?php
/*
  WebMakers.com Added: webmakers_added_functions.php
  Additional functions for the admin
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

if (false) {
echo $products_id_from . 'x' . $products_id_to . '<br>';
echo $copy_attributes_delete_first;
echo $copy_attributes_duplicates_skipped;
echo $copy_attributes_duplicates_overwrite;
echo $copy_attributes_include_downloads;
echo $copy_attributes_include_filename . '<br>';
} // false for testing

    if ($copy_attributes_delete_first=='1') {
      // delete all attributes and downloads first
//      echo 'Delete all existing attributes first <br>';
        $products_delete_from_query= tep_db_query("select pa.products_id, pad.products_attributes_id from " . TABLE_PRODUCTS_ATTRIBUTES . " pa, " . TABLE_PRODUCTS_ATTRIBUTES_DOWNLOAD . " pad  where pa.products_id='" . $products_id_to . "' and pad.products_attributes_id= pa.products_attributes_id");
        while ( $products_delete_from=tep_db_fetch_array($products_delete_from_query) ) {
          tep_db_query("delete from " . TABLE_PRODUCTS_ATTRIBUTES_DOWNLOAD . " where products_attributes_id = '" . $products_delete_from['products_attributes_id'] . "'");
        }
        tep_db_query("delete from " . TABLE_PRODUCTS_ATTRIBUTES . " where products_id = '" . $products_copy_to_check['products_id'] . "'");
    }

    while ( $products_copy_from=tep_db_fetch_array($products_copy_from_query) ) {
      $rows++;
// This must match the structure of your products_attributes table
// Current Field Order: products_attributes_id, options_values_price, price_prefix, products_options_sort_order, product_attributes_one_time, products_attributes_weight, products_attributes_weight_prefix, products_attributes_units, products_attributes_units_price
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
//          echo 'DUPLICATE ' . ' Option ' . $products_copy_from['options_id'] . ' Value ' . $products_copy_from['options_values_id'] . ' Price ' . $products_copy_from['options_values_price'] . ' SKIPPED<br>';
          $skip_it=true;
          break;
        case (!$copy_attributes_include_downloads and $check_attributes_download['products_attributes_id']):
          // skip download attributes
//          echo 'Download - ' . ' Attribute ID ' . $check_attributes_download['products_attributes_id'] . ' do not copy it<br>';
          $skip_it=true;
          break;
        default:
//          echo '$check_attributes_download ' . $check_attributes_download['products_attributes_id'] . '<br>';
          if ($check_attributes_download['products_attributes_id']) {
            if (DOWNLOAD_ENABLED=='false' or !$copy_attributes_include_downloads) {
              // do not copy this download
//              echo 'This is a download not to be copied <br>';
              $skip_it=true;
            } else {
              // copy this download
//              echo 'This is a download to be copied <br>';
            }
          }

// skip anything when $skip_it
          if (!$skip_it) {
            if ($check_attribute['products_id']) {
              // Duplicate attribute - update it
//              echo 'Duplicate - Update ' . $check_attribute['products_id'] . ' Option ' . $check_attribute['options_id'] . ' Value ' . $check_attribute['options_values_id'] . ' Price ' . $products_copy_from['options_values_price'] . '<br>';
              // tep_db_query("update set " . TABLE_PRODUCTS_ATTRIBUTES . ' ' . options_id=$products_copy_from['options_id'] . "', '" . options_values_id=$products_copy_from['options_values_id'] . "', '" . options_values_price=$products_copy_from['options_values_price'] . "', '" . price_prefix=$products_copy_from['price_prefix'] . "', '" . products_options_sort_order=$products_copy_from['products_options_sort_order'] . "', '" . product_attributes_one_time=$products_copy_from['product_attributes_one_time'] . "', '" . products_attributes_weight=$products_copy_from['products_attributes_weight'] . "', '" . products_attributes_weight_prefix=$products_copy_from['products_attributes_weight_prefix'] . "', '" . products_attributes_units=$products_copy_from['products_attributes_units'] . "', '" . products_attributes_units_price=$products_copy_from['products_attributes_units_price'] . " where products_id='" . $products_id_to . "' and products_attributes_id='" . $check_attribute['products_attributes_id'] . "'");

              $sql_data_array = array(
                'options_id' => tep_db_prepare_input($products_copy_from['options_id']),
                'options_values_id' => tep_db_prepare_input($products_copy_from['options_values_id']),
                'options_values_price' => tep_db_prepare_input($products_copy_from['options_values_price']),
                'price_prefix' => tep_db_prepare_input($products_copy_from['price_prefix']),
                'products_options_sort_order' => tep_db_prepare_input($products_copy_from['products_options_sort_order']),
                'product_attributes_one_time' => tep_db_prepare_input($products_copy_from['product_attributes_one_time']),
                'products_attributes_weight' => tep_db_prepare_input($products_copy_from['products_attributes_weight']),
                'products_attributes_weight_prefix' => tep_db_prepare_input($products_copy_from['products_attributes_weight_prefix']),
                'products_attributes_units' => tep_db_prepare_input($products_copy_from['products_attributes_units']),
                'products_attributes_units_price' => tep_db_prepare_input($products_copy_from['products_attributes_units_price'])
              );

              $cur_attributes_id = $check_attribute['products_attributes_id'];
              tep_db_perform(TABLE_PRODUCTS_ATTRIBUTES, $sql_data_array, 'update', 'products_id = \'' . tep_db_input($products_id_to) . '\' and products_attributes_id=\'' . tep_db_input($cur_attributes_id) . '\'');
            } else {
              // New attribute - insert it
//              echo 'New - Insert ' . 'Option ' . $products_copy_from['options_id'] . ' Value ' . $products_copy_from['options_values_id']  . ' Price ' . $products_copy_from['options_values_price'] . '<br>';
              tep_db_query("insert into " . TABLE_PRODUCTS_ATTRIBUTES . " values ('', '" . $products_id_to . "', '" . $products_copy_from['options_id'] . "', '" . $products_copy_from['options_values_id'] . "', '" . $products_copy_from['options_values_price'] . "', '" . $products_copy_from['price_prefix'] . "', '" . $products_copy_from['products_options_sort_order'] . "', '" . $products_copy_from['product_attributes_one_time'] . "', '" . $products_copy_from['products_attributes_weight'] . "', '" . $products_copy_from['products_attributes_weight_prefix'] . "', '" . $products_copy_from['products_attributes_units'] . "', '" . $products_copy_from['products_attributes_units_price'] . "')");
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
?>
