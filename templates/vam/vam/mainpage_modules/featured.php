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
<h1><a href="<?php echo tep_href_link(FILENAME_FEATURED_PRODUCTS); ?>"><?php echo TABLE_HEADING_FEATURED_PRODUCTS; ?></a></h1>
<div class="page">
<b class="b1"></b><b class="b2"></b><b class="b3"></b><b class="b4"></b>
<div class="pageItem">
<?php
  $featured_products_category_id = $featured_products_category_id;
  $cat_name_query = tep_db_query("select categories_name from categories_description where categories_id = '" . $featured_products_category_id . "' limit 1");
  $cat_name_fetch = tep_db_fetch_array($cat_name_query);
  $cat_name = $cat_name_fetch['categories_name'];

  if ( (!isset($featured_products_category_id)) || ($featured_products_category_id == '0') ) {
    $featured_products_query = tep_db_query("select p.products_id, p.products_image, p.products_tax_class_id, s.status as specstat, s.specials_new_products_price, p.products_price from " . TABLE_PRODUCTS . " p left join " . TABLE_SPECIALS . " s on p.products_id = s.products_id left join " . TABLE_FEATURED . " f on p.products_id = f.products_id where p.products_status = '1' and f.status = '1' order by rand() DESC limit " . MAX_DISPLAY_FEATURED_PRODUCTS);
  } else {
    $featured_products_query = tep_db_query("select distinct p.products_id, p.products_image, p.products_tax_class_id, s.status as specstat, s.specials_new_products_price, p.products_price from " . TABLE_PRODUCTS . " p left join " . TABLE_SPECIALS . " s on p.products_id = s.products_id, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c, " . TABLE_CATEGORIES . " c left join " . TABLE_FEATURED . " f on p.products_id = f.products_id where p.products_id = p2c.products_id and p2c.categories_id = c.categories_id and c.parent_id = '" . $featured_products_category_id . "' and p.products_status = '1' and f.status = '1' order by rand() DESC limit " . MAX_DISPLAY_FEATURED_PRODUCTS);
}

echo '<table border="0" width="100%" align="center" cellpadding="0" cellspacing="0"><tr>';

$col = 0;

  while ($featured_products = tep_db_fetch_array($featured_products_query)) {

$col++; 

    $featured_products['products_name'] = tep_get_products_name($featured_products['products_id']);
	if ($featured_price = tep_get_products_special_price($featured_products['products_id'])) {
     $featured_products['products_price'] = $featured_price; // Обычная цена
     $featured_products['specials_featured_products_price'] = tep_xppp_getproductprice($featured_products['products_id']); // Спец. цена
	  echo '<td align="center"><a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $featured_products['products_id']) . '">' . tep_image(DIR_WS_IMAGES . $featured_products['products_image'], $featured_products['products_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT) . '</a><br><a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $featured_products['products_id']) . '">' . $featured_products['products_name'] . '</a><br><s>' . $currencies->display_price_nodiscount($featured_products['specials_featured_products_price'], tep_get_tax_rate($featured_products['products_tax_class_id'])) . '</s><br><span class="productSpecialPrice">' . 
                                           $currencies->display_price_nodiscount($featured_products['products_price'], tep_get_tax_rate($featured_products['products_tax_class_id'])).'</td>';
    } else {
     $featured_products['products_price'] = $featured_price; // Обычная цена
     $featured_products['specials_featured_products_price'] = tep_xppp_getproductprice($featured_products['products_id']); // Спец. цена
	  echo '<td align="center"><a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $featured_products['products_id']) . '">' . tep_image(DIR_WS_IMAGES . $featured_products['products_image'], $featured_products['products_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT) . '</a><br /><a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $featured_products['products_id']) . '">' . $featured_products['products_name'] . '</a><br>' . $currencies->display_price($featured_products['specials_featured_products_price'], tep_get_tax_rate($featured_products['products_tax_class_id'])).'</td>';
    }

  if ($col>=3) {  $col=0;  echo '</tr><tr>';  }

  }

echo '</tr></table>';

  


?>
</div>

<b class="b4b"></b><b class="b3b"></b><b class="b2b"></b><b class="b1b"></b>
</div>
<!-- featured_products_eof //-->
