<?php
/*
  $Id: default_specials.php,v 2.0 2003/06/13

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/
?>
<!-- default_specials //-->

<h1><a href="<?php echo tep_href_link(FILENAME_SPECIALS); ?>"><?php echo sprintf(TABLE_HEADING_DEFAULT_SPECIALS, strftime('%B')); ?></a></h1>
<div class="page">
<b class="b1"></b><b class="b2"></b><b class="b3"></b><b class="b4"></b>
<div class="pageItem">
<?php

 $new = tep_db_query("select p.products_id, pd.products_name, p.products_price, p.products_tax_class_id, p.products_image, s.specials_new_products_price from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd, " . TABLE_SPECIALS . " s where p.products_status = '1' and s.products_id = p.products_id and p.products_id = pd.products_id and pd.language_id = '" . $languages_id . "' and s.status = '1' order by RAND() limit " . MAX_DISPLAY_SPECIAL_PRODUCTS);
 
     
echo '<table border="0" width="100%" align="center" cellpadding="0" cellspacing="0"><tr>';

$col = 0;

  while ($default_specials = tep_db_fetch_array($new)) {

$col++; 

    $default_specials['products_name'] = tep_get_products_name($default_specials['products_id']);
     echo '<td align="center"><a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $default_specials["products_id"]) . '">' . tep_image(DIR_WS_IMAGES . $default_specials['products_image'], $default_specials['products_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT) . '</a><br /><a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $default_specials['products_id']) . '">' . $default_specials['products_name'] . '</a><br><s>' . $currencies->display_price_nodiscount($default_specials['products_price'], tep_get_tax_rate($default_specials['products_tax_class_id'])) . '</s><br /><span class="productSpecialPrice">' . $currencies->display_price_nodiscount($default_specials['specials_new_products_price'], tep_get_tax_rate($default_specials['products_tax_class_id'])) . '</span></td>';

  if ($col>=3) {  $col=0;  echo '</tr><tr>';  }

  }

echo '</tr></table>';

?>
</div>

<b class="b4b"></b><b class="b3b"></b><b class="b2b"></b><b class="b1b"></b>
</div>
<!-- default_specials_eof //-->
