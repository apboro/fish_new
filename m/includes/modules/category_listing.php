<?php

if (!isset($c2c_array) || empty($c2c_array)){$c2c_array=GetCategoriesProductsCount();}
if (strlen(trim($cPath))==0){return;}
    if (isset($cPath) && strpos('_', $cPath)) {
// check to see if there are deeper categories within the current category
      $category_links = array_reverse($cPath_array);
      for($i=0, $n=sizeof($category_links); $i<$n; $i++) {
        $categories_query = tep_db_query("select count(*) as total from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd where c.parent_id = '" . (int)$category_links[$i] . "' and c.categories_id = cd.categories_id and cd.language_id = '" . (int)$languages_id . "' ");
        $categories = tep_db_fetch_array($categories_query);
        if ($categories['total'] < 1) {
          // do nothing, go through the loop
        } else {
          $categories_query = tep_db_query("select c.categories_id, cd.categories_name, c.categories_image, c.parent_id from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd where c.parent_id = '" . (int)$category_links[$i] . "' and c.categories_id = cd.categories_id and cd.language_id = '" . (int)$languages_id . "' and c.categories_status=1  order by sort_order, cd.categories_name");
          break; // we've found the deepest category the customer is in
        }
      }
    } else {
      $categories_query = tep_db_query("select c.categories_id, cd.categories_name, c.categories_image, c.parent_id from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd where c.parent_id = '" . (int)$current_category_id . "' and c.categories_id = cd.categories_id and cd.language_id = '" . (int)$languages_id . "'  and c.categories_status=1  order by sort_order, cd.categories_name");
    }
    $number_of_categories = tep_db_num_rows($categories_query);
    if ($number_of_categories>0){
echo '<div class="contentText">
<table border="0" width="100%" cellspacing="10" cellpadding="1">
          <tr><td>';
    $rows = 0;
if ($cPath!=='0'){
?>
<script type="text/javascript">
function SwitchCLB(){
    jQuery("div.CLB").toggle();
    setCookie('CLBs',jQuery("div.CLB").css('display'));
    }
</script>
<div class="SA_CLB" onclick='SwitchCLB();'><i class="fa fa-sort" aria-hidden="true"></i><span> Показать все <?php echo $catname?></span></div>

<?php
    }
echo '<div class="CLB">';
if ($cPath=='0'){
//    echo '<div class="CLB">';
    echo '<div class="categoryListBoxContents">
	<div class="subproduct_name">
	    <a href="' . tep_href_link(FILENAME_DISCOUNT) . '">' .
		tep_image(DIR_WS_IMAGES.'skidki.png', 'Распродажа склада', SUBCATEGORY_IMAGE_WIDTH, SUBCATEGORY_IMAGE_HEIGHT) .
	       '<br />Распродажа склада</a>
	    </div>
	    </div>';
//    echo '</div>';
    }

        $category_ids = array();
        while ($current_categories = tep_db_fetch_array($categories_query)) {
            $list_categories[] = $current_categories;
            $category_ids[] = $current_categories['categories_id'];
        }
        $cPaths_cur = tep_get_paths($category_ids);

        $notav_cats = array();
        foreach ($list_categories as $categories ) {
            if ($c2c_array[$categories['categories_id']]<=0){
                $notav_cats[] = $categories;
                continue;
            }
            $rows++;
          $cPath_new = $cPaths_cur[$categories['categories_id']];
//          $width = (int)(100 / MAX_DISPLAY_CATEGORIES_PER_ROW_MOB) . '%';
          echo '<div class="categoryListBoxContents '.$notavailable.'"><div class="subproduct_name"><a href="' . tep_href_link(FILENAME_DEFAULT, $cPath_new) . '">' . tep_image(DIR_WS_IMAGES . $categories['categories_image'], $categories['categories_name'], SUBCATEGORY_IMAGE_WIDTH, SUBCATEGORY_IMAGE_HEIGHT) . '<br />' . $categories['categories_name'] . '</a></div></div>';
    	}

        if (SHOW_SUBCATEGORIES_WHEN_CATEGORIES_HAS_QUANTITY !== 'false') {
            foreach ($notav_cats as $categories) {
                $rows++;
                $cPath_new = $cPaths_cur[$categories['categories_id']];
//          $width = (int)(100 / MAX_DISPLAY_CATEGORIES_PER_ROW_MOB) . '%';
                echo '<div class="categoryListBoxContents noavaile"><div class="subproduct_name"><a href="' . tep_href_link(FILENAME_DEFAULT, $cPath_new) . '">' . tep_image(DIR_WS_IMAGES . $categories['categories_image'], $categories['categories_name'], SUBCATEGORY_IMAGE_WIDTH, SUBCATEGORY_IMAGE_HEIGHT) . '<br />' . $categories['categories_name'] . '</a></div></div>';

            }
        }
        echo '</div>';
echo '</td></tr></table></div>';
?>
<script type="text/javascript">
<?php
if ($cPath!='0'){
?>
jQuery("div.CLB").css('display',getCookie("CLBs"));
<?php }?>
AllignCategory();
</script>
<?php

}
?>