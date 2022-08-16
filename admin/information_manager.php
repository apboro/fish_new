<?php
/*
  $Id: information.php,v 1.138 2002/11/18 21:38:22 dgw_ Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2002 osCommerce

  Released under the GNU General Public License
*/

  require('includes/application_top.php');

  if ($_GET['action']) {
    switch ($_GET['action']) {
      case 'setflag':
        if ( ($_GET['flag'] == '0') || ($_GET['flag'] == '1') ) {
// BOF Enable - Disable Categories Contribution--------------------------------------
/*
    if ($_GET['pID']) {
            tep_set_page_status($_GET['pID'], $_GET['flag']);
    }
*/
    if ($_GET['pID']) {
            tep_set_page_status($_GET['pID'], $_GET['flag']);
    }
// EOF Enable - Disable Categories Contribution--------------------------------------

          if (USE_CACHE == 'true') {
            tep_reset_cache_block('pages');
          }
        }

        tep_redirect(tep_href_link(FILENAME_INFORMATION));
        break;

      case 'delete_infopage_confirm':
        if ($_POST['information_id']) {
          $information_id = tep_db_prepare_input($_POST['information_id']);

          $information = tep_get_infopage_tree($information_id, '', '0', '', true);
          $pages = array();
          $pages_delete = array();

          for ($i = 0, $n = sizeof($information); $i < $n; $i++) {
            $page_ids_query = tep_db_query("select pages_id from " . TABLE_PAGES . " ");
            while ($page_ids = tep_db_fetch_array($page_ids_query)) {
              $pages[$page_ids['pages_id']];
            }
          }

          reset($pages);
          while (list($key, $value) = each($pages)) {
            $infopage_ids = '';
            for ($i = 0, $n = sizeof($value['information']); $i < $n; $i++) {
              $infopage_ids .= '\'' . $value['information'][$i] . '\', ';
            }
            $infopage_ids = substr($infopage_ids, 0, -2);

            $check_query = tep_db_query("select count(*) as total from " . TABLE_PAGES . " where pages_id = '" . $key . "')");
            $check = tep_db_fetch_array($check_query);
            if ($check['total'] < '1') {
              $pages_delete[$key] = $key;
            }
          }

          // Removing information can be a lengthy process
          tep_set_time_limit(0);
          for ($i = 0, $n = sizeof($information); $i < $n; $i++) {
            tep_remove($information[$i]['id']);
          }

          reset($pages_delete);
          while (list($key) = each($pages_delete)) {
            tep_remove_page($key);
          }
        }

        if (USE_CACHE == 'true') {
          tep_reset_cache_block('pages');
        }

        tep_redirect(tep_href_link(FILENAME_INFORMATION));
        break;
      case 'delete_page_confirm':
        if (isset($_POST['pages_id']) ) {
          $page_id = tep_db_prepare_input($_POST['pages_id']);

          for ($i = 0, $n = sizeof($page_id); $i < $n; $i++) {
            tep_db_query("delete from " . TABLE_PAGES . " where pages_id = '" . (int)$page_id . "' ");
			tep_db_query("delete from " . TABLE_PAGES_DESCRIPTION . " where pages_id = '" . (int)$page_id . "' ");
          }

          $page_id_query = tep_db_query("select count(*) as total from " . TABLE_PAGES . " where pages_id = '" . (int)$page_id . "'");
          $page_id = tep_db_fetch_array($page_id_query);

          if ($page_id['total'] == '0') {
            tep_remove_page($page_id);
          }
        }

        if (USE_CACHE == 'true') {
          tep_reset_cache_block('pages');
        }

        tep_redirect(tep_href_link(FILENAME_INFORMATION));
        break;
      case 'insert_page':
      case 'update_page':
        if ( ($_POST['edit_x']) || ($_POST['edit_y']) ) {
          $_GET['action'] = 'new_page';
        } else {
		//BEGIN remove old image mod
		if ($_POST['delete_image'] == 'yes') {
                unlink(DIR_FS_CATALOG_IMAGES . $_POST['pages_previous_image']);
                if ($_POST['pages_image'] == $_POST['pages_previous_image']) {
                    $_POST['pages_image'] = 'none';
                }
            }
		//END remove old image mod
          $pages_id = tep_db_prepare_input($_GET['pID']);
          $sql_data_array = array('pages_image' => (($_POST['pages_image'] == 'none') ? '' : tep_db_prepare_input($_POST['pages_image'])),
                                  'pages_status' => tep_db_prepare_input($_POST['pages_status']),
                                  'sort_order' => tep_db_prepare_input($_POST['sort_order']));

          if ($_GET['action'] == 'insert_page') {
            $insert_sql_data = array('pages_date_added' => 'now()');
            $sql_data_array = tep_array_merge($sql_data_array, $insert_sql_data);
            tep_db_perform(TABLE_PAGES, $sql_data_array);
            $pages_id = tep_db_insert_id();
          } elseif ($_GET['action'] == 'update_page') {
            $update_sql_data = array('pages_last_modified' => 'now()');
            $sql_data_array = tep_array_merge($sql_data_array, $update_sql_data);
            tep_db_perform(TABLE_PAGES, $sql_data_array, 'update', 'pages_id = \'' . tep_db_input($pages_id) . '\'');
          }

          $languages = tep_get_languages();
          for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
            $language_id = $languages[$i]['id'];

            $sql_data_array = array('pages_name' => tep_db_prepare_input($_POST['pages_name'][$language_id]),
                                    'pages_description' => tep_db_prepare_input($_POST['pages_description'][$language_id]));

            if ($_GET['action'] == 'insert_page') {
              $insert_sql_data = array('pages_id' => $pages_id,
                                       'language_id' => $language_id);
              $sql_data_array = tep_array_merge($sql_data_array, $insert_sql_data);
              tep_db_perform(TABLE_PAGES_DESCRIPTION, $sql_data_array);
            } elseif ($_GET['action'] == 'update_page') {
              tep_db_perform(TABLE_PAGES_DESCRIPTION, $sql_data_array, 'update', 'pages_id = \'' . tep_db_input($pages_id) . '\' and language_id = \'' . $language_id . '\'');
            }
          }

          if (USE_CACHE == 'true') {
            tep_reset_cache_block('pages');
          }

          tep_redirect(tep_href_link(FILENAME_INFORMATION, '&pID=' . $pages_id));
        }
        break;
      case 'copy_to_confirm':
        if ( (tep_not_null($_POST['pages_id'])) ) {
          $pages_id = tep_db_prepare_input($_POST['pages_id']);

          if ($_POST['copy_as'] == 'duplicate') {
            $page_query = tep_db_query("select pages_image from " . TABLE_PAGES . " where pages_id = '" . tep_db_input($pages_id) . "'");
            $page = tep_db_fetch_array($page_query);

            tep_db_query("insert into " . TABLE_PAGES . " (pages_image, pages_date_added, pages_status) values ('" . $page['pages_image'] . "',  now(), '0')");
            $dup_pages_id = tep_db_insert_id();

            $description_query = tep_db_query("select language_id, pages_name, pages_description from " . TABLE_PAGES_DESCRIPTION . " where pages_id = '" . tep_db_input($pages_id) . "'");
            while ($description = tep_db_fetch_array($description_query)) {
              tep_db_query("insert into " . TABLE_PAGES_DESCRIPTION . " (pages_id, language_id, pages_name, pages_description, pages_viewed) values ('" . $dup_pages_id . "', '" . $description['language_id'] . "', '" . addslashes($description['pages_name']) . "', '" . addslashes($description['pages_description']) . "', '0')");
            }

            //tep_db_query("insert into " . TABLE_PAGES . " (pages_id) values ('" . $dup_pages_id . "')");
            $pages_id = $dup_pages_id;
          }

          if (USE_CACHE == 'true') {
            tep_reset_cache_block('pages');
          }
        }

        tep_redirect(tep_href_link(FILENAME_INFORMATION, '&pID=' . $pages_id));
        break;
    }
  }

