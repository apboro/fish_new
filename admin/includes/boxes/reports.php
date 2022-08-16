<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2010 osCommerce

  Released under the GNU General Public License
*/

  $cl_box_groups[] = array(
    'heading' => BOX_HEADING_REPORTS,
    'apps' => array(
      array(
        'code' => FILENAME_STATS_PRODUCTS_VIEWED,
        'title' => BOX_REPORTS_PRODUCTS_VIEWED,
        'link' => tep_href_link(FILENAME_STATS_PRODUCTS_VIEWED)
      ),
      array(
        'code' => FILENAME_STATS_PRODUCTS_PURCHASED,
        'title' => BOX_REPORTS_PRODUCTS_PURCHASED,
        'link' => tep_href_link(FILENAME_STATS_PRODUCTS_PURCHASED)
      ),
      array(
        'code' => FILENAME_STATS_CUSTOMERS,
        'title' => BOX_REPORTS_ORDERS_TOTAL,
        'link' => tep_href_link(FILENAME_STATS_CUSTOMERS)
      ),
      array(
        'code' => FILENAME_STATS_MONTHLY_SALES,
        'title' => BOX_REPORTS_MONTHLY_SALES,
        'link' => tep_href_link(FILENAME_STATS_MONTHLY_SALES)
      ),
      array(
        'code' => FILENAME_STATS_SALES_REPORT2,
        'title' => BOX_REPORTS_SALES_REPORT2,
        'link' => tep_href_link(FILENAME_STATS_SALES_REPORT2)
      ),
      array(
        'code' => FILENAME_STATS_SALES_REPORT,
        'title' => BOX_REPORTS_SALES_REPORT,
        'link' => tep_href_link(FILENAME_STATS_SALES_REPORT)
      ),
      array(
        'code' => FILENAME_STATS_CUSTOMERS_ORDERS,
        'title' => BOX_REPORTS_CUSTOMERS_ORDERS,
        'link' => tep_href_link(FILENAME_STATS_CUSTOMERS_ORDERS)
      )
    )
  );
?>