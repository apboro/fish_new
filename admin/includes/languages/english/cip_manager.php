<?php
/* --------------------------------------------------------------
   $Id: cip_manager.php 1249 2007-02-07 17:36:57 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   --------------------------------------------------------------
   based on:
   (c) 2005 Vlad Savitsky cip.net.ua

   Released under the GNU General Public License
   --------------------------------------------------------------*/

define('HEADING_TITLE', 'CIP Manager');

define('TABLE_HEADING_FILENAME', 'Name');
define('TABLE_HEADING_SIZE', 'Size');
define('TABLE_HEADING_PERMISSIONS', 'Permissions');
define('TABLE_HEADING_USER', 'User');
define('TABLE_HEADING_GROUP', 'Group');
define('TABLE_HEADING_UPLOADED', 'Uploaded');
define('TABLE_HEADING_ACTION', 'Action');

define('TEXT_INFO_HEADING_UPLOAD', 'Upload');
define('TEXT_FILE_NAME', 'Filename:');
define('TEXT_FILE_SIZE', 'Size:');
define('TEXT_FILE_CONTENTS', 'Contents:');
define('TEXT_LAST_MODIFIED', 'Last Modified:');
define('TEXT_DELETE_INTRO', 'Are you sure you want to delete this file?');
define('TEXT_UPLOAD_INTRO', 'Please select the files to upload.');
define('TEXT_UPLOAD_LIMITS','Remember that you could upload only <b>ZIPs</b>, no more than <b>'.round(MAX_UPLOADED_FILESIZE/1024).'Kb</b> and only <b>Contrib Installer Packages</b>!');

define('ERROR_DIRECTORY_NOT_WRITEABLE', 'Error: I can not write to this directory. Please set the right user permissions on: %s');
define('ERROR_FILE_NOT_WRITEABLE', 'Error: I can not write to this file. Please set the right user permissions on: %s');
define('ERROR_DIRECTORY_NOT_REMOVEABLE', 'Error: I can not remove this directory. Please set the right user permissions on: %s');
define('ERROR_FILE_NOT_REMOVEABLE', 'Error: I can not remove this file. Please set the right user permissions on: %s');
define('ERROR_FILE_ALREADY_EXISTS','File %s  <b>already exists</b>.');

define('ICON_EDIT', 'Edit');
define('ICON_INSTALL', 'Install');
define('ICON_REMOVE', 'Remove');
define('ICON_DELETE_MODULE', 'Delete module archive');
define('ICON_WITHOUT_DATA_REMOVING', 'without data removing');
define('ICON_EMPTY', '');
define('ICON_INSTALLED_CURRENT_FOLDER', 'Current folder of CIP that has been installed');

define('CIP_MANAGER_SUPPORT','Support: ');
define('CIP_MANAGER_UPLOADER','Uploader: ');
define('CIP_MANAGER_SUPPORT_FORUM','Support Forum for this CIP');
define('CIP_MANAGER_CONTRIBUTION_PAGE','Contribution official page');
define('CIP_MANAGER_SUPPORT_FORUM_DEVELOPER','Support Forum for this CIP at developer site');
define('CIP_MANAGER_INFO','Contrib Info: ');
define('CIP_MANAGER_INSTALLED','CIP have been INSTALLED');
define('CIP_MANAGER_NOT_INSTALLED','CIP have NOT been installed');
define('CIP_MANAGER_UPLOAD_NOTE','Remember that you could upload <b>only ZIPs</b>, <br><b>no more than 500Kb</b><br>and <b>only Contrib Installer Packages! :-)</b>.');
define('CIP_MANAGER_XML_NOT_FOUND',' does not exists!');
define('CIP_MANAGER_GENERAL_INFO','General Info: ');
define('CIP_MANAGER_IMAGE_PREVIEW','Image Preview: ');
define('CIP_MANAGER_ENLARGE','Click to enlarge');
define('CIP_MANAGER_INSTALLED','CIP was <b>installed!</b>');
define('CIP_MANAGER_REMOVED','CIP was <b>removed.</b>');

