<?php
/*
  $Id: currencies.php,v 1.1.1.1 2003/09/18 19:05:50 wilt Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2001 osCommerce

  Released under the GNU General Public License
*/
?>
<!-- currencies //-->
<div class="box">
<b class="top"><b class="b1"></b><b class="b2"></b><b class="b3"></b><b class="b4"></b><b class="b5"></b></b>
<div class="boxHeader">
<h5><?php echo BOX_HEADING_CURRENCIES; ?></h5>
</div>
<div class="boxContent">
<p>
<?php
  if (substr(basename($PHP_SELF), 0, 8) != 'checkout') {

  $select_box = '<select name="currency" onChange="this.form.submit();" style="width: 100%">';
  reset($currencies->currencies);
  while (list($key, $value) = each($currencies->currencies)) {
    $select_box .= '<option value="' . $key . '"';
// $currency is a session variable
    if ($currency == $key) {
      $select_box .= ' SELECTED';
    }
    $select_box .= '>' . $value['title'] . '</option>';
  }
  $select_box .= "</select>";
  $select_box .= tep_hide_session_id();

  $hidden_get_variables = '';
  reset($_GET);
  while (list($key, $value) = each ($_GET)) {
    if ( ($key != 'currency') && ($key != tep_session_name()) ) {
      $hidden_get_variables .= tep_draw_hidden_field($key, $value);
    }
  }

  if (getenv('HTTPS') == 'on') $connection = 'SSL';
  else $connection = 'NONSSL';

  $select_box .= $hidden_get_variables;

  echo '<form name="currencies" method="get" action="' . tep_href_link(basename($PHP_SELF), '', $connection, false) . '">';
  echo $select_box;
  echo '</form>';

}
?>
</p>
</div>
<b class="bottom"><b class="b5b"></b><b class="b4b"></b><b class="b3b"></b><b class="b2b"></b><b class="b1b"></b></b>
</div>
<!-- currencies_eof //-->