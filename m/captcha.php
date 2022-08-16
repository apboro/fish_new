<?php
/*
autocreated script
*/
  require('includes/application_top.php');
?>
    <?php
/* -----------------------------------------------------------------------------------------
  $Id: captcha.php 831 2007-10-29 19:20:03 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2007 KCAPTCHA - author Kruglov Sergei; captcha.ru 

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/



require ('includes/configure.php'); 
require_once (DIR_WS_CLASSES.'kcaptcha.php');

if(isset($_REQUEST[session_name()])){
	session_start();
}

$captcha = new KCAPTCHA();

//if($_REQUEST[session_name()]){
	$_SESSION['captcha_keystring'] = $captcha->getKeyString();
//}

?>
<?php
  require(DIR_WS_INCLUDES . 'template_top.php');
?>
<div class="contentContainer">
    <div class="contentText">

</div>
</div>
<?php
  require(DIR_WS_INCLUDES . 'template_bottom.php');
  require(DIR_WS_INCLUDES . 'application_bottom.php');
?>
