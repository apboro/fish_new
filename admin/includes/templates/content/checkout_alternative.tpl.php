<table border="0" width="100%" cellspacing="0" cellpadding="<?php echo CELLPADDING_SUB;?>">
<?php 
// Set number of columns in listing
define ('NR_COLUMNS', 2);?>
<?php
// BOF: Lango Added for template MOD
if (SHOW_HEADING_TITLE_ORIGINAL == 'yes') {
$header_text = '&nbsp;'
//EOF: Lango Added for template MOD
?>
      <tr> 
        <td width="100%"><table class="table-padding-0">
          <tr>
            <td class="pageHeading"><?php echo HEADING_TITLES; ?></td>
            <td align="right"><?php echo tep_image(DIR_WS_TEMPLATES . TEMPLATE_NAME . '/images/content/checkout.gif', HEADING_TITLES, HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?></td>
          </tr>
        </table></td> 
      </tr>
<?php
// BOF: Lango Added for template MOD
}else{
$header_text = HEADING_TITLE;
}
// EOF: Lango Added for template MOD
?>

<?php
// BOF: Lango Added for template MOD
if (MAIN_TABLE_BORDER == 'yes'){
table_image_border_top(false, false, $header_text);
}
// EOF: Lango Added for template MOD
?>

      <tr>
        <td><table class="table-padding-2">
          <tr>

<!-- body_text //-->
    <td width="100%" valign="top"><?php echo tep_draw_form('checkout', tep_href_link(FILENAME_CHECKOUT_ALTERNATIVE, '', 'SSL'), 'post','onSubmit="return check_form(checkout);"') . tep_draw_hidden_field('action', 'process'); ?>
      <table class="table-padding-0">

<?php
  if ($messageStack->size('login') > 0) {

?>
      <tr>
        <td><?php echo $messageStack->output('login'); ?></td>
      </tr>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
<?php
  }
?>

      <tr>
            <td class="main"><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>

      <tr>
        <td valign="top"><table class="table-padding-2">
          <tr>
            <td class="main"><b><?php echo TITLE_FORM; ?></b></td>
          </tr>
        </table></td>
      </tr>
           <tr>
                <td width="100%" class="main"><?php echo TEXT_GREETING; ?></td>
           </tr>

 <?php
  ///*********************************** PRODUCTS MODULE START**************************//////
?>
       <tr>

        <td><table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBox">

          <tr class="infoBoxContents">
            <td width="100%" valign="top"><table class="table-padding-0">

              <tr>
                <td><table class="table-padding-2">
                  <tr>
                    <td class="main" colspan="3"><?php echo '<b>' . HEADING_PRODUCTS . '</b> <a href="' . tep_href_link(FILENAME_SHOPPING_CART) . '"><span class="orderEdit">(' . TEXT_EDIT . ')</span></a>'; ?></td>
                  </tr>

      <tr>
        <td>
<?php

    $info_box_contents = array();
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
          echo tep_draw_hidden_field('id[' . $products[$i]['id'] . '][' . $option . ']', $value);
          $attributes = tep_db_query("select popt.products_options_name, poval.products_options_values_name, pa.options_values_price, pa.price_prefix
                                      from " . TABLE_PRODUCTS_OPTIONS . " popt, " . TABLE_PRODUCTS_OPTIONS_VALUES . " poval, " . TABLE_PRODUCTS_ATTRIBUTES . " pa
                                      where pa.products_id = '" . $products[$i]['id'] . "'
                                       and pa.options_id = '" . $option . "'
                                       and pa.options_id = popt.products_options_id
                                       and pa.options_values_id = '" . $value . "'
                                       and pa.options_values_id = poval.products_options_values_id
                                       and popt.language_id = '" . $languages_id . "'
                                       and poval.language_id = '" . $languages_id . "'");
          $attributes_values = tep_db_fetch_array($attributes);

          $products[$i][$option]['products_options_name'] = $attributes_values['products_options_name'];
          $products[$i][$option]['options_values_id'] = $value;
          $products[$i][$option]['products_options_values_name'] = $attributes_values['products_options_values_name'];
          $products[$i][$option]['options_values_price'] = $attributes_values['options_values_price'];
          $products[$i][$option]['price_prefix'] = $attributes_values['price_prefix'];
        }
      }
    }

    for ($i=0, $n=sizeof($products); $i<$n; $i++) {
      if (($i/2) == floor($i/2)) {
        $info_box_contents[] = array('params' => 'class="productListing-even"');
      } else {
        $info_box_contents[] = array('params' => 'class="productListing-odd"');
      }

      $cur_row = sizeof($info_box_contents) - 1;

     $products_name = '<table border="0" cellspacing="2" cellpadding="2">' .
                       '  <tr>' .
                       '    <td class="productListing-data" align="center"><a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $products[$i]['id']) . '">' . tep_image(DIR_WS_IMAGES . $products[$i]['image'], $products[$i]['name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT) . '</a></td>' .
                       '    <td class="productListing-data" valign="center"><a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $products[$i]['id']) . '"><b>' . $products[$i]['name'] . '</b></a>';

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
          $products_name .= '<br><small><i> - ' . $products[$i][$option]['products_options_name'] . ' ' . $products[$i][$option]['products_options_values_name'] . '</i></small>';
        }
      }

      $products_name .= '    </td>' .
                        '  </tr>' .
                        '</table>';

      $info_box_contents[$cur_row][] = array('params' => 'class="productListing-data" valign="center"',
                                             'text' => $products_name);

      $info_box_contents[$cur_row][] = array('align' => 'center',
                                             'params' => 'class="productListing-data" valign="center"',
                                             'text' => tep_draw_input_field('cart_quantity[]', $products[$i]['quantity'], 'size="4" disabled="true"') . tep_draw_hidden_field('products_id[]', $products[$i]['id']));

      $info_box_contents[$cur_row][] = array('align' => 'right',
                                             'params' => 'class="productListing-data" valign="center"',
                                             'text' => '<b>' . $currencies->display_price($products[$i]['final_price'], tep_get_tax_rate($products[$i]['tax_class_id']), $products[$i]['quantity']) . '</b>');
    }

    new productListBox($info_box_contents);
