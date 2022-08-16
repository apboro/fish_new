<?php
/*
  $Id: categories.php,v 1.2 2003/09/24 13:57:05 wilt Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/
if (isset($_POST['upd'])) {$_GET['action']='update_category';}
  require('includes/application_top.php');
//Added for Categories Description 1.5
  require('includes/functions/categories_description.php');
//End Categories Description 1.5

  require(DIR_WS_CLASSES . 'currencies.php');
  $currencies = new currencies();

// Start Products Specifications
  require_once (DIR_WS_CLASSES . 'boxes.php');
  require_once (DIR_WS_FUNCTIONS . 'products_specifications.php');
// End Products Specifications

  $action = (isset($_GET['action']) ? $_GET['action'] : '');

// BOF: KategorienAdmin / OLISWISS
  	$admin_access_query = tep_db_query("select admin_groups_id, admin_cat_access, admin_right_access from " . TABLE_ADMIN . " where admin_id=" . $login_id);
	$admin_access_array = tep_db_fetch_array($admin_access_query);
	$admin_groups_id = $admin_access_array['admin_groups_id'];
	$admin_cat_access = $admin_access_array['admin_cat_access'];
	$admin_cat_access_array_cats = explode(",",$admin_cat_access);
	$admin_right_access = $admin_access_array['admin_right_access'];
// EOF: KategorienAdmin / OLISWISS

  if (tep_not_null($action)) {
    switch ($action) {
      case 'setflag':
        if ( ($_GET['flag'] == '0') || ($_GET['flag'] == '1') ) {
          if (isset($_GET['pID'])) {
            tep_set_product_status($_GET['pID'], $_GET['flag']);
          }

          if (USE_CACHE == 'true') {
            tep_reset_cache_block('categories');
            tep_reset_cache_block('also_purchased');
          }
        }

        tep_redirect(tep_href_link(FILENAME_CATEGORIES, 'cPath=' . $_GET['cPath'] . '&pID=' . $_GET['pID']));
        break;

// BOF Enable - Disable Categories Contribution--------------------------------------
		case 'setflag_cat':
        		if ( ($_GET['flag'] == '0') || ($_GET['flag'] == '1') )
			{
	      		if (isset($_GET['cID']))
				{
            		tep_set_categories_status($_GET['cID'], $_GET['flag']);
    				}

          		if (USE_CACHE == 'true')
				{
            			tep_reset_cache_block('categories');
            			tep_reset_cache_block('also_purchased');
          			}
        		}

	tep_redirect(tep_href_link(FILENAME_CATEGORIES, 'cPath=' . $_GET['cPath'] . '&cID=' . $_GET['cID']));
	break;
// EOF Enable - Disable Categories Contribution--------------------------------------


      case 'setxml':
        if ( ($_GET['flagxml'] == '0') || ($_GET['flagxml'] == '1') ) {
          if (isset($_GET['pID'])) {
            tep_set_product_xml($_GET['pID'], $_GET['flagxml']);
          }

          if (USE_CACHE == 'true') {
            tep_reset_cache_block('categories');
            tep_reset_cache_block('also_purchased');
          }
        }

        tep_redirect(tep_href_link(FILENAME_CATEGORIES, 'cPath=' . $_GET['cPath'] . '&pID=' . $_GET['pID']));
        break;


//Added for Categories Description 1.5
      case 'new_category':
      case 'edit_category':
	  
	   
        if (ALLOW_CATEGORY_DESCRIPTIONS == 'true')
          $_GET['action']=$_GET['action'] . '_ACD';
        break;
//End Categories Description 1.5

      case 'insert_category':
      case 'update_category':
//==================================================================================================	
	  if (isset($_POST['cat_id']))
	  {
	  foreach($_POST['cat_id'] as $cat_id => $pos)
   {
       $categories_id = $cat_id;
	   $sort_order = $pos;
//        $sql_data_array = array('sort_order' => $sort_order);
// BOF Enable - Disable Categories Contribution--------------------------------------
        $sql_data_array = array('sort_order' => $sort_order);
// EOF Enable - Disable Categories Contribution--------------------------------------

      
          $update_sql_data = array('last_modified' => 'now()');

          $sql_data_array = array_merge($sql_data_array, $update_sql_data);

          tep_db_perform(TABLE_CATEGORIES, $sql_data_array, 'update', "categories_id = '" . (int)$categories_id . "'");
        
		}
		 tep_redirect(tep_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . '&cID=' . $categories_id));
		break;
	  }
//==================================================================================================		  
	  
	  
	  

//Added for Categories Description 1.5
 if ( ($_POST['edit_x']) || ($_POST['edit_y']) ) {
          $_GET['action'] = 'edit_category_ACD';
        } else {
//End Categories Description 1.5

        if (isset($_POST['categories_id'])) $categories_id = tep_db_prepare_input($_POST['categories_id']);

//Added for Categories Description 1.5
        if ($categories_id == '') {
           $categories_id = tep_db_prepare_input($_GET['cID']);
         }
//End Categories Description 1.5

        $sort_order = tep_db_prepare_input($_POST['sort_order']);

//        $sql_data_array = array('sort_order' => $sort_order);

// BOF Enable - Disable Categories Contribution--------------------------------------
        $categories_status = tep_db_prepare_input($_POST['categories_status']);
        $sql_data_array = array('sort_order' => $sort_order, 'categories_status' => $categories_status);
// EOF Enable - Disable Categories Contribution--------------------------------------

        if ($action == 'insert_category') {
          $insert_sql_data = array('parent_id' => $current_category_id,
                                   'date_added' => 'now()');

          $sql_data_array = array_merge($sql_data_array, $insert_sql_data);

          tep_db_perform(TABLE_CATEGORIES, $sql_data_array);

          $categories_id = tep_db_insert_id();
          
// BOF: KategorienAdmin / OLI
	if (in_array("ALL",$admin_cat_access_array_cats)== false) {
	  array_push($admin_cat_access_array_cats,$categories_id);
	  $admin_cat_access = implode(",",$admin_cat_access_array_cats);
          $sql_data_array = array('admin_cat_access' => tep_db_prepare_input($admin_cat_access));
          tep_db_perform(TABLE_ADMIN, $sql_data_array, 'update', 'admin_id = \'' . $login_id . '\'');
        }
// EOF: KategorienAdmin / OLI 
         
        } elseif ($action == 'update_category') {
          $update_sql_data = array('last_modified' => 'now()');

          $sql_data_array = array_merge($sql_data_array, $update_sql_data);

          tep_db_perform(TABLE_CATEGORIES, $sql_data_array, 'update', "categories_id = '" . (int)$categories_id . "'");
        }

        $languages = tep_get_languages();
        for ($i=0, $n=sizeof($languages); $i<$n; $i++) {
          $categories_name_array = $_POST['categories_name'];
          $categories_meta_title_array = $_POST['categories_meta_title'];
          $categories_meta_description_array = $_POST['categories_meta_description'];
          $categories_meta_keywords_array = $_POST['categories_meta_keywords'];

          $language_id = $languages[$i]['id'];

          $sql_data_array = array('categories_name' => tep_db_prepare_input($categories_name_array[$language_id]),
                                  'categories_meta_title' => tep_db_prepare_input($categories_meta_title_array[$language_id]),
                                  'categories_meta_description' => tep_db_prepare_input($categories_meta_description_array[$language_id]),
                                  'categories_meta_keywords' => tep_db_prepare_input($categories_meta_keywords_array[$language_id]));

//Added for Categories Description 1.5
            if (ALLOW_CATEGORY_DESCRIPTIONS == 'true') {
              $sql_data_array = array('categories_name' => tep_db_prepare_input($_POST['categories_name'][$language_id]),
                                      'categories_heading_title' => tep_db_prepare_input($_POST['categories_heading_title'][$language_id]),
                                      'categories_description' => tep_db_prepare_input($_POST['categories_description'][$language_id]),
                                      'categories_meta_title' => tep_db_prepare_input($_POST['categories_meta_title'][$language_id]),
                                      'categories_meta_description' => tep_db_prepare_input($_POST['categories_meta_description'][$language_id]),
                                      'categories_meta_keywords' => tep_db_prepare_input($_POST['categories_meta_keywords'][$language_id]));
            }
//End Categories Description 1.5

          if ($action == 'insert_category') {
            $insert_sql_data = array('categories_id' => $categories_id,
                                     'language_id' => $languages[$i]['id']);

            $sql_data_array = array_merge($sql_data_array, $insert_sql_data);

            tep_db_perform(TABLE_CATEGORIES_DESCRIPTION, $sql_data_array);
          } elseif ($action == 'update_category') {
            tep_db_perform(TABLE_CATEGORIES_DESCRIPTION, $sql_data_array, 'update', "categories_id = '" . (int)$categories_id . "' and language_id = '" . (int)$languages[$i]['id'] . "'");
          }
        }


//Code commented out for Categories Description 1.5
//        if ($categories_image = new upload('categories_image', DIR_FS_CATALOG_IMAGES)) {
//          tep_db_query("update " . TABLE_CATEGORIES . " set categories_image = '" . //tep_db_input($categories_image->filename) . "' where categories_id = '" . (int)$categories_id . "'");
//        }
//Added the following to replacce above code
          if (ALLOW_CATEGORY_DESCRIPTIONS == 'true') {
            tep_db_query("update " . TABLE_CATEGORIES . " set categories_image = '" . $_POST['categories_image'] . "' where categories_id = '" .  tep_db_input($categories_id) . "'");
            $categories_image = '';
      } else {
      
        if ($categories_image = new upload('categories_image', DIR_FS_CATALOG_IMAGES)) {
      if ($_POST['categories_image_old'] != $categories_image->filename && $categories_image->filename != '') {
          tep_db_query("update " . TABLE_CATEGORIES . " set categories_image = '" . tep_db_input($categories_image->filename) . "' where categories_id = '" . (int)$categories_id . "'");
        }
       }
}
        
        $categories_image = new upload('categories_image', DIR_FS_CATALOG_IMAGES);
        
        $categories_image->set_destination(DIR_FS_CATALOG_IMAGES);        
        if ($categories_image->parse() && $categories_image->save()) {        
          tep_db_query("update " . TABLE_CATEGORIES . " set categories_image = '" . tep_db_input($categories_image->filename) . "' where categories_id = '" . (int)$categories_id . "'");
        }
       
        

//End Categories Description 1.5

        if (USE_CACHE == 'true') {
          tep_reset_cache_block('categories');
          tep_reset_cache_block('also_purchased');
        }

        tep_redirect(tep_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . '&cID=' . $categories_id));

//Added for Categories Description 1.5
        }
//End Categories Description 1.5

        break;
      case 'delete_category_confirm':
      	
      	
      	
      	
      	
      	
      
	
        if (isset($_POST['prod_id']) && is_array($_POST['prod_id'])) {
       
        	foreach ($_POST['prod_id'] as $prod_id => $cat_id2 ){
        		
        		$cat_id1[]= $cat_id2;
          $product_id = tep_db_prepare_input($prod_id);
          $product_categories = $cat_id1;

          for ($i=0, $n=sizeof($product_categories); $i<$n; $i++) {
            tep_db_query("delete from " . TABLE_PRODUCTS_TO_CATEGORIES . " where products_id = '" . (int)$product_id . "' and categories_id = '" . (int)$product_categories[$i] . "'");
          }

          $product_categories_query = tep_db_query("select count(*) as total from " . TABLE_PRODUCTS_TO_CATEGORIES . " where products_id = '" . (int)$product_id . "'");
          $product_categories = tep_db_fetch_array($product_categories_query);

          if ($product_categories['total'] == '0') {
            tep_remove_product($product_id);

    // START: Extra Fields Contribution
    tep_db_query("delete from " . TABLE_PRODUCTS_TO_PRODUCTS_EXTRA_FIELDS . " where products_id = " . (int)$product_id);
    // END: Extra Fields Contribution
          }
          }
        }
        if (isset($_POST['categories_id2']) && is_array($_POST['categories_id2'])) {
        	foreach ($_POST['categories_id2'] as $cat_id => $e_id ){
          $categories_id = tep_db_prepare_input($e_id);

// BOF: KategorienAdmin / OLI 
        //$categories = tep_get_category_tree($categories_id, '', '0', '',true);
          $categories = tep_get_category_tree($categories_id, '', '0', '', '',true);
// EOF: KategorienAdmin / OLI 



          $products = array();
          $products_delete = array();

          for ($i=0, $n=sizeof($categories); $i<$n; $i++) {
            $product_ids_query = tep_db_query("select products_id from " . TABLE_PRODUCTS_TO_CATEGORIES . " where categories_id = '" . (int)$categories[$i]['id'] . "'");

            while ($product_ids = tep_db_fetch_array($product_ids_query)) {
              $products[$product_ids['products_id']]['categories'][] = $categories[$i]['id'];
            }
          }

          reset($products);
          while (list($key, $value) = each($products)) {
            $category_ids = '';

            for ($i=0, $n=sizeof($value['categories']); $i<$n; $i++) {
              $category_ids .= "'" . (int)$value['categories'][$i] . "', ";
            }
            $category_ids = substr($category_ids, 0, -2);

            $check_query = tep_db_query("select count(*) as total from " . TABLE_PRODUCTS_TO_CATEGORIES . " where products_id = '" . (int)$key . "' and categories_id not in (" . $category_ids . ")");
            $check = tep_db_fetch_array($check_query);
            if ($check['total'] < '1') {
              $products_delete[$key] = $key;
            }
          }

// removing categories can be a lengthy process
          tep_set_time_limit(0);
          for ($i=0, $n=sizeof($categories); $i<$n; $i++) {
            tep_remove_category($categories[$i]['id']);

          }


          reset($products_delete);
          while (list($key) = each($products_delete)) {
            tep_remove_product($key);
          }
        }}
          if (isset($_POST['categories_id'])) { 
           $categories_id = tep_db_prepare_input($_POST['categories_id']);

// BOF: KategorienAdmin / OLI 
        //$categories = tep_get_category_tree($categories_id, '', '0', '',true);
          $categories = tep_get_category_tree($categories_id, '', '0', '', '',true);
// EOF: KategorienAdmin / OLI 


          $products = array();
          $products_delete = array();

          for ($i=0, $n=sizeof($categories); $i<$n; $i++) {
            $product_ids_query = tep_db_query("select products_id from " . TABLE_PRODUCTS_TO_CATEGORIES . " where categories_id = '" . (int)$categories[$i]['id'] . "'");

            while ($product_ids = tep_db_fetch_array($product_ids_query)) {
              $products[$product_ids['products_id']]['categories'][] = $categories[$i]['id'];
            }
          }

          reset($products);
          while (list($key, $value) = each($products)) {
            $category_ids = '';

            for ($i=0, $n=sizeof($value['categories']); $i<$n; $i++) {
              $category_ids .= "'" . (int)$value['categories'][$i] . "', ";
            }
            $category_ids = substr($category_ids, 0, -2);

            $check_query = tep_db_query("select count(*) as total from " . TABLE_PRODUCTS_TO_CATEGORIES . " where products_id = '" . (int)$key . "' and categories_id not in (" . $category_ids . ")");
            $check = tep_db_fetch_array($check_query);
            if ($check['total'] < '1') {
              $products_delete[$key] = $key;
            }
          }

// removing categories can be a lengthy process
          tep_set_time_limit(0);
          for ($i=0, $n=sizeof($categories); $i<$n; $i++) {
            tep_remove_category($categories[$i]['id']);

          }


          reset($products_delete);
          while (list($key) = each($products_delete)) {
            tep_remove_product($key);
          }
          
          }

        if (USE_CACHE == 'true') {
          tep_reset_cache_block('categories');
          tep_reset_cache_block('also_purchased');
        }
        if (isset($_POST['cPath'])) {
$cPath=$_POST['cPath'];}
       tep_redirect(tep_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath));
        break;
      case 'delete_product_confirm':

	 
	
        if (isset($_POST['products_id']) && isset($_POST['product_categories']) && is_array($_POST['product_categories'])) {
          $product_id = tep_db_prepare_input($_POST['products_id']);
          $product_categories = $_POST['product_categories'];

          for ($i=0, $n=sizeof($product_categories); $i<$n; $i++) {
            tep_db_query("delete from " . TABLE_PRODUCTS_TO_CATEGORIES . " where products_id = '" . (int)$product_id . "' and categories_id = '" . (int)$product_categories[$i] . "'");
          }

          $product_categories_query = tep_db_query("select count(*) as total from " . TABLE_PRODUCTS_TO_CATEGORIES . " where products_id = '" . (int)$product_id . "'");
          $product_categories = tep_db_fetch_array($product_categories_query);

          if ($product_categories['total'] == '0') {
            tep_remove_product($product_id);

    // START: Extra Fields Contribution
    tep_db_query("delete from " . TABLE_PRODUCTS_TO_PRODUCTS_EXTRA_FIELDS . " where products_id = " . (int)$product_id);
    // END: Extra Fields Contribution

          }
        }

// Start Products Specifications
        tep_db_query ("delete from " . TABLE_PRODUCTS_SPECIFICATIONS . " 
                       where products_id = '" . (int) $product_id . "'
                    ");
// End Products Specifications

        if (USE_CACHE == 'true') {
          tep_reset_cache_block('categories');
          tep_reset_cache_block('also_purchased');
        }

        tep_redirect(tep_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath));
        break;
      case 'move_category_confirm':
        if (isset($_POST['categories_id']) && ($_POST['categories_id'] != $_POST['move_to_category_id'])) {
          $categories_id = tep_db_prepare_input($_POST['categories_id']);
          $new_parent_id = tep_db_prepare_input($_POST['move_to_category_id']);

          $path = explode('_', tep_get_generated_category_path_ids($new_parent_id));

          if (in_array($categories_id, $path)) {
            $messageStack->add_session(ERROR_CANNOT_MOVE_CATEGORY_TO_PARENT, 'error');

            tep_redirect(tep_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . '&cID=' . $categories_id));
          } else {
            tep_db_query("update " . TABLE_CATEGORIES . " set parent_id = '" . (int)$new_parent_id . "', last_modified = now() where categories_id = '" . (int)$categories_id . "'");

            if (USE_CACHE == 'true') {
              tep_reset_cache_block('categories');
              tep_reset_cache_block('also_purchased');
            }

            tep_redirect(tep_href_link(FILENAME_CATEGORIES, 'cPath=' . $new_parent_id . '&cID=' . $categories_id));
          }
        }

        break;
      case 'move_product_confirm':
        $products_id = tep_db_prepare_input($_POST['products_id']);
        $new_parent_id = tep_db_prepare_input($_POST['move_to_category_id']);

        $duplicate_check_query = tep_db_query("select count(*) as total from " . TABLE_PRODUCTS_TO_CATEGORIES . " where products_id = '" . (int)$products_id . "' and categories_id = '" . (int)$new_parent_id . "'");
        $duplicate_check = tep_db_fetch_array($duplicate_check_query);
        if ($duplicate_check['total'] < 1) tep_db_query("update " . TABLE_PRODUCTS_TO_CATEGORIES . " set categories_id = '" . (int)$new_parent_id . "' where products_id = '" . (int)$products_id . "' and categories_id = '" . (int)$current_category_id . "'");

        if (USE_CACHE == 'true') {
          tep_reset_cache_block('categories');
          tep_reset_cache_block('also_purchased');
        }

        tep_redirect(tep_href_link(FILENAME_CATEGORIES, 'cPath=' . $new_parent_id . '&pID=' . $products_id));
        break;
///////////////////////////////////////////////////////////////////////////////////////
// BOF: WebMakers.com Added: Copy Attributes Existing Product to another Existing Product

      case 'create_copy_product_attributes':
  // $products_id_to= $copy_to_products_id;
  // $products_id_from = $pID;
        tep_copy_products_attributes($pID,$copy_to_products_id);
        break;
// EOF: WebMakers.com Added: Copy Attributes Existing Product to another Existing Product
///////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////
// WebMakers.com Added: Copy Attributes Existing Product to All Existing Products in a Category
      case 'create_copy_product_attributes_categories':
  // $products_id_to= $categories_products_copying['products_id'];
  // $products_id_from = $make_copy_from_products_id;
  //  echo 'Copy from products_id# ' . $make_copy_from_products_id . ' Copy to all products in category: ' . $cID . '<br>';
        $categories_products_copying_query= tep_db_query("select products_id from " . TABLE_PRODUCTS_TO_CATEGORIES . " where categories_id='" . $cID . "'");
        while ( $categories_products_copying=tep_db_fetch_array($categories_products_copying_query) ) {
          // process all products in category
          tep_copy_products_attributes($make_copy_from_products_id,$categories_products_copying['products_id']);
        }
        break;
// EOF: WebMakers.com Added: Copy Attributes Existing Product to All Existing Products in a Category
///////////////////////////////////////////////////////////////////////////////////////
      case 'insert_product':
      case 'update_product':
        if (isset($_POST['edit_x']) || isset($_POST['edit_y'])) {
          $action = 'new_product';
        } else {

// BOF MaxiDVD: Modified For Ultimate Images Pack!
            if ($_POST['delete_image'] == 'yes') {
                unlink(DIR_FS_CATALOG_IMAGES . $_POST['products_previous_image']);
            }
            if ($_POST['delete_image_med'] == 'yes') {
                unlink(DIR_FS_CATALOG_IMAGES . $_POST['products_previous_image_med']);
            }
            if ($_POST['delete_image_lrg'] == 'yes') {
                unlink(DIR_FS_CATALOG_IMAGES . $_POST['products_previous_image_lrg']);
            }
            if ($_POST['delete_image_sm_1'] == 'yes') {
                unlink(DIR_FS_CATALOG_IMAGES . $_POST['products_previous_image_sm_1']);
            }
            if ($_POST['delete_image_xl_1'] == 'yes') {
                unlink(DIR_FS_CATALOG_IMAGES . $_POST['products_previous_image_xl_1']);
            }
            if ($_POST['delete_image_sm_2'] == 'yes') {
                unlink(DIR_FS_CATALOG_IMAGES . $_POST['products_previous_image_sm_2']);
            }
            if ($_POST['delete_image_xl_2'] == 'yes') {
                unlink(DIR_FS_CATALOG_IMAGES . $_POST['products_previous_image_xl_2']);
            }
            if ($_POST['delete_image_sm_3'] == 'yes') {
                unlink(DIR_FS_CATALOG_IMAGES . $_POST['products_previous_image_sm_3']);
            }
            if ($_POST['delete_image_xl_3'] == 'yes') {
                unlink(DIR_FS_CATALOG_IMAGES . $_POST['products_previous_image_xl_3']);
            }
            if ($_POST['delete_image_sm_4'] == 'yes') {
                unlink(DIR_FS_CATALOG_IMAGES . $_POST['products_previous_image_sm_4']);
            }
            if ($_POST['delete_image_xl_4'] == 'yes') {
                unlink(DIR_FS_CATALOG_IMAGES . $_POST['products_previous_image_xl_4']);
            }
            if ($_POST['delete_image_sm_5'] == 'yes') {
                unlink(DIR_FS_CATALOG_IMAGES . $_POST['products_previous_image_sm_5']);
            }
            if ($_POST['delete_image_xl_5'] == 'yes') {
                unlink(DIR_FS_CATALOG_IMAGES . $_POST['products_previous_image_xl_5']);
            }
            if ($_POST['delete_image_sm_6'] == 'yes') {
                unlink(DIR_FS_CATALOG_IMAGES . $_POST['products_previous_image_sm_6']);
            }
            if ($_POST['delete_image_xl_6'] == 'yes') {
                unlink(DIR_FS_CATALOG_IMAGES . $_POST['products_previous_image_xl_6']);
            }
// EOF MaxiDVD: Modified For Ultimate Images Pack!
          if (isset($_GET['pID'])) $products_id = tep_db_prepare_input($_GET['pID']);
          $products_date_available = tep_db_prepare_input($_POST['products_date_available']);

          $products_date_available = (date('Y-m-d') < $products_date_available) ? $products_date_available : 'null';

          $sql_data_array = array('products_quantity' => (int)tep_db_prepare_input($_POST['products_quantity']),
                                  'products_model' => tep_db_prepare_input($_POST['products_model']),
                                  'products_price' => tep_db_prepare_input($_POST['products_price']),
                                  'products_date_available' => $products_date_available,
                                  'products_weight' => (float)tep_db_prepare_input($_POST['products_weight']),
                                  'products_status' => tep_db_prepare_input($_POST['products_status']),
                                  'products_to_xml' => tep_db_prepare_input($_POST['products_to_xml']),
                                  'products_tax_class_id' => tep_db_prepare_input($_POST['products_tax_class_id']),
                                  'products_quantity_order_min' => tep_db_prepare_input($_POST['products_quantity_order_min']),
                                  'products_quantity_order_units' => tep_db_prepare_input($_POST['products_quantity_order_units']),
                                  'products_sort_order' => tep_db_prepare_input($_POST['products_sort_order']),
                                	 'manufacturers_id' => (int)tep_db_prepare_input($_POST['manufacturers_id']),
	                               'products_sort_order' => tep_db_prepare_input($_POST['products_sort_order']));

		 //TotalB2B start
		 $prices_num = tep_xppp_getpricesnum();
         for ($i=2; $i<=$prices_num; $i++) {
			if (tep_db_prepare_input($_POST['checkbox_products_price_' . $i]) != "true")
			   $sql_data_array['products_price_' . $i] = 'null';
			else
			   $sql_data_array['products_price_' . $i] = tep_db_prepare_input($_POST['products_price_' . $i]);
	     }
         //TotalB2B end


// BOF MaxiDVD: Modified For Ultimate Images Pack!
       if (($_POST['unlink_image'] == 'yes') or ($_POST['delete_image'] == 'yes')) {
            $sql_data_array['products_image'] = '';
           } else {
         if (isset($_POST['products_image']) && tep_not_null($_POST['products_image']) && ($_POST['products_image'] != 'none')) {
            $sql_data_array['products_image'] = tep_db_prepare_input($_POST['products_image']);
          }
          }
       if (($_POST['unlink_image_med'] == 'yes') or ($_POST['delete_image_med'] == 'yes')) {
            $sql_data_array['products_image_med'] = '';
           } else {
          if (isset($_POST['products_image_med']) && tep_not_null($_POST['products_image_med']) && ($_POST['products_image_med'] != 'none')) {
            $sql_data_array['products_image_med'] = tep_db_prepare_input($_POST['products_image_med']);
          }
          }
       if (($_POST['unlink_image_lrg'] == 'yes') or ($_POST['delete_image_lrg'] == 'yes')) {
            $sql_data_array['products_image_lrg'] = '';
           } else {
          if (isset($_POST['products_image_lrg']) && tep_not_null($_POST['products_image_lrg']) && ($_POST['products_image_lrg'] != 'none')) {
            $sql_data_array['products_image_lrg'] = tep_db_prepare_input($_POST['products_image_lrg']);
          }
          }
       if (($_POST['unlink_image_sm_1'] == 'yes') or ($_POST['delete_image_sm_1'] == 'yes')) {
            $sql_data_array['products_image_sm_1'] = '';
           } else {
          if (isset($_POST['products_image_sm_1']) && tep_not_null($_POST['products_image_sm_1']) && ($_POST['products_image_sm_1'] != 'none')) {
            $sql_data_array['products_image_sm_1'] = tep_db_prepare_input($_POST['products_image_sm_1']);
          }
          }
       if (($_POST['unlink_image_xl_1'] == 'yes') or ($_POST['delete_image_xl_1'] == 'yes')) {
            $sql_data_array['products_image_xl_1'] = '';
           } else {
          if (isset($_POST['products_image_xl_1']) && tep_not_null($_POST['products_image_xl_1']) && ($_POST['products_image_xl_1'] != 'none')) {
            $sql_data_array['products_image_xl_1'] = tep_db_prepare_input($_POST['products_image_xl_1']);
          }
          }
       if (($_POST['unlink_image_sm_2'] == 'yes') or ($_POST['delete_image_sm_2'] == 'yes')) {
            $sql_data_array['products_image_sm_2'] = '';
           } else {
          if (isset($_POST['products_image_sm_2']) && tep_not_null($_POST['products_image_sm_2']) && ($_POST['products_image_sm_2'] != 'none')) {
            $sql_data_array['products_image_sm_2'] = tep_db_prepare_input($_POST['products_image_sm_2']);
          }
          }
       if (($_POST['unlink_image_xl_2'] == 'yes') or ($_POST['delete_image_xl_2'] == 'yes')) {
            $sql_data_array['products_image_xl_2'] = '';
           } else {
          if (isset($_POST['products_image_xl_2']) && tep_not_null($_POST['products_image_xl_2']) && ($_POST['products_image_xl_2'] != 'none')) {
            $sql_data_array['products_image_xl_2'] = tep_db_prepare_input($_POST['products_image_xl_2']);
          }
          }
       if (($_POST['unlink_image_sm_3'] == 'yes') or ($_POST['delete_image_sm_3'] == 'yes')) {
            $sql_data_array['products_image_sm_3'] = '';
           } else {
          if (isset($_POST['products_image_sm_3']) && tep_not_null($_POST['products_image_sm_3']) && ($_POST['products_image_sm_3'] != 'none')) {
            $sql_data_array['products_image_sm_3'] = tep_db_prepare_input($_POST['products_image_sm_3']);
          }
          }
       if (($_POST['unlink_image_xl_3'] == 'yes') or ($_POST['delete_image_xl_3'] == 'yes')) {
            $sql_data_array['products_image_xl_3'] = '';
           } else {
          if (isset($_POST['products_image_xl_3']) && tep_not_null($_POST['products_image_xl_3']) && ($_POST['products_image_xl_3'] != 'none')) {
            $sql_data_array['products_image_xl_3'] = tep_db_prepare_input($_POST['products_image_xl_3']);
          }
          }
       if (($_POST['unlink_image_sm_4'] == 'yes') or ($_POST['delete_image_sm_4'] == 'yes')) {
            $sql_data_array['products_image_sm_4'] = '';
           } else {
          if (isset($_POST['products_image_sm_4']) && tep_not_null($_POST['products_image_sm_4']) && ($_POST['products_image_sm_4'] != 'none')) {
            $sql_data_array['products_image_sm_4'] = tep_db_prepare_input($_POST['products_image_sm_4']);
          }
          }
       if (($_POST['unlink_image_xl_4'] == 'yes') or ($_POST['delete_image_xl_4'] == 'yes')) {
            $sql_data_array['products_image_xl_4'] = '';
           } else {
          if (isset($_POST['products_image_xl_4']) && tep_not_null($_POST['products_image_xl_4']) && ($_POST['products_image_xl_4'] != 'none')) {
            $sql_data_array['products_image_xl_4'] = tep_db_prepare_input($_POST['products_image_xl_4']);
          }
          }
       if (($_POST['unlink_image_sm_5'] == 'yes') or ($_POST['delete_image_sm_5'] == 'yes')) {
            $sql_data_array['products_image_sm_5'] = '';
           } else {
          if (isset($_POST['products_image_sm_5']) && tep_not_null($_POST['products_image_sm_5']) && ($_POST['products_image_sm_5'] != 'none')) {
            $sql_data_array['products_image_sm_5'] = tep_db_prepare_input($_POST['products_image_sm_5']);
          }
          }
       if (($_POST['unlink_image_xl_5'] == 'yes') or ($_POST['delete_image_xl_5'] == 'yes')) {
            $sql_data_array['products_image_xl_5'] = '';
           } else {
          if (isset($_POST['products_image_xl_5']) && tep_not_null($_POST['products_image_xl_5']) && ($_POST['products_image_xl_5'] != 'none')) {
            $sql_data_array['products_image_xl_5'] = tep_db_prepare_input($_POST['products_image_xl_5']);
          }
          }
       if (($_POST['unlink_image_sm_6'] == 'yes') or ($_POST['delete_image_sm_6'] == 'yes')) {
            $sql_data_array['products_image_sm_6'] = '';
           } else {
          if (isset($_POST['products_image_sm_6']) && tep_not_null($_POST['products_image_sm_6']) && ($_POST['products_image_sm_6'] != 'none')) {
            $sql_data_array['products_image_sm_6'] = tep_db_prepare_input($_POST['products_image_sm_6']);
          }
          }
       if (($_POST['unlink_image_xl_6'] == 'yes') or ($_POST['delete_image_xl_6'] == 'yes')) {
            $sql_data_array['products_image_xl_6'] = '';
           } else {
          if (isset($_POST['products_image_xl_6']) && tep_not_null($_POST['products_image_xl_6']) && ($_POST['products_image_xl_6'] != 'none')) {
            $sql_data_array['products_image_xl_6'] = tep_db_prepare_input($_POST['products_image_xl_6']);
          }
          }
// EOF MaxiDVD: Modified For Ultimate Images Pack!

          if ($action == 'insert_product') {
            $insert_sql_data = array('products_date_added' => 'now()');

            $sql_data_array = array_merge($sql_data_array, $insert_sql_data);

            tep_db_perform(TABLE_PRODUCTS, $sql_data_array);
            $products_id = tep_db_insert_id();

            tep_db_query("insert into " . TABLE_PRODUCTS_TO_CATEGORIES . " (products_id, categories_id) values ('" . (int)$products_id . "', '" . (int)$current_category_id . "')");
          } elseif ($action == 'update_product') {
            $update_sql_data = array('products_last_modified' => 'now()');

            $sql_data_array = array_merge($sql_data_array, $update_sql_data);

            tep_db_perform(TABLE_PRODUCTS, $sql_data_array, 'update', "products_id = '" . (int)$products_id . "'");
          }

          $languages = tep_get_languages();
          for ($i=0, $n=sizeof($languages); $i<$n; $i++) {
            $language_id = $languages[$i]['id'];

            $sql_data_array = array('products_name' => tep_db_prepare_input($_POST['products_name'][$language_id]),
                                    'products_info' => tep_db_prepare_input($_POST['products_info'][$language_id]),
                                    'products_description' => tep_db_prepare_input($_POST['products_description'][$language_id]),
// Start Products Specifications
									'products_tab_1' => tep_db_prepare_input ($_POST['products_tab_1'][$language_id]),
									'products_tab_2' => tep_db_prepare_input ($_POST['products_tab_2'][$language_id]),
									'products_tab_3' => tep_db_prepare_input ($_POST['products_tab_3'][$language_id]),
									'products_tab_4' => tep_db_prepare_input ($_POST['products_tab_4'][$language_id]),
									'products_tab_5' => tep_db_prepare_input ($_POST['products_tab_5'][$language_id]),
									'products_tab_6' => tep_db_prepare_input ($_POST['products_tab_6'][$language_id]),
// End Products Specifications
                                    'products_url' => tep_db_prepare_input($_POST['products_url'][$language_id]),
		                              'products_head_title_tag' => tep_db_prepare_input($_POST['products_head_title_tag'][$language_id]),
                                    'products_head_desc_tag' => tep_db_prepare_input($_POST['products_head_desc_tag'][$language_id]),
                                    'products_head_keywords_tag' => tep_db_prepare_input($_POST['products_head_keywords_tag'][$language_id]));

            if ($action == 'insert_product') {
              $insert_sql_data = array('products_id' => $products_id,
                                       'language_id' => $language_id);

              $sql_data_array = array_merge($sql_data_array, $insert_sql_data);

              tep_db_perform(TABLE_PRODUCTS_DESCRIPTION, $sql_data_array);
            } elseif ($action == 'update_product') {
              tep_db_perform(TABLE_PRODUCTS_DESCRIPTION, $sql_data_array, 'update', "products_id = '" . (int)$products_id . "' and language_id = '" . (int)$language_id . "'");
            }
          }

// Start Products Specifications
          for ($i=0, $n=sizeof($languages); $i<$n; $i++) {
            $language_id = $languages[$i]['id'];
            $specifications_query_raw = "select s.specifications_id
                                         from " . TABLE_SPECIFICATION . " s, 
                                              " . TABLE_SPECIFICATIONS_TO_CATEGORIES . " sg2c
                                         where sg2c.specification_group_id = s.specification_group_id 
                                           and sg2c.categories_id = '" . (int) $current_category_id . "'
                                       ";
            $specifications_query = tep_db_query ($specifications_query_raw);

            $count_specificatons = tep_db_num_rows ($specifications_query);
            if ($count_specificatons > 0) {
              while ($specifications = tep_db_fetch_array ($specifications_query) ) {
                $specifications_id = (int) $specifications['specifications_id'];

                tep_db_query ("delete from " . TABLE_PRODUCTS_SPECIFICATIONS . " 
                               where products_id = '" . (int) $products_id . "' 
                                 and specifications_id = '" . $specifications_id . "'
                                 and language_id = '" . $language_id . "'
                            ");
                
                $specification = $_POST['products_specification'][$specifications_id][$language_id];
                if (is_array ($specification) ) {
                  foreach ($specification as $each_specification) {
                    $each_specification = tep_db_prepare_input ($each_specification);
                    if ($each_specification != '') {
                      $sql_data_array = array ('specification' => $each_specification,
                                               'products_id' => $products_id,
                                               'specifications_id' => $specifications_id,
                                               'language_id' => $language_id
                                              );
                  
                      tep_db_perform (TABLE_PRODUCTS_SPECIFICATIONS, $sql_data_array);
                    } // if ($each_specification
                  } // foreach ($specification
                  
                } else {
                  $specification = tep_db_prepare_input ($specification);
                  if ($specification != '') {
                    $sql_data_array = array ('specification' => $specification,
                                             'products_id' => $products_id,
                                             'specifications_id' => $specifications_id,
                                             'language_id' => $language_id
                                            );
                    tep_db_perform (TABLE_PRODUCTS_SPECIFICATIONS, $sql_data_array);
                  } // if ($specification
                } //  if (is_array ... else ...
              } // while ($specifications
            } // if ($count_specificatons
          } // for ($i=0
// End Products Specifications
          
    // START: Extra Fields Contribution
          $extra_fields_query = tep_db_query("SELECT * FROM " . TABLE_PRODUCTS_TO_PRODUCTS_EXTRA_FIELDS . " WHERE products_id = " . (int)$products_id);
          while ($products_extra_fields = tep_db_fetch_array($extra_fields_query)) {
            $extra_product_entry[$products_extra_fields['products_extra_fields_id']] = $products_extra_fields['products_extra_fields_value'];
          }

          if ($_POST['extra_field']) { // Check to see if there are any need to update extra fields.
            foreach ($_POST['extra_field'] as $key=>$val) {
              if (isset($extra_product_entry[$key])) { // an entry exists
                if ($val == '') tep_db_query("DELETE FROM " . TABLE_PRODUCTS_TO_PRODUCTS_EXTRA_FIELDS . " where products_id = " . (int)$products_id . " AND  products_extra_fields_id = " . $key);
                else tep_db_query("UPDATE " . TABLE_PRODUCTS_TO_PRODUCTS_EXTRA_FIELDS . " SET products_extra_fields_value = '" . tep_db_prepare_input($val) . "' WHERE products_id = " . (int)$products_id . " AND  products_extra_fields_id = " . $key);
              }
              else { // an entry does not exist
                if ($val != '') tep_db_query("INSERT INTO " . TABLE_PRODUCTS_TO_PRODUCTS_EXTRA_FIELDS . " (products_id, products_extra_fields_id, products_extra_fields_value) VALUES ('" . (int)$products_id . "', '" . $key . "', '" . tep_db_prepare_input($val) . "')");
              }
            }
          } // Check to see if there are any need to update extra fields.
          // END: Extra Fields Contribution
          
/////////////////////////////////////////////////////////////////////
// BOF: WebMakers.com Added: Update Product Attributes and Sort Order
// Update the changes to the attributes if any changes were made
          // Update Product Attributes

if (ALLOW_ATTRIBUTES_IN_PRODUCT_EDIT_PAGE == 'true') {

          $rows = 0;
          $options_query = tep_db_query("select products_options_id, products_options_name from " . TABLE_PRODUCTS_OPTIONS . " where language_id = '" . $languages_id . "' order by products_options_sort_order, products_options_name");
          while ($options = tep_db_fetch_array($options_query)) {
            $values_query = tep_db_query("select pov.products_options_values_id, pov.products_options_values_name from " . TABLE_PRODUCTS_OPTIONS_VALUES . " pov, " . TABLE_PRODUCTS_OPTIONS_VALUES_TO_PRODUCTS_OPTIONS . " p2p where pov.products_options_values_id = p2p.products_options_values_id and p2p.products_options_id = '" . $options['products_options_id'] . "' and pov.language_id = '" . $languages_id . "' order by pov.products_options_values_name");
            while ($values = tep_db_fetch_array($values_query)) {
              $rows ++;
// original              $attributes_query = tep_db_query("select products_attributes_id, options_values_price, price_prefix from " . TABLE_PRODUCTS_ATTRIBUTES . " where products_id = '" . $products_id . "' and options_id = '" . $options['products_options_id'] . "' and options_values_id = '" . $values['products_options_values_id'] . "'");
              $attributes_query = tep_db_query("select products_attributes_id, options_values_price, price_prefix, products_attributes_weight, products_attributes_weight_prefix, products_options_sort_order from " . TABLE_PRODUCTS_ATTRIBUTES . " where products_id = '" . $products_id . "' and options_id = '" . $options['products_options_id'] . "' and options_values_id = '" . $values['products_options_values_id'] . "'");
              if (tep_db_num_rows($attributes_query) > 0) {
                $attributes = tep_db_fetch_array($attributes_query);
                $attributes_query_download = tep_db_query("select pad.products_attributes_id, pad.products_attributes_filename, pad.products_attributes_maxdays, pad.products_attributes_maxcount from " . TABLE_PRODUCTS_ATTRIBUTES_DOWNLOAD . " pad where pad.products_attributes_id = '" . $attributes['products_attributes_id'] . "'");
                $attributes_download = tep_db_fetch_array($attributes_query_download);
                if ($_POST['option'][$rows]) {

                  if ( ($_POST['prefix'][$rows] <> $attributes['price_prefix']) || ($_POST['products_attributes_weight'][$rows] <> $attributes['products_attributes_weight']) || ($_POST['products_attributes_weight_prefix'][$rows] <> $attributes['products_attributes_weight_prefix']) || ($_POST['price'][$rows] <> $attributes['options_values_price']) || ($_POST['products_options_sort_order'][$rows] <> $attributes['products_options_sort_order']) ) {

                    tep_db_query("update " . TABLE_PRODUCTS_ATTRIBUTES . " set options_values_price = '" . $_POST['price'][$rows] . "', price_prefix = '" . $_POST['prefix'][$rows] . "', products_options_sort_order = '" . $_POST['products_options_sort_order'][$rows] . "', product_attributes_one_time = '" . $_POST['product_attributes_one_time'][$rows] . "', products_attributes_weight = '" . $_POST['products_attributes_weight'][$rows] . "', products_attributes_weight_prefix = '" . $_POST['products_attributes_weight_prefix'][$rows] . "', products_attributes_units = '" . $_POST['products_attributes_units'][$rows] . "', products_attributes_units_price = '" . $_POST['products_attributes_units_price'][$rows] . "' where products_attributes_id = '" . $attributes['products_attributes_id'] . "'");
                  }

                  if (trim($_POST['filename'][$rows].$_POST['maxdays'][$rows].$_POST['maxcount'][$rows]) != ""){
                  	if (tep_db_num_rows($attributes_query_download) > 0) {
                    	tep_db_query("update " . TABLE_PRODUCTS_ATTRIBUTES_DOWNLOAD . " set products_attributes_filename = '" . $_POST['filename'][$rows] . "', products_attributes_maxdays = '" . $_POST['maxdays'][$rows] . "', products_attributes_maxcount = '" . $_POST['maxcount'][$rows] . "' where products_attributes_id = '" . $attributes['products_attributes_id'] . "'");
                  	} else {
                  		tep_db_query("insert into " . TABLE_PRODUCTS_ATTRIBUTES_DOWNLOAD . " values ('" . $attributes['products_attributes_id'] ."', '" . $_POST['filename'][$rows] . "', '" . $_POST['maxdays'][$rows] . "', '" . $_POST['maxcount'][$rows] . "')");
                  	}
                  } elseif (tep_db_num_rows($attributes_query_download) > 0) {
                    tep_db_query("delete from " . TABLE_PRODUCTS_ATTRIBUTES_DOWNLOAD . " where products_attributes_id = '" . $attributes['products_attributes_id'] . "'");
                  }

                } else {
                  tep_db_query("delete from " . TABLE_PRODUCTS_ATTRIBUTES . " where products_attributes_id = '" . $attributes['products_attributes_id'] . "'");
                  tep_db_query("delete from " . TABLE_PRODUCTS_ATTRIBUTES_DOWNLOAD . " where products_attributes_id = '" . $attributes['products_attributes_id'] . "'");
                }
              } elseif ($_POST['option'][$rows]) {
                tep_db_query("insert into " . TABLE_PRODUCTS_ATTRIBUTES . " values ('', '" . $products_id . "', '" . $options['products_options_id'] . "', '" . $values['products_options_values_id'] . "', '" . $_POST['price'][$rows] . "', '" . $_POST['prefix'][$rows] . "', '" . $_POST['products_options_sort_order'][$rows] . "', '" . $_POST['product_attributes_one_time'][$rows] . "', '" . $_POST['products_attributes_weight'][$rows] . "', '" . $_POST['products_attributes_weight_prefix'][$rows] . "', '" . $_POST['products_attributes_units'][$rows] . "', '" . $_POST['products_attributes_units_price'][$rows] . "' )");
                if (trim($_POST['filename'][$rows].$_POST['maxdays'][$rows].$_POST['maxcount'][$rows]) != ""){
               		tep_db_query("insert into " . TABLE_PRODUCTS_ATTRIBUTES_DOWNLOAD . " values (last_insert_id(), '" . $_POST['filename'][$rows] . "', '" . $_POST['maxdays'][$rows] . "', '" . $_POST['maxcount'][$rows] . "')");
               	}

              }
            }
          }
          
}          
          
// EOF: WebMakers.com Added: Update Product Attributes and Sort Order
/////////////////////////////////////////////////////////////////////

          if (USE_CACHE == 'true') {
            tep_reset_cache_block('categories');
            tep_reset_cache_block('also_purchased');
          }

          tep_redirect(tep_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . '&pID=' . $products_id));
        }
        break;
      case 'copy_to_confirm':
        if (isset($_POST['products_id']) && isset($_POST['categories_id'])) {
          $products_id = tep_db_prepare_input($_POST['products_id']);
          $categories_id = tep_db_prepare_input($_POST['categories_id']);

          if ($_POST['copy_as'] == 'link') {
            if ($categories_id != $current_category_id) {
              $check_query = tep_db_query("select count(*) as total from " . TABLE_PRODUCTS_TO_CATEGORIES . " where products_id = '" . (int)$products_id . "' and categories_id = '" . (int)$categories_id . "'");
              $check = tep_db_fetch_array($check_query);
              if ($check['total'] < '1') {
                tep_db_query("insert into " . TABLE_PRODUCTS_TO_CATEGORIES . " (products_id, categories_id) values ('" . (int)$products_id . "', '" . (int)$categories_id . "')");
              }
            } else {
              $messageStack->add_session(ERROR_CANNOT_LINK_TO_SAME_CATEGORY, 'error');
            }
          } elseif ($_POST['copy_as'] == 'duplicate') {
// BOF MaxiDVD: Modified For Ultimate Images Pack!
$products_price_list = tep_xppp_getpricelist("");
            $product_query = tep_db_query("select products_quantity, products_model, products_image, products_image_med, products_image_lrg, products_image_sm_1, products_image_xl_1, products_image_sm_2, products_image_xl_2, products_image_sm_3, products_image_xl_3, products_image_sm_4, products_image_xl_4, products_image_sm_5, products_image_xl_5, products_image_sm_6, products_image_xl_6, ". $products_price_list . ", products_date_available, products_weight, products_tax_class_id, products_quantity_order_min, products_quantity_order_units, products_sort_order, manufacturers_id from " . TABLE_PRODUCTS . " where products_id = '" . (int)$products_id . "'");

            $product = tep_db_fetch_array($product_query);

			//TotalB2B start
			$prices_num = tep_xppp_getpricesnum();
			for($i=2; $i<=$prices_num; $i++) {
			   if ($product['products_price_' . $i] == NULL) $products_instval .= "NULL, ";
			   else $products_instval .= "'" . tep_db_input($product['products_price_' . $i]) . "', ";
			}
			$products_instval .= "'" . tep_db_input($product['products_price']) . "' ";
            tep_db_query("insert into " . TABLE_PRODUCTS . " (products_quantity, products_model, products_image, products_image_med, products_image_lrg, products_image_sm_1, products_image_xl_1, products_image_sm_2, products_image_xl_2, products_image_sm_3, products_image_xl_3, products_image_sm_4, products_image_xl_4, products_image_sm_5, products_image_xl_5, products_image_sm_6, products_image_xl_6, ". $products_price_list . ", products_date_added, products_date_available, products_weight, products_status, products_tax_class_id, products_quantity_order_min, products_quantity_order_units, products_sort_order, manufacturers_id) values ('" . tep_db_input($product['products_quantity']) . "', '" . tep_db_input($product['products_model']) . "', '" . tep_db_input($product['products_image']) . "', '" . tep_db_input($product['products_image_med']) . "', '" . tep_db_input($product['products_image_lrg']) . "', '" . tep_db_input($product['products_image_sm_1']) . "', '" . tep_db_input($product['products_image_xl_1']) . "', '" . tep_db_input($product['products_image_sm_2']) . "', '" . tep_db_input($product['products_image_xl_2']) . "', '" . tep_db_input($product['products_image_sm_3']) . "', '" . tep_db_input($product['products_image_xl_3']) . "', '" . tep_db_input($product['products_image_sm_4']) . "', '" . tep_db_input($product['products_image_xl_4']) . "', '" . tep_db_input($product['products_image_sm_5']) . "', '" . tep_db_input($product['products_image_xl_5']) . "', '" . tep_db_input($product['products_image_sm_6']) . "', '" . tep_db_input($product['products_image_xl_6']) . "', " . $products_instval . ",  now(), " . (empty($product['products_date_available']) ? "null" : "'" . tep_db_input($product['products_date_available']) . "'") . ", '" . tep_db_input($product['products_weight']) . "', '0', '" . (int)$product['products_tax_class_id'] . "', '" . (int)$product['products_quantity_order_min'] . "', '" . (int)$product['products_quantity_order_units'] . "', '" . (int)$product['products_sort_order'] . "', '" . (int)$product['manufacturers_id'] . "')");
            //TotalB2B end
// BOF MaxiDVD: Modified For Ultimate Images Pack!
            $dup_products_id = tep_db_insert_id();

            $description_query = tep_db_query("select language_id, products_name, products_info, products_description, products_head_title_tag, products_head_desc_tag, products_head_keywords_tag, products_url, products_tab_1, products_tab_2, products_tab_3, products_tab_4, products_tab_5, products_tab_6 from " . TABLE_PRODUCTS_DESCRIPTION . " where products_id = '" . (int)$products_id . "'");
            while ($description = tep_db_fetch_array($description_query)) {
              tep_db_query("insert into " . TABLE_PRODUCTS_DESCRIPTION . " (products_id, language_id, products_name, products_info, products_description, products_head_title_tag, products_head_desc_tag, products_head_keywords_tag, products_url, products_tab_1, products_tab_2, products_tab_3, products_tab_4, products_tab_5, products_tab_6, products_viewed) values ('" . (int)$dup_products_id . "', '" . (int)$description['language_id'] . "', '" . tep_db_input($description['products_name']) . "', '". tep_db_input($description['products_info']) . "', '" . tep_db_input($description['products_description']) . "', '" . tep_db_input($description['products_head_title_tag']) . "', '" . tep_db_input($description['products_head_desc_tag']) . "', '" . tep_db_input($description['products_head_keywords_tag']) . "', '" . tep_db_input($description['products_url']) . "', '" . tep_db_input ($description['products_tab_1']) . "', '" . tep_db_input ($description['products_tab_2']) . "', '" . tep_db_input ($description['products_tab_3']) . "', '" . tep_db_input ($description['products_tab_4']) . "', '" . tep_db_input ($description['products_tab_5']) . "', '" . tep_db_input ($description['products_tab_6']) . "', '0')");
            }

            tep_db_query("insert into " . TABLE_PRODUCTS_TO_CATEGORIES . " (products_id, categories_id) values ('" . (int)$dup_products_id . "', '" . (int)$categories_id . "')");
            
// Start Products Specifications
            $specifications_query = tep_db_query ("select specifications_id, 
                                                          language_id, 
                                                          specification 
                                                   from " . TABLE_PRODUCTS_SPECIFICATIONS . " 
                                                   where products_id = '" . (int)$products_id . "'
                                                 ");
            while ($specifications = tep_db_fetch_array ($specifications_query) ) {
              tep_db_query ("insert into " . TABLE_PRODUCTS_SPECIFICATIONS . " (
                                         products_id,
                                         specifications_id, 
                                         language_id, 
                                         specification) values (
                                         '" . (int) $dup_products_id . "', 
                                         '" . (int) $specifications['specification_description_id'] . "', 
                                         '" . (int)$specifications['language_id'] . "', 
                                         '" . tep_db_input ($specifications['specification']) . "')
                           ");
            } // while ($specifications
// End Products Specifications
            
// BOF: WebMakers.com Added: Attributes Copy on non-linked
            $products_id_from=tep_db_input($products_id);
            $products_id_to= $dup_products_id;
            $products_id = $dup_products_id;
if ( $_POST['copy_attributes']=='copy_attributes_yes' and $_POST['copy_as'] == 'duplicate' ) {
// WebMakers.com Added: Copy attributes to duplicate product
  // $products_id_to= $copy_to_products_id;
  // $products_id_from = $pID;
            $copy_attributes_delete_first='1';
            $copy_attributes_duplicates_skipped='1';
            $copy_attributes_duplicates_overwrite='0';

            if (DOWNLOAD_ENABLED == 'true') {
              $copy_attributes_include_downloads='1';
              $copy_attributes_include_filename='1';
            } else {
              $copy_attributes_include_downloads='0';
              $copy_attributes_include_filename='0';
            }
            tep_copy_products_attributes($products_id_from,$products_id_to);
// EOF: WebMakers.com Added: Attributes Copy on non-linked
}
          }

          if (USE_CACHE == 'true') {
            tep_reset_cache_block('categories');
            tep_reset_cache_block('also_purchased');
          }
        }

        tep_redirect(tep_href_link(FILENAME_CATEGORIES, 'cPath=' . $categories_id . '&pID=' . $products_id));
        break;
// BOF MaxiDVD: Modified For Ultimate Images Pack!
      case 'new_product_preview':
// copy image only if modified
   if (($_POST['unlink_image'] == 'yes') or ($_POST['delete_image'] == 'yes')) {
        $products_image = '';
        $products_image_name = '';
        } else {
        $products_image = new upload('products_image');
        $products_image->set_destination(DIR_FS_CATALOG_IMAGES . $_POST['img_dir']);
        if ($products_image->parse() && $products_image->save($_POST['overwrite'])) {
          $products_image_name = $_POST['img_dir'] . $products_image->filename;
        } else {
          $products_image_name = (isset($_POST['products_previous_image']) ? $_POST['products_previous_image'] : '');
        }
}

   if (($_POST['unlink_image_med'] == 'yes') or ($_POST['delete_image_med'] == 'yes')) {
        $products_image_med = '';
        $products_image_med_name = '';
        } else {
        $products_image_med = new upload('products_image_med');
        $products_image_med->set_destination(DIR_FS_CATALOG_IMAGES . $_POST['img_dir_med']);
        if ($products_image_med->parse() && $products_image_med->save($_POST['overwrite_med'])) {
          $products_image_med_name = $_POST['img_dir_med'] . $products_image_med->filename;
        } else {
          $products_image_med_name = (isset($_POST['products_previous_image_med']) ? $_POST['products_previous_image_med'] : '');
        }
}

   if (($_POST['unlink_image_lrg'] == 'yes') or ($_POST['delete_image_lrg'] == 'yes')) {
        $products_image_lrg = '';
        $products_image_lrg_name = '';
        } else {
        $products_image_lrg = new upload('products_image_lrg');
        $products_image_lrg->set_destination(DIR_FS_CATALOG_IMAGES . $_POST['img_dir_lrg']);
        if ($products_image_lrg->parse() && $products_image_lrg->save($_POST['overwrite_lrg'])) {
          $products_image_lrg_name = $_POST['img_dir_lrg'] . $products_image_lrg->filename;
        } else {
          $products_image_lrg_name = (isset($_POST['products_previous_image_lrg']) ? $_POST['products_previous_image_lrg'] : '');
        }
}        

   if (($_POST['unlink_image_sm_1'] == 'yes') or ($_POST['delete_image_sm_1'] == 'yes')) {
        $products_image_sm_1 = '';
        $products_image_sm_1_name = '';
        } else {
        $products_image_sm_1 = new upload('products_image_sm_1');
        $products_image_sm_1->set_destination(DIR_FS_CATALOG_IMAGES . $_POST['img_dir_sm_1']);
        if ($products_image_sm_1->parse() && $products_image_sm_1->save($_POST['overwrite_sm_1'])) {
          $products_image_sm_1_name = $_POST['img_dir_sm_1'] . $products_image_sm_1->filename;
        } else {
          $products_image_sm_1_name = (isset($_POST['products_previous_image_sm_1']) ? $_POST['products_previous_image_sm_1'] : '');
        }
        }    if (($_POST['unlink_image_xl_1'] == 'yes') or ($_POST['delete_image_xl_1'] == 'yes')) {
        $products_image_xl_1 = '';
        $products_image_xl_1_name = '';
        } else {
        $products_image_xl_1 = new upload('products_image_xl_1');
        $products_image_xl_1->set_destination(DIR_FS_CATALOG_IMAGES . $_POST['img_dir_xl_1']);
        if ($products_image_xl_1->parse() && $products_image_xl_1->save($_POST['overwrite_xl_1'])) {
          $products_image_xl_1_name = $_POST['img_dir_xl_1'] . $products_image_xl_1->filename;
        } else {
          $products_image_xl_1_name = (isset($_POST['products_previous_image_xl_1']) ? $_POST['products_previous_image_xl_1'] : '');
        }
        }
   if (($_POST['unlink_image_sm_2'] == 'yes') or ($_POST['delete_image_sm_2'] == 'yes')) {
        $products_image_sm_2 = '';
        $products_image_sm_2_name = '';
        } else {
        $products_image_sm_2 = new upload('products_image_sm_2');
        $products_image_sm_2->set_destination(DIR_FS_CATALOG_IMAGES . $_POST['img_dir_sm_2']);
        if ($products_image_sm_2->parse() && $products_image_sm_2->save($_POST['overwrite_sm_2'])) {
          $products_image_sm_2_name = $_POST['img_dir_sm_2'] . $products_image_sm_2->filename;
        } else {
          $products_image_sm_2_name = (isset($_POST['products_previous_image_sm_2']) ? $_POST['products_previous_image_sm_2'] : '');
        }
        }
   if (($_POST['unlink_image_xl_2'] == 'yes') or ($_POST['delete_image_xl_2'] == 'yes')) {
        $products_image_xl_2 = '';
        $products_image_xl_2_name = '';
        } else {
        $products_image_xl_2 = new upload('products_image_xl_2');
        $products_image_xl_2->set_destination(DIR_FS_CATALOG_IMAGES . $_POST['img_dir_xl_2']);
        if ($products_image_xl_2->parse() && $products_image_xl_2->save($_POST['overwrite_xl_2'])) {
          $products_image_xl_2_name = $_POST['img_dir_xl_2'] . $products_image_xl_2->filename;
        } else {
          $products_image_xl_2_name = (isset($_POST['products_previous_image_xl_2']) ? $_POST['products_previous_image_xl_2'] : '');
        }
        }
   if (($_POST['unlink_image_sm_3'] == 'yes') or ($_POST['delete_image_sm_3'] == 'yes')) {
        $products_image_sm_3 = '';
        $products_image_sm_3_name = '';
        } else {
        $products_image_sm_3 = new upload('products_image_sm_3');
        $products_image_sm_3->set_destination(DIR_FS_CATALOG_IMAGES . $_POST['img_dir_sm_3']);
        if ($products_image_sm_3->parse() && $products_image_sm_3->save($_POST['overwrite_sm_3'])) {
          $products_image_sm_3_name = $_POST['img_dir_sm_3'] . $products_image_sm_3->filename;
        } else {
          $products_image_sm_3_name = (isset($_POST['products_previous_image_sm_3']) ? $_POST['products_previous_image_sm_3'] : '');
        }
        }
   if (($_POST['unlink_image_xl_3'] == 'yes') or ($_POST['delete_image_xl_3'] == 'yes')) {
        $products_image_xl_3 = '';
        $products_image_xl_3_name = '';
        } else {
        $products_image_xl_3 = new upload('products_image_xl_3');
        $products_image_xl_3->set_destination(DIR_FS_CATALOG_IMAGES . $_POST['img_dir_xl_3']);
        if ($products_image_xl_3->parse() && $products_image_xl_3->save($_POST['overwrite_xl_3'])) {
          $products_image_xl_3_name = $_POST['img_dir_xl_3'] . $products_image_xl_3->filename;
        } else {
          $products_image_xl_3_name = (isset($_POST['products_previous_image_xl_3']) ? $_POST['products_previous_image_xl_3'] : '');
        }
        }
   if (($_POST['unlink_image_sm_4'] == 'yes') or ($_POST['delete_image_sm_4'] == 'yes')) {
        $products_image_sm_4 = '';
        $products_image_sm_4_name = '';
        } else {
        $products_image_sm_4 = new upload('products_image_sm_4');
        $products_image_sm_4->set_destination(DIR_FS_CATALOG_IMAGES . $_POST['img_dir_sm_4']);
        if ($products_image_sm_4->parse() && $products_image_sm_4->save($_POST['overwrite_sm_4'])) {
          $products_image_sm_4_name = $_POST['img_dir_sm_4'] . $products_image_sm_4->filename;
        } else {
          $products_image_sm_4_name = (isset($_POST['products_previous_image_sm_4']) ? $_POST['products_previous_image_sm_4'] : '');
        }
        }
   if (($_POST['unlink_image_xl_4'] == 'yes') or ($_POST['delete_image_xl_4'] == 'yes')) {
        $products_image_xl_4 = '';
        $products_image_xl_4_name = '';
        } else {
        $products_image_xl_4 = new upload('products_image_xl_4');
        $products_image_xl_4->set_destination(DIR_FS_CATALOG_IMAGES . $_POST['img_dir_xl_4']);
        if ($products_image_xl_4->parse() && $products_image_xl_4->save($_POST['overwrite_xl_4'])) {
          $products_image_xl_4_name = $_POST['img_dir_xl_4'] . $products_image_xl_4->filename;
        } else {           $products_image_xl_4_name = (isset($_POST['products_previous_image_xl_4']) ? $_POST['products_previous_image_xl_4'] : '');
        }
        }
   if (($_POST['unlink_image_sm_5'] == 'yes') or ($_POST['delete_image_sm_5'] == 'yes')) {
        $products_image_sm_5 = '';
        $products_image_sm_5_name = '';
        } else {
        $products_image_sm_5 = new upload('products_image_sm_5');
        $products_image_sm_5->set_destination(DIR_FS_CATALOG_IMAGES . $_POST['img_dir_sm_5']);
        if ($products_image_sm_5->parse() && $products_image_sm_5->save($_POST['overwrite_sm_5'])) {
          $products_image_sm_5_name = $_POST['img_dir_sm_5'] . $products_image_sm_5->filename;
        } else {
          $products_image_sm_5_name = (isset($_POST['products_previous_image_sm_5']) ? $_POST['products_previous_image_sm_5'] : '');
        }
        }
   if (($_POST['unlink_image_xl_5'] == 'yes') or ($_POST['delete_image_xl_5'] == 'yes')) {
        $products_image_xl_5 = '';
        $products_image_xl_5_name = '';
        } else {
        $products_image_xl_5 = new upload('products_image_xl_5');
        $products_image_xl_5->set_destination(DIR_FS_CATALOG_IMAGES . $_POST['img_dir_xl_5']);
        if ($products_image_xl_5->parse() && $products_image_xl_5->save($_POST['overwrite_xl_5'])) {
          $products_image_xl_5_name = $_POST['img_dir_xl_5'] . $products_image_xl_5->filename;
        } else {
          $products_image_xl_5_name = (isset($_POST['products_previous_image_xl_5']) ? $_POST['products_previous_image_xl_5'] : '');
        }
        }
   if (($_POST['unlink_image_sm_6'] == 'yes') or ($_POST['delete_image_sm_6'] == 'yes')) {
        $products_image_sm_6 = '';
        $products_image_sm_6_name = '';
        } else {
        $products_image_sm_6 = new upload('products_image_sm_6');
        $products_image_sm_6->set_destination(DIR_FS_CATALOG_IMAGES . $_POST['img_dir_sm_6']);
         if ($products_image_sm_6->parse() && $products_image_sm_6->save($_POST['overwrite_sm_6'])) {
          $products_image_sm_6_name = $_POST['img_dir_sm_6'] . $products_image_sm_6->filename;
        } else {
          $products_image_sm_6_name = (isset($_POST['products_previous_image_sm_6']) ? $_POST['products_previous_image_sm_6'] : '');
        }
        }
   if (($_POST['unlink_image_xl_6'] == 'yes') or ($_POST['delete_image_xl_6'] == 'yes')) {
        $products_image_xl_6 = '';
        $products_image_xl_6_name = '';
        } else {
        $products_image_xl_6 = new upload('products_image_xl_6');
        $products_image_xl_6->set_destination(DIR_FS_CATALOG_IMAGES . $_POST['img_dir_xl_6']);
        if ($products_image_xl_6->parse() && $products_image_xl_6->save($_POST['overwrite_xl_6'])) {
          $products_image_xl_6_name = $_POST['img_dir_xl_6'] . $products_image_xl_6->filename;
        } else {
          $products_image_xl_6_name = (isset($_POST['products_previous_image_xl_6']) ? $_POST['products_previous_image_xl_6'] : '');
        }
        }
        break;
// EOF MaxiDVD: Modified For Ultimate Images Pack!
    }
  }

// check if the catalog image directory exists
  if (is_dir(DIR_FS_CATALOG_IMAGES)) {
    if (!is_writeable(DIR_FS_CATALOG_IMAGES)) $messageStack->add(ERROR_CATALOG_IMAGE_DIRECTORY_NOT_WRITEABLE, 'error');
  } else {
    $messageStack->add(ERROR_CATALOG_IMAGE_DIRECTORY_DOES_NOT_EXIST, 'error');
  }
?>
<?php
// WebMakers.com Added: Display Order
  switch (true) {
    case (CATEGORIES_SORT_ORDER=="products_name"):
      $order_it_by = "pd.products_name";
      break;
    case (CATEGORIES_SORT_ORDER=="products_name-desc"):
      $order_it_by = "pd.products_name DESC";
      break;
    case (CATEGORIES_SORT_ORDER=="model"):
      $order_it_by = "p.products_model";
      break;
    case (CATEGORIES_SORT_ORDER=="model-desc"):
      $order_it_by = "p.products_model DESC";
      break;
    default:
      $order_it_by = "pd.products_name";
      break;
    }
?>

<?php
$go_back_to=$REQUEST_URI;
?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<title><?php echo TITLE; ?> 11</title>
<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
<123>123</123>
<script language="javascript" type="text/javascript" src="includes/javascript/categories.js"></script>
<?php
  if (HTML_AREA_WYSIWYG_DISABLE == 'Enable') { 
?>
<script language="javascript" type="text/javascript" src="includes/javascript/tiny_mce/tiny_mce.js"></script>
<script language="javascript" type="text/javascript" src="includes/javascript/tiny_mce/plugins/tinybrowser/tb_tinymce.js.php"></script>
<script language="javascript" type="text/javascript">
tinyMCE.init({
	mode : "textareas",
	editor_deselector : "notinymce",
	extended_valid_elements : "script[type|src],iframe[src|style|width|height|scrolling|marginwidth|marginheight|frameborder],div[*],p[*],object[width|height|classid|codebase|embed|param],param[name|value],embed[param|src|type|width|height|flashvars|wmode]",
	theme : "advanced",
	width : 650,
	height : 300,
	language : "<?php echo DEFAULT_LANGUAGE; ?>",
	paste_create_paragraphs : false,
	paste_create_linebreaks : false,
	paste_use_dialog : true,
	convert_urls : false,

	plugins : "safari,typograf,spellchecker,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,imagemanager,filemanager",

	file_browser_callback : "tinyBrowser",

	spellchecker_languages : "+Russian=ru,English=en",
	spellchecker_rpc_url : "<?php echo HTTP_SERVER . DIR_WS_CATALOG; ?>admin/includes/javascript/tiny_mce/plugins/spellchecker/rpc_proxy.php",

	// Theme options
	theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect",
	theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
	theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
	theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,spellchecker,typograf,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,blockquote,pagebreak,|,insertfile,insertimage",
	theme_advanced_toolbar_location : "top",
	theme_advanced_toolbar_align : "left",
	theme_advanced_statusbar_location : "bottom",
	theme_advanced_resizing : true

});
</script>
<?php } ?>
<script language="javascript" src="includes/menu.js"></script>
<?php
// Start Products Specifications
  if (SPECIFICATIONS_BOX_FRAME_STYLE == 'Tabs') {
?>
  <link href="includes/style_tabs.css" rel="stylesheet" type="text/css">
  <script language="javascript" type="text/javascript" src="includes/functions/jquery-1.3.2.min.js"></script> 
  <script language="javascript" type="text/javascript">
    $(document).ready(function(){  
      initTabs();  
    });  
  
    function initTabs() {  
      $('#tabMenu a').bind('click',function(e) {  
      e.preventDefault();  
      var thref = $(this).attr("href").replace(/#/, '');  
      $('#tabMenu a').removeClass('active');  
      $(this).addClass('active');  
      $('#tabContent div.content').removeClass('active');  
      $('#'+thref).addClass('active');  
      });  
    }  
  </script> 
<?php
  }
// End Products Specifications
?>
<script language="javascript" src="includes/general.js"></script>
<?php
  if (ENABLE_TABS == 'true') { 
?>
		<link type="text/css" href="../jscript/jquery/plugins/ui/css/smoothness/jquery-ui-1.7.2.custom.css" rel="stylesheet" />	
		<script type="text/javascript" src="../jscript/jquery/jquery.js"></script>
		<script type="text/javascript" src="../jscript/jquery/plugins/ui/jquery-ui-1.7.2.custom.min.js"></script>
		<script type="text/javascript">
			$(function(){
				$('#tabs').tabs();
			});
		</script>
<?php } ?>
<script language="javascript"><!--
function popupWindow1(url) {
  window.open(url,'popupWindow','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=no,resizable=yes,copyhistory=no,width=900,height=600')
}
//--></script>
<script language="javascript"><!--
function popupWindow(url) {
  window.open(url,'popupWindow','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=no,resizable=yes,copyhistory=no,width=100,height=100,screenX=150,screenY=150,top=150,left=150')
}
//--></script>
<script>
var number;
var number1 = "]";
var number2 = "filename[";
</script>

<?php
// WebMakers.com Added: Java Scripts - popup window
include(DIR_WS_INCLUDES . 'javascript/' . 'webmakers_added_js.php')
?>

</head>
<body marginwidth="0" marginheight="0" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0" bgcolor="#FFFFFF">
<script language="javascript"><!--
function popupPropertiesWindow(url) {
  window.open(url,'popupPropertiesWindow','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,copyhistory=no,width=800,height=600,screenX=112,screenY=112,top=70,left=112')
}
//--></script>

<div id="spiffycalendar" class="text"></div>
<!-- header //-->
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
<!-- header_eof //-->

<!-- body //-->
<table border="0" width="100%" cellspacing="2" cellpadding="2">
  <tr>
    <td width="<?php echo BOX_WIDTH; ?>" valign="top"><table border="0" width="<?php echo BOX_WIDTH; ?>" cellspacing="1" cellpadding="1" class="columnLeft">
<!-- left_navigation //-->
<?php require(DIR_WS_INCLUDES . 'column_left.php'); ?>
<!-- left_navigation_eof //-->
    </table></td>
	<!-- body_text //-->
	     <td width="100%" valign="top"><table class="table-padding-2">
	<?php   //----- new_category / edit_category (when ALLOW_CATEGORY_DESCRIPTIONS is 'true') -----
  if ($_GET['action'] == 'new_category_ACD' || $_GET['action'] == 'edit_category_ACD') {
    if ( ($_GET['cID']) && (!$_POST) ) {
      $categories_query = tep_db_query("select c.categories_id, c.categories_status, cd.categories_name, cd.categories_heading_title, cd.categories_description,  cd.categories_meta_title, cd.categories_meta_description, cd.categories_meta_keywords, c.categories_image, c.parent_id, c.sort_order, c.date_added, c.last_modified from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd where c.categories_id = '" . $_GET['cID'] . "' and c.categories_id = cd.categories_id and cd.language_id = '" . $languages_id . "' order by c.sort_order, cd.categories_name");
      $category = tep_db_fetch_array($categories_query);


      $cInfo = new objectInfo($category);
    } elseif ($_POST) {
      $cInfo = new objectInfo($_POST);
      $categories_name = $_POST['categories_name'];
      $categories_heading_title = $_POST['categories_heading_title'];
      $categories_description = $_POST['categories_description'];
      $categories_meta_title = $_POST['categories_meta_title'];
      $categories_meta_description = $_POST['categories_meta_description'];
      $categories_meta_keywords = $_POST['categories_meta_keywords'];
      $categories_url = $_POST['categories_url'];

    } else {
      $cInfo = new objectInfo(array());
    }

    $languages = tep_get_languages();

    $text_new_or_edit = ($_GET['action']=='new_category_ACD') ? TEXT_INFO_HEADING_NEW_CATEGORY : TEXT_INFO_HEADING_EDIT_CATEGORY;
?>
      <tr>
        <td><table class="table-padding-0">
          <tr>
            <td class="pageHeading"><?php echo sprintf($text_new_or_edit, tep_output_generated_category_path($current_category_id)); ?></td>
            <td class="pageHeading" align="right"><?php echo tep_draw_separator('pixel_trans.gif', HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
      <tr>
        <td>

<?php echo tep_draw_form('new_category', FILENAME_CATEGORIES, 'cPath=' . $cPath . '&cID=' . $_GET['cID'] . '&action=new_category_preview', 'post', 'enctype="multipart/form-data"'); ?>

<?php echo tep_draw_hidden_field('categories_date_added', (($cInfo->date_added) ? $cInfo->date_added : date('Y-m-d'))) . tep_draw_hidden_field('parent_id', $cInfo->parent_id) . tep_image_submit('button_preview.gif', IMAGE_PREVIEW) . '&nbsp;&nbsp;<a href="' . tep_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . '&cID=' . $_GET['cID']) . '">' . tep_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>'; ?>
              
<div id="tabs">

			<ul>
<?php
    for ($i=0; $i<sizeof($languages); $i++) {
?>
				<li><a href="#tab<?php echo $i; ?>"><?php echo $languages[$i]['name']; ?></a></li>
<?php 
}
?>
				<li><a href="#data"><?php echo TEXT_PRODUCTS_DATA; ?></a></li>
				<li><a href="#images"><?php echo TEXT_TAB_CATEGORIES_IMAGE; ?></a></li>
			</ul>

<?php
    for ($i=0; $i<sizeof($languages); $i++) {
?>
<!-- ��������� -->
        <div id="tab<?php echo $i; ?>">
          <table border="0" class="main">

          <tr>
            <td class="main"><?php echo TEXT_EDIT_CATEGORIES_NAME; ?></td>
            <td class="main"><?php echo tep_draw_input_field('categories_name[' . $languages[$i]['id'] . ']', (($categories_name[$languages[$i]['id']]) ? stripslashes($categories_name[$languages[$i]['id']]) : tep_get_category_name($cInfo->categories_id, $languages[$i]['id']))); ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo TEXT_EDIT_CATEGORIES_HEADING_TITLE; ?></td>
            <td class="main"><?php echo tep_draw_input_field('categories_heading_title[' . $languages[$i]['id'] . ']', (($categories_name[$languages[$i]['id']]) ? stripslashes($categories_name[$languages[$i]['id']]) : tep_get_category_heading_title($cInfo->categories_id, $languages[$i]['id']))); ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
          <tr>
            <td class="main" valign="top"><?php echo TEXT_EDIT_CATEGORIES_DESCRIPTION; ?></td>
            <td><table border="0" cellspacing="0" cellpadding="0">
              <tr>
<td class="main">

<?php
          echo tep_draw_textarea_field('categories_description[' . $languages[$i]['id'] . ']', 'soft', '70', '15', (($categories_description[$languages[$i]['id']]) ? stripslashes($categories_description[$languages[$i]['id']]) : tep_get_category_description($cInfo->categories_id, $languages[$i]['id'])));
?>

</td>
              </tr>
            </table></td>
          </tr>


<!-- NEW META -->

          <tr>
            <td class="main"><?php echo TEXT_META_TITLE; ?></td>
            <td class="main"><?php echo tep_draw_input_field('categories_meta_title[' . $languages[$i]['id'] . ']', (($categories_meta_title[$languages[$i]['id']]) ? stripslashes($categories_meta_title[$languages[$i]['id']]) : tep_get_category_meta_title($cInfo->categories_id, $languages[$i]['id']))); ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo TEXT_META_DESCRIPTION; ?></td>
            <td class="main"><?php echo tep_draw_input_field('categories_meta_description[' . $languages[$i]['id'] . ']', (($categories_meta_description[$languages[$i]['id']]) ? stripslashes($categories_meta_description[$languages[$i]['id']]) : tep_get_category_meta_description($cInfo->categories_id, $languages[$i]['id']))); ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo TEXT_META_KEYWORDS; ?></td>
            <td class="main"><?php echo tep_draw_input_field('categories_meta_keywords[' . $languages[$i]['id'] . ']', (($categories_meta_keywords[$languages[$i]['id']]) ? stripslashes($categories_meta_keywords[$languages[$i]['id']]) : tep_get_category_meta_keywords($cInfo->categories_id, $languages[$i]['id']))); ?></td>
          </tr>

<!-- /NEW META -->
          </table>
        </div>
<?php } ?>
<!-- /��������� -->

<!-- info -->
        <div id="data">
          <table border="0" class="main">
          
          <tr>
          <tr>
            <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo TEXT_EDIT_SORT_ORDER; ?></td>
            <td class="main"><?php echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_input_field('sort_order', $cInfo->sort_order, 'size="2"'); ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo TEXT_EDIT_STATUS; ?></td>
            <td class="main"><?php echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_input_field('categories_status', $cInfo->categories_status, 'size="2"'); ?>&nbsp;<?php echo TEXT_DEFINE_CATEGORY_STATUS; ?></td>
          </tr>

        </table>
        </div>
<!-- info -->

<!-- �������� -->
        <div id="images">
          <table border="0">
          
          <tr>
            <td class="main" valign="top"><?php echo TEXT_EDIT_CATEGORIES_IMAGE; ?></td>
            <td class="main"><?php echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_file_field('categories_image') . '<br>' . tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . $cInfo->categories_image . tep_draw_hidden_field('categories_previous_image', $cInfo->categories_image); ?></td>
          </tr>
          
        </table>
      </form>
        </div>

</div>      
<?php
  //----- new_category_preview (active when ALLOW_CATEGORY_DESCRIPTIONS is 'true') -----
  } elseif ($_GET['action'] == 'new_category_preview') {
    if ($_POST) {
      $cInfo = new objectInfo($_POST);
      $categories_name = $_POST['categories_name'];
      $categories_heading_title = $_POST['categories_heading_title'];
      $categories_description = $_POST['categories_description'];
      $categories_meta_title = $_POST['categories_meta_title'];
      $categories_meta_description = $_POST['categories_meta_description'];
      $categories_meta_keywords = $_POST['categories_meta_keywords'];

// copy image only if modified
        $categories_image = new upload('categories_image');
        $categories_image->set_destination(DIR_FS_CATALOG_IMAGES);
        if ($categories_image->parse() && $categories_image->save()) {
          $categories_image_name = $categories_image->filename;
        } else {
        $categories_image_name = $_POST['categories_previous_image'];
      }
#     if ( ($categories_image != 'none') && ($categories_image != '') ) {
#       $image_location = DIR_FS_CATALOG_IMAGES . $categories_image_name;
#       if (file_exists($image_location)) @unlink($image_location);
#       copy($categories_image, $image_location);
#     } else {
#       $categories_image_name = $_POST['categories_previous_image'];
#     }
    } else {
      $category_query = tep_db_query("select c.categories_id, cd.language_id, cd.categories_name, cd.categories_heading_title, cd.categories_description, cd.categories_meta_title, cd.categories_meta_description, cd.categories_meta_keywords, c.categories_image, c.sort_order, c.date_added, c.last_modified from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd where c.categories_id = cd.categories_id and c.categories_id = '" . $_GET['cID'] . "'");
      $category = tep_db_fetch_array($category_query);

      $cInfo = new objectInfo($category);
      $categories_image_name = $cInfo->categories_image;
    }

    $form_action = ($_GET['cID']) ? 'update_category' : 'insert_category';

    echo tep_draw_form($form_action, FILENAME_CATEGORIES, 'cPath=' . $cPath . '&cID=' . $_GET['cID'] . '&action=' . $form_action, 'post', 'enctype="multipart/form-data"');

    $languages = tep_get_languages();
    for ($i=0; $i<sizeof($languages); $i++) {
      if ($_GET['read'] == 'only') {
        $cInfo->categories_name = tep_get_category_name($cInfo->categories_id, $languages[$i]['id']);
        $cInfo->categories_heading_title = tep_get_category_heading_title($cInfo->categories_id, $languages[$i]['id']);
        $cInfo->categories_description = tep_get_category_description($cInfo->categories_id, $languages[$i]['id']);
        $cInfo->categories_meta_title = tep_get_category_meta_title($cInfo->categories_id, $languages[$i]['id']);
        $cInfo->categories_meta_description = tep_get_category_meta_description($cInfo->categories_id, $languages[$i]['id']);
        $cInfo->categories_meta_keywords = tep_get_category_meta_keywords($cInfo->categories_id, $languages[$i]['id']);
      } else {
        $cInfo->categories_name = tep_db_prepare_input($categories_name[$languages[$i]['id']]);
        $cInfo->categories_heading_title = tep_db_prepare_input($categories_heading_title[$languages[$i]['id']]);
        $cInfo->categories_description = tep_db_prepare_input($categories_description[$languages[$i]['id']]);
        $cInfo->categories_meta_title = tep_db_prepare_input($categories_meta_title[$languages[$i]['id']]);
        $cInfo->categories_meta_description = tep_db_prepare_input($categories_meta_description[$languages[$i]['id']]);
        $cInfo->categories_meta_keywords = tep_db_prepare_input($categories_meta_keywords[$languages[$i]['id']]);
      }
?>
      <tr>
        <td><table class="table-padding-0">
          <tr>
            <td class="pageHeading"><?php echo tep_image(DIR_WS_CATALOG_LANGUAGES . $languages[$i]['directory'] . '/images/' . $languages[$i]['image'], $languages[$i]['name']) . '&nbsp;' . $cInfo->categories_heading_title; ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
      <tr>
        <td class="main"><?php echo tep_image(DIR_WS_CATALOG_IMAGES . $categories_image_name, $cInfo->categories_name, SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT, 'align="right" hspace="5" vspace="5"') . $cInfo->categories_description; ?></td>
      </tr>

<?php
    }
    if ($_GET['read'] == 'only') {
      if ($_GET['origin']) {
        $pos_params = strpos($_GET['origin'], '?', 0);
        if ($pos_params != false) {
          $back_url = substr($_GET['origin'], 0, $pos_params);
          $back_url_params = substr($_GET['origin'], $pos_params + 1);
        } else {
          $back_url = $_GET['origin'];
          $back_url_params = '';
        }
      } else {
        $back_url = FILENAME_CATEGORIES;
        $back_url_params = 'cPath=' . $cPath . '&cID=' . $cInfo->categories_id;
      }
?>
      <tr>
        <td align="right"><?php echo '<a href="' . tep_href_link($back_url, $back_url_params, 'NONSSL') . '">' . tep_image_button('button_back.gif', IMAGE_BACK) . '</a>'; ?></td>
      </tr>
<?php
    } else {
?>
      <tr>
        <td align="right" class="smallText">
<?php
/* Re-Post all POST'ed variables */
      reset($_POST);
      while (list($key, $value) = each($_POST)) {
        if (!is_array($_POST[$key])) {
          echo tep_draw_hidden_field($key, htmlspecialchars(stripslashes($value)));
        }
      }
      $languages = tep_get_languages();
      for ($i=0; $i<sizeof($languages); $i++) {
        echo tep_draw_hidden_field('categories_name[' . $languages[$i]['id'] . ']', htmlspecialchars(stripslashes($categories_name[$languages[$i]['id']])));
        echo tep_draw_hidden_field('categories_heading_title[' . $languages[$i]['id'] . ']', htmlspecialchars(stripslashes($categories_heading_title[$languages[$i]['id']])));
        echo tep_draw_hidden_field('categories_description[' . $languages[$i]['id'] . ']', htmlspecialchars(stripslashes($categories_description[$languages[$i]['id']])));
        echo tep_draw_hidden_field('categories_meta_title[' . $languages[$i]['id'] . ']', htmlspecialchars(stripslashes($categories_meta_title[$languages[$i]['id']])));
        echo tep_draw_hidden_field('categories_meta_description[' . $languages[$i]['id'] . ']', htmlspecialchars(stripslashes($categories_meta_description[$languages[$i]['id']])));
        echo tep_draw_hidden_field('categories_meta_keywords[' . $languages[$i]['id'] . ']', htmlspecialchars(stripslashes($categories_meta_keywords[$languages[$i]['id']])));
      }
      echo tep_draw_hidden_field('X_categories_image', stripslashes($categories_image_name));
      echo tep_draw_hidden_field('categories_image', stripslashes($categories_image_name));

      echo tep_image_submit('button_back.gif', IMAGE_BACK, 'name="edit"') . '&nbsp;&nbsp;';

      if ($_GET['cID']) {
        echo tep_image_submit('button_update.gif', IMAGE_UPDATE);
      } else {
        echo tep_image_submit('button_insert.gif', IMAGE_INSERT);
      }
      echo '&nbsp;&nbsp;<a href="' . tep_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . '&cID=' . $_GET['cID']) . '">' . tep_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>';
