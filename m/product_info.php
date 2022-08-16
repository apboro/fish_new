<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2013 osCommerce

  Released under the GNU General Public License
*/
  require('includes/application_top.php');
  if (!isset($HTTP_GET_VARS['products_id'])) {
    tep_redirect(tep_href_link(FILENAME_DEFAULT));
  }
$ajax_load=isset($_GET['ajax']);
if (isset($_GET['ajax'])){unset($_GET['ajax']);}
if (!$ajax_load){
  require(DIR_WS_INCLUDES . 'template_top.php');
  require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_PRODUCT_INFO);
  ?><base href="<?php echo (($request_type == 'SSL') ? HTTPS_SERVER : HTTP_SERVER) . DIR_WS_CATALOG; ?>">
<link rel="stylesheet" type="text/css" href="/ext/css/m_stylesheet.css">
<style type="text/css">
  .fa-spinner:before {
    content: "\f110";
}
#piGal {margin: 0 auto; width: auto;}
#piGal img {height: auto; max-width: 100% !important;width: 100% !important;}
#lightbox { top:200px !important; }

#piGal a:first-child {
    border: medium none;
    float: left;
    height: auto;
    width: 100% !important;
}
#piGal a {
    border: 1px solid #eee;
    float: left;
    height: auto;
    margin: 1%;
    width: 30%;
	height:100px;
}
</style>
<script language="javascript"><!--
function popupWindow(url) {
  window.open(url,'popupWindow','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=no,resizable=yes,copyhistory=no,width=100,height=100,screenX=150,screenY=150,top=150,left=150')
}
//--></script>

<link rel="stylesheet" href="lightbox/lightbox.css" type="text/css" media="screen" />
<script type="text/javascript" src="lightbox/prototype.js"></script>
<script type="text/javascript" src="lightbox/scriptaculous.js?load=effects"></script>
<script type="text/javascript" src="lightbox/builder.js"></script>
<script type="text/javascript" src="lightbox/lightbox.js"></script>
<?php
}//------if ajax-load
  $product_check_query = tep_db_query("select count(*) as total from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd where p.products_status = '1' and p.products_id = '" . (int)$HTTP_GET_VARS['products_id'] . "' and pd.products_id = p.products_id and pd.language_id = '" . (int)$languages_id . "'");
  $product_check = tep_db_fetch_array($product_check_query);

