<?php
/*if ($_SESSION['pvpath']<>(int)$_REQUEST['vPath']){
    unset($_REQUEST['filter_id']);
    unset($_GET['filter_id']);
    unset($_GET['srmi']);
    unset($_GET['srma']);
    unset($_REQUEST['srmi']);
    unset($_REQUEST['srma']);
    }
$_SESSION['pvpath']=$_REQUEST['vPath'];
if (isset($_REQUEST['vPath'])&&(strlen($_REQUEST['vPath'])==0)){
    unset($_REQUEST['filter_id']);
    unset($_GET['filter_id']);
    unset($_GET['srmi']);
    unset($_GET['srma']);
    unset($_REQUEST['srmi']);
    unset($_REQUEST['srma']);
    }*/


 
/*мой код*/
 
if (!isset($deduction_map)){$deduction_map=GetDeductionMap(true);}
//$dproducts=$deduction_map['products'];
$host='db'; // имя хоста (уточняется у провайдера)
$database='yourfish'; // имя базы данных, которую вы должны создать
$user='root'; // заданное вами имя пользователя, либо определенное провайдером
$pswd='lHhYoy'; // заданный вами пароль
 
$dbh = mysql_connect($host, $user, $pswd) or die("Не могу соединиться с MySQL.");
mysql_select_db($database) or die("Не могу подключиться к базе.");
$query = 'SELECT * FROM products_to_categories cat, products prod WHERE cat.categories_id=25421 AND cat.products_id=prod.products_id
 AND (prod.products_price BETWEEN '.$deduction_map["min"].' AND '.$deduction_map["max"].')';
$res = mysql_query($query);
while($row = mysql_fetch_array($res))
{
  $p_id=  $row['products_id'];
$dproducts[$p_id]=1;



}
$display_cat[25421]=1;
/*мой код*/

$display_cat=$deduction_map['categories'];
$min_price=$deduction_map['min'];
$max_price=$deduction_map['max'];

$dmanufacturers=$deduction_map['manufacturers'];





if (sizeof($dproducts)==0){
    ?>
    <p>Не найдено</p>
    <script type="text/javascript">
    //window.history.go(-1);
    </script>
    <?
    return;
    }

$order_str='';
if (strlen($listing_sql)>0){
    $finder=' order by ';
    $order_str= substr($listing_sql,strpos($listing_sql,$finder),strlen($listing_sql));
}


$listing_sql='select SQL_CALC_FOUND_ROWS p.products_image, pd.products_name,p.products_quantity,
    if (p.products_quantity>0,1,0) as pq , 
    if (p.products_quantity>=9999,1,0) as ps,  
    if(p.products_quantity < 9999, 1, products_quantity_order_min)  as quantity_order_min,
    if(p.products_quantity < 9999, 1, products_quantity_order_units)  as quantity_order_units,
    p2c.categories_id as categories_id,
    p.products_model,
    pd.products_info,
    p.products_id, 
    p.manufacturers_id, p.products_price, p.products_sort_order, 
    p.products_tax_class_id, IF(s.status, s.specials_new_products_price, NULL) as specials_new_products_price, 
    IF(s.status, s.specials_new_products_price, p.products_price) as final_price 
'."from " . TABLE_PRODUCTS . " p 
  INNER JOIN (SELECT * FROM " . TABLE_PRODUCTS_TO_CATEGORIES . " group by products_id) as  p2c
  ON p.products_status = '1' AND  p.products_quantity > 0 AND  p.products_id = p2c.products_id
  INNER JOIN " . TABLE_CATEGORIES . " as c
  ON c.categories_status = '1' AND p2c.categories_id = c.categories_id
  INNER JOIN " . TABLE_PRODUCTS_DESCRIPTION . " as pd
  ON p.products_id = pd.products_id and pd.language_id = '" . (int)$languages_id . "'
  left join  " . TABLE_PRODUCTS_TO_PRODUCTS_EXTRA_FIELDS . " p2pef on p.products_id = p2pef.products_id
  left join   " . TABLE_MANUFACTURERS_INFO . " mi on mi.manufacturers_id = p.manufacturers_id
  left join " . TABLE_SPECIALS . " s on p.products_id = s.products_id Where true";
if (sizeof($dproducts)>0){
    $listing_sql.='    and p.products_id in ('.implode(',',array_keys($dproducts)).')';
    }
