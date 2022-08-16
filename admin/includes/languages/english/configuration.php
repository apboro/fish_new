<?php
/*
  $Id: configuration.php,v 1.2 2003/09/24 13:57:08 wilt Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2002 osCommerce

  Released under the GNU General Public License
*/

define('TABLE_HEADING_CONFIGURATION_TITLE', 'Title');
define('TABLE_HEADING_CONFIGURATION_VALUE', 'Value');
define('TABLE_HEADING_ACTION', 'Action');

define('TEXT_INFO_EDIT_INTRO', 'Please make any necessary changes');
define('TEXT_INFO_DATE_ADDED', 'Date Added:');
define('TEXT_INFO_LAST_MODIFIED', 'Last Modified:');
define('ERROR_TEMPLATE_IMAGE_DIRECTORY_NOT_WRITEABLE', 'Directory does not writeable. Change permissions.');
define('ERROR_TEMPLATE_IMAGE_DIRECTORY_DOES_NOT_EXIST', 'Directory does not exists.');

// Мой магазин

define('DEFAULT_TEMPLATE_TITLE', 'Default theme');
define('STORE_NAME_TITLE', 'Store Name');
define('STORE_OWNER_TITLE', 'Store Owner');
define('STORE_LOGO_TITLE', 'Store Logo');
define('STORE_OWNER_EMAIL_ADDRESS_TITLE', 'E-Mail Address');
define('STORE_OWNER_ICQ_NUMBER_TITLE' , 'ICQ number');
define('EMAIL_FROM_TITLE', 'E-Mail From');
define('STORE_COUNTRY_TITLE', 'Country');
define('STORE_ZONE_TITLE', 'Zone');
define('EXPECTED_PRODUCTS_SORT_TITLE', 'Expected Sort Order');
define('EXPECTED_PRODUCTS_FIELD_TITLE', 'Expected Sort Field');
define('USE_DEFAULT_LANGUAGE_CURRENCY_TITLE', 'Switch To Default Language Currency');
define('SEND_EXTRA_ORDER_EMAILS_TO_TITLE', 'Send Extra Order Emails To');
define('SEARCH_ENGINE_FRIENDLY_URLS_TITLE', 'Use Search-Engine Safe URLs (still in development)');
define('DISPLAY_CART_TITLE', 'Display Cart After Adding Product');
define('ALLOW_GUEST_TO_TELL_A_FRIEND_TITLE', 'Allow Guest To Tell A Friend');
define('ADVANCED_SEARCH_DEFAULT_OPERATOR_TITLE', 'Default Search Operator');
define('STORE_NAME_ADDRESS_TITLE', 'Store Address and Phone');
define('SHOW_COUNTS_TITLE', 'Show Category Counts');
define('ALLOW_CATEGORY_DESCRIPTIONS_TITLE', 'Allow Category Descriptions');
define('TAX_DECIMAL_PLACES_TITLE', 'Tax Decimal Places');
define('SHOW_MAIN_FEATURED_PRODUCTS_TITLE', 'Show Featured Products on Main Page');
define('DISPLAY_PRICE_WITH_TAX_TITLE', 'Display Prices with Tax');
define('XPRICES_NUM_TITLE' , 'Number Of Prices Per Products');
define('NEW_SIGNUP_GIFT_VOUCHER_AMOUNT_TITLE', 'Welcome Gift Voucher Amount');
define('ALLOW_GUEST_TO_SEE_PRICES_TITLE' , 'Allow Guest To See Prices');
define('NEW_SIGNUP_DISCOUNT_COUPON_TITLE', 'Welcome Discount Coupon Code');
define('GUEST_DISCOUNT_TITLE' , 'Guest Discount');
define('CATEGORIES_SORT_ORDER_TITLE' , 'Category/Products Display Order');
define('QUICKSEARCH_IN_DESCRIPTION_TITLE' , 'Search in products description');
define('CONTACT_US_LIST_TITLE' , 'Contact Us Email Lists');
define('ALLOW_GIFT_VOUCHERS_TITLE' , 'Allow gift vouchers and coupons');
define('ALLOW_ATTRIBUTES_IN_PRODUCT_EDIT_PAGE_TITLE' , 'Allow attributes in product edit page');
define('SHOW_SUBCATEGORIES_WHEN_CATEGORIES_HAS_PRODUCTS_TITLE' , 'Show subcategories when category has products');
define('SHOW_PDF_DATASHEET_TITLE' , 'PDF Datasheet');

// Минимальнаые значения

define('ENTRY_FIRST_NAME_MIN_LENGTH_TITLE', 'First Name');
define('ENTRY_LAST_NAME_MIN_LENGTH_TITLE', 'Last Name');
define('ENTRY_DOB_MIN_LENGTH_TITLE', 'Date of Birth');
define('ENTRY_EMAIL_ADDRESS_MIN_LENGTH_TITLE', 'E-Mail Address');
define('ENTRY_STREET_ADDRESS_MIN_LENGTH_TITLE', 'Street Address');
define('ENTRY_COMPANY_MIN_LENGTH_TITLE', 'Company');
define('ENTRY_POSTCODE_MIN_LENGTH_TITLE', 'Post Code');
define('ENTRY_CITY_MIN_LENGTH_TITLE', 'City');
define('ENTRY_STATE_MIN_LENGTH_TITLE', 'State');
define('ENTRY_TELEPHONE_MIN_LENGTH_TITLE', 'Telephone Number');
define('ENTRY_PASSWORD_MIN_LENGTH_TITLE', 'Password');
define('CC_OWNER_MIN_LENGTH_TITLE', 'Credit Card Owner Name');
define('CC_NUMBER_MIN_LENGTH_TITLE', 'Credit Card Number');
define('REVIEW_TEXT_MIN_LENGTH_TITLE', 'Review Text');
define('MIN_DISPLAY_BESTSELLERS_TITLE', 'Best Sellers');
define('MIN_DISPLAY_ALSO_PURCHASED_TITLE', 'Also Purchased');
define('MIN_DISPLAY_XSELL_TITLE', 'X-Sell');
define('MIN_ORDER_TITLE' , 'Minimum order amount');

// Максимальные значения

define('MAX_PROD_ADMIN_SIDE_TITLE' , 'Products per page in admin');
define('MAX_ADDRESS_BOOK_ENTRIES_TITLE', 'Address Book Entries');
define('MAX_DISPLAY_SEARCH_RESULTS_TITLE', 'Search Results');
define('MAX_DISPLAY_PAGE_LINKS_TITLE', 'Page Links');
define('MAX_DISPLAY_SPECIAL_PRODUCTS_TITLE', 'Special Products');
define('MAX_DISPLAY_NEW_PRODUCTS_TITLE', 'New Products Module');
define('MAX_DISPLAY_UPCOMING_PRODUCTS_TITLE', 'Products Expected');
define('MAX_DISPLAY_MANUFACTURERS_IN_A_LIST_TITLE', 'Manufacturers List');
define('MAX_MANUFACTURERS_LIST_TITLE', 'Manufacturers Select Size');
define('MAX_DISPLAY_MANUFACTURER_NAME_LEN_TITLE', 'Length of Manufacturers Name');
define('MAX_DISPLAY_NEW_REVIEWS_TITLE', 'New Reviews');
define('MAX_RANDOM_SELECT_REVIEWS_TITLE', 'Selection of Random Reviews');
define('MAX_RANDOM_SELECT_NEW_TITLE', 'Selection of Random New Products');
define('MAX_RANDOM_SELECT_SPECIALS_TITLE', 'Selection of Products on Special');
define('MAX_DISPLAY_CATEGORIES_PER_ROW_TITLE', 'Categories To List Per Row');
define('MAX_DISPLAY_PRODUCTS_NEW_TITLE', 'New Products Listing');
define('MAX_DISPLAY_BESTSELLERS_TITLE', 'Best Sellers');
define('MAX_DISPLAY_ALSO_PURCHASED_TITLE', 'Also Purchased');
define('MAX_DISPLAY_PRODUCTS_IN_ORDER_HISTORY_BOX_TITLE', 'Customer Order History Box');
define('MAX_DISPLAY_ORDER_HISTORY_TITLE', 'Order History');
define('MAX_DISPLAY_FEATURED_PRODUCTS_TITLE', 'Product Featured Maximum Display');
define('MAX_DISPLAY_FEATURED_PRODUCTS_LISTING_TITLE', 'Product Featured Display Results');

// Картинки

define('SMALL_IMAGE_WIDTH_TITLE', 'Small Image Width');
define('SMALL_IMAGE_HEIGHT_TITLE', 'Small Image Height');
define('HEADING_IMAGE_WIDTH_TITLE', 'Heading Image Width');
define('HEADING_IMAGE_HEIGHT_TITLE', 'Heading Image Height');
define('SUBCATEGORY_IMAGE_WIDTH_TITLE', 'Subcategory Image Width');
define('SUBCATEGORY_IMAGE_HEIGHT_TITLE', 'Subcategory Image Height');
define('CONFIG_CALCULATE_IMAGE_SIZE_TITLE', 'Calculate Image Size');
define('IMAGE_REQUIRED_TITLE', 'Image Required');
define('ULTIMATE_ADDITIONAL_IMAGES_TITLE', 'Enable Additional Images?');
define('ULT_THUMB_IMAGE_WIDTH_TITLE', 'Additional Thumb Width');
define('ULT_THUMB_IMAGE_HEIGHT_TITLE', 'Additional Thumb Height');
define('MEDIUM_IMAGE_WIDTH_TITLE', 'Medium Image Width');
define('MEDIUM_IMAGE_HEIGHT_TITLE', 'Medium Image Height');
define('LARGE_IMAGE_WIDTH_TITLE', 'Large Image Width (Pop-up)');
define('LARGE_IMAGE_HEIGHT_TITLE', 'Large Image Height (Pop-up)');

// Данные покупателя

define('ACCOUNT_GENDER_TITLE', 'Gender');
define('ACCOUNT_DOB_TITLE', 'Date of Birth');
define('ACCOUNT_COMPANY_TITLE', 'Company');
define('ACCOUNT_SUBURB_TITLE', 'Suburb');
define('ACCOUNT_STATE_TITLE', 'State');
define('ACCOUNT_STREET_ADDRESS_TITLE' , 'Street address');
define('ACCOUNT_CITY_TITLE' , 'City');
define('ACCOUNT_POSTCODE_TITLE' , 'Postcode/ZIP');
define('ACCOUNT_COUNTRY_TITLE' , 'Country');
define('ACCOUNT_TELE_TITLE' , 'Telephone');
define('ACCOUNT_FAX_TITLE' , 'Fax');
define('ACCOUNT_NEWS_TITLE' , 'Newsletter');

// Доставка/упаковка

define('SHIPPING_ORIGIN_COUNTRY_TITLE', 'Country of Origin');
define('SHIPPING_ORIGIN_ZIP_TITLE', 'Postal Code');
define('SHIPPING_MAX_WEIGHT_TITLE', 'Enter the Maximum Package Weight you will ship');
define('SHIPPING_BOX_WEIGHT_TITLE', 'Package Tare weight.');
define('SHIPPING_BOX_PADDING_TITLE', 'Larger packages - percentage increase.');
define('MODULE_ORDER_TOTAL_SHIPPING_FREE_SHIPPING_TITLE', 'Allow Free Shipping');
define('MODULE_ORDER_TOTAL_SHIPPING_FREE_SHIPPING_OVER_TITLE', 'Free Shipping For Orders Over');
define('MODULE_ORDER_TOTAL_SHIPPING_DESTINATION_TITLE', 'Provide Free Shipping For Orders Made');
define('SHOW_SHIPPING_ESTIMATOR_TITLE', 'Shipping Estimator');
define('SHOW_XSELL_CART', 'Show cross-sell products in cart');

// Вывод товара

