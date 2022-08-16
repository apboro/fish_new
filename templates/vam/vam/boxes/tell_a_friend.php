<?php
/*
  $Id: tell_a_friend.php,v 1.1.1.1 2003/09/18 19:05:50 wilt Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2002 osCommerce

  Released under the GNU General Public License
*/

  if (isset($_GET['products_id'])) {
    if (basename($PHP_SELF) != FILENAME_TELL_A_FRIEND)
   {
?>

<!-- tell_a_friend //-->
<div class="box">
<b class="top"><b class="b1"></b><b class="b2"></b><b class="b3"></b><b class="b4"></b><b class="b5"></b></b>
<div class="boxHeader">
<h5><?php echo BOX_HEADING_TELL_A_FRIEND; ?></h5>
</div>
<div class="boxContent">
<p>
<?php
  if (isset($_GET['products_id'])) {
    if (basename($PHP_SELF) != FILENAME_TELL_A_FRIEND)
   {
    
  $hide = tep_draw_hidden_field('products_id', $_GET['products_id']);
  $hide .= tep_hide_session_id();

echo '<form name="tell_a_friend" method="get" action="' . tep_href_link(FILENAME_TELL_A_FRIEND, '', 'NONSSL', false) . '">';
echo tep_draw_input_field('to_email_address', '', 'size="10"') . '&nbsp;' . tep_template_image_submit('button_tell_a_friend.gif', BOX_HEADING_TELL_A_FRIEND) . $hide . '<br />' . BOX_TELL_A_FRIEND_TEXT . '</form>';


}}
?>
</p>
</div>
<b class="bottom"><b class="b5b"></b><b class="b4b"></b><b class="b3b"></b><b class="b2b"></b><b class="b1b"></b></b>
</div>
<?php
}}
?>
<!-- tell_a_friend_eof //-->