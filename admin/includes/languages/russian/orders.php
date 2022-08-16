<?php
/*
  $Id: orders.php,v 1.2 2003/09/24 13:57:08 wilt Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2002 osCommerce

  Released under the GNU General Public License
*/

define('HEADING_TITLE', 'Список заказов');
define('HEADING_TITLE_SEARCH', 'Поиск по ID заказа');
define('HEADING_TITLE_STATUS', 'Состояние:');

define('TABLE_HEADING_COMMENTS', 'Комментарий');
define('TABLE_HEADING_CUSTOMERS', 'Клиенты');
define('TABLE_HEADING_ORDER_TOTAL', 'Заказ итого');
define('TABLE_HEADING_DATE_PURCHASED', 'Дата покупки');
define('TABLE_HEADING_STATUS', 'Состояние');
define('TABLE_HEADING_ACTION', 'Действие');
define('TABLE_HEADING_QUANTITY', 'Количество');
define('TABLE_HEADING_PRODUCTS_MODEL', 'Код товара');
define('TABLE_HEADING_PRODUCTS', 'Товары');
define('TABLE_HEADING_TAX', 'Налог');
define('TABLE_HEADING_TOTAL', 'Всего');
define('TABLE_HEADING_PRICE_EXCLUDING_TAX', 'Цена (не включая налог)');
define('TABLE_HEADING_PRICE_INCLUDING_TAX', 'Цена');
define('TABLE_HEADING_TOTAL_EXCLUDING_TAX', 'Общая (не включая налог)');
define('TABLE_HEADING_TOTAL_INCLUDING_TAX', 'Всего');

define('TABLE_HEADING_STATUS', 'Статус');
define('TABLE_HEADING_DATE_ADDED', 'Дата добавления');
define('TABLE_HEADING_CUSTOMER_NOTIFIED', 'Клиент уведомлён');
define('OTZIV_MARKET', 'Напишите, пожалуйста, отзыв о нашем магазине: http://market.yandex.ru/shop/17311/reviews?clid=703');
define('ENTRY_CUSTOMER', 'Клиент:');
define('ENTRY_SOLD_TO', 'ПОКУПАТЕЛЬ:');
define('ENTRY_DELIVERY_TO', 'Адрес:');
define('ENTRY_SHIP_TO', 'АДРЕС ДОСТАВКИ:');
define('ENTRY_SHIPPING_ADDRESS', 'Адрес Доставки:');
define('ENTRY_BILLING_ADDRESS', 'Адрес Покупателя:');
define('ENTRY_PAYMENT_METHOD', 'Способ оплаты:');
define('ENTRY_CREDIT_CARD_TYPE', 'Тип Кредитной Карточки:');
define('ENTRY_CREDIT_CARD_OWNER', 'Владелец Кредитной Карточки:');
define('ENTRY_CREDIT_CARD_NUMBER', 'Номер Кредитной Карточки:');
define('ENTRY_CREDIT_CARD_EXPIRES', 'Срок окончания действия кредитной карточки:');
define('ENTRY_SUB_TOTAL', 'Предварительный Итог:');
define('ENTRY_TAX', 'Налог:');
define('ENTRY_SHIPPING', 'Доставка:');
define('ENTRY_TOTAL', 'Всего:');
define('ENTRY_DATE_PURCHASED', 'Дата Покупки:');
define('ENTRY_STATUS', 'Состояние:');
define('ENTRY_DATE_LAST_UPDATED', 'Последнее изменение:');
define('ENTRY_NOTIFY_CUSTOMER', 'Уведомить Клиента:'); 
define('ENTRY_NOTIFY_COMMENTS', 'Отображать клиенту:');
define('ENTRY_PRINTABLE', 'Напечатать счёт');

define('TEXT_INFO_HEADING_DELETE_ORDER', 'Удалить Заказ');
define('TEXT_INFO_DELETE_INTRO', 'Вы действительно хотите удалить этот заказ?');
define('TEXT_INFO_DELETE_DATA', 'Покупатель:');
define('TEXT_INFO_RESTOCK_PRODUCT_QUANTITY', 'Пересчитать количество товара на складе');
define('TEXT_INFO_DELETE_DATA_OID', 'Номер заказа:');
define('TEXT_DATE_ORDER_CREATED', 'Дата Создания:');
define('TEXT_DATE_ORDER_LAST_MODIFIED', 'Последние Изменения:');
define('TEXT_INFO_PAYMENT_METHOD', 'Способ Оплаты:');

define('TEXT_ALL_ORDERS', 'Все Заказы');
define('TEXT_NO_ORDER_HISTORY', 'История заказа отсутствует');

