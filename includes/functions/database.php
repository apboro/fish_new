<?php
/*
  $Id: database.php,v 1.1.1.1 2003/09/18 19:05:08 wilt Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/
//***VB***
  function tep_db_connect($server = DB_SERVER, $username = DB_SERVER_USERNAME, $password = DB_SERVER_PASSWORD, $database = DB_DATABASE, $link = 'db_link', $use_pconnect = USE_PCONNECT, $new_link = false) {
    global $$link;

    if (USE_PCONNECT == 'true') {
      $server = 'p:' . $server;
    }

    $$link = mysqli_connect($server, $username, $password, $database);

      @mysqli_query($$link, "SET SQL_MODE= ''");
      @mysqli_query($$link, "SET NAMES 'utf8' COLLATE 'utf8_general_ci'");

//***VB***

//Start VaM db-error processing
    if (!$$link) {
      tep_db_error("connect", mysqli_errno($$link), mysqli_error($$link));
    }
//End VaM db-error processing
    return $$link;
  } 
  
  function tep_db_close($link = 'db_link') {
    global $$link;

    return mysqli_close($$link);
  }

//  function tep_db_error($query, $errno, $error) { 
//    die('<font color="#000000"><b>' . $errno . ' - ' . $error . '<br><br>' . $query . '<br><br><small><font color="#ff0000">[TEP STOP]</font></small><br><br></b></font>');
//  }

function tep_db_error($query, $errno, $error) {
// BOF db-error processing
   @include(DIR_WS_LANGUAGES.'russian_db_error.php');
   $msg = "\n" . 'MYSQL QUERY ERROR REPORT' . "\n" . " - " . date("d/m/Y H:m:s",time()) . "\n" . '---------------------------------------' . "\n";
   $msg .= $errno . ' - ' . $error . "\n\n" . $query . "\n";
   $msg .= '---------------------------------------' . "\n";
   $msg .= 'Server Name   : ' . $_SERVER['SERVER_NAME'] . "\n";
   $msg .= 'Remote Address: ' . $_SERVER['REMOTE_ADDR'] . "\n";
   $msg .= 'Referer       : ' . $_SERVER["HTTP_REFERER"] . "\n";
   $msg .= 'Requested     : ' . $_SERVER["REQUEST_URI"] . "\n";
   $msg .= 'Trace Back    : ' . str_replace(DIR_FS_CATALOG, '', str_replace('\\', '/', implode(" => ", zen_trace_back('', 0 , 1, true))))."\n";;
   if(defined('DEBUG') && DEBUG == true) {
			echo(nl2br($msg));
			die('==========================================================================');
	 }
   $log = date("d/m/Y H:m:s",time()) . ' | ' . $errno . ' - ' . $error . ' | ' . $query . ' | ' . $_SERVER["REQUEST_URI"] . "\n";
	 error_log($log, 3, 'mysql_db_error.log');
   /*mail(DB_ERR_MAIL, 'MySQL Error Report!', $msg,
        'From: db_error@'.$_SERVER["SERVER_NAME"]);*/
if (!headers_sent() && file_exists('db_error.html') ) {
    // header('Location: db_error.html');
	header('Location: https://yourfish.ru/results.php?searchid=2542863&text='. $_GET['keywords'] . '&web=0');
     //include('db_error.html');
   }

}

function zen_trace_back($backtrace=false, $from=0, $to=0, $get_call=true) {
	if (!$backtrace)
		$backtrace = debug_backtrace();
	$output = array();
	for ($i=count($backtrace)-1-$from;$i>$to-1;$i--) {
		$args = '';
		if ($get_call && is_array($backtrace[$i]['args'])){
			$args = str_replace("\n", "; ", zen_trace_vardump($backtrace[$i]['args']));
/*
			foreach ($backtrace[$i]['args'] as $a) {
				if (!empty($args))
					$args .= ', ';
				switch (gettype($a)) {
					case 'integer':
					case 'double':
						$args .= $a;
						break;
					case 'string':
						$a = substr($a, 0, 64).((strlen($a) > 64) ? '...' : '');
						$args .= "\"$a\"";
						break;
					case 'array':
						$args .= 'Array('.count($a).')';
						break;
					case 'object':
						$args .= 'Object('.get_class($a).')';
						break;
					case 'resource':
						$args .= 'Resource('.strstr($a, '#').')';
						break;
					case 'boolean':
						$args .= $a ? 'True' : 'False';
						break;
					case 'NULL':
						$args .= 'Null';
						break;
					default:
						$args .= 'Unknown';
				}
			}
*/
		}
		$output[] = $backtrace[$i]['file'].":".$backtrace[$i]['line'] . (($get_call) ? "(".$backtrace[$i]['class'].$backtrace[$i]['type'].$backtrace[$i]['function'].$args.")" : "");
	}
	return $output;
}

	function zen_trace_vardump($var){
		ob_start();
		var_dump($var);
		$out = ob_get_contents();
		ob_end_clean();
		return($out);
	}

