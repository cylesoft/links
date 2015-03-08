<?php

// links.

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

<?php
if ($current_user['loggedin'] == true) {
	?>
		
	<div id="add">
	<form action="process_links.php" method="post" id="addlink"><input type="hidden" name="a" value="n" />
	<input type="text" class="content_input" name="t" placeholder="add something..." /> <input type="checkbox" id="privpost" name="p" value="1" title="for your eyes only?" <?php if (isset($current_user['options']) && $current_user['options']['priv'] == true) { ?>checked="checked" <?php } ?>/> <input class="submitbtn" type="submit" value="+" />
	</form>
	</div>
	
	<div id="options">
	<div><label><input type="checkbox" class="opt" id="option_ts" <?php if (isset($current_user['options']) && $current_user['options']['ts'] == true) { ?>checked="checked" <?php } ?>/> show timestamps</label></div>
	<div><label><input type="checkbox" class="opt" id="option_ut" <?php if (isset($current_user['options']) && $current_user['options']['ut'] == true) { ?>checked="checked" <?php } ?>/> show edit/delete links</label></div>
	<div><label><input type="checkbox" class="opt" id="option_priv" <?php if (isset($current_user['options']) && $current_user['options']['priv'] == true) { ?>checked="checked" <?php } ?>/> make new posts private by default</label></div>
	<div><a href="/of/links/by/<?php echo $current_user['username']; ?>/">permalink to your public posts</a></div>
	<div><a href="/of/links/logout/">logout</a></div>
	</div>
	
	<div id="list">
	<?php
	
	require('functions.php');
	
	$links = get_links( array('user_id' => $current_user['user_id']), array('limit' => 50), 'new' );
	
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
	<div><a href="archive.php">view all the posts &raquo;</a></div>
	<?php
} else {
	?>
	
	<div><h1>a repository of links</h1></div>
	
	<div><p><a href="/of/links/login/">log in</a> or <a href="/of/links/register/">sign up</a></p></div>
	
	<div>
	<p>we make our own trails across the internet, link by link.</p>
	<p>these trails can act as bibliographies. or adventures. or whatever.</p>
	<p>this is meant to be just link pasting with some neat options.</p>
	<p>this is not meant to be a promotional tool. this is not twitter. anything but.</p>
	<p>check out <a href="/of/links/by/cyle/">my posts</a> as an example</p>
	</div>
	
	<div>
	<p>i built this mostly because</p>
	<ul>
	<li>i can, so why not</li>
	<li>i don't like "sharing" - i like posting</li>
	<li>del.icio.us is dead</li>
	<li>tumblr is too complicated</li>
	<li>facebook is too crowded</li>
	<li>twitter sucks for sharing links</li>
	<li>i don't want anyone selling what links i post</li>
	<li>i need a collection, not a profile</li>
	<li>i read a lot on the web, and i want a way to track it</li>
	<li>i write a lot on the web, and i want a list to cite from</li>
	</ul>
	</div>
	
	<div>
	<p>features, lol</p>
	<ul>
	<li>post some fucking links</li>
	<li>unlimited links per post</li>
	<li>post some text, i don't care</li>
	<li>no dumb url shortening or tracking</li>
	<li>no goddamn character limit</li>
	<li>mark post as private "for your eyes only"</li>
	<li>disable seeing certain options (like timestamps)</li>
	<li>you get a page of your public links</li>
	<li>you get an rss feed, too, holy shit</li>
	</ul>
	</div>
	
	<div>
	<p>features not done yet, fuck you</p>
	<ul>
	<li>following other people? gotta be something better to call it than that</li>
	<li>export all your links as xml or json or plain text</li>
	<li>pagination? haha</li>
	</ul>
	</div>
	
	<div>
	<p>features that'll never happen</p>
	<ul>
	<li>selling anything anyone does here</li>
	<li>a public timeline of random people's bullshit</li>
	<li>a "spotlight" or "featured" section</li>
	<li>tags might never happen, i dunno</li>
	<li>liking. +1-ing. upvoting.</li>
	</ul>
	</div>
	
	<div>
	<p>if you want to use it, cool. if not, that's fine too.</p>
	<p>who made this? i'm <a href="http://cylegage.com/">cyle</a></p>
	</div>
	<?php
}
?>

<?php require_once('templates/foot.php'); ?>
</body>
</html>