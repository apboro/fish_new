<?php
/*
  $Id: products_attributes.php,v 1.52 2003/07/10 20:46:01 dgw_ Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/

  require('includes/application_top.php');
  $languages = tep_get_languages();

  $action = (isset($_GET['action']) ? $_GET['action'] : '');

    if (isset($_GET['option_page'])) $option_page = $_GET['option_page'];
    if (isset($_GET['value_page'])) $value_page = $_GET['value_page'];
    if (isset($_GET['attribute_page'])) $attribute_page = $_GET['attribute_page'];

  if (tep_not_null($action)) {
    $page_info = '';
    if (isset($_GET['option_page'])) $page_info .= 'option_page=' . $_GET['option_page'] . '&';
    if (isset($_GET['value_page'])) $page_info .= 'value_page=' . $_GET['value_page'] . '&';
    if (isset($_GET['attribute_page'])) $page_info .= 'attribute_page=' . $_GET['attribute_page'] . '&';
    if (tep_not_null($page_info)) {
      $page_info = substr($page_info, 0, -1);
    }

    switch ($action) {
      case 'add_product_options':
        $products_options_id = tep_db_prepare_input($_POST['products_options_id']);
        $option_name_array = $_POST['option_name'];
        $option_type = $_POST['option_type'];	//clr 030714 update to add option type to products_option
		  $option_length = $_POST['option_length'];	//clr 030714 update to add option length to products_option
        for ($i=0, $n=sizeof($languages); $i<$n; $i ++) {
        $option_name = tep_db_prepare_input($option_name_array[$languages[$i]['id']]);
		  $option_comment = $_POST['option_comment'];
   	  $option_sort_order = $_POST['option_sort_order'];	//clr 030714 update to add option comment to products_option

          tep_db_query("insert into " . TABLE_PRODUCTS_OPTIONS . " (products_options_id, products_options_name, language_id, products_options_type, products_options_length, products_options_comment, products_options_sort_order) values ('" . (int)$products_options_id . "', '" . tep_db_input($option_name) . "', '" . (int)$languages[$i]['id'] . "', '" . $option_type . "', '" . $option_length . "', '" . $option_comment[$languages[$i]['id']]  . "', '" . $option_sort_order[$languages[$i]['id']] . "')");
        }
        tep_redirect(tep_href_link(FILENAME_PRODUCTS_ATTRIBUTES, $page_info));
        break;
      case 'add_product_option_values':
        $value_name_array = $_POST['value_name'];
        $value_id = tep_db_prepare_input($_POST['value_id']);
        $option_id = tep_db_prepare_input($_POST['option_id']);

        for ($i=0, $n=sizeof($languages); $i<$n; $i ++) {
          $value_name = tep_db_prepare_input($value_name_array[$languages[$i]['id']]);

          tep_db_query("insert into " . TABLE_PRODUCTS_OPTIONS_VALUES . " (products_options_values_id, language_id, products_options_values_name) values ('" . (int)$value_id . "', '" . (int)$languages[$i]['id'] . "', '" . tep_db_input($value_name) . "')");
        }

        tep_db_query("insert into " . TABLE_PRODUCTS_OPTIONS_VALUES_TO_PRODUCTS_OPTIONS . " (products_options_id, products_options_values_id) values ('" . (int)$option_id . "', '" . (int)$value_id . "')");

        tep_redirect(tep_href_link(FILENAME_PRODUCTS_ATTRIBUTES, $page_info));
        break;
      case 'add_product_attributes':
        $products_id = tep_db_prepare_input($_POST['products_id']);
        $options_id = tep_db_prepare_input($_POST['options_id']);
        $values_id = tep_db_prepare_input($_POST['values_id']);
        $value_price = tep_db_prepare_input($_POST['value_price']);
        $price_prefix = tep_db_prepare_input($_POST['price_prefix']);

// BOF: WebMakers.com Added: Attribute Sorter
// OLD        tep_db_query("insert into " . TABLE_PRODUCTS_ATTRIBUTES . " values ('', '" . $_POST['products_id'] . "', '" . $_POST['options_id'] . "', '" . $_POST['values_id'] . "', '" . $_POST['value_price'] . "', '" . $_POST['price_prefix'] . "', '" . $_POST['sort_order'] . "', '" . $_POST['product_attributes_one_time']  . "')");
        tep_db_query("insert into " . TABLE_PRODUCTS_ATTRIBUTES . " values (null, '" . $_POST['products_id'] . "', '" . $_POST['options_id'] . "', '" . $_POST['values_id'] . "', '" . $_POST['value_price'] . "', '" . $_POST['price_prefix'] . "', '" . $_POST['sort_order'] . "', '" . $_POST['product_attributes_one_time'] . "', '" . $_POST['products_attributes_weight'] . "', '" . $_POST['products_attributes_weight_prefix'] . "', '" . $_POST['products_attributes_units'] . "', '" . $_POST['products_attributes_units_price'] . "' )");
// EOF: WebMakers.com Added: Attribute Sorter
        if (DOWNLOAD_ENABLED == 'true') {
          $products_attributes_id = tep_db_insert_id();

          $products_attributes_filename = tep_db_prepare_input($_POST['products_attributes_filename']);
          $products_attributes_maxdays = tep_db_prepare_input($_POST['products_attributes_maxdays']);
          $products_attributes_maxcount = tep_db_prepare_input($_POST['products_attributes_maxcount']);

 //PIN add
		  $products_attributes_is_pin = isset($_POST['products_attributes_is_pin'])?1:0;
//PIN end

  	  //PIN change
          if (tep_not_null($products_attributes_filename)) {
            tep_db_query("insert into " . TABLE_PRODUCTS_ATTRIBUTES_DOWNLOAD . " values (" . (int)$products_attributes_id . ", '" . tep_db_input($products_attributes_filename) . "', '" . tep_db_input($products_attributes_maxdays) . "', '" . tep_db_input($products_attributes_maxcount) . "', '".$products_attributes_is_pin."')");
          }
        }

        tep_redirect(tep_href_link(FILENAME_PRODUCTS_ATTRIBUTES, $page_info));
        break;
      case 'update_option_name':
        $option_name_array = $_POST['option_name'];
	    $option_type = $_POST['option_type'];	//clr 030714 update to add option type to products_option
	    $option_length = $_POST['option_length'];	//clr 030714 update to add option length to products_option
        $option_id = tep_db_prepare_input($_POST['option_id']);

        for ($i=0, $n=sizeof($languages); $i<$n; $i ++) {
          $option_name = tep_db_prepare_input($option_name_array[$languages[$i]['id']]);	
   		 $option_comment = $_POST['option_comment'];	
   		 $option_sort_order = $_POST['option_sort_order'];	
   		 
          tep_db_query("update " . TABLE_PRODUCTS_OPTIONS . " set products_options_name = '" . tep_db_input($option_name) . "', products_options_sort_order = '" . $option_sort_order[$languages[$i]['id']] . "', products_options_type = '" . $option_type . "', products_options_length = '" . $option_length . "', products_options_comment = '" . $option_comment[$languages[$i]['id']] . "' where products_options_id = '" . (int)$option_id . "' and language_id = '" . (int)$languages[$i]['id'] . "'");
        }

        tep_redirect(tep_href_link(FILENAME_PRODUCTS_ATTRIBUTES, $page_info));
        break;
      case 'update_value':
        $value_name_array = $_POST['value_name'];
        $value_id = tep_db_prepare_input($_POST['value_id']);
        $option_id = tep_db_prepare_input($_POST['option_id']);

        for ($i=0, $n=sizeof($languages); $i<$n; $i ++) {
          $value_name = tep_db_prepare_input($value_name_array[$languages[$i]['id']]);

          tep_db_query("update " . TABLE_PRODUCTS_OPTIONS_VALUES . " set products_options_values_name = '" . tep_db_input($value_name) . "' where products_options_values_id = '" . tep_db_input($value_id) . "' and language_id = '" . (int)$languages[$i]['id'] . "'");
        }

        tep_db_query("update " . TABLE_PRODUCTS_OPTIONS_VALUES_TO_PRODUCTS_OPTIONS . " set products_options_id = '" . (int)$option_id . "'  where products_options_values_id = '" . (int)$value_id . "'");

        tep_redirect(tep_href_link(FILENAME_PRODUCTS_ATTRIBUTES, $page_info));
        break;
      case 'update_product_attribute':
        $products_id = tep_db_prepare_input($_POST['products_id']);
        $options_id = tep_db_prepare_input($_POST['options_id']);
        $values_id = tep_db_prepare_input($_POST['values_id']);
        $value_price = tep_db_prepare_input($_POST['value_price']);
        $price_prefix = tep_db_prepare_input($_POST['price_prefix']);
        $attribute_id = tep_db_prepare_input($_POST['attribute_id']);

// BOF: WebMakers.com Added: Attribute Sorter
// OLD  tep_db_query("update " . TABLE_PRODUCTS_ATTRIBUTES . " set products_id = '" . $_POST['products_id'] . "', options_id = '" . $_POST['options_id'] . "', options_values_id = '" . $_POST['values_id'] . "', options_values_price = '" . $_POST['value_price'] . "', price_prefix = '" . $_POST['price_prefix'] . "',  products_options_sort_order = '" . $_POST['sort_order'] . "',  product_attributes_one_time = '" . $_POST['product_attributes_one_time'] . "' where products_attributes_id = '" . $_POST['attribute_id'] . "'");
        tep_db_query("update " . TABLE_PRODUCTS_ATTRIBUTES . " set products_id = '" . $_POST['products_id'] . "', options_id = '" . $_POST['options_id'] . "', options_values_id = '" . $_POST['values_id'] . "', options_values_price = '" . $_POST['value_price'] . "', price_prefix = '" . $_POST['price_prefix'] . "', products_options_sort_order = '" . $_POST['sort_order'] . "', product_attributes_one_time = '" . $_POST['product_attributes_one_time'] . "', products_attributes_weight = '" . $_POST['products_attributes_weight'] . "', products_attributes_weight_prefix = '" . $_POST['products_attributes_weight_prefix'] . "', products_attributes_units = '" . $_POST['products_attributes_units'] . "', products_attributes_units_price = '" . $_POST['products_attributes_units_price'] . "' where products_attributes_id = '" . $_POST['attribute_id'] . "'");
// EOF: WebMakers.com Added: Attribute Sorter
        if ((DOWNLOAD_ENABLED == 'true') && $_POST['products_attributes_filename'] != '') {
          tep_db_query("update " . TABLE_PRODUCTS_ATTRIBUTES_DOWNLOAD . "
                        set products_attributes_filename='" . $_POST['products_attributes_filename'] . "',
                            products_attributes_maxdays='" . $_POST['products_attributes_maxdays'] . "',
                            products_attributes_maxcount='" . $_POST['products_attributes_maxcount'] . "',
                            products_attributes_is_pin='" . $_POST['products_attributes_is_pin'] . "'
                        where products_attributes_id = '" . $_POST['attribute_id'] . "'");
        }
        tep_redirect(tep_href_link(FILENAME_PRODUCTS_ATTRIBUTES, $page_info));
        break;
      case 'delete_option':
        $option_id = tep_db_prepare_input($_GET['option_id']);

        tep_db_query("delete from " . TABLE_PRODUCTS_OPTIONS . " where products_options_id = '" . (int)$option_id . "'");

        tep_redirect(tep_href_link(FILENAME_PRODUCTS_ATTRIBUTES, $page_info));
        break;
      case 'delete_value':
        $value_id = tep_db_prepare_input($_GET['value_id']);

        tep_db_query("delete from " . TABLE_PRODUCTS_OPTIONS_VALUES . " where products_options_values_id = '" . (int)$value_id . "'");
        tep_db_query("delete from " . TABLE_PRODUCTS_OPTIONS_VALUES . " where products_options_values_id = '" . (int)$value_id . "'");
        tep_db_query("delete from " . TABLE_PRODUCTS_OPTIONS_VALUES_TO_PRODUCTS_OPTIONS . " where products_options_values_id = '" . (int)$value_id . "'");

        tep_redirect(tep_href_link(FILENAME_PRODUCTS_ATTRIBUTES, $page_info));
        break;
      case 'delete_attribute':
        $attribute_id = tep_db_prepare_input($_GET['attribute_id']);

        tep_db_query("delete from " . TABLE_PRODUCTS_ATTRIBUTES . " where products_attributes_id = '" . (int)$attribute_id . "'");

// added for DOWNLOAD_ENABLED. Always try to remove attributes, even if downloads are no longer enabled
        tep_db_query("delete from " . TABLE_PRODUCTS_ATTRIBUTES_DOWNLOAD . " where products_attributes_id = '" . (int)$attribute_id . "'");

        tep_redirect(tep_href_link(FILENAME_PRODUCTS_ATTRIBUTES, $page_info));
        break;
    }
  }

//CLR 030312 add function to draw pulldown list of option types
// Draw a pulldown for Option Types
function draw_optiontype_pulldown($name, $default = '') {
  $values = array();
  $values[] = array('id' => 0, 'text' => 'Select');
  $values[] = array('id' => 1, 'text' => 'Text');
  $values[] = array('id' => 2, 'text' => 'Radio');
  $values[] = array('id' => 3, 'text' => 'Checkbox');
  $values[] = array('id' => 4, 'text' => 'Textarea');
  return tep_draw_pull_down_menu($name, $values, $default);
}

//CLR 030312 add function to translate type_id to name
// Translate option_type_values to english string
function translate_type_to_name($opt_type) {
  if ($opt_type == 0) return 'Select';
  if ($opt_type == 1) return 'Text';
  if ($opt_type == 2) return 'Radio';
  if ($opt_type == 3) return 'Checkbox';
  if ($opt_type == 4) return 'Textarea';
  return 'Error ' . $opt_type;
}

?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<title><?php echo TITLE; ?></title>
<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
<script language="javascript"><!--
function go_option() {
  if (document.option_order_by.selected.options[document.option_order_by.selected.selectedIndex].value != "none") {
    location = "<?php echo tep_href_link(FILENAME_PRODUCTS_ATTRIBUTES, 'option_page=' . ($_GET['option_page'] ? $_GET['option_page'] : 1)); ?>&option_order_by="+document.option_order_by.selected.options[document.option_order_by.selected.selectedIndex].value;
  }
}
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
    <td width="100%" valign="top"><table class="table-padding-0">
<!-- options and values//-->
      <tr>
        <td width="100%"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top" width="50%"><table width="100%" border="0" cellspacing="0" cellpadding="2">
<!-- options //-->
<?php
  if ($action == 'delete_product_option') { // delete product option
    $options = tep_db_query("select products_options_id, products_options_name from " . TABLE_PRODUCTS_OPTIONS . " where products_options_id = '" . (int)$_GET['option_id'] . "' and language_id = '" . (int)$languages_id . "'");
    $options_values = tep_db_fetch_array($options);
?>
              <tr>
                <td class="pageHeading">&nbsp;<?php echo $options_values['products_options_name']; ?>&nbsp;</td>
                <td>&nbsp;<?php echo tep_image(DIR_WS_IMAGES . 'pixel_trans.gif', '', '1', '53'); ?>&nbsp;</td>
              </tr>
              <tr>
                <td><table class="table-padding-2">
                  <tr>
                    <td colspan="3"><?php echo tep_black_line(); ?></td>
                  </tr>
<?php
    $products = tep_db_query("select p.products_id, pd.products_name, pov.products_options_values_name from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_OPTIONS_VALUES . " pov, " . TABLE_PRODUCTS_ATTRIBUTES . " pa, " . TABLE_PRODUCTS_DESCRIPTION . " pd where pd.products_id = p.products_id and pov.language_id = '" . (int)$languages_id . "' and pd.language_id = '" . (int)$languages_id . "' and pa.products_id = p.products_id and pa.options_id='" . (int)$_GET['option_id'] . "' and pov.products_options_values_id = pa.options_values_id order by pd.products_name");
    if (tep_db_num_rows($products)) {
?>
                  <tr class="dataTableHeadingRow">
                    <td class="dataTableHeadingContent" align="center">&nbsp;<?php echo TABLE_HEADING_ID; ?>&nbsp;</td>
                    <td class="dataTableHeadingContent">&nbsp;<?php echo TABLE_HEADING_PRODUCT; ?>&nbsp;</td>
                    <td class="dataTableHeadingContent">&nbsp;<?php echo TABLE_HEADING_OPT_VALUE; ?>&nbsp;</td>
                  </tr>
                  <tr>
                    <td colspan="3"><?php echo tep_black_line(); ?></td>
                  </tr>
<?php
      $rows = 0;
      while ($products_values = tep_db_fetch_array($products)) {
        $rows++;
?>
                  <tr class="<?php echo (floor($rows/2) == ($rows/2) ? 'attributes-even' : 'attributes-odd'); ?>">
                    <td align="center" class="smallText">&nbsp;<?php echo $products_values['products_id']; ?>&nbsp;</td>
                    <td class="smallText">&nbsp;<?php echo $products_values['products_name']; ?>&nbsp;</td>
                    <td class="smallText">&nbsp;<?php echo $products_values['products_options_values_name']; ?>&nbsp;</td>
                  </tr>
<?php
      }
?>
                  <tr>
                    <td colspan="3"><?php echo tep_black_line(); ?></td>
                  </tr>
                  <tr>
                    <td colspan="3" class="main"><br><?php echo TEXT_WARNING_OF_DELETE; ?></td>
                  </tr>
                  <tr>
                    <td align="right" colspan="3" class="main"><br><?php echo '<a href="' . tep_href_link(FILENAME_PRODUCTS_ATTRIBUTES, (isset($_GET['value_page']) ? 'value_page=' . $_GET['value_page'] . '&' : '') . (isset($_GET['attribute_page']) ? 'attribute_page=' . $_GET['attribute_page'] : ''), 'NONSSL') . '">'; ?><?php echo tep_image_button('button_cancel.gif', ' cancel '); ?></a>&nbsp;</td>
                  </tr>
<?php
    } else {
?>
                  <tr>
                    <td class="main" colspan="3"><br><?php echo TEXT_OK_TO_DELETE; ?></td>
                  </tr>
                  <tr>
                    <td class="main" align="right" colspan="3"><br><?php echo '<a href="' . tep_href_link(FILENAME_PRODUCTS_ATTRIBUTES, 'action=delete_option&option_id=' . $_GET['option_id'], 'NONSSL') . '">'; ?><?php echo tep_image_button('button_delete.gif', ' delete '); ?></a>&nbsp;&nbsp;&nbsp;<?php echo '<a href="' . tep_href_link(FILENAME_PRODUCTS_ATTRIBUTES, (isset($_GET['order_by']) ? 'order_by=' . $_GET['order_by'] . '&' : '') . (isset($_GET['page']) ? 'page=' . $_GET['page'] : ''), 'NONSSL') . '">'; ?><?php echo tep_image_button('button_cancel.gif', ' cancel '); ?></a>&nbsp;</td>
                  </tr>
<?php
    }
?>
                </table></td>
              </tr>
<?php
  } else {
    if (isset($_GET['option_order_by'])) {
      $option_order_by = $_GET['option_order_by'];
    } else {
      $option_order_by = 'products_options_id';
    }
?>
              <tr>
                <td colspan="2" class="pageHeading">&nbsp;<?php echo HEADING_TITLE_OPT; ?>&nbsp;</td>
                <td align="right"><br><form name="option_order_by" action="<?php echo FILENAME_PRODUCTS_ATTRIBUTES; ?>"><select name="selected" onChange="go_option()"><option value="products_options_id"<?php if ($option_order_by == 'products_options_id') { echo ' SELECTED'; } ?>><?php echo TEXT_OPTION_ID; ?></option><option value="products_options_name"<?php if ($option_order_by == 'products_options_name') { echo ' SELECTED'; } ?>><?php echo TEXT_OPTION_NAME; ?></option></select></form></td>
              </tr>
              <tr>
                <td colspan="3" class="smallText">
<?php
    $per_page = MAX_ROW_LISTS_OPTIONS;
    $options = "select * from " . TABLE_PRODUCTS_OPTIONS . " where language_id = '" . (int)$languages_id . "' order by " . $option_order_by;
    if (!isset($option_page)) {
      $option_page = 1;
    }
    $prev_option_page = $option_page - 1;
    $next_option_page = $option_page + 1;

    $option_query = tep_db_query($options);

    $option_page_start = ($per_page * $option_page) - $per_page;
    $num_rows = tep_db_num_rows($option_query);

    if ($num_rows <= $per_page) {
      $num_pages = 1;
    } else if (($num_rows % $per_page) == 0) {
      $num_pages = ($num_rows / $per_page);
    } else {
      $num_pages = ($num_rows / $per_page) + 1;
    }
    $num_pages = (int) $num_pages;

    $options = $options . " LIMIT $option_page_start, $per_page";

    // Previous
    if ($prev_option_page)  {
      echo '<a href="' . tep_href_link(FILENAME_PRODUCTS_ATTRIBUTES, 'option_page=' . $prev_option_page) . '"> &lt;&lt; </a> | ';
    }

    for ($i = 1; $i <= $num_pages; $i++) {
      if ($i != $option_page) {
        echo '<a href="' . tep_href_link(FILENAME_PRODUCTS_ATTRIBUTES, 'option_page=' . $i) . '">' . $i . '</a> | ';
      } else {
        echo '<b><font color=red>' . $i . '</font></b> | ';
      }
    }

    // Next
    if ($option_page != $num_pages) {
      echo '<a href="' . tep_href_link(FILENAME_PRODUCTS_ATTRIBUTES, 'option_page=' . $next_option_page) . '"> &gt;&gt; </a>';
    }
//CLR 030212 - Add column for option type
?>
                </td>
              </tr>
              <tr>
                <td colspan="7"><?php echo tep_black_line(); ?></td>
              </tr>
              <tr class="dataTableHeadingRow">
                <td class="dataTableHeadingContent">&nbsp;<?php echo TABLE_HEADING_ID; ?>&nbsp;</td>
                <td class="dataTableHeadingContent">&nbsp;<?php echo TABLE_HEADING_OPT_NAME; ?>&nbsp;</td>
				<td class="dataTableHeadingContent">&nbsp;<?php echo TABLE_HEADING_OPT_TYPE; ?>&nbsp;</td>	<!-- CLR 030212 - Add column for option type //-->
    			<td class="dataTableHeadingContent">&nbsp;<?php echo TABLE_HEADING_OPT_LENGTH; ?>&nbsp;</td>	<!-- CLR 030212 - Add column for option length //-->
                <td class="dataTableHeadingContent">&nbsp;<?php echo TABLE_HEADING_OPT_COMMENT; ?>&nbsp;</td>	<!-- CLR 030212 - Add column for option comment //-->
                <td class="dataTableHeadingContent" align="right">&nbsp;<?php echo TABLE_HEADING_OPTION_SORT_ORDER; ?>&nbsp;</td>
                <td class="dataTableHeadingContent" align="center">&nbsp;<?php echo TABLE_HEADING_ACTION; ?>&nbsp;</td>
              </tr>
              <tr>
                <td colspan="7"><?php echo tep_black_line(); ?></td>
              </tr>
<?php
    $next_id = 1;
    $rows = 0;
    $options = tep_db_query($options);
    while ($options_values = tep_db_fetch_array($options)) {
      $rows++;
?>
              <tr class="<?php echo (floor($rows/2) == ($rows/2) ? 'attributes-even' : 'attributes-odd'); ?>">
<?php
      if (($action == 'update_option') && ($_GET['option_id'] == $options_values['products_options_id'])) {
        echo '<form name="option" action="' . tep_href_link(FILENAME_PRODUCTS_ATTRIBUTES, 'action=update_option_name', 'NONSSL') . '" method="post">';
        $inputs = '';
        for ($i = 0, $n = sizeof($languages); $i < $n; $i ++) {
// WebMakers.com Added: Product Options Sort Order        
          $option_name = tep_db_query("select products_options_name, products_options_sort_order, products_options_length, products_options_comment from " . TABLE_PRODUCTS_OPTIONS . " where products_options_id = '" . $options_values['products_options_id'] . "' and language_id = '" . $languages[$i]['id'] . "'");
          $option_name = tep_db_fetch_array($option_name);
 		  $inputs .= TABLE_HEADING_OPT_NAME . ' (' . $languages[$i]['code'] . '):&nbsp;<input type="text" name="option_name[' . $languages[$i]['id'] . ']" size="32" value="' . $option_name['products_options_name'] . '"><br>' . TABLE_HEADING_OPT_COMMENT . ':<br> <input type="text" name="option_comment[' . $languages[$i]['id'] . ']" size="32" value="' . $option_name['products_options_comment'] . '"><br>' . TEXT_OPTION_SORT_ORDER . ' <input type="text" name="option_sort_order[' . $languages[$i]['id'] . ']" size="3" value="' . $option_name['products_options_sort_order'] . '"><br>';
        }
//CLR 030212 - Add column for option type
?>
                <td align="center" class="smallText">&nbsp;<?php echo $options_values['products_options_id']; ?><input type="hidden" name="option_id" value="<?php echo $options_values['products_options_id']; ?>">&nbsp;</td>
				<td class="smallText" colspan="3"><?php echo $inputs; ?></td>
				<td class="smallText"><?php echo TABLE_HEADING_OPT_LENGTH . ' <input type="text" name="option_length" size="4" value="' . $option_name['products_options_length'] . '">'; ?></td>	<!-- CLR 030212 - Add column for option length //-->
				<td class="smallText"><?php echo TABLE_HEADING_OPT_TYPE . '<br>' . draw_optiontype_pulldown('option_type', $options_values['products_options_type']); ?></td>	<!-- CLR 030212 - Add column for option type //-->
                <td align="center" class="smallText">&nbsp;<?php echo tep_image_submit('button_update.gif', IMAGE_UPDATE); ?>&nbsp;<?php echo '<a href="' . tep_href_link(FILENAME_PRODUCTS_ATTRIBUTES, '', 'NONSSL') . '">'; ?><?php echo tep_image_button('button_cancel.gif', IMAGE_CANCEL); ?></a>&nbsp;</td>
<?php
        echo '</form>' . "\n";
      } else {
//CLR 030212 - Add column for option type
// WebMakers.com Added: Product Options Sort Order
?>
                <td align="center" class="smallText">&nbsp;<?php echo $options_values["products_options_id"]; ?>&nbsp;</td>
                <td class="smallText">&nbsp;<?php echo $options_values["products_options_name"]; ?>&nbsp;</td>
                <td class="smallText">&nbsp;<?php echo translate_type_to_name($options_values["products_options_type"]); ?>&nbsp;</td> <!-- CLR 030212 - Add column for option type //-->
				<td class="smallText">&nbsp;<?php echo $options_values["products_options_length"]; ?>&nbsp;</td>	<!-- CLR 030212 - Add column for option length //-->
				<td class="smallText">&nbsp;<?php echo $options_values["products_options_comment"]; ?>&nbsp;</td>	<!-- CLR 030212 - Add column for option comment //-->
                <td class="smallText" align="right">&nbsp;<?php echo $options_values["products_options_sort_order"]; ?>&nbsp;</td>
                <td align="center" class="smallText">&nbsp;<?php echo '<a href="' . tep_href_link(FILENAME_PRODUCTS_ATTRIBUTES, 'action=update_option&option_id=' . $options_values['products_options_id'] . '&option_order_by=' . $option_order_by . '&option_page=' . $option_page, 'NONSSL') . '">'; ?><?php echo tep_image_button('button_edit.gif', IMAGE_UPDATE); ?></a>&nbsp;&nbsp;<?php echo '<a href="' . tep_href_link(FILENAME_PRODUCTS_ATTRIBUTES, 'action=delete_product_option&option_id=' . $options_values['products_options_id'], 'NONSSL') , '">'; ?><?php echo tep_image_button('button_delete.gif', IMAGE_DELETE); ?></a>&nbsp;</td>
<?php
      }
?>
              </tr>
<?php
      $max_options_id_query = tep_db_query("select max(products_options_id) + 1 as next_id from " . TABLE_PRODUCTS_OPTIONS);
      $max_options_id_values = tep_db_fetch_array($max_options_id_query);
      $next_id = $max_options_id_values['next_id'];
    }
?>
              <tr>
                <td colspan="7"><?php echo tep_black_line(); ?></td>
              </tr>
<?php
    if ($action != 'update_option') {
?>
              <tr class="<?php echo (floor($rows/2) == ($rows/2) ? 'attributes-even' : 'attributes-odd'); ?>">
<?php
// WebMakers.com Added: Product Options Sort Order
      echo '<form name="options" action="' . tep_href_link(FILENAME_PRODUCTS_ATTRIBUTES, 'action=add_product_options&option_page=' . $option_page, 'NONSSL') . '" method="post"><input type="hidden" name="products_options_id" value="' . $next_id . '">';
      $inputs = '';
      for ($i = 0, $n = sizeof($languages); $i < $n; $i ++) {
		$inputs .= $languages[$i]['code'] . ':&nbsp;<input type="text" name="option_name[' . $languages[$i]['id'] . ']" size="32"><br>' . TABLE_HEADING_OPT_COMMENT . ' <input type="text" name="option_comment[' . $languages[$i]['id'] . ']" size="32"><br>' . TEXT_OPTION_SORT_ORDER . '  <input type="text" name="option_sort_order[' . $languages[$i]['id'] . ']" size="3">&nbsp;<br>';
      }
//CLR 030212 - Add column for option type
?>
                <td align="center" class="smallText">&nbsp;<?php echo $next_id; ?>&nbsp;</td>
                <td class="smallText" colspan="2"><?php echo $inputs; ?></td>
		<td class="smallText"><?php echo TABLE_HEADING_OPT_LENGTH . ' <input type="text" name="option_length" size="4" value="' . $option_name['products_options_length'] . '">'; ?></td>	<!-- CLR 030212 - Add column for option length //-->
		<td class="smallText"><?php echo TABLE_HEADING_OPT_TYPE . ' ' . draw_optiontype_pulldown('option_type'); ?></td>	<!-- CLR 030212 - Add column for option type //-->
                <td align="center" class="smallText">&nbsp;<?php echo tep_image_submit('button_insert.gif', IMAGE_INSERT); ?>&nbsp;</td>
<?php
      echo '</form>';
?>
              </tr>
              <tr>
                <td colspan="7"><?php echo tep_black_line(); ?></td>
              </tr>
<?php
    }
  }
?>
            </table></td>
<!-- options eof //-->
          </tr>
          </table>
          <table class="table-padding-2">
          <tr>
            <td valign="top" width="50%"><table width="100%" border="0" cellspacing="0" cellpadding="2">
<!-- value //-->
<?php
  if ($action == 'delete_option_value') { // delete product option value
    $values = tep_db_query("select products_options_values_id, products_options_values_name from " . TABLE_PRODUCTS_OPTIONS_VALUES . " where products_options_values_id = '" . (int)$_GET['value_id'] . "' and language_id = '" . (int)$languages_id . "'");
    $values_values = tep_db_fetch_array($values);
?>
              <tr>
                <td colspan="3" class="pageHeading">&nbsp;<?php echo $values_values['products_options_values_name']; ?>&nbsp;</td>
                <td>&nbsp;<?php echo tep_image(DIR_WS_IMAGES . 'pixel_trans.gif', '', '1', '53'); ?>&nbsp;</td>
              </tr>
              <tr>
                <td><table class="table-padding-2">
                  <tr>
                    <td colspan="3"><?php echo tep_black_line(); ?></td>
                  </tr>
<?php
    $products = tep_db_query("select p.products_id, pd.products_name, po.products_options_name from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_ATTRIBUTES . " pa, " . TABLE_PRODUCTS_OPTIONS . " po, " . TABLE_PRODUCTS_DESCRIPTION . " pd where pd.products_id = p.products_id and pd.language_id = '" . (int)$languages_id . "' and po.language_id = '" . (int)$languages_id . "' and pa.products_id = p.products_id and pa.options_values_id='" . (int)$_GET['value_id'] . "' and po.products_options_id = pa.options_id order by pd.products_name");
    if (tep_db_num_rows($products)) {
?>
                  <tr class="dataTableHeadingRow">
                    <td class="dataTableHeadingContent" align="center">&nbsp;<?php echo TABLE_HEADING_ID; ?>&nbsp;</td>
                    <td class="dataTableHeadingContent">&nbsp;<?php echo TABLE_HEADING_PRODUCT; ?>&nbsp;</td>
                    <td class="dataTableHeadingContent" align="right">&nbsp;<?php echo TABLE_HEADING_OPTION_SORT_ORDER; ?>&nbsp;</td>
                    <td class="dataTableHeadingContent">&nbsp;<?php echo TABLE_HEADING_OPT_NAME; ?>&nbsp;</td>
                  </tr>
                  <tr>
                    <td colspan="3"><?php echo tep_black_line(); ?></td>
                  </tr>
<?php
      while ($products_values = tep_db_fetch_array($products)) {
        $rows++;
?>
                  <tr class="<?php echo (floor($rows/2) == ($rows/2) ? 'attributes-even' : 'attributes-odd'); ?>">
                    <td align="center" class="smallText">&nbsp;<?php echo $products_values['products_id']; ?>&nbsp;</td>
                    <td class="smallText">&nbsp;<?php echo $products_values['products_name']; ?>&nbsp;</td>
                    <td class="smallText" align="right">&nbsp;<?php echo $options_values["products_options_sort_order"]; ?>&nbsp;</td>
                    <td class="smallText">&nbsp;<?php echo $products_values['products_options_name']; ?>&nbsp;</td>
                  </tr>
<?php
      }
?>
                  <tr>
                    <td colspan="3"><?php echo tep_black_line(); ?></td>
                  </tr>
                  <tr>
                    <td class="main" colspan="3"><br><?php echo TEXT_WARNING_OF_DELETE; ?></td>
                  </tr>
                  <tr>
                    <td class="main" align="right" colspan="3"><br><?php echo '<a href="' . tep_href_link(FILENAME_PRODUCTS_ATTRIBUTES, (isset($_GET['value_page']) ? 'value_page=' . $_GET['value_page'] . '&' : '') . (isset($_GET['attribute_page']) ? 'attribute_page=' . $attribute_page : ''), 'NONSSL') . '">'; ?><?php echo tep_image_button('button_cancel.gif', ' cancel '); ?></a>&nbsp;</td>
                  </tr>
<?php
    } else {
?>
                  <tr>
                    <td class="main" colspan="3"><br><?php echo TEXT_OK_TO_DELETE; ?></td>
                  </tr>
                  <tr>
                    <td class="main" align="right" colspan="3"><br><?php echo '<a href="' . tep_href_link(FILENAME_PRODUCTS_ATTRIBUTES, 'action=delete_value&value_id=' . $_GET['value_id'], 'NONSSL') . '">'; ?><?php echo tep_image_button('button_delete.gif', ' delete '); ?></a>&nbsp;&nbsp;&nbsp;<?php echo '<a href="' . tep_href_link(FILENAME_PRODUCTS_ATTRIBUTES, '&option_page=' . $option_page . (isset($_GET['value_page']) ? '&value_page=' . $value_page : '') . (isset($_GET['attribute_page']) ? '&attribute_page=' . $attribute_page : ''), 'NONSSL') . '">'; ?><?php echo tep_image_button('button_cancel.gif', ' cancel '); ?></a>&nbsp;</td>
                  </tr>
<?php
    }
?>
              	</table></td>
              </tr>
<?php
  } else {
?>
              <tr>
                <td colspan="3" class="pageHeading">&nbsp;<?php echo HEADING_TITLE_VAL; ?>&nbsp;</td>
                <td>&nbsp;<?php echo tep_image(DIR_WS_IMAGES . 'pixel_trans.gif', '', '1', '53'); ?>&nbsp;</td>
              </tr>
              <tr>
                <td colspan="5" class="smallText">
<?php
    $per_page = MAX_ROW_LISTS_OPTIONS;
    $values = "select pov.products_options_values_id, pov.products_options_values_name, pov2po.products_options_id from " . TABLE_PRODUCTS_OPTIONS_VALUES . " pov left join " . TABLE_PRODUCTS_OPTIONS_VALUES_TO_PRODUCTS_OPTIONS . " pov2po on pov.products_options_values_id = pov2po.products_options_values_id where pov.language_id = '" . (int)$languages_id . "' order by pov.products_options_values_id";
    if (!isset($value_page)) {
      $value_page = 1;
    }
    $prev_value_page = $value_page - 1;
    $next_value_page = $value_page + 1;

    $value_query = tep_db_query($values);

    $value_page_start = ($per_page * $value_page) - $per_page;
    $num_rows = tep_db_num_rows($value_query);

    if ($num_rows <= $per_page) {
      $num_pages = 1;
    } else if (($num_rows % $per_page) == 0) {
      $num_pages = ($num_rows / $per_page);
    } else {
      $num_pages = ($num_rows / $per_page) + 1;
    }
    $num_pages = (int) $num_pages;

    $values = $values . " LIMIT $value_page_start, $per_page";

    // Previous
    if ($prev_value_page)  {
      echo '<a href="' . tep_href_link(FILENAME_PRODUCTS_ATTRIBUTES, 'option_order_by=' . $option_order_by . '&value_page=' . $prev_value_page) . '"> &lt;&lt; </a> | ';
    }

    for ($i = 1; $i <= $num_pages; $i++) {
      if ($i != $value_page) {
         echo '<a href="' . tep_href_link(FILENAME_PRODUCTS_ATTRIBUTES, (isset($option_order_by) ? 'option_order_by=' . $option_order_by . '&' : '') . 'value_page=' . $i) . '">' . $i . '</a> | ';
      } else {
         echo '<b><font color=red>' . $i . '</font></b> | ';
      }
    }

    // Next
    if ($value_page != $num_pages) {
      echo '<a href="' . tep_href_link(FILENAME_PRODUCTS_ATTRIBUTES, (isset($option_order_by) ? 'option_order_by=' . $option_order_by . '&' : '') . 'value_page=' . $next_value_page) . '"> &gt;&gt;</a> ';
    }
?>
                </td>
              </tr>
              <tr>
                <td colspan="4"><?php echo tep_black_line(); ?></td>
              </tr>
              <tr class="dataTableHeadingRow">
                <td class="dataTableHeadingContent">&nbsp;<?php echo TABLE_HEADING_ID; ?>&nbsp;</td>
                <td class="dataTableHeadingContent">&nbsp;<?php echo TABLE_HEADING_OPT_NAME; ?>&nbsp;</td>
                <td class="dataTableHeadingContent">&nbsp;<?php echo TABLE_HEADING_OPT_VALUE; ?>&nbsp;</td>
                <td class="dataTableHeadingContent" align="center">&nbsp;<?php echo TABLE_HEADING_ACTION; ?>&nbsp;</td>
              </tr>
              <tr>
                <td colspan="4"><?php echo tep_black_line(); ?></td>
              </tr>
<?php
    $next_id = 1;
    $rows = 0;
    $values = tep_db_query($values);
    while ($values_values = tep_db_fetch_array($values)) {
      $options_name = tep_options_name($values_values['products_options_id']);
      $values_name = $values_values['products_options_values_name'];
      $rows++;
?>
              <tr class="<?php echo (floor($rows/2) == ($rows/2) ? 'attributes-even' : 'attributes-odd'); ?>">
<?php
      if (($action == 'update_option_value') && ($_GET['value_id'] == $values_values['products_options_values_id'])) {
        echo '<form name="values" action="' . tep_href_link(FILENAME_PRODUCTS_ATTRIBUTES, 'action=update_value', 'NONSSL') . '" method="post">';
        $inputs = '';
        for ($i = 0, $n = sizeof($languages); $i < $n; $i ++) {
          $value_name = tep_db_query("select products_options_values_name from " . TABLE_PRODUCTS_OPTIONS_VALUES . " where products_options_values_id = '" . (int)$values_values['products_options_values_id'] . "' and language_id = '" . (int)$languages[$i]['id'] . "'");
          $value_name = tep_db_fetch_array($value_name);
          $inputs .= $languages[$i]['code'] . ':&nbsp;<input type="text" name="value_name[' . $languages[$i]['id'] . ']" size="15" value="' . $value_name['products_options_values_name'] . '">&nbsp;<br>';
        }
?>
                <td align="center" class="smallText">&nbsp;<?php echo $values_values['products_options_values_id']; ?><input type="hidden" name="value_id" value="<?php echo $values_values['products_options_values_id']; ?>">&nbsp;</td>
                <td align="center" class="smallText">&nbsp;<?php echo "\n"; ?><select name="option_id">
<?php
        $options = tep_db_query("select products_options_id, products_options_name from " . TABLE_PRODUCTS_OPTIONS . " where language_id = '" . (int)$languages_id . "' order by products_options_name");
        while ($options_values = tep_db_fetch_array($options)) {
          echo "\n" . '<option name="' . $options_values['products_options_name'] . '" value="' . $options_values['products_options_id'] . '"';
          if ($values_values['products_options_id'] == $options_values['products_options_id']) {
            echo ' selected';
          }
          echo '>' . $options_values['products_options_name'] . '</option>';
        }
?>
                </select>&nbsp;</td>
                <td class="smallText"><?php echo $inputs; ?></td>
                <td align="center" class="smallText">&nbsp;<?php echo tep_image_submit('button_update.gif', IMAGE_UPDATE); ?>&nbsp;<?php echo '<a href="' . tep_href_link(FILENAME_PRODUCTS_ATTRIBUTES, '', 'NONSSL') . '">'; ?><?php echo tep_image_button('button_cancel.gif', IMAGE_CANCEL); ?></a>&nbsp;</td>
<?php
        echo '</form>';
      } else {
?>
                <td align="center" class="smallText">&nbsp;<?php echo $values_values["products_options_values_id"]; ?>&nbsp;</td>
                <td align="center" class="smallText">&nbsp;<?php echo $options_name; ?>&nbsp;</td>
                <td class="smallText">&nbsp;<?php echo $values_name; ?>&nbsp;</td>
                <td align="center" class="smallText">&nbsp;<?php echo '<a href="' . tep_href_link(FILENAME_PRODUCTS_ATTRIBUTES, 'action=update_option_value&value_id=' . $values_values['products_options_values_id'] . (isset($_GET['value_page']) ? '&value_page=' . $_GET['value_page'] : ''), 'NONSSL') . '">'; ?><?php echo tep_image_button('button_edit.gif', IMAGE_UPDATE); ?></a>&nbsp;&nbsp;<?php echo '<a href="' . tep_href_link(FILENAME_PRODUCTS_ATTRIBUTES, 'action=delete_option_value&value_id=' . $values_values['products_options_values_id'], 'NONSSL') , '">'; ?><?php echo tep_image_button('button_delete.gif', IMAGE_DELETE); ?></a>&nbsp;</td>
<?php
      }
      $max_values_id_query = tep_db_query("select max(products_options_values_id) + 1 as next_id from " . TABLE_PRODUCTS_OPTIONS_VALUES);
      $max_values_id_values = tep_db_fetch_array($max_values_id_query);
      $next_id = $max_values_id_values['next_id'];
    }
?>
              </tr>
              <tr>
                <td colspan="4"><?php echo tep_black_line(); ?></td>
              </tr>
<?php
    if ($action != 'update_option_value') {
?>
              <tr class="<?php echo (floor($rows/2) == ($rows/2) ? 'attributes-even' : 'attributes-odd'); ?>">
<?php
      echo '<form name="values" action="' . tep_href_link(FILENAME_PRODUCTS_ATTRIBUTES, 'action=add_product_option_values&value_page=' . $value_page, 'NONSSL') . '" method="post">';
?>
                <td align="center" class="smallText">&nbsp;<?php echo $next_id; ?>&nbsp;</td>
                <td align="center" class="smallText">&nbsp;<select name="option_id">
<?php
      $options = tep_db_query("select products_options_id, products_options_name from " . TABLE_PRODUCTS_OPTIONS . " where language_id = '" . $languages_id . "' order by products_options_name");
      while ($options_values = tep_db_fetch_array($options)) {
        echo '<option name="' . $options_values['products_options_name'] . '" value="' . $options_values['products_options_id'] . '">' . $options_values['products_options_name'] . '</option>';
      }

      $inputs = '';
      for ($i = 0, $n = sizeof($languages); $i < $n; $i ++) {
        $inputs .= $languages[$i]['code'] . ':&nbsp;<input type="text" name="value_name[' . $languages[$i]['id'] . ']" size="15">&nbsp;<br>';
      }
?>
                </select>&nbsp;</td>
                <td class="smallText"><input type="hidden" name="value_id" value="<?php echo $next_id; ?>"><?php echo $inputs; ?></td>
                <td align="center" class="smallText">&nbsp;<?php echo tep_image_submit('button_insert.gif', IMAGE_INSERT); ?>&nbsp;</td>
<?php
      echo '</form>';
?>
              </tr>
              <tr>
                <td colspan="4"><?php echo tep_black_line(); ?></td>
              </tr>
<?php
    }
  }
?>
            </table></td>
          </tr>
        </table></td>
<!-- option value eof //-->
      </tr>
            </table>
      <table class="table-padding-2">
<!-- products_attributes //-->
      <tr>
        <td width="100%"><table class="table-padding-0">
          <tr>
            <td class="pageHeading">&nbsp;<?php echo HEADING_TITLE_ATRIB; ?>&nbsp;</td>
            <td>&nbsp;<?php echo tep_image(DIR_WS_IMAGES . 'pixel_trans.gif', '', '1', '53'); ?>&nbsp;</td>
          </tr>
        </table></td>
      </tr>
      <tr>
<?php
    if ($_GET['action'] == 'update_attribute') {
      $form_action = 'update_product_attribute';
    } else {
      $form_action = 'add_product_attributes';
    }
?>

        <td><form name="attributes" action="<?php echo tep_href_link(FILENAME_PRODUCTS_ATTRIBUTES, 'action=' . $form_action . '&option_page=' . $option_page . '&value_page=' . $value_page . '&attribute_page=' . $attribute_page); ?>" method="post"><table class="table-padding-2">
          <tr>
            <td colspan="10" class="smallText">
<?php
  $per_page = MAX_ROW_LISTS_OPTIONS;
  $attributes = "select pa.* from " . TABLE_PRODUCTS_ATTRIBUTES . " pa left join " . TABLE_PRODUCTS_DESCRIPTION . " pd on pa.products_id = pd.products_id and pd.language_id = '" . $languages_id . "' order by pd.products_name";
  if (!$attribute_page) {
    $attribute_page = 1;
  }
  $prev_attribute_page = $attribute_page - 1;
  $next_attribute_page = $attribute_page + 1;

  $attribute_query = tep_db_query($attributes);

  $attribute_page_start = ($per_page * $attribute_page) - $per_page;
  $num_rows = tep_db_num_rows($attribute_query);

  if ($num_rows <= $per_page) {
     $num_pages = 1;
  } else if (($num_rows % $per_page) == 0) {
     $num_pages = ($num_rows / $per_page);
  } else {
     $num_pages = ($num_rows / $per_page) + 1;
  }
  $num_pages = (int) $num_pages;

  $attributes = $attributes . " LIMIT $attribute_page_start, $per_page";

  // Previous
  if ($prev_attribute_page) {
    echo '<a href="' . tep_href_link(FILENAME_PRODUCTS_ATTRIBUTES, 'attribute_page=' . $prev_attribute_page) . '"> &lt;&lt; </a> | ';
  }

  for ($i = 1; $i <= $num_pages; $i++) {
    if ($i != $attribute_page) {
      echo '<a href="' . tep_href_link(FILENAME_PRODUCTS_ATTRIBUTES, 'attribute_page=' . $i) . '">' . $i . '</a> | ';
    } else {
      echo '<b><font color="red">' . $i . '</font></b> | ';
    }
  }

  // Next
  if ($attribute_page != $num_pages) {
    echo '<a href="' . tep_href_link(FILENAME_PRODUCTS_ATTRIBUTES, 'attribute_page=' . $next_attribute_page) . '"> &gt;&gt; </a>';
  }
?>
            </td>
          </tr>
          <tr>
            <td colspan="10"><?php echo tep_black_line(); ?></td>
          </tr>
          <tr class="dataTableHeadingRow">
            <td class="dataTableHeadingContent">&nbsp;<?php echo TABLE_HEADING_ID; ?>&nbsp;</td>
            <td class="dataTableHeadingContent">&nbsp;<?php echo TABLE_HEADING_PRODUCT; ?>&nbsp;</td>
<?php
// BOF: WebMakers.com Added: FREE-CALL
//
?>
            <td class="dataTableHeadingContent">&nbsp;<?php echo TABLE_HEADING_FILENAME; ?>&nbsp;</td>
<?php
// EOF: WebMakers.com Added: FREE-CALL
//
?>
            <td class="dataTableHeadingContent">&nbsp;<?php echo TABLE_HEADING_OPT_NAME; ?>&nbsp;</td>
            <td class="dataTableHeadingContent">&nbsp;<?php echo TABLE_HEADING_OPT_VALUE; ?>&nbsp;</td>
<?php
// BOF: WebMakers.com Added: FREE-CALL
//
?>
            <td class="dataTableHeadingContent" align="right">&nbsp;<?php echo TABLE_HEADING_OPTION_SORT_ORDER; ?>&nbsp;</td>

<?php
// EOF: WebMakers.com Added: FREE-CALL
//
?>
            <td class="dataTableHeadingContent" align="right">&nbsp;<?php echo TABLE_HEADING_OPT_PRICE; ?>&nbsp;</td>
            <td class="dataTableHeadingContent" align="center">&nbsp;<?php echo TABLE_HEADING_OPT_PRICE_PREFIX; ?>&nbsp;</td>
            <td class="dataTableHeadingContent" align="center">&nbsp;<?php echo TABLE_HEADING_PRODUCT_ATTRIBUTE_ONE_TIME; ?>&nbsp;</td>
            <td class="dataTableHeadingContent" align="center">&nbsp;<?php echo TABLE_HEADING_ACTION; ?>&nbsp;</td>
          </tr>
          <tr>
            <td colspan="10"><?php echo tep_black_line(); ?></td>
          </tr>

<?php
  $next_id = 1;
  $attributes = tep_db_query($attributes);
  while ($attributes_values = tep_db_fetch_array($attributes)) {
    $products_name_only = tep_get_products_name($attributes_values['products_id']);
    $options_name = tep_options_name($attributes_values['options_id']);
    $values_name = tep_values_name($attributes_values['options_values_id']);
    $rows++;
?>
          <tr class="<?php echo (floor($rows/2) == ($rows/2) ? 'attributes-even' : 'attributes-odd'); ?>">
<?php
    if (($_GET['action'] == 'update_attribute') && ($_GET['attribute_id'] == $attributes_values['products_attributes_id'])) {
?>
            <td class="attributeBoxContent">&nbsp;<?php echo $attributes_values['products_attributes_id']; ?><input type="hidden" name="attribute_id" value="<?php echo $attributes_values['products_attributes_id']; ?>">&nbsp;</td>
            <td class="attributeBoxContent" colspan="2">&nbsp;<select name="products_id">
<?php
      $products = tep_db_query("select p.products_id, pd.products_name from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd where pd.products_id = p.products_id and pd.language_id = '" . $languages_id . "' order by pd.products_name");
      while($products_values = tep_db_fetch_array($products)) {
        if ($attributes_values['products_id'] == $products_values['products_id']) {
          echo "\n" . '<option name="' . $products_values['products_name'] . '" value="' . $products_values['products_id'] . '" SELECTED>' . $products_values['products_name'] . '</option>';
        } else {
          echo "\n" . '<option name="' . $products_values['products_name'] . '" value="' . $products_values['products_id'] . '">' . $products_values['products_name'] . '</option>';
        }
      }
?>
            </select>&nbsp;</td>
            <td class="attributeBoxContent">&nbsp;<select name="options_id">
<?php
      $options = tep_db_query("select * from " . TABLE_PRODUCTS_OPTIONS . " where language_id = '" . $languages_id . "' order by products_options_name");
      while($options_values = tep_db_fetch_array($options)) {
        if ($attributes_values['options_id'] == $options_values['products_options_id']) {
          echo "\n" . '<option name="' . $options_values['products_options_name'] . '" value="' . $options_values['products_options_id'] . '" SELECTED>' . $options_values['products_options_name'] . '</option>';
        } else {
          echo "\n" . '<option name="' . $options_values['products_options_name'] . '" value="' . $options_values['products_options_id'] . '">' . $options_values['products_options_name'] . '</option>';
        }
      }
?>
            </select>&nbsp;</td>
            <td class="attributeBoxContent">&nbsp;<select name="values_id">
<?php
      $values = tep_db_query("select * from " . TABLE_PRODUCTS_OPTIONS_VALUES . " where language_id ='" . $languages_id . "' order by products_options_values_name");
      while($values_values = tep_db_fetch_array($values)) {
        if ($attributes_values['options_values_id'] == $values_values['products_options_values_id']) {
          echo "\n" . '<option name="' . $values_values['products_options_values_name'] . '" value="' . $values_values['products_options_values_id'] . '" SELECTED>' . $values_values['products_options_values_name'] . '</option>';
        } else {
          echo "\n" . '<option name="' . $values_values['products_options_values_name'] . '" value="' . $values_values['products_options_values_id'] . '">' . $values_values['products_options_values_name'] . '</option>';
        }
      }
?>
            </select>&nbsp;</td>
<?php
// BOF: WebMakers.com Added: Attribute Sorter- Edit
//
?>
            <td align="right" class="attributeBoxContent">&nbsp;<?php echo TEXT_OPTION_SORT_ORDER; ?> <input type="text" name="sort_order" value="<?php echo $attributes_values['products_options_sort_order']; ?>" size="2">&nbsp;</td>
            <td align="right" class="attributeBoxContent">&nbsp;<?php echo TABLE_HEADING_OPT_PRICE; ?> <input type="text" name="value_price" value="<?php echo $attributes_values['options_values_price']; ?>" size="6">&nbsp;</td>
            <td align="center" class="attributeBoxContent">&nbsp;<input type="text" name="price_prefix" value="<?php echo $attributes_values['price_prefix']; ?>" size="2">&nbsp;</td>
            <td class="attributeBoxContent">&nbsp;</td>
            <td align="center" class="attributeBoxContent">&nbsp;<?php echo tep_image_submit('button_update.gif', IMAGE_UPDATE); ?>&nbsp;<?php echo '<a href="' . tep_href_link(FILENAME_PRODUCTS_ATTRIBUTES, '&attribute_page=' . $attribute_page, 'NONSSL') . '">'; ?><?php echo tep_image_button('button_cancel.gif', IMAGE_CANCEL); ?></a>&nbsp;</td>
<?php
      if (DOWNLOAD_ENABLED == 'true') {
        $download_query_raw ="select products_attributes_filename, products_attributes_maxdays, products_attributes_maxcount, products_attributes_is_pin
                              from " . TABLE_PRODUCTS_ATTRIBUTES_DOWNLOAD . "
                              where products_attributes_id='" . $attributes_values['products_attributes_id'] . "'";
        $download_query = tep_db_query($download_query_raw);
        if (tep_db_num_rows($download_query) > 0) {
          $download = tep_db_fetch_array($download_query);
          $products_attributes_filename = $download['products_attributes_filename'];
          $products_attributes_maxdays  = $download['products_attributes_maxdays'];
          $products_attributes_maxcount = $download['products_attributes_maxcount'];
          $products_attributes_is_pin   = $download['products_attributes_is_pin'];
        }
?>
          <tr class="attributeBoxContent">
            <td class="attributeBoxContent">&nbsp;</td>
            <td colspan="8">
              <table>
                <tr class="attributeBoxContent">
                  <td align="right" class="attributeBoxContent"><?php echo TABLE_HEADING_DOWNLOAD; ?>&nbsp;</td>
                  <td align="right" class="attributeBoxContent"><?php echo TABLE_TEXT_FILENAME; ?></td>
                  <td align="right" class="attributeBoxContent"><?php echo tep_draw_input_field('products_attributes_filename', $products_attributes_filename, 'size="35"'); ?>&nbsp;</td>
                  <td align="right" class="attributeBoxContent"><?php echo TABLE_TEXT_MAX_DAYS; ?></td>
                  <td align="right" class="attributeBoxContent"><?php echo tep_draw_input_field('products_attributes_maxdays', $products_attributes_maxdays, 'size="5"'); ?>&nbsp;</td>
                  <td align="right" class="attributeBoxContent"><?php echo TABLE_TEXT_MAX_COUNT; ?></td>
                  <td align="right" class="attributeBoxContent"><?php echo tep_draw_input_field('products_attributes_maxcount', $products_attributes_maxcount, 'size="5"'); ?>&nbsp;</td>
                  <!-- //PIN add -->
<td class="smallText"><?php echo TABLE_TEXT_IS_PIN; ?></td>
<td class="smallText"><?php echo tep_draw_checkbox_field('products_attributes_is_pin', '', $products_attributes_is_pin,1); ?>&nbsp;</td>
<!-- //PIN end -->
                </tr>
              </table>
            </td>
            <td>&nbsp;</td>
          </tr>
<?php
      }
?>

<?
    switch ($attributes_values['product_attributes_one_time']) {
      case ('0'): $on_attribute = false; $off_attribute = true; break;
      case ('1'): $on_attribute = true; $off_attribute = false; break;
      default: $on_attribute = false; $off_attribute = true;
    }
?>

<!--

<?php /* BOF: WebMakers.com Added: Attribute Enhancements Coming Soon */ ?>
          <tr class="attributeBoxContent">
            <td class="attributeBoxContent">&nbsp;</td>
            <td class="attributeBoxContent" colspan="8">
              <table>
                <tr>
                  <td colspan="6"><?php echo tep_black_line(); ?></td>
                </tr>
                <tr class="attributeBoxContent">
                  <td align="right" class="attributeBoxContent">&nbsp;<FONT COLOR="FF0000"><b>COMING SOON:</b></FONT> </td>
                  <td align="right" class="attributeBoxContent">&nbsp;Attribute Weight: <input type="text" name="products_attributes_weight" value="<?php echo $attributes_values['products_attributes_weight']; ?>" size="5">&nbsp;</td>
                  <td align="right" class="attributeBoxContent">&nbsp;Prefix: <input type="text" name="products_attributes_weight_prefix" value="<?php echo $attributes_values['products_attributes_weight_prefix']; ?>" size="2">&nbsp;</td>
                  <td align="right" class="attributeBoxContent">&nbsp;#Units per Product: <input type="text" name="products_attributes_units" value="<?php echo $attributes_values['products_attributes_units']; ?>" size="5">&nbsp;</td>
                  <td align="right" class="attributeBoxContent">&nbsp;Unit Price: <input type="text" name="products_attributes_units_price" value="<?php echo $attributes_values['products_attributes_units_price']; ?>" size="7">&nbsp;</td>
                  <td align="right" class="attributeBoxContent">&nbsp;One Time Attribute Charge Per Product: <?php echo tep_draw_radio_field('product_attributes_one_time', '0', $off_attribute) . '&nbsp;' . 'No' . ' ' . tep_draw_radio_field('product_attributes_one_time', '1', $on_attribute) . '&nbsp;' . 'Yes'; ?></td>
                </tr>
              </table>
            </td>
            <td>&nbsp;</td>
          </tr>
