    <table border="0" width="100%" cellspacing="0" cellpadding="<?php echo CELLPADDING_SUB; ?>">
	
	 <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.0.0/animate.min.css"
  />
	
<center><strong><span class="animate__animated animate__lightSpeedInLeft animate__delay-1s"><font color="#3366ff" size="5em">Система скидок в нашем магазине</font></span></strong><br />
 Достаточно просто <a style="border-bottom: 2px dotted DarkGreen;" href="https://yourfish.ru/create_account.php">зарегистрироваться</a>, 
 чтобы Вам была установлена спеццена на все товары магазина.<br /><br /> Далее действует накопительная система скидок:<br /> 
 Сумма заказов более 10 000 руб. - скидка 7% на все товары.<br /> Сумма заказов более 20 000 руб. - скидка 9% на все товары.<br /> 
 Сумма заказов более 50 000 руб. - скидка 11% на все товары.<br /> Сумма заказов более 100 000 руб. - скидка 13% на все товары.<br /> 
 Сумма заказов более 150 000 руб. - скидка 15% на все товары.</center>
<p><br /><br /></p>
    
    
<?php
// BOF: Lango Added for template MOD
if (SHOW_HEADING_TITLE_ORIGINAL == 'yes') {
$header_text = '&nbsp;'
//EOF: Lango Added for template MOD
?>
      <tr>
        <td><table class="table-padding-0">
          <tr>
            <td align="center" class="animate__animated animate__lightSpeedInLeft animate__delay-1s"><font color="#3366ff" size="4em"><?php echo "САМЫЕ  ВЫГОДНЫЕ ПРЕДЛОЖЕНИЯ СЕГОДНЯ"; ?></font></td>

          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
<?php
// BOF: Lango Added for template MOD
}else{
$header_text = HEADING_TITLE;
}
// EOF: Lango Added for template MOD
?>
<?php

  //TotalB2B start
  if (!isset($customer_id)) $customer_id = 0;
  $customer_group = tep_get_customers_groups_id();
  $specials_query_raw = "select DISTINCT p.products_id, pd.products_name, p.products_price, p.products_quantity, p.products_status, p.products_tax_class_id, p.products_image from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd where p.products_quantity !='0' AND p.products_quantity <'500' and p.products_status ='1' and p.products_id = pd.products_id and pd.language_id = '" . (int)$languages_id . "' order by RAND()";
  //TotalB2B end


//  $specials_query_raw = "select p.products_id, pd.products_name, p.products_price, p.products_tax_class_id, p.products_image, s.specials_new_products_price from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd, " . TABLE_SPECIALS . " s where p.products_status = '1' and s.products_id = p.products_id and p.products_id = pd.products_id and pd.language_id = '" . (int)$languages_id . "' and s.status = '1' order by s.specials_date_added DESC";

$specials_split = new splitPageResults($specials_query_raw, 250);
  if (($specials_split->number_of_rows > 0) && ((PREV_NEXT_BAR_LOCATION == '1') || (PREV_NEXT_BAR_LOCATION == '3'))) {
?>
      <tr>
        <td><table class="table-padding-2">
          <tr>
            <td class="smallText"><?php echo $specials_split->display_count(TEXT_DISPLAY_NUMBER_OF_SPECIALS); ?></td>
            <td align="right" class="smallText"><?php echo TEXT_RESULT_PAGE . ' ' . $specials_split->display_links(MAX_DISPLAY_PAGE_LINKS, tep_get_all_get_params(array('page', 'info', 'x', 'y'))); ?></td>
          </tr>
        </table></td>
      </tr>
<?php
  }
?>
<?php
// BOF: Lango Added for template MOD
if (MAIN_TABLE_BORDER == 'yes'){
table_image_border_top(false, false, $header_text);
}
// EOF: Lango Added for template MOD
?>

<!-- CSS goes in the document HEAD or added to your external stylesheet -->
<style type="text/css">
table.imagetable {
    font-family: verdana,arial,sans-serif;
    font-size:11px;
    color:#333333;
    border-width: 1px;
    border-color: #999999;
    

}
table.imagetable th {

    border-width: 1px;
    padding: 8px;
    border-style: solid;
    border-color: #999999;
}
table.imagetable td {
    border-width: 1px;
    padding: 8px;
    border-style: solid;
    border-color: #999999;
    border: 1px solid silver;
border-radius:10px;
-moz-border-radius: 10px;
-webkit-border-radius: 10px;
padding: 10px;
    
}
</style>


      <tr>
        <td><table class= "imagetable" width="100%" cellspacing="5" cellpadding="2">
          <tr>
