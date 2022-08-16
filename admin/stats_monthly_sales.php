<?php
/*
  $Id: stats_monthly_sales.php,v 1.1 2003/09/28 23:38:19 anotherlango Exp $

  contributed by Fritz Clapp <osc@sonnybargercycles.com>

This report displays a summary of monthly totals:
	gross income (product sales + tax collected + shipping/handling charges + low order fees)
	product sales (exempt + taxable)
	product sales exempt
	product sales taxable
	sales tax collected
	shipping/handling charges
	low order fees
The data comes from the orders and orders_total tables, therefore this report
works only for osCommerce snapshots since 2002/04/08.

added 1.1:	annual footers for all columns;
			summary prepared for all orders or by status;
added 1.2:	extra column for any added class values in orders_total table,
			header can be set in language file as "Other" or "Gift Voucher";
added 1.3:	download report data in Comma Separated Values to file;
			spawn window with printer friendly contents, selection criteria and date;
			omit column for low order fee if not enabled in store configuration;
			help screen to describe report contents and facilities;
			(stubs placed for future capability to make rows active links)
bugfix 1.4:	added file exist check before delete of temp.csv file;
			removed misbehaving javascript in stub for active rows;
 			
bugfix 1.4a: removed unnecessary delete of temp.csv file;

bugfix 1.4b: corrections to extra class query, footer total clearing and layout;

added 1.5:	allow disabling of csv capability (set $csv_enabled to false);
revised 1.54:	added parameter in call to tep_get_zone_name;
revised 1.54x:	version with CSV capability set false
revised 1.55x:	changed call to array_merge instead of tep_array_merge;
revised 1.55a:	made compatable with osCommerce 2.2 MS2;

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com
  Copyright (c) 2002 osCommerce
  Released under the GNU General Public License
*/
////////////////////////// 
// Disable CSV file capability for systems lacking permission
$csv_enabled = false;
//////////////////////////

  require('includes/application_top.php');

  require(DIR_WS_CLASSES . 'currencies.php');
  $currencies = new currencies();
  
?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<title><?php echo TITLE; ?></title>
<link rel="stylesheet" type="text/css" href="<?php if(!$print) {
	echo 'includes/stylesheet.css';}
	else echo 'includes/printer.css'; ?>">
</head>
<body marginwidth="0" marginheight="0" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0" bgcolor="#FFFFFF">
<?php
// printer-friendly version
($_GET['print']=='yes') ? $print=true : $print=false;
?>
<!-- header //-->
<?php if(!$print) require(DIR_WS_INCLUDES . 'header.php'); ?>
<!-- header_eof //-->

<!-- body //-->
<table border="0" width="100%" cellspacing="2" cellpadding="2">
  <tr>

<?php if(!$print) {?>
	<td width="<?php echo BOX_WIDTH; ?>" valign="top"><table border="0" width="<?php echo BOX_WIDTH; ?>" cellspacing="1" cellpadding="1" class="columnLeft">
	<!-- left_navigation //-->
	<?php require(DIR_WS_INCLUDES . 'column_left.php'); ?>
	<!-- left_navigation_eof //-->
        </table></td>
<?php	};	?>

<!-- body_text //-->
    <td width="100%" valign="top">
	<table class="table-padding-2">
      <tr>
        <td>
		<table class="table-padding-0">
<?php if ($print) {
	echo "<tr><td class=\"pageHeading\">" . STORE_NAME ."</td></tr>";
	};
?>
		  <tr>
            <td class="pageHeading">
			<?php echo HEADING_TITLE; ?></td>
<?php 
// get list of orders_status names for dropdown selection
  $orders_statuses = array();
  $orders_status_array = array();
  $orders_status_query = tep_db_query("select orders_status_id, orders_status_name from " . TABLE_ORDERS_STATUS . " where language_id = '" . $languages_id . "'");
  while ($orders_status = tep_db_fetch_array($orders_status_query)) {
    $orders_statuses[] = array('id' => $orders_status['orders_status_id'],
                 'text' => $orders_status['orders_status_name']);
    $orders_status_array[$orders_status['orders_status_id']] = $orders_status['orders_status_name'];
	  };
