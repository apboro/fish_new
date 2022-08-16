<?php
/*
  $Id: russian.php,v 1.114 2003/07/09 18:13:39 dgw_ Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2013 osCommerce

  Released under the GNU General Public License
*/

// look in your $PATH_LOCALE/locale directory for available locales
// or type locale -a on the server.
// Examples:
// on RedHat try 'en_US'
// on FreeBSD try 'en_US.ISO_8859-1'
// on Windows try 'en', or 'English'
@setlocale(LC_TIME, 'ru_RU.UTF-8');

define('DATE_FORMAT_SHORT', '%d/%m/%Y');  // this is used for strftime()
define('DATE_FORMAT_LONG', '%A %d %B, %Y'); // this is used for strftime()
define('DATE_FORMAT', 'd/m/Y'); // this is used for date()
define('DATE_TIME_FORMAT', DATE_FORMAT_SHORT . ' %H:%M:%S');
define('JQUERY_DATEPICKER_I18N_CODE', ''); // leave empty for en_US; see http://jqueryui.com/demos/datepicker/#localization
define('JQUERY_DATEPICKER_FORMAT', 'dd/mm/yy'); // see http://docs.jquery.com/UI/Datepicker/formatDate

////
// Return date in raw format
// $date should be in format dd/mm/yyyy
// raw date is in format YYYYMMDD, or DDMMYYYY
function tep_date_raw($date, $reverse = false) {
  if ($reverse) {
    return substr($date, 0, 2) . substr($date, 3, 2) . substr($date, 6, 4);
  } else {
    return substr($date, 6, 4) . substr($date, 3, 2) . substr($date, 0, 2);
  }
}

// if USE_DEFAULT_LANGUAGE_CURRENCY is true, use the following currency, instead of the applications default currency (used when changing language)
define('LANGUAGE_CURRENCY', 'RUR');

// Global entries for the <html> tag
define('HTML_PARAMS', 'dir="ltr" lang="ru"');

// charset for web pages and emails
define('CHARSET', 'UTF-8');
mb_internal_encoding('UTF-8');

// page title
define('TITLE', STORE_NAME);

// header text in includes/header.php
define('HEADER_TITLE_CREATE_ACCOUNT', 'Регистрация');
define('HEADER_TITLE_MY_ACCOUNT', 'Мои данные');
define('HEADER_TITLE_CART_CONTENTS', 'Корзина');
define('HEADER_TITLE_CHECKOUT', 'Оформить заказ');
define('HEADER_TITLE_TOP', 'Магазин');
define('HEADER_TITLE_CATALOG', 'Каталог');
define('HEADER_TITLE_LOGOFF', 'Выход');
define('HEADER_TITLE_LOGIN', 'Вход');

// footer text in includes/footer.php
define('FOOTER_TEXT_REQUESTS_SINCE', 'просмотренных страниц c');

// text for gender
define('MALE', 'Мужской');
define('FEMALE', 'Женский');
define('MALE_ADDRESS', 'Г-н');
define('FEMALE_ADDRESS', 'Г-жа');

// text for date of birth example
define('DOB_FORMAT_STRING', 'dd/mm/yyyy');

// checkout procedure text
define('CHECKOUT_BAR_DELIVERY', 'Адрес доставки');
define('CHECKOUT_BAR_PAYMENT', 'Способ оплаты');
define('CHECKOUT_BAR_CONFIRMATION', 'Подтверждение');
define('CHECKOUT_BAR_FINISHED', 'Заказ оформлен!');

// pull down default text
define('PULL_DOWN_DEFAULT', 'Выберите');
define('TYPE_BELOW', 'Выбор ниже');

// javascript messages
define('JS_ERROR', 'Ошибки при заполнении формы!\n\nИсправьте пожалуйста:\n\n');

define('JS_REVIEW_TEXT', '* Поле \'Текст отзыва\' должно содержать не менее ' . REVIEW_TEXT_MIN_LENGTH . ' символов.\n');
define('JS_REVIEW_RATING', '* Оцените, пожалуйста, продукт по пятибальной шкале.\n');

define('JS_ERROR_NO_PAYMENT_MODULE_SELECTED', '* Выберите метод оплаты для Вашего заказа.\n');

