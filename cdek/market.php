<?php
include_once("CalculatePriceDeliveryCdek.php");

abstract class Outlet
{
    public $PhoneDetail = '';
    public $WorkTimeY;
}

class CDEKIntegration
{

    /**
     * Режим отладки для уменьшения количества запросов
     * @var boolean
     */
    private $DEBUG = false;

    /**
     * Токен приложения имеющий доступ к API Я.Маркета
     * @var string
     */
    // Колино private $OAUTH_TOKEN = 'AgAAAAAfFcLcAAXZ5lsPBIB2LUTdkC72gSClrSo';
    private $OAUTH_TOKEN = 'AQAAAAABXSvwAAeYsDlscNzd10MlsMeftHYTUNc';

    /**
     * ID приложения имеющий доступ к API Я.Маркета
     * @var string
     */
    // Колино private $OAUTH_CLIENT_ID = 'a0a015512c6743469adcf12d0e4be21d';
    private $OAUTH_CLIENT_ID = '9f011ee17c414b3194c8853266ba7d27';

    /**
     * URL адрес API Я.Маркета
     * @var string
     */
    private $MARKET_API_URL = 'https://api.partner.market.yandex.ru/v2/';


    /**
     * URL адрес API СДЭКа
     * @var string
     */
    private $CDEK_API_URL = 'http://integration.cdek.ru/';

    /**
     * ID магазина в Я.Маркете
     * @var integer
     */
    private $COMPAIGHN_ID = 22787539;


    /**
     * Стоимость доставки по умолчанию
     * @var integer
     */
    private $DELIVERY_COST_DEFAULT = 250;


    /**
     * Стоимость доставки по регионам
     * @var array
     */
    private $DELIVERY_COST = array(
        1 => 250, //Москва
        2 => 250 //СПб
    );

    /**
     * Минимальное количество дней доставки
     *
     *
     *
     * @var integer
     */
    private $MIN_DELIVERY_DAYS = 3;

    /**
     * Максимльное количество дней доставки
     * Для доставки по своему региону разница не должна превышать двух дней.
     * Например, если min-delivery-days равно 1,
     * то для max-delivery-days допускаются значения от 1 до 3.
     * @var integer
     */
    private $MAX_DELIVERY_DAYS = 5;


    /*
     * Данные о точках выдачи со СДЭКа
     * @var null|SimpleXMLElement
     */
    private $importCdekData = null;


    /*
     * Префикс точек выдачи для Я.Маркета. Используется для идентификации точек СДЭКа.
     * @var string
     */
    private $CODE_PREFIX = 'CDEK-';


    /*
     * Список кодов точек выдачи
     * @var array
     */
    private $cdekOutletIds = array();


    /*
     * ID всех точек выдачи СДЭКа с Я.Маркета
     * @var array
     */
    private $yandexCdekOutletIds = array();


    /*
     * Список регионов
     * @var array
     */
    private $regionIds = array();

    public function __construct()
    {

        ini_set('error_reporting', E_ALL);
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        ini_set('memory_limit', '500M');
        set_time_limit(0);
        ini_set('max_execution_time', '0');
        header("Content-type: text/html; charset=UTF-8");
        if ($this->DEBUG) {
            $this->updateOutlets();
        } else {
//            $arr=['CDEK-MSK647'];
//            $outlets=$this->getOutletsByCodes($arr,false);
//
//            $marketOutlets = $this->prepareCdekOutletsToYMatket($outlets);
//            foreach ($marketOutlets as $outlet) {
//                $this->addOutlet(json_encode($outlet));
//            }
            //$this->addOutlet($this->getDemoOutlet());


            $this->removeOutlets();
            $this->updateOutlets();
            $this->addOutlets();


            //$cdeks=$this->getOutletsFromCdek();
            //echo count($cdeks);
            //$this->getCdekPeriod(98);
//            $arr=['CDEK-ZRS1','CDEK-BRN17','CDEK-PTG3','CDEK-SKT3', 'CDEK-CHEL49'];
//            $outlets=$this->getOutletsByCodes($arr,false);
//            $opa=$this->prepareCdekOutletsToYMatket($outlets);
//            echo "<pre>";
//             print_r($opa);
//            foreach ($outlets as $outlet)
//            {
//
//                $CityCodeCdek=$outlet['CityCode'];
//                //echo ' '.$CityCodeCdek;
//                $this->getCdekPeriod($CityCodeCdek);
//                echo '<br>'.$outlet['City'];
//            };
//            echo "</pre>";
//            var_dump($this->request('regions.json', array('name' => 'Себеж')));
//            $this->getRegion('Себеж');
//            $this->prepareAddress('Камызяк', 'Lenina 45', 'Sleva ot pomoiki');
//            $this->getCdekPeriod(44);
        }
    }

