<?php
  function tep_get_version() {
/*    static $v;
    if (!isset($v)) {
      $v = trim(implode('', file(DIR_FS_CATALOG . 'includes/version.php')));
    }
    return $v;*/
    return '2.3.4';
  }
  function tep_validate_ip_address($ip_address) {
    if (function_exists('filter_var') && defined('FILTER_VALIDATE_IP')) {
      return filter_var($ip_address, FILTER_VALIDATE_IP, array('flags' => FILTER_FLAG_IPV4));
    }

    if (preg_match('/^(\d{1,3})\.(\d{1,3})\.(\d{1,3})\.(\d{1,3})$/', $ip_address)) {
      $parts = explode('.', $ip_address);

      foreach ($parts as $ip_parts) {
        if ( (intval($ip_parts) > 255) || (intval($ip_parts) < 0) ) {
          return false; // number is not within 0-255
        }
      }

      return true;
    }

    return false;
  }



function tep_reset_cache_data_seo_urls($action){
  switch ($action){
    case 'reset':
    case 'uninstall':
       tep_db_query("DELETE FROM cache WHERE cache_name LIKE '%seo_urls%'");
       tep_db_query("UPDATE configuration SET configuration_value='false' WHERE configuration_key='SEO_URLS_CACHE_RESET'");

       if ($action == 'reset') break;

       tep_db_query("DELETE FROM configuration_group WHERE configuration_group_title LIKE '%seo_urls%'");
	     tep_db_query("DELETE FROM configuration WHERE configuration_key LIKE 'SEO%' OR configuration_key LIKE 'USE_SEO%'");
    break;
    default:
    break;
  }
  # The return value is used to set the value upon viewing
  # It's NOT returining a false to indicate failure!!
  return 'false';
}

// Output a jQuery UI Button
  function tep_draw_button($title = null, $icon = null, $link = null, $priority = null, $params = null) {
    static $button_counter = 1;

    $types = array('submit', 'button', 'reset');

    if ( !isset($params['type']) ) {
      $params['type'] = 'submit';
    }

    if ( !in_array($params['type'], $types) ) {
      $params['type'] = 'submit';
    }

    if ( ($params['type'] == 'submit') && isset($link) ) {
      $params['type'] = 'button';
    }

    if (!isset($priority)) {
      $priority = 'secondary';
    }

    $button = '<span class="tdbLink">';

    if ( ($params['type'] == 'button') && isset($link) ) {
      $button .= '<a id="tdb' . $button_counter . '" href="' . $link . '"';

      if ( isset($params['newwindow']) ) {
        $button .= ' target="_blank"';
      }
    } else {
      $button .= '<button id="tdb' . $button_counter . '" type="' . tep_output_string($params['type']) . '"';
    }

    if ( isset($params['params']) ) {
      $button .= ' ' . $params['params'];
    }

    $button .= '>' . $title;

    if ( ($params['type'] == 'button') && isset($link) ) {
      $button .= '</a>';
    } else {
      $button .= '</button>';
    }

/*
    $button .= '</span><script type="text/javascript">$("#tdb' . $button_counter . '").button(';

    $args = array();

    if ( isset($icon) ) {
      if ( !isset($params['iconpos']) ) {
        $params['iconpos'] = 'left';
      }

      if ( $params['iconpos'] == 'left' ) {
        $args[] = 'icons:{primary:"ui-icon-' . $icon . '"}';
      } else {
        $args[] = 'icons:{secondary:"ui-icon-' . $icon . '"}';
      }
    }

    if (empty($title)) {
      $args[] = 'text:false';
    }

    if (!empty($args)) {
      $button .= '{' . implode(',', $args) . '}';
    }

    $button .= ').addClass("ui-priority-' . $priority . '").parent().removeClass("tdbLink");</script>';
*/
    $button_counter++;
    $button.='</span>';
    return $button;
  }

////
// This function returns the type of the encrpyted password
// (phpass or salt)
  function tep_password_type($encrypted) {
      if (preg_match('/^[A-Z0-9]{32}\:[A-Z0-9]{2}$/i', $encrypted) === 1) {
        return 'salt';
        }
    return 'phpass';
 }


