<?php
/*
  $Id: attributeManagerHeader.inc.php,v 1.0 21/02/06 Sam West$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Released under the GNU General Public License
  
  Copyright © 2006 Kangaroo Partners
  http://kangaroopartners.com
  osc@kangaroopartners.com
*/

if ($action == 'new_product' || $action == 'update_product') {
	$amSessionVar = tep_session_name().'='.tep_session_id();

	echo '<script language="JavaScript" type="text/JavaScript">'."\n";
	echo "	var productsId='".(int)$_GET['pID']."';"."\n";
	echo "	var pageAction='".tep_db_prepare_input($_GET['action'])."';"."\n";
	echo "	var sessionId='".$amSessionVar."';"."\n";
	echo '</script>'."\n";
	echo '<script language="JavaScript" type="text/JavaScript" src="attributeManager/javascript/requester.js"></script>'."\n";
	echo '<script language="JavaScript" type="text/JavaScript" src="attributeManager/javascript/alertBoxes.js"></script>'."\n";
	echo '<script language="JavaScript" type="text/JavaScript" src="attributeManager/javascript/attributeManager.js"></script>'."\n";
	echo '<link rel="stylesheet" type="text/css" href="attributeManager/css/attributeManager.css" />'."\n";
}
?>

<script language="JavaScript" type="text/javascript">

function goOnLoad() {
	<?php	if('new_product' == $action || 'update_product' == $action) echo 'attributeManagerInit();';	?>
	SetFocus();
}

</script>
