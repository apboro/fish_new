<?php
/*
  $Id: login.php,v 1.2 2003/09/24 15:18:15 wilt Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2002 osCommerce

  Released under the GNU General Public License
*/

  require('includes/application_top.php');
  
  if (isset($_GET['action']) && ($_GET['action'] == 'process')) {
    $email_address = tep_db_prepare_input($_POST['email_address']);
    $password = tep_db_prepare_input($_POST['password']);

// Check if email exists
    $check_admin_query = tep_db_query("select admin_id as login_id, admin_groups_id as login_groups_id, admin_firstname as login_firstname, admin_email_address as login_email_address, admin_password as login_password, admin_modified as login_modified, admin_logdate as login_logdate, admin_lognum as login_lognum from " . TABLE_ADMIN . " where admin_email_address = '" . tep_db_input($email_address) . "'");
    if (!tep_db_num_rows($check_admin_query)) {
      $_GET['login'] = 'fail';
    } else {
      $check_admin = tep_db_fetch_array($check_admin_query);
      // Check that password is good
      if (!tep_validate_password($password, $check_admin['login_password'])) {
        $_GET['login'] = 'fail';
      } else {
        if (tep_session_is_registered('password_forgotten')) {
          tep_session_unregister('password_forgotten');
        }

        $login_id = $check_admin['login_id'];
        $_SESSION['login_id'] = $check_admin['login_id'];
        $login_groups_id = $check_admin[login_groups_id];
        $login_firstname = $check_admin['login_firstname'];
        $login_email_address = $check_admin['login_email_address'];
        $login_logdate = $check_admin['login_logdate'];
        $login_lognum = $check_admin['login_lognum'];
        $login_modified = $check_admin['login_modified'];

        tep_session_register('login_id');
        tep_session_register('login_groups_id');
        tep_session_register('login_first_name');

        //$date_now = date('Ymd');
        tep_db_query("update " . TABLE_ADMIN . " set admin_logdate = now(), admin_lognum = admin_lognum+1 where admin_id = '" . $login_id . "'");

        if (($login_lognum == 0) || !($login_logdate) || ($login_email_address == 'admin@localhost') || ($login_modified == '0000-00-00 00:00:00')) {
          tep_redirect(tep_href_link(FILENAME_ADMIN_ACCOUNT));
        } else {
          tep_redirect(tep_href_link(FILENAME_ORDERS));
        }

      }
    }
  }

  require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_LOGIN);