?>
</td>
</tr>

        <tr>
                 <td width="100%"  class="infoBoxContents" align="right"><b><font class="infoBoxContents"><?php echo TITLE_TOTAL; ?></font> <?php echo  $currencies->format($cart->show_total());?></b></td>
       </tr>

            </table></td>
              </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>


 <?php
  ///*********************************** PRODUCTS MODULE END**************************//////
?>

<?php

    if ($order->content_type == 'virtual_weight' || $order->content_type == 'virtual') {
      tep_session_register('shipping');
      $shipping = false;
      $sendto = false;
   }
   
    if ($order->content_type == 'physical') {
  ///*********************************** SHIPING MODULE START**************************//////
?>


<?php
  $total_weight = $cart->show_weight();
  $total_count = $cart->count_contents();

// load all enabled shipping modules

  //if (!tep_session_is_registered('cartID')) tep_session_register('cartID');
  $cartID = $cart->cartID;
    if ($order->content_type == 'virtual') {
    //if (!tep_session_is_registered('shipping')) tep_session_register('shipping');
    $shipping = false;
    $sendto = false;
  }
// get all available shipping quotes
  $quotes = $shipping_modules->quote();

   if ( !tep_session_is_registered('shipping') || ( tep_session_is_registered('shipping') && ($shipping == false) && (tep_count_shipping_modules() > 1) ) ) $shipping = $shipping_modules->cheapest();
  ?>
  <tr>
        <td><br><table class="table-padding-2">
          <tr>
            <td class="main"><b><?php echo TABLE_HEADING_SHIPPING_METHOD; ?></b></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBox">
          <tr class="infoBoxContents">
            <td><table class="table-padding-2">
<?php
    if (sizeof($quotes) > 1 && sizeof($quotes[0]) > 1) {
?>
              <tr>
                <td><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
                <td class="main" width="50%" valign="top"><?php echo TEXT_CHOOSE_SHIPPING_METHOD; ?></td>
                <td class="main" width="50%" valign="top" align="right"><?php echo '<b>' . TITLE_PLEASE_SELECT . '</b><br>' . tep_image(DIR_WS_IMAGES . 'arrow_east_south.gif'); ?></td>
                <td><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
              </tr>
<?php
    } elseif ($free_shipping == false) {
?>
              <tr>
                <td><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
                <td class="main" width="100%" colspan="2"><?php echo TEXT_ENTER_SHIPPING_INFORMATION; ?></td>
                <td><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
              </tr>
<?php
    }

    if ($free_shipping == true) {
?>
              <tr>
                <td><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
                <td colspan="2" width="100%"><table class="table-padding-2">
                  <tr>
                    <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
                    <td class="main" colspan="3"><b><?php echo FREE_SHIPPING_TITLE; ?></b>&nbsp;<?php echo $quotes[$i]['icon']; ?></td>
                    <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
                  </tr>
                  <tr id="defaultSelected" class="moduleRowSelected" onmouseover="rowOverEffect1(this)" onmouseout="rowOutEffect1(this)" onclick="selectRowEffect1(this, 0)">
                    <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
                    <td class="main" width="100%"><?php echo sprintf(FREE_SHIPPING_DESCRIPTION, $currencies->format(MODULE_ORDER_TOTAL_SHIPPING_FREE_SHIPPING_OVER)) . tep_draw_hidden_field('shipping', 'free_free'); ?></td>
                    <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
                  </tr>
                </table></td>
                <td><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
              </tr>
<?php
    } else {
      $radio_buttons = 0;
      for ($i=0, $n=sizeof($quotes); $i<$n; $i++) {
?>
              <tr>
                <td><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
                <td colspan="2"><table class="table-padding-2">
                  <tr>
                    <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
                    <td class="main" colspan="3"><b><?php echo $quotes[$i]['module']; ?></b>&nbsp;<?php if (isset($quotes[$i]['icon']) && tep_not_null($quotes[$i]['icon'])) { echo $quotes[$i]['icon']; } ?></td>
                    <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
                  </tr>
<?php
        if (isset($quotes[$i]['error'])) {
?>
                  <tr>
                    <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
                    <td class="main" colspan="3"><?php echo $quotes[$i]['error']; ?></td>
                    <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
                  </tr>
<?php
        } else {
          for ($j=0, $n2=sizeof($quotes[$i]['methods']); $j<$n2; $j++) {
// set the radio button to be checked if it is the method chosen
            $checked = (($quotes[$i]['id'] . '_' . $quotes[$i]['methods'][$j]['id'] == $shipping['id']) ? true : false);

            if ( ($checked == true) || ($n == 1 && $n2 == 1) ) {
              echo '                  <tr id="defaultSelected" class="moduleRowSelected" onmouseover="rowOverEffect1(this)" onmouseout="rowOutEffect1(this)" onclick="selectRowEffect1(this, ' . $radio_buttons . ')">' . "\n";
            } else {
              echo '                  <tr class="moduleRow" onmouseover="rowOverEffect1(this)" onmouseout="rowOutEffect1(this)" onclick="selectRowEffect1(this, ' . $radio_buttons . ')">' . "\n";
            }
?>
                    <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
                    <td class="main" width="75%"><?php echo $quotes[$i]['methods'][$j]['title']; ?></td>
<?php
            if ( ($n > 1) || ($n2 > 1) ) {
?>
                    <td class="main"><?php echo $currencies->format(tep_add_tax($quotes[$i]['methods'][$j]['cost'], (isset($quotes[$i]['tax']) ? $quotes[$i]['tax'] : 0))); ?></td>
                    <td class="main" align="right"><?php echo tep_draw_radio_field('shipping', $quotes[$i]['id'] . '_' . $quotes[$i]['methods'][$j]['id'], $checked); ?></td>
<?php
            } else {
?>
                    <td class="main" align="right" colspan="2"><?php echo $currencies->format(tep_add_tax($quotes[$i]['methods'][$j]['cost'], $quotes[$i]['tax'])) . tep_draw_hidden_field('shipping', $quotes[$i]['id'] . '_' . $quotes[$i]['methods'][$j]['id']); ?></td>
<?php
            }
?>
                    <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
                  </tr>
<?php
            $radio_buttons++;
          }
        }
?>
                </table></td>
                <td><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
              </tr>
<?php
      }
    }
?>

                </table></td>
              </tr>
            </table></td>
          </tr>

<?php
} 
  ///*********************************** SHIPING MODULE END**************************//////
