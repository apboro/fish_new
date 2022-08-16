<?php
/*
  $Id: products_tabs.php, v1.0 20090909 kymation Exp $
  $Loc: catalog/includes/modules/ $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2009 osCommerce

  Released under the GNU General Public License
*/


?>
<!-- ask_a_question //-->
                  <div id="ASK" class="content<?php echo $selected_tab == 'ASK' ? ' active' : ''; ?>">
                    <div class="inside_heading"><?php echo sprintf (TEXT_TAB_ASK_A_QUESTION_HEAD, $product_info['products_name']); ?> <span class="smalltext">[<?php echo $product_info['products_model']; ?>]<span></div>
                      <?php echo tep_draw_form ('ask_a_question', tep_href_link (FILENAME_PRODUCT_INFO, tep_get_all_get_params (array ('action') ) . 'action=process&products_id=' . $_GET['products_id']) ); ?>
                      <table cellpadding="0" cellspacing="0" width="100%" style="BORDER:none;background:none;">
<?php
  if ($messageStack->size('ask') > 0) {
?>
                        <tr>
                          <td><?php echo tep_draw_separator ('pixel_trans.gif', '100%', '10'); ?></td>
                       </tr>
                        <tr>
                          <td><?php echo $messageStack->output ('ask'); ?></td>
                        </tr>
<?php
  }
?>
                        <tr>
                          <td><?php echo tep_draw_separator ('pixel_trans.gif', '100%', '10'); ?></td>
                        </tr>
                        <tr>
                          <td><table class="infoBox table-padding-2">
                            <tr class="infoBoxContents">
                              <td><table class="table-padding-2">
                                <tr>
                                  <td class="main"><b><?php echo FORM_TITLE_CUSTOMER_DETAILS; ?></b></td>
                                  <td class="inputRequirement" align="right"><?php echo FORM_REQUIRED_INFORMATION; ?></td>
                                </tr>
                              </table></td>
                            </tr>
                            <tr class="infoBoxContents">
                              <td><table border="0" cellspacing="0" cellpadding="2">
                                <tr>
                                  <td class="main"><?php echo FORM_FIELD_CUSTOMER_NAME; ?></td>
                                  <td class="main"><?php echo tep_draw_input_field ('from_name'); ?></td>
                                </tr>
                                <tr>
                                  <td class="main"><?php echo FORM_FIELD_CUSTOMER_EMAIL; ?></td>
                                  <td class="main"><?php echo tep_draw_input_field ('from_email_address'); ?></td>
                                </tr>
                              </table></td>
                            </tr>
                            <tr class="infoBoxContents">
                              <td><?php echo tep_draw_separator ('pixel_trans.gif', '100%', '10'); ?></td>
                            </tr>
                            <tr class="infoBoxContents">
                              <td class="main"><b><?php echo FORM_FIELD_MESSAGE; ?></b></td>
                            </tr>
                            <tr class="infoBoxContents">
                              <td><table border="0" width="100%" cellspacing="1" cellpadding="2">
                                <tr>
                                  <td><?php echo tep_draw_textarea_field ('message', 'soft', 40, 8); ?></td>
                                </tr>
                              </table></td>
                            </tr>
                          </table></td>
                        </tr>
                        <tr>
                          <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
                        </tr>
                        <tr>
                          <td><table class="table-padding-2">
                            <tr>
                              <td width="10"><?php echo tep_draw_separator ('pixel_trans.gif', '10', '1'); ?></td>
                              <td align="right"><?php echo tep_image_submit ('button_continue.gif', IMAGE_BUTTON_CONTINUE); ?></td>
                              <td width="10"><?php echo tep_draw_separator ('pixel_trans.gif', '10', '1'); ?></td>
                            </tr>
                          </table></td>
                        </tr>
                      </table></form>
                    </div>
<!-- ask_a_question_EOF //-->
        
