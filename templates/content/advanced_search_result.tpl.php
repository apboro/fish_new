<table border="0" width="100%" cellspacing="0" cellpadding="<?php echo CELLPADDING_SUB; ?>">
    <?php
    // BOF: Lango Added for template MOD
    if (SHOW_HEADING_TITLE_ORIGINAL == 'yes') {
        $header_text = '&nbsp;'
//EOF: Lango Added for template MOD
        ?>
        <tr>
            <td><table class="table-padding-0">
                    <tr>
                        <td class="pageHeading"><?php echo HEADING_TITLE_2; ?> «<?php echo $_GET['keywords'] ?>»</td>
                        <td class="pageHeading" align="right"><?php echo tep_image(DIR_WS_TEMPLATES . TEMPLATE_NAME . '/images/content/browse.gif', HEADING_TITLE_2, HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?></td>
                    </tr>
                    <tr><td>Найдено в категориях: </td></tr>
                </table></td>
        </tr>
        <?php
        if ( ($error_cart_msg) ) {
            ?>
            <tr>
                <td align="right"><?php echo tep_output_warning($error_cart_msg); ?><br></td>
            </tr>
            <?php
        }
        $error_cart_msg='';
        ?>

        <?php
    }else{
        $header_text = HEADING_TITLE_2;
    }
    ?>
    <?php
    // BOF: Lango Added for template MOD
    if (MAIN_TABLE_BORDER == 'yes'){
        table_image_border_top(false, false, $header_text);
    }
    // EOF: Lango Added for template MOD
    ?>
    <tr>
        <td>
            <?php
            // create column list
            $define_list = array('PRODUCT_LIST_MODEL' => PRODUCT_LIST_MODEL,
                'PRODUCT_LIST_NAME' => PRODUCT_LIST_NAME,
                'PRODUCT_LIST_MANUFACTURER' => PRODUCT_LIST_MANUFACTURER,
                'PRODUCT_LIST_PRICE' => PRODUCT_LIST_PRICE,
                'PRODUCT_LIST_QUANTITY' => PRODUCT_LIST_QUANTITY,
                'PRODUCT_LIST_WEIGHT' => PRODUCT_LIST_WEIGHT,
                'PRODUCT_LIST_IMAGE' => PRODUCT_LIST_IMAGE,
                'PRODUCT_LIST_BUY_NOW' => PRODUCT_LIST_BUY_NOW);

            asort($define_list);

            $column_list_order = array();
            $order = 0;
            $order_group = -1;
            $value_old = 0;
            while (list($key, $value) = each($define_list)) {
                if ($value > 0)
                {
                    $column_list[$order] = $key;
                    if ($value_old != $value)
                    {
                        $value_old = $value;
                        $order_group++;
                    }
                    $column_list_order[$order] = $order_group;
                    $order++;
                }
            }

            $select_column_list = '';

            for ($i=0, $n=sizeof($column_list); $i<$n; $i++) {
                switch ($column_list[$i]) {
                    case 'PRODUCT_LIST_MODEL':
                        $select_column_list .= 'p.products_model, ';
                        break;
                    case 'PRODUCT_LIST_MANUFACTURER':
// BOF manufacturers descriptions
//        $select_column_list .= 'm.manufacturers_name, ';
                        $select_column_list .= 'mi.manufacturers_name, ';
// EOF manufacturers descriptions
                        break;
                    case 'PRODUCT_LIST_QUANTITY':
                        $select_column_list .= 'p.products_quantity, ';
                        break;
                    case 'PRODUCT_LIST_IMAGE':
                        $select_column_list .= 'p.products_image, ';
                        break;
                    case 'PRODUCT_LIST_WEIGHT':
                        $select_column_list .= 'p.products_weight, ';
                        break;
                }
            }

            // BOF manufacturers descriptions
            //  $select_str = "select distinct " . $select_column_list . " m.manufacturers_id, p.products_id, pd.products_name, p.products_price, p.products_tax_class_id, IF(s.status, s.specials_new_products_price, NULL) as specials_new_products_price, IF(s.status, s.specials_new_products_price, p.products_price) as final_price ";
            $select_str = "select SQL_CALC_FOUND_ROWS if (p.products_quantity>0,1,0) as pq,p.products_model, if (p.products_quantity>=9999,1,0) as ps, " .
                $select_column_list . " p.products_quantity,mi.manufacturers_id, p.products_id, pd.products_name, pd.products_info, 
      p.products_price, p.products_tax_class_id, IF(s.status, s.specials_new_products_price, NULL) as specials_new_products_price, 
      IF(s.status, s.specials_new_products_price, p.products_price) as final_price ";
            // EOF manufacturers descriptions

            $products_price_list = tep_xppp_getpricelist("");
            $select_product_order = " 
    ,if(p.products_quantity < 9999, 1, products_quantity_order_min)  as quantity_order_min,
    if(p.products_quantity < 9999, 1, products_quantity_order_units)  as quantity_order_units,
    p2c.categories_id as categories_id
    ";
            $select_str .= "$select_product_order";
            if ( (DISPLAY_PRICE_WITH_TAX == 'true') && (tep_not_null($pfrom) || tep_not_null($pto)) ) {
                $select_str .= ", SUM(tr.tax_rate) as tax_rate ";
            }

            // START: Extra Fields Contribution

            $inner_p2c = "FROM categories as c INNER JOIN ".TABLE_PRODUCTS_TO_CATEGORIES." as p2c  ON c.categories_status = '1' 
            AND p2c.categories_id = c.categories_id 
            INNER JOIN " . TABLE_PRODUCTS . " p ";

            $from_str_1 = "from " . TABLE_PRODUCTS . " p " ;
            $from_str_2 = " p.products_status = '1' AND  p.products_quantity > 0 AND  p.products_id = p2c.products_id 
  INNER JOIN " . TABLE_PRODUCTS_DESCRIPTION . " as pd
  ON p.products_id = pd.products_id and pd.language_id = '" . (int)$languages_id . "'
  left join  " . TABLE_PRODUCTS_TO_PRODUCTS_EXTRA_FIELDS . " p2pef on p.products_id = p2pef.products_id
  left join   " . TABLE_MANUFACTURERS_INFO . " mi on mi.manufacturers_id = p.manufacturers_id
  left join " . TABLE_SPECIALS . " s on p.products_id = s.products_id";
            $from_query = '';
            $from_str = '';
            // END: Extra Fields Contribution

            if ( (DISPLAY_PRICE_WITH_TAX == 'true') && (tep_not_null($pfrom) || tep_not_null($pto)) ) {
                if (!tep_session_is_registered('customer_country_id')) {
                    $customer_country_id = STORE_COUNTRY;
                    $customer_zone_id = STORE_ZONE;
                }
                $from_str .= " left join " . TABLE_TAX_RATES . " tr on p.products_tax_class_id = tr.tax_class_id left join " . TABLE_ZONES_TO_GEO_ZONES . " gz on tr.tax_zone_id = gz.geo_zone_id and (gz.zone_country_id is null or gz.zone_country_id = '0' or gz.zone_country_id = '" . (int)$customer_country_id . "') and (gz.zone_id is null or gz.zone_id = '0' or gz.zone_id = '" . (int)$customer_zone_id . "')";

            }

            // BOF Enable - Disable Categories Contribution--------------------------------------
            $where_str = " WHERE true";
            // EOF Enable - Disable Categories Contribution--------------------------------------



            if (isset($_GET['categories_id']) && tep_not_null($_GET['categories_id'])) {
                if (isset($_GET['inc_subcat']) && ($_GET['inc_subcat'] == '1')) {
                    $subcategories_array = array();
                    tep_get_subcategories($subcategories_array, $_GET['categories_id']);

                    $where_str .= " and p2c.products_id = p.products_id and p2c.products_id = pd.products_id and (p2c.categories_id = '" . (int)$_GET['categories_id'] . "'";

                    for ($i=0, $n=sizeof($subcategories_array); $i<$n; $i++ ) {
                        $where_str .= " or p2c.categories_id = '" . (int)$subcategories_array[$i] . "'";
                    }

                    $where_str .= ")";
                } else {
                    $where_str .= " and p2c.products_id = p.products_id and p2c.products_id = pd.products_id and pd.language_id = '" . (int)$languages_id . "' and p2c.categories_id = '" . (int)$_GET['categories_id'] . "'";
                }
            }

            if (isset($_GET['manufacturers_id']) && tep_not_null($_GET['manufacturers_id'])) {
// BOF manufacturers descriptions
//    $where_str .= " and m.manufacturers_id = '" . (int)$_GET['manufacturers_id'] . "'";
                $where_str .= " and mi.manufacturers_id = '" . (int)$_GET['manufacturers_id'] . "'";
// EOF manufacturers descriptions
            }

            if (isset($search_keywords) && (sizeof($search_keywords) > 0)) {
                $where_str .= " and (";
                for ($i=0, $n=sizeof($search_keywords); $i<$n; $i++ ) {
                    switch ($search_keywords[$i]) {
                        case '(':
                        case ')':
                        case 'and':
                        case 'or':
                            $where_str .= " " . $search_keywords[$i] . " ";
                            break;
                        default:
                            $keyword = tep_db_prepare_input($search_keywords[$i]);
// BOF manufacturers descriptions
//          $where_str .= "(pd.products_name like '%" . tep_db_input($keyword) . "%' or p.products_model like '%" . tep_db_input($keyword) . "%' or m.manufacturers_name like '%" . tep_db_input($keyword) . "%'";
                            $where_str .= "(pd.products_name like '%" . tep_db_input($keyword) . "%' or p.products_model like '%" . tep_db_input($keyword) . "%' or mi.manufacturers_name like '%" . tep_db_input($keyword) . "%' or p2pef.products_extra_fields_value like '%" . tep_db_input($keyword) . "%'";
// EOF manufacturers descriptions
                            if (isset($_GET['search_in_description']) && ($_GET['search_in_description'] == '1')) $where_str .= " or pd.products_description like '%" . tep_db_input($keyword) . "%'";
                            if (isset($_GET['search_in_description']) && ($_GET['search_in_description'] == '1')) $where_str .= " or pd.products_info like '%" . tep_db_input($keyword) . "%'";
                            $where_str .= ')';
                            break;
                    }
                }
                $where_str .= " )";
            }
            if (tep_not_null($dfrom)) {
                $where_str .= " and p.products_date_added >= '" . tep_date_raw($dfrom) . "'";
            }

            if (tep_not_null($dto)) {
                $where_str .= " and p.products_date_added <= '" . tep_date_raw($dto) . "'";
            }

            if (tep_not_null($pfrom)) {
                if ($currencies->is_set($currency)) {
                    $rate = $currencies->get_value($currency);

                    $pfrom = $pfrom / $rate;
                }
            }

            if (tep_not_null($pto)) {
                if (isset($rate)) {
                    $pto = $pto / $rate;
                }
            }

            if (DISPLAY_PRICE_WITH_TAX == 'true') {
                if ($pfrom > 0) $where_str .= " and (IF(s.status, s.specials_new_products_price, p.products_price) * if(gz.geo_zone_id is null, 1, 1 + (tr.tax_rate / 100) ) >= " . (double)$pfrom . ")";
                if ($pto > 0) $where_str .= " and (IF(s.status, s.specials_new_products_price, p.products_price) * if(gz.geo_zone_id is null, 1, 1 + (tr.tax_rate / 100) ) <= " . (double)$pto . ")";
            } else {
                if ($pfrom > 0) $where_str .= " and (IF(s.status, s.specials_new_products_price, p.products_price) >= " . (double)$pfrom . ")";
                if ($pto > 0) $where_str .= " and (IF(s.status, s.specials_new_products_price, p.products_price) <= " . (double)$pto . ")";
            }
            /*iHolder disable from search zero count products*/
            $where_str.=' and p.products_quantity>0 ';
            /*iHolder disable from search zero count products*/
            //TotalB2B start
            $where_str .=  " group by p.products_id";
            if ( (DISPLAY_PRICE_WITH_TAX == 'true') && (tep_not_null($pfrom) || tep_not_null($pto)) ) {
                $where_str .= ", tr.tax_priority";
            }
            //TotalB2B end

            //  if ( (DISPLAY_PRICE_WITH_TAX == 'true') && (tep_not_null($pfrom) || tep_not_null($pto)) ) {
            //    $where_str .= " group by p.products_id, tr.tax_priority";
            //  }

            if ( (!isset($_GET['sort'])) || (!preg_match('/[1-8][ad]/', $_GET['sort'])) || (substr($_GET['sort'], 0, 1) > sizeof($column_list)) ) {
                for ($i=0, $n=sizeof($column_list); $i<$n; $i++) {
                    if ($column_list[$i] == 'PRODUCT_LIST_NAME') {
                        $_GET['sort'] = $i+1 . 'a';
                        /*        $order_str = ' order by pd.products_name';*/
                        $order_str = ' order by pq desc,ps asc,p.products_price asc ';
                        break;
                    }
                }
            } else {
                $sort_col = substr($_GET['sort'], 0 , 1);
                $sort_order = substr($_GET['sort'], 1);
                $order_str = ' order by ';
                switch ($column_list[$sort_col-1]) {
                    case 'PRODUCT_LIST_MODEL':
                        $order_str .= "p.products_model " . ($sort_order == 'd' ? "desc" : "") . ", pd.products_name";
                        break;
                    case 'PRODUCT_LIST_NAME':
                        $order_str .= "pd.products_name " . ($sort_order == 'd' ? "desc" : "");
                        break;
                    case 'PRODUCT_LIST_MANUFACTURER':
// BOF manufacturers descriptions
//        $order_str .= "m.manufacturers_name " . ($sort_order == 'd' ? "desc" : "") . ", pd.products_name";
                        $order_str .= "mi.manufacturers_name " . ($sort_order == 'd' ? "desc" : "") . ", pd.products_name";
// EOF manufacturers descriptions
                        break;
                    case 'PRODUCT_LIST_QUANTITY':
                        $order_str .= "p.products_quantity " . ($sort_order == 'd' ? "desc" : "") . ", pd.products_name";
                        break;
                    case 'PRODUCT_LIST_IMAGE':
                        $order_str .= "pd.products_name";
                        break;
                    case 'PRODUCT_LIST_WEIGHT':
                        $order_str .= "p.products_weight " . ($sort_order == 'd' ? "desc" : "") . ", pd.products_name";
                        break;
                    case 'PRODUCT_LIST_PRICE':
                        $order_str .= "final_price " . ($sort_order == 'd' ? "desc" : "") . ", pd.products_name";
                        break;
                }
            }
            $from_str_1 = "from " . TABLE_PRODUCTS . " p " ;
            $from_query = "".$inner_p2c." ON  ".$from_str_2.$from_str;

            $categories_sql = "SELECT straight_join p2c.categories_id " . $from_query . str_replace("group by p.products_id" ,"group by p2c.categories_id",$where_str);

            if (isset($categories_sql)) {
                $category_ids = array();
                $query = tep_db_query($categories_sql);
                while ($cat = tep_db_fetch_array($query)) {
                    $category_ids[] = $cat['categories_id'];
                }
                if (!empty($category_ids)) {
                    $categories = tep_db_query("SELECT categories_heading_title as name,categories_id FROM `categories_description` where categories_id in (SELECT parent_id FROM `categories` where categories_id in (" . implode(',', $category_ids) . "));");
                    echo "<div id='found-in-category'>";
                    $show_block = array();
                    while ($category_in = tep_db_fetch_array($categories)) {
                        $show_block[] = '<a target="_blank" href="' . tep_href_link(FILENAME_ADVANCED_SEARCH_RESULT, tep_get_all_get_params() . 'categories_id=' . $category_in['categories_id'] . '&inc_subcat=1', 'NOSSL') . '" >' . $category_in['name'] . '</a>';
                    }
                    echo implode(', ', $show_block);
                    echo "</div>";
                }
            }
            $from_query = $from_str_1." INNER JOIN  products_to_categories as p2c on p2c.categories_id IN (".implode(',',$category_ids).") AND ".$from_str_2.$from_str;
            $listing_sql = $select_str . $from_query . $where_str . $order_str;
            //echo $listing_sql;exit;
			$kk=$_GET['keywords'];
			$listing_split = new splitPageResults($listing_sql, 100, 'p.products_id');
			
			//starch with yandex яндекс
			if  ($listing_split->number_of_rows <= 0)
			{
				header('Location: https://yourfish.ru/results.php');
				
              echo '<meta http-equiv="refresh" content="0;URL=https://yourfish.ru/results.php?searchid=2542863&text='. $kk . '&web=0" >';
			}
			
			
            require(DIR_WS_MODULES . FILENAME_PRODUCT_LISTING_COL);


            ?>
        </td>
    </tr>
    <?php
    // BOF: Lango Added for template MOD
    if (MAIN_TABLE_BORDER == 'yes'){
        table_image_border_bottom();
    }
    // EOF: Lango Added for template MOD
    ?>
    <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
    </tr>
    <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
    </tr>
    <tr>
        <td class="main"><?php echo '<a href="' . tep_href_link(FILENAME_ADVANCED_SEARCH, tep_get_all_get_params(array('sort', 'page')), 'NONSSL', true, false) . '">' . tep_template_image_button('button_back.gif', IMAGE_BUTTON_BACK) . '</a>'; ?></td>
    </tr>
</table>