    /**
     * Получаем сроки доставки из Москвы
     * @param $CdekCityCode
     */
    private function getCdekPeriod($CdekCityCode)
    {
        $CDEK_UserKey = "1030310ac8a91bc76db4e53e2f7b01e8";
        $CDEK_UserPassword = "013fc3f5c1a2493786efe625416c58dc";
        try {
            $calc = new CalculatePriceDeliveryCdek();
            $calc->setAuth($CDEK_UserKey, $CDEK_UserPassword);
            $calc->setSenderCityId(44);
            $calc->setReceiverCityId($CdekCityCode);
            $calc->addTariffPriority(234, 1);
            $calc->addTariffPriority(136, 2);
//            $calc->setTariffId(136);
            $calc->addGoodsItemBySize(1, 20, 15, 10);

            if ($calc->calculate() === true) {
                $res = $calc->getResult();
//                echo "<pre>";
//                var_dump($calc);
//                echo "</pre>";
//                exit;
                $periodMax = $res['result']['deliveryPeriodMax'];
//                $periodMin = $res['result']['deliveryPeriodMin'];
//                echo '<br>Period ' . $periodMin . ' ' . $periodMax;
            }
        } catch (Exception $e) {
        }
        return $periodMax;
    }


    /**
     * Получаем список регионов из локальной базы
     * @return array Список регионов из Я.Маркета
     */
    private function getYandexRegions()
    {
        if (empty($this->regionIds)) {
            $regionsJson = file_get_contents(dirname(__FILE__) . '/regions.json');
            $this->regionIds = (array)json_decode($regionsJson);
        }
        return $this->regionIds;
    }

    /**
     * Отображает список ошибок от Яндекс Маркета
     * @param array $errors
     */
    private function showError($errors = array())
    {
        $errorMsgs = array('BAD_REQUEST' => 'Не удалось выполнить запрос.',
            'COULD_NOT_FIND_COORDS' => 'По значениям, переданным в теле запроса в параметре address, не удалось определить координаты точки.',
            'DUPLICATE_OUTLET_CODE' => 'В теле запроса в параметре shop-outlet-code передан идентификатор, который присвоен другой точке магазина.',
            'INVALID_EMAIL_FORMAT' => 'В теле запроса в параметре email передан адрес электронной почты, который не соответствует указанному формату.',
            'INVALID_OUTLET_INFO' => 'В теле запроса переданы некорректные данные, например, значение параметра min-delivery-days больше, чем значение max-delivery-days.',
            'INVALID_PHONE_FORMAT' => 'В теле запроса в параметре phone передан телефон, который не соответствует указанному формату.',
            'NOT_SPECIFIED' => 'В теле запроса не указан обязательный параметр.',
            'UNKNOWN_REGION' => 'В теле запроса в параметре region-id указано некорректное значение.',
            'WRONG_OUTLET_GPS_COORDINATES' => 'В теле запроса в параметре coords передано значение, которое не соответствует указанному формату.');
        foreach ($errors as $error) {
            if (isset($errorMsgs[$error->code])) {
                print_r($errorMsgs[$error->code]);
            } else {
                print_r($error);
            }
        }
    }

