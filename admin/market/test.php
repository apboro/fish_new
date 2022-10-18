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
//    $resMarket = $clientMarket->request('GET', 'https://api.partner.market.yandex.ru/v2/campaigns/22787539/orders/115952063/buyer.json', [
//        'headers' => [
//            'Content-Type' => 'application/json',
//            'Authorization: OAuth oauth_token="AQAAAAABXSvwAAeYsDlscNzd10MlsMeftHYTUNc", oauth_client_id="9f011ee17c414b3194c8853266ba7d27"',
//        ],
//    ]);
//    $order = $resMarket->toArray();
//    var_dump($order['result']['phone']);

//    $cdek = $order['order']['delivery']['outletId'];
//
$resMarket = $clientMarket->request('GET', 'https://api.partner.market.yandex.ru/v2/regions.json?name=Себеж', [
    'headers' => [
        'Content-Type' => 'application/json',
        'Authorization: OAuth oauth_token="AQAAAAABXSvwAAeYsDlscNzd10MlsMeftHYTUNc", oauth_client_id="9f011ee17c414b3194c8853266ba7d27"',
    ],

]);
var_dump($resMarket->toArray());
//$cdek_outlet_id=$resMarket->toArray();
//$cdek_outlet_code = str_replace('CDEK-', '', $cdek_outlet_id['outlet']['shopOutletCode']);


array(1) {
    ["order"]=>
  array(22) {
        ["id"]=>
    int(143634586)
    ["status"]=>
    string(10) "PROCESSING"
        ["substatus"]=>
    string(7) "STARTED"
        ["creationDate"]=>
    string(19) "10-10-2022 20:16:03"
        ["currency"]=>
    string(3) "RUR"
        ["itemsTotal"]=>
    float(8596)
    ["total"]=>
    float(8596)
    ["buyerTotal"]=>
    int(8596)
    ["buyerItemsTotal"]=>
    int(8596)
    ["buyerTotalBeforeDiscount"]=>
    int(9707)
    ["buyerItemsTotalBeforeDiscount"]=>
    int(9658)
    ["deliveryTotal"]=>
    int(0)
    ["subsidyTotal"]=>
    float(49)
    ["totalWithSubsidy"]=>
    float(8645)
    ["paymentType"]=>
    string(7) "PREPAID"
        ["paymentMethod"]=>
    string(6) "YANDEX"
        ["fake"]=>
    bool(false)
    ["items"]=>
    array(1) {
            [0]=>
      array(14) {
                ["id"]=>
        int(217398234)
        ["feedId"]=>
        int(2557774)
        ["offerId"]=>
        string(6) "252381"
                ["feedCategoryId"]=>
        string(4) "1746"
                ["offerName"]=>
        string(46) "Катушка Salmo Elite BAITFEEDER 7 5000BR"
                ["price"]=>
        int(4298)
        ["buyerPrice"]=>
        int(4298)
        ["buyerPriceBeforeDiscount"]=>
        int(4829)
        ["count"]=>
        int(2)
        ["vat"]=>
        string(6) "NO_VAT"
                ["subsidy"]=>
        int(0)
        ["partnerWarehouseId"]=>
        string(36) "99631464-8e9f-40dc-b3a0-d8bb1f6242b2"
                ["promos"]=>
        array(0) {
                }
        ["instances"]=>
        array(2) {
                    [0]=>
          array(0) {
                    }
          [1]=>
          array(0) {
                    }
        }
      }
    }
    ["delivery"]=>
    array(9) {
            ["type"]=>
      string(6) "PICKUP"
            ["serviceName"]=>
      string(18) "Самовывоз"
            ["price"]=>
      int(0)
      ["deliveryPartnerType"]=>
      string(4) "SHOP"
            ["dates"]=>
      array(2) {
                ["fromDate"]=>
        string(10) "24-10-2022"
                ["toDate"]=>
        string(10) "24-10-2022"
      }
      ["region"]=>
      array(4) {
                ["id"]=>
        int(21641)
        ["name"]=>
        string(10) "Лобня"
                ["type"]=>
        string(4) "CITY"
                ["parent"]=>
        array(4) {
                    ["id"]=>
          int(121002)
          ["name"]=>
          string(40) "Городской округ Лобня"
                    ["type"]=>
          string(13) "REPUBLIC_AREA"
                    ["parent"]=>
          array(4) {
                        ["id"]=>
            int(1)
            ["name"]=>
            string(51) "Москва и Московская область"
                        ["type"]=>
            string(8) "REPUBLIC"
                        ["parent"]=>
            array(4) {
                            ["id"]=>
              int(3)
              ["name"]=>
              string(56) "Центральный федеральный округ"
                            ["type"]=>
              string(16) "COUNTRY_DISTRICT"
                            ["parent"]=>
              array(3) {
                                ["id"]=>
                int(225)
                ["name"]=>
                string(12) "Россия"
                                ["type"]=>
                string(7) "COUNTRY"
              }
            }
          }
        }
      }
      ["deliveryServiceId"]=>
      int(99)
      ["dispatchType"]=>
      string(11) "SHOP_OUTLET"
            ["shipments"]=>
      array(1) {
                [0]=>
        array(3) {
                    ["id"]=>
          int(138921506)
          ["shipmentDate"]=>
          string(10) "10-10-2022"
                    ["boxes"]=>
          array(1) {
                        [0]=>
            array(2) {
                            ["id"]=>
              int(249649314)
              ["fulfilmentId"]=>
              string(11) "143634586-1"
            }
          }
        }
      }
    }
    ["buyer"]=>
    array(4) {
            ["id"]=>
      string(24) "3PoPPECqDkTlWK3KrVZFrA=="
            ["lastName"]=>
      string(12) "Костюк"
            ["firstName"]=>
      string(10) "Денис"
            ["type"]=>
      string(6) "PERSON"
    }
    ["notes"]=>
    string(391) "7 ( Микрорайон КАТЮШКИ , от АШАНА одна остановка  ул. Физкультурная 6/Лобненский бульвар  -ледовый каток, Аптека,   в  сторону  детских садиков «Катюша»  и  «Антошка» а также ТЦ «ДИКСИ», ТЦ «БУЛЬВАР», магазин «ПРОДУКТЫ» )"
        ["taxSystem"]=>
    string(14) "USN_MINUS_COST"
  }
}


