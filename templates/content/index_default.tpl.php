    <table border="0" width="100%" cellspacing="0" cellpadding="<?php echo CELLPADDING_SUB; ?>">
      <tr>
        <td><table class="table-padding-0">
          <tr>
                        <td> <h1 class="pageHeading">
             <?php
               if ( (ALLOW_CATEGORY_DESCRIPTIONS == 'true') && (tep_not_null($category['categories_heading_title'])) ) {
                 echo $category['categories_heading_title'];
               } else {
                 echo HEADING_TITLE;
               }
             ?>
            </h1>
            </td>
            <td class="pageHeading" align="right"><?php echo tep_image(DIR_WS_TEMPLATES . TEMPLATE_NAME . '/images/content/default.gif', HEADING_TITLE, HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?></td>
          </tr>
	          </table></td>
      </tr>
      <tr>
        <td><table class="table-padding-0">
<?php if (SHOW_CUSTOMER_GREETING == 'yes'){ ?>
          <tr>
            <td class="main"><?php echo tep_customer_greeting(); ?></td>
          </tr>
<?php } ?>
          <tr>
            <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
          </tr>
<?php
if (file_exists(DIR_WS_TEMPLATES .TEMPLATE_NAME . '/mainpage_modules/' . $template_name)) {
$modules_folder = (DIR_WS_TEMPLATES .TEMPLATE_NAME . '/mainpage_modules/' . $template_name);
}else{
$modules_folder = DIR_WS_MODULES. '/mainpage_modules/';
}

if (tep_not_null(INCLUDE_MODULE_ONE)) {
echo '<tr><td>';
include($modules_folder . INCLUDE_MODULE_ONE);
echo '</td></tr>';
}
?>
          <tr>
            <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
          </tr>

<?php
if (tep_not_null(INCLUDE_MODULE_TWO)) {
echo '          <tr>
            <td class="main">';
include($modules_folder . INCLUDE_MODULE_TWO);
echo '</td></tr>';
}
?>
          <tr>
            <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
          </tr>
<?php
if (tep_not_null(INCLUDE_MODULE_THREE)) {
echo '<tr><td>';
include($modules_folder . INCLUDE_MODULE_THREE);
echo '</td></tr>';
}
?>
          <tr>
            <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
          </tr>
<?php
if (tep_not_null(INCLUDE_MODULE_FOUR)) {
echo '<tr><td>';
include($modules_folder . INCLUDE_MODULE_FOUR);
echo '</td></tr>';
}
?>
          <tr>
            <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
          </tr>
<?php
if (tep_not_null(INCLUDE_MODULE_FIVE)) {
echo '<tr><td>';
include($modules_folder . INCLUDE_MODULE_FIVE);
echo '</td></tr>';
}
?>
          <tr>
            <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
          </tr>
<?php
if (tep_not_null(INCLUDE_MODULE_SIX)) {
echo '<tr><td>';
include($modules_folder . INCLUDE_MODULE_SIX);
echo '</td></tr>';
}

?>
        </table></td>
      </tr>
    </table>