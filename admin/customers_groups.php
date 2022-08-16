<?php
/*
  Group Discount
  by hOZONE, hozone@tiscali.it, http://hozone.cjb.net
  
  visit osCommerceITalia, http://www.oscommerceitalia.com

  derived by:
  Discount_Groups_v1.1, by Enrico Drusiani, 2003/5/22
  
  for:
  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com
  
  Copyright (c) 2003 osCommerce
  
  Released under the GNU General Public License 
*/

  require('includes/application_top.php');
  
  $action = (isset($_GET['action']) ? $_GET['action'] : '');

  if (tep_not_null($action)) {
    switch ($action) {

      case 'update':
        $error = false;
	    $customers_groups_id = tep_db_prepare_input($_GET['cID']);
		$customers_groups_name = tep_db_prepare_input($_POST['customers_groups_name']);
		$customers_groups_accumulated_limit = tep_db_prepare_input($_POST['customers_groups_accumulated_limit']);
		$customers_groups_discount_sign = tep_db_prepare_input($_POST['customers_groups_discount_sign']);
        $customers_groups_discount = tep_db_prepare_input($_POST['customers_groups_discount']);
		$customers_groups_price = tep_db_prepare_input($_POST['customers_groups_price']);

// add for Minimum group price to order start			
		$customers_groups_min_price = tep_db_prepare_input($_POST['customers_groups_min_price']);
// add for Minimum group price to order end	

//add SPPC shipment and payment module start 
$group_payment_allowed = '';
		if ($_POST['payment_allowed'] && $_POST['group_payment_settings'] == '1') {
		  while(list($key, $val) = each($_POST['payment_allowed'])) {
		    if ($val == true) { 
		    $group_payment_allowed .= tep_db_prepare_input($val).';'; 
		    }
		  } // end while
		  $group_payment_allowed = substr($group_payment_allowed,0,strlen($group_payment_allowed)-1);
		} // end if ($_POST['payment_allowed'])
		$group_shipment_allowed = '';
		if ($_POST['shipping_allowed'] && $_POST['group_shipment_settings'] == '1') {
		  while(list($key, $val) = each($_POST['shipping_allowed'])) {
		    if ($val == true) { 
		    $group_shipment_allowed .= tep_db_prepare_input($val).';'; 
		    }
		  } // end while
		  $group_shipment_allowed = substr($group_shipment_allowed,0,strlen($group_shipment_allowed)-1);
		} // end if ($_POST['shipment_allowed'])
		//add for SPPC shipment and payment module end

//add and change for /color groups/, /shipment and payment module/, /minimum group price to order/ start			
		$color_bar = tep_db_prepare_input($_POST['color_bar']);  

        tep_db_query("update " . TABLE_CUSTOMERS_GROUPS . " set customers_groups_name='" . $customers_groups_name . "', customers_groups_discount='" . $customers_groups_discount_sign . $customers_groups_discount . "', customers_groups_price='" . $customers_groups_price .  "', color_bar='" . $color_bar . "', group_payment_allowed = '". $group_payment_allowed ."', group_shipment_allowed = '". $group_shipment_allowed . "', customers_groups_min_price='" . $customers_groups_min_price . "', customers_groups_accumulated_limit = '" . $customers_groups_accumulated_limit . "'  where customers_groups_id = " . tep_db_input($customers_groups_id) );
//add and change for /color groups/, /shipment and payment module/, /minimum group price to order/ end		
        // denuz  acc limit

        tep_db_query("delete from customers_groups_orders_status where customers_groups_id = " .  tep_db_input($customers_groups_id));
        $orders_status_query = tep_db_query("select orders_status_id from orders_status where language_id = " . $languages_id . " order by orders_status_id");
        while ($orders_status = tep_db_fetch_array($orders_status_query)) {
           if ($_POST['orders_status_' . $orders_status['orders_status_id']]) {
              tep_db_query("insert into customers_groups_orders_status values (" .  tep_db_input($customers_groups_id) . ", " . $orders_status['orders_status_id'] . ")");
           }
        }

        // eof denuz  acc lim

        tep_redirect(tep_href_link('customers_groups.php', tep_get_all_get_params(array('cID', 'action')) . 'cID=' . $customers_groups_id));
		break;
        
      case 'deleteconfirm':
        $group_id = tep_db_prepare_input($_GET['cID']);
        tep_db_query("delete from " . TABLE_CUSTOMERS_GROUPS . " where customers_groups_id= " . $group_id); 
        $customers_id_query = tep_db_query("select customers_id from " . TABLE_CUSTOMERS . " where customers_groups_id=" . $group_id);
        while($customers_id = tep_db_fetch_array($customers_id_query)) {
            tep_db_query("UPDATE " . TABLE_CUSTOMERS . " set customers_groups_id=1 where customers_id=" . $customers_id['customers_id']);
        }     
        // denuz
        tep_db_query("delete from customers_groups_orders_status where customers_groups_id = " .  tep_db_input($group_id));
        // eof denuz
        tep_redirect(tep_href_link('customers_groups.php', tep_get_all_get_params(array('cID', 'action')))); 
        break;
        
      case 'newconfirm' :
        $customers_groups_name = tep_db_prepare_input($_POST['customers_groups_name']);
	    $customers_groups_discount_sign = tep_db_prepare_input($_POST['customers_groups_discount_sign']);
        $customers_groups_discount = tep_db_prepare_input($_POST['customers_groups_discount']);
		$customers_groups_accumulated_limit = tep_db_prepare_input($_POST['customers_groups_accumulated_limit']);
		$customers_groups_price = tep_db_prepare_input($_POST['customers_groups_price']);

// add for SPPC shipment and payment module start 		
$group_payment_allowed = '';
	if ($_POST['payment_allowed']) {
	      while(list($key, $val) = each($_POST['payment_allowed'])) {
	         if ($val == true) { 
	         $group_payment_allowed .= tep_db_prepare_input($val).';'; 
	         }
	      } // end while
	   $group_payment_allowed = substr($group_payment_allowed,0,strlen($group_payment_allowed)-1);
	} // end if ($_POST['payment_allowed'])
		$group_shipment_allowed = '';
		if ($_POST['shipping_allowed'] && $_POST['group_shipment_settings'] == '1') {
		  while(list($key, $val) = each($_POST['shipping_allowed'])) {
		    if ($val == true) { 
		    $group_shipment_allowed .= tep_db_prepare_input($val).';'; 
		    }
		  } // end while
		  $group_shipment_allowed = substr($group_shipment_allowed,0,strlen($group_shipment_allowed)-1);
		} // end if ($_POST['shipment_allowed'])
// add for SPPC shipment and payment module end		

//add for Minimum group price to order start			
		$customers_groups_min_price = tep_db_prepare_input($_POST['customers_groups_min_price']);
// add for Minimum group price to order end	

//add and change for /color groups/, /shipment and payment module/, /minimum group price to order/ start				
		$color_bar = tep_db_prepare_input($_POST['color_bar']);
        tep_db_query("insert into " . TABLE_CUSTOMERS_GROUPS . " set customers_groups_name = '" . $customers_groups_name . "', customers_groups_discount = '" . $customers_groups_discount_sign . $customers_groups_discount . "', customers_groups_price = '" . $customers_groups_price . "', color_bar='" . $color_bar  . "', group_payment_allowed = '". $group_payment_allowed ."', group_shipment_allowed = '". $group_shipment_allowed . "', customers_groups_min_price='" . $customers_groups_min_price . "', customers_groups_accumulated_limit = '" . $customers_groups_accumulated_limit . "'");
// add and change for /color groups/, /shipment and payment module/, /minimum group price to order/ end			        

        // denuz  acc limit

        $customers_groups_id = tep_db_insert_id();  
        tep_db_query("delete from customers_groups_orders_status where customers_groups_id = " .  tep_db_input($customers_groups_id));
        $orders_status_query = tep_db_query("select orders_status_id from orders_status where language_id = " . $languages_id . " order by orders_status_id");
        while ($orders_status = tep_db_fetch_array($orders_status_query)) {
           if ($_POST['orders_status_' . $orders_status['orders_status_id']]) {
              tep_db_query("insert into customers_groups_orders_status values (" .  tep_db_input($customers_groups_id) . ", " . $orders_status['orders_status_id'] . ")");
           }
        }

        // eof denuz  acc lim

        tep_redirect(tep_href_link('customers_groups.php', tep_get_all_get_params(array('action'))));
        break;
    }
  }
