<?php

// Current EP Version
$curver = '2.75';

/*
  $Id: easypopulate_basic.php,v 1.7 2004/10/06  $
*/
require('epconfigure.php');
include(DIR_WS_LANGUAGES .  $language . '/easypopulate.php');

//*******************************
//*******************************
// S T A R T
// INITIALIZATION
//*******************************
//*******************************
//*******************************
// If you are running a pre-Nov1-2002 snapshot of OSC, then we need this include line to avoid
// errors like:
//   undefined function tep_get_uploaded_file
 if (!function_exists(tep_get_uploaded_file)){
	include ('easypopulate_functions.php');
 }
//*******************************

// VJ product attributes begin
global $attribute_options_array;
$attribute_options_array = array();

if ($products_with_attributes == true) {
	if (is_array($attribute_options_select) && (count($attribute_options_select) > 0)) {
		foreach ($attribute_options_select as $value) {
			$attribute_options_query = "select distinct products_options_id from " . TABLE_PRODUCTS_OPTIONS . " where products_options_name = '" . $value . "'";

			$attribute_options_values = tep_db_query($attribute_options_query);

			if ($attribute_options = tep_db_fetch_array($attribute_options_values)){
				$attribute_options_array[] = array('products_options_id' => $attribute_options['products_options_id']);
			}
		}
	} else {
		$attribute_options_query = "select distinct products_options_id from " . TABLE_PRODUCTS_OPTIONS . " order by products_options_id";

		$attribute_options_values = tep_db_query($attribute_options_query);

		while ($attribute_options = tep_db_fetch_array($attribute_options_values)){
			$attribute_options_array[] = array('products_options_id' => $attribute_options['products_options_id']);
		}
	}
}
// VJ product attributes end

global $filelayout, $filelayout_count, $filelayout_sql, $langcode, $fileheaders;

// these are the fields that will be defaulted to the current values in the database if they are not found in the incoming file
global $default_these;
$default_these = array(
	'v_products_image',
	'v_products_image_med',
	'v_products_image_lrg',
	'v_products_image_sm_1',
	'v_products_image_xl_1',
	'v_products_image_sm_2',
	'v_products_image_xl_2',
	'v_products_image_sm_3',
	'v_products_image_xl_3',
	'v_products_image_sm_4',
	'v_products_image_xl_4',
	'v_products_image_sm_5',
	'v_products_image_xl_5',
	'v_products_image_sm_6',
	'v_products_image_xl_6',
	'v_categories_id',
	'v_products_price',
	'v_products_quantity',
	'v_products_weight',
	'v_date_avail',
	'v_instock',
	'v_tax_class_title',
	'v_manufacturers_name',
	'v_manufacturers_id',
	'v_products_dim_type',
	'v_products_length',
	'v_products_width',
	'v_products_height'
	);

//elari check default language_id from configuration table DEFAULT_LANGUAGE
$epdlanguage_query = tep_db_query("select languages_id, name, code from " . TABLE_LANGUAGES . " where code = '" . DEFAULT_LANGUAGE . "'");
if (tep_db_num_rows($epdlanguage_query)) {
	$epdlanguage = tep_db_fetch_array($epdlanguage_query);
	$epdlanguage_id   = $epdlanguage['languages_id'];
	$epdlanguage_name = $epdlanguage['name'];
	$epdlanguage_code = $epdlanguage['code'];
} else {
	Echo 'Strange but there is no default language to work... That may not happen, just in case... ';
}

$langcode = ep_get_languages();

if ( $dltype != '' ){
	// if dltype is set, then create the filelayout.  Otherwise it gets read from the uploaded file
	ep_create_filelayout($dltype); // get the right filelayout for this download
}

//*******************************
//*******************************
// E N D
// INITIALIZATION
//*******************************
//*******************************


