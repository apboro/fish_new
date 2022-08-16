<?php
/*
autocreated script
*/
  require('includes/application_top.php');
?>
    <?php
/*
  $Id: allprods.php,v 1.7 2002/12/02

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2002 osCommerce
  Copyright (c) 2002 HMCservices

  Released under the GNU General Public License
*/



  require_once (DIR_WS_FUNCTIONS . 'products_specifications.php');

  include(DIR_WS_LANGUAGES . $language . '/' . FILENAME_PRODUCTS_FILTERS);

// Block Robots
// Set a Robots NoIndex if the sort field is set
  $robots_tag = '';
  if ( (isset ($_GET['sort'])) || (preg_match ('/[1-9][ad]/', $_GET['sort'])) ) {
    $robots_tag = '<meta name="robots" content="noindex,follow">';
 }
  
  $category_sql = '';
  if ($current_category_id != 0) {
    $category_sql = "and s2c.categories_id = '" . $current_category_id . "'";
  }
    
  // Check for filters on each applicable Specification
  $specs_query_raw = "SELECT  DISTINCT
                        s.specifications_id,
                        s.filter_class,
                        s.products_column_name,
                        sd.specification_name
                      FROM
                        " . TABLE_SPECIFICATION . " AS s
                      Inner Join " . TABLE_SPECIFICATION_GROUPS . " AS sg
                        ON s.specification_group_id = sg.specification_group_id
                      Inner Join " . TABLE_SPECIFICATIONS_TO_CATEGORIES . " AS s2c
                        ON sg.specification_group_id = s2c.specification_group_id
                      Inner Join " . TABLE_SPECIFICATION_DESCRIPTION . " sd 
                        ON sd.specifications_id = s.specifications_id
                      WHERE
                        s.show_filter = 'True'
                        AND sg.show_filter = 'True' 
                        and sd.language_id = '" . (int) $languages_id . "'
                        " . $category_sql;
  // print $specs_query_raw . "<br>\n";
  $specs_query = tep_db_query ($specs_query_raw);

  //breadcrumbs : preserve the result of the specs_query
  $specs_array_breadcrumb = array(); 
  
  // Build a string of SQL to constrain the specification to the filter values
  $sql_array = array (
    'from' => '',
    'where' => ''
  );

  while ($specs_array = tep_db_fetch_array ($specs_query) ) {
    // Retrieve the GET vars used as filters
    // Variable names are the letter "f" followed by the specifications_id for that spec.
    $var = 'f' . $specs_array['specifications_id'];
    $$var = '0';
    if (isset ($_GET[$var]) && $_GET[$var] != '') {
      // Decode the URL-encoded names, including arrays
//      $$var = tep_decode_recursive ($_GET[$var]);

        if(is_string($_GET[$var])){
            $$var = urldecode($_GET[$var]);
        }else{
            $$var = $_GET[$var];
        }

       
      // Get rid of extra values if Select All is selected
      $$var = tep_select_all_override ($$var);
      
      // Get the breadcrumbs data for the filters that are set
      $filter_breadcrumbs = tep_get_filter_breadcrumbs ($specs_array, $$var);
      $specs_array_breadcrumb = array_merge ($specs_array_breadcrumb, (array) $filter_breadcrumbs);
      
      // Set the correct variable type (All _GET variables are strings by default)
      $$var = tep_set_type ($$var);
    
      // Get the SQL to apply the filters
      $sql_string_array = tep_get_filter_sql ($specs_array['filter_class'], $specs_array['specifications_id'], $$var, $specs_array['products_column_name'], $languages_id);
      $sql_array['from'] .= $sql_string_array['from'];
      $sql_array['where'] .= $sql_string_array['where'];
      
    } // if (isset ($_GET[$var]
  } // while ($specs_array
    
  // create column list
  $define_list = array ('PRODUCT_LIST_MODEL' => PRODUCT_LIST_MODEL,
                        'PRODUCT_LIST_NAME' => PRODUCT_LIST_NAME,
                        'PRODUCT_LIST_MANUFACTURER' => PRODUCT_LIST_MANUFACTURER,
                        'PRODUCT_LIST_PRICE' => PRODUCT_LIST_PRICE,
                        'PRODUCT_LIST_QUANTITY' => PRODUCT_LIST_QUANTITY,
                        'PRODUCT_LIST_WEIGHT' => PRODUCT_LIST_WEIGHT,
                        'PRODUCT_LIST_IMAGE' => PRODUCT_LIST_IMAGE,
                        'PRODUCT_LIST_BUY_NOW' => PRODUCT_LIST_BUY_NOW);

  asort ($define_list);

  $column_list = array();
  reset ($define_list);

  while (list ($key, $value) = each ($define_list) ) {
    if ($value > 0) $column_list[] = $key;
  }

  $listing_sql = '            select SQL_CALC_FOUND_ROWS distinct ';

  for ($i=0, $n=sizeof($column_list); $i<$n; $i++) {
    switch ($column_list[$i]) {
      case 'PRODUCT_LIST_MODEL':
        $listing_sql .= "p.products_model, \n";
        break;
      case 'PRODUCT_LIST_NAME':
        $listing_sql .= "pd.products_name, \n";
        break;
      case 'PRODUCT_LIST_MANUFACTURER':
        $listing_sql .= "mi.manufacturers_name, \n";
        break;
      case 'PRODUCT_LIST_QUANTITY':
        $listing_sql .= "p.products_quantity, \n";
        break;
      case 'PRODUCT_LIST_IMAGE':
        $listing_sql .= "p.products_image, \n";
        break;
      case 'PRODUCT_LIST_WEIGHT':
        $listing_sql .= "p.products_weight, \n";
        break;
    } //switch
  } //for
  
  $listing_sql .= "p.products_id,
		   if (p.products_quantity>0,1,0) as pq,
	           if (p.products_quantity>=9999,1,0) as ps, 
	           if(p.products_quantity < 9999, 1, products_quantity_order_min) as quantity_order_min, 
	           if(p.products_quantity < 9999, 1, products_quantity_order_units) as quantity_order_units,
		   p.products_quantity,
                   p.products_model,
                   pd.products_info,
                   p.manufacturers_id,
                   mi.manufacturers_name,
                   p.products_price,
                   p.products_tax_class_id,
                   IF(s.status, s.specials_new_products_price, NULL)
                     as specials_new_products_price,
                   IF(s.status, s.specials_new_products_price, p.products_price)
                     as final_price
                 from
                   " . TABLE_PRODUCTS . " p
                 left join " . TABLE_SPECIALS . " s
                   on p.products_id = s.products_id
                 left join " . TABLE_MANUFACTURERS_INFO . " mi
                   on p.manufacturers_id = mi.manufacturers_id
                 join " . TABLE_PRODUCTS_DESCRIPTION . " pd
                   on p.products_id = pd.products_id
                 join " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c
                   on p.products_id = p2c.products_id
                   " . $sql_array['from'] . "
                 where
                   p.products_status = '1'
		          and p.products_quantity>0 
                   and pd.language_id = '" . (int) $languages_id . "'
                   " . $sql_array['where'] . "
                ";

  if ($current_category_id != 0) {
    $subcategories_array = array();
    tep_get_subcategories ($subcategories_array, $current_category_id);
        
    if (SPECIFICATIONS_FILTER_SUBCATEGORIES == 'True' && count ($subcategories_array) > 0) {
      $category_ids = $current_category_id . ',' . implode (',', $subcategories_array);
      $listing_sql .= '   ' . "and p2c.categories_id in (" . $category_ids . ") \n";
      
    } else {
      $listing_sql .= '   ' . "and p2c.categories_id = '" . $current_category_id . "' \n";
    }
  } // if ($current_category_id

  if ( (!isset($_GET['sort'])) || (!preg_match('/^[1-8][ad]$/', $_GET['sort'])) || (substr($_GET['sort'], 0, 1) > sizeof($column_list)) ) {
    $_GET['sort'] = 'products_name';
/* pre last changes in sorting order
    $listing_sql .= "             order by pq desc,pd.products_name";
*/    $listing_sql .= "             order by pq desc,ps asc,p.products_price asc ";    
  } else {
    $sort_col = substr ($_GET['sort'], 0 , 1);
    $sort_order = substr ($_GET['sort'], 1);

    switch ($column_list[$sort_col-1]) {
      case 'PRODUCT_LIST_MODEL':
        $listing_sql .= "             order by pq desc,p.products_model " . ($sort_order == 'd' ? 'desc' : '') . ", pd.products_name";
        break;
      case 'PRODUCT_LIST_NAME':
        $listing_sql .= "             order by pq desc,pd.products_name " . ($sort_order == 'd' ? 'desc' : '');
        break;
      case 'PRODUCT_LIST_MANUFACTURER':
        $listing_sql .= "             order by pq desc,mi.manufacturers_name " . ($sort_order == 'd' ? 'desc' : '') . ", pd.products_name";
        break;
      case 'PRODUCT_LIST_QUANTITY':
        $listing_sql .= "             order by pq desc,p.products_quantity " . ($sort_order == 'd' ? 'desc' : '') . ", pd.products_name";
        break;
      case 'PRODUCT_LIST_IMAGE':
        $listing_sql .= "             order by pq desc,pd.products_name";
        break;
      case 'PRODUCT_LIST_WEIGHT':
        $listing_sql .= "             order by pq desc,p.products_weight " . ($sort_order == 'd' ? 'desc' : '') . ", pd.products_name";
        break;
      case 'PRODUCT_LIST_PRICE':
        $listing_sql .= "             order by pq desc,final_price " . ($sort_order == 'd' ? 'desc' : '') . ", pd.products_name";
        break;
    } // switch ($column_list
  } // if ( (!isset($_GET['sort'] ... else ...
  // print $listing_sql . "<br>\n";

