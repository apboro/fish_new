<?php

class YandexMarket
{

    public static function showHeader()
    {
        echo "<?xml version=\"1.0\" encoding=\"utf-8\"?> 
		<!DOCTYPE yml_catalog SYSTEM \"shops.dtd\">
		<yml_catalog date=\"" . gmdate("Y-m-d 00:00") . "\">
			<shop>
				<name>Рыболовный магазин</name>
				<company>Рыболовный интернет магазин YourFish.ru</company>
				<url>https://yourfish.ru/</url>
				<currencies>
					<currency id=\"RUB\" rate=\"1\"/>
				</currencies>";
    }

    public static function showCategories($languages_id, $exclude_cat)
    {
        $categories_query = self::getCategoriesQuery($languages_id, $exclude_cat);
        echo "\r\n<categories>\r\n";
        while ($categories = tep_db_fetch_array($categories_query)) {
            $parent = '';
            if ($categories['parent_id'] > 0) {
                $parent = 'parentId="' . $categories['parent_id'] . '"';
            }
            echo '<category id="' . $categories['categories_id'] . '" ' . $parent . ' >' . self::prepare_string($categories['categories_name']) . '</category>' . "\r\n";
        }
        echo "\r\n</categories>\r\n";
    }

    /** Get categories request object
     * @param $languages_id
     * @return resource
     */
    private function getCategoriesQuery($languages_id, $exclude_cat)
    {
        $query = "SELECT c.categories_id, cd.categories_name, c.parent_id 
            FROM " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd
            WHERE c.categories_id = cd.categories_id AND c.categories_status = '1' " .
            " AND c.categories_id NOT IN (" . implode(',', $exclude_cat) . ") ";
        $query .= " and cd.language_id='" . $languages_id . "'
            order by sort_order, cd.categories_name";
        return tep_db_query($query);
    }

    /**Text filter
     * @param $text
     * @return mixed
     */
    private function prepare_string($text)
    {
        return str_replace(array('"', "&", ">", "<", "'"), array('&quot;', '&amp;', '&gt;', '&lt;', '&apos;'), strip_tags($text));
    }

    public static function getExcludeCatList()
    {
        //исключаем ножи
        $query_nozh = tep_db_query("SELECT categories_id FROM `categories` WHERE `parent_id` = 505");
        $exclude_cat = array(505);
        while ($cat = tep_db_fetch_array($query_nozh)) {
            $exclude_cat [] = $cat['categories_id'];
        }
        return $exclude_cat;
    }

    public static function showOffers($currencies, $exclude_cat, $limit = 0)
    {
        echo "<offers>";
        $query = "SELECT p.products_id,p.products_id,pd.products_name,p.products_quantity,p.products_price,p.products_tax_class_id,pc.categories_id,p.manufacturers_id,
          m.manufacturers_name,p.products_model,p.products_model_tag,pd.products_description, p.products_weight,
          p.products_image,
          p.products_image_med,
          p.products_image_lrg,
          p.products_image_sm_1,
          p.products_image_xl_1,
          p.products_image_sm_2,
          p.products_image_xl_2,
          p.products_image_sm_3,
          p.products_image_xl_3,
          p.products_image_sm_4,
          p.products_image_xl_4,
          p.products_image_sm_5,
          p.products_image_xl_5,
          p.products_image_sm_6,
          p.products_image_xl_6
            FROM " . TABLE_PRODUCTS . " p INNER JOIN " . TABLE_PRODUCTS_TO_CATEGORIES . " AS pc ON pc.products_id = p.products_id
            LEFT JOIN " . TABLE_PRODUCTS_DESCRIPTION . " AS pd ON pd.products_id = p.products_id
            LEFT JOIN " . TABLE_CATEGORIES . " AS c ON c.categories_id = pc.categories_id
            LEFT JOIN " . TABLE_MANUFACTURERS . " AS m ON m.manufacturers_id = p.manufacturers_id
            WHERE p.products_status = '1' " .
            "AND supplier_id NOT IN (34,23)".
            "AND c.categories_id NOT IN (" . implode(',', $exclude_cat) . ") AND c.categories_status = '1' AND p.products_price > 0  GROUP BY p.products_id " .
            ($limit > 0 ? "Limit " . $limit : "");
        $products_query = tep_db_query($query);
        $currencies->currencies['RUR']['symbol_right'] = '';
        $currencies->currencies['RUR']['thousands_point'] = '';

        /*
         * исключаем одежду без параметра размер
         * Одежда,Обувь,очки
         * */
        $query_clothes = tep_db_query("SELECT categories_id FROM `categories` WHERE `parent_id` IN (43,351,102)");
        $clothes_cat = array(43, 351, 102);
        $child_cats = array();
        while ($cat = tep_db_fetch_array($query_clothes)) {
            $child_cats[] = $cat['categories_id'];
            $clothes_cat[] = $cat['categories_id'];
        }
        $query_child_clothes = tep_db_query("SELECT categories_id FROM `categories` WHERE `parent_id` IN (" . implode(',', $child_cats) . ")");
        while ($cat = tep_db_fetch_array($query_child_clothes)) {
            $clothes_cat[] = $cat['categories_id'];
        }
        while ($product = tep_db_fetch_array($products_query)) {
            echo self::getOffer($product, $currencies, $clothes_cat);
        }
        echo "</offers>";
    }

