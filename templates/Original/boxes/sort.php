<!-- information //-->
        <tr>
            <td>
<?php 
 if ((sizeof($options)<2)||($current_category_id==0)){}
else {
  $c=1;
 $info_box_contents = array();
  $info_box_contents[] = array('align' => 'left',
                               'text'  => BOX_HEADING_MANUFACTURERS);
  new infoBoxHeading($info_box_contents, false, false);


  $info_box_contents = array();
// BOF manufacturers descriptions
//  $manufacturers_query = tep_db_query("select manufacturers_id, manufacturers_name from " . TABLE_MANUFACTURERS . " order by manufacturers_name");
  $manufacturers_query = tep_db_query("select manufacturers_id, manufacturers_name from " . TABLE_MANUFACTURERS_INFO . " where languages_id = '" . (int)$languages_id . "' order by manufacturers_name");
// EOF manufacturers descriptions
  $number_of_rows = tep_db_num_rows($manufacturers_query);
  while ($manufacturers = tep_db_fetch_array($manufacturers_query)) {
        $manufacturers_name = ((strlen($manufacturers['manufacturers_name']) > MAX_DISPLAY_MANUFACTURER_NAME_LEN) ? substr($manufacturers['manufacturers_name'], 0, MAX_DISPLAY_MANUFACTURER_NAME_LEN) . '..' : $manufacturers['manufacturers_name']);
        if (isset($_GET['manufacturers_id']) && ($_GET['manufacturers_id'] == $manufacturers['manufacturers_id'])) $manufacturers_name = '<b>' . $manufacturers_name .'</b>';
        $manufacturers_list .= '<a href="' . tep_href_link(FILENAME_DEFAULT, 'manufacturers_id=' . $manufacturers['manufacturers_id']) . '">' . $manufacturers_name . '</a><br>';

 //echo '<a href="index.php?manufacturers_id='. $manufacturers['manufacturers_id']   .'"target="_self">' . $manufacturers['manufacturers_name'] .'</a>';
//echo $options[$c]['text']. ' ' . $manufacturers['manufacturers_name'] .'<br>';
if ($options[$c]['text']== $manufacturers['manufacturers_name']){
   $new[$c-1]='<a href="index.php?'.  tep_get_path($current_category_id)  .'&filter_id='. $manufacturers['manufacturers_id']   .' "target="_self">' . $manufacturers['manufacturers_name'] .'</a>';
                $c++;     } else {}


            }

 // echo $current_category_id;
for ($col=0, $n=sizeof($new); $col<$n; $col++) {
      $info_box_contents[$col] = array('form' => tep_draw_form('manufacturers', tep_href_link(FILENAME_DEFAULT, '', 'NONSSL', false), 'get'),
                                 'text' => $new[$col]);
          $all.= $new[$col];
        if ($col < sizeof($new))  $all.=', ';
                                }
                                
 // new iBox($all);

?>
<table class="infoBox table-padding-1">
  <tr>
    <td><table border="0" width="100%" cellspacing="0" cellpadding="3" class="infoBoxContents">
  <tr>
    <td><div class="row-height-1"></td>
  </tr>
  <tr>
    <td align="left" class="boxText">
<br>
<?php

  echo $all;
?>  

<?php
echo '<a href="index.php?'. tep_get_path($current_category_id) .' "target="_self">'.TEXT_ALL.'</a>';
?>
<br>
<br>
</td>
  </tr>
  <tr>
    <td><div class="row-height-1"></td>
  </tr>

</table>
</td>
  </tr>
  </table>
            </td>
          </tr>

<?php } ?>