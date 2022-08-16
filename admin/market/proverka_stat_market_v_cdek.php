<?
/*Данный скрипт получает информацию из маркета о заказах
 со статусами в обработке, передан в доставку, лежит в пвз
Проверяет статус этих заказов в СДЭКе и если нужно, меняет статус в маркете.
*/
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
date_default_timezone_set('Europe/Moscow');
echo date("d-m-Y H:i:s") . PHP_EOL;

require __DIR__ . '/vendor/autoload.php';
$client = new \Symfony\Component\HttpClient\Psr18Client();
$cdek = new \CdekSDK2\Client($client);
$cdek->setAccount('yy730tubinej2gmzmovzn48xz43vr5vl');
$cdek->setSecure('qgsp3xueexi94k05mca1hshpyfwdlgon');

use CdekSDK2\BaseTypes;
use Symfony\Component\HttpClient\HttpClient;
use CdekSDK2\Exceptions\RequestException;

$host = 'db';
$user = 'root';
$password = 'lHhYoy';
$db_name = 'yourfish';
$link = mysqli_connect($host, $user, $password, $db_name);
mysqli_set_charset($link, "utf8mb4");
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// Указываем авторизационные данные
$clientId = '9f011ee17c414b3194c8853266ba7d27';
$token = 'AQAAAAABXSvwAAeYsDlscNzd10MlsMeftHYTUNc';

