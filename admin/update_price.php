<?php
require('includes/application_top.php');
ini_set('max_execution_time',1200);
ini_set('output_buffering',512);
define('TEMP_PATH',DIR_FS_CATALOG.'temp/');
define('STORAGE_EXT','dmp');
$keep_filename=TEMP_PATH.date('d.m.Y_H:i').'.'.STORAGE_EXT;
$LOG=array();
$action=(int)$_REQUEST['action']; 
$logname=TEMP_PATH.tep_session_id().'.log';
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
div#main div{border-radius:0 0 10px 10px;display:none;float:left;width:100%;height:700px;width:600px;padding:10px;overflow:auto;white-space:nowrap;}
</style>
<div>
<div id="header">
<div style="background-color: #c4c9df" rel="update">Обновить</div>
<div style="background-color:#9c9" rel="restore">Восстановить</div>
<div style="background-color:#f2f2f2" rel="log">Журнал</div>
</div>
<div style="background-color:transparent;height:1px;width:100%;"></div>
<div id="main" >
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

    <tr><td><b>Использовать для обновления поле</b></td><td>
    <select name="use_field">
    <option value="model">Модель</option>
    <option value="name">Название товара</option>
    </select></td></tr>

    <tr><td><b>Обновить товары поставщика</b></td><td>
            <select name="supply">
                    <?
                    $query =  tep_db_query ("
SELECT 
supplier_id,supplier_name
FROM
supplier 
GROUP BY supplier_id
");

                    while ($new_values = tep_db_fetch_array($query)){
                        $arr[] = $new_values;
                    }
                    echo "<option>Выбери поставщика</option>";

                    foreach ($arr as $ar) {
                        echo "<option value='".$ar['supplier_id']."'>".$ar['supplier_name']."</option>";
                    }

                    ?>
            </select></td></tr>

    <tr><td><b>Кодировка:</b></td><td>
    <select name="enc">
    <option value="cp1251">cp1251</option>
    <option value="utf8">utf-8</option>
    </select></td></tr>
    
    <tr><td><b>Сохранить состояние БД</b></td><td>
    <input type="checkbox" name="keep_exist"  />
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
//   }else{

    switch($action){
//    default:echo '<div id="log"></div>';break;
    case 2: 
	RestoreDB();
	break;
    case 1:
    //-----Main do--------
    $to_process=tep_get_uploaded_file('ufile');
    if (is_array($to_process) && (strlen($to_process['name'])>0)){
	LogIt('Обрабатываем файл:'.$to_process['name']);
	$error_str='';
	if ($_REQUEST['enc']=='utf8'){
        $strings=explode("\n",file_get_contents($to_process['tmp_name']));
        }else{
	LogIt('Конвертация из cp1251 в utf-8');
	$strings=explode("\n",iconv('cp1251','utf-8',file_get_contents($to_process['tmp_name'])));
        }
	LogIt('Количество строк:'.(sizeof($strings)-1));
	$header=explode(';',$strings[0]);
	$mapping=array();
	for($i=0;$i<sizeof($header);$i++){
	    if ($header[$i]=='v_products_name_1'){$mapping['name']=$i;}
	    if ($header[$i]=='v_products_model'){$mapping['model']=$i;}
	    if ($header[$i]=='v_products_price'){$mapping['price']=$i;}
	    if ($header[$i]=='v_products_quantity'){$mapping['quantity']=$i;}
	    }
      foreach(array_keys($mapping) as $key){LogIt('Найдено поле: "'.$key.'"');}
      $key_field='model';
      if (isset($_POST['use_field'])){
    	    if ($_POST['use_field']=='name'){$key_field='name';}
    	}
        $supply = false;
        if (isset($_POST['supply']) && !empty($_POST['supply'])){
            $supply = (int)$_POST['supply'];
        }
        $allow_update=true;
      $allow_update=$allow_update and isset($mapping[$key_field]);

      if (!isset($mapping[$key_field])){LogIt('<p>Нет поля товара:<font color="red"> '.$key_field.'</font></p>',false);
        }else{
	     $products=array();
	     GetProducts($key_field,$supply);
	     DoUpdate($key_field);
	}
	}else{LogIt('<p style="color:red">Выберите файл</p>',false);}#if any file was uploaded
        break;
    }//-----end switch action----
	echo '<div id="log" ';
	if ($action<>0){echo 'style="display:block;background-color:#f2f2f2"';}
	else{echo 'style="background-color:#f2f2f2"';} 
	echo '>';
	echo implode("\n",$LOG).'</div>';
//        echo '<br /><a href="'.tep_href_link($current_page).'">Вернуться назад</a>';
//}#end of do something action is set

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
    $p=unserialize(file_get_contents($file));
    $p_key=$p['key_field'];
    GetProducts($p_key);
    $p_data=$p['data'];
    $restored=0;
    foreach($p_data as $model=>$value){
	$need_update=false;
	$need_update=$need_update | (float)($products[$model]['price']<>(float)$value['price']);
	$need_update=$need_update | ($products[$model]['quantity']<>$value['quantity']);
	if ($need_update){
	    $query='update products set products_quantity='.
		    tep_db_input($value['quantity']).
		    ',products_price= '.
		    tep_db_input($value['price']).
		' where products_id='.$value['id'];
	     try{$qry=tep_my_query($query);
		LogIt('<p style="color:#ccc">Восстановление:('.$model.') успешно</p>',false);
		$restored++;
		 }catch(Exception $e){LogIt('<p style="color:red;font-weight:bold;">'.$e->getMessage().'</p>',false);}
	    }//--need update
	 }//---foreach value
    //----
    }else{
    LogIt('Файл '.$_REQUEST['rfile'].' не найден');
    }
