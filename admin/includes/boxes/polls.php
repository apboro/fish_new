<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2010 osCommerce

  Released under the GNU General Public License
*/

  $cl_box_groups[] = array(
    'heading' => BOX_HEADING_POLLS,
    'apps' => array(
      array(
        'code' => FILENAME_POLLS,
        'title' => BOX_POLLS_POLLS,
        'link' => tep_href_link(FILENAME_POLLS)
      ),
      array(
        'code' => FILENAME_POLLS,
        'title' => BOX_POLLS_CONFIG,
        'link' => tep_href_link(FILENAME_POLLS, 'info=1&action=config', 'NONSSL')
      )
    )
  );
?>