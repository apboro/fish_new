<?php
/*
  $Id: options_images.php,v 1.0 2003/08/18 

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/
  require('includes/application_top.php');
	
  //check that destination directory exists and is writeable
  if (is_dir(DIR_FS_CATALOG_IMAGES . 'options/')) {
    if (!is_writeable(DIR_FS_CATALOG_IMAGES . 'options/')) $messageStack->add(ERROR_OPTIONS_IMAGES_DIRECTORY_NOT_WRITEABLE, 'error');
  } else {
    $messageStack->add(ERROR_OPTIONS_IMAGE_DIRECTORY_DOES_NOT_EXIST, 'error');
  }

  if ($_GET['action']) {
    switch ($_GET['action']) {
      case 'save':
        $image_source = $_FILES['value_image_input']['tmp_name'];
        $filename = $_FILES['value_image_input']['name'];
        $image_destination = DIR_FS_CATALOG_IMAGES . 'options/' . $filename;
        $cID = tep_db_prepare_input($_GET['cID']);
        copy($image_source , $image_destination)	or die("unable to copy $image_source to location $image_destination");
        tep_db_query("update " . TABLE_PRODUCTS_OPTIONS_VALUES . " set products_options_values_thumbnail = '" . tep_db_input($filename) . "'  where products_options_values_id = '" . tep_db_input($cID) . "'");
        tep_redirect(tep_href_link(FILENAME_OPTIONS_IMAGES, '&cID=' . $cID . '&box_id=' . $_GET['box_id']));
        break;
        
      case 'update_enabled':
        tep_db_query("update " . TABLE_PRODUCTS_OPTIONS . " set products_options_images_enabled = 'false'");
        if ( !empty($_POST ['option_select']) ) {
          foreach ($_POST ['option_select'] as $options_selected){
            tep_db_query("update " . TABLE_PRODUCTS_OPTIONS .  " set products_options_images_enabled = 'true' where products_options_id = '" . $options_selected . "'"); 
          }
        }
        break;

      case 'delete':
        $options_query = tep_db_query("select products_options_values_thumbnail from " . TABLE_PRODUCTS_OPTIONS_VALUES . " where  products_options_values_id = '" . $_GET['cID'] . "'");
        $options_id = tep_db_fetch_array($options_query);
        @unlink(DIR_FS_CATALOG_IMAGES.'options/'.$options_id['products_options_values_thumbnail']);

        //tep_db_query("update " . TABLE_PRODUCTS_OPTIONS_VALUES . " set products_options_values_thumbnail = '' where products_options_values_id = '" . tep_db_input($vID) . "'");
        tep_db_query("update " . TABLE_PRODUCTS_OPTIONS_VALUES . " set products_options_values_thumbnail = '' where products_options_values_id = '" . $_GET['cID'] . "'");
        tep_redirect(tep_href_link(FILENAME_OPTIONS_IMAGES, tep_get_all_get_params(array('action'))));
        break;

      case 'frdelete':
        $options_query = tep_db_query("select products_options_thumbnail from " . TABLE_PRODUCTS_OPTIONS . " where products_options_id = '" . (int)$oID . "'");
        $options_id = tep_db_fetch_array($options_query);
        @unlink(DIR_FS_CATALOG_IMAGES.'options/'.$options_id['products_options_thumbnail']);
        tep_db_query("update " . TABLE_PRODUCTS_OPTIONS . " set products_options_thumbnail = '' where products_options_id = '" . (int)$oID . "'");
        //tep_redirect(tep_href_link(FILENAME_OPTIONS_IMAGES, tep_get_all_get_params(array('action'))));
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
            <td class="pageHeading"><?php echo HEADER_TITLE; ?></td>
            <td class="pageHeading" align="right"><?php echo tep_draw_separator('pixel_trans.gif', HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?></td>
          </tr>
          <tr><td class="smalltext"><?php echo TEXT_SELECT_ATTRIBUTE; ?>  
<?php
      if (isset($_POST['box_select'])){
        $options_id = $_POST['box_select'];
      }else if (isset($_GET['box_id'])){
        $options_id = $_GET['box_id'];
      }else if (isset($_GET['cID'])){
        $options_query = tep_db_query("select products_options_id from " . TABLE_PRODUCTS_OPTIONS_VALUES_TO_PRODUCTS_OPTIONS . " where products_options_values_id='" . $_GET['cID'] . "'");

        $options = tep_db_fetch_array ($options_query);
        $options_id = $options['products_options_id'];
      }else{
        $options_id = 1;
      }


      $options_query = tep_db_query("select * from " . TABLE_PRODUCTS_OPTIONS . " where language_id='" . $languages_id . "'");
//	  echo "select * from " . TABLE_PRODUCTS_OPTIONS . " where language_id='" . $language_id . "'";
			$i=0;
      while ($options = tep_db_fetch_array ($options_query)){
			  $values[$i]['id']= $options['products_options_id'];
			  $values[$i]['text']= $options['products_options_name'];
			  $i++;
      }
      echo tep_draw_form('box_selection', FILENAME_OPTIONS_IMAGES,'');
      echo tep_draw_pull_down_menu('box_select', $values, $options_id, 'onChange="this.form.submit();"');
      echo '</form>';
				
?>
            </td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><table class="table-padding-0">
          <tr>
            <td valign="top"><table class="table-padding-2">
              <tr class="dataTableHeadingRow">
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_NAME; ?></td>
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_IMAGE; ?></td>
								<td class="dataTableHeadingContent"><?php echo TABLE_HEADING_IMAGE_NAME; ?></td>
              </tr>
<?php
  	
  $query1 = tep_db_query("select * from " . TABLE_PRODUCTS_OPTIONS_VALUES_TO_PRODUCTS_OPTIONS . " where products_options_id = '" . $options_id . "'" );
	//First find all the products options values that belong to the selected product option
  while ($result1 = tep_db_fetch_array($query1)) {
	  $products_options_values_id = $result1['products_options_values_id'];

		//Now pull their details from the database
   $query2 = tep_db_query ("select * from " . TABLE_PRODUCTS_OPTIONS_VALUES . " where products_options_values_id = '" . $products_options_values_id . "' and language_id = '" .$languages_id . "'");
		while ($result2 = tep_db_fetch_array($query2)) {
		  $products_options_values_name = $result2 ['products_options_values_name']; 
		  $products_options_values_thumbnail = $result2['products_options_values_thumbnail'];
		   
	
	  if ($_GET['cID'] == $products_options_values_id){
	  $selected_value['name'] = $products_options_values_name;
	  $selected_value['image'] = $products_options_values_thumbnail;
	  $selected_value['id'] = $products_options_values_id;
	  } 
	
	if ( (isset($selected_value['id'])) && ($products_options_values_id == $selected_value['id']) ) {
      echo '<tr class="dataTableRowSelected" onmouseover="this.style.cursor=\'hand\'" onclick="document.location.href=\'' . tep_href_link(FILENAME_OPTIONS_IMAGES, '&cID=' . $products_options_values_id . '&box_id=' . $options_id . '&action=edit') . '\'">' . "\n";
    } else {
      echo '<tr class="dataTableRow" onmouseover="this.className=\'dataTableRowOver\';this.style.cursor=\'hand\'" onmouseout="this.className=\'dataTableRow\'" onclick="document.location.href=\'' . tep_href_link(FILENAME_OPTIONS_IMAGES, '&cID=' . $products_options_values_id . '&box_id=' . $options_id ) . '\'">' . "\n";
    }

?>
                <td class="dataTableContent"><?php echo $products_options_values_name ?></td>
                <td class="dataTableContent" align="center"><?php echo tep_image(DIR_WS_CATALOG_IMAGES . 'options/' . $products_options_values_thumbnail, $products_options_values_name, OPTIONS_IMAGES_WIDTH, OPTIONS_IMAGES_HEIGHT) ?></td>
                <td class="dataTableContent"><?php echo $products_options_values_thumbnail ?></td>
          </tr>
<?php
    }
  }
?>

  </table></td>
<?php	
  $heading = array();
  $contents = array();
  switch ($_GET['action']) {
    case 'edit':
      $heading[] = array('text' => '<b>'.$selected_value['name'].'</b>');
      $contents = array('form' => tep_draw_form('value_image_input', FILENAME_OPTIONS_IMAGES, '&cID=' . $selected_value['id'] . '&box_id=' . $options_id . '&action=save', 'post', 'enctype="multipart/form-data"'));
      $contents[] = array('text' => TEXT_INFO_EDIT_INTRO);
      $contents[] = array('text' => '<br>' . TEXT_SELECT_FILE . '<br>' . tep_draw_file_field('value_image_input'));
      $contents[] = array('align' => 'center', 'text' => '<br>' . tep_image_submit('button_update.gif', IMAGE_UPDATE) . '&nbsp;<a href="' . tep_href_link(FILENAME_OPTIONS_IMAGES, '&cID=' . $selected_value['id']) . '&box_id=' . $options_id .'">' . tep_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>');
      break;


    default:
       if (isset ($selected_value['id'])){
        $heading[] = array('text' => '<b>' . $selected_value['name'] . '</b>');
        
        
        
        
        
        $contents[] = array('align' => 'center', 'text' => '<a href="' . tep_href_link(FILENAME_OPTIONS_IMAGES, '&cID=' . $selected_value['id'] . '&box_id=' . $options_id . '&action=edit') . '">' . tep_image_button('button_edit.gif', IMAGE_EDIT) . '</a> <a href="' . tep_href_link(FILENAME_OPTIONS_IMAGES, '&cID=' . $selected_value['id']. '&box_id=' . $options_id . '&action=delete') . '">' . tep_image_button('button_delete.gif', IMAGE_DELETE) . '</a>');
        break;
      }
    }
  if ( (tep_not_null($heading)) && (tep_not_null($contents)) ) {
    echo '            <td width="25%" valign="top" align="center">' . "\n";

    $box = new box;
    echo $box->infoBox($heading, $contents);

    echo '            </td>' . "\n";

  }

?>
          </tr>
					
	<tr><td>
	
<?php
  echo tep_draw_form('update_enabled_options', FILENAME_OPTIONS_IMAGES, '&cID=' . $selected_value['id'] . '&box_id=' . $options_id . '&action=update_enabled', 'post');  
  echo '<tr><td class="smalltext">'.TEXT_ENABLE_DISABLE.'</td></tr>';
  $options_query = tep_db_query("select * from " . TABLE_PRODUCTS_OPTIONS . " where language_id = '" . $languages_id . "'");
	
	echo '<tr><td class="smalltext">';
	while ($options = tep_db_fetch_array ($options_query)){
  	if ($options['products_options_images_enabled'] == 'true') $checked = true;
		else $checked = false;
	  echo $options['products_options_name'] . tep_draw_selection_field('option_select[' . $options['products_options_id'] . ']', 'checkbox', $options['products_options_id'], $checked) . '  |  ';
	}
   	
  echo tep_image_submit('button_update.gif', IMAGE_UPDATE);
	echo '</td></tr>';

 	
?>
					

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