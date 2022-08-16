<?php
header( 'Content-Type: text/html; charset=utf-8' );

ini_set('display_errors','On');
error_reporting('E_ALL');
$host = 'db';  
$user = 'root'; 
$password = 'lHhYoy'; 
$db_name = 'yourfish'; 

$link = mysqli_connect($host, $user, $password, $db_name);
//mysqli_query($link, "SET CHARACTER SET 'utf8'");
//mysqli_query($link, "set character_set_client='utf8'");
//mysqli_query($link, "set character_set_results='utf8'");
//mysqli_query($link, "set collation_connection='utf8_general_ci'");
//mysqli_query($link, "SET NAMES utf8");


//$query = mysqli_query($link, "select categories_id, categories_name from categories_description WHERE categories_name REGEXP '[a-zA-Z]' and categories_name not like '% %'" );
$query = mysqli_query($link, "select categories_id, categories_name from categories_description WHERE categories_id=245" );
while ($kol = mysqli_fetch_assoc($query)) {
   $parent_id_query=mysqli_query($link,"select parent_id from categories where categories_id=".$kol['categories_id']);
     $parent_id=mysqli_fetch_assoc($parent_id_query);
   $parent_name_query=mysqli_query($link,"select categories_name from categories_description where categories_id=".$parent_id['parent_id']);
     $parent_name=mysqli_fetch_assoc($parent_name_query);	 
	 $new_name =$parent_name['categories_name']. ' ' . $kol['categories_name'];
	// mysqli_query($link,"update categories_description set categories_name='".$new_name ."' where categories_id=".$kol['categories_id']);
	 //mysqli_query($link,"update categories_description set categories_name='дурка' where categories_id=245");
     //echo $kol['categories_id'];
	 echo $kol['categories_name'].'бабозавр';
}

//var_dump($kol);

?>
