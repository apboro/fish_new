<?php
/*
  $Id: links_submit.php,v 1.00 2003/10/03 Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/

define('NAVBAR_TITLE_1', 'Ссылки');
define('NAVBAR_TITLE_2', 'Добавить ссылку');

define('HEADING_TITLE', 'Добавление ссылки');

define('TEXT_MAIN', 'Заполните данную форму.');

define('EMAIL_SUBJECT', 'Обмен ссылками.');
define('EMAIL_GREET_NONE', 'Уважаемый %s' . "\n\n");
define('EMAIL_WELCOME', 'Спасибо Вам за то, что Вы решили обменяться ссылками с нашим интернет-магазином.' . "\n\n");
define('EMAIL_TEXT', 'Ваша ссылка ссылка успешно добавлена. Она будет доступна для всех посетителей магазина сразу после проверки администратором. Вы получите уведомление о проверке Вашей ссылке.' . "\n\n");
define('EMAIL_CONTACT', 'Если у Вас есть какие-либо вопросы, пишите нам по адресу ' . STORE_OWNER_EMAIL_ADDRESS . '.' . "\n\n");
define('EMAIL_WARNING', '<b>Внимание:</b> Данный email адрес был предоставлен Вам для обмена ссылками. Если у Вас есть вопросы, задавайте их, написав письмо по адресу ' . STORE_OWNER_EMAIL_ADDRESS . '.' . "\n");
define('EMAIL_OWNER_SUBJECT', 'Ссылка успешно добавлена!');
define('EMAIL_OWNER_TEXT', 'Новая ссылка ссылка успешно добавлена, но ещё не проверена администратором. Пожалуйста, проверьте ссылку и сделайте её активной.' . "\n\n");

define('TEXT_LINKS_HELP_LINK', '&nbsp;Помощь&nbsp;[?]');

define('HEADING_LINKS_HELP', 'Помощь');
define('TEXT_LINKS_HELP', '<b>Название сайта:</b> Укажите название Вашего сайта.<br><br><b>URL Адрес:</b> URL адерс Вашего сайта, начиная с \'http://\'.<br><br><b>Раздел:</b> Раздел, который наиболее подходит для Вашего сайта.<br><br><b>Описание:</b> Описание Вашего сайта.<br><br><b>URL Картинки:</b> Адрес баннера Вашего сайта, начиная с \'http://\'. Этот баннер будет показываться при просмотре описание Вашего сайта.<br>Пример адреса: http://your-domain.com/path/to/your/image.gif <br><br><b>Ваше имя:</b> Ваше имя для связи с Вами.<br><br><b>Email:</b> Ваш email адрес. Указывайте, пожалуйста, реальный адрес, он будет использоваться для связи с Вами, в случае возникновения вопросов.<br><br><b>Адрес страницы, где будет стоять наша ссылка:</b> Адрес страницы на Вашем сайте, где Вы разместите нашу ссылка.<br>Пример адреса: http://your-domain.com/path/to/your/links_page.php');
define('TEXT_CLOSE_WINDOW', '<u>Закрыть</u> [x]');

// VJ todo - move to common language file
define('CATEGORY_WEBSITE', 'Информация о сайте');
define('CATEGORY_RECIPROCAL', 'Страница, где будет размещена наша ссылка');

define('ENTRY_LINKS_TITLE', 'Название сайта:');
define('ENTRY_LINKS_TITLE_ERROR', 'Поле Название должно содеражть как минимум ' . ENTRY_LINKS_TITLE_MIN_LENGTH . ' символов.');
define('ENTRY_LINKS_TITLE_TEXT', '*');
define('ENTRY_LINKS_URL', 'URL Адрес:');
define('ENTRY_LINKS_URL_ERROR', 'Поле URL Адрес должно содеражть как минимум ' . ENTRY_LINKS_URL_MIN_LENGTH . ' символов.');
define('ENTRY_LINKS_URL_TEXT', '*');
define('ENTRY_LINKS_CATEGORY', 'Раздел:');
define('ENTRY_LINKS_CATEGORY_TEXT', '*');
define('ENTRY_LINKS_DESCRIPTION', 'Описание:');
define('ENTRY_LINKS_DESCRIPTION_ERROR', 'Поле Описание должно содеражть как минимум ' . ENTRY_LINKS_DESCRIPTION_MIN_LENGTH . ' символов.');
define('ENTRY_LINKS_DESCRIPTION_TEXT', '*');
define('ENTRY_LINKS_IMAGE', 'URL Картинки:');
define('ENTRY_LINKS_IMAGE_TEXT', '');
define('ENTRY_LINKS_CONTACT_NAME', 'Ваше имя:');
define('ENTRY_LINKS_CONTACT_NAME_ERROR', 'Поле Ваше имя должно содеражть как минимум ' . ENTRY_LINKS_CONTACT_NAME_MIN_LENGTH . ' символов.');
define('ENTRY_LINKS_CONTACT_NAME_TEXT', '*');
define('ENTRY_LINKS_RECIPROCAL_URL', 'Адрес страницы, где будет стоять наша ссылка:');
define('ENTRY_LINKS_RECIPROCAL_URL_ERROR', 'Поле Адрес страницы, где будет стоять наша ссылка должно содержать как минимум ' . ENTRY_LINKS_URL_MIN_LENGTH . ' символов.');
define('ENTRY_LINKS_RECIPROCAL_URL_TEXT', '*');

define('ENTRY_CAPTCHA', 'Укажите код на картинке:');

?>