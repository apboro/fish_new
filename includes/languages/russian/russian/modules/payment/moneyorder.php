<?php
/*
  $Id: moneyorder.php,v 1.1.1.1 2003/09/18 19:04:32 wilt Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2002 osCommerce

  Released under the GNU General Public License
*/

  define('MODULE_PAYMENT_MONEYORDER_TEXT_TITLE', 'Чек');
  define('MODULE_PAYMENT_MONEYORDER_TEXT_DESCRIPTION', 'Информация для оплаты:&nbsp;' . MODULE_PAYMENT_MONEYORDER_PAYTO . '<br><br>Почтовый адрес:<br>' . nl2br(STORE_NAME_ADDRESS) . '<br><br>' . 'Ваш заказ не будет отправлен пока мы не получим оплату.');
  define('MODULE_PAYMENT_MONEYORDER_TEXT_EMAIL_FOOTER', "Информация для оплаты: ". MODULE_PAYMENT_MONEYORDER_PAYTO . "\n\nПочтовый адрес:\n" . STORE_NAME_ADDRESS . "\n\n" . 'Ваш заказ не будет отправлен пока мы не получим оплату.');
?>
