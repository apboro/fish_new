<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2013 osCommerce

  Released under the GNU General Public License
*/

  require('includes/application_top.php');

  require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_SPECIALS);

  $breadcrumb->add(NAVBAR_TITLE, tep_href_link(FILENAME_SPECIALS));

  require(DIR_WS_INCLUDES . 'template_top.php');
?>
<div class="contentContainer" id="specials">
<h1><?php echo HEADING_TITLE; ?></h1>

  <div class="contentText">

<?php
  $specials_query_raw = "select p.products_id, pd.products_name, pd.products_description, p.products_price, p.products_tax_class_id, p.products_image, s.specials_new_products_price from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd, " . TABLE_SPECIALS . " s where p.products_status = '1' and s.products_id = p.products_id and p.products_id = pd.products_id and pd.language_id = '" . (int)$languages_id . "' and s.status = '1' order by p.products_price ASC";
  $specials_split = new splitPageResults($specials_query_raw, 50);

  if (($specials_split->number_of_rows > 0) && ((PREV_NEXT_BAR_LOCATION == '1') || (PREV_NEXT_BAR_LOCATION == '3'))) {
?>

    <div>
      <span style="float: right;"><?php echo TEXT_RESULT_PAGE . ' <span class="mj-pagination">' . $specials_split->display_links(MAX_DISPLAY_PAGE_LINKS, tep_get_all_get_params(array('page', 'info', 'x', 'y'))); ?></span></span>

      <span><?php echo $specials_split->display_count(TEXT_DISPLAY_NUMBER_OF_SPECIALS); ?></span>
    </div>

    <br />

<?php
  }
?>

    <table class="table-padding-0">
      <tr>
<?php
    $row = 0;
    $specials_query = tep_db_query($specials_split->sql_query);
    while ($specials = tep_db_fetch_array($specials_query)) {
		$description = $specials['products_description'];
		$description = ltrim(mb_substr($description, 0, 40,'utf-8') . '...'); //Trims and Limits the desc
      $row++;
	  //print_r($specials);

      echo '<td align="center" width="33%">
	  			<div class="centerBoxContentsNew centeredContent">
	  				<div class="imagename">
						<div class="product_image">
	  						<a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $specials['products_id']) . '">' . tep_image(DIR_WS_IMAGES . $specials[
								'products_image'], $specials['products_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT) . '</a>
						</div><br />
						<div class="product_name">
							<a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $specials['products_id']) . '">' . $specials['products_name'] . '</a>
						</div><br />
					</div>
				 			<span class="normalprice">' .
								$currencies->display_price($specials['products_price'], tep_get_tax_rate($specials['products_tax_class_id'])) . 
							'</span>
							<span class="productSpecialPrice">' . 
								$currencies->display_price($specials['specials_new_products_price'], tep_get_tax_rate($specials['products_tax_class_id'])) . 
							'</span>
						</div>
					
                    <!--	<div class="productbtn">
	  				 		<div class="mj-productdetailimage">
								<a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $specials['products_id']) . '">More</a>
							</div>
						</div> 
                        -->
                        
                        
			</td>' . "\n";
            
            

      if ((($row / 3) == floor($row / 3))) {
?>
      </tr>
      <tr>
<?php
      }
    }
?>
      </tr>
    </table>

<?php
  if (($specials_split->number_of_rows > 0) && ((PREV_NEXT_BAR_LOCATION == '2') || (PREV_NEXT_BAR_LOCATION == '3'))) {
?>

    <div class="mj-productpagination">
      <span style="float: right;"><?php echo TEXT_RESULT_PAGE . ' <span class="mj-pagination">' . $specials_split->display_links(MAX_DISPLAY_PAGE_LINKS, tep_get_all_get_params(array('page', 'info', 'x', 'y'))); ?></span></span>

      <span><?php echo $specials_split->display_count(TEXT_DISPLAY_NUMBER_OF_SPECIALS); ?></span>
    </div>

<?php
  }
?>

  </div>
</div>

<?php
  require(DIR_WS_INCLUDES . 'template_bottom.php');
  require(DIR_WS_INCLUDES . 'application_bottom.php');
?>
