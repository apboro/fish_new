<style>
    div.sm_layout_box {
        padding:5px;border:1px solid gray;
        margin:2px;
        font-size:11px;
    }
    div.sm_layout_box p,h5{font-size:11px;margin:0;padding:5px;}
    div.sm_layout_box h2{font-size:12px;}
    div.sm_layout_box table tr td {vertical-align:middle;font-size:14px;line-height: 1.5;}
</style>
<?php

###################### payment url redirection START ###################################
//if payment method such as paypal is choosen,  repost process_button data
if ((isset($$payment->form_action_url)) && ($sc_payment_url == true)) {

    $form_action_url = $$payment->form_action_url;
    echo tep_draw_form('checkoutUrl', $form_action_url, 'post');
}

if (is_array($payment_modules->modules)) {
    $payment_modules->pre_confirmation_check();
}

if (is_array($payment_modules->modules)) {
    $payment_modules->confirmation();
}

if (is_array($payment_modules->modules)) {
    echo $payment_modules->process_button();
}

//////////  START  redirection page for payment modules such as paypal if no confirmation page ////////////
if ((isset($$payment->form_action_url)) && ($sc_payment_url == true)) {
    ?>

    <!-- body //-->
    <?php
    if (is_array($payment_modules->modules)) {
        if ($confirmation = $payment_modules->confirmation()) {

            ?>

            <!--  <h2><?php echo HEADING_PAYMENT_INFORMATION; ?></h2> -->

            <div class="contentText">
                <table border="0" cellspacing="0" cellpadding="2">
                    <tr>
                        <td colspan="4"><?php
                            echo $confirmation['title']; ?></td>
                    </tr>

                    <?php
                    for ($i=0, $n=sizeof($confirmation['fields']); $i<$n; $i++) {

                        ?>

                        <tr>
                            <td><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
                            <td class="main"><?php echo $confirmation['fields'][$i]['title']; ?></td>
                            <td><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
                            <td class="main"><?php echo $confirmation['fields'][$i]['field']; ?></td>
                        </tr>

                        <?php
                    }
                    ?>

                </table>
            </div>

            <?php
        }
    }

    ?>

    <p><?php echo SC_TEXT_REDIRECT; ?></p>



    </form>

    <!-- body_eof //-->

    <script type="text/javascript">
        document.checkoutUrl.submit();
    </script>
    <noscript><input type="submit" value="verify submit"></noscript>


    <?php
}
//////////  END  redirection page for payment modules such as paypal if no confirmation page ////////////
?>

<!-- body //-->

<?php echo $payment_modules->javascript_validation(); ?>

