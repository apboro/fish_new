<?php
/*
  $Id: login.php,v 1.1.1.1 2003/09/18 19:04:28 wilt Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/

  define('NAVBAR_TITLE', 'Пароль');
  define('HEADING_TITLE', 'Позвольте войти!');

define('HEADING_NEW_CUSTOMER', 'Регистрация');
define('TEXT_NEW_CUSTOMER', 'Я хочу зарегистрироваться!');
define('TEXT_NEW_CUSTOMER_INTRODUCTION', 'Зарегистрировавшись в нашем магазине, Вы сможете совершать покупки намного быстрее и удобнее, кроме того, Вы сможете следить за выполнением заказов, смотреть историю своих заказов.');

define('HEADING_RETURNING_CUSTOMER', 'Зарегистрированный пользователь');
define('TEXT_RETURNING_CUSTOMER', 'Я уже зарегистрирован!');

define('TEXT_PASSWORD_FORGOTTEN', 'Если не получается войти, нажмите сюда');

define('TEXT_LOGIN_ERROR', '<font color="#ff0000"><b>ОШИБКА:</b></font> Неверный \'E-Mail Адрес\' и/или \'Пароль\'.');
define('TEXT_VISITORS_CART', '<font color="#ff0000"><b>К СВЕДЕНИЮ:</b></font>&nbsp;Содержимое Вашей &quot;корзины посетителя&quot; будет объединено с содержимым Вашей &quot;постоянной корзины&quot; как только Вы подтвердите регистрацию. <a href="javascript:session_win();">[Подробнее]</a>');

// guest_account start

define('HEADING_GUEST_CUSTOMER', 'Быстрое оформление заказа');
define('TEXT_GUEST_CUSTOMER', 'Я не хочу регистрироваться в магазине!');
define('TEXT_GUEST_CUSTOMER_INTRODUCTION', 'Если Вы хотите максимально быстро оформить заказ, нажимайте кнопку "Продолжить", которая расположена ниже, быстрое оформление заказа сэкономит Ваше время, но у Вас не будет адресной книги, Вы не сможете получать новости о последних новинках в нашем магазине. <br><br>Если Вы уже зарегистрированы в нашем магазине, введите свой e-mail адрес и пароль.');
?>
