<?php
/*
autocreated script
*/
  require('includes/application_top.php');
?>
    <?php
/*
  $Id: allprods.php,v 1.7 2002/12/02

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2002 osCommerce
  Copyright (c) 2002 HMCservices

  Released under the GNU General Public License
*/


  include(DIR_WS_LANGUAGES . $language . '/' . FILENAME_ARTICLES);

// Set number of columns in listing
define ('NR_COLUMNS', 1);
//
  $breadcrumb->add(HEADING_TITLE, tep_href_link(FILENAME_ARTICLES, '', 'NONSSL'));

  $content = CONTENT_ARTICLES;




?>

<?php
  require(DIR_WS_INCLUDES . 'template_top.php');
?>
<div class="contentContainer">
    <div class="contentText">
<?php

  $topic_depth = 'top';

  if (isset($tPath) && tep_not_null($tPath)) {
    $topics_articles_query = tep_db_query("select count(*) as total from " . TABLE_ARTICLES_TO_TOPICS . " where topics_id = '" . (int)$current_topic_id . "'");
    $topics_articles = tep_db_fetch_array($topics_articles_query);
    if ($topics_articles['total'] > 0) {
      $topic_depth = 'articles'; // display articles
    } else {
      $topic_parent_query = tep_db_query("select count(*) as total from " . TABLE_TOPICS . " where parent_id = '" . (int)$current_topic_id . "'");
      $topic_parent = tep_db_fetch_array($topic_parent_query);
      if ($topic_parent['total'] > 0) {
        $topic_depth = 'nested'; // navigate through the topics
      } else {
        $topic_depth = 'articles'; // topic has no articles, but display the 'no articles' message
      }
    }
  }

  if ($topic_depth == 'top' && !isset($_GET['authors_id'])) {
    $breadcrumb->add(NAVBAR_TITLE_DEFAULT, tep_href_link(FILENAME_ARTICLES));
  }

  include(DIR_WS_LANGUAGES . $language . '/' . FILENAME_ARTICLES);
