<?php
/*
  $Id: product_reviews.php, v1.0 20090909 kymation Exp $
  $Loc: catalog/includes/modules/ $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2009 osCommerce

  Released under the GNU General Public License
*/


  function get_stars ($count) {
    $rounded = round ($count, 1);
    if ($rounded <= 1) {
      return ('stars_1.gif');
    } elseif ($rounded / floor($rounded) == 1) {
      return ('stars_' . (int)$rounded . '.gif');
    } else {
      return ('stars_' . floor($rounded) . '_.gif');
    }
  }


?>
<!-- product_reviews //-->
                  <div id="REVIEW" class="content<?php echo $selected_tab == 'REVIEW' ? ' active' : ''; ?>">
                    <div class="inside_heading"><?php echo TEXT_TAB_REVIEWS_HEAD; ?></div>
                    <br>
                    <table border=0 cellspacing=0 cellpadding=0><tbody>
<?php
    if (SPECIFICATIONS_MAX_REVIEWS == '0') {
?>
                      <tr>
                        <td align="left" valign="middle" class="main">
<?php
      echo tep_draw_separator('pixel_trans.gif', '100', '2') .
           '<br><a href="' . tep_href_link (FILENAME_PRODUCT_REVIEWS, tep_get_all_get_params() ) . '">' . tep_image_button('button_reviews.gif', IMAGE_BUTTON_REVIEWS) . '</a>';
?>
                        </td>
                      </tr>
<?php
    } else {
      // Check for an approved reviews column
      $reviews_description_query_raw = "
        SHOW COLUMNS 
        FROM 
          " . TABLE_REVIEWS . " 
        WHERE 
          Field 
        LIKE 
          'approv%'
      ";
      $reviews_description_query = tep_db_query ($reviews_description_query_raw);
      
      $approved_sql = '';
      if (tep_db_num_rows ($reviews_description_query) ) {
        $reviews_description = tep_db_fetch_array ($reviews_description_query);
        $approved_sql = "and (" . $reviews_description['Field'] . " = '1'";
        $approved_sql .= "or " . $reviews_description['Field'] . " = 'True')";
      }
                                         
      $reviews_count_query = tep_db_query ("select count(*) as count
                                            from " . TABLE_REVIEWS . "
                                            where products_id = '" . (int) $_GET['products_id'] . "'
                                              " . $approved_sql . "
                                         ");
      $reviews = tep_db_fetch_array($reviews_count_query);

      $reviews_query_average = tep_db_query ("select (avg(reviews_rating)) as average_rating
                                              from " . TABLE_REVIEWS . "
                                              where products_id = '" . (int) $_GET['products_id'] . "'
                                                " . $approved_sql . "
                                            ");
      $reviews_average = tep_db_fetch_array ($reviews_query_average);
      $reviews_stars = $reviews_average['average_rating'];

      $reviews_query_raw = "
        select 
          r.reviews_id,
          rd.reviews_text,
          r.reviews_rating,
          r.date_added,
          r.customers_name
        from " . TABLE_REVIEWS . " r,
             " . TABLE_REVIEWS_DESCRIPTION . " rd
        where r.products_id = '" . (int) $_GET['products_id'] . "'
          and rd.reviews_id = r.reviews_id and r.status_otz = '1'
          and rd.languages_id = '" . $languages_id . "'
                                 " . $approved_sql . "
        order by r.reviews_id DESC
      ";
      // print $reviews_query_raw . '<br>';
      $reviews_query = tep_db_query ($reviews_query_raw);
      $num_rows = tep_db_num_rows ($reviews_query);
?>
                      <tr>
                        <td><h2>
<?php
      if ($num_rows < 1) {
        echo '<a href="' . tep_href_link(FILENAME_PRODUCT_REVIEWS_WRITE, tep_get_all_get_params()) . '">' . tep_image_button('button_write_review.gif', IMAGE_BUTTON_WRITE_REVIEW) .
             '<br><span class=smalltext>' . TEXT_REVIEW_INVITE . '</span></a>';
      }
?>
                        </h2></td>
                      </tr>
                      <tr>
                        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
                      </tr>
<?php
      if ($num_rows > 0) {
        $row = 0;
        while ($reviews = tep_db_fetch_array ($reviews_query)) {
          if ($row < SPECIFICATIONS_MAX_REVIEWS) {
            $row++;
            $date_added = tep_date_short ($reviews['date_added']);
// Write product reviews
?>
                      <tr>
                        <td class="main">
<?php 
            echo tep_image (DIR_WS_IMAGES . 'stars_' . $reviews['reviews_rating'] . '.gif') . ' ' .
                            sprintf (TEXT_REVIEW_BY, tep_output_string_protected ($reviews['customers_name']) ) .  ', ' .
                            tep_date_long ($reviews['date_added']); 
?>
                        </td>
                      </tr>
                      <tr>
                        <td valign="top" class="main">
<?php 
            echo tep_break_string (tep_output_string_protected ($reviews['reviews_text']), 60, '<br>') . ( (strlen ($reviews['reviews_text']) >= 100) ? '<br>' : '') .
                                   '... &nbsp; &nbsp;' .
                                   '<a href="' . tep_href_link (FILENAME_PRODUCT_REVIEWS_INFO, 'products_id=' . $product_info['products_id'] . '&reviews_id=' . $reviews['reviews_id']) . '">' .
                                   'Read Full Review</a>';
?>
                        </td>
                      </tr>
<?php
           } // if ($row 
         } // while ($reviews
       } // if ($num_rows
     } // if (SPECIFICATIONS_MAX_REVIEWS

?>
                    </tbody></table>
                  </div>
<!-- product_reviews_eof //-->
