<?php
/*
  $Id: reviews.php,v 1.1.1.1 2003/09/18 19:05:48 wilt Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2002 osCommerce

  Released under the GNU General Public License
*/
?>
<!-- reviews //-->
<div class="box">
<b class="top"><b class="b1"></b><b class="b2"></b><b class="b3"></b><b class="b4"></b><b class="b5"></b></b>
<div class="boxHeader">
<h5><?php echo BOX_HEADING_REVIEWS; ?></h5>
</div>
<div class="boxContent"><?php

  $random_select = "select r.reviews_id, r.reviews_rating, substring(rd.reviews_text, 1, 60) as reviews_text, p.products_id, p.products_image from " . TABLE_REVIEWS . " r left join " . TABLE_PRODUCTS . " p on r.products_id = p.products_id, " . TABLE_REVIEWS_DESCRIPTION . " rd where p.products_status = '1' and r.status_otz = '1' and rd.reviews_id = r.reviews_id and languages_id = '" . $languages_id . "'";
  if ($_GET['products_id']) {
    $random_select .= " and p.products_id = '" . $_GET['products_id'] . "'";
  }
  $random_select .= " order by r.reviews_id DESC limit " . MAX_RANDOM_SELECT_REVIEWS;
  $random_product = tep_random_select($random_select);

  if ($random_product) {
// display random review box
    $random_product['products_name'] = tep_get_products_name($random_product['products_id']);
    $review = htmlspecialchars($random_product['reviews_text']);
    $review = tep_break_string($review, 15, '-<br>');

    echo '<a href="' . tep_href_link(FILENAME_PRODUCT_REVIEWS_INFO, 'products_id=' . $random_product['products_id'] . '&reviews_id=' . $random_product['reviews_id'], 'NONSSL') . '">' . tep_image(DIR_WS_IMAGES . $random_product['products_image'], $random_product['products_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT) . '</a><a href="' . tep_href_link(FILENAME_PRODUCT_REVIEWS_INFO, 'products_id=' . $random_product['products_id'] . '&reviews_id=' . $random_product['reviews_id'], 'NONSSL') . '">' . $review . ' ..</a><br />' . tep_image(DIR_WS_TEMPLATES . TEMPLATE_NAME . '/images/content/stars_' . $random_product['reviews_rating'] . '.gif' , sprintf(BOX_REVIEWS_TEXT_OF_5_STARS, $random_product['reviews_rating'])) . '';

  } elseif ($_GET['products_id']) {
// display 'write a review' box
    echo '<table border="0" cellspacing="0" cellpadding="2"><tr><td class="infoBoxContents"><a href="' . tep_href_link(FILENAME_PRODUCT_REVIEWS_WRITE, 'products_id=' . $_GET['products_id'], 'NONSSL') . '">' . tep_image(DIR_WS_TEMPLATES . TEMPLATE_NAME . '/images/content/box_write_review.gif', IMAGE_BUTTON_WRITE_REVIEW) . '</a></td><td class="infoBoxContents"><a href="' . tep_href_link(FILENAME_PRODUCT_REVIEWS_WRITE, 'products_id=' . $_GET['products_id'], 'NONSSL') . '">' . BOX_REVIEWS_WRITE_REVIEW .'</a></td></tr></table>';

  } else {
// display 'no reviews' box
    echo BOX_REVIEWS_NO_REVIEWS;
  }

?>
</div>
<b class="bottom"><b class="b5b"></b><b class="b4b"></b><b class="b3b"></b><b class="b2b"></b><b class="b1b"></b></b>
</div>
<!-- reviews_eof //-->