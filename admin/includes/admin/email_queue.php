<?php
  require('includes/application_top.php');

//  $max_results = 3; // to override the normal search results
  $max_results = MAX_DISPLAY_SEARCH_RESULTS;

  if ($_GET['table'] == 'archive') {
    $view_archive = true;
  } else {
    $view_archive = false;
  }

  $released   = '<img src="images/icons/released.gif" alt="' . ALT_RELEASED . '">';
  $hold_red   = '<img src="images/icons/hold.gif" alt="' . ALT_HOLDING . '">';
  $send_green = '<img src="images/icons/send.gif" alt="' . ALT_SEND . '">';
  $scheduled  = '<img src="images/icons/scheduled.gif" alt="' . ALT_SCHEDULED . '">';

  if (HOLD_EMAIL_QUEUE == 'true') {
    $hold_message = ' <span style="color: red; font-size: 12px;">' . MSG_MASTERSWITCH . '</span>';
  } else {
    $hold_message = '';
  }

  if ($view_archive) {
    $table_in_use = TABLE_EMAIL_BATCH_A;
    $hold_message .= ' - ' . LINK_ARCHIVE;
  } else {
    $table_in_use = TABLE_EMAIL_BATCH;
  }

  $action = (isset($_GET['action']) ? $_GET['action'] : '');
  if (tep_not_null($action)) {
    switch ($action) {
      case 'save':
        if (isset($_GET['eID'])) $email_id = tep_db_prepare_input($_GET['eID']);
          $to_name      = tep_db_prepare_input($_POST['to_name']);
          $to_address   = tep_db_prepare_input($_POST['to_address']);
          $subject      = tep_db_prepare_input($_POST['subject']);
          $send         = tep_db_prepare_input($_POST['send']);
          $text         = tep_db_prepare_input($_POST['text']);
          $from_name    = tep_db_prepare_input($_POST['from_name']);
          $from_address = tep_db_prepare_input($_POST['from_address']);
          $hold         = tep_db_prepare_input($_POST['hold']);

          $this_moment = date("Ymd") . ' ' . date("H:i:s");

          $sql_data_array = array('to_name'      => $to_name,
                                  'to_address'   => $to_address,
                                  'subject'      => $subject,
                                  'text'         => $text,
                                  'from_name'    => $from_name,
                                  'from_address' => $from_address,
                                  'send'         => $send,
                                  'hold'         => $hold,
                                  'last_updated' => $this_moment);

        tep_db_perform($table_in_use , $sql_data_array, 'update', "id = '" . (int)$email_id . "'");
        tep_redirect(tep_href_link(FILENAME_EMAIL_QUEUE, 'page=' . $_GET['page'] . '&eID=' . $email_id . '&table=' . $_GET['table']));
        break;
      case 'archive':
        $email_query = tep_db_query("select * from email_batch where send = 'on'");
        while ($email = mysql_fetch_array($email_query)) {
          $sql_data_array = array('id'           => $email['id'],
                                  'charset'      => $email['charset'],
                                  'ip'           => $email['ip'],
                                  'send'         => $email['send'],
                                  'hold'         => $email['hold'],
                                  'to_name'      => $email['to_name'],
                                  'to_address'   => $email['to_address'],
                                  'subject'      => $email['subject'],
                                  'text'         => $email['text'],
                                  'from_name'    => $email['from_name'],
                                  'from_address' => $email['from_address'],
                                  'last_updated' => $email['last_updated'],
                                  'created'      => $email['created']);

          tep_db_perform(TABLE_EMAIL_BATCH_A, $sql_data_array, 'insert');
          tep_db_query("delete from email_batch where id = '" . $email['id']. "'");
        }
        tep_redirect(tep_href_link(FILENAME_EMAIL_QUEUE, 'page=' . $_GET['page'] . '&table=' . $_GET['table']));
        break;
      case 'deleteconfirm':
        $email_id = tep_db_prepare_input($_GET['eID']);
        tep_db_query("delete from " . $table_in_use . " where id = '" . (int)$email_id . "'");
        tep_redirect(tep_href_link(FILENAME_EMAIL_QUEUE, 'page=' . $_GET['page'] . '&table=' . $_GET['table']));
        break;
      case 'delete':
        $email_id = tep_db_prepare_input($_GET['eID']);
        $remove_email = true;
        break;
      case 'delete_send':
        tep_db_query("delete from " . $table_in_use . " where send = 'on'");
        tep_redirect(tep_href_link(FILENAME_EMAIL_QUEUE, 'page=' . $_GET['page'] . '&table=' . $_GET['table']));
        break;
      case 'release_on_hold':
        tep_db_query("update " . $table_in_use . " set hold = '' where hold = 'on'");
        tep_redirect(tep_href_link(FILENAME_EMAIL_QUEUE, 'page=' . $_GET['page'] . '&table=' . $_GET['table']));
        break;
      case 'hold_pending':
        tep_db_query("update " . $table_in_use . " set hold = 'on' where send is NULL or send = ''");
        tep_redirect(tep_href_link(FILENAME_EMAIL_QUEUE, 'page=' . $_GET['page'] . '&table=' . $_GET['table']));
        break;
      case 'send':
        $this_email_query = tep_db_query("select * from " . $table_in_use . " where id = '" . $_GET['eID'] . "'");
        $this_email = mysql_fetch_array($this_email_query);
        define('CHARSET', $this_email['charset']);
        $this_email['text'] = str_replace("\n", '<br>', $this_email['text']);
        tep_mail($this_email['to_name'], $this_email['to_address'], $this_email['subject'], $this_email['text'], $this_email['from_name'], $this_email['from_address']);
        tep_db_query("update email_batch set send = 'on', last_updated = now() where id = '" . $this_email['id'] . "'");
        tep_redirect(tep_href_link(FILENAME_EMAIL_QUEUE, 'page=' . $_GET['page'] . '&table=' . $_GET['table']));
        break;
    }
  }
