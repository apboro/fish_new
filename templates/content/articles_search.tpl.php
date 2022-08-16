<table border="0" width="100%" cellspacing="0" cellpadding="<?php echo CELLPADDING_SUB;?>">
<?php
// BOF: Lango Added for template MOD
if (SHOW_HEADING_TITLE_ORIGINAL == 'yes') {
$header_text = '&nbsp;'
//EOF: Lango Added for template MOD
?>
      <tr>
        <td><table class="table-padding-0">
          <tr>
            <td class="pageHeading"><?php echo ARTICLE_SEARCH_TITLE; ?></td>
            <td class="pageHeading" align="right"><?php echo tep_image(DIR_WS_TEMPLATES . TEMPLATE_NAME . '/images/content/browse.gif', ARTICLE_SEARCH_TITLE, HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
<?php
}else{
$header_text = HEADING_TITLE;
}
?>
<?php
// BOF: Lango Added for template MOD
if (MAIN_TABLE_BORDER == 'yes'){
table_image_border_top(false, false, $header_text);
}
// EOF: Lango Added for template MOD
?>

<!-- body_text //-->
<?php
  if ($akeywords == ""){
?>  
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
      <tr>
	    <td class="main"><?php echo ERROR_INPUT; ?></td>
	  </tr>
<?php
    } else {		 
	
  if (isset($_GET['description'])) {
    $search_query = tep_db_query("select ad.articles_name, a.articles_id, ad.articles_description from " . TABLE_ARTICLES_DESCRIPTION . " ad inner join " . TABLE_ARTICLES . " a on ad.articles_id = a.articles_id where a.articles_status = '1' and ad.language_id = '" . (int)$languages_id . "' and (ad.articles_name like '%" . $akeywords . "%' or ad.articles_description like '%" . $akeywords . "%' or ad.articles_head_desc_tag like '%" . $akeywords . "%' or ad.articles_head_keywords_tag like '%" . $akeywords . "%' or ad.articles_head_title_tag like '%" . $akeywords . "%') order by ad.articles_name ASC");
  }  else {
    $search_query = tep_db_query("select ad.articles_name, a.articles_id, ad.articles_description from " . TABLE_ARTICLES_DESCRIPTION . " ad inner join " . TABLE_ARTICLES . " a on ad.articles_id = a.articles_id where a.articles_status='1' and ad.language_id = '" . (int)$languages_id . "' and (ad.articles_name like '%" . $akeywords . "%' or ad.articles_head_desc_tag like '%" . $akeywords . "%' or ad.articles_head_keywords_tag like '%" . $akeywords . "%' or ad.articles_head_title_tag like '%" . $akeywords . "%') order by ad.articles_name ASC");
  }    
    $count=0;
?>

<tr>
	                <td valign="middle" align="center" class="productListing-heading"><?php echo TEXT_ARTICLE_NAME; ?></td>
	                <td valign="middle" align="center" class="productListing-heading"><?php echo TEXT_ARTICLE_EXCERPT; ?></td>
	                <td valign="middle" align="center" class="productListing-heading"><?php echo TEXT_ARTICLE_LINK; ?></td>
</tr>
      <tr>
        <td colspan="3"><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>


<?php		
  while($results = tep_db_fetch_array($search_query)){
$article_ex = utf8_substr(strip_tags($results['articles_description']), 0, 777);
?>
 <tr>
	                 <td valign="top" align="left" valign="top" width="20%" class="linkListing-data"><a href="<?php echo FILENAME_ARTICLE_INFO; ?>?articles_id=<?php echo $results['articles_id'] ?>"><?php echo $results['articles_name'] ?></a><br></td>
	                 <td valign="top" align="left" valign="top" class="linkListing-data"><?php echo $article_ex; ?> ...<br></td>
	                 <td valign="middle" align="center" valign="top" width="115px" class="main"><a href="<?php echo FILENAME_ARTICLE_INFO; ?>?articles_id=<?php echo $results['articles_id'] ?>"><?php echo ICON_ARROW_RIGHT; ?></a><br></td>
</tr>

		  
<?php
    $count++;
	} 
	if ($count == 0){
?>	

      <tr>
        <td colspan="3"><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
	<tr>
	<td class="main" colspan="3" align="center"><?php echo TEXT_NO_ARTICLES ?></td>
	</tr>
<?php	
	}  
?>
        </td>
	      </tr>
      <tr>
        <td class="main"></td>
      </tr>
<?php
  }
?>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
<?php
// BOF: Lango Added for template MOD
if (MAIN_TABLE_BORDER == 'yes'){
table_image_border_bottom();
}
// EOF: Lango Added for template MOD
?>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBox">
          <tr class="infoBoxContents">
            <td><table class="table-padding-2">
              <tr>
                <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
                <td><?php echo '<a href="' . tep_href_link(FILENAME_ACCOUNT, '', 'SSL') . '">' . tep_template_image_button('button_back.gif', IMAGE_BUTTON_BACK) . '</a>'; ?></td>
                <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
              </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>
    </table>
