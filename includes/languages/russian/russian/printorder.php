<?php
/*
  $Id: invoice.php,v 1.1 2003/05 xaglo
  
  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2002 osCommerce

  Released under the GNU General Public License
*/

define('TITLE_PRINT_ORDER', 'СЧЕТ');
define('TITLE_PRINT_ORDER_NUM', '№ ЗАКАЗА:');
define('TITLE_PRINT_NUMBER_TEXT', ' ');

define('TABLE_HEADING_INN', 'ИНН');
define('TABLE_HEADING_CONTNUM', 'Счет №');
define('TABLE_HEADING_BIK', 'БИК');
define('TABLE_HEADING_NUM', '№');
define('TABLE_HEADING_OT', 'от');
define('TABLE_HEADING_SUMMA', 'К оплате:');
define('TABLE_HEADING_COMMENTS', 'Коментарии');
define('TABLE_HEADING_PRODUCTS_MODEL', 'Артикул	');
define('TABLE_HEADING_PRODUCTS_CONT', 'Кол-во');
define('TABLE_HEADING_PRODUCTS', 'Товар');
define('TABLE_HEADING_TAX', 'НДС');
define('TABLE_HEADING_PRICE_EXCLUDING_TAX', 'Цена за ед.<br> без НДС');
define('TABLE_HEADING_PRICE_INCLUDING_TAX', 'Цена за ед с НДС');
define('TABLE_HEADING_TOTAL_EXCLUDING_TAX', 'Сумма без НДС');
define('TABLE_HEADING_TOTAL_INCLUDING_TAX', 'Сумма с НДС');

define('IMAGE_BUTTON_PRINT', 'Печать');

define('ENTRY_EXT_DA', 'ПОСТАВЩИК:');
define('ENTRY_EXT_DA_1', 'Получатель');
define('ENTRY_EXT_DA_2', 'Банк получателя');

define('ENTRY_EXT_DA_3', 'Сбербанк России г. Москва');

define('ENTRY_OBR_DA', 'Образец заполнения платежного поручения:');
define('ENTRY_SOLD_TO', 'ПЛАТЕЛЬЩИК:');
define('ENTRY_SOLD_TO_1', 'ПРЕДСТАВИТЕЛЬ ПЛАТЕЛЬЩИКА:');
define('ENTRY_SOLD_TO_2', 'ТЕЛЕФОНЫ:');
define('ENTRY_SOLD_TO_INN', 'ИНН');
define('ENTRY_SOLD_TO_KPP', 'КПП');
define('ENTRY_SOLD_TO_OGRN', 'ОГРН');
define('ENTRY_SOLD_TO_OKPO', 'ОКПО');
define('ENTRY_SOLD_TO_RS', 'Р/с');
define('ENTRY_SOLD_TO_BANK_NAME', 'Банк');
define('ENTRY_SOLD_TO_BIK', 'БИК');
define('ENTRY_SOLD_TO_KS', 'К/с');
define('ENTRY_SHIP_TO', 'ГРУЗОПОЛУЧАТЕЛЬ:');
define('ENTRY_PAYMENT_METHOD', 'Форма оплаты:');
define('ENTRY_BOSS', 'Руководитель:');

define('ENTRY_BOSS_NOME', MODULE_PAYMENT_RUS_SCHET_9);

define('MODULE_PAYMENT_RUS_SCHET_TEXT_DESCRIPTION_1', MODULE_PAYMENT_RUS_SCHET_1);  // Банк
define('MODULE_PAYMENT_RUS_SCHET_TEXT_DESCRIPTION_2', MODULE_PAYMENT_RUS_SCHET_2);  // Счет получателя
define('MODULE_PAYMENT_RUS_SCHET_TEXT_DESCRIPTION_3', MODULE_PAYMENT_RUS_SCHET_3);  // БИК
define('MODULE_PAYMENT_RUS_SCHET_TEXT_DESCRIPTION_4', MODULE_PAYMENT_RUS_SCHET_4);  // Счет банка
define('MODULE_PAYMENT_RUS_SCHET_TEXT_DESCRIPTION_5', MODULE_PAYMENT_RUS_SCHET_5);  // КПП
define('MODULE_PAYMENT_RUS_SCHET_TEXT_DESCRIPTION_6', MODULE_PAYMENT_RUS_SCHET_6);  // Получатель
define('MODULE_PAYMENT_RUS_SCHET_TEXT_DESCRIPTION_7', MODULE_PAYMENT_RUS_SCHET_7);  // ИНН

