
<?php if (TABLE_HEADING_IMAGE=='TABLE_HEADING_IMAGE'){
   define('TABLE_HEADING_IMAGE', 'Товары');
   define('TABLE_HEADING_MODEL', 'Код');
   define('TABLE_HEADING_PRODUCTS', 'Название товара');
   define('TABLE_HEADING_MANUFACTURER', 'Производитель');
   define('TABLE_HEADING_QUANTITY', 'Количество');
   define('TABLE_HEADING_PRICE', 'Цена');
   define('TABLE_HEADING_WEIGHT', 'Вес');
   define('TABLE_HEADING_BUY_NOW', 'Купить');
 }?>
<table width="100%">
<tr><td>
<?php
$ccisuffix=' = '.(int)$current_category_id;
if ((int)$current_category_id>0){
    $ccisuffix=' in('.implode(GetAllSubCat((int)$current_category_id),',').','.(int)$current_category_id.')';
}
// create column list
    $define_list = array('PRODUCT_LIST_MODEL' => PRODUCT_LIST_MODEL,
                         'PRODUCT_LIST_NAME' => PRODUCT_LIST_NAME,
                         'PRODUCT_LIST_MANUFACTURER' => PRODUCT_LIST_MANUFACTURER,
                         'PRODUCT_LIST_PRICE' => PRODUCT_LIST_PRICE,
                         'PRODUCT_LIST_QUANTITY' => PRODUCT_LIST_QUANTITY,
                         'PRODUCT_LIST_WEIGHT' => PRODUCT_LIST_WEIGHT,
                         'PRODUCT_LIST_IMAGE' => PRODUCT_LIST_IMAGE,
                   	    'PRODUCT_LIST_BUY_NOW' => PRODUCT_LIST_BUY_NOW,
	                      'PRODUCT_SORT_ORDER' => PRODUCT_SORT_ORDER);

    asort($define_list);
    $column_list = array();
    reset($define_list);
/* CDS Patch. 4. OF */
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
/* CDS Patch. 4. EOF */

    $select_column_list = '';
    $select_column_list .= 'p.products_model, ';
    for ($i=0, $n=sizeof($column_list); $i<$n; $i++) {
      switch ($column_list[$i]) {
        case 'PRODUCT_LIST_MODEL':
          $select_column_list .= 'p.products_model, ';
          break;
        case 'PRODUCT_LIST_NAME':
          $select_column_list .= 'pd.products_name, ';
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
        case 'PRODUCT_SORT_ORDER':
          $select_column_list .= 'p.products_sort_order, ';
          break;
		//TotalB2B start
		//this is a know bug
	case 'PRODUCT_LIST_PRICE':
          $listing_sql .= "p.products_price " . ($sort_order == 'd' ? 'desc' : '') . ", pd.products_name";
          break;
		//TotalB2B end


      }
    }
