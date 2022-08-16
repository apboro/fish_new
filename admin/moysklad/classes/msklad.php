<?php
define('DO_LOG_BODY',false);//----Если установлена переменная, то все запросы на обновление будут сохранены в body.bin файле кеша
define('MySklad_STR',240);//Длина строки на МоемСкладе. до 255.
define('PREFIX_CAT','C');
define('PREFIX_PROD','');
define('STOCK_FILE','stock.xls');
define('ENABLE_DROP_ALL',false);
define('MAX_LOOP',5);
define('DROP_DOUBLES',false);
define('ENABLE_DELETE_GOOD',false);
define('READONLY',true);
define('MAXQUERY',1000);

/*функции загрушки, если не унаследованы с nhp.php*/
if (!function_exists('LogIt')){function LogIt($s){};}
if (!function_exists('LogItColor')){function LogItColor($color,$s){};}
if (!function_exists('SafeExit')){function SafeExit($s){exit;};}
if (!function_exists('LogItErr')){function LogItErr($s){};}
if (!function_exists('tep_db_query_my')){
    function tep_db_query_my($query, $link = 'db_link'){
        $qry=tep_db_query('set names utf8');
	return tep_db_query($query,$link);
	};
    }


if (!function_exists('hex2bin')) {
    function hex2bin($data) {
        static $old;
        if ($old === null) {
            $old = version_compare(PHP_VERSION, '5.2', '<');
        }
        $isobj = false;
        if (is_scalar($data) || (($isobj = is_object($data)) && method_exists($data, '__toString'))) {
            if ($isobj && $old) {
                ob_start();
                echo $data;
                $data = ob_get_clean();
            }
            else {
                $data = (string) $data;
            }
        }
        else {
            trigger_error(__FUNCTION__.'() expects parameter 1 to be string, ' . gettype($data) . ' given', E_USER_WARNING);
            return;//null in this case
        }
        $len = strlen($data);
        if ($len % 2) {
            trigger_error(__FUNCTION__.'(): Hexadecimal input string must have an even length', E_USER_WARNING);
            return false;
        }
        if (strspn($data, '0123456789abcdefABCDEF') != $len) {
            trigger_error(__FUNCTION__.'(): Input string must be hexadecimal string', E_USER_WARNING);
            return false;
        }
        return pack('H*', $data);
    }
}
function CleanupBadSymbols($item){
//----patch by iHolder remove C2A0 symbol from link---
$hex = bin2hex($item);
$_item = str_replace('c2a0', '20', $hex);
$_item = str_replace('73e2', '', $_item);
$_item = str_replace('8093', '', $_item);
return hex2bin($_item);
//--endpatch
}



class QueryDump{
    protected $filename;
    protected $FW;
    protected $line;
    protected $header;
    protected $footer;
    function __construct($filename,$unlink=true){
	if (file_exists($filename)){if ($unlink){unlink($filename);}}
	$this->filename=$filename;
	$this->line='';
	$this->header='<?xml version="1.0" encoding="UTF-8" ?><collection>'."\n";
	$this->footer='</collection>'."\n";
	$FW=fopen($filename,'a+');
	if (!is_resource($FW)){return false;}
	$this->FW=$FW;
	}
    function reset(){$this->line='';if (file_exists($this->filename)){unlink($this->filename);}}
    function add($line){$line=preg_replace('|[\n\r]|','',$line);$this->line.=$line."\n";}
    function save(){if (is_resource($this->FW)){fputs($this->FW,$this->line);$this->line='';}}
    function reopen(){
	if (is_resource($this->FW)){fclose($this->FW);}
	    $this->FW=fopen($this->filename,'r');
	    if (!is_resource($this->FW)){SafeExit('Error QueryDump open file');}
	    }
    function __destruct() {if (is_resource($this->FW)){fclose($this->FW);};
	//$this->reset();
	}
    function get($count=100){
	$line=$this->header;
	for ($i=0;$i<$count;$i++){$line.=fgets($this->FW);if (feof($this->FW)){break;}}
	return $line.$this->footer;
	}
    function eof(){return feof($this->FW);}
}

