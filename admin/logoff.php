<?php
/*
  $Id: logoff.php,v 1.2 2003/09/24 15:18:15 wilt Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/

  require('includes/application_top.php');

  require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_LOGOFF);

//tep_session_destroy();
  tep_session_unregister('login_id');
  tep_session_unregister('login_firstname');
  tep_session_unregister('login_groups_id');

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
<table border="0" width="600" height="100%" cellspacing="0" cellpadding="0" align="center" valign="middle">
  <tr>
    <td><table border="0" width="600" cellspacing="0" cellpadding="1" align="center" valign="middle">
      <tr bgcolor="#000000">
        <td><table border="0" width="600" cellspacing="0" cellpadding="0">
           <tr> <td colspan="2" valign="top" height="100%">
 <table border="0" height="100%" cellspacing="0" cellpadding="0" bordercolor="#990000"> 
     	<?php 
        	// #CP - point logos to come from selected template's images directory
		    $template_query = tep_db_query("select configuration_id, configuration_title, configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'DEFAULT_TEMPLATE'");
  			$template = tep_db_fetch_array($template_query);
  			$CURR_TEMPLATE = $template['configuration_value'] . '/';
            
        ?>

<tr><td colspan="3"> <table border=0 cellpadding=0 cellspacing=0 width=100%> <tr> <td bgcolor="#ffffff"> <?php echo tep_image(DIR_WS_TEMPLATES . $CURR_TEMPLATE . DIR_WS_IMAGES . 'oscommerce.gif'); ?></td>
            
        <td bgcolor="#ffffff" width="495" align="center" valign="middle"> 
&nbsp;
              </td>
              <td bgcolor="#ffffff" width="495" align="center" valign="middle"> 
&nbsp;
              </td>
          </tr> </table></td></tr>
          <tr bgcolor="#000000">
            <td colspan="2" align="center" valign="middle">

<table border="0" cellpadding="0" cellspacing="0" width="100%">
<tr><td bgcolor="black" height="1" colspan="2"></td></tr>
<tr class="headerNavigation" height="25">
    <td  height="25" background="images/back.gif" class="headerBarContent" align="right" valign="middle">&nbsp;</td>
</tr>
<tr><td bgcolor="black" height="1" colspan="2"></td></tr>
</table>

</td>
</tr>


          <tr bgcolor="#000000">
            <td colspan="2" align="center" valign="middle">
                            <table width="280" border="0" cellspacing="0" cellpadding="2">
                              <tr>
                                <td class="login_heading" valign="top"><br><b><?php echo HEADING_TITLE; ?></b></td>
                              </tr>
                              <tr>
                                <td class="login_heading"><?php echo TEXT_MAIN; ?></td>
                              </tr>
                              <tr>
                                <td class="login_heading" align="right"><?php echo '<a class="login_heading" href="' . tep_href_link(FILENAME_LOGIN, '', 'SSL') . '">' . tep_image_button('button_back.gif', IMAGE_BACK) . '</a>'; ?></td>
                              </tr>
                              <tr>
                                <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '100%', '30'); ?></td>
                              </tr>
                            </table>
            </td>
          </tr>
        </table></td>
      </tr>
            </td>
          </tr>
        </table></td>

      <tr>
        <td><?php require(DIR_WS_INCLUDES . 'footer.php'); ?></td
      </tr>
    </table></td>
  </tr>
</table>

</body>

</html>
