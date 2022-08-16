<?php
/*
autocreated script
*/
  require('includes/application_top.php');
?>
    <?php 
error_reporting(0);

define('SITEMAP_FILE',DIR_FS_CATALOG.'/temp/sitemap_html.html');
define('PAGE_SIZE',200);
define('CACHE_TIME',60*60*24);//---cache time = 1 day
?>
<?php
if (file_exists(SITEMAP_FILE)){
    $mtime=filectime(SITEMAP_FILE);
    if (($mtime+CACHE_TIME)<time()){
	@unlink(SITEMAP_FILE);
	}
    }


if (!file_exists(SITEMAP_FILE)){
    $show_full_tree = true;	
    $idname_for_menu = 'sf-menu';  // see superfish.css
    $classname_for_selected = 'selected';  // see superfish.css
    $classname_for_parent = 'current_parent';  //see superfish.css
    $GLOBALS['this_level'] = 0;
    $output = tep_make_catsf_ullist();
    $output.= CreatePagesTree();
    $output.= CreateInfoTree();
    $output.= CreateNewsTree();

file_put_contents(SITEMAP_FILE,$output);
}

//----END OF HTML CODE



?>
<?php
$content = 'sitemap_html';

  

?>

<?php
  require(DIR_WS_INCLUDES . 'template_top.php');
?>
<div class="contentContainer">
    <div class="contentText">
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
</div>
</div>
<?php
  require(DIR_WS_INCLUDES . 'template_bottom.php');
  require(DIR_WS_INCLUDES . 'application_bottom.php');
?>
