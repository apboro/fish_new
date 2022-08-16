<?php
/*
  $Id: shopping_cart.php,v 1.2 2004/03/09 17:56:06 ccwjr Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2001 osCommerce

  Released under the GNU General Public License
*/
?>
<?php

if (!tep_session_is_registered('customer_id') && ENABLE_PAGE_CACHE == 'true' && class_exists('page_cache') ) {
      echo "<%CART_CACHE%>";
      } else {
      
?>      

<!-- shopping_cart //-->
          <tr>
            <td>
<?php
  $info_box_contents = array();
    $info_box_contents[] = array('text'  => '<font color="' . $font_color . '">' . BOX_HEADING_SHOPPING_CART . '</font>');
  new infoBoxHeading_right($info_box_contents, false, false, tep_href_link(FILENAME_SHOPPING_CART, '', 'NONSSL'));

  $cart_contents_string = '';
  if ($cart->count_contents() > 0) {
    $cart_contents_string = '<table class="table-padding-0">';
    $products = $cart->get_products();
    for ($i=0, $n=sizeof($products); $i<$n; $i++) {
      $cart_contents_string .= '<tr><td align="right" valign="top" class="infoBoxContents">';

      if ((tep_session_is_registered('new_products_id_in_cart')) && ($new_products_id_in_cart == $products[$i]['id'])) {
        $cart_contents_string .= '<span class="newItemInCart">';
      } else {
        $cart_contents_string .= '<span class="infoBoxContents">';
      }

      $cart_contents_string .= $products[$i]['quantity'] . '&nbsp;x&nbsp;</span></td><td valign="top" class="infoBoxContents"><a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $products[$i]['id']) . '">';

      if ((tep_session_is_registered('new_products_id_in_cart')) && ($new_products_id_in_cart == $products[$i]['id'])) {
        $cart_contents_string .= '<span class="newItemInCart">';
      } else {
        $cart_contents_string .= '<span class="infoBoxContents">';
      }

      $cart_contents_string .= $products[$i]['name'] . '</span></a></td></tr>';

      if ((tep_session_is_registered('new_products_id_in_cart')) && ($new_products_id_in_cart == $products[$i]['id'])) {
        tep_session_unregister('new_products_id_in_cart');
      }
    }
    $cart_contents_string .= '</table>';
  } else {
    $cart_contents_string .= BOX_SHOPPING_CART_EMPTY;
  }

  $info_box_contents = array();
  $info_box_contents[] = array('text' => $cart_contents_string);

//  if ($cart->count_contents() > 0) {
    // WebMakers.com Added: Shoppe Enhancement Controller
    // check for free order
//    $final_total=$cart->show_total();
//    if ($final_total==0) {
//      $final_total='Free';
//    } else {
//      $final_total=$currencies->format($cart->show_total());
//    }
//    $info_box_contents[] = array('text' => tep_draw_separator());
//    $info_box_contents[] = array('align' => 'right',
//                                 'text' => $final_total);
//  }




  //TotalB2B start
  global $customer_id;
//  $query_price_to_guest = tep_db_query("select configuration_value from " . TABLE_CONFIGURATION . " WHERE configuration_key = 'ALLOW_GUEST_TO_SEE_PRICES'");
//  $query_price_to_guest_result = tep_db_fetch_array($query_price_to_guest);
  $query_price_to_guest_result = ALLOW_GUEST_TO_SEE_PRICES;
  $final_total=$cart->show_total();
  if ((($query_price_to_guest_result=='true') && !(tep_session_is_registered('customer_id'))) || ((tep_session_is_registered('customer_id')))) {
      $box_text = $currencies->format($cart->show_total());
  } else {
      $box_text = PRICES_LOGGED_IN_TEXT;
  }
  if ($cart->count_contents() > 0) {
    $info_box_contents[] = array('text' => tep_draw_separator());
    $info_box_contents[] = array('align' => 'right',
                                 'text' => $box_text);
  }
  //TotalB2B end

  if ($cart->count_contents() > 0) {
      $info_box_contents[] = array('align' => 'left','text' => '<p align="center"><a href="' . tep_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL') . '">'.HEADER_TITLE_CHECKOUT.'</a></p>');
  }

// ICW ADDED FOR CREDIT CLASS GV
  if (tep_session_is_registered('customer_id')) {
    $gv_query = tep_db_query("select amount from " . TABLE_COUPON_GV_CUSTOMER . " where customer_id = '" . $customer_id . "'");
    $gv_result = tep_db_fetch_array($gv_query);
    if ($gv_result['amount'] > 0 ) {
      $info_box_contents[] = array('align' => 'left','text' => tep_draw_separator());
      $info_box_contents[] = array('align' => 'left','text' => '<table class="table-padding-0"><tr><td class="smalltext">' . VOUCHER_BALANCE . '</td><td class="smalltext" align="right" valign="bottom">' . $currencies->format($gv_result['amount']) . '</td></tr></table>');
      $info_box_contents[] = array('align' => 'left','text' => '<table class="table-padding-0"><tr><td class="smalltext"><a href="'. tep_href_link(FILENAME_GV_SEND) . '">' . BOX_SEND_TO_FRIEND . '</a></td></tr></table>');
    }
  }
  if (tep_session_is_registered('gv_id')) {
    $gv_query = tep_db_query("select coupon_amount from " . TABLE_COUPONS . " where coupon_id = '" . $gv_id . "'");
    $coupon = tep_db_fetch_array($gv_query);
    $info_box_contents[] = array('align' => 'left','text' => tep_draw_separator());
    $info_box_contents[] = array('align' => 'left','text' => '<table class="table-padding-0"><tr><td class="smalltext">' . VOUCHER_REDEEMED . '</td><td class="smalltext" align="right" valign="bottom">' . $currencies->format($coupon['coupon_amount']) . '</td></tr></table>');

  }
  if (tep_session_is_registered('cc_id') && $cc_id) {
    $info_box_contents[] = array('align' => 'left','text' => tep_draw_separator());
    $info_box_contents[] = array('align' => 'left','text' => '<table class="table-padding-0"><tr><td class="smalltext">' . CART_COUPON . '</td><td class="smalltext" align="right" valign="bottom">' . '<a href="' . tep_href_link(FILENAME_POPUP_COUPON_HELP, 'cID=' . $cc_id) . '" target="_blank">' . CART_COUPON_INFO . '</a>' . '</td></tr></table>');

  }

// ADDED FOR CREDIT CLASS GV END ADDITTION

			 $query = tep_db_query("select g.customers_groups_discount from " . TABLE_CUSTOMERS_GROUPS . " g inner join  " . TABLE_CUSTOMERS  . " c on c.customers_groups_id = g.customers_groups_id and c.customers_id = '" . $customer_id . "'");
			 $query_result = tep_db_fetch_array($query);
			 $customers_groups_discount = $query_result['customers_groups_discount'];
			 $query = tep_db_query("select customers_discount from " . TABLE_CUSTOMERS . " where customers_id =  '" . $customer_id . "'");
			 $query_result = tep_db_fetch_array($query);
			 $customer_discount = $query_result['customers_discount'];
			 $customer_discount = $customer_discount + $customers_groups_discount;


  if (tep_session_is_registered('customer_id')) {
   if ($customer_discount != 0) {
    $info_box_contents[] = array('align' => 'left','text' => tep_draw_separator());
    $info_box_contents[] = array('align' => 'left','text' => '<table class="table-padding-0"><td><tr>' . TEXT_DISCOUNT . $customer_discount . '% </td></tr></table>');
    }
   }

  new infoBox_right($info_box_contents);

$info_box_contents = array();
  $info_box_contents[] = array('align' => 'left',
'text'  => tep_draw_separator('pixel_trans.gif', '100%', '1')
                              );
  new infoboxFooter_right($info_box_contents, true, true);
?>
            </td>
          </tr>
<!-- shopping_cart_eof //-->
<?php
     }
?>