if ( $download == 'stream' or  $download == 'tempfile' ){
	//*******************************
	//*******************************
	// DOWNLOAD FILE
	//*******************************
	//*******************************
	$filestring = ""; // this holds the csv file we want to download

	if ( $dltype=='froogle' ){
		// set the things froogle wants at the top of the file
		//$filestring .= "# html_escaped=YES\n";
		//$filestring .= "# updates_only=NO\n";
		//$filestring .= "# product_type=OTHER\n";
		//$filestring .= "# quoted=YES\n";
	}

	$result = tep_db_query($filelayout_sql);
	$row =  tep_db_fetch_array($result);

	// Here we need to allow for the mapping of internal field names to external field names
	// default to all headers named like the internal ones
	// the field mapping array only needs to cover those fields that need to have their name changed
	if ( count($fileheaders) != 0 ){
		$filelayout_header = $fileheaders; // if they gave us fileheaders for the dl, then use them
	} else {
		$filelayout_header = $filelayout; // if no mapping was spec'd use the internal field names for header names
	}
	//We prepare the table heading with layout values
	foreach( $filelayout_header as $key => $value ){
		$filestring .= $key . $separator;
	}
	// now lop off the trailing tab
	$filestring = substr($filestring, 0, strlen($filestring)-1);

	// set the type
	if ( $dltype == 'froogle' ){
		$endofrow = "\n";
	} else {
		// default to normal end of row
		$endofrow = $separator . 'EOREOR' . "\n";
	}
	$filestring .= $endofrow;

	$num_of_langs = count($langcode);
	while ($row){


		// if the filelayout says we need a products_name, get it
		// build the long full froogle image path
		$row['v_products_fullpath_image'] = $froogle_image_path . $row['v_products_image'];
		// Other froogle defaults go here for now
		$row['v_froogle_instock'] 		= 'Y';
		$row['v_froogle_shipping'] 		= '';
		$row['v_froogle_upc'] 			= '';
		$row['v_froogle_color']			= '';
		$row['v_froogle_size']			= '';
		$row['v_froogle_quantitylevel']		= '';
		$row['v_froogle_manufacturer_id']	= '';
		$row['v_froogle_exp_date']		= '';
		$row['v_froogle_product_type']		= 'OTHER';
		$row['v_froogle_delete']		= '';
		$row['v_froogle_currency']		= 'USD';
		$row['v_froogle_offer_id']		= $row['v_products_model'];
		$row['v_froogle_product_id']		= $row['v_products_model'];

		// names and descriptions require that we loop thru all languages that are turned on in the store
		foreach ($langcode as $key => $lang){
			$lid = $lang['id'];
			$lcd = $lang['code'];

			// for each language, get the description and set the vals
			$sql2 = "SELECT *
				FROM ".TABLE_PRODUCTS_DESCRIPTION."
				WHERE
					products_id = " . $row['v_products_id'] . " AND
					language_id = '" . $lid . "'
				";
			$result2 = tep_db_query($sql2);
			$row2 =  tep_db_fetch_array($result2);

//added cpath
		  // for the categories, we need to keep looping until we find the root category
  		// start with v_categories_id
  		// Get the category description
	  	// set the appropriate variable name
		  // if parent_id is not null, then follow it up.
  		// we'll populate an aray first, then decide where it goes in the
	  	$thecategory_id1 = $row['v_categories_id'];
		  $fullcategory1 = ''; // this will have the entire category stack for froogle
  		for( $categorylevel=1; $categorylevel<$max_categories+1; $categorylevel++){
	  		if ($thecategory_id1){
		  		// now get the parent ID if there was one
			  	$sq23 = "SELECT parent_id
				  	FROM ".TABLE_CATEGORIES."
					  WHERE categories_id = " . $thecategory_id1;
  				$result23 = tep_db_query($sq23);
	  			$row23 =  tep_db_fetch_array($result23);
		  		$theparent_id1 = $row23['parent_id'];
			  }
  			$cPath = $theparent_id1 .  '_'  . $row['v_categories_id'];
      }

			// I'm only doing this for the first language, since right now froogle is US only.. Fix later!
			// adding url for froogle, but it should be available no matter what
			if ($froogle_SEF_urls){
				// if only one language
				if ($num_of_langs == 1){
					$row['v_froogle_products_url_' . $lid] = $froogle_product_info_path . '?cPath='  .  $cPath . '&products_id=' . $row['v_products_id'];
				} else {
					$row['v_froogle_products_url_' . $lid] = $froogle_product_info_path . '?cPath='  .  $cPath . '&products_id=' . $row['v_products_id'] . '&language=' . $epdlanguage_code;
				}
			} else {
				if ($num_of_langs == 1){
					$row['v_froogle_products_url_' . $lid] = $froogle_product_info_path . '?cPath='  .  $cPath . '&products_id=' . $row['v_products_id'];
				} else {
					$row['v_froogle_products_url_' . $lid] = $froogle_product_info_path . '?cPath='  .  $cPath . '&products_id=' . $row['v_products_id'] . '&language=' . $epdlanguage_code;
				}
			}

			$row['v_products_name_' . $lid] 	= $row2['products_name'];
			$row['v_products_description_' . $lid] 	= $row2['products_description'];
			$row['v_products_url_' . $lid] 		= $row2['products_url'];

			// froogle advanced format needs the quotes around the name and desc
			$row['v_froogle_products_name_' . $lid] = '"' . strip_tags(str_replace('"','""',$row2['products_name'])) . '"';
			$row['v_froogle_products_description_' . $lid] = '"' . strip_tags(str_replace('"','""',$row2['products_description'])) . '"';

			// support for Linda's Header Controller 2.0 here
			if(isset($filelayout['v_products_head_title_tag_' . $lid])){
				$row['v_products_head_title_tag_' . $lid] 	= $row2['products_head_title_tag'];
				$row['v_products_head_desc_tag_' . $lid] 	= $row2['products_head_desc_tag'];
				$row['v_products_head_keywords_tag_' . $lid] 	= $row2['products_head_keywords_tag'];
			}
			// end support for Header Controller 2.0
		}

		// for the categories, we need to keep looping until we find the root category

		// start with v_categories_id
		// Get the category description
		// set the appropriate variable name
		// if parent_id is not null, then follow it up.
		// we'll populate an aray first, then decide where it goes in the
		$thecategory_id = $row['v_categories_id'];
		$fullcategory = ''; // this will have the entire category stack for froogle
		for( $categorylevel=1; $categorylevel<$max_categories+1; $categorylevel++){
			if ($thecategory_id){
				$sql2 = "SELECT categories_name
					FROM ".TABLE_CATEGORIES_DESCRIPTION."
					WHERE
						categories_id = " . $thecategory_id . " AND
						language_id = " . $epdlanguage_id ;

				$result2 = tep_db_query($sql2);
				$row2 =  tep_db_fetch_array($result2);
				// only set it if we found something
				$temprow['v_categories_name_' . $categorylevel] = $row2['categories_name'];
				// now get the parent ID if there was one
				$sql3 = "SELECT parent_id
					FROM ".TABLE_CATEGORIES."
					WHERE
						categories_id = " . $thecategory_id;
				$result3 = tep_db_query($sql3);
				$row3 =  tep_db_fetch_array($result3);
				$theparent_id = $row3['parent_id'];
				if ($theparent_id != ''){
					// there was a parent ID, lets set thecategoryid to get the next level
					$thecategory_id = $theparent_id;
				} else {
					// we have found the top level category for this item,
					$thecategory_id = false;
				}
				//$fullcategory .= " > " . $row2['categories_name'];
				$fullcategory = $row2['categories_name'] . " > " . $fullcategory;
			} else {
				$temprow['v_categories_name_' . $categorylevel] = '';
			}
		}
		// now trim off the last ">" from the category stack
		$row['v_category_fullpath'] = substr($fullcategory,0,strlen($fullcategory)-3);

		// temprow has the old style low to high level categories.
		$newlevel = 1;
		// let's turn them into high to low level categories
		for( $categorylevel=6; $categorylevel>0; $categorylevel--){
			if ($temprow['v_categories_name_' . $categorylevel] != ''){
				$row['v_categories_name_' . $newlevel++] = $temprow['v_categories_name_' . $categorylevel];
			}
		}
		// if the filelayout says we need a manufacturers name, get it
		if (isset($filelayout['v_manufacturers_name'])){
			if ($row['v_manufacturers_id'] != ''){
				$sql2 = "SELECT manufacturers_name
					FROM ".TABLE_MANUFACTURERS_INFO."
					WHERE languages_id = " . $epdlanguage_id . " and	manufacturers_id = " . $row['v_manufacturers_id']
					;
				$result2 = tep_db_query($sql2);
				$row2 =  tep_db_fetch_array($result2);
				$row['v_manufacturers_name'] = $row2['manufacturers_name'];
			}
		}


		// If you have other modules that need to be available, put them here

		// VJ product attribs begin
		if (isset($filelayout['v_attribute_options_id_1'])){
			$languages = tep_get_languages();

			$attribute_options_count = 1;
      foreach ($attribute_options_array as $attribute_options) {
				$row['v_attribute_options_id_' . $attribute_options_count] 	= $attribute_options['products_options_id'];

				for ($i=0, $n=sizeof($languages); $i<$n; $i++) {
					$lid = $languages[$i]['id'];

					$attribute_options_languages_query = "select products_options_name from " . TABLE_PRODUCTS_OPTIONS . " where products_options_id = '" . (int)$attribute_options['products_options_id'] . "' and language_id = '" . (int)$lid . "'";

					$attribute_options_languages_values = tep_db_query($attribute_options_languages_query);

					$attribute_options_languages = tep_db_fetch_array($attribute_options_languages_values);

					$row['v_attribute_options_name_' . $attribute_options_count . '_' . $lid] = $attribute_options_languages['products_options_name'];
				}

				$attribute_values_query = "select products_options_values_id from " . TABLE_PRODUCTS_OPTIONS_VALUES_TO_PRODUCTS_OPTIONS . " where products_options_id = '" . (int)$attribute_options['products_options_id'] . "' order by products_options_values_id";

				$attribute_values_values = tep_db_query($attribute_values_query);

				$attribute_values_count = 1;
				while ($attribute_values = tep_db_fetch_array($attribute_values_values)) {
					$row['v_attribute_values_id_' . $attribute_options_count . '_' . $attribute_values_count] 	= $attribute_values['products_options_values_id'];

					$attribute_values_price_query = "select options_values_price, price_prefix from " . TABLE_PRODUCTS_ATTRIBUTES . " where products_id = '" . (int)$row['v_products_id'] . "' and options_id = '" . (int)$attribute_options['products_options_id'] . "' and options_values_id = '" . (int)$attribute_values['products_options_values_id'] . "'";

					$attribute_values_price_values = tep_db_query($attribute_values_price_query);

					$attribute_values_price = tep_db_fetch_array($attribute_values_price_values);

					$row['v_attribute_values_price_' . $attribute_options_count . '_' . $attribute_values_count] 	= $attribute_values_price['price_prefix'] . $attribute_values_price['options_values_price'];

					for ($i=0, $n=sizeof($languages); $i<$n; $i++) {
						$lid = $languages[$i]['id'];

						$attribute_values_languages_query = "select products_options_values_name from " . TABLE_PRODUCTS_OPTIONS_VALUES . " where products_options_values_id = '" . (int)$attribute_values['products_options_values_id'] . "' and language_id = '" . (int)$lid . "'";

						$attribute_values_languages_values = tep_db_query($attribute_values_languages_query);

						$attribute_values_languages = tep_db_fetch_array($attribute_values_languages_values);

						$row['v_attribute_values_name_' . $attribute_options_count . '_' . $attribute_values_count . '_' . $lid] = $attribute_values_languages['products_options_values_name'];
					}

					$attribute_values_count++;
				}

				$attribute_options_count++;
			}
		}
		// VJ product attribs end

		// this is for the separate price per customer module
		if (isset($filelayout['v_customer_price_1'])){
			$sql2 = "SELECT
					customers_group_price,
					customers_group_id
				FROM
					".TABLE_PRODUCTS_GROUPS."
				WHERE
				products_id = " . $row['v_products_id'] . "
				ORDER BY
				customers_group_id"
				;
			$result2 = tep_db_query($sql2);
			$ll = 1;
			$row2 =  tep_db_fetch_array($result2);
			while( $row2 ){
				$row['v_customer_group_id_' . $ll] 	= $row2['customers_group_id'];
				$row['v_customer_price_' . $ll] 	= $row2['customers_group_price'];
				$row2 = tep_db_fetch_array($result2);
				$ll++;
			}
		}
		if ($dltype == 'froogle'){
			// For froogle, we check the specials prices for any applicable specials, and use that price
			// by grabbing the specials id descending, we always get the most recently added special price
			// I'm checking status because I think you can turn off specials
			$sql2 = "SELECT
					specials_new_products_price
				FROM
					".TABLE_SPECIALS."
				WHERE
				products_id = " . $row['v_products_id'] . " and
				status = 1 and
				expires_date < CURRENT_TIMESTAMP
				ORDER BY
					specials_id DESC"
				;
			$result2 = tep_db_query($sql2);
			$ll = 1;
			$row2 =  tep_db_fetch_array($result2);
			if( $row2 ){
				// reset the products price to our special price if there is one for this product
				$row['v_products_price'] 	= $row2['specials_new_products_price'];
			}
		}

		//elari -
		//We check the value of tax class and title instead of the id
		//Then we add the tax to price if $price_with_tax is set to 1
		$row_tax_multiplier 		= tep_get_tax_class_rate($row['v_tax_class_id']);
		$row['v_tax_class_title'] 	= tep_get_tax_class_title($row['v_tax_class_id']);
		$row['v_products_price'] 	= $row['v_products_price'] +
							($price_with_tax * round($row['v_products_price'] * $row_tax_multiplier / 100,2));


		// Now set the status to a word the user specd in the config vars
		if ( $row['v_status'] == '1' ){
			$row['v_status'] = $active;
		} else {
			$row['v_status'] = $inactive;
		}

		// remove any bad things in the texts that could confuse EasyPopulate
		$therow = '';
		foreach( $filelayout as $key => $value ){
			//echo "The field was $key<br>";

			$thetext = $row[$key];
			// kill the carriage returns and tabs in the descriptions, they're killing me!
			$thetext = str_replace("\r",' ',$thetext);
			$thetext = str_replace("\n",' ',$thetext);
			$thetext = str_replace("\t",' ',$thetext);
			// and put the text into the output separated by tabs
			$therow .= $thetext . $separator;
		}

		// lop off the trailing tab, then append the end of row indicator
		$therow = substr($therow,0,strlen($therow)-1) . $endofrow;

		$filestring .= $therow;
		// grab the next row from the db
		$row =  tep_db_fetch_array($result);
	}

	#$EXPORT_TIME=time();
	$EXPORT_TIME = strftime('%Y%b%d-%H%I');
	if ($dltype == 'froogle'){
		$EXPORT_TIME = "FroogleEP" . $EXPORT_TIME;
	} else {
		$EXPORT_TIME = "EPB" . $EXPORT_TIME;
	}
    //end froogle

	// now either stream it to them or put it in the temp directory for all files
	if ($download == 'stream'){
		//*******************************
		// STREAM FILE
		//*******************************
		header("Content-type: application/vnd.ms-excel");
		header("Content-disposition: attachment; filename=$EXPORT_TIME.txt");
		header("Pragma: no-cache");
		header("Expires: 0");
		echo $filestring;
		die();
	} else {
		//*******************************
		// PUT FILE IN TEMP DIR
		//*******************************
		$tmpfname = DIR_FS_DOCUMENT_ROOT . $tempdir . "$EXPORT_TIME.txt";
		//unlink($tmpfname);
		$fp = fopen( $tmpfname, "w+");
		fwrite($fp, $filestring);
		fclose($fp);
		echo EASY_FILE_LOCATE . $tempdir .  $EXPORT_TIME . ".txt" ;

		echo  '<a href="easypopulate_basic.php">' . EASY_FILE_RETURN . '</a><br>';


		die();
	}
}   // *** END *** download section
?>

<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<title><?php echo TITLE; ?></title>
<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
<script language="javascript" src="includes/menu.js"></script>
</head>
<body marginwidth="0" marginheight="0" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0" bgcolor="#FFFFFF">
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>

<table class="table-padding-2">
<tr>
<td width="<?php echo BOX_WIDTH; ?>" valign="top" height="27">
<table border="0" width="<?php echo BOX_WIDTH; ?>" cellspacing="1" cellpadding="1" class="columnLeft">
<?php require(DIR_WS_INCLUDES . 'column_left.php');?>
</table></td>
<td class="pageHeading" valign="top"><?php
echo EASY_VERSION_B . $curver .  EASY_DEFAULT_LANGUAGE . $epdlanguage_name . '(' . $epdlanguage_id .')' ;
?>

<p class="smallText">

<?php

