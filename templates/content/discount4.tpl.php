  <script src="https://unpkg.com/react@16/umd/react.production.min.js" crossorigin></script>
  <script src="https://unpkg.com/react-dom@16/umd/react-dom.production.min.js" crossorigin></script>

<script>
let data = {
    "id": "JsonRpcClient.js",
    "jsonrpc": "2.0",
    "method": "suggestSettlement",
    "params": {
        "query": "Воронеж",
        "parent": "36000000000",
        "country_code": "RU"
    }
}


let response = await fetch('https://api.shiptor.ru/public/v1', {
  method: 'POST',
  headers: {
    'Content-Type': 'application/json;charset=utf-8',
	'x-authorization-token': 'eaac3392666bd380f49400869d8f6e1c5ed377a5'
  },
  body: JSON.stringify(data)
});

let result = await response.json();
alert(result.message);	
console.log(result);
alert('крюк');

/*console.log(fetch('https://api.shiptor.ru/public/v1', {
  method: 'POST',
  headers: {
  'Content-Type': 'application/json',
  'x-authorization-token': 'eaac3392666bd380f49400869d8f6e1c5ed377a5'
  }
  body: JSON.stringify(data);
}
}).then((response) => response.json())
.then((data) => {
  console.log('Success:', data); 
})
.catch((error) => {
  console.error('Error:', error);
});
return  response.json();
})*/


</script>
    <div class="container">
      <h1>Enter a Word</h1>
      <form id="form" autocomplete="off">
        <input type="text" id="input" value=""></input>
        <button id="submit">SUBMIT</button>
      </form>
	        <div id="responseField">
			
      </div>
    </div>
	

<?php
echo 'Поиск по ID заказа:' . ' ' . tep_draw_input_field('oID', '', 'size="12"') . tep_draw_hidden_field('action', 'edit'); 
$oID = tep_db_prepare_input($_GET['oID']);
$status_zakaza=tep_db_query("select order_status from orders_status_history where orders_id = '" . tep_db_input($oID) . "'");
echo $status_zakaza;
echo "privet";
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
if (!isset($deduction_map)){$deduction_map=GetDeductionMap();}
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

$order_str='';
if (strlen($listing_sql)>0){
    $finder=' order by ';
    $order_str= substr($listing_sql,strpos($listing_sql,$finder),strlen($listing_sql));
}
$listing_sql="select SQL_CALC_FOUND_ROWS p.products_image, pd.products_name,p.products_quantity, p.products_ordered,
    if (p.products_quantity > 0,1,0) as pq , 
    if (p.products_quantity >= 9999,1,0) as ps,  
    if(p.products_quantity < 9999, 1, products_quantity_order_min)  as quantity_order_min,
    if(p.products_quantity < 9999, 1, products_quantity_order_units)  as quantity_order_units,
    p2c.categories_id as categories_id,
    p.products_id, 
    p.manufacturers_id, p.products_price, p.products_sort_order, 
    p.products_tax_class_id  
 from " . TABLE_PRODUCTS . " as p 
  INNER JOIN (SELECT * FROM " . TABLE_PRODUCTS_TO_CATEGORIES . " group by products_id) as  p2c
  ON p.products_status = '1' AND  p.products_quantity > 0 AND p.products_ordered >= 50 AND  p.products_id = p2c.products_id
  INNER JOIN " . TABLE_CATEGORIES . " as c
  ON c.categories_status = '1' AND p2c.categories_id = c.categories_id
  INNER JOIN " . TABLE_PRODUCTS_DESCRIPTION . " as pd
  ON p.products_id = pd.products_id
  
  left join   " . TABLE_MANUFACTURERS_INFO . " mi on mi.manufacturers_id = p.manufacturers_id order by RAND(10)";

/*
"select p.products_image, pd.products_name,p.products_quantity, p.products_ordered,
    if (p.products_quantity > 0,1,0) as pq , 
    if (p.products_quantity >= 9999,1,0) as ps,  
    if(p.products_quantity < 9999, 1, products_quantity_order_min)  as quantity_order_min,
    if(p.products_quantity < 9999, 1, products_quantity_order_units)  as quantity_order_units,
    p2c.categories_id as categories_id,
    p.products_id, 
    p.manufacturers_id, p.products_price, p.products_sort_order	from products as p 
  INNER JOIN (SELECT * FROM products_to_categories group by products_id) as  p2c
  ON p.products_status = '1' AND  p.products_quantity > 0 AND p.products_ordered >= 5 AND  p.products_id = p2c.products_id
  INNER JOIN categories as c
  ON c.categories_status = '1' AND p2c.categories_id = c.categories_id
  INNER JOIN products_description as pd
  ON p.products_id = pd.products_id
  left join manufacturers_info mi on mi.manufacturers_id = p.manufacturers_id order by p.products_ordered desc";
  
  ---->>>
  для категории
  
  select p2c.categories_id as categories_id, p.products_id, 
    p.manufacturers_id, p.products_price, p.products_sort_order  from products as p, categories_description.categories_name as name, categories_description.categories_id as id
  INNER JOIN (SELECT * FROM products_to_categories group by products_id) as  p2c
  ON p.products_status = '1' AND  p.products_quantity > 0 AND p.products_ordered >= 5 AND  p.products_id = p2c.products_id
  INNER JOIN categories as c
  ON c.categories_status = '1' AND p2c.categories_id = c.categories_id
  
*/
  
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
        <?php echo tep_draw_form('filter', tep_href_link(FILENAME_POPS), 'get'); ?>
        <table class="table-padding-0">
        

        
<?php
//--------display categories
//echo '<tr><td class="main"><span class="vdesc">Раздел:</span></td><td class="main">';
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
    //echo '<input type="hidden" name="'.$key.'" value="'.$value.'">';
    }
//echo '<select name="vPath" style="margin:5px;" onchange="this.form.submit()">';
//echo '<option value="">Все разделы</option>';
foreach(array_keys($c_names) as $catid){
  //  echo '<option value="'.$catid.'" ';
    if ((int)$_REQUEST['vPath']==$catid){echo ' selected ';}
   // echo '>'.$c_names[$catid].'</option>';
    }
//echo '</select></td></tr>';







?>

<?php
// BOF: Lango Added for template MOD
if (MAIN_TABLE_BORDER == 'yes'){
$heading_text = $heading_text_box ;
table_image_border_top(false, false, $heading_text);
}
// EOF: Lango Added for template MOD
?>
      <tr>
        <td><?php //include(DIR_WS_MODULES . FILENAME_PRODUCT_LISTING_COL_POPS); ?></td>
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