    <table border="0" width="100%" cellspacing="0" cellpadding="<?php echo CELLPADDING_SUB;?>">
<?php
// BOF: Lango Added for template MOD
if (SHOW_HEADING_TITLE_ORIGINAL == 'yes') {
$header_text = '&nbsp;'
//EOF: Lango Added for template MOD
?>
<?php
// BOF MaxiDVD: Modified For Ultimate Images Pack!
    $product_info_query = tep_db_query("select p.products_id, pd.products_name, pd.products_description, p.products_model, p.products_quantity, p.products_image, p.products_image_med, p.products_image_lrg, p.products_image_sm_1, p.products_image_xl_1, p.products_image_sm_2, p.products_image_xl_2, p.products_image_sm_3, p.products_image_xl_3, p.products_image_sm_4, p.products_image_xl_4, p.products_image_sm_5, p.products_image_xl_5, p.products_image_sm_6, p.products_image_xl_6, pd.products_url, p.products_price, p.products_tax_class_id, p.products_date_added, p.products_date_available, p.manufacturers_id from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd where p.products_status = '1' and p.products_id = '" . (int)$_GET['products_id'] . "' and pd.products_id = p.products_id and pd.language_id = '" . (int)$languages_id . "'");
// EOF MaxiDVD: Modified For Ultimate Images Pack!
    $product_info = tep_db_fetch_array($product_info_query);

    tep_db_query("update " . TABLE_PRODUCTS_DESCRIPTION . " set products_viewed = products_viewed+1 where products_id = '" . (int)$_GET['products_id'] . "' and language_id = '" . (int)$languages_id . "'");

	//TotalB2B start
	$product_info['products_price'] = tep_xppp_getproductprice($product_info['products_id']);
    //TotalB2B end

    if ($new_price = tep_get_products_special_price($product_info['products_id'])) {
      
      //TotalB2B start
//	  $query_special_prices_hide = tep_db_query("select configuration_value from " . TABLE_CONFIGURATION . " WHERE configuration_key = 'SPECIAL_PRICES_HIDE'");
//      $query_special_prices_hide_result = tep_db_fetch_array($query_special_prices_hide); 
      $query_special_prices_hide_result = SPECIAL_PRICES_HIDE; 
      if ($query_special_prices_hide_result == 'true') {
	 	$products_price = '<span class="productSpecialPrice">' . $currencies->display_price_nodiscount($new_price, tep_get_tax_rate($product_info['products_tax_class_id'])) . '</span>'; 
	  } else {
	    $products_price = '<s>' . $currencies->display_price_nodiscount($product_info['products_price'], tep_get_tax_rate($product_info['products_tax_class_id'])) . '</s> <span class="productSpecialPrice">' . $currencies->display_price_nodiscount($new_price, tep_get_tax_rate($product_info['products_tax_class_id'])) . '</span>';
	  }
      //TotalB2B end

    } else {
      $products_price = $currencies->display_price($product_info['products_price'], tep_get_tax_rate($product_info['products_tax_class_id']));
    }


//    if ($new_price = tep_get_products_special_price($product_info['products_id'])) {
//      $products_price = '<s>' . $currencies->display_price($product_info['products_price'], tep_get_tax_rate($product_info['products_tax_class_id'])) . '</s> <span class="productSpecialPrice">' . $currencies->display_price($new_price, tep_get_tax_rate($product_info['products_tax_class_id'])) . '</span>';
//    } else {
//      $products_price = $currencies->display_price($product_info['products_price'], tep_get_tax_rate($product_info['products_tax_class_id']));
//    }


//    if (tep_not_null($product_info['products_model'])) {
//      $products_name = $product_info['products_name'] . '<br><span class="smallText">[' . $product_info['products_model'] . ']</span>';
//    } else {
//      $products_name = $product_info['products_name'];
//    }

    if (tep_not_null($product_info['products_model'])) {
      $products_name = $product_info['products_name'];
    } else {
      $products_name = $product_info['products_name'];
    }
?>

      <tr>
        <td><table class="table-padding-0">
          <tr>
            <td class="pageHeading" valign="top"><?php echo $products_name; ?></td>
            <td class="pageHeading" align="right" valign="top"><?php echo $products_price; ?></td>
          </tr>
<?php
if ( ($error_cart_msg) ) {
?>
      <tr>
        <td colspan="2" align="right" class="QtyErrors"><br><?php echo tep_output_warning($error_cart_msg); ?></td>
      </tr>
<?php
}
$error_cart_msg='';
?>
          
        </table></td>
      </tr>
<?php
}else{
$header_text = $products_name . '&nbsp;&nbsp;&nbsp;&nbsp;' . $products_price;
}
?>

