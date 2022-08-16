<?php
/*
  $Id: best_sellers.php,v 1.1.1.1 2003/09/18 19:05:50 wilt Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2001 osCommerce

  Released under the GNU General Public License
*/
?>
<!-- best_sellers //-->
<?php
  if ($cPath) {
// BOF Enable - Disable Categories Contribution--------------------------------------
    $best_sellers_query = tep_db_query("SELECT distinct p.products_id, pd.products_name
    FROM " . TABLE_PRODUCTS . " p
      LEFT JOIN " . TABLE_PRODUCTS_DESCRIPTION . " pd ON (p.products_id = pd.products_id AND pd.language_id = '" . (int)$languages_id . "' ), " .
             TABLE_PRODUCTS_TO_CATEGORIES . " p2c, " .
             TABLE_CATEGORIES . " c
    WHERE p.products_status = '1'
      AND c.categories_status = '1'
      AND p.products_ordered > 0
      AND p.products_id = p2c.products_id
      AND p2c.categories_id = c.categories_id
      AND '" . (int)$current_category_id . "' IN (c.categories_id, c.parent_id)
    ORDER BY p.products_ordered DESC, pd.products_name
    LIMIT " . MAX_DISPLAY_BESTSELLERS);
  } else {
    $best_sellers_query = tep_db_query("SELECT distinct p.products_id, pd.products_name
    FROM " . TABLE_PRODUCTS . " p
      LEFT JOIN " . TABLE_PRODUCTS_DESCRIPTION . " pd ON (p.products_id = pd.products_id AND pd.language_id = '" . (int)$languages_id . "' ) WHERE p.products_status = '1'
      AND p.products_ordered > 0
    ORDER BY p.products_ordered DESC, pd.products_name
    LIMIT " . MAX_DISPLAY_BESTSELLERS);
  }
// EOF Enable - Disable Categories Contribution--------------------------------------


  if (tep_db_num_rows($best_sellers_query) >= MIN_DISPLAY_BESTSELLERS) {
?>
<div class="box">
<b class="top"><b class="b1"></b><b class="b2"></b><b class="b3"></b><b class="b4"></b><b class="b5"></b></b>
<div class="boxHeader">
<h5><?php echo BOX_HEADING_BESTSELLERS; ?></h5>
</div>
<div class="boxContent">
<?php

    $rows = 0;
    while ($best_sellers = tep_db_fetch_array($best_sellers_query)) {
      $rows++;
      echo tep_row_number_format($rows) . '.&nbsp;<a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $best_sellers['products_id'], 'NONSSL') . '">' . $best_sellers['products_name'] . '</a><br />';
    }

?>
</div>
<b class="bottom"><b class="b5b"></b><b class="b4b"></b><b class="b3b"></b><b class="b2b"></b><b class="b1b"></b></b>
</div>
<?php
  }
?>
<!-- best_sellers_eof //-->