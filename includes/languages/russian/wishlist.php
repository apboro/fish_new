<?php
/*
  $Id: wishlist.php,v 3.0  2005/04/20 Dennis Blake
  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Released under the GNU General Public License
*/

define('NAVBAR_TITLE_WISHLIST', 'Отложенные товары');
define('HEADING_TITLE', 'Отложенные товары');
define('HEADING_TITLE2', 'Отложенные товары');
define('BOX_TEXT_PRICE', 'Стоимость');
define('BOX_TEXT_PRODUCT', 'Название');
define('BOX_TEXT_IMAGE', 'Картинка');
define('BOX_TEXT_SELECT', 'Выберите');

define('BOX_TEXT_VIEW', 'Показать');
define('BOX_TEXT_HELP', 'Помощь');
define('BOX_WISHLIST_EMPTY', 'Всего отложенных товаров: 0');
define('BOX_TEXT_NO_ITEMS', 'Нет отложенных товаров.');

define('TEXT_NAME', 'Имя: ');
define('TEXT_EMAIL', 'Email: ');
define('TEXT_YOUR_NAME', 'Ваше имя: ');
define('TEXT_YOUR_EMAIL', 'Ваш email: ');
define('TEXT_MESSAGE', 'Сообщение: ');
define('TEXT_ITEM_IN_CART', 'Товар в корзине');
define('TEXT_ITEM_NOT_AVAILABLE', 'Товар более недоступен');
define('TEXT_DISPLAY_NUMBER_OF_WISHLIST', 'Показано <b>%d</b> - <b>%d</b> (всего <b>%d</b> отложенных товаров.)');
define('WISHLIST_EMAIL_TEXT', 'Вы можете отправить информацию о товарах, которые Вы отложили, своим друзьям и знакомым.');
define('WISHLIST_EMAIL_TEXT_GUEST', 'Вы можете отправить информацию о товарах, которые Вы отложили, своим друзьям и знакомым.');
define('WISHLIST_EMAIL_SUBJECT', 'отправил Вам сообщение');  //Customers name will be automatically added to the beginning of this.
define('WISHLIST_SENT', 'Отложенные товары успешно отправлены.');
define('WISHLIST_EMAIL_LINK', '

Список отложенных товаров посетителя $from_name:
$link

Спасибо, ' . STORE_NAME); //$from_name = Customers name  $link = public wishlist link

define('WISHLIST_EMAIL_GUEST', 'Спасибо, ' . STORE_NAME);

define('ERROR_YOUR_NAME' , 'Укажите Ваше имя.');
define('ERROR_YOUR_EMAIL' , 'Укажите Ваш email.');
define('ERROR_VALID_EMAIL' , 'Укажите верные email адреса.');
define('ERROR_ONE_EMAIL' , 'Вы должны как минимум указать одно имя и один email адрес.');
define('ERROR_ENTER_EMAIL' , 'Укажите email адрес.');
define('ERROR_ENTER_NAME' , 'Укажите имена получателей.');
define('ERROR_MESSAGE', 'Добавьте сообщение.');
?>
