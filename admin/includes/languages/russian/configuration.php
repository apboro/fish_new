<?php
/*
  $Id: configuration.php,v 1.2 2003/09/24 13:57:08 wilt Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2002 osCommerce

  Released under the GNU General Public License
*/

define('TABLE_HEADING_CONFIGURATION_TITLE', 'Заголовок');
define('TABLE_HEADING_CONFIGURATION_VALUE', 'Значение');
define('TABLE_HEADING_ACTION', 'Действие');

define('TEXT_INFO_EDIT_INTRO', 'Пожалуйста, внесите необходимые изменения');
define('TEXT_INFO_DATE_ADDED', 'Дата добавления:');
define('TEXT_INFO_LAST_MODIFIED', 'Последнее изменение:');
define('ERROR_TEMPLATE_IMAGE_DIRECTORY_NOT_WRITEABLE', 'Директория защищена от записи, установите верные права доступа (например chmod 777) для директории ');
define('ERROR_TEMPLATE_IMAGE_DIRECTORY_DOES_NOT_EXIST', 'Директория отсутствует, создайте директорию ');

// Мой магазин

define('DEFAULT_TEMPLATE_TITLE' , 'Шаблон по умолчанию');
define('STORE_NAME_TITLE' , 'Название магазина');
define('STORE_OWNER_TITLE' , 'Владелец магазина');
define('STORE_LOGO_TITLE' , 'Логотип магазина');
define('STORE_OWNER_EMAIL_ADDRESS_TITLE' , 'E-Mail Адрес');
define('STORE_OWNER_ICQ_NUMBER_TITLE' , 'ICQ номер');
define('EMAIL_FROM_TITLE' , 'E-Mail От');
define('STORE_COUNTRY_TITLE' , 'Страна');
define('STORE_ZONE_TITLE' , 'Регион');
define('EXPECTED_PRODUCTS_SORT_TITLE' , 'Порядок сортировки ожидаемых товаров');
define('EXPECTED_PRODUCTS_FIELD_TITLE' , 'Сортировка ожидаемых товаров');
define('USE_DEFAULT_LANGUAGE_CURRENCY_TITLE' , 'Переключение на валюту текущего языка');
define('SEND_EXTRA_ORDER_EMAILS_TO_TITLE' , 'Отправка копий писем с заказом');
define('SEARCH_ENGINE_FRIENDLY_URLS_TITLE' , 'Использовать короткие URL адреса (находится в разработке)');
define('DISPLAY_CART_TITLE' , 'Переходить в корзину после добавления товара');
define('ALLOW_GUEST_TO_TELL_A_FRIEND_TITLE' , 'Разрешить гостям использовать функцию Рассказать другу');
define('ADVANCED_SEARCH_DEFAULT_OPERATOR_TITLE' , 'Оператор поиска по умолчанию');
define('STORE_NAME_ADDRESS_TITLE' , 'Адрес и телефон магазина');
define('SHOW_COUNTS_TITLE' , 'Показывать счётчик товаров');
define('ALLOW_CATEGORY_DESCRIPTIONS_TITLE' , 'Разрешить описания категорий');
define('TAX_DECIMAL_PLACES_TITLE' , 'Количество знаков после запятой у налогов');
define('SHOW_MAIN_FEATURED_PRODUCTS_TITLE' , 'Показывать рекомендуемые товары на главной странице');
define('DISPLAY_PRICE_WITH_TAX_TITLE' , 'Показывать цены с налогами');
define('XPRICES_NUM_TITLE' , 'Количество возможных цен для товара');
define('NEW_SIGNUP_GIFT_VOUCHER_AMOUNT_TITLE' , 'Номинал подарочного сертификата, который получат посетители');
define('ALLOW_GUEST_TO_SEE_PRICES_TITLE' , 'Показывать цены посетителям');
define('NEW_SIGNUP_DISCOUNT_COUPON_TITLE' , 'Код купона, который получат посетители, прошедшие регистрацию');
define('GUEST_DISCOUNT_TITLE' , 'Наценка для посетителей');
define('CATEGORIES_SORT_ORDER_TITLE' , 'Сортировка товара, категорий');
define('QUICKSEARCH_IN_DESCRIPTION_TITLE' , 'Поиск в описаниях товара');
define('CONTACT_US_LIST_TITLE' , 'Получатели писем, отправленных со страницы Свяжитесь с нами');
define('ALLOW_GIFT_VOUCHERS_TITLE' , 'Разрешить использование подарочных сертификатов и купонов');
define('ALLOW_ATTRIBUTES_IN_PRODUCT_EDIT_PAGE_TITLE' , 'Разрешить управление атрибутами на странице добавления товара');
define('SHOW_SUBCATEGORIES_WHEN_CATEGORIES_HAS_PRODUCTS_TITLE' , 'Выводить субкатегории при наличии товара в категории');
define('SHOW_PDF_DATASHEET_TITLE' , 'Показывать PDF описание товара');

// Минимальнаые значения

define('ENTRY_FIRST_NAME_MIN_LENGTH_TITLE' , 'Имя');
define('ENTRY_LAST_NAME_MIN_LENGTH_TITLE' , 'Фамилия');
define('ENTRY_DOB_MIN_LENGTH_TITLE' , 'Дата рождения');
define('ENTRY_EMAIL_ADDRESS_MIN_LENGTH_TITLE' , 'E-Mail адрес');
define('ENTRY_STREET_ADDRESS_MIN_LENGTH_TITLE' , 'Адрес');
define('ENTRY_COMPANY_MIN_LENGTH_TITLE' , 'Компания');
define('ENTRY_POSTCODE_MIN_LENGTH_TITLE' , 'Почтовый индекс');
define('ENTRY_CITY_MIN_LENGTH_TITLE' , 'Город');
define('ENTRY_STATE_MIN_LENGTH_TITLE' , 'Регион');
define('ENTRY_TELEPHONE_MIN_LENGTH_TITLE' , 'Телефон');
define('ENTRY_PASSWORD_MIN_LENGTH_TITLE' , 'Пароль');
define('CC_OWNER_MIN_LENGTH_TITLE' , 'Владелец кредитной карточки');
define('CC_NUMBER_MIN_LENGTH_TITLE' , 'Номер кредитной карточки');
define('REVIEW_TEXT_MIN_LENGTH_TITLE' , 'Текст отзыва');
define('MIN_DISPLAY_BESTSELLERS_TITLE' , 'Лидеры продаж');
define('MIN_DISPLAY_ALSO_PURCHASED_TITLE' , 'Также заказали');
define('MIN_DISPLAY_XSELL_TITLE' , 'Связанные товары');
define('MIN_ORDER_TITLE' , 'Минимальная сумма заказа');

// Максимальные значения

define('MAX_PROD_ADMIN_SIDE_TITLE' , 'Товаров на одной странице в администраторской');
define('MAX_ADDRESS_BOOK_ENTRIES_TITLE' , 'Записи в адресной книге');
define('MAX_DISPLAY_SEARCH_RESULTS_TITLE' , 'Товаров на одной странице в каталоге');
define('MAX_DISPLAY_PAGE_LINKS_TITLE' , 'Ссылок на страницы');
define('MAX_DISPLAY_SPECIAL_PRODUCTS_TITLE' , 'Специальные цены');
define('MAX_DISPLAY_NEW_PRODUCTS_TITLE' , 'Новинки');
define('MAX_DISPLAY_UPCOMING_PRODUCTS_TITLE' , 'Ожидаемые товары');
define('MAX_DISPLAY_MANUFACTURERS_IN_A_LIST_TITLE' , 'Список производителей');
define('MAX_MANUFACTURERS_LIST_TITLE' , 'Производители в виде развёрнутого меню');
define('MAX_DISPLAY_MANUFACTURER_NAME_LEN_TITLE' , 'Ограничение длины названия производителя');
define('MAX_DISPLAY_NEW_REVIEWS_TITLE' , 'Новые отзывы');
define('MAX_RANDOM_SELECT_REVIEWS_TITLE' , 'Выбор случайных отзывов');
define('MAX_RANDOM_SELECT_NEW_TITLE' , 'Выбор случайного товара в боксе Новинки');
define('MAX_RANDOM_SELECT_SPECIALS_TITLE' , 'Выбор случайного товара в боксе Скидки');
define('MAX_DISPLAY_CATEGORIES_PER_ROW_TITLE' , 'Количество категорий в строке');
define('MAX_DISPLAY_PRODUCTS_NEW_TITLE' , 'Количество Новинок на странице');
define('MAX_DISPLAY_BESTSELLERS_TITLE' , 'Лидеры продаж');
define('MAX_DISPLAY_ALSO_PURCHASED_TITLE' , 'Также заказали');
define('MAX_DISPLAY_PRODUCTS_IN_ORDER_HISTORY_BOX_TITLE' , 'Бокс История заказов');
define('MAX_DISPLAY_ORDER_HISTORY_TITLE' , 'История заказов');
define('MAX_DISPLAY_FEATURED_PRODUCTS_TITLE' , 'Товаров в боксе Рекомендуемые товары на главной странице');
define('MAX_DISPLAY_FEATURED_PRODUCTS_LISTING_TITLE' , 'Товаров на одной странице Рекомендуемых товаров');

// Картинки

define('SMALL_IMAGE_WIDTH_TITLE' , 'Ширина маленькой картинки');
define('SMALL_IMAGE_HEIGHT_TITLE' , 'Высота маленькой картинки');
define('HEADING_IMAGE_WIDTH_TITLE' , 'Ширина картинки категории');
define('HEADING_IMAGE_HEIGHT_TITLE' , 'Высота картинки категории');
define('SUBCATEGORY_IMAGE_WIDTH_TITLE' , 'Ширина картинки подкатегории');
define('SUBCATEGORY_IMAGE_HEIGHT_TITLE' , 'Высота картинки подкатегории');
define('CONFIG_CALCULATE_IMAGE_SIZE_TITLE' , 'Вычислять размер картинки');
define('IMAGE_REQUIRED_TITLE' , 'Картинка обязательна');
define('ULTIMATE_ADDITIONAL_IMAGES_TITLE' , 'Разрешить использование модуля дополнительных картинок?');
define('ULT_THUMB_IMAGE_WIDTH_TITLE' , 'Ширина дополнительной картинки');
define('ULT_THUMB_IMAGE_HEIGHT_TITLE' , 'Высота дополнительной картинки');
define('MEDIUM_IMAGE_WIDTH_TITLE' , 'Ширина большой картинки');
define('MEDIUM_IMAGE_HEIGHT_TITLE' , 'Высота большой картинки');
define('LARGE_IMAGE_WIDTH_TITLE' , 'Ширина картинки для pop-up окна');
define('LARGE_IMAGE_HEIGHT_TITLE' , 'Высота картинки для pop-up окна');

// Данные покупателя

define('ACCOUNT_GENDER_TITLE' , 'Пол');
define('ACCOUNT_DOB_TITLE' , 'Дата рождения');
define('ACCOUNT_COMPANY_TITLE' , 'Компания');
define('ACCOUNT_SUBURB_TITLE' , 'Район');
define('ACCOUNT_STATE_TITLE' , 'Регион');
define('ACCOUNT_STREET_ADDRESS_TITLE' , 'Адрес');
define('ACCOUNT_CITY_TITLE' , 'Город');
define('ACCOUNT_POSTCODE_TITLE' , 'Почтовый индекс');
define('ACCOUNT_COUNTRY_TITLE' , 'Страна');
define('ACCOUNT_TELE_TITLE' , 'Телефон');
define('ACCOUNT_FAX_TITLE' , 'Факс');
define('ACCOUNT_NEWS_TITLE' , 'Рассылка');

// Доставка/упаковка

define('SHIPPING_ORIGIN_COUNTRY_TITLE' , 'Страна магазина');
define('SHIPPING_ORIGIN_ZIP_TITLE' , 'Почтовый индекс магазина');
define('SHIPPING_MAX_WEIGHT_TITLE' , 'Максимальный вес доставки');
define('SHIPPING_BOX_WEIGHT_TITLE' , 'Минимальный вес упаковки');
define('SHIPPING_BOX_PADDING_TITLE' , 'Вес упаковки в процентах'); 
define('MODULE_ORDER_TOTAL_SHIPPING_FREE_SHIPPING_TITLE' , 'Разрешить бесплатную доставку');
define('MODULE_ORDER_TOTAL_SHIPPING_FREE_SHIPPING_OVER_TITLE' , 'Бесплатная доставка для заказов на сумму свыше');
define('MODULE_ORDER_TOTAL_SHIPPING_DESTINATION_TITLE' , 'Бесплатная доставка для заказов, оформленных из');
define('SHOW_SHIPPING_ESTIMATOR_TITLE' , 'Показывать способы и стоимость доставки в корзине');
define('SHOW_XSELL_CART_TITLE' , 'Показывать сопутствующие в корзине');

// Вывод товара

define('PRODUCT_LISTING_DISPLAY_STYLE_TITLE' , 'Формат вывода товара');
define('PRODUCT_LIST_IMAGE_TITLE' , 'Показывать картинку товара');
define('PRODUCT_LIST_COL_NUM_TITLE' , 'Количество товара в одной строке');
define('PRODUCT_LIST_MANUFACTURER_TITLE' , 'Показывать производителя товара');
define('PRODUCT_LIST_MODEL_TITLE' , 'Показывать код товара');
define('PRODUCT_LIST_NAME_TITLE' , 'Показывать название товара');
define('PRODUCT_LIST_PRICE_TITLE' , 'Показывать стоимость товара');
define('PRODUCT_LIST_QUANTITY_TITLE' , 'Показывать количество товара на складе');
define('PRODUCT_LIST_WEIGHT_TITLE' , 'Показывать вес товара');
define('PRODUCT_LIST_BUY_NOW_TITLE' , 'Показывать кнопку Купить сейчас!');
define('PRODUCT_LIST_FILTER_TITLE' , 'Показывать фильтр Категория/Производители (0=не показывать; 1=показывать)');
define('PREV_NEXT_BAR_LOCATION_TITLE' , 'Расположение навигации Следующая/Предыдущая страница');
define('PRODUCT_LIST_INFO_TITLE' , 'Показывать краткое описание');
define('PRODUCT_SORT_ORDER_TITLE' , 'Показывать порядок сортировки');

// Склад

define('STOCK_CHECK_TITLE' , 'Проверять наличие товара на складе');
define('STOCK_LIMITED_TITLE' , 'Вычитать товар со склада');
define('STOCK_ALLOW_CHECKOUT_TITLE' , 'Разрешить оформление заказа');
define('STOCK_MARK_PRODUCT_OUT_OF_STOCK_TITLE' , 'Отмечать товар, отсутствующий на складе');
define('STOCK_REORDER_LEVEL_TITLE' , 'Лимит количества товара на складе');

