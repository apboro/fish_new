
<?php
function sendMailAttachment($mailTo, $from, $subject, $message, $file = false){
    $separator = "---"; // разделитель в письме
    // Заголовки для письма
    $headers = "MIME-Version: 1.0\r\n";
    $headers .= "From: $from\nReply-To: $from\n"; // задаем от кого письмо
    $headers .= "Content-Type: multipart/mixed; boundary=\"$separator\""; // в заголовке указываем разделитель
    // если письмо с вложением
    if($file){
        $bodyMail = "--$separator\n"; // начало тела письма, выводим разделитель
        $bodyMail .= "Content-type: text/html; charset='utf-8'\n"; // кодировка письма
        $bodyMail .= "Content-Transfer-Encoding: quoted-printable"; // задаем конвертацию письма
        $bodyMail .= "Content-Disposition: attachment; filename==?utf-8?B?".base64_encode(basename($file))."?=\n\n"; // задаем название файла
        $bodyMail .= $message."\n"; // добавляем текст письма
        $bodyMail .= "--$separator\n";
        $fileRead = fopen($file, "r"); // открываем файл
        $contentFile = fread($fileRead, filesize($file)); // считываем его до конца
        fclose($fileRead); // закрываем файл
        $bodyMail .= "Content-Type: application/octet-stream; name==?utf-8?B?".base64_encode(basename($file))."?=\n"; 
        $bodyMail .= "Content-Transfer-Encoding: base64\n"; // кодировка файла
        $bodyMail .= "Content-Disposition: attachment; filename==?utf-8?B?".base64_encode(basename($file))."?=\n\n";
        $bodyMail .= chunk_split(base64_encode($contentFile))."\n"; // кодируем и прикрепляем файл
        $bodyMail .= "--".$separator ."--\n";
    // письмо без вложения
    }else{
        $bodyMail = $message;
    }
    $result = mail($mailTo, $subject, $bodyMail, $headers); // отправка письма
    return $result;
}
    setlocale(LC_ALL, 'ru_RU.UTF-8');
    //$today = strftime('%d '. mb_convert_encoding('%b','utf-8').' %Y', time());
	$today =strftime('%d %m %Y', strtotime("now"));
	$tomorrow =strftime('%d %m %Y', strtotime("tomorrow"));
	$img = "./dover.jpeg"; // Ссылка на файл
	$font = "./arial.ttf"; // Ссылка на шрифт
	$font_size = 24; // Размер шрифта
	$degree = 0; // Угол поворота текста в градусах
	$textPasp=$_POST['pasp'];
	$textName = $_POST['name']; 
	$email = $_POST['mail'];
	$nomer = rand(1, 9999);
	$pic = imagecreatefromjpeg($img); // Функция создания изображения
	$color = imagecolorallocate($pic, 0, 0, 0); // Функция выделения цвета для текста	
	imagettftext($pic, 18, $degree, 110, 455, $color, $font, $textName); 
	imagettftext($pic, 18, $degree, 110, 500, $color, $font, "Паспорт " .$textPasp); 
	imagettftext($pic, 16, $degree, 640, 195, $color, $font, $today); 
	imagettftext($pic, 16, $degree, 567, 678, $color, $font, $tomorrow); 
	imagettftext($pic, 16, $degree, 445, 150, $color, $font, "№ ". $nomer);        
	imagejpeg($pic, "./doverki/Doverennost-".$nomer.".jpeg"); // Сохранение рисунка
	imagedestroy($pic); // Освобождение памяти и закрытие рисунка
    $r = sendMailAttachment ($email, "magazin@yourfish.ru" , "Доверенность", "Высылаем доверенность", "./doverki/Doverennost-".$nomer.".jpeg");
	echo "Successfully sent!";
?>