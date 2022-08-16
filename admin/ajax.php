<?php
require('includes/application_top.php');
switch ($_GET['action']){
    case 'list_categories':
        $parent = '';
        if(empty($_GET['search'])){
            $parent = 'INNER JOIN categories as c on c.categories_id=cd.categories_id and c.parent_id=0 ';
        }
        $query = "Select * From ".TABLE_CATEGORIES_DESCRIPTION." as cd ".
            $parent.
            " WHERE cd.categories_id='".tep_db_input($_GET['search'])."' ".
            " OR cd.categories_name LIKE '%".tep_db_input($_GET['search'])."%' Limit 60";
        $categories_query = tep_db_query($query);
        $cats = array();
        while ($cat = tep_db_fetch_array($categories_query)) {
            $cats[] = array('id' => $cat['categories_id'],
                'text' => $cat['categories_name']." (".$cat['categories_id'].")");
        }
        echo json_encode($cats);
        die();
        break;
    case 'list_products':
        $query = "Select * From ".TABLE_PRODUCTS." as p ".
            " INNER JOIN ".TABLE_PRODUCTS_DESCRIPTION." as pd on pd.products_id=p.products_id ".
            " WHERE p.products_id='".tep_db_input($_GET['search'])."' ".
            " OR pd.products_name LIKE '%".tep_db_input($_GET['search'])."%'".
            " OR p.products_model LIKE '%".tep_db_input($_GET['search'])."%' 
             Limit 60";
        $products_query = tep_db_query($query);
        $products = array();
        while ($product = tep_db_fetch_array($products_query)) {
            $products[] = array('id' => $product['categories_id'],
                'text' => $product['products_name']." (".$product['products_id'].")");
        }
        echo json_encode($products);
        die();
        break;
}