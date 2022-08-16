<?php
/*
  $Id: products_properties.php,v 2.0 2004/09/29 oj Exp $

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
      case 'add_product_options':
        $categories_options_id = tep_db_prepare_input($_POST['categories_options_id']);
        $option_name_array = $_POST['option_name'];
				
      	$count_rows_query = tep_db_query("select products_options_id from " . TABLE_PRODUCTS_PROP_OPTIONS . "");
				if (tep_db_num_rows($count_rows_query)) {
					$max_options_id_query = tep_db_query("select max(products_options_id) + 1 as next_id from " . TABLE_PRODUCTS_PROP_OPTIONS . "");
      		$max_options_id_values = tep_db_fetch_array($max_options_id_query);
					$products_options_id = $max_options_id_values['next_id'];
				} else {
					$products_options_id = 1;
				}
				
        for ($i=0, $n=sizeof($languages); $i<$n; $i ++) {
          $option_name = tep_db_prepare_input($option_name_array[$languages[$i]['id']]);

          tep_db_query("insert into " . TABLE_PRODUCTS_PROP_OPTIONS . " (products_options_id, categories_options_id, products_options_name, language_id) values ('" . (int)$products_options_id . "', '" . (int)$categories_options_id . "', '" . tep_db_input($option_name) . "', '" . (int)$languages[$i]['id'] . "')");
        }
        tep_redirect(tep_href_link(FILENAME_PRODUCTS_PROPERTIES, 'cID=' . $categories_options_id));
        break;
      case 'add_product_option_values':
        $value_name_array = $_POST['value_name'];
        $category_id = tep_db_prepare_input($_POST['category_id']);
        $option_id = tep_db_prepare_input($_POST['option_id']);

				$count_rows_query = tep_db_query("select products_options_values_id from " . TABLE_PRODUCTS_PROP_OPTIONS_VALUES);
				if (tep_db_num_rows($count_rows_query)) {
	      	$max_values_id_query = tep_db_query("select max(products_options_values_id) + 1 as next_id from " . TABLE_PRODUCTS_PROP_OPTIONS_VALUES);
  	    	$max_values_id_values = tep_db_fetch_array($max_values_id_query);
    	  	$value_id = $max_values_id_values['next_id'];
				} else {
					$value_id = 1;
				}
					
        for ($i=0, $n=sizeof($languages); $i<$n; $i ++) {
          $value_name = tep_db_prepare_input($value_name_array[$languages[$i]['id']]);

          tep_db_query("insert into " . TABLE_PRODUCTS_PROP_OPTIONS_VALUES . " (products_options_values_id, categories_options_values_id, language_id, products_options_values_name) values ('" . (int)$value_id . "', '" . (int)$category_id . "', '" . (int)$languages[$i]['id'] . "', '" . tep_db_input($value_name) . "')");
        }

        tep_db_query("insert into " . TABLE_PRODUCTS_PROP_OPTIONS_VALUES_TO_PRODUCTS_PROP_OPTIONS . " (products_options_id, products_options_values_id) values ('" . (int)$option_id . "', '" . (int)$value_id . "')");

        tep_redirect(tep_href_link(FILENAME_PRODUCTS_PROPERTIES, 'cID=' . $category_id));
        break;
      case 'update_option_name':
        $category_id = tep_db_prepare_input($_POST['category_id']);
				$option_name_array = $_POST['option_name'];
        $option_id = tep_db_prepare_input($_POST['option_id']);

        for ($i=0, $n=sizeof($languages); $i<$n; $i ++) {
          $option_name = tep_db_prepare_input($option_name_array[$languages[$i]['id']]);

          tep_db_query("update " . TABLE_PRODUCTS_PROP_OPTIONS . " set products_options_name = '" . tep_db_input($option_name) . "' where categories_options_id = '" . (int)$category_id . "' and products_options_id = '" . (int)$option_id . "' and language_id = '" . (int)$languages[$i]['id'] . "'");
        }

        tep_redirect(tep_href_link(FILENAME_PRODUCTS_PROPERTIES, 'cID=' . $category_id));
        break;
      case 'update_value':
        $value_name_array = $_POST['value_name'];
        $category_id = tep_db_prepare_input($_POST['category_id']);
				$value_id = tep_db_prepare_input($_POST['value_id']);
        $option_id = tep_db_prepare_input($_POST['option_id']);

        for ($i=0, $n=sizeof($languages); $i<$n; $i ++) {
          $value_name = tep_db_prepare_input($value_name_array[$languages[$i]['id']]);

          tep_db_query("update " . TABLE_PRODUCTS_PROP_OPTIONS_VALUES . " set products_options_values_name = '" . tep_db_input($value_name) . "' where products_options_values_id = '" . tep_db_input($value_id) . "' and categories_options_values_id = '" . tep_db_input($category_id) . "' and language_id = '" . (int)$languages[$i]['id'] . "'");
        }

        tep_db_query("update " . TABLE_PRODUCTS_PROP_OPTIONS_VALUES_TO_PRODUCTS_PROP_OPTIONS . " set products_options_id = '" . (int)$option_id . "'  where products_options_values_id = '" . (int)$value_id . "'");

        tep_redirect(tep_href_link(FILENAME_PRODUCTS_PROPERTIES, 'cID=' . $category_id));
        break;
      case 'delete_option':
        $category_id = tep_db_prepare_input($_GET['cID']);
				$option_id = tep_db_prepare_input($_GET['option_id']);

        tep_db_query("delete from " . TABLE_PRODUCTS_PROP_OPTIONS . " where categories_options_id = '" . (int)$category_id . "' and products_options_id = '" . (int)$option_id . "'");

        tep_redirect(tep_href_link(FILENAME_PRODUCTS_PROPERTIES, 'cID=' . $category_id));
        break;
      case 'delete_value':
        $category_id = tep_db_prepare_input($_GET['cID']);
				$value_id = tep_db_prepare_input($_GET['value_id']);

        tep_db_query("delete from " . TABLE_PRODUCTS_PROP_OPTIONS_VALUES . " where products_options_values_id = '" . (int)$value_id . "' and categories_options_values_id = '" . (int)$category_id . "'");
        tep_db_query("delete from " . TABLE_PRODUCTS_PROP_OPTIONS_VALUES_TO_PRODUCTS_PROP_OPTIONS . " where products_options_values_id = '" . (int)$value_id . "'");

        tep_redirect(tep_href_link(FILENAME_PRODUCTS_PROPERTIES, 'cID=' . $category_id));
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
        <td width="100%"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top" width="100%"><table width="100%" border="0" cellspacing="0" cellpadding="2">
<?php
  if ($action == 'delete_product_option') { 
    $options = tep_db_query("select products_options_id, categories_options_id, products_options_name from " . TABLE_PRODUCTS_PROP_OPTIONS . " where categories_options_id = '" . (int)$_GET['cID'] . "' and products_options_id = '" . (int)$_GET['option_id'] . "' and language_id = '" . (int)$languages_id . "'");
    $options_values = tep_db_fetch_array($options);
?>
              <tr>
                <td class="pageHeading"><?php echo $options_values['products_options_name']; ?>&nbsp;</td>
              </tr>
              <tr>
                <td><table class="table-padding-2">
<?php
    $products = tep_db_query("select p.products_id, pd.products_name, pov.products_options_values_name from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_PROP_OPTIONS_VALUES . " pov, " . TABLE_PRODUCTS_PROPERTIES . " pp, " . TABLE_PRODUCTS_DESCRIPTION . " pd where pd.products_id = p.products_id and pov.language_id = '" . (int)$languages_id . "' and pd.language_id = '" . (int)$languages_id . "' and pp.products_id = p.products_id and pp.options_id='" . (int)$_GET['option_id'] . "' and pov.products_options_values_id = pp.options_values_id order by pd.products_name");
    if (tep_db_num_rows($products)) {
?>
                  <tr class="dataTableHeadingRow">
                    <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_PROPERTIES_PRODUCT; ?>&nbsp;</td>
                    <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_PROPERTIES_OPTIONS_VALUE; ?>&nbsp;</td>
                  </tr>
<?php
      $rows = 0;
      while ($products_values = tep_db_fetch_array($products)) {
        $rows++;
?>
                  <tr class="<?php echo (floor($rows/2) == ($rows/2) ? 'properties-even' : 'properties-odd'); ?>">
                    <td class="smallText"><?php echo $products_values['products_name']; ?>&nbsp;</td>
                    <td class="smallText"><?php echo $products_values['products_options_values_name']; ?>&nbsp;</td>
                  </tr>
<?php
      }
?>
                  <tr>
                    <td colspan="2" class="main"><br><?php echo TEXT_WARNING_OF_DELETE; ?></td>
                  </tr>
                  <tr>
                    <td align="right" colspan="2" class="main"><br><?php echo '<a href="' . tep_href_link(FILENAME_PRODUCTS_PROPERTIES, 'cID=' . $_GET['cID'], 'NONSSL') . '">'; ?><?php echo tep_image_button('button_cancel.gif', IMAGE_CANCEL); ?></a></td>
                  </tr>
<?php
    } else {
?>
                  <tr>
                    <td class="main" colspan="2"><br><?php echo TEXT_OK_TO_DELETE; ?></td>
                  </tr>
                  <tr>
                    <td class="main" align="right" colspan="2"><br><?php echo '<a href="' . tep_href_link(FILENAME_PRODUCTS_PROPERTIES, 'action=delete_option&option_id=' . $_GET['option_id'] . '&cID=' . $_GET['cID'], 'NONSSL') . '">'; ?><?php echo tep_image_button('button_delete.gif', IMAGE_DELETE); ?></a>&nbsp;<?php echo '<a href="' . tep_href_link(FILENAME_PRODUCTS_PROPERTIES, 'cID=' . $_GET['cID'], 'NONSSL') . '">'; ?><?php echo tep_image_button('button_cancel.gif', IMAGE_CANCEL); ?></a></td>
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
                <td colspan="2" class="pageHeading"><?php echo HEADING_TITLE_PROPERTIES_OPTIONS; ?>&nbsp;</td>
              </tr>
              <tr>
                <td colspan="2" class="smallText">
<?php
    $options = "select * from " . TABLE_PRODUCTS_PROP_OPTIONS . " where categories_options_id = '" . (int)$_GET['cID'] . "' and language_id = '" . (int)$languages_id . "' order by products_options_name";
?>
                </td>
              </tr>
              <tr class="dataTableHeadingRow">
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_PROPERTIES_OPTIONS_NAME; ?>&nbsp;</td>
                <td class="dataTableHeadingContent" align="center"><?php echo TABLE_HEADING_PROPERTIES_ACTION; ?>&nbsp;</td>
              </tr>
<?php
    $rows = 0;
    $options = tep_db_query($options);
    while ($options_values = tep_db_fetch_array($options)) {
      $rows++;
?>
              <tr class="<?php echo (floor($rows/2) == ($rows/2) ? 'properties-even' : 'properties-odd'); ?>">
<?php
      if (($action == 'update_option') && ($_GET['option_id'] == $options_values['products_options_id'])) {
        echo '<form name="option" action="' . tep_href_link(FILENAME_PRODUCTS_PROPERTIES, 'action=update_option_name', 'NONSSL') . '" method="post">';
        $inputs = '';
        for ($i = 0, $n = sizeof($languages); $i < $n; $i ++) {
          $option_name = tep_db_query("select products_options_name from " . TABLE_PRODUCTS_PROP_OPTIONS . " where categories_options_id = '" . $_GET['cID'] . "' and products_options_id = '" . $options_values['products_options_id'] . "' and language_id = '" . $languages[$i]['id'] . "'");
          $option_name = tep_db_fetch_array($option_name);
          $inputs .= tep_image(DIR_WS_CATALOG_LANGUAGES . $languages[$i]['directory'] . '/images/' . $languages[$i]['image'], $languages[$i]['name']) . '&nbsp;<input type="text" name="option_name[' . $languages[$i]['id'] . ']" size="20" value="' . $option_name['products_options_name'] . '">&nbsp;<br>';
        }
?>
                <td class="smallText"><input type="hidden" name="option_id" value="<?php echo $options_values['products_options_id']; ?>"><input type="hidden" name="category_id" value="<?php echo $options_values['categories_options_id']; ?>"><?php echo $inputs; ?></td>
                <td align="center" class="smallText">&nbsp;<?php echo tep_image_submit('button_update.gif', IMAGE_UPDATE); ?>&nbsp;<?php echo '<a href="' . tep_href_link(FILENAME_PRODUCTS_PROPERTIES, 'cID=' . $_GET['cID'], 'NONSSL') . '">'; ?><?php echo tep_image_button('button_cancel.gif', IMAGE_CANCEL); ?></a>&nbsp;</td>
<?php
        echo '</form>' . "\n";
      } else {
?>
                <td class="smallText"><?php echo $options_values["products_options_name"]; ?>&nbsp;</td>
                <td align="right" class="smallText">&nbsp;<?php echo '<a href="' . tep_href_link(FILENAME_PRODUCTS_PROPERTIES, 'action=update_option&option_id=' . $options_values['products_options_id'] . '&cID=' . $options_values['categories_options_id'], 'NONSSL') . '">'; ?><?php echo tep_image_button('button_edit.gif', IMAGE_EDIT); ?></a>&nbsp;<?php echo '<a href="' . tep_href_link(FILENAME_PRODUCTS_PROPERTIES, 'action=delete_product_option&option_id=' . $options_values['products_options_id'] . '&cID=' . $options_values['categories_options_id'], 'NONSSL') , '">'; ?><?php echo tep_image_button('button_delete.gif', IMAGE_DELETE); ?></a></td>
<?php
      }
?>
              </tr>
<?php
    }

    if ($action != 'update_option') {
?>
              <tr class="<?php echo (floor($rows/2) == ($rows/2) ? 'properties-odd' : 'properties-even'); ?>">
<?php
      echo '<form name="options" action="' . tep_href_link(FILENAME_PRODUCTS_PROPERTIES, 'action=add_product_options', 'NONSSL') . '" method="post"><input type="hidden" name="categories_options_id" value="' . $_GET['cID'] . '">';
      $inputs = '';
      for ($i = 0, $n = sizeof($languages); $i < $n; $i ++) {
        $inputs .= tep_image(DIR_WS_CATALOG_LANGUAGES . $languages[$i]['directory'] . '/images/' . $languages[$i]['image'], $languages[$i]['name']) . '&nbsp;<input type="text" name="option_name[' . $languages[$i]['id'] . ']" size="20">&nbsp;<br>';
      }
?>
                <td class="smallText"><?php echo $inputs; ?></td>
                <td align="right" class="smallText" valign="bottom">&nbsp;<?php echo tep_image_submit('button_insert.gif', IMAGE_INSERT); ?></td>
<?php
      echo '</form>';
?>
              </tr>
<?php
    }
  }
?>
            </table></td>
          </tr>
          <tr>
	        	<td>&nbsp;<?php echo tep_image(DIR_WS_IMAGES . 'pixel_trans.gif', '1', '53'); ?>&nbsp;</td>
					</tr>
          <tr>
            <td valign="top" width="100%"><table width="100%" border="0" cellspacing="0" cellpadding="2">
<?php
  if ($action == 'delete_option_value') { 
    $values = tep_db_query("select products_options_values_id, products_options_values_name from " . TABLE_PRODUCTS_PROP_OPTIONS_VALUES . " where categories_options_values_id = '" . (int)$_GET['cID'] . "' and products_options_values_id = '" . (int)$_GET['value_id'] . "' and language_id = '" . (int)$languages_id . "'");
    $values_values = tep_db_fetch_array($values);
?>
              <tr>
                <td class="pageHeading"><?php echo $values_values['products_options_values_name']; ?>&nbsp;</td>
              </tr>
              <tr>
                <td><table class="table-padding-2">
<?php
    $products = tep_db_query("select p.products_id, pd.products_name, ppo.products_options_name from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_PROPERTIES . " pp, " . TABLE_PRODUCTS_PROP_OPTIONS . " ppo, " . TABLE_PRODUCTS_DESCRIPTION . " pd where pd.products_id = p.products_id and pd.language_id = '" . (int)$languages_id . "' and ppo.language_id = '" . (int)$languages_id . "' and pp.products_id = p.products_id and pp.options_values_id='" . (int)$_GET['value_id'] . "' and ppo.products_options_id = pp.options_id order by pd.products_name");
    if (tep_db_num_rows($products)) {
?>
                  <tr class="dataTableHeadingRow">
                    <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_PROPERTIES_PRODUCT; ?>&nbsp;</td>
                    <td class="dataTableHeadingContent">&nbsp;<?php echo TABLE_HEADING_PROPERTIES_OPTIONS_NAME; ?>&nbsp;</td>
                  </tr>
<?php
      while ($products_values = tep_db_fetch_array($products)) {
        $rows++;
?>
                  <tr class="<?php echo (floor($rows/2) == ($rows/2) ? 'properties-even' : 'properties-odd'); ?>">
                    <td class="smallText"><?php echo $products_values['products_name']; ?>&nbsp;</td>
                    <td class="smallText">&nbsp;<?php echo $products_values['products_options_name']; ?>&nbsp;</td>
                  </tr>
<?php
      }
?>
                  <tr>
                    <td class="main" colspan="2"><br><?php echo TEXT_WARNING_OF_DELETE; ?></td>
                  </tr>
                  <tr>
                    <td class="main" align="right" colspan="2"><br><?php echo '<a href="' . tep_href_link(FILENAME_PRODUCTS_PROPERTIES, 'cID=' . $_GET['cID'], 'NONSSL') . '">'; ?><?php echo tep_image_button('button_cancel.gif', IMAGE_CANCEL); ?></a></td>
                  </tr>
<?php
    } else {
?>
                  <tr>
                    <td class="main" colspan="2"><br><?php echo TEXT_OK_TO_DELETE; ?></td>
                  </tr>
                  <tr>
                    <td class="main" align="right" colspan="2"><br><?php echo '<a href="' . tep_href_link(FILENAME_PRODUCTS_PROPERTIES, 'action=delete_value&value_id=' . $_GET['value_id'] . '&cID=' . $_GET['cID'], 'NONSSL') . '">'; ?><?php echo tep_image_button('button_delete.gif', IMAGE_DELETE); ?></a>&nbsp;<?php echo '<a href="' . tep_href_link(FILENAME_PRODUCTS_PROPERTIES, 'cID=' . $_GET['cID'], 'NONSSL') . '">'; ?><?php echo tep_image_button('button_cancel.gif', IMAGE_CANCEL); ?></a></td>
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
                <td colspan="3" class="pageHeading"><?php echo HEADING_TITLE_PROPERTIES_VALUE; ?>&nbsp;</td>
              </tr>
              <tr>
                <td colspan="3" class="smallText">
<?php
    $values = "select ppov.products_options_values_id, ppov.categories_options_values_id, ppov.products_options_values_name, ppov2ppo.products_options_id from " . TABLE_PRODUCTS_PROP_OPTIONS_VALUES . " ppov left join " . TABLE_PRODUCTS_PROP_OPTIONS_VALUES_TO_PRODUCTS_PROP_OPTIONS . " ppov2ppo on ppov.products_options_values_id = ppov2ppo.products_options_values_id where ppov.categories_options_values_id = '" . $_GET['cID'] . "' and ppov.language_id = '" . (int)$languages_id . "' order by ppov.products_options_values_id";
?>
                </td>
              </tr>
              <tr class="dataTableHeadingRow">
                <td class="dataTableHeadingContent">&nbsp;<?php echo TABLE_HEADING_PROPERTIES_OPTIONS_NAME; ?>&nbsp;</td>
                <td class="dataTableHeadingContent">&nbsp;<?php echo TABLE_HEADING_PROPERTIES_OPTIONS_VALUE; ?>&nbsp;</td>
                <td class="dataTableHeadingContent" align="center">&nbsp;<?php echo TABLE_HEADING_PROPERTIES_ACTION; ?>&nbsp;</td>
              </tr>
<?php
    $rows = 0;
    $values = tep_db_query($values);
    while ($values_values = tep_db_fetch_array($values)) {
      $options_name = tep_get_properties_options_name($values_values['products_options_id']);
      $values_name = $values_values['products_options_values_name'];
      $rows++;
?>
              <tr class="<?php echo (floor($rows/2) == ($rows/2) ? 'properties-even' : 'properties-odd'); ?>">
<?php
      if (($action == 'update_option_value') && ($_GET['value_id'] == $values_values['products_options_values_id'])) {
        echo '<form name="values" action="' . tep_href_link(FILENAME_PRODUCTS_PROPERTIES, 'action=update_value&cID=' . $_GET['cID'], 'NONSSL') . '" method="post">';
        $inputs = '';
        for ($i = 0, $n = sizeof($languages); $i < $n; $i ++) {
          $value_name = tep_db_query("select products_options_values_name from " . TABLE_PRODUCTS_PROP_OPTIONS_VALUES . " where products_options_values_id = '" . (int)$values_values['products_options_values_id'] . "' and categories_options_values_id = '" . $_GET['cID'] . "' and language_id = '" . (int)$languages[$i]['id'] . "'");
          $value_name = tep_db_fetch_array($value_name);
          $inputs .= tep_image(DIR_WS_CATALOG_LANGUAGES . $languages[$i]['directory'] . '/images/' . $languages[$i]['image'], $languages[$i]['name']) . '&nbsp;<input type="text" name="value_name[' . $languages[$i]['id'] . ']" size="15" value="' . $value_name['products_options_values_name'] . '">&nbsp;<br>';
        }
?>
                <td align="left" class="smallText top-valign"><input type="hidden" name="value_id" value="<?php echo $values_values['products_options_values_id']; ?>"><input type="hidden" name="category_id" value="<?php echo $values_values['categories_options_values_id']; ?>"><?php echo "\n"; ?>&nbsp;<select name="option_id">
<?php
        $options = tep_db_query("select products_options_id, products_options_name from " . TABLE_PRODUCTS_PROP_OPTIONS . " where categories_options_id = '" . $_GET['cID'] . "' and language_id = '" . (int)$languages_id . "' order by products_options_name");
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
                <td align="center" class="smallText">&nbsp;<?php echo tep_image_submit('button_update.gif', IMAGE_UPDATE); ?>&nbsp;<?php echo '<a href="' . tep_href_link(FILENAME_PRODUCTS_PROPERTIES, 'cID=' . $_GET['cID'], 'NONSSL') . '">'; ?><?php echo tep_image_button('button_cancel.gif', IMAGE_CANCEL); ?></a>&nbsp;</td>
<?php
        echo '</form>';
      } else {
?>
                <td align="left" class="smallText">&nbsp;<?php echo $options_name; ?>&nbsp;</td>
                <td class="smallText">&nbsp;<?php echo $values_name; ?>&nbsp;</td>
                <td align="right" class="smallText">&nbsp;<?php echo '<a href="' . tep_href_link(FILENAME_PRODUCTS_PROPERTIES, 'action=update_option_value&value_id=' . $values_values['products_options_values_id'] . '&cID=' . $_GET['cID'], 'NONSSL') . '">'; ?><?php echo tep_image_button('button_edit.gif', IMAGE_UPDATE); ?></a>&nbsp;<?php echo '<a href="' . tep_href_link(FILENAME_PRODUCTS_PROPERTIES, 'action=delete_option_value&value_id=' . $values_values['products_options_values_id'] . '&cID=' . $_GET['cID'], 'NONSSL') , '">'; ?><?php echo tep_image_button('button_delete.gif', IMAGE_DELETE); ?></a></td>
<?php
      }
    }
?>
              </tr>
<?php
    if ($action != 'update_option_value') {
?>
              <tr class="<?php echo (floor($rows/2) == ($rows/2) ? 'properties-odd' : 'properties-even'); ?>">
<?php
      echo '<form name="values" action="' . tep_href_link(FILENAME_PRODUCTS_PROPERTIES, 'action=add_product_option_values&cID=' . $_GET['cID'], 'NONSSL') . '" method="post">';
?>
                <td align="left" class="smallText top-valign">&nbsp;<select name="option_id">
<?php
      $options = tep_db_query("select products_options_id, products_options_name from " . TABLE_PRODUCTS_PROP_OPTIONS . " where categories_options_id = '" . $_GET['cID'] . "' and language_id = '" . $languages_id . "' order by products_options_name");
      while ($options_values = tep_db_fetch_array($options)) {
        echo '<option name="' . $options_values['products_options_name'] . '" value="' . $options_values['products_options_id'] . '">' . $options_values['products_options_name'] . '</option>';
      }

      $inputs = '';
      for ($i = 0, $n = sizeof($languages); $i < $n; $i ++) {
        $inputs .= tep_image(DIR_WS_CATALOG_LANGUAGES . $languages[$i]['directory'] . '/images/' . $languages[$i]['image'], $languages[$i]['name']) . '&nbsp;<input type="text" name="value_name[' . $languages[$i]['id'] . ']" size="15">&nbsp;<br>';
      }
?>
                </select>&nbsp;</td>
                <td class="smallText"><input type="hidden" name="category_id" value="<?php echo $_GET['cID']; ?>"><?php echo $inputs; ?></td>
                <td align="right" class="smallText" valign="bottom">&nbsp;<?php echo tep_image_submit('button_insert.gif', IMAGE_INSERT); ?></td>
<?php
      echo '</form>';
?>
              </tr>
<?php
    }
  }
?>
            </table></td>
          </tr>
        </table></td>
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