// Логи

define('STORE_PAGE_PARSE_TIME_TITLE' , 'Сохранять время парсинга страниц');
define('STORE_PAGE_PARSE_TIME_LOG_TITLE' , 'Директория хранения логов');
define('STORE_PARSE_DATE_TIME_FORMAT_TITLE' , 'Формат даты логов');
define('DISPLAY_PAGE_PARSE_TIME_TITLE' , 'Показывать время парсинга страниц');
define('STORE_DB_TRANSACTIONS_TITLE' , 'Сохранять запросы к базе дынных');

// Кэш

define('USE_CACHE_TITLE' , 'Использовать кэш');
define('DIR_FS_CACHE_TITLE' , 'Кэш директория');

// Настройка E-Mail

define('EMAIL_TRANSPORT_TITLE' , 'Способ отправки E-Mail');
define('EMAIL_LINEFEED_TITLE' , 'Разделитель строк в E-Mail');
define('EMAIL_USE_HTML_TITLE' , 'Использовать HTML формат при отправке писем');
define('ENTRY_EMAIL_ADDRESS_CHECK_TITLE' , 'Проверять E-Mail адрес через DNS');
define('SEND_EMAILS_TITLE' , 'Отправлять письма из магазина');

// Скачивание

define('DOWNLOAD_ENABLED_TITLE' , 'Разрешить функцию скачивания товаров');
define('DOWNLOAD_BY_REDIRECT_TITLE' , 'Использовать перенаправление при скачивании');
define('DOWNLOAD_MAX_DAYS_TITLE' , 'Срок существования ссылки для скачивания (дней)');
define('DOWNLOAD_MAX_COUNT_TITLE' , 'Максимальное количество скачиваний');
define('DOWNLOADS_ORDERS_STATUS_UPDATED_VALUE_TITLE' , 'Сброс статистики скачиваний');
define('DOWNLOADS_CONTROLLER_ON_HOLD_MSG_TITLE' , 'Предупреждением о необходимости оплатить скачиваемый товар');
define('DOWNLOADS_CONTROLLER_ORDERS_STATUS_TITLE' , 'Скачивание разрешается только заказам, имеющим указанный статус и выше');

// GZip Компрессия

define('GZIP_COMPRESSION_TITLE' , 'Разрешить GZip компрессию');
define('GZIP_LEVEL_TITLE' , 'Уровень компрессии');

// Сессии

define('SESSION_WRITE_DIRECTORY_TITLE' , 'Директория сессий');
define('SESSION_FORCE_COOKIE_USE_TITLE' , 'Принудительное использование Cookie');
define('SESSION_CHECK_SSL_SESSION_ID_TITLE' , 'Проверять ID SSL сессии');
define('SESSION_CHECK_USER_AGENT_TITLE' , 'Проверять переменную User Agent');
define('SESSION_CHECK_IP_ADDRESS_TITLE' , 'Проверять IP адрес');
define('SESSION_BLOCK_SPIDERS_TITLE' , 'Не показывать сессию в адресе паукам поисковых машин');
define('SESSION_RECREATE_TITLE' , 'Воссоздавать сессию');

// HTML Редактор

define('HTML_AREA_WYSIWYG_DISABLE_TITLE' , 'Использовать HTML редактор для поля описание товара?');
define('HTML_AREA_WYSIWYG_DISABLE_JPSY_TITLE' , 'Использовать улучшенный модуль для добавления картинок к товару?');
define('HTML_AREA_WYSIWYG_BASIC_PD_TITLE' , 'Возможности HTML редактора для поля описание товара');
define('HTML_AREA_WYSIWYG_WIDTH_TITLE' , 'Ширина HTML редактора для поля описание товара');
define('HTML_AREA_WYSIWYG_HEIGHT_TITLE' , 'Высота HTML редактора для поля описание товара');
define('HTML_AREA_WYSIWYG_DISABLE_EMAIL_TITLE' , 'Использовать HTML редактор на странице отправить Email?');
define('HTML_AREA_WYSIWYG_BASIC_EMAIL_TITLE' , 'Возможности HTML редактора на странице отправить Email');
define('EMAIL_AREA_WYSIWYG_WIDTH_TITLE' , 'Ширина HTML редактора для страницы отправить EMail');
define('EMAIL_AREA_WYSIWYG_HEIGHT_TITLE' , 'Высота HTML редактора для страницы отправить EMail');
define('HTML_AREA_WYSIWYG_DISABLE_NEWSLETTER_TITLE' , 'Использовать HTML редактор на странице менеджер почтовых рассылок?');
define('HTML_AREA_WYSIWYG_BASIC_NEWSLETTER_TITLE' , 'Возможности HTML редактора на странице менеджер почтовых рассылок');
define('NEWSLETTER_EMAIL_WYSIWYG_WIDTH_TITLE' , 'Ширина HTML редактора для страницы менеджер почтовых рассылок');
define('NEWSLETTER_EMAIL_WYSIWYG_HEIGHT_TITLE' , 'Высота HTML редактора для страницы менеджер почтовых рассылок');
define('HTML_AREA_WYSIWYG_DISABLE_DEFINE_TITLE' , 'Использовать HTML редактор при редактировании главной страницы');
define('HTML_AREA_WYSIWYG_BASIC_DEFINE_TITLE' , 'Возможности HTML редактора при редактировании главной страницы');
define('HTML_AREA_WYSIWYG_DISABLE_ARTICLES_TITLE' , 'Использовать HTML редактор при редактировании статей');
define('HTML_AREA_WYSIWYG_BASIC_ARTICLES_TITLE' , 'Возможности HTML редактора при редактировании статей');
define('HTML_AREA_WYSIWYG_DISABLE_FAQDESK_TITLE' , 'Использовать HTML редактор при редактировании faq');
define('HTML_AREA_WYSIWYG_BASIC_FAQDESK_TITLE' , 'Возможности HTML редактора при редактировании faq');
define('HTML_AREA_WYSIWYG_DISABLE_NEWSDESK_TITLE' , 'Использовать HTML редактор при редактировании новостей');
define('HTML_AREA_WYSIWYG_BASIC_NEWSDESK_TITLE' , 'Возможности HTML редактора при редактировании новостей');
define('HTML_AREA_WYSIWYG_DISABLE_INFOPAGES_TITLE' , 'Использовать HTML редактор при редактировании информационных страниц');
define('HTML_AREA_WYSIWYG_BASIC_INFOPAGES_TITLE' , 'Возможности HTML редактора при редактировании информационных страниц');
define('DEFINE_MAINPAGE_WYSIWYG_WIDTH_TITLE' , 'Ширина HTML редактора при редактировании главной страницы');
define('DEFINE_MAINPAGE_WYSIWYG_HEIGHT_TITLE' , 'Высота HTML редактора при редактировании главной страницы');
define('HTML_AREA_WYSIWYG_FONT_TYPE_TITLE' , 'Глобальные настройки - Шрифт, используемый в интерфейсе HTML редактора');
define('HTML_AREA_WYSIWYG_FONT_SIZE_TITLE' , 'Глобальные настройки - Размер шрифта, используемого в интерфейсе HTML редактора');
define('HTML_AREA_WYSIWYG_FONT_COLOUR_TITLE' , 'Глобальные настройки - Цвет шрифта, используемого в интерфейсе HTML редактора');
define('HTML_AREA_WYSIWYG_BG_COLOUR_TITLE' , 'Глобальные настройки - Цвет фона в интерфейсе HTML редактора');
define('HTML_AREA_WYSIWYG_DEBUG_TITLE' , 'Глобальные настройки - Разрешить режим отладки?');

// Партнёрская программа

define('AFFILIATE_EMAIL_ADDRESS_TITLE' , 'E-Mail Адрес');
define('AFFILIATE_PERCENT_TITLE' , 'Процент с каждой продажи, начисляемый партнёру');
define('AFFILIATE_THRESHOLD_TITLE' , 'Минимальная сумма к оплате');
define('AFFILIATE_COOKIE_LIFETIME_TITLE' , 'Время хранения cookies');
define('AFFILIATE_BILLING_TIME_TITLE' , 'Выписка счетов к оплате');
define('AFFILIATE_PAYMENT_ORDER_MIN_STATUS_TITLE' , 'Минимальный статус заказа');
define('AFFILIATE_USE_CHECK_TITLE' , 'Оплата партнёрам через WebMoney');
define('AFFILIATE_USE_PAYPAL_TITLE' , 'Оплата партнёрам через PayPal');
define('AFFILIATE_USE_BANK_TITLE' , 'Оплата партнёрам переводом на счёт в банке');
define('AFFILATE_INDIVIDUAL_PERCENTAGE_TITLE' , 'Индивидуальные проценты для партнёров');
define('AFFILATE_USE_TIER_TITLE' , 'Партнёрская пирамида');
define('AFFILIATE_TIER_LEVELS_TITLE' , 'Количество уровей пирамиды');
define('AFFILIATE_TIER_PERCENTAGE_TITLE' , 'Процент комиссии партнёрской пирамиды');

// Модуль Dynamic MoPics

define('IN_IMAGE_BIGIMAGES_TITLE' , 'Каталог хранения больших картинок');
define('IN_IMAGE_THUMBS_TITLE' , 'Каталог хранения маленьких картинок');
define('MAIN_THUMB_IN_SUBDIR_TITLE' , 'Оригинальная картинка хранится в папке с автоматически генерируемыми картинками');
define('THUMBS_PER_ROW_TITLE' , 'Количество картинок в одной строке');
define('MORE_PICS_EXT_TITLE' , 'Префикс автоматически генерируемой картинки');
define('BIG_PIC_EXT_TITLE' , 'Префикс автоматичски генерируемой большой картинки');
define('THUMB_IMAGE_TYPE_TITLE' , 'Тип генерируемых картинок');
define('BIG_IMAGE_TYPE_TITLE' , 'Тип больших картинок');

// Тех. обслуживание

define('DOWN_FOR_MAINTENANCE_TITLE' , 'Техническое обслуживание: Вкл./Выкл.');
define('DOWN_FOR_MAINTENANCE_FILENAME_TITLE' , 'Техническое обслуживание: Имя файла');
define('DOWN_FOR_MAINTENANCE_HEADER_OFF_TITLE' , 'Техническое обслуживание: Не показывать шапку');
define('DOWN_FOR_MAINTENANCE_COLUMN_LEFT_OFF_TITLE' , 'Техническое обслуживание: Не показывать левую колонку');
define('DOWN_FOR_MAINTENANCE_COLUMN_RIGHT_OFF_TITLE' , 'Техническое обслуживание: Не показывать правую колонку');
define('DOWN_FOR_MAINTENANCE_FOOTER_OFF_TITLE' , 'Техническое обслуживание: Не показывать нижнюю часть');
define('DOWN_FOR_MAINTENANCE_PRICES_OFF_TITLE' , 'Техническое обслуживание: Не показывать цены');
define('EXCLUDE_ADMIN_IP_FOR_MAINTENANCE_TITLE' , 'Техническое обслуживание: Исключить указанный IP адрес');
define('WARN_BEFORE_DOWN_FOR_MAINTENANCE_TITLE' , 'Уведомлять посетителей магазина перед уходом на Техническое обслуживание');
define('PERIOD_BEFORE_DOWN_FOR_MAINTENANCE_TITLE' , 'Текст уведомления');
define('DISPLAY_MAINTENANCE_TIME_TITLE' , 'Показывать дату активации режима Техническое обслуживание');
define('DISPLAY_MAINTENANCE_PERIOD_TITLE' , 'Показывать период работы режима Техническое обслуживание');
define('TEXT_MAINTENANCE_PERIOD_TIME_TITLE' , 'Время работы режима Техническое обслуживание');

// Быстрое оформление

define('GUEST_ON_TITLE' , 'Быстрое оформление заказа');

// Ссылки

define('ENABLE_LINKS_COUNT_TITLE' , 'Счётчик переходов');
define('ENABLE_SPIDER_FRIENDLY_LINKS_TITLE' , 'Использовать короткие URL адреса');
define('LINKS_IMAGE_WIDTH_TITLE' , 'Ширина картинки');
define('LINKS_IMAGE_HEIGHT_TITLE' , 'Высота картинки');
define('LINK_LIST_IMAGE_TITLE' , 'Показывать картинку');
define('LINK_LIST_URL_TITLE' , 'Показывать URL');
define('LINK_LIST_TITLE_TITLE' , 'Показывать название ссылки');
define('LINK_LIST_DESCRIPTION_TITLE' , 'Показывать описание ссылки');
define('LINK_LIST_COUNT_TITLE' , 'Показывать количество переходов');
define('ENTRY_LINKS_TITLE_MIN_LENGTH_TITLE' , 'Минимальное количество символов поля Название сайта');
define('ENTRY_LINKS_URL_MIN_LENGTH_TITLE' , 'Минимальное количество символов поля URL Адрес');
define('ENTRY_LINKS_DESCRIPTION_MIN_LENGTH_TITLE' , 'Минимальное количество символов поля Описание');
define('ENTRY_LINKS_CONTACT_NAME_MIN_LENGTH_TITLE' , 'Минимальное количество символов поля Ваше имя');
define('LINKS_CHECK_PHRASE_TITLE' , 'Текст для проверки');

// Обновление прайса

define('DISPLAY_MODEL_TITLE' , 'Показывать код товара');
define('MODIFY_MODEL_TITLE' , 'Показывать код товара');
define('MODIFY_NAME_TITLE' , 'Показывать название товара');
define('DISPLAY_STATUT_TITLE' , 'Показывать статус товара');
define('DISPLAY_WEIGHT_TITLE' , 'Показывать вес товара');
define('DISPLAY_QUANTITY_TITLE' , 'Показывать количество товара');
define('DISPLAY_SORT_ORDER_TITLE' , 'Показывать порядок сортировки');
define('DISPLAY_ORDER_MIN_TITLE' , 'Показывать минимум для заказа');
define('DISPLAY_ORDER_UNITS_TITLE' , 'Показывать шаг');
define('DISPLAY_IMAGE_TITLE' , 'Показывать картинку товара');
define('DISPLAY_XML_TITLE' , 'Показывать XML');
define('DISPLAY_MANUFACTURER_TITLE' , 'Показывать производителя');
define('MODIFY_MANUFACTURER_TITLE' , 'Показывать производителей товара');
define('DISPLAY_TAX_TITLE' , 'Показывать налог');
define('MODIFY_TAX_TITLE' , 'Показывать налог');
define('DISPLAY_TVA_OVER_TITLE' , 'Показывать цены с налогами');
define('DISPLAY_TVA_UP_TITLE' , 'Показывать цены с налогами при изменении цены');
define('DISPLAY_PREVIEW_TITLE' , 'Показывать ссылку на описание товара');
define('DISPLAY_EDIT_TITLE' , 'Показывать ссылку на редактирование товара');
define('ACTIVATE_COMMERCIAL_MARGIN_TITLE' , 'Показывать возможность массового изменения цен');

