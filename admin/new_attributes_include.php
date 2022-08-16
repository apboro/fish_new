<TR>
<TD class="pageHeading" colspan="9"><?php echo $pageTitle?></TD>
</TR>
<FORM ACTION="<?php echo FILENAME_NEW_ATTRIBUTE_MANAGER; ?>" METHOD="POST" NAME="SUBMIT_ATTRIBUTES">
<INPUT TYPE="HIDDEN" NAME="current_product_id" VALUE="<?php echo $current_product_id; ?>">
<INPUT TYPE="HIDDEN" NAME="action" VALUE="change">
<?php

$cPathID = $_POST['cPathID'];
$current_product_id = $_POST['current_product_id'];
$languageFilter = $languages_id;

if ( $cPath ) echo "<INPUT TYPE=\"HIDDEN\" NAME=\"cPathID\" VALUE=\"" . $cPath . "\">";

require( 'new_attributes_functions.php');

// Temp id for text input contribution.. I'll put them in a seperate array.
$tempTextID= "1999043";

// Lets get all of the possible options

$query = "SELECT * FROM products_options where products_options_id LIKE '%' AND language_id = '$languageFilter'";

$result = tep_db_query($query) or die(mysqli_error());

$matches = tep_db_num_rows($result);
// ########################## added for download
//        echo "<p class=\"smallText\">(Download-Dateien nur in Optionen, die im Namen 'download' enthalten!)</p>";
// ########################## added for download
if ($matches) {

   while ($line = tep_db_fetch_array($result, MYSQLI_ASSOC)) {
                                                           	
        $current_product_option_name = $line['products_options_name'];
        $current_product_option_id = $line['products_options_id'];

// Print the Option Name
        echo "<TR class=\"dataTableHeadingRow\">";
        echo "<TD class=\"dataTableHeadingContent\" width=150><B>" . $current_product_option_name . "</B></TD>";
        echo "<TD class=\"dataTableHeadingContent\"><B>". TEXT_NEW_ATTRIBUTE_PREFIX . "</B></TD>";
        echo "<TD class=\"dataTableHeadingContent\"><B>". TEXT_NEW_ATTRIBUTE_PRICE . "</B></TD>";
        
        if ( $optionTypeInstalled == "1" ) {
                
                echo "<TD class=\"dataTableHeadingContent\"><B>Option Type</B></TD>";
                echo "<TD class=\"dataTableHeadingContent\"><B>Quantity</B></TD>";
                echo "<TD class=\"dataTableHeadingContent\"><B>Order</B></TD>";
                echo "<TD class=\"dataTableHeadingContent\"><B>Linked Attr.</B></TD>";
                echo "<TD class=\"dataTableHeadingContent\"><B>ID</B></TD>";
                
        }
        
                echo "<TD class=\"dataTableHeadingContent\"><B>". TEXT_NEW_ATTRIBUTE_PREFIX . "</B></TD>";
                echo "<TD class=\"dataTableHeadingContent\"><B>". TEXT_NEW_ATTRIBUTE_WEIGHT . "</B></TD>";
                echo "<TD class=\"dataTableHeadingContent\"><B>". TEXT_NEW_ATTRIBUTE_SORT_ORDER . "</B></TD>";

// ############################# added for download
        if (DOWNLOAD_ENABLED == 'true') 
        {
//                if(preg_match('/download/',strtolower($current_product_option_name)))
//                {
						        echo "<TD class=\"dataTableHeadingContent\"><B>". TEXT_NEW_ATTRIBUTE_FILE . "</B></TD>";
						        echo "<TD class=\"dataTableHeadingContent\"><B>". TEXT_NEW_ATTRIBUTE_MAX_COUNT . "</B></TD>";
						        echo "<TD class=\"dataTableHeadingContent\"><B>". TEXT_NEW_ATTRIBUTE_MAX_DOWNLOAD . "</B></TD>";
						        echo "<TD class=\"dataTableHeadingContent\">&nbsp;</TD>";
//                }
        }
// ############################# end added for download

        echo "</TR>";
        
// Find all of the Current Option's Available Values
        $query2 = "SELECT * FROM products_options_values_to_products_options WHERE products_options_id = '$current_product_option_id' ORDER BY products_options_values_id DESC";

        $result2 = tep_db_query($query2) or die(mysqli_error());
        
        $matches2 = tep_db_num_rows($result2);

        if ($matches2) {

           $i = "0";

           while ($line = tep_db_fetch_array($result2, MYSQLI_ASSOC)) {

                $i++;
                
                $rowClass = rowClass( $i );

                $current_value_id = $line['products_options_values_id'];

                $isSelected = checkAttribute( $current_value_id, $current_product_id, $current_product_option_id );

                if ($isSelected) { $CHECKED = " CHECKED"; } else { $CHECKED = ""; }
                
                $query3 = "SELECT * FROM products_options_values WHERE products_options_values_id = '$current_value_id' AND language_id = '$languageFilter'";
                
                $result3 = tep_db_query($query3) or die(mysqli_error());

                while($line = tep_db_fetch_array($result3, MYSQLI_ASSOC)) {

                        $current_value_name = $line['products_options_values_name'];

// Print the Current Value Name
                        echo "<TR class=\"" . $rowClass . "\">";
                        echo "<TD class=\"main\" width=150>";

// Add Support for multiple text input option types (for Chandra's contribution).. and using ' to begin/end strings.. less of a mess.
                        if ( $optionTypeTextInstalled == "1" && $current_value_id == $optionTypeTextInstalledID ) {

                                $current_value_id_old = $current_value_id;
                                $current_value_id = $tempTextID;

                                echo '<input type="checkbox" name="optionValuesText[]" value="' . $current_value_id . '"' . $CHECKED . '>&nbsp;&nbsp;' . $current_value_name . '&nbsp;&nbsp;';
                                echo '<input type="hidden" name="' . $current_value_id . '_options_id" value="' . $current_product_option_id . '">';
                                
                        } else {

                        echo "<input type=\"checkbox\" name=\"optionValues[]\" value=\"" . $current_value_id . "\"" . $CHECKED . ">&nbsp;&nbsp;" . $current_value_name . "&nbsp;&nbsp;";
                        
                        }

                        echo "</TD>";
                                echo "<TD class=\"main\" align=\"right\"><SELECT name=\"" . $current_value_id . "_prefix\"> <OPTION value=\"+\"" . $posCheck . ">+<OPTION value=\"-\"" . $negCheck . ">-</SELECT></TD>";
                                getSortCopyValues( $current_value_id, $current_product_id );

                        echo "<TD class=\"main\" align=\"left\"><input type=\"text\" name=\"" . $current_value_id . "_price\" value=\"" . $attribute_value_price . "\" size=\"10\"></TD>";
                               
                                echo "<TD class=\"main\" align=\"right\"><SELECT name=\"" . $current_value_id . "_weight_prefix\"> <OPTION value=\"+\"" . $wposCheck . ">+<OPTION value=\"-\"" . $wnegCheck . ">-</SELECT></TD>";
                                getSortCopyValues( $current_value_id, $current_product_id );
                                echo "</SELECT></TD>";
                                                            	
                               
                                echo "<TD class=\"main\" align=\"left\"><input type=\"text\" name=\"" . $current_value_id . "_weight\" value=\"" . $attribute_weight . "\" size=\"10\"></TD>";

                        echo "<TD class=\"smallText\" align=\"left\" NOWRAP><input type=\"text\" name=\"" . $current_value_id . "_sort\" value=\"" . $attribute_value_sort_order . "\" size=\"3\"></TD>";


// ############################# added for download
        if (DOWNLOAD_ENABLED == 'true') 
        {
//                if(preg_match('/download/',strtolower($current_product_option_name)))
//                {
	                $query4 = "SELECT pa.products_attributes_id, 
	                pad.products_attributes_filename, 
	                pad.products_attributes_maxdays,
	                pad.products_attributes_maxcount,
	                pad.products_attributes_is_pin 
	                FROM products_attributes pa,products_attributes_download pad 
	                WHERE pa.products_id='$current_product_id' AND pa.options_id='$current_product_option_id' AND pa.options_values_id = '$current_value_id' AND pad.products_attributes_id=pa.products_attributes_id";
	                $result4 = tep_db_query($query4) or die(mysqli_error());                   
	    
	                $current_products_attributes_id=$dl_line['products_attributes_id'];

	                $dl_line = tep_db_fetch_array($result4, MYSQLI_ASSOC);
                  
	                if($dl_line['products_attributes_filename']=='')
	                {
	                  $dl_line['products_attributes_maxdays']=DOWNLOAD_MAX_DAYS;
	                  $dl_line['products_attributes_maxcount']=DOWNLOAD_MAX_COUNT;
	                }

	                echo "<TD class=\"main\" align=\"left\"><input type=\"text\" id=\"" . $current_value_id . "_dlfile\"  name=\"" . $current_value_id . "_dlfile\" value=\"" . $dl_line['products_attributes_filename'] . "\" size=\"10\"></TD>";
	                echo "<TD class=\"main\" align=\"left\"><input type=\"text\" name=\"" . $current_value_id . "_dldays\" value=\"" . $dl_line['products_attributes_maxdays'] . "\" size=\"10\"></TD>";
	                echo "<TD class=\"main\" align=\"left\"><input type=\"text\" name=\"" . $current_value_id . "_dlcount\" value=\"" . $dl_line['products_attributes_maxcount'] . "\" size=\"10\"></TD/";
	                ?>
	                                   <!-- //PIN add -->
                  <TD class="main" align="left"><?php echo TABLE_TEXT_IS_PIN; ?> <?php echo tep_draw_checkbox_field($current_value_id . '_ispin', '',  $dl_line['products_attributes_is_pin'],1); ?>&nbsp;</td>
                  <!-- //PIN end -->
<?php
//                }
/*
                else
                {
	                echo "<TD class=\"main\" align=\"left\">&nbsp;</TD>";
	                echo "<TD class=\"main\" align=\"left\">&nbsp;</TD>";
	                echo "<TD class=\"main\" align=\"left\">&nbsp;</TD>";
                }
*/
// ############################# end added for download
        }
                        echo "</TR>";

                        if ( $optionTypeTextInstalled == "1" && $current_value_id_old == $optionTypeTextInstalledID ) {

                           $tempTextID++;

                        }

                }
                
                if( $i == $matches2 ) { $i = "0"; }

           }

        } else {
          echo "<TR>";
          echo "<TD class=\"main\"><SMALL>" . TEXT_NEW_ATTRIBUTE_NO_VALUES . "</SMALL></TD>";
          echo "</TR>";


   }

}
}

?>
<TR>
<TD colspan="8" class="main"><BR><INPUT TYPE="image" src="<?php echo $adminImages?>button_save.gif">&nbsp;&nbsp;&nbsp;<?php echo $backLink?><img src="<?php echo $adminImages?>button_cancel.gif" border="0"></A></TD>
</TR>
</FORM>