<?php
/*
  $Id: pollbooth.php,v 1.15 2003/04/06 22:29:47 wilt Exp $
  Altered by TomB to add results on admin side in OSC

  The Exchange Project - Community Made Shopping!
  http://www.theexchangeproject.org

  Copyright (c) 2000,2001 The Exchange Project

  Released under the GNU General Public License
*/
  require('includes/application_top.php');
  $location = ' : <a href="' . tep_href_link('pollbooth.php', 'op=results', 'NONSSL') . '" class="headerNavigation"> ' . NAVBAR_TITLE_1 . '</a>';
  DEFINE('MAX_DISPLAY_NEW_COMMENTS', '5');
if ($_GET['action']=='do_comment') {
  $comment_query_raw = "insert into phesis_comments (pollid, customer_id, name, date, host_name, comment,language_id) values ('" . $_GET['pollid'] . "', '" . $customer_id . "', '" . addslashes($_POST['comment_name']) . "', now(),'" . $REMOTE_ADDR . "','" . addslashes($_POST['comment']) . "','" . $languages_id . "')";
  $comment_query = tep_db_query($comment_query_raw);
  $_GET['action'] = '';
  $_GET['op'] = 'results';
}
?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<title><?php echo TITLE; ?></title>
<base href="<?php echo (getenv('HTTPS') == 'on' ? HTTPS_SERVER : HTTP_SERVER) . DIR_WS_ADMIN; ?>">
<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
</head>
<body>
<!-- header //-->
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
<!-- header_eof //-->

<!-- body //-->
<table border="0" width="100%" cellspacing="3" cellpadding="3">
  <tr>
    <td width="<?php echo BOX_WIDTH; ?>" valign="top"><table border="0" width="<?php echo BOX_WIDTH; ?>" cellspacing="0" cellpadding="2" class="columnLeft">
<!-- left_navigation //-->
<?php require(DIR_WS_INCLUDES . 'column_left.php'); ?>
<!-- left_navigation_eof //-->
    </table></td>
<!-- body_text //-->
    <td width="100%" valign="top"><table class="table-padding-0">
      <tr>
        <td width="100%"><table class="table-padding-0">
          <tr>
            <td class="pageHeading"><?php echo 'Результаты опроса'; ?></td>
            <td align="right">&nbsp;</td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
      <tr>


<?php
if ($_GET['warn']) {
?>
          <tr class="headerError">
            <td class="headerError"><?echo (_WARNING);$warn=$_GET['warn'];eval("\$temp=$warn;");echo($temp);?></td>
          </tr>
<?php
}
?>
     <tr>
       <td>
       <table width="100%">
<?php
if (!isset($_GET['op'])) {
        $_GET['op']="list";
        }
