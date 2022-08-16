<?php

$ya_pass='zkkbaobbvyltqphl';
	// пример использования SendMailSmtpClass.php

	require_once "SendMailSmtpClass.php"; // подключаем класс
	  
	 $mailSMTP = new SendMailSmtpClass('magazin@yourfish.ru', 'whqnltpltvyiolhj', 'ssl://smtp.yandex.ru', 465, "UTF-8");
	// $mailSMTP = new SendMailSmtpClass('zhenikipatov@yandex.ru', '***', 'ssl://smtp.yandex.ru', 465, "windows-1251");
	// $mailSMTP = new SendMailSmtpClass('monitor.test@mail.ru', '***', 'ssl://smtp.mail.ru', 465, "UTF-8");
	// $mailSMTP = new SendMailSmtpClass('red@mega-dev.ru', '***', 'ssl://smtp.beget.com', 465, "UTF-8");
	// $mailSMTP = new SendMailSmtpClass('red@mega-dev.ru', '***', 'smtp.beget.com', 2525, "windows-1251");
	// $mailSMTP = new SendMailSmtpClass('red@mega-dev.ru', '***', 'ssl://smtp.beget.com', 465, "utf-8");
	//$mailSMTP = new SendMailSmtpClass('magazin@yourfish.ru', '***', 'smtp.beget.com', 2525, "utf-8");
	// $mailSMTP = new SendMailSmtpClass('логин', 'пароль', 'хост', 'порт', 'кодировка письма');
	
	
	// от кого
	$from = array(
		"YOURFISH", // Имя отправителя
		"magazin@yourfish.ru" // почта отправителя
	);
	// кому отправка. Можно указывать несколько получателей через запятую
	$to = 'borodachev@gmail.com';
	
	// добавляем файлы
	$mailSMTP->addFile("test.jpg");
	$mailSMTP->addFile("test2.jpg");
	$mailSMTP->addFile("test3.txt");
	
	// отправляем письмо
	$result =  $mailSMTP->send($to, 'Заказ ИП Рыблов НИ', 'Здравствуйте, примите, пожалуйста, заказ.', $from); 
	// $result =  $mailSMTP->send('Кому письмо', 'Тема письма', 'Текст письма', 'Отправитель письма');
	
	if($result === true){
		echo "Done";
	}else{
		echo "Error: " . $result;
	}
	