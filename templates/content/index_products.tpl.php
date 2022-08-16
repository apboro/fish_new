<?php if ($category['categories_status'] ==0) {
	
	//echo $category['categories_name'];
	//echo $category['categories_status'];
header('HTTP/1.1 301 Moved Permanently');
header('Location: https://yourfish.ru');  
}
//	echo $category['categories_name'];
//	echo $category['categories_status'];
//	echo 'gggggg';
?>
  <table border="0" width="100%" cellspacing="0" cellpadding="<?php echo CELLPADDING_SUB;?>">
      <tr>
        <td><table class="table-padding-0">
          <tr>
                        <td class="pageHeading"><h1><?php
    // Get the category name and description
    $category_query = tep_db_query("select cd.categories_bottom_name,cd.categories_top_name,cd.categories_top_content,
	cd.categories_bottom_content,cd.categories_name, cd.categories_heading_title, cd.categories_description, cd.categories_meta_description, c.categories_image from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd where c.categories_id = '" . $current_category_id . "' and cd.categories_id = '" . $current_category_id . "' and cd.language_id = '" . $languages_id . "'");
    $category = tep_db_fetch_array($category_query);
     $heading_text_box = $category['categories_name'];

               if ( (ALLOW_CATEGORY_DESCRIPTIONS == 'true') && (tep_not_null($category['categories_heading_title'])) ) {
                 echo $category['categories_heading_title'];
               } elseif (tep_not_null($_GET['manufacturers_id'])) {
                 echo tep_get_manufacturers_name($_GET['manufacturers_id']);
               } else {
                 echo HEADING_TITLE;
               }
             ?></h1>
             
             После <a href="https://yourfish.ru/create_account.php" style="border-bottom: 2px dotted DarkGreen" target='_blank';> регистрации </a> Вам устанавливается спеццена на все товары магазина!
            </td>
<?php
// optional Product List Filter
/*
    if (PRODUCT_LIST_FILTER > 0) {
      if (isset($_GET['manufacturers_id'])) {
        $filterlist_sql = "select distinct c.categories_id as id, cd.categories_name as name from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c, " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd where p.products_status = '1' and p.products_id = p2c.products_id and p2c.categories_id = c.categories_id and p2c.categories_id = cd.categories_id and cd.language_id = '" . (int)$languages_id . "' and p.manufacturers_id = '" . (int)$_GET['manufacturers_id'] . "' order by cd.categories_name";
      } else {
// BOF manufacturers descriptions
//      $filterlist_sql= "select distinct m.manufacturers_id as id, m.manufacturers_name as name from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c, " . TABLE_MANUFACTURERS . " m where p.products_status = '1' and p.manufacturers_id = m.manufacturers_id and p.products_id = p2c.products_id and p2c.categories_id = '" . (int)$current_category_id . "' order by m.manufacturers_name";
        $filterlist_sql= "select distinct mi.manufacturers_id as id, mi.manufacturers_name as name from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c, " . TABLE_MANUFACTURERS_INFO . " mi where p.products_status = '1' and p.manufacturers_id = mi.manufacturers_id and p.products_id = p2c.products_id and p2c.categories_id = '" . (int)$current_category_id . "' and mi.languages_id = '" . (int)$languages_id . "' order by mi.manufacturers_name";
// EOF manufacturers descriptions
      }
      $filterlist_query = tep_db_query($filterlist_sql);
      if (tep_db_num_rows($filterlist_query) > 1) {
        echo '            <td align="center" class="main">' . tep_draw_form('filter', tep_href_link( FILENAME_DEFAULT ), 'get') . TEXT_SHOW . '&nbsp;';
        if (isset($_GET['manufacturers_id'])) {
          echo tep_draw_hidden_field('manufacturers_id', $_GET['manufacturers_id']);
          $options = array(array('id' => '', 'text' => TEXT_ALL_CATEGORIES));
        } else {
          echo tep_draw_hidden_field('cPath', $cPath);
          $options = array(array('id' => '', 'text' => TEXT_ALL_MANUFACTURERS));
        }
        echo tep_draw_hidden_field('sort', $_GET['sort']);
        while ($filterlist = tep_db_fetch_array($filterlist_query)) {
          $options[] = array('id' => $filterlist['id'], 'text' => $filterlist['name']);
        }
        echo tep_draw_pull_down_menu('filter_id', $options, (isset($_GET['filter_id']) ? $_GET['filter_id'] : ''), 'onchange="this.form.submit()"');
        echo tep_hide_session_id() . '</form></td>' . "\n";
      }
    }
*/
// Get the right image for the top-right
    $image = DIR_WS_IMAGES . 'table_background_list.gif';
    if (isset($_GET['manufacturers_id'])) {
      $image = tep_db_query("select manufacturers_image from " . TABLE_MANUFACTURERS . " where manufacturers_id = '" . (int)$_GET['manufacturers_id'] . "'");
      $image = tep_db_fetch_array($image);
      $image = $image['manufacturers_image'];
// BOF manufacturers descriptions
//     $manufactures_query = tep_db_query("select manufacturers_name from " . TABLE_MANUFACTURERS . " where manufacturers_id = '" . (int)$_GET['manufacturers_id'] . "'");
       $manufactures_query = tep_db_query("select manufacturers_name, manufacturers_description from " . TABLE_MANUFACTURERS_INFO . " where manufacturers_id = '" . (int)$_GET['manufacturers_id'] . "' and languages_id = '" . (int)$languages_id . "'");
// EOF manufacturers descriptions
$manufactures = tep_db_fetch_array($manufactures_query);
$heading_text_box = $manufactures['manufacturers_name'];
// BOF manufacturers descriptions
if(tep_not_null($manufactures['manufacturers_description']))
$category['categories_description'] = $manufactures['manufacturers_description'];
$category['categories_name'] = $manufactures['manufacturers_name'];
// EOF manufacturers descriptions

    } elseif ($current_category_id) {
      $image = tep_db_query("select categories_image from " . TABLE_CATEGORIES . " where categories_id = '" . (int)$current_category_id . "'");
      $image = tep_db_fetch_array($image);
      $image = $image['categories_image'];
    }
?>
<?php
// Start Product Specifications
      // Check the number of products is above the minimum for the comparison table
      $check_query_raw = "select distinct p2c.products_id
                           from " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c,
                                " . TABLE_SPECIFICATION_GROUPS . " sg,
                                " . TABLE_SPECIFICATIONS_TO_CATEGORIES . " sg2c
                           where sg.show_comparison = 'True'
                             and sg.specification_group_id = sg2c.specification_group_id
                             and p2c.categories_id = sg2c.categories_id 
                             and sg2c.categories_id = '" . (int) $current_category_id . "'
                         ";
      // print $check_query_raw . "<br>\n";
      $check_query = tep_db_query ($check_query_raw);
      $show_comparison = SPECIFICATIONS_MINIMUM_COMPARISON <= tep_db_num_rows ($check_query);

      if (SPECIFICATIONS_BOX_COMP_INDEX == 'False' && SPECIFICATIONS_COMP_LINK == 'True' && $current_category_id != 0 && $show_comparison == true && tep_has_spec_group ($current_category_id, 'show_comparison') == true) {
        echo '                <td align="center"><a href="' . tep_href_link (FILENAME_COMPARISON, 'cPath=' . $cPath) . '">' . tep_template_image_button ('button_products_comparison.gif', TEXT_BUTTON_COMPARISON) . '</a></td>' . "\n";
      } // if (SPECIFICATIONS_BOX_COMP_INDEX
// End Product Specifications
?>
            <td align="right">

<?php
if ($image != '') {
echo tep_image(DIR_WS_IMAGES . $image, $category['categories_name'], HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT);  
}
else
{
echo "&nbsp;";
}
?>

            </td>
          </tr>
	  <?php if ( (ALLOW_CATEGORY_DESCRIPTIONS == 'true') && (tep_not_null($category['categories_description'])) ) { ?>
	  <tr>
            <td align="left" colspan="3" class="category_desc"><?php echo $category['categories_description']; echo '<br>'; echo $category['categories_meta_description'];?></td>
			
	  </tr>

<?php
    if (strlen($category['categories_top_name'])>0){?>
	  <tr><td>
	  <div class="tb_text">
    <a href="javascript:void();" onclick="document.getElementById('maintext_top').style.display = document.getElementById('maintext_top').style.display == 'block' ? 'none':'block'; return false;">
        <h2><?php echo $category['categories_top_name']?></h2>
        </a>
    <div id="maintext_top" class="maintext" style="display: none;"><?php echo $category['categories_top_content'];?>
	
	</div>
</div>
</td></tr>
<?php }?>

	  <?php } ?>
        </table></td>
      </tr>
<?php
if ( ($error_cart_msg) ) {
?>
      <tr>
        <td align="right"><br><?php echo tep_output_warning($error_cart_msg); ?></td>
      </tr>
<?php
}
$error_cart_msg='';
?>
<?php

if (BRWCAT_ENABLE == 'false') { ?>


<!-- BOF: Show subcategories in Product Listing -->
<?php
 if (SHOW_SUBCATEGORIES_WHEN_CATEGORIES_HAS_PRODUCTS == 'true') {
?>
    <tr>
	<td><table class="table-padding-2"><tr>
	<?php
    
        if (isset($cPath)) {
			if (preg_match('/_/', $cPath)) {
				$category_links = array_reverse($cPath_array);
				$cat_to_search = $category_links[0];
				}
			else {
				$cat_to_search = $cPath;
				}
		    // check to see if there are deeper categories within the current category
		  	$categories_query = tep_db_query("select c.categories_id, cd.categories_name, c.categories_image, 
c.parent_id from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd where c.categories_status = '1' and c.parent_id = '" . $cat_to_search
. "' and c.categories_id = cd.categories_id and cd.language_id = '" . $languages_id . "' order by sort_order, 
cd.categories_name");
			    if (tep_db_num_rows($categories_query) > 0 ) {
				    $rows = 0;
					while ($categories = tep_db_fetch_array($categories_query)) {
					    $rows++;
						$cPath_new = tep_get_path($categories['categories_id']);
						$width = (int)(100 / MAX_DISPLAY_CATEGORIES_PER_ROW) . '%';
						echo '               <td align="center" class="smallText" style="width: ' .
$width . '" valign="top"><a href="' . tep_href_link(FILENAME_DEFAULT, $cPath_new) . '">' . tep_image(DIR_WS_IMAGES .
$categories['categories_image'], $categories['categories_name'], SUBCATEGORY_IMAGE_WIDTH, SUBCATEGORY_IMAGE_HEIGHT) . '<br>'
. $categories['categories_name'] . '</a></td>' . "\n";
						if ((($rows / MAX_DISPLAY_CATEGORIES_PER_ROW) == floor($rows /
MAX_DISPLAY_CATEGORIES_PER_ROW)) && ($rows != tep_db_num_rows($categories_query))) {
							echo '              </tr>' . "\n";
							echo '              <tr>' . "\n";
							}
					}
				}
		}
    ?>
    </tr></table></td>
	</tr>
<?php
 }
?>
<!-- EOF: Show subcategories in Product Listing -->

<?php } else { ?>
          <!-- DWD Contribution -> Add: Browse by Categories. 222!-->
          <tr>
            <td><?php $browse_category_id = $current_category_id; include(DIR_WS_MODULES . FILENAME_BROWSE_CATEGORIES); ?></td>
          </tr>
          <!-- DWD Contribution End. !-->
	  <?php } ?>


<?php /* if (PRODUCT_LIST_FILTER > 0) { ?>
            <tr>
            <td><?php
        	//require(DIR_WS_TEMPLATES . TEMPLATE_NAME . '/boxes/sort.php');
        	?></td>
          </tr>

<?php } */?>
      <?php
// Start Products Specifications
  if (SPECIFICATIONS_FILTERS_MODULE == 'True') {
/*
?>
      <tr>
        <td>
<?php
*/  
    require (DIR_WS_MODULES . 'products_filter.php');

/*
?>
        </td>
      </tr>
<?php
*/  }
// End Products Specifications
?>

<?php
// BOF: Lango Added for template MOD
if (MAIN_TABLE_BORDER == 'yes'){
$heading_text = $heading_text_box ;
table_image_border_top(false, false, $heading_text);
}
// EOF: Lango Added for template MOD
?>
     
      <tr>
        <td><?php include(DIR_WS_MODULES . FILENAME_PRODUCT_LISTING_COL); ?></td>
      </tr>


          <tr>
            <td><?php include(DIR_WS_MODULES . FILENAME_FEATURED); ?></td>
          </tr>
          <tr>
            <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
          </tr>
          <tr>
            <td><?php include(DIR_WS_MODULES . FILENAME_NEW_PRODUCTS); ?></td>
          </tr>

          
<?php
// BOF: Lango Added for template MOD
if (MAIN_TABLE_BORDER == 'yes'){
table_image_border_bottom();
}
// EOF: Lango Added for template MOD
?>
<?php
/*
    if (strlen($category['categories_bottom_content'])>0){?>
    <tr><td><?php echo $category['categories_bottom_content'];?></td></tr>
<?php }*/ ?>

<?php
    if (strlen($category['categories_bottom_name'])>0){?>
    
	  <tr><td>

	  <div class="tb_text">

    <a href="javascript:void();" onclick="document.getElementById('maintext_bottom').style.display = document.getElementById('maintext_bottom').style.display == 'block' ? 'none':'block'; return false;">

        <h2><?php echo $category['categories_bottom_name']?></h2>
        </a>

       
    <div id="maintext_bottom" class="maintext" style="display: none;"><?php echo $category['categories_bottom_content'];?></div>

    </div>
</td></tr>
<?php }?>


    </table>