<?php
/*
  $Id: polls.php,v 1.2 2003/04/06 13:12:38 wilt Exp $

  The Exchange Project - Community Made Shopping!
  http://www.theexchangeproject.org

  Copyright (c) 2000,2001 The Exchange Project

  Released under the GNU General Public License
*/

define('TOP_BAR_TITLE', 'Poll Manager');
define('HEADING_TITLE', 'Poll Manager');

define('TABLE_HEADING_ID', 'ID');
define('TABLE_HEADING_TITLE', 'Poll Title');
define('TABLE_HEADING_VOTES', 'No. of Votes');
define('TABLE_HEADING_CREATED', 'Date Created');
define('TABLE_HEADING_ACTION', 'Action');
define('TABLE_HEADING_PUBLIC', 'Public');
define('TABLE_HEADING_OPEN', 'Open');
define('TABLE_HEADING_CONFIGURATION_TITLE','Title');
define('TABLE_HEADING_CONFIGURATION_VALUE','Value');
define('TEXT_DISPLAY_NUMBER_OF_POLLS', 'Number of Polls:');
define('TEXT_DELETE_INTRO', 'Are you sure you want to delete this poll?');
define('TEXT_INFO_DESCRIPTION','Description:');
define('TEXT_INFO_DATE_ADDED','Date added:');
define('TEXT_INFO_LAST_MODIFIED','Last modified:');
define('TEXT_INFO_EDIT_INTRO','Please make any necessary changes');
define('TEXT_POLL_TITLE', 'Poll Title');
define('TEXT_POLL_CATEGORY', 'Choose Category');
define('TEXT_OPTION', 'Option');
define('IMAGE_NEW_POLL', 'New Poll');
define('_ALT_REOPEN','Re-open Poll');
define('_ALT_CLOSE','Close Poll');
define('_ALT_PUBLIC','Make poll public');
define('_ALT_PRIVATE','Make poll private');

define('DISPLAY_POLL_HOW_TITLE', 'Display Poll');
define('DISPLAY_POLL_ID_TITLE', 'Poll Id');
define('SHOW_POLL_COMMENTS_TITLE', 'Allow Comments');
define('SHOW_NOPOLL_TITLE', 'Show if no Polls');
define('POLL_SPAM_TITLE', 'Allow multiple votes');
define('MAX_DISPLAY_NEW_COMMENTS_TITLE', 'Number of Comments');

define('DISPLAY_POLL_HOW_DESC', 'Decides how the poll shown in the side box is chosen.<br>0 = Random<br>1 = Latest<br>2 = Most Popular<br>3 = Specific Poll ID');
define('DISPLAY_POLL_ID_DESC', 'If you chose above to display a<br>specific poll enter the pollid here');
define('SHOW_POLL_COMMENTS_DESC', 'Enable or Disable poll comments.<br>0 = Disable<br>1 = Enable');
define('SHOW_NOPOLL_DESC', 'If set will still show poll box if their are no eligible polls.<br>0 = Don\'t show side box<br>1 = Show side box');
define('POLL_SPAM_DESC', 'Allow people to vote more than once.<br>0 = No (recommended)<br>1 = yes (Useful for testing)');
define('MAX_DISPLAY_NEW_COMMENTS_DESC', 'Maximum number of comments to display on the pollbooth page');

define('TEXT_POLLS_CATEGORY','Data');

?>