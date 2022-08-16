<?php
#July 11, 2005
#Version 1.0
#By Dan Sullivan
/*===============================================================================*/
/*================================================================================*/

$reviews_query = tep_db_query("select r.reviews_id, r.customers_name, r.date_added, rd.reviews_text, r.reviews_rating FROM reviews r, reviews_description rd WHERE r.status_otz = '1' and r.reviews_id = rd.reviews_id AND r.products_id = '" . (int)$_GET['products_id'] . "' AND rd.languages_id = '" . (int)$languages_id . "' ORDER BY r.date_added DESC LIMIT " . MAX_REVIEWS);
$info_box_header = array();
$info_box_header[] = array('text' => BOX_REVIEWS_HEADER_TEXT);
new infoBoxHeading($info_box_header,false,false);

$info_box_contents = array();

while ($reviews = tep_db_fetch_array($reviews_query)) {
  $info_box_contents[][0] = array('align' => 'left',
                                  'params' => 'class="smallText top-valign"',
                                  'text' => '<a href="' . tep_href_link(FILENAME_PRODUCT_REVIEWS_INFO, 'products_id=' . (int)$_GET['products_id'] . '&reviews_id=' . $reviews['reviews_id']) . '"><b>' . $reviews['customers_name'] . '</b>&nbsp;-&nbsp;' . tep_date_short($reviews['date_added']) . '&nbsp;' . tep_image(DIR_WS_IMAGES . 'stars_' . $reviews['reviews_rating'] . '.gif' , sprintf(BOX_REVIEWS_TEXT_OF_5_STARS, $reviews['reviews_rating'])) . '</a><br> ' . $reviews['reviews_text']);
}
 if(tep_db_num_rows($reviews_query) > 0) {
$info_box_contents[][0] = array('align' => 'left',
                          'params' => 'class="smallText top-valign"',
                          'text' => '<a href="' . tep_href_link(FILENAME_PRODUCT_REVIEWS, 'products_id=' . (int)$_GET['products_id']) . '">' . TEXT_VIEW_ALL_REVIEWS . '</a>');
} else {
  $info_box_contents[][0] = array('align' => 'left',
                          'params' => 'class="smallText top-valign"',
                          'text' => NO_REVIEWS_TEXT . '<br /><br /><a href="' . tep_href_link(FILENAME_PRODUCT_REVIEWS_WRITE, tep_get_all_get_params()) . '">' . IMAGE_BUTTON_WRITE_REVIEW . '</a><br />');
}
new contentBox($info_box_contents);

if (MAIN_TABLE_BORDER == 'yes'){
$info_box_contents = array();
$info_box_contents = array();
  $info_box_contents[] = array('align' => 'left',
                                'text'  => tep_draw_separator('pixel_trans.gif', '100%', '1')
                              );
  new infoboxFooter($info_box_contents, true, true);
}

?>