define('JS_ERROR_SUBMITTED', 'Эта форма уже заполнена. Нажимайте Ok.');

define('ERROR_NO_PAYMENT_MODULE_SELECTED', 'Выберите, пожалуйста, метод оплаты для Вашего заказа.');

define('CATEGORY_COMPANY', 'Организация');
define('CATEGORY_PERSONAL', 'Ваши персональные данные');
define('CATEGORY_ADDRESS', 'Ваш адрес');
define('CATEGORY_CONTACT', 'Контактная информация');
define('CATEGORY_OPTIONS', 'Рассылка');
define('CATEGORY_PASSWORD', 'Ваш пароль');

define('ENTRY_COMPANY', 'Название компании:');
define('ENTRY_COMPANY_TEXT', '');
define('ENTRY_GENDER', 'Пол:');
define('ENTRY_GENDER_ERROR', 'Вы должны указать свой пол.');
define('ENTRY_GENDER_TEXT', '*');
define('ENTRY_FIRST_NAME', 'Имя:');
define('ENTRY_FIRST_NAME_ERROR', 'Поле Имя должно содержать как минимум ' . ENTRY_FIRST_NAME_MIN_LENGTH . ' символа.');
define('ENTRY_FIRST_NAME_TEXT', '*');
define('ENTRY_LAST_NAME', 'Фамилия:');
define('ENTRY_LAST_NAME_ERROR', 'Поле Фамилия должно содержать как минимум ' . ENTRY_LAST_NAME_MIN_LENGTH . ' символа.');
define('ENTRY_LAST_NAME_TEXT', '*');
define('ENTRY_DATE_OF_BIRTH', 'Дата рождения:');
define('ENTRY_DATE_OF_BIRTH_ERROR', 'Дату рождения необходимо вводить в следующем формате: MM/DD/YYYY (пример 05/21/1970)');
define('ENTRY_DATE_OF_BIRTH_TEXT', '* (пример 05/21/1970)');
define('ENTRY_EMAIL_ADDRESS', 'E-Mail:');
define('ENTRY_EMAIL_ADDRESS_ERROR', 'Поле E-Mail должно содержать как минимум ' . ENTRY_EMAIL_ADDRESS_MIN_LENGTH . ' символов.');
define('ENTRY_EMAIL_ADDRESS_CHECK_ERROR', 'Ваш E-Mail адрес указан неправильно, попробуйте ещё раз.');
define('ENTRY_EMAIL_ADDRESS_ERROR_EXISTS', 'Введённый Вами E-Mail уже зарегистрирован в нашем магазине, попробуйте указать другой E-Mail адрес.');
define('ENTRY_EMAIL_ADDRESS_TEXT', '*');
define('ENTRY_STREET_ADDRESS', 'Улица и номер дома:');
define('ENTRY_STREET_ADDRESS_ERROR', 'Поле Улица и номер дома должно содержать как минимум ' . ENTRY_STREET_ADDRESS_MIN_LENGTH . ' символов.');
define('ENTRY_STREET_ADDRESS_TEXT', '*');
define('ENTRY_SUBURB', 'Дополнительный адрес:');
define('ENTRY_SUBURB_TEXT', '');
define('ENTRY_POST_CODE', 'Почтовый индекс:');
define('ENTRY_POST_CODE_ERROR', 'Поле Почтовый индекс должно содержать как минимум ' . ENTRY_POSTCODE_MIN_LENGTH . ' символа.');
define('ENTRY_POST_CODE_TEXT', '*');
define('ENTRY_CITY', 'Город:');
define('ENTRY_CITY_ERROR', 'Поле Город должно содержать как минимум ' . ENTRY_CITY_MIN_LENGTH . ' символа.');
define('ENTRY_CITY_TEXT', '*');
define('ENTRY_STATE', 'Область:');
define('ENTRY_STATE_ERROR', 'Поле Область должно содержать как минимум ' . ENTRY_STATE_MIN_LENGTH . ' символа.');
define('ENTRY_STATE_ERROR_SELECT', 'Выберите область.');
define('ENTRY_STATE_TEXT', '*');
define('ENTRY_COUNTRY', 'Страна:');
define('ENTRY_COUNTRY_ERROR', 'Выберите страну.');
define('ENTRY_COUNTRY_TEXT', '*');
define('ENTRY_TELEPHONE_NUMBER', 'Телефон:');
define('ENTRY_TELEPHONE_NUMBER_ERROR', 'Поле Телефон должно содержать как минимум ' . ENTRY_TELEPHONE_MIN_LENGTH . ' символа.');
define('ENTRY_TELEPHONE_NUMBER_TEXT', '*');
define('ENTRY_FAX_NUMBER', 'Факс:');
define('ENTRY_FAX_NUMBER_TEXT', '');
define('ENTRY_NEWSLETTER', 'Новости магазина:');
define('ENTRY_NEWSLETTER_TEXT', '');
define('ENTRY_NEWSLETTER_YES', 'Подписаться');
define('ENTRY_NEWSLETTER_NO', 'Отказаться от подписки');
define('ENTRY_PASSWORD', 'Пароль:');
define('ENTRY_PASSWORD_ERROR', 'Ваш пароль должен содержать как минимум ' . ENTRY_PASSWORD_MIN_LENGTH . ' символов.');
define('ENTRY_PASSWORD_ERROR_NOT_MATCHING', 'Поле Подтвердите пароль должно совпадать с полем Пароль.');
define('ENTRY_PASSWORD_TEXT', '*');
define('ENTRY_PASSWORD_CONFIRMATION', 'Подтвердите пароль:');
define('ENTRY_PASSWORD_CONFIRMATION_TEXT', '*');
define('ENTRY_PASSWORD_CURRENT', 'Текущий пароль:');
define('ENTRY_PASSWORD_CURRENT_TEXT', '*');
define('ENTRY_PASSWORD_CURRENT_ERROR', 'Поле Пароль должно содержать как минимум ' . ENTRY_PASSWORD_MIN_LENGTH . ' символов.');
define('ENTRY_PASSWORD_NEW', 'Новый пароль:');
define('ENTRY_PASSWORD_NEW_TEXT', '*');
define('ENTRY_PASSWORD_NEW_ERROR', 'Ваш Новый пароль должен содержать как минимум ' . ENTRY_PASSWORD_MIN_LENGTH . ' символов.');
define('ENTRY_PASSWORD_NEW_ERROR_NOT_MATCHING', 'Поля Подтвердите пароль и Новый пароль должны совпадать.');
define('PASSWORD_HIDDEN', '--СКРЫТ--');

