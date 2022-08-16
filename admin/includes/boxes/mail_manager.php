<?php


$cl_box_groups[] = array(
    'heading' => BOX_HEADING_MAIL_MANAGER,
    'apps' => array(
              array(
                  'code' => FILENAME_MM_RESPONSEMAIL,
                  'title' => BOX_MM_RESPONSEMAIL,
                  'link' => tep_href_link(FILENAME_MM_RESPONSEMAIL)
	            ),
              array(
                  'code' => FILENAME_MM_BULKMAIL,
                  'title' => BOX_MM_BULKMAIL,
                  'link' => tep_href_link(FILENAME_MM_BULKMAIL)
	            ),
              array(
                  'code' => FILENAME_MM_TEMPLATES,
                  'title' => BOX_MM_TEMPLATES,
                  'link' => tep_href_link(FILENAME_MM_TEMPLATES)
	            ),
              array(
                  'code' => FILENAME_MM_EMAIL,
                  'title' =>  BOX_MM_EMAIL,
                  'link' => tep_href_link(FILENAME_MM_EMAIL)
	            ),


            )
  );

?>

