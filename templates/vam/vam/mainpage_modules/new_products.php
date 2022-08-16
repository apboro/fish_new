<?php
/*
  $Id: new_products.php,v 1.34 2003/06/09 22:49:58 hpdl Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/
?>
<!-- new_products //-->
<h1><a href="<?php echo tep_href_link(FILENAME_PRODUCTS_NEW); ?>"><?php echo sprintf(TABLE_HEADING_NEW_PRODUCTS, strftime('%B')); ?></a></h1>
<div class="page">
<b class="b1"></b><b class="b2"></b><b class="b3"></b><b class="b4"></b>
<div class="pageItem">
<?php

  //TotalB2B start
  if ( (!isset($new_products_category_id)) || ($new_products_category_id == '0') ) {
    $new_products_query = tep_db_query("select p.products_id, p.products_image, p.products_tax_class_id, pd.products_name, if(s.status, s.specials_new_products_price, p.products_price) as products_price from " . TABLE_PRODUCTS . " p left join " . TABLE_SPECIALS . " s on p.products_id = s.products_id, " . TABLE_PRODUCTS_DESCRIPTION . " pd where p.products_status = '1' and p.products_id = pd.products_id and pd.language_id = '" . (int)$languages_id . "' order by p.products_date_added desc limit " . MAX_DISPLAY_NEW_PRODUCTS);
  } else {
    $new_products_query = tep_db_query("select distinct p.products_id, p.products_image, p.products_tax_class_id, pd.products_name, if(s.status, s.specials_new_products_price, p.products_price) as products_price from " . TABLE_PRODUCTS . " p left join " . TABLE_SPECIALS . " s on p.products_id = s.products_id, " . TABLE_PRODUCTS_DESCRIPTION . " pd, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c, " . TABLE_CATEGORIES . " c where p.products_id = p2c.products_id and p2c.categories_id = c.categories_id and c.parent_id = '" . (int)$new_products_category_id . "' and p.products_status = '1' and p.products_id = pd.products_id and pd.language_id = '" . (int)$languages_id . "' order by p.products_date_added desc limit " . MAX_DISPLAY_NEW_PRODUCTS);
  }
  //TotalB2B end


echo '<table border="0" width="100%" align="center" cellpadding="0" cellspacing="0"><tr>';

$col = 0;

  while ($new_products = tep_db_fetch_array($new_products_query)) {

$col++; 


//    $special_price = tep_get_products_special_price($new_products['products_id']);
//    if ($special_price) {
//      $products_price = '<s>' .  $currencies->display_price($new_products['products_price'], tep_get_tax_rate($new_products['products_tax_class_id'])) . '</s>&nbsp;&nbsp;<span class="productSpecialPrice">' . $currencies->display_price($special_price, tep_get_tax_rate($new_products['products_tax_class_id'])) . '</span>';
//    } else {
//      $products_price = $currencies->display_price($new_products['products_price'], tep_get_tax_rate($new_products['products_tax_class_id']));
//    }

	//TotalB2B start & TotalB2B start

	if ($new_price = tep_get_products_special_price($new_products['products_id'])) {
     $new_products['products_price'] = $new_price; // Обычная цена
     $new_products['specials_new_products_price'] = tep_xppp_getproductprice($new_products['products_id']); // Спец. цена
	  echo '<td align="center"><a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $new_products['products_id']) . '">' . tep_image(DIR_WS_IMAGES . $new_products['products_image'], $new_products['products_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT) . '</a><br><a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $new_products['products_id']) . '">' . $new_products['products_name'] . '</a><br /><s>' . $currencies->display_price_nodiscount($new_products['specials_new_products_price'], tep_get_tax_rate($new_products['products_tax_class_id'])) . '</s><br><span class="productSpecialPrice">' . 
                                           $currencies->display_price_nodiscount($new_products['products_price'], tep_get_tax_rate($new_products['products_tax_class_id'])).'</td>';
    } else {
     $new_products['products_price'] = $new_price; // Обычная цена
     $new_products['specials_new_products_price'] = tep_xppp_getproductprice($new_products['products_id']); // Спец. цена
	  echo '<td align="center"><a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $new_products['products_id']) . '">' . tep_image(DIR_WS_IMAGES . $new_products['products_image'], $new_products['products_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT) . '</a><br /><a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $new_products['products_id']) . '">' . $new_products['products_name'] . '</a><br>' . $currencies->display_price($new_products['specials_new_products_price'], tep_get_tax_rate($new_products['products_tax_class_id'])).'</td>';
    }

  if ($col>=3) {  $col=0;  echo '</tr><tr>';  }

  }

echo '</tr></table>';

?>
<div class="clear"></div>
</div>

<b class="b4b"></b><b class="b3b"></b><b class="b2b"></b><b class="b1b"></b>
</div>
<!-- new_products_eof //-->