?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<title><?php echo TITLE; ?></title>
<style type="text/css"><!--
a { color:#000000; text-decoration:none; }
a:hover { color:#aabbdd; text-decoration:underline; }
a.text:link, a.text:visited { color: #000000; text-decoration: none; }
a:text:hover { color: #000000; text-decoration: underline; }
a.sub:link, a.sub:visited { color: #dddddd; text-decoration: none; }
A.sub:hover { color: #dddddd; text-decoration: underline; }
.sub { font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; font-weight: bold; line-height: 1.5; color: #dddddd; }
.text { font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 11px; font-weight: bold; color: #000000; }
.smallText { font-family: Verdana, Arial, sans-serif; font-size: 10px; }
.login_heading { font-family: Verdana, Arial, sans-serif; font-size: 12px; color: #ffffff;}
.login { font-family: Verdana, Arial, sans-serif; font-size: 12px; color: #000000;}
.loginfooter { font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; color: #000000; font-size: 10pt }
a:link.headerLink { font-family: Verdana, Arial, sans-serif; font-size: 10px; color: #8F020E; font-weight: bold; text-decoration: none; }
a:visited.headerLink { font-family: Verdana, Arial, sans-serif; font-size: 10px; color: #8F020E; font-weight: bold; text-decoration: none }
a:active.headerLink { font-family: Verdana, Arial, sans-serif; font-size: 10px; color: #8F020E; font-weight: bold; text-decoration: none; }
a:hover.headerLink { font-family: Verdana, Arial, sans-serif; font-size: 10px; color: #8F020E; font-weight: bold; text-decoration: underline; }

//--></style>
</head>
<body marginwidth="0" marginheight="0" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0" bgcolor="#FFFFFF">
<table border="0" width="776" height="100%" cellspacing="0" cellpadding="0" align="center" valign="middle">
  <tr>
    <td><table border="0" width="755" cellspacing="0" cellpadding="1" align="center" valign="middle">
      <tr bgcolor="#ffffff">
        <td><table border="0" width="755" cellspacing="0" cellpadding="0">
           <tr>    <td bgcolor="#ffffff">
    	<?php 
        	// #CP - point logos to come from selected template's images directory
		    $template_query = tep_db_query("select configuration_id, configuration_title, configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'DEFAULT_TEMPLATE'");
  			$template = tep_db_fetch_array($template_query);
  			$CURR_TEMPLATE = $template['configuration_value'] . '/';
            
        	echo tep_image(DIR_WS_TEMPLATES . $CURR_TEMPLATE . DIR_WS_IMAGES . 'oscommerce.gif'); 
        ?>
    </td>
    </tr>

<tr>
<td>

<table border="0" cellpadding="0" cellspacing="0" width="100%">
<tr><td bgcolor="black" height="1" colspan="2"></td></tr>
<tr class="headerNavigation" height="25">
    <td  height="25" background="images/back.gif" class="headerBarContent" align="right" valign="middle">&nbsp;</td>
</tr>
<tr><td bgcolor="black" height="1" colspan="2"></td></tr>
</table>

</td>
</tr>

</table></td></tr>
          <tr bgcolor="#000000">
            <td colspan="2" align="center" valign="middle">
                          <?php echo tep_draw_form('login', FILENAME_LOGIN, 'action=process'); ?>
                            <table width="280" border="0" cellspacing="0" cellpadding="2">
                            <br><br>
                              <tr>
                                <td class="login_heading" valign="top">&nbsp;<b><?php echo HEADING_RETURNING_ADMIN; ?></b></td>
                              </tr>
                              <tr>
                                <td height="100%" valign="top" align="center">
                                <table border="0" height="100%" cellspacing="0" cellpadding="1" bgcolor="#666666">
                                  <tr><td><table border="0" width="100%" height="100%" cellspacing="3" cellpadding="2" bgcolor="#F0F0FF">
<?php
  if ($_GET['login'] == 'fail') {
    $info_message = TEXT_LOGIN_ERROR;
  }

  if (isset($info_message)) {
?>
                                    <tr>
                                      <td colspan="2" class="smallText" align="center"><?php echo $info_message; ?></td>
                                    </tr>
<?php
  } else {
?>
                                    <tr>
                                      <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
                                    </tr>
<?php
  }
?>                                    
                                    <tr>
                                      <td class="login"><?php echo ENTRY_EMAIL_ADDRESS; ?></td>
                                      <td class="login"><?php echo tep_draw_input_field('email_address'); ?></td>
                                    </tr>
                                    <tr>
                                      <td class="login"><?php echo ENTRY_PASSWORD; ?></td>
                                      <td class="login"><?php echo tep_draw_password_field('password'); ?></td>
                                    </tr>
                                    <tr>
                                      <td colspan="2" align="right" valign="top"><?php echo tep_image_submit('button_confirm.gif', IMAGE_BUTTON_LOGIN); ?></td>
                                    </tr>
                                  </table></td></tr>
                                </table>
                                </td>
                              </tr>
                              <tr>
                                <td valign="top" align="right"><?php echo '<a class="sub" href="' . tep_href_link(FILENAME_PASSWORD_FORGOTTEN, '', 'SSL') . '">' . TEXT_PASSWORD_FORGOTTEN . '</a><span class="sub">&nbsp;</span>'; ?></td>
                              </tr>
                            </table>
                          </form>
<br><br>
            </td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td>
<table class="table-padding-2">
      <tr>
        <td><?php require(DIR_WS_INCLUDES . 'footer.php'); ?></td>
      </tr>

</table></td>
      </tr>
    </table></td>
  </tr>
</table>

</body>

</html>
