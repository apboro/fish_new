<?php
/*
  $Id: russian.php,v 1.1.1.1 2012/09/18 19:04:27 wilt Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/

// look in your $PATH_LOCALE/locale directory for available locales
// or type locale -a on the server.
// Examples:
// on RedHat try 'en_US'
// on FreeBSD try 'en_US.ISO_8859-1'
// on Windows try 'en', or 'English'

switch(strtoupper($_SERVER['OS']))
{
	case 'WINDOWS_NT':
		@setlocale(LC_TIME, 'ru');
		break;
	default:
		@setlocale(LC_TIME, 'ru_RU.UTF-8');
		break;
}

define('DATE_FORMAT_SHORT', '%d/%m/%Y');  // this is used for strftime()
//define('DATE_FORMAT_LONG', '%A %d %B, %Y'); // this is used for strftime()
define('DATE_FORMAT_LONG', '%d %B %Y г.'); // this is used for strftime()
define('DATE_FORMAT', 'd/m/Y'); // this is used for date()
define('DATE_TIME_FORMAT', DATE_FORMAT_SHORT . ' %H:%M:%S');

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

// if USE_DEFAULT_LANGUAGE_CURRENCY is true, use the following currency, instead of the applications default currency (used when changing language)
define('LANGUAGE_CURRENCY', 'RUR');

// Global entries for the <html> tag
define('HTML_PARAMS','dir="LTR" lang="ru"');

// charset for web pages and emails
define('CHARSET', 'utf-8');

// page title
define('TITLE', 'Интернет-магазин');

// header text in includes/header.php
define('HEADER_TITLE_CREATE_ACCOUNT', 'Регистрация');
define('HEADER_TITLE_PASSWORD_FORGOTTEN', 'Не помню пароль');
define('HEADER_TITLE_MY_ACCOUNT', 'Мои данные');
define('HEADER_TITLE_CART_CONTENTS', 'Корзина');
define('HEADER_TITLE_CHECKOUT', 'Оформить заказ');
define('HEADER_TITLE_TOP', 'Главная');
define('HEADER_TITLE_CATALOG', 'Каталог');
define('HEADER_TITLE_LOGOFF', 'Выход');
define('HEADER_TITLE_LOGIN', 'Мои данные');

// footer text in includes/footer.php
define('FOOTER_TEXT_REQUESTS_SINCE', 'человек посетили магазин c');

// text for gender
define('MALE', 'Мужской');
define('FEMALE', 'Женский');
define('MALE_ADDRESS', 'Г-н');
define('FEMALE_ADDRESS', 'Г-жа');

// text for date of birth example
define('DOB_FORMAT_STRING', 'dd/mm/yyyy');

// quick_find box text in includes/boxes/quick_find.php
define('BOX_SEARCH_TEXT', 'Введите слово для поиска.');
define('BOX_SEARCH_ADVANCED_SEARCH', 'Расширенный поиск');

// reviews box text in includes/boxes/reviews.php
define('BOX_REVIEWS_WRITE_REVIEW', 'Напишите Ваше мнение о товаре!');
define('BOX_REVIEWS_NO_REVIEWS', 'К настоящему времени нет ни одного отзыва');
define('BOX_REVIEWS_TEXT_OF_5_STARS', '%s из 5 звёзд!');

// shopping_cart box text in includes/boxes/shopping_cart.php
define('BOX_SHOPPING_CART_EMPTY', 'Корзина пуста');

// notifications box text in includes/boxes/products_notifications.php
define('BOX_NOTIFICATIONS_NOTIFY', 'Сообщите мне о новинках и&nbsp;<b>%s</b>');
define('BOX_NOTIFICATIONS_NOTIFY_REMOVE', 'Не сообщайте мне о новинках <b>%s</b>');

// manufacturer box text
define('BOX_MANUFACTURER_INFO_HOMEPAGE', 'Сайт %s');
define('BOX_MANUFACTURER_INFO_OTHER_PRODUCTS', 'Другие товары данного производителя');

// information box text in includes/boxes/information.php
define('BOX_INFORMATION_PRIVACY', 'Безопасность');
define('BOX_INFORMATION_CONDITIONS', 'Условия и гарантии');
define('BOX_INFORMATION_SHIPPING', 'Доставка и возврат');
define('BOX_INFORMATION_CONTACT', 'Свяжитесь с нами');

define('BOX_INFORMATION_PRICE_XLS', 'Прайс-лист (Excel)');
define('BOX_INFORMATION_PRICE_HTML', 'Прайс-лист (HTML)');

// tell a friend box text in includes/boxes/tell_a_friend.php
define('BOX_TELL_A_FRIEND_TEXT', 'Сообщите своим друзьям и близким о нашем магазине');

//BEGIN allprods modification
define('BOX_INFORMATION_ALLPRODS', 'Полный список товаров');
//END allprods modification

// VJ Links Manager v1.00 begin
define('BOX_INFORMATION_LINKS', 'Ссылки');
// VJ Links Manager v1.00 end

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

define('JS_FIRST_NAME', '* Поле \'Имя\' должно содержать не менее ' . ENTRY_FIRST_NAME_MIN_LENGTH . ' символов.\n');
define('JS_LAST_NAME', '* Поле \'Фамилия\' должно содержать не менее ' . ENTRY_LAST_NAME_MIN_LENGTH . ' символов.\n');


define('JS_REVIEW_RATING', '* Вы не указали рейтинг.\n');

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
define('ENTRY_COMPANY_ERROR', '');
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
define('ENTRY_DATE_OF_BIRTH_ERROR', 'Дату рождения необходимо вводить в следующем формате: DD/MM/YYYY (пример 21/05/1970)');
define('ENTRY_DATE_OF_BIRTH_TEXT', '* (пример 21/05/1970)');
define('ENTRY_EMAIL_ADDRESS', 'E-Mail:');
define('ENTRY_EMAIL_ADDRESS_ERROR', 'Поле E-Mail должно содержать как минимум ' . ENTRY_EMAIL_ADDRESS_MIN_LENGTH . ' символов.');
define('ENTRY_EMAIL_ADDRESS_CHECK_ERROR', 'Ваш E-Mail адрес указан неправильно, попробуйте ещё раз.');
define('ENTRY_EMAIL_ADDRESS_ERROR_EXISTS', 'Введённый Вами E-Mail уже зарегистрирован в нашем магазине, попробуйте указать другой E-Mail адрес.');
define('ENTRY_EMAIL_ADDRESS_TEXT', '*');
define('ENTRY_STREET_ADDRESS', 'Адрес:');
define('ENTRY_STREET_ADDRESS_ERROR', 'Поле Улица и номер дома должно содержать как минимум ' . ENTRY_STREET_ADDRESS_MIN_LENGTH . ' символов.');
define('ENTRY_STREET_ADDRESS_TEXT', '* Пример: ул. Мира 346, кв. 78');
define('ENTRY_SUBURB', 'Район:');
define('ENTRY_SUBURB_ERROR', '');
define('ENTRY_SUBURB_TEXT', '');
define('ENTRY_POST_CODE', 'Почтовый индекс:');
define('ENTRY_POST_CODE_ERROR', 'Поле Почтовый индекс должно содержать как минимум ' . ENTRY_POSTCODE_MIN_LENGTH . ' символа.');
define('ENTRY_POST_CODE_TEXT', '*');
define('ENTRY_CITY', 'Город:');
define('ENTRY_CITY_ERROR', 'Поле Город должно содержать как минимум ' . ENTRY_CITY_MIN_LENGTH . ' символа.');
define('ENTRY_CITY_TEXT', '*');
define('ENTRY_STATE', 'Регион:');
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
define('ENTRY_FAX_NUMBER_ERROR', '');
define('ENTRY_FAX_NUMBER_TEXT', '');
define('ENTRY_NEWSLETTER', 'Получать информацию о скидках, призах, подарках:');
define('ENTRY_NEWSLETTER_TEXT', '');
define('ENTRY_NEWSLETTER_YES', 'Подписаться');
define('ENTRY_NEWSLETTER_NO', 'Отказаться от подписки');
define('ENTRY_NEWSLETTER_ERROR', '');
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
define('TEXT_DISPLAY_NUMBER_OF_FEATURED', 'Показано <b>%d</b> - <b>%d</b> (всего <b>%d</b> рекомендуемых товаров)');

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
define('IMAGE_BUTTON_IN_CART', 'Добавить в корзину');
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
define('IMAGE_REDEEM_VOUCHER', 'Применить');

define('SMALL_IMAGE_BUTTON_DELETE', 'Удалить');
define('SMALL_IMAGE_BUTTON_EDIT', 'Изменить');
define('SMALL_IMAGE_BUTTON_VIEW', 'Смотреть');

define('ICON_ARROW_RIGHT', 'Перейти');
define('ICON_CART', 'В корзину');
define('ICON_ERROR', 'Ошибка');
define('ICON_SUCCESS', 'Выполнено');
define('ICON_WARNING', 'Внимание');

define('TEXT_GREETING_PERSONAL', 'Добро пожаловать, <span class="greetUser">%s!</span> Вы хотите посмотреть какие <a href="%s"><u>новые товары</u></a> поступили в наш магазин?');
define('TEXT_CUSTOMER_GREETING_HEADER', 'Добро пожаловать!');
define('TEXT_GREETING_PERSONAL_RELOGON', '<small>Если Вы не %s, пожалуйста, <a href="%s"><u>введите</u></a> свои данные для входа.</small>');
define('TEXT_GREETING_GUEST', 'Добро пожаловать в наш <span class="greetUser">рыболовный интернет-магазин!</span><br> Вы можете купить рыболовные снасти не выходя из дома! Для этого нужно всего лишь выбрать в нужном разделе нашего рыболовного каталога снастей интересующий Вас товар и оформить заказ. Если Вы наш постоянный клиент, <a href="%s"><u>введите Ваши персональные данные</u></a> для входа. Если Вы у нас впервые, Вам необходимо <a href="%s"><u>зарегистрироваться</u></a>, чтобы иметь возможность получать скидки в дальнейшем, но Вы так же можете совершать покупки и без регистрации!<br>
<a href="http://www.youtube.com/user/YourFishru" target="_blank"><center><font size="3" color="#008AD2">ВИДЕООБЗОРЫ СНАСТЕЙ НА НАШЕМ КАНАЛЕ <br> <iframe width="560" height="315" src="https://www.youtube.com/embed/b_nVkPY53LY" frameborder="0" allowfullscreen></iframe></center></font></a>');

define('TEXT_SORT_PRODUCTS', 'Сортировка ');
define('TEXT_DESCENDINGLY', 'по убыванию');
define('TEXT_ASCENDINGLY', 'по возрастанию');
define('TEXT_BY', ', колонка ');

define('TEXT_REVIEW_BY', '- %s');
define('TEXT_REVIEW_WORD_COUNT', '%s слова');
define('TEXT_REVIEW_RATING', 'Рейтинг: %s [%s]');
define('TEXT_REVIEW_DATE_ADDED', 'Дата добавления: %s');
define('TEXT_NO_REVIEWS', 'К настоящему времени нет отзывов, Вы можете стать первым.');

define('TEXT_NO_NEW_PRODUCTS', 'Сегодня нет новых продуктов.');

define('TEXT_NO_PRODUCTS', 'Удачных покупок!');

define('TEXT_UNKNOWN_TAX_RATE', 'Неизвестна налоговая ставка');

define('TEXT_REQUIRED', '<span class="errorText">Обязательно</span>');

// Down For Maintenance
define('TEXT_BEFORE_DOWN_FOR_MAINTENANCE', 'Внимание: Магазин закрыт по техническим причинам до: ');
define('TEXT_ADMIN_DOWN_FOR_MAINTENANCE', 'Внимание: Магазин закрыт по техническим причинам');

define('ERROR_TEP_MAIL', '<font face="Verdana, Arial" size="2" color="#ff0000"><b><small>ОШИБКА:</small> Невозможно отправить email через сервер SMTP. Проверьте, пожалуйста, Ваши установки php.ini и если необходимо, скорректируйте сервер SMTP.</b></font>');
define('WARNING_INSTALL_DIRECTORY_EXISTS', 'Предупреждение: Не удалена директория установки магазина: ' . dirname($_SERVER['SCRIPT_FILENAME']) . '/install. Пожалуйста, удалите эту директорию для безопасности.');
define('WARNING_CONFIG_FILE_WRITEABLE', 'Предупреждение: Файл конфигурации доступен для записи: ' . dirname($_SERVER['SCRIPT_FILENAME']) . '/includes/configure.php. Это - потенциальный риск безопасности - пожалуйста, установите необходимые права доступа к этому файлу.');
define('WARNING_SESSION_DIRECTORY_NON_EXISTENT', 'Предупреждение: директория сессий не существует: ' . tep_session_save_path() . '. Сессии не будут работать пока эта директория не будет создана.');
define('WARNING_SESSION_DIRECTORY_NOT_WRITEABLE', 'Предупреждение: Нет доступа к каталогу сессий: ' . tep_session_save_path() . '. Сессии не будут работать пока не установлены необходимые права доступа.');
define('WARNING_SESSION_AUTO_START', 'Предупреждение: опция session.auto_start включена - пожалуйста, выключите данную опцию в файле php.ini и перезапустите веб-сервер.');
define('WARNING_DOWNLOAD_DIRECTORY_NON_EXISTENT', 'Предупреждение: Директория отсутствует: ' . DIR_FS_DOWNLOAD . '. Создайте директорию.');


define('TEXT_CCVAL_ERROR_INVALID_DATE', 'Вы указали неверную дату истечения срока действия кредитной карточки. Попробуйте ещё раз.');
define('TEXT_CCVAL_ERROR_INVALID_NUMBER', 'Вы указали неверный номер кредитной карточки. Попробуйте ещё раз.');
define('TEXT_CCVAL_ERROR_UNKNOWN_CARD', 'Первые цифры Вашей кредитной карточки: %s Если Вы указали номер своей кредитной карточки правильно, сообщаем Вам, что мы не принимаем к оплате данный тип кредитных карточек. Если Вы указали номер кредитной карточки неверно, попробуйте ещё раз.');

/*
  The following copyright announcement can only be
  appropriately modified or removed if the layout of
  the site theme has been modified to distinguish
  itself from the default Chainreaction-copyrighted
  theme.

  For more information please read the following
  Frequently Asked Questions entry on the osCommerce
  support site:

  http://www.oscommerce.com/community.php/faq,26/q,50

  Please leave this comment intact together with the
  following copyright announcement.
*/
define('FOOTER_TEXT_BODY', '');
require(DIR_WS_LANGUAGES . 'add_ccgvdc_russian.php');
/////////////////////////////////////////////////////////////////////
// HEADER.PHP
// Header Links
define('HEADER_LINKS_DEFAULT','Начало');
define('HEADER_LINKS_WHATS_NEW','Новинки');
define('HEADER_LINKS_SPECIALS','Скидки');
define('HEADER_LINKS_REVIEWS','Отзывы');
define('HEADER_LINKS_LOGIN','Войти');
define('HEADER_LINKS_LOGOFF','Выход');
define('HEADER_LINKS_PRODUCTS_ALL','Каталог');
define('HEADER_LINKS_ACCOUNT_INFO','Ваши данные');
define('HEADER_LINKS_CHECKOUT','Оформить заказ');
define('HEADER_LINKS_CART','Корзина');
define('HEADER_LINKS_DVD', 'Каталог товаров');