?></td>
      </form></tr>
<?php
    }


  } elseif ($action == 'new_product') {
    $parameters = array('products_name' => '',
                       'products_info' => '',
                       'products_description' => '',
// Start Products Specifications
                        'products_tab_1' => '',
                        'products_tab_2' => '',
                        'products_tab_3' => '',
                        'products_tab_4' => '',
                        'products_tab_5' => '',
                        'products_tab_6' => '',
// End Products Specifications
                       'products_url' => '',
                       'products_id' => '',
                       'products_quantity' => '',
                       'products_model' => '',
                       'products_image' => '',
// BOF MaxiDVD: Modified For Ultimate Images Pack!
                       'products_image_med' => '',
                       'products_image_lrg' => '',
                       'products_image_sm_1' => '',
                       'products_image_xl_1' => '',
                       'products_image_sm_2' => '',
                       'products_image_xl_2' => '',
                       'products_image_sm_3' => '',
                       'products_image_xl_3' => '',
                       'products_image_sm_4' => '',
                       'products_image_xl_4' => '',
                       'products_image_sm_5' => '',
                       'products_image_xl_5' => '',
                       'products_image_sm_6' => '',
                       'products_image_xl_6' => '',
// EOF MaxiDVD: Modified For Ultimate Images Pack!
                       'products_price' => '',
                       'products_weight' => '',
                       'products_date_added' => '',
                       'products_last_modified' => '',
                       'products_date_available' => '',
                       'products_status' => '',
                       'products_to_xml' => '',
                       'products_sort_order' => '',
                       'products_tax_class_id' => '',
                       'manufacturers_id' => '');

	//TotalB2B start
	$prices_num = tep_xppp_getpricesnum();
    for ($i=2; $i<=$prices_num; $i++) {
	  $parameters['products_price_' . $i] = '';
	}
    //TotalB2B start


    $pInfo = new objectInfo($parameters);

    if (isset($_GET['pID']) && empty($_POST)) {

// START: Extra Fields Contribution	  
      $products_extra_fields_query = tep_db_query("SELECT * FROM " . TABLE_PRODUCTS_TO_PRODUCTS_EXTRA_FIELDS . " WHERE products_id=" . (int)$_GET['pID']);
      while ($products_extra_fields = tep_db_fetch_array($products_extra_fields_query)) {
        $extra_field[$products_extra_fields['products_extra_fields_id']] = $products_extra_fields['products_extra_fields_value'];
      }
	  $extra_field_array=array('extra_field'=>$extra_field);
	  $pInfo->objectInfo($extra_field_array);
// END: Extra Fields Contribution	
    
// BOF MaxiDVD: Modified For Ultimate Images Pack!
      $products_price_list = tep_xppp_getpricelist("p");
      $product_query = tep_db_query("select pd.products_name, pd.products_description, pd.products_head_title_tag, pd.products_head_desc_tag, pd.products_head_keywords_tag, pd.products_url, p.products_id, p.products_quantity, p.products_model, p.products_image, p.products_image_med, p.products_image_lrg, p.products_image_sm_1, p.products_image_xl_1, p.products_image_sm_2, p.products_image_xl_2, p.products_image_sm_3, p.products_image_xl_3, p.products_image_sm_4, p.products_image_xl_4, p.products_image_sm_5, p.products_image_xl_5, p.products_image_sm_6, p.products_image_xl_6, " . $products_price_list . ", p.products_weight, p.products_date_added, p.products_last_modified, date_format(p.products_date_available, '%Y-%m-%d') as products_date_available, p.products_status, p.products_to_xml, p.products_tax_class_id, p.products_quantity_order_min, p.products_quantity_order_units, p.products_sort_order, p.manufacturers_id from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd where p.products_id = '" . (int)$_GET['pID'] . "' and p.products_id = pd.products_id and pd.language_id = '" . (int)$languages_id . "'");
// EOF MaxiDVD: Modified For Ultimate Images Pack!
      $product = tep_db_fetch_array($product_query);

      $pInfo->objectInfo($product);
    } elseif (tep_not_null($_POST)) {
      $pInfo->objectInfo($_POST);
      $products_name = $_POST['products_name'];
      $products_info = $_POST['products_info'];
      $products_description = $_POST['products_description'];
// Start Products Specifications
      $products_spec = $_POST['products_spec'];
      $products_musthave = $_POST['products_musthave'];
      $products_extraimage = $_POST['products_extraimage'];
      $products_manual = $_POST['products_manual'];
      $products_extra1 = $_POST['products_extra1'];
      $products_moreinfo = $_POST['products_moreinfo'];
// End Products Specifications
      $products_url = $_POST['products_url'];
    }

    $manufacturers_array = array(array('id' => '', 'text' => TEXT_NONE));
// BOF manufacturers descriptions
//  $manufacturers_query = tep_db_query("select manufacturers_id, manufacturers_name from " . TABLE_MANUFACTURERS . " order by manufacturers_name");
    $manufacturers_query = tep_db_query("select manufacturers_id, manufacturers_name from " . TABLE_MANUFACTURERS_INFO . " where languages_id = '" . (int)$languages_id . "' order by manufacturers_name");
// EOF manufacturers descriptions
    while ($manufacturers = tep_db_fetch_array($manufacturers_query)) {
      $manufacturers_array[] = array('id' => $manufacturers['manufacturers_id'],
                                     'text' => $manufacturers['manufacturers_name']);
    }

    $tax_class_array = array(array('id' => '0', 'text' => TEXT_NONE));
    $tax_class_query = tep_db_query("select tax_class_id, tax_class_title from " . TABLE_TAX_CLASS . " order by tax_class_title");
    while ($tax_class = tep_db_fetch_array($tax_class_query)) {
      $tax_class_array[] = array('id' => $tax_class['tax_class_id'],
                                 'text' => $tax_class['tax_class_title']);
    }

    $languages = tep_get_languages();

    if (!isset($pInfo->products_status)) $pInfo->products_status = '1';
    switch ($pInfo->products_status) {
      case '0': $in_status = false; $out_status = true; break;
      case '1':
      default: $in_status = true; $out_status = false;
    }

    if (!isset($pInfo->products_to_xml)) $pInfo->products_to_xml = '1';
    switch ($pInfo->products_to_xml) {
      case '0': $in_xml = false; $out_xml = true; break;
      case '1':
      default: $in_xml = true; $out_xml = false;
    }


?>
<link rel="stylesheet" type="text/css" href="includes/javascript/spiffyCal/spiffyCal_v2_1.css">
<script language="JavaScript" src="includes/javascript/spiffyCal/spiffyCal_v2_1.js"></script>
<script language="javascript"><!--
  var dateAvailable = new ctlSpiffyCalendarBox("dateAvailable", "new_product", "products_date_available","btnDate1","<?php echo $pInfo->products_date_available; ?>",scBTNMODE_CUSTOMBLUE);
//--></script>
<script language="javascript"><!--
var tax_rates = new Array();
<?php
    for ($i=0, $n=sizeof($tax_class_array); $i<$n; $i++) {
      if ($tax_class_array[$i]['id'] > 0) {
        echo 'tax_rates["' . $tax_class_array[$i]['id'] . '"] = ' . tep_get_tax_rate_value($tax_class_array[$i]['id']) . ';' . "\n";
      }
    }
?>

function doRound(x, places) {
  return Math.round(x * Math.pow(10, places)) / Math.pow(10, places);
}

function getTaxRate() {
  var selected_value = document.forms["new_product"].products_tax_class_id.selectedIndex;
  var parameterVal = document.forms["new_product"].products_tax_class_id[selected_value].value;

  if ( (parameterVal > 0) && (tax_rates[parameterVal] > 0) ) {
    return tax_rates[parameterVal];
  } else {
    return 0;
  }
}

//TotalB2B start
function updateGross(products_price_t) {
  var taxRate = getTaxRate(products_price_t);

  var grossValue = document.forms["new_product"].elements[products_price_t].value;

  if (taxRate > 0) {
    grossValue = grossValue * ((taxRate / 100) + 1);
  }

  var products_price_gross_t = products_price_t + "_gross";

  document.forms["new_product"].elements[products_price_gross_t].value = doRound(grossValue, 4);
}

function updateNet(products_price_t) {
  var taxRate = getTaxRate();
  var products_price_gross_t = products_price_t + "_gross";
  var netValue = document.forms["new_product"].elements[products_price_gross_t].value;

  if (taxRate > 0) {
    netValue = netValue / ((taxRate / 100) + 1);
  }

  document.forms["new_product"].elements[products_price_t].value = doRound(netValue, 4);
}
//TotalB2B end

//--></script>
    <?php echo tep_draw_form('new_product', FILENAME_CATEGORIES, 'cPath=' . $cPath . (isset($_GET['pID']) ? '&pID=' . $_GET['pID'] : '') . '&action=new_product_preview', 'post', 'enctype="multipart/form-data"'); ?>
    <table class="table-padding-2">
      <tr>
        <td><table class="table-padding-0">
          <tr>
            <td class="pageHeading"><?php echo sprintf(TEXT_NEW_PRODUCT, tep_output_generated_category_path($current_category_id)); ?></td>
            <td class="pageHeading" align="right"><?php echo tep_draw_separator('pixel_trans.gif', HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
      <tr>
        <td>

<?php echo tep_draw_hidden_field('products_date_added', (tep_not_null($pInfo->products_date_added) ? $pInfo->products_date_added : date('Y-m-d'))) . tep_image_submit('button_preview.gif', IMAGE_PREVIEW) . '&nbsp;&nbsp;<a href="' . tep_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . (isset($_GET['pID']) ? '&pID=' . $_GET['pID'] : '')) . '">' . tep_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>'; ?>
        
<div id="tabs">

			<ul>
				<li><a href="#data"><?php echo TEXT_PRODUCTS_DATA; ?></a></li>
<?php
    for ($i=0; $i<sizeof($languages); $i++) {
?>
				<li><a href="#tab<?php echo $i; ?>"><?php echo $languages[$i]['name']; ?></a></li>
<?php 
}
?>
				<li><a href="#images"><?php echo TEXT_PRODUCTS_TAB_IMAGES; ?></a></li>
				<li><a href="#prices"><?php echo TEXT_PRODUCTS_TAB_PRICE; ?></a></li>
<?php
 if (ALLOW_ATTRIBUTES_IN_PRODUCT_EDIT_PAGE == 'true') {
?>
				<li><a href="#options"><?php echo TEXT_PRODUCTS_TAB_ATTRIBUTES; ?></a></li>
<?php
}
?>				
				<li><a href="#specs"><?php echo TEXT_TAB_SPECIFICATIONS; ?></a></li>
			</ul>

        <div id="data">
          <table border="0">
       
          <tr>
            <td class="main"><?php echo TEXT_PRODUCTS_STATUS; ?></td>
            <td class="main"><?php echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_radio_field('products_status', '1', $in_status) . '&nbsp;' . TEXT_PRODUCT_AVAILABLE . '&nbsp;' . tep_draw_radio_field('products_status', '0', $out_status) . '&nbsp;' . TEXT_PRODUCT_NOT_AVAILABLE; ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo TEXT_PRODUCTS_DATE_AVAILABLE; ?><br><small>(YYYY-MM-DD)</small></td>
            <td class="main"><?php echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;'; ?><script language="javascript">dateAvailable.writeControl(); dateAvailable.dateFormat="yyyy-MM-dd";</script></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo TEXT_PRODUCTS_MANUFACTURER; ?></td>
            <td class="main"><?php echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_pull_down_menu('manufacturers_id', $manufacturers_array, $pInfo->manufacturers_id); ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo TEXT_PRODUCTS_TO_XML; ?></td>
            <td class="main"><?php echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_radio_field('products_to_xml', '1', $in_xml) . '&nbsp;' . TEXT_PRODUCT_AVAILABLE_TO_XML . '&nbsp;' . tep_draw_radio_field('products_to_xml', '0', $out_xml) . '&nbsp;' . TEXT_PRODUCT_NOT_AVAILABLE_TO_XML; ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo TEXT_PRODUCTS_QUANTITY; ?></td>
            <td class="main"><?php echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_input_field('products_quantity', $pInfo->products_quantity); ?></td>

          </tr>
          <tr>
            <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo TEXT_MIN_QUANTITY; ?></td>
            <td class="main"><?php echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_input_field('products_quantity_order_min', ($pInfo->products_quantity_order_min==0 ? 1 : $pInfo->products_quantity_order_min)); ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo TEXT_MIN_QUANTITY_UNITS; ?></td>
            <td class="main"><?php echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_input_field('products_quantity_order_units', ($pInfo->products_quantity_order_units==0 ? 1 : $pInfo->products_quantity_order_units)); ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo TEXT_PRODUCTS_MODEL; ?></td>
            <td class="main"><?php echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_input_field('products_model', $pInfo->products_model); ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>

          <tr>
            <td colspan="2"><?php echo TEXT_WEIGHT_HELP; ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo TEXT_PRODUCTS_WEIGHT; ?></td>
            <td class="main"><?php echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_input_field('products_weight', $pInfo->products_weight); ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo TEXT_EDIT_SORT_ORDER; ?></td>
            <td class="main"><?php echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_input_field('products_sort_order', $pInfo->products_sort_order); ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>

<?php
// START: Extra Fields Contribution (chapter 1.4)
      // Sort language by ID  
	  for ($i=0, $n=sizeof($languages); $i<$n; $i++) {
	    $languages_array[$languages[$i]['id']]=$languages[$i];
	  }
      $extra_fields_query = tep_db_query("SELECT * FROM " . TABLE_PRODUCTS_EXTRA_FIELDS . " ORDER BY products_extra_fields_order");
      while ($extra_fields = tep_db_fetch_array($extra_fields_query)) {
	  // Display language icon or blank space
        if ($extra_fields['languages_id']==0) {
	      $m=tep_draw_separator('pixel_trans.gif', '24', '15');
	    } else $m= tep_image(DIR_WS_CATALOG_LANGUAGES . $languages_array[$extra_fields['languages_id']]['directory'] . '/images/' . $languages_array[$extra_fields['languages_id']]['image'], $languages_array[$extra_fields['languages_id']]['name']);
?>
          <tr bgcolor="#ebebff">
            <td class="main"><?php echo $extra_fields['products_extra_fields_name']; ?>:</td>
            <td class="main"><?php echo $m . '&nbsp;' . tep_draw_input_field("extra_field[".$extra_fields['products_extra_fields_id']."]", $pInfo->extra_field[$extra_fields['products_extra_fields_id']]); ?></td>
          </tr>
<?php
}
// END: Extra Fields Contribution
?>

          </table>
        </div>

<?php for ($i = 0, $n = sizeof($languages); $i < $n; $i++) { ?>
<!-- ��������� -->
        <div id="tab<?php echo $i; ?>">
          <table border="0" class="main">

          <tr>
            <td class="main"><?php echo TEXT_PRODUCTS_NAME; ?></td>
            <td class="main"><?php echo tep_draw_input_field('products_name[' . $languages[$i]['id'] . ']', (isset($products_name[$languages[$i]['id']]) ? stripslashes($products_name[$languages[$i]['id']]) : tep_get_products_name($pInfo->products_id, $languages[$i]['id']))); ?></td>
              
          </tr>
          <tr>
            <td class="main" valign="top"><?php echo TEXT_PRODUCTS_INFO; ?></td>
            <td><table border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td class="main" valign="top"><?php echo tep_draw_textarea_field('products_info[' . $languages[$i]['id'] . ']', 'soft', '70', '10', (isset($products_info[$languages[$i]['id']]) ? $products_info[$languages[$i]['id']] : tep_get_products_info($pInfo->products_id, $languages[$i]['id'])),'class="notinymce"'); ?></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td class="main" valign="top"><?php echo TEXT_PRODUCTS_DESCRIPTION; ?></td>
            <td><table border="0" cellspacing="0" cellpadding="0">
              <tr>
<td class="main">

<?php
          echo tep_draw_textarea_field('products_description[' . $languages[$i]['id'] . ']', 'soft', '70', '15', (isset($products_description[$languages[$i]['id']]) ? stripslashes($products_description[$languages[$i]['id']]) : tep_get_products_description($pInfo->products_id, $languages[$i]['id'])));
?>

</td>

              </tr>
            </table></td>
          </tr>

         <tr>
            <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>

          <tr>
            <td class="main" valign="top"><?php echo TEXT_PRODUCTS_PAGE_TITLE; ?></td>
            <td><table border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td class="main" valign="top"><?php echo tep_draw_textarea_field('products_head_title_tag[' . $languages[$i]['id'] . ']', 'soft', '70', '5', (isset($products_head_title_tag[$languages[$i]['id']]) ? $products_head_title_tag[$languages[$i]['id']] : tep_get_products_head_title_tag($pInfo->products_id, $languages[$i]['id'])),'class="notinymce"'); ?></td>
              </tr>
            </table></td>
          </tr>

          <tr>
            <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>

           <tr>
            <td class="main" valign="top"><?php echo TEXT_PRODUCTS_HEADER_DESCRIPTION; ?></td>
            <td><table border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td class="main" valign="top"><?php echo tep_draw_textarea_field('products_head_desc_tag[' . $languages[$i]['id'] . ']', 'soft', '70', '5', (isset($products_head_desc_tag[$languages[$i]['id']]) ? $products_head_desc_tag[$languages[$i]['id']] : tep_get_products_head_desc_tag($pInfo->products_id, $languages[$i]['id'])),'class="notinymce"'); ?></td>
              </tr>
            </table></td>
          </tr>

          <tr>
            <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>

           <tr>
            <td class="main" valign="top"><?php echo TEXT_PRODUCTS_KEYWORDS; ?></td>
            <td><table border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td class="main" valign="top"><?php echo tep_draw_textarea_field('products_head_keywords_tag[' . $languages[$i]['id'] . ']', 'soft', '70', '5', (isset($products_head_keywords_tag[$languages[$i]['id']]) ? $products_head_keywords_tag[$languages[$i]['id']] : tep_get_products_head_keywords_tag($pInfo->products_id, $languages[$i]['id'])),'class="notinymce"'); ?></td>
              </tr>
            </table></td>
          </tr>
          
          <tr>
            <td class="main"><?php echo TEXT_PRODUCTS_URL . '<br><small>' . TEXT_PRODUCTS_URL_WITHOUT_HTTP . '</small>'; ?></td>
            <td class="main"><?php echo tep_draw_input_field('products_url[' . $languages[$i]['id'] . ']', (isset($products_url[$languages[$i]['id']]) ? stripslashes($products_url[$languages[$i]['id']]) : tep_get_products_url($pInfo->products_id, $languages[$i]['id']))); ?></td>
          </tr>

          </table>
        </div>
<?php } ?>

        <div id="images">
          <table border="0">

<!-- // BOF: MaxiDVD Added for Ulimited Images Pack! -->

<?php

  require('includes/classes/directory_listing.php');
  $osC_Dir_Images = new osC_DirectoryListing('../images');
  $osC_Dir_Images->setExcludeEntries('CVS');
  $osC_Dir_Images->setIncludeFiles(false);
  $osC_Dir_Images->setRecursive(true);
  $osC_Dir_Images->setAddDirectoryToFilename(true);
  $files = $osC_Dir_Images->getFiles();

  $image_directories = array(array('id' => '', 'text' => TEXT_IMAGES_MAIN_DIRECTORY));
  foreach ($files as $file) {
    $image_directories[] = array('id' => $file['name'] . '/', 'text' => 'images/' . $file['name']);
  }

//  $dir = @dir(DIR_FS_CATALOG_IMAGES);
//  $dir_info[] = array('id' => '', 'text' => TEXT_IMAGES_MAIN_DIRECTORY);
//  while ($file = $dir->read()) {
//    if (is_dir(DIR_FS_CATALOG_IMAGES . $file) && strtoupper($file) != 'CVS' && $file != "." && $file != "..") {
//      $dir_info[] = array('id' => $file . '/', 'text' => $file);
//    }
//  }

//  $default_directory = substr( $pInfo->products_image, 0,strpos( $pInfo->products_image, '/')+1);
//  $default_directory_med = substr( $pInfo->products_image_med, 0,strpos( $pInfo->products_image_med, '/')+1);
//  $default_directory_lrg = substr( $pInfo->products_image_lrg, 0,strpos( $pInfo->products_image_lrg, '/')+1);

  // set image overwrite
  $on_overwrite = true;
  $off_overwrite = false;
  $on_overwrite_med = true;
  $off_overwrite_med = false;
  $on_overwrite_lrg = true;
  $off_overwrite_lrg = false;
  $on_overwrite_sm_1 = true;
  $off_overwrite_sm_1 = false;
  $on_overwrite_sm_2 = true;
  $off_overwrite_sm_2 = false;
  $on_overwrite_sm_3 = true;
  $off_overwrite_sm_3 = false;
  $on_overwrite_sm_4 = true;
  $off_overwrite_sm_4 = false;
  $on_overwrite_sm_5 = true;
  $off_overwrite_sm_5 = false;
  $on_overwrite_sm_6 = true;
  $off_overwrite_sm_6 = false;
  $on_overwrite_xl_1 = true;
  $off_overwrite_xl_1 = false;
  $on_overwrite_xl_2 = true;
  $off_overwrite_xl_2 = false;
  $on_overwrite_xl_3 = true;
  $off_overwrite_xl_3 = false;
  $on_overwrite_xl_4 = true;
  $off_overwrite_xl_4 = false;
  $on_overwrite_xl_5 = true;
  $off_overwrite_xl_5 = false;
  $on_overwrite_xl_6 = true;
  $off_overwrite_xl_6 = false;
?>
          <tr>
           <td class="dataTableRow" width="30%" valign="top"><span class="main"><?php echo TEXT_PRODUCTS_IMAGE_NOTE; ?></span></td>
        <td class="dataTableRow" width="70%" valign="top"><span class="smallText"><?php echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_file_field('products_image') . '&nbsp;'; ?><br><?php echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . TEXT_PRODUCTS_IMAGE_DIR; ?><br><?php echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_pull_down_menu('img_dir', $image_directories, dirname($pInfo->products_image) . '/'); ?><br>
           <?php if (($_GET['pID']) && ($pInfo->products_image) != '')
           echo tep_draw_separator('pixel_trans.gif', '24', '17" align="left') . $pInfo->products_image . tep_image(DIR_WS_CATALOG_IMAGES . $pInfo->products_image, $pInfo->products_image, SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT, 'align="left" hspace="0" vspace="5"') . tep_draw_hidden_field('products_previous_image', $pInfo->products_image) . '<br>'. tep_draw_separator('pixel_trans.gif', '5', '15') . '&nbsp;<input type="checkbox" name="unlink_image" value="yes">' . TEXT_PRODUCTS_IMAGE_REMOVE_SHORT . '<br>' . tep_draw_separator('pixel_trans.gif', '5', '15') . '&nbsp;<input type="checkbox" name="delete_image" value="yes">' . TEXT_PRODUCTS_IMAGE_DELETE_SHORT . '<br>' . tep_draw_separator('pixel_trans.gif', '1', '42'); ?></span></td>
          </tr>
          <tr>
           <td class="dataTableRow" width="30%" valign="top"><span class="main"><?php echo TEXT_PRODUCTS_IMAGE_MEDIUM; ?></span></td>
           <td class="dataTableRow" width="70%" valign="top"><span class="smallText"><?php echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_file_field('products_image_med') . '&nbsp;'; ?><br><?php echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . TEXT_PRODUCTS_IMAGE_DIR; ?><br><?php echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_pull_down_menu('img_dir_med', $image_directories, dirname($pInfo->products_image_med) . '/'); ?><br>
           <?php if (($_GET['pID']) && ($pInfo->products_image_med) != '')
           echo tep_draw_separator('pixel_trans.gif', '24', '17" align="left') . $pInfo->products_image_med . tep_image(DIR_WS_CATALOG_IMAGES . $pInfo->products_image_med, $pInfo->products_image_med, SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT, 'align="left" hspace="0" vspace="5"') . tep_draw_hidden_field('products_previous_image_med', $pInfo->products_image_med) . '<br>'. tep_draw_separator('pixel_trans.gif', '5', '15') . '&nbsp;<input type="checkbox" name="unlink_image_med" value="yes">' . TEXT_PRODUCTS_IMAGE_REMOVE_SHORT . '<br>' . tep_draw_separator('pixel_trans.gif', '5', '15') . '&nbsp;<input type="checkbox" name="delete_image_med" value="yes">' . TEXT_PRODUCTS_IMAGE_DELETE_SHORT . '<br>' . tep_draw_separator('pixel_trans.gif', '1', '42'); ?></span></td>
          </tr>
          <tr>
           <td class="dataTableRow" width="30%" valign="top"><span class="main"><?php echo TEXT_PRODUCTS_IMAGE_LARGE; ?></span></td>
           <td class="dataTableRow" width="70%" valign="top"><span class="smallText"><?php echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_file_field('products_image_lrg') . '&nbsp;'; ?><br><?php echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . TEXT_PRODUCTS_IMAGE_DIR; ?><br><?php echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_pull_down_menu('img_dir_lrg', $image_directories, dirname($pInfo->products_image_lrg) . '/'); ?><br>
           <?php if (($_GET['pID']) && ($pInfo->products_image_lrg) != '')
           echo tep_draw_separator('pixel_trans.gif', '24', '17" align="left') . $pInfo->products_image_lrg . tep_image(DIR_WS_CATALOG_IMAGES . $pInfo->products_image_lrg, $pInfo->products_image_lrg, SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT, 'align="left" hspace="0" vspace="5"') . tep_draw_hidden_field('products_previous_image_lrg', $pInfo->products_image_lrg) . '<br>'. tep_draw_separator('pixel_trans.gif', '5', '15') . '&nbsp;<input type="checkbox" name="unlink_image_lrg" value="yes">' . TEXT_PRODUCTS_IMAGE_REMOVE_SHORT . '<br>' . tep_draw_separator('pixel_trans.gif', '5', '15') . '&nbsp;<input type="checkbox" name="delete_image_lrg" value="yes">' . TEXT_PRODUCTS_IMAGE_DELETE_SHORT . '<br>' . tep_draw_separator('pixel_trans.gif', '1', '42'); ?></span></td>
          </tr>

  <?php
      if (ULTIMATE_ADDITIONAL_IMAGES == 'enable') {
   ?>
          <tr>
            <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '20'); ?></td>
          </tr>
         <tr>
            <td class="main" colspan="3"><?php echo TEXT_PRODUCTS_IMAGE_ADDITIONAL . '<br><hr>';?></td>
          </tr>
          <tr>
            <td class="smalltext" colspan="3"><table border="0" cellpadding="2" cellspacing="0" width="100%">
              <tr>
                <td class="smalltext" colspan="2" valign="top" width="50%"><?php echo TEXT_PRODUCTS_IMAGE_TH_NOTICE; ?></td>
                <td class="smalltext" colspan="2" valign="top" width="50%"><?php echo TEXT_PRODUCTS_IMAGE_XL_NOTICE; ?></td>
              </tr>

              <tr>
                <td class="dataTableRow" valign="top"><span class="smallText"><?php echo TEXT_PRODUCTS_IMAGE_SM_1; ?></span></td>
                <td class="dataTableRow" valign="top"><span class="smallText"><?php echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_file_field('products_image_sm_1') . tep_draw_hidden_field('products_previous_image_sm_1', $pInfo->products_image_sm_1); ?><br><?php echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . TEXT_PRODUCTS_IMAGE_DIR; ?><br><?php echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_pull_down_menu('img_dir_sm_1', $image_directories, dirname($pInfo->products_image_sm_1) . '/'); ?><br>
</td>
                <td class="dataTableRow" valign="top"><span class="smallText"><?php echo TEXT_PRODUCTS_IMAGE_XL_1; ?></span></td>
                <td class="dataTableRow" valign="top"><span class="smallText"><?php echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_file_field('products_image_xl_1') . tep_draw_hidden_field('products_previous_image_xl_1', $pInfo->products_image_xl_1); ?><br><?php echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . TEXT_PRODUCTS_IMAGE_DIR; ?><br><?php echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_pull_down_menu('img_dir_xl_1', $image_directories, dirname($pInfo->products_image_xl_1) . '/'); ?><br>
</td>
              </tr>
              <tr>
                <td class="dataTableRow" colspan="2" valign="top"><?php if (($_GET['pID']) && ($pInfo->products_image_sm_1) != '')  { ?><?php if (tep_not_null($pInfo->products_image_sm_1)) { ?><span class="smallText"><?php echo $pInfo->products_image_sm_1 . '<br>' . tep_image(DIR_WS_CATALOG_IMAGES . $pInfo->products_image_sm_1, $pInfo->products_image_sm_1, SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT, 'align="left" hspace="0" vspace="5"') . '<br>'. tep_draw_separator('pixel_trans.gif', '5', '15') . '&nbsp;<input type="checkbox" name="unlink_image_sm_1" value="yes">' . TEXT_PRODUCTS_IMAGE_REMOVE_SHORT . '<br>' . tep_draw_separator('pixel_trans.gif', '5', '15') . '&nbsp;<input type="checkbox" name="delete_image_sm_1" value="yes">' . TEXT_PRODUCTS_IMAGE_DELETE_SHORT . '<br>' . tep_draw_separator('pixel_trans.gif', '1', '42'); ?></span><?php } } ?></td>
                <td class="dataTableRow" colspan="2" valign="top"><?php if (($_GET['pID']) && ($pInfo->products_image_xl_1) != '') { ?><?php if (tep_not_null($pInfo->products_image_xl_1)) { ?><span class="smallText"><?php echo $pInfo->products_image_xl_1 . '<br>' . tep_image(DIR_WS_CATALOG_IMAGES . $pInfo->products_image_xl_1, $pInfo->products_image_xl_1, SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT, 'align="left" hspace="0" vspace="5"') . '<br>'. tep_draw_separator('pixel_trans.gif', '5', '15') . '&nbsp;<input type="checkbox" name="unlink_image_xl_1" value="yes">' . TEXT_PRODUCTS_IMAGE_REMOVE_SHORT . '<br>' . tep_draw_separator('pixel_trans.gif', '5', '15') . '&nbsp;<input type="checkbox" name="delete_image_xl_1" value="yes">' . TEXT_PRODUCTS_IMAGE_DELETE_SHORT . '<br>' . tep_draw_separator('pixel_trans.gif', '1', '42'); ?></span><?php } } ?></td>
              </tr>
              <tr>
                <td class="smallText top-valign"><span class="smallText"><?php echo TEXT_PRODUCTS_IMAGE_SM_2; ?></span></td>
                <td class="smallText top-valign"><span class="smallText"><?php echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_file_field('products_image_sm_2') . tep_draw_hidden_field('products_previous_image_sm_2', $pInfo->products_image_sm_2); ?><br><?php echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . TEXT_PRODUCTS_IMAGE_DIR; ?><br><?php echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_pull_down_menu('img_dir_sm_2', $image_directories, dirname($pInfo->products_image_sm_2) . '/'); ?><br>
</td>
                <td class="smallText top-valign"><span class="smallText"><?php echo TEXT_PRODUCTS_IMAGE_XL_2; ?></span></td>
                <td class="smallText top-valign"><span class="smallText"><?php echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_file_field('products_image_xl_2') . tep_draw_hidden_field('products_previous_image_xl_2', $pInfo->products_image_xl_2); ?><br><?php echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . TEXT_PRODUCTS_IMAGE_DIR; ?><br><?php echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_pull_down_menu('img_dir_xl_2', $image_directories, dirname($pInfo->products_image_xl_2) . '/'); ?><br>
</td>
             </tr>
              <tr>
                <td class="smallText top-valign" colspan="2"><?php if (($_GET['pID']) && ($pInfo->products_image_sm_2) != '')  { ?><?php if (tep_not_null($pInfo->products_image_sm_2)) { ?><?php echo $pInfo->products_image_sm_2 . '<br>' . tep_image(DIR_WS_CATALOG_IMAGES . $pInfo->products_image_sm_2, $pInfo->products_name_sm_2, SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT, 'align="left" hspace="0" vspace="5"') . '<br>'. tep_draw_separator('pixel_trans.gif', '5', '15') . '&nbsp;<input type="checkbox" name="unlink_image_sm_2" value="yes">' . TEXT_PRODUCTS_IMAGE_REMOVE_SHORT . '<br>' . tep_draw_separator('pixel_trans.gif', '5', '15') . '&nbsp;<input type="checkbox" name="delete_image_sm_2" value="yes">' . TEXT_PRODUCTS_IMAGE_DELETE_SHORT . '<br>' . tep_draw_separator('pixel_trans.gif', '1', '42'); ?><?php } } ?></td>
                <td class="smallText top-valign" colspan="2"><?php if (($_GET['pID']) && ($pInfo->products_image_xl_2) != '') { ?><?php if (tep_not_null($pInfo->products_image_xl_2)) { ?><?php echo $pInfo->products_image_xl_2 . '<br>' . tep_image(DIR_WS_CATALOG_IMAGES . $pInfo->products_image_xl_2, $pInfo->products_name_xl_2, SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT, 'align="left" hspace="0" vspace="5"') . '<br>'. tep_draw_separator('pixel_trans.gif', '5', '15') . '&nbsp;<input type="checkbox" name="unlink_image_xl_2" value="yes">' . TEXT_PRODUCTS_IMAGE_REMOVE_SHORT . '<br>' . tep_draw_separator('pixel_trans.gif', '5', '15') . '&nbsp;<input type="checkbox" name="delete_image_xl_2" value="yes">' . TEXT_PRODUCTS_IMAGE_DELETE_SHORT . '<br>' . tep_draw_separator('pixel_trans.gif', '1', '42'); ?><?php } } ?></td>
              </tr>
              <tr>
                <td class="dataTableRow" valign="top"><span class="smallText"><?php echo TEXT_PRODUCTS_IMAGE_SM_3; ?></span></td>
                <td class="dataTableRow" valign="top"><span class="smallText"><?php echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_file_field('products_image_sm_3') . tep_draw_hidden_field('products_previous_image_sm_3', $pInfo->products_image_sm_3); ?><br><?php echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . TEXT_PRODUCTS_IMAGE_DIR; ?><br><?php echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_pull_down_menu('img_dir_sm_3', $image_directories, dirname($pInfo->products_image_sm_3) . '/'); ?><br>
</td>
                <td class="dataTableRow" valign="top"><span class="smallText"><?php echo TEXT_PRODUCTS_IMAGE_XL_3; ?></span></td>
                <td class="dataTableRow" valign="top"><span class="smallText"><?php echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_file_field('products_image_xl_3') . tep_draw_hidden_field('products_previous_image_xl_3', $pInfo->products_image_xl_3); ?><br><?php echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . TEXT_PRODUCTS_IMAGE_DIR; ?><br><?php echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_pull_down_menu('img_dir_xl_3', $image_directories, dirname($pInfo->products_image_xl_3) . '/'); ?><br>
</td>
              </tr>
              <tr>
                <td class="dataTableRow" colspan="2" valign="top"><?php if (($_GET['pID']) && ($pInfo->products_image_sm_3) != '')  { ?><?php if (tep_not_null($pInfo->products_image_sm_3)) { ?><span class="smallText"><?php echo $pInfo->products_image_sm_3 . '<br>' . tep_image(DIR_WS_CATALOG_IMAGES . $pInfo->products_image_sm_3, $pInfo->products_name_sm_3, SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT, 'align="left" hspace="0" vspace="5"') . '<br>'. tep_draw_separator('pixel_trans.gif', '5', '15') . '&nbsp;<input type="checkbox" name="unlink_image_sm_3" value="yes">' . TEXT_PRODUCTS_IMAGE_REMOVE_SHORT . '<br>' . tep_draw_separator('pixel_trans.gif', '5', '15') . '&nbsp;<input type="checkbox" name="delete_image_sm_3" value="yes">' . TEXT_PRODUCTS_IMAGE_DELETE_SHORT . '<br>' . tep_draw_separator('pixel_trans.gif', '1', '42'); ?></span><?php } } ?></td>
                <td class="dataTableRow" colspan="2" valign="top"><?php if (($_GET['pID']) && ($pInfo->products_image_xl_3) != '') { ?><?php if (tep_not_null($pInfo->products_image_xl_3)) { ?><span class="smallText"><?php echo $pInfo->products_image_xl_3 . '<br>' . tep_image(DIR_WS_CATALOG_IMAGES . $pInfo->products_image_xl_3, $pInfo->products_name_xl_3, SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT, 'align="left" hspace="0" vspace="5"') . '<br>'. tep_draw_separator('pixel_trans.gif', '5', '15') . '&nbsp;<input type="checkbox" name="unlink_image_xl_3" value="yes">' . TEXT_PRODUCTS_IMAGE_REMOVE_SHORT . '<br>' . tep_draw_separator('pixel_trans.gif', '5', '15') . '&nbsp;<input type="checkbox" name="delete_image_xl_3" value="yes">' . TEXT_PRODUCTS_IMAGE_DELETE_SHORT . '<br>' . tep_draw_separator('pixel_trans.gif', '1', '42'); ?></span><?php } } ?></td>
              </tr>
              <tr>
                <td class="smallText top-valign"><span class="smallText"><?php echo TEXT_PRODUCTS_IMAGE_SM_4; ?></span></td>
                <td class="smallText top-valign"><span class="smallText"><?php echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_file_field('products_image_sm_4') . tep_draw_hidden_field('products_previous_image_sm_4', $pInfo->products_image_sm_4); ?><br><?php echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . TEXT_PRODUCTS_IMAGE_DIR; ?><br><?php echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_pull_down_menu('img_dir_sm_4', $image_directories, dirname($pInfo->products_image_sm_4) . '/'); ?><br>
</td>
                <td class="smallText top-valign"><span class="smallText"><?php echo TEXT_PRODUCTS_IMAGE_XL_4; ?></span></td>
                <td class="smallText top-valign"><span class="smallText"><?php echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_file_field('products_image_xl_4') . tep_draw_hidden_field('products_previous_image_xl_4', $pInfo->products_image_xl_4); ?><br><?php echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . TEXT_PRODUCTS_IMAGE_DIR; ?><br><?php echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_pull_down_menu('img_dir_xl_4', $image_directories, dirname($pInfo->products_image_xl_4) . '/'); ?><br>
</td>
             </tr>
              <tr>
                <td class="smallText top-valign" colspan="2"><?php if (($_GET['pID']) && ($pInfo->products_image_sm_4) != '')  { ?><?php if (tep_not_null($pInfo->products_image_sm_4)) { ?><?php echo $pInfo->products_image_sm_4 . '<br>' . tep_image(DIR_WS_CATALOG_IMAGES . $pInfo->products_image_sm_4, $pInfo->products_name_sm_4, SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT, 'align="left" hspace="0" vspace="5"') . '<br>'. tep_draw_separator('pixel_trans.gif', '5', '15') . '&nbsp;<input type="checkbox" name="unlink_image_sm_4" value="yes">' . TEXT_PRODUCTS_IMAGE_REMOVE_SHORT . '<br>' . tep_draw_separator('pixel_trans.gif', '5', '15') . '&nbsp;<input type="checkbox" name="delete_image_sm_4" value="yes">' . TEXT_PRODUCTS_IMAGE_DELETE_SHORT . '<br>' . tep_draw_separator('pixel_trans.gif', '1', '42'); ?><?php } } ?></td>
                <td class="smallText top-valign" colspan="2"><?php if (($_GET['pID']) && ($pInfo->products_image_xl_4) != '') { ?><?php if (tep_not_null($pInfo->products_image_xl_4)) { ?><?php echo $pInfo->products_image_xl_4 . '<br>' . tep_image(DIR_WS_CATALOG_IMAGES . $pInfo->products_image_xl_4, $pInfo->products_name_xl_4, SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT, 'align="left" hspace="0" vspace="5"') . '<br>'. tep_draw_separator('pixel_trans.gif', '5', '15') . '&nbsp;<input type="checkbox" name="unlink_image_xl_4" value="yes">' . TEXT_PRODUCTS_IMAGE_REMOVE_SHORT . '<br>' . tep_draw_separator('pixel_trans.gif', '5', '15') . '&nbsp;<input type="checkbox" name="delete_image_xl_4" value="yes">' . TEXT_PRODUCTS_IMAGE_DELETE_SHORT . '<br>' . tep_draw_separator('pixel_trans.gif', '1', '42'); ?><?php } } ?></td>
              </tr>
              <tr>
                <td class="dataTableRow" valign="top"><span class="smallText"><?php echo TEXT_PRODUCTS_IMAGE_SM_5; ?></span></td>
                <td class="dataTableRow" valign="top"><span class="smallText"><?php echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_file_field('products_image_sm_5') . tep_draw_hidden_field('products_previous_image_sm_5', $pInfo->products_image_sm_5); ?><br><?php echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . TEXT_PRODUCTS_IMAGE_DIR; ?><br><?php echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_pull_down_menu('img_dir_sm_5', $image_directories, dirname($pInfo->products_image_sm_5) . '/'); ?><br>
</td>
                <td class="dataTableRow" valign="top"><span class="smallText"><?php echo TEXT_PRODUCTS_IMAGE_XL_5; ?></span></td>
                <td class="dataTableRow" valign="top"><span class="smallText"><?php echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_file_field('products_image_xl_5') . tep_draw_hidden_field('products_previous_image_xl_5', $pInfo->products_image_xl_5); ?><br><?php echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . TEXT_PRODUCTS_IMAGE_DIR; ?><br><?php echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_pull_down_menu('img_dir_xl_5', $image_directories, dirname($pInfo->products_image_xl_5) . '/'); ?><br>
</td>
              </tr>
             <tr>
                <td class="dataTableRow" colspan="2" valign="top"> <?php if (($_GET['pID']) && ($pInfo->products_image_sm_5) != '')  { ?><?php if (tep_not_null($pInfo->products_image_sm_5)) { ?><span class="smallText"><?php echo $pInfo->products_image_sm_5 . '<br>' . tep_image(DIR_WS_CATALOG_IMAGES . $pInfo->products_image_sm_5, $pInfo->products_name_sm_5, SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT, 'align="left" hspace="0" vspace="5"') . '<br>'. tep_draw_separator('pixel_trans.gif', '5', '15') . '&nbsp;<input type="checkbox" name="unlink_image_sm_5" value="yes">' . TEXT_PRODUCTS_IMAGE_REMOVE_SHORT . '<br>' . tep_draw_separator('pixel_trans.gif', '5', '15') . '&nbsp;<input type="checkbox" name="delete_image_sm_5" value="yes">' . TEXT_PRODUCTS_IMAGE_DELETE_SHORT . '<br>' . tep_draw_separator('pixel_trans.gif', '1', '42'); ?></span><?php } } ?></td>
                <td class="dataTableRow" colspan="2" valign="top"><?php if (($_GET['pID']) && ($pInfo->products_image_xl_5) != '') { ?><?php if (tep_not_null($pInfo->products_image_xl_5)) { ?><span class="smallText"><?php echo $pInfo->products_image_xl_5 . '<br>' . tep_image(DIR_WS_CATALOG_IMAGES . $pInfo->products_image_xl_5, $pInfo->products_name_xl_5, SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT, 'align="left" hspace="0" vspace="5"') . '<br>'. tep_draw_separator('pixel_trans.gif', '5', '15') . '&nbsp;<input type="checkbox" name="unlink_image_xl_5" value="yes">' . TEXT_PRODUCTS_IMAGE_REMOVE_SHORT . '<br>' . tep_draw_separator('pixel_trans.gif', '5', '15') . '&nbsp;<input type="checkbox" name="delete_image_xl_5" value="yes">' . TEXT_PRODUCTS_IMAGE_DELETE_SHORT . '<br>' . tep_draw_separator('pixel_trans.gif', '1', '42'); ?></span><?php } } ?></td>
              </tr>
              <tr>
                <td class="smallText top-valign"><span class="smallText"><?php echo TEXT_PRODUCTS_IMAGE_SM_6; ?></span></td>
                <td class="smallText top-valign"><span class="smallText"><?php echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_file_field('products_image_sm_6') . tep_draw_hidden_field('products_previous_image_sm_6', $pInfo->products_image_sm_6); ?><br><?php echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . TEXT_PRODUCTS_IMAGE_DIR; ?><br><?php echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_pull_down_menu('img_dir_sm_6', $image_directories, dirname($pInfo->products_image_sm_6) . '/'); ?><br>
</td>
                <td class="smallText top-valign"><span class="smallText"><?php echo TEXT_PRODUCTS_IMAGE_XL_6; ?></span></td>
                <td class="smallText top-valign"><span class="smallText"><?php echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_file_field('products_image_xl_6') . tep_draw_hidden_field('products_previous_image_xl_6', $pInfo->products_image_xl_6); ?><br><?php echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . TEXT_PRODUCTS_IMAGE_DIR; ?><br><?php echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_pull_down_menu('img_dir_xl_6', $image_directories, dirname($pInfo->products_image_xl_6) . '/'); ?><br>
</td>
             </tr>
             <tr>
                <td class="smallText top-valign" colspan="2"><?php if (($_GET['pID']) && ($pInfo->products_image_sm_6) != '')  { ?><?php if (tep_not_null($pInfo->products_image_sm_6)) { ?><?php echo $pInfo->products_image_sm_6 . '<br>' . tep_image(DIR_WS_CATALOG_IMAGES . $pInfo->products_image_sm_6, $pInfo->products_name_sm_6, SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT, 'align="left" hspace="0" vspace="5"') . '<br>'. tep_draw_separator('pixel_trans.gif', '5', '15') . '&nbsp;<input type="checkbox" name="unlink_image_sm_6" value="yes">' . TEXT_PRODUCTS_IMAGE_REMOVE_SHORT . '<br>' . tep_draw_separator('pixel_trans.gif', '5', '15') . '&nbsp;<input type="checkbox" name="delete_image_sm_6" value="yes">' . TEXT_PRODUCTS_IMAGE_DELETE_SHORT . '<br>' . tep_draw_separator('pixel_trans.gif', '1', '42'); ?><?php } } ?></td>
               <td class="smallText top-valign" colspan="2"><?php if (($_GET['pID']) && ($pInfo->products_image_xl_6) != '') { ?><?php if (tep_not_null($pInfo->products_image_xl_6)) { ?><?php echo $pInfo->products_image_xl_6 . '<br>' . tep_image(DIR_WS_CATALOG_IMAGES . $pInfo->products_image_xl_6, $pInfo->products_name_xl_6, SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT, 'align="left" hspace="0" vspace="5"') . '<br>'. tep_draw_separator('pixel_trans.gif', '5', '15') . '&nbsp;<input type="checkbox" name="unlink_image_xl_6" value="yes">' . TEXT_PRODUCTS_IMAGE_REMOVE_SHORT . '<br>' . tep_draw_separator('pixel_trans.gif', '5', '15') . '&nbsp;<input type="checkbox" name="delete_image_xl_6" value="yes">' . TEXT_PRODUCTS_IMAGE_DELETE_SHORT . '<br>' . tep_draw_separator('pixel_trans.gif', '1', '42'); ?><?php } } ?></td>
              </tr>
            </table></td>
          </tr>
<?php
  } else {
   echo tep_draw_hidden_field('products_previous_image_sm_1', $pInfo->products_image_sm_1) .
        tep_draw_hidden_field('products_previous_image_xl_1', $pInfo->products_image_xl_1) .
        tep_draw_hidden_field('products_previous_image_sm_2', $pInfo->products_image_sm_2) .
        tep_draw_hidden_field('products_previous_image_xl_2', $pInfo->products_image_xl_2) .
        tep_draw_hidden_field('products_previous_image_sm_3', $pInfo->products_image_sm_3) .
        tep_draw_hidden_field('products_previous_image_xl_3', $pInfo->products_image_xl_3) .
        tep_draw_hidden_field('products_previous_image_sm_4', $pInfo->products_image_sm_4) .
        tep_draw_hidden_field('products_previous_image_xl_4', $pInfo->products_image_xl_4) .
        tep_draw_hidden_field('products_previous_image_sm_5', $pInfo->products_image_sm_5) .
        tep_draw_hidden_field('products_previous_image_xl_5', $pInfo->products_image_xl_5) .
        tep_draw_hidden_field('products_previous_image_sm_6', $pInfo->products_image_sm_6) .
        tep_draw_hidden_field('products_previous_image_xl_6', $pInfo->products_image_xl_6);
     };
