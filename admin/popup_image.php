<?php
/*
  $Id: popup_image.php,v 1.7 2003/06/20 00:40:23 hpdl Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/

  require('includes/application_top.php');

if ($_GET['image']) {

     $big_image = tep_image(DIR_WS_CATALOG_IMAGES . $_GET['image'], $_GET['image']);

} else {

  reset($_GET);
  while (list($key, ) = each($_GET)) {
    switch ($key) {
      case 'banner':
        $banners_id = tep_db_prepare_input($_GET['banner']);

        $banner_query = tep_db_query("select banners_title, banners_image, banners_html_text from " . TABLE_BANNERS . " where banners_id = '" . (int)$banners_id . "'");
        $banner = tep_db_fetch_array($banner_query);

        $page_title = $banner['banners_title'];

        if ($banner['banners_html_text']) {
          $image_source = $banner['banners_html_text'];
        } elseif ($banner['banners_image']) {
          $image_source = tep_image(HTTP_CATALOG_SERVER . DIR_WS_CATALOG_IMAGES . 'banner/' . $banner['banners_image'], $page_title);
        }
        break;
    }
  }
 }
?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<title><?php echo $page_title . $_GET['image']; ?></title>
<script language="javascript"><!--
var i=0;

function resize() {
  if (navigator.appName == 'Netscape') i = 40;
  window.resizeTo(document.images[0].width + 30, document.images[0].height + 60 - i);
}
//--></script>
</head>

<body onload="resize();">

<?php
   if ($_GET['image']) {
         echo $big_image;
         } else {
         echo $image_source;
   }
 ?>

</body>

</html>
