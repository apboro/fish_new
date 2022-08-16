<?php
//use PHPMailer\PHPMailer;
//use PHPMailer\Exception;
//use PHPMailer\SMTP;
//
//require (__DIR__.'/PHPMailer/Exception.php');
//require (__DIR__.'/PHPMailer/PHPMailer.php');
//require (__DIR__.'/PHPMailer/SMTP.php');

date_default_timezone_set('Europe/Moscow');
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
header("Pragma: no-cache");
error_reporting(E_ALL & ~E_NOTICE);
if (function_exists('ini_get') && (ini_get('register_globals') == false) && (PHP_VERSION < 4.3)) {
    exit('Server Requirement Error: register_globals is disabled in your PHP configuration. This can be enabled in your php.ini configuration file or in the .htaccess file in your catalog directory. Please use PHP 4.3+ if register_globals cannot be enabled on the server.');
}
//require_once(__DIR__ . '/PHPExcel.php');
//require_once(__DIR__ . '/PHPExcel/Writer/Excel2007.php');
//require_once(__DIR__ . '/PHPExcel/IOFactory.php');
//require_once(__DIR__ . '/PHPExcel/Writer/Excel5.php');
//require('includes/application_top.php');
//include('moscan_price_parse.php');
//$moscan_link = Parserlink::create()
//    ->setBaseUrl('http://moscanella.ru')
//    ->setUrl('http://moscanella.ru/Login.aspx')
//    ->setPostData($data)
//    ->send()
//    ->sendNext()
//    ->parse()
//    ->getFullLink();


//скачать бемал для прайсдаты
$datePrice= date('d.m.Y');
$url_bemal = 'https://bemal.ru/price/price_12.04.2022.xls';
$ch = curl_init($url_bemal);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_HEADER, false);
$html = curl_exec($ch);
$curl_res = curl_getinfo($ch);
curl_close($ch);
if ($curl_res['http_code'] != 404) {
    file_put_contents(__DIR__ . '/bemal_ost.xls', $html);
    $bem="Downloaded bemal price on url: ".$url_bemal = 'https://bemal.ru/price/price_'.$datePrice.'.xls';
}
else {
    $datePriceVchera = date('d.m.Y', strtotime("-1 DAY"));
    $url_bemal = 'https://bemal.ru/price/price_'.$datePriceVchera.'.xls';
    $ch = curl_init($url_bemal);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_HEADER, false);
    $html = curl_exec($ch);
    $curl_res = curl_getinfo($ch);
    curl_close($ch);
    if ($curl_res['http_code'] != 404) {
        file_put_contents(__DIR__ . '/bemal_ost.xls', $html);
        $bem="Downloaded bemal price on url: ".$url_bemal = 'https://bemal.ru/price/price_'.$datePriceVchera.'.xls';
    }
}
//mail("borodachev@gmail.com", "прайс бемал", $url_bemal. "response:".$curl_res['http_code'],'from:admin@yourfish.ru');
//echo "mail sent";


// сачать нормарк с прайсдаты
$ch = curl_init('https://ru.pricedata.com/datafeed/uK/15.xls');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_HEADER, false);
$html = curl_exec($ch);
curl_close($ch);
file_put_contents(__DIR__ . '/15.xls', $html);

// сачать бемал с прайсдаты
$ch = curl_init('https://ru.pricedata.com/datafeed/uK/64.xls');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_HEADER, false);
$html = curl_exec($ch);
curl_close($ch);
file_put_contents(__DIR__ . '/64.xls', $html);

//скачать москанеллу для прайсдаты
$ch = curl_init($moscan_link);
$fp = fopen(__DIR__ . '/moscan_download.xls', 'wb');
curl_setopt($ch, CURLOPT_FILE, $fp);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_exec($ch);
curl_close($ch);
fclose($fp);

//скачать москанеллу c прайсдаты
$ch = curl_init('https://ru.pricedata.com/datafeed/uK/21.xls');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_HEADER, false);
$html = curl_exec($ch);
curl_close($ch);
file_put_contents(__DIR__ . '/21.xls', $html);

//скачать грифа
$ch = curl_init('https://ru.pricedata.com/datafeed/uK/17.xls');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_HEADER, false);
$html = curl_exec($ch);
curl_close($ch);
file_put_contents(__DIR__ . '/17.xls', $html);


