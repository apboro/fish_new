<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2013 osCommerce

  Released under the GNU General Public License
*/

  require('includes/application_top.php');
  require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_INFORMATION);

    $page_info_query = tep_db_query("select p.pages_id, pd.pages_name, pd.pages_description, p.pages_image, p.pages_date_added from " . TABLE_PAGES . " p, " . TABLE_PAGES_DESCRIPTION . " pd where p.pages_status = '1' and p.pages_id = '" . (int)$_GET['pages_id'] . "' and pd.pages_id = p.pages_id and pd.language_id = '" . $languages_id . "'");
    $page_info = tep_db_fetch_array($page_info_query);


  $breadcrumb->add($page_info['pages_name'], tep_href_link(FILENAME_INFORMATION, 'pages_id='.$page_info['pages_id'], 'NONSSL'));

  require(DIR_WS_INCLUDES . 'template_top.php');
?>

<div id="mj-shippingreturns">
<h1><?php echo $page_info['pages_name']; ?></h1>

<div class="contentContainer">
    <div id="mj-content">
<div class="item-page">
<div class="mj-full mj-dotted">
<?php echo $page_info['pages_description'];?>

</div>
</div>
</div>
</div>
</div>
  
</div>
<?php
  require(DIR_WS_INCLUDES . 'template_bottom.php');
  require(DIR_WS_INCLUDES . 'application_bottom.php');
?>