define('FORM_REQUIRED_INFORMATION', '* Обязательно для заполнения');

// constants for use in tep_prev_next_display function
define('TEXT_RESULT_PAGE', 'Страницы:');
define('TEXT_DISPLAY_NUMBER_OF_PRODUCTS', 'Показано <b>%d</b> - <b>%d</b> (всего <b>%d</b> позиций)');
define('TEXT_DISPLAY_NUMBER_OF_ORDERS', 'Показано <b>%d</b> - <b>%d</b> (всего <b>%d</b> заказов)');
define('TEXT_DISPLAY_NUMBER_OF_REVIEWS', 'Показано <b>%d</b> - <b>%d</b> (всего <b>%d</b> отзывов)');
define('TEXT_DISPLAY_NUMBER_OF_PRODUCTS_NEW', 'Показано <b>%d</b> - <b>%d</b> (всего <b>%d</b> новинок)');
define('TEXT_DISPLAY_NUMBER_OF_SPECIALS', 'Показано <b>%d</b> - <b>%d</b> (всего <b>%d</b> специальных предложений)');

define('PREVNEXT_TITLE_FIRST_PAGE', 'Первая страница');
define('PREVNEXT_TITLE_PREVIOUS_PAGE', 'предыдущая');
define('PREVNEXT_TITLE_NEXT_PAGE', 'Следующая страница');
define('PREVNEXT_TITLE_LAST_PAGE', 'Последняя страница');
define('PREVNEXT_TITLE_PAGE_NO', 'Страница %d');
define('PREVNEXT_TITLE_PREV_SET_OF_NO_PAGE', 'Предыдущие %d страниц');
define('PREVNEXT_TITLE_NEXT_SET_OF_NO_PAGE', 'Следующие %d страниц');
define('PREVNEXT_BUTTON_FIRST', 'ПЕРВАЯ');
define('PREVNEXT_BUTTON_PREV', 'Предыдущая');
define('PREVNEXT_BUTTON_NEXT', 'Следующая');
define('PREVNEXT_BUTTON_LAST', 'ПОСЛЕДНЯЯ');

