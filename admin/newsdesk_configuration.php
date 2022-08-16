<?php

  require('includes/application_top.php');

  if ($_GET['action']) {
    switch ($_GET['action']) {
      case 'save':
     $configuration_value = tep_db_prepare_input($_POST['configuration_value']);
        $cID = tep_db_prepare_input($_GET['cID']);

          $configuration_query = tep_db_query("select configuration_key,configuration_title,configuration_description,configuration_id, configuration_value, use_function,set_function from " . TABLE_NEWSDESK_CONFIGURATION . " where configuration_group_id = '" . (int)$_GET['gID'] . "' order by sort_order");

          while ($configuration = tep_db_fetch_array($configuration_query))
              tep_db_query("UPDATE ".TABLE_NEWSDESK_CONFIGURATION." SET configuration_value='".$_POST[$configuration['configuration_key']]."' where configuration_key='".$configuration['configuration_key']."'");

               tep_redirect(FILENAME_NEWSDESK_CONFIGURATION. '?gID=' . (int)$_GET['gID']);
        break;

    }
  }

  $cfg_group_query = tep_db_query("select configuration_group_id, configuration_group_title, configuration_group_key from " . TABLE_NEWSDESK_CONFIGURATION_GROUP . " where configuration_group_id = '" . (int)$_GET['gID'] . "'");
  $cfg_group = tep_db_fetch_array($cfg_group_query);
?>

<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<title><?php echo TITLE; ?></title>
<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
<script language="javascript" src="includes/menu.js"></script>
<script language="javascript" src="includes/general.js"></script>
</head>
<body marginwidth="0" marginheight="0" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0" bgcolor="#FFFFFF" onload="SetFocus();">
<!-- header //-->
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
<!-- header_eof //-->

<!-- body //-->
<table border="0" width="100%" cellspacing="2" cellpadding="2">
	<tr>
		<td width="<?php echo BOX_WIDTH; ?>" valign="top">
<table border="0" width="<?php echo BOX_WIDTH; ?>" cellspacing="1" cellpadding="1" class="columnLeft">

<!-- left_navigation //-->
<?php require(DIR_WS_INCLUDES . 'column_left.php'); ?>

<!-- left_navigation_eof //-->
</table>
		</td>
<!-- body_text //-->

		<td width="100%" valign="top">
<table class="table-padding-2">
	<tr>
		<td>
<?php
if (!defined('CONFIGURATION_GROUP_' . $cfg_group['configuration_group_id'])) {
$text = $cfg_group['configuration_group_title'];
} else {
$text = constant('CONFIGURATION_GROUP_' . $cfg_group['configuration_group_id']);
}
?>   		
<table class="table-padding-0">
	<tr>
		<td class="pageHeading"><?php echo $text; ?></td>
		<td class="pageHeading" align="right"><?php echo tep_draw_separator('pixel_trans.gif', HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?></td>
	</tr>
</table>
		</td>
	</tr>

<?php echo tep_draw_form('configuration', FILENAME_NEWSDESK_CONFIGURATION, 'gID=' . (int)$_GET['gID'] . '&action=save'); ?>
            <table width="100%"  border="0" cellspacing="0" cellpadding="4">
<?php
  $configuration_query = tep_db_query("select configuration_key,configuration_id, configuration_value, use_function,set_function from " . TABLE_NEWSDESK_CONFIGURATION . " where configuration_group_id = '" . (int)$_GET['gID'] . "' order by sort_order");

  while ($configuration = tep_db_fetch_array($configuration_query)) {

    if (tep_not_null($configuration['use_function'])) {
      $use_function = $configuration['use_function'];
      if (preg_match('/->/', $use_function)) {
        $class_method = explode('->', $use_function);
        if (!is_object(${$class_method[0]})) {
          include(DIR_WS_CLASSES . $class_method[0] . '.php');
          ${$class_method[0]} = new $class_method[0]();
        }
        $cfgValue = tep_call_function($class_method[1], $configuration['configuration_value'], ${$class_method[0]});
      } else {
        $cfgValue = tep_call_function($use_function, $configuration['configuration_value']);
      }
    } else {
      $cfgValue = $configuration['configuration_value'];
    }

    if (((!$_GET['cID']) || (@$_GET['cID'] == $configuration['configuration_id'])) && (!$cInfo) && (substr($_GET['action'], 0, 3) != 'new')) {
      $cfg_extra_query = tep_db_query("select configuration_key,configuration_value, date_added, last_modified, use_function, set_function from " . TABLE_NEWSDESK_CONFIGURATION . " where configuration_id = '" . $configuration['configuration_id'] . "'");
      $cfg_extra = tep_db_fetch_array($cfg_extra_query);

      $cInfo_array = tep_array_merge($configuration, $cfg_extra);
      $cInfo = new objectInfo($cInfo_array);
    }
    if ($configuration['set_function']) {
        eval('$value_field = ' . $configuration['set_function'] . '"' . htmlspecialchars($configuration['configuration_value']) . '");');
      } else {
        $value_field = tep_draw_input_field($configuration['configuration_key'], $configuration['configuration_value'],'size=40');
      }
   // add

   if (strstr($value_field,'configuration_value')) $value_field=str_replace('configuration_value',$configuration['configuration_key'],$value_field);

if (!defined($configuration['configuration_key'].'_TITLE')) {
$conf_title = $configuration['configuration_title'];
} else {
$conf_title = constant($configuration['configuration_key'].'_TITLE');
}

if (!defined($configuration['configuration_key'].'_DESC')) {
$conf_desc = $configuration['configuration_description'];
} else {
$conf_desc = constant($configuration['configuration_key'].'_DESC');
}

   echo '
  <tr>
    <td width="300" valign="top" align="right" class="dataTableContent"><b>'.$conf_title.'</b></td>
    <td valign="top" class="dataTableContent">
    <table width="100%"  border="0" cellspacing="0" cellpadding="2">
      <tr>
        <td style="background-color:#DFDFDF ; border: 1px solid; border-color: #CCCCCC;" class="dataTableContent">'.$value_field.'</td>
      </tr>
    </table>
    '.$conf_desc.'<br /></td>
  </tr>
  ';

  }
?>
            </table>
<?php echo tep_image_submit('button_update.gif', IMAGE_UPDATE); ?></form>
            </td>

          </tr>
        </table></td>
      </tr>
    </table></td>
<!-- body_text_eof //-->

	</tr>
</table>
<!-- body_eof //-->

<!-- footer //-->
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<!-- footer_eof //-->

</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>

<?php
/*

	osCommerce, Open Source E-Commerce Solutions ---- http://www.oscommerce.com
	Copyright (c) 2002 osCommerce
	Released under the GNU General Public License

	IMPORTANT NOTE:

	This script is not part of the official osC distribution but an add-on contributed to the osC community.
	Please read the NOTE and INSTALL documents that are provided with this file for further information and installation notes.

	script name:	NewsDesk
	version:		1.4.5
	date:			2003-08-31
	author:			Carsten aka moyashi
	web site:		www..com

*/
?>