// check if the catalog image directory exists
  if (is_dir(DIR_FS_CATALOG_IMAGES)) {
    if (!is_writeable(DIR_FS_CATALOG_IMAGES)) $messageStack->add(ERROR_CATALOG_IMAGE_DIRECTORY_NOT_WRITEABLE, 'error');
  } else {
    $messageStack->add(ERROR_CATALOG_IMAGE_DIRECTORY_DOES_NOT_EXIST, 'error');
  }
?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<title><?php echo TITLE; ?></title>
<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
<?php
  if (HTML_AREA_WYSIWYG_DISABLE_INFOPAGES == 'Enable') { 
?>
<script language="javascript" type="text/javascript" src="includes/javascript/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
tinyMCE.init({
	mode : "textareas",
	editor_deselector : "notinymce",
	theme : "advanced",
	language : "<?php echo DEFAULT_LANGUAGE; ?>",
	paste_create_paragraphs : false,
	paste_create_linebreaks : false,
	paste_use_dialog : true,
	convert_urls : false,

	plugins : "safari,spellchecker,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,fullscreen,noneditable,visualchars,nonbreaking,typograf",

	file_browser_callback : "ajaxfilemanager",
	elements : "ajaxfilemanager",

	spellchecker_languages : "+Russian=ru,English=en",
	spellchecker_rpc_url : "<?php echo HTTP_SERVER . DIR_WS_CATALOG; ?>admin/includes/javascript/tiny_mce/plugins/spellchecker/rpc_proxy.php",

	// Theme options
	theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect",
	theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
	theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
	theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,spellchecker,typograf,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,blockquote,pagebreak,|,insertfile,insertimage",
	theme_advanced_toolbar_location : "top",
	theme_advanced_toolbar_align : "left",
	theme_advanced_statusbar_location : "bottom",
	theme_advanced_resizing : true

});

  function ajaxfilemanager(field_name, url, type, win) {
    var ajaxfilemanagerurl = "<?php echo HTTP_SERVER . DIR_WS_CATALOG; ?>admin/includes/javascript/tiny_mce/plugins/ajaxfilemanager/ajaxfilemanager.php?language=' . strtolower(<?php echo DEFAULT_LANGUAGE; ?>) . '&vam=' . trim(<?php echo DIR_WS_ADMIN; ?>, '/') . '&sid=' . session_id() .'";
    switch (type) {
      case "image":
        break;
      case "media":
        break;
      case "flash":
        break;
      case "file":
        break;
      default:
        return false;
    }
    tinyMCE.activeEditor.windowManager.open({
      url: ajaxfilemanagerurl,
      width: 782,
      height: 440,
      inline : "yes",
      close_previous : "no"
    },{
      window : win,
      input : field_name
    });
  }
  
function toggleHTMLEditor(id) {
	if (!tinyMCE.get(id))
		tinyMCE.execCommand("mceAddControl", false, id);
	else
		tinyMCE.execCommand("mceRemoveControl", false, id);
}
</script>
<?php } ?>
<script language="javascript" src="includes/menu.js"></script>

