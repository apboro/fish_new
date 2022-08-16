<?php
/*
  $Id: contact_us.php,v 1.2 2003/09/24 15:34:26 wilt Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/

  require('includes/application_top.php');

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

  require(DIR_WS_TEMPLATES . TEMPLATE_NAME . '/' . TEMPLATENAME_MAIN_PAGE);

  require(DIR_WS_INCLUDES . 'application_bottom.php');
?>