// EOF: MaxiDVD Added for Ulimited Images Pack!
?>
          <tr>
            <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
          
          </table>
        </div>

        <div id="prices">
          <table border="0">

          <tr>
            <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
          <!--TotalB2B start-->
		  <tr>
            <td class="main"><?php echo TEXT_PRODUCTS_TAX_CLASS; ?></td>
            <td class="main"><?php
			  $prices_num = tep_xppp_getpricesnum();
		      $gross_update = 'updateGross(\'products_price\');';
              for ($i=2; $i<=$prices_num; $i++)
				  $gross_update .= 'updateGross(\'products_price_'. $i . '\');';
		      echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_pull_down_menu('products_tax_class_id', $tax_class_array, $pInfo->products_tax_class_id, 'onchange="' . $gross_update .'"'); ?></td>
          </tr>
		  <tr>
            <td class="main" colspan="2"><br><?php echo ENTRY_PRODUCTS_PRICE . " 1";?></td>
          </tr>
          <tr>
            <td class="main"><?php echo TEXT_PRODUCTS_PRICE_NET; ?></td>
            <td class="main"><?php echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_input_field('products_price', $pInfo->products_price, 'onKeyUp="updateGross(\'products_price\')"'); ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo TEXT_PRODUCTS_PRICE_GROSS; ?></td>
            <td class="main"><?php echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_input_field('products_price_gross', $pInfo->products_price, 'OnKeyUp="updateNet(\'products_price\')"'); ?></td>
          </tr>

		  <?php
			  $prices_num = tep_xppp_getpricesnum();
              for ($i=2; $i<=$prices_num; $i++) {?>

          <tr>
            <td class="main" colspan="2"><br><?php echo ENTRY_PRODUCTS_PRICE . " " . $i;?>&nbsp;<input type="checkbox" name="<?php echo "checkbox_products_price_" . $i;?>" <?php
			    $products_price_X = "products_price_" . $i;
			    if ($pInfo->$products_price_X != NULL) echo " checked "; ?> value="true" onClick="if (!<?php echo "products_price_" . $i;?>.disabled) { <?php echo "products_price_" . $i;?>.disabled = true;  <?php echo "products_price_". $i . "_gross";?>.disabled = true; } else { <?php echo "products_price_" . $i;?>.disabled = false;  <?php echo "products_price_". $i . "_gross";?>.disabled = false; } "></td>
          </tr>
          <tr>
            <td class="main"><?php echo TEXT_PRODUCTS_PRICE_NET; ?></td>
            <td class="main"><?php
				$products_price_X = "products_price_" . $i;
			    if ($pInfo->$products_price_X == NULL) {
				  echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_input_field('products_price_' . $i, $pInfo->$products_price_X, 'onKeyUp="updateGross(\'products_price_' . $i .'\')", disabled');
				} else {
				  echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_input_field('products_price_' . $i, $pInfo->$products_price_X, 'onKeyUp="updateGross(\'products_price_' . $i .'\')"');
				} ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo TEXT_PRODUCTS_PRICE_GROSS; ?></td>
            <td class="main"><?php
				$products_price_X = "products_price_" . $i;
			    if ($pInfo->$products_price_X == NULL) {
				  echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_input_field('products_price_'. $i . '_gross', $pInfo->$products_price_X, 'OnKeyUp="updateNet(\'products_price_' . $i .'\')", disabled');
				} else {
				  echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_input_field('products_price_'. $i . '_gross', $pInfo->$products_price_X, 'OnKeyUp="updateNet(\'products_price_' . $i .'\')"');
				} ?>
			</td>
          </tr>

		  <?php } ?>

          <tr>
            <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>

