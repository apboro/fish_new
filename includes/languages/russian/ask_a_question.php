<?php
/*
  $Id: ask_a_question.php,v 2.3.4 2013/06/25 18:20:39 hpdl Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
  
*/

define('NAVBAR_TITLE', 'Ask a Question');

define('HEADING_TITLE', 'Ask a question about the:');

define('FORM_TITLE_CUSTOMER_DETAILS', 'Your Info');
define('FORM_TITLE_FRIEND_MESSAGE', 'Your Question');

define('FORM_FIELD_CUSTOMER_NAME', 'Your Name:');
define('FORM_FIELD_CUSTOMER_EMAIL', 'Your E-Mail Address:');


define('TEXT_EMAIL_SUCCESSFUL_SENT', 'Your question about <strong>%s</strong> has been successfully sent...');

define('TEXT_EMAIL_SUBJECT', 'A question from %s');
define('TEXT_EMAIL_INTRO', '%s' . "\n\n" . 'A customer, %s, has a question about: %s - %s.');
define('TEXT_EMAIL_LINK', 'Here is the product link:' . "\n\n" . '%s');
define('TEXT_EMAIL_SIGNATURE', 'Regards,' . "\n\n" . '%s');

define('ERROR_FROM_NAME', 'Error: Your name must not be empty.');
define('ERROR_FROM_ADDRESS', 'Error: Your e-mail address must be a valid e-mail address.');
define('ERROR_MESSAGE', 'Error: You failed to enter a question!');
define('ERROR_HAS_LINK', 'Error: A link to the product you have a question about is already being included in the message. No other links are allowed.');
define('ERROR_INVALID_ACCESS', 'Error: Invalid file access!');
?>