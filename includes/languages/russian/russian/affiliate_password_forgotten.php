<?php
/*
  $Id: affiliate_password_forgotten.php,v 1.1.1.1 2003/09/18 19:04:30 wilt Exp $

  OSC-Affiliate

  Contribution based on:

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2002 - 2003 osCommerce

  Released under the GNU General Public License
*/

define('NAVBAR_TITLE_1', 'Вход');
define('NAVBAR_TITLE_2', 'Восстановление пароля');
define('HEADING_TITLE', 'Я забыл пароль для входа в партнёрскую программу!');
define('TEXT_NO_EMAIL_ADDRESS_FOUND', '<font color="#ff0000"><b>ВНИМАНИЕ:</b></font> Указанный E-Mail адрес не зарегистрирован в нашей партнёрской программе. Попробуйте ещё раз.');
define('EMAIL_PASSWORD_REMINDER_SUBJECT', STORE_NAME . ' - Новый пароль');
define('EMAIL_PASSWORD_REMINDER_BODY', 'Вы запросили новый пароль для партнёрской программы. Ваш новый пароль для доступа к партнёрской программе Интернет-магазина \'' . STORE_NAME . '\':' . "\n\n" . '   %s' . "\n\n");
define('TEXT_PASSWORD_SENT', 'Новый пароль был отправлен на Ваш Email адрес, проверьте почту.');
?>