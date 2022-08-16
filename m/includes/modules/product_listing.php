<?php
define('DISPLAY_VIEW', 0);//----1 = mobile not strings 0 -strings
define('PRODUCTS_DISPLAY', true);
require(FILENAME_CATEGORY_LISTING);
$listing_split = new splitPageResults($listing_sql, MAX_DISPLAY_SEARCH_RESULTS, 'p.products_id');
?>
<div class="contentText" id="productlisting">
    <?php
    if (($listing_split->number_of_rows > 0) && ((PREV_NEXT_BAR_LOCATION == '1') || (PREV_NEXT_BAR_LOCATION == '3'))) {
        ?>
        <div>
      <span style="float: right;"><?php echo TEXT_RESULT_PAGE . ' <span class="mj-pagination">' . $listing_split->display_links(MAX_DISPLAY_PAGE_LINKS,
                  tep_get_all_get_params(array('page', 'info', 'x', 'y'))); ?></span>
            </span>
            <span><?php echo $listing_split->display_count(TEXT_DISPLAY_NUMBER_OF_PRODUCTS); ?></span>
        </div>
        <br/>
        <?php
        //}
        if (DISPLAY_VIEW == 0) {
            $prod_list_contents =
                '<div class="productlistingContainer">' .
                '<div class="productlistingHeading">' .
                '<table border="0" width="100%" cellspacing="0" cellpadding="2" class="productListingHeader tableHeading">' .
                '<tr>';

            for ($col = 0, $n = sizeof($column_list); $col < $n; $col++) {
                $lc_align = '';
                switch ($column_list[$col]) {
                    case 'PRODUCT_LIST_MODEL':
                        $lc_text = TABLE_HEADING_MODEL;
                        $lc_align = 'center';
                        $class = 'product_model';
                        break;
                    case 'PRODUCT_LIST_NAME':
                        $lc_text = TABLE_HEADING_PRODUCTS;
//        						$lc_align = 'center';
                        $lc_align = 'left';
                        $class = 'product_list_name';
                        break;
                    case 'PRODUCT_LIST_MANUFACTURER':
                        $lc_text = TABLE_HEADING_MANUFACTURER;
                        $lc_align = 'center';
                        $class = 'product_manufacturer';
                        break;
                    case 'PRODUCT_LIST_PRICE':
                        $lc_text = TABLE_HEADING_PRICE;
                        $lc_align = 'center';
                        $class = 'product_list_price';
                        break;
                    case 'PRODUCT_LIST_QUANTITY':
                        $lc_text = TABLE_HEADING_QUANTITY;
                        $lc_align = 'center';
                        $class = 'product_quantity';
                        break;
                    case 'PRODUCT_LIST_WEIGHT':
                        $lc_text = TABLE_HEADING_WEIGHT;
                        $lc_align = 'center';
                        $class = 'product_weight';
                        break;
                    case 'PRODUCT_LIST_IMAGE':
                        //$lc_text = TABLE_HEADING_PRODUCT_IMAGE;
                        $lc_text = '';
                        $lc_align = 'center';
                        $class = 'product_list_image';
                        break;
                    case 'PRODUCT_LIST_BUY_NOW':
                        $lc_text = TABLE_HEADING_BUY_NOW;
                        $lc_align = 'center';
                        $class = 'buy_now';
                        break;
                }
                if (($column_list[$col] != 'PRODUCT_LIST_BUY_NOW') && ($column_list[$col] != 'PRODUCT_LIST_IMAGE')) {
                    $lc_text = tep_create_sort_heading($HTTP_GET_VARS['sort'], $col + 1, $lc_text);
                }
                $prod_list_contents .= '<th' . (tep_not_null($lc_align) ? ' align="' . $lc_align . '"' : '') . 'class=' . $class . '>' . $lc_text . '</th>';
            }
            $prod_list_contents .= '</tr>';

            if ($listing_split->number_of_rows > 0) {
                $rows = 0;
               // $listing_query = tep_db_query($listing_split->sql_query);

                $products_ids = array();
                $sale_category_query = array();
                while ($listing = tep_db_fetch_array($listing_split->sql_query)) {
                    $products[] = $listing;
                    $products_ids[] = $listing['products_id'];
                    $sale_category_query[] = $listing['categories_id'];
                }

                $sale_query = tep_db_query("select * from " . TABLE_SALEMAKER_SALES . " where sale_categories_all like '%," . implode(",%' OR sale_categories_all like '%,",$sale_category_query) . ",%' 
    and sale_status = '1' and (sale_date_start <= now() or sale_date_start = '0000-00-00') and 
    (sale_date_end >= now() or sale_date_end = '0000-00-00') ");

                //Проверяем, есть ли скидки в этой категории
                $has_sales = false;
                if($sale_query->num_rows > 0){
                    $has_sales = true;
                }
                $product_info_hrefs = tep_product_info_href_links($products_ids,($cPath ? 'cPath=' . $cPath:""));
                foreach ($products as $listing ) {
                    $rows++;
                    $products_name = CleanupBadSymbols($listing['products_name']);
//      $products_description=CleanupBadSymbols(strip_tags($listing['products_description']));
                    $extra_fields_text = '';
                    $prod_list_contents .= '<tr class="tablecontent qview">';

                    for ($col = 0, $n = sizeof($column_list); $col < $n; $col++) {
                        switch ($column_list[$col]) {
                            case 'PRODUCT_LIST_MODEL':
                                $prod_list_contents .= '<td align="center" class="product_model">' . $listing['products_model'] . '</td>';
                                break;
                            case 'PRODUCT_LIST_NAME':

                                $products_name = '<div class="product_list_image_name" style="text-align:center">' .
                                    tep_image(DIR_WS_IMAGES . $listing['products_image'], $products_name, SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT) .
                                    '</div><br>' . $products_name;

                                if (isset($HTTP_GET_VARS['manufacturers_id']) && tep_not_null($HTTP_GET_VARS['manufacturers_id'])) {
//              $prod_list_contents .= '<td align="center" class="product_list_name"><a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'manufacturers_id=' . $HTTP_GET_VARS['manufacturers_id'] . '&products_id=' . $listing['products_id']) . '">' . $products_name . '</a></td>';
                                    $prod_list_contents .= '<td align="center" class="product_list_name"><a href="' .$product_info_hrefs[$listing['products_id']] . '"><b>' . $products_name . '</b></a>
              <br>'
                                        .$listing['products_info'] . $extra_fields_text .
                                        '</td>';

                                } else {
                                    $prod_list_contents .= '<td align="center" class="product_list_name"><a href="' . $product_info_hrefs[$listing['products_id']] . '"><b>' . $products_name . '</b></a>
              <br>'
                                        . $listing['products_info'] . $extra_fields_text .
                                        '</td>';
//              $prod_list_contents .= '<td align="justify" class="product_list_name"><a href="' . tep_href_link(FILENAME_PRODUCT_INFO, ($cPath ? 'cPath=' . $cPath . '&' : '') . 'products_id=' . $listing['products_id']) . '">' . mb_substr($products_description,0,256,'utf-8') . '...</a></td>';
                                }
                                break;
                            case 'PRODUCT_LIST_MANUFACTURER':
                                $prod_list_contents .= '        <td align="center" class="product_manufacturer"><a href="' . tep_href_link(FILENAME_DEFAULT, 'manufacturers_id=' . $listing['manufacturers_id']) . '">' . $listing['manufacturers_name'] . '</a></td>';
                                break;
                            case 'PRODUCT_LIST_PRICE':
                                $sprice = DisplayPriceQuick($listing, $listing['products_price'], $listing['products_tax_class_id'],$has_sales);
                                /*            if (tep_not_null($listing['specials_new_products_price'])) {
                                              $prod_list_contents .= '        <td align="center" class="product_list_price"><del>' .  $currencies->display_price($listing['products_price'], tep_get_tax_rate($listing['products_tax_class_id'])) . '</del>&nbsp;&nbsp;<span class="productSpecialPrice">' . $currencies->display_price($listing['specials_new_products_price'], tep_get_tax_rate($listing['products_tax_class_id'])) . '</span></td>';
                                            } else {
                                              $prod_list_contents .= '        <td align="center" class="product_list_price">' . $currencies->display_price($listing['products_price'], tep_get_tax_rate($listing['products_tax_class_id'])) . '</td>';
                                            }*/
                                $prod_list_contents .= '<td align="center" class="product_list_price">' . $sprice . '</td>';
                                break;
                            case 'PRODUCT_LIST_QUANTITY':
                                $prod_list_contents .= '        <td align="center" class="product_quantity">' . $listing['products_quantity'] . '</td>';
                                break;
                            case 'PRODUCT_LIST_WEIGHT':
                                $prod_list_contents .= '        <td align="center" class="product_weight">' . $listing['products_weight'] . '</td>';
                                break;
                            case 'PRODUCT_LIST_IMAGE':
                                if (isset($HTTP_GET_VARS['manufacturers_id']) && tep_not_null($HTTP_GET_VARS['manufacturers_id'])) {
                                    $prod_list_contents .= '        <td align="center"  class="product_list_image"><a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'manufacturers_id=' . $HTTP_GET_VARS['manufacturers_id'] . '&products_id=' . $listing['products_id']) . '" class="qover">' . tep_image(DIR_WS_IMAGES . $listing['products_image'], $products_name, SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT) .
                                        '<div>Быстрый просмотр</div>' .
                                        '</a></td>';
                                } else {
                                    $prod_list_contents .= '        <td align="center" class="product_list_image"><a href="' . $product_info_hrefs[$listing['products_id']] . '" class="qover">' . tep_image(DIR_WS_IMAGES . $listing['products_image'], $products_name, SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT) .
                                        '<div>Быстрый просмотр</div>' .
                                        '</a></td>';
                                }
//            $prod_list_contents.='<td></td>';
                                break;
                            case 'PRODUCT_LIST_BUY_NOW':
                                $sprice = DisplayPriceQuick($listing, $listing['products_price'], $listing['products_tax_class_id'],$has_sales);
                                $price_content = '<div class="price_buy">' . $sprice . '<br></div>';
                                /*            $price_content.=$listing['products_quantity'].'=='.
                                            $listing['pq'];*/
                                if ($listing['products_quantity'] < 9999) {
                                    if (isset($listing['pq']) && ($listing['pq'] > 0)) {
                                        $price_content .= '<p class="instore">В наличии</p>';
                                    }
                                } else {
                                    $price_content .= '<p class="instore">В наличии</p>';
                                }


                                if ($listing['products_quantity'] > 0) {
//            $prod_list_contents .= '        <td align="center" class="buy_now">' . tep_draw_button(IMAGE_BUTTON_BUY_NOW, 'cart', tep_href_link($PHP_SELF, tep_get_all_get_params(array('action')) . 'action=buy_now&products_id=' . $listing['products_id'])) . '</td>';
                                    $prod_list_contents .= '<td align="center" class="buy_now">' .
                                        $price_content . '<a href="' . tep_href_link($PHP_SELF, tep_get_all_get_params(array('action')) . 'action=buy_now&products_id=' . $listing['products_id']) . '">
               <i  class="fa  fa-shopping-cart  fa-2x"></i></a></td>';
                                } else {
//            $prod_list_contents .= '<td align="center" class="buy_now"><span class="markProductOutOfStock">' . STOCK_MARK_PRODUCT_OUT_OF_STOCK . '</span></td>';
                                    $prod_list_contents .= '<td align="center" class="buy_now">' . $price_content .
                                        '<span class="noproduct_list"><img src="' . DIR_WS_IMAGES . 'nopmob.png" class="noproduct" ></span>' . '</td>';
//            '<span class="markProductOutOfStock"><img width="80" height="62" border="0" alt="" src="images/nt_nw_tm.jpg"></span></td>';
                                }

                                break;
                        }
                    }

                    $prod_list_contents .= '      </tr>';
                }

                $prod_list_contents .= '    </table>' .
                    '  </div>' .
                    '</div>';

                echo $prod_list_contents;
            }//----end of string list
        }//-----display view=0
        else {
//    define('MAX_COL',MAX_DISPLAY_CATEGORIES_PER_ROW_MOB);
            define('MAX_COL', 2);
            $counter = 0;
            $col = 0;
            $new_prods_content = '<table border="0" width="100%" cellspacing="2" cellpadding="2">';
            $new_prods_content .= '<tr><td>';
//    $new_prods_content = '';
            //$listing_query = tep_db_query($listing_split->sql_query);
            while ($new_products = tep_db_fetch_array($listing_split->sql_query)) {
                $products_name = CleanupBadSymbols($new_products['products_name']);
                /*    $products_description = '...';
                        $products_description = strip_tags($new_products['products_description']);
                        $products_description = ltrim((mb_substr($products_description, 0, 80,'utf-8') . '...')); //Trims and Limits the desc
                */
                /*
                      $counter++;
                      if ($col === 0) {
                        $new_prods_content .= '<tr>';
                      }*/
//      $new_prods_content .= '<td width="'.ceil(100/MAX_COL).'%" align="center" valign="top">';

                $new_prods_content .= '<div class="PLB">';
                $new_prods_content .= '<div class="centerBoxContentsNew centeredContent">
	  		<div class="imagename">
				<div class="product_image">
					<a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $new_products['products_id']) . '">' .
                    tep_image(DIR_WS_IMAGES . $new_products['products_image'], $products_name, SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT) .
                    'привет</a>
				</div>
				<div class="product_name">
					<a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $new_products['products_id']) . '">' . $products_name . '</a>
				</div>';

                /*$new_prods_content.='				<div class="product_desc">
                                    <p class="s_desc">
                                        <a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $new_products['products_id']) . '">' . $products_description . '</a>
                                    </p>
                                </div>';
                */
                $new_prods_content .= '			 </div> 
			 <div class="propricemain">
				 <div class="prodprice">';

                $new_prods_content .= DisplayPrice($new_products['products_id'], $new_products['products_price'], $new_products['products_tax_class_id']);
                $prod_min_qty = tep_get_products_quantity_order_min($new_products['products_id']);
                if ($prod_min_qty > 1) {
                    $new_prods_content .= '<br><small>Минимум: ' . $prod_min_qty . '</small>';
                }


                /*            if (tep_not_null($new_products['specials_new_products_price'])) {
                              $new_prods_content .= '<del>' .  $currencies->display_price($new_products['products_price'], tep_get_tax_rate($new_products['products_tax_class_id'])) . '</del>
                                &nbsp;&nbsp;<span class="productSpecialPrice">' . $currencies->display_price($new_products['specials_new_products_price'], tep_get_tax_rate($new_products['products_tax_class_id'])) . '</span>';
                            } else {
                              $new_prods_content .= $currencies->display_price($new_products['products_price'], tep_get_tax_rate($new_products['products_tax_class_id'])) ;
                            }*/

//    	$currencies->display_price($new_products['products_price'], tep_get_tax_rate($new_products['products_tax_class_id'])) .
                $new_prods_content .= '</div>
				 ';
                if (tep_get_products_stock($new_products['products_id']) > 0) {
                    $new_prods_content .= '  <div class="productbtn"><div class="mj-productdetailimage">';
                    $new_prods_content .= '<a href="' . tep_href_link($PHP_SELF, tep_get_all_get_params(array('action')) . 'action=buy_now&products_id=' . $new_products['products_id']) . '">More</a>';
                    $new_prods_content .= '</div></div>';
                } else {
//        	$new_prods_content .= '<img src="'.DIR_WS_IMAGES.'nt_nw_tm.jpg" class="noproduct" >';
                    $new_prods_content .= '<span class="noproduct_list"><img src="' . DIR_WS_IMAGES . 'nopmob.png" class="noproduct" ></span>';
//		$new_prods_content.='<span class="noproduct_list">Временно отсутствует</span>';
                }
//					  <a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $new_products['products_id']) . '">'.'More</a>
                $new_prods_content .= '
			  </div>
		  </div> 
</div>';
                /*      $col ++;
                      if (($col >= MAX_COL) || ($counter == $num_new_products)) {
                        $new_prods_content .= '</tr>';
                        $col = 0;
                      }*/
            }
            $new_prods_content .= '</td></tr></table>';
//    $new_prods_content .= '</table>';
            echo '<div class="contentText">' . CompressContent($new_prods_content) . '</div>';
        }

    } else {
        ?>

        <p><?php echo TEXT_NO_PRODUCTS; ?></p>

        <?php
    }

    if (($listing_split->number_of_rows > 0) && ((PREV_NEXT_BAR_LOCATION == '2') || (PREV_NEXT_BAR_LOCATION == '3'))) {
        ?>

        <br/>

        <div class="pagination_container">
            <span class="pager"
                  style="float: right;"><?php echo TEXT_RESULT_PAGE . ' <span class="mj-pagination">' . $listing_split->display_links(MAX_DISPLAY_PAGE_LINKS, tep_get_all_get_params(array('page', 'info', 'x', 'y'))); ?></span></span>

            <span><?php echo $listing_split->display_count(TEXT_DISPLAY_NUMBER_OF_PRODUCTS); ?></span>
        </div>

        <?php 
    }
    ?>
    <script type="text/javascript">//AllignProducts();</script>
</div>
