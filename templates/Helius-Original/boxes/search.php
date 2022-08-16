<?php
/*
  $Id: search.php,v 1.1.1.1 2003/09/18 19:05:49 wilt Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/
?>
<!-- search //-->
          <tr>
            <td>
<?php
  $info_box_contents = array();
    $info_box_contents[] = array('text'  => '<font color="' . $font_color . '">' . BOX_HEADING_SEARCH . '</font>');
  new infoBoxHeading($info_box_contents, false, false);

  $info_box_contents = array();
// IQ 20040610-3-hhaller w013 QuickSearch searches in description, too
	if (QUICKSEARCH_IN_DESCRIPTION == 'true') {
		$iq_text = '<input type="hidden" name="search_in_description" value="1">';
	} else {
		$iq_text = '';
	}
  $info_box_contents[] = array('form' => tep_draw_form('quick_find', tep_href_link(FILENAME_ADVANCED_SEARCH_RESULT, '', 'NONSSL', false), 'get'),
                               'align' => 'center',
//                               'text' => tep_draw_input_field('keywords', '', 'size="10" maxlength="30" style="width: ' . (BOX_WIDTH-30) . 'px"') . '&nbsp;' . tep_hide_session_id() . tep_template_image_submit('button_quick_find.gif', BOX_HEADING_SEARCH) . '<br>' . BOX_SEARCH_TEXT . '<br><a href="' . tep_href_link(FILENAME_ADVANCED_SEARCH) . '"><b>' . BOX_SEARCH_ADVANCED_SEARCH . '</b></a>');
                               'text' => $iq_text . '<table border=0><tr><td>' . tep_draw_input_field('keywords', '', 'size="10" maxlength="30" style="width: ' . (BOX_WIDTH-30) . 'px"') . '</td><td>' . tep_hide_session_id() . tep_template_image_submit('button_quick_find.gif', BOX_HEADING_SEARCH) . '</td></tr></table>
' . BOX_SEARCH_TEXT . '
<a href="' . tep_href_link(FILENAME_ADVANCED_SEARCH) . '">' . BOX_SEARCH_ADVANCED_SEARCH . '</a>');
// IQ 20040610-3-hhaller w013 end

  new infoBox($info_box_contents);
$info_box_contents = array();
  $info_box_contents[] = array('align' => 'left',
                                'text'  => tep_draw_separator('pixel_trans.gif', '100%', '1')
                              );
  new infoboxFooter($info_box_contents, true, true);
?>
            </td>
          </tr>
<!-- search_eof //-->
