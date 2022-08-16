<?php
/*
  $Id: english.php,v 1.1.1.1 2003/09/18 19:04:27 wilt Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/

// look in your $PATH_LOCALE/locale directory for available locales
// or type locale -a on the server.
// Examples:
// on RedHat try 'en_US'
// on FreeBSD try 'en_US.ISO_8859-1'
// on Windows try 'en', or 'English'
@setlocale(LC_TIME, 'en_US.UTF-8');

define('DATE_FORMAT_SHORT', '%m/%d/%Y');  // this is used for strftime()
//define('DATE_FORMAT_LONG', '%A %d %B, %Y'); // this is used for strftime()
define('DATE_FORMAT_LONG', '%d %B %Y'); // this is used for strftime()
define('DATE_FORMAT', 'm/d/Y'); // this is used for date()
define('DATE_TIME_FORMAT', DATE_FORMAT_SHORT . ' %H:%M:%S');

////
// Return date in raw format
// $date should be in format mm/dd/yyyy
// raw date is in format YYYYMMDD, or DDMMYYYY
function tep_date_raw($date, $reverse = false) {
  if ($reverse) {
    return substr($date, 3, 2) . substr($date, 0, 2) . substr($date, 6, 4);
  } else {
    return substr($date, 6, 4) . substr($date, 0, 2) . substr($date, 3, 2);
  }
}

// if USE_DEFAULT_LANGUAGE_CURRENCY is true, use the following currency, instead of the applications default currency (used when changing language)
define('LANGUAGE_CURRENCY', 'USD');

// Global entries for the <html> tag
define('HTML_PARAMS','dir="LTR" lang="en"');

// charset for web pages and emails
define('CHARSET', 'utf-8');

// page title
define('TITLE', 'Your Store Name');

// header text in includes/header.php
define('HEADER_TITLE_CREATE_ACCOUNT', 'Create an Account');
define('HEADER_TITLE_MY_ACCOUNT', 'My Account');
define('HEADER_TITLE_CART_CONTENTS', 'Cart Contents');
define('HEADER_TITLE_CHECKOUT', 'Checkout');
define('HEADER_TITLE_TOP', 'Top');
define('HEADER_TITLE_CATALOG', 'Catalog');
define('HEADER_TITLE_LOGOFF', 'Log Off');
define('HEADER_TITLE_LOGIN', 'Log In');

// footer text in includes/footer.php
define('FOOTER_TEXT_REQUESTS_SINCE', 'requests since');

// text for gender
define('MALE', 'Male');
define('FEMALE', 'Female');
define('MALE_ADDRESS', 'Mr.');
define('FEMALE_ADDRESS', 'Ms.');

// text for date of birth example
define('DOB_FORMAT_STRING', 'mm/dd/yyyy');


// quick_find box text in includes/boxes/quick_find.php
define('BOX_SEARCH_TEXT', 'Use keywords to find the product you are looking for.');
define('BOX_SEARCH_ADVANCED_SEARCH', 'Advanced Search');

// reviews box text in includes/boxes/reviews.php
define('BOX_REVIEWS_WRITE_REVIEW', 'Write a review on this product!');
define('BOX_REVIEWS_NO_REVIEWS', 'There are currently no product reviews');
define('BOX_REVIEWS_TEXT_OF_5_STARS', '%s of 5 Stars!');

// shopping_cart box text in includes/boxes/shopping_cart.php
define('BOX_SHOPPING_CART_EMPTY', '0 items');

// notifications box text in includes/boxes/products_notifications.php
define('BOX_NOTIFICATIONS_NOTIFY', 'Notify me of updates to <b>%s</b>');
define('BOX_NOTIFICATIONS_NOTIFY_REMOVE', 'Do not notify me of updates to <b>%s</b>');

// manufacturer box text
define('BOX_MANUFACTURER_INFO_HOMEPAGE', '%s Homepage');
define('BOX_MANUFACTURER_INFO_OTHER_PRODUCTS', 'Other products');

// information box text in includes/boxes/information.php
define('BOX_INFORMATION_PRIVACY', 'Privacy Notice');
define('BOX_INFORMATION_CONDITIONS', 'Conditions of Use');
define('BOX_INFORMATION_SHIPPING', 'Shipping & Returns');
define('BOX_INFORMATION_CONTACT', 'Contact Us');

define('BOX_INFORMATION_PRICE_XLS', 'Price-list (Excel)');
define('BOX_INFORMATION_PRICE_HTML', 'Price-list (HTML)');


// tell a friend box text in includes/boxes/tell_a_friend.php
define('BOX_TELL_A_FRIEND_TEXT', 'Tell someone you know about this product.');

//BEGIN allprods modification
define('BOX_INFORMATION_ALLPRODS', 'View All Items');
//END allprods modification

// VJ Links Manager v1.00 begin
define('BOX_INFORMATION_LINKS', 'Links');
// VJ Links Manager v1.00 end

// checkout procedure text
define('CHECKOUT_BAR_DELIVERY', 'Delivery Information');
define('CHECKOUT_BAR_PAYMENT', 'Payment Information');
define('CHECKOUT_BAR_CONFIRMATION', 'Confirmation');
define('CHECKOUT_BAR_FINISHED', 'Finished!');

// pull down default text
define('PULL_DOWN_DEFAULT', 'Please Select');
define('TYPE_BELOW', 'Type Below');

// javascript messages
define('JS_ERROR', 'Errors have occured during the process of your form.\n\nPlease make the following corrections:\n\n');

define('JS_REVIEW_TEXT', '* The \'Review Text\' must have at least ' . REVIEW_TEXT_MIN_LENGTH . ' characters.\n');

define('JS_FIRST_NAME', '* The \'First Name\' must contain a minimum of ' . ENTRY_FIRST_NAME_MIN_LENGTH . ' characters.\n');
define('JS_LAST_NAME', '* The \'Last Name\' must contain a minimum of ' . ENTRY_LAST_NAME_MIN_LENGTH . ' characters.\n');


define('JS_REVIEW_RATING', '* You must rate the product for your review.\n');

define('JS_ERROR_NO_PAYMENT_MODULE_SELECTED', '* Please select a payment method for your order.\n');

define('JS_ERROR_SUBMITTED', 'This form has already been submitted. Please press Ok and wait for this process to be completed.');

define('ERROR_NO_PAYMENT_MODULE_SELECTED', 'Please select a payment method for your order.');

define('CATEGORY_COMPANY', 'Company Details');
define('CATEGORY_PERSONAL', 'Your Personal Details');
define('CATEGORY_ADDRESS', 'Your Address');
define('CATEGORY_CONTACT', 'Your Contact Information');
define('CATEGORY_OPTIONS', 'Options');
define('CATEGORY_PASSWORD', 'Your Password');

define('ENTRY_COMPANY', 'Company Name:');
define('ENTRY_COMPANY_ERROR', '');
define('ENTRY_COMPANY_TEXT', '');
define('ENTRY_GENDER', 'Gender:');
define('ENTRY_GENDER_ERROR', 'Please select your Gender.');
define('ENTRY_GENDER_TEXT', '*');
define('ENTRY_FIRST_NAME', 'First Name:');
define('ENTRY_FIRST_NAME_ERROR', 'Your First Name must contain a minimum of ' . ENTRY_FIRST_NAME_MIN_LENGTH . ' characters.');
define('ENTRY_FIRST_NAME_TEXT', '*');
define('ENTRY_LAST_NAME', 'Last Name:');
define('ENTRY_LAST_NAME_ERROR', 'Your Last Name must contain a minimum of ' . ENTRY_LAST_NAME_MIN_LENGTH . ' characters.');
define('ENTRY_LAST_NAME_TEXT', '*');
define('ENTRY_DATE_OF_BIRTH', 'Date of Birth:');
define('ENTRY_DATE_OF_BIRTH_ERROR', 'Your Date of Birth must be in this format: MM/DD/YYYY (eg 05/21/1970)');
define('ENTRY_DATE_OF_BIRTH_TEXT', '* (eg. 05/21/1970)');
define('ENTRY_EMAIL_ADDRESS', 'E-Mail Address:');
define('ENTRY_EMAIL_ADDRESS_ERROR', 'Your E-Mail Address must contain a minimum of ' . ENTRY_EMAIL_ADDRESS_MIN_LENGTH . ' characters.');
define('ENTRY_EMAIL_ADDRESS_CHECK_ERROR', 'Your E-Mail Address does not appear to be valid - please make any necessary corrections.');
define('ENTRY_EMAIL_ADDRESS_ERROR_EXISTS', 'Your E-Mail Address already exists in our records - please log in with the e-mail address or create an account with a different address.');
define('ENTRY_EMAIL_ADDRESS_TEXT', '*');
define('ENTRY_STREET_ADDRESS', 'Street Address:');
define('ENTRY_STREET_ADDRESS_ERROR', 'Your Street Address must contain a minimum of ' . ENTRY_STREET_ADDRESS_MIN_LENGTH . ' characters.');
define('ENTRY_STREET_ADDRESS_TEXT', '*');
define('ENTRY_SUBURB', 'Suburb:');
define('ENTRY_SUBURB_ERROR', '');
define('ENTRY_SUBURB_TEXT', '');
define('ENTRY_POST_CODE', 'Post Code:');
define('ENTRY_POST_CODE_ERROR', 'Your Post Code must contain a minimum of ' . ENTRY_POSTCODE_MIN_LENGTH . ' characters.');
define('ENTRY_POST_CODE_TEXT', '*');
define('ENTRY_CITY', 'City:');
define('ENTRY_CITY_ERROR', 'Your City must contain a minimum of ' . ENTRY_CITY_MIN_LENGTH . ' characters.');
define('ENTRY_CITY_TEXT', '*');
define('ENTRY_STATE', 'State/Province:');
define('ENTRY_STATE_ERROR', 'Your State must contain a minimum of ' . ENTRY_STATE_MIN_LENGTH . ' characters.');
define('ENTRY_STATE_ERROR_SELECT', 'Please select a state from the States pull down menu.');
define('ENTRY_STATE_TEXT', '*');
define('ENTRY_COUNTRY', 'Country:');
define('ENTRY_COUNTRY_ERROR', 'You must select a country from the Countries pull down menu.');
define('ENTRY_COUNTRY_TEXT', '*');
define('ENTRY_TELEPHONE_NUMBER', 'Telephone Number:');
define('ENTRY_TELEPHONE_NUMBER_ERROR', 'Your Telephone Number must contain a minimum of ' . ENTRY_TELEPHONE_MIN_LENGTH . ' characters.');
define('ENTRY_TELEPHONE_NUMBER_TEXT', '*');
define('ENTRY_FAX_NUMBER', 'Fax Number:');
define('ENTRY_FAX_NUMBER_ERROR', '');
define('ENTRY_FAX_NUMBER_TEXT', '');
define('ENTRY_NEWSLETTER', 'Newsletter:');
define('ENTRY_NEWSLETTER_TEXT', '');
define('ENTRY_NEWSLETTER_YES', 'Subscribed');
define('ENTRY_NEWSLETTER_NO', 'Unsubscribed');
define('ENTRY_NEWSLETTER_ERROR', '');
define('ENTRY_PASSWORD', 'Password:');
define('ENTRY_PASSWORD_ERROR', 'Your Password must contain a minimum of ' . ENTRY_PASSWORD_MIN_LENGTH . ' characters.');
define('ENTRY_PASSWORD_ERROR_NOT_MATCHING', 'The Password Confirmation must match your Password.');
define('ENTRY_PASSWORD_TEXT', '*');
define('ENTRY_PASSWORD_CONFIRMATION', 'Password Confirmation:');
define('ENTRY_PASSWORD_CONFIRMATION_TEXT', '*');
define('ENTRY_PASSWORD_CURRENT', 'Current Password:');
define('ENTRY_PASSWORD_CURRENT_TEXT', '*');
define('ENTRY_PASSWORD_CURRENT_ERROR', 'Your Password must contain a minimum of ' . ENTRY_PASSWORD_MIN_LENGTH . ' characters.');
define('ENTRY_PASSWORD_NEW', 'New Password:');
define('ENTRY_PASSWORD_NEW_TEXT', '*');
define('ENTRY_PASSWORD_NEW_ERROR', 'Your new Password must contain a minimum of ' . ENTRY_PASSWORD_MIN_LENGTH . ' characters.');
define('ENTRY_PASSWORD_NEW_ERROR_NOT_MATCHING', 'The Password Confirmation must match your new Password.');
define('PASSWORD_HIDDEN', '--HIDDEN--');

define('FORM_REQUIRED_INFORMATION', '* Required information');

// constants for use in tep_prev_next_display function
define('TEXT_RESULT_PAGE', 'Result Pages:');
define('TEXT_DISPLAY_NUMBER_OF_PRODUCTS', 'Displaying <b>%d</b> to <b>%d</b> (of <b>%d</b> products)');
define('TEXT_DISPLAY_NUMBER_OF_ORDERS', 'Displaying <b>%d</b> to <b>%d</b> (of <b>%d</b> orders)');
define('TEXT_DISPLAY_NUMBER_OF_REVIEWS', 'Displaying <b>%d</b> to <b>%d</b> (of <b>%d</b> reviews)');
define('TEXT_DISPLAY_NUMBER_OF_PRODUCTS_NEW', 'Displaying <b>%d</b> to <b>%d</b> (of <b>%d</b> new products)');
define('TEXT_DISPLAY_NUMBER_OF_SPECIALS', 'Displaying <b>%d</b> to <b>%d</b> (of <b>%d</b> specials)');
define('TEXT_DISPLAY_NUMBER_OF_FEATURED', 'Displaying <b>%d</b> to <b>%d</b> (of <b>%d</b> featured products)');

define('PREVNEXT_TITLE_FIRST_PAGE', 'First Page');
define('PREVNEXT_TITLE_PREVIOUS_PAGE', 'Previous Page');
define('PREVNEXT_TITLE_NEXT_PAGE', 'Next Page');
define('PREVNEXT_TITLE_LAST_PAGE', 'Last Page');
define('PREVNEXT_TITLE_PAGE_NO', 'Page %d');
define('PREVNEXT_TITLE_PREV_SET_OF_NO_PAGE', 'Previous Set of %d Pages');
define('PREVNEXT_TITLE_NEXT_SET_OF_NO_PAGE', 'Next Set of %d Pages');
define('PREVNEXT_BUTTON_FIRST', '&lt;&lt;FIRST');
define('PREVNEXT_BUTTON_PREV', '[&lt;&lt;&nbsp;Prev]');
define('PREVNEXT_BUTTON_NEXT', '[Next&nbsp;&gt;&gt;]');
define('PREVNEXT_BUTTON_LAST', 'LAST&gt;&gt;');

define('IMAGE_BUTTON_ADD_ADDRESS', 'Add Address');
define('IMAGE_BUTTON_ADDRESS_BOOK', 'Address Book');
define('IMAGE_BUTTON_BACK', 'Back');
define('IMAGE_BUTTON_BUY_NOW', 'Buy Now');
define('IMAGE_BUTTON_CHANGE_ADDRESS', 'Change Address');
define('IMAGE_BUTTON_CHECKOUT', 'Checkout');
define('IMAGE_BUTTON_CONFIRM_ORDER', 'Confirm Order');
define('IMAGE_BUTTON_CONTINUE', 'Continue');
define('IMAGE_BUTTON_CONTINUE_SHOPPING', 'Continue Shopping');
define('IMAGE_BUTTON_DELETE', 'Delete');
define('IMAGE_BUTTON_EDIT_ACCOUNT', 'Edit Account');
define('IMAGE_BUTTON_HISTORY', 'Order History');
define('IMAGE_BUTTON_LOGIN', 'Sign In');
define('IMAGE_BUTTON_IN_CART', 'Add to Cart');
define('IMAGE_BUTTON_NOTIFICATIONS', 'Notifications');
define('IMAGE_BUTTON_QUICK_FIND', 'Quick Find');
define('IMAGE_BUTTON_REMOVE_NOTIFICATIONS', 'Remove Notifications');
define('IMAGE_BUTTON_REVIEWS', 'Reviews');
define('IMAGE_BUTTON_SEARCH', 'Search');
define('IMAGE_BUTTON_SHIPPING_OPTIONS', 'Shipping Options');
define('IMAGE_BUTTON_TELL_A_FRIEND', 'Tell a Friend');
define('IMAGE_BUTTON_UPDATE', 'Update');
define('IMAGE_BUTTON_UPDATE_CART', 'Update Cart');
define('IMAGE_BUTTON_WRITE_REVIEW', 'Write Review');
define('IMAGE_REDEEM_VOUCHER', 'Redeem');

define('SMALL_IMAGE_BUTTON_DELETE', 'Delete');
define('SMALL_IMAGE_BUTTON_EDIT', 'Edit');
define('SMALL_IMAGE_BUTTON_VIEW', 'View');

define('ICON_ARROW_RIGHT', 'more');
define('ICON_CART', 'In Cart');
define('ICON_ERROR', 'Error');
define('ICON_SUCCESS', 'Success');
define('ICON_WARNING', 'Warning');

define('TEXT_GREETING_PERSONAL', 'Welcome back <span class="greetUser">%s!</span> Would you like to see which <a href="%s"><u>new products</u></a> are available to purchase?');
define('TEXT_CUSTOMER_GREETING_HEADER', 'Our Customer Greeting');
define('TEXT_GREETING_PERSONAL_RELOGON', '<small>If you are not %s, please <a href="%s"><u>log yourself in</u></a> with your account information.</small>');
define('TEXT_GREETING_GUEST', 'Welcome <span class="greetUser">Guest!</span> Would you like to <a href="%s"><u>log yourself in</u></a>? Or would you prefer to <a href="%s"><u>create an account</u></a>?');

define('TEXT_SORT_PRODUCTS', 'Sort products ');
define('TEXT_DESCENDINGLY', 'descendingly');
define('TEXT_ASCENDINGLY', 'ascendingly');
define('TEXT_BY', ' by ');

define('TEXT_REVIEW_BY', 'by %s');
define('TEXT_REVIEW_WORD_COUNT', '%s words');
define('TEXT_REVIEW_RATING', 'Rating: %s [%s]');
define('TEXT_REVIEW_DATE_ADDED', 'Date Added: %s');
define('TEXT_NO_REVIEWS', 'There are currently no product reviews.');

define('TEXT_NO_NEW_PRODUCTS', 'There are currently no products.');

define('TEXT_NO_PRODUCTS', 'There are currently no products in this range.');

define('TEXT_UNKNOWN_TAX_RATE', 'Unknown tax rate');

define('TEXT_REQUIRED', '<span class="errorText">Required</span>');

// Down For Maintenance
define('TEXT_BEFORE_DOWN_FOR_MAINTENANCE', 'NOTICE: This website will be down for maintenance on: ');
define('TEXT_ADMIN_DOWN_FOR_MAINTENANCE', 'NOTICE: the website is currently Down For Maintenance to the public');

define('ERROR_TEP_MAIL', '<font face="Verdana, Arial" size="2" color="#ff0000"><b><small>TEP ERROR:</small> Cannot send the email through the specified SMTP server. Please check your php.ini setting and correct the SMTP server if necessary.</b></font>');
define('WARNING_INSTALL_DIRECTORY_EXISTS', 'Warning: Installation directory exists at: ' . dirname($_SERVER['SCRIPT_FILENAME']) . '/install. Please remove this directory for security reasons.');
define('WARNING_CONFIG_FILE_WRITEABLE', 'Warning: I am able to write to the configuration file: ' . dirname($_SERVER['SCRIPT_FILENAME']) . '/includes/configure.php. This is a potential security risk - please set the right user permissions on this file.');
define('WARNING_SESSION_DIRECTORY_NON_EXISTENT', 'Warning: The sessions directory does not exist: ' . tep_session_save_path() . '. Sessions will not work until this directory is created.');
define('WARNING_SESSION_DIRECTORY_NOT_WRITEABLE', 'Warning: I am not able to write to the sessions directory: ' . tep_session_save_path() . '. Sessions will not work until the right user permissions are set.');
define('WARNING_SESSION_AUTO_START', 'Warning: session.auto_start is enabled - please disable this php feature in php.ini and restart the web server.');
define('WARNING_DOWNLOAD_DIRECTORY_NON_EXISTENT', 'Warning: The downloadable products directory does not exist: ' . DIR_FS_DOWNLOAD . '. Downloadable products will not work until this directory is valid.');


define('TEXT_CCVAL_ERROR_INVALID_DATE', 'The expiry date entered for the credit card is invalid. Please check the date and try again.');
define('TEXT_CCVAL_ERROR_INVALID_NUMBER', 'The credit card number entered is invalid. Please check the number and try again.');
define('TEXT_CCVAL_ERROR_UNKNOWN_CARD', 'The first four digits of the number entered are: %s. If that number is correct, we do not accept that type of credit card. If it is wrong, please try again.');

/*
  The following copyright announcement can only be
  appropriately modified or removed if the layout of
  the site theme has been modified to distinguish
  itself from the default Chainreaction-copyrighted
  theme.

  For more information please read the following
  Frequently Asked Questions entry on the osCommerce
  support site:

  http://www.oscommerce.com/community.php/faq,26/q,50

  Please leave this comment intact together with the
  following copyright announcement.
*/
define('FOOTER_TEXT_BODY', '<center>
<span class="smallText">
E-Commerce Engine Copyright В© 2003-2007 <a href="http://www.oscommerce.com" target="_blank">osCommerce</a><br>
osCommerce provides no warranty and is redistributable under the <a href="http://www.gnu.org/licenses/gpl.html" target="_blank">GNU General Public License</a><br>
<a href="http://oscommerce.com" target="_blank">Powered by osCommerce 2.2 MS2 VaM Edition Ver. ' . implode('', file(DIR_FS_CATALOG .'VERSION.txt')) . '</a><br>
<a href="rss2_info.php"><img src="images/rss.png" width="36" height="14" alt="RSS channels" border="0"></a><br>
</span>
</center>');
require(DIR_WS_LANGUAGES . 'add_ccgvdc_english.php');
/////////////////////////////////////////////////////////////////////
// HEADER.PHP
// Header Links
define('HEADER_LINKS_DEFAULT','Home');
define('HEADER_LINKS_WHATS_NEW','What\'s new?');
define('HEADER_LINKS_SPECIALS','Specials');
define('HEADER_LINKS_REVIEWS','Reviews');
define('HEADER_LINKS_LOGIN','Login');
define('HEADER_LINKS_LOGOFF','Log Off');
define('HEADER_LINKS_PRODUCTS_ALL','Catalog');
define('HEADER_LINKS_ACCOUNT_INFO','Account Info');
define('HEADER_LINKS_CHECKOUT','Checkout');
define('HEADER_LINKS_CART','Shopping Cart');
define('HEADER_LINKS_DVD', 'Catalog');

/////////////////////////////////////////////////////////////////////

// BOF: Lango added for print order mod
define('IMAGE_BUTTON_PRINT_ORDER', 'Order printable');
// EOF: Lango added for print order mod

// WebMakers.com Added: Attributes Sorter
require(DIR_WS_LANGUAGES . $language . '/' . 'attributes_sorter.php');

define('BOX_LOGINBOX_HEADING', 'Your account');
define('BOX_LOGINBOX_EMAIL', 'E-Mail:');
define('BOX_LOGINBOX_PASSWORD', 'Password:');
define('IMAGE_BUTTON_LOGIN', 'Sign in');

define('BOX_HEADING_LOGIN_BOX_MY_ACCOUNT','My account');
define('LOGIN_BOX_ACCOUNT_EDIT','Edit account');
define('LOGIN_BOX_ACCOUNT_HISTORY','Order history');
define('LOGIN_BOX_ADDRESS_BOOK','Address book');
define('LOGIN_BOX_PRODUCT_NOTIFICATIONS','Notifications');
define('LOGIN_BOX_MY_ACCOUNT','My account');
define('LOGIN_BOX_LOGOFF','Log off');


define('DISCOUNT_HEADING', 'Discounts');

define('HELP', '<a href="http://www.icq.com/whitepages/cmd.php?uin=' . STORE_OWNER_ICQ_NUMBER . '&action=message" target="_blank"><img src="http://status.icq.com/online.gif?icq=' . STORE_OWNER_ICQ_NUMBER . '&img=26" title="ICQ Status" align="absmiddle" border="0">' . STORE_OWNER_ICQ_NUMBER . '</a>
<br>
');

define('ICQ', 'ICQ:<br>');
define('TEXT_MORE_INFO', 'More info...');

// Article Manager
define('BOX_ALL_ARTICLES', 'All Articles');
define('BOX_NEW_ARTICLES', 'New Articles');
define('TEXT_DISPLAY_NUMBER_OF_ARTICLES', 'Displaying <b>%d</b> to <b>%d</b> (of <b>%d</b> articles)');
define('TEXT_DISPLAY_NUMBER_OF_ARTICLES_NEW', 'Displaying <b>%d</b> to <b>%d</b> (of <b>%d</b> new articles)');
define('TABLE_HEADING_AUTHOR', 'Author');
define('TABLE_HEADING_ABSTRACT', 'Abstract');
define('NAVBAR_TITLE_DEFAULT', 'Articles');

define('TABLE_HEADING_INFO','Short description');

//TotalB2B start
define('PRICES_LOGGED_IN_TEXT','Must be logged in for prices!');
//TotalB2B end

define('PRODUCTS_ORDER_QTY_TEXT','Add Qty: ');
define('PRODUCTS_ORDER_QTY_MIN_TEXT','<br>' . ' Min Qty: ');
define('PRODUCTS_ORDER_QTY_MIN_TEXT_INFO','Order Minumum is: ');
define('PRODUCTS_ORDER_QTY_MIN_TEXT_CART','Order Minimum is: ');
define('PRODUCTS_ORDER_QTY_MIN_TEXT_CART_SHORT',' Min Qty: ');
define('PRODUCTS_ORDER_QTY_UNIT_TEXT',' in Units of: ');
define('PRODUCTS_ORDER_QTY_UNIT_TEXT_INFO','Order in Units of: ');
define('PRODUCTS_ORDER_QTY_UNIT_TEXT_CART','Order in Units of: ');
define('PRODUCTS_ORDER_QTY_UNIT_TEXT_CART_SHORT',' Units: ');
define('ERROR_PRODUCTS_QUANTITY_ORDER_MIN_TEXT','');
define('ERROR_PRODUCTS_QUANTITY_INVALID','Invalid Qty: ');
define('ERROR_PRODUCTS_QUANTITY_ORDER_UNITS_TEXT','');
define('ERROR_PRODUCTS_UNITS_INVALID','Invalid Units: ');

// Poll Box Text
define('_RESULTS', 'Results');define('_VOTE', 'Vote');define('_COMMENTS','Comments:');
define('_VOTES', 'Votes:');define('_NOPOLLS','No eligible polls');define('_NOPOLLSCONTENT','There are no polls that you are eligible for, however you can still view the results of other polls<br><br><a href="pollbooth.php">['._POLLS.']');

define('IMAGE_BUTTON_PREVIOUS', 'Previous item');
define('IMAGE_BUTTON_NEXT', 'Next item');
define('IMAGE_BUTTON_RETURN_TO_PRODUCT_LIST', 'Back to product list');
define('PREV_NEXT_PRODUCT', 'Product ');
define('PREV_NEXT_PRODUCT1', '/');
define('PREV_NEXT_CAT', ' of category ');
define('PREV_NEXT_MB', ' of manafacturer ');

define('BOX_TEXT_DOWNLOAD', 'Your downloads: ');
define('BOX_DOWNLOAD_DOWNLOAD', 'Download files');
define('BOX_TEXT_DOWNLOAD_NOW', 'Download');

// English names of boxes

define('BOX_HEADING_CATEGORIES', 'Categories');
define('BOX_HEADING_INFORMATION', 'Information');
define('BOX_HEADING_TEMPLATE_SELECT', 'Theme select');
define('BOX_HEADING_MANUFACTURERS', 'Manufacturers');
define('BOX_HEADING_SPECIALS', 'Specials');
define('BOX_HEADING_NEWSDESK_LATEST', 'Latest news');
define('BOX_HEADING_SEARCH', 'Quick find');
define('BOX_HEADING_WHATS_NEW', 'Latest products');
define('BOX_HEADING_LANGUAGES', 'Languages');
define('BOX_HEADING_NEWSBOX', 'News');
define('BOX_HEADING_FEATURED', 'Featured products');
define('BOX_HEADING_SHOP_BY_PRICE', 'Shop by price');
define('BOX_HEADING_NEWSDESK_CATEGORIES', 'News categories');
define('BOX_HEADING_ARTICLES', 'Articles');
define('BOX_HEADING_AUTHORS', 'Authors');
define('BOX_HEADING_LINKS', 'Links');
define('BOX_HEADING_SHOPPING_CART', 'Shopping cart');
define('BOX_HEADING_DOWNLOAD', 'Downloads');
define('BOX_HEADING_LOGIN', 'Your account');
define('HELP_HEADING', 'Help');
define('BOX_HEADING_WISHLIST', 'Wishlist');
define('BOX_HEADING_REVIEWS', 'Reviews');
define('BOX_HEADING_CUSTOMER_ORDERS', 'Orders history');
define('BOX_HEADING_AFFILIATE', 'Affiliate program');
define('BOX_HEADING_MANUFACTURER_INFO', 'Manufactures info');
define('BOX_HEADING_BESTSELLERS', 'Best sellers');
define('BOX_HEADING_TELL_A_FRIEND', 'Tell a friend');
define('BOX_HEADING_NOTIFICATIONS', 'Notifications');
define('BOX_HEADING_CURRENCIES', 'Currencies');
define('BOX_HEADING_FAQDESK_CATEGORIES', 'FAQ');
define('BOX_HEADING_FAQDESK_LATEST', 'FAQDesk Latest');
define('_POLLS', 'Polls');

// Shopping cart quotes
  define('SHIPPING_OPTIONS', 'Shipping Options:');
  if (strstr($PHP_SELF,'shopping_cart.php')) {
    define('SHIPPING_OPTIONS_LOGIN', 'Please <a href="' . tep_href_link(FILENAME_LOGIN, '', 'SSL') . '"><u>Log In</u></a>, to display your personal shipping costs.');
  } else {
    define('SHIPPING_OPTIONS_LOGIN', 'Please Log In, to display your personal shipping costs.');
  }
  define('SHIPPING_METHOD_TEXT','Shipping Methods:');
  define('SHIPPING_METHOD_RATES','Rates:');
  define('SHIPPING_METHOD_TO','Ship to: ');
  define('SHIPPING_METHOD_TO_NOLOGIN', 'Ship to: <a href="' . tep_href_link(FILENAME_LOGIN, '', 'SSL') . '"><u>Log In</u></a>');
  define('SHIPPING_METHOD_FREE_TEXT','Free Shipping');
  define('SHIPPING_METHOD_ALL_DOWNLOADS','- Downloads');
  define('SHIPPING_METHOD_RECALCULATE','Recalculate');
  define('SHIPPING_METHOD_ZIP_REQUIRED','true');
  define('SHIPPING_METHOD_ADDRESS','Address:');
  define('SHIPPING_METHOD_QTY','Items: ');
  define('SHIPPING_METHOD_WEIGHT','Weight: ');
  define('SHIPPING_METHOD_WEIGHT1',' lbs');

  define('LOW_STOCK_TEXT1','Low stock warning: ');
  define('LOW_STOCK_TEXT2','Model No.: ');
  define('LOW_STOCK_TEXT3','Quantity: ');
  define('LOW_STOCK_TEXT4','Product URL: ');
  define('LOW_STOCK_TEXT5','Current Low order limit is ');

// wishlist box text in includes/boxes/wishlist.php
  define('BOX_HEADING_CUSTOMER_WISHLIST', 'My Wishlist');
  define('TEXT_WISHLIST_COUNT', 'Currently %s items are on your Wish List.');

  define('BOX_TEXT_VIEW', 'Show');
  define('BOX_TEXT_HELP', 'Help');
  define('BOX_WISHLIST_EMPTY', '0 items');
  define('BOX_TEXT_NO_ITEMS', 'No products are in your Wishlist.');
  define('IMAGE_BUTTON_ADD_WISHLIST', 'Add to wishlist');
  
  define('TEXT_VERSION', 'Version: ');
  define('TOTAL_QUERIES', 'Total queries: ');
  define('TOTAL_TIME', 'Execution time: ');
    
// otf 1.71 defines needed for Product Option Type feature.
  define('PRODUCTS_OPTIONS_TYPE_SELECT', 0);
  define('PRODUCTS_OPTIONS_TYPE_TEXT', 1);
  define('PRODUCTS_OPTIONS_TYPE_RADIO', 2);
  define('PRODUCTS_OPTIONS_TYPE_CHECKBOX', 3);
  define('PRODUCTS_OPTIONS_TYPE_TEXTAREA', 4);
  define('TEXT_PREFIX', 'txt_');
  define('PRODUCTS_OPTIONS_VALUE_TEXT_ID', 0);  //Must match id for user defined "TEXT" value in db table TABLE_PRODUCTS_OPTIONS_VALUES
  
  
//include('includes/languages/english_support.php');
include(DIR_WS_LANGUAGES .$language.'_newsdesk.php');
include(DIR_WS_LANGUAGES .$language.'_faqdesk.php');

define('ENTRY_EXTRA_FIELDS_ERROR','Field %s must contain a minimum of %d characters');
define('CATEGORY_EXTRA_FIELDS', 'Extra Fields');
define('PRODUCT_EXTRA_FIELDS', 'Additional Info');

define('TEXT_DISCOUNT', 'Your discount: ');

define('NO_REVIEWS_TEXT', 'There are currently no reviews for this product.'); define('BOX_REVIEWS_HEADER_TEXT', 'Product Reviews'); 
define('TEXT_VIEW_ALL_REVIEWS', 'Click to view All Reviews');

define('ENTRY_CAPTCHA_ERROR', 'Captcha error!');

define('TEXT_PXSELL_ARTICLES', 'Articles related to this product:'); 

define('TEXT_ALL', 'All'); 

define('TEXT_XSEEL_CART_RECOMMENDED', 'Recommeded Accessories'); 
define('TEXT_XSEEL_CART_UPDATE', 'Click the checkboxes, then click "Update"'); 

// Start Products Specifications
// Products Filter box text in includes/boxes/products_filter.php
define('BOX_HEADING_PRODUCTS_FILTER', 'Filter Products');
define('TEXT_SHOW_ALL', 'Show All');
define('TEXT_FIND_PRODUCTS', 'Find Matching Products');
// End Products Specifications

// Products Specifications
define('TEXT_NOT_AVAILABLE', 'N/A');

define('TEXT_DISPLAY_ALL_PRODUCTS', 'Show all');
define('TEXT_DISPLAY_BY_PAGES', 'Split page');

define('PIN_NOT_AVAILABLE', 'Products out of stock during checkout. Personnel notified.');

?>