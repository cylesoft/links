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
	<p>We make our own trails across the internet, link by link.</p>
	<p>These trails can act as bibliographies, or adventures, or whatever.</p>
	<p>This is meant to be just link pasting with some neat options.</p>
	<p>This is not meant to be a promotional tool. This is not twitter; anything but.</p>
	<p>Check out <a href="/of/links/by/cyle/">my links</a> as an example.</p>
	</div>
	
	<div>
	<p>I built this mostly because...</p>
	<ul>
	<li>I can, so why not.</li>
	<li>I don't like "sharing" - I like posting.</li>
	<li>del.icio.us is dead.</li>
	<li>tumblr is too complicated.</li>
	<li>Facebook is too crowded.</li>
	<li>Twitter sucks for sharing links.</li>
	<li>Apple's "Reading List" is a joke.</li>
	<li>I don't want anyone selling what links I post.</li>
	<li>I need a collection, not a profile.</li>
	<li>I read a lot on the web, and I want a way to keep track of it.</li>
	<li>I write a lot on the web, and I want a list to cite from.</li>
	</ul>
	</div>
	
	<div>
	<p>Features, lol</p>
	<ul>
	<li>Post some fucking links.</li>
	<li>Unlimited links per post.</li>
	<li>Post some text, I don't care.</li>
	<li>No dumb url shortening or tracking.</li>
	<li>No goddamn character limit.</li>
	<li>Mark post as private "for your eyes only".</li>
	<li>Disable seeing certain options (like timestamps).</li>
	<li>You get a page of your public links.</li>
	<li>You get an RSS feed, too, holy shit.</li>
	</ul>
	</div>
	
	<div>
	<p>Features not done yet, fuck you, be patient</p>
	<ul>
	<li>Following other people? Gotta be something better to call it than that.</li>
	<li>Export all your links as JSON or plain text.</li>
	<li>Pagination? haha, I have over 1000 links.</li>
	</ul>
	</div>
	
	<div>
	<p>Features that'll never happen:</p>
	<ul>
	<li>Selling anything anyone does here.</li>
	<li>A public timeline of random people's bullshit.</li>
	<li>A "spotlight" or "featured" section.</li>
	<li>Tags might never happen, I dunno.</li>
	<li>Liking. +1-ing. Upvoting. No.</li>
	</ul>
	</div>
	
	<div>
	<p>If you want to use it, cool. If not, that's fine too.</p>
	<p>Who made this? I'm <a href="http://cylegage.com/">cyle</a></p>
	<p>I'm hesitant to give you an invite code unless I know you. The source code is <a href="https://github.com/cylesoft/links">here</a>.</p>
	</div>
	<?php
}
?>

<?php require_once('templates/foot.php'); ?>
</body>
</html>