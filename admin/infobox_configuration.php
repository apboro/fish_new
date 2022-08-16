<?php
/*
  $Id: infobox_configuration.php,v 1.3 2003/10/06 18:00:38 anotherlango Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/

  require('includes/application_top.php');

  $gID = $_GET['gID'];
  $cID = $_GET['cID'];

////
// Alias function for Store configuration values in the Administration Tool
  function tep_cfg_select_option_infobox($select_array, $key_value, $key = '') {
    $string = '';

    for ($i=0, $n=sizeof($select_array); $i<$n; $i++) {
      $name = ((tep_not_null($key)) ? 'infobox_' .$key  : 'infobox_display');
      $string .= '<input type="radio" name="' . $name . '" value="' . $select_array[$i] . '"';
      if ($key_value == $select_array[$i]) $string .= ' CHECKED';
      $string .= '> ' . $select_array[$i];
    }
    return $string;
  }

  function tep_get_templates() {
    $templates_query = tep_db_query("select template_id, template_name from " . TABLE_TEMPLATE . " order by template_id");
    while ($template = tep_db_fetch_array($templates_query)) {
      $template_array[] = array('id' => $template['template_id'],
                                 'name' => $template['template_name']);
    }

    return $template_array;
  }



  $action = (isset($_GET['action']) ? $_GET['action'] : '');

  if (tep_not_null($action)) {

    switch ($action) {

     case 'position_update': //set the status of a template active buttons.
	 if (isset($_POST['pos'])) {
	 $loc_id = array_combine($_POST['id'],$_POST['pos']);
	 
	 foreach($loc_id as $insd => $vs)
   {
      tep_db_query('UPDATE `'. TABLE_INFOBOX_CONFIGURATION .'` SET `location` = \''.$vs.'\' WHERE `infobox_id` = \''.$insd.'\'');
   }

	
	 }
        if ( ($_GET['flag'] == 'up') || ($_GET['flag'] == 'down') ) {
          if ($_GET['gID']) {
            tep_db_query("update " . TABLE_INFOBOX_CONFIGURATION . " set  location = '" . $_GET['loc'] .  "', last_modified = now() where location = '" . $_GET['loc1'] . "' and display_in_column = '" . $_GET['col'] . "'");

            tep_db_query("update " . TABLE_INFOBOX_CONFIGURATION . " set  location = '" . $_GET['loc1'] .  "', last_modified = now() where infobox_id = '" . (int)$iID . "' and display_in_column = '" . $_GET['col'] . "'");
        }
        }
tep_redirect(tep_href_link(FILENAME_INFOBOX_CONFIGURATION, 'gID=' . $_GET['gID'] . '&cID=' . $iID));
        break;


case 'fixweight': 
    global  $infobox_id, $cID;
    $rightpos = 'right';
    $leftpos = 'left';

    $result_query = tep_db_query("select infobox_id from " . TABLE_INFOBOX_CONFIGURATION . " where display_in_column = '" . $leftpos . "' and template_id = '" . (int)$gID . "' order by location");

    $sorted_position = 0;
      while ($result = tep_db_fetch_array($result_query)) {
	$sorted_position++;
	tep_db_query("update " . TABLE_INFOBOX_CONFIGURATION . " set location = '" . $sorted_position . "' where infobox_id = '" . (int)$result['infobox_id'] . "' and template_id = '" . (int)$gID . "'");
    }

    $result_query = tep_db_query("select infobox_id from " . TABLE_INFOBOX_CONFIGURATION . " where display_in_column = '" . $rightpos . "' and template_id = '" . (int)$gID . "' order by location");

    $sorted_position = 0;
      while ($result = tep_db_fetch_array($result_query)) {
	$sorted_position++;
	tep_db_query("update " . TABLE_INFOBOX_CONFIGURATION . " set location = '" . $sorted_position . "' where infobox_id = '" . (int)$result['infobox_id'] . "' and template_id = '" . (int)$gID . "'");
    }

tep_redirect(tep_href_link(FILENAME_INFOBOX_CONFIGURATION, 'gID=' . $_GET['gID'] . '&cID=' . $cID));
        break;


      case 'setflag': //set the status of a news item.
        if ( ($_GET['flag'] == 'no') || ($_GET['flag'] == 'yes') ) {
          if ($_GET['cID']) {
            tep_db_query("update " . TABLE_INFOBOX_CONFIGURATION . " set infobox_display = '" . $_GET['flag'] . "' where infobox_id = '" . (int)$cID . "'");
          }
        }

tep_redirect(tep_href_link(FILENAME_INFOBOX_CONFIGURATION, 'gID=' . $_GET['gID'] . '&cID=' . $cID));
        break;

      case 'setflagcolumn': //set the status of a news item.
        if ( ($_GET['flag'] == 'left') || ($_GET['flag'] == 'right') ) {
          if ($_GET['cID']) {
            tep_db_query("update " . TABLE_INFOBOX_CONFIGURATION . " set display_in_column = '" . $_GET['flag'] . "' where infobox_id = '" . (int)$cID . "' and template_id = '" . $_GET['gID'] . "'");
          }
        }

tep_redirect(tep_href_link(FILENAME_INFOBOX_CONFIGURATION, 'gID=' . $_GET['gID'] . '&cID=' . $cID));
        break;

      case 'save':

      $configuration_active = tep_db_prepare_input($_POST['infobox_active']);


      $infobox_file_name = tep_db_prepare_input($_POST['infobox_file_name']);
      $infobox_define = tep_db_prepare_input($_POST['infobox_define']);
      $display_in_column = tep_db_prepare_input($_POST['infobox_column']);
      $location = tep_db_prepare_input($_POST['location']);
      $box_heading = tep_db_prepare_input($_POST['box_heading']);
      $box_template = tep_db_prepare_input($_POST['box_template']);
      $box_heading_font_color = tep_db_prepare_input($_POST['hexval']);
      $cID = tep_db_prepare_input($_GET['cID']);

        tep_db_query("update " . TABLE_INFOBOX_CONFIGURATION . " set infobox_file_name = '" . tep_db_input($infobox_file_name) . "',
							 infobox_define = '" . tep_db_input($infobox_define) . "',
							 location = '" . tep_db_input($location) . "',
							 display_in_column = '" . tep_db_input($display_in_column) . "',
							 infobox_display = '" . tep_db_input($configuration_active) . "',
							 box_heading = '" . tep_db_input($box_heading) . "',
							 box_template = '" . tep_db_input($box_template) . "',
							 box_heading_font_color = '" . tep_db_input($box_heading_font_color) . "',
							 last_modified = now() where infobox_id = '" . (int)$cID . "' and template_id = '" . $_GET['gID'] . "'");

        tep_redirect(tep_href_link(FILENAME_INFOBOX_CONFIGURATION, 'gID=' . $_GET['gID'] . '&cID=' . $cID));
        break;

 case 'insert':

      $infobox_file_name = tep_db_prepare_input($_POST['infobox_file_name']);
      $infobox_define = tep_db_prepare_input($_POST['infobox_define']);
      $configuration_active = tep_db_prepare_input($_POST['infobox_active']);
      $display_in_column = tep_db_prepare_input($_POST['infobox_column']);
      $location = tep_db_prepare_input($_POST['location']);
      $box_heading = tep_db_prepare_input($_POST['box_heading']);
      $box_template = tep_db_prepare_input($_POST['box_template']);
      $template_id = tep_db_prepare_input($_GET['gID']);

      tep_db_query("insert into " . TABLE_INFOBOX_CONFIGURATION . " (template_id, infobox_file_name, infobox_display, infobox_define, display_in_column, location, box_heading, box_template) values ('" . tep_db_input($template_id) . "', '" . tep_db_input($infobox_file_name) . "', '" . tep_db_input($configuration_active) . "', '" . tep_db_input($infobox_define) . "', '" . tep_db_input($display_in_column) . "', '" . tep_db_input($location) . "', '" . tep_db_input($box_heading) . "', '" . tep_db_input($box_template) . "')");
       tep_redirect(tep_href_link(FILENAME_INFOBOX_CONFIGURATION, 'gID=' . $_GET['gID']));     
        break;

    case 'deleteconfirm':
      $cID = tep_db_prepare_input($_GET['cID']);;

      tep_db_query("delete from " . TABLE_INFOBOX_CONFIGURATION . " where infobox_id = '" . tep_db_input($cID) . "'");
      
        tep_redirect(tep_href_link(FILENAME_INFOBOX_CONFIGURATION, 'gID=' . $_GET['gID'] . '&cID=' . $cID));  
      break;
    }
  }

  $gID = (isset($_GET['gID'])) ? $_GET['gID'] : 1;

  $template = tep_get_templates();
  $template_array = array();
  $template_selected = '';

  for ($i = 0, $n = sizeof($template); $i < $n; $i++) {
    $template_array[] = array('id' => $template[$i]['id'],
                               'text' => $template[$i]['name']);
  }

?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<title><?php echo TITLE; ?></title>
<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
<script language="javascript" src="includes/menu.js"></script>
<script language="javascript" src="includes/general.js"></script>
<script language="javascript"><!--
function popupWindow(url) {
  window.open(url,'popupWindow','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=no,resizable=yes,copyhistory=no,width=450,height=300%,screenX=150,screenY=150,top=150,left=150')
}
//--></script>
<script language="javascript"><!--
var i=0;

function resize() {
  if (navigator.appName == 'Netscape') i = 40;
  window.resizeTo(document.images[0].width + 30, document.images[0].height + 60 - i);
}
//--></script>
<script type="text/javascript" language="JavaScript"> 

function check_form() {
  var error = 0;
  var error_message = "<?php echo JS_ERROR; ?>";

  var infobox_file_name = document.infobox_configuration.infobox_file_name.value;
  var infobox_define = document.infobox_configuration.infobox_define.value;  

  if (infobox_file_name == "") {
    error_message = error_message + "<?php echo JS_INFO_BOX_FILENAME; ?>";
    error = 1;
  }

  if (error == 1) {
    alert(error_message);
    return false;
  } else {
    return true;
  }
}


<!-- Begin 
function showColor(val) { 
document.infobox_configuration.hexval.value = val; 
} 
// End --> 


//--></script>
</head>
<body marginwidth="0" marginheight="0" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0" bgcolor="#FFFFFF">
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
          <tr><?php echo tep_draw_form('gID', FILENAME_INFOBOX_CONFIGURATION, '', 'get'); ?>
            <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
            <td class="pageHeading" align="center"><?php echo tep_draw_pull_down_menu('gID', $template_array,  $template_selected,
  'onChange="this.form.submit();"'); ?></td></form>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><form action="<?php echo tep_href_link(FILENAME_INFOBOX_CONFIGURATION, 'action=position_update&gID=' . $_GET['gID']); ?>" method="post"><center><table class="table-padding-0">
          <tr>
            <td valign="top"><table class="table-padding-2">
          <tr>
            <td valign="top"><table class="table-padding-2">
              <tr class="dataTableHeadingRow">
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_INFOBOX_FILE_NAME; ?></td>
                <td width="70" class="dataTableHeadingContent"><?php echo TABLE_HEADING_FONT_COLOR; ?></td>
                <td class="dataTableHeadingContent" align="center"><?php echo TABLE_HEADING_ACTIVE; ?></td>
                <td class="dataTableHeadingContent" align="center"><?php echo TABLE_HEADING_COLUMN; ?>&nbsp;</td>
                <td class="dataTableHeadingContent" align="left"><?php echo TABLE_HEADING_KEY; ?>&nbsp;</td>
                <td class="dataTableHeadingContent" align="center"><?php echo TABLE_HEADING_SORT_ORDER; ?>&nbsp;</td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_ACTION; ?>&nbsp;</td>
              </tr>

<?php
$count_left_active = 0;
$count_right_active = 0;
$totInf_boxes = 1;



  $configuration_query = tep_db_query("select *  from " . TABLE_INFOBOX_CONFIGURATION . " where template_id = '" . $_GET['gID'] . "' order by display_in_column, location");
  while ($configuration = tep_db_fetch_array($configuration_query)) {

$totInf_boxes++;
      $cfgloc = $configuration['location'];
      $cfgValue = $configuration['infobox_display'];
      $cfgcol = $configuration['display_in_column'];
      $cfgtemp = $configuration['box_template'];
      $cfgkey = $configuration['infobox_define'];
      $cfgfont = $configuration['box_heading_font_color'];
	  $cfgid = $configuration['infobox_id'];

	$location1 = $cfgloc - 1;
	$location3 = $cfgloc + 1;

	    $res = tep_db_query("select infobox_id from " . TABLE_INFOBOX_CONFIGURATION . " where template_id = '" . $_GET['gID'] . "' and location = ' $location1 '  AND display_in_column ='$cfgcol'");
$con1 =  tep_db_fetch_array($res);

	    $res2 = tep_db_query("select infobox_id from " . TABLE_INFOBOX_CONFIGURATION . " where template_id = '" . $_GET['gID'] . "' and location = ' $location3 '  AND display_in_column ='$cfgcol'");
$con2 =  tep_db_fetch_array($res2);



if (($cfgcol == 'left') && ($cfgValue != 'no')) { 
$count_left_active++;
} else if (($cfgcol == 'right') && ($cfgValue != 'no'))
{$count_right_active++; 
}
	$infobox_list .= $configuration['infobox_file_name']. ",";

    if ((!isset($_GET['cID']) || (isset($_GET['cID']) && ($_GET['cID'] == $configuration['infobox_id']))) && !isset($cInfo) && (substr($action, 0, 3) != 'new')) {
      $cfg_extra_query = tep_db_query("select infobox_define, date_added, last_modified from " . TABLE_INFOBOX_CONFIGURATION . " where infobox_id = '" . (int)$configuration['infobox_id'] . "'");
      $cfg_extra = tep_db_fetch_array($cfg_extra_query);

      $cInfo_array = array_merge($configuration, $cfg_extra);
      $cInfo = new objectInfo($cInfo_array);
    }
?>  <?php
    if ( (isset($cInfo) && is_object($cInfo)) && ($configuration['infobox_id'] == $cInfo->infobox_id) ) {
      echo '                  <tr id="defaultSelected" class="dataTableRowSelected" onmouseover="this.style.cursor=\'hand\'">' . "\n";
    } else {
      echo '                  <tr class="dataTableRow" onmouseover="this.className=\'dataTableRowOver\';this.style.cursor=\'hand\'" onmouseout="this.className=\'dataTableRow\'">' . "\n";
    }
?>
                <td class="dataTableContent"><input type="hidden" name="id[]" value="<?php echo $cfgid; ?>"><input title="<?php echo TEXT_BOX_POSITION; ?>" style="background: 
<?php if ($configuration['display_in_column'] == 'left'){echo "#C4D9FF";} else {echo "#DEFFD7";} ?>
 ;" name="pos[]" size="1" value="<?php echo $cfgloc; ?>" type="text">&nbsp;<?php echo $configuration['infobox_file_name']; ?></td>
                <td width="70"bgcolor="<?php echo $configuration['box_heading_font_color']; ?>">&nbsp;</td>
                <td class="dataTableContent" align="center">
<?php
      if ($configuration['infobox_display'] == 'yes') {
        echo tep_image(DIR_WS_IMAGES . 'icon_status_green.gif', IMAGE_ICON_STATUS_GREEN, 10, 10) . '&nbsp;&nbsp;<a href="' . tep_href_link(FILENAME_INFOBOX_CONFIGURATION, 'action=setflag&flag=no&gID=' . $_GET['gID'] . '&cID=' . $configuration['infobox_id'] ) . '">' . tep_image(DIR_WS_IMAGES . 'icon_status_red_light.gif', IMAGE_ICON_STATUS_RED_LIGHT, 10, 10) . '</a>';
      } else {
        echo '<a href="' . tep_href_link(FILENAME_INFOBOX_CONFIGURATION, 'action=setflag&flag=yes&gID=' . $_GET['gID'] . '&cID=' . $configuration['infobox_id']) . '">' . tep_image(DIR_WS_IMAGES . 'icon_status_green_light.gif', IMAGE_ICON_STATUS_GREEN_LIGHT, 10, 10) . '</a>&nbsp;&nbsp;' . tep_image(DIR_WS_IMAGES . 'icon_status_red.gif', IMAGE_ICON_STATUS_RED, 10, 10);
      }
?></td>
              

                <td class="dataTableContent" align="center"><?php
      if ($configuration['display_in_column'] == 'left') {
        echo tep_image(DIR_WS_IMAGES . 'icon_infobox_green.gif', IMAGE_INFOBOX_STATUS_GREEN, 14, 10) . '&nbsp;&nbsp;<a href="' . tep_href_link(FILENAME_INFOBOX_CONFIGURATION, 'action=setflagcolumn&flag=right&gID=' . $_GET['gID'] . '&cID=' . $configuration['infobox_id']) . '">' . tep_image(DIR_WS_IMAGES . 'icon_infobox_red_light.gif', IMAGE_INFOBOX_STATUS_RED_LIGHT, 14, 10) . '</a>';
      } else {
        echo '<a href="' . tep_href_link(FILENAME_INFOBOX_CONFIGURATION, 'action=setflagcolumn&flag=left&gID=' . $_GET['gID'] . '&cID=' . $configuration['infobox_id']) . '">' . tep_image(DIR_WS_IMAGES . 'icon_infobox_green_light.gif', IMAGE_INFOBOX_STATUS_GREEN_LIGHT, 14, 10) . '</a>&nbsp;&nbsp;' . tep_image(DIR_WS_IMAGES . 'icon_infobox_red.gif', IMAGE_INFOBOX_STATUS_RED, 14, 10);
      }
?></td>
                <td class="dataTableContent" align="left"><?php echo htmlspecialchars($cfgkey); ?></td>


<td height="30" align="center" valign="middle">
<?php
	    if ($con1) {
		echo '<a href="' . tep_href_link(FILENAME_INFOBOX_CONFIGURATION, 'action=position_update&loc1=' .$location1.'&loc=' .$cfgloc.'&flag=up&col=' . $cfgcol . '&iID=' .$configuration['infobox_id'] . '&gID=' . $_GET['gID']) . '">' . tep_image(DIR_WS_IMAGES . 'up.gif', IMAGE_ICON_STATUS_RED_LIGHT, 11, 14) . '</a>&nbsp;&nbsp;';
	    }
	    if ($con2) {
		echo '<a href="' . tep_href_link(FILENAME_INFOBOX_CONFIGURATION, 'action=position_update&loc1=' .$location3.'&loc=' .$cfgloc.'&flag=down&col=' . $cfgcol . '&iID=' .$configuration['infobox_id'] . '&gID=' . $_GET['gID']) . '">' . tep_image(DIR_WS_IMAGES . 'down.gif', IMAGE_ICON_STATUS_GREEN_LIGHT, 11, 14) . '</a>';
	    }
?>
</td>

                <td class="dataTableContent" align="right"><?php if ( (is_object($cInfo)) && ($configuration['infobox_id'] == $cInfo->infobox_id) ) { echo tep_image(DIR_WS_IMAGES . 'icon_arrow_right.gif', ''); } else { echo '<a href="' . tep_href_link(FILENAME_INFOBOX_CONFIGURATION, 'gID=' . $_GET['gID'] . '&cID=' . $configuration['infobox_id']) . '">' . tep_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . '</a>'; } ?>&nbsp;</td>
              </tr>
<?php
  }
?>

            </table><input name="" value="<?php echo BUTTON_SAVE; ?>" type="submit"><input name="" value="<?php echo BUTTON_CANCEL; ?>" type="reset"></form></td>
<?php

  $heading = array();
  $contents = array();

  switch ($action) {
    case 'edit':

     echo tep_draw_form('infobox_configuration', FILENAME_INFOBOX_CONFIGURATION, tep_get_all_get_params(array('action')) . 'action=save', 'post', 'onSubmit="return check_form();"') . tep_draw_hidden_field('cID', $cInfo->infobox_id);
?>
            <table class="table-padding-0">
      <tr>
        <td colspan="4"><table border="0" width="100%" cellspacing="0" cellpadding="2" bgcolor="#B3BAC5">
          <tr>
            <td class="pageHeading"><?php echo TEXT_INFO_HEADING_UPDATE_INFOBOX . ' -- <font color="' . $cInfo->box_heading_font_color . '">' . $cInfo->infobox_file_name;?></font></td>
            <td class="pageHeading" align="right"><?php echo tep_draw_separator('pixel_trans.gif', HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?></td>
                  </tr>
                </table>
                </td>
              </tr>
              <tr>
                <td colspan="4" class="infoBoxContent" width="100%" align="center">
                <font color="red">Поля формы, отмеченные * обязательны для заполнения</font> </td>
              </tr>
              <tr>
                <td class="infoBoxContent" width="30%" align="center">
<?php

      echo '<br><b>Имя файла</b><br><a href="javascript:popupWindow(\'' . tep_href_link(FILENAME_POPUP_INFOBOX_HELP,'action=filename') . '\')">' . tep_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . '</a> ' . tep_draw_input_field('infobox_file_name',$cInfo->infobox_file_name,'size="20"','true');
?>
                </td>

                <td class="infoBoxContent" width="30%" align="center">
<!--
<?php
	echo '<br><b>Название</b><br><a href="javascript:popupWindow(\'' . tep_href_link(FILENAME_POPUP_INFOBOX_HELP,'action=heading') . '\')">' . tep_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . '</a> ' . tep_draw_input_field('box_heading',$cInfo->box_heading,'size="25"','true');
?>
-->                
                </td>
                <td class="infoBoxContent" width="20%" align="center">
<input type="hidden" name="box_template" value="infobox">
                </td>
                <td class="infoBoxContent" width="20%" align="center">
<?php
      echo '<br><b>Расположение</b><br><a href="javascript:popupWindow(\'' . tep_href_link(FILENAME_POPUP_INFOBOX_HELP,'action=column') . '\')">' . tep_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . '</a> ' . tep_cfg_select_option_infobox(array('left', 'right'),$cInfo->display_in_column,'column') . '</b><br>';
?>
</td>
                    </tr>
              <tr>
                <td class="infoBoxContent" width="30%" align="center">
<?php
      echo '<br><b>Порядок сортировки</b><br><a href="javascript:popupWindow(\'' . tep_href_link(FILENAME_POPUP_INFOBOX_HELP,'action=position') . '\')">' . tep_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . '</a> ' . tep_draw_input_field('location',$cInfo->location,'size=3');
?>
 </td>
                <td colspan="2" class="infoBoxContent" width="40%" align="center">
<?php
      echo '<br><b>Переменная</b><br><a href="javascript:popupWindow(\'' . tep_href_link(FILENAME_POPUP_INFOBOX_HELP,'action=define') . '\')">' . tep_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . '</a> ' . tep_draw_input_field('infobox_define',$cInfo->infobox_define,'size="35"','true');
?>

 </td>
                <td class="infoBoxContent" width="30%" align="center">
<?php

      echo '<br><b>Активировать бокс</b><br><a href="javascript:popupWindow(\'' . tep_href_link(FILENAME_POPUP_INFOBOX_HELP,'action=active') . '\')">' . tep_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . '</a> ' . tep_cfg_select_option_infobox(array('yes', 'no'),$cInfo->infobox_display,'active') . '</b><br><br>';

?>
</td>
                    </tr>
 <tr>
                <td colspan="4" class="infoBoxContent" width="100%" align="center">
<?php include('select_color.htm');?>

<?php

      echo  tep_draw_input_field('hexval',$cInfo->box_heading_font_color,'size="10"','true');
?>
  
</td>
                    </tr>
              <tr>
                <td colspan="4" class="infoBoxContent" width="100%" align="center">
<?php
      echo '<br><br><br>' . tep_image_submit('button_update.gif', IMAGE_UPDATE) . '&nbsp;<a href="' . tep_href_link(FILENAME_INFOBOX_CONFIGURATION, 'gID=' . $_GET['gID'] . '&cID=' . $cInfo->infobox_id) . '">' . tep_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>';
?>
</form>
</td>
                    </tr>

<?php

      break;


case 'new':

      echo tep_draw_form('infobox_configuration', FILENAME_INFOBOX_CONFIGURATION, tep_get_all_get_params(array('action')) . 'action=insert', 'post', 'onSubmit="return check_form();"') . tep_draw_hidden_field('cID', $cInfo->infobox_id);
?>
            <table class="table-padding-0">
      <tr>
        <td colspan="4"><table border="0" width="100%" cellspacing="0" cellpadding="2" bgcolor="#B3BAC5">
          <tr>
            <td class="pageHeading"><?php echo TEXT_INFO_HEADING_NEW_INFOBOX;?></td>
            <td class="pageHeading" align="right"><?php echo tep_draw_separator('pixel_trans.gif', HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?></td>
          </tr>
        </table></td>
      </tr>

              <tr>
                <td colspan="4" class="infoBoxContent" width="100%" align="center">
<font color="red">Поля формы, отмеченные * обязательны для заполения</font>
</td>
                    </tr>
              <tr>
                <td class="infoBoxContent" width="30%" align="center">
<?php
 	$gID = $_GET['gID'];

    $templates_query = tep_db_query("select template_id, template_name from " . TABLE_TEMPLATE . " where template_id = " . $gID);
    $template = tep_db_fetch_array($templates_query);

	  if ($handle = opendir(DIR_FS_TEMPLATES.$template['template_name']."/boxes")) {
     /* This is the correct way to loop over the directory. */
        while (false !== ($file = readdir($handle))) { 
    	  if(is_file(DIR_FS_TEMPLATES .$template['template_name']. '/boxes/' . $file) && stristr($infobox_list.".,..", $file) == FALSE){
	    	$dirs[] = $file;
	      	$dirs_array[] = array('id' => $file,
                                 'text' => $file);
            
         }
        }
        closedir($handle); 
     }

      echo '<br><b>Имя файла</b><br><a href="javascript:popupWindow(\'' . tep_href_link(FILENAME_POPUP_INFOBOX_HELP,'action=filename') . '\')">' . tep_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . '</a> ' . tep_draw_pull_down_menu('infobox_file_name',$dirs_array,'', "style='width:150;'", 'true');
