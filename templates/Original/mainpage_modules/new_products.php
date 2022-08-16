<?php
/*
  $Id: new_products.php,v 1.1.1.1 2003/09/18 19:04:53 wilt Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/
?>
<!-- new_products 22//-->
<?php


 $info_box_contents = array();
  $info_box_contents[] = array('text' => sprintf(TABLE_HEADING_NEW_PRODUCTS, strftime('%B')));

  new infoBoxHeading($info_box_contents, false, false, tep_href_link(FILENAME_PRODUCTS_NEW));


  $row = 0;
  $col = 0;

	  $info_box_contents[$row][$col] = array('align' => 'center',
                                       'params' => 'class="smallText" width="33%" valign="top"',
                                       'text' => '<iframe width="420" height="315" src="https://www.youtube.com/embed/b_nVkPY53LY" frameborder="0" allowfullscreen></iframe>');


   $row = 1;
  $col = 0;

      $info_box_contents[$row][$col] = array('align' => 'center',
                                       'params' => 'class="smallText" width="33%" valign="top"',
                                       'text' => '<a href = "https://youtube.com/user/YourFishru?feature=watch" target="_blank">Еще Видео</a>');






  new contentBox($info_box_contents);
if (MAIN_TABLE_BORDER == 'yes'){
$info_box_contents = array();
  $info_box_contents[] = array('align' => 'left',
                                'text'  => tep_draw_separator('pixel_trans.gif', '100%', '1')
                              );
  new infoboxFooter($info_box_contents, true, true);
}
?>
<!-- new_products_eof //-->
