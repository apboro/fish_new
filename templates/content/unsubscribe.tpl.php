<div>
<?php if (!isset($unsubscribed)){
//-------unsubscribe message----
?>
<!--<p>Уважаемый <b><?=$customer_info['customers_firstname'];?> <?=$customer_info['customers_lastname'];?></b></p>
<p>Вы получили это письмо, потому что Ваш адрес <b><?=$customer_info['customers_email_address']?></b>  подписан на новостную рассылку </p>-->
<p>Желаете отписаться от новостной рассылки сайта "<?=STORE_NAME?>"?</p>

<form action="<?=tep_href_link($content.'.php');?>" method="GET">
<input type="hidden" name="agree" value="1">
<input type="hidden" name="uid" value="<?=tep_db_input($_GET['uid'])?>">
<input type="submit" value="Да">
</form>

<form action="<?=tep_href_link(FILENAME_DEFAULT);?>" method="GET">
<input type="submit" value="Нет">
</form>
<?php }else{ 
//-------unsubscribe complete----
?>
<p>Спасибо. Вы отписаны от новостной рассылки</p>
<?php } ?>

</div>

