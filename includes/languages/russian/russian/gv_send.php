<?php
/*
  $Id: gv_send.php,v 1.1.1.1 2003/09/18 19:04:28 wilt Exp $

  The Exchange Project - Community Made Shopping!
  http://www.theexchangeproject.org

  Gift Voucher System v1.0
  Copyright (c) 2001,2002 Ian C Wilson
  http://www.phesis.org

  Released under the GNU General Public License
*/

define('HEADING_TITLE', 'Отправить сертификат');
define('NAVBAR_TITLE', 'Отправить сертификат');
define('EMAIL_SUBJECT', 'Сообщение от Интернет-магазина');
define('HEADING_TEXT','<br>Чтобы отправить сертификат, Вы должны заполнить следующую форму.<br>');
define('ENTRY_NAME', 'Имя получателя:');
define('ENTRY_EMAIL', 'E-Mail адрес получателя:');
define('ENTRY_MESSAGE', 'Сообщение:');
define('ENTRY_AMOUNT', 'Сумма сертификата:');
define('ERROR_ENTRY_AMOUNT_CHECK', '&nbsp;&nbsp;<span class="errorText">Неверная сумма</span>');
define('ERROR_ENTRY_EMAIL_ADDRESS_CHECK', '&nbsp;&nbsp;<span class="errorText">Неверный Email адрес</span>');
define('MAIN_MESSAGE', 'Вы решили отправить сертификат на сумму %s своему знакомому %s, его Email адрес: %s<br><br>Получатель сертификата получит следующее сообщение:<br><br>Уважаемый %s<br><br>
                        Вам отправлен сертификат на сумму %s, отправитель: %s');

define('PERSONAL_MESSAGE', '%s пишет:');
define('TEXT_SUCCESS', 'Поздравляем, Ваш сертификат успешно отправлен');


define('EMAIL_SEPARATOR', '----------------------------------------------------------------------------------------');
define('EMAIL_GV_TEXT_HEADER', 'Поздравляем, Вы получили сертификат на сумму %s');
define('EMAIL_GV_TEXT_SUBJECT', 'Подарок от %s');
define('EMAIL_GV_FROM', 'Отправитель этого сертификата - %s');
define('EMAIL_GV_MESSAGE', 'Сообщение отправителя: ');
define('EMAIL_GV_SEND_TO', 'Здравствуйте, %s');
define('EMAIL_GV_REDEEM', 'Чтобы активизировать сертификат, откройте ссылку, которая расположена ниже. Код сертификата: %s');
define('EMAIL_GV_LINK', 'Кликните здесь, чтобы активизировать сертификат ');
define('EMAIL_GV_VISIT', ' или зайдите сюда ');
define('EMAIL_GV_ENTER', ' и введите код сертификата ');
define('EMAIL_GV_FIXED_FOOTER', 'Если у Вас возникают проблемы при активизации сертификата с помощью ссылки, указанной выше, ' . "\n" . 
                                'Мы рекомендуем вводить код сертификата при оформлении заказа, а не через ссылку, указанную выше.' . "\n\n");
define('EMAIL_GV_SHOP_FOOTER', '');
?>