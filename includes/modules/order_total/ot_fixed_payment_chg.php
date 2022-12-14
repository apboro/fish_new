<?php
/*
  $Id: ot_fixed_payment_chg.php,v 1.8 2006/04/12 13:47:12 wilt Exp $

    osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2002 osCommerce

  Released under the GNU General Public License
*/

  class ot_fixed_payment_chg {
    var $title, $output;

    function ot_fixed_payment_chg() {
      global $payment;

      $this->code = 'ot_fixed_payment_chg';
      $this->title = MODULE_FIXED_PAYMENT_CHG_TITLE;
      $this->description = MODULE_FIXED_PAYMENT_CHG_DESCRIPTION;
      // bol ct: dynamic title/description of fee
      if (isset($payment)) {
        $table = split("[:,]" , MODULE_FIXED_PAYMENT_CHG_TYPE_DESCRIPTION);
        for ($i = 0; $i < count($table); $i+=2) {
          if ($payment == $table[$i]) {
            $this->title = $table[$i+1];
            $this->description = $table[$i+1];
          }
        }
      }
      // eol ct: dynamic title/description of fee
      $this->enabled = MODULE_FIXED_PAYMENT_CHG_STATUS;
      $this->sort_order = MODULE_FIXED_PAYMENT_CHG_SORT_ORDER;
      $this->type = MODULE_FIXED_PAYMENT_CHG_TYPE;
      $this->tax_class = MODULE_FIXED_PAYMENT_CHG_TAX_CLASS;
      $this->output = array();
    }

    function process() {
      global $order, $ot_subtotal, $currencies;

      $od_amount = $this->calculate_charge($this->get_order_total());
      if ($od_amount != 0) {
        $this->deduction = $od_amount;
        $this->output[] = array('title' => $this->title . ':',
                                'text' => $currencies->format($od_amount),
                                'value' => $od_amount);
	      $order->info['total'] = $order->info['total'] - $od_amount;
        if ($this->sort_order < $ot_subtotal->sort_order) {
          $order->info['subtotal'] = $order->info['subtotal'] - $od_amount;
        }
      }
    }

    function calculate_charge($amount) {
      global $order, $customer_id, $payment;
      $od_amount=0;
      $table = split("[:,]" , MODULE_FIXED_PAYMENT_CHG_TYPE);
      for ($i = 0; $i < count($table); $i+=3) {
        if ($payment == $table[$i]) {
		  $od_am_fixed=$table[$i+1];
		  $od_am_percentage=$table[$i+2];

          // use either a fixed amount or percentage of total incl. shipping
          if (substr($od_am_percentage,0,1) == '%') {
            $od_am_percentage=substr($od_am_percentage, 1);
            $od_am_percentage=round($amount/100*$od_am_percentage,2); // choose the decimal position for rounding
			$table[$i+2]=$od_am_percentage;
          }

          if (MODULE_FIXED_PAYMENT_CHG_TAX_CLASS > 0) {
            $tod_rate = tep_get_tax_rate(MODULE_FIXED_PAYMENT_CHG_TAX_CLASS);
            $tod_description = tep_get_tax_description(MODULE_FIXED_PAYMENT_CHG_TAX_CLASS, $order->delivery['country']['id'], $order->delivery['zone_id']);
            $tod_amount =  tep_calculate_tax($od_am_fixed + $od_am_percentage, $tod_rate);
            $order->info['tax'] += $tod_amount;
            $order->info['tax_groups'][$tod_description] += tep_calculate_tax($table[$i+1] + $table[$i+2], $tod_rate);
          }

          if (DISPLAY_PRICE_WITH_TAX) { 
            $od_amount = $od_am_fixed + $od_am_percentage + $tod_amount;
          } else {       
            $od_amount = $od_am_fixed + $od_am_percentage;
            $order->info['total'] += $tod_amount;
          }
        }
      }
      return $od_amount;
    }

    function get_order_total() {
      global  $order, $cart;
      $order_total = $order->info['total'];
      // Check if gift voucher is in cart and adjust total
      $products = $cart->get_products();
      for ($i=0; $i<sizeof($products); $i++) {
        $t_prid = tep_get_prid($products[$i]['id']);
        $gv_query = tep_db_query("select products_price, products_tax_class_id, products_model from " . TABLE_PRODUCTS . " where products_id = '" . $t_prid . "'");
        $gv_result = tep_db_fetch_array($gv_query);
        if (ereg('^GIFT', addslashes($gv_result['products_model']))) { 
          $qty = $cart->get_quantity($t_prid);
          $products_tax = tep_get_tax_rate($gv_result['products_tax_class_id']);
          if ($this->include_tax =='false') {
            $gv_amount = $gv_result['products_price'] * $qty;
          } else {
            $gv_amount = ($gv_result['products_price'] + tep_calculate_tax($gv_result['products_price'],$products_tax)) * $qty;
          }
          $order_total=$order_total - $gv_amount;
        }
      }
      if ($this->include_tax == 'false') $order_total=$order_total-$order->info['tax'];
      if ($this->include_shipping == 'false') $order_total=$order_total-$order->info['shipping_cost'];
      return $order_total;
    }

    function check() {
      if (!isset($this->check)) {
        $check_query = tep_db_query("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_FIXED_PAYMENT_CHG_STATUS'");
        $this->check = tep_db_num_rows($check_query);
      }

      return $this->check;
    }

    function keys() {
      return array('MODULE_FIXED_PAYMENT_CHG_STATUS', 'MODULE_FIXED_PAYMENT_CHG_SORT_ORDER', 'MODULE_FIXED_PAYMENT_CHG_TYPE', 'MODULE_FIXED_PAYMENT_CHG_TYPE_DESCRIPTION', 'MODULE_FIXED_PAYMENT_CHG_TAX_CLASS');
    }

    function install() {
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Display Total', 'MODULE_FIXED_PAYMENT_CHG_STATUS', 'true', 'Do you want to display the payment charge', '6', '1','tep_cfg_select_option(array(\'true\', \'false\'), ', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Sort Order', 'MODULE_FIXED_PAYMENT_CHG_SORT_ORDER', '10', 'Sort order of display.', '6', '2', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Payment Type', 'MODULE_FIXED_PAYMENT_CHG_TYPE', 'moneyorder:5:%0,cod:50:%10', 'Payment Types to get charge', '6', '2', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Payment Type Description', 'MODULE_FIXED_PAYMENT_CHG_TYPE_DESCRIPTION', 'moneyorder:Fee for Money Order,cod:Fee for Cash on Delivery', 'Description for each payment type.', '6', '3', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) values ('Tax Class', 'MODULE_FIXED_PAYMENT_CHG_TAX_CLASS', '0', 'Use the following tax class on the payment charge.', '6', '6', 'tep_get_tax_class_title', 'tep_cfg_pull_down_tax_classes(', now())");
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
	
    // function to display payment cost in checkout_payment..php page
    function get_payment_cost($pay_type) {
      $od_amount=0;
      $table = split("[:,]" , MODULE_FIXED_PAYMENT_CHG_TYPE);
      for ($i = 0; $i < count($table); $i+=3) {
        if ($pay_type == $table[$i]) {
          $od_am=$table[$i+1];
          if (MODULE_FIXED_PAYMENT_CHG_TAX_CLASS > 0) {
            $tod_rate = tep_get_tax_rate(MODULE_FIXED_PAYMENT_CHG_TAX_CLASS);
            $tod_amount =  tep_calculate_tax($table[$i+1], $tod_rate);
          }
          if (DISPLAY_PRICE_WITH_TAX=="true") { 
            $od_amount = $od_am + $tod_amount;
          } else {       
            $od_amount = $od_am;
          }
        }
      }
      return $od_amount;
    }
  }
?>