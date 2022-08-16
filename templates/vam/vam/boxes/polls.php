<!-- polls //-->
<?php
  $hide = tep_hide_session_id();

function pollnewest() {
	global $customer_id, $_GET;
	if (DISPLAY_POLL_HOW==3) {
	        $extra_query=" and pollID='" . DISPLAY_POLL_ID . "'";
	        }
	if (!tep_session_is_registered('customer_id')) {
		$extra_query.=" and poll_type='0' ";
		}
	if (DISPLAY_POLL_HOW==2) {
		$order = 'voters DESC';
 		} else {
		$order = 'timestamp DESC';
		}

 	if (DISPLAY_POLL_HOW==0) {
	$query= tep_db_query("select pollid, catID FROM phesis_poll_desc where poll_open='0'".$extra_query."and catID != 0 order by RAND(), ".$order);
	} else {
	$query= tep_db_query("select pollid, catID FROM phesis_poll_desc where poll_open='0'".$extra_query."and catID != 0 order by ".$order);
	}

	$count=tep_db_num_rows($query);
        $result = tep_db_fetch_array($query);
	$pollid = false;
        if ($count>0) {
           if ($_GET['cPath']) $mypath = $_GET['cPath'];
           if ($_GET['products_id'])$mypath = tep_get_product_path($_GET['products_id']);
           if ($mypath) {
             $sub_cat_ids = preg_split("/[_]/", $mypath);
             for ($i = 0; $i < count($sub_cat_ids); $i++) { 
               if ($sub_cat_ids[$i] == $result['catID']) $pollid = $result['pollid'];                              
             }
           }
        }
	$query= tep_db_query("select pollid, catID FROM phesis_poll_desc where poll_open='0'".$extra_query." and catID = 0 order by ".$order);
	$count=tep_db_num_rows($query);
       	if ((!DISPLAY_POLL_HOW==0 || $count==1) && !$pollid) {
		if ($result=tep_db_fetch_array($query)) {
			$pollid = $result['pollid'];
		}
	} elseif (!$pollid) {
		mt_srand((double) microtime() * 1000000);
		$rand = mt_rand(1,$count);
		for($i=0;$i<$rand;$i++) {
			$result=tep_db_fetch_array($query);
			$pollid = $result['pollid'];
			}
	}
	return $pollid;
}
if (basename($PHP_SELF) !='pollbooth.php') {
$pollid=pollnewest();
if ($pollid) {
?>
<div class="box">
<b class="top"><b class="b1"></b><b class="b2"></b><b class="b3"></b><b class="b4"></b><b class="b5"></b></b>
<div class="boxHeader">
<h5><?php echo _POLLS; ?></h5>
</div>
<div class="boxContent">
<table>
<form name="poll" method="post" action="<?php echo tep_href_link('pollcollect.php'); ?>">
<?php
	$poll_query=tep_db_query("select voters from phesis_poll_desc where pollid=$pollid and poll_open='0'");
	$poll_details=tep_db_fetch_array($poll_query);
        $title_query = tep_db_query("select optionText from phesis_poll_data where pollid=$pollid and voteid='0' and language_id = '" . $languages_id . "'");
        $title = tep_db_fetch_array($title_query);
  	$url = tep_href_link('pollbooth.php', 'op=results&pollid='.$pollid);
	$cont = "<tr><td colspan=\"2\" class=\"main\">" . $title['optionText'] . "</td></tr>";
 	$cont .=  "<input type=\"hidden\" name=\"pollid\" value=\"".$pollid."\">\n";
  	$cont .=  "<input type=\"hidden\" name=\"forwarder\" value=\"".$url."\">\n";
	for ($i=1;$i<=15;$i++) {
	      $query=tep_db_query("select pollid, optiontext, optioncount, voteid from phesis_poll_data where (pollid=$pollid) and (voteid=$i) and (language_id=$languages_id)");
      	if ($result=tep_db_fetch_array($query)) {
     	 		if ($result['optiontext']) {
       		$cont.= "<tr class=\"pollOptRow\"><td width=\"100\" class=\"pollBoxRow\" align=\"left\">".$result['optiontext']."</td><td width=\"10\" align=\"right\" class=\"pollBoxRow\"><input type=\"radio\" name=\"voteid\" value=\"".$i."\"></td></tr>";
       		}
    		}
	}
	$cont .= "<tr class=\"pollFooter\"><td colspan=\"2\"><center><input type=\"submit\" value=\""._VOTE."\"></center>\n</td></tr>";
	$query=tep_db_query("select sum(optioncount) as sum from phesis_poll_data where pollid='" . $pollid . "' and language_id = '" . $languages_id . "'");
	$query1=tep_db_query("select count(pollid) as comments from phesis_comments where pollid=$pollid and language_id=$languages_id");
        $result1 = tep_db_fetch_array($query1);
        $comments1 = $result1['comments'];
	if ($result=tep_db_fetch_array($query)) {
		$sum=$result['sum'];
	}
        $cont .= "<tr class=\"pollFooter\"><td colspan=\"2\" class=\"pollBoxText\"><center> <a href=\"" . tep_href_link('pollbooth.php', 'op=results&pollid=' .$pollid, 'NONSSL')."\">"._RESULTS."</a> | <a href=\"" .tep_href_link('pollbooth.php', 'op=list')."\">"._POLLS."</a> </td></tr>";

if (SHOW_POLL_COMMENTS == '1') {

        $cont .= "<tr class=\"pollFooter\"><td colspan=\"2\" class=\"pollBoxText\"><center>" . _VOTES . $sum . " | " . _COMMENTS . $comments1 . "</center>\n</td></tr>";

} else {        
        
        $cont .= "<tr class=\"pollFooter\"><td colspan=\"2\" class=\"pollBoxText\"><center>" . _VOTES . $sum . "</center>\n</td></tr>";

}
        
echo  $cont;

?>
</form>
</table>
</div>
<b class="bottom"><b class="b5b"></b><b class="b4b"></b><b class="b3b"></b><b class="b2b"></b><b class="b1b"></b></b>
</div>
<?php
} elseif (SHOW_NOPOLL==1) {
?>
<div class="box">
<b class="top"><b class="b1"></b><b class="b2"></b><b class="b3"></b><b class="b4"></b><b class="b5"></b></b>
<div class="boxHeader">
<h5><?php echo _NOPOLLS; ?></h5>
</div>
<div class="boxContent"><?php
echo _NOPOLLSCONTENT;

?>
</div>
<b class="bottom"><b class="b5b"></b><b class="b4b"></b><b class="b3b"></b><b class="b2b"></b><b class="b1b"></b></b>
</div>
<?php
}
}
?>
<!-- polls-eof //-->