<?php
/*
  $Id: rusbank.php,v 1.2 2002/11/22

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2002 osCommerce

  Released under the GNU General Public License
*/

  class rusbank {
    var $code, $title, $description, $enabled;

// class constructor
    function rusbank() {
      $this->code = 'rusbank';
      $this->title = MODULE_PAYMENT_RUS_BANK_TEXT_TITLE;
      $this->description = MODULE_PAYMENT_RUS_BANK_TEXT_DESCRIPTION;
      $this->sort_order = MODULE_PAYMENT_RUS_BANK_SORT_ORDER;
      $this->icon = DIR_WS_ICONS . 'kvitancia.png';
      $this->email_footer = MODULE_PAYMENT_RUS_BANK_TEXT_EMAIL_FOOTER;
      $this->enabled = ((MODULE_PAYMENT_RUS_BANK_STATUS == 'True') ? true : false);

      if ((int)MODULE_PAYMENT_RUS_BANK_ORDER_STATUS_ID > 0) {
        $this->order_status = MODULE_PAYMENT_RUS_BANK_ORDER_STATUS_ID;
      }

      if (is_object($order)) $this->update_status();
    }

// class methods
    function update_status() {
      global $order;

      if ( ($this->enabled == true) && ((int)MODULE_PAYMENT_RUS_BANK_ZONE > 0) ) {
        $check_flag = false;
        $check_query = tep_db_query("select zone_id from " . TABLE_ZONES_TO_GEO_ZONES . " where geo_zone_id = '" . MODULE_PAYMENT_RUS_BANK_ZONE . "' and zone_country_id = '" . $order->delivery['country']['id'] . "' order by zone_id");
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
    function javascript_validation() {
      return false;
    }

	function selection() {
      global $order, $customer_id;

 if (tep_session_is_registered('customer_id')) {

  $customer_info_query = tep_db_query("select orders_id from " . TABLE_ORDERS . " where customers_id = '". (int)$customer_id . "'");
  $customer_info = tep_db_fetch_array($customer_info_query);

  $person_info_query = tep_db_query("select name, address from " . TABLE_PERSONS . " where orders_id = '". (int)$customer_info['orders_id'] . "'");
  $person_info = tep_db_fetch_array($person_info_query);

}

      //if (tep_not_null($this->icon)) $icon = tep_image($this->icon, $this->title);
      
      $selection = array('id' => $this->code,
      				'icon' => $icon,
                   'module' => $this->title, 
                         'description'=>$this->info
                         /*, 
      	                 'fields' => array(array('title' => '',
      	                                         'field' => ''),
      	                                   
      	                                   )*/);  

		return $selection;  
      	                                   
	}     

	function pre_confirmation_check() {

        $this->name = tep_db_prepare_input($_SESSION['kvit_name']);
        $this->address = tep_db_prepare_input($_SESSION['kvit_address']);

	}

    function confirmation() {
      return array('title' => MODULE_PAYMENT_RUS_BANK_TEXT_DESCRIPTION);
    }

	function process_button() {

      $process_button_string = tep_draw_hidden_field('kvit_name', $this->name) .
                               tep_draw_hidden_field('kvit_address', $this->address);

      return $process_button_string;

	}

	function before_process() {

    	 $this->pre_confirmation_check();
    	return false;

	}

	function after_process() {

      global $insert_id, $name, $address, $checkout_form_action, $checkout_form_submit;
      tep_db_query("INSERT INTO ".TABLE_PERSONS." (orders_id, name, address) VALUES ('" . tep_db_prepare_input($insert_id) . "', '" . tep_db_prepare_input($_SESSION['kvit_name']) . "', '" . tep_db_prepare_input($_SESSION['kvit_address']) ."')");

	}

    function get_error() {
      return false;
    }

    function check() {
      if (!isset($this->check)) {
        $check_query = tep_db_query("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_PAYMENT_RUS_BANK_STATUS'");
        $this->check = tep_db_num_rows($check_query);
      }
      return $this->check;
    }

    function install() {
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Разрешить модуль Оплата по квитанции Сбербанка РФ', 'MODULE_PAYMENT_RUS_BANK_STATUS', 'True', 'Вы хотите разрешить использование модуля при оформлении заказов?', '6', '1', 'tep_cfg_select_option(array(\'True\', \'False\'), ', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Название банка', 'MODULE_PAYMENT_RUS_BANK_1', '', 'Введите название банка', '6', '2', now());");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Расчетный счет', 'MODULE_PAYMENT_RUS_BANK_2', '', 'Введите Ваш расчетный счет', '6', '3', now());");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('БИК', 'MODULE_PAYMENT_RUS_BANK_3', '', 'Введите БИК', '6', '4', now());");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Кор./счет', 'MODULE_PAYMENT_RUS_BANK_4', '', 'Введите Кор./счет', '6', '5', now());");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('ИНН', 'MODULE_PAYMENT_RUS_BANK_5', '', 'Введите ИНН', '6', '6', now());");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Получатель', 'MODULE_PAYMENT_RUS_BANK_6', '', 'Получатель платежа', '6', '7', now());");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('КПП', 'MODULE_PAYMENT_RUS_BANK_7', '', 'Введите КПП', '6', '8', now());");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Назначение платежа', 'MODULE_PAYMENT_RUS_BANK_8', '', 'Укажите назначение платежа', '6', '9', now());");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Порядок сортировки.', 'MODULE_PAYMENT_RUS_BANK_SORT_ORDER', '0', 'Порядок сортировки модуля.', '6', '10', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) values ('Зона', 'MODULE_PAYMENT_RUS_BANK_ZONE', '0', 'Если выбрана зона, то данный модуль оплаты будет виден только покупателям из выбранной зоны.', '6', '11', 'tep_get_zone_class_title', 'tep_cfg_pull_down_zone_classes(', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, use_function, date_added) values ('Статус заказа', 'MODULE_PAYMENT_RUS_BANK_ORDER_STATUS_ID', '0', 'Заказы, оформленные с использованием данного модуля оплаты будут принимать указанный статус.', '6', '12', 'tep_cfg_pull_down_order_statuses(', 'tep_get_order_status_name', now())");
   }

    function remove() {
      tep_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }

    function keys() {
      return array('MODULE_PAYMENT_RUS_BANK_STATUS', 'MODULE_PAYMENT_RUS_BANK_1', 'MODULE_PAYMENT_RUS_BANK_2', 'MODULE_PAYMENT_RUS_BANK_3', 'MODULE_PAYMENT_RUS_BANK_4', 'MODULE_PAYMENT_RUS_BANK_5', 'MODULE_PAYMENT_RUS_BANK_6', 'MODULE_PAYMENT_RUS_BANK_7', 'MODULE_PAYMENT_RUS_BANK_8', 'MODULE_PAYMENT_RUS_BANK_SORT_ORDER','MODULE_PAYMENT_RUS_BANK_ZONE', 'MODULE_PAYMENT_RUS_BANK_ORDER_STATUS_ID');
      return $keys;
    }
  }
?>