?>
 </td>
                <td class="infoBoxContent" width="30%" align="center">
<!--
<?php
	echo '<br><b>Название</b><br><a href="javascript:popupWindow(\'' . tep_href_link(FILENAME_POPUP_INFOBOX_HELP,'action=heading') . '\')">' . tep_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . '</a> ' . tep_draw_input_field('box_heading','Example','size="30"','true');
?>
-->
 </td>
                <td class="infoBoxContent" width="20%" align="center">
<input type="hidden" name="box_template" value="infobox">
 </td>
                <td class="infoBoxContent" width="20%" align="center">
<?php
      echo '<br><b>Расположение</b><br><a href="javascript:popupWindow(\'' . tep_href_link(FILENAME_POPUP_INFOBOX_HELP,'action=column') . '\')">' . tep_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . '</a> ' . tep_cfg_select_option_infobox(array('left', 'right'),'left','column') . '</b><br>';
?>
</td>
                    </tr>
              <tr>
                <td class="infoBoxContent" width="30%" align="center">
<?php
      echo '<br><b>Порядок сортировки</b><br><a href="javascript:popupWindow(\'' . tep_href_link(FILENAME_POPUP_INFOBOX_HELP,'action=position') . '\')">' . tep_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . '</a> ' . tep_draw_input_field('location',$totInf_boxes,'size=3');
