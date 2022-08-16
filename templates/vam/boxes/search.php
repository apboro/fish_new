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
<div class="box">
<b class="top"><b class="b1"></b><b class="b2"></b><b class="b3"></b><b class="b4"></b><b class="b5"></b></b>
<div class="boxHeader">
<h5><?php echo BOX_HEADING_SEARCH; ?></h5>
</div>
<div class="boxContent">
<p>
<?php

// IQ 20040610-3-hhaller w013 QuickSearch searches in description, too
	if (QUICKSEARCH_IN_DESCRIPTION == 'true') {
		$iq_text = '<input type="hidden" name="search_in_description" value="1">';
	} else {
		$iq_text = '';
	}
  echo tep_draw_form('quick_find', tep_href_link(FILENAME_ADVANCED_SEARCH_RESULT, '', 'NONSSL', false), 'get');
  echo $iq_text . '<table border=0><tr><td>' . tep_draw_input_field('keywords', '', 'size="10" maxlength="30" style="width: ' . (BOX_WIDTH-30) . 'px"') . '</td><td>' . tep_hide_session_id() . tep_template_image_submit('button_quick_find.gif', BOX_HEADING_SEARCH) . '</td></tr></table>
' . BOX_SEARCH_TEXT . '
<a href="' . tep_href_link(FILENAME_ADVANCED_SEARCH) . '">' . BOX_SEARCH_ADVANCED_SEARCH . '</a>';
// IQ 20040610-3-hhaller w013 end

?>
</form>

</p>
</div>
<b class="bottom"><b class="b5b"></b><b class="b4b"></b><b class="b3b"></b><b class="b2b"></b><b class="b1b"></b></b>
</div>
<!-- search_eof //-->