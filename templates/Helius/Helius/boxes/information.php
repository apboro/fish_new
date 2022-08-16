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
          <tr>
            <td>
<?php


  $info_box_contents = array();
    $info_box_contents[] = array('text'  => '<font color="' . $font_color . '">' . BOX_HEADING_INFORMATION . '</font>');
  new infoBoxHeading($info_box_contents, false, false);
  
//BEGIN Added Lines: Dynamic Information pages
    $information_pages_query = tep_db_query("select p.pages_id, pd.pages_name from " . TABLE_PAGES . " p, " . TABLE_PAGES_DESCRIPTION . " pd where p.pages_status = '1' and p.pages_id = pd.pages_id and pd.language_id = '" . $languages_id . "' order by p.sort_order, pd.pages_name");

//To use numbered listing like in the bestsellers box: Replace || . tep_image(DIR_WS_IMAGES . 'tri.gif') . || with || . tep_row_number_format($rows) .

    $rows = 0;
    while ($information_pages = tep_db_fetch_array($information_pages_query)) {
      $rows++;
      $information_list .= '<a href="' . tep_href_link(FILENAME_INFORMATION, 'pages_id=' . $information_pages['pages_id'] . ''  .  $information_pages[''])  . '">' . $information_pages['pages_name'] . '</a><br>';
    }

//END Added Lines: Dynamic Information pages
   $info_box_contents = array();
$info_box_contents[] = array('text' =>  $information_list .
                                         '<a href="' . tep_href_link(FILENAME_PRICE_XLS) . '">' . BOX_INFORMATION_PRICE_XLS . '</a><br>' .
                                         '<a href="' . tep_href_link(FILENAME_PRICE_HTML) . '">' . BOX_INFORMATION_PRICE_HTML . '</a><br>' .
                                         '<a href="' . tep_href_link(FILENAME_CONTACT_US) . '">' . BOX_INFORMATION_CONTACT . '</a><br>');

new infoBox($info_box_contents);

$info_box_contents = array();
  $info_box_contents[] = array('align' => 'left',
                                'text'  => tep_draw_separator('pixel_trans.gif', '100%', '1')
                              );
  new infoboxFooter($info_box_contents, true, true);
?>
            </td>
          </tr>
<!-- information_eof //-->
