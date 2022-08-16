<?php
  $this_folder=dirname(__FILE__).'/moysklad/';
  require('includes/application_top.php');
  require($this_folder.'process.inc');
  require($this_folder.'classes/msklad.php');
  define('LOG_FILE',$this_folder.'log/log.txt');
  define('CONSOLE_LOG_FILE',$this_folder.'log/nohup_log.txt');
  $map_file=$this_folder.'tmp/map.php';
  global $LOG;
    $action=$_REQUEST['action'];
    $action=preg_replace('|[^\w]|','',$action);

//echo 'Maintenance';
//exit;
/* Uncomment this lines to drop whole backgrounds processed

echo "Before kill\n";
echo `ps aux | grep paralinz`;
`killall -9 php`;
echo "After kill\n";
echo `ps aux | grep paralinz`;
exit;
 Uncomment this lines to drop whole backgrounds processed
*/
$isRun=isProcRun();
 if ($action=='log'){
//    if (!$isRun){SafeExit('Процесс убит');}
//   if (!$isRun){LogIt('Процесс убит');}
    ReturnLog();exit;
    }
 if ($action=='logfull'){ReturnLogFull();exit;}
 if ($action=='getstock'){ReturnStock();exit;}
 if ($action=='restore'){RestoreShop();}
 if ($action=='delivery'){DoDelivery();$isRun=true;}
 if ($action=='logdisplay'){LogDisplay();exit;}
if (!$isRun){	
	@unlink(LOG_FILE);
	$fw=fopen($map_file,"w");
	if (isset($fw)){
	@fwrite($fw,'<?php'."\n");
	@fwrite($fw,'$_REQUEST='.var_export($_REQUEST,True).';');
	@fwrite($fw,'$_SERVER='.var_export($_SERVER,True).';');
	@fwrite($fw,'$_POST='.var_export($_POST,True).';');
	@fwrite($fw,'$_GET='.var_export($_GET,True).';');
	@fwrite($fw,'?>');
	@fclose($fw);
	    }
	$main_php='php';
	if (file_exists(PHP_BINDIR.'/php-cli')){$main_php='php-cli';}
	passthru(PHP_BINDIR.'/'.$main_php.' --php-ini '.
	    $this_folder.'php.ini'.' '.
	    $this_folder.'nhp.php > '.
	    $this_folder.'log/nohup_log.txt 2>&1 &',$return);
	}else{echo 'Running';}
?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<title><?php echo TITLE; ?></title>
<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
<script type="text/javascript" src="includes/menu.js"></script>
<script type="text/javascript" src="includes/general.js"></script>
<script type="text/javascript" src="includes/jquery-1.10.2.js"></script>

<script type="text/javascript">
$(document).ready(function(){ShowLog();});

function ShowLog(){
var id;
jQuery.ajaxSetup({cache: false});
jQuery.get('<?php echo DIR_WS_ADMIN.basename(__FILE__); ?>?action=log',function(data){
    document.getElementById('log').innerHTML=data;
            if (data.search(/Done/i)>0){submited='F';window.clearTimeout(id);}
                    });
            id=window.setTimeout("ShowLog()",5000);
}

</script>
</head>
<body marginwidth="0" marginheight="0" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0" bgcolor="#FFFFFF" onload="SetFocus();">
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
<!-- header_eof //-->
<!-- body //-->
<table border="0" width="100%" cellspacing="2" cellpadding="2">
  <tr>
    <td  valign="top">
      <table border="0" width="<?php echo BOX_WIDTH; ?> " cellspacing="1" cellpadding="1" class="columnLeft">
      <!-- left_navigation //-->
     <?php require(DIR_WS_INCLUDES . 'column_left.php'); ?>
     <!-- left_navigation_eof //-->
    </table>
   </td><td valign="top" width="100%">