if ($localfile or (is_uploaded_file($usrfl) && $split==0)) {
	//*******************************
	//*******************************
	// UPLOAD AND INSERT FILE
	//*******************************
	//*******************************
//	check files name for EPA

      if (strstr($localfile, 'EPA')){
     echo EASY_ERROR_5 .  '<a href="' . tep_href_link(FILENAME_EASYPOPULATE_BASIC) . '">' . EASY_ERROR_5a . '</a><br>';
die();
     }else{
      }

if (strstr($usrfl_name, 'EPA')){
     echo EASY_ERROR_5 .  '<a href="' . tep_href_link(FILENAME_EASYPOPULATE_BASIC) . '">' . EASY_ERROR_5a . '</a><br>';
die();
     }else{
      }

	if ($usrfl){
		// move the file to where we can work with it
		$file = tep_get_uploaded_file('usrfl');
		if (is_uploaded_file($file['tmp_name'])) {
			tep_copy_uploaded_file($file, DIR_FS_DOCUMENT_ROOT . $tempdir);
		}


		echo '<p class=smallText>';
		echo EASY_UPLOAD_FILE . '<br>';
		echo EASY_UPLOAD_TEMP . $usrfl . '<br>';
		echo EASY_UPLOAD_USER_FILE . $usrfl_name . '<br>';
		echo EASY_SIZE . $usrfl_size . '<br>';

		// get the entire file into an array
		$readed = file(DIR_FS_DOCUMENT_ROOT . $tempdir . $usrfl_name);
	}
	if ($localfile){
		// move the file to where we can work with it
		$file = tep_get_uploaded_file('usrfl');			$attribute_options_query = "select distinct products_options_id from " . TABLE_PRODUCTS_OPTIONS . " order by products_options_id";

			$attribute_options_values = tep_db_query($attribute_options_query);

			$attribute_options_count = 1;
			//while ($attribute_options = tep_db_fetch_array($attribute_options_values)){
		if (is_uploaded_file($file['tmp_name'])) {
			tep_copy_uploaded_file($file, DIR_FS_DOCUMENT_ROOT . $tempdir);
		}

		echo "<p class=smallText>";
		echo  EASY_FILENAME . $localfile . '<br>';

		// get the entire file into an array
		$readed = file(DIR_FS_DOCUMENT_ROOT . $tempdir . $localfile);
	}

	// now we string the entire thing together in case there were carriage returns in the data
	$newreaded = "";
	foreach ($readed as $read){
		$newreaded .= $read;
	}

	// now newreaded has the entire file together without the carriage returns.
	// if for some reason excel put qoutes around our EOREOR, remove them then split into rows
	$newreaded = str_replace('"EOREOR"', 'EOREOR', $newreaded);
	$readed = explode( $separator . 'EOREOR',$newreaded);


	// Now we'll populate the filelayout based on the header row.
	$theheaders_array = explode( $separator, $readed[0] ); // explode the first row, it will be our filelayout
	$lll = 0;
	$filelayout = array();
	foreach( $theheaders_array as $header ){
		$cleanheader = str_replace( '"', '', $header);
	//	echo "Fileheader was $header<br><br><br>";
		$filelayout[ $cleanheader ] = $lll++; //
	}
	unset($readed[0]); //  we don't want to process the headers with the data

	// now we've got the array broken into parts by the expicit end-of-row marker.
	array_walk($readed, 'walk');

}

if (is_uploaded_file($usrfl) && $split==1) {
	//*******************************
	//*******************************
	// UPLOAD AND SPLIT FILE
	//*******************************
	//*******************************

	//	check files name for EPA

	      if (strstr($usrfl_name, 'EPA')){
	     echo EASY_ERROR_5 .  '<a href="' . tep_href_link(FILENAME_EASYPOPULATE_BASIC) . '">' . EASY_ERROR_5a . '</a><br>';

	//tep_redirect(easypopulate_basic.php);
	die();
	     }else{
	      }

	// move the file to where we can work with it
	$file = tep_get_uploaded_file('usrfl');
	//echo "Trying to move file...";
	if (is_uploaded_file($file['tmp_name'])) {
		tep_copy_uploaded_file($file, DIR_FS_DOCUMENT_ROOT . $tempdir);
	}

	$infp = fopen(DIR_FS_DOCUMENT_ROOT . $tempdir . $usrfl_name, "r");

	//toprow has the field headers
	$toprow = fgets($infp,32768);

	$filecount = 1;

	echo EASY_LABEL_FILE_COUNT_1B . $filecount . EASY_LABEL_FILE_COUNT_2;
	$tmpfname = DIR_FS_DOCUMENT_ROOT . $tempdir . "EPB_Split" . $filecount . ".txt";
	$fp = fopen( $tmpfname, "w+");
	fwrite($fp, $toprow);

	$linecount = 0;
	$line = fgets($infp,32768);
	while ($line){
		// walking the entire file one row at a time
		// but a line is not necessarily a complete row, we need to split on rows that have "EOREOR" at the end
		$line = str_replace('"EOREOR"', 'EOREOR', $line);
		fwrite($fp, $line);
		if (strpos($line, 'EOREOR')){
			// we found the end of a line of data, store it
			$linecount++; // increment our line counter
			if ($linecount >= $maxrecs){
				echo EASY_LABEL_LINE_COUNT_1 . $linecount . EASY_LABEL_LINE_COUNT_2 . '<Br>';
				$linecount = 0; // reset our line counter
				// close the existing file and open another;
				fclose($fp);
				// increment filecount
				$filecount++;
				echo "Creating file EPB_Split" . $filecount . ".txt ...  ";
				$tmpfname = DIR_FS_DOCUMENT_ROOT . $tempdir . "EPB_Split" . $filecount . ".txt";
				//Open next file name
				$fp = fopen( $tmpfname, "w+");
				fwrite($fp, $toprow);
			}
		}
		$line=fgets($infp,32768);
	}
	echo EASY_LABEL_FILE_CLOSE_1 . $linecount . EASY_LABEL_FILE_CLOSE_2 . '<br><br> ';
	fclose($fp);
	fclose($infp);

	echo EASY_SPLIT_DOWN;

}

?>
      </p>

      <table width="75%" border="1">
        <tr>
          <td width="75%">
           <FORM ENCTYPE="multipart/form-data" ACTION="easypopulate_basic.php?split=0" METHOD=POST>

                <div align = "left">
                <br><b><?PHP ECHO EASY_UPLOAD_EP_FILE;?></b><br>

                  <INPUT TYPE="hidden" name="MAX_FILE_SIZE" value="100000000">

                  <input name="usrfl" type="file" size="50">
                  <input type="submit" name="buttoninsert" value="Insert into db"><br>

              </div>

              </form>
          </td>
          </tr>
          <tr>
          <td>
           <FORM ENCTYPE="multipart/form-data" ACTION="easypopulate_basic.php?split=1" METHOD=POST>

                <div align = "left">
                <br><b><?php echo EASY_SPLIT_EP_FILE;?></b><br>
                 <INPUT TYPE="hidden" name="MAX_FILE_SIZE" value="1000000000">

                  <input name="usrfl" type="file" size="50">
                  <input type="submit" name="buttonsplit" value="Split file">

              </div>

             </form>

          </td>
          </tr>
          <tr>
          <td>

           <FORM ENCTYPE="multipart/form-data" ACTION="easypopulate_basic.php" METHOD=POST>
              <p>
                <div align = "left">
    		<?php echo tep_draw_form('localfile_insert', 'easypopulate.php', '', 'post', 'ENCTYPE="multipart/form-data"'); ?>
		              <p>
		                <div align = "left">
		                <b><?php echo sprintf(TEXT_IMPORT_TEMP, $tempdir); ?></b><br>

		<?php
		    $dir = dir(DIR_FS_CATALOG . $tempdir);
		    $contents = array(array('id' => '', 'text' => TEXT_SELECT_ONE));
		    while ($file = $dir->read()) {
		      if ( ($file != '.') && ($file != 'CVS') && ($file != '..') ) {
		        //$file_size = filesize(DIR_FS_CATALOG . $tempdir . $file);

		        $contents[] = array('id' => $file, 'text' => $file);
		      }
		    }
		    echo tep_draw_pull_down_menu('localfile', $contents, $localfile);
		?>
		                    <input type="submit" name="buttoninsert" value="<?php echo TEXT_INSERT_INTO_DB ; ?>"><br>


              </div>
             </form>
             </td>
			           </tr>
			           <tr>

                      <td>
		      <p><b><?php echo EASY_LABEL_CREATE;?></b></p>

		  <FORM ENCTYPE="multipart/form-data" ACTION="easypopulate_basic.php?action=export" METHOD=POST>


		  <select name="download">
		  <option selected value ="stream" size="10"><?php echo EASY_LABEL_DOWNLOAD . '<b> ';?>
		  <option value="tempfile" size="10"><?php echo EASY_LABEL_CREATE_SAVE;?>
		  </select><b><?php echo EASY_LABEL_CREATE_SELECT;?></b><br>


		  <select name="dltype">
		  <option selected value ="full" size="10"><?php echo EASY_LABEL_COMPLETE //full;?>
		  <option value="priceqty" size="10"><?php echo EASY_LABEL_MPQ //model price qty;?>
		  <option value="category" size="10"><?php echo EASY_LABEL_EP_MC //model category;?>
		  <option value="froogle" size="10"><?php echo EASY_LABEL_EP_FROGGLE //froggle;?>
		  <option value="attrib" size="10"><?php echo EASY_LABEL_EP_ATTRIB //attibutes;?>
		  </select><b><?php echo EASY_LABEL_SELECT_DOWN;?></b><br>
          <br><input type="submit" name="buttoninsert" value="<?php echo EASY_LABEL_PRODUCT_START;?>">

		                  </form>

	  </td>
	</tr>
      </table>
    </td>
 </tr>
</table>

<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>

<p>??</p>
<p>??</p><p><br>
</p></body>
</html>

<?php
function tep_get_category_treea($parent_id , $spacing = '', $exclude = '', $category_id_array = '', $include_itself = true) {
    global $languages_id;

    if (!is_array($category_id_array)) $category_tree_array = array();
    if ( (sizeof($category_id_array) < 1) && ($exclude != '0') ) $category_id_array[] = array('id' => '0', 'text' => TEXT_TOP);

    if ($include_itself) {
      $category_query = tep_db_query("select cd.categories_name from " . TABLE_CATEGORIES_DESCRIPTION . " cd where cd.language_id = '" . (int)$languages_id . "' and cd.categories_id = '" . (int)$parent_id . "'");
      $category = tep_db_fetch_array($category_query);
      $category_tree_arraya[] = array('id' => $parent_id, 'text' => $category['categories_name']);
    }

    $categories_query = tep_db_query("select c.categories_id, cd.categories_name, c.parent_id from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd where c.categories_id = cd.categories_id and cd.language_id = '" . (int)$languages_id . "' and c.parent_id = '" . (int)$parent_id . "' order by c.sort_order, cd.categories_name");
    while ($categories = tep_db_fetch_array($categories_query)) {
      if ($exclude != $categories['categories_id']) $category_id_array[] = array('id' => $categories['categories_id']);
      $category_tree_array = tep_get_category_treea($categories['categories_id'],  $exclude, $category_id_array);
    }

    return $category_id_array;
  }

