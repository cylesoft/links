<?php

// show RSS feed for user's public links
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
$links = get_links( array('user_id' => $user_id), array('limit' => 25), 'new' );

header('Content-type: text/xml');

echo '<?xml version="1.0" encoding="UTF-8" ?>'."\n";

?><rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
<channel>
<title><?php echo $username; ?>'s links</title>
<description>not much complicated about this</description>
<link>http://arepository.com/of/links/by/<?php echo $username; ?>/</link>
<lastBuildDate><?php echo date('r', strtotime($links[0]['added'])); ?></lastBuildDate>
<pubDate><?php echo date('r', strtotime($links[0]['added'])); ?></pubDate>
<atom:link href="<?php echo 'http://arepository.com/of/links/by/'.$username.'/rss'; ?>" rel="self" type="application/rss+xml" />
<?php
foreach ($links as $link) {
	echo '<item>'."\n";
	echo '<title>link</title>'."\n";
	echo '<description>'.htmlspecialchars($link['parsed']).'</description>'."\n";
	echo '<link>http://arepository.com/of/links/by/'.$username.'</link>'."\n";
	echo '<guid>http://arepository.com/of/links/by/'.$username.'/'.$link['id'].'</guid>'."\n";
	echo '<pubDate>'.date('r', strtotime($link['added'])).'</pubDate>'."\n";
	echo '</item>'."\n";
}
?>
</channel>
</rss>