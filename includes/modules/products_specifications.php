<?php
/*
  $Id: products_specifications.php, v1.0.1 20090917 kymation Exp $
  $Loc: catalog/includes/modules/ $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2009 osCommerce

  Released under the GNU General Public License
*/

/*
 * This file produces the product specification list on the Product Info page.
 * 
 * $current_category_id and $_GET['products_id'] are required to determine which
 * specifications to show.
 */
  
  $specification_box_heading = array();
  $specification_box_heading[] = array ('text' => SPECIFICATION_TITLE_PRODUCTS);
  
  $specifications_query_raw = "select ps.specification, 
                                      s.filter_display,
                                      s.enter_values,
                                      sd.specification_name, 
                                      sd.specification_prefix, 
                                      sd.specification_suffix                                      
                               from " . TABLE_PRODUCTS_SPECIFICATIONS . " ps, 
                                    " . TABLE_SPECIFICATION . " s, 
                                    " . TABLE_SPECIFICATION_DESCRIPTION . " sd, 
                                    " . TABLE_SPECIFICATION_GROUPS . " sg,
                                    " . TABLE_SPECIFICATIONS_TO_CATEGORIES . " sg2c
                               where sg.show_products = 'True'
                                 and s.show_products = 'True'
                                 and s.specification_group_id = sg.specification_group_id 
                                 and sg.specification_group_id = sg2c.specification_group_id 
                                 and sd.specifications_id = s.specifications_id
                                 and ps.specifications_id = sd.specifications_id
                                 and sg2c.categories_id = '" . (int) $current_category_id . "' 
                                 and ps.products_id = '" . (int) $_GET['products_id'] . "' 
                                 and sd.language_id = '" . (int) $languages_id . "' 
                                 and ps.language_id = '" . (int) $languages_id . "' 
                               order by s.specification_sort_order, 
                                        sd.specification_name
                             ";
  // print $specifications_query_raw . "<br>\n";
  $specifications_query = tep_db_query ($specifications_query_raw);

  $count_specificatons = tep_db_num_rows ($specifications_query);
  if ($count_specificatons >= SPECIFICATIONS_MINIMUM_PRODUCTS || SPECIFICATIONS_BOX_FRAME_STYLE == 'Tabs') {
    $specifications_box_contents = array();
    $specification_text = '<ul class=specification_box>' . "\n";

    while ($specifications = tep_db_fetch_array ($specifications_query) ) {
      if ($specifications['specification'] != '') {
        $specification_text .= '<li>';
      
        if (SPECIFICATIONS_SHOW_NAME_PRODUCTS == 'True') {
          $specification_text .= $specifications['specification_name'] . ': ';
        }
      
        $specification_text .= $specifications['specification_prefix'] . ' ';
                      
        if ($specifications['display'] == 'image' || $specifications['display'] == 'multiimage' || $specifications['enter'] == 'image' || $specifications['enter'] == 'multiimage') { 
          tep_image (DIR_WS_IMAGES . $specifications['specification'], $specifications['specification_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT);
        } else {
          $specification_text .= $specifications['specification'] . ' ';
        }

        $specification_text .= $specifications['specification_suffix'];
        $specification_text .= '</li>' . "\n";
      } // if ($specifications['specification']
    } // while ($specifications
    $specification_text .= '</ul>' . "\n";
    
    $specifications_box_contents[0] = array ('align' => 'left',
                                             'params' => 'class="main" valign="middle"',
                                             'text' => $specification_text
                                            );
    
?>
<table border="0" width="100%" cellspacing="2" cellpadding="3" class="specs_box">
  <tr>
    <td class="main" valign="top">
<!-- products_specifications_box //-->
<?php
    // Show the heading if selected
    if (SPECIFICATIONS_SHOW_TITLE_PRODUCTS == 'True' && (SPECIFICATIONS_BOX_FRAME_STYLE == 'Plain' || SPECIFICATIONS_BOX_FRAME_STYLE == 'Simple') ) {
      echo '<b>' . $specification_box_heading[0]['text'] . '</b>';
    }

    // Output the specifications in the selected style
    switch (SPECIFICATIONS_BOX_FRAME_STYLE) {
      case 'Tabs':
        include_once (DIR_WS_MODULES . FILENAME_PRODUCTS_TABS);
        break;
        
      case 'Plain':
        new borderlessBox ($specifications_box_contents);
        break;
        
      case 'Simple':
        new productListingBox ($specifications_box_contents);
        break;
        
      case 'Stock':
      default:
        new contentBoxHeading ($specification_box_heading, false, false);
        new contentBox ($specifications_box_contents);
        break;
    } // switch
?>
<!-- products_specifications_box_eof //-->
    </td>
  </tr>
</table>
<?php
  } //if ($count_specificatons
?>