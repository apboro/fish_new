<script type="text/javascript" src="jscript/jquery/jquery.js"></script>

<script type="text/javascript" src="ddaccordion.js"></script>
<script type="text/javascript">
    ddaccordion.init({
        headerclass: "submenuheader",
        contentclass: "submenu",
        revealtype: "clickgo",
        mouseoverdelay: 500,
        collapseprev: true,
        defaultexpanded: [],
        onemustopen: false,
        animatedefault: false,
        persiststate: true,
        toggleclass: ["", ""],
        togglehtml: ["suffix", "<img src=\'images/plus.gif\' class=\'statusicon\' />", ""],
        animatespeed: "fast",
        collapseheader: false,
        oninit: function (headers, expandedindices) {
        },
        onopenclose: function (header, index, state, isuseractivated) {
        }
    })

</script>


<style type="text/css">
    .glossymenu {
        margin: 5px 0;
        padding: 0;
        width: 205px; /*width of menu*/
        border: 1px solid #9A9A9A;
        border-bottom-width: 0;
        /*display:none;*/
    }
    .glossymenu .menuitem:first-child, .glossymenu .menuitem[headerindex='3h'], .submenu-135 {
        background: red!important;
    }
    .glossymenu a.menuitem {
        background: black url(images/glossyback.gif) repeat-x bottom left;
        font: bold 14px "Lucida Grande", "Trebuchet MS", Verdana, Helvetica, sans-serif;
        color: white;
        display: block;
        position: relative; /*To help in the anchoring of the ".statusicon" icon image*/
        width: auto;
        padding: 4px 0;
        padding-left: 10px;
        text-decoration: none;
    }

    .glossymenu a.menuitem:visited, .glossymenu .menuitem:active {
        color: white;
    }

    .glossymenu a.menuitem .statusicon { /*CSS for icon image that gets dynamically added to headers*/
        position: absolute;
        top: 5px;
        right: 5px;
        border: none;
    }

    .glossymenu a.menuitem:hover {
        background-image: url(images/glossyback2.gif);
    }

    .glossymenu div.submenu { /*DIV that contains each sub menu*/
        background: white;
    }

    .glossymenu div.submenu ul { /*UL of each sub menu*/
        list-style-type: none;
        margin: 0;
        padding: 0;
        background-color: #91cbf4;

    }

    .glossymenu div.submenu ul li {
        border-bottom: 1px solid blue;
    }

    .glossymenu div.submenu ul li a {
        display: block;
        font: normal 13px "Lucida Grande", "Trebuchet MS", Verdana, Helvetica, sans-serif;
        color: black;

        text-decoration: none;
        border-bottom: 1px dotted #5ba0d0;
        padding: 2px 0;
        padding-left: 10px;
    }

    .glossymenu div.submenu ul li a:hover {
        background: url("/images/glossyback2.gif") repeat-x;
        color: white;
        /*background: #DFDCCB;*/
        /*color: white;*/
    }

    .wr_cat_all {
    display: flex;
    justify-content: center;
    margin: 5px 0;
}

a.btn_cat_all {
    text-align: center;
    width: 130px;
    /* border: 1px solid #f8f8f9; */
    background: gray;
    padding: 5px;
    color: white;
    font-size: 14px;
    border-radius: 5px;
}

a.btn_cat_all:hover {
    color: inherit;
    text-decoration: none;
}
a.btn_cat_all span {
    text-transform: lowercase;
}
/*.glossymenu .menuitem.submenuheader[headerindex='3h'] {
    background: red!important;
}*/

</style>


