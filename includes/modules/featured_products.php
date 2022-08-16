<?php
/*
  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2002 osCommerce

  Released under the GNU General Public License
  
  Featured Products Listing Module
*/
  if (sizeof($featured_products_array) == '0') {
?>
  <tr>
    <td class="main"><?php echo TEXT_NO_FEATURED_PRODUCTS; ?></td>
  </tr>
<?php
  } else {
    for($i=0; $i<sizeof($featured_products_array); $i++) {
		//TotalB2B start
        $featured_products['products_price'] = tep_xppp_getproductprice($featured_products['products_id']);
        //TotalB2B end

      if ($new_price = tep_get_products_special_price($featured_products['products_id'])) {
		
        //TotalB2B start
//		$query_special_prices_hide = tep_db_query("select configuration_value from " . TABLE_CONFIGURATION . " WHERE configuration_key = 'SPECIAL_PRICES_HIDE'");
//        $query_special_prices_hide_result = tep_db_fetch_array($query_special_prices_hide); 
        $query_special_prices_hide_result = SPECIAL_PRICES_HIDE; 
        if ($query_special_prices_hide_result == 'true') {
          $products_price = '<span class="productSpecialPrice">' . $currencies->display_price_nodiscount($new_price, tep_get_tax_rate($featured_products['products_tax_class_id'])) . '</span>';
	    } else {
          $products_price = '<s>' . $currencies->display_price($featured_products['products_price'], tep_get_tax_rate($featured_products['products_tax_class_id'])) . '</s> <span class="productSpecialPrice">' . $currencies->display_price_nodiscount($new_price, tep_get_tax_rate($featured_products['products_tax_class_id'])) . '</span>';
	    }
        //TotalB2B end

      } else {
        $products_price = $currencies->display_price($featured_products['products_price'], tep_get_tax_rate($featured_products['products_tax_class_id']));
      }
?>
  <tr>
    <td width="<?php echo SMALL_IMAGE_WIDTH + 10; ?>" valign="top" class="main"><?php echo '<a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $featured_products_array[$i]['id'], 'NONSSL') . '"'.AddBlank().'>' . tep_image(DIR_WS_IMAGES . $featured_products_array[$i]['image'], $featured_products_array[$i]['name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT) . '</a>'; ?></td>
    <td valign="top" class="main"><?php echo '<a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $featured_products_array[$i]['id'], 'NONSSL') . '"'.AddBlank().'><b><u>' . $featured_products_array[$i]['name'] . '</u></b></a><br>' . TEXT_DATE_ADDED . ' ' . $featured_products_array[$i]['date_added'] . '<br>' . TEXT_MANUFACTURER . ' ' . $featured_products_array[$i]['manufacturer'] . '<br><br>' . TEXT_PRICE . ' ' . $products_price; ?></td>
    <td align="right" valign="middle" class="main"><?php echo '<a href="' . tep_href_link(FILENAME_FEATURED_PRODUCTS, tep_get_all_get_params(array('action')) . 'action=buy_now&products_id=' . $featured_products_array[$i]['id'], 'NONSSL') . '">' . tep_template_image_button('button_in_cart.gif', IMAGE_BUTTON_IN_CART) . '</a>'; ?></td>
  </tr>
<?php
      if (($i+1) != sizeof($featured_products_array)) {
?>
  <tr>
    <td colspan="3" class="main">&nbsp;</td>
  </tr>
<?php
      }
    }
  }
?>