// Создаем экземпляр клиента с базовыми методами
$baseClient = new \Yandex\Market\Partner\Clients\BaseClient($clientId, $token);
$clientCdek = HttpClient::create(['http_version' => '2.0']);
$clientSMS = HttpClient::create(['http_version' => '2.0']);
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

    $order = $ordersPage->current();
    for ($i = 0; $i < $ordersCount; $i++) {
        if ($order->getStatus() == "DELIVERY" or $order->getStatus() == "PICKUP" or $order->getStatus() == "PROCESSING") {
            //if ($order->getId()==106085117) {
            $market_order = $order->getId();
            $delivery = $order->getDelivery();
            $buyer = $order->getBuyer();
            $shipDate = $delivery->getDates()->getToDate();



            //GET CDEK_NUMBER
            $resCdekAuth = $clientCdek->request('POST', 'https://api.cdek.ru/v2/oauth/token?parameters', [
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

            $resCdekOrdInfo = $clientCdek->request('GET', 'https://api.cdek.ru/v2/orders?im_number=' . $market_order, [
                'headers' => [
                    'Authorization: Bearer ' . $token1,
                ],
            ]);

            //echo '<pre>';
            //print_r($resCdekOrdInfo->toArray());
            if ($resCdekOrdInfo == null)
            {
                continue;
            }
            $nakl = $resCdekOrdInfo->toArray();
            $cdekStatus = $nakl['entity']['statuses'][0]['name'];
            $cdekStatusDate = $nakl['entity']['statuses'][0]['date_time'];
            $cdek_number = $nakl['entity']['cdek_number'];
            //echo ">> Cdek Number: ". $nakl['entity']['cdek_number'];

            echo PHP_EOL . 'Заказ номер: ' . $order->getId() . '>>' . $cdekStatus . ' ' . $cdekStatusDate;
            //echo '>>> Status CDEK: '.$nakl['entity']['statuses'][0]['name']. ' Status Market>>>'. $order->getStatus().' Date '.$shipDate;

            if ($cdekStatus != 'Создан' and $order->getStatus() == "PROCESSING"){

                $orderStatus = $OrderProcessingClient->updateOrderStatus(
                    22787539,
                    $market_order,
                    // Информация о заказе. Обязательный параметр
                    [
                        "order" =>
                            [
                                // Новый статус заказа. Обязательный параметр
                                "status" => "DELIVERY",
                                // Причина отмены заказа (для нового статуса CANCELLED). Обязательный параметр
                                "substatus" => ""
                            ]
                    ]
                );
            }
            //change market order status if delivered in cdek
            if ($cdekStatus == 'Принят на склад до востребования' and $delivery->getType() == "PICKUP" and $order->getStatus() != "PICKUP") {
                $orderStatus = $OrderProcessingClient->updateOrderStatus(
                    22787539,
                    $market_order,
                    // Информация о заказе. Обязательный параметр
                    [
                        "order" =>
                        [
                            // Новый статус заказа. Обязательный параметр
                            "status" => "PICKUP",
                            // Причина отмены заказа (для нового статуса CANCELLED). Обязательный параметр
                            "substatus" => ""
                        ]
                    ]
                );
                echo ' МЕНЯЕМ СТАТУС НА "В ПУНКТЕ" ' . $market_order;
            }

            if ($cdekStatus == 'Вручен') {

                $orderStatus = $OrderProcessingClient->updateOrderStatus(
                    22787539,
                    $market_order,
                    // Информация о заказе. Обязательный параметр
                    [
                        "order" =>
                        [
                            // Новый статус заказа. Обязательный параметр
                            "status" => "DELIVERED",
                            // Причина отмены заказа (для нового статуса CANCELLED). Обязательный параметр
                            "substatus" => ""
                        ]
                    ]
                );
                echo ' МЕНЯЕМ СТАТУС НА ДОСТАВЛЕН ' . $market_order;
            }

            //Change market_order status on delivery
            $cdekStatusesArr = [
                "Выдан на отправку в г.-транзите", "Выдан на отправку в г.-отправителе",
                "Сдан перевозчику в г.-отправителе", 'Принят на склад отправителя', "Сдан перевозчику в г.-транзите",
                "Отправлен в г.-транзит", "Встречен в г.-транзите", "Принят на склад транзита"
            ];
            if (($order->getStatus() == "PROCESSING") and (in_array($cdekStatus, $cdekStatusesArr))) {
                $orderStatus = $OrderProcessingClient->updateOrderStatus(
                    22787539,
                    $market_order,
                    // Информация о заказе. Обязательный параметр
                    [
                        "order" =>
                        [
                            // Новый статус заказа. Обязательный параметр
                            "status" => "DELIVERY",
                            // Причина отмены заказа (для нового статуса CANCELLED). Обязательный параметр
                            "substatus" => ""
                        ]
                    ]
                );
                echo ' МЕНЯЕМ СТАТУС НА "ДОСТАВЛЯЕТСЯ" ' . $market_order;
            }

            //sms for postpaid arrived in cdek
            if (($order->getPaymentType() == "POSTPAID") and ($cdekStatus == "Принят на склад до востребования")) {
                $meta_sms_query = mysqli_query($link, "select meta from orders where orders_id=" . $market_order);
                $meta_sms = mysqli_fetch_assoc($meta_sms_query);
                if ($meta_sms['meta'] == '') {
                    $sql = "UPDATE orders SET meta='SMS1' where orders_id=" . $market_order;
                    mysqli_query($link, $sql);
                    $clientSMS = HttpClient::create(['http_version' => '2.0']);
                    $resSMS = $clientSMS->request('POST', 'https://api.pushbullet.com/v2/texts', [
                        'headers' => [
                            'charset' => 'utf-8',
                            'Content-Type' => 'application/json',
                            'Access-Token' => 'o.JNYdz8BzzY9PrV40KVQGdfHeUx0IRBr3',
                        ],
                        'json' => [
                            'data' =>
                            [
                                'addresses' => [$buyer->getPhone()],
                                'message' => 'Zakaz na Yandex.Market nomer ' . $market_order . ' - GOTOV K VYDACHE, poluchenie - cdek.ru/ru/tracking?order_id=' . $cdek_number,
                                'target_device_iden' => 'ujCebCmJMyWsjvEKd3c3P2',
                            ]
                        ]
                    ]);
                    echo ' SMS -OK?200 =' . $statusCode = $resSMS->getStatusCode();
                }
            }
        }

        $order = $ordersPage->next();
    }
    $ordersTotalPages = $ordersObject->getPager()->getPagesCount();
} while ($pageNumber != $ordersTotalPages);
