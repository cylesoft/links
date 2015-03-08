<!doctype html>
<html>
<head>
<?php require_once('templates/head.php'); ?>
</head>
<body>
<?php require_once('templates/header.php'); ?>

<div><h1>sign up</h1></div>

<div class="sign-up">
	<form action="/of/links/register/process/" method="post">
	<table>
	<tr><td>Your Email:</td><td><input tabindex="1" id="start-here" name="e" type="email" placeholder="you@whatever.com" /></td></tr>
	<tr><td>Your Public Username:</td><td><input tabindex="2" name="u" type="text" maxlength="50" placeholder="alphanumeric, please" /></td></tr>
	<tr><td>Your Password:</td><td><input tabindex="3" name="p1" type="password" /></td></tr>
	<tr><td>Your Password:</td><td><input tabindex="4" name="p2" type="password" /></td></tr>
	<tr><td>Invite Code:</td><td><input tabindex="5" name="i" type="password" /></td></tr>
	<tr><td><input tabindex="6" type="submit" value="sign up &raquo;" /></td><td></td></tr>
	</table>
	</form>
</div>

<?php require_once('templates/foot.php'); ?>
</body>
</html>