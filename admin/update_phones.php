<?php
require('includes/application_top.php');
define('TEMP_FOLDER',DIR_FS_CATALOG.'temp/');
if (!file_exists(TEMP_FOLDER)){mkdir(TEMP_FOLDER,0755,true);}
/*if ($action=='99'){
		    echo file_get_contents($logname,NULL,NULL,0,filesize($logname));
		    exit;    }*/
?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?> >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<title><?php echo TITLE; ?></title>
<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
<script language="javascript" src="includes/menu.js"></script>
<script language="javascript" src="includes/general.js"></script>
</head>
<body marginwidth="0" marginheight="0" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0" bgcolor="#FFFFFF" onload="SetFocus();">
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
<!-- header_eof //-->
<!-- body //-->
<table border="0" width="100%" cellspacing="2" cellpadding="2">
<tr>
<td width="<?php echo BOX_WIDTH; ?>" valign="top">
<table border="0" width="<?php echo BOX_WIDTH; ?> " cellspacing="1" cellpadding="1" class="columnLeft">
<!-- left_navigation //-->
<?php require(DIR_WS_INCLUDES . 'column_left.php'); ?>
<!-- left_navigation_eof //-->
</table>
</td>
<td width=100% valign=top>
<!-- body_text -->
<?php 
VerifyStructure();
if (strlen($_GET['action'])>0){$action=(int)$_GET['action'];};
switch ($action){
    case 1:if (Process()){echo '<p>Телефоны пересчитаны</p>';}
		else{echo '<p>Ошибка обновления данных</p>';}break;
    case 2: if (Rollback()){echo '<p>Данные восстановлены</p>';}
		else{echo '<p>Ошибка восстановления данных</p>';}
	    ;break;
    }
?>

<form method="GET" action="/admin/<?php echo basename(__FILE__);?>">
<input type="hidden" name="action" value="1">
<input type="submit" value="Пересчитать">
</form>

<form method="GET" action="/admin/<?php echo basename(__FILE__);?>">
<input type="hidden" name="action" value="2">
<input type="submit" value="Восстановить">
</form>


<!-- body_text_eof //-->
</td>
</tr>
</table>
<!-- body_eof //-->

<!-- footer //-->
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<!-- footer_eof //-->
<br>
</body>
</html>
<?php 
function Process(){
//$FW=fopen(TEMP_FOLDER.'phones.txt',w);
//if (!is_resource($FW)){return false;}
$qry=tep_db_query('select `customers_id`,`customers_telephone` from `customers` 
    order by customers_id');
if ($qry!==false){
    while ($res=tep_db_fetch_array($qry)){
	$to_update[$res['customers_id']]=$res['customers_telephone'];
	}
    unset($qry);
    $i=0;
    foreach($to_update as $id=>$phone){
	$phone=trim($phone);
	$n_phone=preg_replace('|^78|','8',$phone);
	$multi=strpos($n_phone,',');
	if ($multi>0){$n_phone=substr($n_phone,0,$multi);}
	$n_phone=preg_replace('|^[\+]{0,1}7|','8',$n_phone);
	$n_phone=preg_replace('|[^\d]|','',$n_phone);
	$n_phone=preg_replace('|^([^8])(\d{9})|','8$1$2',$n_phone);
	$n_phone=preg_replace('|^8(\d{3})(\d{3})(\d{2})(\d{2})$|','8($1)$2-$3-$4',$n_phone);
	if (strlen(trim($n_phone))==0){$n_phone=$phone;}
	if ($n_phone<>$phone){
	$i++;
	try{
	tep_db_query('update customers set `customers_telephone`="'.tep_db_input($n_phone).'" 
	    where customers_id='.$id);
	    }catch(Exception $e){echo '<p>Ошибка запроса:'.$e->getMessage().'</p>';}
	    
	    }
//	fputs($FW,"$id\t$phone\t$n_phone\n");
	}
    echo '<p>Обновлено записей:'.$i.'</p>';
    return true;
//    fclose($FW);
    }else{return false;}
}
function Rollback(){
    if (BackupExist()){
	$qry=tep_db_query('update customers set customers_telephone=keep_customers_telephone');
	return ($qry!==false);
	}
    }
function BackupExist(){
$qry=tep_db_query('select count(*) as CNT from `information_schema`.`columns` a 
where a.`TABLE_SCHEMA`="'.DB_DATABASE.'" and a.`table_name`="customers"
and a.`column_name`="keep_customers_telephone"');
if ($qry!==false){
$res=tep_db_fetch_array($qry);
return $res['CNT']>0;
}else{return false;}
}
function VerifyStructure(){
if (!BackupExist()){
	tep_db_query('alter table customers add keep_customers_telephone varchar(32)');
	tep_db_query('update customers set keep_customers_telephone=customers_telephone');
	$qry=tep_db_query('select count(*) as CNT  from customers where 
	trim(customers_telephone)<>trim(keep_customers_telephone)');
	if ($qry!==false){
	    $res=tep_db_fetch_array($qry);
	    if ($res['CNT']!=0){
		SafeExit('Ошибка создания структуры для восстановления');
		tep_db_query('alter table customers drop column keep_customers_telephone');
		}
	    return true;
	    }else{return false;}

    }
}
function SafeExit($msg){echo $msg;exit;};
?>