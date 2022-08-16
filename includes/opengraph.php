<?php 
define('OG_USE',true);
if (OG_USE===true){
$og_image='';
$og_type='article';
$tk_image='';
$og_title=$the_title;
$og_desc=$the_desc;
$tk_title=$the_title;
$tk_desc=$the_desc;
if ($content=='index_default'){$og_image=$tk_image=HTTP_SERVER.'/images/rybolovniy_magazin.jpg';}
if (strlen($canonical_url)>0){$og_url=$canonical_url;}else{$og_url=HTTP_SERVER;}
if ($PHP_SELF==FILENAME_DEFAULT){
    if (isset($_GET['cPath'])&&(strlen($_GET['cPath'])>0)){

if (strlen($metaData['og_title'])>0){$og_title=$metaData['og_title'];}
if (strlen($metaData['og_description'])>0){$og_desc=$metaData['og_description'];}
if (strlen($metaData['tk_title'])>0){$tk_title=$metaData['tk_title'];}
if (strlen($metaData['tk_description'])>0){$tk_desc=$metaData['tk_description'];}
	$ogqry=tep_db_query('select categories_image as ci from categories 
	    where categories_id='.tep_db_input($metaCategory).' limit 1');
	if ($ogqry!==false){
	    $ogres=tep_db_fetch_array($ogqry);
	    if (strlen($ogres['ci'])>0){$og_tk_image=HTTP_SERVER.'/'.DIR_WS_IMAGES.$ogres['ci'];}
	}

    if (strlen($metaData['og_image'])>0){$og_image=$metaData['og_image'];}else{$og_image=$og_tk_image;}
    if (strlen($metaData['tk_image'])>0){$tk_image=$metaData['tk_image'];}else{$tk_image=$og_tk_image;}
	$og_type='object';
	}else{
	$og_type='website';
	}
    }
if ($PHP_SELF==FILENAME_PRODUCT_INFO){
	$og_type='article';
	$ogqry=tep_db_query('select products_image as pi,products_image_med as pm,products_image_lrg as pl from products where products_id='.tep_db_input($_GET['products_id']).' limit 1');
	if ($ogqry!==false){
	    $ogres=tep_db_fetch_array($ogqry);
	    $image = '';
	    if(!empty($ogres['pl'])){
            $image = $ogres['pl'];
        }elseif(!empty($ogres['pm'])){
            $image = $ogres['pm'];
        }else{
            $image = $ogres['pi'];
        }
	    if (strlen($image)>0){$og_tk_image=HTTP_SERVER.'/'.DIR_WS_IMAGES.$image;}
	    }

    if (strlen($the_product_info['og_title'])>0){$og_title=$the_product_info['og_title'];}
    if (strlen($the_product_info['og_description'])>0){$og_desc=$the_product_info['og_description'];}
    if (strlen($the_product_info['tk_title'])>0){$tk_title=$the_product_info['tk_title'];}
    if (strlen($the_product_info['tk_description'])>0){$tk_desc=$the_product_info['tk_description'];}
    if (strlen($the_product_info['og_image'])>0){$og_image=$the_product_info['og_image'];}else{$og_image=$og_tk_image;}
    if (strlen($the_product_info['tk_image'])>0){$tk_image=$the_product_info['tk_image'];}else{$tk_image=$og_tk_image;}
	}


/*---End of dife og type---*/
echo '<meta property="og:locale" content="ru_RU" />'."\n";
echo '<meta property="og:type" content="'.$og_type.'" />'."\n";
echo '<meta property="og:title" content="'.$og_title.'"  />'."\n";
echo '<meta property="og:description" content="'.$og_desc.'"  />'."\n";
echo '<meta property="og:url" content="'.$og_url.'" />'."\n";
echo '<meta property="og:site_name" content="'.STORE_NAME.'" />'."\n";
if (strlen($og_image)>0){
    echo '<meta property="og:image" content="'.$og_image.'" />'."\n";
    }

echo '<meta name="twitter:card" content="summary_large_image" />'."\n";
echo '<meta name="twitter:description" content="'.$tk_desc.'" />'."\n";
echo '<meta name="twitter:title" content="'.$tk_title.'" />'."\n";
if (strlen($tk_image)>0){
    echo '<meta name="twitter:image" content="'.$tk_image.'" />'."\n";
    }
}
;
?>