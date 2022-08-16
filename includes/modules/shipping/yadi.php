<?php
/*
  $Id: yadi.php,v 1.1.1.1 2003/09/18 19:04:54 wilt Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/

  class yadi {
    var $code, $title, $description, $icon, $enabled;

// class constructor
    function yadi() {
      global $order;

      $this->code = 'yadi';
      $this->title = MODULE_SHIPPING_YADI_TEXT_TITLE;
      $this->description = MODULE_SHIPPING_YADI_TEXT_DESCRIPTION;
      $this->sort_order = MODULE_SHIPPING_YADI_SORT_ORDER;
      $this->icon = '';
      $this->tax_class = MODULE_SHIPPING_YADI_TAX_CLASS;
      $this->enabled = ((MODULE_SHIPPING_YADI_STATUS == 'True') ? true : false);
      $this->ids=json_decode(MODULE_SHIPPING_YADI_API);
      $this->keys=json_decode(MODULE_SHIPPING_YADI_KEYS);
      $this->enabled=is_object($this->ids)&&is_object($this->keys);
      $this->script='<script type="text/javascript" src="https://api-maps.yandex.ru/2.1/?lang=ru-RU"></script>
      <script src="https://delivery.yandex.ru/widget/loader?resource_id='.
      $this->ids->client->id.'&sid='.
      $this->ids->senders[0]->id.'&key=3341b21ced4cb164e34e85215f99b34e"></script>';
      if (file_exists(DIR_WS_JAVASCRIPT.'yadi.js')){
        $this->script.=file_get_contents(DIR_WS_JAVASCRIPT.'yadi.js');
        }
//      $this->script.='<script type="text/javascript" src="'.DIR_WS_JAVASCRIPT.'yadi.js"></script>';
      $this->id=$this->ids->client->id;
      
      if ( ($this->enabled == true) && ((int)MODULE_SHIPPING_YADI_ZONE > 0) ) {
        $check_flag = false;
        $check_query = tep_db_query("select zone_id from " . TABLE_ZONES_TO_GEO_ZONES . " where geo_zone_id = '" . MODULE_SHIPPING_YADI_ZONE . "' and zone_country_id = '" . $order->delivery['country']['id'] . "' order by zone_id");
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
      global $order;
//---modified by iHolder
     $cost=MODULE_SHIPPING_YADI_COST;
//---modified by iHolder
      $this->quotes = array('id' => $this->code,
                            'module' => MODULE_SHIPPING_YADI_TEXT_TITLE,
                            'methods' => array(array('id' => $this->code,
                                                     'title' => MODULE_SHIPPING_YADI_TEXT_WAY.$this->script,
                                                     'cost' => $cost)));

      if ($this->tax_class > 0) {
        $this->quotes['tax'] = tep_get_tax_rate($this->tax_class, $order->delivery['country']['id'], $order->delivery['zone_id']);
      }

      if (tep_not_null($this->icon)) $this->quotes['icon'] = tep_image($this->icon, $this->title);

      return $this->quotes;
    }

    function check() {
      if (!isset($this->_check)) {
        $check_query = tep_db_query("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_SHIPPING_YADI_STATUS'");
        $this->_check = tep_db_num_rows($check_query);
      }
      return $this->_check;
    }

    function install() {
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Разрешить модуль курьерская доставка', 'MODULE_SHIPPING_YADI_STATUS', 'True', 'Вы хотите разрешить модуль Yandex delivery?', '6', '0', 'tep_cfg_select_option(array(\'True\', \'False\'), ', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Стоимость', 'MODULE_SHIPPING_YADI_COST', '5.00', 'Стоимость использования данного способа доставки по-умолчанию.', '6', '0', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) values ('Налог', 'MODULE_SHIPPING_YADI_TAX_CLASS', '0', 'Использовать налог.', '6', '0', 'tep_get_tax_class_title', 'tep_cfg_pull_down_tax_classes(', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) values ('Зона', 'MODULE_SHIPPING_YADI_ZONE', '0', 'Если выбрана зона, то данный модуль доставки будет виден только покупателям из выбранной зоны.', '6', '0', 'tep_get_zone_class_title', 'tep_cfg_pull_down_zone_classes(', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Порядок сортировки', 'MODULE_SHIPPING_YADI_SORT_ORDER', '0', 'Порядок сортировки модуля.', '6', '0', now())");

      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('API ids(JSON)', 'MODULE_SHIPPING_YADI_API', '', 'Yandex Delivery ids.', '6', '0', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('API keys(JSON)', 'MODULE_SHIPPING_YADI_KEYS', '', 'Yandex delivery keys.', '6', '0', now())");

    }

    function remove() {
      tep_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }

    function keys() {
      return array('MODULE_SHIPPING_YADI_STATUS', 
      'MODULE_SHIPPING_YADI_COST', 
      'MODULE_SHIPPING_YADI_TAX_CLASS', 
      'MODULE_SHIPPING_YADI_ZONE', 
      'MODULE_SHIPPING_YADI_SORT_ORDER',
      'MODULE_SHIPPING_YADI_API',
      'MODULE_SHIPPING_YADI_KEYS'
      );
    }
  }
?>
