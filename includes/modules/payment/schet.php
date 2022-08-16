<?php
/*
  $Id: schet.php,v 1.2 2002/11/22

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2002 osCommerce

  Released under the GNU General Public License
*/

  class schet {
    var $code, $title, $description, $enabled;

// class constructor
    function schet() {
      $this->code = 'schet';
      $this->title = MODULE_PAYMENT_RUS_SCHET_TEXT_TITLE;
      $this->description = MODULE_PAYMENT_RUS_SCHET_TEXT_DESCRIPTION;
      $this->sort_order = MODULE_PAYMENT_RUS_SCHET_SORT_ORDER;
      $this->email_footer = MODULE_PAYMENT_RUS_SCHET_TEXT_EMAIL_FOOTER;
      $this->enabled = ((MODULE_PAYMENT_RUS_SCHET_STATUS == 'True') ? true : false);

      if ((int)MODULE_PAYMENT_RUS_SCHET_ORDER_STATUS_ID > 0) {
        $this->order_status = MODULE_PAYMENT_RUS_SCHET_ORDER_STATUS_ID;
      }

      if (is_object($order)) $this->update_status();
    }

// class methods
    function update_status() {
      global $order;

      if ( ($this->enabled == true) && ((int)MODULE_PAYMENT_RUS_SCHET_ZONE > 0) ) {
        $check_flag = false;
        $check_query = tep_db_query("select zone_id from " . TABLE_ZONES_TO_GEO_ZONES . " where geo_zone_id = '" . MODULE_PAYMENT_RUS_SCHET_ZONE . "' and zone_country_id = '" . $order->delivery['country']['id'] . "' order by zone_id");
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

  $payment_info_query = tep_db_query("select name, inn, kpp, ogrn, okpo, rs, bank_name, bik, ks, address, yur_address, fakt_address, telephone, fax, email, director, accountant from " . TABLE_COMPANIES . " where orders_id = '". (int)$customer_info['orders_id'] . "'");
  $payment_info = tep_db_fetch_array($payment_info_query);

}

      $selection = array('id' => $this->code,
                         'module' => $this->title,
                         'description'=>$this->info,
      	                 'fields' => array(array('title' => MODULE_PAYMENT_SCHET_J_NAME_TITLE,
      	                                         'field' => MODULE_PAYMENT_SCHET_J_NAME_DESC),
      	                                   array('title' => MODULE_PAYMENT_SCHET_J_NAME,
      	                                         'field' => tep_draw_input_field('s_name',$payment_info['name']) . MODULE_PAYMENT_SCHET_J_NAME_IP),
//      	                                   array('title' => MODULE_PAYMENT_SCHET_J_INN,
//      	                                         'field' => tep_draw_input_field('s_inn',$payment_info['inn'])),
//      	                                   array('title' => MODULE_PAYMENT_SCHET_J_KPP,
//      	                                         'field' => tep_draw_input_field('s_kpp',$payment_info['kpp'])),
//      	                                   array('title' => MODULE_PAYMENT_SCHET_J_OGRN,
//      	                                         'field' => tep_draw_input_field('s_ogrn',$payment_info['ogrn'])),
//      	                                   array('title' => MODULE_PAYMENT_SCHET_J_OKPO,
//      	                                         'field' => tep_draw_input_field('s_okpo',$payment_info['okpo'])),
//      	                                   array('title' => MODULE_PAYMENT_SCHET_J_RS,
//      	                                         'field' => tep_draw_input_field('s_rs',$payment_info['rs'])),
//      	                                   array('title' => MODULE_PAYMENT_SCHET_J_BANK_NAME,
//      	                                         'field' => tep_draw_input_field('s_bank_name',$payment_info['bank_name']) . MODULE_PAYMENT_SCHET_J_BANK_NAME_HELP),
//      	                                   array('title' => MODULE_PAYMENT_SCHET_J_BIK,
//      	                                         'field' => tep_draw_input_field('s_bik',$payment_info['bik'])),
//      	                                   array('title' => MODULE_PAYMENT_SCHET_J_KS,
//      	                                         'field' => tep_draw_input_field('s_ks',$payment_info['ks'])),
//      	                                   array('title' => MODULE_PAYMENT_SCHET_J_ADDRESS,
//      	                                         'field' => tep_draw_input_field('s_address',$payment_info['address']) . MODULE_PAYMENT_SCHET_J_ADDRESS_HELP),
//      	                                   array('title' => MODULE_PAYMENT_SCHET_J_YUR_ADDRESS,
//      	                                         'field' => tep_draw_input_field('s_yur_address',$payment_info['yur_address'])),
//      	                                   array('title' => MODULE_PAYMENT_SCHET_J_FAKT_ADDRESS,
//      	                                         'field' => tep_draw_input_field('s_fakt_address',$payment_info['fakt_address'])),
      	                                   array('title' => MODULE_PAYMENT_SCHET_J_TELEPHONE,
      	                                         'field' => tep_draw_input_field('s_telephone', $order->customer['telephone']))
//      	                                   array('title' => MODULE_PAYMENT_SCHET_J_FAX,
//      	                                         'field' => tep_draw_input_field('s_fax',$payment_info['fax'])),
//      	                                   array('title' => MODULE_PAYMENT_SCHET_J_EMAIL,
//      	                                         'field' => tep_draw_input_field('s_email',$payment_info['email'])),
//      	                                   array('title' => MODULE_PAYMENT_SCHET_J_DIRECTOR,
//      	                                         'field' => tep_draw_input_field('s_director', $order->customer['firstname'] . ' ' . $order->customer['lastname'])),
//      	                                   array('title' => MODULE_PAYMENT_SCHET_J_ACCOUNTANT,
//      	                                         'field' => tep_draw_input_field('s_accountant',$payment_info['accountant']))
      	                                         
      	                                   ));

		return $selection;
      	                                   
	}

	function pre_confirmation_check() {

        $this->name = tep_db_prepare_input($_SESSION['s_name']);
        $this->inn = tep_db_prepare_input($_SESSION['s_inn']);
        $this->kpp = tep_db_prepare_input($_SESSION['s_kpp']);
        $this->ogrn = tep_db_prepare_input($_SESSION['s_ogrn']);
        $this->okpo = tep_db_prepare_input($_SESSION['s_okpo']);
        $this->rs = tep_db_prepare_input($_SESSION['s_rs']);
        $this->bank_name = tep_db_prepare_input($_SESSION['s_bank_name']);
        $this->bik = tep_db_prepare_input($_SESSION['s_bik']);
        $this->ks = tep_db_prepare_input($_SESSION['s_ks']);
        $this->address = tep_db_prepare_input($_SESSION['s_address']);
        $this->yur_address = tep_db_prepare_input($_SESSION['s_yur_address']);
        $this->fakt_address = tep_db_prepare_input($_SESSION['s_fakt_address']);
        $this->telephone = tep_db_prepare_input($_SESSION['s_telephone']);
        $this->fax = tep_db_prepare_input($_SESSION['s_fax']);
        $this->email = tep_db_prepare_input($_SESSION['s_email']);
        $this->director = tep_db_prepare_input($_SESSION['s_director']);
        $this->accountant = tep_db_prepare_input($_SESSION['s_accountant']);

	}

    function confirmation() {
      return array('title' => MODULE_PAYMENT_RUS_SCHET_TEXT_DESCRIPTION);
    }

	function process_button() {

      $process_button_string = tep_draw_hidden_field('s_name', $this->name) .
                               tep_draw_hidden_field('s_inn', $this->inn).
                               tep_draw_hidden_field('s_kpp', $this->kpp).
                               tep_draw_hidden_field('s_ogrn', $this->ogrn).
                               tep_draw_hidden_field('s_okpo', $this->okpo).
                               tep_draw_hidden_field('s_rs', $this->rs).
                               tep_draw_hidden_field('s_bank_name', $this->bank_name).
                               tep_draw_hidden_field('s_bik', $this->bik).
                               tep_draw_hidden_field('s_ks', $this->ks).
                               tep_draw_hidden_field('s_address', $this->address).
                               tep_draw_hidden_field('s_yur_address', $this->yur_address).
                               tep_draw_hidden_field('s_fakt_address', $this->fakt_address) .
                               tep_draw_hidden_field('s_telephone', $this->telephone) .
                               tep_draw_hidden_field('s_fax', $this->fax) .
                               tep_draw_hidden_field('s_email', $this->email) .
                               tep_draw_hidden_field('s_director', $this->director) .
                               tep_draw_hidden_field('s_accountant', $this->accountant);

      return $process_button_string;

	}

	function before_process() {

    	 $this->pre_confirmation_check();
    	return false;

	}

	function after_process() {

      global $insert_id, $name, $inn, $kpp, $ogrn, $okpo, $rs, $bank_name, $bik, $ks, $address, $yur_address, $fakt_address, $telephone, $fax, $email, $director, $accountant, $checkout_form_action, $checkout_form_submit;
      tep_db_query("INSERT INTO ".TABLE_COMPANIES." (orders_id, name, inn, kpp, ogrn, okpo, rs, bank_name, bik, ks, address, yur_address, fakt_address, telephone, fax, email, director, accountant) VALUES ('" . tep_db_prepare_input($insert_id) . "', '" . tep_db_prepare_input($_SESSION['s_name']) . "', '" . tep_db_prepare_input($_SESSION['s_inn']) . "', '" . tep_db_prepare_input($_SESSION['s_kpp']) . "', '" . tep_db_prepare_input($_SESSION['s_ogrn']) ."', '" . tep_db_prepare_input($_SESSION['s_okpo']) ."', '" . tep_db_prepare_input($_SESSION['s_rs']) ."', '" . tep_db_prepare_input($_SESSION['s_bank_name']) ."', '" . tep_db_prepare_input($_SESSION['s_bik']) ."', '" . tep_db_prepare_input($_SESSION['s_ks']) ."', '" . tep_db_prepare_input($_SESSION['s_address']) ."', '" . tep_db_prepare_input($_SESSION['s_yur_address']) ."', '" . tep_db_prepare_input($_SESSION['s_fakt_address']) ."', '" . tep_db_prepare_input($_SESSION['s_telephone']) ."', '" . tep_db_prepare_input($_SESSION['s_fax']) ."', '" . tep_db_prepare_input($_SESSION['s_email']) ."', '" . tep_db_prepare_input($_SESSION['s_director']) ."', '" . tep_db_prepare_input($_SESSION['s_accountant']) ."')");

	}

    function get_error() {
      return false;
    }

    function check() {
      if (!isset($this->check)) {
        $check_query = tep_db_query("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_PAYMENT_RUS_SCHET_STATUS'");
        $this->check = tep_db_num_rows($check_query);
      }
      return $this->check;
    }

    function install() {
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Разрешить модуль Предоплата на счёт', 'MODULE_PAYMENT_RUS_SCHET_STATUS', 'True', 'Вы хотите разрешить использование модуля при оформлении заказов?', '6', '1', 'tep_cfg_select_option(array(\'True\', \'False\'), ', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Название банка', 'MODULE_PAYMENT_RUS_SCHET_1', 'test', 'Введите название банка', '6', '1', now());");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Расчетный счет', 'MODULE_PAYMENT_RUS_SCHET_2', 'test', 'Введите Ваш расчетный счет', '6', '1', now());");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('БИК', 'MODULE_PAYMENT_RUS_SCHET_3', 'test', 'Введите Ваш БИК', '6', '1', now());");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Кор./счет', 'MODULE_PAYMENT_RUS_SCHET_4', 'test', 'Введите Ваш Кор./счет', '6', '1', now());");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('КПП', 'MODULE_PAYMENT_RUS_SCHET_5', 'test', 'Введите КПП', '6', '1', now());");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Получатель', 'MODULE_PAYMENT_RUS_SCHET_6', 'test', 'Получатель платежа', '6', '1', now());");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('ИНН', 'MODULE_PAYMENT_RUS_SCHET_7', 'test', 'Введите Ваш ИНН', '6', '1', now());");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Юридический адрес', 'MODULE_PAYMENT_RUS_SCHET_8', 'test', 'Введите Ваш юр. адрес', '6', '1', now());");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Руководитель', 'MODULE_PAYMENT_RUS_SCHET_9', 'test', 'Ф.И.О. руководителя', '6', '1', now());");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Порядок сортировки.', 'MODULE_PAYMENT_RUS_SCHET_SORT_ORDER', '0', 'Порядок сортировки модуля.', '6', '0', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) values ('Зона', 'MODULE_PAYMENT_RUS_SCHET_ZONE', '0', 'Если выбрана зона, то данный модуль оплаты будет виден только покупателям из выбранной зоны.', '6', '0', 'tep_get_zone_class_title', 'tep_cfg_pull_down_zone_classes(', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, use_function, date_added) values ('Статус заказа', 'MODULE_PAYMENT_RUS_SCHET_ORDER_STATUS_ID', '0', 'Заказы, оформленные с использованием данного модуля оплаты будут принимать указанный статус.', '6', '0', 'tep_cfg_pull_down_order_statuses(', 'tep_get_order_status_name', now())");
   }

    function remove() {
      tep_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }

    function keys() {
      return array('MODULE_PAYMENT_RUS_SCHET_STATUS', 'MODULE_PAYMENT_RUS_SCHET_1', 'MODULE_PAYMENT_RUS_SCHET_2', 'MODULE_PAYMENT_RUS_SCHET_3', 'MODULE_PAYMENT_RUS_SCHET_4', 'MODULE_PAYMENT_RUS_SCHET_5', 'MODULE_PAYMENT_RUS_SCHET_6', 'MODULE_PAYMENT_RUS_SCHET_7', 'MODULE_PAYMENT_RUS_SCHET_8', 'MODULE_PAYMENT_RUS_SCHET_9', 'MODULE_PAYMENT_RUS_SCHET_SORT_ORDER','MODULE_PAYMENT_RUS_SCHET_ZONE', 'MODULE_PAYMENT_RUS_SCHET_ORDER_STATUS_ID');
      return $keys;
    }
  }
?>