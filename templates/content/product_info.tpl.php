
<style>
    a.qzoom{display:block;margin-top:10px;font-size:12px;color:red;font-weight:bold;}
</style>

<?php echo tep_draw_form('cart_quantity', tep_href_link(FILENAME_PRODUCT_INFO, tep_get_all_get_params(array('action')) . 'action=add_product')); ?>
<div itemscope itemtype="http://schema.org/Product">
    <table border="0" width="100%" cellspacing="0" cellpadding="<?php echo CELLPADDING_SUB;?>">
        <?php
        $special_price = false;
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
        $product_info_query = tep_db_query("select pd.products_info,p.products_group,pd.products_bottom_name,pd.products_top_name,pd.products_top_content,pd.products_bottom_content,p.products_id, pd.products_name, pd.products_description, p.products_model, p.products_quantity, p.products_image, p.products_image_med, p.products_image_lrg, p.products_image_sm_1, p.products_image_xl_1, p.products_image_sm_2, p.products_image_xl_2, p.products_image_sm_3, p.products_image_xl_3, p.products_image_sm_4, p.products_image_xl_4, p.products_image_sm_5, p.products_image_xl_5, p.products_image_sm_6, p.products_image_xl_6, pd.products_url, p.products_price, p.products_tax_class_id, p.products_date_added, p.products_date_available, p.manufacturers_id, p.products_ordered, pd.products_viewed from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd where p.products_status = '1' and p.products_id = '" . (int)$_GET['products_id'] . "' and pd.products_id = p.products_id and pd.language_id = '" . (int)$languages_id . "'");
        // EOF MaxiDVD: Modified For Ultimate Images Pack!
        $product_info = tep_db_fetch_array($product_info_query);

        tep_db_query("update " . TABLE_PRODUCTS_DESCRIPTION . " set products_viewed = products_viewed+1 where products_id = '" . (int)$_GET['products_id'] . "' and language_id = '" . (int)$languages_id . "'");

        //TotalB2B start
        $product_info['products_price'] = tep_xppp_getproductprice($product_info['products_id']);
        //TotalB2B end

        if (($new_price = tep_get_products_special_price($product_info['products_id'])) and ($product_info['manufacturers_id']<>50)) { //условие для отключения скидок на косадаку
            //TotalB2B start
//      $query_special_prices_hide = tep_db_query("select configuration_value from " . TABLE_CONFIGURATION . " WHERE configuration_key = 'SPECIAL_PRICES_HIDE'");
//      $query_special_prices_hide_result = tep_db_fetch_array($query_special_prices_hide);
            $query_special_prices_hide_result = SPECIAL_PRICES_HIDE;

            if ($query_special_prices_hide_result == 'true') {
                $products_price = '<span class="productSpecialPrice">' . $currencies->display_price_nodiscount($new_price, tep_get_tax_rate($product_info['products_tax_class_id'])) . '</span>';
            } else {
                $special_price = true;
                $query_special_prices_hide = tep_db_query("select expires_date from " . TABLE_SPECIALS . " WHERE products_id=".$product_info['products_id']);

                $product_to_categories_query = tep_db_query("select categories_id from " . TABLE_PRODUCTS_TO_CATEGORIES . " where products_id = '" . $product_info['products_id'] . "'");
                $product_to_categories = tep_db_fetch_array($product_to_categories_query);
              $sale_query = tep_db_query("select  sale_date_end,
    if (" . $product_info['products_quantity'] . ">=sale_quantity,sale_deduction_value_2,sale_deduction_value) as sale_deduction_value from " . TABLE_SALEMAKER_SALES . " where sale_categories_all like '%," . $product_to_categories['categories_id'] . ",%' and sale_status = '1' and (sale_date_start <= now() or sale_date_start = '0000-00-00') and (sale_date_end >= now() or sale_date_end = '0000-00-00') and (sale_pricerange_from <= '" . $product_info['products_price'] . "' or sale_pricerange_from = '0') and (sale_pricerange_to >= '" . $product_info['products_price'] . "' or sale_pricerange_to = '0')
    having sale_deduction_value>0");
                $sale_info = tep_db_fetch_array($sale_query);
                $products_price = (empty($page_cache)?('<s>' . $currencies->display_price_nodiscount($product_info['products_price'], tep_get_tax_rate($product_info['products_tax_class_id'])) . '</s> <span class="productSpecialPrice">' . $currencies->display_price_nodiscount($new_price, tep_get_tax_rate($product_info['products_tax_class_id'])). '</span>'):"<%PRODUCT_PRICE%>");
            }
            //TotalB2B end

        } else {
            $products_price = $currencies->display_price($product_info['products_price'], tep_get_tax_rate($product_info['products_tax_class_id']));
        }

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

            $yad_price = explode(" ", $products_price);
            ?>
            <tr>
                <td><table class="table-padding-0">
                        <tr>
                            <td class="nazvtovar creditgoods" valign="top"><div itemprop="name"><h1 style = "font-size: 1.2em"><?php echo $products_name; ?></h1></div></td>
                            <td class="nazvtovar" align="right" valign="top">

                            </td>
                        </tr>
                        <?php
                        /*by iHolder top name with content*/
                        if (strlen($product_info['products_top_name'])>0){?>
                            <tr><td colspan="2">
                                    <a href="javascript:void();" onclick="document.getElementById('maintext_top').style.display = document.getElementById('maintext_top').style.display == 'block' ? 'none':'block'; return false;" style="font-size: 10px;">
                                        <h2><?php echo $product_info['products_top_name']?></h2>
                                    </a>
                                    <div id="maintext_top" class="maintext" style="display: none;"><?php echo $product_info['products_top_content'];?></div>
                                </td></tr>
                        <?php }?>


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
                        <!--      <tr>
                               </td>
                              </tr>
                        -->
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

                <table width="100%" border="0" cellspacing="0" cellpadding="2" align="left" class="piib">
                    <!--</td>
                    </tr>-->
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
                            <?php if (!$ajax_load){?>
                                <script type="text/javascript" src="jscript/jquery/jquery.js"></script>
                            <link rel="stylesheet" type="text/css" href="/ext/js/counter.css?v=1" />
                                <script type="text/javascript" src="/ext/js/jquery.countdown.min.js?v=1"></script>
                                <script type="text/javascript">
                                    $(document).ready(function() {
                                        $("a.zoom").fancybox({
                                              
                                            "zoomOpacity"            : true,
                                            "overlayShow"            : false,
                                            "zoomSpeedIn"            : 500,
                                            "zoomSpeedOut"            : 500,
                                            "showNavArrows"          : true
                                         });
                                    });
                                </script>
                            <?php }else{ ?>
                            <link rel="stylesheet" type="text/css" href="/ext/colorbox/colorbox.css" />
                                <script type="text/javascript" src="/ext/colorbox/jquery.colorbox-min.js"></script>
                                <script type="text/javascript">
                                    jQuery("a.zoom").colorbox({maxWidth:'100%',maxHeight:'100%'});
                                </script>

                            <?php } ?>
                            <?php
                            echo '<a class="zoom" title="'.addslashes($product_info['products_name']).'" alt="'.addslashes($product_info['products_name']).'" itemprop="image" rel="group" href="' . STATIC_DOMAIN.DIR_WS_IMAGES . $popup_image . '"><figure>' . tep_image(STATIC_DOMAIN.DIR_WS_IMAGES . $new_image, addslashes($product_info['products_name']), $image_width, $image_height, 'hspace="5" vspace="5"') . '<figcaption>'.$product_info['products_name'].'</figcaption></figure><br>' . tep_template_image_button('image_enlarge.gif', TEXT_CLICK_TO_ENLARGE) . '</a>';
                            //	if (!$ajax_load){
                            //	echo '<a class="zoom"  itemprop="image" rel="group" href="' . tep_href_link(DIR_WS_IMAGES . $popup_image) . '">' . tep_image(DIR_WS_IMAGES . $new_image, addslashes($product_info['products_name']), $image_width, $image_height, 'hspace="5" vspace="5"') . '<br>' . tep_template_image_button('image_enlarge.gif', TEXT_CLICK_TO_ENLARGE) . '</a>';
                            //	}else{
                            //	echo '<a class="zoom"  itemprop="image" rel="group" href="' . tep_href_link(DIR_WS_IMAGES . $popup_image) . '">' . tep_image(DIR_WS_IMAGES . $new_image, addslashes($product_info['products_name']), $image_width, $image_height, 'hspace="5" vspace="5"') . '<br>' . tep_template_image_button('image_enlarge.gif', TEXT_CLICK_TO_ENLARGE) . '</a>';
                            //	echo tep_image(DIR_WS_IMAGES . $new_image, addslashes($product_info['products_name']), $image_width, $image_height, 'hspace="5" vspace="5"') ;
                            //	}
                            ?>
                            </a>
                            <!-- // EOF MaxiDVD: Modified For Ultimate Images Pack! //-->
                        </td>
                        <td>
                            <table class="table-padding-2">
                                <?php
                                if(!empty($product_info['products_group'])):?>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td>
                                            <div class="product-models">
                                                <?php
                                                $query_cat = tep_db_query("select categories_id as id from " . TABLE_PRODUCTS_TO_CATEGORIES . " where products_id=" . (int)$_GET['products_id']);
                                                $current_cat = tep_db_fetch_array($query_cat);
                                                $current_cat = $current_cat['id'];
                                                $products_models_query_str = "SELECT pr.products_quantity, pr.products_id, pr.products_tax_class_id,pd.products_name,pr.products_model_tag,pr.products_model,pr.products_image as image
FROM `".TABLE_PRODUCTS_TO_CATEGORIES."` as cat
INNER JOIN `".TABLE_PRODUCTS."` as pr on (pr.products_id = cat.products_id)
INNER JOIN `".TABLE_PRODUCTS_DESCRIPTION."` as pd on (pd.products_id = pr.products_id)
WHERE cat.`categories_id` = {$current_cat} AND pr.products_quantity>0 AND pr.products_group = '{$product_info['products_group']}'
AND pr.products_status=\"1\"";
                                                $products_models_query = tep_db_query($products_models_query_str);
                                                $counts_models = tep_db_num_rows($products_models_query);
                                                ?>

                                                <div class="product-models-header">Модельный ряд (<?=$counts_models?> шт.)
                                                    <?php if ($counts_models > 28 ) { ?> -
                                                        <a class="view-models dashed" href="/#swb_3"><span>Просмотр списком</span></a>
                                                    <?php } ?>
                                                </div>
                                                <div class="product-models-wrap max-height">
                                                    <?php  while ($products_model = tep_db_fetch_array($products_models_query)){
                                                        $active= '';
                                                        if($products_model['products_id'] == $_GET['products_id']){
                                                            $active= 'active';
                                                        }
                                                        ?>
                                                        <a class="product-model <?=$active?>" href="<?=tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $products_model['products_id'])?>">
                                                            <div>
                                                                <?=tep_image(STATIC_DOMAIN . DIR_WS_IMAGES .$products_model['image'], $products_model['products_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT);?></div>
                                                            <span class="model-size"><?=$products_model['products_model_tag']?></span>
                                                        </a>    <?php } ?>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endif;?>
                                <tr>
                                    <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
                                    <td class="main"><?php
                                        //echo '<a href="' . tep_href_link(FILENAME_PRODUCT_REVIEWS, tep_get_all_get_params()) . '">' . tep_template_image_button('button_reviews.gif', IMAGE_BUTTON_REVIEWS) . '</a>';
                                        ?></td>
                                    <td id="btns-click" class="main" align="right">
                                        <div itemprop="offers" itemscope itemtype="http://schema.org/Offer">
                                            <?php $ip_price= round($product_info['products_price'],0);
                                            if (strlen($new_price)>0){$ip_price=round($new_price,0);}
                                            ?>
                                            <meta itemprop="price" content="<? echo $ip_price; ?>">
                                            <meta itemprop="priceCurrency" content="RUB">
                                        </div>
                                        <?php if ($product_info['products_quantity']>0) { ?>
											<div class="creditprice" style="display:none"><?=str_replace(',','',$products_price)?></div>
											
											<style>
											div.pppprice{font-size:1.2Em;font-weight:bold}
											</style>
											
                                            <div class="pppprice"><?=(empty($page_cache)?$products_price:"<%PRODUCT_PRICE%>") ?></div>



											<?php
                                            if ($special_price) { ?>
                                                <div class="sale-count">Скидка действует еще:</div>
                                                <div id="formCountbox" <?php if(isset($sale_info) && !empty($sale_info['sale_date_end'])){
                                                    echo 'data-date="'.$sale_info['sale_date_end'].'""';
                                                } ?>>
                                                </div>
                                            <?php }
                                        }
                                        ?>
                                        <div class="product-attrs">
                                            <?php
                                            }
                                            $products_attributes_query = tep_db_query("select count(*) as total from " . TABLE_PRODUCTS_OPTIONS . " popt, " . TABLE_PRODUCTS_ATTRIBUTES . " patrib where patrib.products_id='" . (int)$_GET['products_id'] . "' and patrib.options_id = popt.products_options_id and popt.language_id = '" . (int)$languages_id . "'");
                                            $products_attributes = tep_db_fetch_array($products_attributes_query);

                                            if ($products_attributes['total'] > 0) {
                                            // otf 1.71 added width
                                            ?>
                                            <?php
                                            // otf 1.71 Update query to pull option_type
                                            $products_options_name_query = tep_db_query("select distinct popt.products_options_id, popt.products_options_name, popt.products_options_type, popt.products_options_length, popt.products_options_comment from " . TABLE_PRODUCTS_OPTIONS . " popt, " . TABLE_PRODUCTS_ATTRIBUTES . " pa where pa.products_id='" . (int)$_GET['products_id'] . "' and pa.options_id = popt.products_options_id and popt.language_id = '" . (int)$languages_id . "' order by popt.products_options_sort_order, popt.products_options_name");
                                            while ($products_options_name = tep_db_fetch_array($products_options_name_query)) {
                                            // otf 1.71 relocate arrays to each type of field
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

                                    <td class="main"><?php echo $products_options_name['products_options_name'] . ':'; ?></td>
                                    <td class="main"><?php echo $tmp_html;  ?></td>

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
                        <script>textCounter(document.getElementById("id[' . TEXT_PREFIX . $products_options_name['products_options_id'] . ']"),"progressbar' . $products_options_name['products_options_id'] . '",' . $products_options_name['products_options_length'] . ')</script>';?>    <!-- DDB - 041031 - Form Field Progress Bar //-->

                                        <?php
                                        if ($products_attribs_array['options_values_price'] != '0') {
                                            echo '<td class=\"main\">'.$products_options_name['products_options_name'].'<br>('.$products_options_name['products_options_comment'].' '.$products_attribs_array['price_prefix'] . $currencies->display_price($products_attribs_array['options_values_price'], tep_get_tax_rate($product_info['products_tax_class_id'])) . ')'.'</td>';
                                        } else {
                                            echo '<td class=\"main\">'.$products_options_name['products_options_name'].'<br>('.$products_options_name['products_options_comment'].')'.'</td>';
                                        }
                                        ?>
                                        <td class="main" width="75%"><?php echo $tmp_html;  ?></td>

                                        <?php
                                        break;

                                    case PRODUCTS_OPTIONS_TYPE_RADIO:
// otf 1.71 Add logic for radio buttons
                                        $tmp_html = '<table>';
                                        $products_options_query = tep_db_query("select pov.products_options_values_id, pov.products_options_values_name, pa.options_values_price, pa.price_prefix from " . TABLE_PRODUCTS_ATTRIBUTES . " pa, " . TABLE_PRODUCTS_OPTIONS_VALUES . " pov where pa.products_id = '" . (int)$_GET['products_id'] . "' and pa.options_id = '" . $products_options_name['products_options_id'] . "' and pa.options_values_id = pov.products_options_values_id and pov.language_id = '" . $languages_id . "' order by pa.products_options_sort_order");
                                        $checked = true;
                                        while ($products_options_array = tep_db_fetch_array($products_options_query)) {
                                            $tmp_html .= '<tr><td class="main" bgcolor="edecea">';
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

                                        <td class="main"><?php echo $products_options_name['products_options_name'] . ':'; ?></td>
                                        <td class="main"><?php echo $tmp_html;  ?></td>

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
                                                $products_options_array[sizeof($products_options_array)-1]['text'] .= ' (' . $products_options['price_prefix'] . round($products_options['options_values_price']).' руб.) ';
                                            }
                                        }

                                        if (isset($cart->contents[$_GET['products_id']]['attributes'][$products_options_name['products_options_id']])) {
                                            $selected_attribute = $cart->contents[$_GET['products_id']]['attributes'][$products_options_name['products_options_id']];
                                        } else {
                                            $selected_attribute = false;
                                        }
                                        ?>
                                        <div class="main"><label><?php echo $products_options_name['products_options_name'] . ':'; ?> </label>
                                            <span><?php echo tep_draw_pull_down_menu('id[' . $products_options_name['products_options_id'] . ']', $products_options_array, $selected_attribute) . $products_options_name['products_options_comment'];  ?></span></div>
                                    <?php
                                    }  // otf 1.71 end switch
                                    } // otf 1.71 end while
                                    ?>

    <?php
    } // otf 1.71 end if

    ?></div>
    <div class="clearfix"></div>