define('IMAGE_BUTTON_ADD_ADDRESS', 'Добавить адрес');
define('IMAGE_BUTTON_ADDRESS_BOOK', 'Адресная книга');
define('IMAGE_BUTTON_BACK', 'Назад');
define('IMAGE_BUTTON_BUY_NOW', 'Купить сейчас');
define('IMAGE_BUTTON_CHANGE_ADDRESS', 'Изменить адрес');
define('IMAGE_BUTTON_CHECKOUT', 'Оформить заказ');
define('IMAGE_BUTTON_CONFIRM_ORDER', 'Подтвердить Заказ');
define('IMAGE_BUTTON_CONTINUE', 'Продолжить');
define('IMAGE_BUTTON_CONTINUE_SHOPPING', 'Вернуться в магазин');
define('IMAGE_BUTTON_DELETE', 'Удалить');
define('IMAGE_BUTTON_EDIT_ACCOUNT', 'Редактировать учетные данные');
define('IMAGE_BUTTON_HISTORY', 'История заказов');
define('IMAGE_BUTTON_LOGIN', 'Войти');
define('IMAGE_BUTTON_IN_CART', 'Добавить в Корзину');
define('IMAGE_BUTTON_NOTIFICATIONS', 'Уведомления');
define('IMAGE_BUTTON_QUICK_FIND', 'Быстрый поиск');
define('IMAGE_BUTTON_REMOVE_NOTIFICATIONS', 'Удалить уведомления');
define('IMAGE_BUTTON_REVIEWS', 'Отзывы');
define('IMAGE_BUTTON_SEARCH', 'Искать');
define('IMAGE_BUTTON_SHIPPING_OPTIONS', 'Способы доставки');
define('IMAGE_BUTTON_TELL_A_FRIEND', 'Написать другу');
define('IMAGE_BUTTON_UPDATE', 'Обновить');
define('IMAGE_BUTTON_UPDATE_CART', 'Пересчитать');
define('IMAGE_BUTTON_WRITE_REVIEW', 'Написать отзыв');

define('SMALL_IMAGE_BUTTON_DELETE', 'Удалить');
define('SMALL_IMAGE_BUTTON_EDIT', 'Изменить');
define('SMALL_IMAGE_BUTTON_VIEW', 'Смотреть');

define('ICON_ARROW_RIGHT', 'Перейти');
define('ICON_CART', 'В корзину');
define('ICON_ERROR', 'Ошибка');
define('ICON_SUCCESS', 'Выполнено');
define('ICON_WARNING', 'Внимание');

define('TEXT_GREETING_PERSONAL', 'Добро пожаловать <span class="greetUser">%s!</span> Вы хотите посмотреть какие <a href="%s"><u>новые товары</u></a> поступили в наш магазин?');
define('TEXT_GREETING_PERSONAL_RELOGON', '<small>Если Вы не %s, пожалуйста <a href="%s"><u>зарегистрируйтесь </u></a> и введите Вашу личную информацию.</small>');
define('TEXT_GREETING_GUEST', 'Добро пожаловать <span class="greetUser">уважаемый гость</span><br> Если Вы наш постоянный клиент, <a href="%s"><u>введите Ваши персональные данные</u></a> для входа. Если Вы у нас впервые и хотите сделать покупки, Вам необходимо <a href="%s"><u>зарегистрироваться</u></a>.');

define('TEXT_SORT_PRODUCTS', 'Сортировка товаров ');
define('TEXT_DESCENDINGLY', 'по убыванию');
define('TEXT_ASCENDINGLY', 'по возрастанию');
define('TEXT_BY', ' по ');

define('TEXT_REVIEW_BY', 'к %s');
define('TEXT_REVIEW_WORD_COUNT', '%s слова');
define('TEXT_REVIEW_RATING', 'Рейтинг: %s [%s]');
define('TEXT_REVIEW_DATE_ADDED', 'Дата добавления: %s');
define('TEXT_NO_REVIEWS', 'К настоящему времени нет отзывов, Вы можете стать первым.');