<script language="javascript">
updateGross('products_price');
<?php
  $prices_num = tep_xppp_getpricesnum();
  for ($i=2; $i<=$prices_num; $i++) echo 'updateGross(\'products_price_' . $i . '\');';
?>
</script>
          <!--TotalB2B end-->

          </table>
        </div>
        
<?php
/////////////////////////////////////////////////////////////////////
// BOF: WebMakers.com Added: Draw Attribute Tables

 if (ALLOW_ATTRIBUTES_IN_PRODUCT_EDIT_PAGE == 'true') {

?>
        <div id="options">
          <table border="0">


      <tr>
        <td><table border="0" cellspacing="0" cellpadding="0" align="center" width="100%">
<?php
    $rows = 0;
    $options_query = tep_db_query("select products_options_id, products_options_name, products_options_sort_order from " . TABLE_PRODUCTS_OPTIONS . " where language_id = '" . $languages_id . "' order by products_options_sort_order, products_options_name");
    while ($options = tep_db_fetch_array($options_query)) {
      $values_query = tep_db_query("select pov.products_options_values_id, pov.products_options_values_name from " . TABLE_PRODUCTS_OPTIONS_VALUES . " pov, " . TABLE_PRODUCTS_OPTIONS_VALUES_TO_PRODUCTS_OPTIONS . " p2p where pov.products_options_values_id = p2p.products_options_values_id and p2p.products_options_id = '" . $options['products_options_id'] . "' and pov.language_id = '" . $languages_id . "' order by pov.products_options_values_name");
      $header = false;
      while ($values = tep_db_fetch_array($values_query)) {
        $rows ++;
        if (!$header) {
          $header = true;
?>
        <tr>
        <td class="main"><?php echo TEXT_ATTRIBUTE_HEAD ?></td>
        </tr>
        <tr>
        <td class="main"><?php echo TEXT_ATTRIBUTE_DESC ?></td>
        </tr>
          <tr valign="top">
<td><table border="0" cellpadding="0" cellspacing="0" width="100%">
              <tr class="dataTableHeadingRow">
              <td colspan="9" class="attributeBoxContent" align="center"><?php echo TABLE_HEADING_ATTRIBUTE_1 ?></td>
             </tr>
              <tr class="dataTableHeadingRow">
                <td class="attributeBoxContent" width="300" align="left"><?php echo $options['products_options_name']; ?></td>
                <td class="attributeBoxContent" align="center"><?php echo TABLE_HEADING_ATTRIBUTE_2 ?></td>
                <td class="attributeBoxContent" align="center"><?php echo TABLE_HEADING_ATTRIBUTE_3 ?></td>
                <td class="attributeBoxContent" align="center"><?php echo TABLE_HEADING_ATTRIBUTE_2 ?></td>
                <td class="attributeBoxContent" align="center"><?php echo TABLE_HEADING_ATTRIBUTE_9 ?></td>
                <td class="attributeBoxContent" align="center"><?php echo TABLE_HEADING_ATTRIBUTE_4 ?></td>
<?php if (DOWNLOAD_ENABLED == 'true') { ?>
                <td class="attributeBoxContent" align="center"><?php echo TABLE_HEADING_ATTRIBUTE_5 ?></td>
                <td class="attributeBoxContent" align="center"><?php echo TABLE_HEADING_ATTRIBUTE_6 ?></td>
                <td class="attributeBoxContent" align="center"><?php echo TABLE_HEADING_ATTRIBUTE_7 ?></td>
<?php } ?>
              </tr>
<?php
        }
        $attributes = array();
        if (sizeof($_POST) > 0) {
          if ($_POST['option'][$rows]) {
            $attributes = array(
                                'products_attributes_id' => $_POST['option'][$rows],
                                'options_values_price' => $_POST['price'][$rows],
                                'price_prefix' => $_POST['prefix'][$rows],
                                'products_attributes_weight' => $_POST['products_attributes_weight'][$rows],
                                'products_attributes_weight_prefix' => $_POST['products_attributes_weight_prefix'][$rows],
                                'products_options_sort_order' => $_POST['products_options_sort_order'][$rows],
                                    );
          }
        } else {
          $attributes_query = tep_db_query("select products_attributes_id, options_values_price, price_prefix, products_attributes_weight, products_attributes_weight_prefix, products_options_sort_order from " . TABLE_PRODUCTS_ATTRIBUTES . " where products_id = '" . $pInfo->products_id . "' and options_id = '" . $options['products_options_id'] . "' and options_values_id = '" . $values['products_options_values_id'] . "'");
          if (tep_db_num_rows($attributes_query) > 0) {
            $attributes = tep_db_fetch_array($attributes_query);
          }
        }

        $attributes_download = array();
        if (sizeof($_POST) > 0) {
          if ($_POST['option'][$rows]) {
            $attributes_download = array(
                                'products_attributes_filename' => $_POST['filename'][$rows],
                                'products_attributes_maxdays' => $_POST['maxdays'][$rows],
                                'products_attributes_maxcount' => $_POST['maxcount'][$rows],
                                    );
          }
        } else {
          $attributes_query_download = tep_db_query("select pad.products_attributes_id, pa.products_attributes_id, pad.products_attributes_filename, pad.products_attributes_maxdays, pad.products_attributes_maxcount from products_attributes pa,products_attributes_download pad where pa.products_id = '" . $pInfo->products_id . "' and pa.options_id = '" . $options['products_options_id'] . "' and pa.options_values_id = '" . $values['products_options_values_id'] . "' and pad.products_attributes_id = pa.products_attributes_id");

          if (tep_db_num_rows($attributes_query_download) > 0) {
            $attributes_download = tep_db_fetch_array($attributes_query_download);
          }
        }
?>
<?php
        if ($attributes['price_prefix'] == "+") { $posCheck = " SELECTED";
                                              $negCheck = "";
                                              
        } else { $posCheck = "";
                 $negCheck = " SELECTED";

        }
        if ($attributes['products_attributes_weight_prefix'] == "+") { 
        		$wposCheck = " SELECTED";
                	$wnegCheck = "";
	        } else { 	
	        	$wposCheck = "";
                 	$wnegCheck = " SELECTED";
        }
?> 
              <tr class="dataTableRow">
                <td class="dataTableContent" width="300"><?php echo tep_draw_checkbox_field('option[' . $rows . ']', $attributes['products_attributes_id'], $attributes['products_attributes_id']) . '&nbsp;' . $values['products_options_values_name']; ?>&nbsp;</td>
                <td class="dataTableContent" align="center"><select name="prefix[<?php echo $rows ?>]"> <option value="+" <?php echo $posCheck ?>>+<option value="-" <?php echo $negCheck ?>>-</select></td>
                <td class="dataTableContent" align="center"><?php echo tep_draw_input_field('price[' . $rows . ']', $attributes['options_values_price'], 'size="7"'); ?></td>
                <td class="dataTableContent" align="center"><select name="products_attributes_weight_prefix[<?php echo $rows ?>]"> <option value="+" <?php echo $wposCheck ?>>+<option value="-" <?php echo $wnegCheck ?>>-</select></td>
                <td class="dataTableContent" align="center"><?php echo tep_draw_input_field('products_attributes_weight[' . $rows . ']', $attributes['products_attributes_weight'], 'size="4"'); ?></td>
                <td class="dataTableContent" align="center"><?php echo tep_draw_input_field('products_options_sort_order[' . $rows . ']', $attributes['products_options_sort_order'], 'size="2"'); ?></td>
<?php if (DOWNLOAD_ENABLED == 'true') { ?>
                <td class="dataTableContent" align="center"><?php echo tep_draw_input_field('filename[' . $rows . ']', $attributes_download['products_attributes_filename'], 'size="12" id=filename[' . $rows . ']'); ?></td>
                <td class="dataTableContent" align="center"><?php echo tep_draw_input_field('maxdays[' . $rows . ']', $attributes_download['products_attributes_maxdays'], 'size="2"'); ?></td>
                <td class="dataTableContent" align="center"><?php echo tep_draw_input_field('maxcount[' . $rows . ']', $attributes_download['products_attributes_maxcount'], 'size="2"'); ?></td>
<?php } ?>
                             </tr>
<?php
      }
      if ($header) {
?>
            </table></td>
<?php
      }
    }
?>
          </tr>
        </table></td>
      </tr>
<?php
}
// EOF: WebMakers.com Added: Draw Attribute Tables
/////////////////////////////////////////////////////////////////////
?>

          </table>
        </div>

