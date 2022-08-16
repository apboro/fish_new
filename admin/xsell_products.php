<?php
/*
$Id$

osCommerce, Open Source E-Commerce Solutions
http://www.oscommerce.com

Copyright (c) 2002 osCommerce

Released under the GNU General Public License

cross.sale.php. Created By Isaac Mualem im@imwebdesigning.com <mailto:im@imwebdesigning.com>

and has little changed Medreces medreces@yandex.ru
*/

require('includes/application_top.php');

require(DIR_WS_CLASSES . 'currencies.php');
$currencies = new currencies();

//Medreces insert Filter categories & manufactures !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
$manufacturers_array = array(array('id' => '', 'text' => TEXT_NONE));
// BOF manufacturers descriptions
//  $manufacturers_query = tep_db_query("select manufacturers_id, manufacturers_name from " . TABLE_MANUFACTURERS . " order by manufacturers_name");
    $manufacturers_query = tep_db_query("select manufacturers_id, manufacturers_name from " . TABLE_MANUFACTURERS_INFO . " where languages_id = '" . (int)$languages_id . "' order by manufacturers_name");
// EOF manufacturers descriptions
while ($manufacturers = tep_db_fetch_array($manufacturers_query)) {
  $manufacturers_array[] = array('id' => $manufacturers['manufacturers_id'],
                                 'text' => $manufacturers['manufacturers_name']);
}

$CATEGORIES_id = 0;
if ( isset($_POST['categories_id']) ) {
  $CATEGORIES_id = $_POST['categories_id'];
} elseif ( isset($_GET['categories_id']) ) $CATEGORIES_id = $_GET['categories_id'];

$MANUFACTURES_id = 0;
if ( isset($_POST['manufacturers_id']) ) {
  $MANUFACTURES_id = $_POST['manufacturers_id'];
} elseif ( isset($_GET['manufacturers_id']) ) $MANUFACTURES_id = $_GET['manufacturers_id'];


//Medreces insert Filter categories & manufactures !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!

?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<title><?php echo TITLE; ?></title>
<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
<script language="JavaScript1.2">

function cOn(td)
{
if(document.getElementById||(document.all && !(document.getElementById)))
{
td.style.backgroundColor="#CCCCCC";
}
}

function cOnA(td)
{
if(document.getElementById||(document.all && !(document.getElementById)))
{
td.style.backgroundColor="#CCFFFF";
}
}