LogIt('<p style="color:green">Восстановлено:'.$restored.' товаров</p>',false);
LogIt('<p style="color:red">Восстановление окончено</p>',false);
}


function GetProducts($key_field, $supply = 0){
global $_POST,$products,$keep_filename,$allow_update;
     LogIt('Определяем состояние БД:');
     LogIt('<p>Ключ для выборки:<b><font color="red">'.$key_field.'</font></b></p>',false);
     $query_supply = '';
     if($supply > 0){
         $query_supply = " AND p.supplier_id=$supply";
     }
     $query=tep_db_query('select p.products_id,
    				 upper(pd.products_name) as products_name,
    				 upper(p.products_model) as products_model,
    				 p.products_price,
    				 p.products_quantity
				 from products p,products_description pd
				 where p.products_id=pd.products_id'.$query_supply);
	 if (is_object($query)){
	    while ($res=tep_db_fetch_array($query))
		{
		$products[$res['products_'.$key_field]]=array(
		    'id'=>$res['products_id'],
		    'price'=>$res['products_price'],
		    'quantity'=>$res['products_quantity'],
		    'name'=>$res['products_name'],
		    'model'=>$res['products_model']
		    );
		}
	    }//----obtain array with products--
	//---keep current state into file---
	LogIt('Товаров:'.sizeof($products));
	if (isset($_POST['keep_exist'])&&($_POST['keep_exist']=='on')){
	    LogIt('Сохраняем текущее состояние в '.basename($keep_filename));
	    $allow_update=$allow_update and file_put_contents($keep_filename,
		serialize(array('key_field'=>$key_field,
		                'data'=>$products)
		        )
		);
        }
}
function Cleanup($s){
$s=preg_replace('|^\"|',null,$s);
$s=preg_replace('|\"$|',null,$s);
$s=preg_replace('|""|','"',$s);
return mb_strtoupper($s,'utf-8');
}

function DoUpdate($key_field){
global $allow_update,$strings,$mapping,$products;
      if ($allow_update){
	LogIt('<p style="color:red">Обновление разрешено</p>',false);
	//---keep current state into file---
	array_shift($strings);//--remove header
    	LogIt('Товаров для обновления:'.(sizeof($strings)-1));
	$to_update=0;
	$not_update=0;
        $not_changed=0;
	$proc_error=0;
	while (sizeof($strings)>0){
	    $s=array_shift($strings);
/*	    $s=preg_replace('|^\"|',null,$s);
	    $s=preg_replace('|\"$|',null,$s);*/
	    if (strlen($s)==0){continue;}
	    $line=explode(';',$s);
	    $model=Cleanup(trim($line[$mapping[$key_field]]));
	    if (strlen($model)>0){
		$price=Cleanup(trim($line[$mapping['price']]));
		$price=(float)trim(preg_replace('[\,]','.',$price));
		$quantity=Cleanup(trim($line[$mapping['quantity']]));
		$id=(int)Cleanup(trim($products[$model]['id']));
	    if (!isset($id)||($id==0)){LogIt('<p style="color:green">Не найдено поле:"'.$model.'"</p>',false);$not_update++;continue;}
		else{
		    $need_update=false;
		    $need_update=$need_update | ((float)$products[$model]['price']<>(float)$price);
		    $need_update=$need_update | ($products[$model]['quantity']<>$quantity);
		    if (!$need_update){continue;$not_changed++;}
		    if (isset($update_array)){unset($update_array);}
		    $update_array=array();
		    if (isset($mapping['price'])){$update_array[]=' products_price='.tep_db_input($price).' ';}
		    if (isset($mapping['quantity'])){$update_array[]=' products_quantity='.tep_db_input($quantity).' ';}
		 $query='update products set '.implode(',',$update_array).' where products_id='.$id;
		 try{$qry=tep_my_query($query);
			if ($qry!==false){
			LogIt('<p style="color:#ccc">Обновление:{'.$model.'}'.
			    'Цена:['.$products[$model]['price'].'=>'.$price.']'.
			    'Количество['.$products[$model]['quantity'].'=>'.$quantity.'] успешно</p>',false);
			$to_update++;
			}else{$proc_error++;}
		       }catch(Exception $e){LogIt('<p style="color:red;font-weight:bold;">'.$e->getMessage().'</p>',false);$proc_error++;}
	    	    }
		}///-if model exist
	    }
        }else{echo 'Обновление запрещено из-за ошибки';}
LogIt('<p style="color:green">Обновлено:'.$to_update.' </p>',false);
LogIt('<p style="color:green">Не обновлено:'.$not_changed.' </p>',false);
LogIt('<p style="color:green">Не найдено:'.$not_update.' </p>',false);
LogIt('<p style="color:green">Ошибок обновления:'.$proc_error.' </p>',false);
LogIt('<p style="color:red">Обновление окончено</p>',false);
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