    private function remove_countries($text){
        return str_replace(array('(Россия)', "ВСЯ РОССИЯ"), '', $text);
    }

    private function getOffer($product, $currencies, $clothes_cat)
    {
        $available = $product['products_quantity'] > 0 ? "true" : "false";
        $product_link = tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $product['products_id'], 'SSL', false);

        $prod_name = trim($product['products_name']);
        if (!empty($prod_name)) {
            $name = '<name>' . self::remove_countries(self::prepare_string($product['products_name'])) . '</name>';
        } else {
            return false;
        }
        $priceList = self::getPrices($currencies, $product['products_id'], $product['products_tax_class_id'], $product['products_price']);
        $price = $priceList['current'];
        $oldPriceTag = $priceList['old'];
        $images = self::getProductImages($product);
        if (empty($images)) {
            return false;
        }
        $weight = self::getProductWeight($product['products_weight']);


        $vendor = '';
        if (!empty($product['manufacturers_name'])) {
            if ($product['manufacturers_name'] != 'Россия') {
                $vendor = '        <vendor>' . self::prepare_string($product['manufacturers_name']) . '</vendor>' . "\r\n";
            }
        }
        $vendorCode = '';
        if (!empty($product['products_model'])) {
            $vendorCode = "        <vendorCode>" . trim(str_replace("\0", '', $product['products_model'])) . "</vendorCode>\r\n";
        }
        $description = '';
        if (!empty($product['products_description'])) {
            $description = "        <description>" . self::prepare_description($product['products_description']) . "</description>\r\n";
        }
        $isClothes = in_array($product['categories_id'], $clothes_cat) ? true : false;
        $params = self::getParams($product['products_id'], $isClothes);
        if($params === false){
            return false;
        }

