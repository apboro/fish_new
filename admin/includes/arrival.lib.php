<?php 

function ProcessMailing($dry=true,$inform_owner=false){
$is_to_send=true;
$owner_mail='<html><body>';
if (file_exists(CURRENT_DATA)){$data=unserialize(file_get_contents(CURRENT_DATA));}
$query=tep_db_query('select products_id as id,products_quantity as qty from products');
if ($query!==false){
    while ($res=tep_db_fetch_array($query)){
	if (($res['qty']<=0)&&(!isset($data[$res['id']]))){$data[$res['id']]=1;}
	if (($res['qty']>0)&&(isset($data[$res['id']])))
	    {
	    if (!$dry){    unset($data[$res['id']]);}
	    $arrive[]=$res['id'];
	    }	
	}
    }
unset($query);

if (is_array($arrive)){
$query=tep_db_query('select pd.products_id,pd.products_name,pn.customers_id,
    c.customers_firstname,c.customers_lastname,
	c.customers_email_address
	from products_notifications pn, customers c, products_description pd
	where pn.customers_id=c.customers_id 
	and pn.products_id=pd.products_id '.
	' and pn.products_id in ('.
	    implode(',',array_values($arrive)).')');
if ($query!==false){
    while ($res=tep_db_fetch_array($query)){
	$customers[$res['customers_id']]['name']=$res['customers_firstname'];
        $customers[$res['customers_id']]['last']=$res['customers_lastname'];
	$customers[$res['customers_id']]['email']=$res['customers_email_address'];
	$customers[$res['customers_id']]['products'][$res['products_id']]=1;
	$customers[$res['customers_id']]['products'][$res['products_id']]=$res['products_name'];
	}
    }
}
$owner_mail='<html><body>';

if (is_array($data)){file_put_contents(CURRENT_DATA,serialize($data));}
if (is_array($customers)){
      foreach($customers as $id=>$customer){
	    $to_name=$customer['name']." ".$customer['last'];
	    $to_email_address=$customer['email'];
	    if (TEST_EMAIL<>'TEST_EMAIL'){$to_email_address=TEST_EMAIL;}
	    $email_subject='Поступил товар';
    	    $mail='<html><head><meta charset="CHARSET" /></head><body>'.
    	    "<p>Уважаемый, ".$customer['name']." ".$customer['last'].",<br>".
	    "На склад поступил интересующий Вас товар:<br>";
	    if (!$inform_owner){
	    echo '<p><span class="wp">'.$to_name.'<br>'.$to_email_address.'</span>';}
		else{$owner_mail.='<p><span class="wp">'.$to_name.'<br>'.$to_email_address.'</span>';}
	    foreach($customer['products'] as $product_id=>$product_name){
		$product_line='<a href="'.HTTP_SERVER.'/product_info.php?products_id='.$product_id.'" >'.$product_name.'</a>';
		$mail.=$product_line."<br>";
	    if (!$inform_owner){
		    echo '<span class="wpl">'.$product_line.'</span>';
		    }else{
		    $owner_mail.='<span class="wpl">'.$product_line.'</span>';
		    }
		}
		$mail.="    С уважением,<br>  Yourfish.ru</p></body></html>";
	    $email_text=$mail;

	    if (!$dry){
    		$send_res=do_mail($to_name, $to_email_address, $email_subject, $email_text, STORE_OWNER, STORE_OWNER_EMAIL_ADDRESS);
		if ($send_res){
		    if (!$inform_owner){
			echo '<span class="wr">Отправлено</span>';}else{
			$owner_mail.='<span class="wr">Отправлено</span>';}
		    }
		$is_to_send=false;
		}
	    if (!$inform_owner){
	        echo '</p>';}else{
	    	    $owner_mail.='</p>';
	    	    }
        }//--foreach
    }else{
	    if (!$inform_owner){
        echo '<p><span class="wt header">Сообщения о поступивших продуктах отсутствуют</span></p>';
	    }else{$owner_mail='<p><span class="wt header">Сообщения о поступивших продуктах отсутствуют</span></p>';}
    $is_to_send=false;
    }
$owner_mail.='</body></html>';
if ($inform_owner){do_mail(STORE_OWNER,STORE_OWNER_EMAIL_ADDRESS,'products arrival mail',
	    $owner_mail,STORE_OWNER, STORE_OWNER_EMAIL_ADDRESS);}
return $is_to_send;
}





function do_mail($to_name, $to_email_address, $email_subject, $email_text, $from_email_name, $from_email_address) {
    // Instantiate a new mail object
    $message = new PHPMailer();
    $message->CharSet = CHARSET;
            if (EMAIL_TRANSPORT == 'smtp'){
                        $message->IsSMTP();
                        $message->SMTPKeepAlive = true;
                        $message->SMTPAuth = EMAIL_SMTP_AUTH;
                        $message->Username = EMAIL_SMTP_USERNAME;
                        $message->Password = EMAIL_SMTP_PASSWORD;
                        $message->Host = EMAIL_SMTP_SERVER; // SMTP server
                        $message->Port = EMAIL_SMTP_PORT;
            }else{
                        $message->IsMail(); // telling the class to use SMTP
            }
           
            // Config
           
            if( strlen($from_email_address)>0 ) {
                        $from_email_address = SMTP_SENDMAIL_FROM;
            }
           
            $message->From = $from_email_address;
           
            if( strlen($from_email_name)>0 ) {
                        $from_email_name = SMTP_FROMEMAIL_NAME;
            }
           
            $message->FromName = $from_email_name;
           
            if( strlen($to_name)==0 ) {
                        $to_name = '';
            }
             
            if( strlen($to_email_address)==0 ) {
                        return false;
            }
           
            $message->AddAddress($to_email_address, $to_name);
 
            $message->Subject = $email_subject;
	    $text = strip_tags($email_text);

              $message->Body =  $email_text;
              $message->AltBody = $text;
              $message->IsHTML(true);
// Send message
    if(!$message->Send()){
               return false;
            }
    return true;
  }

?>


