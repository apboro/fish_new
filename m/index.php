<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2013 osCommerce

  Released under the GNU General Public License
*/
//  define('MAX_DISPLAY_CATEGORIES_PER_ROW_MOB',2);
require('includes/application_top.php');
// the following cPath references come from application_top.php
$category_depth = 'top';
$nested_cids=GetAllSubCat((int)$current_category_id);

if (isset($cPath) && tep_not_null($cPath)) {
    $cpq= "select count(*) as total from " . TABLE_PRODUCTS_TO_CATEGORIES . " where categories_id ";
    if (sizeof($nested_cids)>0){
        $cpq.=" in (".implode($nested_cids,',').")";
    }else{$cpq.= " = '" . (int)$current_category_id . "'";}
    $categories_products_query = tep_db_query($cpq);
    $categories_products = tep_db_fetch_array($categories_products_query);
    if ($categories_products['total'] > 0) {
        $category_depth = 'products'; // display products
    } else {
        $category_parent_query = tep_db_query("select count(*) as total from " . TABLE_CATEGORIES . " where parent_id = '" . (int)$current_category_id . "'");
        $category_parent = tep_db_fetch_array($category_parent_query);
        if ($category_parent['total'] > 0) {
            $category_depth = 'nested'; // navigate through the categories
        } else {
            $category_depth = 'products'; // category has no products, but display the 'no products' message
        }
    }
}
require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_DEFAULT);
require(DIR_WS_INCLUDES . 'template_top.php');
if ($category_depth == 'nested') {
    $category_query = tep_db_query("select cd.categories_name, c.categories_image from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd where c.categories_id = '" . (int)$current_category_id . "' and cd.categories_id = '" . (int)$current_category_id . "' and cd.language_id = '" . (int)$languages_id . "'");
    $category = tep_db_fetch_array($category_query);
    ?>
    <div class="contentContainer" id="">
        <h1><?php echo $category['categories_name']; ?></h1>
        <?php /* ?>
  		<div class="contentText">
    <table border="0" width="100%" cellspacing="10" cellpadding="1">
      <tr>
<?php     */ ?>
        <?php
        /*    if (isset($cPath) && strpos('_', $cPath)) {
        // check to see if there are deeper categories within the current category
              $category_links = array_reverse($cPath_array);
              for($i=0, $n=sizeof($category_links); $i<$n; $i++) {
                $categories_query = tep_db_query("select count(*) as total from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd where c.parent_id = '" . (int)$category_links[$i] . "' and c.categories_id = cd.categories_id and cd.language_id = '" . (int)$languages_id . "'");
                $categories = tep_db_fetch_array($categories_query);
                if ($categories['total'] < 1) {
                  // do nothing, go through the loop
                } else {
                  $categories_query = tep_db_query("select c.categories_id, cd.categories_name, c.categories_image, c.parent_id from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd where c.parent_id = '" . (int)$category_links[$i] . "' and c.categories_id = cd.categories_id and cd.language_id = '" . (int)$languages_id . "' order by sort_order, cd.categories_name");
                  break; // we've found the deepest category the customer is in
                }
              }
            } else {
              $categories_query = tep_db_query("select c.categories_id, cd.categories_name, c.categories_image, c.parent_id from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd where c.parent_id = '" . (int)$current_category_id . "' and c.categories_id = cd.categories_id and cd.language_id = '" . (int)$languages_id . "' order by sort_order, cd.categories_name");
            }

            $number_of_categories = tep_db_num_rows($categories_query);

            $rows = 0;
        echo '<div class="CLB">';
            while ($categories = tep_db_fetch_array($categories_query)) {
              $rows++;
              $cPath_new = tep_get_path($categories['categories_id']);
              $width = (int)(100 / MAX_DISPLAY_CATEGORIES_PER_ROW_MOB) . '%';
              echo '<div class="categoryListBoxContents"><div class="subproduct_name"><a href="' . tep_href_link(FILENAME_DEFAULT, $cPath_new) . '">' . tep_image(DIR_WS_IMAGES . $categories['categories_image'], $categories['categories_name'], SUBCATEGORY_IMAGE_WIDTH, SUBCATEGORY_IMAGE_HEIGHT) . '<br />' . $categories['categories_name'] . '</a></div></div>';
        //      echo '<div class="categoryListBoxContents"><div class="subproduct_name"><a href="' . tep_href_link(FILENAME_DEFAULT, $cPath_new) . '">' . tep_image(DIR_WS_IMAGES . $categories['categories_image'], $categories['categories_name'], 100, 100) . '<br />' . $categories['categories_name'] . '</a></div></div>';
            }
        echo '</div>';*/
        require(DIR_WS_MODULES.FILENAME_CATEGORY_LISTING);
        // needed for the new products module shown below
        ?>
        <?php /*     ?> </tr>
    </table>
<?php */ ?>
        <br />
        <?php
        $new_products_category_id = $current_category_id;
        //include(DIR_WS_MODULES . FILENAME_NEW_PRODUCTS);
        ?>

    </div>
    </div>

    <?php
} elseif ($category_depth == 'products' || $category_depth=='neverset'|| (isset($HTTP_GET_VARS['manufacturers_id']) && !empty($HTTP_GET_VARS['manufacturers_id']))) {
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

    $column_list = array();
    reset($define_list);
    while (list($key, $value) = each($define_list)) {
        if ($value > 0) $column_list[] = $key;
    }

    $select_column_list = '';

    for ($i=0, $n=sizeof($column_list); $i<$n; $i++) {
        switch ($column_list[$i]) {
            case 'PRODUCT_LIST_MODEL':
                $select_column_list .= 'p.products_model, ';
                break;
            case 'PRODUCT_LIST_NAME':
                $select_column_list .= 'pd.products_name, ';
                break;
            case 'PRODUCT_LIST_MANUFACTURER':
                $select_column_list .= 'm.manufacturers_name, ';
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

    $products_price_list = tep_xppp_getpricelist("");
    $select_product_order = "      if(p.products_quantity < 9999, 1, products_quantity_order_min)  as quantity_order_min,
    if(p.products_quantity < 9999, 1, products_quantity_order_units)  as quantity_order_units,
    p2c.categories_id as categories_id,
    pd.products_info
    ";

    $select_column_list.=' p.products_quantity,if (p.products_quantity>0,1,0) as pq , if (p.products_quantity>=9999,1,0) as ps, pd.products_description , ';
// show the products of a specified manufacturer
    if (isset($HTTP_GET_VARS['manufacturers_id']) && !empty($HTTP_GET_VARS['manufacturers_id'])) {
        if (isset($HTTP_GET_VARS['filter_id']) && tep_not_null($HTTP_GET_VARS['filter_id'])) {
// We are asked to show only a specific category
            $listing_sql = "select SQL_CALC_FOUND_ROWS " . $select_column_list . " p.products_id, ".$select_product_order.", p.manufacturers_id, p.products_price, p.products_tax_class_id, IF(s.status, s.specials_new_products_price, NULL) as specials_new_products_price, IF(s.status, s.specials_new_products_price, p.products_price) as final_price from " . TABLE_PRODUCTS . " p left join " . TABLE_SPECIALS . " s on p.products_id = s.products_id, " . TABLE_PRODUCTS_DESCRIPTION . " pd, " . TABLE_MANUFACTURERS_INFO . " m, (SELECT * FROM ".TABLE_PRODUCTS_TO_CATEGORIES." group by products_id) p2c,".TABLE_CATEGORIES." c where p.products_status = '1' and c.categories_id=p2c.categories_id and c.categories_status=1 and p.manufacturers_id = m.manufacturers_id and m.manufacturers_id = '" . (int)$HTTP_GET_VARS['manufacturers_id'] . "' and p.products_id = p2c.products_id and pd.products_id = p2c.products_id and pd.language_id = '" . (int)$languages_id . "' and p2c.categories_id = '" . (int)$HTTP_GET_VARS['filter_id'] . "'";
        } else {
// We show them all
            $listing_sql = "select SQL_CALC_FOUND_ROWS " . $select_column_list . " p.products_id,".$select_product_order.", p.manufacturers_id, p.products_price, p.products_tax_class_id, IF(s.status, s.specials_new_products_price, NULL) as specials_new_products_price, IF(s.status, s.specials_new_products_price, p.products_price) as final_price from " . TABLE_PRODUCTS . " p left join " . TABLE_SPECIALS . " s on p.products_id = s.products_id, " . TABLE_PRODUCTS_DESCRIPTION . " pd, " . TABLE_MANUFACTURERS_INFO . " m where p.products_status = '1' and pd.products_id = p.products_id and pd.language_id = '" . (int)$languages_id . "' and p.manufacturers_id = m.manufacturers_id and m.manufacturers_id = '" . (int)$HTTP_GET_VARS['manufacturers_id'] . "'";
        }
    } else {
// show the products in a given categorie


        if (isset($HTTP_GET_VARS['filter_id']) && tep_not_null($HTTP_GET_VARS['filter_id'])) {
// We are asked to show only specific catgeory
            $listing_sql = "select SQL_CALC_FOUND_ROWS " . $select_column_list . " p.products_id, ".$select_product_order.", p.manufacturers_id, p.products_price, p.products_tax_class_id, IF(s.status, s.specials_new_products_price, NULL) as specials_new_products_price, IF(s.status, s.specials_new_products_price, p.products_price) as final_price from " . TABLE_PRODUCTS . " p left join " . TABLE_SPECIALS . " s on p.products_id = s.products_id, " . TABLE_PRODUCTS_DESCRIPTION . " pd, " . TABLE_MANUFACTURERS_INFO . " m, (SELECT * FROM ".TABLE_PRODUCTS_TO_CATEGORIES." group by products_id) p2c,".TABLE_CATEGORIES." c where p.products_status = '1' and c.categories_id=p2c.categories_id and c.categories_status=1 and p.manufacturers_id = m.manufacturers_id and m.manufacturers_id = '" . (int)$HTTP_GET_VARS['filter_id'] . "' and p.products_id = p2c.products_id and pd.products_id = p2c.products_id and pd.language_id = '" . (int)$languages_id . "'";
        } else {
// We show them all
            $listing_sql = "select SQL_CALC_FOUND_ROWS " . $select_column_list . " p.products_id, ".$select_product_order.", p.manufacturers_id, p.products_price, p.products_tax_class_id, IF(s.status, s.specials_new_products_price, NULL) as specials_new_products_price, IF(s.status, s.specials_new_products_price, p.products_price) as final_price from " . TABLE_PRODUCTS_DESCRIPTION . " pd, " . TABLE_PRODUCTS . " p left join " . TABLE_MANUFACTURERS_INFO . " m on p.manufacturers_id = m.manufacturers_id left join " . TABLE_SPECIALS . " s on p.products_id = s.products_id, (SELECT * FROM ".TABLE_PRODUCTS_TO_CATEGORIES." group by products_id) p2c,".TABLE_CATEGORIES." c where p.products_status = '1' and c.categories_id=p2c.categories_id and c.categories_status=1 and p.products_id = p2c.products_id and pd.products_id = p2c.products_id and pd.language_id = '" . (int)$languages_id . "'";
//        " and p2c.categories_id = '" . (int)$current_category_id . "'";
        }
        if (sizeof($nested_cids)>0){$listing_sql.=" and p2c.categories_id in (" .implode($nested_cids,',')  . ")";}
        else{$listing_sql.=" and p2c.categories_id = '" . (int)$current_category_id . "'";}

    }
//    $listing_sql.=' and p.products_quantity>0 ';
    if ( (!isset($HTTP_GET_VARS['sort'])) || (!preg_match('/^[1-8][ad]$/', $HTTP_GET_VARS['sort'])) || (substr($HTTP_GET_VARS['sort'], 0, 1) > sizeof($column_list)) ) {
        for ($i=0, $n=sizeof($column_list); $i<$n; $i++) {
            if ($column_list[$i] == 'PRODUCT_LIST_NAME') {
                $HTTP_GET_VARS['sort'] = $i+1 . 'a';
//          $listing_sql .= " order by pq desc,p.products_sort_order,pd.products_name";
                $listing_sql.=' order by pq desc,ps asc, p.products_price asc';
                break;
            }
        }
    } else {
        $sort_col = substr($HTTP_GET_VARS['sort'], 0 , 1);
        $sort_order = substr($HTTP_GET_VARS['sort'], 1);

        switch ($column_list[$sort_col-1]) {
            case 'PRODUCT_LIST_MODEL':
                $listing_sql .= " order by p.products_model " . ($sort_order == 'd' ? 'desc' : '') . ", pd.products_name";
                break;
            case 'PRODUCT_LIST_NAME':
                $listing_sql .= " order by pd.products_name " . ($sort_order == 'd' ? 'desc' : '');
                break;
            case 'PRODUCT_LIST_MANUFACTURER':
                $listing_sql .= " order by m.manufacturers_name " . ($sort_order == 'd' ? 'desc' : '') . ", pd.products_name";
                break;
            case 'PRODUCT_LIST_QUANTITY':
                $listing_sql .= " order by p.products_quantity " . ($sort_order == 'd' ? 'desc' : '') . ", pd.products_name";
                break;
            case 'PRODUCT_LIST_IMAGE':
                $listing_sql .= " order by pd.products_name";
                break;
            case 'PRODUCT_LIST_WEIGHT':
                $listing_sql .= " order by p.products_weight " . ($sort_order == 'd' ? 'desc' : '') . ", pd.products_name";
                break;
            case 'PRODUCT_LIST_PRICE':
                $listing_sql .= " order by final_price " . ($sort_order == 'd' ? 'desc' : '') . ", pd.products_name";
                break;
        }
    }
//echo 'Listing'.$listing_sql;exit;
    $catname = HEADING_TITLE;
    if (isset($HTTP_GET_VARS['manufacturers_id']) && !empty($HTTP_GET_VARS['manufacturers_id'])) {
        $image = tep_db_query("select m.manufacturers_image, mi.manufacturers_name 
        as catname from " . TABLE_MANUFACTURERS_INFO . " mi
        left join ".TABLE_MANUFACTURERS." m on (m.manufacturers_id=mi.manufacturers_id)
        where m.manufacturers_id = '" . (int)$HTTP_GET_VARS['manufacturers_id'] . "'");
        $image = tep_db_fetch_array($image);
        $catname = $image['catname'];
    } elseif ($current_category_id) {
        $image = tep_db_query("select c.categories_image, cd.categories_name as catname from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd where c.categories_id = '" . (int)$current_category_id . "' and c.categories_id = cd.categories_id and cd.language_id = '" . (int)$languages_id . "'");
        $image = tep_db_fetch_array($image);
        $catname = $image['catname'];
    }
    ?>
    <div class="product_listing_info">
        <h1><?php echo $catname; ?></h1>

        <div class="contentContainer">
            <?php
            require (DIR_FS_CATALOG.DIR_WS_MODULES . 'products_filter.php');
            // optional Product List Filter
            if (PRODUCT_LIST_FILTER > 0) {
                $filterlist_sql='';
                if (isset($HTTP_GET_VARS['manufacturers_id']) && !empty($HTTP_GET_VARS['manufacturers_id'])) {
//        $filterlist_sql = "select distinct c.categories_id as id, cd.categories_name as name from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c, " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd where p.products_status = '1' and p.products_id = p2c.products_id and p2c.categories_id = c.categories_id and p2c.categories_id = cd.categories_id and cd.language_id = '" . (int)$languages_id . "' and p.manufacturers_id = '" . (int)$HTTP_GET_VARS['manufacturers_id'] . "' order by cd.categories_name";
                } else {
                    $filterlist_sql= "select distinct m.manufacturers_id as id, m.manufacturers_name as name from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c, " . TABLE_MANUFACTURERS_INFO . " m where p.products_status = '1' and p.manufacturers_id = m.manufacturers_id and p.products_id = p2c.products_id and p2c.categories_id = '" . (int)$current_category_id . "' order by m.manufacturers_name";
                }

                if (strlen($filterlist_sql)>0){
                    $filterlist_query = tep_db_query($filterlist_sql);
                    if (tep_db_num_rows($filterlist_query) > 1) {
                        echo '<div>' . tep_draw_form('filter', FILENAME_DEFAULT, 'get') . '<p align="right">' . TEXT_SHOW . '&nbsp;';
                        if (isset($HTTP_GET_VARS['manufacturers_id']) && !empty($HTTP_GET_VARS['manufacturers_id'])) {
                            echo tep_draw_hidden_field('manufacturers_id', $HTTP_GET_VARS['manufacturers_id']);
                            $options = array(array('id' => '', 'text' => TEXT_ALL_CATEGORIES));
                        } else {
                            echo tep_draw_hidden_field('cPath', $cPath);
                            $options = array(array('id' => '', 'text' => TEXT_ALL_MANUFACTURERS));
                        }
                        echo tep_draw_hidden_field('sort', $HTTP_GET_VARS['sort']);
                        while ($filterlist = tep_db_fetch_array($filterlist_query)) {
                            $options[] = array('id' => $filterlist['id'], 'text' => $filterlist['name']);
                        }
                        echo tep_draw_pull_down_menu('filter_id', $options, (isset($HTTP_GET_VARS['filter_id']) ? $HTTP_GET_VARS['filter_id'] : ''), 'onchange="this.form.submit()"');
                        echo tep_hide_session_id() . '</p></form></div>' . "\n";
                    }
                }//---if filterlist exist
            }
            include(DIR_WS_MODULES . FILENAME_PRODUCT_LISTING);
            ?>

        </div>
    </div>
    <?php
} else { // default page
    ?>


    <?php /* ?>
        <ul class="tabs">
            <li><a href="#" rel="view1"><?php echo TEXT_NEW; ?></a></li>
            <li><a href="#" rel="view2"><?php echo TEXT_SPECIAL; ?></a></li>
        </ul>
        <div class="tabcontents">
            <div id="view1" class="tabcontent">
                 <?php
                    include(DIR_WS_MODULES . FILENAME_NEW_PRODUCTS);
                    ?>
            </div>
            <div id="view2" class="tabcontent">
                <?php
            	include(DIR_WS_MODULES . FILENAME_SPECIALS);
            	?>
            </div>

        </div>
        <?php */ ?>
    <?php /* ?>
        <div class="tabcontents">
            <div id="view2" class="tabcontent">
                <?php
            	include(DIR_WS_MODULES . FILENAME_SPECIALS);
            	?>
	    </div>
    </div>
<?php */ /*?>
    <table border="0" width="100%" cellspacing="10" cellpadding="1">
      <tr>
<?php

    $categories_query = tep_db_query("select c.categories_id, cd.categories_name, c.categories_image, c.parent_id from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd where c.parent_id = '0' and c.categories_id = cd.categories_id and cd.language_id = '" . (int)$languages_id . "' and c.categories_status=1 order by sort_order, cd.categories_name");
    $number_of_categories = tep_db_num_rows($categories_query);

    $rows = 0;
    while ($categories = tep_db_fetch_array($categories_query)) {
      $rows++;
      $cPath_new = tep_get_path($categories['categories_id']);
      $width = (int)(100 / MAX_DISPLAY_CATEGORIES_PER_ROW_MOB) . '%';
      echo '        <td align="center" class="smallText" width="' . $width . '" valign="top"><div class="categoryListBoxContents" style="width:100%;"><div class="subproduct_name"><a href="' . tep_href_link(FILENAME_DEFAULT, $cPath_new) . '">' . tep_image(DIR_WS_IMAGES . $categories['categories_image'], $categories['categories_name'], SUBCATEGORY_IMAGE_WIDTH, SUBCATEGORY_IMAGE_HEIGHT) . '<br />' . $categories['categories_name'] . '</a></div></div></td>' . "\n";
      if ((($rows / MAX_DISPLAY_CATEGORIES_PER_ROW_MOB) == floor($rows / MAX_DISPLAY_CATEGORIES_PER_ROW_MOB)) && ($rows != $number_of_categories)) {
        echo '      </tr>' . "\n";
        echo '      <tr>' . "\n";
      }
    }
// needed for the new products module shown below
?>
      </tr>
    </table>
<?php */?>
    <div class="contentContainer">
        <?php
        $cPath='0';
        require(DIR_WS_MODULES.FILENAME_CATEGORY_LISTING);?>
    </div>
    <?php
}

require(DIR_WS_INCLUDES . 'template_bottom.php');
require(DIR_WS_INCLUDES . 'application_bottom.php');
?>