define('TEXT_NO_NEW_PRODUCTS', 'Сегодня нет новых товаров.');

define('TEXT_UNKNOWN_TAX_RATE', 'Налоговая ставка неизвестна');

define('TEXT_REQUIRED', '<span class="errorText">Обязательно</span>');

define('ERROR_TEP_MAIL', '<font face="Verdana, Arial" size="2" color="#ff0000"><b><small>ОШИБКА:</small> Невозможно отправить email через сервер SMTP. Проверьте, пожалуйста, Ваши установки php.ini и если необходимо, скорректируйте сервер SMTP.</b></font>');

define('TEXT_CCVAL_ERROR_INVALID_DATE', 'Вы указали неверную дату истечения срока действия кредитной карточки.<br>Попробуйте ещё раз.');
define('TEXT_CCVAL_ERROR_INVALID_NUMBER', 'Вы указали неверный номер кредитной карточки.<br>Попробуйте ещё раз.');
define('TEXT_CCVAL_ERROR_UNKNOWN_CARD', 'Первые цифры Вашей кредитной карточки: %s<br>Если Вы указали номер своей кредитной карточки правильно, сообщаем Вам, что мы не принимаем к оплате данный тип кредитных карточек.<br>Если Вы указали номер кредитной карточки неверно, попробуйте ещё раз.');

define('FOOTER_TEXT_BODY', 'Copyright &copy; ' . date('Y') . ' <a href="' . tep_href_link(FILENAME_DEFAULT) . '">' . STORE_NAME . '</a><br>Powered by <a href="http://www.oscommerce.com" target="_blank">osCommerce</a><br>Перевод - <a href="http://www.kypi.ru" target="_blank">Александр Меновщиков</a>  (Мodified by <a href="http://www.eshop-master.com" target="_blank">eShop-Master.com</a> и <a href="http://ecommerce-service.com" target="_blank"><b>eCommerce-Service.com</b></a>)');

// OSCMART LANGUAGES--------------------------------------------------------------------------------------------------------------------------------
define('HEADER_TITLE_HOME', 'домой');
define('TABLE_HEADING_SPECIAL_PRODUCTS', 'Товары со скидками за %s');
define('TEXT_SLIDESHOW_VIEW_MORE', 'Просмотреть больше');
define('TEXT_SHOP_NOW', 'Купите сейчас!');
define('TEXT_SLIDESHOW_SPECIAL', 'специальный');
define('TABLE_HEADING_PRODUCT_IMAGE', 'Изображение');
define('TABLE_HEADING_PRODUCT_DETAILS', 'Подробнее');
define('TABLE_HEADING_ADDTOCART', 'Добавить в корзину');



// manufacturer box text
define('BOX_HEADING_MANUFACTURER_INFO', 'Производитель');
define('BOX_MANUFACTURER_INFO_HOMEPAGE', '%s домашняя страница');
define('BOX_HOMEPAGE', 'Главная');
define('BOX_MANUFACTURER_INFO_OTHER_PRODUCTS', 'Другие продукты');

// whats_new box text in includes/boxes/whats_new.php
define('BOX_HEADING_WHATS_NEW', 'Что \'является Нью-?');

// specials box text in includes/boxes/specials.php
define('BOX_HEADING_SPECIALS', 'Скидки');
define('BOX_HEADING_TYPOGRAPHY', 'книгопечатание');
define('BOX_HEADING_SITEMAP', 'Карта сайта');

// information box text in includes/boxes/information.php
define('BOX_HEADING_INFORMATION', 'Информация');
define('BOX_INFORMATION_PRIVACY', 'Конфиденциальность');
define('BOX_INFORMATION_CONDITIONS', 'Условия использования');
define('BOX_INFORMATION_SHIPPING', 'Доставка и возврат');
define('BOX_INFORMATION_CONTACT', 'связаться с нами');