/////////////////////////////////////////////////////////////////////

// BOF: Lango added for print order mod
define('IMAGE_BUTTON_PRINT_ORDER', 'Версия для печати');
// EOF: Lango added for print order mod

// WebMakers.com Added: Attributes Sorter
require(DIR_WS_LANGUAGES . $language . '/' . 'attributes_sorter.php');

define('BOX_LOGINBOX_HEADING', 'Вход');
define('BOX_LOGINBOX_EMAIL', 'E-Mail:');
define('BOX_LOGINBOX_PASSWORD', 'Пароль:');
define('IMAGE_BUTTON_LOGIN', 'Войти');

define('BOX_HEADING_LOGIN_BOX_MY_ACCOUNT','Мои данные');
define('LOGIN_BOX_ACCOUNT_EDIT','Изменить данные');
define('LOGIN_BOX_ACCOUNT_HISTORY','История заказов');
define('LOGIN_BOX_ADDRESS_BOOK','Адресная книга');
define('LOGIN_BOX_PRODUCT_NOTIFICATIONS','Уведомления');
define('LOGIN_BOX_MY_ACCOUNT','Мои данные');
define('LOGIN_BOX_LOGOFF','Выход');


// VJ Guestbook for OSC v1.0 begin
define('BOX_INFORMATION_GUESTBOOK', 'Гостевая книга');
// VJ Guestbook for OSC v1.0 end

