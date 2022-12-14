<?php
/*
  $Id: edit_orders.php v5.0 08/05/2007 djmonkey1 Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2007 osCommerce

  Released under the GNU General Public License
*/

define('HEADING_TITLE', 'Редактирование заказа номер %s от %s');
define('ADDING_TITLE', 'Добавляем товар к заказу номер %s');

define('ENTRY_UPDATE_TO_CC', '(Обновить способ оплаты на ' . ORDER_EDITOR_CREDIT_CARD . ' для просмотра полей с информацией о кредитной карточке.)');
define('TABLE_HEADING_COMMENTS', 'Комментарии');
define('TABLE_HEADING_STATUS', 'Статус');
define('TABLE_HEADING_NEW_STATUS', 'Новый статус');
define('TABLE_HEADING_ACTION', 'Действие');
define('TABLE_HEADING_DELETE', 'Удалить?');
define('TABLE_HEADING_QUANTITY', 'Количество');
define('TABLE_HEADING_PRODUCTS_MODEL', 'Код');
define('TABLE_HEADING_PRODUCTS', 'Товары');
define('TABLE_HEADING_TAX', 'Налог');
define('TABLE_HEADING_TOTAL', 'Всего');
define('TABLE_HEADING_BASE_PRICE', 'Цена<br>(за единицу)');
define('TABLE_HEADING_UNIT_PRICE', 'Цена<br>(без налога)');
define('TABLE_HEADING_UNIT_PRICE_TAXED', 'Цена<br>(с налогом)');
define('TABLE_HEADING_TOTAL_PRICE', 'Сумма<br>(без налога)');
define('TABLE_HEADING_TOTAL_PRICE_TAXED', 'Сумма<br>(с налогом)');
define('TABLE_HEADING_OT_TOTALS', 'Сумма заказа:');
define('TABLE_HEADING_OT_VALUES', 'Значение:');
define('TABLE_HEADING_SHIPPING_QUOTES', 'Доставка:');
define('TABLE_HEADING_NO_SHIPPING_QUOTES', 'Нет информации!');

define('TABLE_HEADING_CUSTOMER_NOTIFIED', 'Покупатель уведомлён');
define('TABLE_HEADING_DATE_ADDED', 'Дата');

define('ENTRY_CUSTOMER', 'Покупатель');
define('ENTRY_NAME', 'Имя:');
define('ENTRY_CITY_STATE', 'Город:');
define('ENTRY_SHIPPING_ADDRESS', 'Адрес доставки');
define('ENTRY_BILLING_ADDRESS', 'Адрес покупателя');
define('ENTRY_PAYMENT_METHOD', 'Способ оплаты');
define('ENTRY_CREDIT_CARD_TYPE', 'Тип карточки:');
define('ENTRY_CREDIT_CARD_OWNER', 'Владелец карточки:');
define('ENTRY_CREDIT_CARD_NUMBER', 'Номер карточки:');
define('ENTRY_CREDIT_CARD_EXPIRES', 'Действительна до:');
define('ENTRY_SUB_TOTAL', 'Стоимость товара:');

//the definition of ENTRY_TAX is important when dealing with certain tax components and scenarios
define('ENTRY_TAX', 'Налог');
//do not use a colon (:) in the defintion, ie 'VAT' is ok, but 'VAT:' is not

define('ENTRY_SHIPPING', 'Доставка:');
define('ENTRY_TOTAL', 'Всего:');
define('ENTRY_STATUS', 'Статус:');

define('ENTRY_NOTIFY_CUSTOMER', 'Уведомить клиента:');
#define('ENTRY_NOTIFY_CUSTOMER', 'Уведомить покупателя:');
#define('ENTRY_NOTIFY_COMMENTS', 'Отправить комментарии:');
define('ENTRY_NOTIFY_COMMENTS', 'Отображать клиенту:');

define('ENTRY_CURRENCY_TYPE', 'Валюта');
define('ENTRY_CURRENCY_VALUE', 'Значение');

define('TEXT_INFO_PAYMENT_METHOD', 'Способ оплаты:');
define('TEXT_NO_ORDER_PRODUCTS', 'В данном заказе нет товаров');
define('TEXT_ADD_NEW_PRODUCT', 'Добавить товар');
define('TEXT_PACKAGE_WEIGHT_COUNT', 'Вес: %s  |  Количество единиц товара: %s');

