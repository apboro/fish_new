<?php
require('includes/application_top.php');
$fields=array('categories_id','categories_name','categories_heading_title',
'categories_meta_title','categories_meta_description','categories_meta_keywords',
'categories_url');
define('PHPEXCEL_ROOT',DIR_FS_DOCUMENT_ROOT);
define('TEMP_PATH',DIR_FS_CATALOG.'temp/');
define('STORAGE_EXT','dmp');
$keep_filename=TEMP_PATH.date('d.m.Y_H:i').'.'.STORAGE_EXT;
define('EXPORT_FILE',TEMP_PATH.'export.xls');
$LOG=array();
$action=(int)$_REQUEST['action']; 
$logname=TEMP_PATH.tep_session_id().'.log';
/*if ($action=='99'){
		    echo file_get_contents($logname,NULL,NULL,0,filesize($logname));
		    exit;    }*/
if ($action=='11'){
    header("Content-type: application/vnd.ms-excel;charset=UTF-8");
    header("Content-Disposition: attachment; filename=".basename(EXPORT_FILE));
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Pragma: public");
    echo file_get_contents(EXPORT_FILE);
    exit;
    }
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
<!-- body_text -->

<td width="100%" valign="top"><table class="table-padding-2">
<tr>
<td width="100%"><table class="table-padding-0">
<tr>
<td>

<script>
$(document).ready(function(){
    $("#header div").click(function(){
	$("#main div").hide();
	$("#main #"+$(this).attr('rel')).show();
	})
    });
</script>
<style>
div#log * {padding:0;margin:0;}
div#header {display:table-row;width:100%;border:none;font-weigth:bold;}
div#header div{border-radius:10px 10px 0px 0px;display:table-cell;float:left;border:1px solid;black;padding:10px;margin:0;margin-left:2px;cursor:pointer;}
div#header div:first-child{margin-left:0px;}
div#header div:hover{opacity:0.5;}
div#main {display:table-row;width:100%;border:2px outset black;}
div#main div{border-radius:0 0 10px 10px;display:none;float:left;width:100%;height:200px;width:400px;padding:10px;overflow:auto;white-space:nowrap;}
</style>
<div>
<div id="header">
<div style="background-color: #c4c9df" rel="update">Обновить</div>
<div style="background-color:#9c9" rel="restore">Восстановить</div>
<div style="background-color:#a8a" rel="export">Экспорт</div>
<div style="background-color:#f2f2f2" rel="log">Журнал</div>
</div>
<div style="background-color:transparent;height:1px;width:100%;"></div>
<div id="main" >
<div id="export" style="background-color:#a8a">
<?php    echo tep_draw_form('data_export',$current_page,'','post','enctype="multipart/form-data"'); ?>
<input type="hidden" name="action" value="10">
<input type="submit" value="Экспорт">
</form>
<?php if (file_exists(EXPORT_FILE)){
    echo tep_draw_form('data_export',$current_page,'','post','enctype="multipart/form-data"'); ?>
    <input type="hidden" name="action" value="11">
    <input type="submit" value="Забрать файл">
    </form>        
<?php    } ?>
</div>
<div id="update"  <?php if ($action==0){echo 'style="display:block;background-color: #c4c9df"';}
    else{echo 'style="background-color: #c4c9df"';}?> >
<?php
if (!file_exists(TEMP_PATH)){mkdir(TEMP_PATH,0770,true);}
if (!function_exists(tep_get_uploaded_file))
    {include('easypopulate_functions.php');}
//if (!isset($_REQUEST['action'])){
    echo tep_draw_form('data_update',$current_page,'','post','enctype="multipart/form-data"');
?>
<table border="0"><tr><td colspan="2"><b>Загружаемый файл:</b></td></tr>
<tr><td colspan="2">
<input type="hidden" name="action" value="1">
<input type="file" name="ufile">
</td></tr>

    <tr><td colspan="2" style="text-align:center;">
    <input type=submit value="Обновить">
    </td></tr></table>
    </form>
    </div>
    <div id="restore" style="background-color:#9c9">
