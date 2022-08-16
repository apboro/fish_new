<?php
/*

	osCommerce, Open Source E-Commerce Solutions ---- http://www.oscommerce.com
	Copyright (c) 2002 osCommerce
	Released under the GNU General Public License

	IMPORTANT NOTE:

	This script is not part of the official osC distribution but an add-on contributed to the osC community.
	Please read the NOTE and INSTALL documents that are provided with this file for further information and installation notes.

	script name:	NewsDesk
	version:		1.4.5
	date:			2003-08-31
	author:			Carsten aka moyashi
	web site:		www..com

*/
?>

<?php

// set application wide parameters
// this query set is for NewsDesk


$configuration_query = tep_db_query("select configuration_key as cfgKey, configuration_value as cfgValue from " . TABLE_NEWSDESK_CONFIGURATION . "");
while ($configuration = tep_db_fetch_array($configuration_query)) {
	define($configuration['cfgKey'], $configuration['cfgValue']);
}


if ( DISPLAY_LATEST_NEWS_BOX ) {
?>
<!-- newsdesk //-->
<div class="box">
<b class="top"><b class="b1"></b><b class="b2"></b><b class="b3"></b><b class="b4"></b><b class="b5"></b></b>
<div class="boxHeader">
<h5><?php echo BOX_HEADING_NEWSDESK_LATEST; ?></h5>
</div>
<div class="boxContent">
<?php

// set application wide parameters
// this query set is for NewsDesk


$configuration_query = tep_db_query("select configuration_key as cfgKey, configuration_value as cfgValue from " . TABLE_NEWSDESK_CONFIGURATION . "");
while ($configuration = tep_db_fetch_array($configuration_query)) {
	define($configuration['cfgKey'], $configuration['cfgValue']);
}


$latest_news_var_query = tep_db_query(
'select p.newsdesk_id, pd.language_id, pd.newsdesk_article_name, pd.newsdesk_article_description, pd.newsdesk_article_shorttext, pd.newsdesk_article_url, 
p.newsdesk_image, p.newsdesk_date_added, p.newsdesk_last_modified, 
p.newsdesk_date_available, p.newsdesk_status  from ' . TABLE_NEWSDESK . ' p, ' . TABLE_NEWSDESK_DESCRIPTION . ' 
pd WHERE pd.newsdesk_id = p.newsdesk_id and pd.language_id = "' . $languages_id . '" and newsdesk_status = 1 ORDER BY newsdesk_date_added DESC LIMIT ' . LATEST_DISPLAY_NEWSDESK_NEWS);



if (!tep_db_num_rows($latest_news_var_query)) { // there is no news
//	echo '<!-- ' . TEXT_NO_NEWSDESK_NEWS . ' -->';

} else {

$latest_news_string = '';

$row = 0;
while ($latest_news = tep_db_fetch_array($latest_news_var_query))  {
$latest_news['newsdesk'] = array(
		'name' => $latest_news['newsdesk_article_name'],
		'id' => $latest_news['newsdesk_id'],
		'date' => $latest_news['newsdesk_date_added'],
	);

$latest_news_string .= '<a class="smallText" href="';
$latest_news_string .= tep_href_link(FILENAME_NEWSDESK_INFO, 'newsdesk_id=' . $latest_news['newsdesk_id']);
$latest_news_string .= '">';
$latest_news_string .= $latest_news['newsdesk_article_name'];
$latest_news_string .= '</a>';
$latest_news_string .= '<br>';

	$row++;
}

echo $latest_news_string;

}
//}
?>

<!-- newsdesk_eof //-->
</div>
<b class="bottom"><b class="b5b"></b><b class="b4b"></b><b class="b3b"></b><b class="b2b"></b><b class="b1b"></b></b>
</div>

<?php
}
?>