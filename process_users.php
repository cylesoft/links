<?php

// process user changes

require_once('login_check.php');
require_once('functions.php');

if (!isset($_REQUEST['a']) || trim($_REQUEST['a']) == '') {
	report_error('no action given, dunno what to do');
}

$action = strtolower(trim($_REQUEST['a']));

if ($action == 'o') {
	// edit an option for a user
	
	$valid_options = array('ts', 'ut', 'priv');
	
	if (!isset($_REQUEST['option']) || trim($_REQUEST['option']) == '' || !in_array(trim($_REQUEST['option']), $valid_options)) {
		report_error('no valid option to edit given, dunno what to do');
	}
	
	if (!isset($_REQUEST['value']) || trim($_REQUEST['value']) == '') {
		report_error('no valid value to edit given, dunno what to do');
	}
	
	$option_name_db = "'".$mysqli->escape_string(trim($_REQUEST['option']))."'";
	$option_value_db = "'".$mysqli->escape_string(trim($_REQUEST['value']))."'";
	
	// check to see if the option for this user already exists
	$check_option = $mysqli->query('SELECT COUNT(id) AS optcount FROM user_options WHERE user_id='.$current_user['user_id'].' AND optname='.$option_name_db);
	if (!$check_option) {
		report_error('database error checking option: ' . $mysqli->error);
	}
	$check_option_result = $check_option->fetch_assoc();
	if ($check_option_result['optcount'] == 1) {
		// update
		$update_option = $mysqli->query('UPDATE user_options SET optvalue='.$option_value_db.' WHERE user_id='.$current_user['user_id'].' AND optname='.$option_name_db);
		if (!$update_option) {
			report_error('database error updating option: ' . $mysqli->error);
		}
	} else {
		// insert
		$insert_option = $mysqli->query('INSERT INTO user_options (user_id, optname, optvalue) VALUES ('.$current_user['user_id'].', '.$option_name_db.', '.$option_value_db.')');
		if (!$insert_option) {
			report_error('database error inserting option: ' . $mysqli->error);
		}
	}
	
	echo 'ok';
	
}