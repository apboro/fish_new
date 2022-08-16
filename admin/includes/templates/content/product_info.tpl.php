<?php echo tep_draw_form('cart_quantity', tep_href_link(FILENAME_PRODUCT_INFO, tep_get_all_get_params(array('action')) . 'action=add_product')); ?>
<table border="0" width="100%" cellspacing="0" cellpadding="<?php echo CELLPADDING_SUB;?>">
<?php
  if ($product_check['total'] < 1) {
?>
      <tr>
        <td><?php new infoBox(array(array('text' => TEXT_PRODUCT_NOT_FOUND))); ?></td>
      </tr>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBox">
          <tr class="infoBoxContents">
            <td><table class="table-padding-2">
              <tr>
                <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
                <td align="right"><?php echo '<a href="' . tep_href_link(FILENAME_DEFAULT) . '">' . tep_template_image_button('button_continue.gif', IMAGE_BUTTON_CONTINUE) . '</a>'; ?></td>
                <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
              </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>
<?php
  } else {
// BOF MaxiDVD: Modified For Ultimate Images Pack!
    $product_info_query = tep_db_query("select p.products_id, pd.products_name, pd.products_description, p.products_model, p.products_quantity, p.products_image, p.products_image_med, p.products_image_lrg, p.products_image_sm_1, p.products_image_xl_1, p.products_image_sm_2, p.products_image_xl_2, p.products_image_sm_3, p.products_image_xl_3, p.products_image_sm_4, p.products_image_xl_4, p.products_image_sm_5, p.products_image_xl_5, p.products_image_sm_6, p.products_image_xl_6, pd.products_url, p.products_price, p.products_tax_class_id, p.products_date_added, p.products_date_available, p.manufacturers_id, pd.products_tab_1, pd.products_tab_2, pd.products_tab_3, pd.products_tab_4, pd.products_tab_5, pd.products_tab_6 from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd where p.products_status = '1' and p.products_id = '" . (int)$_GET['products_id'] . "' and pd.products_id = p.products_id and pd.language_id = '" . (int)$languages_id . "'");
// EOF MaxiDVD: Modified For Ultimate Images Pack!
    $product_info = tep_db_fetch_array($product_info_query);

    tep_db_query("update " . TABLE_PRODUCTS_DESCRIPTION . " set products_viewed = products_viewed+1 where products_id = '" . (int)$_GET['products_id'] . "' and language_id = '" . (int)$languages_id . "'");

	//TotalB2B start
	$product_info['products_price'] = tep_xppp_getproductprice($product_info['products_id']);
    //TotalB2B end

    if ($new_price = tep_get_products_special_price($product_info['products_id'])) {
      
      //TotalB2B start
//	  $query_special_prices_hide = tep_db_query("select configuration_value from " . TABLE_CONFIGURATION . " WHERE configuration_key = 'SPECIAL_PRICES_HIDE'");
//      $query_special_prices_hide_result = tep_db_fetch_array($query_special_prices_hide); 
      $query_special_prices_hide_result = SPECIAL_PRICES_HIDE; 
      if ($query_special_prices_hide_result == 'true') {
	 	$products_price = '<span class="productSpecialPrice">' . $currencies->display_price_nodiscount($new_price, tep_get_tax_rate($product_info['products_tax_class_id'])) . '</span>'; 
	  } else {
	    $products_price = '<s>' . $currencies->display_price_nodiscount($product_info['products_price'], tep_get_tax_rate($product_info['products_tax_class_id'])) . '</s> <span class="productSpecialPrice">' . $currencies->display_price_nodiscount($new_price, tep_get_tax_rate($product_info['products_tax_class_id'])) . '</span>';
	  }
      //TotalB2B end

    } else {
      $products_price = $currencies->display_price($product_info['products_price'], tep_get_tax_rate($product_info['products_tax_class_id']));
    }


//    if ($new_price = tep_get_products_special_price($product_info['products_id'])) {
//      $products_price = '<s>' . $currencies->display_price($product_info['products_price'], tep_get_tax_rate($product_info['products_tax_class_id'])) . '</s> <span class="productSpecialPrice">' . $currencies->display_price($new_price, tep_get_tax_rate($product_info['products_tax_class_id'])) . '</span>';
//    } else {
//      $products_price = $currencies->display_price($product_info['products_price'], tep_get_tax_rate($product_info['products_tax_class_id']));
//    }


//    if (tep_not_null($product_info['products_model'])) {
//      $products_name = $product_info['products_name'] . '<br><span class="smallText">[' . $product_info['products_model'] . ']</span>';
//    } else {
//      $products_name = $product_info['products_name'];
//    }

    if (tep_not_null($product_info['products_model'])) {
      $products_name = $product_info['products_name'];
    } else {
      $products_name = $product_info['products_name'];
    }
    
//DISPLAY PRODUCT WAS ADDED TO WISHLIST IF WISHLIST REDIRECT IS ENABLED
 if(tep_session_is_registered('wishlist_id')) {
 ?>
 <tr>     
 <td class="messageStackSuccess"><?php echo PRODUCT_ADDED_TO_WISHLIST; ?></td>
 </tr>
<?php
 tep_session_unregister('wishlist_id');
 }    
?>

<?php
// BOF: WebMakers.com Added: Show Featured Products
if (SHOW_HEADING_TITLE_ORIGINAL=='yes') {
$header_text = '&nbsp;';
?>
      <tr>
        <td><table class="table-padding-0">
          <tr>
            <td class="pageHeading" valign="top"><?php echo $products_name; ?></td>
            <td class="pageHeading" align="right" valign="top"><?php echo $products_price; ?></td>
          </tr>
<?php
if ( ($error_cart_msg) ) {
?>
      <tr>
        <td colspan="2" align="right" class="QtyErrors"><br><?php echo tep_output_warning($error_cart_msg); ?></td>
      </tr>
<?php
}
$error_cart_msg='';
?>

      <tr>
        <td colspan="2" align="right" class="main">
<?php
  require(DIR_WS_INCLUDES . 'products_next_previous.php');
?>
       </td>
      </tr>

        </table></td>
      </tr>

                                          
<?php
}else{
$header_text =  $products_name . tep_draw_separator('pixel_trans.gif', '80%', '4') . $products_price;
}
?>
<?php
// BOF: Lango Added for template MOD
if (MAIN_TABLE_BORDER == 'yes'){
table_image_border_top(false, false, $header_text);
}
// EOF: Lango Added for template MOD
?>
      <tr>
        <td class="main">
<?php
    if (tep_not_null($product_info['products_image'])) {
?>
          <table border="0" cellspacing="0" cellpadding="2" align="right">
            <tr>
              <td align="center" class="smallText">

<!-- // BOF MaxiDVD: Modified For Ultimate Images Pack! //-->
<?php
 if ($product_info['products_image_med']!='') {
          $new_image = $product_info['products_image_med'];
          $image_width = MEDIUM_IMAGE_WIDTH;
          $image_height = MEDIUM_IMAGE_HEIGHT;
         } else {
          $new_image = $product_info['products_image'];
          $image_width = SMALL_IMAGE_WIDTH;
          $image_height = SMALL_IMAGE_HEIGHT;
          }
 if ($product_info['products_image_lrg']!='') {
          $popup_image = $product_info['products_image_lrg'];
         } elseif ($product_info['products_image_med']!='') {
          $popup_image = $product_info['products_image_med'];
          } else {
          $popup_image = $product_info['products_image'];
          }
?>
<script type="text/javascript" src="jscript/jquery/jquery.js"></script>
<link rel="stylesheet" type="text/css" href="jscript/jquery/plugins/fancybox/jquery.fancybox-1.2.5.css" media="screen" />
<script type="text/javascript" src="jscript/jquery/plugins/fancybox/jquery.fancybox-1.2.5.pack.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$("a.zoom").fancybox({
		"zoomOpacity"			: true,
		"overlayShow"			: false,
		"zoomSpeedIn"			: 500,
		"zoomSpeedOut"			: 500
	});
	});
