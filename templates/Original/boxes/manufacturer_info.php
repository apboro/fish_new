<?php
/*
  $Id: manufacturer_info.php,v 1.1.1.1 2003/09/18 19:05:49 wilt Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2001 osCommerce

  Released under the GNU General Public License
*/
 if (isset($_GET['products_id'])){
// BOF manufacturers descriptions
//  $manufacturer_query = tep_db_query("select m.manufacturers_id, m.manufacturers_name, m.manufacturers_image from " . TABLE_MANUFACTURERS . " m, " . TABLE_PRODUCTS . " p  where p.products_id = '" . $_GET['products_id'] . "' and p.manufacturers_id = m.manufacturers_id");
  $manufacturer_query = tep_db_query("select m.manufacturers_id, mi.manufacturers_name, m.manufacturers_image from " . TABLE_MANUFACTURERS . " m left join " . TABLE_MANUFACTURERS_INFO . " mi on (m.manufacturers_id=mi.manufacturers_id), " . TABLE_PRODUCTS . " p where p.products_id = '" . $_GET['products_id'] . "' and p.manufacturers_id = m.manufacturers_id and mi.languages_id = '" . (int)$languages_id . "'");
// EOF manufacturers descriptions
  if (tep_db_num_rows($manufacturer_query)) {
    $manufacturer = tep_db_fetch_array($manufacturer_query);

    $manufacturer_url_query = tep_db_query("select manufacturers_url from " . TABLE_MANUFACTURERS_INFO . " where manufacturers_id = '" . $manufacturer['manufacturers_id'] . "'");
    $manufacturer_url_values = tep_db_fetch_array($manufacturer_url_query);

//    $has_manufacturer_url = (strlen($manufacturer_url_values['manufacturers_url'])>0) ? true : false;
?>
<!-- manufacturer_info //-->
          <tr>
            <td>
<?php
  $info_box_contents = array();
/* ORIGINAL 213
    $info_box_contents[] = array('text'  => '<font color="' . $font_color . '">' . BOX_HEADING_MANUFACTURER_INFO . '</font>');
*/
/* CDS Patch. 12. BOF */
    if (strlen($manufacturer_url_values['manufacturers_url'])>0){
    $info_box_contents[] = array('text'  => '<a href="' . tep_href_link(FILENAME_REDIRECT, 'action=manufacturer', 'NONSSL') . '"><font color="' . $font_color . '">' . BOX_HEADING_MANUFACTURER_INFO . '</font></a>');
    }else{
    $info_box_contents[] = array('text'  => '<font color="' . $font_color . '">' . BOX_HEADING_MANUFACTURER_INFO . '</font>');    
    }
/* CDS Patch. 12. EOF */
  new infoBoxHeading($info_box_contents, false, false);

if (isset($manufacturer['manufacturers_image'])){
     $manufacturer_info_string = '<figure align="center" class="hidecaption">' . tep_image(DIR_WS_IMAGES . $manufacturer['manufacturers_image'], $manufacturer['manufacturers_name']) . '<figcaption>'.$manufacturer['manufacturers_name'].'</figcaption></figure><table border="0" width="80%" cellspacing="0" cellpadding="0">';
}else{
$manufacturer_info_string = '<div align="center"></div><table border="0" width="80%" cellspacing="0" cellpadding="0">';
}

    if (strlen($manufacturer_url_values['manufacturers_url'])>0){ $manufacturer_info_string .= '<tr><td valign="top" class="smalltext">-&nbsp;</td><td valign="top" class="smalltext"><a href="' . tep_href_link(FILENAME_REDIRECT, 'action=manufacturer&manufacturers_id=' . $manufacturer['manufacturers_id'], 'NONSSL') . '" target="_blank">' . sprintf(BOX_MANUFACTURER_INFO_HOMEPAGE, $manufacturer['manufacturers_name']) . '</a></td></tr>';}

    $manufacturer_info_string .= '<tr><td valign="top" class="smalltext">-&nbsp;</td><td valign="top" class="smalltext"><a href="' . tep_href_link(FILENAME_DEFAULT, 'manufacturers_id=' . $manufacturer['manufacturers_id'], 'NONSSL') . '">' . BOX_MANUFACTURER_INFO_OTHER_PRODUCTS . '</a></td></tr></table>';

    $info_box_contents = array();
    $info_box_contents[] = array('align' => 'left',
                                 'text'  => $manufacturer_info_string);
new infoBox($info_box_contents);

}
?>
            </td>
          </tr>
<!-- manufacturer_info_eof //-->
<?php
  }
?>
