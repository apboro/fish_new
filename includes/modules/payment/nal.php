<?php
/*
  $Id: cod.php,v 1.1.1.1 2003/09/18 19:05:01 wilt Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/

  class nal {
    var $code, $title, $description, $enabled;

// class constructor
    function nal() {
      global $order;

      $this->code = 'nal';
      $this->title = MODULE_PAYMENT_NAL_TEXT_TITLE;
      $this->description = MODULE_PAYMENT_NAL_TEXT_DESCRIPTION;
      $this->sort_order = MODULE_PAYMENT_NAL_SORT_ORDER;
      $this->enabled = ((MODULE_PAYMENT_NAL_STATUS == 'True') ? true : false);

      if ($order->info['subtotal']<500){$this->enabled=false;return;}

      if ((int)MODULE_PAYMENT_NAL_ORDER_STATUS_ID > 0) {
        $this->order_status = MODULE_PAYMENT_NAL_ORDER_STATUS_ID;
      }

      if (is_object($order)) $this->update_status();
    }

// class methods
    function update_status() {
      global $order;

      if ( ($this->enabled == true) && ((int)MODULE_PAYMENT_NAL_ZONE > 0) ) {
        $check_flag = false;
        $check_query = tep_db_query("select zone_id from " . TABLE_ZONES_TO_GEO_ZONES . " where geo_zone_id = '" . MODULE_PAYMENT_NAL_ZONE . "' and zone_country_id = '" . $order->delivery['country']['id'] . "' order by zone_id");
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

// disable the module if the order only contains virtual products
      if ($this->enabled == true) {
        if ($order->content_type == 'virtual') {
          $this->enabled = false;
        }
      }
    }

    function javascript_validation() {
      return false;
    }

    function selection() {
	global $order, $cart;
	$procent = round($order->info['subtotal']*0.04)+250;
	
      return array('id' => $this->code,
                   'module' => $this->title." - при этом способе оплаты доставка составит ".$procent." руб.");
    }

    function pre_confirmation_check() {
      return false;
    }

    function confirmation() {
      return false;
    }

    function process_button() {
      return false;
    }

    function before_process() {
      return false;
    }

    function after_process() {
      return false;
    }

    function get_error() {
      return false;
    }

    function check() {
      if (!isset($this->_check)) {
        $check_query = tep_db_query("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_PAYMENT_NAL_STATUS'");
        $this->_check = tep_db_num_rows($check_query);
      }
      return $this->_check;
    }

    function install() {
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Разрешить модуль Оплата наличными при получении', 'MODULE_PAYMENT_NAL_STATUS', 'True', 'Вы хотите разрешить использование модуля при оформлении заказов?', '6', '1', 'tep_cfg_select_option(array(\'True\', \'False\'), ', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) values ('Зона', 'MODULE_PAYMENT_NAL_ZONE', '0', 'Если выбрана зона, то данный модуль оплаты будет виден только покупателям из выбранной зоны.', '6', '2', 'tep_get_zone_class_title', 'tep_cfg_pull_down_zone_classes(', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Порядок сортировки.', 'MODULE_PAYMENT_NAL_SORT_ORDER', '0', 'Порядок сортировки модуля.', '6', '0', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, use_function, date_added) values ('Статус заказа', 'MODULE_PAYMENT_NAL_ORDER_STATUS_ID', '0', 'Заказы, оформленные с использованием данного модуля оплаты будут принимать указанный статус.', '6', '0', 'tep_cfg_pull_down_order_statuses(', 'tep_get_order_status_name', now())");
   }

    function remove() {
      tep_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }

    function keys() {
      return array('MODULE_PAYMENT_NAL_STATUS', 'MODULE_PAYMENT_NAL_ZONE', 'MODULE_PAYMENT_NAL_ORDER_STATUS_ID', 'MODULE_PAYMENT_NAL_SORT_ORDER');
    }
  }
?>