<?php
/*
autocreated script
*/
  require('includes/application_top.php');


?>
    <?php

  include(DIR_FS_CATALOG.DIR_WS_LANGUAGES . $language . '/' . FILENAME_DISCOUNT);
/*  if (!isset($_GET['sort'])){
    $_GET['sort']='products_sort_order';
    }else{
    if ($_GET['sort']=='products_sort_order'){tep_redirect(FILENAME_DISCOUNT);}
    }
*/
if ($_SESSION['pvpath']<>(int)$_REQUEST['vPath']){
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
/*        unset($_GET['srmi']);
        unset($_GET['srma']);
        unset($_REQUEST['srmi']);
        unset($_REQUEST['srma']);*/
}


// create column list
  $define_list = array ('PRODUCT_LIST_MODEL' => PRODUCT_LIST_MODEL,
                        'PRODUCT_LIST_NAME' => PRODUCT_LIST_NAME,
                        'PRODUCT_LIST_MANUFACTURER' => PRODUCT_LIST_MANUFACTURER,
                        'PRODUCT_LIST_PRICE' => PRODUCT_LIST_PRICE,
                        'PRODUCT_LIST_QUANTITY' => PRODUCT_LIST_QUANTITY,
                        'PRODUCT_LIST_WEIGHT' => PRODUCT_LIST_WEIGHT,
                        'PRODUCT_LIST_IMAGE' => PRODUCT_LIST_IMAGE,
                        'PRODUCT_LIST_BUY_NOW' => PRODUCT_LIST_BUY_NOW);

  asort ($define_list);
  $column_list = array();
  reset ($define_list);
  while (list ($key, $value) = each ($define_list) ) {
    if ($value > 0) $column_list[] = $key;
  }
$listing_sql='';
    if ( (!isset($_GET['sort'])) || (!preg_match('/[1-8][ad]/', $_GET['sort'])) || (substr($_GET['sort'], 0, 1) > sizeof($column_list)) ) {
      for ($i=0, $n=sizeof($column_list); $i<$n; $i++) {
        if ($column_list[$i] == 'PRODUCT_LIST_NAME') {
            $_GET['sort'] = 'p';
	    $listing_sql .= " order by RAND() ";
          break;
        }
      }
    } else {
      $sort_col = substr($_GET['sort'], 0 , 1);
      $sort_order = substr($_GET['sort'], 1);
      switch ($column_list[$sort_col-1]) {
        case 'PRODUCT_LIST_MODEL':
          $listing_sql .= " order by pq desc,ps asc,p.products_model " . ($sort_order == 'd' ? 'desc' : '') . ", pd.products_name";
          break;
        case 'PRODUCT_LIST_NAME':
          $listing_sql .= " order by pq desc,ps asc,pd.products_name " . ($sort_order == 'd' ? 'desc' : '');
          break;
        case 'PRODUCT_LIST_MANUFACTURER':
// BOF manufacturers descriptions
//        $listing_sql .= "m.manufacturers_name " . ($sort_order == 'd' ? 'desc' : '') . ", pd.products_name";
          $listing_sql .= "order by pq desc,ps asc,mi.manufacturers_name " . ($sort_order == 'd' ? 'desc' : '');
// EOF manufacturers descriptions
          break;
        case 'PRODUCT_LIST_QUANTITY':
          $listing_sql .= " order by pq desc,ps asc,p.products_quantity " . ($sort_order == 'd' ? 'desc' : '') . ", pd.products_name";
          break;
        case 'PRODUCT_LIST_IMAGE':
          $listing_sql .= " order by pq desc,ps asc,pd.products_name";
          break;
        case 'PRODUCT_LIST_WEIGHT':
          $listing_sql .= " order by pq desc,ps asc,p.products_weight " . ($sort_order == 'd' ? 'desc' : '') . ", pd.products_name";
          break;
        case 'PRODUCT_LIST_PRICE':
          $listing_sql .= " order by pq desc,ps asc,final_price " . ($sort_order == 'd' ? 'desc' : '') . ", pd.products_name";
          break;
        case 'PRODUCT_SORT_ORDER':
          $listing_sql .= " order by pq desc,ps asc,p.products_sort_order " . ($sort_order == 'd' ? "desc" : '') . ", pd.products_name";
          break;
        default:
          $listing_sql .= " order by pq desc,ps asc,p.products_sort_order, pd.products_name asc";
          break;
      } 
    }






  $content = 'discount';


