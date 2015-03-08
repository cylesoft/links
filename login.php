<?php

// login page if they are not already logged in
require_once('login_check.php');

// otherwise, wtf? 
if (isset($current_user) && isset($current_user['loggedin']) && $current_user['loggedin'] == true) {
	header('Location: /of/links/');
	die();
}

?><!doctype html>
<html>
<head>
<?php require_once('templates/head.php'); ?>
</head>
<body>
<?php require_once('templates/header.php'); ?>

<div><h1>log in</h1></div>

<div>
	<form action="/of/links/login/" method="post">
	<p><input tabindex="1" name="e" type="email" placeholder="you@whatever.com" /></p>
	<p><input tabindex="2" name="p" type="password" /></p>
	<p><input tabindex="3" type="submit" class="small" value="log in &raquo;" /></p>
	</form>
</div>

</div>
<?php require_once('templates/foot.php'); ?>
</body>
</html>