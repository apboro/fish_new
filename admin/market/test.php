<?php

/*Сначала получаем заказ с маркета через SDK market
затем с данными из заказа создаем накладную СДЭК
потом записываем заказ в БД ёфиш
Отправляем СМС с треком сдэк заказам с наложкой
*/
date_default_timezone_set('Europe/Moscow');
echo date("d-m-Y H:i:s");
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

require __DIR__ . '/vendor/autoload.php';
$client = new \Symfony\Component\HttpClient\Psr18Client();
$cdek = new \CdekSDK2\Client($client);
$cdek->setAccount('yy730tubinej2gmzmovzn48xz43vr5vl');
$cdek->setSecure('qgsp3xueexi94k05mca1hshpyfwdlgon');

use CdekSDK2\BaseTypes;
use Symfony\Component\HttpClient\HttpClient;
use CdekSDK2\Exceptions\RequestException;
use CdekSDK2\BaseTypes\Barcode;
use CdekSDK2\BaseTypes\OrdersList;
//print_r($last_day_orders);
// Указываем авторизационные данные
$clientId = '9f011ee17c414b3194c8853266ba7d27';
$token = 'AQAAAAABXSvwAAeYsDlscNzd10MlsMeftHYTUNc';

// Создаем экземпляр клиента с базовыми методами
$baseClient = new \Yandex\Market\Partner\Clients\BaseClient($clientId, $token);
$OrderProcessingClient = new \Yandex\Market\Partner\Clients\OrderProcessingClient($clientId, $token);

    $clientMarket = HttpClient::create(['http_version' => '2.0']);
    $resMarket = $clientMarket->request('GET', 'https://api.partner.market.yandex.ru/v2/campaigns/22787539/orders/115952063/buyer.json', [
        'headers' => [
            'Content-Type' => 'application/json',
            'Authorization: OAuth oauth_token="AQAAAAABXSvwAAeYsDlscNzd10MlsMeftHYTUNc", oauth_client_id="9f011ee17c414b3194c8853266ba7d27"',
        ],
    ]);
    $order = $resMarket->toArray();
    var_dump($order['result']['phone']);

//    $cdek = $order['order']['delivery']['outletId'];
//
//$resMarket = $clientMarket->request('GET', 'https://api.partner.market.yandex.ru/v2/campaigns/22787539/outlets/'.$cdek.'.json', [
//    'headers' => [
//        'Content-Type' => 'application/json',
//        'Authorization: OAuth oauth_token="AQAAAAABXSvwAAeYsDlscNzd10MlsMeftHYTUNc", oauth_client_id="9f011ee17c414b3194c8853266ba7d27"',
//    ],
//
//]);
//$cdek_outlet_id=$resMarket->toArray();
//$cdek_outlet_code = str_replace('CDEK-', '', $cdek_outlet_id['outlet']['shopOutletCode']);