// VJ Guestbook for OSC v1.0 begin
define('GUESTBOOK_TEXT_MIN_LENGTH', '10'); //[TODO] move to config db table
define('JS_GUESTBOOK_TEXT', '* Поле \'Ваше сообщение\' должно содержать как минимум ' . GUESTBOOK_TEXT_MIN_LENGTH . ' символов.\n');
define('JS_GUESTBOOK_NAME', '* Вы должны заполнить поле \'Ваше имя\'.\n');
// VJ Guestbook for OSC v1.0 end

// VJ Guestbook for OSC v1.0 begin
define('TEXT_DISPLAY_NUMBER_OF_GUESTBOOK_ENTRIES', 'Показано <b>%d</b> - <b>%d</b> (всего <b>%d</b> записей)');
// VJ Guestbook for OSC v1.0 end

// VJ Guestbook for OSC v1.0 begin
define('IMAGE_BUTTON_SIGN_GUESTBOOK', 'Добавить запись');
// VJ Guestbook for OSC v1.0 end

// VJ Guestbook for OSC v1.0 begin
define('TEXT_GUESTBOOK_DATE_ADDED', 'Дата: %s');
define('TEXT_NO_GUESTBOOK_ENTRY', 'Пока нет ни одной записи в гостевой книге. Будьте первыми!');
// VJ Guestbook for OSC v1.0 end

