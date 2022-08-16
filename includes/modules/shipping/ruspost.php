<?php
/*
  $Id: ruspost.php,v 1.40 2007/11/04 8:41:52 hpdl Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2007 osCommerce

  Released under the GNU General Public License
  edit:  Fomin Maksim  maxx-fomin@mail.ru
  Вычисление стоимости отправления по индексу, весу и стоимости отправления
  Индексы поделены в группы из пяти зон доставки , куда цены на отправку одинаковые.
  В администрировании можно сменить цены для каждой из зоны.
  по умолчанию взяты реальные цены http://www.russianpost.ru
*/

  class ruspost {
    var $code, $title, $description, $icon, $enabled;

// class constructor
    function ruspost() {
      global $order;

      $this->code = 'ruspost';
      $this->title = MODULE_SHIPPING_RUS_POST_TEXT_TITLE;
      $this->description = MODULE_SHIPPING_RUS_POST_TEXT_DESCRIPTION;
      $this->sort_order = MODULE_SHIPPING_RUS_POST_SORT_ORDER;
      $this->icon = '';
      $this->tax_class = MODULE_SHIPPING_RUS_POST_TAX_CLASS;
      $this->enabled = ((MODULE_SHIPPING_RUS_POST_STATUS == 'True') ? true : false);

      if ( ($this->enabled == true) && ((int)MODULE_SHIPPING_RUS_POST_ZONE > 0) ) {
        $check_flag = false;
        $check_query = tep_db_query("select zone_id from " . TABLE_ZONES_TO_GEO_ZONES . " where geo_zone_id = '" . MODULE_SHIPPING_RUS_POST_ZONE . "' and zone_country_id = '" . $order->delivery['country']['id'] . "' order by zone_id");
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

    /////////////////////////////////////////////////////////////////////////////////////////////////////////
       for ($i=0, $n=sizeof($order->products); $i<$n; $i++) {       //вычисление общего веса посылки
       $weight=$weight+$order->products[$i]['qty']*$order->products[$i]['weight'];

   }
   ///////////////////////////////////////////////////////////////////////////////////////////////////////////
        //$order->customer['postcode']; //инфо о клиенте
        $tax_zone_query = tep_db_query("select tax_zone_id, low, high, mono from post_index where low <='" . $order->customer['postcode'] ."'AND high >='" . $order->customer['postcode'] ."' OR  mono = '" . $order->customer['postcode'] ."'");
        $tax_zone = tep_db_fetch_array($tax_zone_query);
        $tax_zone_id = $tax_zone['tax_zone_id'];        //тарифная зона

       if($tax_zone_id==1&&$weight<=1000&&$order->info['subtotal']<="1000"){$tax_prise=ONE_1000_COST;}
        else if($tax_zone_id==1&&$weight<=2000&&$order->info['subtotal']<="2000"){$tax_prise=ONE_2000_COST;}
         else if($tax_zone_id==1&&$weight<=2000&&$order->info['subtotal']<="3500"){$tax_prise=ONE_3500_COST;}

       if($tax_zone_id==4&&$weight<=1000&&$order->info['subtotal']<="1000"){$tax_prise=TWO_1000_COST;}
        else if($tax_zone_id==4&&$weight<=2000&&$order->info['subtotal']<="2000"){$tax_prise=TWO_2000_COST;}       // вычисление стоимости доставки
         else if($tax_zone_id==4&&$weight<=2000&&$order->info['subtotal']<="3500"){$tax_prise=TWO_3500_COST;}      //по номеру зоны  весу и стоимости

       if($tax_zone_id==5&&$weight<=1000&&$order->info['subtotal']<="1000"){$tax_prise=THRE_1000_COST;}
        else if($tax_zone_id==5&&$weight<=2000&&$order->info['subtotal']<="2000"){$tax_prise=THRE_2000_COST;}
         else if($tax_zone_id==5&&$weight<=2000&&$order->info['subtotal']<="3500"){$tax_prise=THRE_3500_COST;}


      /////////////////////////////////////////////////////////////////////////////////////////////////////////


      $this->quotes = array('id' => $this->code,
                            'module' => MODULE_SHIPPING_RUS_POST_TEXT_TITLE,
                            'methods' => array(array('id' => $this->code,
                                                     'title' => MODULE_SHIPPING_RUS_POST_TEXT_WAY,
                                                     'cost' => $tax_prise)));

      if ($this->tax_class > 0) {
        $this->quotes['tax'] = tep_get_tax_rate($this->tax_class, $order->delivery['country']['id'], $order->delivery['zone_id']);
      }

      if (tep_not_null($this->icon)) $this->quotes['icon'] = tep_image($this->icon, $this->title);

      return $this->quotes;
    }

    function check() {
      if (!isset($this->_check)) {
        $check_query = tep_db_query("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_SHIPPING_RUS_POST_STATUS'");
        $this->_check = tep_db_num_rows($check_query);
      }
      return $this->_check;
    }

    function install() {
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Enable Russian Post Shipping', 'MODULE_SHIPPING_RUS_POST_STATUS', 'True', 'Do you want to offer russian post shipping?', '6', '0', 'tep_cfg_select_option(array(\'True\', \'False\'), ', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Zone 1: <1000 rur', 'ONE_1000_COST', '130', '', '6', '0', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Zone 1: <2000 rur', 'ONE_2000_COST', '170', '', '6', '0', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Zone 1: <3500 rur', 'ONE_3500_COST', '250', '', '6', '0', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Zone 4: <1000 rur', 'TWO_1000_COST', '170', '', '6', '0', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Zone 4: <2000 rur', 'TWO_2000_COST', '200', '', '6', '0', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Zone 4: <3500 rur', 'TWO_3500_COST', '300', '', '6', '0', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Zone 5: <1000 rur', 'THRE_1000_COST', '190', '', '6', '0', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Zone 5: <2000 rur', 'THRE_2000_COST', '220', '', '6', '0', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Zone 5: <3500 rur', 'THRE_3500_COST', '320', '', '6', '0', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) values ('Налог', 'MODULE_SHIPPING_RUS_POST_TAX_CLASS', '0', 'Использовать налог.', '6', '0', 'tep_get_tax_class_title', 'tep_cfg_pull_down_tax_classes(', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) values ('Зона', 'MODULE_SHIPPING_RUS_POST_ZONE', '0', 'Если выбрана зона, то данный модуль доставки будет виден только покупателям из выбранной зоны.', '6', '0', 'tep_get_zone_class_title', 'tep_cfg_pull_down_zone_classes(', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Порядок сортировки', 'MODULE_SHIPPING_RUS_POST_SORT_ORDER', '0', 'Порядок сортировки модуля.', '6', '0', now())");

    }

    function remove() {
      tep_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }

    function keys() {
      return array('MODULE_SHIPPING_RUS_POST_STATUS', 'ONE_1000_COST','ONE_2000_COST','ONE_3500_COST','TWO_1000_COST','TWO_2000_COST','TWO_3500_COST','THRE_1000_COST','THRE_2000_COST','THRE_3500_COST', 'MODULE_SHIPPING_RUS_POST_TAX_CLASS', 'MODULE_SHIPPING_RUS_POST_ZONE', 'MODULE_SHIPPING_RUS_POST_SORT_ORDER');
    }
  }
?>