<?php
if ($product_info['products_quantity']>0){
    echo empty($page_cache) ? PRODUCTS_ORDER_QTY_TEXT . '<input type="text" name="cart_quantity" value="' .
        (tep_get_products_quantity_order_min($_GET['products_id'])) . '" maxlength="3" size="3">
                       ' . ((tep_get_products_quantity_order_min($_GET['products_id'])) > 1 ? PRODUCTS_ORDER_QTY_MIN_TEXT .
            (tep_get_products_quantity_order_min($_GET['products_id'])) : "") . ' ' .
        (tep_get_products_quantity_order_min($_GET['products_id']) > 1 ? PRODUCTS_ORDER_QTY_UNIT_TEXT . (tep_get_products_quantity_order_units($_GET['products_id'])) : "") . '
                        <br>' . tep_draw_hidden_field('products_id', $product_info['products_id']) .
        tep_template_image_submit('button_in_cart.gif', IMAGE_BUTTON_IN_CART) : "<%PRODUCT_BUY%>";
}
else{
    echo empty($page_cache)?tep_image(STATIC_DOMAIN.DIR_WS_IMAGES.'nt_nw_tm.jpg'):"<%PRODUCT_PRICE%>";
    echo '</div><div class="clearfix"></div>';
    echo empty($page_cache)?'':"<%PRODUCT_BUY%>";
    //  echo tep_image(STATIC_DOMAIN.DIR_WS_IMAGES.'nt_nw_tm.jpg');
}
?>

   

    <?php echo Display1Click('superfast.png');?>
    <button type="button" class="btn_1click" >Купить в  1 клик</button>
    <script type="text/javascript">
        
               
                       var clicable=false;
                        $('.btn_1click').click(function(){
                                    if(!clicable) {
                                            clicable=true;
                                            $(this).parents("form[name='cart_quantity']").submit();
                                            //$("form[name='cart_quantity']").submit();
                                        setTimeout(function(){
                                            $('.a_one_click').eq(0).click();
                                        },500);
                                    }
                                    

                        })
                        

                
                
           
       
    </script>
	<style>
	.gocredit{
		display:block;
		background: #719cca;
		border: none;
		text-transform: uppercase;
		width: 85px;
		padding: 5px 5px;
		cursor: pointer;
		text-align: center;
		color: #0d0c0cc9;
		margin-top:10px;
	}
	.gocredit:hover{opacity:0.8}
	</style>

        <style>p.instore{color:blue;font-weight:bold;font-style:Italic; font-size:12px;}</style>
        <?php
        if ($product_info['products_quantity']<9999 and $product_info['products_quantity']>0) {
           echo empty($page_cache) ? '<p class="instore">В наличии</p>' : "<%IN_STOCK%>";
        }
        if  ($product_info['products_quantity']>=9999) {
            echo  empty($page_cache) ? '<p class="instore">В наличии</p>' : "<%IN_STOCK%>";
        }
        if (!(tep_session_is_registered('customer_id') and ($guest_account == false))) {
            echo '<p><a href="/login.php" style="
            color: blue;
            text-decoration: underline;
        " target="_blank">Войдите</a> или <a href="/create_account.php" style="
            color: blue;
            text-decoration: underline;
        " target="_blank">зарегистрируйтесь</a>, чтобы увидеть <b>СПЕЦ. ЦЕНУ<b></p>';
        }

        if ($product_info['products_quantity']>0){
            if (!$ajax_load){
                ?>
                <a class="qzoom" href="<?=tep_href_link(FILENAME_PRODUCT_QUESTION,'pid='.$product_info['products_id']);?>">Поторговаться</a>
                <?php
            }//---ajax load ?>
            <?php
        }else {
            echo '<a style="color:red;font-weight:bold;font-size:0.8Em;" href="'.$breadcrumb->_trail[1]['link'].'">Похожие снасти в наличии</a><br>';
//if ($ajax_load){
            if (tep_session_is_registered('customer_id')){
                echo '<br><a class="nzoom" style="color:red;font-weight:bold;font-size:0.8Em;" href="'.HTTP_SERVER.'/notify.php?todo=n_add&notify='.$product_info['products_id'].'">Уведомить о поступлении</a>';
            }else{
                echo '<br><a style="color:red;font-weight:bold;font-size:0.8Em;" href="'.HTTP_SERVER.'/create_account.php">Зарегистрируйтесь, чтобы<br> получить уведомление о поступлении</a>';}
//    }//--ajax load
        }
        ?>
        <p style="    color: #2660b8;    font-weight: bold;">При покупке любой снасти стоимостью выше двух тысяч рублей,
            <b style="    color: red;