define('CONTRIB_INSTALLER_NAME','Contrib_Installer');
define('CONTRIB_INSTALLER_VERSION','2.0.6');
define('CONFIG_FILENAME','install.xml');
define('INIT_CONTRIB_INSTALLER', 'contrib_installer.php');

define('CANT_CREATE_DIR_TEXT', 'Couldn\'t create directory: ');
define('COLUDNT_REMOVE_DIR_TEXT', 'Couldn\'t remove directory: ');
define('WRITE_PERMISSINS_NEEDED_TEXT', 'I need write permission for: ');
define('COULDNT_REMOVE_FILE_TEXT', 'Couldn\'t remove file: ');
define('COULDNT_COPY_TO_TEXT', 'Couldn\'t copy file: ');
define('COULDNT_FIND_TEXT', 'Couldn\'t find ');
define('NO_CONTRIBUTION_NAME_TEXT', 'No contribution name.');
define('NAME_OF_FILE_MISSING_IN_ADDFILE_SECTION_TEXT', 'Name of file missing.');
define('NO_QUERY_TAG_IN_SQL_SECTION_TEXT', 'No query tag.');
define('NO_REMOVE_QUERY_NESSESARY_FOR_SQL_QUERY_TEXT', 'No remove query necessary for SQL query: ');
define('NAME_OF_DIR_MISSING_IN_MAKE_DIR_SECTION_TEXT', 'Name of dir missing.');
define('IN_THE_FILE_TEXT', 'in the file: ');
define('NO_INSTALL_TAG_IN_PHP_SECTION_TEXT', 'No INSTALL tag in php section.');
define('NO_REMOVE_TAG_IN_PHP_SECTION_TEXT', 'No REMOVE tag in php section.');
define('FILE_NOT_EXISTS_TEXT', 'File NOT exists');
define('NAME_OF_FILE_MISSING_IN_DEL_FILE_SECTION_TEXT', 'Name of file missing.');
define('ERROR_COULD_NOT_OPEN_XML', 'Could not open XML input from: ');
define('TEXT_NOT_ORIGINAL_TEXT', 'Not original text in find-section. ');
define('TEXT_HAVE_BEEN_FOUND', 'Have been found ');
define('TEXT_TIMES', ' times!!!');
define('NO_COMMENTS_TAG_IN_DESCRIPTION_SECTION_TEXT', 'No comments tag in description section');
define('NO_CREDITS_TAG_IN_DESCRIPTION_SECTION_TEXT', 'No credits tag in description section');
define('NO_CONTRIB_REF_PARAMETER_IN_DETAILS_TAG_TEXT', 'No contrib_ref parameter in details tag');
define('NO_FORUM_REF_PARAMETER_IN_DETAILS_TAG_TEXT', 'No forum_ref parameter in details tag');
define('NO_CONTRIB_TYPE_PARAMETER_IN_DETAILS_TAG_TEXT', 'No contrib_type parameter in details tag');
define('NO_STATUS_PARAMETER_IN_DETAILS_TAG_TEXT', 'No status parameter in details tag');
define('NO_LAST_UPDATE_PARAMETER_IN_DETAILS_TAG_TEXT', 'No last_update parameter in details tag');

define('TEXT_INFO_SUPPORT', 'Support');
define('TEXT_INFO_CONTRIB', 'Contrib Info');
define('CONTRIBS_PAGE_ALT','Contributions official page');
define('CONTRIBS_PAGE','Contrib\'s Page');

define('CONTRIBS_FORUM_ALT','Link to forum where you can get a support');
define('CONTRIBS_FORUM','Support Forum for contrib');

define('CIP_STATUS_REMOVED_ALT', 'CIP have NOT been installed');
define('CIP_STATUS_INSTALLED_ALT', 'CIP have been INSTALLED');

define('CIP_USES', 'CIP uses');
define('TEXT_DOESNT_EXISTS', ' doesn\'t exists');

define('MSG_WAS_INSTALLED','CIP was installed!');
define('MSG_WAS_APPLIED',' was aplied!');
define('MSG_WAS_REMOVED','CIP was removed.');

define('TEXT_POST_INSTALL_NOTES','POST INSTALL NOTES');

?>