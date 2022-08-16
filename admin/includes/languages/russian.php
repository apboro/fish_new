<?php
/*
  $Id: russian.php,v 1.3 2003/09/28 23:37:26 anotherlango Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/

//Admin begin
// header text in includes/header.php
define('HEADER_TITLE_ACCOUNT', 'Мой эккаунт');
define('HEADER_TITLE_LOGOFF', 'Выход');

// Admin Account
define('BOX_HEADING_MY_ACCOUNT', 'Мой эккаунт');

// configuration box text in includes/boxes/administrator.php
define('BOX_HEADING_ADMINISTRATOR', 'Администраторы');
define('BOX_ADMINISTRATOR_MEMBERS', 'Группы пользователей');
define('BOX_ADMINISTRATOR_MEMBER', 'Пользователи');
define('BOX_ADMINISTRATOR_BOXES', 'Права доступа');
define('BOX_ADMINISTRATOR_ACCOUNT_UPDATE', 'Обновить информацию о себе');

// images
define('IMAGE_FILE_PERMISSION', 'Права доступа');
define('IMAGE_GROUPS', 'Список групп');
define('IMAGE_INSERT_FILE', 'Добавить файл');
define('IMAGE_MEMBERS', 'Список пользователей');
define('IMAGE_NEW_GROUP', 'Добавить группы');
define('IMAGE_NEW_MEMBER', 'Добавить пользователя');
define('IMAGE_NEXT', 'Далее');

// constants for use in tep_prev_next_display function
define('TEXT_DISPLAY_NUMBER_OF_FILENAMES', 'Показано <b>%d</b> - <b>%d</b> (всего <b>%d</b> файлов)');
define('TEXT_DISPLAY_NUMBER_OF_MEMBERS', 'Показано <b>%d</b> - <b>%d</b> (всего <b>%d</b> пользователей)');
//Admin end

// look in your $PATH_LOCALE/locale directory for available locales..
// on RedHat6.0 I used 'en_US'
// on FreeBSD 4.0 I use 'en_US.ISO_8859-1'
// this may not work under win32 environments..
setlocale(LC_TIME, 'ru_RU.UTF-8');
define('DATE_FORMAT_SHORT', '%d/%m/%Y');  // this is used for strftime()
//define('DATE_FORMAT_LONG', '%A %d %B, %Y'); // this is used for strftime()
define('DATE_FORMAT_LONG', '%d %B %Y г.'); // this is used for strftime()
define('DATE_FORMAT', 'd/m/Y'); // this is used for date()
define('PHP_DATE_TIME_FORMAT', 'd/m/Y H:i:s'); // this is used for date()
define('DATE_TIME_FORMAT', DATE_FORMAT_SHORT . ' %H:%M:%S');
define('DATE_FORMAT_SPIFFYCAL', 'dd/MM/yyyy');  //Use only 'dd', 'MM' and 'yyyy' here in any order


////
// Return date in raw format
// $date should be in format mm/dd/yyyy
// raw date is in format YYYYMMDD, or DDMMYYYY
function tep_date_raw($date, $reverse = false) {
  if ($reverse) {
    return substr($date, 3, 2) . substr($date, 0, 2) . substr($date, 6, 4);
  } else {
    return substr($date, 6, 4) . substr($date, 3, 2) . substr($date, 0, 2); 
  }
}

// Global entries for the <html> tag
define('HTML_PARAMS','dir="ltr" lang="ru"');

// charset for web pages and emails
define('CHARSET', 'utf-8');

// page title
define('TITLE', 'Администрирование');

// header text in includes/header.php
define('HEADER_TITLE_TOP', 'Администрирование');
define('HEADER_TITLE_SUPPORT_SITE', 'Сайт поддержки');
define('HEADER_TITLE_ONLINE_CATALOG', 'Каталог');
define('HEADER_TITLE_ADMINISTRATION', 'Администрирование');
define('HEADER_TITLE_CHAINREACTION', 'osCommerce');
define('HEADER_TITLE_PHESIS', 'Loaded6');
// MaxiDVD Added Line For WYSIWYG HTML Area: BOF
define('BOX_CATALOG_DEFINE_MAINPAGE', 'Изменить главную страницу');
// MaxiDVD Added Line For WYSIWYG HTML Area: EOF


// text for gender
define('MALE', 'Мужчина');
define('FEMALE', 'Женщина');

// text for date of birth example
define('DOB_FORMAT_STRING', 'dd/mm/yyyy');

// configuration box text in includes/boxes/configuration.php
define('BOX_HEADING_CONFIGURATION', 'Настройки');
define('BOX_CONFIGURATION_MYSTORE', 'Магазин');
define('BOX_CONFIGURATION_LOGGING', 'Логи');
define('BOX_CONFIGURATION_CACHE', 'Кэш');

// modules box text in includes/boxes/modules.php
define('BOX_HEADING_MODULES', 'Модули');
define('BOX_MODULES_PAYMENT', 'Оплата');
define('BOX_MODULES_SHIPPING', 'Доставка');
define('BOX_MODULES_ORDER_TOTAL', 'Заказ итого');

// categories box text in includes/boxes/catalog.php
define('BOX_HEADING_CATALOG', 'Каталог');
define('BOX_CATALOG_CATEGORIES_PRODUCTS', 'Категории/Товары');
define('BOX_CATALOG_CATEGORIES_PRODUCTS_ATTRIBUTES', 'Атрибуты - Настройка');
define('BOX_CATALOG_CATEGORIES_PRODUCTS_ATTRIBUTES_NEW', 'Атрибуты - Установка');
define('BOX_CATALOG_MANUFACTURERS', 'Производители');
define('BOX_CATALOG_REVIEWS', 'Отзывы');
define('BOX_CATALOG_SPECIALS', 'Скидки');
define('BOX_CATALOG_PRODUCTS_EXPECTED', 'Ожидаемые товары'); 
define('BOX_CATALOG_EASYPOPULATE', 'Excel импорт/экспорт');

define('BOX_CATALOG_SALEMAKER', 'Массовые скидки');

// customers box text in includes/boxes/customers.php
define('BOX_HEADING_CUSTOMERS', 'Клиенты');
define('BOX_CUSTOMERS_CUSTOMERS', 'Клиенты');
define('BOX_CUSTOMERS_ORDERS', 'Заказы');
define('BOX_CUSTOMERS_EDIT_ORDERS', 'Редактировать заказы');


// taxes box text in includes/boxes/taxes.php
define('BOX_HEADING_LOCATION_AND_TAXES', 'Места / Налоги');
define('BOX_TAXES_COUNTRIES', 'Страны');
define('BOX_TAXES_ZONES', 'Регионы');
define('BOX_TAXES_GEO_ZONES', 'Налоговые зоны');
define('BOX_TAXES_TAX_CLASSES', 'Типы налогов');
define('BOX_TAXES_TAX_RATES', 'Ставки налогов');

// reports box text in includes/boxes/reports.php
define('BOX_HEADING_REPORTS', 'Отчёты');
define('BOX_REPORTS_PRODUCTS_VIEWED', 'Просмотренные товары');
define('BOX_REPORTS_PRODUCTS_PURCHASED', 'Заказанные товары');
define('BOX_REPORTS_ORDERS_TOTAL', 'Лучшие клиенты');

// tools text in includes/boxes/tools.php
define('BOX_HEADING_TOOLS', 'Инструменты');
define('BOX_TOOLS_BACKUP', 'Резервное копирование БД');
define('BOX_TOOLS_BANNER_MANAGER', 'Менеджер баннеров');
define('BOX_TOOLS_CACHE', 'Контроль кэша');
define('BOX_TOOLS_DEFINE_LANGUAGE', 'Языковые файлы');
define('BOX_TOOLS_FILE_MANAGER', 'Файловый менеджер');
define('BOX_TOOLS_MAIL', 'Отправить Email');
define('BOX_TOOLS_NEWSLETTER_MANAGER', 'Менеджер почтовых рассылок');
define('BOX_TOOLS_SERVER_INFO', 'Информация о сервере');
define('BOX_TOOLS_WHOS_ONLINE', 'Кто в онлайне');

// localizaion box text in includes/boxes/localization.php
define('BOX_HEADING_LOCALIZATION', 'Локализация');
define('BOX_LOCALIZATION_CURRENCIES', 'Валюты');
define('BOX_LOCALIZATION_LANGUAGES', 'Языки');
define('BOX_LOCALIZATION_ORDERS_STATUS', 'Статусы заказов');

// infobox box text in includes/boxes/info_boxes.php
define('BOX_HEADING_BOXES', 'Управление боксами');
define('BOX_HEADING_TEMPLATE_CONFIGURATION', 'Настройка шаблонов');
define('BOX_HEADING_DESIGN_CONTROLS', 'Шаблоны');

// VJ Links Manager v1.00 begin
// links manager box text in includes/boxes/links.php
define('BOX_HEADING_LINKS', 'Ссылки');
define('BOX_LINKS_LINKS', 'Ссылки');
define('BOX_LINKS_LINK_CATEGORIES', 'Категории');
define('BOX_LINKS_LINKS_CONTACT', 'Обратная связь');
// VJ Links Manager v1.00 end

// javascript messages
define('JS_ERROR', 'При заполнении формы Вы допустили ошибки!\nСделайте, пожалуйста, следующие исправления:\n\n');

define('JS_OPTIONS_VALUE_PRICE', '* Новый атрибут товара дожен иметь цену\n');
define('JS_OPTIONS_VALUE_PRICE_PREFIX', '* Новый атрибут товара дожен иметь ценовой префикс\n');

define('JS_PRODUCTS_NAME', '* Для нового товара должно быть указано наименование\n');
define('JS_PRODUCTS_DESCRIPTION', '* Для нового товара должно быть указано описание\n');
define('JS_PRODUCTS_PRICE', '* Для нового товара должна быть указана цена\n');
define('JS_PRODUCTS_WEIGHT', '* Для нового товара должен быть указан вес\n');
define('JS_PRODUCTS_QUANTITY', '* Для нового товара должно быть указано количество\n');
define('JS_PRODUCTS_MODEL', '* Для нового товара должен быть указан код товара\n');
define('JS_PRODUCTS_IMAGE', '* Для нового товара должна быть картинка\n');

define('JS_SPECIALS_PRODUCTS_PRICE', '* Для этого товара должна быть установлена новая цена\n');

define('JS_GENDER', '* Поле \'Пол\' должно быть выбрано.\n');
define('JS_FIRST_NAME', '* Поле \'Имя\' должно содержать не менее ' . ENTRY_FIRST_NAME_MIN_LENGTH . ' символов.\n');
define('JS_LAST_NAME', '* Поле \'Фамилия\' должно содержать не менее ' . ENTRY_LAST_NAME_MIN_LENGTH . ' символов.\n');
define('JS_DOB', '* Поле \'День рождения\' должно иметь формат: xx/xx/xxxx (день/месяц/год).\n');
define('JS_EMAIL_ADDRESS', '* Поле \'E-Mail адрес\' должно содержать не менее ' . ENTRY_EMAIL_ADDRESS_MIN_LENGTH . ' символов.\n');
define('JS_ADDRESS', '* Поле \'Адрес\' должно содержать не менее ' . ENTRY_STREET_ADDRESS_MIN_LENGTH . ' символов.\n');
define('JS_POST_CODE', '* Поле \'Индекс\' должно содержать не менее ' . ENTRY_POSTCODE_MIN_LENGTH . ' символов.\n');
define('JS_CITY', '* Поле \'Город\' должно содержать не менее ' . ENTRY_CITY_MIN_LENGTH . ' символов.\n');
define('JS_STATE', '* Поле \'Регион\' должно быть выбрано.\n');
define('JS_STATE_SELECT', '-- Выберите выше --');
define('JS_ZONE', '* Поле \'Регион\' должно соответствовать выбраной стране.');
define('JS_COUNTRY', '* Поле \'Страна\' дожно быть заполнено.\n');
define('JS_TELEPHONE', '* Поле \'Телефон\' должно содержать не менее ' . ENTRY_TELEPHONE_MIN_LENGTH . ' символов.\n');
define('JS_PASSWORD', '* Поля \'Пароль\' и \'Подтверждение\' должны совпадать и содержать не менее ' . ENTRY_PASSWORD_MIN_LENGTH . ' символов.\n');

define('JS_ORDER_DOES_NOT_EXIST', 'Заказ номер %s не найден!');

define('CATEGORY_PERSONAL', 'Персональный');
define('CATEGORY_ADDRESS', 'Адрес');
define('CATEGORY_CONTACT', 'Для контакта');
define('CATEGORY_COMPANY', 'Компания');
define('CATEGORY_OPTIONS', 'Рассылка');
define('DISCOUNT_OPTIONS', 'Скидки');

define('ENTRY_GENDER', 'Пол:');
define('ENTRY_GENDER_ERROR', '&nbsp;<span class="errorText">обязательно</span>');
define('ENTRY_FIRST_NAME', 'Имя:');
define('ENTRY_FIRST_NAME_ERROR', '&nbsp;<span class="errorText">минимум ' . ENTRY_FIRST_NAME_MIN_LENGTH . ' символов</span>');
define('ENTRY_LAST_NAME', 'Фамилия:');
define('ENTRY_LAST_NAME_ERROR', '&nbsp;<span class="errorText">минимум ' . ENTRY_LAST_NAME_MIN_LENGTH . ' символов</span>');
define('ENTRY_DATE_OF_BIRTH', 'Дата рождения:');
define('ENTRY_DATE_OF_BIRTH_ERROR', '&nbsp;<span class="errorText">(пример 21/05/1970)</span>');
define('ENTRY_EMAIL_ADDRESS', 'E-Mail Адрес:');
define('ENTRY_EMAIL_ADDRESS_ERROR', '&nbsp;<span class="errorText">минимум ' . ENTRY_EMAIL_ADDRESS_MIN_LENGTH . ' символов</span>');
define('ENTRY_EMAIL_ADDRESS_CHECK_ERROR', '&nbsp;<span class="errorText">Вы ввели неверный email адрес!</span>');
define('ENTRY_EMAIL_ADDRESS_ERROR_EXISTS', '&nbsp;<span class="errorText">Данный email адрес уже зарегистрирован!</span>');
define('ENTRY_COMPANY', 'Название компании:');
define('ENTRY_COMPANY_ERROR', '');
define('ENTRY_STREET_ADDRESS', 'Адрес:');
define('ENTRY_STREET_ADDRESS_ERROR', '&nbsp;<span class="errorText">минимум ' . ENTRY_STREET_ADDRESS_MIN_LENGTH . ' символов</span>');
define('ENTRY_SUBURB', 'Район:');
define('ENTRY_SUBURB_ERROR', '');
define('ENTRY_POST_CODE', 'Индекс:');
define('ENTRY_POST_CODE_ERROR', '&nbsp;<span class="errorText">минимум ' . ENTRY_POSTCODE_MIN_LENGTH . ' символов</span>');
define('ENTRY_CITY', 'Город:');
define('ENTRY_CITY_ERROR', '&nbsp;<span class="errorText">минимум ' . ENTRY_CITY_MIN_LENGTH . ' символов</span>');
define('ENTRY_STATE', 'Регион:');
define('ENTRY_STATE_ERROR', '&nbsp;<span class="errorText">обязательно</span>');
define('ENTRY_COUNTRY', 'Страна:');
define('ENTRY_COUNTRY_ERROR', '');
define('ENTRY_TELEPHONE_NUMBER', 'Телефон:');
define('ENTRY_TELEPHONE_NUMBER_ERROR', '&nbsp;<span class="errorText">минимум ' . ENTRY_TELEPHONE_MIN_LENGTH . ' символов</span>');
define('ENTRY_FAX_NUMBER', 'Факс:');
define('ENTRY_FAX_NUMBER_ERROR', '');
define('ENTRY_NEWSLETTER', 'Получать рассылку:');
define('ENTRY_NEWSLETTER_YES', 'Подписан');
define('ENTRY_NEWSLETTER_NO', 'Не подписан');
define('ENTRY_NEWSLETTER_ERROR', '');

// images
define('IMAGE_ANI_SEND_EMAIL', 'Отправить E-Mail');
define('IMAGE_BACK', 'Назад');
define('IMAGE_BACKUP', 'Рез. копия');
define('IMAGE_CANCEL', 'Отменить');
define('IMAGE_CONFIRM', 'Подтвердить');
define('IMAGE_COPY', 'Копировать');
define('IMAGE_COPY_TO', 'Копировать в');
define('IMAGE_DETAILS', 'Настроить');
define('IMAGE_DELETE', 'Удалить');
define('IMAGE_EDIT', 'Редактировать');
define('IMAGE_EMAIL', 'Email');
define('IMAGE_FILE_MANAGER', 'Менеджер файлов');
define('IMAGE_ICON_STATUS_GREEN', 'Активный');
define('IMAGE_ICON_STATUS_GREEN_LIGHT', 'Активизировать');
define('IMAGE_ICON_STATUS_RED', 'Неактивный');
define('IMAGE_ICON_STATUS_RED_LIGHT', 'Сделать неактивным');
define('IMAGE_ICON_INFO', 'Информационные страницы');
define('IMAGE_INSERT', 'Добавить');
define('IMAGE_LOCK', 'Замок');
define('IMAGE_MODULE_INSTALL', 'Установить модуль');
define('IMAGE_MODULE_REMOVE', 'Удалить модуль');
define('IMAGE_MOVE', 'Переместить');
define('IMAGE_NEW_BANNER', 'Новый баннер');
define('IMAGE_NEW_CATEGORY', 'Новая категория');
define('IMAGE_NEW_COUNTRY', 'Новая страна');
define('IMAGE_NEW_CURRENCY', 'Новая валюта'); 
define('IMAGE_NEW_FILE', 'Новый файл');
define('IMAGE_NEW_FOLDER', 'Новая папка');
define('IMAGE_NEW_LANGUAGE', 'Новый язык');
define('IMAGE_NEW_NEWSLETTER', 'Новое письмо новостей');
define('IMAGE_NEW_PRODUCT', 'Новый товар');
define('IMAGE_NEW_SALE', 'Новая распродажа');
define('IMAGE_NEW_TAX_CLASS', 'Новый налог'); 
define('IMAGE_NEW_TAX_RATE', 'Новая ставка налога');
define('IMAGE_NEW_TAX_ZONE', 'Новая налоговая зона');
define('IMAGE_NEW_ZONE', 'Новая зона');
define('IMAGE_ORDERS', 'Заказы');
define('IMAGE_ORDERS_INVOICE', 'Счёт-фактура');
define('IMAGE_ORDERS_PACKINGSLIP', 'Накладная');
define('IMAGE_PREVIEW', 'Предпросмотр');
define('IMAGE_RESTORE', 'Восстановить');
define('IMAGE_RESET', 'Сброс');
define('IMAGE_SAVE', 'Сохранить');
define('IMAGE_SEARCH', 'Искать');
define('IMAGE_SELECT', 'Выбрать');
define('IMAGE_SEND', 'Отправить');
define('IMAGE_SEND_EMAIL', 'Отправить Email');
define('IMAGE_UNLOCK', 'Разблокировать');
define('IMAGE_UPDATE', 'Обновить');
define('IMAGE_UPDATE_CURRENCIES', 'Скорректировать курсы валют');
define('IMAGE_UPLOAD', 'Загрузить');
define('TEXT_IMAGE_NONEXISTENT', 'Нет картинки'); 

define('ICON_CROSS', 'Недействительно');
define('ICON_CURRENT_FOLDER', 'Текущая директория');
define('ICON_DELETE', 'Удалить');
define('ICON_ERROR', 'Ошибка:');
define('ICON_FILE', 'Файл');
define('ICON_FILE_DOWNLOAD', 'Загрузка');
define('ICON_FOLDER', 'Папка');
define('ICON_LOCKED', 'Заблокировать');
define('ICON_PREVIOUS_LEVEL', 'Предыдущий уровень');
define('ICON_PREVIEW', 'Редактировать');
define('ICON_STATISTICS', 'Статистика');
define('ICON_SUCCESS', 'Выполнено');
define('ICON_TICK', 'Истина');
define('ICON_UNLOCKED', 'Разблокировать');
define('ICON_WARNING', 'ВНИМАНИЕ');

// constants for use in tep_prev_next_display function
define('TEXT_RESULT_PAGE', 'Страница %s из %d');

define('TEXT_DISPLAY_NUMBER_OF_BANNERS', 'Показано <b>%d</b> - <b>%d</b> (всего <b>%d</b> баннеров)');
define('TEXT_DISPLAY_NUMBER_OF_COUNTRIES', 'Показано <b>%d</b> - <b>%d</b> (всего <b>%d</b> стран)');
define('TEXT_DISPLAY_NUMBER_OF_CUSTOMERS', 'Показано <b>%d</b> - <b>%d</b> (всего <b>%d</b> клиентов)');
define('TEXT_DISPLAY_NUMBER_OF_CURRENCIES', 'Показано <b>%d</b> - <b>%d</b> (всего <b>%d</b> валют)');
define('TEXT_DISPLAY_NUMBER_OF_LANGUAGES', 'Показано <b>%d</b> - <b>%d</b> (всего <b>%d</b> языковых модулей)');
define('TEXT_DISPLAY_NUMBER_OF_MANUFACTURERS', 'Показано <b>%d</b> - <b>%d</b> (всего <b>%d</b> производителей)');
define('TEXT_DISPLAY_NUMBER_OF_NEWSLETTERS', 'Показано <b>%d</b> - <b>%d</b> (всего <b>%d</b> рассылок)');
define('TEXT_DISPLAY_NUMBER_OF_ORDERS', 'Показано <b>%d</b> - <b>%d</b> (всего <b>%d</b> заказов)');
define('TEXT_DISPLAY_NUMBER_OF_ORDERS_STATUS', 'Показано <b>%d</b> - <b>%d</b> (всего <b>%d</b> статуса)');
define('TEXT_DISPLAY_NUMBER_OF_PRODUCTS', 'Показано <b>%d</b> - <b>%d</b> (всего <b>%d</b> позиций)');
define('TEXT_DISPLAY_NUMBER_OF_PRODUCTS_EXPECTED', 'Показано <b>%d</b> - <b>%d</b> (всего <b>%d</b> ожидаемых товаров)');
define('TEXT_DISPLAY_NUMBER_OF_REVIEWS', 'Показано <b>%d</b> - <b>%d</b> (всего <b>%d</b> отзывов о товарах)');
define('TEXT_DISPLAY_NUMBER_OF_SPECIALS', 'Показано <b>%d</b> - <b>%d</b> (всего <b>%d</b> специальных предложений)');
define('TEXT_DISPLAY_NUMBER_OF_TAX_CLASSES', 'Показано <b>%d</b> - <b>%d</b> (всего <b>%d</b> типов налогов)');
define('TEXT_DISPLAY_NUMBER_OF_TAX_ZONES', 'Показано <b>%d</b> - <b>%d</b> (всего <b>%d</b> налоговых зон)');
define('TEXT_DISPLAY_NUMBER_OF_TAX_RATES', 'Показано <b>%d</b> - <b>%d</b> (всего <b>%d</b> ставок налогов)');
define('TEXT_DISPLAY_NUMBER_OF_ZONES', 'Показано <b>%d</b> - <b>%d</b> (всего <b>%d</b> зон)');
define('TEXT_DISPLAY_NUMBER_OF_NEWS', 'Показано <b>%d</b> - <b>%d</b> (всего <b>%d</b> новостей)');
define('TEXT_DISPLAY_NUMBER_OF_FAQS', 'Показано <b>%d</b> - <b>%d</b> (всего <b>%d</b> вопросов)');

define('PREVNEXT_BUTTON_PREV', 'Предыдущая');
define('PREVNEXT_BUTTON_NEXT', 'Следующая');

define('TEXT_DEFAULT', 'по умолчанию');
define('TEXT_SET_DEFAULT', 'Установить по умолчанию');
define('TEXT_FIELD_REQUIRED', '&nbsp;<span class="fieldRequired">* Обязательно</span>');

define('ERROR_NO_DEFAULT_CURRENCY_DEFINED', 'Ошибка: К настоящему времени ни одна валюта не была установлена по умолчанию. Пожалуйста, установите одну из них в: Локализация -> Валюта');

define('TEXT_CACHE_CATEGORIES', 'Бокс Категорий');
define('TEXT_CACHE_MANUFACTURERS', 'Бокс Производителей');
define('TEXT_CACHE_ALSO_PURCHASED', 'Также Модули Покупок'); 

define('TEXT_NONE', '--нет--');
define('TEXT_TOP', 'Начало');

define('ERROR_DESTINATION_DOES_NOT_EXIST', 'Ошибка: Каталог не существует.');
define('ERROR_DESTINATION_NOT_WRITEABLE', 'Ошибка: Каталог защищён от записи, установите необходимые права доступа.');
define('ERROR_FILE_NOT_SAVED', 'Ошибка: Файл не был загружен.');
define('ERROR_FILETYPE_NOT_ALLOWED', 'Ошибка: Нельзя закачивать файлы данного типа.');
define('SUCCESS_FILE_SAVED_SUCCESSFULLY', 'Выполнено: Файл успешно загружен.');
define('WARNING_NO_FILE_UPLOADED', 'Предупреждение: Ни одного файла не загружено.');
define('WARNING_FILE_UPLOADS_DISABLED', 'Предупреждение: Опция загрузки файлов отключена в конфигурационном файле php.ini.');

define('BOX_CATALOG_XSELL_PRODUCTS', 'Сопутствующие товары');

define('IMAGE_BUTTON_PRINT_ORDER', 'Версия для печати');

 // X-Sell
REQUIRE(DIR_WS_LANGUAGES . 'add_ccgvdc_russian.php');

// BOF: Lango Added for print order MOD
define('IMAGE_BUTTON_PRINT', 'Печатать');
// EOF: Lango Added for print order MOD

// BOF: Lango Added for Featured product MOD
  define('BOX_CATALOG_FEATURED', 'Рекомендуемые товары');
// EOF: Lango Added for Featured product MOD

// BOF: Lango Added for Sales Stats MOD
define('BOX_REPORTS_MONTHLY_SALES', 'Статистика продаж');
// EOF: Lango Added for Sales Stats MOD

// BOF: Lango Added for template MOD
// WebMakers.com Added: Attribute Sorter, Copier and Catalog additions
require(DIR_WS_LANGUAGES . $language . '/' . 'attributes_sorter.php');

//BEGIN Dynamic information pages unlimited
define('BOX_HEADING_INFORMATION', 'Информационные страницы');
define('BOX_INFORMATION', 'Страницы');
//END Dynamic information pages unlimited

	define('BOX_REPORTS_RECOVER_CART_SALES', 'Незавершённые заказы');
	define('BOX_TOOLS_RECOVER_CART', 'Незавершённые заказы');

  define('BOX_TOOLS_KEYWORDS', 'Поисковые запросы');

// RJW Begin Meta Tags Code
  define('TEXT_META_TITLE', 'Meta Title');
  define('TEXT_META_DESCRIPTION', 'Meta Description');
  define('TEXT_META_KEYWORDS', 'Meta Keywords');
// RJW End Meta Tags Code

// Article Manager
define('BOX_HEADING_ARTICLES', 'Статьи');
define('BOX_TOPICS_ARTICLES', 'Статьи/Разделы');
define('BOX_ARTICLES_CONFIG', 'Настройка');
define('BOX_ARTICLES_AUTHORS', 'Авторы');
define('BOX_ARTICLES_REVIEWS', 'Отзывы'); 
define('BOX_ARTICLES_XSELL', 'Товары-Статьи');
define('IMAGE_NEW_TOPIC', 'Новый раздел');
define('IMAGE_NEW_ARTICLE', 'Новая статья');
define('TEXT_DISPLAY_NUMBER_OF_AUTHORS', 'Показано <b>%d</b> - <b>%d</b> (всего <b>%d</b> авторов)'); 

//TotalB2B start
define('BOX_CUSTOMERS_GROUPS', 'Группы');
define('BOX_MANUDISCOUNT', 'Скидка на товары одного производителя');
//TotalB2B end

// add for Group minimum price to order start		
define('GROUP_MIN_PRICE', 'Минимальная стоимость заказа группы');
// add for Group minimum price to order end

// add for color groups start
define('GROUP_COLOR_BAR', 'Цвет группы');
// add for color groups end
//TotalB2B end
define('BOX_CATALOG_QUICK_UPDATES', 'Обновление прайса');

define('IMAGE_PROPERTIES_POPUP_ADD_CHANGE_DELETE', 'Изменить/удалить тех. параметры');
define('IMAGE_PROPERTIES_POPUP_ADD', 'Добавить тех. параметры');
define('IMAGE_PROPERTIES', 'Тех. параметры');

// polls box text in includes/boxes/polls.php

define('BOX_HEADING_POLLS', 'Опросы');
define('BOX_POLLS_POLLS', 'Опросы');
define('BOX_POLLS_CONFIG','Настройки');

define('BOX_INDEX_GIFTVOUCHERS', 'Сертификаты / Купоны');

define('BOX_REPORTS_SALES_REPORT2', 'Статистика продаж 2');
define('BOX_REPORTS_SALES_REPORT', 'Статистика продаж 3');
define('BOX_REPORTS_CUSTOMERS_ORDERS', 'Статистика клиентов');

define('TEXT_NEW_ATTRIBUTE_EDIT', 'Редактировать атрибуты товара');

define('CONFIGURATION_GROUP_1', 'Мой магазин');
define('CONFIGURATION_GROUP_2', 'Минимальные значения');
define('CONFIGURATION_GROUP_3', 'Максимальные значения');
define('CONFIGURATION_GROUP_4', 'Картинки');
define('CONFIGURATION_GROUP_5', 'Данные покупателя');
define('CONFIGURATION_GROUP_6', 'Установленные модули');
define('CONFIGURATION_GROUP_7', 'Доставка/Упаковка');
define('CONFIGURATION_GROUP_8', 'Вывод товара');
define('CONFIGURATION_GROUP_9', 'Склад');
define('CONFIGURATION_GROUP_10', 'Логи');
define('CONFIGURATION_GROUP_11', 'Кэш');
define('CONFIGURATION_GROUP_12', 'Настройка E-Mail');
define('CONFIGURATION_GROUP_13', 'Скачивание');
define('CONFIGURATION_GROUP_14', 'GZip Компрессия');
define('CONFIGURATION_GROUP_15', 'Сессии');
define('CONFIGURATION_GROUP_112', 'HTML редактор');
define('CONFIGURATION_GROUP_900', 'Партнёрская программа');
define('CONFIGURATION_GROUP_16', 'Тех. обслуживание');
define('CONFIGURATION_GROUP_40', 'Быстрое оформление');
define('CONFIGURATION_GROUP_901', 'Ссылки');
define('CONFIGURATION_GROUP_300', 'Обновление прайса');
define('CONFIGURATION_GROUP_12954', 'Отложенные товары');
define('CONFIGURATION_GROUP_26229', 'Кэш страниц');
define('CONFIGURATION_GROUP_26230', 'Яндекс-Маркет');
define('CONFIGURATION_GROUP_401', 'Список категорий на главной странице');
define('CONFIGURATION_GROUP_160', 'Установщик модулей');
define('CONFIGURATION_GROUP_72', 'Редактор заказов');
define('CONFIGURATION_GROUP_735', 'Картинки атрибутов');
define('CONFIGURATION_GROUP_736', 'Боксы');
define('CONFIGURATION_GROUP_1610', 'Спецификации товаров');

define('FAQDESK_LISTING_DB', 'Настройки вывода');
define('FAQDESK_SETTINGS_DB', 'Общие настройки');
define('FAQDESK_REVIEWS_DB', 'Настройка отзывов');
define('FAQDESK_STICKY_DB', 'Настройка "горячих" вопросов');
define('FAQDESK_OTHER_DB', 'Другие настройки');

define('NEWSDESK_LISTING_DB', 'Настройки вывода');
define('NEWSDESK_SETTINGS_DB', 'Общие настройки');
define('NEWSDESK_REVIEWS_DB', 'Настройка отзывов');
define('NEWSDESK_STICKY_DB', 'Настройка "горячих" новостей');

define('ATTRIBUTES_COPY_TEXT1', ' Внимание: Нельзя скопировать атрибуты из товара номер ');
define('ATTRIBUTES_COPY_TEXT2', ' в товар номер');
define('ATTRIBUTES_COPY_TEXT3', '. Ничего не скопировано.');
define('ATTRIBUTES_COPY_TEXT4', ' Внимание: Нет атрибутов для копирования из товара номер ');
define('ATTRIBUTES_COPY_TEXT5', ' в товар ');
define('ATTRIBUTES_COPY_TEXT6', '. Ничего не скопировано.');
define('ATTRIBUTES_COPY_TEXT7', ' Внимание: Товар с номером ');
define('ATTRIBUTES_COPY_TEXT8', ' не найден. Либо Вы не указали номер товара, либо указанный товар не существует. Ничего не скопировано.');

//include('includes/languages/english_support.php');

// BOF FlyOpenair: Extra Product Price
define('BOX_EXTRA_PRODUCT_PRICE', 'Наценки');
define('EXTRA_PRODUCT_PRICE_ID_TITLE', 'Система наценок');
define('EXTRA_PRODUCT_PRICE_ID_DESC', 'Включение и выключение модуля системы наценок');
// EOF FlyOpenair: Extra Product Price

define('BOX_TITLE_VAM', 'osCommerce');
define('VAM_LINK_TITLE', 'Что такое osCommerce VaM Edition');
define('VAM_LINK_FORUM', 'Форум поддержки');
define('VAM_LINK_BUGTRACKER', 'Найди ошибку');
define('VAM_LINK_MANUAL', 'Руководство пользователя osCommerce VaM Edition');
define('VAM_LINK_MODULES', 'Модули');
define('VAM_LINK_TEMPLATES', 'Шаблоны');
define('VAM_LINK_SERVICES', 'Услуги');

define('TEXT_IMAGE_OVERWRITE_WARNING','Внимание: Имя файла было изменено, но не перезаписано ');          

define('BOX_MODULES_SHIP2PAY', 'Доставка-Оплата');
define('BROWSE_BY_CATEGORIES_TITLE', 'Просмотр категорий');

include('includes/languages/russian_newsdesk.php');
include('includes/languages/russian_faqdesk.php');
include('includes/languages/order_edit_russian.php');

define('BOX_TOOLS_EXTRA_FIELDS_MANAGER','Дополнительные поля покупателей');
define('ENTRY_EXTRA_FIELDS_ERROR','Поле %s должно содержать как минимум %d символов');
define('TEXT_DISPLAY_NUMBER_OF_FIELDS', 'Показано <b>%d</b> - <b>%d</b> (всего <b>%d</b> полей)');

// START: Product Extra Fields
define('BOX_CATALOG_PRODUCTS_EXTRA_FIELDS', 'Дополнительные поля товаров');
// END: Product Extra Fields

define('CIP_TITLE','Установка модулей');
define('BOX_CONTRIB_INSTALLER', 'Установка модулей');

define('TEXT_OTHER', 'Другой');         

define('TEXT_INDEX_LANGUAGE','Язык: ');
define('TEXT_SUMMARY_CUSTOMERS','Покупатели');
define('TEXT_SUMMARY_ORDERS','Заказы');
define('TEXT_SUMMARY_PRODUCTS','Товары');
define('TEXT_SUMMARY_HELP','Помощь');
define('TEXT_SUMMARY_STAT','Статистика');

define('TABLE_HEADING_HELP', 'Помощь');

define('TABLE_HEADING_CUSTOMERS', 'Последние покупатели');
define('TABLE_HEADING_LASTNAME', 'Фамилия');
define('TABLE_HEADING_FIRSTNAME', 'Имя');
define('TABLE_HEADING_DATE', 'Дата');

define('TABLE_HEADING_ORDERS', 'Последние заказы');
define('TABLE_HEADING_CUSTOMER', 'Покупатель');
define('TABLE_HEADING_NUMBER', 'Номер');
define('TABLE_HEADING_ORDER_TOTAL', 'Сумма');
define('TABLE_HEADING_STATUS', 'Статус');

define('TABLE_HEADING_SUMMARY_PRODUCTS', 'Последние товары');
define('TABLE_HEADING_PRODUCT_NAME', 'Товары');
define('TABLE_HEADING_PRODUCT_PRICE', 'Стоимость');

define('BOX_CATEGORY_SPECIALS', 'Категории со скидками');
define('TEXT_DISPLAY_NUMBER_OF_SPECIAL_CATEGORY', 'Показано <b>%d</b> - <b>%d</b> (всего <b>%d</b> категорий со скидками)');

//Options as Images Mod
define('BOX_CATALOG_OPTIONS_IMAGES', 'Картинки атрибутов');

define('BOX_CATALOG_CATEGORIES_PRODUCTS_MULTI', 'Массовое удаление/копирование/перемещение товаров.');

// Products Specifications
define('BOX_CATALOG_PRODUCTS_SPECIFICATIONS', 'Спецификации товаров');

define('BOX_EMAIL_QUEUE', 'Очередь email');
         
define('TEXT_DISPLAY_NUMBER_OF_ENTRIES', 'Показано <b>%d</b> - <b>%d</b> (всего <b>%d</b> записей)');

define('BOX_YML_IMPORT', 'Я-маркет импорт/экспорт');
         
define('BOX_CUSTOMERS_EXPORTORDERS', 'Экспорт заказов');
define('BOX_CUSTOMERS_EXPORT', 'Экспорт клиентов'); 
 
define('TABLE_TEXT_IS_PIN','Товар имеет PIN код');
define('BOX_CATALOG_PIN_LOADER','PIN коды');

define('CONFIGURATION_GROUP_80', 'Оформление заказов');

//mail manager
define('BOX_HEADING_MAIL_MANAGER', 'Mail Manager');
define('BOX_MM_BULKMAIL', 'BulkMail Manager');
define('BOX_MM_TEMPLATES', 'Template Manager');
define('BOX_MM_EMAIL', 'Send Email');
define('BOX_MM_RESPONSEMAIL', 'Response Mail');

         
?>