// Отложенные товары

define('MAX_DISPLAY_WISHLIST_PRODUCTS_TITLE' , 'Количество отложенных товаров на странице');
define('MAX_DISPLAY_WISHLIST_BOX_TITLE' , 'Количество отложенных товаров в боксе');
define('DISPLAY_WISHLIST_EMAILS_TITLE' , 'Количество e-mail адресов');
define('WISHLIST_REDIRECT_TITLE' , 'Оставаться на странице карточки товара');

// Кэш страниц

define('ENABLE_PAGE_CACHE_TITLE' , 'Разрешить кэширование страниц');
define('PAGE_CACHE_LIFETIME_TITLE' , 'Срок жизни кэша');
define('PAGE_CACHE_DEBUG_MODE_TITLE' , 'Включить режим отладки?');
define('PAGE_CACHE_DISABLE_PARAMETERS_TITLE' , 'Отключать URL параметры?');
define('PAGE_CACHE_DELETE_FILES_TITLE' , 'Удалять кэш файлы?');
define('PAGE_CACHE_UPDATE_CONFIG_FILES_TITLE' , 'Настроить обновление кэш файлов?');

// Яндекс маркет

define('YML_NAME_TITLE' , 'Название магазина');
define('YML_COMPANY_TITLE' , 'Название компании');
define('YML_DELIVERYINCLUDED_TITLE' , 'Доставка включена');
define('YML_AVAILABLE_TITLE' , 'Товар в наличии');
define('YML_AUTH_USER_TITLE' , 'Логин');
define('YML_AUTH_PW_TITLE' , 'Пароль');
define('YML_REFERER_TITLE' , 'Ссылка');
define('YML_STRIP_TAGS_TITLE' , 'Теги');
define('YML_UTF8_TITLE' , 'Перекодировка в windows-1251');
define('YML_SALES_NOTES_TITLE' , 'Тэг sales_notes');

// Описание полей

// Мой магазин

define('DEFAULT_TEMPLATE_DESC', 'Здесь Вы можете указать шаблон, используемый в магазине по умолчанию.');
define('STORE_NAME_DESC', 'Название Вашего магазина');
define('STORE_OWNER_DESC', 'Имя владельца магазина');
define('STORE_LOGO_DESC', 'Укажите логотип Вашего магазина');
define('STORE_OWNER_EMAIL_ADDRESS_DESC', 'E-Mail адрес владельца магазина');
define('STORE_OWNER_ICQ_NUMBER_DESC', 'ICQ номер, который будет выведен в боксе Консультант в магазине.');
define('EMAIL_FROM_DESC', 'E-Mail адрес в отправляемых письмах');
define('STORE_COUNTRY_DESC', 'Страна нахождения магазина.<br><br><b>Замечание: Не забудьте также указать Зону.</b>');
define('STORE_ZONE_DESC', 'Регион нахождения магазина');
define('EXPECTED_PRODUCTS_SORT_DESC', 'Укажите порядок сортировки для ожидаемых товаров, по возрастанию - asc или по убыванию - desc.');
define('EXPECTED_PRODUCTS_FIELD_DESC', 'По какому значению будут сортироваться ожидаемые товары.');
define('USE_DEFAULT_LANGUAGE_CURRENCY_DESC', 'Автоматическое переключение цен в магазине на валюту текущего языка.');
define('SEND_EXTRA_ORDER_EMAILS_TO_DESC', 'Если Вы хотите получать письма с заказами, т.е. такие же письма, что и получает клиент после оформления заказа, укажите e-mail адрес для получения копий писем в следующем формате: Имя 1 &lt;email@address1&gt;, Имя 2 &lt;email@address2&gt;');
define('SEARCH_ENGINE_FRIENDLY_URLS_DESC', 'Использовать короткие URL адреса в магазине');
define('DISPLAY_CART_DESC', 'Переходить в корзину после добавления товара в корзину или оставаться на той же странице.');
define('ALLOW_GUEST_TO_TELL_A_FRIEND_DESC', 'Позволить гостям использовать функцию магазина Рассказать другу, если нет, то данной функцией могут пользоваться только зарегистрированные пользователи магазина.');
define('ADVANCED_SEARCH_DEFAULT_OPERATOR_DESC', 'Укажите, какой оператор будет использоваться по умолчанию при осуществлении посетителем поиска в магазине.');
define('STORE_NAME_ADDRESS_DESC', 'Здесь Вы можете указать адрес и телефон магазина');
define('SHOW_COUNTS_DESC', 'Показывает количество товара в каждой категории. При большом количестве товара в магазина рекомендуется отключать счётчик - false, чтобы снизить нагрузку на MySQL сервер, тем самых скорость загрузки страницы Вашего магазина увеличится.');
define('ALLOW_CATEGORY_DESCRIPTIONS_DESC', 'Разрешить добавление описаний для категорий.');
define('TAX_DECIMAL_PLACES_DESC', 'Количество знаков после целого числа у налогов.');
define('SHOW_MAIN_FEATURED_PRODUCTS_DESC', 'true - Показывать<br>false - Не показывать');
define('DISPLAY_PRICE_WITH_TAX_DESC', 'Показывать цены в магазине с налогами (true) или показывать налог только на заключительном этапе оформления заказа (false)');

define('XPRICES_NUM_DESC', 'Здесь Вы можете указать, какое количество цен может иметь каждый товар<br><br>Например, Вы можете покупателям из группы Покупатели показывать одну цену товара, покупателям из группы Оптовики - показывать другую.');
define('NEW_SIGNUP_GIFT_VOUCHER_AMOUNT_DESC', 'Если Вы не хотите отправлять подарочный сертификат зарегистрированным в магазине покупателям, укажите 0. Чтобы отправлять зарегистрированным покупателям сертификат, например, номиналом в 10$ - укажите 10, если 25.5$ - укажите 25.5 и т.д.');
define('ALLOW_GUEST_TO_SEE_PRICES_DESC', 'Если стоит false, то цены в магазине могут видеть только зарегистрированные посетители, если true - все посетители могут видеть цены в магазине.');
define('NEW_SIGNUP_DISCOUNT_COUPON_DESC', 'Если Вы не хотите давать купон посетителям, прошедшим регистрацию, просто оставьте поле пустым, либо укажите код существующего купона, который Вы хотите давать всем зарегистрированным покупателям.');
define('GUEST_DISCOUNT_DESC', 'Наценка для простых посетителей магазина. Для зарегистрированных в магазине посетителей данная опция не действует. Указывайте наценку в процентах. Например укажите 10, это значит, что для простых посетителей все цены в магазине будут на 10% выше чем для зарегистрированных посетителей.');
define('CATEGORIES_SORT_ORDER_DESC', '<b>Возможные значения:<br>products_name<br>products_name-desc<br>model<br>model-desc</b>');
define('QUICKSEARCH_IN_DESCRIPTION_DESC', 'При поиске товара с помощью бокса быстрый поиск, Вы можете указать, как искать товары, только по названиям - FALSE или искать в названиях + описаниях - TRUE');
define('CONTACT_US_LIST_DESC', 'Вы можете указать разных получателей на странице Свяжитесь с нами. Формат записи: Имя 1 &lt;email@address1&gt;, Имя 2 &lt;email@address2&gt;. Если Вы хотите оставить всего одного получателя писем, просто оставьте поле пустым.');
define('ALLOW_GIFT_VOUCHERS_DESC', 'Вы можете включить - true или выключить - false возможность использования подарочных сертификатов и купонов при оформлении заказа.');
define('ALLOW_ATTRIBUTES_IN_PRODUCT_EDIT_PAGE_DESC', 'Вы можете включить - true или выключить - false возможность управления атрибутами товаров прямо на странице добавления/редактирования товаров.');
define('SHOW_SUBCATEGORIES_WHEN_CATEGORIES_HAS_PRODUCTS_DESC', 'Если в категории есть товар и в данной категории есть субкатегории, то по умолчанию (true), зайдя в такую категорию, Вы увидите список субкатегорий и список товаров категории. Можно отключить вывод субкатегорий, для этого поставьте false.');
define('SHOW_PDF_DATASHEET_DESC', 'Показывать (true) или нет (false) PDF описание товара на странице описания товара.');

// Минимальнаые значения

define('ENTRY_FIRST_NAME_MIN_LENGTH_DESC', 'Минимальное количество символов поля Имя');
define('ENTRY_LAST_NAME_MIN_LENGTH_DESC', 'Минимальное количество символов поля Фамилия');
define('ENTRY_DOB_MIN_LENGTH_DESC', 'Минимальное количество символов поля Дата рождения');
define('ENTRY_EMAIL_ADDRESS_MIN_LENGTH_DESC', 'Минимальное количество символов поля E-Mail адрес');
define('ENTRY_STREET_ADDRESS_MIN_LENGTH_DESC', 'Минимальное количество символов поля Адрес');
define('ENTRY_COMPANY_MIN_LENGTH_DESC', 'Минимальное количество символов поля Компания');
define('ENTRY_POSTCODE_MIN_LENGTH_DESC', 'Минимальное количество символов поля Почтовый индекс');
define('ENTRY_CITY_MIN_LENGTH_DESC', 'Минимальное количество символов поля Город');
define('ENTRY_STATE_MIN_LENGTH_DESC', 'Минимальное количество символов поля Регион');
define('ENTRY_TELEPHONE_MIN_LENGTH_DESC', 'Минимальное количество символов поля Телефон');
define('ENTRY_PASSWORD_MIN_LENGTH_DESC', 'Минимальное количество символов поля Пароль');
define('CC_OWNER_MIN_LENGTH_DESC', 'Минимальное количество символов поля Владелец кредитной карточки');
define('CC_NUMBER_MIN_LENGTH_DESC', 'Минимальное количество символов поля Номер кредитной карточки');
define('REVIEW_TEXT_MIN_LENGTH_DESC', 'Минимальное количество символов для отызов');
define('MIN_DISPLAY_BESTSELLERS_DESC', 'Минимальное количество товара, выводимого в блоке Лидеры продаж');
define('MIN_DISPLAY_ALSO_PURCHASED_DESC', 'Минимальное количество товара, выводимого в боксе Также заказали');
define('MIN_DISPLAY_XSELL_DESC', 'Минимальное количество товаров, выводимых в боксе Связанные товары');
define('MIN_ORDER_DESC', 'Если сумма заказа будет меньше указанной, такой заказ нельзя будет оформить. Указывайте просто число, без симолов валюты ($, руб. и т.д.). Поставьте 0, если Вы не хотите ограничивать минимальную сумму заказа.');

// Максимальные значения

define('MAX_PROD_ADMIN_SIDE_DESC', 'Количество товара на одной странице в администраторской');

define('MAX_ADDRESS_BOOK_ENTRIES_DESC', 'Максимальное количество записей, которые может сделать покупатель в своей адресной книге');
define('MAX_DISPLAY_SEARCH_RESULTS_DESC', 'Количество товара, выводимого на одной странице');
define('MAX_DISPLAY_PAGE_LINKS_DESC', 'Количество ссылок на другие страницы');
define('MAX_DISPLAY_SPECIAL_PRODUCTS_DESC', 'Максимальное количество товара, выводимого на странице Скидки');
define('MAX_DISPLAY_NEW_PRODUCTS_DESC', 'Максимальное количество товара, выводимых в боксе Новинки');
define('MAX_DISPLAY_UPCOMING_PRODUCTS_DESC', 'Максимальное количество товара, выводимого в блоке Ожидаемые товары');
define('MAX_DISPLAY_MANUFACTURERS_IN_A_LIST_DESC', 'Данная опция используется для настройки бокса производителей, если число производителей превышает указанное в данной опции, список производителей будет выводиться в виде drop-down списка, если число производителей меньше указанного в данной опции, производители будут выводиться в виде списка.');
define('MAX_MANUFACTURERS_LIST_DESC', 'Данная опция используется для настройки бокса производителей, если указана цифра \'1\', то список производителей выводится в виде стандартного drop-down списка. Если указана любая другая цифра, то выводится только X производителей в виде развёрнутого меню.');
define('MAX_DISPLAY_MANUFACTURER_NAME_LEN_DESC', 'Данная опция используется для настройки бокса производителей, Вы указываете количество символов, выводимого в боксе производителей, если название производителя будет состоять из большего количества символов, то будут выведены первые X символов названия');
define('MAX_DISPLAY_NEW_REVIEWS_DESC', 'Максимальное количество выводимых новых отзывов');
define('MAX_RANDOM_SELECT_REVIEWS_DESC', 'Количество отзывов, которое будет использоваться для вывода случайного, т.е. если указано X - число отзывов, то случайный отзыв будет выбран из этих X отзывов');
define('MAX_RANDOM_SELECT_NEW_DESC', 'Количество товара, среди которого будет выбран случайный товар и выведен в бокс Новинок, т.е. если указано число X, то новый товар, который будет показан в боксе Новинок будет выбран из этих X новых товаров');
define('MAX_RANDOM_SELECT_SPECIALS_DESC', 'Количество товара, среди которого будет выбран случайный товар и выведен в бокс Скидки, т.е. если указано число X, то товар, который будет показан в боксе Скидки будет выбран из этих X товаров');
define('MAX_DISPLAY_CATEGORIES_PER_ROW_DESC', 'Сколько категорий выводить в одной строке');
define('MAX_DISPLAY_PRODUCTS_NEW_DESC', 'Максимальное количество новинок, выводимых на одной странице в разделе Новинки');
define('MAX_DISPLAY_BESTSELLERS_DESC', 'Максимальное количество лидеров продаж, выводимых в боксе Лидеры продаж');
define('MAX_DISPLAY_ALSO_PURCHASED_DESC', 'Максимальное количество товаров в боксе Наши покупатели также заказали');
define('MAX_DISPLAY_PRODUCTS_IN_ORDER_HISTORY_BOX_DESC', 'Максимальное количество товаров, выводимых в боксе История заказов');
define('MAX_DISPLAY_ORDER_HISTORY_DESC', 'Максимальное количество заказов, выводимых на странице История заказов');
define('MAX_DISPLAY_FEATURED_PRODUCTS_DESC', 'Максимальное количество товара в боксе Рекомендуемые товары на главной странице');
define('MAX_DISPLAY_FEATURED_PRODUCTS_LISTING_DESC', 'Количество товара на одной странице Рекомендуемых товаров');

