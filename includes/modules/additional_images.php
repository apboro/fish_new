<?php
    $images_exists=false;
//    var_dump($product_info);
    for ($i=1;$i<=6;$i++){$images_exists|= strlen($product_info['products_image_xl_'.$i])>0;}
    if (!$images_exists){return;}
?>
<!-- // BOF MaxiDVD: Modified For Ultimate Images Pack! //-->
    <tr>
      <td><table width="100%">
       <tr>
<?php 
/*if ($ajax_load){
    for ($i=1;$i<=6;$i++){$product_info['products_image_xl_'.$i]='';}
    }*/
?>
<?php
    if (($product_info['products_image_sm_1'] != '') && ($product_info['products_image_xl_1'] == '')) {
?>
     <td align="center" class="smallText">
           <?php echo tep_image(DIR_WS_IMAGES . $product_info['products_image_sm_1'], $product_info['products_name'], ULT_THUMB_IMAGE_WIDTH, ULT_THUMB_IMAGE_HEIGHT, 'hspace="1" vspace="1"'); ?>
      </td>
<?php
    } elseif
       (($product_info['products_image_sm_1'] != '') && ($product_info['products_image_sm_1'] != '')) {
?>
     <td align="center" class="smallText">
           <?php echo '<a class="zoom" rel="group" href="' . tep_href_link(DIR_WS_IMAGES . $product_info['products_image_xl_1']) . '">' . tep_image(DIR_WS_IMAGES . $product_info['products_image_sm_1'], $product_info['products_name'], ULT_THUMB_IMAGE_WIDTH, ULT_THUMB_IMAGE_HEIGHT, 'hspace="1" vspace="1"') . '<br>' . tep_template_image_button('image_enlarge.gif', TEXT_CLICK_TO_ENLARGE) . '</a>'; ?>
      </td>
<?php
    } elseif
      (($products_info['products_image_sm_1'] == '') && ($product_info['products_image_xl_1'] != '')) {
?>
     <td align="center" class="smallText">
           <?php echo tep_image(DIR_WS_IMAGES . $product_info['products_image_xl_1'], $product_info['products_name'], LARGE_IMAGE_WIDTH, LARGE_IMAGE_HEIGHT, 'hspace="1" vspace="1"'); ?>
      </td>
<?php
    }
?>

<?php
    if (($product_info['products_image_sm_2'] != '') && ($product_info['products_image_xl_2'] == '')) {
?>
     <td align="center" class="smallText">
           <?php echo tep_image(DIR_WS_IMAGES . $product_info['products_image_sm_2'], $product_info['products_name'], ULT_THUMB_IMAGE_WIDTH, ULT_THUMB_IMAGE_HEIGHT, 'hspace="1" vspace="1"'); ?>
      </td>
<?php
    } elseif
       (($product_info['products_image_sm_2'] != '') && ($product_info['products_image_sm_2'] != '')) {
?>
     <td align="center" class="smallText">
           <?php echo '<a class="zoom" rel="group" href="' . tep_href_link(DIR_WS_IMAGES . $product_info['products_image_xl_2']) . '">' . tep_image(DIR_WS_IMAGES . $product_info['products_image_sm_2'], $product_info['products_name'], ULT_THUMB_IMAGE_WIDTH, ULT_THUMB_IMAGE_HEIGHT, 'hspace="1" vspace="1"') . '<br>' . tep_template_image_button('image_enlarge.gif', TEXT_CLICK_TO_ENLARGE) . '</a>'; ?>
      </td>
<?php
    } elseif
      (($products_info['products_image_sm_2'] == '') && ($product_info['products_image_xl_2'] != '')) {
?>
     <td align="center" class="smallText">
           <?php echo tep_image(DIR_WS_IMAGES . $product_info['products_image_xl_2'], $product_info['products_name'], LARGE_IMAGE_WIDTH, LARGE_IMAGE_HEIGHT, 'hspace="1" vspace="1"'); ?>
      </td>
<?php
    }
?>

<?php
    if (($product_info['products_image_sm_3'] != '') && ($product_info['products_image_xl_3'] == '')) {
?>
     <td align="center" class="smallText">
           <?php echo tep_image(DIR_WS_IMAGES . $product_info['products_image_sm_3'], $product_info['products_name'], ULT_THUMB_IMAGE_WIDTH, ULT_THUMB_IMAGE_HEIGHT, 'hspace="1" vspace="1"'); ?>
      </td>
<?php
    } elseif
       (($product_info['products_image_sm_3'] != '') && ($product_info['products_image_sm_3'] != '')) {
?>
     <td align="center" class="smallText">
           <?php echo '<a class="zoom" rel="group" href="' . tep_href_link(DIR_WS_IMAGES . $product_info['products_image_xl_3']) . '">' . tep_image(DIR_WS_IMAGES . $product_info['products_image_sm_3'], $product_info['products_name'], ULT_THUMB_IMAGE_WIDTH, ULT_THUMB_IMAGE_HEIGHT, 'hspace="1" vspace="1"') . '<br>' . tep_template_image_button('image_enlarge.gif', TEXT_CLICK_TO_ENLARGE) . '</a>'; ?>
      </td>
<?php
    } elseif
      (($products_info['products_image_sm_3'] == '') && ($product_info['products_image_xl_3'] != '')) {
?>
     <td align="center" class="smallText">
           <?php echo tep_image(DIR_WS_IMAGES . $product_info['products_image_xl_3'], $product_info['products_name'], LARGE_IMAGE_WIDTH, LARGE_IMAGE_HEIGHT, 'hspace="1" vspace="1"'); ?>
      </td>
<?php
    }
