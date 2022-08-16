<?php
/*
  $Id: admin_account.php,v 1.2 2003/09/24 13:57:08 wilt Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2002 osCommerce

  Released under the GNU General Public License
*/

define('HEADING_TITLE', 'Администратор');

define('TABLE_HEADING_ACCOUNT', 'Мои данные');

define('TEXT_INFO_FULLNAME', '<b>Имя: </b>');
define('TEXT_INFO_FIRSTNAME', '<b>Имя: </b>');
define('TEXT_INFO_LASTNAME', '<b>Фамилия: </b>');
define('TEXT_INFO_EMAIL', '<b>Email Адрес: </b>');
define('TEXT_INFO_PASSWORD', '<b>Пароль: </b>');
define('TEXT_INFO_PASSWORD_HIDDEN', '-Скрыт-');
define('TEXT_INFO_PASSWORD_CONFIRM', '<b>Подтвердите пароль: </b>');
define('TEXT_INFO_CREATED', '<b>Запись создана: </b>');
define('TEXT_INFO_LOGDATE', '<b>Последний вход: </b>');
define('TEXT_INFO_LOGNUM', '<b>Количество входов: </b>');
define('TEXT_INFO_GROUP', '<b>Группа: </b>');
define('TEXT_INFO_ERROR', '<font color="red">Данный Email адрес уже зарегистрирован! Попробуйте ещё раз.</font>');
define('TEXT_INFO_MODIFIED', 'Последние изменения: ');

define('TEXT_INFO_HEADING_DEFAULT', 'Изменить данные ');
define('TEXT_INFO_HEADING_CONFIRM_PASSWORD', 'Введите пароль ');
define('TEXT_INFO_INTRO_CONFIRM_PASSWORD', 'Пароль:');
define('TEXT_INFO_INTRO_CONFIRM_PASSWORD_ERROR', '<font color="red"><b>ОШИБКА:</b> неверный пароль!</font>');
define('TEXT_INFO_INTRO_DEFAULT', 'Нажмите кнопку <b>изменить</b> для редактирования данных.');
define('TEXT_INFO_INTRO_DEFAULT_FIRST_TIME', '');
define('TEXT_INFO_INTRO_DEFAULT_FIRST', '<br><b>ВНИМАНИЕ:</b><br>Здравствуйте, <b>%s</b>, мы рекомендуем Вам изменить email адрес (<font color="red">admin@localhost</font>) и пароль!');
define('TEXT_INFO_INTRO_EDIT_PROCESS', 'Все поля формы обязательны для заполнения. Нажмите кнопку "сохранить" для сохранения внесённых изменений.');

define('JS_ALERT_FIRSTNAME',        '- Вы не указали своё Имя. \n');
define('JS_ALERT_LASTNAME',         '- Вы не указали свою Фамилию. \n');
define('JS_ALERT_EMAIL',            '- Вы не указали свой Email адрес. \n');
define('JS_ALERT_PASSWORD',         '- Вы не указали свой Пароль. \n');
define('JS_ALERT_FIRSTNAME_LENGTH', '- Поле Имя должно содержать как минимум символов: ');
define('JS_ALERT_LASTNAME_LENGTH',  '- Поле Фамилия должно содержать как минимум символов: ');
define('JS_ALERT_PASSWORD_LENGTH',  '- Поле Пароль должно содержать как минимум символов: ');
define('JS_ALERT_EMAIL_FORMAT',     '- Вы неправильно написали Email адрес! \n');
define('JS_ALERT_EMAIL_USED',       '- Введённый Email адрес уже зарегистрирован! \n');
define('JS_ALERT_PASSWORD_CONFIRM', '- Вы не ввели пароль в поле Подтвердите пароль! \n');

define('ADMIN_EMAIL_SUBJECT', 'Ваши данные изменены!');
define('ADMIN_EMAIL_TEXT', 'Здравствуйте, %s!' . "\n\n" . 'Ваша информация успешно изменена. Если Вы не изменяли свою информацию, обязательно свяжитесь с администратором, возможно, кто-то пытается получить доступ к Вашей информации!!' . "\n\n" . 'Сайт: %s' . "\n" . 'Email: %s' . "\n" . 'Пароль: %s' . "\n\n" . 'Спасибо!' . "\n" . '%s' . "\n\n" . 'Это письмо отправлено автоматически, не нужно на него отвечать!'); 
?>
