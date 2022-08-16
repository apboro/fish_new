<?php 
if (file_exists(SITEMAP_FILE)){
require(DIR_WS_CLASSES.'split_page_file.php');
$SPF=new SplitPageFile(SITEMAP_FILE,PAGE_SIZE);
echo $SPF->display_links(10, tep_get_all_get_params(array('page', 'info', 'x', 'y')));
//echo $SPF->display_count(PAGE_SIZE);
echo $SPF->display_lines(PAGE_SIZE);
echo $SPF->display_links(10, tep_get_all_get_params(array('page', 'info', 'x', 'y')));
}
?>