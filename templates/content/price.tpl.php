<?php
	require('price_settings.php');
	// the following cPath references come from application_top.php
	$category_depth = 'top';
	if (isset($cPath) && tep_not_null($cPath)) {
		$categories_products_query = tep_db_query("select count(*) as total from " . TABLE_PRODUCTS_TO_CATEGORIES . " where categories_id = '" . (int)$current_category_id . "'");
		$cateqories_products = tep_db_fetch_array($categories_products_query);
		if ($cateqories_products['total'] > 0) {
			$category_depth = 'products'; // display products
		} else {
			$category_parent_query = tep_db_query("select count(*) as total from " . TABLE_CATEGORIES . " where parent_id = '" . (int)$current_category_id . "'");
			$category_parent = tep_db_fetch_array($category_parent_query);
			if ($category_parent['total'] > 0) {
				$category_depth = 'nested'; // navigate through the categories
			} else {
				$category_depth = 'products'; // category has no products, but display the 'no products' message
			}
		}
	}
	require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_DEFAULT);
	$breadcrumb->add(TITLE_PRICE, tep_href_link("price.php", '', 'SSL')); 
?>

<table border="0" width="100%" cellspacing="0" cellpadding="<?php echo CELLPADDING_SUB;?>">
<?php 
// Set number of columns in listing
define ('NR_COLUMNS', 2);?>
<?php
// BOF: Lango Added for template MOD
if (SHOW_HEADING_TITLE_ORIGINAL == 'yes') {
$header_text = '&nbsp;'
//EOF: Lango Added for template MOD
?>
      <tr> 
        <td width="100%"><table class="table-padding-0"> 
          <tr>
            <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
            <td class="pageHeading" align="right"><?php echo tep_image(DIR_WS_TEMPLATES . TEMPLATE_NAME . '/images/content/specials.gif', HEADING_TITLE, HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?></td>
          </tr>
        </table></td> 
      </tr>
<?php
// BOF: Lango Added for template MOD
}else{
$header_text = HEADING_TITLE;
}
// EOF: Lango Added for template MOD
?>

<?php
// BOF: Lango Added for template MOD
if (MAIN_TABLE_BORDER == 'yes'){
table_image_border_top(false, false, $header_text);
}
// EOF: Lango Added for template MOD
?>



<!-- body //-->
<tr>
<td>
<?php 
// есть у группы продукты?
// group have products?
function check_products($id_group){
	$products_price_query = tep_db_query("select products_to_categories.products_id FROM products_to_categories where products_to_categories.categories_id = ".$id_group." LIMIT 0,1");
	if(tep_db_fetch_array($products_price_query)){
		return true;	
	}
	return false;
}

// выводим список продуктов определенной группы $id_group
// list products determined group
function get_products($id_group){
	global $currencies;
	global $languages_id;
	
	$query = "";
	if(!SHOW_MARKED_OUT_STOCK){
		$query = " and products.products_status = 1";
	}
	if(USED_QUANTITY){
		$query = $query." and products.products_quantity <> 0";
	}
	$products_price_query = tep_db_query("select products_description.products_name, products_tax_class_id, products.products_quantity, products.products_price, products.products_model, products_to_categories.products_id, products_to_categories.categories_id FROM products, products_description, products_to_categories where products.products_id = products_description.products_id".$query." and products.products_id = products_to_categories.products_id and products_to_categories.categories_id = ".$id_group." and products_description.language_id = ".$languages_id);
	$x=0;
	while ($products_price = tep_db_fetch_array($products_price_query)){
		if($x==1) {
			$col = "#ffffff";
			$x = 0;	
		}else{
			$col = "#e5e5e5";
			$x++;
		}

	//TotalB2B start & TotalB2B start

	if ($new_price = tep_get_products_special_price($products_price['products_id'])) {
    $col = "#FFEAEA";
     $products_price['products_price'] = $new_price; // Обычная цена
     $products_price['specials_new_products_price'] = tep_xppp_getproductprice($products_price['products_id']); // Спец. цена
	  $cell = $currencies->display_price_nodiscount($products_price['products_price'], tep_get_tax_rate($products_price['products_tax_class_id']));
    } else {
     $products_price['products_price'] = $new_price; // Обычная цена
     $products_price['specials_new_products_price'] = tep_xppp_getproductprice($products_price['products_id']); // Спец. цена
	  $cell = $currencies->display_price($products_price['specials_new_products_price'], tep_get_tax_rate($products_price['products_tax_class_id']));
    }


//		$cell = tep_get_products_special_price($products_price['products_id']);
//		if($cell == 0)
//			$cell = $products_price['products_price'];

         // BOF FlyOpenair: Extra Product Price
//         $cell = extra_product_price($cell);
         // EOF FlyOpenair: Extra Product Price
			
//		$cell = $currencies->display_price($cell,TAX_INCREASE);

//		}else{
//			$col = "#FFEAEA";
//		}
		$quantity = "";
		$model = "";
		if(SHOW_QUANTITY)
			$quantity = "<td width=\"100\" align=\"right\" class=\"boxText\">(".$products_price['products_quantity'].")</td>";
		if(SHOW_MODEL)
			$model = "<td width=\"100\" align=\"right\" class=\"boxText\">[".$products_price['products_model']."]</td>";
		print "<tr bgcolor=\"".$col."\">".$model."<td width=\"80%\" class=\"boxText\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"" . tep_href_link(FILENAME_PRODUCT_INFO, "products_id=" . $products_price['products_id']) . "\">".$products_price['products_name']."</a></td>".$quantity."<td width=\"20%\" align=\"right\" class=\"boxText\">".$cell."</td></tr>";
	}
}

// рекурсивная функция, получает группы по порядку
// get all groups
function get_group($id_parent,$position){
global $languages_id;
$groups_price_query = tep_db_query("select categories.categories_id, categories_description.categories_name from
categories, categories_description where categories_status=1 and categories.categories_id = categories_description.categories_id and
categories.parent_id = ".$id_parent." and categories_description.language_id = '" . (int)$languages_id . "' order by
categories.sort_order");

	while ($groups_price = tep_db_fetch_array($groups_price_query)){
		$str = "";
		for($i = 0; $i < $position; $i++){
			$str = $str . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
		}
		$class = "productListing-heading";
		if($position == 0) {
			$class = "headerNavigation";
			print "<tr><td colspan=\"4\" width=\"1000\" class=\"boxText\">&nbsp;</td></tr>"; // пустая строка
		}
		if(check_products($groups_price['categories_id']) || $position == 0){
			print "<tr><td colspan=\"4\" width=\"1000\" class=\"infoBoxHeading\"><font color=\"black\">".$str.$groups_price['categories_name']."</font></td></tr>";
			get_products($groups_price['categories_id']);
		}
		get_group($groups_price['categories_id'],$position+1); // следующая группа
	}
}
?>
<table width="100%" border="0" cellspacing="1" cellpadding="0">
<?php 
  get_group(0,0);
?>
</table>
		<!-- body_text_eof //-->
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
  
    