// Картинки

define('SMALL_IMAGE_WIDTH_DESC', 'Ширина картинки в пикселах. Оставьте поле пустым или поставьте 0, если не хотите ограничивать ширину картинки. Ограничение ширины картинки не значит физического уменьшения размеров картинки.');
define('SMALL_IMAGE_HEIGHT_DESC', 'Высота картинки в пикселах. Оставьте поле пустым или поставьте 0, если не хотите ограничивать высоту картинки. Ограничение высоты картинки не значит физического уменьшения размеров картинки.');
define('HEADING_IMAGE_WIDTH_DESC', 'Ширина картинки в пикселах. Оставьте поле пустым или поставьте 0, если не хотите ограничивать ширину картинки. Ограничение ширины картинки не значит физического уменьшения размеров картинки.');
define('HEADING_IMAGE_HEIGHT_DESC', 'Высота картинки в пикселах. Оставьте поле пустым или поставьте 0, если не хотите ограничивать высоту картинки. Ограничение высоты картинки не значит физического уменьшения размеров картинки.');
define('SUBCATEGORY_IMAGE_WIDTH_DESC', 'Ширина картинки в пикселах. Оставьте поле пустым или поставьте 0, если не хотите ограничивать ширину картинки. Ограничение ширины картинки не значит физического уменьшения размеров картинки.');
define('SUBCATEGORY_IMAGE_HEIGHT_DESC', 'Высота картинки в пикселах. Оставьте поле пустым или поставьте 0, если не хотите ограничивать высоту картинки. Ограничение высоты картинки не значит физического уменьшения размеров картинки.');
define('CONFIG_CALCULATE_IMAGE_SIZE_DESC', 'Данная опция просто смотрит переменные, указанные выше и сжимает картинку до указанных размеров, это не значит, что физический размер картинки уменьшится, происходит принудительный вывод картинки определённого размера. Рекомендуется ставить значение false');
define('IMAGE_REQUIRED_DESC', 'Необходимо для поиска ошибок, в случае, если картинка не выводится.');
define('ULTIMATE_ADDITIONAL_IMAGES_DESC', 'Вы можете включить/выключить модуль дополнительных картинок для товара.');
define('ULT_THUMB_IMAGE_WIDTH_DESC', 'Ширина дополнительной картинки в пикселах. Оставьте поле пустым или поставьте 0, если не хотите ограничивать ширину картинки. Ограничение ширины картинки не значит физического уменьшения размеров картинки.');
define('ULT_THUMB_IMAGE_HEIGHT_DESC', 'Высота дополнительной картинки в пикселах. Оставьте поле пустым или поставьте 0, если не хотите ограничивать высоту картинки. Ограничение высоты картинки не значит физического уменьшения размеров картинки.');
define('MEDIUM_IMAGE_WIDTH_DESC', 'Ширина большой картинки в пикселах. Оставьте поле пустым или поставьте 0, если не хотите ограничивать ширину большой картинки. Ограничение ширины большой картинки не значит физического уменьшения размеров картинки.');
define('MEDIUM_IMAGE_HEIGHT_DESC', 'Высота большой картинки в пикселах. Оставьте поле пустым или поставьте 0, если не хотите ограничивать высоту большой картинки. Ограничение высоты большой картинки не значит физического уменьшения размеров картинки.');
define('LARGE_IMAGE_WIDTH_DESC', 'Ширина картинки для pop-up окна в пикселах. Оставьте поле пустым или поставьте 0, если не хотите ограничивать ширину картинки для pop-up окна. Ограничение ширины картинки для pop-up окна не значит физического уменьшения размеров картинки.');
define('LARGE_IMAGE_HEIGHT_DESC', 'Высота картинки для pop-up окна в пикселах. Оставьте поле пустым или поставьте 0, если не хотите ограничивать высоту картинки для pop-up окна. Ограничение высоты картинки для pop-up окна не значит физического уменьшения размеров картинки.');

// Данные покупателя

define('ACCOUNT_GENDER_DESC', 'Показывать поле Пол при регистрации покупателя в магазине и в адресной книге');
define('ACCOUNT_DOB_DESC', 'Показывать поле Дата рождения при регистрации покупателя в магазине и в адресной книге');
define('ACCOUNT_COMPANY_DESC', 'Показывать поле Компания при регистрации покупателя в магазине и в адресной книге');
define('ACCOUNT_SUBURB_DESC', 'Показывать поле Район при регистрации покупателя в магазине и в адресной книге');
define('ACCOUNT_STATE_DESC', 'Показывать поле Регион при регистрации покупателя в магазине и в адресной книге');
define('ACCOUNT_STREET_ADDRESS_DESC', 'Показывать поле Адрес при регистрации покупателя в магазине и в адресной книге');
define('ACCOUNT_CITY_DESC', 'Показывать поле Город при регистрации покупателя в магазине и в адресной книге');
define('ACCOUNT_POSTCODE_DESC', 'Показывать поле Почтовый индекс при регистрации покупателя в магазине и в адресной книге');
define('ACCOUNT_COUNTRY_DESC', 'Показывать поле Страна при регистрации покупателя в магазине и в адресной книге');
define('ACCOUNT_TELE_DESC', 'Показывать поле Телефон при регистрации покупателя в магазине и в адресной книге');
define('ACCOUNT_FAX_DESC', 'Показывать поле Факс при регистрации покупателя в магазине и в адресной книге');
define('ACCOUNT_NEWS_DESC', 'Показывать поле Рассылка при регистрации покупателя в магазине и в адресной книге');

// Доставка/упаковка

define('SHIPPING_ORIGIN_COUNTRY_DESC', 'Страна, где находится магазин. Необходимо для некоторых модулей доставки.');
define('SHIPPING_ORIGIN_ZIP_DESC', 'Укажите почтовый индекс магазина. Необходимо для некоторых модулей доставки.');
define('SHIPPING_MAX_WEIGHT_DESC', 'Вы можете указать максимальный вес доставки, свыше которого заказы не доставляются. Необходимо для некоторых модулей доставки.');
define('SHIPPING_BOX_WEIGHT_DESC', 'Вы можете указать вес упаковки.');
define('SHIPPING_BOX_PADDING_DESC', 'Доставка заказов, вес которых больше указанного в переменной Максимальный вес доставки, увеличивается на указанный процент. Если Вы хотите увелить стоимость на 10%, пишите - 10');
define('MODULE_ORDER_TOTAL_SHIPPING_FREE_SHIPPING_DESC', 'Вы хотите разрешить использование модуля бесплатной доставки?');
define('MODULE_ORDER_TOTAL_SHIPPING_FREE_SHIPPING_OVER_DESC', 'Заказы, свыше суммы, указанной данной поле, будут доставляться бесплатно.');
define('MODULE_ORDER_TOTAL_SHIPPING_DESTINATION_DESC', 'national - заказы из страны нахождения магазина(переменная Страна магазина), international - заказы из любой страны, кроме страны нахождения магазина, если both - тогда все заказы. При условии, что сумма заказы выше суммы, указанной в переменной выше.');
define('SHOW_SHIPPING_ESTIMATOR_DESC', 'Показывать информацию о способах и стоимости доставки в корзине?<br>true - показывать.<br>false - не показывать.');
define('SHOW_XSELL_CART_DESC', 'Показывать сопутствующие в корзине?<br>true - показывать.<br>false - не показывать.');

// Вывод товара

define('PRODUCT_LISTING_DISPLAY_STYLE_DESC', 'Вы можете выбрать, в каком формате выводить товар, в виде таблицы - list, либо в столбец - columns.');
define('PRODUCT_LIST_IMAGE_DESC', 'Укажите порядок вывода, т.е. введите цифру. Если укажите 1, то картинка будет слева на первом месте, если 2, то картинка будет показана после(правее) поля, у которого указана цифра 1 и т.д.');
define('PRODUCT_LIST_COL_NUM_DESC', 'Данная опция действительна только если в качестве вывода товара выбран вывод товара в столбец - columns. Вы можете указать, какое количество товара будет выводиться в одной строке.');
define('PRODUCT_LIST_MANUFACTURER_DESC', 'Укажите порядок вывода данного поля в Вашем магазине, т.е. введите цифру. Если укажите 1, то данное поле будет слева на первом месте, если 2, то поле будет показана после(правее) поля, у которого указана цифра 1 и т.д.');
define('PRODUCT_LIST_MODEL_DESC', 'Укажите порядок вывода данного поля в Вашем магазине, т.е. введите цифру. Если укажите 1, то данное поле будет слева на первом месте, если 2, то поле будет показана после(правее) поля, у которого указана цифра 1 и т.д.');
define('PRODUCT_LIST_NAME_DESC', 'Укажите порядок вывода данного поля в Вашем магазине, т.е. введите цифру. Если укажите 1, то данное поле будет слева на первом месте, если 2, то поле будет показана после(правее) поля, у которого указана цифра 1 и т.д.');
define('PRODUCT_LIST_PRICE_DESC', 'Укажите порядок вывода данного поля в Вашем магазине, т.е. введите цифру. Если укажите 1, то данное поле будет слева на первом месте, если 2, то поле будет показана после(правее) поля, у которого указана цифра 1 и т.д.');
define('PRODUCT_LIST_QUANTITY_DESC', 'Укажите порядок вывода данного поля в Вашем магазине, т.е. введите цифру. Если укажите 1, то данное поле будет слева на первом месте, если 2, то поле будет показана после(правее) поля, у которого указана цифра 1 и т.д.');
define('PRODUCT_LIST_WEIGHT_DESC', 'Укажите порядок вывода данного поля в Вашем магазине, т.е. введите цифру. Если укажите 1, то данное поле будет слева на первом месте, если 2, то поле будет показана после(правее) поля, у которого указана цифра 1 и т.д.');
define('PRODUCT_LIST_BUY_NOW_DESC', 'Укажите порядок вывода данного поля в Вашем магазине, т.е. введите цифру. Если укажите 1, то данное поле будет слева на первом месте, если 2, то поле будет показана после(правее) поля, у которого указана цифра 1 и т.д.');
define('PRODUCT_LIST_FILTER_DESC', 'Показывать бокс(drop-down) меню, с помощью которого можно сортировать товар в какой-либо категории магазина по Производителю.');
define('PREV_NEXT_BAR_LOCATION_DESC', 'Установите расположение навигации Следующая/Предыдущая страница (1-верх, 2-низ, 3-верх+низ)');
define('PRODUCT_LIST_INFO_DESC', 'Если Вы укажите 0, тогда краткое описание показываться не будет, если 1-99 - краткое описание будет показываться, но только если краткое описание было добавлено при добавлении товара.');
define('PRODUCT_SORT_ORDER_DESC', 'Укажите порядок вывода данного поля в Вашем магазине, т.е. введите цифру. Если укажите 1, то данное поле будет слева на первом месте, если 2, то поле будет показана после(правее) поля, у которого указана цифра 1 и т.д. 0 - значит не показывать данное поле');

// Склад

define('STOCK_CHECK_DESC', 'Проверять, есть ли необходимое количество товара на складе при оформлении заказа');
define('STOCK_LIMITED_DESC', 'Вычитать со склада то количество товара, которое будет заказываться в интернет-магазине');
define('STOCK_ALLOW_CHECKOUT_DESC', 'Разрешить покупателям оформлять заказ, даже если на складе нет достаточного количества единиц заказываемого товара');
define('STOCK_MARK_PRODUCT_OUT_OF_STOCK_DESC', 'Показывать покупателю маркер напротив товара при оформлении заказа, если на складе нет необходимого количества единиц заказываемого товара');
define('STOCK_REORDER_LEVEL_DESC', 'Если количество товара на складе меньше, чем указанное число в данной переменной, то в корзине выводится предупреждение о недостаточном количестве товара на складе для выполнения заказа.');

// Логи

define('STORE_PAGE_PARSE_TIME_DESC', 'Хранить время, затраченное на генерацию(парсинг) страниц магазина.');
define('STORE_PAGE_PARSE_TIME_LOG_DESC', 'Полный путь до директории и файла, в который будет записываться лог парсинга страниц.');
define('STORE_PARSE_DATE_TIME_FORMAT_DESC', 'Формат даты');
define('DISPLAY_PAGE_PARSE_TIME_DESC', 'Показывать время парсинга страницы в интернет-магазине (опция Сохранять время парсинга страниц должна быть включена)');
define('STORE_DB_TRANSACTIONS_DESC', 'Сохранять все запросы к базе данных в файле, указанном в переменной Директория хранение логов (только для PHP4 и выше)');

// Кэш

define('USE_CACHE_DESC', 'Использовать кэширование информации.');
define('DIR_FS_CACHE_DESC', 'Директория, куда будут записываться и сохраняться кэш-файлы.');

// Настройка E-Mail

define('EMAIL_TRANSPORT_DESC', 'Укажите, какой способ отправки писем из магазина будет использоваться. Для серверов, работающих под управлением Windows или MacOS необходимо установить SMTP для отправки писем.');
define('EMAIL_LINEFEED_DESC', 'Используемая последовательность символов для разделения заголовков в письме.');
define('EMAIL_USE_HTML_DESC', 'Отправлять письма из магазина в HTML формате.');
define('ENTRY_EMAIL_ADDRESS_CHECK_DESC', 'Проверять, верные ли e-mail адреса указываются при регистрации в интернет-магазине. Для проверки используется DNS.');
define('SEND_EMAILS_DESC', 'Отправлять письма из магазина.');

// Скачивание

define('DOWNLOAD_ENABLED_DESC', 'Разрешить функцию скачивания товаров.');
define('DOWNLOAD_BY_REDIRECT_DESC', 'Использовать перенаправление в браузере для скачивания товара. Для не Unix систем(Windows, Mac OS и т.д.) должно стоять false.');
define('DOWNLOAD_MAX_DAYS_DESC', 'Установите количество дней, в течение которых покупатель может скачать свой товар. Если укажите 0, тогда срок существования ссылки для скачивания ограничен не будет.');
define('DOWNLOAD_MAX_COUNT_DESC', 'Установите максимальное количество скачиваний для одного товара. Если укажите 0, тогда никаких ограничений по количеству скачиваний не будет.');
define('DOWNLOADS_ORDERS_STATUS_UPDATED_VALUE_DESC', 'Какой ID номер статуса заказа сбрасывает переменные Срок существования ссылки для скачивания (дней) и Максимальное количество скачиваний - По умолчанию Доставляется (id код 4).');
define('DOWNLOADS_CONTROLLER_ON_HOLD_MSG_DESC', 'Вы можете указать сообщение, которое будет показано клиенту, в случае, если он захочет скачать ещё неоплаченный товар.');
define('DOWNLOADS_CONTROLLER_ORDERS_STATUS_DESC', 'Скачивание файла (файлов) будет разрешено только в случае, если заказ будет иметь указанный статус (а именно id код статуса заказа). По умолчанию скачивание разрешено для заказов со статусом ждём оплаты (id код 2).');