<!-- ������������ -->
        <div id="specs">
          <table border="0" class="main">

<?php
// Start Products Specifications
    if (SPECIFICATIONS_BOX_FRAME_STYLE == 'Tabs') {
?>
          <tr>
            <td colspan=2>
<?php
      require (DIR_WS_MODULES . FILENAME_PRODUCTS_TABS);
    } else {
// End Products Specifications
?>
<?php 
// Products Specifications
      require (DIR_WS_MODULES . FILENAME_PRODUCTS_SPECIFICATIONS_INPUT);
?>
<?php
// Products Specifications
    } // if (SPECIFICATIONS_BOX_FRAME_STYLE ... else ...
?>

          </table>
        </div>

       </div>
      
        </form>

<?php
  } elseif ($action == 'new_product_preview') {
    if (tep_not_null($_POST)) {
      $pInfo = new objectInfo($_POST);
      $products_name = $_POST['products_name'];
      $products_info = $_POST['products_info'];
      $products_description = $_POST['products_description'];
// Start Products Specifications
      $products_tab_1 = $_POST['products_tab_1'];
      $products_tab_2 = $_POST['products_tab_2'];
      $products_tab_3 = $_POST['products_tab_3'];
      $products_tab_4 = $_POST['products_tab_4'];
      $products_tab_5 = $_POST['products_tab_5'];
      $products_tab_6 = $_POST['products_tab_6'];
// End Products Specifications
      $products_head_title_tag = $_POST['products_head_title_tag'];
      $products_head_desc_tag = $_POST['products_head_desc_tag'];
      $products_head_keywords_tag = $_POST['products_head_keywords_tag'];
      $products_url = $_POST['products_url'];
    } else {

	  //TotalB2B start
      $products_price_list = tep_xppp_getpricelist("p");
// BOF MaxiDVD: Modified For Ultimate Images Pack!
      $product_query = tep_db_query("select p.products_id, pd.language_id, pd.products_name, pd.products_info, pd.products_description, pd.products_head_title_tag, pd.products_head_desc_tag, pd.products_head_keywords_tag, pd.products_url, p.products_quantity, p.products_model, p.products_image, p.products_image_med, p.products_image_lrg, p.products_image_sm_1, p.products_image_xl_1, p.products_image_sm_2, p.products_image_xl_2, p.products_image_sm_3, p.products_image_xl_3, p.products_image_sm_4, p.products_image_xl_4, p.products_image_sm_5, p.products_image_xl_5, p.products_image_sm_6, p.products_image_xl_6, " . $products_price_list . ", p.products_weight, p.products_date_added, p.products_last_modified, p.products_date_available, p.products_status, p.products_to_xml, p.products_quantity_order_min, p.products_quantity_order_units, p.products_sort_order, p.manufacturers_id  from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd where p.products_id = pd.products_id and p.products_id = '" . (int)$_GET['pID'] . "'");
// EOF MaxiDVD: Modified For Ultimate Images Pack!
      $product = tep_db_fetch_array($product_query);

      $pInfo = new objectInfo($product);
      $products_image_name = $pInfo->products_image;
      $products_image_med_name = $pInfo->products_image_med;
      $products_image_lrg_name = $pInfo->products_image_lrg;
      $products_image_sm_1_name = $pInfo->products_image_sm_1;
      $products_image_sm_2_name = $pInfo->products_image_sm_2;
      $products_image_sm_3_name = $pInfo->products_image_sm_3;
      $products_image_sm_4_name = $pInfo->products_image_sm_4;
      $products_image_sm_5_name = $pInfo->products_image_sm_5;
      $products_image_sm_6_name = $pInfo->products_image_sm_6;
      $products_image_xl_1_name = $pInfo->products_image_xl_1;
      $products_image_xl_2_name = $pInfo->products_image_xl_2;
      $products_image_xl_3_name = $pInfo->products_image_xl_3;
      $products_image_xl_4_name = $pInfo->products_image_xl_4;
      $products_image_xl_5_name = $pInfo->products_image_xl_5;
      $products_image_xl_6_name = $pInfo->products_image_xl_6;
    }

    $form_action = (isset($_GET['pID'])) ? 'update_product' : 'insert_product';

    echo tep_draw_form($form_action, FILENAME_CATEGORIES, 'cPath=' . $cPath . (isset($_GET['pID']) ? '&pID=' . $_GET['pID'] : '') . '&action=' . $form_action, 'post', 'enctype="multipart/form-data"');

    $languages = tep_get_languages();
    for ($i=0, $n=sizeof($languages); $i<$n; $i++) {
      if (isset($_GET['read']) && ($_GET['read'] == 'only')) {
        $pInfo->products_name = tep_get_products_name($pInfo->products_id, $languages[$i]['id']);
        $pInfo->products_info = tep_get_products_info($pInfo->products_id, $languages[$i]['id']);
        $pInfo->products_description = tep_get_products_description($pInfo->products_id, $languages[$i]['id']);
// Start Products Specifications
        $products_tabs = tep_get_products_tabs ($pInfo->products_id, $languages[$i]['id']);
        $pInfo->products_tab_1 = $products_tabs['1'];
        $pInfo->products_tab_2 = $products_tabs['2'];
        $pInfo->products_tab_3 = $products_tabs['3'];
        $pInfo->products_tab_4 = $products_tabs['4'];
        $pInfo->products_tab_5 = $products_tabs['5'];
        $pInfo->products_tab_6 = $products_tabs['6'];
// End Products Specifications
        $pInfo->products_head_title_tag = tep_db_prepare_input($products_head_title_tag[$languages[$i]['id']]);
        $pInfo->products_head_desc_tag = tep_db_prepare_input($products_head_desc_tag[$languages[$i]['id']]);
        $pInfo->products_head_keywords_tag = tep_db_prepare_input($products_head_keywords_tag[$languages[$i]['id']]);
        $pInfo->products_url = tep_get_products_url($pInfo->products_id, $languages[$i]['id']);
      } else {
        $pInfo->products_name = tep_db_prepare_input($products_name[$languages[$i]['id']]);
        $pInfo->products_info = tep_db_prepare_input($products_info[$languages[$i]['id']]);
        $pInfo->products_description = tep_db_prepare_input($products_description[$languages[$i]['id']]);
        $pInfo->products_head_title_tag = tep_db_prepare_input($products_head_title_tag[$languages[$i]['id']]);
        $pInfo->products_head_desc_tag = tep_db_prepare_input($products_head_desc_tag[$languages[$i]['id']]);
        $pInfo->products_head_keywords_tag = tep_db_prepare_input($products_head_keywords_tag[$languages[$i]['id']]);
        $pInfo->products_url = tep_db_prepare_input($products_url[$languages[$i]['id']]);
      }
?>
    <table class="table-padding-2">
      <tr>
        <td><table class="table-padding-0">
          <tr>
            <td class="pageHeading"><?php echo tep_image(DIR_WS_CATALOG_LANGUAGES . $languages[$i]['directory'] . '/images/' . $languages[$i]['image'], $languages[$i]['name']) . '&nbsp;' . $pInfo->products_name; ?></td>
			<!--TotalB2B start-->
			<td class="pageHeading" align="right"><?php
				$prices_num = tep_xppp_getpricesnum();
			    echo ENTRY_PRODUCTS_PRICE . " 1: " . $currencies->format($pInfo->products_price);
                for ($b=2; $b<=$prices_num; $b++) {
				   $products_price_X = "products_price_" . $b;
				   echo "<br>" . ENTRY_PRODUCTS_PRICE . " " . $b. ": ";
				   if (tep_not_null($_POST)) {
					 if (tep_db_prepare_input($_POST['checkbox_products_price_' . $b]) != "true") echo ENTRY_PRODUCTS_PRICE_DISABLED;
				     else echo $currencies->format($pInfo->$products_price_X);
				   } else {
				     if ($product['products_price_' . $b] == NULL) echo ENTRY_PRODUCTS_PRICE_DISABLED;
				     else echo $currencies->format($pInfo->$products_price_X);
				   }
				}
			?></td>
			<!--TotalB2B end-->
          </tr>
        </table></td>
      </tr>
<!-- // BOF MaxiDVD: Modified For Ultimate Images Pack! // -->
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
      <tr>
        <td class="main">
<?php if ($products_image_med_name) { ?><?php echo tep_image(DIR_WS_CATALOG_IMAGES . $products_image_med_name, $products_image_med_name, MEDIUM_IMAGE_WIDTH, MEDIUM_IMAGE_HEIGHT, 'align="right" hspace="5" vspace="5"'); } elseif ($products_image_lrg_name) { ?>
<script language="javascript"><!--
      document.write('<?php echo '<a href="javascript:popupWindow(\\\'' . tep_href_link(FILENAME_POPUP_IMAGE, 'image=' . $products_image_lrg_name) . '\\\')">' . tep_image(DIR_WS_CATALOG_IMAGES . $products_image_name, $products_image_name, SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT, 'align="right" hspace="5" vspace="5"') . '</a>'; ?>');
//--></script>
<?php } elseif ($products_image_name) { ?><?php echo tep_image(DIR_WS_CATALOG_IMAGES . $products_image_name, $products_image_name, SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT, 'align="right" hspace="5" vspace="5"');}; ?>
<?php echo $pInfo->products_description . '<br><br><center>'; ?>
<?php if ($products_image_xl_1_name) { ?>
<script language="javascript"><!--
      document.write('<?php echo '<a href="javascript:popupWindow(\\\'' . tep_href_link(FILENAME_POPUP_IMAGE, 'image=' . $products_image_sm_1_name) . '\\\')">' . tep_image(DIR_WS_CATALOG_IMAGES . $products_image_sm_1_name, $products_image_sm_1_name, SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT, 'align="center" hspace="5" vspace="5"') . '</a>'; ?>');
//--></script>
<?php } elseif ($products_image_sm_1_name) { ?><?php echo tep_image(DIR_WS_CATALOG_IMAGES . $products_image_sm_1_name, $products_image_sm_1_name, SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT, 'align="center" hspace="5" vspace="5"'); }; ?>
<?php if ($products_image_xl_2_name) { ?>
<script language="javascript"><!--
      document.write('<?php echo '<a href="javascript:popupWindow(\\\'' . tep_href_link(FILENAME_POPUP_IMAGE, 'image=' . $products_image_sm_2_name) . '\\\')">' . tep_image(DIR_WS_CATALOG_IMAGES . $products_image_sm_2_name, $products_image_sm_2_name, SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT, 'align="center" hspace="5" vspace="5"') . '</a>'; ?>');
//--></script>
<?php } elseif ($products_image_sm_2_name) { ?><?php echo tep_image(DIR_WS_CATALOG_IMAGES . $products_image_sm_2_name, $products_image_sm_2_name, SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT, 'align="center" hspace="5" vspace="5"'); }; ?>
<?php if ($products_image_xl_3_name) { ?>
<script language="javascript"><!--
      document.write('<?php echo '<a href="javascript:popupWindow(\\\'' . tep_href_link(FILENAME_POPUP_IMAGE, 'image=' . $products_image_sm_3_name) . '\\\')">' . tep_image(DIR_WS_CATALOG_IMAGES . $products_image_sm_3_name, $products_image_sm_3_name, SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT, 'align="center" hspace="5" vspace="5"') . '</a>'; ?>');
//--></script>
<?php } elseif ($products_image_sm_3_name) { ?><?php echo tep_image(DIR_WS_CATALOG_IMAGES . $products_image_sm_3_name, $products_image_sm_3_name, SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT, 'align="center" hspace="5" vspace="5"'); }; ?>
<?php if ($products_image_xl_4_name) { ?>
<script language="javascript"><!--
      document.write('<?php echo '<a href="javascript:popupWindow(\\\'' . tep_href_link(FILENAME_POPUP_IMAGE, 'image=' . $products_image_sm_4_name) . '\\\')">' . tep_image(DIR_WS_CATALOG_IMAGES . $products_image_sm_4_name, $products_image_sm_4_name, SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT, 'align="center" hspace="5" vspace="5"') . '</a>'; ?>');
//--></script>
<?php } elseif ($products_image_sm_4_name) { ?><?php echo tep_image(DIR_WS_CATALOG_IMAGES . $products_image_sm_4_name, $products_image_sm_4_name, SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT, 'align="center" hspace="5" vspace="5"'); }; ?>
<?php if ($products_image_xl_5_name) { ?>
<script language="javascript"><!--
      document.write('<?php echo '<a href="javascript:popupWindow(\\\'' . tep_href_link(FILENAME_POPUP_IMAGE, 'image=' . $products_image_sm_5_name) . '\\\')">' . tep_image(DIR_WS_CATALOG_IMAGES . $products_image_sm_5_name, $products_image_sm_5_name, SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT, 'align="center" hspace="5" vspace="5"') . '</a>'; ?>');
//--></script>
<?php } elseif ($products_image_sm_5_name) { ?><?php echo tep_image(DIR_WS_CATALOG_IMAGES . $products_image_sm_5_name, $products_image_sm_5_name, SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT, 'align="center" hspace="5" vspace="5"'); }; ?>
<?php if ($products_image_xl_6_name) { ?>
<script language="javascript"><!--
      document.write('<?php echo '<a href="javascript:popupWindow(\\\'' . tep_href_link(FILENAME_POPUP_IMAGE, 'image=' . $products_image_sm_6_name) . '\\\')">' . tep_image(DIR_WS_CATALOG_IMAGES . $products_image_sm_6_name, $products_image_sm_6_name, SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT, 'align="center" hspace="6" vspace="6"') . '</a>'; ?>');
//--></script>
<?php } elseif ($products_image_sm_6_name) { ?><?php echo tep_image(DIR_WS_CATALOG_IMAGES . $products_image_sm_6_name, $products_image_sm_6_name, SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT, 'align="center" hspace="6" vspace="6"'); }; ?>
        </td>
      </tr>
<!-- // EOF MaxiDVD: Modified For Ultimate Images Pack! // -->

    <td class="main">
         <?php 
 // START: Extra Fields Contribution (chapter 1.5)
          if ($_GET['read'] == 'only') {
            $products_extra_fields_query = tep_db_query("SELECT * FROM " . TABLE_PRODUCTS_TO_PRODUCTS_EXTRA_FIELDS . " WHERE products_id=" . (int)$_GET['pID']);
            while ($products_extra_fields = tep_db_fetch_array($products_extra_fields_query)) {
              $extra_fields_array[$products_extra_fields['products_extra_fields_id']] = $products_extra_fields['products_extra_fields_value'];
            }
          }
          else {
            $extra_fields_array = $_POST['extra_field'];
          }

          $extra_fields_names_query = tep_db_query("SELECT * FROM " . TABLE_PRODUCTS_EXTRA_FIELDS. " WHERE languages_id='0' or languages_id='".(int)$languages[$i]['id']."' ORDER BY products_extra_fields_order");
          while ($extra_fields_names = tep_db_fetch_array($extra_fields_names_query)) {
            $extra_field_name[$extra_fields_names['products_extra_fields_id']] = $extra_fields_names['products_extra_fields_name'];
			echo '<B>'.$extra_fields_names['products_extra_fields_name'].':</B>&nbsp;'.stripslashes($extra_fields_array[$extra_fields_names['products_extra_fields_id']]).'<BR>'."\n";
          }		  
// END: Extra Fields Contribution

         ?>
       </td>

<tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
<tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
<tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>

          <tr>
            <td class="main"><b><u><?php echo sprintf(TEXT_PRODUCTS_INFO); ?></u></b></td>
            <td class="main" align="right"></td>
          </tr>


      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
      <tr>
        <td class="main"><?php echo $pInfo->products_info; ?></td>
      </tr>
<tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
<tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>

<tr>
        <td>
<?php
// Products Specifications
      include (DIR_WS_MODULES . FILENAME_PRODUCTS_SPECIFICATIONS);
?>
</td>
      </tr>

<?php
      if ($pInfo->products_url) {
?>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
      <tr>
        <td class="main"><?php echo sprintf(TEXT_PRODUCT_MORE_INFORMATION, $pInfo->products_url); ?></td>
      </tr>
<?php
      }
?>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
<?php
      if ($pInfo->products_date_available > date('Y-m-d')) {
?>
      <tr>
        <td align="center" class="smallText"><?php echo sprintf(TEXT_PRODUCT_DATE_AVAILABLE, tep_date_long($pInfo->products_date_available)); ?></td>
      </tr>
<?php
      } else {
?>
      <tr>
        <td align="center" class="smallText"><?php echo sprintf(TEXT_PRODUCT_DATE_ADDED, tep_date_long($pInfo->products_date_added)); ?></td>
      </tr>
<?php
      }
?>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
<?php
    }

    if (isset($_GET['read']) && ($_GET['read'] == 'only')) {
      if (isset($_GET['origin'])) {
        $pos_params = strpos($_GET['origin'], '?', 0);
        if ($pos_params != false) {
          $back_url = substr($_GET['origin'], 0, $pos_params);
          $back_url_params = substr($_GET['origin'], $pos_params + 1);
        } else {
          $back_url = $_GET['origin'];
          $back_url_params = '';
        }
      } else {
        $back_url = FILENAME_CATEGORIES;
        $back_url_params = 'cPath=' . $cPath . '&pID=' . $pInfo->products_id;
      }
?>
      <tr>
        <td align="right"><?php echo '<a href="' . tep_href_link($back_url, $back_url_params, 'NONSSL') . '">' . tep_image_button('button_back.gif', IMAGE_BACK) . '</a>'; ?></td>
      </tr>
<?php
    } else {
?>
      <tr>
        <td align="right" class="smallText">
<?php
/////////////////////////////////////////////////////////////////////
// BOF: WebMakers.com Added: Preview Back
/* Re-Post all POST'ed variables */
      reset($_POST);
      while (list($key, $value) = each($_POST)) {
        if (is_array($value)) {
          while (list($k, $v) = each($value)) {
            echo tep_draw_hidden_field($key . '[' . $k . ']', htmlspecialchars(stripslashes($v)));
          }
        } else {
          echo tep_draw_hidden_field($key, htmlspecialchars(stripslashes($value)));
        }
      }
      $languages = tep_get_languages();
      for ($i=0, $n=sizeof($languages); $i<$n; $i++) {
        echo tep_draw_hidden_field('products_name[' . $languages[$i]['id'] . ']', htmlspecialchars(stripslashes($products_name[$languages[$i]['id']])));
        echo tep_draw_hidden_field('products_info[' . $languages[$i]['id'] . ']', htmlspecialchars(stripslashes($products_info[$languages[$i]['id']])));
        echo tep_draw_hidden_field('products_description[' . $languages[$i]['id'] . ']', htmlspecialchars(stripslashes($products_description[$languages[$i]['id']])));
        echo tep_draw_hidden_field('products_head_title_tag[' . $languages[$i]['id'] . ']', htmlspecialchars(stripslashes($products_head_title_tag[$languages[$i]['id']])));
        echo tep_draw_hidden_field('products_head_desc_tag[' . $languages[$i]['id'] . ']', htmlspecialchars(stripslashes($products_head_desc_tag[$languages[$i]['id']])));
        echo tep_draw_hidden_field('products_head_keywords_tag[' . $languages[$i]['id'] . ']', htmlspecialchars(stripslashes($products_head_keywords_tag[$languages[$i]['id']])));
        echo tep_draw_hidden_field('products_url[' . $languages[$i]['id'] . ']', htmlspecialchars(stripslashes($products_url[$languages[$i]['id']])));
// Start Products Specifications
        echo tep_draw_hidden_field ('products_tab_1[' . $languages[$i]['id'] . ']', htmlspecialchars (stripslashes ($products_tab_1[$languages[$i]['id']])));
        echo tep_draw_hidden_field ('products_tab_2[' . $languages[$i]['id'] . ']', htmlspecialchars (stripslashes ($products_tab_2[$languages[$i]['id']])));
        echo tep_draw_hidden_field ('products_tab_3[' . $languages[$i]['id'] . ']', htmlspecialchars (stripslashes ($products_tab_3[$languages[$i]['id']])));
        echo tep_draw_hidden_field ('products_tab_4[' . $languages[$i]['id'] . ']', htmlspecialchars (stripslashes ($products_tab_4[$languages[$i]['id']])));
        echo tep_draw_hidden_field ('products_tab_5[' . $languages[$i]['id'] . ']', htmlspecialchars (stripslashes ($products_tab_5[$languages[$i]['id']])));
        echo tep_draw_hidden_field ('products_tab_6[' . $languages[$i]['id'] . ']', htmlspecialchars (stripslashes ($products_tab_6[$languages[$i]['id']])));

        $specifications_query_raw = "select s.specifications_id
                                     from " . TABLE_SPECIFICATION . " s, 
                                          " . TABLE_SPECIFICATIONS_TO_CATEGORIES . " sg2c
                                     where sg2c.specification_group_id = s.specification_group_id 
                                       and sg2c.categories_id = '" . (int) $current_category_id . "'
                                   ";
        // print $specifications_query_raw . "<br>\n";
        $specifications_query = tep_db_query ($specifications_query_raw);
        while ($specifications = tep_db_fetch_array ($specifications_query) ) {
          $specification_id = $specifications['specifications_id'];
          $specification = $_POST['products_specification'][$specification_id][$languages[$i]['id']];
          if (is_array ($specification) ) {
            $value_number = 0;
            foreach ($specification as $each_specification) {
              echo tep_draw_hidden_field ('products_specification[' . $specification_id . '][' . $languages[$i]['id'] . '][' . $value_number . ']', htmlspecialchars (stripslashes ($each_specification) ) ) . "\n";
              $value_number++;
            }
          } else {
            echo tep_draw_hidden_field ('products_specification[' . $specification_id . '][' . $languages[$i]['id'] . ']', htmlspecialchars (stripslashes ($specification) ) ) . "\n";
          }
        }
// End Products Specifications
      }

    // START: Extra Fields Contribution
      if ($_POST['extra_field']) { // Check to see if there are any need to update extra fields.
        foreach ($_POST['extra_field'] as $key=>$val) {
          echo tep_draw_hidden_field('extra_field['.$key.']', stripslashes($val));
        }
      } // Check to see if there are any need to update extra fields.
      // END: Extra Fields Contribution

      echo tep_draw_hidden_field('products_image', stripslashes($products_image_name));
// BOF MaxiDVD: Added For Ultimate Images Pack!
      echo tep_draw_hidden_field('products_image_med', stripslashes($products_image_med_name));
      echo tep_draw_hidden_field('products_image_lrg', stripslashes($products_image_lrg_name));
      echo tep_draw_hidden_field('products_image_sm_1', stripslashes($products_image_sm_1_name));
      echo tep_draw_hidden_field('products_image_xl_1', stripslashes($products_image_xl_1_name));
      echo tep_draw_hidden_field('products_image_sm_2', stripslashes($products_image_sm_2_name));
      echo tep_draw_hidden_field('products_image_xl_2', stripslashes($products_image_xl_2_name));
      echo tep_draw_hidden_field('products_image_sm_3', stripslashes($products_image_sm_3_name));
      echo tep_draw_hidden_field('products_image_xl_3', stripslashes($products_image_xl_3_name));
      echo tep_draw_hidden_field('products_image_sm_4', stripslashes($products_image_sm_4_name));
      echo tep_draw_hidden_field('products_image_xl_4', stripslashes($products_image_xl_4_name));
      echo tep_draw_hidden_field('products_image_sm_5', stripslashes($products_image_sm_5_name));
      echo tep_draw_hidden_field('products_image_xl_5', stripslashes($products_image_xl_5_name));
      echo tep_draw_hidden_field('products_image_sm_6', stripslashes($products_image_sm_6_name));
      echo tep_draw_hidden_field('products_image_xl_6', stripslashes($products_image_xl_6_name));
// EOF MaxiDVD: Added For Ultimate Images Pack!
      echo tep_image_submit('button_back.gif', IMAGE_BACK, 'name="edit"') . '&nbsp;&nbsp;';

      if (isset($_GET['pID'])) {
        echo tep_image_submit('button_update.gif', IMAGE_UPDATE);
      } else {
        echo tep_image_submit('button_insert.gif', IMAGE_INSERT);
      }
      echo '&nbsp;&nbsp;<a href="' . tep_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . (isset($_GET['pID']) ? '&pID=' . $_GET['pID'] : '')) . '">' . tep_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>';
?></td>
      </tr>
    </table></form>
<?php
    }
  } else {
?>
    <table class="table-padding-2">
      <tr>
        <td><table class="table-padding-0">
          <tr>
            <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
            <td class="pageHeading" align="right"><?php echo tep_draw_separator('pixel_trans.gif', 1, HEADING_IMAGE_HEIGHT); ?></td>
            <td align="right"><table class="table-padding-0">
              <tr>
                <td class="smallText" align="right">
<?php
// BOF: KategorienAdmin / OLISWISS
//  if ($admin_groups_id == 1) {
    echo tep_draw_form('search', FILENAME_CATEGORIES, '', 'get');
    echo HEADING_TITLE_SEARCH . ' ' . tep_draw_input_field('search') . tep_draw_hidden_field('search_model_key','no');

    echo tep_hide_session_id() . '</form><br>';

    echo tep_draw_form('search', FILENAME_CATEGORIES, '', 'get');
    echo HEADING_TITLE_SEARCH_MODEL . ' ' . tep_draw_input_field('search') . tep_draw_hidden_field('search_model_key','yes');

    echo tep_hide_session_id() . '</form>'; 
//  }
// EOF: KategorienAdmin / OLISWISS
?>

                </td>
              </tr>
              <tr>
                <td class="smallText" align="right">
<?php
// BOF: KategorienAdmin / OLISWISS
//  echo tep_draw_form('goto', FILENAME_CATEGORIES, '', 'get');
//  echo HEADING_TITLE_GOTO . ' ' . tep_draw_pull_down_menu('cPath', tep_get_category_tree(), $current_category_id, 'onChange="this.form.submit();"');
//  echo '</form>';
  if (is_array($admin_cat_access_array_cats) && (in_array("ALL",$admin_cat_access_array_cats)== false) && (pos($admin_cat_access_array_cats)!= "")) {
    echo tep_draw_form('goto', FILENAME_CATEGORIES, '', 'get');
    echo HEADING_TITLE_GOTO . ' ' . tep_draw_pull_down_menu('cPath', tep_get_category_tree('','','','',$admin_cat_access_array_cats), $current_category_id, 'onChange="this.form.submit();"');
    echo '</form>';
  } else if (in_array("ALL",$admin_cat_access_array_cats)== true) { //nur Top-ADMIN
    echo tep_draw_form('goto', FILENAME_CATEGORIES, '', 'get');
    echo HEADING_TITLE_GOTO . ' ' . tep_draw_pull_down_menu('cPath', tep_get_category_tree(), $current_category_id, 'onChange="this.form.submit();"');
    echo tep_hide_session_id() . '</form>'; 
  }
// EOF: KategorienAdmin / OLISWISS
?>

                </td>
              </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><table class="table-padding-0">
          <tr>
          <script language="JavaScript"> 
<!-- �����������! 
function yesqw() 
{ 
var response = confirm('<?php echo TEXT_DELETE_CONFIRM; ?>'); 
if ( response == true ) 
{ 
return true;
} 
else {return false;}
} 

// ������� ����������. --> 
</script>
          
            <td valign="top"><form name="emailForm" action="?action=delete_category_confirm&cPath=<?php echo $_GET['cPath'] ?>" method="post" onSubmit="return yesqw();" >
			
			
			<?php $qaz=0; $marg=17; ?><table class="table-padding-2">
              <tr class="dataTableHeadingRow">
              <td class="dataTableHeadingContent"></td>
                <td class="dataTableHeadingContent"><input type="checkbox" onClick="javascript:CheckAll(this.checked);">&nbsp;<?php echo TABLE_HEADING_CATEGORIES_PRODUCTS; ?></td>
                <td class="dataTableHeadingContent" align="center"><?php echo TABLE_HEADING_STATUS; ?></td>
                <td class="dataTableHeadingContent" align="center"><?php echo TABLE_HEADING_XML; ?></td>
                <td class="dataTableHeadingContent" align="center"><?php echo TABLE_HEADING_PRODUCT_SORT; ?></td>
                <td class="dataTableHeadingContent" align="center">&nbsp;</td>
              </tr>
<?php
    $categories_count = 0;
    $rows = 0;
    if (isset($_GET['search'])) {
      $search = tep_db_prepare_input($_GET['search']);
// BOF Enable - Disable Categories Contribution--------------------------------------
      $categories_query = tep_db_query("select c.categories_id, cd.categories_name, cd.categories_meta_title, cd.categories_meta_description, cd.categories_meta_keywords, c.categories_image, c.parent_id, c.sort_order, c.date_added, c.last_modified, c.categories_status from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd where c.categories_id = cd.categories_id and cd.language_id = '" . (int)$languages_id . "' and cd.categories_name like '%" . tep_db_input($search) . "%' order by c.sort_order, cd.categories_name");
    } else {
// BOF: KategorienAdmin / OLISWISS
    if ($admin_cat_access == "ALL") {
      $categories_query = tep_db_query("select c.categories_id, cd.categories_name, cd.categories_meta_title, cd.categories_meta_description, cd.categories_meta_keywords, c.categories_image, c.parent_id, c.sort_order, c.date_added, c.last_modified, c.categories_status from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd where c.parent_id = '" . (int)$current_category_id . "' and c.categories_id = cd.categories_id and cd.language_id = '" . (int)$languages_id . "' order by c.sort_order, cd.categories_name");
    } else if ($admin_cat_access == ""){

//      $categories_query = tep_db_query("");

      $categories_query = tep_db_query("select c.categories_id, cd.categories_name, cd.categories_meta_title, cd.categories_meta_description, cd.categories_meta_keywords, c.categories_image, c.parent_id, c.sort_order, c.date_added, c.last_modified, c.categories_status from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd where c.parent_id = '" . (int)$current_category_id . "' and c.categories_id = cd.categories_id and cd.language_id = '" . (int)$languages_id . "' order by c.sort_order, cd.categories_name");
    } else {
      $categories_query = tep_db_query("select c.categories_id, cd.categories_name, cd.categories_meta_title, cd.categories_meta_description, cd.categories_meta_keywords, c.categories_image, c.parent_id, c.sort_order, c.date_added, c.last_modified, c.categories_status from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd where c.parent_id = '" . (int)$current_category_id . "' and (c.parent_id or c.categories_id in (" . $admin_cat_access . ")) and c.categories_id = cd.categories_id and cd.language_id = '" . (int)$languages_id . "' order by c.sort_order, cd.categories_name");
    }
   }
// EOF: KategorienAdmin / OLISWISS
// EOF Enable - Disable Categories Contribution--------------------------------------

    while ($categories = tep_db_fetch_array($categories_query)) {
      $categories_count++;
      $rows++;

// Get parent_id for subcategories if search
      if (isset($_GET['search'])) $cPath= $categories['parent_id'];

      if ((!isset($_GET['cID']) && !isset($_GET['pID']) || (isset($_GET['cID']) && ($_GET['cID'] == $categories['categories_id']))) && !isset($cInfo) && (substr($action, 0, 3) != 'new')) {
        $category_childs = array('childs_count' => tep_childs_in_category_count($categories['categories_id']));
        $category_products = array('products_count' => tep_products_in_category_count($categories['categories_id']));

        $cInfo_array = array_merge($categories, $category_childs, $category_products);
        $cInfo = new objectInfo($cInfo_array);
      }

// BOF: KategorienAdmin / OLISWISS
     if ($admin_groups_id == 1 || is_array(array_intersect(explode('_',$_GET['cPath']),$admin_cat_access_array_cats)) ) {
// EOF: KategorienAdmin / OLISWISS

      if (isset($cInfo) && is_object($cInfo) && ($categories['categories_id'] == $cInfo->categories_id) ) {
        echo '              <tr id="defaultSelected" class="dataTableRowSelected" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)">' . "\n";
      } else {
        echo '              <tr class="dataTableRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)">' . "\n";
      }
?>
                  <td>                    </td> <td class="dataTableContent">
                    <input name="categories_id2[<?php echo $qaz; ?>]" type="checkbox"  value="<?php echo $categories['categories_id']; $qaz++; ?>" >&nbsp; 
                    <?php echo '<a href="' . tep_href_link(FILENAME_CATEGORIES, tep_get_path($categories['categories_id'])) . '">' . tep_image(DIR_WS_ICONS . 'folder.gif', ICON_FOLDER) . '</a>&nbsp;<b><a href="' . tep_href_link(FILENAME_CATEGORIES, tep_get_path($categories['categories_id'])) . '">' . $categories['categories_name'] . '</a></b>'; ?></td>
<!-- BOF Enable - Disable Categories Contribution-------------------------------------->
                <td class="dataTableContent" align="center">
<?php
      if ($categories['categories_status'] == '1') {
        echo tep_image(DIR_WS_IMAGES . 'icon_status_green.gif', IMAGE_ICON_STATUS_GREEN, 10, 10) . '&nbsp;&nbsp;<a href="' . tep_href_link(FILENAME_CATEGORIES, 'action=setflag_cat&flag=0&cID=' . $categories['categories_id'] . '&cPath=' . $cPath) . '">' . tep_image(DIR_WS_IMAGES . 'icon_status_red_light.gif', IMAGE_ICON_STATUS_RED_LIGHT, 10, 10) . '</a>';
      } else {
        echo '<a href="' . tep_href_link(FILENAME_CATEGORIES, 'action=setflag_cat&flag=1&cID=' . $categories['categories_id'] . '&cPath=' . $cPath) . '">' . tep_image(DIR_WS_IMAGES . 'icon_status_green_light.gif', IMAGE_ICON_STATUS_GREEN_LIGHT, 10, 10) . '</a>&nbsp;&nbsp;' . tep_image(DIR_WS_IMAGES . 'icon_status_red.gif', IMAGE_ICON_STATUS_RED, 10, 10);
      }
?>                </td>
<!-- EOF Enable - Disable Categories Contribution-------------------------------------->
                <td class="dataTableContent" align="center">&nbsp;</td> 
                <!-- // tth-->
                <td class="dataTableContent" align="center"><input size="2"  type="text" name="cat_id[<?php echo $categories['categories_id']; ?>]"  value="<?php echo $categories['sort_order']; ?>"></td> <!-- // tth-->
                <td class="dataTableContent" align="right"><?php if (isset($cInfo) && is_object($cInfo) && ($categories['categories_id'] == $cInfo->categories_id) ) { echo tep_image(DIR_WS_IMAGES . 'icon_arrow_right.gif', ''); } else { echo '<a href="' . tep_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . '&cID=' . $categories['categories_id']) . '">' . tep_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . '</a>'; } ?>                  &nbsp;</td>
              </tr>
<?php
// BOF: KategorienAdmin / OLISWISS
       }
// EOF: KategorienAdmin / OLISWISS
    }

