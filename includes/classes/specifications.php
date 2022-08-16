<?php
/*
  $Id: specifications.php, v1.0 20090909 Yarhajile Exp $
  $Loc: catalog/includes/classes/ $
  $Mod: 1.0.1.1 20090917 kymation $
  
  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2009 osCommerce

  Released under the GNU General License
*/


class Specifications {
    var $specs = array ();
    var $applied_filters = array ();
    var $current_category_id;
    var $languages_id;
    var $in_categories_buffer = array();

    function Specifications() {
        global $current_category_id, $languages_id;

        $this->current_category_id = $current_category_id;
        $this->languages_id = $languages_id;

        $this->setAppliedFilters();
    }

    function setAppliedFilters() {
        $category_sql = $this->current_category_id != 0 ? "and s2c.categories_id = '" . $this->current_category_id . "'" : '';

        // Check for filters on each applicable Specification
        $specs_query_raw = "SELECT
                            s.specifications_id,
                            s.filter_class,
                            s.products_column_name,
                            sd.specification_name
                          FROM
                            " . TABLE_SPECIFICATION . " AS s
                          INNER JOIN " . TABLE_SPECIFICATION_GROUPS . " AS sg
                            ON s.specification_group_id = sg.specification_group_id
                          INNER JOIN " . TABLE_SPECIFICATIONS_TO_CATEGORIES . " AS s2c
                            ON sg.specification_group_id = s2c.specification_group_id
                          INNER JOIN " . TABLE_SPECIFICATION_DESCRIPTION . " sd 
                            ON sd.specifications_id = s.specifications_id
                          WHERE
                            s.show_filter = 'True'
                            AND sg.show_filter = 'True' 
                            " . $category_sql . "
                         ";

        $specs_query = tep_db_query($specs_query_raw);

        while ($specs_array = tep_db_fetch_array($specs_query)) {
            // Retrieve the GET vars used as filters
            // Variable names are the letter "f" followed by the specifications_id for that spec.
            $var = $specs_array['specifications_id'];
            $$var = '0';

            if (isset ($_GET['f' . $var]) && $_GET['f' . $var] != '') {
                // Decode the URL-encoded names, including arrays
                $$var = tep_decode_recursive ($_GET['f' . $var]);
                // Set the cporrect variable type (All _GET variables are strings by default)
                $$var = tep_set_type($$var);

                $this->applied_filters[$var] = $$var;
            } // if (isset ($_GET[$var]

        } // while ($specs_array
    }

    function getAppliedFilters() {
        return $this->applied_filters;
    }

    function getFilterInCategoriesQuery(){
        if (!isset($this->in_categories_buffer[$this->current_category_id])) {
            if (!read_cache($in_categories, 'in-categories-list-' . $this->current_category_id . '.cache', 300)) {
                $subcategories_array = array();
                tep_get_subcategories($subcategories_array, $this->current_category_id, true);
                if (SPECIFICATIONS_FILTER_SUBCATEGORIES == 'True' && count($subcategories_array) > 0) {
                    $category_ids = $this->current_category_id . ',' . implode(',', $subcategories_array);
                    $in_categories .= '   ' . "and p2c.categories_id in (" . $category_ids . ") ";
                } else {
                    $in_categories .= " and p2c.categories_id = '" . $this->current_category_id . "' ";
                }
                $this->in_categories_buffer[$this->current_category_id] = $in_categories;
                write_cache($in_categories, 'in-categories-list-'.$this->current_category_id.'.cache' );
            }
            return $in_categories;
        } else {
            return $this->in_categories_buffer[$this->current_category_id];
        }
    }


    function getGroupFilterCount($specification, $specifications_id, $filter_class, $products_column_name, $only_exist = false)
    {
        global $cPath, $language;
        /*
         * TODO:Нужно добавить кэш
         */
        if (!read_cache($counts, 'products_filter-' . $language . 'spec' . $filter_class . 'class' . $specifications_id . $products_column_name . $cPath . '.cache', 300)) {
            if ($only_exist) {
                $raw_query_start = "SELECT EXISTS (select STRAIGHT_JOIN * ";
            } else {
                $raw_query_start = "select STRAIGHT_JOIN count(distinct p.products_id) as count ";
            }
            $in_categories = " ";
            if ($this->current_category_id != 0) { // Restrict query to the appropriate category/categories
                $in_categories = $this->getFilterInCategoriesQuery();
            }
            $languages_id = '1';
            $spec_select = '';
            $count_el = 0;
            switch ($filter_class) {
                case 'range' :
                    foreach ($specification as $specification_item) {
                        $filters_range = explode('-', $specification_item);
                        $filters_range = array_map('tep_set_filter_case', $filters_range);
                        if (count($filters_range) < 2) {
                        } else { // There are two parameters, so treat them as minimum and maximum
                            $spec_select .= "IF(ps" . $specifications_id . ".specification <= {$filters_range[1]},'" . $specification_item . "',\r\n";
                            $count_el++;
                        }
                    }
                    $spec_select .= "0" . str_repeat(')', $count_el);
            }
            $raw_query_start .= ',' . $spec_select . ' as item';
            $raw_query_from = " FROM (" . TABLE_PRODUCTS . " p)
INNER JOIN (" . TABLE_PRODUCTS_TO_CATEGORIES . " p2c)
ON (p.products_id = p2c.products_id) " . $in_categories .
                " and p.products_status = '1' and p.products_quantity>0 
INNER JOIN " . TABLE_CATEGORIES . " cat
ON (cat.categories_id = p2c.categories_id) and cat.categories_status = '1'";
            $raw_query_from .= " inner join  products_description pd on (p.products_id=pd.products_id) ";

            $raw_query_from .= " INNER JOIN " . TABLE_PRODUCTS_SPECIFICATIONS . " ps" .
                $specifications_id . " ON p.products_id = ps" . $specifications_id . ".products_id
            AND ps" . $specifications_id . ".specifications_id = '" . $specifications_id . "'
            AND ps" . $specifications_id . ".language_id = '" . (int)$languages_id . "'";
            $raw_query = $raw_query_start . $raw_query_from . ' group by item';

            if ($only_exist) {
                $raw_query .= ' ) as count';
            }
            $filter_count_query = tep_db_query($raw_query);
            $counts = array();
            while ($filter_count = tep_db_fetch_array($filter_count_query)) {
                $counts[$filter_count['item']] = $filter_count['count'];
            }
            write_cache($counts, 'products_filter-' . $language  . 'spec' . $filter_class . 'class' . $specifications_id . $products_column_name . $cPath . '.cache');
        }
        return $counts;
    }