<?php
//$sdiscount = 100 - round($sprice * 100 / $qres['products_price'], 0);
    $row = 0;
    $specials_query = tep_db_query($specials_split->sql_query);
    while ($specials = tep_db_fetch_array($specials_query)) {
      $row++;

	  //TotalB2B start
      $specials['products_price'] = tep_xppp_getproductprice($specials['products_id']);
      //TotalB2B end
      //$skidon=100-round($currencies->display_price_nodiscount($specials['specials_new_products_price'] / $currencies->display_price_nodiscount($specials['products_price'], 0)
      //TotalB2B start
	  $specials['specials_new_products_price'] = tep_get_products_special_price($specials['products_id']);
//	  $query_special_prices_hide = tep_db_query("select configuration_value from " . TABLE_CONFIGURATION . " WHERE configuration_key = 'SPECIAL_PRICES_HIDE'");
//      $query_special_prices_hide_result = tep_db_fetch_array($query_special_prices_hide); 
      $query_special_prices_hide_result = SPECIAL_PRICES_HIDE; 
       $price1 = $specials['products_price'];
      // $price2 = $specials['specials_new_products_price'];         
       $sdiscount = 100 - round($price2 * 100 / $price1, 0);
      
      if ($query_special_prices_hide_result == 'true') {

echo '            <td align="center" width="33%" class="smallText"><a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $specials['products_id']) . '">' . tep_image(DIR_WS_IMAGES . $specials['products_image'], $specials['products_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT) . '</a><br><a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $specials['products_id']) . '">' . $specials['products_name'] . '</a><br><s>' . $currencies->display_price_nodiscount($specials['specials_new_products_price'], tep_get_tax_rate($specials['products_tax_class_id'])) . '</s><br><span class="productSpecialPrice">' . $currencies->display_price_nodiscount($specials['specials_new_products_price'], tep_get_tax_rate($specials['products_tax_class_id'])) . '</span></td>' . "\n";


      } else {
echo '            <td align="center" width="33%" class="smallText"><a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $specials['products_id']) . '">' . tep_image(DIR_WS_IMAGES . $specials['products_image'], $specials['products_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT) . '</a><br><a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $specials['products_id']) . '">' . $specials['products_name'] . '</a><br><s>' . $currencies->display_price_nodiscount($specials['products_price'], tep_get_tax_rate($specials['products_tax_class_id'])) . '</s><br><span class="productSpecialPrice">' . $currencies->display_price_nodiscount($specials['specials_new_products_price'], tep_get_tax_rate($specials['products_tax_class_id'])). '</span></b></nobr></td>' . "\n";

	  }
      //TotalB2B end


   // Lango Added: for Salemaker Mod BOF  
//echo '            <td align="center" width="33%" class="smallText"><a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $specials['products_id']) . '">' . tep_image(DIR_WS_IMAGES . $specials['products_image'], $specials['products_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT) . '</a><br><a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $specials['products_id']) . '">' . $specials['products_name'] . '</a><br><s>' . $currencies->display_price($specials['products_price'], tep_get_tax_rate($specials['products_tax_class_id'])) . '</s><br><span class="productSpecialPrice">' . $currencies->display_price(tep_get_products_special_price($specials['products_id']), tep_get_tax_rate($specials['products_tax_class_id'])) . '</span></td>' . "\n";
   // Lango Added: for Salemaker Mod EOF  

      if ((($row / 3) == floor($row / 3))) {
?>
          </tr>
          <tr>
           
          </tr>
          <tr>
<?php
      }
    }
?>
          </tr>
        </table></td>
      </tr>
<?php
// BOF: Lango Added for template MOD
if (MAIN_TABLE_BORDER == 'yes'){
table_image_border_bottom();
}
// EOF: Lango Added for template MOD
?>
<?php

  //TotalB2B start
  if (!isset($customer_id)) $customer_id = 0;
  $customer_group = tep_get_customers_groups_id();
  $specials_query_raw = "select DISTINCT p.products_id, pd.products_name, p.products_price, p.products_tax_class_id, p.products_image from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd, " . TABLE_SPECIALS . " s where p.products_status = '1' and s.products_id = p.products_id and p.products_id = pd.products_id and pd.language_id = '" . (int)$languages_id . "' and s.status = '1' and ((s.customers_id = '" . $customer_id . "' and s.customers_groups_id = '0') or (s.customers_id = '0' and s.customers_groups_id = '" . $customer_group . "') or (s.customers_id = '0' and s.customers_groups_id = '0')) order by s.specials_date_added DESC";
  //TotalB2B end


  if (($specials_split->number_of_rows > 0) && ((PREV_NEXT_BAR_LOCATION == '2') || (PREV_NEXT_BAR_LOCATION == '3'))) {
?>
      <tr>
        <td><br><table class="table-padding-2">
          <tr>
            <td class="smallText"><?php echo $specials_split->display_count(TEXT_DISPLAY_NUMBER_OF_SPECIALS); ?></td>
            <td align="right" class="smallText"><?php echo TEXT_RESULT_PAGE . ' ' . $specials_split->display_links(MAX_DISPLAY_PAGE_LINKS, tep_get_all_get_params(array('page', 'info', 'x', 'y'))); ?></td>
          
		  
</tr>
        </table></td>
      </tr>
<?php
  }
?>
    </table>