?>

<?php
  ///*********************************** PAYMENT MODULE START**************************//////
?>

     <tr>
        <td><br><table class="table-padding-2">
          <tr>
            <td class="main"><b><?php echo TABLE_HEADING_PAYMENT_METHOD; ?></b></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBox">
          <tr class="infoBoxContents">
            <td><table class="table-padding-2">
<?php
  $selection = $payment_modules->selection();
  if (sizeof($selection) > 1) {
?>
              <tr>
                <td><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
                <td class="main" width="50%" valign="top"><?php echo TEXT_SELECT_PAYMENT_METHOD; ?></td>
                <td class="main" width="50%" valign="top" align="right"><b><?php echo TITLE_PLEASE_SELECT; ?></b><br><?php echo tep_image(DIR_WS_IMAGES . 'arrow_east_south.gif'); ?></td>
                <td><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
              </tr>
<?php
  } else {
?>
              <tr>
                <td><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
                <td class="main" width="100%" colspan="2"><?php echo TEXT_ENTER_PAYMENT_INFORMATION; ?></td>
                <td><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
              </tr>
<?php
  }

  $radio_buttons = 0;
  for ($i=0, $n=sizeof($selection); $i<$n; $i++) {
?>
              <tr>
                <td><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
                <td colspan="2"><table class="table-padding-2">
<?php
    if ( ($selection[$i]['id'] == $payment) || ($n == 1) ) {
      echo '                  <tr id="defaultSelected" class="moduleRowSelected" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="selectRowEffect(this, ' . $radio_buttons . ')">' . "\n";
    } else {
      echo '                  <tr class="moduleRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="selectRowEffect(this, ' . $radio_buttons . ')">' . "\n";
    }
?>
                    <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
                    <td class="main" colspan="3"><?php echo $selection[$i]['icon']; ?> <b><?php echo $selection[$i]['module']; ?></b></td>
                    <td class="main" align="right">
<?php
    if (sizeof($selection) > 1) {
      echo tep_draw_radio_field('payment', $selection[$i]['id'], ($selection[$i]['id'] == $selection[0]['id'])); 
    } else {
      echo tep_draw_hidden_field('payment', $selection[$i]['id']);
    }
?>
                    </td>
                    <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
                  </tr>
<?php
    if (isset($selection[$i]['error'])) {
?>
                  <tr>
                    <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
                    <td class="main" colspan="4"><?php echo $selection[$i]['error']; ?></td>
                    <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
                  </tr>
<?php
    } elseif (isset($selection[$i]['fields']) && is_array($selection[$i]['fields'])) {
?>
                  <tr>
                    <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
                    <td colspan="4"><table border="0" cellspacing="0" cellpadding="2">
<?php
      for ($j=0, $n2=sizeof($selection[$i]['fields']); $j<$n2; $j++) {
?>
                      <tr>
                        <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
                        <td class="main"><?php echo $selection[$i]['fields'][$j]['title']; ?></td>
                        <td><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
                        <td class="main"><?php echo $selection[$i]['fields'][$j]['field']; ?></td>
                        <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
                      </tr>
<?php
      }
?>
                    </table></td>
                    <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
                  </tr>
<?php
    }
?>
                </table></td>
                <td><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
              </tr>
<?php
    $radio_buttons++;
  }
