<?php
/*
  $Id: new_products.php,v 1.1.1.1 2003/09/18 19:04:53 wilt Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/
?>
<!-- new_products22 //-->
<?php  $info_box_contents = array();
  $info_box_contents[] = array('text' => sprintf('Что такое рыболовный интернет-магазин?', strftime('%B')));




  $row = 0;
  $col = 0;

	  $info_box_contents[$row][$col] = array('align' => 'center',
                                       'params' => 'class="smallText" width="33%" valign="top"',
                                       'text' => '<p><font size="2"><strong>Рыболовный интернет-магазин</strong> - это совокупность удобства приобретения товаров через интернет, подробного описания приобретаемых снастей, возможность консультации<font size="2"> и невысокие цены</font>.&nbsp;</font></p><p><font size="2">В этих категориях можно выделить <strong>преимущества рыболовного интернет-магазина YourFish.ru</strong>:</font></p><ul><li><font size="2"><strong><em>Абсолютное лидерство по ассортименту</em></strong> - в нашем магазине есть возможность заказа снастей от примерно 80% представленных в России крупных мировых фирм-производителей.</font></li><li><font size="2"><em><strong>Любые консультации по снастям</strong></em> - наши специалисты просто фанаты рыбалки! Вы получите абсолютно грамотную консультацию по подбору снастей и снаряжения для рыбалки!</font></li><li><font size="2"><strong><em>Постоянное сопровождение заказа</em></strong> - вы можете отслеживать состояние заказа по статусам в личном кабинете или связаться с менеджером магазина любым удобным для Вас способом.</font></li><li><font size="2"><strong><em>Возможность самовывоза заказа </em></strong>- Вы всегда можете подъехать к нам в магазин по адресу: Щелковское ш. д.3. Смотрите <a href="https://www.yourfish.ru/map.htm"><font color="#009900"><strong>схему проезда</strong></font></a>. Вы сэкономите на доставке и познакомитесь с нашим коллективом! Более того, площадь нашего магазина более 100м2! Вы можете &quot;пощупать&quot; то, что не решились бы купить через интернет без предварительного осмотра. </font></li><li><font size="2"><em><strong>Возможность купить снасти намного дешевле</strong></em> - пер<font size="2">и</font>одически обновляемый раздел <font color="#009900"><strong><a href="../index.php/cPath/365">Скидки</a></strong></font> содержит снасти и снаряжение по тем или иным причинам не подошедшее покупателям, а также немалую часть ассортимента нашего магазина в Москве. Помимо этого, у постоянных клиентов нашего интернет магазина есть постоянная скидка!</font></li></ul><font size="2">Надежных Вам снастей и, конечно, удачной рыбалки! </font>');






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
