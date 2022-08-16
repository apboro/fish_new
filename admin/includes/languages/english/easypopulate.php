<?php
/*
  $Id: easypopulate.php,v 1.4 2004/09/21  zip1 Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 20042 osCommerce

  Released under the GNU General Public License
*/

define('HEADING_TITLE', 'Easy Populate');

define('EASYPOPULATE_TAB_IMPORT','Import');
define('EASYPOPULATE_TAB_IMPORT_TEMP','Import from temp dir');
define('EASYPOPULATE_TAB_SPLIT','Split');
define('EASYPOPULATE_TAB_EXPORT','Export');
define('EASYPOPULATE_TAB_QUICK_LINKS','Quick Links');
define('EASYPOPULATE_TAB_INFO','Info');

define('TEXT_EASYPOPULATE_PLEASE','Please');
define('TEXT_EASYPOPULATE_BACKUP_TEXT','backup your database');
define('TEXT_EASYPOPULATE_BACKUP_TEXT1','before performing any Easy Populate operations!');

define('TEXT_EASYPOPULATE_BACKUP_BUTTON','Quick Backup');

define('EASY_UPLOAD_EP_FILE', 'Import');
define('EASY_INSERT', 'Insert into DB');

define('TEXT_EASYPOPULATE_NORMAL','Normal');
define('TEXT_EASYPOPULATE_ADD','Add New Only');
define('TEXT_EASYPOPULATE_UPDATE','Update Only');
define('TEXT_EASYPOPULATE_DELETE','Delete Only');

define('EASY_IMPORT_TEMP_DIR', 'Import EP file from Dir');
define('EASY_SPLIT_EP_FILE', 'Upload and Split a EP File');

define('EASYPOPULATE_BUTTON_SPLIT','Split');

define('TEXT_EASYPOPULATE_EXPORT','Export EP or Froogle Products Fil');

define('TEXT_EASYPOPULATE_ON_THE_FLY','Download on-the-fly');
define('TEXT_EASYPOPULATE_CREATE_THEN_DOWNLOAD','Create then Download');
define('TEXT_EASYPOPULATE_CREATE_IN_TEMP','Create in Temp Dir');
define('TEXT_EASYPOPULATE_TYPE','a');
define('TEXT_EASYPOPULATE_COMPLETE','Complete');
define('TEXT_EASYPOPULATE_CUSTOM','Custom');
define('TEXT_EASYPOPULATE_PRICE_QTY','Price/Qty');
define('TEXT_EASYPOPULATE_CATEGORIES','Categories');
define('TEXT_EASYPOPULATE_ATTRIBUTES','Attributes');
define('TEXT_EASYPOPULATE_FROOGLE','Froogle');
define('TEXT_EASYPOPULATE_FILE_FORMAT',' file (model number is always included).');

define('TEXT_EASYPOPULATE_LABEL_NAME','name');
define('TEXT_EASYPOPULATE_LABEL_DESC','description');
define('TEXT_EASYPOPULATE_LABEL_URL','url');
define('TEXT_EASYPOPULATE_LABEL_IMAGE','image');
define('TEXT_EASYPOPULATE_LABEL_ATTRIBUTES','attributes');
define('TEXT_EASYPOPULATE_LABEL_CATEGORIES','categories');
define('TEXT_EASYPOPULATE_LABEL_MANUFACTURERS','manufacturer');
define('TEXT_EASYPOPULATE_LABEL_PRICE','price');
define('TEXT_EASYPOPULATE_LABEL_QUANTITY','quantity');
define('TEXT_EASYPOPULATE_LABEL_WEIGHT','weight');
define('TEXT_EASYPOPULATE_LABEL_TAX_CLASS','tax class');
define('TEXT_EASYPOPULATE_LABEL_AVAILABLE','available');
define('TEXT_EASYPOPULATE_LABEL_DATE_ADDED','date added');
define('TEXT_EASYPOPULATE_LABEL_STATUS','status');
define('TEXT_EASYPOPULATE_LABEL_SPECIALS','specials');
define('TEXT_EASYPOPULATE_LABEL_ADD_IMAGES','add images');
define('TEXT_EASYPOPULATE_LABEL_VENDOR','vendor');
define('TEXT_EASYPOPULATE_LABEL_XSELL','xsell');
define('TEXT_EASYPOPULATE_LABEL_QUANTITY_MIN','min quantity');
define('TEXT_EASYPOPULATE_LABEL_QUANTITY_UNITS','order units');
define('TEXT_EASYPOPULATE_LABEL_SORT','sort order');
define('TEXT_EASYPOPULATE_LABEL_SHORT_DESCRIPTION','short description');

