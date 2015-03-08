<?php

// show just this user's links, all of them, why not
// accept $_GET['u']

require('functions.php');

if (!isset($_GET['u']) || trim($_GET['u']) == '') {
	report_error('no user given, dunno what to do, sorry');
}

$username = str_replace('/', '', trim($_GET['u']));

$username_db = "'".$mysqli->escape_string($username)."'";

// find user ID

$get_user = $mysqli->query("SELECT user_id FROM users WHERE username=$username_db");
if (!$get_user) {
	report_error('database error getting user info: '.$mysqli->error);
} else if ($get_user->num_rows == 0) {
	report_error('no user found with that name, sorry');
}

$user_row = $get_user->fetch_assoc();
$user_id = $user_row['user_id'];

?><!doctype html>
<html>
<!--
	 _ _       _        
	| (_)     | |       
	| |_ _ __ | | _____ 
	| | | '_ \| |/ / __|
	| | | | | |   <\__ \
	|_|_|_| |_|_|\_\___/
	                    
-->
<head>
<?php require_once('templates/head.php'); ?>
</head>
<body>
<?php require_once('templates/header.php'); ?>

<div><h1>links posted by <?php echo $username; ?></h1></div>

<div><a href="/of/links/by/<?php echo $username; ?>/rss/">here's a link to this as a public rss feed</a></div>

<div id="list">
<?php

$links = get_links( array('user_id' => $user_id, 'public_only' => true), array('limit' => -1), 'new' );

foreach ($links as $link) {
	echo '<div class="link">';
	echo '<span class="when"';
	echo '>'.date('m.d.Y H:i:s', strtotime($link['added'])).'</span>';
	echo ' ';
	echo '<span class="content">'.$link['parsed'].'</span>';
	echo '</div>';
	echo "\n";
}

?>
</div>

<?php require_once('templates/foot.php'); ?>
</body>
</html>