define('EMAIL_SEPARATOR', '------------------------------------------------------');
define('EMAIL_TEXT_SUBJECT', 'Статус Вашего заказа изменён');
define('EMAIL_TEXT_ORDER_NUMBER', 'Номер заказа:');
define('EMAIL_TEXT_INVOICE_URL', 'Информация о заказе:');
define('EMAIL_TEXT_DATE_ORDERED', 'Дата заказа:');
define('EMAIL_TEXT_DATE_SHIPPING', 'Дата доставки:');
define('EMAIL_TEXT_STATUS_UPDATE', 'Новый статус заказа: %s' . "\n" . 'Если у Вас возникли вопросы, просто задайте их нам в ответном письме.' . "\n");
define('EMAIL_TEXT_COMMENTS_UPDATE', 'Комментарии к Вашему заказу' . "\n\n%s\n\n");

define('ERROR_ORDER_DOES_NOT_EXIST', 'Ошибка: Заказ не существует.');
define('SUCCESS_ORDER_UPDATED', 'Выполнено: Заказ успешно обновлён.');
define('WARNING_ORDER_NOT_UPDATED', 'Внимание: Изменять нечего. Заказ НЕ обновлён.');
// denuz
define('TABLE_HEADING_ORDER_NETTO', 'Нетто');
define('TABLE_HEADING_ORDER_NUMBER', 'Номер');
define('TABLE_HEADING_ORDER_MARJA', 'Маржа');
define('TITLE_ORDER_NETTO', 'Нетто:');
define('TITLE_ORDER_MARJA', 'Маржа:');
define('TEXT_TOTAL', 'Всего: ');
define('TEXT_NETTO', 'Нетто: ');
define('TEXT_MARJA', 'Маржа: ');
// eof denuz
define('EMAIL_TEXT_CUSTOMER_NAME', 'Покупатель:');
define('EMAIL_TEXT_CUSTOMER_EMAIL_ADDRESS', 'Email:');
define('EMAIL_TEXT_CUSTOMER_TELEPHONE', 'Телефон:');
define('EMAIL_ACC_DISCOUNT_INTRO_OWNER', 'Один из Ваших клиентов достиг предела накопительной скидки и был переведён в новую группу. ' . "\n\n" . 'Детали:');
define('EMAIL_TEXT_LIMIT', 'Достигнутый предел: ');
define('EMAIL_TEXT_CURRENT_GROUP', 'Новая группа: ');
define('EMAIL_TEXT_DISCOUNT', 'Новая скидка: ');
define('EMAIL_ACC_SUBJECT', 'Накопительная скидка');
define('EMAIL_ACC_INTRO_CUSTOMER', 'Поздравляем, Вы получили новую накопительную скидку. Все детали ниже:');
define('EMAIL_ACC_FOOTER', 'Если у Вас есть вопросы, задайте их нам в ответном письме.');

define('TEXT_REFERER', 'Откуда пришёл: ');
define('TEXT_ORDER_DELETE', 'Удалить: ');
define('TEXT_ORDER_DELETE_CONFIRM1', 'Вы действительно хотите удалить ');
define('TEXT_ORDER_DELETE_CONFIRM2', '?');

define('TEXT_ORDER_SUMMARY','Информация');
define('TEXT_ORDER_PAYMENT','Оплата / Доставка');
define('TEXT_ORDER_PRODUCTS','Товары');
define('TEXT_ORDER_STATUS','Статус');

define('BUS_HEADING_TITLE','Смена статуса');
define('BUS_TEXT_NEW_STATUS', 'Выберите новый статус');
define('BUS_NOTIFY_CUSTOMERS', 'Уведомить покупателя (ей)');
define('BUS_SELECT_ALL', 'Выбрать все');
define('BUS_SELECT_NONE', 'Снять выделение');
define('BUS_SUBMIT', 'Обновить');
define('BUS_SUCCESS','Выбранные заказы обновлены!');
define('BUS_WARNING','Выбранные заказы не обновлены!');
define('BUS_DELETE_SUCCESS','Выбранные заказы удалены!');
define('BUS_DELETE_WARNING','Выбранные заказы не удалены!');
define('BUS_DELETE_ORDERS','Удалить выбранные заказы');

define('TEXT_ORDER_MAP','Карта');
define('MAP_API_KEY_ERROR','Зарегистрируйте ключ на <a href=\"http://api.yandex.ru/maps/form.xml\" target=\"_blank\">http://api.yandex.ru/maps/form.xml</a> и укажите Ваш ключ в Админке - Настройки - Мой магазин - Яндекс карты API-Ключ. <br /> Ошибка:');

define('ENTRY_SHIPPING_METHOD', 'Способ доставки:');
define('TABLE_HEADING_CUSTOMER_VISIBLE','Клиент видит статус');
define('EMAIL_ST_CH','');
define('EMAIL_ST_CH_FOOTER',EMAIL_ACC_FOOTER."\n\n".'Наш канал на YouTube - <a href="http://www.youtube.com/user/YourFishru">http://www.youtube.com/user/YourFishru</a> '."\n\n".
'Мы в Твиттер - <a href="https://twitter.com/YourFish_ru">https://twitter.com/YourFish_ru</a> '."\n\n".
'Мы Вконтакте - <a href="http://vk.com/yourfish_ru">http://vk.com/yourfish_ru</a> '."\n\n");
define('EMAIL_ST_ID',4);
define('CDEK_INVOICE','Сделать заказ в СДЭК');

?>