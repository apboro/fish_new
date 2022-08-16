 
<?php
/*
  $Id: product_listing.php,v 1.44 2003/06/09 22:49:59 hpdl Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/
//---by iHolder make style switchable
?>
        <style>.pmodel{margin:0;padding:0 0 5 0;font-size:0.9Em;color:black;width:99%;display:inline-block;}</style>
<?php
define('PRODUCTS_DISPLAY',true);
$LISTING_STYLE=PRODUCT_LISTING_DISPLAY_STYLE;
/*
if (!isset($_GET['vls'])){
    if (isset($_SESSION['vls'])){
        $_GET['vls']=$_SESSION['vls'];
    }
}
*/
if (isset($_GET['vls'])){
    $_SESSION['vls']=$_GET['vls'];
    $LISTING_STYLE=((int)$_GET['vls']==0)?'list':'columns';
}else{
    $_GET['vls']=($LISTING_STYLE=='list')?0:1;
}
//---by iHolder make style switchable
if (isset($pw_mispell)){ //added for search enhancements mod
    ?>

    <table class="table-padding-2">
        <tr><td><?php echo $pw_string; ?></td></tr>
    </table>
    <?php
} //end added search enhancements mod
// BOF display_all_products
//------------------iHolder switch
?>
    <style>
        div.viewselector{display:block;float:right;position:relative;width:60px;height:28px;}
        div.viewselector a {display:block;float:left;border:none;margin:1px;border-radius:5px;}
        div.viewselector a.view_button{background-image:url("images/glossyback.gif");}
        div.viewselector a.view_button:hover{background-image:url("images/glossyback2.gif");}
        p.instore{font-size:12px;color:blue;font-weight:bold;font-style:Italic;margin:2px;}
    </style>
    <table class="table-padding-2">
        <tr><td>
                <div class="viewselector">
                    <a title="Плитка" class="view_button" href="<?=basename($PHP_SELF).'?'.tep_get_all_get_params(array('vls','srrange')).'vls=1';?>"><img src="/images/tiles.png"></a>
                    <a title="Строки" class="view_button" href="<?=basename($PHP_SELF).'?'.tep_get_all_get_params(array('vls','srrange')).'vls=0';?>"><img src="/images/columns.png"></a>
                </div>

            </td>
        </tr></table>
<?php
//------------------iHolder switch
?>

<?php
$customer_price = tep_get_customer_price();
if ($_GET['page'] == 'all') {
    $listing_split = new splitPageResults($listing_sql, 100, 'p.products_id');
} else
// EOF display_all_products
    $listing_split = new splitPageResults($listing_sql, MAX_DISPLAY_SEARCH_RESULTS, 'p.products_id');
// fix counted products


