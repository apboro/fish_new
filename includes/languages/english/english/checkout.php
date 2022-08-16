<?php
/* -----------------------------------------------------------------------------------------
   $Id: checkout.php 867 2012-11-20 19:20:03 oleg_vamsoft $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2012 VamShop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(address_book.php,v 1.57 2003/05/29); www.oscommerce.com 
   (c) 2003	 nextcommerce (address_book.php,v 1.14 2003/08/17); www.nextcommerce.org
   (c) 2004	 xt:Commerce (address_book.php,v 1.14 2003/08/17); xt-commerce.com
   (c) 2012	 STRUB

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

define('NAVBAR_TITLE_1', 'Checkout');
define('NAVBAR_TITLE_2', 'Checkout');

define('HEADING_TITLE', 'Checkout');

//error
define('SHIPPING_ERROR', 'Please select a shipping method.');
define('PAYMENT_ERROR', 'Please select a payment method.');
define('CONDITIONS_ERROR', 'Please agree to our Terms and Conditions Agreement.');
//error end


//progess bar
define('SC_PROGRESS_CHECKOUT_PAGE', 'Checkout');
define('SC_PROGRESS_CONFIRMATION_PAGE', 'Order Confirmation');
//progress bar end

define('TEXT_ORIGIN_LOGIN', 'Would you like to <b><a href='.FILENAME_LOGIN.'><u> log yourself in</u></a></b>?. Or you can place your order right now, please fill form below.');

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
define('ENTRY_SC_STREET_ADDRESS_TEXT', '');
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

//site content
define('TEXT_SHIPPING_SAME_AS_PAYMENT', 'Billing address is the same as shipping address.');
define('TEXT_NO_SHIPPING_AVAILABLE', 'No shipping available to the selected country.');
define('SC_TEXT_REDIRECT', 'You will be redirected to payment page.');
define('SC_ERROR_NO_SHIPPING_POSSIBLE', 'No shipping available to the selected country.');

//site content end

//buttons
define('IMAGE_BUTTON_CONFIRMATION_PAGE', 'Go to confirmation page');
//buttons end



//Start Conditions of use
define('SC_CONDITION', 'I have read the ');
define('SC_CONDITION_END', ' and I agree to them: ');

define('SC_HEADING_CONDITIONS', '<strong>Terms and Conditions Agreement</strong>');
//End Conditions of use

define('TEXT_DISCOUNT_CODE', 'Coupon code or gift voucher');

//Account optional
define('TEXT_CREATE_ACCOUNT_OPTIONAL', 'I do not want to create an account.');

//Account creation
define('SC_HEADING_CREATE_ACCOUNT', 'Create account');
define('SC_HEADING_CREATE_ACCOUNT_INFORMATION', 'Account Information');
define('SC_TEXT_VIRTUAL_PRODUCT', 'You need to create an account in order to download virtual products!');
define('SC_TEXT_PASSWORD_REQUIRED', 'You need to create an account in order to purchase products!');


//email specific
define('EMAIL_USERNAME', 'Your username is: ' . stripslashes($_POST['email_address']) . "\n\n");
define('EMAIL_PASSWORD', 'Your password is: ' . stripslashes($_POST['password']) . "\n\n");

// CHECKOUT_SHIPPING

define('TABLE_HEADING_SHIPPING_ADDRESS', 'Shipping Address');
define('TEXT_CHOOSE_SHIPPING_DESTINATION', 'Please choose from your address book where you would like the items to be delivered to.');
define('TITLE_SHIPPING_ADDRESS', 'Shipping Address:');

define('TABLE_HEADING_SHIPPING_METHOD', 'Shipping Method');
define('TEXT_CHOOSE_SHIPPING_METHOD', 'Please select the preferred shipping method to use on this order.');
define('TITLE_PLEASE_SELECT', 'Please Select');
define('TEXT_ENTER_SHIPPING_INFORMATION', 'This is currently the only shipping method available to use on this order.');

define('TABLE_HEADING_COMMENTS', 'Add Comments About Your Order');

define('TITLE_CONTINUE_CHECKOUT_PROCEDURE', 'Continue Checkout Procedure');
define('TEXT_CONTINUE_CHECKOUT_PROCEDURE', 'to select the preferred payment method.');

define('TEXT_ENTER_SHIPPING_NO_METHOD','Shipping methods not available.');

// CHECKOUT_PAYMENT

define('TABLE_HEADING_BILLING_ADDRESS', 'Billing Address');
define('TEXT_SELECTED_BILLING_DESTINATION', 'Please choose from your address book where you would like the invoice to be sent to.');
define('TITLE_BILLING_ADDRESS', 'Billing Address:');

define('TABLE_HEADING_PAYMENT_METHOD', 'Payment Method');
define('TEXT_SELECT_PAYMENT_METHOD', 'Please select the preferred payment method to use on this order.');
define('TITLE_PLEASE_SELECT', 'Please Select');
define('TEXT_ENTER_PAYMENT_INFORMATION', 'This is currently the only payment method available to use on this order.');

define('TABLE_HEADING_COMMENTS', 'Add Comments About Your Order');

define('TITLE_CONTINUE_CHECKOUT_PROCEDURE', 'Continue Checkout Procedure');
define('TEXT_CONTINUE_CHECKOUT_PROCEDURE', 'to confirm this order.');

// CHECKOUT_CONFIRMATION

define('HEADING_DELIVERY_ADDRESS', 'Delivery Address');
define('HEADING_SHIPPING_METHOD', 'Shipping Method');
define('HEADING_PRODUCTS', 'Products');
define('HEADING_TAX', 'Tax');
define('HEADING_TOTAL', 'Total');
define('HEADING_BILLING_INFORMATION', 'Billing Information');
define('HEADING_BILLING_ADDRESS', 'Billing Address');
define('HEADING_PAYMENT_METHOD', 'Payment Method');
define('HEADING_PAYMENT_INFORMATION', 'Payment Information');
define('HEADING_ORDER_COMMENTS', 'Comments About Your Order');

define('TEXT_EDIT', 'Edit');

define('TITLE_CONTINUE_CHECKOUT_PROCEDURE', 'Continue Checkout Procedure');
define('TEXT_CONTINUE_CHECKOUT_PROCEDURE', 'to confirm this order.');
?>