if (strlen($order_str)>0){$listing_sql.=$order_str;}else{
//    $listing_sql.=' order by pq desc,p.products_price,p.products_sort_order, pd.products_name asc';
    $listing_sql.=' order by pq desc,ps asc,p.products_sort_order, pd.products_name asc';
    }
//echo $listing_sql;exit;
?>
<style>
.vdesc{font-weight:bold;color:green;padding:5px;}
input.disabled,select.disabled {
    pointer-events:none;
    color:#AAA;
    background:#F5F5F5;
}
</style>
    <table border="0" width="100%" cellspacing="0" cellpadding="<?php echo CELLPADDING_SUB;?>">
      <tr>
        <td>

        <?php echo tep_draw_form('filter', tep_href_link('discount2.php'), 'get'); ?>
        <table class="table-padding-0">
<?php
//--------display categories
echo '<tr style="display:none;"><td class="main"><span class="vdesc">Разделы:</span></td><td class="main">';
$query="select cd.categories_id as id,cd.categories_name as name from ".
	TABLE_CATEGORIES_DESCRIPTION . " cd where cd.language_id = '" . $languages_id . "'";
	if (sizeof($display_cat)>0){
	$query.=" and cd.categories_id in(".implode(',',array_keys($display_cat)).") ";

	}
    $query.=" order by categories_name";
$cq = tep_db_query($query);
if ($cq!==false){
    while ($cres=tep_db_fetch_array($cq)){
	$c_names[$cres['id']]=$cres['name'];
	}
    }
$exclude=array('vPath','filter_id','srmi','srma','srrange');
foreach($_GET as $key=>$value){
    if (in_array($key,$exclude)){continue;}
    if (($key=='sort')&&($value=='products_sort_order')){continue;}
    echo '<input type="hidden" name="'.$key.'" value="'.$value.'">';
    }
echo '<select name="vPath" style="margin:5px;" onchange="this.form.submit()">';
echo '<option value="">Все разделы</option>';
foreach(array_keys($c_names) as $catid){
    echo '<option value="'.$catid.'" ';
    if ((int)$_REQUEST['vPath']==$catid){echo ' selected ';}
    echo '>'.$c_names[$catid].'</option>';
    }
echo '</select></td></tr>';

//---iHolder select manufacturer
      $filterlist_sql= " select distinct mi.manufacturers_id as id, mi.manufacturers_name as name from " . TABLE_MANUFACTURERS_INFO . "  mi where 1=1 ";
      if (sizeof($dmanufacturers)>0){
        $filterlist_sql.= " and  mi.manufacturers_id in (" . implode(',',array_keys($dmanufacturers)) . ")";
        }
      $filterlist_sql.=" and mi.languages_id = '" . (int)$languages_id . "' ";
      $filterlist_sql.= " order by mi.manufacturers_name";
//---iHolder select manufacturer

      $filterlist_query = tep_db_query($filterlist_sql);
      if (tep_db_num_rows($filterlist_query) > 0) {
	echo '<tr><td class="main"><span class="vdesc">Производители:</span></td>';
        echo '<td class="main">';
        $options[]=array('id'=>'','text'=>'Все производители');
        while ($filterlist = tep_db_fetch_array($filterlist_query)) {
          $options[] = array('id' => $filterlist['id'], 'text' => $filterlist['name']);
        }
	$select_style=' style="margin:5px;" ';
	if (!isset($_REQUEST['vPath'])||(strlen($_REQUEST['vPath'])==0)){
	    $select_style.= ' class="disabled"';}
        echo tep_draw_pull_down_menu('filter_id', $options, (isset($_GET['filter_id']) ? $_GET['filter_id'] : ''),$select_style.' onchange="this.form.submit()"');
        echo tep_hide_session_id() . '</td></tr>' . "\n";
      }



PriceSlider($min_price,$max_price);

?>
<tr><td colspan="2">
<table width="100%" cellspacing="0" cellpadding="4" border="0" class="infoBoxContents">
  <tbody><tr>
      <td align="center">
   <input type="image"  alt="Найти подходящие товары" src="/includes/languages/russian/images/buttons/icon_next.gif">
   <a title="Сбросить" href="<?php echo tep_href_link('discount2.php'.(isset($_REQUEST['vls'])?'?vls='.(int)$_REQUEST['vls']:''));?>">
   <img  alt="Сбросить" src="<?php echo DIR_WS_TEMPLATES.TEMPLATE_NAME.'/images/buttons/russian/button_reset.gif';?>">
 </a></td>