// name of status selection
$orders_status_text = TEXT_ALL_ORDERS;
if ($_GET['status']) {
  $status = tep_db_prepare_input($_GET['status']);
  $orders_status_query = tep_db_query("select orders_status_name from " . TABLE_ORDERS_STATUS . " where language_id = '" . $languages_id . "' and orders_status_id =" . $status);
  while ($orders_status = tep_db_fetch_array($orders_status_query)) {
	  $orders_status_text = $orders_status['orders_status_name'];}
				};	
if (!$print) { ?>
			<td align="right">
			<table class="table-padding-0">
			  <tr><td class="smallText" align="right">
				<?php echo tep_draw_form('status', FILENAME_STATS_MONTHLY_SALES, '', 'get');
				// get list of orders_status names for dropdown selection
				  $orders_statuses = array();
				  $orders_status_array = array();
				  $orders_status_query = tep_db_query("select orders_status_id, orders_status_name from " . TABLE_ORDERS_STATUS . " where language_id = '" . $languages_id . "'");
				  while ($orders_status = tep_db_fetch_array($orders_status_query)) {
				    $orders_statuses[] = array('id' => $orders_status['orders_status_id'],
			         'text' => $orders_status['orders_status_name']);
					$orders_status_array[$orders_status['orders_status_id']] = $orders_status['orders_status_name'];
				  };
                echo HEADING_TITLE_STATUS . ': ' . tep_draw_pull_down_menu('status', array_merge(array(array('id' => '', 'text' => TEXT_ALL_ORDERS)), $orders_statuses), '', 'onChange="this.form.submit();"'); ?><input type="hidden" name="selected_box" value="reports"></td>
              </form></tr>
             </table>
			 </td>
<?php		}; ?>

<?php if ($print) { ?>
			<td>
			</td>
		<tr><td>
				<table>
				<tr><td class="smallText"><?php echo HEADING_TITLE_REPORTED . ": "; ?></td>
				<td width="8"></td>
				<td class="smallText" align="left"><?php echo date(ltrim(TEXT_REPORT_DATE_FORMAT)); ?></td>
				</tr>
				<tr><td class="smallText" align="left">
				<?php echo HEADING_TITLE_STATUS . ": ";  ?></td>
				<td width="8"></td>
				<td class="smallText" align="left">
				<?php echo $orders_status_text;?>
				</td>
				</tr>
				<table>
			</td><td></td>
		</tr>
<?php 	};	 ?>
        </table></td>
      </tr>
<?php if(!$print) { ?>
<!--
row for buttons to print, save, and help
-->
			<tr><td colspan="2" align="right">
				<table align=right cellspacing="10"><tr>
				<td class="smallText"><a href="<?php  
				echo $_SERVER['PHP_SELF'] . "?" . $_SERVER['QUERY_STRING'] . "&print=yes";
				?>" target="print" title="<?php echo TEXT_BUTTON_REPORT_PRINT_DESC . "\">" . TEXT_BUTTON_REPORT_PRINT; ?></a>
				</td>
			<?php if ($csv_enabled) { ?>
				<td class="smallText"><a href='download_csv.php?saveas=sales_report_<?php 
				if (strpos($orders_status_text,' ')) echo substr($orders_status_text, 0, strpos($orders_status_text,' ')) . "_" . date("YmdHi"); else echo $orders_status_text . "_" . date("YmdHi"); 
				?>' title="<?php echo TEXT_BUTTON_REPORT_FILE_DESC . "\">" . TEXT_BUTTON_REPORT_FILE; ?></a>
				</td>
			<?php }; ?>
				</td>
				</tr></table>
				</td>
			</tr>
<?php	};	?>
<?php
//
// if loworder fee not enabled in configuration, omit the column
$loworder_query_raw = "select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key =" . "'MODULE_ORDER_TOTAL_LOWORDERFEE_LOW_ORDER_FEE'";
$loworder = false;
$loworder_query = tep_db_query($loworder_query_raw);
if (tep_db_num_rows($loworder_query)>0) {
	$low_setting=tep_db_fetch_array($loworder_query);
	if ($low_setting['configuration_value']=='true') $loworder=true;
};
//
// if there are extended class values in orders_table
// create extra column so totals are comprehensively correct
$class_val_subtotal = "'ot_subtotal'";
$class_val_tax = "'ot_tax'";
$class_val_shiphndl = "'ot_shipping'";
$class_val_loworder = "'ot_loworderfee'";
$class_val_total = "'ot_total'";
	$extra_class_query_raw = "select value from " . TABLE_ORDERS_TOTAL . " where class <> " . $class_val_subtotal . " and class <>" . $class_val_tax . " and class <>" . $class_val_shiphndl . " and class <>" . $class_val_loworder . " and class <>" . $class_val_total;
	$extra_class = false;
	$extra_class_query = tep_db_query($extra_class_query_raw);
	if (tep_db_num_rows($extra_class_query)>0) $extra_class = true;