// EOF db-error processing


  function tep_db_query($query, $link = 'db_link') {
    global $$link;
    global $query_counts;
    global $query_total_time;
    $query_counts++; 

    if (defined('STORE_DB_TRANSACTIONS') && (STORE_DB_TRANSACTIONS == 'true')) {
      error_log('QUERY ' . $query . "\n", 3, STORE_PAGE_PARSE_TIME_LOG);
    }

     $time_start = explode (' ', microtime());
     $result = @mysqli_query($$link, $query);
     $time_end = explode (' ', microtime());
     $query_time = $time_end[1]+$time_end[0]-$time_start[1]-$time_start[0];
     $query_total_time += $query_time; 

    if (defined('STORE_DB_TRANSACTIONS') && (STORE_DB_TRANSACTIONS == 'true')) {
       $result_error = mysqli_error($$link);
       error_log('RESULT ' . $result . ' ' . $result_error . "\n", 3, STORE_PAGE_PARSE_TIME_LOG);
    }
//Start VaM db-error processing
    if (!$result) {
      @tep_db_error($query, mysqli_errno($$link), mysqli_error($$link));
    }
//End VaM db-error processing
    return @$result;
  }
  
  function tep_db_perform($table, $data, $action = 'insert', $parameters = '', $link = 'db_link') {
    reset($data);
    if ($action == 'insert') {
      $query = 'insert into ' . $table . ' (';
      while (list($columns, ) = each($data)) {
        $query .= $columns . ', ';
      }
      $query = substr($query, 0, -2) . ') values (';
      reset($data);
      while (list(, $value) = each($data)) {
        switch ((string)$value) {
          case 'now()':
            $query .= 'now(), ';
            break;
          case 'null':
            $query .= 'null, ';
            break;
          default:
            $query .= '\'' . tep_db_input($value) . '\', ';
            break;
        }
      }
      $query = substr($query, 0, -2) . ')';
    } elseif ($action == 'update') {
      $query = 'update ' . $table . ' set ';
      while (list($columns, $value) = each($data)) {
        switch ((string)$value) {
          case 'now()':
            $query .= $columns . ' = now(), ';
            break;
          case 'null':
            $query .= $columns .= ' = null, ';
            break;
          default:
            $query .= $columns . ' = \'' . tep_db_input($value) . '\', ';
            break;
        }
      }
      $query = substr($query, 0, -2) . ' where ' . $parameters;
    }

    return tep_db_query($query, $link);
  }

    function tep_db_fetch_array($db_query)
    {
        if(!empty($db_query)) {
            $result = mysqli_fetch_array($db_query, MYSQLI_ASSOC);
        }
        return $result;
    }

  function tep_db_num_rows($db_query) {
    return mysqli_num_rows($db_query);
  }

  function tep_db_data_seek($db_query, $row_number) {
    return mysqli_data_seek($db_query, $row_number);
  }

  function tep_db_insert_id($link = 'db_link') { 
    global $$link;

    return mysqli_insert_id($$link); 
  }

  function tep_db_free_result($db_query) {
    return mysqli_free_result($db_query);
  }

  function tep_db_fetch_fields($db_query) {
    return mysqli_fetch_field($db_query);
  }

  function tep_db_output($string) {
    return htmlspecialchars($string);
  }

  function tep_db_input($string, $link = 'db_link') {
    global $$link;

    return @mysqli_real_escape_string($$link, $string);
  }

  function tep_db_prepare_input($string) {
    if (is_string($string)) {
      return trim(stripslashes($string));
    } elseif (is_array($string)) {
      reset($string);
      while (list($key, $value) = each($string)) {
        $string[$key] = tep_db_prepare_input($value);
      }
      return $string;
    } else {
      return $string;
    }
  }
  
 if ( !function_exists('mysqli_connect') ) {
    define('MYSQLI_ASSOC', MYSQL_ASSOC);

    function mysqli_connect($server, $username, $password, $database) {
      if ( substr($server, 0, 2) == 'p:' ) {
        $link = mysql_pconnect(substr($server, 2), $username, $password);
      } else {
        $link = mysql_connect($server, $username, $password);
      }

      if ( $link ) {
        mysql_select_db($database, $link);
      }

      return $link;
    }

    function mysqli_close($link) {
      return mysql_close($link);
    }

    function mysqli_query($link, $query) {
      return mysql_query($query, $link);
    }

    function mysqli_errno($link) {
      return mysql_errno($link);
    }

    function mysqli_error($link) {
      return mysql_error($link);
    }

    function mysqli_fetch_array($query, $type) {
      return mysql_fetch_array($query, $type);
    }

    function mysqli_num_rows($query) {
      return mysql_num_rows($query);
    }

    function mysqli_data_seek($query, $offset) {
      return mysql_data_seek($query, $offsetr);
    }

    function mysqli_insert_id($link) {
      return mysql_insert_id($link);
    }

    function mysqli_free_result($query) {
      return mysql_free_result($query);
    }

    function mysqli_fetch_field($query) {
      return mysql_fetch_field($query);
    }

    function mysqli_real_escape_string($link, $string) {
      if ( function_exists('mysql_real_escape_string') ) {
        return mysql_real_escape_string($string, $link);
      } elseif ( function_exists('mysql_escape_string') ) {
        return mysql_escape_string($string);
      }

      return addslashes($string);
    }
  }
  
function mysqli_result($res, $row, $field=0) { 
    $res->data_seek($row); 
    $datarow = $res->fetch_array(); 
    return $datarow[$field]; 
} 