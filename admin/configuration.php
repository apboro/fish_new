<?php 
/*
  $Id: configuration.php,v 1.3 2003/09/24 13:57:05 wilt Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/

Header("Cache-control: private, no-cache");  
Header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); # Past date
Header("Pragma: no-cache");

  require('includes/application_top.php');

  // #CP - local dir to the template directory where you are uploading the company logo
  $template_query = tep_db_query("select configuration_id, configuration_title, configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'DEFAULT_TEMPLATE'");
  $template = tep_db_fetch_array($template_query);
  $CURR_TEMPLATE = $template['configuration_value'] . '/';
  
  $upload_fs_dir = DIR_FS_TEMPLATES.$CURR_TEMPLATE.DIR_WS_IMAGES;
  $upload_ws_dir = DIR_WS_TEMPLATES.$CURR_TEMPLATE.DIR_WS_IMAGES;
  // #CP

  $action = (isset($_GET['action']) ? $_GET['action'] : '');

  if ($_GET['action']) {
    switch ($_GET['action']) {
      case 'save':
     $configuration_value = tep_db_prepare_input($_POST['configuration_value']);
        $cID = tep_db_prepare_input($_GET['cID']);

          $configuration_query = tep_db_query("select configuration_key,configuration_id, configuration_value, use_function,set_function from " . TABLE_CONFIGURATION . " where configuration_group_id = '" . (int)$_GET['gID'] . "' order by sort_order");

          while ($configuration = tep_db_fetch_array($configuration_query))
              tep_db_query("UPDATE ".TABLE_CONFIGURATION." SET configuration_value='".$_POST[$configuration['configuration_key']]."' where configuration_key='".$configuration['configuration_key']."'");
               tep_redirect(FILENAME_CONFIGURATION. '?gID=' . (int)$_GET['gID']);
        break;

    }
  }

  $gID = (isset($_GET['gID'])) ? $_GET['gID'] : 1;

  $cfg_group_query = tep_db_query("select configuration_group_id, configuration_group_title from " . TABLE_CONFIGURATION_GROUP . " where configuration_group_id = '" . (int)$gID . "'");
  $cfg_group = tep_db_fetch_array($cfg_group_query);
  
// check if the template image directory exists
  if (is_dir($upload_fs_dir)) {
    if (!is_writeable($upload_fs_dir)) $messageStack->add(ERROR_TEMPLATE_IMAGE_DIRECTORY_NOT_WRITEABLE . $upload_fs_dir, 'error');
  } else {
    $messageStack->add(ERROR_TEMPLATE_IMAGE_DIRECTORY_DOES_NOT_EXIST . $upload_fs_dir, 'error');
  }
  
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
    <td width="<?php echo BOX_WIDTH; ?>" valign="top"><table border="0" width="<?php echo BOX_WIDTH; ?>" cellspacing="1" cellpadding="1" class="columnLeft">
<!-- left_navigation //-->
<?php require(DIR_WS_INCLUDES . 'column_left.php'); ?>
<!-- left_navigation_eof //-->
    </table></td>
<!-- body_text //-->
    <td width="100%" valign="top"><table class="table-padding-2">
      <tr>
        <td><table class="table-padding-0">
          <tr>
<?php
if (!defined('CONFIGURATION_GROUP_' . $cfg_group['configuration_group_id'])) {
$text = $cfg_group['configuration_group_title'];
} else {
$text = constant('CONFIGURATION_GROUP_' . $cfg_group['configuration_group_id']);
}
?>          
            <td class="pageHeading"><?php echo $text; ?></td>
            <td class="pageHeading" align="right"><?php echo tep_draw_separator('pixel_trans.gif', HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?></td>
          </tr>
        </table></td>
      </tr>

<?php echo tep_draw_form('configuration', FILENAME_CONFIGURATION, 'gID=' . (int)$_GET['gID'] . '&action=save'); ?>
            <table width="100%"  border="0" cellspacing="0" cellpadding="4">
<?php
  $configuration_query = tep_db_query("select configuration_key,configuration_title,configuration_description,configuration_id, configuration_value, use_function,set_function from " . TABLE_CONFIGURATION . " where configuration_group_id = '" . (int)$_GET['gID'] . "' order by sort_order");

	$rows = 0;
  while ($configuration = tep_db_fetch_array($configuration_query)) {
	$rows++;

        if (($rows/2) == floor($rows/2)) {
          $class = "even";
        } else {
          $class = "odd";
        }	
        
 /*   if ($_GET['gID'] == 6) {
      switch ($configuration['configuration_key']) {
        case 'MODULE_PAYMENT_INSTALLED':
          if ($configuration['configuration_value'] != '') {
            $payment_installed = explode(';', $configuration['configuration_value']);
            for ($i = 0, $n = sizeof($payment_installed); $i < $n; $i++) {
              include(DIR_FS_CATALOG_LANGUAGES . $language . '/modules/payment/' . $payment_installed[$i]);
            }
          }
          break;

        case 'MODULE_SHIPPING_INSTALLED':
          if ($configuration['configuration_value'] != '') {
            $shipping_installed = explode(';', $configuration['configuration_value']);
            for ($i = 0, $n = sizeof($shipping_installed); $i < $n; $i++) {
              include(DIR_FS_CATALOG_LANGUAGES . $language . '/modules/shipping/' . $shipping_installed[$i]);
            }
          }
          break;

        case 'MODULE_ORDER_TOTAL_INSTALLED':
          if ($configuration['configuration_value'] != '') {
            $ot_installed = explode(';', $configuration['configuration_value']);
            for ($i = 0, $n = sizeof($ot_installed); $i < $n; $i++) {
              include(DIR_FS_CATALOG_LANGUAGES . $language . '/modules/order_total/' . $ot_installed[$i]);
            }
          }
          break;
      }
    }*/
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
      $cfg_extra_query = tep_db_query("select configuration_key,configuration_value, date_added, last_modified, use_function, set_function from " . TABLE_CONFIGURATION . " where configuration_id = '" . $configuration['configuration_id'] . "'");
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
    <td width="300" valign="top" align="right" class="dataTableContent-'.$class.'">'.$conf_title.'</td>
    <td valign="top" class="dataTableContent">
    <table width="100%"  border="0" cellspacing="0" cellpadding="2">
      <tr>
        <td style="background-color:#DFDFDF ; border: 1px solid; border-color: #CCCCCC;" class="dataTableContent-'.$class.'">'.$value_field.'</td>
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
<br>
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>