// GZip Компрессия

define('GZIP_COMPRESSION_DESC', 'Разрешить HTTP GZip компрессию.');
define('GZIP_LEVEL_DESC', 'Вы можете указать уровень компрессии от 0 до 9 (0 = минимум, 9 = максимум).');

// Сессии

define('SESSION_WRITE_DIRECTORY_DESC', 'Если сессии хранятся в файлах, то здесь необходимо указать полный путь до папки, в которой будут храниться файлы сессий.');
define('SESSION_FORCE_COOKIE_USE_DESC', 'Принудительно использовать сессии, только когда в браузере активированы cookies.');
define('SESSION_CHECK_SSL_SESSION_ID_DESC', 'Проверять  SSL_SESSION_ID при каждом обращении к странице, защищённой протоколом HTTPS.');
define('SESSION_CHECK_USER_AGENT_DESC', 'Проверять переменную бразура user agent при каждом обращении к страницам интернет-магазина.');
define('SESSION_CHECK_IP_ADDRESS_DESC', 'Проверять IP адреса клиентов при каждом обращении к страницам интернет-магазина.');
define('SESSION_BLOCK_SPIDERS_DESC', 'Не показывать сессию в адресе при обращении к станицам магазина известных поисковых пауков. Список известных пауков находится в файле includes/spiders.txt.');
define('SESSION_RECREATE_DESC', 'Воссоздавать сессию для генерации нового ID кода сессии при входе зарегистрированного покупателя в магазин, либо при регистрации нового покупателя (Только для PHP 4.1 и выше).');

// HTML Редактор

define('HTML_AREA_WYSIWYG_DISABLE_DESC', 'Enable - Включить HTML редактор для поля Описание товара при добавлении/редактировании товара<br>Disable - Выключить HTML редактор.');
define('HTML_AREA_WYSIWYG_DISABLE_JPSY_DESC', 'Enable - Включить<br>Disable - Выключить<br>Данный модуль работает с браузером Internet Explorer 5.5 и выше. Если Вам не нравится данный модуль, можете его выключить, поставив Disable и при добавлении картинок к товару будет более простой вариант с кнопко');
define('HTML_AREA_WYSIWYG_BASIC_PD_DESC', 'Basic - Простой HTML редактор с минимальным количеством возможностей.<br> Advanced - Расширенный HTML редактор, максимальное количество возможностей.<br>Medium - Нечто среднее между Basic и Advanced.');
define('HTML_AREA_WYSIWYG_WIDTH_DESC', 'Ширина HTML редактора в пикселах (по умолчанию: 505)');
define('HTML_AREA_WYSIWYG_HEIGHT_DESC', 'Высота HTML редактора в пикселах (по умолчанию: 240)');
define('HTML_AREA_WYSIWYG_DISABLE_EMAIL_DESC', 'Enable - Включить HTML редактор <br>Disable - Выключить HTML редактор.');
define('HTML_AREA_WYSIWYG_BASIC_EMAIL_DESC', 'Basic - Простой HTML редактор с минимальным количеством возможностей.<br> Advanced - Расширенный HTML редактор, максимальное количество возможностей.');
define('EMAIL_AREA_WYSIWYG_WIDTH_DESC', 'Ширина HTML редактора в пикселах (по умолчанию: 505)');
define('EMAIL_AREA_WYSIWYG_HEIGHT_DESC', 'Высота HTML редактора в пикселах (по умолчанию: 140)');
define('HTML_AREA_WYSIWYG_DISABLE_NEWSLETTER_DESC', 'Enable - Включить HTML редактор <br>Disable - Выключить HTML редактор.');
define('HTML_AREA_WYSIWYG_BASIC_NEWSLETTER_DESC', 'Basic - Простой HTML редактор с минимальным количеством возможностей.<br> Advanced - Расширенный HTML редактор, максимальное количество возможностей.<br>Medium - Нечто среднее между Basic и Advanced.');
define('NEWSLETTER_EMAIL_WYSIWYG_WIDTH_DESC', 'Ширина HTML редактора в пикселах (по умолчанию: 505)');
define('NEWSLETTER_EMAIL_WYSIWYG_HEIGHT_DESC', 'Высота HTML редактора в пикселах (по умолчанию: 140)');
define('HTML_AREA_WYSIWYG_DISABLE_DEFINE_DESC', 'Enable - Включить HTML редактор <br>Disable - Выключить HTML редактор.');
define('HTML_AREA_WYSIWYG_BASIC_DEFINE_DESC', 'Basic - Простой HTML редактор с минимальным количеством возможностей.<br> Advanced - Расширенный HTML редактор, максимальное количество возможностей.<br>Medium - Нечто среднее между Basic и Advanced.');
define('HTML_AREA_WYSIWYG_DISABLE_ARTICLES_DESC', 'Enable - Включить HTML редактор <br>Disable - Выключить HTML редактор.');
define('HTML_AREA_WYSIWYG_BASIC_ARTICLES_DESC', 'Basic - Простой HTML редактор с минимальным количеством возможностей.<br> Advanced - Расширенный HTML редактор, максимальное количество возможностей.<br>Medium - Нечто среднее между Basic и Advanced.');
define('HTML_AREA_WYSIWYG_DISABLE_FAQDESK_DESC', 'Enable - Включить HTML редактор <br>Disable - Выключить HTML редактор.');
define('HTML_AREA_WYSIWYG_BASIC_FAQDESK_DESC', 'Basic - Простой HTML редактор с минимальным количеством возможностей.<br> Advanced - Расширенный HTML редактор, максимальное количество возможностей.<br>Medium - Нечто среднее между Basic и Advanced.');
define('HTML_AREA_WYSIWYG_DISABLE_NEWSDESK_DESC', 'Enable - Включить HTML редактор <br>Disable - Выключить HTML редактор.');
define('HTML_AREA_WYSIWYG_BASIC_NEWSDESK_DESC', 'Basic - Простой HTML редактор с минимальным количеством возможностей.<br> Advanced - Расширенный HTML редактор, максимальное количество возможностей.<br>Medium - Нечто среднее между Basic и Advanced.');
define('HTML_AREA_WYSIWYG_DISABLE_INFOPAGES_DESC', 'Enable - Включить HTML редактор <br>Disable - Выключить HTML редактор.');
define('HTML_AREA_WYSIWYG_BASIC_INFOPAGES_DESC', 'Basic - Простой HTML редактор с минимальным количеством возможностей.<br> Advanced - Расширенный HTML редактор, максимальное количество возможностей.<br>Medium - Нечто среднее между Basic и Advanced.');
define('DEFINE_MAINPAGE_WYSIWYG_WIDTH_DESC', 'Ширина HTML редактора в пикселах (по умолчанию: 505)');
define('DEFINE_MAINPAGE_WYSIWYG_HEIGHT_DESC', 'Высота HTML редактора в пикселах (по умолчанию: 140)');
define('HTML_AREA_WYSIWYG_FONT_TYPE_DESC', 'Шрифт интерфейса HTML редактора, никак не связано с теми данными, которые Вы будете вводить с помощью HTML редактора.');
define('HTML_AREA_WYSIWYG_FONT_SIZE_DESC', 'Размер шрифта интерфейса HTML редактора, никак не связано с теми данными, которые Вы будете вводить с помощью HTML редактора.');
define('HTML_AREA_WYSIWYG_FONT_COLOUR_DESC', 'Цвет шрифта интерфейса HTML редактора, никак не связано с теми данными, которые Вы будете вводить с помощью HTML редактора.<br>Вы можете указать либо код цвета, например #FFFFFF, либо название цвета, например black.');
define('HTML_AREA_WYSIWYG_BG_COLOUR_DESC', 'Цвет фона интерфейса HTML редактора, никак не связано с теми данными, которые Вы будете вводить с помощью HTML редактора.<br>Вы можете указать либо код цвета, например #FFFFFF, либо название цвета, например black.');
define('HTML_AREA_WYSIWYG_DEBUG_DESC', 'Следить за генерируемым HTML-кодом, т.е. Вы можете видеть, какой HTML-код создаётся при использовании HTML редактора.<p>0 - Отключить.<br>1 - Включить<br>По умолчанию стоит 0');

// Партнёрская программа

define('AFFILIATE_EMAIL_ADDRESS_DESC', 'E-Mail Адрес Партнёрской программы');
define('AFFILIATE_PERCENT_DESC', 'Процент от суммы оплаченного заказа, начисляемый партнёрам');
define('AFFILIATE_THRESHOLD_DESC', 'Минимальная сумма партнёрской комиссии к оплате');
define('AFFILIATE_COOKIE_LIFETIME_DESC', 'Время (в секундах) хранения cookies. Если посетитель с одного IP адреса сделал клик или покупку, и комиссия с его покупки была зачтена партнёру, то в следующий раз клики и продажи с этого IP будут засчитыватсья только через 7200 секунд (по умолчанию).');
define('AFFILIATE_BILLING_TIME_DESC', 'По умолчанию стоит 30, это значит, что счета для оплаты комиссий партнёрам выписываются раз в месяц');
define('AFFILIATE_PAYMENT_ORDER_MIN_STATUS_DESC', 'Необходимо для того, чтобы комиссия партнёрам начислялась только за оплаченные заказы, статус ID - 3 или выше. По умолчанию стоит 3 (Выполняется), т.е. заказ уже оплачен и комиссия партнёрам начисляется только за оплаченные заказы.');
define('AFFILIATE_USE_CHECK_DESC', 'Оплата партнёрских комиссий через WebMoney. При регистрации партнёр указывает свои данные в WebMoney.<br>true - Включено<br>false - Выключено');
define('AFFILIATE_USE_PAYPAL_DESC', 'Оплата через систему PayPal.<br>true - Включено<br>false - Выключено');
define('AFFILIATE_USE_BANK_DESC', 'Оплата партнёрских комиссий через банк.<br>true - Включено<br>false - Выключено');
define('AFFILATE_INDIVIDUAL_PERCENTAGE_DESC', 'Позволяет указывать индивидуальные процентны комиссии для партнёров. Например, по умолчанию стоит 10% с продажи для всех зарегистрированных партнёров, а Вы можете наиболее успешным партнёрам давать комиссию 15% с продажи.');
define('AFFILATE_USE_TIER_DESC', 'Партнёры, зарегистрировавшиеся через себя новых партнёров, могут получать комиссию за заказы, оформленные через партнёров, которых он привёл в магазин.');
define('AFFILIATE_TIER_LEVELS_DESC', 'Количество уровней, которое учитываются при учёте комиссии.');
define('AFFILIATE_TIER_PERCENTAGE_DESC', 'Проценты комиссии для каждого из уровней.<br>Пример: 8.00;5.00;1.00');

// Модуль Dynamic MoPics

define('IN_IMAGE_BIGIMAGES_DESC', 'Каталог, где будут храниться большие картинки.');
define('IN_IMAGE_THUMBS_DESC', 'Каталог, куда будут записываться маленькие картинки, автоматически генерируемые из большх картинок.');
define('MAIN_THUMB_IN_SUBDIR_DESC', 'По умолчанию true.');
define('THUMBS_PER_ROW_DESC', 'Сколько картинок должно показываться в одной строке.');
define('MORE_PICS_EXT_DESC', 'Данный префикс будет добавлен к оригинальному названию файла картинки. Можно оставить данное поле пустым, если не хотите добавлять каких-либо префиксов к оригинальному названию файла.');
define('BIG_PIC_EXT_DESC', 'Данный префикс будет добавлен к оригинальному названию файла большой картинки. Можно оставить данное поле пустым, если не хотите добавлять каких-либо префиксов к оригинальному названию файла.');
define('THUMB_IMAGE_TYPE_DESC', 'Тип генерируемых картинок.');
define('BIG_IMAGE_TYPE_DESC', 'Тип больших картинок');

// Тех. обслуживание

define('DOWN_FOR_MAINTENANCE_DESC', 'Техническое обслуживание. Если включено, то в магазине нельзя будет делать заказы и будет выведено предупреждение о проведении технического обслуживания магазина.<br>true - Включено<br>false - Выключено');
define('DOWN_FOR_MAINTENANCE_FILENAME_DESC', 'Файл, который будет показан в магазине, если включено Техническое обслуживание магазина. По умолчанию - down_for_maintenance.php');
define('DOWN_FOR_MAINTENANCE_HEADER_OFF_DESC', 'При включённом техническом обслуживании Вы можете запретить показывать шапку магазина<br>true - Не показывать<Br>false - Показывать');
define('DOWN_FOR_MAINTENANCE_COLUMN_LEFT_OFF_DESC', 'При включённом техническом обслуживании Вы можете запретить показывать левую колонку магазина<br>true - Не показывать<Br>false - Показывать');
define('DOWN_FOR_MAINTENANCE_COLUMN_RIGHT_OFF_DESC', 'При включённом техническом обслуживании Вы можете запретить показывать правую колонку магазина<br>true - Не показывать<Br>false - Показывать');
define('DOWN_FOR_MAINTENANCE_FOOTER_OFF_DESC', 'При включённом техническом обслуживании Вы можете запретить показывать нижнюю часть магазина<br>true - Не показывать<Br>false - Показывать');
define('DOWN_FOR_MAINTENANCE_PRICES_OFF_DESC', 'При включённом техническом обслуживании Вы можете запретить показывать цены на товары в магазине<br>true - Не показывать<Br>false - Показывать');
define('EXCLUDE_ADMIN_IP_FOR_MAINTENANCE_DESC', 'Для указанного IP адреса магазин будет доступен даже при включённом режиме Техническое обслуживание. Обычно здесь указывает IP адрес администратора магазина.');
define('WARN_BEFORE_DOWN_FOR_MAINTENANCE_DESC', 'Предупреждать посетителей перед уходом на техническое обслуживание. Если техническое обслуживание уже включено, то данная опция автоматически устанавливается в false.');
define('PERIOD_BEFORE_DOWN_FOR_MAINTENANCE_DESC', 'Укажите текст уведомления.');
define('DISPLAY_MAINTENANCE_TIME_DESC', 'Показывать дату активации режима Техническое обслуживание.');
define('DISPLAY_MAINTENANCE_PERIOD_DESC', 'Показывать в течение какого времени магазин будет находиться в режиме Техническое обслуживание.');
define('TEXT_MAINTENANCE_PERIOD_TIME_DESC', 'Укажите время работы магазина в режиме Техническое обслуживание');

