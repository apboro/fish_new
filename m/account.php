<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2013 osCommerce

  Released under the GNU General Public License
*/

  require('includes/application_top.php');

  if (!tep_session_is_registered('customer_id')) {
    $navigation->set_snapshot();
    tep_redirect(tep_href_link(FILENAME_LOGIN, '', 'SSL'));
  }

  require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_ACCOUNT);

  $breadcrumb->add(NAVBAR_TITLE, tep_href_link(FILENAME_ACCOUNT, '', 'SSL'));

  require(DIR_WS_INCLUDES . 'template_top.php');
?>

<div class="contentContainer" id="my_account">
	<h1><?php echo HEADING_TITLE; ?></h1>
    <?php
  		if ($messageStack->size('account') > 0) {
    		echo $messageStack->output('account');
  		}
	?>
    <div class="review_box">
    	<div class="content_box">
        	<span class="title"><?php echo MY_ACCOUNT_TITLE; ?></span>
            <div class="accounts_link">
            	<ul class="accountLinkList">
      				<li><span class="ui-icon ui-icon-person accountLinkListEntry"></span><?php echo '<a href="' . tep_href_link(FILENAME_ACCOUNT_EDIT, '', 'SSL') . '">'
					 	. MY_ACCOUNT_INFORMATION . '</a>'; ?></li>
      				<li><span class="ui-icon ui-icon-home accountLinkListEntry"></span><?php echo '<a href="' . tep_href_link(FILENAME_ADDRESS_BOOK, '', 'SSL') . '">'
					 	. MY_ACCOUNT_ADDRESS_BOOK . '</a>'; ?></li>
      				<li><span class="ui-icon ui-icon-key accountLinkListEntry"></span><?php echo '<a href="' . tep_href_link(FILENAME_ACCOUNT_PASSWORD, '', 'SSL') . '">'
					 	. MY_ACCOUNT_PASSWORD . '</a>'; ?></li>
    			</ul>
            </div>
        </div>
        <div class="content_box">
        	<span class="title"><?php echo MY_ORDERS_TITLE; ?></span>
            <div class="accounts_link">
            	<ul class="accountLinkList">
      				<li><span class="ui-icon ui-icon-cart accountLinkListEntry"></span><?php echo '<a href="' . tep_href_link(FILENAME_ACCOUNT_HISTORY, '', 'SSL') . '">'
						 . MY_ORDERS_VIEW . '</a>'; ?></li>
    			</ul>
            </div>
        </div>
        <div class="content_box">
        	<span class="title"><?php echo EMAIL_NOTIFICATIONS_TITLE; ?></span>
            <div class="accounts_link">
            	<ul class="accountLinkList">
      				<li><span class="ui-icon ui-icon-mail-closed accountLinkListEntry"></span><?php echo '<a href="' . tep_href_link(FILENAME_ACCOUNT_NEWSLETTERS, '', 'SSL')
						 . '">' . EMAIL_NOTIFICATIONS_NEWSLETTERS . '</a>'; ?></li>
      				<li><span class="ui-icon ui-icon-heart accountLinkListEntry"></span><?php echo '<a href="' . tep_href_link(FILENAME_ACCOUNT_NOTIFICATIONS, '', 'SSL') . '">'
						 . EMAIL_NOTIFICATIONS_PRODUCTS . '</a>'; ?></li>
    			</ul>
            </div>
        </div>
    </div>
</div>

<?php
  require(DIR_WS_INCLUDES . 'template_bottom.php');
  require(DIR_WS_INCLUDES . 'application_bottom.php');
?>