?>
            </table></td>
          </tr>
        </table></td>
       </tr>

<?php
  ///*********************************** PAYMENT MODULE END**************************//////
?>

<?php
  ///*********************************** CUSTOMERS MODULE START**************************//////
?>
    <tr>
        <td><br><table class="table-padding-2">
          <tr>
            <td class="main"><b><?php echo TABLE_HEADING_COMMENTS; ?></b></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBox">
          <tr class="infoBoxContents">
            <td><table class="table-padding-2">
              <tr>
                <td><?php echo tep_draw_textarea_field('comments', 'soft', '60', '5'); ?></td>
              </tr>
            </table></td>
          </tr>
        </table></td>
        </tr>


      <tr>
        <td><br><table class="table-padding-2">
          <tr>
            <td class="main"><b><?php echo TITLE_PAYMENT_ADDRESS; ?></b></td>
           <td class="inputRequirement" align="right"><?php echo FORM_REQUIRED_INFORMATION; ?></td>
          </tr>

        </table></td>
      </tr>
<?php
if (ACCOUNT_STREET_ADDRESS == 'true') {
?>
      <tr>
        <td><table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBox">
          <tr class="infoBoxContents">
            <td><table border="0" cellspacing="2" cellpadding="2" align="right">
        <tr>
               <td class = "infoBoxContents"><?php echo PAYMENT_SHIPMENT; ?></td>
               <td class = "infoBoxContents"><img class="collapse" src="images/collapse_tcat.gif" alt=""></td>
                    </tr>
                    </table></td>
          </tr>
        </table></td>
      </tr>
<?php
}
?>

      <tr>
        <td><table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBox">
          <tr class="infoBoxContents">
            <td><table border="0" cellspacing="2" cellpadding="2">
        <tr>
              <td class="infoBoxContents"><?php echo ENTRY_FIRST_NAME; ?></td>
              <td class="infoBoxContents"><?php echo tep_draw_input_field('firstname','','') . '&nbsp;' . (tep_not_null(ENTRY_FIRST_NAME_TEXT) ? '<span class="inputRequirement">' . ENTRY_FIRST_NAME_TEXT . '</span>': ''); ?></td>
        </tr>
        <tr>
              <td class="infoBoxContents"><?php echo ENTRY_LAST_NAME; ?></td>
              <td class="infoBoxContents"><?php echo tep_draw_input_field('lastname','','') . '&nbsp;' . (tep_not_null(ENTRY_LAST_NAME_TEXT) ? '<span class="inputRequirement">' . ENTRY_LAST_NAME_TEXT . '</span>': ''); ?></td>
        </tr>
