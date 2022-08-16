<table border="0" width="100%" cellspacing="0" cellpadding="<?php echo CELLPADDING_SUB;?>">

      <tr> 
        <td width="100%">
        
	  <table class="table-padding-0">
      <tr>
        <td>
		  <table class="table-padding-0"><?php echo tep_draw_form('wishlist_form', $_PHP_SELF); ?>
          <tr>
            <td class="pageHeading" colspan="3"><?php echo HEADING_TITLE; ?></td>
            <td class="pageHeading" align="right"><?php echo tep_image(DIR_WS_TEMPLATES . TEMPLATE_NAME . '/images/content/wishlist.gif', HEADING_TITLE, HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?></td>
          </tr>
          </table>
		</td>
      </tr>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>

<?php
  if ($messageStack->size('wishlist') > 0) {
?>
      <tr>
        <td><?php echo $messageStack->output('wishlist'); ?></td>
      </tr>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
<?php
  }

/*******************************************************************
****** QUERY THE DATABASE FOR THE CUSTOMERS WISHLIST PRODUCTS ******
*******************************************************************/

  $wishlist_query_raw = "select * from " . TABLE_WISHLIST . " where customers_id = '" . $public_id . "'";
  $wishlist_split = new splitPageResults($wishlist_query_raw, MAX_DISPLAY_WISHLIST_PRODUCTS);
  $wishlist_query = tep_db_query($wishlist_split->sql_query);

?>
<!-- customer_wishlist //-->
<?php

  if (tep_db_num_rows($wishlist_query)) {

	if ($wishlist_split > 0 && (PREV_NEXT_BAR_LOCATION == '1' || PREV_NEXT_BAR_LOCATION == '3')) {
?>
      <tr>
        <td>
		<table class="table-padding-2">
          <tr>
            <td class="smallText"><?php echo $wishlist_split->display_count(TEXT_DISPLAY_NUMBER_OF_WISHLIST); ?></td>
            <td align="right" class="smallText"><?php echo TEXT_RESULT_PAGE . ' ' . $wishlist_split->display_links(MAX_DISPLAY_PAGE_LINKS, tep_get_all_get_params(array('page', 'info', 'x', 'y'))); ?></td>
          </tr>
        </table>
		</td>
      </tr>

<?php
  }
?>

<?php
// BOF: Lango Added for template MOD
if (MAIN_TABLE_BORDER == 'yes'){
$header_text = '&nbsp;';
table_image_border_top(false, false, $header_text);
}
// EOF: Lango Added for template MOD
?>
	  <tr>
		<td>
		<table border="0" width="100%" cellspacing="0" cellpadding="3" class="productListing">
		  <tr>
				<td class="productListing-heading"><?php echo BOX_TEXT_IMAGE; ?></td>
				<td class="productListing-heading"><?php echo BOX_TEXT_PRODUCT; ?></td>
				<td class="productListing-heading"><?php echo BOX_TEXT_PRICE; ?></td>
				<td class="productListing-heading" align="center"><?php echo BOX_TEXT_SELECT; ?></td>
		  </tr>
<?php 

/*******************************************************************
***** LOOP THROUGH EACH PRODUCT ID TO DISPLAY IN THE WISHLIST ******
*******************************************************************/
	$i = 0;
    while ($wishlist = tep_db_fetch_array($wishlist_query)) {
	$wishlist_id = tep_get_prid($wishlist['products_id']);

    $products_query = tep_db_query("select pd.products_id, pd.products_name, pd.products_description, p.products_image, p.products_price, p.products_tax_class_id, IF(s.status, s.specials_new_products_price, NULL) as specials_new_products_price, IF(s.status, s.specials_new_products_price, p.products_price) as final_price from " . TABLE_PRODUCTS . " p left join " . TABLE_SPECIALS . " s on p.products_id = s.products_id, " . TABLE_PRODUCTS_DESCRIPTION . " pd where pd.products_id = '" . $wishlist_id . "' and p.products_id = pd.products_id and pd.language_id = '" . $languages_id . "' order by products_name");
	$products = tep_db_fetch_array($products_query);

      if (($i/2) == floor($i/2)) {
        $class = "productListing-even";
      } else {
        $class = "productListing-odd";
      }

?>
				  <tr class="<?php echo $class; ?>">
					<td valign="top" class="productListing-data" align="left"><a href="<?php echo tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $wishlist['products_id'], 'NONSSL'); ?>"><?php echo tep_image(DIR_WS_IMAGES . $products['products_image'], $products['products_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT); ?></a></td>
					<td valign="top" class="productListing-data" align="left" class="main"><b><a href="<?php echo tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $wishlist['products_id'], 'NONSSL'); ?>"><?php echo $products['products_name']; ?></a></b>
<?php

/*******************************************************************
******** THIS IS THE WISHLIST CODE FOR PRODUCT ATTRIBUTES  *********
*******************************************************************/

                  $attributes_addon_price = 0;

                  // Now get and populate product attributes
                    $wishlist_products_attributes_query = tep_db_query("select products_options_id as po, products_options_value_id as pov from " . TABLE_WISHLIST_ATTRIBUTES . " where customers_id='" . $public_id . "' and products_id = '" . $wishlist['products_id'] . "'");
                    while ($wishlist_products_attributes = tep_db_fetch_array($wishlist_products_attributes_query)) {
                      // We now populate $id[] hidden form field with product attributes
                      echo tep_draw_hidden_field('id['.$wishlist['products_id'].']['.$wishlist_products_attributes['po'].']', $wishlist_products_attributes['pov']);
                      // And Output the appropriate attribute name
                      $attributes = tep_db_query("select popt.products_options_name, poval.products_options_values_name, pa.options_values_price, pa.price_prefix
                                      from " . TABLE_PRODUCTS_OPTIONS . " popt, " . TABLE_PRODUCTS_OPTIONS_VALUES . " poval, " . TABLE_PRODUCTS_ATTRIBUTES . " pa
                                      where pa.products_id = '" . $wishlist_id . "'
                                       and pa.options_id = '" . $wishlist_products_attributes['po'] . "'
                                       and pa.options_id = popt.products_options_id
                                       and pa.options_values_id = '" . $wishlist_products_attributes['pov'] . "'
                                       and pa.options_values_id = poval.products_options_values_id
                                       and popt.language_id = '" . $languages_id . "'
                                       and poval.language_id = '" . $languages_id . "'");
                       $attributes_values = tep_db_fetch_array($attributes);
                       if ($attributes_values['price_prefix'] == '+')
                         { $attributes_addon_price += $attributes_values['options_values_price']; }
                       else if ($attributes_values['price_prefix'] == '-')
                         { $attributes_addon_price -= $attributes_values['options_values_price']; }
                       echo '<br /><small><i> ' . $attributes_values['products_options_name'] . ': ' . $attributes_values['products_options_values_name'] . '</i></small>';
                    } // end while attributes for product

//                    if (tep_not_null($products['specials_new_products_price'])) {
//                       $products_price = '<s>' . $currencies->display_price($products['products_price']+$attributes_addon_price, tep_get_tax_rate($products['products_tax_class_id'])) . '</s> <span class="productSpecialPrice">' . $currencies->display_price($products['specials_new_products_price']+$attributes_addon_price, tep_get_tax_rate($products['products_tax_class_id'])) . '</span>';
//                    } else {
//                       $products_price = $currencies->display_price($products['products_price']+$attributes_addon_price, tep_get_tax_rate($products['products_tax_class_id']));
//                    }


	//TotalB2B start
	$products['products_price'] = tep_xppp_getproductprice($wishlist_id);
    //TotalB2B end

    if ($new_price = tep_get_products_special_price($wishlist_id)) {
      
      //TotalB2B start
//	  $query_special_prices_hide = tep_db_query("select configuration_value from " . TABLE_CONFIGURATION . " WHERE configuration_key = 'SPECIAL_PRICES_HIDE'");
//      $query_special_prices_hide_result = tep_db_fetch_array($query_special_prices_hide); 
      $query_special_prices_hide_result = SPECIAL_PRICES_HIDE; 
      if ($query_special_prices_hide_result == 'true') {
	 	$products_price = '<span class="productSpecialPrice">' . $currencies->display_price_nodiscount($new_price+$attributes_addon_price, tep_get_tax_rate($products['products_tax_class_id'])) . '</span>'; 
	  } else {
	    $products_price = '<s>' . $currencies->display_price_nodiscount($products['products_price']+$attributes_addon_price, tep_get_tax_rate($products['products_tax_class_id'])) . '</s> <span class="productSpecialPrice">' . $currencies->display_price_nodiscount($new_price+$attributes_addon_price, tep_get_tax_rate($products['products_tax_class_id'])) . '</span>';
	  }
      //TotalB2B end

    } else {
      $products_price = $currencies->display_price($products['products_price']+$attributes_addon_price, tep_get_tax_rate($products['products_tax_class_id']));
    }



/*******************************************************************
******* CHECK TO SEE IF PRODUCT HAS BEEN ADDED TO THEIR CART *******
*******************************************************************/

		if($cart->in_cart($wishlist[products_id])) {
			echo '<br /><font color="#FF0000"><b>' . TEXT_ITEM_IN_CART . '</b></font>';
		}

	$i++;
?>
					</td>
					<td valign="top" class="productListing-data"><?php echo $products_price; ?></td>
					<td valign="top" class="productListing-data" align="center"><?php echo tep_draw_checkbox_field('add_wishprod[]',$wishlist['products_id']); ?></td>
				  </tr>

<?php
    }
?>
				</table>
		</td>
	  </tr>
	  <tr>
		<td align="right"><br /><?php echo tep_template_image_submit('button_in_cart.gif', IMAGE_BUTTON_IN_CART, 'name="add_prod" value="add_prod"'); ?></td>
 	  </tr>
	  <tr>
		<td>



<?php
  if ($wishlist_split > 0 && (PREV_NEXT_BAR_LOCATION == '2' || PREV_NEXT_BAR_LOCATION == '3')) {
?>
		<table class="table-padding-2">
        	    <tr>
	             <td class="smallText"><?php echo $wishlist_split->display_count(TEXT_DISPLAY_NUMBER_OF_WISHLIST); ?></td>
            	 <td align="right" class="smallText"><?php echo TEXT_RESULT_PAGE . ' ' . $wishlist_split->display_links(MAX_DISPLAY_PAGE_LINKS, tep_get_all_get_params(array('page', 'info', 'x', 'y'))); ?></td>
      	    </tr>
		</table>
		</td>
	  </tr>

<?php
}
// BOF: Lango Added for template MOD
if (MAIN_TABLE_BORDER == 'yes'){
table_image_border_bottom();
}
// EOF: Lango Added for template MOD
?>  	


	</table>
	

<?php

} else { // Nothing in the customers wishlist

?>

<?php
// BOF: Lango Added for template MOD
if (MAIN_TABLE_BORDER == 'yes'){
$header_text = '&nbsp;';
table_image_border_top(false, false, $header_text);
}
// EOF: Lango Added for template MOD
?>
  <tr>
	<td>
	<table class="table-padding-2">
	  <tr>
		<td><table class="table-padding-0">
		  <tr>
			<td class="main"><?php echo BOX_TEXT_NO_ITEMS;?></td>
		  </tr>
		</table>
		</td>
	  </tr>
	</table>
	</td>
  </tr>

<?php
// BOF: Lango Added for template MOD
if (MAIN_TABLE_BORDER == 'yes'){
table_image_border_bottom();
}
// EOF: Lango Added for template MOD
?>  
  
</table>
</form>

<?php 
}
?>
<!-- customer_wishlist_eof //-->        


        
        </td>
      </tr>
   </table>