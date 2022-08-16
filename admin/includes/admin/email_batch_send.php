<?php
require('includes/configure.php');
require ('includes/configuration_cache_read.php');
if (HOLD_EMAIL_QUEUE == 'true') {} else {
  require(DIR_WS_INCLUDES . 'filenames.php');
  require(DIR_WS_INCLUDES . 'database_tables.php');
  require(DIR_WS_FUNCTIONS . 'database.php');
  tep_db_connect() or die('We are currently unavailable due to Maintenance..');
  require(DIR_WS_FUNCTIONS . 'general.php');
  require(DIR_WS_CLASSES . 'mime.php');
  require(DIR_WS_CLASSES . 'email.php');
  $email_query = tep_db_query("select * from email_batch where (send is null or send = '') and (hold is null or hold = '')  ");
  while ($email = mysql_fetch_array($email_query)) {
    define('CHARSET', $email['charset']);
    $email['text'] = str_replace("\n", '<br>', $email['text']);
    tep_mail(
             $email['to_name'], 
             $email['to_address'], 
             $email['subject'],
             $email['text'],
             $email['from_name'], 
             $email['from_address']);
    tep_db_query("update email_batch set send = 'on', last_updated = now() where id = '" . $email['id']. "'");
  }
  mysql_free_result($email_query);
}
?>