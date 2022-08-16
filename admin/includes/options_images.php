<?php
/*
  $Id: options_images.php,v 1.6.6 2003/08/18 

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/

    require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_OPTIONS_IMAGES);

    $iec='0';

    $products_attributes_query = tep_db_query("select count(*) as total from " . TABLE_PRODUCTS_OPTIONS . " popt, " . TABLE_PRODUCTS_ATTRIBUTES . " patrib where patrib.products_id='" . (int)$_GET['products_id'] . "' and patrib.options_id = popt.products_options_id and popt.language_id = '" . (int)$languages_id . "'");
    $products_attributes = tep_db_fetch_array($products_attributes_query);
    if ($products_attributes['total'] > 0) {
      echo '<b><span class="optionsAvailable">' . TEXT_PRODUCT_OPTIONS. '</span></b>';
?>

<?php
      $products_options_name_query = tep_db_query("select distinct popt.products_options_id, popt.products_options_name, popt.products_options_type, popt.products_options_images_enabled from " . TABLE_PRODUCTS_OPTIONS . " popt, " . TABLE_PRODUCTS_ATTRIBUTES . " patrib where patrib.products_id='" . (int)$_GET['products_id'] . "' and patrib.options_id = popt.products_options_id and popt.language_id = '" . (int)$languages_id . "' order by popt.products_options_sort_order, popt.products_options_name");
      while ($products_options_name = tep_db_fetch_array($products_options_name_query)) {
        $products_options_array = array();
        $products_options_query = tep_db_query("select pov.products_options_values_id, pov.products_options_values_name, pov.products_options_values_thumbnail, pa.options_values_price, pa.price_prefix from " . TABLE_PRODUCTS_ATTRIBUTES . " pa, " . TABLE_PRODUCTS_OPTIONS_VALUES . " pov where pa.products_id = '" . (int)$_GET['products_id'] . "' and pa.options_id = '" . (int)$products_options_name['products_options_id'] . "' and pa.options_values_id = pov.products_options_values_id and pov.language_id = '" . (int)$languages_id . "' order by pov.products_options_values_name asc");

        while($products_options = tep_db_fetch_array($products_options_query)){ 
          $products_options_array[] = array('id' => $products_options['products_options_values_id'], 'text' => $products_options['products_options_values_name'], 'thumbnail' => $products_options['products_options_values_thumbnail']);
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
        <table border="0" cellspacing="0" cellpadding="2">
 
            <tr>
              <td class="main" valign="top"><b><?php echo $products_options_name['products_options_name']. ':'; ?></b>
              <?php 
      		    if (OPTIONS_IMAGES_CLICK_ENLARGE == 'true' && ($products_options_name['products_options_images_enabled'] != 'false')){
                  echo '<br><span class="smallText"><i>&nbsp;&nbsp;' . TEXT_SELECT_DESIRED. '<br>&nbsp;&nbsp;'. TEXT_CLICK_IMAGES. '<br></i></span>'; 
                }
              ?>
              </td>
              
							
<?php 
              if ($products_options_name['products_options_images_enabled'] == 'false'){
// otf 1.71 add case statement to check option type
// echo 'type - ' . $products_options_name['products_options_type'];
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
              <!--td class="main"><?php echo $products_options_name['products_options_name'] . ':'; ?></td-->
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
            $products_options_query = tep_db_query("select pov.products_options_values_id, pov.products_options_values_thumbnail, pov.products_options_values_name, pa.options_values_price, pa.price_prefix from " . TABLE_PRODUCTS_ATTRIBUTES . " pa, " . TABLE_PRODUCTS_OPTIONS_VALUES . " pov where pa.products_id = '" . (int)$_GET['products_id'] . "' and pa.options_id = '" . $products_options_name['products_options_id'] . "' and pa.options_values_id = pov.products_options_values_id and pov.language_id = '" . $languages_id . "' order by pa.products_options_sort_order");
            $checked = true;
            while ($products_options_array = tep_db_fetch_array($products_options_query)) {
                  if ($products_options_array['products_options_values_thumbnail'] != '') { 
                  if (OPTIONS_IMAGES_CLICK_ENLARGE == 'true'){ 
                   $tmp_image = '<a href="javascript:popupWindow(\'' . tep_href_link(FILENAME_OPTIONS_IMAGES_POPUP, 'oID=' . $products_options_array['products_options_values_id']) .'\')">' . tep_image(DIR_WS_IMAGES . 'options/' . $products_options_array['products_options_values_thumbnail'], $products_options_array['products_options_values_name'], OPTIONS_IMAGES_WIDTH, OPTIONS_IMAGES_HEIGHT) . '</a>';
                  }else{
                    $tmp_image = '' . tep_image(DIR_WS_IMAGES . 'options/' . $opti_array['thumbnail'], $opti_array['text'], OPTIONS_IMAGES_WIDTH, OPTIONS_IMAGES_HEIGHT) . '';
                  }
                  } else {
                    $tmp_image = '';
                  }
              $tmp_html .= '<tr><td class="main">';
              $tmp_html .= tep_draw_radio_field('id[' . $products_options_name['products_options_id'] . ']', $products_options_array['products_options_values_id'], $checked);
              $checked = false;
              $tmp_html .= $products_options_array['products_options_values_name'] . $tmp_image;
              $tmp_html .=$products_options_name['products_options_comment'] ;
              if ($products_options_array['options_values_price'] != '0') {
                $tmp_html .= '(' . $products_options_array['price_prefix'] . $currencies->display_price($products_options_array['options_values_price'], tep_get_tax_rate($product_info['products_tax_class_id'])) .')&nbsp';
              }
            }
              $tmp_html .= '</tr></td>';
            $tmp_html .= '</table>';
?>
            <tr>
              <!--td class="main"><?php echo $products_options_name['products_options_name'] . ':'; ?></td-->
              <td class="main"><?php echo $tmp_html;  ?></td>
            </tr>
<?php
            break;

          case PRODUCTS_OPTIONS_TYPE_CHECKBOX:
// otf 1.71 Add logic for checkboxes
            $products_attribs_query = tep_db_query("select distinct pov.products_options_values_id, pov.products_options_values_thumbnail, pov.products_options_values_name, pa.options_values_price, pa.options_values_id, pa.price_prefix from " . TABLE_PRODUCTS_ATTRIBUTES . " pa, " . TABLE_PRODUCTS_OPTIONS_VALUES . " pov where pa.products_id = '" . (int)$_GET['products_id'] . "' and pa.options_id = '" . $products_options_name['products_options_id'] . "' and pa.options_values_id = pov.products_options_values_id and pov.language_id = '" . $languages_id . "' order by pa.products_options_sort_order");
            $products_attribs_array = tep_db_fetch_array($products_attribs_query);
                  if ($products_attribs_array['products_options_values_thumbnail'] != '') { 
                  if (OPTIONS_IMAGES_CLICK_ENLARGE == 'true'){ 
                   $tmp_image = '<a href="javascript:popupWindow(\'' . tep_href_link(FILENAME_OPTIONS_IMAGES_POPUP, 'oID=' . $products_attribs_array['products_options_values_id']) .'\')">' . tep_image(DIR_WS_IMAGES . 'options/' . $products_attribs_array['products_options_values_thumbnail'], $products_attribs_array['products_options_values_name'], OPTIONS_IMAGES_WIDTH, OPTIONS_IMAGES_HEIGHT) . '</a>';
                  }else{
                    $tmp_image = '' . tep_image(DIR_WS_IMAGES . 'options/' . $opti_array['thumbnail'], $opti_array['text'], OPTIONS_IMAGES_WIDTH, OPTIONS_IMAGES_HEIGHT) . '';
                  }
                  } else {
                    $tmp_image = '';
                  }
            echo '<tr><!--td class="main">' . $products_options_name['products_options_name'] . ': </td--><td class="main">'.$tmp_image;
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
              <!--td class="main"><?php echo $products_options_name['products_options_name'] . ':'; ?></td-->
              <td class="main"><?php echo tep_draw_pull_down_menu('id[' . $products_options_name['products_options_id'] . ']', $products_options_array, $selected_attribute) . $products_options_name['products_options_comment'];  ?></td>
            </tr>
<?php
        }  // otf 1.71 end switch
              }else {
                $count=0;
                echo '<tr><td class="main"><table><tr>';
                foreach ($products_options_array as $opti_array){
                  echo '<td align="center"><table cellspacing="5" cellpadding="0" border="0">';
                  if ($opti_array['thumbnail'] != '') { 
                  if (OPTIONS_IMAGES_CLICK_ENLARGE == 'true'){ 
                    echo '<td align="center"><a href="javascript:popupWindow(\'' . tep_href_link(FILENAME_OPTIONS_IMAGES_POPUP, 'oID=' . $opti_array['id']) .'\')">' . tep_image(DIR_WS_IMAGES . 'options/' . $opti_array['thumbnail'], $opti_array['text'], OPTIONS_IMAGES_WIDTH, OPTIONS_IMAGES_HEIGHT) . '</a></td></tr>';
                  }else{
                    echo '<tr><td align="center">' . tep_image(DIR_WS_IMAGES . 'options/' . $opti_array['thumbnail'], $opti_array['text'], OPTIONS_IMAGES_WIDTH, OPTIONS_IMAGES_HEIGHT) . '</td></tr>';
                  }
                  }
                  echo '<tr><td class="main" align="center">' . $opti_array['text'] . '</td></tr>';

//Radio button disable auto check mod Options as Images MS2 v1.5
//This will add a variable to the loop and make the value untrue.
//However if you check a radio button, you still can't uncheck it by clicking it again. 
//In that case you need to change 'radio' to 'checkbox' in the above code. . . 
//this will put a checkbox there which can be unchecked by clicking it again.
//							      echo '<tr><td align="center"><input type="radio" name ="id[' . $products_options_name['products_options_id'] . ']" value="' . $opti_array['id'] . '" checked></td></tr></table></td>';
if ($iec=='1') { $checkedd=''; } else { $checkedd='checked'; }
echo '<tr><td align="center"><input type="radio" name ="id[' . $products_options_name['products_options_id'] . ']" value="' . $opti_array['id'] . '" ' . $checkedd . ' /></td></tr></table></td>';
$iec='1';
//END Radio button disable auto check mod Options as Images MS2 v1.5

											$count++;
                      if ($count%OPTIONS_IMAGES_NUMBER_PER_ROW == 0) {
							 	        echo '</tr><tr>';
								        $count = 0;
							        }
							      }
									echo '</table>';
								}

?>
        </td></tr>
<?php
      }
?>
     </table>
<?php
    }
?>