<?php
/*
  $Id: header.php,v 1.2 2003/09/24 13:57:07 wilt Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2002 osCommerce

  Released under the GNU General Public License
*/

  if ($messageStack->size > 0) {
    echo $messageStack->output();
  }

?>

<link rel="stylesheet" type="text/css" href="../jscript/jquery/plugins/ui/css/smoothness/jquery-ui-1.8.7.custom.css">

<script type="text/javascript" src="../jscript/jquery/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="../jscript/jquery/plugins/ui/jquery-ui-1.8.6.min.js"></script>
<link rel="stylesheet" type="text/css" href="/jscript/jquery/plugins/fancybox/jquery.fancybox-1.3.4.css" media="screen" />
<script type="text/javascript" src="/jscript/jquery/plugins/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<script>jQuery_old = jQuery.noConflict(true);</script>
<script type="text/javascript" src="../jscript/jquery/jquery-2.0.3.min.js"></script>
<script type="text/javascript" src="/jscript/jquery/select2.min.js"></script>
<link rel="stylesheet" type="text/css" href="/jscript/jquery/select2.min.css" media="screen" />
<script type="text/javascript" src="/admin/includes/javascript/main.js?v=2"></script>

<script>jQuery = jQuery_old;
    $ = jQuery;</script>
<table class="table-padding-0">

<tr>
<td align="left" colspan="2" width="100%" valign="top">
    	<?php
        	echo '<a href="#">' . tep_image(DIR_WS_IMAGES . 'oscommerce.gif') . '</a>';
        ?>
</td>
</tr>

<tr>
<td align="left" colspan="2" width="100%" valign="top">

<table border="0" cellpadding="0" cellspacing="0" width="100%">
<tr><td bgcolor="black" height="1" colspan=2></td></tr>
<tr class="headerNavigation" height="25">
    <td  height="25" background="images/back.gif" class="headerBarContent" align="right" valign="middle">
    <span class="headerBarSearch">
             <table border="0"><tr>
                <td class="smallText" align="right">
              <?php echo tep_draw_form('orders', FILENAME_ORDERS, '', 'get'); ?>
	      <?php 
		  $pribil = 0;
		  $date1 = $_GET['date1'];
		  $date2 = $_GET['date2'];
		  if($date1 != "" AND $date2 != ""){
			  $price_query = tep_db_query("select * from `orders` WHERE `date_purchased` >= '" .$date1. "' AND `date_purchased` <= '".$date2."'");
		  }
		  if($date1 == "" AND $date2 == ""){
$d = date('Y-n-d');
 $date = explode("-", $d);
 $date = $date[2];
  $time = time()-(86400*$date);
  $time = date('Y-m-d H:i:s', $time);
			  $price_query = tep_db_query("select * from `orders` WHERE `date_purchased` >= '".$time."'");
		  }
		  if($date1 != "" AND $date2 == ""){
			  $price_query = tep_db_query("select * from `orders` WHERE `date_purchased` >= '" .$date1. "'");
		  }
		  if($date1 == "" AND $date2 != ""){
			  $price_query = tep_db_query("select * from `orders` WHERE `date_purchased` <= '".$date2."'");
		  }
          echo 'Поиск по ID заказа:' . ' ' . tep_draw_input_field('oID', '', 'size="12"') . tep_draw_hidden_field('action', 'edit'); ?>
              <?php echo tep_hide_session_id(); ?>
			  <?php
			  while($product_order = mysqli_fetch_array($price_query)) {
				if($product_order['orders_status'] != 6 AND $product_order['orders_status'] != 17 AND $product_order['orders_status'] != 13){
					$price_query1 = tep_db_query("select * from `orders_products` WHERE `orders_id` = ".$product_order['orders_id']);
					while($product_order1 = mysqli_fetch_array($price_query1)) {
						$pribil1 = $product_order1['final_price'] - $product_order1['zakaz_price'];
						$pribil += $pribil1 * $product_order1['products_quantity'];
					}			 
				}			 
			  }			  
			  ?>			  
              <input type="submit" value="Поиск"></form>
              </td>
              <td>    
              <form method="get">
              Поиск товара в заказах: <input type="text" name="search_product" />
              <?php
              
               $orders_products_query = tep_db_query("
               SELECT o.orders_id, o.orders_status, op.products_name, op.products_model
                from orders_products op 
 join orders o on o.orders_id=op.orders_id
 where concat_ws(' ', op.products_name, op.products_model)
  LIKE '%" . trim($_GET['search_product']) . "%' and o.orders_status not in (16,5,6) 
order by op.orders_id desc limit 30");
                while ($tovars = tep_db_fetch_array($orders_products_query)) {
                 $orders .= $tovars['orders_id'].'+';
                }
                $orders=substr($orders, 0, -1);
               if (isset($_GET['search_product'])){
                  header('HTTP/1.1 200 OK');
                  header('Location: invoiceall.php?process=1&orders='.$orders);
               }
               unset($_GET['search_product']);
            ?>
            <input type="submit" value="Поиск"></form>
			  <!-- <td style="padding-left: 50px;">Месячная прибыль: <?php //echo floor($pribil); ?>руб. <input type="date" id="date1" name="date1" onchange="editInputs()"/> до <input type="date" id="date2" name="date2" onchange="editInputs()"/><a href="?date1" id="perdata" name="perdata" ><font color="blue">По дате </font></a></td>-->
              </tr>
<script>
function editInputs(){
  var inputvalue1 = document.getElementById('date1').value;
  var inputvalue2 = document.getElementById('date2').value;
  document.getElementById("perdata").href = '?date1=' + inputvalue1 + '&date2=' + inputvalue2;
}
</script>
            </table>
    </span>
        <span>
            Количество активных товаров: <?php
            $query = tep_db_query("
                            SELECT COUNT(*) as count FROM products where products_quantity > 0 and products_status>0
                            ");

            $res = tep_db_fetch_array($query);
            $count = $res['count'];
            echo $count;
            ?>
        </span>
    <?php echo '&nbsp;&nbsp;<a href="' . tep_catalog_href_link() . '" class="headerLink">' . HEADER_TITLE_ONLINE_CATALOG . '</a> &nbsp;|&nbsp; <a href="' . tep_href_link(FILENAME_DEFAULT, '', 'NONSSL') . '" class="headerLink">' . HEADER_TITLE_TOP . '</a> &nbsp;|&nbsp; <a href="' . tep_href_link(FILENAME_LOGOFF, '', 'NONSSL') . '" class="headerLink">' . HEADER_TITLE_LOGOFF . '</a>'; ?>&nbsp;&nbsp;
</td>
</tr>
<tr><td bgcolor="black" height="1" colspan="2"></td></tr>
</table>

</td>
</tr>

</table>

<?php if (MENU_DHTML == true) require(DIR_WS_INCLUDES . 'header_navigation.php'); ?>            <table class="table-padding-0">
