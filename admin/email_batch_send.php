<?php
require('includes/configure.php');
require(DIR_WS_INCLUDES . 'filenames.php');
require ('includes/configuration_cache_read.php');
if (HOLD_EMAIL_QUEUE == 'true') {} else {
require(DIR_WS_INCLUDES . 'database_tables.php');
require(DIR_WS_FUNCTIONS . 'database.php');
tep_db_connect() or die('We are currently unavailable due to Maintenance..');
require(DIR_WS_FUNCTIONS . 'general.php');
//require(DIR_WS_CLASSES . 'mime.php');
//require(DIR_WS_CLASSES . 'email.php');
require(DIR_WS_CLASSES . 'class.phpmailer.php');
$email_query = tep_db_query("select * from email_batch where (send is null or send = '') and (hold is null or hold = '')");
while ($email = tep_db_fetch_array($email_query)) {
if (!defined('CHARSET')) define('CHARSET', $email['charset']);
$email['text'] = str_replace("\n", '
', $email['text']);
//echo "mail to ".$email['to_name']."\n";
tep_mail(
$email['to_name'],
$email['to_address'],
$email['subject'],
$email['text'],
$email['from_name'],
$email['from_address']);
tep_db_query("update email_batch set send = 'on', last_updated = now() where id = '" . $email['id']. "'");
}
mysqli_free_result($email_query);
}
?>