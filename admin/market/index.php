<?
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

//connect yourfish db
$host = 'db';
$user = 'root';
$password = 'lHhYoy';
$db_name = 'yourfish';
$link = mysqli_connect($host, $user, $password, $db_name);
mysqli_set_charset($link, "utf8mb4");
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$last_day_orders_query = mysqli_query($link, "SELECT orders_id from orders where date_purchased>NOW() - INTERVAL 14 DAY");
while ($row = mysqli_fetch_assoc($last_day_orders_query)) {
    $last_day_orders[] = $row["orders_id"];
}
//print_r($last_day_orders);
// Указываем авторизационные данные
$clientId = '9f011ee17c414b3194c8853266ba7d27';
$token = 'AQAAAAABXSvwAAeYsDlscNzd10MlsMeftHYTUNc';

// Создаем экземпляр клиента с базовыми методами
$baseClient = new \Yandex\Market\Partner\Clients\BaseClient($clientId, $token);

$OrderProcessingClient = new \Yandex\Market\Partner\Clients\OrderProcessingClient($clientId, $token);

// Магазины возвращаются постранично
$pageNumber = 0;

do {
    $pageNumber++;

    // Получаем страницу заказов с номером pageNumber
    $ordersObject = $OrderProcessingClient->getOrders(22787539, ['page' => $pageNumber,]);
    //var_dump($ordersObject);


    // Получаем итератор по заказам
    $ordersPage = $ordersObject->getOrders(22787539);

    // Получаем количество магазинов на странице
    $ordersCount = $ordersPage->count();

    //get first order
    //print_r($last_day_orders); exit;
    $order = $ordersPage->current();
    for ($i = 0; $i < $ordersCount; $i++) {
        $market_order_number = $order->getId();
         //if ($order->getId()==116908731) {
        if (!in_array($market_order_number, $last_day_orders) and ($order->getStatus() != "CANCELLED")
            and ($order->getStatus()!= "DELIVERED") and ($order->getStatus()!= "PICKUP") and ($order->getStatus()!= "DELIVERY"))
        {
            $market_order = $order;
            $tovars = $order->getItems();
            $tovar = $tovars->current();
            $delivery = $order->getDelivery();
            $address = $delivery->getAddress();
            $buyer = $order->getBuyer();
            $customerName = $buyer->getLastName() . ' ' . $buyer->getFirstName();
            $shipDate = $delivery->getDates()->getToDate();
            $note = '';
            if (count($tovars->getAll()) > 1) $note = 'В заказе БОЛЬШЕ 1 товара';

            if ($delivery->getType() != "PICKUP") {
                $adres_dostavki = $note . ' ' . $address->getCity() . ' ' .  $address->getStreet() . ' ' . $address->getHouse() . ' ' . $address->getApartment() . ' Дата доставки: ' . $shipDate;
            } else {
                $adres_dostavki = $note . ' СДЭК - ' . $delivery->getOutletCode() . ' ' . $delivery->getRegion()->getName() . ' Дата доставки: ' . $shipDate; //. ' outlet '.$punkt->getAddress();
            }
            $date = new DateTime($shipDate);
            $shipDate = $date->format('Y-m-d');
            echo 'TAKING ORDER '. $market_order_number. PHP_EOL;

             $clientMarketForPhone = HttpClient::create(['http_version' => '2.0']);
             $resMarketforPhone = $clientMarketForPhone->request('GET', 'https://api.partner.market.yandex.ru/v2/campaigns/22787539/orders/'.$market_order_number.'/buyer.json', [
                 'headers' => [
                     'Content-Type' => 'application/json',
                     'Authorization: OAuth oauth_token="AQAAAAABXSvwAAeYsDlscNzd10MlsMeftHYTUNc", oauth_client_id="9f011ee17c414b3194c8853266ba7d27"',
                 ],
             ]);
             $orderBuyerInfo = $resMarketforPhone->toArray();
             $buyerPhone=$orderBuyerInfo['result']['phone'];


//            if ($delivery->getType() == "PICKUP") {
//                try {
//                    $clientMarket = HttpClient::create(['http_version' => '2.0']);
//                    $resMarket = $clientMarket->request('GET', 'https://api.partner.market.yandex.ru/v2/campaigns/22787539/orders/' . $market_order->getId() . '.json', [
//                        'headers' => [
//                            'Content-Type' => 'application/json',
//                            'Authorization: OAuth oauth_token="AQAAAAABXSvwAAeYsDlscNzd10MlsMeftHYTUNc", oauth_client_id="9f011ee17c414b3194c8853266ba7d27"',
//                        ],
//                    ]);
//                } catch (RequestException $exception) {
//                    echo $exception->getMessage();
//                }
//                $orderMarketCdek = $resMarket->toArray();
//                $d = $order->getDelivery()->toArray();
//                var_dump($d); exit;
//                $cdekOutletId = $d['data']['outletId'];
//
//                $resMarket = $clientMarket->request('GET', 'https://api.partner.market.yandex.ru/v2/campaigns/22787539/outlets/' . $cdekOutletId . '.json', [
//                    'headers' => [
//                        'Content-Type' => 'application/json',
//                        'Authorization: OAuth oauth_token="AQAAAAABXSvwAAeYsDlscNzd10MlsMeftHYTUNc", oauth_client_id="9f011ee17c414b3194c8853266ba7d27"',
//                    ],
//
//                ]);
//                $cdek_outlet_id = $resMarket->toArray();
//                $cdek_outlet_code = str_replace('CDEK-', '', $cdek_outlet_id['outlet']['shopOutletCode']);
//            }

            //BEGIN CDEK BUILD

            //begin of cdek order class
//            if ($delivery->getType() == "PICKUP") {
//                $orderCdek = BaseTypes\Order::create([
//                    'shipment_point' => 'MSK647',
//                    'delivery_point' => $cdek_outlet_code,
//                    'number' => $market_order->getId(),
//                    'tariff_code' => '136',
//                    'recipient' => BaseTypes\Contact::create([
//                        'name' => $customerName,
//                        'phones' => [
//                            BaseTypes\Phone::create(['number' => $buyerPhone])
//                        ]
//                    ]),
//                    'packages' => [
//                        BaseTypes\Package::create([
//                            'number' => '1',
//                            'weight' => 1000,
//                            'length' => 10,
//                            'width' => 10,
//                            'height' => 10,
//                            'items' => [
//                                BaseTypes\Item::create([
//                                    'name' => $tovar->getOfferName(),
//                                    'ware_key' => $tovar->getOfferId(),
//                                    'payment' => BaseTypes\Money::create(['value' => $market_order->getPaymentType() == "POSTPAID" ? $market_order->getTotal()  : 0]),
//                                    //'payment' => BaseTypes\Money::create(['value' => 0]),
//                                    'cost' => $market_order->getPaymentType() == "POSTPAID" ? $market_order->getTotal()  : 0,
//                                    'weight' => 1000,
//                                    'amount' => 1,
//                                ]),
//                            ]
//                        ])
//                    ],
//                ]);
//            }
            if ($delivery->getType() != "PICKUP") {
                $orderCdek = BaseTypes\Order::create([
                    'shipment_point' => 'MSK647',
                    'number' => $market_order->getId(),
                    'tariff_code' => '137',
                    'recipient' => BaseTypes\Contact::create([
                        'name' => $customerName,
                        'phones' => [
                            BaseTypes\Phone::create(['number' => $buyerPhone])
                        ]
                    ]),
//
                    'to_location' => BaseTypes\Location::create([
                        'code' => 44,
                        'country_code' => 'ru',
                        'address' => $address->getStreet() . ' ' . $address->getHouse() . ' ' . $address->getApartment()
                    ]),

                    'packages' => [
                        BaseTypes\Package::create([
                            'number' => '1',
                            'weight' => 1000,
                            'length' => 10,
                            'width' => 10,
                            'height' => 10,
                            'items' => [
                                BaseTypes\Item::create([
                                    'name' => $tovar->getOfferName(),
                                    'ware_key' => $tovar->getOfferId(),
                                    'payment' => BaseTypes\Money::create(['value' => $market_order->getPaymentType() == "POSTPAID" ? $market_order->getTotal() : 0]),
                                    //'payment' => BaseTypes\Money::create(['value' => 0]),
                                    'cost' => $market_order->getPaymentType() == "POSTPAID" ? $market_order->getTotal() : 0,
                                    'weight' => 1000,
                                    'amount' => 1,
                                ]),
                            ]
                        ])
                    ],
                ]);

//             echo 'Result of adding order:'; PHP_EOL; var_dump($orderCdek);
                try {
                    echo "ADDING ORDER " . $market_order_number . PHP_EOL;
//                    print_r($orderCdek);
//                    exit;
                    $result = $cdek->orders()->add($orderCdek);

                    if ($result->isOk()) {
                        //Запрос успешно выполнился
                        $response_order = $cdek->formatResponse($result, BaseTypes\Order::class);
                        // получаем UUID заказа и сохраняем его
                        $uuid = $response_order->entity->uuid;
                        //echo 'Result of adding order:'; PHP_EOL; var_dump($response_order); exit;
                    }
                    if ($result->hasErrors()) {
                        echo 'Order added to CDEK' . PHP_EOL;
                    }
                } catch (RequestException $exception) {
                    echo $exception->getMessage();
                }


//            getting cdek token
                $client = HttpClient::create(['http_version' => '2.0']);
                $resCdekAuth = $client->request('POST', 'https://api.cdek.ru/v2/oauth/token?parameters', [
                    'headers' => [
                        'Content-Type' => 'application/x-www-form-urlencoded',

                    ],
                    'body' => [
                        'client_id' => 'yy730tubinej2gmzmovzn48xz43vr5vl',
                        'client_secret' => 'qgsp3xueexi94k05mca1hshpyfwdlgon',
                        'grant_type' => 'client_credentials',
                    ],
                ]);
                $token1 = $resCdekAuth->toArray()['access_token'];

                $cdek_number = 0;
                //getting cdek_number
                do {
                    try {
                        $i = 0;
                        echo "GETTING CDEK NUMBER " . $i . PHP_EOL;
                        sleep(5);
                        $resCdekOrdInfo = $client->request('GET', 'https://api.cdek.ru/v2/orders?im_number=' . $market_order->getId(), [
                            'headers' => [
                                'Authorization: Bearer ' . $token1,
                            ],
                        ]);
                        $nakl = $resCdekOrdInfo->toArray();
                        $cdek_number = $nakl['entity']['cdek_number'];
                        echo "CDEK NUMBER IS: ";
                        print_r($cdek_number);
                        echo PHP_EOL;
                    } catch (RequestException $exception) {
                        echo $exception->getMessage();
                    }
                    $i++;
                } while ($cdek_number == 0 and $i < 5);

                //write track code in orders comments
                $cdekSK = mysqli_real_escape_string($link, 'https://lk.cdek.ru/print/print-barcodes?orderId=' . $cdek_number . '&format=A4');


                //request in market for add track code for cdek
                try {
                    $clientMarket = HttpClient::create(['http_version' => '2.0']);
                    $resMarket = $clientMarket->request('POST', 'https://api.partner.market.yandex.ru/v2/campaigns/22787539/orders/' . $market_order->getId() . '/delivery/track.json', [
                        'headers' => [
                            'Content-Type' => 'application/json',
                            'Authorization: OAuth oauth_token="AQAAAAABXSvwAAeYsDlscNzd10MlsMeftHYTUNc", oauth_client_id="9f011ee17c414b3194c8853266ba7d27"',
                        ],
                        'json' => ["trackCode" => $cdek_number, "deliveryServiceId" => 51],
                    ]);
                    echo "Track " . $cdek_number . " add to Market" . PHP_EOL;
                } catch (RequestException $exception) {
                    echo $exception->getMessage();
                }
            }
//            //sms postpaid order
//            if ($market_order->getPaymentType() == "POSTPAID") {
//                $clientSMS = HttpClient::create(['http_version' => '2.0']);
//
//                $resSMS = $clientSMS->request('POST', 'https://api.pushbullet.com/v2/texts', [
//                    'headers' => [
//                        'charset' => 'utf-8',
//                        'Content-Type' => 'application/json',
//                        'Access-Token' => 'o.JNYdz8BzzY9PrV40KVQGdfHeUx0IRBr3',
//                    ],
//                    'json' => [
//                        'data' =>
//                        [
//                            'addresses' => [$buyerPhone],
//                            'message' => 'Zakaz na Yandex.Market nomer ' . $market_order->getId() . ' oformlen i skoro budet otpravlen. Otsledit` posylku - cdek.ru/ru/tracking?order_id=' . $cdek_number,
//                            'target_device_iden' => 'ujCebCmJMyWsjBAT2Rkeey',
//                        ]
//                    ]
//                ]);
//                echo ' SMS -OK?200 =' . $statusCode = $resSMS->getStatusCode();
//            }


            //IMPORT IN YOURFISH
//            try {
                insertCustomer($order->getId(), $customerName, $buyerPhone, $link);
                insertOrder($order->getId(), $customerName, $buyerPhone, $order->getPaymentType(), $shipDate, $link);
                insertOrderProducts($order->getId(), $tovar->getOfferName(), $tovar->getPrice(), $tovar->getCount(), $link);
                insertTotal($order->getId(), $tovar->getPrice(), $delivery->getPrice(), $link);
                insertComment($order->getId(), $order->getNotes(), $adres_dostavki, $link);
                insertComment($market_order->getId(), $cdek_number . ' / Отслеживание - cdek.ru/ru/tracking?order_id=' . $cdek_number, $cdekSK, $link);
//            } catch (Exception $e) {
//                echo $e->getMessage();
//            }
        }
        $order = $ordersPage->next();
    }
    $ordersTotalPages = $ordersObject->getPager()->getPagesCount();
} while ($pageNumber != $ordersTotalPages);

