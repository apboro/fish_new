<?php
/*
  $Id: flat.php,v 1.1.1.1 2003/09/18 19:04:54 wilt Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/

  class flat {
    var $code, $title, $description, $icon, $enabled;

// class constructor
    function flat() {
      global $order;

      $this->code = 'flat';
      $this->title = MODULE_SHIPPING_FLAT_TEXT_TITLE;
      $this->description = MODULE_SHIPPING_FLAT_TEXT_DESCRIPTION;
      $this->sort_order = MODULE_SHIPPING_FLAT_SORT_ORDER;
      $this->icon = '';
      $this->tax_class = MODULE_SHIPPING_FLAT_TAX_CLASS;
      $this->enabled = ((MODULE_SHIPPING_FLAT_STATUS == 'True') ? true : false);
      if ($order->info['subtotal']<1){$this->enabled=false;return;}

      if ( ($this->enabled == true) && ((int)MODULE_SHIPPING_FLAT_ZONE > 0) ) {
        $check_flag = false;
        $check_query = tep_db_query("select zone_id from " . TABLE_ZONES_TO_GEO_ZONES . " where geo_zone_id = '" . MODULE_SHIPPING_FLAT_ZONE . "' and zone_country_id = '" . $order->delivery['country']['id'] . "' order by zone_id");
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
     $cost=MODULE_SHIPPING_FLAT_COST;
   
     for ($i=0; $i<20; $i++) {  //($i=0, $n=count($order->$products); $i<$n; $i++) {
         $weightsum += $order->products[$i]['weight'];//+$order->products[1]['weight'];
		 }
 

     if ($order->info['subtotal']<2999)
     {$cost=350;}
     if (($order->info['subtotal']>2999) and ($order->info['subtotal']<4999))
     {$cost=250;}
     if ($order->info['subtotal']>4999)
     {$cost=150;}
     
   if ($weightsum>3000){$cost=500;}
   
//---modified by iHolder
      $this->quotes = array('id' => $this->code,
                            'module' => MODULE_SHIPPING_FLAT_TEXT_TITLE,
                            'methods' => array(array('id' => $this->code,
                                                     'title' => MODULE_SHIPPING_FLAT_TEXT_WAY,
                                                     
                                                     'cost' => $cost)));

      if ($this->tax_class > 0) {
        $this->quotes['tax'] = tep_get_tax_rate($this->tax_class, $order->delivery['country']['id'], $order->delivery['zone_id']);
      }

      if (tep_not_null($this->icon)) $this->quotes['icon'] = tep_image($this->icon, $this->title);

      return $this->quotes;
    }

    function check() {
      if (!isset($this->_check)) {
        $check_query = tep_db_query("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_SHIPPING_FLAT_STATUS'");
        $this->_check = tep_db_num_rows($check_query);
      }
      return $this->_check;
    }

    function install() {
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Разрешить модуль курьерская доставка', 'MODULE_SHIPPING_FLAT_STATUS', 'True', 'Вы хотите разрешить модуль курьерская доставка?', '6', '0', 'tep_cfg_select_option(array(\'True\', \'False\'), ', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Стоимость', 'MODULE_SHIPPING_FLAT_COST', '5.00', 'Стоимость использования данного способа доставки.', '6', '0', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) values ('Налог', 'MODULE_SHIPPING_FLAT_TAX_CLASS', '0', 'Использовать налог.', '6', '0', 'tep_get_tax_class_title', 'tep_cfg_pull_down_tax_classes(', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) values ('Зона', 'MODULE_SHIPPING_FLAT_ZONE', '0', 'Если выбрана зона, то данный модуль доставки будет виден только покупателям из выбранной зоны.', '6', '0', 'tep_get_zone_class_title', 'tep_cfg_pull_down_zone_classes(', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Порядок сортировки', 'MODULE_SHIPPING_FLAT_SORT_ORDER', '0', 'Порядок сортировки модуля.', '6', '0', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Бесплатная доставка свыше:', 'MODULE_SHIPPING_FLAT_FREE', '5000.00', 'Бесплатная доставка свыше суммы', '6', '0', now())");
    }

    function remove() {
      tep_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }

    function keys() {
      return array('MODULE_SHIPPING_FLAT_STATUS', 'MODULE_SHIPPING_FLAT_COST', 'MODULE_SHIPPING_FLAT_TAX_CLASS', 'MODULE_SHIPPING_FLAT_ZONE', 'MODULE_SHIPPING_FLAT_SORT_ORDER','MODULE_SHIPPING_FLAT_FREE');
    }
  }
?>
