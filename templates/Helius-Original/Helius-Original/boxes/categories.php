<?php
/*
  $Id: categories2.php,v 1.1.1.1 2003/09/18 19:05:49 wilt Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2002 osCommerce

  Released under the GNU General Public License
*/

//###############################################
//if ( (USE_CACHE == 'true') && !defined('SID')) {
//    echo tep_cache_categories_box();
//  } else {
//###############################################


  function tep_show_category($counter) {
    global $foo, $categories_string, $id;

    for ($a=0; $a<$foo[$counter]['level']; $a++) {
      $categories_string .= "&nbsp;&nbsp;";
    }

    $categories_string .= '<a href="';

    if ($foo[$counter]['parent'] == 0) {
      $cPath_new = 'cPath=' . $counter;
    } else {
      $cPath_new = 'cPath=' . $foo[$counter]['path'];
    }

    $categories_string .= tep_href_link(FILENAME_DEFAULT, $cPath_new);
    $categories_string .= '">';

    if (tep_has_category_subcategories($counter)) {
      $categories_string .= tep_image(DIR_WS_TEMPLATES . TEMPLATE_NAME . '/images/content/pointer.gif', '');
    }
    else {
      $categories_string .= tep_image(DIR_WS_TEMPLATES . TEMPLATE_NAME . '/images/content/pointer_light.gif', '');
    }
    

    if ( ($id) && (in_array($counter, $id)) ) {
      $categories_string .= '<b>';
    }
    
    if ($cat_name == $tree[$counter]['name']) {
      $categories_string .= '<span class="headerNavigation">';
    }    

// display category name
    $categories_string .= $foo[$counter]['name'];

    if ( ($id) && (in_array($counter, $id)) ) {
      $categories_string .= '</b>';
    }

    if (tep_has_category_subcategories($counter)) {
      $categories_string .= '</span>';
    }

    $categories_string .= '</a>';

    if (SHOW_COUNTS == 'true') {
      $products_in_category = tep_count_products_in_category($counter);
      if ($products_in_category > 0) {
        $categories_string .= '&nbsp;(' . $products_in_category . ')';
      }
    }

    $categories_string .= '<br>';

    if ($foo[$counter]['next_id']) {
      tep_show_category($foo[$counter]['next_id']);
    }
  }
?>
<!-- categories //-->
          <tr>
            <td>
<?php

  $info_box_contents = array();
  $info_box_contents[] = array('text' => '<font color="' . $font_color . '">' . BOX_HEADING_CATEGORIES . '</font>');
  new infoBoxHeading($info_box_contents, false, false);

  $categories_string = '';

//  $categories_query = tep_db_query("select c.categories_id, cd.categories_name, c.parent_id from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd where c.parent_id = '0' and c.categories_id = cd.categories_id and cd.language_id='" . $languages_id ."' order by sort_order, cd.categories_name");

// BOF Enable - Disable Categories Contribution-------------------------------------- 
  $categories_query = tep_db_query("select c.categories_id, cd.categories_name, c.parent_id from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd where c.categories_status = '1' and c.parent_id = '0' and c.categories_id = cd.categories_id and cd.language_id='" . (int)$languages_id ."' order by sort_order, cd.categories_name");
// EOF Enable - Disable Categories Contribution-------------------------------------- 

  while ($categories = tep_db_fetch_array($categories_query))  {
    $foo[$categories['categories_id']] = array(
                                        'name' => $categories['categories_name'],
                                        'parent' => $categories['parent_id'],
                                        'level' => 0,
                                        'path' => $categories['categories_id'],
                                        'next_id' => false
                                       );

    if (isset($prev_id)) {
      $foo[$prev_id]['next_id'] = $categories['categories_id'];
    }

    $prev_id = $categories['categories_id'];

    if (!isset($first_element)) {
      $first_element = $categories['categories_id'];
    }
  }

  //------------------------
  if ($cPath) {
    $new_path = '';
    $id = preg_split('/_/', $cPath);
    reset($id);
    while (list($key, $value) = each($id)) {
      unset($prev_id);
      unset($first_id);
// BOF Enable - Disable Categories Contribution-------------------------------------- 
      $categories_query = tep_db_query("select c.categories_id, cd.categories_name, c.parent_id from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd where c.categories_status = '1' and c.parent_id = '" . (int)$value . "' and c.categories_id = cd.categories_id and cd.language_id='" . (int)$languages_id ."' order by sort_order, cd.categories_name");
// EOF Enable - Disable Categories Contribution-------------------------------------- 

//      $categories_query = tep_db_query("select c.categories_id, cd.categories_name, c.parent_id from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd where c.parent_id = '" . $value . "' and c.categories_id = cd.categories_id and cd.language_id='" . $languages_id ."' order by sort_order, cd.categories_name");
      $category_check = tep_db_num_rows($categories_query);
      if ($category_check > 0) {
        $new_path .= $value;
        while ($row = tep_db_fetch_array($categories_query)) {
          $foo[$row['categories_id']] = array(
                                              'name' => $row['categories_name'],
                                              'parent' => $row['parent_id'],
                                              'level' => $key+1,
                                              'path' => $new_path . '_' . $row['categories_id'],
                                              'next_id' => false
                                             );

          if (isset($prev_id)) {
            $foo[$prev_id]['next_id'] = $row['categories_id'];
          }

          $prev_id = $row['categories_id'];

          if (!isset($first_id)) {
            $first_id = $row['categories_id'];
          }

          $last_id = $row['categories_id'];
        }
        $foo[$last_id]['next_id'] = $foo[$value]['next_id'];
        $foo[$value]['next_id'] = $first_id;
        $new_path .= '_';
      } else {
        break;
      }
    }
  }
  tep_show_category($first_element); 

  $info_box_contents = array();

  $info_box_contents[] = array('align' => 'left',
                               'text'  => $categories_string
                              );
  $info_box_contents[] = array('align' => 'center',
                               'text'  => '<span class="headerNavigation"><a href="' . tep_href_link(FILENAME_PRICE_HTML, '', 'NONSSL') . '">' . BOX_INFORMATION_ALLPRODS . '</a></span>');
                              
  new infoBox($info_box_contents);
  
$info_box_contents = array();
$info_box_contents[] = array('align' => 'left',
'text'  => tep_draw_separator('pixel_trans.gif', '100%', '1')
                              );
  new infoboxFooter($info_box_contents, true, true);

?>
            </td>
          </tr>
<?php
//}
?>
<!--############################################### //-->
<!--############################################## //-->
<!-- categories_eof //-->