// quick_find box text in includes/boxes/quick_find.php
define('BOX_HEADING_SEARCH', 'Быстрый поиск');
define('HEADING_SEARCH', 'поиск');
define('BOX_SEARCH_TEXT', 'Используйте ключевые слова, чтобы найти продукт, который вы ищете.');
define('BOX_SEARCH_ADVANCED_SEARCH', 'Расширенный поиск');
define('INPUT_SEARCH', ' Поиск весь магазин...');

// currencies box text in includes/boxes/currencies.php
define('BOX_HEADING_CURRENCIES', 'Валюты');

// shopping cart box text in shopping_cart.php
define('PRODUCT_TITLE_CART', 'Название товара');
define('PRODUCT_QTY_CART', 'Кол-во.');
define('PRODUCT_UPDATE_CART', 'обновление');
define('PRODUCT_REMOVE_CART', 'удалять');
define('ENTRY_TOTAL_CART', 'общий');


//-----------------------------------------------------------------BOF HEADER CONTENT-----------------------------------------------------------------
define('TEXT_CALL_US', '');

define('TEXT_SEARCH', 'поиск');
define('TEXT_MAIN_MENU', 'Главное меню');
define('TEXT_STORE', 'магазин');
define('TEXT_CATEGORIES', 'Каталог');
define('TEXT_FREE_SHIPPING', '<span style="font-size:0.7Em;">Бесплатная доставка</span>');
// HEADER VALUES
define('OSMARTVAL_CALL_US', '<font style="font-size:0.7Em">клиентская служба</font>
<br><a href=https://wa.me/79262663218> написать в чат </a>');
define('OSMARTVAL_LOGO_TAGLINE', 'отзывчивый OsCommerce шаблон');
//define('OSMARTVAL_FREE_SHIPPING', 'По приказу свыше $ 599. Данное предложение действует на всех наших деталей магазина.');
define('OSMARTVAL_FREE_SHIPPING', '<b>Бесплатная доставка свыше %s</b>');
define('TEXT_FOOTER_DELIVERY_TITLE','Доставка');
define('TEXT_FOOTER_DELIVERY','<a href="/information.php?pages_id=6">Условия доставки</a>');

//-----------------------------------------------------------------EOF HEADER CONTENT-----------------------------------------------------------------
//-----------------------------------------------------------------BOF FOOTER CONTENT-----------------------------------------------------------------
define('TEXT_STAY_IN_TOUCH', 'Оставайтесь на связи');
define('TEXT_OUR_BRANDS', 'Наши Бренды');
define('TEXT_JOIN_OUR_NEWSLETTER', 'Подпишитесь на нашу рассылку');
define('TEXT_STORE_FINDER', 'Поиск магазина');
define('TEXT_STAY_UPDATED_WITH_OFFRES_AND_NEW_ARRIVALS', 'Будьте в курсе предложений и Новые поступления');
define('TEXT_FIND_STORE_NEAR_TO_YOU', 'Найдите адрес магазина рядом с вами');
define('TEXT_LATEST_PRODUCTS', 'Последние поступления');
define('TEXT_MORE', 'более');
define('TEXT_EXTRA', 'дополнительный');
define('TEXT_DELIVERY_INFORMATION', 'Информация о доставке');
define('TEXT_AFFILIATES', 'Партнеры');
define('TEXT_SITEMAP', 'Карта сайта');
define('TEXT_ABOUT_US', 'О нас');
define('TEXT_TERMS_AND_CONDITION', 'Условия и состояние');
define('TEXT_PRIVACY_POLICY', 'Политика конфиденциальности');
define('TEXT_REFUND_POLICY', 'Политика возврата');
define('TEXT_GET_IN_TOUCH', 'Связаться с нами');
define('TEXT_FIND_US_ON_MAP', '<a href="map.php">Найти нас на карте</a>');
define('TEXT_EMAIL_US_AT', 'Пишите нам по адресу:');
define('TEXT_TALK_TO_US', 'Обращайтесь к нам:');
define('TEXT_LINKEDIN', 'linkedin');
define('TEXT_RSS_FEED', 'RSS Feed');
define('TEXT_TWITTER', 'Twitter');
define('TEXT_FACEBOOK', 'Facebook');
define('TEXT_SUPPORT', 'поддержка');
define('TEXT_BACK_TO_TOP', 'Вернуться к началу');
define('TEXT_27_7_PHONE_SUPPORT', 'Поддержка по телефону:');

// GET IN TOUCH VALUES
define('OSMARTVAL_ADDRESS', 'Москва, 4й-Лихачевский переулок д2с2');
define('OSMARTVAL_EMAIL_US_AT', 'magazin@yourfish.ru');
//define('OSMARTVAL_PHONE', '<a href="tel:8800-222-41-49">8800-222-41-49</a>');
define('OSMARTVAL_SKYPE', '<a href="skype:yourfish.ru">+79262663218</a>');
define('OSMARTVAL_COPYRIGHT', '&copy; Copyright 2012 by mojoomla.com');

// SOCIALS LINK VALUES
define('SOCIAL_VK_A','https://vk.com/yourfish_ru');
define('SOCIAL_VK_TITLE','&nbsp;&nbsp;');
define('SOCIAL_YOUTUBE_A','https://www.youtube.com/user/YourFishru');
define('SOCIAL_YOUTUBE_TITLE','&nbsp;&nbsp;');
define('SOCIAL_TWITTER_A','https://twitter.com/YourFish_ru');
define('SOCIAL_TWITTER_TITLE','&nbsp;&nbsp;');
define('OSMARTVAL_LINKEDIN', 'http://www.linkedin.com');
define('OSMARTVAL_FEED', 'http://www.feed.com');
define('OSMARTVAL_TWITTER', 'http://www.twitter.com');
define('OSMARTVAL_FACEBOOK', 'http://www.facebook.com');
define('TEXT_ICQ_TO_US','Написать в WhatsApp:');
//define('OSMARTVAL_ICQ','<img loading="auto" src="http://www.icq.com/whitepages/online?icq=602218037&img=5"/>602218037');
define('OSMARTVAL_ICQ','<a href="https://wa.me/79262663218"> написать в чат </a>');
//-----------------------------------------------------------------EOF FOOTER CONTENT-----------------------------------------------------------------

//-----------------------------------------------------------------BOF HOMEPAGE CONTENT-----------------------------------------------------------------
define('TEXT_NEW', 'НОВИНКИ');
define('TEXT_SPECIAL', 'СКИДКИ');
//-----------------------------------------------------------------EOF HOMEPAGE CONTENT-----------------------------------------------------------------

//-----------------------------------------------------------------BOF PRODUCT INFO CONTENT-----------------------------------------------------------------
define('TEXT_TABS_DESCRIPTION', 'описание');
define('TEXT_TABS_REVIEWS', 'Отзывы');
define('TEXT_PRODINFO_PRICE', 'цена :');
define('TEXT_QUANTITY', 'количество :');
//-----------------------------------------------------------------EOF PRODUCT INFO CONTENT-----------------------------------------------------------------
define('TEXT_BUTTON_REMOVE', 'удалять');



define('TEXT_DISPLAY_NUMBER_OF_ARTICLES', 'Показано <b>%d</b> - <b>%d</b> (всего <b>%d</b> статей)');
define('TEXT_DISPLAY_NUMBER_OF_ARTICLES_NEW', 'Показано <b>%d</b> - <b>%d</b> (всего <b>%d</b> новых статей)');
define('PRODUCTS_ORDER_QTY_TEXT','Количество: ');
define('ENTRY_CAPTCHA', 'Код на картинке:');
define('ENTRY_CAPTCHA_ERROR', 'Вы неправильно указали код на картинке.');
define('HELP','<b>ICQ:</b><br><img loading="auto" border="0" align="absmiddle" title="Статус ICQ" src="'.echoHTTP().'yourfish.ru/Icq.png">
602218037<br><b>E-mail</b>:<br><a class="tov" href="mailto:magazin@yourfish.ru?subject=Ask yourfish">magazin@yourfish.ru</a>
<br><b>Skype:</b><br>yourfish.ru<br><b>Телефон:</b><br>+7(495)507-55-47');
define('HELP_HEADING', 'Консультант');
define('BOX_NEW_ARTICLES', 'Новые статьи');
define('BOX_ALL_ARTICLES', 'Все статьи');
define('BOX_HEADING_PRODUCTS_FILTER', 'Фильтры');
define('TEXT_SHOW_ALL', 'Показать все');

?>