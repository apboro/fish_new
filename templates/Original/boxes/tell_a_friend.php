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
    $sukanah = array();

$sukanah[] = '<a rel="nofollow" href="https://www.vsemayki.ru/catalog/tourist/fishing?ref=103493" target="_blank">
 <img src="'.echoHTTP().'yourfish.ru/templates/Original/boxes/skyblue_250dush.png" alt="Футболки о рыбалке" title="Футболки о рыбалке" width="170" height="170"/></a>';

$sukanah[] = '<a rel="nofollow" href="https://www.vsemayki.ru/catalog/tourist/fishing?ref=103493" target="_blank">
 <img src="'.echoHTTP().'yourfish.ru/templates/Original/boxes/back_blue_250.bmp" alt="Футболки о рыбалке" title="Футболки о рыбалке" width="170" height="170"/></a>';

$sukanah[] = '<a rel="nofollow" href="https://www.vsemayki.ru/catalog/tourist/fishing?ref=103493" target="_blank">
 <img src="'.echoHTTP().'yourfish.ru/templates/Original/boxes/black_250evo.png" alt="Футболки о рыбалке" title="Футболки о рыбалке" width="170" height="170"/></a>';

$sukanah[] = '<a rel="nofollow" href="https://www.vsemayki.ru/catalog/tourist/fishing?ref=103493" target="_blank">
 <img src="'.echoHTTP().'yourfish.ru/templates/Original/boxes/white_250brak.png" alt="Футболки о рыбалке" title="Футболки о рыбалке" width="170" height="170"/></a>';

$sukanah[] = '<a rel="nofollow" href="https://www.vsemayki.ru/catalog/tourist/fishing?ref=103493" target="_blank">
 <img src="'.echoHTTP().'yourfish.ru/templates/Original/boxes/black_50012.bmp" alt="Футболки о рыбалке" title="Футболки о рыбалке" width="170" height="170"/></a>';

$sukanah[] = '<a rel="nofollow" href="https://www.vsemayki.ru/catalog/tourist/fishing?ref=103493" target="_blank">
 <img src="'.echoHTTP().'yourfish.ru/templates/Original/boxes/black_250uzel.png" alt="Футболки о рыбалке" title="Футболки о рыбалке" width="170" height="170"/></a>';

$sukanah[] = '<a rel="nofollow" href="https://www.vsemayki.ru/catalog/tourist/fishing?ref=103493" target="_blank">
 <img src="'.echoHTTP().'yourfish.ru/templates/Original/boxes/red_500.bmp" alt="Футболки о рыбалке" title="Футболки о рыбалке" width="170" height="170"/></a>';

$sukanah[] = '<a rel="nofollow" href="https://www.vsemayki.ru/catalog/tourist/fishing?ref=103493" target="_blank">
 <img src="'.echoHTTP().'yourfish.ru/templates/Original/boxes/skyblue_250sexnr.png" alt="Футболки о рыбалке" title="Футболки о рыбалке" width="170" height="170"/></a>';



//echo $ukana[array_rand ($ukana)];'


    $info_box_contents = array();
    $info_box_contents[] = array('text'  => '<font color="#45688E">Футболки о рыбалке</font>');
    new infoBoxHeading($info_box_contents, false, false);
    $info_box_contents = array();
    $info_box_contents[] = array('text'  =>  '<figure class="hidecaption">'.$sukanah[array_rand ($sukanah)].'<figcaption>Футболки о рыбалке</figcaption></figure>');

    new infoBox($info_box_contents);
?>
                       </td>
          </tr>