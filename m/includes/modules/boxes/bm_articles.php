<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2013 osCommerce

  Released under the GNU General Public License
*/

  class bm_articles {
    var $code = 'bm_articles';
    var $group = 'boxes_column_right';
    var $title;
    var $description;
    var $sort_order;
    var $enabled;
    private  $tree;
    private  $topics_string;
    private  $tPath_array;
    
    function bm_articles() {
      $this->title ='Статьи';
      $this->description = '';
      if (defined('MODULE_BOXES_ARTICLES_STATUS') ) {
        $this->sort_order = MODULE_BOXES_ARTICLES_SORT_ORDER;
        $this->enabled = (MODULE_BOXES_ARTICLES_STATUS == 'True');
        $this->group = ((MODULE_BOXES_ARTICLES_CONTENT_PLACEMENT == 'Left Column') ? 'boxes_column_left' : 'boxes_column_right');
      }
    }

    function execute() {
      global $oscTemplate,$languages_id;

    $data = '<div class="ui-widget infoBoxContainer mj-quickfind">' .
      '  <div class="ui-widget-header infoBoxHeading">' . $this->title . '</div>' .
      '  <div class="ui-widget-content infoBoxContents">';


  $this->topics_string = '';
  $this->tree = array();

  $topics_query = tep_db_query("select t.topics_id, td.topics_name, t.parent_id from " . TABLE_TOPICS . " t, " . TABLE_TOPICS_DESCRIPTION . " td where t.parent_id = '0' and t.topics_id = td.topics_id and td.language_id = '" . (int)$languages_id . "' order by sort_order, td.topics_name");
  while ($topics = tep_db_fetch_array($topics_query))  {
    $this->tree[$topics['topics_id']] = array('name' => $topics['topics_name'],
                                        'parent' => $topics['parent_id'],
                                        'level' => 0,
                                        'path' => $topics['topics_id'],
                                        'next_id' => false);

    if (isset($parent_id)) {
      $this->tree[$parent_id]['next_id'] = $topics['topics_id'];
    }

    $parent_id = $topics['topics_id'];

    if (!isset($first_topic_element)) {
      $first_topic_element = $topics['topics_id'];
    }
  }

  //------------------------
  if (tep_not_null($tPath)) {
    $new_path = '';
    reset($this->tPath_array);
    while (list($key, $value) = each($this->tPath_array)) {
      unset($parent_id);
      unset($first_id);
      $topics_query = tep_db_query("select t.topics_id, td.topics_name, t.parent_id from " . TABLE_TOPICS . " t, " . TABLE_TOPICS_DESCRIPTION . " td where t.parent_id = '" . (int)$value . "' and t.topics_id = td.topics_id and td.language_id = '" . (int)$languages_id . "' order by sort_order, td.topics_name");
      if (tep_db_num_rows($topics_query)) {
        $new_path .= $value;
        while ($row = tep_db_fetch_array($topics_query)) {
          $this->tree[$row['topics_id']] = array('name' => $row['topics_name'],
                                           'parent' => $row['parent_id'],
                                           'level' => $key+1,
                                           'path' => $new_path . '_' . $row['topics_id'],
                                           'next_id' => false);

          if (isset($parent_id)) {
            $this->tree[$parent_id]['next_id'] = $row['topics_id'];
          }

          $parent_id = $row['topics_id'];

          if (!isset($first_id)) {
            $first_id = $row['topics_id'];
          }

          $last_id = $row['topics_id'];
        }
        $this->tree[$last_id]['next_id'] = $this->tree[$value]['next_id'];
        $this->tree[$value]['next_id'] = $first_id;
        $new_path .= '_';
      } else {
        break;
      }
    }
  }
  
  $this->tep_show_topic($first_topic_element);

  $info_box_contents = array();
  $new_articles_string = '';
  $all_articles_string = '';

  if (DISPLAY_NEW_ARTICLES=='true') {
    if (SHOW_ARTICLE_COUNTS == 'true') {
      $articles_new_query = tep_db_query("select a.articles_id from " . TABLE_ARTICLES . " a left join " . TABLE_AUTHORS . " au on a.authors_id = au.authors_id, " . TABLE_ARTICLES_TO_TOPICS . " a2t left join " . TABLE_TOPICS_DESCRIPTION . " td on a2t.topics_id = td.topics_id, " . TABLE_ARTICLES_DESCRIPTION . " ad where (a.articles_date_available IS NULL or to_days(a.articles_date_available) <= to_days(now())) and a.articles_id = a2t.articles_id and a.articles_status = '1' and a.articles_id = ad.articles_id and ad.language_id = '" . (int)$languages_id . "' and td.language_id = '" . (int)$languages_id . "' and a.articles_date_added > SUBDATE(now( ), INTERVAL '" . NEW_ARTICLES_DAYS_DISPLAY . "' DAY)");
      $articles_new_count = ' (' . tep_db_num_rows($articles_new_query) . ')';
    } else {
      $articles_new_count = '';
    }

    if (strstr($_SERVER['PHP_SELF'],FILENAME_ARTICLES_NEW) or strstr($PHP_SELF,FILENAME_ARTICLES_NEW)) {
      $new_articles_string = '<b>';
    }

    $new_articles_string .= '<a href="' . tep_href_link(FILENAME_ARTICLES_NEW, '', 'NONSSL') . '">' . BOX_NEW_ARTICLES . '</a>';

    if (strstr($_SERVER['PHP_SELF'],FILENAME_ARTICLES_NEW) or strstr($PHP_SELF,FILENAME_ARTICLES_NEW)) {
      $new_articles_string .= '</b>';
    }

    $new_articles_string .= $articles_new_count . '<br>';

  }

  if (DISPLAY_ALL_ARTICLES=='true') {
    if (SHOW_ARTICLE_COUNTS == 'true') {
      $articles_all_query = tep_db_query("select a.articles_id from " . TABLE_ARTICLES . " a left join " . TABLE_AUTHORS . " au on a.authors_id = au.authors_id, " . TABLE_ARTICLES_TO_TOPICS . " a2t left join " . TABLE_TOPICS_DESCRIPTION . " td on a2t.topics_id = td.topics_id, " . TABLE_ARTICLES_DESCRIPTION . " ad where (a.articles_date_available IS NULL or to_days(a.articles_date_available) <= to_days(now())) and a.articles_id = a2t.articles_id and a.articles_status = '1' and a.articles_id = ad.articles_id and ad.language_id = '" . (int)$languages_id . "' and td.language_id = '" . (int)$languages_id . "'");
      $articles_all_count = ' (' . tep_db_num_rows($articles_all_query) . ')';
    } else {
      $articles_all_count = '';
    }

    if ($topic_depth == 'top') {
      $all_articles_string = '<b>';
    }

    $all_articles_string .= '<a href="' . tep_href_link(FILENAME_ARTICLES, '', 'NONSSL') . '">' . BOX_ALL_ARTICLES . '</a>';

    if ($topic_depth == 'top') {
      $all_articles_string .= '</b>';
    }

    $all_articles_string .= $articles_all_count . '<br>';

  }


/*  $info_box_contents = array();
  $info_box_contents[] = array('text' => $new_articles_string . $all_articles_string . $this->topics_string);

new infoBox($info_box_contents);
*/
$data.=$new_articles_string . $all_articles_string . $this->topics_string;



     $data.='  </div>' .
      '</div>';

      $oscTemplate->addBlock($data, $this->group);
    }

  function tep_show_topic($counter) {
//    global $tree, $topics_string, $tPath_array;

    for ($i=0; $i<$this->tree[$counter]['level']; $i++) {
      $this->topics_string .= "&nbsp;&nbsp;";
    }

    $this->topics_string .= '<a href="';

    if ($this->tree[$counter]['parent'] == 0) {
      $tPath_new = 'tPath=' . $counter;
    } else {
      $tPath_new = 'tPath=' . $this->tree[$counter]['path'];
    }

    $this->topics_string .= tep_href_link(FILENAME_ARTICLES, $tPath_new) . '">';

    if (isset($this->tPath_array) && in_array($counter, $this->tPath_array)) {
      $this->topics_string .= '<b>';
    }

// display topic name
    $this->topics_string .= $this->tree[$counter]['name'];

    if (isset($this->tPath_array) && in_array($counter, $this->tPath_array)) {
      $this->topics_string .= '</b>';
    }

    if (tep_has_topic_subtopics($counter)) {
      $this->topics_string .= ' -&gt;';
    }

    $this->topics_string .= '</a>';

    if (SHOW_ARTICLE_COUNTS == 'true') {
      $articles_in_topic = tep_count_articles_in_topic($counter);
      if ($articles_in_topic > 0) {
        $this->topics_string .= '&nbsp;(' . $articles_in_topic . ')';
      }
    }

    $this->topics_string .= '<br>';

    if ($this->tree[$counter]['next_id'] != false) {
      $this->tep_show_topic($this->tree[$counter]['next_id']);
    }
  }





    function isEnabled() {
      return $this->enabled;
    }

    function check() {
     return defined('MODULE_BOXES_ARTICLES_STATUS');
    }

    function install() {
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Enable Module', 'MODULE_BOXES_ARTICLES_STATUS', 'True', 'Do you want to add the module to your shop?', '6', '1', 'tep_cfg_select_option(array(\'True\', \'False\'), ', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Content Placement', 'MODULE_BOXES_ARTICLES_CONTENT_PLACEMENT', 'Left Column', 'Should the module be loaded in the left or right column?', '6', '1', 'tep_cfg_select_option(array(\'Left Column\', \'Right Column\'), ', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Sort Order', 'MODULE_BOXES_ARTICLES_SORT_ORDER', '0', 'Sort order of display. Lowest is displayed first.', '6', '0', now())");

    }

    function remove() {
      tep_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");

    }

    function keys() {
      return array('MODULE_BOXES_ARTICLES_STATUS', 
    	           'MODULE_BOXES_ARTICLES_CONTENT_PLACEMENT', 
    	           'MODULE_BOXES_ARTICLES_SORT_ORDER'
    	           );

    return null;
    }
  }
?>