//IMORT IN YOURFISH DB FUNCTIONS
function insertCustomer($orderNumber, $customerName, $customerTel, $link)
{
    mysqli_query($link, "INSERT INTO `customers` (`customers_id`, `customers_gender`, `customers_firstname`, `customers_lastname`, `customers_dob`,
 `customers_email_address`, `customers_default_address_id`, `customers_telephone`, `customers_fax`, `customers_password`,
  `customers_newsletter`, `mmstatus`, `customers_selected_template`, `guest_flag`, `customers_discount`, `customers_groups_id`,
   `customers_status`, `customers_payment_allowed`, `customers_shipment_allowed`, `keep_customers_telephone`, `customers_uuid`)
 VALUES ('" . $orderNumber . "', '', '" . $customerName . "', '', '0000-00-00 00:00:00.000000', '', NULL, '" . $customerTel . "', NULL, '', NULL, '', '', '0', '0.00', '1', '1', '', '', NULL, NULL)");
}

function insertOrder($orderNumber, $customerName, $customerTel, $paymentMethod, $shipDate, $link)
{
    mysqli_query($link, "INSERT INTO `orders` (`orders_id`, `customers_id`, `customers_groups_id`, `customers_name`, `customers_company`,
 `customers_street_address`, `customers_suburb`, `customers_city`, `customers_postcode`, `customers_state`, `customers_country`,
  `customers_telephone`, `customers_email_address`, `customers_address_format_id`, `delivery_name`, `delivery_company`,
   `delivery_street_address`, `delivery_suburb`, `delivery_city`, `delivery_postcode`, `delivery_state`, `delivery_country`,
    `delivery_address_format_id`, `billing_name`, `billing_company`, `billing_street_address`, `billing_suburb`, `billing_city`,
     `billing_postcode`, `billing_state`, `billing_country`, `billing_address_format_id`, `payment_method`, `payment_info`, `cc_type`,
      `cc_owner`, `cc_number`, `cc_expires`, `last_modified`, `date_purchased`, `orders_status`, `orders_date_finished`, `currency`, 
      `currency_value`, `customers_referer_url`, `customers_fax`, `shipping_module`, `SSID`, `addon`, `sber_order`, `meta`)
       VALUES ('" . $orderNumber . "', (200000+ROUND(1 + (RAND() * 9999))), '0', '" . $customerName . "', NULL, '', NULL, '', '', NULL, '', '" . $customerTel . "', '', '0', '', NULL, '', NULL, '', '', NULL, '', '0', '', NULL,
        '', NULL, '', '', NULL, '', '0', '" . $paymentMethod . "', NULL, NULL, NULL, NULL, NULL, NULL, now(), '10', '" . $shipDate . "', 'RUR', '1.0000000', 'Яндекс.Маркет', '', NULL, '', NULL,
         '', '')");
    echo PHP_EOL . "ADDING... Order number " . $orderNumber . " by customer " . $customerName . " with telephone " . $customerTel;
}