//  require(DIR_WS_INCLUDES . 'template_top.php');
 if ($product_check['total'] < 1) {
?>



<div class="contentContainer">
  <div class="contentText">
    <?php echo TEXT_PRODUCT_NOT_FOUND; ?>
  </div>

  <div style="float: right;">
    <?php echo tep_draw_button(IMAGE_BUTTON_CONTINUE, 'triangle-1-e', tep_href_link(FILENAME_DEFAULT)); ?>
  </div>
</div>

<?php
  } else {
    $product_info_query = tep_db_query("select p.products_id, pd.products_name, pd.products_info, pd.products_description, p.products_model, p.products_quantity, p.products_image, pd.products_url, p.products_price, p.products_tax_class_id, p.products_date_added, p.products_date_available, p.manufacturers_id from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd where p.products_status = '1' and p.products_id = '" . (int)$HTTP_GET_VARS['products_id'] . "' and pd.products_id = p.products_id and pd.language_id = '" . (int)$languages_id . "'");
    $product_info = tep_db_fetch_array($product_info_query);

    tep_db_query("update " . TABLE_PRODUCTS_DESCRIPTION . " set products_viewed = products_viewed+1 where products_id = '" . (int)$HTTP_GET_VARS['products_id'] . "' and language_id = '" . (int)$languages_id . "'");

    if ($new_price = tep_get_products_special_price($product_info['products_id'])) {
      $products_price = '<del>' . $currencies->display_price_nodiscount($product_info['products_price'], tep_get_tax_rate($product_info['products_tax_class_id'])) . '</del> <span class="productSpecialPrice">' . $currencies->display_price_nodiscount($new_price, tep_get_tax_rate($product_info['products_tax_class_id'])) . '</span>';
    } else {
      $products_price = $currencies->display_price($product_info['products_price'], tep_get_tax_rate($product_info['products_tax_class_id']));
    }

    if (tep_not_null($product_info['products_model'])) {
      $products_name = $product_info['products_name'] . '<span class="smallText">[' . $product_info['products_model'] . ']</span>';
    } else {
      $products_name = $product_info['products_name'];
    }
?>

<?php 
echo tep_draw_form('cart_quantity_pi', tep_href_link(FILENAME_PRODUCT_INFO, tep_get_all_get_params(array('action','ajax')) . 'action=add_product')); ?>
<div class="mj-productinfo">
    <div>
      <h2 class="mj-productheading"><?php echo $products_name; ?></h2>
    </div>

	<div class="contentContainer">
  		<div class="contentText">
			<div class="mj-product_infoleft">
<?php
    if (tep_not_null($product_info['products_image'])) {
      $photoset_layout = '1';

//      $pi_query = tep_db_query("select image, htmlcontent from " . TABLE_PRODUCTS_IMAGES . " where products_id = '" . (int)$product_info['products_id'] . "' order by sort_order");
$pi_query_sql='
select products_image as simage,products_image_lrg as image from products where length(products_image)>0 and  products_id='. (int)$product_info['products_id'] .'
union 
select products_image_sm_1 as simage, products_image_xl_1 as image from products where length(products_image_sm_1)>0 and  products_id='. (int)$product_info['products_id'] .'
union 
select products_image_sm_2 as simage, products_image_xl_2 as image from products where length(products_image_sm_2)>0 and  products_id='. (int)$product_info['products_id'] .'
union 
select  products_image_sm_3 as simage,products_image_xl_3 as image from products where length(products_image_sm_3)>0 and  products_id='. (int)$product_info['products_id'] .'
union 
select  products_image_sm_4 as simage,products_image_xl_4 as image from products where length(products_image_sm_4)>0 and  products_id='. (int)$product_info['products_id'] .'
union 
select  products_image_sm_5 as simage,products_image_xl_5 as image from products where length(products_image_sm_5)>0 and  products_id='. (int)$product_info['products_id'] .'
union 
select  products_image_sm_6 as simage,products_image_xl_6 as image from products where length(products_image_sm_6)>0 and  products_id='. (int)$product_info['products_id'] .'
';
//echo $pi_query_sql;
$pi_query=tep_db_query($pi_query_sql);
      $pi_total = tep_db_num_rows($pi_query);
//echo $pi_total;exit;
      if ($pi_total > 0) {
        $pi_sub = $pi_total-1;

        while ($pi_sub > 5) {
          $photoset_layout .= 5;
          $pi_sub = $pi_sub-5;
        }

        if ($pi_sub > 0) {
          $photoset_layout .= ($pi_total > 5) ? 5 : $pi_sub;
        }
?>

    <div id="piGal">

<?php
        $pi_counter = 0;
        $pi_html = array();

        while ($pi = tep_db_fetch_array($pi_query)) {
          $pi_counter++;
          if (tep_not_null($pi['htmlcontent'])) {
            $pi_html[] = '<div id="piGalDiv_' . $pi_counter . '">' . $pi['htmlcontent'] . '</div>';
          }
          echo '<a href="' . tep_href_link(DIR_WS_IMAGES . $pi['image'], '', 'NONSSL', false) . '" target="_blank" rel="cbox">'. tep_image(DIR_WS_IMAGES . $pi['simage'], '', '', '', 'id="piGalImg_' . $pi_counter . '" '). '</a>';
        }
?>

    </div>

<?php
        if ( !empty($pi_html) ) {
          echo '    <div style="display: none;">' . implode('', $pi_html) . '</div>';
        }
      } else {
?>

    <div id="piGal">
      <?php echo '<a href="' . tep_href_link(DIR_WS_IMAGES . $product_info['products_image'], '', 'NONSSL', false) . '" target="_blank" rel="cbox">'.tep_image(DIR_WS_IMAGES . $product_info['products_image'], addslashes($product_info['products_name'])). '</a>'; ?>
    </div>

<?php
      }
    }
?>

<script type="text/javascript">
/*jQuery(document).ready(function(){
jQuery('#piGal a').css('maxHeight','95%');
jQuery('#piGal a').css('maxWidth','95%');
})*/

jQuery(function() {
jQuery("#piGal a").colorbox({maxWidth:'95%',maxHeight:'95%'});
});

</script>



</div>
	  
      	<div class="mj-product_inforight">
            <div class="product_title">
            	<h3 class="mj-productdescname"><?php echo $products_name; ?></h3>
            </div>
            
            <div class="product_price">
                	<h4 class="optionName">
                    	<label><?php echo TEXT_PRODINFO_PRICE; ?></label>
                   	</h4>
                    <div class="price_amount" style="display: inline-block;">
						<span class="price_amount"><?php echo $products_price; ?></span>
                    </div>
            </div>
            <div class="cartadd">
            <?php
    $products_attributes_query = tep_db_query("select count(*) as total from " . TABLE_PRODUCTS_OPTIONS . " popt, " . TABLE_PRODUCTS_ATTRIBUTES . " patrib where patrib.products_id='" . (int)$HTTP_GET_VARS['products_id'] . "' and patrib.options_id = popt.products_options_id and popt.language_id = '" . (int)$languages_id . "'");
    $products_attributes = tep_db_fetch_array($products_attributes_query);
    if ($products_attributes['total'] > 0) {
?>

    <!--<p><?php //echo TEXT_PRODUCT_OPTIONS; ?></p>-->
        <div id="productAttributes">
<?php 
 
          $products_options_name_query = tep_db_query("select distinct popt.products_options_id, popt.products_options_name from " . TABLE_PRODUCTS_OPTIONS . " popt, " . TABLE_PRODUCTS_ATTRIBUTES . " patrib where patrib.products_id='" . (int)$HTTP_GET_VARS['products_id'] . "' and patrib.options_id = popt.products_options_id and popt.language_id = '" . (int)$languages_id . "' order by popt.products_options_name");
          while ($products_options_name = tep_db_fetch_array($products_options_name_query)) {
		  
                $products_options_array = array();
                $products_options_query = tep_db_query("select pov.products_options_values_id, pov.products_options_values_name, pa.options_values_price, pa.price_prefix from " . TABLE_PRODUCTS_ATTRIBUTES . " pa, " . TABLE_PRODUCTS_OPTIONS_VALUES . " pov where pa.products_id = '" . (int)$HTTP_GET_VARS['products_id'] . "' and pa.options_id = '" . (int)$products_options_name['products_options_id'] . "' and pa.options_values_id = pov.products_options_values_id and pov.language_id = '" . (int)$languages_id . "'");
				
                while ($products_options = tep_db_fetch_array($products_options_query)) {
				
                  $products_options_array[] = array('id' => $products_options['products_options_values_id'], 'text' => $products_options['products_options_values_name']);
                  if ($products_options['options_values_price'] != '0') {
                        $products_options_array[sizeof($products_options_array)-1]['text'] .= ' (' . $products_options['price_prefix'] . $currencies->display_price($products_options['options_values_price'], tep_get_tax_rate($product_info['products_tax_class_id'])) .') ';
                  }
                }
				
				
				
                if (isset($cart->contents[$HTTP_GET_VARS['products_id']]['attributes'][$products_options_name['products_options_id']])) {
                  $selected_attribute = $cart->contents[$HTTP_GET_VARS['products_id']]['attributes'][$products_options_name['products_options_id']];
                } else {
                  $selected_attribute = false;
                }
        
 
?>
              
      <div class="attribsoptions"><h4 class="optionName"><?php echo $products_options_name['products_options_name'] . ':'; ?></h4><div class="product_attributes"><?php echo tep_draw_pull_down_menu('id[' . $products_options_name['products_options_id'] . ']', $products_options_array, $selected_attribute); ?></div></div>
<?php
      }
?>
    </div>

<?php
    }
?>


<?php
    if ($product_info['products_date_available'] > date('Y-m-d H:i:s')) {
?>

    <p style="text-align: center;"><?php echo sprintf(TEXT_DATE_AVAILABLE, tep_date_long($product_info['products_date_available'])); ?></p>

<?php
    }
?>
<div class="cart_info" >

<?php if ($product_info['products_quantity']>0){?>
<div class="cart_quantity">
    <?php 
      $order_min=(tep_get_products_quantity_order_min($_GET['products_id'])); 
       if ($products_options_total['total'] != 1) { 
        echo '<strong>'.TEXT_QUANTITY;
	    if ($order_min>1){echo '<br>Минимум:'.$order_min;}
        echo '</strong> ';
        echo  tep_draw_input_field('cart_quantity',$order_min,'size="3" style="float:right" ') . ' ' ; } 
       
       ?>
</div>
<?php }?>

</div>
<?php
if ($product_info['products_quantity']<9999)
                {
            if ($product_info['products_quantity']>0)
            {echo '<p class="instore">В наличии</p>';}
        }else{
    echo '<p class="instore">В наличии</p>';
            }

 if ($product_info['products_quantity']>0){?>
			   <div class="cart_button" style="float:left;position: relative;">

  
   
    
          <i class="fa" style="display: none;width: 10px; height: 10px;position: absolute;left: 155px;top: 15px;color: #3692CA;"></i>
			   		<?php echo tep_draw_hidden_field('products_id', $product_info['products_id']) . tep_draw_button(IMAGE_BUTTON_IN_CART, 'cart', null, 'primary'); ?>
 			   </div>

         <script type="text/javascript">
           jQuery('.cart_button').click(function(){
              jQuery('.cart_button i').css('display','block').addClass('fa-spin fa-spinner');
              setTimeout(function(){
                  jQuery('.cart_button i').css('display','none');
              },500);
           });
         </script>
<?php }else{ 
echo '<div style="width:100%;">';
echo tep_image(DIR_WS_IMAGES.'nopmob.png');
//echo '<span class="product_title noproduct">Временно отсутствует</span><br>';
echo '<br><a class="thesame" href="'.$breadcrumb->_trail[1]['link'].'">Похожие снасти в наличии</a>';
echo '</div>';
}
?>
<!--            </div> -->
       </div>
     	</div>

</div>

<?php
    $reviews_query = tep_db_query("select count(*) as count from " . TABLE_REVIEWS . " r, " . TABLE_REVIEWS_DESCRIPTION . " rd where r.products_id = '" . (int)$HTTP_GET_VARS['products_id'] . "' and r.reviews_id = rd.reviews_id and rd.languages_id = '" . (int)$languages_id . "' and status_otz = 1");
    $reviews = tep_db_fetch_array($reviews_query);
?>

</div>


    <div class="mj_prodinfo_tabcontent">
     <ul class="tabs" data-persist="true">
            <li><a href="#view1"><span class="title"><?php echo TEXT_TABS_DESCRIPTION; ?></span></a></li>
            <li><a href="#view2"><span class="title"><?php echo TEXT_TABS_REVIEWS; ?></span></a></li>
        </ul>
        <div class="tabcontents">
            <div id="view1">

            <?php echo TransformDescription(stripslashes($product_info['products_info'])); 
    	          echo TransformDescription(stripslashes($product_info['products_description'])); ?>
            
            </div>
            <div id="view2">
              <div class="mj-productreviewlink">
			<?php if($reviews['count'] == 0){
					 echo '<p>' . TEXT_NO_REVIEWS . '</p>';
					 echo tep_draw_button(IMAGE_BUTTON_WRITE_REVIEW, 'comment', tep_href_link(FILENAME_PRODUCT_REVIEWS_WRITE, tep_get_all_get_params()), 'primary');
				}
				else{
					echo tep_draw_button(IMAGE_BUTTON_REVIEWS . (($reviews['count'] > 0) ? ' (' . $reviews['count'] . ')' : ''), 
					'comment', tep_href_link(FILENAME_PRODUCT_REVIEWS, tep_get_all_get_params())); 
				}
			?></div>        
            </div>
        </div>
        
    </div>
<?php if ($ajax_load){?>
<div class="qvstep"><a href="<?php echo tep_href_link(FILENAME_PRODUCT_INFO, tep_get_all_get_params(array('action','ajax')))?>">Перейти на страницу товара</a></div>
<?php } ?>
    <script type="text/javascript" src="/ext/jquery/mj_tabcontent.js"></script>	
        <?php
    if ((USE_CACHE == 'true') && empty($SID)) {
      echo tep_cache_also_purchased(3600);
    } else {
//      include(DIR_WS_MODULES . FILENAME_ALSO_PURCHASED_PRODUCTS);
    }
?>
</div>
  
</form>

 
<?php
  }
if (!$ajax_load){
  require(DIR_WS_INCLUDES . 'template_bottom.php');
}else{
?>
	<script type="text/javascript" src="/ext/script/internal.js"></script>
    <script type="text/javascript">
        jQuery('.tabcontents div[id^="view"]').css('display','none');
        jQuery('.tabcontents div[id^="view"]:first-child').css('display','block');
	jQuery("ul.tabs li a").click(function(e){
	    e.preventDefault();
	    var $tab=jQuery(this).attr("href");
	    jQuery('.tabcontents div[id^="view"]').css('display','none');
	    jQuery($tab).css('display','block');
	    
	    });
    </script>
<?php
}
  require(DIR_WS_INCLUDES . 'application_bottom.php');

?>
<?php //echo Display1Click('superfast.png');?>
