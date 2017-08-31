<?php
session_start();
require_once '../functions.php';

SessionManager::authenticate($_SESSION, $_POST);

$p = new Page('Login', false);
$p->displayNavless();

if ($_SESSION['login_attempts'])
	echo '<p class="error">Wrong password. Please try again.</p>'; ?>

<!--TODO: vertically align center-->
<div class="container">
    <h1>Login</h1>
    <br>
    <form action="login.php" method="post">
        <div class="form-group row">
            <!-- for horizontal centering -->
            <div class="col-4"></div>
            <div class="col-4">
                <input type="password" name="pw" class="form-control" placeholder="Password" autofocus>
            </div>
        </div>
    </form>
    <h1></h1>
    <h1></h1>
</div>
<footer class="fixed-bottom"><a href="register.php">Don't have an account? Register!</a></footer>

<?php $p->displayFooter();