<?php
    echo tep_draw_form('data_restore',$current_page,'','post','enctype="multipart/form-data"');
?>
    <table><tr><td>
    <input type="hidden" name="action" value="2">
    <select name="rfile"> 
    <?php
    if (is_dir(TEMP_PATH)) {
	if ($dh = opendir(TEMP_PATH)) {
    	    while (($file = readdir($dh)) !== false) {
		    $pinfo=pathinfo($file);
		    if ($pinfo['extension']==STORAGE_EXT){
			    echo '<option value="'.$file.'">'.$file.'</option>';
			    }
                        }
                closedir($dh);
                }
    }

    ?>
    </select> 
    </td></tr><tr><td><input type=submit value="Восстановить"></td></tr>
    </table>
</form>
</div>
<? 

    switch($action){
    case 10: ExportCategories();break;
    case 2: 
	RestoreDB();
	break;
    case 1:DoUpdate();
        break;
    }//-----end switch action----
	echo '<div id="log" ';
	if ($action<>0){echo 'style="display:block;background-color:#f2f2f2"';}
	else{echo 'style="background-color:#f2f2f2"';} 
	echo '>';
	echo implode("\n",$LOG).'</div>';

?>
</div>
</div>
</div>

<?php

function RestoreDB(){
global $_REQUEST,$products;
LogIt('<p style="color:red">Восстанавливаем БД из: '.$_REQUEST['rfile'].'</p>',false);
$file=TEMP_PATH.$_REQUEST['rfile'];
if (isset($_REQUEST['rfile'])&&(file_exists($file))){
    $xls=unserialize(file_get_contents($file));
    $data=GetSnapshot(true);    

    if (is_array($xls)&&is_array($data)){
	foreach($xls as $catid=>$cat_data){
	    $data_eq=true;
	    foreach ($cat_data as $field=>$value){
		$data_eq=$data_eq && ($data[$catid][$field]==$value);
		}
		if (!$data_eq) {
		    $sql='update categories_description set ';
		    if (isset($join)){unset($join);$join=array();}
		    foreach($cat_data as $cfield=>$cvalue){
			if ($cvalue==NULL){continue;}
			$join[]=" $cfield=\"".tep_db_input($cvalue)."\"";
			}
		    $sql.=implode($join,',').' where categories_id='.$catid;
		    LogIt('<p style="color:red"> Обновляем '.$catid.'</p>',false);
		    tep_my_query($sql);
    	        }else{LogIt('Нет изменений '.$catid);}//---create sql for all fields if not eq
	    }//--for each row in file
	}//---if both data exist
    }
}




function GetSnapshot($return_array=false){
global $keep_filename,$fields;
$qry=tep_my_query('select * from categories_description order by categories_id');

$data=array();
if ($qry!==false){
    while ($res=tep_db_fetch_array($qry)){
	for($i=1;$i<sizeof($fields);$i++){
    	    $data[$res['categories_id']][$fields[$i]]=$res[$fields[$i]];
	    }
    	}
    }
if ($return_array==false){
    if (sizeof($data)>0){file_put_contents($keep_filename,serialize($data));}
    }else{return $data;}

}