// VaM admin paging start

    $products_count = 0;
    
$page = $_GET['page'];
$pID = $_GET['pID'];    
    
if (!isset($page)){$page=0;};

$max_count = MAX_PROD_ADMIN_SIDE;

    if (isset($_GET['search'])) {
			 $stl="";

if ($_GET['search_model_key'] == 'no'){
     $products_query = tep_db_query("select p.products_id, pd.products_name, p.products_quantity, p.products_image, p.products_price, p.products_date_added, p.products_last_modified, p.products_date_available, p.products_status, p.products_to_xml, p.products_sort_order, p.products_model, p2c.categories_id from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c where p.products_id = pd.products_id and pd.language_id = '" . (int)$languages_id . "' and p.products_id = p2c.products_id and pd.products_name like '%" . tep_db_input($search) . "%' order by pd.products_name");
}
else{
     $products_query = tep_db_query("select p.products_id, pd.products_name, p.products_quantity, p.products_image, p.products_price, p.products_date_added, p.products_last_modified, p.products_date_available, p.products_status, p.products_to_xml, p.products_sort_order, p.products_model, p2c.categories_id from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c where p.products_id = pd.products_id and pd.language_id = '" . (int)$languages_id . "' and p.products_id = p2c.products_id and p.products_model like '%" . tep_db_input($search) . "%' order by pd.products_name");
}      
      
    } else {
			 $stl="";
       $products_query = tep_db_query("select p.products_id, pd.products_name, p.products_quantity, p.products_image, p.products_price, p.products_date_added, p.products_last_modified, p.products_date_available, p.products_status, p.products_to_xml, p.products_sort_order, p.products_model, p2c.categories_id from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c where p.products_id = pd.products_id and pd.language_id = '" . (int)$languages_id .$stl . "' and p.products_id = p2c.products_id and p2c.categories_id = '" . (int)$current_category_id . "' order by pd.products_name");

       $numr=tep_db_num_rows($products_query);
//opredeliaem stranicu tecuschego producta
	if ( (isset($pID)) and ($numr>0) ){
	$pnum=1;

	while ($row=tep_db_fetch_array($products_query)){
		if ($row["products_id"]==$pID){
//								echo $pID." ".$numr." ";
								$pnum=($pnum/$max_count);
									if (strpos($pnum,".")>0){
									$pnum=substr($pnum,0,strpos($pnum,"."));
									} else{
									if ($pnum<>0){
											$pnum=$pnum-1;
												}
									}
									$page=$pnum*$max_count;
//									echo $page;
								break;
								}
	$pnum++;
								}
	}
//--------------------------------
			//formiruem stroku kol-va
//$numr=500;

      $products_query = tep_db_query("select p.products_id, pd.products_name, p.products_quantity, p.products_image, p.products_price, p.products_date_added, p.products_last_modified, p.products_date_available, p.products_status, p.products_to_xml, p.products_sort_order, p.products_model, p2c.categories_id from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c where p.products_id = pd.products_id and pd.language_id = '" . (int)$languages_id .$stl . "' and p.products_id = p2c.products_id and p2c.categories_id = '" . (int)$current_category_id . "' order by pd.products_name"." limit ".$page.",".$max_count);

if ($numr>$max_count){
			$kn=0;
			$stp= TEXT_PAGES;

			$im=1;$nk=0;
			while ($kn<$numr){
			if ($kn<>$page){
			$stp.= '<a href="' . tep_href_link(FILENAME_CATEGORIES, 'cPath='.$cPath.'&page='.$kn) . '">'.$im.'</a>&nbsp';
			}else{
			$stp.='<font color="CC0000">['.$im.']</font>&nbsp';
			}
			$kn=$kn+$max_count;
			$nk=$nk+$max_count;
			if ($nk>=$max_count*40){$stp.='<br>';$nk=0;}
			$im++;
			}
}

// VaM admin paging end

			//-----------------------
    }
    while ($products = tep_db_fetch_array($products_query)) {
	
      $products_count++;
      $rows++;

// Get categories_id for product if search
      if (isset($_GET['search'])) $cPath = $products['categories_id'];

      if ( (!isset($_GET['pID']) && !isset($_GET['cID']) || (isset($_GET['pID']) && ($_GET['pID'] == $products['products_id']))) && !isset($pInfo) && !isset($cInfo) && (substr($action, 0, 3) != 'new')) {
// find out the rating average from customer reviews
        $reviews_query = tep_db_query("select (avg(reviews_rating) / 5 * 100) as average_rating from " . TABLE_REVIEWS . " where products_id = '" . (int)$products['products_id'] . "'");
        $reviews = tep_db_fetch_array($reviews_query);
        $pInfo_array = array_merge($products, $reviews);
        $pInfo = new objectInfo($pInfo_array);
      }
// BOF: KategorienAdmin / OLISWISS
     if ($admin_groups_id == 1 || in_array($categories['categories_id'],$admin_cat_access_array_cats) || $cPath != 0) {
// EOF: KategorienAdmin / OLISWISS

      if (isset($pInfo) && is_object($pInfo) && ($products['products_id'] == $pInfo->products_id) ) {

        echo '              <tr id="defaultSelected" class="dataTableRowSelected" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)">' . "\n";
      } else {

echo '              <tr class="dataTableRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)">' . "\n";

      }
?>
                   <td></td><td class="dataTableContent"><?php if (strstr($admin_right_access,"PDELETE") or $login_id = 1) { ?><input title="<?php echo $products[products_id]." ddd ".$products[categories_id]; ?>"  name="prod_id[<?php echo $products[products_id]; ?>]" type="checkbox"  value="<?php echo $products[categories_id];  ?>" />&nbsp;<?php } echo '<a href="' . tep_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . '&pID=' . $products['products_id'] . '&action=new_product') . '">' . tep_image(DIR_WS_ICONS . 'preview.gif', ICON_PREVIEW) . '</a>&nbsp;<a href="' . tep_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . '&pID=' . $products['products_id']) . '">' . $products['products_name'];  ?></a> </td>
                <td class="dataTableContent" align="center">

