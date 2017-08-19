<?php
# TODO: navBar at top, return links at the bottom
# TODO: view past entries (for that user) & search them
# TODO: make graph of mood (from point A to B, by default the entire range)
session_start();
require_once '../functions.php';

if (!isset($_SESSION['valid_user']) || !$_SESSION['valid_user'])
	$_SESSION['valid_user'] = AccountManager::check_password($_POST);

if (!isset($_SESSION['login_attempts']) || $_SESSION['valid_user'])
	$_SESSION['login_attempts'] = 0;
else
	$_SESSION['login_attempts']++;

$p = $_SESSION['valid_user'] ? new Page('Journal') : new Page('Login');
if ($_SESSION['valid_user']) $p->loggedIn = true;

$p->displayHeader();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Journal</title>
</head>
<body>
<?php
if ($_SESSION['valid_user']) { ?>
	<h1>Diary/Mood Entry for <?= htmlspecialchars($_SESSION['valid_user']) ?></h1>
	<form action="insert.php" method="post">
		<p class="instruction">Entry type:</p>
		<input type="radio" name="type" value="Diary" checked>Diary<br />
		<input type="radio" name="type" value="Mood">Mood
		
		<p class="instruction">Enter corresponding text:</p>
		<textarea name="input" rows="10" cols="50"></textarea>
		
		<p class="input"><input type="submit" value="Submit"/></p>
	</form>
<?php } else {
	if ($_SESSION['login_attempts'])
		echo '<p class="error">Wrong password. Please try again.</p>';
	else
		echo '<p class="notice">You are not logged in.</p>' ?>
	<h1>Login</h1>
	<!--TODO: send data over HTTPS & SSL-->
	<form action="login.php" method="post">
		<input type="password" name="pw" size="30"/>
	</form>
<?php }
$p->displayFooter();