    /**
     * Точки выдачи со СДЭКа отфильтрованные по кодам
     * @param array $codes - коды для фильтрации
     * @param bool $saveKeys - сохранять id точек выдачи
     * @return array
     */
    private function getOutletsByCodes($codes = array(), $saveKeys = false)
    {
        $outlets = $this->getOutletsFromCdek();
        $outletsResult = array();
        foreach ($outlets as $outlet) {
            $outletCode = $this->CODE_PREFIX . (string)$outlet['Code'];
            if (!$saveKeys) {
                if (in_array($outletCode, $codes)) {
                    $outletsResult[] = $outlet;
                }
            } else {
                if ($code = array_search($outletCode, $codes)) {
                    $outletsResult[$code] = $outlet;
                }
            }
        }
        return $outletsResult;
    }

    /**
     * Обновляем точки выдачи
     */
    private function updateOutlets()
    {
        $yandexCodes = $this->getYandexCdekOutletIds();
        $cdekCodes = $this->getCdekOutletIds();
//        $fp = fopen("yaouts.txt", "a"); // Открываем файл в режиме записи
//        $fp2 = fopen("cdekouts.txt", "a"); // Открываем файл в режиме записи
//        $test = fwrite($fp, $yandexCodes); // Запись в файл      $fp = fopen("yaouts.txt", "a"); // Открываем файл в режиме записи
//        $test2 = fwrite($fp2, $cdekCodes); // Запись в файл
//        exit;

        $outletsCodes = array_intersect($yandexCodes, $cdekCodes);

        $outlets = $this->getOutletsByCodes($outletsCodes, true);

        $marketOutlets = $this->prepareCdekOutletsToYMatket($outlets);
        foreach ($marketOutlets as $id => $outlet) {
            $this->updateOutlet(json_encode($outlet), $id);
//            $fp = fopen("addpunkt.txt", "a"); // Открываем файл в режиме записи
//            $test = fwrite($fp, json_encode($outlet), $id); // Запись в файл      $fp = fopen("yaouts.txt", "a"); // Открываем файл в режиме записи
        }
    }

    /**
     * Тестовые данные о точке выдачи для Яндекс Маркета
     * @return array
     */
    private function getDemoOutlet()
    {
        return array('name' => "На Озёрной Проверка",
            'type' => 'DEPOT',
            'coords' => "20.4522144, 54.7104264",
            'isMain' => false,
            'shopOutletCode' => "419",
            'visibility' => 'VISIBLE',
            'address' => array("regionId" => 1,
                "street" => "ОЗЕРНАЯ",
                "number" => "20А"),
            'phones' => array("+7 (401) 212-22-32 #123"),
            'workingSchedule' => array(
                "workInHoliday" => false,
                "scheduleItems" =>
                    array(
                        array(
                            "startDay" => "MONDAY",
                            "endDay" => "FRIDAY",
                            "startTime" => "09:00",
                            "endTime" => "19:00"
                        ),
                        array(
                            "startDay" => "SATURDAY",
                            "endDay" => "SATURDAY",
                            "startTime" => "10:00",
                            "endTime" => "16:00"
                        )
                    )),
            'deliveryRules' => array(array("cost" => 285,
                "minDeliveryDays" => 19,
                "maxDeliveryDays" => 30,
                "deliveryServiceId" => 100,
                "orderBefore" => 24,
                "priceFreePickup" => 120)),

            "emails" => array("example-shop@yandex.ru")
        );
    }

    /**
     * Добавляем точки выдачи в Яндекс маркет
     */
    private function addOutlets()
    {
        $yandexCodes = $this->getYandexCdekOutletIds();
        $cdekCodes = $this->getCdekOutletIds();
        $diffCodes = array_diff($cdekCodes, $yandexCodes);
        if (empty($diffCodes)) return;
        $outlets = $this->getOutletsByCodes($diffCodes);
        $marketOutlets = $this->prepareCdekOutletsToYMatket($outlets);
        foreach ($marketOutlets as $outlet) {
            $this->addOutlet(json_encode($outlet));
        }
    }


    /**
     * Добавляем точку выдачи в яндекс маркет
     * \[]
     * @param string $outlet - точка выдачы
     * @return mixed - ID точки выдачи в Я.Маркете
     */
    private function addOutlet($outlet = '')
    {
        echo "adding {$outlet}";
        return $this->request('campaigns/' . $this->COMPAIGHN_ID . '/outlets.json', array(), $outlet, 'POST');
    }

