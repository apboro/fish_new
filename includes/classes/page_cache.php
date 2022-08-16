<?php
/*=======================================================================*\
|| #################### //-- SCRIPT INFO --// ########################## ||
|| #	Script name: page_cache.php
|| #	Contribution: Page Cache
|| #	Version: 1.6
|| #	Date: 20 February 2005
|| # ------------------------------------------------------------------ # ||
|| #################### //-- COPYRIGHT INFO --// ######################## ||
|| #	Copyright (C) 2005 Bobby Easland								# ||
|| #	Internet moniker: Chemo											# ||	
|| #	Contact: chemo@mesoimpact.com									# ||
|| #	Commercial Site: http://gigabyte-hosting.com/					# ||
|| #	GPL Dev Server: http://mesoimpact.com/							# ||
|| #																	# ||
|| #	This script is free software; you can redistribute it and/or	# ||
|| #	modify it under the terms of the GNU General Public License		# ||
|| #	as published by the Free Software Foundation; either version 2	# ||
|| #	of the License, or (at your option) any later version.			# ||
|| #																	# ||
|| #	This script is distributed in the hope that it will be useful,	# ||
|| #	but WITHOUT ANY WARRANTY; without even the implied warranty of	# ||
|| #	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the	# ||
|| #	GNU General Public License for more details.					# ||
|| #																	# ||
|| #	Script is intended to be used with:								# ||
|| #	osCommerce, Open Source E-Commerce Solutions					# ||
|| #	http://www.oscommerce.com										# ||
|| #	Copyright (c) 2003 osCommerce									# ||
|| ###################################################################### ||
\*========================================================================*/

