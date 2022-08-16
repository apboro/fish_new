<?php

         define('HEADING_TITLES','Order Form');
         define('TEXT_GREETING', 'Would you like to <b><a href='.FILENAME_LOGIN.'><u> log yourself in</u></a></b>?.<br>  Or would you prefer to <a href='.FILENAME_CREATE_ACCOUNT.'><u><b>create an account</b></u></a>?. <br><br>Or you can place your order right now, please fill form below.');
         define('TITLE_SHIPPING_ADDRESS', 'Shipping Address:');
         define('TABLE_HEADING_SHIPPING_METHOD', 'Shipping Method');
         define('TITLE_FORM', 'Quick order form');
         define('TEXT_ENTER_SHIPPING_INFORMATION', '');
         define('TEXT_CHOOSE_SHIPPING_METHOD', 'Select shipping method');
         define('PRIMARY_ADDRESS_DESCRIPTION', 'By creating an account at osCommerce you will be able to shop faster, be up to date on an orders status, and keep track of the orders you have previously made.');
         define('TABLE_QUANTITY', 'Quantity: ');
         define('TABLE_PRICE', 'Price: ');
         define('TABLE_SPECIAL_PRICE', 'Special Price: ');
         define('TITLE_TOTAL', 'Total Price:');
         define('TITLE_METHOD_PAYMENT', 'Payment Method');
         define('TITLE_DATE', 'Shipping date');
         define('TITLE_TIME_SHIPMENT', 'Shipping date');
         define('TITLE_PAYMENT_ADDRESS', 'Billing Address');
         define('PAYMENT_TEXT', 'Required fields.');
         define('PAYMENT_SHIPMENT', 'Press if Delivery Address different from Billing Address:');
         define('ENTRY_COMMENTS', 'Comments:');
         define('ENTRY_HOWKNOW', '');
         define('TITLE_SHIPPING_OWNER', 'Customer:');
         define('HEADING_PRODUCTS', 'Products');
         define('TEXT_EDIT', 'Edit');

define('EMAIL_SUBJECT', 'Welcome to ' . STORE_NAME);
define('EMAIL_GREET_MR', 'Dear Mr. %s,' . "\n\n");
define('EMAIL_GREET_MS', 'Dear Ms. %s,' . "\n\n");
define('EMAIL_GREET_NONE', 'Dear %s' . "\n\n");
define('EMAIL_WELCOME', 'We welcome you to <b>' . STORE_NAME . '</b>.' . "\n\n");
define('EMAIL_TEXT', 'You can now take part in the <b>various services</b> we have to offer you. Some of these services include:' . "\n\n" . '<li><b>Permanent Cart</b> - Any products added to your online cart remain there until you remove them, or check them out.' . "\n" . '<li><b>Address Book</b> - We can now deliver your products to another address other than yours! This is perfect to send birthday gifts direct to the birthday-person themselves.' . "\n" . '<li><b>Order History</b> - View your history of purchases that you have made with us.' . "\n" . '<li><b>Products Reviews</b> - Share your opinions on products with our other customers.' . "\n\n");
define('EMAIL_CONTACT', 'For help with any of our online services, please email the store-owner: ' . STORE_OWNER_EMAIL_ADDRESS . '.' . "\n\n");
define('EMAIL_WARNING', '<b>Note:</b> This email address was given to us by one of our customers. If you did not signup to be a member, please send an email to ' . STORE_OWNER_EMAIL_ADDRESS . '.' . "\n");

/* ICW Credit class gift voucher begin */
define('EMAIL_GV_INCENTIVE_HEADER', "\n\n" .'As part of our welcome to new customers, we have sent you an e-Gift Voucher worth %s');
define('EMAIL_GV_REDEEM', 'The redeem code for the e-Gift Voucher is %s, you can enter the redeem code when checking out while making a purchase');
define('EMAIL_GV_LINK', 'or by following this link ');
define('EMAIL_COUPON_INCENTIVE_HEADER', 'Congratulations, to make your first visit to our online shop a more rewarding experience we are sending you an e-Discount Coupon.' . "\n" .
                                        ' Below are details of the Discount Coupon created just for you' . "\n");
define('EMAIL_COUPON_REDEEM', 'To use the coupon enter the redeem code which is %s during checkout while making a purchase');

/* ICW Credit class gift voucher end */


?>