define('TEXT_EASYPOPULATE_FILTER_BY','Filter by: ');
define('TEXT_EASYPOPULATE_FILTER_CATEGORY','- Category -');
define('TEXT_EASYPOPULATE_FILTER_MANUFACTURER','- Manufacturer -');
define('TEXT_EASYPOPULATE_FILTER_STATUS','- Status -');
define('TEXT_EASYPOPULATE_FILTER_STATUS_ACTIVE','Active');
define('TEXT_EASYPOPULATE_FILTER_STATUS_DISABLED','Disabled');
define('TEXT_EASYPOPULATE_BUILD_BUTTON','Build File');

define('TEXT_EASYPOPULATE_QUICK_LINKS','Quick Links');
define('TEXT_EASYPOPULATE_QUICK_LINKS_1','Create then Download Files');
define('TEXT_EASYPOPULATE_QUICK_LINKS_2','Create entire file in server memory then stream download after completed.');
define('TEXT_EASYPOPULATE_QUICK_LINKS_3','Download <b>Complete');
define('TEXT_EASYPOPULATE_QUICK_LINKS_4',' w/SPPC');
define('TEXT_EASYPOPULATE_QUICK_LINKS_5','file to edit');
define('TEXT_EASYPOPULATE_QUICK_LINKS_6','file in temp dir');
define('TEXT_EASYPOPULATE_QUICK_LINKS_7','Download <b>Extra Fields</b>');
define('TEXT_EASYPOPULATE_QUICK_LINKS_8','Download <b>Model/Price/Qty');
define('TEXT_EASYPOPULATE_QUICK_LINKS_9','Download <b>Model/Category');
define('TEXT_EASYPOPULATE_QUICK_LINKS_10','Download <b>Froogle');
define('TEXT_EASYPOPULATE_QUICK_LINKS_11','Download <b>Model/Attributes');
define('TEXT_EASYPOPULATE_QUICK_LINKS_12','file');
define('TEXT_EASYPOPULATE_QUICK_LINKS_13','Create Files in Temp Dir');
define('TEXT_EASYPOPULATE_QUICK_LINKS_14','Create entire file in server memory then save to Temp Dir after completed.');
define('TEXT_EASYPOPULATE_QUICK_LINKS_15','Create <b>Complete</b>');
define('TEXT_EASYPOPULATE_QUICK_LINKS_16','Create <b>Model/Price/Qty</b>');
define('TEXT_EASYPOPULATE_QUICK_LINKS_17','Create <b>Model/Category</b>');
define('TEXT_EASYPOPULATE_QUICK_LINKS_18','Create <b>Froogle</b>');
define('TEXT_EASYPOPULATE_QUICK_LINKS_19','Create <b>Model/Attributes</b>');
define('TEXT_EASYPOPULATE_QUICK_LINKS_20','Temp Directory:');
define('TEXT_EASYPOPULATE_QUICK_LINKS_21','Temp Dir is Writable');
define('TEXT_EASYPOPULATE_QUICK_LINKS_22','Temp Dir is NOT Writable');
define('TEXT_EASYPOPULATE_QUICK_LINKS_23','Magic Quotes is:');
define('TEXT_EASYPOPULATE_QUICK_LINKS_24','register_globals is:');
define('TEXT_EASYPOPULATE_QUICK_LINKS_25','Split files on:');
define('TEXT_EASYPOPULATE_QUICK_LINKS_26','Model Num Size:');
define('TEXT_EASYPOPULATE_QUICK_LINKS_27','Price with tax:');
define('TEXT_EASYPOPULATE_QUICK_LINKS_28','Calc Precision:');
define('TEXT_EASYPOPULATE_QUICK_LINKS_29','Replace quotes:');
define('TEXT_EASYPOPULATE_QUICK_LINKS_30','Field separator:');
define('TEXT_EASYPOPULATE_QUICK_LINKS_31','tab');
define('TEXT_EASYPOPULATE_QUICK_LINKS_32','comma');
define('TEXT_EASYPOPULATE_QUICK_LINKS_33','semi-colon');
define('TEXT_EASYPOPULATE_QUICK_LINKS_34','tilde');
define('TEXT_EASYPOPULATE_QUICK_LINKS_35','dash');
define('TEXT_EASYPOPULATE_QUICK_LINKS_36','splat');
define('TEXT_EASYPOPULATE_QUICK_LINKS_37','Excel safe output:');
define('TEXT_EASYPOPULATE_QUICK_LINKS_38','Preserve tab/cr/lf:');
define('TEXT_EASYPOPULATE_QUICK_LINKS_39','Category depth:');
define('TEXT_EASYPOPULATE_QUICK_LINKS_40','Enable attributes:');
define('TEXT_EASYPOPULATE_QUICK_LINKS_41','SEF Froogle URLS:');
define('TEXT_EASYPOPULATE_QUICK_LINKS_42','on');
define('TEXT_EASYPOPULATE_QUICK_LINKS_43','off');
define('TEXT_EASYPOPULATE_QUICK_LINKS_44','records');