define('DISCOUNT_HEADING', 'Скидки');

define('HELP', 'В связи с загруженностью, для связи доступны только чат WhatsApp и e-mail<br> <b>E-mail</b>:<br><a href="mailto:magazin@yourfish.ru?subject=Ask yourfish" class="tov">magazin@yourfish.ru</a><br><b>WhatsApp:</b><br> <a href=https://wa.me/79262663218> написать в чат </a>');
define('ICQ', '<b>Телефон:</b><br>');
define('TEXT_MORE_INFO', 'Подробнее...');

// Article Manager
define('BOX_ALL_ARTICLES', 'Все статьи');
define('BOX_NEW_ARTICLES', 'Новые статьи');
define('TEXT_DISPLAY_NUMBER_OF_ARTICLES', 'Показано <b>%d</b> - <b>%d</b> (всего <b>%d</b> статей)');
define('TEXT_DISPLAY_NUMBER_OF_ARTICLES_NEW', 'Показано <b>%d</b> - <b>%d</b> (всего <b>%d</b> новых статей)');
define('TABLE_HEADING_AUTHOR', 'Автор');
define('TABLE_HEADING_ABSTRACT', 'Резюме');
define('BOX_HEADING_AUTHORS', 'Авторы статей');
define('NAVBAR_TITLE_DEFAULT', 'Статьи');

