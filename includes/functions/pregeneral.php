<?php
  function usu5_base_filename() {
    // Probably won't get past SCRIPT_NAME unless this is reporting cgi location
    $base = new ArrayIterator( array( 'SCRIPT_NAME', 'PHP_SELF', 'REQUEST_URI', 'ORIG_PATH_INFO', 'HTTP_X_ORIGINAL_URL', 'HTTP_X_REWRITE_URL' ) );
    while ( $base->valid() ) {
      if ( array_key_exists(  $base->current(), $_SERVER ) && !empty(  $_SERVER[$base->current()] ) ) {
        if ( false !== strpos( $_SERVER[$base->current()], '.php' ) ) {
          preg_match( '@[a-z0-9_]+\.php@i', $_SERVER[$base->current()], $matches );
          if ( is_array( $matches ) && ( array_key_exists( 0, $matches ) )
                                    && ( substr( $matches[0], -4, 4 ) == '.php' )
                                    && ( is_readable( $matches[0] ) ) ) {
            return $matches[0];
          } 
        } 
      }
      $base->next();
    }
    // Some odd server set ups return / for SCRIPT_NAME and PHP_SELF when accessed as mysite.com (no index.php) where they usually return /index.php
    if ( ( $_SERVER['SCRIPT_NAME'] == '/' ) || ( $_SERVER['PHP_SELF'] == '/' ) ) {
      return 'index.php';
    }
    // Return the standard RC3 code 
    return ( ( ( strlen( ini_get( 'cgi.fix_pathinfo' ) ) > 0) && ( (bool)ini_get( 'cgi.fix_pathinfo' ) == false ) ) || !isset( $_SERVER['SCRIPT_NAME'] ) ) ? basename( $_SERVER['PHP_SELF'] ) : basename( $_SERVER['SCRIPT_NAME'] );
  } // End function


// BOF: WebMakers.com Added: configuration key value lookup
  function tep_get_configuration_key_value($lookup) {
    $configuration_query_raw= tep_db_query("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key='" . $lookup . "'");
    $configuration_query= tep_db_fetch_array($configuration_query_raw);
    $lookup_value= $configuration_query['configuration_value'];
    if ( !($lookup_value) ) {
      $lookup_value='<font color="FF0000">' . $lookup . '</font>';
    }
    return $lookup_value;
  }
// EOF: WebMakers.com Added: configuration key value lookup

// starts canonical tag function

