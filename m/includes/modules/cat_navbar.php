<?php
/*
CATEGORY NAVIGATION BAR
cat_navbar.php
Adapted from ul_categories and superfish jquery for OSC to CSS
references:
by www.niora.com/css-oscommerce.php

  $Id: ul_categories.php,v 1.00 2006/04/30 01:13:58 nate_02631 Exp $	
	Outputs the store category list as a proper unordered list, opening up
	possibilities to use CSS to style as drop-down/flyout, collapsable or 
	other menu types.
  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com
  Copyright (c) 2006 Nate Welch http://www.natewelch.com
  Released under the GNU General Public License
*/

// BEGIN Configuration options

  	// Indicates whether or not to render your entire category list or just the root categories
	// and the currently selected submenu tree. Rendering the full list is useful for dynamic menu
	// generation where you want the user to have instant access to all categories. The other option
	// is the default oSC behaviour, when the subcats aren't available until the parent is clicked. 
	$show_full_tree = true;	
  
	// This is the CSS *ID* you want to assign to the UL (unordered list) containing
	// your category menu. Used in conjuction with the CSS list you create for the menu.
	// This value cannot be blank.
	$idname_for_menu = 'sf-menu';  // see superfish.css
	
  
	// This is the *CLASSNAME* you want to tag a LI to indicate the selected category.
	// The currently selected category (and its parents, if any) will be tagged with
	// this class. Modify your stylesheet as appropriate. Leave blank or set to false to not assign a class. 
//gt	$classname_for_selected = 'selected';
	$classname_for_selected = 'selected';  // see superfish.css
	
  
	// This is the *CLASSNAME* you want to tag a LI to indicate a category has subcategores.
	// Modify your stylesheet to draw an indicator to show the users that subcategories are
	// available. Leave blank or set to false to not assign a class. 	
//gt	$classname_for_parent = 'parent';
    $classname_for_parent = 'current_parent';  //see superfish.css
	
	
	// This is the HTML that you would like to appear before your categories menu  
	// This is useful for reconciling tables or clearing
	// floats, depending on your layout needs. Leave blank for no html
	$before_html = '';
	
	// This is the HTML that you would like to appear after your categories menu if *not*
	// displaying in a standard "box". This is useful for reconciling tables or clearing
	// floats, depending on your layout needs.	
    $after_html = '
		';	


// END Configuration options

// Global Variables
$GLOBALS['this_level'] = 0;

// Initialize HTML and info_box class if displaying inside a box


// Generate a bulleted list (uses configuration options above)
$categories_string = tep_make_catsf_ullist();


	echo $before_html;	
    echo $categories_string;
	echo $after_html;



// Create the root unordered list
function tep_make_catsf_ullist($rootcatid = 0, $maxlevel = 0){

    global $idname_for_menu, $cPath_array, $show_full_tree, $languages_id;
/*---virtual directory---*/
    $deduction_map=GetDeductionMap();
    $display_cat=$deduction_map['categories'];

    $output='<ul class="nav"><li><a href="'.tep_href_link(FILENAME_DISCOUNT).'">????????????????????</a>';
    $output.='<ul class="nav-child unstyled">';
     $dquery="select cd.categories_id as id,cd.categories_name as name from ".
     TABLE_CATEGORIES_DESCRIPTION . " cd where cd.language_id = '" . $languages_id . "'";
     if (sizeof($display_cat)>0){
             $dquery.=" and cd.categories_id in(".implode(',',array_keys($display_cat)).") ";
                 }
      $dquery.=" order by categories_name";
      $dcq = tep_db_query($dquery);
      if ($dcq!==false){
      while ($dcres=tep_db_fetch_array($dcq)){
       $output.='<li><a href="/'.FILENAME_DISCOUNT.'?vPath='.$dcres['id'].'">'.$dcres['name'].'</a></li>';
       }
       }
      unset($dcq,$dcres);
    $output.='</ul>';
    $output.='</li></ul>';
/*---virtual directory---*/    





    // Modify category query if not fetching all categories (limit to root cats and selected subcat tree)
		if (!$show_full_tree) {
        $parent_query	= 'AND (c.parent_id = "0"';	
				
				if (isset($cPath_array)) {
				
				    $cPath_array_temp = $cPath_array;
				
				    foreach($cPath_array_temp AS $key => $value) {
						    $parent_query	.= ' OR c.parent_id = "'.$value.'"';
						}
						
						unset($cPath_array_temp);
				}	
				
        $parent_query .= ')';				
		} else {
        $parent_query	= '';	
		}
		
		$result = tep_db_query('select c.categories_id, cd.categories_name, c.parent_id from ' . TABLE_CATEGORIES . ' c, ' . TABLE_CATEGORIES_DESCRIPTION . ' cd where c.categories_id = cd.categories_id and cd.language_id="' . (int)$languages_id .'" '.$parent_query.' and c.categories_status=1 order by sort_order, cd.categories_name');
    
		while ($row = tep_db_fetch_array($result)) {				
        $table[$row['parent_id']][$row['categories_id']] = $row['categories_name'];
    }
    $output .= '<ul class="nav">';
//gt    $output .= '<ul id="'.$idname_for_menu.'">';
    $output .= tep_make_catsf_ulbranch($rootcatid, $table, 0, $maxlevel);

		// Close off nested lists
    for ($nest = 0; $nest <= $GLOBALS['this_level']; $nest++) {
			//if you need extra links uncomment out the lines below
				//	$output .= '</ul></li>';
				//	$output .=' 
				//	<li><a href=" '.tep_href_link('myextralink_1.php', '', 'NONSSL').'" >Extra Link 1</a></li> 
				//	<li><a href=" '.tep_href_link('myextralink_2.php', '', 'NONSSL').'" >Extra Link 2</a></li> 
				//	<li><a href=" '.tep_href_link('myextralink_3.php', '', 'NONSSL').'" >Extra Link 3</a></li> 
				//	';
      	 $output .= '</ul></li>';	
	  }
	   
			 
    return $output;
}