">блесна Mikado</b> на выбор магазина в <b style="    color: red;">ПОДАРОК!</b></p>
    </td>
    <!--               <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td> -->
</tr>



    </table>



    </td>
    </table>
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
<?php
if (tep_not_null($product_info['products_url'])) {
    ?>
    <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
    </tr>
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

    <?php
} else {
    ?>

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
    <!--          <tr class="infoBoxContents">
            <td>
</td>
</tr>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>-->

<tr>
    <td>
        <div class="piib">
            <p><b><?php echo stripslashes($product_info['products_info']); ?></b></p>

            <!-- Yandex.RTB R-A-264052-1 -->
            <!-- <div id="yandex_rtb_R-A-264052-1"></div> -->
            <!--<script type="text/javascript" src="//yandex.st/share/share.js" charset="utf-8"></script>

            <div class="yashare-auto-init" data-yashareType="button" data-yashareQuickServices="yaru,vkontakte,facebook,twitter,odnoklassniki,moimir,friendfeed,lj"></div>-->


            <script src="https://yastatic.net/es5-shims/0.0.2/es5-shims.min.js"></script>
<script src="https://yastatic.net/share2/share.js"></script>
<div style="position: static;background: none; border: none;opacity: 1" class="ya-share2 ya-share2-card" data-services="vkontakte,facebook,odnoklassniki,moimir,twitter,lj" data-limit="3"></div>
<style type="text/css">
	.ya-share2-card span.ya-share2__title {
    display: inline;
}
</style>

            <p><b>Артикул: <?=$product_info['products_model'];?></b></p>
 

            
        </div>

        <p>
            <?php
            $reviews_query = tep_db_query("select r.reviews_id, r.customers_name, r.date_added, rd.reviews_text, r.reviews_rating FROM reviews r, reviews_description rd WHERE r.status_otz = '1' and r.reviews_id = rd.reviews_id AND r.products_id = '" . (int)$_GET['products_id'] . "' AND rd.languages_id = '" . (int)$languages_id . "' ORDER BY r.date_added DESC LIMIT " . MAX_REVIEWS);
            ?>
        <div class="swtch">
            <div class="swh">
                <?php if($counts_models > 28){ ?><span rel="3">Модели (<?=tep_db_num_rows($products_models_query)?>)</span><?php } ?>
                <span rel="1"><?php echo TEXT_TAB_DESCRIPTION;?></span>
                <span rel="2"><?php echo TEXT_TAB_REVIEWS." ($reviews_query->num_rows)"?></span>
            </div>
            <?php

            if($counts_models > 28){ ?>
                <div id="swb_3" style="display:none;"  class="swb"  >
                    <div class="product-models-tab">
                        <table class="product-models-table">
                            <tbody><tr>
                                <th></th>
                                <th><span>модель</span></th>
                                <th>
                                    <div><span>Артикул</span></div>
                                </th>
                                <th><span>цена (руб)</span></th>
                            </tr>
                            <?php
                            $products_models_query = tep_db_query($products_models_query_str);
                            while ($products_model = tep_db_fetch_array($products_models_query)){
                                ?>
                                <tr>
                                    <td class="model-image">
                                        <a href="<?= tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $products_model['products_id']) ?>">
                                            <div class="image">
                                                <?= tep_image(STATIC_DOMAIN . DIR_WS_IMAGES . $products_model['image'], $products_model['products_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT); ?>
                                            </div>
                                        </a>
                                    </td>
                                    <td class="model-name">
                                        <div class="model-name"><a
                                                    href="<?= tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $products_model['products_id']) ?>">
                                                <?=$products_model['products_name']?></a></div>
                                    </td>
                                    <td><?=$products_model['products_model']?></td>
                                    <td><?php
                                        $products_model['products_price'] = tep_xppp_getproductprice($products_model['products_id']);
                                        if ($new_price = tep_get_products_special_price($products_model['products_id'])) {
                                            $special_price = true;
                                            $products_price = '<s>' . $currencies->display_price_nodiscount(
                                                    $products_model['products_price'],
                                                    tep_get_tax_rate($products_model['products_tax_class_id'])
                                                ) . '</s> <span class="productSpecialPrice">' .
                                                $currencies->display_price_nodiscount(
                                                    $new_price,
                                                    tep_get_tax_rate($products_model['products_tax_class_id'])
                                                ) . '</span>';
                                        } else {
                                            $products_price = $currencies->display_price(
                                                $products_model['products_price'],
                                                tep_get_tax_rate($products_model['products_tax_class_id'])
                                            );
                                        }
                                        echo $products_price;
                                        ?></td>

                                </tr>
                            <?php } ?>

                            </tbody></table>
                    </div>
                </div>
            <?php } ?>
            <div id="swb_1" style="display:block;" class="swb" itemprop="description">
                <?php echo stripslashes($product_info['products_description']); ?></div>
            <div id="swb_2" class="swb"><?php

                $info_box_contents = array();
                $reviewCount = 0;
                $ratingValue = 0;
                while ($reviews = tep_db_fetch_array($reviews_query)) {
                    $date = explode(' ',$reviews['date_added']);
                    $reviewCount++;
                    $ratingValue+=$reviews['reviews_rating'];
                    $info_box_contents[][0] = array('align' => 'left',
                        'params' => 'class="smallText top-valign" itemprop="review" itemscope itemtype="http://schema.org/Review"',
                        'text' => '<a href="' .
                            tep_href_link(FILENAME_PRODUCT_REVIEWS_INFO, 'products_id=' . (int)$_GET['products_id'] .
                                '&reviews_id=' . $reviews['reviews_id']) . '"><b itemprop="author">' . $reviews['customers_name'] .
                            '</b>'.
                            '<span itemprop="reviewRating" itemscope itemtype="http://schema.org/Rating">
                                  <meta itemprop="worstRating" content = "1">
                                  <meta itemprop="ratingValue" content="'.$reviews['reviews_rating'].'">
                                  <meta itemprop="bestRating" content = "5">
                                </span>'
                            .'<meta itemprop="datePublished" content="'.$date[0].'">&nbsp;-&nbsp;'. tep_date_short($reviews['date_added']) . '&nbsp;'
                            . tep_image(STATIC_DOMAIN.DIR_WS_IMAGES . 'stars_' . $reviews['reviews_rating'] . '.gif' ,
                                sprintf(BOX_REVIEWS_TEXT_OF_5_STARS, $reviews['reviews_rating'])) . '</a><br> <div itemprop="description">' .
                            $reviews['reviews_text'].'</div>');

                }
                if(empty($reviewCount)) $reviewCount = 1;
                $ratingValue/=$reviewCount;
                if (sizeof($info_box_contents)==0){
                    $info_box_contents[][0] = array('align' => 'left',
                        'params' => 'class="smallText top-valign"',
                        'text' => NO_REVIEWS_TEXT);

                }else{

                    echo '<div itemprop="aggregateRating"
    itemscope itemtype="http://schema.org/AggregateRating">
   <meta itemprop="ratingValue" content="'.$ratingValue.'" > 
   <meta itemprop="reviewCount" content="'.$reviewCount.'"> </div>';
                }

                new contentBox($info_box_contents);
                /* if (MAIN_TABLE_BORDER == 'yes'){
                     $info_box_contents = array();
                     $info_box_contents = array();
                     $info_box_contents[] = array('align' => 'left',
                                                  'text'  => tep_draw_separator('pixel_trans.gif', '100%', '1')
                                                 );
                   }*/
                echo '<a class="qzoom" style="padding-top:5px;" href="' . tep_href_link('/rw.php', tep_get_all_get_params()) . '">' .
                    tep_template_image_button('button_write_review.gif',IMAGE_BUTTON_WRITE_REVIEW) .
                    '</a>';
                ?>

            </div></div>
        <script type="text/javascript">
            (function ($) {
                $(document).ready(function () {
                    $('.view-models').click(function(){
                        $('.swb').hide();
                        $('#swb_3').show();
                        $("html, body").animate({ scrollTop: $('#swb_3').offset().top }, 1000);
                        return false;
                    });
                    $("a.qzoom").fancybox({
                        "imageScale"        :true,
                        "modal"            :false,
                        "hideOnContentClick"    :false,
                        "zoomOpacity"        : true,
                        "showCloseButton"    : true,
                        "overlayShow"        : false,
                        "zoomSpeedIn"        : 500,
                        "zoomSpeedOut"        : 500
                    });

                    $("a.nzoom").fancybox({
                        "imageScale"        :true,
                        "modal"            :true,
                        "hideOnContentClick"    : true,
                        "zoomOpacity"        : true,
                        "showCloseButton"    : false,
                        "overlayShow"        : false,
                        "zoomSpeedIn"        : 500,
                        "zoomSpeedOut"        : 500,
                        'onComplete': function(){
                            setTimeout( function() {$.fancybox.close(); },2000);
                        }
                    });

                    /*  $("div.swb").css('width',$("div.swh").width());*/
                    $("div.swh").find('span').click(function(){
                        dt=$(this).attr('rel');
                        $("div.swb").hide();
                        $("#swb_"+dt).show();
                    });
                })})(jQuery);
        </script>
        <script type="text/javascript">
            <?php if ($ajax_load){?>
            $(".piib input[rel$='submit_button']").each(function () {
                var frm = $(this).parents('form:first');
                $('<input>').attr({
                    type: 'hidden',
                    name: 'buytype',
                    value: 'ajax'
                }).appendTo(frm);
                $(frm).submit(function () {
                    BuySubmit(this);
                    return false;
                });
            });
            <?php } ?>
            (function(w, d, n, s, t) {
                w[n] = w[n] || [];
                w[n].push(function() {
                    Ya.Context.AdvManager.render({
                        blockId: "R-A-264052-1",
                        renderTo: "yandex_rtb_R-A-264052-1",
                        async: true
                    });
                });
                t = d.getElementsByTagName("script")[0];
                s = d.createElement("script");
                s.type = "text/javascript";
                s.src = "//an.yandex.ru/system/context.js";
                s.async = true;
                t.parentNode.insertBefore(s, t);
            })(this, this.document, "yandexContextAsyncCallbacks");
        </script>
        <!--          </p>

        </div>-->
        <?php if ($ajax_load){?>
            <div class="qvstep"><a href="<?php echo tep_href_link(FILENAME_PRODUCT_INFO, tep_get_all_get_params(array('action','ajax')))?>">Перейти на страницу товара</a></div>
        <?php } ?>
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

        <?
        /*
         $hui2 = "http://".$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF']; ?>


        <link rel="canonical" href="<? echo $hui2 ?>" />
        <?php */?>


        <?php
        if ( (USE_CACHE == 'true') && !SID) {
            echo tep_cache_related_products(3600);
        } else {
            include(DIR_WS_MODULES . FILENAME_CONTENT_RELATED_PRODUCTS);

        }
        //include(DIR_WS_MODULES . FILENAME_PRODUCT_REVIEWS_INFO);
        ?>
    </td>
</tr>
<?php
if (strlen($product_info['products_bottom_content'])>0){?>
    <tr><td class="seo-desc"><span class="other-desc">Дополнительное описание</span><div><?php echo $product_info['products_bottom_content'];?></div></td></tr>
<?php } ?>
<script>
    jQuery(document).on('click','.other-desc',function(){
        $(this).next().slideToggle();
    })
</script>
<?php
/*by iHolder top name with content*/
if (strlen($product_info['products_bottom_name'])>0){?>
    <tr><td colspan="2">
            <a href="javascript:void();" onclick="document.getElementById('maintext_bottom').style.display = document.getElementById('maintext_bottom').style.display == 'block' ? 'none':'block'; return false;" style="font-size: 10px;">
                <h2><?php echo $product_info['products_bottom_name']?></h2>
            </a>
            <div id="maintext_bottom" class="maintext" style="display: none;"><?php echo $product_info['products_bottom_content'];?></div>
        </td></tr>
<?php }?>
</table>
</form>
<?php if (IS_MOBILE==1){ ?>
    <script src="/ext/script/internal.js?v=1"></script>
<?php } ?>