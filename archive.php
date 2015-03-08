<?php

$login_required = true;
require_once('login_check.php');

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
	
<div id="options">
<div><input type="checkbox" class="opt" id="option_ts" <?php if (isset($current_user['options']) && $current_user['options']['ts'] == true) { ?>checked="checked" <?php } ?>/> show timestamps</div>
<div><input type="checkbox" class="opt" id="option_ut" <?php if (isset($current_user['options']) && $current_user['options']['ut'] == true) { ?>checked="checked" <?php } ?>/> show edit/delete links</div>
<div><input type="checkbox" class="opt" id="option_priv" <?php if (isset($current_user['options']) && $current_user['options']['priv'] == true) { ?>checked="checked" <?php } ?>/> make new posts private by default</div>
<div><a href="/of/links/logout/">logout</a></div>
<div><a href="http://arepository.com/of/links/by/<?php echo $current_user['username']; ?>/">permalink to your public posts</a></div>
</div>

<div id="list">
<?php

require('functions.php');

$links = get_links( array('user_id' => $current_user['user_id']), array('limit' => -1), 'new' );

foreach ($links as $link) {
	echo '<div class="link" id="link-'.$link['id'].'">';
	if (isset($current_user['loggedin']) && $current_user['loggedin'] == true) {
		echo '<span class="utils"';
		if (isset($current_user['options']) && ($current_user['options']['ut'] == null || $current_user['options']['ut'] == false)) {
			echo ' style="display:none"';
		}
		echo '><span data-id="'.$link['id'].'" title="edit!" class="editlink">e</span> / <span data-id="'.$link['id'].'" title="delete!" class="deletelink">d</span></span> ';
	}
	echo '<span class="when"';
	if ((isset($current_user['options']) && $current_user['options']['ts'] == false) || !isset($current_user['loggedin'])) {
		echo ' style="display:none"';
	}
	echo '>'.date('m.d.Y H:i:s', strtotime($link['added'])).'</span>';
	echo ' ';
	echo '<span class="content">';
	echo '<input type="hidden" value="'.$link['privacy'].'" name="privacy" />';
	echo $link['parsed'].'</span>';
	echo '</div>';
	echo "\n";
}

?>
</div>

<?php require_once('templates/foot.php'); ?>
</body>
</html>