<?php
session_start();
require_once '../functions.php';

SessionManager::authenticate($_SESSION, $_POST);

$p = new Page('Login', false);
$p->displayNavless();

if ($_SESSION['login_attempts'])
	echo '<p class="error">Wrong password. Please try again.</p>'; ?>

<h1>Login</h1>
<div class="container">
	<form action="login.php" method="post">
		<div class="form-group row">
			<!-- for horizontal centering -->
			<div class="col-sm-4"></div>
			<div class="col-sm-4">
				<input type="password" name="pw" class="form-control" placeholder="Password">
			</div>
		</div>
	</form>
</div>

<a href="register.php">Don't have an account? Register!</a>

<?php $p->displayFooter();