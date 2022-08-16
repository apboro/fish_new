<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2010 osCommerce

  Released under the GNU General Public License
*/

  $cl_box_groups[] = array(
    'heading' => BOX_HEADING_PAYPALIPN_ADMIN,
    'apps' => array(
      array(
        'code' => FILENAME_PAYPALIPN_TRANSACTIONS,
        'title' => BOX_PAYPALIPN_ADMIN_TRANSACTIONS,
        'link' => tep_href_link(FILENAME_PAYPALIPN_TRANSACTIONS)
      ),
      array(
        'code' => FILENAME_PAYPALIPN_TESTS,
        'title' => BOX_PAYPALIPN_ADMIN_TESTS,
        'link' => tep_href_link(FILENAME_PAYPALIPN_TESTS)
      )
    )
  );
?>