function CanonicalUrl($only_this)
{
    global $detect_category_link, $_SERVER, $request_type, $canonical_url;
    if ($detect_category_link) {
        $string = HTTP_SERVER . $_SERVER['REDIRECT_URL'];
        $search = '/\&osCsid.[^\&\?]*|\?osCsid.[^\&\?]*|\?sort.[^\&\?]*|\&sort.[^\&\?]*|\?direction.[^\&\?]*|\&direction.[^\&\?]*|\?on_page.[^\&\?]*|\&on_page.[^\&\?]*|\?page=1|\&page=1|\&cat.[^\&\?]*|\&filter_id.[^\&\?]*|\&manufacturers_id.[^\&\?]*|\&params.[^\&\?]*|\?q.[^\&\?]*|\&q.[^\&\?]*|\?price_min.[^\&\?]*|\&price_min.[^\&\?]*|\?price_max.[^\&\?]*|\&price_max.[^\&\?]*|\&vls.[^\&\?]|\?vls.[^\&\?]/'; // searches for the session id in the url
        $replace = ''; // replaces with nothing i.e. deletes
        $ret = preg_replace($search, $replace, $string); // merges the variables and echoing them
        $canonical_url = $ret;
        echo $ret;
        return;
    }
    $cleanup = array('cPath', 'products_id', 'articles_id', 'manufacturers_id');
    foreach ($cleanup as $clean) {
        if (isset($_GET[$clean])) {
            $s = $_GET[$clean];
            $template = '|[^\d_]|';
            switch ($clean) {
//		case 'cPath': $template='|[^\d_]|';break;
                case 'products_id':
                    $template = '|[^\d\{\}]|';
                    break;
                case 'manufacturers_id':
                    $template = '|[^\d]|';
                    break;
                case 'articles_id':
                    $template = '|[^\d]|';
                    break;
            }
            $s = preg_replace($template, '', $s);
            $_GET[$clean] = $s;
        }
    }
    /*---byIHolder---*/
    $file = Usu_Main::i()->getVar('filename');
    if ($file == FILENAME_PRODUCTS_FILTERS) {
        $file = FILENAME_DEFAULT;
    }
    if ((strlen($only_this) > 0) && ($detect_category_link == false)) {
        $ret = Usu_Main::i()->hrefLink($file, $only_this . '=' . $_GET[$only_this], ($request_type == 'SSL') ? 'SSL' : 'NONSSL', true, true);
    } else {
        $string = Usu_Main::i()->hrefLink($file, tep_get_all_get_params(array('sort', 'page', 'amp3Bsort', 'amp3Bpage', 'is_mobile', 'vls', 'vPath', 'srmi', 'srma', 'srrange')), ($request_type == 'SSL') ? 'SSL' : 'NONSSL', true, true);
        /*---byIHolder---*/
        $search = '/\&osCsid.[^\&\?]*|\?osCsid.[^\&\?]*|\?keywords.[^\&\?]*|\?sort.[^\&\?]*|\&sort.[^\&\?]*|\?direction.[^\&\?]*|\&direction.[^\&\?]*|\?on_page.[^\&\?]*|\&on_page.[^\&\?]*|\?page=1|\&page=1|\&cat.[^\&\?]*|\&filter_id.[^\&\?]*|\&manufacturers_id.[^\&\?]*|\&params.[^\&\?]*|\?q.[^\&\?]*|\&q.[^\&\?]*|\?price_min.[^\&\?]*|\&price_min.[^\&\?]*|\?price_max.[^\&\?]*|\&price_max.[^\&\?]*|\&vls.[^\&\?]|\?vls.[^\&\?]/i'; // searches for the session id in the url
        $replace = ''; // replaces with nothing i.e. deletes
        $ret = preg_replace($search, $replace, $string); // merges the variables and echoing them

    }
    if(empty($only_this)){
        $ret = preg_replace('/(.*)\/$/',"$1",HTTP_SERVER . $_SERVER['REDIRECT_URL']);
    }
    $canonical_url = $ret;
    echo $ret;
}

function CorrectBadUrls(){
global $_GET,$_SERVER;
switch($_GET['cPath']){
    case ('products_id'):
	{
	unset($_GET['cPath']);
	if (sizeof($_GET)>0){
	    foreach($_GET as $key=>$value){
		if (preg_match('|([\d]+)|',$key,$arr)){
		    tep_redirect(tep_href_link(FILENAME_PRODUCT_INFO,'products_id='.(int)$arr[1]),301);
		    }
		};
	    }
	tep_redirect(tep_href_link(FILENAME_DEFAULT));
	};
	break;
    }

}

