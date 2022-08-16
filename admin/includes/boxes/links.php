<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2010 osCommerce

  Released under the GNU General Public License
*/

  $cl_box_groups[] = array(
    'heading' => BOX_HEADING_LINKS,
    'apps' => array(
      array(
        'code' => FILENAME_LINKS,
        'title' => BOX_LINKS_LINKS,
        'link' => tep_href_link(FILENAME_LINKS)
      ),
      array(
        'code' => FILENAME_LINK_CATEGORIES,
        'title' => BOX_LINKS_LINK_CATEGORIES,
        'link' => tep_href_link(FILENAME_LINK_CATEGORIES)
      ),
      array(
        'code' => FILENAME_LINKS_CONTACT,
        'title' => BOX_LINKS_LINKS_CONTACT,
        'link' => tep_href_link(FILENAME_LINKS_CONTACT)
      )
    )
  );
?>