        if($price < 20000) {
            return "<offer id=\"" . $product['products_id'] . "\" available=\"{$available}\" > 
            {$name}
            <url>{$product_link}</url>
            <price>{$price}</price>{$oldPriceTag}
            <currencyId>RUR</currencyId>
            <categoryId>{$product['categories_id']}</categoryId>
            {$images}
            <store>true</store>
            <pickup>true</pickup>
            <delivery>true</delivery>
            <weight>{$weight}</weight>
            {$vendor}{$vendorCode}{$description}{$params}<sales_notes>Самовывоз, курьер. Трансп. комп. - предоплата 100%</sales_notes> 
            </offer>\r\n";
        }
    }

    private function getPrices($currencies, $productId, $product_tax, $product_price)
    {
        $oldPriceTag = '';
        if ($new_price = tep_get_products_special_price($productId)) {
            $price = trim($currencies->display_price_nodiscount($new_price, tep_get_tax_rate($product_tax)));
            $oldPrice = trim($currencies->display_price_nodiscount($product_price, tep_get_tax_rate($product_tax)));
            if (!empty($oldPrice)) {
                $oldPriceTag = "\r\n        <oldprice>{$product_tax}{$oldPrice}</oldprice>";
            }
            if (floatval($price) / floatval($oldPrice) > 0.95) {
                $oldPriceTag = '';
            }
        } else {
            $price = trim($currencies->display_price($product_price, tep_get_tax_rate($product_tax)));
        }
        return array('old' => $oldPriceTag, 'current' => $price);
    }

    private function getProductImages($product)
    {
        $images = array();
        $suffix = 'https://yourfish.ru/images/';
        if (!empty($product['products_image_lrg'])) {
            $images[] = self::prepare_image($suffix, $product['products_image_lrg']);
        } elseif (!empty($product['products_image_med'])) {
            $images[] = self::prepare_image($suffix, $product['products_image_med']);
        } elseif (!empty($product['products_image'])) {
            $images[] = self::prepare_image($suffix, $product['products_image']);
        }

        for ($i = 1; $i < 7; $i++) {
            if (!empty($product['products_image_xl_' . $i])) {
                $images[] = self::prepare_image($suffix, $product['products_image_xl_' . $i]);
            } elseif (!empty($product['products_image_sm_' . $i])) {
                $images[] = self::prepare_image($suffix, $product['products_image_sm_' . $i]);
            }
        }
        if (empty($images)) {
            return false;
        }
        return implode("\r\n", array_unique($images));
    }

    /**Image filter
     * @param $suffix
     * @param $img
     * @return string
     */
    private function prepare_image($suffix, $img)
    {
        if (stripos($img, ',') !== false) {
            $img = stristr($img, ',', true);
        }
        return '<picture>' . $suffix . str_replace(' ', '%20', $img) . '</picture>';
    }

    private function getProductWeight($products_weight)
    {
        $products_weight = floatval($products_weight);
        if ($products_weight > 900) {
            $weight = 0.05;
        } elseif ($products_weight == 0) {
            $weight = 0.3;
        } elseif ($products_weight > 40) {
            $weight = $products_weight / 100;
        } else {
            $weight = $products_weight;
        }
        return $weight;
    }

    /**Description filter
     * @param $text
     * @return string
     */
    private function prepare_description($text)
    {
        $exclude = array("скидка", "распродажа", "дешевый", "подарок", "бесплатно", "акция", "специальная цена",
            "новинка", "new", "аналог", "заказ", "хит");
        if (stripos($text, '<table') !== false) {
            $text = stristr($text, '<table', true);
        }
        return '<![CDATA[' . mb_substr(str_ireplace($exclude, '', trim(strip_tags($text, '<h3><ul><li>'))), 0, 2980) . ']]>';
    }

    function getParams($product_id, $isClothes)
    {
        $params_query = tep_db_query("SELECT  
          IF(vd.specification_values_id IS NULL, ps.specification, vd.specification_values_id) AS value1, 
          sd.specification_name                                                                AS specification_name
        FROM products_specifications AS ps
          INNER JOIN specifications AS s ON s.specifications_id = ps.specifications_id
          LEFT JOIN specification_values AS sv ON sv.specifications_id = ps.specifications_id
          LEFT JOIN specification_description as sd on sd.specifications_id = ps.specifications_id
          LEFT JOIN specification_values_description AS vd ON vd.specification_values_id = sv.specification_values_id
        WHERE
          ps.specifications_id <> 0
          AND ps.products_id = {$product_id}
          AND s.products_column_name = ''
          AND sd.language_id=1
          AND ps.specification <> ''
          AND (
          (
              vd.specification_value IS NOT NULL AND ps.specification = vd.specification_value
            )
            OR
            (
                vd.specification_value IS NULL
            )
          )");
        $params = '';
        $haveSize = false;
        while ($param = tep_db_fetch_array($params_query)) {
            if ($param['specification_name'] == 'Размер') {
                $haveSize = true;
            }
            $params .= '        <param name="' . $param['specification_name'] . '">' . $param['value1'] . '</param>' . "\r\n";
        }
        if ($isClothes && !$haveSize) {
            return false;
        } else {
            return $params;
        }
    }

    public static function showFooter()
    {
        echo " 
			</shop>
		</yml_catalog>";
    }
}

define('DIR_FS_CACHE', __DIR__ . '/cache/');
require('includes/application_top.php');
include(DIR_WS_FUNCTIONS . 'cache.php');
header("Content-Type: application/zip");
header("Expires: Thu, 19 Feb 1998 13:24:18 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Content-Disposition: attachment; filename=\"yandex_market2.zip\"");
header("Cache-Control: no-cache, must-revalidate");
header("Cache-Control: post-check=0,pre-check=0");
header("Cache-Control: max-age=0");
header("Pragma: no-cache");
if (!read_cache($cache_output, 'yandex_market2.xml', 2*60*60)) {
    mb_internal_encoding('UTF-8');
    ob_start();
    $exclude_cat = YandexMarket::getExcludeCatList();
    YandexMarket::showHeader();
    YandexMarket::showCategories($languages_id, $exclude_cat);
    YandexMarket::showOffers($currencies, $exclude_cat,1000);
    YandexMarket::showFooter();
    $cache_output = ob_get_contents();
    ob_end_clean();
    write_cache($cache_output, 'yandex_market2.xml');
    file_put_contents(DIR_FS_CACHE . 'yandex_market_tmp2.xml', $cache_output);
    shell_exec('cd ' . DIR_FS_CACHE . ' && rm yandex_market2.zip && zip yandex_market2.zip yandex_market_tmp2.xml');
}
header('Content-Length: ' . filesize(DIR_FS_CACHE . 'yandex_market2.zip'));
readfile(DIR_FS_CACHE . 'yandex_market2.zip');
exit;
