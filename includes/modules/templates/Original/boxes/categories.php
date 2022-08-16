<script type="text/javascript" src="jscript/jquery/jquery.js"></script>

<script type="text/javascript" src="ddaccordion.js">

/***********************************************
* Accordion Content script- (c) Dynamic Drive DHTML code library (www.dynamicdrive.com)
* Visit http://www.dynamicDrive.com for hundreds of DHTML scripts
* This notice must stay intact for legal use
***********************************************/

</script>


<script type="text/javascript">


ddaccordion.init({
	headerclass: "submenuheader", //Shared CSS class name of headers group
	contentclass: "submenu", //Shared CSS class name of contents group
	revealtype: "clickgo", //Reveal content when user clicks or onmouseover the header? Valid value: "click", "clickgo", or "mouseover"
	mouseoverdelay: 200, //if revealtype="mouseover", set delay in milliseconds before header expands onMouseover
	collapseprev: true, //Collapse previous content (so only one open at any time)? true/false 
	defaultexpanded: [], //index of content(s) open by default [index1, index2, etc] [] denotes no content
	onemustopen: false, //Specify whether at least one header should be open always (so never all headers closed)
	animatedefault: false, //Should contents open by default be animated into view?
	persiststate: true, //persist state of opened contents within browser session?
	toggleclass: ["", ""], //Two CSS classes to be applied to the header when it's collapsed and expanded, respectively ["class1", "class2"]
	togglehtml: ["suffix", "<img src='images/plus.gif' class='statusicon' />", "<img src='images/minus.gif' class='statusicon' />"], //Additional HTML added to the header when it's collapsed and expanded, respectively  ["position", "html1", "html2"] (see docs)
	animatespeed: "fast", //speed of animation: integer in milliseconds (ie: 200), or keywords "fast", "normal", or "slow"
	oninit:function(headers, expandedindices){ //custom code to run when headers have initalized
		//do nothing
	},
	onopenclose:function(header, index, state, isuseractivated){ //custom code to run whenever a header is opened or closed
		//do nothing
	}
})

PreLoadImage=new Image();
PreLoadImage.src='/images/mloader.gif';
PreLoadImage.className="statusicon"
function AnimateExpand(menu){
if ($(menu).find('span.accordsuffix img').attr('src')=='images/plus.gif')
    {
    $(menu).find('span.accordsuffix').remove();
    $(menu).find('span.accordprefix').append(PreLoadImage);
    }
}

</script>


<style type="text/css">

.glossymenu{
margin: 5px 0;
padding: 0;
width: 205px; /*width of menu*/
border: 1px solid #9A9A9A;
border-bottom-width: 0;
}

.glossymenu a.menuitem{
background: black url(images/glossyback.gif) repeat-x bottom left;
font: bold 14px "Lucida Grande", "Trebuchet MS", Verdana, Helvetica, sans-serif;
color: white;
display: block;
position: relative; /*To help in the anchoring of the ".statusicon" icon image*/
width: auto;
padding: 4px 0;
padding-left: 10px;
text-decoration: none;
}


.glossymenu a.menuitem:visited, .glossymenu .menuitem:active{
color: white;
}

.glossymenu a.menuitem .statusicon{ /*CSS for icon image that gets dynamically added to headers*/
position: absolute;
top: 5px;
right: 5px;
border: none;
}

.glossymenu a.menuitem:hover{
background-image: url(images/glossyback2.gif);
}

.glossymenu div.submenu{ /*DIV that contains each sub menu*/
background: white;
}

.glossymenu div.submenu ul{ /*UL of each sub menu*/
list-style-type: none;
margin: 0;
padding: 0;
}

.glossymenu div.submenu ul li{
border-bottom: 1px solid blue;
}

.glossymenu div.submenu ul li a{
display: block;
font: normal 13px "Lucida Grande", "Trebuchet MS", Verdana, Helvetica, sans-serif;
color: black;
text-decoration: none;
padding: 2px 0;
padding-left: 10px;
}

.glossymenu div.submenu ul li a:hover{
background: #DFDCCB;
colorz: white;
}

</style>


	<tr>
	 <td valign="top">			
<?php
  if (!isset($c2c_array)){$c2c_array=GetCategoriesProductsCount();}
  if (!isset($deduction_map)){$deduction_map=GetDeductionMap();}


  $info_box_contents = array();
  $info_box_contents[] = array('text' => BOX_HEADING_CATEGORIES);

  new infoBoxHeading($info_box_contents);?>
<table border="0" cellpadding="0" cellspacing="0" height="100%"  width="100%" style="margin-top:1px;">
	<tr>
	   <td valign="top" style="padding:1px; ">  



<?php
// Categories  Accordion Menu
// coded by fl�ist 2009
// @florist duzgun.com forum

//  categories list

$status = tep_db_num_rows(tep_db_query('describe ' .  TABLE_CATEGORIES . ' status'));


  $query = "select c.categories_id, cd.categories_name, c.parent_id, c.categories_image
            from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd
            where c.categories_id = cd.categories_id and c.categories_status = '1'";


  $query.= " and cd.language_id='" . $languages_id ."'
            order by sort_order, cd.categories_name";

  $categories_query = tep_db_query($query);


 
// Display box contents

  echo'2<div class="glossymenu">';
/*in the top of menu display rasprodazha*/ 
	if (isset($_GET['sort'])?$this_sort=$_GET['sort']:$this_sort='products_sort_order');
        echo'<a class="menuitem submenuheader" href="/'.FILENAME_DISCOUNT.'?sort='.$this_sort.'" onclick="AnimateExpand(this);">Распродажа склада</a>';
	echo'<div class="submenu">';
	echo'<ul><li>';
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
                        echo '<a href="/'.FILENAME_DISCOUNT.'?vPath='.$dcres['id'].'&sort='.$this_sort.'">'.$dcres['name'].'</a>';
                        }
                }
        unset($dcq,$dcres);
	echo'</li></ul>';
	echo'</div>';
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
	  
/*	 $parent = $categories['parent_id'];
	 $count_query = tep_db_query ("select count(*)as sayi from ".TABLE_CATEGORIES." where parent_id = 0 ");
	 $count = tep_db_fetch_array($count_query);
	 
   $cat_bosluk = '<br style="clear: left"/>';
	for($i=4;$i<$count['sayi'];$i++){

    if(($i%4)!=0) continue; */
	
	
	
    if (tep_has_category_subcategories($category_id)) {
    $child_category_query = tep_db_query("select count(*) as count from " . TABLE_CATEGORIES . " where parent_id = '" . $categories['categories_id'] . "'");
    $child_category = tep_db_fetch_array($child_category_query);
 
    if ($child_category['count'] > 0) {echo'<a class="menuitem submenuheader" href="' . tep_href_link(FILENAME_DEFAULT, $cPath_new, 'NONSSL') . '" onclick="AnimateExpand(this);">' . $categories['categories_name'] . '</a>';
	echo'<div class="submenu">';
	echo'<ul><li>' . $text_subcategories.'</li></ul>';
	echo'</div>';}
	 else {echo'<a class="menuitem" href="' . tep_href_link(FILENAME_DEFAULT, $cPath_new, 'NONSSL') . '">' . $categories['categories_name'] . '</a>'; }}

	
    
	 
	// echo''.$cat_bosluk[$i].'';    
       
   // }
    $cPath_array = $temp_cPath_array; //Re-enable the array for the rest of the code
    }
  }
   echo'</div>';	
?>
			  </td>
			</tr>
		</table>	
	</td>
</tr>
<!-- show_subcategories_eof //-->