?>
 </td>
                <td colspan="2" class="infoBoxContent" width="40%" align="center">
<?php
      echo '<br><b>Константа бокса в языковом файле</b><br><a href="javascript:popupWindow(\'' . tep_href_link(FILENAME_POPUP_INFOBOX_HELP,'action=define') . '\')">' . tep_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . '</a> ' . tep_draw_input_field('infobox_define','BOX_HEADING_EXAMPLE','size="35"','true');
?>
 </td>
                <td class="infoBoxContent" width="30%" align="center">
<?php

      echo '<br><b>Активировать бокс</b><br><a href="javascript:popupWindow(\'' . tep_href_link(FILENAME_POPUP_INFOBOX_HELP,'action=active') . '\')">' . tep_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . '</a> ' . tep_cfg_select_option_infobox(array('yes', 'no'),'yes','active') . '</b><br>';
?>
</td>
                    </tr>
              <tr>
                <td colspan="4" class="infoBoxContent" width="100%" align="center">
<?php
      echo '<br>' . tep_image_submit('button_module_install.gif', IMAGE_INSERT) . '&nbsp;<a href="' . tep_href_link(FILENAME_INFOBOX_CONFIGURATION, 'gID=' . $_GET['gID']) . '">' . tep_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>';
?>
</form>
</td>
                    </tr>

