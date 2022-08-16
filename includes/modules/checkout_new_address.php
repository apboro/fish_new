<?php
/*
  $Id: checkout_new_address.php,v 1.1.1.1 2003/09/18 19:04:53 wilt Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/

  if (!isset($process)) $process = false;
?>
<table class="table-padding-2">
<?php
  if (ACCOUNT_GENDER == 'true') {
    if (isset($gender)) {
      $male = ($gender == 'm') ? true : false;
      $female = ($gender == 'f') ? true : false;
    } else {
      $male = false;
      $female = false;
    }
?>
  <tr>
    <td class="main"><?php echo ENTRY_GENDER; ?></td>
    <td class="main"><?php echo tep_draw_radio_field('gender', 'm', $male) . '&nbsp;&nbsp;' . MALE . '&nbsp;&nbsp;' . tep_draw_radio_field('gender', 'f', $female) . '&nbsp;&nbsp;' . FEMALE . '&nbsp;' . (tep_not_null(ENTRY_GENDER_TEXT) ? '<span class="inputRequirement">' . ENTRY_GENDER_TEXT . '</span>': ''); ?></td>
  </tr>
<?php
  }
?>
  <tr>
    <td class="main"><?php echo ENTRY_FIRST_NAME; ?></td>
    <td class="main"><?php echo tep_draw_input_field('firstname') . '&nbsp;' . (tep_not_null(ENTRY_FIRST_NAME_TEXT) ? '<span class="inputRequirement">' . ENTRY_FIRST_NAME_TEXT . '</span>': ''); ?></td>
  </tr>
  <tr>
    <td class="main"><?php echo ENTRY_LAST_NAME; ?></td>
    <td class="main"><?php echo tep_draw_input_field('lastname') . '&nbsp;' . (tep_not_null(ENTRY_LAST_NAME_TEXT) ? '<span class="inputRequirement">' . ENTRY_LAST_NAME_TEXT . '</span>': ''); ?></td>
  </tr>
<?php
  if (ACCOUNT_COMPANY == 'true') {
?>
  <tr>
    <td class="main"><?php echo ENTRY_COMPANY; ?></td>
    <td class="main"><?php echo tep_draw_input_field('company') . '&nbsp;' . (tep_not_null(ENTRY_COMPANY_TEXT) ? '<span class="inputRequirement">' . ENTRY_COMPANY_TEXT . '</span>': ''); ?></td>
  </tr>
<?php
  }
?>
  <tr>
    <td class="main"><?php echo ENTRY_STREET_ADDRESS; ?></td>
    <td class="main"><?php echo tep_draw_input_field('street_address') . '&nbsp;' . (tep_not_null(ENTRY_STREET_ADDRESS_TEXT) ? '<span class="inputRequirement">' . ENTRY_STREET_ADDRESS_TEXT . '</span>': ''); ?></td>
  </tr>
<?php
  if (ACCOUNT_SUBURB == 'true') {
?>
  <tr>
    <td class="main"><?php echo ENTRY_SUBURB; ?></td>
    <td class="main"><?php echo tep_draw_input_field('suburb') . '&nbsp;' . (tep_not_null(ENTRY_SUBURB_TEXT) ? '<span class="inputRequirement">' . ENTRY_SUBURB_TEXT . '</span>': ''); ?></td>
  </tr>
<?php
  }
?>
  <tr>
    <td class="main"><?php echo ENTRY_POST_CODE; ?></td>
    <td class="main"><?php echo tep_draw_input_field('postcode') . '&nbsp;' . (tep_not_null(ENTRY_POST_CODE_TEXT) ? '<span class="inputRequirement">' . ENTRY_POST_CODE_TEXT . '</span>': ''); ?></td>
  </tr>
  <tr>
    <td class="main"><?php echo ENTRY_CITY; ?></td>
    <td class="main"><?php echo tep_draw_input_field('city') . '&nbsp;' . (tep_not_null(ENTRY_CITY_TEXT) ? '<span class="inputRequirement">' . ENTRY_CITY_TEXT . '</span>': ''); ?></td>
  </tr>
<?php
  if (ACCOUNT_COUNTRY == 'true') {
?>
              <tr>
                <td class="main"><?php echo ENTRY_COUNTRY; ?></td>
                <td class="main"><?php echo tep_get_country_list('country',STORE_COUNTRY, 'onChange="changeselect();"') . '&nbsp;' . (tep_not_null(ENTRY_COUNTRY_TEXT) ? '<span class="inputRequirement">' . ENTRY_COUNTRY_TEXT . '</span>': ''); ?></td>
              </tr>
<?php
  }
?>
<?php
if (ACCOUNT_STATE == 'true') {
?>
             <tr>
               <td class="main"><?php echo ENTRY_STATE;?></td>
               <td class="main">
<script language="javascript">
<!--
function changeselect(reg) {
//clear select
    document.checkout_address.state.length=0;
    var j=0;
    for (var i=0;i<zones.length;i++) {
      if (zones[i][0]==document.checkout_address.country.value) {
   document.checkout_address.state.options[j]=new Option(zones[i][1],zones[i][1], zones[i][2]);
   j++;
   }
      }
    if (j==0) {
      document.checkout_address.state.options[0]=new Option('-','-');
      }
    if (reg) { document.checkout_address.state.value = reg; }
}
   var zones = new Array(
   <?php
       $zones_query = tep_db_query("select zone_country_id,zone_id,zone_name from " . TABLE_ZONES . " order by zone_name asc");
       $mas=array();
       while ($zones_values = tep_db_fetch_array($zones_query)) {
       	($zones_values['zone_id'] == STORE_ZONE) ? $selected = 'true' : $selected = 'false';
         $zones[] = 'new Array('.$zones_values['zone_country_id'].',"'.$zones_values['zone_name'].'",'.$selected.')';
       }
       echo implode(',',$zones);
       ?>
       );
document.write('<SELECT NAME="state">');
document.write('</SELECT>');
changeselect("<?php echo tep_db_prepare_input($_POST['state']); ?>");
-->
</script>
          </td>
             </tr>
<?php
}
?>
</table>
