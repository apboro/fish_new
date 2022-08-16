<?php
/*
  $Id: extra_product_price.php,v 1.1 2005/09/11 15:18:15 wilt Exp $

  for The osCommerce Vam Edition v 1.72
  Last Update: 2005/10/22 12:27:15

  Author: FlyOpenair
  email: flyopenair@mail.ru
  web:   flyopenair.ru

  Released under the GNU General Public License
*/
function extra_product_price($products_price)
{
    //TODO: Не используем, поэтому пока отключаем функцию
    return $products_price;
    $products_price_tmp = $products_price;

    if (EXTRA_PRODUCT_PRICE_ID == 'true') {

        $extra_product_price_query = tep_db_query("select extra_product_price_pricerange_to, extra_product_price_pricerange_from, extra_product_price_deduction_value, extra_product_price_deduction_type from " . TABLE_EXTRA_PRODUCT_PRICE . " where extra_product_price_status = '1' ");
        $count = tep_db_num_rows($extra_product_price_query);


        while ($count) {

            $extra_product_price = tep_db_fetch_array($extra_product_price_query);
            if (($products_price_tmp >= $extra_product_price['extra_product_price_pricerange_from']) and ($products_price_tmp <= $extra_product_price['extra_product_price_pricerange_to'])) {


                switch ($extra_product_price['extra_product_price_deduction_type']) {
                    case 0:
                        $products_price = $products_price + $extra_product_price['extra_product_price_deduction_value'];
                        break;

                    case 1:

                        $products_price = $products_price + (($products_price / 100) * $extra_product_price['extra_product_price_deduction_value']);
                        break;

                    case '2':

                        $products_price = $extra_product_price['extra_product_price_deduction_value'];
                        break;

                    default:
                }

            }

            $count--;
        }


    }
    return $products_price;
}


?>