// Create the branches of the unordered list
function tep_make_catsf_ulbranch($parcat, $table, $level, $maxlevel) {

    global $cPath_array, $classname_for_selected, $classname_for_parent;
		
    $list = $table[$parcat];
	
    while(list($key,$val) = each($list)){
			 
        if ($GLOBALS['this_level'] != $level) {

		        if ($GLOBALS['this_level'] < $level) {
				        $output .= "\n".'<ul class="nav-child unstyled">';
				    } else {
                for ($nest = 1; $nest <= ($GLOBALS['this_level'] - $level); $nest++) {
                    $output .= '</ul></li>'."\n";	
		            }
	/*							
								if ($GLOBALS['this_level'] -1 == $level)
$output .= '</ul></li>'."\n";
elseif ($GLOBALS['this_level'] -2 == $level)
$output .= '</ul></li></ul></li>'."\n";
elseif ($GLOBALS['this_level'] -3 == $level)
$output .= '</ul></li></ul></li></ul></li>'."\n";
elseif ($GLOBALS['this_level'] -4 == $level)
$output .= '</ul></li></ul></li></ul></li></ul></li>'."\n"; 
	*/							
						}			
		
		        $GLOBALS['this_level'] = $level;
        }

        if (isset($cPath_array) && in_array($key, $cPath_array) && $classname_for_selected) {
            $this_cat_class = ' class="'.$classname_for_selected.'"';
        } else {
            $this_cat_class = '';		
		    }	
		
     //gt   $output .= '<li class="cat_lev_'.$level.'"><a href="';
         $output .= '<li class="selected_'.$level.'"><a href="';

        if (!$level) {
				    unset($GLOBALS['cPath_set']);
						$GLOBALS['cPath_set'][0] = $key;
            $cPath_new = 'cPath=' . $key;

        } else {
						$GLOBALS['cPath_set'][$level] = $key;		
            $cPath_new = 'cPath=' . implode("_", array_slice($GLOBALS['cPath_set'], 0, ($level+1)));
        }
	
        if (tep_has_category_subcategories($key) && $classname_for_parent) {
            $this_parent_class = ' class="'.$classname_for_parent.'"';
        } else {
            $this_parent_class = '';		
		    }				

        $output .= tep_href_link(FILENAME_DEFAULT, $cPath_new) . '"'.$this_parent_class.'>'.$val;		

        if (SHOW_COUNTS == 'true') {
            $products_in_category = tep_count_products_in_category($key);
            if ($products_in_category > 0) {
                $output .= '';
            }
        }
		
        $output .= '</a>';	

        if (!tep_has_category_subcategories($key)) {
            $output .= '</li>'."\n";	
        }						 
								
        if ((isset($table[$key])) AND (($maxlevel > $level + 1) OR ($maxlevel == '0'))) {
            $output .= tep_make_catsf_ulbranch($key,$table,$level + 1,$maxlevel);
        }
    
		} // End while loop

    return $output;
    
}	


?>