</tr>
</tbody></table>
</form>
</td></tr>

        </table></td>
      </tr>
<?php
// BOF: Lango Added for template MOD
if (MAIN_TABLE_BORDER == 'yes'){
$heading_text = $heading_text_box ;
table_image_border_top(false, false, $heading_text);
}
// EOF: Lango Added for template MOD
?>
      <tr>
        <td><?php include(DIR_WS_MODULES . FILENAME_PRODUCT_LISTING_COL); ?></td>
      </tr>

          <tr>
            <td><?php include(DIR_WS_MODULES . FILENAME_FEATURED); ?></td>
          </tr>
          <tr>
            <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
          </tr>
          <tr>
            <td><?php include(DIR_WS_MODULES . FILENAME_NEW_PRODUCTS); ?></td>
          </tr>
<?php
// BOF: Lango Added for template MOD
if (MAIN_TABLE_BORDER == 'yes'){
table_image_border_bottom();
}
// EOF: Lango Added for template MOD
?>

    </table>
<?php
function PriceSlider($min,$max){
//----by iHolder slider---

    $min_max_data=array('min'=>$min,'max'=>$max);

    if (is_array($min_max_data)){
    	    $srmi=ceil($min_max_data['min']);
    	    $price_minimal=$srmi;
    	    $srma=ceil($min_max_data['max']);
    	    $price_maximum=$srma;
    	    }


	if (strlen($_REQUEST['srmi'])>0){$srmi=(int)$_REQUEST['srmi'];}
	if (strlen($_REQUEST['srma'])>0){$srma=(int)$_REQUEST['srma'];}

	$box_text.='<tr><td class="main">';
	$box_text.='<span class="vdesc">Цена:</span></td><td class="main">';
	$box_text.='<div class="srv"><span id="amount">';
	$box_text.='<input  type="text" id="slider-range-min" name="srmi" value="';
	$box_text.=$srmi;
	$box_text.='" size="'.(strlen($srma)).'"> руб.- <input  type="text"  id="slider-range-max" name="srma" value="';
	$box_text.=$srma;
	$box_text.='" size="'.(strlen($srma)).'"> руб.';
	$box_text.='</span>
	<div id="slider-range">
	<input id="slider-range-value" type="hidden" name="srrange" value="0">
	</div></div>';
	echo $box_text;
	?>
	<link rel="stylesheet" type="text/css" href="jscript/jquery/plugins/ui1/jquery-ui.min.css">
	<script type="text/javascript" src="jscript/jquery/plugins/ui1/jquery-ui.min.js"></script>
	<script type="text/javascript">
	   $(function() {
	    function SetPriceValue(){
		$("#slider-range-value").val(parseInt($("#slider-range-min").val())+'-'+
		parseInt($("#slider-range-max").val()));
	    }
	  $("#slider-range-min").keyup(function(){
	    $("#slider-range").slider( "values", [parseInt($("#slider-range-min").val()),parseInt($("#slider-range-max").val())] );
	    SetPriceValue();
	    });
	  $("#slider-range-max").keyup(function(){
	    $("#slider-range").slider( "values", [parseInt($("#slider-range-min").val()),parseInt($("#slider-range-max").val())] );
	    SetPriceValue();
	    });

	  $( "#slider-range" ).slider({
	        range: true,
		 step: 50,
		 min: <?=$price_minimal;?>,
	         max: <?=$price_maximum;?>,
	         values: [ <?=$srmi;?>, <?=$srma;?> ],
	         slide: function( event, ui ) {
	            $("#slider-range-min").val(ui.values[ 0 ]+'-'+ui.values[ 1 ]);
	            $("#slider-range-min").val(ui.values[ 0 ]);
		    $("#slider-range-max").val(ui.values[ 1 ]);
		    $("#slider-range-value").val(ui.values[ 0 ]+'-'+ui.values[ 1 ]);
	          }
	          });
		  $("#slider-range-value").val(  <?=$srmi;?>+ "-" + <?=$srma;?>);
	          });
	    </script>
<?php
echo '</td></tr>';
}
//----by iHolder slider---
?>