function cOut(td)
{
if(document.getElementById||(document.all && !(document.getElementById)))
{
td.style.backgroundColor="DFE4F4";
}
}
</script>
</head>
<body marginwidth="0" marginheight="0" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0" bgcolor="#FFFFFF">
<!-- header //-->
<?php include(DIR_WS_INCLUDES . 'header.php'); ?>
<!-- header_eof //-->
<table border="0" width="100%" cellspacing="2" cellpadding="2">
<tr>
  <td width="<?php echo BOX_WIDTH; ?>" valign="top"><table border="0" width="<?php echo BOX_WIDTH; ?>" cellspacing="1" cellpadding="1" class="columnLeft">
      <!-- left_navigation //-->
      <?php require(DIR_WS_INCLUDES . 'column_left.php'); ?>
      <!-- left_navigation_eof //-->
    </table>
  </td>
  <!-- body_text //-->
  <td width="100%" valign="top"><table class="table-padding-2">
      <tr>
        <td><table class="table-padding-0">
            <tr>
              <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
              <td class="pageHeading" align="right"><?php echo tep_draw_separator('pixel_trans.gif', HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?></td>
            </tr>
<?php //Medreces insert Filter categories & manufactures !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! ?>
            <TR class="smallText"><?php echo tep_draw_form('filter_xsell_products', FILENAME_XSELL_PRODUCTS, ($first_entrance ? '' : tep_get_all_get_params())); ?>
                <td class="smallText" align="left"><?php echo XSELL_FILTERS; ?></td>
                <td class="smallText" align="right">
                  <?php echo XSELL_CATEGORIES . tep_draw_pull_down_menu('categories_id', tep_get_category_tree(), $CATEGORIES_id);
                        echo '<br>' . XSELL_MANUFACTURERS . tep_draw_pull_down_menu('manufacturers_id', $manufacturers_array, $MANUFACTURES_id);
       			  ?>
                </td>
				<TD class="dataTableContent" align="right"><?php echo tep_image_submit('button_select.gif', XSELL_SELECT); ?></TD>
            </form></TR>
<?php  // !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! ?>
          </table>
        </td>
      </tr>
      <!-- body_text //-->
      <tr><td width="100%" valign="top">
          <!-- Start of cross sale //-->
          <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td align=center>
                <?php
/* general_db_conct($query) Function */
/* To call use: list ($test_a, $test_b) = general_db_conct($query); */
function general_db_conct($query_1)
{
$result_1 = tep_db_query($query_1);
$num_of_rows = tep_db_num_rows($result_1);
for ($i=0; $i < $num_of_rows; $i++) {
	$fields = mysqli_fetch_row($result_1);
	$a_to_pass[$i] = $fields[$y=0];
	$b_to_pass[$i] = $fields[++$y];
	$c_to_pass[$i] = $fields[++$y];
	$d_to_pass[$i] = $fields[++$y];
	$e_to_pass[$i] = $fields[++$y];
	$f_to_pass[$i] = $fields[++$y];
	$g_to_pass[$i] = $fields[++$y];
	$h_to_pass[$i] = $fields[++$y];
	$i_to_pass[$i] = $fields[++$y];
	$j_to_pass[$i] = $fields[++$y];
	$k_to_pass[$i] = $fields[++$y];
	$l_to_pass[$i] = $fields[++$y];
	$m_to_pass[$i] = $fields[++$y];
	$n_to_pass[$i] = $fields[++$y];
	$o_to_pass[$i] = $fields[++$y];
}

return array($a_to_pass,$b_to_pass,$c_to_pass,$d_to_pass,$e_to_pass,$f_to_pass,$g_to_pass,$h_to_pass,$i_to_pass,$j_to_pass,$k_to_pass,$l_to_pass,$m_to_pass,$n_to_pass,$o_to_pass);
} // End of function general_db_conct()

////////////////////////////////////////////////////////////////////////////////////////////////
// This bit does the first page. Lists all products and their X-sells

if (!$_GET['add_related_product_ID'] && !$first_entrance)
{

/* Multiple Language fix --- mail@michaelding.net <mailto:mail@michaelding.net> */
$query = "select
b.language_id,a.products_id, b.products_name, b.products_description,a.products_quantity, a.products_model, b.products_url, a.products_price
FROM
products a, products_description b, products_to_categories p2c WHERE products_status = 1 and b.products_id = a.products_id AND b.products_id=p2c.products_id AND b.language_id ='" . $languages_id . "'" . ($CATEGORIES_id ?  " AND p2c.categories_id ='" . $CATEGORIES_id . "'" : "") . ($MANUFACTURES_id ? " AND a.manufacturers_id ='" . $MANUFACTURES_id . "'" : "" ) . " ORDER BY b.products_name;";
list ($LANGUAGE_id,$PRODUCTS_id, $PRODUCTS_name, $PRODUCTS_description , $PRODUCTS_quantity , $PRODUCTS_model , $PRODUCTS_url , $PRODUCTS_price ) = general_db_conct($query);
?>
                <table border="0" cellspacing="1" cellpadding="2" bgcolor="#999999">
                  <tr class="dataTableHeadingRow">
                    <td class="dataTableHeadingContent" width="75"><?php echo XSELL_PRODUCT_ID; ?></td>
                    <td class="dataTableHeadingContent"><?php echo XSELL_PRODUCT_MODEL; ?></td>
                    <td class="dataTableHeadingContent"><?php echo XSELL_PRODUCT_NAME; ?></td>
                    <td class="dataTableHeadingContent" nowrap><?php echo XSELL_PRODUCT_CURRENT; ?></td>
                    <td class="dataTableHeadingContent" colspan=2 nowrap align=center><?php echo XSELL_PRODUCT_UPDATE; ?></td>
                  </tr>
<?php
$num_of_products = sizeof($PRODUCTS_id);
for ($i=0; $i < $num_of_products; $i++)
{
/* now we will query the DB for existing related items */
 $query = "select b.products_name, a.xsell_id, c.products_model from " . TABLE_PRODUCTS_XSELL . " a," . TABLE_PRODUCTS_DESCRIPTION . " b," . TABLE_PRODUCTS ." c WHERE b.products_id = a.xsell_id and a.products_id ='" . $PRODUCTS_id[$i] . "' and b.products_id = c.products_id ORDER BY sort_order";
					list ($related_items, $xsell_ids, $product_models) = general_db_conct($query);
					echo "<tr onMouseOver=\"cOn(this); this.style.cursor='pointer'; this.style.cursor='hand';\" onMouseOut=\"cOut(this);\" bgcolor='#DFE4F4' onClick=document.location.href='" . tep_href_link(FILENAME_XSELL_PRODUCTS, 'add_related_product_ID=' . $PRODUCTS_id[$i] . '&categories_id=' . $CATEGORIES_id . '&manufacturers_id=' . $MANUFACTURES_id , 'NONSSL') . "'>";
echo "<td class=\"dataTableContent\" valign=\"top\">&nbsp;".$PRODUCTS_id[$i]."&nbsp;</td>\n";
					echo "<td class=\"dataTableContent\" valign=\"top\">" . $PRODUCTS_model[$i]."&nbsp;</td>\n";
echo "<td class=\"dataTableContent\" valign=\"top\">&nbsp;".$PRODUCTS_name[$i]."&nbsp;</td>\n";
					if ($related_items)
{
echo "<td class=\"dataTableContent\"><ol>";
						for ($j = 0; $j < count($related_items); $j++) {
							echo '<li><strong>' . $product_models[$j] . '</strong> ' . $related_items[$j] .  '</li>';
						}
echo"</ol></td>\n";
}
else
echo "<td class=\"dataTableContent\">--</td>\n";
echo '<td class="dataTableContent" valign="top">&nbsp;<a href="' . tep_href_link(FILENAME_XSELL_PRODUCTS, 'add_related_product_ID=' . $PRODUCTS_id[$i] . '&categories_id=' . $CATEGORIES_id . '&manufacturers_id=' . $MANUFACTURES_id , 'NONSSL') . '">' . XSELL_EDIT . '</a>&nbsp;</td>';

					if (count($related_items)>1)
{
echo '<td class="dataTableContent" valign="top">&nbsp;<a href="' . tep_href_link(FILENAME_XSELL_PRODUCTS, 'sort=1&add_related_product_ID=' . $PRODUCTS_id[$i] . '&categories_id=' . $CATEGORIES_id . '&manufacturers_id=' . $MANUFACTURES_id , 'NONSSL') . '">' . XSELL_SORT_ORDER . '</a>&nbsp;</td>';
} else {
echo "<td class=\"dataTableContent\" valign=top align=center>--</td>";
}
echo "</tr>\n";
					unset($related_items);
}
?>
                </table>
                <?php
} // the end of -> if (!$add_related_product_ID)

//////////////////////////////////////////////////////////////////////////////////
// This bit does the 'EDIT' page (previously Add/Remove)

if ( ($_POST[run_update] || $_POST[xsell_id]) && $_POST[add_related_product_ID] && !$sort && !$first_entrance) {
  if ($_POST[run_update]==true) {
	$query ="DELETE FROM " . TABLE_PRODUCTS_XSELL . " WHERE products_id = '".$_POST[add_related_product_ID]."'";
	if (!tep_db_query($query)) exit('could not delete');
  }
  if ($_POST[xsell_id])
	foreach ($_POST[xsell_id] as $temp) {
	  $query = "INSERT INTO " . TABLE_PRODUCTS_XSELL . " VALUES ('',$_POST[add_related_product_ID],$temp,1)";
	    if (!tep_db_query($query)) exit('could not insert to DB');
	}
  echo '<a href="' . tep_href_link(FILENAME_XSELL_PRODUCTS, 'categories_id=' . $CATEGORIES_id . '&manufacturers_id=' . $MANUFACTURES_id, 'NONSSL') . '">' . XSELL_NEW_XSELL .'</a><br>' . "\n";
  if ($_POST[xsell_id])
	echo '<a href="' . tep_href_link(FILENAME_XSELL_PRODUCTS, 'sort=1&add_related_product_ID=' . $_POST[add_related_product_ID] . '&categories_id=' . $CATEGORIES_id . '&manufacturers_id=' . $MANUFACTURES_id, 'NONSSL') . '">' . XSELL_SORT_ORDER_XSELL .'</a>' . "\n";
}

if ($_GET['add_related_product_ID'] && ! ($_POST[run_update] || $_POST[xsell_id] ) && !$sort && !$first_entrance)
{ ?>
                <table border="0" cellpadding="2" cellspacing="1" bgcolor="#999999">
                  <form action="<?php tep_href_link(FILENAME_XSELL_PRODUCTS, '', 'NONSSL'); ?>" method="post">
                    <tr class="dataTableHeadingRow">
                      <?php
$query = "select b.language_id, a.products_id, b.products_name, b.products_description, " .
"a.products_quantity, a.products_model, " .
"b.products_url, a.products_price from products a, products_description b where products_status = 1 and b.products_id = a.products_id and b.language_id = '" . $languages_id . "' and a.products_id = '".$_GET['add_related_product_ID']."'";
list ($language_id, $PRODUCTS_id, $PRODUCTS_name, $PRODUCTS_description , $PRODUCTS_quantity , $PRODUCTS_model , $PRODUCTS_url , $PRODUCTS_price ) = general_db_conct($query);
		echo '<span class="pageHeading">' . XSELL_ADD_NEW . $PRODUCTS_model[0] . ' (' . XSELL_PRODUCT_ID .': ' . $PRODUCTS_id[0] . ') </span><br><br>';
?>

                      <td class="dataTableHeadingContent"><?php echo XSELL_PRODUCT_ID; ?></td>
                      <td class="dataTableHeadingContent"><?php echo XSELL_PRODUCT_MODEL; ?></td>
                      <td class="dataTableHeadingContent"><?php echo XSELL_PRODUCT_XSELL; ?></td>
                      <td class="dataTableHeadingContent"><?php echo XSELL_PRODUCT_ITEM_NAME; ?></td>
                      <td class="dataTableHeadingContent"><?php echo XSELL_PRODUCT_PRICE; ?></td>
                    </tr>
                    <?php

$run_update = false; // Set False to insert new entry in the DB
$query = "select * from " . TABLE_PRODUCTS_XSELL . " WHERE products_id = '" . $_GET['add_related_product_ID'] . "'";
list ($ID_PR, $PRODUCTS_id_PR, $xsell_id_PR) = general_db_conct($query);

if ($xsell_id_PR) {
  $run_update = true;
  $num_of_products = sizeof($xsell_id_PR);
?>
                    <tr bgcolor='#FFFFFF'><td COLSPAN=5><?php echo XSELL_PRODUCT_ALREADY; ?></td></tr>
<?php
  for ($i=0; $i < $num_of_products; $i++) {
    $query = 'select b.language_id, a.products_id, b.products_name, b.products_description, a.products_quantity, a.products_model, b.products_url, a.products_price FROM products a, products_description b where products_status = 1 and b.products_id=a.products_id and b.language_id="' . $languages_id . '" and b.products_id="' . $xsell_id_PR[$i] . '" ORDER BY b.products_name';
list ($language_id, $PRODUCTS_id, $PRODUCTS_name, $PRODUCTS_description , $PRODUCTS_quantity , $PRODUCTS_model , $PRODUCTS_url , $PRODUCTS_price ) = general_db_conct($query);
?>
                    <tr bgcolor='#DFE4F4'>
					  <td class="dataTableContent" align=center><?php echo $PRODUCTS_id[0]; ?></td>
					  <td class="dataTableContent" align=center>&nbsp;<?php echo $PRODUCTS_model[0]; ?>&nbsp;</td>
                      <td class="dataTableContent" align="center" valign="middle">
                        <label onMouseOver="this.style.cursor='pointer'; this.style.cursor='hand'">
                        <input onMouseOver="this.style.cursor='pointer'; this.style.cursor='hand'" checked size="20" name="xsell_id[]" type="checkbox" value="<?php echo $PRODUCTS_id[0]; ?>"><?php echo XSELL_PRODUCT_XSELL1; ?></label>
                      </td>
					  <td class="dataTableContent"><?php echo $PRODUCTS_name[0]; ?></td>
					  <td class="dataTableContent"><?php echo $currencies->display_price($PRODUCTS_price[0], tep_get_tax_rate($product_info_values['products_tax_class_id'])); ?></td>
                    </tr>
<?php
  }
}
$query = 'select b.language_id, a.products_id, b.products_name, b.products_description, a.products_quantity, a.products_model, b.products_url, a.products_price FROM products a, products_description b, products_to_categories p2c WHERE products_status = 1 and b.products_id=a.products_id and b.language_id = "' . $languages_id . '" AND a.products_id=p2c.products_id ' . ($CATEGORIES_id ?  ' and p2c.categories_id="' . $CATEGORIES_id . '" ' : '') . ($MANUFACTURES_id ? ' and a.manufacturers_id="' . $MANUFACTURES_id . '" ' : '' ) . ' and a.products_id != "' . $_GET['add_related_product_ID'] . '" ORDER BY b.products_name';
list ($language_id, $PRODUCTS_id, $PRODUCTS_name, $PRODUCTS_description , $PRODUCTS_quantity , $PRODUCTS_model , $PRODUCTS_url , $PRODUCTS_price ) = general_db_conct($query);

if($PRODUCTS_id) {
?>
                    <tr bgcolor='#FFFFFF'><td COLSPAN=5><?php echo XSELL_PRODUCT_ADD; ?></td></tr>
<?php
  $num_of_products = sizeof($PRODUCTS_id);
  for ($i=0; $i < $num_of_products; $i++) {
	if ($xsell_id_PR) /* See if item is in the DB. Not Display - Medreces */
	  foreach ($xsell_id_PR as $compare_checked){
		if ($PRODUCTS_id[$i] === $compare_checked) continue 2;
      }
?>
                    <tr bgcolor='#DFE4F4'>
					  <td class="dataTableContent" align=center><?php echo $PRODUCTS_id[$i]; ?></td>
					  <td class="dataTableContent" align=center>&nbsp;<?php echo $PRODUCTS_model[$i]; ?>&nbsp;</td>
                      <td class="dataTableContent" align="center" valign="middle">
                        <label onMouseOver="this.style.cursor='pointer'; this.style.cursor='hand'">
                        <input onMouseOver="this.style.cursor='pointer'; this.style.cursor='hand'" size="20" name="xsell_id[]" type="checkbox" value="<?php echo $PRODUCTS_id[$i]; ?>"><?php echo XSELL_PRODUCT_XSELL1; ?></label>
                      </td>
					  <td class="dataTableContent"><?php echo $PRODUCTS_name[$i]; ?></td>
					  <td class="dataTableContent"><?php echo $currencies->display_price($PRODUCTS_price[$i], tep_get_tax_rate($product_info_values['products_tax_class_id'])); ?></td>
                    </tr>
<?}?>
                    <tr>
                      <td colspan="4">
                        <input type="hidden" name="run_update" value="<?php if ($run_update==true) echo "true"; else echo "false" ?>">

                        <input type="hidden" name="categories_id" value="<?php echo $CATEGORIES_id;?>">
                        <input type="hidden" name="manufacturers_id" value="<?php echo $MANUFACTURES_id;?>">

                        <input type="hidden" name="add_related_product_ID" value="<?php echo $_GET['add_related_product_ID']; ?>">
                        <input type="submit" name="Submit" value="<?php echo XSELL_PRODUCT_SUBMIT; ?>">
                      </td>
                    </tr>
                  </form>
                </table>
<?}
}
// sort routines
if ($sort==1 && !$first_entrance)
{
// first lets take care of the DB update.
$run_once=0;
if ($_POST)
foreach ($_POST as $key_a => $value_a)
{
tep_db_connect();
$query = "UPDATE " . TABLE_PRODUCTS_XSELL . " SET sort_order = '" . $value_a . "' WHERE xsell_id= '$key_a' ";
if ($value_a != 'Update')
	if (!tep_db_query($query))
		exit('Could not UPDATE DB');
	else if ($run_once==0)
	{
		echo '<b class=\'main\'><?php echo XSELL_PRODUCT_UPDATED; ?> <a href="' . tep_href_link(FILENAME_XSELL_PRODUCTS, '', 'NONSSL') . '"><?php echo XSELL_PRODUCT_BACK; ?></a></b><br>' . "\n";
		$run_once++;
	}

}// end of foreach.

//////////////////////////////////////////////////////////////////////////////////
// This bit does the 'PRIORITISE' page (previously Sort)

$query = "select b.language_id, a.products_id, b.products_name, b.products_description, " .
"a.products_quantity, a.products_model, " .
"b.products_url, a.products_price from products a, products_description b where products_status = 1 and b.products_id = a.products_id and b.language_id = '" . $languages_id . "' and a.products_id = '" . $_GET['add_related_product_ID'] . "'";

list ($language_id, $PRODUCTS_id, $PRODUCTS_name, $PRODUCTS_description , $PRODUCTS_quantity , $PRODUCTS_model , $PRODUCTS_url , $PRODUCTS_price ) = general_db_conct($query);

?>

                <form method="post" action="<?php tep_href_link(FILENAME_XSELL_PRODUCTS, 'sort=1&add_related_product_ID=' . $_GET['add_related_product_ID'], 'NONSSL'); ?>">

<span class="pageHeading"><?php echo XSELL_ADD_NEW; ?> <?php echo $PRODUCTS_model[0] . ' (' . XSELL_PRODUCT_ID .': ' . $PRODUCTS_id[0] . ') <br><br>'	; ?></span><br><br>

                  <table cellpadding="2" cellspacing="1" bgcolor=999999 border="0">
                    <tr class="dataTableHeadingRow">
                      <td class="dataTableHeadingContent" width="75"><?php echo XSELL_PRODUCT_ID; ?></td>
                      <td class="dataTableHeadingContent" width="75"><?php echo XSELL_PRODUCT_MODEL; ?></td>
                      <td class="dataTableHeadingContent"><?php echo XSELL_PRODUCT_NAME; ?></td>
                      <td class="dataTableHeadingContent" width="150"><?php echo XSELL_PRODUCT_PRICE; ?></td>
                      <td class="dataTableHeadingContent" width="150"><?php echo XSELL_PRODUCT_SORT_ORDER; ?></td>
                    </tr>
                    <?
$query = "select * from " . TABLE_PRODUCTS_XSELL . " WHERE products_id = '" . $_GET['add_related_product_ID'] . "'";
list ($ID_PR, $PRODUCTS_id_PR, $xsell_id_PR, $order_PR) = general_db_conct($query);
$ordering_size = sizeof($ID_PR);

for ($i=0; $i<$ordering_size; $i++)
{
$query = "select b.language_id, a.products_id, b.products_name, b.products_description, " .
"a.products_quantity, a.products_model, " .
"b.products_url, a.products_price from products a, products_description b where products_status = 1 and b.products_id = a.products_id and b.language_id = '" . $languages_id . "' and a.products_id = " . $xsell_id_PR[$i] . "";

list ($language_id, $PRODUCTS_id, $PRODUCTS_name, $PRODUCTS_description , $PRODUCTS_quantity , $PRODUCTS_model , $PRODUCTS_url , $PRODUCTS_price ) = general_db_conct($query);

?>
                    <tr class="dataTableContentRow" bgcolor='#DFE4F4'>
                      <td class="dataTableContent"><?php echo $PRODUCTS_id[0]; ?></td>
                      <!--// Adam@CP: Added Model Number and image thumbnail. -->
                      <td class="dataTableContent"><?php echo $PRODUCTS_model[0] ?></td>
                      <td class="dataTableContent"><?php echo $PRODUCTS_name[0]; ?></td>
                      <td class="dataTableContent"><?php echo $currencies->display_price($PRODUCTS_price[0], tep_get_tax_rate($product_info_values['products_tax_class_id'])); ?></td>
                      <td class="dataTableContent"><select name="<?php echo $PRODUCTS_id[0]; ?>">
                          <?php for ($y=1;$y<=$ordering_size;$y++)
{
echo "<option value=\"$y\"";
if (!(strcmp($y, "$order_PR[$i]"))) {echo "SELECTED";}
echo ">$y</option>";
}
?>
                        </select>
                      </td>
                    </tr>
                    <?php } // the end of foreach ?>
                    <tr>
                      <td colspan="5" bgcolor='#DFE4F4'><input name="runing_update" type="submit" id="runing_update" value="<?php echo XSELL_PRODUCT_UPDATE; ?>">
                      </td>
                    </tr>
                  </table>
                </form>
                <?php }?>
              </td>
            </tr>
          </table>
          <!-- End of cross sale //-->
        </td>
        <!-- products_attributes_eof //-->
      </tr>
    </table>
    <!-- body_text_eof //-->
    <!-- footer //-->
    <?php include(DIR_WS_INCLUDES . 'footer.php'); ?>
    <!-- footer_eof //-->
    <br>
</body>
</html>
<?php include(DIR_WS_INCLUDES . 'application_bottom.php');?>