// Get the right image for the top-right
  $image = DIR_WS_IMAGES . 'table_background_list.gif';
  if ($current_category_id > 0) {
    $image = tep_db_query ("select categories_image 
                            from " . TABLE_CATEGORIES . " 
                            where categories_id = '" . (int) $current_category_id . "'
                          ");
    $image = tep_db_fetch_array ($image);
    $image = $image['categories_image'];
  }

  // Add Filter to Breadcrumbs if selected
  if (SPECIFICATIONS_FILTER_BREADCRUMB == 'True') {
    foreach ($specs_array_breadcrumb as $crumb) {
      $breadcrumb->add ($crumb['specification_name'] . ' : ' . $crumb['value'] . ' <span class="close">[X]</span>', tep_href_link (FILENAME_PRODUCTS_FILTERS, tep_get_all_get_params (array ('f' . $crumb['specifications_id']) ) ) );
    }
  }
  
  $breadcrumb->add(HEADING_TITLE, tep_href_link(FILENAME_PRODUCTS_FILTERS, '', 'NONSSL'));

  $content = CONTENT_PRODUCTS_FILTERS;




?>

<?php
  require(DIR_WS_INCLUDES . 'template_top.php');
?>
<div class="contentContainer">
    <div class="contentText">
<table border="0" width="100%" cellspacing="0" cellpadding="<?php echo CELLPADDING_SUB;?>">
<?php 
// Set number of columns in listing
define ('NR_COLUMNS', 2);?>
<?php
// BOF: Lango Added for template MOD
if (SHOW_HEADING_TITLE_ORIGINAL == 'yes') {
$header_text = '&nbsp;'
//EOF: Lango Added for template MOD
?>
      <tr> 
        <td width="100%"><table class="table-padding-0">
          <tr>
            <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
            <td align="right">&nbsp;</td>
          </tr>
        </table></td> 
      </tr>
<?php
// BOF: Lango Added for template MOD
}else{
$header_text = HEADING_TITLE;
}
// EOF: Lango Added for template MOD
?>

<?php
// BOF: Lango Added for template MOD
if (MAIN_TABLE_BORDER == 'yes'){
table_image_border_top(false, false, $header_text);
}
// EOF: Lango Added for template MOD
?>

      <tr>
        <td><table class="table-padding-2">
            
<?php
  // Show the Filters module here if set in Admin
  if (SPECIFICATIONS_FILTERS_MODULE == 'True') {
?>
      <tr>
        <td><?php echo tep_draw_separator ('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
      <tr>
        <td>
<?php
    require (DIR_FS_CATALOG.DIR_WS_MODULES . 'products_filter.php');
?>
        </td>
      </tr>
<?php
  }
?>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '20'); ?></td>
      </tr>
      <tr valign=top>
        <td valign=top><?php include(DIR_WS_MODULES . FILENAME_PRODUCT_LISTING_COL); ?></td>
      </tr>            
            
        </table></td>
      </tr>
<?php
// BOF: Lango Added for template MOD
if (MAIN_TABLE_BORDER == 'yes'){
table_image_border_bottom();
}
// EOF: Lango Added for template MOD
?>

   </table>

</div>
</div>
<?php
  require(DIR_WS_INCLUDES . 'template_bottom.php');
  require(DIR_WS_INCLUDES . 'application_bottom.php');
?>