?>
<table border="0" width="100%" cellspacing="0" cellpadding="<?php echo CELLPADDING_SUB;?>">
<?php
// Set number of columns in listing
define ('NR_COLUMNS', 2);?>
<?php
if (SHOW_HEADING_TITLE_ORIGINAL == 'yes') {
$header_text = '&nbsp;'
?>
      <tr>
        <td width="100%"><table class="table-padding-0">
<tr>
<form name="quick_find" method="get" action="<?php echo tep_href_link(FILENAME_ARTICLE_SEARCH, '', 'NONSSL', false)?>">
<td colspan="2" class="main">
<?php
  $hide = tep_hide_session_id();
?>
<?php echo $hide . TEXT_ARTICLES_SEARCH ?>
<input type="hidden" name="description" value="1">
<input type="text" name="akeywords" size="20" maxlength="30" value="<?php echo htmlspecialchars(StripSlashes(@$_GET["akeywords"])) ?>" style="width: '<?php echo (BOX_WIDTH-30) ?>'px">
&nbsp;
<?php echo tep_template_image_submit('button_quick_find.gif', BOX_HEADING_SEARCH) ?>
</td></form>
</tr>
        </table></td>
      </tr>
<?php
}else{
$header_text = HEADING_TITLE;
}
?>
<?php
if (MAIN_TABLE_BORDER == 'yes'){
table_image_border_top(false, false, $header_text);
}
?>
<!-- body_text //-->
<?php
  if ($topic_depth == 'nested') {
    $topic_query = tep_db_query("select td.topics_name, td.topics_heading_title, td.topics_description from " . TABLE_TOPICS . " t, " . TABLE_TOPICS_DESCRIPTION . " td where t.topics_id = '" . (int)$current_topic_id . "' and td.topics_id = '" . (int)$current_topic_id . "' and td.language_id = '" . (int)$languages_id . "'");
    $topic = tep_db_fetch_array($topic_query);
?>
   <tr>
    <td width="100%" valign="top"><table class="table-padding-0">
      <tr>
        <td><table class="table-padding-2">
          <tr>
            <td><table class="table-padding-2">
              <tr><td>
<?php
    if (isset($tPath) && strpos('_', $tPath)) {
// check to see if there are deeper topics within the current topic
      $topic_links = array_reverse($tPath_array);
      for($i=0, $n=sizeof($topic_links); $i<$n; $i++) {
        $topics_query = tep_db_query("select count(*) as total from " . TABLE_TOPICS . " t, " . TABLE_TOPICS_DESCRIPTION . " td where t.parent_id = '" . (int)$topic_links[$i] . "' and t.topics_id = td.topics_id and td.language_id = '" . (int)$languages_id . "'");
        $topics = tep_db_fetch_array($topics_query);
        if ($topics['total'] < 1) {
          // do nothing, go through the loop
        } else {
          $topics_query = tep_db_query("select t.topics_id, td.topics_name, t.parent_id from " . TABLE_TOPICS . " t, " . TABLE_TOPICS_DESCRIPTION . " td where t.parent_id = '" . (int)$topic_links[$i] . "' and t.topics_id = td.topics_id and td.language_id = '" . (int)$languages_id . "' order by sort_order, td.topics_name");
          break; // we've found the deepest topic the customer is in
        }
      }
    } else {
      $topics_query = tep_db_query("select t.topics_id, td.topics_name, t.parent_id from " . TABLE_TOPICS . " t, " . TABLE_TOPICS_DESCRIPTION . " td where t.parent_id = '" . (int)$current_topic_id . "' and t.topics_id = td.topics_id and td.language_id = '" . (int)$languages_id . "' order by sort_order, td.topics_name");
    }

// needed for the new articles module shown below
    $new_articles_topic_id = $current_topic_id;
?>
              </td></tr>
            </table></td>
          </tr>
          <tr>
            <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
          </tr>
        </table></td>
      </tr>
    </table></td></tr>
<?php
  } elseif ($topic_depth == 'articles' || isset($_GET['authors_id'])) {

/* bof catdesc for bts1a */
// Get the topic name and description from the database
    $topic_query = tep_db_query("select td.topics_name, td.topics_heading_title, td.topics_description from " . TABLE_TOPICS . " t, " . TABLE_TOPICS_DESCRIPTION . " td where t.topics_id = '" . (int)$current_topic_id . "' and td.topics_id = '" . (int)$current_topic_id . "' and td.language_id = '" . (int)$languages_id . "'");
    $topic = tep_db_fetch_array($topic_query);
/* bof catdesc for bts1a */

// show the articles of a specified author
    if (isset($_GET['authors_id'])) {
      if (isset($_GET['filter_id']) && tep_not_null($_GET['filter_id'])) {
// We are asked to show only a specific topic
        $listing_sql = "select a.articles_id, a.authors_id, a.articles_date_added, ad.articles_name, ad.articles_head_desc_tag, au.authors_name, td.topics_name, a2t.topics_id from " . TABLE_ARTICLES . " a left join " . TABLE_AUTHORS . " au on a.authors_id = au.authors_id, " . TABLE_ARTICLES_DESCRIPTION . " ad, " . TABLE_ARTICLES_TO_TOPICS . " a2t left join " . TABLE_TOPICS_DESCRIPTION . " td on a2t.topics_id = td.topics_id where (a.articles_date_available IS NULL or to_days(a.articles_date_available) <= to_days(now())) and a.articles_status = '1' and au.authors_id = '" . (int)$_GET['authors_id'] . "' and a.articles_id = a2t.articles_id and ad.articles_id = a2t.articles_id and ad.language_id = '" . (int)$languages_id . "' and td.language_id = '" . (int)$languages_id . "' and a2t.topics_id = '" . (int)$_GET['filter_id'] . "' order by a.articles_date_added desc, ad.articles_name";
      } else {
// We show them all
        $listing_sql = "select a.articles_id, a.authors_id, a.articles_date_added, ad.articles_name, ad.articles_head_desc_tag, au.authors_name, td.topics_name, a2t.topics_id from " . TABLE_ARTICLES . " a left join " . TABLE_AUTHORS . " au on a.authors_id = au.authors_id, " . TABLE_ARTICLES_DESCRIPTION . " ad, " . TABLE_ARTICLES_TO_TOPICS . " a2t left join " . TABLE_TOPICS_DESCRIPTION . " td on a2t.topics_id = td.topics_id where (a.articles_date_available IS NULL or to_days(a.articles_date_available) <= to_days(now())) and a.articles_status = '1' and au.authors_id = '" . (int)$_GET['authors_id'] . "' and a.articles_id = a2t.articles_id and ad.articles_id = a2t.articles_id and ad.language_id = '" . (int)$languages_id . "' and td.language_id = '" . (int)$languages_id . "' order by a.articles_date_added desc, ad.articles_name";
      }
    } else {
// show the articles in a given category
      if (isset($_GET['filter_id']) && tep_not_null($_GET['filter_id'])) {
// We are asked to show only specific catgeory
        $listing_sql = "select a.articles_id, a.authors_id, a.articles_date_added, ad.articles_name, ad.articles_head_desc_tag, au.authors_name, td.topics_name, a2t.topics_id from " . TABLE_ARTICLES . " a left join " . TABLE_AUTHORS . " au on a.authors_id = au.authors_id, " . TABLE_ARTICLES_DESCRIPTION . " ad, " . TABLE_ARTICLES_TO_TOPICS . " a2t left join " . TABLE_TOPICS_DESCRIPTION . " td on a2t.topics_id = td.topics_id where (a.articles_date_available IS NULL or to_days(a.articles_date_available) <= to_days(now())) and a.articles_status = '1' and a.articles_id = a2t.articles_id and ad.articles_id = a2t.articles_id and ad.language_id = '" . (int)$languages_id . "' and td.language_id = '" . (int)$languages_id . "' and a2t.topics_id = '" . (int)$current_topic_id . "' and au.authors_id = '" . (int)$_GET['filter_id'] . "' order by a.articles_date_added desc, ad.articles_name";
      } else {
// We show them all
        $listing_sql = "select a.articles_id, a.authors_id, a.articles_date_added, ad.articles_name, ad.articles_head_desc_tag, au.authors_name, td.topics_name, a2t.topics_id from " . TABLE_ARTICLES . " a left join " . TABLE_AUTHORS . " au on a.authors_id = au.authors_id, " . TABLE_ARTICLES_DESCRIPTION . " ad, " . TABLE_ARTICLES_TO_TOPICS . " a2t left join " . TABLE_TOPICS_DESCRIPTION . " td on a2t.topics_id = td.topics_id where (a.articles_date_available IS NULL or to_days(a.articles_date_available) <= to_days(now())) and a.articles_status = '1' and a.articles_id = a2t.articles_id and ad.articles_id = a2t.articles_id and ad.language_id = '" . (int)$languages_id . "' and td.language_id = '" . (int)$languages_id . "' and a2t.topics_id = '" . (int)$current_topic_id . "' order by a.articles_date_added desc, ad.articles_name";
      }
    }
?>
   <tr>
    <td width="100%" valign="top"><table class="table-padding-0">
      <tr>
        <td><table class="table-padding-0">
<?php
// optional Article List Filter
    if (ARTICLE_LIST_FILTER) {
      if (isset($_GET['authors_id'])) {
        $filterlist_sql = "select distinct t.topics_id as id, td.topics_name as name from " . TABLE_ARTICLES . " a, " . TABLE_ARTICLES_TO_TOPICS . " a2t, " . TABLE_TOPICS . " t, " . TABLE_TOPICS_DESCRIPTION . " td where a.articles_status = '1' and a.articles_id = a2t.articles_id and a2t.topics_id = t.topics_id and a2t.topics_id = td.topics_id and td.language_id = '" . (int)$languages_id . "' and a.authors_id = '" . (int)$_GET['authors_id'] . "' order by td.topics_name";
      } else {
        $filterlist_sql= "select distinct au.authors_id as id, au.authors_name as name from " . TABLE_ARTICLES . " a, " . TABLE_ARTICLES_TO_TOPICS . " a2t, " . TABLE_AUTHORS . " au where a.articles_status = '1' and a.authors_id = au.authors_id and a.articles_id = a2t.articles_id and a2t.topics_id = '" . (int)$current_topic_id . "' order by au.authors_name";
      }
      $filterlist_query = tep_db_query($filterlist_sql);
      if (tep_db_num_rows($filterlist_query) > 1) {
        echo '<tr><td align="right" class="main">' . tep_draw_form('filter', FILENAME_ARTICLES, 'get') . TEXT_SHOW . '&nbsp;';
        if (isset($_GET['authors_id'])) {
          echo tep_draw_hidden_field('authors_id', $_GET['authors_id']);
          $options = array(array('id' => '', 'text' => TEXT_ALL_TOPICS));
        } else {
          echo tep_draw_hidden_field('tPath', $tPath);
          $options = array(array('id' => '', 'text' => TEXT_ALL_AUTHORS));
        }
        echo tep_draw_hidden_field('sort', $_GET['sort']);
        while ($filterlist = tep_db_fetch_array($filterlist_query)) {
          $options[] = array('id' => $filterlist['id'], 'text' => $filterlist['name']);
        }
        echo tep_draw_pull_down_menu('filter_id', $options, (isset($_GET['filter_id']) ? $_GET['filter_id'] : ''), 'onchange="this.form.submit()"');
        echo '</form></td></tr>' . "\n";
      }
    }
?>
         <?php if ( tep_not_null($topic['topics_description']) ) { ?>
         <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
       </tr>
       <tr>
          <td align="left" colspan="2" class="main"><?php echo $topic['topics_description']; ?></td>
       </tr>
       <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
       </tr>
          <?php } ?>
         <?php if (tep_not_null($authors_description)) { ?>
          <tr>
            <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
          </tr>
          <tr>
            <td class="main" colspan="2" valign="top"><?php echo $authors_description; ?></td>
          </tr>
          <?php } ?>
          <?php if (tep_not_null($authors_url)) { ?>
          <tr>
            <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
          <tr>
            <td class="main" colspan="2" valign="top"><?php echo sprintf(TEXT_MORE_INFORMATION, $authors_url); ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
          <?php } ?>
        </table></td>
      </tr>
<?php include(DIR_WS_MODULES . FILENAME_ARTICLE_LISTING); ?>
    </table></td></tr>
<?php
  } else { // default page
?>
    <tr><td width="100%" valign="top"><table class="table-padding-0">
      <tr>
        <td><?php include(DIR_WS_MODULES . FILENAME_ARTICLES_UPCOMING); ?></td>
      </tr>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
      <tr>
        <td class="main"><?php echo '<b>' . TEXT_CURRENT_ARTICLES . '</b>'; ?></td>
      </tr>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
<?php
  $articles_all_array = array();
  $articles_all_query_raw = "select a.articles_id, a.articles_date_added, a.articles_date_available, ad.articles_name, ad.articles_head_desc_tag, ad.articles_viewed, au.authors_id, au.authors_name, td.topics_id, td.topics_name from " . TABLE_ARTICLES . " a left join " . TABLE_AUTHORS . " au on a.authors_id = au.authors_id, " . TABLE_ARTICLES_TO_TOPICS . " a2t left join " . TABLE_TOPICS_DESCRIPTION . " td on a2t.topics_id = td.topics_id, " . TABLE_ARTICLES_DESCRIPTION . " ad where (a.articles_date_available IS NULL or to_days(a.articles_date_available) <= to_days(now())) and a.articles_id = a2t.articles_id and a.articles_status = '1' and a.articles_id = ad.articles_id and ad.language_id = '" . (int)$languages_id . "' and td.language_id = '" . (int)$languages_id . "' ORDER BY IF (`a`.`articles_date_available`,`a`.`articles_date_available`, `a`.`articles_date_added`) DESC";

  $articles_all_split = new splitPageResults($articles_all_query_raw, MAX_ARTICLES_PER_PAGE);
  if (($articles_all_split->number_of_rows > 0) && ((ARTICLE_PREV_NEXT_BAR_LOCATION == 'top') || (ARTICLE_PREV_NEXT_BAR_LOCATION == 'both'))) {
?>
      <tr>
        <td><table class="table-padding-2">
          <tr>
            <td class="smallText"><?php echo $articles_all_split->display_count(TEXT_DISPLAY_NUMBER_OF_ARTICLES); ?></td>
            <td align="right" class="smallText"><?php echo TEXT_RESULT_PAGE . ' ' . $articles_all_split->display_links(MAX_DISPLAY_PAGE_LINKS, tep_get_all_get_params(array('page', 'info', 'x', 'y'))); ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr></table></td></tr>
<?php
  }
?>
      <tr>
        <td><table class="table-padding-0">
<?php
  if ($articles_all_split->number_of_rows > 0) {
    $articles_all_query = tep_db_query($articles_all_split->sql_query);
?>
      <tr>
        <td class="main"><?php echo TEXT_ALL_ARTICLES; ?></td>
      </tr>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
<?php
    while ($articles_all = tep_db_fetch_array($articles_all_query)) {
?>
          <tr>
            <td valign="top" class="main" width="75%">
<?php
  echo '<a href="' . tep_href_link(FILENAME_ARTICLE_INFO, 'articles_id=' . $articles_all['articles_id']) . '"><b>' . $articles_all['articles_name'] . '</b></a> ';
  if (DISPLAY_AUTHOR_ARTICLE_LISTING == 'true' && tep_not_null($articles_all['authors_name'])) {
   echo TEXT_BY . ' ' . '<a href="' . tep_href_link(FILENAME_ARTICLES, 'authors_id=' . $articles_all['authors_id']) . '"> ' . $articles_all['authors_name'] . '</a>';
  }
?>
            </td>
<?php
      if (DISPLAY_TOPIC_ARTICLE_LISTING == 'true' && tep_not_null($articles_all['topics_name'])) {
?>
            <td valign="top" class="main" width="25%" nowrap><?php echo TEXT_TOPIC . '&nbsp;<a href="' . tep_href_link(FILENAME_ARTICLES, 'tPath=' . $articles_all['topics_id']) . '">' . $articles_all['topics_name'] . '</a>'; ?></td>
<?php
      }
?>
          </tr>
<?php
      if (DISPLAY_ABSTRACT_ARTICLE_LISTING == 'true') {
?>
          <tr>
            <td class="main" style="padding-left:15px"><?php echo clean_html_comments(utf8_substr($articles_all['articles_head_desc_tag'],0, MAX_ARTICLE_ABSTRACT_LENGTH)) . ((utf8_strlen($articles_all['articles_head_desc_tag']) >= MAX_ARTICLE_ABSTRACT_LENGTH) ? '...' : ''); ?></td>
          </tr>
<?php
      }
      if (DISPLAY_DATE_ADDED_ARTICLE_LISTING == 'true') {
?>
          <tr>
            <td class="smalltext" style="padding-left:15px"><?php echo TEXT_DATE_ADDED . ' ' . tep_date_long($articles_all['articles_date_added']); ?></td>
          </tr>
<?php
      }
      if (DISPLAY_ABSTRACT_ARTICLE_LISTING == 'true' || DISPLAY_DATE_ADDED_ARTICLE_LISTING) {
?>
          <tr>
            <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
          </tr>
<?php
 }
    } // End of listing loop
  } else {
?>
          <tr>
            <td class="main"><?php echo TEXT_NO_ARTICLES; ?></td>
          </tr>
          <tr>
            <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
          </tr>
<?php
  }
?>
          <tr>
            <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
          </tr>
        </table></td>
      </tr>
<?php
  if (($articles_all_split->number_of_rows > 0) && ((ARTICLE_PREV_NEXT_BAR_LOCATION == 'bottom') || (ARTICLE_PREV_NEXT_BAR_LOCATION == 'both'))) {
?>
      <tr>
        <td><table class="table-padding-2">
          <tr>
            <td class="smallText"><?php echo $articles_all_split->display_count(TEXT_DISPLAY_NUMBER_OF_ARTICLES); ?></td>
            <td align="right" class="smallText"><?php echo TEXT_RESULT_PAGE . ' ' . $articles_all_split->display_links(MAX_DISPLAY_PAGE_LINKS, tep_get_all_get_params(array('page', 'info', 'x', 'y'))); ?></td>
          </tr>
        </table></td>
      </tr>
<?php
  }
?>

<?php } ?>
<!-- body_text_eof //-->
<?php
if (MAIN_TABLE_BORDER == 'yes'){
table_image_border_bottom();
}
?>
</table>


</div>
</div>
<?php
  require(DIR_WS_INCLUDES . 'template_bottom.php');
  require(DIR_WS_INCLUDES . 'application_bottom.php');
?>
