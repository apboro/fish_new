<?php
/*
  $Id: cc.php,v 1.1.1.1 2003/09/18 19:04:32 wilt Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2002 osCommerce

  Released under the GNU General Public License
*/

  define('MODULE_PAYMENT_CC_TEXT_TITLE', 'Кредитная карточка');
  define('MODULE_PAYMENT_CC_TEXT_DESCRIPTION', 'Информация о кредитной карточке для теста:<br><br>Номер карточки: 4111111111111111<br>Действительна до: Любая дата');
  define('MODULE_PAYMENT_CC_TEXT_CREDIT_CARD_TYPE', 'Тип кредитной карточки:');
  define('MODULE_PAYMENT_CC_TEXT_CREDIT_CARD_OWNER', 'Владелец кредитной карточки:');
  define('MODULE_PAYMENT_CC_TEXT_CREDIT_CARD_NUMBER', 'Номер кредитной карточки:');
  define('MODULE_PAYMENT_CC_TEXT_CREDIT_CARD_EXPIRES', 'Действительна до:');
  define('MODULE_PAYMENT_CC_TEXT_JS_CC_OWNER', '* Имя владельца кредитной карточки должно содержать по крайней мере ' . CC_OWNER_MIN_LENGTH . ' символов.\n');
  define('MODULE_PAYMENT_CC_TEXT_JS_CC_NUMBER', '* Номер кредитной карточки должен содержать по крайней мере ' . CC_NUMBER_MIN_LENGTH . ' символов.\n');
  define('MODULE_PAYMENT_CC_TEXT_ERROR', 'Данные введены неправильно!');
?>