<?php
/*
  $Id: contact_us.php,v 1.1.1.1 2003/09/18 19:04:30 wilt Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2002 osCommerce

  Released under the GNU General Public License
*/

define('HEADING_TITLE', 'Свяжитесь с нами');
define('NAVBAR_TITLE', 'Написать');
define('TEXT_SUCCESS', 'Ваше сообщение успешно отправлено!');
define('EMAIL_SUBJECT', 'Поторговаться с YOURFISH.RU');

define('ENTRY_NAME', 'Ваше имя:');
define('ENTRY_EMAIL', 'E-Mail адрес:');
define('ENTRY_ENQUIRY', 'Сообщение:');

define('SEND_TO_TEXT', 'Письмо в:');
//define('SEND_TO_TYPE', 'radio');  //this will create a radio buttons for your contact list
define('SEND_TO_TYPE', ''); //Change to this for a dropdown menu.
define('MESSAGE_BODY',"Вопрос о товаре: %s\n\nОтправитель: %s\nИмя: %s\nТовар: %s\n\nСообщение: \n%s");

?>