define('PRODUCT_LISTING_DISPLAY_STYLE_TITLE' , 'Product listing type');
define('PRODUCT_LIST_IMAGE_TITLE' , 'Display Product Image');
define('PRODUCT_LIST_COL_NUM_TITLE' , 'Number of Columns for Product Listing');
define('PRODUCT_LIST_MANUFACTURER_TITLE', 'Display Product Manufaturer Name');
define('PRODUCT_LIST_MODEL_TITLE', 'Display Product Model');
define('PRODUCT_LIST_NAME_TITLE', 'Display Product Name');
define('PRODUCT_LIST_PRICE_TITLE', 'Display Product Price');
define('PRODUCT_LIST_QUANTITY_TITLE', 'Display Product Quantity');
define('PRODUCT_LIST_WEIGHT_TITLE', 'Display Product Weight');
define('PRODUCT_LIST_BUY_NOW_TITLE', 'Display Buy Now column');
define('PRODUCT_LIST_FILTER_TITLE', 'Display Category/Manufacturer Filter (0=disable; 1=enable)');
define('PREV_NEXT_BAR_LOCATION_TITLE', 'Location of Prev/Next Navigation Bar (1-top, 2-bottom, 3-both)');
define('PRODUCT_LIST_INFO_TITLE' , 'Display short description');
define('PRODUCT_SORT_ORDER_TITLE' , 'Display sort order');

// Склад

define('STOCK_CHECK_TITLE', 'Check stock level');
define('STOCK_LIMITED_TITLE', 'Subtract stock');
define('STOCK_ALLOW_CHECKOUT_TITLE', 'Allow Checkout');
define('STOCK_MARK_PRODUCT_OUT_OF_STOCK_TITLE', 'Mark product out of stock');
define('STOCK_REORDER_LEVEL_TITLE', 'Stock Re-order level');

// Логи

define('STORE_PAGE_PARSE_TIME_TITLE', 'Store Page Parse Time');
define('STORE_PAGE_PARSE_TIME_LOG_TITLE', 'Log Destination');
define('STORE_PARSE_DATE_TIME_FORMAT_TITLE', 'Log Date Format');
define('DISPLAY_PAGE_PARSE_TIME_TITLE', 'Display The Page Parse Time');
define('STORE_DB_TRANSACTIONS_TITLE', 'Store Database Queries');

// Кэш

define('USE_CACHE_TITLE', 'Use Cache');
define('DIR_FS_CACHE_TITLE', 'Cache Directory');

// Настройка E-Mail

define('EMAIL_TRANSPORT_TITLE', 'E-Mail Transport Method');
define('EMAIL_LINEFEED_TITLE', 'E-Mail Linefeeds');
define('EMAIL_USE_HTML_TITLE', 'Use MIME HTML When Sending Emails');
define('ENTRY_EMAIL_ADDRESS_CHECK_TITLE', 'Verify E-Mail Addresses Through DNS');
define('SEND_EMAILS_TITLE', 'Send E-Mails');

// Скачивание

define('DOWNLOAD_ENABLED_TITLE', 'Enable download');
define('DOWNLOAD_BY_REDIRECT_TITLE', 'Download by redirect');
define('DOWNLOAD_MAX_DAYS_TITLE', 'Expiry delay (days)');
define('DOWNLOAD_MAX_COUNT_TITLE', 'Maximum number of downloads');
define('DOWNLOADS_ORDERS_STATUS_UPDATED_VALUE_TITLE', 'Downloads Controller Update Status Value');
define('DOWNLOADS_CONTROLLER_ON_HOLD_MSG_TITLE', 'Downloads Controller Download on hold message');
define('DOWNLOADS_CONTROLLER_ORDERS_STATUS_TITLE', 'Downloads Controller Order Status Value');

// GZip Компрессия

define('GZIP_COMPRESSION_TITLE', 'Enable GZip Compression');
define('GZIP_LEVEL_TITLE', 'Compression Level');

// Сессии

define('SESSION_WRITE_DIRECTORY_TITLE', 'Session Directory');
define('SESSION_FORCE_COOKIE_USE_TITLE', 'Force Cookie Use');
define('SESSION_CHECK_SSL_SESSION_ID_TITLE', 'Check SSL Session ID');
define('SESSION_CHECK_USER_AGENT_TITLE', 'Check User Agent');
define('SESSION_CHECK_IP_ADDRESS_TITLE', 'Check IP Address');
define('SESSION_BLOCK_SPIDERS_TITLE', 'Prevent Spider Sessions');
define('SESSION_RECREATE_TITLE', 'Recreate Session');

// HTML Редактор

define('HTML_AREA_WYSIWYG_DISABLE_TITLE', 'PRODUCT DESCRIPTIONS use TinyMCE?');
define('HTML_AREA_WYSIWYG_DISABLE_JPSY_TITLE', 'PRODUCT DESCRIPTIONS use JPSY-PHP ULTRA-IMAGES MANAGER?');
define('HTML_AREA_WYSIWYG_BASIC_PD_TITLE', 'Product Description Basic/Advanced/Medium Version?');
define('HTML_AREA_WYSIWYG_WIDTH_TITLE', 'Product Description Layout Width');
define('HTML_AREA_WYSIWYG_HEIGHT_TITLE', 'Product Description Layout Height');
define('HTML_AREA_WYSIWYG_DISABLE_EMAIL_TITLE', 'CUSTOMER EMAILS use TinyMCE?');
define('HTML_AREA_WYSIWYG_BASIC_EMAIL_TITLE', 'Customer Email Basic/Advanced/Medium Version?');
define('EMAIL_AREA_WYSIWYG_WIDTH_TITLE', 'Customer Email Layout Width');
define('EMAIL_AREA_WYSIWYG_HEIGHT_TITLE', 'Customer Email Layout Height');
define('HTML_AREA_WYSIWYG_DISABLE_NEWSLETTER_TITLE', 'NEWSLETTER EMAILS use TinyMCE?');
define('HTML_AREA_WYSIWYG_BASIC_NEWSLETTER_TITLE', 'Newsletter Email Basic/Advanced/Medium Version?');
define('NEWSLETTER_EMAIL_WYSIWYG_WIDTH_TITLE', 'Newsletter Email Layout Width');
define('NEWSLETTER_EMAIL_WYSIWYG_HEIGHT_TITLE', 'Newsletter Email Layout Height');
define('HTML_AREA_WYSIWYG_DISABLE_DEFINE_TITLE', 'DEFINE MAINPAGE use TinyMCE?');
define('HTML_AREA_WYSIWYG_BASIC_DEFINE_TITLE', 'Define Mainpage Basic/Advanced/Medium Version?');
define('HTML_AREA_WYSIWYG_DISABLE_ARTICLES_TITLE', 'DEFINE articles use TinyMCE?');
define('HTML_AREA_WYSIWYG_BASIC_ARTICLES_TITLE', 'Define articles Basic/Advanced/Medium Version?');
define('HTML_AREA_WYSIWYG_DISABLE_FAQDESK_TITLE', 'DEFINE faq use TinyMCE?');
define('HTML_AREA_WYSIWYG_BASIC_FAQDESK_TITLE', 'Define faq Basic/Advanced/Medium Version?');
define('HTML_AREA_WYSIWYG_DISABLE_NEWSDESK_TITLE', 'DEFINE news use TinyMCE?');
define('HTML_AREA_WYSIWYG_BASIC_NEWSDESK_TITLE', 'Define news Basic/Advanced/Medium Version?');
define('HTML_AREA_WYSIWYG_DISABLE_INFOPAGES_TITLE', 'DEFINE infopages use TinyMCE?');
define('HTML_AREA_WYSIWYG_BASIC_INFOPAGES_TITLE', 'Define infopages Basic/Advanced/Medium Version?');
define('DEFINE_MAINPAGE_WYSIWYG_WIDTH_TITLE', 'Define Mainpage Layout Width');
define('DEFINE_MAINPAGE_WYSIWYG_HEIGHT_TITLE', 'Define Mainpage Layout Height');
define('HTML_AREA_WYSIWYG_FONT_TYPE_TITLE', 'GLOBAL - User Interface Font Type');
define('HTML_AREA_WYSIWYG_FONT_SIZE_TITLE', 'GLOBAL - User Interface Font Size');
define('HTML_AREA_WYSIWYG_FONT_COLOUR_TITLE', 'GLOBAL - User Interface Font Colour');
define('HTML_AREA_WYSIWYG_BG_COLOUR_TITLE', 'GLOBAL - User Interface Background Colour');
define('HTML_AREA_WYSIWYG_DEBUG_TITLE', 'GLOBAL - ALLOW DEBUG MODE?');

// Партнёрская программа

define('AFFILIATE_EMAIL_ADDRESS_TITLE', 'E-Mail Address');
define('AFFILIATE_PERCENT_TITLE', 'Affiliate Pay Per Sale Payment % Rate');
define('AFFILIATE_THRESHOLD_TITLE', 'Payment Threshold');
define('AFFILIATE_COOKIE_LIFETIME_TITLE', 'Cookie Lifetime');
define('AFFILIATE_BILLING_TIME_TITLE', 'Billing Time');
define('AFFILIATE_PAYMENT_ORDER_MIN_STATUS_TITLE', 'Order Min Status');
define('AFFILIATE_USE_CHECK_TITLE', 'Pay Affiliates with check');
define('AFFILIATE_USE_PAYPAL_TITLE', 'Pay Affiliates with PayPal');
define('AFFILIATE_USE_BANK_TITLE', 'Pay Affiliates by Bank');
define('AFFILATE_INDIVIDUAL_PERCENTAGE_TITLE', 'Individual Affiliate Percentage');
define('AFFILATE_USE_TIER_TITLE', 'Use Affiliate-tier');
define('AFFILIATE_TIER_LEVELS_TITLE', 'Number of Tierlevels');
define('AFFILIATE_TIER_PERCENTAGE_TITLE', 'Percentage Rate for the Tierlevels');

// Модуль Dynamic MoPics

define('IN_IMAGE_BIGIMAGES_TITLE', 'Big Images Directory');
define('IN_IMAGE_THUMBS_TITLE', 'Thumbnail Images Directory');
define('MAIN_THUMB_IN_SUBDIR_TITLE', 'Main Thumbnail In Thumb Directory');
define('THUMBS_PER_ROW_TITLE', 'Number of Pics per Row');
define('MORE_PICS_EXT_TITLE', 'Mo Pics Extension');
define('BIG_PIC_EXT_TITLE', 'Main Big Pic Extension');
define('THUMB_IMAGE_TYPE_TITLE', 'Mo Pics Thumbnail Image Type');
define('BIG_IMAGE_TYPE_TITLE', 'Mo Pics Big Image Type');

// Тех. обслуживание

define('DOWN_FOR_MAINTENANCE_TITLE', 'Down for Maintenance: ON/OFF');
define('DOWN_FOR_MAINTENANCE_FILENAME_TITLE', 'Down for Maintenance: filename');
define('DOWN_FOR_MAINTENANCE_HEADER_OFF_TITLE', 'Down for Maintenance: Hide Header');
define('DOWN_FOR_MAINTENANCE_COLUMN_LEFT_OFF_TITLE', 'Down for Maintenance: Hide Column Left');
define('DOWN_FOR_MAINTENANCE_COLUMN_RIGHT_OFF_TITLE', 'Down for Maintenance: Hide Column Right');
define('DOWN_FOR_MAINTENANCE_FOOTER_OFF_TITLE', 'Down for Maintenance: Hide Footer');
define('DOWN_FOR_MAINTENANCE_PRICES_OFF_TITLE', 'Down for Maintenance: Hide Prices');
define('EXCLUDE_ADMIN_IP_FOR_MAINTENANCE_TITLE', 'Down For Maintenance (exclude this IP-Address)');
define('WARN_BEFORE_DOWN_FOR_MAINTENANCE_TITLE', 'NOTIFY PUBLIC Before going Down for Maintenance: ON/OFF');
define('PERIOD_BEFORE_DOWN_FOR_MAINTENANCE_TITLE', 'Date and hours for notice before maintenance');
define('DISPLAY_MAINTENANCE_TIME_TITLE', 'Display when webmaster has enabled maintenance');
define('DISPLAY_MAINTENANCE_PERIOD_TITLE', 'Display website maintenance period');
define('TEXT_MAINTENANCE_PERIOD_TIME_TITLE', 'Website maintenance period');

