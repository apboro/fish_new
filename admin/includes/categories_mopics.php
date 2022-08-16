<?php
/*

  BOF: WebMakers.com Added: Images and MO Pics

*/
?>
          <tr>
            <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>

<tr>
  <td colspan="2"><table border="2" cellpadding="2" cellspacing="2" width="100%">

          <tr>
            <td class="main" align="center">PRODUCT IMAGES</td>
          </tr>

<tr><td><table>

          <tr>
            <td class="main" valign="top"><?php echo TEXT_PRODUCTS_IMAGE; ?></td>
            <td class="main"><?php echo
              tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_file_field('products_image') . '<br>' .
              tep_draw_separator('pixel_trans.gif', '24', '15') . tep_draw_checkbox_field('delete_image_1', 'yes', false) . TEXT_DELETE_IMAGE . '&nbsp' .
              tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . $pInfo->products_image . tep_draw_hidden_field('products_previous_image', $pInfo->products_image); ?>
            </td>
          </tr>

          <tr>
            <td class="main" valign="top"><?php echo TEXT_PRODUCTS_BIMAGE; ?></td>
            <td class="main" valign="top"><?php echo
              tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_file_field('products_bimage') . '<br>' .
              tep_draw_separator('pixel_trans.gif', '24', '15') . tep_draw_checkbox_field('delete_image_2', 'yes', false) . TEXT_DELETE_IMAGE . '&nbsp;' .
              tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . $pInfo->products_bimage . tep_draw_hidden_field('products_previous_bimage', $pInfo->products_bimage); ?>
            </td>
          </tr>
</table></td></tr>

<tr><td><table>
          <tr>
            <td class="main" valign="top"><?php echo TEXT_PRODUCTS_SUBIMAGE1; ?></td>
            <td class="main" valign="top"><?php echo
              tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_file_field('products_subimage1') . '<br>' .
              tep_draw_separator('pixel_trans.gif', '24', '15') . tep_draw_checkbox_field('delete_image_3', 'yes', false) . TEXT_DELETE_IMAGE . '&nbsp' .
              tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . $pInfo->products_subimage1 . tep_draw_hidden_field('products_previous_subimage1', $pInfo->products_subimage1); ?>
            </td>
          </tr>
          <tr>
            <td class="main" valign="top"><?php echo TEXT_PRODUCTS_BSUBIMAGE1; ?></td>
            <td class="main" valign="top"><?php echo
              tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_file_field('products_bsubimage1') . '<br>' .
              tep_draw_separator('pixel_trans.gif', '24', '15') . tep_draw_checkbox_field('delete_image_4', 'yes', false) . TEXT_DELETE_IMAGE . '&nbsp' .
              tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . $pInfo->products_bsubimage1 . tep_draw_hidden_field('products_previous_bsubimage1', $pInfo->products_bsubimage1); ?>
            </td>
          </tr>
</table></td></tr>

<tr><td><table>
          <tr>
            <td class="main" valign="top"><?php echo TEXT_PRODUCTS_SUBIMAGE2; ?></td>
            <td class="main" valign="top"><?php echo
              tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_file_field('products_subimage2') . '<br>' .
              tep_draw_separator('pixel_trans.gif', '24', '15') . tep_draw_checkbox_field('delete_image_5', 'yes', false) . TEXT_DELETE_IMAGE . '&nbsp' .
              tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . $pInfo->products_subimage2 . tep_draw_hidden_field('products_previous_subimage2', $pInfo->products_subimage2); ?>
            </td>
          </tr>
          <tr>
            <td class="main" valign="top"><?php echo TEXT_PRODUCTS_BSUBIMAGE2; ?></td>
            <td class="main" valign="top"><?php echo
              tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_file_field('products_bsubimage2') . '<br>' .
              tep_draw_separator('pixel_trans.gif', '24', '15') . tep_draw_checkbox_field('delete_image_6', 'yes', false) . TEXT_DELETE_IMAGE . '&nbsp' .
              tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . $pInfo->products_bsubimage2 . tep_draw_hidden_field('products_previous_bsubimage2', $pInfo->products_bsubimage2); ?>
            </td>
          </tr>
</table></td></tr>

