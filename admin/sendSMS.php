<?php 
function sendSMS($data){
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://api.pushbullet.com/v2/texts");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data)); 
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_HEADER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json; charset=cp1251", "Access-Token: o.JNYdz8BzzY9PrV40KVQGdfHeUx0IRBr3",));
$html = curl_exec($ch);
curl_close($ch); 
}
  ?>