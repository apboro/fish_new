    <table border="0" width="100%" cellspacing="0" cellpadding="<?php echo CELLPADDING_SUB; ?>">
<?php
// BOF: Lango Added for template MOD
if (SHOW_HEADING_TITLE_ORIGINAL == 'yes') {
$header_text = '&nbsp;'
//EOF: Lango Added for template MOD
?>
 <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.0.0/animate.min.css"
  />


      <tr>
        <td><table class="table-padding-0">
              <tr>
                <td class="animate__animated animate__lightSpeedInLeft"><?php echo $page_info['pages_name']; ?></td>
				    <td align="right">
<?php
if ($page_info['pages_image'] != '') {
echo tep_image(DIR_WS_IMAGES . $page_info['pages_image'], addslashes($page_info['pages_name']), SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT);
}
else
{
echo "&nbsp;";
};
?>
</td>
              </tr>
        </table></td>
      </tr>
<?php
// BOF: Lango Added for template MOD
}else{
$header_text = $page_info['pages_name'];
}
// EOF: Lango Added for template MOD
?>
      <tr>
        <td><table class="table-padding-2">
<?php
if (MAIN_TABLE_BORDER == 'yes'){
table_image_border_top(false, false, $header_text);
}
?>
<!-- body_text //-->
        <?php
  $page_info_query = tep_db_query("select p.pages_id, pd.pages_name, pd.pages_description, p.pages_image, p.pages_date_added from " . TABLE_PAGES . " p, " . TABLE_PAGES_DESCRIPTION . " pd where p.pages_status = '1' and p.pages_id = '" . (int)$_GET['pages_id'] . "' and pd.pages_id = p.pages_id and pd.language_id = '" . $languages_id . "'");

  if (!tep_db_num_rows($page_info_query)) { // page not found in database
?>
        <tr>
          <td colspan="2" class="main">
          <br>
            <?php echo TEXT_PAGE_NOT_FOUND; ?>
          <br>
          <br>
            </td>
        </tr>
<?php  } else {
    tep_db_query("update " . TABLE_PAGES_DESCRIPTION . " set pages_viewed = pages_viewed+1 where pages_id = '" . (int)$_GET['pages_id'] . "' and language_id = '" . $languages_id . "'");
    $page_info = tep_db_fetch_array($page_info_query);

?>
        <tr>
          <td colspan="2" class="main">
          <?php echo stripslashes($page_info['pages_description']); ?>
        </td>
        <tr>
          <td colspan="2" align="center" class="smallText"><br>
            <?php echo sprintf(TEXT_DATE_ADDED, tep_date_long($page_info['pages_date_added'])); ?></td>
        </tr>
        <tr>
          <td colspan="2"><br></td></tr>
            <?php
    if ( (USE_CACHE == 'true') && !defined('SID')) {
      echo tep_cache_also_purchased(3600);
    }
  }
?>
<!-- body_text_eof //-->
<?php
// BOF: Lango Added for template MOD
if (MAIN_TABLE_BORDER == 'yes'){
table_image_border_bottom();
}
// EOF: Lango Added for template MOD
?>
        </table></td>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBox">
          <tr class="infoBoxContents">
            <td><table class="table-padding-2">
              <tr>
                <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
                <td align="right"><?php echo '<a href="' . tep_href_link(FILENAME_DEFAULT) . '">' . tep_template_image_button('button_continue.gif', IMAGE_BUTTON_CONTINUE) . '</a>'; ?></td>
                <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
              </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>
    </table>
