<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2013 osCommerce

  Released under the GNU General Public License
*/

  class bm_categories {
    var $code = 'bm_categories';
    var $group = 'boxes';
    var $title;
    var $description;
    var $sort_order;
    var $enabled = false;

    function bm_categories() {
      $this->title = MODULE_BOXES_CATEGORIES_TITLE;
      $this->description = MODULE_BOXES_CATEGORIES_DESCRIPTION;

      if ( defined('MODULE_BOXES_CATEGORIES_STATUS') ) {
        $this->sort_order = MODULE_BOXES_CATEGORIES_SORT_ORDER;
        $this->enabled = (MODULE_BOXES_CATEGORIES_STATUS == 'True');

        $this->group = ((MODULE_BOXES_CATEGORIES_CONTENT_PLACEMENT == 'Left Column') ? 'boxes_column_left' : 'boxes_column_right');
      }
    }

    function tep_show_category($counter) {
      global $tree, $categories_string, $cPath_array;
      for ($i=0; $i<$tree[$counter]['level']; $i++) {
        //$categories_string .= "&nbsp;&nbsp;";
      }
      $categories_string .= '<li><a href="';

      if ($tree[$counter]['parent'] == 0) {
        $cPath_new = 'cPath=' . $counter;
      } else {
        $cPath_new = 'cPath=' . $tree[$counter]['path'];
      }
      $categories_string .= tep_href_link(FILENAME_DEFAULT, $cPath_new) . '">';

      if (isset($cPath_array) && in_array($counter, $cPath_array)) {
        $categories_string .= '<strong>';
      }

// display category name
      $categories_string .= $tree[$counter]['name'];

      if (isset($cPath_array) && in_array($counter, $cPath_array)) {
        $categories_string .= '</strong>';
      }

      if (tep_has_category_subcategories($counter)) {
        $categories_string .= '';
      }
		if (SHOW_COUNTS == 'true') {
        $products_in_category = tep_count_products_in_category($counter);
        if ($products_in_category > 0) {
          $categories_string .= '<span class="mj-countcolor">&nbsp;(' . $products_in_category . ')</span>';
        }
      }
      $categories_string .= '</a></li>';

     
      if ($tree[$counter]['next_id'] != false) {
        $this->tep_show_category($tree[$counter]['next_id']);
      }
    }

function BuildVirtual(){
/*---virtual category---*/
global $categories_string;
$categories_string='<li><a href="'.tep_href_link(FILENAME_DISCOUNT).'">Распродажа склада</a></li>';

}

    function getData(){return $this->BuildNewMenu();}
    function getDataOld() {
      global $categories_string, $tree, $languages_id, $cPath, $cPath_array;

      $categories_string = '';
      $tree = array();

      $categories_query = tep_db_query("select c.categories_id, cd.categories_name, c.parent_id from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd where c.parent_id = '0' and c.categories_id = cd.categories_id and c.categories_status=1 and cd.language_id='" . (int)$languages_id ."' order by sort_order, cd.categories_name");
      while ($categories = tep_db_fetch_array($categories_query))  {
        $tree[$categories['categories_id']] = array('name' => $categories['categories_name'],
                                                    'parent' => $categories['parent_id'],
                                                    'level' => 0,
                                                    'path' => $categories['categories_id'],
                                                    'next_id' => false);

        if (isset($parent_id)) {
          $tree[$parent_id]['next_id'] = $categories['categories_id'];
        }

        $parent_id = $categories['categories_id'];

        if (!isset($first_element)) {
          $first_element = $categories['categories_id'];
        }
      }

      if (tep_not_null($cPath)) {
        $new_path = '';
        reset($cPath_array);
        while (list($key, $value) = each($cPath_array)) {
          unset($parent_id);
          unset($first_id);
          $categories_query = tep_db_query("select c.categories_id, cd.categories_name, c.parent_id from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd where c.parent_id = '" . (int)$value . "' and c.categories_id = cd.categories_id and cd.language_id='" . (int)$languages_id ."' order by sort_order, cd.categories_name");
          if (tep_db_num_rows($categories_query)) {
            $new_path .= $value;
            while ($row = tep_db_fetch_array($categories_query)) {
              $tree[$row['categories_id']] = array('name' => $row['categories_name'],
                                                   'parent' => $row['parent_id'],
                                                   'level' => $key+1,
                                                   'path' => $new_path . '_' . $row['categories_id'],
                                                   'next_id' => false);

              if (isset($parent_id)) {
                $tree[$parent_id]['next_id'] = $row['categories_id'];
              }

              $parent_id = $row['categories_id'];

              if (!isset($first_id)) {
                $first_id = $row['categories_id'];
              }

              $last_id = $row['categories_id'];
            }
            $tree[$last_id]['next_id'] = $tree[$value]['next_id'];
            $tree[$value]['next_id'] = $first_id;
            $new_path .= '_';
          } else {
            break;
          }
        }
      }

      $this->BuildVirtual();
      $this->tep_show_category($first_element);

      $data = '<div class="ui-widget infoBoxContainer mj-categoriessidebox">' .
              '  <div class="ui-widget-header infoBoxHeading">' . MODULE_BOXES_CATEGORIES_BOX_TITLE . '</div>' .
              '  <div class="ui-widget-content infoBoxContents"><ul>'. $categories_string .'</i></ul></div>' .
              '</div>';

      return $data;
    }

function BuildNewMenu(){

//return GetCategoryMenu(true);
return false;
global $c2c_array,$deduction_map,$languages_id,$_GET;
$DATA='<div class="ui-widget infoBoxContainer mj-categoriessidebox">' .
              '  <div class="ui-widget-header infoBoxHeading">' . MODULE_BOXES_CATEGORIES_BOX_TITLE . '</div>';
              
$DATA .= '<script type="text/javascript" src="ddaccordion.js"></script>
<script type="text/javascript">
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
	togglehtml: ["suffix", "<img src=\'images/plus.gif\' class=\'statusicon\' />", ""], 
	animatespeed: "fast", 
	collapseheader:false,
	oninit:function(headers, expandedindices){},
	onopenclose:function(header, index, state, isuseractivated){}
})
/*
PreLoadImage=new Image();
PreLoadImage.src="images/mloader.gif";
PreLoadImage.className="statusicon"
function AnimateExpand(menu){
if (jQuery(menu).find("span.accordsuffix img").attr("src")=="images/plus.gif")
    {
    jQuery(menu).find("span.accordsuffix").remove();
    jQuery(menu).find("span.accordprefix").append(PreLoadImage);
    }
}
jQuery(document).ready(function(){jQuery(".glossymenu").show();})
*/