function DoUpdate(){
global $allow_update,$strings,$mapping,$products,$keep_filename,$fields;
$data=GetSnapshot(true);
if (sizeof($data)>0){file_put_contents($keep_filename,serialize($data));}
    $to_process=tep_get_uploaded_file('ufile');
    if (is_array($to_process) && (strlen($to_process['name'])>0)){
	LogIt('Обрабатываем файл:'.$to_process['name']);
        $filename=$to_process['tmp_name'];	
    	include '../PHPExcel.php';
    try {
	$inputFileType = PHPExcel_IOFactory::identify($filename);
	LogIt('Тип файла:'.$inputFileType);
        $objReader = PHPExcel_IOFactory::createReader($inputFileType);
        $objPHPExcel = $objReader->load($filename);
            } catch(Exception $e) {
                LogIt('Ошибка загрузки файла "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage(),true);
		return false;
                }
	if (is_object($objPHPExcel)){
	    $xls=array();
	    $sheet = $objPHPExcel->getSheet(0);
	    $arr=$sheet->toArray();
	    $highestRow = $sheet->getHighestRow();
	    $highestColumn = $sheet->getHighestColumn();
	    LogIt($catid);
	    for ($row = 1; $row <= $highestRow; $row++){ 
		$catid=$arr[$row][0];
		$xls[$catid]=array();
		for ($col=1;$col<sizeof($fields);$col++){
		    $cell=$arr[$row][$col];
		    $xls[$catid][$fields[$col]]=$cell;
		    }
		}
//	    file_put_contents($keep_filename.'.x',serialize($xls));
	    }
	}
    if (is_array($xls)&&is_array($data)){
	foreach($xls as $catid=>$cat_data){
	    $data_eq=true;
	    foreach ($cat_data as $field=>$value){
		$data_eq=$data_eq && ($data[$catid][$field]==$value);
		}
		if (!$data_eq) {
		    $sql='update categories_description set ';
		    if (isset($join)){unset($join);$join=array();}
		    foreach($cat_data as $cfield=>$cvalue){
			if ($cvalue==NULL){continue;}
			$join[]=" $cfield=\"".tep_db_input($cvalue)."\"";
			}
		    $sql.=implode($join,',').' where categories_id='.$catid;
		    LogIt('<p style="color:red"> Обновляем '.$catid.'</p>',false);
		    tep_my_query($sql);
    	        }else{LogIt('Нет изменений '.$catid);}//---create sql for all fields if not eq
	    }//--for each row in file
	}//---if both data exist
	

}

function tep_my_query($query, $link = 'db_link') {
  global $$link, $logger;
  $result = mysqli_query($$link, $query); 
  if (mysqli_error($$link)){ 
    LogIt('<p style="font-weight:bold;color:red;">'.$query.'</p>',false);
  }
  return $result;
 }

function LogIt($msg,$p_include=true){
global $LOG,$logname;
if ($p_include){$msg='<p>'.$msg.'</p>';}
$LOG[]=$msg;
@file_put_contents($logname,implode("\n",$LOG));
}

function ExportCategories(){
global $languages_id,$fields;
LogIt('<p style="color:red">Делаем выборку данных</p>',false);
$qry=tep_my_query('select * from categories_description order by categories_id');

if ($qry==false){return;}
//LogIt(DIR_FS_DOCUMENT_ROOT.'/PHPExcel',true);

require('../PHPExcel.php');
$workbook = new PHPExcel();
$sheet=$workbook->getActiveSheet();
for ($i=0;$i<sizeof($fields);$i++){
    $sheet->setCellValueByColumnAndRow($i,1,$fields[$i]);
    }
$query=$qry;
    if ($query!==false){
	$count=2;
	while ($res=tep_db_fetch_array($query)){
    for ($i=0;$i<sizeof($fields);$i++){
	$sheet->setCellValueByColumnAndRow($i,$count,$res[$fields[$i]]);    
	}
    $count++;
	    }
	}
    $objWriter = new PHPExcel_Writer_Excel5($workbook);
    $objWriter->save(EXPORT_FILE);
    unset($objWriter);unset($sheet);unset($workbook);
LogIt('<p style="color:red">Подготовили файл</p>',false);
}




?>

</td>

</tr>
</table></td>

<!-- body_text_eof //-->

</tr>
</table>
<!-- body_eof //-->

<!-- footer //-->
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<!-- footer_eof //-->
<br>
</body>
</html>