function GetAMPCategoryMenu($in_header = true)
{
    global $c2c_array, $deduction_map, $languages_id, $_GET;

    if (!isset($c2c_array)) {
        $c2c_array = GetCategoriesProductsCount();
    }
    if (!isset($deduction_map)) {
        $deduction_map = GetDeductionMap();
    }

    $status = tep_db_num_rows(tep_db_query('describe ' . TABLE_CATEGORIES . ' status'));
    $query = "select c.categories_id, cd.categories_name, c.parent_id, c.categories_image
            from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd
            where c.categories_id = cd.categories_id and c.categories_status = '1'";
    $query .= " and cd.language_id='" . $languages_id . "'
            order by sort_order, cd.categories_name";
    $categories_query = tep_db_query($query);
    $data = '<div class="glossymenu">';
    /*in the top of menu display rasprodazha*/
    if (isset($_GET['sort']) ? $this_sort = $_GET['sort'] : $this_sort = 'products_sort_order') ;
    $data .= '<amp-accordion><section><h4 class="menuitem submenuheader">Распродажа склада</h4>';
    $data .= '<div class="submenu">';
    $data .= '<ul><li>';
    $dquery = "select cd.categories_id as id,cd.categories_name as name from " .
        TABLE_CATEGORIES_DESCRIPTION . " cd where cd.language_id = '" . $languages_id . "'";
    $display_cat = $deduction_map['categories'];
    if (sizeof($display_cat) > 0) {
        $dquery .= " and cd.categories_id in(" . implode(',', array_keys($display_cat)) . ") ";
    }
    $dquery .= " order by categories_name";
    $dcq = tep_db_query($dquery);
    if ($dcq !== false) {
        while ($dcres = tep_db_fetch_array($dcq)) {
            $data .= '<a href="/' . FILENAME_DISCOUNT . '?vPath=' . $dcres['id'] . '">' . $dcres['name'] . '</a>';
        }
    }
    unset($dcq, $dcres);
    $data .= '</li></ul>';
    $data .= '</div></section></amp-accordion>';
    /*in the top of menu display rasprodazha*/
    $cPath_array = '';
    while ($categories = tep_db_fetch_array($categories_query)) {
        if ($categories['parent_id'] == 0) {
            $temp_cPath_array = $cPath_array;  //Johan's solution - kill the array but save it for the rest of the site
            unset($cPath_array);
            $cPath_new = tep_get_path($categories['categories_id']);
            $text_subcategories = '';
            $subcategories_query = tep_db_query($query);
            while ($subcategories = tep_db_fetch_array($subcategories_query)) {
                if ($subcategories['parent_id'] == $categories['categories_id']) {
                    $cPath_new_sub = "cPath=" . $categories['categories_id'] . "_" . $subcategories['categories_id'];
//---modified by iHolder
                    if ($c2c_array[$subcategories['categories_id']] > 0) {
                        $text_subcategories .= '<a href="' . tep_href_link(FILENAME_DEFAULT, $cPath_new_sub, 'NONSSL') . '">' . $subcategories['categories_name'] . '</a>' . " ";
                    }
//---modified by iHolder
//           $text_subcategories .= '<a href="' . tep_href_link(FILENAME_DEFAULT, $cPath_new_sub, 'NONSSL') . '">' . $subcategories['categories_name'] . '</a>' . " ";
                } // if
            } // While Interno


            if (tep_has_category_subcategories($category_id)) {
                $child_category_query = tep_db_query("select count(*) as count from " . TABLE_CATEGORIES . " where parent_id = '" . $categories['categories_id'] . "'");
                $child_category = tep_db_fetch_array($child_category_query);

                if ($child_category['count'] > 0) {
                    $data .= '<amp-accordion><section><h4 class="menuitem submenuheader">' . $categories['categories_name'] . '</h4>';
                    $data .= '<div class="submenu">';
                    $data .= '<ul><li>' . $text_subcategories . '</li></ul>';
                    $data .= '</div></section></amp-accordion>';
                } else {
                    $data .= '<a class="menuitem" href="' . tep_href_link(FILENAME_DEFAULT, $cPath_new, 'NONSSL') . '">' . $categories['categories_name'] . '</a>';
                }
            }
            $cPath_array = $temp_cPath_array; //Re-enable the array for the rest of the code
        }
    }
    if (!$in_header) {
        $data .= '</div>';
        $data .= '</div>';
    }
    $data .= '</div>';
    return $data;
}
function GetCategoryMenu($in_header=true){
global $c2c_array,$deduction_map,$languages_id,$_GET;
if (!in_header){
$DATA='<div class="ui-widget infoBoxContainer mj-categoriessidebox">' .
              '  <div class="ui-widget-header infoBoxHeading">' . MODULE_BOXES_CATEGORIES_BOX_TITLE . '</div>';
} else{$DATA='';}
$DATA.='<script type="text/javascript">
ddaccordion.init({
        headerclass: "submenuheader",
        contentclass: "submenu",
        revealtype: "click",
        mouseoverdelay: 500,
        collapseprev: true,
        defaultexpanded: [],
        onemustopen: false,
        animatedefault: false,
        persiststate: true,
        toggleclass: ["", ""],
        togglehtml: ["suffix", "<img src=\'/images/plus.gif\' class=\'statusicon\' />", ""],
        animatespeed: "fast",
        collapseheader:false,
        oninit:function(headers, expandedindices){},
        onopenclose:function(header, index, state, isuseractivated){}
});
</script>
';

  if (!isset($c2c_array)){$c2c_array=GetCategoriesProductsCount();}
  if (!isset($deduction_map)){$deduction_map=GetDeductionMap();}

 $status = tep_db_num_rows(tep_db_query('describe ' .  TABLE_CATEGORIES . ' status')); 
                    // Categories  Accordion Menu
                    // coded by flist 2009
                    // @florist duzgun.com forum

                    //  categories list

                    //$status = tep_db_num_rows(tep_db_query('describe ' .  TABLE_CATEGORIES . ' status'));


                    $query = "select c.categories_id, cd.categories_name, c.parent_id, c.categories_image
            from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd
            where c.categories_id = cd.categories_id and c.categories_status = '1' and c.parent_id < 1";


                    $query .= " and cd.language_id='" . $languages_id . "'
            order by sort_order, cd.categories_name";

                    $categories_query = tep_db_query($query);
                    // Display box contents
                    if (($refresh == true) || !read_cache($cache_output, 'category-menu-' . $language . '.cache', 300)) {
                        ob_start();
                        global $menu;
                        $menu = array();
                        echo '<div class="glossymenu">';
                        /*in the top of menu display rasprodazha*/
                        function displayCatsMenu($categories_query,$cPath_array,$query,$category_id,$languages_id,$notParent = false,$c2c_array)
                        {
                            global $menu;
                            $categoryList = array();
                            while ($categoryItems = tep_db_fetch_array($categories_query)) {
                                $categories[] = $categoryItems;
                            }
                            usort($categories, function ($a, $b) {
                                if ($a['categories_name'] == $b['categories_name']) {
                                    return 0;
                                }
                                return ($a['categories_name'] < $b['categories_name']) ? -1 : 1;
                            });
                            foreach ($categories as $categories) {
                                $echo = '';
                                if($categories['categories_id'] == '68'){
                                    //Удочки классиические
                                    $query1 = "select c.categories_id, 'УДОЧКИ КЛАССИЧЕСКИЕ' AS categories_name, c.parent_id, c.categories_image
            from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd
            where c.categories_id = cd.categories_id and c.categories_status = '1' 
            AND c.categories_id = 202 and cd.language_id='" . $languages_id . "'
            order by sort_order, cd.categories_name ";
                                    $categories_query2 = tep_db_query($query1);
                                    $query2  = "select c.categories_id, cd.categories_name, c.parent_id, c.categories_image
            from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd
            where c.categories_id = cd.categories_id and c.categories_status = '1' 
            AND c.parent_id = 202 and cd.language_id='" . $languages_id . "'
            order by sort_order, cd.categories_name ";
                                    displayCatsMenu($categories_query2,$cPath_array,$query2,$category_id,$languages_id,true,$c2c_array);
                                }
                                if ($categories['parent_id'] == 0 || $notParent) {
                                    $temp_cPath_array = $cPath_array;  //Johan's solution - kill the array but save it for the rest of the site
                                    unset($cPath_array);
                                    $cPath_new = tep_get_path($categories['categories_id']);
                                    $text_subcategories = '';
                                    $query = "select c.categories_id, cd.categories_name, c.parent_id, c.categories_image
            from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd
            where c.categories_id = cd.categories_id and c.categories_status = '1' and c.parent_id =".$categories['categories_id'];
                                    $subcategories_query = tep_db_query($query);
                                    while ($subcategories = tep_db_fetch_array($subcategories_query)) {
                                        if ($subcategories['parent_id'] == $categories['categories_id']) {
                                            $cPath_new_sub = "cPath=" . $categories['categories_id'] . "_" . $subcategories['categories_id'];
//---modified by iHolder
                                            if ($c2c_array[$subcategories['categories_id']]>0){
                                                $text_subcategories .= '<a href="' . tep_href_link(FILENAME_DEFAULT, $cPath_new_sub, 'NONSSL') . '">' . $subcategories['categories_name'] . '</a>' . " ";
                                            }
//---modified by iHolder
//           $text_subcategories .= '<a href="' . tep_href_link(FILENAME_DEFAULT, $cPath_new_sub, 'NONSSL') . '">' . $subcategories['categories_name'] . '</a>' . " ";

                                        } // if
                                    } // While Interno

                                    if (tep_has_category_subcategories($category_id)) {
                                        $child_category_query = tep_db_query("select count(*) as count from " . TABLE_CATEGORIES . " where parent_id = '" . $categories['categories_id'] . "'");
                                        $child_category = tep_db_fetch_array($child_category_query);

                                        if ($child_category['count'] > 0) {
                                            $echo .= '<a class="menuitem submenuheader" href="' . tep_href_link(FILENAME_DEFAULT, $cPath_new, 'NONSSL') . '">' . $categories['categories_name'] . '</a>';
                                            $echo .= '<div class="submenu">';
                                            $echo .= '<ul><li>' . $text_subcategories . '</li></ul>';
                                            $echo .= '</div>';
                                        } else {
                                            $echo .= '<a class="menuitem" href="' . tep_href_link(FILENAME_DEFAULT, $cPath_new, 'NONSSL') . '">' . $categories['categories_name'] . '</a>';
                                        }
                                    }
                                    $cPath_array = $temp_cPath_array; //Re-enable the array for the rest of the code
                                }
                                $menu[$categories['categories_id']]= $echo;
                            }
                        }

                        displayCatsMenu($categories_query,$cPath_array,$query,$category_id,$languages_id,false,$c2c_array);
                        echo $menu[89]; //Зимняя рыбалка
                        unset($menu[89]);
                        /*in the top of menu display rasprodazha*/
                        if (isset($_GET['sort']) ? $this_sort = $_GET['sort'] : $this_sort = 'products_sort_order') ;
                        echo '<a class="menuitem submenuheader" href="/' . FILENAME_DISCOUNT . '">Распродажа склада</a>';
                        echo '<div class="submenu">';
                        echo '<ul><li>';
                        $dquery = "select cd.categories_id as id,cd.categories_name as name from " .
                            TABLE_CATEGORIES_DESCRIPTION . " cd where cd.language_id = '" . $languages_id . "'";
                        $display_cat = $deduction_map['categories'];
                        if (sizeof($display_cat) > 0) {
                            $dquery .= " and cd.categories_id in(" . implode(',', array_keys($display_cat)) . ") ";
                        }
                        $dquery .= " order by categories_name";
                        $dcq = tep_db_query($dquery);
                        if ($dcq !== false) {
                            while ($dcres = tep_db_fetch_array($dcq)) {
                                echo '<a href="/' . FILENAME_DISCOUNT . '?vPath=' . $dcres['id'] . '">' . $dcres['name'] . '</a>';
                            }
                        }
                        unset($dcq, $dcres);
                        echo '</li></ul>';
                        echo '</div>';
                        echo implode('',$menu);
                        echo '</div>';
                        $cache_output = ob_get_contents();
                        ob_end_clean();
                        write_cache($cache_output, 'category-menu-' . $language . '.cache');
                    }
return $DATA.$cache_output;
}
function CompressContent($m){
return preg_replace('|[\r\n\t]|','',$m);
}