// Быстрое оформление

define('GUEST_ON_DESC', 'Разрешить покупателям быстро оформлять заказ.');

// Ссылки

define('ENABLE_LINKS_COUNT_DESC', 'Показывать количество переходов по ссылке.');
define('ENABLE_SPIDER_FRIENDLY_LINKS_DESC', 'Использовать короткие URL адреса.');
define('LINKS_IMAGE_WIDTH_DESC', 'Ширина картинки ссылки.');
define('LINKS_IMAGE_HEIGHT_DESC', 'Высота картинки ссылки.');
define('LINK_LIST_IMAGE_DESC', 'Укажите порядок вывода данного поля, т.е. введите цифру. Если укажите 1, то данное поле будет слева на первом месте, если 2, то поле будет показана после(правее) поля, у которого указана цифра 1 и т.д. Если укажите 0, то данное поле не будет показываться.');
define('LINK_LIST_URL_DESC', 'Укажите порядок вывода данного поля, т.е. введите цифру. Если укажите 1, то данное поле будет слева на первом месте, если 2, то поле будет показана после(правее) поля, у которого указана цифра 1 и т.д. Если укажите 0, то данное поле не будет показываться.');
define('LINK_LIST_TITLE_DESC', 'Укажите порядок вывода данного поля, т.е. введите цифру. Если укажите 1, то данное поле будет слева на первом месте, если 2, то поле будет показана после(правее) поля, у которого указана цифра 1 и т.д. Если укажите 0, то данное поле не будет показываться.');
define('LINK_LIST_DESCRIPTION_DESC', 'Укажите порядок вывода данного поля, т.е. введите цифру. Если укажите 1, то данное поле будет слева на первом месте, если 2, то поле будет показана после(правее) поля, у которого указана цифра 1 и т.д. Если укажите 0, то данное поле не будет показываться.');
define('LINK_LIST_COUNT_DESC', 'Укажите порядок вывода данного поля, т.е. введите цифру. Если укажите 1, то данное поле будет слева на первом месте, если 2, то поле будет показана после(правее) поля, у которого указана цифра 1 и т.д. Если укажите 0, то данное поле не будет показываться.');
define('ENTRY_LINKS_TITLE_MIN_LENGTH_DESC', 'Минимальное количество символов.');
define('ENTRY_LINKS_URL_MIN_LENGTH_DESC', 'Минимальное количество символов.');
define('ENTRY_LINKS_DESCRIPTION_MIN_LENGTH_DESC', 'Минимальное количество символов.');
define('ENTRY_LINKS_CONTACT_NAME_MIN_LENGTH_DESC', 'Минимальное количество символов.');
define('LINKS_CHECK_PHRASE_DESC', 'Текст (обычно адрес магазина), который будет искаться при проверке ссылки. Необходимо для того, чтобы убедиться, что на сайте, добавленном в каталог ссылок, установлена ссылка на Ваш магазин.');

// Обновление прайса

define('DISPLAY_MODEL_DESC', 'Показывать/Не показывать код товара');
define('MODIFY_MODEL_DESC', 'Показывать/Не показывать код товара');
define('MODIFY_NAME_DESC', 'Показывать/Не показывать название товара');
define('DISPLAY_STATUT_DESC', 'Показывать/Не показывать статус товара');
define('DISPLAY_WEIGHT_DESC', 'Показывать/Не показывать вес товара');
define('DISPLAY_QUANTITY_DESC', 'Показывать/Не показывать количество товара');
define('DISPLAY_SORT_ORDER_DESC', 'Показывать/Не показывать порядок сортировки');
define('DISPLAY_ORDER_MIN_DESC', 'Показывать/Не показывать минимум для заказа');
define('DISPLAY_ORDER_UNITS_DESC', 'Показывать/Не показывать шаг');
define('DISPLAY_IMAGE_DESC', 'Показывать/Не показывать картинку товара');
define('DISPLAY_XML_DESC', 'Показывать/Не показывать колонку XML');
define('MODIFY_MANUFACTURER_DESC', 'Показывать/Не показывать производителя товара');
define('MODIFY_TAX_DESC', 'Показывать/Не показывать налог');
define('DISPLAY_TVA_OVER_DESC', 'Показывать/Не показывать цены с налогами');
define('DISPLAY_TVA_UP_DESC', 'Показывать/Не показывать цены с налогами при изменении цены');
define('DISPLAY_PREVIEW_DESC', 'Показывать/Не показывать ссылку на описание товара');
define('DISPLAY_EDIT_DESC', 'Показывать/Не показывать ссылку на редактирование товара');
define('DISPLAY_MANUFACTURER_DESC', 'Показывать/Не показывать производителя');
define('DISPLAY_TAX_DESC', 'Показывать/Не показывать налог');
define('ACTIVATE_COMMERCIAL_MARGIN_DESC', 'Показывать/Не показывать возможность массового  изменения цен');

// Отложенные товары

define('MAX_DISPLAY_WISHLIST_PRODUCTS_DESC' , 'Сколько отложенных товаров показывать на одной странице?');
define('MAX_DISPLAY_WISHLIST_BOX_DESC' , 'Сколько отложенных товаров показывать в боксе до того, как список изменится на счётчик?');
define('DISPLAY_WISHLIST_EMAILS_DESC' , 'Сколько возможных e-mail адресов показывать на странице отложенных товаров?');
define('WISHLIST_REDIRECT_DESC' , 'Возвращаться на страницу карточки товара после добавления товара в отложенные?');

// Кэш страниц

define('ENABLE_PAGE_CACHE_DESC' , 'Разрешить кэширование страниц? Данная функция помогает снизить нагрузку на сервер и ускорить загрузку страниц.');
define('PAGE_CACHE_LIFETIME_DESC' , 'Как долго кэшировать страницы (в минутах)?');
define('PAGE_CACHE_DEBUG_MODE_DESC' , 'Включить режим отладки (внизу страницы)? Не включайте данную опцию на работающих магазинах! Вы можете включить режим отладки просто добавив к URL адресу параметр ?debug=1');
define('PAGE_CACHE_DISABLE_PARAMETERS_DESC' , 'В некоторых случаях (например, при включённых коротких адресах) или при большом количестве партнёров может привести к чрезмерному использованию дискового пространства.');
define('PAGE_CACHE_DELETE_FILES_DESC' , 'Если установлено в true, то при любом следующем просмотре любой страницы в каталоге, все кэш файлы будут удалены, после этого верните false.');
define('PAGE_CACHE_UPDATE_CONFIG_FILES_DESC' , 'Если у Вас установлен модуль configuration cache, укажите полный (абсолютный) путь до файла обновления.');

// Яндекс маркет

define('YML_NAME_DESC' , 'Название магазина для Яндекс-Маркет. Если поле пустое, то используется STORE_NAME.');
define('YML_COMPANY_DESC' , 'Название компании для Яндекс-Маркет. Если поле пустое, то используется STORE_OWNER.');
define('YML_DELIVERYINCLUDED_DESC' , 'Доставка включена в стоимость товара?');
define('YML_AVAILABLE_DESC' , 'Товар в наличии или под заказ?');
define('YML_AUTH_USER_DESC' , 'Логин для доступа к YML');
define('YML_AUTH_PW_DESC' , 'Пароль для доступа к YML');
define('YML_REFERER_DESC' , 'Добавить в адрес товара параметр с ссылкой на User agent или ip?');
define('YML_STRIP_TAGS_DESC' , 'Убирать html-теги в строках?');
define('YML_UTF8_DESC' , 'Перекодировать в windows-1251?');
define('YML_SALES_NOTES_DESC' , 'Текст для тэга sales_notes');

// Список категорий на главной странице

define('BRWCAT_ENABLE_TITLE' , 'Разрешить модуль просмотр категорий');
define('BRWCAT_ICON_MODE_TITLE' , 'Картинки категорий');
define('BRWCAT_SUBCAT_MODE_TITLE' , 'Ссылки на подкатегории');
define('BRWCAT_ICONS_PER_ROW_TITLE' , 'Максимальное количество подкатегорий в одной строке');
define('BRWCAT_SUBCAT_BULLET_TITLE' , 'Символ перед названием категорий');
define('BRWCAT_SUBCAT_COUNTS_TITLE' , 'Счетчик количества товаров в категориях');
define('BRWCAT_NAME_CASE_TITLE' , 'Формат вывода названий категорий');

define('BRWCAT_ENABLE_DESC' , 'Активировать модуль просмотр категорий.');
define('BRWCAT_ICON_MODE_DESC' , 'Выберите, показывать картинки или нет и если показывать, то как:<br><br>Disabled - Не показывать.<br>Text - Название без картинки.<br>Image only - Картинка.<br>Image with caption - Картинка + текст.');
define('BRWCAT_SUBCAT_MODE_DESC' , 'Как показывать ссылку на подкатегории:<br><br>Off - Не показывать вообще.<br>Bottom - Показывать снизу.<br>Right top - Справа сверху.<br>Right middle - Справа посередине.<br>Right bottom - Справа снизу.');
define('BRWCAT_ICONS_PER_ROW_DESC' , 'Сколько подкатегорий показывать в одной строке:');
define('BRWCAT_SUBCAT_BULLET_DESC' , 'Символ, показываемый перед названием категории.');
define('BRWCAT_SUBCAT_COUNTS_DESC' , 'Счётчик количества товара в категориях.');
define('BRWCAT_NAME_CASE_DESC' , 'Выберите, в каком формате выводить названия категорий.');

// Статьи - Настройки 

define('DISPLAY_NEW_ARTICLES_TITLE', 'Показывать ссылку новые статьи');
define('NEW_ARTICLES_DAYS_DISPLAY_TITLE', 'Количество дней, в течение которых статья считается новой');
define('MAX_NEW_ARTICLES_PER_PAGE_TITLE', 'Количество статей на одной странице новых статей');
define('DISPLAY_ALL_ARTICLES_TITLE', 'Показывать ссылку все статьи');
define('MAX_ARTICLES_PER_PAGE_TITLE', 'Количество статей на одной странице');
define('MAX_DISPLAY_UPCOMING_ARTICLES_TITLE', 'Максимальное количество готовящихся к публикации статей');
define('ENABLE_ARTICLE_REVIEWS_TITLE', 'Разрешить отзывы к статьям');
define('ENABLE_TELL_A_FRIEND_ARTICLE_TITLE', 'Разрешить функцию рассказать знакомому');
define('MIN_DISPLAY_ARTICLES_XSELL_TITLE', 'Минимальное количество товара, выводимого в боксе связанные товары');
define('MAX_DISPLAY_ARTICLES_XSELL_TITLE', 'Максимальное количество товара, выводимого в боксе связанные товары');
define('SHOW_ARTICLE_COUNTS_TITLE', 'Показывать счётчик статей');
define('MAX_DISPLAY_AUTHOR_NAME_LEN_TITLE', 'Максимальная длина поля автор');
define('MAX_DISPLAY_AUTHORS_IN_A_LIST_TITLE', 'Формат вывода списка авторов');
define('MAX_AUTHORS_LIST_TITLE', 'Авторы в виде развёрнутого меню');
define('DISPLAY_AUTHOR_ARTICLE_LISTING_TITLE', 'Показывать автора в списке статей');
define('DISPLAY_TOPIC_ARTICLE_LISTING_TITLE', 'Показывать раздел в списке статей');
define('DISPLAY_ABSTRACT_ARTICLE_LISTING_TITLE', 'Показывать Meta Description в списке статей');
define('DISPLAY_DATE_ADDED_ARTICLE_LISTING_TITLE', 'Показывать дату добавления в списке статей');
define('MAX_ARTICLE_ABSTRACT_LENGTH_TITLE', 'Максимальная длина поля Meta Description');
define('ARTICLE_LIST_FILTER_TITLE', 'Показывать фильтр Раздел/Авторы');
define('ARTICLE_PREV_NEXT_BAR_LOCATION_TITLE', 'Расположение навигации Следующая/Предыдущая страница');
define('ARTICLE_WYSIWYG_ENABLE_TITLE', 'Использовать HTML редактор для написания статей?');
define('ARTICLE_MANAGER_WYSIWYG_BASIC_TITLE', 'Возможности HTML редактора');
define('ARTICLE_MANAGER_WYSIWYG_WIDTH_TITLE', 'Ширина HTML редактора');
define('ARTICLE_MANAGER_WYSIWYG_HEIGHT_TITLE', 'Высота HTML редактора');
define('ARTICLE_MANAGER_WYSIWYG_FONT_TYPE_TITLE', 'Шрифт, используемый в интерфейсе HTML редактора');
define('ARTICLE_MANAGER_WYSIWYG_FONT_SIZE_TITLE', 'Размер шрифта, используемого в интерфейсе HTML редактора');
define('ARTICLE_MANAGER_WYSIWYG_FONT_COLOUR_TITLE', 'Цвет шрифта, используемого в интерфейсе HTML редактора');
define('ARTICLE_MANAGER_WYSIWYG_BG_COLOUR_TITLE', 'Цвет фона в интерфейсе HTML редактора');
define('ARTICLE_MANAGER_WYSIWYG_DEBUG_TITLE', 'Разрешить режим отладки?');

