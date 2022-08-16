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
          <tr>
            <td>
<?php
  $info_box_contents = array();
    $info_box_contents[] = array('text'  => '<font color="' . $font_color . '">' . BOX_HEADING_BESTSELLERS . '</font>');
  new infoBoxHeading($info_box_contents, false, false, tep_href_link(FILENAME_BEST_SELLERS));

    $rows = 0;
    $info_box_contents = array();
    while ($best_sellers = tep_db_fetch_array($best_sellers_query)) {
      $rows++;
      $info_box_contents[] = array('align' => 'left',
                                   'text'  => tep_row_number_format($rows) . '.&nbsp;<a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $best_sellers['products_id'], 'NONSSL') . '">' . $best_sellers['products_name'] . '</a>');
    }

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
<!-- best_sellers_eof //-->