<!-- body_text -->
<?php 
$ms=new MySklad();
$settings=$ms->GetSettings();
$company=$ms->GetCompanyNames();
//if (!isset($settings['company']['uuid'])){
if (true){
?>
<div style="border:1px solid black;">
<form action="<?php echo DIR_WS_ADMIN.basename(__FILE__); ?>" method="POST">
<input type="hidden" name="action" value="settings"/>
<table>
<tr><td>Юридическое лицо</td><td>
<?php
if (is_array($company)){
    echo '<select name="company">';
    foreach($company as $key=>$value){
	echo '<option value="'.$value['uuid'].'"';
	if ($value['uuid']==$settings['company']['uuid']){echo ' selected ';}
	echo '>'.$value['name'].'</option>';
	}
    echo '</select>';
    }
?>
</td></tr>
<?php 
if (!isset($settings['connected'])){?>
<tr><td>Имя пользователя API</td><td>
<input type="text" name="login_name" value="<?php echo $settings['login']['username'];?>"></td></tr>
<tr><td>Пароль API</td><td>
<input type="password" name="login_password" value="<?php echo $settings['login']['password'];?>"></td></tr>
<tr><td><input type="submit" value="Сохранить"></td></tr>
</table>
<?php } ?>

</form>
</div>

<?php 
}//----set company and login
if (isset($settings['connected'])){
?>

<table  style="background-color:#cfa;padding:3px;">
<tr><td style="color:red;font-weight:bold;">Внимание! Восстановление происходит без подтверждения!!!</td></tr>
<tr><td>
<?php echo $ms->ScanStorage();?>
</td></tr></table>
<br>
<table  style="background-color:#caf;padding:3px;">
<tr><td>Отобразить лог:</td></tr>
<tr><td>
<?php echo $ms->ScanLog();?>
</td></tr></table>
<br>
<table border="1">
<tr><td colspan="2">Синхронизация</td><td><a  style="maring:5px;padding:5px;color:red;font-weight:bold;" target="_blank" href="<?=DIR_WS_ADMIN.basename(__FILE__);?>?action=logfull">Текущий полный лог</a></td></tr>
<tr><td>Склад остатки</td><td><?=ShowForm('stock');?></td><td style="text-align:right"><?php
    echo ShowForm('stock',false);
    ?></td></tr>
<tr><td>Синхронизация цен</td><td><?=ShowForm('price');?></td><td style="text-align:right"><?php
echo ShowForm('price',false);
?></td></tr>
<tr><td>Все!</td><td><?=ShowForm('all');?></td><td style="text-align:right"><?php
echo ShowForm('all',false);
?></td></tr>
</table>
<br>
<table border=1>
<tr><td colspan="3">Полная перезагрузка кеша</td></tr>
<tr><td colspan="2"><?=ShowForm('reload',false);?></td></tr>
<?php if (ENABLE_DROP_ALL===true){?>
<tr><td colspan="3">Удалить все!!!</td></tr>
<tr><td colspan="2"><?=ShowForm('drop',false);?></td></tr>
<?php }?>
</table>
<?php } ?>
<div style="border: 1px solid black;height:300px;overflow:auto;" id="log"></div>

<!-- body_eof //-->
</td></tr>

</table>
<!-- footer //-->

<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<!-- footer_eof //-->
<br>
</body>
</html>
<?php 

function RestoreShop(){
global $ms;
if (!isset($ms)){$ms=new MySklad();}
}
function ShowForm($what,$dryrun=true){
$res='<form action="'.DIR_WS_ADMIN.basename(__FILE__).'" method="POST">'.
    '<input type="hidden" name="action" value="sync">'.
     '<input type="hidden" name="what" value="'.$what.'">';
     if ($dryrun){$res.='<input type="submit" value="Проверить">'.
    			'<input type="hidden" name="dry" value="dry">';
    			}else{
			$res.= '<input type="submit" value="Выполнить">';
			}
    $res.='</form>';
return $res;
}


function DoDelivery(){
global $_REQUEST;
$ms=new MySklad();
$data=array(
    'company_uuid'=>$_REQUEST['company_delivery'],
    'process_uuid'=>$_REQUEST['state_process'],
    'complete_uuid'=>$_REQUEST['state_complete']
    );
$ms->SetSettings('delivery',$data);
}

function ReturnLog(){
$tail=trim(`which tail`);
if (file_exists(LOG_FILE)){system($tail.' -n 15 '.LOG_FILE);}
if (file_exists(CONSOLE_LOG_FILE)){
    $FH=fopen(CONSOLE_LOG_FILE,'r');
    if (isset($FH)){
        while (!feof($FH)){echo fgets($FH);}
            fclose($FH);	
                }
    }
}

function ReturnLogFull(){
if (file_exists(LOG_FILE)){
    $FH=fopen(LOG_FILE,'r');
    if (isset($FH)){
        while (!feof($FH)){echo fgets($FH);}
            fclose($FH);	
                }
        }
if (file_exists(CONSOLE_LOG_FILE)){
    $FH=fopen(CONSOLE_LOG_FILE,'r');
    if (isset($FH)){
        while (!feof($FH)){echo fgets($FH);}
            fclose($FH);	
                }
        }        
}
function LogDisplay(){
$hash=tep_db_input($_POST['log_file']);
foreach(scandir(dirname(LOG_FILE)) as $file){
        if (preg_match('|^\.{1,2}$|',$file)){continue;}
        if (preg_match('|^log(.+)|',$file,$arr))
                {
                if (sha1($arr[0])==$hash){
		echo '<p style="color:red">'.$arr[0].'</p><hr>';
		$file=dirname(LOG_FILE).'/'.$arr[0];
		echo file_get_contents($file);
		return;
		    }
            }
    }
}

function ReturnStock(){
$ms=new MySklad();

$file=$ms->PrepareStock();
$quoted = sprintf('"%s"', addcslashes(basename($file), '"\\'));
$size   = filesize($file);

header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename=' . $quoted); 
header('Content-Transfer-Encoding: binary');
header('Connection: Keep-Alive');
header('Expires: 0');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Pragma: public');
header('Content-Length: ' . $size);
echo file_get_contents($file);    
}

?>