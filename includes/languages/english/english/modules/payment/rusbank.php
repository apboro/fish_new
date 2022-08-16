<?php
/*
  $Id: rusbank.php,v 1.2 2002/11/22

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2002 osCommerce

  Released under the GNU General Public License
*/

  define('MODULE_PAYMENT_RUS_BANK_TEXT_TITLE', 'Kvitancia SB RF');
  define('MODULE_PAYMENT_RUS_BANK_TEXT_DESCRIPTION', 'Наши банковские реквизиты:<br><br>Название банка: &nbsp;&nbsp;&nbsp;' . MODULE_PAYMENT_RUS_BANK_1 . '<br>Расчетный счет: &nbsp;&nbsp;&nbsp;' . MODULE_PAYMENT_RUS_BANK_2 . '<br>БИК: &nbsp;&nbsp;&nbsp;' . MODULE_PAYMENT_RUS_BANK_3 . '<br>Кор./счет: &nbsp;&nbsp;&nbsp;' . MODULE_PAYMENT_RUS_BANK_4 . '<br>ИНН: &nbsp;&nbsp;&nbsp;' . MODULE_PAYMENT_RUS_BANK_5 . '<br>Получатель: &nbsp;&nbsp;&nbsp;' . MODULE_PAYMENT_RUS_BANK_6 . '<br>КПП: &nbsp;&nbsp;&nbsp;' . MODULE_PAYMENT_RUS_BANK_7 . '<br>Назначение платежа: &nbsp;&nbsp;&nbsp;' . MODULE_PAYMENT_RUS_BANK_8 . '<br><br>После оплаты заказа обязательно сообщите нам по электронной почте <a href="mailto:' . STORE_OWNER_EMAIL_ADDRESS . '">' . STORE_OWNER_EMAIL_ADDRESS . '</a> о факте оплаты. Ваш заказ будет отправлен сразу после подтверждения факта оплаты.<br><br>Распечатать квитанцию для оплаты Вы сможете на следующей странице.');
  define('MODULE_PAYMENT_RUS_BANK_TEXT_EMAIL_FOOTER', "Наши банковские реквизиты:\n\nНазвание банка: " . MODULE_PAYMENT_RUS_BANK_1 . "\nРасчетный счет: " . MODULE_PAYMENT_RUS_BANK_2 . "\nБИК: " . MODULE_PAYMENT_RUS_BANK_3 . "\nКор./счет: " . MODULE_PAYMENT_RUS_BANK_4 . "\nИНН: " . MODULE_PAYMENT_RUS_BANK_5 . "\nПолучатель: " . MODULE_PAYMENT_RUS_BANK_6 . "\nКПП: " . MODULE_PAYMENT_RUS_BANK_7 . "\nНазначение платежа: " . MODULE_PAYMENT_RUS_BANK_8 . "\n\nПосле оплаты заказа обязательно сообщите нам по электронной почте " . STORE_OWNER_EMAIL_ADDRESS . " о факте оплаты. Ваш заказ будет отправлен сразу после подтверждения факта оплаты.");

define('MODULE_PAYMENT_RUS_BANK_TEXT_PRINT','Распечатать квитанцию для оплаты');  
define('MODULE_PAYMENT_RUS_BANK_ORDER_NUMBER',', заказ номер ');

define('MODULE_PAYMENT_KVITANCIA_NAME_TITLE','Информация о плательщике');
define('MODULE_PAYMENT_KVITANCIA_NAME_DESC','');
define('MODULE_PAYMENT_KVITANCIA_NAME','ФИО:');
define('MODULE_PAYMENT_KVITANCIA_ADDRESS','Адрес:');
define('MODULE_PAYMENT_KVITANCIA_ADDRESS_HELP',' Пример: г. Ставрополь, ул. Мира 111, оф. 11');

?>