/*функции загрушки, если не унаследованы с hph.php*/
class MySklad {
  protected $MAXQUERY=MAXQUERY;//----максимальное кличество элементов в запросе на склад. Ограничено 1000
  protected $username;
  protected $password;
  protected $cache;  
  private $dictionary;
  private $settings_file;
  private $categories;
  private $products;
  private $customers;
  private $orders;
  private $states;
  private $delivery_states;
  private $company;
  private $settings;
  private $CompanyLine;
  private $PriceType;
  private $CacheChecked;
  private $products_options;
  private $exclude_options;
  private $start_time;
  private $query_count;
  private $delivery_names;
  private $PurchaseOrder;
  private $EmailName;
  private $EmailFrom;
  private $dostavka_method;
  private $dostavka_company;
  private $manufacture;
  private $body;
  private $count;
  private $reserve;
  private $stock;
  private $loop;
  private $barcode;
  private $bar;
  private $uuidtocategories;
  private $thisdate;
  private $storedir;
  private $logdir;
function MySklad($cache_name=__FILE__){
    if (!function_exists('simplexml_load_string')){LogItErr('Simple XML not found!');}
//    $this->dictionary=array('Good','GoodFolder','Company','CustomerOrder','Workflow','MyCompany','PriceType','PurchaseOrder','Metadata','Stock','Consignment');
    $this->thisdate=date('j.m.Y-H:i:s');
    $this->dictionary=array('Good','Company','MyCompany','PriceType','Metadata','Stock');
    $this->reserve=array('set'=>array(10,13,3),'clear'=>array(6));
    $this->loop=0;
    //------все справочники, которые нужно загружать.
    $this->cache=dirname($cache_name).'/../tmp';
    $this->storedir=dirname($cache_name).'/../store';
    $this->logdir=dirname($cache_name).'/../log';
    if (!file_exists($this->storedir)){@mkdir($this->storedir,0755);}
    $this->CacheChecked=false;
    $this->start_time = time();
    file_put_contents(__DIR__.'/time.bin',$this->start_time);
    $this->EmailName=$this->sEncode(STORE_OWNER);//----НА кого(имя)слать заказы поставщикам
    $this->EmailFrom=$this->sEncode(STORE_OWNER_EMAIL_ADDRESS);//----Куда слать заказы поставщикам
    $this->settings_file=$this->cache.'/settings.bin';
    $this->LoadSettings();
    if (isset($this->settings)){
    $this->username=$this->settings['login']['username'];
    $this->password=$this->settings['login']['password'];
    if (is_array($this->settings['company'])){
	if (!isset($this->settings['company']['accountUuid'])){
	if (sizeof($this->settings['company'])==1){
	    $this->settings['company']=end($this->settings['company']);
	    }else{
		SafeExit('Несколько компаний. Выберите пожалуйста');
		}
	    }
	}
//    if (!isset($this->settings['company']['accountUuid'])){}
    $this->CompanyLine='<accountUuid>'.$this->settings['company']['accountUuid'].'</accountUuid>
		    <accountId>'.$this->settings['company']['accountId'].'</accountId>
		    <groupUuid>'.$this->settings['company']['groupUuid'].'</groupUuid>';
    }
}

/*функция выводит результаты дампа в лог. Иногда нужно*/
private function InternalDebug($arr){
ob_start();
if (is_array($arr)){echo '<pre>';var_dump($arr);echo '</pre>';}
else{echo $arr;}
$output=ob_get_clean();
echo $this->sDecode($output);
}
/*Функция вывода в лог тела запроса*/
private function LogBody($body){
    if (DO_LOG_BODY){
    LogIt('Log query body');
	$FW=fopen($this->cache.'/body.bin','a');
	if (is_resource($FW)){
	    fputs($FW,$body."\n");
	    fclose($FW);
	    }
	}
    }
/*Сохранение установок*/
private function SaveSettings(){
    LogIt('Save settings');
    if (isset($this->settings)){
	file_put_contents($this->settings_file,serialize($this->settings));
	}
    }
/*загружка установок*/
private function LoadSettings(){
    if (file_exists($this->settings_file)){
	$this->settings=unserialize(file_get_contents($this->settings_file));
    }
}
/*установка настройки в определенное значение*/
public function SetSettings($key,$value){
    if (!isset($this->settings)){
	$this->LoadSettings();
	}
    try{
    $data=$this->sEncode(var_export($value,true));
    eval('$data='.$data.';');
    $this->settings[$key]=$data;
    if ($key=='login')
	{
	$this->username=$data['username'];
	$this->password=$data['password'];	
	}
    $this->SaveSettings();
    }catch(Exception $e){SafeExit($e->getMessage());}
    }
/*получение массива настроек*/
public function GetSettings(){
    if (isset($this->settings)){
	return $this->Recode($this->settings);}
	    else{return false;}
    }
/*перекодирование данных из одного формата в другой*/
private function Recode($data){
      $data=$this->sDecode(var_export($data,true));
      eval('$data='.$data.';');
      return $data;
    }





/*получение имен компании для интерфейса*/
public function GetCompanyNames(){
$xml=$this->LoadFromCache('MyCompany');
if ($xml===false){return false;}
if (!isset($this->settings['connected'])){
	$this->SetSettings('connected','true');
	}
$C=array();
    if (is_object($xml)){
	foreach ($xml->children() as $element){
	$name=(string)$element->attributes()->name[0];
	$C[$name]=array(
	    'name'=>(string)$element->attributes()->name[0],
	    'accountUuid'=>(string)$element->accountUuid,
	    'groupUuid'=>(string)$element->groupUuid,
	    'accountId'=>(string)$element->accountId,
	    'uuid'=>(string)$element->uuid
	    );
	}
    }
$this->company=$C;
if (sizeof($C)==1){
    $test_company=end($C);
    if ($this->settings['company']['uuid']!==$test_company['uuid']){
	$this->SetSettings('company',$C);
	}
    }
return $this->Recode($C);
}

//определение идентификаторов метода оплаты,заказа по-умолчанию, компаний для доставки со склада
private function BuildPriceType(){
if (isset($this->PriceType)&&
    isset($this->barcode)
//    isset($this->manufacture)
    ){return;}
$xml=$this->LoadFromCache('PriceType');    
if ($xml===false){return false;}
if (is_object($xml)){
	foreach ($xml->children() as $element){
        if ($element->attributes()->name[0]==$this->sEncode('Цена продажи')){
	    $this->PriceType=(string)$element->uuid;break;
    	    }
	}
    }
unset($xml);

$xml=$this->LoadFromCache('Metadata');
if ($xml===false){return false;}
if (is_object($xml)){
	foreach ($xml->children() as $element){
        if ($element->attributes()->name[0]==$this->sEncode('GoodFolder')){
	    foreach($element->attributeMetadata as $child){
/*		 if ($child->attributes()->name[0]==$this->sEncode('Производитель товара')){
		    $this->manufacture=(string)$child->uuid;
		    LogIt('Определено поле производителя товара');
		    }*/
		 if ($child->attributes()->name[0]==$this->sEncode('Штрихкод')){
		    $this->barcode=(string)$child->uuid;
		    LogIt('Определено поле штрихкода');
		    }

		    
	    }
        }

	}
    }
unset($xml);

}

/*вывод в лог результатов проверки синхронизации*/
private function ExplainDry($dry){
/*    $str=sprintf("На складе:%s В магазине:%s Удалить:%s Обновить:%s Добавить:%s",
		$dry['sklad'],$dry['shop'],$dry['todo']['delete'],
		$dry['todo']['update'],$dry['todo']['insert']
		);
	LogIt($str);*/
        }



/*построение схемы товаров в магазине*/
private function BuildProducts(){}

/*синхронизация склада*/
public function SyncStock($dryrun=true){
//if (READONLY){LogIt('Только чтение!');return;}
LogIt('Определение остатков со склада');
$this->LoadCache(array('Stock'),true);
if (!$dryrun){$store=array();}
if (isset($this->stock)){unset($this->stock);}
$qry=tep_db_query_my('select products_model,concat("'.PREFIX_PROD.'",products_id) as products_id,products_quantity 
    from products where length(products_model)>0');
if ($qry!==false){
    while ($res=tep_db_fetch_array($qry)){
	$shop[$res['products_model'].':'.$res['products_id']]=$res['products_quantity'];
	}
    }
$file_cache=$this->cache.'/Stock.xml';
@unlink($file_cache);
$xml=$this->LoadFromCache('Stock');
$update_count=0;
$to_update=0;
$todo=array();
if ($xml===false){return false;}
if (is_object($xml)){
	foreach ($xml->children() as $element){
	    $model=trim((string)$element->attributes()->productCode[0]);
	    $pid=tep_get_prid((string)$element->goodRef->attributes()->code[0]);
	    $code=$model.':'.$pid;
	    if ((strlen($model)==0)&&(strlen($pid)==0)){continue;}
//	    LogIt('Проверка:'.$code.'<'.$shop[$code].'>'.'<'.$qty.'>');
	    if (!isset($shop[$code])){continue;}
	    $qty=(float)$element->attributes()->quantity[0];
	    if (((float)$shop[$code]==9999)&&($qty==0)){continue;}
	    if ((float)$shop[$code]!=$qty){
    	    LogIt('Отличие: ('.$code.')! В магазине:'.$shop[$code].' на складе '.$qty);
	    $to_update++;

	    if (!$dryrun){
   	        $store[$code]=$shop[$code];
		$update_count++;
		if ($qty==0){$qty=9999;}

//		$pid=preg_replace('|[^\d]|','',$code);
		$todo[$code]=$qty;
/*		$upd_query='update products set products_quantity='.$qty.
			' where ';*/
/*		if (isset($where)){unset($where);}
		if (strlen($model)>0){$where[]=' products_model="'.tep_db_input($model).'"';}
		if (strlen($pid)>0){$where[]=' products_id="'.tep_db_input($pid).'"';}
		$upd_query.=implode(' and ',$where);*/
/*		$upd_query.=' products_model="'.tep_db_input($model).'" and '.
			' products_id="'.tep_db_input($pid).'"';*/
//		LogIt($upd_query);
/*		try{
//		$upd=tep_db_query_my($upd_query);
		}catch(Exception $e){LogIt($e->getMessage());}
*/	    	}
	    $STOCK[$code]=$shop[$code];
	}
    }
}
unset($xml);
if (!$dryrun){
    if (sizeof($store)>0){file_put_contents($this->storedir.'/qty'.$this->thisdate,serialize($store));}
    if (sizeof($todo)>0){
	foreach  ($todo as $code=>$qty){
	    $arr=explode(':',$code);
	    $model=$arr[0];
	    $pid=$arr[1];
   	    LogIt('Обновляем ('.$code.')! В магазине:'.$shop[$code].' -> '.$qty);
		$upd_query='update products set products_quantity='.$qty.
			' where  products_model="'.tep_db_input($model).'" and ' .
			' products_id="'.tep_db_input($pid).'"';
		try{
		$upd=tep_db_query_my($upd_query);
		}catch(Exception $e){LogIt($e->getMessage());}
	    }
	}
    }
$this->stock=$STOCK;
LogIt('Нужно обновить:'.$to_update);
LogIt('Обновлено:'.$update_count);
}

/*синхронизация товаров*/
public function SyncProducts($dryrun=true){}


/*очистка строк от спецсимволов. Можно дополнять*/
private function StringCleanup($str){
    $str=CleanupBadSymbols($str);
    $str = iconv("UTF-8", "UTF-8//IGNORE", $str);
    return trim(preg_replace('|[\n\r\t\"\'\&]|','',strip_tags($str)));
    }

private function AssignCategoriesID(){ }
/*построение дерева каталогов товара*/
private function BuildCategories(){}

/*Синхронизация категорий товара*/
public function SyncCategories($dryrun=true){}



/*загрузка товаров из кеша для заданного сервиса (передается массив)*/
private function LoadFromCache($service){
    $file_cache=$this->cache.'/'.$service.'.xml';
    $this->LoadCache(array($service));
    if (!file_exists($file_cache)){$this->LoadCache(array($service),true);}
    if (file_exists($file_cache)){
	return $this->loadXML(file_get_contents($file_cache));
	}else{LogIt('Не удалось загрузить со склада '.$service);return false;}
    }

/*Функция делаем сам по себе запрос данных со склада. Можно делать принудительную загрузку*/
private function LoadCache($data='',$force=false){
    if (!is_array($data)){$data=$this->dictionary;}
    LogIt("Загрузка данных со склада:".implode(',',$data).($force?' Принудительно ':''));
    $cache=$this->cache;
    if (!file_exists($cache)){mkdir($cache,true,0755);}
    foreach($data as $key){
	$file_cache=$cache.'/'.$key.'.xml';
        if ($force) {
            if (file_exists($file_cache)) {
                @unlink($file_cache);
                if (file_exists($file_cache)) {
                    SafeExit('Файл кеша ' . $key . 'не был удален');
                }
            }
        }
        if (!isset($_REQUEST['action']) && file_exists($file_cache)) {
            $data = stat($file_cache);
            $time_str = date('YmdHis', $data['mtime']);
            $ret = $this->query($key, 'list', '', 'filter=updated%3E' . $time_str);
            $code = $this->Join($key, $ret);
            if ($code == true) {
                continue;
            }
        } else {
            $ans = $this->query($key);
            if ($ans !== false) {
                file_put_contents($file_cache, $ans);
                return true;
            }
        }

    }
    return false;

}
/*сохранение снимка данных. Используется только при хранении товаров в статике*/
private function SaveParsed($key,$data){
    $file_cache=$this->cache.'/'.$key.'.srl';
    file_put_contents($file_cache,serialize($data));
}
/*загрузка снимка данных. Аналогично. Только в статике товаров*/
private function LoadParsed($key,$force=false){
    $file_cache=$this->cache.'/'.$key.'.srl';
    if (file_exists($file_cache)){
    	    return unserialize(file_get_contents($file_cache));
    	    }else{return false;}
}

/*осуществление сетевого основного запроса к складу*/
private function query($service,$action='list',$body='',$filter=''){
LogIt('Делаем запрос:'.$service.' действие:'.$action);
//if(strlen($body)>0){LogIt('Размер тела запроса:'.ceil(strlen($body)/1000).' Кбайт');}
$service_url=$service;
if ($action=='list'){return $this->ListQuery($service.'/list',$body,$filter);}
//віше только для функции листинга вызывается отдельная функция
switch($action){
    case 'update':$service_url.='/list/update';$action='PUT';break;
    case 'delete':$service_url.='/list/delete';$action='POST';
}

//$xml=simplexml_load_string($body);
$xml=$this->loadXML($body);

if (!is_object($xml)){SafeExit('Объект не XML');return false;}
$total=sizeof($xml->children());
if (($total/$this->MAXQUERY)>1){LogIt('Запросов:'.ceil($total/$this->MAXQUERY));}
foreach ($xml->children() as $t) {
	$dump[]="\n".$t->asXML();
	}
unset($xml);
$i=0;
$updated_ok=true;
$return_xml='';
while ($i<$total){
    $data='<?xml version="1.0" encoding="UTF-8"?>
	<collection>';
        for ($j=0;$j<$this->MAXQUERY;$j++){
    	    if (isset($dump[$i+$j])){
    		$data.=$dump[$i+$j];
    		}
    	    }
    $data.='</collection>';
    if (($total/$this->MAXQUERY)>1){LogIt('Запрос № '.ceil($i/$this->MAXQUERY));}
    $ret_data=$this->lQuery($service_url,$action,$data);
    try{
	$xml=$this->loadXML($ret_data);
	if (!is_object($xml)){SafeExit('xml parse error'.$xml);}
	foreach($xml->children() as $child){$return_xml.=$child->asXML();}
	unset($xml);
	}
	catch(Exception $e){SafeExit($e->getMessage());}
    if ($ret_data===false){SafeExit('Возврат по ошибке');};
    $update_ok=$updated_ok && ($ret_data!==false);
    $i=$i+$j;
    };
if (strlen($return_xml)>0){return $return_xml='<?xml version="1.0" encoding="UTF-8"?>
	<collection>'.$return_xml.'</collection>';}
return false;
}

/*Только считывание данных со склада с объединением запросов (до 1000 элементов)*/
private function ListQuery($service,$body='',$filter=''){
    $filter_add='showArchived=true';
    if (strlen($filter)>0){$filter='&'.$filter_add.'&'.$filter;}
	else{$filter='&'.$filter_add;}
    $params='?start=0&count=1';if (strlen($filter)>0){$params.='&'.$filter;}
    $ret= $this->lQuery($service.$params);
    if ($ret!==false){
	$xml=$this->loadXML($ret);
	if (!is_object($xml)){return false;}
	$total=(int)$xml->attributes()->total[0];
	if ($total<=$this->MAXQUERY){
	    if (strlen($filter)>0){$service.='?'.$filter;}
	    return $this->lQuery($service);
	    }
	unset($xml);
	$data='<?xml version="1.0" encoding="UTF-8"?>
	<collection total="'.$total.'">';
	for ($i=0;$i<$total;($i=$i+$this->MAXQUERY)){
	     LogIt('Чтение с позиции:'.$i);
	     $params='?start='.$i.'&count='.$this->MAXQUERY;if (strlen($filter)>0){$params.='&'.$filter;}
	     $ret= $this->lQuery($service.$params,'GET',$body);
	       if ($ret!==false){
		$xml=$this->loadXML($ret);
	           foreach ($xml->children() as $t) {
    			$data.="\n".$t->asXML();
    			}
    		unset($xml);
		}
	    }
	$data.='</collection>';
	return $data;
	}
    return false;
    }
/*функция осуществляет сам по себе сетевой интерфейс со складом*/
//---adopt 1 query per 5 seconds
private function timeoutForQuery(){
    if(file_exists(__DIR__.'/time.bin')){
        $this->start_time = (int)file_get_contents(__DIR__.'/time.bin');
    }
    $howmany=(time()-$this->start_time);
    if ($howmany < 6){
        sleep(ceil(6-$howmany));
        $this->timeoutForQuery();
    }else {
        $this->start_time = time();
        file_put_contents(__DIR__ . '/time.bin', $this->start_time);
    }
}
//---adopt 1 query per 5 seconds
private function lQuery($service,$action='GET',$body=''){
    if ((strlen($this->username)==0)&&(strlen($this->password)==0)){
	    LogIt('Не заданы имя пользователя и пароль');
	    return false;
	    }
    $this->timeoutForQuery();

    $service_url='https://online.moysklad.ru/exchange/rest/ms/xml/'.$service;
    if (preg_match('|^Stock|',$service)){
        $service_url='https://online.moysklad.ru/exchange/rest/stock/xml/';    
	}
    $curl = curl_init($service_url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $action);
    curl_setopt($curl,CURLOPT_BINARYTRANSFER,true);
    curl_setopt($curl,CURLOPT_HEADER,true);
    curl_setopt($curl,CURLOPT_HTTPAUTH,CURLAUTH_BASIC);
    curl_setopt($curl,CURLOPT_USERAGENT,"MySklad sync");
    curl_setopt($curl,CURLOPT_USERPWD, $this->username . ":" . $this->password);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/xml'));
    if (strlen($body)>0){
	$this->LogBody($service_url."\n".$action."\n".$body."\n=============\n");
	curl_setopt($curl, CURLOPT_POSTFIELDS, $body);
	}
    $response = curl_exec($curl);
    if ($response === false) {
    	curl_close($curl);
    	return false;
            }
    curl_close($curl);
    list($header, $rbody) = explode("\r\n\r\n", $response, 2);

    if (preg_match('|HTTP\/1\.[01]\s100\s|',$header,$arr)){
	list($header, $rbody) = explode("\r\n\r\n", $rbody, 2);
	}
    if (preg_match('|HTTP\/1\.[01]\s200\sOK|',$header,$arr)){
	if (preg_match('|<error>|',$rbody)){
	    preg_match('|<message>([^>]+)</message>|',$rbody,$ans);
	    LogIt('Ошибка:'.$ans[1]);
	    echo "response:\n".$response."\nbody:\n".$body."\nheader:\n".$header."\nbody:\n".$rbody."\n";
            SafeExit('Возврат по ошибке');
	    }
	return $rbody;
	}else{
	if(preg_match('|HTTP\/1\.[01]\s(\d+)\s|',$header,$arr)){
		LogIt('Код возврата:Ошибка('.$arr[1].')');
		echo "response:\n".$response."\nbody:\n".$body."\nheader:\n".$header."\nbody:\n".$rbody."\n";
		SafeExit('Возврат по ошибке');
	    }
	return false;}
    return false;
}

/*перекодирование даты из ормата магазина в формат склада*/
private function TimeRecode($date){
$dt = DateTime::createFromFormat('Y-m-d H:i:s',$date);
if ($dt===false){$dt=DateTime::createFromFormat('Y-m-d H:i:s','1970-00-00 00:00:00');}
return date_format($dt, 'Y-m-d\TH:i:sP');
}
/*перекодирование из cp1251 в utf8*/
public function sEncode($s){
    return $s;
//    if (DO_RECODE_CP1251==false){ return $s;} else{return iconv('cp1251','utf-8',$s);}
    }
/*перекодирование из  utf8 в cp1251*/
public function sDecode($s){
    return $s;
//    if (DO_RECODE_CP1251==false){return $s;}else{ return iconv('utf-8','cp1251',$s);}
    }

/*функция объединения данных кеша с результатами запроса на склад.*/
private function Join($key,$join){
$file_cache=$this->cache.'/'.$key.'.xml';
try{
//$xml_join=simplexml_load_string($join);
$xml_join=$this->loadXML($join);unset($join);
if (sizeof($xml_join)==0){ return false;}
$xml=$this->loadXML(file_get_contents($file_cache));
}catch(Exception $e){SafeExit($e->getMessage());}
if (is_object($xml)&&is_object($xml_join)){
    $to_join=0;
    foreach($xml_join->children() as $child){$to_join++;$u_join[(string)$child->uuid]=$child->asXML();unset($child);}
    unset($xml_join);
    foreach($xml->children() as $child){$u_exist[(string)$child->uuid]=$child->asXML();	unset($child);}
    unset($xml);
    foreach($u_join as $key=>$value){
	if (isset($u_exist[$key])){unset($u_exist[$key]);}
	$new_xml[]=$value;	    
	}
    foreach($new_xml as $key=>$value){$u_exist[]=$value;}
    unset($new_xml);
    
    if (file_exists($file_cache)){@unlink($file_cache);}
    $XW=fopen($file_cache,'w');
    if (is_resource($XW)){
	fputs($XW,'<?xml version="1.0" encoding="UTF-8"?>
	    <collection total="'.sizeof($u_exist).'">');
	foreach($u_exist as $key=>$value){fputs($XW,$value."\n");}
        fputs($XW,'</collection>');
        fclose($XW);
	}
    unset($u_exist);

    @touch($file_cache,$this->start_time);
    LogIt('Объединено '.$to_join.' записей');
//-----rebuild data
    switch ($key){
	case 'Good':unset($this->products);$this->BuildProducts();break;
	case 'GoodFolder':unset($this->categories);$this->BuildCategories();break;
	case 'Company':unset($this->customers);$this->BuildCustomers();break;
	}
    }//----if objects
return true;
}
/*полная синхронизация*/

public function SyncAll($dry=true){
    $this->SyncPrice($dry);
    $this->SyncStock($dry);
    }

/*полная перезагрузка кеша*/
public function ReloadAllCache(){
    foreach($this->dictionary as $key){
	$file_cache=$this->cache.'/'.$key.'.xml';	
	@unlink($file_cache);
	$this->LoadCache(array($key),true);
	}
    }


/*включение в ошибки предупреждений при обработке XML данных*/
function loadXML($data) {
    set_error_handler(function($errno, $errstr, $errfile, $errline) {
        throw new Exception($errstr, $errno);
            });
    try {
    $xml=simplexml_load_string($data, 'SimpleXMLElement',LIBXML_PARSEHUGE);
    }catch(Exception $e) {
    SafeExit($e->getMessage());
    }
    restore_error_handler();
return $xml;
}

function DropAll($dryrun){}

public function PrepareStock(){}
public function SyncBarcode($dry_run){}

public function Cat(){}

public function SyncPrice($dryrun=true){
$this->BuildPriceType();
if(!$dryrun){$qd=new QueryDump($this->cache.'/SyncPrice.dump.xml');}
if(!$dryrun){$store=new QueryDump($this->storedir.'/price'.$this->thisdate);}
$qry=tep_db_query_my('select products_id,products_model,products_price from products');
if ($qry!==false){
$data=array();
$al_records=tep_db_num_rows($qry);
while ($res=tep_db_fetch_array($qry)){
    if (strlen($res['products_model'])>0){
	$data[$res['products_model'].':'.$res['products_id']]=(float)$res['products_price'];
	}
    }

$xml=$this->LoadFromCache('Good');
$i=0;
if ($xml===false){return false;}
    if (is_object($xml)){
	foreach ($xml->children() as $element){
	    $code=(string)$element->code;
	    $uuid=(string)$element->uuid;
    	    $price=(float)$element->attributes()->salePrice[0]/100;
	    foreach($element->salePrices->price as $sp){
		if ($sp->attributes()->priceTypeUuid[0]==$this->PriceType){$price=(float)$sp->attributes()->value[0]/100;}}
	    $price=round($price,0,PHP_ROUND_HALF_UP);
	    $model=(string)$element->attributes()->productCode[0];
	    $pid=tep_get_prid((string)$element->code);
	    $code=$model.':'.$pid;
	    if ((strlen($model)==0)&&(strlen($pid)==0)){continue;}
	    if (isset($data[$code])){
		$price_shop=round($data[$code],0,PHP_ROUND_HALF_UP);
		}else{//leave price if model not found
		$price_shop=$price;
		}
	if ($price!=$price_shop){
	    if(!$dryrun){$store->add($element->asXML());}
	    $i++;
	    LogIt('Цена поменялась:model{'.$model.'}id['.$pid.'] '.$price.'-->'.$price_shop);
	    foreach($element->salePrices->price as $sp){
		if ($sp->attributes()->priceTypeUuid[0]==$this->PriceType){$sp->attributes()->value=$price_shop*100;}
		}
	    if(!$dryrun){$qd->add($element->asXML());}
	    }
	}//----foreach
if(!$dryrun){$qd->save();}
if(!$dryrun){$store->save();}
LogIt('Всего цен:'.$al_records);
LogIt('Изменено цен:'.$i);
unset($xml);
}

if (!$dryrun){
$qd->reopen();
while (!$qd->eof()){
    $body=$qd->get($this->MAXQUERY);
	    try{
		$ret=$this->query('Good','update',$body);
		}catch(Exception $e){SafeExit($e->getMessage());};
		$body='';
    }
}
if (isset($qd)){unset($qd);}
if (isset($store)){unset($store);}
}//----query !=false
}//---end proc

public function ScanLog(){
$plog='<select name="log_file"><option value="0">Выбрать</option>';
    foreach(scandir($this->logdir) as $file){
	if (preg_match('|^\.{1,2}$|',$file)){continue;}
	if (preg_match('|^log(.+)|',$file,$arr))
	{
	$plog.='<option value="'.sha1($arr[0]).'">'.$arr[0].'</option>';	
	}
	}
$plog.='</select>';
return '<form target="_blank" method="POST" action="'.DIR_WS_ADMIN.basename($_SERVER['SCRIPT_FILENAME']).'">'.$plog.
'<input type="hidden" name="action" value="logdisplay">'.
'<input type="submit" value="Отобразить"></form>';
    }

public function ScanStorage(){
    $dir=$this->storedir;
    $price=array();
    $qty=array();
    foreach(scandir($dir) as $file){
	if (preg_match('|^\.{1,2}$|',$file)){continue;}
	if (preg_match('|^price(.+)|',$file,$arr)){$price[]=$arr[1];}
	if (preg_match('|^qty(.+)|',$file,$arr)){$qty[]=$arr[1];}
	}
$pselect='';
if (sizeof($price)>0){
$pselect='<select name="backup_price"><option value="0">Выбрать</option>';
    for ($i=0;$i<sizeof($price);$i++){	
	$pselect.='<option value="'.sha1($price[$i]).'">'.$price[$i].'</option>';
	}
$pselect.='</select>';
    }
$qselect='';
if (sizeof($qty)>0){
$qselect='<select name="backup_qty"><option value="0">Выбрать</option>';
    for ($i=0;$i<sizeof($qty);$i++){
	$qselect.='<option value="'.sha1($qty[$i]).'">'.$qty[$i].'</option>';
	}
$qselect.='</select>';
    }
return '<form method="POST" action="'.DIR_WS_ADMIN.basename($_SERVER['SCRIPT_FILENAME']).'">Цены:'.$pselect.' Количество:'.$qselect.
'<input type="hidden" name="action" value="restore">'.
'<input type="submit" value="Восстановить"></form>';
}
public function RestoreShop(){
global $_POST;
$file_price=$file_qty=false;
if (strlen($_POST['backup_price'])>1){$file_price=$this->DefineFile('price',$_POST['backup_price']);}
if (strlen($_POST['backup_qty'])>1){$file_qty=$this->DefineFile('qty',$_POST['backup_qty']);}
/*   go to process restore price in mysklad  */
if ($file_price!==false){
    $qd=new QueryDump($this->storedir.'/'.$file_price,false);
	$qd->reopen();
	    while (!$qd->eof()){
	        $body=$qd->get($this->MAXQUERY);
	    	    try{
	    		$ret=$this->query('Good','update',$body);
			}catch(Exception $e){SafeExit($e->getMessage());};
			$body='';
			}
    }
/*   go to process restore quoantity in shop  */    
if ($file_qty!==false){
    LogIt('Восстанавливаем количество '.$file_qty);
    $qty=unserialize(file_get_contents($this->storedir.'/'.$file_qty));
    if (is_array($qty)){
    foreach($qty as $model=>$quantity){
	try{
	LogIt("Model:".$model.'==>'.$quantity);
	$arr=explode(':',$model);
	$model=$arr[0];$pid=$arr[1];
	$upd=tep_db_query_my('update products set products_quantity='.$quantity.
			' where products_model="'.tep_db_input($model).'" and
   			  products_id="'.$pid.'"');
	}catch(Exception $e){SafeExit($e->getMessage());};
		}//---foreach
	}//---is_array
    }//---update qty
}

private function DefineFile($prefix='price',$hash=''){
foreach(scandir($this->storedir) as $file){
	if (preg_match('|^\.{1,2}$|',$file)){continue;}
	if (preg_match('|^'.$prefix.'(.+)|',$file,$arr))
	    {
	    if (sha1($arr[1])==$hash){return $prefix.$arr[1];}
	    }
	}
    LogIt('Файл не найден');
    return false;
    }

}//----end class

?>