<?php /* EOF: WebMakers.com Added: Attribute Enhancements Coming Soon */ ?>

-->




<?php
    } elseif (($_GET['action'] == 'delete_product_attribute') && ($_GET['attribute_id'] == $attributes_values['products_attributes_id'])) {
?>

<?php
// BOF: WebMakers.com Added: Attribute Sorter - Delete
?>
            <td class="smallText">&nbsp;<b><?php echo $attributes_values["products_attributes_id"]; ?></b>&nbsp;</td>
            <td class="smallText">&nbsp;<b><?php echo $products_name_only; ?></b>&nbsp;</td>

            <td class="smallText">&nbsp;<b><?php echo $the_download['products_attributes_filename']; ?></b>&nbsp;</td>
            <td class="smallText">&nbsp;<b><?php echo $options_name; ?></b>&nbsp;</td>
            <td class="smallText">&nbsp;<b><?php echo $values_name; ?></b>&nbsp;</td>

            <td align="right" class="smallText">&nbsp;<b><?php echo $attributes_values["products_options_sort_order"]; ?></td>
            <td align="right" class="smallText">&nbsp;<b><?php echo $attributes_values["options_values_price"]; ?></b>&nbsp;</td>
            <td align="center" class="smallText">&nbsp;<b><?php echo $attributes_values["price_prefix"]; ?></b>&nbsp;</td>
            <td align="center" class="smallText">&nbsp;<b><?php echo $attributes_values['product_attributes_one_time']; ?></b>&nbsp;</td>

            <td align="center" class="smallText">&nbsp;<b><?php echo '<a href="' . tep_href_link(FILENAME_PRODUCTS_ATTRIBUTES, 'action=delete_attribute&attribute_id=' . $_GET['attribute_id']) . '">'; ?><?php echo tep_image_button('button_confirm.gif', IMAGE_CONFIRM); ?></a>&nbsp;&nbsp;<?php echo '<a href="' . tep_href_link(FILENAME_PRODUCTS_ATTRIBUTES, '&option_page=' . $option_page . '&value_page=' . $value_page . '&attribute_page=' . $attribute_page, 'NONSSL') . '">'; ?><?php echo tep_image_button('button_cancel.gif', IMAGE_CANCEL); ?></a>&nbsp;</b></td>
<?php
// EOF: WebMakers.com Added: Attribute Sorter - Delete
    } else {
?>
<?php
// BOF: WebMakers.com Added: FREE-CALL FOR PRICE-COMING SOON ETC.
        $the_download_query_raw ="select products_attributes_filename, products_attributes_maxdays, products_attributes_maxcount, products_attributes_is_pin from " . TABLE_PRODUCTS_ATTRIBUTES_DOWNLOAD . " where products_attributes_id='" . $attributes_values['products_attributes_id'] . "'";
        $the_download_query = tep_db_query($the_download_query_raw);
        $the_download= tep_db_fetch_array($the_download_query);

?>
            <td class="smallText">&nbsp;<?php echo $attributes_values["products_attributes_id"]; ?>&nbsp;</td>
            <td class="smallText">&nbsp;<?php echo $products_name_only; ?>&nbsp;</td>
<?php
// BOF: NOTE
// Could go into /admin/includes/configure.php
  define('DIR_FS_DOWNLOAD', DIR_FS_CATALOG . 'download/');
  $filename_is_missing='';
// EOF: NOTE
if ( $the_download['products_attributes_filename'] ) {
  if ( !file_exists(DIR_FS_DOWNLOAD . $the_download['products_attributes_filename']) ) {
    $filename_is_missing='<FONT COLOR="FF0000"> - <B>*** Missing</B></FONT>';
  } else {
    $filename_is_missing='<FONT COLOR="2F4F2F"> - <B>Good File</B></FONT>';
  }
}
?>
            <td class="smallText"><?php echo $the_download['products_attributes_filename'] . $filename_is_missing; ?>&nbsp;</td>
<?php
// EOF: WebMakers.com Added: FREE-CALL FOR PRICE-COMING SOON ETC.
?>
            <td class="smallText">&nbsp;<?php echo $options_name; ?>&nbsp;</td>
            <td class="smallText">&nbsp;<?php echo $values_name; ?>&nbsp;</td>
<?php
// BOF: WebMakers.com Added: FREE-CALL FOR PRICE-COMING SOON ETC.
//
?>
            <td align="right" class="smallText"><?php echo $attributes_values["products_options_sort_order"]; ?>&nbsp;</td>
<?php
// EOF: WebMakers.com Added: FREE-CALL FOR PRICE-COMING SOON ETC.
//
?>
            <td align="right" class="smallText">&nbsp;<?php echo $attributes_values["options_values_price"]; ?>&nbsp;</td>
            <td align="center" class="smallText">&nbsp;<?php echo $attributes_values["price_prefix"]; ?>&nbsp;</td>
            <td align="center" class="smallText">&nbsp;<?php echo $attributes_values["product_attributes_one_time"]; ?>&nbsp;</td>
            <td align="center" class="smallText">&nbsp;<?php echo '<a href="' . tep_href_link(FILENAME_PRODUCTS_ATTRIBUTES, 'action=update_attribute&attribute_id=' . $attributes_values['products_attributes_id'] . '&attribute_page=' . $attribute_page, 'NONSSL') . '">'; ?><?php echo tep_image_button('button_edit.gif', IMAGE_UPDATE); ?></a>&nbsp;&nbsp;<?php echo '<a href="' . tep_href_link(FILENAME_PRODUCTS_ATTRIBUTES, 'action=delete_product_attribute&attribute_id=' . $attributes_values['products_attributes_id'] . '&attribute_page=' . $attribute_page, 'NONSSL') , '">'; ?><?php echo tep_image_button('button_delete.gif', IMAGE_DELETE); ?></a>&nbsp;</td>
<?php
    }
    $max_attributes_id_query = tep_db_query("select max(products_attributes_id) + 1 as next_id from " . TABLE_PRODUCTS_ATTRIBUTES);
    $max_attributes_id_values = tep_db_fetch_array($max_attributes_id_query);
    $next_id = $max_attributes_id_values['next_id'];
