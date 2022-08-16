<?php
/*
  $Id: products.php,v 1.2 2007/09/24 15:18:15 wilt Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/

require_once (DIR_WS_CLASSES.'currencies.php');

$currencies = new currencies();

?>
          <tr>
            <td valign="top"><table class="table-padding-2">
				  <tr> 
				    <td colspan="3" class="pageHeading" width="100%">

    <h4><?php echo '<a href="' . tep_href_link(FILENAME_CATEGORIES, '', 'NONSSL') . '">' . TEXT_SUMMARY_PRODUCTS . '</a>'; ?></h4>
				    
				    </td>
				  </tr>
              <tr class="dataTableHeadingRow">
                <td width="35%" class="dataTableHeadingContent"><?php echo TABLE_HEADING_PRODUCT_NAME; ?></td>
                <td width="35%" class="dataTableHeadingContent"><?php echo TABLE_HEADING_PRODUCT_PRICE; ?></td>
                <td width="30%" class="dataTableHeadingContent"><?php echo TABLE_HEADING_DATE; ?></td>
              </tr>

<?php

        $products_query_raw = tep_db_query("
        SELECT 
        p.products_tax_class_id,
        p.products_id, 
        pd.products_name, 
        p.products_price, 
        p.products_date_added, 
        p.products_last_modified 
        FROM " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd WHERE p.products_id = pd.products_id AND pd.language_id = '" . (int)$_SESSION['languages_id'] . "' order by p.products_date_added, pd.products_name limit 20");

	while ($products = tep_db_fetch_array($products_query_raw)) {

            $price = $products['products_price'];
            $price = tep_round($price,PRICE_PRECISION);

?>
              <tr>
                <td class="dataTableContent"><a href="<?php echo tep_href_link(FILENAME_CATEGORIES, tep_get_all_get_params(array('pID', 'action')) . 'pID=' . $products['products_id'] . '&action=new_product'); ?>"><?php echo $products['products_name']; ?></a></td>
                <td class="dataTableContent"><?php echo $currencies->format($price); ?></td>
                <td class="dataTableContent"><?php echo $products['products_date_added']; ?></td>
              </tr>
<?php

	}
?>

                </table></td>
              </tr>