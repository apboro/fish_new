<?php
/*
  $Id: privacy.php,v 1.3 2001/12/20 14:14:15 dgw_ Exp $

  The Exchange Project - Community Made Shopping!
  http://www.theexchangeproject.org

  Copyright (c) 2000,2001 The Exchange Project

  Released under the GNU General Public License
*/

define('NAVBAR_TITLE', 'Минимальная сумма заказа');
define('HEADING_TITLE', 'Минимальная сумма заказа');
define('TEXT_INFORMATION', 'Вы сделали заказ на общую сумму <b>'. $currencies->format($cart->show_total()) .'</b>, но в нашем магазине минимальная сумма заказа должна быть как минимум <b>' . $currencies->format(MIN_ORDER) . '</b>. Вы можете либо положить в корзину ещё товар, тем самым достигнув минимальной суммы заказа, либо Вы можете отказаться от покупки.');

?>