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
<tr>
            <td>
<?php
  if (substr(basename($PHP_SELF), 0, 8) != 'checkout') {
  $info_box_contents = array();
    $info_box_contents[] = array('text'  => '<font color="' . $font_color . '">' . BOX_HEADING_CURRENCIES . '</font>');
  new infoBoxHeading($info_box_contents, false, false);

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

  $info_box_contents = array();
  $info_box_contents[] = array('form'  => '<form name="currencies" method="get" action="' . tep_href_link(basename($PHP_SELF), '', $connection, false) . '">',
                               'align' => 'left',
                               'text'  => $select_box
                              );

new infoBox($info_box_contents);

$info_box_contents = array();
  $info_box_contents[] = array('align' => 'left',
                                'text'  => tep_draw_separator('pixel_trans.gif', '100%', '1')
                              );
  new infoboxFooter($info_box_contents, true, true);
}
?>
            </td>
</tr>
<!-- currencies_eof //-->
