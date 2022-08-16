
<table border="0" width="100%" cellspacing="0" cellpadding="<?php echo CELLPADDING_SUB;?>">
<?php 
// Set number of columns in listing
define ('NR_COLUMNS', 2);?>
<?php
// BOF: Lango Added for template MOD
if (SHOW_HEADING_TITLE_ORIGINAL == 'yes') {
$header_text = '&nbsp;'
//EOF: Lango Added for template MOD
?>
      <tr> 
        <td width="100%"><table class="table-padding-0"> 
          <tr>
            <td class="pageHeading"><?php echo HEADING_TITLE ?></td>
            <td align="right"><?php echo tep_image(DIR_WS_TEMPLATES . TEMPLATE_NAME . '/images/content/reviews.gif', HEADING_TITLE, HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?></td>
          </tr>
<tr>
<form name="quick_find" method="get" action="<?php echo tep_href_link(FILENAME_ARTICLE_SEARCH, '', 'NONSSL', false)?>">
<td colspan="2" class="main">
<?php
  $hide = tep_hide_session_id();
?>
<?php echo $hide . TEXT_ARTICLES_SEARCH ?> 
<input type="text" name="akeywords" size="20" maxlength="30" value="<?php echo htmlspecialchars(StripSlashes(@$_GET["akeywords"])) ?>" style="width: '<?php echo (BOX_WIDTH-30) ?>'px">
<input type="hidden" name="description" value="1">
&nbsp;
<?php echo tep_template_image_submit('button_quick_find.gif', BOX_HEADING_SEARCH) ?>
</td></form>
</tr>
        </table></td> 
      </tr>
<?php
// BOF: Lango Added for template MOD
}else{
$header_text = HEADING_TITLE;
}
// EOF: Lango Added for template MOD
?>

<?php
// BOF: Lango Added for template MOD
if (MAIN_TABLE_BORDER == 'yes'){
table_image_border_top(false, false, $header_text);
}
// EOF: Lango Added for template MOD
?>

<!-- body_text //-->
<tr>
    <td width="100%" valign="top"><table class="table-padding-0">
<?php
  $articles_new_array = array();
  $articles_new_query_raw = "select a.articles_id, a.articles_date_added, ad.articles_name, ad.articles_head_desc_tag, au.authors_id, au.authors_name, td.topics_id, td.topics_name from " . TABLE_ARTICLES . " a left join " . TABLE_AUTHORS . " au on a.authors_id = au.authors_id, " . TABLE_ARTICLES_TO_TOPICS . " a2t left join " . TABLE_TOPICS_DESCRIPTION . " td on a2t.topics_id = td.topics_id, " . TABLE_ARTICLES_DESCRIPTION . " ad where (a.articles_date_available IS NULL or to_days(a.articles_date_available) <= to_days(now())) and a.articles_id = a2t.articles_id and a.articles_status = '1' and a.articles_id = ad.articles_id and ad.language_id = '" . (int)$languages_id . "' and td.language_id = '" . (int)$languages_id . "' and a.articles_date_added > SUBDATE(now( ), INTERVAL '" . NEW_ARTICLES_DAYS_DISPLAY . "' DAY) order by a.articles_date_added desc, ad.articles_name";

  $articles_new_split = new splitPageResults($articles_new_query_raw, MAX_NEW_ARTICLES_PER_PAGE);
  if (($articles_new_split->number_of_rows > 0) && ((ARTICLE_PREV_NEXT_BAR_LOCATION == 'top') || (ARTICLE_PREV_NEXT_BAR_LOCATION == 'both'))) {
?>
      <tr>
        <td><table class="table-padding-2">
          <tr>
            <td class="smallText"><?php echo $articles_new_split->display_count(TEXT_DISPLAY_NUMBER_OF_ARTICLES_NEW); ?></td>
            <td align="right" class="smallText"><?php echo TEXT_RESULT_PAGE . ' ' . $articles_new_split->display_links(MAX_DISPLAY_PAGE_LINKS, tep_get_all_get_params(array('page', 'info', 'x', 'y'))); ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
<?php
  }
?>
      <tr>
        <td><table class="table-padding-0">
<?php
  if ($articles_new_split->number_of_rows > 0) {
    $articles_new_query = tep_db_query($articles_new_split->sql_query);
?>
      <tr>
        <td class="main"><?php echo sprintf(TEXT_NEW_ARTICLES, NEW_ARTICLES_DAYS_DISPLAY); ?></td>
      </tr>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
<?php
    while ($articles_new = tep_db_fetch_array($articles_new_query)) {
?>
          <tr>
            <td valign="top" class="main" width="75%">
<?php
  echo '<a href="' . tep_href_link(FILENAME_ARTICLE_INFO, 'articles_id=' . $articles_new['articles_id']) . '"><b>' . $articles_new['articles_name'] . '</b></a> ';
  if (DISPLAY_AUTHOR_ARTICLE_LISTING == 'true' && tep_not_null($articles_new['authors_name'])) {
   echo TEXT_BY . ' ' . '<a href="' . tep_href_link(FILENAME_ARTICLES, 'authors_id=' . $articles_new['authors_id']) . '"> ' . $articles_new['authors_name'] . '</a>';
  }
?>
            </td>
<?php
      if (DISPLAY_TOPIC_ARTICLE_LISTING == 'true' && tep_not_null($articles_new['topics_name'])) {
?>
            <td valign="top" class="main" width="25%" nowrap><?php echo TEXT_TOPIC . '&nbsp;<a href="' . tep_href_link(FILENAME_ARTICLES, 'tPath=' . $articles_new['topics_id']) . '">' . $articles_new['topics_name'] . '</a>'; ?></td>
<?php
      }
?>
          </tr>
<?php
      if (DISPLAY_ABSTRACT_ARTICLE_LISTING == 'true') {
?>
          <tr>
            <td class="main" style="padding-left:15px"><?php echo clean_html_comments(utf8_substr($articles_new['articles_head_desc_tag'],0, MAX_ARTICLE_ABSTRACT_LENGTH)) . ((utf8_strlen($articles_new['articles_head_desc_tag']) >= MAX_ARTICLE_ABSTRACT_LENGTH) ? '...' : ''); ?></td>
          </tr>
<?php
      }
      if (DISPLAY_DATE_ADDED_ARTICLE_LISTING == 'true') {
?>
          <tr>
            <td class="smalltext" style="padding-left:15px"><?php echo TEXT_DATE_ADDED . ' ' . tep_date_long($articles_new['articles_date_added']); ?></td>
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
            <td class="main"><?php echo sprintf(TEXT_NO_NEW_ARTICLES, NEW_ARTICLES_DAYS_DISPLAY); ?></td>
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
  if (($articles_new_split->number_of_rows > 0) && ((ARTICLE_PREV_NEXT_BAR_LOCATION == 'bottom') || (ARTICLE_PREV_NEXT_BAR_LOCATION == 'both'))) {
?>
      <tr>
        <td><table class="table-padding-2">
          <tr>
            <td class="smallText"><?php echo $articles_new_split->display_count(TEXT_DISPLAY_NUMBER_OF_ARTICLES_NEW); ?></td>
            <td align="right" class="smallText"><?php echo TEXT_RESULT_PAGE . ' ' . $articles_new_split->display_links(MAX_DISPLAY_PAGE_LINKS, tep_get_all_get_params(array('page', 'info', 'x', 'y'))); ?></td>
          </tr>
        </table></td>
      </tr>
<?php
  }
?>
    </table></td></tr>
<!-- body_text_eof //-->
<?php
// BOF: Lango Added for template MOD
if (MAIN_TABLE_BORDER == 'yes'){
table_image_border_bottom();
}
// EOF: Lango Added for template MOD
?>


   </table>
   
