<?php
/*
  $Id: order.php,v 1.1.1.1 2003/09/18 19:03:49 wilt Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/

  class order {
    var $info, $totals, $products, $customer, $delivery,$statuses;

    function order($order_id) {
      $this->info = array();
      $this->totals = array();
      $this->products = array();
      $this->customer = array();
      $this->delivery = array();
        $this->statuses = array();

      $this->query($order_id);
    }

    function query($order_id) {
      $order_query = tep_db_query("select customers_name, customers_company, customers_street_address, customers_suburb, customers_city, customers_postcode, customers_state, customers_country, customers_telephone, customers_fax, customers_email_address, customers_address_format_id, delivery_name, delivery_company, delivery_street_address, delivery_suburb, delivery_city, delivery_postcode, delivery_state, delivery_country, delivery_address_format_id, billing_name, billing_company, billing_street_address, billing_suburb, billing_city, billing_postcode, billing_state, billing_country, billing_address_format_id,shipping_module, addon,payment_method, cc_type, cc_owner, cc_number, cc_expires, currency, currency_value, date_purchased, orders_status, last_modified, customers_referer_url,sber_order,orders_date_finished from " . TABLE_ORDERS . " where orders_id = '" . (int)$order_id . "'");
      $order = tep_db_fetch_array($order_query);
        $orders_status_query = tep_db_query("select orders_status_id, orders_status_name from " . TABLE_ORDERS_STATUS . " where 1 = 1");
        $orders_status_array = array();
        while ($orders_status = tep_db_fetch_array($orders_status_query)) {
            $orders_status_array[$orders_status['orders_status_id']] = $orders_status['orders_status_name'];
        }
        $totals_query = tep_db_query("select title, value, text from " . TABLE_ORDERS_TOTAL . " where orders_id = '" . (int)$order_id . "' order by sort_order");
      while ($totals = tep_db_fetch_array($totals_query)) {
        $this->totals[] = array('title' => $totals['title'],
                                'value' => $totals['value'],
                                'text' => $totals['text']);
      }
        $this->statuses = $orders_status_array;
      $this->info = array('currency' => $order['currency'],
                          'currency_value' => $order['currency_value'],
                          'payment_method' => $order['payment_method'],
                          'sber_order' => $order['sber_order'],
                          'addon' => $order['addon'],
                          'shipping_module' => $order['shipping_module'],
                          'cc_type' => $order['cc_type'],
                          'cc_owner' => $order['cc_owner'],
                          'cc_number' => $order['cc_number'],
                          'cc_expires' => $order['cc_expires'],
                          'date_purchased' => $order['date_purchased'],
                          'orders_status' => $order['orders_status'],
                          'last_modified' => $order['last_modified'],
                          'orders_date_finished' => $order['orders_date_finished'],
               			  'customers_referer_url' => $order['customers_referer_url']);

      $this->customer = array('name' => $order['customers_name'],
                              'company' => $order['customers_company'],
                              'street_address' => $order['customers_street_address'],
                              'suburb' => $order['customers_suburb'],
                              'city' => $order['customers_city'],
                              'postcode' => $order['customers_postcode'],
                              'state' => $order['customers_state'],
                              'country' => $order['customers_country'],
                              'format_id' => $order['customers_address_format_id'],
                              'telephone' => $order['customers_telephone'],
                              'fax' => $order['customers_fax'], 
                              'email_address' => $order['customers_email_address']);

      $this->delivery = array('name' => $order['delivery_name'],
                              'company' => $order['delivery_company'],
                              'street_address' => $order['delivery_street_address'],
                              'suburb' => $order['delivery_suburb'],
                              'city' => $order['delivery_city'],
                              'postcode' => $order['delivery_postcode'],
                              'state' => $order['delivery_state'],
                              'country' => $order['delivery_country'],
                              'format_id' => $order['delivery_address_format_id']);

      $this->billing = array('name' => $order['billing_name'],
                             'company' => $order['billing_company'],
                             'street_address' => $order['billing_street_address'],
                             'suburb' => $order['billing_suburb'],
                             'city' => $order['billing_city'],
                             'postcode' => $order['billing_postcode'],
                             'state' => $order['billing_state'],
                             'country' => $order['billing_country'],
                             'format_id' => $order['billing_address_format_id']);

      $index = 0;
      $orders_products_query = tep_db_query("select orders_products_id,products_id, products_name, products_model, products_price, products_tax, products_quantity, zakaz_price, products_id, final_price from " . TABLE_ORDERS_PRODUCTS . " where orders_id = '" . (int)$order_id . "'");
      while ($orders_products = tep_db_fetch_array($orders_products_query)) {
        $this->products[$index] = array('qty' => $orders_products['products_quantity'],
                                        'id' => $orders_products['products_id'],
                                        'name' => $orders_products['products_name'],
                                        'model' => $orders_products['products_model'],
                                        'tax' => $orders_products['products_tax'],
                                        'price' => $orders_products['products_price'],																				'zakaz_price' => $orders_products['zakaz_price'], 'products_id' => $orders_products['products_id'],
                                        'final_price' => $orders_products['final_price']);

        $subindex = 0;
        $attributes_query = tep_db_query("select products_options, products_options_values, options_values_price, price_prefix from " . TABLE_ORDERS_PRODUCTS_ATTRIBUTES . " where orders_id = '" . (int)$order_id . "' and orders_products_id = '" . (int)$orders_products['orders_products_id'] . "'");
        if (tep_db_num_rows($attributes_query)) {
          while ($attributes = tep_db_fetch_array($attributes_query)) {
            $this->products[$index]['attributes'][$subindex] = array('option' => $attributes['products_options'],
                                                                     'value' => $attributes['products_options_values'],
                                                                     'prefix' => $attributes['price_prefix'],
                                                                     'price' => $attributes['options_values_price']);

            $subindex++;
          }
        }
        $index++;
      }
    }
  }
?>
