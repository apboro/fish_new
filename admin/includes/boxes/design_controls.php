<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2010 osCommerce

  Released under the GNU General Public License
*/

	    $template_id_select_query = tep_db_query("select template_id from " . TABLE_TEMPLATE . "  where template_name = '" . DEFAULT_TEMPLATE . "'");
$template_id_select =  tep_db_fetch_array($template_id_select_query);

  $cl_box_groups[] = array(
    'heading' => BOX_HEADING_DESIGN_CONTROLS,
    'apps' => array(
      array(
        'code' => FILENAME_TEMPLATE_CONFIGURATION,
        'title' => BOX_HEADING_TEMPLATE_CONFIGURATION,
        'link' => tep_href_link(FILENAME_TEMPLATE_CONFIGURATION, 'cID=' . $template_id_select[template_id], 'NONSSL')
      ),
      array(
        'code' => FILENAME_TEMPLATE_CONFIGURATION,
        'title' => BOX_HEADING_BOXES,
        'link' => tep_href_link(FILENAME_INFOBOX_CONFIGURATION, 'gID=' . $template_id_select[template_id], 'NONSSL')
      )
    )
  );
?>