<?php

/*
  $Id: mm_email.php http://www.css-oscommerce.com
  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com
  Copyright (c) 2003 osCommerce
  Released under the GNU General Public License
*/

  require('includes/application_top.php');
  $search = (isset($HTTP_GET_VARS['search_customers']) ? $HTTP_GET_VARS['search_customers'] : '');
  $action = (isset($HTTP_GET_VARS['action']) ? $HTTP_GET_VARS['action'] : '');

  if ( ($action == 'send_email_to_user') && isset($HTTP_POST_VARS['customers_email_address']) && !isset($HTTP_POST_VARS['back_x']) ) {
       
    $mail_query = tep_db_query("select customers_firstname, customers_lastname, customers_email_address from " . TABLE_CUSTOMERS . " where customers_email_address = '".$HTTP_POST_VARS['customers_email_address']."'");
    $mail = tep_db_fetch_array($mail_query);    

    $template_name = tep_db_prepare_input($HTTP_POST_VARS['template']);
    $template_query = tep_db_query("select title, htmlheader, htmlfooter, txtheader, txtfooter from " . TABLE_MM_TEMPLATES . " where title = '" . $template_name . "'");
    $template = tep_db_fetch_array($template_query);
    
    $from = tep_db_prepare_input($HTTP_POST_VARS['from']);
    $output_subject = tep_db_prepare_input($HTTP_POST_VARS['subject']);
    $output_content_html = $template['htmlheader'].tep_db_prepare_input($HTTP_POST_VARS['message'].$template['htmlfooter']);
    $output_content_txt = $template['txtheader'].tep_db_prepare_input($HTTP_POST_VARS['message'].$template['txtfooter']);

    tep_mm_sendmail($mail['customers_firstname'] . ' ' . $mail['customers_lastname'], $mail['customers_email_address'], STORE_OWNER, $from, $output_subject, $output_content_html, $output_content_txt);	

    tep_redirect(tep_href_link(FILENAME_MM_EMAIL, 'mail_sent_to=' . urlencode($mail_sent_to)));

  }

  if ( ($action == 'preview') && !isset($HTTP_POST_VARS['customers_email_address']) ) {
    $messageStack->add(ERROR_NO_CUSTOMER_SELECTED, 'error');
  }

  if (isset($HTTP_GET_VARS['mail_sent_to'])) {
    $messageStack->add(sprintf(NOTICE_EMAIL_SENT_TO, $HTTP_GET_VARS['mail_sent_to']), 'success');
  }

?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<title><?php echo TITLE; ?></title>
<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
<script language="javascript" src="includes/general.js"></script>
</head>
<body marginwidth="0" marginheight="0" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0" bgcolor="#FFFFFF">
<div id="spiffycalendar" class="text"></div>
<!-- header //-->
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
<!-- header_eof //-->

<!-- body //-->

<table border="0" width="100%" cellspacing="2" cellpadding="2">
  <tr>
    <td width="<?php echo BOX_WIDTH; ?>" valign="top"><table border="0" width="<?php echo BOX_WIDTH; ?>" cellspacing="1" cellpadding="1" class="columnLeft">
<!-- left_navigation //-->
<?php require(DIR_WS_INCLUDES . 'column_left.php'); ?>
<!-- left_navigation_eof //-->
    </table></td>
<!-- body_text //-->
    <td width="100%" valign="top">