class page_cache {
	# Define class variables
	var $cache_dir, $cache_filename, $cache_param, $cache_file, $customer_cart, $cache_compress, $cache_language, $cache_currency, $customer_sid;
	var $cart_counter;
	var $debug_output = array();
	var $cache_lifetime = 5;
	var $is_guest = false;
	var $debug_messages = false;
	var $cache_file_exists = false;
	var $cache_file_is_expired = true;
	var $write_cache_file = false;
	var $output_ob = false;

/*##################################################################################

Class constructor must have the $cart_cache passed to keep the customer shopping cart dynamic

###################################################################################*/
	function page_cache($cart_info, $cache_time = PAGE_CACHE_LIFETIME, $debug_switch = PAGE_CACHE_DEBUG_MODE) {
		global $SID,$REQUEST,$cart;
		$this->cart_counter=$cart->count_contents();
		# Start populating the debug array with the current database settings	
		$this->debug_output['admin_config_settings']['ENABLE_PAGE_CACHE'] = ENABLE_PAGE_CACHE;
		$this->debug_output['admin_config_settings']['PAGE_CACHE_LIFETIME'] = PAGE_CACHE_LIFETIME;
		$this->debug_output['admin_config_settings']['PAGE_CACHE_DEBUG_MODE'] = PAGE_CACHE_DEBUG_MODE;
		$this->debug_output['admin_config_settings']['PAGE_CACHE_DISABLE_PARAMETERS'] = PAGE_CACHE_DISABLE_PARAMETERS; 
		$this->debug_output['admin_config_settings']['PAGE_CACHE_DELETE_FILES'] = PAGE_CACHE_DELETE_FILES;
		$this->debug_output['admin_config_settings']['PAGE_CACHE_UPDATE_CONFIG_FILES'] = PAGE_CACHE_UPDATE_CONFIG_FILES;
		
		# Set the cache directory and store the setting in the debug array
		$this->cache_dir = DIR_FS_CATALOG . 'cache/';
		$this->debug_output['cache_dir'] = $this->cache_dir;

		# If the delete cache file switch is true then let's go through this code
		if (PAGE_CACHE_DELETE_FILES == 'true') {
			# Check to see if there is a configuration cache contribution installed and the file exists 
			$this->debug_output['PAGE_CACHE_UPDATE_CONFIG_FILE_EXISTS'] = (file_exists(PAGE_CACHE_UPDATE_CONFIG_FILES) ? 'true' : 'false');
			# Call the delete_cache_files() method
			$this->delete_cache_files();
			# Add the "deleted cache files" message to the debug array
			$this->debug_output['delete_cache_files'] = 'cache files deleted - top level';
			# Change the delete cache file switch to "false"
			tep_db_query("UPDATE configuration SET configuration_value = 'false' WHERE configuration_key = 'PAGE_CACHE_DELETE_FILES'");		
			# Add the switch change to the debug array
			$this->debug_output['update_configuration_setting'] = 'PAGE_CACHE_DELETE_FILES reset to false';
			# If a configuration cache file is specified include it if it exists
			if ( file_exists(PAGE_CACHE_UPDATE_CONFIG_FILES) ) {
				require(PAGE_CACHE_UPDATE_CONFIG_FILES);
				# Add the "config cache file updated" message to the debug array
				$this->debug_output['update_config_files'] = 'configuration cache files updated';
				} # END if file_exists
				else {
					$this->debug_output['update_config_files'] = 'ERROR: update file does not exist';
				}		
			} # END delete cache files
			 
		# Take the PHP_SELF global and replace all the /'s
		# This should work with ALL URL's but best for search engine safe
//		$this->cache_filename = str_replace("/", "_", $_SERVER['PHP_SELF']);
		$this->cache_filename = str_replace("/", "", $_SERVER['PHP_SELF']);
		# Add the constructed cache_filename to the debug output
		$this->debug_output['cache_filename'] = $this->cache_filename; 
		# Replace all the s in the URL parameters.  Should not be needed but just in case...
		//-----changes in cache by iHolder

   		/*
   		$this->cache_param = str_replace("/", "_", $_SERVER["QUERY_STRING"]);
		# Remove the osCsid from the cache parameters
		$this->cache_param = preg_replace("/([&]|)osCsid=.{32}/", "", $_SERVER["QUERY_STRING"]);
		*/
		$disable_cache=array('srrange','osCsid','x','y');
		$enable_cookie=array('OscMobile','submenuheader');
		if (IS_MOBILE==1){$this->cache_param='m';}
		foreach($_COOKIE as $gkey=>$gvalue){
		    if (!in_array($gkey,$enable_cookie)){
			unset($_REQUEST[$gkey]);
			}
		    }
		foreach(array_merge($_GET,$_POST,$_REQUEST) as $gkey=>$gvalue){
		    if (is_array($gvalue)){$gvalue=serialize($gvalue);}
		    if (in_array($gkey,$disable_cache) || (strlen($gvalue)==0)){continue;}
		    $this->cache_param.='_'.$gkey.'-'.$gvalue;
		    }
		$this->cache_param=str_replace("/", "_",$this->cache_param);
		//-----changes in cache by iHolder		    
//---debug cache params---
/*		echo '<pre>';
		var_dump($_GET);
		var_dump($_POST);
		var_dump($_REQUEST);
		var_dump($_COOKIE);
		echo '</pre>';
		echo $this->cache_param;exit;*/
		$this->cache_param_full=$this->cache_param;
		$this->cache_param=md5($this->cache_param);
		# Add the constructed cache_param to debug output
		$this->debug_output['cache_param'] = $this->cache_param;
		#Add the cache language and store it
		$this->cache_language = '_' . $_SESSION['language'];
		$this->debug_output['cache_language'] = $this->cache_language;
		# Set the cache file currency and store it
		$this->cache_currency = '_' . $_SESSION['currency'];
		$this->debug_output['cache_currency'] = $this->cache_currency;
		# Check whether page parameters are disabled
		# May be needed in some cases where live help is offered and the LHO session ID is appended to URL's, etc.
		if (PAGE_CACHE_DISABLE_PARAMETERS == 'false') {
			# Parameters are NOT disabled so include them in the cache_file naming 
			$this->cache_file = $this->cache_dir.$this->cache_filename.'_'.$this->cache_param.$this->cache_language.$this->cache_currency.".cache";
			} else {
				# Parameters ARE disabled so DO NOT include them in the cache_file naming
				$this->cache_file = $this->cache_dir.$this->cache_filename.$this->cache_language.$this->cache_currency.".cache";
				}
			# Add the constructed cache_file setting to the debug array
			$this->debug_output['cache_file'] = $this->cache_file;
		# Convert cache time from minutes to seconds
		$this->cache_lifetime = $cache_time * 60;
		# Add the lifetime to the debug array
		$this->debug_output['cache_lifetime'] = $this->cache_lifetime . ' seconds';
		# collect the garbage
		if ( rand(0, 100) <= 5 ) $this->collect_garbage(); // 5% chance of triggering GC
		# Add a way to output the debug array other than globally
		# To activate this switch append ?debug=1 to the end of a cached file URL
		if (PAGE_CACHE_DEBUG_MODE=='true'){
      ($_GET['debug'] ? $this->debug_messages = 'true' : $this->debug_messages = $debug_switch);
      }
		# Add the setting to the debug array
		$this->debug_output['debug_output'] = $this->debug_messages;
		# Check to see if the customer is a guest and add to the debug array
		if ( !tep_session_is_registered('customer_id') ) $this->is_guest = true;
		$this->debug_output['is_guest'] = $this->is_guest; 
		# See if the cache_file exists
		if (file_exists($this->cache_file)&&(filesize($this->cache_file)==0)){
			unlink($this->cache_file);
			}
		if ( file_exists($this->cache_file) ) {
			# File does exist and add to debug array
			$this->filesize=filesize($this->cache_file);
			$this->cache_file_exists = true;
			$this->debug_output['cache_file_exists'] = $this->cache_file_exists;
			# Check to see whether the file is expired and add to the debug array
			( (filemtime($this->cache_file) + $this->cache_lifetime) < time() )
				?	$this->cache_file_is_expired = true
				:	$this->cache_file_is_expired = false;
			$this->debug_output['cache_file_is_expired'] = $this->cache_file_is_expired;		
		} # END if file_exists
		# Define the customer_cart variable and compress the data then add the message to debug array
		# The data used here is passed to the class contructor
//		echo $cart_info;
		$this->customer_cart = $this->compress_buffer( $cart_info );
//		echo 'after';
//		echo $this->customer_cart;exit;
		$this->debug_output['customer_cart'] = ( is_string($this->customer_cart)  ? true : false );
		# Set the customers_sid and store it
		$this->customer_sid = $SID; 		
		$this->debug_output['customer_sid'] = $this->customer_sid;
} # END of page_cache constructor
	
/*##################################################################################

cache_this_page() method
	- no arguments
	- no return

###################################################################################*/
	function cache_this_page () {
		global $debug;
		# Check to see if the customer is logged in and whether the page cache is enabled		
		if ($this->is_guest && ENABLE_PAGE_CACHE =='true') {
			# Add to the debug array
			$this->debug_output['is_guest_check'] = 'customer_id not set - cache_this_page()';
			# Check to see if the file exists and it is not expired
			if ( $this->cache_file_exists && !$this->cache_file_is_expired) {
				# Good...it does exist and is not expired
				$this->debug_output['file_exists_and_is_not_expired'] = 'file exists and is not expired';
				# Now let's see if they have cookie support enabled
                global $regions,$currencies;
                if(isset($_GET['products_id'])) {
                    $product_info_query = tep_db_query("select p.products_price,p.products_quantity,p.products_quantity_order_min,p.products_quantity,p.products_tax_class_id from " . TABLE_PRODUCTS . " p WHERE p.products_id = " . (int)$_GET['products_id']);
                    $product_info = tep_db_fetch_array($product_info_query);
                    $product_buy = '';
                    $in_stock = '';
                    if( $product_info['products_quantity'] < 1){
                        $product_price = tep_image(STATIC_DOMAIN.DIR_WS_IMAGES.'nt_nw_tm.jpg');
                    }else {
                        $in_stock = '<p class="instore">В наличии</p>';
                        $product_buy = PRODUCTS_ORDER_QTY_TEXT . '<input type="text" name="cart_quantity" value="' .
                            (tep_get_product_quantity_order_min($_GET['products_id'])) . '" maxlength="3" size="3">
                        ' . ((tep_get_product_quantity_order_min($_GET['products_id'])) > 1 ? PRODUCTS_ORDER_QTY_MIN_TEXT .
                                (tep_get_product_quantity_order_min($_GET['products_id'])) : "") . ' ' .
                            (tep_get_product_quantity_order_min($_GET['products_id']) > 1 ? PRODUCTS_ORDER_QTY_UNIT_TEXT . (tep_get_product_quantity_order_units($_GET['products_id'])) : "") . '
                        <br>' . tep_draw_hidden_field('products_id', $product_info['products_id']) .
                            tep_template_image_submit('button_in_cart.gif', IMAGE_BUTTON_IN_CART);
                        if ($new_price = tep_get_products_special_price((int)$_GET['products_id'])) {
                            $product_price = '<s>' . $currencies->display_price_nodiscount($product_info['products_price'], tep_get_tax_rate($product_info['products_tax_class_id'])) . '</s> <span class="productSpecialPrice">' . $currencies->display_price_nodiscount($new_price, tep_get_tax_rate($product_info['products_tax_class_id'])) . '</span>';
                        } else {
                            $product_price = $currencies->display_price($product_info['products_price'], tep_get_tax_rate($product_info['products_tax_class_id']));
                        }
                    }
                }
				if ( !tep_not_null($this->customer_sid) ) {
					# They have cookies enabled...let's remove the osCsid from the URL's since it is being pulled from cookie
                    echo str_replace(
                        array_merge(array("<%PRODUCT_PRICE%>","<%PRODUCT_BUY%>","<%IN_STOCK%>","<%CART_COUNTER%>", "<%CART_CACHE%>", "?<osCsid>", "&<osCsid>"),
                            $regions->getParamTemplates()),
                        array_merge(array($product_price,$product_buy,$in_stock,$this->cart_counter, $this->customer_cart, $this->customer_sid, $this->customer_sid),
                            $regions->getParamValues()), file_get_contents($this->cache_file));
				} else {
					# No cookies enabled so let's append the osCsid to every URL
                    echo str_replace(
                        array_merge(array("<%PRODUCT_PRICE%>","<%PRODUCT_BUY%>","<%IN_STOCK%>","<%CART_COUNTER%>", "<%CART_CACHE%>", "<osCsid>"),
                            $regions->getParamTemplates()),
                        array_merge(array($product_price,$product_buy,$in_stock,$this->cart_counter, $this->customer_cart, $this->customer_sid),
                            $regions->getParamValues()), file_get_contents($this->cache_file));
				}

				$this->debug();
				include (DIR_WS_INCLUDES . 'counter.php');
				include_once (DIR_WS_INCLUDES . 'application_bottom.php');
				exit();
			} # END file exists and is not expired
			
			# Does the file exist or is it expired?			
			if ( !$this->cache_file_exists || $this->cache_file_is_expired ) {
				# Either it does not exist or is expired.  Let's start the cache
				# Add the info to the debug array
				$this->debug_output['no_file_or_expired'] = 'file does not exist or is expired'; 
				# Set the flag to write the cache file
				$this->write_cache_file = true;
				# We'll need to output the buffer as well
				$this->output_ob = true;
				# Start the output buffer
				ob_start();
				# Add the info to the debug array
				$this->debug_output['ob_started'] = 'ob started @ '. time();
			} # END is file does not exist or is expired			
		} # END if $this->is_guest		
	} # END cache_this_page method
	
