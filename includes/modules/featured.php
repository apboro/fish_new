<?php
/*
  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2002 osCommerce

  Released under the GNU General Public License

  Featured Products V1.1
  Displays a list of featured products, selected from admin
  For use as an Infobox instead of the "New Products" Infobox
*/
?>
<!-- featured_products //-->
<?php
 if(FEATURED_PRODUCTS_DISPLAY == true)
 {
  $featured_products_category_id = $new_products_category_id;
  $cat_name_query = tep_db_query("select categories_name from categories_description where categories_id = '" . $featured_products_category_id . "' limit 1");
  $cat_name_fetch = tep_db_fetch_array($cat_name_query);
  $cat_name = $cat_name_fetch['categories_name'];
  $info_box_contents = array();


  if ( (!isset($featured_products_category_id)) || ($featured_products_category_id == '0') ) {
    $info_box_contents[] = array('align' => 'left', 'text' => '<a href="' . tep_href_link(FILENAME_FEATURED_PRODUCTS, '', 'NONSSL') . '">'.TABLE_HEADING_FEATURED_PRODUCTS . '</a>');
    $featured_products_query = tep_db_query("select STRAIGHT_JOIN p.products_id, pd.products_name, p.products_model, p.products_quantity, p.products_weight, p.manufacturers_id, p.products_image, p.products_tax_class_id, s.status as specstat, s.specials_new_products_price, p.products_price 
  FROM ".TABLE_PRODUCTS." p
  INNER JOIN ".TABLE_FEATURED." as f on p.products_id = f.products_id
  and p.products_status = '1' and f.status = '1'
  INNER JOIN ".TABLE_PRODUCTS_DESCRIPTION." as pd on pd.products_id = p.products_id
  left join ".TABLE_SPECIALS." s on s.products_id = p.products_id
  WHERE 1 limit " . MAX_DISPLAY_FEATURED_PRODUCTS);
  } else {
    $info_box_contents[] = array('align' => 'left', 'text' => '<a href="' . tep_href_link(FILENAME_FEATURED_PRODUCTS, '', 'NONSSL') . '">'.sprintf(TABLE_HEADING_FEATURED_PRODUCTS_CATEGORY, $cat_name) . '</a>');
    $featured_products_query = tep_db_query("select STRAIGHT_JOIN distinct p.products_id, p.products_model, p.products_quantity, p.products_weight, p.manufacturers_id, p.products_image, p.products_tax_class_id, s.status as specstat, s.specials_new_products_price, p.products_price 
FROM ".TABLE_PRODUCTS." p
  INNER JOIN ".TABLE_FEATURED." as f on p.products_id = f.products_id
  and p.products_status = '1' and f.status = '1'
  INNER JOIN ".TABLE_PRODUCTS_DESCRIPTION." as pd on pd.products_id = p.products_id
  left join ".TABLE_SPECIALS." s on s.products_id = p.products_id
  WHERE 1 limit " . MAX_DISPLAY_FEATURED_PRODUCTS);
}
  $row = 0;
  $col = 0;
  $num = 0;
  $width = 100 / PRODUCT_LIST_COL_NUM;

  $customer_price = tep_get_customer_price();
  while ($featured_products = tep_db_fetch_array($featured_products_query)) {
    $num ++; if ($num == 1) { new infoBoxHeading($info_box_contents, false, false, tep_href_link(FILENAME_FEATURED_PRODUCTS));}
	if ($featured_price = tep_get_products_special_price($featured_products['products_id'])) {
     $featured_products['products_price'] = $featured_price; // Обычная цена
     $featured_products['specials_featured_products_price'] = tep_quick_getproductprice($featured_products,$customer_price); // Спец. цена
	  $info_box_contents[$row][$col] = array('align' => 'center',
                                       'params' => 'class="smallText" width="' . $width . '%" valign="top"',
                                       'text' => '<a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $featured_products['products_id']) . '"'.AddBlank().'>' . tep_image(STATIC_DOMAIN.DIR_WS_IMAGES . $featured_products['products_image'], $featured_products['products_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT) . '</a><br><a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $featured_products['products_id']) . '"'.AddBlank().'>' . $featured_products['products_name'] . '</a><br><s>' . $currencies->display_price_nodiscount($featured_products['specials_featured_products_price'], tep_get_tax_rate($featured_products['products_tax_class_id'])) . '</s><br><span class="productSpecialPrice">' .
                                           $currencies->display_price_nodiscount($featured_products['products_price'], tep_get_tax_rate($featured_products['products_tax_class_id'])));
    } else {
     $featured_products['specials_featured_products_price'] = tep_quick_getproductprice($featured_products,$customer_price); // Спец. цена
	  $info_box_contents[$row][$col] = array('align' => 'center',
                                       'params' => 'class="smallText" width="' . $width . '%" valign="top"',
                                       'text' => '<a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $featured_products['products_id']) . '"'.AddBlank().'>' . tep_image(STATIC_DOMAIN.DIR_WS_IMAGES . $featured_products['products_image'], $featured_products['products_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT) . '</a><br><a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $featured_products['products_id']) . '"'.AddBlank().'>' . $featured_products['products_name'] . '</a><br>' . $currencies->display_price($featured_products['specials_featured_products_price'], tep_get_tax_rate($featured_products['products_tax_class_id'])));
    }
    $col ++;
    if ($col > PRODUCT_LIST_COL_NUM - 1) {
      $col = 0;
      $row ++;
    }
  }
  if($num) {

      new contentBox($info_box_contents);
if (MAIN_TABLE_BORDER == 'yes'){
$info_box_contents = array();
  $info_box_contents[] = array('align' => 'left',
                                'text'  => tep_draw_separator('pixel_trans.gif', '100%', '1')
                              );
  new infoboxFooter($info_box_contents, true, true);
}
  }
 } else // If it's disabled, then include the original New Products box
 {
   include (DIR_WS_MODULES . FILENAME_NEW_PRODUCTS);
 }
?>
<!-- featured_products_eof //-->