// Быстрое оформление

define('GUEST_ON_TITLE' , 'Guests accounts');

// Ссылки

define('ENABLE_LINKS_COUNT_TITLE' , 'Click Count');
define('ENABLE_SPIDER_FRIENDLY_LINKS_TITLE' , 'Spider Friendly Links');
define('LINKS_IMAGE_WIDTH_TITLE' , 'Links Image Width');
define('LINKS_IMAGE_HEIGHT_TITLE' , 'Links Image Height');
define('LINK_LIST_IMAGE_TITLE' , 'Display Link Image');
define('LINK_LIST_URL_TITLE' , 'Display Link URL');
define('LINK_LIST_TITLE_TITLE' , 'Display Link Title');
define('LINK_LIST_DESCRIPTION_TITLE' , 'Display Link Description');
define('LINK_LIST_COUNT_TITLE' , 'Display Link Click Count');
define('ENTRY_LINKS_TITLE_MIN_LENGTH_TITLE' , 'Link Title Minimum Length');
define('ENTRY_LINKS_URL_MIN_LENGTH_TITLE' , 'Link URL Minimum Length');
define('ENTRY_LINKS_DESCRIPTION_MIN_LENGTH_TITLE' , 'Link Description Minimum Length');
define('ENTRY_LINKS_CONTACT_NAME_MIN_LENGTH_TITLE' , 'Link Contact Name Minimum Length');
define('LINKS_CHECK_PHRASE_TITLE' , 'Links Check Phrase');

// Обновление прайса

define('DISPLAY_MODEL_TITLE' , 'Display the model');
define('MODIFY_MODEL_TITLE' , 'Modify the model');
define('MODIFY_NAME_TITLE' , 'Modify the name of the products');
define('DISPLAY_STATUT_TITLE' , 'Modify the statut of the products');
define('DISPLAY_WEIGHT_TITLE' , 'Modify the weight of the products');
define('DISPLAY_QUANTITY_TITLE' , 'Modify the quantity of the products');
define('DISPLAY_SORT_ORDER_TITLE' , 'Display the sort order');
define('DISPLAY_ORDER_MIN_TITLE' , 'Display the min');
define('DISPLAY_ORDER_UNITS_TITLE' , 'Display the units');
define('DISPLAY_IMAGE_TITLE' , 'Modify the image of the products');
define('DISPLAY_XML_TITLE' , 'Display xml');
define('DISPLAY_MANUFACTURER_TITLE' , 'Display the manufacturer');
define('MODIFY_MANUFACTURER_TITLE' , 'Modify the manufacturer of the products');
define('DISPLAY_TAX_TITLE' , 'Display the tax');
define('MODIFY_TAX_TITLE' , 'Modify the class of tax of the products');
define('DISPLAY_TVA_OVER_TITLE' , 'Display price with all included of tax');
define('DISPLAY_TVA_UP_TITLE' , 'Display price with all included of tax');
define('DISPLAY_PREVIEW_TITLE' , 'Display the link towards the products information page');
define('DISPLAY_EDIT_TITLE' , 'Display the link towards the page where you will be able to edit the product');
define('ACTIVATE_COMMERCIAL_MARGIN_TITLE' , 'Activate or desactivate the commercial margin');

// Отложенные товары

define('MAX_DISPLAY_WISHLIST_PRODUCTS_TITLE' , 'Max Wish List');
define('MAX_DISPLAY_WISHLIST_BOX_TITLE' , 'Max Wish List Box');
define('DISPLAY_WISHLIST_EMAILS_TITLE' , 'Display Emails');
define('WISHLIST_REDIRECT_TITLE' , 'Wishlist Redirect');

// Кэш страниц

define('ENABLE_PAGE_CACHE_TITLE' , 'Enable Page Cache');
define('PAGE_CACHE_LIFETIME_TITLE' , 'Cache Lifetime');
define('PAGE_CACHE_DEBUG_MODE_TITLE' , 'Turn on Debug Mode?');
define('PAGE_CACHE_DISABLE_PARAMETERS_TITLE' , 'Disable URL Parameters?');
define('PAGE_CACHE_DELETE_FILES_TITLE' , 'Delete Cache Files?');
define('PAGE_CACHE_UPDATE_CONFIG_FILES_TITLE' , 'Config Cache Update File?');

// Яндекс маркет

define('YML_NAME_TITLE' , 'Store name');
define('YML_COMPANY_TITLE' , 'Store owner');
define('YML_DELIVERYINCLUDED_TITLE' , 'Delivery included');
define('YML_AVAILABLE_TITLE' , 'Product availability');
define('YML_AUTH_USER_TITLE' , 'Login');
define('YML_AUTH_PW_TITLE' , 'Password');
define('YML_REFERER_TITLE' , 'Referer');
define('YML_STRIP_TAGS_TITLE' , 'Strip tags');
define('YML_UTF8_TITLE' , 'Encode to windows-1251');
define('YML_SALES_NOTES_TITLE' , 'sales_notes tag');

// Описание полей

// Мой магазин

define('DEFAULT_TEMPLATE_DESC', 'Use this to set the default theme.');
define('STORE_NAME_DESC', 'The name of my store');
define('STORE_OWNER_DESC', 'The name of my store owner');
define('STORE_LOGO_DESC', 'This is the logo for my store');
define('STORE_OWNER_EMAIL_ADDRESS_DESC', 'The e-mail address of my store owner');
define('STORE_OWNER_ICQ_NUMBER_DESC', 'ICQ number will be displayed in the Help side box.');
define('EMAIL_FROM_DESC', 'The e-mail address used in (sent) e-mails');
define('STORE_COUNTRY_DESC', 'The country my store is located in <br><br><b>Note: Please remember to update the store zone.</b>');
define('STORE_ZONE_DESC', 'The zone my store is located in');
define('EXPECTED_PRODUCTS_SORT_DESC', 'This is the sort order used in the expected products box.');
define('EXPECTED_PRODUCTS_FIELD_DESC', 'The column to sort by in the expected products box.');
define('USE_DEFAULT_LANGUAGE_CURRENCY_DESC', 'Automatically switch to the language\'s currency when it is changed');
define('SEND_EXTRA_ORDER_EMAILS_TO_DESC', 'Send extra order emails to the following email addresses, in this format: Name 1 &lt;email@address1&gt;, Name 2 &lt;email@address2&gt;');
define('SEARCH_ENGINE_FRIENDLY_URLS_DESC', 'Use search-engine safe urls for all site links');
define('DISPLAY_CART_DESC', 'Display the shopping cart after adding a product (or return back to their origin)');
define('ALLOW_GUEST_TO_TELL_A_FRIEND_DESC', 'Allow guests to tell a friend about a product');
define('ADVANCED_SEARCH_DEFAULT_OPERATOR_DESC', 'Default search operators');
define('STORE_NAME_ADDRESS_DESC', 'This is the Store Name, Address and Phone used on printable documents and displayed online');
define('SHOW_COUNTS_DESC', 'Count recursively how many products are in each category');
define('ALLOW_CATEGORY_DESCRIPTIONS_DESC', 'Allow use of full text descriptions for categories');
define('TAX_DECIMAL_PLACES_DESC', 'Pad the tax value this amount of decimal places');
define('SHOW_MAIN_FEATURED_PRODUCTS_DESC', 'true - Enable<br>false - Disable');
define('DISPLAY_PRICE_WITH_TAX_DESC', 'Display prices with tax included (true) or add the tax at the end (false)');
define('XPRICES_NUM_DESC', 'Number of prices per products<br><br><b>WARNING: Changing this value will delete prices entry in products table!</b><br><br><b>Every groups that use a deleted price will use product default price.</b>');
define('NEW_SIGNUP_GIFT_VOUCHER_AMOUNT_DESC', 'Welcome Gift Voucher Amount: If you do not wish to send a Gift Voucher in your create account email put 0 for no amount else if you do place the amount here i.e. 10.00 or 50.00 no currency signs');
define('ALLOW_GUEST_TO_SEE_PRICES_DESC', 'Allow guests to view default prices');
define('NEW_SIGNUP_DISCOUNT_COUPON_DESC', 'Welcome Discount Coupon Code: if you do not want to send a coupon in your create account email leave blank else place the coupon code you wish to use');
define('GUEST_DISCOUNT_DESC', 'Guest Discount.');
define('CATEGORIES_SORT_ORDER_DESC', '<b>Valid Orders:<br>products_name<br>products_name-desc<br>model<br>model-desc</b>');
define('QUICKSEARCH_IN_DESCRIPTION_DESC', 'If set to TRUE the customer can search in descriptions otherwise the search is limited to the product title');
define('CONTACT_US_LIST_DESC', 'On the "Contact Us" Page, set the list of email addresses , in this format: Name 1 &lt;email@address1&gt;, Name 2 &lt;email@address2&gt;');
define('ALLOW_GIFT_VOUCHERS_DESC', 'Enable - true<br>Disable - false.');
define('ALLOW_ATTRIBUTES_IN_PRODUCT_EDIT_PAGE_DESC', 'Enable - true<br>Disable - false.');
define('SHOW_SUBCATEGORIES_WHEN_CATEGORIES_HAS_PRODUCTS_DESC', 'Show subcategories when category has products.');
define('SHOW_PDF_DATASHEET_DESC', 'Enable - true<br>Disable - false.');

// Минимальнаые значения

define('ENTRY_FIRST_NAME_MIN_LENGTH_DESC', 'Minimum length of first name');
define('ENTRY_LAST_NAME_MIN_LENGTH_DESC', 'Minimum length of last name');
define('ENTRY_DOB_MIN_LENGTH_DESC', 'Minimum length of date of birth');
define('ENTRY_EMAIL_ADDRESS_MIN_LENGTH_DESC', 'Minimum length of e-mail address');
define('ENTRY_STREET_ADDRESS_MIN_LENGTH_DESC', 'Minimum length of street address');
define('ENTRY_COMPANY_MIN_LENGTH_DESC', 'Minimum length of company name');
define('ENTRY_POSTCODE_MIN_LENGTH_DESC', 'Minimum length of post code');
define('ENTRY_CITY_MIN_LENGTH_DESC', 'Minimum length of city');
define('ENTRY_STATE_MIN_LENGTH_DESC', 'Minimum length of state');
define('ENTRY_TELEPHONE_MIN_LENGTH_DESC', 'Minimum length of telephone number');
define('ENTRY_PASSWORD_MIN_LENGTH_DESC', 'Minimum length of password');
define('CC_OWNER_MIN_LENGTH_DESC', 'Minimum length of credit card owner name');
define('CC_NUMBER_MIN_LENGTH_DESC', 'Minimum length of credit card number');
define('REVIEW_TEXT_MIN_LENGTH_DESC', 'Minimum length of review text');
define('MIN_DISPLAY_BESTSELLERS_DESC', 'Minimum number of best sellers to display');
define('MIN_DISPLAY_ALSO_PURCHASED_DESC', 'Minimum number of products to display in the \'This Customer Also Purchased\' box');
define('MIN_DISPLAY_XSELL_DESC', 'Minimum nuber of X-sell products to display');
define('MIN_ORDER_DESC', 'Minimum order amount.');

// Максимальные значения