<table class="table-padding-0">
      <tr>
        <td width="100%"><table class="table-padding-0">
          <tr>
            <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
            <td class="pageHeading" align="right"><?php echo tep_draw_separator('pixel_trans.gif', HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?></td>
          </tr>
        </table></td>
      </tr>
      <tr><td>
<table  cellspacing="5" cellpadding="2">
<tr>
	<td  valign="top" class="main"><?php echo TEXT_SEARCH; ?>	
	<form name="search_customers" action="mm_email.php?action=process" method="get">
		<table>
			<tr><td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td></tr>
			<tr>
				<td class="main">email:</td><td><?php echo tep_draw_input_field('search_email');?></td></tr>
			<tr><td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td></tr>
			<tr>
			    <td class="main">last name:</td><td><?php echo tep_draw_input_field('search_lastname'); ?></td></tr>
			<tr><td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td></tr>
			<tr>
			    <td class="main">phone:</td><td><?php echo tep_draw_input_field('search_phone'); ?></td></tr>			
			<tr><td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td></tr>
			<tr>
			    <td class="main"></td><td><?php echo tep_image_submit('button_search.gif', IMAGE_BUTTON_SEARCH).tep_hide_session_id();?></form></td></tr>
		</table>
	</td>
    <td bgcolor="#F2F2F2">
<?php
		    if ($HTTP_GET_VARS['search_email']) {
		    	$search_email = tep_db_prepare_input($HTTP_GET_VARS['search_email']);
		    	$where_clause = "customers_email_address RLIKE '".tep_db_input($search_email)."'";
		    
		    }

		    if ($HTTP_GET_VARS['search_phone']) {
		    	$search_phone = tep_db_prepare_input($HTTP_GET_VARS['search_phone']);
		    	$where_clause .= ($where_clause ? ' or ' : '')."customers_telephone RLIKE '".tep_db_input($search_phone)."'";
		    }


		    if ($HTTP_GET_VARS['search_lastname']) {
		    	$search_lastname = tep_db_prepare_input($HTTP_GET_VARS['search_lastname']);
		    	$where_clause .= ($where_clause ? ' or ' : '')." customers_lastname RLIKE '".tep_db_input($search_lastname)."'";
		    }
		 
		    if ($where_clause) {
		    	$search_sql = "select * from ".TABLE_CUSTOMERS." where ".$where_clause;
		    	$search_query = tep_db_query($search_sql);

		    	if (tep_db_num_rows($search_query)) {
                    ?>
						<table width="100%" >
						<tr>
							<td colspan="3" class="main"><?php echo TEXT_CLICKCUS; ?></td>
						</tr>
						<tr><td colspan="3" height="1" bgcolor="000000"></td></tr>
						<?php
			    while ($search_result = tep_db_fetch_array($search_query)) {		          
			    	echo '<tr>
			    	<td class="smallText"><a href="mm_email.php?'.$search_result['customers_email_address'].'">'.$search_result['customers_email_address'].'</a></td>
			    	<td class="smallText">'.$search_result['customers_firstname'].' '.$search_result['customers_lastname'].'</td>
			    	<td class="smallText">'.$search_result['customers_telephone'].'</td>
			    	</tr><tr><td colspan="3" height="1" bgcolor="666666"></td></tr>';	
			         }
			         echo '</table>';			    			
			         	} else {
						  echo '<table><tr><td class="main">No customers matching search were located in the database.</td></tr></table>';
			          		}
		            }
?>
</td></tr>
<tr bgcolor="#000000"><td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '1'); ?></td></tr>
</table></td></tr>
      <tr>
        <td><table class="table-padding-2">
