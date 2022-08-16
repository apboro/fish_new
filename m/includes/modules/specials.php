<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2013 osCommerce

  Released under the GNU General Public License
*/

  if ( (!isset($new_products_category_id)) || ($new_products_category_id == '0') ) {
    $new_products_query = tep_db_query("SELECT a.*, b.*,c.* FROM " . TABLE_SPECIALS . " as a, " . TABLE_PRODUCTS . " as b,".TABLE_PRODUCTS_DESCRIPTION." as c  WHERE a.`products_id` = b.`products_id` and a.status=1 and a.`products_id` = c.`products_id`");
  } else {
    $new_products_query = tep_db_query("SELECT a.*, b.*,c.* FROM " . TABLE_SPECIALS . " as a, " . TABLE_PRODUCTS . " as b,".TABLE_PRODUCTS_DESCRIPTION." as c  WHERE a.`products_id` = b.`products_id` and a.status=1 and a.`products_id` = c.`products_id`");
  }

  $num_new_products = tep_db_num_rows($new_products_query);

  if ($num_new_products > 0) {
    $counter = 0;
    $col = 0;

    $new_prods_content = '<table class="table-padding-2">';
    while ($new_products = tep_db_fetch_array($new_products_query)) {
    $cleanup_fields=array('products_name','products_description','products_info');
    foreach($cleanup_fields as $cleanup){
	$new_products[$cleanup]=strip_tags($new_products[$cleanup]);
	}

		$products_description = strip_tags($new_products['products_description']);	
		$products_description = ltrim(mb_substr($products_description, 0, 80,'utf-8') . '...'); //Trims and Limits the desc
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
				 <div class="prodprice">
				 	<span class="normalprice">' . 
	  					$currencies->display_price($new_products['products_price'], tep_get_tax_rate($new_products['products_tax_class_id'])) . 
				 	'</span>
					<span class="productSpecialPrice">' .
						$currencies->display_price($new_products['specials_new_products_price'], tep_get_tax_rate($new_products['products_tax_class_id'])) .
					'</span>
				 </div>
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

  <h2><?php echo sprintf(TABLE_HEADING_SPECIAL_PRODUCTS, strftime('%B')); ?></h2>

  <div class="contentText">
    <?php echo $new_prods_content; ?>
  </div>

<?php
  }
?>