define('TABLE_HEADING_INFO','Краткое описание');

//TotalB2B start
define('PRICES_LOGGED_IN_TEXT','Войдите в магазин, чтобы увидеть цены!');
//TotalB2B end

define('PRODUCTS_ORDER_QTY_TEXT','Количество: ');
define('PRODUCTS_ORDER_QTY_MIN_TEXT','<br>' . ' Минимум: ');
define('PRODUCTS_ORDER_QTY_MIN_TEXT_INFO','Минимум единиц для заказа: '); // order_detail.php
define('PRODUCTS_ORDER_QTY_MIN_TEXT_CART','Минимум единиц для заказа: '); // order_detail.php
define('PRODUCTS_ORDER_QTY_MIN_TEXT_CART_SHORT',' Минимум: '); // order_detail.php
define('PRODUCTS_ORDER_QTY_UNIT_TEXT',', Шаг: ');
define('PRODUCTS_ORDER_QTY_UNIT_TEXT_INFO','Шаг: '); // order_detail.php
define('PRODUCTS_ORDER_QTY_UNIT_TEXT_CART','Шаг: '); // order_detail.php
define('PRODUCTS_ORDER_QTY_UNIT_TEXT_CART_SHORT',' Шаг: '); // order_detail.php
define('ERROR_PRODUCTS_QUANTITY_ORDER_MIN_TEXT','');
define('ERROR_PRODUCTS_QUANTITY_INVALID','Вы пытаетесь положить в корзину неверное количество товара: ');
define('ERROR_PRODUCTS_QUANTITY_ORDER_UNITS_TEXT','');
define('ERROR_PRODUCTS_UNITS_INVALID','Вы пытаетесь положить в корзину неверное количество товара: ');

