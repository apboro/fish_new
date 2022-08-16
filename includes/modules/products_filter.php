<?php
/*
  $Id: products_filter.php, v1.0.1 20090917 kymation Exp $
  $Loc: catalog/includes/modules/ $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2009 osCommerce

  Released under the GNU General Public License
*/

require_once(DIR_WS_FUNCTIONS . 'products_specifications.php');

require_once(DIR_WS_CLASSES . 'specifications.php');
if(empty($current_category_id)){
    return false;
}
$spec_object = new Specifications();
if (SPECIFICATIONS_FILTERS_MODULE == 'True') {
    // Generate the heading for the box
    $info_box_heading = array();
    $info_box_heading[] = array('text' => BOX_HEADING_PRODUCTS_FILTER);

    $specs_query_raw = "select s.specifications_id,
                               s.products_column_name,
                               s.filter_class,
                               s.filter_show_all,
                               s.filter_display,
                               sd.specification_name,
                               sd.specification_prefix,
                               sd.specification_suffix
                        from " . TABLE_SPECIFICATION . " s,
                             " . TABLE_SPECIFICATION_DESCRIPTION . " sd,
                             " . TABLE_SPECIFICATION_GROUPS . " sg,
                             " . TABLE_SPECIFICATIONS_TO_CATEGORIES . " s2c
                        where s.specification_group_id = sg.specification_group_id
                          and sg.specification_group_id = s2c.specification_group_id
                          and sd.specifications_id = s.specifications_id
                          and s2c.categories_id = '" . $current_category_id . "'
                          and s.show_filter = 'True'
                          and sg.show_filter = 'True'
                          and sd.language_id = '" . $languages_id . "'
                        order by s.specification_sort_order,
                                 sd.specification_name
                      ";
//    echo $specs_query_raw . "<br>\n";

    $specs_query = tep_db_query($specs_query_raw);
    $info_box_contents = array();
    $exclude_array = array();
    $filter_manufacture_id = -1;
    while ($specs_array = tep_db_fetch_array($specs_query)) {
        // Retrieve the GET vars, sanitize, and assign to variables
        // Variable names are the letter "f" followed by the specifications_id for that spec.
        if (preg_match('|роизводител|i', $specs_array['specification_name'])) {
            $filter_manufacture_id = $specs_array['specifications_id'];
        }
        // Retrieve the GET vars, sanitize, and assign to variables
        // Variable names are the letter "f" followed by the specifications_id for that spec.
        $var = 'f' . $specs_array['specifications_id'];
        $exclude_array[] = $var;
        $$var = '0';
        if (isset ($_GET[$var]) && $_GET[$var] != '') {
            // Sanitize variables to prevent hacking
            if (is_string($_GET[$var])) {
                $$var = $_GET[$var];
            } else {
                $$var = tep_clean_get__recursive($_GET[$var]);
            }
            // Get rid of extra values if Select All is selected
            $$var = tep_select_all_override($$var);
        }

        $box_text = ''; // Build an HTML string to go into the text part of the box
        $price_minimal = $price_maximum = 0;
        $filters_query_raw = "select sf.specification_filters_id,
                                   sfd.filter
                            from " . TABLE_SPECIFICATIONS_FILTERS . " sf,
                                 " . TABLE_SPECIFICATIONS_FILTERS_DESCRIPTION . " sfd
                            where sfd.specification_filters_id = sf.specification_filters_id
                              and sf.specifications_id = '" . (int)$specs_array['specifications_id'] . "'
                              and sfd.language_id = '" . $languages_id . "'
                            order by sf.filter_sort_order,
                                     sfd.filter
                           ";

        // print $filters_query_raw . "<br>\n";

        $filters_query = tep_db_query($filters_query_raw);
        $count_filters = tep_db_num_rows($filters_query);
        $filters_select_array = array();

        if ($count_filters >= SPECIFICATIONS_FILTER_MINIMUM || $specs_array['products_column_name'] == 'products_price') {
            $filters_array = array();

            if(!isset( $GLOBALS['HTTP_GET_VARS']['manufacturers_id'])) {
                $box_text .= '<b>' . $specs_array['specification_name'] . '</b><br>';
            }
            $filter_index = 0;
            if ($specs_array['filter_show_all'] == 'True') {
                $count = 1;
                if (SPECIFICATION_FILTER_NO_RESULT != 'normal' || SPECIFICATIONS_FILTER_SHOW_COUNT == 'True') {
                    // Filter ID is set to 0 so no filter will be applied
//            $count = $spec_object->getFilterCount ('0', $specs_array['specifications_id'], $specs_array['filter_class'], $specs_array['products_column_name']);
                }
                // The ID value must be set as a string, not an integer
                $filters_select_array[$filter_index] = array('id' => '0',
                    'text' => TEXT_SHOW_ALL,
                    'count' => $count
                );
                $filter_index++;
            }
            /*
             * Вычесляем количество товаров с данным значением спецификации
             *
             * */
            $filters_count= array();
            if($specs_array['filter_class'] == 'exact'){
                $man_ids = array();
                $in_categories = $spec_object->getFilterInCategoriesQuery();
                $products_column_name = '';
                if($specs_array['products_column_name'] == 'manufacturers_id'){
                    $products_column_name = $specs_array['products_column_name'];
                }

                $filter_array_items = array();
                $filter_names = array();
                while ($filter_item = tep_db_fetch_array($filters_query)) {
                    $filter_text = $specs_array['specification_prefix'] . ' ' . $filter_item['filter'] . ' ' . $specs_array['specification_suffix'];
                    $filter_names[] = "\"".$filter_item['filter']."\"";
                    $filter_array_items[$filter_item['filter']] = array(
                        'filter_id' => $filter_item['filter'],
                        'filter_text' => $filter_text
                    );
                }
                $sql_array = array();
                if (strlen($products_column_name) > 1) { // Use an existing column
                    $man_ids = tep_quick_get_manufacturer_id(array_keys($filter_array_items), $products_column_name,$languages_id,true);
                    $sql_array['where'] .= " AND " . $products_column_name . " IN (" . implode(',', $man_ids) . ") ";

                } else {
                    $sql_array['from'] .= " INNER JOIN " . TABLE_PRODUCTS_SPECIFICATIONS . " ps" . $specs_array['specifications_id'] .
                        " ON p.products_id = ps" . $specs_array['specifications_id'] . ".products_id ";
                    $sql_array['where'] .= " AND ps" . $specs_array['specifications_id'] . ".specification IN (" . implode(',', $filter_names) . ")
                              AND ps" . $specs_array['specifications_id'] . ".specifications_id = '" . $specs_array['specifications_id'] . "'
                              AND ps" . $specs_array['specifications_id'] . ".language_id = '" . (int)$languages_id . "'
                              ";
                    $products_column_name = "ps" . $specs_array['specifications_id'].'.specification'  ;
                }
                $query_string = "select STRAIGHT_JOIN " . $products_column_name . "  as filter_value,COUNT(*) as count
    FROM (" . TABLE_PRODUCTS . " p)
    INNER JOIN (" . TABLE_PRODUCTS_TO_CATEGORIES . " p2c) ON 
    p.products_quantity>0
    and (p.products_id = p2c.products_id) " . $in_categories . " 
     and p.products_status = '1'
    INNER JOIN " . TABLE_CATEGORIES . " cat ON (cat.categories_id = p2c.categories_id) and cat.categories_status = '1'
    inner join  products_description pd on (p.products_id=pd.products_id) ".$sql_array['from'] . $sql_array['where'] . " 
    GROUP BY " . $products_column_name;
                $filters_items_query = tep_db_query($query_string);
                if(!empty($man_ids)){
                    $man_ids = array_flip($man_ids);
                }
                while ($item = tep_db_fetch_array($filters_items_query)) {
                    $id = $item['filter_value'];
                    $filters_count[$id] = $item['count'];
                    if (!empty($man_ids)) {
                        $id = $man_ids[$id];
                    }
                    $filters_select_array[$filter_index] = array('id' => urlencode($filter_array_items[$id]['filter_id']),
                        'text' => $filter_array_items[$id]['filter_text'],
                        'count' => $item['count']
                    );
                    $filter_index++;
                }
            }else {
                $previous_filter = 0;
                $previous_filter_id = 0;
                $filter_items = array();
                while ($filters_array = tep_db_fetch_array($filters_query)) {
                    $filter_items[] = $filters_array;
                }
                $counts = array();
                if ($specs_array['filter_class'] == 'range' && $specs_array['products_column_name'] !== 'products_price') {
                    $filter_ids = array();
                    foreach ($filter_items as $filters_array) {
                        $filter_id = $filters_array['filter'];
                        // Format currency if the column is a price
                        $filter_text = $specs_array['specification_prefix'] . ' ' . $filters_array['filter'] . ' ' . $specs_array['specification_suffix'];


                        $filter_text = $previous_filter . ' - ' . $filter_text;
                        $filter_id = $previous_filter_id . '-' . $filters_array['filter'];

                        $previous_filter = $filters_array['filter'];
                        $previous_filter_id = $filters_array['filter'];
                        $filter_ids[] = $filter_id;
                        $count = 1;
                    }
                    $filter_ids[] = $previous_filter_id;
                    $counts = $spec_object->getGroupFilterCount($filter_ids, $specs_array['specifications_id'], $specs_array['filter_class'], $specs_array['products_column_name']);
                }

                $previous_filter = 0;
                $previous_filter_id = 0;
                foreach ($filter_items as $filters_array) {
                    $filter_id = $filters_array['filter'];
                    // Format currency if the column is a price
                    if ($specs_array['products_column_name'] == 'products_price' || $specs_array['products_column_name'] == 'final_price') {
                        $previous_filter = $currencies->format($previous_filter);
                        $filter_text = $currencies->format($filters_array['filter']);
                        if ($filters_array['filter'] < $price_minimal) {
                            $price_minimal = $filters_array['filter'];
                        }
                        if ($filters_array['filter'] > $price_maximum) {
                            $price_maximum = $filters_array['filter'];
                        }
                    } else {
                        $filter_text = $specs_array['specification_prefix'] . ' ' . $filters_array['filter'] . ' ' . $specs_array['specification_suffix'];
                    }

                    // Set up the range if class is range
                    if ($specs_array['filter_class'] == 'range') {
                        $filter_text = $previous_filter . ' - ' . $filter_text;
                        $filter_id = $previous_filter_id . '-' . $filters_array['filter'];

                        $previous_filter = $filters_array['filter'];
                        $previous_filter_id = $filters_array['filter'];
                    }
                    $count = 1;

                    if(isset($counts[$filter_id])){
                        $count = $counts[$filter_id];
                    }elseif(!empty($counts)) {
                        $count = 0;
                    }else{
                        if (SPECIFICATION_FILTER_NO_RESULT != 'normal' || SPECIFICATIONS_FILTER_SHOW_COUNT == 'True') {
                            $count = $spec_object->getFilterCount($filter_id, $specs_array['specifications_id'], $specs_array['filter_class'], $specs_array['products_column_name']);
                        }
                    }
                    if (!empty($filters_count)) {
                        $count = $filters_count[$filters_array['specification_filters_id']];
                    }
                    $filters_select_array[$filter_index] = array('id' => urlencode($filter_id),
                        'text' => $filter_text,
                        'count' => $count
                    );
                    $filter_index++;
                }
            }
            // For the Range class only, add an extra filter at the end for maximum value +
            if ($specs_array['filter_class'] == 'range') {
                if ($specs_array['products_column_name'] == 'products_price' || $specs_array['products_column_name'] == 'final_price') {
                    $previous_filter = $currencies->format($previous_filter);
                }

                $count = 1;
                if (SPECIFICATION_FILTER_NO_RESULT != 'normal' || SPECIFICATIONS_FILTER_SHOW_COUNT == 'True') {
                    $count = $spec_object->getFilterCount($previous_filter_id, $specs_array['specifications_id'], $specs_array['filter_class'], $specs_array['products_column_name']);
                }

//          $filters_select_array[$filter_index] = array ('id' => rawurlencode ($previous_filter_id),
                $filters_select_array[$filter_index] = array('id' => ($previous_filter_id),
                    'text' => $previous_filter . '+',
                    'count' => $count
                );
            } // if ($specs_array['filter_class'] == 'range'
//----by iHolder slider---
            if ($specs_array['products_column_name'] == 'products_price' || $specs_array['products_column_name'] == 'final_price') {

                $min_max_data = GetMinMaxFromCat($current_category_id);
                if (is_array($min_max_data)) {
                    $srmi = ceil($min_max_data['min']);

                    $price_minimal = $srmi;
                    $srma = ceil($min_max_data['max']);
                    $price_maximum = $srma;
                } else {
                    $srmi = $price_minimal;
                    $srma = $price_maximum;
                }

                if($srmi == $srma){
                    continue;
                }
                if ((strlen($_REQUEST['srmi']) > 0) && (isset($_REQUEST[$var]))) {
                    $srmi = (int)$_REQUEST['srmi'];
                }
                if ((strlen($_REQUEST['srma']) > 0) && (isset($_REQUEST[$var]))) {
                    $srma = (int)$_REQUEST['srma'];
                }
                $box_text .= '<div class="srv"><span id="amount">';
                $box_text .= '<input  type="text" id="slider-range-min" name="srmi" value="';
                $box_text .= $srmi;
                $box_text .= '" size="' . (strlen($srma)) . '"> руб.- <input  type="text"  id="slider-range-max" name="srma" value="';
                $box_text .= $srma;
                $box_text .= '" size="' . (strlen($srma)) . '"> руб.';

                $box_text .= '</span>
	<div id="slider-range">
	<input id="slider-range-value" type="hidden" name="' . $var . '[]" value="0">
	</div></div>';

                $box_text .= '<link rel="stylesheet" type="text/css" href="jscript/jquery/plugins/ui1/jquery-ui.min.css">
	<script type="text/javascript" src="jscript/jquery/plugins/ui1/jquery-ui.min.js"></script>
	<script type="text/javascript">
	   $(function() {
	    function SetPriceValue(){
		$("#slider-range-value").val(parseInt($("#slider-range-min").val())+"-"+
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
		 min: ' . $price_minimal . ',
	         max: ' . $price_maximum . ',
	         values: [ ' . $srmi . ',' . $srma . '],
	         slide: function( event, ui ) {
	            $("#slider-range-min").val(ui.values[ 0 ]+"-"+ui.values[ 1 ]);    
	            $("#slider-range-min").val(ui.values[ 0 ]);
		    $("#slider-range-max").val(ui.values[ 1 ]);	            
		    $("#slider-range-value").val(ui.values[ 0 ]+"-"+ui.values[ 1 ]);
	          }
	          });
		  $("#slider-range-value").val(  ' . $srmi . ' + "-" + ' . $srma . ');
	          });
	    </script>';
//----by iHolder slider---
            } else {

                if(!isset( $GLOBALS['HTTP_GET_VARS']['manufacturers_id'])) {
                    if ($specs_array['specifications_id'] == $filter_manufacture_id) {
                        if (isset($fsa)) {
                            unset($fsa);
                        }
                        $fsa = array();
                        foreach ($filters_select_array as $fsa_k => $fsa_v) {
                            if ($fsa_v['count'] > 0) {
                                $fsa[] = $fsa_v;
                            }
                        }
                        unset($filters_select_array);
                        $filters_select_array = $fsa;
                        if (sizeof($fsa) == 2) {
                            //	    var_dump($specs_array);
                            //    	    var_dump($filters_select_array);
                            $$var = $fsa[1]['id'];
                        }
                        if (count($filters_select_array) < 3) {
                            $filters_select_array = array();
                        }
//	    echo $var.'==='. $$var;
                    }
                    $box_text .= tep_get_filter_string($specs_array['filter_display'], $filters_select_array, FILENAME_PRODUCTS_FILTERS, $var, $$var);
                }
            }
        } // if ($count_filters
        $show_spec = 0;
        foreach($filters_select_array as $item){
            if($item['count'] > 0){
                $show_spec++;
            }
        }
        if ($show_spec > 1) {
            $info_box_contents[0][] = array('text' => $box_text);
        }
    } // while ($specs_arrayx
    if(isset( $GLOBALS['HTTP_GET_VARS']['manufacturers_id'])){
        $specs_query = tep_db_query( "select c.categories_name,c.categories_id
                        from " . TABLE_PRODUCTS . " p 
                        INNER JOIN ".TABLE_PRODUCTS_TO_CATEGORIES." as pc on
                         p.products_status = '1' 
                         AND p.manufacturers_id = ".$GLOBALS['HTTP_GET_VARS']['manufacturers_id']."
                         AND pc.products_id = p.products_id
                         AND p.products_quantity > 0
                         INNER JOIN ".TABLE_CATEGORIES_DESCRIPTION." as c on c.categories_id =  pc.categories_id                   
                        where 1 GROUP BY c.categories_id
                      ");
        while ($specs_array = tep_db_fetch_array($specs_query)) {
            $categories = array();
            tep_get_parent_categories($categories,$specs_array['categories_id']);
            $categories = array_reverse($categories);
            $categories[] = $specs_array['categories_id'];
            $filters_select_array1[] = array('id' => implode('_', $categories),
                'text' => $specs_array['categories_name'] ,
                'count' => 1
            );
        }
        $box_text1 .= '<b>Категория</b><br>';
        $box_text1 .= tep_get_filter_string('pulldown', $filters_select_array1, 'Категория', 'cPath', 'Категория');

        $info_box_contents[0][] = array('text' => $box_text1    );
    }
    if (tep_db_num_rows($specs_query) > 0 && !empty($info_box_contents)) {
        ?>
        <!-- category_filter //-->
        <tr>
            <td>
                <?php
                // Output the box in the selected style
                switch (SPECIFICATIONS_FILTERS_FRAME_STYLE) {
                    case 'Plain':
                        new borderlessBox ($info_box_contents);
                        break;

                    case 'Simple':
                        new productListingBox ($info_box_contents);
                        break;
                    case 'Stock':

                    default:
                        if (SINGLE_KNOB) {
                            echo tep_draw_form('filter', FILENAME_PRODUCTS_FILTERS, 'get');
                        }
                        new infoBoxHeading($info_box_heading, false, false);
                        new contentBox ($info_box_contents);

                        if (SINGLE_KNOB) {
                            $info_box_contents = array();
                            /*    $info_box_contents[] = array('align' => 'center',
                                                            'text'  => tep_image_submit('icon_next.gif', TEXT_FIND_PRODUCTS)
                                                          );*/
//    echo '<pre>';var_dump($exclude_array);echo '</pre>';
//    if (strlen($_GET['sort'])==0){$_GET['sort']='3a';}
                            if (isset($_GET['cPath'])) {
                                $cpath_array = tep_parse_category_path($_GET['cPath']);
//	if (sizeof($cpath_array)>0){echo tep_draw_hidden_field('cPath',$cpath_array[0]);}
                                if (sizeof($cpath_array) > 0) {
                                    echo tep_draw_hidden_field('cPath', $cpath_array[sizeof($cpath_array)]);
                                }
                            }
//    tep_draw_hidden_field('cPath',$_GET['cPath']);
                            foreach (array('page', 'sort') as $hkey) //    foreach(array('page','sort','cPath') as $hkey)
                            {
                                echo tep_draw_hidden_field($hkey, $_GET[$hkey]);
                            }
                            if (basename(__FILE__) == FILENAME_PRODUCTS_FILTERS) {
                                $info_box_contents[] = array(
                                    'align' => 'center',
                                    'text' => '<table width="100%" border="0"><tr><td style="text-align:center">' . tep_image_submit('icon_next.gif', TEXT_FIND_PRODUCTS) .
                                        '
    <a title="Сбросить" href="' . tep_href_link(FILENAME_PRODUCTS_FILTERS, tep_get_all_get_params($exclude_array)) . '">' .
                                        '<img  alt="Сбросить" src="' . DIR_WS_TEMPLATES . TEMPLATE_NAME . '/images/buttons/russian/button_reset.gif">
    </td></tr></table>');

                                /*
                                    $info_box_contents[]=array(
                                                'align'=>'center',
                                                'text'=>'<a title="Сбросить" href="'.tep_href_link(FILENAME_PRODUCTS_FILTERS,tep_get_all_get_params($exclude_array)).'">'.
                                                '<img  alt="Сбросить" src="'.DIR_WS_TEMPLATES.TEMPLATE_NAME.'/images/buttons/russian/button_reset.gif">'.
                                                '</a>'
                                                );*/
                            }
                            new contentBox ($info_box_contents);
                            echo '</form>';
                        }

                        $info_box_contents = array();
                        $info_box_contents[] = array('align' => 'left',
                            'text' => tep_draw_separator('pixel_trans.gif', '100%', '1')
                        );
                        new infoBoxFooter($info_box_contents, true, true);

                        break;
                }
                ?>
            </td>
        </tr>
        <!-- category_filter_eof //-->
        <?php
    }
}
?>