?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<title><?php echo TITLE; ?></title>
<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
<script language="javascript" src="includes/general.js"></script>
</head>
<body>
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
<table border="0" width="100%" cellspacing="2" cellpadding="2">
  <tr>
    <td width="<?php echo BOX_WIDTH; ?>" valign="top">
     <table border="0" width="<?php echo BOX_WIDTH; ?>" cellspacing="1" cellpadding="1" class="columnLeft">
     <?php require(DIR_WS_INCLUDES . 'column_left.php'); ?>
     </table>
    </td>
    <td width="100%" valign="top">
     <table class="table-padding-2">
      <tr>
        <td>
         <table class="table-padding-0">
          <tr>
            <td class="pageHeading"><?php echo HEADING_TITLE . $hold_message ; ?></td>
            <td class="pageHeading" align="right"><?php echo tep_draw_separator('pixel_trans.gif', HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?></td>
          </tr>
        </table>
       </td>
      </tr>
      <tr>
       <td>
          <table class="table-padding-0">
          <tr>
            <td valign="top">
             <table class="table-padding-2">
              <tr class="dataTableHeadingRow">
               <?php
                 echo '<td style="background: #ffe6e6; border: 1px solid #A2ABB6;" width="20%" align="center"><a href="' . tep_href_link(FILENAME_EMAIL_QUEUE, 'page=' . $_GET['page'] . '&eID=' . $eInfo->id . '&table=queue') . '">' . LINK_QUEUE . '</a></td>';
                 echo '<td style="background: #FFFACD; border: 1px solid #A2ABB6;" width="20%" align="center"><a href="' . tep_href_link(FILENAME_EMAIL_QUEUE, 'page=' . $_GET['page'] . '&eID=' . $eInfo->id . '&table=archive') . '">' . LINK_ARCHIVE . '</a></td>';
               ?>
              </tr>
             </table>
          </td>
         </tr>
         </table>
      </tr>
      <tr>
       <td>
          <table class="table-padding-0">
          <tr>
            <td valign="top">
             <table class="table-padding-2">
              <tr class="dataTableHeadingRow">
               <?php
                  if (!$view_archive) {
                    echo '<td style="background: #99DAB9; border: 1px solid #A2ABB6;" width="20%" align="center"><a href="' . tep_href_link(FILENAME_EMAIL_QUEUE) . '">' . LINK_REFRESH . '</a></td>';
                    echo '<td style="background: #ffe6e6; border: 1px solid #A2ABB6;" width="20%" align="center"><a href="' . tep_href_link(FILENAME_EMAIL_QUEUE, 'page=' . $_GET['page'] . '&eID=' . $eInfo->id . '&table=' . $_GET['table'] . '&action=release_on_hold') . '">' . LINK_RELEASE_ON_HOLD . '</a></td>';
                    echo '<td style="background: #f1f9fe; border: 1px solid #A2ABB6;" width="20%" align="center"><a href="' . tep_href_link(FILENAME_EMAIL_QUEUE, 'page=' . $_GET['page'] . '&eID=' . $eInfo->id . '&table=' . $_GET['table'] . '&action=hold_pending') . '">' . LINK_HOLD_PENDING . '</a></td>';
                    echo '<td style="background: #FFFACD; border: 1px solid #A2ABB6;" width="20%" align="center"><a href="' . tep_href_link(FILENAME_EMAIL_QUEUE, 'page=' . $_GET['page'] . '&eID=' . $eInfo->id . '&table=' . $_GET['table'] . '&action=archive') . '">' . LINK_ARCHIVE_SEND . '</a></td>';
                    echo '<td style="background: #FFDAB9; border: 1px solid #A2ABB6;" width="20%" align="center"><a href="' . tep_href_link(FILENAME_EMAIL_QUEUE, 'page=' . $_GET['page'] . '&eID=' . $eInfo->id . '&table=' . $_GET['table'] . '&action=delete_send') . '">' . LINK_DELETE_SEND . '</a></td>';
                  }
               ?>
              </tr>
             </table>
          </td>
         </tr>
         </table>
      </tr>
      <tr>
        <td>
          <table class="table-padding-0">
          <tr>
            <td valign="top"><table class="table-padding-2">
              <tr class="dataTableHeadingRow">
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_EMAIL_ID; ?></td>
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_EMAIL_CREATED; ?></td>
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_TO_ADDRESS; ?></td>
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_SUBJECT; ?></td>
                <td class="dataTableHeadingContent" align="center"><?php echo TABLE_HEADING_HOLD; ?></td>
                <td class="dataTableHeadingContent" align="center"><?php echo TABLE_HEADING_SEND; ?></td>
                <td class="dataTableHeadingContent" align="center"><?php echo TABLE_HEADING_ACTION; ?>&nbsp;</td>
              </tr>
              <?php
                $email_query_raw = "SELECT * from " . $table_in_use . " order by created desc"; 
                $email_query_numrows = 0;
                $email_split = new splitPageResults($_GET['page'], $max_results , $email_query_raw, $email_query_numrows);

                $email_query = tep_db_query($email_query_raw);
                while ($email = tep_db_fetch_array($email_query)) {
                  if ((!isset($_GET['eID']) || (isset($_GET['eID']) && ($_GET['eID'] == $email['id']))) && !isset($eInfo) && (substr($action, 0, 3) != 'new')) {
                    $eInfo = new objectInfo($email);
                  }

                  if (isset($eInfo) && is_object($eInfo) && ($email['id'] == $eInfo->id) ) {
                    if (!$view_archive) {
                      echo '<tr id="defaultSelected" class="dataTableRowSelected" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="document.location.href=\'' . tep_href_link(FILENAME_EMAIL_QUEUE, 'page=' . $_GET['page'] . '&eID=' . $eInfo->id . '&table=' . $_GET['table'] . '&action=edit') . '\'">' . "\n";
                    } else {
                      echo '<tr id="defaultSelected" class="dataTableRowSelected" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="document.location.href=\'' . tep_href_link(FILENAME_EMAIL_QUEUE, 'page=' . $_GET['page'] . '&eID=' . $eInfo->id . '&table=' . $_GET['table']) . '\'">' . "\n";
                    }
                  } else {
                    echo '<tr class="dataTableRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="document.location.href=\'' . tep_href_link(FILENAME_EMAIL_QUEUE, 'page=' . $_GET['page'] . '&eID=' . $email['id'] . '&table=' . $_GET['table']) . '\'">' . "\n";
                  }
              ?>
                <td class="dataTableContent"><?php echo $email['id']; ?></td>
                <td class="dataTableContent"><?php echo $email['created']; ?></td>
                <td class="dataTableContent"><?php echo $email['to_address']; ?></td>
                <td class="dataTableContent"><?php echo $email['subject']; ?></td>
                <td class="dataTableContent" align="center">
                 <?php 
                       if ($email['hold'] == 'on') {
                         echo $hold_red;
                       } else {
                         echo $released;
                       }
                 ?>
                </td>
                <td class="dataTableContent" align="center">
                 <?php 
                       if ($email['send'] == 'on') {
                         echo $send_green;
                       } else {
                         echo $scheduled;
                       }
                 ?>
                </td>
                <td class="dataTableContent" align="center">
                 <?php 
                       if (isset($eInfo) && is_object($eInfo) && ($email['id'] == $eInfo->id) ) {
                         echo tep_image(DIR_WS_IMAGES . 'icon_arrow_right.gif');
                       } else { 
                         echo '<a href="' . tep_href_link(FILENAME_EMAIL_QUEUE, 'page=' . $_GET['page'] . '&eID=' . $email['id'] . '&table=' . $_GET['table']) . '">' 
                              . tep_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . '</a>';
                       }
                 ?>
                </td>
              </tr>
              <?php
              }
              ?>
              <tr>
                <td colspan="10">
                 <table class="table-padding-2">
                  <tr>
                    <td class="smallText top-valign"><?php echo $email_split->display_count($email_query_numrows, $max_results , $_GET['page'], TEXT_DISPLAY_NUMBER_OF_ENTRIES); ?></td>
                    <td class="smallText" align="right"><?php echo $email_split->display_links($email_query_numrows, $max_results , MAX_DISPLAY_PAGE_LINKS, $_GET['page'],'table=' . $_GET['table']); ?></td>
                  </tr>
                </table>
               </td>
              </tr>
            </table>
          </td>
          <?php
           $heading = array();
           $contents = array();

           switch ($action) {
             case 'edit':
               $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_EDIT_EMAIL . '</b>');
               $contents = array('form' => tep_draw_form('emails', FILENAME_EMAIL_QUEUE, 'page=' . $_GET['page'] . '&eID=' . $eInfo->id . '&table=' . $_GET['table'] . '&action=save'));
               $contents[] = array('align' => 'center', 'text' => '<br>' . tep_image_submit('button_update.gif', IMAGE_UPDATE) . ' <a href="' . tep_href_link(FILENAME_EMAIL_QUEUE, 'page=' . $_GET['page'] . '&eID=' . $eInfo->id . '&table=' . $_GET['table']) . '">' . tep_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>');
               $contents[] = array('text' => '' . TEXT_INFO_EMAIL_ID . ' ' . $eInfo->id . ' ' . TEXT_INFO_EMAIL_SEND . ' ' . tep_draw_checkbox_field('send', $eInfo->send,($eInfo->send == 'on')) . ' ' . TEXT_INFO_EMAIL_HOLD . ' ' . tep_draw_checkbox_field('hold', $eInfo->hold,($eInfo->hold == 'on')) . ' ' . TEXT_INFO_EMAIL_CHARSET . ' ' . $eInfo->charset . ' ip: ' . $eInfo->ip);
               $contents[] = array('text' => '' . TEXT_INFO_EMAIL_TO_NAME . '<br>' . tep_draw_input_field('to_name', $eInfo->to_name, ' size="50" ') . ' ' . tep_draw_input_field('to_address', $eInfo->to_address, ' size="50" '));
               $contents[] = array('text' => '' . TEXT_INFO_EMAIL_FROM_NAME . '<br>' . tep_draw_input_field('from_name', $eInfo->from_name, ' size="50" ') . ' ' . tep_draw_input_field('from_address', $eInfo->from_address, ' size="50" '));
               $contents[] = array('text' => '' . TEXT_INFO_EMAIL_SUBJECT . '<br>' . tep_draw_input_field('subject', $eInfo->subject, ' size="150" '));
               if (EMAIL_USE_HTML == 'true') {
                 $contents[] = array('text' => '' . TEXT_INFO_EMAIL_TEXT . '<br>' . tep_draw_textarea_field('text','soft',150,25, tep_convert_linefeeds(array("\r\n", "\n", "\r"), '<br>', $eInfo->text)));
               } else {
                 $contents[] = array('text' => '' . TEXT_INFO_EMAIL_TEXT . '<br>' . tep_draw_textarea_field('text','soft',150,25, $eInfo->text));
               }
               $contents[] = array('align' => 'center', 'text' => '<br>' . tep_image_submit('button_update.gif', IMAGE_UPDATE) . ' <a href="' . tep_href_link(FILENAME_EMAIL_QUEUE, 'page=' . $_GET['page'] . '&eID=' . $eInfo->id . '&table=' . $_GET['table']) . '">' . tep_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>');
               break;
             case 'delete':
               $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_DELETE_EMAIL . '</b>');
               $contents[] = array('text' => TEXT_INFO_DELETE_INTRO);
               $contents[] = array('text' => '<br><b>' . $cInfo->title . '</b>');
               $contents[] = array('align' => 'center', 'text' => '<br>' . (($remove_email) ? '<a href="' . tep_href_link(FILENAME_EMAIL_QUEUE, 'page=' . $_GET['page'] . '&eID=' . $eInfo->id . '&table=' . $_GET['table'] . '&action=deleteconfirm') . '">' . tep_image_button('button_delete.gif', IMAGE_DELETE) . '</a>' : '') . ' <a href="' . tep_href_link(FILENAME_EMAIL_QUEUE, 'page=' . $_GET['page'] . '&eID=' . $eInfo->id . '&table=' . $_GET['table']) . '">' . tep_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>');
               break;
             default:
               if (is_object($eInfo)) {
                 $heading[] = array('text' => '<b>' . $eInfo->id . '</b>');
                 if (!$view_archive) {
                   $contents[] = array('align' => 'center', 'text' => '<a href="' . tep_href_link(FILENAME_EMAIL_QUEUE, 'page=' . $_GET['page'] . '&eID=' . $eInfo->id . '&table=' . $_GET['table'] . '&action=edit') . '">' . tep_image_button('button_edit.gif', IMAGE_EDIT) . '</a> <a href="' . tep_href_link(FILENAME_EMAIL_QUEUE, 'page=' . $_GET['page'] . '&eID=' . $eInfo->id . '&table=' . $_GET['table'] . '&action=delete') . '">' . tep_image_button('button_delete.gif', IMAGE_DELETE) . '</a> <a href="' . tep_href_link(FILENAME_EMAIL_QUEUE, 'page=' . $_GET['page'] . '&eID=' . $eInfo->id . '&table=' . $_GET['table'] . '&action=send') . '">' . tep_image_button('button_send.gif', IMAGE_SEND) . '</a>');
                 }
                 $contents[] = array('text' => '' . TEXT_INFO_EMAIL_CHARSET . ' ' . $eInfo->charset . ' - from ip: ' . $eInfo->ip);
                 $contents[] = array('text' => '' . TEXT_INFO_EMAIL_TO_NAME . ' ' . $eInfo->to_name . ' [' . $eInfo->to_address . ']');
                 $contents[] = array('text' => '' . TEXT_INFO_EMAIL_FROM_NAME . ' ' . $eInfo->from_name . ' [' . $eInfo->from_address . ']');
                 if ($eInfo->hold) {
                   $contents[] = array('text' => '<li>' . TEXT_INFO_EMAIL_HOLD . '</li>');
                 } else {
                   $contents[] = array('text' => '<li>' . TEXT_INFO_EMAIL_RELEASED . '</li>');
                 }
                 if ($eInfo->send) {
                   $contents[] = array('text' => '<li>' . TEXT_INFO_EMAIL_SEND . '</li>');
                 } else {
                   $contents[] = array('text' => '<li>' . TEXT_INFO_EMAIL_NOT_SEND . '</li>');
                 }
                 $contents[] = array('text' => '' . TEXT_INFO_EMAIL_CREATED . ' ' . $eInfo->created);
                 $contents[] = array('text' => '' . TEXT_INFO_EMAIL_LAST_UPDATED . ' ' . $eInfo->last_updated);
                 $contents[] = array('text' => '<br>' . TEXT_INFO_EMAIL_SUBJECT . ' ' . $eInfo->subject);
                 if (EMAIL_USE_HTML == 'true') {
                   $contents[] = array('text' => '' . TEXT_INFO_EMAIL_TEXT . '<br>' . tep_convert_linefeeds(array("\r\n", "\n", "\r"), '<br>', $eInfo->text));
                 } else {
                   $contents[] = array('text' => '' . TEXT_INFO_EMAIL_TEXT . '<br>' . $eInfo->text);
                 }
               }
               break;
           }

           if ( (tep_not_null($heading)) && (tep_not_null($contents)) ) {
             echo '</tr><tr><td width="100%" valign="top">' . "\n";
             $box = new box;
             echo $box->infoBox($heading, $contents);
             echo '</td>';
           }
          ?>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
</table>
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>