jQuery(document).ready(function(){
    jQuery("a.submenuheader").each(function(){
	jQuery(this).attr("rel",jQuery(this).attr("href"));
	jQuery(this).attr("href","javascript:void()");
	});
/*    jQuery("a.submenuheader").find("span").click(function(){
	document.location=(jQuery(this).parent().attr("rel"));
	});*/
    })
</script>


<style type="text/css">

.glossymenu{
margin: 5px 0;
padding: 0;
border: 1px solid #9A9A9A;
border-bottom-width: 0;
display:block;
}
.glossymenu a.menuitem,.glossymenu span.menuitem{
background: black url(images/glossyback.gif) repeat-x bottom left;
font: bold 14px "Lucida Grande", "Trebuchet MS", Verdana, Helvetica, sans-serif;
color: white;
display: block;
position: relative; 
width: auto;
padding: 4px 0;
padding-left: 10px;
text-decoration: none;
}

.glossymenu a.menuitem:visited, .glossymenu .menuitem:active{
color: white;
}

.glossymenu a.menuitem .statusicon{ 
position: absolute;
top: 5px;
right: 5px;
border: none;
}

.glossymenu a.menuitem:hover{
background-image: url(images/glossyback2.gif);
}

.glossymenu div.submenu{ 
background: white;
}

.glossymenu div.submenu ul{ 
list-style-type: none;
margin: 0;
padding: 0;
background-color:#91cbf4;

}

.glossymenu div.submenu ul li{
border-bottom: 1px solid blue;
}

.glossymenu div.submenu ul li a{
display: block;
font: normal 13px "Lucida Grande", "Trebuchet MS", Verdana, Helvetica, sans-serif;
color: black;

text-decoration: none;
border-bottom: 1px dotted #5ba0d0;
padding: 2px 0;
padding-left: 10px;
}

.glossymenu div.submenu ul li a:hover{
background: url("/images/glossyback2.gif") repeat-x;
color:white;
}

</style>';

  if (!isset($c2c_array)){$c2c_array=GetCategoriesProductsCount();}
  if (!isset($deduction_map)){$deduction_map=GetDeductionMap();}

 $status = tep_db_num_rows(tep_db_query('describe ' .  TABLE_CATEGORIES . ' status'));
  $query = "select c.categories_id, cd.categories_name, c.parent_id, c.categories_image
            from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd
            where c.categories_id = cd.categories_id and c.categories_status = '1'";
  $query.= " and cd.language_id='" . $languages_id ."'
            order by sort_order, cd.categories_name";
  $categories_query = tep_db_query($query);

