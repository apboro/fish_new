<?php
/*
autocreated script
*/
  require('includes/application_top.php');
?>
    <?php
/*
  $Id: allprods.php,v 1.7 2002/12/02

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2002 osCommerce
  Copyright (c) 2002 HMCservices

  Released under the GNU General Public License
*/


  include(DIR_WS_LANGUAGES . $language . '/' . FILENAME_POLLS);

$content = CONTENT_mapa;

 



?>


<?php
  require(DIR_WS_INCLUDES . 'template_top.php');
?>
<div class="contentContainer">
    <div class="contentText">

<center><p style="font-size:20;">Рыболовный интернет-магазин</p><br></center>

<center><!-- Этот блок кода нужно вставить в ту часть страницы, где вы хотите разместить карту  (начало) -->
<div style="position:relative;overflow:hidden;"><a href="https://yandex.ru/maps/213/moscow/?utm_medium=mapframe&utm_source=maps" style="color:#eee;font-size:12px;position:absolute;top:0px;">Москва</a><a href="https://yandex.ru/maps/213/moscow/house/4_y_likhachyovskiy_pereulok_2s2/Z04YcwVmT0UOQFtvfXR0cXhkYA==/?ll=37.526865%2C55.849660&sll=37.526609%2C55.850474&source=wizgeo&utm_medium=mapframe&utm_source=maps&z=16.2" style="color:#eee;font-size:12px;position:absolute;top:14px;">4-й Лихачёвский переулок, 2с2 на карте Москвы, ближайшее метро Коптево — Яндекс.Карты</a><iframe src="https://yandex.ru/map-widget/v1/-/CCQhZGvXdD" width="560" height="400" frameborder="1" allowfullscreen="true" style="position:relative;"></iframe></div>
 <!--
 <?php
    global $regions;
    ?>
    <div itemscope itemtype="http://schema.org/LocalBusiness">
        <H1 style="font-size:20;"><span itemprop="name">Рыболовный интернет-магазин на Первомайской</span></h1>

        <br>
        <div itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">

            <h3><span itemprop="addressLocality"><?=$regions->showCurrentParam('name')?></span>,
                <span itemprop="streetAddress"><?=$regions->showCurrentParam('address')?></span>,
                <span itemprop="postalCode"><?=$regions->showCurrentParam('postalCode')?></span>
        </div>
-->
<h1><center>4-й Лихачевский переулок, 2с2</center></h1>

        <!-- <br> Режим работы:
        <time itemprop="openingHours" datetime="Mo-Fr">ПН-ПТ с 11:00 до 19:00</time> -->
        <br>По данному адресу находится пункт выдачи заказов и склад.<br>
        <br>Телефон: <br><span itemprop="telephone">8(800)-222-41-49</span><br>
        <div>Электронная почта: <span itemprop="email">magazin@yourfish.ru</span>
        <div><b>Как добраться.</b><br>
Автобус № 123 от МЦК Коптево (либо от метро Водный стадион или Петровско-Разумская)
до остановки "База механизации".
Проходная "Метзавод 66". На проходной показать документ.
От проходной направо - 50 метров прямо, потом направо в дверь под козырьком с надписью Моссварка.</div>
            </h3>
        </div>
    </div>
<?php
  require(DIR_WS_INCLUDES . 'template_bottom.php');
  require(DIR_WS_INCLUDES . 'application_bottom.php');
?>