/*##################################################################################

end_page_cache() method
	- no arguments
	- no return

###################################################################################*/
	function end_page_cache() {
		# Check to see if the customer is logged in and whether the page cache is enabled 
		if ($this->is_guest && ENABLE_PAGE_CACHE =='true') {
			# Passed the check...let's add the info to the debug array
			$this->debug_output['is_guess_check_end'] = 'customer_id not set - end_page_cache()';
			# If the output switch is true lets output the buffer
			if ( $this->output_ob ) {
				# Switch enabled...add the info to the debug array
				$this->debug_output['output_ob'] = 'output_ob = true';
				# Store the compressed buffer as a variable
				$this->cache_compress = $this->compress_buffer( ob_get_clean() );
				# Add the info to the debug array
				$this->debug_output['ob_compressed'] = 'output buffer flushed and compressed';
				# Output the compressed buffer
				$this->output_buffer($this->cache_compress);
				# Add the info to the debug array
				$this->debug_output['output'] = 'compressed ob sent to screen';
			} # END if $this->output_buffer
			
			# If the write to file swith is true let's write the file
			if ( $this->write_cache_file ) {
				# Passed check.  Write the file
				$this->write_file ( $this->cache_compress );
				# Let's add the info to the debug array
				$this->debug_output['write_file'] = 'compressed ob written to file'; 
			} # END if write cache file
			
			# Unset the buffer
			unset ($this->cache_compress);
			# Add the info to the debug array
			$this->debug_output['unset_cache_compress'] = 'cache compress unset';			
		} #END if $this->is_guest		
		$this->debug();			
	} #END end_page_cache method