?>  
<?php
  require(DIR_WS_INCLUDES . 'template_top.php');
?>
<div class="contentContainer">
    <div class="contentText">
<?php

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
        <?php echo tep_draw_form('filter', tep_href_link(FILENAME_DISCOUNT), 'get'); ?>
        <table class="table-padding-0">
<?php
//--------display categories
echo '<tr><td class="main"><span class="vdesc">Разделы:</span></td><td class="main">';
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
<?php
if (IS_MOBILE==1){
 echo tep_draw_button("Применить");
    }else{
?>
   <input type="image"  alt="Найти подходящие товары" src="/includes/languages/russian/images/buttons/icon_next.gif">
<?php }?>
<?php
if (IS_MOBILE==1){
echo '<span style="display:inline-block;width:10px;height:auto;"></span>';
echo tep_draw_button("Сбросить",null,
	tep_href_link(FILENAME_DISCOUNT.(isset($_REQUEST['vls'])?'?vls='.(int)$_REQUEST['vls']:'')),
	null,array('type'=>'submit')
	);
    }else{
/*
?>
<!--   <a title="Сбросить" href="<?php echo tep_href_link(FILENAME_DISCOUNT.(isset($_REQUEST['vls'])?'?vls='.(int)$_REQUEST['vls']:''));?>">
   <img  alt="Сбросить" src="<?php echo DIR_WS_TEMPLATES.TEMPLATE_NAME.'/images/buttons/russian/button_reset.gif';?>">
-->
<?php
*/
}
?>

 </a>
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
        <td><?php 
	if (IS_MOBILE==0){
        include(DIR_WS_MODULES . FILENAME_PRODUCT_LISTING_COL); }
        else{
	include(DIR_WS_MODULES . FILENAME_PRODUCT_LISTING);         
        }
        ?></td>
      </tr>
<?php /* ?>
          <tr>
            <td><?php include(DIR_WS_MODULES . FILENAME_FEATURED); ?></td>
          </tr>          
          <tr>
            <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
          </tr>
          <tr>
            <td><?php include(DIR_WS_MODULES . FILENAME_NEW_PRODUCTS); ?></td>
          </tr>
<?php */?>
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
<!--	<div id="slider-range">
	<input id="slider-range-value" type="hidden" name="srrange" value="0">
	</div>
	-->
	</div>';
	echo $box_text;
	?>

	<link rel="stylesheet" type="text/css" href="jscript/jquery/plugins/ui1/jquery-ui.min.css"> 
	<script type="text/javascript" src="jscript/jquery/plugins/ui1/jquery-ui.min.js"></script> 
	<script type="text/javascript">
	   jQuery(function() {
	    function SetPriceValue(){
		jQuery("#slider-range-value").val(parseInt(jQuery("#slider-range-min").val())+'-'+
		parseInt(jQuery("#slider-range-max").val()));
	    }
	  jQuery("#slider-range-min").keyup(function(){
	    jQuery("#slider-range").slider( "values", [parseInt(jQuery("#slider-range-min").val()),parseInt(jQuery("#slider-range-max").val())] );
	    SetPriceValue();
	    });
	  jQuery("#slider-range-max").keyup(function(){
	    jQuery("#slider-range").slider( "values", [parseInt(jQuery("#slider-range-min").val()),parseInt(jQuery("#slider-range-max").val())] );
	    SetPriceValue();
	    });

	  jQuery( "#slider-range" ).slider({
	        range: true,
		 step: 1,
		 min: <?=$price_minimal;?>,
	         max: <?=$price_maximum;?>,
	         values: [ <?=$srmi;?>, <?=$srma;?> ],
	         slide: function( event, ui ) {
	            jQuery("#slider-range-min").val(ui.values[ 0 ]+'-'+ui.values[ 1 ]);
	            jQuery("#slider-range-min").val(ui.values[ 0 ]);
		    jQuery("#slider-range-max").val(ui.values[ 1 ]);	
		    jQuery("#slider-range-value").val(ui.values[ 0 ]+'-'+ui.values[ 1 ]);
	          }
	          });
		  jQuery("#slider-range-value").val(  <?=$srmi;?>+ "-" + <?=$srma;?>);
	          });
	    </script>
<?php
echo '</td></tr>';
}
//----by iHolder slider---
?>
</div>
</div>
<?php
  require(DIR_WS_INCLUDES . 'template_bottom.php');
  require(DIR_WS_INCLUDES . 'application_bottom.php');
?>
