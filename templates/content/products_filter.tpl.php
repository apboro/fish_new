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
<?php 
//-----by iHolder description of category---
$category_query = tep_db_query("select cd.categories_bottom_name,cd.categories_top_name,cd.categories_top_content,cd.categories_bottom_content,
        cd.categories_name, cd.categories_heading_title, cd.categories_description, c.categories_image from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd where c.categories_id = '" . $current_category_id . "' and cd.categories_id = '" . $current_category_id . "' and cd.language_id = '" . $languages_id . "'");
$category = tep_db_fetch_array($category_query);
?><tr>
    <td class="pageHeading"><h1>
<?php
               if ( (ALLOW_CATEGORY_DESCRIPTIONS == 'true') && (tep_not_null($category['categories_name'])) ) {
                 echo $category['categories_name'];
               } else {
                 echo HEADING_TITLE;
               }
             ?></h1>
            </td>
            <td class="pageHeading" align="right">
            <?php 
            echo tep_image(DIR_WS_IMAGES . $category['categories_image'], $category['categories_name'], HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); 
    	    ?></td>
          </tr>
          <?php 
            if ( (ALLOW_CATEGORY_DESCRIPTIONS == 'true') && (tep_not_null($category['categories_description'])) ) 
            { 
            ?>
          <tr>
            <td align="left" colspan="2" class="category_desc"><?php echo $category['categories_description']; ?></td>
         </tr>
<?php    }?>
        <?php
//by iHolder top name with content

    if (strlen($category['categories_top_name'])>0){?>
	<tr><td>
	<div class="tb_text">
        <a href="javascript:void();" onclick="document.getElementById('maintext_top').style.display = document.getElementById('maintext_top').style.display == 'block' ? 'none':'block'; return false;">
            <h2><?php echo $category['categories_top_name'];?></h2>
            </a>
    <div id="maintext_top" class="maintext" style="display: none;"><?php echo $category['categories_top_content'];?></div>
    </div>
</td>
          </tr>
<?php } ?>

<?php
//-----by iHolder description of category---
?>
<?php /* ?>
          <tr>
            <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
            <td align="right">&nbsp;</td>
          </tr> 
<?php */ ?>



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

      <tr>
        <td><table class="table-padding-2">
            
<?php
  // Show the Filters module here if set in Admin
  if (SPECIFICATIONS_FILTERS_MODULE == 'True') {
?>
      <tr>
        <td><?php echo tep_draw_separator ('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
      <tr>
        <td>
<?php

require(DIR_WS_MODULES . FILENAME_PRODUCTS_FILTERS);
?>
        </td>
      </tr>
<?php
  }
?>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '20'); ?></td>
      </tr>
      <tr valign=top>
        <td valign=top><?php include(DIR_WS_MODULES . FILENAME_PRODUCT_LISTING_COL); ?></td>
      </tr>
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
        <?php }
//----bottom text        
        ?>

        </table></td>
      </tr>
<?php
// BOF: Lango Added for template MOD
if (MAIN_TABLE_BORDER == 'yes'){
table_image_border_bottom();
}
// EOF: Lango Added for template MOD
?>   </table>