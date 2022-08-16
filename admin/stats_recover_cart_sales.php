<?php
/*
  $Id$
  Recover Cart Sales Report v1.3.6

  contrib: JM Ivler 11/20/03
  (c) Ivler/ osCommerce
  http://www.oscommerce.com

  Released under the GNU General Public License

 Modifed by Aalst (recover_cart_sales.php,v 1.2)
 aalst@aalst.com
 Nov 28th 2003

 Modifed by Aalst (recover_cart_sales.php,v 1.3)
 aalst@aalst.com
 Nov 29th 2003

 Modifed by Aalst (recover_cart_sales.php,v 1.3.5)
 aalst@aalst.com
 Nov 30th 2003

 Modifed by Aalst (recover_cart_sales.php,v 1.3.6)
 aalst@aalst.com
 Dec 2nd 2003
*/

  require('includes/application_top.php');

  require(DIR_WS_CLASSES . 'currencies.php');
  $currencies = new currencies();

/**
 * CONFIGURATION VARIABLES
 */

$BASE_DAYS = 10;

?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<title><?php echo TITLE; ?></title>
<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
</head>
<body marginwidth="0" marginheight="0" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0" bgcolor="#FFFFFF">
<!-- header //-->
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
<!-- header_eof //-->

<!-- body //-->
<?
function seadate($day) {
 $ts = date("U");
 $rawtime = strtotime("-".$day." days", $ts);
 $ndate = date("Ymd", $rawtime);
return $ndate;
}
?>
<table border="0" width="100%" cellspacing="2" cellpadding="2">
  <tr>
    <td width="<?php echo BOX_WIDTH; ?>" valign="top"><table border="0" width="<?php echo BOX_WIDTH; ?>" cellspacing="1" cellpadding="1" class="columnLeft">
<!-- left_navigation //-->
<?php require(DIR_WS_INCLUDES . 'column_left.php'); ?>
<!-- left_navigation_eof //-->
    </table></td>
<!-- body_text //-->
    <td width="100%" valign="top"><table class="table-padding-2">
      <tr>
        <td colspan=5><table class="table-padding-0">
          <tr>

<?
//  echo $ndate; // debug line, shows the date we are seeking
?>
<!-- new header -->
          <table class="table-padding-2">
          <table class="table-padding-2"><tr><td>
            <tr>
              <td class="pageHeading" align="left"><?php echo HEADING_TITLE; ?></td>
              <td class="pageHeading" align="right">
                <?php  $tdate = $_POST['tdate'];
                    if ($_POST['tdate'] == '') $tdate = $BASE_DAYS;
                    $ndate = seadate($tdate); ?>
                <form method=post action=<?php echo $PHP_SELF;?> >
                  <table align="right" width="100%">
                    <tr class="dataTableContent" align="right">
                      <td><?php echo DAYS_FIELD_PREFIX; ?><input type=text size=
4 width=4 value=<?php echo $tdate; ?> name=tdate><?php echo DAYS_FIELD_POSTFIX; ?><input type=submit value="<?php echo DAYS_FIELD_BUTTON; ?>"></td>
                    </tr>
                  </table></td></tr></table>
                </form>
              </td>
            </tr>
<?php
  $custknt = 0;
  $tdate = $_POST['tdate'];
  if ($_POST['tdate'] == '') $tdate = '3';
  $ndate = seadate($tdate);
//  echo $ndate; // debug line, shows the date we are seeking
  $conquery = tep_db_query("select * from ". TABLE_SCART ." where dateadded >= '".$ndate."'" );
  $knt = tep_db_num_rows($conquery);
  for ($i = 0; $i < $knt; $i++) {
     $inrec = tep_db_fetch_array($conquery);
// echo $inrec['dateadded']."<br>"; '' debug line
     $cid = $inrec['customers_id'];
     $query1 = tep_db_query("select cus.customers_firstname as fname, cus.customers_lastname as lname from customers as cus where cus.customers_id ='".$cid."'");
     $crec = tep_db_fetch_array($query1);
     $cquery = tep_db_query("select * from orders where customers_id = '".$cid."'" );
     $iknt = tep_db_num_rows($cquery);
     for ($j = 0; $j < $iknt; $j++) {
       $orec = tep_db_fetch_array($cquery);
// split the date_purchased on the space
       $orderdate = explode(' ',$orec['date_purchased']);
// take the [0] and remove the "-"'s
       $odate = str_replace('-','',$orderdate[0]);
// see if they have purchased since the message
       if ($inrec['dateadded'] <= $odate) {
         $custknt++;
       ($custknt % 2 ? $class = 'dataTableRow' : $class = '');
         $custlist .= "<tr class=".$class."><td class=datatablecontent><a href='" . tep_href_link(FILENAME_CUSTOMERS, 'search=' . $crec['lname'], 'NONSSL') . "'>".$crec['lname'].", ".$crec['fname']."</td</a></tr>";
       }
     }
  }
   $cline = " <tr><td><b>". RECORDS ."</b>".$knt."</td></tr> <tr><td><b>". SALES ."</b>".$custknt."</td></tr> ";
   echo $cline;
?>
      <tr>
        <td class="smallText">
       <tr class="dataTableHeadingRow">
        <td width=100% class="dataTableHeadingContent">Customer</td>
       </tr>
<?
   $cline = $custlist."</table></td></tr>";
   echo $cline;

?>
     </tr>
    </table>
   </td>
   </tr>
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
