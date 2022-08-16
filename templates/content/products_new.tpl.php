    <table border="0" width="100%" cellspacing="0" cellpadding="<?php echo CELLPADDING_SUB;?>">
<?php
// BOF: Lango Added for template MOD
if (SHOW_HEADING_TITLE_ORIGINAL == 'yes') {
$header_text = '&nbsp;'
//EOF: Lango Added for template MOD
?>
 <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.0.0/animate.min.css"
  />

      <tr>
        <td><table class="table-padding-0">
          <tr>
            <td class="animate__animated animate__rollIn"><?php echo HEADING_TITLE; ?></td>
            <td class="pageHeading" align="right"><?php echo tep_image(DIR_WS_TEMPLATES . TEMPLATE_NAME . '/images/content/products_new.gif', HEADING_TITLE, HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?></td>
          </tr>
        </table></td>
      </tr>
<?php
}else{
$header_text =  HEADING_TITLE;
}
?>

<?php
  $products_new_array = array();

//  $products_new_query_raw = "select p.products_id, pd.products_name, pd.products_info, p.products_image, p.products_price, p.products_tax_class_id, p.products_date_added, m.manufacturers_name from " . TABLE_PRODUCTS . " p left join " . TABLE_MANUFACTURERS . " m on (p.manufacturers_id = m.manufacturers_id), " . TABLE_PRODUCTS_DESCRIPTION . " pd where p.products_status = '1' and p.products_id = pd.products_id and pd.language_id = '" . (int)$languages_id . "' order by p.products_date_added DESC, pd.products_name";

// BOF Enable - Disable Categories Contribution--------------------------------------
// BOF manufacturers descriptions
//  $products_new_query_raw = "select distinct p.products_id, pd.products_name, pd.products_info, p.products_image, p.products_price, p.products_tax_class_id, p.products_date_added, m.manufacturers_name from " . TABLE_PRODUCTS . " p left join " . TABLE_MANUFACTURERS . " m on (p.manufacturers_id = m.manufacturers_id), " . TABLE_CATEGORIES . " c, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c, " . TABLE_PRODUCTS_DESCRIPTION . " pd where c.categories_status=1 and p.products_id = p2c.products_id and c.categories_id = p2c.categories_id and p.products_status = '1' and p.products_id = pd.products_id and pd.language_id = '" . (int)$languages_id . "' order by p.products_date_added DESC, pd.products_name";
//  $products_new_query_raw = "select distinct p.products_id, pd.products_name, pd.products_info, p.products_image, p.products_price, p.products_tax_class_id, p.products_date_added, mi.manufacturers_name from " . TABLE_PRODUCTS . " p left join " . TABLE_MANUFACTURERS_INFO . " mi on (p.manufacturers_id = mi.manufacturers_id and mi.languages_id = '" . (int)$languages_id . "'), " . TABLE_CATEGORIES . " c, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c, " . TABLE_PRODUCTS_DESCRIPTION . " pd where c.categories_status=1 and p.products_id = p2c.products_id and c.categories_id = p2c.categories_id and p.products_status = '1' and p.products_id = pd.products_id and pd.language_id = '" . (int)$languages_id . "' order by p.products_date_added DESC, pd.products_name";
$products_new_query_raw = "SELECT STRAIGHT_JOIN p.products_id, pd.products_name, pd.products_info, p.products_image,
 p.products_price, p.products_tax_class_id, p.products_date_added, mi.manufacturers_name 
 from " . TABLE_PRODUCTS . " p  
 INNER JOIN ( SELECT  * from " . TABLE_PRODUCTS_TO_CATEGORIES . " GROUP by products_id ) as p2c ON p.products_id = p2c.products_id
 and p.products_id = p2c.products_id and p.products_status = '1' and p.products_quantity>0 and p.products_date_added > '2019-10-10 20:00:28'  
   INNER JOIN  " . TABLE_CATEGORIES . " as  c on c.categories_id = p2c.categories_id
  INNER JOIN " . TABLE_PRODUCTS_DESCRIPTION . " as pd ON pd.language_id = '1'  and p.products_id = pd.products_id
left join " . TABLE_MANUFACTURERS_INFO . " mi on (p.manufacturers_id = mi.manufacturers_id and mi.languages_id = '" . (int)$languages_id . "')
order by p.products_date_added DESC"; 
// EOF manufacturers descriptions
// EOF Enable - Disable Categories Contribution--------------------------------------

// TODO:Приближенное значение, т.к. точное значение работает на 1 секунду медленннее
    $count_query = tep_db_query("select count(*) as total FROM ".TABLE_PRODUCTS . " where products_date_added > '2019-12-12 20:00:28'");
    $count = tep_db_fetch_array($count_query);

  $products_new_split = new splitPageResults($products_new_query_raw, MAX_DISPLAY_PRODUCTS_NEW, 'p.products_id', 'page',$count['total']);
  if (($products_new_split->number_of_rows > 0) && ((PREV_NEXT_BAR_LOCATION == '1') || (PREV_NEXT_BAR_LOCATION == '3'))) {
?>
<?php
if ( ($error_cart_msg) ) {
?>
      <tr>
        <td align="right"><?php echo tep_output_warning($error_cart_msg); ?><br></td>
      </tr>
<?php
}
$error_cart_msg='';
?>

      <tr>
        <td><table class="table-padding-2">
          <tr>
            <td class="smallText"><?php echo $products_new_split->display_count('Показано <b>%d</b> - <b>%d</b>'); ?></td>
            <td align="right" class="smallText"><?php echo TEXT_RESULT_PAGE . ' ' . $products_new_split->display_links(MAX_DISPLAY_PAGE_LINKS, tep_get_all_get_params(array('page', 'info', 'x', 'y'))); ?></td>
          </tr>
        </table></td>
      </tr>

<?php
  }
?>
      <tr>
        <td><table class="table-padding-2">
<?php
// BOF: Lango Added for template MOD
if (MAIN_TABLE_BORDER == 'yes'){
table_image_border_top(false, false, $header_text);
}
// EOF: Lango Added for template MOD
?>
<?php
  if ($products_new_split->number_of_rows > 0) {
    $products_new_query = tep_db_query($products_new_split->sql_query);
    while ($products_new = tep_db_fetch_array($products_new_query)) {
    
		//TotalB2B start
        $products_new['products_price'] = tep_xppp_getproductprice($products_new['products_id']);
        //TotalB2B end

      if ($new_price = tep_get_products_special_price($products_new['products_id'])) {
		
        //TotalB2B start
//		$query_special_prices_hide = tep_db_query("select configuration_value from " . TABLE_CONFIGURATION . " WHERE configuration_key = 'SPECIAL_PRICES_HIDE'");
//        $query_special_prices_hide_result = tep_db_fetch_array($query_special_prices_hide); 
        $query_special_prices_hide_result = SPECIAL_PRICES_HIDE; 
        if ($query_special_prices_hide_result == 'true') {
          $products_price = '<span class="productSpecialPrice">' . $currencies->display_price_nodiscount($new_price, tep_get_tax_rate($products_new['products_tax_class_id'])) . '</span>';
	    } else {
          $products_price = '<s>' . $currencies->display_price_nodiscount($products_new['products_price'], tep_get_tax_rate($products_new['products_tax_class_id'])) . '</s> <span class="productSpecialPrice">' . $currencies->display_price_nodiscount($new_price, tep_get_tax_rate($products_new['products_tax_class_id'])) . '</span>';
	    }
        //TotalB2B end

      } else {
        $products_price = $currencies->display_price($products_new['products_price'], tep_get_tax_rate($products_new['products_tax_class_id']));
      }

    
//      if ($new_price = tep_get_products_special_price($products_new['products_id'])) {
//        $products_price = '<s>' . $currencies->display_price($products_new['products_price'], tep_get_tax_rate($products_new['products_tax_class_id'])) . '</s> <span class="productSpecialPrice">' . $currencies->display_price($new_price, tep_get_tax_rate($products_new['products_tax_class_id'])) . '</span>';
//      } else {
//        $products_price = $currencies->display_price($products_new['products_price'], tep_get_tax_rate($products_new['products_tax_class_id']));
//      }
?>
          <tr>
            <td width="<?php echo SMALL_IMAGE_WIDTH + 10; ?>" valign="top" class="main"><?php echo '<a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $products_new['products_id']) . '">' . tep_image(DIR_WS_IMAGES . $products_new['products_image'], $products_new['products_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT) . '</a>'; ?></td>
            <td valign="top" class="main"><?php echo '<a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $products_new['products_id']) . '"><b><u>' . $products_new['products_name'] . '</u></b></a><br>' . $products_new['products_info'] . '<br>' . TEXT_DATE_ADDED . ' ' . tep_date_long($products_new['products_date_added']) . '<br>' . TEXT_MANUFACTURER . ' ' . $products_new['manufacturers_name'] . '<br><br>' . TEXT_PRICE . ' ' . $products_price; ?></td>
            <td align="right" valign="middle" class="main">
            
<!--
            <?php echo '<a href="' . tep_href_link(FILENAME_PRODUCTS_NEW, tep_get_all_get_params(array('action')) . 'action=buy_now&products_id=' . $products_new['products_id']) . '">' . tep_template_image_button('button_in_cart.gif', IMAGE_BUTTON_IN_CART) . '</a>'; ?>
-->            
            
<?php
if (tep_has_product_attributes($products_new['products_id'])) {
              if (isset($_GET['manufacturers_id'])) {
?>              
                <?php echo '<a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'manufacturers_id=' . $_GET['manufacturers_id'] . '&products_id=' . $products_new['products_id']) . '">' . TEXT_MORE_INFO . '</a>'; ?>
<?php
              } else {
?>
                <?php echo '&nbsp;<a href="' . tep_href_link(FILENAME_PRODUCT_INFO, ($cPath ? 'cPath=' . $cPath . '&' : '') . 'products_id=' . $products_new['products_id']) . '">' . TEXT_MORE_INFO . '</a>'; ?>
<?php
              }
} else {
?>
            
            
               <?php echo tep_draw_form('cart_quantity', tep_href_link(FILENAME_PRODUCTS_NEW, tep_get_all_get_params(array('action')) . 'action=add_product', 'NONSSL')); ?> 
<?php echo PRODUCTS_ORDER_QTY_TEXT; ?><input type="text" class="input-class" name="cart_quantity" value=<?php echo (tep_get_products_quantity_order_min($products_new['products_id'])); ?> maxlength="3" size="3"><?php echo ((tep_get_products_quantity_order_min($products_new['products_id'])) > 1 ? PRODUCTS_ORDER_QTY_MIN_TEXT . (tep_get_products_quantity_order_min($products_new['products_id'])) : ""); ?><?php echo (tep_get_products_quantity_order_units($products_new['products_id']) > 1 ? PRODUCTS_ORDER_QTY_UNIT_TEXT . (tep_get_products_quantity_order_units($products_new['products_id'])) : ""); ?>

                
                <?php echo tep_draw_hidden_field('products_id', $products_new['products_id']) . tep_template_image_submit('button_in_cart.gif', IMAGE_BUTTON_IN_CART); ?></form>
            
<?php } ?>  
            
            
            
            
            </td>       
          </tr>
          <tr>
            <td colspan="3"><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
          </tr>
<?php
    }
  } else {
?>
          <tr>
            <td class="main"><?php echo TEXT_NO_NEW_PRODUCTS; ?></td>
          </tr>
          <tr>
            <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
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
        </table></td>
      </tr>
<?php
  if (($products_new_split->number_of_rows > 0) && ((PREV_NEXT_BAR_LOCATION == '2') || (PREV_NEXT_BAR_LOCATION == '3'))) {
?>
      <tr>
        <td><table class="table-padding-2">
          <tr>
            <td class="smallText"><?php echo $products_new_split->display_count(TEXT_DISPLAY_NUMBER_OF_PRODUCTS_NEW); ?></td>
            <td align="right" class="smallText"><?php echo TEXT_RESULT_PAGE . ' ' . $products_new_split->display_links(MAX_DISPLAY_PAGE_LINKS, tep_get_all_get_params(array('page', 'info', 'x', 'y'))); ?></td>
          </tr>
        </table></td>
      </tr>
<?php
  }
?>
    </table>

