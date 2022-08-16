<?
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
require __DIR__ . '/vendor/autoload.php';

use Symfony\Component\HttpClient\HttpClient; 
$clientSMS = HttpClient::create(['http_version' => '2.0']); 

$resSMS= $clientSMS->request('POST', 'https://api.pushbullet.com/v2/texts', [
    'headers' => [
        'charset' => 'utf-8',
        'Content-Type' => 'application/json',
        'Access-Token' => 'o.JNYdz8BzzY9PrV40KVQGdfHeUx0IRBr3',
    ],
     'json'=>['data'=>
     [
            'addresses' => ['+79262663218'], //[$buyer->getPhone()],
            'message' => 'Hi, bye',
            'target_device_iden' => 'ujCebCmJMyWsjDSyX6H2tw',
     ] 
     ]
]);
echo 'SMS -OK?200 ='.$statusCode = $resSMS->getStatusCode();