define('MAX_PROD_ADMIN_SIDE_DESC', 'Maximum products per page in admin');
define('MAX_ADDRESS_BOOK_ENTRIES_DESC', 'Maximum address book entries a customer is allowed to have');
define('MAX_DISPLAY_SEARCH_RESULTS_DESC', 'Amount of products to list');
define('MAX_DISPLAY_PAGE_LINKS_DESC', 'Number of \'number\' links use for page-sets');
define('MAX_DISPLAY_SPECIAL_PRODUCTS_DESC', 'Maximum number of products on special to display');
define('MAX_DISPLAY_NEW_PRODUCTS_DESC', 'Maximum number of new products to display in a category');
define('MAX_DISPLAY_UPCOMING_PRODUCTS_DESC', 'Maximum number of products expected to display');
define('MAX_DISPLAY_MANUFACTURERS_IN_A_LIST_DESC', 'Used in manufacturers box; when the number of manufacturers exceeds this number, a drop-down list will be displayed instead of the default list');
define('MAX_MANUFACTURERS_LIST_DESC', 'Used in manufacturers box; when this value is \'1\' the classic drop-down list will be used for the manufacturers box. Otherwise, a list-box with the specified number of rows will be displayed.');
define('MAX_DISPLAY_MANUFACTURER_NAME_LEN_DESC', 'Used in manufacturers box; maximum length of manufacturers name to display');
define('MAX_DISPLAY_NEW_REVIEWS_DESC', 'Maximum number of new reviews to display');
define('MAX_RANDOM_SELECT_REVIEWS_DESC', 'How many records to select from to choose one random product review');
define('MAX_RANDOM_SELECT_NEW_DESC', 'How many records to select from to choose one random new product to display');
define('MAX_RANDOM_SELECT_SPECIALS_DESC', 'How many records to select from to choose one random product special to display');
define('MAX_DISPLAY_CATEGORIES_PER_ROW_DESC', 'How many categories to list per row');
define('MAX_DISPLAY_PRODUCTS_NEW_DESC', 'Maximum number of new products to display in new products page');
define('MAX_DISPLAY_BESTSELLERS_DESC', 'Maximum number of best sellers to display');
define('MAX_DISPLAY_ALSO_PURCHASED_DESC', 'Maximum number of products to display in the \'This Customer Also Purchased\' box');
define('MAX_DISPLAY_PRODUCTS_IN_ORDER_HISTORY_BOX_DESC', 'Maximum number of products to display in the customer order history box');
define('MAX_DISPLAY_ORDER_HISTORY_DESC', 'Maximum number of orders to display in the order history page');
define('MAX_DISPLAY_FEATURED_PRODUCTS_DESC', 'Amount of products to on main page');
define('MAX_DISPLAY_FEATURED_PRODUCTS_LISTING_DESC', 'Amount of products to list per page');

// Картинки

define('SMALL_IMAGE_WIDTH_DESC', 'The pixel width of small images');
define('SMALL_IMAGE_HEIGHT_DESC', 'The pixel height of small images');
define('HEADING_IMAGE_WIDTH_DESC', 'The pixel width of heading images');
define('HEADING_IMAGE_HEIGHT_DESC', 'The pixel height of heading images');
define('SUBCATEGORY_IMAGE_WIDTH_DESC', 'The pixel width of subcategory images');
define('SUBCATEGORY_IMAGE_HEIGHT_DESC', 'The pixel height of subcategory images');
define('CONFIG_CALCULATE_IMAGE_SIZE_DESC', 'Calculate the size of images?');
define('IMAGE_REQUIRED_DESC', 'Enable to display broken images. Good for development.');
define('ULTIMATE_ADDITIONAL_IMAGES_DESC', 'Display Additional Images below Product Description?');
define('ULT_THUMB_IMAGE_WIDTH_DESC', 'The pixel width of additional thumb images');
define('ULT_THUMB_IMAGE_HEIGHT_DESC', 'The pixel height of additional thumb images');
define('MEDIUM_IMAGE_WIDTH_DESC', 'The pixel width of medium images');
define('MEDIUM_IMAGE_HEIGHT_DESC', 'The pixel height of medium images');
define('LARGE_IMAGE_WIDTH_DESC', 'The pixel width of large images (Pop-up)<br>(Use 0 for non-specific size)');
define('LARGE_IMAGE_HEIGHT_DESC', 'The pixel height of large images (Pop-up)<br>(Use 0 for non-specific size)');

// Данные покупателя

define('ACCOUNT_GENDER_DESC', 'Display gender in the customers account');
define('ACCOUNT_DOB_DESC', 'Display date of birth in the customers account');
define('ACCOUNT_COMPANY_DESC', 'Display company in the customers account');
define('ACCOUNT_SUBURB_DESC', 'Display suburb in the customers account');
define('ACCOUNT_STATE_DESC', 'Display state in the customers account');
define('ACCOUNT_STREET_ADDRESS_DESC', 'Display Street Address on the Create Account page');
define('ACCOUNT_CITY_DESC', 'Display City on the Create Account page');
define('ACCOUNT_POSTCODE_DESC', 'Display Postcode/ZIP on the Create Account page');
define('ACCOUNT_COUNTRY_DESC', 'Display Country on the Create Account page');
define('ACCOUNT_TELE_DESC', 'Display Telephone on the Create Account page');
define('ACCOUNT_FAX_DESC', 'Display Fax on the Create Account page');
define('ACCOUNT_NEWS_DESC', 'Display Newsletter on the Create Account page');

// Доставка/упаковка

define('SHIPPING_ORIGIN_COUNTRY_DESC', 'Select the country of origin to be used in shipping quotes.');
define('SHIPPING_ORIGIN_ZIP_DESC', 'Enter the Postal Code (ZIP) of the Store to be used in shipping quotes.');
define('SHIPPING_MAX_WEIGHT_DESC', 'Carriers have a max weight limit for a single package. This is a common one for all.');
define('SHIPPING_BOX_WEIGHT_DESC', 'What is the weight of typical packaging of small to medium packages?');
define('SHIPPING_BOX_PADDING_DESC', 'For 10% enter 10');
define('MODULE_ORDER_TOTAL_SHIPPING_FREE_SHIPPING_DESC', 'Do you want to allow free shipping?');
define('MODULE_ORDER_TOTAL_SHIPPING_FREE_SHIPPING_OVER_DESC', 'Provide free shipping for orders over the set amount.');
define('MODULE_ORDER_TOTAL_SHIPPING_DESTINATION_DESC', 'Provide free shipping for orders sent to the set destination.');
define('SHOW_SHIPPING_ESTIMATOR_DESC', 'Show Shipping Estimator on Shopping Cart <br>true= always <br>false= button popup only');
define('SHOW_XSELL_CART_DESC', 'Show Cross-Sell Products on Shopping Cart');

// Вывод товара

define('PRODUCT_LISTING_DISPLAY_STYLE_DESC', 'Choose which Style you would like use to display your products on the Product Listing Pages.<br><br>Whichever style you choose, make sure you configure the appropriate settings for the style of listing you have selected.');
define('PRODUCT_LIST_IMAGE_DESC', 'Do you want to display the Product Image?');
define('PRODUCT_LIST_COL_NUM_DESC', 'Enter the number of columns you would like to display your products on the Product Listing pages.');
define('PRODUCT_LIST_MANUFACTURER_DESC', 'Do you want to display the Product Manufacturer Name?');
define('PRODUCT_LIST_MODEL_DESC', 'Do you want to display the Product Model?');
define('PRODUCT_LIST_NAME_DESC', 'Do you want to display the Product Name?');
define('PRODUCT_LIST_PRICE_DESC', 'Do you want to display the Product Price');
define('PRODUCT_LIST_QUANTITY_DESC', 'Do you want to display the Product Quantity?');
define('PRODUCT_LIST_WEIGHT_DESC', 'Do you want to display the Product Weight?');
define('PRODUCT_LIST_BUY_NOW_DESC', 'Do you want to display the Buy Now column?');
define('PRODUCT_LIST_FILTER_DESC', 'Do you want to display the Category/Manufacturer Filter?');
define('PREV_NEXT_BAR_LOCATION_DESC', 'Sets the location of the Prev/Next Navigation Bar (1-top, 2-bottom, 3-both)');
define('PRODUCT_LIST_INFO_DESC', 'Do you want to display the Short Description?');
define('PRODUCT_SORT_ORDER_DESC', 'Do you want to display the Product Sort Order?');

// Склад

define('STOCK_CHECK_DESC', 'Check to see if sufficent stock is available');
define('STOCK_LIMITED_DESC', 'Subtract product in stock by product orders');
define('STOCK_ALLOW_CHECKOUT_DESC', 'Allow customer to checkout even if there is insufficient stock');
define('STOCK_MARK_PRODUCT_OUT_OF_STOCK_DESC', 'Display something on screen so customer can see which product has insufficient stock');
define('STOCK_REORDER_LEVEL_DESC', 'Define when stock needs to be re-ordered');

// Логи

define('STORE_PAGE_PARSE_TIME_DESC', 'Store the time it takes to parse a page');
define('STORE_PAGE_PARSE_TIME_LOG_DESC', 'Directory and filename of the page parse time log');
define('STORE_PARSE_DATE_TIME_FORMAT_DESC', 'The date format');
define('DISPLAY_PAGE_PARSE_TIME_DESC', 'Display the page parse time (store page parse time must be enabled)');
define('STORE_DB_TRANSACTIONS_DESC', 'Store the database queries in the page parse time log (PHP4 only)');

// Кэш

define('USE_CACHE_DESC', 'Use caching features');
define('DIR_FS_CACHE_DESC', 'The directory where the cached files are saved');

// Настройка E-Mail

define('EMAIL_TRANSPORT_DESC', 'Defines if this server uses a local connection to sendmail or uses an SMTP connection via TCP/IP. Servers running on Windows and MacOS should change this setting to SMTP.');
define('EMAIL_LINEFEED_DESC', 'Defines the character sequence used to separate mail headers.');
define('EMAIL_USE_HTML_DESC', 'Send e-mails in HTML format');
define('ENTRY_EMAIL_ADDRESS_CHECK_DESC', 'Verify e-mail address through a DNS server');
define('SEND_EMAILS_DESC', 'Send out e-mails');

// Скачивание

define('DOWNLOAD_ENABLED_DESC', 'Enable the products download functions.');
define('DOWNLOAD_BY_REDIRECT_DESC', 'Use browser redirection for download. Disable on non-Unix systems.');
define('DOWNLOAD_MAX_DAYS_DESC', 'Set number of days before the download link expires. 0 means no limit.');
define('DOWNLOAD_MAX_COUNT_DESC', 'Set the maximum number of downloads. 0 means no download authorized.');
define('DOWNLOADS_ORDERS_STATUS_UPDATED_VALUE_DESC', 'What orders_status resets the Download days and Max Downloads - Default is 4');
define('DOWNLOADS_CONTROLLER_ON_HOLD_MSG_DESC', 'Downloads Controller Download on hold message');
define('DOWNLOADS_CONTROLLER_ORDERS_STATUS_DESC', 'Downloads Controller Order Status Value - Default=2');

// GZip Компрессия

define('GZIP_COMPRESSION_DESC', 'Enable HTTP GZip compression.');
define('GZIP_LEVEL_DESC', 'Use this compression level 0-9 (0 = minimum, 9 = maximum).');

// Сессии

define('SESSION_WRITE_DIRECTORY_DESC', 'If sessions are file based, store them in this directory.');
define('SESSION_FORCE_COOKIE_USE_DESC', 'Force the use of sessions when cookies are only enabled.');
define('SESSION_CHECK_SSL_SESSION_ID_DESC', 'Validate the SSL_SESSION_ID on every secure HTTPS page request.');
define('SESSION_CHECK_USER_AGENT_DESC', 'Validate the clients browser user agent on every page request.');
define('SESSION_CHECK_IP_ADDRESS_DESC', 'Validate the clients IP address on every page request.');
define('SESSION_BLOCK_SPIDERS_DESC', 'Prevent known spiders from starting a session.');
define('SESSION_RECREATE_DESC', 'Recreate the session to generate a new session ID when the customer logs on or creates an account (PHP >=4.1 needed).');

// HTML Редактор

