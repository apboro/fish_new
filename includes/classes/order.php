<?php
/*
  $Id: order.php,v 1.1.1.1 2003/09/18 19:05:14 wilt Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/

class order {
    var $info, $totals, $products, $customer, $delivery, $content_type;

    function order($order_id = '') {
        $this->info = array();
        $this->totals = array();
        $this->products = array();
        $this->customer = array();
        $this->delivery = array();

// SMART CHECKOUT BOF
        if (tep_session_is_registered('noaccount')) {
            $this->cart_noaccount();
        } elseif (tep_not_null($order_id)) {
            $this->query($order_id);
        } else {
            $this->cart();
        }
    }
// SMART CHECKOUT EOF

    function query($order_id) {
        global $languages_id;

        $order_id = tep_db_prepare_input($order_id);

        $order_query = tep_db_query("select customers_id, customers_groups_id, customers_name, customers_company, customers_street_address, customers_suburb, customers_city, customers_postcode, customers_state, customers_country, customers_telephone, customers_fax, customers_email_address, customers_address_format_id, delivery_name, delivery_company, delivery_street_address, delivery_suburb, delivery_city, delivery_postcode, delivery_state, delivery_country, delivery_address_format_id, billing_name, billing_company, billing_street_address, billing_suburb, billing_city, billing_postcode, billing_state, billing_country, billing_address_format_id, payment_method, cc_type, cc_owner, cc_number, cc_expires, currency, currency_value, date_purchased, orders_status, last_modified,sber_order,meta from " . TABLE_ORDERS . " where orders_id = '" . (int)$order_id . "'");
        $order = tep_db_fetch_array($order_query);

        $totals_query = tep_db_query("select title, text from " . TABLE_ORDERS_TOTAL . " where orders_id = '" . (int)$order_id . "' order by sort_order");
        while ($totals = tep_db_fetch_array($totals_query)) {
            $this->totals[] = array('title' => $totals['title'],
                'text' => $totals['text']);
        }

        $order_total_query = tep_db_query("select text, value from " . TABLE_ORDERS_TOTAL . " where orders_id = '" . (int)$order_id . "' and class = 'ot_total'");
        $order_total = tep_db_fetch_array($order_total_query);

        $shipping_method_query = tep_db_query("select title from " . TABLE_ORDERS_TOTAL . " where orders_id = '" . (int)$order_id . "' and class = 'ot_shipping'");
        $shipping_method = tep_db_fetch_array($shipping_method_query);

        $order_status_query = tep_db_query("select orders_status_name from " . TABLE_ORDERS_STATUS . " where orders_status_id = '" . $order['orders_status'] . "' and language_id = '" . (int)$languages_id . "'");
        $order_status = tep_db_fetch_array($order_status_query);

        $this->info = array('currency' => $order['currency'],
            'currency_value' => $order['currency_value'],
            'payment_method' => $order['payment_method'],
            'sber_order' => $order['sber_order'],
            'cc_type' => $order['cc_type'],
            'cc_owner' => $order['cc_owner'],
            'cc_number' => $order['cc_number'],
            'cc_expires' => $order['cc_expires'],
            'date_purchased' => $order['date_purchased'],
            'orders_status' => $order_status['orders_status_name'],
            'last_modified' => $order['last_modified'],
            'total' => strip_tags($order_total['text']),
            'value' => $order_total['value'],
            'shipping_method' => ((substr($shipping_method['title'], -1) == ':') ? substr(strip_tags($shipping_method['title']), 0, -1) : strip_tags($shipping_method['title'])));

        $this->customer = array('id' => $order['customers_id'],
//KIKOLEPPARD add for color groups start
            'group_id' => $order['customers_groups_id'],
//KIKOLEPPARD add for color groups end
            'name' => $order['customers_name'],
            'company' => $order['customers_company'],
            'street_address' => $order['customers_street_address'],
            'suburb' => $order['customers_suburb'],
            'city' => $order['customers_city'],
            'postcode' => $order['customers_postcode'],
            'state' => $order['customers_state'],
            'country' => array('title' => $order['customers_country']),
            'format_id' => $order['customers_address_format_id'],
            'telephone' => $order['customers_telephone'],
            'fax' => $order['customers_fax'],
            'email_address' => $order['customers_email_address']);

        $this->delivery = array('name' => trim($order['delivery_name']),
            'company' => $order['delivery_company'],
            'street_address' => $order['delivery_street_address'],
            'suburb' => $order['delivery_suburb'],
            'city' => $order['delivery_city'],
            'postcode' => $order['delivery_postcode'],
            'state' => $order['delivery_state'],
            'country' => array('title' => $order['delivery_country']),
            'format_id' => $order['delivery_address_format_id']);

        if (empty($this->delivery['name']) && empty($this->delivery['street_address'])) {
            $this->delivery = false;
        }

        $this->billing = array('name' => $order['billing_name'],
            'company' => $order['billing_company'],
            'street_address' => $order['billing_street_address'],
            'suburb' => $order['billing_suburb'],
            'city' => $order['billing_city'],
            'postcode' => $order['billing_postcode'],
            'state' => $order['billing_state'],
            'country' => array('title' => $order['billing_country']),
            'format_id' => $order['billing_address_format_id']);

        $index = 0;
        $orders_products_query = tep_db_query("select orders_products_id, products_id, products_name, products_model, products_price, products_tax, products_quantity, final_price from " . TABLE_ORDERS_PRODUCTS . " where orders_id = '" . (int)$order_id . "'");
        while ($orders_products = tep_db_fetch_array($orders_products_query)) {
            $this->products[$index] = array('qty' => $orders_products['products_quantity'],
                'id' => $orders_products['products_id'],
                'name' => $orders_products['products_name'],
                'model' => $orders_products['products_model'],
                'tax' => $orders_products['products_tax'],
                'price' => $orders_products['products_price'],
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

            $this->info['tax_groups']["{$this->products[$index]['tax']}"] = '1';

            $index++;
        }
    }

    function cart() {
        global $_POST, $customer_id, $sendto, $billto, $cart, $languages_id, $currency, $currencies, $shipping, $payment, $comments, $customer_default_address_id;

        $this->content_type = $cart->get_content_type();

        if ( ($this->content_type != 'virtual') && ($sendto == false) ) {
            $sendto = $customer_default_address_id;
        }

        $customer_address_query = tep_db_query("select c.customers_firstname, c.customers_id, c.customers_lastname, c.customers_groups_id, c.customers_telephone, c.customers_fax, c.customers_email_address, ab.entry_company, ab.entry_street_address, ab.entry_suburb, ab.entry_postcode, ab.entry_city, ab.entry_zone_id, z.zone_name, co.countries_id, co.countries_name, co.countries_iso_code_2, co.countries_iso_code_3, co.address_format_id, ab.entry_state from " . TABLE_CUSTOMERS . " c, " . TABLE_ADDRESS_BOOK . " ab left join " . TABLE_ZONES . " z on (ab.entry_zone_id = z.zone_id) left join " . TABLE_COUNTRIES . " co on (ab.entry_country_id = co.countries_id) where c.customers_id = '" . (int)$customer_id . "' and ab.customers_id = '" . (int)$customer_id . "' and c.customers_default_address_id = ab.address_book_id");
        $customer_address = tep_db_fetch_array($customer_address_query);

        if (is_array($sendto) && !empty($sendto)) {
            $shipping_address = array('entry_firstname' => $sendto['firstname'],
                'entry_lastname' => $sendto['lastname'],
                'entry_company' => $sendto['company'],
                'entry_street_address' => $sendto['street_address'],
                'entry_suburb' => $sendto['suburb'],
                'entry_postcode' => $sendto['postcode'],
                'entry_city' => $sendto['city'],
                'entry_zone_id' => $sendto['zone_id'],
                'zone_name' => $sendto['zone_name'],
                'entry_country_id' => $sendto['country_id'],
                'countries_id' => $sendto['country_id'],
                'countries_name' => $sendto['country_name'],
                'countries_iso_code_2' => $sendto['country_iso_code_2'],
                'countries_iso_code_3' => $sendto['country_iso_code_3'],
                'address_format_id' => $sendto['address_format_id'],
                'entry_state' => $sendto['zone_name']);
        } elseif (is_numeric($sendto)) {
            $shipping_address_query = tep_db_query("select ab.entry_firstname, ab.entry_lastname, ab.entry_company, ab.entry_street_address, ab.entry_suburb, ab.entry_postcode,ab.entry_city_id, ab.entry_city, ab.entry_zone_id, z.zone_name, ab.entry_country_id, c.countries_id, c.countries_name, c.countries_iso_code_2, c.countries_iso_code_3, c.address_format_id, ab.entry_state from " . TABLE_ADDRESS_BOOK . " ab left join " . TABLE_ZONES . " z on (ab.entry_zone_id = z.zone_id) left join " . TABLE_COUNTRIES . " c on (ab.entry_country_id = c.countries_id) where ab.customers_id = '" . (int)$customer_id . "' and ab.address_book_id = '" . (int)$sendto . "'");
            $shipping_address = tep_db_fetch_array($shipping_address_query);
        } else {
            $shipping_address = array('entry_firstname' => null,
                'entry_lastname' => null,
                'entry_company' => null,
                'entry_street_address' => null,
                'entry_suburb' => null,
                'entry_postcode' => null,
                'entry_city' => null,
                'entry_zone_id' => null,
                'zone_name' => null,
                'entry_country_id' => null,
                'countries_id' => null,
                'countries_name' => null,
                'countries_iso_code_2' => null,
                'countries_iso_code_3' => null,
                'address_format_id' => 0,
                'entry_state' => null);
        }

        if (is_array($billto) && !empty($billto)) {
            $billing_address = array('entry_firstname' => $billto['firstname'],
                'entry_lastname' => $billto['lastname'],
                'entry_company' => $billto['company'],
                'entry_street_address' => $billto['street_address'],
                'entry_suburb' => $billto['suburb'],
                'entry_postcode' => $billto['postcode'],
                'entry_city' => $billto['city'],
                'entry_zone_id' => $billto['zone_id'],
                'zone_name' => $billto['zone_name'],
                'entry_country_id' => $billto['country_id'],
                'countries_id' => $billto['country_id'],
                'countries_name' => $billto['country_name'],
                'countries_iso_code_2' => $billto['country_iso_code_2'],
                'countries_iso_code_3' => $billto['country_iso_code_3'],
                'address_format_id' => $billto['address_format_id'],
                'entry_state' => $billto['zone_name']);
        } else {
            $billing_address_query = tep_db_query("select ab.entry_firstname, ab.entry_lastname, ab.entry_city_id, ab.entry_company, ab.entry_street_address, ab.entry_suburb, ab.entry_postcode, ab.entry_city, ab.entry_zone_id, z.zone_name, ab.entry_country_id, c.countries_id, c.countries_name, c.countries_iso_code_2, c.countries_iso_code_3, c.address_format_id, ab.entry_state from " . TABLE_ADDRESS_BOOK . " ab left join " . TABLE_ZONES . " z on (ab.entry_zone_id = z.zone_id) left join " . TABLE_COUNTRIES . " c on (ab.entry_country_id = c.countries_id) where ab.customers_id = '" . (int)$customer_id . "' and ab.address_book_id = '" . (int)$billto . "'");
            $billing_address = tep_db_fetch_array($billing_address_query);
        }

        if ($this->content_type == 'virtual') {
            $tax_address = array('entry_country_id' => $billing_address['entry_country_id'],
                'entry_zone_id' => $billing_address['entry_zone_id']);
        } else {
            $tax_address = array('entry_country_id' => $shipping_address['entry_country_id'],
                'entry_zone_id' => $shipping_address['entry_zone_id']);
        }

        $this->info = array('order_status' => DEFAULT_ORDERS_STATUS_ID,
            'currency' => $currency,
            'currency_value' => $currencies->currencies[$currency]['value'],
            'payment_method' => $payment,
            'cc_type' => '',
            'cc_owner' => '',
            'cc_number' => '',
            'cc_expires' => '',
            'shipping_method' => $shipping['title'],
            'shipping_cost' => $shipping['cost'],
            'subtotal' => 0,
            'tax' => 0,
            'tax_groups' => array(),
            'comments' => (tep_session_is_registered('comments') && !empty($comments) ? $comments : ''));

        if (isset($GLOBALS[$payment]) && is_object($GLOBALS[$payment])) {
            if (isset($GLOBALS[$payment]->public_title)) {
                $this->info['payment_method'] = $GLOBALS[$payment]->public_title;
            } else {
                $this->info['payment_method'] = $GLOBALS[$payment]->title;
            }

            if ( isset($GLOBALS[$payment]->order_status) && is_numeric($GLOBALS[$payment]->order_status) && ($GLOBALS[$payment]->order_status > 0) ) {
                $this->info['order_status'] = $GLOBALS[$payment]->order_status;
            }
        }

        $this->customer = array('id' => $customer_address['customers_id'],
            'firstname' => $customer_address['customers_firstname'],
            'lastname' => $customer_address['customers_lastname'],
//KIKOLEPPARD add for color groups start
            'group_id' => $customer_address['customers_groups_id'],
//KIKOLEPPARD add for color groups end
            'company' => $customer_address['entry_company'],
            'street_address' => $customer_address['entry_street_address'],
            'suburb' => $customer_address['entry_suburb'],
            'city' => $customer_address['entry_city'],
            'postcode' => $customer_address['entry_postcode'],
            'state' => ((tep_not_null($customer_address['entry_state'])) ? $customer_address['entry_state'] : $customer_address['zone_name']),
            'zone_id' => $customer_address['entry_zone_id'],
            'country' => array('id' => $customer_address['countries_id'], 'title' => $customer_address['countries_name'], 'iso_code_2' => $customer_address['countries_iso_code_2'], 'iso_code_3' => $customer_address['countries_iso_code_3']),
            'format_id' => $customer_address['address_format_id'],
            'telephone' => $customer_address['customers_telephone'],
            'fax' => $customer_address['customers_fax'],
            'email_address' => $customer_address['customers_email_address']);

        $this->delivery = array('firstname' => $shipping_address['entry_firstname'],
            'lastname' => $shipping_address['entry_lastname'],
            'company' => $shipping_address['entry_company'],
            'street_address' => $shipping_address['entry_street_address'],
            'suburb' => $shipping_address['entry_suburb'],
            'city' => $shipping_address['entry_city'],
            'postcode' => $shipping_address['entry_postcode'],
            'city_id' => $shipping_address['entry_city_id'],
            'state' => ((tep_not_null($shipping_address['entry_state'])) ? $shipping_address['entry_state'] : $shipping_address['zone_name']),
            'zone_id' => $shipping_address['entry_zone_id'],
            'country' => array('id' => $shipping_address['countries_id'], 'title' => $shipping_address['countries_name'], 'iso_code_2' => $shipping_address['countries_iso_code_2'], 'iso_code_3' => $shipping_address['countries_iso_code_3']),
            'country_id' => $shipping_address['entry_country_id'],
            'format_id' => $shipping_address['address_format_id']);

        $this->billing = array('firstname' => $billing_address['entry_firstname'],
            'lastname' => $billing_address['entry_lastname'],
            'company' => $billing_address['entry_company'],
            'street_address' => $billing_address['entry_street_address'],
            'suburb' => $billing_address['entry_suburb'],
            'city' => $billing_address['entry_city'],
            'postcode' => $billing_address['entry_postcode'],
            'state' => ((tep_not_null($billing_address['entry_state'])) ? $billing_address['entry_state'] : $billing_address['zone_name']),
            'zone_id' => $billing_address['entry_zone_id'],
            'country' => array('id' => $billing_address['countries_id'], 'title' => $billing_address['countries_name'], 'iso_code_2' => $billing_address['countries_iso_code_2'], 'iso_code_3' => $billing_address['countries_iso_code_3']),
            'country_id' => $billing_address['entry_country_id'],
            'format_id' => $billing_address['address_format_id']);

        $index = 0;
        $products = $cart->get_products();
        for ($i=0, $n=sizeof($products); $i<$n; $i++) {
			$model = $products[$i]['model'];
			$orders_products_query1 = tep_db_query("select products_purchase_price from `products` where products_model = '" . $model . "'");
			while ($orders_products1 = tep_db_fetch_array($orders_products_query1)) {
				$zakaz_price = $orders_products1['products_purchase_price'];
			}
            $this->products[$index] = array('qty' => $products[$i]['quantity'],
                'name' => $products[$i]['name'],
                'model' => $products[$i]['model'],
                'tax' => tep_get_tax_rate($products[$i]['tax_class_id'], $tax_address['entry_country_id'], $tax_address['entry_zone_id']),
                'tax_description' => tep_get_tax_description($products[$i]['tax_class_id'], $tax_address['entry_country_id'], $tax_address['entry_zone_id']),
                'price' => $products[$i]['price'],
                'final_price' => $products[$i]['price'] + $cart->attributes_price($products[$i]['id']),
				'zakaz_price' => $zakaz_price,
                'weight' => $products[$i]['weight'],
                'id' => $products[$i]['id']);

            if ($products[$i]['attributes']) {
                $subindex = 0;
                reset($products[$i]['attributes']);
                while (list($option, $value) = each($products[$i]['attributes'])) {
                    $attributes_query = tep_db_query("select popt.products_options_name, poval.products_options_values_name, pa.options_values_price, pa.price_prefix from " . TABLE_PRODUCTS_OPTIONS . " popt, " . TABLE_PRODUCTS_OPTIONS_VALUES . " poval, " . TABLE_PRODUCTS_ATTRIBUTES . " pa where pa.products_id = '" . (int)$products[$i]['id'] . "' and pa.options_id = '" . (int)$option . "' and pa.options_id = popt.products_options_id and pa.options_values_id = '" . (int)$value . "' and pa.options_values_id = poval.products_options_values_id and popt.language_id = '" . (int)$languages_id . "' and poval.language_id = '" . (int)$languages_id . "'");
                    $attributes = tep_db_fetch_array($attributes_query);
// otf 1.71 Determine if attribute is a text attribute and change products array if it is.
                    if ($value == PRODUCTS_OPTIONS_VALUE_TEXT_ID){
                        $attr_value = $products[$i]['attributes_values'][$option];
                    } else {
                        $attr_value = $attributes['products_options_values_name'];
                    }
                    $this->products[$index]['attributes'][$subindex] = array('option' => $attributes['products_options_name'],
                        'value' => $attr_value,
                        'option_id' => $option,
                        'value_id' => $value,
                        'prefix' => $attributes['price_prefix'],
                        'price' => $attributes['options_values_price']);

                    $subindex++;
                }
            }

            $shown_price = $currencies->calculate_price($this->products[$index]['final_price'], $this->products[$index]['tax'], $this->products[$index]['qty']);
            $this->info['subtotal'] += $shown_price;

            $products_tax = $this->products[$index]['tax'];
            $products_tax_description = $this->products[$index]['tax_description'];
            if (DISPLAY_PRICE_WITH_TAX == 'true') {
                $this->info['tax'] += $shown_price - ($shown_price / (($products_tax < 10) ? "1.0" . str_replace('.', '', $products_tax) : "1." . str_replace('.', '', $products_tax)));
                if (isset($this->info['tax_groups']["$products_tax_description"])) {
                    $this->info['tax_groups']["$products_tax_description"] += $shown_price - ($shown_price / (($products_tax < 10) ? "1.0" . str_replace('.', '', $products_tax) : "1." . str_replace('.', '', $products_tax)));
                } else {
                    $this->info['tax_groups']["$products_tax_description"] = $shown_price - ($shown_price / (($products_tax < 10) ? "1.0" . str_replace('.', '', $products_tax) : "1." . str_replace('.', '', $products_tax)));
                }
            } else {
                $this->info['tax'] += ($products_tax / 100) * $shown_price;
                if (isset($this->info['tax_groups']["$products_tax_description"])) {
                    $this->info['tax_groups']["$products_tax_description"] += ($products_tax / 100) * $shown_price;
                } else {
                    $this->info['tax_groups']["$products_tax_description"] = ($products_tax / 100) * $shown_price;
                }
            }

            $index++;
        }

        if (DISPLAY_PRICE_WITH_TAX == 'true') {
            $this->info['total'] = $this->info['subtotal'] + $this->info['shipping_cost'];
        } else {
            $this->info['total'] = $this->info['subtotal'] + $this->info['tax'] + $this->info['shipping_cost'];
        }

    }

// SMART CHECKOUT BOF
    function cart_noaccount() {
        global $HTTP_POST_VARS, $customer_id, $sendto, $billto, $cart, $languages_id, $currency, $currencies, $shipping, $payment, $comments, $customer_default_address_id;

        $this->content_type = $cart->get_content_type();

        if ( ($this->content_type != 'virtual') && ($sendto == false) ) {
            $sendto = $customer_default_address_id;
        }


        //get always zone and country data from customers input fields for shipping and customers order data
        $sc_customers_zone_id = $_SESSION['sc_customers_zone_id'];
        $sc_customers_countries_id = $_SESSION['sc_customers_country'];

        $sc_customers_zone_data_query = tep_db_query("select zone_name from " . TABLE_ZONES . " where zone_id = '" . $sc_customers_zone_id . "'");
        $sc_customers_zone_data = tep_db_fetch_array($sc_customers_zone_data_query);

        $sc_customers_country_data_query = tep_db_query("select countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id from " . TABLE_COUNTRIES . " where countries_id = '" . $sc_customers_countries_id . "'");
        $sc_customers_country_data = tep_db_fetch_array($sc_customers_country_data_query);




        $this->info = array('order_status' => DEFAULT_ORDERS_STATUS_ID,
            'currency' => $currency,
            'currency_value' => $currencies->currencies[$currency]['value'],
            'payment_method' => $payment,
            'cc_type' => '',
            'cc_owner' => '',
            'cc_number' => '',
            'cc_expires' => '',
            'shipping_method' => $shipping['title'],
            'shipping_cost' => $shipping['cost'],
            'subtotal' => 0,
            'tax' => 0,
            'tax_groups' => array(),
            'comments' => (tep_session_is_registered('comments') && !empty($comments) ? $comments : ''));

        if (isset($GLOBALS[$payment]) && is_object($GLOBALS[$payment])) {
            if (isset($GLOBALS[$payment]->public_title)) {
                $this->info['payment_method'] = $GLOBALS[$payment]->public_title;
            } else {
                $this->info['payment_method'] = $GLOBALS[$payment]->title;
            }

            if ( isset($GLOBALS[$payment]->order_status) && is_numeric($GLOBALS[$payment]->order_status) && ($GLOBALS[$payment]->order_status > 0) ) {
                $this->info['order_status'] = $GLOBALS[$payment]->order_status;

            }
        }


        //customer data
        //format_id = from country table, get data from table country
        $this->customer = array('firstname' => $_SESSION['sc_customers_firstname'],
            'lastname' => $_SESSION['sc_customers_lastname'],
            'company' => $_SESSION['sc_customers_company'],
            'street_address' => $_SESSION['sc_customers_street_address'],
            'suburb' => $_SESSION['sc_customers_suburb'],
            'city' => $_SESSION['sc_customers_city'],
            'postcode' => $_SESSION['sc_customers_postcode'],
            'state' => ((tep_not_null($_SESSION['sc_customers_state'])) ? $_SESSION['sc_customers_state'] : $sc_customers_zone_data['zone_name']),
            'zone_id' => $_SESSION['sc_customers_zone_id'],
            'country' => array('id' => $sc_customers_country_data['countries_id'], 'title' => $sc_customers_country_data['countries_name'], 'iso_code_2' => $sc_customers_country_data['countries_iso_code_2'], 'iso_code_3' => $sc_customers_country_data['countries_iso_code_3']),
            'format_id' => $sc_customers_country_data['address_format_id'],
            'telephone' => $_SESSION['sc_customers_telephone'],
            'email_address' => $_SESSION['sc_customers_email_address']);



        $this->delivery = array('firstname' => $_SESSION['sc_customers_firstname'],
            'lastname' => $_SESSION['sc_customers_lastname'],
            'company' => $_SESSION['sc_customers_company'],
            'street_address' => $_SESSION['sc_customers_street_address'],
            'suburb' => $_SESSION['sc_customers_suburb'],
            'city' => $_SESSION['sc_customers_city'],
            'postcode' => $_SESSION['sc_customers_postcode'],
            'state' => ((tep_not_null($_SESSION['sc_customers_state'])) ? $_SESSION['sc_customers_state'] : $sc_customers_zone_data['zone_name']),
            'zone_id' => $_SESSION['sc_customers_zone_id'],
            'country' => array('id' => $sc_customers_country_data['countries_id'], 'title' => $sc_customers_country_data['countries_name'], 'iso_code_2' => $sc_customers_country_data['countries_iso_code_2'], 'iso_code_3' => $sc_customers_country_data['countries_iso_code_3']),
            'country_id' => $_SESSION['sc_customers_country'],
            'format_id' => $sc_customers_country_data['address_format_id']);







        if ($_SESSION['sc_payment_address_selected'] != '1') { //is unchecked - so payment address is different

            //get different zone and country data from customers input fields for billing order data
            $sc_customers_zone_id = $_SESSION['sc_payment_zone_id'];
            $sc_customers_countries_id = $_SESSION['sc_payment_country'];

            $sc_customers_zone_data_query = tep_db_query("select zone_name from " . TABLE_ZONES . " where zone_id = '" . $sc_customers_zone_id . "'");
            $sc_customers_zone_data = tep_db_fetch_array($sc_customers_zone_data_query);

            $sc_customers_country_data_query = tep_db_query("select countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id from " . TABLE_COUNTRIES . " where countries_id = '" . $sc_customers_countries_id . "'");
            $sc_customers_country_data = tep_db_fetch_array($sc_customers_country_data_query);

            $sc_sess_firstname = $_SESSION['sc_payment_firstname'];
            $sc_sess_lastname = $_SESSION['sc_payment_lastname'];
            $sc_sess_company = $_SESSION['sc_payment_company'];
            $sc_sess_street_address = $_SESSION['sc_payment_street_address'];
            $sc_sess_suburb = $_SESSION['sc_payment_suburb'];
            $sc_sess_city = $_SESSION['sc_payment_city'];
            $sc_sess_postcode = $_SESSION['sc_payment_postcode'];
            $sc_sess_state = $_SESSION['sc_payment_state'];
            $sc_sess_zone_id = $_SESSION['sc_payment_zone_id'];
            $sc_sess_country = $_SESSION['sc_payment_country'];
        } else { //payment address is same as shipping address
            $sc_sess_firstname = $_SESSION['sc_customers_firstname'];
            $sc_sess_lastname = $_SESSION['sc_customers_lastname'];
            $sc_sess_company = $_SESSION['sc_customers_company'];
            $sc_sess_street_address = $_SESSION['sc_customers_street_address'];
            $sc_sess_suburb = $_SESSION['sc_customers_suburb'];
            $sc_sess_city = $_SESSION['sc_customers_city'];
            $sc_sess_postcode = $_SESSION['sc_customers_postcode'];
            $sc_sess_state = $_SESSION['sc_customers_state'];
            $sc_sess_zone_id = $_SESSION['sc_customers_zone_id'];
            $sc_sess_country = $_SESSION['sc_customers_country'];
        }




        $this->billing = array('firstname' => $sc_sess_firstname, //$billing_address['entry_firstname'],
            'lastname' => $sc_sess_lastname,
            'company' => $sc_sess_company,
            'street_address' => $sc_sess_street_address,
            'suburb' => $sc_sess_suburb,
            'city' => $sc_sess_city,
            'postcode' => $sc_sess_postcode,
            'state' => ((tep_not_null($sc_sess_state)) ? $sc_sess_state : $sc_customers_zone_data['zone_name']),
            'zone_id' => $sc_sess_zone_id,
            'country' => array('id' => $sc_customers_country_data['countries_id'], 'title' => $sc_customers_country_data['countries_name'], 'iso_code_2' => $sc_customers_country_data['countries_iso_code_2'], 'iso_code_3' => $sc_customers_country_data['countries_iso_code_3']),
            'country_id' => $sc_sess_country,
            'format_id' => $sc_customers_country_data['address_format_id']);



        //get products
        $index = 0;
        $products = $cart->get_products();
        for ($i=0, $n=sizeof($products); $i<$n; $i++) {
            $this->products[$index] = array('qty' => $products[$i]['quantity'],
                'name' => $products[$i]['name'],
                'model' => $products[$i]['model'],
                'tax' => tep_get_tax_rate($products[$i]['tax_class_id'], $tax_address['entry_country_id'], $tax_address['entry_zone_id']),
                'tax_description' => tep_get_tax_description($products[$i]['tax_class_id'], $tax_address['entry_country_id'], $tax_address['entry_zone_id']),
                'price' => $products[$i]['price'],
                'final_price' => $products[$i]['price'] + $cart->attributes_price($products[$i]['id']),
                'weight' => $products[$i]['weight'],
                'id' => $products[$i]['id']);

            if ($products[$i]['attributes']) {
                $subindex = 0;
                reset($products[$i]['attributes']);
                while (list($option, $value) = each($products[$i]['attributes'])) {
                    $attributes_query = tep_db_query("select popt.products_options_name, poval.products_options_values_name, pa.options_values_price, pa.price_prefix from " . TABLE_PRODUCTS_OPTIONS . " popt, " . TABLE_PRODUCTS_OPTIONS_VALUES . " poval, " . TABLE_PRODUCTS_ATTRIBUTES . " pa where pa.products_id = '" . (int)$products[$i]['id'] . "' and pa.options_id = '" . (int)$option . "' and pa.options_id = popt.products_options_id and pa.options_values_id = '" . (int)$value . "' and pa.options_values_id = poval.products_options_values_id and popt.language_id = '" . (int)$languages_id . "' and poval.language_id = '" . (int)$languages_id . "'");
                    $attributes = tep_db_fetch_array($attributes_query);

                    $this->products[$index]['attributes'][$subindex] = array('option' => $attributes['products_options_name'],
                        'value' => $attributes['products_options_values_name'],
                        'option_id' => $option,
                        'value_id' => $value,
                        'prefix' => $attributes['price_prefix'],
                        'price' => $attributes['options_values_price']);

                    $subindex++;
                }
            }

            $shown_price = $currencies->calculate_price($this->products[$index]['final_price'], $this->products[$index]['tax'], $this->products[$index]['qty']);
            $this->info['subtotal'] += $shown_price;

            $products_tax = $this->products[$index]['tax'];
            $products_tax_description = $this->products[$index]['tax_description'];
            if (DISPLAY_PRICE_WITH_TAX == 'true') {
                $this->info['tax'] += $shown_price - ($shown_price / (($products_tax < 10) ? "1.0" . str_replace('.', '', $products_tax) : "1." . str_replace('.', '', $products_tax)));
                if (isset($this->info['tax_groups']["$products_tax_description"])) {
                    $this->info['tax_groups']["$products_tax_description"] += $shown_price - ($shown_price / (($products_tax < 10) ? "1.0" . str_replace('.', '', $products_tax) : "1." . str_replace('.', '', $products_tax)));
                } else {
                    $this->info['tax_groups']["$products_tax_description"] = $shown_price - ($shown_price / (($products_tax < 10) ? "1.0" . str_replace('.', '', $products_tax) : "1." . str_replace('.', '', $products_tax)));
                }
            } else {
                $this->info['tax'] += ($products_tax / 100) * $shown_price;
                if (isset($this->info['tax_groups']["$products_tax_description"])) {
                    $this->info['tax_groups']["$products_tax_description"] += ($products_tax / 100) * $shown_price;
                } else {
                    $this->info['tax_groups']["$products_tax_description"] = ($products_tax / 100) * $shown_price;
                }
            }

            $index++;
        }

        if (DISPLAY_PRICE_WITH_TAX == 'true') {
            $this->info['total'] = $this->info['subtotal'] + $this->info['shipping_cost'];
        } else {
            $this->info['total'] = $this->info['subtotal'] + $this->info['tax'] + $this->info['shipping_cost'];
        }
    }

} //end class
// SMART CHECKOUT BOF

?>