// Poll Box Text
define('_RESULTS', 'Результаты');
define('_VOTE', 'Голосовать');
define('_COMMENTS','Отзывов:');
define('_VOTES', 'Голосов:');
define('_NOPOLLS','Нет опросов');
define('_NOPOLLSCONTENT','На данный момент нет ни одного активного опроса, Вы можете посмотреть результаты всех проводившихся ранее опросов.<br><br><a href="pollbooth.php">['._POLLS.']');

define('IMAGE_BUTTON_PREVIOUS', 'Предыдущий товар');
define('IMAGE_BUTTON_NEXT', 'Следующий товар');
define('IMAGE_BUTTON_RETURN_TO_PRODUCT_LIST', 'Вернуться к списку товаров');
define('PREV_NEXT_PRODUCT', 'Товар ');
define('PREV_NEXT_PRODUCT1', ' из ');
define('PREV_NEXT_CAT', ' категории ');
define('PREV_NEXT_MB', ' производителя ');

define('BOX_TEXT_DOWNLOAD', 'Ваши загрузки: ');
define('BOX_DOWNLOAD_DOWNLOAD', 'Загрузить файлы');
define('BOX_TEXT_DOWNLOAD_NOW', 'Загрузить');

// Русские названия боксов 

define('BOX_HEADING_CATEGORIES', 'Разделы');
define('BOX_HEADING_INFORMATION', 'Информация');
define('BOX_HEADING_TEMPLATE_SELECT', 'Выбор дизайна');
define('BOX_HEADING_MANUFACTURERS', 'Производители');
define('BOX_HEADING_SPECIALS', 'Скидки');
define('BOX_HEADING_NEWSDESK_LATEST', 'Последние новости');
define('BOX_HEADING_SEARCH', 'Поиск');
define('BOX_HEADING_WHATS_NEW', 'Новинки');
define('BOX_HEADING_LANGUAGES', 'Язык');
define('BOX_HEADING_NEWSBOX', 'Новости');
define('BOX_HEADING_FEATURED', 'Рекомендуемые');
define('BOX_HEADING_SHOP_BY_PRICE', 'Сортировка по цене');
define('BOX_HEADING_NEWSDESK_CATEGORIES', 'Новости');
define('BOX_HEADING_ARTICLES', 'Статьи');
define('BOX_HEADING_AUTHORS', 'Авторы');
define('BOX_HEADING_LINKS', 'Обмен ссылками');
define('BOX_HEADING_SHOPPING_CART', 'Корзина');
define('BOX_HEADING_DOWNLOAD', 'Файлы');
define('BOX_HEADING_LOGIN', 'Вход');
define('HELP_HEADING', 'Консультант');
define('BOX_HEADING_WISHLIST', 'Лодки ЛАС');
define('BOX_HEADING_REVIEWS', 'Отзывы');
define('BOX_HEADING_CUSTOMER_ORDERS', 'История заказов');
define('BOX_HEADING_AFFILIATE', 'Заработай с нами');
define('BOX_HEADING_MANUFACTURER_INFO', 'Производитель');
define('BOX_HEADING_BESTSELLERS', 'Лидеры продаж');
define('BOX_HEADING_TELL_A_FRIEND', 'Рассказать другу');
define('BOX_HEADING_NOTIFICATIONS', 'Уведомления');
define('BOX_HEADING_CURRENCIES', 'Прокат байдарок');
define('BOX_HEADING_FAQDESK_CATEGORIES', 'FAQ');
define('BOX_HEADING_FAQDESK_LATEST', 'Последние FAQ');
define('_POLLS', 'Опросы');