<tr>
    <td valign="top">
        <?php
        if (!isset($c2c_array)) {
            $c2c_array = GetCategoriesProductsCount();
        }
        if (!isset($deduction_map)) {
            $deduction_map = GetDeductionMap();
        }


        $info_box_contents = array();
        $info_box_contents[] = array('text' => BOX_HEADING_CATEGORIES);

        new infoBoxHeading($info_box_contents); ?>
        <table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" style="margin-top:1px;">
            <tr>
                <td valign="top" style="padding:1px; ">


                    <?php
                    // Categories  Accordion Menu
                    // coded by flist 2009
                    // @florist duzgun.com forum

                    //  categories list

                    //$status = tep_db_num_rows(tep_db_query('describe ' .  TABLE_CATEGORIES . ' status'));


                    $query = "select c.categories_id, cd.categories_name, c.parent_id, c.categories_image
            from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd
            where c.categories_id = cd.categories_id and c.categories_status = '1' and c.parent_id < 1";


                    $query .= " and cd.language_id='" . $languages_id . "'
            order by c.sort_order, cd.categories_name";

                    $categories_query = tep_db_query($query);
                    // Display box contents
                    $sortik = '?sort=products_sort_order&vls=1';
                    if (($refresh == true) || !read_cache($cache_output, 'category-menu-' . $language . '.cache', 300)) {
                        ob_start();
                        global $menu;
                        $menu = array();
                        echo '<div class="glossymenu">';
                        /*in the top of menu display rasprodazha*/
                        function displayCatsMenu($categories_query,$cPath_array,$query,$category_id,$languages_id,$notParent = false,$c2c_array)
                        {
                            global $menu;
                            $categoryList = array();
                            while ($categoryItems = tep_db_fetch_array($categories_query)) {
                                $categories[] = $categoryItems;
                            }
                            usort($categories, function ($a, $b) {
                                if ($a['categories_name'] == $b['categories_name']) {
                                    return 0;
                                }
                                return ($a['categories_name'] < $b['categories_name']) ? -1 : 1;
                            });
                            foreach ($categories as $categories) {
                                $echo = '';
                                if($categories['categories_id'] == '68'){
                                    //Удочки классиические
                                    $query1 = "select c.categories_id, 'УДОЧКИ КЛАССИЧЕСКИЕ' AS categories_name, c.parent_id, c.categories_image
            from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd
            where c.categories_id = cd.categories_id and c.categories_status = '1' 
            AND c.categories_id = 202 and cd.language_id='" . $languages_id . "'
            order by sort_order, cd.categories_name ";
                                    $categories_query2 = tep_db_query($query1);
                                    $query2  = "select c.categories_id, cd.categories_name, c.parent_id, c.categories_image
            from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd
            where c.categories_id = cd.categories_id and c.categories_status = '1' 
            AND c.parent_id = 202 and cd.language_id='" . $languages_id . "'
            order by sort_order, cd.categories_name ";
                                    displayCatsMenu($categories_query2,$cPath_array,$query2,$category_id,$languages_id,true,$c2c_array);
                                }
                                if ($categories['parent_id'] == 0 || $notParent) {
                                    $temp_cPath_array = $cPath_array;  //Johan's solution - kill the array but save it for the rest of the site
                                    unset($cPath_array);
                                    $cPath_new = tep_get_path($categories['categories_id']);
                                    $text_subcategories = '';
                                    $query = "select c.categories_id, cd.categories_name, c.parent_id, c.categories_image
            from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd
            where c.categories_id = cd.categories_id and c.categories_status = '1' and c.parent_id =".$categories['categories_id'];
                                    $subcategories_query = tep_db_query($query);
                                    while ($subcategories = tep_db_fetch_array($subcategories_query)) {
                                        if ($subcategories['parent_id'] == $categories['categories_id']) {
                                            $cPath_new_sub = "cPath=" . $categories['categories_id'] . "_" . $subcategories['categories_id'];
//---modified by iHolder
                                            if ($c2c_array[$subcategories['categories_id']]>0){
                                            $text_subcategories .= '<a href="' . tep_href_link(FILENAME_DEFAULT, $cPath_new_sub, 'NONSSL') . '">' . $subcategories['categories_name'] . '</a>' . " ";
                                            }
//---modified by iHolder
//           $text_subcategories .= '<a href="' . tep_href_link(FILENAME_DEFAULT, $cPath_new_sub, 'NONSSL') . '">' . $subcategories['categories_name'] . '</a>' . " ";

                                        } // if
                                    } // While Interno

                                    if (tep_has_category_subcategories($category_id)) {
                                        $child_category_query = tep_db_query("select count(*) as count from " . TABLE_CATEGORIES . " where parent_id = '" . $categories['categories_id'] . "'");
                                        $child_category = tep_db_fetch_array($child_category_query);

                                        if ($child_category['count'] > 0) {
                                            $echo .= '<a class="menuitem submenuheader" href="' . tep_href_link(FILENAME_DEFAULT, $cPath_new, 'NONSSL') . '">' . $categories['categories_name'] . '</a>';
                                            $echo .= '<div class="submenu submenu-'.$categories['categories_id'].'">';
                                            $html_more='<div class="wr_cat_all"><a class="btn_cat_all" href="'.tep_href_link(FILENAME_DEFAULT, $cPath_new, 'NONSSL').'">Все <span>'.$categories['categories_name'].' </span></a></div>'; 
                                            $echo .= $html_more.'<ul><li>' . $text_subcategories . '</li></ul>';
                                            $echo .= '</div>';
                                        } else {
                                            $echo .= '<a class="menuitem submenu-'.$categories['categories_id'].'" href="' . tep_href_link(FILENAME_DEFAULT, $cPath_new, 'NONSSL') . '">' . $categories['categories_name'] . '</a>';
                                        }
                                    }
                                    $cPath_array = $temp_cPath_array; //Re-enable the array for the rest of the code
                                }
                                $menu[$categories['categories_id']]= $echo;
                            }
                        }

                        displayCatsMenu($categories_query,$cPath_array,$query,$category_id,$languages_id,false,$c2c_array);

                    /*in the top of menu display rasprodazha*/
                    if (isset($_GET['sort']) ? $this_sort = $_GET['sort'] : $this_sort = 'products_sort_order') ;
                    echo '<a class="menuitem submenuheader" href="/' . FILENAME_DISCOUNT . '">РАСПРОДАЖА</a>';
                    echo '<div class="submenu">';
                    echo '<ul><li>';
                    $dquery = "select cd.categories_id as id,cd.categories_name as name from " .
                        TABLE_CATEGORIES_DESCRIPTION . " cd where cd.language_id = '" . $languages_id . "'";
                    $display_cat = $deduction_map['categories'];
                    if (sizeof($display_cat) > 0) {
                        $dquery .= " and cd.categories_id in(" . implode(',', array_keys($display_cat)) . ") ";
                    }
                    $dquery .= " order by categories_name";
                    $dcq = tep_db_query($dquery);
                    if ($dcq !== false) {
                        while ($dcres = tep_db_fetch_array($dcq)) {
                            echo '<a href="/' . FILENAME_DISCOUNT . '?vPath=' . $dcres['id'] . '">' . $dcres['name'] . '</a>';
                        }
                    }
                    unset($dcq, $dcres);
                    echo '</li></ul>';
                    echo '</div>';
                        echo implode('',$menu);
                        echo '</div>';
                        $cache_output = ob_get_contents();
                        ob_end_clean();
                        write_cache($cache_output, 'category-menu-' . $language . '.cache');
                    }
                    echo $cache_output;
                    ?>
                    <script type="text/javascript">
                        jQuery(document).ready(function () {
                            jQuery("a.submenuheader").each(function () {
                                jQuery(this).attr("rel", jQuery(this).attr("href"));
                                jQuery(this).attr("href", "javascript:void()");
                                jQuery(this).click(function () {
                                    DoTitleClick(this);
                                    return false;
                                });
                            });

                            var click_url = "";

                            function DoTitleClick(obj) {
                                if (click_url == jQuery(obj).attr("rel")) {
                                    document.location = click_url;
                                } else {
                                    click_url = jQuery(obj).attr("rel");
                                }
                            }
                        })
                    </script>

                </td>
            </tr>
        </table>
    </td>
</tr>
<!-- show_subcategories_eof //-->