function insertOrderProducts($orderNumber, $productsName, $productsPrice, $productsQuantity, $link)
{
    $products_query = mysqli_query($link, "select p.products_id, p.products_model,
   pd.products_name from products_description pd
   join products p
   on p.products_id=pd.products_id
   where products_name='" . $productsName . "'");
    while ($product = mysqli_fetch_assoc($products_query)) {

        mysqli_query($link, "INSERT INTO `orders_products` (`orders_products_id`, `orders_id`, `products_id`, `products_model`,
      `products_name`, `products_price`, `final_price`, `products_tax`, `products_quantity`, `zakaz_price`)
       VALUES (NULL, '" . $orderNumber . "', '" . $product['products_id'] . "', '" . $product['products_model'] . "',
        '" . $product['products_name'] . "',
        '" . $productsPrice . "', '" . $productsPrice . "', '0.0000', '" . $productsQuantity . "','0')");
        echo ' with products ' . $product['products_name'];
        mysqli_query($link, "update products set products_quantity =products_quantity-1
     where products_model='" . $product['products_model'] . "'");
    }
}
function insertTotal($orderNumber, $productsPrice, $deliveryPrice, $link)
{
    mysqli_query($link, "INSERT INTO `orders_total` (`orders_total_id`, `orders_id`, `title`, `text`, `value`, `class`, `sort_order`)
   VALUES (NULL, '" . $orderNumber . "', 'Стоимость товара:', '" . $productsPrice . "', '" . $productsPrice . "', 'ot_subtotal', '1')");
    mysqli_query($link, "INSERT INTO `orders_total` (`orders_total_id`, `orders_id`, `title`, `text`, `value`, `class`, `sort_order`)
   VALUES (NULL, '" . $orderNumber . "', 'Доставка:', '" . $deliveryPrice . "', '" . $deliveryPrice . "', 'ot_shipping', '2')");
    $totalsum = $productsPrice + $deliveryPrice;
    mysqli_query($link, "INSERT INTO `orders_total` (`orders_total_id`, `orders_id`, `title`, `text`, `value`, `class`, `sort_order`)
   VALUES (NULL, '" . $orderNumber . "', 'Всего:', '" . $totalsum . "', '" . $totalsum . "', 'ot_total', '800')");
}

function insertComment($orderNumber, $orderKomment, $orderAdres, $link)
{
    $komment = $orderAdres . '
  ' . $orderKomment;
    mysqli_query($link, "INSERT INTO `orders_status_history` (`orders_status_history_id`, `orders_id`, `orders_status_id`, `date_added`, `customer_notified`, `comments`, `customer_visible`)
   VALUES (NULL, '" . $orderNumber . "', '10', now(), '0', '" . $komment . "', '1')");
}