// Способы и стоимость доставки в корзине
  define('SHIPPING_OPTIONS', 'Способы и стоимость доставки:');
  if (strstr($PHP_SELF,'shopping_cart.php')) {
    define('SHIPPING_OPTIONS_LOGIN', 'Пожалуйста, <a href="' . tep_href_link(FILENAME_LOGIN, '', 'SSL') . '"><u>войдите</u></a> в магазин, чтобы увидеть точную стоимость доставки Вашего заказа.');
  } else {
    define('SHIPPING_OPTIONS_LOGIN', 'Пожалуйста, войдите в магазин, чтобы увидеть способы и стоимость доставки Вашего заказа.');
  }
  define('SHIPPING_METHOD_TEXT','Способы доставки:');
  define('SHIPPING_METHOD_RATES','Стоимость:');
  define('SHIPPING_METHOD_TO','Адрес доставки: ');
  define('SHIPPING_METHOD_TO_NOLOGIN', 'Адрес доставки: <a href="' . tep_href_link(FILENAME_LOGIN, '', 'SSL') . '"><u>Войдите</u></a>');
  define('SHIPPING_METHOD_FREE_TEXT','Бесплатная доставка');
  define('SHIPPING_METHOD_ALL_DOWNLOADS','- Скачивания');
  define('SHIPPING_METHOD_RECALCULATE','Рассчитать');
  define('SHIPPING_METHOD_ZIP_REQUIRED','true');
  define('SHIPPING_METHOD_ADDRESS','Адрес:');
  define('SHIPPING_METHOD_QTY','Количество товара: ');
  define('SHIPPING_METHOD_WEIGHT','Вес товара: ');
  define('SHIPPING_METHOD_WEIGHT1',' кг.');

  define('LOW_STOCK_TEXT1','Товар на складе заканчивается: ');
  define('LOW_STOCK_TEXT2','Код товара: ');
  define('LOW_STOCK_TEXT3','Текущее количество: ');
  define('LOW_STOCK_TEXT4','Ссылка на товар: ');
  define('LOW_STOCK_TEXT5','Текущее значение переменной Лимит количества товара на складе: ');

