<?php
  class card {
    var $code, $title, $description, $enabled;

// class constructor
    function card() {
      $this->code = 'card';
      $this->title = MODULE_PAYMENT_CARD_TEXT_TITLE;
      $this->description = MODULE_PAYMENT_CARD_DESCRIPTION;
      $this->sort_order = MODULE_PAYMENT_CARD_SORT_ORDER;

      $this->enabled = ((MODULE_PAYMENT_CARD_STATUS == 'True') ? true : false);
//      $this->icon = DIR_WS_ICONS . 'kvitancia.png';

      if ((int)MODULE_PAYMENT_CARD_ORDER_STATUS_ID > 0) {
        $this->order_status = MODULE_PAYMENT_CARD_ORDER_STATUS_ID;
      }

      if (is_object($order)) $this->update_status();
    }

// class methods
    function update_status() {
      global $order;
      if ( ($this->enabled == true) && ((int)MODULE_PAYMENT_CARD_ZONE > 0) ) {
        $check_flag = false;
        $check_query = tep_db_query("select zone_id from " . TABLE_ZONES_TO_GEO_ZONES . " where geo_zone_id = '" . MODULE_PAYMENT_CARD_ZONE . "' and zone_country_id ='" . $order->delivery['country']['id'] . "' order by zone_id");
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
      if (tep_not_null($this->icon)) $icon = tep_image($this->icon, $this->title);
      $selection = array('id' => $this->code,
			'icon' => $icon,
//                	'module' => $this->CreateCardView(),
                	'module' => $this->title,
                        'description'=>$this->CreateCardView());
		return $selection;
	}

	function pre_confirmation_check() {
	}

    function CreateCardView($hide_some=false){
//	$view='<p>Реквизиты наших карт:<br></p>';
	$view=$this->title;
        if (strlen(MODULE_PAYMENT_CARD_NUMBER1)>0){
	    $view.='<p><span style="padding-left:20px;font-size:16px">'.
    		MODULE_PAYMENT_CARD_NUMBER1.'</span></p>';
		}
    return $view;
    }



function confirmation() {
      return array('title' =>$this->CreateCardView(),
    		    'display'=>$this->title);    	
//      return array('title' =>$this->title);    	
    }

	function process_button() { return false;}

	function before_process() {

    	 $this->pre_confirmation_check();
    	return false;

	}

	function after_process() {
	return false;
	}

    function get_error() {
      return false;
    }

    function check() {
      if (!isset($this->check)) {
        $check_query = tep_db_query("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_PAYMENT_CARD_STATUS'");
        $this->check = tep_db_num_rows($check_query);
      }
      return $this->check;
    }

    function install() {
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Разрешить модуль Оплата на карточку', 'MODULE_PAYMENT_CARD_STATUS', 'True', 'Вы хотите разрешить использование модуля при оформлении заказов?', '6', '1', 'tep_cfg_select_option(array(\'True\', \'False\'), ', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Порядок сортировки.', 'MODULE_PAYMENT_CARD_SORT_ORDER', '0', 'Порядок сортировки модуля.', '6', '2', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, use_function, date_added) values ('Статус заказа', 'MODULE_PAYMENT_CARD_ORDER_STATUS_ID', '0', 'Заказы, оформленные с использованием данного модуля оплаты будут принимать указанный статус.', '6', '3', 'tep_cfg_pull_down_order_statuses(', 'tep_get_order_status_name', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) values ('Зона', 'MODULE_PAYMENT_CARD_ZONE', '0', 'Если выбрана зона, то данный модуль оплаты будет виден только покупателям из выбранной зоны.', '6', '11', 'tep_get_zone_class_title', 'tep_cfg_pull_down_zone_classes(', now())");

/*    tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) 
	    values ('Название банка 1', 'MODULE_PAYMENT_CARD_BNAME1', '', 'Введите Название банка 1', '6', '11', now());");

      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) 
	    values ('Тип карты 1', 'MODULE_PAYMENT_CARD_TYPE1', '', 'Введите тип карты 1', '6', '12', now());");
*/
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) 
	    values ('Номер карты 1', 'MODULE_PAYMENT_CARD_NUMBER1', '', 'Введите номер карты 1', '6', '13', now());");
/*    tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) 
	    values ('ФИО на карте 1', 'MODULE_PAYMENT_CARD_FIO1', '', 'Введите ФИО на карте 1', '6', '14', now());");
*/
  }

    function remove() {
      tep_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }

    function keys() {
/*    return array('MODULE_PAYMENT_CARD_STATUS', 'MODULE_PAYMENT_CARD_ORDER_STATUS_ID', 'MODULE_PAYMENT_CARD_SORT_ORDER','MODULE_PAYMENT_CARD_ZONE',
	'MODULE_PAYMENT_CARD_BNAME1','MODULE_PAYMENT_CARD_TYPE1','MODULE_PAYMENT_CARD_NUMBER1','MODULE_PAYMENT_CARD_FIO1');*/
   return array('MODULE_PAYMENT_CARD_STATUS', 'MODULE_PAYMENT_CARD_ORDER_STATUS_ID', 'MODULE_PAYMENT_CARD_SORT_ORDER','MODULE_PAYMENT_CARD_ZONE',
	'MODULE_PAYMENT_CARD_NUMBER1');
	
    }
  }
?>