<?php
/* --------------------------------------------------------------
   $Id: yml_import.php,v 1.1 2010-08-06 17:36:57 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2010 VaMSoft Ltd.
   --------------------------------------------------------------
   Released under the GNU General Public License
   --------------------------------------------------------------*/
   
function unhtmlentities($string) {
  $trans_tbl = get_html_translation_table(HTML_ENTITIES);
  $trans_tbl = array_flip ($trans_tbl);
  return strtr ($string, $trans_tbl);
}

require('includes/application_top.php');

if ($_POST['action']=='import') {
  if (is_uploaded_file($_FILES['xml_file']['tmp_name'])) {


$xml = simplexml_load_file($_FILES['xml_file']['tmp_name']);

    $count=0;
    $count_upd=0;
    $count_add=0;
    $count_cat_upd=0;
    $count_cat_add=0;
    
    // Categories import
    
    foreach ($xml->shop->categories->category as $category) {

      $categories_id = $category['id'];
      $parent_id = ((!isset($category['parentId'])) ? 0 : $category['parentId']);
      $categories_name = unhtmlentities($category);
      $categories_description = '';

      $categories_query = tep_db_query("select categories_name from " . TABLE_CATEGORIES_DESCRIPTION . " where categories_id = '" . $categories_id . "' and language_id = '".(int)$languages_id."' limit 1");
      if (tep_db_num_rows($categories_query)) {
        $row=tep_db_fetch_array($categories_query);
        if ($row['categories_name']!=$categories_name) {
          tep_db_perform(TABLE_CATEGORIES, array('last_modified' => 'now()', 'parent_id' => $parent_id, 'categories_status' => 1, 'date_added' => 'now()'), 'update', 'categories_id=\''.$categories_id.'\'');
          tep_db_perform(TABLE_CATEGORIES_DESCRIPTION, array('categories_name' => $categories_name, 'categories_description' => $categories_description), 'update', 'categories_id=\''.$categories_id.'\' and language_id=\''.(int)$languages_id.'\'');
          $count_cat_upd++;
        }
      } else {
          tep_db_perform(TABLE_CATEGORIES, array('categories_id' => $categories_id, 'last_modified' => 'now()', 'parent_id' => $parent_id, 'categories_status' => 1, 'date_added' => 'now()'));
          tep_db_perform(TABLE_CATEGORIES_DESCRIPTION, array('categories_id' => $categories_id, 'categories_name' => $categories_name, 'categories_description' => $categories_description));
        $count_cat_add++;
      }
      
    }
        
    // Products import

    foreach ($xml->shop->offers->offer as $product) {
    	
      $products_id = $product['id'];
      $products_quantity = (($product['available']) ? 0 : 10000);
      $products_price = $product->price;
      $categoryId = $product->categoryId;
      $products_image = substr(strrchr($product->picture, "/"), 1);
      $products_name = unhtmlentities($product->name);
      $products_description = unhtmlentities($product->description);
      $products_status = 1;

      $products_query = tep_db_query("select products_id, products_price from " . TABLE_PRODUCTS . " where products_id = '" . $products_id . "' limit 1");
      if (tep_db_num_rows($products_query)) {
        $row=tep_db_fetch_array($products_query);
        if ($row['products_price']!=$products_price) {
          tep_db_perform(TABLE_PRODUCTS, array('products_last_modified' => 'now()', 'products_price' => $products_price, 'products_image' => $products_image, 'products_status' => $products_status, 'products_quantity' => $products_quantity, 'products_date_available' => 'now()'), 'update', 'products_id=\''.$products_id.'\'');
          tep_db_perform(TABLE_PRODUCTS_DESCRIPTION, array('products_name' => $products_name, 'products_description' => $products_description), 'update', 'products_id=\''.$products_id.'\' and language_id=\''.(int)$languages_id.'\'');
          $count_upd++;
        }
      } else {
        tep_db_perform(TABLE_PRODUCTS, array('products_id' => $products_id, 'products_last_modified' => 'now()', 'products_price' => $products_price, 'products_image' => $products_image, 'products_status' => $products_status, 'products_quantity' => $products_quantity, 'products_date_available' => 'now()'));
        tep_db_perform(TABLE_PRODUCTS_DESCRIPTION, array('products_id' => $products_id, 'products_name' => $products_name, 'products_description' => $products_description, 'language_id' => (int)$languages_id));
        tep_db_perform(TABLE_PRODUCTS_TO_CATEGORIES, array('products_id' => $products_id, 'categories_id' => $categoryId));
        $count_add++;
      }
      $count++;
    }
    $messageStack->add_session(TEXT_YML_UPDATED.$count_upd, 'success');
    $messageStack->add_session(TEXT_YML_CHANGED.($count-$count_upd), 'success');
    $messageStack->add_session(TEXT_YML_ADDED.$count_add, 'success');
    $messageStack->add_session(TEXT_YML_CAT_ADDED.$count_cat_add, 'success');
    $messageStack->add_session(TEXT_YML_CAT_UPDATED.$count_cat_upd, 'success');
  } else {
    $messageStack->add_session(TEXT_YML_ERROR, 'error');
  }

  tep_redirect(tep_href_link(FILENAME_YML_IMPORT));
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
            <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
            <td class="pageHeading" align="right"><?php echo tep_draw_separator('pixel_trans.gif', HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?></td>
          </tr>
        </table></td>
      </tr>    
      <tr>
        <td><table class="table-padding-0">
          <tr>
        <td class="main">
          <?php echo tep_draw_form('xml_import', FILENAME_YML_IMPORT, '', 'post', 'enctype="multipart/form-data"') ."\n". tep_draw_file_field('xml_file') ."\n"; ?>
          <input type="hidden" name="action" value="import">
          <br>
          <?php echo TEXT_YML_MAX_SIZE; ?> <b><?php echo ini_get('upload_max_filesize'); ?></b><br />
          <span class="button"><button type="submit" value="<?php echo TEXT_YML_IMPORT; ?>"><?php echo TEXT_YML_IMPORT; ?></button>
          </form>
        </td>
        <td class="main" width="50%" valign="bottom">
          <a class="button" href="<?php echo HTTP_SERVER . DIR_WS_CATALOG.'market.php'; ?>" target="_blank"><span><?php echo TEXT_YML_EXPORT; ?></span></a>
        </td>
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