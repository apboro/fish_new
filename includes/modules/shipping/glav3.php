<?php
/*
  $Id: glav2.php,v 1.1.1.1 2003/09/18 19:04:56 wilt Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2001,2002 osCommerce

  Released under the GNU General Public License
*/
class glav3 {
    var $code, $title, $description, $icon, $enabled;

// class constructor
    function glav3() {
      global $order;

      $this->code = 'glav3';
      $this->title = MODULE_SHIPPING_GLAV3_TEXT_TITLE;
      $this->description = MODULE_SHIPPING_GLAV3_TEXT_DESCRIPTION;
      $this->sort_order = MODULE_SHIPPING_GLAV3_SORT_ORDER;
      $this->icon = '';
      $this->tax_class = MODULE_SHIPPING_GLAV3_TAX_CLASS;
      $this->enabled = ((MODULE_SHIPPING_GLAV3_STATUS == 'True') ? true : false);

      if ( ($this->enabled == true) && ((int)MODULE_SHIPPING_GLAV3_ZONE > 0) ) {
        $check_flag = false;
        $check_query = tep_db_query("select zone_id from " . TABLE_ZONES_TO_GEO_ZONES . " where geo_zone_id = '" . MODULE_SHIPPING_GLAV3_ZONE . "' and zone_country_id = '" . $order->delivery['country']['id'] . "' order by zone_id");
        while ($check = tep_db_fetch_array($check_query)) {
          if ($check['zone_id'] < 1) {
            $check_flag = true;
            break;
          } elseif ($check['zone_id'] == $order->delivery['zone_id']) {
            $check_flag = true;
            break;
          }
        }

        if ($check_flag == false) {
          $this->enabled = false;
        }
      }
    }

// class methods
    function quote($method = '') {
      global $order, $cart;

     if ($order->info['subtotal']<1000){$cost=100;}
     if ($order->info['subtotal']>1000){$cost=0;}
	  
      $this->quotes = array('id' => $this->code,
                            'module' => MODULE_SHIPPING_GLAV3_TEXT_TITLE,
                            'methods' => array(array('id' => $this->code,
                                                     'title' => MODULE_SHIPPING_GLAV3_TEXT_WAY,
                                                     'cost' => $cost)));

      if ($this->tax_class > 0) {
        $this->quotes['tax'] = tep_get_tax_rate($this->tax_class, $order->delivery['country']['id'], $order->delivery['zone_id']);
      }

      if (tep_not_null($this->icon)) $this->quotes['icon'] = tep_image($this->icon, $this->title);

      return $this->quotes;
    }

    function check() {
      if (!isset($this->_check)) {
        $check_query = tep_db_query("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_SHIPPING_GLAV3_STATUS'");
        $this->_check = tep_db_num_rows($check_query);
      }
      return $this->_check;
    }

    function install() {
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('?????????????????? ???????????? ???????????????????? ????????????????', 'MODULE_SHIPPING_GLAV3_STATUS', 'True', '???? ???????????? ?????????????????? ???????????? ???????????????????? ?????????????????', '6', '0', 'tep_cfg_select_option(array(\'True\', \'False\'), ', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('??????????????', 'MODULE_SHIPPING_GLAV3_RATE', '.18', '?????????????????? ???????????????? ???????????? ?????????????? ?? ?????????????????? ???? ?????????? ?????????????????? ????????????, ???????????????? ???? .01 ???? .99', '6', '0', now())");
	  tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('?????????????? ?????????????????? ?????? ?????????????? ????', 'MODULE_SHIPPING_GLAV3_LESS_THEN', '34.75', '?????????????? ?????????????????? ???????????????? ?????? ??????????????, ???????????????????? ???? ?????????????????? ????????????????.', '6', '0', now())");
	  tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('?????????????? ???????????????????? ??????????????????', 'MODULE_SHIPPING_GLAV3_FLAT_USE', '6.50', '?????????????? ?????????????????? ???????????????? ?? ?????????????????? ???? ?????????? ?????????????????? ????????????, ?????????????????????????? ?????? ???????? ??????????????.', '6', '0', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) values ('??????????', 'MODULE_SHIPPING_GLAV3_TAX_CLASS', '0', '???????????????????????? ??????????.', '6', '0', 'tep_get_tax_class_title', 'tep_cfg_pull_down_tax_classes(', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) values ('????????', 'MODULE_SHIPPING_GLAV3_ZONE', '0', '???????? ?????????????? ????????, ???? ???????????? ???????????? ???????????????? ?????????? ?????????? ???????????? ?????????????????????? ???? ?????????????????? ????????.', '6', '0', 'tep_get_zone_class_title', 'tep_cfg_pull_down_zone_classes(', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('?????????????? ????????????????????', 'MODULE_SHIPPING_GLAV3_SORT_ORDER', '0', '?????????????? ???????????????????? ????????????.', '6', '0', now())");
    }

    function remove() {
      tep_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }

    function keys() {
      return array('MODULE_SHIPPING_GLAV3_STATUS', 'MODULE_SHIPPING_GLAV3_RATE', 'MODULE_SHIPPING_GLAV3_LESS_THEN', 'MODULE_SHIPPING_GLAV3_FLAT_USE', 'MODULE_SHIPPING_GLAV3_TAX_CLASS', 'MODULE_SHIPPING_GLAV3_ZONE', 'MODULE_SHIPPING_GLAV3_SORT_ORDER');
    }
  }
?>
