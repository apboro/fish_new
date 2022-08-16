<?php
// /catalog/includes/header_tags.php
// WebMakers.com Added: Header Tags Generator v2.0
// Add META TAGS and Modify TITLE
//
// NOTE: Globally replace all fields in products table with current product name just to get things started:
// In phpMyAdmin use: UPDATE products_description set PRODUCTS_HEAD_TITLE_TAG = PRODUCTS_NAME
//
require(DIR_FS_CATALOG.DIR_WS_LANGUAGES . $language . '/' . 'header_tags.php');

$the_desc='';
$the_key_words='';
$the_title='';

// Define specific settings per page:
switch (true) {

// DEFAULT.PHP
//if (isset($cPath) && tep_not_null($cPath)) {
//case (isset($cPath) && tep_not_null($cPath)):
  case (strstr($_SERVER['PHP_SELF'],FILENAME_DEFAULT) or strstr($PHP_SELF,FILENAME_DEFAULT) or  strstr($PHP_SELF,FILENAME_PRODUCTS_FILTERS) ):
    $the_category_query = tep_db_query("select cd.categories_name from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd where c.categories_id = '" . (int)$current_category_id . "' and cd.categories_id = '" . (int)$current_category_id . "' and cd.language_id = '" . (int)$languages_id . "'");
    $the_category = tep_db_fetch_array($the_category_query);

$metaCategoryArray = explode ("_",$cPath);
if (strpos($cPath, '_')) { $metaCategoryArray  = array_reverse($metaCategoryArray); }
$metaCategory = $metaCategoryArray[0];

$category_query = tep_db_query ("select og_image,tk_image,tk_title,tk_description,og_title,og_description,categories_meta_title, categories_meta_description, categories_meta_keywords from " . TABLE_CATEGORIES_DESCRIPTION . " where categories_id = '" . $metaCategory . "' and language_id = '" . (int)$languages_id . "'");

$metaData = tep_db_fetch_array ($category_query);

if (empty($metaData['categories_meta_description'])) {
     $the_desc= HEAD_DESC_TAG_DEFAULT;
} else {
    if (isset($cPath) && tep_not_null($cPath)) {
     $the_desc= $metaData['categories_meta_description'];
     } else {
     $the_desc= HEAD_DESC_TAG_DEFAULT;
    }
}

if (empty($metaData['categories_meta_keywords'])) {
     $the_key_words= HEAD_KEY_TAG_DEFAULT;
} else {
    if (isset($cPath) && tep_not_null($cPath)) {
     $the_key_words= $metaData['categories_meta_keywords'];
     } else {
     $the_key_words= HEAD_KEY_TAG_DEFAULT;
    }
}

      if (empty($the_category['categories_name'])) {
          $the_title = HEAD_TITLE_TAG_DEFAULT . $the_category['categories_name'];
      } else {
          if (HTTA_DEFAULT_ON == '1' and empty($metaData['categories_meta_title'])) {
              $the_title = $the_category['categories_name'];
          } else {
              $the_title = $metaData['categories_meta_title'];
          }
      }
    break;

// PRODUCT_INFO.PHP
  case ( strstr($_SERVER['PHP_SELF'],'product_info.php') or strstr($PHP_SELF,'product_info.php') ):
//    $the_product_info_query = tep_db_query("select p.products_id, pd.products_name, pd.products_description, pd.products_head_title_tag, pd.products_head_keywords_tag, pd.products_head_desc_tag, p.products_model, p.products_quantity, p.products_image, pd.products_url, p.products_price, p.products_tax_class_id, p.products_date_added, p.products_date_available, p.manufacturers_id from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd where p.products_id = '" . $_GET['products_id'] . "' and pd.products_id = '" . $_GET['products_id'] . "'");
    $the_product_info_query = tep_db_query("select pd.tk_image,pd.og_image,pd.tk_title,pd.tk_description,pd.og_title,pd.og_description,pd.language_id, p.products_id, pd.products_name, pd.products_description, pd.products_head_title_tag, pd.products_head_keywords_tag, pd.products_head_desc_tag, p.products_model, p.products_quantity, p.products_image, pd.products_url, p.products_price, p.products_tax_class_id, p.products_date_added, p.products_date_available, p.manufacturers_id from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd where p.products_id = '" . (int)$_GET['products_id'] . "' and pd.products_id = '" . (int)$_GET['products_id'] . "'" . " and pd.language_id ='" .  (int)$languages_id . "'");
    $the_product_info = tep_db_fetch_array($the_product_info_query);

    if (empty($the_product_info['products_head_desc_tag'])) {
      $the_desc= HEAD_DESC_TAG_ALL;
    } else {
      if ( HTDA_PRODUCT_INFO_ON=='1' ) {
        $the_desc= $the_product_info['products_head_desc_tag'] . ' ' . HEAD_DESC_TAG_ALL;
      } else {
        $the_desc= $the_product_info['products_head_desc_tag'];
      }
    }

    if (empty($the_product_info['products_head_keywords_tag'])) {
      $the_key_words= HEAD_KEY_TAG_ALL;
    } else {
      if ( HTKA_PRODUCT_INFO_ON=='1' ) {
        $the_key_words= $the_product_info['products_head_keywords_tag'] . ' ' . HEAD_KEY_TAG_ALL;
      } else {
        $the_key_words= $the_product_info['products_head_keywords_tag'];
      }
    }
if (isset($cPath) && tep_not_null($cPath)) {

    $the_category_query = tep_db_query("select cd.categories_name from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd where c.categories_id = '" . (int)$current_category_id . "' and cd.categories_id = '" . (int)$current_category_id . "' and cd.language_id = '" . (int)$languages_id . "'");
    $the_category = tep_db_fetch_array($the_category_query);

$metaCategoryArray = explode ("_",$cPath);
if (strpos($cPath, '_')) { $metaCategoryArray  = array_reverse($metaCategoryArray); }
$metaCategory = $metaCategoryArray[0];

$category_query = tep_db_query ("select og_image,tk_image,tk_title,tk_description,og_title,og_description,categories_meta_title, categories_meta_description, categories_meta_keywords from " . TABLE_CATEGORIES_DESCRIPTION . " where categories_id = '" . $metaCategory . "' and language_id = '" . (int)$languages_id . "'");

$metaData = tep_db_fetch_array ($category_query);
    $the_product_info['products_head_title_tag'] = trim($the_product_info['products_head_title_tag']);
    if (empty($the_product_info['products_head_title_tag'])) {
      $the_title= $the_product_info['products_name'] . ' - ' . $the_category['categories_name'];
    } else {
      if ( HTTA_PRODUCT_INFO_ON=='1' ) {
        $the_title= clean_html_comments($the_product_info['products_head_title_tag']) . ' - ' . $the_category['categories_name'];
      } else {
        $the_title= clean_html_comments($the_product_info['products_head_title_tag']);
      }
    }
    $the_title .= ' - купить в рыболовном интернет-магазине';
    break;

}
// PRODUCTS_NEW.PHP
  case ( strstr($_SERVER['PHP_SELF'],'products_new.php') or strstr($PHP_SELF,'products_new.php') ):
    if ( HEAD_DESC_TAG_WHATS_NEW!='' ) {
      if ( HTDA_WHATS_NEW_ON=='1' ) {
        $the_desc= HEAD_DESC_TAG_WHATS_NEW . ' ' . HEAD_DESC_TAG_ALL;
      } else {
        $the_desc= HEAD_DESC_TAG_WHATS_NEW;
      }
    } else {
      $the_desc= HEAD_DESC_TAG_ALL;
    }

    if ( HEAD_KEY_TAG_WHATS_NEW!='' ) {
      if ( HTKA_WHATS_NEW_ON=='1' ) {
        $the_key_words= HEAD_KEY_TAG_WHATS_NEW . ' ' . HEAD_KEY_TAG_ALL;
      } else {
        $the_key_words= HEAD_KEY_TAG_WHATS_NEW;
      }
    } else {
      $the_key_words= HEAD_KEY_TAG_ALL;
    }

    if ( HEAD_TITLE_TAG_WHATS_NEW!='' ) {
      if ( HTTA_WHATS_NEW_ON=='1' ) {
        $the_title= HEAD_TITLE_TAG_ALL . ' - ' . HEAD_TITLE_TAG_WHATS_NEW;
      } else {
        $the_title= HEAD_TITLE_TAG_WHATS_NEW;
      }
    } else {
      $the_title= HEAD_TITLE_TAG_ALL;
    }

    break;


// SPECIALS.PHP
  case ( strstr($_SERVER['PHP_SELF'],'specials.php')  or strstr($PHP_SELF,'specials.php') ):
    if ( HEAD_DESC_TAG_SPECIALS!='' ) {
      if ( HTDA_SPECIALS_ON=='1' ) {
        $the_desc= HEAD_DESC_TAG_SPECIALS . ' ' . HEAD_DESC_TAG_ALL;
      } else {
        $the_desc= HEAD_DESC_TAG_SPECIALS;
      }
    } else {
      $the_desc= HEAD_DESC_TAG_ALL;
    }

    if ( HEAD_KEY_TAG_SPECIALS=='' ) {
      // Build a list of ALL specials product names to put in keywords
      $new = tep_db_query("select p.products_id, pd.products_name, p.products_price, p.products_tax_class_id, p.products_image, s.specials_new_products_price from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd, " . TABLE_SPECIALS . " s where p.products_status = '1' and s.products_id = p.products_id and p.products_id = pd.products_id and pd.language_id = '" . (int)$languages_id . "' and s.status = '1' order by s.specials_date_added DESC ");
      $row = 0;
      $the_specials='';
      while ($new_values = tep_db_fetch_array($new)) {
        $the_specials .= clean_html_comments($new_values['products_name']) . ', ';
      }
      if ( HTKA_SPECIALS_ON=='1' ) {
        $the_key_words= $the_specials . ' ' . HEAD_KEY_TAG_ALL;
      } else {
        $the_key_words= $the_specials;
      }
    } else {
      $the_key_words= HEAD_KEY_TAG_SPECIALS . ' ' . HEAD_KEY_TAG_ALL;
    }

    if ( HEAD_TITLE_TAG_SPECIALS!='' ) {
      if ( HTTA_SPECIALS_ON=='1' ) {
        $the_title= HEAD_TITLE_TAG_ALL . ' - ' . HEAD_TITLE_TAG_SPECIALS;
      } else {
        $the_title= HEAD_TITLE_TAG_SPECIALS;
      }
    } else {
      $the_title= HEAD_TITLE_TAG_ALL;
    }

    break;


// PRODUCTS_REVIEWS_INFO.PHP and PRODUCTS_REVIEWS.PHP
  case ( strstr($_SERVER['PHP_SELF'],'product_reviews_info.php') or strstr($_SERVER['PHP_SELF'],'product_reviews.php') or strstr($PHP_SELF,'product_reviews_info.php') or strstr($PHP_SELF,'product_reviews.php') ):
    if ( HEAD_DESC_TAG_PRODUCT_REVIEWS_INFO=='' ) {
      if ( HTDA_PRODUCT_REVIEWS_INFO_ON=='1' ) {
        $the_desc= tep_get_header_tag_products_desc(isset($_GET['reviews_id'])) . ' ' . HEAD_DESC_TAG_ALL;
      } else {
        $the_desc= tep_get_header_tag_products_desc(isset($_GET['reviews_id']));
      }
    } else {
      $the_desc= HEAD_DESC_TAG_PRODUCT_REVIEWS_INFO;
    }

    if ( HEAD_KEY_TAG_PRODUCT_REVIEWS_INFO=='' ) {
      if ( HTKA_PRODUCT_REVIEWS_INFO_ON=='1' ) {
        $the_key_words= tep_get_header_tag_products_keywords(isset($_GET['reviews_id'])) . ' ' . HEAD_KEY_TAG_ALL;
      } else {
        $the_key_words= tep_get_header_tag_products_keywords(isset($_GET['reviews_id']));
      }
    } else {
      $the_key_words= HEAD_KEY_TAG_PRODUCT_REVIEWS_INFO;
    }

    if ( HEAD_TITLE_TAG_PRODUCT_REVIEWS_INFO=='' ) {
      if ( HTTA_PRODUCT_REVIEWS_INFO_ON=='1' ) {
        $the_title= HEAD_TITLE_TAG_ALL . ' - ' . tep_get_products_name($_GET['products_id']);
      } else {
        $the_title= tep_get_products_name(isset($_GET['products_id']));
      }
    } else {
      $the_title= HEAD_TITLE_TAG_PRODUCT_REVIEWS_INFO . ' - ' . tep_get_products_name($_GET['products_id']);
    }

    break;

  case ( strstr($_SERVER['PHP_SELF'],'advanced_search_result.php')  or strstr($PHP_SELF,'advanced_search_result.php') ):

        $the_title= "Товары, соответствующие Вашему запросу «".$_GET['keywords']."»";
      $the_desc= HEAD_DESC_TAG_ALL;
      $the_key_words= HEAD_KEY_TAG_ALL;

        break;
    case ( strstr($_SERVER['PHP_SELF'],'map.php')  or strstr($PHP_SELF,'map.php') ):

    $the_title= "Схема проезда";
    $the_desc= HEAD_DESC_TAG_ALL;
    $the_key_words= HEAD_KEY_TAG_ALL;

    break;
    case ( strstr($_SERVER['PHP_SELF'],'discount.php')  or strstr($PHP_SELF,'discount.php') ):

        $the_title= "Скидки";
        $the_desc= HEAD_DESC_TAG_ALL;
        $the_key_words= HEAD_KEY_TAG_ALL;

        break;
// ALL OTHER PAGES NOT DEFINED ABOVE
  default:
    $the_desc= HEAD_DESC_TAG_ALL;
    $the_key_words= HEAD_KEY_TAG_ALL;
    $the_title= HEAD_TITLE_TAG_ALL;
    break;

  }

