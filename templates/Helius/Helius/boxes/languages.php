<?php
/*
  $Id: languages.php,v 1.1.1.1 2003/09/18 19:05:48 wilt Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2001 osCommerce

  Released under the GNU General Public License
*/
?>
<!-- languages //-->
          <tr>
            <td>
<?php
  if (substr(basename($PHP_SELF), 0, 8) != 'checkout') {
  $info_box_contents = array();
    $info_box_contents[] = array('text'  => '<font color="' . $font_color . '">' . BOX_HEADING_LANGUAGES . '</font>');
  new infoBoxHeading($info_box_contents, false, false);

  if (!is_object($lng)) {
    include(DIR_WS_CLASSES . 'language.php');
    $lng = new language;
  }

  if (getenv('HTTPS') == 'on') $connection = 'SSL';
  else $connection = 'NONSSL';

  $languages_string = '';
  reset($lng->catalog_languages);
  while (list($key, $value) = each($lng->catalog_languages)) {
    $languages_string .= ' <a href="' . tep_href_link(basename($PHP_SELF), tep_get_all_get_params(array('language', 'currency')) . 'language=' . $key, $connection) . '">' . tep_image(DIR_WS_LANGUAGES_IMAGES .  $value['directory'] . '/images/' . $value['image'], $value['name']) . '</a> ';
  }

  $info_box_contents = array();
  $info_box_contents[] = array('align' => 'center',
                               'text'  => $languages_string
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
<!-- languages_eof //-->
