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
   <table border="0" width="100%" cellspacing="0" cellpadding="<?php echo CELLPADDING_SUB; ?>">
      <tr>
        <td><table class="table-padding-0">
          <tr>
                        <td class="pageHeading"><h1><?php
               if ( (ALLOW_CATEGORY_DESCRIPTIONS == 'true') && (tep_not_null($category['categories_name'])) ) {
                 echo $category['categories_name'];
               } else {
                 echo HEADING_TITLE;
               }
             ?></h1>
             После <a href="https://yourfish.ru/create_account.php" style="border-bottom: 2px dotted DarkGreen" target='_blank';> регистрации </a> Вам устанавливается спеццена на все товары магазина!
             
            </td>
            <td class="pageHeading" align="right"><?php echo tep_image(DIR_WS_IMAGES . $category['categories_image'], $category['categories_name'], HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?></td>
            
            
          </tr>
	  <?php if ( (ALLOW_CATEGORY_DESCRIPTIONS == 'true') && (tep_not_null($category['categories_description'])) ) { ?>
	  <tr>
            <td align="left" colspan="2" class="category_desc"><?php echo $category['categories_description']; ?>
	<?php 
/*by iHolder top name with content*/
    if (strlen($category['categories_top_name'])>0){?>
	<div class="tb_text">
	<a href="javascript:void();" onclick="document.getElementById('maintext_top').style.display = document.getElementById('maintext_top').style.display == 'block' ? 'none':'block'; return false;">
	    <h2><?php echo $category['categories_top_name']?></h2>
	    </a>
    <div id="maintext_top" class="maintext" style="display: none;"><?php echo $category['categories_top_content'];?></div>
    </div>
<?php }?>

</td>
	  </tr>
	  <?php }  ?>
        </table></td>
      </tr>
<?php
// Start Products Specifications
  if (SPECIFICATIONS_FILTERS_MODULE == 'True') {
?>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
      <tr>
        <td>
<?php
    require (DIR_WS_MODULES . 'products_filter.php');
?>
        </td>
      </tr>
<?php
  }
// End Products Specifications
?>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
      <tr>
        <td><table class="table-padding-2">

	  <?php if (BRWCAT_ENABLE == 'false') { ?>   


          <tr>
            <td><table class="table-padding-2">
              <tr>
<?php
    if (isset($cPath) && strpos($cPath, '_')) {
// check to see if there are deeper categories within the current category
      $category_links = array_reverse($cPath_array);
      for($i=0, $n=sizeof($category_links); $i<$n; $i++) {
        $categories_query = tep_db_query("select count(*) as total from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd where c.parent_id = '" . (int)$category_links[$i] . "' and c.categories_id = cd.categories_id and cd.language_id = '" . (int)$languages_id . "'");
        $categories = tep_db_fetch_array($categories_query);
        if ($categories['total'] < 1) {
          // do nothing, go through the loop
        } else {

// BOF Enable - Disable Categories Contribution--------------------------------------
          $categories_query = tep_db_query("select c.categories_id, cd.categories_name, c.categories_image, c.parent_id from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd where c.categories_status = '1' and c.parent_id = '" . (int)$category_links[$i] . "' and c.categories_id = cd.categories_id and cd.language_id = '" . (int)$languages_id . "' order by sort_order, cd.categories_name");
// EOF Enable - Disable Categories Contribution--------------------------------------

//          $categories_query = tep_db_query("select c.categories_id, cd.categories_name, c.categories_image, c.parent_id from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd where c.parent_id = '" . (int)$category_links[$i] . "' and c.categories_id = cd.categories_id and cd.language_id = '" . (int)$languages_id . "' order by sort_order, cd.categories_name");
          break; // we've found the deepest category the customer is in
        }
      }
    } else {
// BOF Enable - Disable Categories Contribution--------------------------------------
      $categories_query = tep_db_query("select c.categories_id, cd.categories_name, c.categories_image, c.parent_id from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd where c.categories_status = '1' and c.parent_id = '" . (int)$current_category_id . "' and c.categories_id = cd.categories_id and cd.language_id = '" . (int)$languages_id . "' order by sort_order, cd.categories_name");
// EOF Enable - Disable Categories Contribution--------------------------------------


//      $categories_query = tep_db_query("select c.categories_id, cd.categories_name, c.categories_image, c.parent_id from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd where c.parent_id = '" . (int)$current_category_id . "' and c.categories_id = cd.categories_id and cd.language_id = '" . (int)$languages_id . "' order by sort_order, cd.categories_name");
    }

    $number_of_categories = tep_db_num_rows($categories_query);

    $rows = 0;
    while ($categories = tep_db_fetch_array($categories_query)) {
      $rows++;
      $cPath_new = tep_get_path($categories['categories_id']);
      $width = (int)(100 / MAX_DISPLAY_CATEGORIES_PER_ROW) . '%';
      echo '                <td align="center" class="smallText" width="' . $width . '" valign="top"><a href="' . tep_href_link(FILENAME_DEFAULT, $cPath_new) . '">' . tep_image(DIR_WS_IMAGES . $categories['categories_image'], $categories['categories_name'], SUBCATEGORY_IMAGE_WIDTH, SUBCATEGORY_IMAGE_HEIGHT) . '<br>' . $categories['categories_name'] . '</a></td>' . "\n";
      if ((($rows / MAX_DISPLAY_CATEGORIES_PER_ROW) == floor($rows / MAX_DISPLAY_CATEGORIES_PER_ROW)) && ($rows != $number_of_categories)) {
        echo '              </tr>' . "\n";
        echo '              <tr>' . "\n";
      }
    }

// needed for the new products module shown below
    $new_products_category_id = $current_category_id;
?>
              </tr>
            </table></td>
          </tr>
          
<?php } else { ?>          
          <!-- DWD Contribution -> Add: Browse by Categories. 111!-->
          <tr>
            <td><?php $browse_category_id = $current_category_id; include(DIR_WS_MODULES . FILENAME_BROWSE_CATEGORIES); ?></td>
          </tr>
<tr><td>
<?php
include(DIR_WS_MODULES.FILENAME_PRODUCT_NESTED);
?>
</td></tr>
          <!-- DWD Contribution End. !-->
	  <?php } ?>
          <tr>
            <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
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
        </table></td>
      </tr>
<?php
/*
    if (strlen($category['categories_bottom_content'])>0){?>
    <tr><td><?php echo $category['categories_bottom_content'];?></td></tr>
<?php }*/ ?>
<?php 
/*by iHolder top name with content*/
    if (strlen($category['categories_bottom_name'])>0){?>
    <tr><td>
    <div class="tb_text">
	<a href="javascript:void();" onclick="document.getElementById('maintext_bottom').style.display = document.getElementById('maintext_bottom').style.display == 'block' ? 'none':'block'; return false;" >
	    <h2><?php echo $category['categories_bottom_name']?></h2>
	    </a>
    <div id="maintext_bottom" class="maintext" style="display: none;"><?php echo $category['categories_bottom_content'];?></div>
    </div>
    </td></tr>
<?php }?>
    </table>