define('HTML_AREA_WYSIWYG_DISABLE_DESC', 'Enable/Disable TinyMCE box');
define('HTML_AREA_WYSIWYG_DISABLE_JPSY_DESC', 'Enable/Disable JPSY PHP/WYSIWYG ULTRA-IMAGE MANAGER box');
define('HTML_AREA_WYSIWYG_BASIC_PD_DESC', 'Basic Features FASTER<br>Advanced Features SLOWER');
define('HTML_AREA_WYSIWYG_WIDTH_DESC', 'How WIDE should the TinyMCE be in pixels (default: 505)');
define('HTML_AREA_WYSIWYG_HEIGHT_DESC', 'How HIGH should the TinyMCE be in pixels (default: 240)');
define('HTML_AREA_WYSIWYG_DISABLE_EMAIL_DESC', 'Use TinyMCE in Email Customers');
define('HTML_AREA_WYSIWYG_BASIC_EMAIL_DESC', 'Basic Features FASTER<br>Advanced Features SLOWER');
define('EMAIL_AREA_WYSIWYG_WIDTH_DESC', 'How WIDE should the TinyMCE be in pixels (default: 505)');
define('EMAIL_AREA_WYSIWYG_HEIGHT_DESC', 'How HIGH should the TinyMCE be in pixels (default: 140)');
define('HTML_AREA_WYSIWYG_DISABLE_NEWSLETTER_DESC', 'Use TinyMCE in Email Newsletter');
define('HTML_AREA_WYSIWYG_BASIC_NEWSLETTER_DESC', 'Basic Features FASTER<br>Advanced Features SLOWER');
define('NEWSLETTER_EMAIL_WYSIWYG_WIDTH_DESC', 'How WIDE should the TinyMCE be in pixels (default: 505)');
define('NEWSLETTER_EMAIL_WYSIWYG_HEIGHT_DESC', 'How HIGH should the TinyMCE be in pixels (default: 140)');
define('HTML_AREA_WYSIWYG_DISABLE_DEFINE_DESC', 'Use TinyMCE in Define Mainpage');
define('HTML_AREA_WYSIWYG_BASIC_DEFINE_DESC', 'Basic Features FASTER<br>Advanced Features SLOWER');
define('HTML_AREA_WYSIWYG_DISABLE_ARTICLES_DESC', 'Use TinyMCE in articles');
define('HTML_AREA_WYSIWYG_BASIC_ARTICLES_DESC', 'Basic Features FASTER<br>Advanced Features SLOWER');
define('HTML_AREA_WYSIWYG_DISABLE_FAQDESK_DESC', 'Use TinyMCE in faq');
define('HTML_AREA_WYSIWYG_BASIC_FAQDESK_DESC', 'Basic Features FASTER<br>Advanced Features SLOWER');
define('HTML_AREA_WYSIWYG_DISABLE_NEWSDESK_DESC', 'Use TinyMCE in news');
define('HTML_AREA_WYSIWYG_BASIC_NEWSDESK_DESC', 'Basic Features FASTER<br>Advanced Features SLOWER');
define('HTML_AREA_WYSIWYG_DISABLE_INFOPAGES_DESC', 'Use TinyMCE in infopages');
define('HTML_AREA_WYSIWYG_BASIC_INFOPAGES_DESC', 'Basic Features FASTER<br>Advanced Features SLOWER');
define('DEFINE_MAINPAGE_WYSIWYG_WIDTH_DESC', 'How WIDE should the TinyMCE be in pixels (default: 505)');
define('DEFINE_MAINPAGE_WYSIWYG_HEIGHT_DESC', 'How HIGH should the TinyMCE be in pixels (default: 140)');
define('HTML_AREA_WYSIWYG_FONT_TYPE_DESC', 'User Interface Font Type<br>(not saved to product description)');
define('HTML_AREA_WYSIWYG_FONT_SIZE_DESC', 'User Interface Font Size (not saved to product description)<p><b>10 Equals 10 pt');
define('HTML_AREA_WYSIWYG_FONT_COLOUR_DESC', 'White, Black, C0C0C0, Red, FFFFFF, Yellow, Pink, Blue, Gray, 000000, ect..<br>basically any colour or HTML colour code!<br>(not saved to product description)');
define('HTML_AREA_WYSIWYG_BG_COLOUR_DESC', 'White, Black, C0C0C0, Red, FFFFFF, Yellow, Pink, Blue, Gray, 000000, ect..<br>basically any colour or html colour code!<br>(not saved to product description)');
define('HTML_AREA_WYSIWYG_DEBUG_DESC', 'Moniter Live-html, It updates as you type in a 2nd field above it.<p>Disable Debug = 0<br>Enable Debug = 1<br>Default = 0 OFF');

// Партнёрская программа

define('AFFILIATE_EMAIL_ADDRESS_DESC', 'The E Mail Address for the Affiliate Programm');
define('AFFILIATE_PERCENT_DESC', 'Percentage Rate for the Affiliate Program');
define('AFFILIATE_THRESHOLD_DESC', 'Payment Threshold for paying affiliates');
define('AFFILIATE_COOKIE_LIFETIME_DESC', 'How long does the click count (seconds) if customer comes back');
define('AFFILIATE_BILLING_TIME_DESC', 'Orders billed must be at least "30" days old.<br>This is needed if a order is refunded');
define('AFFILIATE_PAYMENT_ORDER_MIN_STATUS_DESC', 'The status an order must have at least, to be billed');
define('AFFILIATE_USE_CHECK_DESC', 'Pay Affiliates with check');
define('AFFILIATE_USE_PAYPAL_DESC', 'Pay Affiliates with PayPal');
define('AFFILIATE_USE_BANK_DESC', 'Pay Affiliates by Bank');
define('AFFILATE_INDIVIDUAL_PERCENTAGE_DESC', 'Allow per Affiliate provision');
define('AFFILATE_USE_TIER_DESC', 'Multilevel Affiliate provisions');
define('AFFILIATE_TIER_LEVELS_DESC', 'Number of Tierlevels');
define('AFFILIATE_TIER_PERCENTAGE_DESC', 'Percent Rates for the tierlevels<br>Example: 8.00;5.00;1.00');

// Модуль Dynamic MoPics

define('IN_IMAGE_BIGIMAGES_DESC', 'The directory inside catalog/ images where your big images are stored.');
define('IN_IMAGE_THUMBS_DESC', 'The directory inside catalog/ images where you extra image thumbs are stored.');
define('MAIN_THUMB_IN_SUBDIR_DESC', 'If you store your main thumb in the thumbnail directory set this true.  If it is in the main image dir, set it false.');
define('THUMBS_PER_ROW_DESC', 'How Many images to show per row.');
define('MORE_PICS_EXT_DESC', 'The addition to your image name for the mopics');
define('BIG_PIC_EXT_DESC', 'This is if you name your main big image like IMAGE_big.jpg, you would put <b>_big</b> here.  Otherwise leave it blank');
define('THUMB_IMAGE_TYPE_DESC', 'The file type of the mopic thumbnails');
define('BIG_IMAGE_TYPE_DESC', 'The file type of the mopic big images');

// Тех. обслуживание

define('DOWN_FOR_MAINTENANCE_DESC', 'Down for Maintenance <br>(true=on false=off)');
define('DOWN_FOR_MAINTENANCE_FILENAME_DESC', 'Down for Maintenance filename Default=down_for_maintenance.php');
define('DOWN_FOR_MAINTENANCE_HEADER_OFF_DESC', 'Down for Maintenance: Hide Header <br>(true=hide false=show)');
define('DOWN_FOR_MAINTENANCE_COLUMN_LEFT_OFF_DESC', 'Down for Maintenance: Hide Column Left <br>(true=hide false=show)');
define('DOWN_FOR_MAINTENANCE_COLUMN_RIGHT_OFF_DESC', 'Down for Maintenance: Hide Column Right <br>(true=hide false=show)r');
define('DOWN_FOR_MAINTENANCE_FOOTER_OFF_DESC', 'Down for Maintenance: Hide Footer <br>(true=hide false=show)');
define('DOWN_FOR_MAINTENANCE_PRICES_OFF_DESC', 'Down for Maintenance: Hide Prices <br>(true=hide false=show)');
define('EXCLUDE_ADMIN_IP_FOR_MAINTENANCE_DESC', 'This IP Address is able to access the website while it is Down For Maintenance (like webmaster)');
define('WARN_BEFORE_DOWN_FOR_MAINTENANCE_DESC', 'Give a WARNING some time before you put your website Down for Maintenance<br>(true=on false=off)<br>If you set the \'Down For Maintenance: ON/OFF\' to true this will automaticly be updated to false');
define('PERIOD_BEFORE_DOWN_FOR_MAINTENANCE_DESC', 'Date and hours for notice before maintenance website, enter date and hours for maintenance website');
define('DISPLAY_MAINTENANCE_TIME_DESC', 'Display when Webmaster has enabled maintenance <br>(true=on false=off)<br>');
define('DISPLAY_MAINTENANCE_PERIOD_DESC', 'Display Website maintenance period <br>(true=on false=off)<br>');
define('TEXT_MAINTENANCE_PERIOD_TIME_DESC', 'Enter Website Maintenance period (hh:mm)');

// Быстрое оформление

define('GUEST_ON_DESC', 'Allow Customers to purchase without an account.');

// Ссылки

define('ENABLE_LINKS_COUNT_DESC', 'Enable links click count.');
define('ENABLE_SPIDER_FRIENDLY_LINKS_DESC', 'Enable spider friendly links (recommended).');
define('LINKS_IMAGE_WIDTH_DESC', 'Maximum width of the links image.');
define('LINKS_IMAGE_HEIGHT_DESC', 'Maximum height of the links image.');
define('LINK_LIST_IMAGE_DESC', 'Do you want to display the Link Image?');
define('LINK_LIST_URL_DESC', 'Do you want to display the Link URL?');
define('LINK_LIST_TITLE_DESC', 'Do you want to display the Link Title?');
define('LINK_LIST_DESCRIPTION_DESC', 'Do you want to display the Link Description?');
define('LINK_LIST_COUNT_DESC', 'Do you want to display the Link Click Count?');
define('ENTRY_LINKS_TITLE_MIN_LENGTH_DESC', 'Minimum length of Link title.');
define('ENTRY_LINKS_URL_MIN_LENGTH_DESC', 'Minimum length of Link URL.');
define('ENTRY_LINKS_DESCRIPTION_MIN_LENGTH_DESC', 'Minimum length of Link Description.');
define('ENTRY_LINKS_CONTACT_NAME_MIN_LENGTH_DESC', 'Minimum length of Link Contact Name..');
define('LINKS_CHECK_PHRASE_DESC', 'Phrase to look for when you perform a link check.');

// Обновление прайса

define('DISPLAY_MODEL_DESC', 'Enable/Disable the model displaying');
define('MODIFY_MODEL_DESC', 'Allow/Disallow the model modification');
define('MODIFY_NAME_DESC', 'Allow/Disallow the name modification?');
define('DISPLAY_STATUT_DESC', 'Allow/Disallow the Statut displaying and modification');
define('DISPLAY_WEIGHT_DESC', 'Allow/Disallow the Weight displaying and modification?');
define('DISPLAY_QUANTITY_DESC', 'Allow/Disallow the Quantity displaying and modification?');
define('DISPLAY_SORT_ORDER_DESC', 'Allow/Disallow the Sort Order displaying and modification?');
define('DISPLAY_ORDER_MIN_DESC', 'Allow/Disallow the Min displaying and modification?');
define('DISPLAY_ORDER_UNITS_DESC', 'Allow/Disallow the Units displaying and modification?');
define('DISPLAY_IMAGE_DESC', 'Allow/Disallow the Image displaying and modification?');
define('DISPLAY_XML_DESC', 'Allow/Disallow the XML displaying and modification?');
define('MODIFY_MANUFACTURER_DESC', 'Allow/Disallow the Manufacturer displaying and modification');
define('MODIFY_TAX_DESC', 'Allow/Disallow the Class of tax displaying and modification');
define('DISPLAY_TVA_OVER_DESC', 'Enable/Disable the displaying of the Price with all tax included when your mouse is over a product');
define('DISPLAY_TVA_UP_DESC', 'Enable/Disable the displaying of the Price with all tax included when you are typing the price?');
define('DISPLAY_PREVIEW_DESC', 'Enable/Disable the display of the link towards the products information page');
define('DISPLAY_EDIT_DESC', 'Enable/Disable the display of the link towards the page where you will be able to edit the product');
define('DISPLAY_MANUFACTURER_DESC', 'Do you want just display the manufacturer ?');
define('DISPLAY_TAX_DESC', 'Do you want just display the tax ?');
define('ACTIVATE_COMMERCIAL_MARGIN_DESC', 'Do you want taht the commercial margin be activate or not ?');