<table class="table-padding-0">
    <tr>
        <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
        <td class="pageHeading" align="right"><?php echo tep_image(DIR_WS_TEMPLATES . TEMPLATE_NAME . '/images/content/confirmation.gif', HEADING_TITLE, HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?></td>
    </tr>
</table>
<!--<h1><?php echo HEADING_TITLE; ?></h1>-->

<!--<div id="box">
    <p style="    color: #2660b8;    font-weight: bold;">При покупке любой снасти стоимостью выше двух тысяч рублей,
        <b style="    color: red;
">блесна Mikado</b> на выбор магазина в <b style="    color: red;">ПОДАРОК!</b></p>-->

    <?php echo tep_draw_form('cart_quantity', tep_href_link(FILENAME_CHECKOUT, 'action=update_product')); ?><table border="0" width="100%" cellspacing="0" cellpadding="<?php echo CELLPADDING_SUB;?>">

        <?php
        $has_gifts = false;
        if ($cart->count_contents() > 0) {
            ?>
            <tr>
                <td>
                    <?php
                    $info_box_contents = array();
                    $info_box_contents[0][] = array('align' => 'center',
                        'params' => 'class="productListing-heading"',
                        'text' => TABLE_HEADING_REMOVE);

                    $info_box_contents[0][] = array('params' => 'class="productListing-heading"',
                        'text' => TABLE_HEADING_PRODUCTS);

                    $info_box_contents[0][] = array('align' => 'center',
                        'params' => 'class="productListing-heading"',
                        'text' => TABLE_HEADING_QUANTITY);

                    $info_box_contents[0][] = array('align' => 'right',
                        'params' => 'class="productListing-heading"',
                        'text' => TABLE_HEADING_TOTAL);

                    $any_out_of_stock = 0;
                    $products = $cart->get_products();
                    for ($i=0, $n=sizeof($products); $i<$n; $i++) {
// Push all attributes information in an array
                        if (isset($products[$i]['attributes']) && is_array($products[$i]['attributes'])) {
                            while (list($option, $value) = each($products[$i]['attributes'])) {
// otf 1.71 move hidden field to if statement below
// echo tep_draw_hidden_field('id[' . $products[$i]['id'] . '][' . $option . ']', $value);
                                $attributes = tep_db_query("select popt.products_options_name, poval.products_options_values_name, pa.options_values_price, pa.price_prefix
                                      from " . TABLE_PRODUCTS_OPTIONS . " popt, " . TABLE_PRODUCTS_OPTIONS_VALUES . " poval, " . TABLE_PRODUCTS_ATTRIBUTES . " pa
                                      where pa.products_id = '" . (int)$products[$i]['id'] . "'
                                       and pa.options_id = '" . (int)$option . "'
                                       and pa.options_id = popt.products_options_id
                                       and pa.options_values_id = '" . (int)$value . "'
                                       and pa.options_values_id = poval.products_options_values_id
                                       and popt.language_id = '" . (int)$languages_id . "'
                                       and poval.language_id = '" . (int)$languages_id . "'");
// otf 1.71 Added the (int) before $value to make work.  Array changed to var type?
// Added the .$addcgid on the previous line - to specify the customer group id
                                $attributes_values = tep_db_fetch_array($attributes);
// otf 1.71 determine if attribute is a text attribute and assign to $attr_value temporarily
                                if ($value == PRODUCTS_OPTIONS_VALUE_TEXT_ID) {
                                    echo tep_draw_hidden_field('id[' . $products[$i]['id'] . '][' . TEXT_PREFIX . $option . ']',  $products[$i]['attributes_values'][$option]);
                                    $attr_value = $products[$i]['attributes_values'][$option];
                                } else {
                                    echo tep_draw_hidden_field('id[' . $products[$i]['id'] . '][' . $option . ']', $value);
                                    $attr_value = $attributes_values['products_options_values_name'];
                                }

                                $products[$i][$option]['products_options_name'] = $attributes_values['products_options_name'];
                                $products[$i][$option]['options_values_id'] = $value;
                                //otf 1.71 assign $attr_value
                                $products[$i][$option]['products_options_values_name'] = $attr_value ;
                                $products[$i][$option]['options_values_price'] = $attributes_values['options_values_price'];
                                $products[$i][$option]['price_prefix'] = $attributes_values['price_prefix'];
                            }
                        }
                    }
                    $total_full=0;
                    for ($i=0, $n=sizeof($products); $i<$n; $i++) {
                        if (($i/2) == floor($i/2)) {
                            $info_box_contents[] = array('params' => 'class="productListing-even"');
                        } else {
                            $info_box_contents[] = array('params' => 'class="productListing-odd"');
                        }

                        $cur_row = sizeof($info_box_contents) - 1;

                        $info_box_contents[$cur_row][] = array('align' => 'center',
                            'params' => 'class="productListing-data" valign="top"',
                            'text' => tep_draw_checkbox_field('cart_delete[]', $products[$i]['id']));

                        $products_name = '<table border="0" cellspacing="2" cellpadding="2">' .
                            '  <tr>' .
                            '    <td class="productListing-data" align="center"><a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $products[$i]['id']) . '"'.AddBlank().'>' . tep_image(DIR_WS_IMAGES . $products[$i]['image'], $products[$i]['name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT) . '</a></td>' .
                            '    <td class="productListing-data" valign="top"><a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $products[$i]['id']) . '"'.AddBlank().'><b>' . $products[$i]['name'] . '</b></a>';

                        if (STOCK_CHECK == 'true') {
                            $stock_check = tep_check_stock($products[$i]['id'], $products[$i]['quantity']);
                            if (tep_not_null($stock_check)) {
                                $any_out_of_stock = 1;

                                $products_name .= $stock_check;
                            }
                        }

                        if (isset($products[$i]['attributes']) && is_array($products[$i]['attributes'])) {
                            reset($products[$i]['attributes']);
                            while (list($option, $value) = each($products[$i]['attributes'])) {
                                $products_name .= '<br><small><i> - ' . $products[$i][$option]['products_options_name'] . ':  ' . $products[$i][$option]['products_options_values_name'] . '</i></small>';
                            }
                        }

                        $products_name .= '    </td>' .
                            '  </tr>' .
                            '</table>';

                        $info_box_contents[$cur_row][] = array('params' => 'class="productListing-data"',
                            'text' => $products_name);

                        $info_box_contents[$cur_row][] = array('align' => 'center',
                            'params' => 'class="productListing-data" valign="top"',
                            'text' => tep_draw_input_field('cart_quantity[]', $products[$i]['quantity'], 'size="4"') . tep_draw_hidden_field('products_id[]', $products[$i]['id']));

                        //TotalB2B start
                        /*      $info_box_contents[$cur_row][] = array('align' => 'right',
                                                                     'params' => 'class="productListing-data" valign="top"',
                                                                     'text' => '<b>' . $currencies->display_price_nodiscount($products[$i]['final_price'], tep_get_tax_rate($products[$i]['tax_class_id']), $products[$i]['quantity']) . '</b>');
                         */
                        $info_box_contents[$cur_row][] = array('align' => 'right',
                            'params' => 'class="productListing-data" valign="top"',
                            'text' => '<b>' .
                                DisplayDiscountPrice(
                                    $products[$i]['final_price']* $products[$i]['quantity'],
                                    $products[$i]['full_price']* $products[$i]['quantity'],
                                    $products[$i]['special_price']). '</b>');
                        $total_full+=$products[$i]['full_price']* $products[$i]['quantity'];
                        //TotalB2B end



                        $truba = false; //preg_match('/Спиннинг/i', $products[$i]['name']);
                        if(preg_match('/Спиннинг/', $products[$i]['name']) === 1) {$truba = true;}
                       
                        if (finalPrice(
                            $products[$i]['final_price'],
                            $products[$i]['full_price'],
                            $products[$i]['special_price']) >= 2000) {
                            $has_gifts = false; // чтобы сделать подарки, надо поменять на true
                        }

                    }

                    if($has_gifts === true){
                        $cur_row++;

                        if (($cur_row/2) == floor($cur_row/2)) {
                            $info_box_contents[$cur_row] = array('params' => 'class="productListing-even"');
                        } else {
                            $info_box_contents[$cur_row] = array('params' => 'class="productListing-odd"');
                        }

                        $info_box_contents[$cur_row][] = array('params' => 'class="productListing-data"',
                            'text' => '<br>');
                        $products_name = '<table border="0" cellspacing="2" cellpadding="2">' .
                            '  <tr>' .
                            '    <td class="productListing-data" align="center">'.tep_image(DIR_WS_IMAGES . '/mikado/middle/540.png', 'Блесна Микадо на выбор магазина', SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT).'</td>' .
                            '    <td class="productListing-data" valign="top"><b>Подарок блесна Микадо на выбор магазина</b></td>' .
                            '  </tr>' .
                            '</table>';

                        $info_box_contents[$cur_row][] = array('params' => 'class="productListing-data"',
                            'text' => $products_name);

                        $info_box_contents[$cur_row][] = array('align' => 'center',
                            'params' => 'class="productListing-data" valign="top"',
                            'text' => '1');

                        $info_box_contents[$cur_row][] = array('align' => 'right',
                            'params' => 'class="productListing-data" valign="top"',
                            'text' => '<b>Бесплатно</b>');
                    }
                    new productListingBox($info_box_contents);
                    ?>
                </td>
            </tr>
            <tr>
                <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
            </tr>
            <tr>
                <td align="right" class="main"><b><?php if ($truba === true) {echo 'Если заказ почтой или СДЭК - будет добавлена упаковка для удилища за 120 руб!';} ?> <?php

                        //TotalB2B start
                        global $customer_id;
                        //          $query_price_to_guest = tep_db_query("select configuration_value from " . TABLE_CONFIGURATION . " WHERE configuration_key = 'ALLOW_GUEST_TO_SEE_PRICES'");
                        //          $query_price_to_guest_result = tep_db_fetch_array($query_price_to_guest);
                        $query_price_to_guest_result = ALLOW_GUEST_TO_SEE_PRICES;
                        if ((($query_price_to_guest_result=='true') && !(tep_session_is_registered('customer_id'))) || ((tep_session_is_registered('customer_id')))) {
                            echo DisplayDiscountPrice($cart->show_total(),$total_full,false);
                        } else {
                            echo PRICES_LOGGED_IN_TEXT;
                        }
                        //TotalB2B end

                        ?></b></td>
            </tr>
            <?php
            if ($any_out_of_stock == 1) {
                /*
                      if (STOCK_ALLOW_CHECKOUT == 'true') {
                ?>
                      <tr>
                        <td class="stockWarning" align="center"><br><?php echo OUT_OF_STOCK_CAN_CHECKOUT; ?></td>
                      </tr>
                <?php

                      } else {

                ?>
                      <tr>
                        <td class="stockWarning" align="center"><br><?php echo OUT_OF_STOCK_CANT_CHECKOUT; ?></td>
                      </tr>
                <?php
                      }
                */
            }
            ?>
            <?php
            if (MAIN_TABLE_BORDER == 'yes'){
                table_image_border_bottom();
            }
            ?>
            <tr>
                <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
            </tr>
            <tr>
                <td><table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBox">
                        <tr class="infoBoxContents">
                            <td><table class="table-padding-2">
                                    <tr>
                                        <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
                                        <td class="main"><?php echo tep_template_image_submit('button_update_cart.gif', IMAGE_BUTTON_UPDATE_CART); ?></td>

                                        <td align="right" class="main"></td>
                                        <td width="10"></td>
                                    </tr>
                                </table></td>
                        </tr>
                    </table>
                </td>
            </tr>
            <?php
            $initialize_checkout_methods = $payment_modules->checkout_initialization_method();

            if (!empty($initialize_checkout_methods)) {
                ?>
                <tr>
                    <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
                </tr>
                <tr>
                    <td align="right" class="main" style="padding-right: 50px;"><?php echo TEXT_ALTERNATIVE_CHECKOUT_METHODS; ?></td>
                </tr>
                <?php
                reset($initialize_checkout_methods);
                while (list(, $value) = each($initialize_checkout_methods)) {
                    ?>
                    <tr>
                        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
                    </tr>
                    <tr>
                        <td align="right" class="main"><?php echo $value; ?></td>
                    </tr>
                    <?php
                }
            }
            ?>
            <?php
            if (SHOW_XSELL_CART=='true') {
                ?>
                <tr>
                    <td><?php require(DIR_WS_MODULES . 'xsell_cart.php'); ?></td>
                </tr>
                <?php
            }
            ?>
            <?php
// WebMakers.com Added: Shipping Estimator
            if (SHOW_SHIPPING_ESTIMATOR=='true' && ACCOUNT_STREET_ADDRESS == 'true' && ACCOUNT_CITY == 'true' && ACCOUNT_COUNTRY == 'true') {
                // always show shipping table
                ?>
                <tr>
                    <td><?php require(DIR_WS_MODULES . 'shipping_estimator.php'); ?></td>
                </tr>
                <?php
            }
            ?>
            <?php
        } else {
            ?>
            <?php
        }
        ?>
    </table>
    </form>
    <div id="checkout">


        <?php
        if ($messageStack->size('smart_checkout') > 0) {
            echo $messageStack->output('smart_checkout');
        }
        ?>


        <?php
        if (!tep_session_is_registered('customer_id')) {
            ?>
            <p><?php echo sprintf(TEXT_ORIGIN_LOGIN, tep_href_link(FILENAME_LOGIN, tep_get_all_get_params(), 'SSL')); ?></p>
            <?php
        }
        ?>


        <?php
        //Draw form for pressing button "confirm order"
        //first check input fields and check for payment choosen
        $form_action_url = tep_href_link(FILENAME_CHECKOUT, '', 'SSL');
        echo tep_draw_form('smart_checkout', $form_action_url, 'post', ' id="SmartCheck" onsubmit="return check_form(smart_checkout);"', true);


        // draw process hidden field
        if (tep_session_is_registered('customer_id')) {  //logged on - process another action = 'logged_on'
            echo tep_draw_hidden_field('action', 'logged_on');
        } else { //is not logged on - process another action = 'process'
            //not logged on
            echo tep_draw_hidden_field('action', 'not_logged_on');
        }

        echo tep_draw_hidden_field('shipping_count', $shipping_count); //need to post it for validation
        echo tep_draw_hidden_field('sc_payment_address_show', $sc_payment_address_show); //need to post it for validation
        echo tep_draw_hidden_field('sc_payment_modules_show', $sc_payment_modules_show); //need to post it for validation
        echo tep_draw_hidden_field('create_account', $create_account); //need to post it for validation
        echo tep_draw_hidden_field('sc_shipping_modules_show', $sc_shipping_modules_show); //need to post it for validation
        echo tep_draw_hidden_field('sc_shipping_address_show', $sc_shipping_address_show); //need to post it for validation
        echo tep_draw_hidden_field('checkout_possible', $checkout_possible); //need to post it for validation
        /*---add fake shipping and payment values--*/
        echo tep_draw_hidden_field('payment','',' id="f_payment"');
        echo tep_draw_hidden_field('shipping','',' id="f_shipping"');
        echo tep_draw_hidden_field('tshipping','',' id="type_shipping"');
        ?>
        <?php
        /*---disable display shipping and payment addresses--*/

        if (tep_session_is_registered('customer_id')) {
            $ceq=tep_db_query('select * from customers where customers_id='.(int)$customer_id.' limit 1');
            if ($ceq!==false){
                $rceq=tep_db_fetch_array($ceq);
                ?>
                <div class="sm_layout_box">
                    <table border="0" cellspacing="2" cellpadding="2" width="100%">
                        <tr>
                            <td class="fieldKey"><?php echo ENTRY_FIRST_NAME; ?></td>
                            <td class="fieldValue">
                                <?php echo tep_draw_input_field('firstname', $rceq['customers_firstname'], 'class="text"') . '&nbsp;' . (!tep_not_null(ENTRY_FIRST_NAME_TEXT) ? '<span class="inputRequirement">' . ENTRY_FIRST_NAME_TEXT . '</span>': ''); ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="fieldKey"><?php echo ENTRY_LAST_NAME; ?></td>
                            <td class="fieldValue">
                                <?php echo tep_draw_input_field('lastname', $rceq['customers_lastname'], 'class="text"') . '&nbsp;' . (!tep_not_null(ENTRY_LAST_NAME_TEXT) ? '<span class="inputRequirement">' . ENTRY_LAST_NAME_TEXT . '</span>': ''); ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="fieldKey"><?php echo ENTRY_TELEPHONE_NUMBER; ?></td>
                            <td class="fieldValue">
                                <?php echo tep_draw_input_field('telephone', $rceq['customers_telephone'], 'class="text"') . '&nbsp;' . (!tep_not_null(ENTRY_TELEPHONE_NUMBER_TEXT) ? '<span class="inputRequirement">' . ENTRY_TELEPHONE_NUMBER_TEXT . '</span>': ''); ?>
                            </td>
                        </tr>
                    </table>
                </div>

                <?php
            }
        }//----display customer info

        if (tep_session_is_registered('customer_id'))
        {
            $sc_shipping_address_show=false;
            $sc_payment_address_show=false;
        }
        ?>
        <?php if ($sc_shipping_address_show == true) { //show shipping otpions ?>
            <div id="shipping_box" class="sm_layout_box infoBoxContents">


                <!--<h2><?php if (($sc_is_virtual_product == true) && ($sc_is_free_virtual_product == false)) {
                    echo  TABLE_HEADING_BILLING_ADDRESS;
                } elseif (($sc_is_virtual_product == true) && ($sc_is_free_virtual_product == true)) {
                    echo tep_get_sc_titles_number(). SC_HEADING_CREATE_ACCOUNT_INFORMATION;
                } else {
                    echo  TABLE_HEADING_SHIPPING_ADDRESS;
                } ?></h2> -->


                <?php ################ START Shipping Information - LOGGED ON ######################################## ?>
                <?php
                if (tep_session_is_registered('customer_id')) { ?>
                    <div>








                        <p><?php echo tep_address_label($customer_id, $sendto, true, ' ', '<br />'); ?></p>
                        <!--          <p><?php echo '<a href="' . tep_href_link(FILENAME_CHECKOUT_SHIPPING_ADDRESS, '', 'SSL') . '">' . tep_template_image_button('button_change_address.gif', IMAGE_BUTTON_CHANGE_ADDRESS) . '</a>'; ?></p>
-->
                    </div>
                <?php } else { //no account ?>
                    <?php ################ END Shipping Information - LOGGED ON ######################################## ?>


                    <?php ################ START Shipping Information - NO ACCOUNT ######################################## ?>

                    <table border="0" cellspacing="2" cellpadding="2" width="100%">

                    <?php
                    if (ACCOUNT_GENDER == 'true') {
                        ?>

                        <tr>
                            <td class="fieldKey"><?php echo ENTRY_GENDER; ?></td>
                            <td class="fieldValue">
                                <?php
                                //not yet finished
                                //echo tep_draw_radio_field('gender', 'm', '', 'id="checkme"') . '&nbsp;&nbsp;' . MALE . '&nbsp;&nbsp;' . tep_draw_radio_field('gender', 'f', '', 'id="checkme2"') . '&nbsp;&nbsp;' . FEMALE . '&nbsp;&nbsp;'. tep_draw_radio_field('gender', 'a', '', 'id="checkme1"') . '&nbsp;&nbsp;' . FIRMA . '&nbsp;' . (!tep_not_null(ENTRY_GENDER_TEXT) ? '<span class="inputRequirement">' . ENTRY_GENDER_TEXT . '</span>': '');

                                echo tep_draw_radio_field('gender', 'm') . '&nbsp;&nbsp;' . MALE . '&nbsp;&nbsp;' . tep_draw_radio_field('gender', 'f') . '&nbsp;&nbsp;' . FEMALE . '&nbsp;' . (!tep_not_null(ENTRY_GENDER_TEXT) ? '<span class="inputRequirement">' . ENTRY_GENDER_TEXT . '</span>': ''); ?></td>
                        </tr>
                        </table>
                        <?php
                    }
                    ?>



                    <?php
                    if (ACCOUNT_COMPANY == 'true') {
                        ?>
                        <div id="extra">
                            <table border="0" cellspacing="2" cellpadding="2" width="100%">
                                <tr>
                                    <td class="fieldKey"><?php echo ENTRY_COMPANY; ?></td>
                                    <td class="fieldValue"><?php echo tep_draw_input_field('company', $sc_guest_company, 'class="text"') . '&nbsp;' . (!tep_not_null(ENTRY_COMPANY_TEXT) ? '<span class="inputRequirement">' . ENTRY_COMPANY_TEXT . '</span>': ''); ?></td>
                                </tr>
                            </table>
                        </div>

                        <?php
                    }
                    ?>
                    <table border="0" cellspacing="2" cellpadding="2" width="100%">
                        <tr>
                            <td class="fieldKey"><?php echo ENTRY_FIRST_NAME; ?></td>
                            <td class="fieldValue">
                                <?php echo tep_draw_input_field('firstname', $sc_guest_firstname, 'class="text"') . '&nbsp;' . (!tep_not_null(ENTRY_FIRST_NAME_TEXT) ? '<span class="inputRequirement">' . ENTRY_FIRST_NAME_TEXT . '</span>': ''); ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="fieldKey"><?php echo ENTRY_LAST_NAME; ?></td>
                            <td class="fieldValue">
                                <?php echo tep_draw_input_field('lastname', $sc_guest_lastname, 'class="text"') . '&nbsp;' . (!tep_not_null(ENTRY_LAST_NAME_TEXT) ? '<span class="inputRequirement">' . ENTRY_LAST_NAME_TEXT . '</span>': ''); ?>
                            </td>
                        </tr>

                        <?php
                        if (ACCOUNT_DOB == 'true') {
                            ?>

                            <tr>
                                <td class="fieldKey"><?php echo ENTRY_DATE_OF_BIRTH; ?></td>
                                <td class="fieldValue"><?php echo tep_draw_input_field('dob', $sc_guest_dob, 'class="text" id="dob"') . '&nbsp;' . (!tep_not_null(ENTRY_DATE_OF_BIRTH_TEXT) ? '<span class="inputRequirement">' . ENTRY_DATE_OF_BIRTH_TEXT . '</span>': ''); ?><script type="text/javascript">$('#dob').datepicker({dateFormat: '<?php echo JQUERY_DATEPICKER_FORMAT; ?>', changeMonth: true, changeYear: true, yearRange: '-100:+0'});</script></td>
                            </tr>

                            <?php
                        }
                        ?>


                    </table>






                    <div id="shipping_address">
                        <table border="0" cellspacing="2" cellpadding="2" width="100%">
                            <?php
                            if (ACCOUNT_STREET_ADDRESS == 'true') {
                                ?>
                                <tr>
                                    <td class="fieldKey"><?php echo ENTRY_STREET_ADDRESS; ?></td>
                                    <td class="fieldValue">
                                        <?php echo tep_draw_input_field('street_address', $sc_guest_street_address, 'class="text"') . '&nbsp;' . (!tep_not_null(ENTRY_STREET_ADDRESS_TEXT) ? '<span class="inputRequirement">' . ENTRY_STREET_ADDRESS_TEXT . '</span>': ''); ?>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                            <?php
                            if (ACCOUNT_SUBURB == 'true') {
                                ?>

                                <tr>
                                    <td class="fieldKey"><?php echo ENTRY_SUBURB; ?></td>
                                    <td class="fieldValue"><?php echo tep_draw_input_field('suburb', $sc_guest_suburb, 'class="text"') . '&nbsp;' . (!tep_not_null(ENTRY_SUBURB_TEXT) ? '<span class="inputRequirement">' . ENTRY_SUBURB_TEXT . '</span>': ''); ?></td>
                                </tr>

                                <?php
                            }
                            ?>
                            <?php
                            if (ACCOUNT_POSTCODE == 'true') {
                                ?>

                                <tr>
                                    <td class="fieldKey"><?php echo ENTRY_POST_CODE; ?></td>
                                    <td class="fieldValue">
                                        <?php echo tep_draw_input_field('postcode', $sc_guest_postcode, 'class="text"') . '&nbsp;' . (!tep_not_null(ENTRY_POST_CODE_TEXT) ? '<span class="inputRequirement">' . ENTRY_POST_CODE_TEXT . '</span>': ''); ?>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                            <?php
                            if (ACCOUNT_CITY == 'true') {
                                ?>
                                <tr>
                                    <td class="fieldKey"><?php echo ENTRY_CITY; ?></td>
                                    <td class="fieldValue">
                                        <?php echo tep_draw_input_field('city', $sc_guest_city, 'class="text"') . '&nbsp;' . (!tep_not_null(ENTRY_CITY_TEXT) ? '<span class="inputRequirement">' . ENTRY_CITY_TEXT . '</span>': ''); ?>
                                        <font color="red">*</font>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                        </table>
                        <div id="shipping_country_box">
                            <div id="shipping_country">

                                <table border="0" cellspacing="2" cellpadding="2" width="100%">
                                    <?php
                                    if (ACCOUNT_COUNTRY == 'true') {
                                        ?>
                                        <tr>
                                            <td class="fieldKey"><?php echo ENTRY_COUNTRY; ?></td>
                                            <td class="fieldValue">
                                                <?php echo tep_get_country_list('country',$selected_country_id, 'onChange="changeselect();"') . '&nbsp;' . (!tep_not_null(ENTRY_COUNTRY_TEXT) ? '<span class="inputRequirement">' . ENTRY_COUNTRY_TEXT . '</span>': ''); ?>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                    ?>

                                </table>
                            </div><!--div end shipping_country -->
                        </div><!--div end shipping_country_box -->
                        <?php
                        if (ACCOUNT_STATE == 'true') {
                            ?>
                            <table border="0" cellspacing="2" cellpadding="2" width="100%">
                                <tr>
                                    <td class="fieldKey"><?php echo ENTRY_STATE; ?></td>
                                    <td class="fieldValue">
                                        <script language="javascript">
                                            <!--
                                            function changeselect(reg) {
//clear select
                                                document.smart_checkout.state.length=0;
                                                var j=0;
                                                for (var i=0;i<zones.length;i++) {
                                                    if (zones[i][0]==document.smart_checkout.country.value) {
                                                        document.smart_checkout.state.options[j]=new Option(zones[i][1],zones[i][1], zones[i][2]);
                                                        j++;
                                                    }
                                                }
                                                if (j==0) {
                                                    document.smart_checkout.state.options[0]=new Option('-','-');
                                                }
                                                if (reg) { document.smart_checkout.state.value = reg; }
                                            }
                                            var zones = new Array(
                                                <?php
                                                $zones_query = tep_db_query("select zone_country_id,zone_id,zone_name from " . TABLE_ZONES . " order by zone_name asc");
                                                $mas=array();
                                                while ($zones_values = tep_db_fetch_array($zones_query)) {
                                                    ($zones_values['zone_id'] == STORE_ZONE) ? $selected = 'true' : $selected = 'false';
                                                    $zones[] = 'new Array('.$zones_values['zone_country_id'].',"'.$zones_values['zone_name'].'",'.$selected.')';
                                                }
                                                echo implode(',',$zones);
                                                ?>
                                            );
                                            document.write('<SELECT NAME="state">');
                                            document.write('</SELECT>');
                                            changeselect("<?php echo tep_db_prepare_input($_POST['state']); ?>");
                                            -->
                                        </script>
                                    </td>
                                </tr>
                            </table>
                            <?php
                        }
                        ?>
                    </div> <!--div end shipping_address -->
                <?php } //end no account ?>
                <?php ################ END Shipping Information - NO ACCOUNT ######################################## ?>

            </div> <!--div end shipping_box -->
        <?php } //END show shipping otpions ?>






        <?php if ($sc_payment_address_show == true) { // hide payment if there is a virtual product because we use shipping address for payment address ?>
            <?php ################ START Payment Information - LOGGED ON ######################################## ?>
            <?php if (tep_session_is_registered('customer_id')) { ?>
                <div id="payment_address_box"  class="sm_layout_box">
                <!-- <h2><?php echo  TABLE_HEADING_BILLING_ADDRESS; ?></h2> -->

                <div>
                    <p><?php echo tep_address_label($customer_id, $billto, true, ' ', '<br />'); ?></p>
                    <p><?php echo '<a href="' . tep_href_link(FILENAME_CHECKOUT_PAYMENT_ADDRESS, '', 'SSL') . '">' . tep_template_image_button('button_change_address.gif', IMAGE_BUTTON_CHANGE_ADDRESS) . '</a>'; ?></p>
                </div>
            <?php } else { //no account ?>
                <?php ################ END Payment Information - LOGGED ON ######################################## ?>


                <?php ################ START Payment Information - NO ACCOUNT ######################################## ?>

                <div id="payment_address_checkbox">
                    <table border="0" cellspacing="2" cellpadding="2" width="100%">
                        <tr style="display:none;">

                            <?php if (($error == '1') && ($payment_address_selected != '1')) { //is not selected - otherwise payment address is same as shipping address ?>

                                <td><?php echo tep_draw_checkbox_field('payment_adress', '1', false, 'id="pay_show"') . '&nbsp;' . (!tep_not_null(ENTRY_NEWSLETTER_TEXT) ? '<span class="inputRequirement">' . ENTRY_NEWSLETTER_TEXT . '</span>': ''). '&nbsp;&nbsp;' . TEXT_SHIPPING_SAME_AS_PAYMENT; ?></td>

                            <?php } else { //is selected ?>

                                <td><?php echo tep_draw_checkbox_field('payment_adress', '1', true, 'id="pay_show"') . '&nbsp;' . (!tep_not_null(ENTRY_NEWSLETTER_TEXT) ? '<span class="inputRequirement">' . ENTRY_NEWSLETTER_TEXT . '</span>': ''). '&nbsp;&nbsp;' . TEXT_SHIPPING_SAME_AS_PAYMENT; ?></td>

                            <?php } ?>

                        </tr>
                    </table>
                </div>



                <div id="payment_address" style="display:none">

                    <table class="table-padding-2">

                        <?php
                        if (ACCOUNT_GENDER == 'true') {
                            if (isset($gender)) {
                                $male = ($gender == 'm') ? true : false;
                                $female = ($gender == 'f') ? true : false;
                            } else {
                                $male = false;
                                $female = false;
                            }
                            ?>



                            <tr>
                                <td class="fieldKey"><?php echo ENTRY_GENDER; ?></td>
                                <td class="fieldValue">

                                    <?php echo tep_draw_radio_field('gender_payment', 'm', $male) . '&nbsp;&nbsp;' . MALE . '&nbsp;&nbsp;' . tep_draw_radio_field('gender_payment', 'f', $female) . '&nbsp;&nbsp;' . FEMALE . '&nbsp;' . (!tep_not_null(ENTRY_GENDER_TEXT) ? '<span class="inputRequirement">' . ENTRY_GENDER_TEXT . '</span>': ''); ?>

                                </td>
                            </tr>

                            <?php
                        }
                        ?>

                        <?php
                        if (ACCOUNT_COMPANY == 'true') {
                            ?>

                            <tr>
                                <td class="fieldKey"><?php echo ENTRY_COMPANY; ?></td>
                                <td class="fieldValue"><?php echo tep_draw_input_field('company_payment', '',  'class="text"') . '&nbsp;' . (!tep_not_null(ENTRY_COMPANY_TEXT) ? '<span class="inputRequirement">' . ENTRY_COMPANY_TEXT . '</span>': ''); ?></td>
                            </tr>

                            <?php
                        }
                        ?>


                        <tr>
                            <td class="fieldKey"><?php echo ENTRY_FIRST_NAME; ?></td>
                            <td class="fieldValue">
                                <?php echo tep_draw_input_field('firstname_payment', '', 'class="text"') . '&nbsp;' . (!tep_not_null(ENTRY_FIRST_NAME_TEXT) ? '<span class="inputRequirement">' . ENTRY_FIRST_NAME_TEXT . '</span>': ''); ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="fieldKey"><?php echo ENTRY_LAST_NAME; ?></td>
                            <td class="fieldValue">
                                <?php echo tep_draw_input_field('lastname_payment', '', 'class="text"') . '&nbsp;' . (!tep_not_null(ENTRY_LAST_NAME_TEXT) ? '<span class="inputRequirement">' . ENTRY_LAST_NAME_TEXT . '</span>': ''); ?>
                            </td>
                        </tr>

                        <?php
                        if (ACCOUNT_STREET_ADDRESS == 'true') {
                            ?>

                            <tr>
                                <td class="fieldKey"><?php echo ENTRY_STREET_ADDRESS; ?></td>
                                <td class="fieldValue">
                                    <?php echo tep_draw_input_field('street_address_payment', '', 'class="text"') . '&nbsp;' . (!tep_not_null(ENTRY_STREET_ADDRESS_TEXT) ? '<span class="inputRequirement">' . ENTRY_STREET_ADDRESS_TEXT . '</span>': ''); ?>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                        <?php
                        if (ACCOUNT_SUBURB == 'true') {
                            ?>

                            <tr>
                                <td class="fieldKey"><?php echo ENTRY_SUBURB; ?></td>
                                <td class="fieldValue"><?php echo tep_draw_input_field('suburb_payment', '', 'class="text"') . '&nbsp;' . (!tep_not_null(ENTRY_SUBURB_TEXT) ? '<span class="inputRequirement">' . ENTRY_SUBURB_TEXT . '</span>': ''); ?></td>
                            </tr>

                            <?php
                        }
                        ?>
                        <?php
                        if (ACCOUNT_POSTCODE == 'true') {
                            ?>
                            <tr>
                                <td class="fieldKey"><?php echo ENTRY_POST_CODE; ?></td>
                                <td class="fieldValue">
                                    <?php echo tep_draw_input_field('postcode_payment', '', 'class="text"') . '&nbsp;' . (!tep_not_null(ENTRY_POST_CODE_TEXT) ? '<span class="inputRequirement">' . ENTRY_POST_CODE_TEXT . '</span>': ''); ?>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                        <?php
                        if (ACCOUNT_CITY == 'true') {
                            ?>
                            <tr>
                                <td class="fieldKey"><?php echo ENTRY_CITY; ?></td>
                                <td class="fieldValue">
                                    <?php echo tep_draw_input_field('city_payment', '', 'class="text"') . '&nbsp;' . (!tep_not_null(ENTRY_CITY_TEXT) ? '<span class="inputRequirement">' . ENTRY_CITY_TEXT . '</span>': ''); ?>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                        <?php
                        if (ACCOUNT_COUNTRY == 'true') {
                            ?>
                            <tr>
                                <td class="fieldKey"><?php echo ENTRY_COUNTRY; ?></td>
                                <td class="fieldValue"><?php echo tep_get_country_list('country_payment',$selected_country_id, 'onChange="changeselectt();"') . '&nbsp;' . (!tep_not_null(ENTRY_COUNTRY_TEXT) ? '<span class="inputRequirement">' . ENTRY_COUNTRY_TEXT . '</span>': ''); ?></td>
                            </tr>
                            <?php
                        }
                        ?>
                        <?php
                        if (ACCOUNT_STATE == 'true') {
                            ?>

                            <tr>
                                <td class="fieldKey"><?php echo ENTRY_STATE;  ?></td>
                                <td class="fieldValue">

                                    <script language="javascript">
                                        <!--
                                        function changeselectt(reg) {
//clear select
                                            document.smart_checkout.state_payment.length=0;
                                            var j=0;
                                            for (var i=0;i<zones.length;i++) {
                                                if (zones[i][0]==document.smart_checkout.country_payment.value) {
                                                    document.smart_checkout.state_payment.options[j]=new Option(zones[i][1],zones[i][1], zones[i][2]);
                                                    j++;
                                                }
                                            }
                                            if (j==0) {
                                                document.smart_checkout.state_payment.options[0]=new Option('-','-');
                                            }
                                            if (reg) { document.smart_checkout.state_payment.value = reg; }
                                        }
                                        var zones = new Array(
                                            <?php
                                            $zones_query = tep_db_query("select zone_country_id,zone_id,zone_name from " . TABLE_ZONES . " order by zone_name asc");
                                            $mas=array();
                                            while ($zones_values = tep_db_fetch_array($zones_query)) {
                                                ($zones_values['zone_id'] == STORE_ZONE) ? $selected = 'true' : $selected = 'false';
                                                $zones[] = 'new Array('.$zones_values['zone_country_id'].',"'.$zones_values['zone_name'].'",'.$selected.')';
                                            }
                                            echo implode(',',$zones);
                                            ?>
                                        );
                                        document.write('<SELECT NAME="state_payment">');
                                        document.write('</SELECT>');
                                        changeselectt("<?php echo tep_db_prepare_input($_POST['state_payment']); ?>");
                                        -->
                                    </script>

                                </td>
                            </tr>

                            <?php
                        }
                        ?>
                    </table>

                </div><!--div end payment_address-->
                </div><!--div end payment_address_box-->
            <?php } //end no account ?>

        <?php } //END hide payment if there is a virtual product because we use shipping address for payment address ?>
        <?php ################ END Payment Information - NO ACCOUNT ######################################## ?>




        <?php if (!tep_session_is_registered('customer_id')) { //IS NOT LOGGED ON ?>
            <?php ################ START Contact Information - NO ACCOUNT ######################################## ?>
            <div id="contact_box" class="sm_layout_box infoBoxContents">

                <!--  <h2><?php echo  CATEGORY_CONTACT; ?></h2> -->


                <table border="0" cellspacing="2" cellpadding="2" width="100%">
                    <tr>
                        <td class="fieldKey"><?php echo ENTRY_EMAIL_ADDRESS; ?></td>
                        <td class="fieldValue">
                            <?php echo tep_draw_input_field('email_address', $sc_guest_email_address, 'class="text"','email',true,true) . '&nbsp;' . (!tep_not_null(ENTRY_EMAIL_ADDRESS_TEXT) ? '<span class="inputRequirement">' . ENTRY_EMAIL_ADDRESS_TEXT . '</span>': ''); ?>
                            <font color="red">*</font>
                        </td>
                    </tr>
                    <?php
                    if (ACCOUNT_TELE == 'true') {
                        ?>
                        <tr>
                            <td class="fieldKey"><?php echo ENTRY_TELEPHONE_NUMBER; ?></td>
                            <td class="fieldValue">
                                <?php echo tep_draw_input_field('telephone', $sc_guest_telephone, 'class="text" pattern=".{17,}"','text',true,true) . '&nbsp;' . (!tep_not_null(ENTRY_TELEPHONE_NUMBER_TEXT) ? '<span class="inputRequirement">' . ENTRY_TELEPHONE_NUMBER_TEXT . '</span>': ''); ?>
                                <font color="red">*</font>
                            </td>
                        </tr>
                        <?php
                    }
                    if (ACCOUNT_FAX=='true'){
                        ?>
                        <tr>
                            <td class="fieldKey"><?php echo ENTRY_FAX_NUMBER; ?></td>
                            <td class="fieldValue"><?php echo tep_draw_input_field('fax', $sc_guest_fax, 'class="text"') . '&nbsp;' . (!tep_not_null(ENTRY_FAX_NUMBER_TEXT) ? '<span class="inputRequirement">' . ENTRY_FAX_NUMBER_TEXT . '</span>': ''); ?></td>
                        </tr>
                        <?php
                    }
                    ?>


                    <!--- extra fields start -->
                    <?php echo tep_get_extra_fields($customer_id,$languages_id);?>
                    <!--- extra fields end -->

                    <tr>
                        <td><?php echo tep_draw_hidden_field('guest', 'guest'); //do we need this??? ?></td>
                    </tr>
                </table>
            </div> <!--div end contact_box -->
            <?php ################ END Contact Information - NO ACCOUNT ######################################## ?>
        <?php } //End IS NOT LOGGED ON ?>


        <div class="line_space"></div>






        <?php ################ START Password - NO ACCOUNT ######################################## ?>
        <?php
        //if ($create_account == true) {
        if (!tep_session_is_registered('customer_id')) { //IS NOT LOGGED ON
            if (($sc_is_virtual_product == true) || ($sc_is_mixed_product == true) || (SC_CREATE_ACCOUNT_REQUIRED == 'true') || (SC_CREATE_ACCOUNT_CHECKOUT_PAGE == 'true')) { ?>
                <div id="password_box"  style="height:1px;padding:0;margin:0">
                    <!--<h2><?php echo  SC_HEADING_CREATE_ACCOUNT; ?></h2>-->

                    <?php
                    if (SC_CREATE_ACCOUNT_REQUIRED == 'true') {
                        echo '<p>' . SC_TEXT_PASSWORD_REQUIRED . '</p>'; //show message that you need to create an account
                    } elseif (($sc_is_virtual_product == true) || ($sc_is_mixed_product == true)) {
                        echo '<p>' . SC_TEXT_VIRTUAL_PRODUCT . '</p>';  //show message that you need to create an account if virtual product
                    }
                    ?>

                    <?php ################ START Password - optional ########################################
                    if (SC_CREATE_ACCOUNT_REQUIRED == 'true') {
                        //show nothing
//} elseif ((SC_CREATE_ACCOUNT_CHECKOUT_PAGE == 'true') && (($sc_is_virtual_product != true) || ($sc_is_mixed_product != true))) {
                    } elseif (SC_CREATE_ACCOUNT_CHECKOUT_PAGE == 'true') {
                        if (($sc_is_virtual_product == true) || ($sc_is_mixed_product == true)) {
                        } else { ?>
                            <div id="password_checkbox">
                                <table border="0" cellspacing="2" cellpadding="2" width="100%">
                                    <tr style="display:block;">

                                        <?php if (($error == '1') && ($password_selected != '1')) { //is not selected ?>

                                            <td><?php
                                                //    	echo tep_draw_checkbox_field('password_checkbox', '1', false, 'id="pw_show"') . '&nbsp;&nbsp;' . TEXT_CREATE_ACCOUNT_OPTIONAL;
                                                echo tep_draw_input_field('password_checkbox','','id="pw_show"','hidden');
                                                ?></td>

                                        <?php } else { //is selected ?>
                                            <td ><?php
                                                //    	echo tep_draw_checkbox_field('password_checkbox', '1', false, 'id="pw_show"') . '&nbsp;&nbsp;' . TEXT_CREATE_ACCOUNT_OPTIONAL;
                                                echo tep_draw_input_field('password_checkbox','','id="pw_show"','hidden');
                                                ?></td>


                                        <?php } ?>

                                    </tr>
                                </table>
                            </div>
                        <?php }
                    } ################ End Password - optional ######################################## ?>


                    <div id="password_fields" style="display:none">
                        <table border="0" cellspacing="2" cellpadding="2" width="100%">
                            <tr>
                                <td class="fieldKey"><?php echo ENTRY_PASSWORD; ?></td>
                                <td class="fieldValue">
                                    <?php echo tep_draw_password_field('password', '', 'class="text"') . '&nbsp;' . (!tep_not_null(ENTRY_PASSWORD_TEXT) ? '<span class="inputRequirement">' . ENTRY_PASSWORD_TEXT . '</span>': ''); ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="fieldKey"><?php echo ENTRY_PASSWORD_CONFIRMATION; ?></td>
                                <td class="fieldValue">
                                    <?php echo tep_draw_password_field('confirmation', '', 'class="text"') . '&nbsp;' . (!tep_not_null(ENTRY_PASSWORD_CONFIRMATION_TEXT) ? '<span class="inputRequirement">' . ENTRY_PASSWORD_CONFIRMATION_TEXT . '</span>': ''); ?>
                                </td>
                            </tr>
                        </table>
                    </div> <!--div end password_fields -->
                </div> <!--div end password_box -->
                <?php
            } //end (($sc_is_virtual_product == true) || ($sc_is_mixed_product == true))
        } //End IS NOT LOGGED ON ?>
        <?php ################ END Password - NO ACCOUNT ######################################## ?>




        <?php ################ START Shipping Modules ######################################## ?>
        <?php if ($sc_shipping_modules_show == true) { //hide shipping modules - used for virtual products ?>

            <?php if ((SC_HIDE_SHIPPING == 'true') && (tep_count_shipping_modules() <= 1)) {
//if 0 or 1 shipping method and in admin hide shipping is set to true, hide shipping box
//but we still need the divs in order to work with jquery update ?>
                <div id="shipping_modules_box">
                    <div id="shipping_options">
                        <!--<p>shipping hidden as only 1 method</p>-->
                    </div>
                </div>

            <?php } //end hide shipping modules
            else { // show shipping modules ?>


                <div id="shipping_modules_box" class="sm_layout_box infoBoxContents">
                    <div id="shipping_options">
                        <?php
                        if (tep_count_shipping_modules() > 0) {
                            ?>



                            <h2><?php echo  TABLE_HEADING_SHIPPING_METHOD; ?></h2>


                            <?php
                            if (sizeof($quotes) > 1 && sizeof($quotes[0]) > 1) {
                                ?>

                                <div class="contentText">
                                    <div style="float: right;">
                                        <?php echo '<h5>' . TITLE_PLEASE_SELECT . '</h5>'; ?>
                                    </div>

                                    <p><?php echo TEXT_CHOOSE_SHIPPING_METHOD; ?></p>
                                </div>

                                <?php
                            } elseif ($free_shipping == false) {
                                ?>


                                <p><?php echo TEXT_ENTER_SHIPPING_INFORMATION; ?></p>


                                <?php
                            }
                            ?>

                            <table class="table-padding-2">

                                <?php
                                if ($free_shipping == true) {
                                    ?>

                                    <tr>
                                        <td><b><?php echo FREE_SHIPPING_TITLE; ?></b>&nbsp;<?php echo $quotes[$i]['icon']; ?></td>
                                    </tr>
                                    <tr id="defaultSelected" class="moduleRowSelected" onMouseOver="rowOverEffect(this)" onMouseOut="rowOutEffect(this)" onClick="selectRowEffect(this, 0)">
                                        <td style="padding-left: 15px;"><?php echo sprintf(FREE_SHIPPING_DESCRIPTION, $currencies->format(MODULE_ORDER_TOTAL_SHIPPING_FREE_SHIPPING_OVER)) . tep_draw_hidden_field('f_shipping', 'free_free'); ?></td>
                                    </tr>

                                    <?php
                                } else {
                                    $radio_buttons = 0;
                                    for ($i=0, $n=sizeof($quotes); $i<$n; $i++) {
                                        ?>

                                        <tr>
                                            <td colspan="3"><b><?php echo $quotes[$i]['module']; ?></b>&nbsp;<?php if (isset($quotes[$i]['icon']) && tep_not_null($quotes[$i]['icon'])) { echo $quotes[$i]['icon']; } ?></td>
                                        </tr>

                                        <?php


                                        if (isset($quotes[$i]['error'])) {
                                            ?>

                                            <tr>
                                                <td colspan="3"><span class="errorText"><?php echo $quotes[$i]['error']; ?></span></td>
                                            </tr>

                                            <?php

                                        } else {
                                            for ($j=0, $n2=sizeof($quotes[$i]['methods']); $j<$n2; $j++) {
// set the radio button to be checked if it is the method chosen
                                                $checked = (($quotes[$i]['id'] . '_' . $quotes[$i]['methods'][$j]['id'] == $shipping['id']) ? true : false);
                                                if ($quotes[$i]['methods'][$j]['id']=='tk'){$classAdd='tk';}else{$classAdd='';}
                                                if ( ($checked == true) || ($n == 1 && $n2 == 1) ) {
                                                    echo '      <tr rel="'.$classAdd.'" id="defaultSelected" class="moduleRowSelected" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="selectRowEffect(this, ' . $radio_buttons . ')">' . "\n";
                                                } else {
                                                    echo '      <tr rel="'.$classAdd.'"  class="moduleRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="selectRowEffect(this, ' . $radio_buttons . ')">' . "\n";
                                                }
                                                ?>

                                                <td <?php if($quotes[$i]['methods'][$j]['id']<>'tk'){ ?>
                                                    width="75%"
                                                <?php }else{ echo ' colspan="3"';}?> style="padding-left: 15px;">
                                                    <?php echo $quotes[$i]['methods'][$j]['title']; ?>
                                                    <?php if($quotes[$i]['methods'][$j]['id']=='tk'){
                                                        echo tep_draw_radio_field('f_shipping', $quotes[$i]['id'] . '_' . $quotes[$i]['methods'][$j]['id'], $checked,' style="visibility:hidden;"','',true);
                                                    }
                                                    if (isset($quotes[$i]['methods'][$j]['addon'])){echo $quotes[$i]['methods'][$j]['addon'];}
                                                    ?>

                                                </td>

                                                <?php
                                                if ( ($n > 1) || ($n2 > 1) ) {


                                                    ?>

                                                    <?php
                                                    if ($quotes[$i]['methods'][$j]['id']<>'tk'){
                                                        echo '<td class="product_price">';
                                                        echo $quotes[$i]['methods'][$j]['cost'] . ' руб.' ;
                                                        echo '</td>';
                                                    }
                                                    ?>
                                                    <?php
                                                    if ($quotes[$i]['methods'][$j]['id']<>'tk'){
                                                        echo '<td align="right">';
                                                        echo tep_draw_radio_field('f_shipping', $quotes[$i]['id'] . '_' . $quotes[$i]['methods'][$j]['id'], $checked,'');
                                                        echo '</td>';
                                                    }else{
//        	echo tep_draw_radio_field('f_shipping', $quotes[$i]['id'] . '_' . $quotes[$i]['methods'][$j]['id'], $checked);
//        	echo tep_draw_radio_field('f_shipping', $quotes[$i]['id'] . '_' . $quotes[$i]['methods'][$j]['id'], $checked,' style="visibility:hidden;"');
                                                    }

                                                    ?></td>

                                                    <?php
                                                } else {

                                                    ?>

                                                    <td class="product_price" align="right" colspan="2"><?php echo $currencies->format(tep_add_tax($quotes[$i]['methods'][$j]['cost'], (isset($quotes[$i]['tax']) ? $quotes[$i]['tax'] : 0))) . tep_draw_hidden_field('f_shipping', $quotes[$i]['id'] . '_' . $quotes[$i]['methods'][$j]['id']); ?></td>

                                                    <?php
                                                }
                                                ?>

                                                </tr>

                                                <?php
                                                $radio_buttons++;
                                            }
                                        }
                                    }
                                }
                                ?>

                            </table>




                            <?php
                        } //end (tep_count_shipping_modules()
                        ?>
                    </div> <!--div end shipping_options-->
                </div> <!--div end shipping_modules_box -->
                <?php
            } // end hide shipping
            ?>
        <?php } //END hide shipping modules - used for virtual products ?>
        <?php ################ END Shipping Modules ######################################## ?>
        <div style="display:none" id="ajax_loader"><img style="width:100%;height:10px;" src="<?=DIR_WS_TEMPLATES.TEMPLATE_NAME;?>/images/ajax-loader.gif"></div>
		
        <?php require(DIR_WS_CONTENT.'checkout.payment.tpl.php');?>
        <?php ################ START Comment box ######################################## ?>
        <?php if (SC_HIDE_COMMENT != 'true') { ?>
            <div id="comment_box" class="sm_layout_box infoBoxContents">
                <h2><?php echo  TABLE_HEADING_COMMENTS; ?></h2>

                <div class="contentText" style="display: table;width:100%; overflow: hidden;">
                    <?php echo tep_draw_textarea_field('comments', '', '60', '5', $comments); ?>
                </div>
            </div><!--div end comment_box-->
        <?php } ?>
        <?php ################ END Comment box ######################################## ?>




        <?php ################ START Order Total Modules ######################################## ?>
        <div id="order_total_modules" class="sm_layout_box" style="display:none">
            <h2><?php echo  HEADING_TOTAL; ?></h2>
            <div class="contentText">
                <div style="float: right;">
                    <table border="0" cellspacing="0" cellpadding="2">

                        <?php
                        if (MODULE_ORDER_TOTAL_INSTALLED) {
                            echo $order_total_modules->output();
                        }
                        ?>
                    </table>
                </div>
            </div>
            <p>&nbsp;</p>
        </div><!--div end order_total_modules -->
        <?php ################ END Order Total Modules ######################################## ?>

        <div class="line_space"></div>

        <?php
        if (is_array($payment_modules->modules)) {
            //  echo $payment_modules->process_button();
        }



        // echo tep_draw_button(IMAGE_BUTTON_CONFIRM_ORDER, 'check', null, 'primary');
        ?>
        <div id="confirm_order">
            <div class="buttonSet sm_layout_box infoBoxContents">
                <div class="buttonAction">
                    <div class="confirm-buttons">
                    <?php
                    if (SC_CONFIRMATION_PAGE == 'true') { //got to confimration page
                        echo tep_template_image_submit('button_continue.gif', IMAGE_BUTTON_CONTINUE);
                    } else { //order now
                        echo tep_template_image_submit('button_confirm_order.gif', IMAGE_BUTTON_CONFIRM_ORDER,' style="float:right" ');
                    }  ?></div>
                    <div class="clearfix"></div>
                    <p align="right">Отправляя форму, я даю согласие на <a href="https://yourfish.ru/information.php/pages_id/11">обработку персональных данных.</a></p>


                    </div>
            </div>
        </div>

        </form>
    </div><!-- Div end checkout -->
</div><!-- Div end checkout_container -->
<div hidden> 
<?php 
//var_dump($_SESSION);
?>
</div>

<!-- body_eof //-->