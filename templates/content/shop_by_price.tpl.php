<table border="0" width="100%" cellspacing="0" cellpadding="<?php echo CELLPADDING_SUB; ?>">
<?php
// BOF: Lango Added for template MOD
if (SHOW_HEADING_TITLE_ORIGINAL == 'yes') {
$header_text = '&nbsp;'
//EOF: Lango Added for template MOD
?>
      <tr>
        <td><table class="table-padding-0">
          <tr>
            <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
            <td class="pageHeading" align="right"><?php echo tep_image(DIR_WS_TEMPLATES . TEMPLATE_NAME . '/images/content/products_new.gif', HEADING_TITLE, HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
<?php
// BOF: Lango Added for template MOD
}else{
$header_text = HEADING_TITLE;
}
// EOF: Lango Added for template MOD
?>
<?php
// BOF: Lango Added for template MOD
if (MAIN_TABLE_BORDER == 'yes'){
table_image_border_top(false, false, $header_text);
}
// EOF: Lango Added for template MOD
?>
      <tr>
        <td>
<?php
  // MELTUS - this is the section of interest
  // create column list
  $define_list = array('PRODUCT_LIST_MODEL' => PRODUCT_LIST_MODEL,
                       'PRODUCT_LIST_NAME' => PRODUCT_LIST_NAME,
                       'PRODUCT_LIST_MANUFACTURER' => PRODUCT_LIST_MANUFACTURER, 
                       'PRODUCT_LIST_PRICE' => PRODUCT_LIST_PRICE,
                       'PRODUCT_LIST_QUANTITY' => PRODUCT_LIST_QUANTITY,
                       'PRODUCT_LIST_WEIGHT' => PRODUCT_LIST_WEIGHT,
                       'PRODUCT_LIST_IMAGE' => PRODUCT_LIST_IMAGE,
                       'PRODUCT_LIST_BUY_NOW' => PRODUCT_LIST_BUY_NOW);
  asort($define_list);

  $column_list = array();
  reset($define_list);
/* ORIGINAL 213
  while (list($column, $value) = each($define_list)) {
    if ($value) $column_list[] = $column;
  }
*/
/* CDS Patch. 16. BOF */
    $column_list_order = array();
    $order = 0;
    $order_group = -1;
    $value_old = 0;
    while (list($column, $value) = each($define_list)) {
      if ($value > 0)
      {
        $column_list[$order] = $column;
        if ($value_old != $value)
        {
          $value_old = $value;
          $order_group++;
        }
        $column_list_order[$order] = $order_group;
        $order++;
      }
    }
/* CDS Patch. 16. EOF */

  $select_column_list = '';

  for ($col=0, $n=sizeof($column_list); $col<$n; $col++) {
    if ( ($column_list[$col] == 'PRODUCT_LIST_BUY_NOW') || ($column_list[$col] == 'PRODUCT_LIST_NAME') || ($column_list[$col] == 'PRODUCT_LIST_PRICE') ) {
      continue;
    }
  }
$get_range = ( (isset($_GET['range']) AND 
  isset($price_ranges_sql[$_GET['range']])) ? $_GET['range'] : 0 );

// BOF manufacturers descriptions
if (isset($_GET['cPath'])) {
  $listing_sql = "select p.products_id, p.products_model, p.manufacturers_id, pd.products_name, p.products_image, p.products_price, p.products_quantity, p.products_tax_class_id, IF(s.status, s.specials_new_products_price, NULL) as specials_new_products_price, p.products_date_added, mi.manufacturers_name from " . TABLE_PRODUCTS . " p left join " . TABLE_MANUFACTURERS_INFO . " mi on p.manufacturers_id = mi.manufacturers_id and mi.languages_id = '" . (int)$languages_id . "' left join " . TABLE_PRODUCTS_DESCRIPTION . " pd on p.products_id = pd.products_id and pd.language_id = '" . $languages_id . "' left join " . TABLE_SPECIALS . " s on p.products_id = s.products_id  left join " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c on p2c.products_id = p.products_id where p.products_status = '1' and p2c.categories_id = '" . (int)$current_category_id . "' and " . $price_ranges_sql[$get_range] . " order by p.products_price, pd.products_name";
} else {
  $listing_sql = "select p.products_id, p.products_model, p.manufacturers_id, pd.products_name, p.products_image, p.products_price, p.products_quantity, p.products_tax_class_id, IF(s.status, s.specials_new_products_price, NULL) as specials_new_products_price, p.products_date_added, mi.manufacturers_name from " . TABLE_PRODUCTS . " p left join " . TABLE_MANUFACTURERS_INFO . " mi on p.manufacturers_id = mi.manufacturers_id and mi.languages_id = '" . (int)$languages_id . "' left join " . TABLE_PRODUCTS_DESCRIPTION . " pd on p.products_id = pd.products_id and pd.language_id = '" . $languages_id . "' left join " . TABLE_SPECIALS . " s on p.products_id = s.products_id where p.products_status = '1' and " . $price_ranges_sql[$get_range] . " order by p.products_price, pd.products_name";
}

// EOF manufacturers descriptions
  
include(DIR_WS_MODULES . FILENAME_PRODUCT_LISTING_COL);
?>
        </td>
      </tr>
<?php
// BOF: Lango Added for template MOD
if (MAIN_TABLE_BORDER == 'yes'){
table_image_border_bottom();
}
// EOF: Lango Added for template MOD
?>
    </table>