<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2013 osCommerce

  Released under the GNU General Public License
*/

  class bm_help {
    var $code = 'bm_help';
    var $group = 'boxes_column_right';
    var $title;
    var $description;
    var $sort_order;
    var $enabled;

    function bm_help() {
      $this->title ='Консультант';
      $this->description = '';
      if (defined('MODULE_BOXES_HELP_STATUS') ) {
        $this->sort_order = MODULE_BOXES_HELP_SORT_ORDER;
        $this->enabled = (MODULE_BOXES_HELP_STATUS == 'True');
        $this->group = ((MODULE_BOXES_HELP_CONTENT_PLACEMENT == 'Left Column') ? 'boxes_column_left' : 'boxes_column_right');
      }
    }

    function execute() {
      global $oscTemplate;

    $data = '<div class="ui-widget infoBoxContainer mj-quickfind">' .
      '  <div class="ui-widget-header infoBoxHeading">' . $this->title . '</div>' .
      '  <div class="ui-widget-content infoBoxContents">' .
      MODULE_BOXES_HELP_CONTENT_TEXT.
      '  </div>' .
      '</div>';

      $oscTemplate->addBlock($data, $this->group);
    }

    function isEnabled() {
      return $this->enabled;
    }

    function check() {
     return defined('MODULE_BOXES_HELP_STATUS');
    }

    function install() {
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Enable Help Module', 'MODULE_BOXES_HELP_STATUS', 'True', 'Do you want to add the module to your shop?', '6', '1', 'tep_cfg_select_option(array(\'True\', \'False\'), ', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Content Placement', 'MODULE_BOXES_HELP_CONTENT_PLACEMENT', 'Left Column', 'Should the module be loaded in the left or right column?', '6', '1', 'tep_cfg_select_option(array(\'Left Column\', \'Right Column\'), ', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Sort Order', 'MODULE_BOXES_HELP_SORT_ORDER', '0', 'Sort order of display. Lowest is displayed first.', '6', '0', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Content', 'MODULE_BOXES_HELP_CONTENT_TEXT', '0', 'Content of box', '6', 'Input content here', now())");

    }

    function remove() {
      tep_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");

    }

    function keys() {
      return array('MODULE_BOXES_HELP_STATUS', 
    	           'MODULE_BOXES_HELP_CONTENT_PLACEMENT', 
    	           'MODULE_BOXES_HELP_SORT_ORDER',
    	           'MODULE_BOXES_HELP_CONTENT_TEXT');

    return null;
    }
  }
?>
