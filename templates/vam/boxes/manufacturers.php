<?php
/*
  $Id: manufacturers.php,v 1.1.1.1 2003/09/18 19:05:50 wilt Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2001 osCommerce

  Released under the GNU General Public License
*/

//###############################################
//  if ( (USE_CACHE == 'true') && !defined('SID')) {
//    echo tep_cache_manufacturers_box();
//  } else {
//##############################################
?>
<!-- manufacturers //-->
<div class="box">
<b class="top"><b class="b1"></b><b class="b2"></b><b class="b3"></b><b class="b4"></b><b class="b5"></b></b>
<div class="boxHeader">
<h5><?php echo BOX_HEADING_MANUFACTURERS; ?></h5>
</div>
<div class="boxContent">
<p>
<?php

// BOF manufacturers descriptions
//  $manufacturers_query = tep_db_query("select manufacturers_id, manufacturers_name from " . TABLE_MANUFACTURERS . " order by manufacturers_name");
  $manufacturers_query = tep_db_query("select manufacturers_id, manufacturers_name from " . TABLE_MANUFACTURERS_INFO . " where languages_id = '" . (int)$languages_id . "' order by manufacturers_name");
// EOF manufacturers descriptions

  if (tep_db_num_rows($manufacturers_query) <= MAX_DISPLAY_MANUFACTURERS_IN_A_LIST) {
// Display a list
      $manufacturers_list = '';
      while ($manufacturers = tep_db_fetch_array($manufacturers_query)) {
        $manufacturers_name = ((strlen($manufacturers['manufacturers_name']) > MAX_DISPLAY_MANUFACTURER_NAME_LEN) ? utf8_substr($manufacturers['manufacturers_name'], 0, MAX_DISPLAY_MANUFACTURER_NAME_LEN*2) . '..' : $manufacturers['manufacturers_name']);
        if (isset($_GET['manufacturers_id']) && ($_GET['manufacturers_id'] == $manufacturers['manufacturers_id'])) $manufacturers_name = '<b>' . $manufacturers_name .'</b>';
        $manufacturers_list .= '<a href="' . tep_href_link(FILENAME_DEFAULT, 'manufacturers_id=' . $manufacturers['manufacturers_id']) . '">' . $manufacturers_name . '</a><br>';
      }
      
    echo $manufacturers_list;
  } else {
// Display a drop-down
    $select_box = '<select name="manufacturers_id" onChange="this.form.submit();" size="' . MAX_MANUFACTURERS_LIST . '" style="width: 100%">';
    if (MAX_MANUFACTURERS_LIST < 2) {
      $select_box .= '<option value="">' . PULL_DOWN_DEFAULT . '</option>';
    }
    while ($manufacturers_values = tep_db_fetch_array($manufacturers_query)) {
      $select_box .= '<option value="' . $manufacturers_values['manufacturers_id'] . '"';
      if ($_GET['manufacturers_id'] == $manufacturers_values['manufacturers_id']) $select_box .= ' SELECTED';
      $select_box .= '>' . utf8_substr($manufacturers_values['manufacturers_name'], 0, MAX_DISPLAY_MANUFACTURER_NAME_LEN) . '</option>';
    }
    $select_box .= "</select>";
    $select_box .= tep_hide_session_id();

    echo '<form name="manufacturers" method="get" action="' . tep_href_link(FILENAME_DEFAULT, '', 'NONSSL', false) . '">';
    echo $select_box;
    echo '</form>';
  }

?>
</p>
</div>
<b class="bottom"><b class="b5b"></b><b class="b4b"></b><b class="b3b"></b><b class="b2b"></b><b class="b1b"></b></b>
</div>
<?php
//}
?>
<!-- manufacturers_eof //-->