</script>
      <?php echo '<a class="zoom" rel="group" href="' . tep_href_link(DIR_WS_IMAGES . $popup_image) . '">' . tep_image(DIR_WS_IMAGES . $new_image, addslashes($product_info['products_name']), $image_width, $image_height, 'hspace="5" vspace="5"') . '<br>' . tep_template_image_button('image_enlarge.gif', TEXT_CLICK_TO_ENLARGE) . '</a>'; ?>
<!-- // EOF MaxiDVD: Modified For Ultimate Images Pack! //-->

              </td>
            </tr>

          </table>
<?php
    }
?>
          <p><b><?php echo stripslashes($product_info['products_info']); ?></b></p>
          <p><?php echo stripslashes($product_info['products_description']); ?></p>

<br>

<?php
// Start Products Specifications 
    include_once (DIR_WS_MODULES . FILENAME_PRODUCTS_SPECIFICATIONS);
// End Products Specifications 
?>

<br>
        
<?php
if (OPTIONS_AS_IMAGES_ENABLED == 'false') {

    $products_attributes_query = tep_db_query("select count(*) as total from " . TABLE_PRODUCTS_OPTIONS . " popt, " . TABLE_PRODUCTS_ATTRIBUTES . " patrib where patrib.products_id='" . (int)$_GET['products_id'] . "' and patrib.options_id = popt.products_options_id and popt.language_id = '" . (int)$languages_id . "'");
    $products_attributes = tep_db_fetch_array($products_attributes_query);
    if ($products_attributes['total'] > 0) {
// otf 1.71 added width
?>
<tr><td>
          <table border="0" cellspacing="0" cellpadding="2">
            <tr>
              <td class="main" colspan="2"><?php echo TEXT_PRODUCT_OPTIONS; ?></td>
            </tr>
<?php
// otf 1.71 Update query to pull option_type
      $products_options_name_query = tep_db_query("select distinct popt.products_options_id, popt.products_options_name, popt.products_options_type, popt.products_options_length, popt.products_options_comment from " . TABLE_PRODUCTS_OPTIONS . " popt, " . TABLE_PRODUCTS_ATTRIBUTES . " pa where pa.products_id='" . (int)$_GET['products_id'] . "' and pa.options_id = popt.products_options_id and popt.language_id = '" . (int)$languages_id . "' order by popt.products_options_sort_order, popt.products_options_name");
//      $products_options_name_query = tep_db_query("select distinct popt.products_options_id, popt.products_options_name from " . TABLE_PRODUCTS_OPTIONS . " popt, " . TABLE_PRODUCTS_ATTRIBUTES . " patrib where patrib.products_id='" . (int)$_GET['products_id'] . "' and patrib.options_id = popt.products_options_id and popt.language_id = '" . (int)$languages_id . "' order by popt.products_options_sort_order");
      while ($products_options_name = tep_db_fetch_array($products_options_name_query)) {
// otf 1.71 relocate arrays to each type of field
//        $products_options_array = array();
//        $products_options_query = tep_db_query("select pov.products_options_values_id, pov.products_options_values_name, pa.options_values_price, pa.price_prefix from " . TABLE_PRODUCTS_ATTRIBUTES . " pa, " . TABLE_PRODUCTS_OPTIONS_VALUES . " pov where pa.products_id = '" . (int)$_GET['products_id'] . "' and pa.options_id = '" . (int)$products_options_name['products_options_id'] . "' and pa.options_values_id = pov.products_options_values_id and pov.language_id = '" . (int)$languages_id . "'".$addcgid." order by pa.products_options_sort_order");
// otf 1.71 add case statement to check option type
        switch ($products_options_name['products_options_type']) {
          case PRODUCTS_OPTIONS_TYPE_TEXT:
            //CLR 030714 Add logic for text option
            $products_attribs_query = tep_db_query("select distinct pa.options_values_price, pa.price_prefix from " . TABLE_PRODUCTS_ATTRIBUTES . " pa where pa.products_id='" . (int)$_GET['products_id'] . "' and pa.options_id = '" . $products_options_name['products_options_id'] . "' order by pa.products_options_sort_order");
            $products_attribs_array = tep_db_fetch_array($products_attribs_query);
            $tmp_html = '<input type="text" name ="id[' . TEXT_PREFIX . $products_options_name['products_options_id'] . ']" size="' . $products_options_name['products_options_length'] .'" maxlength="' . $products_options_name['products_options_length'] . '" value="' . $cart->contents[$_GET['products_id']]['attributes_values'][$products_options_name['products_options_id']] .'">  ' . $products_options_name['products_options_comment'] ;
            if ($products_attribs_array['options_values_price'] != '0') {
              $tmp_html .= '(' . $products_attribs_array['price_prefix'] . $currencies->display_price($products_attribs_array['options_values_price'], tep_get_tax_rate($product_info['products_tax_class_id'])) .')';
            }
?>
            <tr>
              <td class="main"><?php echo $products_options_name['products_options_name'] . ':'; ?></td>
              <td class="main"><?php echo $tmp_html;  ?></td>
            </tr>
<?php
            break;

          case PRODUCTS_OPTIONS_TYPE_TEXTAREA:
// otf 1.71 Add logic for text option
            $products_attribs_query = tep_db_query("select distinct pa.options_values_price, pa.price_prefix from " . TABLE_PRODUCTS_ATTRIBUTES . " pa where pa.products_id='" . (int)$_GET['products_id'] . "' and pa.options_id = '" . $products_options_name['products_options_id'] . "' order by pa.products_options_sort_order");
            $products_attribs_array = tep_db_fetch_array($products_attribs_query);
		    $tmp_html = '<textarea onKeyDown="textCounter(this,\'progressbar' . $products_options_name['products_options_id'] . '\',' . $products_options_name['products_options_length'] . ')" 
								   onKeyUp="textCounter(this,\'progressbar' . $products_options_name['products_options_id'] . '\',' . $products_options_name['products_options_length'] . ')" 
								   onFocus="textCounter(this,\'progressbar' . $products_options_name['products_options_id'] . '\',' . $products_options_name['products_options_length'] . ')" 
								   wrap="soft" 
								   name="id[' . TEXT_PREFIX . $products_options_name['products_options_id'] . ']" 
								   rows=5
								   id="id[' . TEXT_PREFIX . $products_options_name['products_options_id'] . ']"
								   value="' . $cart->contents[$_GET['products_id']]['attributes_values'][$products_options_name['products_options_id']] . '"></textarea>
						<div id="progressbar' . $products_options_name['products_options_id'] . '" class="progress"></div>
						<script>textCounter(document.getElementById("id[' . TEXT_PREFIX . $products_options_name['products_options_id'] . ']"),"progressbar' . $products_options_name['products_options_id'] . '",' . $products_options_name['products_options_length'] . ')</script>';?>	<!-- DDB - 041031 - Form Field Progress Bar //-->
            <tr>
<?php
            if ($products_attribs_array['options_values_price'] != '0') {
               echo '<td class=\"main\">'.$products_options_name['products_options_name'].'<br>('.$products_options_name['products_options_comment'].' '.$products_attribs_array['price_prefix'] . $currencies->display_price($products_attribs_array['options_values_price'], tep_get_tax_rate($product_info['products_tax_class_id'])) . ')'.'</td>';
            } else {
               echo '<td class=\"main\">'.$products_options_name['products_options_name'].'<br>('.$products_options_name['products_options_comment'].')'.'</td>';
            }
?>
               <td class="main" width="75%"><?php echo $tmp_html;  ?></td>
            </tr>
<?php
            break;
			
          case PRODUCTS_OPTIONS_TYPE_RADIO:
// otf 1.71 Add logic for radio buttons
            $tmp_html = '<table>';
            $products_options_query = tep_db_query("select pov.products_options_values_id, pov.products_options_values_name, pa.options_values_price, pa.price_prefix from " . TABLE_PRODUCTS_ATTRIBUTES . " pa, " . TABLE_PRODUCTS_OPTIONS_VALUES . " pov where pa.products_id = '" . (int)$_GET['products_id'] . "' and pa.options_id = '" . $products_options_name['products_options_id'] . "' and pa.options_values_id = pov.products_options_values_id and pov.language_id = '" . $languages_id . "' order by pa.products_options_sort_order");
            $checked = true;
            while ($products_options_array = tep_db_fetch_array($products_options_query)) {
              $tmp_html .= '<tr><td class="main">';
              $tmp_html .= tep_draw_radio_field('id[' . $products_options_name['products_options_id'] . ']', $products_options_array['products_options_values_id'], $checked);
              $checked = false;
              $tmp_html .= $products_options_array['products_options_values_name'] ;
              $tmp_html .=$products_options_name['products_options_comment'] ;
              if ($products_options_array['options_values_price'] != '0') {
                $tmp_html .= '(' . $products_options_array['price_prefix'] . $currencies->display_price($products_options_array['options_values_price'], tep_get_tax_rate($product_info['products_tax_class_id'])) .')&nbsp';
              }
              $tmp_html .= '</tr></td>';
            }
            $tmp_html .= '</table>';
?>
            <tr>
              <td class="main"><?php echo $products_options_name['products_options_name'] . ':'; ?></td>
              <td class="main"><?php echo $tmp_html;  ?></td>
            </tr>
<?php
            break;

          case PRODUCTS_OPTIONS_TYPE_CHECKBOX:
// otf 1.71 Add logic for checkboxes
            $products_attribs_query = tep_db_query("select distinct pa.options_values_id, pa.options_values_price, pa.price_prefix from " . TABLE_PRODUCTS_ATTRIBUTES . " pa where pa.products_id='" . (int)$_GET['products_id'] . "' and pa.options_id = '" . $products_options_name['products_options_id'] . "' order by pa.products_options_sort_order");
            $products_attribs_array = tep_db_fetch_array($products_attribs_query);
            echo '<tr><td class="main">' . $products_options_name['products_options_name'] . ': </td><td class="main">';
            echo tep_draw_checkbox_field('id[' . $products_options_name['products_options_id'] . ']', $products_attribs_array['options_values_id']);
            echo $products_options_name['products_options_comment'] ;
            if ($products_attribs_array['options_values_price'] != '0') {
              echo '(' . $products_attribs_array['price_prefix'] . $currencies->display_price($products_attribs_array['options_values_price'], tep_get_tax_rate($product_info['products_tax_class_id'])) .')&nbsp';
            }
            echo '</td></tr>';
            break;
          default:
// otf 1.71 default is select list
// otf 1.71 reset selected_attribute variable
            $selected_attribute = false;
        		$products_options_array = array();
        		$products_options_query = tep_db_query("select pov.products_options_values_id, pov.products_options_values_name, pa.options_values_price, pa.price_prefix from " . TABLE_PRODUCTS_ATTRIBUTES . " pa, " . TABLE_PRODUCTS_OPTIONS_VALUES . " pov where pa.products_id = '" . (int)$_GET['products_id'] . "' and pa.options_id = '" . (int)$products_options_name['products_options_id'] . "' and pa.options_values_id = pov.products_options_values_id and pov.language_id = '" . (int)$languages_id . "' order by pa.products_options_sort_order");
        		while ($products_options = tep_db_fetch_array($products_options_query)) {
          		$products_options_array[] = array('id' => $products_options['products_options_values_id'], 'text' => $products_options['products_options_values_name']);
          		if ($products_options['options_values_price'] != '0') {
            		$products_options_array[sizeof($products_options_array)-1]['text'] .= ' (' . $products_options['price_prefix'] . $currencies->display_price($products_options['options_values_price'], tep_get_tax_rate($product_info['products_tax_class_id'])) .') ';
          		}
        		}

        		if (isset($cart->contents[$_GET['products_id']]['attributes'][$products_options_name['products_options_id']])) {
          		$selected_attribute = $cart->contents[$_GET['products_id']]['attributes'][$products_options_name['products_options_id']];
        		} else {
          		$selected_attribute = false;
        		}
?>
            <tr>
              <td class="main"><?php echo $products_options_name['products_options_name'] . ':'; ?></td>
              <td class="main"><?php echo tep_draw_pull_down_menu('id[' . $products_options_name['products_options_id'] . ']', $products_options_array, $selected_attribute) . $products_options_name['products_options_comment'];  ?></td>
            </tr>
<?php
        }  // otf 1.71 end switch
      } // otf 1.71 end while
?>
          </table>
<?php
    } // otf 1.71 end if

//Options as Images. This whole php clause needs to be added
	}

