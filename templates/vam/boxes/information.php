<?php
/*
  $Id: information.php,v 1.1.1.1 2003/09/18 19:05:51 wilt Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2001 osCommerce

  Released under the GNU General Public License
*/
?>
<!-- information //-->
<div class="box">
<b class="top"><b class="b1"></b><b class="b2"></b><b class="b3"></b><b class="b4"></b><b class="b5"></b></b>
<div class="boxHeader">
<h5><?php echo BOX_HEADING_INFORMATION; ?></h5>
</div>
<div class="boxContent">
<?php
  
//BEGIN Added Lines: Dynamic Information pages
    $information_pages_query = tep_db_query("select p.pages_id, pd.pages_name from " . TABLE_PAGES . " p, " . TABLE_PAGES_DESCRIPTION . " pd where p.pages_status = '1' and p.pages_id = pd.pages_id and pd.language_id = '" . $languages_id . "' order by p.sort_order, pd.pages_name");

//To use numbered listing like in the bestsellers box: Replace || . tep_image(DIR_WS_IMAGES . 'tri.gif') . || with || . tep_row_number_format($rows) .

    $rows = 0;
    while ($information_pages = tep_db_fetch_array($information_pages_query)) {
      $rows++;
      $information_list .= '<a href="' . tep_href_link(FILENAME_INFORMATION, 'pages_id=' . $information_pages['pages_id'] . ''  .  $information_pages[''])  . '">' . $information_pages['pages_name'] . '</a><br>';
    }

//END Added Lines: Dynamic Information pages
   echo  $information_list .
                                         '<a href="' . tep_href_link(FILENAME_PRICE_XLS) . '">' . BOX_INFORMATION_PRICE_XLS . '</a><br>' .
                                         '<a href="' . tep_href_link(FILENAME_PRICE_HTML) . '">' . BOX_INFORMATION_PRICE_HTML . '</a><br>' .
                                         '<a href="' . tep_href_link(FILENAME_CONTACT_US) . '">' . BOX_INFORMATION_CONTACT . '</a><br>';

?>
</div>
<b class="bottom"><b class="b5b"></b><b class="b4b"></b><b class="b3b"></b><b class="b2b"></b><b class="b1b"></b></b>
</div>
<!-- information_eof //-->