<?php
/*
  $Id: specials.php,v 1.1.1.1 2003/09/18 19:05:48 wilt Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2002 osCommerce

  Released under the GNU General Public License
*/
?>
<!-- specials //-->
<?php

   //TotalB2B start
   if (!isset($customer_id)) $customer_id = 0;
   $customer_group = tep_get_customers_groups_id();
   if ($random_product = tep_random_select("select p.products_id, pd.products_name, p.products_price, p.products_tax_class_id, p.products_image, s.specials_new_products_price from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd, " . TABLE_SPECIALS . " s where p.products_status = '1' and p.products_id = s.products_id and pd.products_id = s.products_id and pd.language_id = '" . (int)$languages_id . "' and s.status = '1' and ((s.customers_id = '" . $customer_id . "' and s.customers_groups_id = '0') or (s.customers_id = '0' and s.customers_groups_id = '" . $customer_group . "') or (s.customers_id = '0' and s.customers_groups_id = '0')) order by s.specials_date_added desc limit " . MAX_RANDOM_SELECT_SPECIALS)) {
   //TotalB2B end

//  if ($random_product = tep_random_select("select p.products_id, pd.products_name, p.products_price, p.products_tax_class_id, p.products_image, s.specials_new_products_price from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd, " . TABLE_SPECIALS . " s where p.products_status = '1' and p.products_id = s.products_id and pd.products_id = s.products_id and pd.language_id = '" . $languages_id . "' and s.status = '1' order by s.specials_date_added DESC limit " . MAX_RANDOM_SELECT_SPECIALS)) {
?>
          <tr>
            <td>
<?php
  $info_box_contents = array();
    $info_box_contents[] = array('text'  => '<font color="' . $font_color . '">' . BOX_HEADING_SPECIALS . '</font>');
  new infoBoxHeading($info_box_contents, false, false, tep_href_link(FILENAME_SPECIALS, '', 'NONSSL'));

    $info_box_contents = array();
    $random_product['products_price'] = tep_xppp_getproductprice($random_product['products_id']);
    $info_box_contents[] = array('align' => 'center',
                                 'text'  => '<a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $random_product["products_id"]) . '">' . tep_image(DIR_WS_IMAGES . $random_product['products_image'], $random_product['products_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT) . '</a><br><a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $random_product['products_id']) . '">' . $random_product['products_name'] . '</a><br><s>' . $currencies->display_price_nodiscount($random_product['products_price'], tep_get_tax_rate($random_product['products_tax_class_id'])) . '</s><br><span class="productSpecialPrice">' . $currencies->display_price_nodiscount(tep_get_products_special_price($random_product['products_id']), tep_get_tax_rate($random_product['products_tax_class_id'])) . '</span>'
                                );
   new infoBox($info_box_contents);

$info_box_contents = array();
  $info_box_contents[] = array('align' => 'left',
'text'  => tep_draw_separator('pixel_trans.gif', '100%', '1')
                              );
  new infoboxFooter($info_box_contents, true, true);
?>
            </td>
          </tr>
<?php
  }
?>
<!-- specials_eof //-->