    function getFilterCount($specification, $specifications_id, $filter_class, $products_column_name, $only_exist = false) {
        global $cPath, $language;
        if ( !read_cache($count, 'products_filter-' . $language . $specification . 'spec' . $filter_class . 'class' . $specifications_id . $products_column_name.$cPath . '.cache' , 300)) {
            if($only_exist) {
                $raw_query_start = "SELECT EXISTS (select STRAIGHT_JOIN * ";
            }else{
                $raw_query_start = "select STRAIGHT_JOIN count(distinct p.products_id) as count ";
            }
            $raw_query_where = " ";
            $in_categories = " ";
            if ($this->current_category_id != 0) { // Restrict query to the appropriate category/categories
                $in_categories = $this->getFilterInCategoriesQuery();
            } // if ($this->current_category_id
            $raw_query_addon_array = tep_get_filter_sql($filter_class, $specifications_id, $specification, $products_column_name, '1');

            if ($products_column_name == 'products_price') {
                $price_where = $raw_query_addon_array['where'];
            } else {
                $raw_query_where .= $raw_query_addon_array['where'];
            }
            $raw_query_from = " FROM (" . TABLE_PRODUCTS . " p)
INNER JOIN (" . TABLE_PRODUCTS_TO_CATEGORIES . " p2c)
ON (p.products_id = p2c.products_id) " . $in_categories .
                " and p.products_status = '1' and p.products_quantity>0 ".$price_where."
INNER JOIN " . TABLE_CATEGORIES . " cat
ON (cat.categories_id = p2c.categories_id) and cat.categories_status = '1'";
            $raw_query_from .= " inner join  products_description pd on (p.products_id=pd.products_id) ";
            $raw_query_from .= $raw_query_addon_array['from'];
            $applied_filters = $this->getAppliedFilters();
            foreach ($applied_filters as $k => $v) {
                if ($k == $specifications_id) {
                    continue;
                }

                $specs_array = $this->getSpecification($k);
                $raw_query_addon_array = tep_get_filter_sql($specs_array['filter_class'], $specs_array['specifications_id'], $v, $specs_array['products_column_name'], $this->languages_id);
//var_dump($raw_query_addon_array);exit;
                //  $raw_query_from .= $raw_query_addon_array['from'];
                //   $raw_query_where .= $raw_query_addon_array['where'];
            } // foreach($applied_filters
            $raw_query = $raw_query_start . $raw_query_from . $raw_query_where;
            /*  print 'Raw Query: ' . $raw_query . '<br>';
              exit;*/
            if($only_exist) {
                $raw_query .= ' ) as count';
            }
            $filter_count_query = tep_db_query($raw_query);
            $filter_count_results = tep_db_fetch_array($filter_count_query);
            $price_where = '';

            $count = (string)$filter_count_results['count'];

            write_cache($count, 'products_filter-' . $language.$specification.'spec'.$filter_class.'class'.$specifications_id.$products_column_name.$cPath . '.cache');
        }
        return $count;
    }

    function getSpecification ($id) {
        if (!isset ($this->specs[$id]) ) {
            $specs_query_raw = "SELECT
                              s.specifications_id,
                              s.products_column_name,
                              s.filter_class,
                              s.filter_show_all,
                              s.filter_display,
                              sd.specification_name,
                              sd.specification_prefix,
                              sd.specification_suffix
                            FROM
                              " . TABLE_SPECIFICATION . " s
                            JOIN " . TABLE_SPECIFICATION_DESCRIPTION . " sd
                              ON s.specifications_id = sd.specifications_id
                            JOIN " . TABLE_SPECIFICATION_GROUPS . " sg
                              ON s.specification_group_id = sg.specification_group_id
                            JOIN " . TABLE_SPECIFICATIONS_TO_CATEGORIES . " s2c
                              ON sg.specification_group_id = s2c.specification_group_id
                            WHERE
                              s.specifications_id = '" . $id . "'
                              and s.show_filter = 'True'
                              and sg.show_filter = 'True'
                              and sd.language_id = '" . $this->languages_id . "'
                              and s2c.categories_id = '" . $this->current_category_id . "'
                           ";
            $specs_query = tep_db_query ($specs_query_raw);

            $this->specs[$id] = tep_db_fetch_array ($specs_query);
        }

        return $this->specs[$id];
    }
}

?>