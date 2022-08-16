<?php 
$orders_query = tep_db_query("select orders_id, orders_status from ".TABLE_ORDERS." where customers_id = '".$customer_id."' order by orders_id desc limit 1");
$orders = tep_db_fetch_array($orders_query);
$last_order = $orders['orders_id'];
?>
    <?php echo tep_draw_form('order', tep_href_link(FILENAME_CHECKOUT_SUCCESS, 'action=update', 'SSL')); ?><table border="0" width="100%" cellspacing="0" cellpadding="<?php echo CELLPADDING_SUB;?>">
      <tr>
        <td colspan="2"><table border="0" width="100%" cellspacing="4" cellpadding="2">
          <tr>
            <td valign="top"><?php echo tep_image(DIR_WS_TEMPLATES . TEMPLATE_NAME . '/images/content/man_on_board.gif', $HEADING_TITLE, HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?></td>
            <td valign="top" class="main"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?><div align="center" class="pageHeading"><?php echo $HEADING_TITLE; ?></div><br>
        	<?php
            if(isset($_GET['fail'])){
                echo "<span style=\"color:red\">Оплата по Вашему заказу не прошла. Мы свяжемся с Вами для повторной оплаты заказа.</span><br>";
            }
		echo sprintf(TEXT_SUCCESS,(int)$last_order);
        	?>
        	<br><br>

<?php
      echo TEXT_SEE_ORDERS . '<br><br>' . TEXT_CONTACT_STORE_OWNER;
?>                   
            <h3><?php echo TEXT_THANKS_FOR_SHOPPING; ?></h3></td>
          </tr>
        </table></td>
      </tr>
<?php require('add_checkout_success.php'); //ICW CREDIT CLASS/GV SYSTEM ?>
      <tr>
        <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>

<?php

	include (DIR_WS_CLASSES.'order.php');
	$order = new order($orders['orders_id']);

require(DIR_WS_LANGUAGES . $language . '/modules/payment/schet.php');
if ($order->info['payment_method'] == MODULE_PAYMENT_RUS_SCHET_TEXT_TITLE) {

?>

<script language="javascript"><!--
function popupPrintorder(url) {
  window.open(url,'popupPrintorder','toolbar=yes,location=no,directories=no,status=no,menubar=yes,scrollbars=yes,resizable=yes,copyhistory=no,width=800,height=600') . focus();
}
//--></script>

      <tr> 
        <td align="left" colspan="2" class="main"><a href="javascript:popupPrintorder('<?php echo tep_href_link(FILENAME_ORDERS_PRINTABLE, 'order_id=' . $_GET['order_id']); ?>')"><?php echo tep_template_image_button('button_printorder.gif', IMAGE_BUTTON_PRINT_ORDER); ?></a>
      </td>
      </tr>
     
<?php
} 
?>

<?php 
require(DIR_WS_LANGUAGES . $language . '/modules/payment/rusbank.php');
if ($order->info['payment_method'] == MODULE_PAYMENT_RUS_BANK_TEXT_TITLE) {
?>

<script language="javascript"><!--
function popupPrintorder(url) {
  window.open(url,'popupPrintorder','toolbar=yes,location=no,directories=no,status=no,menubar=yes,scrollbars=yes,resizable=yes,copyhistory=no,width=800,height=600') . focus();
}
//--></script>

      <tr> 
        <td align="left" colspan="2" class="main"><a href="javascript:popupPrintorder('<?php echo tep_href_link('kvitan.php', 'order_id=' . $_GET['order_id']); ?>')"><?php echo MODULE_PAYMENT_RUS_BANK_TEXT_PRINT; ?></a>
      </td>
      </tr>
     
<?php
}
?> 

      <tr> 
        <td align="right" class="main" colspan="2"><?php echo tep_template_image_submit('button_continue.gif', IMAGE_BUTTON_CONTINUE); ?></td>
      </tr>
      
      <tr>
        <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
      <tr>
        <td colspan="2"><table class="table-padding-0">
          <tr>
            <td width="25%"><table class="table-padding-0">
              <tr>
                <td width="50%" align="right"><?php echo tep_draw_separator('pixel_silver.gif', '1', '5'); ?></td>
                <td width="50%"><?php echo tep_draw_separator('pixel_silver.gif', '100%', '1'); ?></td>
              </tr>
            </table></td>
            <td width="25%"><?php echo tep_draw_separator('pixel_silver.gif', '100%', '1'); ?></td>
            <td width="25%"><?php echo tep_draw_separator('pixel_silver.gif', '100%', '1'); ?></td>
            <td width="25%"><table class="table-padding-0">
              <tr>
                <td width="50%"><?php echo tep_draw_separator('pixel_silver.gif', '100%', '1'); ?></td>
                <td width="50%"><?php echo tep_image(DIR_WS_TEMPLATES . TEMPLATE_NAME . '/images/content/checkout_bullet.gif'); ?></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td align="center" width="25%" class="checkoutBarFrom"><?php echo CHECKOUT_BAR_DELIVERY; ?></td>
            <td align="center" width="25%" class="checkoutBarFrom"><?php echo CHECKOUT_BAR_PAYMENT; ?></td>
            <td align="center" width="25%" class="checkoutBarFrom"><?php echo CHECKOUT_BAR_CONFIRMATION; ?></td>
            <td align="center" width="25%" class="checkoutBarCurrent"><?php echo CHECKOUT_BAR_FINISHED; ?></td>
          </tr>
        </table></td>
      </tr>
<?php if (DOWNLOAD_ENABLED == 'true') include(DIR_WS_MODULES . 'downloads.php'); ?>
    </table></form>
