<?php
/*
  $Id: attributeManager.php,v 1.0 21/02/06 Sam West$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Released under the GNU General Public License
  
  Hebrew translation to AJAX-AttributeManager-V2.7
  
  by Shimon Doodkin
  http://help.me.pro.googlepages.com
  helpmepro1@gmail.com
*/

//attributeManagerPrompts.inc.php

define('AM_AJAX_YES', 'ëï');
define('AM_AJAX_NO', 'ìà');
define('AM_AJAX_UPDATE', 'òãëï');
define('AM_AJAX_CANCEL', 'áéèåì');
define('AM_AJAX_OK', 'àéùåø');

define('AM_AJAX_SORT', 'ñéãåø:');
define('AM_AJAX_TRACK_STOCK', 'îò÷á îìàé?');
define('AM_AJAX_TRACK_STOCK_IMGALT', 'ìòùåú îò÷á îìàé ìîåöø äæä ?');

define('AM_AJAX_ENTER_NEW_OPTION_NAME', 'ðà ìä÷ìéã ùí çãù ìàôùøåú');
define('AM_AJAX_ENTER_NEW_OPTION_VALUE_NAME', 'ðà ìä÷ìéã ùí çãù ìòøê ùì äàôùøåú');
define('AM_AJAX_ENTER_NEW_OPTION_VALUE_NAME_TO_ADD_TO', 'ðà ìä÷ìéã ùí çãù ùì òøê àôùøåú ëãé ìäåñéó ì - %s');

define('AM_AJAX_PROMPT_REMOVE_OPTION_AND_ALL_VALUES', 'äàí äéðê áèåç ùáøöåðê ìîçå÷ àú äàôùøåú - %s åàú ëì äòøëéí ùäéà îëéìä ?');
define('AM_AJAX_PROMPT_REMOVE_OPTION', 'äàí äéðê áèåç ùáøöåðê ìîçå÷ îäîåöø äæä àú äàôùøåú - %s?');
define('AM_AJAX_PROMPT_STOCK_COMBINATION', 'äàí äéðê áèåç ùáøöåðê ìîçå÷ îäîåöø äæä àú ùéìåá äîìàé äðáçø?');

define('AM_AJAX_PROMPT_LOAD_TEMPLATE', 'äàí áøöåðê ìèòåï àú äúáðéú - %s ? <br />ôòåìä æå úçìéó àú äàôùøåéåú äðåëçéåú ùì äîåöø äæä åôòåìä æå ìà ðéúðú ìáéèåì.');
define('AM_AJAX_NEW_TEMPLATE_NAME_HEADER', 'ðà ìä÷ìéã ùí çãù òáåø äúáðéú. àå...');
define('AM_AJAX_NEW_NAME', 'ùí çãù:');
define('AM_AJAX_CHOOSE_EXISTING_TEMPLATE_TO_OVERWRITE', ' ...<br /> ... áçø úáðéú ÷ééîú ëãé ìäçìéó àåúä');
define('AM_AJAX_CHOOSE_EXISTING_TEMPLATE_TITLE', 'úáðéåú ÷ééîåú:'); 
define('AM_AJAX_RENAME_TEMPLATE_ENTER_NEW_NAME', 'ðà ìä÷ìéã ùí çãù òáåø äúáðéú - %s');
define('AM_AJAX_PROMPT_DELETE_TEMPLATE', 'äàí äéðê áèåç ùáøöåðê ìîçå÷ àú äúáðéú - %s?<br>ôòåìä æå àéðä ðéúðú ìáéèåì!');

//attributeManager.php