/*##################################################################################

compress_buffer() method
	- arguments: $buffer (string)
	- return: compressed $buffer

###################################################################################*/
	function compress_buffer ($buffer) {
		# Add the info to the debug array
		$this->debug_output['compress_buffer'] = 'compressing buffer';
		# Return the compressed buffer
		return preg_replace('/\>\s+\</', '> <', $buffer);
	} # END compress buffer
	
/*##################################################################################

write_file() method
	- arguments: $buffer (string)
	- return: true;

###################################################################################*/
function iDebug($buffer){
		$debug='('.file_exists($this->cache_file).')'.$this->cache_file.'{'.$this->cache_param_full.'}'.'['.
		    strlen($buffer).']'."\n";
		    $fw=fopen(DIR_FS_CATALOG . 'cache/iDebug.txt','a');
		    if (is_resource($fw)){
			    fwrite($fw,$debug);
			    fclose($fw);
			    }

}
	function write_file($buffer) {
//		$this->iDebug($buffer);
//		if (file_exists($this->cache_file)&&(strlen(buffer)==0)){unset($buffer);return true;}
//		if (strlen(buffer)==0){unset($buffer);return true;}
		if (!file_exists($this->cache_file)){
		    $fp = fopen($this->cache_file,'w+');
		    fwrite($fp, $buffer);
		    fclose($fp);
		    $this->debug_output['file_write'] = 'buffer writtent to file';
		    unset($buffer);
		    $this->debug_output['unset_write_buffer'] = 'write buffer unset';
		    }
		return true;
	} # END write_cache_file method

