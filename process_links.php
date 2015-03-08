<?php

// process link stuff

require_once('login_check.php');
require_once('functions.php');

if (!isset($_REQUEST['a']) || trim($_REQUEST['a']) == '') {
	report_error('no action given, dunno what to do');
}

$action = strtolower(trim($_REQUEST['a']));

if ($action == 'n') {
	// save new link for current user
	
	// $_POST['t'] is the text content
	// $_POST['p'] if set is privacy = true
	
	if (!isset($_POST['t']) || trim($_POST['t']) == '') {
		report_error('no text content given, dunno what to do');
	}
	
	$privacy_db = 0; // public by default!
	
	if (isset($_POST['p']) && trim($_POST['p']) != '') {
		$privacy_db = 1;
	}
	
	$content = str_replace(array('<', '>'), array('&lt;', '&gt;'), trim($_POST['t']));
	$content_db = "'".$mysqli->escape_string($content)."'";
	
	$insert_link = $mysqli->query("INSERT INTO thelinks (content, user_id, added, updated, privacy) VALUES ($content_db, ".$current_user['user_id'].", NOW(), NOW(), $privacy_db)");
	if (!$insert_link) {
		report_error('error inserting new link into database: '.$mysqli->error);
	}
	
	header('Location: /of/links/');
	
} else if ($action == 'd') {
		
	if (!isset($_POST['id']) || !is_numeric($_POST['id'])) {
		report_error('no link ID given, dunno what to do');
	}
	
	$link_id = (int) $_POST['id'] * 1;
	
	$delete_query = $mysqli->query("DELETE FROM thelinks WHERE user_id=".$current_user['user_id']." AND id=$link_id");
	
	if (!$delete_query) {
		report_error('error deleting link from database: '.$mysqli->error);
	}
	
	echo 'ok';
	
} else if ($action == 'e') {
	
	//print_r($_REQUEST);
	
	if (!isset($_POST['id']) || trim($_POST['id']) == '') {
		report_error('no link ID given, dunno what to do');
	}
	
	$link_id = (int) $_POST['id'] * 1;
	
	if (!isset($_POST['t']) || trim($_POST['t']) == '') {
		report_error('no text content given, dunno what to do');
	}
	
	$privacy_db = 0; // public by default!
	
	if (isset($_POST['p']) && trim($_POST['p']) != '' && trim($_POST['p']) == '1') {
		$privacy_db = 1;
	}
	
	$content = str_replace(array('<', '>'), array('&lt;', '&gt;'), trim($_POST['t']));
	$content_db = "'".$mysqli->escape_string($content)."'";
	
	$update_link = $mysqli->query("UPDATE thelinks SET content=$content_db, updated=NOW(), privacy=$privacy_db WHERE id=$link_id");
	if (!$update_link) {
		report_error('error updating link in database: '.$mysqli->error);
	}
	
	// return this to the AJAX call
	echo '<input type="hidden" value="'.$privacy_db.'" name="privacy" />';
	echo parseURLs($content);
	
}