// active row, user wants to display days of month
$sel_month = 0;
	if ($_GET['month']&& $_GET['year']) {
	$sel_month = tep_db_prepare_input($_GET['month']);
	$sel_year = tep_db_prepare_input($_GET['year']);
	};
// start accumulator for the report content mirrored in CSV
$csv_accum = '';
?>
      <tr>
        <td><table class="table-padding-2">
          <tr>
            <td valign="top">
			<table border="0" width='100%' cellspacing="0" cellpadding="2">
<tr class="dataTableHeadingRow">
<td class="dataTableHeadingContent" width='45' align='left' valign="bottom"><?php 
if ($sel_month == 0) mirror_out(TABLE_HEADING_MONTH); else mirror_out(TABLE_HEADING_DAYS); ?>
</td>
<td class="dataTableHeadingContent" width='35' align='left' valign="bottom"><?php 
if ($sel_month == 0) mirror_out(TABLE_HEADING_YEAR); else mirror_out(TABLE_HEADING_MONTH); ?></td>
<td class="dataTableHeadingContent" width='70' align='right' valign="bottom"><?php mirror_out(TABLE_HEADING_INCOME); ?></td>
<td class="dataTableHeadingContent" width='70' align='right' valign="bottom"><?php mirror_out(TABLE_HEADING_SALES); ?></td>
<td class="dataTableHeadingContent" width='70' align='right' valign="bottom"><?php mirror_out(TABLE_HEADING_NONTAXED); ?></td>
<td class="dataTableHeadingContent" width='70' align='right' valign="bottom"><?php mirror_out(TABLE_HEADING_TAXED); ?></td>
<td class="dataTableHeadingContent" width='70' align='right' valign="bottom"><?php mirror_out(TABLE_HEADING_TAX_COLL); ?></td>
<td class="dataTableHeadingContent" width='70' align='right' valign="bottom"><?php mirror_out(TABLE_HEADING_SHIPHNDL); ?></td>
<?php 
if ($loworder) { ?>
<td class="dataTableHeadingContent" width='70' align='right' valign="bottom"><?php mirror_out(TABLE_HEADING_LOWORDER); ?></td>
<?php }; ?>
<?php
if ($extra_class) { ?>
<td class="dataTableHeadingContent" width='70' align='right' valign="bottom"><?php mirror_out(TABLE_HEADING_OTHER); ?></td>
<?php }; ?>
</tr>
<?php 
// clear footer totals
	$ytd_gross = 0;
	$ytd_sales = 0;
	$ytd_sales_exempt = 0;
	$ytd_sales_taxable = 0;
	$ytd_tax_coll = 0;
	$ytd_shiphndl = 0;
	$ytd_loworder = 0;
	$ytd_other = 0;
// new line for CSV
$csv_accum .= "\n";
// order subtotals, the driving force 
$status = '';
$sales_query_raw = "select sum(ot.value) gross_sales, monthname(o.date_purchased) row_month, year(o.date_purchased) row_year, month(o.date_purchased) i_month, dayofmonth(o.date_purchased) row_day  from " . TABLE_ORDERS . " o left join " . TABLE_ORDERS_TOTAL . " ot on (o.orders_id = ot.orders_id) where ";
if ($_GET['status']) {
  $status = tep_db_prepare_input($_GET['status']);
  $sales_query_raw .= "o.orders_status =" . $status . " and ";
	};