<?php

      break;


 case 'delete':
?>
<tr>
        <td colspan="4"><table border="0" width="100%" cellspacing="0" cellpadding="2" bgcolor="#B3BAC5">
          <tr>
            <td class="pageHeading"><?php echo TEXT_INFO_HEADING_DELETE_INFOBOX . ' -- ' . $cInfo->infobox_file_name;?></td>
            <td class="pageHeading" align="right"><?php echo tep_draw_separator('pixel_trans.gif', HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?></td>
          </tr>
        </table></td>
      </tr>
<?php

      $contents = array('form' => tep_draw_form('configuration', FILENAME_INFOBOX_CONFIGURATION, 'gID=' . $_GET['gID'] . '&cID=' . $cInfo->infobox_id . '&action=deleteconfirm'));
      $contents[] = array('align' => 'center', 'text' => TEXT_INFO_DELETE_INTRO);


      $contents[] = array('align' => 'center', 'text' => '<br>' . tep_image_submit('button_module_remove.gif', IMAGE_DELETE) . '&nbsp;<a href="' . tep_href_link(FILENAME_INFOBOX_CONFIGURATION, 'gID=' . $_GET['gID'] . '&cID=' . $cInfo->infobox_id) . '">' . tep_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>');
      break;

default:

      if (is_object($cInfo)) {
        $heading[] = array('text' => '<b>' . $cInfo->infobox_file_name . '</b>');

        $contents[] = array('align' => 'center', 'text' => '<a href="' . tep_href_link(FILENAME_INFOBOX_CONFIGURATION, 'gID=' . $_GET['gID'] . '&cID=' . $cInfo->infobox_id . '&action=edit') . '">' . tep_image_button('button_edit.gif', IMAGE_EDIT) . '</a> <a href="' . tep_href_link(FILENAME_INFOBOX_CONFIGURATION, 'gID=' . $_GET['gID'] . '&cID=' . $cInfo->infobox_id . '&action=delete') . '">' . tep_image_button('button_module_remove.gif', IMAGE_DELETE) . '</a> <a href="' . tep_href_link(FILENAME_INFOBOX_CONFIGURATION, 'action=fixweight&gID=' . $_GET['gID'] . '&cID=' . $cInfo->infobox_id) . '">' . tep_image_button('button_update_box_positions.gif', IMAGE_UPDATE) . '</a><br>');

}

  $gID = $_GET['gID'];

  $templates_query = tep_db_query("select template_id, template_name from " . TABLE_TEMPLATE . " where template_id = " . $gID);
  $template = tep_db_fetch_array($templates_query);
  if (file_exists(DIR_FS_TEMPLATES.$template['template_name']."/boxes") && ($handle = opendir(DIR_FS_TEMPLATES.$template['template_name']."/boxes"))) {
   /* This is the correct way to loop over the directory. */
      while (false !== ($file = readdir($handle))) { 
  	  if(is_file(DIR_FS_TEMPLATES .$template['template_name']. '/boxes/' . $file) && stristr($infobox_list.".,..", $file) == FALSE){
        	$avail_boxes ++;
        }
      }
      closedir($handle); 

   
  	  if (($action != 'new') && ($action != 'edit') && ($action != 'delete') && ($avail_boxes > 0)){

        $contents[] = array('align' => 'center', 'text' => '<a href="' . tep_href_link(FILENAME_INFOBOX_CONFIGURATION, 'gID=' . $_GET['gID'] . '&action=new') . '">' . tep_image_button('button_module_install.gif', IMAGE_NEW_INFOBOX) . '</a>');
	  }
      else if($avail_boxes == 0){
        $contents[] = array('align' => 'center', 'text' => 'This template does not have any infoboxes to install. Please put the infoboxes that you want to install in this template\'s boxes directory');

      }
  }
  else{
        $contents[] = array('align' => 'center', 'text' => 'This template does not have any infoboxes to install. Please put the infoboxes that you want to install in this template\'s boxes directory');
     
  }




        $contents[] = array('align' => 'center', 'text' => '<br>' . TEXT_INFO_DATE_ADDED . ' ' . tep_date_short($cInfo->date_added));
        if (tep_not_null($cInfo->last_modified)) $contents[] = array('align' => 'center','text' => TEXT_INFO_LAST_MODIFIED . ' ' . tep_date_short($cInfo->last_modified));
       
		If ($cInfo->include_column_left == 'yes' && $count_left_active == 0) {
			$contents[] = array('align' => 'center','text' => '<font color="red" size="4">ВНИМАНИЕ: Нет боксов в левой колонке</font>');
		}
		If ($cInfo->include_column_right == 'yes' && $count_right_active == 0) {
			$contents[] = array('align' => 'center','text' => '<font color="red" size="4">ВНИМАНИЕ: Нет боксов в правой колонке</font>');
		}
        $contents[] = array('align' => 'center','text' => '<br>Всего <br>'. $count_left_active . ' активных боксов в левой колонке и <br>'. $count_right_active . ' активных боксов в правой колонке');
      break;
  }



  if ( (tep_not_null($contents)) ) {
    echo '            </tr><tr><td width="100%" valign="top" align="center">' . "\n";

    $box = new box;
    echo $box->infoBox($heading,$contents);

    echo '            </td></tr> ' . "\n";

  } 

?>

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
                 </table>
<br>
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>