if (!function_exists('CategoryLink')) {
    function CategoryLink()
    {
        global $_SERVER, $PHP_SELF, $SCRIPT_NAME;
        $skip_array = array('products_filter.php');
//return false;
        foreach ($skip_array as $skip) {
            if (trim($PHP_SELF) == trim($skip)) {
                return false;
            }
        }
        $uri = urldecode($_SERVER['REQUEST_URI']);
        $part = explode('?', $uri);
        if (is_array($part)) {
            $uri = $part[0];
        }
        $uri = preg_replace('|^/|', '', $uri);
        $query = tep_db_query('select categories_id as id from categories_description
	where categories_url="' . tep_db_input($uri) . '" and length(categories_url)>0 limit 1');
        if ($query !== false) {
            $data = tep_db_fetch_array($query);
            $rcPath = '';
            if (tep_db_num_rows($query) > 0) {
                $id = $data['id'];
                $ct = array();
                tep_get_parent_categories($ct, $id);
                $rcPath = $id;
                if (sizeof($ct) > 0) {
                    $ct = array_reverse($ct);
                    array_push($ct, $id);
                    $rcPath = implode('_', $ct);
                }
            }
            if (strlen($rcPath) > 0) {
                $_GET['cPath'] = $rcPath;
                $_SERVER['SCRIPT_FILENAME'] = dirname($_SERVER['SCRIPT_FILENAME']) . '/' . FILENAME_DEFAULT;
                $_SERVER['PHP_SELF'] = $_SERVER['SCRIPT_NAME'] = $PHP_SELF = $SCRIPT_NAME = FILENAME_DEFAULT;
                $_SERVER['REQUEST_URI'] = '/' . FILENAME_DEFAULT . '?cPath=' . $rcPath . '&' . $_SERVER['REDIRECT_QUERY_STRING'];
                if (isset($_SERVER['REDIRECT_QUERY_STRING'])) {
                    $params = explode('&', $_SERVER['REDIRECT_QUERY_STRING']);
                    foreach ($params as $param) {
                        $dta = explode('=', $param);
                        if (is_array($dta)) {
                            $_GET[$dta[0]] = $dta[1];
                        }
                    }
                }
                header("Status: 200 OK");
                header("HTTP/1.0 200 OK");
                return true;
            }//--strlen
            else {
                //---if not category catched url
                if (isset($_GET['cPath'])) {
                    $carray = explode('_', $_GET['cPath']);
                    $latest = end($carray);
                    $query = tep_db_query('select categories_id as id,categories_url as url from categories_description
		    where categories_id="' . tep_db_input($latest) . '" limit 1');
                    if (($query !== false) && (tep_db_num_rows($query) > 0)) {
                        $data = tep_db_fetch_array($query);
                        if (!empty($data['url'])) {
                            $full_url = HTTP_SERVER . urlencode($data['url']) . '?' . $_SERVER['REDIRECT_QUERY_STRING'];
                            tep_redirect($full_url);
                            exit;
                        }
                    }
                }
            }//
        }
        return false;
    }
}

function CorrectCPath(){
global $_GET,$request_type;
if (isset($_GET['cPath'])){
    $carray=explode('_',$_GET['cPath']);
    $latest=end($carray);
    $rcPath='';$ct=array();
    tep_get_parent_categories($ct,$latest);
    if (sizeof($ct)>0)
	{
	$ct=array_reverse($ct);array_push($ct,$latest);
        $rcPath=implode('_',$ct);
        if ($_GET['cPath']!=$rcPath){
            $_GET['cPath']=$rcPath;
	    $string=Usu_Main::i()->getVar('filename');
	    $string=Usu_Main::i()->hrefLink($string, tep_get_all_get_params(), ($request_type=='SSL')?'SSL':'NONSSL', true, true);
	    header( 'Location: '.$string, true, 301 );
	    exit;
    	    }
	}
    }
}
if (!function_exists('hex2bin')) {
    function hex2bin($data) {
        static $old;
        if ($old === null) {
            $old = version_compare(PHP_VERSION, '5.2', '<');
        }
        $isobj = false;
        if (is_scalar($data) || (($isobj = is_object($data)) && method_exists($data, '__toString'))) {
            if ($isobj && $old) {
                ob_start();
                echo $data;
                $data = ob_get_clean();
            }
            else {
                $data = (string) $data;
            }
        }
        else {
            trigger_error(__FUNCTION__.'() expects parameter 1 to be string, ' . gettype($data) . ' given', E_USER_WARNING);
            return;//null in this case
        }
        $len = strlen($data);
        if ($len % 2) {
            trigger_error(__FUNCTION__.'(): Hexadecimal input string must have an even length', E_USER_WARNING);
            return false;
        }
        if (strspn($data, '0123456789abcdefABCDEF') != $len) {
            trigger_error(__FUNCTION__.'(): Input string must be hexadecimal string', E_USER_WARNING);
            return false;
        }
        return pack('H*', $data);
    }
}
function CleanupBadSymbols($item){
//----patch by iHolder remove C2A0 symbol from link---
$hex = bin2hex($item);
$_item = str_replace('c2a0', '20', $hex);
//if (strpos($_item,'8093')>0){echo '<p>'.$link_text.'<br>'.$_item.'</p>';}
$_item = str_replace('73e2', '', $_item);
$_item = str_replace('8093', '', $_item);
return hex2bin($_item);
//--endpatch
}
function echoHTTP(){
    if (ENABLE_SSL==true){return 'https://';}else{return 'http://';}
        }

?>