<script language="javascript" src="includes/general.js"></script>
</head>
<body marginwidth="0" marginheight="0" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0" bgcolor="#FFFFFF">
<!-- header //-->
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
<!-- header_eof //-->

<!-- body //-->
<table border="0" width="100%" cellspacing="2" cellpadding="2">
  <tr>
    <td width="<?php echo BOX_WIDTH; ?>" valign="top"><table border="0" width="<?php echo BOX_WIDTH; ?>" cellspacing="1" cellpadding="1" class="columnLeft">
<!-- left_navigation //-->
<?php require(DIR_WS_INCLUDES . 'column_left.php'); ?>
<!-- left_navigation_eof //-->
    </table></td>
<!-- body_text //-->
    <td width="100%" valign="top"><table class="table-padding-2">
<?php
  if ($_GET['action'] == 'new_page') {
    if ( ($_GET['pID']) && (!$_POST) ) {
      $page_query = tep_db_query("select pd.pages_name, pd.pages_description, p.pages_id, p.pages_image, p.pages_date_added, p.pages_last_modified, p.pages_status, p.sort_order from " . TABLE_PAGES . " p, " . TABLE_PAGES_DESCRIPTION . " pd where p.pages_id = '" . $_GET['pID'] . "' and p.pages_id = pd.pages_id and pd.language_id = '" . $languages_id . "'");
      $page = tep_db_fetch_array($page_query);

      $pInfo = new objectInfo($page);
    } elseif ($_POST) {
      $pInfo = new objectInfo($_POST);
      $pages_name = $_POST['pages_name'];
      $pages_description = $_POST['pages_description'];
    } else {
      $pInfo = new objectInfo(array());
    }

    $languages = tep_get_languages();

    switch ($pInfo->pages_status) {
      case '0': $in_status = false; $out_status = true; break;
      case '1':
      default: $in_status = true; $out_status = false;
    }
?>
      <tr>
        <td><table class="table-padding-0">
          <tr>
            <td class="pageHeading"><?php echo sprintf(TEXT_NEW_PAGE, tep_output_generated_infopage_path($current_infopage_id)); ?></td>
            <td class="pageHeading" align="right"><?php echo tep_draw_separator('pixel_trans.gif', HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
      <tr><?php echo tep_draw_form('new_page', FILENAME_INFORMATION, '&pID=' . $_GET['pID'] . '&action=new_page_preview', 'post', 'enctype="multipart/form-data"'); ?>
        <td>

<?php echo tep_draw_hidden_field('pages_date_added', (($pInfo->pages_date_added) ? $pInfo->pages_date_added : date('Y-m-d'))) . tep_image_submit('button_preview.gif', IMAGE_PREVIEW) . '&nbsp;&nbsp;<a href="' . tep_href_link(FILENAME_INFORMATION, '&pID=' . $_GET['pID']) . '">' . tep_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>'; ?>
        
        <?php
  if (ENABLE_TABS == 'true') { 
?>
		<script type="text/javascript">
			$(function(){
				$('#tabs').tabs({ fx: { opacity: 'toggle', duration: 'fast' } });
			});
		</script>
<?php } ?>

        
<div id="tabs">

			<ul>
<?php
    for ($l=0; $l<sizeof($languages); $l++) {
?>
				<li><a href="#language_<?php echo $languages[$l]['id']; ?>"><?php echo $languages[$l]['name']; ?></a></li>
<?php
	}
?>
				<li><a href="#data"><?php echo TEXT_INFOPAGES_DATA; ?></a></li>
			</ul>

<?php
    for ($i=0; $i<sizeof($languages); $i++) {
?>

        <div id="language_<?php echo $languages[$i]['id']; ?>">
          <table border="0">        
          <tr>
            <td class="main"><?php echo TEXT_PAGES_NAME; ?></td>
            <td class="main"><?php echo tep_draw_input_field('pages_name[' . $languages[$i]['id'] . ']', (($pages_name[$languages[$i]['id']]) ? stripslashes($pages_name[$languages[$i]['id']]) : tep_get_pages_name($pInfo->pages_id, $languages[$i]['id']))); ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
          <tr>
            <td class="main" valign="top"><?php echo TEXT_PAGES_DESCRIPTION; ?></td>
            <td><table border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td class="main" valign="top"><?php echo tep_draw_textarea_field('pages_description[' . $languages[$i]['id'] . ']', 'soft', '70', '15', (($pages_description[$languages[$i]['id']]) ? stripslashes($pages_description[$languages[$i]['id']]) : tep_get_pages_description($pInfo->pages_id, $languages[$i]['id'])));
?>

</td>
                
              </tr>
            </table></td>
          </tr>

          </table>
        </div>
          
<?php
    }
?>

        <div id="data">
          <table border="0">
                  
          <tr>
            <td class="main"><?php echo TEXT_PAGES_STATUS; ?></td>
            <td class="main"><?php echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_radio_field('pages_status', '1', $in_status) . '&nbsp;' . TEXT_PAGE_AVAILABLE . '&nbsp;' . tep_draw_radio_field('pages_status', '0', $out_status) . '&nbsp;' . TEXT_PAGE_NOT_AVAILABLE; ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo TEXT_EDIT_SORT_ORDER; ?></td>
            <td class="main"><?php echo tep_draw_input_field('sort_order', $pInfo ->sort_order, "size=3"); ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>

          </table>
        </div>
   
       </div>      
      </form>
<?php
  } elseif ($_GET['action'] == 'new_page_preview') {
    if ($_POST) {
      $pInfo = new objectInfo($_POST);
      $pages_name = $_POST['pages_name'];
      $pages_description = $_POST['pages_description'];

// copy image only if modified
//      $pages_image = tep_get_uploaded_file_info('pages_image');
//      $image_directory = tep_get_local_path_info(DIR_FS_CATALOG_IMAGES);

//      if (is_uploaded_file($pages_image['tmp_name'])) {
//        tep_copy_uploaded_file_info($pages_image, $image_directory);
//        $pages_image_name = $pages_image['name'];
//      } else {
//        $pages_image_name = $_POST['pages_previous_image'];
//      }
    } else {
      $page_query = tep_db_query("select p.pages_id, pd.language_id, pd.pages_name, pd.pages_description, p.pages_image, p.pages_date_added, p.pages_last_modified, p.pages_status from " . TABLE_PAGES . " p, " . TABLE_PAGES_DESCRIPTION . " pd where p.pages_id = pd.pages_id and p.pages_id = '" . $_GET['pID'] . "'");
      $page = tep_db_fetch_array($page_query);

      $pInfo = new objectInfo($page);
      $pages_image_name = $pInfo->pages_image;
    }

    $form_action = ($_GET['pID']) ? 'update_page' : 'insert_page';

    echo tep_draw_form($form_action, FILENAME_INFORMATION, '&pID=' . $_GET['pID'] . '&action=' . $form_action, 'post', 'enctype="multipart/form-data"');

    $languages = tep_get_languages();
    for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
      if ($_GET['read'] == 'only') {
        $pInfo->pages_name = tep_get_pages_name($pInfo->pages_id, $languages[$i]['id']);
        $pInfo->pages_description = tep_get_pages_description($pInfo->pages_id, $languages[$i]['id']);
      } else {
        $pInfo->pages_name = tep_db_prepare_input($pages_name[$languages[$i]['id']]);
        $pInfo->pages_description = tep_db_prepare_input($pages_description[$languages[$i]['id']]);

      }
?>
      <tr>
        <td><table class="table-padding-0">
          <tr>
            <td class="pageHeading"><?php echo tep_image(DIR_WS_CATALOG_LANGUAGES . $languages[$i]['directory'] . '/images/' . $languages[$i]['image'], $languages[$i]['name']) . '&nbsp;' . $pInfo->pages_name; ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
      <tr>
        <td class="main"><?php echo $pInfo->pages_description; ?></td>
      </tr>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
      <tr>
        <td align="center" class="smallText"><?php echo sprintf(TEXT_PAGE_DATE_ADDED, tep_date_long($pInfo->pages_date_added)); ?></td>
      </tr>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
<?php
    }

    if ($_GET['read'] == 'only') {
      if ($_GET['origin']) {
        $pos_params = strpos($_GET['origin'], '?', 0);
        if ($pos_params != false) {
          $back_url = substr($_GET['origin'], 0, $pos_params);
          $back_url_params = substr($_GET['origin'], $pos_params + 1);
        } else {
          $back_url = $_GET['origin'];
          $back_url_params = '';
        }
      } else {
        $back_url = FILENAME_INFORMATION;
        $back_url_params = '&pID=' . $pInfo->pages_id;
      }
?>
      <tr>
        <td align="right"><?php echo '<a href="' . tep_href_link($back_url, $back_url_params, 'NONSSL') . '">' . tep_image_button('button_back.gif', IMAGE_BACK) . '</a>'; ?></td>
      </tr>
<?php
    } else {
?>
      <tr>
        <td align="right" class="smallText">
<?php
/* Re-Post all POST'ed variables */
      reset($_POST);
      while (list($key, $value) = each($_POST)) {
        if (!is_array($_POST[$key])) {
          echo tep_draw_hidden_field($key, htmlspecialchars(stripslashes($value)));
        }
      }
      $languages = tep_get_languages();
      for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
        echo tep_draw_hidden_field('pages_name[' . $languages[$i]['id'] . ']', htmlspecialchars(stripslashes($pages_name[$languages[$i]['id']])));
        echo tep_draw_hidden_field('pages_description[' . $languages[$i]['id'] . ']', htmlspecialchars(stripslashes($pages_description[$languages[$i]['id']])));
      }
      echo tep_draw_hidden_field('pages_image', stripslashes($pages_image_name));

      echo tep_image_submit('button_back.gif', IMAGE_BACK, 'name="edit"') . '&nbsp;&nbsp;';

      if ($_GET['pID']) {
        echo tep_image_submit('button_save.gif', IMAGE_UPDATE);
      } else {
        echo tep_image_submit('button_insert.gif', IMAGE_INSERT);
      }
      echo '&nbsp;&nbsp;<a href="' . tep_href_link(FILENAME_INFORMATION, '&pID=' . $_GET['pID']) . '">' . tep_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>';
?></td>
      </form></tr>
<?php
    }
  } else {
?>
     <tr>
        <td><table class="table-padding-0">
          <tr>
            <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
            <td class="pageHeading" align="right"><?php echo tep_draw_separator('pixel_trans.gif', 1, HEADING_IMAGE_HEIGHT); ?></td>
            <td align="right"><table class="table-padding-0">
              <tr><?php echo tep_draw_form('search', FILENAME_INFORMATION, '', 'get'); ?>
                <td class="smallText" align="right"><?php echo HEADING_TITLE_SEARCH . ' ' . tep_draw_input_field('search', $_GET['search']); ?></td>
              </form></tr>
              <tr><?php echo tep_draw_form('goto', FILENAME_INFORMATION, '', 'get'); ?>
                <td class="smallText" align="right"><?php // echo HEADING_TITLE_GOTO . ' ' . tep_draw_pull_down_menu('cPath', tep_get_infopage_tree(), $current_infopage_id, 'onChange="this.form.submit();"'); ?></td>
              </form></tr>
            </table></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><table class="table-padding-0">
          <tr>
            <td valign="top"><table class="table-padding-2">
              <tr class="dataTableHeadingRow">
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_INFORMATION_PAGES; ?></td>
                <td class="dataTableHeadingContent" align="center"><?php echo TABLE_HEADING_STATUS; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_ACTION; ?>&nbsp;</td>
              </tr>
<?php

    $pages_count = 0;
    if ($_GET['search']) {
  	  $pages_query = tep_db_query("select p.pages_id, pd.pages_name, p.pages_image, p.pages_date_added, p.pages_last_modified, p.pages_status, p.sort_order from " . TABLE_PAGES . " p, " . TABLE_PAGES_DESCRIPTION . " pd where p.pages_id = pd.pages_id and pd.language_id = '" . $languages_id . "' and pd.pages_name like '%" . $_GET['search'] . "%' order by p.sort_order, pd.pages_name");
    } else {
      $pages_query = tep_db_query("select p.pages_id, pd.pages_name, p.pages_image, p.pages_date_added, p.pages_last_modified, p.pages_status, p.sort_order from " . TABLE_PAGES . " p, " . TABLE_PAGES_DESCRIPTION . " pd where p.pages_id = pd.pages_id and pd.language_id = '" . $languages_id . "' order by p.sort_order, pd.pages_name");
    }
    while ($pages = tep_db_fetch_array($pages_query)) {
      $pages_count++;
      $rows++;
// Get information_id for page if search
      if ($_GET['search']) $pages['pages_id'];

      if ( ((!$_GET['pID']) || (@$_GET['pID'] == $pages['pages_id'])) && (!$pInfo) && (substr($_GET['action'], 0, 4) != 'new_') ) {

/*        $pInfo_array = tep_array_merge($pages);
        $pInfo = new objectInfo($pInfo_array);
 */     $pInfo = new objectInfo($pages);
      }

      if ( (is_object($pInfo)) && ($pages['pages_id'] == $pInfo->pages_id) ) {
        echo '              <tr class="dataTableRowSelected" onmouseover="this.style.cursor=\'hand\'" onclick="document.location.href=\'' . tep_href_link(FILENAME_INFORMATION, '&pID=' . $pages['pages_id'] . '&action=new_page_preview&read=only') . '\'">' . "\n";
      } else {
        echo '              <tr class="dataTableRow" onmouseover="this.className=\'dataTableRowOver\';this.style.cursor=\'hand\'" onmouseout="this.className=\'dataTableRow\'" onclick="document.location.href=\'' . tep_href_link(FILENAME_INFORMATION, '&pID=' . $pages['pages_id']) . '\'">' . "\n";
      }
?>
                <td class="dataTableContent"><?php echo '<a href="' . tep_href_link(FILENAME_INFORMATION, '&pID=' . $pages['pages_id'] . '&action=new_page_preview&read=only') . '">' . tep_image(DIR_WS_ICONS . 'preview.gif', ICON_PREVIEW) . '</a>&nbsp;' . $pages['pages_name']; ?></td>
                <td class="dataTableContent" align="center">
<?php
      if ($pages['pages_status'] == '1') {
        echo tep_image(DIR_WS_IMAGES . 'icon_status_green.gif', IMAGE_ICON_STATUS_GREEN, 10, 10) . '&nbsp;&nbsp;<a href="' . tep_href_link(FILENAME_INFORMATION, 'action=setflag&flag=0&pID=' . $pages['pages_id']) . '">' . tep_image(DIR_WS_IMAGES . 'icon_status_red_light.gif', IMAGE_ICON_STATUS_RED_LIGHT, 10, 10) . '</a>';
      } else {
        echo '<a href="' . tep_href_link(FILENAME_INFORMATION, 'action=setflag&flag=1&pID=' . $pages['pages_id']) . '">' . tep_image(DIR_WS_IMAGES . 'icon_status_green_light.gif', IMAGE_ICON_STATUS_GREEN_LIGHT, 10, 10) . '</a>&nbsp;&nbsp;' . tep_image(DIR_WS_IMAGES . 'icon_status_red.gif', IMAGE_ICON_STATUS_RED, 10, 10);
      }
?></td>
                <td class="dataTableContent" align="right"><?php if ( (is_object($pInfo)) && ($pages['pages_id'] == $pInfo->pages_id) ) { echo tep_image(DIR_WS_IMAGES . 'icon_arrow_right.gif', ''); } else { echo '<a href="' . tep_href_link(FILENAME_INFORMATION, '&pID=' . $pages['pages_id']) . '">' . tep_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . '</a>'; } ?>&nbsp;</td>
              </tr>
<?php
    }

?>
              <tr>
                <td colspan="3"><table class="table-padding-2">
                  <tr>
                    <td class="smallText"><?php echo TEXT_PAGES . '&nbsp;' . $pages_count; ?></td>
                    <td align="right" class="smallText"><?php echo '<a href="' . tep_href_link(FILENAME_INFORMATION, '&action=new_page') . '">' . tep_image_button('button_new.gif', IMAGE_NEW_PAGE) . '</a>'; ?>&nbsp;</td>
                  </tr>
                </table></td>
              </tr>
            </table></td>
<?php
    $heading = array();
    $contents = array();
    switch ($_GET['action']) {
       case 'delete_page':
        $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_DELETE_PAGE . '</b>');

        $contents = array('form' => tep_draw_form('pages', FILENAME_INFORMATION, 'action=delete_page_confirm') . tep_draw_hidden_field('pages_id', $pInfo->pages_id));
        $contents[] = array('text' => TEXT_DELETE_PAGE_INTRO);
        $contents[] = array('text' => '<br><b>' . $pInfo->pages_name . '</b>');

        $page_id_string = '';
        $page_id = tep_generate_infopage_path($pInfo->pages_id, 'page');
        for ($i = 0, $n = sizeof($page_id); $i < $n; $i++) {
          $infopage_path = '';
          for ($j = 0, $k = sizeof($page_id[$i]); $j < $k; $j++) {
            $infopage_path .= $page_id[$i][$j]['text'] . '&nbsp;&gt;&nbsp;';
          }
          $infopage_path = substr($infopage_path, 0, -16);
          $page_id_string .= tep_draw_checkbox_field('page_information[]', $page_id[$i][sizeof($page_id[$i])-1]['id'], true) . '&nbsp;' . $infopage_path . '<br>';
        }
        $page_id_string = substr($page_id_string, 0, -4);

        $contents[] = array('text' => '<br>' . $page_id_string);
        $contents[] = array('align' => 'center', 'text' => '<br>' . tep_image_submit('button_delete.gif', IMAGE_DELETE) . ' <a href="' . tep_href_link(FILENAME_INFORMATION, '&pID=' . $pInfo->pages_id) . '">' . tep_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>');
        break;
      case 'move_page':
        $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_MOVE_PAGE . '</b>');

        $contents = array('form' => tep_draw_form('pages', FILENAME_INFORMATION, 'action=move_page_confirm') . tep_draw_hidden_field('pages_id', $pInfo->pages_id));
        $contents[] = array('text' => sprintf(TEXT_MOVE_PAGES_INTRO, $pInfo->pages_name));
        $contents[] = array('text' => '<br>' . TEXT_INFO_CURRENT_INFORMATION . '<br><b>' . tep_output_generated_infopage_path($pInfo->pages_id, 'page') . '</b>');
        $contents[] = array('text' => '<br>' . sprintf(TEXT_MOVE, $pInfo->pages_name) . '<br>' . tep_draw_pull_down_menu('move_to_infopage_id', tep_get_infopage_tree(), $current_infopage_id));
        $contents[] = array('align' => 'center', 'text' => '<br>' . tep_image_submit('button_move.gif', IMAGE_MOVE) . ' <a href="' . tep_href_link(FILENAME_INFORMATION, '&pID=' . $pInfo->pages_id) . '">' . tep_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>');
        break;
      case 'copy_to':
        $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_COPY_TO . '</b>');

        $contents = array('form' => tep_draw_form('copy_to', FILENAME_INFORMATION, 'action=copy_to_confirm') . tep_draw_hidden_field('pages_id', $pInfo->pages_id));
        $contents[] = array('text' => TEXT_INFO_COPY_TO_INTRO);
        $contents[] = array('text' => '<br>' . TEXT_INFO_CURRENT_INFORMATION . '<br><b>' . tep_output_generated_infopage_path($pInfo->pages_id, 'page') . '</b>');
        $contents[] = array('text' => '<br>' . TEXT_INFORMATION . '<br>' . tep_draw_pull_down_menu('information_id', tep_get_infopage_tree(), $current_infopage_id));
        $contents[] = array('text' => '<br>' . TEXT_HOW_TO_COPY . '<br>' . tep_draw_radio_field('copy_as', 'link', true) . ' ' . TEXT_COPY_AS_LINK . '<br>' . tep_draw_radio_field('copy_as', 'duplicate') . ' ' . TEXT_COPY_AS_DUPLICATE);
        $contents[] = array('align' => 'center', 'text' => '<br>' . tep_image_submit('button_copy.gif', IMAGE_COPY) . ' <a href="' . tep_href_link(FILENAME_INFORMATION, '&pID=' . $pInfo->pages_id) . '">' . tep_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>');
        break;
      default:
        if ($rows > 0) {
		  if (is_object($pInfo)) { // page info box contents
            $heading[] = array('text' => '<b>' . tep_get_pages_name($pInfo->pages_id, $languages_id) . '</b>');

            $contents[] = array('align' => 'center', 'text' => '<a href="' . tep_href_link(FILENAME_INFORMATION, '&pID=' . $pInfo->pages_id . '&action=new_page') . '">' . tep_image_button('button_edit.gif', IMAGE_EDIT) . '</a> <a href="' . tep_href_link(FILENAME_INFORMATION, '&pID=' . $pInfo->pages_id . '&action=delete_page') . '">' . tep_image_button('button_delete.gif', IMAGE_DELETE) . '</a>');
            $contents[] = array('text' => '<br>' . TEXT_DATE_ADDED . ' ' . tep_date_short($pInfo->pages_date_added));
            if (tep_not_null($pInfo->pages_last_modified)) $contents[] = array('text' => TEXT_LAST_MODIFIED . ' ' . tep_date_short($pInfo->pages_last_modified));
//            $contents[] = array('text' => '<br>' . tep_info_image($pInfo->pages_image, $pInfo->pages_name, SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT) . '<br>' . $pInfo->pages_image);
         }
        } else { // create infopage/page info
          $heading[] = array('text' => '<b>' . EMPTY_INFOPAGE . '</b>');

          $contents[] = array('text' => sprintf(TEXT_NO_CHILD_INFORMATION_OR_PAGES, $parent_information_name));
        }
        break;
    }

    if ( (tep_not_null($heading)) && (tep_not_null($contents)) ) {
      echo '            <td width="25%" valign="top">' . "\n";

      $box = new box;
      echo $box->infoBox($heading, $contents);

      echo '            </td>' . "\n";
    }
?>
          </tr>
        </table></td>
      </tr>
<?php
  }
?>
    </table></td>
<!-- body_text_eof //-->
  </tr>
</table>
<!-- body_eof //-->

<!-- footer //-->
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<!-- footer_eof //-->
<br>
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>