// Display box contents
  
  $data=$DATA.='<div class="glossymenu">';
/*in the top of menu display rasprodazha*/ 
	if (isset($_GET['sort'])?$this_sort=$_GET['sort']:$this_sort='products_sort_order');
        $data.='<a class="menuitem submenuheader" href="/'.FILENAME_DISCOUNT.'">Распродажа склада</a>';
	$data.='<div class="submenu">';
	$data.='<ul><li>';
	$dquery="select cd.categories_id as id,cd.categories_name as name from ".
        TABLE_CATEGORIES_DESCRIPTION . " cd where cd.language_id = '" . $languages_id . "'";
	$display_cat=$deduction_map['categories'];
        if (sizeof($display_cat)>0){
    	        $dquery.=" and cd.categories_id in(".implode(',',array_keys($display_cat)).") ";
                    }
    	    $dquery.=" order by categories_name";
            $dcq = tep_db_query($dquery);
            if ($dcq!==false){
                while ($dcres=tep_db_fetch_array($dcq)){
                        $data.='<a href="/'.FILENAME_DISCOUNT.'?vPath='.$dcres['id'].'">'.$dcres['name'].'</a>';
                        }
                }
        unset($dcq,$dcres);
	$data.='</li></ul>';
	$data.='</div>';
/*in the top of menu display rasprodazha*/ 
    while ($categories = tep_db_fetch_array($categories_query)) {
       if ($categories['parent_id'] == 0) {
            $temp_cPath_array = $cPath_array;  //Johan's solution - kill the array but save it for the rest of the site
            unset($cPath_array);
           $cPath_new = tep_get_path($categories['categories_id']);
           $text_subcategories = '';
           $subcategories_query = tep_db_query($query);
	while ($subcategories = tep_db_fetch_array($subcategories_query)) {
       if ($subcategories['parent_id'] == $categories['categories_id']){
           $cPath_new_sub = "cPath="  . $categories['categories_id'] . "_" . $subcategories['categories_id'];
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
 
    if ($child_category['count'] > 0) {$data.='<a class="menuitem submenuheader" href="' . tep_href_link(FILENAME_DEFAULT, $cPath_new, 'NONSSL') . '" >' . $categories['categories_name'] . '</a>';
	$data.='<div class="submenu">';
	$data.='<ul><li>' . $text_subcategories.'</li></ul>';
	$data.='</div>';}
	 else {$data.='<a class="menuitem" href="' . tep_href_link(FILENAME_DEFAULT, $cPath_new, 'NONSSL') . '">' . $categories['categories_name'] . '</a>'; }}
    $cPath_array = $temp_cPath_array; //Re-enable the array for the rest of the code
    }
  }
   $data.='</div>';	
$data.='</div>';
return $data;
}//---build new menu



    function execute() {
      global $SID, $oscTemplate;

      if ((USE_CACHE == 'true') && empty($SID)) {
        $output = tep_cache_categories_box();
      } else {
        $output = $this->getData();
      }

      $oscTemplate->addBlock($output, $this->group);
    }

    function isEnabled() {
      return $this->enabled;
    }

    function check() {
      return defined('MODULE_BOXES_CATEGORIES_STATUS');
    }

    function install() {
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Enable Categories Module', 'MODULE_BOXES_CATEGORIES_STATUS', 'True', 'Do you want to add the module to your shop?', '6', '1', 'tep_cfg_select_option(array(\'True\', \'False\'), ', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Content Placement', 'MODULE_BOXES_CATEGORIES_CONTENT_PLACEMENT', 'Left Column', 'Should the module be loaded in the left or right column?', '6', '1', 'tep_cfg_select_option(array(\'Left Column\', \'Right Column\'), ', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Sort Order', 'MODULE_BOXES_CATEGORIES_SORT_ORDER', '0', 'Sort order of display. Lowest is displayed first.', '6', '0', now())");
    }

    function remove() {
      tep_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }

    function keys() {
      return array('MODULE_BOXES_CATEGORIES_STATUS', 'MODULE_BOXES_CATEGORIES_CONTENT_PLACEMENT', 'MODULE_BOXES_CATEGORIES_SORT_ORDER');
    }
  }
?>