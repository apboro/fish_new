<?php ################ START Payment Modules ######################################## ?> 
<?php if ($sc_payment_modules_show == true) { // hide payment modules ?>
<?php if (!isset($_REQUEST['ajax'])){ ?>
<div id="payment_options" class="sm_layout_box infoBoxContents"> 
<?php } ?>
<h2><?php echo  TABLE_HEADING_PAYMENT_METHOD; ?></h2>
<?php
if ($sc_payment_modules_process == true) {
  $selection = $payment_modules->selection();
  if (sizeof($selection) > 1) {
?>
<?php //echo '<strong>' . TITLE_PLEASE_SELECT . '</strong>'; ?>
<p><?php echo TEXT_SELECT_PAYMENT_METHOD; ?></p>
<?php    } elseif ($free_shipping == false) { ?>
<p><?php echo TEXT_ENTER_PAYMENT_INFORMATION; ?></p>
<?php    } 
  $radio_buttons = 0;
  $has_select = false;
  foreach($selection as $select){
    if($select['id'] == $payment){
        $has_select = true;
        break;
    }
  }
  for ($i=0, $n=sizeof($selection); $i<$n; $i++) {
?>
    <table class="table-padding-2">
<?php
    if ( ($selection[$i]['id'] == $payment) || ($n == 1) ) {
      echo '      <tr id="defaultSelected" class="moduleRowSelected" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="selectRowEffect(this, ' . $radio_buttons . ')">' . "\n";
    } else {
      echo '      <tr class="moduleRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="selectRowEffect(this, ' . $radio_buttons . ')">' . "\n";
    }
?>
        <td><b><?php echo $selection[$i]['icon']; ?> <?php echo $selection[$i]['module']; ?></b></td>
        <td align="right">
<?php
    if (sizeof($selection) > 1) {
        if($has_select) {
            echo tep_draw_radio_field('f_payment', $selection[$i]['id'], ($selection[$i]['id'] == $payment), '');
        }else{
            echo tep_draw_radio_field('f_payment', $selection[$i]['id'], true, '');
            $has_select = true;
        }
    } else {
      echo tep_draw_hidden_field('f_payment', $selection[$i]['id']);
    }
?>
        </td>
      </tr>
<?php
    if (isset($selection[$i]['error'])) {
?>
      <tr>
        <td colspan="2"><?php echo $selection[$i]['error']; ?></td>
      </tr>
<?php
    } elseif (isset($selection[$i]['fields']) 
	      && is_array($selection[$i]['fields'])
	      	) {
?>
      <tr>
        <td colspan="2"><table border="0" cellspacing="0" cellpadding="2">
<?php
      for ($j=0, $n2=sizeof($selection[$i]['fields']); $j<$n2; $j++) {
?>
          <tr>
            <td><?php echo $selection[$i]['fields'][$j]['title']; ?></td>
            <td><?php echo $selection[$i]['fields'][$j]['field']; ?></td>
          </tr>

<?php       } ?>
        </table></td>
      </tr>
<?php
    }
?>
    </table>
<?php
    $radio_buttons++;
  }
}
  // Discount Code 2.6 - start
  if (MODULE_ORDER_TOTAL_DISCOUNT_STATUS == 'true') {
?>
  <h2><?php echo  TEXT_DISCOUNT_CODE; ?></h2>
  <?php echo tep_draw_input_field('discount_code', $sess_discount_code, 'class="text" size="10"'); ?>
<?php
  }
  // Discount Code 2.6 - end
?>
<?php if (!isset($_REQUEST['ajax'])){ ?>
</div> <!--div end payment_options-->
<?php } ?>
<?php } //End hide payment modules ?>
<?php ################ END Payment Modules ######################################## ?> 