// Manufacturers
if (isset($_GET['manufacturers_id']) && tep_not_null($_GET['manufacturers_id'])) {

$manufacturers_query = tep_db_query ("select  manufacturers_meta_title,  manufacturers_meta_keywords,  manufacturers_meta_description from " . TABLE_MANUFACTURERS_INFO . " where manufacturers_id = '" . $_GET['manufacturers_id'] . "' and languages_id = '" . (int)$languages_id . "'");

$metaData = tep_db_fetch_array ($manufacturers_query);

// BOF manufacturers descriptions
//  $the_manufacturers_query= tep_db_query("select manufacturers_name from " . TABLE_MANUFACTURERS . " where manufacturers_id = '" . (int)$_GET['manufacturers_id'] . "'");
    $the_manufacturers_query= tep_db_query("select manufacturers_name from " . TABLE_MANUFACTURERS_INFO . " where manufacturers_id = '" . (int)$_GET['manufacturers_id'] . "' and languages_id = '" . (int)$languages_id . "'");
// EOF manufacturers descriptions
    $the_manufacturers = tep_db_fetch_array($the_manufacturers_query);


    if (empty($metaData['manufacturers_meta_description'])) {
      $the_desc= HEAD_DESC_TAG_ALL;
    } else {
      if ( HTDA_DEFAULT_ON=='1' ) {
        $the_desc= $metaData['manufacturers_meta_description'] . ' ' . HEAD_DESC_TAG_ALL;
      } else {
        $the_desc= $metaData['manufacturers_meta_description'];
      }
    }

    if (empty($metaData['manufacturers_meta_keywords'])) {
      $the_key_words= HEAD_KEY_TAG_ALL;
    } else {
      if ( HTKA_DEFAULT_ON=='1' ) {
        $the_key_words= $metaData['manufacturers_meta_keywords'] . ' ' . HEAD_KEY_TAG_ALL;
      } else {
        $the_key_words= $metaData['manufacturers_meta_keywords'];
      }
    }

    if (empty($metaData['manufacturers_meta_title'])) {
      $the_title= $the_manufacturers['manufacturers_name'] . ' - ' . HEAD_TITLE_TAG_ALL;
    } else {
      if ( HTTA_DEFAULT_ON=='1' ) {
        $the_title= clean_html_comments($metaData['manufacturers_meta_title']) . ' - ' . HEAD_TITLE_TAG_ALL;
      } else {
        $the_title= $the_manufacturers['manufacturers_name'];

      }
    }
}
// ARTICLES.PHP
switch (true) {

    case ((strstr($_SERVER['PHP_SELF'],'articles.php') or strstr($PHP_SELF,'articles.php')) &! strstr($PHP_SELF,'new_articles.php')):
    $the_topic_query = tep_db_query("select td.topics_name from " . TABLE_TOPICS . " t, " . TABLE_TOPICS_DESCRIPTION . " td where t.topics_id = '" . (int)$current_topic_id . "' and td.topics_id = '" . (int)$current_topic_id . "' and td.language_id = '" . (int)$languages_id . "'");
    $the_topic = tep_db_fetch_array($the_topic_query);

    $the_authors_query= tep_db_query("select authors_name from " . TABLE_AUTHORS . " where authors_id = '" . (int)$_GET['authors_id'] . "'");
    $the_authors = tep_db_fetch_array($the_authors_query);

    if (HTDA_ARTICLES_ON=='1') {
      $the_desc= HEAD_DESC_TAG_ARTICLES . '. ' . HEAD_DESC_ARTICLE_TAG_ALL;
    } else {
      $the_desc= HEAD_DESC_TAG_ARTICLES;
    }

    if (HTKA_ARTICLES_ON=='1') {

      if (tep_not_null($the_topic['topics_name'])) {
        $the_key_words .= $the_topic['topics_name'];
      } else {
        if (tep_not_null($the_authors['authors_name'])) {
          $the_key_words .= $the_authors['authors_name'];
        }
      }

      $the_key_words = HEAD_KEY_TAG_ARTICLES . ', ' . $the_key_words . ', ' . HEAD_KEY_ARTICLE_TAG_ALL;

    } else {
      $the_key_words= HEAD_KEY_TAG_ARTICLES;
    }

    if (HTTA_ARTICLES_ON=='1') {
      $the_title= HEAD_TITLE_ARTICLE_TAG_ALL . ' - ' . HEAD_TITLE_TAG_ARTICLES;

      if (tep_not_null($the_topic['topics_name'])) {
        $the_title .= ' - ' . $the_topic['topics_name'];
      } else {
        if (tep_not_null($the_authors['authors_name'])) {
          $the_title .= TEXT_BY . $the_authors['authors_name'];
        }
      }

    } else {
      $the_title= HEAD_TITLE_TAG_ARTICLES;
    }

    break;

// ARTICLE_INFO.PHP
  case ( strstr($_SERVER['PHP_SELF'],'article_info.php') or strstr($PHP_SELF,'article_info.php') ):
//    $the_article_info_query = tep_db_query("select a.articles_id, ad.articles_name, ad.articles_description, ad.articles_head_title_tag, ad.articles_head_keywords_tag, ad.articles_head_desc_tag, ad.articles_url, a.articles_date_added, a.articles_date_available, a.authors_id from " . TABLE_ARTICLES . " a, " . TABLE_ARTICLES_DESCRIPTION . " ad where a.articles_id = '" . $_GET['articles_id'] . "' and ad.articles_id = '" . $_GET['articles_id'] . "'");
    $the_article_info_query = tep_db_query("select ad.language_id, a.articles_id, ad.articles_name, ad.articles_description, ad.articles_head_title_tag, ad.articles_head_keywords_tag, ad.articles_head_desc_tag, ad.articles_url, a.articles_date_added, a.articles_date_available, a.authors_id from " . TABLE_ARTICLES . " a, " . TABLE_ARTICLES_DESCRIPTION . " ad where a.articles_id = '" . (int)$_GET['articles_id'] . "' and ad.articles_id = '" . (int)$_GET['articles_id'] . "'" . " and ad.language_id ='" .  (int)$languages_id . "'");
    $the_article_info = tep_db_fetch_array($the_article_info_query);

    if (empty($the_article_info['articles_head_desc_tag'])) {
      $the_desc= HEAD_DESC_ARTICLE_TAG_ALL;
    } else {
      if ( HTDA_ARTICLE_INFO_ON=='1' ) {
        $the_desc= $the_article_info['articles_head_desc_tag'] . ' ' . HEAD_DESC_ARTICLE_TAG_ALL;
      } else {
        $the_desc= $the_article_info['articles_head_desc_tag'];
      }
    }

    if (empty($the_article_info['articles_head_keywords_tag'])) {
      $the_key_words= HEAD_KEY_ARTICLE_TAG_ALL;
    } else {
      if ( HTKA_ARTICLE_INFO_ON=='1' ) {
        $the_key_words= $the_article_info['articles_head_keywords_tag'] . ', ' . HEAD_KEY_ARTICLE_TAG_ALL;
      } else {
        $the_key_words= $the_article_info['articles_head_keywords_tag'];
      }
    }

// BOF SEO Title
		if (empty($the_article_info['articles_head_title_tag'])) $the_article_info['articles_head_title_tag'] = $the_article_info['articles_name'];
// EOF SEO Title
    if (empty($the_article_info['articles_head_title_tag'])) {
      $the_title= HEAD_TITLE_ARTICLE_TAG_ALL . ' - ' . HEAD_TITLE_TAG_ARTICLES;
    } else {
      if ( HTTA_ARTICLE_INFO_ON=='1' ) {
        $the_title= HEAD_TITLE_ARTICLE_TAG_ALL . ' - ' .  HEAD_TITLE_TAG_ARTICLE_INFO . ' - ' . $topics['topics_name'] . $authors['authors_name'] . ' - ' . clean_html_comments($the_article_info['articles_head_title_tag']);
      } else {
        $the_title= clean_html_comments($the_article_info['articles_head_title_tag']);
      }
    }

    break;

// ARTICLES_NEW.PHP
  case ( strstr($_SERVER['PHP_SELF'],'articles_new.php') or strstr($PHP_SELF,'articles_new.php') ):
    if ( HEAD_DESC_TAG_ARTICLES_NEW!='' ) {
      if ( HTDA_ARTICLES_NEW_ON=='1' ) {
        $the_desc= HEAD_DESC_TAG_ARTICLES_NEW . '. ' . HEAD_DESC_ARTICLE_TAG_ALL;
      } else {
        $the_desc= HEAD_DESC_TAG_ARTICLES_NEW;
      }
    } else {
      $the_desc= HEAD_DESC_ARTICLE_TAG_ALL;
    }

    if ( HEAD_KEY_TAG_ARTICLES_NEW=='' ) {
      // Build a list of ALL new article names to put in keywords
      $articles_new_array = array();
      $articles_new_query_raw = "select ad.articles_name from " . TABLE_ARTICLES . " a left join " . TABLE_AUTHORS . " au on (a.authors_id = au.authors_id), " . TABLE_ARTICLES_DESCRIPTION . " ad where a.articles_status = '1' and a.articles_id = ad.articles_id and ad.language_id = '" . (int)$languages_id . "' order by a.articles_date_added DESC, ad.articles_name";
      $articles_new_split = new splitPageResults($articles_new_query_raw, MAX_NEW_ARTICLES_PER_PAGE);
      $articles_new_query = tep_db_query($articles_new_split->sql_query);

      $row = 0;
      $the_new_articles='';
      while ($articles_new = tep_db_fetch_array($articles_new_query)) {
        $the_new_articles .= clean_html_comments($articles_new['articles_name']) . ', ';
      }
      if ( HTKA_ARTICLES_NEW_ON=='1' ) {
        $the_key_words= $the_new_articles . ', ' . HEAD_KEY_ARTICLE_TAG_ALL;
      } else {
        $the_key_words= $the_new_articles;
      }
    } else {
      $the_key_words= HEAD_KEY_TAG_ARTICLES_NEW . ', ' . HEAD_KEY_ARTICLE_TAG_ALL;
    }

    if ( HEAD_TITLE_TAG_ARTICLES_NEW!='' ) {
      if ( HTTA_ARTICLES_NEW_ON=='1' ) {
        $the_title= HEAD_TITLE_ARTICLE_TAG_ALL . ' - ' . HEAD_TITLE_TAG_ARTICLES_NEW;
      } else {
        $the_title= HEAD_TITLE_TAG_ARTICLES_NEW;
      }
    } else {
      $the_title= HEAD_TITLE_ARTICLE_TAG_ALL . ' - ' . NAVBAR_TITLE;
    }

    break;

// ARTICLES_REVIEWS_INFO.PHP and ARTICLES_REVIEWS.PHP
  case ( strstr($_SERVER['PHP_SELF'],'article_reviews_info.php') or strstr($_SERVER['PHP_SELF'],'article_reviews.php') or strstr($PHP_SELF,'article_reviews_info.php') or strstr($PHP_SELF,'article_reviews.php') ):
    if ( HEAD_DESC_TAG_ARTICLE_REVIEWS_INFO=='' ) {
      if ( HTDA_ARTICLE_REVIEWS_INFO_ON=='1' ) {
        $the_desc= NAVBAR_TITLE . '. ' . tep_get_header_tag_articles_desc(isset($_GET['reviews_id'])) . ' ' . HEAD_DESC_ARTICLE_TAG_ALL;
      } else {
        $the_desc= NAVBAR_TITLE . '. ' . tep_get_header_tag_articles_desc(isset($_GET['reviews_id']));
      }
    } else {
      $the_desc= HEAD_DESC_TAG_ARTICLE_REVIEWS_INFO;
    }

    if ( HEAD_KEY_TAG_ARTICLE_REVIEWS_INFO=='' ) {
      if ( HTKA_ARTICLE_REVIEWS_INFO_ON=='1' ) {
        $the_key_words= NAVBAR_TITLE . ', ' . tep_get_header_tag_articles_keywords(isset($_GET['reviews_id'])) . ', ' . HEAD_KEY_ARTICLE_TAG_ALL;
      } else {
        $the_key_words= NAVBAR_TITLE . ', ' . tep_get_header_tag_articles_keywords(isset($_GET['reviews_id']));
      }
    } else {
      $the_key_words= HEAD_KEY_TAG_ARTICLE_REVIEWS_INFO;
    }

    if ( HEAD_TITLE_TAG_ARTICLE_REVIEWS_INFO=='' ) {
      if ( HTTA_ARTICLE_REVIEWS_INFO_ON=='1' ) {
        $the_title= HEAD_TITLE_ARTICLE_TAG_ALL . ' - ' . HEADING_TITLE . tep_get_header_tag_articles_title(isset($_GET['reviews_id']));
      } else {
        $the_title= tep_get_header_tag_articles_title(isset($_GET['reviews_id']));
      }
    } else {
      $the_title= HEAD_TITLE_TAG_ARTICLE_REVIEWS_INFO;
    }

    break;

// Meta Title для Информационных страниц

  case ( strstr($_SERVER['PHP_SELF'],'information.php') ):

$the_title= addslashes($page_info['pages_name']);
  break;


// newsdesk_info.php
  case ( strstr($_SERVER['PHP_SELF'],'newsdesk_info.php') or strstr($PHP_SELF,'newsdesk_info.php') ):
  	$the_title= HEAD_TITLE_ARTICLE_TAG_ALL . ' - ' . NAVBAR_TITLE . ' - ' . $categories['categories_name'] . ' - ' . $news['newsdesk_article_name'];
  break;

// newsdesk_index.php
  case ( strstr($_SERVER['PHP_SELF'],'newsdesk_index.php') or strstr($PHP_SELF,'newsdesk_index.php') ):
  	$the_title= HEAD_TITLE_ARTICLE_TAG_ALL . ' - ' . NAVBAR_TITLE . ' - ' . $categories['categories_name'] . ' - ' . $news['newsdesk_article_name'];
  break;

  }


