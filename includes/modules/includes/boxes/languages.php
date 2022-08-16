<?php
/*
  $Id: languages.php 187 2010-12-01 11:12:10Z Rob $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/
?>
<!-- languages //-->
          <tr>
            <td>
<?php
  $info_box_contents = array();
  $info_box_contents[] = array('text' => BOX_HEADING_LANGUAGES);

  new infoBoxHeading($info_box_contents, false, false);

  if (!isset($lng) || (isset($lng) && !is_object($lng))) {
    if ( !class_exists( 'language' ) ) {
      include_once DIR_WS_CLASSES . 'language.php';
    }
    $lng = new language;
  }

  $languages_string = '';
  reset($lng->catalog_languages);
  foreach( $lng->catalog_languages as $key => $value ) {
    if ( $value['directory'] == $language ) {
      $current_lang_key = $key;
      break;
    }
  }
  reset($lng->catalog_languages);
  $home_page_redirect = defined( 'USU5_HOME_PAGE_REDIRECT' ) && ( USU5_HOME_PAGE_REDIRECT == 'true' ) ? true : false;
  while (list($key, $value) = each($lng->catalog_languages)) {
    if ( defined( 'USU5_MULTI_LANGUAGE_SEO_SUPPORT' ) && ( USU5_MULTI_LANGUAGE_SEO_SUPPORT == 'true' )
                                                      && defined( 'USU5_ENABLED' )
                                                      && ( USU5_ENABLED == 'true' ) ) {
      if( false === ( $language == $value['directory'] ) ) { // we don't want to show a link to the currently loaded language
        if ( false !== $home_page_redirect ) { // If we are using the root site redirect
          $link = str_replace( array( FILENAME_DEFAULT, '/' . $current_lang_key ), '', tep_href_link( FILENAME_DEFAULT ) );
        } else {
          $link = str_replace('/' . $current_lang_key, '', tep_href_link( FILENAME_DEFAULT ) );
        }
        if ( $key !== DEFAULT_LANGUAGE ) { // if it is not the default language we are dealing with
          if ( false === strpos( $link, '.php' ) && ( false !== $home_page_redirect ) ) {
            $link_array = explode( '?', $link );
            $qs = array_key_exists( 1, $link_array ) ? ( '?' . $link_array[1] ) : '';
            $link = $link_array[0] . FILENAME_DEFAULT . '/' . $key . $qs;
          } else {
            $link_array = explode( '?', $link );
            $qs = array_key_exists( 1, $link_array ) ? ( '?' . $link_array[1] ) : ''; 
            $link = str_replace( '.php', '.php/' . $key . $qs, $link );
          }
        }
        // USU5  shows the language link and image
        $languages_string .= ' <a href="' . $link . '">' . tep_image(DIR_WS_LANGUAGES .  $value['directory'] . '/images/' . $value['image'], $value['name']) . '</a> ';
      }
    } else { // Just do the standard osCommerce links
    // Standard osCommerce shows the language link and image
      $languages_string .= ' <a href="' . tep_href_link(basename($PHP_SELF), tep_get_all_get_params(array('language', 'currency')) . 'language=' . $key, $request_type) . '">' . tep_image(DIR_WS_LANGUAGES .  $value['directory'] . '/images/' . $value['image'], $value['name']) . '</a> ';
    }
  }

  $info_box_contents = array();
  $info_box_contents[] = array('align' => 'center',
                               'text' => $languages_string);

  new infoBox($info_box_contents);
?>
            </td>
          </tr>
<!-- languages_eof //-->