$sales_query_raw .= "ot.class = " . $class_val_subtotal;
if ($sel_month<>0) $sales_query_raw .= " and month(o.date_purchased) = " . $sel_month;
$sales_query_raw .= " group by year(o.date_purchased), month(o.date_purchased)";
if ($sel_month<>0) $sales_query_raw .= ", o.date_purchased";
$sales_query_raw .=  " order by o.date_purchased desc";
$sales_query = tep_db_query($sales_query_raw);
$num_rows = tep_db_num_rows($sales_query);
if ($num_rows==0) echo '<tr><td class="smalltext">' . TEXT_NOTHING_FOUND . '</td></tr>';
$rows=0;
//
// loop here for each row reported
while ($sales = tep_db_fetch_array($sales_query)) {
	$rows++;
//
// determine tax collected for row
$tax_coll_query_raw = "select sum(ot.value) tax_coll from " . TABLE_ORDERS . " o left join " . TABLE_ORDERS_TOTAL . " ot on (o.orders_id = ot.orders_id) where ";
if ($status<>'') $tax_coll_query_raw .= "o.orders_status =" . $status . " and ";
$tax_coll_query_raw .= "ot.class = " . $class_val_tax . " and month(o.date_purchased)= '" . $sales['i_month'] . "' and year(o.date_purchased)= " . $sales['row_year'];
if ($sel_month<>0) $tax_coll_query_raw .= " and o.date_purchased = " . $sales['row_day'];
$tax_coll_query = tep_db_query($tax_coll_query_raw);
$tax_this_row = 0;
if (tep_db_num_rows($tax_coll_query)>0)	
	$tax_this_row = tep_db_fetch_array($tax_coll_query);
//
// shipping and handling charges for row
$shiphndl_query_raw = "select sum(ot.value) shiphndl from " . TABLE_ORDERS . " o left join " . TABLE_ORDERS_TOTAL . " ot on (o.orders_id = ot.orders_id) where ";
if ($status<>'') $shiphndl_query_raw .= "o.orders_status =" . $status . " and ";
$shiphndl_query_raw .= "ot.class = " . $class_val_shiphndl . " and month(o.date_purchased)= " . $sales['i_month'] . " and year(o.date_purchased)= " . $sales['row_year'];
if ($sel_month<>0) $shiphndl_query_raw .= " and o.date_purchased = " . $sales['row_day'];
$shiphndl_query = tep_db_query($shiphndl_query_raw);
$shiphndl_this_row = 0;
if (tep_db_num_rows($shiphndl_query)>0)	
	$shiphndl_this_row = tep_db_fetch_array($shiphndl_query);
//
// low order fees for row
$loworder_this_row = 0;
if ($loworder) {
	$loworder_query_raw = "select sum(ot.value) loworder from " . TABLE_ORDERS . " o left join " . TABLE_ORDERS_TOTAL . " ot on (o.orders_id = ot.orders_id) where ";
	if ($status<>'') $loworder_query_raw .= "o.orders_status =" . $status . " and ";
	$loworder_query_raw .= "ot.class = " . $class_val_loworder . " and month(o.date_purchased)= " . $sales['i_month'] . " and year(o.date_purchased)= " . $sales['row_year'];
	if ($sel_month<>0) $loworder_query_raw .= " and o.date_purchased = " . $sales['row_day'];
	$loworder_query = tep_db_query($loworder_query_raw);
	if (tep_db_num_rows($loworder_query)>0)	
	$loworder_this_row = tep_db_fetch_array($loworder_query);
};
//
// additional column if extra class value in orders_total table
$other_this_row = 0;
if ($extra_class) { 
	$other_query_raw = "select sum(ot.value) other from " . TABLE_ORDERS . " o left join " . TABLE_ORDERS_TOTAL . " ot on (o.orders_id = ot.orders_id) where ";
	if ($status<>'') $other_query_raw .= "o.orders_status =" . $status . " and ";
	$other_query_raw .= "ot.class <> " . $class_val_subtotal . " and class <> " . $class_val_tax . " and class <> " . $class_val_shiphndl . " and class <> " . $class_val_loworder . " and class <> " . $class_val_total . " and month(o.date_purchased)= " . $sales['i_month'] . " and year(o.date_purchased)= " . $sales['row_year'];
	if ($sel_month<>0) $other_query_raw .= " and o.date_purchased = " . $sales['row_day'];
	$other_query = tep_db_query($other_query_raw);
	if (tep_db_num_rows($other_query)>0)	
	$other_this_row = tep_db_fetch_array($other_query);
	};
//
// sum of orders out of zone
	$nontaxable_query_raw = "select sum(ot.value) nontaxable_sales, monthname(o.date_purchased) row_month, month(o.date_purchased) i_month from " . TABLE_ORDERS . " o left join " . TABLE_ORDERS_TOTAL . " ot on (o.orders_id = ot.orders_id) where ";
	if ($status<>'') $nontaxable_query_raw .= "o.orders_status =" . $status . " and ";
	$nontaxable_query_raw .= "ot.class = " . $class_val_subtotal . " and o.delivery_state <> '" . tep_get_zone_name(tep_get_country_name($country_id), STORE_ZONE, STORE_ZONE) . "' and month(o.date_purchased)= " . $sales['i_month'] . " and year(o.date_purchased)= " . $sales['row_year'];
	if ($sel_month<>0) {
		$nontaxable_query_raw .= " and dayofmonth(o.date_purchased) = " . $sales['row_day'] . " group by o.date_purchased";
	} else {
		$nontaxable_query_raw .= " group by month(o.date_purchased)";
	};
	$nontaxable_query = tep_db_query($nontaxable_query_raw);
	$nontaxable_this_row = tep_db_fetch_array($nontaxable_query);
//
// sum of orders in zone
	$taxable_query_raw = "select sum(ot.value) taxable_sales, monthname(o.date_purchased) row_month, month(o.date_purchased) i_month from " . TABLE_ORDERS . " o left join " . TABLE_ORDERS_TOTAL . " ot on (o.orders_id = ot.orders_id) where ";
	if ($status<>'') $taxable_query_raw .= "o.orders_status =" . $status . " and ";
	$taxable_query_raw .= "ot.class = " . $class_val_subtotal . " and o.delivery_state = '" . tep_get_zone_name(tep_get_country_name($country_id), STORE_ZONE, STORE_ZONE) . "' and month(o.date_purchased)= " . $sales['i_month'] . " and year(o.date_purchased)= " . $sales['row_year'];
	if ($sel_month<>0) {
		$taxable_query_raw .= " and dayofmonth(o.date_purchased) = " . $sales['row_day'] . " group by o.date_purchased";
	} else {
		$taxable_query_raw .= " group by month(o.date_purchased)";
	};
	$taxable_query = tep_db_query($taxable_query_raw);
	$taxable_this_row = tep_db_fetch_array($taxable_query);
//
// accumulate row results in footer
	$ytd_gross += $sales['gross_sales'] + $tax_this_row['tax_coll'] + $shiphndl_this_row['shiphndl'] + $loworder_this_row['loworder'];
	$ytd_sales += $sales['gross_sales'];
	$ytd_sales_exempt += $nontaxable_this_row['nontaxable_sales'];
	$ytd_sales_taxable += $taxable_this_row['taxable_sales'];
	$ytd_tax_coll += $tax_this_row['tax_coll'];
	$ytd_shiphndl += $shiphndl_this_row['shiphndl'];
	$ytd_loworder += $loworder_this_row['loworder'];
	if ($extra_class) { 
		$ytd_gross += $other_this_row['other'];
		$ytd_other += $other_this_row['other'];
	};
?>
<tr class="dataTableRow">
<td class="dataTableContent" align="left">
<?php mirror_out(substr($sales['row_month'],0,3)); ?>
</td>
<td class="dataTableContent" align="left">
<?php 
if ($sel_month==0) mirror_out($sales['row_year']);
else mirror_out($sales['row_day']); 
?>
</td>
<td class="dataTableContent" width='70' align="right"><?php mirror_out(number_format($sales['gross_sales'] + $tax_this_row['tax_coll'] + $shiphndl_this_row['shiphndl'] + $loworder_this_row['loworder'] + $other_this_row['other'],2)); ?></td>
<td class="dataTableContent" width='70' align="right"><?php mirror_out(number_format($sales['gross_sales'],2)); ?></td>
<td class="dataTableContent" width='70' align="right"><?php mirror_out(number_format($nontaxable_this_row['nontaxable_sales'],2)); ?></td>
<td class="dataTableContent" width='70' align="right"><?php mirror_out(number_format($taxable_this_row['taxable_sales'],2)); ?></td>
<td class="dataTableContent" width='70' align="right"><?php mirror_out(number_format($tax_this_row['tax_coll'],2)); ?></td>
<td class="dataTableContent" width='70' align="right"><?php mirror_out(number_format($shiphndl_this_row['shiphndl'],2)); ?></td>
<?php if ($loworder) { ?>
<td class="dataTableContent" width='70' align="right"><?php mirror_out(number_format($loworder_this_row['loworder'],2)); ?></td>
<?php }; ?>
<?php
if ($extra_class) { ?>
<td class="dataTableContent" width='70' align="right"><?php mirror_out(number_format($other_this_row['other'],2)); ?></td>
<?php }; ?>
</tr>
<?php 
// new line for CSV
$csv_accum .= "\n";
// output footer below month 01 of monthly rows view, or ending row
if (($sel_month==0) && ($sales['i_month']==01) || $rows==$num_rows){
?>
<tr class="dataTableHeadingRow">
<td class="dataTableHeadingContent" align="left">
<?php if ($sales['row_year']==date("Y")) mirror_out(TABLE_FOOTER_YTD); 
	else mirror_out(TABLE_FOOTER_YEAR);?>
</td>
<td class="dataTableHeadingContent" align="left">
<?php mirror_out($sales['row_year']); ?></td>
<td class="dataTableHeadingContent" width='70' align="right">
<?php mirror_out(number_format($ytd_gross,2)); ?>
</td>
<td class="dataTableHeadingContent" width='70' align="right">
<?php mirror_out(number_format($ytd_sales,2)); ?>
</td>
<td class="dataTableHeadingContent" width='70' align="right">
<?php mirror_out(number_format($ytd_sales_exempt,2)); ?>
</td>
<td class="dataTableHeadingContent" width='70' align="right">
<?php mirror_out(number_format($ytd_sales_taxable,2)); ?>
</td>
<td class="dataTableHeadingContent" width='70' align="right">
<?php mirror_out(number_format($ytd_tax_coll,2)); ?>
</td>
<td class="dataTableHeadingContent" width='70' align="right">
<?php mirror_out(number_format($ytd_shiphndl,2)); ?>
</td>
<?php if ($loworder) { ?>
<td class="dataTableHeadingContent" width='70' align="right">
<?php mirror_out(number_format($ytd_loworder,2)); ?>
</td>
<?php }; ?>
<?php if ($extra_class) { ?>
<td class="dataTableHeadingContent" width='70' align="right">
<?php mirror_out(number_format($ytd_other,2)); ?>
</td>
<?php }; 
// clear footer totals
$ytd_gross = 0;
$ytd_sales = 0;
$ytd_sales_exempt = 0;
$ytd_sales_taxable = 0;
$ytd_tax_coll = 0;
$ytd_shiphndl = 0;
$ytd_loworder = 0;
$ytd_other = 0;
// new line for CSV
$csv_accum .= "\n";
?>
</tr>
<?php };
  };
// done with report body
// save CSV as file
if ($num_rows>0 && $csv_enabled) {
	$f=fopen('temp.csv','w');
	fwrite($f,$csv_accum);
	fclose($f);
}
?>

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
<?php if(!$print) require(DIR_WS_INCLUDES . 'footer.php'); ?>
<!-- footer_eof //-->
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); 

function mirror_out ($field) {
	global $csv_accum;
	echo $field;
	$field = strip_tags($field);
	$field = preg_replace ("/,/","",$field);
	if ($csv_accum=='') $csv_accum=$field; 
	else 
	{if (strrpos($csv_accum,chr(10)) == (strlen($csv_accum)-1)) $csv_accum .= $field;
		else $csv_accum .= "," . $field; };
	return;
};

?>