<?php

// --------------------------------------------------------------------------------------------------------------------------------------------
// create column list
$define_list = array(
	'FAQDESK_DATE_AVAILABLE' => FAQDESK_DATE_AVAILABLE,
	'FAQDESK_LONG_ANSWER' => FAQDESK_LONG_ANSWER,
	'FAQDESK_SHORT_ANSWER' => FAQDESK_SHORT_ANSWER,
	'FAQDESK_QUESTION' => FAQDESK_QUESTION,
);

asort($define_list);

$column_list = array();
reset($define_list);
while (list($column, $value) = each($define_list)) {
	if ($value) $column_list[] = $column;
}

$select_column_list = '';

$size = sizeof($column_list);
for ($col=0; $col<$size; $col++) {
	if ( ($column_list[$col] == 'FAQDESK_DATE_AVAILABLE') || ($column_list[$col] == 'FAQDESK_QUESTION') ) {
		continue;
	}

	if ($select_column_list != '') {
		$select_column_list .= ', ';
	}

	switch ($column_list[$col]) {
	case 'FAQDESK_DATE_AVAILABLE': $select_column_list .= 'p.faqdesk_date_added';
		break;
	case 'FAQDESK_LONG_ANSWER': $select_column_list .= 'pd.faqdesk_answer_long';
		break;
	case 'FAQDESK_SHORT_ANSWER': $select_column_list .= 'pd.faqdesk_answer_short';
		break;
	case 'FAQDESK_QUESTION': $select_column_list .= 'pd.faqdesk_question';
		break;
	}
}

if ($select_column_list != '') {
	$select_column_list .= ', ';
}

// We show them all
$listing_sql = "select " . $select_column_list . " p.faqdesk_id, p.faqdesk_date_added, pd.faqdesk_question, 
pd.faqdesk_answer_long, pd.faqdesk_answer_short from " 
. TABLE_FAQDESK_DESCRIPTION . " pd, " 
. TABLE_FAQDESK . " p, " 
. TABLE_FAQDESK_TO_CATEGORIES . " p2c 
where p.faqdesk_status = '1' and p.faqdesk_id = p2c.faqdesk_id and pd.faqdesk_id = p2c.faqdesk_id 
and pd.language_id = '" . $languages_id . "' and p2c.categories_id =  '" . $_GET['faqPath'] . "'
";

$cl_size = sizeof($column_list);
if ( (!$_GET['sort']) || (!preg_match('/[1-8][ad]/', $_GET['sort'])) || (substr($_GET['sort'],0,1) > $cl_size) ) {
	for ($col=0; $col<$cl_size; $col++) {
		if ($column_list[$col] == 'FAQDESK_QUESTION') {
			$_GET['sort'] = $col+1 . 'a';
			$listing_sql .= " order by pd.faqdesk_question";
			break;
		}
	}
} else {
	$sort_col = substr($_GET['sort'], 0, 1);
	$sort_order = substr($_GET['sort'], 1);
	$listing_sql .= ' order by ';
	switch ($column_list[$sort_col-1]) {
	case 'FAQDESK_DATE_AVAILABLE': $listing_sql .= "p.faqdesk_date_added " . ($sort_order == 'd' ? "desc" : "") . ", pd.faqdesk_question";
		break;
	case 'FAQDESK_QUESTION': $listing_sql .= "pd.faqdesk_question " . ($sort_order == 'd' ? "desc" : "");
		break;
	case 'FAQDESK_SHORT_ANSWER': $listing_sql .= "pd.faqdesk_answer_short " . ($sort_order == 'd' ? "desc" : "") . ", pd.faqdesk_question";
		break;
	case 'FAQDESK_LONG_ANSWER': $listing_sql .= "pd.faqdesk_answer_long " . ($sort_order == 'd' ? "desc" : "") . ", pd.faqdesk_question";
		break;
	}
}

?>

<?php include(DIR_WS_MODULES.FILENAME_FAQDESK_LISTING); ?>

<?php
/*

	osCommerce, Open Source E-Commerce Solutions ---- http://www.oscommerce.com
	Copyright (c) 2002 osCommerce
	Released under the GNU General Public License

	IMPORTANT NOTE:

	This script is not part of the official osC distribution but an add-on contributed to the osC community.
	Please read the NOTE and INSTALL documents that are provided with this file for further information and installation notes.

	script name:	FaqDesk
	version:		1.2.5
	date:			2003-09-01
	author:			Carsten aka moyashi
	web site:		www..com

*/
?>
