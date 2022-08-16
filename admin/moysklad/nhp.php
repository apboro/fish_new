<?php
$this_folder=dirname(__FILE__).'/';
gc_enable();
if (!gc_enabled()){echo 'Garbage collection not enabled';}
if (file_exists($this_folder.'tmp/map.php'))
            {require($this_folder.'tmp/map.php');}	
require($this_folder.'/process.inc');
require($this_folder.'/nhp_top.php');
require($this_folder.'/classes/msklad.php');


  global $LOG,$languages_id,$MYSQL_COUNTER,$the_specs,$the_manufacture;
//  date_default_timezone_set('Europe/Moscow');
  date_default_timezone_set('EET');
//  date_default_timezone_set('Europe/Moscow');
//  ini_set('max_execution_time', 7200);
  ini_set('max_execution_time', 0);
  $start_at=date('Ymd_Gi');
  $the_specs=array();
  $the_manufacture=array();
  $languages_id=1;
  $MYSQL_COUNTER=0;
  define('LOG_FILE',$this_folder.'log/log.txt');
  define('DEBUG_LEVEL',1);
  $LOG=fopen(LOG_FILE,'w');
    if (!isProcRun()){
        SetPID();
    }else{SafeExit('Process started');}
LogIt('Процесс номер:'.ReadPID());
LogIt('Запущено с:('.$_SERVER['REMOTE_ADDR'].')');
//LogIt('Запущено в:'.date('d.m.Y H:i:s',time()));
MemoryEat();
if (!isset($_REQUEST['action'])){LogItDone();SafeExit('Закончили');}
$action=$_REQUEST['action'];
$action=preg_replace('|[^\w]|','',$action);

$ms=new MySklad();
switch($action){
    case 'settings':DoSettings();break;
    case 'sync':DoSync();break;
    case 'restore':$ms->RestoreShop();break;
    }

MemoryEat();
LogIt('Всего запросов в БД:( '.$MYSQL_COUNTER.' )');
//LogIt('Время затраченное БД:( '.$MYSQL_TIME.' ) сек.');

SafeExit('Закончили');

exit;

/*--------------functions------------*/
function DoSync(){
global $_REQUEST,$ms;
if (!isset($_REQUEST['what'])){return;}
$dry=isset($_REQUEST['dry']);
sleep(3);
$what=trim($_REQUEST['what']);
$need_update=true;

switch($what){
/*    case 'folders':{LogIt('Синхронизация категорий');$do=$ms->SyncCategories($dry);};break;
    case 'products':{LogIt('Синхронизация товаров');$do=$ms->SyncProducts($dry);};break;*/
/*    case 'customers':{LogIt('Синхронизация покупателей');$do=$ms->SyncCustomers($dry);};break;*/
    case 'reload':{LogIt('Полная перезагрузка кеша');$do=$ms->ReloadAllCache($dry);break;}
    case 'stock':{LogIt('Синхронизация склада');$do=$ms->SyncStock($dry);break;}
//    case 'stockfile':{LogIt('Подготовка файла стока');$do=$ms->PrepareStock();break;}
//    case 'meta':{LogIt('Подготовка метаданных');$do=$ms->SyncMeta($dry);break;}
//    case 'bar':{LogIt('Синхронизация баркодов');$do=$ms->SyncBarcode($dry);break;}
//    case 'cat':{LogIt('Синхронизация баркодов');$do=$ms->Cat($dry);break;}
    case 'price':{LogIt('Синхронизация цен');$do=$ms->SyncPrice($dry);break;}
    case 'all':{$do=$ms->SyncAll($dry);break;}
//    case 'drop':{LogIt('Удалить все');$do=$ms->DropAll($dry);}
    }
}


function DoSettings(){
global $_REQUEST,$ms;
if (isset($_REQUEST['company'])){
    $company=$ms->GetCompanyNames();
    foreach($company as $key=>$value){
	if ($value['uuid']==$_REQUEST['company']){
	    $ms->SetSettings('company',$value);
	    }
	}
}
if (isset($_REQUEST['login_name'])&&isset($_REQUEST['login_password'])){
    $settings=$ms->GetSettings();
	$ms->SetSettings('login',array(
			'username'=>$_REQUEST['login_name'],
			'password'=>$_REQUEST['login_password']
	    ));
	$ping=$ms->GetCompanyNames();
	if ($ping===false){LogItErr('Не могу подключится к API');
	}else{
	    $settings=$ms->GetSettings();
	    if (!isset($settings['connected'])){
		$ms->SetSettings('connected','true');
		}
	    }
    }
}

function MemoryEat(){
if (DEBUG_LEVEL>0){
LogIt('Съели памяти:'.round((memory_get_peak_usage(true)/1000000),2).' Мбайт');	
}
}

function LogItDone(){
global $LOG;
$mess=date('j.m.Y H:i:s').':&lt;Done&gt';
if (isset($LOG)){
    fwrite($LOG,'<span style="color:red;font-weight:bold;background-color:black;">'.$mess.'</span>'.'<br />'."\n");
    }

}
function LogItErr($msg){
global $LOG;
$mess=date('j.m.Y H:i:s').':<'.$msg.'>';
if (isset($LOG)){
    fwrite($LOG,'<span style="color:red;font-weight:bold;">'.htmlspecialchars($mess,ENT_NOQUOTES).'</span>'.'<br />'."\n");
    }
}

function LogItColor($color,$msg){
global $LOG;
$mess=date('j.m.Y H:i:s').'{'.
    round((memory_get_usage(true)/1000000),2).'--'.
    round((memory_get_peak_usage(true)/1000000),2).
    '} Мбайт'.':<'.$msg.'>';

if (isset($LOG)){
    fwrite($LOG,'<span style="color:'.$color.';font-weight:bold;">'.htmlspecialchars($mess,ENT_NOQUOTES).'</span>'.'<br />'."\n");
    }
}

function LogIt($msg){
global $LOG;
$mess=date('j.m.Y H:i:s').'{'.
    round((memory_get_usage(true)/1000000),2).'--'.
    round((memory_get_peak_usage(true)/1000000),2).
    '} Мбайт'.':<'.$msg.'>';

if (isset($LOG)){
    fwrite($LOG,htmlspecialchars($mess,ENT_NOQUOTES).'<br />'."\n");
    }
}


function SafeExit($msg){
global $LOG,$this_folder,$start_at;
LogIt("$msg");
LogIt("Done");
tep_db_close();
if (isset($LOG)){fclose($LOG);}
$nohup=$this_folder.'log/nohup_log.txt';
if (file_exists($nohup)&&(filesize($nohup)>0)){
    $this_log=file_get_contents(LOG_FILE);
    $error_log=file_get_contents($nohup);
    file_put_contents(LOG_FILE,$this_log.$error_log);
}
@copy(LOG_FILE,$this_folder.'log/log'.$start_at.'.txt');

unSetPID();
exit;
}

function tep_db_query_my($query, $link = 'db_link') {
    global $$link, $logger,$MYSQL_COUNTER;
    $MYSQL_COUNTER++;
    $qry=mysqli_query($$link,'set names utf8');if (isset($qry)){unset($qry);}
    $result = mysqli_query($$link,$query);
    if ($result===false) 
	{
	LogItErr('Код ошибки:'.mysqli_errno($$link));
	LogItErr('Описание ошибки:'. mysqli_error($$link));
	LogItErr('Запрос:'.$query);
	SafeExit('SQL critical error!');
	}
    return $result;
  }
function mem(){
LogIt(memory_get_usage().'---'.memory_get_peak_usage()."\n");
}

?>

