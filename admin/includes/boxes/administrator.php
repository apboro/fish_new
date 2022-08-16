<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2010 osCommerce

  Released under the GNU General Public License
*/

  $cl_box_groups[] = array(
    'heading' => BOX_HEADING_ADMINISTRATOR,
    'apps' => array(
      array(
        'code' => FILENAME_ADMIN_MEMBERS,
        'title' => BOX_ADMINISTRATOR_MEMBERS,
        'link' => tep_href_link(FILENAME_ADMIN_MEMBERS)
      ),
      array(
        'code' => FILENAME_ADMIN_ACCOUNT,
        'title' => BOX_ADMINISTRATOR_ACCOUNT_UPDATE,
        'link' => tep_href_link(FILENAME_ADMIN_ACCOUNT)
      ),
      array(
        'code' => FILENAME_ADMIN_FILES,
        'title' => BOX_ADMINISTRATOR_BOXES,
        'link' => tep_href_link(FILENAME_ADMIN_FILES)
      )
    )
  );
?>