<?php
/*
  $Id: featured.php,v 1.1.1.1 2003/09/18 19:05:48 wilt Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2002 osCommerce

  Released under the GNU General Public License
*/
?>
<!-- featured //-->
<?php
// BOF manufacturers descriptions
//  if ($random_product = tep_random_select("select p.products_id, pd.products_name, p.products_image, p.products_tax_class_id, p.products_price, p.products_date_added, m.manufacturers_name from " . TABLE_PRODUCTS . " p left join " . TABLE_MANUFACTURERS . " m on p.manufacturers_id = m.manufacturers_id left join " . TABLE_PRODUCTS_DESCRIPTION . " pd on p.products_id = pd.products_id and pd.language_id = '" . $languages_id . "' left join " . TABLE_SPECIALS . " s on p.products_id = s.products_id left join " . TABLE_FEATURED . " f on p.products_id = f.products_id where p.products_status = '1' and f.status = '1' order by f.featured_date_added DESC limit " . MAX_RANDOM_SELECT_SPECIALS)) {
  if ($random_product = tep_random_select("select p.products_id, pd.products_name, p.products_image, p.products_tax_class_id, p.products_price, p.products_date_added, mi.manufacturers_name from " . TABLE_PRODUCTS . " p left join " . TABLE_MANUFACTURERS_INFO . " mi on p.manufacturers_id = mi.manufacturers_id and mi.languages_id = '" . (int)$languages_id . "' left join " . TABLE_PRODUCTS_DESCRIPTION . " pd on p.products_id = pd.products_id and pd.language_id = '" . (int)$languages_id . "' left join " . TABLE_SPECIALS . " s on p.products_id = s.products_id left join " . TABLE_FEATURED . " f on p.products_id = f.products_id where p.products_status = '1' and f.status = '1' order by f.featured_date_added DESC limit " . MAX_RANDOM_SELECT_SPECIALS)) {  
// EOF manufacturers descriptions
?>
          <tr>
            <td>
<?php
    $random_product['products_name'] = tep_get_products_name($random_product['products_id']);
    $random_product['specials_new_products_price'] = tep_get_products_special_price($random_product['products_id']);

    $info_box_contents = array();
/* ORIGINAL 213
    $info_box_contents[] = array('align' => 'left',
                                 'text'  => '<font color="' . $font_color . '">' .BOX_HEADING_FEATURED . '</font>'
                                );
*/
/* CDS Patch. 12. BOF */
    $info_box_contents[] = array('text' => '<a href="' . tep_href_link(FILENAME_FEATURED_PRODUCTS, '', 'NONSSL') . '"><font color="' . $font_color . '">' .BOX_HEADING_FEATURED . '</font></a>');
/* CDS Patch. 12. EOF */
    new infoBoxHeading($info_box_contents, false, false, tep_href_link(FILENAME_FEATURED_PRODUCTS, '', 'NONSSL'));

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
        /* ORIGINAL. 213
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
        */
/* CDS Patch. 1. BOF */
      if ($query_special_prices_hide_result == 'true') {
          $random_product['products_price'] = tep_xppp_getproductprice($random_product['products_id']);
		$whats_new_price .= '<nobr><span class="productSpecialPrice">' . $currencies->display_price_nodiscount($random_product['specials_new_products_price'], tep_get_tax_rate($random_product['products_tax_class_id'])) . '</span></nobr>';
	  } else {
        $tmp_real_price = $currencies->display_price_nodiscount($random_product['products_price'], tep_get_tax_rate($random_product['products_tax_class_id']));
        $tmp_specials_price = $currencies->display_price_nodiscount($random_product['specials_new_products_price'], tep_get_tax_rate($random_product['products_tax_class_id']));
        $whats_new_price = '<nobr><s>' . $tmp_real_price . '</s></nobr><br />
        <nobr><span class="productSpecialPrice">' . $tmp_specials_price . '</span></nobr>';
        if (str_replace(",", "", $tmp_real_price) != 0)
        {
        $whats_new_price .= '<br /><nobr><span class="productSpecialPrice">(-' . (int)(((str_replace(",", "", $tmp_real_price) - str_replace(",", "", $tmp_specials_price)) * 100) / str_replace(",", "", $tmp_real_price)) . '%)</span></nobr>';
        }
	  }
      //TotalB2B end

    } else {
      $whats_new_price = '<nobr>' . $currencies->display_price($random_product['products_price'], tep_get_tax_rate($random_product['products_tax_class_id'])) . '</nobr>';
    }
/* CDS Patch. 1. EOF */

    $info_box_contents = array();
    $random_product['products_price'] = tep_xppp_getproductprice($random_product['products_id']);    
    $info_box_contents[] = array('align' => 'center',
                                 'text'  => '<a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $random_product['products_id']) . '"'.AddBlank().'>' . tep_image(DIR_WS_IMAGES . $random_product['products_image'], $random_product['products_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT) . '</a><br><a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $random_product['products_id'], 'NONSSL') . '"'.AddBlank().'>' . $random_product['products_name'] . '</a><br>' . $whats_new_price
                                );
    new infoBox($info_box_contents);



?>
            </td>
          </tr>
<?php
}
?>
<!-- featured_eof //-->