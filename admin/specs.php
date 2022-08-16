<?php 
require('includes/application_top.php');
?>
<style>
.header {background-color:#eee;font-weight:bold;color:brown;text-align:center;}
.pinfo{border:1px solid red;padding:2px;white_space:wrap !important;background-color:#eee;}
table.products{border:2px solid green;width:100%;}
table.products td {border:1px solid black;}
table.products td span{
display:block;float:left;
white-space:nowrap;padding:2px;background-color:#eee;margin:2px;border:1px dotted green;}

</style>
<?php
function SafeExit(){require('includes/application_bottom.php');exit;}
function Fill2ps(){
    global $languages_id,$cid;
//    echo "<p>Fill list</p>";
//    if (isset($p2s)){unset($p2s);}
    $pq=tep_db_query('SELECT SQL_NO_CACHE ps.products_id,ps.specifications_id,ps.specification,enter_values
        FROM products_specifications ps
        left join products_to_categories p2c on (ps.products_id=p2c.products_id)
	left join specifications s on (ps.specifications_id=s.specifications_id)
        where categories_id='.($cid).'
        and language_id='.$languages_id.'
        order by p2c.products_id,specifications_id');
    if ($pq!==false){
        while ($pr=tep_db_fetch_array($pq)){
//	    echo "<p> ".$pr['products_id']." ".$pr['enter_values']."</p>";
	    switch($pr['enter_values']){
	    case 'checkbox':
		$p2s[$pr['products_id']][$pr['specifications_id']][$pr['specification']]='on';
		break;
	    case 'pulldown':
	    case 'radio':
        	    $p2s[$pr['products_id']][$pr['specifications_id']]=$pr['specification'];
        	    break;
	    }
	}
/*	if ($pr['enter_values']!=='checkbox'){
    	    $p2s[$pr['products_id']][$pr['specifications_id']]=$pr['specification'];
    	    }else{
		$p2s[$pr['products_id']][$pr['specifications_id']][$pr['specification']]='on';
    	    }*/
        }
return $p2s;
}

function ValueList($pid, $specid)
{
    global $p2s, $specs;
    if (!isset($specs[$specid]['values'])) {
        return '<span>?</span>';
    }
    $ret = '';
    $addNewValue = '<div style="clear: both;">Новое:<input type="text" name="add[' . $pid . '][' . $specid . '][value]">' .
        'Порядок:<input type="number" min="0" style="width: 40px;" name="add[' . $pid . '][' . $specid . '][order]"></div>';
    switch ($specs[$specid]['type']) {
        case 'pulldown':
        case 'radio': {
            $ret = '<select name="radio[' . $pid . '][' . $specid . ']">';
            $ret .= '<option value="-1">Выбрать</option>';
            foreach ($specs[$specid]['values'] as $value) {
                $ret .= '<option ';
                if ($p2s[$pid][$specid] == $value) {
                    $ret .= ' selected ';
                }
                $ret .= '>' . $value . '</option>';
            }
            $ret .= '</select>' . $addNewValue;
            break;
        }
        case 'checkbox': {
            foreach ($specs[$specid]['values'] as $value) {
                $ret .= '<span><input type="checkbox" name="check[' . $pid . '][' . $specid . '][' . $value . ']"';
                if (isset($p2s[$pid][$specid][$value])) {
                    $ret .= ' checked ';
                }
                $ret .= '>' . $value . '</span>';
            }
            $ret .= $addNewValue;
            break;}
        case 'text': {
            $query = tep_db_query("SELECT specification 
            FROM  `products_specifications` 
            WHERE products_id ='$pid' AND specifications_id='$specid'");
            $value =tep_db_fetch_array($query);
            $value = $value['specification'];
            $ret .= '<textarea name="text[' . $pid . '][' . $specid . ']">'.$value.'</textarea>';
            break;}
    }
    return $ret;
}

if (!isset($_REQUEST['cPath'])){SafeExit();}
$caid_array=explode('_',$_REQUEST['cPath']);
$cid=(int)end($caid_array);
if ($cid<=0){SafeExit();}
/*Do some job about specs*/

if ($_POST['action']=='submit'){
$p2s=Fill2ps();
//echo '<pre>';var_dump($p2s);var_dump($_POST);echo '</pre>';
/*for each radio item*/
if (is_array($_POST['radio'])){

    foreach($_POST['radio'] as $pid=>$data){
	foreach($data as $sid=>$value){
	    if (isset($p2s[$pid][$sid])){
    		if ($value==-1){
//		    echo "<p>Delete $pid $sid </p>";
		    tep_db_query('delete from `products_specifications` where 
			products_id='.(int)$pid.' and specifications_id='.(int)$sid);
    		    continue;
    		    }
		if ($p2s[$pid][$sid]!==$value){
//    		echo "<p>Update $pid $sid </p>";
			tep_db_query('update `products_specifications` set specification="'.tep_db_input($value).'"
			where products_id='.(int)$pid.' and specifications_id='.(int)$sid);
			}
		}else{
		if ($value==-1){//echo "<p>?? $pid $sid</p>";
		    continue;
		    }
//    		echo "<p>Insert $pid $sid </p>";
		tep_db_query('insert into `products_specifications`(products_id,specifications_id,language_id,specification)
			    values('.(int)$pid.','.(int)$sid.','.(int)$languages_id.',"'.tep_db_input($value).'")');
		}
	    }
	}
}
function checkSpecificationExist($specifications_id,$language_id,$specification_value){
    $query = "select COUNT(*) as total
                               from " . TABLE_SPECIFICATIONS_VALUES . " as s
                               inner join ".TABLE_SPECIFICATIONS_VALUES_DESCRIPTION." as sd on(sd.specification_values_id = s.specification_values_id)
                               where s.specifications_id = '" . $specifications_id . "' 
                               AND sd.language_id = ".$language_id."  AND  sd.specification_value='".$specification_value."'
                              ";
    $specQuery = tep_db_query($query);
    $check_spec = tep_db_fetch_array($specQuery);
    if ($check_spec['total'] > 0) {
        return true;
    }
    return false;
}
function addSpecForProduct($pid,$sid,$languages_id,$value){
    tep_db_query('insert into `products_specifications`(products_id,specifications_id,language_id,specification)
			    values(' . (int)$pid . ',' . (int)$sid . ',' . (int)$languages_id . ',"' . tep_db_input($value) . '")');
}
function addNewSpecification(){
    $addItems = $_POST['add'];
    global $languages_id;
    foreach ( $addItems as $pid => $item) {
        foreach ( $item as $specifications_id => $specification) {
            if(!empty($specification['value'])) {
                $value = $specification['value'];
                $order = (int)$specification['order'];
                if(!checkSpecificationExist($specifications_id,$languages_id,$value)) {
                    $sql_data_array = array(
                        'specifications_id' => $specifications_id,
                        'value_sort_order' => $order
                    );
                    tep_db_perform(TABLE_SPECIFICATIONS_VALUES, $sql_data_array);
                    $specification_values_id = tep_db_insert_id();
                    $sql_data_array = array(
                        'specification_values_id' => $specification_values_id,
                        'specification_value' => $value);
                    $new_sql_data = array('language_id' => (int)$languages_id);
                    $sql_data_array = array_merge($sql_data_array, $new_sql_data);
                    tep_db_perform(TABLE_SPECIFICATIONS_VALUES_DESCRIPTION, $sql_data_array);
                }
                addSpecForProduct($pid,$specifications_id,$languages_id,$value);
            }
        }
    }
}
/*for each radio item*/
/*for each check item*/
    if ((is_array($_POST['check'])) || (sizeof($p2s) > 0) || is_array($_POST['text'])) {
//var_dump($p2s);
        if (is_array($p2s)) {
            foreach ($p2s as $pid => $data) {
                foreach ($data as $sid => $values) {
                    if (
                        (!isset($_POST['check'][$pid][$sid])) &&
                        (!isset($_POST['radio'][$pid][$sid]))
                    ) {
                        tep_db_query('delete from `products_specifications` where
		products_id=' . (int)$pid . ' and specifications_id=' . (int)$sid);
                        continue;
                    }
                    if (is_array($values)) {
                        foreach (array_keys($values) as $value) {
                            if (!isset($_POST['check'][$pid][$sid][$value])) {
                                tep_db_query('delete from `products_specifications` where
			products_id=' . (int)$pid . ' and specifications_id=' . (int)$sid . '
			and specification="' . $value . '"');
                            }
                        }
                    }

                }
            }//--foreach
        }
        addNewSpecification();
        if (is_array($_POST['check'])) {
            foreach ($_POST['check'] as $pid => $data) {
                foreach ($data as $sid => $values) {
                    foreach (array_keys($values) as $value) {
                        if (!isset($p2s[$pid][$sid][$value])) {
                            addSpecForProduct($pid,$sid,$languages_id,$value);
                        }
                    }
                }
            }
        }//--is_array
        if (is_array($_POST['text'])) {
            foreach ($_POST['text'] as $pid => $data) {
                foreach ($data as $sid => $value) {
                        tep_db_query('delete from `products_specifications` where
		products_id=' . (int)$pid . ' and specifications_id=' . (int)$sid);
                        addSpecForProduct($pid, $sid, $languages_id, $value);
                }
            }
        }
    }
//---if submit---

}
/*for each check item*/

/*Do some job about specs*/


unset($p2s);
$p2s=Fill2ps();

/*---get map for products to specification*/
//unset($pq);
$pq=tep_db_query('SELECT s.specifications_id, sd.specification_name,
    svd.language_id,sd.specification_description,specification_value,enter_values
 FROM specification_groups_to_categories sgtc
 left join specification_groups sg on (sg.specification_group_id=sgtc.specification_group_id)
 left join specifications s on (s.specification_group_id=sg.specification_group_id)
 left join specification_description sd on (sd.specifications_id=s.specifications_id)
 left join specification_values sv on (sv.specifications_id=s.specifications_id)
 left join specification_values_description svd on (sv.specification_values_id=svd.specification_values_id   and sd.language_id=svd.language_id)
 where categories_id='.$cid.'
 and (svd.language_id='.$languages_id.' OR ( enter_values = "text"))
 order by specifications_id,specification_value');
if ($pq!==false){
    while ($pr=tep_db_fetch_array($pq)){
	$specs[$pr['specifications_id']]['name']=$pr['specification_name'];
	$specs[$pr['specifications_id']]['desc']=$pr['specification_description'];
	$specs[$pr['specifications_id']]['values'][]=$pr['specification_value'];
	$specs[$pr['specifications_id']]['type']=$pr['enter_values'];
	}
    }


$i=0;
if(!empty($specs)) {
    foreach ($specs as $id => $data) {
        $header[$i]['name'] = $data['name'];
        $header[$i]['desc'] = $data['desc'];
        $header[$i]['id'] = $id;
        $i++;
    }
}
//var_dump($header);
if (sizeof($specs)==0){echo '<p>Нет спецификаций</p>';SafeExit();}

$prods_q=tep_db_query('select pd.products_name, p.products_image, p.products_quantity, p.products_model, pd.products_info,pd.products_id ,pd.products_description
	from  products_description pd 
       left join products_to_categories p2c on (p2c.products_id=pd.products_id)
       left join products p on (p.products_id=pd.products_id)
       where p2c.categories_id='.$cid.'  and p.products_quantity>0');
if (($prods_q!==false)&&(tep_db_num_rows($prods_q)==0)){echo 'Нет товаров';SafeExit();}
echo '<form method="POST" action="/admin/'.basename(__FILE__).'">';
echo '<input type="hidden" name="action" value="submit">';
echo '<input type="hidden" name="cPath" value="'.$cid.'">';
echo '<table class="products"><tr>';
echo '<td class="header">Изображение</td>';
echo '<td class="header">Название</td>';
foreach($header as $id=>$value){
    echo '<td class="header">'.$value['name'].'<br><small style="color:red">'.$value['desc'].'</small></td>';
}
echo '</tr>';
if ($prods_q!==false){
	$i=1;
    while ($pqr=tep_db_fetch_array($prods_q)){
	echo '<tr>';
        echo '<td>'.tep_image('/'.DIR_WS_IMAGES . $pqr['products_image'], $pqr['products_name'], 100, '').'</td>';
        echo '<td>№№'.$i.'<br>'.$pqr['products_name'].'<br><div class="pinfo">'.(empty($pqr['products_info'])?$pqr['products_description']:$pqr['products_info']);
		echo '<a href="https://yourfish.ru/advanced_search_result.php?keywords='. $pqr['products_model']. '" target=_blank><br>посмотреть на сайте</a></div></td>';
	foreach(array_values($header) as $hvalue){
	    echo '<td>'.ValueList($pqr['products_id'],$hvalue['id']).'</td>';
	    }
	echo '</tr>';
	$i++;
	}
    }
echo '</table>';
echo '<input type="submit" value="Сохранить">';
echo '</form>';
/*echo '<prE>';
echo 'header';
var_dump($header);
echo '</pre>';
*/
require('includes/application_bottom.php');
?>