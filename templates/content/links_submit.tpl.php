<?php echo tep_draw_form('submit_link', tep_href_link(FILENAME_LINKS_SUBMIT, '', 'SSL'), 'post', 'onSubmit="return check_form(submit_link);"') . tep_draw_hidden_field('action', 'process'); ?><table border="0" width="100%" cellspacing="0" cellpadding="<?php echo CELLPADDING_SUB; ?>">
<?php
// BOF: Lango Added for template MOD
if (SHOW_HEADING_TITLE_ORIGINAL == 'yes') {
$header_text = '&nbsp;'
//EOF: Lango Added for template MOD
?>
      <tr>
        <td><table class="table-padding-0">
          <tr>
            <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
            <td class="pageHeading" align="right"><?php echo tep_image(DIR_WS_TEMPLATES . TEMPLATE_NAME . '/images/content/account.gif', HEADING_TITLE, HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?></td>
          </tr>
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
        <td class="smallText"><br><?php echo TEXT_MAIN; ?></td>
      </tr>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
<?php
  if ($messageStack->size('submit_link') > 0) {
?>
      <tr>
        <td><?php echo $messageStack->output('submit_link'); ?></td>
      </tr>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
<?php
  }
?>
      <tr>
        <td><table class="table-padding-2">
          <tr>
            <td class="main"><b><?php echo CATEGORY_WEBSITE; ?></b></td>
           <td class="inputRequirement" align="right"><?php echo FORM_REQUIRED_INFORMATION; ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBox">
          <tr class="infoBoxContents">
            <td><table border="0" width="60%" cellspacing="2" cellpadding="2">
              <tr>
                <td class="main" width="25%"><?php echo ENTRY_LINKS_TITLE; ?></td>
                <td class="main"><?php echo tep_draw_input_field('links_title') . '&nbsp;' . (tep_not_null(ENTRY_LINKS_TITLE_TEXT) ? '<span class="inputRequirement">' . ENTRY_LINKS_TITLE_TEXT . '</span>': ''); ?></td>
              </tr>
              <tr>
                <td class="main"><?php echo ENTRY_LINKS_URL; ?></td>
                <td class="main"><?php echo tep_draw_input_field('links_url', 'http://') . '&nbsp;' . (tep_not_null(ENTRY_LINKS_URL_TEXT) ? '<span class="inputRequirement">' . ENTRY_LINKS_URL_TEXT . '</span>': ''); ?></td>
              </tr>
<?php
  //link category drop-down list
  $categories_array = array();
  $categories_query = tep_db_query("select lcd.link_categories_id, lcd.link_categories_name from " . TABLE_LINK_CATEGORIES_DESCRIPTION . " lcd where lcd.language_id = '" . (int)$languages_id . "'order by lcd.link_categories_name");
  while ($categories_values = tep_db_fetch_array($categories_query)) {
    $categories_array[] = array('id' => $categories_values['link_categories_name'], 'text' => $categories_values['link_categories_name']);
  }

  if (isset($_GET['lPath'])) {
    $current_categories_id = $_GET['lPath'];

    $current_categories_query = tep_db_query("select link_categories_name from " . TABLE_LINK_CATEGORIES_DESCRIPTION . " where link_categories_id ='" . (int)$current_categories_id . "' and language_id ='" . (int)$languages_id . "'");
    if ($categories = tep_db_fetch_array($current_categories_query)) {
      $default_category = $categories['link_categories_name'];
    } else {
      $default_category = '';
    }
  }
?>
              <tr>
                <td class="main"><?php echo ENTRY_LINKS_CATEGORY; ?></td>
                <td class="main">
<?php
    echo tep_draw_pull_down_menu('links_category', $categories_array, $default_category);

    if (tep_not_null(ENTRY_LINKS_CATEGORY_TEXT)) echo '&nbsp;<span class="inputRequirement">' . ENTRY_LINKS_CATEGORY_TEXT;
?>
                </td>
              </tr>
              <tr>
                <td class="main" valign="top"><?php echo ENTRY_LINKS_DESCRIPTION; ?></td>
                <td class="main"><?php echo tep_draw_textarea_field('links_description', 'hard', 20, 5) . '&nbsp;' . (tep_not_null(ENTRY_LINKS_DESCRIPTION_TEXT) ? '<span class="inputRequirement">' . ENTRY_LINKS_DESCRIPTION_TEXT . '</span>': ''); ?></td>
              </tr>
              <tr>
                <td class="main"><?php echo ENTRY_LINKS_IMAGE; ?></td>
                <td class="main"><?php echo tep_draw_input_field('links_image', 'http://') . '&nbsp;' . (tep_not_null(ENTRY_LINKS_IMAGE_TEXT) ? '<span class="inputRequirement">' . ENTRY_LINKS_IMAGE_TEXT . '</span>': ''); ?><?php echo '<a href="javascript:popupWindow(\'' . tep_href_link(FILENAME_POPUP_LINKS_HELP) . '\')">' . TEXT_LINKS_HELP_LINK . '</a>'; ?></td>
              </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
      <tr>
        <td class="main"><b><?php echo CATEGORY_CONTACT; ?></b></td>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBox">
          <tr class="infoBoxContents">
            <td><table width="60%" border="0" cellspacing="2" cellpadding="2">
              <tr>
                <td class="main" width="25%"><?php echo ENTRY_LINKS_CONTACT_NAME; ?></td>
                <td class="main"><?php echo tep_draw_input_field('links_contact_name') . '&nbsp;' . (tep_not_null(ENTRY_LINKS_CONTACT_NAME_TEXT) ? '<span class="inputRequirement">' . ENTRY_LINKS_CONTACT_NAME_TEXT . '</span>': ''); ?></td>
              </tr>
              <tr>
                <td class="main"><?php echo ENTRY_EMAIL_ADDRESS; ?></td>
                <td class="main"><?php echo tep_draw_input_field('links_contact_email') . '&nbsp;' . (tep_not_null(ENTRY_EMAIL_ADDRESS_TEXT) ? '<span class="inputRequirement">' . ENTRY_EMAIL_ADDRESS_TEXT . '</span>': ''); ?></td>
              </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
      <tr>
        <td class="main"><b><?php echo CATEGORY_RECIPROCAL; ?></b></td>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBox">
          <tr class="infoBoxContents">
            <td><table width="60%" border="0" cellspacing="2" cellpadding="2">
              <tr>
                <td class="main" width="25%"><?php echo ENTRY_LINKS_RECIPROCAL_URL; ?></td>
                <td class="main"><?php echo tep_draw_input_field('links_reciprocal_url', 'http://') . '&nbsp;' . (tep_not_null(ENTRY_LINKS_RECIPROCAL_URL_TEXT) ? '<span class="inputRequirement">' . ENTRY_LINKS_RECIPROCAL_URL_TEXT . '</span>': ''); ?><?php echo '<a href="javascript:popupWindow(\'' . tep_href_link(FILENAME_POPUP_LINKS_HELP) . '\')">' . TEXT_LINKS_HELP_LINK . '</a>'; ?></td>
              </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
          <tr>
            <td><table width="100%" border="0" cellspacing="2" cellpadding="2">
              <tr>
                <td class="main" colspan="2"><?php echo '<img src="'.tep_href_link(FILENAME_DISPLAY_CAPTCHA).'" alt="captcha" />'; ?></td>
              </tr>
              <tr>
                <td class="main" width="25%"><?php echo ENTRY_CAPTCHA; ?></td>
                <td class="main"><?php echo tep_draw_input_field('captcha', '', 'size="6"', 'text', false); ?></td>
              </tr>
            </table></td>
          </tr>      
      <tr>
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
        <td><table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBox">
          <tr class="infoBoxContents">
            <td><table class="table-padding-2">
              <tr>
                <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
                <td align="right"><?php echo tep_template_image_submit('button_continue.gif', IMAGE_BUTTON_CONTINUE); ?></td>
                <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
              </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>
    </table></form>