/*##################################################################################

outpur_buffer() method
	- arguments: $buffer (string)
	- return: buffer with customer cart
	
###################################################################################*/
	function output_buffer($buffer) {
	    global $regions,$currencies;

        if(isset($_GET['products_id'])) {
            $product_info_query = tep_db_query("select p.products_price,p.products_quantity,p.products_quantity_order_min,p.products_quantity,p.products_tax_class_id from " . TABLE_PRODUCTS . " p WHERE p.products_id = " . (int)$_GET['products_id']);
            $product_info = tep_db_fetch_array($product_info_query);
            $product_buy = '';
            $in_stock = '';
            if( $product_info['products_quantity'] < 1){
                $product_price = tep_image(STATIC_DOMAIN.DIR_WS_IMAGES.'nt_nw_tm.jpg');
            }else {
                $in_stock = '<p class="instore">В наличии</p>';
                $product_buy = PRODUCTS_ORDER_QTY_TEXT . '<input type="text" name="cart_quantity" value="' .
                    (tep_get_product_quantity_order_min($_GET['products_id'])) . '" maxlength="3" size="3">
                       ' . ((tep_get_product_quantity_order_min($_GET['products_id'])) > 1 ? PRODUCTS_ORDER_QTY_MIN_TEXT .
                        (tep_get_product_quantity_order_min($_GET['products_id'])) : "") . ' ' .
                    (tep_get_product_quantity_order_min($_GET['products_id']) > 1 ? PRODUCTS_ORDER_QTY_UNIT_TEXT . (tep_get_product_quantity_order_units($_GET['products_id'])) : "") . '
                        <br>' . tep_draw_hidden_field('products_id', $product_info['products_id']) .
                    tep_template_image_submit('button_in_cart.gif', IMAGE_BUTTON_IN_CART);
                if ($new_price = tep_get_products_special_price((int)$_GET['products_id'])) {
                    $product_price = '<s>' . $currencies->display_price_nodiscount($product_info['products_price'], tep_get_tax_rate($product_info['products_tax_class_id'])) . '</s> <span class="productSpecialPrice">' . $currencies->display_price_nodiscount($new_price, tep_get_tax_rate($product_info['products_tax_class_id'])) . '</span>';
                } else {
                    $product_price = $currencies->display_price($product_info['products_price'], tep_get_tax_rate($product_info['products_tax_class_id']));
                }
            }
        }
        if ( !tep_not_null($this->customer_sid) ) {
            # They have cookies enabled...let's remove the osCsid from the URL's since it is being pulled from cookie
            echo str_replace(
                array_merge(array("<%PRODUCT_PRICE%>","<%PRODUCT_BUY%>","<%IN_STOCK%>","<%CART_COUNTER%>", "<%CART_CACHE%>", "?<osCsid>", "&<osCsid>"),
                    $regions->getParamTemplates()),
                array_merge(array($product_price,$product_buy,$in_stock,$this->cart_counter, $this->customer_cart, $this->customer_sid, $this->customer_sid),
                    $regions->getParamValues()), $buffer);
        } else {
            # No cookies enabled so let's append the osCsid to every URL
            echo str_replace(
                array_merge(array("<%PRODUCT_PRICE%>","<%PRODUCT_BUY%>","<%IN_STOCK%>","<%CART_COUNTER%>", "<%CART_CACHE%>", "<osCsid>"),
                    $regions->getParamTemplates()),
                array_merge(array($product_price,$product_buy,$in_stock,$this->cart_counter, $this->customer_cart, $this->customer_sid),
                    $regions->getParamValues()), $buffer);
        }

		$this->debug_output['output_2_screen'] = 'successfully output to screen';
		unset($buffer);
		$this->debug_output['unset_screen_buffer'] = 'screen buffer unset';			
	} # END output_buffer() method
	
/*##################################################################################

debug() method
	- arguments: none
	- return: debug array

###################################################################################*/
	function debug () {
		if ($this->debug_messages == 'true') {
			$data_store['PAGE_CACHE'] = $this->debug_output;
			$data_store['COOKIE_INFO'] = $_COOKIE;
			$data_store['SESSION_INFO'] = $_SESSION;
			echo '<pre>';
			print_r($data_store);
			echo '</pre>';
		}		
	} # END debug() method
	
/*##################################################################################

delete_cache_file() method
	- arguments: none
	- return: true;

###################################################################################*/
	function delete_cache_files () {
		foreach (glob($this->cache_dir."*.cache") as $filename) {
		   $this->debug_output['deleting_file'][]= $filename;
		   @unlink($filename);
		}
		return true;
	} # END delete_cache_files() method

/*##################################################################################

collect_garbage() method
	- arguments: none
	- return: true;

###################################################################################*/
	function collect_garbage() {
		foreach (glob($this->cache_dir."{*.cache}", GLOB_BRACE) as $filename) {
		   if ( ( filemtime($filename) + $this->cache_lifetime) < time() )
			@unlink($filename);
		}
		return true;
	} # END collect_garbage() method
	
} #END of class
?>