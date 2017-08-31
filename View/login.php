<?php
require_once '../functions.php';
session_start();

SessionManager::authenticate($_SESSION, $_POST);

$p = new Page('Login', false);
$p->displayNavless(); ?>

<div class="container">
    <?php
    if ($_SESSION['login_attempts'])
        echo '<p class="error">Wrong password. Please try again.</p>'; ?>
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