//---iHolder Add quantity to selection--
$select_column_list.=' if (p.products_quantity>0,1,0) as pq ,products_quantity, if (p.products_quantity>=9999,1,0) as ps,';
//---Add quantity to selection--
// show the products of a specified manufacturer

    $products_price_list = tep_xppp_getpricelist("");
    $select_product_order = " 
    if(p.products_quantity < 9999, 1, products_quantity_order_min)  as quantity_order_min,
    if(p.products_quantity < 9999, 1, products_quantity_order_units)  as quantity_order_units,
    p2c.categories_id as categories_id,
    pd.products_info,
    {$products_price_list}
    ";
    if (isset($_GET['manufacturers_id'])) {
      if (isset($_GET['filter_id']) && tep_not_null($_GET['filter_id'])) {
// We are asked to show only a specific category
// BOF manufacturers descriptions
//      $listing_sql = "select " . $select_column_list . " p.products_id, p.manufacturers_id, p.products_price, p.products_sort_order, p.products_tax_class_id, IF(s.status, s.specials_new_products_price, NULL) as specials_new_products_price, IF(s.status, s.specials_new_products_price, p.products_price) as final_price from " . TABLE_PRODUCTS . " p left join " . TABLE_SPECIALS . " s on p.products_id = s.products_id, " . TABLE_PRODUCTS_DESCRIPTION . " pd, " . TABLE_MANUFACTURERS . " m, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c where p.products_status = '1' and p.manufacturers_id = m.manufacturers_id and m.manufacturers_id = '" . (int)$_GET['manufacturers_id'] . "' and p.products_id = p2c.products_id and pd.products_id = p2c.products_id and pd.language_id = '" . (int)$languages_id . "' and p2c.categories_id = '" . (int)$_GET['filter_id'] . "'";
        $listing_sql = "select SQL_CALC_FOUND_ROWS " . $select_column_list . " p.products_id, $select_product_order, p.manufacturers_id, p.products_price, p.products_sort_order, p.products_tax_class_id, IF(s.status, s.specials_new_products_price, NULL) as specials_new_products_price, IF(s.status, s.specials_new_products_price, p.products_price) as final_price from " . TABLE_PRODUCTS . " p left join " . TABLE_SPECIALS . " s on p.products_id = s.products_id, " . TABLE_PRODUCTS_DESCRIPTION . " pd, " . TABLE_MANUFACTURERS_INFO . " mi, (SELECT * FROM ".TABLE_PRODUCTS_TO_CATEGORIES." group by products_id) p2c,".TABLE_CATEGORIES." c where p.products_status = '1' and c.categories_id=p2c.categories_id and c.categories_status=1 and p.manufacturers_id = mi.manufacturers_id and mi.manufacturers_id = '" . (int)$_GET['manufacturers_id'] . "' and mi.languages_id = '" . (int)$languages_id . "' and p.products_id = p2c.products_id and pd.products_id = p2c.products_id and pd.language_id = '" . (int)$languages_id . "' and p2c.categories_id = '" . (int)$_GET['filter_id'] . "'";
// EOF manufacturers descriptions
      } else {
// We show them all
// BOF manufacturers descriptions
//      $listing_sql = "select " . $select_column_list . " p.products_id, p.manufacturers_id, p.products_price, p.products_sort_order, p.products_tax_class_id, IF(s.status, s.specials_new_products_price, NULL) as specials_new_products_price, IF(s.status, s.specials_new_products_price, p.products_price) as final_price from " . TABLE_PRODUCTS . " p left join " . TABLE_SPECIALS . " s on p.products_id = s.products_id, " . TABLE_PRODUCTS_DESCRIPTION . " pd, " . TABLE_MANUFACTURERS . " m where p.products_status = '1' and pd.products_id = p.products_id and pd.language_id = '" . (int)$languages_id . "' and p.manufacturers_id = m.manufacturers_id and m.manufacturers_id = '" . (int)$_GET['manufacturers_id'] . "'";
        $listing_sql = "select SQL_CALC_FOUND_ROWS " . $select_column_list . " p.products_id, $select_product_order, p.manufacturers_id, p.products_price, p.products_sort_order, p.products_tax_class_id, IF(s.status, s.specials_new_products_price, NULL) as specials_new_products_price, IF(s.status, s.specials_new_products_price, p.products_price) as final_price from " . TABLE_PRODUCTS . " p left join " . TABLE_SPECIALS . " s on p.products_id = s.products_id, " . TABLE_PRODUCTS_DESCRIPTION . " pd, " . TABLE_MANUFACTURERS_INFO . " mi where p.products_status = '1' and pd.products_id = p.products_id and pd.language_id = '" . (int)$languages_id . "' and p.manufacturers_id = mi.manufacturers_id and mi.manufacturers_id = '" . (int)$_GET['manufacturers_id'] . "' and mi.languages_id = '" . (int)$languages_id . "'";
// EOF manufacturers descriptions
      }
    } else {
// show the products in a given categorie
      if (isset($_GET['filter_id']) && tep_not_null($_GET['filter_id'])) {
// We are asked to show only specific catgeory
// BOF manufacturers descriptions
//      $listing_sql = "select " . $select_column_list . " p.products_id, p.manufacturers_id, p.products_price, p.products_sort_order, p.products_tax_class_id, IF(s.status, s.specials_new_products_price, NULL) as specials_new_products_price, IF(s.status, s.specials_new_products_price, p.products_price) as final_price from " . TABLE_PRODUCTS . " p left join " . TABLE_SPECIALS . " s on p.products_id = s.products_id, " . TABLE_PRODUCTS_DESCRIPTION . " pd, " . TABLE_MANUFACTURERS . " m, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c where p.products_status = '1' and p.manufacturers_id = m.manufacturers_id and m.manufacturers_id = '" . (int)$_GET['filter_id'] . "' and p.products_id = p2c.products_id and pd.products_id = p2c.products_id and pd.language_id = '" . (int)$languages_id . "' and p2c.categories_id = '" . (int)$current_category_id . "'";
        $listing_sql = "select SQL_CALC_FOUND_ROWS " . $select_column_list . " p.products_id, $select_product_order, p.manufacturers_id, p.products_price, p.products_sort_order, p.products_tax_class_id, IF(s.status, s.specials_new_products_price, NULL) as specials_new_products_price, IF(s.status, s.specials_new_products_price, p.products_price) as final_price from " . TABLE_PRODUCTS . " p left join " . TABLE_SPECIALS . " s on p.products_id = s.products_id, " . TABLE_PRODUCTS_DESCRIPTION . " pd, " . TABLE_MANUFACTURERS_INFO . " mi, (SELECT * FROM ".TABLE_PRODUCTS_TO_CATEGORIES." WHERE categories_id ".$ccisuffix." group by products_id) p2c, ".TABLE_CATEGORIES." c where p.products_status = '1' and c.categories_id=p2c.categories_id and c.categories_status=1 and p.manufacturers_id = mi.manufacturers_id and mi.manufacturers_id = '" . (int)$_GET['filter_id'] . "' and mi.languages_id = '" . (int)$languages_id . "' and p.products_id = p2c.products_id and pd.products_id = p2c.products_id and pd.language_id = '" . (int)$languages_id . "' and p2c.categories_id " . $ccisuffix;
// EOF manufacturers descriptions
      } else {
// We show them all
// BOF manufacturers descriptions
//      $listing_sql = "select " . $select_column_list . " p.products_id, p.manufacturers_id, p.products_price, p.products_sort_order, p.products_tax_class_id, IF(s.status, s.specials_new_products_price, NULL) as specials_new_products_price, IF(s.status, s.specials_new_products_price, p.products_price) as final_price from " . TABLE_PRODUCTS_DESCRIPTION . " pd, " . TABLE_PRODUCTS . " p left join " . TABLE_MANUFACTURERS . " m on p.manufacturers_id = m.manufacturers_id left join " . TABLE_SPECIALS . " s on p.products_id = s.products_id, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c where p.products_status = '1' and p.products_id = p2c.products_id and pd.products_id = p2c.products_id and pd.language_id = '" . (int)$languages_id . "' and p2c.categories_id = '" . (int)$current_category_id . "'";
        $listing_sql = "select SQL_CALC_FOUND_ROWS " . $select_column_list . " p.products_id, $select_product_order, p.manufacturers_id, p.products_price, p.products_sort_order, p.products_tax_class_id, IF(s.status, s.specials_new_products_price, NULL) as specials_new_products_price, IF(s.status, s.specials_new_products_price, p.products_price) as final_price from " . TABLE_PRODUCTS_DESCRIPTION . " pd, " . TABLE_PRODUCTS . " p left join " . TABLE_MANUFACTURERS_INFO . " mi on (p.manufacturers_id = mi.manufacturers_id and mi.languages_id = '" . (int)$languages_id . "') left join " . TABLE_SPECIALS . " s on p.products_id = s.products_id, (SELECT * FROM ".TABLE_PRODUCTS_TO_CATEGORIES." WHERE categories_id ".$ccisuffix." group by products_id) p2c,".TABLE_CATEGORIES." c where p.products_status = '1' and c.categories_id=p2c.categories_id and c.categories_status=1 and p.products_id = p2c.products_id and pd.products_id = p2c.products_id and pd.language_id = '" . (int)$languages_id . "' and p2c.categories_id " .$ccisuffix;
// EOF manufacturers descriptions
      }
    }
    //TotalB2B end
    if ( (!isset($_GET['sort'])) || (!preg_match('/[1-8][ad]/', $_GET['sort'])) || (substr($_GET['sort'], 0, 1) > sizeof($column_list)) ) {
      for ($i=0, $n=sizeof($column_list); $i<$n; $i++) {
        if ($column_list[$i] == 'PRODUCT_LIST_NAME') {
//          $_GET['sort'] = $i+1 . 'a';
//          $listing_sql .= " order by pd.products_name";
//Product sort order
            $_GET['sort'] = 'products_sort_order';
//	    $listing_sql .= " order by pq desc,p.products_sort_order, pd.products_name asc";
//--iHolder set default sort order with price first
//	    $listing_sql .= " order by pq desc,p.products_price,p.products_sort_order, pd.products_name asc";
//	    $listing_sql .= " order by pq desc,p.products_sort_order, pd.products_name asc";
	    $listing_sql .= " order by pq desc,ps asc, p.products_price asc";
          break;
        }
      }
    } else {
      $sort_col = substr($_GET['sort'], 0 , 1);
      $sort_order = substr($_GET['sort'], 1);
        switch ($column_list[$sort_col-1]) {
            case 'PRODUCT_LIST_MODEL':
                $listing_sql .= " order by pq desc,p.products_model " . ($sort_order == 'd' ? 'desc' : '') . ", pd.products_name";
                break;
            case 'PRODUCT_LIST_NAME':
                $listing_sql .= " order by pq desc,pd.products_name " . ($sort_order == 'd' ? 'desc' : '');
                break;
            case 'PRODUCT_LIST_MANUFACTURER':
// BOF manufacturers descriptions
//        $listing_sql .= "m.manufacturers_name " . ($sort_order == 'd' ? 'desc' : '') . ", pd.products_name";
                $listing_sql .= "order by pq desc,mi.manufacturers_name " . ($sort_order == 'd' ? 'desc' : '');
// EOF manufacturers descriptions
                break;
            case 'PRODUCT_LIST_QUANTITY':
                $listing_sql .= " order by pq desc,p.products_quantity " . ($sort_order == 'd' ? 'desc' : '') . ", pd.products_name";
                break;
            case 'PRODUCT_LIST_IMAGE':
                $listing_sql .= " order by pq desc,pd.products_name";
                break;
            case 'PRODUCT_LIST_WEIGHT':
                $listing_sql .= " order by pq desc,p.products_weight " . ($sort_order == 'd' ? 'desc' : '') . ", pd.products_name";
                break;
            case 'PRODUCT_LIST_PRICE':
                $listing_sql .= " order by pq desc,final_price " . ($sort_order == 'd' ? 'desc' : '') . ", pd.products_name";
                break;
            case 'PRODUCT_SORT_ORDER':
                $listing_sql .= " order by pq desc,p.products_sort_order " . ($sort_order == 'd' ? "desc" : '') . ", pd.products_name";
                break;
            default:
                $listing_sql .= " order by pq desc,p.products_sort_order, pd.products_name asc";
                break;
        }
    }
//echo $listing_sql;exit;
include(DIR_WS_MODULES . FILENAME_PRODUCT_LISTING_COL); ?>
</td></tr></table>