?>

<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<title><?php echo TITLE; ?></title>
<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
<script language="javascript" src="includes/general.js"></script>
<!-- KIKOLEPPARD add for color groups start	-->
<script language="Javascript" src="includes/colorpicker.js"></script>
<!-- KIKOLEPPARD add for color groups end -->

</head>
<body marginwidth="0" marginheight="0" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0" bgcolor="#FFFFFF" onload="SetFocus();">
<!-- header //-->
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
<!-- header_eof //-->

<!-- body //-->
<table border="0" width="100%" cellspacing="2" cellpadding="2">
  <tr>
    <td width="<?php echo BOX_WIDTH; ?>" valign="top"><table border="0" width="<?php echo BOX_WIDTH; ?>" cellspacing="1" cellpadding="1" class="columnLeft">
<!-- left_navigation //-->
<?php require(DIR_WS_INCLUDES . 'column_left.php'); ?>
<!-- left_navigation_eof //-->
    </table></td>
<!-- body_text //-->
    <td width="100%" valign="top"><table class="table-padding-2">

<?php
  if ($_GET['action'] == 'edit') {
    // denuz modified query
    $customers_groups_query = tep_db_query("select c.customers_groups_accumulated_limit, c.customers_groups_id, c.customers_groups_name, c.customers_groups_discount, c.customers_groups_price, c.color_bar, c.group_payment_allowed, c.group_shipment_allowed, c.customers_groups_min_price from " . TABLE_CUSTOMERS_GROUPS . " c  where c.customers_groups_id = '" . $_GET['cID'] . "'");
    $customers_groups = tep_db_fetch_array($customers_groups_query);
    $cInfo = new objectInfo($customers_groups);

// add for SPPC shipment and payment module start 
	   $payments_allowed = explode (";",$cInfo->group_payment_allowed);
   $shipment_allowed = explode (";",$cInfo->group_shipment_allowed);
   $module_directory = DIR_FS_CATALOG_MODULES . 'payment/';
   $ship_module_directory = DIR_FS_CATALOG_MODULES . 'shipping/';

   $file_extension = substr($PHP_SELF, strrpos($PHP_SELF, '.'));
   $directory_array = array();
   if ($dir = @dir($module_directory)) {
    while ($file = $dir->read()) {
      if (!is_dir($module_directory . $file)) {
        if (substr($file, strrpos($file, '.')) == $file_extension) {
          $directory_array[] = $file; // array of all the payment modules present in includes/modules/payment
        }
      }
    }
    sort($directory_array);
    $dir->close();
  }

   $ship_directory_array = array();
   if ($dir = @dir($ship_module_directory)) {
    while ($file = $dir->read()) {
      if (!is_dir($ship_module_directory . $file)) {
        if (substr($file, strrpos($file, '.')) == $file_extension) {
          $ship_directory_array[] = $file; // array of all shipping modules present in includes/modules/shipping
        }
      }
    }
    sort($ship_directory_array);
    $dir->close();
  }
// SPPC shipment and payment module end	
?>

<script language="javascript"><!--
function check_form() {
  var error = 0;

  var customers_groups_name = document.customers.customers_groups_name.value;
  
  if (customers_groups_name == "") {
    error_message = "<?php echo ERROR_CUSTOMERS_GROUPS_NAME; ?>";
    error = 1;
  }

  if (error == 1) {
    alert(error_message);
    return false;
  } else {
    return true;
  }
}
//--></script>

      <tr>
        <td><table class="table-padding-0">
          <tr>
            <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
            <td class="pageHeading" align="right"><?php echo tep_draw_separator('pixel_trans.gif', HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>

	  <tr><?php echo tep_draw_form('customers', 'customers_groups.php', tep_get_all_get_params(array('action')) . 'action=update', 'post', 'onSubmit="return check_form();"'); ?>
        <td class="formAreaTitle"><?php echo CATEGORY_PERSONAL; ?></td>
      </tr>

      <tr>
        <td class="formArea"><table border="0" cellspacing="2" cellpadding="2">
          <tr>
            <td class="main"><?php echo ENTRY_GROUPS_NAME; ?></td>
            <td class="main"><?php echo tep_draw_input_field('customers_groups_name', $cInfo->customers_groups_name, 'maxlength="32"', false); ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo ENTRY_DEFAULT_DISCOUNT; ?></td>
            <td class="main">
			   <select name="customers_groups_discount_sign">
			        <option name="minus" value="-" <?php if (strstr($cInfo->customers_groups_discount,"-")) echo "selected=\"selected\"" ?>>-</option>
					<option name="plus" value="+"  <?php if (strstr($cInfo->customers_groups_discount,"+")) echo "selected=\"selected\"" ?>>+</option>
			   </select>&nbsp;<?php echo tep_draw_input_field('customers_groups_discount', substr($cInfo->customers_groups_discount,1,strlen($cInfo->customers_groups_discount)), 'maxlength="9"', false); ?>&nbsp;%
			</td>
		  </tr>
		  <tr>
            <td class="main"><?php echo ENTRY_DEFAULT_PRICE; ?></td>
            <td class="main"><?php
		       for ($i=1; $i<=tep_xppp_getpricesnum(); $i++) {
                   $price_array[] = array('id' => $i,
                              'text' => $i);
               }
               echo tep_draw_pull_down_menu('customers_groups_price', $price_array, $cInfo->customers_groups_price);
               ?>
		    </td>
		  </tr>

		   <!--  add for Minimum group price to order start	 -->
		      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '1', '5'); ?></td>
      </tr>
		  <tr>
            <td class="main"><?php echo ENTRY_GROUP_MIN_PRICE; ?></td>
            <td class="main"><?php echo tep_draw_input_field('customers_groups_min_price', $cInfo->customers_groups_min_price, 'maxlength="12"'); ?>
		    </td>
		  </tr>
		    <!--  add for Minimum group price to order end	 -->

		  <!--  add for color groups start -->
		 
	  <tr>
			<td class="main"><?php echo ENTRY_COLOR_BAR; ?></td>
			 <td>
				    <table width="50%" id="colortd" align="left" bgcolor="<?php echo $cInfo->color_bar;?>">
              <tr>                                                                                 
                <td align="center" >
          <!-- flooble.com Color Picker start -->
	          <input id="pick1064797275field" size="12" class="inputbox"
		  onChange="cp.relateColor(this.value);" title="onclick" name="color_bar" value="<?php echo $cInfo->color_bar;?>">
		  <a href="javascript:void(0)" onclick="cp.pickColor();" id="pick1064797275"
		  style="border: 1px solid #000000; font-family:Verdana; font-size:10px;
		  text-decoration: none;">&nbsp;&nbsp;&nbsp;</a>
		  <script language="javascript">
			var cp = new ColorPicker( 'cp', 'pick1064797275', '#ffffff' );
		  </script>
	        <!-- flooble Color Picker end -->              
                </td>
              </tr>
            </table>
			 </td>
			</tr>
			
<!--  add for color groups end -->		


<!-- denuz -->
  <tr>
            <td class="main"><?php echo ENTRY_ACCUMULATED_LIMIT; ?></td>
            <td class="main"><input name="customers_groups_accumulated_limit" value="<?php echo $cInfo->customers_groups_accumulated_limit?>"></td>
</tr>
  <tr>
            <td class="main" valign="top"><?php echo ENTRY_ORDERS_STATUS; ?></td>
            <td class="main">
<?php
  $orders_status_query = tep_db_query("select * from orders_status where language_id = " . $languages_id . " order by orders_status_id");
  while ($orders_status = tep_db_fetch_array($orders_status_query)) {
    $check_status_query = tep_db_query("select orders_status_id from customers_groups_orders_status where customers_groups_id = " . (int)$_GET['cID'] . " and orders_status_id = " . $orders_status['orders_status_id']);
    if (tep_db_num_rows($check_status_query)) {
      $selected = 'checked';
    } else {
      $selected = '';
    }
?>
     <input type="checkbox" name="orders_status_<?php echo $orders_status['orders_status_id']?>" value="1" <?php echo $selected?>> <?php echo $orders_status['orders_status_name']?><br>
<?php
  }
?>
</td>
</tr>
<!-- eof denuz -->

        </table></td>
      </tr>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
<!-- add for SPPC shipment and payment module start -->	
<tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
      <tr>
        <td class="formAreaTitle"><?php include_once(DIR_WS_LANGUAGES . $language . '/modules.php');
	echo HEADING_TITLE_MODULES_PAYMENT; ?></td>
      </tr>
      <tr>
        <td class="formArea"><table border="0" cellspacing="2" cellpadding="2">
	   <tr bgcolor="#DEE4E8">
            <td class="main"><?php echo tep_draw_radio_field('group_payment_settings', '1', false, (tep_not_null($cInfo->group_payment_allowed)? '1' : '0' )) . '&nbsp;&nbsp;' . ENTRY_GROUP_PAYMENT_SET . '&nbsp;&nbsp;' . tep_draw_radio_field('group_payment_settings', '0', false, (tep_not_null($cInfo->group_payment_allowed)? '1' : '0' )) . '&nbsp;&nbsp;' . ENTRY_GROUP_PAYMENT_DEFAULT ; ?></td>
          </tr>
<?php
    $module_active = explode (";",MODULE_PAYMENT_INSTALLED);
    $installed_modules = array();
    for ($i = 0, $n = sizeof($directory_array); $i < $n; $i++) {
    $file = $directory_array[$i];
    if (in_array ($directory_array[$i], $module_active)) {
      include(DIR_FS_CATALOG_LANGUAGES . $language . '/modules/payment/' . $file);
      include($module_directory . $file);

     $class = substr($file, 0, strrpos($file, '.'));
     if (tep_class_exists($class)) {
       $module = new $class;
       if ($module->check() > 0) {
         $installed_modules[] = $file;
       }
     } // end if (tep_class_exists($class))
?>
	   <tr>
            <td class="main"><?php echo tep_draw_checkbox_field('payment_allowed[' . $i . ']', $module->code.".php" , (in_array ($module->code.".php", $payments_allowed)) ?  1 : 0); ?>&#160;&#160;<?php echo $module->title; ?></td>
           </tr>
<?php
  } // end if (in_array ($directory_array[$i], $module_active)) 
 } // end for ($i = 0, $n = sizeof($directory_array); $i < $n; $i++)
?>
	   <tr>
            <td class="main" style="padding-left: 30px; padding-right: 10px; padding-top: 10px;"><?php echo ENTRY_PAYMENT_SET_EXPLAIN ?></td>
           </tr>
		   <tr>
               <td><?php echo tep_draw_separator('pixel_trans.gif', '1', '6'); ?></td>
           </tr>		   
		    <tr>
            <td class="main" style="padding-left: 30px; padding-right: 10px; padding-top: 10px;"><?php echo ENTRY_PAYMENT_SET_EXPLAIN2 ?></td>
           </tr>		   
        </table>
       </td>
      </tr>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
      <tr>
        <td class="formAreaTitle"><?php echo HEADING_TITLE_MODULES_SHIPPING; ?></td>
      </tr>
      <tr>
        <td class="formArea"><table border="0" cellspacing="2" cellpadding="2">
	   <tr bgcolor="#DEE4E8">
            <td class="main"><?php echo tep_draw_radio_field('group_shipment_settings', '1', false, (tep_not_null($cInfo->group_shipment_allowed)? '1' : '0' )) . '&nbsp;&nbsp;' . ENTRY_GROUP_SHIPPING_SET . '&nbsp;&nbsp;' . tep_draw_radio_field('group_shipment_settings', '0', false, (tep_not_null($cInfo->group_shipment_allowed)? '1' : '0' )) . '&nbsp;&nbsp;' . ENTRY_GROUP_SHIPPING_DEFAULT ; ?></td>
          </tr>
<?php
    $ship_module_active = explode (";",MODULE_SHIPPING_INSTALLED);
    $installed_shipping_modules = array();
    for ($i = 0, $n = sizeof($ship_directory_array); $i < $n; $i++) {
    $file = $ship_directory_array[$i];
    if (in_array ($ship_directory_array[$i], $ship_module_active)) {
      include(DIR_FS_CATALOG_LANGUAGES . $language . '/modules/shipping/' . $file);
      include($ship_module_directory . $file);

     $ship_class = substr($file, 0, strrpos($file, '.'));
     if (tep_class_exists($ship_class)) {
       $ship_module = new $ship_class;
       if ($ship_module->check() > 0) {
         $installed_shipping_modules[] = $file;
       }
     } // end if (tep_class_exists($ship_class))
?>
	   <tr>
            <td class="main"><?php echo tep_draw_checkbox_field('shipping_allowed[' . $i . ']', $ship_module->code.".php" , (in_array ($ship_module->code.".php", $shipment_allowed)) ?  1 : 0); ?>&#160;&#160;<?php echo $ship_module->title; ?></td>
           </tr>
<?php
  } // end if (in_array ($ship_directory_array[$i], $ship_module_active)) 
 } // end for ($i = 0, $n = sizeof($ship_directory_array); $i < $n; $i++)
?>
	   <tr>
            <td class="main" style="padding-left: 30px; padding-right: 10px; padding-top: 10px;"><?php echo ENTRY_SHIPPING_SET_EXPLAIN ?></td>
           </tr>
		    <tr>
               <td><?php echo tep_draw_separator('pixel_trans.gif', '1', '6'); ?></td>
           </tr>		   
		    <tr>
            <td class="main" style="padding-left: 30px; padding-right: 10px; padding-top: 10px;"><?php echo ENTRY_SHIPPING_SET_EXPLAIN2 ?></td>
           </tr>	
        </table>
       </td>
      </tr>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
<!-- SPPC shipment and payment module end -->	

      <tr>
        <td align="right" class="main"><?php echo tep_image_submit('button_update.gif', IMAGE_UPDATE) . ' <a href="' . tep_href_link('customers_groups.php', tep_get_all_get_params(array('action','cID'))) .'">' . tep_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>'; ?></td>
      </tr>
      </form>

	  <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '1', '70'); ?></td>
      </tr>

