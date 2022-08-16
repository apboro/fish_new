<?php
/*
  $Id: ot_qty_discount.php,v 1.2 2002/07/22 07:36:01 amk Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2002 osCommerce

  Released under the GNU General Public License
*/

  class ot_qty_discount {
    var $title, $output;

    function ot_qty_discount() {
      $this->code = 'ot_qty_discount';
      $this->title = MODULE_QTY_DISCOUNT_TITLE;
      $this->description = MODULE_QTY_DISCOUNT_DESCRIPTION;
      $this->enabled = MODULE_QTY_DISCOUNT_STATUS;
      $this->sort_order = MODULE_QTY_DISCOUNT_SORT_ORDER;
      $this->include_shipping = MODULE_QTY_DISCOUNT_INC_SHIPPING;
      $this->include_tax = MODULE_QTY_DISCOUNT_INC_TAX;
      $this->calculate_tax = MODULE_QTY_DISCOUNT_CALC_TAX;
      $this->output = array();
    }

        function process()
        {
                global $order, $currencies, $cart, $ot_subtotal;     
                if ($this->calculate_tax == 'true') {
                    $tod_amount = $this->calculate_discount($order->info['tax']);
                }
                $od_amount = $this->calculate_discount($this->get_order_total());
                if ($od_amount>0)
                {
 				    if (MODULE_QTY_DISCOUNT_RATE_TYPE == 'percentage') $title_ext = ' ('.$this->calculate_rate($cart->count_contents()).'%)';
					    $this->deduction = $od_amount+$tod_amount;
                        $this->output[] = array('title' => $this->title . ':',
                                                'text' => '<b>-' . $currencies->format($od_amount) . '</b>',
                                                'value' => $od_amount);
                        $order->info['total'] = $order->info['total'] - $od_amount - $tod_amount;
				    if ($this->sort_order < $ot_subtotal->sort_order) {
					    $order->info['subtotal'] = $order->info['subtotal'] - $od_amount - $tod_amount;
				    }
                        $order->info['tax'] = $order->info['tax'] - $tod_amount;
                }
        }

  function calculate_discount($amount) {
    global $qty_discount, $order_qty, $cart;

    $order_qty = $cart->count_contents();
    $od_amount=0;

	$qty_discount = $this->calculate_rate($order_qty);
    if ($qty_discount > 0) {
	  if (MODULE_QTY_DISCOUNT_RATE_TYPE == 'percentage') {
      $od_amount = (round($amount*10)/10)*($qty_discount/100);
	  } else {
      $od_amount = (round($qty_discount*10)/10);
	  }
    }
    return $od_amount;
  }
  
  function calculate_rate($order_qty) {
	  $discount_rate = preg_split("/[:,]/" , MODULE_QTY_DISCOUNT_RATES);
      $size = sizeof($discount_rate);
      for ($i=0, $n=$size; $i<$n; $i+=2) {
        if ($order_qty >= $discount_rate[$i]) {
          $qty_discount = $discount_rate[$i+1];
        }
      }
    return $qty_discount;
  }


  function get_order_total() {
    global  $order;
    $order_total = $order->info['total'];
    if ($this->include_tax == 'false') $order_total=$order_total-$order->info['tax'];
    if ($this->include_shipping == 'false') $order_total=$order_total-$order->info['shipping_cost'];
    return $order_total;
  }   
    
    function check() {
      if (!isset($this->check)) {
        $check_query = tep_db_query("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_QTY_DISCOUNT_STATUS'");
        $this->check = tep_db_num_rows($check_query);
      }

      return $this->check;
    }

    function keys() {
      return array('MODULE_QTY_DISCOUNT_STATUS', 'MODULE_QTY_DISCOUNT_SORT_ORDER', 'MODULE_QTY_DISCOUNT_RATE_TYPE', 'MODULE_QTY_DISCOUNT_RATES', 'MODULE_QTY_DISCOUNT_INC_SHIPPING', 'MODULE_QTY_DISCOUNT_INC_TAX', 'MODULE_QTY_DISCOUNT_CALC_TAX');
    }

    function install() {
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Показывать скидку от количества', 'MODULE_QTY_DISCOUNT_STATUS', 'true', 'Вы хотите разрешить скидки от количества?', '6', '1','tep_cfg_select_option(array(\'true\', \'false\'), ', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Порядок сортировки', 'MODULE_QTY_DISCOUNT_SORT_ORDER', '999', 'Порядок сортировки модуля.', '6', '2', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function ,date_added) values ('Тип скидки', 'MODULE_QTY_DISCOUNT_RATE_TYPE', 'percentage', 'Выберите тип скидки - процентная (percentage) или плоская (flat rate)', '6', '3','tep_cfg_select_option(array(\'percentage\', \'flat rate\'), ', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Скидка', 'MODULE_QTY_DISCOUNT_RATES', '10:5,20:10', 'Скидка считается исходя из общего количества заказанных единиц товара. Например: 10:5,20:10... и т.д. Это значит, что заказав 10 или более единиц товара, покупатель получает скидку 5% или $5; 20 или более единиц - скидка 10% или $10; в зависимости от типа скидки.', '6', '4', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function ,date_added) values ('Учитывать доставку', 'MODULE_QTY_DISCOUNT_INC_SHIPPING', 'false', 'Включать в расчёт доставку.', '6', '5', 'tep_cfg_select_option(array(\'true\', \'false\'), ', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function ,date_added) values ('Учитывать налог', 'MODULE_QTY_DISCOUNT_INC_TAX', 'false', 'Включать в расчёт налог.', '6', '6','tep_cfg_select_option(array(\'true\', \'false\'), ', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function ,date_added) values ('Пересчитывать налог', 'MODULE_QTY_DISCOUNT_CALC_TAX', 'true', 'Пересчитывать налог.', '6', '5','tep_cfg_select_option(array(\'true\', \'false\'), ', now())");
    }

    function remove() {
      $keys = '';
      $keys_array = $this->keys();
      for ($i=0; $i<sizeof($keys_array); $i++) {
        $keys .= "'" . $keys_array[$i] . "',";
      }
      $keys = substr($keys, 0, -1);

      tep_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key in (" . $keys . ")");
    }
  }
?>