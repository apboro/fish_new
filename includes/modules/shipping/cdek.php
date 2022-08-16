<?php
define('CDEK_FREE', 2500);

class cdek
{
    var $code, $title, $description, $icon, $enabled, $errorset;

// class constructor
    function cdek()
    {
        global $order;
        $this->price_from = 125;
        $this->errorset = false;
        $this->sender_city = CDEK_SenderCity;
        $this->mode_id = 4;
        $this->mode_id1 = 3;
        $this->code = 'cdek';
        $this->title = MODULE_SHIPPING_CDEK_TEXT_TITLE;
        $this->description = MODULE_SHIPPING_CDEK_TEXT_DESCRIPTION;
        $this->sort_order = MODULE_SHIPPING_CDEK_SORT_ORDER;
        $this->icon = '';
        $this->tax_class = MODULE_SHIPPING_CDEK_TAX_CLASS;
        $this->enabled = ((MODULE_SHIPPING_CDEK_STATUS == 'True') ? true : false);
        /*      if ( ($this->enabled == true) && ((int)MODULE_SHIPPING_CDEK_ZONE > 0) ) {
                $check_flag = false;
                $check_query = tep_db_query("select zone_id from " . TABLE_ZONES_TO_GEO_ZONES . " where geo_zone_id = '" . MODULE_SHIPPING_CDEK_ZONE . "' and zone_country_id = '" . $order->delivery['country']['id'] . "' order by zone_id");
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
        */
    }

// class methods
    function quote($method = '')
    {
        global $order, $cart, $javascript_footer, $_SESSION, $_REQUEST, $messageStack;
         

     

        $cdek_way_text = '';
        $need_recalc = false;
        if (isset($_REQUEST['cityID'])) {
            $need_recalc = ($_SESSION['cdek_ship']['cityID'] !== $_REQUEST['cityID']) ||
                (!isset($_SESSION['cdek_ship']['cdek_price']) ||
                    ($_SESSION['cdek_ship']['cdek_postbox'] !== $_REQUEST['cdek_postbox']));
        }
        $need_recalc = $need_recalc && ($_REQUEST['cityID'] > 0);
        $destination_city = $order->customer['city'];
        if (isset($_SESSION['cdek_ship']['destCity'])) {
            $destination_city = $_SESSION['cdek_ship']['destCity'];
        }
        if (isset($_SESSION['cdek_ship']['cityID'])) {
            $destination_cityID = $_SESSION['cdek_ship']['cityID'];
        }elseif(isset($_SESSION['order_addon']['cityID'])){
            $destination_cityID = $_SESSION['order_addon']['cityID'];
        } elseif(!empty($order->delivery['city_id'])) {
            $destination_cityID = $order->delivery['city_id']   ;
        }else{
            $destination_cityID = -1;
        }
        if (MODULE_SHIPPING_CDEK_STATUS == 'True') {
            $addon = '<input autocomplete="off" name="oity" type="text" value="' . $destination_city . '" placeholder="Начните вводить город">
        <input type="hidden" name="cityID" value="' . $destination_cityID . '">
         
		 <a href="#yandmap" id="showmap">На карте в городе ↑</a><span id="cdek_postbox"> 
        
		<select id="postbox" name="cdek_postbox" data-value="'.$_SESSION['order_addon']['cdek_postbox'].'">
        </select>
        </span>
        <span id="cdek_way"></span>';
		
            $javascript_footer[] = 'city_auto.js';
        }
        $shipping_cdek = $this->price_from;
        /*....Calculate real price....*/
        if ($_REQUEST['city'] !== NULL) {
            $_SESSION['cdek_ship']['destCity'] = $_REQUEST['city'];
        }
        if ($_REQUEST['cdek_postbox'] !== NULL) {
            $_SESSION['cdek_ship']['cdek_postbox'] = $_REQUEST['cdek_postbox'];
            if (isset($_SESSION['cdek_ship']['cdek_offices'])) {
                $cdek_offices = unserialize($_SESSION['cdek_ship']['cdek_offices']);
                foreach ($cdek_offices as $cd_value => $cd_key) {
                    if (trim($cd_key) == trim($_REQUEST['cdek_postbox'])) {
                        $_SESSION['cdek_ship']['cdek_office_address'] = $cd_value;
						
                    }
                }
            }
        }

        if ((isset($_SESSION['shipping']['cost'])) && (isset($_SESSION['cdek_ship']['cdek_price']))) {
            $_SESSION['shipping']['cost'] = $_SESSION['cdek_ship']['cdek_price'];
        }

        if ($order->info['subtotal'] > CDEK_FREE) {
            
            $_SESSION['cdek_ship']['cdek_price'] = 0;
            $_SESSION['order_addon']['cdek_price'] = 0;
        }
       

		//[if (($cart->weight > 3000)) {
        //    $shipping_cdek = 500;
       // }

        if (isset($_SESSION['cdek_ship']['cdek_price'])) {
            $shipping_cdek = $_SESSION['cdek_ship']['cdek_price'];
        }
        $encode_destination = $_SESSION['cdek_ship']['cdek_office_address'];
        $this->quotes = array('id' => $this->code,
            'module' => $this->title . ($_SESSION['cdek_ship']['destCity'] ? '(' . $_SESSION['cdek_ship']['destCity'] . '-' . $encode_destination . ')' : ''),
            'methods' => array(array('id' => $this->code,
                'title' =>  MODULE_SHIPPING_CDEK_TEXT_WAY,
                'addon' => $addon,
                'cost' => $shipping_cdek)));
        /*fillin addon information for order history*/
        if (isset($_SESSION['cdek_ship'])) {
            foreach ($_SESSION['cdek_ship'] as $cdek_key => $cdek_value) {
                if ($cdek_key == 'cdek_offices') {
                    continue;
                }
                $_SESSION['order_addon'][$cdek_key] = $cdek_value;
            }
            if (isset($_REQUEST['payment']) && (strlen($_REQUEST['payment']) > 0)) {
                $payment = $_REQUEST['payment'];
                $payment = preg_replace('|[^\w_]|', '', $payment);
                $_SESSION['order_addon']['payment'] = $payment;
            }

            $_SESSION['order_addon_comment'] = 'Город: ' . $_SESSION['order_addon']['destCity'] .
                ' отделение: ' . $_SESSION['order_addon']['cdek_postbox'] .
                ' адрес отделения: ' . $_SESSION['order_addon']['cdek_office_address'] .
                ' цена: ' . $_SESSION['order_addon']['cdek_price'] . ' руб.' .
                ' тариф: ' . $_SESSION['order_addon']['cdek_tarif'] .
                ' тип доставки: ' . $_SESSION['order_addon']['cdek_way'];

        }
        /*if (strlen($_SESSION['order_addon']['destCity'])==0){
            if ($this->errorset){
            $messageStack->add('smart_checkout','Укажите город доставки');
            }
            }*/
//echo '<pre>';var_dump($_SESSION['order_addon'],$messageStack);echo '</pre>';
        if ($this->tax_class > 0) {
            $this->quotes['tax'] = tep_get_tax_rate($this->tax_class, $order->delivery['country']['id'], $order->delivery['zone_id']);
        }

        if (tep_not_null($this->icon)) $this->quotes['icon'] = tep_image($this->icon, $this->title);

        return $this->quotes;
    }