define('EASY_ERROR_1', 'Strange but there is no default language to work... That may not happen, just in case... ');
define('EASY_FILE_LOCATE', 'You can get your file in the Tools/Files under ');

define('TEXT_EASYPOPULATE_CLEAR','Clear');

define('EASY_UPLOAD_FILE', 'File uploaded. ');
define('EASY_UPLOAD_TEMP', 'Temporary filename: ');
define('EASY_UPLOAD_USER_FILE', 'User filename: ');
define('EASY_SIZE', 'Size: ');
define('EASY_FILENAME', 'Filename: ');

define('EASY_ERROR_7', 'Can not open file for reading. Script will terminate.<br />');

define('EASY_LABEL_FILE_COUNT_1', 'Creating file EP_Split');

define('EASY_LABEL_LINE_COUNT_1', 'Added ');
define('EASY_LABEL_LINE_COUNT_2', 'records and closing file... ');

define('EASY_SPLIT_DOWN', 'You can download your split files in the Tools/Files under');

define('EASY_TEXT_DELETED', 'Deleted product ');
define('EASY_TEXT_DELETED1', ' from the database');
define('EASY_TEXT_NOT_DELETE', 'Did not delete ');
define('EASY_TEXT_NOT_DELETE1', ' since it is not unique');

define('EASY_ERROR_2', '... ERROR! - Too many characters in the model number.<br>
			25 is the maximum on a standard install.<br>
			Your maximum product_model length is set to ');
define('EASY_ERROR_2A', ' <br>You can either shorten your model numbers or increase the size of the field in the database. Then change the setting at the top of the easypopulate.php file.</font>');

define('EASY_LABEL_NEW_PRODUCT', "<font color='green'> !New Product!</font><br>");
define('EASY_LABEL_UPDATED', "<font color='black'> Updated</font><br>");
define('EASY_LABEL_DELETE_STATUS_1', "<font color='red'> !!Deleting product ");
define('EASY_LABEL_DELETE_STATUS_2', " from the database !!</font><br>");

define('EASY_LABEL_TEXT_NO_MODEL', 'No products_model field in record. This line was not imported: ');

define('EASY_EXTRA_FIELD_UPDATED', 'Product Extra Fields Updated');
define('EASY_EXTRA_FIELD_ADDED', 'Product Extra Fields Inserted');

?>