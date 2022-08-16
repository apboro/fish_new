<?php

/*
  $Id: stats_products_purchased.php,v 1.29 2003/06/29 22:50:52 hpdl Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License */

  require('includes/application_top.php');

  if (isset($_GET['start_date'])) {
    $start_date = $_GET['start_date'];
  } else {
    $start_date = date('Y-m-01');
  }

  if (isset($_GET['end_date'])) {
    $end_date = $_GET['end_date'];
  } else {
    $end_date = date('Y-m-d');
  }
?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN"> <html <?php echo HTML_PARAMS; ?>> <head> <meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>"> <title><?php echo TITLE; ?></title> <link rel="stylesheet" type="text/css" href="includes/stylesheet.css"> <script language="javascript" src="includes/general.js"></script>
</head>
<body marginwidth="0" marginheight="0" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0" bgcolor="#FFFFFF">
<!-- header //-->
<?php
  if ($printable != 'on') {
  require(DIR_WS_INCLUDES . 'header.php');
  }; ?>
<!-- header_eof //-->

<!-- body //-->
<table border="0" width="100%" cellspacing="2" cellpadding="2">
  <tr>
<?php 
   if ($printable != 'on') {;?>
    <td width="<?php echo BOX_WIDTH; ?>" valign="top"><table border="0" width="<?php echo BOX_WIDTH; ?>" cellspacing="1" cellpadding="1" class="columnLeft">
<!-- left_navigation //-->
<?php
 require(DIR_WS_INCLUDES . 'column_left.php'); ?>
<!-- left_navigation_eof //-->
        </table>
<?php }; ?>
</td>
<!-- body_text //-->
    <td width="100%" valign="top"><table class="table-padding-2">
      <tr>
        <td><table class="table-padding-0">
          <tr>
            <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
            <td class="pageHeading" align="right"><?php echo tep_draw_separator('pixel_trans.gif', HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?></td>
          </tr>
        </table></td>
      </tr>
<tr><td><table>
<tr><td></td><td class="main">
<?php
    echo tep_draw_form('date_range','stats_products_purchased.php' , '', 'get');
    echo ENTRY_STARTDATE . tep_draw_input_field('start_date', $start_date);
    echo ' <td> ';
    echo ENTRY_TODATE . tep_draw_input_field('end_date', $end_date). '&nbsp;';
    echo ENTRY_PRINTABLE . tep_draw_checkbox_field('printable', $print);
    echo ENTRY_SORTGROSS . tep_draw_checkbox_field('gross', $gross). '&nbsp;';
    echo '<input type="submit" value="'. ENTRY_SUBMIT .'">';
    echo '</td></form>';

    $totalgross = 0;
?>
</td></tr>
</table></td></tr>
  
      <tr>
        <td><table class="table-padding-0">
          <tr>
            <td valign="top"><table class="table-padding-2"> <tr class="dataTableHeadingRow">
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_NUMBER; ?></td>
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_MODEL; ?></td>
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_PRODUCTS; ?></td>
                <td class="dataTableHeadingContent" align="center"><?php echo TABLE_HEADING_PURCHASED; ?>&nbsp;</td>
                <td class="dataTableHeadingContent" align="center"><?php echo TABLE_HEADING_GROSS; ?>&nbsp;</td>
          </tr>
<?php
 if ($gross =='on') {
     $products_query_raw = "select op.products_id, op.products_model, op.products_name, sum(op.products_quantity) as quantitysum , sum(op.products_price*op.products_quantity)as gross FROM " . TABLE_ORDERS . " as o, " . TABLE_ORDERS_PRODUCTS . " AS op WHERE o.date_purchased BETWEEN '" . $start_date . "' AND '" . $end_date . " 23:59:59' AND o.orders_id = op.orders_id GROUP BY op.products_id ORDER BY gross DESC,quantitysum DESC, op.products_model";
   } else {
     $products_query_raw = "select op.products_id, op.products_model, op.products_name, sum(op.products_quantity) as quantitysum , sum(op.products_price*op.products_quantity)as gross FROM " . TABLE_ORDERS . " as o, " . TABLE_ORDERS_PRODUCTS . " AS op WHERE o.date_purchased BETWEEN '" . $start_date . "' AND '" . $end_date . " 23:59:59' AND o.orders_id = op.orders_id GROUP BY op.products_id ORDER BY quantitysum DESC, op.products_model";
   }

  $rows = 0;
  $products_query = tep_db_query($products_query_raw);
  
  while ($products = tep_db_fetch_array($products_query)) {
    $rows ++;
    
    $totalgross = $totalgross + $products['gross']; 


    if(strlen($rows) < 2) {
     $rows = '0' . $rows;
    }
?>
                <tr bgcolor="<?php echo ((++$cnt)%2==0) ? '#e0e0e0' : '#ffffff' ?>">
                <td class="dataTableContent"><?php echo $rows  ; ?>.</td>
                <td class="dataTableContent"><?php echo $products['products_model']; ?>
                <td class="dataTableContent"><?php echo '<a href="' . tep_href_link(FILENAME_CATEGORIES, 'action=new_product_preview&read=only&pID=' . $products['products_id'] . '&origin=' . FILENAME_STATS_PRODUCTS_PURCHASED . '?page=' . $_GET['page'], 'NONSSL') . '">' . $products['products_name'] . '</a>'; ?></td>
                <td class="dataTableContent" align="center"><?php echo $products['quantitysum']; ?>&nbsp;</td>
                <td class="dataTableContent" align="right"><?php echo sprintf("%01.2f", $products['gross']); ?>&nbsp;</td>
              </tr>
<?php
  }
?>
            <tr><td class="dataTableContent" align="right" colspan="5"><b><?php echo(ENTRY_TOTAL) ?>:</b><b><?php echo sprintf("%01.2f", $totalgross); ?></td></tr> 
            </table></td>
          </tr>

        </table></td>
      </tr>
    </table></td>
<!-- body_text_eof //-->
  </tr>
</table>
<!-- body_eof //-->

<!-- footer //-->
<?php
  if ($printable != 'on') {
   require(DIR_WS_INCLUDES . 'footer.php');
  }
?>
<!-- footer_eof //-->
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>