<tr><td><table>
          <tr>
            <td class="main" valign="top"><?php echo TEXT_PRODUCTS_SUBIMAGE3; ?></td>
            <td class="main" valign="top"><?php echo
              tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_file_field('products_subimage3') . '<br>' .
              tep_draw_separator('pixel_trans.gif', '24', '15') . tep_draw_checkbox_field('delete_image_7', 'yes', false) . TEXT_DELETE_IMAGE . '&nbsp' .
              tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . $pInfo->products_subimage3 . tep_draw_hidden_field('products_previous_subimage3', $pInfo->products_subimage3); ?>
            </td>
          </tr>
          <tr>
            <td class="main" valign="top"><?php echo TEXT_PRODUCTS_BSUBIMAGE3; ?></td>
            <td class="main" valign="top"><?php echo
              tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_file_field('products_bsubimage3') . '<br>' .
              tep_draw_separator('pixel_trans.gif', '24', '15') . tep_draw_checkbox_field('delete_image_8', 'yes', false) . TEXT_DELETE_IMAGE . '&nbsp' .
              tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . $pInfo->products_bsubimage3 . tep_draw_hidden_field('products_previous_bsubimage3', $pInfo->products_bsubimage3); ?>
            </td>
          </tr>
</table></td></tr>

<tr><td><table>
          <tr>
            <td class="main" valign="top"><?php echo TEXT_PRODUCTS_SUBIMAGE4; ?></td>
            <td class="main" valign="top"><?php echo
              tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_file_field('products_subimage4') . '<br>' .
              tep_draw_separator('pixel_trans.gif', '24', '15') . tep_draw_checkbox_field('delete_image_9', 'yes', false) . TEXT_DELETE_IMAGE . '&nbsp' .
              tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . $pInfo->products_subimage4 . tep_draw_hidden_field('products_previous_subimage4', $pInfo->products_subimage4); ?>
            </td>
          </tr>
          <tr>
            <td class="main" valign="top"><?php echo TEXT_PRODUCTS_BSUBIMAGE4; ?></td>
            <td class="main" valign="top"><?php echo
              tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_file_field('products_bsubimage4') . '<br>' .
              tep_draw_separator('pixel_trans.gif', '24', '15') . tep_draw_checkbox_field('delete_image_10', 'yes', false) . TEXT_DELETE_IMAGE . '&nbsp' .
              tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . $pInfo->products_bsubimage4 . tep_draw_hidden_field('products_previous_bsubimage4', $pInfo->products_bsubimage4); ?>
            </td>
          </tr>
</table></td></tr>

<tr><td><table>
          <tr>
            <td class="main" valign="top"><?php echo TEXT_PRODUCTS_SUBIMAGE5; ?></td>
            <td class="main" valign="top"><?php echo
              tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_file_field('products_subimage5') . '<br>' .
              tep_draw_separator('pixel_trans.gif', '24', '15') . tep_draw_checkbox_field('delete_image_12', 'yes', false) . TEXT_DELETE_IMAGE . '&nbsp' .
              tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . $pInfo->products_subimage5 . tep_draw_hidden_field('products_previous_subimage5', $pInfo->products_subimage5); ?>
            </td>
          </tr>
          <tr>
            <td class="main" valign="top"><?php echo TEXT_PRODUCTS_BSUBIMAGE5; ?></td>
            <td class="main" valign="top"><?php echo
              tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_file_field('products_bsubimage5') . '<br>' .
              tep_draw_separator('pixel_trans.gif', '24', '15') . tep_draw_checkbox_field('delete_image_13', 'yes', false) . TEXT_DELETE_IMAGE . '&nbsp' .
              tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . $pInfo->products_bsubimage5 . tep_draw_hidden_field('products_previous_bsubimage5', $pInfo->products_bsubimage5); ?>
            </td>
          </tr>
</table></td></tr>

<tr><td><table>
          <tr>
            <td class="main" valign="top"><?php echo TEXT_PRODUCTS_SUBIMAGE6; ?></td>
            <td class="main" valign="top"><?php echo
              tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_file_field('products_subimage6') . '<br>' .
              tep_draw_separator('pixel_trans.gif', '24', '15') . tep_draw_checkbox_field('delete_image_14', 'yes', false) . TEXT_DELETE_IMAGE . '&nbsp' .
              tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . $pInfo->products_subimage6 . tep_draw_hidden_field('products_previous_subimage6', $pInfo->products_subimage6); ?>
            </td>
          </tr>
          <tr>
            <td class="main" valign="top"><?php echo TEXT_PRODUCTS_BSUBIMAGE6; ?></td>
            <td class="main" valign="top"><?php echo
              tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_file_field('products_bsubimage6') . '<br>' .
              tep_draw_separator('pixel_trans.gif', '24', '15') . tep_draw_checkbox_field('delete_image_15', 'yes', false) . TEXT_DELETE_IMAGE . '&nbsp' .
              tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . $pInfo->products_bsubimage6 . tep_draw_hidden_field('products_previous_bsubimage6', $pInfo->products_bsubimage6); ?>
            </td>
          </tr>
</table></td></tr>

  </table></td>
</tr>
          <tr>
            <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>