// Отложенные товары

define('MAX_DISPLAY_WISHLIST_PRODUCTS_DESC' , 'How many wish list items to show per page on the main wishlist.php file.');
define('MAX_DISPLAY_WISHLIST_BOX_DESC' , 'How many wish list items to display in the infobox before it changes to a counter.');
define('DISPLAY_WISHLIST_EMAILS_DESC' , 'How many emails to display when the customer emails their wishlist link.');
define('WISHLIST_REDIRECT_DESC' , 'Do you want to redirect back to the product_info.php page when a customer adds a product to their wishlist?');

// Кэш страниц

define('ENABLE_PAGE_CACHE_DESC' , 'Enable the page cache features to reduce server load and faster page renders?');
define('PAGE_CACHE_LIFETIME_DESC' , 'How long to cache the pages (in minutes)?');
define('PAGE_CACHE_DEBUG_MODE_DESC' , 'Turn on the global debug output (located at the footer) ? This affects ALL browsers and is NOT for live shops! You can turn on debug mode JUST for your browser by adding ?debug=1 to your URL.');
define('PAGE_CACHE_DISABLE_PARAMETERS_DESC' , 'In some cases (such as search engine safe URLs) or large number of affiliate referrals will cause excessive page writing.');
define('PAGE_CACHE_DELETE_FILES_DESC' , 'If set to true the next catalog page request will delete all the cache files and then reset this value to false again.');
define('PAGE_CACHE_UPDATE_CONFIG_FILES_DESC' , 'If you have a configuration cache contribution enter the FULL path to the update file.');

// Яндекс маркет

define('YML_NAME_DESC' , 'Store name for Yandex-Market. STORE_NAME used if this field empty.');
define('YML_COMPANY_DESC' , 'Store owner for Yandex-Market. STORE_OWNER used if this field empty.');
define('YML_DELIVERYINCLUDED_DESC' , 'Delivery included?');
define('YML_AVAILABLE_DESC' , 'Product availability?');
define('YML_AUTH_USER_DESC' , 'Login for YML');
define('YML_AUTH_PW_DESC' , 'Password for YML');
define('YML_REFERER_DESC' , 'Add referer to product link (ip or user agent)?');
define('YML_STRIP_TAGS_DESC' , 'Strip html tags?');
define('YML_UTF8_DESC' , 'Encode to windows-1251?');
define('YML_SALES_NOTES_DESC' , 'sales_notes tag value');

// Список категорий на главной странице

define('BRWCAT_ENABLE_TITLE' , 'Enable browse by categories module');
define('BRWCAT_ICON_MODE_TITLE' , 'Category Icon Mode');
define('BRWCAT_SUBCAT_MODE_TITLE' , 'Sub-Category Link Mode');
define('BRWCAT_ICONS_PER_ROW_TITLE' , 'Max number of category Icons per Row');
define('BRWCAT_SUBCAT_BULLET_TITLE' , 'Sub-Category Links Bullet');
define('BRWCAT_SUBCAT_COUNTS_TITLE' , 'Sub-Category Products Count');
define('BRWCAT_NAME_CASE_TITLE' , 'Category Name Case');

define('BRWCAT_ENABLE_DESC' , 'Enable browse by categories module');
define('BRWCAT_ICON_MODE_DESC' , 'Choose between Disabled, Text and Image without or with Caption for Current Level Categories Icons.<br /><b>Note</b>: Image Only mode causes the category name to be displayed on top of its sub-category links.');
define('BRWCAT_SUBCAT_MODE_DESC' , 'Choose between Disabled, Bottom or Right position of Sub-Category Links.');
define('BRWCAT_ICONS_PER_ROW_DESC' , 'Choose how many Current Level Categories to display per row.');
define('BRWCAT_SUBCAT_BULLET_DESC' , 'Select Bullet character to prefix each Sub Category Link.<br /><b>Note</b>: Default bullet is "» ", where the whitespace must be entered has entity &nbsp.');
define('BRWCAT_SUBCAT_COUNTS_DESC' , 'Define sprintf format to display Sub-Category Products count.<br /><b>Note</b>: Default format is (%s) that causes the products count to be displayed surrounded by parentesis. For more information, read the PHP manual for sprintf function.');
define('BRWCAT_NAME_CASE_DESC' , 'Choose between same case, upper case, lower case or title case for Current Level Categories Name.');

// Статьи - Настройки 

define('DISPLAY_NEW_ARTICLES_TITLE', 'Display New Articles Link');
define('NEW_ARTICLES_DAYS_DISPLAY_TITLE', 'Number of Days Display New Articles');
define('MAX_NEW_ARTICLES_PER_PAGE_TITLE', 'Maximum New Articles Per Page');
define('DISPLAY_ALL_ARTICLES_TITLE', 'Display All Articles Link');
define('MAX_ARTICLES_PER_PAGE_TITLE', 'Maximum Articles Per Page');
define('MAX_DISPLAY_UPCOMING_ARTICLES_TITLE', 'Maximum Display Upcoming Articles');
define('ENABLE_ARTICLE_REVIEWS_TITLE', 'Enable Article Reviews');
define('ENABLE_TELL_A_FRIEND_ARTICLE_TITLE', 'Enable Tell a Friend About Article');
define('MIN_DISPLAY_ARTICLES_XSELL_TITLE', 'Minimum Number Cross-Sell Products');
define('MAX_DISPLAY_ARTICLES_XSELL_TITLE', 'Maximum Number Cross-Sell Products');
define('SHOW_ARTICLE_COUNTS_TITLE', 'Show Article Counts');
define('MAX_DISPLAY_AUTHOR_NAME_LEN_TITLE', 'Maximum Length of Author Name');
define('MAX_DISPLAY_AUTHORS_IN_A_LIST_TITLE', 'Authors List Style');
define('MAX_AUTHORS_LIST_TITLE', 'Authors Select Box Size');
define('DISPLAY_AUTHOR_ARTICLE_LISTING_TITLE', 'Display Author in Article Listing');
define('DISPLAY_TOPIC_ARTICLE_LISTING_TITLE', 'Display Topic in Article Listing');
define('DISPLAY_ABSTRACT_ARTICLE_LISTING_TITLE', 'Display Abstract in Article Listing');
define('DISPLAY_DATE_ADDED_ARTICLE_LISTING_TITLE', 'Display Date Added in Article Listing');
define('MAX_ARTICLE_ABSTRACT_LENGTH_TITLE', 'Maximum Article Abstract Length');
define('ARTICLE_LIST_FILTER_TITLE', 'Display Topic/Author Filter');
define('ARTICLE_PREV_NEXT_BAR_LOCATION_TITLE', 'Location of Prev/Next Navigation Bar');
define('ARTICLE_WYSIWYG_ENABLE_TITLE', 'Use TinyMCE Editor?');
define('ARTICLE_MANAGER_WYSIWYG_BASIC_TITLE', 'TinyMCE Basic/Advanced Version?');
define('ARTICLE_MANAGER_WYSIWYG_WIDTH_TITLE', 'TinyMCE Layout Width');
define('ARTICLE_MANAGER_WYSIWYG_HEIGHT_TITLE', 'TinyMCE Layout Height');
define('ARTICLE_MANAGER_WYSIWYG_FONT_TYPE_TITLE', 'TinyMCE Font Type');
define('ARTICLE_MANAGER_WYSIWYG_FONT_SIZE_TITLE', 'TinyMCE Font Size');
define('ARTICLE_MANAGER_WYSIWYG_FONT_COLOUR_TITLE', 'TinyMCE Font Colour');
define('ARTICLE_MANAGER_WYSIWYG_BG_COLOUR_TITLE', 'TinyMCE Background Colour');
define('ARTICLE_MANAGER_WYSIWYG_DEBUG_TITLE', 'TinyMCE Allow Debug Mode?');

define('DISPLAY_NEW_ARTICLES_DESC', 'Display a link to New Articles in the Articles box?');
define('NEW_ARTICLES_DAYS_DISPLAY_DESC', 'The number of days to display New Articles?');
define('MAX_NEW_ARTICLES_PER_PAGE_DESC', 'The maximum number of New Articles to display per page<br>(New Articles page)');
define('DISPLAY_ALL_ARTICLES_DESC', 'Display a link to All Articles in the Articles box?');
define('MAX_ARTICLES_PER_PAGE_DESC', 'The maximum number of Articles to display per page<br>(All Articles and Topic/Author pages)');
define('MAX_DISPLAY_UPCOMING_ARTICLES_DESC', 'Maximum number of articles to display in the Upcoming Articles module');
define('ENABLE_ARTICLE_REVIEWS_DESC', 'Enable registered users to review articles?');
define('ENABLE_TELL_A_FRIEND_ARTICLE_DESC', 'Enable Tell a Friend option in the Article Information page?');
define('MIN_DISPLAY_ARTICLES_XSELL_DESC', 'Minimum number of products to display in the articles Cross-Sell listing.');
define('MAX_DISPLAY_ARTICLES_XSELL_DESC', 'Maximum number of products to display in the articles Cross-Sell listing.');
define('SHOW_ARTICLE_COUNTS_DESC', 'Count recursively how many articles are in each topic');
define('MAX_DISPLAY_AUTHOR_NAME_LEN_DESC', 'The maximum length of the author\'s name for display in the Author box');
define('MAX_DISPLAY_AUTHORS_IN_A_LIST_DESC', 'Used in Authors box. When the number of authors exceeds this number, a drop-down list will be displayed instead of the default list');
define('MAX_AUTHORS_LIST_DESC', 'Used in Authors box. When this value is 1 the classic drop-down list will be used for the authors box. Otherwise, a list-box with the specified number of rows will be displayed.');
define('DISPLAY_AUTHOR_ARTICLE_LISTING_DESC', 'Display the Author in the Article Listing?');
define('DISPLAY_TOPIC_ARTICLE_LISTING_DESC', 'Display the Topic in the Article Listing?');
define('DISPLAY_ABSTRACT_ARTICLE_LISTING_DESC', 'Display the Abstract in the Article Listing?');
define('DISPLAY_DATE_ADDED_ARTICLE_LISTING_DESC', 'Display the Date Added in the Article Listing?');
define('MAX_ARTICLE_ABSTRACT_LENGTH_DESC', 'Sets the maximum length of the Article Abstract to be displayed<br><br>(No. of characters)');
define('ARTICLE_LIST_FILTER_DESC', 'Do you want to display the Topic/Author Filter?');
define('ARTICLE_PREV_NEXT_BAR_LOCATION_DESC', 'Sets the location of the Previous/Next Navigation Bar<br><br>(top; bottom; both)');
define('ARTICLE_WYSIWYG_ENABLE_DESC', 'Use TinyMCE in Articles and Topic/Author Descriptions?');
define('ARTICLE_MANAGER_WYSIWYG_BASIC_DESC', 'Basic Features FASTER<br>Advanced Features SLOWER');
define('ARTICLE_MANAGER_WYSIWYG_WIDTH_DESC', 'How WIDE should the TinyMCE be in pixels (default: 605)');
define('ARTICLE_MANAGER_WYSIWYG_HEIGHT_DESC', 'How HIGH should the TinyMCE be in pixels (default: 300)');
define('ARTICLE_MANAGER_WYSIWYG_FONT_TYPE_DESC', 'User Interface Font Type<br>(not saved to content)');
define('ARTICLE_MANAGER_WYSIWYG_FONT_SIZE_DESC', 'User Interface Font Size<br>(not saved to content)<p><b>10 Equals 10 pt</b>');
define('ARTICLE_MANAGER_WYSIWYG_FONT_COLOUR_DESC', 'White, Black, C0C0C0, Red, FFFFFF, Yellow, Pink, Blue, Gray, 000000, etc...<br>basically any colour or HTML colour code!<br>(not saved to content)');
define('ARTICLE_MANAGER_WYSIWYG_BG_COLOUR_DESC', 'White, Black, C0C0C0, Red, FFFFFF, Yellow, Pink, Blue, Gray, 000000, etc...<br>basically any colour or html colour code!<br>(not saved to content)');
define('ARTICLE_MANAGER_WYSIWYG_DEBUG_DESC', 'Moniter Live-html, It updates as you type in a 2nd field above it.<p>Disable Debug = 0<br>Enable Debug = 1<br>Default = 0 OFF');

