<?php
require_once __DIR__.'/vendor/autoload.php';
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
use CdekSDK2\BaseTypes;
use Symfony\Component\HttpClient\HttpClient;
use CdekSDK2\Exceptions\RequestException;
use CdekSDK2\BaseTypes\Barcode;
use CdekSDK2\BaseTypes\OrdersList;

$orders=[90493749];
//AUTHORIZE
$client = new \Symfony\Component\HttpClient\Psr18Client();
$cdek = new \CdekSDK2\Client($client);
$cdek->setAccount('yy730tubinej2gmzmovzn48xz43vr5vl');
$cdek->setSecure('qgsp3xueexi94k05mca1hshpyfwdlgon');
$client = HttpClient::create(['http_version' => '2.0']);

$res = $client->request('POST', 'https://api.cdek.ru/v2/oauth/token?parameters', [
    'headers' => [
        'Content-Type' => 'application/x-www-form-urlencoded',
    ],
    'body'=>[
        'client_id' => 'yy730tubinej2gmzmovzn48xz43vr5vl',
        'client_secret'=>'qgsp3xueexi94k05mca1hshpyfwdlgon',
        'grant_type'=>'client_credentials',
    ],
]);

$token1=$res->toArray()['access_token'];

//CHECK REGIONS
foreach ($orders as $order) {

    $res = $client->request('GET', 'https://api.cdek.ru/v2/orders?im_number=102559530', [
        'headers' => [
            'Authorization: Bearer ' . $token1,
        ],
    ]);
    echo '<pre>';
    print_r($res->toArray());
    echo '</pre>';

}