<?php
if (ACCOUNT_STREET_ADDRESS == 'true') {
?>
        <tr>
              <td class="infoBoxContents"><?php echo ENTRY_STREET_ADDRESS; ?></td>
              <td class="infoBoxContents"><?php echo tep_draw_input_field('street_address','','') . '&nbsp;' . (tep_not_null(ENTRY_STREET_ADDRESS_TEXT) ? '<span class="inputRequirement">' . ENTRY_STREET_ADDRESS_TEXT . '</span>': ''); ?></td>
        </tr>
<?php
  }
?>
<?php
  if (ACCOUNT_POSTCODE == 'true') {
?>
        <tr>
                <td class="infoBoxContents"><?php echo ENTRY_POST_CODE; ?></td>
                <td class="infoBoxContents"><?php echo tep_draw_input_field('postcode') . '&nbsp;' . (tep_not_null(ENTRY_POST_CODE_TEXT) ? '<span class="inputRequirement">' . ENTRY_POST_CODE_TEXT . '</span>': ''); ?></td>
        </tr>
<?php
  }
?>
<?php
  if (ACCOUNT_CITY == 'true') {
?>
        <tr>
              <td class="infoBoxContents"><?php echo ENTRY_CITY; ?></td>
              <td class="infoBoxContents"><?php echo tep_draw_input_field('city','','') . '&nbsp;' . (tep_not_null(ENTRY_CITY_TEXT) ? '<span class="inputRequirement">' . ENTRY_CITY_TEXT . '</span>': ''); ?></td>
        </tr>
<?php
  }
?>
<?php
  if (ACCOUNT_COUNTRY == 'true') {
?>
              <tr>
                <td class="main"><?php echo ENTRY_COUNTRY; ?></td>
                <td class="main"><?php echo tep_get_country_list('country',STORE_COUNTRY, 'onChange="changeselect();"') . '&nbsp;' . (tep_not_null(ENTRY_COUNTRY_TEXT) ? '<span class="inputRequirement">' . ENTRY_COUNTRY_TEXT . '</span>': ''); ?></td>
              </tr>
<?php
  }
