<?php
/*define('MODULE_SHIPPING_TK_TEXT_WAY', '<div class="tk">
<div><input type="radio" name="tk_type" value="DL"><a href="http://www.dellin.ru/">Деловые Линии - от 500 руб.</a></div>
<div><input type="radio" name="tk_type" value="PEK"><a href="http://pecom.ru/">ПЭК - от 250 руб.</a></div>
<div><input type="radio"  name="tk_type" value="CDEK"><a href="http://www.edostavka.ru">СДЭК - от 200 руб.</a></div>
<div><input type="radio"  name="tk_type" value="EMS"><a href="http://emspost.ru">ЕМС почта - от 500 руб.</a></div>
</div>');*/
  class tk {
    var $code, $title, $description, $icon, $enabled,$tk_types;

// class constructor
    function tk() {
      global $order;
      $this->tk_types=array(
    /*'DL'=>array('title'=>  'Деловые Линии',
    					'url'=>'http://www.dellin.ru/',
    					'price'=>500
    					),*/
        		    'PEK'=>array('title'=>'ПЭК',
        				'url'=>'http://pecom.ru/',
        				'price'=>300),
/*                            'CDEK'=>array('title'=>'СДЭК',
                        		'url'=>'http://www.edostavka.ru',
                        		'price'=>200),*/
                            'EMS'=>array('title'=> 'ЕМС почта',
                        		'url'=>'http://emspost.ru',
                        		'price'=>500));
      $this->code = 'tk';
      $this->title = MODULE_SHIPPING_TK_TEXT_TITLE;
      $this->description = MODULE_SHIPPING_TK_TEXT_DESCRIPTION;
      $this->sort_order = MODULE_SHIPPING_TK_SORT_ORDER;
      $this->icon = '';
      $this->enabled = ((MODULE_SHIPPING_TK_STATUS == 'True') ? true : false);
    }

// class methods
    function quote($method = '') {
      global $order, $total_count,$messageStack;
if ($messageStack->size('smart_checkout')>0) {unset($_POST['tk_type']);unset($_REQUEST['tk_type']);};

      $selected='';
      if (isset($_REQUEST['tk_type'])){
    	    $_SESSION['tshipping']=$_REQUEST['tk_type'];
    	    }
      if (isset($_REQUEST['tshipping'])){
        $selected=$_REQUEST['tshipping'];
        $_SESSION['tshipping']=$selected;
        }else{
        if (isset($_SESSION['tshipping'])){
	    $selected=$_SESSION['tshipping'];        
    	    }
        }


$company='<div class="tk">';
foreach($this->tk_types as $key=>$value){
    $company.='<div><input  type="radio" '.($selected==$key?' id="tk_selected" checked="checked" ':'').
    ' name="tk_type" value="'.$key.'"/><span style="width:15%;display:inline-block">'.$value['title'].'</span>(от '.$value['price'].'руб.) ..... <a target="_blank" href="'.$value['url'].'" >перейти на сайт компании</a></div>';
    }
$company.='</div>';
      $price=0;
      if (isset($_REQUEST['tk_type'])){
    	    $_SESSION['tshipping']=$_REQUEST['tk_type'];
	    $company=$this->tk_types[tep_db_input($_REQUEST['tk_type'])]['title'];
	    $price=$this->tk_types[tep_db_input($_REQUEST['tk_type'])]['price'];
      }
    if (function_exists('tep_admin_check_login')){$company='';}
      $this->quotes = array('id' => $this->code,
                            'module' => MODULE_SHIPPING_TK_TEXT_TITLE,
                            'methods' => array(array('id' => $this->code,
                                                     'title' =>$company,
                                                     'cost' => $price)));
      if (tep_not_null($this->icon)) $this->quotes['icon'] = tep_image($this->icon, $this->title);
      return $this->quotes;
    }

    function check() {
      if (!isset($this->_check)) {
        $check_query = tep_db_query("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_SHIPPING_TK_STATUS'");
        $this->_check = tep_db_num_rows($check_query);
      }
      return $this->_check;
    }

    function install() {
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Разрешить модуль Транспортная компания', 'MODULE_SHIPPING_TK_STATUS', 'True', 'Вы хотите разрешить модуль на единицу?', '6', '0', 'tep_cfg_select_option(array(\'True\', \'False\'), ', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Порядок сортировки', 'MODULE_SHIPPING_TK_SORT_ORDER', '0', 'Порядок сортировки модуля.', '6', '0', now())");
    }

    function remove() {
      tep_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }

    function keys() {
      return array('MODULE_SHIPPING_TK_STATUS',  'MODULE_SHIPPING_TK_SORT_ORDER');
    }
  }
?>