switch ($_GET['op']) {
        case "results":
                if (isset($_GET['pollid'])) {
                        $pollid=$_GET['pollid'];
                } else {
                $pollid=1;
                }
                      $poll_query = tep_db_query("SELECT pollid, timeStamp FROM phesis_poll_desc WHERE pollid='".$pollid."'");        
                      $polls = tep_db_fetch_array($poll_query);
                      $title_query = tep_db_query("select optionText from phesis_poll_data where pollid=$pollid and voteid='0' and language_id = '" . $languages_id . "'");
                      $title = tep_db_fetch_array($title_query);
?>
                <tr><td colspan="2" align="center"><b><br><br><?echo $title['optionText']?></b></td></tr>
                <tr><td>&nbsp;</td></tr>
<?php
                        $query="SELECT SUM(optionCount) AS sum FROM phesis_poll_data WHERE pollid='".$pollid."'";

                        $result=tep_db_query($query);
                        $polls=tep_db_fetch_array($result);
                        $sum=$polls['sum'];
                        for($i = 1; $i <= 12; $i++) {
                                $query = "SELECT pollid, optiontext, optioncount, voteid FROM phesis_poll_data WHERE (language_id = '" . $languages_id . "') and (pollid='".$pollid."') AND (voteid='".$i."')";        
                                $result=tep_db_query($query);$polls=tep_db_fetch_array($result);
                                $optiontext=$polls['optiontext'];
                                $optioncount=$polls['optioncount'];
                                if ($optiontext) {
?>
                                        <tr><td align="right">
                                        <?php echo $optiontext?></td>
<?php
                                        if ($sum) {
                                                $percent = 100 * $optioncount / $sum;
                                                } else {
                                                $percent = 0;
                                                }
?>
                                        <td align="left">
<?php
                                        $percentInt = (int)$percent * 4 * 1;
                                        $percent2 = (int)$percent;
                                        if ($percent > 0) {
?>
                                                   <img src="images/leftbar.gif" height="15" width="7" Alt="<?echo $percent2?> %"><img src="images/mainbar.gif" height="15" width="<?echo $percentInt?>" Alt="<?echo $percent2?> %"><img src="images/rightbar.gif" height="15" width="7" Alt="<?echo $percent2?> %">
<?php

                                                } else {
?>
                                                    <img src="images/leftbar.gif" height="15" width="7" Alt="<?php echo $percent2?> %"><img src="images/mainbar.gif" height="15" width="3" Alt="<?php echo $percent2?> %"><img src="images/rightbar.gif" height="15" width="7" Alt="<?php echo $percent2?> %">
<?php
                                                }
                                        printf(" %.2f%% (%d)", $percent, $optioncount);
?>
                                        </td></tr>
<?php
                                        }
                                }

                        $comments_query_raw = "select * from phesis_comments where pollid = '" . $pollid . "' and language_id = '" . $languages_id . "'";

                        $comments_query = tep_db_query($comments_query_raw);
  if ($comments_numrows > 0) {
?>

<?php
}
  if (($comments_numrows > 0) && ((PREV_NEXT_BAR_LOCATION == '2') || (PREV_NEXT_BAR_LOCATION == '3'))) {
?>
      <tr>
        <td colspan="2"><br><table class="table-padding-2">
          <tr>
            <td class="smallText"><?php echo $comments_split->display_count($comments_numrows, MAX_DISPLAY_NEW_COMMENTS, $_GET['page'], TEXT_DISPLAY_NUMBER_OF_COMMENTS); ?></td>
            <td align="right" class="smallText"><?php echo TEXT_RESULT_PAGE; ?> <?php echo $comments_split->display_links($comments_numrows, MAX_DISPLAY_NEW_COMMENTS, MAX_DISPLAY_PAGE_LINKS, $_GET['page'], tep_get_all_get_params(array('page', 'info', 'x', 'y'))); ?></td>
          </tr>
        </table></td>
      </tr>
<?php
  }
?>
                        <tr><td colspan="2" align="center">&nbsp;</td></tr>
                        <tr><td colspan="2" align="center" class="main"><?php echo 'Всего голосов'?> = <?php echo $sum?></td></tr>
                        <tr><td colspan="2" align="center" class="main"></td></tr>
<?php
                        break;
                case 'comment':
                if (isset($_GET['pollid'])) {
                        $pollid=$_GET['pollid'];
                } else {
                $pollid=1;
                }
                      $poll_query = tep_db_query("SELECT pollid, timeStamp FROM phesis_poll_desc WHERE pollid='".$pollid."'");        
                      $polls = tep_db_fetch_array($poll_query);
                      $title_query = tep_db_query("select optionText from phesis_poll_data where pollid=$pollid and voteid='0' and language_id = '" . $languages_id . "'");
                      $title = tep_db_fetch_array($title_query);
?>
                <?php echo tep_draw_form('poll_comment', tep_href_link('pollbooth.php', 'action=do_comment&pollid=' . $pollid), 'post'); ?>
                <tr><td colspan="2" align="center"><b><br><br><?echo $title['optionText']?></b></td></tr>
                <tr><td colspan="2">&nbsp;</td></tr>
<?php
  if (!$customer_id) {
?>
                <tr><td><?php echo tep_draw_input_field('comment_name',''); ?>&nbsp;<?php echo _YOURNAME; ?></td></tr>
<?php
  }
?>
                <tr><td><?php echo tep_draw_textarea_field('comment', 'soft', '30', '4', ''); ?></td></tr>
                <tr><td><?php echo tep_image_submit('button_continue.gif','TEXT_CONTINUE'); ?></td></tr>
                <form>
<?php
                $nolink = true;
                break;
                case 'list':
?>
                <tr><td colspan="3">&nbsp;</td></tr>
<?php
                $result=tep_db_query("SELECT pollid, timestamp, voters, poll_type, poll_open FROM phesis_poll_desc ORDER BY timestamp desc");
                $row=0;
                while ($polls=tep_db_fetch_array($result)) {
                        $row++;
                        $id=$polls['pollid'];
                        if (($row / 2) == floor($row / 2)) {
?>
                        <tr class="Payment-even">
<?php
                } else {
?>
                        <tr class="Payment-odd">
<?php
                }
                        $title_query = tep_db_query("select optionText from phesis_poll_data where pollid=$id and voteid='0' and language_id = '" . $languages_id . "'");
                        $title = tep_db_fetch_array($title_query);
                $fullresults="<a href=\"".tep_href_link('pollbooth.php','op=results&pollid='.$id,'NONSSL')."\">"._POLLRESULTS."</a>";
                $result1 = tep_db_query("SELECT SUM(optioncount) AS sum FROM phesis_poll_data WHERE pollid='".$id."'");
                $poll_sum=tep_db_fetch_array($result1);
                $sum=$poll_sum['sum'];
                $query1=tep_db_query("select count(pollid) as comments from phesis_comments where pollid=$id and language_id=$languages_id");
                $result1 = tep_db_fetch_array($query1);
                $comments = $result1['comments'];
                echo("<td class=\"main\">".$title['optionText']."</td><td class=\"main\">".$sum." "._VOTES."</td><td class=\"main\">".$comments." "._COMMENTS."</td><td class=\"main\">".$fullresults."</td>");
                if ($polls['poll_type']=='0') {
                        echo ("<td class=\"main\">"._PUBLIC."</td>");
                          } else {
                        echo ("<td class=\"main\">"._PRIVATE."</td>");
                        }
                if ($polls['poll_open']=='0') {
                        echo ("<td class=\"main\">"._POLLOPEN."</td>");
                          } else {
                        echo ("<td class=\"main\">"._POLLCLOSED."</td>");
                        }

                echo("</tr>\n");
        } 
        break;

        if (isset($_GET['pollid'])) {
$pollid=$_GET['pollid'];
} else {
$pollid=1;
}



                $poll_query=tep_db_query("select voters from phesis_poll_desc where pollid=$pollid");
                $poll_details=tep_db_fetch_array($poll_query);
                $title_query = tep_db_query("select optionText from phesis_poll_data where pollid=$pollid and voteid='0' and language_id = '" . $languages_id . "'");
                $title = tep_db_fetch_array($title_query);
?>
                <tr>
                <td align="center"><b><?echo $title['optionText']?></b><td>
                </tr>
<?php                
                $url = tep_href_link('pollbooth.php','op=results&pollid='.$pollid,'NONSSL');
                 $content =  "<input type=\"hidden\" name=\"pollid\" value=\"".$pollid."\">\n";
                  $content .=  "<input type=\"hidden\" name=\"forwarder\" value=\"".$url."\">\n";
                for ($i=1;$i<=12;$i++) {
                      $query=tep_db_query("select pollid, optiontext, optioncount, voteid from phesis_poll_data where (pollid=$pollid) and (voteid=$i) and (language_id=$languages_id)");
                      if ($result=tep_db_fetch_array($query)) {
                                      if ($result['optiontext']) {
                               $content.= "<input type=\"radio\" name=\"voteid\" value=\"".$i."\">".$result['optiontext']."<br>\n";
                               }
                            }
                }
                $content .= "<br><center><input type=\"submit\" value=\""._VOTE."\"></center><br>\n";
                $query=tep_db_query("select sum(optioncount) as sum from phesis_poll_data where pollid=$pollid");
                if ($result=tep_db_fetch_array($query)) {
                        $sum=$result['sum'];
                }
                $content .= "<center>[ <a href=\"".tep_href_link('pollbooth.php','op=results&pollid='.$pollid,'NONSSL')."\">"._RESULTS."</a> | <a href=\"".tep_href_link('pollbooth.php','op=list','NONSSL')."\">"._OTHERPOLLS."</a> ]";
                  $content .= "</br><center>" . $sum . " "._VOTES."</center>\n";
                echo '<tr><td align="center"><form name="poll" method="post" action="pollcollect.php">';

                echo $content;
                echo '<form>';
?>
                </td>
                </tr>
<?php
        break;
                }
?>
     </table>
      </tr>
<?php 
  if (!$nolink) {
?>
      <tr>
        <td align="right" class="main"><br><?php echo '<a href="' . tep_href_link(FILENAME_POLLS, '', 'NONSSL') . '">' . tep_image_button('button_continue.gif', 'CONTINUE') . '</a>'; ?></td>
      </tr>
<?php
}
?>
    </table></td>
<!-- body_text_eof //-->


  </tr>
</table>
<!-- body_eof //-->

<!-- footer //-->
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<!-- footer_eof //-->
<br>
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>
