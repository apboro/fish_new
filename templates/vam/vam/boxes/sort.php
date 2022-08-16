<!-- information //-->
<h1><?php echo BOX_HEADING_MANUFACTURERS; ?></h1>
<div class="page">
<b class="b1"></b><b class="b2"></b><b class="b3"></b><b class="b4"></b>
<div class="pageItem">
<p>
<?php  if (sizeof($options)<2){}
else {
  $c=1;

// BOF manufacturers descriptions
//  $manufacturers_query = tep_db_query("select manufacturers_id, manufacturers_name from " . TABLE_MANUFACTURERS . " order by manufacturers_name");
  $manufacturers_query = tep_db_query("select manufacturers_id, manufacturers_name from " . TABLE_MANUFACTURERS_INFO . " where languages_id = '" . (int)$languages_id . "' order by manufacturers_name");
// EOF manufacturers descriptions
  $number_of_rows = tep_db_num_rows($manufacturers_query);
  while ($manufacturers = tep_db_fetch_array($manufacturers_query)) {
        $manufacturers_name = ((strlen($manufacturers['manufacturers_name']) > MAX_DISPLAY_MANUFACTURER_NAME_LEN) ? substr($manufacturers['manufacturers_name'], 0, MAX_DISPLAY_MANUFACTURER_NAME_LEN) . '..' : $manufacturers['manufacturers_name']);
        if (isset($_GET['manufacturers_id']) && ($_GET['manufacturers_id'] == $manufacturers['manufacturers_id'])) $manufacturers_name = '<b>' . $manufacturers_name .'</b>';
        $manufacturers_list .= '&nbsp;<a href="' . tep_href_link(FILENAME_DEFAULT, 'manufacturers_id=' . $manufacturers['manufacturers_id']) . '">' . $manufacturers_name . '</a>';

 //echo '<a href="index.php?manufacturers_id='. $manufacturers['manufacturers_id']   .'"target="_self">' . $manufacturers['manufacturers_name'] .'</a>';
//echo $options[$c]['text']. ' ' . $manufacturers['manufacturers_name'] .'<br>';
if ($options[$c]['text']== $manufacturers['manufacturers_name']){
   $new[$c-1]='&nbsp;<a href="index.php?'.  tep_get_path($current_category_id)  .'&filter_id='. $manufacturers['manufacturers_id']   .' "target="_self">' . $manufacturers['manufacturers_name'] .'</a>';
                $c++;     } else {}


            }

 // echo $current_category_id;
for ($col=0, $n=sizeof($new); $col<$n; $col++) {
      echo tep_draw_form('manufacturers', tep_href_link(FILENAME_DEFAULT, '', 'NONSSL', false), 'get');
          $all.= $new[$col];
        if ($col < sizeof($new))  $all.=', ';
                                }
                                
 // new iBox($all);

?>
<?php

  echo $all;
?>  

<?php
echo '<a href="index.php?'. tep_get_path($current_category_id) .' "target="_self">'.TEXT_ALL.'</a>';

      echo '<br /><br />';
      echo '</form>';

?> 

<?php } ?>
</p>
<div class="clear"></div>
</div>

<b class="b4b"></b><b class="b3b"></b><b class="b2b"></b><b class="b1b"></b>
</div>