<?php
/*
  $Id: shop_by_price.php,v 1.0 2003/5/26  $

  Contribution by Meltus
  http://www.highbarn-consulting.com

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/
?>
          <tr>
            <td>
<?php


    $sukanah='<a href="'.echoHTTP().$_SERVER['HTTP_HOST'].'/legkie-naduvnye-lodki" title="Лодки ЛАС" target=_blank><img src="'.echoHTTP().'yourfish.ru/boatbanner.gif"></a>';
    $info_box_contents = array();
    $info_box_contents[] = array('text'  => '<font color="#45688E">' . BOX_HEADING_WISHLIST . '</font>');
    new infoBoxHeading($info_box_contents, false, false);
    $info_box_contents = array();
    $info_box_contents[] = array('text'  =>  '<font size="1">'.$sukanah. '</font>');
    new infoBox($info_box_contents);


 ?>

                       </td>
          </tr>