<?php
// BOF: Lango Added for template MOD
if (MAIN_TABLE_BORDER == 'yes'){
table_image_border_top(false, false, $header_text);
}
// EOF: Lango Added for template MOD
?>
      <tr>
        <td><table width="100%" border="0" cellspacing="0" cellpadding="2">
          <tr>
            <td valign="top"><table class="table-padding-2">
              <tr>
                <td><table class="table-padding-2">
                  <tr>
                    <td class="main"><?php echo '<b>' . sprintf(TEXT_REVIEW_BY, tep_output_string_protected($review_text['customers_name'])) . '</b>'; ?></td>
                    <td class="smallText" align="right"><?php echo sprintf(TEXT_REVIEW_DATE_ADDED, tep_date_long($review_text['date_added'])); ?></td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td><table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBox">
                  <tr class="infoBoxContents">
                    <td><table class="table-padding-2">
                      <tr>
                        <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
                        <td valign="top" class="main"><?php echo tep_break_string(nl2br(tep_output_string_protected($review_text['reviews_text'])), 60, '-<br>') . '<br><br><i>' . sprintf(TEXT_REVIEW_RATING, tep_image(DIR_WS_TEMPLATES . TEMPLATE_NAME . '/images/content/stars_' . $review_text['reviews_rating'] . '.gif', sprintf(TEXT_OF_5_STARS, $review_text['reviews_rating'])), sprintf(TEXT_OF_5_STARS, $review_text['reviews_rating'])) . '</i>'; ?></td>
                        <td width="10" align="right"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
                      </tr>
                    </table></td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
              </tr>
              <tr>
                <td><table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBox">
                  <tr class="infoBoxContents">
                    <td><table class="table-padding-2">
                      <tr>
                        <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
                        <td class="main"><?php echo '<a href="' . tep_href_link(FILENAME_PRODUCT_REVIEWS, tep_get_all_get_params(array('reviews_id'))) . '">' . tep_template_image_button('button_back.gif', IMAGE_BUTTON_BACK) . '</a>'; ?></td>
                        <td class="main" align="right"><?php echo '<a href="' . tep_href_link(FILENAME_PRODUCT_REVIEWS_WRITE, tep_get_all_get_params(array('reviews_id'))) . '">' . tep_template_image_button('button_write_review.gif', IMAGE_BUTTON_WRITE_REVIEW) . '</a>'; ?></td>
                        <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
                      </tr>
                    </table></td>
                  </tr>
                </table></td>
              </tr>
            </table></td>
            <td width="<?php echo SMALL_IMAGE_WIDTH + 10; ?>" align="right" valign="top"><table border="0" cellspacing="0" cellpadding="2">
              <tr>
                <td align="center" class="smallText">
<?php
  if (tep_not_null($review_text['products_image'])) {
?>
<script language="javascript"><!--
document.write('<?php echo '<a href="javascript:popupWindow(\\\'' . tep_href_link(FILENAME_POPUP_IMAGE, 'pID=' . $review_text['products_id']) . '\\\')">' . tep_image(DIR_WS_IMAGES . $review_text['products_image'], addslashes($review_text['products_name']), SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT, 'hspace="5" vspace="5"') . '<br>' . TEXT_CLICK_TO_ENLARGE . '</a>'; ?>');
//--></script>
<noscript>
<?php echo '<a href="' . tep_href_link(DIR_WS_IMAGES . $review_text['products_image']) . '" target="_blank">' . tep_image(DIR_WS_IMAGES . $review_text['products_image'], $review_text['products_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT, 'hspace="5" vspace="5"') . '<br>' . TEXT_CLICK_TO_ENLARGE . '</a>'; ?>
</noscript>
<?php
  }
?>
<br>
<?php if (!tep_has_product_attributes($_GET['products_id'])) { ?>
               <?php echo tep_draw_form('cart_quantity', tep_href_link(FILENAME_PRODUCT_REVIEWS_INFO, tep_get_all_get_params(array('action')) . 'action=add_product', 'NONSSL')); ?> 
<?php echo PRODUCTS_ORDER_QTY_TEXT; ?><input type="text" name="cart_quantity" value=<?php echo (tep_get_products_quantity_order_min($_GET['products_id'])); ?> maxlength="3" size="3"><?php echo ((tep_get_products_quantity_order_min($_GET['products_id'])) > 1 ? PRODUCTS_ORDER_QTY_MIN_TEXT . (tep_get_products_quantity_order_min($_GET['products_id'])) : ""); ?><?php echo (tep_get_products_quantity_order_units($_GET['products_id']) > 1 ? PRODUCTS_ORDER_QTY_UNIT_TEXT . (tep_get_products_quantity_order_units($_GET['products_id'])) : ""); ?>

                
                <?php echo tep_draw_hidden_field('products_id', $product_info['products_id']) . tep_template_image_submit('button_in_cart.gif', IMAGE_BUTTON_IN_CART); ?></form><br><br>
                
  <?php } ?>
                </td>
              </tr>
            </table>
          </td>
        </table></td>
      </tr>
<?php
// BOF: Lango Added for template MOD
if (MAIN_TABLE_BORDER == 'yes'){
table_image_border_bottom();
}
// EOF: Lango Added for template MOD
?>
    </table>