define('TEXT_STEP_1', '<b>Шаг 1:</b>');
define('TEXT_STEP_2', '<b>Шаг 2:</b>');
define('TEXT_STEP_3', '<b>Шаг 3:</b>');
define('TEXT_STEP_4', '<b>Шаг 4:</b>');
define('TEXT_SELECT_CATEGORY', '- Выберите категорию -');
define('TEXT_PRODUCT_SEARCH', '<b>- или введите ключевые слова для поиска -</b>');
define('TEXT_ALL_CATEGORIES', 'Все категории/Все товары');
define('TEXT_SELECT_PRODUCT', '- Выберите товар -');
define('TEXT_BUTTON_SELECT_OPTIONS', 'Выберите атрибуты');
define('TEXT_BUTTON_SELECT_CATEGORY', 'Выбрать данную категорию');
define('TEXT_BUTTON_SELECT_PRODUCT', 'Выбрать данный товар');
define('TEXT_SKIP_NO_OPTIONS', '<em>Нет атрибутов - Пропущено...</em>');
define('TEXT_QUANTITY', 'Количество:');
define('TEXT_BUTTON_ADD_PRODUCT', 'Добавить к заказу');
define('TEXT_CLOSE_POPUP', '<u>Закрыть окно</u> [x]');
define('TEXT_ADD_PRODUCT_INSTRUCTIONS', 'Продолжайте добавлять товар, когда будет добавлен весь необходимый товар, просто закройте окно.');
define('TEXT_PRODUCT_NOT_FOUND', '<b>Товар не найден<b>');
define('TEXT_SHIPPING_SAME_AS_BILLING', 'Адрес доставки и адрес покупателя совпадают');
define('TEXT_BILLING_SAME_AS_CUSTOMER', 'Адреса одинаковые');

define('IMAGE_ADD_NEW_OT', 'Укажите новую запись заказ итого');
define('IMAGE_REMOVE_NEW_OT', 'Удалить данную строку');
define('IMAGE_NEW_ORDER_EMAIL', 'Отправить e-mail с информацией о заказе');

define('TEXT_NO_ORDER_HISTORY', 'Нет истории заказа');

define('PLEASE_SELECT', 'Выберите');

define('EMAIL_SEPARATOR', '------------------------------------------------------');
define('EMAIL_PODTV_ZAK', 'Заказ ОБНОВЛЁН в соответствии с наличием на складе. Если хотите что то добавить, изменить или убрать из заказа, напишите нам об этом в ответном письме.');
define('EMAIL_TEXT_SUBJECT', 'Ваш заказ был обновлён');
define('EMAIL_TEXT_ORDER_NUMBER', 'Номер заказа:');
define('EMAIL_TEXT_INVOICE_URL', 'Подробная информация о заказе:');
define('EMAIL_TEXT_DATE_ORDERED', 'Дата заказа:');
define('EMAIL_TEXT_DATE_SHIPPING', 'Дата доставки:');
define('EMAIL_TEXT_STATUS_UPDATE', 'Спасибо за Ваш заказ!' . "\n\n" . 'Статус Вашего заказа был изменён.' . "\n\n" . 'Новый статус: %s' . "\n\n");
define('EMAIL_TEXT_STATUS_UPDATE2', 'Если у Вас есть вопросы, задайте их нам в ответном письме.' . "\n\n" . 'С уважением, ' . STORE_NAME . "\n");
define('EMAIL_TEXT_COMMENTS_UPDATE', 'Комментарии к Вашему заказу:' . "\n\n%s\n\n");

define('ERROR_ORDER_DOES_NOT_EXIST', 'Ошибка: Заказ %s не найден.');
define('SUCCESS_ORDER_UPDATED', 'Успешно: Заказ был успешно обновлён.');
define('WARNING_ORDER_NOT_UPDATED', 'Предупреждение: Никаких изменений сделано не было.');

//the hints
define('HINT_UPDATE_TO_CC', 'Установите способ оплаты на ' . ORDER_EDITOR_CREDIT_CARD . ' и появятся поля с информацией о кредитной карточке. Данные поля будут скрыты, пока не будет указан необходимй способ оплаты, способ оплаты для кредитных карточек настривается в Админке - Настройки - Редактор заказов.');
define('HINT_UPDATE_CURRENCY', 'При смене валюты заказа будут пересчитаны все итоговые суммы заказа.');
define('HINT_SHIPPING_ADDRESS', 'При смене региона, почтового индекса или страны Вы увидите предупреждение, пересчитать или нет итоговую стоимость заказа.');
define('HINT_TOTALS', 'Вы можете указывать скидки, добавляя отрицательные значения. Поля стоимость товара, налог и всего редактировать нельзя.');
define('HINT_PRESS_UPDATE', 'Нажмите Обновить для сохранения внесённых изменёний.');
define('HINT_BASE_PRICE', 'Цена (за единицу) - это цена единицы товара без учёта атрибутов товара');
define('HINT_PRICE_EXCL', 'Цены (без налога) - это цена товара, включающая в себя атрибуты, но без налога');
define('HINT_PRICE_INCL', 'Цена (с налогом) - это цена товара + налог');
define('HINT_TOTAL_EXCL', 'Сумма (без налога) - это цена товара * на количество товара, но без налога.');
define('HINT_TOTAL_INCL', 'Сумма (с налогом) - это цена товара * на количество товара, включая налог.');
//end hints

