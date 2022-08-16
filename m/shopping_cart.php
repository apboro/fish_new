<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2013 osCommerce

  Released under the GNU General Public License
*/

  require("includes/application_top.php");

define('FAKE_MAIL', '1click@yourfish.ru');
  if ($cart->count_contents() > 0) {
    include(DIR_WS_CLASSES . 'payment.php');
    $payment_modules = new payment;
  }

  require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_SHOPPING_CART);

  $breadcrumb->add(NAVBAR_TITLE, tep_href_link(FILENAME_SHOPPING_CART));

  require(DIR_WS_INCLUDES . 'template_top.php');
?>

<h1><?php echo HEADING_TITLE; ?></h1>

<?php
  if ($cart->count_contents() > 0) {
?>

<?php echo tep_draw_form('cart_quantity', tep_href_link(FILENAME_SHOPPING_CART, 'action=update_product')); ?>
<div id="mj-shoppingcart">
<div class="contentContainer">
  <div class="contentText">

<?php
    $any_out_of_stock = 0;
    $products = $cart->get_products();
    for ($i=0, $n=sizeof($products); $i<$n; $i++) {
// Push all attributes information in an array
      if (isset($products[$i]['attributes']) && is_array($products[$i]['attributes'])) {
        while (list($option, $value) = each($products[$i]['attributes'])) {
          echo tep_draw_hidden_field('id[' . $products[$i]['id'] . '][' . $option . ']', $value);
          $attributes = tep_db_query("select popt.products_options_name, poval.products_options_values_name, pa.options_values_price, pa.price_prefix
                                      from " . TABLE_PRODUCTS_OPTIONS . " popt, " . TABLE_PRODUCTS_OPTIONS_VALUES . " poval, " . TABLE_PRODUCTS_ATTRIBUTES . " pa
                                      where pa.products_id = '" . (int)$products[$i]['id'] . "'
                                       and pa.options_id = '" . (int)$option . "'
                                       and pa.options_id = popt.products_options_id
                                       and pa.options_values_id = '" . (int)$value . "'
                                       and pa.options_values_id = poval.products_options_values_id
                                       and popt.language_id = '" . (int)$languages_id . "'
                                       and poval.language_id = '" . (int)$languages_id . "'");
          $attributes_values = tep_db_fetch_array($attributes);

          $products[$i][$option]['products_options_name'] = $attributes_values['products_options_name'];
          $products[$i][$option]['options_values_id'] = $value;
          $products[$i][$option]['products_options_values_name'] = $attributes_values['products_options_values_name'];
          $products[$i][$option]['options_values_price'] = $attributes_values['options_values_price'];
          $products[$i][$option]['price_prefix'] = $attributes_values['price_prefix'];
        }
      }
    }
?>

    <table border="0" width="100%" cellspacing="0" cellpadding="10">
    	<tbody>
        	<tr class="tableHeading">
            	<th><?php echo PRODUCT_TITLE_CART; ?></th>
                <th><?php echo PRODUCT_QTY_CART; ?></th>
				<th><?php echo TABLE_HEADING_REMOVE; ?></th>
                <th><?php echo TABLE_HEADING_TOTAL; ?></th>
            </tr>
<?php
    $any_out_of_stock=0;
    $total_price=0;
    for ($i=0, $n=sizeof($products); $i<$n; $i++) { ?>
     	<tr class="tablecontent">
	    	<td align="center" class="product_info_image">
            	<?php
		    $not_in_stock=0;
		    		$products_name_q='';
      				if (STOCK_CHECK == 'true') {
        				$stock_check = tep_check_stock($products[$i]['id'], $products[$i]['quantity']);
/*						echo $products[$i]['id'].'---'. $products[$i]['quantity'].'---'.
						    tep_get_products_stock($products[$i]['id']).'??'.$stock_check.'??';
						echo '//'.strlen($stock_check).'//';*/
        					if (strlen($stock_check)>0) {
          						$any_out_of_stock = 1;
          						$not_in_stock=1;
          						$products_name_q = $stock_check;
        					}

      				}
				?>
				<?php
            		if (isset($products[$i]['attributes']) && is_array($products[$i]['attributes'])) {
						reset($products[$i]['attributes']);
        				while (list($option, $value) = each($products[$i]['attributes'])) {
          					$products[$i]['name'] .= '<br /><small><i> - ' . $products[$i][$option]['products_options_name'] . ' ' .
							$products[$i][$option]['products_options_values_name'] . '</i></small>';
        				}
      			} ?>
            	<a href="<?php echo tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $products[$i]['id']);?>"> <?php echo tep_image(DIR_WS_IMAGES . $products[$i]['image'],
						$products[$i]['name'], 75,75); ?>
                </a><br/>
                <a href="<?php echo tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $products[$i]['id']);?>">
                <strong><?php echo $products[$i]['name'] . '<br>'.$products_name_q; ?></strong>
                </a>
            </td>
      		<td align="center">
				<?php echo tep_draw_input_field('cart_quantity[]', $products[$i]['quantity'], 'size="4"') . tep_draw_hidden_field('products_id[]', $products[$i]['id']); ?>
            </td>
      		<td align="center">
		<input name="cart_delete[]" value="<?php echo $products[$i]['id'];?>" type="checkbox">
            </td>
      		<td class="buy_now" align="center" valign="middle"><strong>
				<?php
		echo DisplayDiscountPrice($products[$i]['final_price']*$products[$i]['quantity'],
					  $products[$i]['full_price']*$products[$i]['quantity'],
					  $products[$i]['special_price']
					    );
//				echo $currencies->display_price_nodiscount($products[$i]['final_price'], tep_get_tax_rate($products[$i]['tax_class_id']), $products[$i]['quantity']); ?></strong>
            </td>
       </tr>

   		<?php
	$total_price+=$products[$i]['full_price']*$products[$i]['quantity'];
   		}
		?>
        </tbody>
    </table>
    <div id="cartSubTotal"><?php echo SUB_TITLE_SUB_TOTAL; ?>
	<?php
	echo DisplayDiscountPrice($cart->show_total(),$total_price,true);
	//echo $currencies->format($cart->show_total());
	?></div>
	<?php
//	echo '?'.$any_out_of_stock.'?';
    	if ($any_out_of_stock == 1) {
      	if (STOCK_ALLOW_CHECKOUT == 'true') {
/*
	?>
    <p class="stockWarning" align="center"><?php echo OUT_OF_STOCK_CAN_CHECKOUT; ?></p>
	<?php
*/
      } else {
/*
	?>
    <p class="stockWarning" align="center"><?php echo OUT_OF_STOCK_CANT_CHECKOUT; ?></p>
	<?php
*/
     	 }
    	}
	?>
  </div>
  <div class="buttonSet">
    <?php echo tep_draw_button(IMAGE_BUTTON_UPDATE, 'refresh'); ?>
    <span class="link_button"><?php echo tep_draw_button(IMAGE_BUTTON_CHECKOUT, 'triangle-1-e', tep_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL'), 'primary'); ?></span>
       <span class="link_button"><a href="#" class="a_one_click">Оформить в 1 клик</a>

      <?php
    $initialize_checkout_methods = $payment_modules->checkout_initialization_method();
    if (!empty($initialize_checkout_methods)) {
      reset($initialize_checkout_methods);
      while (list(, $value) = each($initialize_checkout_methods)) { ?>
	 <span class="other_options"> <?php echo $value; ?></span>
     <span class="alternate_text"><?php echo TEXT_ALTERNATIVE_CHECKOUT_METHODS; ?> </span>
     <?php  }
    }
?>

  </div>


</div>
</div>
</form>

<form id="one-click" style="display: none" action="<?php echo FILENAME_CHECKOUT; ?>" method="POST">
    <p>1. Введите свои имя и телефон, способ оплаты и адрес доставки. <br>2. Для связи обязательно указать номер с WhatsApp или e-mail. <br>3. Для отправки заказа по России и СНГ у нас всегда обязательна предоплата (полная/только за доставку).</p>
    <input type="hidden" name="formid" value="<?php echo tep_output_string($sessiontoken); ?>"/>
    <input type="hidden" name="action"
           value="<?php echo tep_session_is_registered('customer_id') ? 'logged_on' : 'not_logged_on'; ?>"/>
    <input type="hidden" name="create_account" value="0"/>
    <input type="hidden" name="checkout_possible" value="1"/>
    <input type="hidden" name="payment" value="roboxchange"/>
    <input type="hidden" name="shipping" value="table_table"/>
    <input type="hidden" name="city" value="Неизвестный"/>
    <input type="hidden" name="lastname" value="1click">
    <input type="hidden" name="email_address" value="<?php echo FAKE_MAIL; ?>"/>
    <input type="hidden" name="1click" value="1"/>
    <input type="text" name="firstname" placeholder="Имя" size="30" value="<?php echo $name_default; ?>"><br>
    <input type="text" name="telephone" placeholder="Телефон" pattern=".{17,}" size="30" required="required"
           value="<?php echo $phone_default; ?>"><br>
    <textarea style="resize: none;" name="comments" wrap="soft" cols=50 rows=5
              placeholder="Здесь Вы можете написать адрес доставки и способ оплаты"></textarea>
    <div style="text-align:center;"><input type="image"
                                           src="/templates/Original/images/buttons/russian/button_checkout.gif"
                                           value="Оформить"></div>
</form>
      <script>
          jQuery('.a_one_click').click(function(){
              jQuery('#one-click').slideToggle();
              return false;
          });
      </script>

      <script type="text/javascript" src="/jscript/jquery/jquery.inputmask.bundle.min.js?v=3"></script>
      <script type="text/javascript">
          jQuery(function($){
              jQuery("input[name='telephone']").mask("+7 (000) 000-00-00", {placeholder: "+7 (___) ___-__-__"});
          });
      </script>
<?php
  } else {
?>
<div id="mj-shoppingcart">
<div class="contentContainer">
  <div class="content_box">
    <?php echo TEXT_CART_EMPTY; ?>
	<br/> <br/>
    <span class="link_button"><?php echo tep_draw_button(IMAGE_BUTTON_CONTINUE, 'triangle-1-e', tep_href_link(FILENAME_DEFAULT)); ?></span>
  </div>
</div>
</div>
<?php
  }
$oscTemplate->removeBlock('boxes_column_left');
  require(DIR_WS_INCLUDES . 'template_bottom.php');
  require(DIR_WS_INCLUDES . 'application_bottom.php');
?>
