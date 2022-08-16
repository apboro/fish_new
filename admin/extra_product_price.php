<?php
/*
  $Id: extra_product_price.php,v 1.0 2005/09/11 15:18:15 wilt Exp $

  for The osCommerce Vam Edition v 1.71
  Last Update: 2005/10/22 12:27:15

  Author: FlyOpenair
  email: flyopenair@mail.ru
  web:   flyopenair.ru

  Released under the GNU General Public License
*/

define('AUTOCHECK', 'False');
define('DISPLAYTTT', 'True');

  require('includes/application_top.php');

  require(DIR_WS_CLASSES . 'currencies.php');
  $currencies = new currencies();

  $specials_condition_array = array(array('id' => '0', 'text' => SPECIALS_CONDITION_DROPDOWN_0),
                                    array('id' => '1', 'text' => SPECIALS_CONDITION_DROPDOWN_1),
                                    array('id' => '2', 'text' => SPECIALS_CONDITION_DROPDOWN_2));

  $deduction_type_array = array(array('id' => '0', 'text' => DEDUCTION_TYPE_DROPDOWN_0),
                                array('id' => '1', 'text' => DEDUCTION_TYPE_DROPDOWN_1),
                                array('id' => '2', 'text' => DEDUCTION_TYPE_DROPDOWN_2));

  $action = (isset($_GET['action']) ? $_GET['action'] : '');

  if (tep_not_null($action)) {
    switch ($action) {
      case 'setflag':
        $extra_product_price_data_array = array('extra_product_price_status' => tep_db_prepare_input($_GET['flag']),
                                      'extra_product_price_date_last_modified' => 'now()',
                                      'extra_product_price_date_status_change' => 'now()');

        tep_db_perform(TABLE_EXTRA_PRODUCT_PRICE, $extra_product_price_data_array, 'update', "extra_product_price_id = '" . tep_db_prepare_input($_GET['sID']) . "'");

        tep_redirect(tep_href_link(FILENAME_EXTRA_PRODUCT_PRICE, '', 'NONSSL'));
        break;
      case 'insert':
      case 'update':
// insert a new sale or update an existing sale

// Create a string of all affected (sub-)categories
        if (tep_not_null($categories)) {
          $categories_selected = array();
          $categories_all = array();
          foreach(tep_db_prepare_input($categories) as $category_path) {
            $category = array_pop(explode('_', $category_path));
            $categories_selected[] = $category;
            $categories_all[] = $category;
            foreach(tep_get_category_tree($category) as $subcategory) {
              if ($subcategory['id'] != '0') {
                $categories_all[] = $subcategory['id'];
              }
            }
          }
          asort($categories_selected);
          $categories_selected_string = implode(',', array_unique($categories_selected));
          asort($categories_all);
          $categories_all_string = ',' . implode(',', array_unique($categories_all)) . ',';
        } else {
          $categories_selected_string = 'null';
          $categories_all_string = 'null';
        }

        $extra_product_price_data_array = array('extra_product_price_name' => tep_db_prepare_input($_POST['name']),
                                            'extra_product_price_deduction_value' => tep_db_prepare_input($_POST['deduction']),
                                            'extra_product_price_deduction_type' => tep_db_prepare_input($_POST['type']),
                                            'extra_product_price_pricerange_from' => tep_db_prepare_input($_POST['from']),
                                            'extra_product_price_pricerange_to' => tep_db_prepare_input($_POST['to']),
                                            'extra_product_price_categories_selected' => $categories_selected_string,
                                            'extra_product_price_categories_all' => $categories_all_string);

        if ($action == 'insert') {
          $extra_product_price['extra_product_price_status'] = 0;
          $extra_product_price_data_array['extra_product_price_date_added'] = 'now()';

          tep_db_perform(TABLE_EXTRA_PRODUCT_PRICE, $extra_product_price_data_array, 'insert');
        } else {
          $extra_product_price_data_array['extra_product_price_date_last_modified'] = 'now()';
          tep_db_perform(TABLE_EXTRA_PRODUCT_PRICE, $extra_product_price_data_array, 'update', "extra_product_price_id = '" . tep_db_input($_POST['sID']) . "'");
        }

        tep_redirect(tep_href_link(FILENAME_EXTRA_PRODUCT_PRICE, 'page=' . $_GET['page'] . '&sID=' . $_POST['sID']));
        break;
      case 'copyconfirm':
        $newname = tep_db_prepare_input($_POST['newname']);
        if (tep_not_null($newname)) {
          $extra_product_price_query = tep_db_query("select * from " . TABLE_EXTRA_PRODUCT_PRICE . " where extra_product_price_id = '" . tep_db_input($_GET['sID']) . "'");
          if (tep_db_num_rows($extra_product_price_query)) {
            $extra_product_price = tep_db_fetch_array($extra_product_price_query);
            $extra_product_price['extra_product_price_id'] = 'null';
            $extra_product_price['extra_product_price_name'] = $newname;
            $extra_product_price['extra_product_price_status'] = 0;
            $extra_product_price['extra_product_price_date_added'] = 'now()';


            tep_db_perform(TABLE_EXTRA_PRODUCT_PRICE, $extra_product_price, 'insert');
          }
        }

        tep_redirect(tep_href_link(FILENAME_EXTRA_PRODUCT_PRICE, 'page=' . $_GET['page'] . '&sID=' . tep_db_insert_id()));
        break;
      case 'deleteconfirm':
        $extra_product_price_id = tep_db_prepare_input($_GET['sID']);

        tep_db_query("delete from " . TABLE_EXTRA_PRODUCT_PRICE . " where extra_product_price_id = '" . (int)$extra_product_price_id . "'");

        tep_redirect(tep_href_link(FILENAME_EXTRA_PRODUCT_PRICE, 'page=' . $_GET['page']));
        break;
    }
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
<?php
  if ( ($action == 'new') || ($action == 'edit') ) {
?>
<script language="JavaScript">
function RowClick(RowValue) {
  for (i=0; i<document.extra_product_price_form.length; i++) {
    if(document.extra_product_price_form.elements[i].type == 'checkbox') {
      if(document.extra_product_price_form.elements[i].value == RowValue) {
        if(document.extra_product_price_form.elements[i].disabled == false) {
         document.extra_product_price_form.elements[i].checked = !document.extra_product_price_form.elements[i].checked;
        }
      }
    }
  }
  SetCategories()
}

function CheckBoxClick() {
  if(this.disabled == false) {
    this.checked = !this.checked;
  }
  SetCategories()
}

function SetCategories() {
  for (i=0; i<document.extra_product_price_form.length; i++) {
    if(document.extra_product_price_form.elements[i].type == 'checkbox') {
      document.extra_product_price_form.elements[i].disabled = false;
      document.extra_product_price_form.elements[i].onclick = CheckBoxClick;
      document.extra_product_price_form.elements[i].parentNode.parentNode.className = 'SaleMakerOver';
    }
  }
  change = true;
  while(change) {
    change = false;
    for (i=0; i<document.extra_product_price_form.length; i++) {
      if(document.extra_product_price_form.elements[i].type == 'checkbox') {
        currentcheckbox = document.extra_product_price_form.elements[i];
        currentrow = currentcheckbox.parentNode.parentNode;
        if ( (currentcheckbox.checked) && (currentrow.className == 'SaleMakerOver') ) {
          currentrow.className = 'SaleMakerSelected';
          for (j=0; j<document.extra_product_price_form.length; j++) {
            if(document.extra_product_price_form.elements[j].type == 'checkbox') {
              relatedcheckbox = document.extra_product_price_form.elements[j];
              relatedrow = relatedcheckbox.parentNode.parentNode;
              if( (relatedcheckbox != currentcheckbox) && (relatedcheckbox.value.substr(0, currentcheckbox.value.length) == currentcheckbox.value) ) {
                if(!relatedcheckbox.disabled) {
<?php
    if ( (defined('AUTOCHECK')) && (AUTOCHECK == 'True') ) {
?>
                  relatedcheckbox.checked = true;
<?php
    }
?>
                  relatedcheckbox.disabled = true;
                  relatedrow.className = 'SaleMakerDisabled';
                  change = true;
                }
              }
            }
          }
        }
      }
    }
  }
}


</script>
</head>
<body marginwidth="0" marginheight="0" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0" bgcolor="#FFFFFF" onload="SetCategories();SetFocus();">
<?php
  } else {
?>
</head>
<body marginwidth="0" marginheight="0" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0" bgcolor="#FFFFFF" onload="SetFocus();">
<?php
  }
?>
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
         <table border="0" width="100%" cellspacing="0" cellpadding="5">
           <tr>
  </tr>
      <tr>
        <td width="100%"><table class="table-padding-0">
          <tr>
            <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
            <td class="pageHeading" align="right"><?php echo tep_draw_separator('pixel_trans.gif', HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?></td>
          </tr>
        </table></td>
      </tr>
<?php
  if ( ($action == 'new') || ($action == 'edit') ) {
    $form_action = 'insert';
    if ( ($action == 'edit') && ($_GET['sID']) ) {
      $form_action = 'update';

      $extra_product_price_query = tep_db_query("select extra_product_price_id, extra_product_price_status, extra_product_price_name, extra_product_price_deduction_value, extra_product_price_deduction_type, extra_product_price_pricerange_from, extra_product_price_pricerange_to,  extra_product_price_categories_selected, extra_product_price_categories_all,   extra_product_price_date_status_change from " . TABLE_EXTRA_PRODUCT_PRICE . " where extra_product_price_id = '" . (int)$_GET['sID'] . "'");
      $extra_product_price = tep_db_fetch_array($extra_product_price_query);

      $sInfo = new objectInfo($extra_product_price);
    } else {
      $sInfo = new objectInfo(array());
    }
?>
      <tr><form name="extra_product_price_form" <?php echo 'action="' . tep_href_link(FILENAME_EXTRA_PRODUCT_PRICE, tep_get_all_get_params(array('action', 'info', 'sID')) . 'action=' . $form_action, 'NONSSL') . '"'; ?> method="post"><?php if ($form_action == 'update') echo tep_draw_hidden_field('sID', $_GET['sID']); ?>
        <td><table class="table-padding-2">
          <tr>

            <td class="main" align="right" valign="top"><br><?php echo (($form_action == 'insert') ? tep_image_submit('button_insert.gif', IMAGE_INSERT) : tep_image_submit('button_update.gif', IMAGE_UPDATE)). '&nbsp;&nbsp;&nbsp;<a href="' . tep_href_link(FILENAME_EXTRA_PRODUCT_PRICE, 'page=' . $_GET['page'] . '&sID=' . $_GET['sID']) . '">' . tep_image_button('button_cancel.gif', IMAGE_CANCEL); ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><table border="0" cellspacing="0" cellpadding="2">
          <tr>
            <td class="main"><?php echo TABLE_EXTRA_PRODUCT_PRICE_NAME; ?>&nbsp;</td>
            <td class="main"><?php echo tep_draw_input_field('name', $sInfo->extra_product_price_name, 'size="37"'); ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo TABLE_EXTRA_PRODUCT_PRICE_DEDUCTION; ?>&nbsp;</td>
            <td class="main"><?php echo tep_draw_input_field('deduction', $sInfo->extra_product_price_deduction_value, 'size="8"') . TEXT_EXTRA_PRODUCT_PRICE_DEDUCTION_TYPE . tep_draw_pull_down_menu('type', $deduction_type_array, $sInfo->extra_product_price_deduction_type); ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo TEXT_EXTRA_PRODUCT_PRICE_PRICERANGE_FROM; ?>&nbsp;</td>
            <td class="main"><?php echo tep_draw_input_field('from', $sInfo->extra_product_price_pricerange_from, 'size="8"') . TEXT_EXTRA_PRODUCT_PRICE_PRICERANGE_TO . tep_draw_input_field('to', $sInfo->extra_product_price_pricerange_to, 'size="8"'); ?></td>
          </tr>
        </table></td>
      </tr>
    </td>
    <td><table border="0" cellspacing="0" cellpadding="2">
<?php
    $categories_query = tep_db_query("select c.categories_id, c.parent_id, cd.categories_name from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd where c.categories_id = cd.categories_id and cd.language_id = '" . $languages_id . "'");
    $categories_array = array();
    while($categories = tep_db_fetch_array($categories_query)) {
      $categories_array[] = $categories;
    }
    $n = sizeof($categories_array);
    for($i = 0; $i < $n; $i++) {
      $categories_array[$i]['path'] = $categories_array[$i]['categories_id'];
      $categories_array[$i]['indent'] = 0;
      $parent = $categories_array[$i]['parent_id'];
      while($parent != 0) {
        $categories_array[$i]['indent']++;
        for($j = 0; $j < $n; $j++) {
          if($categories_array[$j]['categories_id'] == $parent) {
            $categories_array[$i]['path'] = $parent . '_' . $categories_array[$i]['path'];
            $parent = $categories_array[$j]['parent_id'];
            break;
          }
        }
      }
      $categories_array[$i]['path'] = '0_' . $categories_array[$i]['path'];
    }

    $order_changed = true;
    while($order_changed) {
      $order_changed = false;
      for($i = 0, $n = (sizeof($categories_array) - 1); $i < $n; $i++) {
        if($categories_array[$i]['path'] > $categories_array[$i + 1]['path']) {
          $tmp = $categories_array[$i];
          $categories_array[$i] = $categories_array[$i + 1];
          $categories_array[$i + 1] = $tmp;
          $order_changed = true;
        }
      }
    }

    $categories_selected = explode(',', $sInfo->extra_product_price_categories_selected);
    if (tep_not_null($sInfo->extra_product_price_categories_selected)) {
      $selected = in_array(0, $categories_selected);
    } else {
      $selected = false;
    }



?>
        </table></td>
      </form></tr>
<?php
  } else {
?>
      <tr>
        <td><table class="table-padding-0">
          <tr>
            <td valign="top"><table class="table-padding-2">
              <tr class="dataTableHeadingRow">
                <td class="dataTableHeadingContent" align="left"><?php echo TABLE_EXTRA_PRODUCT_PRICE_NAME; ?></td>
                <td colspan="2"><table border="0" width="100%" cellpadding="0"cellspacing="2">
                  <tr>
                    <td class="dataTableHeadingContent" align="center"><?php echo TABLE_EXTRA_PRODUCT_PRICE_DEDUCTION; ?></td>
                  </tr>
                </table></td>
                <td class="dataTableHeadingContent" align="center"><?php echo TABLE_EXTRA_PRODUCT_PRICE_HEADING_DEDUCTION_STATUS; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_EXTRA_PRODUCT_PRICE_HEADING_ACTION; ?>&nbsp;</td>
              </tr>
<?php
    $extra_product_price_query_raw = "select extra_product_price_id, extra_product_price_status, extra_product_price_name, extra_product_price_deduction_value, extra_product_price_deduction_type, extra_product_price_pricerange_from, extra_product_price_pricerange_to,  extra_product_price_categories_selected, extra_product_price_categories_all, extra_product_price_date_start, extra_product_price_date_end, extra_product_price_date_added, extra_product_price_date_last_modified, extra_product_price_date_status_change from " . TABLE_EXTRA_PRODUCT_PRICE . " order by extra_product_price_name";
    $extra_product_price_split = new splitPageResults($_GET['page'], MAX_PROD_ADMIN_SIDE, $extra_product_price_query_raw, $extra_product_price_query_numrows);
    $extra_product_price_query = tep_db_query($extra_product_price_query_raw);
    while ($extra_product_price = tep_db_fetch_array($extra_product_price_query)) {
      if ((!isset($_GET['sID']) || (isset($_GET['sID']) && ($_GET['sID'] == $extra_product_price['extra_product_price_id']))) && !isset($sInfo)) {
        $sInfo_array = $extra_product_price;
        $sInfo = new objectInfo($sInfo_array);
      }

      if (isset($sInfo) && is_object($sInfo) && ($extra_product_price['extra_product_price_id'] == $sInfo->extra_product_price_id)) {
        echo '                  <tr class="dataTableRowSelected" onmouseover="this.style.cursor=\'hand\'" onclick="document.location.href=\'' . tep_href_link(FILENAME_EXTRA_PRODUCT_PRICE, 'page=' . $_GET['page'] . '&sID=' . $sInfo->specials_id . '&action=edit') . '\'">' . "\n";
      } else {
        echo '                  <tr class="dataTableRow" onmouseover="this.className=\'dataTableRowOver\';this.style.cursor=\'hand\'" onmouseout="this.className=\'dataTableRow\'" onclick="document.location.href=\'' . tep_href_link(FILENAME_EXTRA_PRODUCT_PRICE, 'page=' . $_GET['page'] . '&sID=' . $extra_product_price['extra_product_price_id']) . '\'">' . "\n";
      }
?>
                <td  class="dataTableContent" align="left"><?php echo $extra_product_price['extra_product_price_name']; ?></td>
                <td  class="dataTableContent" align="right"><?php echo $extra_product_price['extra_product_price_deduction_value']; ?></td>
                <td  class="dataTableContent" align="left"><?php echo $deduction_type_array[$extra_product_price['extra_product_price_deduction_type']]['text']; ?></td>
                <td  class="dataTableContent" align="center">
<?php
      if ($extra_product_price['extra_product_price_status'] == '1') {
        echo tep_image(DIR_WS_IMAGES . 'icon_status_green.gif', IMAGE_ICON_STATUS_GREEN, 10, 10) . '&nbsp;&nbsp;<a href="' . tep_href_link(FILENAME_EXTRA_PRODUCT_PRICE, 'action=setflag&flag=0&sID=' . $extra_product_price['extra_product_price_id'], 'NONSSL') . '">' . tep_image(DIR_WS_IMAGES . 'icon_status_red_light.gif', IMAGE_ICON_STATUS_RED_LIGHT, 10, 10) . '</a>';
      } else {
        echo '<a href="' . tep_href_link(FILENAME_EXTRA_PRODUCT_PRICE, 'action=setflag&flag=1&sID=' . $extra_product_price['extra_product_price_id'], 'NONSSL') . '">' . tep_image(DIR_WS_IMAGES . 'icon_status_green_light.gif', IMAGE_ICON_STATUS_GREEN_LIGHT, 10, 10) . '</a>&nbsp;&nbsp;' . tep_image(DIR_WS_IMAGES . 'icon_status_red.gif', IMAGE_ICON_STATUS_RED, 10, 10);
      }
?></td>
                <td class="dataTableContent" align="right"><?php if ( (is_object($sInfo)) && ($extra_product_price['extra_product_price_id'] == $sInfo->extra_product_price_id) ) { echo tep_image(DIR_WS_IMAGES . 'icon_arrow_right.gif', ''); } else { echo '<a href="' . tep_href_link(FILENAME_EXTRA_PRODUCT_PRICE, 'page=' . $_GET['page'] . '&sID=' . $extra_product_price['extra_product_price_id']) . '">' . tep_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . '</a>'; } ?>&nbsp;</td>
      </tr>
<?php
    }
?>
              <tr>
                <td colspan="7"><table border="0" width="100%" cellpadding="0"cellspacing="2">
                  <tr>
                    <td class="smallText top-valign"><?php echo $extra_product_price_split->display_count($extra_product_price_query_numrows, MAX_PROD_ADMIN_SIDE, $_GET['page'], TEXT_DISPLAY_NUMBER_OF_EXTRA_PRODUCT_PRICE); ?></td>
                    <td class="smallText" align="right"><?php echo $extra_product_price_split->display_links($extra_product_price_query_numrows, MAX_PROD_ADMIN_SIDE, MAX_DISPLAY_PAGE_LINKS, $_GET['page']); ?></td>
                  </tr>
<?php
  if (empty($action)) {
?>
                  <tr>
                    <td colspan="2" align="right"><?php echo '<a href="' . tep_href_link(FILENAME_EXTRA_PRODUCT_PRICE, 'page=' . $_GET['page'] . '&action=new') . '">' . tep_image_button('button_new_sale.gif', IMAGE_NEW_EXTRA_PRODUCT_PRICE) . '</a>'; ?></td>
                  </tr>
<?php
  }
?>
                </table></td>
              </tr>
            </table></td>
<?php
  $heading = array();
  $contents = array();

  switch ($action) {
    case 'copy':
      $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_COPY_SALE . '</b>');

      $contents = array('form' => tep_draw_form('sales', FILENAME_EXTRA_PRODUCT_PRICE, 'page=' . $_GET['page'] . '&sID=' . $sInfo->extra_product_price_id . '&action=copyconfirm'));
      $contents[] = array('text' => sprintf(TEXT_INFO_COPY_INTRO, $sInfo->extra_product_price_name));
      $contents[] = array('text' => '<br>&nbsp;' . tep_draw_input_field('newname', $sInfo->extra_product_price_name . '_', 'size="31"'));
      $contents[] = array('align' => 'center', 'text' => '<br>' . tep_image_submit('button_copy.gif', IMAGE_COPY) . '&nbsp;<a href="' . tep_href_link(FILENAME_EXTRA_PRODUCT_PRICE, 'page=' . $_GET['page'] . '&sID=' . $sInfo->extra_product_price_id) . '">' . tep_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>');
      break;
    case 'delete':
      $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_DELETE_SALE . '</b>');

      $contents = array('form' => tep_draw_form('sales', FILENAME_EXTRA_PRODUCT_PRICE, 'page=' . $_GET['page'] . '&sID=' . $sInfo->extra_product_price_id . '&action=deleteconfirm'));
      $contents[] = array('text' => TEXT_INFO_DELETE_INTRO);
      $contents[] = array('text' => '<br><b>' . $sInfo->extra_product_price_name . '</b>');
      $contents[] = array('align' => 'center', 'text' => '<br>' . tep_image_submit('button_delete.gif', IMAGE_DELETE) . '&nbsp;<a href="' . tep_href_link(FILENAME_EXTRA_PRODUCT_PRICE, 'page=' . $_GET['page'] . '&sID=' . $sInfo->extra_product_price_id) . '">' . tep_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>');
      break;
    default:
      if (is_object($sInfo)) {
        $heading[] = array('text' => '<b>' . $sInfo->extra_product_price_name . '</b>');

        $contents[] = array('align' => 'center', 'text' => '<a href="' . tep_href_link(FILENAME_EXTRA_PRODUCT_PRICE, 'page=' . $_GET['page'] . '&sID=' . $sInfo->extra_product_price_id . '&action=edit') . '">' . tep_image_button('button_edit.gif', IMAGE_EDIT) . '</a> <a href="' . tep_href_link(FILENAME_EXTRA_PRODUCT_PRICE, 'page=' . $_GET['page'] . '&sID=' . $sInfo->extra_product_price_id . '&action=copy') . '">' . tep_image_button('button_copy_to.gif', IMAGE_COPY_TO) . '</a> <a href="' . tep_href_link(FILENAME_EXTRA_PRODUCT_PRICE, 'page=' . $_GET['page'] . '&sID=' . $sInfo->extra_product_price_id . '&action=delete') . '">' . tep_image_button('button_delete.gif', IMAGE_DELETE) . '</a>');
        $contents[] = array('text' => '<br>' . TEXT_INFO_DATE_ADDED . ' ' . tep_date_short($sInfo->extra_product_price_date_added));
        $contents[] = array('text' => '' . TEXT_INFO_DATE_MODIFIED . ' ' . (($sInfo->extra_product_price_date_last_modified == '0000-00-00') ? TEXT_EXTRA_PRODUCT_PRICE_NEVER : tep_date_short($sInfo->extra_product_price_date_last_modified)));


        $contents[] = array('text' => '<br>' . TEXT_INFO_DEDUCTION . ' ' . $sInfo->extra_product_price_deduction_value . ' ' . $deduction_type_array[$sInfo->extra_product_price_deduction_type]['text']);
        $contents[] = array('text' => '' . TEXT_INFO_PRICERANGE_FROM . ' ' . $currencies->format($sInfo->extra_product_price_pricerange_from) . TEXT_INFO_PRICERANGE_TO . $currencies->format($sInfo->extra_product_price_pricerange_to));


      }
      break;
  }
  if ( (tep_not_null($heading)) && (tep_not_null($contents)) ) {
    echo '            <td width="25%" valign="top">' . "\n";

    $box = new box;
    echo $box->infoBox($heading, $contents);
    echo '            </td>' . "\n";
  }
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
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>
