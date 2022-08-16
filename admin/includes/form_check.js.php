<?php
/*
  $Id: form_check.js.php,v 1.1 2003/09/24 14:33:18 wilt Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2002 osCommerce

  Released under the GNU General Public License
*/
?>

<script language="javascript"><!--

var submitted = false;

function check_form() {

  var error = 0;
  var error_message = "<?php echo JS_ERROR; ?>";

  if(submitted){ 
    alert( "<?php echo JS_ERROR_SUBMITTED; ?>"); 
    return false; 
  }
   
  var first_name = document.account_edit.firstname.value;
  var last_name = document.account_edit.lastname.value;
<?php
   if (ACCOUNT_DOB == 'true') echo '  var dob = document.account_edit.dob.value;' . "\n";
?>
	var email_address = document.account_edit.email_address.value;  
  try {
	var street_address = document.account_edit.street_address.value;
  } catch(e) {}
  try {
	var postcode = document.account_edit.postcode.value;
  } catch(e) {}
  try {
	var city = document.account_edit.city.value;
  } catch(e) {}
  try {
	var telephone = document.account_edit.telephone.value;
  } catch(e) {}
  try {
	var password = document.account_edit.password.value;
  } catch(e) {}
  try {
	var confirmation = document.account_edit.confirmation.value;
  } catch(e) {}

<?php
   if (ACCOUNT_GENDER == 'true') {
?>
  if (document.account_edit.elements['gender'].type != "hidden") {
    if (document.account_edit.gender[0].checked || document.account_edit.gender[1].checked) {
    } else {
      error_message = error_message + "<?php echo JS_GENDER; ?>";
      error = 1;
    }
  }
<?php
  }
?>
 
  if (document.account_edit.elements['firstname'].type != "hidden") {
    if (first_name == '' || first_name.length < <?php echo ENTRY_FIRST_NAME_MIN_LENGTH; ?>) {
      error_message = error_message + "<?php echo JS_FIRST_NAME; ?>";
      error = 1;
    }
  }

  if (document.account_edit.elements['lastname'].type != "hidden") {
    if (last_name == '' || last_name.length < <?php echo ENTRY_LAST_NAME_MIN_LENGTH; ?>) {
      error_message = error_message + "<?php echo JS_LAST_NAME; ?>";
      error = 1;
    }
  }

<?php
   if (ACCOUNT_DOB == 'true') {
?>
  if (document.account_edit.elements['dob'].type != "hidden") {
    if (dob == '' || dob.length < <?php echo ENTRY_DOB_MIN_LENGTH; ?>) {
      error_message = error_message + "<?php echo JS_DOB; ?>";
      error = 1;
    }
  }
<?php
  }
?>
  if (document.account_edit.elements['email_address'].type != "hidden") {
    if (email_address == '' || email_address.length < <?php echo ENTRY_EMAIL_ADDRESS_MIN_LENGTH; ?>) {
      error_message = error_message + "<?php echo JS_EMAIL_ADDRESS; ?>";
      error = 1;
    }
  }
  try {
   if (document.account_edit.elements['street_address'].type != "hidden") {
     if (street_address == '' || street_address.length < <?php echo ENTRY_STREET_ADDRESS_MIN_LENGTH; ?>) {
       error_message = error_message + "<?php echo JS_ADDRESS; ?>";
       error = 1;
     }
   }
  } catch(e) {}

  try {
   if (document.account_edit.elements['postcode'].type != "hidden") {
     if (postcode == '' || postcode.length < <?php echo ENTRY_POSTCODE_MIN_LENGTH; ?>) {
       error_message = error_message + "<?php echo JS_POST_CODE; ?>";
       error = 1;
     }
   }
  } catch(e) {}

  try {
   if (document.account_edit.elements['city'].type != "hidden") {
     if (city == '' || city.length < <?php echo ENTRY_CITY_MIN_LENGTH; ?>) {
       error_message = error_message + "<?php echo JS_CITY; ?>";
       error = 1;
     }
   }
  } catch(e) {}

<?php
  if (ACCOUNT_STATE == 'true') {
?>
  if (document.account_edit.elements['state'].type != "hidden") {
    if (document.account_edit.state.value == '' || document.account_edit.state.value.length < <?php echo ENTRY_STATE_MIN_LENGTH; ?> ) {
       error_message = error_message + "<?php echo JS_STATE; ?>";
       error = 1;
    }
  }
<?php
  }
?>
  try {
   if (document.account_edit.elements['country'].type != "hidden") {
     if (document.account_edit.country.value == 0) {
       error_message = error_message + "<?php echo JS_COUNTRY; ?>";
       error = 1;
     }
   }
  } catch(e) {}

  try {
   if (document.account_edit.elements['telephone'].type != "hidden") {
     if (telephone == '' || telephone.length < <?php echo ENTRY_TELEPHONE_MIN_LENGTH; ?>) {
       error_message = error_message + "<?php echo JS_TELEPHONE; ?>";
       error = 1;
     }
   }
  } catch(e) {}

   try {
    if (document.account_edit.elements['password'].type != "hidden") {
     if ((password != confirmation) || (password == '' || password.length < <?php echo ENTRY_PASSWORD_MIN_LENGTH; ?>)) {
       error_message = error_message + "<?php echo JS_PASSWORD; ?>";
       error = 1;
     }
    } 
   } catch(e) {}

  if (error == 1) { 
    alert(error_message); 
    return false; 
  } else { 
    submitted = true; 
    return true; 
  }
}

<?php
   $extra_fields_query = tep_db_query("select ce.fields_id, ce.fields_input_type, ce.fields_required_status, cei.fields_name, ce.fields_status, ce.fields_input_type, ce.fields_size from " . TABLE_EXTRA_FIELDS . " ce, " . TABLE_EXTRA_FIELDS_INFO . " cei where ce.fields_status=1 and ce.fields_required_status=1 and cei.fields_id=ce.fields_id and cei.languages_id =" . $languages_id);
   while($extra_fields = tep_db_fetch_array($extra_fields_query)){
   $string_error=sprintf(ENTRY_EXTRA_FIELDS_ERROR,$extra_fields['fields_name'],$extra_fields['fields_size']);?>
    check_input("<?php echo 'fields_' . $extra_fields['fields_id']?>", <?php echo $extra_fields['fields_size'];?>, "<?php echo $string_error; ?>");
 <?php }?>

//--></script>