function ep_get_languages() {
	$languages_query = tep_db_query("select languages_id, code from " . TABLE_LANGUAGES . " order by sort_order");
	// start array at one, the rest of the code expects it that way
	$ll =1;
	while ($ep_languages = tep_db_fetch_array($languages_query)) {
		//will be used to return language_id en language code to report in product_name_code instead of product_name_id
		$ep_languages_array[$ll++] = array(
					'id' => $ep_languages['languages_id'],
					'code' => $ep_languages['code']
					);
	}
	return $ep_languages_array;
};

function tep_get_tax_class_rate($tax_class_id) {
	$tax_multiplier = 0;
	$tax_query = tep_db_query("select SUM(tax_rate) as tax_rate from " . TABLE_TAX_RATES . " WHERE  tax_class_id = '" . $tax_class_id . "' GROUP BY tax_priority");
	if (tep_db_num_rows($tax_query)) {
		while ($tax = tep_db_fetch_array($tax_query)) {
			$tax_multiplier += $tax['tax_rate'];
		}
	}
	return $tax_multiplier;
};

function tep_get_tax_title_class_id($tax_class_title) {
	$classes_query = tep_db_query("select tax_class_id from " . TABLE_TAX_CLASS . " WHERE tax_class_title = '" . $tax_class_title . "'" );
	$tax_class_array = tep_db_fetch_array($classes_query);
	$tax_class_id = $tax_class_array['tax_class_id'];
	return $tax_class_id ;
}

function print_el( $item2 ) {
	echo " | " . substr(strip_tags($item2), 0, 10);
};

function print_el1( $item2 ) {
	echo sprintf("| %'.4s ", substr(strip_tags($item2), 0, 80));
};
function ep_create_filelayout($dltype){
	global $filelayout, $filelayout_count, $filelayout_sql, $langcode, $fileheaders, $max_categories, $rangebegin, $rangeend, $catsort, $catfilter, $BEGIN1, $BEEND1, $limit_man, $limit_cat, $categories_range;
	// depending on the type of the download the user wanted, create a file layout for it.
	$fieldmap = array(); // default to no mapping to change internal field names to external.
	switch( $dltype ){
	case 'full':
		// The file layout is dynamically made depending on the number of languages
		$iii = 0;
		$filelayout = array(
			'v_products_model'		=> $iii++,
			'v_products_image'		=> $iii++,
			'v_products_image_med'		=> $iii++,
			'v_products_image_lrg'		=> $iii++,
			'v_products_image_sm_1'		=> $iii++,
			'v_products_image_xl_1'		=> $iii++,
			'v_products_image_sm_2'		=> $iii++,
			'v_products_image_xl_2'		=> $iii++,
			'v_products_image_sm_3'		=> $iii++,
			'v_products_image_xl_3'		=> $iii++,
			'v_products_image_sm_4'		=> $iii++,
			'v_products_image_xl_4'		=> $iii++,
			'v_products_image_sm_5'		=> $iii++,
			'v_products_image_xl_5'		=> $iii++,
			'v_products_image_sm_6'		=> $iii++,
			'v_products_image_xl_6'		=> $iii++
			);

		foreach ($langcode as $key => $lang){
			$l_id = $lang['id'];
			// uncomment the head_title, head_desc, and head_keywords to use
			// Linda's Header Tag Controller 2.0
			//echo $langcode['id'] . $langcode['code'];
			$filelayout  = array_merge($filelayout , array(
					'v_products_name_' . $l_id		=> $iii++,
					//'v_products_description_' . $l_id	=> $iii++,
					'v_products_description_' . $l_id	=> (str_replace('"', '\"', $iii++)),
					'v_products_url_' . $l_id	=> $iii++,
					'v_products_head_title_tag_'.$l_id	=> $iii++,
					'v_products_head_desc_tag_'.$l_id	=> $iii++,
					'v_products_head_keywords_tag_'.$l_id	=> $iii++,
					));
		}


		// uncomment the customer_price and customer_group to support multi-price per product contrib

    // VJ product attribs begin
     $header_array = array(
			'v_products_price'		=> $iii++,
			'v_products_weight'		=> $iii++,
			'v_date_avail'			=> $iii++,
			'v_date_added'			=> $iii++,
			'v_products_quantity'		=> $iii++,
			);

			$languages = tep_get_languages();

      global $attribute_options_array;

      $attribute_options_count = 1;
      foreach ($attribute_options_array as $attribute_options_values) {
				$key1 = 'v_attribute_options_id_' . $attribute_options_count;
				$header_array[$key1] = $iii++;

        for ($i=0, $n=sizeof($languages); $i<$n; $i++) {
          $l_id = $languages[$i]['id'];

					$key2 = 'v_attribute_options_name_' . $attribute_options_count . '_' . $l_id;
					$header_array[$key2] = $iii++;
				}

				$attribute_values_query = "select products_options_values_id  from " . TABLE_PRODUCTS_OPTIONS_VALUES_TO_PRODUCTS_OPTIONS . " where products_options_id = '" . (int)$attribute_options_values['products_options_id'] . "' order by products_options_values_id";

				$attribute_values_values = tep_db_query($attribute_values_query);

				$attribute_values_count = 1;
				while ($attribute_values = tep_db_fetch_array($attribute_values_values)) {
					$key3 = 'v_attribute_values_id_' . $attribute_options_count . '_' . $attribute_values_count;
					$header_array[$key3] = $iii++;

					$key4 = 'v_attribute_values_price_' . $attribute_options_count . '_' . $attribute_values_count;
					$header_array[$key4] = $iii++;

					for ($i=0, $n=sizeof($languages); $i<$n; $i++) {
						$l_id = $languages[$i]['id'];

						$key5 = 'v_attribute_values_name_' . $attribute_options_count . '_' . $attribute_values_count . '_' . $l_id;
						$header_array[$key5] = $iii++;
					}

					$attribute_values_count++;
				}

				$attribute_options_count++;
     }

    $header_array['v_manufacturers_name'] = $iii++;

    $filelayout = array_merge($filelayout, $header_array);
    // VJ product attribs end

		// build the categories name section of the array based on the number of categores the user wants to have
		for($i=1;$i<$max_categories+1;$i++){
			$filelayout = array_merge($filelayout, array('v_categories_name_' . $i => $iii++));
		}

		$filelayout = array_merge($filelayout, array(
			'v_tax_class_title'		=> $iii++,
			'v_status'			=> $iii++,
			));

		$filelayout_sql = "SELECT
			p.products_id as v_products_id,
			p.products_model as v_products_model,
			p.products_image as v_products_image,
			p.products_image_med as v_products_image_med,
			p.products_image_lrg as v_products_image_lrg,
			p.products_image_sm_1 as v_products_image_sm_1,
			p.products_image_xl_1 as v_products_image_xl_1,
			p.products_image_sm_2 as v_products_image_sm_2,
			p.products_image_xl_2 as v_products_image_xl_2,
			p.products_image_sm_3 as v_products_image_sm_3,
			p.products_image_xl_3 as v_products_image_xl_3,
			p.products_image_sm_4 as v_products_image_sm_4,
			p.products_image_xl_4 as v_products_image_xl_4,
			p.products_image_sm_5 as v_products_image_sm_5,
			p.products_image_xl_5 as v_products_image_xl_5,
			p.products_image_sm_6 as v_products_image_sm_6,
			p.products_image_xl_6 as v_products_image_xl_6,
			p.products_price as v_products_price,
			p.products_weight as v_products_weight,
			p.products_date_available as v_date_avail,
			p.products_date_added as v_date_added,
			p.products_tax_class_id as v_tax_class_id,
			p.products_quantity as v_products_quantity,
			p.manufacturers_id as v_manufacturers_id,
			subc.categories_id as v_categories_id,
			p.products_status as v_status
			FROM
			".TABLE_PRODUCTS." as p,
			".TABLE_CATEGORIES." as subc,
			".TABLE_PRODUCTS_TO_CATEGORIES." as ptoc
			WHERE
			p.products_id = ptoc.products_id AND
			ptoc.categories_id = subc.categories_id
			";

		break;

	case 'priceqty':
		$iii = 0;
		// uncomment the customer_price and customer_group to support multi-price per product contrib
		$filelayout = array(
			'v_products_model'		=> $iii++,
			'v_products_price'		=> $iii++,
			'v_products_quantity'		=> $iii++,
			#'v_customer_price_1'		=> $iii++,
			#'v_customer_group_id_1'		=> $iii++,
			#'v_customer_price_2'		=> $iii++,
			#'v_customer_group_id_2'		=> $iii++,
			#'v_customer_price_3'		=> $iii++,
			#'v_customer_group_id_3'		=> $iii++,
			#'v_customer_price_4'		=> $iii++,
			#'v_customer_group_id_4'		=> $iii++,
				);
		$filelayout_sql = "SELECT
			p.products_id as v_products_id,
			p.products_model as v_products_model,
			p.products_price as v_products_price,
			p.products_quantity as v_products_quantity
			FROM
			".TABLE_PRODUCTS." as p
			";

		break;

	case 'category':
		// The file layout is dynamically made depending on the number of languages
		$iii = 0;
		$filelayout = array(
			'v_products_model'		=> $iii++,
		);

		// build the categories name section of the array based on the number of categores the user wants to have
		for($i=1;$i<$max_categories+1;$i++){
			$filelayout = array_merge($filelayout, array('v_categories_name_' . $i => $iii++));
		}


		$filelayout_sql = "SELECT
			p.products_id as v_products_id,
			p.products_model as v_products_model,
			subc.categories_id as v_categories_id
			FROM
			".TABLE_PRODUCTS." as p,
			".TABLE_CATEGORIES." as subc,
			".TABLE_PRODUCTS_TO_CATEGORIES." as ptoc
			WHERE
			p.products_id = ptoc.products_id AND
			ptoc.categories_id = subc.categories_id
			";
		break;

	case 'froogle':
		// this is going to be a little interesting because we need
		// a way to map from internal names to external names
		//
		// Before it didn't matter, but with froogle needing particular headers,
		// The file layout is dynamically made depending on the number of languages
		$iii = 0;
		$filelayout = array(
			'v_froogle_products_url_1'			=> $iii++,
			);
		//
		// here we need to get the default language and put
		$l_id = 1; // dummy it in for now.
//		foreach ($langcode as $key => $lang){
//			$l_id = $lang['id'];
			$filelayout  = array_merge($filelayout , array(
					'v_froogle_products_name_' . $l_id		=> $iii++,
					'v_froogle_products_description_' . $l_id	=> $iii++,
					));
//		}
		$filelayout  = array_merge($filelayout , array(
			'v_products_price'		=> $iii++,
			'v_products_fullpath_image'	=> $iii++,
			'v_category_fullpath'		=> $iii++,
			'v_froogle_offer_id'		=> $iii++,
			'v_froogle_instock'		=> $iii++,
			'v_froogle_ shipping'		=> $iii++,
			'v_manufacturers_name'		=> $iii++,
			'v_froogle_ upc'		=> $iii++,
			'v_froogle_color'		=> $iii++,
			'v_froogle_size'		=> $iii++,
			'v_froogle_quantitylevel'	=> $iii++,
			'v_froogle_product_id'		=> $iii++,
			'v_froogle_manufacturer_id'	=> $iii++,
			'v_froogle_exp_date'		=> $iii++,
			'v_froogle_product_type'	=> $iii++,
			'v_froogle_delete'		=> $iii++,
			'v_froogle_currency'		=> $iii++,
				));
		$iii=0;
		$fileheaders = array(
			'product_url'		=> $iii++,
			'name'			=> $iii++,
			'description'		=> $iii++,
			'price'			=> $iii++,
			'image_url'		=> $iii++,
			'category'		=> $iii++,
			'offer_id'		=> $iii++,
			'instock'		=> $iii++,
			'shipping'		=> $iii++,
			'brand'			=> $iii++,
			'upc'			=> $iii++,
			'color'			=> $iii++,
			'size'			=> $iii++,
			'quantity'		=> $iii++,
			'product_id'		=> $iii++,
			'manufacturer_id'	=> $iii++,
			'exp_date'		=> $iii++,
			'product_type'		=> $iii++,
			'delete'		=> $iii++,
			'currency'		=> $iii++,
			);
		$filelayout_sql = "SELECT
			p.products_id as v_products_id,
			p.products_model as v_products_model,
			p.products_image as v_products_image,
			p.products_price as v_products_price,
			p.products_weight as v_products_weight,
			p.products_date_added as v_date_avail,
			p.products_tax_class_id as v_tax_class_id,
			p.products_quantity as v_products_quantity,
			p.manufacturers_id as v_manufacturers_id,
			subc.categories_id as v_categories_id
			FROM
			".TABLE_PRODUCTS." as p,
			".TABLE_CATEGORIES." as subc,
			".TABLE_PRODUCTS_TO_CATEGORIES." as ptoc
			WHERE
			p.products_id = ptoc.products_id AND
			ptoc.categories_id = subc.categories_id AND
			p.products_quantity > 0
			";
		break;

// VJ product attributes begin
	case 'attrib':
		$iii = 0;
		$filelayout = array(
			'v_products_model'		=> $iii++
			);

    $header_array = array();

		$languages = tep_get_languages();

    global $attribute_options_array;

    $attribute_options_count = 1;
    foreach ($attribute_options_array as $attribute_options_values) {
			$key1 = 'v_attribute_options_id_' . $attribute_options_count;
			$header_array[$key1] = $iii++;

			for ($i=0, $n=sizeof($languages); $i<$n; $i++) {
				$l_id = $languages[$i]['id'];

				$key2 = 'v_attribute_options_name_' . $attribute_options_count . '_' . $l_id;
				$header_array[$key2] = $iii++;
			}

			$attribute_values_query = "select products_options_values_id  from " . TABLE_PRODUCTS_OPTIONS_VALUES_TO_PRODUCTS_OPTIONS . " where products_options_id = '" . (int)$attribute_options_values['products_options_id'] . "' order by products_options_values_id";

			$attribute_values_values = tep_db_query($attribute_values_query);

			$attribute_values_count = 1;
			while ($attribute_values = tep_db_fetch_array($attribute_values_values)) {
				$key3 = 'v_attribute_values_id_' . $attribute_options_count . '_' . $attribute_values_count;
				$header_array[$key3] = $iii++;

				$key4 = 'v_attribute_values_price_' . $attribute_options_count . '_' . $attribute_values_count;
				$header_array[$key4] = $iii++;

				for ($i=0, $n=sizeof($languages); $i<$n; $i++) {
					$l_id = $languages[$i]['id'];

					$key5 = 'v_attribute_values_name_' . $attribute_options_count . '_' . $attribute_values_count . '_' . $l_id;
					$header_array[$key5] = $iii++;
				}

				$attribute_values_count++;
			}

			$attribute_options_count++;
    }

    $filelayout = array_merge($filelayout, $header_array);

		$filelayout_sql = "SELECT
			p.products_id as v_products_id,
			p.products_model as v_products_model
			FROM
			".TABLE_PRODUCTS." as p
			";

		break;
// VJ product attributes end
	}
	$filelayout_count = count($filelayout);

}


