<?php
/*
  $Id: column_left.php,v 1.2 2003/09/24 13:57:07 wilt Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2002 osCommerce

  Released under the GNU General Public License
*/

//Admin begin
//  require(DIR_WS_BOXES . 'configuration.php');
//  require(DIR_WS_BOXES . 'catalog.php');
//  require(DIR_WS_BOXES . 'modules.php');
//  require(DIR_WS_BOXES . 'customers.php');
//  require(DIR_WS_BOXES . 'taxes.php');
//  require(DIR_WS_BOXES . 'localization.php');
//  require(DIR_WS_BOXES . 'reports.php');
//  require(DIR_WS_BOXES . 'tools.php');
//DWD Modify: Information Page Unlimited 1.1f - PT
// require(DIR_WS_BOXES . 'information.php');
//DWD Modify End

    $cl_box_groups = array();
    
  if    (MENU_DHTML != true) {
 define('BOX_WIDTH', 125);

  if (tep_admin_check_boxes('administrator.php') == true) {
    require(DIR_WS_BOXES . 'administrator.php');
  } 
  if (tep_admin_check_boxes('configuration.php') == true) {
    require(DIR_WS_BOXES . 'configuration.php');
  }
  if (tep_admin_check_boxes('catalog.php') == true) {
    require(DIR_WS_BOXES . 'catalog.php');
  } 
  if (tep_admin_check_boxes('articles.php') == true) {
    require(DIR_WS_BOXES . 'articles.php');
  } 
  if (tep_admin_check_boxes('information.php') == true) {
    require(DIR_WS_BOXES . 'information.php');
  }
  if (tep_admin_check_boxes('newsdesk.php') == true) {
    require(DIR_WS_BOXES . 'newsdesk.php');
  }
  if (tep_admin_check_boxes('faqdesk.php') == true) {
    require(DIR_WS_BOXES . 'faqdesk.php');
  }
  if (tep_admin_check_boxes('modules.php') == true) {
    require(DIR_WS_BOXES . 'modules.php');
  } 



  if (tep_admin_check_boxes('gv_admin.php') == true) {
    require(DIR_WS_BOXES . 'gv_admin.php');
  } 
  if (tep_admin_check_boxes('customers.php') == true) {
    require(DIR_WS_BOXES . 'customers.php');
  } 
  if (tep_admin_check_boxes('polls.php') == true) {
    require(DIR_WS_BOXES . 'polls.php');
  }     
  if (tep_admin_check_boxes('affiliate.php') == true) {
    require(DIR_WS_BOXES . 'affiliate.php');
  } 
  if (tep_admin_check_boxes('taxes.php') == true) {
    require(DIR_WS_BOXES . 'taxes.php');
  } 
  if (tep_admin_check_boxes('localization.php') == true) {
    require(DIR_WS_BOXES . 'localization.php');
  } 
  if (tep_admin_check_boxes('design_controls.php') == true) {
    require(DIR_WS_BOXES . 'design_controls.php');
  }
   if (tep_admin_check_boxes('links.php') == true) {
    require(DIR_WS_BOXES . 'links.php');
  }
 
  if (tep_admin_check_boxes('reports.php') == true) {
    require(DIR_WS_BOXES . 'reports.php');
  } 
  if (tep_admin_check_boxes('tools.php') == true) {
    require(DIR_WS_BOXES . 'tools.php');
  }

   include(DIR_WS_BOXES . 'mail_manager.php');
?>

<div id="adminAppMenu">

<?php
    foreach ($cl_box_groups as $groups) {
      echo '<h3><a href="#">' . $groups['heading'] . '</a></h3>' .
           '<div><ul>';

      foreach ($groups['apps'] as $app) {
        echo '<li><a href="' . $app['link'] . '">' . $app['title'] . '</a></li>';
      }

      echo '</ul></div>';
    }
?>

</div>

<script type="text/javascript">
$('#adminAppMenu').accordion({
  autoHeight: false,
  icons: {
    'header': 'ui-icon-plus',
    'headerSelected': 'ui-icon-minus'
  }

<?php
    $counter = 0;
    foreach ($cl_box_groups as $groups) {
      foreach ($groups['apps'] as $app) {
        if ($app['code'] == $PHP_SELF) {
          echo ',active: ' . $counter;
          break;
        }
      }

      $counter++;
    }
?>

});
</script>

<?php
//Admin end
}
?>
