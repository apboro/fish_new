<?php
/*
  $Id: salemaker.php,v 1.2 2003/09/24 15:18:15 wilt Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

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
            $salemaker_data_array = array('sale_status' => tep_db_prepare_input($_GET['flag']),
                'sale_date_last_modified' => 'now()',
                'sale_date_status_change' => 'now()');

            tep_db_perform(TABLE_SALEMAKER_SALES, $salemaker_data_array, 'update', "sale_id = '" . tep_db_prepare_input($_GET['sID']) . "'");

            tep_redirect(tep_href_link(FILENAME_SALEMAKER, '', 'NONSSL'));
            break;
        case 'insert':
        case 'update':
// insert a new sale or update an existing sale

// Create a string of all affected (sub-)categories

            if (tep_not_null($_POST['categories'])) {
                $categories_selected = array();
                $categories_all = array();
                $ind = 0;
                foreach (tep_db_prepare_input($_POST['categories']) as $category_path) {
                    $category = array_pop(explode('_', $category_path));
                    $categories_selected[] = $category;
                    $categories_all[$ind++] = $category;
                    $categories_all +=  tep_quick_get_subcategories($category,false,$ind);
                }
                asort($categories_selected);
                $categories_selected_string = implode(',', array_unique($categories_selected));
                asort($categories_all);
                $categories_all_string = ',' . implode(',', array_unique($categories_all)) . ',';
            } else {
                $categories_selected_string = 'null';
                $categories_all_string = 'null';
            }

            $salemaker_sales_data_array = array('sale_name' => tep_db_prepare_input($_POST['name']),
                'sale_deduction_value' => tep_db_prepare_input($_POST['deduction']),
                'sale_deduction_value_2' => tep_db_prepare_input($_POST['deduction_value_2']),
                'sale_quantity' => tep_db_prepare_input($_POST['deduction_quantity']),
                'sale_deduction_type' => tep_db_prepare_input($_POST['type']),
                'sale_pricerange_from' => tep_db_prepare_input($_POST['from']),
                'sale_pricerange_to' => tep_db_prepare_input($_POST['to']),
                'sale_specials_condition' => tep_db_prepare_input($_POST['condition']),
                'sale_categories_selected' => $categories_selected_string,
                'sale_categories_all' => $categories_all_string,
                'sale_date_start' => tep_db_prepare_input($_POST['sale_date_start']),
                'sale_date_end' => tep_db_prepare_input($_POST['sale_date_end']));

            if ($action == 'insert') {
                $salemaker_sales['sale_status'] = 0;
                $salemaker_sales_data_array['sale_date_added'] = 'now()';
                $salemaker_sales_data_array['sale_date_last_modified'] = '0000-00-00';
                $salemaker_sales_data_array['sale_date_status_change'] = '0000-00-00';
                tep_db_perform(TABLE_SALEMAKER_SALES, $salemaker_sales_data_array, 'insert');
            } else {
                $salemaker_sales_data_array['sale_date_last_modified'] = 'now()';
                tep_db_perform(TABLE_SALEMAKER_SALES, $salemaker_sales_data_array, 'update', "sale_id = '" . tep_db_input($_POST['sID']) . "'");
            }

            tep_redirect(tep_href_link(FILENAME_SALEMAKER, 'page=' . $_GET['page'] . '&sID=' . $_POST['sID']));
            break;
        case 'copyconfirm':
            $newname = tep_db_prepare_input($_POST['newname']);
            if (tep_not_null($newname)) {
                $salemaker_sales_query = tep_db_query("select * from " . TABLE_SALEMAKER_SALES . " where sale_id = '" . tep_db_input($_GET['sID']) . "'");
                if (tep_db_num_rows($salemaker_sales_query)) {
                    $salemaker_sales = tep_db_fetch_array($salemaker_sales_query);
                    $salemaker_sales['sale_id'] = 'null';
                    $salemaker_sales['sale_name'] = $newname;
                    $salemaker_sales['sale_status'] = 0;
                    $salemaker_sales['sale_date_added'] = 'now()';
                    $salemaker_sales['sale_date_last_modified'] = '0000-00-00';
                    $salemaker_sales['sale_date_status_change'] = '0000-00-00';

                    tep_db_perform(TABLE_SALEMAKER_SALES, $salemaker_sales, 'insert');
                }
            }

            tep_redirect(tep_href_link(FILENAME_SALEMAKER, 'page=' . $_GET['page'] . '&sID=' . tep_db_insert_id()));
            break;
        case 'deleteconfirm':
            $sale_id = tep_db_prepare_input($_GET['sID']);

            tep_db_query("delete from " . TABLE_SALEMAKER_SALES . " where sale_id = '" . (int)$sale_id . "'");

            tep_redirect(tep_href_link(FILENAME_SALEMAKER, 'page=' . $_GET['page']));
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
    if (($action == 'new') || ($action == 'edit')) {
    ?>
    <link rel="stylesheet" type="text/css" href="includes/javascript/date-picker/css/datepicker.css">
    <script language="JavaScript" src="includes/javascript/date-picker/js/datepicker.js"></script>
    <script language="JavaScript">
        function RowClick(RowValue) {
            for (i = 0; i < document.sale_form.length; i++) {
                if (document.sale_form.elements[i].type == 'checkbox') {
                    if (document.sale_form.elements[i].value == RowValue) {
                        if (document.sale_form.elements[i].disabled == false) {
                            document.sale_form.elements[i].checked = !document.sale_form.elements[i].checked;
                        }
                    }
                }
            }
            SetCategories()
        }

        function CheckBoxClick() {
            if (this.disabled == false) {
                this.checked = !this.checked;
            }
            SetCategories()
        }

        function SetCategories() {
            for (i = 0; i < document.sale_form.length; i++) {
                if (document.sale_form.elements[i].type == 'checkbox') {
                    document.sale_form.elements[i].disabled = false;
                    document.sale_form.elements[i].onclick = CheckBoxClick;
                    document.sale_form.elements[i].parentNode.parentNode.className = 'SaleMakerOver';
                }
            }
            change = true;
            while (change) {
                change = false;
                for (i = 0; i < document.sale_form.length; i++) {
                    if (document.sale_form.elements[i].type == 'checkbox') {
                        currentcheckbox = document.sale_form.elements[i];
                        currentrow = currentcheckbox.parentNode.parentNode;
                        if ((currentcheckbox.checked) && (currentrow.className == 'SaleMakerOver')) {
                            currentrow.className = 'SaleMakerSelected';
                            for (j = 0; j < document.sale_form.length; j++) {
                                if (document.sale_form.elements[j].type == 'checkbox') {
                                    relatedcheckbox = document.sale_form.elements[j];
                                    relatedrow = relatedcheckbox.parentNode.parentNode;
                                    if ((relatedcheckbox != currentcheckbox) && (relatedcheckbox.value.substr(0, currentcheckbox.value.length) == currentcheckbox.value)) {
                                        if (!relatedcheckbox.disabled) {
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

        function session_win() {
            window.open("<?php echo tep_href_link(FILENAME_SALEMAKER_INFO); ?>", "salemaker_info", "height=460,width=600,scrollbars=yes,resizable=yes").focus();
        }
    </script>
</head>
<body marginwidth="0" marginheight="0" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0" bgcolor="#FFFFFF"
      onload="SetCategories();SetFocus();">
<?php
} else {
?>
</head>
<body marginwidth="0" marginheight="0" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0" bgcolor="#FFFFFF"
      onload="SetFocus();">
<?php
}
?>
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
                    <td width="100%">
                        <table class="table-padding-0">
                            <tr>
                                <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
                                <td class="pageHeading"
                                    align="right"><?php echo tep_draw_separator('pixel_trans.gif', HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <?php
                if (($action == 'new') || ($action == 'edit')) {
                    $form_action = 'insert';
                    if (($action == 'edit') && ($_GET['sID'])) {
                        $form_action = 'update';

                        $salemaker_sales_query = tep_db_query("select sale_deduction_value_2,sale_quantity,sale_id, sale_status, sale_name, sale_deduction_value, sale_deduction_type, sale_pricerange_from, sale_pricerange_to, sale_specials_condition, sale_categories_selected, sale_categories_all, sale_date_start, sale_date_end, sale_date_added, sale_date_last_modified, sale_date_status_change from " . TABLE_SALEMAKER_SALES . " where sale_id = '" . (int)$_GET['sID'] . "'");
                        $salemaker_sales = tep_db_fetch_array($salemaker_sales_query);

                        $sInfo = new objectInfo($salemaker_sales);
                    } else {
                        $sInfo = new objectInfo(array());
                    }
                    ?>
                    <tr>
                        <form name="sale_form" <?php echo 'action="' . tep_href_link(FILENAME_SALEMAKER, tep_get_all_get_params(array('action', 'info', 'sID')) . 'action=' . $form_action, 'NONSSL') . '"'; ?>
                              method="post"><?php if ($form_action == 'update') echo tep_draw_hidden_field('sID', $_GET['sID']); ?>
                            <td>
                                <table class="table-padding-2">
                                    <tr>
                                        <td class="main"><?php echo TEXT_SALEMAKER_POPUP; ?></td>
                                        <td class="main" align="right" valign="top">
                                            <br><?php echo (($form_action == 'insert') ? tep_image_submit('button_insert.gif', IMAGE_INSERT) : tep_image_submit('button_update.gif', IMAGE_UPDATE)) . '&nbsp;&nbsp;&nbsp;<a href="' . tep_href_link(FILENAME_SALEMAKER, 'page=' . $_GET['page'] . '&sID=' . $_GET['sID']) . '">' . tep_image_button('button_cancel.gif', IMAGE_CANCEL); ?>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                    </tr>
                    <tr>
                        <td>
                            <table border="0" cellspacing="0" cellpadding="2">
                                <tr>
                                    <td class="main"><?php echo TEXT_SALEMAKER_NAME; ?>&nbsp;</td>
                                    <td class="main"><?php echo tep_draw_input_field('name', $sInfo->sale_name, 'size="37"'); ?></td>
                                </tr>
                                <tr>
                                    <td class="main"><?php echo TEXT_SALEMAKER_DEDUCTION; ?>&nbsp;</td>
                                    <td style="border:1px solid green;" class="main">
                                        <table border=0>
                                            <tr>
                                                <td class="main">Скидка 1(<<?php echo $sInfo->sale_quantity; ?>)</td>
                                                <td>
                                                    <?php echo tep_draw_input_field('deduction', $sInfo->sale_deduction_value, 'size="8"'); ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="main">Скидка 2(> <?php echo $sInfo->sale_quantity; ?>)</td>
                                                <td>
                                                    <?php echo tep_draw_input_field('deduction_value_2', $sInfo->sale_deduction_value_2, 'size="8"'); ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="main">Количество</td>
                                                <td>
                                                    <?php echo tep_draw_input_field('deduction_quantity', $sInfo->sale_quantity, 'size="8"'); ?>
                                                    <br>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="main"><?php echo TEXT_SALEMAKER_DEDUCTION_TYPE; ?></td>
                                                <td>
                                                    <?php echo tep_draw_pull_down_menu('type', $deduction_type_array, $sInfo->sale_deduction_type); ?>
                                                </td>
                                            </tr>

                                        </table>

                                    </td>
                                </tr>
                                <tr>
                                    <td class="main"><?php echo TEXT_SALEMAKER_PRICERANGE_FROM; ?>&nbsp;</td>
                                    <td class="main"><?php echo tep_draw_input_field('from', $sInfo->sale_pricerange_from, 'size="8"') . TEXT_SALEMAKER_PRICERANGE_TO . tep_draw_input_field('to', $sInfo->sale_pricerange_to, 'size="8"'); ?></td>
                                </tr>
                                <tr>
                                    <td class="main"><?php echo TEXT_SALEMAKER_SPECIALS_CONDITION; ?>&nbsp;</td>
                                    <td class="main"><?php echo tep_draw_pull_down_menu('condition', $specials_condition_array, $sInfo->sale_specials_condition); ?></td>
                                </tr>
                                <tr>
                                    <td class="main"><?php echo TEXT_SALEMAKER_DATE_START; ?>&nbsp;</td>
                                    <td class="main"><?php echo tep_draw_input_field('sale_date_start', $sInfo->sale_date_start, 'size="10" class="format-y-m-d dividor-space"'); ?></td>
                                </tr>
                                <tr>
                                    <td class="main"><?php echo TEXT_SALEMAKER_DATE_END; ?>&nbsp;</td>
                                    <td class="main"><?php echo tep_draw_input_field('sale_date_end', $sInfo->sale_date_end, 'size="10" class="format-y-m-d dividor-space"'); ?></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    </td>
                    <td>
                        <table border="0" cellspacing="0" cellpadding="2">
                            <select name="categories[]" class="select2-menu" multiple style="width: 100%">
                                <?php

                                $categories_query = tep_db_query("select c.categories_id, c.parent_id, cd.categories_name from " .
                                    TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION .
                                    " cd where c.categories_id = cd.categories_id and cd.language_id = '" . $languages_id .
                                    "' and c.categories_id IN (".$sInfo->sale_categories_selected.")");
                                while ($categories = tep_db_fetch_array($categories_query)) {
                                    echo "<option selected=\"\" value=\"".$categories['categories_id']."\">".$categories['categories_name']." (".$categories['categories_id'].")"."</option>";
                                }
                                ?>

                            </select>
                            <?php
                            //TODO:Отключаем вывод категорий на время
                            if(false){
                            $categories_query = tep_db_query("select c.categories_id, c.parent_id, cd.categories_name from " .
                                TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION .
                                " cd where c.categories_id = cd.categories_id and cd.language_id = '" . $languages_id .
                                "' Limit 10");
                            $categories_array = array();
                            while ($categories = tep_db_fetch_array($categories_query)) {
                                $categories_array[] = $categories;
                            }
                            $n = sizeof($categories_array);
                                print_r($categories_array);
                                die();
                            for ($i = 0; $i < $n; $i++) {
                                $categories_array[$i]['path'] = $categories_array[$i]['categories_id'];
                                $categories_array[$i]['indent'] = 0;
                                $parent = $categories_array[$i]['parent_id'];
                                while ($parent != 0) {
                                    $categories_array[$i]['indent']++;
                                    for ($j = 0; $j < $n; $j++) {
                                        if ($categories_array[$j]['categories_id'] == $parent) {
                                            $categories_array[$i]['path'] = $parent . '_' . $categories_array[$i]['path'];
                                            $parent = $categories_array[$j]['parent_id'];
                                            break;
                                        }
                                    }
                                }
                                $categories_array[$i]['path'] = '0_' . $categories_array[$i]['path'];
                            }

                            $order_changed = true;
                            while ($order_changed) {
                                $order_changed = false;
                                for ($i = 0, $n = (sizeof($categories_array) - 1); $i < $n; $i++) {
                                    if ($categories_array[$i]['path'] > $categories_array[$i + 1]['path']) {
                                        $tmp = $categories_array[$i];
                                        $categories_array[$i] = $categories_array[$i + 1];
                                        $categories_array[$i + 1] = $tmp;
                                        $order_changed = true;
                                    }
                                }
                            }

                            $categories_selected = explode(',', $sInfo->sale_categories_selected);
                            if (tep_not_null($sInfo->sale_categories_selected)) {
                                $selected = in_array(0, $categories_selected);
                            } else {
                                $selected = false;
                            }

                            echo "      <tr>\n";
                            echo '        <td valign="bottom">' . tep_draw_separator('pixel_trans.gif', '4', '1') . tep_image(DIR_WS_IMAGES . 'icon_arrow_right.gif') . "</td>\n";
                            echo '        <td class="main"><br>' . TEXT_SALEMAKER_ENTIRE_CATALOG . "</td>\n";
                            echo "      </tr>\n";
                            echo '      <tr onClick="RowClick(\'0\')">' . "\n";
                            echo '        <td width="10">' . tep_draw_checkbox_field('categories[]', '0', $selected) . "</td>\n";
                            echo '        <td>' . TEXT_SALEMAKER_TOP . "</td>\n";
                            echo "      </tr>\n";
                            echo "      <tr>\n";
                            echo '        <td valign="bottom">' . tep_draw_separator('pixel_trans.gif', '4', '1') . tep_image(DIR_WS_IMAGES . 'icon_arrow_right.gif') . "</td>\n";
                            echo '        <td class="main"><br>' . TEXT_SALEMAKER_CATEGORIES . "</td>\n";
                            echo "      </tr>\n";

                            foreach ($categories_array as $category) {
                                if (tep_not_null($sInfo->sale_categories_selected)) {
                                    $selected = in_array($category['categories_id'], $categories_selected);
                                } else {
                                    $selected = false;
                                }
                                echo '      <tr onClick="RowClick(\'' . $category['path'] . '\')">' . "\n";
                                echo '        <td width="10">' . tep_draw_checkbox_field('categories[]', $category['path'], $selected) . "</td>\n";
                                echo '        <td>' . str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;', $category['indent']) . $category['categories_name'] . "</td>\n";
                                echo '      </tr>' . "\n";
                            }


                            }
                            ?>
                        </table>
                    </td>
                    </form></tr>
                    <?php
                } else {
                ?>
                <tr>
                    <td>
                        <table class="table-padding-0">
                            <tr>
                                <td valign="top">
                                    <table class="table-padding-2">
                                        <tr class="dataTableHeadingRow">
                                            <td class="dataTableHeadingContent"
                                                align="left"><?php echo TABLE_HEADING_SALE_NAME; ?></td>
                                            <td colspan="2">
                                                <table border="0" width="100%" cellpadding="0" cellspacing="2">
                                                    <tr>
                                                        <td class="dataTableHeadingContent"
                                                            align="center"><?php echo TABLE_HEADING_SALE_DEDUCTION; ?></td>
                                                    </tr>
                                                </table>
                                            </td>
                                            <td class="dataTableHeadingContent"
                                                align="center"><?php echo TABLE_HEADING_SALE_DATE_START; ?></td>
                                            <td class="dataTableHeadingContent"
                                                align="center"><?php echo TABLE_HEADING_SALE_DATE_END; ?></td>
                                            <td class="dataTableHeadingContent"
                                                align="center"><?php echo TABLE_HEADING_STATUS; ?></td>
                                            <td class="dataTableHeadingContent"
                                                align="right"><?php echo TABLE_HEADING_ACTION; ?>&nbsp;
                                            </td>
                                        </tr>
                                        <?php
                                        $salemaker_sales_query_raw = "select sale_id, sale_status, sale_name, sale_deduction_value, sale_deduction_type, sale_pricerange_from, sale_pricerange_to, sale_specials_condition, sale_categories_selected, sale_categories_all, sale_date_start, sale_date_end, sale_date_added, sale_date_last_modified, sale_date_status_change from " . TABLE_SALEMAKER_SALES . " order by sale_name";
                                        $salemaker_sales_split = new splitPageResults($_GET['page'], MAX_PROD_ADMIN_SIDE, $salemaker_sales_query_raw, $salemaker_sales_query_numrows);
                                        $salemaker_sales_query = tep_db_query($salemaker_sales_query_raw);
                                        while ($salemaker_sales = tep_db_fetch_array($salemaker_sales_query)) {
                                            if ((!isset($_GET['sID']) || (isset($_GET['sID']) && ($_GET['sID'] == $salemaker_sales['sale_id']))) && !isset($sInfo)) {
                                                $sInfo_array = $salemaker_sales;
                                                $sInfo = new objectInfo($sInfo_array);
                                            }

                                            if (isset($sInfo) && is_object($sInfo) && ($salemaker_sales['sale_id'] == $sInfo->sale_id)) {
                                                echo '                  <tr class="dataTableRowSelected" onmouseover="this.style.cursor=\'hand\'" onclick="document.location.href=\'' . tep_href_link(FILENAME_SALEMAKER, 'page=' . $_GET['page'] . '&sID=' . $sInfo->sale_id . '&action=edit') . '\'">' . "\n";
                                            } else {
                                                echo '                  <tr class="dataTableRow" onmouseover="this.className=\'dataTableRowOver\';this.style.cursor=\'hand\'" onmouseout="this.className=\'dataTableRow\'" onclick="document.location.href=\'' . tep_href_link(FILENAME_SALEMAKER, 'page=' . $_GET['page'] . '&sID=' . $salemaker_sales['sale_id']) . '\'">' . "\n";
                                            }
                                            ?>
                                            <td class="dataTableContent"
                                                align="left"><?php echo $salemaker_sales['sale_name']; ?></td>
                                            <td class="dataTableContent"
                                                align="right"><?php echo $salemaker_sales['sale_deduction_value']; ?></td>
                                            <td class="dataTableContent"
                                                align="left"><?php echo $deduction_type_array[$salemaker_sales['sale_deduction_type']]['text']; ?></td>
                                            <td class="dataTableContent"
                                                align="center"><?php echo(($salemaker_sales['sale_date_start'] == '0000-00-00') ? TEXT_SALEMAKER_IMMEDIATELY : tep_date_short($salemaker_sales['sale_date_start'])); ?></td>
                                            <td class="dataTableContent"
                                                align="center"><?php echo(($salemaker_sales['sale_date_end'] == '0000-00-00') ? TEXT_SALEMAKER_NEVER : tep_date_short($salemaker_sales['sale_date_end'])); ?></td>
                                            <td class="dataTableContent" align="center">
                                                <?php
                                                if ($salemaker_sales['sale_status'] == '1') {
                                                    echo tep_image(DIR_WS_IMAGES . 'icon_status_green.gif', IMAGE_ICON_STATUS_GREEN, 10, 10) . '&nbsp;&nbsp;<a href="' . tep_href_link(FILENAME_SALEMAKER, 'action=setflag&flag=0&sID=' . $salemaker_sales['sale_id'], 'NONSSL') . '">' . tep_image(DIR_WS_IMAGES . 'icon_status_red_light.gif', IMAGE_ICON_STATUS_RED_LIGHT, 10, 10) . '</a>';
                                                } else {
                                                    echo '<a href="' . tep_href_link(FILENAME_SALEMAKER, 'action=setflag&flag=1&sID=' . $salemaker_sales['sale_id'], 'NONSSL') . '">' . tep_image(DIR_WS_IMAGES . 'icon_status_green_light.gif', IMAGE_ICON_STATUS_GREEN_LIGHT, 10, 10) . '</a>&nbsp;&nbsp;' . tep_image(DIR_WS_IMAGES . 'icon_status_red.gif', IMAGE_ICON_STATUS_RED, 10, 10);
                                                }
                                                ?></td>
                                            <td class="dataTableContent"
                                                align="right"><?php if ((is_object($sInfo)) && ($salemaker_sales['sale_id'] == $sInfo->sale_id)) {
                                                    echo tep_image(DIR_WS_IMAGES . 'icon_arrow_right.gif', '');
                                                } else {
                                                    echo '<a href="' . tep_href_link(FILENAME_SALEMAKER, 'page=' . $_GET['page'] . '&sID=' . $salemaker_sales['sale_id']) . '">' . tep_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . '</a>';
                                                } ?>&nbsp;
                                            </td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                        <tr>
                                            <td colspan="7">
                                                <table border="0" width="100%" cellpadding="0" cellspacing="2">
                                                    <tr>
                                                        <td class="smallText top-valign"><?php echo $salemaker_sales_split->display_count($salemaker_sales_query_numrows, MAX_PROD_ADMIN_SIDE, $_GET['page'], TEXT_DISPLAY_NUMBER_OF_SALES); ?></td>
                                                        <td class="smallText"
                                                            align="right"><?php echo $salemaker_sales_split->display_links($salemaker_sales_query_numrows, MAX_PROD_ADMIN_SIDE, MAX_DISPLAY_PAGE_LINKS, $_GET['page']); ?></td>
                                                    </tr>
                                                    <?php
                                                    if (empty($action)) {
                                                        ?>
                                                        <tr>
                                                            <td colspan="2"
                                                                align="right"><?php echo '<a href="' . tep_href_link(FILENAME_SALEMAKER, 'page=' . $_GET['page'] . '&action=new') . '">' . tep_image_button('button_new_sale.gif', IMAGE_NEW_SALE) . '</a>'; ?></td>
                                                        </tr>
                                                        <?php
                                                    }
                                                    ?>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                                <?php
                                $heading = array();
                                $contents = array();

                                switch ($action) {
                                    case 'copy':
                                        $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_COPY_SALE . '</b>');

                                        $contents = array('form' => tep_draw_form('sales', FILENAME_SALEMAKER, 'page=' . $_GET['page'] . '&sID=' . $sInfo->sale_id . '&action=copyconfirm'));
                                        $contents[] = array('text' => sprintf(TEXT_INFO_COPY_INTRO, $sInfo->sale_name));
                                        $contents[] = array('text' => '<br>&nbsp;' . tep_draw_input_field('newname', $sInfo->sale_name . '_', 'size="31"'));
                                        $contents[] = array('align' => 'center', 'text' => '<br>' . tep_image_submit('button_copy.gif', IMAGE_COPY) . '&nbsp;<a href="' . tep_href_link(FILENAME_SALEMAKER, 'page=' . $_GET['page'] . '&sID=' . $sInfo->sale_id) . '">' . tep_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>');
                                        break;
                                    case 'delete':
                                        $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_DELETE_SALE . '</b>');

                                        $contents = array('form' => tep_draw_form('sales', FILENAME_SALEMAKER, 'page=' . $_GET['page'] . '&sID=' . $sInfo->sale_id . '&action=deleteconfirm'));
                                        $contents[] = array('text' => TEXT_INFO_DELETE_INTRO);
                                        $contents[] = array('text' => '<br><b>' . $sInfo->sale_name . '</b>');
                                        $contents[] = array('align' => 'center', 'text' => '<br>' . tep_image_submit('button_delete.gif', IMAGE_DELETE) . '&nbsp;<a href="' . tep_href_link(FILENAME_SALEMAKER, 'page=' . $_GET['page'] . '&sID=' . $sInfo->sale_id) . '">' . tep_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>');
                                        break;
                                    default:
                                        if (is_object($sInfo)) {
                                            $heading[] = array('text' => '<b>' . $sInfo->sale_name . '</b>');

                                            $contents[] = array('align' => 'center', 'text' => '<a href="' . tep_href_link(FILENAME_SALEMAKER, 'page=' . $_GET['page'] . '&sID=' . $sInfo->sale_id . '&action=edit') . '">' . tep_image_button('button_edit.gif', IMAGE_EDIT) . '</a> <a href="' . tep_href_link(FILENAME_SALEMAKER, 'page=' . $_GET['page'] . '&sID=' . $sInfo->sale_id . '&action=copy') . '">' . tep_image_button('button_copy_to.gif', IMAGE_COPY_TO) . '</a> <a href="' . tep_href_link(FILENAME_SALEMAKER, 'page=' . $_GET['page'] . '&sID=' . $sInfo->sale_id . '&action=delete') . '">' . tep_image_button('button_delete.gif', IMAGE_DELETE) . '</a>');
                                            $contents[] = array('text' => '<br>' . TEXT_INFO_DATE_ADDED . ' ' . tep_date_short($sInfo->sale_date_added));
                                            $contents[] = array('text' => '' . TEXT_INFO_DATE_MODIFIED . ' ' . (($sInfo->sale_date_last_modified == '0000-00-00') ? TEXT_SALEMAKER_NEVER : tep_date_short($sInfo->sale_date_last_modified)));
                                            $contents[] = array('text' => '' . TEXT_INFO_DATE_STATUS_CHANGE . ' ' . (($sInfo->sale_date_status_change == '0000-00-00') ? TEXT_SALEMAKER_NEVER : tep_date_short($sInfo->sale_date_status_change)));

                                            $contents[] = array('text' => '<br>' . TEXT_INFO_DEDUCTION . ' ' . $sInfo->sale_deduction_value . ' ' . $deduction_type_array[$sInfo->sale_deduction_type]['text']);
                                            $contents[] = array('text' => '' . TEXT_INFO_PRICERANGE_FROM . ' ' . $currencies->format($sInfo->sale_pricerange_from) . TEXT_INFO_PRICERANGE_TO . $currencies->format($sInfo->sale_pricerange_to));
                                            $contents[] = array('text' => '<table class="dataTableContent" class="table-padding-0"><tr><td valign="top">' . TEXT_INFO_SPECIALS_CONDITION . '&nbsp;</td><td>' . $specials_condition_array[$sInfo->sale_specials_condition]['text'] . '</td></tr></table>');

                                            $contents[] = array('text' => '<br>' . TEXT_INFO_DATE_START . ' ' . (($sInfo->sale_date_start == '0000-00-00') ? TEXT_SALEMAKER_IMMEDIATELY : tep_date_short($sInfo->sale_date_start)));
                                            $contents[] = array('text' => '' . TEXT_INFO_DATE_END . ' ' . (($sInfo->sale_date_end == '0000-00-00') ? TEXT_SALEMAKER_NEVER : tep_date_short($sInfo->sale_date_end)));
                                        }
                                        break;
                                }
                                if ((tep_not_null($heading)) && (tep_not_null($contents))) {
                                    echo '            <td width="25%" valign="top">' . "\n";

                                    $box = new box;
                                    echo $box->infoBox($heading, $contents);
                                    echo '            </td>' . "\n";
                                }
                                }
                                ?>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
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
