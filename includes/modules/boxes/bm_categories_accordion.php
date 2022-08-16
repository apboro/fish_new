<?php
/*
  $Id: bm_categories_accordion.php v1.2 20130612 Kymation $
  $Loc: catalog/includes/modules/boxes/ $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2013 osCommerce

  Released under the GNU General Public License
*/

  class bm_categories_accordion {
    var $code = 'bm_categories_accordion';
    var $group = 'boxes';
    var $title;
    var $description;
    var $sort_order;
    var $enabled = false;

    function bm_categories_accordion() {
    	global $PHP_SELF;

      $this->title = MODULE_BOXES_CATEGORIES_ACCORDION_TITLE;
      $this->description = MODULE_BOXES_CATEGORIES_ACCORDION_DESCRIPTION;

      if ( defined('MODULE_BOXES_CATEGORIES_ACCORDION_STATUS') ) {
        $this->sort_order = MODULE_BOXES_CATEGORIES_ACCORDION_SORT_ORDER;
        $this->enabled = (MODULE_BOXES_CATEGORIES_ACCORDION_STATUS == 'True');

        $this->group = ((MODULE_BOXES_CATEGORIES_ACCORDION_CONTENT_PLACEMENT == 'Left Column') ? 'boxes_column_left' : 'boxes_column_right');
      }
    }

    function tep_show_category($counter) {
      global $tree, $categories_string, $cPath_array, $category_active_id, $category_count, $PHP_SELF;

      if ($tree[$counter]['parent'] == 0) {
        $cPath_new = 'cPath=' . $counter;
        $category_count++;
      } else {
        $cPath_new = 'cPath=' . $tree[$counter]['path'];
      }

      if( $tree[$counter]['level'] == 0 ) {
       if ($tree[$counter]['category_number'] == 0 ) {
        	$category_active_id = 'false';
        } else {
          $categories_string .= '    </div>' . PHP_EOL;
        }                                            

        if (isset($cPath_array) && in_array($counter, $cPath_array)) {
          $category_active_id = $tree[$counter]['category_number'];
        }

        $categories_string .= '    <h3';
        $categories_string .= ' onclick="location.href=\'';
        $categories_string .= tep_href_link( FILENAME_DEFAULT, $cPath_new );
        $categories_string .= '\';"';
        $categories_string .= '>';

        $categories_string .= '<a href="#">';
        $categories_string .= $tree[$counter]['name'];
        $categories_string .= '</a>';

        $categories_string .= '</h3>' . PHP_EOL;
        $categories_string .= '    <div>' . PHP_EOL;

      } else {
      	$category_indent = ($tree[$counter]['level'] * 0.5 ) - 1;

        $categories_string .= '    <div style="margin: 0 -15px 0 ' . $category_indent . 'em; border-top: 1px solid #cccccc; padding-top:5px; padding-bottom: 5px;">' . PHP_EOL;

        $categories_string .= '      <a href="';
        $categories_string .= tep_href_link(FILENAME_DEFAULT, $cPath_new) . '">';

        if (isset($cPath_array) && in_array($counter, $cPath_array)) {
          $categories_string .= '<strong>';
        }

        // display category name
        $categories_string .= $tree[$counter]['name'];

        if (isset($cPath_array) && in_array($counter, $cPath_array)) {
          $categories_string .= '</strong>';
        }

        if (tep_has_category_subcategories($counter)) {
          // Uncomment the next line if you want the ugly text arrows
          // $categories_string .= '-&gt;';
        }

        $categories_string .= '</a>';
        if (SHOW_COUNTS == 'true') {
          $products_in_category = tep_count_products_in_category($counter);
          if ($products_in_category > 0) {
            $categories_string .= '&nbsp;(' . $products_in_category . ')';
          }
        }

        $categories_string .= '    </div>' . PHP_EOL;

      }

      if ($tree[$counter]['next_id'] != false) {
        $this->tep_show_category($tree[$counter]['next_id']);

      } else {
        $categories_string .= '    </div>' . PHP_EOL;
        $categories_string .= '  </div>' . PHP_EOL;
        $categories_string .= '  <script type="text/javascript">' . PHP_EOL;
        $categories_string .= '    $(function() {' . PHP_EOL;
        $categories_string .= '      $( "#categoriesMenu" ).accordion({' . PHP_EOL;
        $categories_string .= '        autoHeight: false,' . PHP_EOL;
        $categories_string .= '        collapsible: true,' . PHP_EOL;
        $categories_string .= '        icons: {' . PHP_EOL;
        $categories_string .= "          'header': 'ui-icon-" . MODULE_BOXES_CATEGORIES_ACCORDION_ICON . "'," . PHP_EOL;
        $categories_string .= "          'headerSelected': 'ui-icon-" . MODULE_BOXES_CATEGORIES_ACCORDION_ICON_SELECTED . "'" . PHP_EOL;
        $categories_string .= '        },' . PHP_EOL;
        $categories_string .= '        active: ' . $category_active_id . PHP_EOL;
        $categories_string .= '      });' . PHP_EOL;
        $categories_string .= '    });' . PHP_EOL;
        $categories_string .= '  </script>' . PHP_EOL;
      }
    }

    function getData() {
      global $categories_string, $tree, $languages_id, $cPath, $cPath_array;

      $categories_string = '<div id="categoriesMenu">' . PHP_EOL;
      $tree = array();

      $categories_query_raw = "
        select
          c.categories_id,
          cd.categories_name,
          c.parent_id
        from
          " . TABLE_CATEGORIES . " c
          join " . TABLE_CATEGORIES_DESCRIPTION . " cd
            on (cd.categories_id = c.categories_id)
        where
          c.parent_id = '0'
          and cd.language_id='" . ( int )$languages_id ."'
        order by
          sort_order,
          cd.categories_name
      ";
      $categories_query = tep_db_query( $categories_query_raw );

      $category_number = 0;
      while ($categories = tep_db_fetch_array($categories_query))  {
        $tree[$categories['categories_id']] = array('name' => $categories['categories_name'],
                                                    'parent' => $categories['parent_id'],
                                                    'level' => 0,
                                                    'path' => $categories['categories_id'],
                                                    'next_id' => false,
                                                    'category_number' => $category_number
                                                   );

        $category_number++;

        if (isset($parent_id)) {
          $tree[$parent_id]['next_id'] = $categories['categories_id'];
        }

        $parent_id = $categories['categories_id'];

        if (!isset($first_element)) {
          $first_element = $categories['categories_id'];
        }
      }

      if (tep_not_null($cPath)) {
        $new_path = '';
        reset($cPath_array);
        while (list($key, $value) = each($cPath_array)) {
          unset($parent_id);

          if (isset($first_id)) {
            unset($first_id);
          }

          $categories_query_raw = "
            select
              c.categories_id,
              cd.categories_name,
              c.parent_id
            from
              " . TABLE_CATEGORIES . " c
              join " . TABLE_CATEGORIES_DESCRIPTION . " cd
                on (c.categories_id = cd.categories_id)
            where
              c.parent_id = '" . (int)$value . "'
              and cd.language_id='" . (int)$languages_id ."'
            order by
              sort_order,
              cd.categories_name
          ";
          $categories_query = tep_db_query( $categories_query_raw );
          if (tep_db_num_rows($categories_query)) {
            $new_path .= $value;
            while ($row = tep_db_fetch_array($categories_query)) {
              $tree[$row['categories_id']] = array('name' => $row['categories_name'],
                                                   'parent' => $row['parent_id'],
                                                   'level' => $key+1,
                                                   'path' => $new_path . '_' . $row['categories_id'],
                                                   'next_id' => false,
                                                   'category_number' => false
                                                   );

              if (isset($parent_id)) {
                $tree[$parent_id]['next_id'] = $row['categories_id'];
              }

              $parent_id = $row['categories_id'];

              if (!isset($first_id)) {
                $first_id = $row['categories_id'];
              }

              $last_id = $row['categories_id'];
            }
            $tree[$last_id]['next_id'] = $tree[$value]['next_id'];
            $tree[$value]['next_id'] = $first_id;
            $new_path .= '_';
          } else {
            break;
          }
        }
      }

      $category_count = 0;
      $this->tep_show_category($first_element);

      $data .= $categories_string . PHP_EOL;
      
      return $data;
    }

    function execute() {
      global $SID, $oscTemplate;

      if ((USE_CACHE == 'true') && empty($SID)) {
        $output = tep_cache_categories_accordion_box();
      } else {
        $output = $this->getData();
      }

      $oscTemplate->addBlock($output, $this->group);
    }

    function isEnabled() {
      return $this->enabled;
    }

    function check() {
      return defined('MODULE_BOXES_CATEGORIES_ACCORDION_STATUS');
    }

    function install() {
      tep_db_query( "insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Enable Categories Module', 'MODULE_BOXES_CATEGORIES_ACCORDION_STATUS', 'True', 'Do you want to add the module to your shop?', '6', '1', 'tep_cfg_select_option(array(\'True\', \'False\'), ', now())");
      tep_db_query( "insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Content Placement', 'MODULE_BOXES_CATEGORIES_ACCORDION_CONTENT_PLACEMENT', 'Left Column', 'Should the module be loaded in the left or right column?', '6', '2', 'tep_cfg_select_option(array(\'Left Column\', \'Right Column\'), ', now())");
      tep_db_query( "insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Sort Order', 'MODULE_BOXES_CATEGORIES_ACCORDION_SORT_ORDER', '0', 'Sort order of display. Lowest is displayed first.', '6', '3', now())");
      tep_db_query( "insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Selected Icon', 'MODULE_BOXES_CATEGORIES_ACCORDION_ICON_SELECTED', 'minus', 'Select the icon to use for the selected tab.', '6', '5', 'tep_cfg_pull_down_icon(', now())");
      tep_db_query( "insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Unselected Icon', 'MODULE_BOXES_CATEGORIES_ACCORDION_ICON', 'plus', 'Select the icon to use for the unselected tabs.', '6', '4', 'tep_cfg_pull_down_icon(', now())");
    }

    function remove() {
      tep_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }

    function keys() {
      $keys = array();
      $keys[] = 'MODULE_BOXES_CATEGORIES_ACCORDION_STATUS';
      $keys[] = 'MODULE_BOXES_CATEGORIES_ACCORDION_CONTENT_PLACEMENT';
      $keys[] = 'MODULE_BOXES_CATEGORIES_ACCORDION_SORT_ORDER';
      $keys[] = 'MODULE_BOXES_CATEGORIES_ACCORDION_ICON_SELECTED';
      $keys[] = 'MODULE_BOXES_CATEGORIES_ACCORDION_ICON';

      return $keys;
    }
  } // class


  ////
  // Generate a pulldown menu of the available jquery icons
  //   Requires a text file containing a list of the icons, one per line,
  //   at: ext/jquery/ui/icons.txt
  if (!function_exists('tep_cfg_pull_down_icon')) {
    function tep_cfg_pull_down_icon($icon, $key = '') {
      $icons_array = array ();

      $file = '/ext/jquery/ui/icons.txt';
      if (file_exists($file) && is_file($file)) {
        $name = (($key) ? 'configuration[' . $key . ']' : 'configuration_value');
        $file_contents = @file($file);

        foreach ($file_contents as $icon_name) {
          $icon_name = trim($icon_name);

          if (strlen($icon_name) > 0) {
            $icon_name = str_replace('ui-icon-', '', $icon_name);

            $icons_array[] = array (
              'id' => $icon_name,
              'text' => $icon_name
            );

          } // if (strlen
        } // foreach ($file_contents
      } // if( file_exists

      return tep_draw_pull_down_menu($name, $icons_array, $icon);
    } // function tep_cfg_pull_down_icon
  } // if (!function_exists
?>