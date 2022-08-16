<?php
/*
  $Id$
  Recover Cart Sales v 1.4 ENGLISH Language File

  Recover Cart Sales contrib: JM Ivler (c)
  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Released under the GNU General Public License

*/

define('MESSAGE_STACK_CUSTOMER_ID', 'Незавершённый заказ покупателя (id код ');
define('MESSAGE_STACK_DELETE_SUCCESS', ') успешно удалён.');
define('HEADING_TITLE', 'Незавершённые заказы');
define('HEADING_EMAIL_SENT', 'Отчёт об отправке писем');
define('EMAIL_SEPARATOR', '------------------------------------------------------');
define('EMAIL_TEXT_SUBJECT', 'Сообщение от Интернет-магазина '.  STORE_NAME );
define('EMAIL_TEXT_SALUTATION', 'Уважаемый ' );
define('EMAIL_TEXT_NEWCUST_INTRO', "\n\n" . 'Вы начинали оформлять заказ в Интернет-магазине ' .
                                   STORE_NAME . ', но так и не оформили его до конца.');
define('EMAIL_TEXT_CURCUST_INTRO', "\n\n" . 'Вы начинали оформлять заказ в Интернет-магазине ' .
                                   STORE_NAME . ', но так и не оформили его до конца.  ');
define('EMAIL_TEXT_COMMON_BODY', "\n\n" . 'Нам было бы интересно узнать, почему Вы так и не оформили его до конца? Если у Вас в процессе оформления заказа возникли какие-либо проблемы, мы всегда готовы Вам помочь с оформлением заказа и с удовольствием ответим на возникшие вопросы. Задайте нам их в ответном письме, мы поможем Вам оформить заказ.' .
                                  "\n\n" . 'Товар, который Вы заказывали:' .
                                 "\n\n" . '%s' . "\n");
define('DAYS_FIELD_PREFIX', 'Показать заказы за последние ');
define('DAYS_FIELD_POSTFIX', ' дней ');
define('DAYS_FIELD_BUTTON', 'Смотреть');
define('TABLE_HEADING_DATE', 'Дата');
define('TABLE_HEADING_CONTACT', 'Уведомлён');
define('TABLE_HEADING_CUSTOMER', 'Имя покупателя');
define('TABLE_HEADING_EMAIL', 'E-mail адрес');
define('TABLE_HEADING_PHONE', 'Телефон');
define('TABLE_HEADING_MODEL', 'Код');
define('TABLE_HEADING_DESCRIPTION', 'Товар');
define('TABLE_HEADING_QUANTY', 'Количество');
define('TABLE_HEADING_PRICE', 'Стоимость');
define('TABLE_HEADING_TOTAL', 'Всего');
define('TABLE_GRAND_TOTAL', 'Общая стоимость незавершённых заказов: ');
define('TABLE_CART_TOTAL', 'Стоимость заказа: ');
define('TEXT_CURRENT_CUSTOMER', 'Покупатель');
define('TEXT_SEND_EMAIL', 'Отправить E-mail');
define('TEXT_RETURN', 'Вернуться назад');
define('TEXT_NOT_CONTACTED', 'Не уведомлён');
define('PSMSG', 'Дополнительное сообщение: ');
?>