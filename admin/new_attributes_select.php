<TR>
<TD class="pageHeading" colspan="3"><?php echo $pageTitle; ?></TD>
</TR>
<FORM ACTION="<?php echo FILENAME_NEW_ATTRIBUTE_MANAGER; ?>" NAME="SELECT_PRODUCT" METHOD="POST">
<INPUT TYPE="HIDDEN" NAME="action" VALUE="select">
<?php

$cPathID = $_POST['cPathID'];
$current_product_id = $_POST['current_product_id'];
$languageFilter = $languages_id;

echo "<TR>";
echo "<TD class=\"main\"><BR><B>" . TEXT_NEW_ATTRIBUTE_SELECT . "<BR></TD>";
echo "</TR>";
echo "<TR>";
echo "<TD class=\"main\"><SELECT NAME=\"current_product_id\">";

$query = "SELECT * FROM products_description where products_id LIKE '%' AND language_id = '$languageFilter' ORDER BY products_name ASC";

$result = tep_db_query($query) or die(mysqli_error());

$matches = tep_db_num_rows($result);

if ($matches) {

   while ($line = tep_db_fetch_array($result, MYSQLI_ASSOC)) {
                                                           	
        $title = $line['products_name'];
        $current_product_id = $line['products_id'];
        
        echo "<OPTION VALUE=\"" . $current_product_id . "\">" . $title;
        
   }
} else { echo TEXT_NEW_ATTRIBUTE_NO_PRODUCTS; }
   
echo "</SELECT>";
echo "</TD></TR>";

echo "<TR>";
echo "<TD class=\"main\"><input type=\"image\" src=\"" . $adminImages . "button_edit.gif\"></TD>";
echo "</TR>";

?>
</FORM>