if ( ($listing_split->number_of_rows > 0) && ( (PREV_NEXT_BAR_LOCATION == '1') || (PREV_NEXT_BAR_LOCATION == '3') ) ) {
	
    ?>
    <table class="table-padding-2">
        <tr>
            <td class="smallText"><?php echo $listing_split->display_count(TEXT_DISPLAY_NUMBER_OF_PRODUCTS); ?></td>
            <td class="smallText" align="right"><?php echo TEXT_RESULT_PAGE . ' ' . $listing_split->display_links(MAX_DISPLAY_PAGE_LINKS, tep_get_all_get_params(array('page', 'info', 'x', 'y'))); ?>
                <?php
                // BOF display_all_products
                if ($listing_split->number_of_rows<100){
                    if ($listing_split->number_of_pages > 1) {
                        ?>
                        <?php echo '<br><a href="' . tep_href_link(basename($PHP_SELF), tep_get_all_get_params(array('page', 'info', 'x', 'y')) . 'page=all', $request_type) . '" class="pageResults" title="' . TEXT_DISPLAY_ALL_PRODUCTS . '">' . TEXT_DISPLAY_ALL_PRODUCTS . '</a>'; ?>
                        <?php
                    } elseif ($_GET['page'] == 'all') {
                        ?>
                        <?php echo '<br><a href="' . tep_href_link(basename($PHP_SELF), tep_get_all_get_params(array('page', 'info', 'x', 'y')) . 'page=1', $request_type) . '" class="pageResults" title="' . TEXT_DISPLAY_BY_PAGES . '" >' . TEXT_DISPLAY_BY_PAGES . '</a>'; ?>
                        <?php
                    }
// EOF display_all_products

                }
                ?>
            </td>
        </tr>
    </table>
    <?php
} 
?>
    <table class="table-padding-2">
        <tr>
            <td class="smallText sorted-fields">Сортировка по:
                <?php
                $sort = array();
                for ($col=0, $n=sizeof($column_list); $col<$n; $col++) {
                    switch ($column_list[$col]) {
                        case 'PRODUCT_LIST_MODEL':
                            $lc_text = 'Модель';
                            $lc_align = '';
                            break;
                        case 'PRODUCT_LIST_NAME':
                            $lc_text = TABLE_HEADING_PRODUCTS;
                            $lc_align = '';
                            break;
                        case 'PRODUCT_LIST_MANUFACTURER':
                            $lc_text = TABLE_HEADING_MANUFACTURER;
                            $lc_align = '';
                            break;
                        case 'PRODUCT_LIST_PRICE':
                            $lc_text = TABLE_HEADING_PRICE;
                            $lc_align = 'right';
                            break;
                        case 'PRODUCT_LIST_QUANTITY':
                            $lc_text = TABLE_HEADING_QUANTITY;
                            $lc_align = 'right';
                            break;
                        case 'PRODUCT_LIST_WEIGHT':
                            $lc_text = TABLE_HEADING_WEIGHT;
                            $lc_align = 'right';
                            break;
                        case 'PRODUCT_LIST_BUY_NOW':
                            $lc_text = TABLE_HEADING_BUY_NOW;
                            $lc_align = 'center';
                            break;
                        case 'PRODUCT_SORT_ORDER':
                            $lc_text = TABLE_HEADING_PRODUCT_SORT;
                            $lc_align = 'center';
                            break;
                        case 'PRODUCT_LIST_IMAGE':
                            $lc_text = TABLE_HEADING_IMAGE;
                            $lc_align = 'center';
                            break;
                    }

                    if ( ($column_list[$col] != 'PRODUCT_LIST_BUY_NOW') && ($column_list[$col] != 'PRODUCT_LIST_IMAGE') ) {
                        $lc_text = tep_create_sort_heading($_GET['sort'], $col+1, $lc_text);
                        $sort[] = $lc_text;
                    }
                }
                echo implode(' | ',$sort);
                ?>
            </td>
        </tr>
    </table>