<?php
  } else if($_GET['action'] == 'newdiscount') {
?>
      <tr>
        <td><table class="table-padding-0">
          <tr>
            <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
            <td class="pageHeading" align="right"><?php echo tep_draw_separator('pixel_trans.gif', HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
      
<?php
  } else if($_GET['action'] == 'new') {
     
?>
<script language="javascript"><!--
function check_form() {
  var error = 0;

  var customers_groups_name = document.customers.customers_groups_name.value;
  
  if (customers_groups_name == "") {
    error_message = "<?php echo ERROR_CUSTOMERS_GROUPS_NAME; ?>";
    error = 1;
  }

  if (error == 1) {
    alert(error_message);
    return false;
  } else {
    return true;
  }
}
//--></script>

      <tr>
        <td><table class="table-padding-0">
          <tr>
            <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
            <td class="pageHeading" align="right"><?php echo tep_draw_separator('pixel_trans.gif', HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
      <tr><?php echo tep_draw_form('customers', 'customers_groups.php', tep_get_all_get_params(array('action')) . 'action=newconfirm', 'post', 'onSubmit="return check_form();"'); ?>
        <td class="formAreaTitle"><?php echo CATEGORY_PERSONAL; ?></td>
      </tr>
      <tr>
        <td class="formArea"><table border="0" cellspacing="2" cellpadding="2">
          <tr>
            <td class="main"><?php echo ENTRY_GROUPS_NAME; ?></td>
            <td class="main"><?php echo tep_draw_input_field('customers_groups_name', '', 'maxlength="32"', false); ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo ENTRY_DEFAULT_DISCOUNT; ?></td>
            <td class="main">
                 <select name="customers_groups_discount_sign"><option name="minus" value="-" selected="selected">-</option><option name="plus" value="+">+</option></select>&nbsp;<?php echo tep_draw_input_field('customers_groups_discount', '0', 'maxlength="9"', false); ?>&nbsp;%
			</td>
          </tr>
		  <tr>
            <td class="main"><?php echo ENTRY_DEFAULT_PRICE; ?></td>
            <td class="main"><?php
		       for ($i=1; $i<=tep_xppp_getpricesnum(); $i++) {
                   $price_array[] = array('id' => $i,
                              'text' => $i);
               }
               echo tep_draw_pull_down_menu('customers_groups_price', $price_array, '1');
               ?>
			</td>
          </tr>
<!--  add for Minimum group price to order start	 -->
   <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '1', '5'); ?></td>
      </tr>
		  <tr>
            <td class="main"><?php echo ENTRY_GROUP_MIN_PRICE; ?></td>
            <td class="main"><?php echo tep_draw_input_field('customers_groups_min_price', $cInfo->customers_groups_min_price, 'maxlength="12"'); ?>
		    </td>
		  </tr>
<!--  add for Minimum group price to order end	 -->
		  
<!--  add for color groups start -->				  
		  <tr>
			<td class="main"><?php echo ENTRY_COLOR_BAR; ?></td>
			 <td>
				    <table width="50%" id="colortd" align="left" bgcolor="#ffffff">
              <tr>                                                                                 
                <td align="center" >
          <!-- flooble.com Color Picker start -->
	          <input id="pick1064797275field" size="12" class="inputbox"
		  onChange="cp.relateColor(this.value);" title="onclick" name="color_bar" value="<?php echo $cInfo->color_bar;?>">
		  <a href="javascript:void(0)" onclick="cp.pickColor();" id="pick1064797275"
		  style="border: 1px solid #000000; font-family:Verdana; font-size:10px;
		  text-decoration: none;">&nbsp;&nbsp;&nbsp;</a>
		  <script language="javascript">
			var cp = new ColorPicker( 'cp', 'pick1064797275', '#ffffff' );
		  </script>
	        <!-- flooble Color Picker end -->              
                </td>
              </tr>
            </table>
			 </td>
			</tr>
<!--  add for color groups end -->		
          
<!-- denuz -->
  <tr>
            <td class="main"><?php echo ENTRY_ACCUMULATED_LIMIT; ?></td>
            <td class="main"><input name="customers_groups_accumulated_limit" value="<?php echo $cInfo->customers_groups_accumulated_limit?>"></td>
</tr>
  <tr>
            <td class="main" valign="top"><?php echo ENTRY_ORDERS_STATUS; ?></td>
            <td class="main">
<?php
  $orders_status_query = tep_db_query("select * from orders_status where language_id = " . $languages_id . " order by orders_status_id");
  while ($orders_status = tep_db_fetch_array($orders_status_query)) {
    $check_status_query = tep_db_query("select orders_status_id from customers_groups_orders_status where customers_groups_id = " . (int)$_GET['cID'] . " and orders_status_id = " . $orders_status['orders_status_id']);
    if (tep_db_num_rows($check_status_query)) {
      $selected = 'checked';
    } else {
      $selected = '';
    }
?>
     <input type="checkbox" name="orders_status_<?php echo $orders_status['orders_status_id']?>" value="1" <?php echo $selected?>> <?php echo $orders_status['orders_status_name']?><br>
<?php
  }
?>
</td>
</tr>
<!-- eof denuz -->

        </table></td>
      </tr>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
      
<!-- SPPC shipment and payment module start -->		  
	  <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
      <tr>
        <td class="formAreaTitle"><?php include_once(DIR_WS_LANGUAGES . $language . '/modules.php');
	echo HEADING_TITLE_MODULES_PAYMENT; ?></td>
      </tr>
      <tr>
        <td class="formArea"><table border="0" cellspacing="2" cellpadding="2">
	   <tr bgcolor="#DEE4E8">
            <td class="main"><?php echo tep_draw_radio_field('group_payment_settings', '1', false, '0') . '&nbsp;&nbsp;' . ENTRY_GROUP_PAYMENT_SET . '&nbsp;&nbsp;' . tep_draw_radio_field('group_payment_settings', '0', false, '0') . '&nbsp;&nbsp;' . ENTRY_GROUP_PAYMENT_DEFAULT ; ?></td>
          </tr>
<?php
  $module_active = explode (";",MODULE_PAYMENT_INSTALLED);
  $ship_module_active = explode (";",MODULE_SHIPPING_INSTALLED);
  $module_directory = DIR_FS_CATALOG_MODULES . 'payment/';
  $ship_module_directory = DIR_FS_CATALOG_MODULES . 'shipping/';

// code slightly adapted from admin/modules.php
  $file_extension = substr($PHP_SELF, strrpos($PHP_SELF, '.'));
  $directory_array = array();
  if ($dir = @dir($module_directory)) {
    while ($file = $dir->read()) {
      if (!is_dir($module_directory . $file)) {
        if (substr($file, strrpos($file, '.')) == $file_extension) {
          $directory_array[] = $file; // array of all the payment modules present in includes/modules/payment
        }
      }
    }
    $dir->close();
  } // end if ($dir = @dir($module_directory))

   $ship_directory_array = array();
   if ($dir = @dir($ship_module_directory)) {
    while ($file = $dir->read()) {
      if (!is_dir($ship_module_directory . $file)) {
        if (substr($file, strrpos($file, '.')) == $file_extension) {
          $ship_directory_array[] = $file; // array of all shipping modules present in includes/modules/shipping
        }
      }
    }
    sort($ship_directory_array);
    $dir->close();
  }
    $installed_modules = array();
    for ($i = 0, $n = sizeof($directory_array); $i < $n; $i++) {
    $file = $directory_array[$i];
    if (in_array ($directory_array[$i], $module_active)) {
      include(DIR_FS_CATALOG_LANGUAGES . $language . '/modules/payment/' . $file);
      include($module_directory . $file);

     $class = substr($file, 0, strrpos($file, '.'));
     if (tep_class_exists($class)) {
       $module = new $class;
       if ($module->check() > 0) {
         $installed_modules[] = array('file_name' => $file, 'title' => $module->title);
       }
     } // end if (tep_class_exists($class))
   } // end if (in_array ($directory_array[$i], $module_active)) 
 } // end for ($i = 0, $n = sizeof($directory_array); $i < $n; $i++)

  for ($y = 0; $y < sizeof($installed_modules) ; $y++) {
?>
	   <tr>
            <td class="main"><?php echo tep_draw_checkbox_field('payment_allowed[' . $y . ']', $installed_modules[$y]['file_name'] , 0); ?>&#160;&#160;<?php echo $installed_modules[$y]['title']; ?></td>
           </tr>
<?php
 } // end for ($y = 0; $y < sizeof($installed_modules) ; $y++)
?>
	   <tr>
            <td class="main" style="padding-left: 30px; padding-right: 10px; padding-top: 10px;"><?php echo ENTRY_PAYMENT_SET_EXPLAIN ?></td>
           </tr>
		    <tr>
               <td><?php echo tep_draw_separator('pixel_trans.gif', '1', '6'); ?></td>
           </tr>		   
		    <tr>
            <td class="main" style="padding-left: 30px; padding-right: 10px; padding-top: 10px;"><?php echo ENTRY_PAYMENT_SET_EXPLAIN2 ?></td>
           </tr>	
        </table>
       </td>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
      <tr>
        <td class="formAreaTitle"><?php echo HEADING_TITLE_MODULES_SHIPPING; ?></td>
      </tr>
      <tr>
        <td class="formArea"><table border="0" cellspacing="2" cellpadding="2">
	   <tr bgcolor="#DEE4E8">
            <td class="main"><?php echo tep_draw_radio_field('group_shipment_settings', '1', false, (tep_not_null($cInfo->group_shipment_allowed)? '1' : '0' )) . '&nbsp;&nbsp;' . ENTRY_GROUP_SHIPPING_SET . '&nbsp;&nbsp;' . tep_draw_radio_field('group_shipment_settings', '0', false, (tep_not_null($cInfo->group_shipment_allowed)? '1' : '0' )) . '&nbsp;&nbsp;' . ENTRY_GROUP_SHIPPING_DEFAULT ; ?></td>
          </tr>
<?php
    $ship_module_active = explode (";",MODULE_SHIPPING_INSTALLED);
    $installed_shipping_modules = array();
    for ($i = 0, $n = sizeof($ship_directory_array); $i < $n; $i++) {
    $file = $ship_directory_array[$i];
    if (in_array ($ship_directory_array[$i], $ship_module_active)) {
      include(DIR_FS_CATALOG_LANGUAGES . $language . '/modules/shipping/' . $file);
      include($ship_module_directory . $file);

     $ship_class = substr($file, 0, strrpos($file, '.'));
     if (tep_class_exists($ship_class)) {
       $ship_module = new $ship_class;
       if ($ship_module->check() > 0) {
         $installed_shipping_modules[] = array('file_name' => $file, 'title' => $ship_module->title);
       }
     } // end if (tep_class_exists($ship_class))
   } // end if (in_array ($ship_directory_array[$i], $ship_module_active))
 } // end for ($i = 0, $n = sizeof($ship_directory_array); $i < $n; $i++)

 for ($y = 0; $y < sizeof($installed_shipping_modules) ; $y++) {
?>
	   <tr>
            <td class="main"><?php echo tep_draw_checkbox_field('shipping_allowed[' . $y . ']', $installed_shipping_modules[$y]['file_name'] , 0); ?>&#160;&#160;<?php echo $installed_shipping_modules[$y]['title']; ?></td>
           </tr>
<?php
  } // end for ($y = 0; $y < sizeof($installed_modules) ; $y++) 
?>
	   <tr>
            <td class="main" style="padding-left: 30px; padding-right: 10px; padding-top: 10px;"><?php echo ENTRY_SHIPPING_SET_EXPLAIN ?></td>
           </tr>
		   <tr>
               <td><?php echo tep_draw_separator('pixel_trans.gif', '1', '6'); ?></td>
           </tr>		   
		    <tr>
            <td class="main" style="padding-left: 30px; padding-right: 10px; padding-top: 10px;"><?php echo ENTRY_SHIPPING_SET_EXPLAIN2 ?></td>
           </tr>	
        </table>
       </td>
      </tr>
      </tr>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
<!-- SPPC shipment and payment module end -->	 
      
      <tr>
        <td align="right" class="main"><?php echo tep_image_submit('button_update.gif', IMAGE_UPDATE) . ' <a href="' . tep_href_link('customers_groups.php', tep_get_all_get_params(array('action','cID'))) .'">' . tep_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>'; ?></td>
      </tr>
      </form>
<?php 
  } else {
?>
      <tr>
        <td><table class="table-padding-0">
          <tr><?php echo tep_draw_form('search', 'customers_groups.php', '', 'get'); ?>
            <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
            <td class="pageHeading" align="right"><?php echo tep_draw_separator('pixel_trans.gif', 1, HEADING_IMAGE_HEIGHT); ?></td>
            <td class="smallText" align="right"><?php echo HEADING_TITLE_SEARCH . ' ' . tep_draw_input_field('search'); ?></td>
          </form></tr>
        </table></td>
      </tr>
      <tr>

          <?php
          switch ($listing) {
              case "id-asc":
              $order = "g.customers_groups_id";
              break;
              case "group":
              $order = "g.customers_groups_name";
              break;
              case "group-desc":
              $order = "g.customers_groups_name DESC";
              break;
              case "discount":
              $order = "g.customers_groups_discount";
              break;
              case "discount-desc":
              $order = "g.customers_groups_discount DESC";
              break;
              default:
              $order = "g.customers_groups_id ASC";
          }
          ?>
	    <td><table class="table-padding-0">
          <tr>
            <td valign="top"><table class="table-padding-2">
               <tr class="dataTableHeadingRow">
			       <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_NAME; ?>&nbsp;<a href="<?php echo "$PHP_SELF?listing=group"; ?>"><b>+</b></a>&nbsp;<a href="<?php echo "$PHP_SELF?listing=group-desc"; ?>"><b>-</b></a></td>
<!--  add for color groups start -->						
				<td class="dataTableHeadingContent" align="left" width="5"><?php echo GROUP_COLOR_BAR; ?>
<!--  add for color groups end -->	
<!--  add for Minimum group price to order start -->					
				<td class="dataTableHeadingContent" align="center" ><?php echo GROUP_MIN_PRICE; ?>
<!--  add for Minimum group price to order end -->				
			       
                   <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_DISCOUNT; ?>&nbsp;<a href="<?php echo "$PHP_SELF?listing=discount"; ?>"><b>+</b></a>&nbsp;<a href="<?php echo "$PHP_SELF?listing=discount-desc"; ?>"><b>-</b></a></td>
                   <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_PRICE; ?>&nbsp;</td>
<!-- denuz acc discount -->
                   <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_ACCUMULATED_LIMIT; ?>&nbsp;</td>
<!-- eof denuz acc discount -->
				   <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_ACTION; ?>&nbsp;</td>
			   </tr>

<?php
    $search = '';
    if ( ($_GET['search']) && (tep_not_null($_GET['search'])) ) {
      $keywords = tep_db_input(tep_db_prepare_input($_GET['search']));
      $search = "where g.customers_groups_name like '%" . $keywords . "%'";
    }

    // denuz  accumulated discount
    $customers_groups_query_raw = "select g.customers_groups_accumulated_limit, g.customers_groups_id, g.customers_groups_name, g.customers_groups_discount, g.customers_groups_price, g.color_bar, g.customers_groups_min_price from " . TABLE_CUSTOMERS_GROUPS . " g  " . $search . " order by $order";
    $customers_groups_split = new splitPageResults($_GET['page'], MAX_PROD_ADMIN_SIDE, $customers_groups_query_raw, $customers_groups_query_numrows);
    $customers_groups_query = tep_db_query($customers_groups_query_raw);

    while ($customers_groups = tep_db_fetch_array($customers_groups_query)) {
      $info_query = tep_db_query("select customers_info_date_account_created as date_account_created, customers_info_date_account_last_modified as date_account_last_modified, customers_info_date_of_last_logon as date_last_logon, customers_info_number_of_logons as number_of_logons from " . TABLE_CUSTOMERS_INFO . " where customers_info_id = '" . $customers_groups['customers_groups_id'] . "'");
      $info = tep_db_fetch_array($info_query);

      if (((!$_GET['cID']) || (@$_GET['cID'] == $customers_groups['customers_groups_id'])) && (!$cInfo)) {
        $cInfo = new objectInfo($customers_groups);
      }

      if ( (is_object($cInfo)) && ($customers_groups['customers_groups_id'] == $cInfo->customers_groups_id) ) {
        echo '          <tr class="dataTableRowSelected" onmouseover="this.style.cursor=\'hand\'" onclick="document.location.href=\'' . tep_href_link('customers_groups.php', tep_get_all_get_params(array('cID', 'action')) . 'cID=' . $cInfo->customers_groups_id . '&action=edit') . '\'">' . "\n";
      } else {
        echo '          <tr class="dataTableRow" onmouseover="this.className=\'dataTableRowOver\';this.style.cursor=\'hand\'" onmouseout="this.className=\'dataTableRow\'" onclick="document.location.href=\'' . tep_href_link('customers_groups.php', tep_get_all_get_params(array('cID')) . 'cID=' . $customers_groups['customers_groups_id']) . '\'">' . "\n";
      }
?>
                <td class="dataTableContent"><?php echo $customers_groups['customers_groups_name']; ?></td>
<!--  add for color groups start -->						
				<td  bgcolor="<?php echo $customers_groups['color_bar']; ?>" width="5"></td>
<!--  add for color groups end -->		
<!--  add for Minimum group price to order start -->						
				 <td class="dataTableContent" align="center"><?php echo $customers_groups['customers_groups_min_price']; ?></td>					
<!--  add for Minimum group price to order end -->		
                
                <td class="dataTableContent" align="right"><?php echo $customers_groups['customers_groups_discount']; ?>%</td>
				<td class="dataTableContent" align="right"><?php echo ENTRY_PRICE . " " . $customers_groups['customers_groups_price']; ?></td>
<!-- denuz acc discount -->
				<td class="dataTableContent" align="right"><?php echo $customers_groups['customers_groups_accumulated_limit']; ?></td>
<!-- eof denuz acc discount -->
                <td class="dataTableContent" align="right"><?php if ( (is_object($cInfo)) && ($customers_groups['customers_groups_id'] == $cInfo->customers_groups_id) ) { echo tep_image(DIR_WS_IMAGES . 'icon_arrow_right.gif', ''); } else { echo '<a href="' . tep_href_link('customers_groups.php', tep_get_all_get_params(array('cID')) . 'cID=' . $customers_groups['customers_groups_id']) . '">' . tep_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . '</a>'; } ?>&nbsp;</td>
              </tr>
<?php
    }
?>
              <tr>
                <td colspan="7"><table class="table-padding-2">
                  <tr>
                    <td class="smallText top-valign"><?php echo $customers_groups_split->display_count($customers_groups_query_numrows, MAX_PROD_ADMIN_SIDE, $_GET['page'], TEXT_DISPLAY_NUMBER_OF_CUSTOMERS); ?></td>
                    <td class="smallText" align="right"><?php echo $customers_groups_split->display_links($customers_groups_query_numrows, MAX_PROD_ADMIN_SIDE, MAX_DISPLAY_PAGE_LINKS, $_GET['page'], tep_get_all_get_params(array('page', 'info', 'x', 'y', 'cID'))); ?></td>
                  </tr>
<?php
    if (tep_not_null($_GET['search'])) {
?>
                  <tr>
                    <td align="right" colspan="2"><?php echo '<a href="' . tep_href_link('customers_groups.php') . '">' . tep_image_button('button_reset.gif', IMAGE_RESET) . '</a>'; ?></td>
                  </tr>
<?php
    } else {
?>
			      <tr>
                    <td align="right" colspan="2" class="smallText"><?php echo '<a href="' . tep_href_link('customers_groups.php', 'page=' . $_GET['page'] . '&action=new') . '">' . tep_image_button('button_insert.gif', IMAGE_INSERT) . '</a>'; ?></td>
                  </tr>
<?php
	}
?>
                </table></td>
              </tr>
            </table></td>
<?php
  $heading = array();
  $contents = array();
  switch ($_GET['action']) {
    case 'confirm':
        if ($_GET['cID'] != 1) {
            $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_DELETE_GROUP . '</b>');
            $contents = array('form' => tep_draw_form('customers_groups', 'customers_groups.php', tep_get_all_get_params(array('cID', 'action')) . 'cID=' . $cInfo->customers_groups_id . '&action=deleteconfirm'));
            $contents[] = array('text' => TEXT_DELETE_INTRO . '<br><br><b>' . $cInfo->customers_groups_name . ' </b>');
            if ($cInfo->number_of_reviews > 0) $contents[] = array('text' => '<br>' . tep_draw_checkbox_field('delete_reviews', 'on', true) . ' ' . sprintf(TEXT_DELETE_REVIEWS, $cInfo->number_of_reviews));
            $contents[] = array('align' => 'center', 'text' => '<br>' . tep_image_submit('button_delete.gif', IMAGE_DELETE) . ' <a href="' . tep_href_link('customers_groups.php', tep_get_all_get_params(array('cID', 'action')) . 'cID=' . $cInfo->customers_groups_id) . '">' . tep_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>');
        } else {
            $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_DELETE_GROUP . '</b>');
            $contents[] = array('text' => 'Non e\' consentito cancellare il gruppo:<br><br><b>' . $cInfo->customers_groups_name . ' </b>');
        }
      break;
    default:
      if (is_object($cInfo)) {
        $heading[] = array('text' => '<b>' . $cInfo->customers_groups_name . ' </b>');
        $contents[] = array('align' => 'center', 'text' => '<a href="' . tep_href_link('customers_groups.php', tep_get_all_get_params(array('cID', 'action')) . 'cID=' . $cInfo->customers_groups_id . '&action=edit') . '">' . tep_image_button('button_edit.gif', IMAGE_EDIT) . '</a> <a href="' . tep_href_link('customers_groups.php', tep_get_all_get_params(array('cID', 'action')) . 'cID=' . $cInfo->customers_groups_id . '&action=confirm') . '">' . tep_image_button('button_delete.gif', IMAGE_DELETE) . '</a>');

      }
      break;
  }

  if ( (tep_not_null($heading)) && (tep_not_null($contents)) ) {
    echo '            <td width="25%" valign="top">' . "\n";

    $box = new box;
    echo $box->infoBox($heading, $contents);

    echo '            </td>' . "\n";
  }
?>
          </tr>
        </table></td>
      </tr>
<?php
  }
?>
    </table></td>
<!-- body_text_eof //-->
  </tr>
</table>
<!-- body_eof //-->

<!-- footer //-->
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<!-- footer_eof //-->
<br>
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>