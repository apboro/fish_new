<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2010 osCommerce

  Released under the GNU General Public License
*/

  $cl_box_groups[] = array(
    'heading' => BOX_HEADING_MODULES,
    'apps' => array(
      array(
        'code' => FILENAME_MODULES,
        'title' => BOX_MODULES_PAYMENT,
        'link' => tep_href_link(FILENAME_MODULES, 'set=payment', 'NONSSL')
      ),
      array(
        'code' => FILENAME_MODULES,
        'title' => BOX_MODULES_SHIPPING,
        'link' => tep_href_link(FILENAME_MODULES, 'set=shipping', 'NONSSL')
      ),
      array(
        'code' => FILENAME_MODULES,
        'title' => BOX_MODULES_ORDER_TOTAL,
        'link' => tep_href_link(FILENAME_MODULES, 'set=ordertotal', 'NONSSL')
      ),
      array(
        'code' => FILENAME_CIP_MANAGER,
        'title' => CIP_TITLE,
        'link' => tep_href_link(FILENAME_CIP_MANAGER)
      ),
      array(
        'code' => FILENAME_SHIP2PAY,
        'title' => BOX_MODULES_SHIP2PAY,
        'link' => tep_href_link(FILENAME_SHIP2PAY)
      ),
      array(
        'code' => FILENAME_MODULES,
        'title' => '<b style="color:blue">Мобильные боксы</b>',
        'link' => tep_href_link(FILENAME_MODULES,'set=mboxes','NONSSL')
      )      
    )
  );
?>