function walk( $item1 ) {
	global $filelayout, $filelayout_count, $modelsize;
	global $active, $inactive, $langcode, $default_these, $deleteit, $zero_qty_inactive;
        global $epdlanguage_id, $price_with_tax, $replace_quotes, $v_products_id1;
	global $default_images, $default_image_manufacturer, $default_image_product, $default_image_category;
	global $separator, $max_categories ;
	// first we clean up the row of data

	// chop blanks from each end
	$item1 = ltrim(rtrim($item1));

	// blow it into an array, splitting on the tabs
	$items = explode($separator, $item1);

	// make sure all non-set things are set to '';
	// and strip the quotes from the start and end of the stings.
	// escape any special chars for the database.
	foreach( $filelayout as $key=> $value){
		$i = $filelayout[$key];
		if (isset($items[$i]) == false) {
			$items[$i]='';
		} else {
			// Check to see if either of the magic_quotes are turned on or off;
			// And apply filtering accordingly.
			if (function_exists('ini_get')) {
				//echo "Getting ready to check magic quotes<br>";
				if (ini_get('magic_quotes_runtime') == 1){
					// The magic_quotes_runtime are on, so lets account for them
					// check if the last character is a quote;
					// if it is, chop off the quotes.
					if (substr($items[$i],-1) == '"'){
						$items[$i] = substr($items[$i],2,strlen($items[$i])-4);
					}
					// now any remaining doubled double quotes should be converted to one doublequote
					$items[$i] = str_replace('\"\"',"\"",$items[$i]);
					//if ($replace_quotes){
					//	$items[$i] = str_replace('\"',"\"",$items[$i]);
					//	$items[$i] = str_replace("\'","\"",$items[$i]);
					//}
				} else { // no magic_quotes are on
					// check if the last character is a quote;
					// if it is, chop off the 1st and last character of the string.
					if (substr($items[$i],-1) == '"'){
						$items[$i] = substr($items[$i],1,strlen($items[$i])-2);
					}
					// now any remaining doubled double quotes should be converted to one doublequote
					$items[$i] = str_replace('""',"\"",$items[$i]);
					if ($replace_quotes){
						$items[$i] = str_replace('"',"\"",$items[$i]);
						$items[$i] = str_replace("'","\'",$items[$i]);
					}
				}
			}
		}
	}
/*
	if ( $items['v_status'] == $deleteit ){
		// they want to delete this product.
		echo "Deleting product " . $items['v_products_model'] . " from the database<br>";
		// Get the ID

		// kill in the products_to_categories

		// Kill in the products table

		return; // we're done deleteing!
	}
*/
	// now do a query to get the record's current contents
	$sql = "SELECT
		p.products_id as v_products_id,
		p.products_model as v_products_model,
		p.products_image as v_products_image,
		p.products_price as v_products_price,
		p.products_weight as v_products_weight,
		p.products_date_added as v_date_avail,
		p.products_tax_class_id as v_tax_class_id,
		p.products_quantity as v_products_quantity,
		p.manufacturers_id as v_manufacturers_id,
		subc.categories_id as v_categories_id
		FROM
		".TABLE_PRODUCTS." as p,
		".TABLE_CATEGORIES." as subc,
		".TABLE_PRODUCTS_TO_CATEGORIES." as ptoc
		WHERE
		p.products_id = ptoc.products_id AND
		p.products_model = '" . $items[$filelayout['v_products_model']] . "' AND
		ptoc.categories_id = subc.categories_id
		";

	$result = tep_db_query($sql);
	$row =  tep_db_fetch_array($result);


	while ($row){
		// OK, since we got a row, the item already exists.
		// Let's get all the data we need and fill in all the fields that need to be defaulted to the current values
		// for each language, get the description and set the vals
		foreach ($langcode as $key => $lang){
			//echo "Inside defaulting loop";
			//echo "key is $key<br>";
			//echo "langid is " . $lang['id'] . "<br>";
//			$sql2 = "SELECT products_name, products_description
//				FROM ".TABLE_PRODUCTS_DESCRIPTION."
//				WHERE
//					products_id = " . $row['v_products_id'] . " AND
//					language_id = '" . $lang['id'] . "'
//				";
			$sql2 = "SELECT *
				FROM ".TABLE_PRODUCTS_DESCRIPTION."
				WHERE
					products_id = " . $row['v_products_id'] . " AND
					language_id = '" . $lang['id'] . "'
				";
			$result2 = tep_db_query($sql2);
			$row2 =  tep_db_fetch_array($result2);
                        // Need to report from ......_name_1 not ..._name_0
			$row['v_products_name_' . $lang['id']] 		= $row2['products_name'];
			$row['v_products_description_' . $lang['id']] 	= $row2['products_description'];
			$row['v_products_url_' . $lang['id']] 		= $row2['products_url'];

			// support for Linda's Header Controller 2.0 here
			if(isset($filelayout['v_products_head_title_tag_' . $lang['id'] ])){
				$row['v_products_head_title_tag_' . $lang['id']] 	= $row2['products_head_title_tag'];
				$row['v_products_head_desc_tag_' . $lang['id']] 	= $row2['products_head_desc_tag'];
				$row['v_products_head_keywords_tag_' . $lang['id']] 	= $row2['products_head_keywords_tag'];
			}
			// end support for Header Controller 2.0
		}

		// start with v_categories_id
		// Get the category description
		// set the appropriate variable name
		// if parent_id is not null, then follow it up.
		$thecategory_id = $row['v_categories_id'];

		for( $categorylevel=1; $categorylevel<$max_categories+1; $categorylevel++){
			if ($thecategory_id){
				$sql2 = "SELECT categories_name
					FROM ".TABLE_CATEGORIES_DESCRIPTION."
					WHERE
						categories_id = " . $thecategory_id . " AND
						language_id = " . $epdlanguage_id ;

				$result2 = tep_db_query($sql2);
				$row2 =  tep_db_fetch_array($result2);
				// only set it if we found something
				$temprow['v_categories_name_' . $categorylevel] = $row2['categories_name'];
				// now get the parent ID if there was one
				$sql3 = "SELECT parent_id
					FROM ".TABLE_CATEGORIES."
					WHERE
						categories_id = " . $thecategory_id;
				$result3 = tep_db_query($sql3);
				$row3 =  tep_db_fetch_array($result3);
				$theparent_id = $row3['parent_id'];
				if ($theparent_id != ''){
					// there was a parent ID, lets set thecategoryid to get the next level
					$thecategory_id = $theparent_id;
				} else {
					// we have found the top level category for this item,
					$thecategory_id = false;
				}
			} else {
					$temprow['v_categories_name_' . $categorylevel] = '';
			}
		}
		// temprow has the old style low to high level categories.
		$newlevel = 1;
		// let's turn them into high to low level categories
		for( $categorylevel=$max_categories+1; $categorylevel>0; $categorylevel--){
			if ($temprow['v_categories_name_' . $categorylevel] != ''){
				$row['v_categories_name_' . $newlevel++] = $temprow['v_categories_name_' . $categorylevel];
			}
		}

		if ($row['v_manufacturers_id'] != ''){
			$sql2 = "SELECT manufacturers_name
				FROM ".TABLE_MANUFACTURERS."
				WHERE
				manufacturers_id = " . $row['v_manufacturers_id']
				;
			$result2 = tep_db_query($sql2);
			$row2 =  tep_db_fetch_array($result2);
			$row['v_manufacturers_name'] = $row2['manufacturers_name'];
		}

		//elari -
		//We check the value of tax class and title instead of the id
		//Then we add the tax to price if $price_with_tax is set to true
		$row_tax_multiplier = tep_get_tax_class_rate($row['v_tax_class_id']);
		$row['v_tax_class_title'] = tep_get_tax_class_title($row['v_tax_class_id']);
		if ($price_with_tax){
			$row['v_products_price'] = $row['v_products_price'] + round($row['v_products_price']* $row_tax_multiplier / 100,2);
		}

		// now create the internal variables that will be used
		// the $$thisvar is on purpose: it creates a variable named what ever was in $thisvar and sets the value
		foreach ($default_these as $thisvar){
			$$thisvar	= $row[$thisvar];
		}

		$row =  tep_db_fetch_array($result);
	}

	// this is an important loop.  What it does is go thru all the fields in the incoming file and set the internal vars.
	// Internal vars not set here are either set in the loop above for existing records, or not set at all (null values)
	// the array values are handled separatly, although they will set variables in this loop, we won't use them.
	foreach( $filelayout as $key => $value ){
		$$key = $items[ $value ];
	}

        // so how to handle these?  we shouldn't built the array unless it's been giving to us.
	// The assumption is that if you give us names and descriptions, then you give us name and description for all applicable languages
	foreach ($langcode as $lang){
		//echo "Langid is " . $lang['id'] . "<br>";
		$l_id = $lang['id'];
		if (isset($filelayout['v_products_name_' . $l_id ])){
			//we set dynamically the language values
			$v_products_name[$l_id] 	= $items[$filelayout['v_products_name_' . $l_id]];
			$v_products_description[$l_id] 	= $items[$filelayout['v_products_description_' . $l_id ]];
			$v_products_url[$l_id] 		= $items[$filelayout['v_products_url_' . $l_id ]];
			// support for Linda's Header Controller 2.0 here
			if(isset($filelayout['v_products_head_title_tag_' . $l_id])){
				$v_products_head_title_tag[$l_id] 	= $items[$filelayout['v_products_head_title_tag_' . $l_id]];
				$v_products_head_desc_tag[$l_id] 	= $items[$filelayout['v_products_head_desc_tag_' . $l_id]];
				$v_products_head_keywords_tag[$l_id] 	= $items[$filelayout['v_products_head_keywords_tag_' . $l_id]];
			}
			// end support for Header Controller 2.0
		}
	}
	//elari... we get the tax_clas_id from the tax_title
	//on screen will still be displayed the tax_class_title instead of the id....
	if ( isset( $v_tax_class_title) ){
		$v_tax_class_id          = tep_get_tax_title_class_id($v_tax_class_title);
	}
	//we check the tax rate of this tax_class_id
        $row_tax_multiplier = tep_get_tax_class_rate($v_tax_class_id);

	//And we recalculate price without the included tax...
	//Since it seems display is made before, the displayed price will still include tax
	//This is same problem for the tax_clas_id that display tax_class_title
	if ($price_with_tax){
		$v_products_price        = round( $v_products_price / (1 + ( $row_tax_multiplier * $price_with_tax/100) ), 2);
	}

	// if they give us one category, they give us all 6 categories
	unset ($v_categories_name); // default to not set.
	if ( isset( $filelayout['v_categories_name_1'] ) ){
		$newlevel = 1;
		for( $categorylevel=6; $categorylevel>0; $categorylevel--){
			if ( $items[$filelayout['v_categories_name_' . $categorylevel]] != ''){
				$v_categories_name[$newlevel++] = $items[$filelayout['v_categories_name_' . $categorylevel]];
			}
		}
		while( $newlevel < $max_categories+1){
			$v_categories_name[$newlevel++] = ''; // default the remaining items to nothing
		}
	}

	if (ltrim(rtrim($v_products_quantity)) == '') {
		$v_products_quantity = 1;
	}
	if ($v_date_avail == '') {
		$v_date_avail = "CURRENT_TIMESTAMP";
	} else {
		// we put the quotes around it here because we can't put them into the query, because sometimes
		//   we will use the "current_timestamp", which can't have quotes around it.
		$v_date_avail = '"' . $v_date_avail . '"';
	}

	if ($v_date_added == '') {
		$v_date_added = "CURRENT_TIMESTAMP";
	} else {
		// we put the quotes around it here because we can't put them into the query, because sometimes
		//   we will use the "current_timestamp", which can't have quotes around it.
		$v_date_added = '"' . $v_date_added . '"';
	}


	// default the stock if they spec'd it or if it's blank
	$v_db_status = '1'; // default to active
	if ($v_status == $inactive){
		// they told us to deactivate this item
		$v_db_status = '0';
	}
	if ($zero_qty_inactive && $v_products_quantity == 0) {
		// if they said that zero qty products should be deactivated, let's deactivate if the qty is zero
		$v_db_status = '0';
	}

	if ($v_manufacturer_id==''){
		$v_manufacturer_id="NULL";
	}

	if (trim($v_products_image)==''){
		$v_products_image = $default_image_product;
	}

	if (strlen($v_products_model) > $modelsize ){
		echo "<font color='red'>" . strlen($v_products_model) . $v_products_model . "... ERROR! - Too many characters in the model number.<br>
			12 is the maximum on a standard OSC install.<br>
			Your maximum product_model length is set to $modelsize<br>
			You can either shorten your model numbers or increase the size of the field in the database.</font>";
		die();
	}

	// OK, we need to convert the manufacturer's name into id's for the database
	if ( isset($v_manufacturers_name) && $v_manufacturers_name != '' ){
		$sql = "SELECT man.manufacturers_id
			FROM ".TABLE_MANUFACTURERS_INFO." as man
			WHERE
				man.manufacturers_name = '" . $v_manufacturers_name . "' and languages_id = '" . $epdlanguage_id . "' ";
		$result = tep_db_query($sql);
		$row =  tep_db_fetch_array($result);
		if ( $row != '' ){
			foreach( $row as $item ){
				$v_manufacturer_id = $item;
			}
		} else {
			// to add, we need to put stuff in categories and categories_description
			$sql = "SELECT MAX( manufacturers_id) max FROM ".TABLE_MANUFACTURERS;
			$result = tep_db_query($sql);
			$row =  tep_db_fetch_array($result);
			$max_mfg_id = $row['max']+1;
			// default the id if there are no manufacturers yet
			if (!is_numeric($max_mfg_id) ){
				$max_mfg_id=1;
			}

			// Uncomment this query if you have an older 2.2 codebase
			/*
			$sql = "INSERT INTO ".TABLE_MANUFACTURERS."(
				manufacturers_id,
				manufacturers_name,
				manufacturers_image
				) VALUES (
				$max_mfg_id,
				'$v_manufacturers_name',
				'$default_image_manufacturer'
				)";
			*/

			// Comment this query out if you have an older 2.2 codebase
				$sql1 = "INSERT INTO ".TABLE_MANUFACTURERS."(
				manufacturers_id,
				manufacturers_image,
				date_added,
				last_modified
				) VALUES (
				$max_mfg_id,
				'$default_image_manufacturer',
				CURRENT_TIMESTAMP,
				CURRENT_TIMESTAMP
				)";
			$result = tep_db_query($sql1);
			
				$sql = "INSERT INTO ".TABLE_MANUFACTURERS_INFO."(
				manufacturers_id,
				languages_id,
				manufacturers_name,
				manufacturers_description,
				manufacturers_meta_title,
				manufacturers_meta_keywords,
				manufacturers_meta_description,
				manufacturers_url,
				url_clicked,
				date_last_click
				) VALUES (
				$max_mfg_id,
				$epdlanguage_id,
				'$v_manufacturers_name',
				'',
				'',
				'',
				'',
				'',
				'',
				'NULL'
				)";

			$result = tep_db_query($sql);
			$v_manufacturer_id = $max_mfg_id;
		}
	}
	// if the categories names are set then try to update them
	if ( isset($v_categories_name_1)){
		// start from the highest possible category and work our way down from the parent
		$v_categories_id = 0;
		$theparent_id = 0;
		for ( $categorylevel=$max_categories+1; $categorylevel>0; $categorylevel-- ){
			$thiscategoryname = $v_categories_name[$categorylevel];
			if ( $thiscategoryname != ''){
				// we found a category name in this field

				// now the subcategory
				$sql = "SELECT cat.categories_id
					FROM ".TABLE_CATEGORIES." as cat,
					     ".TABLE_CATEGORIES_DESCRIPTION." as des
					WHERE
						cat.categories_id = des.categories_id AND
						des.language_id = $epdlanguage_id AND
						cat.parent_id = " . $theparent_id . " AND
						des.categories_name = '" . $thiscategoryname . "'";
				$result = tep_db_query($sql);
				$row =  tep_db_fetch_array($result);
				if ( $row != '' ){
					foreach( $row as $item ){
						$thiscategoryid = $item;
					}
				} else {
					// to add, we need to put stuff in categories and categories_description
					$sql = "SELECT MAX( categories_id) max FROM ".TABLE_CATEGORIES;
					$result = tep_db_query($sql);
					$row =  tep_db_fetch_array($result);
					$max_category_id = $row['max']+1;
					if (!is_numeric($max_category_id) ){
						$max_category_id=1;
					}
					$sql = "INSERT INTO ".TABLE_CATEGORIES."(
						categories_id,
						categories_image,
						parent_id,
						sort_order,
						date_added,
						last_modified
						) VALUES (
						$max_category_id,
						'$default_image_category',
						$theparent_id,
						0,
						CURRENT_TIMESTAMP
						,CURRENT_TIMESTAMP
						)";
					$result = tep_db_query($sql);
					$sql = "INSERT INTO ".TABLE_CATEGORIES_DESCRIPTION."(
							categories_id,
							language_id,
							categories_name
						) VALUES (
							$max_category_id,
							'$epdlanguage_id',
							'$thiscategoryname'
						)";
					$result = tep_db_query($sql);
					$thiscategoryid = $max_category_id;
				}
				// the current catid is the next level's parent
				$theparent_id = $thiscategoryid;
				$v_categories_id = $thiscategoryid; // keep setting this, we need the lowest level category ID later
			}
		}
	}

	if ($v_products_model != "") {
		//   products_model exists!
		array_walk($items, 'print_el');

		// First we check to see if this is a product in the current db.
		$result = tep_db_query("SELECT products_id FROM ".TABLE_PRODUCTS." WHERE (products_model = '". $v_products_model . "')");

		if (tep_db_num_rows($result) == 0)  {
			//   insert into products

			$sql = "SHOW TABLE STATUS LIKE '".TABLE_PRODUCTS."'";
			$result = tep_db_query($sql);
			$row =  tep_db_fetch_array($result);
			$max_product_id = $row['Auto_increment'];
			if (!is_numeric($max_product_id) ){
				$max_product_id=1;
			}
			$v_products_id = $max_product_id;
		//	$v_products_id1 = $max_product_id;
			echo "<font color='green'>" .  EASY_LABEL_NEW_PRODUCT ;

			$query = "INSERT INTO ".TABLE_PRODUCTS." (
					products_image,
					products_image_med,
					products_image_lrg,
					products_image_sm_1,
					products_image_xl_1,
					products_image_sm_2,
					products_image_xl_2,
					products_image_sm_3,
					products_image_xl_3,
					products_image_sm_4,
					products_image_xl_4,
					products_image_sm_5,
					products_image_xl_5,
					products_image_sm_6,
					products_image_xl_6,
					products_model,
					products_price,
					products_status,
					products_last_modified,
					products_date_added,
					products_date_available,
					products_tax_class_id,
					products_weight,
					products_quantity,
					manufacturers_id)
						VALUES (
							'$v_products_image',
							'$v_products_image_med',
							'$v_products_image_lrg',
							'$v_products_image_sm_1',
							'$v_products_image_xl_1',
							'$v_products_image_sm_2',
							'$v_products_image_xl_2',
							'$v_products_image_sm_3',
							'$v_products_image_xl_3',
							'$v_products_image_sm_4',
							'$v_products_image_xl_4',
							'$v_products_image_sm_5',
							'$v_products_image_xl_5',
							'$v_products_image_sm_6',
							'$v_products_image_xl_6',
							'$v_products_model',
								'$v_products_price',
								'$v_db_status',
								CURRENT_TIMESTAMP,
								$v_date_added,
								$v_date_avail,
								'$v_tax_class_id',
								'$v_products_weight',
								'$v_products_quantity',
								'$v_manufacturer_id')
							";
				$result = tep_db_query($query);
		} else {
			// existing product, get the id from the query
			// and update the product data
			$row =  tep_db_fetch_array($result);
			$v_products_id = $row['products_id'];
			echo EASY_LABEL_UPDATED;
			$row =  tep_db_fetch_array($result);
			$query = 'UPDATE '.TABLE_PRODUCTS.'
					SET
					products_price="'.$v_products_price.
					'" ,products_image="'.$v_products_image;

			// uncomment these lines if you are running the image mods

				$query .=
					'" ,products_image_med="'.$v_products_image_med.
					'" ,products_image_lrg="'.$v_products_image_lrg.
					'" ,products_image_sm_1="'.$v_products_image_sm_1.
					'" ,products_image_xl_1="'.$v_products_image_xl_1.
					'" ,products_image_sm_2="'.$v_products_image_sm_2.
					'" ,products_image_xl_2="'.$v_products_image_xl_2.
					'" ,products_image_sm_3="'.$v_products_image_sm_3.
					'" ,products_image_xl_3="'.$v_products_image_xl_3.
					'" ,products_image_sm_4="'.$v_products_image_sm_4.
					'" ,products_image_xl_4="'.$v_products_image_xl_4.
					'" ,products_image_sm_5="'.$v_products_image_sm_5.
					'" ,products_image_xl_5="'.$v_products_image_xl_5.
					'" ,products_image_sm_6="'.$v_products_image_sm_6.
					'" ,products_image_xl_6="'.$v_products_image_xl_6;

			$query .= '", products_weight="'.$v_products_weight .
					'", products_tax_class_id="'.$v_tax_class_id .
					'", products_date_available= ' . $v_date_avail .
					', products_date_added= ' . $v_date_added .
					', products_last_modified=CURRENT_TIMESTAMP
					, products_quantity="' . $v_products_quantity .
					'" ,manufacturers_id=' . $v_manufacturer_id .
					' , products_status=' . $v_db_status . '
					WHERE
						(products_id = "'. $v_products_id . '")';

			$result = tep_db_query($query);
		}

		// the following is common in both the updating an existing product and creating a new product
                if ( isset($v_products_name)){
			foreach( $v_products_name as $key => $name){
							if ($name!=''){
					$sql = "SELECT * FROM ".TABLE_PRODUCTS_DESCRIPTION." WHERE
							products_id = $v_products_id AND
							language_id = " . $key;
					$result = tep_db_query($sql);
					if (tep_db_num_rows($result) == 0) {
						// nope, this is a new product description
						$result = tep_db_query($sql);
						$sql =
							"INSERT INTO ".TABLE_PRODUCTS_DESCRIPTION."
								(products_id,
								language_id,
								products_name,
								products_description,
								products_url)
								VALUES (
									'" . $v_products_id . "',
									" . $key . ",
									'" . $name . "',
									'". $v_products_description[$key] . "',
									'". $v_products_url[$key] . "'
									)";
						// support for Linda's Header Controller 2.0
						if (isset($v_products_head_title_tag)){
							// override the sql if we're using Linda's contrib
							$sql =
								"INSERT INTO ".TABLE_PRODUCTS_DESCRIPTION."
									(products_id,
									language_id,
									products_name,
									products_description,
									products_url,
									products_head_title_tag,
									products_head_desc_tag,
									products_head_keywords_tag)
									VALUES (
										'" . $v_products_id . "',
										" . $key . ",
										'" . $name . "',
										'". $v_products_description[$key] . "',
										'". $v_products_url[$key] . "',
										'". $v_products_head_title_tag[$key] . "',
										'". $v_products_head_desc_tag[$key] . "',
										'". $v_products_head_keywords_tag[$key] . "')";
						}
						// end support for Linda's Header Controller 2.0
						$result = tep_db_query($sql);
					} else {
						// already in the description, let's just update it
						$sql =
							"UPDATE ".TABLE_PRODUCTS_DESCRIPTION." SET
								products_name='$name',
								products_description='".$v_products_description[$key] . "',
								products_url='" . $v_products_url[$key] . "'
							WHERE
								products_id = '$v_products_id' AND
								language_id = '$key'";
						// support for Lindas Header Controller 2.0
						if (isset($v_products_head_title_tag)){
							// override the sql if we're using Linda's contrib
							$sql =
								"UPDATE ".TABLE_PRODUCTS_DESCRIPTION." SET
									products_name = '$name',
									products_description = '".$v_products_description[$key] . "',
									products_url = '" . $v_products_url[$key] ."',
									products_head_title_tag = '" . $v_products_head_title_tag[$key] ."',
									products_head_desc_tag = '" . $v_products_head_desc_tag[$key] ."',
									products_head_keywords_tag = '" . $v_products_head_keywords_tag[$key] ."'
								WHERE
									products_id = '$v_products_id' AND
									language_id = '$key'";
						}
						// end support for Linda's Header Controller 2.0
						$result = tep_db_query($sql);
					}
				}
			}
		}
		if (isset($v_categories_id)){
			//find out if this product is listed in the category given
			$result_incategory = tep_db_query('SELECT
						'.TABLE_PRODUCTS_TO_CATEGORIES.'.products_id,
						'.TABLE_PRODUCTS_TO_CATEGORIES.'.categories_id
						FROM
							'.TABLE_PRODUCTS_TO_CATEGORIES.'
						WHERE
						'.TABLE_PRODUCTS_TO_CATEGORIES.'.products_id='.$v_products_id.' AND
						'.TABLE_PRODUCTS_TO_CATEGORIES.'.categories_id='.$v_categories_id);

			if (tep_db_num_rows($result_incategory) == 0) {
				// nope, this is a new category for this product
				$res1 = tep_db_query('INSERT INTO '.TABLE_PRODUCTS_TO_CATEGORIES.' (products_id, categories_id)
							VALUES ("' . $v_products_id . '", "' . $v_categories_id . '")');
			} else {
				// already in this category, nothing to do!
			}
		}
		// for the separate prices per customer module
		$ll=1;

		if (isset($v_customer_price_1)){

			if (($v_customer_group_id_1 == '') AND ($v_customer_price_1 != ''))  {
				echo EASY_ERROR_4;
				die();
			}
			// they spec'd some prices, so clear all existing entries
			$result = tep_db_query('
						DELETE
						FROM
							'.TABLE_PRODUCTS_GROUPS.'
						WHERE
							products_id = ' . $v_products_id
						);
			// and insert the new record
			if ($v_customer_price_1 != ''){
				$result = tep_db_query('
							INSERT INTO
								'.TABLE_PRODUCTS_GROUPS.'
							VALUES
							(
								' . $v_customer_group_id_1 . ',
								' . $v_customer_price_1 . ',
								' . $v_products_id . ',
								' . $v_products_price .'
								)'
							);
			}
			if ($v_customer_price_2 != ''){
				$result = tep_db_query('
							INSERT INTO
								'.TABLE_PRODUCTS_GROUPS.'
							VALUES
							(
								' . $v_customer_group_id_2 . ',
								' . $v_customer_price_2 . ',
								' . $v_products_id . ',
								' . $v_products_price . '
								)'
							);
			}
			if ($v_customer_price_3 != ''){
				$result = tep_db_query('
							INSERT INTO
								'.TABLE_PRODUCTS_GROUPS.'
							VALUES
							(
								' . $v_customer_group_id_3 . ',
								' . $v_customer_price_3 . ',
								' . $v_products_id . ',
								' . $v_products_price . '
								)'
							);
			}
			if ($v_customer_price_4 != ''){
				$result = tep_db_query('
							INSERT INTO
								'.TABLE_PRODUCTS_GROUPS.'
							VALUES
							(
								' . $v_customer_group_id_4 . ',
								' . $v_customer_price_4 . ',
								' . $v_products_id . ',
								' . $v_products_price . '
								)'
							);
			}

		}

		// VJ product attribs begin insert
		if (isset($v_attribute_options_id_1)){
			$attribute_rows = 1; // master row count

			$languages = tep_get_languages();

			// product options count
			$attribute_options_count = 1;
			$v_attribute_options_id_var = 'v_attribute_options_id_' . $attribute_options_count;

			while (isset($$v_attribute_options_id_var) && !empty($$v_attribute_options_id_var)) {
				// remove product attribute options linked to this product before proceeding further
				// this is useful for removing attributes linked to a product
				$attributes_clean_query = "delete from " . TABLE_PRODUCTS_ATTRIBUTES . " where products_id = '" . (int)$v_products_id . "' and options_id = '" . (int)$$v_attribute_options_id_var . "'";

				tep_db_query($attributes_clean_query);

				$attribute_options_query = "select products_options_name from " . TABLE_PRODUCTS_OPTIONS . " where products_options_id = '" . (int)$$v_attribute_options_id_var . "'";

				$attribute_options_values = tep_db_query($attribute_options_query);

				// option table update begin
				if ($attribute_rows == 1) {
					// insert into options table if no option exists
					if (tep_db_num_rows($attribute_options_values) <= 0) {
						for ($i=0, $n=sizeof($languages); $i<$n; $i++) {
							$lid = $languages[$i]['id'];

						  $v_attribute_options_name_var = 'v_attribute_options_name_' . $attribute_options_count . '_' . $lid;

							if (isset($$v_attribute_options_name_var)) {
								$attribute_options_insert_query = "insert into " . TABLE_PRODUCTS_OPTIONS . " (products_options_id, language_id, products_options_name) values ('" . (int)$$v_attribute_options_id_var . "', '" . (int)$lid . "', '" . $$v_attribute_options_name_var . "')";

								$attribute_options_insert = tep_db_query($attribute_options_insert_query);
							}
						}
					} else { // update options table, if options already exists
						for ($i=0, $n=sizeof($languages); $i<$n; $i++) {
							$lid = $languages[$i]['id'];

							$v_attribute_options_name_var = 'v_attribute_options_name_' . $attribute_options_count . '_' . $lid;

							if (isset($$v_attribute_options_name_var)) {
								$attribute_options_update_lang_query = "select products_options_name from " . TABLE_PRODUCTS_OPTIONS . " where products_options_id = '" . (int)$$v_attribute_options_id_var . "' and language_id ='" . (int)$lid . "'";

								$attribute_options_update_lang_values = tep_db_query($attribute_options_update_lang_query);

								// if option name doesn't exist for particular language, insert value
								if (tep_db_num_rows($attribute_options_update_lang_values) <= 0) {
									$attribute_options_lang_insert_query = "insert into " . TABLE_PRODUCTS_OPTIONS . " (products_options_id, language_id, products_options_name) values ('" . (int)$$v_attribute_options_id_var . "', '" . (int)$lid . "', '" . $$v_attribute_options_name_var . "')";

									$attribute_options_lang_insert = tep_db_query($attribute_options_lang_insert_query);
								} else { // if option name exists for particular language, update table
									$attribute_options_update_query = "update " . TABLE_PRODUCTS_OPTIONS . " set products_options_name = '" . $$v_attribute_options_name_var . "' where products_options_id ='" . (int)$$v_attribute_options_id_var . "' and language_id = '" . (int)$lid . "'";

									$attribute_options_update = tep_db_query($attribute_options_update_query);
								}
							}
						}
					}
				}
				// option table update end

				// product option values count
				$attribute_values_count = 1;
				$v_attribute_values_id_var = 'v_attribute_values_id_' . $attribute_options_count . '_' . $attribute_values_count;

				while (isset($$v_attribute_values_id_var) && !empty($$v_attribute_values_id_var)) {
					$attribute_values_query = "select products_options_values_name from " . TABLE_PRODUCTS_OPTIONS_VALUES . " where products_options_values_id = '" . (int)$$v_attribute_values_id_var . "'";

					$attribute_values_values = tep_db_query($attribute_values_query);

					// options_values table update begin
					if ($attribute_rows == 1) {
						// insert into options_values table if no option exists
						if (tep_db_num_rows($attribute_values_values) <= 0) {
							for ($i=0, $n=sizeof($languages); $i<$n; $i++) {
								$lid = $languages[$i]['id'];

								$v_attribute_values_name_var = 'v_attribute_values_name_' . $attribute_options_count . '_' . $attribute_values_count . '_' . $lid;

								if (isset($$v_attribute_values_name_var)) {
									$attribute_values_insert_query = "insert into " . TABLE_PRODUCTS_OPTIONS_VALUES . " (products_options_values_id, language_id, products_options_values_name) values ('" . (int)$$v_attribute_values_id_var . "', '" . (int)$lid . "', '" . $$v_attribute_values_name_var . "')";

									$attribute_values_insert = tep_db_query($attribute_values_insert_query);
								}
							}


							// insert values to pov2po table
							$attribute_values_pov2po_query = "insert into " . TABLE_PRODUCTS_OPTIONS_VALUES_TO_PRODUCTS_OPTIONS . " (products_options_id, products_options_values_id) values ('" . (int)$$v_attribute_options_id_var . "', '" . (int)$$v_attribute_values_id_var . "')";

							$attribute_values_pov2po = tep_db_query($attribute_values_pov2po_query);
						} else { // update options table, if options already exists
							for ($i=0, $n=sizeof($languages); $i<$n; $i++) {
								$lid = $languages[$i]['id'];

								$v_attribute_values_name_var = 'v_attribute_values_name_' . $attribute_options_count . '_' . $attribute_values_count . '_' . $lid;

								if (isset($$v_attribute_values_name_var)) {
									$attribute_values_update_lang_query = "select products_options_values_name from " . TABLE_PRODUCTS_OPTIONS_VALUES . " where products_options_values_id = '" . (int)$$v_attribute_values_id_var . "' and language_id ='" . (int)$lid . "'";

									$attribute_values_update_lang_values = tep_db_query($attribute_values_update_lang_query);

									// if options_values name doesn't exist for particular language, insert value
									if (tep_db_num_rows($attribute_values_update_lang_values) <= 0) {
										$attribute_values_lang_insert_query = "insert into " . TABLE_PRODUCTS_OPTIONS_VALUES . " (products_options_values_id, language_id, products_options_values_name) values ('" . (int)$$v_attribute_values_id_var . "', '" . (int)$lid . "', '" . $$v_attribute_values_name_var . "')";

										$attribute_values_lang_insert = tep_db_query($attribute_values_lang_insert_query);
									} else { // if options_values name exists for particular language, update table
										$attribute_values_update_query = "update " . TABLE_PRODUCTS_OPTIONS_VALUES . " set products_options_values_name = '" . $$v_attribute_values_name_var . "' where products_options_values_id ='" . (int)$$v_attribute_values_id_var . "' and language_id = '" . (int)$lid . "'";

										$attribute_values_update = tep_db_query($attribute_values_update_query);
									}
								}
							}
						}
					}
					// options_values table update end

					// options_values price update begin
				  $v_attribute_values_price_var = 'v_attribute_values_price_' . $attribute_options_count . '_' . $attribute_values_count;

					if (isset($$v_attribute_values_price_var) && ($$v_attribute_values_price_var != '')) {
						$attribute_prices_query = "select options_values_price, price_prefix from " . TABLE_PRODUCTS_ATTRIBUTES . " where products_id = '" . (int)$v_products_id . "' and options_id ='" . (int)$$v_attribute_options_id_var . "' and options_values_id = '" . (int)$$v_attribute_values_id_var . "'";

						$attribute_prices_values = tep_db_query($attribute_prices_query);

						$attribute_values_price_prefix = ($$v_attribute_values_price_var < 0) ? '-' : '+';

						// options_values_prices table update begin
						// insert into options_values_prices table if no price exists
						if (tep_db_num_rows($attribute_prices_values) <= 0) {
							$attribute_prices_insert_query = "insert into " . TABLE_PRODUCTS_ATTRIBUTES . " (products_id, options_id, options_values_id, options_values_price, price_prefix) values ('" . (int)$v_products_id . "', '" . (int)$$v_attribute_options_id_var . "', '" . (int)$$v_attribute_values_id_var . "', '" . (int)$$v_attribute_values_price_var . "', '" . $attribute_values_price_prefix . "')";

							$attribute_prices_insert = tep_db_query($attribute_prices_insert_query);
						} else { // update options table, if options already exists
							$attribute_prices_update_query = "update " . TABLE_PRODUCTS_ATTRIBUTES . " set options_values_price = '" . $$v_attribute_values_price_var . "', price_prefix = '" . $attribute_values_price_prefix . "' where products_id = '" . (int)$v_products_id . "' and options_id = '" . (int)$$v_attribute_options_id_var . "' and options_values_id ='" . (int)$$v_attribute_values_id_var . "'";

							$attribute_prices_update = tep_db_query($attribute_prices_update_query);
						}
					}
					// options_values price update end

					$attribute_values_count++;
					$v_attribute_values_id_var = 'v_attribute_values_id_' . $attribute_options_count . '_' . $attribute_values_count;
				}

				$attribute_options_count++;
				$v_attribute_options_id_var = 'v_attribute_options_id_' . $attribute_options_count;
			}

			$attribute_rows++;
		}
		// VJ product attribs end

	} else {
		// this record was missing the product_model
		array_walk($items, 'print_el');
		echo EASY_ERROR_3 ;
	}
// end of row insertion code
}


require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>
