<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2013 osCommerce

  Released under the GNU General Public License
*/

  require('includes/application_top.php');

// redirect the customer to a friendly cookie-must-be-enabled page if cookies are disabled (or the session has not started)
	if ($session_started == false) {
		if ( !isset($HTTP_GET_VARS['cookie_test']) ) {
			$all_get = tep_get_all_get_params();
			tep_redirect(tep_href_link(FILENAME_LOGIN, $all_get . (empty($all_get) ? '' : '&') . 'cookie_test=1', 'SSL'));
		}
		tep_redirect(tep_href_link(FILENAME_COOKIE_USAGE));
	}else{
	  if (tep_session_is_registered('customer_id')){tep_redirect(tep_href_link(FILENAME_LOGOFF));}
	}

  require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_LOGIN);
  $error = false;
  if (isset($HTTP_GET_VARS['action']) && ($HTTP_GET_VARS['action'] == 'process') && isset($HTTP_POST_VARS['formid']) && ($HTTP_POST_VARS['formid'] == $sessiontoken)) 
  {
    $email_address = tep_db_prepare_input($HTTP_POST_VARS['email_address']);
    $password = tep_db_prepare_input($HTTP_POST_VARS['password']);

// Check if email exists
    $check_customer_query = tep_db_query("select customers_id, customers_firstname, customers_password, customers_email_address, customers_default_address_id from " . TABLE_CUSTOMERS . " where customers_email_address = '" . tep_db_input($email_address) . "'");
    if (!tep_db_num_rows($check_customer_query)) {
      $error = true;
    } else {
      $check_customer = tep_db_fetch_array($check_customer_query);
    }
}
// Check that password is good
/* iHolder single sign one*/
    $user_auth=false;
    if (isset($_GET['uid'])){
    $check_customer_query=tep_db_query('select customers_id, customers_firstname, customers_password, customers_groups_id, customers_email_address, customers_default_address_id, customers_status from ' . TABLE_CUSTOMERS .
    ' where customers_status = 1 and customers_uuid="'.tep_db_input($_GET['uid']).'"');
	if ($check_customer_query!==false){
	$user_auth=(tep_db_num_rows($check_customer_query)>0);
	}
    }
    if (!$user_auth){
    //TotalB2B start
    $check_customer_query = tep_db_query("select customers_id, customers_firstname, customers_password, customers_groups_id, customers_email_address, customers_default_address_id, customers_status from " . TABLE_CUSTOMERS . " where customers_status = '1' and customers_email_address = '" . tep_db_input($email_address) . "'");
    }
    if (!tep_db_num_rows($check_customer_query)) {
      $error = true;
    } else {
      $check_customer = tep_db_fetch_array($check_customer_query);
    //TotalB2B end
// Check that password is good
      if ($user_auth){
	$password='123';
        $check_customer['customers_password']=tep_encrypt_password($password);
        }
    }

/* iHolder single sign one*/






      if (!tep_validate_password($password, $check_customer['customers_password'])) {
        $error = true;
      } else {
        if (SESSION_RECREATE == 'True') {
          tep_session_recreate();
        }

// migrate old hashed password to new phpass password
        if (tep_password_type($check_customer['customers_password']) != 'phpass') {
          tep_db_query("update " . TABLE_CUSTOMERS . " set customers_password = '" . tep_encrypt_password($password) . "' where customers_id = '" . (int)$check_customer['customers_id'] . "'");
        }

        $check_country_query = tep_db_query("select entry_country_id, entry_zone_id from " . TABLE_ADDRESS_BOOK . " where customers_id = '" . (int)$check_customer['customers_id'] . "' and address_book_id = '" . (int)$check_customer['customers_default_address_id'] . "'");
        $check_country = tep_db_fetch_array($check_country_query);

        $customer_id = $check_customer['customers_id'];
        $customer_default_address_id = $check_customer['customers_default_address_id'];
        $customer_first_name = $check_customer['customers_firstname'];
        $customer_country_id = $check_country['entry_country_id'];
        $customer_zone_id = $check_country['entry_zone_id'];
        tep_session_register('customer_id');
        tep_session_register('customer_default_address_id');
        tep_session_register('customer_first_name');
        tep_session_register('customer_country_id');
        tep_session_register('customer_zone_id');

        tep_db_query("update " . TABLE_CUSTOMERS_INFO . " set customers_info_date_of_last_logon = now(), customers_info_number_of_logons = customers_info_number_of_logons+1, password_reset_key = null, password_reset_date = null where customers_info_id = '" . (int)$customer_id . "'");

// reset session token
        $sessiontoken = md5(tep_rand() . tep_rand() . tep_rand() . tep_rand());

// restore cart contents
        $cart->restore_contents();


  if ($user_auth&&isset($_GET['r'])){
    //---1 - redirect to checkout fast
        switch ((int)$_GET['r']){
                case 1 : tep_redirect(tep_href_link(FILENAME_CHECKOUT));break;
                    }
        }
                            

        if (sizeof($navigation->snapshot) > 0) {
          $origin_href = tep_href_link($navigation->snapshot['page'], tep_array_to_string($navigation->snapshot['get'], array(tep_session_name())), $navigation->snapshot['mode']);
          $navigation->clear_snapshot();
          tep_redirect($origin_href);
        } else {
          tep_redirect(tep_href_link(FILENAME_DEFAULT));
        }
      }