// Установка модулей

define('DIR_FS_CIP_TITLE' , 'Contribution Directory');
define('DIR_FS_CIP_DESC' , 'Location of contribution files');
define('ALLOW_SQL_BACKUP_TITLE' , 'Backup Database Before Install Each CIP');
define('ALLOW_SQL_BACKUP_DESC' , 'Choose TRUE and database will be backuped before each CIP install.<br />Do backup if database isn\'t huge or for debugging.');
define('ALLOW_SQL_RESTORE_TITLE' , 'Restore Database When Remove Each CIP');
define('ALLOW_SQL_RESTORE_DESC' , 'Choose TRUE and files will be restored from backup.<br />Backup doesn\'t contain changes made after CIP installation.<br />Use restoring only when build a new store or debug.');
define('ALLOW_FILES_BACKUP_TITLE' , 'Backup Files Before Install Each CIP');
define('ALLOW_FILES_BACKUP_DESC' , 'Choose TRUE and files will be backuped.<br>Backup contain only files which CIP will modify.<br />We recommend to do a files backup.');
define('ALLOW_FILES_RESTORE_TITLE' , 'Restore Files When Remove Each CIP');
define('ALLOW_FILES_RESTORE_DESC' , 'Choose TRUE and files will be restored from backup.<br />Backup doesn\'t contain changes made after CIP installation.<br />Use restoring only when build a new store or debug.');
define('ALLOW_OVERWRITE_MODIFIED_TITLE' , 'Allow Overwrite Existing Modified Files');
define('ALLOW_OVERWRITE_MODIFIED_DESC' , 'Choose TRUE and ADDFILE will overwrite even files with changes.<br />All changes will be lost. Use only for testing and debugging.');
define('TEXT_LINK_FORUM_TITLE' , 'Forum Link');
define('TEXT_LINK_FORUM_DESC' , 'URL for support forum at osCommerce.org');
define('TEXT_LINK_CONTR_TITLE' , 'URL to the Contribution\'s page');
define('TEXT_LINK_CONTR_DESC' , 'URL for contrib\'s page at osCommerce.org');
define('ALWAYS_DISPLAY_REMOVE_BUTTON_TITLE' , 'Always Display Remove-Button');
define('ALWAYS_DISPLAY_REMOVE_BUTTON_DESC' , 'Choose TRUE and REMOVE button will be displayed for both installed and NOT installed CIPs.');
define('ALWAYS_DISPLAY_INSTALL_BUTTON_TITLE' , 'Always Display Install-Button');
define('ALWAYS_DISPLAY_INSTALL_BUTTON_DESC' , 'Choose TRUE and INSTALL button will be displayed for both installed and NOT installed CIPs.');
define('SHOW_PACK_BUTTONS_TITLE' , 'Show Pack and Unpack Buttons');
define('SHOW_PACK_BUTTONS_DESC' , 'Choose TRUE and Pack and Unpack Buttons will be shown.');
define('SHOW_PERMISSIONS_COLUMN_TITLE' , 'Show Permissions Column');
define('SHOW_PERMISSIONS_COLUMN_DESC' , 'Choose TRUE and permissions column will be shown.');
define('SHOW_USER_GROUP_COLUMN_TITLE' , 'Show User/Group Column');
define('SHOW_USER_GROUP_COLUMN_DESC' , 'Choose TRUE and User/Group column will be shown.');
define('SHOW_UPLOADER_COLUMN_TITLE' , 'Show Uploader Column');
define('SHOW_UPLOADER_COLUMN_DESC' , 'Choose TRUE and Uploader column will be shown.');
define('SHOW_UPLOADED_COLUMN_TITLE' , 'Show Date Uploaded Column');
define('SHOW_UPLOADED_COLUMN_DESC' , 'Choose TRUE and Date Uploaded column will be shown.');
define('SHOW_SIZE_COLUMN_TITLE' , 'Show Size Column');
define('SHOW_SIZE_COLUMN_DESC' , 'Choose TRUE and Size column will be shown.');
define('USE_LOG_SYSTEM_TITLE' , 'Use Log System');
define('USE_LOG_SYSTEM_DESC' , 'Choose TRUE and all actions will be logged into file in backups folder.');
define('MAX_UPLOADED_FILESIZE_TITLE' , 'Maximum filesize for uploaded CIP');
define('MAX_UPLOADED_FILESIZE_DESC' , 'Set maximum filesize in bytes for cip archives you can upload.');

define('MAX_QTY_IN_CART_TITLE' , 'Product Quantities In Shopping Cart');
define('MAX_QTY_IN_CART_DESC' , 'Maximum number of product quantities that can be added to the shopping cart (0 for no limit)');

// Order Editor

define('ORDER_EDITOR_PAYMENT_DROPDOWN_TITLE','Display the Payment Method dropdown?');
define('ORDER_EDITOR_PAYMENT_DROPDOWN_DESC','Based on this selection Order Editor will display the payment method as a dropdown menu (true) or as an input field (false).');
define('ORDER_EDITOR_USE_SPPC_TITLE','Use prices from Separate Pricing Per Customer?');
define('ORDER_EDITOR_USE_SPPC_DESC','This should be set to true only if SPPC is installed.');
define('ORDER_EDITOR_USE_AJAX_TITLE','Allow the use of AJAX to update order information?');
define('ORDER_EDITOR_USE_AJAX_DESC','This must be set to false if using a browser on which JavaScript is disabled or not available.');
define('ORDER_EDITOR_CREDIT_CARD_TITLE','Select your credit card payment method');
define('ORDER_EDITOR_CREDIT_CARD_DESC','Order Editor will display the credit card fields when this payment method is selected.');

define('MAX_REVIEWS_TITLE','Maximum number of reviews on product info page');
define('MAX_REVIEWS_DESC','Maximum number of reviews displayed on product info page.');

define('ENABLE_TABS_TITLE','Use tabs in admin');
define('ENABLE_TABS_DESC','Enable tabs in admin');

define('MASTER_PASS_TITLE','Master Password');
define('MASTER_PASS_DESC','This password will allow you to login to any customers account.');

define('OPTIONS_AS_IMAGES_ENABLED_TITLE','Enable options as images');
define('OPTIONS_AS_IMAGES_ENABLED_DESC','');
define('OPTIONS_IMAGES_NUMBER_PER_ROW_TITLE','Images per row');
define('OPTIONS_IMAGES_NUMBER_PER_ROW_DESC','');
define('OPTIONS_IMAGES_WIDTH_TITLE','Image width');
define('OPTIONS_IMAGES_WIDTH_DESC','');
define('OPTIONS_IMAGES_HEIGHT_TITLE','Image height');
define('OPTIONS_IMAGES_HEIGHT_DESC','');
define('OPTIONS_IMAGES_CLICK_ENLARGE_TITLE','Enlarge image');
define('OPTIONS_IMAGES_CLICK_ENLARGE_DESC','');

define('SET_BOX_CATEGORIES_TITLE', 'Categories');
define('SET_BOX_INFORMATION_TITLE', 'Information');
define('SET_BOX_MANUFACTURERS_TITLE', 'Manufacturers');
define('SET_BOX_LATESTNEWS_TITLE', 'Latest news');
define('SET_BOX_SEARCH_TITLE', 'Search');
define('SET_BOX_WHATSNEW_TITLE', 'Whats new');
define('SET_BOX_FEATURED_TITLE', 'Featured');
define('SET_BOX_SHOP_BY_PRICE_TITLE', 'Shop by price');
define('SET_BOX_ARTICLES_TITLE', 'Articles');
define('SET_BOX_AUTHORS_TITLE', 'Authors');
define('SET_BOX_LINKS_TITLE', 'Links');
define('SET_BOX_CART_TITLE', 'Cart');
define('SET_BOX_DOWNLOADS_TITLE', 'Downloads');
define('SET_BOX_HELP_TITLE', 'Help');
define('SET_BOX_LOGIN_TITLE', 'Login');
define('SET_BOX_WISHLIST_TITLE', 'Wishlist');
define('SET_BOX_AFFILIATE_TITLE', 'Affiliate');
define('SET_BOX_FAQ_TITLE', 'Faqdesk categories');
define('SET_BOX_FAQ_LATEST_TITLE', 'Latest faqs');
define('SET_BOX_POLLS_TITLE', 'Polls');
define('SET_BOX_MANUFACTURERS_INFO_TITLE', 'Manufacturer info');
define('SET_BOX_ORDER_HISTORY_TITLE', 'Orders history');
define('SET_BOX_BESTSELLERS_TITLE', 'Bestsellers');
define('SET_BOX_NOTIFICATIONS_TITLE', 'Notifications');
define('SET_BOX_SET_BOX_TELL_A_FRIEND_TITLE', 'Tell a friend');
define('SET_BOX_SPECIALS_TITLE', 'Specials');
define('SET_BOX_REVIEWS_TITLE', 'Reviews');
define('SET_BOX_LANGUAGES_TITLE', 'Languages');
define('SET_BOX_CURRENCIES_TITLE', 'Currencies');

define('SET_BOX_CATEGORIES_DESC', 'Enable/Disable box.');
define('SET_BOX_INFORMATION_DESC', 'Enable/Disable box.');
define('SET_BOX_MANUFACTURERS_DESC', 'Enable/Disable box.');
define('SET_BOX_LATESTNEWS_DESC', 'Enable/Disable box.');
define('SET_BOX_SEARCH_DESC', 'Enable/Disable box.');
define('SET_BOX_WHATSNEW_DESC', 'Enable/Disable box.');
define('SET_BOX_FEATURED_DESC', 'Enable/Disable box.');
define('SET_BOX_SHOP_BY_PRICE_DESC', 'Enable/Disable box.');
define('SET_BOX_ARTICLES_DESC', 'Enable/Disable box.');
define('SET_BOX_AUTHORS_DESC', 'Enable/Disable box.');
define('SET_BOX_LINKS_DESC', 'Enable/Disable box.');
define('SET_BOX_CART_DESC', 'Enable/Disable box.');
define('SET_BOX_DOWNLOADS_DESC', 'Enable/Disable box.');
define('SET_BOX_HELP_DESC', 'Enable/Disable box.');
define('SET_BOX_LOGIN_DESC', 'Enable/Disable box.');
define('SET_BOX_WISHLIST_DESC', 'Enable/Disable box.');
define('SET_BOX_AFFILIATE_DESC', 'Enable/Disable box.');
define('SET_BOX_FAQ_DESC', 'Enable/Disable box.');
define('SET_BOX_FAQ_LATEST_DESC', 'Enable/Disable box.');
define('SET_BOX_POLLS_DESC', 'Enable/Disable box.');
define('SET_BOX_MANUFACTURERS_INFO_DESC', 'Enable/Disable box.');
define('SET_BOX_ORDER_HISTORY_DESC', 'Enable/Disable box.');
define('SET_BOX_BESTSELLERS_DESC', 'Enable/Disable box.');
define('SET_BOX_NOTIFICATIONS_DESC', 'Enable/Disable box.');
define('SET_BOX_SET_BOX_TELL_A_FRIEND_DESC', 'Enable/Disable box.');
define('SET_BOX_SPECIALS_DESC', 'Enable/Disable box.');
define('SET_BOX_REVIEWS_DESC', 'Enable/Disable box.');
define('SET_BOX_LANGUAGES_DESC', 'Enable/Disable box.');
define('SET_BOX_CURRENCIES_DESC', 'Enable/Disable box.');

