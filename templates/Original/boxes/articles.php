<?php
/*
  $Id: information.php,v 1.1.1.1 2003/09/18 19:05:51 wilt Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2001 osCommerce

  Released under the GNU General Public License
*/
  function tep_show_topic($counter) {
    global $tree, $topics_string, $tPath_array;

    for ($i=0; $i<$tree[$counter]['level']; $i++) {
      $topics_string .= "&nbsp;&nbsp;";
    }

    $topics_string .= '<a href="';

    if ($tree[$counter]['parent'] == 0) {
      $tPath_new = 'tPath=' . $counter;
    } else {
      $tPath_new = 'tPath=' . $tree[$counter]['path'];
    }

    $topics_string .= tep_href_link(FILENAME_ARTICLES, $tPath_new) . '">';

    if (isset($tPath_array) && in_array($counter, $tPath_array)) {
      $topics_string .= '<b>';
    }

// display topic name
    $topics_string .= $tree[$counter]['name'];

    if (isset($tPath_array) && in_array($counter, $tPath_array)) {
      $topics_string .= '</b>';
    }

    if (tep_has_topic_subtopics($counter)) {
      $topics_string .= ' -&gt;';
    }

    $topics_string .= '</a>';

    if (SHOW_ARTICLE_COUNTS == 'true') {
      $articles_in_topic = tep_count_articles_in_topic($counter);
      if ($articles_in_topic > 0) {
        $topics_string .= '&nbsp;(' . $articles_in_topic . ')';
      }
    }

    $topics_string .= '<br>';

    if ($tree[$counter]['next_id'] != false) {
      tep_show_topic($tree[$counter]['next_id']);
    }
  }
  
  
?>
<!-- topics //-->
          <tr>
		  
            <td>

			
<?php


  $info_box_contents = array();
/* ORIGINAL 213
  $info_box_contents[] = array('text' => '<font color="' . $font_color . '">' . BOX_HEADING_ARTICLES . '</font>');
*/
/* CDS Patch. 12. BOF */
  $info_box_contents[] = array('text' => '<a href="' . tep_href_link(FILENAME_ARTICLES, '', 'NONSSL') . '"><font color="' . $font_color . '">' . BOX_HEADING_ARTICLES . '</font></a>');
/* CDS Patch. 12. EOF */
  new infoBoxHeading($info_box_contents, false, false);

  $topics_string = '';
  $tree = array();

  $topics_query = tep_db_query("select t.topics_id, td.topics_name, t.parent_id from " . TABLE_TOPICS . " t, " . TABLE_TOPICS_DESCRIPTION . " td where t.parent_id = '0' and t.topics_id = td.topics_id and td.language_id = '" . (int)$languages_id . "' order by sort_order, td.topics_name");
  while ($topics = tep_db_fetch_array($topics_query))  {
    $tree[$topics['topics_id']] = array('name' => $topics['topics_name'],
                                        'parent' => $topics['parent_id'],
                                        'level' => 0,
                                        'path' => $topics['topics_id'],
                                        'next_id' => false);

    if (isset($parent_id)) {
      $tree[$parent_id]['next_id'] = $topics['topics_id'];
    }

    $parent_id = $topics['topics_id'];

    if (!isset($first_topic_element)) {
      $first_topic_element = $topics['topics_id'];
    }
  }

  //------------------------
  if (tep_not_null($tPath)) {
    $new_path = '';
    reset($tPath_array);
    while (list($key, $value) = each($tPath_array)) {
      unset($parent_id);
      unset($first_id);
      $topics_query = tep_db_query("select t.topics_id, td.topics_name, t.parent_id from " . TABLE_TOPICS . " t, " . TABLE_TOPICS_DESCRIPTION . " td where t.parent_id = '" . (int)$value . "' and t.topics_id = td.topics_id and td.language_id = '" . (int)$languages_id . "' order by sort_order, td.topics_name");
      if (tep_db_num_rows($topics_query)) {
        $new_path .= $value;
        while ($row = tep_db_fetch_array($topics_query)) {
          $tree[$row['topics_id']] = array('name' => $row['topics_name'],
                                           'parent' => $row['parent_id'],
                                           'level' => $key+1,
                                           'path' => $new_path . '_' . $row['topics_id'],
                                           'next_id' => false);

          if (isset($parent_id)) {
            $tree[$parent_id]['next_id'] = $row['topics_id'];
          }

          $parent_id = $row['topics_id'];

          if (!isset($first_id)) {
            $first_id = $row['topics_id'];
          }

          $last_id = $row['topics_id'];
        }
        $tree[$last_id]['next_id'] = $tree[$value]['next_id'];
        $tree[$value]['next_id'] = $first_id;
        $new_path .= '_';
      } else {
        break;
      }
    }
  }
  tep_show_topic($first_topic_element);

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


  $info_box_contents = array();
  $info_box_contents[] = array('text' => $new_articles_string . $all_articles_string . $topics_string);

new infoBox($info_box_contents);

?>


            </td>
          </tr>
<!-- information_eof //-->
