<?php
/*
  $Id: whats_new.php,v 1.1.1.1 2003/09/18 19:05:48 wilt Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2002 osCommerce

  Released under the GNU General Public License
*/
?>
<!-- whats_new //-->
<div class="box">
<b class="top"><b class="b1"></b><b class="b2"></b><b class="b3"></b><b class="b4"></b><b class="b5"></b></b>
<div class="boxHeader">
<h5><?php echo BOX_HEADING_WHATS_NEW; ?></h5>
</div>
<div class="boxContent">
<p>
<?php
// BOF Enable - Disable Categories Contribution-------------------------------------- 
if ($random_product = tep_random_select("select distinct p.products_id, p.products_image, p.products_tax_class_id, p.products_price from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c, " . TABLE_CATEGORIES . " c where p.products_status=1 and p.products_id = p2c.products_id and c.categories_id = p2c.categories_id and c.categories_status=1 order by p.products_date_added desc limit " . MAX_RANDOM_SELECT_NEW)) {
// EOF Enable - Disable Categories Contribution-------------------------------------- 

//  if ($random_product = tep_random_select("select products_id, products_image, products_tax_class_id, products_price from " . TABLE_PRODUCTS . " where products_status='1' order by products_date_added desc limit " . MAX_RANDOM_SELECT_NEW)) {
    $random_product['products_name'] = tep_get_products_name($random_product['products_id']);
    $random_product['specials_new_products_price'] = tep_get_products_special_price($random_product['products_id']);

	//TotalB2B start
    $random_product['products_price'] = tep_xppp_getproductprice($random_product['products_id']);
    //TotalB2B end

    if (tep_not_null($random_product['specials_new_products_price'])) {
	  
      //TotalB2B start
	  $random_product['specials_new_products_price'] = tep_get_products_special_price($random_product['products_id']);
//	  $query_special_prices_hide = tep_db_query("select configuration_value from " . TABLE_CONFIGURATION . " WHERE configuration_key = 'SPECIAL_PRICES_HIDE'");
//      $query_special_prices_hide_result = tep_db_fetch_array($query_special_prices_hide); 
      $query_special_prices_hide_result = SPECIAL_PRICES_HIDE; 
    $random_product['products_price'] = tep_xppp_getproductprice($random_product['products_id']);      
      if ($query_special_prices_hide_result == 'true') {
          $random_product['products_price'] = tep_xppp_getproductprice($random_product['products_id']);
		$whats_new_price .= '<span class="productSpecialPrice">' . $currencies->display_price_nodiscount($random_product['specials_new_products_price'], tep_get_tax_rate($random_product['products_tax_class_id'])) . '</span>';
	  } else {
		$whats_new_price = '<s>' . $currencies->display_price_nodiscount($random_product['products_price'], tep_get_tax_rate($random_product['products_tax_class_id'])) . '</s><br>';
        $whats_new_price .= '<span class="productSpecialPrice">' . $currencies->display_price_nodiscount($random_product['specials_new_products_price'], tep_get_tax_rate($random_product['products_tax_class_id'])) . '</span>';
	  }
      //TotalB2B end

    } else {
      $whats_new_price = $currencies->display_price($random_product['products_price'], tep_get_tax_rate($random_product['products_tax_class_id']));
    }

    $random_product['products_price'] = tep_xppp_getproductprice($random_product['products_id']);    

echo '<a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $random_product['products_id']) . '">' . tep_image(DIR_WS_IMAGES . $random_product['products_image'], $random_product['products_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT) . '</a><br><a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $random_product['products_id'], 'NONSSL') . '">' . $random_product['products_name'] . '</a><br>' . $whats_new_price;

}
?>
</p>
</div>
<b class="bottom"><b class="b5b"></b><b class="b4b"></b><b class="b3b"></b><b class="b2b"></b><b class="b1b"></b></b>
</div>
<!-- whats_new_eof //-->