<?php
/*
autocreated script
*/
  require('includes/application_top.php');
?>
    <?php
/*
  $Id: contact_us.php,v 1.2 2003/09/24 15:34:26 wilt Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/



  require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_CONTACT_US);

 // BOF: BugFix: Spam mailer exploit
$sanita = array("|([\r\n])[\s]+|","@Content-Type:@");
$_POST['email'] = $_POST['email'] = preg_replace( $sanita, " ", $_POST['email'] );
$_POST['name'] = $_POST['name'] = preg_replace( $sanita, " ", $_POST['name'] );
// EOF: BugFix: Spam mailer exploit

  $error = false;
  if (isset($_GET['action']) && ($_GET['action'] == 'send')) {
    $name = tep_db_prepare_input($_POST['name']);
    $email_address = tep_db_prepare_input($_POST['email']);
    $enquiry = tep_db_prepare_input($_POST['enquiry']);

    if (tep_validate_email($email_address)) {

	if (CONTACT_US_LIST !=''){
		$send_to_array=explode("," ,CONTACT_US_LIST);

//for ( $send_to = 0; $send_to < count($send_to_array); $send_to++) {

		preg_match('/\<[^>]+\>/', $send_to_array[$_POST['send_to']], $send_email_array);
		$send_to_email= preg_replace ("/>/", "", $send_email_array[0]);
		$send_to_email= preg_replace ("/</", "", $send_to_email);

  if (USE_EMAIL_QUEUE == 'true') {
		tep_store_mail(preg_replace('/\<[^*]*/', '', $send_to_array[$_POST['send_to']]), $send_to_email, EMAIL_SUBJECT, $enquiry, $name, $email_address);
  } else {
		tep_mail(preg_replace('/\<[^*]*/', '', $send_to_array[$_POST['send_to']]), $send_to_email, EMAIL_SUBJECT, $enquiry, $name, $email_address);
  }

//}

	}else{
  if (USE_EMAIL_QUEUE == 'true') {
      		tep_store_mail(STORE_OWNER, STORE_OWNER_EMAIL_ADDRESS, EMAIL_SUBJECT, $enquiry, $name, $email_address);
  } else {
      		tep_mail(STORE_OWNER, STORE_OWNER_EMAIL_ADDRESS, EMAIL_SUBJECT, $enquiry, $name, $email_address);
  }
	}


      tep_redirect(tep_href_link(FILENAME_CONTACT_US, 'action=success'));
    } else {
      $error = true;

      $messageStack->add('contact', ENTRY_EMAIL_ADDRESS_CHECK_ERROR);
    }
  }

  $enquiry = "";
  $name = "";
  $email = "";
  
  $breadcrumb->add(HEADING_TITLE, tep_href_link(FILENAME_CONTACT_US));

  $content = CONTENT_CONTACT_US;




?>

<?php
  require(DIR_WS_INCLUDES . 'template_top.php');
?>
<div class="contentContainer">
    <div class="contentText">
    <?php echo tep_draw_form('contact_us', tep_href_link(FILENAME_CONTACT_US, 'action=send')); ?><table border="0" width="100%" cellspacing="0" cellpadding="<?php echo CELLPADDING_SUB; ?>">
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
            <td class="pageHeading" align="right"><?php echo tep_image(DIR_WS_TEMPLATES . TEMPLATE_NAME . '/images/content/contact_us.gif', HEADING_TITLE, HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
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
$header_text = HEADING_TITLE;
table_image_border_top(false, false, $header_text);
}
// EOF: Lango Added for template MOD
?>
<?php
  if ($messageStack->size('contact') > 0) {
?>
      <tr>
        <td><?php echo $messageStack->output('contact'); ?></td>
      </tr>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
<?php
  }

  if (isset($_GET['action']) && ($_GET['action'] == 'success')) {
?>
      <tr>
        <td class="main" align="center"><?php echo tep_image(DIR_WS_TEMPLATES . TEMPLATE_NAME . '/images/content/man_on_board.gif', HEADING_TITLE, '0', '0', 'align="left"') . TEXT_SUCCESS; ?></td>
      </tr>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
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
<?php
// BOF: Lango Added for template MOD
if (MAIN_TABLE_BORDER == 'yes'){
table_image_border_bottom();
}
// EOF: Lango Added for template MOD
?>

<?php
  } else {
?>
      <tr>
        <td><table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBox">
          <tr class="infoBoxContents">
            <td><table class="table-padding-2">
		          <?php 
		  if (CONTACT_US_LIST !=''){
					  echo '<tr><td class="main">'. SEND_TO_TEXT. '</td></tr>'
				 		.'<tr><td class="main">';
				 if(SEND_TO_TYPE=='radio'){
				 foreach(explode("," ,CONTACT_US_LIST) as $k => $v) {
				    if($k==0){
					$checked=true;
					}else{
					$checked=false;
					}
					echo tep_draw_radio_field('send_to', "$k", $checked). " " .preg_replace('/\<[^*]*/', '', $v)."<br>\n";
				 }

			   }else{
				   foreach(explode("," ,CONTACT_US_LIST) as $k => $v) {
						$send_to_array[] = array('id' => $k, 'text' => preg_replace('/\<[^*]*/', '', $v));
					 }
        		echo tep_draw_pull_down_menu('send_to',  $send_to_array);
			   }

			echo "\n</td></tr>\n";
			
			}
			 ?>

			  <tr>
                <td class="main"><?php echo ENTRY_NAME; ?></td>
              </tr>
              <tr>
                <td class="main"><?php
                          // prefill first+last name and email address if customer is logged in
                          if (tep_session_is_registered('customer_id')) {
                          $customer_query_raw = "select customers_firstname, customers_lastname, customers_email_address from " . TABLE_CUSTOMERS . " where customers_id='" . $customer_id . "'";
                          $customer_query = tep_db_query($customer_query_raw);
                          $customer_array = tep_db_fetch_array($customer_query);
                          echo tep_draw_input_field('name', $customer_array['customers_firstname'] . " " . $customer_array['customers_lastname']);
                          echo "</td></tr><tr><td class=\"main\">" . ENTRY_EMAIL . "</td></tr><tr><td class=\"main\">";
                          echo tep_draw_input_field('email', $customer_array['customers_email_address']);
                            } else {
                          echo tep_draw_input_field('name');
                          echo "</td></tr><tr><td class=\"main\">" . ENTRY_EMAIL . "</td></tr><tr><td class=\"main\">";
                                echo tep_draw_input_field('email');
                            } ?></td>
              </tr>
              <tr>
                <td class="main"><?php echo ENTRY_ENQUIRY; ?></td>
</tr>
<tr>
<td><?php echo tep_draw_textarea_field('enquiry', 'soft', 50, 15); ?></td>
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
</table></td>
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
                <td align="right"><?php echo tep_template_image_submit('button_continue.gif', IMAGE_BUTTON_CONTINUE); ?></td>
                <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
              </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>
<?php
  }
?>
    </table></form>


</div>
</div>
<?php
  require(DIR_WS_INCLUDES . 'template_bottom.php');
  require(DIR_WS_INCLUDES . 'application_bottom.php');
?>
