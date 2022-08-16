<?php
/*
  $Id: advanced_search_result.php,v 1.2 2003/09/24 15:34:25 wilt Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/

  require('includes/application_top.php');

  require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_ADVANCED_SEARCH);

// Search enhancement mod start

if (preg_match('/href|http|favicon/i', $_GET['keywords'])) {
//echo "robot";
break;
}

if(isset($_GET['keywords']) && $_GET['keywords'] != ''){
	if(!isset($_GET['s'])){
  	    $pwstr_check = strtolower(substr($_GET['keywords'], strlen($_GET['keywords'])-1, strlen($_GET['keywords'])));
  	    if($pwstr_check == 's'){
  	            $pwstr_replace = substr($_GET['keywords'], 0, strlen($_GET['keywords'])-1);
  	            header('location: ' . tep_href_link( FILENAME_ADVANCED_SEARCH_RESULT , 'search_in_description=1&s=1&keywords=' . urlencode($pwstr_replace) . '' ));
  	            exit;
  	    }
        } 

       $pw_keywords = explode(' ',stripslashes(strtolower($_GET['keywords'])));
       $pw_boldwords = $pw_keywords;
       $sql_words = tep_db_query("SELECT * FROM searchword_swap");
       $pw_replacement = '';
       while ($sql_words_result = tep_db_fetch_array($sql_words)) {
       	   if(stripslashes(strtolower($_GET['keywords'])) == stripslashes(strtolower($sql_words_result['sws_word']))){
       	       $pw_replacement = stripslashes($sql_words_result['sws_replacement']);
       	       $pw_link_text = '<b><i>' . stripslashes($sql_words_result['sws_replacement']) . '</i></b>';
       	       $pw_phrase = 1;
       	       $pw_mispell = 1;
       	       break;
       	   }
           for($i=0; $i<sizeof($pw_keywords); $i++){
               if($pw_keywords[$i]  == stripslashes(strtolower($sql_words_result['sws_word']))){
                   $pw_keywords[$i]  = stripslashes($sql_words_result['sws_replacement']);
                   $pw_boldwords[$i] = '<b><i>' . stripslashes($sql_words_result['sws_replacement']) . '</i></b>';
                   $pw_mispell = 1;
                   break;
               }
           }	
       }
       if(!isset($pw_phrase)){
           for($i=0; $i<sizeof($pw_keywords); $i++){
               $pw_replacement .= $pw_keywords[$i]. ' ';
       	       $pw_link_text   .= $pw_boldwords[$i]. ' ';	
           }
       }
       
       $pw_replacement = trim($pw_replacement);
       $pw_link_text   = trim($pw_link_text);
       $pw_string      = '<br><span class="main"><font color="red">' . TEXT_REPLACEMENT_SUGGESTION . '</font><a href="' . tep_href_link( FILENAME_ADVANCED_SEARCH_RESULT , 'keywords=' . urlencode($pw_replacement) . '&search_in_description=1' ) . '">' . $pw_link_text . '</a></span><br><br>';
}
// Search enhancement mod end


  $error = false;

  if ( (isset($_GET['keywords']) && empty($_GET['keywords'])) &&
       (isset($_GET['dfrom']) && (empty($_GET['dfrom']) || ($_GET['dfrom'] == DOB_FORMAT_STRING))) &&
       (isset($_GET['dto']) && (empty($_GET['dto']) || ($_GET['dto'] == DOB_FORMAT_STRING))) &&
       (isset($_GET['pfrom']) && !is_numeric($_GET['pfrom'])) &&
       (isset($_GET['pto']) && !is_numeric($_GET['pto'])) ) {
    $error = true;

    $messageStack->add_session('search', ERROR_AT_LEAST_ONE_INPUT);
  } else {
    $dfrom = '';
    $dto = '';
    $pfrom = '';
    $pto = '';
    $keywords = '';

    if (isset($_GET['dfrom'])) {
      $dfrom = (($_GET['dfrom'] == DOB_FORMAT_STRING) ? '' : $_GET['dfrom']);
    }

    if (isset($_GET['dto'])) {
      $dto = (($_GET['dto'] == DOB_FORMAT_STRING) ? '' : $_GET['dto']);
    }

    if (isset($_GET['pfrom'])) {
      $pfrom = $_GET['pfrom'];
    }

    if (isset($_GET['pto'])) {
      $pto = $_GET['pto'];
    }

    if (isset($_GET['keywords'])) {
      $keywords = $_GET['keywords'];
    }

    $date_check_error = false;
    if (tep_not_null($dfrom)) {
      if (!tep_checkdate($dfrom, DOB_FORMAT_STRING, $dfrom_array)) {
        $error = true;
        $date_check_error = true;

        $messageStack->add_session('search', ERROR_INVALID_FROM_DATE);
      }
    }

    if (tep_not_null($dto)) {
      if (!tep_checkdate($dto, DOB_FORMAT_STRING, $dto_array)) {
        $error = true;
        $date_check_error = true;

        $messageStack->add_session('search', ERROR_INVALID_TO_DATE);
      }
    }

    if (($date_check_error == false) && tep_not_null($dfrom) && tep_not_null($dto)) {
      if (mktime(0, 0, 0, $dfrom_array[1], $dfrom_array[2], $dfrom_array[0]) > mktime(0, 0, 0, $dto_array[1], $dto_array[2], $dto_array[0])) {
        $error = true;

        $messageStack->add_session('search', ERROR_TO_DATE_LESS_THAN_FROM_DATE);
      }
    }

    $price_check_error = false;
    if (tep_not_null($pfrom)) {
      if (!settype($pfrom, 'double')) {
        $error = true;
        $price_check_error = true;

        $messageStack->add_session('search', ERROR_PRICE_FROM_MUST_BE_NUM);
      }
    }

    if (tep_not_null($pto)) {
      if (!settype($pto, 'double')) {
        $error = true;
        $price_check_error = true;

        $messageStack->add_session('search', ERROR_PRICE_TO_MUST_BE_NUM);
      }
    }

    if (($price_check_error == false) && is_float($pfrom) && is_float($pto)) {
      if ($pfrom >= $pto) {
        $error = true;

        $messageStack->add_session('search', ERROR_PRICE_TO_LESS_THAN_PRICE_FROM);
      }
    }

    if (tep_not_null($keywords)) {
      if (!tep_parse_search_string($keywords, $search_keywords)) {
        $error = true;

        $messageStack->add_session('search', ERROR_INVALID_KEYWORDS);
      }
    }
  }

  if (empty($dfrom) && empty($dto) && empty($pfrom) && empty($pto) && empty($keywords)) {
    $error = true;

    $messageStack->add_session('search', ERROR_AT_LEAST_ONE_INPUT);
  }

  if ($error == true) {
    tep_redirect(tep_href_link(FILENAME_ADVANCED_SEARCH, tep_get_all_get_params(), 'NONSSL', true, false));
  }

// Search enhancement mod start
                $search_enhancements_keywords = $_GET['keywords'];
                $search_enhancements_keywords = strip_tags($search_enhancements_keywords);
                $search_enhancements_keywords = addslashes($search_enhancements_keywords);                
          
                if ($search_enhancements_keywords != $last_search_insert) {
                        tep_db_query("insert into search_queries (search_text)  values ('" .  $search_enhancements_keywords . "')");
                        tep_session_register('last_search_insert');
                        $last_search_insert = $search_enhancements_keywords;
                }
// Search enhancement mod end


  $breadcrumb->add(NAVBAR_TITLE_1, tep_href_link(FILENAME_ADVANCED_SEARCH));
  $breadcrumb->add(NAVBAR_TITLE_2, tep_href_link(FILENAME_ADVANCED_SEARCH_RESULT, tep_get_all_get_params(), 'NONSSL', true, false));

  $content = CONTENT_ADVANCED_SEARCH_RESULT;

  require(DIR_WS_TEMPLATES . TEMPLATE_NAME . '/' . TEMPLATENAME_MAIN_PAGE);

  require(DIR_WS_INCLUDES . 'application_bottom.php');
?>
