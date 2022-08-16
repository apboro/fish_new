<?php

  $location = ' : <a href="' . tep_href_link('pollbooth.php', 'op=results', 'NONSSL') . '" class="headerNavigation"> ' . NAVBAR_TITLE_1 . '</a>';

  DEFINE('MAX_DISPLAY_NEW_COMMENTS', '5');

if ($_GET['action']=='do_comment') {

  $comment_query_raw = "insert into phesis_comments (pollid, customer_id, name, date, host_name, comment,language_id) values ('" . $_GET['pollid'] . "', '" . $customer_id . "', '" . addslashes($_POST['comment_name']) . "', now(),'" . $REMOTE_ADDR . "','" . addslashes($_POST['comment']) . "','" . $languages_id . "')";

  $comment_query = tep_db_query($comment_query_raw);

  $_GET['action'] = '';

  $_GET['op'] = 'results';

}

?>

<table border="0" width="100%" cellspacing="0" cellpadding="<?php echo CELLPADDING_SUB;?>">
<?php 
// Set number of columns in listing
define ('NR_COLUMNS', 2);?>
<?php
// BOF: Lango Added for template MOD
if (SHOW_HEADING_TITLE_ORIGINAL == 'yes') {
$header_text = '&nbsp;'
//EOF: Lango Added for template MOD
?>
      <tr> 
        <td width="100%"><table class="table-padding-0"> 
          <tr>
            <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
            <td align="right"><?php echo tep_image(DIR_WS_TEMPLATES . TEMPLATE_NAME . '/images/content/specials.gif', HEADING_TITLE, HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?></td>
          </tr>
        </table></td> 
      </tr>
<?php
// BOF: Lango Added for template MOD
}else{
$header_text = HEADING_TITLE;
}
// EOF: Lango Added for template MOD
?>

<?php
// BOF: Lango Added for template MOD
if (MAIN_TABLE_BORDER == 'yes'){
table_image_border_top(false, false, $header_text);
}
// EOF: Lango Added for template MOD
?>

<!-- body_text //-->

    <td width="100%" valign="top"><table class="table-padding-0">
      <tr>






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

                      $title_query = tep_db_query("SELect optionText from phesis_poll_data where pollid='".$pollid."' and voteid='0' and language_id = '" . $languages_id . "'");

                      $title = tep_db_fetch_array($title_query);

?>

		<tr><td colspan="2" align="center"><b><br><br><?echo $title['optionText']?></b></td></tr>

		<tr><td>&nbsp;</td></tr>

<?php

			$query="SELECT SUM(optionCount) AS sum FROM phesis_poll_data WHERE pollid='".$pollid."'";



			$result=tep_db_query($query);

			$polls=tep_db_fetch_array($result);

			$sum=$polls['sum'];

			for($i = 1; $i <= 15; $i++) {

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

//                      $comments_split = new splitPageResults($_GET['page'], MAX_DISPLAY_NEW_COMMENTS, $comments_query_raw, $comments_numrows);

                        $comments_query = tep_db_query($comments_query_raw);

  if ($comments_numrows > 0) {

?>

        <tr><td colspan="2">&nbsp;</td></tr>

        <tr><td class="pageheading" colspan="2"><?php echo _COMMENTS_POSTED; ?></td></tr>  

        <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '100%', '5'); ?></td>

<?php

}

  if (($comments_numrows > 0) && ((PREV_NEXT_BAR_LOCATION == '1') || (PREV_NEXT_BAR_LOCATION == '3'))) {

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

                        while ($comments = tep_db_fetch_array($comments_query)) {

  if ($comments['customer_id'] != '0') {

    $name_query = tep_db_query("select customers_firstname, customers_lastname from " . TABLE_CUSTOMERS . " where customers_id = '". $comments['customer_id'] . "'");

    $name = tep_db_fetch_array($name_query);

    $comment_name = $name['customers_firstname'] . " " . $name['customers_lastname'];

  } else {

    $comment_name = $comments['name'];

  }

 

  $post_details = _COMMENTS_BY . $comment_name . ' ['. $comments['host_name'] . ']' . _COMMENTS_ON . $comments['date'] ;

?>

<?php if (SHOW_POLL_COMMENTS == '1') { ?>

  <tr><td class="main" colspan="2"><b><?php echo $post_details; ?></b></td></tr>

        <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '100%', '5'); ?></td>

  <tr><td class="main" colspan="2"><?php echo htmlspecialchars($comments['comment']); ?></td></tr>

        <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '100%', '5'); ?></td>

<?php } ?>  







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

			<tr><td colspan="2" align="center" class="main"><?php echo _TOTALVOTES?> = <?php echo $sum?></td></tr>


			<tr><td colspan="2" align="center" class="main">[ <a href="<?php echo tep_href_link('pollbooth.php','pollid='.$pollid.'&op=comment','NONSSL')?>"><?php if (SHOW_POLL_COMMENTS == '1') { echo _ADD_COMMENTS;?></a> | <?php } if ($polls['poll_open']=='1') { ?><a href="<?php echo tep_href_link('pollbooth.php','pollid='.$pollid.'&op=vote','NONSSL')?>"><?php } echo _VOTING?></a> | <a href="<?php echo tep_href_link('pollbooth.php','op=list','NONSSL')?>"><?echo _OTHERPOLLS?></a> ]</td></tr>

<?php

			break;
                case 'comment':
if (SHOW_POLL_COMMENTS == '1') {

		if (isset($_GET['pollid'])) {

			$pollid=$_GET['pollid'];

		} else {

		$pollid=1;

		}

		      $poll_query = tep_db_query("SELECT pollid, timeStamp FROM phesis_poll_desc WHERE pollid='".$pollid."'");	

		      $polls = tep_db_fetch_array($poll_query);

                      $title_query = tep_db_query("select optionText from phesis_poll_data where pollid='".$pollid."' and voteid='0' and language_id = '" . $languages_id . "'");

                      $title = tep_db_fetch_array($title_query);

?>

                <?php echo tep_draw_form('poll_comment', tep_href_link('pollbooth.php', 'action=do_comment&pollid=' . $pollid), 'post'); ?>

		<tr><td colspan="2" align="center"><b><br><br><?echo $title['optionText']?></b></td></tr>

		<tr><td colspan="2">&nbsp;</td></tr>

<?php

  if (!$customer_id) {

?>

                <tr><td><?php echo _YOURNAME; ?>&nbsp;<?php echo tep_draw_input_field('comment_name',''); ?></td></tr>

<?php

  }

?>

                <tr><td><?php echo _OTZYV; ?><br><?php echo tep_draw_textarea_field('comment', 'soft', '30', '4', ''); ?></td></tr>

                <tr><td><?php echo tep_template_image_submit('button_submit_link.gif',TEXT_CONTINUE); ?></td></tr>

                <form>

<?php

                $nolink = true;
}

                break;
		case 'list':

?>

		<tr><td colspan="3">&nbsp;</td></tr>

<?php

		$result=tep_db_query("SELECT pollid, timestamp, voters, poll_type, poll_open FROM phesis_poll_desc ORDER BY timestamp desc");

		$row=0;

		while ($polls=tep_db_fetch_array($result)) {

			$row++;

			$id_poll =$polls['pollid'];

			if (($row / 2) == floor($row / 2)) {

?>

			<tr class="Payment-even">

<?php

		} else {

?>

			<tr class="Payment-odd">

<?php

		}

                        $title_query = tep_db_query("SELect optionText from phesis_poll_data where pollid='".$id_poll ."' and voteid='0' and language_id = '" . $languages_id . "'");

                        $title = tep_db_fetch_array($title_query);

		$fullresults="<a href=\"".tep_href_link('pollbooth.php','op=results&pollid='.$id_poll ,'NONSSL')."\">"._POLLRESULTS."</a>";

		$result1 = tep_db_query("SELECT SUM(optioncount) AS sum FROM phesis_poll_data WHERE pollid='".$id_poll ."'");

		$poll_sum=tep_db_fetch_array($result1);

		$sum=$poll_sum['sum'];

	        $query1=tep_db_query("select count(pollid) as comments from phesis_comments where pollid='".$id_poll."' and language_id='".$languages_id."'");

                $result1 = tep_db_fetch_array($query1);

                $comments = $result1['comments'];
if (SHOW_POLL_COMMENTS == '1') {

		echo("<td class=\"main\">".$title['optionText']."</td><td class=\"main\">". _VOTES . " " . $sum."</td><td class=\"main\">" . _COMMENTS. " " .$comments."</td><td class=\"main\">".$fullresults."</td>");
		
} else {        
        
		echo("<td class=\"main\">".$title['optionText']."</td><td class=\"main\">". _VOTES . " " . $sum."</td><td class=\"main\">&nbsp;</td><td class=\"main\">".$fullresults."</td>");
		
}



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

	case "vote":

if (isset($_GET['pollid'])) {

$pollid=$_GET['pollid'];

} else {

$pollid=1;

}



		$poll_query=tep_db_query("select voters from phesis_poll_desc where pollid='".$pollid."'");

		$poll_details=tep_db_fetch_array($poll_query);

                $title_query = tep_db_query("SElect optionText from phesis_poll_data where pollid='".$pollid."' and voteid='0' and language_id = '" . $languages_id . "'");

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

		      $query=tep_db_query("select pollid, optiontext, optioncount, voteid from phesis_poll_data where (pollid='".$pollid."') and (voteid=$i) and (language_id='".$languages_id."')");

      		if ($result=tep_db_fetch_array($query)) {

     	 			if ($result['optiontext']) {

	       		$content.= "<input type=\"radio\" name=\"voteid\" value=\"".$i."\">".$result['optiontext']."<br>\n";

      	 		}

    			}

		}

		$content .= "<br><center><input type=\"submit\" value=\""._VOTE."\"></center><br>\n";

		$query=tep_db_query("select sum(optioncount) as sum from phesis_poll_data where pollid='".$pollid."'");

		if ($result=tep_db_fetch_array($query)) {

			$sum=$result['sum'];

		}

		$content .= "<center>[ <a href=\"".tep_href_link('pollbooth.php','op=results&pollid='.$pollid,'NONSSL')."\">"._RESULTS."</a> | <a href=\"".tep_href_link('pollbooth.php','op=list','NONSSL')."\">"._OTHERPOLLS."</a> ]";

  		$content .= "</br><center>" . _VOTES . " " . $sum . "</center>\n";

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

<?php

}

?>

    </table></td>

<!-- body_text_eof //-->
<?php
// BOF: Lango Added for template MOD
if (MAIN_TABLE_BORDER == 'yes'){
table_image_border_bottom();
}
// EOF: Lango Added for template MOD
?>


   </table>
   