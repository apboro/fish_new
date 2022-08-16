<?php
?>


<!-- body_text //-->

<table class="table-padding-0">
	<tr>
		<td>
<table class="table-padding-0">
	<tr>
		<td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
		<td class="pageHeading" align="right">
<?php echo tep_image(DIR_WS_TEMPLATES . TEMPLATE_NAME . '/images/content/browse.gif', HEADING_TITLE, HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?>
		</td>
	</tr>
</table>
		</td>
	</tr>
	<tr>
		<td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
	</tr>
	<tr>
		<td>


<?php
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

for ($col=0; $col<sizeof($column_list); $col++) {
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

$select_str = "select " . $select_column_list . " p.faqdesk_id, p.faqdesk_date_added, pd.faqdesk_question, 
pd.faqdesk_answer_long, pd.faqdesk_answer_short ";

$from_str = "from " . TABLE_FAQDESK . " p, " . TABLE_FAQDESK_DESCRIPTION . " pd, " 
. TABLE_FAQDESK_CATEGORIES . " c, " . TABLE_FAQDESK_TO_CATEGORIES . " p2c";

$where_str = " where p.faqdesk_status = '1' and p.faqdesk_id = pd.faqdesk_id and pd.language_id = '" . $languages_id . "' and 
p.faqdesk_id = p2c.faqdesk_id and p2c.categories_id = c.categories_id ";

if ($_GET['categories_id']) {
	if ($_GET['inc_subcat'] == "1") {
		$subcategories_array = array();
		faqdesk_get_subcategories($subcategories_array, $_GET['categories_id']);
		$where_str .= " and p2c.faqdesk_id = p.faqdesk_id and p2c.faqdesk_id = pd.faqdesk_id and (p2c.categories_id = '" 
		. $_GET['categories_id'] . "'";

		for ($i=0; $i<sizeof($subcategories_array); $i++ ) {
			$where_str .= " or p2c.categories_id = '" . $subcategories_array[$i] . "'";
		}
		$where_str .= ")";
	} else {
		$where_str .= " and p2c.faqdesk_id = p.faqdesk_id and p2c.faqdesk_id = pd.faqdesk_id and pd.language_id = '" 
		. $languages_id . "' and p2c.categories_id = '" . $_GET['categories_id'] . "'";
	}
}

if ($_GET['keywords']) {
	if (tep_parse_search_string( StripSlashes($_GET['keywords']), $search_keywords)) {
		$where_str .= " and (";
		for ($i=0; $i<sizeof($search_keywords); $i++ ) {
			switch ($search_keywords[$i]) {
				case '(':
				case ')':
				case 'and':
				case 'or':
				$where_str .= " " . $search_keywords[$i] . " ";
			break;
			default:
$where_str .= "
(pd.faqdesk_question like '%" . AddSlashes($search_keywords[$i]) . "%' or 
pd.faqdesk_answer_short like '%" . AddSlashes($search_keywords[$i]) . "%' or 
pd.faqdesk_answer_long like '%" . AddSlashes($search_keywords[$i]) . "%'";
				if ($_GET['search_in_description']) $where_str .= " 
				or pd.faqdesk_answer_long like '%" . AddSlashes($search_keywords[$i]) . "%'";
				$where_str .= ')';
			break;
			}
		}
		$where_str .= " )";
	}
}

if ($_GET['dfrom'] && $_GET['dfrom'] != DOB_FORMAT_STRING) {
	$where_str .= " and p.faqdesk_date_added >= '" . tep_date_raw($dfrom_to_check) . "'";
}

if ($_GET['dto'] && $_GET['dto'] != DOB_FORMAT_STRING) {
	$where_str .= " and p.faqdesk_date_added <= '" . tep_date_raw($dto_to_check) . "'";
}


if ( (!$_GET['sort']) || (!preg_match('/[1-8][ad]/', $_GET['sort'])) || (substr($_GET['sort'],0,1) > sizeof($column_list)) ) {
	for ($col=0; $col<sizeof($column_list); $col++) {
		if ($column_list[$col] == 'FAQDESK_QUESTION') {
			$_GET['sort'] = $col+1 . 'a';
			$order_str .= " order by pd.faqdesk_question";
			break;
		}
	}
} else {
	$sort_col = substr($_GET['sort'], 0, 1);
	$sort_order = substr($_GET['sort'], 1);
	$order_str .= ' order by ';
	switch ($column_list[$sort_col-1]) {
	case 'FAQDESK_DATE_AVAILABLE': $order_str .= "p.faqdesk_date_added " . ($sort_order == 'd' ? "desc" : "") . ", pd.faqdesk_question";
		break;
	case 'FAQDESK_QUESTION': $order_str .= "pd.faqdesk_question " . ($sort_order == 'd' ? "desc" : "");
		break;
	case 'FAQDESK_SHORT_ANSWER': $order_str .= "pd.faqdesk_answer_short " . ($sort_order == 'd' ? "desc" : "") . ", pd.faqdesk_question";
		break;
	case 'FAQDESK_LONG_ANSWER': $order_str .= "pd.faqdesk_answer_long " . ($sort_order == 'd' ? "desc" : "") . ", pd.faqdesk_question";
		break;
	}
}

$listing_sql = $select_str . $from_str . $where_str . $order_str;

require(DIR_WS_MODULES . FILENAME_FAQDESK_LISTING);
?>


		</td>
	</tr>
	<tr>
		<td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
	</tr>
	<tr>
		<td class="main">
<?php
//FILENAME_FAQDESK_SEARCH
echo '<a href="' . tep_href_link(FILENAME_FAQDESK_INDEX, tep_get_all_get_params(array('sort', 'page', 'x', 'y')), 'NONSSL', true, false) 
. '">' . tep_template_image_button('button_back.gif', IMAGE_BUTTON_BACK) . '</a>';
?>
		</td>
	</tr>
</table>

<!-- body_text_eof //-->

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