?>
<?php
if (ACCOUNT_STATE == 'true') {
?>
             <tr>
               <td class="main"><?php echo ENTRY_STATE;?></td>
               <td class="main">
<script language="javascript">
<!--
function changeselect(reg) {
//clear select
    document.checkout.state.length=0;
    var j=0;
    for (var i=0;i<zones.length;i++) {
      if (zones[i][0]==document.checkout.country.value) {
   document.checkout.state.options[j]=new Option(zones[i][1],zones[i][1]);
   j++;
   }
      }
    if (j==0) {
      document.checkout.state.options[0]=new Option('-','-');
      }
    if (reg) { document.checkout.state.value = reg; }
}
   var zones = new Array(
   <?php
       $zones_query = tep_db_query("select zone_country_id,zone_name from " . TABLE_ZONES . " order by zone_name asc");
       $mas=array();
       while ($zones_values = tep_db_fetch_array($zones_query)) {
         $zones[] = 'new Array('.$zones_values['zone_country_id'].',"'.$zones_values['zone_name'].'")';
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
<?php
}
?>
<?php
  if (ACCOUNT_TELE == 'true') {
?>
        <tr>
              <td class="infoBoxContents"><?php echo ENTRY_TELEPHONE_NUMBER; ?></td>
              <td class="infoBoxContents"><?php echo tep_draw_input_field('telephone','','') . '&nbsp;' . (tep_not_null(ENTRY_TELEPHONE_NUMBER_TEXT) ? '<span class="inputRequirement">' . ENTRY_TELEPHONE_NUMBER_TEXT . '</span>': ''); ?></td>
        </tr>
<?php
  }
?>
        <tr>
              <td class="infoBoxContents"><?php echo ENTRY_EMAIL_ADDRESS; ?></td>
              <td class="infoBoxContents"><?php echo tep_draw_input_field('email_address') . '&nbsp;' . (tep_not_null(ENTRY_EMAIL_ADDRESS_TEXT) ? '<span class="inputRequirement">' . ENTRY_EMAIL_ADDRESS_TEXT . '</span>': ''); ?></td>
       </tr>
       <tr>
              <td class="main"><?php echo ENTRY_PASSWORD; ?></td>
              <td class="main"><?php echo tep_draw_password_field('password') . '&nbsp;' . (tep_not_null(ENTRY_PASSWORD_TEXT) ? '<span class="inputRequirement">' . ENTRY_PASSWORD_TEXT . '</span>': ''); ?></td>
       </tr>
       <tr>
               <td class="main"><?php echo ENTRY_PASSWORD_CONFIRMATION; ?></td>
               <td class="main"><?php echo tep_draw_password_field('confirmation') . '&nbsp;' . (tep_not_null(ENTRY_PASSWORD_CONFIRMATION_TEXT) ? '<span class="inputRequirement">' . ENTRY_PASSWORD_CONFIRMATION_TEXT . '</span>': ''); ?></td>
       </tr>
              </table></td>
              </tr>
            </table></td>
          </tr>

<!--- extra fields start -->
     <tr>
             <td>
       <?php echo tep_get_extra_fields($customer_id,$languages_id);?>
      </td>
    </tr>
<!--- extra fields end -->

<?php
if (ACCOUNT_STREET_ADDRESS == 'true') {
?>

                 <tr>
        <td><table border="0" width="100%" cellspacing="1" cellpadding="2">
                    <TBODY id=collapseobj_forumbit_1>
                      <TD class=alt2 noWrap>
                      <table border="0" width="100%" cellspacing="1" cellpadding="2">
                          <TBODY>

       <tr>
        <td><table class="table-padding-2">
          <tr>
            <td class="main"><b><?php echo TITLE_SHIPPING_ADDRESS; ?></b></td>
          </tr>
        </table></td>
      </tr>

       <tr>
        <td><table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBox">
          <tr class="infoBoxContents">
            <td><table class="table-padding-2">


       <tr>
               <td class="infoBoxContents"><?php echo ENTRY_FIRST_NAME; ?></td>
               <td class = "infoBoxContents"><input type="text" name="ShipFirstName" value="<?php echo $FirstName; ?>" size="20"></td>
       </tr>
       <tr>
               <td class="infoBoxContents"><?php echo ENTRY_LAST_NAME; ?></td>
               <td class = "infoBoxContents"><input name="ShipLastName" value="<?php echo $LastName; ?>" size="20"></td>
       </tr>
<?php
if (ACCOUNT_STREET_ADDRESS == 'true') {
?>
       <tr>
               <td class="infoBoxContents"><?php echo ENTRY_STREET_ADDRESS; ?></td>
               <td class = "infoBoxContents"><tt><font size="2"><input name="ShipAddress" value="<?php echo $ShipAddress; ?>" size="20"></font></tt></td>
       </tr>
<?php
  }
?>
<?php
  if (ACCOUNT_POSTCODE == 'true') {
?>
       <tr>
                <td class="infoBoxContents"><?php echo ENTRY_POST_CODE; ?></td>
                <td class="infoBoxContents"><?php echo tep_draw_input_field('shippostcode') ; ?></td>
       </tr>
<?php
  }
?>
<?php
  if (ACCOUNT_CITY == 'true') {
?>
       <tr>
               <td class="infoBoxContents"><?php echo ENTRY_CITY; ?></td>
               <td class = "infoBoxContents"><INPUT TYPE="text" NAME="ShipCity" VALUE="<?php echo $City; ?>"></td>
       </tr>
<?php
  }
?>
<?php
  if (ACCOUNT_COUNTRY == 'true') {
?>
              <tr>
                <td class="main"><?php echo ENTRY_COUNTRY; ?></td>
                <td class="main"><?php echo tep_get_country_list('shipcountry',STORE_COUNTRY, 'onChange="changeselectt();"') . '&nbsp;' . (tep_not_null(ENTRY_COUNTRY_TEXT) ? '<span class="inputRequirement">' . ENTRY_COUNTRY_TEXT . '</span>': ''); ?></td>
              </tr>
<?php
  }
?>
<?php
if (ACCOUNT_STATE == 'true') {
?>
             <tr>
               <td class="main"><?php echo ENTRY_STATE;?></td>
               <td class="main">
<script language="javascript">
<!--
function changeselectt(reg) {
//clear select
    document.checkout.shipstate.length=0;
    var j=0;
    for (var i=0;i<zones.length;i++) {
      if (zones[i][0]==document.checkout.shipcountry.value) {
   document.checkout.shipstate.options[j]=new Option(zones[i][1],zones[i][1]);
   j++;
   }
      }
    if (j==0) {
      document.checkout.shipstate.options[0]=new Option('-','-');
      }
    if (reg) { document.checkout.shipstate.value = reg; }
}
   var zones = new Array(
   <?php
       $zones_query = tep_db_query("select zone_country_id,zone_name from " . TABLE_ZONES . " order by zone_name asc");
       $mas=array();
       while ($zones_values = tep_db_fetch_array($zones_query)) {
         $zones[] = 'new Array('.$zones_values['zone_country_id'].',"'.$zones_values['zone_name'].'")';
       }
       echo implode(',',$zones);
       ?>
       );
document.write('<SELECT NAME="shipstate">');
document.write('</SELECT>');
changeselectt("<?php echo tep_db_prepare_input($_POST['shipstate']); ?>");
-->
</script>
          </td>
             </tr>
<?php
}
?>
<?php
  if (ACCOUNT_TELE == 'true') {
?>
       <tr>
               <td class="infoBoxContents"><?php echo ENTRY_TELEPHONE_NUMBER; ?></td>
               <td class="infoBoxContents"><?php echo tep_draw_input_field('shiptelephone') . '&nbsp;' . (tep_not_null(ENTRY_TELEPHONE_NUMBER_TEXT) ? '<span class="inputRequirement">' . ENTRY_TELEPHONE_NUMBER_TEXT . '</span>': ''); ?></td>
       </tr>
<?php
}
?>
                </table></td>
              </tr>
            </table></td>
          </tr>
          
          
          
  </TBODY> 
  </table></td>
  </TBODY> 
             </table></td>
          </tr>

<?php
}
?>    

       <tr>

        <td><table border="0" width="98%" cellspacing="1" cellpadding="2">
<tr>        
        <?php
          if (basename($_SERVER["HTTP_REFERER"])) {
?>
           <td width="20%" valign="top"><center>   <?php
           echo '<a href="' . basename($_SERVER["HTTP_REFERER"]) . '">' . tep_template_image_button('button_continue_shopping.gif', IMAGE_BUTTON_CONTINUE_SHOPPING) . '</a>'; ?>
<?php
            }
?>
       </td><td width="100%" border="1">&nbsp;</td><td width="100%" border="1" valign="top"><center>
<?php

  if (isset($$payment->form_action_url)) {
    $form_action_url = $$payment->form_action_url;
  } else {
    $form_action_url = tep_href_link(FILENAME_CHECKOUT_PROCESS_ALTERNATIVE, '', 'SSL');
  }




  echo tep_template_image_submit('button_confirm_order.gif', IMAGE_BUTTON_CONFIRM_ORDER) . '</form>';
?>
</center></td>
</tr>
</table>
</td>
</tr>


      </table>
      </td>
<!-- body_text_eof //-->


          </tr>
        </table></td>
      </tr>
<?php
// BOF: Lango Added for template MOD
if (MAIN_TABLE_BORDER == 'yes'){
table_image_border_bottom();
}
// EOF: Lango Added for template MOD
?>

   </table>