define('DISPLAY_NEW_ARTICLES_DESC', 'Показывать ссылку новые статьи в боксе статьи?');
define('NEW_ARTICLES_DAYS_DISPLAY_DESC', 'Какое количество дней после добавления, статья считается новой и отображатеся на странице новые статьи.');
define('MAX_NEW_ARTICLES_PER_PAGE_DESC', 'Максимальное количество статей, выводимых на одной странице новых статей.');
define('DISPLAY_ALL_ARTICLES_DESC', 'Показывать ссылку все статьи в боксе статьи?');
define('MAX_ARTICLES_PER_PAGE_DESC', 'Максимальное количество статей, выводимых на одной странице.');
define('MAX_DISPLAY_UPCOMING_ARTICLES_DESC', 'Максимальное количество статей, выводимых в блоке готовятся к публикации');
define('ENABLE_ARTICLE_REVIEWS_DESC', 'Разрешить посетителям оставлять свои отзывы о статьях.');
define('ENABLE_TELL_A_FRIEND_ARTICLE_DESC', 'Разрешить посетителям использовть функцию Рассказать знакомому.');
define('MIN_DISPLAY_ARTICLES_XSELL_DESC', 'Минимальное количество товара, выводимого в боксе связанные товары.');
define('MAX_DISPLAY_ARTICLES_XSELL_DESC', 'Максимальное количество товара, выводимого в боксе связанные товары.');
define('SHOW_ARTICLE_COUNTS_DESC', 'Показывать количество статей в каждой разделе.');
define('MAX_DISPLAY_AUTHOR_NAME_LEN_DESC', 'Максимальная количество символов, выводимых в боксе авторы.');
define('MAX_DISPLAY_AUTHORS_IN_A_LIST_DESC', 'Если число авторов меньше указанной цифры, тогда в боксе авторы выводится простой список, если число авторов больше указанной цифры, тогра выводится drop-down список авторов.');
define('MAX_AUTHORS_LIST_DESC', 'Данная опция используется для настройки бокса авторы, если указана цифра 1, то список авторов выводится в виде стандартного drop-down списка. Если указана любая другая цифра, то выводится только X производителей в виде развёрнутого меню.');
define('DISPLAY_AUTHOR_ARTICLE_LISTING_DESC', 'Показывать автора в списке статей?');
define('DISPLAY_TOPIC_ARTICLE_LISTING_DESC', 'Показывать раздел в списке статей?');
define('DISPLAY_ABSTRACT_ARTICLE_LISTING_DESC', 'Показывать Meta Description в списке статей?');
define('DISPLAY_DATE_ADDED_ARTICLE_LISTING_DESC', 'Показывать дату добавления в списке статей?');
define('MAX_ARTICLE_ABSTRACT_LENGTH_DESC', 'Максимальное количество символов поля Meta Description.');
define('ARTICLE_LIST_FILTER_DESC', 'Показывать фильтр Раздел/Авторы?');
define('ARTICLE_PREV_NEXT_BAR_LOCATION_DESC', 'Расположение навигации Следующая/Предыдущая страница<br><br>top - верх<br>bottom - низ<br>both - (верх+низ)');
define('ARTICLE_WYSIWYG_ENABLE_DESC', 'Использовать HTML редактор для написания статей?');
define('ARTICLE_MANAGER_WYSIWYG_BASIC_DESC', 'Basic - Простой HTML редактор с минимальным количеством возможностей.<br>Advanced - Расширенный HTML редактор, максимальное количество возможностей.');
define('ARTICLE_MANAGER_WYSIWYG_WIDTH_DESC', 'Ширина HTML редактора в пикселах (по умолчанию: 605)');
define('ARTICLE_MANAGER_WYSIWYG_HEIGHT_DESC', 'Высота HTML редактора в пикселах (по умолчанию: 300)');
define('ARTICLE_MANAGER_WYSIWYG_FONT_TYPE_DESC', 'Шрифт интерфейса HTML редактора, никак не связано с теми данными, которые Вы будете вводить с помощью HTML редактора.');
define('ARTICLE_MANAGER_WYSIWYG_FONT_SIZE_DESC', 'Размер шрифта интерфейса HTML редактора, никак не связано с теми данными, которые Вы будете вводить с помощью HTML редактора.');
define('ARTICLE_MANAGER_WYSIWYG_FONT_COLOUR_DESC', 'Цвет шрифта интерфейса HTML редактора, никак не связано с теми данными, которые Вы будете вводить с помощью HTML редактора. Вы можете указать либо код цвета, например #FFFFFF, либо название цвета, например black.');
define('ARTICLE_MANAGER_WYSIWYG_BG_COLOUR_DESC', 'Цвет фона интерфейса HTML редактора, никак не связано с теми данными, которые Вы будете вводить с помощью HTML редактора. Вы можете указать либо код цвета, например #FFFFFF, либо название цвета, например black.');
define('ARTICLE_MANAGER_WYSIWYG_DEBUG_DESC', 'Следить за генерируемым HTML-кодом, т.е. Вы можете видеть, какой HTML-код создаётся при использовании HTML редактора.<br><br>0 - Отключить.<br>1 - Включить<br>По умолчанию стоит 0');

// Установка модулей

define('DIR_FS_CIP_TITLE' , 'Директория с модулями');
define('DIR_FS_CIP_DESC' , 'Директория, где будут находиться архивы с модулями');
define('ALLOW_SQL_BACKUP_TITLE' , 'Делать резервную копию базы данных перед установкой нового модуля');
define('ALLOW_SQL_BACKUP_DESC' , 'Если база данных большая, лучше поставить false.');
define('ALLOW_SQL_RESTORE_TITLE' , 'Восстанавливать резервную копию базы данных при удалении модуля');
define('ALLOW_SQL_RESTORE_DESC' , 'Ставьте true только для отладки и если Вы точно знаете, как и для чего работает данная опция.');
define('ALLOW_FILES_BACKUP_TITLE' , 'Делать резервные копии файлов перед установкой нового модуля');
define('ALLOW_FILES_BACKUP_DESC' , 'Сохраняются только файлы, которые изменяет установщик модулей, рекомендуется поставить true.');
define('ALLOW_FILES_RESTORE_TITLE' , 'Восстанавливать резервные копии файлов при удалении модуля');
define('ALLOW_FILES_RESTORE_DESC' , 'Ставьте true только для отладки и если Вы точно знаете, как и для чего работает данная опция.');
define('ALLOW_OVERWRITE_MODIFIED_TITLE' , 'Разрешить перезаписывать уже изменённые файлы');
define('ALLOW_OVERWRITE_MODIFIED_DESC' , 'Если true, то установщик модулей перезапишет уже изменённый при установке другого модуля файл. Ставьте true только для отладки и если Вы точно знаете, как и для чего работает данная опция.');
define('TEXT_LINK_FORUM_TITLE' , 'Ссылка на форум');
define('TEXT_LINK_FORUM_DESC' , 'Ссылка на форум поддежки');
define('TEXT_LINK_CONTR_TITLE' , 'Ссылка на каталог с модулями');
define('TEXT_LINK_CONTR_DESC' , 'URL каталога с доступными модулями для магазина.');
define('ALWAYS_DISPLAY_REMOVE_BUTTON_TITLE' , 'Всегда показывать кнопку удалить');
define('ALWAYS_DISPLAY_REMOVE_BUTTON_DESC' , 'Поставьте true и кнопка удалить будет показываться напротив каждого модуля, вне зависимости от того, установлен он или нет.');
define('ALWAYS_DISPLAY_INSTALL_BUTTON_TITLE' , 'Всегда показывать кнопку установить');
define('ALWAYS_DISPLAY_INSTALL_BUTTON_DESC' , 'Поставьте true и кнопка установить будет показываться напротив каждого модуля, вне зависимости от того, установлен он или нет.');
define('SHOW_PACK_BUTTONS_TITLE' , 'Показывать кнопки архивировать/разархивировать');
define('SHOW_PACK_BUTTONS_DESC' , 'Показывать - true, не показывать - false.');
define('SHOW_PERMISSIONS_COLUMN_TITLE' , 'Показывать колонку права доступа');
define('SHOW_PERMISSIONS_COLUMN_DESC' , 'Выберите true и в списке модулей будет отображаться колонка права доступа.');
define('SHOW_USER_GROUP_COLUMN_TITLE' , 'Показывать колонку пользователь/группа');
define('SHOW_USER_GROUP_COLUMN_DESC' , 'Выберите true и в списке модулей будет отображаться колонка пользователь/группа.');
define('SHOW_UPLOADER_COLUMN_TITLE' , 'Показывать колонку автор модуля');
define('SHOW_UPLOADER_COLUMN_DESC' , 'Выберите true и в списке модулей будет отображаться колонка автор модуля.');
define('SHOW_UPLOADED_COLUMN_TITLE' , 'Показывать колонку дата');
define('SHOW_UPLOADED_COLUMN_DESC' , 'Выберите true и в списке модулей будет отображаться колонка дата.');
define('SHOW_SIZE_COLUMN_TITLE' , 'Показывать колонку размер');
define('SHOW_SIZE_COLUMN_DESC' , 'Выберите true и в списке модулей будет отображаться колонка размер.');
define('USE_LOG_SYSTEM_TITLE' , 'Вести лог');
define('USE_LOG_SYSTEM_DESC' , 'Если true, то всё действия установщика модулей будут записываться в папку backups.');
define('MAX_UPLOADED_FILESIZE_TITLE' , 'Максимальный размер загружаемых CIP модулей');
define('MAX_UPLOADED_FILESIZE_DESC' , 'Установите максимальный размер архивов, которые Вы можете загружать через браузер в установщике модулей.');

define('MAX_QTY_IN_CART_TITLE' , 'Количество товара в корзине');
define('MAX_QTY_IN_CART_DESC' , 'Максимально возможное количество товара, которое может быть добавлено в корзину (0 - без ограничений)');

// Редактор заказов

define('ORDER_EDITOR_PAYMENT_DROPDOWN_TITLE','Показывать dropdown меню с модулями оплаты?');
define('ORDER_EDITOR_PAYMENT_DROPDOWN_DESC','Показывать способ оплаты заказа в виде drop-down меню (true), либо в виде input поля (false).');
define('ORDER_EDITOR_USE_SPPC_TITLE','Использовать возможности модуля SPPC (должно быть выключено)?');
define('ORDER_EDITOR_USE_SPPC_DESC','Данная опция должна быть выключена, т.к. на данный момент модуль SPPC не установлен.');
define('ORDER_EDITOR_USE_AJAX_TITLE','Использовать Ajax при редактировании заказа?');
define('ORDER_EDITOR_USE_AJAX_DESC','Если Ваш браузер не поддерживает JavaScript, установите false.');
define('ORDER_EDITOR_CREDIT_CARD_TITLE','Выбери способ оплаты кредитной карточкой');
define('ORDER_EDITOR_CREDIT_CARD_DESC','Редактор заказов выведет поля для указания информации о карточке когда будет выбран указанный в настройке способ оплаты.');

define('MAX_REVIEWS_TITLE','Количество отзывов на странице карточки товара');
define('MAX_REVIEWS_DESC','Максимальное количество отзывов, отображаемых на странице карточки товара.');

define('ENABLE_TABS_TITLE','Разрешить закладки в админке');
define('ENABLE_TABS_DESC','Использовать закладки в админке при добавлении/редактировании категорий, товаров, при редактировании заказов.');

define('MASTER_PASS_TITLE','Мастер пароль');
define('MASTER_PASS_DESC','С данным паролем Вы сможете входить в магазин под любым клиентом, указывая при входе email клиента и мастер пароль');

define('OPTIONS_AS_IMAGES_ENABLED_TITLE','Использовать модуль картинок атрибутов?');
define('OPTIONS_AS_IMAGES_ENABLED_DESC','Хотите разрешить модуль?');
define('OPTIONS_IMAGES_NUMBER_PER_ROW_TITLE','Число картинок в одном ряду');
define('OPTIONS_IMAGES_NUMBER_PER_ROW_DESC','Введите максимальную длину ряда картинок');
define('OPTIONS_IMAGES_WIDTH_TITLE','Ширина картинки атрибута');
define('OPTIONS_IMAGES_WIDTH_DESC','Укажите ширины картинки атрибута.');
define('OPTIONS_IMAGES_HEIGHT_TITLE','Высота картинки атрибута');
define('OPTIONS_IMAGES_HEIGHT_DESC','Укажите высоту картинки атрибута.');
define('OPTIONS_IMAGES_CLICK_ENLARGE_TITLE','Увеличение кликом');
define('OPTIONS_IMAGES_CLICK_ENLARGE_DESC','Активировать функцию увеличения картинки кликом мышки?');

define('SET_BOX_CATEGORIES_TITLE', 'Разделы');
define('SET_BOX_INFORMATION_TITLE', 'Информация');
define('SET_BOX_MANUFACTURERS_TITLE', 'Производитель');
define('SET_BOX_LATESTNEWS_TITLE', 'Новости');
define('SET_BOX_SEARCH_TITLE', 'Поиск');
define('SET_BOX_WHATSNEW_TITLE', 'Новинки');
define('SET_BOX_FEATURED_TITLE', 'Рекомендуемые');
define('SET_BOX_SHOP_BY_PRICE_TITLE', 'Сортировка по цене');
define('SET_BOX_ARTICLES_TITLE', 'Статьи');
define('SET_BOX_AUTHORS_TITLE', 'Авторы');
define('SET_BOX_LINKS_TITLE', 'Ссылки');
define('SET_BOX_CART_TITLE', 'Корзина');
define('SET_BOX_DOWNLOADS_TITLE', 'Мои загрузки');
define('SET_BOX_HELP_TITLE', 'Консультант');
define('SET_BOX_LOGIN_TITLE', 'Вход');
define('SET_BOX_WISHLIST_TITLE', 'Отложенные товары');
define('SET_BOX_AFFILIATE_TITLE', 'Партнёрская программа');
define('SET_BOX_FAQ_TITLE', 'Вопросы и ответы - категории');
define('SET_BOX_FAQ_LATEST_TITLE', 'Последние вопросы и ответы');
define('SET_BOX_POLLS_TITLE', 'Опросы');
define('SET_BOX_MANUFACTURERS_INFO_TITLE', 'Информация о производителе');
define('SET_BOX_ORDER_HISTORY_TITLE', 'Информация о заказах');
define('SET_BOX_BESTSELLERS_TITLE', 'Лучшие товары');
define('SET_BOX_NOTIFICATIONS_TITLE', 'Уведомления');
define('SET_BOX_SET_BOX_TELL_A_FRIEND_TITLE', 'Рассказать другу');
define('SET_BOX_SPECIALS_TITLE', 'Скидки');
define('SET_BOX_REVIEWS_TITLE', 'Отзывы');
define('SET_BOX_LANGUAGES_TITLE', 'Языки');
define('SET_BOX_CURRENCIES_TITLE', 'Валюты');