<?php
      if ($products['products_status'] == '1') {
        echo tep_image(DIR_WS_IMAGES . 'icon_status_green.gif', IMAGE_ICON_STATUS_GREEN, 10, 10) . '&nbsp;&nbsp;<a href="' . tep_href_link(FILENAME_CATEGORIES, 'action=setflag&flag=0&pID=' . $products['products_id'] . '&cPath=' . $cPath) . '">' . tep_image(DIR_WS_IMAGES . 'icon_status_red_light.gif', IMAGE_ICON_STATUS_RED_LIGHT, 10, 10) . '</a>';
      } else {
        echo '<a href="' . tep_href_link(FILENAME_CATEGORIES, 'action=setflag&flag=1&pID=' . $products['products_id'] . '&cPath=' . $cPath) . '">' . tep_image(DIR_WS_IMAGES . 'icon_status_green_light.gif', IMAGE_ICON_STATUS_GREEN_LIGHT, 10, 10) . '</a>&nbsp;&nbsp;' . tep_image(DIR_WS_IMAGES . 'icon_status_red.gif', IMAGE_ICON_STATUS_RED, 10, 10);
      }?></td>
         <td class="dataTableContent" align="center">
<?php
      if ($products['products_to_xml'] == '1') {
        echo tep_image(DIR_WS_IMAGES . 'icon_status_green.gif', IMAGE_ICON_STATUS_GREEN, 10, 10) . '&nbsp;&nbsp;<a href="' . tep_href_link(FILENAME_CATEGORIES, 'action=setxml&flagxml=0&pID=' . $products['products_id'] . '&cPath=' . $cPath) . '">' . tep_image(DIR_WS_IMAGES . 'icon_status_red_light.gif', IMAGE_ICON_STATUS_RED_LIGHT, 10, 10) . '</a>';
      } else {
        echo '<a href="' . tep_href_link(FILENAME_CATEGORIES, 'action=setxml&flagxml=1&pID=' . $products['products_id'] . '&cPath=' . $cPath) . '">' . tep_image(DIR_WS_IMAGES . 'icon_status_green_light.gif', IMAGE_ICON_STATUS_GREEN_LIGHT, 10, 10) . '</a>&nbsp;&nbsp;' . tep_image(DIR_WS_IMAGES . 'icon_status_red.gif', IMAGE_ICON_STATUS_RED, 10, 10);
      }
?></td>
                <td class="dataTableContent" align="center">
            <?php echo $products['products_sort_order']; ?>              </td>

                <td class="dataTableContent" align="right">
<?php
	$products_properties_query = tep_db_query("select products_id from " . TABLE_PRODUCTS_PROPERTIES . " where products_id = '" . (int)$products['products_id'] . "'");
		while($products_properties = tep_db_fetch_array($products_properties_query)) {
			$products_properties_id = $products_properties['products_id'];
		}
?>

<?php if ($products['products_id'] == $products_properties_id) { echo '<a href="javascript:popupPropertiesWindow(\'' . tep_href_link(FILENAME_PRODUCTS_PROPERTIES_POPUP, 'cID=' . $current_category_id . '&pID=' . $products['products_id']) . '\')">' . tep_image(DIR_WS_ICONS . 'icon_properties_change.gif', IMAGE_PROPERTIES_POPUP_ADD_CHANGE_DELETE, 13, 19) . '</a>'; } else { echo '<a href="javascript:popupPropertiesWindow(\'' . tep_href_link(FILENAME_PRODUCTS_PROPERTIES_POPUP, 'cID=' . $current_category_id . '&pID=' . $products['products_id']) . '\')">' . tep_image(DIR_WS_ICONS . 'icon_properties_add.gif', IMAGE_PROPERTIES_POPUP_ADD, 13, 19) . '</a>'; } ?>&nbsp;


                <?php if (isset($pInfo) && is_object($pInfo) && ($products['products_id'] == $pInfo->products_id)) { echo tep_image(DIR_WS_IMAGES . 'icon_arrow_right.gif', ''); } else { echo '<a href="' . tep_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . '&pID=' . $products['products_id']) . '">' . tep_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . '</a>'; } ?>

                &nbsp;</td>

              </tr>
<?php
// BOF: KategorienAdmin / OLISWISS
      }
// EOF: KategorienAdmin / OLISWISS
    }

    $cPath_back = '';
    if (sizeof($cPath_array) > 0) {
      for ($i=0, $n=sizeof($cPath_array)-1; $i<$n; $i++) {
        if (empty($cPath_back)) {
          $cPath_back .= $cPath_array[$i];
        } else {
          $cPath_back .= '_' . $cPath_array[$i];
        }
      }
    }

    $cPath_back = (tep_not_null($cPath_back)) ? 'cPath=' . $cPath_back . '&' : '';
?>
              <tr>
                <td colspan="6"><table class="table-padding-2">
                  <tr>
                    <?php // BOF: KategorienAdmin / OLISWISS
	if($admin_groups_id == 1){
?>
                    <td class="smallText"><?php echo TEXT_CATEGORIES . '&nbsp;' . $categories_count . '<br>' . TEXT_PRODUCTS . '&nbsp;' . $products_count; ?> <br>
                        <?php echo TEXT_TOTAL_PRODUCTS . $numr; ?> <br>
                        <?php echo $stp; ?> </td>
                  </tr>
                  <tr>
                    <td align="right" class="smallText"><?php if (sizeof($cPath_array) > 0) echo '<a href="' . tep_href_link(FILENAME_CATEGORIES, $cPath_back . 'cID=' . $current_category_id) . '">' . tep_image_button('button_back.gif', IMAGE_BACK) . '</a>&nbsp;'; if (!isset($_GET['search'])) echo '<a href="' . tep_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . '&action=new_category') . '">' . tep_image_button('button_new_category.gif', IMAGE_NEW_CATEGORY) . '</a>&nbsp;<a href="' . tep_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . '&action=new_product') . '">' . tep_image_button('button_new_product.gif', IMAGE_NEW_PRODUCT) . '</a>'; ?>
                      &nbsp;</td>
                    <?php
	} else {
?>
                    <td class="smallText"><?php echo TEXT_TOTAL_PRODUCTS . $numr; ?> <br>
                        <?php echo $stp; ?> </td>
                    <td align="right" class="smallText"><?php if (sizeof($cPath_array) > 0) echo '<a href="' . tep_href_link(FILENAME_CATEGORIES, $cPath_back . 'cID=' . $current_category_id) . '">' . tep_image_button('button_back.gif', IMAGE_BACK) . '</a>&nbsp;';
                    if (!isset($_GET['search']) && strstr($admin_right_access,"CNEW")) echo '<a href="' . tep_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . '&action=new_category') . '">' . tep_image_button('button_new_category.gif', IMAGE_NEW_CATEGORY) . '</a>&nbsp;'; 
                    if (!isset($_GET['search']) && strstr($admin_right_access,"PNEW") && $cInfo->parent_id !='0') echo '<a href="' . tep_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . '&action=new_product') . '">' . tep_image_button('button_new_product.gif', IMAGE_NEW_PRODUCT) . '</a>'; ?>
                      &nbsp;</td>
                    <?php
	}
// EOF: KategorienAdmin / OLISWISS
?>
                  </tr>
                </table></td>
              </tr>
            </table>
            <input type="hidden" name="cPath" value="<?php echo $_GET['cPath']; ?>">
            

<input class="but_cat" name="<?php echo TEXT_BUTTON_DELETE; ?>" value="<?php echo TEXT_BUTTON_DELETE; ?>" type="submit"> <input class="but_cat" value="<?php echo TEXT_BUTTON_CLEAR; ?>" name="" type="reset"> <input class="but_cat2" name="upd" value="<?php echo TEXT_BUTTON_UPDATE; ?>" type="submit"></form>
 
<br />
<?php echo '<a href="' . tep_href_link(FILENAME_PRODUCTS_MULTI) . '">' . BOX_CATALOG_CATEGORIES_PRODUCTS_MULTI . '</a>'; ?>
</td>
<?php
    $heading = array();
    $contents = array();
    switch ($action) {
      case 'new_category':
        $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_NEW_CATEGORY . '</b>');

        $contents = array('form' => tep_draw_form('newcategory', FILENAME_CATEGORIES, 'action=insert_category&cPath=' . $cPath, 'post', 'enctype="multipart/form-data"'));
        $contents[] = array('text' => TEXT_NEW_CATEGORY_INTRO);

        $category_inputs_string = '';
        $languages = tep_get_languages();
        for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
          $category_inputs_string .= '<br>' . tep_image(DIR_WS_CATALOG_LANGUAGES . $languages[$i]['directory'] . '/images/' . $languages[$i]['image'], $languages[$i]['name']) . '&nbsp;' . tep_draw_input_field('categories_name[' . $languages[$i]['id'] . ']');
        }

        $category_meta_t = '';
        $languages = tep_get_languages();
        for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
          $category_meta_t .= '<br>' . tep_image(DIR_WS_CATALOG_LANGUAGES . $languages[$i]['directory'] . '/images/' . $languages[$i]['image'], $languages[$i]['name']) . '&nbsp;' . tep_draw_input_field('categories_meta_title[' . $languages[$i]['id'] . ']');
        }

        $category_meta_d = '';
        $languages = tep_get_languages();
        for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
          $category_meta_d .= '<br>' . tep_image(DIR_WS_CATALOG_LANGUAGES . $languages[$i]['directory'] . '/images/' . $languages[$i]['image'], $languages[$i]['name']) . '&nbsp;' . tep_draw_input_field('categories_meta_description[' . $languages[$i]['id'] . ']');
        }

        $category_meta_k = '';
        $languages = tep_get_languages();
        for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
          $category_meta_k .= '<br>' . tep_image(DIR_WS_CATALOG_LANGUAGES . $languages[$i]['directory'] . '/images/' . $languages[$i]['image'], $languages[$i]['name']) . '&nbsp;' . tep_draw_input_field('categories_meta_keywords[' . $languages[$i]['id'] . ']');
        }

        $contents[] = array('text' => '<br>' . TEXT_CATEGORIES_NAME . $category_inputs_string);
        $contents[] = array('text' => '<br>' . TEXT_CATEGORIES_IMAGE . '<br>' . tep_draw_file_field('categories_image'));
        $contents[] = array('text' => '<br>' . TEXT_SORT_ORDER . '<br>' . tep_draw_input_field('sort_order', '', 'size="2"'));

