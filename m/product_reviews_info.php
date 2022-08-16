<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2013 osCommerce

  Released under the GNU General Public License
*/

  require('includes/application_top.php');

  if (isset($HTTP_GET_VARS['reviews_id']) && tep_not_null($HTTP_GET_VARS['reviews_id']) && isset($HTTP_GET_VARS['products_id']) && tep_not_null($HTTP_GET_VARS['products_id'])) {
    $review_check_query = tep_db_query("select count(*) as total from " . TABLE_REVIEWS . " r, " . TABLE_REVIEWS_DESCRIPTION . " rd where r.reviews_id = '" . (int)$HTTP_GET_VARS['reviews_id'] . "' and r.products_id = '" . (int)$HTTP_GET_VARS['products_id'] . "' and r.reviews_id = rd.reviews_id and rd.languages_id = '" . (int)$languages_id . "' and r.status_otz = 1");
    $review_check = tep_db_fetch_array($review_check_query);

    if ($review_check['total'] < 1) {
      tep_redirect(tep_href_link(FILENAME_PRODUCT_REVIEWS, tep_get_all_get_params(array('reviews_id'))));
    }
  } else {
    tep_redirect(tep_href_link(FILENAME_PRODUCT_REVIEWS, tep_get_all_get_params(array('reviews_id'))));
  }

  tep_db_query("update " . TABLE_REVIEWS . " set reviews_read = reviews_read+1 where reviews_id = '" . (int)$HTTP_GET_VARS['reviews_id'] . "'");

  $review_query = tep_db_query("select rd.reviews_text, r.reviews_rating, r.reviews_id, r.customers_name, r.date_added, r.reviews_read, p.products_id, p.products_price, p.products_tax_class_id, p.products_image, p.products_model, pd.products_name from " . TABLE_REVIEWS . " r, " . TABLE_REVIEWS_DESCRIPTION . " rd, " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd where r.reviews_id = '" . (int)$HTTP_GET_VARS['reviews_id'] . "' and r.reviews_id = rd.reviews_id and rd.languages_id = '" . (int)$languages_id . "' and r.products_id = p.products_id and p.products_status = '1' and p.products_id = pd.products_id and pd.language_id = '". (int)$languages_id . "'");
  $review = tep_db_fetch_array($review_query);

  if ($new_price = tep_get_products_special_price($review['products_id'])) {
    $products_price = '<del>' . $currencies->display_price($review['products_price'], tep_get_tax_rate($review['products_tax_class_id'])) . '</del> <span class="productSpecialPrice">' . $currencies->display_price($new_price, tep_get_tax_rate($review['products_tax_class_id'])) . '</span>';
  } else {
    $products_price = $currencies->display_price($review['products_price'], tep_get_tax_rate($review['products_tax_class_id']));
  }

  if (tep_not_null($review['products_model'])) {
    $products_name = $review['products_name'] . '<br /><span class="smallText">[' . $review['products_model'] . ']</span>';
  } else {
    $products_name = $review['products_name'];
  }

  require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_PRODUCT_REVIEWS_INFO);

  $breadcrumb->add(NAVBAR_TITLE, tep_href_link(FILENAME_PRODUCT_REVIEWS, tep_get_all_get_params()));

  require(DIR_WS_INCLUDES . 'template_top.php');
?>

<div class="contentContainer" id="mj-reviewsInfo">
	<div class="review_prodinfo">
		<div class="mj-product_infoleft">
    		<div class="mj-reviewsProductImage">
        		<div class="productMainImage">
    				<?php echo '<a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $review['products_id']) . '">' . tep_image(DIR_WS_IMAGES . $review['products_image'], addslashes($review['products_name']), SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT, 'hspace="5" vspace="5"') . '</a>'; ?>
            	</div>
        	</div>
    	</div>
    
    	<div class="mj-product_inforight">
    		<div class="product_title">
        		<h3><?php echo $products_name; ?></h3>
        	</div>
        	<div class="product_price">
        		<strong> <?php echo PRICE_TITLE;?> : </strong>
            	<div class="price_amount" style="display:inline-block">
            		<span class="price_amount">
                		<?php echo $products_price; ?>
                	</span>
            	</div>
        	</div>
    	</div>
    </div>



  <div class="list-reviews">
  		<div class="review_box">
        	<div class="ratings">
            	<span class="rating">
                	<?php echo sprintf(tep_image(DIR_WS_IMAGES . 'stars_' . $review['reviews_rating'] . '.gif', 
							sprintf($review['reviews_rating'])), sprintf($review['reviews_rating'])); ?>
                </span>
            </div>
            <div class="mj-review">
            	<div class="review_content">
                	<?php echo tep_break_string(nl2br(tep_output_string_protected($review['reviews_text'])), 60, '-<br />'); ?>
                </div>
                <div class="review_left">
                	<div class="user_detail">
                    	<span class="bold">
                        	<?php echo sprintf(TEXT_REVIEW_BY, tep_output_string_protected($review['customers_name'])); ?>
                        </span>
                        <span class="date">
                        	<?php echo sprintf(TEXT_REVIEW_DATE_ADDED, tep_date_long($review['date_added'])); ?>
                        </span>
                    </div>
                    <div class="buttonSet">
    					<span class="write_review"><?php echo tep_draw_button(IMAGE_BUTTON_WRITE_REVIEW, 'comment', 
								tep_href_link(FILENAME_PRODUCT_REVIEWS_WRITE, tep_get_all_get_params(array('reviews_id'))), 'primary'); ?>
                        </span>
						<?php
                      		if (tep_not_null($review['products_image'])) {
                    	?>
                        <span class="add_to_cart">
    					<?php echo tep_draw_button(IMAGE_BUTTON_IN_CART, 'cart', tep_href_link(basename($PHP_SELF), 
								tep_get_all_get_params(array('action')) . 'action=buy_now')); ?>
							<?php
                              }
                            ?>
    					<span class="back">
							<?php echo tep_draw_button(IMAGE_BUTTON_BACK, 'triangle-1-w', tep_href_link(FILENAME_PRODUCT_REVIEWS, tep_get_all_get_params(array('reviews_id')))); ?>
                        </span>
  					</div>
                </div>
            </div>
        </div>
  </div>

  
</div>

<?php
  require(DIR_WS_INCLUDES . 'template_bottom.php');
  require(DIR_WS_INCLUDES . 'application_bottom.php');
?>