//new order confirmation email- this is a separate email from order status update
define('ENTRY_SEND_NEW_ORDER_CONFIRMATION', 'Отправить E-Mail:');
define('EMAIL_TEXT_DATE_MODIFIED', 'Дата:');
define('EMAIL_TEXT_PRODUCTS', 'Товары');
define('EMAIL_TEXT_DELIVERY_ADDRESS', 'Адрес доставки');
define('EMAIL_TEXT_BILLING_ADDRESS', 'Адрес покупателя');
define('EMAIL_TEXT_PAYMENT_METHOD', 'Способ оплаты');
// If you want to include extra payment information, enter text below (use <br> for line breaks):
//define('EMAIL_TEXT_PAYMENT_INFO', ''); //why would this be useful???
// If you want to include footer text, enter text below (use <br> for line breaks):
define('EMAIL_TEXT_FOOTER', '');
//end email

//add-on for downloads
define('ENTRY_DOWNLOAD_COUNT', 'Загрузка ');
define('ENTRY_DOWNLOAD_FILENAME', 'Имя файла');
define('ENTRY_DOWNLOAD_MAXDAYS', 'Ссылка активна (дней)');
define('ENTRY_DOWNLOAD_MAXCOUNT', 'Максимум загрузок');

//add-on for Ajax
define('AJAX_CONFIRM_PRODUCT_DELETE', 'Вы действительно хотите удалить данный товар из заказа?');
define('AJAX_CONFIRM_COMMENT_DELETE', 'Вы действительно хотите удалить данный комментарий из истории заказа?');
define('AJAX_MESSAGE_STACK_SUCCESS', 'Выполнено! \' + %s + \' обновлено');
define('AJAX_CONFIRM_RELOAD_TOTALS', 'Вы изменили информацию о доставке. Хотите чтобы были пересчитаны итоговые суммы заказа?');
define('AJAX_CANNOT_CREATE_XMLHTTP', 'Не могу создать XMLHTTP');
define('AJAX_SUBMIT_COMMENT', 'Добавить новые комментарии и/или статус');
define('AJAX_NO_QUOTES', 'Нет информации.');
define('AJAX_SELECTED_NO_SHIPPING', 'Вы выбрали новый способ доставки, хотите чтобы были пересчитаны итоговые суммы заказа?');
define('AJAX_RELOAD_TOTALS', 'Новая единица была добавлена в заказ, но итоговые суммы не были пересчитаны. Нажмите обновить.');
define('AJAX_NEW_ORDER_EMAIL', 'Вы действительно хотите отправить e-mail покупателю с информацией о сделанных изменениях в заказе?');
define('AJAX_INPUT_NEW_EMAIL_COMMENTS', 'Укажите комментарии, либо оставьте поле пустым, если не хотите добавлять комментарии. Нажимая enter, Вы сохраняете введённый текст.');
define('AJAX_SUCCESS_EMAIL_SENT', 'Выполнено! Информация о заказе отправлена %s');
define('AJAX_WORKING', 'Загрузка, пожалуйста, подождите....');

define('EMAIL_ACC_DISCOUNT_INTRO_OWNER', 'Один из ваших клиентов достиг предела накопительной скидки и был переведен в новую группу. ' . "\n\n" . 'Детали:');
define('EMAIL_TEXT_LIMIT', 'Достигнутый предел: ');
define('EMAIL_TEXT_CURRENT_GROUP', 'Новая группа: ');
define('EMAIL_TEXT_DISCOUNT', 'Скидка: ');
define('EMAIL_ACC_SUBJECT', 'Накопительная скидка');
define('EMAIL_ACC_INTRO_CUSTOMER', 'Поздравляем, Вы получили новую накопительную скидку. Все детали ниже:');
define('EMAIL_ACC_FOOTER', 'Теперь Вы можете сэкономить, делая покупки в нашем интернет-магазине.');

define('EMAIL_TEXT_CUSTOMER_NAME', 'Покупатель:');
define('EMAIL_TEXT_CUSTOMER_EMAIL_ADDRESS', 'Email:');
define('EMAIL_TEXT_CUSTOMER_TELEPHONE', 'Телефон:');

define('TEXT_ORDER_COMMENTS', 'Комментарий к заказу');

define('ENTRY_TYPE_BELOW', 'Выберите'); 
define('ERROR_NO_ORDER_SELECTED', 'Вы не выбрали заказ для редактирования, либо не указан ID номер заказа для редактирования.');
define('TABLE_HEADING_CUSTOMER_VISIBLE','Клиент видит статус');
define('EMAIL_ST_CH','');
define('EMAIL_ST_CH_FOOTER',EMAIL_ACC_FOOTER."\n\n".'Наш канал на YouTube - <a href="http://www.youtube.com/user/YourFishru">http://www.youtube.com/user/YourFishru</a> '."\n\n".
'Мы в Твиттер - <a href="https://twitter.com/YourFish_ru">https://twitter.com/YourFish_ru</a> '."\n\n".
'Мы Вконтакте - <a href="http://vk.com/yourfish_ru">http://vk.com/yourfish_ru</a> '."\n\n");
define('EMAIL_ST_ID',4);

?>