//Products Specifications

define('SPECIFICATIONS_PRODUCTS_HEAD_TITLE', '<b>Products Info Page</b>');
define('SPECIFICATIONS_PRODUCTS_HEAD_DESC', 'Products Comparison page');
define('SPECIFICATIONS_MINIMUM_PRODUCTS_TITLE', 'Minimum Spec Products');
define('SPECIFICATIONS_MINIMUM_PRODUCTS_DESC', 'The minimum number of specifications needed to have the Specifications box show up on the Product Info page');
define('SPECIFICATIONS_SHOW_NAME_PRODUCTS_TITLE', 'Show Specification Name');
define('SPECIFICATIONS_SHOW_NAME_PRODUCTS_DESC', 'Show the name of the specification in the box');
define('SPECIFICATIONS_SHOW_TITLE_PRODUCTS_TITLE', 'Show Spec Box Title');
define('SPECIFICATIONS_SHOW_TITLE_PRODUCTS_DESC', 'Show the title above the Specifications box');
define('SPECIFICATIONS_BOX_FRAME_STYLE_TITLE', 'Spec Box Frame Style');
define('SPECIFICATIONS_BOX_FRAME_STYLE_DESC', 'Show the Specifications in a standard box (Stock), a simple outline box (Simple), no box (Plain), or a tabbed content box (Tabs)');
define('SPECIFICATIONS_REVIEWS_TAB_TITLE', 'Show Reviews Tab');
define('SPECIFICATIONS_REVIEWS_TAB_DESC', 'Show the Reviews tab');
define('SPECIFICATIONS_MAX_REVIEWS_TITLE', 'Max Reviews in Tab');
define('SPECIFICATIONS_MAX_REVIEWS_DESC', 'The maxmum number of reviews that can show in the Reviews tab');
define('SPECIFICATIONS_QUESTION_TAB_TITLE', 'Show Question Tab');
define('SPECIFICATIONS_QUESTION_TAB_DESC', 'Show the Ask a Question tab');

define('SPECIFICATIONS_COMPARISON_HEAD_TITLE', '<b>Products Comparison Page</b>');
define('SPECIFICATIONS_COMPARISON_HEAD_DESC', 'Products Comparison page');
define('SPECIFICATIONS_MINIMUM_COMPARISON_TITLE', 'Minimum Spec Comparison');
define('SPECIFICATIONS_MINIMUM_COMPARISON_DESC', 'The minimum number of products having specifications needed to have the Comparison page show up for a Category');
define('SPECIFICATIONS_COMP_LINK_TITLE', 'Comparison Link in Index');
define('SPECIFICATIONS_COMP_LINK_DESC', 'Show a link to the Comparison table on the Index page');
define('SPECIFICATIONS_COMP_TABLE_ROW_TITLE', 'Comparison Row in Table');
define('SPECIFICATIONS_COMP_TABLE_ROW_DESC', 'Show a link to the Comparison in the Products list on the Index page');
define('SPECIFICATIONS_BOX_COMPARISON_TITLE', 'Show Comparison');
define('SPECIFICATIONS_BOX_COMPARISON_DESC', 'Show the Comparison table in a separate page');
define('SPECIFICATIONS_BOX_COMP_INDEX_TITLE', 'Comparison in Index');
define('SPECIFICATIONS_BOX_COMP_INDEX_DESC', 'Show the Comparison table instead of the Products list in the Index page');
define('SPECIFICATIONS_COMP_SUFFIX_TITLE', 'Comparison Suffix in Header');
define('SPECIFICATIONS_COMP_SUFFIX_DESC', 'Show the Suffix in the Comparison table header (Otherwise in each field)');
define('SPECIFICATIONS_COMPARISON_STYLE_TITLE', 'Comparison Box Style');
define('SPECIFICATIONS_COMPARISON_STYLE_DESC', 'Show the Specifications in a standard box (Stock), a simple outline box (Simple), or no box (Plain)');
define('SPECIFICATIONS_COMBO_MFR_TITLE', 'Spec Combo Manufacturer');
define('SPECIFICATIONS_COMBO_MFR_DESC', 'Show the Manufacturer in a special combo box (0 = No, 1-9 = Sort Order)');
define('SPECIFICATIONS_COMBO_WEIGHT_TITLE', 'Spec Combo Weight');
define('SPECIFICATIONS_COMBO_WEIGHT_DESC', 'Show the Weight in a special combo box (0 = No, 1-9 = Sort Order)');
define('SPECIFICATIONS_COMBO_PRICE_TITLE', 'Spec Combo Price');
define('SPECIFICATIONS_COMBO_PRICE_DESC', 'Show the Price in a special combo box (0 = No, 1-9 = Sort Order)');
define('SPECIFICATIONS_COMBO_MODEL_TITLE', 'Spec Combo Model');
define('SPECIFICATIONS_COMBO_MODEL_DESC', 'Show the Model number in a special combo box (0 = No, 1-9 = Sort Order)');
define('SPECIFICATIONS_COMBO_IMAGE_TITLE', 'Spec Combo Image');
define('SPECIFICATIONS_COMBO_IMAGE_DESC', 'Show the Image in a special combo box (0 = No, 1-9 = Sort Order)');
define('SPECIFICATIONS_COMBO_NAME_TITLE', 'Spec Combo Name');
define('SPECIFICATIONS_COMBO_NAME_DESC', 'Show the Name in a special combo box (0 = No, 1-9 = Sort Order)');
define('SPECIFICATIONS_COMBO_BUY_NOW_TITLE', 'Spec Combo Buy Now');
define('SPECIFICATIONS_COMBO_BUY_NOW_DESC', 'Show the Buy Now in a special combo box (0 = No, 1-9 = Sort Order)');

define('SPECIFICATIONS_FILTERS_HEAD_TITLE', '<b>Products Filters</b>');
define('SPECIFICATIONS_FILTERS_HEAD_DESC', 'Products Filters');
define('SPECIFICATIONS_FILTERS_MODULE_TITLE', 'Show Filters Module');
define('SPECIFICATIONS_FILTERS_MODULE_DESC', 'Show the Filters module in the center column (main part of the page)');
define('SPECIFICATIONS_FILTERS_BOX_TITLE', 'Show Filters Box');
define('SPECIFICATIONS_FILTERS_BOX_DESC', 'Show the Filters box in the side column');
define('SPECIFICATIONS_FILTER_MINIMUM_TITLE', 'Minimum Spec Filter');
define('SPECIFICATIONS_FILTER_MINIMUM_DESC', 'The minimum number of filters needed to have the Filters box show up in the column');
define('SPECIFICATIONS_FILTER_SUBCATEGORIES_TITLE', 'Filter Subcategories');
define('SPECIFICATIONS_FILTER_SUBCATEGORIES_DESC', 'Include subcategories in the filter results');
define('SPECIFICATIONS_FILTER_SHOW_COUNT_TITLE', 'Filter Show Count');
define('SPECIFICATIONS_FILTER_SHOW_COUNT_DESC', 'Show the number of products that the filter would return');
define('SPECIFICATIONS_FILTER_NO_RESULT_TITLE', 'Filter No Result');
define('SPECIFICATIONS_FILTER_NO_RESULT_DESC', 'What to show for a filter that would return no result.');
define('SPECIFICATIONS_FILTER_BREADCRUMB_TITLE', 'Filter Show Breadcrumb');
define('SPECIFICATIONS_FILTER_BREADCRUMB_DESC', 'Show currently applied filters in the Breadcrumb trail with option to remove');
define('SPECIFICATIONS_FILTER_IMAGE_WIDTH_TITLE', 'Filter Image Width');
define('SPECIFICATIONS_FILTER_IMAGE_WIDTH_DESC', 'Set the width of the images displayed as filters in the filter box.');
define('SPECIFICATIONS_FILTER_IMAGE_HEIGHT_TITLE', 'Filter Image Height');
define('SPECIFICATIONS_FILTER_IMAGE_HEIGHT_DESC', 'Set the height of the images displayed as filters in the filter box.');

define('SET_BOX_FILTERS_TITLE', 'Filters');
define('SET_BOX_FILTERS_DESC', 'Enable/Disable box.');

define('EMAIL_SMTP_SERVER_TITLE' , 'SMTP server');
define('EMAIL_SMTP_SERVER_DESC' , 'Defines the smtp server.');
define('EMAIL_SMTP_PORT_TITLE' , 'SMTP server: Port');
define('EMAIL_SMTP_PORT_DESC' , 'Defines the smtp server port.');
define('EMAIL_SMTP_AUTH_TITLE' , 'SMTP Authorization');
define('EMAIL_SMTP_AUTH_DESC' , 'SMTP Authorization.');
define('EMAIL_SMTP_USERNAME_TITLE' , 'SMTP server: Username');
define('EMAIL_SMTP_USERNAME_DESC' , 'Defines the smtp server username.');
define('EMAIL_SMTP_PASSWORD_TITLE' , 'SMTP server: Password');
define('EMAIL_SMTP_PASSWORD_DESC' , 'Defines the smtp server password.');

define('ENABLE_MAP_TAB_TITLE','Show map tab at order info page');
define('ENABLE_MAP_TAB_DESC','');
define('MAP_API_KEY_TITLE','Yandex Maps API Key');
define('MAP_API_KEY_DESC','Your API Key.');

define('USE_EMAIL_QUEUE_TITLE','Use Email Queue');
define('USE_EMAIL_QUEUE_DESC','Process the emails via the Email Queue');
define('HOLD_EMAIL_QUEUE_TITLE','Hold Email Queue');
define('HOLD_EMAIL_QUEUE_DESC','Hold all emails in the Email Queue');

define('SITE_TIME_ZONE_TITLE', 'Site Time Zone');
define('SITE_TIME_ZONE_DESC', 'Site time zone');

define('DOWNLOADS_AVAILABLE_STATUS_TITLE', 'PIN Show status');
define('DOWNLOADS_AVAILABLE_STATUS_DESC', 'Order must have this or better status');

define('FILTERS_MAIN_PAGE_TITLE', 'Show Filters on the Main Page');
define('FILTERS_MAIN_PAGE_DESC', '');

define('SMART_CHECKOUT_TITLE', 'Enable Smart Checkout');
define('SMART_CHECKOUT_DESC', 'Do you want to enable Smart Checkout');
define('SC_CREATE_ACCOUNT_REQUIRED_TITLE', 'Create Account required');
define('SC_CREATE_ACCOUNT_REQUIRED_DESC', 'If enabled, customers need to create an account to process an order');
define('SC_CREATE_ACCOUNT_CHECKOUT_PAGE_TITLE', 'Create Account option at checkout page');
define('SC_CREATE_ACCOUNT_CHECKOUT_PAGE_DESC', 'If enabled, customers have always the option to create an account at the checkout page');
define('SC_HIDE_SHIPPING_TITLE', 'Hide Shipping');
define('SC_HIDE_SHIPPING_DESC', 'If you have only one shipping method, there is no need to show the shipping part. If enabled and only one shipping method is active it hides the shipping part. Recommended as checkout gets even simpler.');
define('SC_HIDE_COMMENT_TITLE', 'Hide Comment');
define('SC_HIDE_COMMENT_DESC', 'Do you want to hide the comment box');
define('SC_COUNTER_ENABLED_TITLE', 'Counter Enabled');
define('SC_COUNTER_ENABLED_DESC', 'If enabled it will show the steps in numbers to proceed an order');
define('SC_EMAIL_LOGIN_DATA_TITLE', 'Send login data');
define('SC_EMAIL_LOGIN_DATA_DESC', 'If enabled it includes the username and password to the welcome email.');
define('SC_CONFIRMATION_PAGE_TITLE', 'Confirmation Page');
define('SC_CONFIRMATION_PAGE_DESC', 'Do you want to show extra confirmation page?');

?>