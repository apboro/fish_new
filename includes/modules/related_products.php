<style>
    #wrapper {
        width: 100%;
        max-height: 295px;
        overflow: hidden;
    }
    #inner {
        width: 100%;
        padding: 20px 0;
        position: relative;
        overflow: hidden;
    }
    #carousel a {
        display:block;
        width: 160px;
        height: 230px;
        float: left;
        text-align: center;
        padding: 10px;
        margin: 0 5px;
    }
    #pager {
        text-align: center;
        margin-top: 20px;
        color: #666;
    }
    #pager a {
        color: #666;
        text-decoration: none;
        display: inline-block;
        padding: 5px 10px;
    }
    #pager a:hover {
        color: #333;
    }
    #pager a.selected {
        background-color: #333;
        color: #ccc;
    }
    #prev, #next {
        display: block;
        width: 40px;
        height: 40px;
        margin-top: -40px;
        position: absolute;
        top: 50%;
        z-index: 2;
    }
    #prev:hover, #next:hover{
        opacity: 0.6;
    }
    .carou-img{
        height: 150px;
        display: table-cell;
        text-align: center;
        width: 160px;
        vertical-align: middle;
        overflow: hidden;
    }
    #prev {
        background: url( /ext/images/icons/gui-prev.png ) no-repeat;
        background-position: center;
        left: 0;
    }
    #next {
        background: url( /ext/images/icons/gui-next.png ) no-repeat;
        background-position: center;
        right: 0;
    }
    #copy {
        text-align: center;
        width: 100%;
        position: absolute;
        bottom: 10px;
        left: 0;
    }
    #copy, #copy a {
        color: #999;
    }
</style>
<?php
if (isset($_GET['products_id'])) {
    $cats_query = tep_db_query("SELECT cat.parent_id, cat.categories_id FROM ".TABLE_PRODUCTS_TO_CATEGORIES.
        " as pr INNER JOIN ".TABLE_CATEGORIES." as cat on (pr.categories_id = cat.categories_id) ".
        "WHERE pr.products_id =".$_GET['products_id']." Limit 1");
    $cats = tep_db_fetch_array($cats_query);
    $cat_id = -1 ;
    while($cat_id == -1){
        if($cats['parent_id'] == 0){
            $cat_id = $cats['categories_id'];
        }else{
            $cats_query = tep_db_query("SELECT cat.parent_id, cat.categories_id FROM  ".
                TABLE_CATEGORIES." as cat ".
                "WHERE cat.categories_id =".$cats['parent_id']." Limit 1");
            $cats = tep_db_fetch_array($cats_query);
        }
    }
    $orders_query = tep_db_query("SELECT cat.categories_id,cat.categories_image
            FROM `".TABLE_CATEGORIES."` AS cat
            INNER JOIN (
                SELECT cat.categories_id, RAND() AS `rnd` 
                FROM `".TABLE_CATEGORIES."` as cat 
                WHERE cat.categories_id NOT IN (56,2208,63,135,89,".$cat_id.") 
                AND cat.parent_id = 0 AND cat.categories_status = 1
                ORDER BY `rnd` ASC LIMIT 6) AS `x` ON x.categories_id = cat.categories_id 
            LIMIT 6 ");
   // $num_products = tep_db_($orders_query);
    ?>
    <!-- also_purchased_products //-->

    <?php
    $info_box_contents = array();
    $info_box_contents[] = array('text' => TEXT_RELATED_PRODUCTS);

    new infoBoxHeading($info_box_contents, false, false);

    $row = 0;
    $col = 0;
    $info_box_contents = array();
    echo "<div id=\"wrapper\"> <div id=\"inner\"> <div id=\"carousel\">";
    while ($orders = tep_db_fetch_array($orders_query)) {
        $cPath_cur = tep_get_path($orders['categories_id']);
        $orders['products_name'] = tep_get_categories_name($orders['categories_id']);
        ?>
        <a class="item" href="<?= tep_href_link(FILENAME_DEFAULT, $cPath_cur)?>">
            <div class="carou-img"><?=tep_image(STATIC_DOMAIN . DIR_WS_IMAGES .
                $orders['categories_image'], $orders['products_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT);?></div>
            <div><?=$orders['products_name'] ?></div>
        </a>
        <?php
    }
    echo "</div>
		<a href=\"#\" id=\"prev\"></a>
		<a href=\"#\" id=\"next\"></a></div></div>";
    if (MAIN_TABLE_BORDER == 'yes') {
        $info_box_contents = array();
        $info_box_contents = array();
        $info_box_contents[] = array('align' => 'left',
            'text' => tep_draw_separator('pixel_trans.gif', '100%', '1')
        );
        new infoboxFooter($info_box_contents, true, true);
    }
    ?>
    <!-- also_purchased_products_eof //-->
    <?php
}
?>
<script src="/ext/js/carousel.js"></script>
<script>
    (function ($) {
        $(document).ready(function () {
            $('#carousel').carouFredSel({
                width: '100%',
                auto: false,
                scroll: {
                    duration: 750
                },
                prev: {
                    button: '#prev',
                    items: 3,
                },
                next: {
                    button: '#next',
                    items: 3,
                },
            });

        })
    })(jQuery);
</script>