// wishlist box text in includes/boxes/wishlist.php
  define('BOX_HEADING_CUSTOMER_WISHLIST', 'Отложенные товары');
  define('TEXT_WISHLIST_COUNT', 'На данный момент отложено товаров: %s.');

  define('BOX_TEXT_VIEW', 'Показать');
  define('BOX_TEXT_HELP', 'Помощь');
  define('BOX_WISHLIST_EMPTY', 'Нет отложенных товаров.');
  define('BOX_TEXT_NO_ITEMS', 'Нет отложенных товаров.');
  define('IMAGE_BUTTON_ADD_WISHLIST', 'Отложить');

  define('TEXT_VERSION', 'Версия сборки: ');
  define('TOTAL_QUERIES', 'Всего запросов: ');
  define('TOTAL_TIME', 'Время исполнения: ');

// otf 1.71 defines needed for Product Option Type feature.
  define('PRODUCTS_OPTIONS_TYPE_SELECT', 0);
  define('PRODUCTS_OPTIONS_TYPE_TEXT', 1);
  define('PRODUCTS_OPTIONS_TYPE_RADIO', 2);
  define('PRODUCTS_OPTIONS_TYPE_CHECKBOX', 3);
  define('PRODUCTS_OPTIONS_TYPE_TEXTAREA', 4);
  define('TEXT_PREFIX', 'txt_');
  define('PRODUCTS_OPTIONS_VALUE_TEXT_ID', 0);  //Must match id for user defined "TEXT" value in db table TABLE_PRODUCTS_OPTIONS_VALUES


//include('includes/languages/english_support.php');
include(DIR_WS_LANGUAGES .$language.'_newsdesk.php');
include(DIR_WS_LANGUAGES .$language.'_faqdesk.php');

define('ENTRY_EXTRA_FIELDS_ERROR','Поле %s должно содержать как минимум %d символов');
define('CATEGORY_EXTRA_FIELDS', 'Дополнительная информация');
define('PRODUCT_EXTRA_FIELDS', 'Дополнительная информация о товаре');

define('TEXT_DISCOUNT', 'Ваша скидка: ');

define('NO_REVIEWS_TEXT', 'На данный момент нет ни одного отзыва.'); 
define('BOX_REVIEWS_HEADER_TEXT', 'Отзывы'); 
define('TEXT_VIEW_ALL_REVIEWS', 'Смотреть все отзывы');

define('ENTRY_CAPTCHA_ERROR', 'Вы неправильно указали код на картинке.');

define('TEXT_PXSELL_ARTICLES', 'Сопутствующие статьи:'); 

define('TEXT_ALL', 'Все'); 

define('TEXT_XSEEL_CART_RECOMMENDED', 'Сопутствующие товары'); 
define('TEXT_XSEEL_CART_UPDATE', 'Чтобы добавить сопутствующий товар в корзину, отметьте товар и нажмите "Обновить"'); 

// Start Products Specifications
// Products Filter box text in includes/boxes/products_filter.php
define('BOX_HEADING_PRODUCTS_FILTER', 'Фильтры');
define('TEXT_SHOW_ALL', 'Показать все');
define('TEXT_FIND_PRODUCTS', 'Найти подходящие товары');
// End Products Specifications

// Products Specifications
define('TEXT_NOT_AVAILABLE', 'нет данных');

define('TEXT_DISPLAY_ALL_PRODUCTS', 'Показать на одной странице');
define('TEXT_DISPLAY_BY_PAGES', 'Разбить на страницы');

define('PIN_NOT_AVAILABLE', 'Товар закончился на складе. Отправлено уведомление на почту.');

// SOCIALS LINK VALUES
define('SOCIAL_VK_A','https://vk.com/yourfish_ru');
define('SOCIAL_VK_TITLE','&nbsp;&nbsp;');
define('SOCIAL_YOUTUBE_A','https://www.youtube.com/user/YourFishru');
define('SOCIAL_YOUTUBE_TITLE','&nbsp;&nbsp;');
define('SOCIAL_TWITTER_A','https://twitter.com/YourFish_ru');
define('SOCIAL_TWITTER_TITLE','&nbsp;&nbsp;');


?>