if (OPTIONS_AS_IMAGES_ENABLED == 'true') include (FILENAME_OPTIONS_IMAGES); 

?>
        </td>
      </tr>

      <!-- begin mod for ProductsProperties v2.01 -->   
<?php
	$properties = "select options_id, options_values_id from " . TABLE_PRODUCTS_PROPERTIES . " where products_id = '" . (int)$_GET['products_id'] . "' order by sort_order asc";
  	$properties = tep_db_query($properties);
	$num_properties = tep_db_num_rows($properties);
?>
<?php 
	if ($num_properties > '0') { ?>
      <tr>
        <td class="main"><b><?php echo TEXT_PRODUCTS_PROPERTIES; ?></b></td>
      </tr>
<?php  
	} 
?>
<?php
  while ($properties_values = tep_db_fetch_array($properties)) {
    $options_name = tep_get_prop_options_name($properties_values['options_id']);
    $values_name = tep_get_prop_values_name($properties_values['options_values_id']);
    $rows++;
?>
      <tr>
        <td class="main">&nbsp;&nbsp;&nbsp;<b><?php if ($values_name != '') { echo $options_name . ':'; } else {} ?></b>&nbsp;<?php echo $values_name; ?></td>
      </tr>
<?php
  }
?> 
      <!-- end mod for ProductsProperties v2.01 -->       