//скачать Земекс
$ch = curl_init('https://ru.pricedata.com/datafeed/uK/28.xls');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_HEADER, false);
$html = curl_exec($ch);
curl_close($ch);
file_put_contents(__DIR__ . '/28.xls', $html);

//скачать волжанку
$ch = curl_init('https://ru.pricedata.com/datafeed/uK/26.xls');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_HEADER, false);
$html = curl_exec($ch);
curl_close($ch);
file_put_contents(__DIR__ . '/26.xls', $html);

//скачать страйк про
$ch = curl_init('https://ru.pricedata.com/datafeed/uK/47.xls');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_HEADER, false);
$html = curl_exec($ch);
curl_close($ch);
file_put_contents(__DIR__ . '/47.xls', $html);

//скачать фишикет
$ch = curl_init('https://ru.pricedata.com/datafeed/uK/32.xls');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_HEADER, false);
$html = curl_exec($ch);
curl_close($ch);
file_put_contents(__DIR__ . '/32.xls', $html);

//скачать ГРЕТИС 
$ch = curl_init('https://ru.pricedata.com/datafeed/uK/56.xls');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_HEADER, false);
$html = curl_exec($ch);
curl_close($ch);
file_put_contents(__DIR__ . '/56.xls', $html);

//скачать МР
$ch = curl_init('https://ru.pricedata.com/datafeed/uK/20.xls');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_HEADER, false);
$html = curl_exec($ch);
curl_close($ch);
file_put_contents(__DIR__ . '/20.xls', $html);

//скачать Колмик
$ch = curl_init('https://ru.pricedata.com/datafeed/uK/40.xls');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_HEADER, false);
$html = curl_exec($ch);
curl_close($ch);
file_put_contents(__DIR__ . '/40.xls', $html);

//скачать Лотта
$ch = curl_init('https://ru.pricedata.com/datafeed/uK/55.xls');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_HEADER, false);
$html = curl_exec($ch);
curl_close($ch);
file_put_contents(__DIR__ . '/55.xls', $html);

//скачать микадо
$ch = curl_init('https://ru.pricedata.com/datafeed/uK/25.xls');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_HEADER, false);
$html = curl_exec($ch);
curl_close($ch);
file_put_contents(__DIR__ . '/25.xls', $html);

//скачать следопыт
// $ch = curl_init('https://ru.pricedata.com/datafeed/uK/49.xls');
// curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
// curl_setopt($ch, CURLOPT_HEADER, false);
// $html = curl_exec($ch);
// curl_close($ch);
// file_put_contents(__DIR__ . '/49.xls', $html);


//скачать АБЦ 
$ch = curl_init('https://ru.pricedata.com/datafeed/uK/44.xls');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_HEADER, false);
$html = curl_exec($ch);
curl_close($ch);
file_put_contents(__DIR__ . '/44.xls', $html);

//скачать РС
$ch = curl_init('https://salmoru.com/api/xls/getPrice/?data[field]=all&activeOnly');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_HEADER, false);
$html = curl_exec($ch);
curl_close($ch);
file_put_contents(__DIR__ . '/18.xls', $html);
//
//$mail = new PHPMailer(true);
//if (!empty($bem)) {
//    try {
//        //Server settings
//        $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
//        $mail->isSMTP();                                            //Send using SMTP
//        $mail->Host = 'smtp.yandex.com';                     //Set the SMTP server to send through
//        $mail->SMTPAuth = true;                                   //Enable SMTP authentication
//        $mail->Username = 'magazin@yourfish.ru';                     //SMTP username
//        $mail->Password = 'whqnltpltvyiolhj';                               //SMTP password
//        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
//        $mail->Port = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
//
//        //Recipients
//        $mail->setFrom('magazin@yourfish.ru', 'fish');
//        $mail->addAddress('Borodachev@gmail.com', 'Alex Boro');     //Add a recipient
//        //$mail->addAddress('ellen@example.com');               //Name is optional
//        //$mail->addReplyTo('info@example.com', 'Information');
//        //$mail->addCC('cc@example.com');
//        //$mail->addBCC('bcc@example.com');
//
//        //Attachments
//        //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
//        //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name
//
//        //Content
//        $mail->isHTML(true);                                  //Set email format to HTML
//        $mail->Subject = 'Downloaded prices';
//        $mail->Body = $bem;
//        //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
//
//        $mail->send();
//        echo 'Message has been sent';
//    } catch (Exception $e) {
//        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
//    }
//}