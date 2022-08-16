<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2010 osCommerce

  Released under the GNU General Public License
*/

  class bm_categories_menu {
    var $code = 'bm_categories_menu';
    var $group = 'boxes';
    var $title;
    var $description;
    var $sort_order;
    var $enabled = false;

    function bm_categories_menu() {
      $this->title = MODULE_BOXES_CATEGORIES_MENU_TITLE;
      $this->description = MODULE_BOXES_CATEGORIES_MENU_DESCRIPTION;

      if ( defined('MODULE_BOXES_CATEGORIES_MENU_STATUS') ) {
        $this->sort_order = MODULE_BOXES_CATEGORIES_MENU_SORT_ORDER;
        $this->enabled = (MODULE_BOXES_CATEGORIES_MENU_STATUS == 'True');

        $this->group = ((MODULE_BOXES_CATEGORIES_MENU_CONTENT_PLACEMENT == 'Left Column') ? 'boxes_column_left' : 'boxes_column_right');
      }
    }
	
	function cattreeLeft($parent_id = 0, $level = 0, $cPath_tree = ''){
		global $languages_id, $cPath_array;
		$categories_query_top = tep_db_query("select c.categories_id, cd.categories_name, c.parent_id from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd where c.parent_id = '".(int)$parent_id."' and c.categories_id = cd.categories_id and cd.language_id='" . (int)$languages_id ."' order by sort_order, cd.categories_name");
			
		$i = 0;
		$totCat = tep_db_num_rows($categories_query_top);
		
		while ($categories_top = tep_db_fetch_array($categories_query_top))  {
			if($categories_top['parent_id'] == 0){
				if($i == 0){
					$output = '<div id="ddsidemenubar" class="markermenu"><ul>';
				}
				if($this->cattreeLeft($categories_top['categories_id'], ($level+1), $categories_top['categories_id']) != ""){
					$output .= '<li><a href="'.tep_href_link(FILENAME_DEFAULT, 'cPath=' . $categories_top['categories_id']).'" rel="ddsubmenuside'.$categories_top['categories_id'].'">'.ucwords($categories_top['categories_name']).'</a></li>';
				}else{
					$output .= '<li><a href="'.tep_href_link(FILENAME_DEFAULT, 'cPath=' . $categories_top['categories_id']).'">'.ucwords($categories_top['categories_name']).'</a></li>';
				}
				if($i == ($totCat-1)){
					$output .= '</ul></div>';
					$output .= '<script type="text/javascript">ddlevelsmenu.setup("ddsidemenubar", "sidebar") //ddlevelsmenu.setup("mainmenuid", "topbar|sidebar")</script>';
				}
				$output .= $this->cattreeLeft($categories_top['categories_id'], ($level+1), $categories_top['categories_id']);
			}else{
				if($i == 0 && $level == 1){
					$output .= '<ul id="ddsubmenuside'.$categories_top['parent_id'].'" class="ddsubmenustyle blackwhite">';
				}elseif($i == 0 && $level > 1){
					$output .= '<ul class="innerUi">';
				}
				$output .= '<li>';
				$output .= '<a href="'.tep_href_link(FILENAME_DEFAULT, 'cPath=' . $cPath_tree.'_'.$categories_top['categories_id']).'">'.ucwords($categories_top['categories_name']).'</a>';
				$output .= $this->cattreeLeft($categories_top['categories_id'], ($level+1), $cPath_tree.'_'.$categories_top['categories_id']);
				$output .= '</li>';
				if($i == ($totCat-1)){
					$output .= '</ul>';
				}			
			}
			$i++;
		}
		return $output;
	  }	

    function getData() {
	  
	  $data = '<div class="ui-widget infoBoxContainer">' .
              '  <div class="ui-widget-header infoBoxHeading">' . MODULE_BOXES_CATEGORIES_BOX_TITLE . '</div>' .
              '  <div class="ui-widget-content infoBoxContents">' . $this->cattreeLeft() . '</div>' .
              '</div>';
      return $data;
    }

    function execute() {
      global $SID, $oscTemplate;

      if ((USE_CACHE == 'true') && empty($SID)) {
        $output = tep_cache_categories_box();
      } else {
        $output = $this->getData();
      }

      $oscTemplate->addBlock($output, $this->group);
    }

    function isEnabled() {
      return $this->enabled;
    }

    function check() {
      return defined('MODULE_BOXES_CATEGORIES_MENU_STATUS');
    }

    function install() {
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Enable Categories Module', 'MODULE_BOXES_CATEGORIES_MENU_STATUS', 'True', 'Do you want to add the module to your shop?', '6', '1', 'tep_cfg_select_option(array(\'True\', \'False\'), ', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Content Placement', 'MODULE_BOXES_CATEGORIES_MENU_CONTENT_PLACEMENT', 'Left Column', 'Should the module be loaded in the left or right column?', '6', '1', 'tep_cfg_select_option(array(\'Left Column\', \'Right Column\'), ', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Sort Order', 'MODULE_BOXES_CATEGORIES_MENU_SORT_ORDER', '0', 'Sort order of display. Lowest is displayed first.', '6', '0', now())");
    }

    function remove() {
      tep_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }

    function keys() {
      return array('MODULE_BOXES_CATEGORIES_MENU_STATUS', 'MODULE_BOXES_CATEGORIES_MENU_CONTENT_PLACEMENT', 'MODULE_BOXES_CATEGORIES_MENU_SORT_ORDER');
    }
  }
?>