<?php
if ($LISTING_STYLE == 'list') {
    $list_box_contents = array();
    for ($col=0;$col<sizeof($column_list);$col++){
        if ($column_list[$col]=='PRODUCT_LIST_MODEL'){
            unset($column_list[$col]);
            break;
        }
        }
        for ($col=0, $n=sizeof($column_list); $col<$n; $col++) {
            switch ($column_list[$col]) {
                case 'PRODUCT_LIST_MODEL':
                    $lc_text = TABLE_HEADING_MODEL;
                    $lc_align = '';
                    break;
                case 'PRODUCT_LIST_NAME':
                    $lc_text = TABLE_HEADING_PRODUCTS;
                    $lc_align = '';
                    break;
                case 'PRODUCT_LIST_MANUFACTURER':
                    $lc_text = TABLE_HEADING_MANUFACTURER;
                    $lc_align = '';
                    break;
                case 'PRODUCT_LIST_PRICE':
                    $lc_text = TABLE_HEADING_PRICE;
                    $lc_align = 'right';
                    break;
                case 'PRODUCT_LIST_QUANTITY':
                    $lc_text = TABLE_HEADING_QUANTITY;
                    $lc_align = 'right';
                    break;
                case 'PRODUCT_LIST_WEIGHT':
                    $lc_text = TABLE_HEADING_WEIGHT;
                    $lc_align = 'right';
                    break;
                case 'PRODUCT_LIST_BUY_NOW':
                    $lc_text = TABLE_HEADING_BUY_NOW;
                    $lc_align = 'center';
                    break;
                case 'PRODUCT_SORT_ORDER':
                    $lc_text = TABLE_HEADING_PRODUCT_SORT;
                    $lc_align = 'center';
                    break;
                case 'PRODUCT_LIST_IMAGE':
                    $lc_text = TABLE_HEADING_IMAGE;
                    $lc_align = 'center';
                    break;
            }

            if ( ($column_list[$col] != 'PRODUCT_LIST_BUY_NOW') && ($column_list[$col] != 'PRODUCT_LIST_IMAGE') ) {
                $lc_text = tep_create_sort_heading($_GET['sort'], $col+1, $lc_text);
            }


            /* ORIGINAL 213 */
            $list_box_contents[0][] = array('align' => $lc_align,
                'params' => 'class="productListing-heading"',
                'text' => '&nbsp;' . $lc_text . '&nbsp;');
            /* CDS Patch. 4. BOF
                      if ($list_box_contents[0][$column_list_order[$col]]['text'] != '')
                      {
                        $lc_text = $list_box_contents[0][$column_list_order[$col]]['text'] . ' / ' . $lc_text;
                      }
                      $list_box_contents[0][$column_list_order[$col]] = array('align' => $lc_align,
                                                            'params' => 'class="productListing-heading"',
                                                             'text'  => $lc_text == ''?'&nbsp;':$lc_text);
            /* CDS Patch. 4. EOF */
        }

    if ($listing_split->number_of_rows > 0) {
        $rows = 0;
       // $listing_query = tep_db_query($listing_split->sql_query);
// Start products specifications
        if ( (SPECIFICATIONS_COMP_TABLE_ROW == 'top' || SPECIFICATIONS_COMP_TABLE_ROW == 'both') && $current_category_id != 0 && $show_comparison == true && tep_has_spec_group ($current_category_id, 'show_comparison') == true && basename ($PHP_SELF) == 'index.php') {
            $list_box_contents[0] = array ('params' => 'class="productListing-even"');
            for ($col=0, $n=sizeof($column_list); $col<$n; $col++) {
                $lc_align = '';

                switch ($column_list[$col]) {
                    case 'PRODUCT_LIST_NAME':
                        $lc_text = '&nbsp;<a href="' . tep_href_link (FILENAME_COMPARISON, 'cPath=' . $cPath) . '">' . TEXT_LINK_PRODUCTS_COMPARISON . '</a>&nbsp;';
                        break;
                    case 'PRODUCT_LIST_MODEL':
                        if (PRODUCT_LIST_NAME == 0) {
                            $lc_text = '&nbsp;<a href="' . tep_href_link (FILENAME_COMPARISON, 'cPath=' . $cPath) . '">' . TEXT_LINK_PRODUCTS_COMPARISON . '</a>&nbsp;';
                        }
                        break;
                    case 'PRODUCT_LIST_IMAGE':
                        $lc_align = 'center';
                        $lc_text = '&nbsp;<a href="' . tep_href_link (FILENAME_COMPARISON, 'cPath=' . $cPath) . '">' . tep_template_image_button ('products_comparison.png', TEXT_LINK_PRODUCTS_COMPARISON, SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT) . '</a>&nbsp;';
                        break;
                    default:
                        $lc_text = '&nbsp;';
                        break;
                } // switch ($column_list


                $list_box_contents[0][] = array ('align' => $lc_align,
                    'params' => 'class="productListing-data"',
                    'text'  => $lc_text
                );
            } // for ($col=0
        } // if ( (SPECIFICATIONS_COMP_TABLE_ROW
// End products specifications

        $products = array();
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
        $has_products_attributes = tep_has_products_attributes($products_ids);
        $product_info_hrefs = tep_product_info_href_links($products_ids,($cPath ? 'cPath=' . $cPath:""));
        foreach ($products as $listing ) {
//---by iHolder skip zero quantity somewhere--
            $script_name=basename($_SERVER['PHP_SELF']);
            switch ($script_name){
                case FILENAME_ADVANCED_SEARCH_RESULT :
                case FILENAME_PRODUCTS_FILTERS : $do_skip=true; break;
                default: $do_skip=false;
            }
            if (isset($listing['products_quantity'])&&($listing['products_quantity']<=0)){
                if ($do_skip===true){continue;}
            }
//---by iHolder skip zero quantity somewhere--
            $rows++;
            if (($rows/2) == floor($rows/2)) {
                $list_box_contents[] = array('params' => 'class="productListing-even qview"');
            } else {
                $list_box_contents[] = array('params' => 'class="productListing-odd qview"');
            }
            $cur_row = sizeof($list_box_contents) - 1;
            for ($col=0, $n=sizeof($column_list); $col<$n; $col++) {
                $lc_align = '';
                switch ($column_list[$col]) {
                    case 'PRODUCT_LIST_MODEL':
                        $lc_align = '';
                        $lc_text = $listing['products_model'] == ''?'&nbsp;':$listing['products_model'];
                        break;
                    case 'PRODUCT_LIST_NAME':
                        $lc_align = '';

                        $extra_fields_text = '';
                        //TODO:ОТключаем, т.к. не используется
                        /*
                        $extra_fields_query = tep_db_query("
					SELECT pef.products_extra_fields_status as status, pef.products_extra_fields_name as name, ptf.products_extra_fields_value as value
					FROM ". TABLE_PRODUCTS_EXTRA_FIELDS ." pef
					LEFT JOIN  ". TABLE_PRODUCTS_TO_PRODUCTS_EXTRA_FIELDS ." ptf
					ON ptf.products_extra_fields_id=pef.products_extra_fields_id
					WHERE ptf.products_id=". (int) $listing['products_id'] ." and ptf.products_extra_fields_value<>'' and (pef.languages_id='0' or pef.languages_id='".$languages_id."')
					ORDER BY products_extra_fields_order");

                        while ($extra_fields = tep_db_fetch_array($extra_fields_query)) {
                            if (! $extra_fields['status'])
                                continue;
                            $extra_fields_text = $extra_fields_text.
                                '<br />'.$extra_fields['name'].': ' .
                                $extra_fields['value'];

                        }
                        */
                        $products_model='<span class="pmodel">Артикул: '.$listing['products_model'].'</span>';

                        if (isset($_GET['manufacturers_id']) && tep_not_null($_GET['manufacturers_id'])) {

                            $lc_text = '<a href="' . $product_info_hrefs[$listing['products_id']]. '"'.AddBlank().'>' . $listing['products_name'] . '</a><br>
                ' . $products_model.$listing['products_info'] . $extra_fields_text;
                        } else {
                            $lc_text = '<span class="productNam"><a href="' . $product_info_hrefs[$listing['products_id']] . '"'.AddBlank().'>' . $listing['products_name'] . '</a><br></span>
                ' . $products_model.$listing['products_info'] . $extra_fields_text;
                        }
                        break;
                    case 'PRODUCT_LIST_MANUFACTURER':
                        $lc_align = '';
                        $lc_text = $listing['manufacturers_name'] == ''?'&nbsp;':'<a href="' . tep_href_link(FILENAME_DEFAULT, 'manufacturers_id=' . $listing['manufacturers_id']) . '">' . $listing['manufacturers_name'] . '</a>';
                        break;
                    case 'PRODUCT_LIST_PRICE':
                        $lc_align = 'right';

                        //TotalB2B start
                        $listing['products_price'] = tep_quick_getproductprice($listing,$customer_price);
                        //TotalB2B end

                        //TotalB2B start
                        if (($new_price = tep_get_quick_products_special_price($listing,$has_sales)) and ($listing['manufacturers_id']<>50)) {
                            $listing['specials_new_products_price'] = $new_price;
//			  $query_special_prices_hide = tep_db_query("select configuration_value from " . TABLE_CONFIGURATION . " WHERE configuration_key = 'SPECIAL_PRICES_HIDE'");
//              $query_special_prices_hide_result = tep_db_fetch_array($query_special_prices_hide);
                            $query_special_prices_hide_result = SPECIAL_PRICES_HIDE;

                            if ($query_special_prices_hide_result == 'true') {
                                $lc_text = '&nbsp;&nbsp;<span class="productSpecialPrice">' . $currencies->display_price_nodiscount($listing['specials_new_products_price'], tep_get_tax_rate($listing['products_tax_class_id'])) . '</span>&nbsp;';
                            } else {
                                if ($listing['pq']>0){
                                    $lc_text = '&nbsp;<s>' .  $currencies->display_price_nodiscount($listing['products_price'], tep_get_tax_rate($listing['products_tax_class_id'])) . '</s>';
                                    $lc_text.='&nbsp;&nbsp;<span class="productSpecialPrice">' . $currencies->display_price_nodiscount($listing['specials_new_products_price'], tep_get_tax_rate($listing['products_tax_class_id'])) . '</span>&nbsp;';
                                }else{
                                    $lc_text = '&nbsp;' .  $currencies->display_price_nodiscount($listing['products_price'], tep_get_tax_rate($listing['products_tax_class_id'])) ;
                                }

                            }
                            //TotalB2B end

                        } else {
                            $lc_text = '&nbsp;' . $currencies->display_price($listing['products_price'], tep_get_tax_rate($listing['products_tax_class_id'])) . '&nbsp;';
                        }
                        break;
                    case 'PRODUCT_LIST_QUANTITY':
                        $lc_align = 'right';
                        $lc_text = $listing['products_quantity'] == ''?'&nbsp;':$listing['products_quantity'];
                        break;
                    case 'PRODUCT_LIST_WEIGHT':
                        $lc_align = 'right';
                        $lc_text = $listing['products_weight'] == ''?'&nbsp;':$listing['products_weight'];
                        break;
                    case 'PRODUCT_LIST_BUY_NOW':
                        $lc_align = 'center';
                        if (isset($tep_has_products_attributes[$listing['products_id']])) {
                            if (isset($_GET['manufacturers_id']) && tep_not_null($_GET['manufacturers_id'])) {
                                $lc_text = '<a  href="' . $product_info_hrefs[$listing['products_id']] . '"'.AddBlank().'>' . TEXT_MORE_INFO . '</a>';
                            } else {
                                $lc_text = '<a  href="' . $product_info_hrefs[$listing['products_id']] . '" '.AddBlank().'>' . TEXT_MORE_INFO . '</a>';
                            }
                        } else {

//---by iHolder. Verify quantity---
                            if ($listing['products_quantity']<9999){$lc_text='<p class="instore">В наличии</p>';}
                            else{$lc_text='<p class="instore">В наличии</p>';}
                            $lc_text .= tep_draw_form('cart_quantity', $product_info_hrefs[$listing['products_id']].'?action=add_product') . PRODUCTS_ORDER_QTY_TEXT . '<input type="text" class="input-class" name="cart_quantity" maxlength="4" size="4" value='. ($listing['quantity_order_min']) .'>' . (($listing['quantity_order_min']) > 1 ? PRODUCTS_ORDER_QTY_MIN_TEXT . ($listing['quantity_order_min']) : "") . ($listing['quantity_order_units'] > 1 ? PRODUCTS_ORDER_QTY_UNIT_TEXT . ($listing['quantity_order_units']) : "") . tep_draw_hidden_field('products_id', $listing['products_id']) . '<br>';

                            $lc_text.=tep_template_image_submit('button_in_cart.gif', IMAGE_BUTTON_IN_CART);

                            $lc_text.='<br><button type="button" class="btn_1click" >Купить в  1 клик</button>';
                             $lc_text.='</form>';
                            if (isset($listing['pq'])&&($listing['pq']==0)){
                                $lc_text=tep_image(DIR_WS_IMAGES.'nt_nw_tm.jpg');
                            }
//---by iHolder. Verify quantity---
                        }
                        break;
                    case 'PRODUCT_SORT_ORDER';
                        $lc_align = 'center';
                        $lc_text = $listing['products_sort_order'] == ''?'&nbsp;':$listing['products_sort_order'];
                        break;
                    case 'PRODUCT_LIST_IMAGE':
                        $lc_align = 'center';
                        if (isset($_GET['manufacturers_id']) && tep_not_null($_GET['manufacturers_id'])) {
                            $lc_text = '<a href="' . $product_info_hrefs[$listing['products_id']] . '" '.AddBlank().' class="qover"><figure class="hidecaption">' .
                                tep_image(STATIC_DOMAIN.DIR_WS_IMAGES . $listing['products_image'], $listing['products_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT,' id="prod_'.$listing['products_id'].'"') .
                                '<figcaption>'.$listing['products_name'].'</figcaption></figure><div>Быстрый просмотр</div>'.
                                '</a>';
                        } else {
                            $lc_text = '<a href="' . $product_info_hrefs[$listing['products_id']] . '" '.AddBlank().' class="qover"><figure class="hidecaption">' .
                                tep_image(STATIC_DOMAIN.DIR_WS_IMAGES . $listing['products_image'], $listing['products_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT,' id="prod_'.$listing['products_id'].'"') .
                                '<figcaption>'.$listing['products_name'].'</figcaption></figure><div>Быстрый просмотр</div>'.
                                '</a>';
                        }
                        break;
                }

                /* ORIGINAL 213 */
                $list_box_contents[$cur_row][] = array('align' => $lc_align,
                    'params' => 'class="productListing-data"',
                    'text'  => $lc_text);
                /* CDS Patch. 4. BOF
                          if ($list_box_contents[$cur_row][$column_list_order[$col]]['text'] != '')
                          {
                            $lc_text = $list_box_contents[$cur_row][$column_list_order[$col]]['text'] . '<br />' . $lc_text;
                          }
                //	$lc_text='<div class="qview">'.$lc_text.'</div>';
                          $list_box_contents[$cur_row][$column_list_order[$col]] = array('align' => $lc_align,
                                                                'params' => 'class="productListing-data"',
                                                                 'text'  => $lc_text);
                 CDS Patch. 4. EOF */
            }
        }

// Start products specifications
        if ( (SPECIFICATIONS_COMP_TABLE_ROW == 'bottom' || SPECIFICATIONS_COMP_TABLE_ROW == 'both') && $current_category_id != 0 && $show_comparison == true && tep_has_spec_group ($current_category_id, 'show_comparison') == true && basename ($PHP_SELF) == 'index.php') {
            $rows++;

            if (($rows/2) == floor($rows/2)) {
                $list_box_contents[] = array('params' => 'class="productListing-even"');
            } else {
                $list_box_contents[] = array('params' => 'class="productListing-odd"');
            }

            for ($col=0, $n=sizeof($column_list); $col<$n; $col++) {
                $lc_align = '';

                switch ($column_list[$col]) {
                    case 'PRODUCT_LIST_NAME':
                        $lc_text = '&nbsp;<a href="' . tep_href_link (FILENAME_COMPARISON, 'cPath=' . $cPath) . '">' . TEXT_LINK_PRODUCTS_COMPARISON . '</a>&nbsp;';
                        break;
                    case 'PRODUCT_LIST_MODEL':
                        if (PRODUCT_LIST_NAME == 0) {
                            $lc_text = '&nbsp;<a href="' . tep_href_link (FILENAME_COMPARISON, 'cPath=' . $cPath) . '">' . TEXT_LINK_PRODUCTS_COMPARISON . '</a>&nbsp;';
                        }
                        break;
                    case 'PRODUCT_LIST_IMAGE':
                        $lc_align = 'center';
                        $lc_text = '&nbsp;<a href="' . tep_href_link (FILENAME_COMPARISON, 'cPath=' . $cPath) . '">' . tep_template_image_button ('products_comparison.png', TEXT_LINK_PRODUCTS_COMPARISON, SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT) . '</a>&nbsp;';
                        break;
                    default:
                        $lc_text = '&nbsp;';
                        break;
                } // switch ($column_list
                $list_box_contents[$cur_row + 1][] = array ('align' => $lc_align,
                    'params' => 'class="productListing-data"',
                    'text'  => $lc_text
                );
            } // for ($col=0
        } // if ( (SPECIFICATIONS_COMP_TABLE_ROW
// End products specifications
        if ($LISTING_STYLE=='list'){
            new productListingBox($list_box_contents);
        }else{
            new productListingBoxFramed($list_box_contents);
        }
    } else {
        $list_box_contents = array();

        $list_box_contents[] = array('text' => TEXT_NO_PRODUCTS);
        new errorBox($list_box_contents);

    }

} elseif ($LISTING_STYLE == 'columns') {

    $info_box_contents = array();
    if ($listing_split->number_of_rows > 0) {
        $row = 0;
        $col = 0;
        //$listing_query = tep_db_query($listing_split->sql_query);
        $pos = 1;
        $products = array();

        $products_ids = array();
        $sale_category_query= array();


        $cPathArr= explode("_",$cPath);
        $cPathCatId= $cPathArr[count($cPathArr)-1];

        while ($listing = tep_db_fetch_array($listing_split->sql_query)) {
            $listing["categories_id"]=$cPathCatId;
            $products[] = $listing;
            $products_ids[] = $listing['products_id'];
            $sale_category_query[] = $listing['categories_id'];
        }
        //Проверяем, есть ли скидки в этой категории
        $sql= "select * from " . TABLE_SALEMAKER_SALES . " where sale_categories_all like '%," . implode(",%' OR sale_categories_all like '%,",$sale_category_query) . ",%' 
    and sale_status = '1' and (sale_date_start <= now() or sale_date_start = '0000-00-00') and 
    (sale_date_end >= now() or sale_date_end = '0000-00-00') ";


        $sale_query = tep_db_query($sql);
        $has_sales = false;
        if($sale_query->num_rows > 0){
            $has_sales = true;
        }
        $has_products_attributes = tep_has_products_attributes($products_ids);
        $product_info_hrefs = tep_product_info_href_links($products_ids,($cPath ? 'cPath=' . $cPath:""));
        foreach ($products as $listing ) {
            $listing['products_name'] = tep_get_products_name($listing['products_id']);
            if (PRODUCT_LIST_IMAGE > 0) {
                $lc_text = '<meta property="position" content="'.$pos.'"><div property="item" typeof="Product" >
<link href="'.$canonicalURL.'#'.$listing['products_id'].'" property="url">
<meta property="name" content="'.$listing['products_name'].'"/>
                <a href="' . $product_info_hrefs[$listing['products_id']] . '"'.AddBlank().' class="qover">'.

                    '<figure class="hidecaption">' .
                    tep_image(STATIC_DOMAIN.DIR_WS_IMAGES . $listing['products_image'], $listing['products_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT) .
                    '<figcaption>'.$listing['products_name'].'</figcaption></figure><div>Быстрый просмотр</div>'.
                    '  </a><br>';
            }
            $lc_text .= '<div property="offers" typeof="Offer">
<meta property="priceCurrency" content="RUB"/>
';
            if (PRODUCT_LIST_NAME > 0) {
                $lc_text .= '<span class="qva"><a href="' . $product_info_hrefs[$listing['products_id']] . '" '.AddBlank().'>' . $listing['products_name'] . '</a></span><br>';
            }

            if (PRODUCT_LIST_MODEL > 0) {
                $lc_text .= '<a href="' . $product_info_hrefs[$listing['products_id']] . '" '.AddBlank().'>' . $listing['products_model'] . '</a><br>';
            }

            if (PRODUCT_LIST_MANUFACTURER > 0) {
                $lc_text .= '<a href="' . tep_href_link(FILENAME_DEFAULT, 'manufacturers_id=' . $listing['manufacturers_id']) . '">' . $listing['manufacturers_name'] . '</a><br>';
            }

            if (PRODUCT_LIST_PRICE > 0) {

                //TotalB2B start
                $listing['products_price'] = tep_quick_getproductprice($listing,$customer_price);
                //TotalB2B end

                $new_price = tep_get_quick_products_special_price($listing,$has_sales);
                $listing['specials_new_products_price'] = $new_price;
                if ($sale_produst=tep_get_products_special_price($listing['products_id'])) {
                    $listing['specials_new_products_price']=$sale_produst;
                }
                $lc_text.='<span class="qvprice" property="price">';
                $price_tmp = (int)$listing['products_price'];
                if(empty($price_tmp)){
                    $price_match = 100;
                }else{
                    $price_match = 100 -  $listing['specials_new_products_price']/$listing['products_price']*100;
                }
                if (tep_not_null($listing['specials_new_products_price'])&&($listing['pq']>0)) {
                    $lc_text .= '<s>' .  $currencies->display_price_nodiscount(
                            $listing['products_price'],
                            tep_get_tax_rate($listing['products_tax_class_id'])) .
                        '</s>&nbsp;<span>(-'.
                        (int)($price_match)
                        .'%)</span>&nbsp;<span class="productSpecialPrice">' .
                        $currencies->display_price_nodiscount($listing['specials_new_products_price'],
                            tep_get_tax_rate($listing['products_tax_class_id'])) . '</span>';
                } else {
                    $lc_text .= '&nbsp;' . $currencies->display_price($listing['products_price'], tep_get_tax_rate($listing['products_tax_class_id'])) . '&nbsp;';
                }
                $lc_text.='</span>';
            }
            $products_model='<span class="pmodel">Артикул:&nbsp;'.$listing['products_model'].'</span>';
            $lc_text.='<br>'.$products_model;

            if (PRODUCT_LIST_BUY_NOW) {
                if ($listing['products_quantity']<9999)
                {
                    if (isset($listing['pq'])&&($listing['pq']>0)){
                        $lc_text.='<p class="instore">В наличии</p>
            <link property="availability" href="http://schema.org/InStock">';
                    }
                }
                else{$lc_text.='<p class="instore">В наличии</p>
            <link property="availability" href="http://schema.org/InStock">';}

                if (isset($listing['pq'])&&($listing['pq']>0)){
                    $c_qty=tep_get_products_quantity_order_min($listing['products_id']);
                    if ($c_qty>1){$lc_text.= '<span style="font-size:10px">'.PRODUCTS_ORDER_QTY_MIN_TEXT.$c_qty.'</span><br>';}
                    $lc_text .= '<br><a   href="' . tep_href_link(basename($PHP_SELF), tep_get_all_get_params(array('action', 'products_id','cart_quantity')) . 'action=buy_now&products_id=' . $listing['products_id'].'&cart_quantity='.$c_qty, 'NONSSL') . '">';
                    $lc_text.= tep_template_image_button('button_in_cart.gif', TEXT_BUY . $listing['products_name'] . TEXT_NOW) ; 
                    $lc_text.='<br><br><button class="btn_1click" >Купить в  1 клик</button>';
                     $lc_text.='</a>';
                }else{
                    $lc_text.='<br>'.tep_image(DIR_WS_IMAGES.'nt_nw_tm.jpg');
                    $lc_text .=' <link property="availability" href="http://schema.org/OutOfStock">';
                }
            }
            $lc_text .='</div></div>';
            $width = 100 / PRODUCT_LIST_COL_NUM;
//	$lc_text='<div class="qview">'.$lc_text.'</div>';
            $info_box_contents[$row][$col] = array('align' => 'center', 'params' => 'class="smallText qview" width="' . $width . '%" valign="top" property="itemListElement" typeof="ListItem"',
                'text' => $lc_text);

            $col ++;
            if ($col > PRODUCT_LIST_COL_NUM-1) {
                $col = 0;
                $row ++;
            }
            $pos++;
        }

        if ($LISTING_STYLE=='list'){
            new productListingBox($info_box_contents);
        }else{
            new productListingBoxFramed($info_box_contents);
        }

    } else {

        $info_box_contents = array();

        $info_box_contents[0] = array('params' => 'class="productListing-odd"');
        $info_box_contents[0][] = array('params' => 'class="productListing-data"',
            'text' => TEXT_NO_PRODUCTS);

        if ($LISTING_STYLE=='list'){
            new productListingBox($info_box_contents);
        }else{
            new productListingBoxFramed($info_box_contents);
        }

    }
}

if ( ($listing_split->number_of_rows > 0) && ( (PREV_NEXT_BAR_LOCATION == '1') || (PREV_NEXT_BAR_LOCATION == '3') ) ) {
    ?>
    <table class="table-padding-2">
        <tr>
            <td class="smallText"><?php echo $listing_split->display_count(TEXT_DISPLAY_NUMBER_OF_PRODUCTS); ?></td>
            <td class="smallText" align="right"><?php echo TEXT_RESULT_PAGE . ' ' . $listing_split->display_links(MAX_DISPLAY_PAGE_LINKS, tep_get_all_get_params(array('page', 'info', 'x', 'y'))); ?>
                <?php
                // BOF display_all_products
                if ($listing_split->number_of_rows<100){
                    if ($listing_split->number_of_pages > 1) {
                        ?>
                        <?php echo '<br><a href="' . tep_href_link(basename($PHP_SELF), tep_get_all_get_params(array('page', 'info', 'x', 'y')) . 'page=all', $request_type) . '" class="pageResults" title=" ' . TEXT_DISPLAY_ALL_PRODUCTS . ' ">' . TEXT_DISPLAY_ALL_PRODUCTS . '</a>'; ?>
                        <?php
                    } elseif ($_GET['page'] == 'all') {
                        ?>
                        <?php echo '<br><a href="' . tep_href_link(basename($PHP_SELF), tep_get_all_get_params(array('page', 'info', 'x', 'y')) . 'page=1', $request_type) . '" class="pageResults" title=" ' . TEXT_DISPLAY_BY_PAGES . ' ">' . TEXT_DISPLAY_BY_PAGES . '</a>'; ?>
                        <?php
                    }
                }
                // EOF display_all_products
                ?>
            </td>
        </tr>
    </table>
    <?php echo Display1Click('superfast.png');?>
    <?php
}
?>
<script type="text/javascript">
        
                        var clicable=false;
                        $('.btn_1click').click(function(){
                                    if(!clicable) {
                                                clicable=true;
                                            $(this).parents("form[name='cart_quantity']").submit();
                                            //$("form[name='cart_quantity']").submit();
                                        setTimeout(function(){
                                            $('.a_one_click').eq(0).click();
                                        },500);
                                    }
                                    

                        })
                        

                
                
           
       
    </script>