function TransformDescription($s){
$ret=$s;
$s=preg_replace('|[\r\n]|','',$s);
$s=preg_replace('|class="social"|','',$s);
if (preg_match('|<table[^>]*>(.+)</table>|m',$s,$arr)){
	$s_line=$arr[0];
	$line=preg_replace('|<th>|','<td>',$arr[1]);
	$line=preg_replace('|</th>|','</td>',$line);
	$line=preg_match_all('|<tr[^>]*>(.+)</tr>|U',$line,$tr);
	$tbl=array();
	if (sizeof($tr[1])>0){
	    for ($i=0;$i<sizeof($tr[1]);$i++){
		preg_match_all('|<td[^>]*>(.+)</td>|U',$tr[1][$i],$td);
		$tbl[$i]=$td[1];
		}
	    }
    if (sizeof($tbl)>0){
    $chg='<table align="center" border="1">';
    for ($i=0;$i<sizeof($tbl[0]);$i++){
	$chg.='<tr>';
	    for ($j=0;$j<sizeof($tbl);$j++){
		$chg.='<td>'.$tbl[$j][$i].'</td>';
		}
	$chg.='</tr>';
	}
	$chg.='</table>';
	$ret=str_replace($s_line,$chg,$s);
	}

    }
return $ret;
}

?>