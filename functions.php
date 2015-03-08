<?php

require_once('dbconn_mysql.php');

function report_error($message) {
	header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
	die($message); // replace with log?
}

function prase_links($m) {
	// this is based on ancient code written for mfisn.com by siik
	// need to improve/simplify it sometime
	$link_length_limit = 50;
    $href = $name = html_entity_decode($m[0]);
    if (strpos( $href, '://' ) === false) {
        $href = 'http://' . $href;
    }
    if (strtolower(substr($name, 0, 11)) == 'http://www.') {
    	$name = substr($name, 11);
    } else if (strtolower(substr($name, 0, 7)) == 'http://') {
    	$name = substr($name, 7);
    }
    $endings = array('.com/', '.net/', '.org/', '.me/');
    if (in_array(strtolower(substr($name, -5)), $endings)) {
    	$name = substr($name, 0, -1);
    }
    if(strlen($name) > $link_length_limit) {
        $k = ( $link_length_limit - 3 ) >> 1;
        $name = substr( $name, 0, $k ) . '...' . substr( $name, -$k );
    }
    return sprintf('<a href="%s" title="%s" rel="ext" target="_blank">%s</a>', htmlentities($href), htmlentities($href), htmlentities($name));
}

function parseURLs($text) {
	$reg = '~((?:https?://|www\d*\.)\S+[-\w+&@#/%=\~|])~';
	return preg_replace_callback($reg, 'prase_links', $text);
}

function get_links($filter = array(), $pagination = array(), $sorting = '') {
	global $mysqli;
	
	// will hold eventual results
	$links = array();
	
	// make sure there's a user ID given to filter
	if (!isset($filter['user_id']) || !is_numeric($filter['user_id']) || $filter['user_id'] == 0) {
		return $links;
	}
	
	// sanitize user ID for database
	$filter['user_id'] = (int) $filter['user_id'];
	
	if (isset($filter['public_only']) && $filter['public_only'] == true) {
		$query_public_only = 'AND privacy=0';
	} else {
		$query_public_only = '';
	}
	
	// check for output limit
	if (!isset($pagination['limit']) || !is_numeric($pagination['limit']) || $pagination['limit'] == 0) {
		$query_limit_clause = 'LIMIT 50'; // default limit
	} else if ($pagination['limit'] == -1) {
		$query_limit_clause = ''; // no limit
	} else {
		$query_limit_clause = 'LIMIT '.($pagination['limit'] * 1); // whatever was given
	}
	
	// check for sorting option
	if (trim($sorting) == '' || trim($sorting) == 'new') {
		$query_order_clause = 'added DESC';
	}
	
	// run the query
	$get_links = $mysqli->query('SELECT * FROM thelinks WHERE user_id='.$filter['user_id'].' '.$query_public_only.' ORDER BY '.$query_order_clause.' '.$query_limit_clause);
	
	// make sure there are rows returned
	if ($get_links->num_rows > 0) {
		while ($link = $get_links->fetch_assoc()) {
			$new_link = $link;
			$new_link['parsed'] = parseURLs($link['content']); // parse content for viewing
			$links[] = $new_link;
		}
	}
	return $links;
}