?>
          </tr>
<?php
  }
  if ($_GET['action'] != 'update_attribute') {
?>
          <tr>
            <td colspan="10"><?php echo tep_black_line(); ?></td>
          </tr>
          <tr class="<?php echo (floor($rows/2) == ($rows/2) ? 'attributes-even' : 'attributes-odd'); ?>">
            <td class="smallText">&nbsp;<?php echo $next_id; ?>&nbsp;</td>
<?php
// BOF: WebMakers.com Added: FREE-CALL FOR PRICE-COMING SOON ETC.
?>
      	    <td class="smallText" colspan="2">&nbsp;<select name="products_id">
<?php
// EOF: WebMakers.com Added: FREE-CALL FOR PRICE-COMING SOON ETC.
?>
<?php
    $products = tep_db_query("select p.products_id, pd.products_name from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd where pd.products_id = p.products_id and pd.language_id = '" . $languages_id . "' order by pd.products_name");
    while ($products_values = tep_db_fetch_array($products)) {
      echo '<option name="' . $products_values['products_name'] . '" value="' . $products_values['products_id'] . '">' . $products_values['products_name'] . '</option>';
    }
?>
            </select>&nbsp;</td>
            <td class="smallText">&nbsp;<select name="options_id">
<?php
    $options = tep_db_query("select * from " . TABLE_PRODUCTS_OPTIONS . " where language_id = '" . $languages_id . "' order by products_options_name");
    while ($options_values = tep_db_fetch_array($options)) {
      echo '<option name="' . $options_values['products_options_name'] . '" value="' . $options_values['products_options_id'] . '">' . $options_values['products_options_name'] . '</option>';
    }
?>
            </select>&nbsp;</td>
            <td class="smallText">&nbsp;<select name="values_id">
<?php
    $values = tep_db_query("select * from " . TABLE_PRODUCTS_OPTIONS_VALUES . " where language_id = '" . $languages_id . "' order by products_options_values_name");
    while ($values_values = tep_db_fetch_array($values)) {
      echo '<option name="' . $values_values['products_options_values_name'] . '" value="' . $values_values['products_options_values_id'] . '">' . $values_values['products_options_values_name'] . '</option>';
    }
?>
            </select>&nbsp;</td>
<?php
// BOF: WebMakers.com Added: FREE-CALL FOR PRICE-COMING SOON ETC.
?>
            <td align="right" class="smallText">&nbsp;<input type="text" name="sort_order" size="6">&nbsp;</td>
<?php
// EOF: WebMakers.com Added: FREE-CALL FOR PRICE-COMING SOON ETC.
?>
            <td align="right" class="smallText">&nbsp;<input type="text" name="value_price" size="6">&nbsp;</td>
            <td align="right" class="smallText">&nbsp;<input type="text" name="price_prefix" size="2" value="+">&nbsp;</td>
            <td align="center" class="smallText">&nbsp;<input type="text" name="product_attributes_one_time" value="0" size="2">&nbsp;</td>
            <td align="center" class="smallText">&nbsp;<?php echo tep_image_submit('button_insert.gif', IMAGE_INSERT); ?>&nbsp;</td>
          </tr>
<?php
      if (DOWNLOAD_ENABLED == 'true') {
        $products_attributes_maxdays  = DOWNLOAD_MAX_DAYS;
        $products_attributes_maxcount = DOWNLOAD_MAX_COUNT;
?>
          <tr class="<?php echo (!($rows % 2)? 'attributes-even' : 'attributes-odd');?>">
            <td>&nbsp;</td>
            <td colspan="8">
              <table>
                <tr class="<?php echo (!($rows % 2)? 'attributes-even' : 'attributes-odd');?>">
                  <td class="smallText"><?php echo TABLE_HEADING_DOWNLOAD; ?>&nbsp;</td>
                  <td class="smallText"><?php echo TABLE_TEXT_FILENAME; ?></td>
                  <td class="smallText"><?php echo tep_draw_input_field('products_attributes_filename', $products_attributes_filename, 'size="35"'); ?>&nbsp;</td>
                  <td class="smallText"><?php echo TABLE_TEXT_MAX_DAYS; ?></td>
                  <td class="smallText"><?php echo tep_draw_input_field('products_attributes_maxdays', $products_attributes_maxdays, 'size="5"'); ?>&nbsp;</td>
                  <td class="smallText"><?php echo TABLE_TEXT_MAX_COUNT; ?></td>
                  <td class="smallText"><?php echo tep_draw_input_field('products_attributes_maxcount', $products_attributes_maxcount, 'size="5"'); ?>&nbsp;</td>
                   <!-- //PIN add -->
                  <td class="smallText"><?php echo TABLE_TEXT_IS_PIN; ?></td>
                  <td class="smallText"><?php echo tep_draw_checkbox_field('products_attributes_is_pin', '',  $products_attributes_is_pin,1); ?>&nbsp;</td>
                  <!-- //PIN end -->
                </tr>
              </table>
            </td>
            <td>&nbsp;</td>
          </tr>
<?php
      } // end of DOWNLOAD_ENABLED section
?>
<?php
  }
?>
          <tr>
            <td colspan="10"><?php echo tep_black_line(); ?></td>
          </tr>
        </table></form></td>
      </tr>
    </table></td>
<!-- products_attributes_eof //-->
  </tr>
</table>
<!-- body_text_eof //-->
<!-- footer //-->
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<!-- footer_eof //-->
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>