    /**
     * Получаем список точек выдачи с Я.Маркета ( Limit 50 )
     * @param int $page - Номер страницы
     * @return mixed
     */
    private function getOutlets($page = 1)
    {
        return $this->request('campaigns/' . $this->COMPAIGHN_ID . '/outlets.json', array('page' => $page));
    }

    /**
     * Получаем список ID всех точек выдачи СДЭКа с кэша Я.Маркета
     * @return array
     */
    private function getDemoYandexCdekOutletsIds()
    {
        $regionsJson = file_get_contents(dirname(__FILE__) . '/outlets.json');
        return (array)json_decode($regionsJson);
    }

    /**
     * Получаем список ID всех точек выдачи СДЭКа с Я.Маркета
     * @return array - Список ID
     */
    private function getYandexCdekOutletIds()
    {
        if ($this->DEBUG) {
            return $this->getDemoYandexCdekOutletsIds();
        }
        if (empty($this->yandexCdekOutletIds)) {
            $page = 0;
            while (true) {
                $page++;
                $outlets = $this->getOutlets($page)->outlets;
                if (empty($outlets)) break;
                foreach ($outlets as $outlet) {
                    if (substr($outlet->shopOutletCode, 0, 5) === $this->CODE_PREFIX) {
                        $this->yandexCdekOutletIds[$outlet->id] = $outlet->shopOutletCode;
                    }
                }
            }
        }

        return $this->yandexCdekOutletIds;
    }

    /**
     * Получаем список Кодов всех точек выдачи со СДЭКа
     * @return array - Список кодов
     */
    private function getCdekOutletIds()
    {
        if (empty($this->cdekOutletIds)) {
            $outlets = $this->getOutletsFromCdek();
            foreach ($outlets as $outlet) {
                $this->cdekOutletIds[] = $this->CODE_PREFIX . (string)$outlet['Code'];
            }
        }
        return $this->cdekOutletIds;
    }


    /**
     * Удаляем все точки выдачи СДЭК с Я.Маркета
     */
    private function removeAllOutlets()
    {
        $yandexIds = $this->getYandexCdekOutletIds();
        foreach ($yandexIds as $id => $code) {
            $this->removeOutlet($id);
        }
    }

    /**
     * Удалить из маркета точки выдачи, которых больше нет в СДЭКе
     */
    private function removeOutlets()
    {
        $yandexIds = $this->getYandexCdekOutletIds();
        $cdekIds = $this->getCdekOutletIds();
        $diffIds = array_diff($yandexIds, $cdekIds);
        foreach ($diffIds as $id => $code) {
            $this->removeOutlet($id);
        }
    }

