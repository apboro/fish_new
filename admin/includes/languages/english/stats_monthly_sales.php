<?php
/*
  $Id: stats_monthly_sales.php,v 1.1 2003/09/28 23:39:22 anotherlango Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2002 osCommerce

  Released under the GNU General Public License
*/

define('HEADING_TITLE', 'Monthly Sales/Tax Summary');
define('HEADING_TITLE_STATUS','Status');
define('HEADING_TITLE_REPORTED','Reported');
define('TEXT_ALL_ORDERS', 'All orders');
define('TEXT_NOTHING_FOUND', 'No income found for this date/status selection');
define('TEXT_BUTTON_REPORT_PRINT','Print');
define('TEXT_BUTTON_REPORT_FILE','File');
define('TEXT_BUTTON_REPORT_HELP','Help');
define('TEXT_BUTTON_REPORT_PRINT_DESC', 'Show report in printer friendly window');
define('TEXT_BUTTON_REPORT_FILE_DESC', 'Download a text file of the data in this report, as Comma Separated Values');
define('TEXT_BUTTON_REPORT_HELP_DESC', 'About this report and how to use its features');
define('TEXT_REPORT_DATE_FORMAT', 'j M Y -   g:i a'); // date format string
//  as specified in php manual here: http://www.php.net/manual/en/function.date.php
define('TABLE_HEADING_YEAR','Year');
define('TABLE_HEADING_MONTH', 'Month');
define('TABLE_HEADING_DAYS', 'Days');
define('TABLE_HEADING_INCOME', 'Gross<br> Income');
define('TABLE_HEADING_SALES', 'Product<br> sales');
define('TABLE_HEADING_NONTAXED', 'Exempt<br> sales');
define('TABLE_HEADING_TAXED', 'Taxable<br> sales');
define('TABLE_HEADING_TAX_COLL', 'Tax<br> paid');
define('TABLE_HEADING_SHIPHNDL', 'Shpg<br> & Hndlg');
define('TABLE_HEADING_LOWORDER', 'Low Order<br> Fees');
define('TABLE_HEADING_OTHER', 'Gift<br> Vouchers');  // could be any other extra class value
define('TABLE_FOOTER_YTD','YTD');
define('TABLE_FOOTER_YEAR','YEAR');
?>