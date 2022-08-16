<?php
require('includes/application_top.php');
require('includes/arrival.lib.php');
define('CURRENT_FOLDER',DIR_FS_CATALOG.'cron');
if (!file_exists(CURRENT_FOLDER)){@mkdir(CURRENT_FOLDER,0770,true);}
define('CURRENT_DATA',CURRENT_FOLDER.'/data.bin');
define('CHARSET','UTF-8');
//define('TEST_EMAIL',STORE_OWNER_EMAIL_ADDRESS);
?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?> >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<title><?php echo TITLE; ?></title>
<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
<script language="javascript" src="includes/menu.js"></script>
<script language="javascript" src="includes/general.js"></script>
<style>
.wl{padding-left:5px;display:block;float:left;width:89%;position:relative;border-right:1px dotted red;}
.wp{display:block;float:left;width:30%;position:relative;border-right:1px dotted red;padding-left:5px;}
.wpl{display:block;width:55%;float:left;padding-left:5px;}
.wr{display:block;float:right;width:10%;position:relative;text-align:center;}
.wt{display:block;float:left;position:relative;width:100%;}
div.panel{display:block;}
div.panel p {padding:0;margin:0;}
div.panel p{border-bottom:1px dotted blue;display:block;float:left;width:100%;}
span.header{font-weight:bold;color:red;text-align:center;}
div.info{
display:block;
position:relative;
float:left;
width:100%;
border:1px solid black;
max-height:400px;
overflow:auto;
    }

</style>
</head>
<body marginwidth="0" marginheight="0" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0" bgcolor="#FFFFFF" onload="SetFocus();">
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
<!-- header_eof //-->
<!-- body //-->
<table border="0" width="100%" cellspacing="2" cellpadding="2">
<tr>
<td width="<?php echo BOX_WIDTH; ?>" valign="top">
<table border="0" width="<?php echo BOX_WIDTH; ?> " cellspacing="1" cellpadding="1" class="columnLeft">
<!-- left_navigation //-->
<?php require(DIR_WS_INCLUDES . 'column_left.php'); ?>
<!-- left_navigation_eof //-->
</table>
</td>
<td width=100% valign=top>
<!-- body_text -->
<?php 
$dry=!(isset($_POST['action'])&&((int)$_POST['action']==1));
?>
<div class="panel">
<p style="text-align:center;color:green;font-weight:bold;margin-top:20px;">Извещения о поступивших товарах:</p>
<div class="info" style="height:auto;max-height:200px;"><?php $is_to_send=ProcessMailing($dry);?></div>
<?php if ($is_to_send){?>
<div style="float:right;display:block;margin:10px;">
<form method="POST" action="<?=DIR_WS_ADMIN.basename(__FILE__);?>">
<input type="hidden" name="action" value="1">
<input type="submit" value="Отправить" title="Отправить извещения">
</form>
</div>
<?php } ?>
<p style="text-align:center;color:green;font-weight:bold;margin-top:20px;">Ожидаемые товары:</p>
<div class="info"><?php DisplayWaiting();?></div>
</div>

<!-- body_text_eof //-->
</td>
</tr>
</table>
<!-- body_eof //-->
<!-- footer //-->
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<!-- footer_eof //-->
<br>
</body>
</html>

<?php
require('includes/application_bottom.php');

function DisplayWaiting(){
$query=tep_db_query('select pd.products_id as id,pd.products_name as name,count(*) as cnt
		      from products_notifications pn, products_description pd
		where pn.products_id=pd.products_id
		group by pd.products_id 
		having cnt>1 order by cnt desc');
if ($query!==false){
    echo '<p><span class="wl header">Товар</span><span class="wr header">Подписка</span></p>';
    if (tep_db_num_rows($query)==0){echo '<p>Нет данных</p>';	}
    while ($res=tep_db_fetch_array($query)){
	echo '<p><span class="wl"><a href="'.HTTP_SERVER.'/product_info.php?products_id='.$res['id'].'">'.$res['name'].'</a></span><span class="wr">'.$res['cnt'].'</span></p>';
	}
    }
}


?>


