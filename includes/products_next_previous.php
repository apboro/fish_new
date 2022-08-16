<?php
  /*

  WebMakers.com Added: Previous/Next through categories products
  Thanks to Nirvana, Yoja and Joachim de Boer
  Modifications: Linda McGrath osCommerce@WebMakers.com

  /includes/products_next_previous.php

  Syntax:
  <?php include (DIR_WS_INCLUDES . 'products_next_previous.php'); ?>
  Already has its own table and can be included anywhere in product_info.php

  Add to english.php
  // previous next product
  define('PREV_NEXT_PRODUCT', 'Product ');
  define('PREV_NEXT_FROM', ' from ');

  Can now work with cateogies at any depth

  */
?>
<?php
				// calculate the previous and next
                if ((isset($_GET['manufacturers_id']) && tep_not_null($_GET['manufacturers_id'])) or (isset($_GET['filter_id']) && tep_not_null($_GET['filter_id']))) {
               $products_ids = tep_db_query("select p.products_id from " . TABLE_PRODUCTS . " p where p.products_status = '1'  and p.manufacturers_id = '" . (int)$_GET['manufacturers_id'] . "'");
// BOF manufacturers descriptions
//			$category_name_query = tep_db_query("select manufacturers_name from " . TABLE_MANUFACTURERS . " where manufacturers_id = '" . (int)$_GET['manufacturers_id'] . "'";
				$category_name_query = tep_db_query("select manufacturers_name from " . TABLE_MANUFACTURERS_INFO . " where manufacturers_id = '" . (int)$_GET['manufacturers_id'] . "' and languages_id = '" . (int)$languages_id . "'");
// EOF manufacturers descriptions
				$category_name_row = tep_db_fetch_array($category_name_query);
				$prev_next_in = PREV_NEXT_MB . ($category_name_row['manufacturers_name']);
				$fPath = 'manufacturers_id=' . (int)$_GET['manufacturers_id'];
                } else {
				if (!$current_category_id) {
					$cPath_query = tep_db_query ("SELECT categories_id FROM " . TABLE_PRODUCTS_TO_CATEGORIES . " WHERE products_id ='" .  (int)$_GET['products_id'] . "'");
				    if ($cPath_row = tep_db_fetch_array($cPath_query)) {
      				$current_category_id = $cPath_row['categories_id'];
    				}
				}
				$products_ids = tep_db_query("select p.products_id from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_TO_CATEGORIES . " ptc where p.products_status = '1'  and p.products_id = ptc.products_id and ptc.categories_id = '" . (int)$current_category_id . "'");
				$category_name_query = tep_db_query("select categories_name from " . TABLE_CATEGORIES_DESCRIPTION . " where categories_id = '" . (int)$current_category_id . "' AND language_id = '" . (int)$languages_id . "'");
				$category_name_row = tep_db_fetch_array($category_name_query);
				$prev_next_in = PREV_NEXT_CAT . ($category_name_row['categories_name']);
				$fPath = 'cPath=' . $cPath;
				}
				$id_array = array();
				while ($product_row = tep_db_fetch_array($products_ids)) {
					$id_array[] = $product_row['products_id'];
				}
				reset ($id_array);
				$counter = 0;
				while (list($key, $value) = each ($id_array)) {
					if ($value == (int)$_GET['products_id']) {
						$position = $counter;
						if ($key == 0)
							$previous = -1; // it was the first to be found
						else
							$previous = $id_array[$key - 1];

						if ($id_array[$key + 1])
							$next_item = $id_array[$key + 1];
						else {
							$next_item = $id_array[0];
						}
					}
					$last = $value;
					$counter++;
				}
				if ($previous == -1)
					$previous = $last;
				
				$manufacturer = ''; 
				if (isset($_GET['manufacturers_id']))
				$manufacturer = '&manufacturers_id='.$_GET['manufacturers_id'];
?>
    <table border="0" align="center" width="100%">
      <tr>
        <td align="left" class="main"><?php if ($previous) { ?><a href="<?php echo tep_href_link(FILENAME_PRODUCT_INFO, "products_id=".$previous.$manufacturer); ?>"><?php echo tep_template_image_button('button_prev.gif', IMAGE_BUTTON_PREVIOUS); ?></a><?php } ?></td>
        <td align="center" class="main" valign="top"><?php echo (PREV_NEXT_PRODUCT); ?><?php echo ($position+1 . PREV_NEXT_PRODUCT1 . $counter . '<br>' . $prev_next_in); ?></td>
        <td align="right" class="main">&nbsp;<?php if ($next_item) { ?><a href="<?php echo tep_href_link(FILENAME_PRODUCT_INFO, "products_id=".$next_item.$manufacturer); ?>"><?php echo tep_template_image_button('button_next.gif', IMAGE_BUTTON_NEXT); ?></a><?php } ?></td>
      </tr>
    </table>
