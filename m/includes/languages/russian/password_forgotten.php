<?php

define('NAVBAR_TITLE_1', 'Вход');
define('NAVBAR_TITLE_2', 'Восстановление пароля');

define('HEADING_TITLE', 'Я забыл свой пароль!');

define('TEXT_MAIN', 'Если Вы забыли свой пароль, введите e-mail адрес, который Вы указывали при регистрации в магазине и мы отправим новый парoль на указанный e-mail.');
define('TEXT_PASSWORD_RESET_INITIATED',TEXT_MAIN);

define('TEXT_NO_EMAIL_ADDRESS_FOUND', '<font color="#ff0000"><b>Ошибка:</b></font> E-Mail адрес не соответствует Вашей учетной записи, попробуйте ещё раз.');

define('EMAIL_PASSWORD_REMINDER_SUBJECT', STORE_NAME . ' - Ваш пароль');
define('EMAIL_PASSWORD_REMINDER_BODY', 'Запрос на получение нового пароля был получен от ' . $_SERVER['REMOTE_ADDR'] . '.' . "\n\n" . 'Ваш новый пароль в \'' . STORE_NAME . '\' :' . "\n\n" . '   %s' . "\n\n");

define('EMAIL_PASSWORD_RESET_SUBJECT',EMAIL_PASSWORD_REMINDER_SUBJECT);
define('EMAIL_PASSWORD_RESET_BODY',EMAIL_PASSWORD_REMINDER_BODY);

define('ERROR_ACTION_RECORDER', 'Ошибка: Пароль был выслан ранее. Пожалуйста повторите через %s минут');
define('SUCCESS_PASSWORD_SENT', 'Выполнено: Ваш новый пароль отправлен Вам по e-mail.');
?>