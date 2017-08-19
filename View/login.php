<?php
# TODO: navBar at top, return links at the bottom
# TODO: view past entries (for that user) & search them
# TODO: make graph of mood (from point A to B, by default the entire range)
# TODO: Three strikes and you're out
session_start();
require_once '../functions.php';

SessionManager::authenticate($_SESSION, $_POST);

$p = new Page('Login', false);
$p->displayNavless();

if ($_SESSION['login_attempts'])
	echo '<p class="error">Wrong password. Please try again.</p>'; ?>

<h1>Login</h1>
<form action="login.php" method="post">
	<input type="password" name="pw" size="30"/>
</form>
<br />

<a href="register.php">Don't have an account? Register!</a>

<?php $p->displayFooter();