    /**
     * Запос к API Яндекс маркета
     * @param string $urlPart - url путь
     * @param array $urlParams - GET параметры
     * @param string $body - Тело запроса в формате JSON
     * @param string $type - Тип запроса ( GET, PUT, POST, DELETE )
     * @return mixed - Объект ответа
     */
    private function request($urlPart = '', $urlParams = array(), $body = '', $type = "GET")
    {


        $extendParams = '';
        if (!empty($urlParams)) {
            $extendParams = '?' . http_build_query($urlParams);
        }

        if ($this->DEBUG) {
            return true;
        }

        $s = curl_init();
        $header = array('Authorization: OAuth oauth_token="' . $this->OAUTH_TOKEN . '", oauth_client_id="' . $this->OAUTH_CLIENT_ID . '"',
            'Accept: */*');

        if (in_array($type, array('POST', 'PUT'))) {
            if (!empty($body)) {
                $header[] = 'Content-Type: application/json';
                $header[] = 'Content-Length: ' . strlen($body);
            }
            if ($type === 'POST') {
                curl_setopt($s, CURLOPT_POST, 1);
            }
            curl_setopt($s, CURLOPT_POSTFIELDS, $body);
        }

        if (in_array($type, array('DELETE', 'PUT'))) {
            curl_setopt($s, CURLOPT_CUSTOMREQUEST, $type);
        }

        curl_setopt($s, CURLOPT_HTTPHEADER, $header);
        curl_setopt($s, CURLOPT_URL, $this->MARKET_API_URL . $urlPart . $extendParams);
        curl_setopt($s, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($s, CURLOPT_SSL_VERIFYPEER, false);
        //curl_setopt($s, CURLOPT_VERBOSE, true);
        $resultJSON = curl_exec($s);
        curl_close($s);
        $result = json_decode($resultJSON);

        if (isset($result->status) && $result->status === 'ERROR') {
            $this->showError($result->errors);
            return null;
        }
        return $result;
    }

    /**
     * Обновляем точку выдачи в Я.Маркете
     * @param $outlet - Данные точки выдачи
     * @param int $outletId - ID точки выдачи в Я.Маркете
     * @return mixed
     */
    private function updateOutlet($outlet, $outletId = 0)
    {
        if ($this->DEBUG) {
            echo "Обновили точку выдачи (" . $outletId . ")\r\n";
            return true;
        } else {
            return $this->request('campaigns/' . $this->COMPAIGHN_ID . '/outlets/' . $outletId . '.json', array(), $outlet, 'PUT');
        }
    }

    /**
     * Удаляем точку выдачи в Я.Маркете
     * @param int $outletId - ID точки выдачи в Я.Маркете
     * @return mixed
     */
    private function removeOutlet($outletId)
    {
        return $this->request('campaigns/' . $this->COMPAIGHN_ID . '/outlets/' . $outletId . '.json', array(), '', 'DELETE');
    }


    /**
     * Получаем информацию о регионе по названию
     * @param string $name - Название региона
     * @return mixed
     */
    private function getRegion($name = '')
    {
        return $this->request('regions.json', array('name' => $name));
    }

    /**
     * Получаем список ID регионов с Я.Маркета
     * @param array $regions - Список названий регионов ( Название хранится в ключе. Значение - null)
     * @return array - ID регионов
     */
    private function getRegionIds($regions = array())
    {
        $regionIds = array();
        foreach ($regions as $region => $null) {
            $result = $this->getRegion($region);
            if (!empty($result->regions)) {
                $regionIds[$region] = $result->regions[0]->id;
            }
        }
        return $regionIds;
    }

    /**
     * Получаем список регионо,которых не существует в базе Я.Маркета
     * @param array $regions - Список названий регионов ( Название хранится в ключе. Значение - null)
     * @return array - Список регионов
     */
    private function checkCity($regions = array())
    {
        $empties = array();
        foreach ($regions as $region => $null) {
            $result = $this->getRegion($region);
            if (empty($result->regions)) {
                $empties[] = $region;
            }
        }
        return $empties;
    }

    /**
     * Получаем ID региона из Я.Маркета
     * @param string $region - Регион
     * @return number | null - ID региона
     */
    private function getRegionId($region = '')
    {
        $yandexRegions = $this->getYandexRegions();
        if (!isset($yandexRegions[$region])) {
            $result = $this->getRegion($region);
            if (!empty($result->regions)) {
                $this->regionIds[$region] = $result->regions[0]->id;
            } else {
                return null;
            }
        }
        return $this->regionIds[$region];
    }

    /**
     * Получаем откорректированное название региона
     * <br><i>Необходим в том случае, если данного региона нет в базе Я.Маркета</i>
     * @param string $region - Название региона
     * @return string - Название региона
     */
    private function fixRegion($region = '')
    {
        $replaceCities =
            array('Петергоф (Петродворец)' => 'Петергоф',
                'Химки Новые' => 'Химки',
                'Сколково инновационный центр' => 'Москва',
                'Северный (Москва)' => 'Москва',
                'Воскресенское поселение' => 'Москва',
                'Десеновское' => 'Москва',
                'Мосрентген' => 'Москва');

        if (isset($replaceCities[$region])) {
            return $replaceCities[$region];
        } else {
            return $region;
        }
    }

    /**
     * Получаем откорректированные названия регионов
     * @param array $regions - список регионов ( Названия в ключе, значения - null)
     * @return array - список откорректированных регионов
     */
    private function fixCities($regions = array())
    {
        $fixedRegions = array();
        foreach ($regions as $region => $null) {
            $fixedRegions[$this->fixRegion($region)] = null;
        }

        return $fixedRegions;
    }

    /**
     * Подготавливаем адресс для импорта в Я.Маркет
     * @param string $region - Регион
     * @param string $address - Адрес
     * @param string $comment - Комментарий
     * @return array | null
     */
    private function prepareAddress($region = '', $address = '', $comment = '')
    {
        $regionName = $this->getRegionName($region);
        if (!$regionId = $this->getRegionId($regionName)) {
            return null;
        }
        $addressInfo = $this->parseAddress($address);
        $street = $addressInfo[0];
        $additional = $addressInfo[1];
        $arr = array(
            'regionId' => $regionId,
            'street' => $street,
            'additional' => $additional . ($comment ? ' ( ' . $comment . ' )' : '')
        );
        return $arr;
    }

    /**
     * Парсим адрес из строки
     * @param string $address - Неотформатированный адрес
     * @return array - [ 0 => Улица, 1 => Дополнительная информация ]
     */
    private function parseAddress($address = '')
    {
        $prepareAddress = str_replace(array(' ул', 'ул.  ', 'ул. ', 'ул.'), '', $address);
        $addresses = explode(', ', $prepareAddress, 2);
        return $addresses;
    }

    /**
     * Получаем название региона из неотформатированной строки
     * @param string $region - Регион
     * @return string - Название региона
     */
    private function getRegionName($region = '')
    {
        $name = explode(',', $region);
        if (is_array($name)) {
            $name = $name[0];
        }
        return $this->fixRegion($name);
    }

    /**
     * Преобразуем СДЕК формат телефона в формат для Я.Маркета
     * @param $phone - Номер телефона
     * @return string Отформатированный номер телефона в формате:
     * + код страны (код города) телефон #добавочный.
     * Например, +7 (495) 012-34-56 #789.
     */
    private function preparePhone($phone = '')
    {
        $number = (string)$phone['number'];
        $CountryCode = substr($number, 0, 2);
        $CityCode = substr($number, 2, 3);
        $phoneNumber1 = substr($number, 5, 3);
        $phoneNumber2 = substr($number, 8, 2);
        $phoneNumber3 = substr($number, 10);
        return $CountryCode . ' (' . $CityCode . ') ' . $phoneNumber1 . '-' . $phoneNumber2 . '-' . $phoneNumber3;
    }

    /**
     * Преобразуем СДЕК формат телефонов в формат для Я.Маркета
     * @param $phones - Список номеров телефонов
     * @return array Отформатированнй список номеров телефонов
     */
    private function preparePhones($phones = array())
    {
        $resultPhones = array();
        if (is_array($phones)) {
            foreach ($phones as $phone) {
                $resultPhones[] = $this->preparePhone($phone);
            }
        } else {
            $resultPhones = array($this->preparePhone($phones));
        }
        return $resultPhones;
    }

    /**
     * Преобразуем формат рабочего времения пунктоа выдачи СДЭК в формат для Я.маркета
     * @param array $workTimes - Время работы пункта выдачи
     * @return array Отформатированное время работы пункта выдачи
     */
    private function prepareWorkingSchedule($workTimes = array())
    {
        $scheduleItems = array();
        $dayMap = array(1 => 'MONDAY', 2 => 'TUESDAY', 3 => 'WEDNESDAY',
            4 => 'THURSDAY', 5 => 'FRIDAY', 6 => 'SATURDAY', 7 => 'SUNDAY');

        $groupByTimes = array();
        //Группируем рабочие дни по времени
        foreach ($workTimes as $workTime) {
            $day = (integer)$workTime['day'];
            $times = (string)$workTime['periods'];
            if (!isset($groupByTimes[$times])) {
                $groupByTimes[$times] = array();
            }

            $groupByTimes[$times][] = $day;

        }
        asort($groupByTimes);
        //Форматируем расписание
        foreach ($groupByTimes as $time => $days) {
            sort($days);
            $times = explode('/', $time); //10:00/19:00
            $firstDay = $days[0];
            $lastDay = $days[count($days) - 1];
            if ($times[1] <= $times[0]) {
                $times[1] = "23:59";
            }
            $scheduleItems[] =
                array("startDay" => $dayMap[$firstDay], //'MONDAY'
                    "endDay" => $dayMap[$lastDay],//'MONDAY'
                    "startTime" => $times[0], //10:00
                    "endTime" => $times[1]); //19:00
        }

        return array('workInHoliday' => false,
            'scheduleItems' => $scheduleItems);
    }

    /**
     * Импортруем данные о точка выдачи СДЭК
     * @return null|SimpleXMLElement
     */
    private function getOutletsFromCdek()
    {
        if (!$this->importCdekData) {
            $this->importCdekData = new SimpleXMLElement(file_get_contents($this->CDEK_API_URL . 'pvzlist/v1/xml?countryiso=RU'));//&regionid=19'));//&cityid=98 //countryiso=RUcityid=83247'));
        }
        return $this->importCdekData;
    }

    /**
     * Получаем список регионов из списка точек выдачи
     * @param array $outlets - данные о точках выдачи СДЭК
     * @return array Список регионов
     */
    private function getRegions($outlets = array())
    {
        $regions = array();
        foreach ($outlets as $outlet) {
            $name = (string)$outlet['City'];
            $name = explode(',', $name);
            if (is_array($name)) {
                $name = $name[0];
            }
            $regions[$name] = null;
        };

        return $regions;
    }

    /**
     * Получаем стоимость доставки до региона
     * @param string $region - Регион
     * @return int | null Стоимость доставки
     */
    private function getDeliveryCost($region = '')
    {
        $regionName = $this->getRegionName($region);
        if (!$regionId = $this->getRegionId($regionName)) {
            return $this->DELIVERY_COST_DEFAULT;
        }

        if (isset($this->DELIVERY_COST[$regionId])) {
            return $this->DELIVERY_COST[$regionId];
        }
        return $this->DELIVERY_COST_DEFAULT;
    }

    /**
     * Подготавливаем данные для экспорта точек выдачи СДЭКа в Я.Маркет
     * @param array $outlets - Точки выдачи
     * @return array Точки выдачи для Я.Маркета
     */
    private function prepareCdekOutletsToYMatket($outlets = array())
    {
        $data = array();
        //upal na PRK6 - check it В теле запроса не указан обязательный параметр.
        foreach ($outlets as $key => $outlet) {
            echo PHP_EOL . "Gotovim punkt " . (string)$outlet['Code'] . " in region " . (string)$outlet['RegionName'];
            ($address = $this->prepareAddress((string)$outlet['City'],
                (string)$outlet['Address'],
                (string)$outlet['AddressComment']));// $this->getDeliveryCost((string)$outlet['RegionName'])))
            if ($outlet['CityCode'] == 0) {
                continue;
            }
            /** @var Outlet $outlet */
            $outletArray = (array)$outlet;
            $maxDeliveryDays = $this->getCdekPeriod($outlet['CityCode']);
            $data[$key] = array('name' => 'Пункт выдачи ' . (string)$outlet['Name'],
                'type' => 'DEPOT',
                'coords' => (string)$outlet['coordX'] . ', ' . (string)$outlet['coordY'],
                'isMain' => false,
                'shopOutletCode' => $this->CODE_PREFIX . (string)$outlet['Code'],
                'visibility' => 'VISIBLE',
                'address' => $address,
                'phones' => array('+7 (495) 009-04-05'),
                'workingSchedule' => $this->prepareWorkingSchedule($outletArray['WorkTimeY']),
                'deliveryRules' => array(array("cost" => 240,
                    "minDeliveryDays" => $maxDeliveryDays + 6,
                    "maxDeliveryDays" => $maxDeliveryDays + 8,
                    "deliveryServiceId" => 51, //Сдэк
                    "priceFreePickup" => 3500))
            );
        }

        return $data;
    }

}

new CDEKIntegration();