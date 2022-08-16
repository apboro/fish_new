<?php


require('includes/application_top.php');

if (!defined('YML_NAME')) define('YML_NAME', '');
if (!defined('YML_COMPANY')) define('YML_COMPANY', '');
if (!defined('YML_AVAILABLE')) define('YML_AVAILABLE', 'stock');
if (!defined('YML_DELIVERYINCLUDED')) define('YML_DELIVERYINCLUDED', 'false');
if (!defined('YML_AUTH_USER')) define('YML_AUTH_USER', '');
if (!defined('YML_AUTH_PW')) define('YML_AUTH_PW', '');
if (!defined('YML_REFERER')) define('YML_REFERER', 'false');
if (!defined('YML_STRIP_TAGS')) define('YML_STRIP_TAGS', 'true');
if (!defined('YML_UTF8')) define('YML_UTF8', 'false');

$yml_referer = (YML_REFERER == 'false' ? "" : (YML_REFERER == 'ip' ? '&amp;ref_ip=' . $_SERVER["REMOTE_ADDR"] : '&amp;ref_ua=' . $_SERVER["HTTP_USER_AGENT"]));

if (YML_AUTH_USER != "" && YML_AUTH_PW != "") {
    if (!isset($PHP_AUTH_USER) || $PHP_AUTH_USER != YML_AUTH_USER || $PHP_AUTH_PW != YML_AUTH_PW) {
        header('WWW-Authenticate: Basic realm="Realm-Name"');
        header("HTTP/1.0 401 Unauthorized");
        die;
    }
}

$charset = (YML_UTF8 == 'true') ? 'utf-8' : CHARSET;

$manufacturers_array = array();

header('Content-Type: text/xml');

echo "<?xml version=\"1.0\" encoding=\"" . $charset . "\"?><!DOCTYPE yml_catalog SYSTEM \"shops.dtd\">\n" .
    "<yml_catalog date=\"" . date('Y-m-d H:i') . "\">\n\n" .
    "<shop>\n" .
    "<name>" . _clear_string((YML_NAME == "" ? STORE_NAME : YML_NAME)) . "</name>\n" .
    "<company>" . _clear_string((YML_COMPANY == "" ? STORE_OWNER : YML_COMPANY)) . "</company>\n" .
    "<url>" . HTTP_SERVER . "/</url>\n\n";

echo "  <currencies>\n";
if ($_GET['currency'] == "") {
    foreach ($currencies->currencies as $code => $v) {
        echo "    <currency id=\"" . $code . "\" rate=\"" . number_format(1 / $v["value"], 4) . "\"/>\n";
    }
} else {
    $varcurrency = $currencies->currencies[$_GET['currency']];
    foreach ($currencies->currencies as $code => $v) {
        echo "    <currency id=\"" . $code . "\" rate=\"" . number_format($varcurrency['value'] / $v['value'], 4) . "\"/>\n";
    }
}


echo "  </currencies>\n\n";

echo "  <categories>\n";
$categories_to_xml_query = tep_db_query('describe ' . TABLE_CATEGORIES . ' categories_to_xml');
$categories_query = tep_db_query("select c.categories_id, cd.categories_name, c.parent_id " . ((tep_db_num_rows($categories_to_xml_query) > 0) ? ", c.categories_to_xml " : "") . "
														from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd
														where c.categories_status = '1'
															and c.categories_id = cd.categories_id
															and cd.language_id='" . (int)$languages_id . "'
														order by c.parent_id, c.sort_order, cd.categories_name"
);
$categories_disable = array();
while ($categories = tep_db_fetch_array($categories_query)) {
    if (!isset($categories["categories_to_xml"]) || $categories["categories_to_xml"] == 1) {
        echo "<category id=\"" . $categories["categories_id"] . "\"" .
            (($categories["parent_id"] == "0") ? ">" : " parentId=\"" . $categories["parent_id"] . "\">") .
            _clear_string($categories["categories_name"]) .
            "</category>\n";
    } else {
        $categories_disable[] = $categories["categories_id"];
    }
}
echo "  </categories>\n";