?>


</tr>
<tr>


<?php
    if (($product_info['products_image_sm_4'] != '') && ($product_info['products_image_xl_4'] == '')) {
?>
     <td align="center" class="smallText">
           <?php echo tep_image(DIR_WS_IMAGES . $product_info['products_image_sm_4'], $product_info['products_name'], ULT_THUMB_IMAGE_WIDTH, ULT_THUMB_IMAGE_HEIGHT, 'hspace="1" vspace="1"'); ?>
      </td>
<?php
    } elseif
       (($product_info['products_image_sm_4'] != '') && ($product_info['products_image_sm_4'] != '')) {
?>
     <td align="center" class="smallText">
           <?php echo '<a class="zoom" rel="group" href="' . tep_href_link(DIR_WS_IMAGES . $product_info['products_image_xl_4']) . '">' . tep_image(DIR_WS_IMAGES . $product_info['products_image_sm_4'], $product_info['products_name'], ULT_THUMB_IMAGE_WIDTH, ULT_THUMB_IMAGE_HEIGHT, 'hspace="1" vspace="1"') . '<br>' . tep_template_image_button('image_enlarge.gif', TEXT_CLICK_TO_ENLARGE) . '</a>'; ?>
      </td>
<?php
    } elseif
      (($products_info['products_image_sm_4'] == '') && ($product_info['products_image_xl_4'] != '')) {
?>
     <td align="center" class="smallText">
           <?php echo tep_image(DIR_WS_IMAGES . $product_info['products_image_xl_4'], $product_info['products_name'], LARGE_IMAGE_WIDTH, LARGE_IMAGE_HEIGHT, 'hspace="1" vspace="1"'); ?>
      </td>
<?php
    }
?>


<?php
    if (($product_info['products_image_sm_5'] != '') && ($product_info['products_image_xl_5'] == '')) {
?>
     <td align="center" class="smallText">
           <?php echo tep_image(DIR_WS_IMAGES . $product_info['products_image_sm_5'], $product_info['products_name'], ULT_THUMB_IMAGE_WIDTH, ULT_THUMB_IMAGE_HEIGHT, 'hspace="1" vspace="1"'); ?>
      </td>
<?php
    } elseif
       (($product_info['products_image_sm_5'] != '') && ($product_info['products_image_sm_5'] != '')) {
?>
     <td align="center" class="smallText">
           <?php echo '<a class="zoom" rel="group" href="' . tep_href_link(DIR_WS_IMAGES . $product_info['products_image_xl_5']) . '">' . tep_image(DIR_WS_IMAGES . $product_info['products_image_sm_5'], $product_info['products_name'], ULT_THUMB_IMAGE_WIDTH, ULT_THUMB_IMAGE_HEIGHT, 'hspace="1" vspace="1"') . '<br>' . tep_template_image_button('image_enlarge.gif', TEXT_CLICK_TO_ENLARGE) . '</a>'; ?>
      </td>
<?php
    } elseif
      (($products_info['products_image_sm_5'] == '') && ($product_info['products_image_xl_5'] != '')) {
?>
     <td align="center" class="smallText">
           <?php echo tep_image(DIR_WS_IMAGES . $product_info['products_image_xl_5'], $product_info['products_name'], LARGE_IMAGE_WIDTH, LARGE_IMAGE_HEIGHT, 'hspace="1" vspace="1"'); ?>
      </td>
<?php
    }
?>


<?php
    if (($product_info['products_image_sm_6'] != '') && ($product_info['products_image_xl_6'] == '')) {
?>
     <td align="center" class="smallText">
           <?php echo tep_image(DIR_WS_IMAGES . $product_info['products_image_sm_6'], $product_info['products_name'], ULT_THUMB_IMAGE_WIDTH, ULT_THUMB_IMAGE_HEIGHT, 'hspace="1" vspace="1"'); ?>
      </td>
<?php
    } elseif
       (($product_info['products_image_sm_6'] != '') && ($product_info['products_image_sm_6'] != '')) {
?>
     <td align="center" class="smallText">
           <?php echo '<a class="zoom" rel="group" href="' . tep_href_link(DIR_WS_IMAGES . $product_info['products_image_xl_6']) . '">' . tep_image(DIR_WS_IMAGES . $product_info['products_image_sm_6'], $product_info['products_name'], ULT_THUMB_IMAGE_WIDTH, ULT_THUMB_IMAGE_HEIGHT, 'hspace="1" vspace="1"') . '<br>' . tep_template_image_button('image_enlarge.gif', TEXT_CLICK_TO_ENLARGE) . '</a>'; ?>
      </td>
<?php
    } elseif
      (($products_info['products_image_sm_6'] == '') && ($product_info['products_image_xl_6'] != '')) {
?>
     <td align="center" class="smallText">
           <?php echo tep_image(DIR_WS_IMAGES . $product_info['products_image_xl_6'], $product_info['products_name'], LARGE_IMAGE_WIDTH, LARGE_IMAGE_HEIGHT, 'hspace="1" vspace="1"'); ?>
      </td>
<?php
    }
?>


     </tr>
        </table></td>
     </tr>
<!-- // BOF MaxiDVD: Modified For Ultimate Images Pack! //-->