// Meta Tags Code
        $contents[] = array('text' => '<br>' . TEXT_META_TITLE . $category_meta_t);
        $contents[] = array('text' => '<br>' . TEXT_META_DESCRIPTION . $category_meta_d);
        $contents[] = array('text' => '<br>' . TEXT_META_KEYWORDS . $category_meta_k);
 // End Meta Tags Code

        $contents[] = array('text' => '<br>' . TEXT_EDIT_STATUS . '<br>' . tep_draw_input_field('categories_status', $cInfo->categories_status, 'size="2"') . ' ' . TEXT_DEFINE_CATEGORY_STATUS);

        $contents[] = array('align' => 'center', 'text' => '<br>' . tep_image_submit('button_save.gif', IMAGE_SAVE) . ' <a href="' . tep_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath) . '">' . tep_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>');
        break;
      case 'edit_category':
        $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_EDIT_CATEGORY . '</b>');

        $contents = array('form' => tep_draw_form('categories', FILENAME_CATEGORIES, 'action=update_category&cPath=' . $cPath, 'post', 'enctype="multipart/form-data"') . tep_draw_hidden_field('categories_id', $cInfo->categories_id));
        $contents[] = array('text' => TEXT_EDIT_INTRO);

        $category_inputs_string = '';
        $languages = tep_get_languages();
        for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
          $category_inputs_string .= '<br>' . tep_image(DIR_WS_CATALOG_LANGUAGES . $languages[$i]['directory'] . '/images/' . $languages[$i]['image'], $languages[$i]['name']) . '&nbsp;' . tep_draw_input_field('categories_name[' . $languages[$i]['id'] . ']', tep_get_category_name($cInfo->categories_id, $languages[$i]['id']));
        }

        $category_meta_t = '';
        $languages = tep_get_languages();
        for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
          $category_meta_t .= '<br>' . tep_image(DIR_WS_CATALOG_LANGUAGES . $languages[$i]['directory'] . '/images/' . $languages[$i]['image'], $languages[$i]['name']) . '&nbsp;' . tep_draw_input_field('categories_meta_title[' . $languages[$i]['id'] . ']', tep_get_category_meta_title($cInfo->categories_id, $languages[$i]['id']));
        }

        $category_meta_d = '';
        $languages = tep_get_languages();
        for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
          $category_meta_d .= '<br>' . tep_image(DIR_WS_CATALOG_LANGUAGES . $languages[$i]['directory'] . '/images/' . $languages[$i]['image'], $languages[$i]['name']) . '&nbsp;' . tep_draw_input_field('categories_meta_description[' . $languages[$i]['id'] . ']', tep_get_category_meta_description($cInfo->categories_id, $languages[$i]['id']));
        }

        $category_meta_k = '';
        $languages = tep_get_languages();
        for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
          $category_meta_k .= '<br>' . tep_image(DIR_WS_CATALOG_LANGUAGES . $languages[$i]['directory'] . '/images/' . $languages[$i]['image'], $languages[$i]['name']) . '&nbsp;' . tep_draw_input_field('categories_meta_keywords[' . $languages[$i]['id'] . ']', tep_get_category_meta_keywords($cInfo->categories_id, $languages[$i]['id']));
        }

        $contents[] = array('text' => '<br>' . TEXT_EDIT_CATEGORIES_NAME . $category_inputs_string);
        $contents[] = array('text' => '<br>' . tep_image(DIR_WS_CATALOG_IMAGES . $cInfo->categories_image, $cInfo->categories_name) . '<br>' . DIR_WS_CATALOG_IMAGES . '<br><b>' . $cInfo->categories_image . '</b>');
        $contents[] = array('text' => '<br>' . TEXT_EDIT_CATEGORIES_IMAGE . '<br>' . tep_draw_file_field('categories_image') . tep_draw_hidden_field('categories_image_old', $cInfo->categories_image));
        $contents[] = array('text' => '<br>' . TEXT_EDIT_SORT_ORDER . '<br>' . tep_draw_input_field('sort_order', $cInfo->sort_order, 'size="2"'));

// Begin Meta Tags Code
        $contents[] = array('text' => '<br>' . TEXT_META_TITLE . $category_meta_t);
        $contents[] = array('text' => '<br>' . TEXT_META_DESCRIPTION . $category_meta_d);
        $contents[] = array('text' => '<br>' . TEXT_META_KEYWORDS . $category_meta_k);
 // End Meta Tags Code


//        $contents[] = array('align' => 'center', 'text' => '<br>' . tep_image_submit('button_save.gif', IMAGE_SAVE) . ' <a href="' . tep_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . '&cID=' . $cInfo->categories_id) . '">' . tep_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>');

// BOF Enable - Disable Categories Contribution--------------------------------------
        $contents[] = array('text' => '<br>' . TEXT_EDIT_STATUS . '<br>' . tep_draw_input_field('categories_status', $cInfo->categories_status, 'size="2"') . ' ' . TEXT_DEFINE_CATEGORY_STATUS);
	$contents[] = array('align' => 'center', 'text' => '<br>' . tep_image_submit('button_save.gif', IMAGE_SAVE) . ' <a href="' . tep_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . '&cID=' . $cInfo->categories_id) . '">' . tep_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>');
// EOF Enable - Disable Categories Contribution--------------------------------------

        break;
      case 'delete_category':
        $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_DELETE_CATEGORY . '</b>');

        $contents = array('form' => tep_draw_form('categories', FILENAME_CATEGORIES, 'action=delete_category_confirm&cPath=' . $cPath) . tep_draw_hidden_field('categories_id', $cInfo->categories_id));
        $contents[] = array('text' => TEXT_DELETE_CATEGORY_INTRO);
        $contents[] = array('text' => '<br><b>' . $cInfo->categories_name . '</b>');
        if ($cInfo->childs_count > 0) $contents[] = array('text' => '<br>' . sprintf(TEXT_DELETE_WARNING_CHILDS, $cInfo->childs_count));
        if ($cInfo->products_count > 0) $contents[] = array('text' => '<br>' . sprintf(TEXT_DELETE_WARNING_PRODUCTS, $cInfo->products_count));
        $contents[] = array('align' => 'center', 'text' => '<br>' . tep_image_submit('button_delete.gif', IMAGE_DELETE) . ' <a href="' . tep_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . '&cID=' . $cInfo->categories_id) . '">' . tep_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>');
        break;
      case 'move_category':
        $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_MOVE_CATEGORY . '</b>');

        $contents = array('form' => tep_draw_form('categories', FILENAME_CATEGORIES, 'action=move_category_confirm&cPath=' . $cPath) . tep_draw_hidden_field('categories_id', $cInfo->categories_id));
        $contents[] = array('text' => sprintf(TEXT_MOVE_CATEGORIES_INTRO, $cInfo->categories_name));
        $contents[] = array('text' => '<br>' . sprintf(TEXT_MOVE, $cInfo->categories_name) . '<br>' . tep_draw_pull_down_menu('move_to_category_id', tep_get_category_tree(), $current_category_id));
        $contents[] = array('align' => 'center', 'text' => '<br>' . tep_image_submit('button_move.gif', IMAGE_MOVE) . ' <a href="' . tep_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . '&cID=' . $cInfo->categories_id) . '">' . tep_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>');
        break;
      case 'delete_product':
        $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_DELETE_PRODUCT . '</b>');

        $contents = array('form' => tep_draw_form('products', FILENAME_CATEGORIES, 'action=delete_product_confirm&cPath=' . $cPath) . tep_draw_hidden_field('products_id', $pInfo->products_id));
        $contents[] = array('text' => TEXT_DELETE_PRODUCT_INTRO);
        $contents[] = array('text' => '<br><b>' . $pInfo->products_name . '</b>');

        $product_categories_string = '';
        $product_categories = tep_generate_category_path($pInfo->products_id, 'product');
        for ($i = 0, $n = sizeof($product_categories); $i < $n; $i++) {
          $category_path = '';
          for ($j = 0, $k = sizeof($product_categories[$i]); $j < $k; $j++) {
            $category_path .= $product_categories[$i][$j]['text'] . '&nbsp;&gt;&nbsp;';
          }
          $category_path = substr($category_path, 0, -16);
          $product_categories_string .= tep_draw_checkbox_field('product_categories[]', $product_categories[$i][sizeof($product_categories[$i])-1]['id'], true) . '&nbsp;' . $category_path . '<br>';
        }
        $product_categories_string = substr($product_categories_string, 0, -4);

        $contents[] = array('text' => '<br>' . $product_categories_string);
        $contents[] = array('align' => 'center', 'text' => '<br>' . tep_image_submit('button_delete.gif', IMAGE_DELETE) . ' <a href="' . tep_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . '&pID=' . $pInfo->products_id) . '">' . tep_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>');
        break;
      case 'move_product':
        $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_MOVE_PRODUCT . '</b>');

        $contents = array('form' => tep_draw_form('products', FILENAME_CATEGORIES, 'action=move_product_confirm&cPath=' . $cPath) . tep_draw_hidden_field('products_id', $pInfo->products_id));
        $contents[] = array('text' => sprintf(TEXT_MOVE_PRODUCTS_INTRO, $pInfo->products_name));
        $contents[] = array('text' => '<br>' . TEXT_INFO_CURRENT_CATEGORIES . '<br><b>' . tep_output_generated_category_path($pInfo->products_id, 'product') . '</b>');

// BOF: KategorienAdmin / OLISWISS
  if (is_array($admin_cat_access_array_cats) && (in_array("ALL",$admin_cat_access_array_cats)== false) && (pos($admin_cat_access_array_cats)!= "")) {
    $contents[] = array('text' => '<br>' . sprintf(TEXT_MOVE, $pInfo->products_name) . '<br>' . tep_draw_pull_down_menu('move_to_category_id', tep_get_category_tree('','','0','',$admin_cat_access_array_cats), $current_category_id));
  } else if (in_array("ALL",$admin_cat_access_array_cats)== true) { //nur Top-ADMIN
    $contents[] = array('text' => '<br>' . sprintf(TEXT_MOVE, $pInfo->products_name) . '<br>' . tep_draw_pull_down_menu('move_to_category_id', tep_get_category_tree(), $current_category_id));
  }
// EOF: KategorienAdmin / OLISWISS

        $contents[] = array('align' => 'center', 'text' => '<br>' . tep_image_submit('button_move.gif', IMAGE_MOVE) . ' <a href="' . tep_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . '&pID=' . $pInfo->products_id) . '">' . tep_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>');
        break;
      case 'copy_to':
        $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_COPY_TO . '</b>');

        $contents = array('form' => tep_draw_form('copy_to', FILENAME_CATEGORIES, 'action=copy_to_confirm&cPath=' . $cPath) . tep_draw_hidden_field('products_id', $pInfo->products_id));
        $contents[] = array('text' => TEXT_INFO_COPY_TO_INTRO);
        $contents[] = array('text' => '<br>' . TEXT_INFO_CURRENT_CATEGORIES . '<br><b>' . tep_output_generated_category_path($pInfo->products_id, 'product') . '</b>');

// BOF: KategorienAdmin / OLISWISS
  if (is_array($admin_cat_access_array_cats) && (in_array("ALL",$admin_cat_access_array_cats)== false) && (pos($admin_cat_access_array_cats)!= "")) {
    $contents[] = array('text' => '<br>' . TEXT_CATEGORIES . '<br>' . tep_draw_pull_down_menu('categories_id', tep_get_category_tree('','','0','',$admin_cat_access_array_cats), $current_category_id));
  } else if (in_array("ALL",$admin_cat_access_array_cats)== true) { //nur Top-ADMIN
    $contents[] = array('text' => '<br>' . TEXT_CATEGORIES . '<br>' . tep_draw_pull_down_menu('categories_id', tep_get_category_tree(), $current_category_id));
  }
// EOF: KategorienAdmin / OLISWISS        

        $contents[] = array('text' => '<br>' . TEXT_HOW_TO_COPY . '<br>' . tep_draw_radio_field('copy_as', 'link', true) . ' ' . TEXT_COPY_AS_LINK . '<br>' . tep_draw_radio_field('copy_as', 'duplicate') . ' ' . TEXT_COPY_AS_DUPLICATE);
// BOF: WebMakers.com Added: Attributes Copy
        $contents[] = array('text' => '<br>' . tep_image(DIR_WS_IMAGES . 'pixel_black.gif','','100%','1'));
        // only ask about attributes if they exist
        if (tep_has_product_attributes($pInfo->products_id)) {
          $contents[] = array('text' => '<br>' . TEXT_COPY_ATTRIBUTES_ONLY);
          $contents[] = array('text' => '<br>' . TEXT_COPY_ATTRIBUTES . '<br>' . tep_draw_radio_field('copy_attributes', 'copy_attributes_yes', true) . ' ' . TEXT_COPY_ATTRIBUTES_YES . '<br>' . tep_draw_radio_field('copy_attributes', 'copy_attributes_no') . ' ' . TEXT_COPY_ATTRIBUTES_NO);
          $contents[] = array('align' => 'center', 'text' => '<br>' . ATTRIBUTES_NAMES_HELPER . '<br>' . tep_draw_separator('pixel_trans.gif', '1', '10'));
          $contents[] = array('text' => '<br>' . tep_image(DIR_WS_IMAGES . 'pixel_black.gif','','100%','1'));
        }
// EOF: WebMakers.com Added: Attributes Copy

        $contents[] = array('align' => 'center', 'text' => '<br>' . tep_image_submit('button_copy.gif', IMAGE_COPY) . ' <a href="' . tep_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . '&pID=' . $pInfo->products_id) . '">' . tep_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>');
        break;

/////////////////////////////////////////////////////////////////////
// WebMakers.com Added: Copy Attributes Existing Product to another Existing Product
      case 'copy_product_attributes':
        $copy_attributes_delete_first='1';
        $copy_attributes_duplicates_skipped='1';
        $copy_attributes_duplicates_overwrite='0';

        if (DOWNLOAD_ENABLED == 'true') {
          $copy_attributes_include_downloads='1';
          $copy_attributes_include_filename='1';
        } else {
          $copy_attributes_include_downloads='0';
          $copy_attributes_include_filename='0';
        }

        $heading[] = array('text' => '<b>' . ATTRIBUTES_COPY_MANAGER_13 . '</b>');
        $contents = array('form' => tep_draw_form('products', FILENAME_CATEGORIES, 'action=create_copy_product_attributes&cPath=' . $cPath . '&pID=' . $pInfo->products_id) . tep_draw_hidden_field('products_id', $pInfo->products_id) . tep_draw_hidden_field('products_name', $pInfo->products_name));
        $contents[] = array('text' => '<br>' . ATTRIBUTES_COPY_MANAGER_2 . '<b>' . $pInfo->products_name . '</b><br>' . ATTRIBUTES_COPY_MANAGER_15 . '<b>' . $pInfo->products_id . '</b>');
        $contents[] = array('text' => ATTRIBUTES_COPY_MANAGER_16 . tep_draw_input_field('copy_to_products_id', $copy_to_products_id, 'size="3"') . ATTRIBUTES_COPY_MANAGER_3);
        $contents[] = array('text' => '<br>' . ATTRIBUTES_COPY_MANAGER_17 . tep_draw_checkbox_field('copy_attributes_delete_first',$copy_attributes_delete_first, 'size="2"'));
        $contents[] = array('text' => '<br>' . tep_image(DIR_WS_IMAGES . 'pixel_black.gif','','100%','1'));
        $contents[] = array('text' => '<br>' . ATTRIBUTES_COPY_MANAGER_7);
        $contents[] = array('text' => ATTRIBUTES_COPY_MANAGER_8 . tep_draw_checkbox_field('copy_attributes_duplicates_skipped',$copy_attributes_duplicates_skipped, 'size="2"'));
        $contents[] = array('text' => ATTRIBUTES_COPY_MANAGER_9 . tep_draw_checkbox_field('copy_attributes_duplicates_overwrite',$copy_attributes_duplicates_overwrite, 'size="2"'));
        if (DOWNLOAD_ENABLED == 'true') {
          $contents[] = array('text' => '<br>' . ATTRIBUTES_COPY_MANAGER_10 . tep_draw_checkbox_field('copy_attributes_include_downloads',$copy_attributes_include_downloads, 'size="2"'));
          // Not used at this time - download name copies if download attribute is copied
          // $contents[] = array('text' => '&nbsp;&nbsp;&nbsp;Include Download Filenames&nbsp;' . tep_draw_checkbox_field('copy_attributes_include_filename',$copy_attributes_include_filename, 'size="2"'));
        }
        $contents[] = array('text' => '<br>' . tep_image(DIR_WS_IMAGES . 'pixel_black.gif','','100%','1'));
        $contents[] = array('align' => 'center', 'text' => '<br>' . PRODUCT_NAMES_HELPER);
        if ($pID) {
          $contents[] = array('align' => 'center', 'text' => '<br>' . ATTRIBUTES_NAMES_HELPER);
        } else {
          $contents[] = array('align' => 'center', 'text' => '<br>Select a product for display');
        }
        $contents[] = array('align' => 'center', 'text' => '<br>' . tep_image_submit('button_copy.gif', ATTRIBUTES_COPY_MANAGER_COPY) . ' <a href="' . tep_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . '&pID=' . $pInfo->products_id) . '">' . tep_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>');
        break;
// WebMakers.com Added: Copy Attributes Existing Product to All Products in Category
      case 'copy_product_attributes_categories':
        $copy_attributes_delete_first='1';
        $copy_attributes_duplicates_skipped='1';
        $copy_attributes_duplicates_overwrite='0';

        if (DOWNLOAD_ENABLED == 'true') {
          $copy_attributes_include_downloads='1';
          $copy_attributes_include_filename='1';
        } else {
          $copy_attributes_include_downloads='0';
          $copy_attributes_include_filename='0';
        }

        $heading[] = array('text' => '<b>' . ATTRIBUTES_COPY_MANAGER_1 . '</b>');
        $contents = array('form' => tep_draw_form('products', FILENAME_CATEGORIES, 'action=create_copy_product_attributes_categories&cPath=' . $cPath . '&cID=' . $cID . '&make_copy_from_products_id=' . $copy_from_products_id));
        $contents[] = array('text' => ATTRIBUTES_COPY_MANAGER_2 . tep_draw_input_field('make_copy_from_products_id', $make_copy_from_products_id, 'size="3"') . ATTRIBUTES_COPY_MANAGER_3);
        $contents[] = array('text' => '<br>' . ATTRIBUTES_COPY_MANAGER_4 . '<b>' . tep_get_category_name($cID, $languages_id) . '</b><br>' .ATTRIBUTES_COPY_MANAGER_5 . $cID);
        $contents[] = array('text' => '<br>' . ATTRIBUTES_COPY_MANAGER_6 . tep_draw_checkbox_field('copy_attributes_delete_first',$copy_attributes_delete_first, 'size="2"'));
        $contents[] = array('text' => '<br>' . tep_image(DIR_WS_IMAGES . 'pixel_black.gif','','100%','1'));
        $contents[] = array('text' => '<br>' . ATTRIBUTES_COPY_MANAGER_7);
        $contents[] = array('text' => ATTRIBUTES_COPY_MANAGER_8 . tep_draw_checkbox_field('copy_attributes_duplicates_skipped',$copy_attributes_duplicates_skipped, 'size="2"'));
        $contents[] = array('text' => '<br>' . ATTRIBUTES_COPY_MANAGER_9 . tep_draw_checkbox_field('copy_attributes_duplicates_overwrite',$copy_attributes_duplicates_overwrite, 'size="2"'));
        if (DOWNLOAD_ENABLED == 'true') {
          $contents[] = array('text' => '<br>' . ATTRIBUTES_COPY_MANAGER_10 . tep_draw_checkbox_field('copy_attributes_include_downloads',$copy_attributes_include_downloads, 'size="2"'));
          // Not used at this time - download name copies if download attribute is copied
          // $contents[] = array('text' => '&nbsp;&nbsp;&nbsp;Include Download Filenames&nbsp;' . tep_draw_checkbox_field('copy_attributes_include_filename',$copy_attributes_include_filename, 'size="2"'));
        }
        $contents[] = array('text' => '<br>' . tep_image(DIR_WS_IMAGES . 'pixel_black.gif','','100%','1'));
        $contents[] = array('align' => 'center', 'text' => '<br>' . PRODUCT_NAMES_HELPER);
        $contents[] = array('align' => 'center', 'text' => '<br>' . tep_image_submit('button_copy.gif', ATTRIBUTES_COPY_MANAGER_COPY) . ' <a href="' . tep_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . '&cID=' . $cID) . '">' . tep_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>');
        break;
      default:
        if ($rows > 0) {
          if (isset($cInfo) && is_object($cInfo)) { // category info box contents
            $category_path_string = '';
            $category_path = tep_generate_category_path($cInfo->categories_id);
            for ($i=(sizeof($category_path[0])-1); $i>0; $i--) {
              $category_path_string .= $category_path[0][$i]['id'] . '_';
            }
            $category_path_string = substr($category_path_string, 0, -1);

            $heading[] = array('text' => '<b>' . $cInfo->categories_name . '</b>');

// BOF: KategorienAdmin / OLISWISS
	    if ($admin_groups_id == 1) {
              $contents[] = array('align' => 'center', 'text' => '<a href="' . tep_href_link(FILENAME_CATEGORIES, 'cPath=' . $category_path_string . '&cID=' . $cInfo->categories_id . '&action=edit_category') . '">' . tep_image_button('button_edit.gif', IMAGE_EDIT) . '</a> <a href="' . tep_href_link(FILENAME_CATEGORIES, 'cPath=' . $category_path_string . '&cID=' . $cInfo->categories_id . '&action=delete_category') . '">' . tep_image_button('button_delete.gif', IMAGE_DELETE) . '</a> <a href="' . tep_href_link(FILENAME_CATEGORIES, 'cPath=' . $category_path_string . '&cID=' . $cInfo->categories_id . '&action=move_category') . '">' . tep_image_button('button_move.gif', IMAGE_MOVE) . '</a>');
	    } else {
	      if (strstr($admin_right_access,"CEDIT")) {  
	        $c_right_string .= ' <a href="' . tep_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . '&cID=' . $cInfo->categories_id . '&action=edit_category') . '">' . tep_image_button('button_edit.gif', IMAGE_EDIT) . '</a>';
	      }
	      if (strstr($admin_right_access,"CDELETE")) {
	      	$c_right_string .= ' <a href="' . tep_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . '&cID=' . $cInfo->categories_id . '&action=delete_category') . '">' . tep_image_button('button_delete.gif', IMAGE_DELETE) . '</a>';
	      }
	      if (strstr($admin_right_access,"CMOVE")) {
	        $c_right_string .= ' <a href="' . tep_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . '&cID=' . $cInfo->categories_id . '&action=move_category') . '">' . tep_image_button('button_move.gif', IMAGE_MOVE) . '</a>';
	      }
	    $contents[] = array('align' => 'center', 'text' => $c_right_string);
	    }
// EOF: KategorienAdmin / OLISWISS     

            $contents[] = array('text' => '<br>' . TEXT_DATE_ADDED . ' ' . tep_date_short($cInfo->date_added));
            if (tep_not_null($cInfo->last_modified)) $contents[] = array('text' => TEXT_LAST_MODIFIED . ' ' . tep_date_short($cInfo->last_modified));
            $contents[] = array('text' => '<br>' . tep_info_image($cInfo->categories_image, $cInfo->categories_name, HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT) . '<br>' . $cInfo->categories_image);
            $contents[] = array('text' => '<br>' . TEXT_SUBCATEGORIES . ' ' . $cInfo->childs_count . '<br>' . TEXT_PRODUCTS . ' ' . $cInfo->products_count);
            if ($cInfo->childs_count==0 and $cInfo->products_count >= 1) {
// WebMakers.com Added: Copy Attributes Existing Product to All Existing Products in Category
              $contents[] = array('text' => '<br>' . tep_image(DIR_WS_IMAGES . 'pixel_black.gif','','100%','1'));
              if ($cID) {
                $contents[] = array('align' => 'center', 'text' => '<a href="' . tep_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . '&cID=' . $cID . '&action=copy_product_attributes_categories') . '">' . ATTRIBUTES_COPY_MANAGER_12 . '<b>' . tep_get_category_name($cID, $languages_id) . '</b><br>' . tep_image_button('button_copy_to.gif', ATTRIBUTES_COPY_MANAGER_COPY) . '</a>');
              } else {
                $contents[] = array('align' => 'center', 'text' => '<br>' . ATTRIBUTES_COPY_MANAGER_11);
              }
            }
          } elseif (isset($pInfo) && is_object($pInfo)) { // product info box contents
            $heading[] = array('text' => '<b>' . tep_get_products_name($pInfo->products_id, $languages_id) . '</b>');

// BOF: KategorienAdmin / OLISWISS
	    if ($admin_groups_id == 1) {
              $contents[] = array('align' => 'center', 'text' => '<a href="' . tep_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . '&pID=' . $pInfo->products_id . '&action=new_product') . '">' . tep_image_button('button_edit.gif', IMAGE_EDIT) . '</a> <a href="' . tep_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . '&pID=' . $pInfo->products_id . '&action=delete_product') . '">' . tep_image_button('button_delete.gif', IMAGE_DELETE) . '</a> <a href="' . tep_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . '&pID=' . $pInfo->products_id . '&action=move_product') . '">' . tep_image_button('button_move.gif', IMAGE_MOVE) . '</a> <a href="' . tep_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . '&pID=' . $pInfo->products_id . '&action=copy_to') . '">' . tep_image_button('button_copy_to.gif', IMAGE_COPY_TO) . '</a>');
	    } else {
	      if (strstr($admin_right_access,"PEDIT")) {  
	        $p_right_string .= ' <a href="' . tep_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . '&pID=' . $pInfo->products_id . '&action=new_product') . '">' . tep_image_button('button_edit.gif', IMAGE_EDIT) . '</a>';
	      }
	      if (strstr($admin_right_access,"PDELETE")) {
	      	$p_right_string .= ' <a href="' . tep_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . '&pID=' . $pInfo->products_id . '&action=delete_product') . '">' . tep_image_button('button_delete.gif', IMAGE_DELETE) . '</a>';
	      }
	      if (strstr($admin_right_access,"PMOVE")) {
	        $p_right_string .= ' <a href="' . tep_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . '&pID=' . $pInfo->products_id . '&action=move_product') . '">' . tep_image_button('button_move.gif', IMAGE_MOVE) . '</a>';
	      }
	      if (strstr($admin_right_access,"PCOPY")) {
	        $p_right_string .= ' <a href="' . tep_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . '&pID=' . $pInfo->products_id . '&action=copy_to') . '">' . tep_image_button('button_copy_to.gif', IMAGE_COPY_TO) . '</a>';
	      }
	    $contents[] = array('align' => 'center', 'text' => $p_right_string);
	    }
// EOF: KategorienAdmin / OLISWISS

//<!-- Products Properties Begin -->
            $contents[] = array('align' => 'center', 'text' => '<a href="javascript:popupPropertiesWindow(\'' . tep_href_link(FILENAME_PRODUCTS_PROPERTIES, 'cID=' . $current_category_id . '&pID=' . $pInfo->products_id) . '\')">' . tep_image_button('button_properties_category.gif', IMAGE_PROPERTIES) . '</a><br>');
//<!-- Products Properties End -->
//<!-- New Attributes Manager Begin -->
            $contents[] = array('align' => 'center', 'text' => '<a href="' . tep_href_link(FILENAME_NEW_ATTRIBUTE_MANAGER, 'action=select&current_product_id=' . $pInfo->products_id . '&cPath=' . $cPath) . '">' . tep_image_button('button_edit_attributes.gif', TEXT_NEW_ATTRIBUTE_EDIT) . '</a>');
//<!-- New Attributes Manager End -->
            $contents[] = array('text' => '<br>' . TEXT_DATE_ADDED . ' ' . tep_date_short($pInfo->products_date_added));
            if (tep_not_null($pInfo->products_last_modified)) $contents[] = array('text' => TEXT_LAST_MODIFIED . ' ' . tep_date_short($pInfo->products_last_modified));
            if (date('Y-m-d') < $pInfo->products_date_available) $contents[] = array('text' => TEXT_DATE_AVAILABLE . ' ' . tep_date_short($pInfo->products_date_available));
            $contents[] = array('text' => '<br>' . tep_info_image($pInfo->products_image, $pInfo->products_name, SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT) . '<br>' . $pInfo->products_image);
            $contents[] = array('text' => '<br>' . TEXT_PRODUCTS_PRICE_INFO . ' ' . $currencies->format($pInfo->products_price) . '<br>' . TEXT_PRODUCTS_QUANTITY_INFO . ' ' . $pInfo->products_quantity);
            $contents[] = array('text' => '<br>' . TEXT_PRODUCTS_AVERAGE_RATING . ' ' . number_format($pInfo->average_rating, 2) . '%');
// WebMakers.com Added: Copy Attributes Existing Product to another Existing Product
            $contents[] = array('text' => '<br>' . tep_image(DIR_WS_IMAGES . 'pixel_black.gif','','100%','1'));
            $contents[] = array('align' => 'center', 'text' => '<a href="' . tep_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . '&pID=' . $pInfo->products_id . '&action=copy_product_attributes') . '">' . ATTRIBUTES_COPY_MANAGER_13 . '<br>' . tep_image_button('button_copy_to.gif', ATTRIBUTES_COPY_MANAGER_COPY) . '</a>');
            if ($pID) {
              $contents[] = array('align' => 'center', 'text' => '<br>' . ATTRIBUTES_NAMES_HELPER . '<br>' . tep_draw_separator('pixel_trans.gif', '1', '10'));
            } else {
              $contents[] = array('align' => 'center', 'text' => '<br>' . ATTRIBUTES_COPY_MANAGER_14);
            }
          }
        } else { // create category/product info
          $heading[] = array('text' => '<b>' . EMPTY_CATEGORY . '</b>');

          $contents[] = array('text' => TEXT_NO_CHILD_CATEGORIES_OR_PRODUCTS);
        }
        break;
    }

    if ( (tep_not_null($heading)) && (tep_not_null($contents)) ) {
      echo '            <td width="25%" valign="top">' . "\n";

      $box = new box;
      echo $box->infoBox($heading, $contents);

      echo '            </td>' . "\n";
    }
?>
          </tr>
        </table></td>
      </tr>
    </table>
<?php
  }
?>
    </td>
<!-- body_text_eof //-->
  </tr>
</table>
<!-- body_eof //-->

<!-- footer //-->
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<!-- footer_eof //-->
<br>
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>