/*    }
  }*/

if (isset($HTTP_GET_VARS['action']) && ($HTTP_GET_VARS['action'] == 'process') &&$error)
{ 
//  if ($error == true) {
    $messageStack->add('login', TEXT_LOGIN_ERROR);
//  }
}
  $breadcrumb->add(NAVBAR_TITLE, tep_href_link(FILENAME_LOGIN, '', 'SSL'));

  require(DIR_WS_INCLUDES . 'template_top.php');
?>

<!--<h1><?php //echo HEADING_TITLE; ?></h1>-->

<?php
  if ($messageStack->size('login') > 0) {
    echo $messageStack->output('login');
  }
?>

<div class="contentContainer mj-signupcontainer">
	<div class="content">
      <h3><?php echo HEADING_NEW_CUSTOMER; ?></h3>
    
      <div class="contentText">
        <p><?php echo TEXT_NEW_CUSTOMER; ?></p>
        <p><?php echo TEXT_NEW_CUSTOMER_INTRODUCTION; ?></p>
    
        <p align="right" class="button"><?php echo tep_draw_button(IMAGE_BUTTON_CONTINUE, 'triangle-1-e', tep_href_link(FILENAME_CREATE_ACCOUNT, '', 'SSL')); ?></p>
      </div>
	
    </div>
</div>

<div class="contentContainer mj-logincontainer">
	<div class="content">
      <h3><?php echo HEADING_RETURNING_CUSTOMER; ?></h3>
    
      <div class="contentText">
        <p><?php echo TEXT_RETURNING_CUSTOMER; ?></p>
    
        <?php echo tep_draw_form('login', tep_href_link(FILENAME_LOGIN, 'action=process', 'SSL'), 'post', '', true); ?>
    
        <table border="0" cellspacing="0" cellpadding="2" width="100%">
          <tr>
            <td class="fieldKey"><?php echo ENTRY_EMAIL_ADDRESS; ?></td>
            <td class="fieldValue"><?php echo tep_draw_input_field('email_address'); ?></td>
          </tr>
          <tr>
            <td class="fieldKey"><?php echo ENTRY_PASSWORD; ?></td>
            <td class="fieldValue"><?php echo tep_draw_password_field('password'); ?></td>
          </tr>
        </table>
    
    	<div class="mj-loginarea">
    		<div class="mj-login"><?php echo tep_draw_button(IMAGE_BUTTON_LOGIN, 'key', null, 'primary'); ?></div>
			<div class="mj-forgotpassword"><?php echo '<a href="' . tep_href_link(FILENAME_PASSWORD_FORGOTTEN, '', 'SSL') . '">' . TEXT_PASSWORD_FORGOTTEN . '</a>'; ?>
        	</div>
		</div>
        
        </form>
      </div>
	</div>
</div>

<?php
  require(DIR_WS_INCLUDES . 'template_bottom.php');
  require(DIR_WS_INCLUDES . 'application_bottom.php');
?>