<?php
  if ( ($action == 'preview') && isset($HTTP_POST_VARS['customers_email_address']) ) {
    
        $mail_sent_to = $HTTP_POST_VARS['customers_email_address'];

?>
          <tr><?php echo tep_draw_form('mail', FILENAME_MM_EMAIL, 'action=send_email_to_user'); ?>
            <td><table border="0" width="100%" cellpadding="0" cellspacing="2">
              <tr><td><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td></tr>
              <tr>
                <td class="smallText"><b><?php echo TEXT_TEMPLATE; ?></b><br><?php echo htmlspecialchars(stripslashes($HTTP_POST_VARS['template'])); ?></td>
              </tr>
              <tr><td><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td></tr>
              <tr>
                <td class="smallText"><b><?php echo TEXT_CUSTOMER; ?></b><br><?php echo $mail_sent_to; ?></td>
              </tr>
              <tr><td><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td></tr>
              <tr>
                <td class="smallText"><b><?php echo TEXT_FROM; ?></b><br><?php echo htmlspecialchars(stripslashes($HTTP_POST_VARS['from'])); ?></td>
              </tr>
              <tr><td><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td></tr>
              <tr>
                <td class="smallText"><b><?php echo TEXT_SUBJECT; ?></b><br><?php echo htmlspecialchars(stripslashes($HTTP_POST_VARS['subject'])); ?></td>
              </tr>
              <tr><td><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td></tr>
              <tr>
                <td class="smallText"><b><?php echo TEXT_MESSAGE; ?></b><br><?php echo nl2br(htmlspecialchars(stripslashes($HTTP_POST_VARS['message']))); ?></td>
              </tr>
              <tr><td><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td></tr>
              <tr>
                <td>
<?php
/* Re-Post all POST'ed variables */
    reset($HTTP_POST_VARS);
    while (list($key, $value) = each($HTTP_POST_VARS)) {
      if (!is_array($HTTP_POST_VARS[$key])) {
        echo tep_draw_hidden_field($key, htmlspecialchars(stripslashes($value)));
      }
    }

?>
                <table border="0" width="100%" cellpadding="0" cellspacing="2">
                  <tr>
                    <td><?php echo tep_image_submit('button_back.gif', IMAGE_BACK, 'name="back"'); ?></td>
                    <td align="right"><?php echo '<a href="' . tep_href_link(FILENAME_MM_EMAIL) . '">' . tep_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a> ' . tep_image_submit('button_send_mail.gif', IMAGE_SEND_EMAIL); ?></td>
                  </tr>
                </table></td>
              </tr>
            </table></td>
          </form></tr>
<?php
  } else {
?>
          <tr><?php echo tep_draw_form('mail', FILENAME_MM_EMAIL, 'action=preview'); ?>
            <td><table border="0" cellpadding="0" cellspacing="2" width="100%">
              <tr>
                <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
              </tr>
              
              <?php
          				 
          				//attach template          	 			
  						$template_array = array();
  					//	$template_array[0]= array('id'=>$template_title, 'text'=>$template_title);
  						$template_query = tep_db_query("select template_id, title from " . TABLE_MM_TEMPLATES . " ");
  						while ($template_values = tep_db_fetch_array($template_query)) {
    					$template_array[] = array('id' => $template_values['title'], 
    											  'text' => $template_values['title']);
    								}
    				   ?>    	
				
				<tr><td class="main" valign="top" align="left">
						<p><?php echo TEXT_TEMPLATE; ?></p></td>
						<td><?php echo tep_draw_pull_down_menu('template', $template_array, '', true); ?>
					  </td>						
          		</tr>
          		<tr><td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '20', '20'); ?></td></tr>
              
              
              <tr>
                <td class="main"><?php echo TEXT_CUSTOMER.$search_result['customers_email_address']; ?></td>
                 <?php 
                 $mail_query = tep_db_query("select customers_firstname, customers_lastname, customers_email_address from " . TABLE_CUSTOMERS . " where customers_email_address = '".$_SERVER['QUERY_STRING']."'");
    			 $mail = tep_db_fetch_array($mail_query); 
    			 if ($mail['customers_email_address']==$_SERVER['QUERY_STRING'])  
                 $email_login =  $_SERVER['QUERY_STRING'];
  
                 ?>
                <td><?php echo tep_draw_input_field('customers_email_address',$email_login,''); ?></td>
              </tr>
              <tr><td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td> </tr>
              <tr >
                <td class="main"><?php echo TEXT_FROM; ?></td>
                <td ><?php echo tep_draw_input_field('from', STORE_OWNER_EMAIL_ADDRESS); ?></td>
              </tr>
              <tr><td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td></tr>
              <tr>
                <td class="main"><?php echo TEXT_SUBJECT; ?></td
                <td><?php echo tep_draw_input_field('subject'); ?></td>
              </tr>
              <tr><td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td></tr>
              <tr>
                <td valign="top" class="main"><?php echo TEXT_MESSAGE; ?></td>
                <td><?php echo tep_draw_textarea_field('message', 'soft', '80', '15'); ?></td>
              </tr>
              <tr><td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td></tr>
              
              <tr>
                <td colspan="2" align="right"><?php echo tep_image_submit('button_send_mail.gif', IMAGE_SEND_EMAIL); ?></td>
              </tr>
            </table>
          </form>
<?php
  }
?>
    </table></td>
<!-- body_text_eof //-->
  </tr>
</table>
<!-- body_eof //-->

<!-- footer //-->
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<!-- footer_eof //-->
<br>
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>