echo "<offers>\n";
$products_short_desc_query = tep_db_query('describe ' . TABLE_PRODUCTS_DESCRIPTION . ' products_info');
$products_to_xml_query = tep_db_query('describe ' . TABLE_PRODUCTS . ' products_to_xml');
$products_sql = "select p.products_id, p.products_model, p.products_quantity,
 p.products_image_lrg,
          p.products_image_xl_1,          
          p.products_image_xl_2,          
          p.products_image_xl_3,          
          p.products_image_xl_4,          
          p.products_image_xl_5,        
          p.products_image_xl_6,
		  p.products_price, products_tax_class_id, p.manufacturers_id, pd.products_name, p2c.categories_id, pd.products_description" .
    ((tep_db_num_rows($products_short_desc_query) > 0) ? ", pd.products_info " : " ") . ", l.code as language " .
    "from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c, " . TABLE_PRODUCTS_DESCRIPTION . " pd, " . TABLE_LANGUAGES . " l
								 where p.products_id = pd.products_id
									 and p.products_status = 1" .
    ((tep_db_num_rows($products_to_xml_query) > 0) ? " and p.products_to_xml = 1" : "") .
    " and p.products_id = p2c.products_id
									 and pd.language_id = " . (int)$languages_id . "
									 and p.products_price > 0
									 and p.products_quantity > 0
									 and l.languages_id=pd.language_id
								 order by pd.products_name";
$products_query = tep_db_query($products_sql);
$prev_prod['products_id'] = 0;
$cats_id = array();