    function check()
    {
        if (!isset($this->_check)) {
            $check_query = tep_db_query("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_SHIPPING_CDEK_STATUS'");
            $this->_check = tep_db_num_rows($check_query);
        }
        return $this->_check;
    }

    function install()
    {
        tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Разрешить модуль процентная доставка', 'MODULE_SHIPPING_CDEK_STATUS', 'True', 'Вы хотите разрешить модуль СДЭК?', '6', '0', 'tep_cfg_select_option(array(\'True\', \'False\'), ', now())");


        tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Код города отправителя:', 'CDEK_SenderCity', '44', '', '6', '1', now())");
        tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Имя пользователя API CDEK:', 'CDEK_UserKey', '', '', '6', '2', now())");
        tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Пароль API CDEK:', 'CDEK_UserPassword', '', '', '6', '3', now())");

        tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) values ('Налог', 'MODULE_SHIPPING_CDEK_TAX_CLASS', '0', 'Использовать налог.', '6', '0', 'tep_get_tax_class_title', 'tep_cfg_pull_down_tax_classes(', now())");
        tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) values ('Зона', 'MODULE_SHIPPING_CDEK_ZONE', '0', 'Если выбрана зона, то данный модуль доставки будет виден только покупателям из выбранной зоны.', '6', '0', 'tep_get_zone_class_title', 'tep_cfg_pull_down_zone_classes(', now())");
        tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Порядок сортировки', 'MODULE_SHIPPING_CDEK_SORT_ORDER', '0', 'Порядок сортировки модуля.', '6', '0', now())");
    }

    function remove()
    {
        tep_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }

    function keys()
    {
        return array('MODULE_SHIPPING_CDEK_STATUS',
            'MODULE_SHIPPING_CDEK_TAX_CLASS', 'MODULE_SHIPPING_CDEK_ZONE', 'MODULE_SHIPPING_CDEK_SORT_ORDER',
            'CDEK_SenderCity', 'CDEK_UserKey', 'CDEK_UserPassword');
    }
}

?>