<?php

  $adminImages = "includes/languages/russian/images/buttons/";
  $backLink = "<a href=\"javascript:history.back()\">";

  require('new_attributes_config.php');
  require('includes/application_top.php');

$cPathID = $_POST['cPathID'];
$current_product_id = $_POST['current_product_id'];
$languageFilter = $languages_id;
$action = $_POST['action'];

  if ( $cPathID && $action == "change" )
  {
        require('new_attributes_change.php');

        tep_redirect( './' . FILENAME_CATEGORIES . '?cPath=' . $cPathID . '&pID=' . $current_product_id );

  }

?>

<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<title><?php echo TITLE; ?></title>
<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
<script language="javascript" src="includes/general.js"></script>
<script language="javascript"><!--
function popupWindow(url) {
  window.open(url,'popupWindow','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=no,resizable=yes,copyhistory=no,width=900,height=600')
}
//--></script>
<script>
var number;
var number1 = "_dlfile";
var number2 = "";
</script>
</head>
<body marginwidth="0" marginheight="0" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0" bgcolor="#FFFFFF" onload="SetFocus();">
<!-- header //-->
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
<!-- header_eof //-->

<!-- body //-->
     <table border="0" width="100%" cellspacing="2" cellpadding="2">
     <tr>
    <td width="<?php echo BOX_WIDTH; ?>" valign="top"><table border="0" width="<?php echo BOX_WIDTH; ?>" cellspacing="1" cellpadding="1" class="columnLeft">
<!-- left_navigation //-->
     <?php require(DIR_WS_INCLUDES . 'column_left.php'); ?>
<!-- left_navigation_eof //-->
    </table></td>

<!-- body_text //-->
    <td width="100%" valign="top"><table class="table-padding-2">
    
<?php

function findTitle( $current_product_id, $languageFilter )
{
  $query = "SELECT * FROM products_description where language_id = '$languageFilter' AND products_id = '$current_product_id'";

  $result = tep_db_query($query) or die(mysqli_error());

  $matches = tep_db_num_rows($result);

  if ($matches) {

  while ($line = tep_db_fetch_array($result, MYSQLI_ASSOC)) {
                                                          	
        $productName = $line['products_name'];
        
  }
  
  return $productName;
  
  } else { return TEXT_NEW_ATTRIBUTE_ERROR; }
  
}

function attribRedirect( $cPath )
{

 return '<SCRIPT LANGUAGE="JavaScript"> window.location="./configure.php?cPath=' . $cPath . '"; </script>';
 
}

switch( $action )
{
  case 'select':
  $pageTitle = TEXT_NEW_ATTRIBUTE_ADD . ' - ' . findTitle( $current_product_id, $languageFilter );
  require('new_attributes_include.php');
  break;
  
  case 'change':
  $pageTitle = TEXT_NEW_ATTRIBUTE_UPDATED;
  require('new_attributes_change.php');
  require('new_attributes_select.php');
  break;

  default:
  $pageTitle = TEXT_NEW_ATTRIBUTE_ADD;
  require('new_attributes_select.php');
  break;
  
}

?>

    </table></TD>
    </TR>
<!-- body_eof //-->

<!-- footer //-->
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<!-- footer_eof //-->
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>