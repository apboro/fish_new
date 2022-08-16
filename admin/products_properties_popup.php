<?php
/*
  $Id: products_properties_popup.php,v 2.0 2004/09/29 oj Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/

  require('includes/application_top.php');
  $languages = tep_get_languages();

  $action = (isset($_GET['action']) ? $_GET['action'] : '');

  if (tep_not_null($action)) {
    switch ($action) {
      case 'add_product_attributes':
        $products_id = tep_db_prepare_input($_POST['products_id']);
        $categories_id = tep_db_prepare_input($_POST['categories_id']);
				$options_id = tep_db_prepare_input($_POST['options_id']);
        $values_id = tep_db_prepare_input($_POST['values_id']);
        $sort_order = tep_db_prepare_input($_POST['sort_order']);

      	$max_values_id_query = tep_db_query("select max(products_attributes_id) + 1 as next_id from " . TABLE_PRODUCTS_PROPERTIES); 
  	    	$max_values_id_values = tep_db_fetch_array($max_values_id_query); 
    	  	$value_id = $max_values_id_values['next_id']; 
    	  	
        tep_db_query("insert into " . TABLE_PRODUCTS_PROPERTIES . " values ('" . (int)$value_id . "', '" . (int)$products_id . "', '" . (int)$categories_id . "', '" . (int)$options_id . "', '" . (int)$values_id . "', '" . tep_db_input($sort_order) . "')");

        tep_redirect(tep_href_link(FILENAME_PRODUCTS_PROPERTIES_POPUP, 'cID=' . $categories_id . '&pID=' . $products_id));
        break;
      case 'update_product_attribute':
        $attribute_id = tep_db_prepare_input($_POST['attribute_id']);
				$products_id = tep_db_prepare_input($_POST['products_id']);
        $categories_id = tep_db_prepare_input($_POST['categories_id']);
				$options_id = tep_db_prepare_input($_POST['options_id']);
        $values_id = tep_db_prepare_input($_POST['values_id']);
        $sort_order = tep_db_prepare_input($_POST['sort_order']);

        tep_db_query("update " . TABLE_PRODUCTS_PROPERTIES . " set products_id = '" . (int)$products_id . "', categories_id = '" . (int)$categories_id . "', options_id = '" . (int)$options_id . "', options_values_id = '" . (int)$values_id . "', sort_order = '" . (int)$sort_order . "' where products_attributes_id = '" . (int)$attribute_id . "'");

        tep_redirect(tep_href_link(FILENAME_PRODUCTS_PROPERTIES_POPUP, 'cID=' . $categories_id . '&pID=' . $products_id));
        break;
      case 'delete_attribute':
        $attribute_id = tep_db_prepare_input($_GET['attribute_id']);
				$products_id = tep_db_prepare_input($_GET['pID']);
        $categories_id = tep_db_prepare_input($_GET['cID']);
				
        tep_db_query("delete from " . TABLE_PRODUCTS_PROPERTIES . " where products_attributes_id = '" . (int)$attribute_id . "'");

        tep_redirect(tep_href_link(FILENAME_PRODUCTS_PROPERTIES_POPUP, 'cID=' . $categories_id . '&pID=' . $products_id));
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
</head>
<body marginwidth="0" marginheight="0" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0" bgcolor="#FFFFFF">

<!-- body //-->
<table border="0" width="100%" cellspacing="2" cellpadding="2">
  <tr>
<!-- body_text //-->
    <td width="100%" valign="top"><table class="table-padding-0">
      <tr>
        <td width="100%"><table class="table-padding-0">
          <tr>
            <td valign="bottom" class="pageHeading"><?php echo HEADING_TITLE_PROPERTIES; ?>&nbsp;</td>
            <td><?php echo tep_image(DIR_WS_IMAGES . 'pixel_trans.gif', '1', '30'); ?>&nbsp;</td>
          </tr>
        </table></td>
      </tr>
      <tr>
<?php
  if ($action == 'update_attribute') {
    $form_action = 'update_product_attribute';
  } else {
    $form_action = 'add_product_attributes';
  }
?>
        <td><form name="properties" action="<?php echo tep_href_link(FILENAME_PRODUCTS_PROPERTIES_POPUP, 'action=' . $form_action . '&cID=' . $_GET['cID'] . '&pID=' . $_GET['pID']); ?>" method="post"><table class="table-padding-2">
          <tr>
            <td colspan="6" class="smallText">
<?php
	$attributes = "select products_attributes_id, products_id, categories_id, options_id, options_values_id, sort_order from " . TABLE_PRODUCTS_PROPERTIES . " where products_id = '" . $_GET['pID'] . "' and categories_id = '" . $_GET['cID'] . "' order by sort_order";
?>
            </td>
          </tr>
          <tr class="dataTableHeadingRow">
            <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_PROPERTIES_PRODUCT_NO; ?>&nbsp;</td>
            <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_PROPERTIES_PRODUCT; ?>&nbsp;</td>
            <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_PROPERTIES_OPTIONS_NAME; ?>&nbsp;</td>
            <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_PROPERTIES_OPTIONS_VALUE; ?>&nbsp;</td>
            <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_PROPERTIES_OPTIONS_SORT; ?>&nbsp;</td>
            <td class="dataTableHeadingContent" align="center"><?php echo TABLE_HEADING_PROPERTIES_ACTION; ?>&nbsp;</td>
          </tr>
<?php
  $attributes = tep_db_query($attributes);
  while ($attributes_values = tep_db_fetch_array($attributes)) { 
		$products_name_only = tep_get_products_name($attributes_values['products_id']);
    $products_model_only = tep_get_products_model($attributes_values['products_id']);
		$options_name = tep_get_properties_options_name($attributes_values['options_id']);
    $values_name = tep_get_properties_values_name($attributes_values['options_values_id']);
    $rows++;
?>
          <tr class="<?php echo (floor($rows/2) == ($rows/2) ? 'properties-even' : 'properties-odd'); ?>">
<?php
    if (($action == 'update_attribute') && ($_GET['attribute_id'] == $attributes_values['products_attributes_id'])) {
?>
            <td class="smallText"><?php echo $products_model_only; ?><input type="hidden" name="attribute_id" value="<?php echo $attributes_values['products_attributes_id']; ?>">&nbsp;</td>
            <td class="smallText"><input type="hidden" name="categories_id" value="<?php echo $attributes_values['categories_id']; ?>"><?php echo $products_name_only; ?><input type="hidden" name="products_id" value="<?php echo $attributes_values['products_id']; ?>"></td>
            <td class="smallText">&nbsp;<select name="options_id">
<?php
      $options = tep_db_query("select * from " . TABLE_PRODUCTS_PROP_OPTIONS . " where categories_options_id = '" . $attributes_values['categories_id'] . "' and language_id = '" . $languages_id . "' order by products_options_name");
      while($options_values = tep_db_fetch_array($options)) {
        if ($attributes_values['options_id'] == $options_values['products_options_id']) {
          echo "\n" . '<option name="' . $options_values['products_options_name'] . '" value="' . $options_values['products_options_id'] . '" SELECTED>' . $options_values['products_options_name'] . '</option>';
        } else {
          echo "\n" . '<option name="' . $options_values['products_options_name'] . '" value="' . $options_values['products_options_id'] . '">' . $options_values['products_options_name'] . '</option>';
        }
      } 
?>
            </select>&nbsp;</td>
            <td class="smallText">&nbsp;<select name="values_id">
<?php
      $values = tep_db_query("select * from " . TABLE_PRODUCTS_PROP_OPTIONS_VALUES . " where categories_options_values_id = '" . $attributes_values['categories_id'] . "' and language_id ='" . $languages_id . "' order by products_options_values_name");
      while($values_values = tep_db_fetch_array($values)) {
        if ($attributes_values['options_values_id'] == $values_values['products_options_values_id']) {
          echo "\n" . '<option name="' . $values_values['products_options_values_name'] . '" value="' . $values_values['products_options_values_id'] . '" SELECTED>' . $values_values['products_options_values_name'] . '</option>';
        } else {
          echo "\n" . '<option name="' . $values_values['products_options_values_name'] . '" value="' . $values_values['products_options_values_id'] . '">' . $values_values['products_options_values_name'] . '</option>';
        }
      } 
?>        
            </select>&nbsp;</td>
            <td align"right" class="smallText">&nbsp;<select name="sort_order">
<?php 
		for ($i = 1; $i <= 10; $i++) {
   		echo '<option name="sort_order" value="' . $i . '">' . $i . '</option>';
		}
?>
						</select>&nbsp;</td>
						<td align="center" class="smallText">&nbsp;<?php echo tep_image_submit('button_update.gif', IMAGE_UPDATE); ?>&nbsp;<?php echo '<a href="' . tep_href_link(FILENAME_PRODUCTS_PROPERTIES_POPUP, 'cID=' . $_GET['cID'] . '&pID=' . $_GET['pID'], 'NONSSL') . '">'; ?><?php echo tep_image_button('button_cancel.gif', IMAGE_CANCEL); ?></a>&nbsp;</td>
<?php
    } elseif (($action == 'delete_product_attribute') && ($_GET['attribute_id'] == $attributes_values['products_attributes_id'])) {
?>
            <td class="smallText"><b><?php echo $products_model_only; ?></b>&nbsp;</td>
            <td class="smallText"><b><?php echo $products_name_only; ?></b>&nbsp;</td>
            <td class="smallText"><b><?php echo $options_name; ?></b>&nbsp;</td>
            <td class="smallText"><b><?php echo $values_name; ?></b>&nbsp;</td>
            <td class="smallText"><b><?php echo $attributes_values["sort_order"]; ?></b>&nbsp;</td>
            <td align="center" class="smallText"><b><?php echo '<a href="' . tep_href_link(FILENAME_PRODUCTS_PROPERTIES_POPUP, 'action=delete_attribute&attribute_id=' . $_GET['attribute_id'] . '&cID=' . $_GET['cID'] . '&pID=' . $_GET['pID']) . '">'; ?><?php echo tep_image_button('button_confirm.gif', IMAGE_CONFIRM); ?></a>&nbsp;&nbsp;<?php echo '<a href="' . tep_href_link(FILENAME_PRODUCTS_PROPERTIES_POPUP, 'cID=' . $_GET['cID'] . '&pID=' . $_GET['pID'], 'NONSSL') . '">'; ?><?php echo tep_image_button('button_cancel.gif', IMAGE_CANCEL); ?></a>&nbsp;</b></td>
<?php
    } else {
?>
            <td class="smallText"><?php echo $products_model_only; ?>&nbsp;</td>
            <td class="smallText"><?php echo $products_name_only; ?>&nbsp;</td>
            <td class="smallText"><?php echo $options_name; ?>&nbsp;</td>
            <td class="smallText"><?php echo $values_name; ?>&nbsp;</td>
            <td class="smallText"><?php echo $attributes_values["sort_order"]; ?>&nbsp;</td>
            <td align="right" class="smallText">&nbsp;<?php echo '<a href="' . tep_href_link(FILENAME_PRODUCTS_PROPERTIES_POPUP, 'action=update_attribute&attribute_id=' . $attributes_values['products_attributes_id'] . '&cID=' . $_GET['cID'] . '&pID=' . $_GET['pID'], 'NONSSL') . '">'; ?><?php echo tep_image_button('button_edit.gif', IMAGE_UPDATE); ?></a>&nbsp;<?php echo '<a href="' . tep_href_link(FILENAME_PRODUCTS_PROPERTIES_POPUP, 'action=delete_product_attribute&attribute_id=' . $attributes_values['products_attributes_id'] . '&cID=' . $_GET['cID'] . '&pID=' . $_GET['pID'], 'NONSSL') , '">'; ?><?php echo tep_image_button('button_delete.gif', IMAGE_DELETE); ?></a></td>
<?php
    }
?>
          </tr>
<?php
  }
  if ($action != 'update_attribute') {
?>
          <tr>
            <td colspan="6">&nbsp;</td>
          </tr>
          <tr class="<?php echo (floor($rows/2) == ($rows/2) ? 'properties-even' : 'properties-odd'); ?>">
            <td class="smallText"><?php echo tep_get_products_model($_GET['pID']); ?>&nbsp;</td>
      	    <td class="smallText"><input type="hidden" name="categories_id" value="<?php echo $_GET['cID']; ?>"><?php echo tep_get_products_name($_GET['pID']); ?><input type="hidden" name="products_id" value="<?php echo $_GET['pID']; ?>"></td>
            <td class="smallText">&nbsp;<select name="options_id">
<?php
    $options = tep_db_query("select * from " . TABLE_PRODUCTS_PROP_OPTIONS . " where categories_options_id = '" . $_GET['cID'] . "' and language_id = '" . $languages_id . "' order by products_options_name");
    while ($options_values = tep_db_fetch_array($options)) {
      echo '<option name="' . $options_values['products_options_name'] . '" value="' . $options_values['products_options_id'] . '">' . $options_values['products_options_name'] . '</option>';
    } 
?>
            </select>&nbsp;</td>
            <td class="smallText">&nbsp;<select name="values_id">
<?php
    $values = tep_db_query("select * from " . TABLE_PRODUCTS_PROP_OPTIONS_VALUES . " where categories_options_values_id = '" . $_GET['cID'] . "' and language_id = '" . $languages_id . "' order by products_options_values_name");
    while ($values_values = tep_db_fetch_array($values)) {
      echo '<option name="' . $values_values['products_options_values_name'] . '" value="' . $values_values['products_options_values_id'] . '">' . $values_values['products_options_values_name'] . '</option>';
    } 
?>
            </select>&nbsp;</td>
            <td align"right" class="smallText">&nbsp;<select name="sort_order">
<?php 
		for ($i = 1; $i <= 10; $i++) {
   		echo '<option name="sort_order" value="' . $i . '">' . $i . '</option>';
		}
?>
						</select>&nbsp;</td>		
						<td align="right" class="smallText">&nbsp;<?php echo tep_image_submit('button_insert.gif', IMAGE_INSERT); ?></td>
          </tr>
<?php
  }
?>
        </table></form></td>
      </tr>
    </table></td>
  </tr>
</table>
<!-- body_text_eof //-->
<!-- footer //-->
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<!-- footer_eof //-->
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>