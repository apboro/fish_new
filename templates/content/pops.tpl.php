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
if (!isset($deduction_map)){$deduction_map=GetDeductionMap2();}
$dproducts=$deduction_map['products'];
$display_cat=$deduction_map['categories'];
$min_price=$deduction_map['min'];
$max_price=$deduction_map['max'];
$dmanufacturers=$deduction_map['manufacturers'];

if (sizeof($dproducts)==0){
    ?>
    <p>Не найдено</p>
    <script type="text/javascript">
    window.history.go(-1);
    </script>
    <?
    return;
    }
//unset( $_GET[ 'email_address' ] );
//unset( $_GET[ 'password' ] );
$zapros=$_GET['val'];
$order_str='order by p.products_ordered desc';
if (strlen($listing_sql)>0){
    $finder=' order by p.products_ordered desc';
    $order_str= substr($listing_sql,strpos($listing_sql,$finder),strlen($listing_sql));
}
$listing_sql='select SQL_CALC_FOUND_ROWS p.products_image, p.products_ordered, pd.products_name,p.products_quantity,
    if (p.products_quantity>0,1,0) as pq , 
    if (p.products_quantity>=9999,1,0) as ps,  
    if(p.products_quantity < 9999, 1, products_quantity_order_min)  as quantity_order_min,
    if(p.products_quantity < 9999, 1, products_quantity_order_units)  as quantity_order_units,
    if (c.parent_id=0, c.categories_id, c.parent_id) as categories_id,
    p.products_model,
    pd.products_info,
    p.products_id, 
    p.manufacturers_id, p.products_price, p.products_sort_order, 
    p.products_tax_class_id, IF(s.status, s.specials_new_products_price, NULL) as specials_new_products_price, 
    IF(s.status, s.specials_new_products_price, p.products_price) as final_price 
'."from " . TABLE_PRODUCTS . " p 
  INNER JOIN (SELECT * FROM " . TABLE_PRODUCTS_TO_CATEGORIES . " group by products_id) as  p2c
  ON p.products_status = '1' AND p.products_ordered>6 AND  p.products_quantity > 0 AND  p.products_id = p2c.products_id
  INNER JOIN " . TABLE_CATEGORIES . " as c
  ON c.categories_status = '1' AND p2c.categories_id = c.categories_id
  INNER JOIN " . TABLE_PRODUCTS_DESCRIPTION . " as pd
  ON p.products_id = pd.products_id AND pd.products_name LIKE '%" . $zapros. "%'
  left join  " . TABLE_PRODUCTS_TO_PRODUCTS_EXTRA_FIELDS . " p2pef on p.products_id = p2pef.products_id
  left join   " . TABLE_MANUFACTURERS_INFO . " mi on mi.manufacturers_id = p.manufacturers_id
  left join " . TABLE_SPECIALS . " s on p.products_id = s.products_id Where true";




  /*ЗАПРОС В SQL ВИДЕ
  select SQL_CALC_FOUND_ROWS p.products_image, p.products_ordered, pd.products_name, p.products_quantity,
    if (p.products_quantity>0,1,0) as pq , 
    if (p.products_quantity>=9999,1,0) as ps,  
    if(p.products_quantity < 9999, 1, products_quantity_order_min)  as quantity_order_min,
    if(p.products_quantity < 9999, 1, products_quantity_order_units)  as quantity_order_units,
    p2c.categories_id as categories_id,
    p.products_model,
    pd.products_info, 
    p.products_id, 
    p.manufacturers_id, p.products_price, p.products_sort_order, IF(s.status, s.specials_new_products_price, NULL) as specials_new_products_price, 
    IF(s.status, s.specials_new_products_price, p.products_price) as final_price 
from products p 
  INNER JOIN (SELECT * FROM products_to_categories group by products_id) as  p2c
  ON p.products_status = '1' AND  p.products_quantity > 0 AND p.products_ordered >6 AND  p.products_id = p2c.products_id
  INNER JOIN categories as c
  ON c.categories_status = '1' AND p2c.categories_id = c.categories_id 
  INNER JOIN products_description as pd
  ON p.products_id = pd.products_id AND pd.products_name LIKE '%спиннинг%'
  left join  products_to_products_extra_fields  p2pef on p.products_id = p2pef.products_id
  left join   manufacturers_info  mi on mi.manufacturers_id = p.manufacturers_id
  left join specials s on p.products_id = s.products_id Where true
  order by pq desc,ps asc,p.products_sort_order, pd.products_name asc
  */


if (sizeof($dproducts)>0){
   // $listing_sql.='    and p.products_id in ('.implode(',',array_keys($dproducts)).')';
    } 
if (strlen($order_str)>0){$listing_sql.=$order_str;}else{
//    $listing_sql.=' order by pq desc,p.products_price,p.products_sort_order, pd.products_name asc';
    $listing_sql.=' order by p.products_ordered desc';
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

        <?php echo tep_draw_form('test', tep_href_link(FILENAME_POPS), 'get'); ?>
        <table class="table-padding-0">
            <script type="text/javascript">
                console.log('hello');
                var x= '<?php echo $_GET['val']; ?>'

                    console.log(document.getElementById('select1'));
                    console.log(x);
            </script>
<?php


//--------display categories
echo '<center><font color="#3366ff" size="4em">САМЫЕ ЗАКАЗЫВАЕМЫЕ ТОВАРЫ НАШЕГО МАГАЗИНА</font></center><br>';

echo '<tr><center><span class="vdesc">КАТЕГОРИЯ</span></center></tr>';

echo '<tr><center><select id="select1" name="val" style="margin:5px;" onchange="this.form.submit()"></center>';
echo '<option value="">Все разделы</option>';
echo '<option value="Воблер">Воблеры</option>';
echo '<option value="Блесна">Блесны</option>';
echo '<option value="Катушка">Катушки</option>';
echo '<option value="Спиннинг">Спиннинги</option>';
echo '<option value="фидерное удилище">Фидеры</option>';
echo '<option value="bolognese">Удочки</option>';
echo '<option value="Поплавок">Поплавки</option>';
echo '<option value="плетен">Плетёнки</option>';
echo '</select></td></tr></form>'; 
//unset($_GET['val']);

?>


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
        <td><?php include(DIR_WS_MODULES . FILENAME_PRODUCT_LISTING_COL_POPS); ?></td>
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