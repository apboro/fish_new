    <?php echo tep_draw_form('cart_quantity', tep_href_link(FILENAME_SHOPPING_CART, 'action=update_product')); ?><table border="0" width="100%" cellspacing="0" cellpadding="<?php echo CELLPADDING_SUB;?>">
<?php
// BOF: Lango Added for template MOD
if (SHOW_HEADING_TITLE_ORIGINAL == 'yes') {
$header_text = '&nbsp;'
//EOF: Lango Added for template MOD
?>
      <tr>
        <td><table class="table-padding-0">
          <tr>
            <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
            <td class="pageHeading" align="right"><?php echo tep_image(DIR_WS_TEMPLATES . TEMPLATE_NAME . '/images/content/cart.gif', HEADING_TITLE, HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
<?php
}else{
$header_text =  HEADING_TITLE;
}
?>

<?php 
if (MAIN_TABLE_BORDER == 'yes'){
table_image_border_top(false, false, $header_text);
}
?>
<?php
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

      $info_box_contents[$cur_row][] = array('params' => 'class="productListing-data creditgoods"',
                                             'text' => $products_name);

											 
	$qua_input=str_replace('class="input-class"','class="input-class creditquantity"',tep_draw_input_field('cart_quantity[]', $products[$i]['quantity'], 'size="4"'));
      $info_box_contents[$cur_row][] = array('align' => 'center',
                                             'params' => 'class="productListing-data" valign="top"',
                                             'text' => $qua_input . tep_draw_hidden_field('products_id[]', $products[$i]['id']));

      //TotalB2B start
/*      $info_box_contents[$cur_row][] = array('align' => 'right',
                                             'params' => 'class="productListing-data" valign="top"',
                                             'text' => '<b>' . $currencies->display_price_nodiscount($products[$i]['final_price'], tep_get_tax_rate($products[$i]['tax_class_id']), $products[$i]['quantity']) . '</b>');
 */
 
 
 $cre_price=DisplayDiscountPrice(
                                                $products[$i]['final_price']* $products[$i]['quantity'],
                                                $products[$i]['full_price']* $products[$i]['quantity'],
                                                $products[$i]['special_price']);
	$cre_price=str_replace(',','',$cre_price);											
	$cre_price='<div class="creditprice" style="display:none">'.$cre_price.'</div>';
      $info_box_contents[$cur_row][] = array('align' => 'right',
                                             'params' => 'class="productListing-data" valign="top"',
                                             'text' => '<b>' . 
                                                DisplayDiscountPrice(
                                                $products[$i]['final_price']* $products[$i]['quantity'],
                                                $products[$i]['full_price']* $products[$i]['quantity'],
                                                $products[$i]['special_price']). $cre_price . '</b>');
    $total_full+=$products[$i]['full_price']* $products[$i]['quantity'];
      //TotalB2B end
    }

    new productListingBox($info_box_contents);
?>
        </td>
      </tr>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
      <tr>
        <td align="right" class="main"><b><?php echo SUB_TITLE_SUB_TOTAL; ?> <?php 
	    
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
<?php
    $back = sizeof($navigation->path)-2;
    if (isset($navigation->path[$back])) {
?>
                <td class="main"><?php echo '<a href="/">' . tep_template_image_button('button_continue_shopping.gif', IMAGE_BUTTON_CONTINUE_SHOPPING) . '</a>'; ?></td>
<?php
    }
?>
				<style>
				.gocredit{
					display:block;
					background: #719cca;
					border: none;
					text-transform: uppercase;
					width: 85px;
					padding: 5px 5px;
					cursor: pointer;
					text-align: center;
					color: #0d0c0cc9;
					margin-top:10px;
				}
				.gocredit:hover{opacity:0.8}
				</style>
				<!-- <td class="main"><button class="gocredit">В кредит</button></td>
				<span id="creditcalc__itscart" style="display: none;"></span>
				  <script type="text/javascript" src="https://v-credit.su/services/easycredit/inc.js"></script>-->
				  
                <td align="right" class="main"><?php if (SMART_CHECKOUT == 'true') { echo '<a href="' . tep_href_link(FILENAME_CHECKOUT, '', 'SSL') . '">' . tep_template_image_button('button_checkout.gif', IMAGE_BUTTON_CHECKOUT) . '</a>'; } else { echo '<a href="' . tep_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL') . '">' . tep_template_image_button('button_checkout.gif', IMAGE_BUTTON_CHECKOUT) . '</a>'; } ?></td>
                <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
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
      <tr>
        <td align="center" class="main"><?php echo TEXT_CART_EMPTY; ?></td>
      </tr>
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
                <td align="right" class="main"><?php echo '<a href="' . tep_href_link(FILENAME_DEFAULT) . '">' . tep_template_image_button('button_continue.gif', IMAGE_BUTTON_CONTINUE) . '</a>'; ?></td>
                <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
              </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>
<?php
  }
?>
    </table>
</form>