echo '<title>' . strip_tags($the_title) . '</title>' . "\n";
echo '<meta name="Description" Content="' . strip_tags($the_desc) . '">' . "\n";
echo '<meta name="Keywords" CONTENT="' . strip_tags($the_key_words) . '">' . "\n";
echo '<meta name="Reply-to" CONTENT="' . HEAD_REPLY_TAG_ALL . '">' . "\n";
if($_SERVER['REQUEST_URI'] == '/'){
    echo '<link rel="amphtml" href="'.tep_href_link('amp').'"/>';
}
$canonicalURL = '';
?>
<? if ($_REQUEST['reviews_id'] || (defined('NOINDEX') && NOINDEX)) { ?>
<meta name="robots" content="noindex, follow"/>
<?} ?>
<?php
$test= '';
ob_start();
if(defined('AMP')){
    echo (($request_type == 'SSL') ? HTTPS_SERVER : HTTP_SERVER) . DIR_WS_CATALOG;
}else if (isset($_GET['products_id']) && strstr($PHP_SELF, FILENAME_PRODUCT_INFO)) {
    CanonicalUrl('products_id');
} else if (isset($_GET['cPath']) && isset($current_category_id) && strstr($PHP_SELF, FILENAME_DEFAULT)) {
    echo $breadcrumb->_trail[count($breadcrumb->_trail) - 1]['link'];
} else if (isset($_GET['vPath'])) {
    CanonicalUrl('');
} else if (isset($_GET['cPath']) && strstr($PHP_SELF, FILENAME_PRODUCTS_FILTERS)) {
    CanonicalUrl('cPath');
} else if (isset($_GET['articles_id']) && strstr($PHP_SELF, FILENAME_ARTICLE_INFO)) {
    CanonicalUrl('articles_id');
} else if (isset($tPath) && strstr($PHP_SELF, FILENAME_ARTICLES)) {
    CanonicalUrl('tPath');
} else if (isset($_GET['news_id']) && strstr($PHP_SELF, FILENAME_NEWS)) {
    CanonicalUrl('news_id');
} else if (isset($_GET['faq_id']) && strstr($PHP_SELF, FILENAME_FAQ)) {
    CanonicalUrl('faq_id');
} else if (isset($_GET['filter_id'])) {
    echo $breadcrumb->_trail[count($breadcrumb->_trail) - 1]['link'];
} else if (isset($_GET['manufacturers_id']) && strstr($PHP_SELF, FILENAME_DEFAULT)) {
    CanonicalUrl('manufacturers_id');
}else if(isset($_GET['reviews_id'])){
    echo tep_href_link(FILENAME_PRODUCT_REVIEWS, tep_get_all_get_params(array('reviews_id')));
} else if (strstr($PHP_SELF, FILENAME_ADVANCED_SEARCH_RESULT)) {
    //$_GET['keywords'] = urlencode($_GET['keywords']);
    CanonicalUrl('');
} else if (strstr($PHP_SELF, FILENAME_BEST_SELLERS)) {
    CanonicalUrl('');
}  else{
    CanonicalUrl('');
}
$canonicalURL = ob_get_contents();

ob_end_clean();
if(empty($canonicalURL)){
    echo '<link rel="canonical" href="';
    CanonicalUrl('');
    echo '" />'."\r\n";
}elseif(strstr($PHP_SELF, FILENAME_ADVANCED_SEARCH_RESULT)){

}else{
    if($canonicalURL == 'https://yourfish.ru/index.php'){
        $canonicalURL = str_replace('/index.php','',$canonicalURL);
    }
    echo '<link rel="canonical" href="'.$canonicalURL.'"/>'."\r\n";
}
if(!(isset($_GET['is_mobile']) && !empty($_GET['is_mobile'])) && !IS_MOBILE){
    echo '<link rel="alternate" media="only screen and (max-width: 640px)" href="'.$canonicalURL.'?is_mobile=1">'."\r\n";
}
?>
<?php
if (file_exists(DIR_FS_CATALOG.DIR_WS_INCLUDES.'/opengraph.php')){require_once(DIR_FS_CATALOG.DIR_WS_INCLUDES.'/opengraph.php');}
?>