<?php
		  // START: Extra Fields Contribution v2.0b - mintpeel display fix
		  
                      $extra_fields_query = tep_db_query("
                      SELECT pef.products_extra_fields_status as status, pef.products_extra_fields_name as name, ptf.products_extra_fields_value as value
                      FROM ". TABLE_PRODUCTS_EXTRA_FIELDS ." pef
             LEFT JOIN  ". TABLE_PRODUCTS_TO_PRODUCTS_EXTRA_FIELDS ." ptf
            ON ptf.products_extra_fields_id=pef.products_extra_fields_id
            WHERE ptf.products_id=". (int) $products_id ." and ptf.products_extra_fields_value<>'' and (pef.languages_id='0' or pef.languages_id='".$languages_id."')
            ORDER BY products_extra_fields_order");

  while ($extra_fields = tep_db_fetch_array($extra_fields_query)) {
        if (! $extra_fields['status'])  // show only enabled extra field
           continue;
        echo '<tr>
	  <td>
	  <table border="0" width="50%" cellspacing="0" cellpadding="2px"><tr>
      <td class="main" align="left" vallign="middle"><b><font size="1" color="#666666">'.$extra_fields['name'].': </b></font>';
        echo '<font size="1" color="#666666">' .$extra_fields['value'].'<BR></font> </tr>
      </table>
	  </td>
      </tr>'; 
  }
       // END: Extra Fields Contribution - mintpeel display fix
?>

<?php
// BOF MaxiDVD: Modified For Ultimate Images Pack!
 if (ULTIMATE_ADDITIONAL_IMAGES == 'enable') { include(DIR_WS_MODULES . 'additional_images.php'); }
// BOF MaxiDVD: Modified For Ultimate Images Pack!
 ?>

      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
<?php
    $reviews_query = tep_db_query("select count(*) as count from " . TABLE_REVIEWS . " where status_otz = '1' and products_id = '" . (int)$_GET['products_id'] . "'");
    $reviews = tep_db_fetch_array($reviews_query);
    if ($reviews['count'] > 0) {
?>
      <tr>
        <td class="main"><?php echo TEXT_CURRENT_REVIEWS . ' ' . $reviews['count']; ?></td>
      </tr>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
<?php
    }

    if (tep_not_null($product_info['products_url'])) {
?>
      <tr>
        <td class="main"><?php echo sprintf(TEXT_MORE_INFORMATION, tep_href_link(FILENAME_REDIRECT, 'action=url&goto=' . urlencode($product_info['products_url']), 'NONSSL', true, false)); ?></td>
      </tr>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
<?php
    }

    if ($product_info['products_date_available'] > date('Y-m-d H:i:s')) {
?>
      <tr>
        <td align="center" class="smallText"><?php echo sprintf(TEXT_DATE_AVAILABLE, tep_date_long($product_info['products_date_available'])); ?></td>
      </tr>
<?php
    } else {
?>
      <tr>
        <td align="center" class="smallText"><?php echo sprintf(TEXT_DATE_ADDED, tep_date_long($product_info['products_date_added'])); ?></td>
      </tr>
<?php
    }
?>
<?php
// BOF: Lango Added for template MOD
if (MAIN_TABLE_BORDER == 'yes'){
table_image_border_bottom();
}
// EOF: Lango Added for template MOD
?>
          <tr class="infoBoxContents">
            <td><table class="table-padding-2">




                   <tr>
                <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
                <td class="main"><?php echo '<a href="' . tep_href_link(FILENAME_PRODUCT_REVIEWS, tep_get_all_get_params()) . '">' . tep_template_image_button('button_reviews.gif', IMAGE_BUTTON_REVIEWS) . '</a>'; ?></td>
                <td class="main" align="right">              
<?php echo PRODUCTS_ORDER_QTY_TEXT; ?><input type="text" class="input-class" name="cart_quantity" value=<?php echo (tep_get_products_quantity_order_min($_GET['products_id'])); ?> maxlength="4" size="4"><?php echo ((tep_get_products_quantity_order_min($_GET['products_id'])) > 1 ? PRODUCTS_ORDER_QTY_MIN_TEXT . (tep_get_products_quantity_order_min($_GET['products_id'])) : ""); ?><?php echo (tep_get_products_quantity_order_units($_GET['products_id']) > 1 ? PRODUCTS_ORDER_QTY_UNIT_TEXT . (tep_get_products_quantity_order_units($_GET['products_id'])) : ""); ?>
<br>              
                <?php echo tep_draw_hidden_field('products_id', $product_info['products_id']) . tep_template_image_submit('button_in_cart.gif', IMAGE_BUTTON_IN_CART); ?></td>
              <td align="right" class="main">
               <?php echo tep_template_image_submit('button_add_wishlist.gif', IMAGE_BUTTON_ADD_WISHLIST, 'name="wishlist" value="wishlist"'); ?>
               </td>
               <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
 </form>
             </tr>
</td>
</tr>
</table>
      
      <tr>
        <td>
<?php

//Commented for x-sell
//    if ((USE_CACHE == 'true') && empty($SID)) {
//      echo tep_cache_also_purchased(3600);
//    } else {
//      include(DIR_WS_MODULES . FILENAME_ALSO_PURCHASED_PRODUCTS);
//    }
//  }
//Added for x sell
   if ( (USE_CACHE == 'true') && !SID) { 
    echo tep_cache_also_purchased(3600); 
     include(DIR_WS_MODULES . FILENAME_XSELL_PRODUCTS); 
   } else { 
      include(DIR_WS_MODULES . FILENAME_XSELL_PRODUCTS_BUYNOW);
echo tep_draw_separator('pixel_trans.gif', '100%', '10');
      include(DIR_WS_MODULES . FILENAME_ALSO_PURCHASED_PRODUCTS);

    }
   }
?>
        </td>
      </tr>
      
      <tr>
        <td>
<?php if ($product_check['total'] > 1) {
        include(DIR_WS_MODULES . FILENAME_PRODUCT_REVIEWS_INFO);
      }
?>
        </td>
      </tr>

      <tr>
        <td>
<?php
      include(DIR_WS_MODULES . FILENAME_ARTICLES_PXSELL);
?>
        </td>
      </tr>
                  
    </table>