define('SET_BOX_CATEGORIES_DESC', 'Включить/выключить бокс.');
define('SET_BOX_INFORMATION_DESC', 'Включить/выключить бокс.');
define('SET_BOX_MANUFACTURERS_DESC', 'Включить/выключить бокс.');
define('SET_BOX_LATESTNEWS_DESC', 'Включить/выключить бокс.');
define('SET_BOX_SEARCH_DESC', 'Включить/выключить бокс.');
define('SET_BOX_WHATSNEW_DESC', 'Включить/выключить бокс.');
define('SET_BOX_FEATURED_DESC', 'Включить/выключить бокс.');
define('SET_BOX_SHOP_BY_PRICE_DESC', 'Включить/выключить бокс.');
define('SET_BOX_ARTICLES_DESC', 'Включить/выключить бокс.');
define('SET_BOX_AUTHORS_DESC', 'Включить/выключить бокс.');
define('SET_BOX_LINKS_DESC', 'Включить/выключить бокс.');
define('SET_BOX_CART_DESC', 'Включить/выключить бокс.');
define('SET_BOX_DOWNLOADS_DESC', 'Включить/выключить бокс.');
define('SET_BOX_HELP_DESC', 'Включить/выключить бокс.');
define('SET_BOX_LOGIN_DESC', 'Включить/выключить бокс.');
define('SET_BOX_WISHLIST_DESC', 'Включить/выключить бокс.');
define('SET_BOX_AFFILIATE_DESC', 'Включить/выключить бокс.');
define('SET_BOX_FAQ_DESC', 'Включить/выключить бокс.');
define('SET_BOX_FAQ_LATEST_DESC', 'Включить/выключить бокс.');
define('SET_BOX_POLLS_DESC', 'Включить/выключить бокс.');
define('SET_BOX_MANUFACTURERS_INFO_DESC', 'Включить/выключить бокс.');
define('SET_BOX_ORDER_HISTORY_DESC', 'Включить/выключить бокс.');
define('SET_BOX_BESTSELLERS_DESC', 'Включить/выключить бокс.');
define('SET_BOX_NOTIFICATIONS_DESC', 'Включить/выключить бокс.');
define('SET_BOX_SET_BOX_TELL_A_FRIEND_DESC', 'Включить/выключить бокс.');
define('SET_BOX_SPECIALS_DESC', 'Включить/выключить бокс.');
define('SET_BOX_REVIEWS_DESC', 'Включить/выключить бокс.');
define('SET_BOX_LANGUAGES_DESC', 'Включить/выключить бокс.');
define('SET_BOX_CURRENCIES_DESC', 'Включить/выключить бокс.');

//Products Specifications

define('SPECIFICATIONS_PRODUCTS_HEAD_TITLE', '<b>Страница карточки товара</b>');
define('SPECIFICATIONS_PRODUCTS_HEAD_DESC', 'Страница карточки товара');
define('SPECIFICATIONS_MINIMUM_PRODUCTS_TITLE', 'Минимум спецификаций у товара');
define('SPECIFICATIONS_MINIMUM_PRODUCTS_DESC', 'Минимальное количество спецификаций, которое должно быть у товара, необходимое для отображение бокса спецификаций на странице карточки товара');
define('SPECIFICATIONS_SHOW_NAME_PRODUCTS_TITLE', 'Показывать название спецификации');
define('SPECIFICATIONS_SHOW_NAME_PRODUCTS_DESC', 'Показывать название спецификации в боксе');
define('SPECIFICATIONS_SHOW_TITLE_PRODUCTS_TITLE', 'Показывать заголовок спецификации');
define('SPECIFICATIONS_SHOW_TITLE_PRODUCTS_DESC', 'Показывать заголовок спецификации в боксе');
define('SPECIFICATIONS_BOX_FRAME_STYLE_TITLE', 'Стиль бокса спецификаций');
define('SPECIFICATIONS_BOX_FRAME_STYLE_DESC', 'Показывать спецификации в стандартном боксе (Stock), в простом боксе (Simple), без бокса (Plain), либо в виде закладок (Tabs)');
define('SPECIFICATIONS_REVIEWS_TAB_TITLE', 'Показывать закладку отзывы');
define('SPECIFICATIONS_REVIEWS_TAB_DESC', 'Показывать закладку отзывы');
define('SPECIFICATIONS_MAX_REVIEWS_TITLE', 'Максимум отзывов в закладке');
define('SPECIFICATIONS_MAX_REVIEWS_DESC', 'Максимальное количество отзывов, отображаемых в закладке отзывы');
define('SPECIFICATIONS_QUESTION_TAB_TITLE', 'Показывать закладку задать вопрос о товаре');
define('SPECIFICATIONS_QUESTION_TAB_DESC', 'Показывать закладку задать вопрос о товаре');

define('SPECIFICATIONS_COMPARISON_HEAD_TITLE', '<b>Страница сравнения</b>');
define('SPECIFICATIONS_COMPARISON_HEAD_DESC', 'Страница сравнения');
define('SPECIFICATIONS_MINIMUM_COMPARISON_TITLE', 'Минимум спецификаций для сравнения');
define('SPECIFICATIONS_MINIMUM_COMPARISON_DESC', 'Минимальное количество спецификаций, которое должно быть у товара, необходимое для возможности сравнения');
define('SPECIFICATIONS_COMP_LINK_TITLE', 'Ссылка сравнения на начальной странице');
define('SPECIFICATIONS_COMP_LINK_DESC', 'Показывать ссылку сравнения на начальной странице');
define('SPECIFICATIONS_COMP_TABLE_ROW_TITLE', 'Рядов в таблице сравнения');
define('SPECIFICATIONS_COMP_TABLE_ROW_DESC', 'Количество рядов в таблице сравнения');
define('SPECIFICATIONS_BOX_COMPARISON_TITLE', 'Показывать сравнение');
define('SPECIFICATIONS_BOX_COMPARISON_DESC', 'Показывать таблицу сравнения на отдельной странице');
define('SPECIFICATIONS_BOX_COMP_INDEX_TITLE', 'Сравнение на начальной странице');
define('SPECIFICATIONS_BOX_COMP_INDEX_DESC', 'Показывать таблицу сравнения на начальной странице вместо страницы списка товара');
define('SPECIFICATIONS_COMP_SUFFIX_TITLE', 'Суффикс сравнения в заголовке');
define('SPECIFICATIONS_COMP_SUFFIX_DESC', 'Показывать суффикс в заголовке таблицы сравнения');
define('SPECIFICATIONS_COMPARISON_STYLE_TITLE', 'Стиль бокса спецификаций');
define('SPECIFICATIONS_COMPARISON_STYLE_DESC', 'Показывать спецификации в стандартном боксе (Stock), в простом боксе (Simple), либо без бокса (Plain)');
define('SPECIFICATIONS_COMBO_MFR_TITLE', 'Показывать производителя');
define('SPECIFICATIONS_COMBO_MFR_DESC', 'Показывать производителя (0 = не показывать, 1-9 = порядок сортировки)');
define('SPECIFICATIONS_COMBO_WEIGHT_TITLE', 'Показывать вес');
define('SPECIFICATIONS_COMBO_WEIGHT_DESC', 'Показывать вес (0 = не показывать, 1-9 = порядок сортировки)');
define('SPECIFICATIONS_COMBO_PRICE_TITLE', 'Показывать стоимость');
define('SPECIFICATIONS_COMBO_PRICE_DESC', 'Показывать стоимость (0 = не показывать, 1-9 = порядок сортировки)');
define('SPECIFICATIONS_COMBO_MODEL_TITLE', 'Показывать код товара');
define('SPECIFICATIONS_COMBO_MODEL_DESC', 'Показывать код товара (0 = не показывать, 1-9 = порядок сортировки)');
define('SPECIFICATIONS_COMBO_IMAGE_TITLE', 'Показывать картинку товара');
define('SPECIFICATIONS_COMBO_IMAGE_DESC', 'Показывать картинку товара (0 = не показывать, 1-9 = порядок сортировки)');
define('SPECIFICATIONS_COMBO_NAME_TITLE', 'Показывать название товара');
define('SPECIFICATIONS_COMBO_NAME_DESC', 'Показывать название товара (0 = не показывать, 1-9 = порядок сортировки)');
define('SPECIFICATIONS_COMBO_BUY_NOW_TITLE', 'Показывать кнопку купить сейчас');
define('SPECIFICATIONS_COMBO_BUY_NOW_DESC', 'Показывать кнопку купить сейчас (0 = не показывать, 1-9 = порядок сортировки)');

define('SPECIFICATIONS_FILTERS_HEAD_TITLE', '<b>Фильтры товаров</b>');
define('SPECIFICATIONS_FILTERS_HEAD_DESC', 'Фильтры товаров');
define('SPECIFICATIONS_FILTERS_MODULE_TITLE', 'Показывать фильтры');
define('SPECIFICATIONS_FILTERS_MODULE_DESC', 'Показывать фильтры в центральной колонке (основной части страницы)');
define('SPECIFICATIONS_FILTERS_BOX_TITLE', 'Показывать бокс фильтры');
define('SPECIFICATIONS_FILTERS_BOX_DESC', 'Показывать сбоку бокс фильтры');
define('SPECIFICATIONS_FILTER_MINIMUM_TITLE', 'Минимум спецификаций для фильтра');
define('SPECIFICATIONS_FILTER_MINIMUM_DESC', 'Минимальное количество спецификаций, необходимое для отображения бокса фильтры');
define('SPECIFICATIONS_FILTER_SUBCATEGORIES_TITLE', 'Фильтры подкатегорий');
define('SPECIFICATIONS_FILTER_SUBCATEGORIES_DESC', 'Включать подкатегории в результаты фильтрации');
define('SPECIFICATIONS_FILTER_SHOW_COUNT_TITLE', 'Показывать счётчик товаров в фильтрах');
define('SPECIFICATIONS_FILTER_SHOW_COUNT_DESC', 'Показывать количество найденных товаров');
define('SPECIFICATIONS_FILTER_NO_RESULT_TITLE', 'Не найдено товаров при фильтрации');
define('SPECIFICATIONS_FILTER_NO_RESULT_DESC', 'Что будет отображаться в случае отсутствия найденных товаров при фильтрации.');
define('SPECIFICATIONS_FILTER_BREADCRUMB_TITLE', 'Показывать навигацию');
define('SPECIFICATIONS_FILTER_BREADCRUMB_DESC', 'Показывать текущие фильтры в навигации');
define('SPECIFICATIONS_FILTER_IMAGE_WIDTH_TITLE', 'Ширина картинки фильтров');
define('SPECIFICATIONS_FILTER_IMAGE_WIDTH_DESC', 'Установите ширину картинки, отображаемой в боксе фильтры.');
define('SPECIFICATIONS_FILTER_IMAGE_HEIGHT_TITLE', 'Высота картинки фильтров');
define('SPECIFICATIONS_FILTER_IMAGE_HEIGHT_DESC', 'Установите высоту картинки, отображаемой в боксе фильтры.');

define('SET_BOX_FILTERS_TITLE', 'Фильтры');
define('SET_BOX_FILTERS_DESC', 'Включить/выключить бокс.');

define('EMAIL_SMTP_SERVER_TITLE' , 'SMTP сервер');
define('EMAIL_SMTP_SERVER_DESC' , 'Укажите smtp сервер, если Вы включили отправку почты через smtp.');
define('EMAIL_SMTP_PORT_TITLE' , 'SMTP сервер: Порт');
define('EMAIL_SMTP_PORT_DESC' , 'Установите порт smtp сервера.');
define('EMAIL_SMTP_AUTH_TITLE' , 'SMTP авторизация');
define('EMAIL_SMTP_AUTH_DESC' , 'SMTP авторизация.');
define('EMAIL_SMTP_USERNAME_TITLE' , 'SMTP сервер: Имя пользователя');
define('EMAIL_SMTP_USERNAME_DESC' , 'Установите имя пользователя для подключения к серверу.');
define('EMAIL_SMTP_PASSWORD_TITLE' , 'SMTP сервер: Пароль');
define('EMAIL_SMTP_PASSWORD_DESC' , 'Установите пароль для подключения к серверу.');

define('ENABLE_MAP_TAB_TITLE','Показывать закладку карта на странице заказа');
define('ENABLE_MAP_TAB_DESC','Включить/Отключить закладку карта на странице заказа.');
define('MAP_API_KEY_TITLE','Яндекс карты API-Ключ');
define('MAP_API_KEY_DESC','Укажите Ваш API ключ.');

define('USE_EMAIL_QUEUE_TITLE','Включить email очередь');
define('USE_EMAIL_QUEUE_DESC','Отправлять почту через модуль email очередь');
define('HOLD_EMAIL_QUEUE_TITLE','Блокировать email очередь');
define('HOLD_EMAIL_QUEUE_DESC','Блокировать все email на отправку');

define('SITE_TIME_ZONE_TITLE', 'Временная зона');
define('SITE_TIME_ZONE_DESC', 'Временная зона');

define('DOWNLOADS_AVAILABLE_STATUS_TITLE', 'Показывать PIN код для заказов с id статусом');
define('DOWNLOADS_AVAILABLE_STATUS_DESC', 'Заказ должен иметь указанный статус или выше, что б можно было видеть заказанный PIN код.');

define('FILTERS_MAIN_PAGE_TITLE', 'Показывать фильтры на главной странице');
define('FILTERS_MAIN_PAGE_DESC', 'Показывать настроенные фильтры на главной странице магазина.');

define('SMART_CHECKOUT_TITLE', 'Разрешить быстрое оформление заказов');
define('SMART_CHECKOUT_DESC', 'Вы хотите активировать модуль быстрого оформления заказов?');
define('SC_CREATE_ACCOUNT_REQUIRED_TITLE', 'Создание аккаунта обязательно');
define('SC_CREATE_ACCOUNT_REQUIRED_DESC', 'Обязательное создание аккаунта для покупателя при быстром оформлении заказа');
define('SC_CREATE_ACCOUNT_CHECKOUT_PAGE_TITLE', 'Создание аккаунта на усмотрение покупателя');
define('SC_CREATE_ACCOUNT_CHECKOUT_PAGE_DESC', 'Создание аккаунта для покупателя при быстром оформлении заказа не является обязательным, появляется опция при быстром оформлении заказа');
define('SC_HIDE_SHIPPING_TITLE', 'Скрыть выбор способа доставки');
define('SC_HIDE_SHIPPING_DESC', 'Если у Вас активирован только один модуль доставки, нет необходимости покупателю показывать выбор доставки на странице быстрого оформления заказа. Выбор доставки не показывается только если включена данная опция и у Вас активен только один модуль доставки.');
define('SC_HIDE_COMMENT_TITLE', 'Скрыть комментарии');
define('SC_HIDE_COMMENT_DESC', 'Показывать покупателю блок с возможностью оставить комментарии к заказу?');
define('SC_COUNTER_ENABLED_TITLE', 'Шаги оформления');
define('SC_COUNTER_ENABLED_DESC', 'Показывать шаги быстрого оформления заказа');
define('SC_EMAIL_LOGIN_DATA_TITLE', 'Отправлять данные для входа');
define('SC_EMAIL_LOGIN_DATA_DESC', 'Если включена данная опция, то данные для входа в магазин отправляются покупателю на указанный при быстром оформлении заказа email.');
define('SC_CONFIRMATION_PAGE_TITLE', 'Страница подтверждения заказа');
define('SC_CONFIRMATION_PAGE_DESC', 'Включить переход на страницу подтверждения заказа?');

?>