define('MODULE_PAYMENT_RUS_SCHET_TEXT_DESCRIPTION_8','<font color=red>Оплата производится в рублях по курсу ЦБ РФ на день покупки</font><br>После оплаты заказа обязательно сообщите нам по электронной почте о факте оплаты или позвоните по тел. В сообщении укажите дату и сумму оплаты, номер заказа, ФИО и номер платежного документа. Оригиналы счета, счет-фактуры и накладных будут предоставлены при получении товара или высланы по почте.');

define('MODULE_PAYMENT_RUS_SCHET_TEXT_DESCRIPTION_9','<font color=red>ВНИМАНИЕ!</font> Оплата данного предварительного счета означает согласие с условиями поставки товара. Счет действителен в течение 3-х банковских дней с момента выписки. По истечении срока действия счета оплату производить строго по уведомлению.');

define('MODULE_PAYMENT_RUS_SCHET_TEXT_DESCRIPTION_10', MODULE_PAYMENT_RUS_SCHET_8); // Адрес получателя

define('text_zero', 'ноль');
define('text_three', 'три');
define('text_four', 'четыре');
define('text_five', 'пять');
define('text_six', 'шесть');
define('text_seven', 'семь');
define('text_eight', 'восемь');
define('text_nine', 'девять');
define('text_ten', 'десять');
define('text_eleven', 'одинадцать');
define('text_twelve', 'двенадцать');
define('text_thirteen', 'тринадцать');
define('text_fourteen', 'четырнадцать');
define('text_fifteen', 'пятнадцать');
define('text_sixteen', 'шестнадцать');
define('text_seventeen', 'семнадцать');
define('text_eighteen', 'восемнадцать');
define('text_nineteen', 'девятнадцать');
define('text_twenty', 'двадцать');
define('text_thirty', 'тридцать');
define('text_forty', 'сорок');
define('text_fifty', 'пятьдесят');
define('text_sixty', 'шестьдесят');
define('text_seventy', 'семьдесят');
define('text_eighty', 'восемьдесят');
define('text_ninety', 'девяносто');
define('text_hundred', 'сто');
define('text_two_hundred', 'двести');
define('text_three_hundred', 'триста');
define('text_four_hundred', 'четыреста');
define('text_five_hundred', 'пятьсот');
define('text_six_hundred', 'шестьсот');
define('text_seven_hundred', 'семьсот');
define('text_eight_hundred', 'восемьсот');
define('text_nine_hundred', 'девятьсот');
define('text_penny', 'копейки');
define('text_kopecks', 'копеек');
define('text_single_kopek', 'одна копейка');
define('text_two_penny', 'две копейки');
define('text_ruble', 'рубля');
define('text_rubles', 'рублей');
define('text_one_ruble', 'один рубль');
define('text_two_rubles', 'два рубля');
define('text_thousands', 'тысячи');
define('text_thousand', 'тысяч');
define('text_one_thousand', 'одна тысяча');
define('text_two_thousand', 'две тысячи');
define('text_million', 'миллиона');
define('text_millions', 'миллионов');
define('text_one_million', 'один миллион');
define('text_two_million', 'два миллиона');
define('text_billion', 'миллиарда');
define('text_billions', 'миллиардов');
define('text_one_billion', 'один миллиард');
define('text_two_billion', 'два миллиарда');
define('text_trillion', 'триллиона');
define('text_trillions', 'триллионов');
define('text_one_trillion', 'один триллион');
define('text_two_trillion', 'два триллиона');

?>