for ($iproducts = 0, $nproducts = tep_db_num_rows($products_query); $iproducts <= $nproducts; $iproducts++) {
    $products = tep_db_fetch_array($products_query);
    if ($prev_prod['products_id'] == $products['products_id']) {
        if (!in_array($products['categories_id'], $categories_disable)) {
            $cats_id[] = $products['categories_id'];
        }
    } else {
        if (sizeof($cats_id) > 0) {
            $available = "false";
            switch (YML_AVAILABLE) {
                case "stock":
                    if ($prev_prod['products_quantity'] > 0)
                        $available = "true";
                    else
                        $available = "false";
                    break;
                case "false":
                case "true":
                    $available = YML_AVAILABLE;
                    break;
            }

            if ($products_price = tep_get_products_special_price($prev_prod['products_id'])) {
            } else {
                $products_price = extra_product_price($prev_prod['products_price']);
            }
            $url = tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $prev_prod['products_id'] . '&amp;language=' . $prev_prod['language'] . (isset($_GET['ref']) ? '&amp;ref=' . $_GET['ref'] : null) . $yml_referer, 'NONSSL', false);
//			if(checkValidUrl($url,$prev_prod['products_id'],  _clear_string($prev_prod['products_name']))){
//			    continue;
//            }


            $products_options_query = tep_db_query("select
 products_attributes.products_id,
 products_attributes.options_id, 
 products_options.products_options_name,  
 products_options_values.products_options_values_name,
 products_options_values.products_options_values_id
 from products_attributes 
 join products_options on products_attributes.options_id=products_options.products_options_id
 join products_options_values
 on
 products_attributes.options_values_id=products_options_values.products_options_values_id
 where products_attributes.products_id=" . $prev_prod['products_id']);


            $q = 0;
            $d = 0;
            $i = 0;
            $cvet_arr = array();
            $razmer_arr = array();
            $products_options_arr = array();

            while ($products_options = tep_db_fetch_array($products_options_query)) {
                $products_options_arr[$i] = $products_options;
                $i++;
                if ($products_options['options_id'] == 2) {
                    $cvet_arr[$q] = $products_options;
                    $q++;
                }
                if ($products_options['options_id'] == 1) {
                    $razmer_arr[$d] = $products_options;
                    $d++;
                }
            }


            if (!empty($razmer_arr) and !empty($cvet_arr)) { // and count($cvet_arr)<2){ //последнее условие для теста
                for ($k = 0; $k < count($razmer_arr); $k++) {
                    for ($w = 0; $w < count($cvet_arr); $w++) {
                        $offer_id = $prev_prod['products_id'] . '-' . $razmer_arr[$k]['products_options_values_id'] . '-' . $cvet_arr[$w]['products_options_values_id'];


                        echo "<offer id=\"" . $offer_id . "\" available=\"" . $available . "\">\n" .
                            "  <url>" . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $prev_prod['products_id'] . '&razm=' . $razmer_arr[$k]['products_options_values_id'] . '&cvet=' . $cvet_arr[$w]['products_options_values_id'], 'NONSSL', false) . "</url>\n" .
//					 "  <url>" . "</url>\n" .
                            "  <price>" . number_format(tep_round(tep_add_tax($products_price, tep_get_tax_rate($prev_prod['products_tax_class_id'])) * $currencies->currencies[$currency]['value'], $currencies->currencies[$currency]['decimal_places']), $currencies->currencies[$currency]['decimal_places'], '.', '') . "</price>\n" .
                            "  <currencyId>" . $currency . "</currencyId>\n";
                        for ($ic = 0, $nc = sizeof($cats_id); $ic < $nc; $ic++) {
                            echo "  <categoryId>" . $cats_id[$ic] . "</categoryId>\n";
                        }

                        echo (tep_not_null($prev_prod['products_image_lrg']) ? "<picture>" . dirname(HTTP_SERVER . DIR_WS_CATALOG . DIR_WS_IMAGES . $prev_prod['products_image_lrg']) . "/" . urlencode(basename($prev_prod['products_image_lrg'])) . "</picture>\n" : "") .


                            (YML_DELIVERYINCLUDED == "true" ? "  <deliveryIncluded/>\n" : "") .
                            "  <name>" . _clear_string($prev_prod['products_name']) . ' ' . $razmer_arr[$k]['products_options_name'] . ' ' . $razmer_arr[$k]['products_options_values_name'] . ' ' . $cvet_arr[$w]['products_options_name'] . ' ' .


                            $cvet_arr[$w]['products_options_values_name'] . "</name>\n";
                        for ($pict = 1; $pict <= 6; $pict++) {
                            $dob_pict = 'products_image_xl_' . $pict;
                            if (tep_not_null($prev_prod[$dob_pict])) {
                                echo "<picture>" . dirname(HTTP_SERVER . DIR_WS_CATALOG . DIR_WS_IMAGES . $prev_prod[$dob_pict]) . "/" . urlencode(basename($prev_prod[$dob_pict])) . "</picture>";
                                //'<picture>'.$prev_prod[$dob_pict].'</picture>';
                            }
                        }

                        $razmerINT = array("XS", "S", "M", "L", "XL", "2XL", "3XL", "4XL");


                        if (in_array(($razmer_arr[$k]['products_options_values_name']), $razmerINT)) {

                            echo "<param name='" . $razmer_arr[$k]['products_options_name'] . "' unit='INT'>" . $razmer_arr[$k]['products_options_values_name'] . "</param>\n";
                        } else {
                            echo "<param name='" . $razmer_arr[$k]['products_options_name'] . "' unit='RU'>" . $razmer_arr[$k]['products_options_values_name'] . "</param>\n";
                        }

                        echo "<param name='" . $cvet_arr[$w]['products_options_name'] . "'>" . $cvet_arr[$w]['products_options_values_name'] . "</param>\n";

                        if ($prev_prod['manufacturers_id'] != 0) {
                            if (!isset($manufacturers_array[$prev_prod['manufacturers_id']])) {
// BOF manufacturers descriptions
                                /*
                                                    $manufacturer_query = tep_db_query("select manufacturers_name
                                                                                                                            from " . TABLE_MANUFACTURERS . "
                                                                                                                            where manufacturers_id ='" . $prev_prod['manufacturers_id'] . "'");
                                */
                                $manufacturer_query = tep_db_query("select manufacturers_name
																							from " . TABLE_MANUFACTURERS_INFO . "
																							where manufacturers_id ='" . $prev_prod['manufacturers_id'] . "' and languages_id = '" . (int)$languages_id . "'");
// EOF manufacturers descriptions
                                $manufacturer = tep_db_fetch_array($manufacturer_query);
                                $manufacturers_array[$prev_prod['manufacturers_id']] = $manufacturer['manufacturers_name'];
                            }
//				echo "  <vendor>" . _clear_string($manufacturers_array[$prev_prod['manufacturers_id']]) . "</vendor>\n";
                        }
                        if (isset($prev_prod['products_info']) && tep_not_null($prev_prod['products_info'])) {
                            echo "  <description><![CDATA[" . _clear_string($prev_prod['products_info']) . "]]></description>\n";
                        } elseif (tep_not_null($prev_prod['products_description'])) {
                            echo "  <description><![CDATA[" . _clear_string($prev_prod['products_description']) . "]]></description>\n";
                        }

                        echo "</offer>\n\n";
                    }
                }
            } else { //(count($cvet_arr)<2) {  //здесь условие для теста

                for ($h = 0; $h <= count($products_options_arr); $h++) {
                    $offer_id = $prev_prod['products_id'] . '-' . $products_options_arr[$h]['products_options_values_id'];
                    echo "<offer id=\"" . $offer_id . "\" available=\"" . $available . "\">\n" .
                        "  <url>" . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $prev_prod['products_id'] . '&param=' . $products_options_arr[$h]['products_options_values_id'], 'NONSSL', false) . "</url>\n" .
//					 "  <url>" . "</url>\n" .
                        "  <price>" . number_format(tep_round(tep_add_tax($products_price, tep_get_tax_rate($prev_prod['products_tax_class_id'])) * $currencies->currencies[$currency]['value'], $currencies->currencies[$currency]['decimal_places']), $currencies->currencies[$currency]['decimal_places'], '.', '') . "</price>\n" .
                        "  <currencyId>" . $currency . "</currencyId>\n";
                    for ($ic = 0, $nc = sizeof($cats_id); $ic < $nc; $ic++) {
                        echo "  <categoryId>" . $cats_id[$ic] . "</categoryId>\n";
                    }
                    echo (tep_not_null($prev_prod['products_image_lrg']) ? "<picture>" . dirname(HTTP_SERVER . DIR_WS_CATALOG . DIR_WS_IMAGES . $prev_prod['products_image_lrg']) . "/" . urlencode(basename($prev_prod['products_image_lrg'])) . "</picture>\n" : "") .
                        (YML_DELIVERYINCLUDED == "true" ? "  <deliveryIncluded/>\n" : "") .
                        "  <name>" . _clear_string($prev_prod['products_name']) . ' ' . $products_options_arr[$h]['products_options_name'] . ' ' . $products_options_arr[$h]['products_options_values_name'] . "</name>\n";

                    for ($pict = 1; $pict <= 6; $pict++) {
                        $dob_pict = 'products_image_xl_' . $pict;
                        if (tep_not_null($prev_prod[$dob_pict])) {
                            echo "<picture>" . dirname(HTTP_SERVER . DIR_WS_CATALOG . DIR_WS_IMAGES . $prev_prod[$dob_pict]) . "/" . urlencode(basename($prev_prod[$dob_pict])) . "</picture>";
                            //'<picture>'.$prev_prod[$dob_pict].'</picture>';
                        }
                    }
                    if ($prev_prod['manufacturers_id'] != 0) {
                        if (!isset($manufacturers_array[$prev_prod['manufacturers_id']])) {
// BOF manufacturers descriptions

                            $manufacturer_query = tep_db_query("select manufacturers_name
																							from " . TABLE_MANUFACTURERS_INFO . "
																							where manufacturers_id ='" . $prev_prod['manufacturers_id'] . "' and languages_id = '" . (int)$languages_id . "'");
// EOF manufacturers descriptions
                            $manufacturer = tep_db_fetch_array($manufacturer_query);
                            $manufacturers_array[$prev_prod['manufacturers_id']] = $manufacturer['manufacturers_name'];
                        }
                        echo "  <vendor>" . _clear_string($manufacturers_array[$prev_prod['manufacturers_id']]) . "</vendor>\n";
                    }
                    if (isset($prev_prod['products_info']) && tep_not_null($prev_prod['products_info'])) {
                        echo "  <description><![CDATA[" . _clear_string($prev_prod['products_info']) . "]]></description>\n";
                    } elseif (tep_not_null($prev_prod['products_description'])) {
                        echo "  <description><![CDATA[" . _clear_string($prev_prod['products_description']) . "]]></description>\n";
                    }
//PARAM
                    if ($products_options_arr[$h]['options_id'] <> 1) {
                        echo "<param name='" . $products_options_arr[$h]['products_options_name'] . "'>" . $products_options_arr[$h]['products_options_values_name'] . "</param>\n";
                    } else {
                        $razmerINT = array("XS", "S", "M", "L", "XL", "2XL", "3XL", "4XL");
                        if (in_array(($products_options_arr[$h]['products_options_values_name']), $razmerINT)) {

                            echo "<param name='" . $products_options_arr[$h]['products_options_name'] . "' unit='INT'>" . $products_options_arr[$h]['products_options_values_name'] . "</param>\n";
                        } else {
                            echo "<param name='" . $products_options_arr[$h]['products_options_name'] . "' unit='RU'>" . $products_options_arr[$h]['products_options_values_name'] . "</param>\n";
                        }
                    }

                    echo "</offer>\n\n";
                }
            }
        }


        $prev_prod = $products;
        $cats_id = array();
        if (!in_array($products['categories_id'], $categories_disable)) {
            $cats_id[] = $products['categories_id'];
        }
    }
}
echo "</offers>\n" .
    "</shop>\n" .
    "</yml_catalog>\n";

function _clear_string($str)
{
    if (YML_STRIP_TAGS == 'true') {
        $str = strip_tags($str);
    }
    if (YML_UTF8 == 'true')
        $str = iconv(CHARSET, "UTF-8", $str);
    return htmlspecialchars($str, ENT_QUOTES);
}


function checkValidUrl($url, $id, $name)
{
//        return 0;
//        file_put_contents('report.txt', "id".$id.PHP_EOL, FILE_APPEND);

    if (preg_match("/&#?[a-z0-9]+;/i", $url)) {
        file_put_contents('report.txt', "id" . $id . "name" . $name . "url->" . $url . PHP_EOL, FILE_APPEND);
        return 1;
    }
    return 0;
}