define('AM_AJAX_ADDS_ATTRIBUTE_TO_OPTION', 'îåñéó àú äîàôééï äðáçø îùîàì ìàôùøåú - %s ');
define('AM_AJAX_ADDS_NEW_VALUE_TO_OPTION', 'îåñéó òøê çãù ìàôùøåú - %s');
define('AM_AJAX_PRODUCT_REMOVES_OPTION_AND_ITS_VALUES', 'îåç÷ îäîåöø äæä, àú äàôùøåú - %1$s åàú ëì %2$d äòøëéí úçúéä');
define('AM_AJAX_CHANGES', 'îùðä ùôú öôééä'); 
define('AM_AJAX_LOADS_SELECTED_TEMPLATE', 'èåòï àú äúáðéú äðáçøú');
define('AM_AJAX_SAVES_ATTRIBUTES_AS_A_NEW_TEMPLATE', 'ùåîø àú äîàôééðéí äðåëçééí ëúáðéú çãùä');
define('AM_AJAX_RENAMES_THE_SELECTED_TEMPLATE', 'îùðä ùí ìúáðéú äðáçøú');
define('AM_AJAX_DELETES_THE_SELECTED_TEMPLATE', 'îåç÷ àú äúáðéú äðáçøú');
define('AM_AJAX_NAME', 'ùí');
define('AM_AJAX_ACTION', 'ôòåìä');
define('AM_AJAX_QT_PRO', 'Quantity Tracking Professional (QT Pro)');
define('AM_AJAX_PRODUCT_REMOVES_VALUE_FROM_OPTION', 'îåç÷ îäîåöø äæä, àú - %1$s îúåê - %2$s');
define('AM_AJAX_MOVES_VALUE_UP', 'îæéæ àú äàôùøåú ìîòìä');
define('AM_AJAX_MOVES_VALUE_DOWN', 'îæéæ àú äàôùøåú ìîèä');
define('AM_AJAX_ADDS_NEW_OPTION', 'îåñéó àôùøåú çãùä ìøùéîä');
define('AM_AJAX_MOVES_VALUE_DOWN', 'Moves option value down');
define('AM_AJAX_ADDS_NEW_OPTION', 'Adds a new option to the list');
define('AM_AJAX_OPTION', 'àôùøåú:');
define('AM_AJAX_VALUE', 'òøê:');
define('AM_AJAX_PREFIX', 'î÷ãí:');
define('AM_AJAX_PRICE', 'îçéø:');
define('AM_AJAX_ATTRIBUTE_CODE', 'Code Suffix:');
define('AM_AJAX_WEIGHT_PREFIX', 'Wgt.Prefix:');
define('AM_AJAX_WEIGHT', 'Weight:');
define('AM_AJAX_SORT', 'ñéãåø:');
define('AM_AJAX_ADDS_NEW_OPTION_VALUE', 'îåñéó òøê çãù ìàôùøåú');
define('AM_AJAX_ADDS_ATTRIBUTE_TO_PRODUCT', 'îåñéó àú äîàôééï ìîåöø äðåëçé');
define('AM_AJAX_DELETES_ATTRIBUTE_FROM_PRODUCT', 'Deletes attribute or attribute combination from the current product');
define('AM_AJAX_QUANTITY', 'ëîåú');
define('AM_AJAX_PRODUCT_REMOVE_ATTRIBUTE_COMBINATION_AND_STOCK', 'îåç÷ ÷åîáéðöéä æàú ùì àôùøåéåú îäîåöø åîäîìàé');
define('AM_AJAX_UPDATE_OR_INSERT_ATTRIBUTE_COMBINATIONBY_QUANTITY', 'îòãëï áîìàé àú ä÷åîáéðöéä ùì äàôùøåéåú áëîåú äðáçøú');
define('AM_AJAX_UPDATE_PRODUCT_QUANTITY', 'Set the given quantity to the current product');

//attributeManager.class.php
define('AM_AJAX_TEMPLATES', '-- úáðéåú --');

//----------------------------
// Change: download attributes for AM
//
// author: mytool
//-----------------------------
define('AM_AJAX_FILENAME', 'File');
define('AM_AJAX_FILE_DAYS', 'Days');
define('AM_AJAX_FILE_COUNT', 'Max. downloads');
define('AM_AJAX_DOWLNOAD_EDIT', 'Edit download option');
define('AM_AJAX_DOWLNOAD_ADD_NEW', 'Add download option');
define('AM_AJAX_DOWLNOAD_DELETE', 'Delete download option');
define('AM_AJAX_HEADER_DOWLNOAD_ADD_NEW', 'Add download option for \"%s\"');
define('AM_AJAX_HEADER_DOWLNOAD_EDIT', 'Edit download option for \"%s\"');
define('AM_AJAX_HEADER_DOWLNOAD_DELETE', 'Delete download option from \"%s\"');
define('AM_AJAX_FIRST_SAVE', 'Save Product before adding options');

//----------------------------
// EOF Change: download attributes for AM
//-----------------------------

define('AM_AJAX_OPTION_NEW_PANEL','New option:');
define('AM_AJAX_SORT_NUMERIC', 'Sort Numerically');
define('AM_AJAX_SORT_ALPHABETIC', 'Sort Alphabetically');

?>