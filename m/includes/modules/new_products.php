<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2013 osCommerce

  Released under the GNU General Public License
*/

  if ( (!isset($new_products_category_id)) || ($new_products_category_id == '0') ) {
    $new_products_query = tep_db_query("select p.products_id, p.products_image, p.products_tax_class_id, pd.products_name, pd.products_description, if(s.status, s.specials_new_products_price, p.products_price) as products_price from " . TABLE_PRODUCTS . " p left join " . TABLE_SPECIALS . " s on p.products_id = s.products_id, " . TABLE_PRODUCTS_DESCRIPTION . " pd where p.products_status = '1' and p.products_id = pd.products_id and pd.language_id = '" . (int)$languages_id . "' order by p.products_date_added desc limit " . MAX_DISPLAY_NEW_PRODUCTS);
  } else {
    $new_products_query = tep_db_query("select distinct p.products_id, p.products_image, p.products_tax_class_id, pd.products_name, pd.products_description, if(s.status, s.specials_new_products_price, p.products_price) as products_price from " . TABLE_PRODUCTS . " p left join " . TABLE_SPECIALS . " s on p.products_id = s.products_id, " . TABLE_PRODUCTS_DESCRIPTION . " pd, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c, " . TABLE_CATEGORIES . " c where p.products_id = p2c.products_id and p2c.categories_id = c.categories_id and c.parent_id = '" . (int)$new_products_category_id . "' and p.products_status = '1' and p.products_id = pd.products_id and pd.language_id = '" . (int)$languages_id . "' order by p.products_date_added desc limit " . MAX_DISPLAY_NEW_PRODUCTS);
  }

  $num_new_products = tep_db_num_rows($new_products_query);

  if ($num_new_products > 0) {
    $counter = 0;
    $col = 0;

    $new_prods_content = '<table class="table-padding-2">';
    while ($new_products = tep_db_fetch_array($new_products_query)) {
		$products_description = strip_tags($new_products['products_description']);	
		$products_description = ltrim(mb_substr($products_description, 0, 40,'utf-8') . '...'); //Trims and Limits the desc
      $counter++;
      if ($col === 0) {
        $new_prods_content .= '<tr>';
      }

      $new_prods_content .= '<td width="33%" align="center" valign="top">
	  <div class="centerBoxContentsNew centeredContent">
	  		<div class="imagename">
				<div class="product_image">
					<a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $new_products['products_id']) . '">' . 
						tep_image(DIR_WS_IMAGES . $new_products['products_image'], $new_products['products_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT) . 
					'</a>
				</div>
				<br />
				<div class="product_name">
					<a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $new_products['products_id']) . '">' . $new_products['products_name'] . '</a>
				</div>
				<div class="product_desc">
					<p class="s_desc">
						<a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $new_products['products_id']) . '">' . $products_description . '</a>
					</p>
				</div>
			 </div>
			 <div class="propricemain">
				 <div class="prodprice">' . 
	  					$currencies->display_price($new_products['products_price'], tep_get_tax_rate($new_products['products_tax_class_id'])) . 
				 '</div>
				  <div class="productbtn">
	  				 <div class="mj-productdetailimage">					 				 		
						  <a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $new_products['products_id']) . '">'.'More</a>
						 
					 </div>
				  </div>
			  </div>
		  </div>
	  </td>';

      $col ++;

      if (($col > 2) || ($counter == $num_new_products)) {
        $new_prods_content .= '</tr>';

        $col = 0;
      }
    }

    $new_prods_content .= '</table>';
?>

  <h2><?php echo sprintf(TABLE_HEADING_NEW_PRODUCTS, strftime('%B')); ?></h2>

  <div class="contentText">
    <?php echo $new_prods_content; ?>
  </div>

<?php
  }
?>
